@extends('network::layouts.master')

@push('js')
    <script src="{{ asset('assets/js/plugins/gojs/go.js') }}" type="text/javascript"></script>
    <script>
        (function () {
            var diagramHeight = $('#main-container').height() - $('#page-header').height();

            $('#tree').height(diagramHeight)

            function init() {
                var $ = go.GraphObject.make;

                myDiagram = $(go.Diagram, "tree", {
                    maxSelectionCount: 0,
                    scale: 1,
                    contentAlignment: go.Spot.Center,
                    layout: $(go.TreeLayout, {
                        angle: 90,
                    })
                });

                function textStyle() {
                    return { font: "9pt  Segoe UI,sans-serif", stroke: "white" };
                }

                function userAvatar(avatar) {
                    return "{{ asset('assets/media/avatars/avatar10.jpg') }}";
                    //return "images/HS" + pic;
                }

                myDiagram.nodeTemplate =
                $(go.Node, "Spot",
                    {
                        selectionObjectName: "BODY",
                    },
                    new go.Binding("text", "nickname"),
                    new go.Binding("layerName", "isSelected", sel => sel ? "Foreground" : "").ofObject(),
                    $(go.Panel, "Auto",
                        { name: "BODY" },
                        $(go.Shape, "Rectangle", {
                            name: "SHAPE",
                            height: 72,
                            width: 218,
                            fill: "#fff",
                            stroke: '#ddd',
                            strokeWidth: 2,
                            portId: ""
                        }),
                        $(go.Panel, "Horizontal",
                            $(go.Picture,
                            {
                                name: "Picture",
                                desiredSize: new go.Size(70, 70),
                                visible: false,
                                margin: 1.5,
                                source: "{{ asset('assets/media/avatars/avatar10.jpg') }}"
                            },
                            new go.Binding("visible", "empty", function(t) { return !t; }),
                            new go.Binding("source", "avatar", userAvatar)),
                            $(go.Panel, "Table",
                                {
                                    minSize: new go.Size(130, NaN),
                                    maxSize: new go.Size(150, NaN),
                                    margin: new go.Margin(6, 10, 0, 6),
                                    defaultAlignment: go.Spot.Left
                                },
                                $(go.RowColumnDefinition, { column: 2, width: 4 }),
                                $(go.TextBlock, textStyle(),
                                    {
                                        name: "NAMETB",
                                        row: 0,
                                        column: 0,
                                        columnSpan: 5,
                                        stroke: "#333",
                                        font: "12pt Segoe UI,sans-serif",
                                        isMultiline: false,
                                        minSize: new go.Size(50, 16),
                                        alignment: go.Spot.Center,
                                    },
                                    new go.Binding("text", "nickname").makeTwoWay(),
                                    new go.Binding("alignment", "sponsor_nickname", function(t) { if (t) { return go.Spot.Left } })
                                ),
                                $(go.TextBlock, "Ранг: ", textStyle(),
                                    {
                                        row: 1,
                                        column: 0,
                                        stroke: "#333",
                                        visible: false,
                                    },
                                    new go.Binding("visible", "sponsor_nickname", function(t) { return !!t; })
                                ),
                                $(go.TextBlock, textStyle(),
                                    {
                                        row: 1,
                                        column: 1,
                                        columnSpan: 4,
                                        stroke: "#333",
                                        visible: false,
                                        isMultiline: false,
                                        minSize: new go.Size(50, 14),
                                        margin: new go.Margin(0, 0, 0, 3)
                                    },
                                    new go.Binding("text", "rank").makeTwoWay(),
                                    new go.Binding("visible", "sponsor_nickname", function(t) { return !!t; })
                                ),
                                $(go.TextBlock, "Спонсор: ", textStyle(),
                                    {
                                        row: 2,
                                        column: 0,
                                        stroke: "#333",
                                        visible: false,
                                    },
                                    new go.Binding("visible", "sponsor_nickname", function(t) { return !!t; })
                                ),
                                $(go.TextBlock, textStyle(),
                                    {
                                        row: 2,
                                        column: 1,
                                        columnSpan: 4,
                                        stroke: "#333",
                                        visible: false,
                                        isMultiline: false,
                                        minSize: new go.Size(50, 14),
                                        margin: new go.Margin(0, 0, 0, 3)
                                    },
                                    new go.Binding("text", "sponsor_nickname").makeTwoWay(),
                                    new go.Binding("visible", "sponsor_nickname", function(t) { return !!t; })
                                ),
                                
                            ) // End Table Panel
                        ) // End Horizontal Panel
                    ), // End Auto Panel
                );

                myDiagram.linkTemplate =
                    $(go.Link,
                        go.Link.Orthogonal,
                        {
                            corner: 0,
                        },
                        $(go.Shape, {
                            strokeWidth: 1,
                            stroke: "#0090ff"
                        }
                    ));

                load();
            }

            function load() {
                myDiagram.model = go.Model.fromJson('{!! $binary_tree !!}');
            }

            window.addEventListener('DOMContentLoaded', init);
        })();
    </script>
@endpush

@section('content')
    <div class="container-fluid pt-2">
        <div id="tree" style="width:100%;"></div>
    </div>
@endsection

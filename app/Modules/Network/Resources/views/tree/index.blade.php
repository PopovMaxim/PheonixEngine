@extends('network::layouts.master')

@push('js')
    <script src="{{ asset('assets/js/plugins/gojs/go.js') }}" type="text/javascript"></script>
    <script>
        (function () {
            var diagramHeight = $('#main-container').height();

            $('#tree').height(diagramHeight)

            function init() {
                var $ = go.GraphObject.make;

                myDiagram = $(go.Diagram, "tree", {
                    maxSelectionCount: 0,
                    scale: 1,
                    contentAlignment: go.Spot.TopCenter,
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

                myDiagram.addDiagramListener("InitialLayoutCompleted", function(e) {
                    //e.diagram.findTreeRoots().each(function(r) { r.expandTree(3); });
                })

                myDiagram.nodeTemplate =
                $(go.Node, "Spot",
                    {
                        selectionObjectName: "BODY",
                        isTreeExpanded: true
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
                        }, new go.Binding("fill", "isHighlighted", h => h ? "gold" : "#ffffff").ofObject()),
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
                                $(go.TextBlock, "????????: ", textStyle(),
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
                                $(go.TextBlock, "??????????????: ", textStyle(),
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
                        ),
                        $("TreeExpanderButton",
                        {
                            "ButtonIcon.stroke": "transparent",
                            "ButtonIcon.strokeWidth": "100",
                            "ButtonBorder.fill": "transparent",
                            "ButtonBorder.stroke": "transparent",
                            "_buttonFillOver": "transparent",
                            "_buttonFillPressed": "transparent",
                            "_buttonBorderPressed": "transparent",
                            "_buttonStrokeOver": "transparent"
                        },
                        { alignment: go.Spot.BottomRight, alignmentFocus: go.Spot.Top },
                        { visible: true }
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
                myDiagram.model = go.Model.fromJson('{!! $binary['tree'] !!}');
            }

            function searchDiagram() {
                var input = document.getElementById("search");
                if (!input) return;
                myDiagram.focus();

                myDiagram.startTransaction("highlight search");

                if (input.value) {
                    // search four different data properties for the string, any of which may match for success
                    // create a case insensitive RegExp from what the user typed
                    var safe = input.value.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
                    var regex = new RegExp(safe, "i");
                    var results = myDiagram.findNodesByExample({ nickname: regex });
                    myDiagram.highlightCollection(results);
                    // try to center the diagram at the first node that was found
                    if (results.count > 0) myDiagram.centerRect(results.first().actualBounds);
                } else {  // empty string only clears highlighteds collection
                    myDiagram.clearHighlighteds();
                }

                myDiagram.commitTransaction("highlight search");
            }

            $('#searchButton').on('click', () => searchDiagram())

            window.addEventListener('DOMContentLoaded', init);
        })();
    </script>
@endpush

@section('content')
    <div class="bg-body-extra-light text-center">
        <div class="content content-boxed content-full py-5">
            <div class="row justify-content-center">
                <div class="col-md-10 col-xl-6">
                    <h1 class="h2 mb-2">
                        ???????????????? ????????????
                    </h1>
                    <p class="fs-lg fw-normal text-muted">
                        ?????????????????? ?????????? ?????????????????????? ????????
                    </p>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-sm-10 col-lg-8 col-xl-6">
                    <div class="p-2 rounded bg-body-light shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <label class="visually-hidden" for="search">?????????? ????????????????...</label>
                                <input type="text" class="form-control form-control-lg form-control-alt" id="search" name="search" placeholder="?????????? ????????????????...">
                            </div>
                            <div class="flex-grow-0 ms-2">
                                <button id="searchButton" class="btn btn-lg btn-primary">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center align-items-center mt-5">
                <div class="px-2 px-sm-5">
                    <p class="fs-3 text-dark mb-0">{{ $binary['total_left_leg_value'] }}</p>
                    <p class="text-muted mb-0">
                        ?????????? ?????????? ????????
                    </p>
                </div>
                <div class="px-2 px-sm-5 border-start">
                    <p class="fs-3 text-dark mb-0">{{ $binary['total_right_leg_value'] }}</p>
                    <p class="text-muted mb-0">
                        ?????????? ???????????? ????????
                    </p>
                </div>
                <div class="px-2 px-sm-5 border-start">
                    <p class="fs-3 text-dark mb-0">{{ $binary['total_value'] }}</p>
                    <p class="text-muted mb-0">
                        ?????????? ???????? ????????
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid pt-2">
        <div id="tree" style="width:100%;"></div>
    </div>
@endsection

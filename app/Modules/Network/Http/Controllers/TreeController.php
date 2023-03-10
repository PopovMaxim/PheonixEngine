<?php

namespace App\Modules\Network\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TreeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $binary = $this->makeBinaryTree($request);

        return view('network::tree.index')
            ->with([
                'binary' => $binary
            ]);
    }

    public function makeBinaryTree(Request $request) {
        $user = $request->user();

        $node = \DB::select("SELECT id FROM binary_tree WHERE user_id = '{$user['id']}'");

        if ($node) {
            $structure_id = $node[0]->id;

            $tree = \DB::table('binary_tree as s')
                ->select([
                    's.id as id',
                    'u.nickname as nickname',
                    'u2.nickname as sponsor_nickname',
                    'u.id as user_id',
                    'u.sponsor_id as sponsor_id',
                    's.sponsor_id as parent',
                    's.left as left',
                    's.right as right',
                    's.path as path',
                    's.side as side',
                    's.total_value as total_value'
                ])
                ->leftJoin('users as u', 'u.id', '=', 's.user_id')
                ->leftJoin('users as u2', 'u2.id', '=', 'u.sponsor_id')
                ->where('s.path', 'LIKE', "%-$structure_id%")
                ->orderBy('s.id', 'ASC')
                ->get();

            $_tree = [];

            foreach ($tree as $v) {
                $_tree[$v->id] = (array) $v;
            }

            $res = [];
            $left = [];
            $queue = [];

            $top = $_tree[$structure_id];
            $queue[] = $_tree[$structure_id];
            $start_top = $_tree[$structure_id];

            while ($queue) {
                $top = current($queue);

                if (!is_null($top['left']) && $top['left'] > 0) {
                    $queue[] = $_tree[$top['left']];
                }
                
                if (!is_null($top['right']) && $top['right'] > 0) {
                    $queue[] = $_tree[$top['right']];
                }

                $res[] = &$_tree[$top['id']];

                array_shift($queue);
            }

            $raw_array = [];

            $total_value = 0;
            $total_left_leg_value = 0;
            $total_right_leg_value = 0;

            foreach ($res as $row) {
                if (!$row['parent'] || $row['user_id'] == $user['id']) continue;
                
                if ($row['side'] == 'right') {
                    $raw_array[$row['parent']]['left']['parent'] = $row['parent'];
                    
                    $raw_array[$row['parent']]['right']['id'] = $row['id'];
                    $raw_array[$row['parent']]['right']['user_id'] = $row['user_id'];
                    $raw_array[$row['parent']]['right']['parent'] = $row['parent'];
                    $raw_array[$row['parent']]['right']['nickname'] = $row['nickname'];
                    $raw_array[$row['parent']]['right']['sponsor_nickname'] = $row['sponsor_nickname'];

                    $total_right_leg_value += $row['total_value'];
                } else {
                    $raw_array[$row['parent']]['left']['id'] = $row['id'];
                    $raw_array[$row['parent']]['left']['user_id'] = $row['user_id'];
                    $raw_array[$row['parent']]['left']['parent'] = $row['parent'];
                    $raw_array[$row['parent']]['left']['nickname'] = $row['nickname'];
                    $raw_array[$row['parent']]['left']['sponsor_nickname'] = $row['sponsor_nickname'];

                    $raw_array[$row['parent']]['right']['parent'] = $row['parent'];

                    $total_left_leg_value += $row['total_value'];
                }

                $total_value += $row['total_value'] ?? 0;
            }

            $total_value = number_format($total_value / 100, 2);
            $total_left_leg_value = number_format($total_left_leg_value / 100, 2);
            $total_right_leg_value = number_format($total_right_leg_value / 100, 2);

            $nickname = $user['nickname'];
            $sponsor_nickname = $user['sponsor']['nickname'] ?? '??????';

            $node_data = '{"class":"go.TreeModel","nodeDataArray":[';

            $_r = '{"key":'.$structure_id.', "nickname":"'.$nickname.'", "empty": false},';

            foreach ($raw_array as $row)
            {
                foreach ($row as $item)
                {
                    if (isset($item['id']))
                    {
                        $_r .= '{"key":'.$item['id'].',"parent":'.$item['parent'].', "nickname":"'.$item['nickname'].'", "sponsor_nickname":"'.$item['sponsor_nickname'].'", "empty": false, "rank": "??????"},';
                    } else {
                        $_r .= '{"parent":'.$item['parent'].', "nickname":"?????? ????????????????", "empty": true},';
                    }
                }             
            }

            $node_data .= rtrim($_r, ',');
            $node_data .= ']}';

            return [
                'tree' => $node_data,
                'total_value' => $total_value,
                'total_left_leg_value' => $total_left_leg_value,
                'total_right_leg_value' => $total_right_leg_value,
            ];
        } else {
            return json_encode([]);
        }
    }
}

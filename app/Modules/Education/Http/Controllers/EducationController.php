<?php

namespace App\Modules\Education\Http\Controllers;

use Iman\Streamer\VideoStreamer;
use App\Modules\Tariffs\Entities\TariffLines;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class EducationController extends Controller
{
    public $videos = [
        1 => [
            [
                'path' => '06.mp4',
                'closed' => true,
                'number' => '01',
                'title' => 'Функционал панели',
                'description' => 'В этом обучающем видео ролике Вы узнаете о функционале панели программы Insider 1.61.',
                'time' => '18:35',
            ],
            [
                'path' => '03.mp4',
                'closed' => true,
                'number' => '02',
                'title' => 'Настройки панели',
                'description' => 'В этом обучающем видео ролике Вы узнаете как настраивать панель программы Insider 1.61.',
                'time' => '7:42',
            ],
            [
                'path' => '04.mp4',
                'closed' => true,
                'number' => '03',
                'title' => 'Торговая стратегия: Хождение за энергией',
                'description' => 'В этом обучающем видео ролике Вы узнаете о торговой стратегии для программы Insider 1.61 и что такое хождение за энергией.',
                'time' => '26:34',
            ],
            [
                'path' => '01.mp4',
                'closed' => true,
                'number' => '04',
                'title' => 'Детали основной стратегии',
                'description' => 'В этом обучающем видео ролике Вы узнаете о деталях основной стратегии торговли с помощью программы Insider 1.61.',
                'time' => '9:51',
            ],
            [
                'path' => '02.mp4',
                'closed' => true,
                'number' => '05',
                'title' => 'Зона спроса и предложения',
                'description' => 'В этом обучающем видео ролике Вы узнаете что такое зоны спроса и предложения, а также как их использовать в сочетании с программой Insider 1.61.',
                'time' => '15:41',
            ],
            [
                'path' => '05.mp4',
                'closed' => true,
                'number' => '06',
                'title' => 'Торговля с программой',
                'description' => 'В этом обучающем видео ролике Вы узнаете как осуществлять торговые операции с программой Insider 1.61.',
                'time' => '37:23',
            ],
        ]
    ];

    public function index($id = null)
    {
        $line = TariffLines::query()->where('id', $id)->where('details->status', 1)->orderBy('order', 'asc')->firstOrFail();

        $breadcrumbs = [
            [
                'title' => 'Обучение',
                'url' => route('education', ['id' => $id])
            ],
            [
                'title' => $line['title'],
                'active' => true
            ],
        ];

        $user_id = request()->user()->id;

        foreach ($this->videos[$id] as $key => $video) {
            if (!$key) {
                $this->videos[$id][$key]['closed'] = false;
            }

            $next_key = $key-1;

            $path = "users/{$user_id}/education/{$id}/{$next_key}.json";

            if (Storage::exists($path)) {
                $this->videos[$id][$key]['closed'] = false;
            }
        }

        return view('education::index')
            ->with([
                'id' => $id,
                'videos' => $this->videos[$id],
                'breadcrumbs' => $breadcrumbs
            ]);
    }

    public function read($id, $number)
    {
        $line = TariffLines::query()->where('id', $id)->where('details->status', 1)->orderBy('order', 'asc')->firstOrFail();

        $user_id = request()->user()->id;

        foreach ($this->videos[$id] as $key => $video) {
            if (!$key) {
                $this->videos[$id][$key]['closed'] = false;
            }

            $next_key = $key-1;

            $path = "users/{$user_id}/education/{$id}/{$next_key}.json";

            if (Storage::exists($path)) {
                $this->videos[$id][$key]['closed'] = false;
            }
        }

        $video = $this->videos[$id][$number];

        if ($video['closed']) {
            return redirect()
                ->route('education', ['id' => $id]);
        }
        
        $breadcrumbs = [
            [
                'title' => 'Обучение',
                'url' => route('education', ['id' => $line['id']])
            ],
            [
                'title' => $line['title'],
                'url' => route('education', ['id' => $line['id']])
            ],
            [
                'title' => $video['title'],
                'active' => true
            ],
        ];

        $prev = $number - 1;
        $next = $number + 1;

        if ($prev < 0) {
            $prev = 0;
        }

        if ($next >= count($this->videos[$id]) - 1) {
            $next = count($this->videos[$id]) - 1;
        }

        $disabled_prev = false;
        $disabled_next = false;

        if ($number == $prev || $this->videos[$id][$prev]['closed']) {
            $disabled_prev = true;
        }

        if ($number == $next || $this->videos[$id][$next]['closed']) {
            $disabled_next = true;
        }

        return view('education::read')
            ->with([
                'id' => $id,
                'number' => $number,
                'breadcrumbs' => $breadcrumbs,
                'video' => $video,
                'prev' => $prev,
                'next' => $next,
                'disabled_prev' => $disabled_prev,
                'disabled_next' => $disabled_next,
            ]);
    }
    
    public function video($id, $number)
    {
        $line = TariffLines::query()->where('id', $id)->where('details->status', 1)->orderBy('order', 'asc')->firstOrFail();

        $video = $this->videos[$id][$number] ?? null;
        
        $path = public_path("education/videos/{$id}/{$video['path']}");

        VideoStreamer::streamFile($path);
    }

    public function videoCompleted($id, $number)
    {
        $user_id = request()->user()->id;

        $path = "users/{$user_id}/education/{$id}/{$number}.json";

        if (!file_exists(storage_path($path))) {
            Storage::put($path, json_encode([
                'date' => now()
            ]));
        }
    }
}

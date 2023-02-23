<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

use App\Service\News as ServiceNews;

//新聞
class News extends Controller
{
    public $serviceNews;

    public function __construct(ServiceNews $serviceNews)
    {
        $this->serviceNews = $serviceNews;
    }

    //取得新聞
    public function get($newsId)
    {
        $data = $this->serviceNews->get($newsId);

        if (!$data) {
            $responseDatas =  [
                'messages' => ['取得新聞錯誤'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'messages' => ['取得新聞成功'],
            'datas' => $data,
        ];

        $response = response()->json($responseDatas, 200);

        return $response;
    }

    //取得新聞列表
    public function getList()
    {
        $page = request()->get('page', 1);
        $title = request()->get('title', '');

        $datas = $this->serviceNews->getList($page, $title);

        if (!$datas && $datas !== []) {
            $responseDatas =  [
                'messages' => ['取得新聞列表錯誤'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'messages' => ['取得新聞列表成功'],
            'datas' => $datas,
        ];

        $response = response()->json($responseDatas, 200);

        return $response;
    }
}

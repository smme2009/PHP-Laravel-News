<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Service\News as ServiceNews;

//新聞管理
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

    //新增新聞
    public function create()
    {
        $data = $this->setData();

        $validator = $this->serviceNews->getValidator($data);

        if ($validator->fails()) {
            $responseDatas =  [
                'messages' => $validator->errors()->all(),
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $check = $this->serviceNews->create($data);

        if (!$check) {
            $responseDatas =  [
                'messages' => ['新增新聞失敗'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'messages' => ['新增新聞成功'],
        ];

        $response = response()->json($responseDatas, 201);

        return $response;
    }

    //更新新聞
    public function update($newsId)
    {
        $data = $this->setData();

        $validator = $this->serviceNews->getValidator($data);

        if ($validator->fails()) {
            $responseDatas =  [
                'messages' => $validator->errors()->all(),
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $check = $this->serviceNews->update($newsId, $data);

        if (!$check) {
            $responseDatas =  [
                'messages' => ['更新新聞失敗'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'messages' => ['更新新聞成功'],
        ];

        $response = response()->json($responseDatas, 200);

        return $response;
    }

    //刪除新聞
    public function delete($newsId)
    {
        $check = $this->serviceNews->delete($newsId);

        if (!$check) {
            $responseDatas =  [
                'messages' => ['刪除新聞失敗'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'messages' => ['刪除新聞成功'],
        ];

        $response = response()->json($responseDatas, 200);

        return $response;
    }

    //設定資料
    private function setData()
    {
        $data = new \stdClass();

        $data->title = request()->get('title', '');
        $data->content = request()->get('content', '');
        $data->imageId = request()->get('imageId', '');
        $data->showTime = request()->get('showTime', '');
        $data->hideTime = request()->get('hideTime', '');
        $data->status = request()->get('status', '');

        return $data;
    }
}

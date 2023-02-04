<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Service\Storage as ServiceStorage;

//檔案上傳
class Storage extends Controller
{
    public $serviceStorage;

    public function __construct(ServiceStorage $serviceStorage)
    {
        $this->serviceStorage = $serviceStorage;
    }

    //上傳圖片
    public function uploadImage()
    {
        $image = request()->file('image');

        $validator = $this->serviceStorage->getImageValidator($image);

        if ($validator->fails()) {
            $responseDatas =  [
                'messages' => $validator->errors()->all(),
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $storageId = $this->serviceStorage->uploadImage($image);

        if (!$storageId) {
            $responseDatas =  [
                'messages' => ['上傳圖片失敗'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'storageId' => $storageId,
            'messages' => ['上傳圖片成功'],
        ];

        $response = response()->json($responseDatas, 201);

        return $response;
    }
}

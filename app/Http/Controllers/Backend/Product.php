<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Service\Product as ServiceProduct;

//商品管理
class Product extends Controller
{
    public $serviceProduct;

    public function __construct(ServiceProduct $serviceProduct)
    {
        $this->serviceProduct = $serviceProduct;
    }

    //取得商品
    public function get($productId)
    {
        $datas = $this->serviceProduct->get($productId);

        if (!$datas) {
            $responseDatas =  [
                'messages' => ['取得商品錯誤'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'messages' => ['取得商品成功'],
            'datas' => $datas,
        ];

        $response = response()->json($responseDatas, 200);

        return $response;
    }

    //取得商品列表
    public function getList()
    {
        $page = request()->get('page', 1);
        $name = request()->get('name', '');

        $datas = $this->serviceProduct->getList($page, $name);

        if (!$datas) {
            $responseDatas =  [
                'messages' => ['取得商品列表錯誤'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'messages' => ['取得商品列表成功'],
            'datas' => $datas,
        ];

        $response = response()->json($responseDatas, 200);

        return $response;
    }

    //新增商品
    public function create()
    {
        $name = request()->get('name', '');
        $price = request()->get('price', '');
        $quantity = request()->get('quantity', '');
        $storageId = request()->get('storageId', '');

        $validator = $this->serviceProduct->getValidator($name, $price, $quantity, $storageId);

        if ($validator->fails()) {
            $responseDatas =  [
                'messages' => $validator->errors()->all(),
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $check = $this->serviceProduct->create($name, $price, $quantity, $storageId);

        if (!$check) {
            $responseDatas =  [
                'messages' => ['新增商品失敗'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'messages' => ['新增商品成功'],
        ];

        $response = response()->json($responseDatas, 201);

        return $response;
    }

    //更新商品
    public function update($productId)
    {
        $name = request()->get('name', '');
        $price = request()->get('price', '');
        $quantity = request()->get('quantity', '');
        $storageId = request()->get('storageId', '');

        $validator = $this->serviceProduct->getValidator($name, $price, $quantity, $storageId);

        if ($validator->fails()) {
            $responseDatas =  [
                'messages' => $validator->errors()->all(),
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $check = $this->serviceProduct->update($productId, $name, $price, $quantity, $storageId);

        if (!$check) {
            $responseDatas =  [
                'messages' => ['更新商品失敗'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'messages' => ['更新商品成功'],
        ];

        $response = response()->json($responseDatas, 200);

        return $response;
    }

    //刪除商品
    public function delete($productId)
    {
        $check = $this->serviceProduct->delete($productId);

        if (!$check) {
            $responseDatas =  [
                'messages' => ['刪除商品失敗'],
            ];

            $response = response()->json($responseDatas, 400);

            return $response;
        }

        $responseDatas =  [
            'messages' => ['刪除商品成功'],
        ];

        $response = response()->json($responseDatas, 200);

        return $response;
    }
}

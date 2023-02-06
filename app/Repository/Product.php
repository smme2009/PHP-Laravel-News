<?php

namespace App\Repository;

use Illuminate\Support\Facades\Storage;

use App\Model\Product as ModelProduct;

//商品管理
class Product
{
    public $model;

    //新增商品
    public function create($name, $price, $quantity, $storageId)
    {
        $this->model = new ModelProduct();

        $check = $this->setModel($name, $price, $quantity, $storageId);

        if (!$check) {
            return false;
        }

        $productId = $this->model->product_id;

        return $productId;
    }

    //讀取單一商品
    public function read($productId)
    {
        $this->model = ModelProduct::with('storage')
            ->find($productId);

        if (!$this->model) {
            return false;
        }

        $datas = $this->setData();

        return $datas;
    }

    //讀取商品列表
    public function readList($page, $name)
    {
        $skip = $page - 1;

        $modelList = ModelProduct::with('storage')
            ->when($name != null, function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })
            ->skip($skip)
            ->take(10)
            ->get();

        if ($modelList->isEmpty()) {
            return false;
        }

        $dataList = [];
        foreach ($modelList as $model) {
            $this->model = $model;
            $dataList[] = $this->setData();
        }

        return $dataList;
    }

    //更新商品
    public function update($productId, $name, $price, $quantity, $storageId)
    {
        $this->model = ModelProduct::find($productId);

        if (!$this->model) {
            return false;
        }

        $check = $this->setModel($name, $price, $quantity, $storageId);

        return $check;
    }

    //刪除商品
    public function delete($productId)
    {
        $this->model = ModelProduct::find($productId);

        if (!$this->model) {
            return false;
        }

        $check = $this->model->delete();

        return $check;
    }

    //設定商品模型
    private function setModel($name, $price, $quantity, $storageId)
    {
        $this->model->name = $name;
        $this->model->price = $price;
        $this->model->quantity = $quantity;
        $this->model->storage_id = $storageId;

        $check = $this->model->save();

        return $check;
    }

    //設定商品資料
    private function setData()
    {
        $datas = [
            'productId' => $this->model->product_id,
            'name' => $this->model->name,
            'price' => $this->model->price,
            'quantity' => $this->model->quantity,
            'storageId' => $this->model->file_id,
            'storageUrl' => Storage::url($this->model->storage->path),
            'createTime' => $this->model->created_time,
            'updatedTime' => $this->model->updated_time,
            'deletedTime' => $this->model->deleted_time,
        ];

        return $datas;
    }
}

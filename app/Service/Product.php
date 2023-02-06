<?php

namespace App\Service;

use App\Repository\Product as RepositoryProduct;

//商品管理
class Product
{
    public $repositoryProduct;

    public function __construct(RepositoryProduct $repositoryProduct)
    {
        $this->repositoryProduct = $repositoryProduct;
    }

    //取得商品資料
    public function get($productId)
    {
        $productDatas = $this->repositoryProduct->read($productId);

        return $productDatas;
    }

    //取得商品列表
    public function getList($page, $name)
    {
        $productList = $this->repositoryProduct->readList($page, $name);

        return $productList;
    }

    //新增商品資料
    public function create($name, $price, $quantity, $storageId)
    {
        $check = $this->repositoryProduct->create($name, $price, $quantity, $storageId);

        return $check;
    }

    //更新商品資料
    public function update($productId, $name, $price, $quantity, $storageId)
    {
        $check = $this->repositoryProduct->update($productId, $name, $price, $quantity, $storageId);

        return $check;
    }

    //刪除商品資料
    public function delete($productId)
    {
        $check = $this->repositoryProduct->delete($productId);

        return $check;
    }

    //驗證資料格式
    public function getValidator($name, $price, $quantity, $storageId)
    {
        $validator = validator()->make(
            [
                'productName' => $name,
                'productPrice' => $price,
                'productQuantity' => $quantity,
                'productStorageId' => $storageId,
            ],
            [
                'productName' => ['required', 'string'],
                'productPrice' => ['required', 'integer'],
                'productQuantity' => ['required', 'integer'],
                'productStorageId' => ['required', 'integer', 'exists:storage,storage_id'],
            ],
        );

        return $validator;
    }
}

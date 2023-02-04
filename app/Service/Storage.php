<?php

namespace App\Service;

use App\Repository\Storage as RepositoryStorage;

//檔案上傳
class Storage
{
    public $repositoryStorage;

    public function __construct(RepositoryStorage $repositoryStorage)
    {
        $this->repositoryStorage = $repositoryStorage;
    }

    //上傳圖片
    public function uploadImage($image)
    {
        $path = $image->store('image');

        if (!$path) {
            return false;
        }

        $fullName = $image->getClientOriginalName();

        $name = pathinfo($fullName, PATHINFO_FILENAME);
        $extension = pathinfo($fullName, PATHINFO_EXTENSION);

        $storageId = $this->repositoryStorage->create($name, $extension, $path);

        return $storageId;
    }

    //驗證圖片資料
    public function getImageValidator($image)
    {
        $validator = validator()->make(
            [
                'image' => $image,
            ],
            [
                'image' => ['required', 'image', 'max:5120'],
            ],
        );

        return $validator;
    }
}

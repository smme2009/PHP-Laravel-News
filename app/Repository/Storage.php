<?php

namespace App\Repository;

use App\Model\Storage as ModelStorage;

//檔案上傳
class Storage
{
    public function create($name, $extension, $path)
    {
        $model = new ModelStorage();

        $model->name = $name;
        $model->extension = $extension;
        $model->path = $path;

        $model->save();

        $storageId = $model->storage_id;

        return $storageId;
    }
}

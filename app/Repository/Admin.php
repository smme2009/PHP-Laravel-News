<?php

namespace App\Repository;

use App\Model\Admin as ModelAdmin;

//後台管理員
class Admin
{
    //讀取單一帳號資料
    public function readAccount($account)
    {
        $model = ModelAdmin::where('account', $account)->first();

        if (!$model) {
            return false;
        }

        $datas = [
            'adminId' => $model->admin_id,
            'account' => $model->account,
            'name' => $model->name,
            'password' => $model->password,
            'createTime' => $model->create_time,
            'updatedTime' => $model->updated_time,
            'deletedTime' => $model->deleted_time,
        ];

        return $datas;
    }
}

<?php

namespace App\Kernel;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends LaravelModel
{
    //啟用軟刪除
    use SoftDeletes;

    //時間欄位使用UNIX Timestamp儲存 
    protected $dateFormat = 'U';

    //調整時間欄位名稱
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    const DELETED_AT = 'deleted_time';

    //調整時間欄位使用UNIX Timestamp輸出
    protected $casts = [
        'created_time' => 'timestamp',
        'updated_time' => 'timestamp',
        'deleted_time' => 'timestamp',
    ];
}

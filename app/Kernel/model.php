<?php

namespace App\Kernel;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends LaravelModel
{
    //啟用軟刪除
    use SoftDeletes;

    //時間戳使用UNIX Timestamp 
    protected $dateFormat = 'U';

    //調整時間戳相關欄位名稱
    const CREATED_AT = 'created_time';
    const UPDATED_AT = 'updated_time';
    const DELETED_AT = 'deleted_time';
}

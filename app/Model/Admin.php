<?php

namespace App\Model;

use App\Kernel\Model;

//後台管理員
class Admin extends Model
{
    protected $table = 'admin';

    protected $primaryKey = 'admin_id';
}

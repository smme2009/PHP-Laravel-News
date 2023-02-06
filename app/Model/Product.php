<?php

namespace App\Model;

use App\Kernel\Model;

//商品
class Product extends Model
{
    protected $table = 'product';

    protected $primaryKey = 'product_id';

    public function storage()
    {
        return $this->hasOne(__NAMESPACE__ . '\Storage', 'storage_id', 'storage_id');
    }
}

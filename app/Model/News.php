<?php

namespace App\Model;

use App\Kernel\Model;

//新聞
class News extends Model
{
    protected $table = 'news';

    protected $primaryKey = 'news_id';

    public function image()
    {
        return $this->hasOne(__NAMESPACE__ . '\Storage', 'storage_id', 'image_id');
    }
}

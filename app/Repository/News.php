<?php

namespace App\Repository;

use Illuminate\Support\Facades\Storage;

use App\Model\News as ModelNews;

//新聞
class News
{
    //新增新聞
    public function create($datas)
    {
        $model = new ModelNews();

        $check = $this->setModel($model, $datas);

        if (!$check) {
            return false;
        }

        $newsId = $model->news_id;

        return $newsId;
    }

    //讀取單一新聞
    public function read($newsId, $admin)
    {
        $query = ModelNews::with('image');

        if (!$admin) {
            $query = $this->setCondition($query);
        }

        $model = $query->find($newsId);

        if (!$model) {
            return false;
        }

        $datas = $this->setData($model, $admin);

        return $datas;
    }

    //讀取新聞列表
    public function readList($page, $title, $admin)
    {
        $skip = $page - 1;

        $query = ModelNews::with('image')
            ->when($title != null, function ($query) use ($title) {
                $query->where('title', 'like', '%' . $title . '%');
            })
            ->skip($skip)
            ->take(10);

        if (!$admin) {
            $query = $this->setCondition($query);
        }

        $modelList = $query->get();

        if ($modelList->isEmpty()) {
            return false;
        }

        $dataList = [];
        foreach ($modelList as $model) {
            $dataList[] = $this->setData($model, $admin);
        }

        return $dataList;
    }

    //更新新聞
    public function update($newsId, $datas)
    {
        $model = ModelNews::find($newsId);

        if (!$model) {
            return false;
        }

        $check = $this->setModel($model, $datas);

        return $check;
    }

    //刪除新聞
    public function delete($newsId)
    {
        $model = ModelNews::find($newsId);

        if (!$model) {
            return false;
        }

        $check = $model->delete();

        return $check;
    }

    //設定新聞模型
    private function setModel($model, $datas)
    {
        $model->title = $datas->title;
        $model->content = $datas->content;
        $model->image_id = $datas->imageId;
        $model->show_time = strtotime($datas->showTime);
        $model->hide_time = strtotime($datas->hideTime);
        $model->status = $datas->status;

        $check = $model->save();

        return $check;
    }

    //設定新聞資料
    private function setData($model, $admin)
    {
        $data = new \stdClass();

        $data->newId = $model->news_id;
        $data->title = $model->title;
        $data->content = $model->content;
        $data->imgUrl = Storage::url($model->image->path);

        if (!$admin) {
            $data->imageId = $model->image_id;
            $data->showTime = date('Y-m-d H:i:s', $model->show_time);
            $data->hideTime = date('Y-m-d H:i:s', $model->hide_time);
            $data->status = $model->status;
        }

        return $data;
    }

    //設定條件
    private function setCondition($query)
    {
        $time = time();

        $query->where(function ($query) use ($time) {
            $query->where('show_time', '<=', $time)
                ->orWhere('show_time', 0);
        });

        $query->where(function ($query) use ($time) {
            $query->where('hide_time', '>=', $time)
                ->orWhere('hide_time', 0);
        });

        $query->where('status', 1);

        return $query;
    }
}

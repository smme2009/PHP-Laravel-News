<?php

namespace App\Repository;

use Illuminate\Support\Facades\Storage;

use App\Model\News as ModelNews;

//新聞管理
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
    public function read($newsId)
    {
        $model = ModelNews::with('image')
            ->find($newsId);

        if (!$model) {
            return false;
        }

        $datas = $this->setData($model);

        return $datas;
    }

    //讀取新聞列表
    public function readList($page, $title)
    {
        $skip = $page - 1;

        $modelList = ModelNews::with('image')
            ->when($title != null, function ($query) use ($title) {
                $query->where('title', 'like', '%' . $title . '%');
            })
            ->skip($skip)
            ->take(10)
            ->get();

        if ($modelList->isEmpty()) {
            return false;
        }

        $dataList = [];
        foreach ($modelList as $model) {
            $dataList[] = $this->setData($model);
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
    private function setData($model)
    {
        $data = new \stdClass();

        $data->newId = $model->news_id;
        $data->title = $model->title;
        $data->content = $model->content;
        $data->imageId = $model->image_id;
        $data->showTime = date('Y-m-d H:i:s', $model->show_time);
        $data->hideTime = date('Y-m-d H:i:s', $model->hide_time);
        $data->status = $model->status;
        $data->imgUrl = Storage::url($model->image->path);

        return $data;
    }
}

<?php

namespace App\Service;

use App\Repository\News as RepositoryNews;

//新聞管理
class News
{
    public $repositoryNews;

    public function __construct(RepositoryNews $repositoryNews)
    {
        $this->repositoryNews = $repositoryNews;
    }

    //取得新聞資料
    public function get($newsId)
    {
        $newsDatas = $this->repositoryNews->read($newsId);

        return $newsDatas;
    }

    //取得新聞列表
    public function getList($page, $title)
    {
        $newsList = $this->repositoryNews->readList($page, $title);

        return $newsList;
    }

    //新增新聞資料
    public function create($data)
    {
        $check = $this->repositoryNews->create($data);

        return $check;
    }

    //更新新聞資料
    public function update($newsId, $data)
    {
        $check = $this->repositoryNews->update($newsId, $data);

        return $check;
    }

    //刪除新聞資料
    public function delete($newsId)
    {
        $check = $this->repositoryNews->delete($newsId);

        return $check;
    }

    //驗證資料格式
    public function getValidator($data)
    {
        $validator = validator()->make(
            [
                'newsTitle' => $data->title,
                'newsContent' => $data->content,
                'newsImageId' => $data->imageId,
                'newsShowTime' => $data->showTime,
                'newsHideTime' => $data->hideTime,
                'status' => $data->status,
            ],
            [
                'newsTitle' => ['required', 'string'],
                'newsContent' => ['required', 'string'],
                'newsImageId' => ['required', 'integer', 'exists:storage,storage_id'],
                'newsShowTime' => ['required', 'date_format:Y-m-d H:i:s'],
                'newsHideTime' => ['required', 'date_format:Y-m-d H:i:s'],
                'status' => ['required', 'boolean'],
            ],
        );

        return $validator;
    }
}

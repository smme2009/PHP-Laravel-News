<?php

namespace App\Service;

use Illuminate\Support\Facades\Hash;

use App\Repository\Admin as RepositoryAdmin;
use App\Tool\Jwt as ToolJwt;

//後台管理員
class Admin
{
    public $repositoryAdmin = null;

    public function __construct(RepositoryAdmin $repositoryAdmin)
    {
        $this->repositoryAdmin = $repositoryAdmin;
    }

    //取得帳號資料
    public function getAccount($account)
    {
        $accountDatas = $this->repositoryAdmin->readAccount($account);

        return $accountDatas;
    }

    //確認密碼
    public function checkPassword($password, $oldPassword)
    {
        $check = Hash::check($password, $oldPassword);

        return $check;
    }

    //取得Jwt Token
    public function getJwtToken($adminId)
    {
        $jwtTokenDatas = [
            'adminId' => $adminId,
        ];

        $jwtToken = ToolJwt::encode($jwtTokenDatas);

        return $jwtToken;
    }
}

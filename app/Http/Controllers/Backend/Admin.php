<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;

use App\Service\Admin as ServiceAdmin;

//後台管理員
class Admin extends Controller
{
    //登入
    public function login(ServiceAdmin $serviceAdmin)
    {
        $request = request()->all();

        $account = $request['account'];
        $password = $request['password'];

        $accountDatas = $serviceAdmin->getAccount($account);

        if (!$accountDatas) {
            $responseDatas =  [
                'messages' => ['登入失敗，帳號錯誤'],
            ];

            $response = response()->json($responseDatas, 401);

            return $response;
        }

        $check = $serviceAdmin->checkPassword($password, $accountDatas['password']);

        if (!$check) {
            $responseDatas =  [
                'messages' => ['登入失敗，密碼錯誤'],
            ];

            $response = response()->json($responseDatas, 401);

            return $response;
        }

        $jwtToken = $serviceAdmin->getJwtToken($accountDatas['adminId']);

        $responseDatas =  [
            'messages' => ['登入成功'],
            'datas' => [
                'jwtToken' => $jwtToken,
            ]
        ];

        $response = response()->json($responseDatas, 200);

        return $response;
    }
}

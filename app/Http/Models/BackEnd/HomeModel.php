<?php
namespace App\Http\Models\BackEnd;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class HomeModel{

    /**
     * 修改用户
     * @param $uid
     * @param $userName
     * @param $userPwd
     * @param $imageUrl
     * @param $email
     * @return array
     */
    public function changeUser($uid, $userName, $userPwd, $imageUrl, $email) {
        $data = [
            'username'  =>  $userName,
            'imgurl'    =>  $imageUrl,
            'email'     =>  $email
        ];

        if (!empty($userPwd)) {
            $data['password'] = Hash::make($userPwd);
        }
        $iCnt = DB::table('sc_admins')->where('uid', $uid)->update($data);
        $userObj = DB::table('sc_admins')->where('uid', $uid)->first();
        Session::put('USER_LOGIN_INFO', (array)$userObj);

        if ($iCnt) {
            return [
                'code'  =>  0,
                'msg'   =>  '修改成功'
            ];
        } else {
            return [
                'code'  =>  1,
                'msg'   =>  '修改失败'
            ];
        }
    }

    /**
     * 获取首页基础信息
     * @return array
     */
    public function getHomeBaseInfo() {
        $articleNum = DB::table('sc_articles')->count();
        $liuyanNum = DB::table('sc_comments')->count();
        $wyNum = DB::table('sc_weiyu')->count();
        $linkNum = DB::table('sc_links')->count();

        $systemInfo = $this->getSystemInfo();

        $relData = [
            'articleNum'    =>  $articleNum,
            'liuyanNum'     =>  $liuyanNum,
            'wyNum'         =>  $wyNum,
            'linkNum'       =>  $linkNum
        ];

        $relData = $relData + $systemInfo;
        return $relData;
    }

    protected function getSystemInfo() {
        $serverUri = env('APP_URL', 'http://blog.scarecrow.top');
        $systemType = php_uname('s');

        if (PHP_SAPI == 'fpm-fcgi') {
            $runHj = 'php-fpm';
        }

        if (PHP_SAPI == 'cgi-fcgi') {
            $runHj = 'fastcgi';
        }

        if (PHP_SAPI == 'apache2handler') {
            $runHj = 'Apache';
        }

        if (PHP_SAPI == 'cli') {
            $runHj = 'CLI';
        }

        $phpVersion = PHP_VERSION;
        $mysqlVersionObj = DB::select('SELECT VERSION() as v');
        $mysqlVersion = $mysqlVersionObj[0]->v ?? '数据库连接失败';
        return [
            'serverUri'     =>  $serverUri,
            'systemType'    =>  $systemType,
            'runHj'         =>  $runHj,
            'phpVersion'    =>  $phpVersion,
            'mysqlVersion'  =>  $mysqlVersion,
            'appVersion'    =>  env('APP_VERSION', 'V1.0')
        ];
    }
}
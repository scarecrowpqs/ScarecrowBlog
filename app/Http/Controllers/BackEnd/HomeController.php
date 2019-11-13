<?php
namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\HomeModel;
use Illuminate\Http\Request;
use function Scarecrow\getLoginUserInfo;

class HomeController extends Controller
{
    /**
     * 主页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $m = new HomeModel();
        $relData = $m->getHomeBaseInfo();
        return view('backend.home', [
            'baseInfo'  =>  $relData
        ]);
    }

    /**
     * 显示改变用户信息页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showChangeUserInfoPage() {
        $uid = getLoginUserInfo('uid', 1);
        $userInfo = getLoginUserInfo();
        return view('backend.user.userinfo', [
            'uid'       =>  $uid,
            'userInfo'  =>  $userInfo
        ]);
    }

    /**
     * 改变用户信息接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeUserInfo(Request $request) {
        $userName = $request->input('userName', '');
        $userPwd = $request->input('userPwd', '');
        $imageUrl = $request->input('imageUrl', '');
        $email = $request->input('email', '');
        $uid = (int)$request->input('uid', 1);

        $m = new HomeModel();
        $relData = $m->changeUser($uid, $userName, $userPwd, $imageUrl, $email);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }
}
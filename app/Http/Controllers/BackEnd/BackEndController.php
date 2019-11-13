<?php
namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\BackEndModel;
use App\Http\Models\BackEnd\LoginModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use function Scarecrow\checkLogin;

class BackEndController extends Controller
{
    /**
     * 登陆页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loginPage() {
        if (checkLogin()) {
            return redirect('/back/index');
        }
        return view("backend.login");
    }

    /**
     * 登陆接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request) {
        $userName = $request->input('userName', '');
        $userPassword = $request->input('userPassword', '');

        $m = new LoginModel();
        $relData = $m->login($userName, $userPassword);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

    /**
     * 注销用户
     * @return \Illuminate\Http\JsonResponse
     */
    public function loginOut() {
        LoginModel::loginOut();
        return response()->json([
            'status'    =>  'YES',
            'info'      =>  '注销成功'
        ]);
    }

    /**
     * 首页
     * @return string
     */
    public function index() {
        return view('backend.index');
    }

    /**
     * 获取菜单列表
     * @return \Illuminate\Http\JsonResponse
     */
    public function getMenuList() {
        $m = new LoginModel();
        $menuList = $m->getMenuList();
        return response()->json([
            'status'    =>  'YES',
            'info'      =>  '',
            'data'      =>  $menuList
        ]);
    }
}
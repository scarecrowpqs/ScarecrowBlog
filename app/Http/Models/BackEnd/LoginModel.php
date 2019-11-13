<?php
namespace App\Http\Models\BackEnd;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginModel {
    /**
     * 登陆接口
     * @param $userName
     * @param $userPassword
     * @return array
     */
    public static function login($userName, $userPassword) {
        $obj = DB::table('sc_admins')->where('username', $userName)->first();
        if ($obj) {
            if (Hash::check($userPassword, $obj->password)) {
                Session::put('USER_LOGIN_INFO', (array)$obj);
                return [
                    'code'  =>  0,
                    'msg'   =>  '登陆成功'
                ];
            }
        }
        return [
            'code'  =>  1,
            'msg'   =>  '登录失败'
        ];
    }

    /**
     * 检测是否登陆
     * @return bool
     */
    public static function check() {
        if(empty(Session::get('USER_LOGIN_INFO', []))) {
            return false;
        }
        return true;
    }

    /**
     * 获取用户信息
     * @return mixed
     */
    public static function getUserInfo() {
        return Session::get('USER_LOGIN_INFO', []);
    }

    /**
     * 注销登陆
     * @return array
     */
    public static function loginOut() {
        Session::flush();
        return [
            'code'  =>  0,
            'msg'   =>  '注销成功'
        ];
    }

    /**
     * 获取菜单列表
     * @return array
     */
    public function getMenuList() {
        $list = [];
        //我的
        $this->addMenuListItem($list, "", ['name'=>'文章设置', 'icon'=>'&#xe6bf;','href'=>'','child'=>[]]);
        $this->addMenuListItem($list, "文章设置", ['name'=>'发布文章', 'icon'=>'&#xe6fc;','href'=>asset("back/article/add")]);
        $this->addMenuListItem($list, "文章设置", ['name'=>'文章管理', 'icon'=>'&#xe6fc;','href'=>asset("back/article/index")]);

        $this->addMenuListItem($list, "", ['name'=>'微语设置', 'icon'=>'&#xe6e9;','href'=>'','child'=>[]]);
        $this->addMenuListItem($list, "微语设置", ['name'=>'发布微语', 'icon'=>'&#xe842;','href'=>asset("back/weiyu/add")]);
        $this->addMenuListItem($list, "微语设置", ['name'=>'微语管理', 'icon'=>'&#xe842;','href'=>asset("back/weiyu/index")]);

        $this->addMenuListItem($list, "", ['name'=>'友链设置', 'icon'=>'&#xe6f5;','href'=>'','child'=>[]]);
        $this->addMenuListItem($list, "友链设置", ['name'=>'添加友链', 'icon'=>'&#xe6b8;','href'=>asset("back/frendlink/add")]);
        $this->addMenuListItem($list, "友链设置", ['name'=>'友链管理', 'icon'=>'&#xe6b8;','href'=>asset("back/frendlink/index")]);

        $this->addMenuListItem($list, "", ['name'=>'留言设置', 'icon'=>'&#xe842;','href'=>'','child'=>[]]);
        $this->addMenuListItem($list, "留言设置", ['name'=>'留言管理', 'icon'=>'&#xe749;','href'=>asset("back/msg/index")]);
        $this->addMenuListItem($list, "留言设置", ['name'=>'用户管理', 'icon'=>'&#xe749;','href'=>asset("back/msg/user")]);

        $this->addMenuListItem($list, "", ['name'=>'音乐设置', 'icon'=>'&#xe696;','href'=>'','child'=>[]]);
        $this->addMenuListItem($list, "音乐设置", ['name'=>'音乐添加', 'icon'=>'&#xe756;','href'=>asset("back/music/add")]);
        $this->addMenuListItem($list, "音乐设置", ['name'=>'音乐管理', 'icon'=>'&#xe756;','href'=>asset("back/music/index")]);

        return $list;
    }

    /**
     * 给菜单列表添加一项
     * @param array $list
     * @param $k 每层之间用"."分隔开
     * @param $item
     * @return array
     */
    private function addMenuListItem(array &$list, $k, array $item)
    {
        $k = trim($k, ".");
        if (empty($k)) {
            $list[] = $item;
            return true;
        }

        $kList = explode(".", $k);
        $data = &$list;
        foreach ($kList as $items) {
            $bool = false;
            foreach ($data as &$i) {
                if($i['name'] === $items) {
                    if (!isset($i['child'])) {
                        return false;
                    }
                    $data = &$i['child'];
                    $bool = true;
                    break;
                }
            }
            if (!$bool) {
                return false;
            }
        }
        $data[] = $item;
        return true;
    }
}
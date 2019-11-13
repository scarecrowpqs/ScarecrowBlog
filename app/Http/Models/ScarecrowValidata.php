<?php
namespace App\Http\Models;

class ScarecrowValidata {
    /**
     * 验证邮箱
     * User: fc
     * Date: 2018/5/8
     * Time: 1:11
     * @param $email
     * @return bool
     */
    public function email($email)
    {
        if (preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $email)) {
            return $email;
        }
        return false;
    }

    /**
     * 验证url
     * User: fc
     * Date: 2018/5/8
     * Time: 1:13
     * @param $url
     * @return bool
     */
    public function url($url)
    {
        if (preg_match("/^(http|ftp|https|ftps):\/\/([a-z0-9\-_]+\.)/i", $url)) {
            return $url;
        }
        return false;
    }

    /**
     * 过滤一下评论内容
     * @param $text
     * @return string
     */
    public function comment($text)
    {
        return  trim(strip_tags($text));
    }

    /**
     * 验证用户名
     * @param $username
     * @return bool|string
     */
    public function username($username)
    {
        $name = trim(strip_tags($username));
        //去掉空格和html标签

        if (preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $name)) {
            return false;
        }
        $len = mb_strlen($name, 'utf-8');
        //小于1不及格
        if ($len <= 1) {
            return false;
        }

        //大于12不及格
        if ($len > 12) {
            return false;
        }
        return $name;
    }

    /**
     * 验证密码
     * @param $userpwd
     * @return bool
     */
    public function userpwd($userpwd)
    {
        $name = trim(strip_tags($userpwd));
        //去掉空格和html标签

        //小于6不及格
        if (!isset($userpwd[6])) {
            return false;
        }

        //大于20,记得住吗？
        if (isset($userpwd[21])) {
            return false;
        }

        return $userpwd;
    }
}
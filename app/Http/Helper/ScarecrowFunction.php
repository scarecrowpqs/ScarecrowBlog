<?php
namespace Scarecrow;
use App\Http\Models\BackEnd\LoginModel;
use App\Mail\replyDiscussMsg;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;

/**
 * 判断request是否是pjax请求
 * @return bool
 */
function requestIsPjax() {
    $resquestObj = request();
    $type = $resquestObj->header('X-PJAX', '');
    if ($type === 'true') {
        return true;
    } else {
        return false;
    }
}

/**
 * 不同的时间，打个招呼
 * @return string
 */
function showGreet()
{
    $hour = date('H');
    if ($hour <= 7 && $hour >= 0) {
        return 'shuijiao.gif';
    } else if ($hour <= 8 && $hour >= 7) {
        return 'baobao.gif';
    } else if ($hour <= 11 && $hour >= 8) {
        return 'buyao.gif';
    } else if ($hour <= 13 && $hour >= 11) {
        return 'chifang.gif';
    } else if ($hour <= 18 && $hour >= 13) {
        return 'zhandou.gif';
    } else if ($hour <= 20 && $hour >= 18) {
        return 'weishi.gif';
    } else if ($hour <= 22 && $hour >= 20) {
        return 'wanshua.gif';
    } else if ($hour <= 23 && $hour >= 22) {
        return 'maimeng.gif';
    } else {
        return 'baobao.gif';
    }
}

/**
 * 分割字符串
 * @param $str
 * @param int $start
 * @param $length
 * @param string $charset
 * @param string $suffix
 * @return string
 */
function substrText($str, $start = 0, $length, $charset = "utf-8", $suffix = ".....")
{
    $str = strip_tags($str);
    if (function_exists("mb_substr")) {
        return mb_substr($str, $start, $length, $charset) . $suffix;
    } elseif (function_exists('iconv_substr')) {
        return iconv_substr($str, $start, $length, $charset) . $suffix;
    }
    $re['utf-8']  = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
    $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
    $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
    $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("", array_slice($match[0], $start, $length));
    return $slice . $suffix;
}

/**
 * 时间转换
 * @param $time
 * @return false|string
 */
function wordTime($time)
{
    $time = (int)substr($time, 0, 10);
    $int  = time() - $time;
    if ($int <= 2) {
        $str = sprintf('刚刚', $int);
    } elseif ($int < 60) {
        $str = sprintf('%d秒前', $int);
    } elseif ($int < 3600) {
        $str = sprintf('%d分钟前', floor($int / 60));
    } elseif ($int < 86400) {
        $str = sprintf('%d小时前', floor($int / 3600));
    } elseif ($int < 2592000) {
        $str = sprintf('%d天前', floor($int / 86400));
    } else {
        $str = date('Y-m-d H:i:s', $time);
    }
    return $str;
}

/**
 * 打印字段
 * @param $data
 */
function printData($data) {
    if (is_array($data)) {
        echo json_encode($data, 256);
    } else {
        var_dump($data);
    }
}

/**
 * 获取用户信息
 * @param string $val
 * @return array|bool|null|string
 */
function getUserInfo($val = '')
{
    if (empty($val)) return false;
    return Cookie::get($val);
}

/**
 * 获取gravatar邮箱地址
 */
function GetGravatar($email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array())
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    if ($img) {
        $url = '<img src="' . $url . '"';
        foreach ($atts as $key => $val) {
            $url .= ' ' . $key . '="' . $val . '"';
        }
        $url .= ' />';
    }
    return $url;
}

/**
 * 获取QQ头像地址
 * @param $qq
 * @return array
 */
function GetQQNick($qq){
    $url = "http://q2.qlogo.cn/headimg_dl?bs={$qq}&dst_uin={$qq}&dst_uin={$qq}&dst_uin={$qq}&spec=100&url_enc=0&referer=bu_interface&term_type=PC";
    return $url;
}

/**
 * 从邮箱中提取QQ
 * @param $email
 * @return string
 */
function getEamilToQq($email) {
    $rex = '/^(\d+)@qq.com/';
    $all = [];
    preg_match_all($rex, $email, $all);
    return $all[1][0] ?? '';
}

/**
 * 根据EMAIL获取头像
 * @param $email
 * @return array|string
 */
function getEmailToImgUrl($email) {
    $strTemp = getEamilToQq($email);
    if ($strTemp) {
        $imgurl = GetQQNick($strTemp);
    } else {
        $imgurl = GetGravatar($email);
    }

    return $imgurl;
}

/**
 * 发送一封邮件到评论者邮箱中
 * @param $to
 * @param $userName
 * @param $hfUserName
 * @param $content
 * @param $url
 */
function sendReturnMsgEmail($to, $userName, $hfUserName, $content, $url) {
    Mail::to($to)->sendNow(new replyDiscussMsg($userName, $hfUserName, $content, $url));
}

/**
 * 检测是否登陆
 * @return bool
 */
function checkLogin() {
    return LoginModel::check();
}

/**
 * 获取登陆用户信息
 * @return mixed
 */
function getLoginUserInfo($key = '', $default='') {
    $userInfo = LoginModel::getUserInfo();
    if ($key === '') {
        return $userInfo;
    }
    if (isset($userInfo[$key])) {
        return $userInfo[$key];
    } else {
        return $default;
    }
}

/**
 * 过滤掉emoji表情
 * @param $str
 * @return mixed
 */
function filterEmoji($str)
{
    $str = preg_replace_callback('/./u', function (array $match) {return strlen($match[0]) >= 4 ? '' : $match[0];}, $str);
    return $str;
}

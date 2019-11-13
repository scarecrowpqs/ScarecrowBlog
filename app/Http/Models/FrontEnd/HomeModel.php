<?php
namespace App\Http\Models\FrontEnd;

use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use function Scarecrow\sendReturnMsgEmail;

class HomeModel extends CommonBaseModel
{
    /**
     * 获取随机文章
     * @return array
     */
    public function randView() {
        $sql = 'SELECT title,cdat,aid FROM sc_articles WHERE openlevel=1 AND recommend=1 ORDER BY aid DESC LIMIT 1';
        $viewInfoObj = DB::select($sql)[0] ?? false;
        $relData = [];
        if($viewInfoObj) {
            $relData = [
                'title' =>$viewInfoObj->title,
                'cdat'  =>date("Y-m-d H:i:s", $viewInfoObj->cdat),
                'aid'   =>  $viewInfoObj->aid
            ];
        }

        return $relData;
    }

    /**
     * 获取文章总数
     * @param int $page
     * @param int $limit
     * @param int $isRecommend 是否是推荐的
     * @param int $cid 分类ID
     * @param int $sc 搜索
     * @return array
     */
    public function getViewList($page=1, $limit=10, $isRecommend=0, $cid=0, $sc='') {
        if ($isRecommend != 0) {
            $where = "t1.openlevel=1 AND t1.recommend=1";
        } else {
            $where = "t1.openlevel=1";
        }

        if ($sc) {
            $where .= " AND t1.title like '%{$sc}%' ";
        }

        $cateTitle = '';
        if ($cid > 0) {
            $where .= " AND t1.cid=" . $cid;
            $cateTitleObj = DB::table('sc_categorys')->where('cid', $cid)->first();
            if ($cateTitleObj) {
                $cateTitle = $cateTitleObj->title;
            }
        }

        //文章总数
        $viewInfoObjNum = DB::table('sc_articles as t1')->whereRaw($where)->count();
        $relData = [
            'curr'      =>  $page,
            'limit'     =>  $limit,
            'total'     =>  $viewInfoObjNum,
            'data'      =>  [],
            'cateTitle' =>  $cateTitle
        ];

        if ($viewInfoObjNum > 0) {
            $indexIcnt = ($page - 1) * $limit;
            //文章对象
            $viewInfoObj = DB::table('sc_articles as t1')
                ->leftJoin('sc_views as t2', 't2.aid', '=', 't1.aid')
                ->leftJoin('sc_categorys as t3', 't3.cid', '=', 't1.cid')
                ->whereRaw($where)
                ->select(['t1.*','t2.content as content','t3.title as catetitle'])
                ->orderByDesc('t1.recommend')
                ->orderByDesc('t1.cdat')
                ->offset($indexIcnt)
                ->limit($limit)
                ->get();

            foreach ($viewInfoObj as $item) {
                $relData['data'][] = (array)$item;
            }
        }
        $relData['next'] = ceil($relData['total'] / $limit) - $page > 0 ? $page + 1 : 0;
        $relData['before'] = $page - 1;
        return $relData;
    }

    /**
     * 获取所有友链
     * @return array
     */
    public function getLinks() {
        $allLinkObj = DB::table('sc_links')->orderByDesc('sort')->get();
        $relData = [];
        $tempArr = [];
        foreach ($allLinkObj as $item) {
            $tempArr[$item->id] = (array)$item;
            $tempArr[$item->id]['children'] = [];
        }

        foreach ($tempArr as &$item) {
            if ($item['spread_id'] == 0) {
                $relData[$item['id']] = &$item;
            } else {
                $tempArr[$item['spread_id']]['children'][] = &$item;
            }
        }

        return $relData;
    }

    /**
     * 获取评论
     * @param $bs
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getDiscuss($bs, $page=1, $limit=10) {
        $total = DB::table('sc_comments')->where('bs', $bs)->count();
        $relData = [
            'total' =>  $total,
            'data'  =>  [],
            'curr'  =>  $page,
            'limit' =>  $limit,
            'next'  =>  (ceil($total / $limit) - $page) > 0 ? $page + 1 : 0,
            'before'=>  $page - 1
        ];

        if ($total < 1) {
            return $relData;
        }

        $indeIcnt = ($page - 1) * $limit;
        $discussList = DB::table('sc_comments as t1')
            ->where('bs', $bs)
            ->orderByDesc('id')
            ->offset($indeIcnt)
            ->limit($limit)
            ->get();
        $allDiscussList = [];

        $allDiscussUserList = [];
        foreach ($discussList as $item) {
            $allDiscussList[] = (array)$item;
            $allDiscussUserList[] = $item->uid;
            $allDiscussUserList[] = $item->hf_uid;
        }

        $allDiscussUserList = array_unique($allDiscussUserList);
        if ($allDiscussUserList) {
            $discussListUserObj = DB::table('sc_commentator')->whereIn('uid', $allDiscussUserList)->get();
        }
        $userInfoList = [];
        foreach ($discussListUserObj as $item) {
            $userInfoList[$item->uid] = (array)$item;
        }

        foreach ($allDiscussList as &$item) {
            $item['name'] = $userInfoList[$item['uid']]['nickname'];
            $item['imgurl'] = $userInfoList[$item['uid']]['imgurl'];
            $item['homeurl'] = $userInfoList[$item['uid']]['homeurl'];
            $item['status'] = $userInfoList[$item['uid']]['status'];
            $item['hftip'] = $userInfoList[$item['uid']]['hftip'];
            $item['hf_name'] = $userInfoList[$item['hf_uid']]['nickname'] ?? '';
            $item['hf_homeurl'] = $userInfoList[$item['hf_uid']]['homeurl'] ?? '';
        }
        $relData['data'] = $allDiscussList;
        return $relData;
    }

    /**
     * 添加一个评论
     * @param $hfUid
     * @param $bs
     * @param $content
     * @param $nick
     * @param $email
     * @param $homeurl
     * @param $url
     * @return array
     */
    public function addDiscussData($hfUid, $bs, $content, $nick, $email, $homeurl, $url) {
        if ($hfUid) {
            $hfUserObj = DB::table('sc_commentator')->where('uid', $hfUid)->first();
            if (!$hfUserObj) {
                return [
                    'code'  =>  1,
                    'msg'   =>  '回复用户并不存在'
                ];
            }
        }

        $userObj = DB::table('sc_commentator')->where('email', $email)->first();
        $uid = $userObj->uid ?? '';
        if ($hfUid && $hfUid == $uid) {
            return [
                'code'  =>  1,
                'msg'   =>  '自己回复自己,戏精吗?'
            ];
        }

        if ($uid) {
            $data = ['email' => $email, 'nickname' => $nick, 'homeurl' => $homeurl];
            DB::table('sc_commentator')->where('uid', $uid)->update($data);
        } else {
            $imgurl = \Scarecrow\getEmailToImgUrl($email);
            $data = ['email' => $email, 'nickname' => $nick, 'imgurl' => $imgurl, 'cdat' => time(),'homeurl'=>$url];
            $uid = DB::table('sc_commentator')->insertGetId($data);
        }

        $toEmail = '1366635163@qq.com';
        if ($hfUid) {
            $toEmail = empty($hfUserObj->email ?? '') ? '1366635163@qq.com' : $hfUserObj->email;
        }

        $userObj =  DB::table('sc_commentator')->where('uid', $uid)->first();
        $imgurl = $userObj->imgurl ?? '';
        $status = $userObj->status ?? '';

        Cookie::queue(Cookie::make('nick', $nick, 43200));
        Cookie::queue(Cookie::make('email', $email, 43200));
        Cookie::queue(Cookie::make('homeurl', $homeurl, 43200));
        Cookie::queue(Cookie::make('imgurl', $imgurl, 43200));

        if ($status == 2) {
            return [
                'code'  =>  '1',
                'msg'   =>  '抱歉,你不能评论了哦！'
            ];
        }

        $data = ['uid' => $uid, 'bs' => $bs, 'hf_uid' => $hfUid, 'content' => $content, 'cdat' => time()];
        $iSIcnt = DB::table('sc_comments')->insert($data);
        if ($iSIcnt) {
            Session::put('plTimes', time());
            //如果需要发送邮件就在此处进行邮件发送
            \Scarecrow\sendReturnMsgEmail($toEmail, $nick, $hfUid ? $hfUserObj->nickname : '', $content, $url);
            return [
                'code' => 0, 'message' => '评论成功'
            ];
        } else {
            return [
                'code' => 1, 'message' => '评论失败！'
            ];
        }
    }

    /**
     * 获取文章详情
     * @param $aid
     * @return array
     */
    public function getView($aid) {
        $viewsObj = DB::table('sc_articles as t1')
            ->leftJoin('sc_views as t2', 't1.aid', '=', 't2.aid')
            ->leftJoin('sc_categorys as t3', 't3.cid', '=', 't1.cid')
            ->where('t1.aid', $aid)
            ->where('t1.openlevel', 1)
            ->select(['t1.*', 't2.content','t3.title as catetitle'])
            ->first();

        if(!$viewsObj) {
            return [
                'code'  =>  1,
                'msg'   =>  '文章不存在'
            ];
        }

        $state = Cookie::get('view' . $aid, '');
        if (!$state) {
            $viewsObj->readnum++;
            Cookie::queue(Cookie::make('view' . $aid, $aid, 1440));
            DB::table('sc_articles')->where('aid', $aid)->update([
                'readnum'   =>  $viewsObj->readnum
            ]);
        }
        $relData = (array)$viewsObj;
        return [
            'code'  =>  0,
            'msg'   =>  '',
            'data'  =>  $relData
        ];
    }

    /**
     * 获取微语列表
     * @param $page
     * @param $limit
     * @return array
     */
    public function getWeiYuList($page = 1, $limit = 8) {
        $weiYuNum = DB::table('sc_weiyu')->count();
        $relData = [
            'curr'      =>  $page,
            'limit'     =>  $limit,
            'total'     =>  $weiYuNum,
            'data'      =>  [],
        ];

        if ($weiYuNum > 0) {
            $indexiCnt = ($page - 1) * $limit;
            $weiYuObj = DB::table('sc_weiyu')->orderByDesc('cdat')->offset($indexiCnt)->limit($limit)->get();
            $weiYuData = [];
            foreach ($weiYuObj as $item) {
                $weiYuData[] = (array)$item;
            }
            $relData['data'] = $weiYuData;
        }

        $relData['next'] = ceil($relData['total'] / $limit) - $page > 0 ? $page + 1 : 0;
        $relData['before'] = $page - 1;
        return $relData;
    }

    /**
     * 获取云音乐列表
     * @return array
     */
    public function getMusicList() {
        $musicList = DB::table('sc_musics')->where('spread_id', 1)->orderByDesc('mid')->get();
        $relData = [];
        foreach ($musicList as $item) {
            $relData[] = (array)$item;
        }
        return $relData;
    }
}
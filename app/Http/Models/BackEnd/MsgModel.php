<?php
namespace App\Http\Models\BackEnd;

use Illuminate\Support\Facades\DB;

class MsgModel {

    /**
     * 获取留言数据分页接口
     * @param string $searchContent
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getMsgListPage($searchContent = '', $page = 1, $limit = 10) {
        $indexIcnt = ($page - 1) * $limit;
        if ($searchContent) {
            $num = DB::table('sc_comments')->whereRaw("content like '%{$searchContent}%'")->count();
        } else {
            $num = DB::table('sc_comments')->count();
        }

        if ($num < 1) {
            return [
                'total' =>  0,
                'data'  =>  [],
            ];
        }

        if ($searchContent) {
            $objList = DB::table('sc_comments')
                ->whereRaw("content like '%{$searchContent}%'")
                ->orderByDesc('cdat')
                ->offset($indexIcnt)->limit($limit)->get();
        } else {
            $objList = DB::table('sc_comments')
                ->orderByDesc('cdat')
                ->offset($indexIcnt)->limit($limit)->get();
        }

        $data = [];
        $allUid = [];
        foreach ($objList as $item) {
            $data[] = [
                'bs'    =>  $item->bs,
                'content'   =>  $item->content,
                'createTime'   =>  date("Y-m-d H:i:s", $item->cdat ? : time()),
                'uid'   =>  $item->uid,
                'hfUid'   =>  $item->hf_uid,
                'id'        =>  $item->id
            ];
            $allUid[] = $item->uid;
            $allUid[] = $item->hf_uid;
        }

        $allUid = array_unique($allUid);
        $allUserObjList = DB::table('sc_commentator')
            ->whereIn('uid', $allUid)
            ->select(['nickname', 'email', 'uid'])
            ->get();

        $allUserObj = [];
        foreach ($allUserObjList as $item) {
            $allUserObj[$item->uid] = [
                'uid'   =>  $item->uid,
                'name'  =>  $item->nickname,
                'email' =>  $item->email
            ];
        }


        foreach ($data as &$item) {
            if ($item['uid']>0) {
                $item['userName'] = ($allUserObj[$item['uid']]['name'] . '&lt;' .$allUserObj[$item['uid']]['email'] . '&gt;') ?? '';
            } else {
                $item['userName'] = '';
            }

            if ($item['hfUid']>0) {
                $item['hfUserName'] = ($allUserObj[$item['hfUid']]['name'] . '&lt;' . $allUserObj[$item['hfUid']]['email'] . '&gt;') ?? '';
            } else {
                $item['hfUserName'] = '';
            }
        }

        return [
            'total' =>  $num,
            'data'  =>  $data
        ];
    }

    /**
     * 删除留言数据
     * @param $id
     * @return array
     */
    public function deleteMsg($id) {
        $iCnt = DB::table('sc_comments')->where('id', $id)->delete();
        if ($iCnt) {
            return [
                'code'  =>  0,
                'msg'   =>  '删除成功'
            ];
        } else {
            return [
                'code'  =>  1,
                'msg'   =>  '删除失败'
            ];
        }
    }

    /**
     * 获取留言用户数据列表
     * @param string $searchContent
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getMsgUserListPage($searchContent = '', $page = 1, $limit = 10) {
        $indexIcnt = ($page - 1) * $limit;
        if ($searchContent) {
            $num = DB::table('sc_commentator')->whereRaw("nickname like '%{$searchContent}%' OR email like '%{$searchContent}%'")->count();
        } else {
            $num = DB::table('sc_commentator')->count();
        }

        if ($num < 1) {
            return [
                'total' =>  0,
                'data'  =>  [],
            ];
        }

        if ($searchContent) {
            $objList = DB::table('sc_commentator')->whereRaw("nickname like '%{$searchContent}%' OR email like '%{$searchContent}%'")->orderByDesc('uid')->offset($indexIcnt)->limit($limit)->get();
        } else {
            $objList = DB::table('sc_commentator')->orderByDesc('uid')->offset($indexIcnt)->limit($limit)->get();
        }

        $data = [];
        foreach ($objList as $item) {
            $data[] = [
                'uid'    =>  $item->uid,
                'nickname'   =>  $item->nickname,
                'homeurl'   =>  $item->homeurl,
                'imgurl'   =>  $item->imgurl,
                'status'   =>  $item->status,
                'email'     =>  $item->email
            ];
        }
        return [
            'total' =>  $num,
            'data'  =>  $data
        ];
    }

    /**
     * 改变留言者的留言权限状态
     * @param $id
     * @return array
     */
    public function changeMsgUserStatus($id) {
        $obj = DB::table('sc_commentator')->where('uid', $id)->first();
        if ($obj) {
            $iCnt = DB::table('sc_commentator')->where('uid', $id)->update([
                'status'    =>  $obj->status == 1 ? 2 : 1
            ]);
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
        } else{
            return [
                'code'  =>  1,
                'msg'   =>  '修改失败'
            ];
        }

    }

    /**
     * 删除一个留言者
     * @param $id
     * @return array
     */
    public function deleteMsgUser($id) {
        DB::table('sc_comments')->whereRaw("uid=? OR hf_uid=?", [$id,$id])->delete();
        DB::table('sc_commentator')->where('uid', $id)->delete();
        return [
            'code'  =>  0,
            'msg'   =>  '删除成功'
        ];
    }
}
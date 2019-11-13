<?php
namespace App\Http\Models\BackEnd;

use Illuminate\Support\Facades\DB;

class WeiYuModel {

    /**
     * 添加微语
     * @param $weiyuContent
     * @param $isGk
     * @return array
     */
    public function addData($weiyuContent, $isGk) {
        $iCnt = DB::table('sc_weiyu')->insert([
            'content'   =>  $weiyuContent,
            'status'    =>  $isGk,
            'cdat'      =>  time()
        ]);

        if ($iCnt) {
            return [
                'code'  =>  0,
                'msg'   =>  '添加成功'
            ];
        } else {
            return [
                'code'  =>  1,
                'msg'   =>  '添加失败'
            ];
        }
    }

    /**
     * 编辑微语
     * @param $id
     * @param $weiyuContent
     * @param $isGk
     * @return array
     */
    public function editData($id, $weiyuContent, $isGk) {
        $iCnt = DB::table('sc_weiyu')->where('id', $id)->update([
            'content'   =>  $weiyuContent,
            'status'    =>  $isGk
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
    }

    /**
     * 获取微语数据分页接口
     * @param string $searchContent
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getWeiYuListPage($searchContent = '', $page = 1, $limit = 10) {
        $indexIcnt = ($page - 1) * $limit;
        if ($searchContent) {
            $num = DB::table('sc_weiyu')->whereRaw("content like '%{$searchContent}%'")->count();
        } else {
            $num = DB::table('sc_weiyu')->count();
        }

        if ($num < 1) {
            return [
                'total' =>  0,
                'data'  =>  [],
            ];
        }

        if ($searchContent) {
            $objList = DB::table('sc_weiyu')->whereRaw("content like '%{$searchContent}%'")->orderByDesc('cdat')->offset($indexIcnt)->limit($limit)->get();
        } else {
            $objList = DB::table('sc_weiyu')->orderByDesc('cdat')->offset($indexIcnt)->limit($limit)->get();
        }

        $data = [];
        foreach ($objList as $item) {
            $data[] = [
                'id'    =>  $item->id,
                'content'   =>  $item->content,
                'status'    =>  $item->status == 1 ? '显示' : '隐藏',
                'cdat'      =>  date('Y-m-d H:i:s', $item->cdat ? : time())
            ];
        }
        return [
            'total' =>  $num,
            'data'  =>  $data
        ];
    }

    /**
     * 获取微语信息
     * @param $id
     * @return array
     */
    public function getWeiYuData($id) {
        $obj = DB::table('sc_weiyu')->where('id', $id)->first();
        if ($obj) {
            return [
                'code'  =>  0,
                'msg'   =>  '',
                'data'  =>  [
                    'id'    =>  $obj->id,
                    'content'   =>  $obj->content,
                    'status'    =>  $obj->status
                ]
            ];
        }
        return [
            'code'  =>  1,
            'msg'   =>  '数据不存在'
        ];
    }

    /**
     * 删除数据
     * @param $id
     * @return array
     */
    public function deleteData($id) {
        $iCnt = DB::table('sc_weiyu')->where('id', $id)->delete();
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
}
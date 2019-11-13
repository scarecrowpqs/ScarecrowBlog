<?php
namespace App\Http\Models\BackEnd;

use Illuminate\Support\Facades\DB;

class FrendLinkModel {

    /**
     * 获取所有分组
     * @return array
     */
    public function getLinkGroup() {
        $allGroup = DB::table('sc_links')->where('spread_id', 0)->pluck('title', 'id')->toArray();
        return $allGroup;
    }

    /**
     * 添加友链接口
     * @param $data
     * @return array
     */
    public function addData($data) {
        $iCnt = DB::table('sc_links')->insert($data);
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
     * 更新数据
     * @param $id
     * @param $data
     * @return array
     */
    public function updateData($id, $data) {
        $iCnt = DB::table('sc_links')->where('id', $id)->update($data);
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
     * 获取友链数据分页接口
     * @param string $searchContent
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getFrendLinkListPage($searchContent = '', $page = 1, $limit = 10) {
        $indexIcnt = ($page - 1) * $limit;
        if ($searchContent) {
            $num = DB::table('sc_links')->whereRaw("spread_id!=0 AND title like '%{$searchContent}%'")->count();
        } else {
            $num = DB::table('sc_links')->whereRaw("spread_id!=0")->count();
        }

        if ($num < 1) {
            return [
                'total' =>  0,
                'data'  =>  [],
            ];
        }

        if ($searchContent) {
            $objList = DB::table('sc_links')->whereRaw("spread_id!=0 AND title like '%{$searchContent}%'")->orderByDesc('cdat')->offset($indexIcnt)->limit($limit)->get();
        } else {
            $objList = DB::table('sc_links')->whereRaw("spread_id!=0")->orderByDesc('cdat')->offset($indexIcnt)->limit($limit)->get();
        }

        $data = [];
        foreach ($objList as $item) {
            $data[] = [
                'id'    =>  $item->id,
                'title'   =>  $item->title,
                'url'   =>  $item->url,
                'pic'   =>  $item->pic,
                'texts'   =>  $item->texts,
                'sort'   =>  $item->sort,
                'status'    =>  $item->status == 1 ? '显示' : '隐藏'
            ];
        }
        return [
            'total' =>  $num,
            'data'  =>  $data
        ];
    }

    /**
     * 获取友链数据
     * @param $id
     * @return array
     */
    public function getLinkInfo($id) {
        $linkInfo = DB::table('sc_links')->where('id', $id)->first();
        $linkInfo = (array)$linkInfo;
        if ($linkInfo) {
            return [
                'code'  =>  0,
                'msg'   =>  '',
                'data'  =>  $linkInfo
            ];
        } else {
            return [
                'code'  =>  1,
                'msg'   =>  '友链不存在'
            ];
        }
    }

    /**
     * 删除链接
     * @param $id
     * @return array
     */
    public function deleteLink($id) {
        $iCnt = DB::table('sc_links')->where('id', $id)->delete();
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
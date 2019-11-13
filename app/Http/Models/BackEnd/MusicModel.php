<?php
namespace App\Http\Models\BackEnd;

use Illuminate\Support\Facades\DB;

class MusicModel
{
    /**
     * 添加音乐链接
     * @param $data
     * @return array
     */
    public function addData($data) {
        $iCnt = DB::table('sc_musics')->insert($data);
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
     * 获取音乐数据分页接口
     * @param string $searchContent
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getMusicListPage($searchContent = '', $page = 1, $limit = 10) {
        $indexIcnt = ($page - 1) * $limit;
        if ($searchContent) {
            $num = DB::table('sc_musics')->whereRaw("spread_id!=0 AND title like '%{$searchContent}%'")->count();
        } else {
            $num = DB::table('sc_musics')->whereRaw("spread_id!=0")->count();
        }

        if ($num < 1) {
            return [
                'total' =>  0,
                'data'  =>  [],
            ];
        }

        if ($searchContent) {
            $objList = DB::table('sc_musics')->whereRaw("spread_id!=0 AND title like '%{$searchContent}%'")->orderByDesc('mid')->offset($indexIcnt)->limit($limit)->get();
        } else {
            $objList = DB::table('sc_musics')->whereRaw("spread_id!=0")->orderByDesc('mid')->offset($indexIcnt)->limit($limit)->get();
        }

        $data = [];
        foreach ($objList as $item) {
            $data[] = [
                'id'    =>  $item->mid,
                'title'   =>  $item->title,
                'url'   =>  $item->url,
                'pic'   =>  $item->pic,
                'author'   =>  $item->author
            ];
        }
        return [
            'total' =>  $num,
            'data'  =>  $data
        ];
    }

    /**
     * 删除音乐
     * @param $mid
     * @return array
     */
    public function deleteMusic($mid) {
        $iCnt = DB::table('sc_musics')->where('mid', $mid)->delete();
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
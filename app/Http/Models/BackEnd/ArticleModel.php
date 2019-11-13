<?php
namespace App\Http\Models\BackEnd;

use Illuminate\Support\Facades\DB;

class ArticleModel {

    /**
     * 获取所有文章分类
     * @return array
     */
    public function getCategoryList() {
        $allFlList = DB::table('sc_categorys')->pluck('title', 'cid')->toArray();
        return $allFlList;
    }

    /**
     * 插入文章数据
     * @param $articleData
     * @param $articleContent
     * @return array
     */
    public function addArticleData($articleData, $articleContent) {
        $aid = DB::table('sc_articles')->insertGetId($articleData);
        $iCnt = DB::table('sc_views')->where('aid', $aid)->update([
            'content'   =>  $articleContent
        ]);

        if($iCnt) {
            $viewObj = DB::table('sc_views')->where('aid', $aid)->first();
            DB::table('sc_articles')->where('aid', $aid)->update([
                'vid'   =>  $viewObj->vid
            ]);
            return [
                'code'  =>  0,
                'msg'   =>  '发布成功'
            ];
        } else {
            return [
                'code'  =>  1,
                'msg'   =>  '发布失败'
            ];
        }
    }

    /**
     * 获取文章分页数据
     * @param string $searchContent
     * @param int $page
     * @param int $limit
     * @return array
     */
    public function getArticleListPage($searchContent='', $page=1, $limit=10) {
        $allArticleListObj = DB::table('sc_articles as t1');
        if ($searchContent) {
            $allArticleListObj->whereRaw("(t1.title like '%{$searchContent}%')");
        }

        $indexIcnt = ($page - 1) * $limit;
        $allNum = $allArticleListObj->count();
        if ($allNum < 1) {
            return [
                'total' =>  $allNum,
                'data'  =>  []
            ];
        }

        $allArticleList = $allArticleListObj->leftJoin('sc_categorys as t2','t1.cid','=', 't2.cid')
            ->select(['t1.aid','t1.title','t2.title as cateName','t1.cdat','t1.author'])
            ->offset($indexIcnt)
            ->limit($limit)
            ->get();

        $data = [];
        foreach ($allArticleList as $item) {
            $data[] = [
                'id'            =>  $item->aid,
                'title'         =>  $item->title,
                'cateName'      =>  $item->cateName,
                'createTime'    =>  date("Y-m-d H:i:s", $item->cdat),
                'author'        =>  $item->author
            ];
        }

        return [
            'total' =>  $allNum,
            'data'  =>  $data
        ];
    }

    /**
     * 删除文章
     * @param $aid
     * @return array
     */
    public function deleteArticle($aid) {
        $iCnt = DB::table('sc_articles')->where('aid', $aid)->delete();
        if ($iCnt > 0) {
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
     * 获取文章信息
     * @param $aid
     * @return array
     */
    public function getArticleInfo($aid) {
        $articleObj = DB::table('sc_articles as t1')
            ->leftJoin('sc_views as t2', 't2.aid','=','t1.aid')
            ->where('t1.aid', $aid)
            ->select(['t1.*', 't2.content'])
            ->first();

        if (!$articleObj) {
            return [
                'code'  =>  1,
                'msg'   =>  '文章信息不存在'
            ];
        }

        return [
            'code'  =>  0,
            'msg'   =>  '',
            'data'  =>  (array)$articleObj
        ];
    }

    /**
     * 更新文章信息
     * @param $aid
     * @param $articleData
     * @param $articleContent
     * @return array
     */
    public function updateArticleData($aid, $articleData, $articleContent) {
        $ariticleObj = DB::table('sc_articles')->where('aid', $aid)->first();
        if (!$ariticleObj) {
            return [
                'code'  =>  1,
                'msg'   =>  '文章不存在'
            ];
        }

        DB::table('sc_articles')->where('aid', $aid)->update($articleData);
        DB::table('sc_views')->where('aid', $aid)->update([
            'content'   =>  $articleContent
        ]);

        return [
            'code'  =>  0,
            'msg'   =>  '更新成功'
        ];
    }
}
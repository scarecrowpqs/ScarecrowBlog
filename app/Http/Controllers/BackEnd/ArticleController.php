<?php
namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\ArticleModel;
use Illuminate\Http\Request;
use ScarecrowUeDitor\ScarecrowController;

class ArticleController extends Controller {

    /**
     * 管理文章页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('backend.article.manage');
    }

    /**
     * 发布文章
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add() {
        $m = new ArticleModel();
        $allCategoryList = $m->getCategoryList();
        return view('backend.article.createarticle', [
            'allCategoryList'  =>  $allCategoryList
        ]);
    }

    /**
     * 发布文章
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addArticleData(Request $request) {
        $categoryId = (int)$request->input('categoryId', 1);
        $articleTitle = $request->input('articleTitle', '');
        $readNum = (int)$request->input('readNum', 0);
        $articleUser = $request->input('articleUser', 'Scarecrow');
        $articleZhaiyao = $request->input('articleZhaiyao', '');
        $articleContent = $request->input('articleContent', '');
        $keyword = $request->input('keyword', '');
        $description = $request->input('description', '');
        $imgUrl = $request->input('imgUrl', '');
        $isGk = (int)$request->input('isGk', 1);
        $isTj = (int)$request->input('isTj', 1);

        if(mb_strlen($articleZhaiyao) > 50) {
            $articleZhaiyao = \Scarecrow\substrText($articleZhaiyao, 0, 50);
        }


        $data = [
            'cid'   =>  $categoryId,
            'title' =>  $articleTitle,
            'readnum'   =>  $readNum,
            'author'    =>  $articleUser,
            'remark'    =>  $articleZhaiyao,
            'openlevel' =>  $isGk,
            'recommend' =>  $isTj,
            'imgurl'    =>  $imgUrl,
            'uid'       =>  1,
            'nian'      =>  date("Y"),
            'yue'       =>  date("m"),
            'ri'        =>  date("d"),
            'udat'      =>  time(),
            'cdat'      =>  time(),
			'description'	=>	$description,
			'keyword'	=>	$keyword
        ];

        $m = new ArticleModel();
        $relData = $m->addArticleData($data, $articleContent);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? "YES" : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

    /**
     * 配置编辑器上传文件
     * @param Request $request
     * @return mixed|string
     */
    public function ueditorPhpHandler(Request $request) {
        $config = [
            "imagePathFormat"=>"/ueditor/image/{yyyy}{mm}{dd}/{time}{rand:6}",
            "scrawlPathFormat"=>"/ueditor/image/{yyyy}{mm}{dd}/{time}{rand:6}",
            "snapscreenPathFormat"=>"/ueditor/image/{yyyy}{mm}{dd}/{time}{rand:6}",
            "catcherPathFormat"=>"/ueditor/image/{yyyy}{mm}{dd}/{time}{rand:6}",
            "videoPathFormat"=>"/ueditor/video/{yyyy}{mm}{dd}/{time}{rand:6}",
            "filePathFormat"=>"/ueditor/file/{yyyy}{mm}{dd}/{time}{rand:6}",

            "imageManagerListPath"=>"/ueditor/image/",
            "fileManagerListPath"=>"/ueditor/file/",
        ];

        $ueObj = new ScarecrowController($config);
        $rel = $ueObj->action($request->all());
        return $rel;
    }

    /**
     * 获取文章分页
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getArticleListPage(Request $request) {
        $page = (int)$request->input('page', 1);
        $limit = (int)$request->input('limit', 10);
        $searchContent = addslashes($request->input('sc', ''));

        $m = new ArticleModel();
        $relData = $m->getArticleListPage($searchContent, $page, $limit);
        return response()->json([
            'status'    =>  'YES',
            'info'      =>  '获取成功',
            'total'     =>  $relData['total'],
            'data'      =>  $relData['data']
        ]);
    }

    /**
     * 删除文章
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteArticle(Request $request) {
        $aid = (int)$request->input('id', 0);
        $m = new ArticleModel();
        $relData = $m->deleteArticle($aid);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

    /**
     * 编辑文章
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editArticle(Request $request) {
        $aid = (int)$request->input('id', 0);
        $m = new ArticleModel();
        $allCategoryList = $m->getCategoryList();
        $relData = $m->getArticleInfo($aid);
        if ($relData['code'] != 0) {
            abort(403, $relData['msg']);
        }
        return view('backend.article.editarticle', [
            'allCategoryList'  =>  $allCategoryList,
            'articleInfo'      =>  $relData['data']
        ]);
    }

    /**
     * 更新文章信息
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateArticle(Request $request) {
        $categoryId = (int)$request->input('categoryId', 1);
        $articleTitle = $request->input('articleTitle', '');
        $readNum = (int)$request->input('readNum', 0);
        $articleUser = $request->input('articleUser', 'Scarecrow');
        $articleZhaiyao = $request->input('articleZhaiyao', '');
        $articleContent = $request->input('articleContent', '');
		$keyword = $request->input('keyword', '');
		$description = $request->input('description', '');
        $imgUrl = $request->input('imgUrl', '');
        $isGk = (int)$request->input('isGk', 1);
        $isTj = (int)$request->input('isTj', 1);
        $aid = (int)$request->input('aid', 0);

        if(mb_strlen($articleZhaiyao) > 50) {
            $articleZhaiyao = \Scarecrow\substrText($articleZhaiyao, 0, 50);
        }

        $data = [
            'cid'   =>  $categoryId,
            'title' =>  $articleTitle,
            'readnum'   =>  $readNum,
            'author'    =>  $articleUser,
            'remark'    =>  $articleZhaiyao,
            'openlevel' =>  $isGk,
            'recommend' =>  $isTj,
            'imgurl'    =>  $imgUrl,
            'uid'       =>  1,
            'udat'      =>  time(),
			'description'	=>	$description,
			'keyword'	=>	$keyword
        ];
        $m = new ArticleModel();
        $relData = $m->updateArticleData($aid, $data, $articleContent);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? "YES" : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }
}
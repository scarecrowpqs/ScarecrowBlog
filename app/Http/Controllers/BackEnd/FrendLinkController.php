<?php
namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\FrendLinkModel;
use Illuminate\Http\Request;

class FrendLinkController extends Controller
{
    /**
     * 管理友链
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view("backend.frendlink.manage");
    }

    /**
     * 获取友链分页列表
     * @param Request $request
     * @return array
     */
    public function getFrendLinkListPage(Request $request) {
        $page = (int)$request->input('page', 1);
        $limit = (int)$request->input('limit', 10);
        $searchContent = addslashes($request->input('sc', ''));

        $m = new FrendLinkModel();
        $relData = $m->getFrendLinkListPage($searchContent, $page, $limit);
        return response()->json([
            'status'    =>  'YES',
            'info'      =>  '获取成功',
            'total'     =>  $relData['total'],
            'data'      =>  $relData['data']
        ]);
    }

    /**
     * 编辑友链页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPage(Request $request) {
        $id = (int)$request->input('id', 0);
        $m = new FrendLinkModel();
        $allGroup = $m->getLinkGroup();
        $linkInfo = $m->getLinkInfo($id);
        if ($linkInfo['code'] != 0) {
            abort(500, $linkInfo['msg']);
        }
        return view('backend.frendlink.edit', [
            'allGroup'  =>  $allGroup,
            'linkInfo'  =>  $linkInfo['data']
        ]);
    }

    /**
     * 添加友链
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add() {
        $m = new FrendLinkModel();
        $allGroup = $m->getLinkGroup();
        return view('backend.frendlink.add', [
            'allGroup'  =>  $allGroup
        ]);
    }

    /**
     * 添加友链接口
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     */
    public function addData(Request $request) {
        $linkName = $request->input('linkName', '');
        $linkGroup = $request->input('linkGroup', '');
        $linkUrl = $request->input('linkUrl', '');
        $imageUrl = $request->input('imageUrl', '');
        $linkJieShao = $request->input('linkJieShao', '');
        $data = [
            'title' =>  $linkName,
            'url'   =>  $linkUrl,
            'pic'   =>  $imageUrl,
            'texts' =>  $linkJieShao,
            'sort'  =>  10,
            'spread_id' =>  $linkGroup,
            'status'    =>  1,
            'cdat'      =>  time()
        ];

        $m = new FrendLinkModel();
        $relData = $m->addData($data);

        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

    /**
     * 更新友链
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateData(Request $request) {
        $linkName = $request->input('linkName', '');
        $linkGroup = $request->input('linkGroup', '');
        $linkUrl = $request->input('linkUrl', '');
        $imageUrl = $request->input('imageUrl', '');
        $linkJieShao = $request->input('linkJieShao', '');
        $sort = $request->input('sort', '');
        $status = $request->input('status', 1);
        $id = (int)$request->input('id', 0);
        $data = [
            'title' =>  $linkName,
            'url'   =>  $linkUrl,
            'pic'   =>  $imageUrl,
            'texts' =>  $linkJieShao,
            'sort'  =>  10,
            'spread_id' =>  $linkGroup,
            'sort'  =>  $sort,
            'status'    =>  $status,
            'cdat'      =>  time()
        ];

        $m = new FrendLinkModel();
        $relData = $m->updateData($id,$data);

        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

    /**
     * 删除友链
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteLink(Request $request) {
        $id = (int)$request->input('id', 0);
        $m = new FrendLinkModel();
        $relData = $m->deleteLink($id);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }
}
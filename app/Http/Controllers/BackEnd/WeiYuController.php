<?php
namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\WeiYuModel;
use Illuminate\Http\Request;

class WeiYuController extends Controller
{
    /**
     * 管理微语页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('backend.weiyu.manage');
    }

    /**
     * 添加微语页面
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add() {
        return view('backend.weiyu.add');
    }

    /**
     * 编辑页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editPage(Request $request) {
        $id = (int)$request->input('id', 0);
        $m = new WeiYuModel();
        $relData = $m->getWeiYuData($id);
        if ($relData['code'] == 0) {
            return view('backend.weiyu.edit', [
                'data'  =>  $relData['data']
            ]);
        } else {
            abort(500, $relData['msg']);
        }
    }

    /**
     * 编辑微语数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function editData(Request $request) {
        $weiyuContent = $request->input('weiyuContent', '');
        $isGk = $request->input('isGk', 1);
        $id = (int)$request->input('id', 0);

        $m = new WeiYuModel();
        $relData = $m->editData($id, $weiyuContent, $isGk);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

    /**
     * 添加微语数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addData(Request $request) {
        $weiyuContent = $request->input('weiyuContent', '');
        $isGk = $request->input('isGk', 1);

        $m = new WeiYuModel();
        $relData = $m->addData($weiyuContent, $isGk);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

    /**
     * 获取微语数据分页
     * @param Request $request
     * @return array
     */
    public function getWeiYuListPage(Request $request) {
        $page = (int)$request->input('page', 1);
        $limit = (int)$request->input('limit', 10);
        $searchContent = addslashes($request->input('sc', ''));

        $m = new WeiYuModel();
        $relData = $m->getWeiYuListPage($searchContent, $page, $limit);
        return response()->json([
            'status'    =>  'YES',
            'info'      =>  '获取成功',
            'total'     =>  $relData['total'],
            'data'      =>  $relData['data']
        ]);
    }

    /**
     * 删除数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteData(Request $request){
        $id = (int)$request->input('id', 0);
        $m = new WeiYuModel();
        $relData = $m->deleteData($id);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }
}
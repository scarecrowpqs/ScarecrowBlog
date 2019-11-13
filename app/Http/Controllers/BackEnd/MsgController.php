<?php
namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\MsgModel;
use Illuminate\Http\Request;

class MsgController extends Controller
{
    /**
     * 留言管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('backend.msg.msgmanage');
    }

    /**
     * 获取留言分页列表
     * @param Request $request
     * @return array
     */
    public function getMsgListPage(Request $request) {
        $page = (int)$request->input('page', 1);
        $limit = (int)$request->input('limit', 10);
        $searchContent = addslashes($request->input('sc', ''));

        $m = new MsgModel();
        $relData = $m->getMsgListPage($searchContent, $page, $limit);
        return response()->json([
            'status'    =>  'YES',
            'info'      =>  '获取成功',
            'total'     =>  $relData['total'],
            'data'      =>  $relData['data']
        ]);
    }

    /**
     * 删除留言数据
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMsg(Request $request) {
        $id = (int)$request->input('id', 0);
        $m = new MsgModel();
        $relData = $m->deleteMsg($id);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

    /**
     * 用户管理
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function user() {
        return view('backend.msg.usermanage');
    }

    /**
     * 获取用户分页列表
     * @param Request $request
     * @return array
     */
    public function getMsgUserListPage(Request $request) {
        $page = (int)$request->input('page', 1);
        $limit = (int)$request->input('limit', 10);
        $searchContent = addslashes($request->input('sc', ''));

        $m = new MsgModel();
        $relData = $m->getMsgUserListPage($searchContent, $page, $limit);
        return response()->json([
            'status'    =>  'YES',
            'info'      =>  '获取成功',
            'total'     =>  $relData['total'],
            'data'      =>  $relData['data']
        ]);
    }

    /**
     * 改变留言者的留言状态
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeMsgUserStatus(Request $request) {
        $id = (int)$request->input('id', 0);
        $m = new MsgModel();
        $relData = $m->changeMsgUserStatus($id);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

    /**
     * 删除一个留言者
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMsgUser(Request $request) {
        $id = (int)$request->input('id', 0);
        $m = new MsgModel();
        $relData = $m->deleteMsgUser($id);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

}
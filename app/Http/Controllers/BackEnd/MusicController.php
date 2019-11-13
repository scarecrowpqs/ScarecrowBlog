<?php
namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Models\BackEnd\MusicModel;
use Illuminate\Http\Request;

class MusicController extends Controller
{
    /**
     * 管理音乐
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        return view('backend.music.manage');
    }

    /**
     * 添加音乐
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function add() {
        return view('backend.music.add');
    }


    /**
     * 获取音乐分页列表
     * @param Request $request
     * @return array
     */
    public function getMusicListPage(Request $request) {
        $page = (int)$request->input('page', 1);
        $limit = (int)$request->input('limit', 10);
        $searchContent = addslashes($request->input('sc', ''));

        $m = new MusicModel();
        $relData = $m->getMusicListPage($searchContent, $page, $limit);
        return response()->json([
            'status'    =>  'YES',
            'info'      =>  '获取成功',
            'total'     =>  $relData['total'],
            'data'      =>  $relData['data']
        ]);
    }


    /**
     * 添加音乐链接
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addData(Request $request)
    {
        $musicName = $request->input('musicName', '');
        $musicUrl = $request->input('musicUrl', '');
        $musicAuthor = $request->input('musicAuthor', '');
        $imageUrl = $request->input('imageUrl', '');
        $data = [
            'title' =>  $musicName,
            'author'   =>  $musicAuthor,
            'pic'   =>  $imageUrl,
            'url' =>  $musicUrl,
            'spread_id' =>  1
        ];

        $m = new MusicModel();
        $relData = $m->addData($data);

        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' : 'NO',
            'info'      =>  $relData['msg']
        ]);
    }

    /**
     * 删除音乐
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteMusic(Request $request) {
        $mid = (int)$request->input('id', 0);
        $m = new MusicModel();
        $relData = $m->deleteMusic($mid);
        return response()->json([
            'status'    =>  $relData['code'] == 0 ? 'YES' :'NO',
            'info'      =>  $relData['msg']
        ]);
    }
}
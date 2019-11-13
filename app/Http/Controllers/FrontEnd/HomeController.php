<?php
namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Models\FrontEnd\HomeModel;
use App\Http\Models\ScarecrowValidata;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use function Scarecrow\filterEmoji;

class HomeController extends Controller
{
    /**
     * 首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $m = new HomeModel();
        $randView = $m->randView();
        $viewList = $m->getViewList(1, 8, 0);
        return view("frontend.home.index", [
            'randView'  =>  $randView,
            'viewList'  =>  $viewList
        ]);
    }

    /**
     * 推荐阅读
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recommend(Request $request) {
        $page = (int)$request->input('page', 1);
        $page = $page < 1 ? 1 : $page;
        $limit = (int)$request->input('limit', 8);
        $m = new HomeModel();
        $viewList = $m->getViewList($page, $limit, 1);
        return view("frontend.home.recommend", [
            'viewList'  =>  $viewList
        ]);
    }

    /**
     * 邻居
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function link() {
        $m = new HomeModel();
        $allLink = $m->getLinks();
        return view("frontend.home.link", [
            'allLink'   =>  $allLink
        ]);
    }

    /**
     * 关于
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about(Request $request) {
        $bs = $request->input('bs', 'guest');
        $token = time();
        Session::put('discussToken', $token);
        $page = (int)$request->input('page', 0);
        $page = $page < 1 ? 1 : $page;
        $limit = (int)$request->input('limit', 8);
        $m = new HomeModel();
        $relData = $m->getDiscuss($bs, $page, $limit);
        return view('frontend.home.about', [
            'bs'    =>  $bs,
            'token' =>  $token,
            'discussInfo'   =>  $relData,
            'uri'   =>  $request->getUri()
        ]);
    }

    /**
     * 获取所有评论
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAllPDiscuss(Request $request) {
        $bs = $request->input('bs', 'guest');
        $page = (int)$request->input('page', 0);
        $page = $page < 1 ? 1 : $page;
        $limit = (int)$request->input('limit', 8);
        $token = time();
        Session::put('discussToken', $token);
        $m = new HomeModel();
        $relData = $m->getDiscuss($bs, $page, $limit);
        return view('frontend.common.pinglun', [
            'bs'    =>  $bs,
            'token' =>  $token,
            'discussInfo'   =>  $relData,
            'uri'   =>  $request->getUri()
        ]);
    }

    /**
     * 查看文章详情
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function seeView(Request $request) {
        $aid = (int)$request->input('aid', 0);
        if ($aid < 1) {
            abort(500, '文章不存在');
        }
        $token = time();
        Session::put('discussToken', $token);
        $m = new HomeModel();
        $viewData = $m->getView($aid);
        if ($viewData['code'] != 0) {
            abort(403, $viewData['msg']);
        }

        $viewDiscuss = $m->getDiscuss($aid, 1, 8);
		$metaKey = $viewData['data']['keyword'];
		$description = $viewData['data']['description'] ?: 'code changing word!';
        return view("frontend.home.view", [
            'token'         =>  $token,
            'viewData'      =>  $viewData['data'],
            'discussInfo'   =>  $viewDiscuss,
            'uri'           =>  $request->getUri(),
            'bs'            =>  $aid,
			'metaKey'		=>	$metaKey,
			'description'	=>	$description
        ]);
    }

    /**
     * 所有文章查看
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function classView(Request $request) {
        $page = (int)$request->input('page', 1);
        $page = $page < 1 ? 1 : $page;
        $limit = (int)$request->input('limit', 8);
        $cid = (int)$request->input('cid', 0);
        $cid = $cid < 1 ? 0 : $cid;
        $sc = addslashes($request->input('sc', ''));

        $m = new HomeModel();
        $viewList = $m->getViewList($page, $limit, 0, $cid, $sc);
        if ($cid == 0) {
            if ($sc) {
                $title = "全部文章-包含 '{$sc}' 的文章";
            } else {
                $title = "全部文章";
            }
        } else {
            $title = $viewList['cateTitle'];
        }
        return view("frontend.home.class", [
            'viewList'   =>  $viewList,
            'title'      =>  $title,
            'cid'        =>  $cid,
            'sc'         =>  stripslashes($sc)
        ]);
    }

    /**
     * 添加评论
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addDiscussData(Request $request) {
        $token = $request->input('token', '');
        $token2 = Session::get('discussToken', '');

        if (!$token || $token != $token2) {
            return response()->json([
                'code' => 1,
                'message' => '评论失败,请重新刷新页面进行评论！'
            ]);
        }

        $plTimes = Session::get('plTimes', 0);
        if ($plTimes && (time() - $plTimes < 30)) {
            return response()->json([
                'code' => 1,
                'message' => '好快啊，系统小姐姐吃不消了！'
            ]);
        }

        $validata = new ScarecrowValidata();
        $hfUid = $request->input('hf_uid', false);

        $bs = $request->input('discuss_id', false);
        if (empty($bs)) {
            return response()->json([
                'code' => 1,
                'message' => '请刷新页面重新操作'
            ]);
        }

        $content = $validata->comment($request->input('comment'));
        $content = filterEmoji($content);
        if (empty($content)) {
            return response()->json([
                'code' => 1,
                'message' => '评论内容(已自动过滤)不能为空！'
            ]);
        }


        $nick = $request->input('author', '');
        if ($nick) {
            $nick = $validata->username($nick) ? : '网友';
        } else {
            return response()->json([
                'code' => 1,
                'message' => '昵称不能为空,太长或含有特殊字符！'
            ]);
        }

        $email = $request->input('email', '');
        if($email) {
            $email = $validata->email($email) ? : '';
            if (!$email) {
                return response()->json([
                    'code' => 1,
                    'message' => '邮箱格式不对'
                ]);
            }
        } else {
            return response()->json([
                'code' => 1,
                'message' => '邮箱格式不对'
            ]);
        }

        $homeurl = $request->input('homeurl', '');
        if ($homeurl) {
            $homeurl = $validata->url($homeurl) ? : '';
        }

        $url = $request->input('url', '');
        if ($url) {
            $url = $validata->url($url) ? : '';
        }

        $m = new HomeModel();
        $relData = $m->addDiscussData($hfUid, $bs, $content, $nick, $email, $homeurl, $url);
        return response()->json($relData);
    }

    /**
     * 查看微语页面
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getWeiYuPage(Request $request) {
        $page = (int)$request->input('page', 1);
        $page = $page < 1 ? 1 : $page;
        $m = new HomeModel();
        $relData = $m->getWeiYuList($page, 8);
		$metaKey = "微语,说说,心情日记,Scarecrow日记";
        return view('frontend.home.weiyu', [
            'formData'  =>  $relData,
			'metaKey'	=>	$metaKey
        ]);
    }

    /**
     * 获取云音乐列表
     * @return array
     */
    public function getWyMusicApi() {
        $m = new HomeModel();
        $musicList = $m->getMusicList();
        return $musicList;
    }
}
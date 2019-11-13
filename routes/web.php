<?php

//测试路由
Route::get('/test', 'TestController@index');

/***********************************FrontEnd*******************************/
//网站临时首页
Route::get('/', function () {
//    return view('welcome');
    return redirect('/home');
});

//网站首页
Route::get('/home', 'FrontEnd\HomeController@index');
//推荐阅读
Route::get('/recommend', 'FrontEnd\HomeController@recommend');
//全部文章
Route::get('/classview', 'FrontEnd\HomeController@classView');
//邻居
Route::get('/link', 'FrontEnd\HomeController@link');
//关于
Route::any('/about', 'FrontEnd\HomeController@about');
//查看文章详情
Route::any('/seeview', 'FrontEnd\HomeController@seeView');
//获取所有评论
Route::any('/getalldiscuss', 'FrontEnd\HomeController@getAllPDiscuss');
//微语
Route::get('/weiyu', 'FrontEnd\HomeController@getWeiYuPage');
//获取网易音乐歌单
Route::any('/getwymusicapi', 'FrontEnd\HomeController@getWyMusicApi');
Route::middleware('srcCheck')->group(function () {
    //TODO::在此处编写前端请求资源
    Route::post('post/disuss', 'FrontEnd\HomeController@addDiscussData');
});


/***************************************END********************************/


/***********************************BackEnd*******************************/
//后台登陆页面
Route::get('back/login', 'BackEnd\BackEndController@loginPage');
//登陆接口
Route::post('/back/api/login', 'BackEnd\BackEndController@login');

Route::prefix('back')->middleware('authCheck')->group(function () {
    //TODO::在此处编写后台所有路由
    //注销用户
    Route::any('loginout', 'BackEnd\BackEndController@loginOut');
    //框架首页
    Route::get('index', 'BackEnd\BackEndController@index');
    //获取菜单列表
    Route::get('getmenulist', 'BackEnd\BackEndController@getMenuList');

    //管理文章
    Route::get('article/index', 'BackEnd\ArticleController@index');
    //获取文章分页数据接口
    Route::get('api/article/getarticlelistpage', 'BackEnd\ArticleController@getArticleListPage');
    //删除文章接口
    Route::get('api/article/deletearticle', 'BackEnd\ArticleController@deleteArticle');
    //添加文章
    Route::get('article/add', 'BackEnd\ArticleController@add');
    //编辑文章
    Route::get('article/editarticle', 'BackEnd\ArticleController@editArticle');
    //更新文章信息
    Route::post('api/article/updatearticle', 'BackEnd\ArticleController@updateArticle');
    //发布文章接口
    Route::post('api/article/addarticledata', 'BackEnd\ArticleController@addArticleData');
    //上传UEditor编辑器后台处理
    Route::any('article/ueditorphphandler', 'BackEnd\ArticleController@ueditorPhpHandler');
    //管理微语
    Route::get('weiyu/index', 'BackEnd\WeiYuController@index');
    //获取微语列表接口
    Route::get('api/weiyu/getweiyulistpage', 'BackEnd\WeiYuController@getWeiYuListPage');
    //添加微语数据接口
    Route::post('api/weiyu/add', 'BackEnd\WeiYuController@addData');
    //编辑微语页面
    Route::get('weiyu/editpage', 'BackEnd\WeiYuController@editPage');
    //编辑微语数据接口
    Route::post('api/weiyu/editdata', 'BackEnd\WeiYuController@editData');
    //微语删除数据接口
    Route::get('api/weiyu/deletedata', 'BackEnd\WeiYuController@deleteData');
    //添加微语
    Route::get('weiyu/add', 'BackEnd\WeiYuController@add');
    //管理友链
    Route::get('frendlink/index', 'BackEnd\FrendLinkController@index');
    //编辑友链
    Route::get('frendlink/editpage', 'BackEnd\FrendLinkController@editPage');
    //编辑友链接口
    Route::post('api/frendlink/updatedata', 'BackEnd\FrendLinkController@updateData');
    //删除友链接口
    Route::get('api/frendlink/deletelink', 'BackEnd\FrendLinkController@deleteLink');
    //获取友链数据接口
    Route::get('api/frendlink/getfrendlinklistpage', 'BackEnd\FrendLinkController@getFrendLinkListPage');
    //添加友链
    Route::get('frendlink/add', 'BackEnd\FrendLinkController@add');
    //添加友链接口
    Route::post('api/frendlink/add', 'BackEnd\FrendLinkController@addData');
    //管理留言
    Route::get('msg/index', 'BackEnd\MsgController@index');
    //获取用户留言列表接口
    Route::get('api/msg/getmsglistpage', 'BackEnd\MsgController@getMsgListPage');
    //刪除用户留言数据接口
    Route::get('api/msg/deletemsg', 'BackEnd\MsgController@deleteMsg');
    //管理留言用户
    Route::get('msg/user', 'BackEnd\MsgController@user');
    //获取留言用户数据列表
    Route::get('api/msg/getmsguserlistpage', 'BackEnd\MsgController@getMsgUserListPage');
    //修改留言者的评论权限接口
    Route::get('api/msg/changemsguserstatus', 'BackEnd\MsgController@changeMsgUserStatus');
    //删除留言者用户
    Route::get('api/msg/deletemsguser', 'BackEnd\MsgController@deleteMsgUser');
    //管理音乐
    Route::get('music/index', 'BackEnd\MusicController@index');
    //获取音乐数据分页接口
    Route::get('api/music/getmusiclistpage', 'BackEnd\MusicController@getMusicListPage');
    //删除音乐接口
    Route::get('api/music/deletemusic', 'BackEnd\MusicController@deleteMusic');
    //添加音乐
    Route::get('music/add', 'BackEnd\MusicController@add');
    //添加音乐链接接口
    Route::post('api/music/add', 'BackEnd\MusicController@addData');
    //总页
    Route::get('home', 'BackEnd\HomeController@index');

    //改变个人信息页面
    Route::get('showuserinfo', 'BackEnd\HomeController@showChangeUserInfoPage');
    //改变个人信息接口
    Route::post('changeuserinfo', 'BackEnd\HomeController@changeUserInfo');

});
/***************************************END********************************/
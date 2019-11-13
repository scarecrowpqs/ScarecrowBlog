<div class="comment-area">
    <section class="comments">
        <div class="comments-main">
            @if($discussInfo['total'] > 0)
            <div id="comments-list-title"><span>{{$discussInfo['total']}}</span> 条评论</div>

            <!-- 加载事件 -->
            <div id="loading-comments">
                <div class="host">
                    <div class="loading loading-0"></div>
                    <div class="loading loading-1"></div>
                    <div class="loading loading-2"></div>
                </div>
            </div>
            <!-- 加载事件 -->

            <ul class="commentwrap">
                @foreach($discussInfo['data'] as $item)
                <li class="comment even thread-even depth-1">
                    <div id="comment-969" class="comment_body contents">
                        <div class="profile">
                            <a rel="nofollow" target="_blank" href="{{$item['homeurl']}}"><img src="{{$item['imgurl'] ? : DEFAULT_IMG_TX}}" class="gravatar" alt="{{$item['name']}}"></a>
                        </div>
                        <div class="main shadow">
                            <div class="commentinfo">
                                <section class="commeta">
                                    <div class="shang">
                                        <h4 class="author"><a rel="nofollow" href="{{$item['homeurl']}}" target="_blank">{{$item['name']}}</a></h4>
                                    </div>

                                </section>
                            </div>
                            <div class="body" style="margin: 12px;">
                                <p>{{$item['content']}}</p>
                            </div>
                            <div class="xia info">
                                @if(!empty($item['hf_uid']))
                                <span>
                                    <a style="cursor: pointer;">{{$item['hf_name']}}</a>
                                    <time datetime="2018-03-09">{{Scarecrow\wordTime($item['cdat'])}}</time>
                                </span>
                                @endif
                                <span style="float: right;">
                                    <a class='comment-reply-link' style="cursor: pointer;" onclick="return jQuery('#hf{{$item['id']}}').toggle(2);">回复</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="comment-respond" id="hf{{$item['id']}}" style="display:none;">
                        <h6 id="replytitle" class="comment-reply-title"><a rel="nofollow" id="cancel-comment-reply-link" onclick="return jQuery('#hf{{$item["id"]}}').toggle(2);">取消回复</a>
                        </h6>
                        <form  id="hf_discuss_form_{{$item['id']}}" method="post" class="clearfix">
                            <div class="clearfix"></div>
                            <!--nologin-->
                            <div class="author-info">
                                <input type="text" name="author"  placeholder="昵  称 : " value="{{Scarecrow\getUserInfo("nick") ?? ''}}" tabindex="1"/>
                                <input type="text" name="email" placeholder="邮  箱 : " value="{{Scarecrow\getUserInfo("email") ?? ''}}" tabindex="2"/>
                                <input type="text" name="homeurl"  placeholder="网  址 :http:// " value="{{Scarecrow\getUserInfo("homeurl") ?? ''}}" tabindex="3"/>
                            </div>
                            <!--/nologin-->
                            <input type="hidden" name="token" value="{{$token}}"/>
                            <input type="hidden" name="url" value="{{$uri}}"/>
                            <div class="clearfix"></div>
                            <input type='hidden' name='hf_uid' value='{{$item['uid']}}'/>
                            <input type='hidden' name="discuss_id" value="{{$bs}}"/>
                            <div class="comment-form-info">
                                <div class="real-time-gravatar">
                                    <img id="real-time-gravatar" src="{{Scarecrow\getUserInfo("imgurl") ? :  DEFAULT_IMG_TX}}" alt="gravatar头像"/>
                                </div>
                                <p class="input-row">
                                    <i class="row-icon"></i>
                                    <textarea class="text_area" rows="3" cols="80" name="comment" tabindex="4"
                                              placeholder="回复:"></textarea>
                                    <input type="submit" name="submit" class="button hf_discuss" data-aid="{{$bs}}" data-id="{{$item['id']}}" tabindex="5" value="回复"/>
                                </p>
                            </div>
                        </form>
                    </div>
                </li>
                @endforeach
            </ul>
            @if($discussInfo['total'] > 0)
            <nav id="comments-navi" style="width:100%;text-align:center;">
                <div class="main shadow">
                    <ul class="fc-pagination">
                        @if ($discussInfo['before'])
                        <li style="cursor: pointer;"><span onclick="return page('{{$bs}}','{{$discussInfo['before']}}');">❮</span></li>
                        @endif
                        @if ($discussInfo['next'])
                        <li style="cursor: pointer;"><span onclick="return page('{{$bs}}','{{$discussInfo['next']}}');">❯</span></li>
                        @endif
                    </ul>
                </div>
            </nav>
            @endif
            @endif
            <!-- 分页 -->


            <!-- 回复评论 -->
            <div class="comment-respond">
                <!--<h6 id="replytitle" class="comment-reply-title"><a rel="nofollow" id="cancel-comment-reply-link" href="" >取消</a></h6>-->
                <form method="post" id="discuss_form" class="clearfix">
                    <div class="clearfix"></div>
                    <!--nologin-->
                    <div class="author-info">
                        <input type="text" name="author"  placeholder="昵  称 : " value="{{Scarecrow\getUserInfo("nick")}}" tabindex="1"/>
                        <input type="text" name="email" placeholder="邮  箱 : " value="{{Scarecrow\getUserInfo("email")}}" tabindex="2"/>
                        <input type="text" name="homeurl"  placeholder="网  址 :http:// " value="{{Scarecrow\getUserInfo("homeurl")}}" tabindex="3"/>
                    </div>
                    <!--/nologin-->
                    <input type="hidden" name="token"  value="{{$token}}"/>
                    <input type="hidden" name="url" value="{{$uri}}"/>
                    <div class="clearfix"></div>
                    <input type='hidden' name="discuss_id" value="{{$bs}}"/>
                    <div class="comment-form-info">
                        <div class="real-time-gravatar">
                            <img id="real-time-gravatar" src="{{Scarecrow\getUserInfo("imgurl") ? :  DEFAULT_IMG_TX}}" alt="gravatar头像"/>
                        </div>
                        <p class="input-row">
                            <i class="row-icon"></i>
                            <textarea class="text_area" rows="3" cols="80" name="comment" tabindex="4"
                                      placeholder="我辣么可耐,不摸一摸吗？(°∀°)ﾉ……"></textarea>
                            <input type="submit" name="submit" class="button discuss" data-aid="{{$bs}}" tabindex="5" value="发送"/>
                        </p>
                    </div>
                </form>
            </div>
            <!-- 回复评论 -->
        </div>
    </section>
</div>
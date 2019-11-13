@extends('frontend.common.index')
@section('showContentFrom')
    <div id="fh5co-main" class="fc_main">
        <aside id="fh5co-hero" class="js-fullheight">
            <div class="flexslider js-fullheight">
                <ul class="slides">
                    <li id="zmbg" style="background-image: url({{asset('assets/frontend/images/home/bj.jpg')}});">
                        <div class="overlay"></div>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2 text-center js-fullheight slider-text">
                                    @if(!empty($randView))
                                    <div class="slider-text-inner">
                                        <h1>{{$randView['title']}}</h1>
                                        <h2>{{$randView['cdat']}}</h2>
                                        <p>
                                            <a class="btn btn-primary btn-demo popup-vimeo" href="{{asset('/seeview?aid=' . $randView['aid'])}}"> <i class="icon-monitor"></i> 查看文章</a>
                                            <a class="btn btn-primary btn-learn" id="btn" href="{{asset('/weiyu')}}">心情吐槽<i class="icon-arrow-right3"></i></a>
                                        </p>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </aside>
        <div class="fh5co-narrow-content" style="padding: 1em 0;">
            <div class="fh5co-narrow-content">
                <h2 class="fh5co-heading animate-box" data-animate-effect="fadeInLeft">最新文章</h2>
                <div class="row row-bottom-padded-md">
                    @foreach($viewList['data'] as $item)
                    <div class="col-md-3 col-sm-6 col-padding animate-box" data-animate-effect="fadeInLeft">
                        <div class="blog-entry">
                            <a href="{{asset("/seeview?aid=" . $item['aid'])}}" class="blog-img"><img src="{{$item['imgurl'] ? : DEFAULT_IMG_FM}}" class="img-responsive" alt="{{$item['title']}}" style="width:100%;height:200px;"></a>
                            <div class="desc">
                                <h3><a href="{{asset("/seeview?aid=" . $item['aid'])}}">{{$item['title']}}</a></h3>
                                <span> <small>{{date("Y-m-d H:i:s", $item['cdat'])}}</small> / <small> <i class="icon-comment"></i>{{$item['readnum']}}</small></span>
                                <p>{{empty($item['remark']) ? Scarecrow\substrText($item['content'],0,55) : $item['remark']}}</p>
                                <a href="{{asset("/seeview?aid=" . $item['aid'])}}" class="lead">更多内容<i class="icon-arrow-right3"></i></a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <nav style="width:100%;text-align:center;">
            <a href="{{asset('/classview?page='. ($viewList['next'] > 0 ? : 1) .'&limit=8&cid=0')}}" class="btn btn-primary btn-learn" id="btn"><i class="icon-arrow-right3"></i></a>
        </nav>
    </div>
@endsection
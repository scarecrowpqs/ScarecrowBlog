@extends('frontend.common.index')
@section('showContentFrom')
<div id="fh5co-main" class="fc_main">
    <div class="fh5co-narrow-content">
        <h2 class="fh5co-heading animate-box" data-animate-effect="fadeInLeft">推荐阅读</h2>
        <div class="row row-bottom-padded-md">
            @foreach($viewList['data'] as $item)
            <div class="col-md-3 col-sm-6 col-padding animate-box" data-animate-effect="fadeInLeft">
                <div class="blog-entry">
                    <a href="{{asset("/seeview?aid=" . $item['aid'])}}" class="blog-img"><img src="{{$item['imgurl'] ? : DEFAULT_IMG_FM}}" class="img-responsive" alt="{{$item['title']}}" style="width:100%;height:200px;"></a>
                    <div class="desc">
                        <h3><a href="{{asset("/seeview?aid=" . $item['aid'])}}">{{$item['title']}}</a></h3>
                        <span> <small> {{date("Y-m-m H:i:s", $item['cdat'])}}</small> / <small> <i class="icon-comment"></i>{{$item['readnum']}} </small></span>
                        <p>{{empty($item['remark']) ? Scarecrow\substrText($item['content'],0,55) : $item['remark']}}</p>
                        <a href="{{asset("/seeview?aid=" . $item['aid'])}}" class="lead">阅读全文<i class="icon-arrow-right3"></i></a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <nav style="width:100%;text-align:center;">
        @if($viewList['before'] > 0)
        <a href="{{asset('/recommend?page=' . $viewList['before'] . '&limit=' . $viewList['limit'])}}" class="btn btn-primary btn-learn" id="btn"><i class="icon-arrow-left3"></i></a>
        @endif
        @if($viewList['next'] > 0)
        <a href="{{asset('/recommend?page=' . $viewList['next'] . '&limit=' . $viewList['limit'])}}" class="btn btn-primary btn-learn" id="btn"><i class="icon-arrow-right3"></i></a>
        @endif
    </nav>
</div>
@endsection


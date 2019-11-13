@extends('frontend.common.index')
@section('showContentFrom')
<div id="fh5co-main" class="fc_main">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/common/comments.css')}}"/>
    <div class="fh5co-more-contact">
        <div class="fh5co-narrow-content">
            <ol itemprop="breadcrumb" class="breadcrumb">
                <li><a href="{{asset('/home')}}">首页</a></li>
                <li><a href="{{asset('/classview?cid=' . $viewData['cid'])}}">{{$viewData['catetitle']}}</a></li>
                <li>文章</li>
            </ol>
            <article class="js-gallery post-1202 post type-post status-publish format-standard has-post-thumbnail hentry category-uncategorized tag-11 tag-22 tag-29"  itemscope itemtype="http://schema.org/Article">
                <!-- 用户评论 -->
                <section class="post_content">
                    @if(empty($viewData['title']))
                    <h2 class="p-title">该文章不存在</h2>
                    @else
                    <header class="post_header">
                        <h1 class="post_title">{{$viewData['title']}}</h1>
                    </header>
                    <div class="post-body js-gallery" itemprop="articleBody" style="max-width:888px;word-wrap: break-word;word-break: normal;">
                        {!! $viewData['content'] !!}
                    </div>
                    @endif
                    <div class="meta split split--responsive cf">
                        <div class="split__title">
                            <time>{{date("Y-m-d H:i:s", $viewData['cdat'] ? : time())}}</time>
                            <span>阅读数:{{$viewData['readnum']}}</span>
                        </div>
                    </div>
                </section>
            </article>
        </div>
    </div>
    <div class="fh5co-narrow-content animate-box" data-animate-effect="fadeInLeft" id="panel">
        @include('frontend.common.pinglun')
    </div>
</div>
@endsection


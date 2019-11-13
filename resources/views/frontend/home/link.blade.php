@extends('frontend.common.index')
@section('showContentFrom')
<div id="fh5co-main" class="fc_main">
    <div class="fh5co-narrow-content">
        <ol itemprop="breadcrumb" class="breadcrumb">
            <li><a href="{{asset('/home')}}">首页</a></li>
            <li class="active">邻居</li>
        </ol>
        <div style="max-width: 92%;margin:0 auto;">
            @foreach($allLink as $item)
            <h2 class="fh5co-heading animate-box" data-animate-effect="fadeInLeft">{{$item['title']}}({{count($item['children'])}})</h2>
            <div class="row">
                @foreach($item['children'] as $value)
                <div class="col-md-6">
                    <div class="fh5co-feature animate-box" data-animate-effect="fadeInLeft">
                        <div class="fh5co-icon">
                            <img alt="{{$value['title']}}" src="{{$value['pic'] ?? DEFAULT_IMG_TX}}" class="fh5co-icon"/>
                        </div>
                        <a href="{{$value['url']}}" target="_blank">
                            <div class="fh5co-text">
                                <h3>{{$value['title']}}</h3>
                                <p>{{$value['texts']}}</p>
                            </div>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection


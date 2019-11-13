@extends('frontend.common.index')
@section('showContentFrom')
<div id="fh5co-main" class="fc_main">
    <div class="fh5co-narrow-content">
        <ul class="listing-item">
            @foreach($formData['data'] as $item)
            <li>
                <div class="col-md-6 col-sm-6">
                    <div class="wrap-card">
                        <div class="card">
                            <p class="company">{{date("Y-m-d H:i:s", $item['cdat'] ? : time())}}</p>
                            <div class="text-detail">
                                <p>{!! $item['content'] !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            @endforeach
        </ul>
    </div>
    <nav style="width:100%;text-align:center;">
        @if($formData['before'] > 0)
        <a href="{{asset('/weiyu?page=' . $formData['before'])}}" class="btn btn-primary btn-learn" id="btn"><i class="icon-arrow-left3"></i></a>
        @endif
        @if($formData['next'] > 0)
        <a href="{{asset('/weiyu?page=' . $formData['next'])}}" class="btn btn-primary btn-learn" id="btn"><i class="icon-arrow-right3"></i></a>
        @endif
    </nav>
</div>
@endsection
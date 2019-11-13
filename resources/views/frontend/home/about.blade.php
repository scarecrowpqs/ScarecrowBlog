@extends('frontend.common.index')
@section('showContentFrom')
<div id="fh5co-main" class="fc_main">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/common/comments.css')}}"/>
    <div class="fh5co-narrow-content">
        <ol itemprop="breadcrumb" class="breadcrumb">
            <li><a href="{{asset('/home')}}">首页</a></li>
            <li class="active">关于我</li>
        </ol>
        <div class="row row-bottom-padded-md">
            <div class="col-md-6 animate-box" data-animate-effect="fadeInLeft">
                <img id="mypic" class="img-responsive" src="{{asset('/assets/frontend/images/home/zwjs.jpg')}}" alt="Free HTML5 Bootstrap Template by FreeHTML5.co">
            </div>
            <div class="col-md-6 animate-box" data-animate-effect="fadeInLeft">
                <h2 class="fh5co-heading mypic">设备外型 <em class="through mytips">编程机器人 零零七</em></h2>
                设备编号：HR-CN-8888<br />
                生产厂家：China<br />
                生产场地：Chong Qing<br />
                制造时间：1995/06/01<br />
                主要构成：碳水化合物，脂肪，蛋白质，矿盐<br />
                设备介绍：本设备的主要功能是把 水、碳水化合物、脂肪转换成由植物纤维制造，能任意折叠，用于交换物品的东西。
                顺带负责制造下一代机器,以便能够接任自己任务。<br />
                作为普通型的智能设备，不具有太过高级的功能，但是可以根据环境，扩展自己的功能，这是智能设备的通用的学习能力。<br />
                设备按照地球自转进行周期性的睡眠，自我检查与维修，另外还会进行能量补充，用于维持零件的运转，现已持续无障碍运行九千多天。<br />
                <em class="through"></em>
                </p>
            </div>
        </div>
    </div>

    <div class="fh5co-narrow-content" style="max-width: 92%;padding: 0 0;">
        <h2 class="fh5co-heading animate-box" data-animate-effect="fadeInLeft">制造项目</h2>
        <div class="row">
            <div class="col-md-6">
                <a target="_blank" href="https://gitee.com/scarecrowpqs/scarecrowAlipaySDK">
                    <div class="fh5co-feature animate-box" data-animate-effect="fadeInLeft">
                        <div class="fh5co-icon">
                            <img alt="ScarecrowAliPaySdk" src="{{asset('assets/frontend/images/home/wdxm_zfb.jpg')}}" class="fh5co-icon"/>
                        </div>
                        <div class="fh5co-text">
                            <h3>scarecrowAlipaySDK</h3>
                            <p>支付宝支付SDK:移除官方框架、支持PSR4</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a target="_blank" href="https://gitee.com/scarecrowpqs/scarecrowWechatSDK">
                    <div class="fh5co-feature animate-box" data-animate-effect="fadeInLeft">
                        <div class="fh5co-icon">
                            <img alt="scarecrowWechatSDK" src="{{asset('assets/frontend/images/home/wdxm_wx.jpg')}}" class="fh5co-icon"/>
                        </div>
                        <div class="fh5co-text">
                            <h3>scarecrowWechatSDK</h3>
                            <p>微信H5支付、查询、退款等</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a target="_blank" href="https://gitee.com/scarecrowpqs/dashboard/codes">
                    <div class="fh5co-feature animate-box" data-animate-effect="fadeInLeft">
                        <div class="fh5co-icon">
                            <img alt="常用小工具" src="{{asset('assets/frontend/images/home/wdxm_tool.jpg')}}" class="fh5co-icon"/>
                        </div>
                        <div class="fh5co-text">
                            <h3>常用小工具代码片段</h3>
                            <p>JS、PHP、HTML、C\C++ .....</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6">
                <a target="_blank" href="https://gitee.com/scarecrowpqs/ScarecrowChineseToPinYin/tree/master">
                    <div class="fh5co-feature animate-box" data-animate-effect="fadeInLeft">
                        <div class="fh5co-icon">
                            <img alt="中文获取拼音" src="{{asset('assets/frontend/images/home/wdxm_hztpy.jpg')}}" class="fh5co-icon"/>
                        </div>
                        <div class="fh5co-text">
                            <h3>中文获取拼音</h3>
                            <p>支持GB2312中文转拼音......</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="fh5co-narrow-content animate-box" data-animate-effect="fadeInLeft" id="panel">
        @include('frontend.common.pinglun')
    </div>
</div>
@endsection
@if(!\Scarecrow\requestIsPjax())
@include("frontend/common/header")
@endif

@yield('showContentFrom')

@if(!\Scarecrow\requestIsPjax())
@include("frontend/common/footer")
@endif

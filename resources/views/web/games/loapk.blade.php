@section('frame_url_address',$url_address)
@section('domain','fingertactic.com')

@if(Auth::guard()->check())
    @include('web.frame.kongregate.play')
@else
    @include('web.frame.kongregate.login')
@endif
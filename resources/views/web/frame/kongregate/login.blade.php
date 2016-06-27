@extends('web.frame.frame')
@section('header')
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'></script>
    <script src='https://cdn1.kongregate.com/javascripts/kongregate_api.js'></script>
@endsection
@section('content')
    <a id='login' style="display: none" title="Login to Kongregate to play the game!"
       href="javascript:kongregate.services.showSignInBox();"> <img src="/assets/img/guest/{{$game_code}}.png?v=1"
                                                                    alt="Login to Kongregate to play the game!"> </a>
@endsection
@section('footer')
    <script type='text/javascript'>
        console.log("[FT]script start");
        function showGameBox() {
            console.log("[FT]show game box start");
            var userId = kongregate.services.getUserId();
            console.log("[FT]service userid: " + userId);
            var authToken = kongregate.services.getGameAuthToken();
            console.log("[FT]service auth token: " + authToken);
            var params = "?uid=" + userId + "&gid=" + '{{$game_code}}'
                    + "&sid=" + '{{$server_id}}' + "&token=" + authToken + "&random=" + (Math.random() * 1000000000);
            console.log("[FT]params:" + params);
            //跳转到游戏
            location.href = "{{url('/service/kongregate/checkAuth')}}" + params;
        }
        function onLoadCompleted() {
            console.log("[FT]on load completed");
            kongregate = kongregateAPI.getAPI();
            var userId = kongregate.services.getUserId();
            console.log("[FT]userid: " + userId);
            if (userId == 0) {
                kongregate.services.addEventListener("login", showGameBox);
                $('#login').show();
            } else {
                showGameBox();
            }
        }
        kongregateAPI.loadAPI(onLoadCompleted);
        console.log("[FT]script end");
    </script>
@endsection
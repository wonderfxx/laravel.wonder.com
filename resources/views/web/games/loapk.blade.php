<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >
<head>
    <link href="/assets/img/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <script type="text/javascript" src='//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'></script>
    <script type="text/javascript" src='//cdn1.kongregate.com/javascripts/kongregate_api.js'></script>
    <script type="text/javascript">
        document.domain = "fingertactic.com";
    </script>
    <style type="text/css">
        html {
            border: none;
            overflow: hidden;
            background-color: #000;
            height: 100%;
        }

        body {
            border: none;
            background-color: #000;
            margin: 0;
            padding: 0;
        }
        .login{
            width: 950px;
            height: 600px;
            display: block;
        }
        .game_content {
            top: 0;
            left: 0;
            width: 100%;
            height: 600px;
            border: none;
            position: absolute;
            display: none;
        }

        .iframe {
            position: relative;
            top: 0;
            left: 0;
            border: 0 none;
            padding: 0;
            width: 100%;
            height: 600px;
        }
        .game_notice{
            position: absolute;
            z-index: 200;
            width:600px;
            height: 165px;
            top: 150px;
            padding: 10px 15px;
            left: 175px;
            background: #ebf5ff;
            font-family: "Lucida Grande",Verdana,sans-serif;
            line-height: 1.5;
            font-size: 18px;
            font-weight: bold;
            color: #000;
            display: block;
            border: 1px solid #FFF;
            border-radius: 5px
        }
        .game_notice .notice_close{position: absolute;right: 35px;top: 5px;width: 20px;height: 20px;display: block;
            font-size: 16px;color:#000;}
        .game_notice a.game_link{color: #900;font-size: 18px}
    </style>
<body>
<script type='text/javascript'>
    console.log("[FT]script start");
    function showGameBox() {
        var userId = kongregate.services.getUserId();
        var authToken = kongregate.services.getGameAuthToken();
        var params = "?uid=" + userId +
                "&gid=" + '{{$game_code}}'+
                "&sid=" + '{{$server_id}}'+
                "&token=" + authToken +
                "&random=" + (Math.random() * 1000000000);
        //跳转到游戏
        var gameUrl = "{!! url('/service/kongregate/checkAuth') !!}" + params;
        console.log("[FT]url:" + gameUrl);
        var iframe = '<iframe id="iframe" ' +
                'name="iframe" frameborder="0" ' +
                'onscroll="function(e){e.preventDefault();}" ' +
                'class="iframe" ' +
                'src="' + gameUrl + '"></iframe>';
        $('#game_content').show().html(iframe);
        console.log("[FT]Playing");
    }
    function onLoadCompleted() {
        console.log("[FT]on load completed");
        kongregate = kongregateAPI.getAPI();
        var userId = kongregate.services.getUserId();
        console.log("[FT]userid: " + userId);
        if (userId == 0) {
            kongregate.services.addEventListener("login", showGameBox);
            $('#login').show().click(function () {
                kongregate.services.showSignInBox();
            });
        } else {
            showGameBox();
        }
    }
    function startPayment(user_id, server_id, product_id, user_role, user_role_id, user_grade) {
        console.log(product_id);
        var param = {
            'game_code': 'loapk',
            'country': 'US',
            'channel_code': 'kongregate',
            'channel_sub_code': '',
            'product_type': 'normal',
            'user_id': user_id,
            'server_id': server_id,
            'product_id': product_id,
            'user_role': user_role,
            'user_role_id': user_role_id,
            'user_grade': user_grade,
            '_token': '{!! csrf_token() !!}'
        };
        $.ajax({
            url: "{{url('/api/placed')}}",
            type: "post",
            dataType: "json",
            data: param,
            success: function (data) {
                console.log('[FT] placed data:' + data);
                kongregate.mtx.purchaseItemsRemote(data.fg_order_id + ',' + data.package_id,
                        function (response) {
                            console.log('[FT] payment status:' + response);
                        });
            },
            error: function (data) {
                var errors = data.responseJSON;
                console.log('[FT]ERROR:' + errors + data.status);
            }
        });
    }
    kongregateAPI.loadAPI(onLoadCompleted);
    console.log("[FT]script end");
    function close() {
        document.getElementById('game_notice').style.display = 'none';
    }
</script>
<a id='login' class="login" style="display: none"
   title="Login to Kongregate to play the game!"
   href="javascript:void(0);">
    <img src="/assets/img/guest/{{$game_code}}.jpg?v=2" width="950px" height="600px"/>
</a>
<div id="game_content" class="game_content">
</div>
@if($is_safari_browser)
<div class="game_notice" id="game_notice">
    <a class="notice_close" href="javascript:close();">close</a>
    <p>
        Sorry, due to Safari default privacy setting, your current version may not be able to play the game, please
    upgrade your Safari to the latest version or readjust your privacy cookie setting to play the game. Here is the
        way to adjust the privacy cookie setting:
        <a href="http://goo.gl/k9JLhB" class="game_link" target="_blank">http://goo.gl/k9JLhB</a>
    </p>
</div>
@endif
</body>
</html>
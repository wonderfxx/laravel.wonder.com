<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
    <link href="/assets/img/favicon.ico" rel="shortcut icon" type="image/x-icon"/>
    <script type="text/javascript" src='//ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'></script>
    <script type="text/javascript" src='//cdn1.kongregate.com/javascripts/kongregate_api.js'></script>
    <link href="/assets/css/game/kg.min.css?v=1.2.0" rel="stylesheet">
    <script type="text/javascript">
        document.domain = "fingertactic.com";
    </script>
<body>
<script type='text/javascript'>
    var isLogin = false;
    $(document).ready(function () {
        $('.header ul li a').click(function () {
            switchTabWindow($(this));
        });
    });
    console.log("[FT]script start");
    function showGameBox(id) {
        var userId = kongregate.services.getUserId();
        var authToken = kongregate.services.getGameAuthToken();
        var server_id = id ? id : '{{$server_id}}';
        var params = "?uid=" + userId +
                "&gid=" + '{{$game_code}}' +
                "&sid=" + server_id +
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
            isLogin = false;
            kongregate.services.addEventListener("login", showGameBox);
            $('#login').show().click(function () {
                kongregate.services.showSignInBox();
            });
        } else {
            isLogin = true;
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
    function switchTabWindow(event) {
        if(!isLogin)
        {
            return false;
        }
        $('.content').hide();
        $(event.attr('name')).show();
        event.parent().siblings().find('a').removeClass('li_active');
        event.addClass('li_active');
    }
    function selectServer(id) {
        switchTabWindow($('#game_content_tab'));
        showGameBox(id);
    }
    kongregateAPI.loadAPI(onLoadCompleted);
    console.log("[FT]script end");
</script>
<div class="header">
    <ul>
        <li>
            <a href="javascript:void(0)" name='#game_content' id='game_content_tab' class="li_active"
               title="Start Game">
                <img src="/assets/img/server/play.png"
                     width="25px" height="17px"
                     style="vertical-align: middle"/>Start Game</a>
        </li>
        <li>
            <a href="javascript:void(0)" name='#server_content' id='server_content_tab' title="Select Server">
                <img src="/assets/img/server/list.png" width="20px" height="15px"
                     style="vertical-align: middle"/>Select Server</a>
        </li>
    </ul>
</div>
<a id='login' class="login" style="display: none"
   title="Login to Kongregate to play the game!"
   href="javascript:void(0);">
    <img src="/assets/img/guest/{{$game_code}}.jpg?v=2" width="950px" height="600px"/>
</a>
<div id="game_content" class="game_content content" style="display: none"></div>
<div id="server_content" class="server_content content">
    <div id="server_select" class="server_select">
        <div class="choose_server">
            @if(!empty($server_list['new']))
                <div class=" server_new">
                    <label>New Server:</label>
                    <a href='javascript:void(0)'
                       onclick="selectServer({{$server_list['new']->server_id}})"
                       title="{{$server_list['new']->server_name}}">{{$server_list['new']->server_name}}</a>
                </div>
            @endif
            @if(!empty($server_list['last']))
                <div class=" server_login">
                    <label>Last Login:</label>
                    <a href='javascript:void(0)'
                       onclick="selectServer({{$server_list['last']->server_id}})"
                       title="{{$server_list['last']->server_name}}">{{$server_list['last']->server_name}}</a>
                </div>
            @endif
            @if(!empty($server_list['other']))
                <div class=" server_normal">
                    <label>Other Servers:</label>
                    <div class="server_normal_box">
                        @foreach($server_list['other']  as $item)
                            <a href='javascript:void(0)' onclick="selectServer({{$item->server_id}})"
                               title="{{$item->server_name}}">{{$item->server_name}}</a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
</body>
</html>

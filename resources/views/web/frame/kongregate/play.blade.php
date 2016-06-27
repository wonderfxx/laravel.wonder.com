@extends('web.frame.frame')
@section('header')
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js'></script>
    <script src='https://cdn1.kongregate.com/javascripts/kongregate_api.js'></script>
    <style>
        body {
            background: black
        }
    </style>
@endsection
@section('content')
    <iframe src="@yield('frame_url_address')" width="100%" height="600" scrolling="no" frameborder="no"></iframe>
@endsection
@section('footer')
    <script type='text/javascript'>
        console.log("[FT]script start");
        function onLoadCompleted() {
            console.log("[FT]on load completed");
            kongregate = kongregateAPI.getAPI();
            var userId = kongregate.services.getUserId();
            console.log("[FT]userid: " + userId);
            if (userId == 0) {
                kongregate.services.addEventListener("login", showGameBox);
                $('#login').show();
            }
        }
        kongregateAPI.loadAPI(onLoadCompleted);
        console.log("[FT]script end");
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
                'product_id': product_id[0],
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
//                                if (response.success) {
//                                    getGame().onOrderSuccess(itemId, response.item_order_id);
//                                }
//                                else {
//                                    getGame().onOrderFail(itemId);
//                                }
                            });
                },
                error: function (data) {
                    var errors = data.responseJSON;
                    console.log(errors);
                    switch (data.status) {
                        case 422:
                            break;
                        case 302:
                            break;
                        case 200:
                            break;
                        default:
                    }
                }
            });
        }
    </script>
@endsection
@extends('web.frame.frame')
@section('content')
    <iframe src="@yield('frame_url_address')" width="100%" height="690" scrolling="no" frameborder="no"></iframe>
@endsection
@section('footer')
    <script type='text/javascript'>
        function startPayment(user_id, server_id, product_id, user_role, user_role_id, user_grade) {
            console.log(product_id);
            var param = {
                'game_code': 'loapk',
                'user_id': user_id,
                'server_id': server_id,
                'product_id': product_id[0],
                'user_role': user_role,
                'user_role_id': user_role_id,
                'user_grade': user_grade,
                '_token':'{!! csrf_token() !!}'
            };
            $.ajax({
                url: "{{url('/api/placed')}}",
                type: "post",
                dataType: "json",
                data: param,
                success: function (data) {
                    alert('success');
                },
                error: function (data) { // the data parameter here is a jqXHR instance
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
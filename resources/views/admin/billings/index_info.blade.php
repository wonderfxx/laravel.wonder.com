@extends('admin.common.frame')
@section('content')
    <div class="wrapper wrapper-content animated fadeIn">
        <div class="row col-sm-6">
            <table class="table table-striped table-hover table-bordered">
                <tbody>
                @foreach($data  as $key=>$item)
                    <tr>
                        <td>{!! empty($headers[$key]) ? $key :$headers[$key]['title'] !!}</td>
                        @if(in_array($key,['send_time','created_time','updated_time','channel_pay_time']))
                            <td>{!! $item == 0 ? "-" : date('Y-m-d H:i',$item) !!}</td>
                        @else
                            <td>{!! $item !!}</td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
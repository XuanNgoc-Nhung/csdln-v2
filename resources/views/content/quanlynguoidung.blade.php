{{--@extends("layout.app")--}}
{{--@section("content")--}}
{{--    <div class="row">--}}
{{--    </div>--}}
{{--    <div id="app" class="row">--}}
{{--        <quan-ly-nguoi-dung  :info="'{{json_encode(get_user_info("common_info"))}}'"></quan-ly-nguoi-dung>--}}
{{--    </div>--}}


{{--@endsection--}}

{{--@section("js_location")--}}
{{--    <script src="{{asset('js/quan-ly-nguoi-dung.js')}}"></script>--}}
{{--    <script src="https://kendo.cdn.telerik.com/2019.1.220/js/kendo.all.min.js"></script>s--}}
{{--@endsection--}}


@extends("layout.app")
@section("header")

    <title>Quản lý người dùng || Cơ sở dữ liệu ngành</title>
@endsection
@section("content")
    <div id="app" class="row">
        <quan-ly-nguoi-dung></quan-ly-nguoi-dung>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/quan-ly-nguoi-dung.js')}}"></script>
@endsection


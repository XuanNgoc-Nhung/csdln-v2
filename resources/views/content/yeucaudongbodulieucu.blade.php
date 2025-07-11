@extends("layout.app")
@section("content")
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Yêu cầu đồng bộ dữ liệu cũ</h1>
        </div>
    </div>
    <div id="app">
        <yeu-cau-dong-bo-du-lieu-cu :ma-so="{{get_user_info("maSo")}}" :info="'{{json_encode(get_user_info("common_info"))}}'"></yeu-cau-dong-bo-du-lieu-cu>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/yeu-cau-dong-bo-du-lieu-cu.js')}}"></script>
@endsection


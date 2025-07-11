@extends("layout.app")
@section("content")
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Danh sách yêu cầu đồng bộ dữ liệu</h1>
        </div>
    </div>
    <div id="app">
        <tra-cuu-yeu-cau-dong-bo :info="'{{json_encode(get_user_info("common_info"))}}'"></tra-cuu-yeu-cau-dong-bo>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/tra-cuu-yeu-cau-dong-bo.js')}}"></script>
@endsection


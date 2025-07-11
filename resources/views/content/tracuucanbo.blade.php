@extends("layout.app")
@section("content")
    
    <div id="app" class="row">
        <tra-cuu-danh-sach-can-bo :trangcu="'{{$data}}'"  :info="'{{json_encode(get_user_info("common_info"))}}'"></tra-cuu-danh-sach-can-bo>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/tra-cuu-can-bo.js')}}"></script>
@endsection


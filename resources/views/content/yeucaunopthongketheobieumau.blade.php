@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <yeu-cau-nop-thong-ke-theo-bieu-mau :info="'{{json_encode(get_user_info("common_info"))}}'"></yeu-cau-nop-thong-ke-theo-bieu-mau>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/yeu-cau-nop-du-lieu-theo-bieu-mau.js')}}"></script>
@endsection


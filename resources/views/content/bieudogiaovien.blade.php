@extends("layout.app")
@section("content")
    <div class="row">
    </div>
    <div id="app" class="row">
        <bieu-do-giao-vien :info="'{{json_encode(get_user_info("common_info"))}}'"></bieu-do-giao-vien>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bieu-do-giao-vien.js')}}"></script>
@endsection


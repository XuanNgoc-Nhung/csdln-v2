@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <bieu-do-xep-loai-hoc-sinh :info="'{{json_encode(get_user_info("common_info"))}}'"></bieu-do-xep-loai-hoc-sinh>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bieu-do-hl-hk-hoc-sinh.js')}}"></script>
@endsection


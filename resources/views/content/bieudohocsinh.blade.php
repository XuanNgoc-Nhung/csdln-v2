@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <bieu-do-hoc-sinh :info="'{{json_encode(get_user_info("common_info"))}}'"></bieu-do-hoc-sinh>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bieu-do-hoc-sinh.js')}}"></script>
@endsection


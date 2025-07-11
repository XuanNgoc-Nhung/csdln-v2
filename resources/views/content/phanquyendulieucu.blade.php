@extends("layout.app")
@section("content")
    <div class="row">
    </div>
    <div id="app">
        <phan-quyen-du-lieu-cu :info="'{{json_encode(get_user_info("common_info"))}}'"></phan-quyen-du-lieu-cu>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/phan-quyen-du-lieu-cu.js')}}"></script>
@endsection


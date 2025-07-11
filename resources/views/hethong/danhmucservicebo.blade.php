@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <danh-muc-service-bo  :info="'{{json_encode(get_user_info("common_info"))}}'"></danh-muc-service-bo>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/danh-muc-service-bo.js')}}"></script>
@endsection


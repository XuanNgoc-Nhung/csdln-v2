@extends("layout.app")
@section("header")
@endsection
@section("content")
    <div id="app" class="row">
        <bao-cao-emis :info="'{{json_encode(get_user_info("common_info"))}}'"></bao-cao-emis>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bao-cao-emis.js')}}"></script>
@endsection


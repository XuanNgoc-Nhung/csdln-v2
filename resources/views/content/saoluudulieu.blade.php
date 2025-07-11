@extends("layout.app")
@section("header")
@endsection
@section("content")
    <div class="row">
    </div>
    <div id="app" class="row">
        <sao-luu-du-lieu  :info="'{{json_encode(get_user_info("common_info"))}}'"></sao-luu-du-lieu>
    </div>


@endsection

@section("js_location")
    <script src="{{asset('js/sao-luu-du-lieu.js')}}"></script>
@endsection


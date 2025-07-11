@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <gui-yeu-cau-dong-bo-du-lieu :info="'{{json_encode(get_user_info("common_info"))}}'"></gui-yeu-cau-dong-bo-du-lieu>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/gui-yeu-cau-dong-bo-du-lieu.js')}}"></script>
@endsection


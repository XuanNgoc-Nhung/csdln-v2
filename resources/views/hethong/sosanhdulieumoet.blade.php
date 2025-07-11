@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <so-sanh-du-lieu-moet :info="'{{json_encode(get_user_info("common_info"))}}'"></so-sanh-du-lieu-moet>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/so-sanh-du-lieu-moet.js')}}"></script>
@endsection


@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <import-file-du-lieu-moet :info="'{{json_encode(get_user_info("common_info"))}}'"></import-file-du-lieu-moet>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/import-file-du-lieu-moet.js')}}"></script>
@endsection


@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <yeu-cau-dong-bo-du-lieu-theo-truong
            :info="'{{json_encode(get_user_info("common_info"))}}'"></yeu-cau-dong-bo-du-lieu-theo-truong>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/yeu-cau-dong-bo-du-lieu-theo-truong-ioc.js')}}"></script>
@endsection


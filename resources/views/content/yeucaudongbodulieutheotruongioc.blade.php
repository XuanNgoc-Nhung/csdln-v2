@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <yeu-cau-dong-bo-du-lieu-theo-truong ></yeu-cau-dong-bo-du-lieu-theo-truong>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/yeu-cau-dong-bo-du-lieu-theo-truong-ioc.js')}}"></script>
@endsection


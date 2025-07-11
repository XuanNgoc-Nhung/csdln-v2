@extends("layout.app")
@section("content")
    <div class="row">
        <div class="col-lg-12">
        </div>
    </div>
    <div id="app">
        <cau-hinh-lich-dong-bo-hang-nam :info="'{{json_encode(get_user_info("common_info"))}}'">
        </cau-hinh-lich-dong-bo-hang-nam>
    </div>
@endsection

@section("js_location")
    <script src="{{asset('js/cau-hinh-lich-dong-bo-hang-nam.js')}}"></script>
@endsection


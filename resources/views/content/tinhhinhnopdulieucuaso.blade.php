@extends("layout.app")
@section("content")
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header text-uppercase">Tình hình nộp dữ liệu của sở</h3>
        </div>
    </div>
    <div id="app">
        <tinh-hinh-nop-du-lieu-cua-so :info="'{{json_encode(get_user_info("common_info"))}}'">
        </tinh-hinh-nop-du-lieu-cua-so>
    </div>
@endsection

@section("js_location")
    <script src="{{asset('js/tinh-hinh-nop-du-lieu-cua-so.js')}}"></script>
@endsection


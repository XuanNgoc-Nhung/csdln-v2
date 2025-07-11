@extends("layout.app")
@section("content")
    <div class="row">
        <div class="text-uppercase">
            <h3 class="page-header">Kết chuyển dữ liệu</h3>
        </div>
    </div>
    <div id="app" class="row">
        <ket-chuyen-du-lieu :info="'{{json_encode(get_user_info("common_info"))}}'"></ket-chuyen-du-lieu>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/ket-chuyen-du-lieu.js')}}"></script>
@endsection


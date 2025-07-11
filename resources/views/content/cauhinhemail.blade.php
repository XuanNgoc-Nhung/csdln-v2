@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 style="font-size: 38px"> Cấu hình email </h1>
        </div>
    </div>
    <div id="app" class="row">
        <cau-hinh-email :ma-so="{{get_user_info("maSo")}}"></cau-hinh-email>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/cau-hinh-email.js')}}"></script>
@endsection


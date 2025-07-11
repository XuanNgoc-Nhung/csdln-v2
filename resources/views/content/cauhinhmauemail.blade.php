@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1> Cấu hình mẫu email</h1>
        </div>
    </div>
    <div id="app" class="row">
        <cau-hinh-mau-email :ma-so="{{get_user_info("maSo")}}"></cau-hinh-mau-email>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/cau-hinh-mau-email.js')}}"></script>
@endsection


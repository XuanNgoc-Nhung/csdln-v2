@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 class="page-header">Cấu hình đường dẫn logo</h1>
        </div>
    </div>
    <div id="app" class="row">
        <cau-hinh-duong-dan-logo></cau-hinh-duong-dan-logo>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/cau-hinh-duong-dan-logo.js')}}"></script>
@endsection


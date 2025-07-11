@extends("layout.app")
@section("header")
    <link rel="stylesheet" href="https://unpkg.com/vue-multiselect@2.1.0/dist/vue-multiselect.min.css">
@endsection
@section("content")
    <div class="row">
        <div>
            <h1 style="font-size: 38px"><i class="fas fa-list"></i> Yêu cầu nhập liệu </h1>
        </div>
    </div>
    <div id="app" class="row">
        <yeu-cau-nhap-lieu></yeu-cau-nhap-lieu>
    </div>

    <script src="{{asset('js/yeu-cau-nhap-lieu.js')}}"></script>

@endsection

@section("js_location")

@endsection


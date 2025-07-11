@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1><i class="fas fa-sliders-h"></i>Danh sách yêu cầu dữ liệu</h1>
        </div>
    </div>
    <div id="app" class="row">
        <danh-sach-yeu-cau-du-lieu></danh-sach-yeu-cau-du-lieu>
    </div>

    <script src="{{asset('js/danh-sach-yeu-cau-du-lieu.js')}}"></script>

@endsection

@section("js_location")

@endsection


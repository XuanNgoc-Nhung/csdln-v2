@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 style="font-size: 38px"><i class="fas fa-search"></i>  Tra Cứu Học Sinh Đồng Bộ </h1>
        </div>
    </div>
    <div id="app" class="row">
        <tra-cuu-danh-sach-hoc-sinh-dong-bo></tra-cuu-danh-sach-hoc-sinh-dong-bo>
    </div>

    <script src="{{asset('js/tra-cuu-hoc-sinh-dong-bo.js')}}"></script>

@endsection

@section("js_location")

@endsection


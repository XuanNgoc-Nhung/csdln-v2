@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <tra-cuu-danh-sach-hoc-sinh :trangcu="'{{$data}}'"></tra-cuu-danh-sach-hoc-sinh>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/tra-cuu-hoc-sinh.js')}}"></script>
@endsection


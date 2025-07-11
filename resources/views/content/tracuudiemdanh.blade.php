@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <tra-cuu-diem-danh></tra-cuu-diem-danh>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/tra-cuu-diem-danh.js')}}"></script>
@endsection


@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <hoc-sinh-giao-vien-chuyen-truong></hoc-sinh-giao-vien-chuyen-truong>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/hoc-sinh-giao-vien-chuyen-truong.js')}}"></script>
@endsection


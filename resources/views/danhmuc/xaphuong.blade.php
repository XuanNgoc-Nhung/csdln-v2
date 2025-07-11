@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-phuong-xa></dm-phuong-xa>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-phuong-xa.js')}}"></script>
@endsection


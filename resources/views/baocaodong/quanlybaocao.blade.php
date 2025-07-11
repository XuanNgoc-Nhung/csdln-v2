@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <quan-ly-bao-cao></quan-ly-bao-cao>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/quan-ly-bao-cao.js')}}"></script>
@endsection

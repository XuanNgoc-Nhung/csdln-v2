@extends("layout.app")
@section("header")
@endsection
@section("content")
    <div id="app" class="row">
        <demo-dashboard></demo-dashboard>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/demo-dashboard.js')}}"></script>
@endsection


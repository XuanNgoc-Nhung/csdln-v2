@extends("layout.app")
@section("header")
@endsection
@section("content")
    <div id="app" class="row">
        <bao-cao-dong-emis></bao-cao-dong-emis>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bao-cao-dong-emis.js')}}"></script>
@endsection


@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <bao-cao-dong></bao-cao-dong>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bao-cao-dong.js')}}"></script>
@endsection

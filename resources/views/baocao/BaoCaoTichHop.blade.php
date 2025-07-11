@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <bao-cao-tich-hop></bao-cao-tich-hop>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bao-cao-tich-hop.js')}}"></script>
@endsection

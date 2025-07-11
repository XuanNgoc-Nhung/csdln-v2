@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <bao-cao-tieu-chi></bao-cao-tieu-chi>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bao-cao-tieu-chi-v2.js')}}"></script>
@endsection

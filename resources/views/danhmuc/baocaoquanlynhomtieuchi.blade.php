@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <bao-cao-nhom-tieu-chi></bao-cao-nhom-tieu-chi>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bao-cao-nhom-tieu-chi.js')}}"></script>
@endsection

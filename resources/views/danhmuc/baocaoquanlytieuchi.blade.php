@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <bao-cao-quan-ly-tieu-chi></bao-cao-quan-ly-tieu-chi>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bao-cao-quan-ly-tieu-chi.js')}}"></script>
@endsection


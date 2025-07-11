@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-quan-huyen></dm-quan-huyen>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-quan-huyen.js')}}"></script>
@endsection


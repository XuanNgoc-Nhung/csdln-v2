@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-to-thon></dm-to-thon>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-to-thon.js')}}"></script>
@endsection


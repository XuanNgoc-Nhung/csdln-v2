@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-ton-giao></dm-ton-giao>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-ton-giao.js')}}"></script>
@endsection


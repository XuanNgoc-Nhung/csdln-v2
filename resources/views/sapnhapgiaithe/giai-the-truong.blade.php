@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <giai-the-truong></giai-the-truong>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/giai-the-truong.js')}}"></script>
@endsection

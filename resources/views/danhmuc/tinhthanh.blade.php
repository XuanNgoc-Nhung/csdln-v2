@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-tinh-thanh></dm-tinh-thanh>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-tinh-thanh.js')}}"></script>
@endsection


@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <quan-ly-cau-hoi-thuong-gap></quan-ly-cau-hoi-thuong-gap>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/cau-hoi-thuong-gap.js')}}"></script>
@endsection


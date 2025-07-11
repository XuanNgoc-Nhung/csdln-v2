@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <thong-tin-y-te-hoc-sinh></thong-tin-y-te-hoc-sinh>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/thong-tin-y-te-hoc-sinh.js')}}"></script>
@endsection


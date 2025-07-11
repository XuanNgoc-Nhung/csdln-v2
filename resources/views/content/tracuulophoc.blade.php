@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <tra-cuu-lop-hoc :trangcu="'{{$data}}'" :info="'{{json_encode(get_user_info("common_info"))}}'"></tra-cuu-lop-hoc>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/tra-cuu-lop-hoc.js')}}"></script>
@endsection


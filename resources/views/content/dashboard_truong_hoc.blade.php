@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dashboard-school :info="'{{json_encode(get_user_info("common_info"))}}'"></dashboard-school>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dashboard-school.js')}}"></script>
@endsection


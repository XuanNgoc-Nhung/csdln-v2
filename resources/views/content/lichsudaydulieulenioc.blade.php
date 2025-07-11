@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <lich-su-day-du-lieu-len-ioc :trangcu="'{{$data}}'" :info="'{{json_encode(get_user_info("common_info"))}}'"></lich-su-day-du-lieu-len-ioc>
    </div>


@endsection

@section("js_location")

    <script src="{{asset('js/lich-su-day-du-lieu-len-ioc.js')}}"></script>
@endsection


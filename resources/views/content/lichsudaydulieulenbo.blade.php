@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <lich-su-day-du-lieu-len-bo :trangcu="'{{$data}}'"></lich-su-day-du-lieu-len-bo>
    </div>


@endsection

@section("js_location")

    <script src="{{asset('js/lich-su-day-du-lieu-len-bo.js')}}"></script>
@endsection


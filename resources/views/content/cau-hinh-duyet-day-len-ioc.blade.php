@extends("layout.app") @section("content")

    <div class="row"></div>
    <div id="app" class="row">
        <cau-hinh-duyet-day-du-lieu-ioc></cau-hinh-duyet-day-du-lieu-ioc>
    </div>

@endsection
@section("js_location")
    <script src="{{asset('js/cau-hinh-duyet-day-du-lieu-ioc.js')}}"></script>
@endsection

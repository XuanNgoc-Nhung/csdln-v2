@extends("layout.app")
@section("header")

    <title>Báo cáo đơn vị || Cơ sở dữ liệu ngành</title>
@endsection
@section("content")
    <div id="app" class="row">
        <bao-cao-cho-so></bao-cao-cho-so>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bao-cao-cho-so-v2.js')}}"></script>
@endsection



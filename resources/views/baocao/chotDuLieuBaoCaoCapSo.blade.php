@extends("layout.app")
@section("header")
    <title>Chốt dữ liệu báo cáo || Cơ sở dữ liệu ngành</title>
@endsection
@section("content")
    <div id="app" class="row">
        <chot-du-lieu-bao-cao-cap-so/>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/chot-du-lieu-bao-cao-cap-so.js')}}"></script>
@endsection


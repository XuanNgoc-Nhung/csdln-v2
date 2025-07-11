@extends("layout.app")
@section("header")

    <title>Tổng hợp dữ liệu || Cơ sở dữ liệu ngành</title>
@endsection
@section("content")
    <div id="app" class="row">
        <tong-hop-du-lieu></tong-hop-du-lieu>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/tong-hop-du-lieu.js')}}"></script>
@endsection


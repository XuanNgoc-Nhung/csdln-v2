
@extends("layout.app")
@section("header")

    <title>Quản lý vai trò || Cơ sở dữ liệu ngành</title>
@endsection
@section("content")
    <div id="app" class="row">
        <quan-ly-vai-tro></quan-ly-vai-tro>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/quan-ly-vai-tro.js')}}"></script>
@endsection


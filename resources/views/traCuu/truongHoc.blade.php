@extends("layout.app")
@section("header")
    <title>Tra cứu trường học || Cơ sở dữ liệu ngành</title>
@endsection
@section("content")
    <div id="app" class="row">
        <tra-cuu-truong-hoc></tra-cuu-truong-hoc>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/tra-cuu-truong-hoc.js')}}"></script>
@endsection


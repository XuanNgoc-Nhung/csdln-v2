@extends("layout.app")
@section('header')
<title>Đồng bộ danh mục</title>
@endsection
@section("content")
    <div id="app" class="row">
        <dong-bo-danh-muc></dong-bo-danh-muc>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dong-bo-danh-muc.js')}}"></script>
@endsection

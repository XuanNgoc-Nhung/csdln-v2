@extends("layout.app")
@section("header")
    <title>Nộp dữ liệu sso || Cơ sở dữ liệu ngành</title>
@endsection
@section("content")
    <div id="app" class="row">
        <nop-du-lieu-sso></nop-du-lieu-sso>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/nop-du-lieu-sso.js')}}"></script>
@endsection


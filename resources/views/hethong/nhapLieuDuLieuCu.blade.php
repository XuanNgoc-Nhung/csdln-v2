@extends("layout.app")
@section("header")
@endsection
@section("content")
    <div id="app" class="row">
        <nhap-lieu-du-lieu-cu></nhap-lieu-du-lieu-cu>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/nhap-lieu-du-lieu-cu.js')}}"></script>
@endsection


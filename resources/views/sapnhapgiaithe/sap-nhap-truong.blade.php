@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <sap-nhap-truong></sap-nhap-truong>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/sap-nhap-truong.js')}}"></script>
@endsection

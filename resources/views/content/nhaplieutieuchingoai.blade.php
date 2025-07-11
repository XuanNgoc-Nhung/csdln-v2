@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <nhap-lieu-tieu-chi-ngoai :trangcu="'{{$data}}'"></nhap-lieu-tieu-chi-ngo>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/nhap-lieu-tieu-chi-ngoai.js')}}"></script>
@endsection


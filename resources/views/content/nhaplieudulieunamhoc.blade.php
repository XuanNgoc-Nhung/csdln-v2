@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <nhap-lieu-du-lieu-nam-hoc></nhap-lieu-du-lieu-nam-hoc>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/nhap-lieu-du-lieu-nam-hoc.js')}}"></script>
@endsection


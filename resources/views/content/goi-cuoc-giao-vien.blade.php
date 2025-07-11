@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <goi-cuoc-giao-vien></goi-cuoc-giao-vien>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/goi-cuoc-giao-vien.js')}}"></script>
@endsection

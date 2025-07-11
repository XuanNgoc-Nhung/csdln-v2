@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 class="page-header text-uppercase">Tra Cứu Lỗi</h1>
        </div>
    </div>
    <div id="app" class="row">
        <index></index>
    </div>

    <script src="{{asset('js/index.js')}}"></script>

@endsection

@section("js_location")

@endsection


@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 style="font-size: 38px"><i class="fas fa-list"></i> Tiêu chí dữ liệu </h1>
        </div>
    </div>
    <div id="app" class="row">
        <tieu-chi-du-lieu></tieu-chi-du-lieu>
    </div>

    <script src="{{asset('js/tieu-chi-du-lieu.js')}}"></script>

@endsection

@section("js_location")

@endsection


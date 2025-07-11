@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 style="font-size: 38px"><i class="fas fa-list"></i>  Lịch sử đẩy dữ liệu đặc thù  </h1>
        </div>
    </div>
    <div id="app" class="row">
        <lich-su-day-du-lieu></lich-su-day-du-lieu>
    </div>

    <script src="{{asset('js/lich-su-day-du-lieu.js')}}"></script>

@endsection

@section("js_location")

@endsection


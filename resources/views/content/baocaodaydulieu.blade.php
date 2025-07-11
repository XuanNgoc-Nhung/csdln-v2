@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 style="font-size: 38px"><i class="fas fa-list"></i>   Báo cáo đẩy dữ liệu đặc thù   </h1>
        </div>
    </div>
    <div id="app" class="row">
        <bao-cao-day-du-lieu></bao-cao-day-du-lieu>
    </div>

    <script src="{{asset('js/bao-cao-day-du-lieu.js')}}"></script>

@endsection

@section("js_location")

@endsection


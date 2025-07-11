@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 style="font-size: 38px"><i class="fas fa-list"></i>  Xem dữ liệu đặc thù  </h1>
        </div>
    </div>
    <div id="app" class="row">
        <xem-du-lieu-dac-thu></xem-du-lieu-dac-thu>
    </div>

    <script src="{{asset('js/xem-du-lieu-dac-thu.js')}}"></script>

@endsection

@section("js_location")

@endsection


@extends("layout.app")
@section("content")
    <div class="row">
        <div>
        </div>
    </div>
    <div id="app" class="row">
        <mat-khau-ket-chuyen-ioc :info="'{{json_encode(get_user_info("common_info"))}}'"></mat-khau-ket-chuyen-ioc>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/mat-khau-ket-chuyen-ioc.js')}}"></script>
@endsection


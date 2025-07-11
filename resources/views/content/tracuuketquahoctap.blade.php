@extends("layout.app")
@section("content")

    <div id="app" class="row">
        <tra-cuu-ket-qua-hoc-tap  :trangcu="'{{$data}}'"   :info="'{{json_encode(get_user_info("common_info"))}}'"></tra-cuu-ket-qua-hoc-tap>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/tra-cuu-ket-qua-hoc-tap.js')}}"></script>
@endsection


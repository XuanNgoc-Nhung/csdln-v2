@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-chuyen-nganh-dao-tao></dm-chuyen-nganh-dao-tao>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-chuyen-nganh-dao-tao.js')}}"></script>
@endsection


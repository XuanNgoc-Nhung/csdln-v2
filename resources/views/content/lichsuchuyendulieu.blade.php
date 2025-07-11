@extends("layout.app") @section("content")
<div id="app" class="row">
    <lich-su-chuyen-du-lieu :trangcu="{{$data}}"></lich-su-chuyen-du-lieu>
</div>
@endsection
@section("js_location")
<script src="{{asset('js/lich-su-chuyen-du-lieu.js')}}"></script>
@endsection
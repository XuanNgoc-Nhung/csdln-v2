@extends("layout.app") @section("content")


<div class="row"></div>
<div id="app" class="row">
    <bao-cao-tinh-hinh-nop-du-lieu></bao-cao-tinh-hinh-nop-du-lieu>
</div>

@endsection
@section("js_location")
<script src="{{asset('js/bao-cao-tinh-hinh-nop-du-lieu.js')}}"></script>
@endsection
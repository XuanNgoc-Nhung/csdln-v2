@extends("layout.app") @section("content")


<div class="row"></div>
<div id="app" class="row">
    <cau-hinh-duyet-day-du-lieu :domain="'{{$domain}}'"></cau-hinh-duyet-day-du-lieu>
</div>

@endsection
@section("js_location")
<script src="{{asset('js/cau-hinh-duyet-day-du-lieu.js')}}"></script>
@endsection
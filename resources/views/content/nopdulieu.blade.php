@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <nop-du-lieu></nop-du-lieu>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/nop-du-lieu.js')}}"></script>
@endsection


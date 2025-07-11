@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-ly-do-bo-hoc></dm-ly-do-bo-hoc>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-ly-do-bo-hoc.js')}}"></script>
@endsection


@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-mon-hoc></dm-mon-hoc>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-mon-hoc.js')}}"></script>
@endsection


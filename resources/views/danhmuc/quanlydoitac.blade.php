@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-quan-ly-doi-tac></dm-quan-ly-doi-tac>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-quan-ly-doi-tac.js')}}"></script>
@endsection


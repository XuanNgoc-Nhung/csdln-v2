@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 class="page-header"> Cập nhật đối tác </h1>
        </div>
    </div>
    <div id="app" class="row">
        <cap-nhat-doi-tac></cap-nhat-doi-tac>
    </div>

    <script src="{{asset('js/cap-nhat-doi-tac.js')}}"></script>

@endsection

@section("js_location")

@endsection


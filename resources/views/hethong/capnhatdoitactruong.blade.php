@extends("layout.app")
@section("header")

    <title>Cập nhật đối tác trường || Cơ sở dữ liệu ngành</title>
@endsection
@section("content")
    <div id="app" class="row">
        <cap-nhat-doi-tac-truong></cap-nhat-doi-tac-truong>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/cap-nhat-doi-tac-truong.js')}}"></script>
@endsection


@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <import-kiem-dinh-chat-luong></import-kiem-dinh-chat-luong>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/import-kiem-dinh-chat-luong.js')}}"></script>
@endsection

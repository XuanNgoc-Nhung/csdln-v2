@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-loai-doi-tuong></dm-loai-doi-tuong>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-loai-doi-tuong.js')}}"></script>
@endsection


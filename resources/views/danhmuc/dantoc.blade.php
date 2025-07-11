@extends("layout.app")
@section("content")
    <div id="app" class="row">
        <dm-dan-toc></dm-dan-toc>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-dan-toc.js')}}"></script>
@endsection


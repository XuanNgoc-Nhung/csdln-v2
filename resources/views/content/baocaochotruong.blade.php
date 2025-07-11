@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 class="page-header">Báo cáo cho trường</h1>
        </div>
    </div>
    <div id="app" class="row">
        <bao-cao-cho-truong></bao-cao-cho-truong>
    </div>

    <script src="{{asset('js/bao-cao-cho-truong.js')}}"></script>

@endsection

@section("js_location")

@endsection


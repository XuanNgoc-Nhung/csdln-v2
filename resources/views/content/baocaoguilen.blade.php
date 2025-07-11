@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 class="page-header"> Quản lý báo cáo cần gửi lên </h1>
        </div>
    </div>
    <div id="app" class="row">
        <bao-cao-gui-len></bao-cao-gui-len>
    </div>

    <script src="{{asset('js/bao-cao-gui-len.js')}}"></script>

@endsection

@section("js_location")

@endsection


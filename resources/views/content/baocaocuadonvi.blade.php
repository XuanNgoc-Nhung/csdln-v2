@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 class="page-header">Báo cáo của đơn vị</h1>
        </div>
    </div>
    <div id="app" class="row">
        <bao-cao-cua-don-vi></bao-cao-cua-don-vi>
    </div>

    <script src="{{asset('js/bao-cao-cua-don-vi.js')}}"></script>

@endsection

@section("js_location")

@endsection


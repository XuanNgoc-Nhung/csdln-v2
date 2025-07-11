@extends("layout.app")
@section("header")
    <style>

        @media only screen and (max-width: 991px) {
            .tenbieudo h4{
                font-size:14px;
                padding:0;
                margin:0;
            }
        }
        @media only screen and (max-width: 1140) {
            .tenbieudo h4{
                font-size:13px;
                padding:0;
                margin:0;
            }
        }
        @media only screen and (min-width: 1140) {
            .tenbieudo h4{
                font-size:13px;
                padding:0;
                margin:0;
            }
        }

    </style>
@endsection
@section("content")
    <div class="row">
        <div>
            <h3 class="page-header text-uppercase">Tổng quan</h3>
        </div>
    </div>
    <div id="app" class="row">
        <dashboard :info="'{{json_encode(get_user_info("common_info"))}}'"></dashboard>
    </div>
@endsection
@section("js_location")
    <!-- <script src="{{asset('js/dashboard3.js')}}"></script> -->
    <script src="{{asset('js/dashboard.js')}}"></script>
@endsection


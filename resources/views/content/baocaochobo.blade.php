@extends("layout.app")
@section("header")
    <style>
        a:active {
            /* background: burlywood !important; */
        }

        .xembaocao {
            /*background: red;*/
        }

        .qh {
            font-size: 18px;
            text-align: center;
        }
        .qh h3{
            font-size:18px;
        }

        .tn {
            font-size: 12px;
            text-align: center;
        }

        .vh {
            text-transform: uppercase;
        }

        .space25 {
            padding-bottom: 5px;
        }

        .space10 {
            padding-bottom: 10px;
        }

        .space20 {
            padding-bottom: 20px;
        }

        .space30 {
            padding-bottom: 30px;
        }

        .space40 {
            padding-bottom: 40px;
        }

        .space50 {
            padding-bottom: 50px;
        }

        .space60 {
            padding-bottom: 60px;
        }

        .space70 {
            padding-bottom: 70px;
        }

        .space80 {
            padding-bottom: 80px;
        }

        .space90 {
            padding-bottom: 90px;
        }

        .space100 {
            padding-bottom: 100px;
        }

        .nav-tabs > li > a {
            font-size: 12px;
        }

        .modal-header h3 {
            font-size: 18;
        }

        .tch {
            font-size: 18;
        }
        .noidung{
            font-size:12px;
        }

        @media only screen and (max-width: 991px) {
            .nav-tabs > li > a {
                font-size: 11px;
            }

            .modal-header h3 {
                font-size: 20px;
            }

            .tch {
                font-size: 12px;
            }

            .tn {
                font-size: 12px;
            }
            .red {
                font-size: 12px;
            }
            .qh {
                font-size: 12px;
            }
            .qh h3{
                font-size:18px;
             }
             
            .xembaocao {
                max-height: 58;
                overflow: scroll;
            }
            .xembaocao iframe{
                max-height: 55vh;
                overflow: scroll;
            }

        }

        @media only screen and (max-width: 1140px) {
            .nav-tabs > li > a {
                font-size: 12px;
            }

            .modal-header h3 {
                font-size: 14px;
            }

            .tch {
                font-size: 12px;
            }

            .qh {
                font-size: 12px;
            }
            .qh h3{
              font-size:12px;
            }

            .red h3{
                font-size: 15px;
            }
            .tn {
                font-size: 12px;
            }
            
            .xembaocao {
                max-height: 52vh;
                overflow: scroll;
            }
            .xembaocao iframe{
                max-height: 49vh;
                overflow: scroll;
            }
        }
        @media only screen and (min-width: 1141px) {
            .xembaocao {
                max-height: 58vh;
                overflow: scroll;
            }
            .xembaocao iframe{
                max-height: 55vh;
                overflow: scroll;
            }
        }
    </style>
@endsection
@section("content")
    <div class="row">
    </div>
    <div id="app">
        <div class="row">
            <bao-cao-cho-bo :info="'{{json_encode(get_user_info("common_info"))}}'"></bao-cao-cho-bo>
        </div>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/bao-cao-cho-bo.js')}}"></script>
@endsection


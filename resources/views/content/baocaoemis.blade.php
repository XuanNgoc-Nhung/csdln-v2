@extends("layout.app")
@section("header")
    <style>
        /* a:active {
            background: burlywood !important;
        } */

        .xembaocao {
            /*background: red;*/
        }

        .qh {
            font-size: 20px;
            text-align: center;
        }

        .tn {
            font-size: 19px;
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
            font-size: 14px;
        }
        .modal-header h3 {
            font-size: 23px;
        }
        .tch {
            font-size: 19px;
        }
        #emis1 td{
            border: 1px solid black !important;
            width:1% !important;
        }
        #emis{
            /*display: contents;*/
        }
        #emis1{
            /*display:contents;*/
        }
        @media only screen and (max-width: 991px) {
            .nav-tabs > li > a {
                font-size: 11px;
            }

            .modal-header h3 {
                font-size: 20px;
            }

            .tch {
                font-size: 17px;
            }

            .tn {
                font-size: 14px;
            }
            .red {
                font-size: 14px;
            }
            .qh {
                font-size: 19px;
            }
        }

        @media only screen and (max-width: 1140px) {
            .nav-tabs > li > a {
                font-size: 12px;
            }

            .modal-header h3 {
                font-size: 20px;
            }

            .tch {
                font-size: 17px;
            }

            .qh {
                font-size: 19px;
            }
            .red h3{
                font-size: 19px;
            }
            .tn {
                font-size: 19px;
            }
        }
    </style>
@endsection
@section("content")
    <div class="row">
        <div>
            <h1 class="page-header">Báo cáo EMIS</h1>
        </div>
    </div>
    <div id="app" class="row">
        <bao-cao-emis :info="'{{json_encode(get_user_info("common_info"))}}'"></bao-cao-emis>
    </div>


@endsection
@section("js_location")
    <script src="{{asset('js/bao-cao-emis.js')}}"></script>
@endsection


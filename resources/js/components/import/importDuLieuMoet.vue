<template>
    <div>
        <div class="tabbable">
            <ul class="nav nav-tabs wizard">
                <li :class="[class_active>=1 ? 'completed' : '', class_active==1 ? 'active': '']"
                    @click="chuyenClass1(1)"><a href="" data-toggle="tab" aria-expanded="false">Upload file</a>
                </li>
                <li :class="[class_active>=2 ? 'completed' : '', class_active==2 ? 'active': '']"
                    @click="chuyenClass1(2)"><a href="" data-toggle="tab" aria-expanded="false">Chọn vùng dữ
                        liệu</a></li>
                <li :class="[class_active>=3 ? 'completed' : '', class_active==3 ? 'active': '']"
                    @click="chuyenClass1(3)"><a href="" data-toggle="tab" aria-expanded="false">Định nghĩa dữ
                        liệu</a></li>
                <li :class="[class_active>=4 ? 'completed' : '', class_active==4 ? 'active': '']"
                    @click="chuyenClass1(4)"><a href="" data-toggle="tab" aria-expanded="true">Xác nhận thông
                        tin</a></li>
                <li :class="[class_active>=5 ? 'completed' : '', class_active==5 ? 'active': '']"
                    @click="chuyenClass1(5)"><a href="" data-toggle="tab" aria-expanded="true">Kiểm tra & import dữ
                        liệu</a>
                </li>
                <li :class="[class_active>=6 ? 'completed' : '', class_active==6 ? 'active': '']"
                    @click="chuyenClass1(6)"><a href="" data-toggle="tab" aria-expanded="true">Kết quả nhập</a>
                </li>
            </ul>
        </div>
            <!-- <div class="row">
                <div class="col-md-12">
                    <button @click="class_active--" class="btn btn-primary"  :disabled="class_active<=1">Lùi</button>
                    <button @click="class_active++" class="btn btn-danger" :disabled="buocHienTai<=class_active">Tiến</button>
                </div>
            </div> -->
            <div class="row">
                <div class="col-md-12">
                    <div style="border:1px solid #ddd; border-radius:5px;">
                        <component @BackStep="quayLaiBuocTruoc($event)" @nextStep="sangBuocTiepTheo($event)"
                            :data_step_one="duLieuBuocMot" :data_step_two="duLieuBuocHai"
                            :data_step_four="duLieuBuocBon" :data_step_three="duLieuBuocBa" :is="current_view">
                        </component>
                    </div>
                </div>
            </div>
    </div>
</template>
<script>
    $(document).ready(function () {
        console.log("thửu xem!");
        $('.tabbable').click(function () {
            return false;
        });
    });
    import UploadFile from './BuocMotUploadFile';
    import ChonVungDuLieu from './BuocHaiChonVungDuLieu';
    import DinhNghiaDuLieu from './BuocBaDinhNghiaDuLieu';
    import XacNhanThongTin from './BuocBonXacNhanThongTin';
    import KiemTraDuLieu from './BuocNamKiemTraDuLieu';
    import KetQuaNhap from './BuocSauKetQuaNhap';
    export default {
        components: {
            'UploadFile': UploadFile,
            'ChonVungDuLieu': ChonVungDuLieu,
            'DinhNghiaDuLieu': DinhNghiaDuLieu,
            'XacNhanThongTin': XacNhanThongTin,
            'KiemTraDuLieu': KiemTraDuLieu,
            'KetQuaNhap': KetQuaNhap,
        },
        watch: {
            buocHienTai: function (newVal) {
                this.chuyenClass(newVal)
            }
        },
        data() {
            return {
                duLieuBuocMot: {},
                duLieuBuocHai: {},
                duLieuBuocBa: {},
                duLieuBuocBon: {},
                class_active: 1,
                buocHienTai: 1,
                current_view: "UploadFile"
            };
        },
        methods: {
            sangBuocTiepTheo(e) {
                console.log("sang bước tiếp theo");
                console.log(e);
                this.class_active = e.step + 1;
                this.buocHienTai = e.step + 1;
                if (e.step == 1) {
                    this.duLieuBuocMot = e.data;
                    console.log("chuyển sang bước 2:");
                    console.log(JSON.stringify(e.data));
                }
                if (e.step == 2) {
                    this.duLieuBuocHai = e;
                    console.log("chuyển sang bước 2:");
                    console.log(JSON.stringify(this.duLieuBuocHai));
                    console.log(JSON.stringify("________________"));
                    console.log(JSON.stringify(this.duLieuBuocHai.data));
                }
                if (e.step == 3) {
                    this.duLieuBuocBa = e.data;
                    console.log("chuyển sang bước 2:");
                    console.log(JSON.stringify(e.data));
                }
                if (e.step == 4) {
                    this.duLieuBuocBon = e.data;
                    console.log("chuyển sang bước 4:");
                    console.log(JSON.stringify(this.duLieuBuocBon));
                }
                if (e.step == 5) {}
            },
            // quayLaiBuocTruoc

            quayLaiBuocTruoc(e) {
                console.log("sang bước tiếp theo");
                console.log(e);
                this.class_active = e - 1;
                this.buocHienTai = e - 1;
            },
            chuyenClass1() {
                console.log("click");
            },
            chuyenClass(e) {
                this.class_active = e;
                if (e == 1) {
                    this.current_view = "UploadFile"
                }
                if (e == 2) {
                    this.current_view = "ChonVungDuLieu"
                }
                if (e == 3) {
                    this.current_view = "DinhNghiaDuLieu"
                }
                if (e == 4) {
                    this.current_view = "XacNhanThongTin"
                }
                if (e == 5) {
                    this.current_view = "KiemTraDuLieu"
                }
                if (e == 6) {
                    this.current_view = "KetQuaNhap"
                }
            }
        }
    };

</script>
<style scoped="scoped">
    .nav-tabs.wizard {
        background-color: transparent;
        padding: 0;
        width: 100%;
        margin: 1em auto;
        border-radius: .25em;
        clear: both;
        border-bottom: none;
    }

    .nav-tabs.wizard li {
        width: 100%;
        float: none;
        margin-bottom: 3px;
    }

    .nav-tabs.wizard li>* {
        position: relative;
        padding: 1em .8em .8em 2.5em;
        color: #999999;
        background-color: #dedede;
        border-color: #dedede;
    }

    .nav-tabs.wizard li.completed>* {
        color: #fff !important;
        background-color: #96c03d !important;
        border-color: #96c03d !important;
        border-bottom: none !important;
    }

    .nav-tabs.wizard li.active>* {
        color: #fff !important;
        background-color: #4CAF50 !important;
        border-color: #4CAF50 !important;
        border-bottom: none !important;
    }

    /* .nav-tabs.wizard li::after:last-child {
        border: none;
    } */

    .nav-tabs.wizard>li>a {
        opacity: 1;
        font-size: 12px;
    }

    .nav-tabs.wizard a:hover {
        color: #fff;
        background-color: #2c3f4c;
        border-color: #2c3f4c
    }

    .nav-tabs.wizard li {
        position: relative;
        padding: 0;
        margin: 4px 4px 4px 0;
        width: 15.2%;
        float: left;
        text-align: center;
    }

    .nav-tabs.wizard li.active a {
        padding-top: 13px;
    }

    .nav-tabs.wizard li::after,
    .nav-tabs.wizard li>*::after {
        content: '';
        position: absolute;
        top: 0;
        left: 100%;
        height: 0;
        width: 0;
        border: 20px solid transparent;
        border-right-width: 0;
        /*border-left-width: 20px*/
    }

    .nav-tabs.wizard li::after {
        z-index: 1;
        -webkit-transform: translateX(4px);
        -moz-transform: translateX(4px);
        -ms-transform: translateX(4px);
        -o-transform: translateX(4px);
        transform: translateX(4px);
        border-left-color: #fff;
        margin: 0
    }

    .nav-tabs.wizard li>*::after {
        z-index: 2;
        border-left-color: inherit
    }

    .nav-tabs.wizard>li:nth-of-type(1)>a {
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }

    /* .nav-tabs.wizard li:last-child a {
        border-top-right-radius: 10px;
        border-bottom-right-radius: 10px;
    } */

    /* .nav-tabs.wizard li:last-child {
        margin-right: 0;
    } */

    /* .nav-tabs.wizard li:last-child a:after,
    .nav-tabs.wizard li:last-child:after {
        content: "";
        border: none;
    } */

    span.nmbr {
        display: block;
    }

</style>

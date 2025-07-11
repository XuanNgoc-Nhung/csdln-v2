<template>
    <div
        id="BcCanBoTheoTrinhDoDaoTao"
        ref="BcCanBoTheoTrinhDoDaoTao"
        class="modal fade giam-han">
        <div class="modal-dialog" style="width: 90%; margin: 0 auto !important;">
            <div class="modal-content">
                <div class="modal-header" style="position: relative">
                    <button
                        type="button"
                        class="close btn btn-danger"
                        style="position: absolute; top: 2px; right: 2px;"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="close()">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-sm-8 col-md-7">
                            <h3 class="modal-title vh">{{tenbc}}
                                <br>
                                    <div class="tch">
                                        <span v-if="capHoc==1">Tiểu học</span>
                                        <span v-else-if="capHoc==2">Trung học Cơ sở</span>
                                        <span v-else-if="capHoc==3">Trung học Phổ thông</span>
                                        <span v-else-if="capHoc==5">Mẫu giáo</span>
                                        <span v-else-if="capHoc==4">Nhà trẻ</span>
                                        <span v-else-if="capHoc==6">Giáo dục thường xuyên</span>
                                        <span v-else="v-else">Cấp học chưa xác định</span>
                                    </div>
                                </h3>
                            </div>
                            <div class="col-md-5 col-sm-4 pull-right">
                                <div class="row" style="display:flex">
                                    <div class="text-right" style="width:48%">
                                        <label>Năm học
                                            <sup class="red">*</sup>
                                            :</label>
                                    </div>
                                    <div style="width:50%">
                                        <select class="form-control" style="width:90%; height:30px;" v-model="namHoc">
                                            <option class="form-control" value=''>Chọn năm học</option>
                                            <option class="form-control" v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div>
                                <form role="form" class="row">
                                    <div
                                        class="col-lg-4 col-md-4 col-sm-4">
                                        <label>Đơn vị :</label>
                                        <div
                                        v-if="this.dangNhap.role==2||this.dangNhap.role==3" style="border-radius:4px;">
                                            <ejs-multiselect
                                                style="border:none !improtant;"
                                                class="form-control"
                                                id="multiselect"
                                                v-model="dsDonVi"
                                                :showClearButton='false'
                                                :dataSource="listDonVi"
                                                placeholder="Chọn đơn vị"
                                                :allowFiltering='true'
                                                :filtering='timDonVi'
                                                mode="CheckBox"
                                                :fields="dsdv"
                                                :showSelectAll="showSelectAll"
                                                selectAllText="Chọn tất cả"
                                                unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect>
                                        </div>
                                        <div v-if="this.dangNhap.role==4">
                                            <select
                                                disabled="disabled"
                                                @change="onDonViChange()"
                                                v-model="madonvi"
                                                class="form-control">
                                                <option v-for="dv in listDonVi" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div v-if="this.dangNhap.role!=5">
                                        <div class="col-lg-4 col-md-4 col-sm-4">
                                            <label>Trường:</label>
                                            <div style="border-radius:4px;">
                                                <ejs-multiselect
                                                    style="border:none !improtant;"
                                                    class="form-control"
                                                    id="multiselect"
                                                    v-model="dsTruongHoc"
                                                    :dataSource="listTruongHoc"
                                                :allowFiltering='true'
                                                :filtering='timTruongHoc'
                                                    placeholder="Chọn trường học"
                                                    mode="CheckBox"
                                                    :fields="dsth"
                                                    :showClearButton='false'
                                                    :showSelectAll="showSelectAll"
                                                    selectAllText="Chọn tất cả"
                                                    unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div v-if="this.dangNhap.role==5">
                                            <div class="col-lg-4 col-md-4 col-sm-4">
                                                <label>Trường:</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    disabled="disabled"
                                                    :value="dangnhap.display_name"/></div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <div style="padding-top:24px;" class="text-left">
                                            <button class="btn btn-primary" style=" width:30%;" @click.prevent="getData()">Tìm kiếm</button>
                                            <button
                                                v-if="Report.length>0"
                                                style="width:30%"
                                                @click.prevent="exPort()"
                                                class="btn btn-success">Xuất Excel</button>
                                            <button
                                                v-if="Report.length>0"
                                                style="width:30%"
                                                @click.prevent="exPortPDF()"
                                                class="btn btn-info">Xuất PDF</button>
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <hr>
                            <div style="padding-top: 10px">
                                <div v-if="Report.length>0" class="text-center">
                                    <div v-if="pdf">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="pull-right">
                                                    <button @click="pdf=false" class="btn btn-danger">
                                                        <i class="fas fa-backward"></i>
                                                        Quay lại
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12 xembaocao">
                                                <iframe style="width:100%; height:100vh" :src="linkPdf"></iframe>
                                            </div>
                                        </div>
                                    </div>
                                    <div v-else="v-else">
                                        <div class=" xembaocao form-group clearfix">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="tn vh">
                                                            <b>{{TieuDe.tenDonViQuanLy}}</b>
                                                        </th>
                                                        <th colspan="9" class="qh vh">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="3" class="tn vh">
                                                            <b>{{TieuDe.tenDonVi}}</b>
                                                        </th>
                                                        <th colspan="9" class="tn">Độc lập - Tự do - Hạnh phúc</th>
                                                    </tr>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="12" class="text-uppercase red text-center">
                                                            <h3>
                                                                {{TieuDe.reportTitle}}</h3>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="12" class="text-uppercase red text-center">
                                                            <h3>Năm học:
                                                                {{TieuDe.namHoc}}-{{TieuDe.namHoc + 1}}</h3>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                        <th style="border-bottom: 1px solid black;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody class="noidung">
                                                    <tr>
                                                        <th>STT</th>
                                                        <th>Tên trường</th>
                                                        <th>Tổng số cán bộ</th>
                                                        <th>Cấp tốc</th>
                                                        <th>Sơ cấp</th>
                                                        <th>Trung cấp</th>
                                                        <th>Cao đẳng</th>
                                                        <th>Đại học</th>
                                                        <th>Thạc sỹ</th>
                                                        <th>Tiến sỹ</th>
                                                        <th>T.S khoa học</th>
                                                        <th>khác</th>
                                                    </tr>
                                                    <tr v-for="(ctbc,i) in Report" style="background: white;">
                                                        <td>{{i+1}}</td>
                                                        <td>{{ctbc.tenTruongHoc}}</td>
                                                        <td>{{ctbc.soLuongTong}}</td>
                                                        <td>{{ctbc.soLuongCapToc}}</td>
                                                        <td>{{ctbc.soLuongSoCap}}</td>
                                                        <td>{{ctbc.soLuongTrungCap}}</td>
                                                        <td>{{ctbc.soLuongCaoDang}}</td>
                                                        <td>{{ctbc.soLuongDaiHoc}}</td>
                                                        <td>{{ctbc.soLuongThacSi}}</td>
                                                        <td>{{ctbc.soLuongTienSi}}</td>
                                                        <td>{{ctbc.soLuongTsKhoaHoc}}</td>
                                                        <td>{{ctbc.soLuongKhac}}</td>
                                                    </tr>
                                                    <tr style="background: white;">
                                                        <td colspan="2">Tổng cộng:</td>
                                                        <td>{{TieuDe.tongSo.soLuongTong}}</td>
                                                        <td>{{TieuDe.tongSo.soLuongCapToc}}</td>
                                                        <td>{{TieuDe.tongSo.soLuongSoCap}}</td>
                                                        <td>{{TieuDe.tongSo.soLuongTrungCap}}</td>
                                                        <td>{{TieuDe.tongSo.soLuongCaoDang}}</td>
                                                        <td>{{TieuDe.tongSo.soLuongDaiHoc}}</td>
                                                        <td>{{TieuDe.tongSo.soLuongThacSi}}</td>
                                                        <td>{{TieuDe.tongSo.soLuongTienSi}}</td>
                                                        <td>{{TieuDe.tongSo.soLuongTsKhoaHoc}}</td>
                                                        <td>{{TieuDe.tongSo.soLuongKhac}}</td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div v-else="v-else" class="text-center">
                                    <p>Không có dữ liệu</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <script>
            import rest_api from '../../../utils/rest_api';
            import array_util from '../../../utils/array_utils';
            import constant from "../../../utils/constant";
            import utils from '../../../utils';
            import api from './../../api';
        import {Query} from '@syncfusion/ej2-data';

            export default {

                props: [
                    'item', 'show', 'dangnhap', 'tenbaocao', 'ten'
                ],

                data() {
                    return {
                        date: new Date(),
                        list_years: constant.LIST_YEARS_FULL,
                        madonvi: '',
                        namHoc: '',
                        collectionName: '',
                        listDonVi: [],
                        TieuDe: '',
                        Report: [],
                        listTruongHoc: [],
                        matruonghoc: '',
                        capHoc: '',
                        linkPdf: '',
                        tenbc: '',
                        dangNhap: {},
                        pdf: false,

                        showSelectAll: true,
                        dsDonVi: [],
                        dsTruongHoc: [],
                        dsdv: {
                            text: "tenDonVi",
                            value: "maDonVi"
                        },
                        dsth: {
                            text: "tenTruongHoc",
                            value: "maTruongHoc"
                        }
                    }
                },
                watch: {
                    show: function (newVal, oldVal) {
                        if (newVal) {
                            $("#BcCanBoTheoTrinhDoDaoTao").modal();
                        } else {
                            $("#BcCanBoTheoTrinhDoDaoTao").modal('hide');
                        }
                    },
                    item: function (newVal) {
                        this.capHoc = newVal;
                        this.lsCapHoc = [];
                        this
                            .lsCapHoc
                            .push(this.capHoc);
                        this.getDanhSachTruongHoc();
                    },
                    dangnhap: function (newVal) {
                        // this.dangNhap = newVal; this.matinhthanh = newVal.province;
                        // console.log(JSON.stringify(this.matinhthanh)) this.getDonVi(); this.madonvi =
                        // this.dangNhap.ma_don_vi; this.getTruongHoc();
                    },
                    tenbaocao: function (newVal) {
                        this.collectionName = newVal;
                    },
                    dsDonVi: function (newVal) {

                        // array_util.clearArrays(this.dsTruongHoc);
                        this.listTruongHoc = [];
                        this.dsTruongHoc = [];
                        this.lsMaDonVi = newVal;
                        this.getDanhSachTruongHoc();
                    }
                },
                mounted: function () {
                    this.namHoc = this
                        .date
                        .getFullYear();
                    $(this.$refs.BcCanBoTheoTrinhDoDaoTao).on("hidden.bs.modal", this.close);
                    console.log("cấp học:" + JSON.stringify(this.item))
                    this.capHoc = this.item;
                    this.lsCapHoc = [];
                    this
                        .lsCapHoc
                        .push(this.capHoc);
                    this.dangNhap = this.dangnhap;
                    this.getDonVi();
                    this.collectionName = this.tenbaocao;
                    this.madonvi = this.dangnhap.ma_don_vi;
                    this.tenbc = this.ten;
                    this.getDanhSachTruongHoc();
                },
                methods: {
            timDonVi: function (args) {
                var searchData = this.listDonVi;
                var query = new Query();
                query = (args.text != "")
                    ? query.where("tenDonVi", "contains", args.text, true)
                    : query;
                args.updateData(searchData, query);
            },
            timTruongHoc: function (args) {
                var searchData = this.listTruongHoc;
                var query = new Query();
                query = (args.text != "")
                    ? query.where("tenTruongHoc", "contains", args.text, true)
                    : query;
                args.updateData(searchData, query);
            },

                    getDanhSachTruongHoc() {
                        array_util.clearArrays(this.listTruongHoc);
                        let params = {
                            ma: this.maTruong,
                            maDonVi: this.lsMaDonVi,
                            capHoc: this.lsCapHoc
                        };

                        rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                            console.log(
                                "lấy danh sách trường học theo list mã đơn vị trả về:" + JSON.stringify(data)
                            )
                            if (data.data != null) {
                                if (data.data.code == 200) {
                                    array_util.clearArrays(this.listTruongHoc);
                                    this.listTruongHoc = data.data.rows;
                                } else {
                                    this.listTruong = [];
                                    this.listTruongHoc = [
                                        {
                                            "maTruongHoc": "",
                                            "tenTruongHoc": "Danh sách trường học trống"
                                        }
                                    ];
                                }
                            }
                        });
                    },
                    exPort() {
                        let url = "xuat-excel";
                        if (this.dangnhap.role == 5) {
                            this.dsTruongHoc = [this.dangnhap.ma_truong_hoc]
                        }
                        let params = {
                            "capHoc": this.capHoc,
                            "namHoc": this.namHoc,
                            "collectionName": this.collectionName,
                            "maTruongs": this.dsTruongHoc,
                            "maDonVis": this.dsDonVi
                        };
                        api.post(url, params, (data) => {
                            let a = document.createElement('a');
                            a.href = data.data.file;
                            document
                                .body
                                .appendChild(a);
                            a.click();
                            document
                                .body
                                .removeChild(a);
                        });

                    },
                    exPortPDF() {
                        let url = "xuat-bao-cao-pdf";
                        if (this.dangnhap.role == 5) {
                            this.dsTruongHoc = [this.dangnhap.ma_truong_hoc]
                        }
                        let params = {
                            "capHoc": this.capHoc,
                            "namHoc": this.namHoc,
                            "collectionName": this.collectionName,
                            "maTruongs": this.dsTruongHoc,
                            "maDonVis": this.dsDonVi
                        };
                        api.post(url, params, (data) => {
                            if (data.data.rc == -1) {
                                this.linkPdf = data.data.file;
                                console.log("link file PDF:" + this.linkPdf);
                                this.pdf = true;
                            }
                        });

                    },
                    getData() {
                        if (this.namHoc == "" || this.capHoc == "" || this.madonvi == "") {
                            utils.showDialog("Thông báo", "Vui lòng kiểm tra lại thông tin");
                            return;
                        }
                        array_util.clearArrays(this.Report);
                        this.TieuDe = '';
                        if (this.dangnhap.role == 5) {
                            this.dsTruongHoc = [this.dangnhap.ma_truong_hoc]
                        }
                        let params = {
                            "capHoc": this.capHoc,
                            "namHoc": this.namHoc,
                            "collectionName": this.collectionName,
                            "maTruongs": this.dsTruongHoc,
                            "maDonVis": this.dsDonVi,
                            "maDonVi": this.madonvi
                        };
                        rest_api.post("/csdlgd-report-api/baoCao/report/", params, (data) => {
                            if (data.data.rc === 0) {
                                this.TieuDe = data.data;
                                this.Report = data.data.reportData;
                                if (this.Report.length == 0) {
                                    utils.showDialog(
                                        "Thông báo",
                                        "Không có bản ghi nào được tìm thấy",
                                        null,
                                        () => {}
                                    );

                                }
                            }
                        });
                    },
                    getDonVi() {
                        let params = {
                            "start": 0,
                            "limit": 9999,
                            "maTinhThanh": this.dangNhap.province
                        };
                        rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                            if (array_util.isArray(data.data.rows)) {
                                array_util.clearArrays(this.listDonVi);
                                this.listDonVi = data.data.rows;
                            }

                        });
                    },
                    onDonViChange() {
                        if (this.madonvi == '') {
                            return;
                        }
                        this.matruonghoc = '';
                        this.getTruongHoc();
                    },
                    getTruongHoc() {
                        let params = {
                            "start": 0,
                            "limit": 9999,
                            "madonvi": this.madonvi,
                            "caphoc": this.capHoc
                        };
                        rest_api.get("/internal-api/dmTruongHoc/filter", params, (data) => {
                            if (array_util.isArray(data.data.rows)) {
                                array_util.clearArrays(this.listTruongHoc);
                                this.listTruongHoc = data.data.rows;
                            }
                        });
                    },
                    close() {
                        this.reset();
                        this.$emit('close');
                    },
                    reset() {
                        this.Report = '';
                        this.namHoc = this
                            .date
                            .getFullYear();
                        this.matruonghoc = '';
                        if (this.dangNhap.role != 4) {
                            this.madonvi = this.dangNhap.ma_don_vi;
                        }
                        this.pdf = false;

                        this.dsDonVi = [];
                        this.dsTruongHoc = [];
                        this.listTruongHoc = [];
                        this.lsCapHoc = [];
                    }
                }
            }
        </script>

        <style scoped="scoped">
            h3 {
                margin: 0;
                font-weight: bold;
            }

            .red {
                color: #DC0101;
            }

            /* .xembaocao {
        max-height: 600px;
        overflow: scroll;
    } */

            .noidung {
                height: 400px;
                overflow-x: scroll;
            }

            .noidung th,
            td {
                border: 1px solid black !important;
            }
        </style>
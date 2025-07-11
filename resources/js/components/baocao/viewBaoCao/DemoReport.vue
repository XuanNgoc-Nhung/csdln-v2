<template>
    <div
        id="BcTinhHinhHocSinhTotNghiep"
        ref="BcTinhHinhHocSinhTotNghiep"
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
                            <h3 class="modal-title vh">{{ten}}
                                <br>
                                    <div class="tch">
                                        <span v-if="capHoc==1">Tiểu học</span>
                                        <span v-else-if="capHoc==2">Trung học Cơ sở</span>
                                        <span v-else-if="capHoc==3">Trung học Phổ thông</span>
                                        <span v-else-if="capHoc==5">Mẫu giáo</span>
                                        <span v-else-if="capHoc==4">Nhà trẻ</span>
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
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <label>Đơn vị
                                            <sup class="red">*</sup>:</label>
                                        <select
                                            v-if="this.dangNhap.role==2||this.dangNhap.role==3"
                                            @change="onDonViChange()"
                                            v-model="madonvi"
                                            class="form-control">
                                            <option v-for="dv in listDonVi" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                                        </select>
                                        <select
                                            v-if="this.dangNhap.role==4"
                                            disabled="disabled"
                                            @change="onDonViChange()"
                                            v-model="madonvi"
                                            class="form-control">
                                            <option v-for="dv in listDonVi" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4">
                                        <label>Trường:</label>
                                        <select class="form-control" v-model="matruonghoc">
                                            <option value=''>Chọn trường</option>
                                            <option v-for="th in listTruongHoc" :value="th.maTruongHoc">
                                                {{th.tenTruongHoc}}
                                            </option>
                                        </select>
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
                            <!-- <div v-if="Report.length>0" class="row"> <div class="col-md-12"> <div
                            class="pull-right"> <button @click="exPort()" class="btn btn-success">Xuất
                            Excel</button> <button class="btn btn-info" @click="exPortPDF()">Xuất
                            PDF</button> </div> </div> </div> -->
                        </div>
                        <div style="padding-top: 10px">
                            <div v-if="Report.length==0" class="text-center">
                                <div>
                                    <div class="xembaocao form-group clearfix">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th colspan="5" class="tn vh">
                                                        <b>UBND Tỉnh quảng ninh</b>
                                                    </th>
                                                    <th colspan="12" class="qh vh">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</th>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" class="tn vh">
                                                        <b>SỞ GIÁO DỤC VÀ ĐÀO TẠO TỈNH QUẢNG NINH</b>
                                                    </th>
                                                    <th colspan="12" class="tn">Độc lập - Tự do - Hạnh phúc</th>
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
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                                <tr>
                                                    <th colspan="17" class="text-uppercase red text-center">
                                                        <h3>ĐÁNH GIÁ SỰ PHÁT TRIỂN CỦA TRẺ</h3>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th colspan="17" class="text-uppercase red text-center">
                                                        <h3>Năm học:2019-2020</h3>
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
                                                    <th style="border-bottom: 1px solid black;"></th>
                                                    <th style="border-bottom: 1px solid black;"></th>
                                                    <th style="border-bottom: 1px solid black;"></th>
                                                    <th style="border-bottom: 1px solid black;"></th>
                                                    <th style="border-bottom: 1px solid black;"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="noidung">
                                                <tr style="background:#f6f6f6">
                                                    <th rowspan="2" class="cg">
                                                        <p>STT</p>
                                                    </th>
                                                    <th rowspan="2" class="cg">
                                                        <p>Trường</p>
                                                    </th>
                                                    <th rowspan="2" class="cg">
                                                        <p>Tổng số trẻ</p>
                                                    </th>
                                                    <th colspan="7" class="cg">
                                                        <p>Nhà trẻ</p>
                                                    </th>
                                                    <th colspan="7" class="cg">
                                                        <p>Mẫu giáo</p>
                                                    </th>
                                                </tr>
                                                <tr style="background:#f6f6f6">
                                                    <th class="cg">
                                                        <p>Tổng số</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Khám sức khỏe định kỳ</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Theo dõi biểu đồ cân nặng</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Theo dõi biểu đồ chiều cao</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Suy dinh dưỡng thể thấp còi</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Trẻ bị phổi, ỉa chảy, hô hấp</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Trẻ bị bệnh béo phì</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Tổng số</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Khám sức khỏe định kỳ</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Theo dõi biểu đồ cân nặng</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Theo dõi biểu đồ chiều cao</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Suy dinh dưỡng thể thấp còi</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Trẻ bị phổi, ỉa chảy, hô hấp</p>
                                                    </th>
                                                    <th class="cg">
                                                        <p>Trẻ bị bệnh béo phì</p>
                                                    </th>
                                                </tr>
                                                <tr style="background:white">
                                                    <td>1</td>
                                                    <td>Trường Mầm Non Hoa Ban</td>
                                                    <td>234</td>
                                                    <td>45</td>
                                                    <td>45</td>
                                                    <td>21</td>
                                                    <td>26</td>
                                                    <td>112</td>
                                                    <td>29</td>
                                                    <td>12</td>
                                                    <td>52</td>
                                                    <td>45</td>
                                                    <td>45</td>
                                                    <td>21</td>
                                                    <td>21</td>
                                                    <td>12</td>
                                                    <td>52</td>
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
                    dangNhap: {},
                    Report: [],
                    TieuDe: '',
                    capHoc: '',
                    listTruongHoc: [],
                    matruonghoc: '',
                    linkPdf: '',
                    pdf: false
                }
            },

            watch: {
                show: function (newVal, oldVal) {
                    if (newVal) {
                        $("#BcTinhHinhHocSinhTotNghiep").modal();
                    } else {
                        $("#BcTinhHinhHocSinhTotNghiep").modal('hide');
                    }
                },
                item: function (newVal) {
                    this.capHoc = newVal;
                    this.getTruongHoc();
                },
                dangnhap: function (newVal) {
                    this.dangNhap = newVal;
                    this.matinhthanh = newVal.province;
                    this.getDonVi();
                    this.madonvi = this.dangNhap.ma_don_vi;
                    this.getTruongHoc();
                },
                tenbaocao: function (newVal) {
                    this.collectionName = newVal;

                }
            },
            mounted: function () {
                this.namHoc = this
                    .date
                    .getFullYear();
                $(this.$refs.BcTinhHinhHocSinhTotNghiep).on("hidden.bs.modal", this.close);
                console.log("cấp học:" + JSON.stringify(this.item))
                this.capHoc = this.item;
                this.dangNhap = this.dangnhap;
                this.getDonVi();
                this.collectionName = this.tenbaocao;
                this.madonvi = this.dangnhap.ma_don_vi;
                this.getTruongHoc();

            },
            methods: {

                exPort() {
                    let url = "xuat-excel";
                    let params = {
                        "capHoc": this.capHoc,
                        "namHoc": this.namHoc,
                        "collectionName": this.collectionName,
                        "maTruongHoc": this.matruonghoc,
                        "maDonVi": this.madonvi
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
                    let params = {
                        "capHoc": this.capHoc,
                        "namHoc": this.namHoc,
                        "collectionName": this.collectionName,
                        "maTruongHoc": this.matruonghoc,
                        "maDonVi": this.madonvi
                    };
                    api.post(url, params, (data) => {
                        if (data.data.rc == -1) {
                            this.linkPdf = data.data.file;
                            this.pdf = true;
                        }
                    });

                },
                getData() {
                    if (this.namHoc == "" || this.capHoc == "" || this.madonvi == "") {
                        utils.showDialog("Thông báo", "Vui lòng kiểm tra lại thông tin");
                        return;
                    }
                    let params = {
                        "capHoc": this.capHoc,
                        "namHoc": this.namHoc,
                        "collectionName": this.collectionName,
                        "maTruongHoc": this.matruonghoc,
                        "maDonVi": this.madonvi
                    };
                    if (this.capHoc == 1) {
                        params.collectionName = "BcTinhHinhHsTotNghiepTieuHoc";
                    };
                    console.log("param lấy dữ liệu:" + JSON.stringify(params));
                    array_util.clearArrays(this.Report);
                    this.TieuDe = '';
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
                        } else {
                            utils.showDialog("Thông báo", data.data.rd, null, () => {});
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
                    array_util.clearArrays(this.listTruongHoc);
                    this.matruonghoc = '';
                    if (this.madonvi == '') {
                        return;
                    }
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
                    this.matruonghoc = '';
                    this.namHoc = this
                        .date
                        .getFullYear();
                    if (this.dangNhap.role != 4) {
                        this.madonvi = this.dangNhap.ma_don_vi;
                    }
                    this.pdf = false;
                }
            }
        }
    </script>

    <style scoped="scoped">
        p{
            margin: 0;
            padding: 0;
        }
        h3 {
            margin: 0;
            font-weight: bold;
        }

        .red {
            color: #DC0101;
        }

        .noidung {
            height: 400px;
            overflow-x: scroll;
        }

        /* .xembaocao {
        max-height: 600px;
        overflow: scroll;
    } */

        .noidung th,
        td {
            border: 1px solid black !important;
        }
        .cg {
            text-align: center;
            vertical-align: middle;
        }
    </style>
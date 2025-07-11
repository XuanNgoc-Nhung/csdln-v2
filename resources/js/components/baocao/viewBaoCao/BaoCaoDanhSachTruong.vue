<template>
    <div id="BcDanhSachTruong" ref="BcDanhSachTruong" class="modal fade giam-han">
        <div class="modal-dialog" style="width: 90%; margin: 0 auto !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="close()">&times;</button>
                    <h3 class="modal-title vh">
                        Báo Cáo Danh Sách Trường Học
                        <br/>

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
                <div class="modal-body clearfix">
                    <div style="padding-top: 10px">
                        <form role="form" class="form-inline">
                            <!-- <label>Năm học: <sup class="red">*</sup></label>-->
                            <!-- <select class="form-control" v-model="namHoc">-->
                            <!-- <option value=''>Chọn năm học</option>-->
                            <!-- <option v-for="y in list_years" :value="y.id">{{y.name}}</option>-->
                            <!-- </select>-->
                            <label>
                                Đơn vị quản lý:
                                <sup class="red">*</sup>
                            </label>
                            <select
                                v-if="this.dangNhap.role==2||this.dangNhap.role==3"
                                v-model="madonvi"
                                class="form-control">
                                <option value="value">Chọn đơn vị quản lý</option>
                                <option v-for="dv in listDonVi" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                            </select>
                            <select
                                v-if="this.dangNhap.role==4"
                                disabled="disabled"
                                @change="onDonViChange()"
                                v-model="madonvi"
                                class="form-control">
                                <option value="value">Chọn đơn vị quản lý</option>
                                <option v-for="dv in listDonVi" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                            </select>
                            <button
                                style="background: #008080 !important"
                                class="btn btn-success"
                                v-on:click.prevent="getTruongHoc()">
                                <i class="fa fa-search"></i>Tìm Kiếm
                            </button>
                            <button
                                v-if="listTruongHoc.length>0"
                                @click.prevent="exPort()"
                                class="btn btn-success">Xuất Excel</button>
                            <button
                                v-if="listTruongHoc.length>0"
                                @click.prevent="exPortPDF()"
                                class="btn btn-info">Xuất PDF</button>
                        </form>
                    </div>
                    <hr/>
                    <div style="padding-top: 10px">
                        <div v-if="listTruongHoc.length>0">
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
                            <div v-else="v-else" class="text-center">
                                <div class="xembaocao form-group clearfix">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="2" class="tn vh">
                                                    <b>UBND
                                                        {{soBaoCao.tenTinhThanh}}</b>
                                                </th>
                                                <th colspan="8" class="qh vh">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</th>
                                            </tr>
                                            <tr>
                                                <th colspan="2" class="tn vh">
                                                    <b>Sở giáo dục và đào tạo
                                                        {{soBaoCao.tenTinhThanh}}</b>
                                                </th>
                                                <th colspan="8" class="tn">Độc lập - Tự do - Hạnh phúc</th>
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
                                            </tr>
                                            <tr>
                                                <th colspan="14" class="text-uppercase red text-center">
                                                    <h3>Báo cáo danh sách trường học</h3>
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
                                            </tr>
                                        </thead>
                                        <tbody class="noidung">
                                            <tr class="text-center cg">
                                                <th class="text-center">
                                                    <p>STT</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Trường</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Loại hình đào tạo</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Loại hình trường</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Ngày thành lập</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>SĐT</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Chuẩn quốc gia</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Vùng khó khăn</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Vùng biên giới</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Chi bộ đảng</p>
                                                </th>
                                            </tr>
                                            <tr v-for="(ctbc,i) in listTruongHoc" style="background: white;">
                                                <td>
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <p>{{ctbc.tenTruongHoc}}</p>
                                                </td>
                                                <td>
                                                    <p v-if="ctbc.loaiHinhDaoTao==1">Công lập</p>
                                                    <p v-else-if="ctbc.loaiHinhDaoTao==2">Tư thục</p>
                                                    <p v-else-if="ctbc.loaiHinhDaoTao==3">GDTX</p>
                                                    <p v-else-if="ctbc.loaiHinhDaoTao==4">Bán công</p>
                                                    <p v-else-if="ctbc.loaiHinhDaoTao==5">Dân lập</p>
                                                    <p v-else="v-else">Chưa xác định</p>
                                                </td>
                                                <td>
                                                    <p v-if="ctbc.loaiHinhTruong==1">Trường bình thường</p>
                                                    <p v-else-if="ctbc.loaiHinhTruong==2">Dân tộc nội trú</p>
                                                    <p v-else-if="ctbc.loaiHinhTruong==3">Khuyết tật</p>
                                                    <p v-else-if="ctbc.loaiHinhTruong==4">Năng khiếu, nghệ thuật</p>
                                                    <p v-else-if="ctbc.loaiHinhTruong==5">Năng khiếu TDTT</p>
                                                    <p v-else-if="ctbc.loaiHinhTruong==6">Trường chuyên</p>
                                                    <p v-else-if="ctbc.loaiHinhTruong==7">Dân tộc bán trú</p>
                                                    <p v-else-if="ctbc.loaiHinhTruong==8">Trường THPT kỹ thuật</p>
                                                    <p v-else-if="ctbc.loaiHinhTruong==9">Trường trẻ em thiệt thòi</p>
                                                    <p v-else="v-else">Chưa xác định</p>
                                                </td>
                                                <td>
                                                    <p>{{ctbc.ngayThanhLap}}</p>
                                                </td>
                                                <td>
                                                    <p>{{ctbc.sdt}}</p>
                                                </td>
                                                <td>
                                                    <p>{{parseInt(ctbc.chuanQuocGia)=== 1 ? 'Có' : 'Không'}}</p>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{parseInt(ctbc.vungBienGioi)=== 1 ? 'Có' : 'Không'}}
                                                    </p>
                                                </td>
                                                <td>

                                                    <p>
                                                        {{parseInt(ctbc.vungBienGioi)=== 1 ? 'Có' : 'Không'}}</p>
                                                </td>
                                                <td>
                                                    <p>
                                                        {{parseInt(ctbc.chiBoDang)=== 1 ? 'Có' : 'Không có'}}</p>
                                                </td>
                                            </tr>
                                            <tr style="background: white;">
                                                <td colspan="2">Tổng cộng:</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
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
    import rest_api from "../../../utils/rest_api";
    import array_util from "../../../utils/array_utils";
    import constant from "../../../utils/constant";
    import utils from "../../../utils";
    import {Query} from '@syncfusion/ej2-data';
    import api from "./../../api";

    export default {
        props: [
            "item", "show", "dangnhap", "tenbaocao"
        ],
        data() {
            return {
                date: new Date(),
                list_years: constant.LIST_YEARS_FULL,
                madonvi: "",
                dangNhap: {},
                pdf: false,
                linkPdf: '',
                namHoc: "",
                collectionName: "",
                listDonVi: [],
                capHoc: "",
                Report: "",
                listTruongHoc: [],
                matruonghoc: "",
                soBaoCao: {}
            };
        },
        watch: {
            show: function (newVal, oldVal) {
                if (newVal) {
                    $("#BcDanhSachTruong").modal();
                } else {
                    $("#BcDanhSachTruong").modal("hide");
                }
            },
            item: function (newVal) {
                this.capHoc = newVal;
                console.log("999999999");
                this.getTruongHoc();
            },
            dangnhap: function (newVal) {
                this.dangNhap = newVal;
                if (this.dangNhap.role == 4) {
                    this.madonvi = this.dangNhap.ma_don_vi;
                    this.getTruongHoc();
                }
            },
            tenbaocao: function (newVal) {
                this.collectionName = newVal;
            }
        },
        mounted: function () {
            this.namHoc = this
                .date
                .getFullYear();
            $(this.$refs.BcDanhSachTruong).on("hidden.bs.modal", this.close);
            this.capHoc = this.item;
            this.dangNhap = this.dangnhap;
            this.matinhthanh = this.dangnhap.province;
            console.log("THông tin đăng nhập:" + JSON.stringify(this.dangNhap));
            this.collectionName = this.tenbaocao;
            this.getTinhThanh();
            this.getDonVi();
            this.madonvi = this.dangnhap.ma_don_vi;
            this.getTruongHoc();
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
            getTinhThanh() {
                let params = {
                    start: 0,
                    limit: 1,
                    ma: this.dangNhap.province,
                    loaiDonVi: 1
                };
                console.log("pr:" + params)
                rest_api.get("/internal-api/dmTinhThanh/filter", params, data => {
                    this.soBaoCao = data
                        .data
                        .rows[0];
                    console.log("thông tin abc:" + JSON.stringify(this.soBaoCao))
                });
            },
            exPort() {
                let url = "xuat-excel";
                let params = {
                    capHoc: this.capHoc,
                    namHoc: this.namHoc,
                    trangThai: 1,
                    collectionName: "BcDanhSachTruongHoc",
                    maTruongHoc: this.matruonghoc,
                    maDonVi: this.madonvi
                };
                api.post(url, params, data => {
                    let a = document.createElement("a");
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
                this.pdf = true;
                console.log("xuất pfd")
                let url = "xuat-bao-cao-pdf";
                let params = {
                    "capHoc": this.capHoc,
                    "namHoc": this.namHoc,
                    "trangThai": 1,
                    "collectionName": "BcDanhSachTruongHoc",
                    "maTruongHoc": this.matruonghoc,
                    "maDonVi": this.madonvi
                };
                console.log("prr là:" + params)
                api.post(url, params, (data) => {
                    console.log(JSON.stringify(data))
                    if (data.data.rc == -1) {
                        this.linkPdf = data.data.file;
                    }
                });
            },
            getData() {
                if (this.namHoc == "" || this.capHoc == "" || this.madonvi == "") {
                    utils.showDialog("Thông báo", "Vui lòng kiểm tra lại thông tin");
                    return;
                }
                let params = {
                    start: 0,
                    limit: 9999,
                    trangThai: 1,
                    madonvi: this.madonvi,
                    caphoc: this.capHoc,
                    ma: this.matruonghoc
                };
                rest_api.get("/internal-api/dmTruongHoc/filter", params, data => {
                    if (array_util.isArray(data.data.rows)) {
                        this.Report = data.data.rows;
                    }
                });
            },
            getDonVi() {
                let params = {
                    start: 0,
                    limit: 9999,
                    maTinhThanh: this.matinhthanh
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, data => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.listDonVi);
                        this.listDonVi = data.data.rows;
                    }
                });
            },
            close() {
                this.listTruongHoc = [],
                this.Report = [],
                this.reset();
                this.$emit("close");
            },
            reset() {
                this.listTruongHoc = "";
                this.Report = "";
                if (this.dangNhap.role != 4) {
                    // this.madonvi = "";
                }
                this.matruonghoc = "";
            },
            onDonViChange() {
                if (this.madonvi == "") {
                    return;
                }
                this.matruonghoc = "";
                this.getTruongHoc();
            },
            getTruongHoc() {
                if (this.madonvi == "") {
                    return;
                }
                let params = {
                    start: 0,
                    limit: 9999,
                    trangThai: 1,
                    madonvi: this.madonvi,
                    caphoc: this.capHoc
                };
                rest_api.get("/internal-api/dmTruongHoc/filter", params, data => {
                    console.log("data trường học:" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.listTruongHoc);
                        this.listTruongHoc = data.data.rows;
                        console.log(this.listTruongHoc)
                    }
                });
            }
        }
    };
</script>

<style scoped="scoped">
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
    .noidung th,
    td {
        border: 1px solid black !important;
    }

    .xembaocao {
        max-height: 600px;
        overflow: scroll;
    }
</style>
<template>
    <div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label class="pull-right lbl_field">Năm học:</label>
                    </div>
                    <div class="col-md-6">
                        <select v-model="namhoc" title="Chọn cấp học" class="form-control"
                                style="width:100%">
                            <option value="">Chọn năm học</option>
                            <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label class="pull-right lbl_field">Cấp học:</label>
                    </div>
                    <div class="col-md-6">
                        <select @change="onCapHocChange" v-model="caphoc" class="form-control" style="width:100%">
                            <option value="">Chọn cấp học</option>
                            <option v-for="ch in ds_cap_hoc" :value="ch.id">{{ch.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row_tp">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label class="pull-right lbl_field">Đơn vị:</label>
                    </div>
                    <div class="col-md-6">
                        <select @change="onDonviChange" v-model="ma_don_vi" class="form-control" style="width:100%">
                            <option value="">Chọn đơn vị</option>
                            <option v-for="dv in ds_don_vi" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label class="pull-right lbl_field">Trường học:</label>
                    </div>
                    <div class="col-md-6">
                        <select v-model="ma_truong_hoc" class="form-control" style="width:100%">
                            <option value="">Chọn trường học</option>
                            <option v-for="tr in ds_truong_hoc" :value="tr.maTruongHoc">{{tr.tenTruongHoc}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row_tp">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label class="pull-right lbl_field">Trạng thái</label>
                    </div>
                    <div class="col-md-6">
                        <select v-model="trang_thai" class="form-control" style="width:100%">


                            <option value="">Chọn trạng thái</option>
                            <option value='1'>Mới tạo</option>
                            <option value='0'>Ngừng hoạt động</option>
                            <option value='2'>Đã đồng bộ</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row_tp">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-success" @click.prevent="getData()"><i class="fa fa-search"></i>Tìm
                            kiếm
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row row_tp">

            <div class="col-sm-12">

                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <label>Danh sách yêu cầu đồng bộ dữ liệu</label>
                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Ngày đồng bộ</th>
                                            <th>Trường học</th>
                                            <th>Loại dữ liệu</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày yêu cầu</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(item, i) in ds_yeu_cau">
                                            <td>{{i+1}}</td>
                                            <td>{{item.ngayCoDl}}</td>
                                            <td>{{item.tenTruongHoc}}</td>
                                            <td>
                                                <p v-if="item.loaiDongBo==1">Đầu năm</p>
                                                <p v-else-if="item.loaiDongBo==2">Phát sinh</p>
                                                <p v-else-if="item.loaiDongBo==3">Cuối năm</p>
                                            </td>
                                            <td>
                                                <p v-if="item.status==0">Ngừng hoạt động</p>
                                                <p v-if="item.status==1">Mới tạo</p>
                                                <p v-if="item.status==2">Đã đồng bộ</p>
                                            </td>
                                            <td><span>{{item.tuNgay}}-{{item.denNgay}}</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>
<script>
    import Vue from 'vue';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'
    import constant from "../../utils/constant";
    import Page from '../ui/PagingCustom';
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
import { constants } from 'buffer';

    Vue.use(VueAlertify);
    export default {
        props: ['info'],
        components: {
            "Page": Page,
        },
        data() {
            return {
                list_years: constant.LIST_YEARS_FULL,
                statusactive: false,
                caphoc: '',
                namhoc: '',
                ds_cap_hoc: constant.LIST_CAP_HOC,
                ds_don_vi: [],
                ds_truong_hoc: [],
                trang_thai: '',
                ma_don_vi: '',
                ma_truong_hoc: '',
                thongtin: '',
                ds_yeu_cau:[],
                start: 0,
                currentPage: 1,
                limit: 25,
                total_rows: 0,

            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(this.info);
            this.ma_don_vi=this.thongtin.ma_don_vi;
            console.log("thông tin đăng nhập:" + JSON.stringify(this.thongtin));
            this.getDonVi();
            this.getData();

        },
        methods: {
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            getData(){
                console.log("lấy danh sách kết quả");
                let params = {
                    "namHoc": this.namhoc,
                    "capHoc": this.caphoc,
                    "start": this.start,
                    "limit": this.limit,
                    "maDonVi": this.ma_don_vi,
                    "maTruongHoc": this.ma_truong_hoc,
                    "status":this.trang_thai
                };
                console.log(JSON.stringify(params) + "là các parames");
                rest_api.post("/csdlgd-admin/yeuCauDuLieuTruong/search/", params, (data) => {

                    console.log("2345678"+ JSON.stringify(data));
                    this.total_rows = data.data.totalRows;
                    this.ds_yeu_cau = data.data.tableData;
                });
            },
            onCapHocChange() {
                console.log("chọn cấp học");
                if (this.ma_don_vi != null) {
                    this.ma_truong_hoc = '';
                        array_util.clearArrays(this.ds_truong_hoc);
                    this.getTruongHoc();
                } else {
                    this.ma_truong_hoc = '';
                        array_util.clearArrays(this.ds_truong_hoc);
                    return
                }
            },
            onDonviChange() {
                console.log("thay đổi đơn vị");
                if (this.ma_don_vi == '') {
                    this.matruonghoc = '';
                        array_util.clearArrays(this.ds_truong_hoc);
                    return;
                }
                this.matruonghoc = '';
                this.getTruongHoc();
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_don_vi,
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_don_vi);
                        this.ds_don_vi = data.data.rows;
                    }

                });
            },
            getTruongHoc() {
                console.log("lấy danh sách trường học của mã đơn vị:" + this.madonvi);
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "madonvi": this.ma_don_vi,
                    "caphoc": this.caphoc,
                };
                rest_api.get("/internal-api/dmTruongHoc/filter", params, (data) => {
                    console.log("trường học trả về:" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_truong_hoc);
                        this.ds_truong_hoc = data.data.rows;
                    }
                });
            },
        }
    }
</script>
<style scoped>

</style>

<template>

    <div id="modal_them_doitac" ref="modal_them_doitac" class="modal fade">

        <div class="modal-dialog" style="width:50%">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Thêm đối tác</h4>
                </div>
                <div class="modal-body clearfix">
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Họ & tên</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text"
                                       v-model="ten_doi_tac"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px;"/>
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Tên đăng nhập</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text"
                                       v-model="ten_dang_nhap"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px;"/>
                            </div>
                        </div>
                    </div>

                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Sđt đối tác</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text"
                                       v-model="sdt"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px;"/>
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Email đối tác</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text"
                                       v-model="email"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px;"/>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Tỉnh thành:</label>
                            </div>
                            <div class="col-sm-4">
                                <select @change="onTinhThanhChange()" class="form-control" v-model="ma_tinh_thanh">
                                    <option value=''>Chọn tỉnh thành</option>
                                    <option v-for="tt in ds_tinh_thanh" :value='tt.maTinhThanh'>{{tt.tenTinhThanh}}</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Quận huyện</label>
                            </div>
                            <div class="col-sm-4">
                                <select @change="onQuanHuyenChange()" class="form-control" v-model="ma_quan_huyen">
                                    <option value=''>Chọn quận huyện</option>
                                    <option v-for="qh in ds_quan_huyen" :value='qh.maQuanHuyen'>{{qh.tenQuanHuyen}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Trường:</label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" v-model="ma_truong">
                                    <option value=''>Chọn trường học</option>
                                    <option v-for="th in ds_truong_hoc" :value='th.maTruongHoc'>{{th.tenTruongHoc}}</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Vai trò</label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" v-model="vai_tro">
                                    <option value=''>Chọn vai trò</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Loại:</label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" v-model="loai">
                                    <option value=''>Chọn loại</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Trạng thái</label>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" v-model="trang_thai">
                                    <option value='1'>Đang hoạt động</option>
                                    <option value='0'>Ngưng hoạt động</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                    </button>
                    <button type="button" class="btn btn-primary" v-on:click="createTieuChuan">Thêm
                    </button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>

    import moment from 'moment'
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import utils from '../../utils'
    import api from '../api';

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: ['item', 'show'],


        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.reset();
                    $("#modal_them_doitac").modal();
                } else {
                    $("#modal_them_doitac").modal('hide');
                }
            }
        },

        data() {
            return {
                ten_doi_tac:'',
                ten_dang_nhap:'',
                ma_tinh_thanh:'',
                ma_quan_huyen:'',
                ma_truong:'',
                vao_tro:'',
                loai:'',
                trang_thai:1,
                sdt:'',
                email:'',
                vai_tro:'',
                ds_tinh_thanh:[],
                ds_quan_huyen:[],
                ds_truong_hoc:[],
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_doitac).on("hidden.bs.modal", this.close);
            this.getTinhThanh();
        },

        methods: {

            createTieuChuan() {
                console.log("Thêm tiêu chuẩn chiều cao cân nặng");
                utils.confirmDialog("Xác nhận thêm tiêu chuẩn", "Thêm", () => {
                    const uri = "/api_them_tieu_chuan_chieu_cao_can_nang";
                    const params = {
                    };
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm đối tiêu chuẩn thành công", null, () => {
                                this.$emit('success', params);
                                this.close();
                            });
                        } else {
                            utils.showDialog("Thất bại", response.data.message, null, () => {
                            });
                        }
                    });
                })
            },

            reset() {
            },
            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            },
            getTinhThanh() {
                let params = {
                    "start": 0,
                    "limit": 100,
                };
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_tinh_thanh);
                        this.ds_tinh_thanh = data.data.rows;
                    }
                });
            },
            onTinhThanhChange(){
                if (this.ds_tinh_thanh === "") {
                    return;
                }
                this.ma_quan_huyen = "";
                this.ma_truong = "";
                this.getQuanHuyen();
                this.getTruongHoc();
            },
            onQuanHuyenChange(){
                if (this.ds_quan_huyen === "") {
                    return;
                }
                this.ma_truong="";
                this.getTruongHoc();
            },

            getQuanHuyen() {
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maTinhThanh":this.ma_tinh_thanh,
                };
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_quan_huyen);
                        this.ds_quan_huyen = data.data.rows;
                    }
                });
            },
            getTruongHoc() {
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maquanhuyen": this.ma_quan_huyen,
                    "matinhthanh": this.ma_tinh_thanh,
                };
                rest_api.get("/internal-api/dmTruongHoc/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_truong_hoc);
                        this.ds_truong_hoc = data.data.rows;
                    }
                });
            },
        }

    }
</script>


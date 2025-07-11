<template>

    <div id="modal_update_email" ref="modal_update_email" class="modal fade">
        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h3 class="modal-title text-uppercase">Chỉnh Sửa Email</h3>
                </div>
                <div class="modal-body" style="width: 90%;margin: 0 auto; font-size: 18px">
                    <div class="row student-info">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Tên đăng nhập <span style="color:#DC0101">*</span></div>
                                <div class="col-md-7">
                                    <input
                                        v-model="ten_dang_nhap"
                                        placeholder="Nhập..."
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Địa chỉ email <span style="color:#DC0101">*</span></div>
                                <div class="col-md-7">
                                    <input
                                        v-model="dia_chi_email"
                                        placeholder="Nhập..."
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Mật khẩu email <span style="color:#DC0101">*</span></div>
                                <div class="col-md-7">
                                    <input
                                        placeholder="Nhập..."
                                        v-model="mat_khau_email"
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="password"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Trạng thái</div>
                                <div class="col-md-7">
                                    <select
                                        v-model="trang_thai"
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value='1'>--Đang hoạt động--</option>
                                        <option value='0'>--Ngừng hoạt động--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Địa chỉ mail serve gửi <span style="color:#DC0101">*</span></div>
                                <div class="col-md-7">
                                    <input
                                        v-model="host_email"
                                        placeholder="Nhập..."
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Cổng Email gửi đi <span style="color:#DC0101">*</span></div>
                                <div class="col-md-7">
                                    <input
                                        v-model="port_email"
                                        placeholder="Nhập..."
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="number"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Vai trò</div>
                                <div class="col-md-7">
                                    <select
                                        v-model="vai_tro"
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value='1'>Sở</option>
                                        <option value='2'>Phòng</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Đơn vị</div>
                                <div class="col-md-7">
                                    <select
                                        v-model="don_vi"
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn đơn vị--</option>
                                        <option v-for="dv in ds_don_vi" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="updateEmail()" class="btn btn-primary">Sửa</button>
                </div>
            </div>
        </div>

    </div>

</template>

<script>

    $(document).ready(function () {
        console.log("ready!");
    });

    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import api from '../api';
    import timeutils from '../../utils/time_utils';

    Vue.use(VueAlertify);
    export default {
        props: ['item', 'show', 'ma_so'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_update_email").modal();
                } else {
                    $("#modal_update_email").modal('hide');
                }
            },
            ma_so: function (newVal, oldVal) {
                this.ma_so = newVal;
                console.log("mã sở:" + this.don_vi);
                this.getDonVi();
            },
            item: function (newVal) {
                console.log("Dữ liệu là : " + JSON.stringify(newVal));
                this.don_vi = newVal.maDonVi;
                this.ten_dang_nhap = newVal.tenDangNhap;
                this.dia_chi_email = newVal.diaChiEmail;
                this.host_email = newVal.hostEmail;
                this.port_email = newVal.portEmail;
                this.vai_tro = newVal.vaiTro;
                console.log("vaitro"+ this.vai_tro);
                this.trang_thai = newVal.trangThai;
                this.idEmail = newVal.cauHinhEmailId;


            }
        },
        data() {
            return {
                ten_dang_nhap: '',
                dia_chi_email: '',
                mat_khau_email: '',
                host_email: '',
                trang_thai: 1,
                port_email: '',
                vai_tro: '',
                idEmail: '',
                don_vi: '',
                ds_don_vi: [],
            }
        },
        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_update_email).on("hidden.bs.modal", this.close);

            console.log("đơn vị là:" + this.don_vi)
        },
        methods: {
            updateEmail() {
                if (this.host_email == '' || this.port_email == '' || this.don_vi == '' || this.vai_tro == '' || this.ten_dang_nhap == '' || this.dia_chi_email == '' || this.mat_khau_email == '') {
                    utils.showDialog("Thông báo", "Vui lòng điền đầy đủ thông tin");
                    return;
                }
                utils.confirmDialog("Xác nhận chỉnh sửa email", "Sửa", () => {
                    const uri = "/api_chinh_sua_cau_hinh_email";
                    const params = {
                        "idEmail":this.idEmail,
                        "diaChiEmail": this.dia_chi_email,
                        "hostEmail": this.host_email,
                        "maDonVi": this.don_vi,
                        "maTinhThanh": this.ma_so,
                        "matKhauEmail": this.mat_khau_email,
                        "portEmail": this.port_email,
                        "tenDangNhap": this.ten_dang_nhap,
                        "trangThai": this.trang_thai,
                        "vaiTro": this.vai_tro,

                    };
                    api.post(uri, params, (response) => {
                        console.log("ok nè");
                        console.log(response.data);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa email thành công", null, () => {
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

            close() {
                this.$emit('close');
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 500,
                    "maDonViCha": this.ma_so,
                };
                console.log(params);
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    // console.log("ds đơn vị trả về: " + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_don_vi);
                        this.ds_don_vi = data.data.rows;
                    }
                });
            },

        }

    }
</script>


<style scoped>
    .col-md-7 {
        padding-bottom: 25px;
    }

    input {
        font-size: 17px;
    }

    .student-info span {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 19px;
    }

    .thumbnail {
        position: relative;
    }

    #box-img .thumbnail {
        width: 150px;
        height: 150px;
    }

    .control-label {
        display: block;
        float: left;
    }

    #change_image {
        position: absolute;
        bottom: 10px;
        left: 10px;
    }

    .img_preview {
        width: 150px;
        height: 150px;
    }

    .required {
        font-size: 12px;
        color: #DC0101
    }
</style>

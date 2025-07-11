<template>

    <div id="modal_create_user" ref="modal_create_user" class="modal fade">

        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h3 class="modal-title text-uppercase">Thêm mới người dùng </h3>
                </div>
                <div class="modal-body" style="width: 90%;margin: 0 auto;">
                    <div class="row student-info">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tên người dùng</div>
                                <div class="col-md-8">
                                    <input
                                        v-model="ho_ten"
                                        placeholder="Nhập..."
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tên đăng nhập</div>
                                <div class="col-md-8">
                                    <input
                                        v-model="ten_dang_nhap"
                                        placeholder="Nhập..."
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tỉnh thành</div>
                                <div class="col-md-8">
                                    <div v-if="user.role==1">
                                        <select
                                            v-model="ma_tinh_thanh"
                                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                            style="width:100%">
                                            <option value=''>--Chọn tỉnh thành--</option>
                                            <option v-for="tt in ds_tinh_thanh" :value="tt.maTinhThanh">
                                                {{tt.tenTinhThanh}}
                                            </option>
                                        </select>
                                    </div>
                                    <div v-if="user.role!==1">
                                        <select
                                            disabled
                                            v-model="ma_tinh_thanh"
                                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                            style="width:100%">
                                            <option v-for="tt in ds_tinh_thanh" :value="tt.maTinhThanh">
                                                {{tt.tenTinhThanh}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row student-info">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Vai trò</div>
                                <div v-if="user.role==1" class="col-md-8">
                                    <select
                                        v-model="vai_tro"
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn vai trò--</option>
                                        <option value='1'>Quản trị hệ thống</option>
                                        <option value='2'>Admin sở</option>
                                        <option value='3'>Người dùng sở</option>
                                        <option value='4'>Phòng</option>
                                        <option value='5'>Trường</option>
                                    </select>
                                </div>
                                <div  v-if="user.role==2" class="col-md-8">
                                    <select
                                        v-model="vai_tro"
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn vai trò--</option>
                                        <option value='2'>Admin sở</option>
                                        <option value='3'>Người dùng sở</option>
                                        <option value='4'>Phòng</option>
                                        <option value='5'>Trường</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div v-if="user.role=1">
                        </div>
                        <div v-if="user.role=2">
                            <div v-if="vai_tro==4">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">Chọn sở</div>
                                        <div class="col-md-8">
                                            <select
                                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                                style="width:100%">
                                                <option value=''>Chọn sở</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">Chọn phòng</div>
                                        <div class="col-md-8">
                                            <select
                                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                                style="width:100%">
                                                <option value=''>Chọn phòng</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div v-if="vai_tro==5">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">Quận huyện</div>
                                        <div class="col-md-8">
                                            <select
                                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                                style="width:100%">
                                                <option value=''>Chọn quận huyện</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4">Chọn trường học</div>
                                        <div class="col-md-8">
                                            <select
                                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                                style="width:100%">
                                                <option value=''>Chọn trường học</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="createUser()" class="btn btn-primary">Thêm</button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>

    $(document).ready(function () {
        console.log("ready!");
    });

    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'
    import api from '../api';

    Vue.use(VueAlertify);
    export default {
        props: ['item', 'show'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_create_user").modal();
                } else {
                    $("#modal_create_user").modal('hide');
                }
            }, item: function (newVal) {
                console.log("thêm-đăng nhập:" + JSON.stringify(newVal));
                this.user = this.item;
                if (this.user.role !== 1) {
                    this.ma_tinh_thanh = this.user.province;
                }
                console.log("mã tỉnh:" + this.ma_tinh_thanh);

            }
        },
        data() {
            return {
                ho_ten: '',
                ten_dang_nhap: '',
                email: '',
                sdt: '',
                maSo: '',
                vai_tro: '',
                loai_tai_khoan: '',
                ma_tinh_thanh: "",
                ds_don_vi: [],
                ds_tinh_thanh: [],
                user: {},
            }
        },
        mounted: function () {
            $(this.$refs.modal_create_user).on("hidden.bs.modal", this.close);
            this.getTinhThanh();
            console.log("mã tỉnh h.tại" + this.ma_tinh_thanh);
        },
        methods: {
            createUser() {
                utils.confirmDialog("Xác nhận thêm mới người dùng", "Thêm", () => {
                    const uri = "/api_them_nguoi_dung";
                    const params = {
                        hoTen: this.ho_ten,
                        username: this.ten_dang_nhap,
                        email: this.email,
                        sdt: this.sdt,
                        vaiTro: this.vai_tro,
                        maDonVi: this.ma_tinh_thanh,
                        trangThai: '1',
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.rc === 0) {
                            utils.showDialog("Thông báo", "Thêm người dùng thành công", null, () => {
                                this.$emit('success', params);
                                this.reset();
                                this.close();
                            });
                        } else {
                            utils.showDialog("Thất bại", response.data.message, null, () => {
                            });
                        }
                    });
                })
            },
            onVaiTroChange() {
                console.log(this.vai_tro);
            },
            close() {
                console.log("Đóng modal");
                this.$emit('close');
            },
            getTinhThanh() {
                let params = {
                    "start": 0,
                    "limit": 100,
                };
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.ds_tinh_thanh = data.data.rows;
                    }
                });
            },
            reset() {
                this.hoTen = '';
                this.username = '';
                this.email = '';
                this.sdt = '';
                this.vaiTro = '';
                this.maDonVi = '';
                this.trangThai = '1';
            }


        }

    }
</script>


<style scoped>
    .col-md-8 {
        padding-bottom: 25px;
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

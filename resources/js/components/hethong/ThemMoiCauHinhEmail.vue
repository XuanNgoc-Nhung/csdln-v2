<template>

    <div id="modal_create_config" ref="modal_create_config" class="modal fade">
        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h3 class="modal-title text-uppercase">THÊM MỚI THÔNG TIN</h3>
                </div>
                <div class="modal-body" style="width: 90%;margin: 0 auto; font-size: 18px">
                    <div class="row student-info">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Mã template <span style="color:#DC0101">*</span></div>
                                <div class="col-md-7">
                                    <input
                                        v-model="ma_template"
                                        placeholder="Nhập..."
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Tên template <span style="color:#DC0101">*</span></div>
                                <div class="col-md-7">
                                    <input
                                        v-model="ten_template"
                                        placeholder="Nhập..."
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Loại áp dụng <span style="color: #DC0101">*</span></div>
                                <div class="col-md-7">
                                    <select
                                        v-model="loai_ap_dung"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="1">--Tất cả--</option>
                                        <option value="1">--Thêm mới--</option>
                                        <option value="1">--Sửa--</option>
                                        <option value="1">--Reset mật khẩu--</option>
                                        <option value="1">--Khác--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5">Trạng thái <span style="color:#DC0101">*</span></div>
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
                        <div class="text-center">Nội dung template</div>
                        <div class="col-md-12">
                            <textarea
                                v-model="noi_dung"
                                class="form-control text-left ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                style="width:100%">
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="createEmailConfig()" class="btn btn-primary">Thêm</button>
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

    Vue.use(VueAlertify);
    export default {
        props: ['item', 'show'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_create_config").modal();
                } else {
                    $("#modal_create_config").modal('hide');
                }
            }
        },
        data() {
            return {
                ma_template:'',
                ten_template:'',
                loai_ap_dung:'',
                trang_thai:1,
                noi_dung:'',
            }
        },
        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_create_config).on("hidden.bs.modal", this.close);
        },
        methods: {
            createEmailConfig() {
                utils.confirmDialog("Xác nhận thêm cấu hình mẫu email", "Thêm", () => {
                    let params = {
                        "loaiApDung": this.loai_ap_dung,
                        "maTemplate": this.ma_template,
                        "tenTemplate": this.ten_template,
                        "noiDung": this.noi_dung,
                        "trangThai": this.trang_thai,
                    };
                    // console.log("thêm cấu hình mẫu email với: " + params);
                    rest_api.post("/internal-api/cauHinhTempEmail/create", params, (data) => {
                        if (data.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm Email thành công", null, () => {
                                this.$emit('success', params);
                                this.reset();
                                this.close();
                            });
                        } else {
                            utils.showDialog("Thất bại", data.data.message, null, () => {
                            });
                        }
                    });
                })
            },

            close() {
                console.log("Đóng modal");
                this.$emit('close');
            },
            reset() {
                this.loai_ap_dung = "";
                this.ma_template = "";
                this.ten_template = "";
                this.noi_dung = "";
                this.port_email = "";
                this.ten_dang_nhap = "";
                this.trang_thai = 1;
            },


        }

    }
</script>


<style scoped>
    .col-md-7 {
        padding-bottom: 25px;
    }
    input{
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
    .student-info .col-md-5{
        text-align: right;
    }
</style>

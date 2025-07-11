<template>

    <div id="modal_update_config" ref="modal_update_config" class="modal fade">
        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h3 class="modal-title text-uppercase">Chỉnh Sửa Thông Tin</h3>
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
                                        <option value='1'>--Tất cả--</option>
                                        <option value='2'>--Thêm mới--</option>
                                        <option value='3'>--Sửa--</option>
                                        <option value='4'>--Reset mật khẩu--</option>
                                        <option value='5'>--Khác--</option>
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
                                class="form-control ng-pristine ng-valid ng-empty text-left ng-valid-maxlength ng-touched"
                                style="width:100%">
                            </textarea>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="updateEmailConfig()" class="btn btn-primary">Cập nhật</button>
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

    Vue.use(VueAlertify);
    export default {
        props: ['item', 'show'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_update_config").modal();
                } else {
                    $("#modal_update_config").modal('hide');
                }
            },
            item: function(newVal, oldVal){
                console.log("sửa: " + JSON.stringify(newVal));
                this.idEmail=newVal.cauHinhTempEmailId;
                this.ma_template=newVal.maTemplate;
                this.ten_template=newVal.tenTemplate;
                this.noi_dung=newVal.noiDungTemplate;
                this.trang_thai=newVal.trangThai;
                this.loai_ap_dung=newVal.loaiApDung;
            }
        },
        data() {
            return {
                ma_template: '',
                ten_template: '',
                loai_ap_dung: '',
                trang_thai: '',
                noi_dung: '',
                idEmail: '',
            }
        },
        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_update_config).on("hidden.bs.modal", this.close);
        },
        methods: {
            updateEmailConfig() {
                utils.confirmDialog("Xác nhận chỉnh sửa email", "Sửa", () => {
                    const uri = "/api_chinh_sua_cau_hinh_mau_email";
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
                console.log("Đóng modal");
                this.$emit('close');
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

<template>

    <div id="chinhsua_matkhau_ketchuyen" ref="chinhsua_matkhau_ketchuyen" class="modal fade">

        <div class="modal-dialog" style="width:60%">

            <div class="modal-content">
                <form role="form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa tài khoản kết chuyển lên Bộ</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <form role="form">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Trường học:</label>
                                    <input disabled type="text" class="form-control" v-model="tenTruong">
                                </div>
                                <div class="col-md-6">
                                    <label>Tên đăng nhập:</label>
                                    <input v-model="tenDangNhap" type="text" class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label>Mật khẩu:</label>
                                    <input v-model="matKhau" type="text" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                        </button>
                        <button type="submit" @click.prevent="updatePass()" class="btn btn-primary">Sửa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import time_utils from '../../utils/time_utils';
    import utils from '../../utils'
    import api from '../api';
    import VeeValidate, {
        Validator
    } from 'vee-validate';
    import dialog from '../../utils/dialog';
    // import { unlink } from 'fs';
    //Validator.localize('vi', vi);
    Vue.use(VeeValidate);

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: ['item', 'show'],
        components: {},
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    //this.reset();
                    $("#chinhsua_matkhau_ketchuyen").modal();
                } else {
                    $("#chinhsua_matkhau_ketchuyen").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                console.log("demo");
                this.tenTruong = newVal.tenTruong;
                this.maTruong = newVal.maTruong;
                this.tenDangNhap = newVal.tenDangNhap;
                this.matKhau = newVal.matKhau;
            }
        },
        data() {
            return {
                thongTinTruong: "",
                maTruong: "",
                tenTruong: "",
                tenDangNhap: "",
                matKhau: ""
            }
        },
        mounted: function () {
            $(this.$refs.chinhsua_matkhau_ketchuyen).on("hidden.bs.modal", this.close);
        },

        methods: {
            close() {
                console.log("close modal");
                this.$emit('close');
            },
            reset() {},
            updatePass() {
                utils.confirmDialog("Xác nhận cập nhật tài khoản kết chuyển lên Bộ?", "Cập nhật", () => {
                    let params = {
                        maTruong: this.maTruong,
                        matKhauKetChuyen: this.matKhau,
                        tenDangNhap: this.tenDangNhap,
                    };
                    const loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    rest_api.post("/csdlgd-push/KetChuyenDL/updatePassword", params, data => {
                        loading.close();
                        console.log("chỉnh sửa mk trả về:" + JSON.stringify(data))
                        if (data.data.code === 200) {
                            utils.showDialog("Thông báo", "Cập nhật thành công", null, () => {
                                this.reset();
                                this.close();
                            });
                        } else {
                            utils.showDialog("Thất bại", data.data.message, null, () => {});
                        }
                    });
                })
            }
        }

    }

</script>
<style scoped>
    .form-check-inline {
        display: inline-flex;
        align-items: center;
        padding-left: 0;
        margin-right: .75rem;
    }

    .form-check-inline label {
        margin-bottom: 0;
        margin-left: 5px;
        position: relative;
        top: 2px;
    }

</style>

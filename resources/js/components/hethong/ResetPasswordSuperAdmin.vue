<template>
    <div
        id="modal_reset_passwrod_superadmin"
        ref="modal_reset_passwrod_superadmin"
        class="modal fade">
        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                <form @submit.prevent="resetPasswordSubmit">
                    <div class="modal-header">
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-hidden="true"
                            v-on:click="close()">
                            &times;
                        </button>
                        <h3 class="modal-title text-uppercase">Đổi mật khẩu</h3>
                    </div>
                    <div class="modal-body" style="width: 80%;margin: 0 auto;">
                        <div class="row">
                            <div class="col-md-6">
                                <label>
                                    Mật khẩu mới
                                </label>
                                <input
                                    v-validate="{ required: true, min:8}"
                                    name="mat_khau_moi"
                                    v-model="mat_khau_moi"
                                    placeholder="Nhập..."
                                    class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%"
                                    type="password"
                                    ref="mat_khau_moi"/>
                                <span class="text-danger" v-show="errors.has('mat_khau_moi')">{{ errors.first('mat_khau_moi') }}</span>
                            </div>
                            <div class="col-md-6">
                                <label>
                                    Nhập lại mật khẩu mới
                                </label>
                                <input
                                    v-validate="{ required: true, confirmed:mat_khau_moi}"
                                    name="mat_khau_moi_nhap_lai"
                                    v-model="mat_khau_moi_nhap_lai"
                                    placeholder="Nhập..."
                                    class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%"
                                    type="password"/>
                                <span class="text-danger" v-show="errors.has('mat_khau_moi_nhap_lai')">{{ errors.first('mat_khau_moi_nhap_lai') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="submit" class="btn btn-success">Đổi Mật khẩu
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng</button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</template>

<script>

    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'
    import api from '../api';
    import vi from 'vee-validate/dist/locale/vi';
    import VeeValidate, {Validator} from 'vee-validate';
    //Validator.localize('vi', vi);
    Vue.use(VeeValidate);
    Vue.use(VueAlertify, {

        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            // dialogs default title
            title: 'Thông báo',
            // ok button text
            ok: 'Đồng ý',
            // cancel button text
            cancel: 'Hủy'
        }
    });
    export default {
        props: [
            'item', 'dulieu'
        ],
        watch: {
            dulieu: function (newVal) {
                console.log("dữ liệu chỉnh sửa" + JSON.stringify(newVal));
                this.role = newVal.role;
                this.ten_dang_nhap = newVal.username;
                // this.email = newVal.email; this.trang_thai = newVal.trangThai; this.sdt =
                // newVal.sdt; this.loai_tai_khoan=newVal.loai_tai_khoan;
                console.log();
            }
        },
        data() {
            return {mat_khau_moi: '', mat_khau_moi_nhap_lai: '', ten_dang_nhap: '', role: ''}
        },
        mounted: function () {
            console.log("thay đổi mật khẩu");
            console.log(JSON.stringify(this.dulieu));

            this.ten_dang_nhap = this.dulieu.username;
            $("#modal_reset_passwrod_superadmin").modal();
            $(this.$refs.modal_reset_passwrod_superadmin).on("hidden.bs.modal", this.close);
            this.customMessage();
        },
        methods: {
            customMessage() {
                const dict = {
                    custom: {
                        mat_khau_moi: {
                            required: () => 'Mật khẩu mới không thể trống',
                            min: () => 'Mật khẩu phải dài ít nhất 8 ký tự'
                        },
                        mat_khau_moi_nhap_lai: {
                            required: () => 'Mật khẩu nhập lại không thể trống',
                            confirmed: () => 'Mật khẩu nhập lại không trúng khớp'
                        }
                    }
                };
                this
                    .$validator
                    .localize('vi', dict);
            },
            resetPasswordSubmit() {
                //this.show_msg = true;
                this
                    .$validator
                    .validateAll()
                    .then(result => {
                        if (result) {
                            this.resetPassword();
                        }
                    });
            },
            resetPassword() {
                utils.confirmDialog("Xác nhận đổi mật khẩu", "Đổi mật khẩu", () => {
                    let uri = "/api_change_pass_nguoi_dung";
                    let params = {
                        password: this.mat_khau_moi,
                        username: this.ten_dang_nhap
                    };
                    let p = {
                        params: params
                    };
                    api.post(uri, p, (response) => {
                        if (response.data.rc === 0) {

                            this
                                .$alertify
                                .success("Thay đổi mật khẩu thành công.");
                            this.close();
                        } else {
                            // utils.showDialog("Thất bại", response.data.rd, null, () => {});
                            this
                                .$alertify
                                .error("Thay đổi mật khẩu thất bại!" + response.data.rd);
                        }
                    });
                })
            },
            close() {
                this.reset();
                this.$emit('close');
            },
            reset() {
                this.mat_khau_moi = '';
                this.mat_khau_moi_nhap_lai = '';
            }

        }

    }
</script>

<style scoped="scoped"></style>

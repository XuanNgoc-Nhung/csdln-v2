<template>
    <div>
        <el-dialog :close-on-click-modal="false" :before-close="dongModal2" @close="dongModal" :close-on-press-escape="false" width="600px"
             title="Đổi mật khẩu" :visible.sync="show">
            <el-form :model="form" :rules="rules" ref="ruleForm" style="margin-bottom: 0;">
                <el-row :gutter="24" style="margin-bottom:30px !important">
                    <el-col v-if="thongtin.doipass||thongtin.doiPassMd" class="text-center" :span="24">
                        <p v-if="thongtin.doipass" class="red"><span style="color: blue"><b>Thông báo:</b></span> Mật
                            khẩu
                            hiện
                            tại sử dụng quá thời hạn
                            6 tháng. Vui lòng thay đổi mật khẩu mới để đăng nhập lại.</p>
                        <p v-if="thongtin.doiPassMd" class="red"><span style="color: blue"><b>Thông báo:</b></span> Bạn
                            đang
                            sử
                            dụng mật khẩu mặc
                            định. Vui lòng thay đổi mật khẩu để đảm bảo an toàn thông tin.</p>
                    </el-col>
                    <el-col :span="24">
                        <el-form-item prop="oldPassword">
                            <span>Mật khẩu hiện tại <sup class="red">*</sup></span>
                            <el-input clearable ref="oldPassword" @change="check_confirm_come_back = true"
                                type="password" placeholder="Nhập..." show-password v-model.trim="form.oldPassword"
                                autocomplete="off">
                            </el-input>
                        </el-form-item>
                        <el-form-item prop="password" style="padding-top: 20px;">
                            <span>Mật khẩu mới <sup class="red">*</sup></span>
                            <el-input @change="check_confirm_come_back = true" clearable ref="password" type="password"
                                placeholder="Nhập..." show-password v-model.trim="form.password" autocomplete="off">
                            </el-input>
                        </el-form-item>
                        <el-form-item prop="repassword" style="padding-top: 20px;">
                            <span>Nhập lại mật khẩu mới <sup class="red">*</sup></span>
                            <el-input clearable type="password" ref="repassword" show-password placeholder="Nhập..."
                                @change="check_confirm_come_back = true" v-model.trim="form.repassword"
                                autocomplete="off">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button v-if="true" size="mini" type="default" @click.prevent="dongModal2">Đóng</el-button>
                <el-button size="mini" type="primary" @click.prevent="submitForm('ruleForm')">Lưu</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import rest_api from '../../utils/rest_api';
    import utils from '../../utils';
    import dialog from "../../utils/dialog";
    import api from "./../api";

    export default {
        props: ['show'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    // $("#modal_doi_mat_khau").modal();
                    this.hien_thi_doi_mat_khau = true;
                    this.resetForm('ruleForm');

                    console.log("đổi mk bản thấn");
                } else {
                    // $("#modal_doi_mat_khau").modal('hide');
                    // this.hien_thi_doi_mat_khau = false;
                }
            },
        },
        data() {
            return {
                check_confirm_come_back: false,
                thongtin: JSON.parse(window.userInfo),
                form: {
                    oldPassword: '',
                    password: '',
                    repassword: ''
                },

                rules: {
                    repassword: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'changer'
                    }, ],
                    password: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'changer'
                    }, ],
                    oldPassword: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                },
                hien_thi_doi_mat_khau: false,
                showerr: false,
                mesThongBao: ""
            }
        },

        mounted: function () {
            console.log("THông tin đổi mkkkkk:")
            console.log(this.thongtin)
            // $(this.$refs.modal_doi_mat_khau).on("hidden.bs.modal", this.close);
        },

        methods: {
            
            resetForm(formName) {
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
            },
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.changePass();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },

            thongBao(t, e) {
                let msg = "";
                let cl = "";
                if (e) {
                    msg = e;
                }
                let type = "success";
                if (t) {
                    type = t
                }
                if (type == "success") {
                    cl = "dts-noty-success"
                }
                if (type == "warning") {
                    cl = "dts-noty-warning"
                }
                if (type == "error") {
                    cl = "dts-noty-error"
                }
                if (type == "info") {
                    cl = "dts-noty-info"
                }
                this.$message({
                    customClass: cl,
                    showClose: true,
                    message: msg,
                    type: t,
                    duration: 5000
                });
            },
            dongModal2() {
                if (this.check_confirm_come_back) {

                    this.$confirm(
                            'Các thông tin vừa nhập sẽ bị mất khi đóng trang. Thầy cô có muốn tiếp tục chỉnh sửa, kiểm tra và lưu lại thông tin đã nhập?',
                            'Thông báo', {
                                confirmButtonText: 'Rời khỏi trang',
                                cancelButtonText: 'Tiếp tục chỉnh sửa',
                                confirmButtonClass: 'el-button--danger',
                                closeOnClickModal: false,
                            })
                        .then(_ => {
                            this.dongModal();
                        })
                        .catch(_ => {
                            console.log('Tiếp tục')
                        });
                } else {
                    this.dongModal();
                }
            },
            dongModal() {

                console.log('Đóng')
                console.log(this.show)
                this.$emit('close')
            },
            validatePass(password) {
                let re = /^(?=.*[A-Z])[A-Za-z\d@$!%*?&]{1,8}$/;
                return re.test(String(password).toLowerCase());

            },
            changePass() {
                this.showerr = true;
                if (!this.form.oldPassword) {
                    this.thongBao('error', 'Vui lòng nhập mật khẩu hiện tại. ')
                    return;
                }
                if (!this.form.password) {
                    this.thongBao('error', 'Vui lòng nhập mật khẩu.')
                    return;
                }

                if (this.form.password != this.form.repassword) {
                    this.thongBao('error', 'Vui lòng nhập lại đúng mật khẩu.')
                    return;
                }
                this.$confirm('Xác nhận đổi mật khẩu?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        let params = {
                            password: this.form.password,
                            username: this.thongtin.username,
                            oldPassword: this.form.oldPassword,
                        };
                        console.log("mk" + JSON.stringify(params))
                        console.table(params)
                        rest_api.put('/csdlgd-user/adminUser/changeSelfPasswordV2', params, response => {
                            console.log("đổi mật khẩu trả về:")
                            console.log(JSON.stringify(response));
                            if (response.data.rc === 0) {
                                this.thongBao('success',
                                    'Đổi mật khẩu thành công. Vui lòng đăng nhập lại.');
                                setTimeout(() => {
                                    this.hien_thi_doi_mat_khau = false;
                                    this.LogOut();
                                }, 1500)
                            } else {
                                this.thongBao('error', response.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            LogOut() {
                console.log("Đăng xuất");
                let logout = 'logout';
                window.location.href = logout;
            },
            close() {
                console.log("đóng");
                this.mesThongBao = "";
                this.$emit('close')
            }
        }
    }

</script>
<style scoped="scoped">
    .el-form-item__content {
        padding-top: 15px;
    }

    .el-form-item__content span {
        line-height: 2;
    }

</style>

<template>
    <div v-loading.fullscreen.lock="fullScreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog title="Chỉnh sửa tài khoản kết chuyển lên IOC" :visible.sync="show" width="70%"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
            <div>
                <el-form :model='dataUpdate' :rules="rules" ref="ruleForm">
                    <el-row :gutter="24">
                        <el-col :lg="8">
                            <label>Trường học <span style="color:#DC0101">*</span></label>
                            <input disabled type="text" class="form-control" v-model="dataUpdate.tenTruong">
                        </el-col>
                        <el-col :lg="8">
                            <label>Tên đăng nhập <span style="color:#DC0101">*</span></label>
                            <el-form-item prop="tenDangNhap">
                                <el-input v-model="dataUpdate.tenDangNhap" placeholder="Nhập..." ref="tenDangNhap"
                                    clearable type="text" @change="check_confirm_come_back = true;dataUpdate.tenDangNhap=dataUpdate.tenDangNhap.trim()" />
                            </el-form-item>
                        </el-col>
                        <el-col :lg="8">
                            <label>Mật khẩu <span style="color:#DC0101">*</span></label>
                            <el-form-item prop="matKhau">
                                <InputPassword ref="matKhau" v-model="dataUpdate.matKhau" @change="check_confirm_come_back = true;dataUpdate.matKhau = dataUpdate.matKhau.trim()"></InputPassword>

<!--                                <el-input clearable placeholder="Nhập..." ref="matKhau" v-model="dataUpdate.matKhau"-->
<!--                                    @change="check_confirm_come_back = true;dataUpdate.matKhau = dataUpdate.matKhau.trim()" show-password>-->
<!--                                    <template slot="suffix">-->
<!--                                        <i-->
<!--                                                :class="isPasswordVisible ? 'el-icon-view' : 'el-icon-view-off'"-->
<!--                                                @click="togglePasswordVisibility"-->
<!--                                                style="cursor: pointer;"-->
<!--                                        ></i>-->
<!--                                    </template>-->
<!--                                </el-input>-->
<!--                                <el-input-->
<!--                                        v-model="dataUpdate.matKhau"-->
<!--                                        @change="check_confirm_come_back = true;dataUpdate.matKhau = dataUpdate.matKhau.trim()"-->
<!--                                        :type="isPasswordVisible ? 'text' : 'password'"-->
<!--                                        clearable placeholder="Nhập..." ref="matKhau"-->
<!--                                >-->
<!--                                    <template  slot="suffix">-->
<!--                                        <i-->
<!--                                                :class="isPasswordVisible ? 'far fa-eye-slash' : 'far fa-eye'"-->
<!--                                                @click="togglePasswordVisibility"-->
<!--                                                style="cursor: pointer;"-->
<!--                                        ></i>-->
<!--                                    </template>-->
<!--                                </el-input>-->
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button size="mini" type="primary" @click.prevent="submitForm('ruleForm')">Lưu</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import rest_api from '../../../utils/rest_api';
    import utils from '../../../utils'
    import InputPassword from "./InputPassword";
    export default {

        props: ['item', 'show'],
        components: {InputPassword},
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);

            },
            item: function (newVal, oldVal) {
                console.log("demo");
                this.dataUpdate = {
                    tenTruong: newVal.tenTruong,
                    maTruong: newVal.maTruong,
                    tenDangNhap: newVal.tenDangNhap,
                    matKhau: newVal.matKhau
                }
            }
        },
        data() {
            return {
                isPasswordVisible: false,
                fullScreenLoading: false,
                check_confirm_come_back: false,
                dataUpdate: {
                    tenTruong: '',
                    maTruong: '',
                    tenDangNhap: '',
                    matKhau: ''
                },
                rules: {
                    tenDangNhap: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    matKhau: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                }
            }
        },
        mounted: function () {

        },

        methods: {
            togglePasswordVisibility() {
                this.isPasswordVisible = !this.isPasswordVisible;
            },
            handleClose() {
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
                            this.resetForm('ruleForm')
                            this.$emit('close');
                        })
                        .catch(_ => {});
                } else {
                    this.resetForm('ruleForm')
                    this.$emit('close');
                }
            },
            close() {
                console.log("close modal");
                this.$emit('close');
            },
            reset() {

                this.resetForm('ruleForm')
                this.$emit('success');
            },
            resetForm(formName) {
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
            },

            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.updatePass();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            updatePass() {
                let params = {
                    maTruong: this.dataUpdate.maTruong,
                    matKhauKetChuyen: this.dataUpdate.matKhau,
                    tenDangNhap: this.dataUpdate.tenDangNhap,
                };
                this.fullScreenLoading = true
                rest_api.post("/csdlgd-push/KetChuyenDlIoc/updatePassword", params, data => {
                    this.fullScreenLoading = false;
                    console.log("chỉnh sửa mk trả về:" + JSON.stringify(data))
                    if (data.data.code === 200) {
                        this.thongBao('success', data.data.message)
                        this.reset();
                        this.close();
                        // });
                    } else {
                        this.thongBao('error', data.data.message)
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

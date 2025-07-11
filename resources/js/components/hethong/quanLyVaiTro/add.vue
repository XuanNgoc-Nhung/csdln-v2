<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog width="80%" top="15vh" :title="text_header" custom-class="showThongTinLoiImportSSO"
            :visible.sync="show_add" :close-on-press-escape="false" append-to-body :close-on-click-modal="false"
            :before-close="closeImport">
            <el-row :gutter="20">
                <el-form :model='dataAdd' :rules="rules" ref="ruleForm">
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Tên vai trò: <span class="red">*</span></label>
                        <el-form-item prop="roleName">
                            <el-input clearable placeholder="Nhập..." ref="roleName" v-model="dataAdd.roleName"
                                @change="check_confirm_come_back = true;dataAdd.roleName = dataAdd.roleName.trim()">
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Vai trò gốc: <span class="red">*</span></label>
                        <el-form-item prop="parentRole">
                            <eselect collapseTags v-model="dataAdd.parentRole" ref="parentRole" :placeholder="'Chọn'"
                                @change="check_confirm_come_back = true" filterable :data="list_vai_tro_goc"
                                :fields="['name','value']" />
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8">
                        <label>Mô tả: <span class="red">*</span></label>

                        <el-form-item prop="description">
                            <el-input clearable placeholder="Nhập..." ref="description" v-model="dataAdd.description"
                                @change="check_confirm_come_back = true;dataAdd.description = dataAdd.description.trim()">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-form>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="default" @click="closeImport">Huỷ</el-button>
                <el-button size="mini" type="primary" @click.prevent="submitForm('ruleForm')">Lưu</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
    import 'vue2-datepicker/index.css';

    export default {
        props: [],
        components: {
            'eselect': ESelectVue,
        },
        watch: {},
        data() {
            return {
                check_confirm_come_back: false,
                loading: {
                    status: false,
                    text: 'Loading...'
                },
                show_add: false,
                text_header: 'Thêm mới thông tin vai trò',
                dataAdd: {
                    description: '',
                    maSo: '',
                    parentRole: '',
                    roleName: '',
                },
                thongtin: {},
                list_vai_tro_goc: [{
                        name: 'Sở',
                        value: 2
                    },
                    {
                        name: 'Phòng',
                        value: 4
                    },
                ],
                rules: {
                    description: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    parentRole: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    roleName: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                }
            }
        },

        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.show_add = true;
        },
        methods: {

            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.confirmAdd();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            confirmAdd() {
                console.log('confirmAdd');
                console.log(this.dataAdd)
                // if (!this.dataAdd.roleName || this.dataAdd.roleName == '') {
                //     this.thongBao('error', 'Vui lòng bổ sung tên vai trò');
                //     return
                // }
                // if (!this.dataAdd.parentRole || this.dataAdd.parentRole == '') {
                //     this.thongBao('error', 'Vui lòng bổ sung thông tin vai trò gốc');
                //     return
                // }

                this.addData();
                // this.$confirm('Xác nhận thêm mới dữ liệu', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {})
                //     .catch(_ => {});
            },
            addData() {
                try {
                    let params = {
                        roleName: this.dataAdd.roleName,
                        parentRole: this.dataAdd.parentRole,
                        description: this.dataAdd.description,
                        maSo: this.thongtin.ma_so
                    };
                    this.loading.text = 'Vui lòng đợi...';
                    this.loading.status = true;
                    rest_api.post("/csdlgd-user/adminRole/createRole", params, (response) => {
                        if (response && response.data.rc == 0) {
                            this.thongBao('success', 'Thêm mới vai trò thành công');
                            this.loading.status = false;
                            this.$emit('addSuccess');
                        } else {
                            this.thongBao('error', response.data.rd)
                        }
                        this.loading.status = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Có lỗi trong quá trình thao tác. Vui lòng thử lại');
                }
            },
            closeImport() {
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
                            this.close();
                        })
                        .catch(_ => {});
                } else {
                    this.close();
                }
            },
            close() {
                this.check_confirm_come_back = false;
                this.$emit('close');
            },

            thongBao(typeNoty, message) {
                let msg = "";
                let cl = "";
                if (message) {
                    msg = message;
                }
                let type = "success";
                if (typeNoty) {
                    type = typeNoty
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
                    type: type,
                    duration: 5000
                });
            },
        }

    }

</script>
<style scoped="scoped">
    .bg-purple {
        background: #d3dce6;
    }

    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }

    .mt-15 {
        margin-top: 15px
    }

    .mb-15 {
        margin-bottom: 15px
    }

    .pd-10 {
        padding: 10px
    }

</style>

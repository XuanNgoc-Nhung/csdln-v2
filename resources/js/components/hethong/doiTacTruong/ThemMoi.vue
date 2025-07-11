<template>
    <div v-loading.fullscreen.lock="loading" :element-loading-text="'loading...'"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog :close-on-click-modal="false" width="1100px" :close-on-press-escape="false" :before-close="dongModal"
            title="Thêm mới đối tác trường" :visible.sync="show">
            <el-form :model='dataForm' :rules="rules" ref="ruleForm">
                <el-row :gutter="24">
                    <el-col :sm="24"  :md="16" :lg="16">
                        <label>Đơn vị quản lý</label>
                        <eselect style="width:100%" multiple collapseTags v-model="dataForm.maPhong" @change="chonDonVi"
                                 placeholder="Chọn"
                            filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />

                    </el-col>
                    <el-col :sm="24"  :md="8" :lg="8">
                        <label class="typo__label">Cấp học</label>
                        <eselect style="width:100%" multiple collapseTags v-model="dataForm.capHoc" @change="chonCapHoc"
                            :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="24"  :md="16" :lg="16">
                        <label class="typo__label">Trường học <span style="color:#DC0101;">*</span></label>

                        <el-form-item prop="truongHoc">
                            <eselect style="width:100%" multiple ref="truongHoc" collapseTags
                                     placeholder="Chọn"
                                @change="check_confirm_come_back = true" v-model="dataForm.truongHoc" filterable
                                :data="ds_truong_hoc" :fields="['name','value']" />
                        </el-form-item>
                    </el-col>
                    <el-col :sm="24"  :md="8" :lg="8">
                        <label class="typo__label">Đối tác <span style="color:#DC0101;">*</span></label>
                        <el-form-item prop="maDoiTac">
                            <eselect style="width:100%" @change="check_confirm_come_back = true" ref="maDoiTac"
                                     placeholder="Chọn"
                                     collapseTags v-model="dataForm.maDoiTac" filterable :data="ds_doi_tac"
                                     :fields="['name','value']" />
                        </el-form-item>
                    </el-col>
                </el-row>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button size="mini" type="primary" @click.prevent="submitForm('ruleForm')">Lưu</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    import rest_api from '../../../utils/rest_api';
    import ElementUI from 'element-ui';
    import ESelectVue from '../../ui/ESelect.vue';
    Vue.use(ElementUI);
    export default {
        props: ['doitac', 'show'],
        components: {
            'eselect': ESelectVue,
        },
        watch: {
            show: function (newVal) {
                if (newVal) {
                    this.ds_doi_tac = this.doitac;
                    this.getDonVi();
                    for (let i = 0; i < this.list_cap_hoc_2.length; i++) {
                        this.list_cap_hoc.push(this.list_cap_hoc_2[i])
                    }
                    this.getTruongHoc();
                } else {}
            },
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                maPhong: [],
                capHoc: [],
                truongHoc: [],
                maDoiTac: "",
                dataForm: {
                    maPhong: [],
                    capHoc: [],
                    truongHoc: [],
                    maDoiTac: ''
                },
                check_confirm_come_back: false,
                loading: false,
                rules: {
                    truongHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'changer'
                    }, ],
                    maDoiTac: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                },
                show_msg: false,
                list_don_vi: [],
                ds_doi_tac: [],
                list_cap_hoc: [],
                list_cap_hoc_2: window.listCapHoc,
                ds_truong_hoc: [],
                ds_req: [],
            }
        },
        mounted: function () {},
        methods: {
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.createDoiTac();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            resetForm(formName) {
                this.dataForm = {
                    maPhong: [],
                    capHoc: [],
                    truongHoc: [],
                    maDoiTac: ''
                }
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
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
                            this.close();
                        })
                        .catch(_ => {});
                } else {
                    this.resetForm('ruleForm')
                    this.close();
                }
            },
            dongModal() {
                this.close();
            },
            getTruongHoc() {
                let params = {
                    maDonVi: this.dataForm.maPhong,
                    capHoc: this.dataForm.capHoc,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    console.log("lấy trường học công" + JSON.stringify(data));
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenTruongHoc + " - [" + data.data.rows[i]
                                    .maTruongHoc + "]",
                                value: data.data.rows[i].maTruongHoc,
                            }
                            data_demo.push(obj);
                        }
                        this.ds_truong_hoc = data_demo;
                    }
                });
            },
            chonCapHoc() {
                this.check_confirm_come_back = true;
                this.list_truong_hoc = [];
                this.dataForm.truongHoc = [];
                this.getTruongHoc();
            },
            chonDonVi() {
                this.list_truong_hoc = [];
                this.dataForm.truongHoc = [];
                this.getTruongHoc();
            },
            createDoiTac() {
                this.ds_req = [];
                for (let i = 0; i < this.dataForm.truongHoc.length; i++) {
                    let obj = {
                        maDoiTac: this.dataForm.maDoiTac,
                        maTruongHoc: this.dataForm.truongHoc[i]
                    }
                    this.ds_req.push(obj)
                }
                let params = {
                    truongEntities: this.ds_req
                };

                this.loading = true;
                rest_api.post("/csdlgd-admin/heThongDoiTacTruong/createDoiTacTruong", params, (data) => {
                    this.loading = false;
                    console.log("Tạo đối tác thành công" + JSON.stringify(data));
                    if (data.data.rc == 0) {
                        this.thongBao('success',data.data.rd)
                        this.$emit('thanhcong');
                    } else {
                        this.thongBao('error',data.data.rd)

                    }
                });
                // dialog.confirmDialog("Xác nhận thêm mới đối tác trường?", "Đồng ý", () => {
                // });
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
            themTruongHocSubmit() {
                this.show_msg = true;
                this
                    .$validator
                    .validateAll()
                    .then(result => {
                        if (result) {
                            this.createDoiTac();
                        }
                    });
            },
            customMessage() {
                const dict = {
                    custom: {
                        ma_truong_hoc: {
                            required: () => 'Mã trường học không thể trống',
                            max: () => 'Mã trường học không vượt quá 30 ký tự',
                            regex: () => 'Mã trường học chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        ma_phong: {
                            required: () => 'Đơn vị không thể trống'
                        },
                        truong_hoc: {
                            required: () => 'Trường học không thể trống'
                        },
                        ma_doi_tac: {
                            required: () => 'Đối tác không thể trống'
                        },
                        // ma_don_vi: {
                        //     required: () => 'Đơn vị không thể trống'
                        // },
                    }
                };
                this
                    .$validator
                    .localize('vi', dict);
            },
            close() {
                this.reset();
                this.$emit('close');
            },
            reset() {},
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                tenDonVi: data.data.rows[i].tenDonVi + " - [" + data.data.rows[i].maDonVi +
                                    "]",
                                maDonVi: data.data.rows[i].maDonVi,
                            }
                            data_demo.push(obj);
                        }
                        this.list_don_vi = data_demo;
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">
</style>

<template>
    <div>
        <el-dialog :close-on-click-modal="false" width="1100px" :close-on-press-escape="false" :before-close="dongModal"
            title="Chỉnh sửa đối tác trường" :visible.sync="show">
            <el-form :model='dataForm' :rules="rules" ref="ruleForm">
                <el-row :gutter="24">
                    <el-col :sm="24"  :md="16" :lg="16">
                        <label>Đơn vị quản lý</label>
                        <eselect style="width:100%" collapseTags v-model="dataForm.maPhong" @change="chonDonVi"
                            filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />

                    </el-col>
                    <el-col :sm="24"  :md="8" :lg="8">
                        <label class="typo__label">Cấp học</label>
                        <eselect style="width:100%" collapseTags v-model="dataForm.capHoc" @change="chonCapHoc"
                            :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="24"  :md="16" :lg="16">
                        <label class="typo__label">Trường học <span style="color:#DC0101;">*</span></label>

                        <el-form-item prop="truongHoc">
                            <eselect style="width:100%" ref="truongHoc" collapseTags v-model="dataForm.truongHoc"
                                @change="check_confirm_come_back = true" filterable :data="ds_truong_hoc"
                                :fields="['name','value']" />
                        </el-form-item>
                    </el-col>
                    <el-col :sm="24"  :md="8" :lg="8">
                        <label class="typo__label">Đối tác <span style="color:#DC0101;">*</span></label>
                        <el-form-item prop="maDoiTac">
                            <eselect style="width:100%" ref="maDoiTac" collapseTags v-model="dataForm.maDoiTac"
                                @change="check_confirm_come_back = true" filterable :data="ds_doi_tac"
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
    import VeeValidate, {
        Validator
    } from 'vee-validate';
    Vue.use(VeeValidate);
    export default {
        props: ['donvi', 'caphoc', 'doitac', 'item', 'show'],
        components: {
            'eselect': ESelectVue,
        },
        watch: {
            show: function (newVal) {
                if (newVal) {
                    this.list_don_vi = this.donvi;
                    this.list_cap_hoc = this.caphoc;
                    this.ds_doi_tac = this.doitac;
                    this.getTruongHoc()
                    this.bindData(this.item);
                } else {}
            },
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                maPhong: "",
                capHoc: "",
                truongHoc: "",
                maDoiTac: "",
                check_confirm_come_back: false,
                dataForm: {
                    maPhong: "",
                    capHoc: "",
                    truongHoc: "",
                    maDoiTac: "",
                },
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
                list_cap_hoc: [{
                    id: "",
                    name: "Chọn"
                }],
                list_cap_hoc_2: window.listCapHoc,
                ds_truong_hoc: [],
            }
        },
        mounted: function () {
            // $("#modal_them_truonghoc").modal();
            // $(this.$refs.modal_them_truonghoc).on("hidden.bs.modal", this.close);
        },
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
            resetForm(formName) {
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
            },
            dongModal() {
                this.close();
            },
            bindData(e) {
                console.log("Bind" + JSON.stringify(e));
                this.dataForm.maPhong = e.maDonVi;
                this.dataForm.maDoiTac = e.maDoiTac;
                this.dataForm.truongHoc = e.maTruongHoc;
            },
            getTruongHoc() {
                let params = {};
                if (this.dataForm.capHoc) {
                    params.capHoc = [this.dataForm.capHoc];
                } else {
                    params.capHoc = [];
                }
                if (this.dataForm.maPhong) {
                    params.maDonVi = [this.dataForm.maPhong];
                } else {
                    params.maDonVi = [];
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    console.log("lấy trường học công" + JSON.stringify(data));
                    let data_demo = [{
                        name: "Chọn",
                        value: ""
                    }];
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
                this.ds_truong_hoc = [];
                this.dataForm.truongHoc = "";
                this.getTruongHoc();
            },
            chonDonVi() {
                this.check_confirm_come_back = true;
                this.ds_truong_hoc = [];
                this.dataForm.truongHoc = "";
                this.getTruongHoc();
            },
            createDoiTac() {
                let params = {
                    "maDoiTac": this.dataForm.maDoiTac,
                    "maTruongHoc": this.dataForm.truongHoc,
                    "id": this.item.id,
                };

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/heThongDoiTacTruong/updateDoiTacTruong", params, (data) => {
                    loading.close();
                    console.log("Tạo đối tác thành công" + JSON.stringify(data));
                    if (data.data.rc == 0) {
                        this.thongBao('success', data.data.rd)
                        this.$emit('thanhcong');
                    } else {

                        this.thongBao('error', data.data.rd)

                    }
                });
                // dialog.confirmDialog("Xác nhận chỉnh sửa đối tác trường?", "Đồng ý", () => {
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
            close() {
                this.reset();
                this.$emit('close');
            },
            reset() {},
            getDonVi() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    console.log("lấy đơn vị thành công" + JSON.stringify(data));
                    let data_demo = [{
                        tenDonVi: "Chọn",
                        maDonVi: ""
                    }];
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

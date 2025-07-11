<template>
    <div>
        

        <Breadcrumb :menu="'Báo cáo'" :desc="'Tổng hợp dữ liệu báo cáo emis'"/>
        <div>
            <div class="card-bieu-do">
                <el-form :model='dataSearch' :rules="rules" ref="ruleForm">
                    <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                        <el-col :span="24">
                            <div class="table-name">Thông tin tìm kiếm</div>
                        </el-col>

                        <el-col :sm="24" :lg="12">
                            <label class="typo__label">Đơn vị quản lý </label>
                            <eselect style="width:100%" @change="layLaiTruong" :disabled="thongtin.role>2" multiple
                                     collapseTags v-model="donVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                     :fields="['tenDonVi','maDonVi']" />
                        </el-col>
                        <el-col :sm="12" :lg="6">
                            <label class="typo__label">Cấp học </label>
                            <eselect style="width:100%" @change="layLaiTruong" multiple collapseTags v-model="capHoc"
                                     :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc_full"
                                     :fields="['name','id']" />
                        </el-col>
                        <el-col :sm="12" :lg="6">
                            <label class="typo__label">Năm học <span style="color:#DC0101">*</span> </label>

                            <el-form-item prop="namHoc">
                                <eselect style="width:100%" ref="namHoc" collapseTags v-model="dataSearch.namHoc"
                                         :placeholder="'Chọn'" filterable :data="list_nam_hoc" :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="24" :lg="12">
                            <label class="typo__label">Trường học <span style="color:#DC0101">*</span> </label>

                            <el-form-item prop="truongHoc">
                                <eselect style="width:100%" ref="truongHoc" collapseTags v-model="dataSearch.truongHoc"
                                         :placeholder="'Chọn'" filterable :data="list_truong_hoc" :disabled="thongtin.role==5"
                                         :fields="['name','value']" />
                            </el-form-item>
                        </el-col>




                    </el-row>
                    <div style="padding-bottom: 24px;padding-top: 5px">
                        <div class="text-center">
                           
                            <el-button size="mini" class="bt-chinh" @click.prevent="submitForm('ruleForm',2)" type="success">Tổng hợp
                            </el-button>
                        </div>
                    </div>
                </el-form>


            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from "../../utils/rest_api";
    import constant from '../../utils/constant';
    import utils from '../../utils'
    import ESelectVue from '../ui/ESelect.vue';
    import moment from 'moment';
    import Breadcrumb from "../ui/Breadcrumb.vue";
    export default {
        components: {
            'eselect': ESelectVue,
            Breadcrumb
        },
        computed: {},
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                donVi: [],
                capHoc: [],
                truongHoc: "",
                date: new Date(),
                namHoc: "",
                list_don_vi: [],
                danh_sach_cap_hoc_full: window.listCapHoc,
                list_truong_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                dataSearch: {
                    truongHoc: '',
                    namHoc: ''
                },
                rules: {
                    truongHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],

                    namHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],

                }
            }
        },
        mounted() {
            this.dataSearch.namHoc = this.thongtin.namHocHienTai
            this.dataSearch.truongHoc = this.thongtin.ma_truong_hoc
            
            this.getDonVi();
        },
        watch: {},
        methods: {
            submitForm(formName, type) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        if (type == 1) {
                            this.kiemTraQuaTrinhTongHop();
                        } else {

                            this.TongHopDuLieuNhaTruong();
                        }
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },

            layLaiTruong() {
                this.list_truong_hoc = [];
                this.dataSearch.truongHoc = "";
                this.getTruongHoc();
            },
            kiemTraQuaTrinhTongHop() {
                if (this.dataSearch.truongHoc == "" || !this.dataSearch.truongHoc) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin trường học.')
                    return;
                }
                if (!this.dataSearch.namHoc || this.dataSearch.namHoc == "") {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin năm học.')
                    return;
                }
                console.log("Ấn tổng hợp")
                let params = {
                    namHoc: this.dataSearch.namHoc,
                    maTruongHoc: this.dataSearch.truongHoc
                };
                const loadingth = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-fetch/refetch/tonghop-dulieu-check", params, (data) => {
                    loadingth.close();
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        this.thongBao('success', data.data.rd)
                    } else {
                        this.thongBao('error', 'Vui lòng thử lại sau vài phút.')
                    }
                });
            },
            TongHopDuLieuNhaTruong() {
                if (this.dataSearch.truongHoc == "" || !this.dataSearch.truongHoc) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin trường học.')
                    return;
                }
                if (!this.dataSearch.namHoc || this.dataSearch.namHoc == "") {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin năm học.')
                    return;
                }
                console.log("Ấn tổng hợp")
                let params = {
                    namHoc: this.dataSearch.namHoc,
                    maTruongHoc: this.dataSearch.truongHoc
                };
                const loadingth = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-report-fetch/criteriaReport/tong-hop-emis", params, (data) => {
                    loadingth.close();
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        this.thongBao('success',data.data.rd)
                        // this.thongBao('success','Hệ thống đang tiến hành tổng hợp lại dữ liệu. Thông tin mới nhất từ QLNT nộp lên sẽ hiển thị trong vài phút tới.')
                    } else {
                        this.thongBao('error',data.data.rd)
                    }
                });
                // utils.confirmDialog("Xác nhận tổng hợp lại dữ liệu của trường học đã chọn", "Đồng ý", () => {

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
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.list_don_vi = [];
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    console.log("Lấy đơn vị trả về:")
                    console.log(JSON.stringify(data))
                    if (data.data.statusResponse == 0) {
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                tenDonVi: data_demo[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data_demo[i].maDonVi + ']',
                                maDonVi: data_demo[i].maDonVi,
                            }
                            this.list_don_vi.push(obj)
                        }
                        if (this.thongtin.role > 3) {
                            this.donVi = [this.list_don_vi[0].maDonVi];
                        }
                        this.getTruongHoc();
                    } else {
                        this.thongBao('error', data.data.message)
                    }
                });
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                let params = {
                    maDonVi: this.donVi,
                    capHoc: this.capHoc,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    // loading.close();
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
                        this.list_truong_hoc = data_demo;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">
</style>

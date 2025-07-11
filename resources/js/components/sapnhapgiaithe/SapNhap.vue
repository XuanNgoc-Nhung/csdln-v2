<template>
    <div>
        <Breadcrumb :menu="'Hệ thống'" :desc="'Sáp nhập trường học'"/>
        <div class="card-bieu-do">


            <el-row :gutter="15">
                <el-col :span="24">
                    <div class="grid-content">
                        <p>Điều kiện thực hiện chức năng sáp nhập trường:</p>
                        <ul>
                            <li>Cả 2 trường cùng sát nhập phải thực hiện chuyển hồ sơ (Trường, lớp, học sinh, giáo viên) từ năm học cũ lên năm học hiện tại.</li>
                            <li>Chuẩn hóa lại Lớp học, Học sinh, Giáo viên, Điểm trường đảm bảo không tồn tại Tên lớp, Mã học sinh, Mã giáo viên, Mã điểm trường tại 2 trường giống nhau.</li>
                        </ul>
                    </div>
                </el-col>
            </el-row>

            <el-row :gutter="15">
                <el-col :span="10">
                    <el-row :gutter="15">
                        <el-col :span="6">
                            <label>Chọn trường chính</label>

                        </el-col>
                        <el-col :span="18">
                            <eselect
                                    clearable
                                    v-model="id_truong_chinh" :placeholder="'--Chọn--'" filterable :data="list_truong_hoc"
                                    :fields="['tenTruongHoc','maTruongHoc']" />
                        </el-col>
                    </el-row>

                </el-col>
                <el-col :span="10">
                    <el-row :gutter="15">
                        <el-col :span="6">
                            <label>Chọn trường sáp nhập</label>

                        </el-col>
                        <el-col :span="18">
                            <eselect
                                    clearable
                                    v-model="id_truong_sap_nhap" :placeholder="'--Chọn--'" filterable :data="list_truong_hoc"
                                    :fields="['tenTruongHoc','maTruongHoc']" />
                        </el-col>
                    </el-row>
                </el-col>
                <el-col :span="4">
                    <el-row :gutter="15">
                        <el-col :span="24">
                            <el-button size="mini" type="success" @click="onSubmitSapNhap">Sáp nhập</el-button>
                        </el-col>

                    </el-row>

                </el-col>
            </el-row>
        </div>
    </div>
</template>

<script>
import rest_api from '../../utils/rest_api';
import Breadcrumb from '../ui/Breadcrumb.vue';
import ESelectVue from "../ui/ESelect";
import 'element-ui/lib/theme-chalk/index.css';

export default {
    name: "SapNhap",
    components : {
        'eselect': ESelectVue,
        Breadcrumb
    },
    data(){
        return {
            thong_tin : '',
            list_truong_hoc: [],
            list_truong_hoc_custom: [],
            id_truong_chinh : '',
            id_truong_sap_nhap : '',
            namHoc: "",
            ds_don_vi: [],
        }
    },
    methods : {
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
        onSubmitSapNhap(){

            if (!this.id_truong_chinh){
                this.thongBao('error','Vui lòng chọn trường chính')
                return
            }
            if (!this.id_truong_sap_nhap){
                this.thongBao('error','Vui lòng trường sáp nhập')
                return
            }
            //action sáp nhập
            console.log('action sáp nhập')
        },

        getTruongHoc(gt = () => {}) {
            this.list_truong_hoc = [];
            this.list_truong_hoc_custom = [];
            let params = {
                maDonVi: this.ds_don_vi,
                capHoc: this.ds_cap_hoc
            };
            // if (this.thongTinTrangCu.maTruongHoc) {     params.maTruong =
            // this.thongTinTrangCu.maTruongHoc; }
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                loading.close();
                console.log("lấy trường");
                if (data.data.statusResponse == 0) {
                    let dulieu = data.data.rows;
                    let ldv = [];
                    for (let i = 0; i < dulieu.length; i++) {
                        let obj = {
                            tenTruongHoc: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                            maTruongHoc: dulieu[i].maTruongHoc
                        }
                        ldv.push(obj)
                    }
                    this.list_truong_hoc = ldv;
                } else {
                    this.list_truong_hoc = [];
                }
            });
        },
    },
    beforeMount() {
        this.thongtin = JSON.parse(window.userInfo);
    },
    mounted() {
        this.namHoc = this.thongtin.namHocHienTai;
        this.getTruongHoc();
    }
}
</script>

<style>
.dts-noty-success {
    background: #67c23a;
}

.dts-noty-info {
    background: #909399;
}

.dts-noty-warning {
    background: #e6a23c;
}

.dts-noty-error {
    background: #f56c6c;
}

.el-message__content {
    color: white !important;
}

.el-message .el-icon-error {
    color: white !important;
}

.el-message .el-icon-success {
    color: white !important;
}

.el-message .el-icon-warning {
    color: white !important;
}

.el-message .el-icon-info {
    color: white !important;
}

.mx-datepicker-popup {
    z-index: 2025 !important;
}
#myTabContent{
    padding-top:60px;
}
.container-fluid{
    border:1px solid Silver
}
</style>

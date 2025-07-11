<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :span="24" class="text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Tra cứu <span class="kytu">
                        &raquo;</span> TRA CỨU KẾT QUẢ HỌC TẬP THÔNG TƯ 22</span>
            </el-col>
        </el-row>
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :xs="24" :sm="12" :md="8" :lg="8">
                <label>Đơn vị quản lý:</label>
                <eselect :disabled="thongtin.role>2" collapseTags v-model="dataSearch.donVi"
                         @change="chonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="8">
                <label>Cấp học</label>
                <eselect :disabled="list_cap_hoc.length==1" collapseTags v-model="dataSearch.capHoc"
                         @change="chonCapHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="8">
                <label>Trường học <span class="red">*</span></label>
                <eselect :disabled="thongtin.role==5" collapseTags v-model="dataSearch.truongHoc"
                         :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="8">
                <label>Năm học <span class="red">*</span></label>
                <eselect collapseTags v-model="dataSearch.namHoc"
                         :placeholder="'Chọn'" filterable :data="list_nam_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="8">
                <label>Học kỳ <span class="red">*</span></label>
                <eselect collapseTags v-model="dataSearch.hocKy"
                         :placeholder="'Chọn'" filterable :data="list_hoc_ky"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :span="24" class="text-center">
                <el-button size="mini" type="success" @click.prevent="getData">Tải xuống</el-button>
            </el-col>
        </el-row>
    </div>
</template>
<script>
import ElementUI from 'element-ui';
import rest_api from "../../../utils/rest_api";
import ESelectVue from '../../ui/ESelect.vue';
import api from "../../api";
import constant from "../../../utils/constant";
Vue.use(ElementUI);
export default {
    components: {
        'eselect': ESelectVue,
    },
    watch: {},
    data() {
        return {
            thongtin: {},
            loading: {
                text: 'Loading...',
                status: false,
            },
            dataSearch: {
                capHoc: '',
                donVi: '',
                namHoc: '',
                hocKy: '',
                truongHoc: '',
            },
            list_don_vi: [],
            list_cap_hoc: window.listCapHoc,
            list_truong_hoc: [],
            list_nam_hoc: constant.LIST_YEARS_FULL,
            list_hoc_ky: constant.LIST_HOC_KY,
        }
    },
    mounted() {
        this.thongtin = JSON.parse(window.userInfo);
        console.log('Mount tra cứu trường học');
        console.warn(this.thongtin);
        if(this.thongtin.role>2){
            this.dataSearch.donVi = this.thongtin.ma_don_vi;
        }
        if(this.thongtin.role&&this.thongtin.role==5){
            this.dataSearch.truongHoc = this.thongtin.ma_truong_hoc;
            if(this.list_cap_hoc&&this.list_cap_hoc.length==1){
                this.dataSearch.capHoc = this.list_cap_hoc[0].id
            }
        }
        this.dataSearch.namHoc = this.thongtin.namHocHienTai;
        this.getDonVi();
        this.getTruongHoc();
    },
    methods: {
        getData(){
            if(!this.dataSearch.truongHoc||this.dataSearch.truongHoc==''){
                this.thongBao('warning','Vui lòng chọn trường học');
                return;
            }
            if(!this.dataSearch.namHoc||this.dataSearch.namHoc==''){
                this.thongBao('warning','Vui lòng chọn năm học');
                return;
            }
            if(!this.dataSearch.hocKy||this.dataSearch.hocKy==''){
                this.thongBao('warning','Vui lòng chọn học kỳ');
                return;
            }
            console.log('getData');
            let params = {
                namHoc: this.dataSearch.namHoc,
                capHoc: this.dataSearch.capHoc,
                hocKy: this.dataSearch.hocKy,
                maTruongHoc: this.dataSearch.truongHoc,
            };
            this.loading.text = 'Đang tải dữ liệu...';
            this.loading.status = true;
            rest_api.post("/csdlgd-admin/export-excel/hoc-sinh-tt26", params, response => {
                console.log('Response:')
                console.log(response)
                if (response.data.rc == 0) {
                    let uri = this.thongtin.tenMien + response.data.item;
                    window.open(uri, '_blank');
                    console.log('Mở trang:')
                    console.log(uri)
                } else {
                    this.thongBao('error',response.data.rd)
                }
                this.loading.status = false
            });
            // api.post(url, params, (data) => {
            //     if(data.data.code==-1){
            //         setTimeout(() => {
            //             this.loading.status = false;
            //             let a = document.createElement('a');
            //             a.href = data.data.file;
            //             document
            //                 .body
            //                 .appendChild(a);
            //             a.click();
            //             document
            //                 .body
            //                 .removeChild(a);
            //         }, 1000)
            //     }
            //     else{
            //         this.thongBao('error',data.data.rd)
            //         this.loading.status = false;
            //     }
            // });
        },
        chonCapHoc() {
            console.log('chonCapHoc')
            if(this.thongtin.role!=5){
                this.dataSearch.truongHoc = '';
                this.list_truong_hoc = [];
                this.getTruongHoc();
            }
        },
        chonDonVi() {
            console.log('chonDonVi')
            this.chonCapHoc();
        },
        getTruongHoc(){
            console.log("Lấy danh sách trường học")
            try {
                let params = {
                    maDonVi: [],
                    capHoc: [],
                    loose: true
                };
                if (this.dataSearch.capHoc) {
                    params.capHoc = [this.dataSearch.capHoc]
                }
                if(this.dataSearch.donVi){
                    params.maDonVi = [this.dataSearch.donVi]
                }
                // this.loading.text = 'Lấy danh sách trường học...'
                // this.loading.status = true;
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, response => {
                    if (response.data.statusResponse == 0) {
                        let dulieu = response.data.rows;
                        let ldv = [];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                value: dulieu[i].maTruongHoc
                            }
                            ldv.push(obj)
                        }
                        this.list_truong_hoc = ldv;
                    } else {
                        this.list_truong_hoc = [];
                    }
                    // this.loading.status = false
                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
            }
        },
        getDonVi() {
            console.log('getDonVi');
            try {
                console.log("Lấy danh sách đơn vị:")
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                this.loading.status = true;
                this.loading.text = 'Lấy danh sách đơn vị';
                rest_api.get("/internal-api/dmDonVi/filter", params, (response) => {
                    console.log("res lấy đơn vị:")
                    console.log(response)
                    if (response.data.code == 200) {
                        let ldv = []
                        let dulieu = response.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                value: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi = ldv;
                    } else {
                    }
                    this.loading.status = false;
                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
            }
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
.mt-15 {
    margin-top: 15px !important;
}
</style>

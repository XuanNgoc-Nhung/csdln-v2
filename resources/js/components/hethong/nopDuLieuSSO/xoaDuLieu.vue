<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :span="20">
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Đơn vị: <span class="red" v-if="!dataSearch.tuKhoa||dataSearch.tuKhoa==''">*</span></label>
                <eselect multiple collapseTags v-model="dataSearch.donVis"
                         @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Cấp học</label>
                <eselect collapseTags v-model="dataSearch.capHoc"
                         @change="chonCapHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Trường học: <span class="red" v-if="thongtin.capHoc">*</span></label>
                <eselect multiple collapseTags v-model="dataSearch.truongHocs" :placeholder="'Chọn'" filterable
                         :data="list_truong_hoc"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Năm học:</label>
                <eselect collapseTags v-model="dataSearch.namHoc" :placeholder="'Chọn'" filterable :data="list_nam_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Loại dữ liệu: <span class="red">*</span></label>
                <eselect collapseTags v-model="dataSearch.loaiDuLieu" :placeholder="'Chọn'" filterable
                         :data="list_loai_du_lieu"
                         :fields="['name','value']"/>
            </el-col>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="24" class="text-center">
                <el-tooltip effect="dark" content="Xoá dữ liệu" placement="top">
                    <el-button size="mini" @click.prevent="XoaDuLieu"
                               type="danger">Xoá
                    </el-button>
                </el-tooltip>
            </el-col>
        </el-row>
    </div>
</template>
<script>
import ESelectVue from '../../ui/ESelect.vue';
import rest_api from "../../../utils/rest_api";
import constant from "../../../utils/constant";

export default {
    components: {
        'eselect': ESelectVue,
    },
    watch: {},
    data() {
        return {
            loading: {
                status: false,
                text: 'Loading...'
            },
            thongtin: {},
            dataSearch: {
                donVis: [],
                capHoc: '',
                truongHocs: [],
                namHoc: '',
                loaiDuLieu: '',
            },
            list_don_vi: [],
            list_cap_hoc: window.listCapHoc,
            list_truong_hoc: [],
            list_nam_hoc: constant.LIST_YEARS_FULL,
            list_loai_du_lieu: [
                {name: 'Dữ liệu học sinh', value: 1},
                {name: 'Dữ liệu giáo viên', value: 2},
            ]
        }
    },
    mounted() {
        console.log('Mount xoá dữ liệu ');
        this.thongtin = JSON.parse(window.userInfo);
        this.dataSearch.namHoc = this.thongtin.namHocHienTai;
        this.getDonVi();
        this.getTruongHoc();
    },
    methods: {
        XoaDuLieu() {
            console.log('XoaDuLieu');
            console.log(this.dataSearch)
            let msgConfirm='Xác nhận xoá dữ liệu';
            if (!this.dataSearch.donVis || this.dataSearch.donVis.length == 0) {
                //thiếu đơn vị
                this.thongBao('error', 'Thiếu thông tin đơn vị');
                return;
            }
            if (!this.dataSearch.loaiDuLieu || this.dataSearch.loaiDuLieu == '') {
                this.thongBao('error', 'Vui lòng chọn loại dữ liệu cần xoá');
                return;
            }
            if(this.dataSearch.capHoc&&this.dataSearch.capHoc!=''){
                if(!this.dataSearch.truongHocs||this.dataSearch.truongHocs.length==0){
                    this.thongBao('warning','Không thể xoá dữ liệu của các đơn vị theo cấp học đã chọn. Vui lòng bổ sung thông tin trường học hoặc bỏ chọn cấp học.');
                    return;
                }
            }
            if(this.dataSearch.truongHocs&&this.dataSearch.truongHocs.length>0){
                msgConfirm = 'Xác nhận xoá dữ liệu của '+ this.dataSearch.truongHocs.length + ' trường học đã chọn';
            }else {
                msgConfirm = 'Xác nhận xoá dữ liệu của '+ this.dataSearch.donVis.length + ' đơn vị đã chọn';
            }
            let uri = "";
            this.$confirm(msgConfirm, 'Thông báo', {
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy',
                closeOnClickModal: false,
            })
                .then(_ => {
                    if (this.dataSearch.loaiDuLieu == 1) {
                        uri = "/csdlgd-admin/sso/deleteHocSinh";
                    } else if (this.dataSearch.loaiDuLieu == 2) {
                        uri = "/csdlgd-admin/sso/deleteGiaoVien";
                    }
                    let params = {
                        lstMaDonVi: this.dataSearch.donVis,
                        lstMaTruong: this.dataSearch.truongHocs,
                        namHoc: this.dataSearch.namHoc
                    };
                    this.loading.text='Đang xoá dữ liệu...';
                    this.loading.status = true;
                    rest_api.post(uri, params, response => {
                        if (response.data.rc == 0) {
                            this.thongBao('success',response.data.rd);
                        } else {
                            this.thongBao('error',response.data.rd);
                        }
                        this.loading.status = false;
                    });
                })
                .catch(_ => {
                });
        },
        chonCapHoc() {
            console.log('Chọn cấp học:');
            this.dataSearch.truongHocs = [];
            this.list_truong_hoc = [];
            this.getTruongHoc();
        },
        ChonDonVi() {
            console.log('Chọn đơn vị:');
            this.dataSearch.truongHocs = [];
            this.list_truong_hoc = [];
            this.getTruongHoc();
        },
        getTruongHoc() {
            console.log("Lấy danh sách trường học")
            try {
                let params = {
                    maDonVi: this.dataSearch.donVis,
                    capHoc: []
                };
                if (this.dataSearch.capHoc) {
                    params.capHoc = [this.dataSearch.capHoc]
                }
                this.loading.text = 'Lấy danh sách trường học...'
                this.loading.status = true;
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
                    this.loading.status = false
                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
            }
        },
        getDonVi() {
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
.mauDo {
    background: #f3cccc !important;
}

</style>

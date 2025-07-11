<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :span="12" class="text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> hệ thống <span class="kytu">
                        &raquo;</span> Tổng hợp dữ liệu báo cáo</span>
            </el-col>
        </el-row>
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :xs="24" :sm="16" :md="16" :lg="6">
                <label>Đơn vị:</label>
                <eselect multiple collapseTags v-model="dataSearch.donVis"
                         @change="chonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="4">
                <label>Cấp học</label>
                <eselect collapseTags v-model="dataSearch.capHocs"
                         multiple
                         @change="chonCapHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :xs="24" :sm="16" :md="16" :lg="6">
                <label>Trường học: <span class="red">*</span></label>
                <eselect collapseTags v-model="dataSearch.truongHoc" :placeholder="'Chọn'" filterable
                         :data="list_truong_hoc"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="8" :md="6" :lg="6">
                <label>Năm học:</label>
                <eselect collapseTags v-model="dataSearch.namHoc" :placeholder="'Chọn'" filterable :data="list_nam_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :span="24" class="text-center">
                <el-tooltip effect="dark" content="Kiểm tra quá trình tổng hợp" placement="top">
                    <el-button size="mini" type="success" @click.prevent="checkSynthetic">Kiểm tra</el-button>
                </el-tooltip>
                <el-tooltip effect="dark" content="Tiến hành tổng hợp" placement="top">
                    <el-button size="mini" type="primary" @click.prevent="syntheticData">Tổng hợp</el-button>
                </el-tooltip>
            </el-col>
        </el-row>
    </div>
</template>
<script>

import ElementUI from 'element-ui';
import rest_api from "../../../utils/rest_api";
import ESelectVue from '../../ui/ESelect.vue';
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
                donVis: [],
                capHocs: [],
                truongHoc: '',
                namHoc: ''
            },
            list_don_vi: [],
            list_cap_hoc: window.listCapHoc,
            list_truong_hoc: [],
            list_nam_hoc: constant.LIST_YEARS_FULL,
        }
    },
    mounted() {
        console.log('Mount nộp dữ liệu sso');
        this.thongtin = JSON.parse(window.userInfo);
        console.warn(this.thongtin);
        this.dataSearch.namHoc = this.thongtin.namHocHienTai;
        this.getDonVi();
        this.getTruongHoc();
    },
    methods: {
        checkSynthetic() {
            console.log('syntheticData');

            if (this.dataSearch.truongHoc == "" || !this.dataSearch.truongHoc) {
                this.thongBao('error', 'Vui lòng bổ sung thông tin trường học.')
                return;
            }
            if (!this.dataSearch.namHoc || this.dataSearch.namHoc == "") {
                this.thongBao('error', 'Vui lòng bổ sung thông tin năm học.')
                return;
            }
            let params = {
                namHoc: this.dataSearch.namHoc,
                maTruongHoc: this.dataSearch.truongHoc
            };
            try {

                this.loading.text = 'Đang kiểm tra...';
                this.loading.status = true;
                rest_api.post("/csdlgd-report-fetch/refetch/tonghop-dulieu-check", params, (response) => {
                    if (response.data.rc == 0) {
                        this.thongBao('success', response.data.rd)
                    } else {
                        this.thongBao('error', 'Vui lòng thử lại sau vài phút.')
                    }
                    this.loading.status = false;
                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút.');
            }
        },
        syntheticData() {
            console.log('checkSynthetic');
            if (this.dataSearch.truongHoc == "" || !this.dataSearch.truongHoc) {
                this.thongBao('error', 'Vui lòng bổ sung thông tin trường học.')
                return;
            }
            if (!this.dataSearch.namHoc || this.dataSearch.namHoc == "") {
                this.thongBao('error', 'Vui lòng bổ sung thông tin năm học.')
                return;
            }
            this.$confirm('Xác nhận tổng hợp dữ liệu cho trường đã chọn?', 'Thông báo', {
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy',
                closeOnClickModal: false,
            })
                .then(_ => {
                    let params = {
                        namHoc: this.dataSearch.namHoc,
                        maTruongHoc: this.dataSearch.truongHoc
                    };
                    this.loading.text = 'Đang tổng hợp...';
                    this.loading.status = true;
                    rest_api.post("/csdlgd-report-fetch/refetch/dasboartBc", params, (response) => {
                        if (response.data.rc == 0) {
                            this.thongBao('success',
                                'Hệ thống đang tiến hành tổng hợp lại các báo cáo và hồ sơ tra cứu. Thông tin mới nhất từ QLNT nộp lên sẽ hiển thị trong vài phút tới.'
                            )
                        } else {
                            this.thongBao('error', 'Vui lòng thử lại sau vài phút')
                        }
                        this.loading.status = false;
                    });
                })
                .catch(_ => {});
        },
        getTruongHoc() {
            console.log('getTruongHoc');
            try {
                let params = {
                    maDonVi: this.dataSearch.donVis,
                    capHoc: this.dataSearch.capHocs
                };
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
            console.log('getDonVi');

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
        chonDonVi() {
            console.log('chonDonVi');
            this.dataSearch.truongHoc = '';
            this.list_truong_hoc = [];
            this.getTruongHoc();
        },
        chonCapHoc() {
            console.log('chonCapHoc')
            this.chonDonVi();
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

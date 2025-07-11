<template>
    <div v-loading.fullscreen.lock="fullscreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :gutter="24">
            <el-col :span="24" class="page-header">
                <div class="text-uppercase">
                    <a href="#">TRANG CHỦ</a>
                    <span>
                        <span class="kytu">
                            &raquo;</span> Báo cáo
                        <span class="kytu">
                            &raquo;</span>Báo cáo động</span>
                </div>
            </el-col>
        </el-row>
        <el-row class="card-bieu-do">
            <el-tabs v-model="bangDuLieu" type="border-card2">
                <el-tab-pane name="canBo" label="Báo cáo cán bộ">
                    <div v-loading="loadingComponent" element-loading-text="Loading..."
                        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
                        <CanBoGiaoVien :danh_sach_don_vi="list_don_vi" :danh_sach_truong_hoc="list_truong_hoc">                        </CanBoGiaoVien>
                    </div>
                </el-tab-pane>
                <el-tab-pane name="hocSinh" label="Báo cáo học sinh">
                    <div v-loading="loadingComponent" element-loading-text="Loading..."
                        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
                        <HocSinh :danh_sach_don_vi="list_don_vi" :danh_sach_truong_hoc="list_truong_hoc"></HocSinh>
                    </div>
                </el-tab-pane>
                <el-tab-pane name="truongHoc" label="Báo cáo trường học">
                    <div v-loading="loadingComponent" element-loading-text="Loading..."
                        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
                        <TruongHoc :danh_sach_don_vi="list_don_vi" :danh_sach_truong_hoc="list_truong_hoc"></TruongHoc>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </el-row>

    </div>
</template>
<script>
    import rest_api from '../../../utils/rest_api';
    import ElementUI from 'element-ui';
    import CanBoGiaoVien from "./CanBoGiaoVien";
    import HocSinh from "./HocSinhEmis";
    import TruongHoc from "./TruongHocEmis";
    Vue.use(ElementUI);
    export default {
        components: {
            CanBoGiaoVien: CanBoGiaoVien,
            HocSinh: HocSinh,
            TruongHoc: TruongHoc,
        },
        watch: {},
        computed: {},
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                list_don_vi: [],
                list_truong_hoc: [],
                fullscreenLoading: false,
                loadingComponent: false,
                bangDuLieu: "canBo",
            }
        },
        mounted() {
            this.getDonVi();
            console.log("Giữa")
        },
        watch: {
            
            bangDuLieu: function (newVal) {
                console.log("Danh sách đơn vị thay đổi:");
                if (newVal) {
                    this.loadingComponent = true;
                setTimeout(() => {
                    this.loadingComponent = false;
                },3000)
                } else {
                }
            },
        },
        methods: {
            getTruongHoc() {
                console.log("lấy trường")
                let params = {
                    maDonVi: [],
                    capHoc: [],
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    this.fullscreenLoading = false;
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
            getDonVi() {
                console.log("lấy đơn vị")
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                this.fullscreenLoading = true;
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    this.getTruongHoc();
                    let du_lieu = [];
                    if (data.data.statusResponse == 0) {
                        let ket_qua = data.data.rows;
                        for (let i = 0; i < ket_qua.length; i++) {

                            let obj = {
                                name: ket_qua[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + ket_qua[i].maDonVi + ']',
                                value: ket_qua[i].maDonVi,
                            }
                            du_lieu.push(obj)
                        }
                        this.list_don_vi = du_lieu;
                    } else {
                        this.list_don_vi = [];
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">
    .el-row {
        margin-bottom: 20px;

        &:last-child {
            margin-bottom: 0;
        }
    }

    .el-col {
        border-radius: 4px;
    }

    .bg-purple-dark {
        background: #99a9bf;
    }

    .bg-purple {
        background: #d3dce6;
    }

    .bg-purple-light {
        background: #e5e9f2;
    }

    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }

    .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
    }

</style>

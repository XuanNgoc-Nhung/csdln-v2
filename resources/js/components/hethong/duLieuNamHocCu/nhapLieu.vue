<template>
    <div v-loading.fullscreen.lock="fullscreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :gutter="24">
            <el-col :span="24" class="page-header">
                <div class="text-uppercase">
                    <a href="#">TRANG CHỦ</a>
                    <span>
                        <span class="kytu">
                            &raquo;</span> Hệ thống
                        <span class="kytu">
                            &raquo;</span>Nhập liệu dữ liệu năm học cũ</span>
                </div>
            </el-col>
        </el-row>
        <el-row class="card-bieu-do">
            <el-tabs v-model="bangDuLieu" type="border-card2">
                <el-tab-pane name="import" label="Nhập dữ liệu">
                    <div v-loading="loadingComponent" element-loading-text="Loading..."
                        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
                        <div class="noiDung">
                            <el-col :span="24">
                            <div class="alert alert-info" style="display: inline-flex;position: relative" role="alert">
                                <div  v-if="tenFile!=''" style="position: absolute; top: 0; right: 0">
                                    <a href="#" title="Xóa file đã chọn"class="xoafile" @click.prevent="xoaFile()">x</a>
                                </div>
                                <label class="btn btn-default btn-file">
                                    <i class="fa fa-cloud-upload"></i>
                                    <span>
                                        <i class="fas fa-upload"></i>
                                        Chọn file</span>
                                    <input
                                        ref="file_upload"
                                        multiple="false"
                                        name="file"
                                        style="display: none;"
                                        type="file"
                                        @change="onFileChange"
                                        aria-invalid="false"/>
                                </label>
                                <label
                                    v-if="tenFile!=''"
                                    class="btn btn-default btn-file"
                                    style="margin: 0 15px;">
                                    <span>File đã chọn:
                                        {{tenFile}}</span>
                                </label>
                            </div>
                            </el-col>
                        </div>
                    </div>
                </el-tab-pane>
                <el-tab-pane name="export" label="Xuất báo cáo">
                    <div v-loading="loadingComponent" element-loading-text="Loading..."
                        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
                        <div class="noiDung">
                            Xuất báo cáo
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </el-row>

    </div>
</template>
<script>
    import rest_api from '../../../utils/rest_api';
    import ElementUI from 'element-ui';
    Vue.use(ElementUI);
    export default {
        components: {},
        watch: {},
        computed: {},
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                danh_sach_dinh_dang_excel:[
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    "application/vnd.ms-excel.sheet.macroEnabled.12",
                    "application/vnd.ms-excel",
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
                ],
                selected_file: '',
                tenFile: '',
                list_don_vi: [],
                list_truong_hoc: [],
                fullscreenLoading: false,
                loadingComponent: false,
                bangDuLieu: "import",
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
                    }, 1000)
                } else {}
            },
        },
        methods: {
            
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
            onFileChange(e) {
                console.log("chọn file")
                console.log(e)
                
                const files = e.target.files;
                this.tenFile = '';
                if (!files) {
                    this.thongBao('error','Trình duyệt không hỗ trợ upload file');
                    return;
                }
                this.selected_file = files[0];
                const size = parseInt(this.selected_file.size); console.log("kích thước file:"+ size);
                if (files && files[0]) {
                    console.log(files)
                    let fileType = this.selected_file["type"];
                    let ValidImageTypes = this.danh_sach_dinh_dang_excel;
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                    this.thongBao('error','Vui lòng chọn đúng định dạng file excel');
                        this.selected_file = null;
                        return;
                    }
                    this.file_name = e
                        .target
                        .files[0]
                        .name;
                    this.tenFile = this.file_name;
                }
            },
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

    .noiDung {
        min-height: 200px;
    }

</style>

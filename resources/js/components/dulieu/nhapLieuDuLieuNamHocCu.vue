<template>
    <div v-loading.fullscreen.lock="fullScreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span>
                    Tiếp nhận dữ liệu QLNT
                    <span class="kytu">
                        &raquo;</span> Nộp dữ liệu kết quả học tập</span>
            </div>
        </div>
        <div class="card-bieu-do" style="padding:12px">
            <el-tabs v-model="activeName" @tab-click="handleClick">
                <el-tab-pane name="first">
                    <span slot="label"><i class="el-icon-download"></i> Tải file biểu mẫu</span>
                    <el-row :gutter="24">
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Đơn vị</label>
                            <eselect style="width:100%" :disabled="thongtin.role>3" collapseTags v-model="donVi"
                                @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                :fields="['tenDonVi','maDonVi']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <div>
                                <label class="typo__label">Cấp học</label>
                                <eselect style="width:100%" collapseTags v-model="capHoc" :disabled="true"
                                    @change="ChonCapHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                                    :fields="['name','id']" />
                            </div>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Trường học <span class="red">*</span> </label>
                            <eselect style="width:100%" :disabled="thongtin.role==5" collapseTags v-model="truongHoc"
                                :placeholder="'Chọn'" filterable :data="list_truong_hoc" :fields="['name','value']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Năm học </label>
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="24" class="text-center">
                            <el-button plain size="mini" v-on:click.prevent="getFileTemplate()" type="primary">Tải xuống
                            </el-button>
                        </el-col>
                    </el-row>
                </el-tab-pane>
                <el-tab-pane name="second">
                    <span slot="label"><i class="el-icon-upload2"></i> Nộp dữ liệu</span>
                    <el-row :gutter="24">
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Đơn vị</label>
                            <eselect style="width:100%" :disabled="thongtin.role>3" collapseTags v-model="donVi"
                                @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                :fields="['tenDonVi','maDonVi']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <div>
                                <label class="typo__label">Cấp học</label>
                                <eselect style="width:100%" collapseTags v-model="capHoc" :disabled="true"
                                    @change="ChonCapHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                                    :fields="['name','id']" />
                            </div>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Trường học <span class="red">*</span> </label>
                            <eselect style="width:100%" :disabled="thongtin.role==5" collapseTags v-model="truongHoc"
                                :placeholder="'Chọn'" filterable :data="list_truong_hoc" :fields="['name','value']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Năm học <span class="red">*</span> </label>
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </el-col>
                    </el-row>
                    <el-row :gutter="24">
                        <el-col :span="12" :offset="6" class="text-center">
                            <importFile :path="'/csdlgd-admin/hocSinh/upload-kqht-khoi678'"
                                @success="sauKhiImport($event)" :maTruong="truongHoc" :namHoc="namHoc"></importFile>
                        </el-col>
                    </el-row>
                </el-tab-pane>
                <el-tab-pane name="third">
                    <span slot="label"><i class="el-icon-files"></i> Kết quả import </span>
                    <el-row :gutter="24">
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Đơn vị <span  class="red">*</span></label>
                            <eselect style="width:100%" :disabled="thongtin.role>3" collapseTags v-model="donVi"
                                @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                :fields="['tenDonVi','maDonVi']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <div>
                                <label class="typo__label">Cấp học <span class="red">*</span></label>
                                <eselect style="width:100%" collapseTags v-model="capHoc" @change="ChonCapHoc"
                                    :placeholder="'Chọn'" filterable :data="list_cap_hoc_ket_qua"
                                    :fields="['name','id']" />
                            </div>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Trường học </label>
                            <eselect style="width:100%" :disabled="thongtin.role==5" collapseTags v-model="truongHoc"
                                :placeholder="'Chọn'" filterable :data="list_truong_hoc" :fields="['name','value']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Năm học <span class="red">*</span></label>
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="24" class="text-center">

                            <el-button plain size="mini" v-on:click.prevent="xemOnline()" type="success">Xem online
                            </el-button>
                            <el-button plain size="mini" v-on:click.prevent="taiXuongKetQua()" type="primary">Tải xuống
                            </el-button>
                        </el-col>
                    </el-row>
                </el-tab-pane>
            </el-tabs>
        </div>
        <div>
            <el-dialog title="Danh sách bản ghi lỗi" width="70%" top="5vh" :visible.sync="hienThiThongTinLoi">
                <el-table :max-height="maxHeight" height="600px" :data="danh_sach_that_bai"
                    :empty-text="'Không có dữ liệu'" style="width: 100%" border>
                    <el-table-column type="expand">
                        <template slot-scope="props">
                            <el-table :data="props.row.children" style="width: 100%" :empty-text="'Không có dữ liệu'"
                                border>
                                <el-table-column align="center">
                                    <template slot="header">
                                        <div>
                                            <p>Vị trí</p>
                                        </div>
                                        <div>
                                            <p>(<i>Hàng trong file excel</i>)</p>
                                        </div>
                                    </template>
                                    <template slot-scope="scope">
                                        <p>{{ scope.row.sttRowExcel + 9 }}</p>
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" label="Tên học sinh">
                                    <template slot-scope="scope">
                                        <p>{{ scope.row.name}}</p>
                                    </template>
                                </el-table-column>
                                <el-table-column header-align="center" label="Mô tả">
                                    <template slot-scope="scope">
                                        <p>{{ scope.row.message}}</p>
                                    </template>
                                </el-table-column>
                            </el-table>
                        </template>
                    </el-table-column>
                    <el-table-column label="Tên sheet">
                        <template slot-scope="scope">
                            <p>{{ scope.row.sheetName}}</p>
                        </template>
                    </el-table-column>
                </el-table>
            </el-dialog>
        </div>
    </div>
</template>
<script>
    import constant from '../../utils/constant';
    import importFile from '../import/ImportManySheet.vue';
    import rest_api from "../../utils/rest_api";
    import api from '../api';
    import ESelectVue from '../ui/ESelect.vue';
    import ElementUI from 'element-ui';
    Vue.use(ElementUI);
    export default {
        components: {
            'eselect': ESelectVue,
            'importFile': importFile,
        },
        props: [],
        data() {
            return {
                maxHeight: window.innerHeight,
                danh_sach_that_bai: [],
                activeName: 'first',
                hienThiThongTinLoi: false,
                fullScreenLoading: false,
                thongtin: JSON.parse(window.userInfo),
                donVi: "",
                capHoc: "",
                truongHoc: "",
                namHoc: "",
                list_don_vi: [],
                list_cap_hoc: window.listCapHoc,
                list_cap_hoc_ket_qua: [],
                list_truong_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                baseLink: "/view-excel?path=",
            }
        },
        watch: {},
        mounted: function () {
            this.maxHeight -= 250;
            this.thongtin = JSON.parse(window.userInfo);
            console.log(this.list_cap_hoc)
            this.mapCapHocKetQua();
            this.namHoc = this.thongtin.namHocHienTai;
            this.capHoc = 2;
            if (this.thongtin.role == 5) {
                this.donVi = this.thongtin.ma_don_vi;
                this.truongHoc = this.thongtin.ma_truong_hoc;
                this.capHoc = this.thongtin.listCapHoc[0];
                for (let i = 0; i < this.thongtin.listCapHoc.length; i++) {
                    if (this.thongtin.listCapHoc[i] == 1) {
                        this.capHoc = 1;
                    }
                    if (this.thongtin.listCapHoc[i] == 2) {
                        this.capHoc = 2;
                    }
                }
            }
            if (this.thongtin.role == 4) {
                this.donVi = this.thongtin.ma_don_vi;
            }
            this.getDonVi();
            this.getTruongHoc();
        },
        methods: {
            mapCapHocKetQua() {
                this.list_cap_hoc_ket_qua = [];
                for (let i = 0; i < this.list_cap_hoc.length; i++) {
                    if (this.list_cap_hoc[i].id == 1 || this.list_cap_hoc[i].id == 2) {
                        this.list_cap_hoc_ket_qua.push(this.list_cap_hoc[i])
                    }
                }
            },
            taiXuongKetQua() {

                if (!this.donVi || this.donVi == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin đơn vị.')
                    return
                }
                if (!this.capHoc) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin cấp học.')
                    return
                }
                if (this.capHoc != 2 && this.capHoc != 1) {
                    this.thongBao('error', 'Chức năng tạm thời chỉ phục vụ cho các trường tiều học và trung học cở sở.')
                    return;
                }
                if (!this.namHoc || this.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin năm học');
                    return
                }
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.thongBao('success','Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        this.fullScreenLoading = true;
                        let params = {
                            capHoc: parseInt(this.capHoc),
                            maSo: this.thongtin.ma_so.toString(),
                            maTruongHoc: this.truongHoc,
                            maPhong: this.donVi,
                            namHoc: this.namHoc
                        }
                        rest_api.post('/csdlgd-admin/export-excel/hoc-sinh-tsdc-tnn', params, (data) => {
                            this.fullScreenLoading = false;
                            console.log(data)
                            if (data.data.rc == 0) {
                                this.thongBao('success', 'Tải xuống thành công');
                                let url = this.thongtin.tenMien + data.data.item;
                                window.open(url);
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            xemOnline() {
                if (!this.donVi || this.donVi == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin đơn vị.')
                    return
                }
                if (!this.capHoc) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin cấp học.')
                    return
                }
                if (this.capHoc != 2 && this.capHoc != 1) {
                    this.thongBao('error', 'Chức năng tạm thời chỉ phục vụ cho các trường tiểu học và trung học cở sở.')
                    return;
                }
                if (!this.namHoc || this.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin năm học');
                    return
                }
                this.$confirm('Xác nhận lấy dữ liệu?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.fullScreenLoading = true;
                        let params = {
                            capHoc: parseInt(this.capHoc),
                            maSo: this.thongtin.ma_so.toString(),
                            maTruongHoc: this.truongHoc,
                            maPhong: this.donVi,
                            namHoc: this.namHoc
                        }
                        console.error("Thông tin lấy kq:")
                        console.error(params)
                        rest_api.post('/csdlgd-admin/export-excel/hoc-sinh-tsdc-tnn', params, (data) => {
                            console.log(data)
                            if (data.data.rc == 0) {
                                this.thongBao('success', 'Đang mở trong thẻ mới...');
                                let uri = this.thongtin.tenMien + data.data.item;
                                var d = new Date();
                                var n = d.getTime();
                                let url = this.baseLink + uri + '?time=' + n;
                                console.log("url")
                                console.log(url)
                                setTimeout(() => {
                                    window.open(url, '_blank');
                                    this.fullScreenLoading = false;
                                }, 1500);
                            } else {
                                this.fullScreenLoading = false;
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            xoaFile() {
                console.log("Xóa file")
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                this.fullScreenLoading = true;
                let params = {
                    maDonVi: [],
                    capHoc: [],
                };
                if (this.donVi && this.donVi != '') {
                    params.maDonVi = [this.donVi];
                }
                if (this.capHoc && this.capHoc != '') {
                    params.capHoc = [this.capHoc];
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    this.fullScreenLoading = false;
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
            sauKhiImport(e) {
                console.log("emit")
                if (e) {
                    let res = e;
                    if (res.countSuccess > 0) {
                        let mess = 'Đã import thành công ' + res.countSuccess + ' bản ghi';
                        this.thongBao('success', mess)
                    }
                    if (res.countError > 0) {
                        let mess = 'Import thất bại ' + res.countError + ' bản ghi'
                        this.thongBao('error', mess)
                        this.danh_sach_that_bai = res.messages;
                        for (let i = 0; i < this.danh_sach_that_bai.length; i++) {
                            this.danh_sach_that_bai[i].id = i + 1;
                            if (this.danh_sach_that_bai[i].children) {
                                for (let j = 0; j < this.danh_sach_that_bai[i].children.length; j++) {
                                    this.danh_sach_that_bai[i].children[j].id = this.danh_sach_that_bai[i].id + '-' + j
                                }
                            }
                        }
                        console.table(this.danh_sach_that_bai)
                        this.hienThiThongTinLoi = true;
                    }
                }
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
                    } else {
                        this.thongBao('error', data.data.message)
                    }
                });
            },
            ChonCapHoc() {
                this.truongHoc = '';
                this.getTruongHoc();
            },
            ChonDonVi() {
                this.truongHoc = '';
                this.getTruongHoc();
            },
            handleClick(tab, event) {
                this.fullScreenLoading = true;
                if (this.activeName == 'third') {
                    this.capHoc = 1;
                    this.truongHoc = '';
                    this.getTruongHoc();
                } else {
                    this.capHoc = 2;
                    this.truongHoc = '';
                    this.getTruongHoc();
                }
                setTimeout(() => {
                    this.fullScreenLoading = false;
                }, 500);
            },
            getFileTemplate() {
                if (this.capHoc != 2) {
                    this.thongBao('error', 'Chức năng tạm thời chỉ phục vụ cho các trường trung học cở sở.')
                    return;
                }
                if (!this.truongHoc || this.truongHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin trường học');
                    return
                }
                if (!this.namHoc || this.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin năm học');
                    return
                }
                let url = '/csdlgd-report-api/excel-form/kqht';
                let params = {
                    maTruongHoc: this.truongHoc,
                    namHoc: this.namHoc
                }
                console.log("Tải xuống")
                this.$confirm('Xác nhận tải xuống dữ liệu?',
                        'Thông báo', {
                            confirmButtonText: 'Xác nhận',
                            cancelButtonText: 'Hủy',
                            closeOnClickModal: false,
                        })
                    .then(_ => {
                        this.thongBao('success','Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        this.fullScreenLoading = true;
                        rest_api.post(url, params, (data) => {
                            this.fullScreenLoading = false;
                            console.log(data)
                            if (data.data.rc == 0) {
                                setTimeout(()=>{
                                    this.thongBao('success', 'Tải xuống thành công');
                                    let url = this.thongtin.tenMien + data.data.urlContext;
                                    window.open(url);
                                },1000)
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
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
        }
    }

</script>
<style scoped="scoped">
    .xoafile {
        color: #DC0101;
        border: 1px solid black;
        padding: 0 4px;
        margin: 0;
        border-radius: 50%;
        background: snow;
        font-weight: bold;
    }

</style>

<template>
    <div v-loading="loading" element-loading-text="Loading..." element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <div>
            <div>
                <div class="card-bieu-do">
                    <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Đơn vị quản lý</label>
                            <eselect style="width:100%" collapseTags v-model="maDonViQuanLy" :placeholder="'Chọn'"
                                @change="ChonCapHoc" filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="4" :lg="3">
                            <label class="typo__label">Cấp học</label>
                            <eselect style="width:100%" collapseTags v-model="capHoc" @change="ChonCapHoc"
                                :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Trường học</label>
                            <eselect style="width:100%" collapseTags v-model="maTruongHoc" :placeholder="'Chọn'"
                                filterable :data="list_truong_hoc" :fields="['tenTruongHoc','maTruongHoc']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="4" :lg="3">
                            <label class="typo__label">Năm học</label>
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="4" :lg="3">
                            <label class="typo__label">Học kỳ</label>
                            <eselect style="width:100%" collapseTags v-model="hocKy" :placeholder="'Chọn'" filterable
                                :data="list_hoc_ky" :fields="['name','value']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="4" :lg="3">
                            <label class="typo__label">Giai đoạn</label>
                            <eselect style="width:100%" collapseTags v-model="maGiaiDoan" :placeholder="'Chọn'"
                                filterable :data="list_giai_doan" :fields="['name','value']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Tiêu chí gốc</label>
                            <eselect style="width:100%" collapseTags v-model="tieuChiGoc" @change="ChonTieuChiGoc"
                                :placeholder="'Chọn'" filterable :data="danh_sach_tieu_chi_goc"
                                :fields="['name','value']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Tên tiêu chí</label>
                            <el-input clearable disabled placeholder="Nhập..." v-model="tenTieuChi"></el-input>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8" :lg="6">
                            <label class="typo__label">Mã tiêu chí</label>
                            <el-input clearable disabled placeholder="Nhập..." v-model="maTieuChi"></el-input>
                        </el-col>
                    </el-row>
                    <el-row :gutter="24" style="padding-top:10px">
                        <el-col :span="24" class="text-center">
                            <el-button size="mini" type="primary" @click.prevent="TruocKhiTim()">Tìm
                                kiếm</el-button>
                        </el-col>
                    </el-row>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-4 reset'>
                    <ChonSoLuong @chonXongSoLuong="ChonSoLuongBanGhi($event)">
                    </ChonSoLuong>
                </div>
                <div class='col-md-8 reset'>
                    <div class="text-right" style="padding-bottom:5px">
                        <el-tooltip content="Tùy chọn nội dung hiển thị" placement="top">
                            <el-button type="info" size="mini" data-toggle="collapse" data-target="#tuychonhienthi">Tùy
                                chọn
                                hiển
                                thị
                            </el-button>
                        </el-tooltip>
                    </div>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-12'>
                    <div id="tuychonhienthi" class="collapse">
                        <input v-model="hienThiTatCa" @change="chonHienThiTatCa" type="checkbox" />
                        <span style="padding-right:15px">Tất cả</span>
                        <input v-model="hienThi.donViQuanLy" type="checkbox" />
                        <span style="padding-right:15px">Đơn vị quản lý</span>
                        <input v-model="hienThi.capHoc" type="checkbox" />
                        <span style="padding-right:15px">Cấp học</span>
                        <input v-model="hienThi.maTruongHoc" type="checkbox" />
                        <span style="padding-right:15px">Trường học</span>
                        <input v-model="hienThi.namHoc" type="checkbox" />
                        <span style="padding-right:15px">Năm học</span>
                        <input v-model="hienThi.hocKy" type="checkbox" />
                        <span style="padding-right:15px">Học kỳ</span>
                        <input v-model="hienThi.maGiaiDoan" type="checkbox" />
                        <span style="padding-right:15px">Giai đoạn</span>
                        <input disabled v-model="hienThi.tenTieuChi" type="checkbox" />
                        <span style="padding-right:15px">Tên tiêu chí</span>
                        <input disabled v-model="hienThi.maTieuChi" type="checkbox" />
                        <span style="padding-right:15px">Mã tiêu chí</span>
                        <input disabled v-model="hienThi.maNhapLieu" type="checkbox" />
                        <span style="padding-right:15px">Mã nhập liệu</span>
                        <input disabled v-model="hienThi.giaTri" type="checkbox" />
                        <span style="padding-right:15px">Giá trị</span>
                    </div>
                </div>
            </div>
            <div class="table-responsive" style="margin-top:5px">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr style="background:rgb(228, 235, 245)">
                            <th class="text-center">
                                <p>STT</p>
                            </th>
                            <th class="text-center" style="min-width:200px" v-if='hienThi.donViQuanLy'>
                                <p>Đơn vị quản lý</p>
                            </th>
                            <th class="text-center" v-if='hienThi.capHoc' style="width:min-100px">
                                <p>Cấp học</p>
                            </th>
                            <th class="text-center" v-if='hienThi.maTruongHoc' style="min-width:200px">
                                <p>Trường học</p>
                            </th>
                            <th class="text-center" v-if='hienThi.namHoc' style="min-width:100px">
                                <p>Năm học</p>
                            </th>
                            <th class="text-center" v-if='hienThi.hocKy' style="min-width:100px">
                                <p>Học kỳ</p>
                            </th>
                            <th class="text-center" v-if='hienThi.maGiaiDoan' style="min-width:100px">
                                <p>Giai đoạn</p>
                            </th>
                            <th class="text-center" v-if='hienThi.tenTieuChi'>
                                <p>Tên tiêu chí</p>
                            </th>
                            <th class="text-center" v-if='hienThi.maTieuChi'>
                                <p>Mã tiêu chí</p>
                            </th>
                            <th class="text-center" v-if='hienThi.maNhapLieu'>
                                <p>Mã nhập liệu</p>
                            </th>
                            <th class="text-center" v-if='hienThi.giaTri'>
                                <p>Giá trị</p>
                            </th>
                        </tr>
                    </thead>
                    <tbody v-if="danh_sach_du_lieu.length===0">
                        <tr>
                            <td class="text-center" colspan="10">
                                <p>Không có bản ghi nào</p>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr v-for="(tt,index) in danh_sach_du_lieu">
                            <td class="text-center">
                                <p>{{(currentPage-1)*limit + index+1}}</p>
                            </td>
                            <td v-if='hienThi.donViQuanLy'>
                                <template>
                                    <p>{{getTenDonVi(tt.maDonViQuanLy)}}</p>
                                </template>
                            </td>
                            <td v-if='hienThi.capHoc'>
                                <template>
                                    <p>{{getTenCapHoc(tt.capHocList)}}</p>
                                </template>
                            </td>
                            <td v-if='hienThi.maTruongHoc'>
                                <template>
                                    <p>{{getTenTruongHoc(tt.maTruongHoc)}}</p>
                                </template>
                            </td>
                            <td class="text-center" v-if='hienThi.namHoc'>
                                <template>
                                    <p>{{tt.namHoc}} - {{tt.namHoc+1}}</p>
                                </template>
                            </td>
                            <td class="text-center" v-if='hienThi.hocKy'>
                                <template>
                                    <p>{{tt.hocKy}}</p>
                                </template>
                            </td>
                            <td class="text-center" v-if='hienThi.maGiaiDoan'>
                                <template>
                                    <p>{{tt.maGiaiDoan}}</p>
                                </template>
                            </td>
                            <td v-if='hienThi.tenTieuChi'>
                                <p>{{tt.tenTieuChi}} </p>
                            </td>
                            <td v-if='hienThi.maTieuChi'>
                                <el-tooltip content="Nhấn đúp để sao chép" placement="right">
                                    <el-button type="primary" v-on:dblclick.native="saoChepMaTieuChi(tt)" size="mini">
                                        {{tt.maTieuChi}}</el-button>
                                </el-tooltip>
                            </td>
                            <td v-if='hienThi.maNhapLieu'>
                                <el-tooltip content="Nhấn đúp để sao chép" placement="right">
                                    <el-button type="primary" v-on:dblclick.native="saoChepMaNhapLieu(tt)" size="mini">
                                        {{tt.maNhapLieu}}</el-button>
                                </el-tooltip>
                            </td>
                            <td v-if='hienThi.giaTri'>
                                <p>{{tt.giaTri}}</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <PhanTrang v-show="total_rows>0" :tongbanghi="total_rows" :soluonghienthi="soLuongBanGhiHienThi"
                :batdau="trangbatdau" @pageChange="layLai($event)">
            </PhanTrang>
        </div>
        <!-- Thêm mới tiêu chí -->
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import PhanTrang from "../../ui/PhanTrang";
    import ChonSoLuong from "../../ui/chonSoLuongBanGhi";
    import ESelectVue from '../../ui/ESelect.vue';
    import rest_api from "../../../utils/rest_api";
    import constant from '../../../utils/constant';
    Vue.use(ElementUI);
    export default {
        props: [],
        components: {
            "PhanTrang": PhanTrang,
            'eselect': ESelectVue,
            ChonSoLuong: ChonSoLuong,
        },
        computed: {},
        data() {
            return {
                loading: false,
                thongtin: JSON.parse(window.userInfo),
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                soLuongBanGhiHienThi: 25,
                danh_sach_du_lieu: [],
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_giai_doan: [{
                        name: 'Giữa kỳ I',
                        value: 'GKI'
                    },
                    {
                        name: 'Cuối kỳ I',
                        value: 'CKI'
                    },
                    {
                        name: 'Giữa kỳ II',
                        value: 'GKII'
                    },
                    {
                        name: 'Cuối kỳ II',
                        value: 'CKII'
                    }
                ],
                list_hoc_ky: [{
                        name: "Học kỳ I",
                        value: 1
                    },
                    {
                        name: "Học kỳ II",
                        value: 2
                    },
                    {
                        name: "Cả năm",
                        value: 3
                    },
                ],
                trangbatdau: false,
                tieuChiGoc: "",
                danh_sach_tieu_chi_goc: [],
                list_don_vi: [],
                list_truong_hoc: [],
                list_truong_hoc_them: [],
                maDonViQuanLy: '',
                capHoc: '',
                maTruongHoc: '',
                namHoc: '',
                hocKy: '',
                maGiaiDoan: '',
                tenTieuChi: '',
                maTieuChi: '',
                hienThiTatCa: false,
                hienThi: {
                    donViQuanLy: false,
                    capHoc: false,
                    maTruongHoc: false,
                    namHoc: false,
                    hocKy: false,
                    maGiaiDoan: false,
                    tenTieuChi: true,
                    maTieuChi: true,
                    giaTri: true,
                    maNhapLieu: true,
                },
                du_lieu_chinh_sua: {}
            };
        },
        mounted() {
            console.log()
            this.getDanhSachTieuChiGoc();
            this.getDonVi();
            this.getDanhSachToanBoTruong();
            console.log("Thông tin đăng nhập:")
            console.log(this.thongtin);
            this.namHoc = this.thongtin.namHocHienTai;
            this.getData();
        },
        watch: {},
        methods: {
            saoChepMaTieuChi(e) {
                var copyText = e.maTieuChi;
                navigator.clipboard.writeText(copyText);
                this.thongBao('success', "Sao chép thành công.");
            },
            saoChepMaNhapLieu(e) {
                var copyText = e.maNhapLieu;
                navigator.clipboard.writeText(copyText);
                this.thongBao('success', "Sao chép thành công.");
            },
            chonHienThiTatCa() {
                console.log("Chọn hiển thị tất cả:")
                console.log(this.hienThiTatCa)
                if (this.hienThiTatCa) {
                    this.hienThi.donViQuanLy = true;
                    this.hienThi.capHoc = true;
                    this.hienThi.maTruongHoc = true;
                    this.hienThi.namHoc = true;
                    this.hienThi.hocKy = true;
                    this.hienThi.maGiaiDoan = true;
                } else {
                    this.hienThi.donViQuanLy = false;
                    this.hienThi.capHoc = false;
                    this.hienThi.maTruongHoc = false;
                    this.hienThi.namHoc = false;
                    this.hienThi.hocKy = false;
                    this.hienThi.maGiaiDoan = false;
                }
            },
            ChonTieuChiGoc() {
                console.log(this.tieuChiGoc);
                this.tenTieuChi = "";
                this.maTieuChi = "";
                if (this.tieuChiGoc && this.tieuChiGoc != '') {
                    for (let i = 0; i < this.danh_sach_tieu_chi_goc.length; i++) {
                        if (this.danh_sach_tieu_chi_goc[i].value == this.tieuChiGoc) {
                            console.log("Chính là thằng này:")
                            console.log(this.danh_sach_tieu_chi_goc[i]);
                            this.tenTieuChi = this.danh_sach_tieu_chi_goc[i].label;
                            this.maTieuChi = this.danh_sach_tieu_chi_goc[i].value;
                        }
                    }
                }
            },
            getTenDonVi(e) {
                let name = "";
                if (e) {
                    for (let i = 0; i < this.list_don_vi.length; i++) {
                        if (this.list_don_vi[i].maDonVi == e) {
                            name = this.list_don_vi[i].tenDonVi
                        }
                    }
                }
                return name;
            },
            getTenCapHoc(e) {
                let name = "";
                if (e) {
                    for (let i = 0; i < this.list_cap_hoc.length; i++) {
                        if (this.list_cap_hoc[i].id == e) {
                            name = this.list_cap_hoc[i].name
                        }
                    }
                }
                return name;
            },
            getTenTruongHoc(e) {
                let name = "";
                if (e) {
                    for (let i = 0; i < this.list_truong_hoc.length; i++) {
                        if (this.list_truong_hoc[i].maTruongHoc == e) {
                            name = this.list_truong_hoc[i].tenTruongHoc
                        }
                    }
                }
                return name;
            },
            ChonCapHoc() {
                this.maTruongHoc = '';
                this.list_truong_hoc = [];
                this.getDanhSachToanBoTruong();
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
            getDanhSachToanBoTruong() {
                this.loading = true;
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: [],
                    capHoc: []
                };
                if (this.maDonViQuanLy) {
                    params.maDonVi = [this.maDonViQuanLy];
                }
                if (this.capHoc) {
                    params.capHoc = [this.capHoc];
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    this.loading = false;
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
                        this.list_truong_hoc_them = ldv;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },
            getDanhSachTruong(e) {
                let data = [];
                let don_vi = e;
                if (don_vi) {
                    for (let i = 0; i < don_vi.length; i++) {
                        for (let j = 0; j < this.list_truong_hoc.length; j++) {
                            if (don_vi[i] == this.list_truong_hoc[j].maDonVi) {
                                data.push(this.list_truong_hoc[j])
                            }
                        }
                    }
                }
                return data;
            },
            getDanhSachTieuChiGoc() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let url = "/csdlgd-analytic-api/criteria/search?skip=0&limit=9999"
                const params = {
                    "doiTuong": 'Custom',
                    "maTieuChi": '',
                    "tenTieuChi": '',
                    "textSreach": '',
                    "tieuChiHeThong": false,
                };
                this.danh_sach_tieu_chi_goc = [];
                rest_api.post(url, params, response => {
                    loading.close();
                    console.log("response:")
                    console.error(response)
                    if (response.data.rc == 0) {
                        let data = response.data.rows;
                        if (data.length > 0) {
                            for (let i = 0; i < data.length; i++) {
                                let obj = {
                                    name: data[i].tenTieuChi + " - [" + data[i].maTieuChi + "]",
                                    value: data[i].maTieuChi,
                                    label: data[i].tenTieuChi
                                }
                                if (data[i].maTieuChi == this.tieuChiGoc) {
                                    this.tenTieuChi = data[i].tenTieuChi;
                                }
                                this.danh_sach_tieu_chi_goc.push(obj);
                            }
                        } else {
                            this.thongBao('error', 'Vui lòng bổ sung tiêu chí hệ thống.')
                        }
                    } else {}
                });
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                this.list_don_vi = [];
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
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
                    } else {}
                });
            },
            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                console.log("Chọn số lượng bản ghi:")
                console.log(JSON.stringify(e));
                this.soLuongBanGhiHienThi = e.soluong;
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            TruocKhiTim() {
                console.log("Ấn tìm kiếm")
                this.total_rows = 0;
                this.trangbatdau = !this.trangbatdau;
            },
            getData() {
                this.loading = true;
                let analyticExternalData = {};
                if (this.maDonViQuanLy) {
                    analyticExternalData.maDonViQuanLy = this.maDonViQuanLy
                }
                if (this.maGiaiDoan) {
                    analyticExternalData.maGiaiDoan = this.maGiaiDoan
                }
                if (this.maTieuChi) {
                    analyticExternalData.maTieuChi = this.maTieuChi
                }
                if (this.maTruongHoc) {
                    analyticExternalData.maTruongHoc = this.maTruongHoc
                }
                if (this.tenTieuChi) {
                    analyticExternalData.tenTieuChi = this.tenTieuChi
                }
                if (this.namHoc) {
                    analyticExternalData.namHoc = this.namHoc
                }
                let params = {
                    start: this.start,
                    limit: this.limit,
                    analyticExternalData
                }
                this.danh_sach_du_lieu = [];
                this.total_rows = 0;
                rest_api.post("/csdlgd-analytic-api/external-data/find-all", params, data => {
                    this.loading = false;
                    console.log("Danh sách tiêu chí ngoài:")
                    console.log(data)
                    if (data.statusText == 'OK') {
                        console.log("Lấy thành công");
                        if (data.data.content.length >= 1) {
                            data.data.content.forEach(item => {
                                item.type = '';
                                if (item.capHocList) {
                                    item.capHocList = parseInt(item.capHocList);
                                }
                                this.danh_sach_du_lieu.push(item)
                            })
                            this.total_rows = data.data.totalElements
                            // this.thongBao('success', 'Lấy dữ liệu thành công')
                        } else {
                            // this.thongBao('error', 'Không có bản ghi nào được tìm thấy')
                        }
                    } else {
                        this.thongBao('error', data.data.rd)
                    }
                });
            }
        }
    };

</script>
<style scoped="scoped">
    .themMoi {
        background: #a5d8c0 !important;
    }

    td p {
        padding: 0;
        margin: 0
    }
</style>

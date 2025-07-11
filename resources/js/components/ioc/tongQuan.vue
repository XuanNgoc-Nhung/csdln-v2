<template>
    <div>
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="ioc/logoThaiNguyen.png" alt="Logo IOC" height="60" width="60">
        </div>
        <nav class="main-header navbar navbar-expand">
            <el-row :gutter="20" style="width:100%">
                <el-col :span="4">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                    class="fas fa-bars"></i></a>
                        </li>
                    </ul>
                </el-col>
                <el-col :span="20">
                    <el-row :gutter="24">
                        <el-col :span="9">
                            <eselect style="width:100%" multiple collapseTags v-model="maDonVi"
                                :placeholder="'Chọn'" filterable :data="list_don_vi"
                                :fields="['name','value']" />
                        </el-col>
                        <el-col :span="5">
                            <eselect style="width:100%" multiple collapseTags v-model="capHoc"
                                :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :span="4">
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn năm học'"
                                filterable :data="list_nam_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :span="4">
                            <el-button size="mini" @click.prevent="layToanBoDuLieu" type="success">Thống kê</el-button>
                        </el-col>
                        <el-col :span="2" class="action-header">
                            <div class="nav-item action-buttom">
                                <span style="color:blue" class="" data-widget="fullscreen" role="button">
                                    <i class="fas fa-expand-arrows-alt"></i>
                                </span>
                            </div>
                            <div class="nav-item action-buttom">
                                <a class="" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                                    <i class="fas fa-th-large"></i>
                                </a>
                            </div>
                        </el-col>
                    </el-row>
                </el-col>
            </el-row>
        </nav>
        <aside class="main-sidebar elevation-4">
            <a href="index.html" class="brand-link">
                <img src="ioc/logoThaiNguyen.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                    style="opacity: .8">
                <span class="brand-text font-weight-light">CSDL Ngành</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="ioc/teach.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Sở GD&ĐT Thái Nguyên</a>
                    </div>
                </div>
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link active">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link" :class="{ 'active': currentUrl=='/dashboard'}">
                                <i class="fa fa-building" aria-hidden="true"></i>
                                <p>
                                    Trường học
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="pages/widgets.html" class="nav-link">
                                <i class="fa fa-users"></i>
                                <p>
                                    Cán bộ
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
        <div class="content-wrapper">
            <div class="content-header">
                <section class="content">
                    <div class="container-fluid">
                        <!-- <div class="row">
                            <div class="col-12" style="padding-bottom:10px"> -->
                        <div class='hienThiBanDo card-bieu-do'>
                            <banDo :item="dataMap"></banDo>
                            <!-- Biểu đồ trường học -->
                            <el-row :gutter="20" v-if='false'>
                                <el-col :span="22">
                                    <h5> <i class="fas fa-school"></i> Biểu đồ trường học</h5>
                                </el-col>
                                <el-col :span="2" class="text-right">
                                    <el-button plain type="success" size="mini">Chi tiết
                                    </el-button>
                                </el-col>
                                <el-col :md="24" :lg="8">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Tổng quan</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoTongQuanTruongHoc"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.tongQuanTruongHoc"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoHinhTron :dulieu="duLieuTongQuanTruongHoc">
                                                </BieuDoHinhTron>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Chất lượng đào tạo</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoTruongHocTheoChatLuongDaoTao"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.chatLuongDaoTaoTruongHoc"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :dulieu="duLieuTruongHocTheoChatLuongDaoTao">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Loại hình đào tạo</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoTruongHocTheoLoaiHinhDaoTao"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.loaiHinhDaoTaoTruongHoc"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :dulieu="duLieuTruongHocTheoLoaiHinhDaoTao">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                            </el-row>
                            <!-- Hết biểu đồ trường học -->
                            <!-- Biểu đồ cán bộ -->
                            <el-row :gutter="20"  v-if='false'>
                                <el-col :span="22">
                                    <h5><i class="fas fa-chalkboard-teacher"></i> Biểu đồ Cán bộ - Giáo viên</h5>
                                </el-col>
                                <el-col :span="2" class="text-right">
                                    <el-button plain type="success" size="mini">Chi tiết
                                    </el-button>
                                </el-col>
                                <el-col :md="24" :lg="6">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Tổng quan</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoTongQuanCanBoGiaoVien"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.tongQuanCanBoGiaoVien"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoHinhTron :label="label.canBo.tongQuan"
                                                    :dulieu="duLieuTongQuanCanBoGiaoVien">
                                                </BieuDoHinhTron>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="24" :lg="6">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Giới tính</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoGioiTinhCanBoGiaoVien"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.gioiTinhCanBoGiaoVien"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoHinhTron :label="label.canBo.gioiTinh"
                                                    :dulieu="duLieuGioiTinhCanBoGiaoVien">
                                                </BieuDoHinhTron>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :span="24" style="height:15px"></el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Trình độ chính</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoCanBoGiaoVienTheoTrinhDoChinh"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.trinhDoChinhCanBoGiaoVien"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.canBo.trinhDoChinh"
                                                    :dulieu="duLieuTrinhDoChinhCanBoGiaoVien">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <!-- Loại hợp đồng -->
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Loại hợp đồng</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoCanBoGiaoVienTheoLoaiHopDong"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.loaiHopDongCanBoGiaoVien"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.canBo.loaiHopDong"
                                                    :dulieu="duLieuLoaiHopDongCanBoGiaoVien">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                            </el-row>
                            <!-- Hết biểu đồ cán bộ -->
                            <!-- Biểu đồ học sinh -->

                            <el-row :gutter="20" v-if='false'>
                                <el-col :span="22">
                                    <h5> <i class="fas fa-user-graduate"></i> Biểu đồ Học sinh</h5>
                                </el-col>
                                <el-col :span="2" class="text-right">
                                    <el-button plain type="success" size="mini">Chi tiết
                                    </el-button>
                                </el-col>
                                <el-col :md="24" :lg="6">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Tổng quan</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoTongQuanHocSinh"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.tongQuanHocSinh"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoHinhTron :label="label.hocSinh.tongQuan"
                                                    :dulieu="duLieuTongQuanHocSinh">
                                                </BieuDoHinhTron>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :md="24" :lg="6">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Giới tính</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoGioiTinhHocSinh"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.gioiTinhHocSinh"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoHinhTron :label="label.canBo.gioiTinh"
                                                    :dulieu="duLieuGioiTinhHocSinh">
                                                </BieuDoHinhTron>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                <el-col :span="24" style="height:15px"></el-col>
                                <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Trạng thái học sinh</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoHocSinhTheoTrangThai"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.trangThaiHocSinh"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.hocSinh.trangThai"
                                                    :dulieu="duLieuTrangThaiHocSinh">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                                 <el-col :md="12" :lg="12">
                                    <div class="dts-moibieudo grid-content bg-purple-light">
                                        <div class="dts-card-header">
                                            <span class="dts-card-title">Loại hình đào tạo</span>
                                            <span class="dts-right"><a href="#"
                                                    @click.prevent="layBieuDoHocSinhTheoLoaiHinhDaoTao"
                                                    title="Lấy lại dữ liệu thống kê"><i
                                                        class="fa-solid fa-rotate-right"></i></a>
                                            </span>
                                        </div>
                                        <div class="dts-card-body">
                                            <div v-loading="loading.loaiHinhDaoTaoHocSinh"
                                                element-loading-background="rgba(0, 0, 0, 0.8)">
                                                <BieuDoCotChong :label="label.hocSinh.loaiHinhDaoTao"
                                                    :dulieu="duLieuLoaiHinhDaoTaoHocSinh">
                                                </BieuDoCotChong>
                                            </div>
                                        </div>
                                    </div>
                                </el-col>
                            </el-row>
                            <!-- Hết biểu đồ học sinh -->
                        </div>
                        <!-- </div>
                        </div> -->
                    </div>
                </section>
            </div>
            <aside class="control-sidebar control-sidebar-dark">
            </aside>
        </div>
    </div>
</template>
<script>
    import ESelectVue from '../ui/ESelect.vue';
    import rest_api from "../../utils/rest_api";
    import ElementUI from 'element-ui';
    import banDo from './banDo';
    import BieuDoHinhTron from './bieuDoHinhTron';
    import BieuDoCotChong from './BieuDoCotChong';
    import constant from '../../utils/constant';
    Vue.use(ElementUI);
    export default {
        components: {
            'eselect': ESelectVue,
            'banDo': banDo,
            'BieuDoHinhTron': BieuDoHinhTron,
            'BieuDoCotChong': BieuDoCotChong,
        },
        data() {
            return {
                currentUrl:'',
                thongtin: JSON.parse(window.userInfo),
                list_don_vi: [],
                maDonVi: [],
                capHoc: [],
                namHoc: '',
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                dataMap: '',
                loading: {
                    tongQuanTruongHoc: false,
                    chatLuongDaoTaoTruongHoc: false,
                    loaiHinhDaoTaoTruongHoc: false,
                    tongQuanTruongHoc: false,
                    trinhDoChinhCanBoGiaoVien: false,
                    loaiHopDongCanBoGiaoVien: false,
                    tongQuanHocSinh: false,
                    gioiTinhHocSinh: false,
                    trangThaiHocSinh: false,
                    loaiHinhDaoTaoHocSinh: false,
                },
                label: {
                    canBo: {
                        tongQuan: ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên cấp'],
                        gioiTinh: ['Nam', 'Nữ'],
                        trinhDoChinh: ['Tiến sĩ', 'Thạc sĩ', 'Đại học', 'Cao Đẳng', 'Trung cấp'],
                        loaiHopDong: ['HĐ XĐ thời hạn', 'HĐ KXĐ thời hoạn', 'HĐ lao động'],
                    },
                    hocSinh:{
                        tongQuan:['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên cấp'],
                        trangThai:['Đang học','Bỏ học', 'Chuyển trường'],
                        loaiHinhDaoTao:['Công lập','Dân lập','Tư thục'],
                    }
                },
                duLieuTongQuanTruongHoc: [0],
                duLieuTruongHocTheoChatLuongDaoTao: [],
                duLieuTruongHocTheoLoaiHinhDaoTao: [],
                duLieuTongQuanCanBoGiaoVien: [0],
                duLieuGioiTinhCanBoGiaoVien: [0],
                duLieuTrinhDoChinhCanBoGiaoVien: [],
                duLieuLoaiHopDongCanBoGiaoVien: [],
                duLieuTongQuanHocSinh: [0],
                duLieuGioiTinhHocSinh: [0],
                duLieuTrangThaiHocSinh: [],
                duLieuLoaiHinhDaoTaoHocSinh: [],
            }
        },
        mounted() {
            console.log("thông tin đăng nhập:" + this.thongtin);
            console.log(this.thongtin);
            this.currentUrl =  window.location.pathname;
            console.log(this.currentUrl)
            this.namHoc = this.thongtin.namHocHienTai;
            this.getDonVi();
            this.layToanBoDuLieu()
        },
        methods: {
            getDonVi() {
                console.log("lấy đơn vị")
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
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
            layToanBoDuLieu() {
                // this.getDataBanDo();
                // this.layBieuDoTongQuanTruongHoc();
                // this.layBieuDoTruongHocTheoChatLuongDaoTao();
                // this.layBieuDoTruongHocTheoLoaiHinhDaoTao();
                this.layBieuDoTongQuanCanBoGiaoVien();
                this.layBieuDoGioiTinhCanBoGiaoVien();
                this.layBieuDoCanBoGiaoVienTheoTrinhDoChinh();
                this.layBieuDoCanBoGiaoVienTheoLoaiHopDong();
                // this.layBieuDoTongQuanHocSinh()
                // this.layBieuDoGioiTinhHocSinh()
                // this.layBieuDoHocSinhTheoTrangThai()
                // this.layBieuDoHocSinhTheoLoaiHinhDaoTao()
            },
            layBieuDoCanBoGiaoVienTheoLoaiHopDong() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.loaiHopDongCanBoGiaoVien = true;
                rest_api.post("/csdlgd-report-api/dasboard/canbogvloaiHD", params, data => {
                    this.loading.loaiHopDongCanBoGiaoVien = false;
                    if (data.data.rc == 0) {
                        this.duLieuLoaiHopDongCanBoGiaoVien = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuLoaiHopDongCanBoGiaoVien = this.ganViTri(dulieu);
                        this.duLieuLoaiHopDongCanBoGiaoVien.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuLoaiHopDongCanBoGiaoVien = []
                    }
                    console.log("duLieuLoaiHopDongCanBoGiaoVien")
                    console.log(this.duLieuLoaiHopDongCanBoGiaoVien)
                });
            },
            layBieuDoCanBoGiaoVienTheoTrinhDoChinh() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.trinhDoChinhCanBoGiaoVien = true;
                rest_api.post("/csdlgd-report-api/dasboard/canbogvtrinhdochinh", params, data => {
                    this.loading.trinhDoChinhCanBoGiaoVien = false;
                    if (data.data.rc == 0) {
                        this.duLieuTrinhDoChinhCanBoGiaoVien = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuTrinhDoChinhCanBoGiaoVien = this.ganViTri(dulieu);
                        this.duLieuTrinhDoChinhCanBoGiaoVien.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuTrinhDoChinhCanBoGiaoVien = []
                    }
                    console.log("duLieuTrinhDoChinhCanBoGiaoVien")
                    console.log(this.duLieuTrinhDoChinhCanBoGiaoVien)
                });
            },
            layBieuDoTruongHocTheoLoaiHinhDaoTao() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.loaiHinhDaoTaoTruongHoc = true;
                rest_api.post("/csdlgd-report-api/dasboard/truonghocloaihinhdaotao", params, data => {
                    this.loading.loaiHinhDaoTaoTruongHoc = false;
                    if (data.data.rc == 0) {
                        this.duLieuTruongHocTheoLoaiHinhDaoTao = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuTruongHocTheoLoaiHinhDaoTao = this.ganViTri(dulieu);
                        this.duLieuTruongHocTheoLoaiHinhDaoTao.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuTruongHocTheoLoaiHinhDaoTao = []
                    }
                    console.log("duLieuTruongHocTheoLoaiHinhDaoTao")
                    console.log(this.duLieuTruongHocTheoLoaiHinhDaoTao)
                });
            },
            layBieuDoTruongHocTheoChatLuongDaoTao() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.chatLuongDaoTaoTruongHoc = true;
                rest_api.post("/csdlgd-report-api/dasboard/truonghocchatluong", params, data => {
                    this.loading.chatLuongDaoTaoTruongHoc = false;
                    if (data.data.rc == 0) {
                        this.duLieuTruongHocTheoChatLuongDaoTao = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuTruongHocTheoChatLuongDaoTao = this.ganViTri(dulieu);
                        this.duLieuTruongHocTheoChatLuongDaoTao.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuTruongHocTheoChatLuongDaoTao = []
                    }
                    console.log("duLieuTruongHocTheoChatLuongDaoTao")
                    console.log(this.duLieuTruongHocTheoChatLuongDaoTao)
                });
            },
            layBieuDoGioiTinhCanBoGiaoVien() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.gioiTinhCanBoGiaoVien = true;
                this.duLieuGioiTinhCanBoGiaoVien = [0]
                rest_api.post("/csdlgd-report-api/dasboard/canbogvgioitinh", params, data => {
                    console.log("Dữ liệu biểu đồ trả về:")
                    this.loading.gioiTinhCanBoGiaoVien = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        let du_lieu = data.data.item.listData;
                        let nam = 0;
                        let nu = 0;
                        for (let i = 0; i < du_lieu.length; i++) {
                            nam += du_lieu[i].data[0];
                            nu += du_lieu[i].data[1];
                        }
                        this.duLieuGioiTinhCanBoGiaoVien = [nam, nu];
                    } else {
                        this.duLieuGioiTinhCanBoGiaoVien = [0]
                    }
                });
            },
            layBieuDoHocSinhTheoLoaiHinhDaoTao() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.loaiHinhDaoTaoHocSinh = true;
                rest_api.post("/csdlgd-report-api/dasboard/hocsinhloaihinhdaotao", params, data => {
                    this.loading.loaiHinhDaoTaoHocSinh = false;
                    if (data.data.rc == 0) {
                        this.duLieuLoaiHinhDaoTaoHocSinh = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuLoaiHinhDaoTaoHocSinh = this.ganViTri(dulieu);
                        this.duLieuLoaiHinhDaoTaoHocSinh.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuLoaiHinhDaoTaoHocSinh = []
                    }
                    console.log("duLieuLoaiHinhDaoTaoHocSinh")
                    console.log(this.duLieuLoaiHinhDaoTaoHocSinh)
                });
            },
            layBieuDoHocSinhTheoTrangThai() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.trangThaiHocSinh = true;
                rest_api.post("/csdlgd-report-api/dasboard/hocsinhtrangthai", params, data => {
                    this.loading.trangThaiHocSinh = false;
                    if (data.data.rc == 0) {
                        this.duLieuTrangThaiHocSinh = data.data.item.listData;
                        let dulieu = data.data.item.listData;
                        this.duLieuTrangThaiHocSinh = this.ganViTri(dulieu);
                        this.duLieuTrangThaiHocSinh.sort((a, b) => (a.id > b.id) ? 1 : -1)
                    } else {
                        this.duLieuTrangThaiHocSinh = []
                    }
                    console.log("duLieuLoaiHopDongCanBoGiaoVien")
                    console.log(this.duLieuLoaiHopDongCanBoGiaoVien)
                });
            },
            layBieuDoGioiTinhHocSinh() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.gioiTinhHocSinh = true;
                this.duLieuGioiTinhHocSinh = [0]
                rest_api.post("/csdlgd-report-api/dasboard/hocsinhgioitinh", params, data => {
                    console.log("Dữ liệu biểu đồ trả về:")
                    this.loading.gioiTinhHocSinh = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        let du_lieu = data.data.item.listData;
                        let nam = 0;
                        let nu = 0;
                        for (let i = 0; i < du_lieu.length; i++) {
                            nam += du_lieu[i].data[0];
                            nu += du_lieu[i].data[1];
                        }
                        this.duLieuGioiTinhHocSinh = [nam, nu];
                    } else {
                        this.duLieuGioiTinhHocSinh = [0]
                    }
                });
            },
            layBieuDoTongQuanHocSinh(){
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.tongQuanHocSinh = true;
                this.duLieuTongQuanHocSinh = [0]
                rest_api.post("/csdlgd-report-api/dasboard/hocsinh", params, data => {
                    console.log("Dữ liệu biểu đồ trả về:")
                    this.loading.tongQuanHocSinh = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        this.duLieuTongQuanHocSinh = data.data.item.listValue;
                    } else {
                        this.duLieuTongQuanHocSinh = []
                    }
                });
            },
            layBieuDoTongQuanCanBoGiaoVien() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.tongQuanCanBoGiaoVien = true;
                this.duLieuTongQuanCanBoGiaoVien = [0]
                rest_api.post("/csdlgd-report-api/dasboard/canbogvcaphoc", params, data => {
                    console.log("Dữ liệu biểu đồ trả về:")
                    this.loading.tongQuanCanBoGiaoVien = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        this.duLieuTongQuanCanBoGiaoVien = data.data.item.listValue;
                    } else {
                        this.duLieuTongQuanCanBoGiaoVien = []
                    }
                });
            },
            layBieuDoTongQuanTruongHoc() {
                let params = {
                    "capHocs": this.capHoc,
                    "maDonVis": this.maDonVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": [],
                    "namHoc": this.namHoc
                }
                this.loading.tongQuanTruongHoc = true;
                rest_api.post("/csdlgd-report-api/dasboard/truongTron", params, data => {
                    console.log("Dữ liệu biểu đồ trả về:")
                    this.loading.tongQuanTruongHoc = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        this.duLieuTongQuanTruongHoc = data.data.item.listValue;
                    } else {
                        this.duLieuTongQuanTruongHoc = []
                    }
                });
            },
            getDataBanDo() {
                console.log("lấy đơn vị")
                let params = {
                    capHocs: ['2'],
                    maDonVis: this.maDonVi,
                    idSo: '19',
                    namHoc: 2021,
                };
                rest_api.post("/csdlgd-report-api/ioc/data", params, (response) => {
                    console.log("response bản đồ:")
                    console.log(response)
                    if (response.data.rc == 0) {
                        this.dataMap = response.data;
                    }
                });
            },
            ganViTri(e) {
                console.log("Map lại vị trí");
                let data = e;
                console.log(data);
                for (let i = 0; i < data.length; i++) {
                    if (data[i].name == 'MN') {
                        data[i].id = 1
                    };
                    if (data[i].name == 'TH') {
                        data[i].id = 2
                    };
                    if (data[i].name == 'THCS') {
                        data[i].id = 3
                    };
                    if (data[i].name == 'THPT') {
                        data[i].id = 4
                    };
                    if (data[i].name == 'GDTX') {
                        data[i].id = 5
                    };
                    if (data[i].name == 'LC') {
                        data[i].id = 6
                    };
                    if (data[i].name == 'LC145') {
                        data[i].id = 7
                    };
                    if (data[i].name == 'LC12') {
                        data[i].id = 8
                    };
                    if (data[i].name == 'LC23') {
                        data[i].id = 9
                    };
                    if (data[i].name == 'LCK') {
                        data[i].id = 10
                    };
                }
                return data;
            },
        }
    }

</script>
<style scoped>
</style>

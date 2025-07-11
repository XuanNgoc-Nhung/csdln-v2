<template>
    <div>
        <div class="card-bieu-do">
            <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                <el-col :span="6" :sm="6" :lg="4">
                    <el-select class="input-with-select" v-model="namHoc" no-match-text="Không tìm thấy bản ghi nào"
                        no-data-text="danh sách lựa chọn trống" collapse-tags style="width:100%" filterable
                        placeholder="Chọn năm học">
                        <el-option v-for="item in list_nam_hoc" :key="item.id" :label="item.name" :value="item.id">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :span="4" :sm="4" :lg="2">
                    <el-tooltip class="item" effect="dark" content="Thống kê dữ liệu Dashboard" placement="top-start">
                        <el-button plain size="mini" @click.prevent="getAll()"
                            style=" width:100%;font-size:14px; padding-left:10px;" type="success">Thống
                            kê</el-button>
                    </el-tooltip>
                </el-col>
                <el-col :span="4" :sm="4" :lg="2">
                    <el-tooltip class="item" effect="dark" content="Tổng hợp lại dữ liệu" placement="top-start">
                        <el-button plain size="mini" @click.prevent="TongHopLaiDuLieuNhaTruong()"
                            style=" width:100%;font-size:14px; padding-left:10px;background-color:#337ab7"
                            type="primary">Tổng hợp
                        </el-button>
                    </el-tooltip>
                </el-col>
            </el-row>
        </div>
        <div v-if="false" class="card-bieu-do">
            <el-row :gutter="24" class="thongketanggiam">
                <el-col :span="6">
                    <div class="grid-content bg-purple-light " style="position:relative">
                        <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                            <h3>{{thongTinTruongHoc.tenTruongHoc}}</h3>
                        </div>
                    </div>
                </el-col>
                <el-col :span="6">
                    <div class="grid-content bg-purple-light">
                        <div class="dts-card-body thongketangiamsl" style="height: inherit" v-loading="false"
                            element-loading-background="rgba(0, 0, 0, 0.5)">
                            <p>Giáo viên</p>
                            <span><span
                                    class="soluongtanggiam">{{thongTinTruongHoc.bienDongGv?thongTinTruongHoc.bienDongGv.toLocaleString():0}}</span>
                                <img v-if="thongTinTruongHoc.statusBdGv=='augment'" class="anhtanggiam"
                                    src="images/tang.png" alt="Tăng">
                                <img v-if="thongTinTruongHoc.statusBdGv=='abatement'" class="anhtanggiam"
                                    src="images/giam.png" alt="Giảm">
                            </span>
                            <p>{{getStatus(thongTinTruongHoc.statusBdGv)}}
                                {{thongTinTruongHoc.percentBienDongGv.toFixed(2)}}% so với năm trước </p>
                        </div>
                    </div>
                </el-col>
                <el-col :span="6">
                    <div class="grid-content bg-purple-light">
                        <div class="dts-card-body thongketangiamsl" style="height: inherit" v-loading="false"
                            element-loading-background="rgba(0, 0, 0, 0.5)">
                            <p>Học sinh</p>
                            <span><span
                                    class="soluongtanggiam">{{thongTinTruongHoc.bienDongHs?thongTinTruongHoc.bienDongHs.toLocaleString():0}}</span>
                                <img v-if="thongTinTruongHoc.statusBdHs=='augment'" class="anhtanggiam"
                                    src="images/tang.png" alt="Tăng">
                                <img v-if="thongTinTruongHoc.statusBdHs=='abatement'" class="anhtanggiam"
                                    src="images/giam.png" alt="Giảm">
                            </span>
                            <p>{{getStatus(thongTinTruongHoc.statusBdHs)}}
                                {{thongTinTruongHoc.percentBienDongHs.toFixed(2)}}% so với năm trước </p>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <!-- Thông tin trường -->
        <ThongTinTruong v-if="false" :item="thongTinTruongHoc" :nam_hoc="namHoc"></ThongTinTruong>
        <!-- Thông tin lớp học-->
        <div v-if="show_thong_tin_lop_hoc">
            <ThongTinLopHoc :diem_truong="list_diem_truong" :nam_hoc="namHoc" :item="thongTinLopHoc"></ThongTinLopHoc>
        </div>
        <!-- Thông tin cán bộ giáo viên -->
        <div>
            <ThongTinCanBoGiaoVien :item="thongTinCanBoGiaoVien"></ThongTinCanBoGiaoVien>
        </div>
        <!-- Thông tin học sinh -->
        <div>
            <ThongTinHocSinh :diem_truong="list_diem_truong" :item="thongTinHocSinh"></ThongTinHocSinh>
        </div>
        <!-- Thông tin kết quả học tập -->
        <div v-if="show_thong_tin_kqht">
            <!-- <ThongTinKetQuaHocTap :nam_hoc="namHoc" :item="thongTinKetQuaHocTap"></ThongTinKetQuaHocTap> -->
        </div>
        <!-- Thông tin phổ điểm -->
        <div v-if="show_thong_tin_pho_diem">
            <ThongTinPhoDiem :diem_truong="list_diem_truong" :nam_hoc="namHoc" :item="thongTinPhoDiem">
            </ThongTinPhoDiem>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import constant from '../../utils/constant';
    import utils from '../../utils'
    import ElementUI from 'element-ui';
    import ESelectVue from '../ui/ESelect.vue';
    import ThongTinTruong from './DashBoardSchool/thongTinTruong';
    import ThongTinLopHoc from './DashBoardSchool/ThongTinLopHoc/thongTinChung';
    import ThongTinCanBoGiaoVien from './DashBoardSchool/canBoGiaoVien/thongTinChung';
    import ThongTinHocSinh from './DashBoardSchool/hocSinh/thongTinChung';
    import ThongTinKetQuaHocTap from './DashBoardSchool/ketQuaHocTap/thongTinChung';
    import ThongTinPhoDiem from './DashBoardSchool/phoDiem/thongTinChung';
    import VueAlertify from "vue-alertify";
    import {
        Loading
    } from 'element-ui';
    Vue.use(VueAlertify, {
        notifier: {
            delay: 2,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
    Vue.use(ElementUI);
    export default {
        props: [],
        components: {
            'eselect': ESelectVue,
            ThongTinTruong: ThongTinTruong,
            ThongTinLopHoc: ThongTinLopHoc,
            ThongTinCanBoGiaoVien: ThongTinCanBoGiaoVien,
            ThongTinHocSinh: ThongTinHocSinh,
            ThongTinKetQuaHocTap: ThongTinKetQuaHocTap,
            ThongTinPhoDiem: ThongTinPhoDiem,
        },
        data() {
            return {
                list_diem_truong: [],
                show_thong_tin_lop_hoc: false,
                show_thong_tin_cbgv: false,
                show_thong_tin_hoc_sinh: false,
                show_thong_tin_kqht: false,
                show_thong_tin_pho_diem: false,
                thongtin: JSON.parse(window.userInfo),
                namHoc: "",
                thongTinTruongHoc: {
                    percentBienDongGv: 0,
                    percentBienDongHs: 0,
                },
                thongTinLopHoc: {},
                thongTinCanBoGiaoVien: {},
                thongTinHocSinh: {},
                thongTinKetQuaHocTap: {},
                thongTinPhoDiem: {},
                listDiemTruong: "",
                date: new Date(),
                list_nam_hoc: constant.LIST_YEARS_FULL,
                mang_diem_truong: [{
                        "name": "diem1",
                        "caphoc": [
                            1,
                            2,
                            3
                        ]
                    },
                    {
                        "name": "diem2",
                        "caphoc": [
                            1,
                            2,
                            3
                        ]
                    },
                    {
                        "name": "diem3",
                        "caphoc": [
                            2,
                            3,
                        ]
                    },
                ]
            }
        },
        watch: {},
        mounted: function () {
            console.log('thông tin')
            console.log(this.thongtin)
            this.namHoc = this.thongtin.namHocHienTai
            this.getAll();
        },
        methods: {
            getAll() {
                console.log("Lấy toàn bộ thông tin");
                this.getThongTinTruongHoc();
                this.layThongTinLopHoc();
                this.getThongTinCanBoGiaoVien();
                this.getThongTinHocSinh();
                // this.getThongTinKetQuaHocTap();
                this.getThongTinPhoDiem();
            },
            TongHopLaiDuLieuNhaTruong() {
                this.show_thong_tin_pho_diem = false;
                this.thongTinPhoDiem = {};
                let params = {
                    namHoc: this.namHoc,
                    maTruongHoc: this.thongtin.ma_truong_hoc,
                };


                this.$confirm('Xác nhận tổng hợp lại dữ liệu?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                    })
                    .then(_ => {
                        const loadingth = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-report-fetch/refetch/dasboartBc", params, (data) => {
                            loadingth.close();
                            console.log(data.data);
                            if (data.data.rc == 0) {
                                this.thongBao('success',
                                    "Hệ thống đang tiến hành tổng hợp lại các báo cáo và hồ sơ tra cứu. Thông tin mới nhất từ QLNT nộp lên sẽ hiển thị trong vài phút tới"
                                    )
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
                // utils.confirmDialog("Xác nhận tổng hợp lại dữ liệu", "Đồng ý", () => {

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
            getThongTinPhoDiem() {
                this.show_thong_tin_pho_diem = false;
                this.thongTinPhoDiem = {};
                let params = {
                    "namHoc": this.namHoc,
                    "hocKy": 1,
                    "maTruongs": [this.thongtin.ma_truong_hoc],
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/dasboard/truong/phodiem", params, (data) => {
                    loading.close();
                    console.log("res phổ điểm:");
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        if (data.data.item.toanTruong.length > 0) {
                            this.thongTinPhoDiem = data.data.item;
                            this.show_thong_tin_pho_diem = true;
                        }
                    }
                });
            },
            getThongTinKetQuaHocTap() {
                this.show_thong_tin_kqht = false;
                this.thongTinKetQuaHocTap = {};
                let params = {
                    "namHoc": this.namHoc,
                    "hocKy": 1,
                    "maTruongs": [this.thongtin.ma_truong_hoc],
                    "maSo": this.thongtin.ma_so,
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/dasboard/truong/ketquahoctap", params, (data) => {
                    loading.close();
                    console.log("res phổ điểm:");
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        this.thongTinKetQuaHocTap = data.data.item;
                        this.show_thong_tin_kqht = true;
                    }
                });
            },
            layThongTinLopHoc() {
                this.show_thong_tin_lop_hoc = false;
                this.thongTinLopHoc = {};
                let params = {
                    "namHoc": this.namHoc,
                    "maTruongs": [this.thongtin.ma_truong_hoc],
                    // "hasDiemChinh": true,
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/dasboard/truong/lophoc", params, (data) => {
                    loading.close();
                    console.log("res:");
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        this.thongTinLopHoc = data.data.item;
                        this.show_thong_tin_lop_hoc = true;
                    }
                });
            },
            getStatus(e) {
                if (e == 'abatement') {
                    return 'Giảm'
                } else if (e == 'augment') {
                    return 'Tăng'
                } else {
                    return ""
                }
            },
            getThongTinHocSinh() {
                this.show_thong_tin_hoc_sinh = false;
                this.ThongTinHocSinh = {};
                let params = {
                    "namHoc": this.namHoc,
                    "maTruongs": [this.thongtin.ma_truong_hoc],
                    "maSo": this.thongtin.ma_so
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/dasboard/truong/thongtinhocsinh", params, (data) => {
                    loading.close();
                    console.log("Học sinh:");
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        this.thongTinHocSinh = data.data.item;
                        this.show_thong_tin_hoc_sinh = true;
                    }
                });
            },
            getThongTinCanBoGiaoVien() {
                this.show_thong_tin_cbgv = false;
                this.thongTinCanBoGiaoVien = {
                    slCbDangLamViec:0,
                    tongCanBoChart:[0,0,0],
                    cbTrinhDoChinh:[],
                    toanTruong:{
                        canBoTrangThai:[],
                        cbDoTuoi:[],
                        cbGioiTinh:[],
                        cbHopDong:[],
                        cbTrinhDoChinh:[],
                    },
                    
                };
                let params = {
                    "namHoc": this.namHoc,
                    "maTruongs": [this.thongtin.ma_truong_hoc],
                    "maSo": this.thongtin.ma_so
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/dasboard/truong/canbogiaovien", params, (data) => {
                    loading.close();
                    console.log("cán bộ giáo viên:");
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        this.thongTinCanBoGiaoVien = data.data.item;
                        this.show_thong_tin_cbgv = true;
                    }
                });
            },
            getThongTinTruongHoc() {
                let params = {
                    "namHoc": this.namHoc,
                    "maTruongs": [this.thongtin.ma_truong_hoc]
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/dasboard/truong/truonghoc", params, (data) => {
                    loading.close();
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        this.thongTinTruongHoc = data.data.item;
                    }
                    this.getDiemTruong();
                });
            },
            getDiemTruong() {
                this.list_diem_truong = [];
                let params = {
                    "namHoc": this.namHoc,
                    "maTruongs": [this.thongtin.ma_truong_hoc]
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/dasboard/truong/diemtruong", params, (data) => {
                    loading.close();
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        let data_demo = data.data.item;
                        let mang = [];
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                name: data_demo[i].tenDiemTruong + ' - [' + data_demo[i].maDiemTruong + ']',
                                value: data_demo[i].maDiemTruong
                            }
                            mang.push(obj);
                        }
                        this.list_diem_truong = mang;
                    }
                });
            },
            layToanBoSMEMappingCode() {
                const loadingMpc = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    type: '2'
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSachSmeMoetCode", params, data => {
                    console.log(data);
                    if (data.data.rc == 0) {
                        let data_dm = data.data.tableData;
                        for (let i = 0; i < data_dm.length; i++) {
                            let ldt = [{
                                name: "Chọn",
                                label: "Chọn",
                                value: ""
                            }]
                            for (let j = 0; j < data_dm[i].list_data.length; j++) {
                                let obj = {
                                    name: data_dm[i].list_data[j].constantTitle,
                                    label: data_dm[i].list_data[j].constantTitle,
                                    value: data_dm[i].list_data[j].moetCode,
                                }
                                ldt.push(obj);
                            }
                            this.ganDuLieuSMEMoetCode(data_dm[i].constantType, ldt)
                        }
                    }
                    loadingMpc.close();
                });
            },
            layToanBoSMEMoetCode() {
                const loadingMec = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    type: '2'
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSachSme", params, data => {
                    console.log(data);
                    if (data.data.rc == 0) {
                        let data_dm = data.data.tableData;
                        for (let i = 0; i < data_dm.length; i++) {
                            let ldt = [{
                                name: "Chọn",
                                label: "Chọn",
                                value: ""
                            }]
                            for (let j = 0; j < data_dm[i].list_data.length; j++) {
                                let obj = {
                                    name: data_dm[i].list_data[j].constantTitle,
                                    label: data_dm[i].list_data[j].constantTitle,
                                    value: data_dm[i].list_data[j].mappingCode,
                                }
                                ldt.push(obj);
                            }
                            this.ganDuLieuSME(data_dm[i].constantType, ldt)
                        }
                    }
                    loadingMec.close();
                });
            },
            ganDuLieuSMEMoetCode(k, dt) {
                if (k == 'MA_LOAI_HINH_BOI_DUONG') {
                    localStorage["danh_sach_loai_hinh_boi_duong_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_KHEN_THUONG_GV') {
                    localStorage["danh_sach_khen_thuong_can_bo_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_KY_LUAT_GV') {
                    localStorage["danh_sach_ky_luat_can_bo_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_HINH_THUC_DAO_TAO') {
                    localStorage["danh_sach_hinh_thuc_dao_tao_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_KET_QUA_NGOAI_NGU') {
                    localStorage["danh_sach_ket_qua_boi_duong_ngoai_ngu_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_KET_QUA_SU_PHAM') {
                    localStorage["danh_sach_ket_qua_boi_duong_su_pham_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_HINH_THUC') {
                    localStorage["danh_sach_hinh_thuc_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_THOI_LUONG_BOI_DUONG') {
                    localStorage["danh_sach_thoi_luong_boi_duong_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_DON_VI_TO_CHUC') {
                    localStorage["danh_sach_don_vi_to_chuc_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_DON_VI') {
                    localStorage["danh_sach_don_vi_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_KHOA_DAO_TAO_NGOAI_NGU') {
                    localStorage["danh_sach_khoa_dao_tao_ngoai_ngu_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_KHOA_DAO_TAO_SU_PHAM') {
                    localStorage["danh_sach_khoa_dao_tao_su_pham_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_BAC_LUONG') {
                    localStorage["danh_sach_bac_luong_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_CHUYEN_MON') {
                    localStorage["danh_sach_chuyen_nganh_dao_tao_khac_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRINH_DO_NGOAI_NGU') {
                    localStorage["danh_sach_trinh_do_ngoai_ngu_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_NGOAI_NGU') {
                    localStorage["danh_sach_ngoai_ngu_chinh_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRINH_DO_CHUYEN_MON') {
                    localStorage["danh_sach_trinh_do_chuyen_mon_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_NGACH_CC') {
                    localStorage["danh_sach_ngach_hang_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_KQ_CHUAN_NGHE_NGHIEP') {
                    localStorage["danh_sach_danh_gia_chuan_nghe_nghiep_moet_code_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_BO_SACH_GIAO_KHOA_SU_DUNG') {
                    localStorage["danh_sach_bo_sach_giao_khoa_sme"] = JSON.stringify(dt)
                }
            },
            ganDuLieuSME(k, dt) {
                if (k == 'DM_VUNG') {
                    localStorage["danh_sach_danh_muc_vung"] = JSON.stringify(dt)
                }
                if (k == 'DM_DU_AN') {
                    localStorage["danh_sach_danh_muc_du_an"] = JSON.stringify(dt)
                }
                if (k == 'DM_LOAI_TRUNG_TAM') {
                    localStorage["danh_sach_danh_muc_loai_trung_tam"] = JSON.stringify(dt)
                }
                if (k == 'DM_LOAI_TRUONG') {
                    localStorage["danh_sach_danh_muc_loai_truong"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRUNG_TAM') {
                    localStorage["danh_sach_danh_muc_trung_tam"] = JSON.stringify(dt)
                }
                if (k == 'DM_BO_SACH_GIAO_KHOA_SU_DUNG') {
                    localStorage["danh_sach_bo_sach_giao_khoa_dang_dung"] = JSON.stringify(dt)
                }
                if (k == 'DM_NHOM_CAP_HOC') {
                    localStorage["danh_sach_cap_hoc_2_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_KHOI') {
                    localStorage["danh_sach_khoi_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_LY_DO_THOI_HOC') {
                    localStorage["danh_sach_ly_do_thoi_hoc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_LY_DO_THOI_HOC') {
                    localStorage["danh_sach_ly_do_thoi_hoc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_DIEN_CHINH_SACH') {
                    localStorage["danh_sach_dien_chinh_sach_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_NUOC') {
                    localStorage["danh_sach_nuoc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRANG_THAI_HOC_SINH') {
                    localStorage["danh_sach_cap_trang_thai_hoc_sinh_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_CAP_DAY_GV_MOET') {
                    localStorage["danh_sach_cap_day_gv_moet_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_GIOI_TINH') {
                    localStorage["danh_sach_gioi_tinh_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_CAP_HOC') {
                    localStorage["danh_sach_cap_hoc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_XA') {
                    localStorage["danh_sach_xa_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_HUYEN') {
                    localStorage["danh_sach_huyen_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TINH') {
                    localStorage["danh_sach_tinh_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_MON_HOC') {
                    localStorage["danh_sach_mon_hoc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_GIAI_DOAN_KQHT') {
                    localStorage["danh_sach_giai_doan_kqht_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_MUC_DAT_CHUAN_QG_CLGD') {
                    localStorage["danh_sach_chuan_quoc_gia_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_LOAI_HINH_TRUONG') {
                    localStorage["danh_sach_loai_hinh_truong_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_LOAI_HINH_DAO_TAO') {
                    localStorage["danh_sach_loai_hinh_dao_tao_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_PHAN_BAN') {
                    localStorage["danh_sach_phan_ban_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_LOP_DAO_TAO_BOI_DUONG') {
                    localStorage["danh_sach_lop_dao_tao_boi_duong_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_HINH_THUC_DAO_TAO_HOC_TAP') {
                    localStorage["danh_sach_hinh_thuc_dao_tao_hoc_tap_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TIET_HOC_NGOAI_NGU') {
                    localStorage["danh_sach_so_tiet_hoc_ngoai_ngu_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_CHUONG_TRINH_HOC_NN') {
                    localStorage["danh_sach_chuong_trinh_hoc_ngoai_ngu_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_KIEU_LOP') {
                    localStorage["danh_sach_lop_bo_tuc_thcs_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TIET_HOC') {
                    localStorage["danh_sach_so_tiet_hoc_tren_tuan_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_BUOI_HOC') {
                    localStorage["danh_sach_buoi_hoc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_NHOM_TUOI_MN') {
                    localStorage["danh_sach_nhom_tuoi_mam_non_sme"] = JSON.stringify(dt)
                }
                if (k == 'THANH_PHAN_GIA_DINH') {
                    localStorage["danh_sach_thanh_phan_gia_dinh_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_LOP_HUONG_NGHIEP_DAY_NGHE') {
                    localStorage["danh_sach_huong_nghiep_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_HOC_BAN_TRU') {
                    localStorage["danh_sach_hoc_ban_tru_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_SO_BUOI_HOC_TREN_TUAN') {
                    localStorage["danh_sach_so_buoi_hoc_tren_tuan_sme"] = JSON.stringify(dt)
                }
                if (k == 'LOAI_NHAP_HOC') {
                    localStorage["danh_sach_loai_nhap_hoc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_LOAI_KHUYET_TAT') {
                    localStorage["danh_sach_loai_khuyet_tat_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_KHU_VUC') {
                    localStorage["danh_sach_khu_vuc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_VUNG_KHO_KHAN') {
                    localStorage["danh_sach_doi_tuong_uu_tien_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_DOI_TUONG_CHINH_SACH') {
                    localStorage["danh_sach_doi_tuong_chinh_sach_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_NHOM_MAU') {
                    localStorage["danh_sach_nhom_mau_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_LOAI_HINH_BOI_DUONG') {
                    localStorage["danh_sach_loai_hinh_boi_duong_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_KHEN_THUONG_GV') {
                    localStorage["danh_sach_khen_thuong_can_bo_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_HINH_THUC_DAO_TAO') {
                    localStorage["danh_sach_hinh_thuc_dao_tao_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_KET_QUA_NGOAI_NGU') {
                    localStorage["danh_sach_ket_qua_boi_duong_ngoai_ngu_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_KET_QUA_SU_PHAM') {
                    localStorage["danh_sach_ket_qua_boi_duong_su_pham_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_HINH_THUC') {
                    localStorage["danh_sach_hinh_thuc_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_THOI_LUONG_BOI_DUONG') {
                    localStorage["danh_sach_thoi_luong_boi_duong_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_DON_VI_TO_CHUC') {
                    localStorage["danh_sach_don_vi_to_chuc_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_DON_VI') {
                    localStorage["danh_sach_don_vi_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_KHOA_DAO_TAO_NGOAI_NGU') {
                    localStorage["danh_sach_khoa_dao_tao_ngoai_ngu_sme"] = JSON.stringify(dt)
                }
                if (k == 'MA_KHOA_DAO_TAO_SU_PHAM') {
                    localStorage["danh_sach_khoa_dao_tao_su_pham_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_BAC_LUONG') {
                    localStorage["danh_sach_bac_luong_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_KQ_CHUAN_NGHE_NGHIEP') {
                    localStorage["danh_sach_danh_gia_chuan_nghe_nghiep_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_GV_TONG_PTRACH_DOI_GIOI') {
                    localStorage["danh_sach_giao_vien_tong_phu_trach_gioi_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_GIAO_VIEN_CHU_NHIEM_GIOI') {
                    localStorage["danh_sach_giao_vien_chu_nhiem_gioi_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_GIAO_VIEN_GIOI') {
                    localStorage["danh_sach_giao_vien_day_gioi_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_DG_VIEN_CHUC') {
                    localStorage["danh_sach_danh_gia_vien_chuc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_CHUNG_CHI_TIENG_DTOC_TSO') {
                    localStorage["danh_sach_chung_chi_tieng_dan_toc_thieu_so_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRINH_DO') {
                    localStorage["danh_sach_trinh_do_khac_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_CHUYEN_MON') {
                    localStorage["danh_sach_chuyen_nganh_dao_tao_khac_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRINH_DO') {
                    localStorage["danh_sach_trinh_do_chinh_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_CHUYEN_MON') {
                    localStorage["danh_sach_chuyen_nganh_dao_tao_chinh_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRINH_DO_TIN_HOC') {
                    localStorage["danh_sach_trinh_do_tin_hoc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_KHUNG_NLUC_NNGU') {
                    localStorage["danh_sach_khung_nang_luc_ngoai_ngu_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_LOAI_CCHI_NNGU') {
                    localStorage["danh_sach_loai_chung_chi_ngoai_ngu_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_NHOM_CCHI_NNGU') {
                    localStorage["danh_sach_nhom_chung_chi_ngoai_ngu_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRINH_DO_NGOAI_NGU') {
                    localStorage["danh_sach_trinh_do_ngoai_ngu_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_NGOAI_NGU') {
                    localStorage["danh_sach_ngoai_ngu_chinh_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_BOI_DUONG_THAY_SACH') {
                    localStorage["danh_sach_boi_duong_thay_sach_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_BOI_DUONG_CBQL_COT_CAN') {
                    localStorage["danh_sach_boi_duong_can_bo_cot_can_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_BOI_DUONG_NVU') {
                    localStorage["danh_sach_boi_duong_nghiep_vu_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRINH_DO_QLGD') {
                    localStorage["danh_sach_trinh_do_quan_ly_giao_duc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRINH_DO_LLCT') {
                    localStorage["danh_sach_trinh_do_ly_luan_chinh_tri_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRINH_DO_CHUYEN_MON') {
                    localStorage["danh_sach_trinh_do_chuyen_mon_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_BOI_DUONG_TX') {
                    localStorage["danh_sach_ket_qua_boi_duong_thuong_xuyen_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_NGACH_CC') {
                    localStorage["danh_sach_ngach_hang_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_NHIEM_VU_KIEM_NHIEM') {
                    localStorage["danh_sach_nhiem_vu_kiem_nhiem_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_HINH_THUC_HOP_DONG') {
                    localStorage["danh_sach_hinh_thuc_hop_dong_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_LOAI_CAN_BO') {
                    localStorage["danh_sach_chuc_vu_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_MON_DAY_GV') {
                    localStorage["danh_sach_mon_day_giao_vien_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_NHOM_CAN_BO') {
                    localStorage["danh_sach_loai_can_bo_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_DAN_TOC') {
                    localStorage["danh_sach_dan_toc_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TON_GIAO') {
                    localStorage["danh_sach_ton_giao_sme"] = JSON.stringify(dt)
                }
                if (k == 'DM_TRANG_THAI_CAN_BO') {
                    localStorage["danh_sach_trang_thai_can_bo_sme"] = JSON.stringify(dt)
                }
            },
        }
    }

</script>
<style scoped="scoped">
    h3,
    h5 {
        margin: 0;
    }

    #page-wrapper {
        background: red;
    }

    .el-row {
        margin: 0 !important;
    }

    .el-col {
        border-radius: 4px;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .bg-purple-dark {
        background: #99a9bf;
    }

    .bg-purple {
        background: #d3dce6;
    }

    .bg-purple-light {
        /* background: #e5e9f2; */
        height: 100px;
    }

    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }

    .row-bg {
        padding: 10px 0;
        background-color: #f9fafc;
    }

    /* css custom */
    .dts-card-header {
        background: #f2f3f8;
        height: 25px;
        color: black;
        padding: 5px;
        border-top-right-radius: 10px;
        border-top-left-radius: 10px;
    }

    .dts-card-title {
        color: #070707;
        padding-left: 10px;
        text-transform: uppercase;
        font-weight: bold;
    }

    .dts-card-body {
        padding: 5px;
        background: white;
        height: 300px;
        position: relative;
        border-bottom-right-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
        border: #f2f3f8 2px solid;
    }

    .dts-card-body-ct {
        padding: 5px;
        background: white;
        height: 350px;
        position: relative;
        border-bottom-right-radius: 10px !important;
        border-bottom-left-radius: 10px !important;
        border: #f2f3f8 2px solid;
    }

    .tuychongiaodien {
        border: 1px solid;
        position: absolute;
        right: 0;
        width: 100%;
        background: navajowhite;
        z-index: 2;
    }

    .dts-right {
        float: right;
        padding: 0 5px;
    }

    .dts-right a {
        color: white;
    }

    .card-bieu-do {
        /* border: 1px solid #088A4B; */
        margin: 15px 0;
        background: white;
        border-radius: 10px;
    }

    .card-bieu-do h5 {
        font-size: 18px;
        padding-left: 10px;
        color: blue;
        font-weight: 700
    }

    .dts-moibieudo {
        display: contents;
        border: 1px solid blue;
    }

    .amount {
        font-size: 26px;
        color: deeppink;
        font-weight: 600;
    }

    .soluongtanggiam {
        font-size: 30px !important;
    }

    .anhtanggiam {
        margin-top: -10px;
    }

    .list-enter,
    .list-leave-to {
        visibility: hidden;
        height: 0;
        margin: 0;
        padding: 0;
        opacity: 0;
    }

    .list-enter-active,
    .list-leave-active {
        transition: all 0.3s;
    }

    .card-tuychon {
        padding: 10px;
    }

    .thongketangiamsl {
        background: #1ab394;
        border-radius: 10px;
        padding: 12px;
        color: white;
        font-size: 18px !important;
    }

    .el-loading-mask {
        border-bottom-right-radius: 0px !important;
        border-bottom-left-radius: 0px !important;
    }

    .inline {
        display: inline-flex;
    }

</style>

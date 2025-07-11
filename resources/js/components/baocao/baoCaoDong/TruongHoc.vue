<template>
    <div v-loading.fullscreen="fullscreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :gutter="24" class="dts-card">
            <el-col :span="12">
                <label>Tiêu chí báo cáo <sup class="red">*</sup></label>
                <eselect style="width:100%" multiple collapseTags v-model="NoiDungHienThi" @input="ChonNoiDungHienThi"
                    :placeholder="'Chọn'" filterable :data="list_tieu_chi" :fields="['name','nameCol']" />
            </el-col>
            <el-col :span="24">
                <draggable class="list-group" tag="div" v-model="list_tieu_chi_hien_thi" v-bind="dragOptions"
                    @start="drag = true" @end="drag = false">
                    <transition-group type="transition">
                        <li class="list-group-item" v-for="(item,i) in list_tieu_chi_hien_thi" :key="item.nameCol">
                            <span>{{i+1}}:
                                {{ item.name }}</span>
                        </li>
                    </transition-group>
                </draggable>
            </el-col>
        </el-row>
        <el-row :gutter="24" class="dts-card">
            <el-collapse v-model="activeNames">
                <el-collapse-item name="1">
                    <template slot="title">
                        <span style="padding-left:12px;color:blue"> <b><i>Bộ lọc dữ liệu</i></b></span>
                    </template>
                    <el-col :span="8">
                        <label>Đơn vị </label>
                        <eselect style="width:100%" @change="LayLaiTruongHoc" multiple collapseTags
                            v-model="noiDungTimKiem.donVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :span="4">
                        <label>Cấp dạy </label>
                        <eselect style="width:100%" multiple collapseTags @change="LayLaiTruongHoc"
                            v-model="noiDungTimKiem.capHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                            :fields="['name','id']" />
                    </el-col>
                    <el-col :span="8">
                        <label>Trường học </label>
                        <eselect style="width:100%" multiple collapseTags v-model="noiDungTimKiem.truongHoc"
                            :placeholder="'Chọn'" filterable :data="list_truong_hoc" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="4">
                        <label>Năm học </label>
                        <eselect style="width:100%" collapseTags v-model="noiDungTimKiem.namHoc" :placeholder="'Chọn'"
                            filterable :data="list_nam_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :span="6">
                        <label>Loại hình trường </label>
                        <eselect style="width:100%" multiple collapseTags v-model="noiDungTimKiem.loaiHinhDaoTao"
                            :placeholder="'Chọn'" filterable :data="list_loai_hinh_truong" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="6">
                        <label>Loại trường </label>
                        <eselect style="width:100%" multiple collapseTags v-model="noiDungTimKiem.LoaiTruong"
                            :placeholder="'Chọn'" filterable :data="list_loai_truong" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="6">
                        <label>Chuẩn quốc gia </label>
                        <eselect style="width:100%" multiple collapseTags v-model="noiDungTimKiem.ChuanTruong"
                            :placeholder="'Chọn'" filterable :data="list_chuan_truong" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="6">
                        <label>Khu vực </label>
                        <eselect style="width:100%" multiple collapseTags v-model="noiDungTimKiem.khuVuc"
                            :placeholder="'Chọn'" filterable :data="list_khu_vuc" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="6">
                        <label>Trường quốc tế </label>
                        <eselect style="width:100%" collapseTags v-model="noiDungTimKiem.TruongQuocTe"
                            :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                </el-collapse-item>
            </el-collapse>
        </el-row>
        <el-row :gutter="24">
            <el-col :span="24" class="text-center">
                <el-button type="success" size="mini" @click.prevent="checkTruocKhiTim">Tìm kiếm</el-button>
            </el-col>
        </el-row>
        <el-row :gutter="24">
            <el-col :span="24" style="padding:0">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <el-row :gutter="24">
                            <el-col :span="8" class="reset">
                                <ChonSoLuong @chonXongSoLuong="ChonSoLuongBanGhi($event)">
                                </ChonSoLuong>
                            </el-col>
                            <el-col :span="16" class="reset">
                                <div class="text-right" style="padding-bottom:5px">
                                    <el-tooltip content="Xuất excel" placement="top">
                                        <el-button type="primary" size="mini" @click.prevent="XacNhanTaiXuong">Tải xuống
                                        </el-button>
                                    </el-tooltip>
                                    <el-tooltip content="Lưu lại nội dung hiển thị và bộ lọc dữ liệu" placement="top">
                                        <el-button type="info" size="mini" @click.prevent="XacNhanLuuMau">Lưu mẫu
                                        </el-button>
                                    </el-tooltip>
                                    <el-tooltip content="Sử dụng nội dung hiển thị và bộ lọc dữ liệu có sẵn"
                                        placement="top">
                                        <el-button type="info" size="mini" @click.prevent="TaiMau">Tải mẫu
                                        </el-button>
                                    </el-tooltip>
                                </div>
                            </el-col>
                        </el-row>
                        <div class="table-responsive">
                            <table id="textTableCanBo" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background:rgb(228, 235, 245);">
                                        <template v-for="th in ten_cac_cot">
                                            <th class="text-center">
                                                <p>{{th.value}}</p>
                                            </th>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody v-if="cac_hang.length==0">
                                    <tr>
                                        <td class="text-center" :colspan="ten_cac_cot.length">
                                            <p>Không có bản ghi nào được tìm thấy</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody class="rennder-data" v-else v-html="htmlrender"></tbody>
                            </table>
                        </div>
                        <PhanTrang v-show="total_rows>0" :tongbanghi="total_rows" :soluonghienthi="soLuongBanGhiHienThi"
                            :batdau="trangbatdau" @pageChange="layLai($event)">
                        </PhanTrang>
                    </div>
                </div>
            </el-col>
        </el-row>
        <el-row :gutter="24">
            <el-col :span="24">
                <el-dialog title="Mẫu có sẵn" width="70%" custom-class="dts-dialog" top="10vh"
                    :visible.sync="hien_thi_mau">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Tên mẫu</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Mã</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Thời gian tạo</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Thao tác</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="danh_sach_mau_co_san.length==0">
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in danh_sach_mau_co_san" :key="i">
                                    <td class="text-center">{{i+1}}
                                    </td>
                                    <td>
                                        <p>{{item.ten}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.id}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.timeCreate}}</p>
                                    </td>
                                    <td class="text-center">
                                        <el-tooltip content="Áp dụng" placement="left">
                                            <el-button size="mini" type="success" icon="el-icon-check"
                                                @click.prevent="ApDungTemplate(item)">
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip content="Xóa" placement="right">
                                            <el-button size="mini" type="danger" icon="el-icon-delete"
                                                @click.prevent="xoaTemplate(item.id)">
                                            </el-button>
                                        </el-tooltip>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </el-dialog>
                <el-dialog title="Lưu mẫu" width="40%" top="10vh" :visible.sync="hien_thi_nhap_ten_mau">
                    <label>Tên mẫu: <span class="red">*</span> </label>
                    <input class="form-control" type="text" placeholder="Nhập..." v-model="tenMau"></input>
                    <span slot="footer" class="dialog-footer">
                        <el-button class="dts-button-close" size="mini" @click="hien_thi_nhap_ten_mau = false">Đóng
                        </el-button>
                        <el-button type="primary" size="mini" @click.prevent="LuuMau">Lưu lại</el-button>
                    </span>
                </el-dialog>
                <el-dialog title="Tải xuống dữ liệu" width="40%" top="10vh" :visible.sync="hien_thi_tai_xuong_du_lieu">
                    <el-checkbox v-model="xuatDuLieuNgang">Xuất dữ liệu ngang</el-checkbox>
                    <span slot="footer" class="dialog-footer">
                        <el-button class="dts-button-close" size="mini" @click="hien_thi_tai_xuong_du_lieu = false">Đóng
                        </el-button>
                        <el-button type="primary" size="mini" @click.prevent="taiXuongExcel">Tải xuống</el-button>
                    </span>
                </el-dialog>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import draggable from "vuedraggable";
    import ESelectVue from '../../ui/ESelect.vue';
    import rest_api from '../../../utils/rest_api';
    import api from "../../api";
    import constant from '../../../utils/constant';
    import PhanTrang from "../../ui/PhanTrang";
    import ChonSoLuong from "../../ui/chonSoLuongBanGhi";
    import FileSaver from 'file-saver';
    export default {
        components: {
            draggable,
            'eselect': ESelectVue,
            PhanTrang: PhanTrang,
            ChonSoLuong: ChonSoLuong,
        },
        props: ['danh_sach_don_vi', 'danh_sach_truong_hoc'],
        data() {
            return {
                activeNames: ['1'],
                fullscreenLoading: false,
                thongtin: JSON.parse(window.userInfo),
                danh_sach_du_lieu: [],
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                soLuongBanGhiHienThi: 25,
                list_don_vi: [],
                list_truong_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_loai_truong: constant.LOAI_TRUONG,
                list_chuan_truong: constant.CHUAN_TRUONG,
                list_loai_hinh_truong: constant.LOAI_HINH_TRUONG,
                list_khu_vuc: constant.KHU_VUC,
                list_do_tuoi: constant.DO_TUOI,
                list_co_khong: [{
                    value: 1,
                    name: 'Có'
                }, {
                    value: 0,
                    name: 'Không'
                }],
                list_cap_hoc: window.listCapHoc,
                hien_thi_sap_xep: false,
                danhSachTieuChi: [],
                noiDungTimKiem: {
                    donVi: [],
                    capHoc: [],
                    truongHoc: [],
                    NamHoc: "",
                    loaiHinhDaoTao: "",
                    LoaiTruong: [],
                    ChuanTruong: '',
                    KhuVuc: [],
                    TruongQuocTe: '',
                },
                NoiDungHienThi: [],
                list_tieu_chi_hien_thi: [],
                danhSachBoLoc: [],
                list_tieu_chi: [{
                    "name": "Đơn vị quản lý",
                    "nameCol": "maDonVi",
                }, {
                    "name": "Cấp học",
                    "nameCol": "capHoc",
                }, {
                    "name": "Trường học",
                    "nameCol": "maTruongHoc",
                }, {
                    "name": "Năm học",
                    "nameCol": "namHoc",
                }, {
                    "name": "Loại hình trường",
                    "nameCol": "loaiHinhDaoTao",
                }, {
                    "name": "Chuẩn quốc gia",
                    "nameCol": "chuanQuocGia",
                }, {
                    "name": "Loại trường",
                    "nameCol": "maLoaiTruong",
                }, {
                    "name": "Khu vực",
                    "nameCol": "maKhuVuc",
                }, {
                    "name": "Trường quốc tế",
                    "nameCol": "truongQuocTe",
                }],
                list_hien_thi_da_sap_xep: [],
                drag: false,
                trangbatdau: false,
                colList: [],
                requestList: [],
                requestLists: [],
                cac_hang: [],
                ten_cac_cot: [],
                hien_thi_mau: false,
                hien_thi_nhap_ten_mau: false,
                hien_thi_tai_xuong_du_lieu: false,
                xuatDuLieuNgang: false,
                danh_sach_mau_co_san: [],
                tenMau: "",
                hienThiBoLoc: {}
            };
        },
        watch: {
            list_tieu_chi_hien_thi(val) {
                console.log("list_tieu_chi_hien_thi thay đổi")
                console.log(this.list_tieu_chi_hien_thi)
            },
            danh_sach_don_vi: function (newVal) {
                console.log("Danh sách đơn vị thay đổi:");
                if (newVal) {
                    this.list_don_vi = newVal;
                } else {
                    this.list_don_vi = [];
                }
            },
            danh_sach_truong_hoc: function (newVal) {
                console.log("Danh sách trường học thay đổi:");
                if (newVal) {
                    this.list_truong_hoc = newVal;
                } else {
                    this.list_truong_hoc = [];
                }
            },
        },
        mounted: function () {
            console.log("Mounted");
            this.noiDungTimKiem.namHoc = this.thongtin.namHocHienTai;
            // this.ganDuLieuSME();
        },
        methods: {
            ChonNoiDungHienThi() {
                if (this.NoiDungHienThi.length > 0) {
                    let data = this.NoiDungHienThi;
                    let mang = [];
                    for (let i = 0; i < data.length; i++) {
                        for (let j = 0; j < this.list_tieu_chi.length; j++) {
                            if (this.list_tieu_chi[j].nameCol == data[i]) {
                                let obj = {
                                    name: this.list_tieu_chi[j].name,
                                    nameCol: this.list_tieu_chi[j].nameCol,
                                }
                                mang.push(obj)
                            }
                        }
                    }
                    this.list_tieu_chi_hien_thi = mang;
                } else {
                    this.list_tieu_chi_hien_thi = [];
                }
            },
            taiXuongExcel() {
                let url = "/xuat-excel-bao-cao-dong-can-bo";
                this.ganLaiViTri();
                if (this.list_hien_thi_da_sap_xep.length == 0) {
                    this.thongBao("error", "Thiếu tiêu chí báo cáo")
                    return;
                }
                this.colList = this.list_hien_thi_da_sap_xep;
                this.ganDanhSachRequestList();
                this.ganDanhSachRequestValue();
                let params = {
                    "colList": this.colList,
                    "requestLists": this.requestLists,
                    "requestList": this.requestList,
                    "start": 0,
                    "limit": 99999,
                    "turn": this.xuatDuLieuNgang
                };
                this.fullscreenLoading = true;
                this.hien_thi_tai_xuong_du_lieu = false;
                api.post(url, params, (data) => {
                    this.fullscreenLoading = false;
                    this.thongBao("success", "Tải xuống thành công");
                    this.hien_thi_mau = false;
                    let currentDate = new Date();
                    let fileName = '';
                    var thangNay = parseInt(currentDate.getMonth()) + 1;
                    if (thangNay < 10) {
                        thangNay = '0' + thangNay;
                    }
                    fileName = this.thongtin.ma_so + '_Bao_cao_can_bo_' + currentDate.getDate() + thangNay +
                        (currentDate.getFullYear());
                    FileSaver.saveAs(data.data.file, fileName);
                });
                // this.fullscreenLoading = true;
                // this.hien_thi_tai_xuong_du_lieu = false;
                // setTimeout(() => {
                //     this.fullscreenLoading = false;
                //     this.thongBao("success", "Tải xuống thành công");
                //     this.hien_thi_mau = false;
                // }, 5000)
            },
            XacNhanTaiXuong() {
                console.log("Ấn tải xuống")
                this.hien_thi_tai_xuong_du_lieu = true;
            },
            ApDungTemplate(e) {
                this.$confirm('Xác nhận áp dụng mẫu đã chọn?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.fullscreenLoading = true;
                        setTimeout(() => {
                            this.fullscreenLoading = false;
                            this.thongBao("success", "Áp dụng thành công");
                            this.hien_thi_mau = false;
                        }, 500)
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
            xoaTemplate(e) {
                this.$confirm('Xác nhận xóa template này?', 'Xóa dữ liệu', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass:'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        let params = {}
                        this.fullscreenLoading = true;
                        rest_api.post(
                            "/csdlgd-report-fetch/template/delete/" + e,
                            params,
                            (data) => {
                                this.fullscreenLoading = false;
                                console.log("Xóa template")
                                console.log(data)
                                if (data.data.rc == 0) {
                                    this.TaiMau();
                                    this.thongBao("success", data.data.rd);
                                    return;
                                } else {
                                    this.thongBao("error", data.data.rd);
                                    return;
                                }
                            },
                        );
                    })
                    .catch(_ => {});
            },
            XacNhanLuuMau() {
                console.log("Lưu mẫu")
                this.ganLaiViTri();
                this.colList = this.list_hien_thi_da_sap_xep;
                this.ganDanhSachRequestList();
                this.ganDanhSachRequestValue();
                if (this.colList.length == 0) {
                    this.thongBao("error", "Vui lòng bổ sung nội dung hiển thị")
                    return;
                }
                this.hien_thi_nhap_ten_mau = true;
            },
            LuuMau() {
                if (!this.tenMau) {
                    this.thongBao("error", "Vui lòng bổ sung tên mẫu")
                    return;
                }
                this.$confirm('Xác nhận lưu lại mẫu?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        let params = {
                            "colList": this.list_tieu_chi,
                            "requestLists": this.requestLists,
                            "requestList": this.requestList,
                            "start": this.start,
                            "limit": this.limit,
                            "type": 1,
                            "name": this.tenMau
                        };
                        this.fullscreenLoading = true;
                        rest_api.post("/csdlgd-report-fetch/template/save", params, (data) => {
                            this.fullscreenLoading = false;
                            if (data.data.rc == 0) {
                                this.thongBao("success", "Mẫu đã được lưu lại");
                                this.hien_thi_nhap_ten_mau = false;
                                this.tenMau = "";
                            } else {
                                this.thongBao("error", "Có lỗi sảy ra. Vui lòng thửu lại")
                            }
                        });
                    })
                    .catch(_ => {});
            },
            TaiMau() {
                console.log("Tải mẫu");
                let params = {
                    "name": "",
                    "type": 1
                };
                this.fullscreenLoading = true;
                rest_api.post("/csdlgd-report-fetch/template/search", params, (data) => {
                    this.fullscreenLoading = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        this.danh_sach_mau_co_san = data.data.rows;
                        if (data.data.total == 0) {
                            // this.thongBao("error", "Không tìm thấy bản ghi nào")
                            return;
                        } else {
                            this.hien_thi_mau = true;
                        }
                    } else {
                        this.thongBao("error", "Hệ thống đang bận. Vui lòng thử lại sau")
                        return;
                    }
                });
            },
            getData() {
                this.ganLaiViTri();
                if (this.list_hien_thi_da_sap_xep.length == 0) {
                    this.thongBao("error", "Thiếu tiêu chí báo cáo")
                    return;
                }
                this.colList = this.list_hien_thi_da_sap_xep;
                this.ganDanhSachRequestList();
                this.ganDanhSachRequestValue();
                let params = {
                    "colList": this.colList,
                    "requestLists": this.requestLists,
                    "requestList": this.requestList,
                    "start": this.start,
                    "limit": this.limit
                };
                console.log("Params lấy dữ liệu:")
                console.log(params);
                this.fullscreenLoading = true;
                rest_api.post("/csdlgd-report-fetch/BaoCaoGiaoVien/sreach", params, (data) => {
                    this.fullscreenLoading = false;
                    var html = '';
                    console.log("lấy báo cáo trả về" + JSON.stringify(data));
                    this.total_rows = data.data.total;
                    console.log("tổng số bản ghi:" + this.total_rows);
                    this.ten_cac_cot = data.data.tableHeaders;
                    console.log("các cột");
                    console.log(JSON.stringify(this.ten_cac_cot));
                    this.cac_hang = data.data.tableRows;
                    console.log("các hàng");
                    console.log(JSON.stringify(this.cac_hang));
                    if (this.cac_hang) {
                        this.dowload = true;
                        this
                            .cac_hang
                            .forEach(function (item) {
                                html += '<tr>';
                                item
                                    .col
                                    .forEach(function (i) {
                                        html += '<td class=""> <p>' + i.value + '</p></td>'
                                    });
                                html += '</tr>';
                            });
                    } else {
                        this.dowload = false;
                        html += '<tr><td>Không bản ghi nào được tìm thấy</td></tr>';
                    }
                    this.htmlrender = html;
                    setTimeout(() => {
                        this.MergeCommonRows();
                    }, 200)
                });
            },
            MergeCommonRows() {
                console.log('số cột :' + this.ten_cac_cot.length);
                let lengthCol = this.ten_cac_cot.length;
                let ar = Array.from(Array(lengthCol - 2).keys());
                $('#textTableCanBo').margetable({
                    type: 2,
                    colindex: ar
                });
            },
            ganDanhSachRequestValue() {
                let data = [];
                if (this.noiDungTimKiem.namHoc) {
                    let obj = {
                        name: "Năm học",
                        nameSreach: "namHoc",
                        value: this.noiDungTimKiem.namHoc
                    }
                    data.push(obj);
                }
                this.requestList = data;
            },
            ganDanhSachRequestList() {
                let data = [];
                if (this.noiDungTimKiem.donVi && this.noiDungTimKiem.donVi.length > 0) {
                    console.log("Có đơn vị");
                    let obj = {
                        name: "Đơn vị quản lý",
                        nameSreach: "maDonVi",
                        values: this.noiDungTimKiem.donVi
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.capHoc && this.noiDungTimKiem.capHoc.length > 0) {
                    console.log("Có cấp dạy");
                    let obj = {
                        name: "Cấp dạy",
                        nameSreach: "capHoc",
                        values: this.noiDungTimKiem.capHoc
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.truongHoc && this.noiDungTimKiem.truongHoc.length > 0) {
                    let obj = {
                        name: "Trường học",
                        nameSreach: "maTruongHoc",
                        values: this.noiDungTimKiem.truongHoc
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.danToc && this.noiDungTimKiem.danToc.length > 0) {
                    let obj = {
                        name: "Dân tộc",
                        nameSreach: "maDanToc",
                        values: this.noiDungTimKiem.danToc
                    }
                    data.push(obj);
                }
                this.requestLists = data;
            },
            getTrueFalse(e) {
                let result = Boolean(e);
                return result;
            },
            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                this.soLuongBanGhiHienThi = e.soluong;
            },
            checkTruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_mon_hoc_sme"];
                if (tmp) {
                    // this.list_loai_hinh_truong = JSON.parse(localStorage["danh_sach_loai_hinh_truong_sme"]);
                }
                this.removeEmptyElement();
                this.mapIntValue();
                this.removeDuplicateArrray();
            },
            removeDuplicateArrray() {
                // this.list_trang_thai = [...new Map(this.list_trang_thai.map(item => [JSON.stringify(item), item]))
                //     .values()
                // ];
            },
            mapIntValue() {
                // for (let i = 0; i < this.list_trang_thai.length; i++) {
                //     this.list_trang_thai[i].value = parseInt(this.list_trang_thai[i].value);
                // }
            },
            removeEmptyElement() {
                // this.list_dan_toc = this.list_dan_toc.filter(item => item.value !== "");
            },
            LayLaiTruongHoc() {
                this.noiDungTimKiem.truongHoc = [];
                this.getTruongHoc();
            },
            getTruongHoc() {
                this.fullscreenLoading = true;
                let params = {
                    maDonVi: this.noiDungTimKiem.donVi,
                    capHoc: this.noiDungTimKiem.capHoc,
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
            ganLaiViTri() {
                let data = [];
                let start = 0;
                console.log("Map lại vị trí hiển thị")
                for (let i = 0; i < this.list_tieu_chi_hien_thi.length; i++) {
                    let obj = {
                        name: this.list_tieu_chi_hien_thi[i].name,
                        nameCol: this.list_tieu_chi_hien_thi[i].nameCol,
                        index: start,
                        status: true,
                    }
                    start++
                    data.push(obj);
                }
                this.list_hien_thi_da_sap_xep = data;
            }
        },
        computed: {
            dragOptions() {
                return {
                    animation: 200,
                    group: "description",
                    disabled: false,
                    ghostClass: "ghost"
                };
            }
        }
    };

</script>
<style scoped="scoped">
    .button {
        margin-top: 35px;
    }

    .flip-list-move {
        transition: transform 0.5s;
    }

    .no-move {
        transition: transform 0s;
    }

    .ghost {
        opacity: 0.5;
        background: #c8ebfb;
    }

    .list-group {
        min-height: 20px;
        padding: 5px;
        border: 1px solid gainsboro
    }

    .list-group-item {
        cursor: move;
        display: inline-flex !important;
        padding: 4px 10px;
    }

    .list-group-item i {
        cursor: pointer;
    }

    .dts-card.el-row {
        border: 1px solid silver;
        border-radius: 4px;
    }

</style>

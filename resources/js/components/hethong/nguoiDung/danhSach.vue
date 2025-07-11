<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a>
                <span>
                    <span class="kytu">
                        &raquo;</span> Hệ thống
                    <span class="kytu">
                        &raquo;</span>Quản lý người dùng</span>
            </div>
        </div>
        <div>
            <div class="card-bieu-do">
                <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label class="typo__label">Đơn vị </label>
                        <eselect style="width:100%" @change="chonDonViSo" :disabled="thongtin.role!=1" collapseTags
                            v-model="donViSo" :placeholder="'Chọn'" filterable :data="list_don_vi_so"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label class="typo__label">Đơn vị quản lý </label>
                        <eselect style="width:100%" collapseTags v-model="donViPhong"
                            :disabled="kiemTraGiaTri(thongtin.ma_phong)" :placeholder="'Chọn'" filterable
                            :data="list_don_vi_phong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label class="typo__label">Tên người dùng </label>
                        <el-input clearable placeholder="Nhập..." v-model="tenNguoiDung"></el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label class="typo__label">Tên đăng nhập </label>
                        <el-input clearable placeholder="Nhập..." v-model="tenDangNhap"></el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label class="typo__label">Email </label>
                        <el-input clearable placeholder="Nhập..." v-model="emailNguoiDung"></el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label class="typo__label">Vai trò </label>
                        <eselect style="width:100%" collapseTags v-model="vaiTro" :placeholder="'Chọn'" filterable
                            :data="danh_sach_vai_tro" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label class="typo__label">Trạng thái </label>
                        <eselect style="width:100%" collapseTags v-model="trangThaiNguoiDung" :placeholder="'Chọn'"
                            filterable :data="danh_sach_trang_thai" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="24" class="text-center">
                        <el-button size="mini" @click.prevent="TruocKhiTim()" type="success">Tìm kiếm
                        </el-button>
                    </el-col>
                </el-row>
                <!-- Danh sách -->
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
                                            <el-tooltip content="Thêm mới cấu hình trường" placement="top">
                                                <el-button plain :disabled="thongtin.role>4" size="mini"
                                                    @click.prevent="ThemMoi" type="primary">Thêm mới
                                                </el-button>
                                            </el-tooltip>
                                        </div>
                                    </el-col>
                                </el-row>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr style="background:rgb(228, 235, 245)">
                                                <th class="text-center">
                                                    <p>STT</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Họ tên</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tên đăng nhập</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Vai trò</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Đơn vị</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Ngày cập nhật</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Loại tài khoản</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Trạng thái</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Thao tác</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="danh_sach_du_lieu.length===0">
                                            <tr>
                                                <td class="text-center" colspan="9">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(tt,index) in danh_sach_du_lieu">
                                                <td class="text-center">
                                                    <p>{{(currentPage-1)*limit + index+1}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tt.hoTen}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tt.username}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tt.roleName}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tt.tenDonVi}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{tt.updatedTime}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <el-button
                                                        :class="{ 'dts-status-primary': tt.isSso==true, 'dts-status-info': tt.isSso!=true  }"
                                                        size="mini">
                                                        {{tt.isSso=== true ? 'Tài khoản SSO' : 'Tài khoản thường'}}
                                                    </el-button>
                                                </td>
                                                <td class="text-center">

                                                    <el-button
                                                        :class="{ 'dts-status-active': tt.trangThai==1, 'dts-status-un-active': tt.trangThai!=1  }"
                                                        size="mini">
                                                        {{tt.trangThai=== 1 ? 'Đang hoạt động' : 'Ngừng hoạt động'}}
                                                    </el-button>
                                                </td>
                                                <td class="text-center">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <PhanTrang v-show="total_rows>0" :tongbanghi="total_rows"
                                    :soluonghienthi="soLuongBanGhiHienThi" :batdau="trangbatdau"
                                    @pageChange="layLai($event)">
                                </PhanTrang>
                            </div>
                        </div>
                    </el-col>
                </el-row>

            </div>
        </div>
        <div>
            <ThemMoi :show='hien_thi_them_moi' :list_so="list_don_vi_so" :list_phong="list_don_vi_phong"
                :list_vai_tro="danh_sach_vai_tro" @close='dongModal'></ThemMoi>
        </div>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
    import PhanTrang from "../../ui/PhanTrang";
    import ChonSoLuong from "../../ui/chonSoLuongBanGhi";
    import ThemMoi from "./ThemMoi";
    import constant from '../../../utils/constant';
    import api from './../../api';
    export default {
        components: {
            'eselect': ESelectVue,
            "PhanTrang": PhanTrang,
            ChonSoLuong: ChonSoLuong,
            ThemMoi: ThemMoi,
        },
        computed: {},
        data() {
            return {
                soLuongBanGhiHienThi: 25,
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                danh_sach_du_lieu: [],
                trangbatdau: false,
                thongtin: JSON.parse(window.userInfo),
                danh_sach_vai_tro: [],
                danh_sach_trang_thai: [{
                        name: 'Đang hoạt động',
                        value: 1
                    },
                    {
                        name: 'Ngừng hoạt động',
                        value: 0
                    }
                ],
                list_don_vi_so: [],
                donViSo: '',
                list_don_vi_phong: [],
                donViPhong: '',
                tenNguoiDung: '',
                tenDangNhap: '',
                emailNguoiDung: '',
                vaiTro: '',
                trangThaiNguoiDung: '',
                hien_thi_them_moi: false,
            }
        },
        mounted() {
            console.log("thông tin đăng nhập:")
            console.log(this.thongtin)
            this.layToanBoCacSo();
            if (this.thongtin.role != 1) {
                this.donViSo = this.thongtin.ma_so;
                if (this.thongtin.ma_phong && this.thongtin.ma_phong != "") {
                    this.donViPhong = this.thongtin.ma_phong;
                }
                this.layDonViPhong();
            }
            this.layDanhSachVaiTro();
        },
        watch: {},
        methods: {
            dongModal() {
                this.hien_thi_them_moi = false;
            },
            ThemMoi() {
                console.log("Thêm mới người dùng:")
                this.hien_thi_them_moi = true;
            },
            kiemTraGiaTri(e) {
                if (e && e != null && e != '') {
                    return true;
                } else {
                    return false;
                }
            },
            TruocKhiTim() {
                this.total_rows = 0;
                this.trangbatdau = !this.trangbatdau;
            },
            getData() {
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "username": this.tenDangNhap,
                    "hoTen": this.tenNguoiDung,
                    "email": this.emailNguoiDung,
                    "maPhong": this.ma_phong,
                    "role": parseInt(this.vaiTro),
                    "trangThai": this.trangThaiNguoiDung
                };
                if (this.thongtin.role == 1) {
                    if (this.donViSo) {
                        if (this.ma_phong) {
                            params.maDonVi = this.donViPhong;
                        } else {
                            params.maDonVi = this.donViSo;
                        }
                    } else {
                        params.maDonVi = "";
                    }
                }
                if (this.thongtin.role != 1) {
                    params.maSo = this.donViSo;
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.danh_sach_du_lieu = [];
                rest_api.post("/csdlgd-user/adminUser/search", params, (data) => {
                    console.log("về:" + JSON.stringify(data.data))
                    loading.close()
                    if (data.data.rc == 0) {
                        this.total_rows = data.data.totalRows;
                        if (this.total_rows != 0) {
                            this.danh_sach_du_lieu = data.data.tableData;
                            // this.thongBao('success', 'Lấy dữ liệu thành công.')
                        } else {
                            // this.thongBao('error', 'Không tìm thấy bản ghi nào.')
                            return;
                        }
                    } else {
                        this.thongBao('error', data.data.rd)
                        return;
                    }
                });
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                console.log("Chọn số lượng bản ghi:")
                console.log(JSON.stringify(e));
                this.soLuongBanGhiHienThi = e.soluong;
            },
            layDanhSachVaiTro() {
                let params = {};
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-user/adminRole/getRole", params, (data) => {
                    loading.close();
                    console.log("Các vai trò trả về:")
                    console.log(data)
                    if (data.status == 200) {
                        let dulieu = data.data;
                        let ldv = []
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].roleName +
                                    ' - [' + dulieu[i].roleId + ']',
                                value: dulieu[i].roleId,
                                vaiTroGoc: dulieu[i].parentRole,
                            }
                            ldv.push(obj)
                        }
                        this.danh_sach_vai_tro = ldv;
                        this.danh_sach_vai_tro.sort((a, b) => (a.value > b.value) ? 1 : -1)
                    } else {
                        this.danh_sach_vai_tro = [];
                    }
                });
            },
            chonDonViSo() {
                this.donViPhong = '';
                if (this.donViSo) {
                    this.layDonViPhong();
                }
            },
            layDonViPhong() {
                let params = {
                    "start": 0,
                    "limit": 500,
                    "maTinhThanh": this.donViSo
                    // "loaiDonVi": 2
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    if (data.data.code == 200) {
                        let dulieu = data.data.rows;
                        let ldv = []
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                value: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi_phong = ldv;
                        this.list_don_vi_phong.sort((a, b) => (a.name > b.name) ? 1 : -1)
                    }
                });
            },
            layToanBoCacSo() {
                let params = {
                    "start": 0,
                    "limit": 500,
                    "loaiDonVi": 1,
                    "check": false
                };
                if (this.thongtin.role != 1) {
                    params.maTinhThanh = this.thongtin.province
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    console.log("lấy sở trả về:" + JSON.stringify(data.data));
                    if (data.data.code == 200) {
                        let dulieu = data.data.rows;
                        let ldv = []
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                value: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi_so = ldv;
                        this.list_don_vi_so.sort((a, b) => (a.name > b.name) ? 1 : -1)
                    }
                });
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
</style>

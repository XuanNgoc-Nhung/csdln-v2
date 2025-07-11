<template>
    <!-- Bắt đầu template -->
    <div>
        <!-- Header -->
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> HỆ THỐNG <span class="kytu">
                        &raquo;</span> QUẢN LÝ NGƯỜI DÙNG</span>
            </div>
        </div>
        <!-- Kết thúc header -->
        <!-- Bắt đầu phần filter -->
        <div class="row">
            <!-- Đơn vị sở -->
            <div class="col-md-4 timkiem">
                <label class="typo__label">Chọn đơn vị {{ma_so}}:</label>
                <div>
                    <eselect style="width:100%" collapseTags v-model="ma_so" :disabled="thongtin.role>=2"
                        :placeholder="'Chọn'" filterable :data="list_don_vi_so" :fields="['name','value']" />
                </div>
            </div>
            <div class="col-md-4 timkiem">
                <label class="typo__label">Phòng:</label>
                <div>
<!--
                    <multiselect v-model="danhSachDonViPhong" :options="list_don_vi_phong" :close-on-select="false"
                        :clear-on-select="false" :preserve-search="false" :disabled="isDisabledPhong"
                        deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                        :custom-label="setNameDonVi" placeholder="Chọn đơn vị" label="maDonVi" track-by="tenDonVi">
                    </multiselect> -->

                    <eselect style="width:100%" collapseTags v-model="ma_phong" :disabled="thongtin.role>=29"
                        :placeholder="'Chọn'" filterable :data="list_don_vi_phong" :fields="['name','value']" />
                </div>
            </div>
            <!-- Hết tên đơn vị phòng -->
            <!-- Tên người dùng -->
            <div class="col-md-2 timkiem">
                <label class="typo__label">Tên người dùng</label>
                <input v-model="tenNguoiDung" type="text" placeholder="Nhập..." class="form-control" />
            </div>
            <!-- Hết tên người dùng -->
            <!-- Tên đăng nhập -->
            <div class="col-md-2 timkiem">
                <label class="typo__label">Tên đăng nhập</label>
                <input v-model="tenDangNhap" type="text" placeholder="Nhập..." class="form-control" />
            </div>
            <!-- Hết tên đăng nhập -->
            <!-- Tên đăng nhập -->
            <div class="col-md-4 timkiem">
                <label class="typo__label">Email</label>
                <input v-model="email" type="text" placeholder="Nhập..." class="form-control" />
            </div>
            <!-- Hết tên đăng nhập -->
            <!-- Trạng thái -->
            <div class="col-md-2 timkiem">
                <label class="typo__label">Vai trò</label>
                <select v-model="roleUser" class="form-control">
                    <option value="">Tất cả</option>
                    <option v-for="item in list_role" :value="item.roleId">{{item.roleName}}</option>
                </select>
            </div>
            <!-- Hết trạng thái -->
            <!-- Quyền -->
            <div class="col-md-2 timkiem">
                <label class="typo__label">Trạng thái</label>
                <select v-model="trangThai" class="form-control">
                    <option value="">Tất cả</option>
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Ngừng hoạt động</option>
                </select>
            </div>
            <!-- Hết quyền -->
        </div>
        <!-- Hết filter -->
        <hr />
        <!-- buttom -->
        <div class="row" style="margin-bottom:5px">
            <div class="col-md-12 text-center">
                <el-button type="success" size="mini" @click.prevent="checkTruocKhiTim()">Tìm kiếm</el-button>
            </div>
        </div>
        <!-- hết button -->
        <!-- Danh sách -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12" style="margin-bottom:10px;">
                        <el-button size="mini" type="primary" class="pull-right" v-on:click.prevent="showCreat()">
                            Thêm mới
                        </el-button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead style="background:rgba(228, 235, 243, 1)">
                                    <tr>
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
                                <tbody v-if="list_nguoi_dung.length===0">
                                    <tr>
                                        <td class="text-center" colspan="9">
                                            <p>Không có bản ghi nào</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else="v-else">
                                    <tr v-for="(tt,index) in list_nguoi_dung" v-bind:class="{ tksso: tt.isSso }">
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
                                        <td>
                                            <p>{{tt.isSso=== true ? 'Tài khoản SSO' : 'Tài khoản thường'}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p>{{parseInt(tt.trangThai)=== 1 ? 'Đang hoạt động' : 'Ngừng hoạt động'}}
                                            </p>
                                        </td>
                                        <td class="text-center">
                                            <div v-if="tt.username!=thongtin.username&&!tt.isSso">
                                                <el-tooltip content="Chỉnh sửa" placement="top">
                                                    <el-button type="warning" v-if="tt.role!=1"
                                                        @click.prevent="showUpdate(tt)" size="mini">
                                                        <i class="el-icon-edit"></i>
                                                    </el-button>
                                                </el-tooltip>
                                                <el-tooltip content="Mở khóa tài khoản" placement="top">
                                                    <el-button type="success" v-if="tt.trangThai==0"
                                                        @click.prevent="LockUser(tt,1)" size="mini">
                                                        <i class="el-icon-unlock"></i>
                                                    </el-button>
                                                </el-tooltip>
                                                <el-tooltip content="Khóa tài khoản" placement="top">
                                                    <el-button type="danger" v-if="tt.trangThai==1"
                                                        @click.prevent="LockUser(tt,0)" size="mini">
                                                        <i class="el-icon-lock"></i>
                                                    </el-button>
                                                </el-tooltip>
                                                <el-tooltip content="Đổi mật khẩu" placement="top">
                                                    <el-button type="info" @click.prevent="showResetPassword(tt)"
                                                        size="mini">
                                                        <i class="el-icon-key"></i>
                                                    </el-button>
                                                </el-tooltip>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Phân trang -->
                            <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                            <!-- Hết phân trang -->
                            <!-- Chỉnh sửa/thêm mới -->
                            <div v-if="show_create_super_admin">
                                <ThemMoiNguoiDungSuperAdmin @close="show_create_super_admin=false"
                                    @success="onCreatedData($event)"></ThemMoiNguoiDungSuperAdmin>
                            </div>
                            <div v-if="show_update_super_admin">
                                <ChinhSuaNguoiDungSuperAdmin :dulieu="dataThongTinNguoiDung"
                                    @close="show_update_super_admin=false" @success="onCreatedData($event)">
                                </ChinhSuaNguoiDungSuperAdmin>
                            </div>
                            <div v-if="show_create_admin_so">
                                <ThemMoiNguoiDungAdminSo @close="show_create_admin_so=false"
                                    @success="onCreatedData($event)"></ThemMoiNguoiDungAdminSo>
                            </div>

                            <div v-if="show_update_admin_so">
                                <ChinhSuaNguoiDungAdminSo :show="show_update_admin_so" :dulieu="dataThongTinNguoiDung"
                                    @close="show_update_admin_so=false" @success="onCreatedData($event)">
                                </ChinhSuaNguoiDungAdminSo>
                            </div>

                            <div v-if="show_create_user_so">
                                <ThemMoiNguoiDungNguoiDungSo @close="show_create_user_so=false"
                                    @success="onCreatedData($event)"></ThemMoiNguoiDungNguoiDungSo>
                            </div>

                            <div v-if="show_update_user_so">
                                <ChinhSuaNguoiDungNguoiDungSo :dulieu="dataThongTinNguoiDung"
                                    @close="show_update_user_so=false" @success="onCreatedData($event)">
                                </ChinhSuaNguoiDungNguoiDungSo>
                            </div>

                            <div v-if="show_create_user_phong">
                                <ThemMoiNguoiDungPhong @close="show_create_user_phong=false"
                                    @success="onCreatedData($event)"></ThemMoiNguoiDungPhong>
                            </div>

                            <div v-if="show_update_user_phong">
                                <ChinhSuaNguoiDungPhong :dulieu="dataThongTinNguoiDung"
                                    @close="show_update_user_phong=false"></ChinhSuaNguoiDungPhong>
                            </div>

                            <div v-if="show_reset_password_super_admin">
                                <ResetPasswordSuperAdmin :dulieu="dataThongTinNguoiDung" @close="onUpDatePass()">
                                </ResetPasswordSuperAdmin>
                            </div>

                            <!-- Hết chỉnh sửa/thêm mới -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hết danh sách -->
    </div>
    <!-- hết template -->
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import constant from '../../utils/constant';
    import moment from "moment";
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import api from '../api';
    import Page from "../ui/PagingCustom";
    import ESelectVue from '../ui/ESelect.vue';
    import dialog from '../../utils/dialog';
    import VueAlertify from "vue-alertify";
    import utils from '../../utils';
    import ThemMoiSuperAdmin from './ThemMoiNguoiDungSuperAdmin';
    import ChinhSuaSuperAdmin from './ChinhSuaThongTinNguoiDungSuperAdmin';
    import ThemNguoiDungAdminSo from './ThemNguoiDungAdminSo';
    import ChinhSuaAdminSo from './ChinhSuaNguoiDungAdminSo';
    import ThemNguoiDungNguoiDungSo from './ThemMoiNguoiDungNguoiDungSo';
    import ChinhSuaNguoiDungNguoiDungSo from './ChinhSuaNguoiDungNguoiDungSo';
    import ChinhSuaNguoiDungPhong from './ChinhSuaNguoiDungPhong';
    import ThemMoiNguoiDungPhong from './ThemNguoiDungPhong';
    import ResetPasswordSuperAdmin from './ResetPasswordSuperAdmin';
    import ElementUI from 'element-ui';
    Vue.use(ElementUI);
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            // dialogs default title
            title: 'Thông báo',
            // ok button text
            ok: 'Đồng ý',
            // cancel button text
            cancel: 'Hủy'
        }
    });
    export default {
        components: {
            'eselect': ESelectVue,
            Multiselect,
            Page: Page,
            "ThemMoiNguoiDungSuperAdmin": ThemMoiSuperAdmin,
            "ChinhSuaNguoiDungSuperAdmin": ChinhSuaSuperAdmin,
            "ChinhSuaNguoiDungAdminSo": ChinhSuaAdminSo,
            "ThemMoiNguoiDungAdminSo": ThemNguoiDungAdminSo,
            "ThemMoiNguoiDungNguoiDungSo": ThemNguoiDungNguoiDungSo,
            "ChinhSuaNguoiDungNguoiDungSo": ChinhSuaNguoiDungNguoiDungSo,
            "ThemMoiNguoiDungPhong": ThemMoiNguoiDungPhong,
            "ChinhSuaNguoiDungPhong": ChinhSuaNguoiDungPhong,
            "ResetPasswordSuperAdmin": ResetPasswordSuperAdmin
        },
        props: [],
        data() {
            return {
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                thongtin: {},
                list_role: [],
                list_nguoi_dung: [],
                list_don_vi_so: [],
                danhSachDonViSo: [],
                danhSachDonViPhong: [],
                list_don_vi_phong: [],
                ma_phong: "",
                ma_so: "",
                tenNguoiDung: "",
                trangThai: "",
                email: "",
                roleUser: "",
                tenDangNhap: "",
                // disabled
                trangbatdau: false,
                // Thêm mới

                show_create_super_admin: false,
                show_update_super_admin: false,
                show_reset_password_super_admin: false,
                show_create_admin_so: false,
                show_update_admin_so: false,
                show_create_user_so: false,
                show_update_user_so: false,
                show_create_user_phong: false,
                show_update_user_phong: false
            }
        },
        watch: {
            danhSachDonViSo: function (newVal) {
                this.ma_phong = "";
                this.danhSachDonViPhong = "";
                this.list_don_vi_phong = [];
                if (newVal) {
                    this.ma_so = newVal.maDonVi;
                    console.log("mã sở:" + this.ma_so);
                    this.getDonViPhong();
                } else {
                    this.ma_so = "";
                }
            },
            danhSachDonViPhong: function (newVal) {
                this.ma_phong = "";
                if (newVal) {
                    this.ma_phong = newVal.maDonVi;
                    console.log("mã phòng:" + this.ma_phong);
                } else {
                    this.ma_phong = "";
                }
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            if(this.thongtin.role>=2){
                this.ma_so = this.thongtin.ma_so;
            }
            this.getDonViSo();
            this.getRole();
            // this.getData();
        },
        methods: {
            checkTruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
            onCreatedData() {
                this.show_create_super_admin = false;
                this.show_create_admin_so = false;
                this.show_create_user_so = false;
                this.show_update_super_admin = false;
                this.show_update_admin_so = false;
                this.show_update_user_so = false;
                this.getData();
            },
            // Lấy role
            getRole() {

                let params = {};
                rest_api.get("/csdlgd-user/adminRole/getRole", params, (data) => {
                    if (data.status == 200) {
                        this.list_role = data.data
                    } else {
                        this.list_role = [];
                    }
                }, 60000, true);
            },
            // Cập nhật mật khẩu thành công
            onUpDatePass() {
                location.reload();
            },

            showResetPassword(tt) {
                console.log("chỉnh sửa của: " + JSON.stringify(tt));
                this.show_reset_password_super_admin = true;
                this.dataThongTinNguoiDung = tt;
            },
            // Thay đổi trạng thái người dùng

            LockUser(us, tt) {
                console.log("thực hiện:" + tt + "của" + JSON.stringify(us.username));
                utils.confirmDialog("Xác nhận thay đổi trạng thái", "Đồng ý", () => {
                    const uri = "/api_thay_doi_trang_thai_nguoi_dung";
                    const params = {
                        username: us.username,
                        trangThai: tt
                    };
                    let p = {
                        params: params
                    };
                    api.post(uri, p, (response) => {
                        console.log("chỉnh sửa người dùng trả về:" + JSON.stringify(response));
                        if (response.data.rc === 0) {
                            this
                                .$alertify
                                .success("Thay đổi trạng thái thành công.")
                            this.getData();
                        } else {
                            this
                                .$alertify
                                .error("thất bại" + response.data.rd)
                        }
                    });
                })
            },
            // thêm mới người dùng

            showCreat() {
                console.log("object" + JSON.stringify(this.thongtin));
                console.log(this.thongtin.role + "quyền hạn");
                if (this.thongtin.role == 1) {
                    console.log("Super admin thêm mới người dùng");
                    this.show_create_super_admin = true;
                }
                if (this.thongtin.role == 2) {
                    this.show_create_admin_so = true;
                    console.log("Admin sở thêm mới người dùng");
                }
                if (this.thongtin.role == 3) {
                    this.show_create_user_so = true;
                    console.log("Admin sở thêm mới người dùng");
                }
                if (this.thongtin.role == 4) {
                    this.show_create_user_phong = true;
                    console.log("Phòng thêm mới người dùng");
                }
                this.dataThongTinDangNhap = this.thongtin;
            },
            // Lấy lại danh sách

            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            // Lấy danh sách người dùng

            getData() {
                this.list_nguoi_dung = [];
                this.total_rows = 0;
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "username": this.tenDangNhap,
                    "hoTen": this.tenNguoiDung,
                    "email": this.email,
                    "maPhong": this.ma_phong,
                    "role": parseInt(this.roleUser),
                    // "maDonVi": this.ma_don_vi,
                    "trangThai": this.trangThai
                };
                if (this.thongtin.role == 1) {
                    if (this.ma_so) {
                        console.log("Có mã sở");
                        if (this.ma_phong) {
                            console.log("có sở có phòng");
                            params.maDonVi = this.ma_phong;
                        } else {
                            console.log("có sở không phòng");
                            params.maDonVi = this.ma_so;
                        }
                    } else {
                        console.log("không sở luôn");
                        params.maDonVi = "";
                    }
                }
                if (this.thongtin.role != 1) {
                    params.maSo = this.ma_so;
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-user/adminUser/search", params, (data) => {
                    console.log("về:" + JSON.stringify(data.data))
                    loading.close()
                    if (data.data.rc == 0) {
                        this.total_rows = data.data.totalRows;
                        if (this.total_rows != 0) {
                            this.list_nguoi_dung = data.data.tableData;
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công.");
                        } else {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy");
                            return;
                        }
                    } else {
                        this
                            .$alertify
                            .error(data.data.rd);
                        return;
                    }
                }, 60000, true);
            },
            // định nghĩa cho đơn vị
            setNameDonVi({
                tenDonVi,
                maDonVi
            }) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // Show update người dùng
            showUpdate(tt) {
                // console.log("chỉnh sửa của: " + JSON.stringify(tt));
                if (this.thongtin.role == 1) {
                    console.log("Super admin Chỉnh sửa người dùng");
                    this.dataThongTinNguoiDung = tt;
                    this.show_update_super_admin = true;
                }
                if (this.thongtin.role == 2) {
                    console.log("Admin sở Chỉnh sửa người dùng");
                    this.dataThongTinNguoiDung = tt;
                    this.show_update_admin_so = true;
                }
                if (this.thongtin.role == 3) {
                    console.log("Người dùng sở Chỉnh sửa người dùng");
                    this.dataThongTinNguoiDung = tt;
                    this.show_update_user_so = true;
                }
                if (this.thongtin.role == 4) {
                    console.log("Người dùng sở Chỉnh sửa người dùng");
                    this.dataThongTinNguoiDung = tt;
                    this.show_update_user_phong = true;
                }

            },

            // Lấy danh sách sở
            getDonViSo() {
                console.log("lấy sở");
                let params = {
                    "start": 0,
                    "limit": 500,
                    "loaiDonVi": 1,
                    "check": false
                };
                if (this.thongtin.role == 2 || this.thongtin.role == 3 || this.thongtin.role == 20 || this.thongtin
                    .role == 4 || this.thongtin.role == 40) {
                    params.maTinhThanh = this.thongtin.province
                }
                console.log("pr lấy sở:" + JSON.stringify(params));
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
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
                    }
                });
            },
            // Lấy danh sách đơn vị phòng
            getDonViPhong() {
                console.log("lấy phòng");
                let params = {
                    "start": 0,
                    "limit": 500,
                    "maDonViCha": this.ma_so,
                    "loaiDonVi": 2
                };
                console.log("param:" + JSON.stringify(params));
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (data.data.code == 200) {
                        this.list_don_vi_phong = data.data.rows;
                        console.log("lấy phòng:");
                        for (let i = 0; i < this.list_don_vi_phong.length; i++) {
                            if (this.list_don_vi_phong[i].maDonVi == this.thongtin.ma_phong) {
                                this.danhSachDonViPhong = this.list_don_vi_phong[i]
                            }
                        }
                    }
                }, 5000, true);
            }
        }
    }

</script>
<style scoped="scoped">
    @import "../../../../node_modules/selectwithsearch.css";

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    label,
    span {
        padding: 0;
        margin: 0;
    }

    hr {
        margin: 5px;
    }

    a,
    button,
    input,
    label,
    p,
    span {}

    .cg {
        text-align: center;
        align-items: center;
    }

    .timkiem>input {
        margin-bottom: 10px;
    }

    .table>tbody>tr>td {
        vertical-align: middle;
        padding: 5px;
    }

    .multiselect--disabled {
        background: white;
    }

    .tksso {
        background: #d6ffd8 !important;
    }

</style>

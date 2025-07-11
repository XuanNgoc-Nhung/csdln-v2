<template>
    <div v-loading.fullscreen.lock="loading" element-loading-text="Loading..." element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <!-- Form -->
        <el-dialog title="Thêm mới người dùng" :close-on-click-modal="false" :close-on-press-escape="false"
        show-close
            custom-class="headerModal" @close="dongModal" top="5vh" width="80%" :visible.sync="hien_thi_them_moi">
            <el-row>
                <!-- Thông tin  -->
                <el-col :xs="24" :sm="12" :md="8" :lg="8">
                    <label class="typo__label">Tên người dùng </label>
                    <el-input clearable placeholder="Nhập..." v-model="tenNguoiDung"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="8">
                    <label class="typo__label">Tên đăng nhập </label>
                    <el-input clearable placeholder="Nhập..." v-model="tenDangNhap"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="8">
                    <label class="typo__label">Email người dùng </label>
                    <el-input clearable placeholder="Nhập..." v-model="emailNguoiDung"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="8">
                    <label class="typo__label">Sđt người dùng </label>
                    <el-input clearable placeholder="Nhập..." v-model="sdtNguoiDung"></el-input>
                </el-col>
                <!-- Thông tin tủy chỉnh -->
                <el-col :xs="24" :sm="12" :md="8" :lg="8">
                    <label class="typo__label">Vai trò </label>
                    <eselect style="width:100%" collapseTags v-model="vaiTro" @change="chonVaiTro" :placeholder="'Chọn'"
                        filterable :data="danh_sach_vai_tro" :fields="['name','value']" />
                </el-col>
                <el-col :xs="24" :sm="12" :md="12" :lg="8">
                    <label class="typo__label">Đơn vị </label>
                    <eselect style="width:100%" @change="chonDonViSo" :disabled="thongtin.role!=1" collapseTags
                        v-model="donViSo" :placeholder="'Chọn'" filterable :data="list_don_vi_so"
                        :fields="['name','value']" />
                </el-col>
                <el-col v-if='vaiTroGoc==3||vaiTroGoc==4||vaiTroGoc==5' :xs="24" :sm="12" :md="12" :lg="8">
                    <label class="typo__label">Đơn vị quản lý </label>
                    <eselect style="width:100%" collapseTags v-model="maDonVi"
                        :disabled="kiemTraGiaTri(thongtin.ma_phong)" :placeholder="'Chọn'" @change="chonDonViPhong"
                        filterable :data="list_don_vi_phong" :fields="['name','value']" />
                </el-col>
                <el-col :xs="24" :sm="12" :md="12" :lg="8">
                    <label class="typo__label">Cấp học <span v-if="vaiTroGoc&&vaiTroGoc!=5"> quản lý</span> </label>
                    <eselect style="width:100%" multiple collapseTags v-model="capHoc" @change="chonCapHoc"
                        :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc" :fields="['name','id']" />
                </el-col>
                <el-col v-if='vaiTroGoc==5' :xs="24" :sm="12" :md="12" :lg="8">
                    <label class="typo__label">Trường </label>
                    <eselect style="width:100%" collapseTags v-model="truongHoc" :placeholder="'Chọn'" filterable
                        :data="list_truong_hoc" :fields="['name','value']" />
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button plain size="mini" @click="hien_thi_them_moi = false">Hủy</el-button>
                <el-button plain size="mini" type="primary" @click="ThemMoiNguoiDung">Thêm mới</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
    export default {
        props: ['show', 'list_so', 'list_phong', 'list_vai_tro'],
        components: {
            'eselect': ESelectVue,
        },
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal showw = " + newVal);
                if (newVal) {
                    this.hien_thi_them_moi = true;
                    this.layDonViPhong();
                } else {
                    this.hien_thi_them_moi = false;
                }
            },
            list_so: function (newVal, oldVal) {
                if (newVal) {
                    this.list_don_vi_so = newVal;
                } else {
                    this.list_don_vi_so = [];
                }
            },
            list_phong: function (newVal, oldVal) {
                if (newVal) {
                    this.list_don_vi_phong = newVal;
                } else {
                    this.list_don_vi_phong = [];
                }
            },
            list_vai_tro: function (newVal, oldVal) {
                if (newVal) {
                    this.danh_sach_vai_tro = newVal;
                } else {
                    this.danh_sach_vai_tro = [];
                }
            },
        },
        data() {
            return {
                loading: false,
                thongtin: JSON.parse(window.userInfo),
                hien_thi_them_moi: false,
                danh_sach_vai_tro: [],
                list_don_vi_so: [],
                list_don_vi_phong: [],
                danh_sach_cap_hoc: window.listCapHoc,
                capHoc: [],
                list_truong_hoc: [],
                donViSo: '',
                maDonVi: '',
                truongHoc: '',
                vaiTroGoc: '',
                vaiTro: '',
                tenNguoiDung: '',
                tenDangNhap: '',
                emailNguoiDung: '',
                sdtNguoiDung: '',
            }
        },
        mounted: function () {
            this.donViSo = this.thongtin.ma_so;
        },
        methods: {
            ThemMoiNguoiDung() {
                console.log("THêm mới")
                let params = {
                    email: this.emailNguoiDung,
                    hoTen: this.hoTenNguoiDung,
                    username: this.tenDangNhap,
                    sdt: this.sdtNguoiDung,
                    roleType: 1,
                    role: this.vaiTro,
                    capHocList: this.capHoc,
                    trangThai: '1',
                    maTruongHoc: this.truongHoc,
                    maDonVi: this.truongHoc,
                }
                console.log("thông tin thêm mới:")
                console.log(JSON.stringify(params))

                this.loading = true;
                rest_api.post("/csdlgd-user/adminUser", params, (data) => {
                    console.log("về:" + JSON.stringify(data.data))
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
                    this.loading = false;
                });
                // this.$confirm('Xác nhận thêm mới người dùng?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {})
                //     .catch(_ => {});

            },
            chonDonViPhong() {
                this.truongHoc = '';
                if (this.vaiTroGoc == 5) {
                    this.layTruongHoc();
                }
            },
            chonCapHoc() {
                this.truongHoc = '';
                if (this.vaiTroGoc == 5) {
                    this.layTruongHoc();
                }
            },
            chonVaiTro() {
                console.log(this.vaiTro)
                console.log(this.danh_sach_vai_tro)
                if (this.thongtin.role == 1) {} else {
                    this.vaiTroGoc = '';
                    this.maDonVi = '';
                    this.truongHoc = '';
                    this.capHoc = [];
                    if (this.vaiTro) {
                        for (let i = 0; i < this.danh_sach_vai_tro.length; i++) {
                            if (this.danh_sach_vai_tro[i].value == this.vaiTro) {
                                this.vaiTroGoc = this.danh_sach_vai_tro[i].vaiTroGoc
                            }
                        }
                        if (this.vaiTroGoc == 4) {
                            console.log("Vai trò gốc = 4")
                            this.layDonViPhong();
                        }
                    }
                }
            },
            kiemTraGiaTri(e) {
                if (e && e != null && e != '') {
                    return true;
                } else {
                    return false;
                }
            },
            chonDonViSo() {
                console.log("Chọn sở:");
                this.maDonVi = '';
                this.list_truong_hoc = [];
                this.truongHoc = '';
                if (this.donViSo && this.vaiTroGoc != 1 && this.vaiTroGoc != 2 && this.vaiTroGoc) {
                    this.layDonViPhong();
                    if (this.vaiTroGoc == 5) {
                        this.layTruongHoc()
                    }
                }
            },
            layTruongHoc() {
                this.list_truong_hoc = [];
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    maSo: this.donViSo,
                    maPhong: this.maDonVi,
                    capHoc: this.capHoc,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
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
            layDonViPhong() {
                let params = {
                    "start": 0,
                    "limit": 500,
                    "maTinhThanh": this.donViSo,
                    // "loaiDonVi": 2
                };
                console.log("vtg" + this.vaiTroGoc)
                if (this.vaiTroGoc == 4) {
                    // params.maDonViCha = this.donViSo;
                    // delete params.maTinhThanh;
                    params.loaiDonVi = 2;
                }
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
            dongModal() {
                console.log("Đóng modal");
                this.$emit('close')
            },
        }
    }

</script>
<style scoped>
    .el-dialog__body {
        padding: 0 20px !important;
    }

</style>

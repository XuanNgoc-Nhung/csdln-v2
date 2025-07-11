<template>
    <div id="modal_update_userso" ref="modal_update_userso" class="modal fade">

        <div class="modal-dialog" style="width: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Chỉnh sửa người dùng
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Đơn vị sở -->
                        <div class="pxn-col col-md-3">
                            <label class="typo__label">Tên người dùng <span class="red">*</span></label>
                            <input v-model="hoTenNguoiDung" type="text" placeholder="Nhập..." class="form-control" />
                        </div>
                        <!-- Hết đơn vị sở -->
                        <!-- -->
                        <div class="pxn-col col-md-3">
                            <label class="typo__label">Tên đăng nhập <span class="red">*</span></label>
                            <input v-model="tenDangNhap" type="text" placeholder="Nhập..." class="form-control" /></div>
                        <!-- -->
                        <!-- -->
                        <div class="pxn-col col-md-3">
                            <label class="typo__label">Email người dùng <span class="red">*</span></label>
                            <input v-model="emailNguoiDung" placeholder="Nhập..." type="text" class="form-control" />
                        </div>
                        <!-- -->

                        <!-- -->
                        <div class="pxn-col col-md-3">
                            <label class="typo__label">Số điện thoại người dùng <span class="red">*</span></label>
                            <input v-model="sdtNguoiDung" type="text" placeholder="Nhập..." class="form-control" />
                        </div>
                        <!-- -->
                        <!-- -->
                        <div class="pxn-col col-md-2">
                            <label class="typo__label">Loại tài khoản <span class="red">*</span></label>
                            <select v-model="loaiTaiKhoan" class="form-control">
                                <option value=''>Chọn loại tài khoản</option>
                                <option value='1'>Tài khoản hệ thống</option>
                                <option value="2">Tài khoản SSO</option>
                            </select>
                        </div>
                        <!-- -->
                        <!-- -->
                        <div class="pxn-col col-md-2">
                            <label class="typo__label">Vai trò <span class="red">*</span></label>
                            <select @change="ChonVaiTro()" v-model="vaiTro" class="form-control">
                                <option v-for="item in list_role" :value="item.roleId">{{item.roleName}}</option>
                            </select>
                        </div>
                        <!-- -->
                        <!-- Check quyền -->
                        <!-- sở -->
                        <div v-if="vaiTro==2||vaiTro==3||vaiTro==4||vaiTro==5||vaiTro==40||vaiTro==20"
                            class="pxn-col col-md-4">
                            <label class="typo__label">Chọn sở phụ trách <span class="red">*</span></label>
                            <multiselect v-model="danhSachDonViSo" :options="list_don_vi_so" :close-on-select="true"
                                :preserve-search="false" :disabled="isDisabled" deselectLabel="Đã chọn"
                                selectLabel="Chưa chọn" @close="dongChonSo" selectedLabel="Đã chọn"
                                :custom-label="setNameDonVi" placeholder="Chọn đơn vị" label="maDonVi"
                                track-by="tenDonVi"></multiselect>
                        </div>
                        <!-- Phòng -->

                        <div v-if="vaiTro==4||vaiTro==5||vaiTro==40" class="pxn-col col-md-4">
                            <label class="typo__label">Chọn đơn vị phụ trách <span class="red">*</span></label>
                            <multiselect v-model="danhSachDonViPhong" :options="list_don_vi_phong"
                                :close-on-select="true" :preserve-search="false" @close="dongChonSo"
                                deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                                :custom-label="setNameDonVi" placeholder="Chọn đơn vị" label="maDonVi"
                                track-by="tenDonVi"></multiselect>
                        </div>
                        <!-- Trường -->

                        <div v-if="vaiTro==5" class="pxn-col col-md-4">
                            <label class="typo__label">Chọn trường phụ trách <span class="red">*</span></label>
                            <multiselect v-model="danhSachDonViTruong" :options="list_truong_hoc"
                                :close-on-select="true" :preserve-search="false" deselectLabel="Đã chọn"
                                selectLabel="Chưa chọn" selectedLabel="Đã chọn" :custom-label="setNameTruongHoc"
                                placeholder="Chọn trường học" label="maTruongHoc" track-by="maTruongHoc"></multiselect>
                        </div>
                        <!-- Hết check quyền -->
                        <!-- -->
                        <div class="pxn-col col-md-4" v-if="vaiTro!=5">
                            <label class="typo__label">Cấp học <span class="red">*</span></label>
                            <multiselect v-model="danhSachCapHoc" :options="ds_cap_hoc" :close-on-select="false"
                                :multiple="true" :preserve-search="false" deselectLabel="Đã chọn"
                                selectLabel="Chưa chọn" selectedLabel="Đã chọn" :custom-label="setNameCapHoc"
                                placeholder="Chọn cấp học" label="name" track-by="name">

                                <template v-if="danhSachCapHoc.length>3" slot="selection"
                                    slot-scope="{ values, search, isOpen }">
                                    <span class="multiselect__single"
                                        v-if="values.length &amp;&amp; !isOpen">{{ values.length }}
                                        cấp học được chọn</span>
                                </template>
                            </multiselect>
                        </div>
                        <!-- -->
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="pxn-col col-md-6 text-left">
                        </div>
                        <div class="pxn-col col-md-6">

                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                            </button>
                            <button type="submit" @click.prevent="ChinhSuaNguoiDung()" class="btn btn-primary">Chính
                                sửa</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import dialog from '../../utils/dialog';
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'
    import constant from "../../utils/constant";
    import api from '../api';
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
        props: ['dulieu'],
        components: {

            Multiselect
        },
        data() {
            return {
                duoc_them_moi: true,
                hoTenNguoiDung: "",
                tenDangNhap: "",
                emailNguoiDung: "",
                sdtNguoiDung: "",
                loaiTaiKhoan: "",
                vaiTro: "",
                list_role: [],
                ds_cap_hoc: [],
                list_don_vi_so: [],
                list_don_vi_phong: [],
                list_truong_hoc: [],
                danhSachDonViSo: "",
                danhSachDonViPhong: "",
                danhSachDonViTruong: "",
                danhSachCapHoc: [],
                list_cap_hoc: "",
                ma_don_vi_so: "",
                ma_don_vi_phong: "",
                capHocList: "",
                ma_don_vi_truong: "",
                isDisabled: true,
                // Thông tin tài khoản đăng nhập
                thongtin: {}
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            console.log("thông tin đăng nhập:" + JSON.stringify(this.thongtin));
            this.ds_cap_hoc = window.listCapHoc;
            $("#modal_update_userso").modal();
            this.getRole();
            $(this.$refs.modal_update_userso).on("hidden.bs.modal", this.close);
            // console.log("dữ liệu chỉnh sửa: " + JSON.stringify(this.dulieu));
            this.bindData(this.dulieu);
        },
        watch: {
            danhSachDonViSo: function (newVal) {
                this.danhSachDonViPhong = "";
                this.danhSachDonViTruong = "";
                this.list_don_vi_phong = [];
                this.list_truong_hoc = [];
                this.ma_don_vi_phong = "";
                this.ma_don_vi_truong = "";

                if (newVal) {
                    this.ma_don_vi_so = newVal.maDonVi;
                    if (this.vaiTro != 2 && this.vaiTro != 3) {
                        this.getDonViPhong();
                    }
                } else {
                    this.ma_don_vi_so = "";
                }
                console.log("má sở:" + this.ma_don_vi_so);
            },
            danhSachDonViPhong: function (newVal) {
                console.log("phòng thay đổi");
                this.danhSachDonViTruong = "";
                this.list_truong_hoc = [];
                this.ma_truong_hoc = "";
                if (newVal) {
                    this.ma_don_vi_phong = newVal.maDonVi;
                    if (this.vaiTro == 5) {
                        this.getDonViTruong();
                    }
                } else {
                    this.ma_don_vi_phong = "";
                }
            },
            danhSachDonViTruong: function (newVal) {
                this.ma_don_vi_truong = "";
                if (newVal) {
                    this.ma_don_vi_truong = newVal.maTruongHoc;
                } else {}
            },
            danhSachCapHoc: function (newVal) {
                this.list_cap_hoc = [];
                if (newVal) {
                    let lsch = newVal.map((obj) => {
                        return obj['id']
                    });
                    this.list_cap_hoc = lsch;
                } else {
                    this.list_cap_hoc = [];
                }
                console.log(
                    "Danh sách cấp học sau khi map:" + JSON.stringify(this.list_cap_hoc)
                );
            }
        },
        methods: {
            // Lấy role
            getRole() {
                let params = {};
                rest_api.get("/csdlgd-user/adminRole/getRole", params, (data) => {
                    if (data.status == 200) {
                        this.list_role = data.data
                    } else {
                        this.list_role = [];
                    }
                });
            },
            // Đóng chọn sở
            dongChonSo() {
                this.dulieu.maDonVi = "";
                this.dulieu.maTruongHoc = "";
            },
            dongChonPhong() {
                this.dulieu.maTruongHoc = "";
            },
            // Bind dữ liệu
            bindData(e) {
                console.log("bind dữ liệu của " + JSON.stringify(this.dulieu));

                this.hoTenNguoiDung = e.hoTen
                this.tenDangNhap = e.username;
                this.emailNguoiDung = e.email;
                this.sdtNguoiDung = e.sdt;
                // this.loaiTaiKhoan = e.sdt;
                this.vaiTro = e.role;
                if (this.vaiTro == 2 || this.vaiTro == 3 || this.vaiTro == 20) {
                    this.getDonViSo();
                }
                if (this.vaiTro == 4 || this.vaiTro == 40) {
                    this.getDonViSo();
                }
                if (this.vaiTro == 5) {
                    this.getDonViSo();
                }
                if (e.capHocList == null) {
                    e.capHocList = [];
                }
                if (e.capHocList.length > 0) {
                    let danhSachCapHocBind = [];
                    for (let i = 0; i < e.capHocList.length; i++) {
                        console.log("danh sách cấp học gửi sang:" + JSON.stringify(e.capHocList));
                        console.log("danh sách cấp học role:" + JSON.stringify(this.ds_cap_hoc));
                        for (let k = 0; k < this.ds_cap_hoc.length; k++) {
                            if (this.ds_cap_hoc[k].id == e.capHocList[i]) {
                                console.log("trùng đứa:" + JSON.stringify(this.ds_cap_hoc[k]));
                                let them = this.ds_cap_hoc[k]
                                danhSachCapHocBind.push(them);
                            }
                        }
                    }
                    console.log(JSON.stringify(danhSachCapHocBind));
                    this.danhSachCapHoc = danhSachCapHocBind;
                }
            },
            // Check trước khi thêm mới
            checkThemMoi() {
                this.duoc_them_moi = true;
                if (!this.hoTenNguoiDung) {
                    this.duoc_them_moi = false;
                }
                if (!this.tenDangNhap) {
                    this.duoc_them_moi = false;
                }
                if (!this.emailNguoiDung) {
                    this.duoc_them_moi = false;
                }
                if (!this.sdtNguoiDung) {
                    this.duoc_them_moi = false;
                }
                if (!this.vaiTro) {
                    this.duoc_them_moi = false;
                }
                this.checkThemMoiRole();
            },
            // Check thêm mới role
            checkThemMoiRole() {
                console.log("check thêm mưới bằng role");
                if (this.vaiTro == 2 || this.vaiTro == 3 || this.vaiTro == 20) {
                    console.log("vai trò là sở");
                    if (!this.ma_don_vi_so) {
                        this.duoc_them_moi = false;
                    }
                    if (this.list_cap_hoc.length == 0) {
                        this.duoc_them_moi = false;
                    }
                }
                if (this.vaiTro == 4 || this.vaiTro == 40) {
                    console.log("thêm mới là phòng");
                    if (!this.ma_don_vi_phong) {
                        this.duoc_them_moi = false;
                    }
                    if (this.list_cap_hoc.length == 0) {
                        this.duoc_them_moi = false;
                    }
                }
                if (this.vaiTro == 5) {
                    console.log("thêm mới là trường");
                    if (!this.ma_don_vi_truong) {
                        this.duoc_them_moi = false;
                    }
                }
            },
            // Thêm mới người dùng
            ChinhSuaNguoiDung() {
                this.checkThemMoi();
                if (!this.duoc_them_moi) {
                    this
                        .$alertify
                        .error("Vui lòng kiểm tra lại thông tin!")
                    return
                }
                const params = {
                    email: this.emailNguoiDung,
                    hoTen: this.hoTenNguoiDung,
                    username: this.tenDangNhap,
                    sdt: this.sdtNguoiDung,
                    roleType: this.loaiTaiKhoan,
                    role: this.vaiTro,
                    capHocList: this.list_cap_hoc,
                    trangThai: '1'
                };
                if (params.capHocList == null || params.capHocList == 'undefined' || params.capHocList == "") {
                    params.capHocList = [0];
                }

                if (this.vaiTro == 2 || this.vaiTro == 3 || this.vaiTro == 20) {
                    params.maDonVi = this.ma_don_vi_so;
                };

                if (this.vaiTro == 4 || this.vaiTro == 40) {
                    params.maDonVi = this.ma_don_vi_phong;
                };
                if (this.vaiTro == 5) {
                    for (
                        let i = 0; i < this.list_truong_hoc.length; i++) {
                        if (this.list_truong_hoc[i].maTruongHoc == this.ma_don_vi_truong) {
                            params.capHocList = [parseInt(this.list_truong_hoc[i].capHoc)];
                        }
                    }
                    params.maTruongHoc = this.ma_don_vi_truong;
                    params.maDonVi = this.ma_don_vi_phong;
                }
                for (let i = 0; i < params.capHocList.length; i++) {
                    if (params.capHocList[i] == 45) {
                        params.capHocList.push(4);
                        params.capHocList.push(5);
                    }
                }
                params.capHocList = this.boPhanTuTrung(params.capHocList);
                console.log("thông tin:" + JSON.stringify(params));
                // xác nhận thêm mới

                let uri = "api_chinh_sua_nguoi_dung";
                api.post(uri, params, (response) => {
                    console.log("Chỉnh sửa người dùng trả về:" + JSON.stringify(response));
                    if (response.data.rc === 0) {
                        this
                            .$alertify
                            .success("Chỉnh người dùng thành công");
                        this.close();
                    } else {
                        this
                            .$alertify
                            .error(response.data.rd + ". Vui lòng thử lại.");
                    }
                }, 60000, true);
                // dialog.confirmDialog("Xác nhận chỉnh sửa người dùng?", "Đồng ý", () => {
                // });

            },
            boPhanTuTrung(arr) {
                return arr.filter((value, index, arr) => arr.indexOf(value) === index);
            },
            // Chọn vai trò
            ChonVaiTro() {
                // reset ở dữ liệu chỉnh sửa
                this.dulieu.maDonVi = "";
                this.dulieu.role = "";
                this.danhSachCapHoc = [];
                this.dulieu.maTruongHoc = "";
                // reset ở dữ liệu chọn
                this.ma_don_vi_so = "";
                this.ma_don_vi_phong = "";
                this.ma_don_vi_truong = "";
                this.danhSachDonViSo = "";
                this.danhSachDonViPhong = "";
                this.danhSachDonViTruong = "";
                console.log("chọn vai trò");
                // if (this.vaiTro == 2 || this.vaiTro == 3 || this.vaiTro == 20) { Vai trò
                // tương đương sở
                this.getDonViSo();
                // }
            },
            // định nghĩa cho đơn vị
            setNameDonVi({
                tenDonVi,
                maDonVi
            }) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // định nghĩa cho cấp học
            setNameCapHoc({
                name
            }) {
                return `${name}`
            },
            // định nghĩa cho trường
            setNameTruongHoc({
                tenTruongHoc,
                maTruongHoc
            }) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            // Lấy danh sách sở
            getDonViSo() {
                let params = {
                    "start": 0,
                    "limit": 500,
                    "loaiDonVi": 1
                };
                if (this.thongtin.role == 3) {
                    params.maTinhThanh = this.thongtin.province
                }
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (data.data.code == 200) {
                        this.list_don_vi_so = data.data.rows;
                        if (this.thongtin.role == 3) {
                            for (let i = 0; i < this.list_don_vi_so.length; i++) {
                                if (this.list_don_vi_so[i].maDonVi == this.thongtin.province) {
                                    this.danhSachDonViSo = this.list_don_vi_so[i];
                                }
                            }
                        }
                        if (this.dulieu.role == 2 || this.dulieu.role == 3 || this.dulieu.role == 20) {
                            if (this.dulieu.maDonVi) {
                                for (let i = 0; i < this.list_don_vi_so.length; i++) {
                                    if (this.list_don_vi_so[i].maDonVi == this.dulieu.maDonVi) {
                                        this.danhSachDonViSo = this.list_don_vi_so[i];
                                    }
                                }
                            }
                        }
                        if (this.dulieu.role == 4 || this.dulieu.role == 40) {
                            console.log("44444444444");
                            if (this.dulieu.maTinhThanh) {
                                console.log(this.dulieu.maTinhThanh);
                                for (let i = 0; i < this.list_don_vi_so.length; i++) {
                                    if (this.list_don_vi_so[i].maDonVi == this.dulieu.maTinhThanh) {
                                        this.danhSachDonViSo = this.list_don_vi_so[i];
                                    }
                                }
                            }
                        }
                        if (this.dulieu.role == 5) {
                            if (this.dulieu.maTinhThanh) {
                                console.log(this.dulieu.maTinhThanh);
                                for (let i = 0; i < this.list_don_vi_so.length; i++) {
                                    if (this.list_don_vi_so[i].maDonVi == this.dulieu.maTinhThanh) {
                                        this.danhSachDonViSo = this.list_don_vi_so[i];
                                    }
                                }
                            }
                        }
                    }
                });
            },
            // Lấy danh sách đơn vị phòng
            getDonViPhong() {
                console.log("lấy phòng");
                let params = {
                    "start": 0,
                    "limit": 500,
                    "maTinhThanh": this.ma_don_vi_so,
                };
                console.log("param:" + JSON.stringify(params));
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (data.data.code == 200) {
                        this.list_don_vi_phong = data.data.rows;
                        if (this.dulieu.role == 4 || this.dulieu.role == 40) {
                            for (let i = 0; i < this.list_don_vi_phong.length; i++) {
                                if (this.list_don_vi_phong[i].maDonVi == this.dulieu.maDonVi) {
                                    this.danhSachDonViPhong = this.list_don_vi_phong[i];
                                }
                            }
                        }
                        if (this.dulieu.role == 5) {
                            console.log("gán phòng");
                            for (let i = 0; i < this.list_don_vi_phong.length; i++) {
                                if (this.list_don_vi_phong[i].maDonVi == this.dulieu.maQuanHuyen) {
                                    this.danhSachDonViPhong = this.list_don_vi_phong[i];
                                }
                            }
                        }
                    }
                }, 5000, true);
            },

            // Lấy danh sách trường
            getDonViTruong() {
                let params = {
                    madonvi: this.ma_don_vi_phong
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    if (data.data.code == 200) {
                        console.log("lấy trường thành công");
                        this.list_truong_hoc = data.data.rows;
                        if (this.dulieu.role == 5) {
                            console.log("gán trường ở đây");
                            for (let i = 0; i < this.list_truong_hoc.length; i++) {
                                if (this.list_truong_hoc[i].maTruongHoc == this.dulieu.maTruongHoc) {
                                    this.danhSachDonViTruong = this.list_truong_hoc[i];
                                }
                            }
                            console.log(JSON.stringify(this.danhSachDonViTruong));
                        }
                    }
                    console.log("danh sách trường:" + JSON.stringify(this.list_truong_hoc));
                }, 60000, true);
            },
            close() {
                this.$emit('close');
            }
        }

    }

</script>

<style scoped="scoped">
    @import "../../../../node_modules/selectwithsearch.css";

    a,
    button,
    input,
    label,
    p,
    span {}

    .red {
        color: #DC0101;
    }

    .pxn-col {}

    .pxn-col>input,
    select {
        margin-bottom: 10px;
    }

    .multiselect--disabled {
        background: white;
    }

</style>

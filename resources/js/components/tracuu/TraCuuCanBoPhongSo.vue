<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Tra cứu<span class="kytu">
                        &raquo;</span> tra cứu cán bộ phòng sở</span>
            </div>
        </div>
        <el-form :model='dataSearch' :rules="rules" ref="ruleForm">
            <div class="row">
                <div class="col-md-5">
                    <label class="typo__label">Đơn vị quản lý:</label>
                    <el-form-item prop="lstMaDonVi">

                        <eselect style="width:100%" multiple collapseTags ref="lstMaDonVi"
                            v-model="dataSearch.lstMaDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                            :fields="['name','value']" />
                    </el-form-item>
                </div>
            </div>
            <div class="text-center" style="padding-top:15px">
                <el-button size="mini" @click.prevent="submitForm('ruleForm')" type="success">
                    Tìm kiếm
                </el-button>
            </div>
        </el-form>
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <el-button type="primary" size="mini" @click.prevent="showCreate">
                                    Thêm mới
                                </el-button>
                                <el-button :disabled="list_can_bo_phong_so.length==0" size="mini" type="success"
                                    @click.prevent="xuatExcel">
                                    Xuất excel
                                </el-button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="text-center fixed-column fixed-col1">
                                                    <p>STT</p>
                                                </th>
                                                <th class="text-center fixed-column fixed-col2">
                                                    <p>Tùy chọn</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Sở</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Phòng</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Mã cán bộ</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tên cán bộ</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Giới tính</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Ngày sinh</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Chức vụ phòng</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Phòng ban</p>
                                                </th>
                                                <!-- <th class="text-center"><p>Số điện thoại</p></th> -->
                                                <th class="text-center">
                                                    <p>Email</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Địa chỉ</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Dân tộc</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tôn giáo</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Số CMT/CCCD</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Ngày cấp CMT/CCCD</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Trạng thái</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_can_bo_phong_so.length==0">
                                            <tr>
                                                <td colspan="17" class="text-center">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in list_can_bo_phong_so" :key="i">
                                                <td class="text-center fixed-column fixed-col1">
                                                    <p>{{(currentPage-1)*limit + i+1}}</p>
                                                </td>
                                                <td class="text-center fixed-column fixed-col2">
                                                    <!-- <el-button type="warning" icon="el-icon-edit"
                                                        @click.prevent="chinhSuaCanBo(item)" size="mini"></el-button>
                                                    <el-button type="danger" icon="el-icon-delete"
                                                        @click.prevent="xoaCanBo(item)" size="mini">
                                                    </el-button> -->

                                                    <el-tooltip content="Sửa" placement="top">
                                                        <i @click.prevent="chinhSuaCanBo(item)" class="el-icon-edit"></i>
                                                    </el-tooltip>
                                                    <el-tooltip content="Xóa" placement="top">
                                                        <i class="el-icon-delete" @click.prevent="xoaCanBo(item)"></i>
                                                    </el-tooltip>
                                                </td>
                                                <td>
                                                    <p>{{item.tenSo}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.tenPhong}}</p>
                                                </td>
                                                <td class="">
                                                    <p>{{item.maCanBo}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.tenCanBo}}</p>
                                                </td>
                                                <td class="">
                                                    <p>{{getGioiTinh(item.gioiTinh)}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{item.ngaySinh}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getChucVu(item.chucVuPhong)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getPhongBan(item.maPhongBan)}}</p>
                                                </td>
                                                <!-- <td class="text-center"><p>{{item.dienThoai}}</p></td> -->
                                                <td>
                                                    <p>{{item.email}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.diaChi}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.tenDanToc}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.tenTonGiao}}</p>
                                                </td>
                                                <td class="">
                                                    <p>{{item.soCmnd}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{item.ngayCapCmnd}}</p>
                                                </td>
                                                <td class="">
                                                    <p v-bind:class="getClass(item.trangThai)">{{getTrangThai(item.trangThai)}}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                                </Page>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <template >
            <ThemMoiYeuCau :show="show_create" @thanhcong="onCreatedData($event)" @close="show_create=false" @success="onCreatedData">
            </ThemMoiYeuCau>
        </template>
        <template>
            <ChinhSuaCanBo :show="show_update" @thanhcong="onCreatedData($event)" :item="dataEditCanBo" @close="show_update=false"
                @success="onCreatedData"></ChinhSuaCanBo>
        </template>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import constant from '../../utils/constant';
    import ThongTin from './ThongTinLopHoc'
    import moment from "moment";
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import api from '../api';
    import Page from "../ui/PagingCustom";
    import ThemMoi from "./ThemCanBoPhongSo";
    import ChinhSua from "./SuaCanBoPhongSo";
    import dialog from '../../utils/dialog';
    import VueAlertify from "vue-alertify";
    import utils from '../../utils';
    import ElementUI from 'element-ui';

    import ESelectVue from '../ui/ESelect.vue';
    Vue.use(ElementUI);
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
    export default {
        components: {
            Multiselect,
            Page: Page,
            'eselect': ESelectVue,
            "ThemMoiYeuCau": ThemMoi,
            "ChinhSuaCanBo": ChinhSua
        },
        props: [],
        data() {
            return {
                thongtin: {},
                list_don_vi: [],
                list_truong_hoc: [],
                list_can_bo_phong_so: [],
                lstMaDonVi: [],
                dataSearch: {
                    lstMaDonVi: []
                },
                rules: {
                    // lstMaDonVi: [{
                    //     required: true,
                    //     message: 'Vui lòng nhập thông tin',
                    //     trigger: 'change'
                    // }, ],
                },
                // lstMaTruong:[],
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                // Thêm mới
                show_create: false,
                trangbatdau: false,
                show_update: false,
                dataEditCanBo: {},
            }
        },
        watch: {
            lstMaDonVi: function (newVal) {
                console.log('thay đổi đơn vị:');
                this.getTruongHoc();
            },
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            console.log("thông tin đăng nhập: " + JSON.stringify(this.thongtin));
            this.getDonVi();
        },
        methods: {
            getClass(stt){
                return stt==1?'banGhiDangHoatDong':'banGhiNgungHoatDong'
            },
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.checkTruocKhiTim();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            checkTruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
            xuatExcel() {
                let url = "xuat-excel-danh-sach-can-bo-phong-so";
                let params = {
                    lstMaDonVi: this.dataSearch.lstMaDonVi,
                    // lstMaTruong: this.lstMaTruong,

                    maSo: this.thongtin.ma_so,
                };
                dialog.confirmDialog(
                    "Xác nhận tải xuống file thông tin. Vui lòng chờ trong thời gian tải xuống.",
                    "Đồng ý",
                    () => {
                        api.post(url, params, (data) => {
                            let a = document.createElement('a');
                            a.href = data.data.file;
                            document
                                .body
                                .appendChild(a);
                            a.click();
                            document
                                .body
                                .removeChild(a);
                        });
                    }
                );
            },
            chinhSuaCanBo(e) {
                this.dataEditCanBo = e;
                this.show_update = true;
                console.log("Chỉnh sửa cán bộ phòng sở");
            },
            xoaCanBo(e) {
                this.$confirm('Xác nhận xóa dữ liệu cán bộ?', 'Xóa dữ liệu', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass: 'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const uri = "/api_xoa_can_bo_phong_so";
                        let params = {
                            maCanBo: e.maCanBo,
                        };
                        api.post(uri, params, (response) => {
                            if (response.data.rc == 0) {
                                this.getData();
                                this.thongBao('success', data.data.rd) 
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
                // dialog.confirmDialog("Xác nhận xóa các bản ghi đã chọn?", "Đồng ý", () => {
                //     console.log("đồng ý xóa");

                // });
            },
            getGioiTinh(loai) {
                var res = parseInt(loai);
                switch (loai) {
                    case 0:
                        res = 'Nữ';
                        break;
                    case 1:
                        res = 'Nam';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getTrangThai(loai) {
                var res = parseInt(loai);
                switch (loai) {
                    case 0:
                        res = 'Ngưng hoạt động';
                        break;
                    case 1:
                        res = 'Đang hoạt động';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getChucVu(loai) {
                var res = parseInt(loai);
                switch (loai) {
                    case 1:
                        res = 'Giám đốc';
                        break;
                    case 2:
                        res = 'Phó giám đốc';
                        break;
                    case 3:
                        res = 'Trưởng phòng';
                        break;
                    case 4:
                        res = 'Phó trưởng phòng';
                        break;
                    case 5:
                        res = 'Chủ tịch công đoàn ngành';
                        break;
                    case 6:
                        res = 'Phó chủ tịch công đoàn ngành';
                        break;
                    case 7:
                        res = 'Tránh thanh tra';
                        break;
                    case 8:
                        res = 'Phó chánh thanh tra';
                        break;
                    case 9:
                        res = 'Thanh tra chính';
                        break;
                    case 10:
                        res = 'Thanh tra viên';
                        break;
                    case 11:
                        res = 'Chánh văn phòng';
                        break;
                    case 13:
                        res = 'Phó chánh văn phòng';
                        break;
                    case 13:
                        res = 'Văn thư';
                        break;
                    case 14:
                        res = 'Chuyên viên';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getPhongBan(loai) {
                var res = parseInt(loai);
                switch (loai) {
                    case 1:
                        res = 'Ban giám đốc';
                        break;
                    case 2:
                        res = 'Phòng TCCB';
                        break;
                    case 3:
                        res = 'Phòng KH-TC';
                        break;
                    case 4:
                        res = 'Phòng GDCN-GDTX';
                        break;
                    case 5:
                        res = 'Văn phòng';
                        break;
                    case 6:
                        res = 'Phòng GDTrh';
                        break;
                    case 7:
                        res = 'Phòng Khảo thí và KĐCLGD';
                        break;
                    case 8:
                        res = 'Phòng GDTH';
                        break;
                    case 9:
                        res = 'Phòng Mầm non';
                        break;
                    case 10:
                        res = 'Thanh tra Sở';
                        break;
                    case 11:
                        res = 'Công đoàn ngành';
                        break;
                    case 12:
                        res = 'Phòng Chính trị - Tư tưởng';
                        break;
                    case 13:
                        res = 'Phòng giáo dục & đào tạo';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            onCreatedData() {
                this.show_create = false;
                this.show_update = false;
                // this.getData();
            },
            // hiển thị thêm mới
            showCreate() {
                console.log("Hiển thị form thêm mới");
                this.show_create = true;
            },
            // Lấy dữ liệu
            getData() {
                console.log('get Đata')
                console.log(this.dataSearch.lstMaDonVi)
                // if (!this.dataSearch.lstMaDonVi || this.dataSearch.lstMaDonVi.length == 0) {
                //     this.thongBao('error', 'Vui lòng bổ sung đơn vị')
                //     return;
                // }
                console.log("lấy dữ liệu:");
                this.list_can_bo_phong_so = [];
                let params = {
                    lstMaDonVi: this.dataSearch.lstMaDonVi,
                    // lstMaTruong: this.lstMaTruong,
                    maSo: this.thongtin.ma_so,
                    limit: this.limit,
                    skip: this.start,
                };
                rest_api.post("/csdlgd-admin/canBoPhongSoQl/filter", params, data => {
                    if (data.data.rc == 0) {
                        console.log("Lấy trường học trả về:" + JSON.stringify(data.data));
                        this.list_can_bo_phong_so = data.data.rows;
                        this.total_rows = this.list_can_bo_phong_so.length;
                        if (this.list_can_bo_phong_so.length > 0) {
                            // this.$alertify.success("Lấy dữ liệu thành công");
                        } else {
                            // this.$alertify.error("Không có bản gi nào được tìm thấy");
                        }
                    } else {
                        this.thongBao('error', data.data.rd)
                    }
                }, 60000, true);
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
            // Lấy trường học
            getTruongHoc() {
                // this.lstMaTruong= [];
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.dataSearch.lstMaDonVi,
                    loose: true
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    if (data.data.code == 200) {
                        console.log("Lấy trường học trả về:" + JSON.stringify(data.data));
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenTruongHoc + ' - [' + data.data.rows[i]
                                    .maTruongHoc + ']',
                                value: data.data.rows[i].maTruongHoc
                            }
                            this.list_truong_hoc.push(obj);
                        }
                    }
                });
            },
            // lấy đơn vị
            getDonVi() {
                this.list_don_vi = [];
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenDonVi + ' - [' + data.data.rows[i].maDonVi + ']',
                                value: data.data.rows[i].maDonVi
                            }
                            this.list_don_vi.push(obj);
                        }
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        padding: 0;
        margin: 0;
    }

    hr {
        margin: 5px;
    }

    a,
    p,
    span {}

    .cg {
        text-align: center;
        align-items: center;
    }

    input[type=checkbox] {
        margin: 0 !important;
    }

</style>

<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> KẾT CHUYỂN DỮ LIỆU LÊN BỘ<span class="kytu"> &raquo;</span> MẬT KHẨU KẾT CHUYỂN</span>
            </div>
        </div>
        <form role="form">
            <div class="row">
                <div class="col-md-5">
                    <label>Chọn đơn vị</label>
                    <multiselect
                        v-model="ojDonVi"
                        :options="listDonVi"
                        :custom-label="nameWithLang"
                        placeholder="Chọn đơn vị"
                        deselectLabel="Đã chọn"
                        selectLabel="Chưa chọn"
                        selectedLabel="Đã chọn"
                        label="maDonVi"
                        track-by="maDonVi"></multiselect>
                    <!-- -->
                </div>
                <div class="col-md-2">
                    <label>Chọn cấp học</label>
                    <multiselect
                        v-model="ojCapHoc"
                        :options="listCapHoc"
                        :custom-label="nameWithValue"
                        placeholder="Chọn cấp học"
                        label="name"
                        deselectLabel="Đã chọn"
                        selectLabel="Chưa chọn"
                        selectedLabel="Đã chọn"
                        track-by="name"></multiselect>
                </div>
                <div class="col-md-5">
                    <label>Chọn trường học</label>
                    <multiselect
                        deselectLabel="Đã chọn"
                        selectLabel="Chưa chọn"
                        selectedLabel="Đã chọn"
                        v-model="ojTruongHoc"
                        :options="ds_truong_hoc"
                        :custom-label="nameWithSchool"
                        placeholder="Chọn trường học"
                        label="maTruongHoc"
                        track-by="maTruongHoc"></multiselect>
                </div>
            </div>
            <div class="text-center" style="padding-top:15px">
                <button class="btn btn-success" v-on:click.prevent="checkTruocKhiTim()">
                    Tìm kiếm
                </button>
            </div>
        </form>
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <button
                                    class="btn btn-info"
                                    style="padding-right:15px"
                                    v-on:click.prevent="showImport()">
                                    Import theo biểu mẫu
                                </button>
                                <button class="btn btn-primary" v-on:click.prevent="showCreat()">
                                    Thêm mới
                                </button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
 
                            <tr style="background:#e4ebf5">
                                                <th class="text-center">
                                                    <p>STT</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tên đăng nhập</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Mã Trường</p>
                                                </th>   
                                                <th class="text-center">
                                                    <p>Tên Trường</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tỉnh thành</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tên đơn vị</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Cấp học</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Sửa</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="listMatKhau.length===0">
                                            <tr>
                                                <td class="text-center" colspan="23">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else="v-else">
                                            <tr v-for="(tg,index) in listMatKhau">
                                                <td class="text-center">
                                                    <p>{{(currentPage-1)*limit + index+1}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tg.tenDangNhap}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tg.maTruong}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tg.tenTruong}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tg.tenTinhThanh}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tg.tenDonvi}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getCapHoc(tg.capHoc)}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <a title="Chỉnh sửa" v-on:click="showUpdate(tg)">
                                                        <i class="el-icon-edit"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" :batdau="trangbatdau"  @pageChange="layLai($event)"></Page>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ChinhSuaMatKhau
            :show="show_update"
            :item="thongTinTruong"
            @success="onUpdateData($event)"
            @close="show_update=false"></ChinhSuaMatKhau>
        <ThemMoiMatKHauKetChuyen
            :show="show_create"
            :user="thongTinDangNhap"
            @success="onCreatedData($event)"
            @close="show_create=false"></ThemMoiMatKHauKetChuyen>
        <ImportMatKhauKetChuyen :show="show_import" @close="show_import=false"></ImportMatKhauKetChuyen>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import VueAlertify from "vue-alertify";
    import rest_api from "../../utils/rest_api";
    import array_util from "../../utils/array_utils";
    import timeutils from "../../utils/time_utils";
    import Page from "../ui/PagingCustom";
    import ChinhSua from "./ChinhSuaMatKhauKetChuyen";
    import ThemMoi from "./ThemMoiMatKhauKetChuyen";
    import Import from "./ImportMatKhauKetChuyen";
    import constant from "../../utils/constant";
    import HuongDan from '../huongdan/MatKhauKetChuyen'
    import dialog from "../../utils/dialog";
    import api from "./../api";
    import utils from "../../utils";
    import {
        Loading
    } from 'element-ui';
    Vue.use(VueAlertify, {

        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {
        props: ["info"],
        components: {
            Page: Page,
            ChinhSuaMatKhau: ChinhSua,
            ThemMoiMatKHauKetChuyen: ThemMoi,
            ImportMatKhauKetChuyen: Import,
            "HuongDan": HuongDan,
            Multiselect
        },
        computed: {},
        data() {
            return {
                huong_dan: false,
                trangbatdau: false,
                show_import: false,
                show_update: false,
                show_create: false,
                total_rows: 0,
                ma_truong_hoc: "",
                ds_truong_hoc: [],
                ds_tinh_thanh: [],
                start: 0,
                currentPage: 1,
                capHoc: "",
                thongTinDangNhap: {},
                tinhthanh: "",
                madonvi: "",
                limit: 25,
                listMatKhau: [],
                listDonVi: [],
                listCapHoc: constant.LIST_CAP_HOC_KHONG_LIEN,
                thongTinTruong: "",
                // phần tìm kiếm trong select
                ojDonVi: "",
                ojCapHoc: "",
                ojTruongHoc: ""
            };
        },

        mounted() {
            this.thongtin = JSON.parse(this.info);
            console.log("Thông tin đăng nhập:" + JSON.stringify(this.thongtin));
            this.tinhthanh = this.thongtin.province;
            this.getDonVi();
            this.getTinhThanh();
            console.log("tinhr 23456789" + JSON.stringify(this.tinhthanh));
            // this.madonvi = this.tinhthanh;
            this.getTruongHoc();
            // this.getMatKhauKetChuyen();
        },

        watch: {
            ojDonVi: function (newVal) {
                console.log("thay đổi đơn vị");
                this.madonvi = "";
                console.log(JSON.stringify(newVal));
                this.ds_truong_hoc = [];
                this.ma_truong_hoc = "";
                this.ojTruongHoc = "";
                if (newVal) {
                    console.log("có đơn vị");
                    this.madonvi = newVal.maDonVi;
                    console.log(this.madonvi);
                    this.getTruongHoc();
                }
                if (!newVal) {
                    console.log("không có đơn vị");
                }
            },
            ojCapHoc: function (newVal) {
                this.capHoc = "";
                this.ds_truong_hoc = [];
                this.ma_truong_hoc = "";
                this.ojTruongHoc = "";
                if (newVal) {
                    console.log("có cấp học");
                    this.capHoc = newVal.id;
                }
                this.getTruongHoc();
            },
            ojTruongHoc: function (newVal) {
                this.ma_truong_hoc = "";
                if (newVal) {
                    this.ma_truong_hoc = newVal.maTruongHoc;
                }
                console.log("mã trường học:" + this.ma_truong_hoc);
            }
        },

        methods: {
            
            getCapHoc(loai) {
                var res = parseInt(loai);
                switch (res) {
                    case 1:
                        res = 'Tiểu học';
                        break;
                    case 2:
                        res = 'THCS';
                        break;
                    case 3:
                        res = 'THPT';
                        break;
                    case 4:
                        res = 'Nhà trẻ';
                        break;
                    case 5:
                        res = 'Mẫu giáo';
                        break;
                    case 12:
                        res = 'PTCS';
                        break;
                    case 1245:
                        res = 'MN-PTCS';
                        break;
                    case 145:
                        res = 'MN-TH';
                        break;
                    case 23:
                        res = 'Trung học';
                        break;
                    case 123:
                        res = 'Phổ thông';
                        break;
                    case 12345:
                        res = 'MN-PT';
                        break;
                    case 45:
                        res = 'Mầm non';
                        break;
                    case 6:
                        res = 'GDTX';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            checkTruocKhiTim(){
                this.trangbatdau = !this.trangbatdau;
            },
            // Tải excel
            DownLoad() {
                let url = "down-load-template-mk-ket-chuyen";
                let params = {};
                utils.confirmDialog(
                    "Xác nhận tải xuống dữ liệu. Vui lòng chờ trong thời gian tải xuống",
                    "Đống ý",
                    () => {

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                        api.post(url, params, (data) => {
                            loading.close();
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
                )
            },
            nameWithLang({tenDonVi, maDonVi}) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            nameWithSchool({tenTruongHoc, maTruongHoc}) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            nameWithValue({name}) {
                return `${name}`
            },
            xemHuongDan() {
                this.huong_dan = true;
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getMatKhauKetChuyen();
            },
            getTime(date) {
                return timeutils.convertTime(new Date(date));
            },
            showUpdate(e) {
                console.log("thay chỉnh sửa mật khẩu kết chuyển");
                this.thongTinTruong = e;
                this.show_update = true;
            },
            onSelectDonVi(e) {
                console.log("chọn xong đơn vị nè");
                console.log(JSON.stringify(e));
            },
            onUpdateData() {
                dialog.confirmDialog("Thay đổi mật khẩu thành công", "Đồng ý", () => {});
            },
            onCreatedData() {
                dialog.confirmDialog("Thêm mới thông tin thành công", "Đồng ý", () => {});
            },
            deleteUnit(qh) {
                console.log(JSON.stringify(qh));
                dialog.confirmDialog("Bạn có muốn xóa tổ thôn này?", "Đồng ý", () => {
                    console.log("đồng ý xóa");
                    showDialog("Thông báo", "Xóa thành công", null, () => {});
                });
            },
            getDonVi() {
                let params = {
                    start: 0,
                    limit: 9999,
                    // loaiDonVi:2,
                    maTinhThanh: this.thongtin.province
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, data => {
                    loading.close();
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.listDonVi);
                        this.listDonVi = data.data.rows;
                    }
                });
            },
            getTinhThanh() {
                let params = {
                    start: 0,
                    limit: 25,
                    ma: this.thongtin.province
                };
                console.log("pr" + JSON.stringify(params));
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmTinhThanh/filter", params, data => {
                    loading.close();
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_tinh_thanh);
                        this.ds_tinh_thanh = data.data.rows;
                        console.log("đơn vị trả về:" + JSON.stringify(this.ds_tinh_thanh));
                    }
                });
            },
            showCreat() {
                console.log("thêm mới mật khẩu kết chuyển");
                this.thongTinDangNhap = this.thongtin;
                this.show_create = true;
            },
            showImport() {
                this.show_import = true;
            },
            getTruongHoc() {
                let params = {
                    start: 0,
                    limit: 100000,
                    caphoc: parseInt(this.capHoc),
                    madonvi: this.madonvi,
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmTruongHoc/filter", params, data => {
                    loading.close();
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_truong_hoc);
                        this.ds_truong_hoc = data.data.rows;
                    }
                });
            },
            getMatKhauKetChuyen() {
                this.listMatKhau = [];
                this.total_rows = 0;
                const uri = "/api_lay_mat_khau_ket_chuyen";
                const params = {
                    start: this.start,
                    limit: this.limit,
                    maTinhThanh: this.tinhthanh,
                    maDonVi: this.ojDonVi.maDonVi,
                };
                if(this.ojCapHoc){
                    params.capHoc =  this.ojCapHoc.id
                }
                if(this.ojTruongHoc){
                    params.maTruongHoc =  this.ojTruongHoc.maTruongHoc
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-push/KetChuyenDL/filterMatKhauKc", params, response => {
                    loading.close();
                    if (response.data.code === 200) {
                        this.listMatKhau = response.data.rows;
                        if (this.listMatKhau == null) {
                            this.listMatKhau = [];
                        };
                        this.total_rows = response.data.total;
                        if (this.total_rows == 0) {
                            this
                                .$alertify
                                .error("Không có bản ghi nào được tìm thấy");
                        }
                        this.total_rows = response.data.total;
                        console.log("bản ghi là:" + JSON.stringify(this.listMatKhau))
                    } else {
                        this
                            .$alertify
                            .error(response.data.message);
                    }
                });

            }
        }
    };
</script>
<style scoped="scoped">
    @import "../../../../node_modules/selectwithsearch.css";
    a,
    p {
        font-size: 10pt;
    }
</style>

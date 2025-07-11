<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6">
                <h3 class=" text-uppercase">Mật khẩu kết chuyển</h3>
            </div>
            <div class="col-sm-6 pull-right">
                <button
                    class="btn btn-info pull-right"
                    @click.prevent="xemHuongDan()"
                    style="margin-top:15px;">Hướng dẫn</button>
                <HuongDan :show="huong_dan" @close="huong_dan=false"></HuongDan>
            </div>
        </div>
        <form role="form">
            <div class="row space20">
                <div class="col-md-3">
                    <label>Tỉnh thành:</label>
                    <select disabled="disabled" v-model="tinhthanh" class="form-control">
                        <option v-for="tt in ds_tinh_thanh" :value="tt.maTinhThanh">{{tt.tenTinhThanh}}</option>
                    </select>

                </div>
                <div class="col-md-3">
                    <label>Đơn vị:</label>
                    <div class="form-control baoselect">
                        <ejs-multiselect
                            style="border:none !improtant;"
                            class="form-control"
                            id="multiselect"
                            v-model="dsDonVi"
                            :dataSource="listDonVi"
                            placeholder="Chọn đơn vị"
                            mode="CheckBox"
                            :fields="dsdv"
                            :showSelectAll="showSelectAll"
                            selectAllText="Chọn tất cả"
                            unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect>
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Cấp học:</label>
                    <div class="form-control baoselect">
                        <ejs-multiselect
                            style="border:none !improtant;"
                            class="form-control"
                            id="multiselect"
                            v-model="dsCapHoc"
                            :dataSource="list_cap_hoc"
                            placeholder="Chọn cấp học"
                            mode="CheckBox"
                            :fields="dsch"
                            :showSelectAll="showSelectAll"
                            selectAllText="Chọn tất cả"
                            unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect>
                    </div>
                </div>
                <div class="col-md-3">
                    <label>Trường học:</label>
                    <div style="border:1px solid #ccc;border-radius:4px;">
                        <ejs-multiselect
                            style="border:none !improtant;"
                            class="form-control"
                            id="multiselect"
                            v-model="dsTruongHoc"
                            :dataSource="listTruongHoc"
                            placeholder="Chọn trường học"
                            mode="CheckBox"
                            :fields="dsth"
                            :showSelectAll="showSelectAll"
                            selectAllText="Chọn tất cả"
                            unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect>
                    </div>
                </div>
            </div>
            <div class="row space20">
                <div class="col-md-3">
                    <label>Năm học:</label>
                    <select v-model="namHoc" class="form-control">
                        <option value="">Chọn năm học</option>
                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Trạng thái:</label>
                    <select v-model="trangThai" class="form-control">
                        <option value="">Chọn trạng thái</option>
                        <option value="1">Thành công</option>
                        <option value="2">Thất bại</option>
                        <option value="3">Đang xử lý</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Loại yêu cầu:</label>
                    <select v-model="loaiYeuCau" class="form-control">
                        <option value="">Chọn loại yêu cầu</option>
                        <option value='1'>Dữ liệu trường</option>
                        <option value='2'>Dữ liệu giáo viên</option>
                        <option value='3'>Dữ liệu lớp học</option>
                        <option value='4'>Dữ liệu học sinh</option>
                        <option value='5'>Dữ liệu kết quả học tập</option>
                        <option value='6'>Dữ liệu EQMS</option>
                    </select>
                </div>
            </div>
            <div class="text-center" style="padding-top:5px">
                <button
                    class="btn btn-success"
                    v-on:click.prevent="getDanhSachLichSuChuyenDuLieu()">
                    <i class="fa fa-search"></i>Tìm kiếm
                </button>
            </div>
        </form>
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Danh sách trường học</label>
                                <button
                                    style="margin:0 5px"
                                    class="btn btn-danger pull-right"
                                    v-on:click.prevent="showDelete()">
                                    <i class="fas fa-trash-alt"></i>
                                    Xóa yêu cầu
                                </button>
                                <button
                                    style="margin:0 5px"
                                    class="btn btn-primary pull-right"
                                    v-on:click.prevent="showCreatDataTransfer()">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                    Tạo yêu cầu
                                </button>
                                <button
                                    style="margin:0 5px"
                                    class="btn btn-success pull-right"
                                    v-on:click.prevent="showImport()">
                                    <i class="fas fa-upload"></i>
                                    Import
                                </button>
                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;"/>
                        <div class="row">
                            <div class="col-sm-12">

                                <div class="table-responsive row_tp">
                                    <table
                                        class="table table-striped table-bordered table-hover"
                                       >
                                        <thead>
                                            <tr class="text-center">
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Tên trường</th>
                                                <th class="text-center">Năm học</th>
                                                <th class="text-center">Bước đẩy</th>
                                                <th class="text-center">Trạng thái</th>
                                                <th class="text-center">Thao tác</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="listKetChuyen.length===0">
                                            <tr>
                                                <td class="text-center" colspan="22">Không có dữ liệu phù hợp</td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else="v-else">
                                            <tr v-for="(px,index) in listKetChuyen">
                                                <td>{{(currentPage-1)*limit + index + 1}}</td>
                                                <td>{{px.tenTruong}}</td>
                                                <td>{{px.namHoc}}-{{parseInt(px.namHoc)+1}}</td>
                                                <td>
                                                    <div v-if="px.buocHienTai==1">Thành công</div>
                                                    <div v-else-if="px.buocHienTai==2">Đẩy dữ liệu giáo viên</div>
                                                    <div v-else-if="px.buocHienTai==3">Đẩy dữ liệu lớp học</div>
                                                    <div v-else-if="px.buocHienTai==4">Đẩy dữ liệu học sinh</div>
                                                    <div v-else-if="px.buocHienTai==5">Đẩy dữ liệu kết quả học tập</div>
                                                    <div v-else-if="px.buocHienTai==6">Đẩy dữ liệu EQMS</div>
                                                    <div v-else="v-else">Đang xử lý</div>
                                                </td>
                                                <td>
                                                    <div v-if="px.trangThaiBuocHienTai==1">Thành công</div>
                                                    <div v-else-if="px.trangThaiBuocHienTai==2">Thất bại</div>
                                                    <div v-else-if="px.trangThaiBuocHienTai==10">Đang tổng hợp</div>
                                                    <div v-else-if="px.trangThaiBuocHienTai==11">Tổng hợp xong</div>
                                                    <div v-else-if="px.trangThaiBuocHienTai==12">Tổng hợp lỗi</div>
                                                    <div v-else="v-else">Đang xử lý</div>
                                                </td>
                                                <td class="text-center" style="text-align:center">
                                                    <a href="#" title="Chi tiết" v-on:click.prevent="showInfo(px)">
                                                        <i class="fas fa-info-circle"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <ThongTin
                                        :show="show_info"
                                        :item="idBanGhi"
                                        @success="onCreatedData($event)"
                                        @close="show_info=false"></ThongTin>
                                    <ThemMoi
                                        :show="show_creat"
                                        :user="thongTinDangNhap"
                                        @success="onCreatedData($event)"
                                        @close="show_creat=false"></ThemMoi>
                                    <Import
                                        :show="show_import"
                                        @success="onCreatedData($event)"
                                        @close="show_import=false"></Import>
                                    <XoaKetChuyen
                                        :show="show_del"
                                        @success="onCreatedData($event)"
                                        @close="show_del=false"></XoaKetChuyen>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from "../../utils/rest_api";
    import array_util from "../../utils/array_utils";
    import timeutils from "../../utils/time_utils";
    import utils from "../../utils";
    import Page from "../ui/PagingCustom";
    import ThongTin from "./ThongTinKetChuyen";
    import ThemMoi from "./ThemMoiKetChuyenDuLieu";
    import XoaKetChuyen from "./XoaKetChuyenDuLieu";
    import Import from "./ImportKetChuyenDuLieu";
    import dialog from "../../utils/dialog";
    import constant from "../../utils/constant";
    import api from "./../api";

    export default {
        props: ["info"],
        components: {
            Page: Page,
            ThongTin: ThongTin,
            ThemMoi: ThemMoi,
            Import: Import,
            XoaKetChuyen: XoaKetChuyen
        },
        computed: {},
        data() {
            return {
                namHoc: '',
                idBanGhi: "",
                trangThai: '',
                loaiYeuCau: '',
                list_years: constant.LIST_YEARS_FULL,
                show_update: false,
                show_creat: false,
                show_import: false,
                show_del: false,
                show_info: false,
                total_rows: 0,
                ma_truong_hoc: "",
                listKetChuyen: [],
                ds_truong_hoc: [],
                ds_tinh_thanh: [],
                start: 0,
                currentPage: 1,
                capHoc: "",
                thongTinDangNhap: {},
                tinhthanh: "",
                madonvi: "",
                limit: 25,
                listDonVi: [],

                showSelectAll: true,
                listTruong: [],
                lsMaDonVi: [],
                lsCapHoc: [],
                listTruongHoc: [],
                list_cap_hoc: constant.LIST_CAP_HOC,
                dsDonVi: [],
                dsTruongHoc: [],
                dsCapHoc: [],
                dsdv: {
                    text: "tenDonVi",
                    value: "maDonVi"
                },
                dsch: {
                    text: "name",
                    value: "id"
                },
                dsth: {
                    text: "tenTruongHoc",
                    value: "maTruongHoc"
                }
            };

        },

        mounted() {
            this.thongtin = JSON.parse(this.info);
            // console.log("Thông tin đăng nhập:" + JSON.stringify(this.thongtin));
            this.tinhthanh = this.thongtin.province;
            this.getDonVi();
            this.getTinhThanh();
            this.madonvi = this.tinhthanh;
            this.getDanhSachTruongHoc();
        },

        watch: {
            dsCapHoc: function (newVal) {
                this.lsCapHoc = newVal;
                this.listTruong = [];
                this.listTruongHoc = [];
                this.getDanhSachTruongHoc();
            },
            dsDonVi: function (newVal) {
                this.lsMaDonVi = newVal;
                this.listTruong = [];
                this.listTruongHoc = [];
                this.getDanhSachTruongHoc();
            }
        },

        methods: {
            getDanhSachTruongHoc() {
                let params = {
                    ma: this.maTruong,
                    maDonVi: this.lsMaDonVi,
                    capHoc: this.lsCapHoc
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    if (data.data != null) {
                        if (data.data.code == 200) {
                            array_util.clearArrays(this.listTruongHoc);
                            this.listTruongHoc = data.data.rows;
                            console.log("trường học:")
                            console.log(JSON.stringify(this.listTruongHoc))
                        } else {
                            this.listTruong = [];
                            this.listTruongHoc = [
                                {
                                    "maTruongHoc": "",
                                    "tenTruongHoc": "Danh sách trường học trống"
                                }
                            ];
                        }
                    }
                });
            },
            onCapHocChang() {
                this.ma_truong_hoc = "";
                this.getTruongHoc();
            },
            layLai(e) {
                // console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getDanhSachLichSuChuyenDuLieu();
            },
            getTime(date) {
                return timeutils.convertTime(new Date(date));
            },
            showUpdate() {
                // console.log("thay chỉnh sửa mật khẩu kết chddddddddddddddddddddduyển");
                this.show_update = true;
            },
            showDelete() {
                // console.log("xóa kết chuyển dữ liệu");
                this.show_del = true;
            },
            showImport() {
                // console.log("hiển thị import dữ liệu");
                this.show_import = true;
            },
            showInfo(e) {
                console.log("xem chi tiết của bản ghi:" + JSON.stringify(e));
                this.idBanGhi = e;
                this.show_info = true;
            },
            showCreatDataTransfer() {
                // console.log("tạo yêu cầu kết chuyển dữ liệu");
                this.thongTinDangNhap = this.thongtin;
                this.show_creat = true;
            },
            onDonViChange() {
                array_util.clearArrays(this.ds_truong_hoc);
                this.ma_truong_hoc = "";
                if (this.madonvi == "") {
                    return;
                }
                this.getTruongHoc();
            },
            onUpdateData() {
                dialog.confirmDialog("Thay đổi mật khẩu thành công", "Đồng ý", () => {});
            },
            onCreatedData() {
                dialog.confirmDialog("Thêm mới thông tin thành công", "Đồng ý", () => {});
            },
            deleteUnit(qh) {
                // console.log(JSON.stringify(qh));
                dialog.confirmDialog("Bạn có muốn xóa tổ thôn này?", "Đồng ý", () => {
                    // console.log("đồng ý xóa");
                    showDialog("Thông báo", "Xóa thành công", null, () => {});
                });
            },
            getDonVi() {
                let params = {
                    start: 0,
                    limit: 9999,
                    maTinhThanh: this.thongtin.province
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, data => {
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
                rest_api.get("/internal-api/dmTinhThanh/filter", params, data => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_tinh_thanh);
                        this.ds_tinh_thanh = data.data.rows;
                        // console.log("đơn vị trả về:" + JSON.stringify(this.ds_tinh_thanh));
                    }
                },60000, true);
            },
            getTruongHoc() {
                array_util.clearArrays(this.ds_truong_hoc);
                let params = {
                    start: 0,
                    limit: 99999,
                    caphoc: parseInt(this.capHoc),
                    madonvi: this.madonvi
                };
                rest_api.get("/internal-api/dmTruongHoc/filter", params, data => {
                    if (array_util.isArray(data.data.rows)) {
                        this.ds_truong_hoc = data.data.rows;
                    }
                });
            },
            getDanhSachLichSuChuyenDuLieu() {
                array_util.clearArrays(this.listKetChuyen);
                let params = {
                    maDonVi: this.madonvi,
                    start: this.start,
                    limit: this.limit,
                    loaiYeuCau: this.loaiYeuCau,
                    capHoc: this.capHoc,
                    maTruongHoc: this.ma_truong_hoc,
                    trangThai: this.trangThai,
                    namHoc: this.namHoc,
                    maTruongs: this.dsTruongHoc,
                    maDonVis: this.dsDonVi,
                    maCapHocs: this.dsCapHoc

                };
                rest_api.post("/csdlgd-push/LichSuDay/listTruong", params, data => {
                    console.log(
                        "csdlgd-push/LichSuDay/Sreach lấy cdữ liệu:" + JSON.stringify(params)
                    );
                    // console.log("danh sách trả về:" + JSON.stringify(data));
                    if (data.data.statusResponse == 0) {
                        this.listKetChuyen = data.data.rows;
                        if (data.data.rows == null) {
                            this.listKetChuyen = [];
                        }
                        this.total_rows = data.data.total;
                        if (this.total_rows == 0) {
                            utils.showDialog(
                                "Thông báo",
                                "Không có bản ghi nào được tìm thấy",
                                null,
                                () => {}
                            );
                            return;
                        }
                    } else {
                        utils.showDialog("Thông báo", data.data.rd);
                        return;
                    }
                });
            }
        }
    };
</script>
<style scoped="scoped">
    table a:hover {
        background: palevioletred;
    }

    .baoselect {
        padding: 0;
        border: 1px solid #d6d6d6;
        border-radius: 4px;
    }
    .e-multiselect.e-checkbox .e-multi-select-wrapper .e-searcher {
        margin-left: 15px;
    }
</style>

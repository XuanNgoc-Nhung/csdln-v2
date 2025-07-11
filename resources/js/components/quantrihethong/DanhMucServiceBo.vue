<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Đồng bộ danh mục</span>
            </div>
        </div>
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <ul class="nav nav-tabs">
                    <li class="active">
                        <a data-toggle="tab" href="#home">Danh mục chung</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#menu1">Danh mục hồ sơ</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#menu2">Service tiếp nhận dữ liệu</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#menu3">Service cấp mã giáo viên</a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#menu4">Service cấp mã học sinh</a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div id="home" class="tab-pane fade in active">
                        <div class="panel panel-default" style="border-top:none">
                            <div class="panel-body">
                                <div class="row">
                                    <!-- demo ở đây -->
                                    <div class="col-sm-4">
                                        <label class="typo__label">Chọn danh mục:</label>
                                        <multiselect
                                            style="height:34px;"
                                            v-model="loaiDanhMuc"
                                            :options="ds_danh_muc"
                                            :custom-label="nameWithLang"
                                            placeholder="Chọn 1 danh mục"
                                            label="name"
                                            track-by="name"></multiselect>
                                    </div>
                                    <!-- -->
                                    <div
                                        class="col-sm-2"
                                        v-if="loaiDanhMuc.value=='GET_ALL_HUYEN'||loaiDanhMuc.value=='GET_DM_XA'||loaiDanhMuc.value=='GET_DM_LOAI_HINH'||loaiDanhMuc.value=='GET_DM_MUC_DAT_CHUAN_QUOC_GIA'||loaiDanhMuc.value=='GET_DM_HINH_THUC_HOP_DONG'||loaiDanhMuc.value=='GET_DM_VUNG'||loaiDanhMuc.value=='GET_DM_MUC_DAT_CHUAN_QUOC_GIA'"
                                    >
                                        <label>Năm học</label>
                                        <select
                                            class="form-control"
                                            v-model="namHoc">
                                            <option value="">Chọn năm học</option>
                                            <option v-for="y in list_nam_hoc" :value="y.id">{{y.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 text-center" style="padding-top:15px;">
                                        <button class="btn btn-primary" style="height:34px" @click.prevent="getData">Lấy
                                            dữ liệu
                                        </button>
                                        <button @click.prevent="DongBo" class="btn btn-info">
                                            <i class="fas fa-sync"></i>
                                            Đồng bộ
                                        </button>
                                    </div>
                                </div>
                                <hr style="margin: 10px 0 0;"/>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr style="background:#f6f6f6">
                                                    <th>
                                                        <p>STT</p>
                                                    </th>
                                                    <th>
                                                        <p>Mã danh mục</p>
                                                    </th>
                                                    <th>
                                                        <p>Tên danh mục</p>
                                                    </th>
                                                    <th>
                                                        <p>Mã cha</p>
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi.length==0">
                                                <tr>
                                                    <td class="text-center" colspan="17">
                                                        <p>Không có bản ghi nào được tìm thấy</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                <tr v-for="(tg,index) in list_ban_ghi">
                                                    <td class="text-center">
                                                        <p>{{index+1}}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{tg.ma}}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{tg.ten}}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{tg.maCha}}</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>

                            </div>
                        </div>
                    </div>
                    <div id="menu1" class="tab-pane fade">
                        <div class="panel panel-default" style="border-top:none">
                            <div class="panel-body">
                                <div class="row">
                                    <!-- demo ở đây -->
                                    <div class="col-sm-4">
                                        <label class="typo__label">Chọn danh mục:</label>
                                        <multiselect
                                            v-model="loaiDanhMucHoSo"
                                            :options="ds_danh_muc_ho_so"
                                            :custom-label="nameWithLang"
                                            placeholder="Chọn danh mục"
                                            label="name"
                                            track-by="name"></multiselect>
                                    </div>
                                    <!-- -->
                                    <div v-if="this.thongtin.role==1" class="col-sm-4">
                                        <label>Sở</label>
                                        <multiselect
                                            v-model="ojDonVi"
                                            :options="ds_don_vi"
                                            :custom-label="nameWithDonVi"
                                            placeholder="Chọn đơn vị"
                                            label="tenDonVi"
                                            track-by="tenDonVi"></multiselect>
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Năm học</label>
                                        <select
                                            class="form-control"
                                            v-model="namHocHoSo">
                                            <option value="">Chọn năm học</option>
                                            <option v-for="y in list_nam_hoc" :value="y.id">{{y.name}}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-12 text-center" style="padding-top:15px;">
                                        <button class="btn btn-primary" style="height:34px"
                                                @click.prevent="getDataDanhMucHoSo">Lấy dữ liệu
                                        </button>
                                        <button @click.prevent="DongBo" class="btn btn-info">
                                            <i class="fas fa-sync"></i>
                                            Đồng bộ
                                        </button>
                                    </div>
                                </div>
                                <hr style="margin: 10px 0 0;"/>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr style="background:#f6f6f6">
                                                    <th class="text-center"><p>STT</p></th>
                                                    <th class="text-center"><p>Mã</p></th>
                                                    <th class="text-center"><p>Tên</p></th>
                                                    <th class="text-center"><p>Địa chỉ</p></th>
                                                    <th class="text-center"><p>Năm học</p></th>
                                                    <th class="text-center"><p>Loại hình trường</p></th>
                                                </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi_danh_muc_ho_so.length==0">
                                                <tr>
                                                    <td class="text-center" colspan="17">
                                                        <p>Không có bản ghi nào được tìm thấy</p>
                                                    </td>
                                                </tr>
                                                </tbody>
                                                <tbody v-else>
                                                <tr v-for="(tg,index) in list_ban_ghi_danh_muc_ho_so">
                                                    <td class="text-center"><p>{{(currentPage-1)*limit + index+1}}</p>
                                                    </td>
                                                    <td><p>{{tg.ma}}</p></td>
                                                    <td><p>{{tg.ten}}</p></td>
                                                    <td><p>{{tg.diaChi}}</p></td>
                                                    <td class="text-center"><p>{{tg.namHoc}}-{{tg.namHoc + 1}}</p></td>
                                                    <td><p>{{tg.maLoaiTruong}}</p></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <Page :total_rows="total_rows" @pageChange="layLai2($event)"></Page>
                            </div>
                        </div>
                    </div>
                    <div id="menu2" class="tab-pane fade">
                        <div class="panel panel-default" style="border-top:none">
                            <div class="panel-body">
                                <label>Danh sách service</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead>
                                                <tr style="background:#f6f6f6">
                                                    <th class="text-center"><p>STT</p></th>
                                                    <th class="text-center"><p>Tên service</p></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr v-for="(tg,index) in list_service_thong_tin">
                                                    <td class="text-center"><p>{{index+1}}</p>
                                                    </td>
                                                    <td><p>{{tg.tenService}}</p></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="menu3" class="tab-pane fade">
                        <div class="panel panel-default" style="border-top:none">
                            <div class="panel-body">
                                <label>Danh sách service cấp mã giáo viên</label>
                                <p><span>Hệ thống đang nâng cấp. Vui lòng quay lại sau ít phút...</span></p>
<!--                                <CapMaGiaoVien :info="dangNhap"></CapMaGiaoVien>-->
                            </div>
                        </div>
                    </div>
                    <div id="menu4" class="tab-pane fade">
                        <div class="panel panel-default" style="border-top:none">
                            <div class="panel-body">
                                <label>Danh sách service cấp mã học sinh</label>
                                <p>Hệ thống đang nâng cấp. Vui lòng quay lại sau ít phút...</p>
<!--                                <CapMaHocSinh :info="dangNhap"></CapMaHocSinh>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import constant from "../../utils/constant";
    import api from '../api';
    import utils from '../../utils'
    import VueAlertify from 'vue-alertify';
    import CapMaGiaoVien from '../tracuu/TraCuuCanBo';
    import CapMaHocSinh from '../tracuu/TraCuuHocSinh';
    import Page from '../ui/PagingCustom';

    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {

        components: {
            "Page": Page,
            "CapMaGiaoVien": CapMaGiaoVien,
            "CapMaHocSinh": CapMaHocSinh,
            Multiselect
        },

        computed: {},
        props: ['info'],

        data() {

            return {
                thongtin: {},
                dangNhap: {},
                loaiDanhMuc: "",
                ojDonVi: "",
                loaiDanhMucHoSo: "",
                maSoHoSo: "",
                namHoc: "",
                namHocHoSo: "",
                ds_danh_muc: constant.DANH_SACH_DANH_MUC_SERVICE,
                ds_danh_muc_ho_so: constant.DANH_SACH_DANH_MUC_SERVICE_HO_SO,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                total_rows: 0,
                list_ban_ghi: [],
                ds_don_vi: [],
                list_ban_ghi_danh_muc_ho_so: [],
                start: 0,
                currentPage: 1,
                limit: 25,
                list_service_thong_tin: [
                    {tenService: "Service bổ sung thông tin trường học đầu năm"},
                    {tenService: "Service bổ sung thông tin trường học cuối năm học"},
                    {tenService: "Service cập nhật thông tin cán bộ đầu năm học"},
                    {tenService: "Service cập nhật thông tin cán bộ cuối năm học"},
                    {tenService: "Service cập nhật thông tin lớp học trong năm học"},
                    {tenService: "Service cập nhật thông tin môn học của lớp trong năm học"},
                    {tenService: "Service cập nhật thông tin học sinh đầu năm học"},
                    {tenService: "Service cập nhật thông tin học sinh cuối năm học"},
                    {tenService: "Service cập nhật thông tin học sinh chuyển lớp"},
                    {tenService: "Service cập nhật thông tin học sinh chuyển trường"},
                    {tenService: "Service cập nhật thông tin học sinh bỏ học"},
                    {tenService: "Service cập nhật điểm học sinh"},
                    {tenService: "Service cập nhật điểm tổng kết học sinh"},
                ]
            }
        },

        mounted() {
            console.log("thông tin đăng nhập:" + this.info);
            this.thongtin = JSON.parse(this.info);
            this.dangNhap = JSON.parse(this.info);
            this.getDonVi();
        },

        watch: {
            loaiDanhMuc: function (newVal) {
                this.namHoc = "";
            }
        },

        methods: {

            nameWithLang({name}) {
                return `${name}`
            },
            nameWithDonVi({tenDonVi}) {
                return `${tenDonVi}`
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            layLai2(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getDataDanhMucHoSo()
            },

            getDonVi() {
                let params = {
                    start: 0,
                    limit: 9999,
                    loaiDonVi: '1',
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, data => {
                    this.ds_don_vi = data.data.rows;
                });
            },
            getData() {
                if (this.loaiDanhMuc.value == "") {
                    utils.showDialog("Thông báo", "Vui lòng chọn danh mục", null, () => {
                    });
                    return;
                }
                if (this.loaiDanhMuc.value == "GET_ALL_HUYEN" || this.loaiDanhMuc.value == "GET_DM_XA" || this.loaiDanhMuc.value == "GET_DM_LOAI_HINH" || this.loaiDanhMuc.value == "GET_DM_MUC_DAT_CHUAN_QUOC_GIA" || this.loaiDanhMuc.value == "GET_DM_HINH_THUC_HOP_DONG" || this.loaiDanhMuc.value == "GET_DM_VUNG" && this.namHoc == "") {
                    if (this.namHoc == "") {
                        utils.showDialog("Thông báo", "Vui lòng chọn năm học", null, () => {
                        });
                        return;
                    }
                }
                this.total_rows = 0;
                this.list_ban_ghi = [];
                console.log("loại danh mục là:" + this.loaiDanhMuc.value);
                let params = {
                    start: this.start,
                    limit: this.limit
                };
                if (this.namHoc) {
                    params.namHoc = this.namHoc;
                }
                console.log(params);
                let url = "/csdlgd-push/API/DanhMuc/" + this.loaiDanhMuc.value;
                rest_api.post(url, params, (data) => {
                    console.log(JSON.stringify(data));
                    if (data.data.total > 0) {
                        this.list_ban_ghi = data.data.rows;
                        this.total_rows = data.data.total;
                        // this
                        //     .$alertify
                        //     .success("Lấy dữ liệu thành công");
                    } else {
                        // this
                        //     .$alertify
                        //     .error("Không có bản ghi nào được tìm thấy");
                    }
                }, 5000, true);
            },
            getDataDanhMucHoSo() {
                console.log(this.ojDonVi);
                this.total_rows = 0;
                this.list_ban_ghi_danh_muc_ho_so = [];
                this.maSoHoSo = this.ojDonVi.maDonVi;
                if (this.thongtin.role == 2) {
                    this.maSoHoSo = this.thongtin.ma_so
                }
                let params = {
                    start: this.start,
                    limit: this.limit,
                    namHoc: this.namHocHoSo,
                    maSo: this.maSoHoSo
                };
                console.log(params);
                let url = "/csdlgd-push/HoSo/GetListTruongHoc";
                rest_api.post(url, params, (data) => {
                    console.log("data trả về:" + JSON.stringify(data));
                    if (data.data.total > 0) {
                        this.list_ban_ghi_danh_muc_ho_so = data.data.rows;
                        this.total_rows = data.data.total;
                        // this
                        //     .$alertify
                        //     .success("Lấy dữ liệu thành công");
                    } else {
                        // this
                        //     .$alertify
                        //     .error("Không có bản ghi nào được tìm thấy");
                    }
                }, 5000, true);
            },
            DongBo() {
                if (this.loaiDanhMuc.value == "") {
                    utils.showDialog("Thông báo", "Vui lòng chọn danh mục", null, () => {
                    });
                    return;
                }
                if (this.loaiDanhMuc.value == "GET_ALL_HUYEN" || this.loaiDanhMuc.value == "GET_DM_XA" || this.loaiDanhMuc.value == "GET_DM_LOAI_HINH" || this.loaiDanhMuc.value == "GET_DM_MUC_DAT_CHUAN_QUOC_GIA" || this.loaiDanhMuc.value == "GET_DM_HINH_THUC_HOP_DONG" || this.loaiDanhMuc.value == "GET_DM_VUNG") {
                    if (this.namHoc == "") {
                        utils.showDialog("Thông báo", "Vui lòng chọn năm học", null, () => {
                        });
                        return;
                    }
                }
                utils.confirmDialog("Xác nhận đồng bộ danh mục", "Đồng bộ", () => {
                    const params = {
                        "tenDm": this.loaiDanhMuc.value
                    };
                    if (this.namHoc) {
                        params.namHoc = this.namHoc;
                    }
                    let url = "/csdlgd-push/API/updateDanhMuc/" + this.loaiDanhMuc.value;
                    rest_api.post(url, params, (response) => {
                        if (response.data.code == 200) {
                            this
                                .$alertify
                                .success("Đồng bộ thành công");
                        } else {
                            this
                                .$alertify
                                .error("Đồng bộ dữ liệu thất bại");
                        }
                        console.log("update:");
                        console.log(JSON.stringify(response));
                    }, 60000, true);
                })
            }
        }

    }
</script>
<style scoped="scoped">
    p {
        font-size: 12px;
        margin: 0;
    }

    thead th {
        text-align: center;
    }

    .inline {
        display: -webkit-box;
        margin: 20px 0;
    }

    .inline p {
        vertical-align: middle;
        line-height: 34px;
        padding: 0 5px;
    }

    .vanban {
        display: -webkit-inline-box;
        line-height: 34px;
        text-align: right;
        margin: 20px 0;
        text-align: right;
        float: right;
        padding-right: 15px;
    }

    .nav-tabs > li.active > a {
        background: gainsboro;
        border: 1px solid #ddd;
        border-bottom: none;
    }
</style>

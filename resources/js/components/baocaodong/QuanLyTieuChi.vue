<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Báo cáo tiêu chí <span class="kytu"> &raquo;</span>quản lý tiêu chí</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label class="pull-right lbl_field">Mã tiêu chí:</label>
                    </div>
                    <div class="col-md-6">
                        <input v-model="ma_tieu_chi" class="form-control" placeholder="Nhập...">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label class="pull-right lbl_field">Tên tiêu chí:</label>
                    </div>
                    <div class="col-md-6">
                        <input v-model="ten_tieu_chi" class="form-control" placeholder="Nhập...">
                    </div>
                </div>
            </div>

        </div>

        <div class="row row_tp">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label class="pull-right lbl_field">Nhóm tiêu chí:</label>
                    </div>
                    <div class="col-md-6">
                        <select @change="onTieuChiChange()" v-model="nhom_tieu_chi_id" title="Chọn tỉnh thành"
                                class="form-control"
                                style="width:100%">
                            <option value="-1">--Tất cả--</option>
                            <optgroup v-for="group in ds_tieu_chi" :label="group.tenNhomTieuChi">
                                <option v-for="option in group.listChild" :value="option.nhomTieuChiId">
                                    {{option.tenNhomTieuChi}}
                                </option>
                            </optgroup>

                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label class="pull-right lbl_field">Trạng thái:</label>
                    </div>
                    <div class="col-md-6">
                        <select v-model="trang_thai_tieu_chi" class="form-control" style="width:100%">
                            <option value="-1">--Tất cả--</option>
                            <option value="0">Đang hoạt động</option>
                            <option value="1">Hết hiệu lực</option>
                        </select>
                    </div>
                </div>
            </div>

        </div>

        <div class="row row_tp">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-success" v-on:click.prevent="getData()"><i class="fa fa-search"></i>Tìm
                            kiếm
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <div class="row" style="margin-top: 20px">

            <div class="col-lg-12">

                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <label>Danh sách kết quả</label>
                                <button class="btn btn-success pull-right" style="margin-left: 10px"
                                        v-on:click.prevent="showImport()">
                                    <i class="fas fa-upload"></i> Import
                                </button>
                                <button class="btn btn-success pull-right" v-on:click.prevent="showCreat()">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </button>

                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Tên tiêu chí</th>
                                            <th>Mã tiêu chí</th>
                                            <th>Trạng thái</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_tim_kiem_tieu_chi.length===0">
                                        <tr>
                                            <td class="text-center" colspan="8">Không có dữ liệu phù hợp</td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(px,index) in ds_tim_kiem_tieu_chi">
                                            <td>{{(currentPage-1)*limit + index+1}}</td>
                                            <td>{{px.tenTieuChi}}</td>
                                            <td>{{px.maTieuChi}}</td>
                                            <td>{{parseInt(px.trangThai)=== 0 ? 'Đang hoạt động' : 'Hết hiệu lực'}}
                                            </td>
                                            <td>{{px.ngayCapNhat}}</td>

                                            <td class="text-center">
                                                <a href="#" title="Chi tiết" v-on:click.prevent="showInfor(px)"><i
                                                        class="fas fa-info"></i></a>
                                                <a v-if="px.tieuChiChaId == null" href="#" title="Thêm mới"
                                                   v-on:click.prevent="showCreat(px)"><i
                                                        class="fas fa-plus"></i></a>
                                                <a href="#" title="Chỉnh sửa" v-on:click.prevent="showUpdate(px)"><i
                                                        class="far fa-edit"></i></a>
                                                <a v-if="parseInt(px.trangThai)=== 0" href="#" title="Khóa"
                                                   v-on:click.prevent="lockData(px)"><i
                                                        class="fas fa-lock-open" style="color: #6D2116"></i></a>
                                                <a v-else-if="parseInt(px.trangThai)=== 1" href="#" title="Mở khóa"
                                                   v-on:click.prevent="lockData(px)"><i
                                                        class="fas fa-lock" style="color: #6D2116"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiTieuChi :show="show_create" :item="tieu_chi_cha" :tieuchi="listTieuChi"
                                                    @close="show_create=false"
                                                    @success="onCreatedData($event)"></ThemMoiTieuChi>
                                    <ChinhSuaTieuChi :show="show_update"
                                                     :item="dataEditTieuChi" :tieuchi="listTieuChi"
                                                     @close="show_update=false"
                                                     @success="onUpdatedData($event)"></ChinhSuaTieuChi>
                                    <ChiTietTieuChi :show="show_infor"
                                                    :item="dataEditTieuChi"
                                                    @close="show_infor=false"></ChiTietTieuChi>
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

    import dialog from '../../utils/dialog';
    import api from '../api';
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import timeutils from '../../utils/time_utils';
    import Page from '../ui/PagingCustom';
    import ThemMoi from './ThemTieuChi';
    import ChinhSua from './ChinhSuaTieuChi';
    import ChiTiet from './ChiTietTieuChi';
    import VueAlertify from 'vue-alertify';

    Vue.use(VueAlertify);
    export default {

        components: {
            "Page": Page,
            "ThemMoiTieuChi": ThemMoi,
            "ChinhSuaTieuChi": ChinhSua,
            "ChiTietTieuChi": ChiTiet,
        },

        computed: {},

        data() {

            return {
                // tieu_chi_con: '',
                ten_tinh_thanh: '',
                ten_quan_huyen: '',
                trang_thai_tieu_chi: '-1',
                ten_tieu_chi: '',
                ma_tieu_chi: '',

                nhom_tieu_chi_id: '-1',
                // tieu_chi_cha_id: '',
                tieu_chi_cha: {},
                show_create: false,
                show_infor: false,
                show_import: false,
                show_update: false,
                trang_thai: '',
                total_rows: 0,
                ds_tieu_chi: [],
                ds_tim_kiem_tieu_chi: [],
                start: 0,
                currentPage: 1,
                limit: 25,
                dataEditTieuChi: {},
                listTieuChi: {},
            }
        },

        mounted() {
            this.getTieuChi();
            this.getData();
        },

        watch: {},

        methods: {
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },

            getTieuChi() {
                let params = {
                    "start": 0,
                    "limit": 1000,
                };
                console.log("Lấy danh sách tiêu chí");
                rest_api.post("/csdlgd-admin/bcdNhomTieuChi/search", params, (data) => {
                    console.log("Danh sách tiêu chí:" + JSON.stringify(data));
                    if (array_util.isArray(data.data.tableData)) {
                        this.ds_tieu_chi = data.data.tableData;
                    }
                }, 10000, true);
            },

            getData() {
                let params = {
                    "limit": this.limit,
                    // "loaiTieuChi": 0,
                    "maTieuChi": this.ma_tieu_chi,
                    "nhomTieuChiId": this.nhom_tieu_chi_id === "-1" ? null : this.nhom_tieu_chi_id,
                    // "phanCap": "",
                    // "scriptDongBo": "",
                    "start": this.start,
                    "tenTieuChi": this.ten_tieu_chi,
                    // "tieuChiBaoCaoId": 0,
                    // "tieuChiChaId": this.tieu_chi_cha_id,
                    "trangThai": this.trang_thai_tieu_chi === "-1" ? null : this.trang_thai_tieu_chi,
                };
                console.log("tìm ds tiêu chí:" + params);
                rest_api.post("/csdlgd-admin/bcdTieuChi/search", params, (data) => {
                    if (array_util.isArray(data.data.tableData)) {
                        this.total_rows = data.data.totalRows;
                        console.log("total rows: " + this.total_rows);
                        array_util.clearArrays(this.ds_tim_kiem_tieu_chi);
                        this.ds_tim_kiem_tieu_chi = data.data.tableData;
                        console.log(JSON.stringify(data));
                    }
                }, 10000, true);
            },
            showCreat(px) {
                console.log("thêm mới tiêu chí");
                this.tieu_chi_cha = px;
                this.listTieuChi = this.ds_tieu_chi;

                this.show_create = true;
            },
            showInfor(px){
                console.log("thông tin tiêu chí");
                this.dataEditTieuChi = px;
                this.show_infor = true;
            },
            showImport() {
                console.log("import tiêu chí");
                this.show_import = true;
            },
            showUpdate(px) {
                this.dataEditTieuChi = px;
                this.listTieuChi = this.ds_tieu_chi;
                this.show_update = true;

            },
            onCreatedData() {
                // this.$alertify.success('Thêm tiêu chí thành công.');
                this.getData();
            },
            onUpdatedData(e) {
                // this.$alertify.success('Chỉnh sửa tiêu chí thành công.');
                this.getData();
            },
            lockData(qh) {
                if (parseInt(qh.trangThai) === 1) {
                    dialog.confirmDialog("Bạn có muốn mở khóa tiêu chí này?", "Đồng ý", () => {
                        console.log("đồng ý mở khóa");
                        let uri = "/csdlgd-admin/bcdTieuChi/action";
                        let params = {
                            "id": qh.tieuChiBaoCaoId,
                            "type": 0,
                        };
                        console.log("url" + uri + "param" + params)
                        rest_api.post(uri, params, (response) => {
                            if (response.data.rc === 0) {
                                showDialog("Thông báo", "Mở khóa tiêu chí thành công", null, () => {
                                    this.getData();
                                });
                            } else {
                                showDialog("Thất bại", response.data.message, null, () => {
                                    return;
                                });
                            }
                        });
                    });
                } else if (parseInt(qh.trangThai) === 0) {
                    dialog.confirmDialog("Bạn có muốn khóa tiêu chí này?", "Đồng ý", () => {
                        console.log("đồng ý khóa");

                        let uri = "/csdlgd-admin/bcdTieuChi/action";
                        let params = {
                            "id": qh.tieuChiBaoCaoId,
                            "type": 1,
                        };
                        rest_api.post(uri, params, (response) => {
                            if (response.data.rc === 0) {
                                showDialog("Thông báo", "Khóa tiêu chí thành công", null, () => {
                                    this.getData();
                                });
                            } else {
                                showDialog("Thất bại", response.data.message, null, () => {
                                    return;
                                });
                            }
                        });
                    });
                }


            },
            onTieuChiChange() {
                // if (this.tieu_chi_con === "" || this.tieu_chi_con == null) {
                //     this.nhom_tieu_chi_id = "";
                //     this.tieu_chi_cha_id = "";
                // } else {
                //     this.nhom_tieu_chi_id = this.tieu_chi_con.nhomTieuChiId;
                //     this.tieu_chi_cha_id = this.tieu_chi_con.nhomTieuChiChaId;
                // }
            }
        }
    }

</script>

<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> BÁO CÁO TIÊU CHÍ <span class="kytu"> &raquo;</span>QUẢN LÝ NHÓM TIÊU CHÍ</span>
            </div>
        </div>
        <form class="form-inline" role="form">
            <label>Tên nhóm :</label>
            <input class="form-control" placeholder="Nhập..." v-model="v_ten_nhom_tieu_chi">
            <label class="search-style">Cấp nhóm :</label>
            <select class="form-control" v-model="v_cap_nhom">
                <option value=-1>-- Tất cả --</option>
                <option value=0>Cấp cha</option>
                <option value=1>Cấp con</option>
            </select>
            <label class="search-style">Trạng thái:</label>
            <select class="form-control" v-model="v_trang_thai">
                <option value=-1>-- Chọn --</option>
                <option value=0>Đang hoạt động</option>
                <option value=1>Ngưng hoạt động</option>
            </select>
            <button class="btn btn-success " v-on:click.prevent="getData()"><i class="fa fa-search"></i>Tìm kiếm
            </button>
        </form>
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">

                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <button class="btn btn-success pull-right" v-on:click.prevent="showCreate()">
                                    <i aria-hidden="true" class="fa fa-plus"></i> Thêm mới
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
                                            <th>Tên nhóm tiêu chí</th>
                                            <th>Cấp nhóm</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Trạng Thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="v_ds_nhom_tieu_chi.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có dữ liệu phù hợp</td>
                                        </tr>
                                        </tbody>
                                        <tbody>
                                        <template v-for="(ntc,index) in v_ds_nhom_tieu_chi">
                                            <tr>
                                                <td :key="ntc.nhomChiTieuId" @click.prevent="click(ntc)">
                                                    <div v-if="parseInt(ntc.capNhom) === 0">
                                                        <span v-if="ntc.open"><i class="fas fa-arrow-up"></i>{{index + 1}}. {{ntc.tenNhomTieuChi}}</span>
                                                        <span v-else><i class="fas fa-arrow-down"></i>{{index + 1}}. {{ntc.tenNhomTieuChi}}</span>
                                                    </div>
                                                    <div v-else>
                                                        {{ntc.tenNhomTieuChi}}
                                                    </div>
                                                </td>
                                                <td>{{parseInt(ntc.capNhom)=== 0 ? 'Cấp 1' : 'Cấp 2'}}</td>
                                                <td>{{ntc.ngayCapNhat}}</td>
                                                <td>{{getTrangThaiStr(ntc)}}</td>
                                                <td class="text-center">
                                                    <a title="Thông tin" v-on:click.prevent="showInfo(ntc)"><i
                                                        class="fas fa-info"></i></a>
                                                    <a title="Chỉnh sửa" v-on:click.prevent="showUpdate(ntc)"><i
                                                        class="far fa-edit"></i></a>
                                                    <a title="Khóa" v-if="getTrangThaiInt(ntc) === 0 "
                                                       v-on:click.prevent="method_lock(ntc)"><i
                                                        class="fas fa-lock"></i></a>
                                                    <a title="Mở Khóa" v-else v-on:click.prevent="method_unlock(ntc)"><i
                                                        class="fas fa-lock-open"></i></a>
                                                </td>
                                            </tr>
                                            <template v-if="ntc.open">
                                                <tr v-for="lc in ntc.listChild">
                                                    <td class="child-style">{{lc.tenNhomTieuChi}}</td>
                                                    <td>{{parseInt(lc.capNhom)=== 0 ? 'Cấp cha' : 'Cấp con'}}</td>
                                                    <td>{{lc.ngayCapNhat}}</td>
                                                    <td>{{getTrangThaiStr(lc)}}</td>
                                                    <td class="text-center">
                                                        <a title="Thông tin" v-on:click.prevent="showInfo(lc)"><i
                                                            class="fas fa-info"></i></a>
                                                        <a title="Chỉnh sửa" v-on:click.prevent="showUpdate(lc)"><i
                                                            class="far fa-edit"></i></a>
                                                        <a title="Khóa" v-if="getTrangThaiInt(lc) === 0"
                                                           v-on:click.prevent="method_lock(lc)"><i
                                                            class="fas fa-lock"></i></a>
                                                        <a title="Mở Khóa" v-else
                                                           v-on:click.prevent="method_unlock(lc)"><i
                                                            class="fas fa-lock-open"></i></a>
                                                    </td>
                                                </tr>
                                            </template>
                                        </template>
                                        </tbody>
                                    </table>

                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiNhomTieuChi :show="v_show_create" @close="v_show_create=false"
                                                        @success="onCreatedData($event)"></ThemMoiNhomTieuChi>
                                    <UpdateNhomTieuChi :item="v_data_edit"
                                                       :show="v_show_update"
                                                       @close="v_show_update=false"
                                                       @success="onCreatedData($event)"></UpdateNhomTieuChi>
                                    <XemChiTietNhomTieuChi :item="v_data_info" :show="v_show_info"
                                                           @close="v_show_info = false"></XemChiTietNhomTieuChi>
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

    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import ThemMoiNhomTieuChi from './ThemMoiNhomTieuChi';
    import UpdateNhomTieuChi from './UpdateNhomTieuChi';
    import utils from '../../utils';
    import api from '../api';
    import XemChiTietNhomTieuChi from './XemChiTietNhomTieuChi';
    import Page from '../ui/PagingCustom';

    export default {
        name: "BaoCaoNhomTieuChi",

        components: {
            "ThemMoiNhomTieuChi": ThemMoiNhomTieuChi,
            "UpdateNhomTieuChi": UpdateNhomTieuChi,
            "XemChiTietNhomTieuChi": XemChiTietNhomTieuChi,
            "Page": Page
        },

        data() {

            return {
                v_ten_nhom_tieu_chi: '',
                v_cap_nhom: -1,
                v_ds_nhom_tieu_chi: [],
                v_trang_thai: -1,
                v_show_child: false,
                v_show_create: false,
                v_show_update: false,
                v_show_info: false,
                total_rows: 0,
                start: 0,
                currentPage: 1,
                limit: 10,
                v_data_edit: {},
                v_data_info: {}
            }
        },

        mounted() {
            this.getData();
        },

        methods: {
            getTime(date) {
                return timeutils.convertTime(new Date(date));
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            getData() {
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "tenNhomTieuChi": this.v_ten_nhom_tieu_chi,
                    "trangThai": this.v_trang_thai == -1 ? null : this.v_trang_thai,
                    "capNhom": this.v_cap_nhom == -1 ? null : this.v_cap_nhom
                };
                rest_api.post("/csdlgd-admin/bcdNhomTieuChi/search", params, (data) => {
                    console.log("---" + JSON.stringify(data));
                    if (array_util.isArray(data.data.tableData)) {
                        this.total_rows = data.data.totalRows;
                        array_util.clearArrays(this.v_ds_nhom_tieu_chi);
                        // this.v_ds_nhom_tieu_chi = data.data.tableData;
                        // console.log("---" + JSON.stringify(data));
                        for (let i = 0; i < data.data.tableData.length; i++) {
                            let obj = data.data.tableData[i];
                            obj.open = false;
                            this.v_ds_nhom_tieu_chi.push(obj);
                        }
                    }
                });
            },

            showCreate() {
                console.log("thêm mới Nhóm tiêu chí");
                this.v_show_create = true;
            },
            showInfo(tt) {
                this.v_show_info = true;
                this.v_data_info = tt;
            },
            showUpdate(tt) {
                // console.log(tt);
                this.v_data_edit = tt;
                this.v_show_update = true;
            },
            onCreatedData(e) {
                this.getData();
            },
            getTrangThaiStr(status) {
                if (status.trangThai === true || status.trangThai === 0) {
                    return "Đang hoạt động";
                }
                return 'Ngưng hoạt động';
            },
            getTrangThaiInt(status) {
                if (status.trangThai === true || status.trangThai === 0) {
                    return 0;
                }
                return 1;
            },
            click(ntc) {
                ntc.open = !ntc.open;
            },
            reset() {
                this.v_ten_nhom_tieu_chi = "";
                this.v_nhom_tieu_chi_cha_id = -1;
                this.v_cap_nhom = 0;
                this.v_trang_thai = 0;
                this.v_ds_nhom_tieu_chi = [];
            },
            close() {
                console.log("close modal");
                // this.reset();
                this.$emit('close');
            },
            method_lock(ntc) {
                console.log("Khóa nhóm tiêu chí");
                if (ntc.nhomTieuChiId === '' || ntc.nhomTieuChiId === null) {
                    utils.showDialog("Thông báo", "Vui lòng nhập Id nhóm tiêu chí");
                    return;
                }
                utils.confirmDialog("Xác nhận Khóa nhóm tiêu chí", "Khóa", () => {
                    const uri = "/csdlgd-admin/bcdNhomTieuChi/action";
                    const params = {
                        "id" : ntc.nhomTieuChiId,
                        "type": 1
                    };
                    console.log(params);
                    rest_api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.rc === 0) {
                            utils.showDialog("Thông báo", "Khóa nhóm tiêu chí thành công", null, () => {
                                this.$emit('success', params);
                                // this.reset();
                                this.close();
                                this.getData();
                            });
                        } else {
                            utils.showDialog("Thất bại", response.data.message, null, () => {
                            });
                        }
                    });
                })
            },
            method_unlock(ntc) {
                console.log("Mở Khóa nhóm tiêu chí");
                if (ntc.nhomTieuChiId === '' || ntc.nhomTieuChiId === null) {
                    utils.showDialog("Thông báo", "Vui lòng nhập Id nhóm tiêu chí");
                    return;
                }
                utils.confirmDialog("Xác nhận Mở Khóa nhóm tiêu chí", "Khóa", () => {
                    const uri = "/csdlgd-admin/bcdNhomTieuChi/action";
                    const params = {
                        "id" : ntc.nhomTieuChiId,
                        "type": 0
                    };
                    console.log(params);
                    rest_api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.rc === 0) {
                            utils.showDialog("Thông báo", " Mở Khóa nhóm tiêu chí thành công", null, () => {
                                this.$emit('success', params);
                                // this.reset();
                                this.close();
                                this.getData();
                            });
                        } else {
                            utils.showDialog("Thất bại", response.data.message, null, () => {
                            });
                        }
                    });
                })
            },
        }

    }
</script>

<style scoped>
    .search-style {
        padding-left: 20px;
    }

    .fa-arrow-up {
        padding-right: 10px;
    }

    .fa-arrow-down {
        padding-right: 10px;
    }

    .child-style {
        padding-left: 50px;
    }
</style>

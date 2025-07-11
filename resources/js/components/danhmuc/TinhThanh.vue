<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span
                class="kytu"> &raquo;</span> tỉnh thành</span>
            </div>
        </div>
        <form role="form" class="form-inline">
            <div class="row">
                <div class="col-sm-3">
                    <label>Tên tỉnh thành:</label>
                    <input v-model="ten_tinh_thanh" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-sm-2">
                    <label>Mã tỉnh thành:</label>
                    <input v-model="ma_tinh_thanh" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-sm-2">
                    <label>Trạng thái:</label>
                    <select class="form-control" v-model="trang_thai">
                        <option value=''>Tất cả</option>
                        <option value='1'>Đang hoạt động</option>
                        <option value='0'>Ngưng hoạt động</option>
                    </select>
                </div>
                <div>
                    <label style="display: block;color:transparent;" for="">Tìm kiếm</label>
                    <el-button size="mini" type="success" class="btn btn-success text-left" v-on:click.prevent="getData()">
                        Tìm kiếm
                    </el-button>
                </div>
            </div>
        </form>
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Danh sách tỉnh thành</label>
                                <el-button type="primary" size="mini" style="margin-left:5px" class="pull-right"
                                           v-on:click.prevent="showCreat()">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </el-button>
                                <el-button type="success" size="mini" class="pull-right"
                                           v-on:click.prevent="showImport()">
                                    <i class="fas fa-upload"></i> Import
                                </el-button>
                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th><p>STT</p></th>
                                            <th><p>Mã tỉnh thành</p></th>
                                            <th><p>Tên tỉnh thành</p></th>
                                            <th><p>Ngày cập nhật</p></th>
                                            <th><p>Trạng thái</p></th>
                                            <th><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_tinh_thanh.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(tt,index) in ds_tinh_thanh">
                                            <td class="text-center"><p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                            </td>
                                            <td class="text-center"><p>{{ tt.maTinhThanh }}</p></td>
                                            <td><p>{{ tt.tenTinhThanh }}</p></td>
                                            <td class="text-center"><p>{{ getTime(tt.ngayCapNhat) }}</p></td>
                                            <td class="text-center"><p>
                                                {{
                                                    parseInt(tt.trangThai) === 1 ? 'Đang hoạt động' : 'Ngưng hoạt động'
                                                }}</p>
                                            </td>
                                            <td class="text-center">
                                                <el-button type="warning" icon="el-icon-edit"
                                                           @click.prevent="showUpdate(tt)" size="mini"></el-button>
                                                <el-button type="danger" icon="el-icon-delete"
                                                           @click.prevent="deleteUnit(tt)" size="mini"></el-button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiTinhThanh :show="show_create" @close="show_create=false"
                                                      @success="onCreatedData($event)"></ThemMoiTinhThanh>
                                    <ChinhSuaTinhThanh :show="show_update" :item="dataEditTinhThanh"
                                                       @close="show_update=false"
                                                       @success="onUpdatedData($event)"></ChinhSuaTinhThanh>
                                    <ImportTinhThanh :show="show_import"
                                                     :info="thongTinImport"
                                                     @close="show_import=false"
                                                     @success="onCreatedData($event)"></ImportTinhThanh>
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
import timeutils from '../../utils/time_utils';
import Page from '../ui/PagingCustom';
import ThemMoi from '../danhmuc/ThemTinhThanh';
import ChinhSua from '../danhmuc/ChinhSuaTinhThanh';
import Import from './pupupImportExcel/importChung.vue';
import dialog from '../../utils/dialog';
import api from './../api';
import ElementUI from 'element-ui';

Vue.use(ElementUI);
export default {
    components: {
        "Page": Page,
        "ThemMoiTinhThanh": ThemMoi,
        "ChinhSuaTinhThanh": ChinhSua,
        "ImportTinhThanh": Import,
    },
    computed: {},
    data() {
        return {
            thongTinImport: {
                title: 'Nhập tỉnh thành',
                pathImport: '/api-import-tinh-thanh',
                pathTemplate: '/templateImport/Template_Tinh_Thanh.xlsx'
            },
            ma_tinh_thanh: '',
            show_create: false,
            show_update: false,
            show_import: false,
            trang_thai: '',
            total_rows: 0,
            ten_tinh_thanh: '',
            ds_tinh_thanh: [],
            start: 0,
            currentPage: 1,
            limit: 25,
            dataEditTinhThanh: {},
        }
    },
    mounted() {
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
        getTime(date) {
            return timeutils.convertTime(new Date(date));
        },
        getData() {
            let params = {
                "start": this.start,
                "limit": this.limit,
                "ma": this.ma_tinh_thanh,
                "ten": this.ten_tinh_thanh,
                "trangthai": this.trang_thai,
            };
            rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                if (array_util.isArray(data.data.rows)) {
                    this.total_rows = data.data.total;
                    // console.log("số hàng: " + this.total_rows);
                    array_util.clearArrays(this.ds_tinh_thanh);
                    this.ds_tinh_thanh = data.data.rows;
                    // console.log(JSON.stringify(data));
                }
            }, 10000, true);
        },
        showCreat() {
            console.log("thêm mới tỉnh thành");
            this.show_create = true;
        },
        showImport() {
            console.log("Import file từ excel");
            this.show_import = true;
        },
        showUpdate(tt) {
            console.log(tt);
            this.dataEditTinhThanh = tt;
            this.show_update = true;
        },
        onUpdatedData(e) {
            this.getData();
        },
        onCreatedData(e) {
            this.getData();
        },
        deleteUnit(e) {
            console.log("xóa lý do bỏ học" + JSON.stringify(e));
            dialog.confirmDialog("Bạn có muốn xóa tỉnh thành này?", "Đồng ý", () => {
                console.log("đồng ý xóa");
                const uri = "/api_xoa_tinh_thanh";
                let params = {
                    id: e.maTinhThanh,
                };
                api.post(uri, params, (response) => {
                    console.log("xóa:" + JSON.stringify(response));
                    if (response.data.code === 200) {
                        showDialog("Thông báo", "Xóa  thành công", null, () => {
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
    }
}
</script>
<style scoped>
.form-control {
    width: 100%;
}

th {
    text-align: center;
}

p {
    font-size: 14px;
}
</style>

<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span
                class="kytu"> &raquo;</span> Tôn giáo</span>
            </div>
        </div>
        <form role="form" class="form-inline">
            <div class="row">
                <div class="col-sm-2">
                    <label>Tên tôn giáo:</label>
                    <input v-model="ten_ton_giao" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-sm-2">
                    <label>Mã tôn giáo:</label>
                    <input v-model="ma_ton_giao" class="form-control" placeholder="Nhập..."></div>
                <div class="col-sm-2">
                    <label>Trạng thái:</label>
                    <select class="form-control" v-model="trang_thai">
                        <option value=''>Tất cả</option>
                        <option value='1'>Đang hoạt động</option>
                        <option value='0'>Ngưng hoạt động</option>
                    </select>
                </div>
                <div class="col-sm-2" style="padding-top:25px;">
<!--                    <button class="btn btn-success" v-on:click.prevent="getData()"><i class="fa fa-search"></i>Tìm kiếm-->
<!--                    </button>-->
                    <el-button size="mini" type="success" v-on:click.prevent="getData()">Tìm kiếm</el-button>
                </div>
            </div>
        </form>
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Danh sách tôn giáo</label>
<!--                                <button class="btn btn-success pull-right" v-on:click.prevent="showCreat()">-->
<!--                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới-->
<!--                                </button>-->
<!--                                <button style="margin:0 5px;" class="btn btn-primary pull-right"-->
<!--                                        v-on:click.prevent="showImport()">-->
<!--                                    <i class="fas fa-upload"></i> Import-->
<!--                                </button>-->
                            </div>
                            <div class="col-sm-6 text-right">
                                <el-button size="mini" type="success" @click.prevent="showImport()">Import</el-button>
                                <el-button size="mini" type="primary" @click.prevent="showCreat()">Thêm mới</el-button>
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
                                            <th><p>Mã tôn giáo</p></th>
                                            <th><p>Tên tôn giáo</p></th>
                                            <th><p>Ngày cập nhật</p></th>
                                            <th><p>Trạng thái</p></th>
                                            <th><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_ton_giao.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(tg,index) in ds_ton_giao">
                                            <td class="text-center"><p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                            </td>
                                            <td class="text-center"><p>{{ tg.maTonGiao }}</p></td>
                                            <td><p>{{ tg.tenTonGiao }}</p></td>
                                            <td class="text-center"><p>{{ getTime(tg.ngayCapNhat) }}</p></td>
                                            <td class="text-center"><p>
                                                {{ parseInt(tg.trangThai) === 1 ? 'Đang hoạt động' : 'Ngưng hoạt động' }}</p>
                                            </td>
                                            <td class="text-center">
<!--                                                <a title="Chỉnh sửa" v-on:click="showUpdate(tg)"><i-->
<!--                                                    class="far fa-edit"></i></a>-->
<!--                                                <a title="Xóa" v-on:click.prevent="deleteUnit(tg)"><i-->
<!--                                                    class="fas fa-trash-alt"></i></a>-->
                                                <el-button type="warning" icon="el-icon-edit"
                                                           @click.prevent="showUpdate(tg)" size="mini"></el-button>
                                                <el-button type="danger" icon="el-icon-delete"
                                                           @click.prevent="deleteUnit(tg)" size="mini"></el-button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiTonGiao :show="show_create" @close="show_create=false"
                                                    @success="onCreatedData($event)"></ThemMoiTonGiao>
                                    <ChinhSuaTonGiao :show="show_update" :item="dataEditTonGiao"
                                                     @close="show_update=false"
                                                     @success="onCreatedData($event)"></ChinhSuaTonGiao>
                                    <ImportTonGiao :show="show_import"
                                                   :info="thongTinImport"
                                                   @close="show_import=false"
                                                   @success="onCreatedData($event)"></ImportTonGiao>
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
import ThemMoi from './ThemTonGiao';
import ChinhSua from './ChinhSuaTonGiao';
import Import from './pupupImportExcel/importChung.vue';
import dialog from '../../utils/dialog';
import api from './../api';
import ElementUI from 'element-ui';
Vue.use(ElementUI);
export default {
    components: {
        "Page": Page,
        "ThemMoiTonGiao": ThemMoi,
        "ChinhSuaTonGiao": ChinhSua,
        "ImportTonGiao": Import,
    },
    computed: {},
    data() {
        return {
            thongTinImport: {
                title: 'Nhập tôn giáo',
                pathImport: '/api-import-ton-giao',
                pathTemplate: '/templateImport/Template_Ton_Giao.xlsx'
            },
            ten_ton_giao: '',
            show_create: false,
            show_update: false,
            show_import: false,
            trang_thai: '',
            total_rows: 0,
            ma_ton_giao: '',
            ds_ton_giao: [],
            start: 0,
            currentPage: 1,
            limit: 25,
            dataEditTonGiao: {},
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
                "ma": this.ma_ton_giao,
                "ten": this.ten_ton_giao,
                "trangthai": this.trang_thai,
            };
            rest_api.get("/internal-api/dmTonGiao/filter", params, (data) => {
                if (array_util.isArray(data.data.rows)) {
                    this.total_rows = data.data.total;
                    array_util.clearArrays(this.ds_ton_giao);
                    this.ds_ton_giao = data.data.rows;
                    console.log("---" + JSON.stringify(data));
                }
            });
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
            this.dataEditTonGiao = tt;
            this.show_update = true;
        },
        onCreatedData(e) {
            this.getData();
        },
        deleteUnit(e) {
            console.log("xóa lý do bỏ học" + JSON.stringify(e));
            dialog.confirmDialog("Bạn có muốn xóa tôn giáo này?", "Đồng ý", () => {
                console.log("đồng ý xóa");
                const uri = "/api_xoa_ton_giao";
                let params = {
                    id: e.maTonGiao,
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

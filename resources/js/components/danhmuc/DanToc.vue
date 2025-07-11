<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span
                class="kytu"> &raquo;</span> dân tộc</span>
            </div>
        </div>
        <form role="form" class="form-inline">
            <div class="row">
                <div class="col-sm-2">
                    <label>Tên dân tộc:</label>
                    <input v-model="ten_dan_toc" class="form-control" placeholder="Nhập..."/>
                </div>
                <div class="col-sm-2">
                    <label>Mã dân tộc:</label>
                    <input v-model="ma_dan_toc" class="form-control" placeholder="Nhập..."/>
                </div>
                <div class="col-sm-2">
                    <label>Loại dân tộc:</label>
                    <select class="form-control" v-model="loai_dan_toc">
                        <option value>Tất cả</option>
                        <option value="1">Thiểu số</option>
                        <option value="2">Đa số</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Trạng thái:</label>
                    <select class="form-control" v-model="trang_thai">
                        <option value>Tất cả</option>
                        <option value="1">Đang hoạt động</option>
                        <option value="0">Ngưng hoạt động</option>
                    </select>
                </div>
                <div class="col-sm-2">

                    <div class="text-left" style="padding-top: 25px;">
<!--                        <button class="btn btn-success" v-on:click.prevent="getData()">-->
<!--                            <i class="fa fa-search"></i>Tìm kiếm-->
<!--                        </button>-->
                        <el-button size="mini" type="success" v-on:click.prevent="getData()">Tìm kiếm</el-button>
                    </div>
                </div>
            </div>
        </form>

        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Danh sách dân tộc</label>
<!--                                <button class="btn btn-success pull-right" v-on:click.prevent="showCreat()">-->
<!--                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới-->
<!--                                </button>-->
<!--                                <button-->
<!--                                    style="margin:0 5px;"-->
<!--                                    class="btn btn-primary pull-right"-->
<!--                                    v-on:click.prevent="showImport()"-->
<!--                                >-->
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
                                            <th class="text-center"><p>STT</p></th>
                                            <th class="text-center"><p>Mã dân tộc</p></th>
                                            <th class="text-center"><p>Tên dân tộc</p></th>
                                            <th class="text-center"><p>Loại dân tộc</p></th>
                                            <th class="text-center"><p>Ngày cập nhật</p></th>
                                            <th class="text-center"><p>Trạng thái</p></th>
                                            <th class="text-center"><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_dan_toc.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(tt,index) in ds_dan_toc">
                                            <td class="text-center"><p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                            </td>
                                            <td class="text-center"><p>{{ tt.maDanToc }}</p></td>
                                            <td><p>{{ tt.tenDanToc }}</p></td>
                                            <td><p>{{ parseInt(tt.loaiDanToc) === 1 ? 'Thiểu số' : 'Đa số' }}</p></td>
                                            <td class="text-center"><p>{{ getTime(tt.ngayCapNhat) }}</p></td>
                                            <td><p>
                                                {{ parseInt(tt.trangThai) === 1 ? 'Đang hoạt động' : 'Ngưng hoạt động' }}</p>
                                            </td>
                                            <td class="text-center">
<!--                                                <a title="Chỉnh sửa" v-on:click="showUpdate(tt)">-->
<!--                                                    <i class="far fa-edit"></i>-->
<!--                                                </a>-->
<!--                                                <a title="Xóa" v-on:click.prevent="deleteUnit(tt)">-->
<!--                                                    <i class="fas fa-trash-alt"></i>-->
<!--                                                </a>-->
                                                <el-button type="warning" icon="el-icon-edit"
                                                           @click.prevent="showUpdate(tt)" size="mini"></el-button>
                                                <el-button type="danger" icon="el-icon-delete"
                                                           @click.prevent="deleteUnit(tt)" size="mini"></el-button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiDanToc
                                        :show="show_create"
                                        @close="show_create=false"
                                        @success="onCreatedData($event)"
                                    ></ThemMoiDanToc>
                                    <ChinhSuaDanToc
                                        :show="show_update"
                                        :item="dataEditTinhThanh"
                                        @close="show_update=false"
                                        @success="onCreatedData($event)"
                                    ></ChinhSuaDanToc>
                                    <ImportDanToc
                                        :info="thongTinImport"
                                        :show="show_import"
                                        @close="show_import=false"
                                        @success="onCreatedData($event)"
                                    ></ImportDanToc>
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
import Page from "../ui/PagingCustom";
import ThemMoi from "./ThemDanToc";
import ChinhSua from "./ChinhSuaDanToc";
import Import from "./pupupImportExcel/importChung.vue";
import dialog from "../../utils/dialog";
import api from "./../api";
import ElementUI from 'element-ui';
Vue.use(ElementUI);

export default {
    components: {
        Page: Page,
        ThemMoiDanToc: ThemMoi,
        ChinhSuaDanToc: ChinhSua,
        ImportDanToc: Import
    },

    computed: {},

    data() {
        return {
            thongTinImport: {
                title: 'Nhập dân tộc',
                pathImport: '/api-import-dan-toc',
                pathTemplate: '/templateImport/Template_Dan_Toc.xlsx'
            },
            ten_dan_toc: "",
            show_create: false,
            show_update: false,
            show_import: false,
            trang_thai: "",
            total_rows: 0,
            ma_dan_toc: "",
            ds_dan_toc: [],
            start: 0,
            currentPage: 1,
            limit: 25,
            dataEditTinhThanh: {},
            loai_dan_toc: ""
        };
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
            this.getData();
        },

        getTime(date) {
            return timeutils.convertTime(new Date(date));
        },

        getData() {
            let params = {
                start: this.start,
                limit: this.limit,
                ma: this.ma_dan_toc,
                ten: this.ten_dan_toc,
                trangthai: this.trang_thai,
                loai: this.loai_dan_toc
            };
            rest_api.get("/internal-api/dmDanToc/filter", params, data => {
                if (array_util.isArray(data.data.rows)) {
                    this.total_rows = data.data.total;
                    array_util.clearArrays(this.ds_dan_toc);
                    this.ds_dan_toc = data.data.rows;
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
            this.dataEditTinhThanh = tt;
            this.show_update = true;
        },
        onCreatedData(e) {
            this.getData();
        },
        deleteUnit(e) {
            console.log("xóa lý do bỏ học" + JSON.stringify(e));
            dialog.confirmDialog("Bạn có muốn xóa dân tộc này?", "Đồng ý", () => {
                console.log("đồng ý xóa");
                const uri = "/api_xoa_dan_toc";
                let params = {
                    id: e.maDanToc
                };
                api.post(uri, params, response => {
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
};
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

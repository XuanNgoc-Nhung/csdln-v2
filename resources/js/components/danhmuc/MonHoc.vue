<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span
                class="kytu"> &raquo;</span> Môn học</span>
            </div>
        </div>
        <form role="form" class="form-inline">
            <div class="row">
                <div class="col-sm-2">
                    <label>Tên môn học:</label>
                    <input v-model="ten_mon_hoc" class="form-control" placeholder="Nhập..."/>
                </div>
                <div class="col-sm-2">
                    <label>Mã môn học:</label>
                    <input v-model="ma_mon_hoc" class="form-control" placeholder="Nhập..."/>
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
                    <label>Cấp học:</label>
                    <select class="form-control" v-model="cap_hoc">
                        <option value>Tất cả</option>
                        <option value="1">Cấp 1</option>
                        <option value="2">Cấp 2</option>
                        <option value="3">Cấp 3</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <div class="text-left" style="padding-top:24px;">
                        <el-button size="mini" type="success" v-on:click.prevent="getData()"> Tìm kiếm
                        </el-button>
                    </div>
                </div>
            </div>
        </form>

        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label>Danh sách môn học</label>
                                <el-button style="margin-left: 5px" size="mini" type="primary" class="pull-right" v-on:click.prevent="showCreat()">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </el-button>
                                <el-button
                                    size="mini"
                                    type="success"
                                    class=" pull-right"
                                    v-on:click.prevent="showImport()"
                                >
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
                                            <th class="text-center"><p>STT</p></th>
                                            <th class="text-center"><p>Mã môn học</p></th>
                                            <th class="text-center"><p>Tên môn học</p></th>
                                            <th class="text-center"><p>Ngoại ngữ</p></th>
                                            <th class="text-center"><p>Tiếng dân tộc</p></th>
                                            <th class="text-center"><p>Trạng thái</p></th>
                                            <th class="text-center"><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_mon_hoc.length===0">
                                        <tr>
                                            <td class="text-center" colspan="15"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(item,index) in ds_mon_hoc">
                                            <td class="text-center"><p>{{ (currentPage - 1) * 10 + index + 1 }}</p></td>
                                            <td><p>{{ item.maMonHoc }}</p></td>
                                            <td><p>{{ item.tenMonHoc }}</p></td>
                                            <td class="text-center">
                                                <div v-if="item.ngoaiNgu==1">
                            <span style="color: blue">
                              <i class="fas fa-check"></i>
                            </span>
                                                </div>
                                                <div v-else>
                            <span style="color: #DC0101">
                              <i class="fas fa-times"></i>
                            </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div v-if="item.tiengDanToc==1">
                            <span style="color: blue">
                              <i class="fas fa-check"></i>
                            </span>
                                                </div>
                                                <div v-else>
                            <span style="color: #DC0101">
                              <i class="fas fa-times"></i>
                            </span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <p v-if="item.trangThai==1">
                                                    <span style="color:blue; font-weight: 700">Đang hoạt động</span>
                                                </p>
                                                <p v-else>
                            <span
                                class="active"
                                style=" color:#DC0101 ;font-weight: 700;">Ngừng hoạt động</span>
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <el-button type="warning" icon="el-icon-edit"
                                                           @click.prevent="showUpdate(item)" size="mini"></el-button>
                                                <el-button type="danger" icon="el-icon-delete"
                                                           @click.prevent="deleteUnit(item)" size="mini"></el-button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiMonHoc
                                        :show="show_create"
                                        @close="show_create=false"
                                        @success="onCreatedData($event)"
                                    ></ThemMoiMonHoc>
                                    <ChinhSuaMonHoc
                                        :show="show_update"
                                        :item="dataEditMonHoc"
                                        @close="show_update=false"
                                        @success="onCreatedData($event)"
                                    ></ChinhSuaMonHoc>
                                    <ImportMonHoc
                                        :show="show_import"
                                        :info="thongTinImport"
                                        @close="show_import=false"
                                        @success="onCreatedData($event)"
                                    ></ImportMonHoc>
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
import ThemMoi from "./ThemMonHoc";
import Import from "./pupupImportExcel/importChung.vue";
import ChinhSua from "./ChinhSuaMonHoc";
import dialog from "../../utils/dialog";
import api from "./../api";
import ElementUI from 'element-ui';
Vue.use(ElementUI);

export default {
    components: {
        Page: Page,
        ThemMoiMonHoc: ThemMoi,
        ChinhSuaMonHoc: ChinhSua,
        ImportMonHoc: Import
    },

    computed: {},

    data() {
        return {
            thongTinImport: {
                title: 'Nhập môn học',
                pathImport: '/api-import-mon-hoc',
                pathTemplate: '/templateImport/Template_Mon_Hoc.xlsx'
            },
            ten_mon_hoc: "",
            show_create: false,
            show_update: false,
            show_import: false,
            trang_thai: "",
            total_rows: 0,
            ma_mon_hoc: "",
            ds_mon_hoc: [],
            start: 0,
            currentPage: 1,
            limit: 25,
            dataEditMonHoc: {},
            cap_hoc: ""
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
                ma: this.ma_mon_hoc,
                ten: this.ten_mon_hoc,
                trangThai: this.trang_thai,
                capHoc: this.cap_hoc
            };
            rest_api.get("/internal-api/dmMonHoc/filter", params, data => {
                if (array_util.isArray(data.data.rows)) {
                    this.total_rows = data.data.total;
                    array_util.clearArrays(this.ds_mon_hoc);
                    this.ds_mon_hoc = data.data.rows;
                    console.log("---" + JSON.stringify(data));
                }
            });
        },
        showCreat() {
            console.log("thêm mới tỉnh thành");
            this.show_create = true;
        },
        showUpdate(tt) {
            console.log(tt);
            this.dataEditMonHoc = tt;
            this.show_update = true;
        },
        onCreatedData(e) {
            this.getData();
        },
        deleteUnit(e) {
            console.log("xóa lý do bỏ học" + JSON.stringify(e));
            dialog.confirmDialog("Bạn có muốn xóa môn học này?", "Đồng ý", () => {
                console.log("đồng ý xóa");
                const uri = "/api_xoa_mon_hoc";
                let params = {
                    id: e.maMonHoc
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
        },

        showImport() {
            console.log("Import file từ excel");
            this.show_import = true;
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

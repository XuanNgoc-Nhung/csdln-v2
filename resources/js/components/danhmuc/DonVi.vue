<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span
                class="kytu"> &raquo;</span> Đơn vị</span>
            </div>
        </div>
        <form role="form" class="form-inline">
            <div class="row">
                <div class="col-sm-3">
                    <label>Tên đơn vị:</label>
                    <input v-model="ten_don_vi" class="form-control" placeholder="Nhập..."/>
                </div>
                <div class="col-sm-3">
                    <label>Mã đơn vị:</label>
                    <input v-model="ma_don_vi" class="form-control" placeholder="Nhập..."/>
                </div>
                <div class="col-sm-3">
                    <label>Trạng thái:</label>
                    <select class="form-control" v-model="trang_thai">
                        <option value>Tất cả</option>
                        <option value="1">Đang hoạt động</option>
                        <option value="0">Ngưng hoạt động</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <el-button type="success" size="mini" style="margin-top:24px;" v-on:click.prevent="getData()">Tìm
                        kiếm
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
                                <label>Danh sách đơn vị</label>
                                <el-button size="mini" type="primary" class="pull-right"
                                           style="margin-left: 5px"
                                           v-on:click.prevent="showCreat()">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </el-button>
                                <el-button
                                    size="mini"
                                    type="success"
                                    class="pull-right"
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
                                            <th><p>STT</p></th>
                                            <th><p>Mã đơn vị</p></th>
                                            <th><p>Tên đơn vị</p></th>
                                            <th><p>Ngày cập nhật</p></th>
                                            <th><p>Trạng thái</p></th>
                                            <th><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_don_vi.length===0">
                                        <tr>
                                            <td class="text-center" colspan="15"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(item,index) in ds_don_vi">
                                            <td class="text-center"><p>{{ (currentPage - 1) * 10 + index + 1 }}</p></td>
                                            <td class="text-center"><p>{{ item.maDonVi }}</p></td>
                                            <td><p>{{ item.tenDonVi }}</p></td>
                                            <td class="text-center"><p>{{ getTime(item.ngayCapNhat) }}</p></td>
                                            <td class="text-center">
                                                <p v-if="item.trangThai==1">
                                                    <span style="color:blue; font-weight: 700">Đang hoạt động</span>
                                                </p>
                                                <p v-else>
                            <span
                                class="active"
                                style=" color:#DC0101 ;font-weight: 700;"
                            >Ngừng hoạt động</span>
                                                </p>
                                            </td>
                                            <td class="text-center">
                                                <el-button type="warning" icon="el-icon-edit"
                                                           @click.prevent="showUpdate(item)" size="mini"></el-button>
                                                <el-button type="danger" icon="el-icon-delete"
                                                           @click.prevent="deleteData(item)" size="mini"></el-button>
                                                <!--                          <a title="Chỉnh sửa" v-on:click="showUpdate(item)">-->
                                                <!--                            <i class="far fa-edit"></i>-->
                                                <!--                          </a>-->
                                                <!--                          <a title="Xóa" v-on:click.prevent="deleteData(item)">-->
                                                <!--                            <i class="fas fa-trash-alt"></i>-->
                                                <!--                          </a>-->
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiDonVi
                                        :show="show_create"
                                        @close="show_create=false"
                                        @success="onCreatedData($event)"
                                    ></ThemMoiDonVi>
                                    <ChinhSuaDonVi
                                        :show="show_update"
                                        :item="dataEditDonVi"
                                        @close="show_update=false"
                                        @success="onCreatedData($event)"
                                    ></ChinhSuaDonVi>
                                    <ImportDonVi
                                        :show="show_import"
                                        :info="thongTinImport"
                                        @close="show_import=false"
                                        @success="onCreatedData($event)"
                                    ></ImportDonVi>
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
import ThemMoi from "./ThemDonVi";
import ChinhSua from "./ChinhSuaDonVi";
import Import from "./pupupImportExcel/importChung.vue";
import dialog from "../../utils/dialog";
import api from "./../api";
import ElementUI from 'element-ui';

Vue.use(ElementUI);
export default {
    props: ["url"],
    components: {
        Page: Page,
        ThemMoiDonVi: ThemMoi,
        ChinhSuaDonVi: ChinhSua,
        ImportDonVi: Import
    },

    computed: {},

    data() {
        return {
            thongTinImport: {
                title: 'Nhập đơn vị',
                pathImport: '/api-import-don-vi',
                pathTemplate: '/templateImport/Template_Don_vi.xlsx'
            },
            ten_don_vi: "",
            show_create: false,
            show_update: false,
            trang_thai: "",
            total_rows: 0,
            ma_don_vi: "",
            ds_don_vi: [],
            start: 0,
            currentPage: 1,
            limit: 25,
            dataEditDonVi: {},
            show_import: false
        };
    },

    mounted() {
        console.log("url cha: " + this.url);
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
                ma: this.ma_don_vi,
                ten: this.ten_don_vi,
                trangthai: this.trang_thai
            };
            rest_api.get("/internal-api/dmDonVi/filter", params, data => {
                if (array_util.isArray(data.data.rows)) {
                    this.total_rows = data.data.total;
                    array_util.clearArrays(this.ds_don_vi);
                    this.ds_don_vi = data.data.rows;
                    console.log("---" + JSON.stringify(data));
                }
            });
        },
        showCreat() {
            console.log("thêm mới tỉnh thành");
            this.show_create = true;
        },
        showUpdate(ld) {
            this.dataEditDonVi = ld;
            console.log("sửa:" + JSON.stringify(this.dataEditDonVi));
            this.show_update = true;
        },
        onCreatedData(e) {
            this.getData();
        },
        deleteUnit() {
            console.log("xóa");
        },
        deleteUnit() {
            console.log("xóa");
        },
        deleteData(e) {
            dialog.confirmDialog("Bạn có muốn xóa đơn vị này?", "Đồng ý", () => {
                console.log("đồng ý xóa");
                const uri = "/api_xoa_don_vi";
                let params = {
                    id: e.maDonVi
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

p {
    font-size: 14px;
}

th {
    text-align: center;
}
</style>

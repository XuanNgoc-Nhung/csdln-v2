<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span
                class="kytu"> &raquo;</span>Lĩnh vực đánh giá phát triển</span>
            </div>
        </div>
        <form role="form">
            <div class="row">
                <div class="col-sm-2">
                    <label>Tên lĩnh vực:</label>
                    <input v-model="ten_linh_vuc" class="form-control" placeholder="Nhập..."/>
                </div>
                <div class="col-sm-2">
                    <label>Mã lĩnh vực:</label>
                    <input v-model="ma_linh_vuc" class="form-control" placeholder="Nhập..."/>
                </div>
                <div class="col-sm-2">
                    <label>Cấp học:</label>
                    <select class="form-control" v-model="cap_hoc">
                        <option value>Tất cả</option>
                        <option value="4">Nhà trẻ</option>
                        <option value="5">Mẫu giáo</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Nhóm tuổi:</label>
                    <select class="form-control" v-model="nhom_tuoi">
                        <option value>Tất cả</option>
                        <optgroup v-show="cap_hoc == 4" label="Nhà trẻ">
                            <option value="13">3 - 12 tháng</option>
                            <option value="14">13 - 24 tháng</option>
                            <option value="15">25 - 36 tháng</option>
                        </optgroup>
                        <optgroup v-show="cap_hoc == 5" label="Mẫu giáo">
                            <option value="16">3 - 4 tuổi</option>
                            <option value="17">4 - 5 tuổi</option>
                            <option value="18">5 - 6 tuổi</option>
                        </optgroup>
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
                <div class="col-sm-2" style="padding-top:25px;">
                    <div class="text-left">
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
                                <label>Danh sách lĩnh vực ĐG&PT</label>
                                <!--                <button class="btn btn-success pull-right" v-on:click.prevent="showCreat()">-->
                                <!--                  <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới-->
                                <!--                </button>-->
                                <!--                <button-->
                                <!--                  style="margin:0 5px;"-->
                                <!--                  class="btn btn-primary pull-right"-->
                                <!--                  v-on:click.prevent="showImport()"-->
                                <!--                >-->
                                <!--                  <i class="fas fa-upload"></i> Import-->
                                <!--                </button>-->
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
                                            <th class="text-center"><p>Mã lĩnh vực</p></th>
                                            <th class="text-center"><p>Tên lĩnh vực</p></th>
                                            <th class="text-center"><p>Cấp học</p></th>
                                            <th class="text-center"><p>Nhóm tuổi</p></th>
                                            <th class="text-center"><p>Trạng thái</p></th>
                                            <th class="text-center"><p>Ngày cập nhật</p></th>
                                            <th class="text-center"><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_linh_vuc.length===0">
                                        <tr>
                                            <td class="text-center" colspan="8"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(ld,index) in ds_linh_vuc">
                                            <td class="text-center"><p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                            </td>
                                            <td class="text-center"><p>{{ ld.maLinhVucDanhGiaSuPt }}</p></td>
                                            <td><p>{{ ld.tenLinhVucDanhGiaSuPt }}</p></td>
                                            <td>
                                                <p v-if="ld.capHoc==4">Nhà trẻ</p>
                                                <p v-if="ld.capHoc==5">Mẫu giáo</p>
                                            </td>
                                            <td>
                                                <p v-if="ld.khoiHoc==13">Từ 3-12 tháng</p>
                                                <p v-if="ld.khoiHoc==14">Từ 13-24 tháng</p>
                                                <p v-if="ld.khoiHoc==15">Từ 25-36 tháng</p>
                                                <p v-if="ld.khoiHoc==16">Từ 3-4 tuổi</p>
                                                <p v-if="ld.khoiHoc==17">Từ 4-5 tuổi</p>
                                                <p v-if="ld.khoiHoc==18">Từ 5-6 tuổi</p>
                                            </td>
                                            <td class="text-center"><p>
                                                {{ parseInt(ld.trangThai) === 1 ? 'Đang hoạt động' : 'Ngưng hoạt động' }}</p>
                                            </td>
                                            <td class="text-center"><p>{{ getTime(ld.ngayCapNhat) }}</p></td>
                                            <td class="text-center">
<!--                                                <a title="Chỉnh sửa" v-on:click="showUpdate(ld)">-->
<!--                                                    <i class="far fa-edit"></i>-->
<!--                                                </a>-->
<!--                                                <a title="Xóa" v-on:click.prevent="deleteUnit(ld)">-->
<!--                                                    <i class="fas fa-trash-alt"></i>-->
<!--                                                </a>-->

                                                <el-button type="warning" icon="el-icon-edit"
                                                           @click.prevent="showUpdate(ld)" size="mini"></el-button>
                                                <el-button type="danger" icon="el-icon-delete"
                                                           @click.prevent="deleteUnit(ld)" size="mini"></el-button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiLinhVuc
                                        :show="show_create"
                                        @close="show_create=false"
                                        @success="onCreatedData($event)"
                                    ></ThemMoiLinhVuc>
                                    <ChinhSuaLinhVuc
                                        :show="show_update"
                                        :item="dataEditLinhVuc"
                                        @close="show_update=false"
                                        @success="onCreatedData($event)"
                                    ></ChinhSuaLinhVuc>
                                    <ImportLinhVuc
                                        :info="thongTinImport"
                                        :show="show_import"
                                        @close="show_import=false"
                                        @success="onCreatedData($event)"
                                    ></ImportLinhVuc>
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
import ThemMoi from "./ThemLinhVucDanhGiaPhatTrien";
import ChinhSua from "./ChinhSuaLinhVucDanhGiaPhatTrien";
import Import from "./pupupImportExcel/importChung.vue";
import dialog from "../../utils/dialog";
import api from "./../api";
import ElementUI from 'element-ui';
Vue.use(ElementUI);
export default {
    components: {
        Page: Page,
        ThemMoiLinhVuc: ThemMoi,
        ChinhSuaLinhVuc: ChinhSua,
        ImportLinhVuc: Import
    },

    computed: {},

    data() {
        return {
            thongTinImport: {
                title: 'Nhập lĩnh vực đánh giá phát triển',
                pathImport: '/api-import-linh-vuc-danh-gia-phat-trien',
                pathTemplate: '/templateImport/Template_Linh_Vuc_Danh_Gia_Su_Phat_Trien.xlsx'
            },
            ten_linh_vuc: "",
            show_create: false,
            show_import: false,
            show_update: false,
            trang_thai: "",
            total_rows: 0,
            ma_linh_vuc: "",
            ds_linh_vuc: [],
            start: 0,
            currentPage: 1,
            limit: 25,
            dataEditLinhVuc: {},
            cap_hoc: "",
            nhom_tuoi: ""
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
                ma: this.ma_linh_vuc,
                ten: this.ten_linh_vuc,
                trangthai: this.trang_thai,
                caphoc: this.cap_hoc,
                khoihoc: this.nhom_tuoi
            };
            rest_api.get(
                "/internal-api/dmLinhVucDanhGiaSuPT/filter",
                params,
                data => {
                    if (array_util.isArray(data.data.rows)) {
                        this.total_rows = data.data.total;
                        array_util.clearArrays(this.ds_linh_vuc);
                        this.ds_linh_vuc = data.data.rows;
                        console.log("---" + JSON.stringify(data));
                    }
                }
            );
        },
        showCreat() {
            console.log("thêm mới tỉnh thành");
            this.show_create = true;
        },
        showImport() {
            console.log("Import file từ excel");
            this.show_import = true;
        },
        showUpdate(ld) {
            console.log(ld);
            this.dataEditLinhVuc = ld;
            this.show_update = true;
        },
        onCreatedData(e) {
            this.getData();
        },
        deleteUnit(e) {
            console.log("xóa lý do bỏ học" + JSON.stringify(e));
            dialog.confirmDialog(
                "Bạn có muốn xóa lĩnh vực đánh giá phát triển này?",
                "Đồng ý",
                () => {
                    console.log("đồng ý xóa");
                    const uri = "/api_xoa_linh_vuc_danh_gia_phat_trien";
                    let params = {
                        id: e.maLinhVucDanhGiaSuPt
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
                }
            );
        }
    }
};
</script>

<style scoped>
th {
    text-align: center;
}

p {
    font-size: 14px;
}
</style>

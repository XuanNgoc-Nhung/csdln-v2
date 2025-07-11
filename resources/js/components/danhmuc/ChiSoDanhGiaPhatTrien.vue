<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span
                class="kytu"> &raquo;</span> Chỉ số đánh giá và phát triển</span>
            </div>
        </div>
        <form role="form">
            <div class="row">
                <div class="col-sm-2">
                    <label>Mã chỉ số:</label>
                    <input v-model="ma_chi_so" class="form-control" placeholder="Nhập..."/>
                </div>
                <div class="col-sm-2">
                    <label>Tên chỉ số:</label>
                    <input v-model="ten_chi_so" class="form-control" placeholder="Nhập..."/>
                </div>
                <div class="col-sm-2">
                    <label>Cấp học:</label>
                    <select @change="onCapHocChange" class="form-control" v-model="cap_hoc">
                        <option value>Tất cả</option>
                        <option value="4">Nhà trẻ</option>
                        <option value="5">Mẫu giáo</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Nhóm tuổi:</label>
                    <select @change="onNhomTuoiChange" class="form-control" v-model="nhom_tuoi">
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
                    <label>Lĩnh vực ĐG&PT:</label>
                    <select class="form-control" v-model="linh_vuc">
                        <option value>Tất cả</option>
                        <option
                            v-for="lv in danh_sach_linh_vuc"
                            :value="lv.maLinhVucDanhGiaSuPt"
                        >{{ lv.tenLinhVucDanhGiaSuPt }}
                        </option>
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
            </div>
            <div class="text-center" style="padding-top: 10px;">
                <el-button size="mini" type="success" @click.prevent="getData()">Tìm kiếm</el-button>
                <!--        <button class="btn btn-success" v-on:click.prevent="getData()">-->
                <!--          <i class="fa fa-search"></i>Tìm kiếm-->
                <!--        </button>-->
            </div>
        </form>

        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Danh sách chỉ số Đánh giá và phát triển</label>
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
                                            <th class="text-center"><p>Mã chỉ số</p></th>
                                            <th class="text-center"><p>Tên chỉ số</p></th>
                                            <th class="text-center"><p>Cấp học</p></th>
                                            <th class="text-center"><p>Nhóm tuổi</p></th>
                                            <th class="text-center"><p>Lĩnh vực ĐG&PT</p></th>
                                            <th class="text-center"><p>Ngày cập nhật</p></th>
                                            <th class="text-center"><p>Trạng thái</p></th>
                                            <th class="text-center"><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_chi_so.length===0">
                                        <tr>
                                            <td class="text-center" colspan="9"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(ld,index) in ds_chi_so">
                                            <td class="text-center"><p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                            </td>
                                            <td class="text-center"><p>{{ ld.maChiSoDanhGiaSuPt }}</p></td>
                                            <td><p>{{ ld.tenChiSoDanhGiaSuPt }}</p></td>
                                            <td>
                                                <p v-if="ld.capHoc==1">Cấp 1</p>
                                                <p v-if="ld.capHoc==2">Cấp 2</p>
                                                <p v-if="ld.capHoc==3">Cấp 3</p>
                                                <p v-if="ld.capHoc==4">Nhà trẻ</p>
                                                <p v-if="ld.capHoc==5">Mẫu giáo</p>
                                            </td>
                                            <td>
                                                <p v-if="ld.khoiHoc==1">Lớp 1</p>
                                                <p v-if="ld.khoiHoc==2">Lớp 2</p>
                                                <p v-if="ld.khoiHoc==3">Lớp 3</p>
                                                <p v-if="ld.khoiHoc==4">Lớp 4</p>
                                                <p v-if="ld.khoiHoc==5">Lớp 5</p>
                                                <p v-if="ld.khoiHoc==6">Lớp 6</p>
                                                <p v-if="ld.khoiHoc==7">Lớp 7</p>
                                                <p v-if="ld.khoiHoc==8">Lớp 8</p>
                                                <p v-if="ld.khoiHoc==9">Lớp 9</p>
                                                <p v-if="ld.khoiHoc==10">Lớp 10</p>
                                                <p v-if="ld.khoiHoc==11">Lớp 11</p>
                                                <p v-if="ld.khoiHoc==12">Lớp 12</p>
                                                <p v-if="ld.khoiHoc==13">Từ 3-12 tháng</p>
                                                <p v-if="ld.khoiHoc==14">Từ 13-24 tháng</p>
                                                <p v-if="ld.khoiHoc==15">Từ 25-36 tháng</p>
                                                <p v-if="ld.khoiHoc==16">Từ 3-4 tuổi</p>
                                                <p v-if="ld.khoiHoc==17">Từ 4-5 tuổi</p>
                                                <p v-if="ld.khoiHoc==18">Từ 5-6 tuổi</p>
                                            </td>
                                            <td><p>{{ ld.tenLinhVucDanhGiaSuPhatTrien }}</p></td>
                                            <td class="text-center"><p>{{ getTime(ld.ngayCapNhat) }}</p></td>
                                            <td
                                                class="text-center"
                                            ><p>
                                                {{ parseInt(ld.trangThai) === 1 ? 'Đang hoạt động' : 'Ngưng hoạt động' }}</p>
                                            </td>
                                            <td class="text-center">

                                                <el-button type="warning" icon="el-icon-edit"
                                                           @click.prevent="showUpdate(ld)" size="mini"></el-button>
                                                <el-button type="danger" icon="el-icon-delete"
                                                           @click.prevent="deleteUnit(ld)" size="mini"></el-button>
                                                <!--                          <a title="Chỉnh sửa" v-on:click="showUpdate(ld)">-->
                                                <!--                            <i class="far fa-edit"></i>-->
                                                <!--                          </a>-->
                                                <!--                          <a title="Xóa" v-on:click.prevent="deleteUnit(ld)">-->
                                                <!--                            <i class="fas fa-trash-alt"></i>-->
                                                <!--                          </a>-->
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiChiSo
                                        :show="show_create"
                                        @close="show_create=false"
                                        @success="onCreatedData($event)"
                                    ></ThemMoiChiSo>
                                    <ChinhSuaChiSo
                                        :show="show_update"
                                        :item="dataEditChiSo"
                                        @close="show_update=false"
                                        @success="onCreatedData($event)"
                                    ></ChinhSuaChiSo>
                                    <ImportChiSo
                                        :info="thongTinImport"
                                        :show="show_import"
                                        @close="show_import=false"
                                        @success="onCreatedData($event)"
                                    ></ImportChiSo>
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
import ThemMoi from "./ThemChiSoDanhGiaPhatTrien";
import ChinhSua from "./ChinhSuaChiSoDanhGiaPhatTrien";
import Import from "./pupupImportExcel/importChung.vue";
import dialog from "../../utils/dialog";
import api from "./../api";
import ElementUI from 'element-ui';

Vue.use(ElementUI);

export default {
    components: {
        Page: Page,
        ThemMoiChiSo: ThemMoi,
        ChinhSuaChiSo: ChinhSua,
        ImportChiSo: Import
    },

    computed: {},

    data() {
        return {
            thongTinImport: {
                title: 'Nhập chỉ số đánh giá phát triển',
                pathImport: '/api-import-chi-so-danh-gia-phat-trien',
                pathTemplate: '/templateImport/Template_Chi_So_Danh_Gia_Su_Phat_Trien.xlsx'
            },
            ten_chi_so: "",
            show_create: false,
            show_update: false,
            show_import: false,
            trang_thai: "",
            total_rows: 0,
            ma_chi_so: "",
            ds_chi_so: [],
            start: 0,
            currentPage: 1,
            limit: 25,
            dataEditChiSo: {},
            cap_hoc: "",
            nhom_tuoi: "",
            danh_sach_linh_vuc: [],
            linh_vuc: ""
        };
    },

    mounted() {
        this.getData();
        this.getDanhSachLinhVuc();
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
        getDanhSachLinhVuc() {
            let params = {
                start: 0,
                limit: 1000,
                trangthai: 1,
                caphoc: this.cap_hoc,
                khoihoc: this.nhom_tuoi
            };
            rest_api.get(
                "/internal-api/dmLinhVucDanhGiaSuPT/filter",
                params,
                data => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.danh_sach_linh_vuc);
                        this.danh_sach_linh_vuc = data.data.rows;
                        console.log("ds linh vuc" + JSON.stringify(data));
                    }
                }
            );
        },
        getData() {
            let params = {
                start: this.start,
                limit: this.limit,
                ma: this.ma_chi_so,
                caphoc: this.cap_hoc,
                khoihoc: this.nhom_tuoi,
                malinhvuc: this.linh_vuc,
                ten: this.ten_chi_so,
                trangthai: this.trang_thai
            };
            rest_api.get("/internal-api/dmChiSoDanhGiaSuPT/filter", params, data => {
                if (data.data.statusResponse == 0) {
                    if (array_util.isArray(data.data.rows)) {
                        this.total_rows = data.data.total;
                        array_util.clearArrays(this.ds_chi_so);
                        this.ds_chi_so = data.data.rows;
                    }
                    // if (data.data.total == 0) {
                    //     showDialog("Thông báo", "Không có bản ghi nào được tìm thấy.", null, () => {
                    //         return;
                    //     });
                    // }
                } else {
                    showDialog("Thông báo", "Hệ thống đang bận. Vui lòng thử lại sau.", null, () => {
                        return;
                    });
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
        showUpdate(ld) {
            console.log(ld);
            this.dataEditChiSo = ld;
            this.show_update = true;
        },
        onCreatedData(e) {
            this.getData();
        },
        deleteUnit(e) {
            console.log("xóa lý do bỏ học" + JSON.stringify(e));
            dialog.confirmDialog("Bạn có muốn xóa chỉ số này?", "Đồng ý", () => {
                console.log("đồng ý xóa");
                const uri = "/api_xoa_chi_so_danh_gia_phat_trien";
                let params = {
                    id: e.maChiSoDanhGiaSuPt
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
        onCapHocChange() {
            this.nhom_tuoi = "";
            this.getDanhSachLinhVuc();
        },
        onNhomTuoiChange() {
            this.getDanhSachLinhVuc();
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

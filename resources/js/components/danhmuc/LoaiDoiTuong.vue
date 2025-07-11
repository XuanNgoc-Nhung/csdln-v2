<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span
                class="kytu"> &raquo;</span> loại đối tượng</span>
            </div>
        </div>
        <form role="form">
            <div class="row">
                <div class="col-sm-2">
                    <label>Tên loại đối tượng:</label>
                    <input v-model="ten_loai_doi_tuong" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-sm-2">
                    <label>Mã loại đối tượng:</label>
                    <input v-model="ma_loai_doi_tuong" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-sm-2">
                    <label>Tên bảng:</label>
                    <select class="form-control" v-model="ten_bang">
                        <option value=''>Tất cả</option>
                        <option value='1'>Giáo viên</option>
                        <option value='2'>Lớp học</option>
                        <option value='3'>Trường học</option>
                        <option value='4'>Học sinh</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Trạng thái:</label>
                    <select class="form-control" v-model="trang_thai">
                        <option value=''>Tất cả</option>
                        <option value='1'>Đang hoạt động</option>
                        <option value='0'>Ngưng hoạt động</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <div class="text-left" style="padding-top: 25px;">
<!--                        <button class="btn btn-success" v-on:click.prevent="getData()"><i class="fa fa-search"></i>Tìm-->
<!--                            kiếm-->
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
                                <label>Danh sách loại đối tượng</label>
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
                                            <th class="text-center"><p>STT</p></th>
                                            <th class="text-center"><p>Mã loại đối tượng</p></th>
                                            <th class="text-center"><p>Tên loại đối tượng</p></th>
                                            <th class="text-center"><p>Tên bảng</p></th>
                                            <th class="text-center"><p>Ngày cập nhật</p></th>
                                            <th class="text-center"><p>Trạng thái</p></th>
                                            <th class="text-center"><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_loai_doi_tuong.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(ld,index) in ds_loai_doi_tuong">
                                            <td class="text-center"><p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                            </td>
                                            <td class="text-center"><p>{{ ld.maLoaiDoiTuong }}</p></td>
                                            <td><p>{{ ld.tenLoaiDoiTuong }}</p></td>
                                            <td>
                                                <p>{{ getTenBang(ld.type) }}</p>
                                            </td>
                                            <td class="text-center"><p>{{ getTime(ld.ngayCapNhat) }}</p></td>
                                            <td class="text-center"><p>
                                                {{ parseInt(ld.trangThai) === 1 ? 'Đang hoạt động' : 'Ngưng hoạt động' }}</p>
                                            </td>
                                            <td class="text-center">
<!--                                                <a title="Chỉnh sửa" v-on:click="showUpdate(ld)"><i-->
<!--                                                    class="far fa-edit"></i></a>-->
<!--                                                <a title="Xóa" v-on:click.prevent="deleteUnit(ld)"><i-->
<!--                                                    class="fas fa-trash-alt"></i></a>-->

                                                <el-button type="warning" icon="el-icon-edit"
                                                           @click.prevent="showUpdate(ld)" size="mini"></el-button>
                                                <el-button type="danger" icon="el-icon-delete"
                                                           @click.prevent="deleteUnit(ld)" size="mini"></el-button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiLoaiDoiTuong :show="show_create" @close="show_create=false"
                                                         @success="onCreatedData($event)"></ThemMoiLoaiDoiTuong>
                                    <ChinhSuaLoaiDoiTuong :show="show_update" :item="dataEditLoaiDoiTuong"
                                                          @close="show_update=false"
                                                          @success="onCreatedData($event)"></ChinhSuaLoaiDoiTuong>
                                    <ImportLoaiDoiTuong :show="show_import"
                                                        :info="thongTinImport"
                                                        @close="show_import=false"
                                                        @success="onCreatedData($event)"></ImportLoaiDoiTuong>
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
import ThemMoi from './ThemLoaiDoiTuong';
import ChinhSua from './ChinhSuaLoaiDoiTuong';
import Import from './pupupImportExcel/importChung.vue';
import dialog from '../../utils/dialog';
import api from './../api';
import ElementUI from 'element-ui';
Vue.use(ElementUI);
export default {
    components: {
        "Page": Page,
        "ThemMoiLoaiDoiTuong": ThemMoi,
        "ChinhSuaLoaiDoiTuong": ChinhSua,
        "ImportLoaiDoiTuong": Import,
    },
    computed: {},
    data() {
        return {
            thongTinImport: {
                title: 'Nhập loại đối tượng',
                pathImport: '/api-import-loai-doi-tuong',
                pathTemplate: '/templateImport/Template_Loai_Doi_Tuong.xlsx'
            },
            ten_loai_doi_tuong: '',
            show_create: false,
            show_update: false,
            show_import: false,
            trang_thai: '',
            total_rows: 0,
            ma_loai_doi_tuong: '',
            ds_loai_doi_tuong: [],
            start: 0,
            currentPage: 1,
            limit: 25,
            dataEditLoaiDoiTuong: {},
            ten_bang: ''
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
                "ma": this.ma_loai_doi_tuong,
                "ten": this.ten_loai_doi_tuong,
                "trangthai": this.trang_thai,
                "type": this.ten_bang
            };
            rest_api.get("/internal-api/dmLoaiDoiTuong/filter", params, (data) => {
                if (array_util.isArray(data.data.rows)) {
                    this.total_rows = data.data.total;
                    array_util.clearArrays(this.ds_loai_doi_tuong);
                    this.ds_loai_doi_tuong = data.data.rows;
                    console.log("---" + JSON.stringify(data));
                }
            });
        },
        showImport() {
            console.log("Import file từ excel");
            this.show_import = true;
        },
        showCreat() {
            console.log("thêm mới tỉnh thành");
            this.show_create = true;
        },
        showUpdate(ld) {
            console.log(ld);
            this.dataEditLoaiDoiTuong = ld;
            this.show_update = true;
        },
        onCreatedData(e) {
            this.getData();
        },
        deleteUnit(e) {
            console.log("xóa lý do bỏ học" + JSON.stringify(e));
            dialog.confirmDialog("Bạn có muốn xóa loại đối tượng này?", "Đồng ý", () => {
                console.log("đồng ý xóa");
                const uri = "/api_xoa_loai_doi_tuong";
                let params = {
                    id: e.maLoaiDoiTuong,
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
        },
        getTenBang(type) {
            var res = '';
            if (type == 1) {
                res = 'Giáo viên';
            }
            if (type == 2) {
                res = 'Lớp học';
            }
            if (type == 3) {
                res = 'Trường học';
            }
            if (type == 4) {
                res = 'Học sinh';
            }
            return res;
        }
    }
}
</script>
<style scoped>
th {
    text-align: center;
}
p {
    font-size: 14px;
}
</style>

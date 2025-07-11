<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span
                class="kytu"> &raquo;</span> Chuẩn chiều cao, cân nặng</span>
            </div>
        </div>
        <form role="form">
            <div class="row">
                <div class="col-sm-2">
                    <label>Mã tiêu chuẩn:</label>
                    <input v-model="ma_tieu_chuan" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-sm-2">
                    <label>Loại tiêu chuẩn:</label>
                    <select class="form-control" v-model="loai_tieu_chuan">
                        <option value=''>Tất cả</option>
                        <option value='1'>Chiều cao bé trai</option>
                        <option value='2'>Cân nặng bé trai</option>
                        <option value='3'>Chiều cao bé gái</option>
                        <option value='4'>Cân nặng bé gái</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Số tháng:</label>
                    <input class="form-control" type="number" placeholder="Nhập..." v-model="so_thang" min="1">
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
                    <div class="text-left" style="padding-top:25px;">
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
                                <label>Danh sách chuẩn chiều cao, cân nặng</label>
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
                                            <th><p>Mã tiêu chuẩn</p></th>
                                            <th><p>Loại tiêu chuẩn</p></th>
                                            <th><p>Thiếu chuẩn 1</p></th>
                                            <th><p>Thiếu chuẩn 2</p></th>
                                            <th><p>Thiếu chuẩn 3</p></th>
                                            <th><p>Trung bình</p></th>
                                            <th><p>Vượt chuẩn 1</p></th>
                                            <th><p>Vượt chuẩn 2</p></th>
                                            <th><p>Vượt chuẩn 3</p></th>
                                            <th><p>Số tháng</p></th>
                                            <th><p>Ngày cập nhật</p></th>
                                            <th><p>Trạng thái</p></th>
                                            <th><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_tieu_chuan.length===0">
                                        <tr>
                                            <td class="text-center" colspan="14"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(tg,index) in ds_tieu_chuan">
                                            <td><p>{{ (currentPage - 1) * limit + index + 1 }}</p></td>
                                            <td><p>{{ tg.maChuanChieuCaoCanNang }}</p></td>
                                            <td><p>{{ getLoai(tg.loaiTieuChuan) }}</p></td>
                                            <td><p>{{ tg.standard1 }}</p></td>
                                            <td><p>{{ tg.standard2 }}</p></td>
                                            <td><p>{{ tg.standard3 }}</p></td>
                                            <td><p>{{ tg.standard0 }}</p></td>
                                            <td><p>{{ tg.standardSub1 }}</p></td>
                                            <td><p>{{ tg.standardSub2 }}</p></td>
                                            <td><p>{{ tg.standardSub3 }}</p></td>
                                            <td><p>{{ tg.thang }}</p></td>
                                            <td><p>{{ getTime(tg.ngayCapNhat) }}</p></td>
                                            <td><p>
                                                {{ parseInt(tg.trangThai) === 1 ? 'Đang hoạt động' : 'Ngưng hoạt động' }}</p>
                                            </td>
                                            <td class="text-center">
                                                <el-button type="warning" icon="el-icon-edit"
                                                           @click.prevent="showUpdate(tg)" size="mini"></el-button>
                                                <el-button type="danger" icon="el-icon-delete"
                                                           @click.prevent="deleteUnit(tg)" size="mini"></el-button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiTieuChuan :show="show_create" @close="show_create=false"
                                                      @success="onCreatedData($event)"></ThemMoiTieuChuan>
                                    <ChinhSuaTieuChuan :show="show_update" :item="dataEditTieuChuan"
                                                       @close="show_update=false"
                                                       @success="onCreatedData($event)"></ChinhSuaTieuChuan>
                                    <ImportTieuChuan :show="show_import"
                                                     :info="thongTinImport"
                                                     @close="show_import=false"
                                                     @success="onCreatedData($event)"></ImportTieuChuan>
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
import ThemMoi from './ThemTieuChuanChieuCaoCanNang';
import ChinhSua from './ChinhSuaTIeuChuanChieuCaoCanNang';
import Import from './pupupImportExcel/importChung.vue';
import dialog from '../../utils/dialog';
import api from './../api';
import ElementUI from 'element-ui';
Vue.use(ElementUI);
export default {

    components: {
        "Page": Page,
        "ThemMoiTieuChuan": ThemMoi,
        "ChinhSuaTieuChuan": ChinhSua,
        "ImportTieuChuan": Import,
    },

    computed: {},

    data() {

        return {
            thongTinImport: {
                title: 'Nhập chuẩn chiều cao cân nặng',
                pathImport: '/api-import-chuan-chieu-cao-can-nang',
                pathTemplate: '/templateImport/Template_Chuan_Chieu_Cao_Can_Nang.xlsx'
            },
            ten_tieu_chuan: '',
            show_create: false,
            show_update: false,
            show_import: false,
            trang_thai: '',
            total_rows: 0,
            ma_tieu_chuan: '',
            ds_tieu_chuan: [],
            start: 0,
            currentPage: 1,
            limit: 25,
            dataEditTieuChuan: {},
            loai_tieu_chuan: '',
            so_thang: ''
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
        getLoai(loai) {
            var res = loai;
            switch (loai) {
                case 1:
                    res = 'Chiều cao bé trai'
                    break;
                case 2:
                    res = 'Cân nặng bé trai'
                    break;
                case 3:
                    res = 'Chiều cao bé gái'
                    break;
                case 4:
                    res = 'Cân nặng bé gái'
                    break;
                default:
                    res = loai;
            }
            return res;
        },

        getData() {
            let params = {
                "start": this.start,
                "limit": this.limit,
                "ma": this.ma_tieu_chuan,
                // "ten": this.ten_tieu_chuan,
                "trangthai": this.trang_thai,
                "loai": this.loai_tieu_chuan,
                "thang": this.so_thang
            };
            rest_api.get("/internal-api/dmChuanChieuCaoCanNang/filter", params, (data) => {
                if (array_util.isArray(data.data.rows)) {
                    this.total_rows = data.data.total;
                    array_util.clearArrays(this.ds_tieu_chuan);
                    this.ds_tieu_chuan = data.data.rows;
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
        showUpdate(tt) {
            console.log(tt);
            this.dataEditTieuChuan = tt;
            this.show_update = true;

        },
        onCreatedData(e) {
            this.getData();
        },
        deleteUnit(e) {
            console.log("xóa lý do bỏ học" + JSON.stringify(e));
            dialog.confirmDialog("Bạn có muốn xóa chuẩn chiều cao cân nặng này?", "Đồng ý", () => {
                console.log("đồng ý xóa");
                const uri = "/api_xoa_chuan_chieu_cao_can_nang";
                let params = {
                    id: e.maChuanChieuCaoCanNang,
                };
                console.log('id : ' + e.maChuanChieuCaoCanNang);
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
p, a {
    font-size: 12px;
}

th {
    text-align: center
}
</style>

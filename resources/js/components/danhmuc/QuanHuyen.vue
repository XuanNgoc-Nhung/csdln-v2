<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span class="kytu"> &raquo;</span> quận huyện</span>
            </div>
        </div>
        <form role="form" class="form-inline">
            <div class="row">
                <div class="col-sm-2">
                    <label>Trực thuộc tỉnh/thành:</label>
                    <select class="form-control" v-model="ma_tinh_thanh">
                        <option value=''>Chọn tỉnh thành</option>
                        <option v-for="tt in ds_tinh_thanh" :value='tt.maTinhThanh'> {{tt.tenTinhThanh}}</option>
                    </select>
                </div>
                <div class="col-sm-2">
                    <label>Tên quận/huyện:</label>
                    <input v-model="ten_quan_huyen" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-sm-2">
                    <label>Mã quận/huyện:</label>
                    <input v-model="ma_quan_huyen" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-sm-2">
                    <div>
                        <label style="display: block;">Trạng thái:</label>
                        <select class="form-control" v-model="trang_thai">
                            <option value=''>Tất cả</option>
                            <option value='1'>Đang hoạt động</option>
                            <option value='0'>Ngưng hoạt động</option>
                        </select>
                    </div>
                </div>
                <div class="col-sm-2">
            <div class="text-left" style="padding-top:25px;">
                <button class="btn btn-success" v-on:click.prevent="getData()"><i class="fa fa-search"></i>Tìm kiếm</button>
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
                                <label>Danh sách quận huyện</label>
                                <button class="btn btn-success pull-right" v-on:click.prevent="showCreat()">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </button>
                                <button style="margin:0 5px;" class="btn btn-primary pull-right" v-on:click.prevent="showImport()">
                                    <i class="fas fa-upload"></i> Import
                                </button>
                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr >
                                            <th class="text-center"><p>STT</p></th>
                                            <th class="text-center"><p>Mã quận/huyện</p></th>
                                            <th class="text-center"><p>Tên quận/huyện</p></th>
                                            <th class="text-center"><p>Trực thuộc tỉnh/thành</p></th>
                                            <th class="text-center"><p>Ngày cập nhật</p></th>
                                            <th class="text-center"><p>Trạng thái</p></th>
                                            <th class="text-center"><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_quan_huyen.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(qh,index) in ds_quan_huyen">
                                            <td class="text-center"><p>{{(currentPage-1)*limit + index+1}}</p></td>
                                            <td class="text-center"><p>{{qh.maQuanHuyen}}</p></td>
                                            <td><p>{{qh.tenQuanHuyen}}</p></td>
                                            <td ><p>{{qh.tenTinhThanh}}</p></td>
                                            <td class="text-center"><p>{{getTime(qh.ngayCapNhat)}}</p></td>
                                            <td class="text-center"><p>{{parseInt(qh.trangThai)=== 1 ? 'Đang hoạt động' : 'Ngưng hoạt động'}}</p>
                                            </td>
                                            <td class="text-center">
                                                <el-button type="warning" icon="el-icon-edit"
                                                           @click.prevent="showUpdate(qh)" size="mini"></el-button>
                                                <el-button type="danger" icon="el-icon-delete"
                                                           @click.prevent="deleteData(qh)" size="mini"></el-button>
<!--                                                <a href="#" title="Chỉnh sửa" v-on:click.prevent="showUpdate(qh)"><i-->
<!--                                                    class="far fa-edit"></i></a>-->
<!--                                                <a href="#" title="Xóa" v-on:click.prevent="deleteData(qh)"><i-->
<!--                                                    class="fas fa-trash-alt"></i></a>-->
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiQuanHuyen :show="show_create" @close="show_create=false"
                                                      @success="onCreatedData($event)"></ThemMoiQuanHuyen>
                                    <ChinhSuaQuanHuyen :show="show_update" :item="dataEditQuanHuyen"
                                                       @close="show_update=false"
                                                       @success="onUpdatedData($event)"></ChinhSuaQuanHuyen>
                                    <ImportQuanHuyen :show="show_import"
                                                     @close="show_import=false"
                                                     @success="onCreatedData($event)"></ImportQuanHuyen>
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
    import dialog from '../../utils/dialog';
    import api from '../api';
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import timeutils from '../../utils/time_utils';
    import Page from '../ui/PagingCustom';
    import ThemMoi from './ThemQuanHuyen';
    import ChinhSua from './ChinhSuaQuanHuyen';
    import Import from './pupupImportExcel/importQuanHuyen';
    import VueAlertify from 'vue-alertify';
    import ElementUI from 'element-ui';
    Vue.use(ElementUI);
    Vue.use(VueAlertify);
    export default {

        components: {
            "Page": Page,
            "ThemMoiQuanHuyen": ThemMoi,
            "ChinhSuaQuanHuyen": ChinhSua,
            "ImportQuanHuyen": Import,
        },

        computed: {},

        data() {

            return {
                ma_tinh_thanh: '',
                ten_tinh_thanh: '',
                ten_quan_huyen: '',
                ma_quan_huyen: '',

                show_create: false,
                show_update: false,
                show_import: false,
                trang_thai: '',
                total_rows: 0,
                ds_tinh_thanh: [],
                ds_quan_huyen: [],
                start: 0,
                currentPage: 1,
                limit: 25,
                dataEditQuanHuyen: {},
            }
        },

        mounted() {
            this.getTinhThanh();
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

            getTinhThanh() {
                let params = {
                    "start": 0,
                    "limit": 100,
                };
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.ds_tinh_thanh = data.data.rows;
                        this.total_rows = data.data.total;
                    }
                }, 10000, true);
            },
            getData() {
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "ma": this.ma_quan_huyen,
                    "ten": this.ten_quan_huyen,
                    "maTinhThanh": this.ma_tinh_thanh,
                    "trangthai": this.trang_thai,
                };
                console.log("lấy ds quận huyện:" + params);
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.total_rows = data.data.total;
                        console.log("số hàng: " + this.total_rows);
                        array_util.clearArrays(this.ds_quan_huyen);
                        this.ds_quan_huyen = data.data.rows;
                        console.log(JSON.stringify(data));
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
                this.dataEditQuanHuyen = tt;
                this.show_update = true;

            },
            onCreatedData() {
                this.$alertify.success('Thêm quận huyện thành công.');
                this.getData();
            },
            onUpdatedData(e) {
                this.$alertify.success('Chỉnh sửa quận huyện thành công.');
                this.getData();
            },
            deleteData(qh) {
                dialog.confirmDialog("Bạn có muốn xóa quận huyện này?", "Đồng ý", () => {
                    console.log("đồng ý xóa");

                    const uri = "/api_xoa_quan_huyen";
                    let params = {
                        id: qh.maQuanHuyen,
                    };
                    api.post(uri, params, (response) => {
                        if (response.data.code === 200) {
                            showDialog("Thông báo", "Xóa quận/huyện thành công", null, () => {
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
.form-control{
    width:100%;
}
th{
    text-align: center;
}
p{
    font-size: 14px;
}
</style>

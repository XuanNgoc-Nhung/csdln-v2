<template>
    <div>
        <form role="form" class="form-inline">
            <label>Mã template:</label>
            <input v-model="ma_template" class="form-control" placeholder="Nhập...">
            <label>Tên template:</label>
            <input v-model="ten_template" class="form-control" placeholder="Nhập...">
            <label>Loại áp dụng:</label>
            <select class="form-control" v-model="loai_ap_dung">
                <option value=''>Tất cả</option>
                <option value=''>Thêm mới</option>
                <option value=''>Sửa</option>
                <option value=''>Khôi phục mật khẩu</option>
                <option value=''>Khác</option>
            </select>
            <label>Trạng thái:</label>
            <select class="form-control" v-model="trang_thai">
                <option value=''>Tất cả</option>
                <option value='1'>Đang hoạt động</option>
                <option value='0'>Ngưng hoạt động</option>
            </select>
            <button class="btn btn-success" v-on:click.prevent="getData()"><i class="fa fa-search"></i>Tìm kiếm</button>
        </form>
        <div class="row" style="margin-top: 20px">

            <div class="col-lg-12">

                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <label>Danh sách kết quả</label>
                                <button class="btn btn-success pull-right" v-on:click.prevent="showCreat()">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </button>
                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Mã template</th>
                                            <th>Tên template</th>
                                            <th>Loại áp dụng</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_email_mau.length===0">
                                        <tr>
                                            <td class="text-center" colspan="8">Không có dữ liệu phù hợp</td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(tg,index) in ds_email_mau">
                                            <td>{{(currentPage-1)*limit + index+1}}</td>
                                            <td>{{tg.maTemplate}}</td>
                                            <td>{{tg.tenTemplate}}</td>
                                            <td>{{tg.loaiApDung}}</td>
                                            <td>{{getTime(tg.ngayCapNhat)}}</td>
                                            <td>{{parseInt(tg.trangThai)=== 1 ? 'Đang hoạt động' : 'Ngưng hoạt động'}}
                                            </td>
                                            <td class="text-center">
                                                <a title="Chỉnh sửa" v-on:click="showUpdate(tg)"><i
                                                    class="far fa-edit"></i></a>
                                                <a title="Xóa" v-on:click.prevent="deleteUnit()"><i
                                                    class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiEmail :show="show_create" @close="show_create=false"
                                                  @success="onCreatedData($event)"></ThemMoiEmail>
                                    <ChinhSuaEmail :show="show_update" :item="dataEditEmailTemp"
                                                   @close="show_update=false"
                                                   @success="onCreatedData($event)"></ChinhSuaEmail>
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
    import ThemMoi from './ThemMoiCauHinhEmail';
    import ChinhSua from './ChinhSuaCauHinhEmail';

    export default {

        components: {
            "Page": Page,
            "ThemMoiEmail": ThemMoi,
            "ChinhSuaEmail": ChinhSua,
        },

        computed: {},

        data() {

            return {
                ma_template : '',
                ten_template : '',
                loai_ap_dung : '',
                show_create: false,
                show_update: false,
                trang_thai: '',
                total_rows: 0,
                ds_email_mau: [],
                start: 0,
                currentPage: 1,
                limit: 25,
                dataEditEmailTemp: {},
            }
        },
        props: {
            maSo: {
                type: Number,
                default: '0',
            },
        },

        mounted() {
            this.getData();
            console.log("mã sở" + this.maSo);
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
                    "tenTemplate": this.ten_template,
                    "maTemplate": this.ma_template,
                    "loaiApDung": this.loai_ap_dung,
                    "trangThai": this.trang_thai,
                };
                rest_api.get("/internal-api/cauHinhTempEmail/filter", params, (data) => {
                    console.log("ds trả về: " + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        this.total_rows = data.data.total;
                        array_util.clearArrays(this.ds_email_mau);
                        this.ds_email_mau = data.data.rows;
                    }
                });
            },
            showCreat() {
                this.show_create = true;
            },
            showUpdate(tg) {
                console.log("sửa" + JSON.stringify(tg));
                this.dataEditEmailTemp = tg;
                this.show_update = true;

            },
            onCreatedData(e) {
                this.getData();
            },
            deleteUnit() {
                // console.log("xóa");
            },
        }

    }
</script>

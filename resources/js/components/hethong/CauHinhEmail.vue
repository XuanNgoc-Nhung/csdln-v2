<template>
    <div>
        <form role="form" class="form-inline">
            <label>Tên đăng nhập:</label>
            <input v-model="ten_dang_nhap" class="form-control" placeholder="Nhập...">
            <label>Địa chỉ email:</label>
            <input v-model="dia_chi_email" class="form-control" placeholder="Nhập...">
            <label>Đơn vị:</label>
            <select class="form-control" v-model="don_vi">
                <option value=''>Tất cả</option>
                <option v-for="dv in ds_don_vi" :value='dv.maDonVi'>{{dv.tenDonVi}}</option>
            </select><label>Trạng thái:</label>
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
                                            <th>Tên đăng nhập</th>
                                            <th>Địa chỉ email</th>
                                            <th>Vai trò</th>
                                            <th>Đơn vị</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_email.length===0">
                                        <tr>
                                            <td class="text-center" colspan="8">Không có dữ liệu phù hợp</td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(tg,index) in ds_email">
                                            <td>{{(currentPage-1)*limit + index+1}}</td>
                                            <td>{{tg.tenDangNhap}}</td>
                                            <td>{{tg.diaChiEmail}}</td>
                                            <td>
                                                <div v-if="tg.vaiTro==1"> Sở</div>
                                                <div v-else-if="tg.vaiTro==2"> Phòng </div>
                                                <div v-else>Chưa rõ</div>
                                            </td>
                                            <td>{{tg.tenDonVi}}</td>
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
                                    <ThemMoiEmail :show="show_create" @close="show_create=false" :item="ma_so"
                                                  @success="onCreatedData($event)"></ThemMoiEmail>
                                    <ChinhSuaEmail :show="show_update" :ma_so="ma_so" :item="dataEditEmail"
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
    import ThemMoi from './ThemEmail';
    import ChinhSua from './ChinhSuaEmail';

    export default {

        components: {
            "Page": Page,
            "ThemMoiEmail": ThemMoi,
            "ChinhSuaEmail": ChinhSua,
        },

        computed: {},

        data() {

            return {
                ten_dang_nhap: '',
                show_create: false,
                show_update: false,
                trang_thai: '',
                don_vi: '',
                ma_so: '',
                total_rows: 0,
                dia_chi_email: '',
                ds_don_vi: [],
                ds_email: [],
                start: 0,
                currentPage: 1,
                limit: 25,
                dataEditEmail: {},
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
            this.getDonVi();
            console.log("mã sở:" + this.maSo);
        },

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
                    "diaChiEmail": this.dia_chi_email,
                    "tenDangnhap": this.ten_dang_nhap,
                    "maDonVi": this.don_vi,
                    "trangThai": this.trang_thai,
                };
                rest_api.get("/internal-api/cauHinhEmail/filter", params, (data) => {
                    console.log("ds trả về: " + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        this.total_rows = data.data.total;
                        array_util.clearArrays(this.ds_email);
                        this.ds_email = data.data.rows;
                    }
                });
            },
            showCreat() {
                this.ma_so = this.maSo;
                this.show_create = true;
            },
            showUpdate(tg) {
                this.dataEditEmail = tg;
                this.ma_so = this.maSo;
                this.show_update = true;

            },
            onCreatedData(e) {
                this.getData();
            },
            deleteUnit() {
                // console.log("xóa");
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 500,
                    "maDonViCha": this.maSo,
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    // console.log("ds đơn vị trả về: " + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_don_vi);
                        this.ds_don_vi = data.data.rows;
                    }
                });
            },
        }

    }

</script>

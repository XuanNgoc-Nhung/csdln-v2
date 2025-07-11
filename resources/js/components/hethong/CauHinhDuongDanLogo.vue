<template>
    <div>
        <div class="row" style="margin-top: 20px">

            <div class="col-lg-12">

                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                           <th>Hình ảnh</th>
                                            <th>Tên file</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_duong_dan_logo.length===0">
                                        <tr>
                                            <td class="text-center" colspan="8">Không có dữ liệu phù hợp</td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>

                                        <tr v-for="(tg,index) in ds_duong_dan_logo" >
                                            <td>{{(currentPage-1)*limit + index+1}}</td>
                                            <td>{{getImage(tg.maDonVi)}}</td>
                                            <td>{{tg.name +'.'+ tg.type}}</td>
                                            <td>{{getTime(tg.ngayCapNhat)}}</td>
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
                                    <ThemMoiDuongDanLogo :show="show_create" @close="show_create=false"
                                                  @success="onCreatedData($event)"></ThemMoiDuongDanLogo>
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

    export default {

        components: {
            "Page": Page,
            "ThemMoiDuongDanLogo": ThemMoi,
        },
        computed: {},
        data() {

            return {
                show_create: false,
                ds_duong_dan_logo: [],
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                ma_hinh_anh:'',
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
                // this.getData()
            },
            getTime(date) {
                return timeutils.convertTime(new Date(date));
            },
            getData() {
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                };
                rest_api.get("/internal-api/imageDonvi/filter", params, (data) => {
                    console.log("ds đường dẫn logo trả về: " + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        this.total_rows = data.data.total;
                        array_util.clearArrays(this.ds_duong_dan_logo);
                        this.ds_duong_dan_logo = data.data.rows;
                    }
                });
            },
            showCreat() {
                this.show_create = true;
            },
            onCreatedData(e) {
                this.getData();
            },
            deleteUnit() {
                // console.log("xóa");
            },
            getImage(ma){
                console.warn("lấy hình ảnh đường dẫn logo")
                this.ma_hinh_anh = ma;
                let params = {
                    "maDonVi": this.ma_hinh_anh,
                };
                console.log("lấy hình ảnh:" + JSON.stringify(params));
                return
                rest_api.get("/internal-api/imageDonvi/", params, (data) => {
                    console.log("ds đường dẫn logo trả về: " + JSON.stringify(data));
                    return data;
                });
            }
        }

    }

</script>

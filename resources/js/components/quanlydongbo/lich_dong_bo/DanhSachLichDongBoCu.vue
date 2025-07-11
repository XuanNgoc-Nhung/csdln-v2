<template>
    <div class="row" style="margin-top: 20px">

        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <label>DANH SÁCH CẤU HÌNH ĐẨY DỮ LIỆU CŨ</label>
                            <button class="btn btn-success pull-right" v-on:click.prevent="showCreat">
                                <i class="fa fa-plus" aria-hidden="true"></i>
                                Thêm</button>
                        </div>
                    </div>

                    <hr style="margin: 10px 0 0;"/>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive row_tp">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>
                                                <p>STT</p>
                                            </th>
                                            <th>
                                                <p>Năm học</p>
                                            </th>
                                            <th>
                                                <p>Lần cập nhật gần nhất</p>
                                            </th>
                                            <th>
                                                <p>Trạng thái</p>
                                            </th>
                                            <th>
                                                <p>Thao tác</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="list_dongbo.length===0">
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <p>Không có bản ghi nào</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody>
                                        <tr v-for="(nd,i) in list_dongbo">
                                            <td>
                                                <p>{{i+1}}</p>
                                            </td>
                                            <td>
                                                <p>{{nd.namHoc}}-{{nd.namHoc + 1}}</p>
                                            </td>
                                            <td>
                                                <p>{{nd.updatedTime}}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{parseInt(nd.status)=== 1 ? 'Đang hoạt động' : 'Ngưng hoạt động'}}</p>
                                            </td>
                                            <td class="text-center">
                                                <a href="#" title="Chỉnh sửa" v-on:click.prevent="showUpdateSync(nd)">
                                                    <i class="far fa-edit"></i>
                                                </a>
                                                <a href="#" title="Chỉnh sửa" v-on:click.prevent="showInfoSync(nd)">
                                                    <i class="fas fa-info-circle"></i>
                                                </a>
                                                <a href="#" title="Xóa" v-on:click.prevent="deleteData(nd)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                                <a href="#" title="Khóa/Mở khóa" v-on:click.prevent="lockSync(nd.id)">
                                                    <i v-if="nd.status==1" class="fas fa-lock"></i>
                                                    <i v-else class="fas fa-unlock-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <Page :total_rows="total_rows" @pageChange="onPageChange"></Page>
                                <ThemMoiLichDongBo
                                    :show="show_create"
                                    @close="show_create=false"
                                    @success="onCreatedData($event)"></ThemMoiLichDongBo>
                                <ChinhSuaLichDongBo
                                    :show="show_update"
                                    :item="dataEdit"
                                    @close="show_update=false"
                                    @success="onCreatedData($event)"></ChinhSuaLichDongBo>
                                <ThongTinLichDongBo :show="show_info" :item="dataEdit" @close="show_info=false"></ThongTinLichDongBo>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import Page from '../../ui/PagingCustom';
    import rest_api from '../../../utils/rest_api';
    import array_util from '../../../utils/array_utils';
    import ThemMoiLichDongBo from "./ThemMoiLichDongBoCu";
    import ChinhSuaLichDongBo from "./SuaLichDongBoCu";
    import ThongTinLichDongBo from "./ThongTinLichDongBoCu";
    import dialog from '../../../utils/dialog';
    import api from './../../api';
     Vue.use(VueAlertify, {
                notifier: {
                    delay: 5,
                    position: 'top-right'
                }
            });
    export default {

        components: {
            ThongTinLichDongBo,
            ThemMoiLichDongBo,
            ChinhSuaLichDongBo,
            'Page': Page
        },

        data() {
            return {
                total_rows: 0,
                list_dongbo: [],
                list_header: [],
                dataInfo: {},
                show_create: false,
                show_update: false,
                show_info: false,
                start: 1,
                limit: 25,
                dataEdit: {}
            }
        },

        mounted: function () {
            this.getData();
        },
        methods: {

            getData() {
                let params = {
                    "start": this.start,
                    "limit": this.limit
                };
                console.log("lấy danh sách cấu hình lịch đồng bộ");
                rest_api.get("/csdlgd-admin/yeuCauDongBo/list-old", params, (data) => {
                    this.list_dongbo = data.data.tableData;
                });

            },
            showCreat() {
                console.log("thêm mới cấu hình");
                this.show_create = true;
            },

            onPageChange(data) {},
            showUpdateSync(e) {
                this.show_update = true;
                this.dataEdit = e;
                console.log("chỉnh sửa:" + JSON.stringify(this.dataEdit));
            },
            showInfoSync(e) {
                this.show_info = true;
                this.dataEdit = e;
                console.log("Thông tin:" + JSON.stringify(this.dataEdit));
            },
            onCreatedData() {
                console.log("thêm mới thành công lịch đồng bộ");
                this.getData();
            },
            lockSync(e) {

                dialog.confirmDialog(
                    "Bạn có muốn thay đổi trạng thái lịch đồng bộ này?",
                    "Đồng ý",
                    () => {
                        let params = {
                            "id": e
                        };
                        console.log("lấy danh sách cấu hình lịch đồng bộ");
                        rest_api.get("/csdlgd-admin/yeuCauDongBo/toggleStatus", params, (data) => {
                            console.log("Khóa cấu hình trả về:" + JSON.stringify(data.data.rc));
                        if(data.data.rc==0){
                                    this
                                        .$alertify
                                        .success("Thay đổi trạng thái thành công.");
                                        this.getData();
                                    return;
                        }
                        else{

                                    this
                                        .$alertify
                                        .error("Thay đổi trạng thái thất bại:" + data.data.rd);
                                    return;
                        }
                        });
                    }
                );
            },

            deleteData(qh) {
                console.log("xóa cấu hình" + JSON.stringify(qh));
                dialog.confirmDialog("Bạn có muốn xóa lịch đồng bộ này?", "Đồng ý", () => {
                    console.log("đồng ý xóa");
                    const uri = "/api_xoa_lich_dong_bo";
                    let params = {
                        id: qh.id
                    };
                    api.post(uri, params, (response) => {
                        console.log("xóa:" + JSON.stringify(response));
                        if (response.data.rc === 0) {
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

<style scoped="scoped">
    p {
        font-size: 12px;
        text-align: center;
    }
    a {
        font-size: 12px;
    }
</style>

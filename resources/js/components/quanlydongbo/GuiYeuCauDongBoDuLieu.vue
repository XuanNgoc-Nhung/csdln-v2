<template>
    <div>

        <div class="col-lg-6">
            <h4 class=" text-uppercase">Gửi yêu cầu đồng bộ dữ liệu</h4>
        </div>
        <div class="col-lg-12">

            <form v-if="user.role!=5" role="form" class="form-inline">
                <div class="row">
                    <div class="col-sm-2">
                        <label>Chọn năm học:</label>

                        <select v-model="nam_hoc" class="form-control" style="width:100%">
                            <option value="">Chọn năm học</option>
                            <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <label>Chọn loại đồng bộ:</label>

                        <select v-model="sync_type" class="form-control" style="width:100%">
                            <option value="">Chọn loại đồng bộ</option>
                            <option v-for="dv in sync_types" :value="dv.id">{{dv.name}}</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <button
                            style="margin-top: 25px;height: 30px;"
                            @click.prevent="addRequest()"
                            class="btn btn-primary">Gửi yêu cầu</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <label v-if="user.role!=5">DANH SÁCH YÊU CẦU ĐÃ GỬI</label>
                            <label v-if="user.role==5">DANH SÁCH YÊU CẦU ĐÃ NHẬN</label>
                        </div>
                    </div>

                    <hr style="margin: 10px 0 0;"/>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive row_tp">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr style="background:#f6f6f6">
                                            <th>
                                                <p>STT</p>
                                            </th>
                                            <th>
                                                <p>Năm học</p>
                                            </th>
                                            <th>
                                                <p>Loại đồng bộ</p>
                                            </th>
                                            <th>
                                                <p>Ngày gửi yêu cầu</p>
                                            </th>
                                            <th v-if="user.role!=5">
                                                <p>Thao tác</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="this.list_req.length==0">
                                        <tr>
                                            <td v-if="user.role!=5" colspan="5"><p>Không có bản ghi nào được tìm thấy</p></td>
                                            <td v-if="user.role==5" colspan="4"><p>Không có bản ghi nào được tìm thấy</p></td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr v-for="(item,i) in list_req">
                                            <td>
                                                <p>{{i+1}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.namHoc}}-{{item.namHoc+1}}</p>
                                            </td>
                                            <td>
                                                <p>{{getLoaiDongBo(item.loaiDongBo)}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.ngayGui}}</p>
                                            </td>
                                            <td v-if="user.role!=5">
                                                <a title="Xóa" href="#" v-on:click.prevent="delRequest(item.id)">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script>

    import utils from '../../utils';
    import rest_api from '../../utils/rest_api';
    import Page from '../ui/PagingCustom';
    import constant from "../../utils/constant";
    import VueAlertify from 'vue-alertify';
    import dialog from '../../utils/dialog';
    import api from './../api';
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {

        components: {},

        props: ['info'],

        watch: {},

        data() {
            return {list_years: constant.LIST_YEARS_FULL, sync_types: constant.SYNC_TYPE, nam_hoc: '',user:{}, list_req: [], sync_type: ''}
        },

        mounted: function () {
            this.getRequest();
            this.user = JSON.parse(this.info)
            console.log("thông tin đăng nhập:" + JSON.stringify(this.user));
        },

        methods: {
            delRequest(e) {
                console.log("xóa" + e);
                dialog.confirmDialog("Bạn có muốn xóa yêu cầu này?", "Đồng ý", () => {
                    const uri = "/api_xoa_yeu_cau_dong_bo_du_lieu";
                    let params = {
                        idXoa: e
                    };
                    api.post(uri, params, (response) => {
                        console.log("xóa:" + JSON.stringify(response));
                        console.log("Xóa trả về:" + JSON.stringify(response));
                        if (response.data.rc == 0) {

                            this
                                .$alertify
                                .success("Xóa thành công.");
                            this.getRequest();
                        } else {
                            this
                                .$alertify
                                .error("Gửi yêu cầu thất bại:" + response.data.rd)
                                return;
                        }
                    });
                });
            },
            getRequest() {
                this.list_req = [];
                const params = {
                    "loaiDongBo": this.sync_type,
                    "namHoc": this.nam_hoc
                };
                rest_api.post("/csdlgd-admin/guiYeuCau/filter", params, (data) => {
                    console.log(JSON.stringify(data));
                    if (data.data.rc == 0) {
                        this.list_req = data.data.rows;
                    } else {
                        this.this.list_req = []
                    }
                    console.log(JSON.stringify(this.list_req));
                }, 1000, true)
            },
            addRequest() {
                console.log("Gửi yêu cầu");
                if (this.nam_hoc == "") {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học.");
                    return
                }
                if (this.sync_type == "") {
                    this
                        .$alertify
                        .error("Vui lòng chọn loại đồng bộ.");
                    return
                }
                const params = {
                    "loaiDongBo": this.sync_type,
                    "namHoc": this.nam_hoc
                };
                rest_api.post("/csdlgd-admin/guiYeuCau/create", params, (data) => {
                    if (data.data.rc == 0) {
                        this
                            .$alertify
                            .success("Gửi yêu cầu đồng bộ thành công.");
                        this.getRequest();
                        console.log(JSON.stringify(data));
                    } else {
                        this
                            .$alertify
                            .error("Gửi yêu cầu thất bại:" + data.data.rd)
                    }
                }, 10000, true)
            },
            getLoaiDongBo(e) {

                var res = e;
                switch (e) {
                    case 1:
                        res = 'Dữ liệu đầu năm'
                        break;
                    case 2:
                        res = 'Dữ liệu phát sinh'
                        break;
                    case 3:
                        res = 'Dữ liệu cuối năm'
                        break;
                    case 4:
                        res = 'Đẩy dữ liệu học sinh năm cũ'
                        break;
                    case 5:
                        res = 'Đẩy dữ liệu tức thời'
                        break;
                    default:
                        res = e;
                }
                return res;
            }
        }
    }
</script>
<style scoped="scoped">
    td,
    th {
        text-align: center;
    }
    p,a {
        font-size: 12px;
    }
    .form-control {
        width: 100%;
    }
</style>
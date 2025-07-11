<template>

    <div id="modal_them_doitac" ref="modal_them_doitac" class="modal fade">

        <div class="modal-dialog" style="width:50%">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Thêm đối tác</h4>
                </div>
                <div class="modal-body clearfix">
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Mã đối tác</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text"
                                       v-model="ma_doi_tac"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px;"/>
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Tên đối tác</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text"
                                       v-model="ten_doi_tac"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px;"/>
                            </div>
                        </div>
                    </div>

                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Tên đăng nhập</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text"
                                       v-model="ten_dang_nhap"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px;"/>
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Mật khẩu</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="password"
                                       v-model="mat_khau"
                                       class="form-control control-inline"
                                       style="min-width: 50px;"/>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Email:</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="text"
                                       v-model="email"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px;"/>
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">White list IP</label>
                            </div>
                            <div class="col-sm-4">
                                <textarea type="text"
                                          v-model="list_ip"
                                          class="form-control control-inline"
                                          style="min-width: 50px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="text-center">
                            Chọn service được phép truy cập
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <div class="table-responsive service row_tp">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Tên service</th>
                                        <th>Chọn</th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="ds_service.length===0">
                                    <tr>
                                        <td class="text-center" colspan="3">Không có dữ liệu phù hợp</td>
                                    </tr>
                                    </tbody>
                                    <tbody v-else>
                                    <tr v-for="(tg,index) in ds_service">
                                        <td>{{index + 1}}</td>
                                        <td>tên service {{tg.id}}</td>
                                        <td>
                                            <label> Chọn <input v-model="tg.check" type="checkbox"></label>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                    </button>
                    <button type="button" class="btn btn-primary" v-on:click="themDoiTac">Thêm
                    </button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>

    import moment from 'moment'
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import utils from '../../utils';
    import api from '../api';

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: ['item', 'show'],


        watch: {
            show: function (newVal, oldVal) {
                this.getService();
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.reset();
                    $("#modal_them_doitac").modal();
                } else {
                    $("#modal_them_doitac").modal('hide');
                }
            }
        },

        data() {
            return {
                ten_doi_tac: '',
                ma_doi_tac: '',
                mat_khau: '',
                list_ip: '',
                ten_dang_nhap: '',
                trang_thai: 1,
                email: '',
                list_ip: '',
                ds_service: [],
                maService: [],
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_doitac).on("hidden.bs.modal", this.close);
        },

        methods: {

            themDoiTac() {
                console.log("Têm đối tác");
                utils.confirmDialog("Xác nhận thêm đối tác", "Thêm", () => {
                    this.maService=[];
                    const uri = "/api_them_doi_tac";
                    for (var i = 0; i < this.ds_service.length; i++) {
                        if (this.ds_service[i].check) {
                            console.log("đã chọn service:" + this.ds_service[i].id);
                            this.maService.push(this.ds_service[i].id)
                        }
                    }
                    const params = {
                        maDoiTac: this.ma_doi_tac,
                        tenDoiTac: this.ten_doi_tac,
                        tenDangNhap: this.ten_dang_nhap,
                        trangThai: '1',
                        whileListIp: this.list_ip,
                        email: this.email,
                        matKhau: this.mat_khau,
                        maService: this.maService,
                    };
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm đối tác thành công", null, () => {
                                this.$emit('success', params);
                                this.close();
                            });
                        } else {
                            utils.showDialog("Thất bại", response.data.message, null, () => {
                            });
                        }
                    });
                })
            },

            reset() {
                this.ma_doi_tac = '';
                this.ten_doi_tac = '';
                this.ten_dang_nhap = '';
                this.trang_thai = '1';
                this.list_ip = '';
                this.email = '';
                this.mat_khau = '';
            },
            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            },
            getService() {
                let params = {};
                rest_api.get("/internal-api/heThongDoiTac/DanhSachService", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.ds_service = data.data.rows;
                        for (var i = 1; i < this.ds_service.length; i++) {
                            this.ds_service[i].check = false;
                        }
                    }
                });
            },
        }

    }
</script>


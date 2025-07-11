<template>
    <div id="thongtin_nhanduoc" ref="thongtin_nhanduoc" class="modal fade">
        <div class="modal-dialog" style="width: 70%;">

            <div class="modal-content">
                <form @submit.prevent="themToThonSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            v-on:click="closeinfo()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chi tiết</h4>
                    </div>

                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#home">Response</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#menu2">Request</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">

                            <div class="table-responsive row_tp" style="height:350px;font-size:12px;">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr class="text-center">
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã</th>
                                            <th class="text-center">Tên</th>
                                            <th class="text-center">Mã lỗi</th>
                                            <th class="text-center">Mô tả lỗi</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="!ChiTietDuLieu.length">
                                        <tr>
                                            <td class="text-center" colspan="22">Không có dữ liệu phù hợp</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(px,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index + 1}}</td>
                                            <td class="text-center">{{px.clientId}}</td>
                                            <td>{{px.name}}</td>
                                            <td class="text-center">{{px.error}}</td>
                                            <td>{{px.errorDescription}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <div style="width:100%; height:300px">
                                <textarea style="width:100%; height:100%; border-top:none;"
                                    :value="ChiTietRequest"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button v-if="show_tai" type="button" class="btn btn-info" @click.prevent="xuatExcel()">Tải bản
                            ghi lỗi
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</template>

<script>
    import utils from '../../utils';
    import rest_api from "../../utils/rest_api";
    import api from '../api';
    import VeeValidate, {
        Validator
    } from 'vee-validate';
    Vue.use(VeeValidate);
    $(document).ready(function () {});

    export default {

        props: [
            'item', 'hien'
        ],
        watch: {
            item: function (newVal) {
                console.log("thông tin bản ghi xem chi tiết:" + newVal);
                this.messageId = newVal;
            },
            hien: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#thongtin_nhanduoc").modal();
                    this.getDetail();
                } else {
                    $("#thongtin_nhanduoc").modal('hide');
                }
            }
        },

        data() {
            return {
                id: "",
                type: '',
                ChiTietDuLieu: [],
                ChiTietRequest: [],
                messageId: "",
                show_tai: false
            }
        },
        mounted: function () {
            $(this.$refs.thongtin_nhanduoc).on("hidden.bs.modal", this.closeinfo);
            // this.getDetail();
        },

        methods: {
            xuatExcel() {
                let url = "xuat-excel-ban-ghi-loi-lich-su-chuyen-du-lieu";
                let params = {
                    messageId: this.messageId
                };
                api.post(url, params, (data) => {
                    let a = document.createElement('a');
                    a.href = data.data.file;
                    document
                        .body
                        .appendChild(a);
                    a.click();
                    document
                        .body
                        .removeChild(a);
                });
            },
            getDetail() {
                this.show_tai = false;
                console.log(this.show_tai)
                let params = {
                    messageId: this.messageId
                };
                rest_api.post("/csdlgd-push/LichSuDay/detail", params, data => {
                    // console.log("chi tiết trả về:" + JSON.stringify(data))
                    if (data.data.code == 200) {
                        this.ChiTietDuLieu = data.data.item.response.body.result.items.item;
                        this.ChiTietRequest = data.data.item.request.body.content.items.item;
                        this.ChiTietDuLieu = JSON.stringify(this.ChiTietDuLieu);
                        this.ChiTietDuLieu = JSON.parse(this.ChiTietDuLieu);
                        this.ChiTietRequest = JSON.stringify(this.ChiTietRequest);
                        for (let i = 0; i < this.ChiTietDuLieu.length; i++) {
                            if (this.ChiTietDuLieu[i].error !== "000-000") {
                                console.log("có lỗi khác 0");
                                this.show_tai = true;
                            }
                        }
                    } else {
                        console.log("lấy thất bại");
                        utils.showDialog("Thất bại", data.data.rd, null, () => {});
                        return;
                    }
                });
            },
            reset() {
                this.show_tai = false;
                this.ChiTietDuLieu = [];
                this.ChiTietRequest = [];
            },
            closeinfo() {
                this.reset();
                this.$emit('closeinfo');
            }
        }
    }

</script>

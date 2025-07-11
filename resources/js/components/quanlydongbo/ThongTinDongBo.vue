<template>

    <div id="modal_info_sync" ref="modal_info_sync" class="modal fade">
        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-md-7">
                            <h3 class="modal-title text-uppercase">Thông tin cấu hình</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right;"><span
                                    style="font-size:18px;padding-top:7px;">Năm học:</span></div>
                                <div class="col-md-8">
                                    <select
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn năm học--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="width: 90%;margin: 0 auto; font-size: 18px">
                    <div class="row">
                        <span style="font-size: 19px; border-bottom:1px solid #ddd">DỮ LIỆU ĐẦU NĂM</span>

                    </div>
                    <div class="row" style="width:90%; margin:0 auto;">
                        <div class="col-md-2">Ngày bắt đầu</div>
                        <div class="col-md-4">
                            <input
                                disabled
                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                style="width:100%"
                                v-model=dauNamBatDau
                                type="date"/></div>
                        <div class="col-md-2">Ngày kết thúc</div>
                        <div class="col-md-4">
                            <input
                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                style="width:100%"
                                v-model="dauNamKetThuc"
                                type="date"/></div>
                        <div class="row" style="text-align:center">
                            <span style="font-size: 12px; font-weight: 300; text-align:center"><i>Dữ liệu đầu năm bao gồm các dữ liệu về: Học sinh, lớp học, phân công giáo viên,...</i></span>
                        </div>
                    </div>
                    <div class="row">
                        <span style="font-size: 19px; border-bottom:1px solid #ddd">DỮ LIỆU PHÁT SINH</span>
                        <div class="row" style="width:85%; margin:0 auto;">
                            <table class="table table-bordered table-striped table-hover" style="margin-bottom: 0">
                                <tr style="background: #e4ebf5;text-align:center;">
                                    <th>STT</th>
                                    <th>Ngày bắt đầu</th>
                                    <th>Ngày kết thúc</th>
                                    <th>Thao tác</th>
                                </tr>
                                <tr v-for="(slps,index) in list_dlps">
                                    <td>{{index}}</td>
                                    <td>
                                        <input
                                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                            style="width:100%"
                                            type="date"/>
                                    </td>
                                    <td>
                                        <input
                                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                            style="width:100%"
                                            type="date"/>
                                    </td>
                                    <td style="text-align:center">
                                        <a href="" v-on:click.prevent="DellDLPS(index)"><i class="fas fa-times"></i></a>
                                    </td>
                                </tr>
                            </table>
                            <button class="btn btn-primary" v-on:click="addDLPS()">Thêm</button>
                        </div>
                        <div class="row" style="text-align:center">
                            <span style="font-size: 12px; font-weight: 300; text-align:center"><i>Dữ liệu phát sinh bao gồm các dữ liệu: Điểm, học sinh chuyển lớp, học sinh chuyển trường, học sinh bỏ học</i></span>
                        </div>
                    </div>
                    <div class="row">
                        <span style="font-size: 19px; border-bottom:1px solid #ddd">DỮ LIỆU CUỐI NĂM</span>
                    </div>
                    <div class="row" style="width:90%; margin:0 auto;">
                        <div class="col-md-2">Ngày bắt đầu</div>
                        <div class="col-md-4">
                            <input
                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                style="width:100%"
                                v-model="cuoiNamBatDau"
                                type="date"/></div>
                        <div class="col-md-2">Ngày kết thúc</div>
                        <div class="col-md-4">
                            <input
                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                style="width:100%"
                                v-model="cuoiNamKetThuc"
                                type="date"/></div>
                        <div class="row" style="text-align:center">
                            <span style="font-size: 12px; font-weight: 300; text-align:center"><i>Dữ liệu cuối năm bao gồm các dữ liệu: Điểm tổng kết, tổng kết học sinh</i></span>
                        </div>
                    </div>
                    <div class="row" style="padding-top:30px;">
                        <p><span style="font-weight: 700;">Lưu ý:</span> Cấu hình đồng bộ dữ liệu áp dụng cho tất cả các trường.</p>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>

    $(document).ready(function () {
        console.log("ready!");
    });

    import moment from 'moment'
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'
    import api from '../api';

    Vue.use(VueAlertify);
    export default {
        props: ['item', 'show'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_info_sync").modal();
                } else {
                    $("#modal_info_sync").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                this.id = newVal.id;
                this.getInfo(this.id);
            }
        },
        data() {
            return {
                id:'',
                student_code: '',
                list_dlps: [],
                dauNamBatDau:'',
                cuoiNamBatDau:'',
                cuoiNamKetThuc:'',
                dauNamKetThuc:'',
            }
        },
        mounted: function () {
            $(this.$refs.modal_info_sync).on("hidden.bs.modal", this.close);
        },
        methods: {
            getInfo(id){
                console.log("xem thông tin đồng bộ của id:" + id);
                console.log(id);
                const uri = "/api_lay_thong_tin_yeu_cau_dong_bo";
                let params = {
                    "id": id,
                };
                api.get(uri, params, (respon) => {
                    console.log(respon);
                    this.dauNamBatDau = respon.data.item.dauNamTuNgay;
                    this.dauNamKetThuc = respon.data.item.dauNamToiNgay;
                })
            },

            close() {
                console.log("Đóng modal");
                this.$emit('close');
            },
            addDLPS() {
                console.log("thêm hàng mới");
                this.list_dlps.push({});
            },
            DellDLPS(index) {
                console.log(index);
                this.list_dlps.splice(index, 1)
            },
        }

    }
</script>


<style scoped>
    th {
        text-align: center;
    }

    td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
</style>

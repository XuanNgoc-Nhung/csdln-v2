<template>

    <div id="modal_update_sync" ref="modal_update_sync" class="modal fade">
        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-md-7">
                            <h3 class="modal-title text-uppercase">
                                CẤU HÌNH ĐỒNG BỘ DỮ LIỆU</h3>
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
                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                style="width:100%"
                                type="date"/></div>
                        <div class="col-md-2">Ngày kết thúc</div>
                        <div class="col-md-4">
                            <input
                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                style="width:100%"
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
                                type="date"/></div>
                        <div class="col-md-2">Ngày kết thúc</div>
                        <div class="col-md-4">
                            <input
                                class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                style="width:100%"
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
                    <button type="button" v-on:click="createEmail()" class="btn btn-primary">Sửa</button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>

    $(document).ready(function () {
        console.log("ready!");
    });

    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'

    Vue.use(VueAlertify);
    export default {
        props: ['item', 'show'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_update_sync").modal();
                } else {
                    $("#modal_update_sync").modal('hide');
                }
            }
        },
        data() {
            return {
                student_code: '',
                list_dlps: [],
            }
        },
        mounted: function () {
            $(this.$refs.modal_update_sync).on("hidden.bs.modal", this.close);
        },
        methods: {
            createEmail() {
                utils.confirmDialog("Bạn có muốn chỉnh sửa dữ liệu này?", "Chỉnh sửa", () => {
                    const params = {};
                    this.$emit('success', params);
                    this.close();
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
            }


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

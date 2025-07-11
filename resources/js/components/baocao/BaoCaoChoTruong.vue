<template>
    <div>
        <div class="row list_user">
            <div class="list_header">
                <h4>Báo cáo CSDL ngành cho bộ</h4>
            </div>
        </div>
        <div>
            <div class="responsive" style="margin-top:20px;">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr style="background: #e4ebf5; text-align:center">
                        <th>STT</th>
                        <th>Nội dung báo cáo</th>
                        <th>Điều kiện báo cáo</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>THPT Báo cáo lớp học dành cho Sở</td>
                        <td class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span>Năm học</span>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched">
                                            <option value="">chọn năm học</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span>Trường học</span>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched">
                                            <option value="">chọn trường học</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-4">
                                        <span>Học kỳ</span>
                                    </div>
                                    <div class="col-md-8">
                                        <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched">
                                            <option value="">chọn học kỳ</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            <button class="btn btn-primary" v-on:click="ShowReport()">Xem</button>
                            <button class="btn btn-primary" v-on:click="Report()">Báo cáo</button>
                            <button class="btn btn-primary" v-on:click="ExportExcel()">Xuất Excel</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div id="modal_show_info" ref="modal_show_info" class="modal fade">
            <div class="modal-dialog" style="width: 70%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h3 class="modal-title text-uppercase">Xem trước Kết quả</h3>
                    </div>
                    <div class="modal-body" style="width: 90%;margin: 0 auto; font-size: 18px">

                    </div>
                    <div>
                        <i>Để xem chi tiết đầy đủ dữ liệu báo cáo vui lòng xuất Excel! Kết quả xem trước chỉ lấy một số dữ liệu cơ bản</i>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </div>


            </div>

        </div>


    </div>
</template>
<script>
    import Vue from 'vue';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'

    Vue.use(VueAlertify);
    export default {
        components: {},
        data() {
            return {}
        },
        methods: {
            ShowReport() {
                console.log("Xem thông tin");
                $("#modal_show_info").modal();
            },
            Report() {
                console.log("Báo cáo thông tin");
                utils.confirmDialog("Xác nhận gửi dữ liệu báo cáo?", "Xác nhận", () => {
                    this.$alertify.success('Báo cáo thành công.');
                })
            },
            ExportExcel() {
                console.log("Xuất file thông tin");
                utils.confirmDialog("Xác nhận xuất dữ liệu ra file Excel?", "Xác nhận", () => {
                    this.$alertify.success('Xuất dữ liệu thành công.');
                })
            }
        }
    }
</script>
<style scoped>
    th {
        text-align: center;
    }
</style>

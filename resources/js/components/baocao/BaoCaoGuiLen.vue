<template>
    <div>
        <div class="row criteria-title">
            <h3>THÔNG TIN TÌM KIẾM </h3>
        </div>
        <div class="row">
            <div class="panel-body" style="width:80%; margin:0 auto;">
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4" style="text-align:right;padding-top:7px;">
                            <label>Tên báo cáo</label>
                        </div>
                        <div class="col-md-8">
                            <input
                                class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                style="width:100%"
                                type="text"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-4"  style="text-align:right;padding-top:7px;">
                            <label>Trạng thái</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched">
                                <option value="">--Tất cả--</option>
                                <option value="">Đã xử lý</option>
                                <option value="">Chưa xử lý</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <a href="" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</a>
                </div>
            </div>
        </div>
        <div class="report-emis" style="width:98%; margin: 0 auto;">
            <hr>
            <div class="responsive" style="margin-top:20px;">
                <h3 class="text-uppercase">Danh sách kết quả</h3>
                <div class="row">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr style="background: #e4ebf5; text-align:center">
                            <th>STT</th>
                            <th>Tên báo cáo</th>
                            <th>Đơn vị yêu cầu</th>
                            <th>Trạng thái</th>
                            <th>Ngày áp dụng</th>
                            <th>Ngày kết thúc</th>
                            <th>Số tiêu chí cần tổng hợp</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Báo cáo nhanh thống kê 2019</td>
                            <td>Sở Giáo dục và Đào tạo tỉnh Hà Giang</td>
                            <td>Chưa xử lý</td>
                            <td>21/12/2012</td>
                            <td>21/12/2013</td>
                            <td>21</td>
                            <td class="text-center">
                                <a title="Lịch sử báo cáo" v-on:click="ShowHistoryReport()"><i class="fas fa-history"></i></a>
                                <a title="Xem trước" v-on:click="ShowReport()"><i class="fas fa-info-circle"></i></a>
                                <a title="Báo cáo" v-on:click="Report()"><i class="fab fa-accusoft"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
        </div>


        <div id="modal_show_info" ref="modal_show_info" class="modal fade">
            <div class="modal-dialog" style="width: 70%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                v-on:click="close()">
                            &times;
                        </button>
                        <h3 class="modal-title text-uppercase">Xem trước Kết quả</h3>
                    </div>
                    <div class="modal-body" style="width: 90%;margin: 0 auto; font-size: 18px">

                    </div>
                    <div>
                        <i>Để xem chi tiết đầy đủ dữ liệu báo cáo vui lòng xuất Excel! Kết quả xem trước chỉ lấy một số
                            dữ liệu cơ bản</i>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </div>


            </div>

        </div>
<!--        lịch sử đẩy báo cáo-->

        <div id="modal_show_his" ref="modal_show_his" class="modal fade">
            <div class="modal-dialog" style="width: 70%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                v-on:click="close()">
                            &times;
                        </button>
                        <h3 class="modal-title text-uppercase">Lịch sử đẩy báo cáo</h3>
                    </div>
                    <div class="modal-body" style="margin: 0 auto; font-size: 18px">
                        <div class="responsive" style="margin-top:20px;">
                            <div class="row">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr style="background: #e4ebf5; text-align:center">
                                        <th>STT</th>
                                        <th>Ngày tạo báo cáo</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>21/12/2013</td>
                                        <td>Trạng thái 1</td>
                                        <td class="text-center">
                                            <a title="Lịch sử báo cáo" ><i class="fas fa-history"></i></a>
                                            <a title="Xem trước" ><i class="fas fa-info-circle"></i></a>
                                            <a title="Báo cáo"><i class="fab fa-accusoft"></i></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
            ShowHistoryReport() {
                console.log("Xem lịch sử báo cáo");
                $("#modal_show_his").modal();
            }
        }
    }
</script>
<style scoped>
    th {
        text-align: center;
    }

    .text-center a {
        padding: 5px;
    }

    .report-emis .col-md-4 {
        padding: 0 4px;
    }
</style>

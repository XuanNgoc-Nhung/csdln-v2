<template>
    <div>
        <div class="row criteria-title" style="margin:0 30px;">
            <h5>THÔNG TIN TÌM KIẾM </h5>
        </div>
        <div class="row criteria-search">
            <div class="panel-body">
                <div class="row height30 ">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Tên yêu cầu</label>
                            </div>
                            <div class="col-md-8">
                                <input
                                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                    style="width:100%"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Loại đối tượng</label>
                            </div>
                            <div class="col-md-8">
                                <select
                                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                    <option value="">--Chọn năm học--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Cấp học</label>
                            </div>
                            <div class="col-md-8">
                                <select
                                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                    <option value="">--Tất cả--</option>
                                    <option value="">--Nhà trẻ--</option>
                                    <option value="">--Mầm non--</option>
                                    <option value="">--Tiểu học--</option>
                                    <option value="">--THCS--</option>
                                    <option value="">--THPT--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row height30">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Năm học</label>
                            </div>
                            <div class="col-md-8">
                                <select
                                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                    <option value="">--Tất cả--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Trạng thái</label>
                            </div>
                            <div class="col-md-8">
                                <select
                                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                    <option value="">--Tất cả--</option>
                                    <option value="">--Đã gửi--</option>
                                    <option value="">--Chưa gửi--</option>
                                    <option value="">--Ngừng hoạt động--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-search">
                <a href="" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</a>
            </div>
        </div>
        <div style="background: #ddd;height: 20px;"></div>
        <div class="row list_user">
            <div class="list_header">
                <h4>DANH SÁCH PHÂN QUYỀN ĐỒNG BỘ DỮ LIỆU CŨ</h4>
            </div>
            <div>
                <div class="responsive" style="margin-top:20px;">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr style="background: #e4ebf5">
                            <th>STT</th>
                            <th>Tên yêu cầu nhập dữ liệu</th>
                            <th>Loại đối tượng</th>
                            <th>Cấp học</th>
                            <th>Năm học</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Trạng thái</th>
                            <th>Ngày đẩy dữ liệu</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>2019 - 2020</td>
                            <td>Trường Mầm non Lâm</td>
                            <td>Trường Mầm non Lâm</td>
                            <td>Trường Mầm non Lâm</td>
                            <td>Trường Mầm non Lâm</td>
                            <td>Dữ liệu năm học cũ</td>
                            <td>
                                <p v-if="statusactive"><span style="color:blue; font-weight: 700">Mới tạo</span></p>
                                <p v-else><span class="active"
                                                style=" color:#DC0101 ;font-weight: 700;">Đã đồng bộ</span></p>
                            </td>
                            <td>Trường Mầm non Lâm</td>
                            <td><span>12/12/2016</span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
            return {
                statusactive: false,
            }
        },
        methods: {
            Khoa() {
                utils.confirmDialog("Bạn có muốn thay đổi trạng thái email này?", "Đồng ý", () => {
                    this.lookuser = !this.lookuser;
                    this.$alertify.success('Thay đổi thành công');
                })
            },
            InfoData() {
                console.log("hiện thị form thông tin người dùng");
                $("#modal_info_data").modal();
            },
            showCreatSyncData() {
                console.log("hiện thị form thông tin người dùng");
                $("#modal_sync_old").modal();
            },
            createSyncDataOld() {
                console.log("thêm");
                utils.confirmDialog("Bạn có muốn thêm cấu hình đồng bộ dữ liệu cũ này?", "Thêm", () => {

                    $("#modal_sync_old").modal('hide');
                    this.$alertify.success('Thêm Thành Công.');
                })
            },
            showEditSyncData() {
                console.log("hiện thị form thông tin người dùng");
                $("#modal_sync_edit").modal();
            },
            showUpdateSyncData() {
                console.log("thêm");
                utils.confirmDialog("Bạn có muốn chỉnh sửa cấu hình đồng bộ dữ liệu cũ này?", "Sửa", () => {

                    $("#modal_sync_edit").modal('hide');
                    this.$alertify.success('Chỉnh Sửa Thành Công.');
                })

            }
        }
    }
</script>
<style scoped>
    th, td {
        text-align: center;
    }

    .height30{
        padding-bottom: 30px;
    }
    .abc {
        padding-bottom: 25px;
    }
    .criteria-search .col-md-4{
    }

    .text-center a {
        padding: 5px;
    }

    .panel-body {
        width: 90%;
        margin: 0 auto;
    }

    .pull-right button {
        margin: 7px;
    }

    .criteria-search {
        margin: 0 auto;
        padding-bottom: 20px;
        padding-top: 15px;
        background: #fff;
    }

    .criteria-search label {
        font-weight: 400;
        text-align: right;
        float: right;
        font-size: 12px;

    }

    .criteria-search input, select {
        border-radius: 4px;
    }

    .criteria-title {
        border-bottom: 1px solid #ddd;
        background: #fff;

    }

    .criteria-title h3 {
        text-transform: uppercase;
        border: 1px solid #e7e7e7;
        border-bottom: 1px solid transparent;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        vertical-align: middle;
        padding: 14px;
    }

    .button-search {
        margin: 0 auto;
        display: block;
        text-align: center;
    }

    .list_user {
        margin: 0 auto;
        background: white;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .list_header {

    }

    .list_header h4 {
        float: left;
    }

    .list_header button {
        float: right;
    }

    .text-center a {
        padding: 5px;
    }

    .panel-body {
        padding: 5px 15px;
    }
</style>

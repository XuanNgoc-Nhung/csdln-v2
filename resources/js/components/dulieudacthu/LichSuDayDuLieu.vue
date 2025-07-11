<template>
    <div>
        <div class="row criteria-title" style="margin:0 30px;">
            <h5>TIÊU CHÍ TÌM KIẾM </h5>
        </div>
        <div class="row criteria-search">
            <div class="panel-body">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Loại đối tượng</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                <option value="">--Tất cả--</option>
                                <option value="">--Nhà vệ sinh--</option>
                                <option value="">--Phòng tập--</option>
                                <option value="">--Thiết bị giảng dạy--</option>
                                <option value="">--Thư viện--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tên yêu cầu</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                <option value="">--Chọn--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Trường học</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                <option value="">--Chọn trường học--</option>
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
                                <option value="">--Mẫu giáo--</option>
                                <option value="">--Tiểu học--</option>
                                <option value="">--THCS--</option>
                                <option value="">--THPT--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Năm học</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                <option value="">--Tất cả--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Ngày đẩy dữ liệu</label>
                        </div>
                        <div class="col-md-8">
                            <input class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                   style="width:100%"
                                   type="date"/>
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
                <h4>DANH SÁCH KẾT QUẢ</h4>
                <div class="pull-right">
                    <button class="btn btn-primary" v-on:click="ExportFile()"><i class="far fa-file-excel"></i> Xuất
                        Excel
                    </button>
                </div>
            </div>
            <div>
                <div class="responsive" style="margin-top:20px;">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr style="background: #e4ebf5">
                            <th>STT</th>
                            <th>Trường học</th>
                            <th>Tên yêu cầu</th>
                            <th>Năm học</th>
                            <th>Cấp học</th>
                            <th>Ngày nhập dữ liệu</th>
                            <th>Ghi chú</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Học sinh THPT</td>
                            <td>Yêu cầu nhập liệu</td>
                            <td>2012-2015</td>
                            <td>THCS</td>
                            <td>21/12/2015</td>
                            <td>Nội dung ghi chú</td>
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
                lookuser: false,
                showImportFile: false,
            }
        },
        methods: {
            ExportFile() {
                console.log("Xuất dữ liệu ra file Excel");
                utils.confirmDialog("Bạn có muốn xuất dữ liệu ra file Excel?", "Đồng ý", () => {
                    this.$alertify.success('Xuất file thành công.');
                })

            }
        }
    }
</script>
<style scoped>
    th, td {
        text-align: center;
    }

    .col-md-4 {
        padding-bottom: 15px;
    }

    .abc span {
        color: #DC0101;
    }

    .text-center a {
        padding: 5px;
    }

    .panel-body {
        width: 90%;
        margin: 0 auto;
    }

    .panel-body .col-md-6 {
        padding-bottom: 20px;
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

    .w20 {
        width: 19%;
        display: inline-table;
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
        padding: 12px;
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

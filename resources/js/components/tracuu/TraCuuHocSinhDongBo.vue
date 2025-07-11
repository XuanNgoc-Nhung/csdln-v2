<template>
    <div>
        <div class="row criteria-search">
            <div class="panel-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Học sinh</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                       style="width:100%"
                                       placeholder="Nhập..."
                                       type="text"/>
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
                                    <option value="">--Chọn năm học--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Tên đối tác</label>
                            </div>
                            <div class="col-md-8">
                                <input class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                       style="width:100%"
                                       type="text"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row text-center">
                    <button class="btn btn-primary"> <i class="fas fa-search"></i> Tìm kiếm</button>
                    <button class="btn btn-primary"><i class="far fa-file-excel"></i> Xuất Excel</button>
                </div>
            </div>
        </div>
        <div style="background: #ddd;height: 20px;"></div>
        <div class="list_user">
            <div class="list_header text-uppercase">
                <h4>danh sách học sinh đồng bộ</h4>
            </div>
            <div class="responsive" style="margin-top:20px;">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr style="background: #e4ebf5">
                        <th>STT</th>
                        <th>Mã học sinh</th>
                        <th>Họ và tên</th>
                        <th>Giới tính</th>
                        <th>Ngày sinh</th>
                        <th>Trường học</th>
                        <th>Năm đồng bộ</th>
                        <th>Tên đối tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>MHS01234</td>
                        <td>Nguyễn Văn An</td>
                        <td>Nam</td>
                        <td>27/03/1994</td>
                        <td>THPT Nguyễn Du</td>
                        <td>2006</td>
                        <td>SMAS</td>
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
            return {}
        },
        methods: {}
    }
</script>
<style scoped>
    h3 {
        margin: 0 auto;
    }

    th, td {
        text-align: center;
    }

    .info-student label {
        padding: 5px 0;
    }

    .thumbnail img {
        width: 100%;
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

    .criteria-search input, select {
        border-radius: 4px;
    }

    .criteria-title h3 {
        text-transform: uppercase;
        border: 1px solid #e7e7e7;
        border-bottom: 1px solid transparent;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        vertical-align: middle;
        padding: 16px;
    }


    .list_user {
        margin: 0 auto;
        background: white;
        padding: 10px;
        border-bottom: 1px solid #ddd;
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

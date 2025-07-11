<template>
    <div>
        <div class="row criteria-title" style="margin:0 30px;">
            <h5>THÔNG TIN TÌM KIẾM </h5>
        </div>
        <div class="row criteria-search">
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Mã tiêu chí</label>
                        </div>
                        <div class="col-md-8">
                            <input
                                class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                style="width:100%"
                                type="text"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tên tiêu chí</label>
                        </div>
                        <div class="col-md-8">
                            <input
                                class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                style="width:100%"
                                type="text"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
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
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Loại dữ liệu</label>
                        </div>
                        <div class="col-md-8">
                            <select
                                class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                style="width:100%">
                                <option value="">--Tất cả--</option>
                                <option value="">--Dạng số--</option>
                                <option value="">--Dữ liệu logic Đúng/Sai--</option>
                                <option value="">--Dữ liệu dạng chuỗi--</option>
                                <option value="">--Dữ liệu dạng list--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Cấp học</label>
                        </div>
                        <div class="col-md-8">
                            <div class="w20">
                                <input type="checkbox"> Nhà trẻ
                            </div>
                            <div class="w20">
                                <input type="checkbox"> Mẫu giáo
                            </div>
                            <div class="w20">
                                <input type="checkbox"> Tiểu học
                            </div>
                            <div class="w20">
                                <input type="checkbox"> THCS
                            </div>
                            <div class="w20">
                                <input type="checkbox"> THPT
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Trạng thái</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                <option value="">--Tất cả--</option>
                                <option value="">--Đang hoạt động--</option>
                                <option value="">--Ngừng hoạt động--</option>
                            </select>
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
                <h4>YÊU CẦU ĐẨY DỮ LIỆU TRƯỜNG HỌC</h4>
                <div class="pull-right">
                    <button class="btn btn-primary" v-on:click="showImportData()"><i class="fas fa-upload"></i>
                        Nhập
                    </button>
                    <button class="btn btn-primary" v-on:click="showCreatSyncData()"><i class="fa fa-plus"
                                                                                        aria-hidden="true"></i> Thêm</button>
                </div>
            </div>
            <div>
                <div class="responsive" style="margin-top:20px;">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr style="background: #e4ebf5">
                            <th>STT</th>
                            <th>Mã tiêu chí</th>
                            <th>Tên tiêu chí</th>
                            <th>Loại đối tượng</th>
                            <th>Cấp học</th>
                            <th>Ngày cập nhật</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>1</td>
                            <td>Trường Mầm non Việt Lâm</td>
                            <td>2019 - 2020</td>
                            <td>12/12/2012</td>
                            <td>12/12/2015</td>
                            <td>Cuối năm</td>
                            <td>
                                <p v-if="lookuser"><span style="color:blue; font-weight: 700">Đang hoạt động</span></p>
                                <p v-else><span class="active"
                                                style=" color:#DC0101 ;font-weight: 700;">Ngừng hoạt động</span></p>
                            </td>
                            <td class="text-center">
                                <a title="Thông tin" v-on:click="InfoData()"><i class="fa fa-info"
                                                                                aria-hidden="true"></i></a>
                                <a v-if="lookuser" title="Khóa" v-on:click="Khoa()"><i class="fa fa-lock"
                                                                                       aria-hidden="true"></i></a>
                                <a v-else title="Mở khóa" v-on:click="Khoa()"><i class="fa fa-unlock-alt"
                                                                                 aria-hidden="true"></i></a>
                                <a title="Chỉnh sửa" v-on:click="showEditSyncData()"><i class="far fa-edit"></i></a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <!--                    thông tin cấu hình-->
                    <div id="modal_info_data" ref="modal_info_data" class="modal fade">
                        <div class="modal-dialog" style="width: 50%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                            v-on:click="close()">
                                        &times;
                                    </button>
                                    <h3 class="modal-title text-uppercase">Thông Tin Chi Tiết</h3>
                                </div>
                                <div class="modal-body" style="width: 90%;margin: 0 auto; font-size: 18px">
                                    <div class="row student-info">
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-4">Trường học:</div>
                                                <div class="col-md-8">Trường Mầm non Việt Lâm</div>
                                                <div class="col-md-4">Từ năm học:</div>
                                                <div class="col-md-8">2019</div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="row">
                                                <div class="col-md-4">Trạng thái:</div>
                                                <div class="col-md-8">Đang hoạt động</div>
                                                <div class="col-md-4">Tới năm học:</div>
                                                <div class="col-md-8">2019</div>
                                            </div>
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
                    <!--                    -->
                    <!--                    thêm mới cấu hình đồng bộ dữ liệu cũ-->
                    <div id="modal_sync_old" ref="modal_sync_old" class="modal fade">
                        <div class="modal-dialog" style="width: 80%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                            v-on:click="close()">
                                        &times;
                                    </button>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h3 class="modal-title text-uppercase">THÊM MỚI THÔNG TIN</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-body" style="width: 100%;margin: 0 auto;">
                                    <div class="row student-info">
                                        <div class="panel-body">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Mã tiêu chí</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input
                                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                                            style="width:100%"
                                                            type="text"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Tên tiêu chí</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input
                                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                                            style="width:100%"
                                                            type="text"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Cấp học</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="w20">
                                                            <input type="checkbox"> Nhà trẻ
                                                        </div>
                                                        <div class="w20">
                                                            <input type="checkbox"> Mẫu giáo
                                                        </div>
                                                        <div class="w20">
                                                            <input type="checkbox"> Tiểu học
                                                        </div>
                                                        <div class="w20">
                                                            <input type="checkbox"> THCS
                                                        </div>
                                                        <div class="w20">
                                                            <input type="checkbox"> THPT
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Loại đối tượng</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select
                                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                                            style="width:100%">
                                                            <option value="">--Nhà vệ sinh--</option>
                                                            <option value="">--Phòng tập--</option>
                                                            <option value="">--Thiết bị giảng dạy--</option>
                                                            <option value="">--Thư viện--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="w125"><label>Mô tả:</label></div>
                                                <div class="w875">
                                                    <textarea class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                        <div class="col-md-3">
                                                            <label>Loại dữ liệ</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select
                                                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                                            style="width:100%">
                                                            <option value="">--Chọn loại dữ liệu--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Trạng thái</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select
                                                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                                            style="width:100%">
                                                            <option value="">--Tất cả--</option>
                                                            <option value="">--Đang hoạt động--</option>
                                                            <option value="">--Ngừng hoạt động--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer clearfix">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                                    </button>
                                    <button type="button" v-on:click="createDataCriteria()" class="btn btn-primary">
                                        Thêm
                                    </button>
                                </div>
                            </div>


                        </div>

                    </div>
                    <!--                    -->
                    <!--                    chỉnh sửa-->

                    <div id="modal_sync_edit" ref="modal_sync_edit" class="modal fade">
                        <div class="modal-dialog" style="width: 70%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                            v-on:click="close()">
                                        &times;
                                    </button>
                                    <div class="row">
                                        <div class="col-md-7">
                                            <h3 class="modal-title text-uppercase">
                                                CẤU HÌNH ĐỒNG BỘ DỮ LIỆU</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-body" style="width: 100%;margin: 0 auto;">
                                    <div class="row student-info">
                                        <div class="panel-body">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Mã tiêu chí</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input
                                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                                            style="width:100%"
                                                            type="text"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Tên tiêu chí</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <input
                                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                                            style="width:100%"
                                                            type="text"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Cấp học</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <div class="w20">
                                                            <input type="checkbox"> Nhà trẻ
                                                        </div>
                                                        <div class="w20">
                                                            <input type="checkbox"> Mẫu giáo
                                                        </div>
                                                        <div class="w20">
                                                            <input type="checkbox"> Tiểu học
                                                        </div>
                                                        <div class="w20">
                                                            <input type="checkbox"> THCS
                                                        </div>
                                                        <div class="w20">
                                                            <input type="checkbox"> THPT
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Loại đối tượng</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select
                                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                                            style="width:100%">
                                                            <option value="">--Nhà vệ sinh--</option>
                                                            <option value="">--Phòng tập--</option>
                                                            <option value="">--Thiết bị giảng dạy--</option>
                                                            <option value="">--Thư viện--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="w125"><label>Mô tả:</label></div>
                                                <div class="w875">
                                                    <textarea class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Loại dữ liệ</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select
                                                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                                            style="width:100%">
                                                            <option value="">--Chọn loại dữ liệu--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <label>Trạng thái</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select
                                                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                                            style="width:100%">
                                                            <option value="">--Tất cả--</option>
                                                            <option value="">--Đang hoạt động--</option>
                                                            <option value="">--Ngừng hoạt động--</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer clearfix">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                                    </button>
                                    <button type="button" v-on:click="showUpdateSyncData()" class="btn btn-primary">
                                        Chỉnh sửa
                                    </button>
                                </div>
                            </div>


                        </div>

                    </div>

                    <import-file :show="showImportFile" @success="onImportData($event)"
                                 @close="showImportFile=false"></import-file>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueAlertify from 'vue-alertify';
    import Import from './ImportFile';
    import utils from '../../utils'

    Vue.use(VueAlertify);
    export default {
        components: {
            'import-file': Import,
        },
        data() {
            return {
                lookuser: false,
                showImportFile:false,
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
            createDataCriteria() {
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

            },
            showImportData() {
                console.log("Hiển thị form tải file");
                $('#modal_import_file').modal();
                this.showImportFile = true;
            },
            onImportData() {
                this.$alertify.success('Tải lên thành công thành công.');
            }
        }
    }
</script>
<style scoped>
    th, td {
        text-align: center;
    }
    .w125{
        width: 12.5%;
        float: left;
    }
    .w875{
        width: 87.5%;
        float: left;
    }
    .col-md-12{
        padding-bottom:15px;
    }
    .abc {
        padding-bottom: 25px;
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

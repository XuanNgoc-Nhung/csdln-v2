<template>
    <div>
        <div>
            <div class="row criteria-title" style="margin: 0 auto; width:80%;">
                <h5>TIÊU CHÍ TÌM KIẾM </h5>
            </div>
            <div class="row text-center">
                <div class="panel-body" style="width:70%; margin:0 auto;">
                    <div class="col-md-5">
                        <div class="row">
                            <div class="col-md-4">
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
                            <div class="col-md-4">
                                <label>Trạng thái</label>
                            </div>
                            <div class="col-md-8">
                                <select
                                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                    <option value="">--Chọn trạng thái--</option>
                                    <option value="">--Đang hoạt động--</option>
                                    <option value="">--Ngừng hoạt động--</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">

                        <a href="" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</a>
                    </div>
                </div>
            </div>
            <div style="background: #ddd;height: 20px;"></div>
            <div class="responsive" style="margin-top:20px;">
                <div class="row" style="padding:10px">
                    <div class="col-md-6">
                        <h3 style="padding:0; margin:0">Thống kê nhà trẻ</h3>
                    </div>
                    <div class="col-md-6">
                        <div class="pull-right">
                            <button class="btn btn-primary" v-on:click="ShowCreatReport()"><i class="fa fa-plus"
                                                                                              aria-hidden="true"></i>
                                Thêm</button>
                        </div>
                    </div>
                </div>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr style="background: #e4ebf5; text-align:center">
                        <th>STT</th>
                        <th>Tên báo cáo</th>
                        <th>Trạng thái</th>
                        <th>Ngày áp dụng</th>
                        <th>Ngày kết thúc</th>
                        <th>Số tiêu chí tổng hợp</th>
                        <th>Thao tác</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>Tên báo cáo</td>
                        <td>Đang hoạt động</td>
                        <td>21/12/2012</td>
                        <td>21/12/2013</td>
                        <td>21</td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
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


        <div id="modal_create_report" ref="modal_create_report" class="modal fade">
            <div class="modal-dialog" style="width: 70%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                                v-on:click="close()">
                            &times;
                        </button>
                        <h3 class="modal-title text-uppercase">THÊM MỚI THÔNG TIN</h3>
                    </div>
                    <div class="modal-body" style="width: 90%;margin: 0 auto; font-size: 18px">
                        <div class="row">
                            <div class="row" style="padding-bottom:20px;">
                                <div class="col-md-2">
                                    <span>Tên báo cáo </span>
                                </div>
                                <div class="col-md-4">
                                    <input
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                                <div class="col-md-2">
                                    <span>Trạng thái</span>
                                </div>
                                <div class="col-md-4">
                                    <select
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Đang hoạt động--</option>
                                        <option value="">--Ngừng hoạt động--</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row" style="padding-bottom:20px;">
                                <div class="col-md-2">
                                    <span>Cấp áp dụng</span>
                                </div>
                                <div class="col-md-10">
                                    <input type="checkbox"><span>Phòng</span>
                                    <input type="checkbox"><span>Nhà trẻ</span>
                                    <input type="checkbox"><span>Mẫu giáo</span>
                                    <input type="checkbox"><span>Mầm non</span>
                                    <input type="checkbox"><span>Tiểu học</span>
                                    <input type="checkbox"><span>THCS</span>
                                    <input type="checkbox"><span>PTCS</span>
                                    <input type="checkbox"><span>THPT</span>
                                    <input type="checkbox"><span>PTTH</span>
                                    <input type="checkbox"><span>Phổ thông</span>
                                    <input type="checkbox"><span>GDTX</span>
                                </div>
                            </div>
                            <div class="row" style="padding-bottom:20px;">
                                <div class="col-md-2">
                                    <span>Ngày áp dụng </span>
                                </div>
                                <div class="col-md-4">
                                    <input
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="date"/>
                                </div>
                                <div class="col-md-2">
                                    <span>Ngày kết thúc</span>
                                </div>
                                <div class="col-md-4">
                                    <input
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="date"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">File biểu mẫu</div>
                                <div class="col-md-10">
                                    <label class="btn btn-default button-file btn-file" tabindex="0" id="lblFile">
                                        <i class="fa fa-cloud-upload"></i> Lựa chọn file Excel
                                        <br>
                                        <small class="text-primary"><em>Tổng dung lượng không quá 10MB</em></small>
                                        <br>
                                        <small class="text-secondary"><em>Định dạng file hợp lệ: *.xlsx </em>
                                        </small>
                                        <input ng-disabled="readonly" ngf-select="addFile(anhTheFile)"
                                               ng-model="anhTheFile" ngf-max-size="10MB" ngf-pattern="'image/*'"
                                               accept="image/png, image/jpeg" name="anhTheFile" type="file"
                                               style="display:none" ngf-valid-only="true" ngf-multiple="false"
                                               class="ng-pristine ng-untouched ng-valid ng-empty" aria-invalid="false">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr style="margin:0">
                    <div class="modal-body" style="width: 90%;margin: 0 auto; font-size: 18px">
                        <a href="#" v-on:click.prevent="showhuongdan=!showhuongdan"> <i class="fas" v-if="showhuongdan">Ẩn hướng dẫn</i> <i v-else class="fas" > Xem hướng dẫn</i></a>
                        <div v-if="showhuongdan">
                            <h5>HƯỚNG DẪN SỬ DỤNG CHO UPLOAD FILE BIỂU MẪU HỢP LỆ  </h5>
                            <p><b>1. File Excel hợp lệ</b></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>- Dữ liệu hợp lệ được tính theo hàng cột từ A đến ZZ và đến 1000 dòng</p></div>
                                <div class="col-md-6">
                                    <p>- Ngoài vùng trên hệ thống phần mềm không kiểm soát được dữ liệu.</p></div>
                            </div>
                            <p><b>2. Đánh dấu tiêu chí ở trên file excel</b></p>
                            <div class="row">
                                <div class="col-md-6">
                                    <p>- Bôi vàng các tiêu chi hay nội dung cần tổng hợp</p></div>
                                <div class="col-md-6">
                                    <p>- Chọn đúng màu VÀNG mặc định của Excel thì hệ thống mới nhận biết được. </p>
                                </div>
                            </div>

                            <p>Các màu vàng không phải mặc định hoặc màu sắc khác thì hệ thống sẽ không nhận dạng được</p>
                            <img src="http://csdl.edu.vn/content/images/hdsd-tk-bieu-mau.png" style="width:200px;" alt="">
                            <p><b>3. Kiểm tra các tiêu chi cần tổng hợp đã chuẩn chưa</b></p>
                            <p>- Sau khi chọn file biểu mẫu, nhấn nút Xem trước, màn hình sẽ hiển thị nội dung file biểu mẫu, các ô cần tổng hợp sẽ chuyển màu nền sang màu đỏ</p>

                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                        </button>
                        <button type="button" v-on:click="CreateReport()" class="btn btn-primary">Thêm</button>
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
            return {
                showhuongdan:false,
            }
        },
        methods: {
            ShowReport() {
                console.log("Xem thông tin");
                $("#modal_show_info").modal();
            },
            ShowCreatReport() {
                console.log("Xem thông tin");
                $("#modal_create_report").modal();
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
            },
            CreateReport(){
                console.log("Thêm mới báo cáo");
                utils.confirmDialog("Xác nhận thêm mới?", "Xác nhận", () => {
                    this.$alertify.success('Thêm mới thành công.');
                })
            }
        }
    }
</script>
<style scoped>
    th {
        text-align: center;
    }

    .col-md-10 span {
        padding-right: 10px;
    }

    .button-file {
        background-color: #aedaa6;
    }

    #modal_create_report p {
        font-size: 12px;
    }
</style>

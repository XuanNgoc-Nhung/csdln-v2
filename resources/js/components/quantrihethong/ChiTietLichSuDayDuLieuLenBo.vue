<template>
    <div id="modal_chitiet_lichsu_daydulieu_len_bo" ref="modal_chitiet_lichsu_daydulieu_len_bo" class="modal fade">
        <div class="modal-dialog" style="width: 80%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase" style="padding: 0 15px;">chi tiết lịch sử đẩy dữ liệu lên bộ</h4>
                </div>
                <div class="modal-body clearfix">
                    <div style="padding-top: 10px;">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label>Tên trường học : </label>
                                <span>{{ChiTiet.tenTruongHoc}}</span>
                            </div>
                            <div class="col-sm-4">
                                <label>Tên đối tác : </label>
                                <span>{{ChiTiet.tenDoiTac}}</span>
                            </div>
                            <div class="col-sm-4">
                                <label>Trạng thái : </label>
                                <span v-if="ChiTiet.trangThaiHienTai == 1">Đang đẩy</span>
                                <span v-if="ChiTiet.trangThaiHienTai == 2">Đã đẩy - Đang chờ xử lý</span>
                                <span v-if="ChiTiet.trangThaiHienTai == 3">Hoàn thành</span>
                                <span v-if="ChiTiet.trangThaiHienTai == 4">Đẩy thất bại</span>
                            </div>

                        </div>
                    </div>
                    <div style="padding-top: 10px;">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label>Năm học : </label>
                                <span>{{ChiTiet.namHoc}}</span>
                            </div>
                            <div class="col-sm-4">
                                <label>Loại đẩy : </label>
                                <span v-if="ChiTiet.loaiDay == 1">Đầu năm</span>
                                <span v-if="ChiTiet.loaiDay == 2">Phát sinh</span>
                                <span v-if="ChiTiet.loaiDay == 3">Năm cũ</span>
                            </div>

                        </div>
                    </div>
                    <div class="row list_user" style=" margin: auto; padding: 0 15px;">
                        <div class="responsive" style="margin-top:30px;">
                            <div class="xembaocao form-group clearfix">
                                <table class="table table-bordered table-striped table-hover">
                                <thead>
                                <tr style="background: #e4ebf5">
                                    <th>STT bước</th>
                                    <th>Tên bước</th>
                                    <th>Trạng thái</th>
                                    <th>Tổng số bản ghi</th>
                                    <th>Thời gian bắt đầu</th>
                                    <th>Thời gian kết thúc</th>
                                    <th>Service Url</th>
                                    <th>MessageId</th>
                                    <th>Error description</th>
                                    <th>Error</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(list,index) in ChiTiet.listDetail">
                                    <td>{{index+1}}</td>
                                    <td>
                                        <p v-if="list.buocHienTai == 1">TTHS</p>
                                        <p v-if="list.buocHienTai == 2">TTGV</p>
                                        <p v-if="list.buocHienTai == 3">TT Lớp</p>
                                        <p v-if="list.buocHienTai == 4">KQ học tập</p>
                                        <p v-if="list.buocHienTai == 5">Xét tốt nghiệp</p>
                                    </td>
                                    <td>
                                        <p v-if="list.trangThaiBuocHienTai == 1">Đang đẩy</p>
                                        <p v-if="list.trangThaiBuocHienTai == 2">Đã đẩy - Đang chờ xử lý</p>
                                        <p v-if="list.trangThaiBuocHienTai == 3">Hoàn thành</p>
                                        <p v-if="list.trangThaiBuocHienTai == 4">Đẩy thất bại</p>
                                    </td>
                                    <td>{{list.totalRecord}}</td>
                                    <td>{{list.timeStart}}</td>
                                    <td>{{list.timeEnd}}</td>
                                    <td>{{list.serviceUrl}}</td>
                                    <td>{{list.messId}}</td>
                                    <td>{{list.errDescr}}</td>
                                    <td>{{list.err}}</td>

                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
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

    export default {
        props: ['item', 'show'],

        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    // this.reset();
                    $("#modal_chitiet_lichsu_daydulieu_len_bo").modal();
                } else {
                    $("#modal_chitiet_lichsu_daydulieu_len_bo").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                if (newVal != null) {
                    this.ChiTiet=newVal;
                    console.log("dữ liệu chi tiết:" + JSON.stringify(this.ChiTiet));
                } else {
                }
            }
        },
        data(){
            return {
                ChiTiet:{},
                start: 0,
                limit: 25,
                currentPage: 1,
            }
        },
        mounted() {
            $(this.$refs.modal_chitiet_lichsu_daydulieu_len_bo).on("hidden.bs.modal", this.close);
        },
        methods:{
            reset() {
                this.ChiTiet=null;
            },

            close() {
                console.log("close modal");
                // this.reset();
                this.$emit('close');
            },
        }

    }
</script>
<style scoped>
    label,span{
         font-size: 12px;
     }
    .xembaocao{
        max-height: 300px;
        overflow: scroll;
    }
</style>
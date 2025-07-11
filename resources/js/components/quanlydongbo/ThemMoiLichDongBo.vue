<template>

    <div id="modal_create_sync" ref="modal_create_sync" class="modal fade">
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
                                    <date-picker v-model="namHoc" :config="configYear"
                                                 placeholder="Chọn ngày "></date-picker>
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
                            <date-picker v-model="dauNamTuNgay" :config="configDate"
                                         placeholder="Chọn ngày "></date-picker>
                        </div>
                        <div class="col-md-2">Ngày kết thúc</div>
                        <div class="col-md-4">
                            <date-picker v-model="dauNamToiNgay" :config="configDate"
                                         placeholder="Chọn ngày "></date-picker>
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
                                <tr v-for="(slps,index) in ycDbdlPhatSinhList">
                                    <td>{{index}}</td>
                                    <td>
                                        <date-picker v-model="slps.ngayBatDau" :config="configDate"
                                                     placeholder="Chọn ngày "></date-picker>
                                    </td>
                                    <td>
                                        <date-picker v-model="slps.ngayKetThuc" :config="configDate"
                                                     placeholder="Chọn ngày "></date-picker>
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
                            <date-picker v-model="cuoiNamTuNgay" :config="configDate"
                                         placeholder="Chọn ngày "></date-picker>
                        </div>
                        <div class="col-md-2">Ngày kết thúc</div>
                        <div class="col-md-4">
                            <date-picker v-model="cuoiNamToiNgay" :config="configDate"
                                         placeholder="Chọn ngày "></date-picker>
                        </div>
                        <div class="row" style="text-align:center">
                            <span style="font-size: 12px; font-weight: 300; text-align:center"><i>Dữ liệu cuối năm bao gồm các dữ liệu: Điểm tổng kết, tổng kết học sinh</i></span>
                        </div>
                    </div>
                    <div class="row" style="padding-top:30px;">
                        <p><span style="font-weight: 700;">Lưu ý:</span> Cấu hình đồng bộ dữ liệu áp dụng cho tất cả các
                            trường.</p>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="createEmail()" class="btn btn-primary">Thêm</button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>

    $(document).ready(function () {
        console.log("ready!");
    });

    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'
    import api from '../api';

    Vue.use(VueAlertify);
    export default {

        components: {
            datePicker,
        },
        props: ['item', 'show'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_create_sync").modal();
                } else {
                    $("#modal_create_sync").modal('hide');
                }
            }
        },
        data() {
            return {
                student_code: '',
                cuoiNamToiNgay: '',
                cuoiNamTuNgay: '',
                dauNamToiNgay: '',
                dauNamTuNgay: '',
                namHoc: '',
                date: new Date(),
                configDate: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                configYear: {
                    format: 'YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                ycDbdlPhatSinhList: [
                    {
                        ngayBatDau: '',
                        ngayKetThuc: ''
                    }
                ],
            }
        },
        mounted: function () {
            $(this.$refs.modal_create_sync).on("hidden.bs.modal", this.close);
        },
        methods: {
            createEmail() {
                utils.confirmDialog("Bạn có muốn thêm dữ liệu này?", "Thêm", () => {

                    const uri = "/api_them_lich_dong_bo";
                    const params = {
                        cuoiNamToiNgay: this.cuoiNamToiNgay,
                        cuoiNamTuNgay: this.cuoiNamTuNgay,
                        dauNamToiNgay: this.dauNamToiNgay,
                        dauNamTuNgay: this.dauNamTuNgay,
                        namHoc: this.namHoc,
                        ycDbdlPhatSinhList: this.ycDbdlPhatSinhList,
                    };
                    console.log("Thêm mới lịch đồng bộ");
                    api.post(uri, params, (response) => {
                        console.log("status trả về");
                        console.log(JSON.stringify(response));
                        if (response.status === 200) {
                            utils.showDialog("Thông báo", "Thêm cấu hình lịch đồng bộ thành công", null, () => {
                                this.$emit('success');
                                this.close();
                            });
                        } else {
                            utils.showDialog("Thất bại", response.data.message, null, () => {
                            });
                        }
                    });
                })
            },

            close() {
                console.log("Đóng modal");
                this.$emit('close');
            },
            addDLPS() {
                console.log("thêm hàng mới");
                this.ycDbdlPhatSinhList.push({});
            },
            DellDLPS(index) {
                console.log(index);
                this.ycDbdlPhatSinhList.splice(index, 1)
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

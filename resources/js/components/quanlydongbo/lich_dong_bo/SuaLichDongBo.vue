<template>
    <div id="modal_update_sync" ref="modal_update_sync" class="modal fade">
        <div class="modal-dialog" style="width: 85%">
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="close()">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-md-7">
                            <h3 class="modal-title text-uppercase">
                                CHỈNh sửa CẤU HÌNH ĐỒNG BỘ DỮ LIỆU</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right;">
                                    <span style="font-size:18px;padding-top:7px;">Năm học:</span>
                                </div>
                                <div class="col-md-8">
                                    <div class="col-md-8">
                                        <select disabled="disabled" class="form-control" v-model="namHoc">
                                            <option value=''>Chọn năm học</option>
                                            <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body" style="width: 90%;margin: 0 auto; font-size: 18px">

                    <div class="row">
                        <div class="col-lg-3">
                            <label class="pull-right">Dữ liệu đầu năm:</label>
                        </div>
                        <div class="col-lg-4">
                            <label>Ngày bắt đầu</label>
                            <date-picker
                                :config="configDatePicker"
                                placeholder="Từ ngày"
                                ref="start_dau_nam"
                                v-model="start_dau_nam"
                                @dp-change=""></date-picker>
                            <em class="required_t">{{errors.start_dau_nam}}</em>
                        </div>
                        <div class="col-lg-4">
                            <label>Ngày kết thúc</label>
                            <date-picker
                                :config="configDatePicker"
                                placeholder="Đến ngày"
                                ref="end_dau_nam"
                                v-model="end_dau_nam"
                                @dp-change=""></date-picker>
                            <em class="required_t">{{errors.end_dau_nam}}</em>
                        </div>
                    </div>
                    <div class="row row_tp">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-9">
                            <em style="color: gray">Dữ liệu đầu năm bao gồm các dữ liệu về: Học sinh, lớp học, phân công giáo viên</em>
                        </div>
                    </div>

                    <div class="row row_tp">
                        <div class="col-lg-3">
                            <label class="pull-right">Dữ liệu phát sinh:</label>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-sm-3">
                                    <span class="pull-right">STT</span>
                                </div>
                                <div class="col-sm-3">
                                    Từ ngày
                                </div>
                                <div class="col-sm-3">
                                    Đến ngày
                                </div>
                                <div class="col-sm-3">
                                    Thao tác
                                </div>
                            </div>
                            <div
                                class="row row_tp"
                                v-for="(k, index) in list_du_lieu_phat_sinh"
                                :key="k.id">
                                <div class="col-sm-3">
                                    <label class="pull-right lbl_field">
                                        {{index+1}}
                                        <!-- {{k.ngayBatDau}}-->
                                        <!-- {{k.ngayKetThuc}}-->
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <date-picker
                                        :config="configDatePicker"
                                        placeholder="Từ ngày"
                                        ref="ngayBatDau"
                                        v-model="k.ngayBatDau"
                                        @dp-change=""></date-picker>
                                    <!-- <em class="required_t">{{k.errors.ngayBatDau}}</em>-->
                                </div>
                                <div class="col-sm-3">
                                    <date-picker
                                        :config="configDatePicker"
                                        placeholder="Đến ngày"
                                        ref="ngayKetThuc"
                                        v-model="k.ngayKetThuc"
                                        @dp-change=""></date-picker>
                                    <!-- <em class="required_t">{{k.errors.ngayKetThuc}}</em>-->
                                </div>
                                <div class="col-sm-3">
                                    <button
                                        class="btn btn-danger"
                                        @click.prevent="list_du_lieu_phat_sinh.splice(index,1)">Xóa
                                    </button>
                                </div>
                            </div>
                            <button @click.prevent="onBtnAddNewPhatSinh" class="btn btn-success">Thêm</button>
                        </div>
                    </div>
                    <div class="row row_tp">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-9">
                            <em style="color: gray">Dữ liệu phát sinh bao gồm các dữ liệu: Điểm, học sinh
                                chuyển lớp, học sinh chuyển trường, học sinh bỏ học</em>
                        </div>
                    </div>

                    <div class="row row_tp">
                        <div class="col-lg-3">
                            <label class="pull-right">Dữ liệu cuối năm:</label>
                        </div>
                        <div class="col-lg-4">
                            <label>Ngày bắt đầu</label>
                            <date-picker
                                :config="configDatePicker"
                                placeholder="Từ ngày"
                                ref="start_cuoi_nam"
                                v-model="start_cuoi_nam"
                                @dp-change=""></date-picker>
                            <em class="required_t">{{errors.start_cuoi_nam}}</em>
                        </div>
                        <div class="col-lg-4">
                            <label>Ngày kết thúc</label>
                            <date-picker
                                :config="configDatePicker"
                                placeholder="Đến ngày"
                                ref="end_cuoi_nam"
                                v-model="end_cuoi_nam"
                                @dp-change=""></date-picker>
                            <em class="required_t">{{errors.end_cuoi_nam}}</em>
                        </div>
                    </div>
                    <div class="row row_tp">
                        <div class="col-lg-3"></div>
                        <div class="col-lg-9">
                            <em style="color: gray">Dữ liệu cuối năm bao gồm các dữ liệu: Điểm tổng kết, tổng kết học sinh</em>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button class="btn btn-success" @click.prevent="onBtnAddClick">Sửa</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
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

    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import VueAlertify from 'vue-alertify';
    // import utils from './../../../utils'
    import constant from "../../../utils/constant";
    import api from './../../api';

    import m_util from '../../../utils/m_utils';
    import rest_api from '../../../utils/rest_api';
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {

        components: {
            datePicker
        },
        props: [
            'item', 'show'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_update_sync").modal();
                } else {
                    $("#modal_update_sync").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                console.log("Chỉnh sửa:" + JSON.stringify(newVal));
                this.idDuLieu = newVal.id;
                this.getDuLieuPhatSinh();

            }
        },
        data() {
            return {
                list_years: constant.LIST_YEARS_FULL,

                errors: {
                    start_dau_nam: "",
                    end_dau_nam: "",
                    start_cuoi_nam: "",
                    end_cuoi_nam: ""
                },

                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },

                configYear: {
                    format: 'YYYY',
                    useCurrent: false,
                    showTodayButton: false,
                    locale: 'vi'
                },
                namHoc: '',

                start_dau_nam: null,
                end_dau_nam: null,

                start_cuoi_nam: null,
                end_cuoi_nam: null,

                list_du_lieu_phat_sinh: []
            }
        },
        mounted: function () {
            $(this.$refs.modal_update_sync).on("hidden.bs.modal", this.close);
            console.log("yyyyyyy" + this.idDuLieu);
        },

        methods: {

            getDuLieuPhatSinh() {

                let params = {
                    "id": this.idDuLieu
                };
                let url = "/csdlgd-admin/yeuCauDongBo";

                rest_api.get(url, params, (response) => {
                    if (response.data.rc === 0) {
                        this.list_du_lieu_phat_sinh = response.data.item.ycDbdlPhatSinhList;
                        console.log("Dữ liệu phát sinh:" + JSON.stringify(this.list_du_lieu_phat_sinh));
                        this.namHoc = response.data.item.namHoc;
                        this.start_dau_nam = response.data.item.dauNamTuNgay;
                        this.start_cuoi_nam = response.data.item.cuoiNamTuNgay;
                        this.end_dau_nam = response.data.item.dauNamToiNgay;
                        this.end_cuoi_nam = response.data.item.cuoiNamToiNgay;

                    }
                });
            },
            checkInputArray() {
                this.resetArrayInput();
                for (let i = 0; i < this.list_du_lieu_phat_sinh.length; i++) {
                    if (!m_util.checkString(this.list_du_lieu_phat_sinh[i].ngayBatDau)) {
                        this
                            .list_du_lieu_phat_sinh[i]
                            .errors
                            .ngayBatDau = "Vui lòng chọn thời gian bắt đầu";
                        this
                            .$refs
                            .ngayBatDau[i]
                            .$el
                            .focus();
                        return false;
                    }
                    if (!m_util.checkString(this.list_du_lieu_phat_sinh[i].ngayKetThuc)) {
                        this
                            .list_du_lieu_phat_sinh[i]
                            .errors
                            .ngayKetThuc = "Vui lòng chọn thời gian kết thúc";
                        this
                            .$refs
                            .ngayKetThuc[i]
                            .$el
                            .focus();
                        return false;
                    }
                }
                return true;
            },

            onBtnAddNewPhatSinh() {

                if (!this.checkInputArray()) {
                    return;
                }

                let obj = {
                    // id: m_util.id(),
                    ngayBatDau: null,
                    ngayKetThuc: null,
                    // errors: {     ngayBatDau: "",     ngayKetThuc: "", }
                };
                this
                    .list_du_lieu_phat_sinh
                    .push(obj);
            },

            onBtnBackClick() {
                this.$emit("callback", 0);
            },

            resetArrayInput() {
                for (let i = 0; i < this.list_du_lieu_phat_sinh.length; i++) {
                    // this.list_du_lieu_phat_sinh[i].errors = {     ngayBatDau: "",
                    // ngayKetThuc: "", }
                }
            },

            resetError() {
                this.errors = {
                    start_dau_nam: "",
                    end_dau_nam: "",
                    start_cuoi_nam: "",
                    end_cuoi_nam: ""
                };
                this.resetArrayInput();
            },

            onBtnAddClick() {

                this.resetError();
                if (!m_util.checkString(this.start_dau_nam)) {
                    this.errors.start_dau_nam = "Vui lòng chọn thời gian bắt đầu";
                    this
                        .$refs
                        .start_dau_nam
                        .$el
                        .focus();
                    return;
                }

                if (!m_util.checkString(this.end_dau_nam)) {
                    this.errors.end_dau_nam = "Vui lòng chọn thời gian kết thúc";
                    this
                        .$refs
                        .end_dau_nam
                        .$el
                        .focus();
                    return;
                }

                if (!this.checkInputArray()) {
                    return;
                }

                if (!m_util.checkString(this.start_cuoi_nam)) {
                    this.errors.start_cuoi_nam = "Vui lòng chọn thời gian bắt đầu";
                    this
                        .$refs
                        .start_cuoi_nam
                        .$el
                        .focus();
                    return;
                }

                if (!m_util.checkString(this.end_cuoi_nam)) {
                    this.errors.end_cuoi_nam = "Vui lòng chọn thời gian kết thúc";
                    this
                        .$refs
                        .end_cuoi_nam
                        .$el
                        .focus();
                    return;
                }

                let ds = [];
                for (let i = 0; i < this.list_du_lieu_phat_sinh.length; i++) {
                    ds.push({
                        ngayBatDau: this
                            .list_du_lieu_phat_sinh[i]
                            .ngayBatDau,
                        ngayKetThuc: this
                            .list_du_lieu_phat_sinh[i]
                            .ngayKetThuc
                    })
                }

                confirmDialog("Bạn muốn chỉnh sửa lịch đồng bộ này chứ ?", "Sửa", () => {
                    let params = {
                        "id": this.idDuLieu,
                        "cuoiNamToiNgay": this.end_cuoi_nam,
                        "cuoiNamTuNgay": this.start_cuoi_nam,
                        "dauNamToiNgay": this.end_dau_nam,
                        "dauNamTuNgay": this.start_dau_nam,
                        "namHoc": this.namHoc,
                        "ycDbdlPhatSinhList": this.list_du_lieu_phat_sinh
                    };
                    let url = "chinh-sua-lich-dong-bo";
                    api.post(url, params, (data) => {
                        console.log("res: " + JSON.stringify(data.data));
                        let msg = m_util.getMessageResponse(
                            data,
                            "Chỉnh sửa lịch đồng bộ thành công",
                            "nội dung mess"
                        );
                        showDialog("Thông báo", msg, null, () => {
                            if (parseInt(data.data.rc) === 0) {
                                this.$emit("success");
                                this.close();
                            }
                        }, null);
                    });
                });
            },

            close() {
                this.reset();
                this.$emit('close');
            },
            reset() {
                console.log("reset lại form");
                this.errors = {
                    start_dau_nam: "",
                    end_dau_nam: "",
                    start_cuoi_nam: "",
                    end_cuoi_nam: ""
                };
                this.resetArrayInput();

            }
        }
    }
</script>

<style scoped="scoped">
    th {
        text-align: center;
    }

    td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
</style>

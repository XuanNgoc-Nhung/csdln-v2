<template>
    <div id="modal_create_sync" ref="modal_create_sync" class="modal fade">
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
                                CẤU HÌNH ĐỒNG BỘ DỮ LIỆU</h3>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4" style="text-align: right;">
                                    <span style="font-size:18px;padding-top:7px;">Năm học:</span>
                                </div>
                                <div class="col-md-8">
                                    <multiselect
                                        v-model="danhSachNamHoc"
                                        :options="list_years"
                                        :custom-label="setNameNamHoc"
                                        placeholder="Chọn năm học"
                                        label="name"
                                        deselectLabel="Đã chọn"
                                        selectLabel="Chưa chọn"
                                        selectedLabel="Đã chọn"
                                        track-by="name"></multiselect>
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
                            <label>Ngày bắt đầu:</label>
                            <date-picker
                                :config="configDatePicker"
                                placeholder="Từ ngày"
                                ref="start_dau_nam"
                                v-model="start_dau_nam"
                                @dp-change="ChonNgayDauNamBatDau"></date-picker>
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
                                    </label>
                                </div>
                                <div class="col-sm-3">
                                    <date-picker
                                        :config="configDatePicker"
                                        placeholder="Từ ngày"
                                        ref="ngayBatDau"
                                        v-model="k.ngayBatDau"
                                        @dp-change="BatDauPhatSinh(k)"></date-picker>
                                    <em class="required_t">{{k.errors.ngayBatDau}}</em>
                                </div>
                                <div class="col-sm-3">
                                    <date-picker
                                        :config="configDatePicker"
                                        placeholder="Đến ngày"
                                        ref="ngayKetThuc"
                                        v-model="k.ngayKetThuc"
                                        @dp-change=""></date-picker>
                                    <em class="required_t">{{k.errors.ngayKetThuc}}</em>
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
                                @dp-change="ChonNgayCuoiNamBatDau"></date-picker>
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
                    <button class="btn btn-success" @click.prevent="onBtnAddClick">Thêm lịch</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                </div>
            </div>

        </div>

    </div>

</template>

<script>
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import VueAlertify from 'vue-alertify';
    import Multiselect from 'vue-multiselect'
    import m_util from '../../../utils/m_utils';
    import rest_api from '../../../utils/rest_api';
    import constant from "../../../utils/constant";
    import timeutils from '../../../utils/time_utils';
    import moment from 'moment';
    import array_util from '../../../utils/array_utils';
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {

        components: {
            Multiselect,
            datePicker
        },
        props: [
            'item', 'show'
        ],
        watch: {
            danhSachNamHoc: function (newVal) {
                this.namHoc = "";
                if (newVal) {
                    this.namHoc = newVal.id;
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                }
            },
        },
        data() {
            return {
                date: new Date(),

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
                namHocHienTai: '',
                danhSachNamHoc:[],

                list_years: constant.LIST_YEARS_FULL,
                start_dau_nam: null,
                end_dau_nam: null,

                start_cuoi_nam: null,
                end_cuoi_nam: null,

                list_du_lieu_phat_sinh: []
            }
        },
        mounted: function () {
            $("#modal_create_sync").modal();
            $(this.$refs.modal_create_sync).on("hidden.bs.modal", this.close);
            // this.namHoc = this
            //     .date
            //     .getFullYear();

            this.namHocHienTai = this
                .date
                .getFullYear();
            let thangNay = this
                .date
                .getMonth();
            thangNay = parseInt(thangNay) + 1;
            if (thangNay > 8) {
                console.log("tháng > 7");
            } else {
                this.namHocHienTai -= 1;
                console.log("tháng không lớn hơn 7");
            }
            this.findNamHoc();
        },

        methods: {
            // định nghĩa cho năm học
            setNameNamHoc({name}) {
                return `${name}`
            },
            // gán năm học
            findNamHoc() {
                this.namHoc = this.namHocHienTai;
                for (let i = 0; i < this.list_years.length; i++) {
                    if (this.list_years[i].id == this.namHocHienTai) {
                        this.danhSachNamHoc = this.list_years[i];
                    }
                }
            },

            getTime(date) {
                return timeutils.convertTime(new Date(date));
            },
            BatDauPhatSinh(item) {
                item.ngayKetThuc = moment(item.ngayBatDau, 'DD/MM/YYYY')
                    .add(6, 'days')
                    .format('DD/MM/YYYY');
            },

            ChonNgayDauNamBatDau() {
                if (this.start_dau_nam != null) {
                    console.log("đầu năm bắt đầu là:" + this.start_dau_nam);
                    let endDauNam = moment(this.start_dau_nam, 'DD/MM/YYYY')
                        .add(6, 'days')
                        .format('DD/MM/YYYY');
                    this.end_dau_nam = endDauNam;
                    console.log("cuối năm:" + this.end_dau_nam)
                }
            },
            ChonNgayCuoiNamBatDau() {
                if (this.start_cuoi_nam != null) {
                    console.log("cuối năm bắt đầu là:" + this.start_cuoi_nam);
                    let endCuoiNam = moment(this.start_cuoi_nam, 'DD/MM/YYYY')
                        .add(6, 'days')
                        .format('DD/MM/YYYY');
                    this.end_cuoi_nam = endCuoiNam;
                    console.log("cuối năm:" + this.end_cuoi_nam)
                }

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
                    id: m_util.id(),
                    ngayBatDau: null,
                    ngayKetThuc: null,
                    errors: {
                        ngayBatDau: "",
                        ngayKetThuc: ""
                    }
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
                    this
                        .list_du_lieu_phat_sinh[i]
                        .errors = {
                            ngayBatDau: "",
                            ngayKetThuc: ""
                        }
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

                confirmDialog("Bạn muốn thêm lịch đồng bộ này chứ ?", "Thêm", () => {
                    let params = {
                        "cuoiNamToiNgay": this.end_cuoi_nam,
                        "cuoiNamTuNgay": this.start_cuoi_nam,
                        "dauNamToiNgay": this.end_dau_nam,
                        "dauNamTuNgay": this.start_dau_nam,
                        "namHoc": this.namHoc,
                        "ycDbdlPhatSinhList": this.list_du_lieu_phat_sinh
                    };
                    let url = "/csdlgd-admin/yeuCauDongBo";
                    rest_api.post(url, params, (data) => {
                        if(data.data.rc==0){
                            this
                                .$alertify
                                .success("Thêm thành công");
                            this.$emit('success');
                        }
                        else{
                            this
                                .$alertify
                                .error(data.data.rd);
                        }
                        // let msg = m_util.getMessageResponse(
                        //     data,
                        //     "Thêm lịch đồng bộ thành công",
                        //     "Thêm lịch đồng bộ thất bại"
                        // );
                        // showDialog("Thông báo", msg, null, () => {
                        //     if (parseInt(data.data.rc) === 0) {
                        //         this.$emit("success");
                        //         this.close();
                        //         this.reset();
                        //     }
                        // }, null);
                    });
                });
            },

            close() {
                // this.reset();
                this.$emit('close');
            },
            reset() {
                array_util.clearArrays(this.list_du_lieu_phat_sinh);
                this.namHoc = this
                    .date
                    .getFullYear();
                this.start_dau_nam = null;
                this.end_dau_nam = null;
                this.start_cuoi_nam = null;
                this.end_cuoi_nam = null;
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
    @import "../../../../../node_modules/selectwithsearch.css";
    th {
        text-align: center;
    }
    td {
        border: 1px solid black;
        border-collapse: collapse;
        text-align: center;
    }
</style>

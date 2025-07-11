<template>
    <div>
        <div class="row">
            <div class="col-lg-3">
                <label class="pull-right">Dữ liệu đầu năm:</label>
            </div>
            <div class="col-lg-4">
                <label>Ngày bắt đầu</label>
                <date-picker :config="configDatePicker" placeholder="Từ ngày" ref="start_dau_nam"
                             v-model="start_dau_nam" @dp-change=""></date-picker>
                <em class="required_t">{{errors.start_dau_nam}}</em>
            </div>
            <div class="col-lg-4">
                <label>Ngày kết thúc</label>
                <date-picker :config="configDatePicker" placeholder="Đến ngày" ref="end_dau_nam"
                             v-model="end_dau_nam" @dp-change=""></date-picker>
                <em class="required_t">{{errors.end_dau_nam}}</em>
            </div>
        </div>
        <div class="row row_tp">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-9">
                <em style="color: gray">Dữ liệu đầu năm bao gồm các dữ liệu về: Học sinh, lớp học, phân công giáo
                    viên</em>
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
                <div class="row row_tp" v-for="(k, index) in list_du_lieu_phat_sinh" :key="k.id">
                    <div class="col-sm-3">
                        <label class="pull-right lbl_field">
                            {{index+1}}
                        </label>
                    </div>
                    <div class="col-sm-3">
                        <date-picker :config="configDatePicker" placeholder="Từ ngày" ref="start_time"
                                     v-model="k.start_time" @dp-change=""></date-picker>
                        <em class="required_t">{{k.errors.start_time}}</em>
                    </div>
                    <div class="col-sm-3">
                        <date-picker :config="configDatePicker" placeholder="Đến ngày" ref="end_time"
                                     v-model="k.end_time" @dp-change=""></date-picker>
                        <em class="required_t">{{k.errors.end_time}}</em>
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-danger" @click.prevent="list_du_lieu_phat_sinh.splice(index,1)">Xóa
                        </button>
                    </div>
                </div>
                <button @click.prevent="onBtnAddNewPhatSinh" class="btn btn-success">Thêm</button>
            </div>
        </div>
        <div class="row row_tp">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-9">
                <em style="color: gray">Dữ liệu phát sinh bao gồm các dữ liệu: Điểm, học sinh chuyển lớp, học sinh
                    chuyển trường, học sinh bỏ học</em>
            </div>
        </div>

        <div class="row row_tp">
            <div class="col-lg-3">
                <label class="pull-right">Dữ liệu cuối năm:</label>
            </div>
            <div class="col-lg-4">
                <label>Ngày bắt đầu</label>
                <date-picker :config="configDatePicker" placeholder="Từ ngày" ref="start_cuoi_nam"
                             v-model="start_cuoi_nam" @dp-change=""></date-picker>
                <em class="required_t">{{errors.start_cuoi_nam}}</em>
            </div>
            <div class="col-lg-4">
                <label>Ngày kết thúc</label>
                <date-picker :config="configDatePicker" placeholder="Đến ngày" ref="end_cuoi_nam"
                             v-model="end_cuoi_nam" @dp-change=""></date-picker>
                <em class="required_t">{{errors.end_cuoi_nam}}</em>
            </div>
        </div>
        <div class="row row_tp">
            <div class="col-lg-3">
            </div>
            <div class="col-lg-9">
                <em style="color: gray">Dữ liệu cuối năm bao gồm các dữ liệu: Điểm tổng kết, tổng kết học sinh</em>
            </div>
        </div>

        <div class="row row_tp">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-8">
                <button class="btn btn-success" @click.prevent="onBtnAddClick">Thêm lịch</button>
                <button class="btn btn-default" @click.prevent="onBtnBackClick">Quay lại</button>
            </div>
        </div>

        <div class="row row_tp">
        </div>
    </div>

</template>

<script>

    import Datepicker from 'vue-bootstrap-datetimepicker';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
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
            "date-picker": Datepicker,
        },

        data() {
            return {

                errors: {
                    start_dau_nam: "",
                    end_dau_nam: "",
                    start_cuoi_nam: "",
                    end_cuoi_nam: "",
                },

                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },

                start_dau_nam: null,
                end_dau_nam: null,

                start_cuoi_nam: null,
                end_cuoi_nam: null,

                list_du_lieu_phat_sinh: []
            }
        },

        methods: {

            checkInputArray() {
                this.resetArrayInput();
                for (let i = 0; i < this.list_du_lieu_phat_sinh.length; i++) {
                    if (!m_util.checkString(this.list_du_lieu_phat_sinh[i].start_time)) {
                        this.list_du_lieu_phat_sinh[i].errors.start_time = "Vui lòng chọn thời gian bắt đầu";
                        this.$refs.start_time[i].$el.focus();
                        return false;
                    }
                    if (!m_util.checkString(this.list_du_lieu_phat_sinh[i].end_time)) {
                        this.list_du_lieu_phat_sinh[i].errors.end_time = "Vui lòng chọn thời gian kết thúc";
                        this.$refs.end_time[i].$el.focus();
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
                    start_time: null,
                    end_time: null,
                    errors: {
                        start_time: "",
                        end_time: "",
                    }
                };
                this.list_du_lieu_phat_sinh.push(obj);
            },

            onBtnBackClick() {
                this.$emit("callback", 0);
            },

            resetArrayInput() {
                for (let i = 0; i < this.list_du_lieu_phat_sinh.length; i++) {
                    this.list_du_lieu_phat_sinh[i].errors = {
                        start_time: "",
                        end_time: "",
                    }
                }
            },

            resetError() {
                this.errors = {
                    start_dau_nam: "",
                    end_dau_nam: "",
                    start_cuoi_nam: "",
                    end_cuoi_nam: "",
                };
                this.resetArrayInput();
            },

            onBtnAddClick() {

                this.resetError();
                if (!m_util.checkString(this.start_dau_nam)) {
                    this.errors.start_dau_nam = "Vui lòng chọn thời gian bắt đầu";
                    this.$refs.start_dau_nam.$el.focus();
                    return;
                }

                if (!m_util.checkString(this.end_dau_nam)) {
                    this.errors.end_dau_nam = "Vui lòng chọn thời gian kết thúc";
                    this.$refs.end_dau_nam.$el.focus();
                    return;
                }

                if (!this.checkInputArray()) {
                    return;
                }

                if (!m_util.checkString(this.start_cuoi_nam)) {
                    this.errors.start_cuoi_nam = "Vui lòng chọn thời gian bắt đầu";
                    this.$refs.start_cuoi_nam.$el.focus();
                    return;
                }

                if (!m_util.checkString(this.end_cuoi_nam)) {
                    this.errors.end_cuoi_nam = "Vui lòng chọn thời gian kết thúc";
                    this.$refs.end_cuoi_nam.$el.focus();
                    return;
                }

                let ds = [];
                for (let i = 0; i < this.list_du_lieu_phat_sinh.length; i++) {
                    ds.push({
                        ngayBatDau: this.list_du_lieu_phat_sinh[i].start_time,
                        ngayKetThuc: this.list_du_lieu_phat_sinh[i].end_time,
                    })
                }

                confirmDialog("Bạn muốn thêm lịch đồng bộ này chứ ?", "Thêm", () => {
                    let params = {
                        "cuoiNamToiNgay": this.end_cuoi_nam,
                        "cuoiNamTuNgay": this.start_cuoi_nam,
                        "dauNamToiNgay": this.end_dau_nam,
                        "dauNamTuNgay": this.start_dau_nam,
                        "namHoc": 0,
                        "ycDbdlPhatSinhList": ds
                    };
                    let url = "/csdlgd-admin/yeuCauDongBo";
                    rest_api.post(url, params, (data) => {
                        console.log("res: " + JSON.stringify(data.data));
                        let msg = m_util.getMessageResponse(data, "Thêm lịch đồng bộ thành công", "Thêm lịch đồng bộ thất bại");
                        showDialog("Thông báo", msg, null, () => {
                            if (parseInt(data.data.rc) === 0) {
                                this.$emit("callback", 0);
                            }
                        }, null);
                    });
                });

            }

        }
    }
</script>

<style scoped>
    label {
        position: relative;
    }
</style>

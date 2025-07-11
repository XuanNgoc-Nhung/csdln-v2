<template>

    <div id="modal_sync_old" ref="modal_sync_old" tabindex="-1" data-backdrop="true" class="modal fade custom_md">

        <div class="modal-dialog" style="width: 60%">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Thêm yêu cầu đồng bộ dữ liệu cũ</h4>
                </div>

                <div class="modal-body">
                    <div class="row student-info">

                        <div class="col-md-6 row_tp">
                            <div class="row">
                                <div class="col-md-4"><label class="pull-right lbl_field">Chọn đơn vị:
                                    <span class="required_t icon_t">*</span></label></div>
                                <div class="col-md-8">
                                    <select @change="onDonViChange()" v-model="maDonVi" class="form-control"
                                            style="width:100%">
                                        <option value="">-- Chọn đơn vị --</option>
                                        <option v-for="tr in listDonVi" :value="tr.maDonVi">{{tr.tenDonVi}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 row_tp">
                            <div class="row">
                                <div class="col-md-4"><label class="pull-right lbl_field">Cấp học:<span class="required_t icon_t">*</span></label></div>
                                <div class="col-md-8">
                                    <select @change="onCapHocChange()" v-model="capHoc" class="form-control"
                                            style="width:100%">
                                        <option value="">-- Chọn cấp học --</option>
                            <option v-for="ch in ds_cap_hoc" :value="ch.id">{{ch.name}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 row_tp">
                            <div class="row">
                                <div class="col-md-4"><label class="pull-right lbl_field">Trường học:
                                    <span class="required_t icon_t">*</span></label></div>
                                <div class="col-md-8">
                                    <select ref="ma_truong_hoc" v-model="ma_truong_hoc" class="form-control"
                                            style="width:100%">
                                        <option value="">--Chọn trường học--</option>
                                        <option v-for="tr in listTruongHoc" :value="tr.maTruongHoc">{{tr.tenTruongHoc}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 row_tp">
                            <div class="row">
                                <div class="col-md-4"><label class="pull-right lbl_field">Trạng
                                    thái:<span class="required_t icon_t">*</span></label></div>
                                <div class="col-md-8">
                                    <select ref="trang_thai" v-model="trang_thai" class="form-control"
                                            style="width:100%">
                                        <option value="1">Đang hoạt động</option>
                                        <option value="0">Ngưng hoạt động</option>
                                    </select>
                                    <em class="required_t">{{errors.trang_thai}}</em>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 row_tp">
                            <div class="row">
                                <div class="col-md-4"><label class="pull-right lbl_field">Từ năm
                                    học:<span class="required_t icon_t">*</span></label></div>
                                <div class="col-md-8">
                                    <select ref="from_year" v-model="from_year" class="form-control" style="width:100%">
                                        <option value="">--Chọn--</option>
                                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                    </select>
                                    <em class="required_t">{{errors.from_year}}</em>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 row_tp">
                            <div class="row">
                                <div class="col-md-4"><label class="pull-right lbl_field">Tới năm học:
                                    <span class="required_t icon_t">*</span></label></div>
                                <div class="col-md-8">
                                    <select ref="to_year" v-model="to_year" class="form-control" style="width:100%">
                                        <option value="">--Chọn--</option>
                                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                    </select>
                                    <em class="required_t">{{errors.to_year}}</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="createSyncDataOld()" class="btn btn-primary">
                        Thêm
                    </button>
                </div>

            </div>

        </div>

    </div>

</template>

<script>

    import m_util from '../../../utils/m_utils';
    import array_util from '../../../utils/array_utils';
    import constant from '../../../utils/constant';
    import rest_api from '../../../utils/rest_api';
    import {mapMutations, mapState} from 'vuex';

    export default {

        props: ['item', 'show','dangnhap'],

        watch: {
            show: function (newVal, oldVal) {
                if (newVal) {
                    this.reset();
                    $("#modal_sync_old").modal();
                } else {
                    $("#modal_sync_old").modal('hide');
                }
            },
            dangnhap: function (newVal) {
                console.log("thông tin đăng nhập:"+JSON.stringify(newVal));
                this.dangNhap = newVal;
                this.matinhthanh = newVal.ma_so;
                console.log(JSON.stringify(this.matinhthanh))
                this.getDonVi();

            },
        },

        computed: {
        },

        beforeMount() {
            this.list_years = constant.LIST_YEARS_FULL;
            console.log("Year = " + JSON.stringify(this.list_years));
        },

        mounted: function () {
            $(this.$refs.modal_sync_old).on("hidden.bs.modal", this.close);
        },

        data() {
            return {
                ds_cap_hoc: constant.LIST_CAP_HOC,
                listTruongHoc:[],
                listDonVi:[],
                maDonVi:'',
                capHoc:'',
                ma_truong_hoc: "",
                trang_thai: 1,
                from_year: "",
                to_year: "",
                errors: {
                    "ma_truong_hoc": "",
                    "trang_thai": "",
                    "from_year": "",
                    "to_year": "",
                },

                list_years: []
            }
        },

        methods: {

            ...mapMutations(['setFlagReload']),

            resetErrors() {
                this.errors = {
                    "ma_truong_hoc": "",
                    "trang_thai": "",
                    "from_year": "",
                    "to_year": "",
                };
            },
            onDonViChange(){
                console.log("thay đổi đơn vị");
                array_util.clearArrays(this.listTruongHoc);
                this.matruonghoc = '';
                if (this.maDonVi == '') {
                    return;
                }
                this.getTruongHoc();
            },
            onCapHocChange(){
                console.log("thay đổi cấp học");
                this.getTruongHoc();
            },
            getTruongHoc() {
                console.log("lấy danh sách trường học của mã đơn vị:" + this.maDonVi);
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "madonvi": this.maDonVi,
                    "caphoc": this.capHoc,
                };
                rest_api.get("/internal-api/dmTruongHoc/filter", params, (data) => {
                    console.log("trường học trả về:" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.listTruongHoc);
                        this.listTruongHoc = data.data.rows;
                    }
                });
            },
            getDonVi() {
                console.log("lấy danh sách đơn vị");
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.matinhthanh,
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.listDonVi);
                        this.listDonVi = data.data.rows;
                    }

                });
            },
            createSyncDataOld() {

                console.log("from: " + this.from_year + ", to: " + this.to_year);
                this.resetErrors();

                if (!m_util.checkString(this.ma_truong_hoc)) {
                    this.errors.ma_truong_hoc = "Vui lòng chọn trường";
                    this.$refs.ma_truong_hoc.focus();
                    return;
                }

                if (!m_util.checkString(this.trang_thai)) {
                    this.errors.trang_thai = "Vui lòng chọn trạng thái";
                    this.$refs.trang_thai.focus();
                    return;
                }

                if (!m_util.checkString(this.from_year)) {
                    this.errors.from_year = "Vui lòng chọn năm bắt đầu";
                    this.$refs.from_year.focus();
                    return;
                }

                if (!m_util.checkString(this.to_year)) {
                    this.errors.to_year = "Vui lòng chọn năm kết thúc";
                    this.$refs.to_year.focus();


                    return;
                }

                if (parseInt(this.to_year) < parseInt(this.from_year)) {
                    this.errors.to_year = "Vui lòng chọn năm kết thúc đúng";
                    this.$refs.to_year.focus();
                    return;
                }

                confirmDialog("Bạn muốn thêm yêu cầu này chứ ?", "Thêm", () => {
                    let params = {
                        "maTruongHoc": this.ma_truong_hoc,
                        "toiNamHoc": this.to_year,
                        "trangThai": Number(this.trang_thai),
                        "tuNamHoc": this.from_year
                    };
                    rest_api.post("/csdlgd-admin/yeuCauDuLieuCu/", params, (data) => {
                        console.log("data: " + JSON.stringify(data.data));
                        let msg = m_util.getMessageResponse(data, "Thêm yêu cầu thành công", "Thêm yêu cầu thất bại");
                        showDialog("Thông báo", msg, null, () => {
                            if (parseInt(data.data.rc) === 0) {
                                this.setFlagReload();
                                this.$emit('success');
                                this.close();
                                this.reset();
                            }
                        }, null);
                    }, null, true);
                });
            },

            close() {
                this.$emit("close", 1);

            },

            reset() {
                this.resetErrors();
                this.ma_truong_hoc = "";
                this.trang_thai = 1;
                this.from_year = "";
                this.to_year = "";
                this.maDonVi = "";
                this.capHoc = "";
            }

        }

    }
</script>

<style scoped>
    label {
        position: relative;
    }
</style>

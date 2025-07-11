<template>
    <div
        id="modal_them_ycdltheotruong"
        ref="modal_them_ycdltheotruong"
        class="modal fade">
        <div class="modal-dialog" style="width:80%">
            <div class="modal-content">
                <!-- header -->
                <div class="modal-header">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Thêm mới lịch đồng bộ</h4>
                </div>
                <!-- end header -->
                <!-- content -->
                <div class="modal-body clearfix">
                    <div class="row">
                        <!-- chọn đơn vị -->
                        <div class="col-md-5">
                            <div>
                                <label class="typo__label">Chọn đơn vị</label>
                                <multiselect
                                    v-model="danhSachDonVi"
                                    :options="list_don_vi"
                                    :custom-label="setNameDonVi"
                                    placeholder="Chọn đơn vị"
                                    label="maDonVi"
                                    track-by="maDonVi"></multiselect>
                            </div>
                        </div>
                        <!-- hết chọn đơn vị -->
                        <!-- chọn cấp học -->
                        <div class="col-md-2">
                            <div>
                                <label class="typo__label">Chọn cấp học</label>
                                <multiselect
                                    v-model="danhSachCapHoc"
                                    :options="list_cap_hoc"
                                    :custom-label="setNameByIdValue"
                                    deselectLabel="Đã chọn"
                                    selectLabel="Chưa chọn"
                                    selectedLabel="Đã chọn"
                                    placeholder="Chọn cấp học"
                                    label="name"
                                    track-by="name"></multiselect>
                            </div>
                        </div>
                        <!-- hết chọn cấp học -->
                        <!-- chọn trường -->
                        <div class="col-md-5">
                            <label class="typo__label">Chọn trường học</label>
                            <multiselect
                                v-model="danhSachTruongHoc"
                                :options="list_truong_hoc"
                                :custom-label="setNameTruongHoc"
                                deselectLabel="Đã chọn"
                                :groupSelect="true"
                                selectLabel="Chưa chọn"
                                selectedLabel="Đã chọn"
                                placeholder="Chọn cấp học"
                                label="maTruongHoc"
                                track-by="maTruongHoc"></multiselect>
                        </div>
                        <!-- hết chọn trường -->
                        <!-- Năm học -->
                        <div class="col-md-2">
                            <label class="typo__label">Năm học</label>
                            <multiselect
                                v-model="danhSachNamHoc"
                                :options="list_nam_hoc"
                                :custom-label="setNameByIdValue"
                                placeholder="Chọn năm học"
                                label="name"
                                deselectLabel="Đã chọn"
                                selectLabel="Chưa chọn"
                                selectedLabel="Đã chọn"
                                track-by="name"></multiselect>
                        </div>
                        <!-- Hết năm học -->

                        <!-- Loại đồng bộ -->
                        <div class="col-md-3">

                            <label class="typo__label">Loại đồng bộ</label>
                            <multiselect
                                v-model="danhSachLoaiDongBo"
                                :options="ds_loai_dong_bo_ket_chuyen_du_lieu"
                                :custom-label="setNameByIdValue"
                                placeholder="Chọn loại đồng bộ"
                                label="name"
                                deselectLabel="Đã chọn"
                                selectLabel="Chưa chọn"
                                selectedLabel="Đã chọn"
                                track-by="name"></multiselect>
                        </div>
                        <!-- hết loại đồng bộ -->
                        <!-- Thời gian đẩy -->
                        <div class="col-md-2 timkiem">
                            <label>Ngày bắt đầu đẩy:</label>
                            <date-picker
                                v-model="ngayBatDau"
                                :config="configDate"
                                @dp-change="ChonNgayDauNamBatDau"
                                placeholder="Chọn ngày bắt đầu"></date-picker>
                        </div>
                        <div class="col-md-2 timkiem">
                            <label>Ngày kết thúc đẩy:</label>
                            <date-picker
                                v-model="ngayKetThuc"
                                :config="configDate"
                                placeholder="Chọn ngày kết thúc"></date-picker>
                        </div>
                        <!-- Hết thời gian đẩy -->
                    </div>
                </div>
                <!-- end content -->
                <!-- footer -->
                <!-- demo -->
                <!-- end demo -->
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy
                    </button>
                    <button type="button" class="btn btn-primary" @click.prevent="themYeuCau">Thêm
                    </button>
                </div>
                <!-- end footer -->
            </div>
        </div>
    </div>
</template>
<script>
    import moment from 'moment'
    import rest_api from '../../utils/rest_api';
    import Multiselect from 'vue-multiselect'
    import array_util from '../../utils/array_utils';
    import utils from '../../utils'
    import api from '../api';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import constant from "../../utils/constant";
    $(document).ready(function () {});
    export default {
        props: [],
        components: {
            datePicker,
            Multiselect
        },
        watch: {
            danhSachNamHoc: function (newVal) {
                console.log("watch Năm học");
                this.namHoc = "";
                if (newVal) {
                    this.namHoc = newVal
                        .id
                        console
                        .log("map xong:" + JSON.stringify(this.namHoc));
                }
            },
            danhSachDonVi: function (newVal) {
                console.log("watch đơn vị" + JSON.stringify(newVal));
                this.ma_truong_hoc = "";
                this.ma_don_vi = "";
                this.danhSachTruongHoc = [];
                this.list_truong_hoc = [];
                if (newVal) {
                    this.ma_don_vi = newVal.maDonVi;
                }
                this.getTruongHoc();

            },
            danhSachTruongHoc: function (newVal) {
                console.log("watch trường học" + JSON.stringify(newVal));
                this.ma_truong_hoc = "";
                if (newVal) {
                    this.ma_truong_hoc = newVal.maTruongHoc;
                }
            },
            danhSachCapHoc: function (newVal) {
                this.ma_truong_hoc = "";
                this.danhSachTruongHoc = [];
                this.ma_cap_hoc = "";
                this.list_truong_hoc = [];
                if (newVal) {
                    this.ma_cap_hoc = newVal.id;
                }
                this.getTruongHoc();

            },
            danhSachLoaiDongBo: function (newVal) {
                this.ma_loai_dong_bo = "";
                if (newVal) {
                    this.ma_loai_dong_bo = newVal
                        .id
                        console
                        .log("map xong:" + JSON.stringify(this.ma_loai_dong_bo));
                }
            }
        },
        data() {
            return {
                configDate: {
                    format: "DD/MM/YYYY",
                    useCurrent: false,
                    showTodayButton: true,
                    locale: "vi"
                },
                ma_don_vi: "",
                ngayBatDau: "",
                ma_loai_dong_bo: "",
                ngayKetThuc: "",
                namHoc: "",
                ma_cap_hoc: "",
                ma_truong_hoc: "",
                list_don_vi: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_cap_hoc: constant.LIST_CAP_HOC_KHONG_LIEN,
                ds_loai_dong_bo_ket_chuyen_du_lieu: constant.ds_loai_dong_bo_ket_chuyen_du_lieu,
                list_truong_hoc: [],
                danhSachDonVi: [],
                danhSachCapHoc: [],
                danhSachTruongHoc: [],
                danhSachLoaiDongBo: [],
                danhSachNamHoc: []
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            console.log("moutnt thêm yêu cầu");
            $("#modal_them_ycdltheotruong").modal();
            $(this.$refs.modal_them_ycdltheotruong).on("hidden.bs.modal", this.close);
            this.getDonVi(() => {
                console.log("lấy đơn vị xong mới chạy thằng này");
                console.log("Thông tin đăng nhập" + JSON.stringify(this.thongtin));
                if(this.thongtin.role==4){
                    this.danhSachDonVi = this.list_don_vi[0];
                }
                this.getTruongHoc();
            });
        },
        methods: {
            themYeuCau() {

                console.log("thêm yêu cầu");
                const uri = "/api_them_yeu_cau_du_lieu_theo_truong";
                const params = {
                    denNgay: this.ngayKetThuc,
                    loaiDongBo: this.ma_loai_dong_bo,
                    maTruongHoc: this.ma_truong_hoc,
                    tuNgay: this.ngayBatDau,
                    namHoc: this.namHoc,
                    status: '0'
                };
                console.log("params thêm:" + JSON.stringify(params));
                if (!params.maTruongHoc) {
                    this
                        .$alertify
                        .error("Vui lòng chọn trường học để thêm yêu cầu");
                    return;
                }
                if (!params.namHoc) {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để thêm yêu cầu");
                    return;
                }
                if (!params.loaiDongBo) {
                    this
                        .$alertify
                        .error("Vui lòng chọn loại đồng bộ để thêm yêu cầu");
                    return;
                }
                if (!params.tuNgay) {
                    this
                        .$alertify
                        .error("Vui lòng chọn ngày bắt đầu đồng bộ để thêm yêu cầu");
                    return;
                }
                if (!params.denNgay) {
                    this
                        .$alertify
                        .error("Vui lòng chọn ngày bắt đầu đồng bộ để thêm yêu cầu");
                    return;
                }

                utils.confirmDialog("Xác nhận thêm yêu cầu", "Thêm", () => {
                    api.post(uri, params, (response) => {
                        if (response.data.rc === 0) {

                            this
                                .$alertify
                                .confirm(
                                    'Thêm yêu cầu thành công. Xác nhận tải lại dữ liệu',
                                    () => {

                                        this.$emit('success');
                                        this.close();

                                        console.log("đồng ý ròi nè");
                                    },
                                    () => this.$alertify.error('Đã hủy tải lại dữ liệu. Hãy tải lại dữ liệu bằng cách tải lại trang nếu bạn muốn.')
                                );

                            return;

                        } else {
                            this
                                .$alertify
                                .error("Thêm yêu cầu thất bại:" + response.data.rd);
                        }
                    });
                })
            },
            // Chọn ngày bắt đầu đẩy
            ChonNgayDauNamBatDau() {
                if (this.ngayBatDau != null) {
                    let endDauNam = moment(this.ngayBatDau, "DD/MM/YYYY")
                        .add(10, "days")
                        .format("DD/MM/YYYY");
                    this.ngayKetThuc = endDauNam;
                }
            },
            // Lấy trường học
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: [this.ma_don_vi],
                    capHoc: [this.ma_cap_hoc]
                };
                if (!this.ma_don_vi) {
                    console.log("không có đươn vị");
                    params.maDonVi = [];
                }
                if (!this.ma_cap_hoc) {
                    console.log("không có cấp học");
                    params.capHoc = [];
                }
                console.log("Thông tin lấy trường học:" + JSON.stringify(params));
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    console.log("lấy trường");
                    if (data.data.code == 200) {
                        this.list_truong_hoc = data.data.rows;
                    }
                });
            },
            close() {
                this.$emit('close');
            },
            // định nghĩa cho đơn vị
            setNameDonVi({tenDonVi, maDonVi}) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // định nghĩa cho trường học
            setNameTruongHoc({tenTruongHoc, maTruongHoc}) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            // định nghĩa cho trạng thái
            setNameByIdValue({name}) {
                return `${name}`
            },
            // Lấy danh sách đơn vị
            getDonVi(ck = () => {}) {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_don_vi
                };
                if (this.thongtin.role == 5 || this.thongtin.role == 4) {
                    params.maTinhThanh = "",
                    params.maQuanHuyen = this.thongtin.ma_don_vi;
                }
                console.log("pr ẻty" + JSON.stringify(params));
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    console.log("lấy đơn vị thành công" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        this.list_don_vi = data.data.rows;
                        if(this.thongtin.role==4){
                            console.log("đơn vị phòng: *************************************************88")
                        }
                        ck();
                    }
                });
            }
        }
    }
</script>
<style scoped="scoped">
    /*@import "../../../../node_modules/selectwithsearch.css";*/
</style>

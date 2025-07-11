<template>

    <div id="modal_create_sync" ref="modal_create_sync" class="modal fade">
        <div class="modal-dialog" style="width: 95%; height:95vh">
            <form @keyup.enter.native="onSubmit">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            v-on:click="close()">
                            &times;
                        </button>
                        <div class="row">
                            <div class="col-md-7">
                                <h3 class="modal-title text-uppercase">Chỉnh sửa học sinh</h3>
                            </div>
                        </div>
                    </div>
                    <div class="modal-body" style="width: 100%;margin: 0 auto;height: 85%;overflow: scroll;">
                        <div style="padding-top: 10px">
                            <div class="row">
                                <div class="col-md-2">
                                    <div style="border:1px solid #D8D8D8">
                                        <img style="width:100%"
                                            src="http://s3.amazonaws.com/37assets/svn/765-default-avatar.png" alt="">
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Mã học sinh</label>
                                            <input class="form-control" v-model="maHocSinh" disabled="disabled"
                                                style="width:100%" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Họ tên</label>
                                            <input class="form-control" v-model="hoTen" style="width:100%" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Trạng thái</label>
                                            <select class="form-control" v-model="trangThai" style="width:100%">
                                                <option value=''>Chọn trạng thái</option>
                                                <option value="1">Đang học/Đã hoàn thành</option>
                                                <option value="3">Chuyển khỏi trường</option>
                                                <option value="4">Bỏ học</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Giới tính</label>
                                            <select class="form-control" v-model="gioiTinh">
                                                <option value="0">Nữ</option>
                                                <option value="1">Nam</option>
                                                <option value="2">Không xác định</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Ngày sinh</label>
                                            <input class="form-control" v-model="ngaySinh" style="width:100%" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Cấp học</label>
                                            <select class="form-control" disabled="disabled"
                                                @change.prevent="onCapHocChange" v-model="CapHoc" style="width:100%">
                                                <option value=''>Chọn cấp học học</option>
                                                <option value='1'>Cấp 1</option>
                                                <option value='2'>Cấp 2</option>
                                                <option value='3'>Cấp 3</option>
                                                <option value='4'>Nhà trẻ</option>
                                                <option value='5'>Mẫu giáo</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Khối học</label>
                                            <select v-if="CapHoc==1" v-model="khoiHoc" class="form-control"
                                                style="width:100%">
                                                <option value=''>Chọn khối học</option>
                                                <option value='1'>Khối lớp 1</option>
                                                <option value='2'>Khối lớp 2</option>
                                                <option value='3'>Khối lớp 3</option>
                                                <option value='4'>Khối lớp 4</option>
                                                <option value='5'>Khối lớp 5</option>
                                            </select>

                                            <select v-if="CapHoc==2" v-model="khoiHoc" class="form-control"
                                                style="width:100%">
                                                <option value=''>Chọn khối học</option>
                                                <option value='6'>Khối lớp 6</option>
                                                <option value='7'>Khối lớp 7</option>
                                                <option value='8'>Khối lớp 8</option>
                                                <option value='9'>Khối lớp 9</option>
                                            </select>

                                            <select v-if="CapHoc==3" v-model="khoiHoc" class="form-control"
                                                style="width:100%">
                                                <option value=''>Chọn khối học</option>
                                                <option value='10'>Khối lớp 10</option>
                                                <option value='11'>Khối lớp 11</option>
                                                <option value='12'>Khối lớp 12</option>
                                            </select>

                                            <select v-if="CapHoc==4" v-model="khoiHoc" class="form-control"
                                                style="width:100%">
                                                <option value=''>Chọn khối học</option>
                                                <option value='13'>Trẻ từ 3-12 tháng tuổi</option>
                                                <option value='14'>Trẻ từ 13-24 tháng tuổi</option>
                                                <option value='15'>Trẻ từ 25-36 tháng tuổi</option>
                                            </select>

                                            <select v-if="CapHoc==5" v-model="khoiHoc" class="form-control"
                                                style="width:100%">
                                                <option value=''>Chọn khối học</option>
                                                <option value='16'>Trẻ từ 3-4 tuổi</option>
                                                <option value='17'>Trẻ từ 4-5 tuổi</option>
                                                <option value='18'>Trẻ từ 5-6 tuổi</option>
                                            </select>

                                            <select v-if="CapHoc==''" disabled="disabled" v-model="khoiHoc"
                                                class="form-control" style="width:100%">
                                                <option value=''>Chọn khối học</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Lớp học</label>
                                            <select disabled="disabled" class="form-control" style="width:100%">
                                                <option value=''>Chọn lớp học</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Tỉnh thành</label>
                                            <select @change.prevent="onTinhThanhChange()" class="form-control"
                                                v-model="maTthanhThtru">
                                                <option value=''>Chọn tỉnh thành</option>
                                                <option v-for="tt in ds_tinh_thanh" :value="tt.maTinhThanh">
                                                    {{tt.tenTinhThanh}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Quận huyện</label>
                                            <select @change.prevent="onQuanHuyenChange()" class="form-control"
                                                v-model="maQhuyenThtru">
                                                <option value=''>Chọn quận huyện</option>
                                                <option v-for="tt in ds_quan_huyen" :value="tt.maQuanHuyen">
                                                    {{tt.tenQuanHuyen}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Phường xã</label>
                                            <select @change.prevent="onPhuongXaChange()" class="form-control"
                                                v-model="maPxaThtru">
                                                <option value=''>Chọn phường xã</option>
                                                <option v-for="tt in ds_phuong_xa" :value="tt.maPhuongXa">
                                                    {{tt.tenPhuongXa}}</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Tổ thôn</label>
                                            <select class="form-control" v-model="maTthonThtru">
                                                <option value=''>Chọn tổ thôn</option>
                                                <option v-for="tt in ds_to_thon" :value="tt.maToThon">{{tt.tenToThon}}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label>Ngày vào trường</label>
                                            <input class="form-control" style="width:100%" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Loại tốt nghiệp cấp dưới</label>
                                            <input class="form-control" style="width:100%" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Hệ học ngoại ngữ</label>
                                            <input class="form-control" style="width:100%" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Nơi sinh</label>
                                            <input class="form-control" v-model="noiSinh" style="width:100%" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Quê quán</label>
                                            <input class="form-control" v-model="queQuan" style="width:100%" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Địa chỉ thường trú</label>
                                            <input class="form-control" v-model="dchiThtru" style="width:100%" />
                                        </div>
                                        <div class="col-md-3">
                                            <label>Địa chỉ tạm trú</label>
                                            <input class="form-control" v-model="dchiTmtru" style="width:100%" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="background:#51aab2;margin:15px 0;">
                                    <h4 style=" margin:5px 0; color:white">Thông tin cá nhân</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Dân tộc</label>
                                    <select class="form-control" v-model="maDanToc">
                                        <option value=''>Chọn tổ thôn</option>
                                        <option v-for="tt in ds_dan_toc" :value="tt.maDanToc">{{tt.tenDanToc}}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Khu vực</label>
                                    <input class="form-control" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Tôn giáo</label>
                                    <select class="form-control" v-model="maTonGiao">
                                        <option value=''>Chọn tôn giáo</option>
                                        <option v-for="tt in ds_ton_giao" :value="tt.maTonGiao">{{tt.tenTonGiao}}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Số CMND</label>
                                    <input class="form-control" v-model="soCmnd" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Email</label>
                                    <input class="form-control" v-model="email" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Vùng khó khăn</label>
                                    <input class="form-control" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Đối tượng chính sách</label>
                                    <select class="form-control" v-model="maDtuongCsach">
                                        <option value=''>Chọn đối tượng chính sách</option>
                                        <option v-for="tt in ds_doi_tuong" :value="tt.maDtuongCsach">
                                            {{tt.tenDtuongCsach}}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Diện học sinh</label>
                                    <input class="form-control" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Chỗ ở</label>
                                    <input class="form-control" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Nhóm máu</label>
                                    <input class="form-control" v-model="nhomMau" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>SĐT cố định</label>
                                    <input class="form-control" v-model="soDthoaiCdinh" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>SĐT di động</label>
                                    <input class="form-control" style="width:100%" />
                                </div>
                                <div class="col-md-2 checkdieukien">
                                    <input v-model="doiVien" type="checkbox" />
                                    <label>
                                        Là đội viên</label>
                                </div>
                                <div class="col-md-2">
                                    <label>Ngày vào đội</label>
                                    <date-picker v-bind:disabled="!doiVien" v-model="ngayVaoDoi" :config="configDate"
                                        placeholder="Chọn ngày "></date-picker>
                                </div>
                                <div class="col-md-2">
                                    <label>Nơi vào đội</label>
                                    <input v-bind:disabled="!doiVien" v-model="noiVaoDoi" class="form-control"
                                        style="width:100%" />
                                </div>
                                <div class="col-md-2 checkdieukien">
                                    <input v-model="doanVien" type="checkbox" />
                                    <label>
                                        Là đoàn viên</label>
                                </div>
                                <div class="col-md-2">
                                    <label>Ngày vào đoàn</label>
                                    <date-picker v-bind:disabled="!doanVien" v-model="ngayVaoDoan" :config="configDate"
                                        placeholder="Chọn ngày "></date-picker>
                                </div>
                                <div class="col-md-2">
                                    <label>Nơi vào đoàn</label>
                                    <input v-bind:disabled="!doanVien" v-model="noiVaoDoan" class="form-control"
                                        style="width:100%" />
                                </div>
                                <div class="col-md-2 checkdieukien">
                                    <input v-model="dangVien" type="checkbox" />
                                    <label>
                                        Là đảng viên</label>
                                </div>
                                <div class="col-md-2">
                                    <label>Ngày vào đảng</label>
                                    <date-picker v-bind:disabled="!dangVien" v-model="ngayVaoDang" :config="configDate"
                                        placeholder="Chọn ngày "></date-picker>
                                </div>
                                <div class="col-md-2">
                                    <label>Nơi vào đảng</label>
                                    <input v-bind:disabled="!dangVien" v-model="noiVaoDang" class="form-control"
                                        style="width:100%" />
                                </div>
                                <div class="col-md-2 checkdieukien">
                                    <input v-model="khuyetTat" type="checkbox" />
                                    <label>
                                        Là người khuyết tật</label>
                                </div>
                                <div class="col-md-2">
                                    <label>Loại khuyết tật</label>
                                    <input v-bind:disabled="!khuyetTat" class="form-control" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Mức độ khuyết tật</label>
                                    <input v-bind:disabled="!khuyetTat" class="form-control" style="width:100%" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12" style="background:#51aab2;margin:15px 0;">
                                    <h4 style=" margin:5px 0; color:white">Thông tin gia đình
                                    </h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Họ tên bố</label>
                                    <input class="form-control" v-model="hoTenBo" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Năm sinh bố</label>
                                    <input class="form-control" v-model="namSinhBo" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Nghề nghiệp bố</label>
                                    <input class="form-control" v-model="ngheNghiepBo" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>SĐT bố</label>
                                    <input class="form-control" v-model="soDienThoaiBo" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Email bố</label>
                                    <input class="form-control" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Nơi làm việc bố</label>
                                    <input class="form-control" v-model="noiLamViecBo" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Họ tên mẹ</label>
                                    <input class="form-control" v-model="hoTenMe" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Năm sinh mẹ</label>
                                    <input class="form-control" v-model="namSinhMe" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Nghề nghiệp mẹ</label>
                                    <input class="form-control" v-model="ngheNghiepMe" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>SĐT mẹ</label>
                                    <input class="form-control" v-model="soDienThoaiMe" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Email mẹ</label>
                                    <input class="form-control" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Nơi làm việc mẹ</label>
                                    <input class="form-control" v-model="noiLamViecMe" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Họ tên người giám hộ</label>
                                    <input class="form-control" v-model="hoTenNguoiGiamHo" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Năm sinh người giám hộ</label>
                                    <input class="form-control" v-model="ngaySinhNguoiGiamHo" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Nghề nghiệp người giám hộ</label>
                                    <input class="form-control" v-model="ngheNghiepNguoiGiamHo" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>SĐT người giám hộ</label>
                                    <input class="form-control" v-model="dienThoaiNguoiGiamHo" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Email người giám hộ</label>
                                    <input class="form-control" style="width:100%" />
                                </div>
                                <div class="col-md-2">
                                    <label>Nơi làm việc người giám hộ</label>
                                    <input class="form-control" v-model="noiLamViecNguoiGiamHo" style="width:100%" />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                        </button>
                        <button type="button" v-on:click="UpdateStudent()" class="btn btn-primary">Chỉnh sửa</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    $(document).ready(function () {
        console.log("ready!");
    });
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils';
    import dialog from '../../utils/dialog';
    import api from '../api';
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
                console.log("Chỉnh sửa 1234567890 = " + newVal);
                if (newVal) {
                    $("#modal_create_sync").modal();
                } else {
                    $("#modal_create_sync").modal('hide');
                }
            },
            item: function (newVal) {
                this.getDataStudent(newVal);
            }
        },
        data() {
            return {
                info: {},
                maHocSinh: '',
                hoTen: '',
                trangThai: '',
                laDoiVien: false,
                maDanToc: "",
                maTonGiao: "",
                gioiTinh: "",
                namSinh: "",
                noiSinh: "",
                queQuan: "",
                soDthoaiCdinh: "",
                soDthoaiDdong: "",
                email: "",
                dchiTmtru: "",
                maTthonThtru: "",
                maPxaThtru: "",
                maPxaTmtru: "",
                maQhuyenTmtru: "",
                maQhuyenThtru: "",
                maTthanhTmtru: "",
                maTthanhThtru: "",
                dchiThtru: "",
                nhomMau: "",
                khuyetTat: "",
                maDtuongCsach: "",
                dtuongUuTien: "",
                doanVien: "",
                dangVien: "",
                noiVaoDoan: "",
                ngayVaoDoan: "",
                ngayVaoDang: "",
                noiVaoDang: "",
                ngayVaoDoi: "",
                noiVaoDoi: "",
                doiVien: "",
                khuyetTat: "",
                soCmnd: "",
                hoTenBo: "",
                namSinhBo: "",
                ngheNghiepBo: "",
                soDienThoaiBo: "",
                noiLamViecBo: "",
                hoTenMe: "",
                namSinhMe: "",
                ngheNghiepMe: "",
                soDienThoaiMe: "",
                noiLamViecMe: "",
                hoTenNguoiGiamHo: "",
                ngaySinhNguoiGiamHo: "",
                ngheNghiepNguoiGiamHo: "",
                noiLamViecNguoiGiamHo: "",
                dienThoaiNguoiGiamHo: "",
                CapHoc: "",
                khoiHoc: "",
                ngaySinh: "",

                ds_tinh_thanh: [],
                ds_quan_huyen: [],
                ds_phuong_xa: [],
                ds_to_thon: [],
                ds_dan_toc: [],
                ds_ton_giao: [],
                ds_doi_tuong: [],

                configDate: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },

                demo: []
            }
        },
        mounted: function () {
            this.getTinhThanh();
            this.getDanToc();
            this.getTonGiao();
            this.getDoiTuongChinhSach();
            $(this.$refs.modal_create_sync).on("hidden.bs.modal", this.close);
        },
        methods: {
            getDataStudent(e) {
                let params = {
                    "maHocSinh": e
                };
                rest_api.get("/csdlgd-admin/hocSinh", params, (data) => {
                    if (data.data != null) {
                        this.info = data.data;
                        this.bindData(this.info);
                        console.log(JSON.stringify(this.info));
                        if (this.info.maTthanhThtru) {
                            this.getQuanHuyen(this.info.maTthanhThtru);
                            if (this.info.maQhuyenThtru) {
                                this.getPhuongXa(this.info.maQhuyenThtru);
                                if (this.info.maPxaThtru) {
                                    this.getToThon(this.info.maPxaThtru)
                                }
                            }
                        }
                    } else {
                        this
                            .$alertify
                            .success("Thực hiện thao tác không thành công");
                    }
                });
            },
            bindData(e) {
                console.log("object" + JSON.stringify(e));
                this.maHocSinh = e.maHocSinh,
                    this.hoTen = e.hoTen,
                    this.trangThai = e.trangThai,
                    this.maDanToc = e.maDanToc,
                    this.maTonGiao = e.maTonGiao,
                    this.gioiTinh = e.gioiTinh,
                    this.namSinh = e.namSinh,
                    this.noiSinh = e.noiSinh,
                    this.queQuan = e.noiSinh,
                    this.soDthoaiCdinh = e.soDthoaiCdinh,
                    this.email = e.email,
                    this.dchiTmtru = e.dchiTmtru,
                    this.maPxaThtru = e.maPxaThtru,
                    this.maPxaThtru = e.maPxaThtru,
                    this.maPxaTmtru = e.maPxaTmtru,
                    this.maQhuyenTmtru = e.maQhuyenTmtru,
                    this.maQhuyenThtru = e.maQhuyenThtru,
                    this.maTthanhTmtru = e.maTthanhTmtru,
                    this.maTthanhThtru = e.maTthanhThtru,
                    this.maTthonThtru = e.maTthonThtru,
                    this.dchiThtru = e.dchiThtru,
                    this.nhomMau = e.nhomMau,
                    this.khuyetTat = e.khuyetTat,
                    this.maDtuongCsach = e.maDtuongCsach,

                    this.dtuongUuTien = e.dtuongUuTien,
                    this.dangVien = e.dangVien,
                    this.doiVien = e.doiVien,
                    this.soCmnd = e.soCmnd,
                    this.khuyetTat = e.khuyetTat,
                    this.hoTenBo = e.hoTenBo,
                    this.namSinhBo = e.namSinhBo,
                    this.ngheNghiepBo = e.ngheNghiepBo,
                    this.soDienThoaiBo = e.soDienThoaiBo,
                    this.noiLamViecBo = e.noiLamViecBo,
                    this.hoTenMe = e.hoTenMe,
                    this.namSinhMe = e.namSinhMe,
                    this.ngheNghiepMe = e.ngheNghiepMe,
                    this.soDienThoaiMe = e.soDienThoaiMe,
                    this.noiLamViecMe = e.noiLamViecMe,
                    this.dienThoaiNguoiGiamHo = e.dienThoaiNguoiGiamHo,
                    this.hoTenNguoiGiamHo = e.hoTenNguoiGiamHo,
                    this.ngaySinhNguoiGiamHo = e.ngaySinhNguoiGiamHo,
                    this.ngheNghiepNguoiGiamHo = e.ngheNghiepNguoiGiamHo,
                    this.noiLamViecNguoiGiamHo = e.noiLamViecNguoiGiamHo,
                    this.ngayVaoDoi = e.ngayVaoDoi,
                    this.ngayVaoDoan = e.ngayVaoDoan,
                    this.ngayVaoDang = e.ngayVaoDang,
                    this.noiVaoDoi = e.noiVaoDoi,
                    this.noiVaoDoan = e.noiVaoDoan,
                    this.noiVaoDang = e.noiVaoDang,
                    this.ngaySinh = e.ngaySinh;
                if (this.maDtuongCsach == null) {
                    this.maDtuongCsach = '';
                };
                if (this.maTthonThtru == null) {
                    this.maTthonThtru = '';
                };
            },
            close() {
                console.log("Đóng modal");
                this.$emit('close');
            },
            onCapHocChange() {
                this.khoiHoc = "";
                console.log("khối học:" + this.khoiHoc + "cấp học:" + this.CapHoc);
            },

            getDoiTuongChinhSach() {
                let params = {
                    start: 0,
                    limit: 999
                };
                rest_api.get("/internal-api/dmDTuongCSach/filter", params, data => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_doi_tuong);
                        this.ds_doi_tuong = data.data.rows;
                    }
                });
            },

            getDanToc() {
                let params = {
                    start: 0,
                    limit: 999
                };
                rest_api.get("/internal-api/dmDanToc/filter", params, data => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_dan_toc);
                        this.ds_dan_toc = data.data.rows;
                    }
                });
            },
            getTonGiao() {
                let params = {
                    "start": 0,
                    "limit": 999
                };
                rest_api.get("/internal-api/dmTonGiao/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_ton_giao);
                        this.ds_ton_giao = data.data.rows;
                    }
                });
            },
            getTinhThanh() {
                let params = {
                    "start": 0,
                    "limit": 100
                };
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_tinh_thanh);
                        this.ds_tinh_thanh = data.data.rows;
                    }
                });
            },
            onTinhThanhChange() {
                console.log("chọn tỉnh thành");
                this.ds_quan_huyen = [];
                this.maQhuyenThtru = "";
                this.ds_phuong_xa = [];
                this.maPxaThtru = "";
                this.ds_to_thon = [];
                this.maTthonThtru = "";
                console.log(this.maTthanhThtru);
                if (this.maTthanhThtru) {
                    this.getQuanHuyen(this.maTthanhThtru)
                }
            },
            getQuanHuyen(e) {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maTinhThanh": e
                };
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_quan_huyen);
                        this.ds_quan_huyen = data.data.rows;
                    }
                });
            },
            onQuanHuyenChange() {
                console.log("chọn tỉnh thành");
                this.ds_phuong_xa = [];
                this.maPxaThtru = "";
                this.ds_to_thon = [];
                this.maTthonThtru = "";
                console.log(this.maTthanhThtru);
                if (this.maQhuyenThtru) {
                    this.getPhuongXa(this.maQhuyenThtru)
                }
            },

            getPhuongXa(e) {
                let params = {
                    start: 0,
                    limit: 999,
                    maQuanHuyen: e
                };
                rest_api.get("/internal-api/dmPhuongXa/filter", params, data => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_phuong_xa);
                        this.ds_phuong_xa = data.data.rows;
                    }
                });
            },
            onPhuongXaChange() {
                console.log("chọn tỉnh thành");
                this.ds_to_thon = [];
                this.maTthonThtru = "";
                console.log(this.maPxaThtru);
                if (this.maPxaThtru) {
                    this.getToThon(this.maPxaThtru)
                }
            },

            getToThon(e) {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maPhuongXa": e
                };
                rest_api.get("/internal-api/dmToThon/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_to_thon);
                        this.ds_to_thon = data.data.rows;
                    }
                });
            },
            UpdateStudent() {
                console.log("xác nhận update");
                
                console.log("đồng ý sửa");
                    let params = {
                        "dangVien": this.dangVien,
                        "dchiThtru": this.dchiThtru,
                        "dchiTmtru": this.dchiTmtru,
                        "doanVien": this.doanVien,
                        "doiVien": this.doiVien,
                        "dtuongUuTien": this.dtuongUuTien,
                        "email": this.email,
                        "gioiTinh": this.gioiTinh,
                        "hoTen": this.hoTen,
                        "hoTenBo": this.hoTenBo,
                        "hoTenMe": this.hoTenMe,
                        "khuyetTat": this.khuyetTat,
                        "maDanToc": this.maDanToc,
                        "maDtuongCsach": this.maDtuongCsach,
                        "maHocSinh": this.maHocSinh,
                        "maPxaThtru": this.maPxaThtru,
                        "maPxaTmtru": this.maPxaTmtru,
                        "maQhuyenThtru": this.maQhuyenThtru,
                        "maQhuyenTmtru": this.maQhuyenTmtru,
                        "maTonGiao": this.maTonGiao,
                        "maTthanhThtru": this.maTthanhThtru,
                        "maTthanhTmtru": this.maTthanhTmtru,
                        "maTthonThtru": this.maTthonThtru,
                        "maTthonTmtru": this.maTthonTmtru,
                        "namSinhBo": this.namSinhBo,
                        "namSinhMe": this.namSinhMe,
                        "ngayCapCmnd": this.ngayCapCmnd,
                        "ngaySinh": this.ngaySinh,
                        "ngayVaoDang": this.ngayVaoDang,
                        "ngayVaoDoan": this.ngayVaoDoan,
                        "ngayVaoDoi": this.ngayVaoDoi,
                        "ngheNghiepBo": this.ngheNghiepBo,
                        "ngheNghiepMe": this.ngheNghiepMe,
                        "nhomMau": this.nhomMau,
                        "noiCapCmnd": this.noiCapCmnd,
                        "noiLamViecBo": this.noiLamViecBo,
                        "noiLamViecMe": this.noiLamViecMe,
                        "noiSinh": this.noiSinh,
                        "noiVaoDang": this.noiVaoDang,
                        "noiVaoDoan": this.noiVaoDoan,
                        "noiVaoDoi": this.noiVaoDoi,
                        "queQuan": this.queQuan,
                        "soCmnd": this.soCmnd,
                        "soDienThoaiBo": this.soDienThoaiBo,
                        "soDienThoaiMe": this.soDienThoaiMe,
                        "soDthoaiDdong": this.soDthoaiDdong,
                        "tphanGdinh": this.tphanGdinh,
                        "namSinh": this.namSinh
                    };
                    console.log(params);
                    rest_api.post("/csdlgd-admin/hocSinh/update", params, data => {
                        console.log("Dữ liệu chỉnh sửa học sinh trả về:" + JSON.stringify(data));
                        if (data.data.rc == 0) {
                            this
                                .$alertify
                                .success("Chỉnh sửa dữ liệu học sinh thành công");
                            setTimeout(() => {
                                this.close();

                                this.$emit('reload')
                            }, 1500);
                        } else {
                            this
                                .$alertify
                                .error("Chỉnh sửa thất bại: " + data.data.rd);
                        }
                    });
                // dialog.confirmDialog("Xác nhận chỉnh sửa học sinh?", "Đồng ý", () => {
                // });
            },
            close() {
                this.$emit('close')
            }
        }
    }

</script>

<style scoped="scoped">
    label {
        font-size: 12px;
    }

    .col-md-2,
    .col-sm-3 {
        margin-bottom: 15px;
    }

    .checkdieukien {
        margin-top: 25px;
        text-align: left;
    }

    .form-control {
        font-size: 12px;
        height: 30px;
    }

</style>

<template>

    <div id="modal_them_truonghoc" ref="modal_them_truonghoc" class="modal fade">

        <div class="modal-dialog" style="width: 90%">
            <div class="modal-content">
                <form @submit.prevent="themTruongHocSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm trường học mới</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group formthem clearfix">
                                <div class="col-sm-3 inputhemtruong">
                                    <label style="">Mã trường học (<span style="color:#DC0101;">*</span>)</label>
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="ma_truong_hoc" type="text"
                                           min="0"
                                           v-model="ma_truong_hoc"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_truong_hoc')">{{ errors.first('ma_truong_hoc') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Tên trường học (<span style="color:#DC0101;">*</span>)</label>
                                    <input v-validate="{ required: true }" name="ten_truong_hoc" type="text"
                                           min="0"
                                           v-model="ten_truong_hoc"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_truong_hoc')">{{ errors.first('ten_truong_hoc') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label >Cấp học (<span style="color:#DC0101;">*</span>)</label>
                                    <select v-validate="{ required: true }" name="cap_hoc" class="form-control" v-model="capHoc">
                                        <option value=''>Chọn cấp học</option>
                                            <option v-for="ch in ds_cap_hoc" :value="ch.id">{{ch.name}}</option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('cap_hoc')">{{ errors.first('cap_hoc') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label >Chuẩn quốc gia (<span style="color:#DC0101;">*</span>)</label>
                                  <select v-validate="{ required: true }" name="chuan_quoc_gia"
                                            v-model="chuan_quoc_gia"
                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                            style="min-width: 50px;">
                                        <option value="0">Không đạt chuẩn</option>
                                        <option value="1">Chuẩn mức 1</option>
                                        <option value="2">Chuẩn mức 2</option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('chuan_quoc_gia')">{{ errors.first('chuan_quoc_gia') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Tỉnh thành (<span style="color:#DC0101;">*</span>)</label>
                                    <select v-validate="{ required: true }" name="ma_tinh_thanh"
                                        @change="onTinhThanhChange"
                                        v-model="ma_tinh_thanh"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px;">
                                        <option value="">--Chọn tỉnh thành--</option>
                                        <option v-for="tt in ds_tinh_thanh" :value="tt.maTinhThanh">{{tt.tenTinhThanh}}
                                        </option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_tinh_thanh')">{{ errors.first('ma_tinh_thanh') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Quận huyện (<span style="color:#DC0101;">*</span>)</label>
                                    <select v-validate="{ required: true }" name="ma_quan_huyen"
                                        @change="onQuanHuyenChange"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; "
                                        v-model="ma_quan_huyen">
                                        <option value="">--Chọn quận huyện--</option>
                                        <option v-for="qh in ds_quan_huyen" :value="qh.maQuanHuyen">{{qh.tenQuanHuyen}}
                                        </option>

                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_quan_huyen')">{{ errors.first('ma_quan_huyen') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Phường xã</label>
                                    <select
                                        @change="onPhuongXaChange"
                                        v-model="ma_phuong_xa"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px;">
                                        <option value="">--Chọn phường xã--</option>
                                        <option v-for="px in ds_phuong_xa" :value="px.maPhuongXa">{{px.tenPhuongXa}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Tổ thôn</label>
                                    <select
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px;">
                                        <option value="">--Chọn tổ thôn--</option>
                                        <option v-for="tt in ds_to_thon" :value="tt.maToThon">{{tt.tenToThon}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Đơn vị quản lý(<span style="color:#DC0101;">*</span>)</label>
                                    <select
                                            v-model="ma_don_vi_quan_ly"
                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                            style="min-width: 50px;">
                                        <option value="">--Chọn đơn vị--</option>
                                        <option v-for="dv in ds_don_vi_quan_ly" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Loại hình đào tạo (<span style="color:#DC0101;">*</span>)</label>
                                    <select v-validate="{ required: true }" name="loai_hinh_dao_tao" v-model="loai_hinh_dao_tao"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px;">
                                        <option value="">--Tất cả--</option>
                                        <option value="1">Công lập</option>
                                        <option value="2">Tư thục</option>
                                        <option value="3">GDTX</option>
                                        <option value="4">Bán công</option>
                                        <option value="5">Dân lập</option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('loai_hinh_dao_tao')">{{ errors.first('loai_hinh_dao_tao') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Loại hình trường (<span style="color:#DC0101;">*</span>)</label>
                                    <select v-validate="{ required: true }" name="loai_hinh_truong" v-model="loai_hinh_truong"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px;">
                                        <option value=''>--Chọn loại hình trường--</option>
                                        <option value='1'>Bình thường</option>
                                        <option value='2'>Dân tộc nội trú</option>
                                        <option value='3'>Khuyết tật</option>
                                        <option value='4'>Năng khiếu nghệ thuật</option>
                                        <option value='5'>Năng khiếu TDTT</option>
                                        <option value='6'>Trường chuyên</option>
                                        <option value='7'>Dân tộc bán trú</option>
                                        <option value='8'>Trường THPT kỹ thuật</option>
                                        <option value='9'>Trẻ em thiệt thòi</option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('loai_hinh_truong')">{{ errors.first('loai_hinh_truong') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Website</label>
                                    <input type="text"
                                        min="0"
                                        v-model="website"
                                        placeholder="Nhập..."
                                        class="form-control control-inline"
                                        style="min-width: 50px;"/>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Số điện thoại</label>
                                    <input v-validate="{max:10, regex: /0[0-9]{9}/}" name="so_dien_thoai" type="text"
                                       min="0"
                                       v-model="so_dien_thoai"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px;"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('so_dien_thoai')">{{ errors.first('so_dien_thoai') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Email</label>
                                    <input v-validate="{email : true}" name="email" type="text"
                                        min="0"
                                        v-model="email"
                                        placeholder="Nhập..."
                                        class="form-control control-inline"
                                        style="min-width: 50px;"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('email')">{{ errors.first('email') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Fax</label>
                                    <input type="text"
                                        min="0"
                                        v-model="fax"
                                        placeholder="Nhập..."
                                        class="form-control control-inline"
                                        style="min-width: 50px;"/>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Tên hiệu trưởng</label>
                                    <input type="text"
                                        min="0"
                                        v-model="ten_hieu_truong"
                                        placeholder="Nhập..."
                                        class="form-control control-inline"
                                        style="min-width: 50px;"/>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>SĐT hiệu trưởng</label>
                                    <input v-validate="{max:10, regex: /0[0-9]{9}/}" name="so_dien_thoai_hieu_truong" type="text"
                                        min="0"
                                        v-model="so_dien_thoai_hieu_truong"
                                        placeholder="Nhập..."
                                        class="form-control control-inline"
                                        style="min-width: 50px;"/>
                                      <span v-if="show_msg"><span class="text-danger" v-show="errors.has('so_dien_thoai_hieu_truong')">{{ errors.first('so_dien_thoai_hieu_truong') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Ngày thành lập</label>
                                    <date-picker class="form-control" style="min-width: 50px;" v-model="ngay_thanh_lap" :config="configDate"
                                                placeholder="Chọn ngày thành lập "></date-picker>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Địa chỉ</label>
                                    <input type="text"
                                        min="0"
                                        v-model="dia_chi"
                                        placeholder="Nhập..."
                                        class="form-control control-inline"
                                        style="min-width: 50px;"/>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Thông tin thêm</label>
                                    <div style="width:100%">
                                        <div class="democheck">
                                            <input v-model="vung_kho_khan" type="checkbox"><span>Vùng khó khăn</span>
                                        </div>
                                        <div class="democheck">
                                            <input v-model="vung_bien_gioi" type="checkbox"><span>Vùng biên giới</span>
                                        </div>
                                        <div class="democheck">
                                            <input v-model="chi_bo_dang" type="checkbox"><span>Chi bộ đảng</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                        </button>
                        <button type="submit" class="btn btn-primary">Thêm
                        </button>
                    </div>
                </form>
            </div>


        </div>

    </div>

</template>

<script>

    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import timeutils from '../../utils/time_utils';
    import utils from '../../utils'
    import api from '../api';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import vi from 'vee-validate/dist/locale/vi';
    import constant from '../../utils/constant';
    import VeeValidate, {Validator} from 'vee-validate';
    //Validator.localize('vi', vi);
    Vue.use(VeeValidate);

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: ['item', 'show'],
        components: {
            datePicker,
        },
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.reset();
                    $("#modal_them_truonghoc").modal();
                } else {
                    $("#modal_them_truonghoc").modal('hide');
                }
            }
        },

        data() {
            return {
                thongtin:{},
                capHoc:'',
                ds_cap_hoc: constant.LIST_CAP_HOC,
                ds_tinh_thanh: [],
                ds_quan_huyen: [],
                ds_phuong_xa: [],
                ds_to_thon: [],
                ma_truong_hoc: '',
                ten_truong_hoc: '',
                ma_tinh_thanh: '',
                ma_quan_huyen: '',
                ma_phuong_xa: '',
                cap_hoc: [],
                loai_hinh_dao_tao:'',
                loai_hinh_truong: '',
                ds_don_vi_quan_ly:[],
                ma_don_vi_quan_ly: '',
                chuan_quoc_gia: 0,
                vung_kho_khan: false,
                vung_bien_gioi:false,
                chi_bo_dang:false,
                website: '',
                so_dien_thoai: '',
                email: '',
                fax: '',
                ngay_thanh_lap: '',
                ten_hieu_truong: '',
                so_dien_thoai_hieu_truong: '',
                dia_chi: '',
                configDate: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                trang_thai: 1,
                show_msg: false
            }
        },


        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            if(this.thongtin.role2==2){
                this.ma_tinh_thanh = this.thongtin.ma_tinh_thanh;
            }
            $(this.$refs.modal_them_truonghoc).on("hidden.bs.modal", this.close);
            this.getTinhThanh();
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_truong_hoc: {
                            required: () => 'Mã trường học không thể trống',
                            max: () => 'Mã trường học không vượt quá 30 ký tự',
                            regex: () => 'Mã trường học chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        ten_truong_hoc: {
                            required: () => 'Tên trường học không thể trống'
                        },
                        cap_hoc:{
                            required: () => 'Cấp học không thể trống'
                        },
                        chuan_quoc_gia:{
                            required: () => 'Chuẩn quốc gia không thể trống'
                        },
                        loai_hinh_dao_tao:{
                            required: () => 'Loại hình đào tạo không thể trống'
                        },
                        loai_hinh_truong : {
                            required: () => 'Loại hình trường không thể trống'
                        },
                        ma_tinh_thanh : {
                            required: () => 'Tỉnh thành không thể trống'
                        },
                        cap_hoc : {
                            required: () => 'Cấp học không thể trống'
                        },
                        ma_quan_huyen : {
                            required: () => 'Quận Huyện không thể trống'
                        },
                        email : {
                            email: () => 'Email không đúng định dạng'
                        },
                        so_dien_thoai : {
                            regex: () => 'Số điện thoại không đúng'
                        },
                        so_dien_thoai_hieu_truong : {
                            regex: () => 'Số điện thoại không đúng'
                        }
                    }
                };
                this.$validator.localize('vi', dict);
            },
            themTruongHocSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.createTruongHoc();
                    }
                });
            },
            getDanhSachDonViQuanLy(){
                let params = {
                    "start": 0,
                    "limit": 1000,
                    "maTinhThanh":this.ma_tinh_thanh,
                    "loaiDonVi":2
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_don_vi_quan_ly);
                        this.ds_don_vi_quan_ly = data.data.rows;
                    }
                });
            },
            createTruongHoc() {
                console.log("thêm trường học");
                utils.confirmDialog("Xác nhận thêm trường học", "Thêm", () => {
                    const uri = "/internal-api/dmTruongHoc/create";
                    const params = {
                        // "capHoc": this.getCapHoc(this.cap_hoc),
                        "capHoc": this.capHoc,
                        "chiBoDang": (this.chi_bo_dang) ? 1 : 0,
                        "chuanQuocGia": this.chuan_quoc_gia,
                        "diaChi": this.dia_chi,
                        "email": this.email,
                        "fax": this.fax,
                        "idPhong": this.ma_don_vi_quan_ly,
                        "idSo": this.ma_tinh_thanh,
                        "loaiHinhDaoTao": this.loai_hinh_dao_tao,
                        "loaiHinhTruong": this.loai_hinh_truong,
                        "ma": this.ma_truong_hoc,
                        "maDonVi": this.ma_don_vi_quan_ly,
                        "maPhuongXa": this.ma_phuong_xa,
                        "maQuanHuyen": this.ma_quan_huyen,
                        "maTinhThanh": this.ma_tinh_thanh,
                        "maToThon": this.ma_to_thon,
                        "ngayThanhLap": this.ngay_thanh_lap,
                        "sdt": this.so_dien_thoai,
                        "sdtHieuTruong": this.so_dien_thoai_hieu_truong,
                        "ten": this.ten_truong_hoc,
                        "tenHieuTruong": this.ten_hieu_truong,
                        "trangThai": this.trang_thai,
                        "vungBienGioi": (this.vung_bien_gioi) ? 1 : 0,
                        "vungKhoKhan": (this.vung_kho_khan) ? 1 : 0,
                        "website": this.website
                    };
                    console.log("11111111111111");
                    console.log(params);
                    rest_api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm trường học thành công", null, () => {
                                this.$emit('success', params);
                                this.show_msg = false;
                                this.reset();
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
                console.log("close modal");
                this.reset();
                this.show_msg = false;
                this.$emit('close');
            },
            getCapHoc(caphoc){
                var text = '';
                for(var i = 0; i< caphoc.length; i++){
                    text += caphoc[i];
                }
                return text;
            },
            setCapHoc(caphoc){
                var mang_cap_hoc = [];
                for(var i = 0; i< caphoc.length; i++){
                    if(s.charAt(i) != '4' && s.charAt(i) != '5'){
                        mang_cap_hoc.push(s.charAt(i));
                    }
                }
                if(caphoc.indexOf('45') != -1){
                    mang_cap_hoc.push('45');
                }
            },
            getTinhThanh() {
                let params = {
                    "start": 0,
                    "limit": 100,
                };
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_tinh_thanh);
                        this.ds_tinh_thanh = data.data.rows;
                    }
                });
            },
            getQuanHuyen() {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maTinhThanh": this.ma_tinh_thanh,
                };
                console.log("lấy ds quận huyện:" + params);
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.ds_quan_huyen = data.data.rows;
                    }
                });
            },
            getPhuongXa() {
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maTinhThanh": this.ma_tinh_thanh,
                    "maQuanHuyen": this.ma_quan_huyen,
                };
                console.log("lấy ds quận huyện:" + params);
                rest_api.get("/internal-api/dmPhuongXa/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.ds_phuong_xa = data.data.rows;
                    }
                });
            },
            getToThon() {
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maTinhThanh": this.ma_tinh_thanh,
                    "maQuanHuyen": this.ma_quan_huyen,
                    "maPhuongXa": this.ma_phuong_xa,
                };
                console.log("lấy ds quận huyện:" + params);
                rest_api.get("/internal-api/dmToThon/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.ds_to_thon = data.data.rows;
                    }
                });
            },
            onTinhThanhChange() {
                array_util.clearArrays(this.ds_quan_huyen);
                array_util.clearArrays(this.ds_phuong_xa);
                array_util.clearArrays(this.ds_to_thon);
                array_util.clearArrays(this.ds_don_vi_quan_ly);
                if (this.ma_tinh_thanh === "") {
                    this.ma_quan_huyen = "";
                    this.ma_phuong_xa = "";
                    this.ma_to_thon = "";
                    this.ma_don_vi_quan_ly = "";
                    return;
                }
                this.ma_quan_huyen = "";
                this.ma_phuong_xa = "";
                this.ma_to_thon = "";
                this.getQuanHuyen();
                this.getDanhSachDonViQuanLy();
            },
            onQuanHuyenChange() {
                console.log("chọn huyện");
                array_util.clearArrays(this.ds_phuong_xa);
                array_util.clearArrays(this.ds_to_thon);
                if (this.ma_quan_huyen === "") {
                    this.ma_phuong_xa = "";
                    this.ma_to_thon = "";
                    return;
                }
                this.ma_phuong_xa = "";
                this.ma_to_thon = "";
                console.log(this.ma_phuong_xa);
                this.getPhuongXa();
            },
            onPhuongXaChange() {
                array_util.clearArrays(this.ds_to_thon);
                if (this.ma_phuong_xa === "") {
                    this.ma_to_thon = "";
                    return;
                }
                this.ma_to_thon = "";
                this.getToThon();
            },
            reset(){
                //ds_tinh_thanh: [],
                this.ds_quan_huyen = [],
                this.ds_phuong_xa = [],
                this.ds_to_thon = [],
                this.ma_truong_hoc = '',
                this.ten_truong_hoc = '',
                this.ma_tinh_thanh = '',
                this.ma_quan_huyen = '',
                this.ma_phuong_xa = '',
                this.cap_hoc = [],
                this.loai_hinh_dao_tao = '',
                this.loai_hinh_truong = '',
                this.ds_don_vi_quan_ly = [],
                this.ma_don_vi_quan_ly = '',
                this.chuan_quoc_gia = 0,
                this.vung_kho_khan= false,
                this.vung_bien_gioi=false,
                this.chi_bo_dang=false,
                this.website = '',
                this.so_dien_thoai = '',
                this.email = '',
                this.fax = '',
                this.ngay_thanh_lap = '',
                this.ten_hieu_truong = '',
                this.so_dien_thoai_hieu_truong =  '',
                this.dia_chi = ''
            }
        }

    }
</script>
<style scoped>
    .form-check-inline{
        display: inline-flex;
        align-items: center;
        padding-left: 0;
        margin-right: .75rem;
    }
    .form-check-inline label{
        margin-bottom: 0;
        margin-left: 5px;
        position: relative;
        top: 2px;
    }
    .col-sm-3{
        padding-top:25px;
    }
    .formthem > .col-sm-3:nth-child(n) {
    }
    .democheck{
    width: 33.33%;
    float: left;
    }
    .inputhemtruong{
        height:80px;
    }
    /* @media only screen and (max-width: 1192) {
    .inputhemtruong{
        width:75px;
        display: none;
    } */
/* } */
</style>

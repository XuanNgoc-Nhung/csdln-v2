<template>
    <div id="modal_them_truonghoc" ref="modal_them_truonghoc" class="modal fade">
        <div class="modal-dialog" style="width: 100%; margin:0 !important">
            <div class="modal-content">
                <form @submit.prevent="themTruongHocSubmit">
                    <div class="modal-header">
                        <h4 class="modal-title text-uppercase">Chỉnh sửa trường học</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div>
                            <div class="form-group formthem clearfix">
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Tỉnh thành (<span style="color:red;">*</span>)</label>
                                    <div v-if="thongtin.role==1">
                                        <multiselect v-model="danhSachTinhThanh" :options="ds_tinh_thanh"
                                            :close-on-select="true" name="ma_tinh_thanh" v-validate="{ required: true }"
                                            :clear-on-select="false" :preserve-search="false" deselectLabel="Đã chọn"
                                            @close="onChonTinhThanh" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                                            :custom-label="setNameTinhThanh" placeholder="Chọn tỉnh/thành"
                                            label="maTinhThanh" track-by="maTinhThanh"></multiselect>
                                        <span v-if="show_msg"><span class="text-danger"
                                                v-show="errors.has('ma_tinh_thanh')">{{ errors.first('ma_tinh_thanh') }}</span></span>
                                    </div>
                                    <div v-else>
                                        <input disabled type="text" class="form-control"
                                            :value="thongtinso.tenTinhThanh" />
                                    </div>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Quận huyện (<span style="color:red;">*</span>)</label>
                                    <div>
                                        <multiselect v-model="danhSachQuanHuyen" :options="ds_quan_huyen"
                                            :close-on-select="true" :clear-on-select="false"
                                            v-validate="{ required: true }" name="ma_quan_huyen"
                                            :preserve-search="false" deselectLabel="Đã chọn" @close="onChonQuanHuyen"
                                            @open="moQuanHuyen" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                                            :custom-label="setNameQuanHuyen" placeholder="Chọn quận/huyện"
                                            label="maQuanHuyen" track-by="maQuanHuyen"></multiselect>
                                        <span v-if="show_msg"><span class="text-danger"
                                                v-show="errors.has('ma_quan_huyen')">{{ errors.first('ma_quan_huyen') }}</span></span>
                                    </div>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Phường xã</label>
                                    <div>
                                        <multiselect v-model="danhSachPhuongXa" :options="ds_phuong_xa"
                                            :close-on-select="true" @open="moPhuongXa" :clear-on-select="false"
                                            :preserve-search="false" deselectLabel="Đã chọn" @close="onChonPhuongXa"
                                            selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                                            :custom-label="setNamePhuongXa" placeholder="Chọn phường/xã"
                                            label="maPhuongXa" track-by="maPhuongXa"></multiselect>
                                    </div>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Tổ thôn</label>
                                    <div>
                                        <input type="text" class="form-control" v-model="maTthon"
                                            placeholder="Nhập...">
                                    </div>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Đơn vị quản lý (<span style="color:red;">*</span>)</label>
                                    <div>
                                        <multiselect v-model="danhSachDonViQuanLy" :options="ds_don_vi_quan_ly"
                                            :close-on-select="true" :clear-on-select="false"
                                            v-validate="{ required: true }" name="don_vi_quan_ly"
                                            :preserve-search="false" deselectLabel="Đã chọn" @open="moDonViQuanLy"
                                            @close="onChonDonViQuanLy" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                                            :custom-label="setNameDonVi" placeholder="Chọn đơn vị quản lý"
                                            label="maDonVi" track-by="maDonVi"></multiselect>
                                        <span v-if="show_msg"><span class="text-danger"
                                                v-show="errors.has('don_vi_quan_ly')">{{ errors.first('don_vi_quan_ly') }}</span></span>

                                    </div>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label style="">Mã trường học (<span style="color:red;">*</span>)</label>
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }"
                                        v-model="maTruongHoc" disabled name="ma_truong_hoc" type="text" min="0"
                                        placeholder="Nhập..." class="form-control control-inline"
                                        style="min-width: 50px;" />
                                    <span v-if="show_msg">
                                        <span class="text-danger"
                                            v-show="errors.has('ma_truong_hoc')">{{ errors.first('ma_truong_hoc') }}</span>
                                    </span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Tên trường học (<span style="color:red;">*</span>)</label>
                                    <input v-model="tenTruongHoc" v-validate="{ required: true }" name="ten_truong_hoc"
                                        type="text" min="0" placeholder="Nhập..."
                                        class="form-control control-inline" style="min-width: 50px;" />
                                    <span v-if="show_msg">
                                        <span class="text-danger"
                                            v-show="errors.has('ten_truong_hoc')">{{ errors.first('ten_truong_hoc') }}</span>
                                    </span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Cấp học (<span style="color:red;">*</span>)</label>
                                    <div>
                                        <multiselect v-model="danhSachCapHoc" :options="list_cap_hoc"
                                            :close-on-select="false" :clear-on-select="false" name="cap_hoc"
                                            v-validate="{ required: true }" :preserve-search="false" :limit="1"
                                            :limit-text="limitTextCapHoc" deselectLabel="Đã chọn" :multiple="true"
                                            @close="onChonCapHoc" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                                            :custom-label="setNameCapHoc" placeholder="Chọn cấp học" label="name"
                                            track-by="name">
                                            <template v-if="danhSachCapHoc.length>0" slot="selection"
                                                slot-scope="{ values, search, isOpen }">
                                                <span class="multiselect__single"
                                                    v-if="values.length &amp;&amp; !isOpen">{{ danhSachCapHoc.length }}
                                                    cấp học được chọn</span>
                                            </template>
                                            <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                                            <span slot="noOptions">Danh sách trống</span>
                                        </multiselect>
                                        <span v-if="show_msg"><span class="text-danger"
                                                v-show="errors.has('cap_hoc')">{{ errors.first('cap_hoc') }}</span></span>
                                    </div>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Loại hình đào tạo (<span style="color:red;">*</span>)</label>
                                    <el-select v-model="loaiHinhDaoTao" v-validate="{ required: true }"
                                        name="loai_hinh_dao_tao" filterable collapse-tags placeholder="Chọn"
                                        no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                        <el-option v-for="item in ds_loai_hinh_dao_tao" :key="item.value"
                                            :label="item.name" :value="item.value">
                                        </el-option>
                                    </el-select>
                                    <span v-if="show_msg"><span class="text-danger"
                                            v-show="errors.has('loai_hinh_dao_tao')">{{ errors.first('loai_hinh_dao_tao') }}</span></span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Loại hình trường (<span style="color:red;">*</span>)</label>
                                    <div>
                                        <el-select v-model="loaiHinhTruong" v-validate="{ required: true }"
                                            name="loai_hinh_truong" filterable collapse-tags placeholder="Chọn"
                                            no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="item in ds_loai_hinh_truong" :key="item.value"
                                                :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                        <span v-if="show_msg"><span class="text-danger"
                                                v-show="errors.has('loai_hinh_truong')">{{ errors.first('loai_hinh_truong') }}</span></span>
                                    </div>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Ngày thành lập (<span style="color:red;">*</span>)</label>
                                    <date-picker class="form-control" style="min-width: 50px;"
                                        v-validate="{ required: true }" v-model="ngayThanhLap" name="ngay_thanh_lap"
                                        :config="configDate" placeholder="Chọn ngày thành lập ">
                                    </date-picker>
                                    <span v-if="show_msg">
                                        <span class="text-danger"
                                            v-show="errors.has('ngay_thanh_lap')">{{ errors.first('ngay_thanh_lap') }}</span>
                                    </span>

                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label> Chuẩn quốc gia</label>
                                    <select v-model="chuanQuocGia"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px;">
                                        <option v-for="hi in ds_chuan_quoc_gia" :value="hi.value">{{hi.name}}</option>

                                    </select>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Website</label>
                                    <input type="text" min="0" v-model="website" placeholder="Nhập..."
                                        class="form-control control-inline" style="min-width: 50px;" />
                                </div>
                                <!-- <div class="col-sm-3 inputhemtruong">
                                    <label>Số điện thoại</label>
                                    <input v-model="soDienThoai" v-validate="{max:12, regex: /0[0-9]{9}/}"
                                        name="so_dien_thoai" type="number" min="0" placeholder="Nhập..."
                                        class="form-control control-inline" style="min-width: 50px;" />
                                    <span v-if="show_msg">
                                        <span class="text-danger"
                                            v-show="errors.has('so_dien_thoai')">{{ errors.first('so_dien_thoai') }}</span>
                                    </span>
                                </div> -->
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Tên hiệu trưởng</label>
                                    <input type="text" v-model="tenHieuTruong" min="0"
                                        placeholder="Nhập..." class="form-control control-inline"
                                        style="min-width: 50px;" />
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Email</label>
                                    <input name="email" v-model="email" type="text" min="0" v-validate="{email : true}"
                                        placeholder="Nhập..." class="form-control control-inline"
                                        style="min-width: 50px;" />
                                    <span v-if="show_msg">
                                        <span class="text-danger"
                                            v-show="errors.has('email')">{{ errors.first('email') }}</span>
                                    </span>
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Fax</label>
                                    <input type="text" min="0" v-model="fax" placeholder="Nhập..."
                                        class="form-control control-inline" style="min-width: 50px;" />
                                </div>
                                <!-- <div class="col-sm-3 inputhemtruong">
                                    <label>SĐT hiệu trưởng</label>
                                    <input v-model="sdtHieuTruong" v-validate="{max:10, regex: /0[0-9]{9}/}"
                                        name="so_dien_thoai_hieu_truong" type="text" min="0"
                                        placeholder="Nhập..." class="form-control control-inline"
                                        style="min-width: 50px;" />
                                    <span v-if="show_msg">
                                        <span class="text-danger"
                                            v-show="errors.has('so_dien_thoai_hieu_truong')">{{ errors.first('so_dien_thoai_hieu_truong') }}</span>
                                    </span>
                                </div> -->
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Địa chỉ</label>
                                    <input type="text" min="0" v-model="diaChi" placeholder="Nhập..."
                                        class="form-control control-inline" style="min-width: 50px;" />
                                </div>
                                <div class="col-sm-3 inputhemtruong">
                                    <label>Trạng thái</label>
                                    <select v-model="trangThai"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px;">
                                        <option value="0">Ngưng hoạt động</option>
                                        <option value="1">Đang hoạt động</option>
                                        <option value="-1">Đã xóa</option>
                                    </select>
                                </div>
                                <!-- <div class="col-sm-3 inputhemtruong" style="display:none">
                                    <label>Thông tin thêm</label>
                                    <div style="width:100%">
                                        <div class="democheck">
                                            <input v-model="vungKhoKhan" type="checkbox" />
                                            <span>Vùng khó khăn</span>
                                        </div>
                                        <div class="democheck">
                                            <input v-model="vungBienGioi" type="checkbox" />
                                            <span>Vùng biên giới</span>
                                        </div>
                                        <div class="democheck">
                                            <input v-model="chiBoDang" type="checkbox" />
                                            <span>Chi bộ đảng</span>
                                        </div>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                        </button>
                        <button type="submit" class="btn btn-primary">Sửa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../../utils/rest_api';
    import timeutils from '../../../utils/time_utils';
    import utils from '../../../utils'
    import api from '../../api';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import vi from 'vee-validate/dist/locale/vi';
    import constant from '../../../utils/constant';
    import ElementUI from 'element-ui';
    Vue.use(ElementUI);
    import VeeValidate, {
        Validator
    } from 'vee-validate';

    Vue.use(VeeValidate);
    export default {
        props: ['item'],
        components: {
            Multiselect,
            datePicker
        },
        watch: {},

        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                thongtinso: {},
                configDate: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                //  gửi đi
                maTruongHoc: "",
                tenTruongHoc: "",
                capHoc: "",
                capHocs: "",
                chuanQuocGia: 0,
                maTinhThanh: "",
                maQuanHuyen: "",
                maPhuongXa: "",
                maTthon: "",
                maDonViQuanLy: "",
                loaiHinhDaoTao: "",
                loaiHinhTruong: "",
                website: "",
                soDienThoai: "",
                email: "",
                fax: "",
                tenHieuTruong: "",
                sdtHieuTruong: "",
                ngayThanhLap: "",
                diaChi: "",
                vungKhoKhan: false,
                vungBienGioi: false,
                chiBoDang: false,
                trangThai: "",
                //  form
                show_msg: false,
                danhSachCapHoc: [],
                danhSachTinhThanh: "",
                danhSachQuanHuyen: "",
                danhSachPhuongXa: "",
                danhSachToThon: "",
                danhSachDonViQuanLy: "",
                // list_cap_hoc: window.listCapHoc,
               list_cap_hoc: [
                    {name:'Mầm non',id:'01'},
                    {name:'Mẫu giáo',id:'02'},
                    {name:'Nhà trẻ',id:'03'},
                    {name:'Nhóm nhà trẻ độc lập',id:'04'},
                    {name:'Lớp mẫu giáo độc lập',id:'05'},
                    {name:'Tiểu học',id:'06'},
                    {name:'THCS',id:'07'},
                    {name:'THPT',id:'08'},
                    {name:'PTCS',id:'09'},
                    {name:'Trung học',id:'10'},
                    {name:'Phổ thông',id:'11'},
                    {name:'GDTX Tỉnh',id:'12'},
                    {name:'GDTX Huyện',id:'13'},
                    {name:'TTKTTHHN',id:'14'},
                    {name:'Lớp nhô',id:'15'},
                    {name:'MN-TH',id:'16'},
                    {name:'MN-PT',id:'17'},
                    {name:'MN-PTCS',id:'18'},
                    {name:'Nhóm trẻ, lớp mẫu giáo độc lập',id:'19'},
                ],
                ds_tinh_thanh: [],
                ds_quan_huyen: [],
                ds_phuong_xa: [],
                ds_to_thon: [],
                ds_don_vi_quan_ly: [],
                ds_loai_hinh_dao_tao: [{
                        name: "Dân lập",
                        value: "5"
                    },
                    {
                        name: "Tư thục",
                        value: "2"
                    },
                    {
                        name: "Công lập",
                        value: "1"
                    },
                    {
                        name: "GDTX",
                        value: "3"
                    },
                ],
                ds_loai_hinh_truong: [],
                ds_chuan_quoc_gia: [],
            }
        },

        mounted: function () {
            this.ganDuLieuSME();
            this.mapIntValue();
            $("#modal_them_truonghoc").modal();
            if (this.thongtin.role == 1) {
                this.getTinhThanh();
            }
            if (this.thongtin.role2 == 2) {
                this.maTinhThanh = this.thongtin.ma_so;

                let params = {
                    "start": 0,
                    "limit": 100,
                    "ma": this.thongtin.ma_so
                };

                let loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    loading.close();
                    console.log("lấy tỉnh 1" + JSON.stringify(data.data))
                    this.ds_tinh_thanh = data.data.rows;
                    this.thongtinso = this.ds_tinh_thanh[0];
                });
            }
            console.log("Chỉnh sửa trường học:");
            console.log(JSON.stringify(this.item));
            this.bindData(this.item);
            $(this.$refs.modal_them_truonghoc).on("hidden.bs.modal", this.close);
            this.customMessage();
        },
        methods: {
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_loai_hinh_dao_tao_sme"];
                if (tmp) {
                    // this.ds_loai_hinh_dao_tao = JSON.parse(localStorage["danh_sach_loai_hinh_dao_tao_sme"]);
                    this.ds_loai_hinh_truong = JSON.parse(localStorage["danh_sach_loai_hinh_truong_sme"]);
                    this.ds_chuan_quoc_gia = JSON.parse(localStorage["danh_sach_chuan_quoc_gia_sme"]);
                }
            },
            mapIntValue() {
                for (let k = 0; k < this.ds_loai_hinh_dao_tao.length; k++) {
                    if (this.ds_loai_hinh_dao_tao[k].value) {
                        this.ds_loai_hinh_dao_tao[k].value = parseInt(this.ds_loai_hinh_dao_tao[k].value)
                    }
                }
                for (let i = 0; i < this.ds_loai_hinh_truong.length; i++) {
                    if (this.ds_loai_hinh_truong[i].value) {
                        this.ds_loai_hinh_truong[i].value = parseInt(this.ds_loai_hinh_truong[i].value)
                    }
                }
            },
            limitTextCapHoc(count) {
                return `và ${count} cấp học khác`
            },
            // Gán dữ liệu
            bindData(e) {
                console.log(JSON.stringify(e));
                this.maTruongHoc = e.maTruongHoc;
                this.tenTruongHoc = e.tenTruongHoc;
                this.chuanQuocGia = e.chuanQuocGia;
                this.website = e.website;
                this.soDienThoai = e.sdt;
                this.email = e.email;
                this.fax = e.fax;
                this.tenHieuTruong = e.tenHieuTruong;
                this.sdtHieuTruong = e.sdtHieuTruong;
                this.ngayThanhLap = e.ngayThanhLap;
                this.diaChi = e.diaChi;
                this.vungKhoKhan = e.vungKhoKhan;
                this.vungBienGioi = e.vungBienGioi;
                this.chiBoDang = e.chiBoDang;
                this.loaiHinhDaoTao = e.loaiHinhDaoTao;
                this.loaiHinhTruong = e.loaiHinhTruong;
                this.trangThai = e.trangThai;
                this.maTthon = e.maTthon;
                this.bindCapHoc(e.capHoc);
                this.bindTinhThanh(e.maTthanh, e.maQhuyen, e.maPxa, e.maDonVi);
                this.onChonCapHoc();
            },
            bindCapHoc(e) {
                console.log("cấp học:" + e)
                console.log("cấp hoc bind lai:" + e)
                let chdemo = e.split("");
                let ch = this.boPhanTuTrung(chdemo)
                console.log('hi:' + JSON.stringify(ch));
                for (let j = 0; j < ch.length; j++) {
                    console.log("Cấp học:" + JSON.stringify(ch[j]));
                    for (let i = 0; i < this.list_cap_hoc.length; i++) {
                        console.log("mqh:" + JSON.stringify(this.list_cap_hoc[i]));
                        if (this.list_cap_hoc[i].id == ch[j]) {
                            this.danhSachCapHoc.push(this.list_cap_hoc[i]);
                        }
                    }
                }
            },
            boPhanTuTrung(arr) {
                return arr.filter((value, index, arr) => arr.indexOf(value) === index);
            },
            bindTinhThanh(a, b, c, d, e) {
                let params = {
                    "start": 0,
                    "limit": 100
                };
                console.log("e là:" + a);
                let params2 = {
                    "start": 0,
                    "limit": 1000,
                    //   "loaiDonVi":2
                };
                let loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params2, (data) => {
                    loading.close();
                    this.ds_don_vi_quan_ly = data.data.rows;
                    for (let j = 0; j < this.ds_don_vi_quan_ly.length; j++) {
                        if (this.ds_don_vi_quan_ly[j].maDonVi == d) {
                            this.danhSachDonViQuanLy = this.ds_don_vi_quan_ly[j];
                            this.maDonViQuanLy = d;
                        }
                    }
                });

                let loading2 = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    loading2.close()
                    console.log("Lấy tỉnh thành:")
                    this.ds_tinh_thanh = data.data.rows;
                    for (let i = 0; i < this.ds_tinh_thanh.length; i++) {
                        if (this.ds_tinh_thanh[i].maTinhThanh == a) {
                            console.log("Tỉnh là:" + JSON.stringify(this.ds_tinh_thanh[i]));
                            this.danhSachTinhThanh = this.ds_tinh_thanh[i];
                            this.maTinhThanh = a;
                            if (2 == 2) {
                                let params = {
                                    "start": 0,
                                    "limit": 999,
                                    "maTinhThanh": this.maTinhThanh
                                };

                                let loading = this.$loading({
                                    lock: true,
                                    text: 'Loading',
                                    spinner: 'el-icon-loading',
                                    background: 'rgba(0, 0, 0, 0.7)'
                                });
                                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (data) => {
                                    loading.close();
                                    console.log("Lấy quận huyện:")
                                    this.ds_quan_huyen = data.data.rows;
                                    for (let k = 0; k < this.ds_quan_huyen.length; k++) {
                                        if (this.ds_quan_huyen[k].maQuanHuyen == b) {
                                            console.log("Huyện trùng là")
                                            this.danhSachQuanHuyen = this.ds_quan_huyen[k];
                                            this.maQuanHuyen = b;
                                            if (c) {
                                                let params = {
                                                    "start": 0,
                                                    "limit": 100,
                                                    "maTinhThanh": this.maTinhThanh,
                                                    "maQuanHuyen": this.maQuanHuyen
                                                };
                                                let loading = this.$loading({
                                                    lock: true,
                                                    text: 'Loading',
                                                    spinner: 'el-icon-loading',
                                                    background: 'rgba(0, 0, 0, 0.7)'
                                                });
                                                rest_api.get("/internal-api/dmPhuongXa/filter", params,
                                                    (data) => {
                                                        loading.close();
                                                        this.ds_phuong_xa = data.data.rows;
                                                        for (let j = 0; j < this.ds_phuong_xa
                                                            .length; j++) {
                                                            if (this.ds_phuong_xa[j].maPhuongXa ==
                                                                c) {
                                                                this.danhSachPhuongXa = this
                                                                    .ds_phuong_xa[j];
                                                                this.maPhuongXa = c;
                                                            }
                                                        }
                                                    });
                                            }
                                        }
                                    }
                                });
                            }
                        }
                    }
                });
            },
            //Mở quận huyện
            moQuanHuyen() {
                if (this.ds_quan_huyen.length == 0) {
                    this.thongBao('error', 'Danh sách quận huyện trống. Thử lại bằng cách chọn tỉnh thành')
                }
            },
            //Mở quận huyện
            moPhuongXa() {
                if (this.ds_phuong_xa.length == 0) {
                    this.thongBao('error', 'Danh sách phường xã trống. Thử lại bằng cách chọn quận huyện')
                }
            },
            //Mở quận huyện
            moToThon() {
                if (this.ds_to_thon.length == 0) {
                    this.thongBao('error', 'Danh sách tổ thôn trống. Thử lại bằng cách chọn phường xã')
                }
            },
            //Mở quận huyện
            moDonViQuanLy() {
                if (this.ds_don_vi_quan_ly.length == 0) {
                    this.thongBao('error', 'Danh sách đơn vị quản lý trống. Thử lại bằng cách chọn tỉnh thành')
                }
            },

            customMessage() {
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
                        cap_hoc: {
                            required: () => 'Cấp học không thể trống'
                        },
                        chuan_quoc_gia: {
                            required: () => 'Chuẩn quốc gia không thể trống'
                        },
                        loai_hinh_dao_tao: {
                            required: () => 'Loại hình đào tạo không thể trống'
                        },
                        loai_hinh_truong: {
                            required: () => 'Loại hình trường không thể trống'
                        },
                        ma_tinh_thanh: {
                            required: () => 'Tỉnh thành không thể trống'
                        },
                        cap_hoc: {
                            required: () => 'Cấp học không thể trống'
                        },
                        ma_quan_huyen: {
                            required: () => 'Quận Huyện không thể trống'
                        },
                        don_vi_quan_ly: {
                            required: () => 'Đơn vị quản lý không thể trống'
                        },
                        loai_hinh_dao_tao: {
                            required: () => 'Loại hình đào tạo không thể trống'
                        },
                        loai_hinh_truong: {
                            required: () => 'Loại hình trường không thể trống'
                        },
                        ngay_thanh_lap: {
                            required: () => 'Ngày thành lập không thể trống'
                        },
                        email: {
                            email: () => 'Email không đúng định dạng'
                        },
                        so_dien_thoai: {
                            regex: () => 'Số điện thoại không đúng'
                        },
                        so_dien_thoai_hieu_truong: {
                            regex: () => 'Số điện thoại không đúng'
                        }
                    }
                };
                this
                    .$validator
                    .localize('vi', dict);
            },
            // thêm trường
            updateTruongHoc() {
                const uri = "/api_chinh_sua_truong_hoc";
                const params = {
                    "capHoc": parseInt(this.capHoc),
                    "capHocs": this.capHocs,
                    "chiBoDang": (this.chiBoDang) ?
                        1 : 0,
                    "chuanQuocGia": this.chuanQuocGia,
                    "diaChi": this.diaChi,
                    "email": this.email,
                    "fax": this.fax,
                    "idPhong": this.maDonViQuanLy,
                    "idSo": this.maTinhThanh,
                    "loaiHinhDaoTao": this.loaiHinhDaoTao,
                    "loaiHinhTruong": this.loaiHinhTruong,
                    "ma": this.maTruongHoc,
                    "maDonVi": this.maDonViQuanLy,
                    "maPhuongXa": this.maPhuongXa,
                    "maQuanHuyen": this.maQuanHuyen,
                    "maTinhThanh": this.maTinhThanh,
                    "maToThon": this.maTthon,
                    "ngayThanhLap": null,
                    "sdt": this.soDienThoai,
                    "sdtHieuTruong": this.sdtHieuTruong,
                    "ten": this.tenTruongHoc,
                    "tenHieuTruong": this.tenHieuTruong,
                    "trangThai": this.trangThai,
                    "vungBienGioi": (this.vungBienGioi) ?
                        1 : 0,
                    "vungKhoKhan": (this.vungKhoKhan) ?
                        1 : 0,
                    "website": this.website
                };
                if (this.ngayThanhLap) {
                    let darr = this
                        .ngayThanhLap
                        .split("/")
                    var dobj = new Date(
                        parseInt(darr[2]),
                        parseInt(darr[1]) - 1,
                        parseInt(darr[0])
                    );
                    dobj = dobj.toISOString();
                    params.ngayThanhLap = dobj;
                }
                this.$confirm('Xác nhận?', 'Thông báo', {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy',
                    closeOnClickModal: false,
                })
                    .then(_ => {

                        rest_api.post("/internal-api/dmTruongHoc/update", params, (res) => {
                            if(res){
                                console.log(res);
                                console.log("THông tin chỉnh sửa trả về:")
                            }
                        });
                    })
                    .catch(_ => {});
                // utils.confirmDialog("Xác nhận sửa trường học", "Sửa", () => {
                //     api.post(uri, params, (response) => {
                //         console.log(response);
                //         if (response.data.code === 200) {
                //             this.thongBao('success', 'Chỉnh sửa thành công')
                //             a
                //         } else {
                //             this.thongBao('error', response.data.message)
                //         }
                //     });
                // });
            },
            thongBao(t, e) {
                let msg = "";
                let cl = "";
                if (e) {
                    msg = e;
                }
                let type = "success";
                if (t) {
                    type = t
                }
                if (type == "success") {
                    cl = "dts-noty-success"
                }
                if (type == "warning") {
                    cl = "dts-noty-warning"
                }
                if (type == "error") {
                    cl = "dts-noty-error"
                }
                if (type == "info") {
                    cl = "dts-noty-info"
                }
                this.$message({
                    customClass: cl,
                    showClose: true,
                    message: msg,
                    type: t,
                    duration: 5000
                });
            },
            // check thêm trường
            themTruongHocSubmit() {
                this.show_msg = true;
                this
                    .$validator
                    .validateAll()
                    .then(result => {
                        if (result) {
                            this.updateTruongHoc();
                        }
                    });
            },
            //   Chọn đơn vị quản lý
            onChonDonViQuanLy() {
                this.maDonViQuanLy = "";
                if (this.danhSachDonViQuanLy) {
                    this.maDonViQuanLy = this.danhSachDonViQuanLy.maDonVi;
                }
            },
            onChonToThon() {
                this.maToThon = "";
                if (this.danhSachToThon) {
                    this.maToThon = this.danhSachToThon.maToThon;
                }
            },
            //   CHọn phường xã
            onChonPhuongXa() {
                this.maPhuongXa = "";
                this.maToThon = "";
                this.danhSachToThon = "";
                this.ds_to_thon = [];
                if (this.danhSachPhuongXa) {
                    this.maPhuongXa = this.danhSachPhuongXa.maPhuongXa;
                    this.getToThon();
                }
            },
            //   Chọn quận huyện
            onChonQuanHuyen() {
                this.maQuanHuyen = "";
                this.maPhuongXa = "";
                this.maToThon = "";
                this.ds_phuong_xa = [];
                this.ds_to_thon = [];
                this.danhSachPhuongXa = [];
                this.danhSachToThon = [];
                if (this.danhSachQuanHuyen) {
                    this.maQuanHuyen = this.danhSachQuanHuyen.maQuanHuyen;
                    this.getPhuongXa();
                }
            },
            // Lấy đơn vị
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 1000,
                    "maTinhThanh": this.maTinhThanh,
                    //   "loaiDonVi":2
                };
                let loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    this.ds_don_vi_quan_ly = data.data.rows;
                });
            },
            //   chọn tỉnh thành
            onChonTinhThanh() {
                this.maTinhThanh = "";
                this.maQuanHuyen = "";
                this.maPhuongXa = "";
                this.maToThon = "";
                this.maDonViQuanLy = "";
                this.danhSachQuanHuyen = "";
                this.danhSachPhuongXa = "";
                this.danhSachToThon = "";
                this.danhSachDonViQuanLy = "";
                this.ds_quan_huyen = [];
                this.ds_phuong_xa = [];
                this.ds_to_thon = [];
                this.ds_don_vi_quan_ly = [];
                if (this.danhSachTinhThanh) {
                    this.maTinhThanh = this.danhSachTinhThanh.maTinhThanh;
                    this.getQuanHuyen();
                    this.getDonVi();
                }
            },
            // Lấy tổ thôn
            getToThon() {
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maTinhThanh": this.maTinhThanh,
                    "maQuanHuyen": this.maQuanHuyen,
                    "maPhuongXa": this.maPhuongXa
                };
                console.log("lấy ds quận huyện:" + params);
                let loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmToThon/filter", params, (data) => {
                    loading.close();
                    this.ds_to_thon = data.data.rows;
                });
            },
            // Lấy phường xã
            getPhuongXa() {
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maTinhThanh": this.maTinhThanh,
                    "maQuanHuyen": this.maQuanHuyen
                };
                let loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmPhuongXa/filter", params, (data) => {
                    loading.close();
                    this.ds_phuong_xa = data.data.rows;
                });
            },
            //   lấy danh sách quận huyện

            getQuanHuyen() {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maTinhThanh": this.maTinhThanh
                };
                let loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (data) => {
                    loading.close();
                    this.ds_quan_huyen = data.data.rows;
                });
            },
            //   Lấy danh sách tỉnh
            getTinhThanh() {
                let params = {
                    "start": 0,
                    "limit": 100
                };
                let loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    loading.close();
                    this.ds_tinh_thanh = data.data.rows;
                });
            },
            onChonCapHoc() {
                console.log("cấp học chọn:" + JSON.stringify(this.danhSachCapHoc));
                this.capHoc = "";
                this.capHocs = [];
                if (this.danhSachCapHoc) {
                    for (let i = 0; i < this.danhSachCapHoc.length; i++) {
                        this.capHoc += this.danhSachCapHoc[i].id;
                        this.capHocs.push(this.danhSachCapHoc[i].id);
                    }
                }
            },

            close() {
                this.reset();
                this.$emit('close');
            },
            reset() {},
            // định nghĩa cho đơn vị
            setNameDonVi({
                tenDonVi,
                maDonVi
            }) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // định nghĩa cho đơn vị
            setNameTinhThanh({
                tenTinhThanh,
                maTinhThanh
            }) {
                return `${tenTinhThanh} - [${maTinhThanh}]`
            },
            // định nghĩa cho đơn vị
            setNameQuanHuyen({
                tenQuanHuyen,
                maQuanHuyen
            }) {
                return `${tenQuanHuyen} - [${maQuanHuyen}]`
            },
            // định nghĩa cho đơn vị
            setNamePhuongXa({
                tenPhuongXa,
                maPhuongXa
            }) {
                return `${tenPhuongXa} - [${maPhuongXa}]`
            },
            // định nghĩa cho đơn vị
            setNameToThon({
                tenToThon,
                maToThon
            }) {
                return `${tenToThon} - [${maToThon}]`
            },
            // định nghĩa cho cấp học
            setNameCapHoc({
                name
            }) {
                return `${name}`
            }
        }

    }

</script>
<style scoped="scoped">

    .form-check-inline {
        display: inline-flex;
        align-items: center;
        padding-left: 0;
        margin-right: 0.75rem;
    }

    .form-check-inline label {
        margin-bottom: 0;
        margin-left: 5px;
        position: relative;
        top: 2px;
    }

    .col-sm-3 {
        padding-top: 25px;
    }

    .formthem>.col-sm-3:nth-child(n) {}

    .democheck {
        width: 33.33%;
        float: left;
    }

    .inputhemtruong {
        height: 75px;
    }

    .text-danger {
        color: #DC0101;
    }

    .multiselect {
        min-height: 30px !important;
    }

</style>

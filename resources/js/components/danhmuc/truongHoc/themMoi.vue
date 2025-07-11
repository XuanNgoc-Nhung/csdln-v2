<template>
    <div v-loading="loadingFullScreen" element-loading-text="Loading..." element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog title="Thêm mới thông tin trường học" :visible.sync="show_dialog" width="90%" top="5vh"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
            <div>
                <el-form :model='formEdit' :rules="rules" ref="ruleForm">
                    <el-row :gutter="20">
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Tỉnh thành <sup class="red">*</sup></label>
                            <el-form-item prop="maTthanh">
                                <eselect :disabled="thongtin.role>1" ref="maTthanh" collapseTags
                                    v-model="formEdit.maTthanh" @change="chonTinhThanh" :placeholder="'Chọn'" filterable
                                    :data="list_tinh_thanh" :fields="['tenTinhThanh','maTinhThanh']" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Quận huyện <sup class="red">*</sup></label>
                            <el-form-item prop="maQhuyen">
                                <eselect collapseTags ref="maQhuyen" v-model="formEdit.maQhuyen" @change="chonQuanHuyen"
                                    :placeholder="'Chọn'" filterable :data="list_quan_huyen"
                                    :fields="['tenQuanHuyen','maQuanHuyen']" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Phường xã <sup class="red">*</sup></label>
                            <el-form-item prop="maPxa">
                                <eselect collapseTags ref="maPxa" v-model="formEdit.maPxa" @change="chonPhuongXa"
                                    :placeholder="'Chọn'" filterable :data="list_phuong_xa"
                                    :fields="['tenPhuongXa','maPhuongXa']" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Tổ thôn</label>
                            <el-select v-model="formEdit.maTthon" filterable allow-create default-first-option
                                @change="check_confirm_come_back = true" :no-match-text="'Không có dữ liệu'"
                                :no-data-text="'Không có gợi ý'" placeholder="Chọn">
                                <el-option v-for="item in list_to_thon" :key="item.maToThon" :label="item.tenToThon"
                                    :value="item.maToThon">
                                </el-option>
                            </el-select>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Đơn vị quản lý <sup class="red">*</sup></label>
                            <el-form-item prop="maDonVi">
                                <eselect collapseTags v-model="formEdit.maDonVi" ref="maDonVi" :placeholder="'Chọn'"
                                    @change="check_confirm_come_back = true" filterable :data="list_don_vi_so"
                                    :fields="['tenDonVi','maDonVi']" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Mã trường học <sup class="red">*</sup></label>
                            <el-form-item prop="maTruongHoc">
                                <el-input clearable placeholder="Nhập..." ref="maTruongHoc"
                                    @change="check_confirm_come_back = true;formEdit.maTruongHoc = formEdit.maTruongHoc.trim()" v-model="formEdit.maTruongHoc"
                                    :disabled="false">
                                </el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Tên trường học <sup class="red">*</sup></label>
                            <el-form-item prop="tenTruongHoc">
                                <el-input clearable placeholder="Nhập..." ref="tenTruongHoc"
                                    @change="check_confirm_come_back = true;formEdit.tenTruongHoc = formEdit.tenTruongHoc.trim()" v-model="formEdit.tenTruongHoc">
                                </el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Cấp học <sup class="red">*</sup></label>
                            <el-form-item prop="capHocs">
                                <eselect collapseTags multiple ref="capHocs" v-model="formEdit.capHocs"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_cap_hoc" :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label> Nhóm cấp học</label>
                            <eselect collapseTags v-model="formEdit.maNhomCapHoc" :placeholder="'Chọn'" filterable
                                @change="check_confirm_come_back = true" :data="list_ma_nhom_cap_hoc"
                                :fields="['name','value']" />
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Loại hình đào tạo <sup class="red">*</sup></label>
                            <el-form-item prop="loaiHinhDaoTao">
                                <eselect collapseTags ref="loaiHinhDaoTao" v-model="formEdit.loaiHinhDaoTao"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_loai_hinh_dao_tao" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>

                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Loại hình trường <sup class="red">*</sup></label>
                            <el-form-item prop="loaiHinhTruong">
                                <eselect collapseTags ref="loaiHinhTruong" v-model="formEdit.loaiHinhTruong"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_loai_hinh_truong" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>

                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Ngày thành lập</label>
                            <date-picker v-model="formEdit.ngayThanhLap" placeholder="Ngày thành lập" :lang="lang"
                                :disabledDate="disableInvalidDates" @change="check_confirm_come_back = true"
                                valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                            </date-picker>
                        </el-col>

                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Chuẩn quốc gia <sup class="red">*</sup></label>
                            <el-form-item prop="chuanQuocGia">
                                <eselect collapseTags ref="chuanQuocGia" v-model="formEdit.chuanQuocGia"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_chuan_quoc_gia" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>

                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Website</label>
                            <el-input @change="check_confirm_come_back = true;formEdit.website=formEdit.website.trim()" clearable placeholder="Nhập..."
                                v-model="formEdit.website">
                            </el-input>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Tên hiệu trưởng</label>
                            <el-input @change="check_confirm_come_back = true;formEdit.tenHieuTruong = formEdit.tenHieuTruong.trim()" clearable placeholder="Nhập..."
                                v-model="formEdit.tenHieuTruong">
                            </el-input>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Email</label>
                            <el-form-item prop="email">
                                <el-input @change="check_confirm_come_back = true;formEdit.email=formEdit.email.trim()" ref="email" clearable
                                    placeholder="Nhập..." v-model="formEdit.email">
                                </el-input>
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Fax</label>
                            <el-input @change="check_confirm_come_back = true;formEdit.fax=formEdit.fax.trim()" clearable placeholder="Nhập..."
                                v-model="formEdit.fax">
                            </el-input>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Địa chỉ</label>
                            <el-input @change="check_confirm_come_back = true;formEdit.diaChi=formEdit.diaChi.trim()" clearable placeholder="Nhập..."
                                v-model="formEdit.diaChi">
                            </el-input>
                        </el-col>
                        <el-col :xs="24" :sm="12" :md="8">
                            <label>Trạng thái</label>
                            <eselect @change="check_confirm_come_back = true" collapseTags v-model="formEdit.trangThai"
                                :placeholder="'Chọn'" filterable :data="list_trang_thai" :fields="['name','value']" />
                        </el-col>
                    </el-row>
                </el-form>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button type="primary" @click.prevent="submitForm('ruleForm')" size="mini">Lưu</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
    import ESelectVue from '../../ui/ESelect.vue';
    import rest_api from "../../../utils/rest_api";
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/vi';

    export default {
        name: "chinhSua",
        props: ['show', 'item'],
        components: {
            'eselect': ESelectVue,
            DatePicker
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                show_dialog: false,
                loadingFullScreen: false,
                check_confirm_come_back: false,
                formEdit: {
                    capHoc: '',
                    capHocs: [],
                    chiBoDang: null,
                    chuanQuocGia: null,
                    diaChi: "",
                    email: "",
                    fax: "",
                    idPhong: "",
                    idSo: "",
                    loaiHinhDaoTao: '',
                    loaiHinhTruong: '',
                    ma: "",
                    maDoiTac: "",
                    maDonVi: "",
                    maNhomCapHoc: "",
                    maPxa: "",
                    maQhuyen: "",
                    maQuanHuyen: "",
                    maTinhThanh: "",
                    maTruongHoc: "",
                    maTthanh: "",
                    maTthon: "",
                    ngayCapNhat: "",
                    ngayThanhLap: "",
                    sdt: "",
                    sdtHieuTruong: "",
                    ten: "",
                    tenDonVi: "",
                    tenHieuTruong: "",
                    tenPhuongXa: "",
                    tenQuanHuyen: "",
                    tenTinhThanh: "",
                    tenToThon: "",
                    tenTruongHoc: "",
                    trangThai: 1,
                    vungBienGioi: '',
                    vungKhoKhan: '',
                    website: ""
                },

                rules: {

                    sdt: [{
                        pattern: /^0\d+$/,
                        message: 'Số điện thoại không đúng',
                        trigger: ['blur', 'change']
                    }],

                    sdtHieuTruong: [{
                        pattern: /^0\d+$/,
                        message: 'Số điện thoại không đúng',
                        trigger: ['blur', 'change']
                    }],
                    email: [{
                        type: 'email',
                        message: 'Vui lòng nhập đúng định dạng email',
                        trigger: ['blur', 'change']
                    }],
                    maTthanh: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    maQhuyen: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    maPxa: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    maDonVi: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    maTruongHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    tenTruongHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    capHocs: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    loaiHinhDaoTao: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    loaiHinhTruong: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    chuanQuocGia: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                },
                list_tinh_thanh: [],
                list_quan_huyen: [],
                list_phuong_xa: [],
                list_to_thon: [],
                list_don_vi_so: [],
                list_loai_hinh_dao_tao: [{
                        name: "Công lập - [1]",
                        value: 1
                    },
                    {
                        name: "Tư thục - [2]",
                        value: 2
                    },
                    {
                        name: "GDTX - [3]",
                        value: 3
                    },
                    {
                        name: "Ngoài công lập - [4]",
                        value: 4
                    }, {
                        name: "Dân lập - [5]",
                        value: 5
                    },
                ],
                list_cap_hoc: window.listCapHoc,
                list_ma_nhom_cap_hoc: [{
                        name: 'Mầm non',
                        value: '01'
                    },
                    {
                        name: 'Mẫu giáo',
                        value: '02'
                    },
                    {
                        name: 'Nhà trẻ',
                        value: '03'
                    },
                    {
                        name: 'Nhóm nhà trẻ độc lập',
                        value: '04'
                    },
                    {
                        name: 'Lớp mẫu giáo độc lập',
                        value: '05'
                    },
                    {
                        name: 'Tiểu học',
                        value: '06'
                    },
                    {
                        name: 'THCS',
                        value: '07'
                    },
                    {
                        name: 'THPT',
                        value: '08'
                    },
                    {
                        name: 'PTCS',
                        value: '09'
                    },
                    {
                        name: 'Trung học',
                        value: '10'
                    },
                    {
                        name: 'Phổ thông',
                        value: '11'
                    },
                    {
                        name: 'GDTX Tỉnh',
                        value: '12'
                    },
                    {
                        name: 'GDTX Huyện',
                        value: '13'
                    },
                    {
                        name: 'TTKTTHHN',
                        value: '14'
                    },
                    {
                        name: 'Lớp nhô',
                        value: '15'
                    },
                    {
                        name: 'MN-TH',
                        value: '16'
                    },
                    {
                        name: 'MN-PT',
                        value: '17'
                    },
                    {
                        name: 'MN-PTCS',
                        value: '18'
                    },
                    {
                        name: 'Nhóm trẻ, lớp mẫu giáo độc lập',
                        value: '19'
                    },
                ],
                list_loai_hinh_truong: [],
                list_chuan_quoc_gia: [],
                list_trang_thai: [{
                        name: 'Ngưng hoạt động',
                        value: 0
                    },
                    {
                        name: 'Đang hoạt động',
                        value: 1
                    },
                    {
                        name: 'Đã xoá',
                        value: -1
                    },
                ],
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false,
                },
            }
        },
        watch: {
            show: function (newVal) {
                console.log("Show thay đổi:" + newVal)
                if (newVal) {
                    this.bindDataUpdate();
                    this.show_dialog = true;

                    this.formEdit.maTthanh = this.thongtin.ma_so;
                    this.formEdit.maTinhThanh = this.thongtin.ma_so;
                    this.formEdit.idSo = this.thongtin.ma_so;
                } else {
                    this.show_dialog = false;
                }
            }
        },
        mounted() {
            console.log("Mounted...")
            this.ganDuLieuSME();
        },
        methods: {
            disableInvalidDates(date) {
                const today = new Date();
                const selected = new Date(date);
                return selected > today; // Vô hiệu hóa các ngày sau ngày hôm nay
            },

            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.xacNhanChinhSua();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            setCapHocFromArr(arr) {
                var unique_arr = [];
                if (arr) {
                    let duLieu = arr.join('');
                    let mang = duLieu.split('');
                    console.log("setCapHocFromArr");
                    unique_arr = [...new Set(mang)];
                    unique_arr.sort(function (a, b) {
                        return a - b;
                    });
                    console.log(unique_arr)
                }
                return unique_arr.join('')
            },
            convertArrayIntToArrayString(arr) {
                let result = [];
                if (arr) {
                    result = arr;
                    for (let i = 0; i < result.length; i++) {
                        result[i] = result[i].toString();
                    }
                }
                return result;
            },
            convertArrayStringToArrayInt(arr) {
                if (arr && arr.length > 0) {
                    for (let i = 0; i < arr.length; i++) {
                        arr[i] = parseInt(arr[i]);
                    }
                    return arr;
                }
            },
            xacNhanChinhSua() {
                this.formEdit.ma = this.formEdit.maTruongHoc;
                this.formEdit.ten = this.formEdit.tenTruongHoc;
                this.formEdit.maQuanHuyen = this.formEdit.maQhuyen;
                this.formEdit.maTinhThanh = this.formEdit.maTthanh;
                console.log("Dữ liệu chỉnh sửa:")
                if (this.formEdit.capHocs) {
                    let capHoc = this.setCapHocFromArr(this.formEdit.capHocs);
                    console.log("Cấp học chỉnh sửa:")
                    console.log(capHoc);
                    this.formEdit.capHoc = parseInt(capHoc);
                    this.formEdit.capHocs = this.convertArrayIntToArrayString(this.formEdit.capHocs);
                }

                console.log(this.formEdit);
                if (!this.formEdit || !this.formEdit.ten || !this.formEdit.capHoc || !this.formEdit.maDonVi || !this
                    .formEdit.capHocs || !this.formEdit.loaiHinhDaoTao || !this.formEdit.maTruongHoc || !this.formEdit
                    .maQuanHuyen || !this.formEdit.maTinhThanh || this.formEdit.chuanQuocGia === '' || this.formEdit
                    .chuanQuocGia == null || !this.formEdit.loaiHinhTruong || !this.formEdit.maDonVi) {
                    this.thongBao('error', 'Vui lòng kiểm tra & bổ sung thông tin bắt buộc')
                    return;
                }
                this.formEdit.idSo = this.formEdit.maTthanh;
                let params = JSON.parse(JSON.stringify(this.formEdit))
                if (params.ngayThanhLap) {
                    let darr = params.ngayThanhLap
                        .split("/")
                    var dobj = new Date(
                        parseInt(darr[2]),
                        parseInt(darr[1]) - 1,
                        parseInt(darr[0])
                    );
                    dobj = dobj.toISOString();
                    params.ngayThanhLap = dobj;
                }
                this.$confirm('Xác nhận thêm mới thông tin?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.loadingFullScreen = true;
                        rest_api.post("/internal-api/dmTruongHoc/create", params, (response) => {
                            console.log("Chỉnh sửa trả về:")
                            console.log(response)
                            if (response.data.code == 200) {
                                this.thongBao('success', 'Thêm mới trường học thành công');
                                this.$emit('thanhcong')
                            } else {
                                this.thongBao('error', response.data.message)
                            }
                            this.loadingFullScreen = false;
                        });
                    })
                    .catch(_ => {});
            },
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_loai_hinh_dao_tao_sme"];
                if (tmp) {
                    this.list_loai_hinh_truong = this.mapToArrayInt(JSON.parse(localStorage[
                        "danh_sach_loai_hinh_truong_sme"]));
                    this.list_chuan_quoc_gia = this.mapToArrayInt(JSON.parse(localStorage[
                        "danh_sach_chuan_quoc_gia_sme"]));
                }
            },
            mapToArrayInt(data) {
                console.log("data")
                console.log(data)
                let du_lieu = [];
                for (let i = 0; i < data.length; i++) {
                    if (data[i].value) {
                        let obj = {
                            label: data[i].label,
                            name: data[i].name,
                            value: parseInt(data[i].value)
                        }
                        du_lieu.push(obj);
                    }
                }
                return du_lieu;
            },
            getDonViQuanLy() {
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maTinhThanh": this.formEdit.maTthanh,
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (response) => {
                    if (response.data.code == 200) {
                        let ldv = []
                        let dulieu = response.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenDonVi: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                maDonVi: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi_so = ldv;
                    } else {
                        this.thongBao('error', 'Không lấy được danh sách đơn vị.')
                    }
                });
            },
            chonPhuongXa() {
                this.check_confirm_come_back = true;
                this.formEdit.maTthon = '';
                if (this.formEdit.maPxa) {
                    this.getToThon();
                }
            },
            chonQuanHuyen() {
                this.check_confirm_come_back = true;
                this.formEdit.maTthon = '';
                this.formEdit.maPxa = '';
                if (this.formEdit.maQhuyen) {
                    this.getPhuongXa();
                }
            },
            chonTinhThanh() {
                this.check_confirm_come_back = true;
                this.formEdit.maTthon = '';
                this.formEdit.maPxa = '';
                this.formEdit.maQhuyen = '';
                this.formEdit.maDonVi = '';
                if (this.formEdit.maTthanh) {
                    this.getQuanHuyen();
                    this.getDonViQuanLy();
                }
            },
            getToThon() {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maPhuongXa": this.formEdit.maPxa,
                    "maQuanHuyen": this.formEdit.maQhuyen,
                    "maTinhThanh": this.formEdit.maTthanh
                };
                rest_api.get("/internal-api/dmToThon/filter", params, (response) => {
                    if (response.data.code == 200) {
                        this.list_to_thon = response.data.rows;
                    } else {
                        this.thongBao('error', 'Không lấy được danh sách tổ thốn.')
                    }
                });
            },
            getPhuongXa() {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maQuanHuyen": this.formEdit.maQhuyen,
                    "maTinhThanh": this.formEdit.maTthanh
                };
                rest_api.get("/internal-api/dmPhuongXa/filter", params, (response) => {
                    if (response.data.code == 200) {
                        this.list_phuong_xa = response.data.rows;
                    } else {
                        this.thongBao('error', 'Không lấy được danh sách phường xã.')
                    }
                });
            },
            getQuanHuyen() {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maTinhThanh": this.formEdit.maTthanh
                };
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (response) => {
                    if (response.data.code == 200) {
                        this.list_quan_huyen = response.data.rows;
                    } else {
                        this.thongBao('error', 'Không lấy được danh sách quận huyện.')
                    }
                });
            },
            getTinhThanh() {
                let params = {
                    "start": 0,
                    "limit": 100
                };
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (response) => {
                    if (response.data.code == 200) {
                        this.list_tinh_thanh = response.data.rows;
                        console.log("Danh sách tỉnh thành:")
                        console.log(this.list_tinh_thanh);
                    } else {
                        this.thongBao('error', 'Không lấy được danh sách tỉnh thành.')
                    }
                });
            },
            bindDataUpdate() {
                console.log("gán:")
                // console.log(this.item)
                // this.formEdit = JSON.parse(JSON.stringify(this.item));
                // let capHoc = JSON.parse(JSON.stringify(this.item)).capHoc;
                // let array_cap_hoc = capHoc.split('');
                // this.formEdit.capHocs = this.convertArrayStringToArrayInt(array_cap_hoc);
                // this.formEdit.maTthanh
                this.getTinhThanh();
                this.getQuanHuyen();
                this.getPhuongXa();
                this.getToThon();
                this.getDonViQuanLy();
            },

            handleClose() {
                console.log("handleClose");
                if (this.check_confirm_come_back) {
                    this.$confirm(
                            'Các thông tin vừa nhập sẽ bị mất khi đóng trang. Thầy cô có muốn tiếp tục chỉnh sửa, kiểm tra và lưu lại thông tin đã nhập?',
                            'Thông báo', {
                                confirmButtonText: 'Rời khỏi trang',
                                cancelButtonText: 'Tiếp tục chỉnh sửa',
                                confirmButtonClass: 'el-button--danger',
                                closeOnClickModal: false,
                            })
                        .then(_ => {
                            this.close();
                        })
                        .catch(_ => {});
                } else {
                    this.close();
                }
            },
            close() {
                this.resetForm('ruleForm')
                this.$emit('close');
            },
            resetForm(formName) {
                this.formEdit = {
                    capHoc: '',
                    capHocs: [],
                    chiBoDang: null,
                    chuanQuocGia: null,
                    diaChi: "",
                    email: "",
                    fax: "",
                    idPhong: "",
                    idSo: "",
                    loaiHinhDaoTao: '',
                    loaiHinhTruong: '',
                    ma: "",
                    maDoiTac: "",
                    maDonVi: "",
                    maNhomCapHoc: "",
                    maPxa: "",
                    maQhuyen: "",
                    maQuanHuyen: "",
                    maTinhThanh: "",
                    maTruongHoc: "",
                    maTthanh: "",
                    maTthon: "",
                    ngayCapNhat: "",
                    ngayThanhLap: "",
                    sdt: "",
                    sdtHieuTruong: "",
                    ten: "",
                    tenDonVi: "",
                    tenHieuTruong: "",
                    tenPhuongXa: "",
                    tenQuanHuyen: "",
                    tenTinhThanh: "",
                    tenToThon: "",
                    tenTruongHoc: "",
                    trangThai: 1,
                    vungBienGioi: '',
                    vungKhoKhan: '',
                    website: ""
                };
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
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
        },
    }

</script>

<style scoped>
    .red {
        font-weight: 700;
        font-size: 12px;
    }

</style>

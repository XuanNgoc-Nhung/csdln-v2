<template>
    <div v-loading="loadingFullScreen" element-loading-text="Loading..." element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog title="Thêm mới thông tin cán bộ phòng sở" :visible.sync="show" width="90%"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">

            <el-form :model='formEdit' :rules="rules" ref="ruleForm">
                <div style="padding-top: 10px">
                    <div class="form-group row">

                        <div class="col-md-2">
                            <label class="typo__label">Loại cán bộ<span style="color:#DC0101">*</span></label>
                            <el-form-item prop="loaiCanBo">
                                <eselect collapseTags ref="loaiCanBo" v-model="formEdit.loaiCanBo"
                                    @change="check_confirm_come_back = true;formEdit.loaiCanBo==1?rules.idPhong[0].required=false:rules.idPhong[0].required=true;$refs.ruleForm.validateField('idPhong')"
                                    :placeholder="'Chọn'" filterable :data="list_loai_can_bo"
                                    :fields="['name','value']" />
                            </el-form-item>
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Sở<span style="color:#DC0101">*</span></label>
                            <!-- <el-select v-model="idSo" disabled filterable collapse-tags placeholder="Chọn đơn vị"
                                no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in list_don_vi" :key="item.value" :label="item.name"
                                    :value="item.value">
                                </el-option>
                            </el-select> -->
                            <el-form-item prop="idSo">
                                <eselect collapseTags disabled ref="idSo" v-model="formEdit.idSo"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_don_vi" :fields="['name','value']" />
                            </el-form-item>
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Phòng <span v-if='formEdit.loaiCanBo==2'
                                    style="color:#DC0101">*</span></label>
                            <el-form-item prop="idPhong">
                                <eselect collapseTags ref="idPhong" v-model="formEdit.idPhong"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_don_vi_phong" :fields="['name','value']" />
                            </el-form-item>
                        </div>
                        <div class="col-md-2">
                            <label class="typo__label">Chức vụ phòng<span style="color:#DC0101">*</span></label>
                            <!-- <el-select v-model="chucVuPhong" filterable collapse-tags placeholder="Chọn đơn vị"
                                no-data-text="Không có dữ liệu" v-validate="{ required: true,}" name="chucVuPhong"
                                no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in list_chuc_vu_phong" :key="item.value" :label="item.name"
                                    :value="item.value">
                                </el-option>
                            </el-select> -->
                            <el-form-item prop="chucVuPhong">
                                <eselect collapseTags ref="chucVuPhong" v-model="formEdit.chucVuPhong"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_chuc_vu_phong" :fields="['name','value']" />
                            </el-form-item>
                        </div>
                        <div class="col-md-2">
                            <label class="typo__label">Phòng ban<span style="color:#DC0101">*</span></label>
                            <el-form-item prop="maPhongBan">
                                <eselect collapseTags ref="maPhongBan" v-model="formEdit.maPhongBan"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_ma_phong_ban" :fields="['name','value']" />
                            </el-form-item>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 pxn-cot">
                            <label>Mã cán bộ<span style="color:#DC0101;">*</span></label>
                            <!-- <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="maCanBo"
                                type="text" v-model="maCanBo" placeholder="Nhập..." class="form-control"> -->

                            <el-form-item prop="maCanBo">
                                <el-input clearable placeholder="Nhập..." ref="maCanBo"
                                    @change="check_confirm_come_back = true;formEdit.maCanBo = formEdit.maCanBo.trim()"
                                    v-model="formEdit.maCanBo">
                                </el-input>
                            </el-form-item>
                        </div>
                        <div class="col-sm-2 pxn-cot">
                            <label>Tên cán bộ<span style="color:#DC0101;">*</span></label>
                            <!-- <input type="text" placeholder="Nhập..." v-model="tenCanBo" class="form-control"> -->

                            <el-form-item prop="tenCanBo">
                                <el-input clearable placeholder="Nhập..." ref="tenCanBo"
                                    @change="check_confirm_come_back = true;formEdit.tenCanBo = formEdit.tenCanBo.trim()"
                                    v-model="formEdit.tenCanBo">
                                </el-input>
                            </el-form-item>
                        </div>
                        <div class="col-sm-2 pxn-cot">
                            <label>Giới tính<span style="color:#DC0101;">*</span></label>
                            <!-- <select v-model="gioiTinh" class="form-control" id="">
                                <option value="">Chọn</option>
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select> -->
                            <el-form-item prop="gioiTinh">
                                <eselect collapseTags ref="gioiTinh" v-model="formEdit.gioiTinh"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_gioi_tinh" :fields="['name','value']" />
                            </el-form-item>
                        </div>
                        <div class="col-sm-2 pxn-cot">
                            <label>Ngày sinh<span style="color:#DC0101;">*</span></label>
                            <!-- <date-picker :config="configDatePicker" v-model="ngaySinh" placeholder="Chọn ngày sinh">
                            </date-picker> -->
                            <el-form-item prop="ngaySinh">
                                <date-picker v-model="formEdit.ngaySinh" ref="ngaySinh" placeholder="Chọn ngày"
                                    :disabledDate="disableInvalidDates" :lang="lang"
                                    @change="check_confirm_come_back = true" valueType="format" value-type="DD/MM/YYYY"
                                    format="DD/MM/YYYY">
                                </date-picker>
                            </el-form-item>
                        </div>
                        <div class="col-sm-2 pxn-cot">
                            <label>Số điện thoại</label>
                            <!-- <input type="text" placeholder="Nhập..." v-model="dienThoai" class="form-control"> -->
                            <el-form-item prop="dienThoai">
                                <el-input clearable placeholder="Nhập..." ref="dienThoai"
                                    @change="check_confirm_come_back = true;formEdit.dienThoai = formEdit.dienThoai.trim()"
                                    v-model="formEdit.dienThoai">
                                </el-input>
                            </el-form-item>
                        </div>
                        <div class="col-sm-2 pxn-cot">
                            <label>Email</label>
                            <!-- <input type="text" placeholder="Nhập..." v-model="email" class="form-control"> -->
                            <el-form-item prop="email">
                                <el-input clearable placeholder="Nhập..." ref="email"
                                    @change="check_confirm_come_back = true;formEdit.email = formEdit.email.trim()"
                                    v-model="formEdit.email">
                                </el-input>
                            </el-form-item>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 pxn-cot">
                            <label>Địa chỉ</label>
                            <!-- <input type="text" placeholder="Nhập..." v-model="diaChi" class="form-control"> -->
                            <el-form-item prop="diaChi">
                                <el-input clearable placeholder="Nhập..." ref="diaChi"
                                    @change="check_confirm_come_back = true;formEdit.diaChi = formEdit.diaChi.trim()"
                                    v-model="formEdit.diaChi">
                                </el-input>
                            </el-form-item>
                        </div>
                        <div class="col-sm-2 pxn-cot">
                            <label>Dân tộc</label>
                            <!-- <el-select v-model="maDanToc" filterable collapse-tags placeholder="Chọn đơn vị"
                                no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in list_dan_toc" :key="item.value" :label="item.name"
                                    :value="item.value">
                                </el-option>
                            </el-select> -->
                            <eselect collapseTags ref="maDanToc" v-model="formEdit.maDanToc"
                                @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                :data="list_dan_toc" :fields="['name','value']" />
                        </div>
                        <div class="col-sm-2 pxn-cot">
                            <label>Tôn giáo</label>
                            <!-- <el-select v-model="maTonGiao" filterable collapse-tags placeholder="Chọn đơn vị"
                                no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in list_ton_giao" :key="item.value" :label="item.name"
                                    :value="item.value">
                                </el-option>
                            </el-select> -->
                            <eselect collapseTags ref="maTonGiao" v-model="formEdit.maTonGiao"
                                @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                :data="list_ton_giao" :fields="['name','value']" />
                        </div>
                        <div class="col-sm-2 pxn-cot">
                            <label>Số CMT/CCCD<span style="color:#DC0101;">*</span></label>
                            <el-form-item prop="soCmnd">
                                <!-- <input type="text" placeholder="Nhập..." v-model="soCmnd" class="form-control"> -->
                                <el-input clearable placeholder="Nhập..." ref="soCmnd"
                                    @change="check_confirm_come_back = true;formEdit.soCmnd = formEdit.soCmnd.trim()"
                                    v-model.trim="formEdit.soCmnd">
                                </el-input>
                            </el-form-item>
                        </div>
                        <div class="col-sm-2 pxn-cot">
                            <label>Ngày cấp CMT/CCCD<span style="color:#DC0101;">*</span></label>
                            <!-- <date-picker :config="configDatePicker" v-model="ngayCapCmnd" placeholder="Chọn ngày sinh">
                            </date-picker> -->
                            <el-form-item prop="ngayCapCmnd">
                                <date-picker v-model="formEdit.ngayCapCmnd" placeholder="Chọn ngày" :lang="lang"
                                    :disabledDate="disableInvalidDates" @change="check_confirm_come_back = true"
                                    valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                </date-picker>
                            </el-form-item>
                        </div>
                        <div class="col-sm-2 pxn-cot">
                            <label>Trạng thái<span style="color:#DC0101;">*</span></label>
                            <!-- <select v-model="trangThai" class="form-control" id="">
                                <option value="">Chọn</option>
                                <option value="1">Đang hoạt động</option>
                                <option value="0">Ngưng hoạt động</option>
                            </select> -->

                            <el-form-item prop="trangThai">
                                <eselect collapseTags ref="trangThai" v-model="formEdit.trangThai"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_trang_thai" :fields="['name','value']" />
                            </el-form-item>
                        </div>
                    </div>
                </div>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button type="primary" @click.prevent="submitForm('ruleForm')" size="mini">Lưu</el-button>
            </span>
        </el-dialog>
    </div>

</template>

<script>
    import moment from 'moment'
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    import api from '../api';
    import constant from '../../utils/constant';

    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/vi';
    import ESelectVue from '../ui/ESelect.vue';

    export default {
        props: ['show'],
        watch: {
            show: function (newVal) {
                console.log("Show thay đổi:" + newVal)
                if (newVal) {
                    this.formEdit = {
                        idSo: this.thongtin.ma_so,
                        idPhong: '',
                        chucVuPhong: '',
                        maPhongBan: '',
                        diaChi: '',
                        dienThoai: '',
                        email: '',
                        gioiTinh: '',
                        maDanToc: '',
                        maTonGiao: '',
                        ngayCapCmnd: '',
                        ngaySinh: '',
                        soCmnd: '',
                        maCanBo: '',
                        tenCanBo: '',
                        trangThai: 1,
                        loaiCanBo: 1,
                    }
                    this.$refs['ruleForm'].resetFields();
                } else {}
            }
        },

        components: {
            DatePicker,
            'eselect': ESelectVue,
        },
        data() {
            return {
                maCanBo: '',
                ten_tongiao: '',
                show_msg: false,
                thongtin: JSON.parse(window.userInfo),
                list_loai_can_bo: [{
                        name: 'Cán bộ sở',
                        value: 1
                    },
                    {
                        name: 'Cán bộ phòng',
                        value: 2
                    },
                ],
                list_don_vi: [],
                list_don_vi_phong: [],
                list_dan_toc: [],
                list_ton_giao: [],
                list_gioi_tinh: [{
                        name: 'Nam',
                        value: 1
                    },
                    {
                        name: 'Nữ',
                        value: 0
                    },
                ],
                list_trang_thai: [{
                        name: 'Đang hoạt động',
                        value: 1
                    },
                    {
                        name: 'Ngưng hoạt động',
                        value: 0
                    },
                ],
                list_chuc_vu_phong: constant.list_chuc_vu_phong,
                list_ma_phong_ban: constant.list_ma_phong_ban,
                formEdit: {
                    idSo: '',
                    idPhong: '',
                    chucVuPhong: '',
                    maPhongBan: '',
                    diaChi: '',
                    dienThoai: '',
                    email: '',
                    gioiTinh: '',
                    maDanToc: '',
                    maTonGiao: '',
                    ngayCapCmnd: '',
                    ngaySinh: '',
                    soCmnd: '',
                    maCanBo: '',
                    tenCanBo: '',
                    trangThai: 1,
                    loaiCanBo: 1,
                },
                rules: {
                    dienThoai: [{
                        pattern: /^0\d+$/,
                        message: 'Số điện thoại không đúng',
                        trigger: ['blur', 'change']
                    }],
                    email: [{
                        type: 'email',
                        message: 'Vui lòng nhập đúng định dạng email',
                        trigger: ['blur', 'change']
                    }],
                    idPhong: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }],
                    loaiCanBo: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                    chucVuPhong: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                    maPhongBan: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                    maCanBo: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                    tenCanBo: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                    gioiTinh: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                    trangThai: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                    ngaySinh: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur', 'input']
                    }, ],
                    soCmnd: [{
                            pattern: /^\d+$/,
                            message: 'Vui lòng nhập đúng định dạng',
                            trigger: ['blur', 'change']
                        },
                        {
                            pattern: /^\d{9}(?:\d{3})?$/,
                            message: 'Số CMND/CCCD có 9 hoặc 12 số',
                            trigger: ['blur', 'change']
                        },
                        {
                            required: true,
                            message: 'Vui lòng nhập thông tin',
                            trigger: ['change', 'blur']
                        },
                    ],
                    ngayCapCmnd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                },
                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false,
                },
                loadingFullScreen: false,
                check_confirm_come_back: false,
            }
        },
        mounted: function () {
            console.log("mounted thêm mới cán bộ phòng sở !!!!!");
            this.getDonVi();
            this.getDonViPhong();
            this.getDanToc();
            this.getTonGiao();
            this.formEdit.idSo = this.thongtin.ma_so;
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
                        this.themCanBo();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            handleClose() {
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
                            this.close()
                        })
                        .catch(_ => {});

                } else {
                    this.close()
                }
            },
            // Lấy tôn giáo
            getTonGiao() {
                let params = {
                    start: 0,
                    limit: 100,
                };
                rest_api.get("/internal-api/dmTonGiao/filter", params, data => {
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenTonGiao + ' - [' + data.data.rows[i].maTonGiao +
                                    ']',
                                value: data.data.rows[i].maTonGiao
                            }
                            this.list_ton_giao.push(obj);
                        }
                    }
                });
            },
            // Lấy dân tộc
            getDanToc() {
                let params = {
                    start: 0,
                    limit: 100,
                };
                rest_api.get("/internal-api/dmDanToc/filter", params, data => {
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenDanToc + ' - [' + data.data.rows[i].maDanToc +
                                    ']',
                                value: data.data.rows[i].maDanToc
                            }
                            this.list_dan_toc.push(obj);
                        }
                    }
                });
            },
            // Lấy dân tộc:

            // Lấy đơn vị
            getDonVi() {
                this.list_don_vi = [];
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenDonVi + ' - [' + data.data.rows[i].maDonVi + ']',
                                value: data.data.rows[i].maDonVi
                            }
                            this.list_don_vi.push(obj);
                        }
                    }
                });
            },
            // Lấy đơn vị phòng
            getDonViPhong() {
                this.list_don_vi_phong = [];
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so,
                    "loaiDonVi": 2,

                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data.data.rows[i].maDonVi + ']',
                                value: data.data.rows[i].maDonVi
                            }
                            this.list_don_vi_phong.push(obj);
                        }
                    }
                });
            },
            themCanBo() {
                const params = {
                    chucVuPhong: this.formEdit.chucVuPhong,
                    diaChi: this.formEdit.diaChi,
                    dienThoai: this.formEdit.dienThoai,
                    email: this.formEdit.email,
                    loaiCanBo: this.formEdit.loaiCanBo,
                    gioiTinh: this.formEdit.gioiTinh,
                    idPhong: this.formEdit.idPhong,
                    idSo: this.formEdit.idSo,
                    maCanBo: this.formEdit.maCanBo,
                    maDanToc: this.formEdit.maDanToc,
                    maPhongBan: this.formEdit.maPhongBan,
                    maTonGiao: this.formEdit.maTonGiao,
                    ngayCapCmnd: this.formEdit.ngayCapCmnd,
                    ngaySinh: this.formEdit.ngaySinh,
                    soCmnd: this.formEdit.soCmnd,
                    tenCanBo: this.formEdit.tenCanBo,
                    trangThai: this.formEdit.trangThai,
                };
                console.log("pr thêm cán bộ:" + JSON.stringify(params));
                this.loadingFullScreen = true;
                rest_api.post("/csdlgd-admin/canBoPhongSoQl/create", params, (response) => {
                    console.log("thêm cán bộ phòng sở trả về:" + JSON.stringify(response));
                    this.loadingFullScreen = false
                    if (response.data.rc === 0) {
                        this.thongBao('success', response.data.rd)
                        this.$emit('success');
                    } else {
                        this.thongBao('error', response.data.rd)
                    }
                });
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

            reset() {
                this.formEdit.maCanBo = "";
                this.ma_cuabo = "";
                this.ten_tongiao = "";
            },
            resetForm(formName) {
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
            },
            close() {
                this.$refs['ruleForm'].resetFields();
                this.resetForm('ruleForm')
                console.log("close modal");
                this.show_msg = false;
                this.reset();
                this.$emit('close');
            },

        }

    }

</script>
<style scoped="scoped">
    .pxn-cot {
        padding-bottom: 15px
    }

</style>

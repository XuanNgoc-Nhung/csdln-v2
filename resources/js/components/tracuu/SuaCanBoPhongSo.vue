<template>
    <div v-loading="loadingFullScreen" element-loading-text="Loading..." element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog title="Chỉnh sửa thông tin cán bộ phòng sở" :visible.sync="show" width="90%"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
            <el-form :model='dataForm' :rules="rules" ref="ruleForm">
                <div class="row" style="padding-bottom:20px">
                    <div class="col-md-2">
                        <el-form-item prop="loaiCanBo">
                        <label class="typo__label">Loại cán bộ <span style="color:#DC0101">*</span></label>
                            <eselect collapseTags ref="loaiCanBo" v-model="dataForm.loaiCanBo"
                                @change="check_confirm_come_back = true;dataForm.loaiCanBo==1?rules.idPhong[0].required=false:rules.idPhong[0].required=true;$refs.ruleForm.validateField('idPhong')" :placeholder="'Chọn'" filterable
                                :data="list_loai_can_bo" :fields="['name','value']" />
                        </el-form-item>
                    </div>
                    <div class="col-md-3">
                        <el-form-item prop="idSo">
                            <label class="typo__label">Sở <span style="color:#DC0101">*</span></label>
                            <eselect style="width:100%" ref="idSo" collapseTags v-model="dataForm.idSo"
                                @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                :data="list_don_vi" :fields="['name','value']" />
                        </el-form-item>
                    </div>
                    <div class="col-md-3">
                        <el-form-item prop="idPhong">
                            <label class="typo__label">Phòng  <span v-if='dataForm.loaiCanBo==2' style="color:#DC0101">*</span></label>
                            <eselect style="width:100%" ref="idPhong" collapseTags v-model="dataForm.idPhong"
                                @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                :data="list_don_vi_phong" :fields="['name','value']" />
                        </el-form-item>
                    </div>
                    <div class="col-md-2">

                        <el-form-item prop="chucVuPhong">
                            <label class="typo__label">Chức vụ phòng <span style="color:#DC0101">*</span></label>
                            <eselect style="width:100%" ref="chucVuPhong" collapseTags v-model="dataForm.chucVuPhong"
                                @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                :data="list_chuc_vu_phong" :fields="['name','value']" />
                        </el-form-item>
                    </div>
                    <div class="col-md-2">

                        <el-form-item prop="maPhongBan">
                            <label class="typo__label">Phòng ban <span style="color:#DC0101">*</span></label>
                            <eselect style="width:100%" ref="maPhongBan" collapseTags v-model="dataForm.maPhongBan"
                                @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                :data="list_ma_phong_ban" :fields="['name','value']" />
                        </el-form-item>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 pxn-cot">
                        <label>Mã cán bộ <span style="color:#DC0101;">*</span></label>
                        <el-input clearable disabled name="maCanBo" ref="maCanBo" type="text" v-model="dataForm.maCanBo"
                            @change="check_confirm_come_back = true;dataForm.maCanBo = dataForm.maCanBo.trim()"
                            placeholder="Nhập..." />
                    </div>
                    <div class="col-sm-2 pxn-cot">
                        <label>Tên cán bộ<span style="color:#DC0101">*</span> </label>
                        <el-form-item prop="tenCanBo">
                            <el-input clearable type="text" ref="tenCanBo" placeholder="Nhập..."
                                @change="check_confirm_come_back = true;dataForm.tenCanBo = dataForm.tenCanBo.trim()"
                                v-model="dataForm.tenCanBo" />
                        </el-form-item>
                    </div>
                    <div class="col-sm-2 pxn-cot">
                        <label>Giới tính <span style="color:#DC0101">*</span></label>

                        <el-form-item prop="gioiTinh">
                            <eselect style="width:100%" ref="gioiTinh" collapseTags v-model="dataForm.gioiTinh"
                                @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                :data="list_gioi_tinh" :fields="['name','value']" />
                        </el-form-item>
                    </div>
                    <div class="col-sm-2 pxn-cot">
                        <label>Ngày sinh <span style="color:#DC0101">*</span></label>
                        <el-form-item prop="ngaySinh">
                            <date-picker v-model="dataForm.ngaySinh" ref="ngaySinh" placeholder="Chọn..." :lang="lang"
                                :disabledDate="disableInvalidDates" @change="check_confirm_come_back = true"
                                valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                            </date-picker>
                        </el-form-item>
                    </div>
                    <div class="col-sm-2 pxn-cot">
                        <label>Số điện thoại</label>
                        <el-form-item prop="dienThoai">
                            <el-input clearable type="text" placeholder="Nhập..." ref="dienThoai"
                                v-model="dataForm.dienThoai"
                                @change="check_confirm_come_back = true;dataForm.dienThoai = dataForm.dienThoai.trim()" />
                        </el-form-item>
                    </div>
                    <div class="col-sm-2 pxn-cot">
                        <label>Email</label>
                        <el-form-item prop="email">
                            <el-input clearable type="text" ref="email" placeholder="Nhập..." v-model="dataForm.email"
                                @change="check_confirm_come_back = true;dataForm.email = dataForm.email.trim()" />
                        </el-form-item>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 pxn-cot">
                        <label>Địa chỉ</label>
                        <el-input clearable type="text" placeholder="Nhập..." v-model="dataForm.diaChi"
                            @change="check_confirm_come_back = true;dataForm.diaChi = dataForm.diaChi.trim()" />
                    </div>
                    <div class="col-sm-2 pxn-cot">
                        <label>Dân tộc</label>

                        <el-form-item prop="maDanToc">
                            <el-select clearable v-model="dataForm.maDanToc" ref="maDanToc" filterable collapse-tags
                                placeholder="Chọn đơn vị" no-data-text="Không có dữ liệu"
                                @change="check_confirm_come_back = true" no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in list_dan_toc" :key="item.value" :label="item.name"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </el-form-item>
                    </div>
                    <div class="col-sm-2 pxn-cot">
                        <label>Tôn giáo</label>
                        <el-select clearable v-model="dataForm.maTonGiao" filterable collapse-tags
                            placeholder="Chọn đơn vị" no-data-text="Không có dữ liệu"
                            @change="check_confirm_come_back = true" no-match-text="Không có dữ liệu phù hợp">
                            <el-option v-for="item in list_ton_giao" :key="item.value" :label="item.name"
                                :value="item.value">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-sm-2 pxn-cot">
                        <label>Số CMT/CCCD <span style="color:#DC0101">*</span></label>
                        <el-form-item prop="soCmnd">
                            <el-input clearable type="text" ref="soCmnd" placeholder="Nhập..."
                                @change="check_confirm_come_back = true;dataForm.diaChi = dataForm.diaChi.trim()"
                                v-model="dataForm.soCmnd" />
                        </el-form-item>
                    </div>
                    <div class="col-sm-2 pxn-cot">
                        <label>Ngày cấp CMT/CCCD <span style="color:#DC0101">*</span></label>

                        <el-form-item prop="ngayCapCmnd">
                            <date-picker v-model="dataForm.ngayCapCmnd" ref="ngayCapCmnd" placeholder="Chọn" :lang="lang"
                                :disabledDate="disableInvalidDates" @change="check_confirm_come_back = true"
                                valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                            </date-picker>
                        </el-form-item>
                    </div>
                    <div class="col-sm-2 pxn-cot">
                        <label>Trạng thái <span style="color:#DC0101">*</span></label>
                        <el-form-item prop="trangThai">
                            <eselect style="width:100%" ref="trangThai" collapseTags v-model="dataForm.trangThai"
                                @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                :data="list_trang_thai" :fields="['name','value']" />
                        </el-form-item>
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
    import datePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/vi';
    import moment from 'moment'
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    import api from '../api';
    import constant from '../../utils/constant';
    import ESelectVue from '../ui/ESelect.vue';
    export default {
        props: ['item', 'show'],
        watch: {
            show: function (newVal) {
                console.log("Show thay đổi:" + newVal)
                if (newVal) {
                    this.bindData(this.item);
                } else {
                    this.check_confirm_come_back = false;
                }
            }
        },

        components: {
            datePicker,
            'eselect': ESelectVue,
        },
        data() {
            return {
                loadingFullScreen: false,
                check_confirm_come_back: false,
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false,
                },
                show_msg: false,
                thongtin: JSON.parse(window.userInfo),
                list_don_vi: [],
                list_loai_can_bo:[
                    {name:'Cán bộ sở',value:1},
                    {name:'Cán bộ phòng',value:2},
                ],
                list_don_vi_phong: [],
                list_dan_toc: [],
                list_ton_giao: [],
                dataForm: {
                    maCanBo: '',
                    loaiCanBo: '',
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
                    tenCanBo: '',
                    trangThai: '',
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
                    idSo: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'blur'
                    }, ],
                    idPhong: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'blur'
                    }, ],
                    chucVuPhong: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'blur'
                    }, ],
                    maPhongBan: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'blur'
                    }, ],
                    maCanBo: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    tenCanBo: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    gioiTinh: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    trangThai: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    ngaySinh: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
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
                    }, {
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    ngayCapCmnd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change','blur','input']
                    }, ],
                    loaiCanBo: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                },
                list_chuc_vu_phong: constant.list_chuc_vu_phong,
                list_ma_phong_ban: constant.list_ma_phong_ban,
                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                list_gioi_tinh: [{
                    name: 'Nam',
                    value: 1
                }, {
                    name: 'Nữ',
                    value: 0
                }],
                list_trang_thai: [{
                    name: 'Đang hoạt động',
                    value: 1
                }, {
                    name: 'Ngừng hoạt động',
                    value: 0
                }],
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            this.getDonVi();
            this.getDonViPhong();
            this.getDanToc();
            this.getTonGiao();
            this.dataForm.idSo = this.thongtin.ma_so;
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
            resetForm(formName) {
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
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
                            this.close();
                        })
                        .catch(_ => {});
                } else {
                    this.close()
                }
            },
            bindData(e) {
                let dulieu = e;
                this.dataForm.maCanBo = e.maCanBo;
                this.dataForm.idSo = e.idSo;
                this.dataForm.idPhong = e.idPhong;
                this.dataForm.chucVuPhong = e.chucVuPhong;
                this.dataForm.maPhongBan = e.maPhongBan;
                this.dataForm.loaiCanBo = e.loaiCanBo;
                this.dataForm.diaChi = e.diaChi;
                this.dataForm.dienThoai = e.dienThoai;
                this.dataForm.email = e.email;
                this.dataForm.gioiTinh = e.gioiTinh;
                this.dataForm.maDanToc = e.maDanToc;
                this.dataForm.maTonGiao = e.maTonGiao;
                this.dataForm.ngayCapCmnd = e.ngayCapCmnd;
                this.dataForm.ngaySinh = e.ngaySinh;
                this.dataForm.soCmnd = e.soCmnd;
                this.dataForm.tenCanBo = e.tenCanBo;
                this.dataForm.trangThai = e.trangThai;
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
                                name: data.data.rows[i].tenDonVi + ' - [' + data.data.rows[i].maDonVi + ']',
                                value: data.data.rows[i].maDonVi
                            }
                            this.list_don_vi_phong.push(obj);
                        }
                    }
                });
            },
            themTonGiaoSubmit() {
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result) {}
                });
            },
            themCanBo() {
                const params = {
                    chucVuPhong: this.dataForm.chucVuPhong,
                    diaChi: this.dataForm.diaChi,
                    dienThoai: this.dataForm.dienThoai,
                    email: this.dataForm.email,
                    loaiCanBo: this.dataForm.loaiCanBo,
                    gioiTinh: this.dataForm.gioiTinh,
                    idPhong: this.dataForm.idPhong,
                    idSo: this.dataForm.idSo,
                    maCanBo: this.dataForm.maCanBo,
                    maDanToc: this.dataForm.maDanToc,
                    maPhongBan: this.dataForm.maPhongBan,
                    maTonGiao: this.dataForm.maTonGiao,
                    ngayCapCmnd: this.dataForm.ngayCapCmnd,
                    ngaySinh: this.dataForm.ngaySinh,
                    soCmnd: this.dataForm.soCmnd,
                    tenCanBo: this.dataForm.tenCanBo,
                    trangThai: this.dataForm.trangThai,
                };
                console.log("pr thêm cán bộ:" + JSON.stringify(params));
                rest_api.post("/csdlgd-admin/canBoPhongSoQl/update", params, (response) => {
                    console.log("thêm cán bộ phòng sở trả về:" + JSON.stringify(response));
                    if (response.data.rc === 0) {
                        this.thongBao('success', response.data.rd)
                        this.$emit('success');
                    } else {
                        this.thongBao('errror', response.data.rd)
                    }
                });
            },
            close() {
                this.resetForm('ruleForm')
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

<template>
    <div>
       
        <Breadcrumb :menu="'Tra cứu'" :desc="'Thông tin điểm danh'"/>
        <div>
            <div class="card-bieu-do">
                <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                    <el-form :model='dataSearch' :rules="rules" ref="ruleForm">
                        <el-col :span="8">
                            <label class="typo__label">Loại báo cáo<span style="color:#DC0101">*</span> </label>
                            <el-form-item prop="loaiDiemDanh">
                                <eselect style="width:100%" ref="loaiDiemDanh" collapseTags
                                    v-model="dataSearch.loaiDiemDanh" @change="chonLoaiDiemDanh" :placeholder="'Chọn'"
                                    filterable :data="danh_sach_loai_diem_danh" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <label class="typo__label">Đơn vị quản lý <span v-if="dataSearch.loaiDiemDanh!=1"
                                    style="color:#DC0101">*</span> </label>
                            <el-form-item prop="donVi">
                                <eselect style="width:100%" ref="donVi" @change="layLaiTruong"
                                    :disabled="thongtin.role>2" collapseTags v-model="dataSearch.donVi"
                                    :placeholder="'Chọn'" filterable :data="list_don_vi"
                                    :fields="['tenDonVi','maDonVi']" />
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <label class="typo__label">Cấp học <span v-if="thongtin.role!=5" style="color:#DC0101">*</span>
                            </label>
                            <el-form-item prop="capHoc">
                                <eselect style="width:100%" @change="layLaiTruong" ref="capHoc"
                                    :disabled="thongtin.role==5&&!thongtin.listCapHoc" collapseTags
                                    v-model="dataSearch.capHoc" :placeholder="'Chọn'" filterable
                                    :data="danh_sach_cap_hoc_full" :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <label class="typo__label">Trường học</label>
                            <el-form-item prop="truongHoc">
                                <eselect style="width:100%" collapseTags
                                    :disabled="thongtin.role==5||dataSearch.loaiDiemDanh==1" ref="truongHoc" multiple
                                    v-model="dataSearch.truongHoc" :placeholder="'Chọn'" filterable
                                    :data="list_truong_hoc" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <label class="typo__label">Năm học <span style="color:#DC0101">*</span> </label>

                            <el-form-item prop="namHoc">
                                <eselect style="width:100%" ref="namHoc" collapseTags v-model="dataSearch.namHoc"
                                    :placeholder="'Chọn'" filterable :data="list_nam_hoc" :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                        <el-col :span="8"
                            v-if='dataSearch.loaiDiemDanh==1||dataSearch.loaiDiemDanh==2||dataSearch.loaiDiemDanh==6'>
                            <label>Ngày điểm danh <span style="color:#DC0101">*</span> </label>
                            <el-form-item prop="tuNgay">
                                <date-picker :lang="lang" ref="tuNgay" v-model="dataSearch.tuNgay"
                                    placeholder="Chọn ngày" format="DD/MM/YYYY" valueType="format"
                                    value-type="DD/MM/YYYY">
                                </date-picker>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8" v-if='dataSearch.loaiDiemDanh==3||dataSearch.loaiDiemDanh==7'>
                            <label>Tuần học <span style="color:#DC0101">*</span> </label>

                            <el-form-item prop="tuanHoc">
                                <date-picker v-model="dataSearch.tuanHoc" ref="tuanHoc" placeholder="Chọn tuần"
                                    type="week" valueType="format" @change="chonTuan" value-type="DD/MM/YYYY"
                                    format="ww">
                                </date-picker>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8" v-if='dataSearch.loaiDiemDanh==4||dataSearch.loaiDiemDanh==8'>
                            <label>Tháng học <span style="color:#DC0101">*</span> </label>

                            <el-form-item prop="thangHoc">
                                <date-picker v-model="dataSearch.thangHoc" ref="thangHoc" format="MM/YYYY"
                                    placeholder="Chọn tháng" type="month" valueType="format" @change="chonThang">
                                </date-picker>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8" v-if='dataSearch.loaiDiemDanh==5'>
                            <label>Học kỳ <span style="color:#DC0101">*</span> </label>
                            <el-form-item prop="hocKy">
                                <eselect style="width:100%" ref="hocKy" collapseTags v-model="dataSearch.hocKy"
                                    :placeholder="'Chọn'" filterable :data="list_hoc_ky" :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                    </el-form>
                    <el-col :span="24" class="text-center">
                        <el-button size="mini" @click.prevent="submitForm('ruleForm',1)" type="primary">
                            Xem báo cáo
                        </el-button>
                        <el-button size="mini" @click.prevent="submitForm('ruleForm',2)" type="success">Xuất excel
                        </el-button>
                    </el-col>
                </el-row>
            </div>
        </div>
    </div>
</template>
<script>
    import api from './../../api';
    import rest_api from "../../../utils/rest_api";
    import constant from '../../../utils/constant';
    import utils from '../../../utils'
    import ESelectVue from '../../ui/ESelect.vue';
    import DatePicker from 'vue2-datepicker';
    import moment from 'moment';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/vi';
    import Breadcrumb from '../../ui/Breadcrumb.vue';
    export default {
        components: {
            'eselect': ESelectVue,
            DatePicker,
            Breadcrumb
        },
        computed: {},
        data() {
            return {
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false,
                },
                baseLink: "/view-excel?path=",
                linkExcel: '',
                thangHoc: '',
                tuanHoc: '',
                thongtin: JSON.parse(window.userInfo),
                donVi: '',
                capHoc: '',
                truongHoc: "",
                date: new Date(),
                namHoc: "",
                hocKy: '',
                tuNgay: '',
                denNgay: '',
                loaiDiemDanh: '',
                dataSearch: {
                    loaiDiemDanh: '',
                    donVi: '',
                    capHoc: '',
                    truongHoc: [],
                    namHoc: '',
                    tuNgay: '',
                    denNgay: '',
                    tuanHoc: '',
                    thangHoc: '',
                    hocKy: '',

                },
                rules: {
                    loaiDiemDanh: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    donVi: [{
                        validator: (rule, value, callback) => {
                            // Nếu năm học >= 2025, không cần kiểm tra donVi
                            if (this.dataSearch.namHoc >= 2025) {
                                callback();
                                return;
                            }
                            
                            // Nếu năm học < 2025
                            if (this.dataSearch.loaiDiemDanh == 1) {
                                // Nếu loaiDiemDanh == 1 thì không cần kiểm tra trường donVi
                                callback();
                            } else if (!value) {
                                // Nếu loaiDiemDanh khác 1 và donVi rỗng
                                callback(new Error('Vui lòng nhập thông tin'));
                            } else {
                                // Trường hợp hợp lệ
                                callback();
                            }
                        },
                        trigger: 'change'
                    }],
                    capHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    namHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    tuNgay: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    denNgay: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    tuanHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    thangHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    hocKy: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    },],
                    truongHoc: [{
                        validator: (rule, value, callback) => {
                            // Nếu năm học >= 2025, bắt buộc chọn trường
                            if (this.dataSearch.namHoc >= 2025) {
                                if (!value || value.length === 0) {
                                    callback(new Error('Vui lòng chọn trường học'));
                                } else {
                                    callback();
                                }
                            } else {
                                // Nếu năm học < 2025, không bắt buộc chọn trường
                                callback();
                            }
                        },
                        trigger: 'change'
                    },],
                },
                list_don_vi: [],
                list_don_vi_co_so: [],
                list_don_vi_khong_co_so: [],
                danh_sach_cap_hoc_full: window.listCapHoc,
                list_truong_hoc: [],
                danh_sach_loai_diem_danh: [],
                danh_sach_diem_danh_so: [{
                        name: 'Sở theo ngày',
                        value: '1'
                    },
                    {
                        name: 'Trường theo ngày',
                        value: '2'
                    },
                    {
                        name: 'Trường theo tuần',
                        value: '3'
                    },
                    {
                        name: 'Trường theo tháng',
                        value: '4'
                    },
                    {
                        name: 'Trường theo học kỳ',
                        value: '5'
                    },
                ],
                danh_sach_diem_danh_phong: [{
                        name: 'Trường theo ngày',
                        value: '2'
                    },
                    {
                        name: 'Trường theo tuần',
                        value: '3'
                    },
                    {
                        name: 'Trường theo tháng',
                        value: '4'
                    },
                    {
                        name: 'Trường theo học kỳ',
                        value: '5'
                    },
                ],
                danh_sach_diem_danh_truong: [{
                        name: 'Trường theo ngày',
                        value: '6'
                    },
                    {
                        name: 'Trường theo tuần',
                        value: '7'
                    },
                    {
                        name: 'Trường theo tháng',
                        value: '8'
                    },
                ],
                list_nam_hoc: constant.generateCurrentYearList(),
                list_hoc_ky: constant.LIST_HOC_KY,
            }
        },
        mounted() {
            this.dataSearch.namHoc = this.thongtin.namHocHienTai;
            if (this.thongtin.role == 2) {
                this.danh_sach_loai_diem_danh = this.danh_sach_diem_danh_so;
            }
            if (this.thongtin.role == 4) {
                this.danh_sach_loai_diem_danh = this.danh_sach_diem_danh_phong
                this.dataSearch.donVi = this.thongtin.ma_don_vi;
            }
            if (this.thongtin.role == 5) {
                this.danh_sach_loai_diem_danh = this.danh_sach_diem_danh_truong
                this.dataSearch.donVi = this.thongtin.ma_don_vi;
                this.dataSearch.truongHoc = [this.thongtin.ma_truong_hoc];
                this.dataSearch.capHoc = this.thongtin.listCapHoc[0]
            }
            this.getDonVi();
        },
        watch: {},
        methods: {
            submitForm(formName, type) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        if (type == 1) {
                            this.xemOnline();
                        } else {
                            this.getData();
                        }
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            chonLoaiDiemDanh() {
                if (this.thongtin.role != 5) {
                    this.list_don_vi = this.list_don_vi_co_so;
                    this.dataSearch.capHoc = '';
                    this.dataSearch.truongHoc = [];
                    if (this.thongtin.role != 4) {
                        this.dataSearch.donVi = '';
                    }
                } else {

                }
                this.dataSearch.tuNgay = "";
                this.dataSearch.tuanHoc = "";
                this.dataSearch.thangHoc = "";
                this.dataSearch.hocKy = "";
                if (this.dataSearch.loaiDiemDanh == 1) {
                    this.dataSearch.truongHoc = [];
                }
                if (this.dataSearch.loaiDiemDanh == 2 || this.dataSearch.loaiDiemDanh == 3 || this.dataSearch
                    .loaiDiemDanh == 4 || this.dataSearch.loaiDiemDanh ==
                    5) {
                    console.log("Bỏ mã sở trong danh sách đơn vị:");
                    this.list_don_vi = this.list_don_vi_khong_co_so;
                }
            },
            xemOnline() {
                if (!this.dataSearch.loaiDiemDanh || this.dataSearch.loaiDiemDanh == '') {
                    this.thongBao('error', 'Vui lòng bổ sung loại báo cáo.')
                    return
                }
                if (this.dataSearch.loaiDiemDanh != 1 && (this.dataSearch.donVi == "" || !this.dataSearch.donVi)) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin đơn vị.')
                    return;
                }
                if (this.thongtin.role != 5 && (!this.dataSearch.capHoc || this.dataSearch.capHoc == '')) {
                    this.thongBao('error', 'Vui lòng bổ sung cấp học.');
                    return;
                }
                if (!this.dataSearch.namHoc || this.dataSearch.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung năm học.');
                    return;
                }
                if ((!this.dataSearch.tuNgay || this.dataSearch.tuNgay == '') && (this.dataSearch.loaiDiemDanh == 1 ||
                        this.dataSearch.loaiDiemDanh == 2 || this
                        .dataSearch.loaiDiemDanh == 3 || this.dataSearch.loaiDiemDanh == 4 || this.dataSearch
                        .loaiDiemDanh == 6 || this.dataSearch.loaiDiemDanh ==
                        7 || this.dataSearch.loaiDiemDanh == 8)) {
                    this.thongBao('error', 'Vui lòng bổ sung thời gian báo cáo.')
                    return
                }
                if (this.dataSearch.loaiDiemDanh == 5 && !this.dataSearch.hocKy) {
                    this.thongBao('error', 'Vui lòng bổ sung học kỳ.')
                    return;
                }
                let params = {
                    namHoc: this.dataSearch.namHoc,
                    maTruongHocs: this.dataSearch.truongHoc,
                    maDonVi: this.dataSearch.donVi,
                    ngayBatDau: this.dataSearch.tuNgay,
                    type: this.dataSearch.loaiDiemDanh,
                    capHoc: this.dataSearch.capHoc.toString(),
                    maSo: this.thongtin.ma_so,
                    hocKy: this.dataSearch.hocKy,
                };
                if (!this.dataSearch.capHoc || this.dataSearch.capHoc == "") {
                    delete params.capHoc
                };
                if (this.dataSearch.loaiDiemDanh == 1) {
                    delete params.maDonVi;
                    params.maDonVis = [this.dataSearch.donVi];
                    if (this.dataSearch.donVi == this.thongtin.ma_don_vi) {
                        delete params.maDonVis;
                    }
                }
                if (this.thongtin.role == 5) {
                    params.maTruongHoc = this.thongtin.ma_truong_hoc;
                    params.maDonVi = this.thongtin.ma_don_vi;
                    delete params.maTruongHocs;
                }
                console.log("params")
                console.log(params)
                let url = "xuat-excel-du-lieu-diem-danh";
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                api.post(url, params, (data) => {
                    this.thongBao('success', 'Đang mở kết quả trong thẻ mới...')
                    let link = data.data.file;
                    var d = new Date();
                    var n = d.getTime();
                    let linkExcel = this.baseLink + link + '?t=' + n;
                    setTimeout(() => {
                        loading.close();
                        window.open(linkExcel, '_blank');
                    }, 1500);
                });
            },
            chonThang(e) {
                if (e) {
                    let firstDay = '01/' + this.dataSearch.thangHoc;
                    this.dataSearch.tuNgay = firstDay;
                } else {
                    this.dataSearch.tuNgay = ''
                }
            },
            chonTuan(e) {
                console.log("Chọn tuần:")
                let vm = this;
                let vm2 = this.$refs.tuanHoc;
                console.log(vm)
                console.log(vm2)
                if (e) {
                    let year = moment().year();
                    let now = moment().day("Monday").year(year).week(e).toDate();
                    let firstDay = moment(now).format("DD/MM/YYYY")
                    this.dataSearch.tuNgay = firstDay;
                } else {
                    this.dataSearch.tuNgay = '';
                }
                console.log(this.dataSearch.tuNgay)
            },
            layLaiTruong() {
                if (this.thongtin.role == 5) {} else {
                    this.list_truong_hoc = [];
                    this.dataSearch.truongHoc = [];
                    this.getTruongHoc();
                }
            },
            getData() {
                if (!this.dataSearch.loaiDiemDanh || this.dataSearch.loaiDiemDanh == '') {
                    this.thongBao('error', 'Vui lòng bổ sung loại báo cáo.')
                    return
                }
                if (this.dataSearch.loaiDiemDanh != 1 && (this.dataSearch.donVi == "" || !this.dataSearch.donVi)) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin đơn vị.')
                    return;
                }
                if (this.thongtin.role != 5 && (!this.dataSearch.capHoc || this.dataSearch.capHoc == '')) {
                    this.thongBao('error', 'Vui lòng bổ sung cấp học.');
                    return;
                }
                if (!this.dataSearch.namHoc || this.dataSearch.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung năm học.');
                    return;
                }
                if ((!this.dataSearch.tuNgay || this.dataSearch.tuNgay == '') && (this.dataSearch.loaiDiemDanh == 1 ||
                        this.dataSearch.loaiDiemDanh == 2 || this
                        .dataSearch.loaiDiemDanh == 3 || this.dataSearch.loaiDiemDanh == 4 || this.dataSearch
                        .loaiDiemDanh == 6 || this.dataSearch.loaiDiemDanh ==
                        7 || this.dataSearch.loaiDiemDanh == 8)) {
                    this.thongBao('error', 'Vui lòng bổ sung thời gian báo cáo.')
                    return
                }
                if (this.dataSearch.loaiDiemDanh == 5 && !this.dataSearch.hocKy) {
                    this.thongBao('error', 'Vui lòng bổ sung học kỳ.')
                    return;
                }
                let params = {
                    namHoc: this.dataSearch.namHoc,
                    maTruongHocs: this.dataSearch.truongHoc,
                    maDonVi: this.dataSearch.donVi,
                    ngayBatDau: this.dataSearch.tuNgay,
                    type: this.dataSearch.loaiDiemDanh,
                    capHoc: this.dataSearch.capHoc.toString(),
                    maSo: this.thongtin.ma_so,
                    hocKy: this.dataSearch.hocKy,
                };
                if (!this.dataSearch.capHoc || this.dataSearch.capHoc == "") {
                    delete params.capHoc
                };
                if (this.dataSearch.loaiDiemDanh == 1) {
                    delete params.maDonVi;
                    params.maDonVis = [this.dataSearch.donVi];
                    if (this.dataSearch.donVi == this.thongtin.ma_don_vi) {
                        delete params.maDonVis;
                    }
                }
                if (this.thongtin.role == 5) {
                    params.maTruongHoc = this.thongtin.ma_truong_hoc;
                    delete params.maTruongHocs;
                    params.maDonVi = this.thongtin.ma_don_vi;
                }
                console.log("params")
                console.log(params)
                let url = "xuat-excel-du-lieu-diem-danh";
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.thongBao('success', 'Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(url, params, (data) => {
                            loading.close();
                            let a = document.createElement('a');
                            a.href = data.data.file;
                            document
                                .body
                                .appendChild(a);
                            a.click();
                            this.thongBao('success', 'Tải xuống thành công.')
                            document
                                .body
                                .removeChild(a);
                        });
                    })
                    .catch(_ => {});
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
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.list_don_vi = [];
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    console.log("Lấy đơn vị trả về:")
                    console.log(JSON.stringify(data))
                    if (data.data.statusResponse == 0) {
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                tenDonVi: data_demo[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data_demo[i].maDonVi + ']',
                                maDonVi: data_demo[i].maDonVi,
                            }
                            this.list_don_vi_co_so.push(obj)
                            if (data_demo[i].maDonVi != this.thongtin.ma_so) {
                                this.list_don_vi_khong_co_so.push(obj)
                            }
                        }
                        this.list_don_vi = this.list_don_vi_co_so;
                        this.getTruongHoc();
                    } else {
                        this.thongBao('error', data.data.message)
                    }
                });
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    loose: true,
                    maDonVi: [],
                    capHoc: [],
                };
                if (this.dataSearch.donVi && this.dataSearch.donVi != '') {
                    params.maDonVi = [this.dataSearch.donVi]
                }
                if (this.dataSearch.capHoc && this.dataSearch.capHoc != '') {
                    params.capHoc = [this.dataSearch.capHoc]
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenTruongHoc + " - [" + data.data.rows[i]
                                    .maTruongHoc + "]",
                                value: data.data.rows[i].maTruongHoc,
                            }
                            data_demo.push(obj);
                        }
                        this.list_truong_hoc = data_demo;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">
</style>

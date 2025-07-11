<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <Breadcrumb :menu="'Tiếp nhận dữ liệu QLNT'" :desc="'Cấu hình lịch đồng bộ'"
            :subDesc="'Cấu hình lịch đồng bộ cấp Sở'" />
        <div class="card-bieu-do">
            <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                <el-col :span="24">
                    <div class="table-name">Thông tin tìm kiếm</div>
                </el-col>
                <el-form ref="ruleForm">
                    <el-col :span="4">
                        <label class="typo__label">Năm học </label>
                        <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                            :data="list_nam_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :span="4">
                        <label style="color:transparent;display:block">Tìm kiếm</label>
                        <el-button class="bt-chinh" @click.prevent="TruocKhiTim" size="mini"
                            style="font-size:14px; padding-left:10px;" type="success">Thống kê
                        </el-button>
                    </el-col>
                    <!-- <el-col :span="4">
                            <label class="typo__label">Trạng thái </label>
                            <eselect style="width:100%" collapseTags v-model="trangThai" :placeholder="'Chọn'" filterable
                                :data="list_trang_thai" :fields="['name','value']" />
                        </el-col> -->
                    <!-- <el-col :span="24" class="text-center">
                            <button class="btn btn-success" v-on:click.prevent="TruocKhiTim()">Tìm kiếm
                            </button>
                        </el-col> -->
                </el-form>
            </el-row>
        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <!-- <el-col :span="12" class="">
                    <label>Cấu hình năm học cấp Sở</label>
                </el-col>
                <el-col :span="12">
                    <div class="text-right">
                        <el-tooltip content="Thêm cấu hình mới" placement="top">
                            <el-button class="bt-chinh" type="primary" size="mini" @click.prevent="showThemMoi">
                                Thêm mới
                            </el-button>
                        </el-tooltip>
                    </div>
                </el-col> -->
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <label class="table-name">Cấu hình năm học cấp Sở</label>
                        <div class="text-right">
                            <el-tooltip content="Thêm cấu hình mới" placement="top">
                                <el-button class="bt-chinh" type="primary" size="mini" @click.prevent="showThemMoi">
                                    Thêm mới
                                </el-button>
                            </el-tooltip>
                        </div>
                    </div>
                </el-col>
                <el-col :span="24">

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr style="background:rgb(228, 235, 245)">
                                    <th class="text-center fixed-column fixed-col1">
                                        <p>STT</p>
                                    </th>

                                    <th class="text-center">
                                        <p>Năm học</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày bắt đầu</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày kết thúc</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày cập nhật</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Trạng thái</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Thao tác</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="danh_sach_du_lieu.length===0">
                                <tr>
                                    <td class="text-center" colspan="7">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(tt,index) in danh_sach_du_lieu">
                                    <td class="text-center fixed-column fixed-col1">
                                        <p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                    </td>

                                    <td class="text-center">
                                        <p>{{ tt.namHoc }}-{{ tt.namHoc + 1 }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ tt.dauNamTuNgay }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ tt.dauNamToiNgay }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ tt.updatedTime }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p v-bind:class="getClass(tt.status)">
                                            {{ tt.status == 1 ? 'Đang hoạt động' : 'Ngưng hoạt động' }}</p>
                                    </td>
                                    <td class="text-center fixed-column fixed-col2">
                                        <el-tooltip v-if="tt.status==1" content="Khóa " placement="left">

                                            <!-- <el-button class="lock-btn" @click.prevent="UpdateStatus(tt,1)"
                                                size="mini"> -->
                                            <i class="el-icon-lock" @click.prevent="UpdateStatus(tt,1)"></i>
                                            <!-- </el-button> -->
                                        </el-tooltip>
                                        <el-tooltip v-else content="Mở khóa" placement="left">

                                            <!-- <el-button type="success" @click.prevent="UpdateStatus(tt,2)"
                                                size="mini"> -->
                                            <i class="el-icon-unlock" @click.prevent="UpdateStatus(tt,2)"></i>
                                            <!-- </el-button> -->
                                        </el-tooltip>
                                        <el-tooltip content="Chỉnh sửa" placement="right">
                                            <!-- <el-button type="warning" @click.prevent="chinhSuaTungBanGhi(tt)"
                                                size="mini">

                                                </el-button> -->
                                            <i class="el-icon-edit" @click.prevent="chinhSuaTungBanGhi(tt)"></i>
                                        </el-tooltip>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </el-col>
            </el-row>
        </div>
        <div>
            <el-dialog :title="getTitleAction()" :visible.sync="show_add_or_update" :close-on-click-modal="false"
                :close-on-press-escape="false" :before-close="handleClose">
                <el-form :model='dataAddOrUpdate' :rules="rules" ref="ruleForm">
                    <el-row :gutter="24">
                        <el-col :md="12">
                            <label>Thời gian năm học</label>
                            <el-form-item prop="tuNgay">
                                <el-date-picker
                                        style="width: 100%"
                                        v-model="dataAddOrUpdate.tuNgay"
                                        type="daterange"
                                        align="center"
                                        format="dd/MM/yyyy"
                                        value-format="dd/MM/yyyy"
                                        start-placeholder="Từ ngày"
                                        end-placeholder="Đến ngày"
                                        @change="check_confirm_come_back = true">
                                </el-date-picker>
                            </el-form-item>
                        </el-col>
                    </el-row>


<!--                    <el-row :gutter="24">-->
<!--                        <el-col :span="12">-->
<!--                            <label for="">Từ ngày</label>-->
<!--                            <el-form-item prop="tuNgay">-->
<!--                                <date-picker v-model="dataAddOrUpdate.tuNgay" placeholder="Ngày bắt đầu" ref="tuNgay"-->
<!--                                    valueType="format" :lang="lang" value-type="DD/MM/YYYY" format="DD/MM/YYYY"-->
<!--                                    @change="chonNgayBatDau">-->
<!--                                </date-picker>-->
<!--                            </el-form-item>-->
<!--                        </el-col>-->
<!--                        <el-col :span="12">-->
<!--                            <label for="">Đến ngày</label>-->
<!--                            <el-form-item prop="denNgay">-->
<!--                                <date-picker v-model="dataAddOrUpdate.denNgay" @change="check_confirm_come_back = true"-->
<!--                                    placeholder="Ngày kết thúc" ref="denNgay" :lang="lang" valueType="format"-->
<!--                                    value-type="DD/MM/YYYY" format="DD/MM/YYYY">-->
<!--                                </date-picker>-->
<!--                            </el-form-item>-->
<!--                        </el-col>-->
<!--                    </el-row>-->
                </el-form>
                <span slot="footer" class="dialog-footer">
                    <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                    <el-button size="mini" type="primary" @click.prevent="submitForm('ruleForm')">
                        {{ typeUpdate == 1 ? 'Lưu' : 'Lưu' }}</el-button>
                </span>
            </el-dialog>
        </div>
    </div>
</template>
<script>
    import rest_api from "../../utils/rest_api";
    import constant from '../../utils/constant';
    import Page from "../ui/PagingCustom";
    import ESelectVue from '../ui/ESelect.vue';
    import moment from 'moment';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/vi';
    import ElementUI from 'element-ui';
    import Breadcrumb from "../ui/Breadcrumb.vue";

    Vue.use(ElementUI);
    export default {
        components: {
            "Page": Page,
            'eselect': ESelectVue,
            DatePicker,
            Breadcrumb
        },
        watch: {},
        computed: {},
        data() {
            return {
                check_confirm_come_back: false,

                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false,
                },
                activeClass: 'dts-status-active',
                errorClass: 'dts-status-error',
                thongtin: JSON.parse(window.userInfo),
                date: new Date(),
                namHoc: "",
                idChinhSua: null,
                trangThai: "",
                typeUpdate: null,
                trangbatdau: false,
                danh_sach_du_lieu: [],
                total_rows: 0,
                start: 0,
                currentPage: 1,
                limit: 25,
                show_add_or_update: false,
                list_trang_thai: [{
                    name: "Đang hoạt động",
                    value: 1
                }, {
                    name: "Ngừng hoạt động",
                    value: 2
                }],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                tuNgay: null,
                denNgay: null,
                loading: {
                    status: false,
                    text: 'Loading...'
                },
                dataAddOrUpdate: {
                    tuNgay: [],

                },
                rules: {
                    tuNgay: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'blur'
                    }, ],
                    denNgay: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                }
            }
        },
        mounted() {
            if (this.thongtin.role > 2) {
                let url = this.thongtin.tenMien + "/Configure-sync-calendar?type=2";
                window.location.href = url;
            }
            this.namHoc = this.thongtin.namHocHienTai
            this.getData();
        },
        methods: {
            getClass(stt) {
                return stt == 1 ? 'banGhiDangHoatDong' : 'banGhiNgungHoatDong'
            },
            resetForm(formName) {
                this.dataAddOrUpdate = {
                    tuNgay: [],

                };
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
            },
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.updateOrAdd();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            getTitleAction() {
                let result = '';
                if (this.typeUpdate == 1) {
                    result = 'Thêm mới cấu hình năm học ' + this.namHoc + '-' + (this.namHoc + 1);
                } else {
                    result = 'Chỉnh sửa cấu hình năm học ' + this.namHoc + '-' + (this.namHoc + 1);
                }
                return result;
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
                            this.resetForm('ruleForm')
                            this.show_add_or_update = false;
                        })
                        .catch(_ => {});
                } else {
                    this.resetForm('ruleForm')
                    this.show_add_or_update = false;
                }
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
            UpdateStatus(a, b) {
                if (b == 1) {
                    console.log("Khóa")
                }
                if (b == 2) {
                    console.log("Mở Khóa")
                }
                console.log(b)
                console.log(a)
                let params = {
                    idSo: this.thongtin.ma_so,
                    ids: [a.id],
                    namHoc: this.namHoc,
                    status: null
                }
                if (b == 1) {
                    params.status = 0
                }
                if (b == 2) {
                    params.status = 1
                }
                console.log("Dữ liệu chỉnh sửa:")
                console.log(JSON.stringify(params));
                let msg = 'Xác nhận khóa cấu hình';
                if (b == 2) {
                    msg = 'Xác nhận mở khóa cấu hình'
                }

                this.$confirm(msg, 'Cập nhật trạng thái', {
                        confirmButtonText: b == 1 ? 'Khóa' : 'Mở khóa',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/yeuCauDongBo/toggleStatus", params, data => {
                            loading.close();
                            if (data.data.rc == 0) {
                                if (params.status) {
                                    this.thongBao('success',
                                        'Mở khóa cấu hình nộp dữ liệu cấp sở thành công')
                                } else {
                                    this.thongBao('success', 'Khóa cấu hình nộp dữ liệu cấp sở thành công ')
                                }
                                this.getData();
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            updateOrAdd() {
                console.log("CHỉnh sửa hoặc thêm mới" + this.typeUpdate)
                //typeUpdate:1-thêm mới,
                let obj1 = {
                    dauNamTuNgay: this.dataAddOrUpdate.tuNgay[0],
                    dauNamToiNgay: this.dataAddOrUpdate.tuNgay[1],
                    namHoc: this.namHoc,
                }
                let obj2 = {
                    denNgay: this.dataAddOrUpdate.tuNgay[1],
                    tuNgay: this.dataAddOrUpdate.tuNgay[0],
                    idSo: this.thongtin.ma_so,
                    namHoc: this.namHoc,
                    status: null,
                    ids: [this.idChinhSua]
                }
                if (this.trangThai == 1) {
                    obj2.status = 1;
                }
                if (this.trangThai == 2) {
                    obj2.status = 0;
                }
                if (this.typeUpdate == 1) {

                    let params = obj1
                    const loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    rest_api.post("/csdlgd-admin/yeuCauDongBo", params, data => {
                        loading.close();
                        if (data.data.rc == 0) {
                            this.thongBao('success',
                                'Thêm mới yêu cầu đồng bộ dữ liệu cấp sở thành công')
                            this.getData();
                        } else {
                            this.thongBao('error', data.data.rd)
                        }
                    });
                    // this.$confirm('Xác nhận thêm mới dữ liệu?', 'Thông báo', {
                    //         confirmButtonText: 'Thêm',
                    //         cancelButtonText: 'Hủy',
                    //     })
                    //     .then(_ => {})
                    //     .catch(_ => {});
                }
                if (this.typeUpdate == 2) {

                    let params = obj2
                    const loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    rest_api.put("/csdlgd-admin/yeuCauDongBo", params, data => {
                        loading.close();
                        if (data.data.rc == 0) {
                            this.thongBao('success',
                                'Chỉnh sửa cấu hình năm học cấp sở thành công.')
                            this.getData();
                        } else {
                            this.thongBao('error', data.data.rd)
                        }
                    });
                    // this.$confirm('Xác nhận thay đổi dữ liệu?', 'Thông báo', {
                    //         confirmButtonText: 'Lưu',
                    //         cancelButtonText: 'Hủy',
                    //     })
                    //     .then(_ => {})
                    //     .catch(_ => {});
                }
            },
            chinhSuaTungBanGhi(e) {
                this.typeUpdate = 2;
                console.log(JSON.stringify(e))
                this.dataAddOrUpdate.tuNgay = [e.dauNamTuNgay,e.dauNamToiNgay];

                this.idChinhSua = e.id
                this.show_add_or_update = true;
            },
            chonNgayBatDau(e) {
                console.log("Chọn ngày bắt đầu:" + e)
                this.check_confirm_come_back = true;
                if (this.dataAddOrUpdate.tuNgay != null) {
                    let endDauNam = moment(this.dataAddOrUpdate.tuNgay, "DD/MM/YYYY")
                        .add(10, "days")
                        .format("DD/MM/YYYY");
                    this.dataAddOrUpdate.denNgay = endDauNam;
                }
            },
            closeModal() {
                this.show_add_or_update = false;
            },
            showThemMoi() {
                this.typeUpdate = 1;
                console.log("Show thêm mới:");
                this.show_add_or_update = true;
            },
            getData() {
                this.total_rows = 0;
                this.danh_sach_du_lieu = [];
                this.show_add_or_update = false;
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    start: this.start,
                    limit: this.limit,
                    namHoc: this.namHoc,
                    status: null,
                    idSo: this.thongtin.ma_so,
                };
                if (this.trangThai == 1) {
                    params.status = 1;
                }
                if (this.trangThai == 2) {
                    params.status = 0;
                }
                rest_api.get("/csdlgd-admin/yeuCauDongBo/list", params, data => {
                    loading.close();
                    console.log("Trả về:")
                    console.log(data.data)
                    if (data.data.rc == 0) {
                        this.total_rows = data.data.totalRows;
                        this.danh_sach_du_lieu = data.data.tableData
                        // this.$alertify.success("Lấy dữ liệu thành công");
                    } else {
                        this.danh_sach_du_lieu = [];
                        this.thongBao('error', data.data.rd)
                    }
                });
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            getTenTrangThai(e) {
                if (e == 1) {
                    return "Đang hoạt động";
                } else {
                    return "Ngừng hoạt động";
                }
            },
            TruocKhiTim() {
                console.log("ấn tìm kiếm")
                this.trangbatdau = !this.trangbatdau;
                this.getData();
            },
        }
    }

</script>
<style scoped="scoped">
    .mx-datepicker {
        width: 100% !important;
    }

    .el-switch__label * {
        padding-top: 3px !important;
    }

    h4{
        padding: 0;
        margin: 0;
    }
</style>

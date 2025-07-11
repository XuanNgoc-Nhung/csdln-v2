<template>
    <div v-loading="loading" element-loading-text="Loading..." element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog title="Thêm mới yêu cầu nộp thống kê theo biểu mẫu" :visible.sync="show" width="90%"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
            <el-form :model='dataForm' :rules="rules" ref="ruleForm">
                <el-row :gutter="24">
                    <el-col :sm="12" :lg="6">
                        <label>Loại báo cáo <span style="color:#DC0101">*</span></label>
                        <el-form-item prop="loaiBaoCao">
                            <eselect style="width:100%" collapseTags v-model="dataForm.loaiBaoCao"
                                     @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                     :data="list_loai_bao_cao" ref="loaiBaoCao" :fields="['name','value']" />
                        </el-form-item>
                    </el-col>
                    <el-col :sm="12"  :lg="6">
                        <label class="typo__label">Đơn vị yêu cầu nộp <span
                                style="color:#DC0101">*</span></label>
                        <el-form-item prop="capDonViNop">
                            <eselect style="width:100%" :disabled="thongtin.role>3" collapseTags
                                v-model="dataForm.capDonViNop" ref="capDonViNop" @change="ChonLoaiBaoCao"
                                :placeholder="'Chọn'" filterable :data="doi_tuong_bao_cao"
                                :fields="['name','value']" />
                        </el-form-item>
                    </el-col>
                    <el-col :sm="12" :lg="6" v-if="dataForm.capDonViNop==5">
                        <label class="typo__label">Cấp học </label>
                        <el-form-item prop="listCapHoc">
                            <eselect style="width:100%" ref="listCapHoc" multiple collapseTags
                                     v-model="dataForm.listCapHoc" @change="ChonCapHoc" :placeholder="'Chọn'"
                                     filterable :data="list_cap_hoc" :fields="['name','id']" />
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" v-if="dataForm.capDonViNop==5">
                        <label class="typo__label">Đơn vị quản lý </label>
                        <eselect style="width:100%" :disabled="thongtin.role>3" multiple collapseTags
                            v-model="dataForm.listDonVi" @change="ChonDonVi" :placeholder="'Chọn'"
                            filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12" v-else>
                        <label class="typo__label">Đơn vị quản lý <span
                                style="color:#DC0101">*</span></label>
                        <el-form-item prop="listDonVi">
                            <eselect style="width:100%" :disabled="thongtin.role>3" multiple collapseTags
                                v-model="dataForm.listDonVi" ref="listDonVi" @change="ChonDonVi"
                                :placeholder="'Chọn'" filterable :data="list_don_vi"
                                :fields="['tenDonVi','maDonVi']" />
                        </el-form-item>
                    </el-col>

                    <el-col :xs="24" :sm="24" :md="12" :lg="12" v-if="dataForm.capDonViNop==5">
                        <label class="typo__label">Trường học <span class="red">*</span> </label>
                        <!-- <el-form-item prop="truongHocList">
                    <eselect style="width:100%" ref="truongHocList" multiple collapseTags
                        v-model="dataForm. truongHocList" @change="truongHocChange()"
                        :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                        :fields="['tenTruongHoc','maTruongHoc']" />
                </el-form-item> -->

                        <el-form-item prop="truongHocList">
                            <eselect style="width:100%" ref="truongHocList" multiple collapseTags
                                v-model="dataForm.truongHocList" @change="truongHocChange"
                                :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                :fields="['tenTruongHoc','maTruongHoc']" />
                        </el-form-item>
                    </el-col>

                    <el-col :sm="24" :lg="12">
                        <label>Tên báo cáo <span style="color:#DC0101">*</span></label>
                        <el-form-item prop="tenBaoCao">
                            <el-input type="text" v-model="dataForm.tenBaoCao" ref="tenBaoCao"
                                @change="check_confirm_come_back = true;dataForm.tenBaoCao = dataForm.tenBaoCao.trim()"
                                placeholder="Nhập..." clearable />
                        </el-form-item>
                    </el-col>

                    <el-col :sm="12" :lg="12">
                        <label>Thời gian áp dụng <span style="color:#DC0101">*</span></label>
                        <el-form-item prop="tuNgay">
                            <el-date-picker
                                    style="width: 100%"
                                    v-model="dataForm.tuNgay"
                                    type="daterange"
                                    align="center"
                                    format="dd/MM/yyyy"
                                    value-format="dd/MM/yyyy"
                                    start-placeholder="Từ ngày"
                                    end-placeholder="Đến ngày">
                            </el-date-picker>
                        </el-form-item>
<!--                        <div class="input-group input-daterange" style="width: 100%; display: flex; justify-content: space-between;">-->
<!--                            <div style="display: flex; align-items: center; width: calc(50% - 30px);;">-->
<!--                                <el-form-item prop="tuNgay" style="width: 100%;">-->
<!--                                    <date-picker :lang="lang" style="width: 100%;" v-model="dataForm.tuNgay"-->
<!--                                                 placeholder="Chọn ngày" valueType="format" value-type="DD/MM/YYYY"-->
<!--                                                 format="DD/MM/YYYY" ref="tuNgay" @change="ChonNgayBatDau">-->
<!--                                    </date-picker>-->
<!--                                </el-form-item>-->
<!--                            </div>-->

<!--                            <div style="padding: 6px 12px; font-size: 14px; font-weight: 400; line-height: 1; display: flex; align-items: center;-->
<!--                color: #555; text-align: center; justify-content: center; height: 36px; width: 60px;">-->
<!--                                đến-->
<!--                            </div>-->

<!--                            <div style="display: flex; align-items: center; width: calc(50% - 30px);">-->
<!--                                <el-form-item prop="denNgay" style="width: 100%;">-->
<!--                                    <date-picker :lang="lang" v-model="dataForm.denNgay" style="width: 100%;"-->
<!--                                                 placeholder="Chọn ngày" ref="denNgay" valueType="format"-->
<!--                                                 @change="check_confirm_come_back = true" value-type="DD/MM/YYYY"-->
<!--                                                 format="DD/MM/YYYY">-->
<!--                                    </date-picker>-->
<!--                                </el-form-item>-->
<!--                            </div>-->
<!--                        </div>-->
                    </el-col>
                </el-row>
                <template>
                <upLoadFile @close="show_file=false" :show="show_file" :banghi="thongTinYeuCau"
                @doneUpLoadFile="doneUpLoadFile()">
            </upLoadFile>
                </template>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button size="mini" type="primary" @click.prevent="submitForm('ruleForm')">Lưu</el-button>
            </span>
        </el-dialog>

    </div>
</template>
<script>
    import moment from "moment";
    import ESelectVue from '../../ui/ESelect.vue';
    import rest_api from '../../../../js/utils/rest_api';
    import upLoadFile from './upLoadFile';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/vi';
    import ElementUI from 'element-ui';
    Vue.use(ElementUI);
    export default {
        props: [
            'item', 'show', 'nh'
        ],
        components: {
            DatePicker,
            'eselect': ESelectVue,
            upLoadFile: upLoadFile
        },
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.dataForm = {
                        listDonVi: [],
                        listCapHoc: [],
                        truongHocList: [],
                        tenBaoCao: '',
                        loaiBaoCao: '',
                        tuNgay: [],
                        denNgay: '',
                        capDonViNop: 4
                    };
                    if (this.thongtin.role == 4) {
                        this.dataForm.capDonViNop = 5;
                    }
                    if (this.thongtin.role != 2) {
                        this.dataForm.listDonVi = [this.thongtin.ma_don_vi];
                    }
                    this.dataForm.truongHocList = [];
                    $("#modal_them_yeu_cau_nop_tk_theo_bieu_mau").modal();
                    this.getDonVi();
                } else {
                    $("#modal_them_yeu_cau_nop_tk_theo_bieu_mau").modal('hide');
                }
            },
        },
        data() {
            return {
                check_confirm_come_back: false,
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false,
                },
                doi_tuong_bao_cao: [{
                        name: 'Phòng',
                        value: 4
                    },
                    {
                        name: 'Trường',
                        value: 5
                    },
                ],
                list_truong_hoc_custom: [],
                //hết custom
                tenBaoCao: "",
                tuNgay: "",
                denNgay: "",
                thongtin: JSON.parse(window.userInfo),
                loading: false,
                show_file: false,
                thongTinYeuCau: "",
                loaiBaoCao: "",
                show_huong_dan: false,
                tenFile: '',
                selected_file: null,
                // chọn
                list_don_vi: [],
                list_loai_bao_cao: [{
                        name: 'Báo cáo cộng dồn',
                        value: 0
                    },
                    {
                        name: 'Báo cáo lặp dòng',
                        value: 1
                    },
                ],
                list_cap_hoc: window.listCapHoc,
                list_truong_hoc: [],
                danhSachDonVi: [],
                danhSachCapHoc: [],
                danhSachTruongHoc: [],
                danhSachCapHocApDung: [],
                listDonVi: [],
                listCapHoc: [],
                ds_cap_hoc_ap_dung: [],
                dataForm: {
                    listDonVi: [],
                    listCapHoc: [],
                    tenBaoCao: '',
                    loaiBaoCao: '',
                    tuNgay: '',
                    denNgay: '',
                    capDonViNop: 4,
                    truongHocList: []
                },
                rules: {
                    capDonViNop: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    loaiBaoCao: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    truongHocList: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    listDonVi: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    // listCapHoc: [{
                    //     required: true,
                    //     message: 'Vui lòng nhập thông tin',
                    //     trigger: 'change'
                    // }, ],
                    tenBaoCao: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    tuNgay: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    denNgay: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                }
            }
        },
        mounted: function () {
            console.log("mounted thêm báo cáo")
            console.log(this.thongtin)
            console.log(this.dataForm.listDonVi)
            $(this.$refs.modal_them_yeu_cau_nop_tk_theo_bieu_mau).on("hidden.bs.modal", this.close);
        },
        methods: {
            truongHocChange() {
                this.$forceUpdate()
                console.log('truongHocChange');
                console.log(this.dataForm);
                this.check_confirm_come_back = true
            },
            ChonLoaiBaoCao() {
                console.log('Chọn loại báo cáo:');
                this.dataForm.listDonVi = [];
                this.dataForm.listCapHoc = [];
                this.dataForm.truongHocList = []
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
                    this.close();
                }
            },
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.ThemMoi();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            ChonCapHoc() {
                this.check_confirm_come_back = true;
                this.dataForm.truongHocList = [];
                this.danhSachTruongHoc = [];
                this.getTruongHoc();
            },
            ChonDonVi() {
                this.check_confirm_come_back = true;
                this.dataForm.truongHocList = [];
                this.danhSachTruongHoc = [];
                this.getTruongHoc();
            },
            doneUpLoadFile() {
                this.show_file = false;
                this.$emit('done');
            },
            // Chọn ngày bắt đầu
            ChonNgayBatDau() {
                this.check_confirm_come_back = true;
                if (this.dataForm.tuNgay != null) {
                    let endCuoiNam = moment(this.dataForm.tuNgay, 'DD/MM/YYYY')
                        .add(14, 'days')
                        .format('DD/MM/YYYY');
                    this.dataForm.denNgay = endCuoiNam;
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
            ThemMoi() {

                let params = {
                    ngayApDung: this.dataForm.tuNgay[0],
                    ngayKetThuc:  this.dataForm.tuNgay[1],
                    tenBaoCao: this.dataForm.tenBaoCao,
                    donViNopList: this.dataForm.listDonVi,
                    loaiBaoCao: this.dataForm.loaiBaoCao,
                    capHocNopList: this.dataForm.listCapHoc,
                    maTruongHocList: this.dataForm.truongHocList,
                    capDonViNop: this.dataForm.capDonViNop,
                };
                params.ngayApDung += ' 00:00:00';
                params.ngayKetThuc += ' 23:59:59';
                this.loading = true;
                rest_api.post("/csdlgd-admin/nop-bieu-mau/create", params, data => {
                    this.loading = false;
                    if (data.data.rc == 0) {
                        console.log(JSON.stringify(data.data));
                        let tm = data
                            .data
                        this
                            .upLoadFile(tm);
                    } else {
                        this.thongBao('error', 'Thêm yêu cầu thất bại. Vui lòng thử lại.')
                        return
                    }
                });
                // this.$confirm('Xác nhận thêm mới?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {
                //     })
                //     .catch(_ => {});
            },
            // Lấy trường học
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.dataForm.listDonVi,
                    capHoc: this.dataForm.listCapHoc
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    console.log("lấy trường");
                    if (data.data.code == 200) {
                        let lth = [];
                        let dulieu = data.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenTruongHoc: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                maTruongHoc: dulieu[i].maTruongHoc
                            }
                            lth.push(obj)
                        }
                        this.list_truong_hoc = lth;
                    }
                });
            },
            // Bước thứ 2 upload file
            upLoadFile(e) {
                console.log("hiển thị thêm file của:" + JSON.stringify(e));
                this.thongTinYeuCau = e.item;
                this.show_file = true
            },
            // Lấy danh sách đơn vị
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_don_vi
                };
                if (this.thongtin.role == 5 || this.thongtin.role == 4) {
                    params.maTinhThanh = "";
                    params.maQuanHuyen = this.thongtin.ma_don_vi;
                }
                this.loading = true;
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    this.loading = false;
                    if (data.data.statusResponse == 0) {
                        let ldv = []
                        let dulieu = data.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenDonVi: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                maDonVi: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi = ldv;
                    }
                    this.getTruongHoc();
                });
            },
            // định nghĩa cho đơn vị
            setNameDonVi({
                tenDonVi,
                maDonVi
            }) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // định nghĩa cho trường
            setNameTruongHoc({
                tenTruongHoc,
                maTruongHoc
            }) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            // định nghĩa cho cấp học
            setNameCapHoc({
                name
            }) {
                return `${name}`
            },
            close() {
                console.log("close modal");
                this.resetForm('ruleForm')
                this.$emit('close');
            },
            resetForm(formName) {
                this.dataForm = {
                    listDonVi: [],
                    listCapHoc: [],
                    tenBaoCao: '',
                    loaiBaoCao: '',
                    tuNgay: [],
                    denNgay: '',
                };
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
            },
            reset() {
                this.$emit('done')
            }
        }
    }

</script>
<style>
    .containe {
        display: table;
        margin: 0 auto;
        font-size: 12px;
    }

    .modal-body {
        font-size: 12px;
    }

    .timkiem {
        padding-top: 15px;
    }

    hr {
        margin: 5px;
    }

    .v-modal {}

</style>

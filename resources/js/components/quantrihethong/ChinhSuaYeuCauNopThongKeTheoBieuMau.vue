<template>
    <div>
        <el-dialog title="Chỉnh sửa yêu cầu nộp thống kê theo biểu mẫu" :visible.sync="show" width="90%"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
                <el-form :model='dataForm' :rules="rules" ref="ruleForm">
                    <el-row :gutter="24">
                        <el-col :sm="12" :lg="6">
                            <label>Loại báo cáo <span class="red">*</span></label>
                            <el-form-item prop="loaiBaoCao">
                                <eselect style="width:100%" ref="loaiBaoCao" collapseTags
                                         @change="check_confirm_come_back = true" v-model="dataForm.loaiBaoCao"
                                         :placeholder="'Chọn'" filterable :data="list_loai_bao_cao"
                                         :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="12"  :lg="6">
                            <label class="typo__label">Đơn vị yêu cầu nộp <span
                                    style="color:#DC0101">*</span></label>
                            <el-form-item prop="capDonViNop">
                                <eselect style="width:100%" disabled collapseTags v-model="dataForm.capDonViNop"
                                    ref="capDonViNop" @change="ChonLoaiBaoCao" :placeholder="'Chọn'" filterable
                                    :data="doi_tuong_bao_cao" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="12" :lg="6" v-if="dataForm.capDonViNop==5">
                            <label class="typo__label">Cấp học </label>
                            <el-form-item prop="ds_cap_hoc">
                                <eselect style="width:100%" ref="ds_cap_hoc" multiple collapseTags
                                         v-model="dataForm.ds_cap_hoc" @change="ChonCapHoc" :placeholder="'Chọn'"
                                         filterable :data="list_cap_hoc" :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="24" :md="12" :lg="12" v-if="dataForm.capDonViNop==5">
                            <label class="typo__label">Đơn vị quản lý </label>
                            <eselect style="width:100%" :disabled="thongtin.role>3" multiple collapseTags
                                v-model="dataForm.ds_don_vi" @change="ChonDonVi" :placeholder="'Chọn'"
                                filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                        </el-col>
                        <el-col v-else :xs="24" :sm="24" :md="12" :lg="12">
                            <label class="typo__label">Đơn vị quản lý <span
                                    style="color:#DC0101">*</span></label>
                            <el-form-item prop="ds_don_vi">
                                <eselect style="width:100%" :disabled="thongtin.role>3" multiple collapseTags
                                    v-model="dataForm.ds_don_vi" ref="ds_don_vi" @change="ChonDonVi"
                                    :placeholder="'Chọn'" filterable :data="list_don_vi"
                                    :fields="['tenDonVi','maDonVi']" />
                            </el-form-item>
                        </el-col>

                        <el-col :xs="24" :sm="24" :md="12" :lg="12" v-if="dataForm.capDonViNop==5">
                            <label class="typo__label">Trường học <span class="red">*</span> </label>
                            <el-form-item prop="ds_truong_hoc">
                                <eselect style="width:100%" ref="ds_truong_hoc" multiple collapseTags
                                    v-model="dataForm.ds_truong_hoc" @change="check_confirm_come_back = true"
                                    :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                    :fields="['tenTruongHoc','maTruongHoc']" />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="24" :lg="12">
                            <label>Tên báo cáo <span style="color:#DC0101">*</span></label>
                            <el-form-item prop="tenBaoCao">
                                <el-input type="text" ref="tenBaoCao" clearable v-model="dataForm.tenBaoCao"
                                    @change="check_confirm_come_back = true;dataForm.tenBaoCao=dataForm.tenBaoCao.trim()" />
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
<!--                            <div class="input-group input-daterange">-->
<!--                                <el-form-item prop="tuNgay">-->
<!--                                    <date-picker :lang="lang" style="width:100%" v-model="dataForm.tuNgay"-->
<!--                                        placeholder="Chọn ngày" valueType="format" value-type="DD/MM/YYYY"-->
<!--                                        format="DD/MM/YYYY" ref="tuNgay" @change="ChonNgayBatDau">-->
<!--                                    </date-picker>-->
<!--                                </el-form-item>-->
<!--                                <div class="input-to">đến</div>-->
<!--                                <el-form-item prop="denNgay">-->
<!--                                    <date-picker :lang="lang" style="width:100%" v-model="dataForm.denNgay"-->
<!--                                        @change="check_confirm_come_back = true" placeholder="Chọn ngày"-->
<!--                                        valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY"-->
<!--                                        ref="denNgay">-->
<!--                                    </date-picker>-->
<!--                                </el-form-item>-->
<!--                            </div>-->
                        </el-col>
                    </el-row>
                    <div v-if="isUploadViaEdit" class="row text-center">
                        <div class="col-md-12">
                            <!-- Hết ngày kết thúc -->
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="btn btn-default button-file btn-file" tabindex="0"
                                            id="lblFile">
                                            <i class="fa fa-cloud-upload"></i>
                                            Chọn File <span style="color:#DC0101">*</span>
                                            <div v-if="!tenFile">
                                                <small class="text-primary">
                                                    <em>Tổng dung lượng không quá 10MB</em>
                                                </small>
                                                <br />
                                                <small class="text-secondary">
                                                    <em>Định dạng file hợp lệ: *.xlsx
                                                    </em>
                                                </small>
                                            </div>
                                            <div v-if="tenFile">
                                                <small>
                                                    <em>File đã chọn:
                                                        <b>{{tenFile}}</b>
                                                    </em>
                                                </small>
                                                <br />
                                            </div>
                                            <input ref="file_upload" multiple="false" name="file"
                                                style="display: none;" type="file" @change="onFileChange"
                                                aria-invalid="false" />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </el-form>
                <span slot="footer" class="dialog-footer">
                    <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                    <el-button size="mini" type="primary" @click.prevent="submitForm('ruleForm')">Lưu</el-button>
                </span>
        </el-dialog>
        <div v-if="false" id="modal_chinh_sua_yeu_cau_nop_tk_theo_bieu_mau"
            ref="modal_chinh_sua_yeu_cau_nop_tk_theo_bieu_mau" class="modal fade">
            <div class="modal-dialog modal-dialog-fullscreen">
                <div class="modal-content modal-content-fullscreen">
                    <div class="modal-header modal-header-fullscreen">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="text-uppercase">Chỉnh sửa yêu cầu nộp thống kê theo biểu mẫu</h4>
                    </div>
                    <!-- Content -->
                    <div class="modal-body modal-body-fullscreen">

                        <el-form :model='dataForm' :rules="rules" ref="ruleForm">
                            <el-row :gutter="24">
                                <el-col :offset="4" :span="3">
                                    <label class="typo__label">Đơn vị yêu cầu nộp <span
                                            style="color:#DC0101">*</span></label>
                                    <el-form-item prop="capDonViNop">
                                        <eselect style="width:100%" disabled collapseTags v-model="dataForm.capDonViNop"
                                            ref="capDonViNop" @change="ChonLoaiBaoCao" :placeholder="'Chọn'" filterable
                                            :data="doi_tuong_bao_cao" :fields="['name','value']" />
                                    </el-form-item>
                                </el-col>
                                <el-col :span="5" v-if="dataForm.capDonViNop==5">
                                    <label class="typo__label">Đơn vị quản lý </label>
                                    <eselect style="width:100%" :disabled="thongtin.role>3" multiple collapseTags
                                        v-model="dataForm.ds_don_vi" @change="ChonDonVi" :placeholder="'Chọn'"
                                        filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                                </el-col>
                                <el-col v-else :span="5">
                                    <label class="typo__label">Đơn vị quản lý <span
                                            style="color:#DC0101">*</span></label>
                                    <el-form-item prop="ds_don_vi">
                                        <eselect style="width:100%" :disabled="thongtin.role>3" multiple collapseTags
                                            v-model="dataForm.ds_don_vi" ref="ds_don_vi" @change="ChonDonVi"
                                            :placeholder="'Chọn'" filterable :data="list_don_vi"
                                            :fields="['tenDonVi','maDonVi']" />
                                    </el-form-item>
                                </el-col>
                                <el-col :span="3" v-if="dataForm.capDonViNop==5">
                                    <label class="typo__label">Cấp học </label>
                                    <el-form-item prop="ds_cap_hoc">
                                        <eselect style="width:100%" ref="ds_cap_hoc" multiple collapseTags
                                            v-model="dataForm.ds_cap_hoc" @change="ChonCapHoc" :placeholder="'Chọn'"
                                            filterable :data="list_cap_hoc" :fields="['name','id']" />
                                    </el-form-item>
                                </el-col>
                                <el-col :span="5" v-if="dataForm.capDonViNop==5">
                                    <label class="typo__label">Trường học <span class="red">*</span> </label>
                                    <el-form-item prop="ds_truong_hoc">
                                        <eselect style="width:100%" ref="ds_truong_hoc" multiple collapseTags
                                            v-model="dataForm.ds_truong_hoc" @change="check_confirm_come_back = true"
                                            :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                            :fields="['tenTruongHoc','maTruongHoc']" />
                                    </el-form-item>
                                </el-col>
                            </el-row>

                            <el-row :gutter="20">
                                <el-col :span="8" :offset="4">
                                    <label>Tên báo cáo <span style="color:#DC0101">*</span></label>
                                    <el-form-item prop="tenBaoCao">
                                        <el-input type="text" ref="tenBaoCao" clearable v-model="dataForm.tenBaoCao"
                                            @change="check_confirm_come_back = true;dataForm.tenBaoCao=dataForm.tenBaoCao.trim()" />
                                    </el-form-item>
                                </el-col>
                                <el-col :span="8">
                                    <label>Loại báo cáo <span class="red">*</span></label>
                                    <el-form-item prop="loaiBaoCao">
                                        <eselect style="width:100%" ref="loaiBaoCao" collapseTags
                                            @change="check_confirm_come_back = true" v-model="dataForm.loaiBaoCao"
                                            :placeholder="'Chọn'" filterable :data="list_loai_bao_cao"
                                            :fields="['name','value']" />
                                    </el-form-item>
                                </el-col>
                            </el-row>
                            <el-row :gutter="20">
                                <el-col :span="16" :offset="4">
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
<!--                                    <div class="input-group input-daterange">-->
<!--                                        <el-form-item prop="tuNgay">-->
<!--                                            <date-picker :lang="lang" style="width:100%" v-model="dataForm.tuNgay"-->
<!--                                                placeholder="Chọn ngày" valueType="format" value-type="DD/MM/YYYY"-->
<!--                                                format="DD/MM/YYYY" ref="tuNgay" @change="ChonNgayBatDau">-->
<!--                                            </date-picker>-->
<!--                                        </el-form-item>-->
<!--                                        <div class="input-to">đến</div>-->
<!--                                        <el-form-item prop="denNgay">-->
<!--                                            <date-picker :lang="lang" style="width:100%" v-model="dataForm.denNgay"-->
<!--                                                @change="check_confirm_come_back = true" placeholder="Chọn ngày"-->
<!--                                                valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY"-->
<!--                                                ref="denNgay">-->
<!--                                            </date-picker>-->
<!--                                        </el-form-item>-->
<!--                                    </div>-->
                                </el-col>
                            </el-row>
                            <div v-if="isUploadViaEdit" class="row text-center">
                                <div class="col-md-12">
                                    <!-- Hết ngày kết thúc -->
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label class="btn btn-default button-file btn-file" tabindex="0"
                                                    id="lblFile">
                                                    <i class="fa fa-cloud-upload"></i>
                                                    Chọn File <span style="color:#DC0101">*</span>
                                                    <div v-if="!tenFile">
                                                        <small class="text-primary">
                                                            <em>Tổng dung lượng không quá 10MB</em>
                                                        </small>
                                                        <br />
                                                        <small class="text-secondary">
                                                            <em>Định dạng file hợp lệ: *.xlsx
                                                            </em>
                                                        </small>
                                                    </div>
                                                    <div v-if="tenFile">
                                                        <small>
                                                            <em>File đã chọn:
                                                                <b>{{tenFile}}</b>
                                                            </em>
                                                        </small>
                                                        <br />
                                                    </div>
                                                    <input ref="file_upload" multiple="false" name="file"
                                                        style="display: none;" type="file" @change="onFileChange"
                                                        aria-invalid="false" />
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </el-form>
                    </div>
                    <div class="modal-footer modal-footer-fullscreen">
                        <el-button type="default" size="mini" @click.prevent="handleClose()">Hủy
                        </el-button>
                        <el-button type="primary" size="mini" @click.prevent="submitForm('ruleForm')">Lưu
                        </el-button>
                    </div>
                </div>
            </div>
            <div class="row"></div>
        </div>
    </div>

</template>

<script>
    import Multiselect from 'vue-multiselect'
    import dialog from '../../../js/utils/dialog';
    import datePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import moment from "moment";
    import array_util from '../../utils/array_utils';
    import utils from '../../../js/utils';
    import constant from "../../utils/constant";
    import ESelectVue from '../ui/ESelect.vue';
    import rest_api from '../../../js/utils/rest_api';
    import api from './../api';
    import VueAlertify from "vue-alertify";
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            // dialogs default title
            title: 'Thông báo',
            // ok button text
            ok: 'Đồng ý',
            // cancel button text
            cancel: 'Hủy'
        }
    });
    export default {

        props: [
            'item', 'show', 'nh'
        ],

        components: {
            datePicker,
            Multiselect,
            'eselect': ESelectVue,
        },
        watch: {
            show: function (newVal) {
                if (newVal) {
                    this.getTruongHoc();
                    this.getDonVi();
                    this.getDetail();
                    $("#modal_chinh_sua_yeu_cau_nop_tk_theo_bieu_mau").modal();
                } else {

                    $("#modal_chinh_sua_yeu_cau_nop_tk_theo_bieu_mau").modal('hide');
                }
            },
        },
        data() {
            return {
                //Custom cho chọn tất cả
                //Hết c
                dataForm: {
                    ds_don_vi: [],
                    ds_cap_hoc: [],
                    ds_truong_hoc: [],
                    tenBaoCao: '',
                    loaiBaoCao: '',
                    tuNgay: [],
                    denNgay: '',
                    capDonViNop: ''
                },
                rules: {
                    ds_truong_hoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],

                    loaiBaoCao: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    ds_don_vi: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    // ds_cap_hoc: [{
                    //     required: true,
                    //     message: 'Vui lòng nhập thông tin',
                    //     trigger: 'change'
                    // }, ],
                    tenBaoCao: [{
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
                },
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false,
                },
                thongTinYeuCau: {},
                tenBaoCao: "",
                tuNgay: "",
                denNgay: "",
                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                thongtin: {},
                show_huong_dan: false,
                tenFile: '',
                loaiBaoCao: "",
                selected_file: null,
                // chọn
                list_don_vi: [],
                list_cap_hoc: window.listCapHoc,
                list_truong_hoc: [],
                danhSachDonVi: [],
                danhSachCapHoc: [],
                danhSachTruongHoc: [],
                danhSachCapHocApDung: [],
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_cap_hoc_ap_dung: [],
                ds_truong_hoc: [],
                // danh sách chỉnh sửa
                isUploadViaEdit: false,
                donViNopList: [],
                capHocNopList: [],
                truongHocNopList: [],
                mangcaphoc: [],
                list_loai_bao_cao: [{
                        name: 'Báo cáo cộng dồn',
                        value: 0
                    },
                    {
                        name: 'Báo cáo lặp dòng',
                        value: 1
                    },
                ],

                doi_tuong_bao_cao: [{
                        name: 'Phòng',
                        value: 4
                    },
                    {
                        name: 'Trường',
                        value: 5
                    },
                ],
                // hết check danh sách
            }
        },

        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            $(this.$refs.modal_chinh_sua_yeu_cau_nop_tk_theo_bieu_mau).on("hidden.bs.modal", this.close);
        },

        methods: {
            ChonLoaiBaoCao() {
                console.log('Chọn loại báo cáo:');
                this.dataForm.listDonVi = [];
                this.dataForm.listCapHoc = [];
                this.dataForm.ds_truong_hoc = []
            },
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.ChinhSua();
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
                            this.close();
                        })
                        .catch(_ => {});
                } else {
                    this.close();
                }
            },

            limitTextTruong(count) {
                return `và ${count} trường học khác`
            },
            limitTextCapHoc(count) {
                return `và ${count} cấp học khác`
            },
            limitTextDonVi(count) {
                return `và ${count} đơn vị khác`
            },
            ChonDonVi() {

                this.check_confirm_come_back = true;
                this.dataForm.ds_truong_hoc = [];
                this.danhSachTruongHoc = [];
                console.log("Đơn vị sau khi chọn:" + this.dataForm.ds_don_vi);
                this.getTruongHoc();
            },
            ChinhSua() {
                let params = {
                    id: this.item.id,
                    ngayApDung: this.dataForm.tuNgay[0],
                    ngayKetThuc: this.dataForm.tuNgay[1],
                    tenBaoCao: this.dataForm.tenBaoCao,
                    donViNopList: this.dataForm.ds_don_vi,
                    loaiBaoCao: this.dataForm.loaiBaoCao,
                    capHocNopList: this.dataForm.ds_cap_hoc,
                    capDonViNop: this.dataForm.capDonViNop,
                    maTruongHocList: this.dataForm.ds_truong_hoc
                };
                params.ngayApDung += ' 00:00:00';
                params.ngayKetThuc += ' 23:59:59';
                const loading3 = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/nop-bieu-mau/update", params, data => {
                    loading3.close();
                    console.log(data)
                    if (data.data.rc == 0) {
                        console.log(JSON.stringify(data.data));
                        this.thongBao('success', 'Sửa thành công')
                        this.$emit('done');
                        this.close();
                    } else {
                        this.thongBao('error', data.data.rd)
                        return

                    }
                });
                // this.$confirm('Xác nhận chỉnh sửa thông tin?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {
                //     })
                //     .catch(_ => {});

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
            //Chọn cấp học
            ChonCapHoc() {
                this.check_confirm_come_back = true;
                this.dataForm.ds_truong_hoc = [];
                this.danhSachTruongHoc = [];
                console.log("cấp học sau khi chọn:" + this.dataForm.ds_cap_hoc)
                this.getTruongHoc();
            },
            // Lấy thông tin
            getDetail() {
                let params = {
                    id: this.item.id
                };
                const loading2 = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-admin/nop-bieu-mau/findOne", params, data => {
                    loading2.close();
                    if (data.data.rc == 0) {
                        this.thongTinYeuCau = data.data.item;
                        this.findData();
                    } else {

                        this
                            .$alertify
                            .error(data.data.rd);
                        return
                    }
                });
            },
            // Gán dữ liệu
            findData() {
                console.log("gán dữ liệu");
                console.log(JSON.stringify(this.thongTinYeuCau));
                this.dataForm.tenBaoCao = this.thongTinYeuCau.tenBaoCao;
                this.dataForm.loaiBaoCao = this.thongTinYeuCau.loaiBaoCao;
                this.dataForm.capDonViNop = this.thongTinYeuCau.capDonViNop ? parseInt(this.thongTinYeuCau
                    .capDonViNop) : null;
                console.log("loại báo cáo:" + this.dataForm.loaiBaoCao)
                // nếu có đơn vị
                if (this.thongTinYeuCau.donViNopList.length > 0) {
                    this.danhSachDonVi = this.thongTinYeuCau.donViNopList;
                    if (this.danhSachDonVi) {
                        let lsdv = this.danhSachDonVi.map((obj) => {
                            return obj['maDonVi']
                        });
                        this.dataForm.ds_don_vi = lsdv;
                    }
                }
                if (this.thongTinYeuCau.capHocNop) {
                    let mangcap = "[" + this
                        .thongTinYeuCau
                        .capHocNop
                        .split(",") + "]";
                    mangcap = JSON.parse(mangcap)
                    console.log(JSON.stringify(mangcap));
                    for (let i = 0; i < mangcap.length; i++) {
                        for (let t = 0; t < this.list_cap_hoc.length; t++) {
                            if (mangcap[i] == this.list_cap_hoc[t].id) {
                                this
                                    .mangcaphoc
                                    .push(this.list_cap_hoc[t]);
                            }
                        }
                    }
                    this.danhSachCapHoc = this.mangcaphoc;
                    if (this.danhSachCapHoc) {
                        let lsch = this.danhSachCapHoc.map((obj) => {
                            return obj['id']
                        });
                        this.dataForm.ds_cap_hoc = lsch;
                    }
                    this.mangcaphoc = [];
                }
                if (this.thongTinYeuCau.truongHocNopList) {
                    console.log("Các trường nộp là:" + JSON.stringify(this.thongTinYeuCau.truongHocNopList))
                    this.danhSachTruongHoc = this.thongTinYeuCau.truongHocNopList;

                    let lsth = this.danhSachTruongHoc.map((obj) => {
                        return obj['maTruongHoc']
                    });
                    this.dataForm.ds_truong_hoc = lsth;
                }
                this.dataForm.tuNgay = [this.thongTinYeuCau.ngayApDung,this.thongTinYeuCau.ngayKetThuc];
                this.dataForm.denNgay = this.thongTinYeuCau.ngayKetThuc;
            },
            // Chọn ngày bắt đầu
            ChonNgayBatDau() {
                this.check_confirm_come_back = true;
                if (this.dataForm.tuNgay != null) {
                    let endCuoiNam = moment(this.dataForm.tuNgay, 'DD/MM/YYYY')
                        .add(6, 'days')
                        .format('DD/MM/YYYY');
                    this.dataForm.denNgay = endCuoiNam;
                }
            },
            // Chọn file

            onFileChange(e) {
                console.log("chọn file");
                const files = e.target.files;
                this.tenFile = '';
                if (!files) {
                    dialog.showDialog("Thông báo", "Trình duyệt không hỗ trợ upload file");
                    return;
                }
                this.selected_file = files[0];
                // const size = parseInt(this.selected_file.size); console.log("kích thước
                // file:"+ size);
                if (files && files[0]) {
                    let fileType = this.selected_file["type"];
                    let ValidImageTypes = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                        dialog.showDialog("Thông báo", "Vui lòng chọn file excel");
                        this.selected_file = null;
                        return;
                    }
                    this.file_name = e
                        .target
                        .files[0]
                        .name;
                    this.tenFile = this.file_name;
                }
                // console.log("upload xong"); console.log("tên file:" + this.file_name);

            },
            HuongDan() {
                console.log("Hướng dẫn");
                this.show_huong_dan = true;
            },
            ThemMoi() {
                console.log("thêm mới");
                if (this.dataForm.ds_don_vi.length == 0) {
                    this
                        .$alertify
                        .error("Vui lòng chọn đơn vị.");
                    return;

                }
                if (!this.dataForm.tuNgay) {
                    this
                        .$alertify
                        .error("Vui lòng bổ sung ngày bắt đầu.");
                    return;

                }


                let params = {
                    ngayApDung: this.dataForm.tuNgay[0],
                    ngayKetThuc: this.dataForm.tuNgay[1],
                    tenBaoCao: this.dataForm.tenBaoCao,
                    donViNopList: this.dataForm.ds_don_vi,
                    capHocNopList: this.dataForm.ds_don_vi,
                    maTruongHocList: this.dataForm.ds_don_vi
                };

                const loading4 = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/nop-bieu-mau/create", params, data => {
                    loading4.close();
                    console.log("Thêm mứi trả về:" + JSON.stringify(data));
                    if (data.data.rc == 0) {
                        this.thongBao('success', 'Thêm yêu cầu thành công')
                        this.$emit('done');
                        this.close();
                    } else {
                        this.thongBao('error', 'Thêm yêu cầu thành công')
                        return

                    }
                });
                // dialog.confirmDialog("Xác nhận chỉnh sửa yêu cầu?", "Đồng ý", () => {
                // });

            },
            // Lấy trường học
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.dataForm.ds_don_vi,
                    capHoc: this.dataForm.ds_cap_hoc
                };
                const loading5 = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading5.close();
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

            // Lấy danh sách đơn vị
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_don_vi
                };
                if (this.thongtin.role == 5 || this.thongtin.role == 4) {
                    params.maTinhThanh = "",
                        params.maQuanHuyen = this.thongtin.ma_don_vi;
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
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
                this.check_confirm_come_back = false;
                console.log("close modal");
                this.$emit('close');
            },
            reset() {
                this.$emit('done')
            }
        }

    }

</script>
<style scoped="scoped">
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

</style>

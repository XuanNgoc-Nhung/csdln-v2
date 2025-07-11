<template>
    <div id="modal_them_yeu_cau_nop_tk_theo_bieu_mau" ref="modal_them_yeu_cau_nop_tk_theo_bieu_mau" class="modal fade">
        <div class="modal-dialog modal-dialog-fullscreen">
            <div class="modal-content modal-content-fullscreen">
                <div class="modal-header modal-header-fullscreen">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Thêm mới yêu cầu  213</h4>
                </div>
                <!-- Content -->
                <div class="modal-body modal-body-fullscreen">
                    <div class="row">
                        <!-- đơn vị -->
                        <div class="col-md-5 timkiem">
                            <label class="typo__label">Chọn đơn vị <span style="color:#DC0101">*</span></label>
                            <div>
                                <eselect style="width:100%" :disabled="thongtin.role>3" multiple collapseTags
                                    v-model="ds_don_vi" @change="ChonDonVi" :placeholder="'Chọn'" filterable
                                    :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                            </div>
                        </div>
                        <!-- end đơn vị -->
                        <!-- cấp học -->
                        <div class="col-md-3 timkiem">
                            <div>
                                <label class="typo__label">Chọn cấp học <span style="color:#DC0101">*</span></label>
                                <div>
                                    <eselect style="width:100%" multiple collapseTags v-model="ds_cap_hoc"
                                        @change="ChonCapHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                                        :fields="['name','id']" />
                                </div>
                            </div>
                        </div>
                        <!-- end cấp học -->
                        <!-- Trường học -->
                        <div class="col-md-4 timkiem">
                            <div>
                                <label class="typo__label">Chọn trường học <span style="color:#DC0101">*</span></label>
                                <eselect style="width:100%" multiple collapseTags v-model="ds_truong_hoc"
                                    :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                    :fields="['tenTruongHoc','maTruongHoc']" />
                            </div>
                        </div>
                    </div>
                    <div class="row space10">
                        <div class="containe" style="padding:0 15%; background:ghostwhite">
                            <div class="col-md-6 timkiem">
                                <label>Tên báo cáo <span style="color:#DC0101">*</span></label>
                                <input type="text" v-model="tenBaoCao" placeholder="Nhập..."
                                    class="form-control" />
                            </div>
                            <div class="col-md-6 timkiem">
                                <label>Loại báo cáo</label>
                                <select v-model="loaiBaoCao" class="form-control">
                                    <option value="">Chọn loại báo cáo</option>
                                    <option value="0">Báo cáo cộng dồn</option>
                                    <option value="1">Báo cáo ghép dòng</option>
                                </select>
                            </div>
                            <div class="col-md-6 timkiem">
                                <label>Ngày bắt đầu <span style="color:#DC0101">*</span></label>
                                <date-picker :config="configDatePicker" placeholder="Ngày bắt đầu"
                                    @dp-change="ChonNgayBatDau" v-model="tuNgay"></date-picker>
                            </div>
                            <!-- Hết ngày bắt đầu -->
                            <!-- Ngày kết thúc -->
                            <div class="col-md-6 timkiem">
                                <label>Ngày kết thúc <span style="color:#DC0101">*</span></label>
                                <date-picker :config="configDatePicker" placeholder="Ngày bắt đầu" v-model="denNgay">
                                </date-picker>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end Content -->
                <div class="modal-footer modal-footer-fullscreen">

                    <el-button style="margin-right:5px" class="dts-button-close" size="mini" data-dismiss="modal">Đóng
                    </el-button>
                    <el-button type="primary" size="mini" @click.prevent="ThemMoi()">Thêm mới</el-button>

                </div>
            </div>
        </div>
        <div class="row"></div>
        <template v-if="show_file">
            <upLoadFile @close="show_file=false" :banghi="thongTinYeuCau" @doneUpLoadFile="doneUpLoadFile()">
            </upLoadFile>
        </template>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import dialog from '../../../js/utils/dialog';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import moment from "moment";
    import ESelectVue from '../ui/ESelect.vue';
    import array_util from '../../utils/array_utils';
    import utils from '../../../js/utils';
    import constant from "../../utils/constant";
    import rest_api from '../../../js/utils/rest_api';
    import upLoadFile from './ImportFileYeuCauTkBm';
    import api from './../api';
    import ElementUI from 'element-ui';
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
            upLoadFile: upLoadFile
        },
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_them_yeu_cau_nop_tk_theo_bieu_mau").modal();
                    this.getDonVi();
                } else {
                    $("#modal_them_yeu_cau_nop_tk_theo_bieu_mau").modal('hide');
                }
            },
            danhSachDonVi: function (newVal) {
                // console.log(JSON.stringify(this.ds_don_vi));
            },
            danhSachCapHoc: function (newVal) {},
            danhSachTruongHoc: function (newVal) {
                // this.getTruongHoc();
            }
        },
        data() {
            return {
                list_truong_hoc_custom: [],
                //hết custom
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
                show_file: false,
                thongTinYeuCau: "",
                loaiBaoCao: "",
                show_huong_dan: false,
                tenFile: '',
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
                ds_truong_hoc: []
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_yeu_cau_nop_tk_theo_bieu_mau).on("hidden.bs.modal", this.close);
        },
        methods: {
            ChonTruongHoc() {
                this.ds_truong_hoc = [];
                if (this.danhSachTruongHoc) {
                    let lsth = this.danhSachTruongHoc.map((obj) => {
                        return obj['maTruongHoc']
                    });
                    this.ds_truong_hoc = lsth;
                }
                console.log("Danh sách trường học:" + this.ds_truong_hoc)
            },
            ChonCapHoc() {
                this.ds_truong_hoc = [];
                this.danhSachTruongHoc = [];
                console.log("cấp học sau khi chọn:" + this.ds_cap_hoc)
                this.getTruongHoc();
            },
            ChonDonVi() {
                this.ds_truong_hoc = [];
                this.danhSachTruongHoc = [];
                console.log("Đơn vị sau khi chọn:" + this.ds_don_vi);
                this.getTruongHoc();
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
            doneUpLoadFile() {
                this.show_file = false;
                this.$emit('done');
            },
            // Chọn ngày bắt đầu
            ChonNgayBatDau() {
                if (this.tuNgay != null) {
                    let endCuoiNam = moment(this.tuNgay, 'DD/MM/YYYY')
                        .add(6, 'days')
                        .format('DD/MM/YYYY');
                    this.denNgay = endCuoiNam;
                }
            },
            HuongDan() {
                console.log("Hướng dẫn");
                this.show_huong_dan = true;
            },
            ThemMoi() {
                if (this.ds_don_vi.length == 0) {
                    this
                        .$alertify
                        .error("Vui lòng chọn đơn vị.");
                    return;
                }
                console.log("thêm mới");
                if (this.ds_truong_hoc.length == 0) {
                    this
                        .$alertify
                        .error("Vui lòng chọn trường học.");
                    return;
                }
                if (this.ds_cap_hoc.length == 0) {
                    this
                        .$alertify
                        .error("Vui lòng chọn cấp học.");
                    return;
                }
                if (!this.tenBaoCao) {
                    this
                        .$alertify
                        .error("Vui lòng bổ sung tên báo cáo.");
                    return;
                }
                if (!this.loaiBaoCao) {
                    this
                        .$alertify
                        .error("Vui lòng bổ sung loại báo cáo.");
                    return;
                }
                if (!this.tuNgay) {
                    this
                        .$alertify
                        .error("Vui lòng bổ sung ngày bắt đầu.");
                    return;
                }
                if (!this.denNgay) {
                    this
                        .$alertify
                        .error("Vui lòng bổ sung ngày kết thúc.");
                    return;
                }
                dialog.confirmDialog("Xác nhận thêm mới?", "Đồng ý", () => {
                    let params = {
                        ngayApDung: this.tuNgay,
                        ngayKetThuc: this.denNgay,
                        tenBaoCao: this.tenBaoCao,
                        donViNopList: this.ds_don_vi,
                        loaiBaoCao: parseInt(this.loaiBaoCao),
                        capHocNopList: this.ds_cap_hoc,
                        maTruongHocList: this.ds_truong_hoc
                    };
                    rest_api.post("/csdlgd-admin/nop-bieu-mau/create", params, data => {
                        if (data.data.rc == 0) {
                            console.log(JSON.stringify(data.data));
                            let tm = data
                                .data
                            this
                                .upLoadFile(tm);
                        } else {
                            this
                                .$alertify
                                .error("Thêm yêu cầu thất bại. Vui lòng thử lại.");
                            return
                        }
                    });
                });
            },
            // Lấy trường học
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    // capHoc: this.ds_cap_hoc
                    capHoc: ['1', '2', '3', '6']
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    console.log("lấy trường");
                    loading.close();
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
                    params.maTinhThanh = "",
                        params.maQuanHuyen = this.thongtin.ma_don_vi;
                    this.ds_don_vi = [this.thongtin.ma_don_vi];
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
                                tenDonVi: dulieu[i].tenDonVi + ' - [' + dulieu[i].maDonVi + ']',
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

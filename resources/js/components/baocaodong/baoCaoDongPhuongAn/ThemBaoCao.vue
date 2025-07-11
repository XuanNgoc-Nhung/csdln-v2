<template>
    <div>
        <div id="modal_them_bao_cao" ref="modal_them_bao_cao" class="modal fade">
            <div class="modal-dialog-fullscreen">
                <form @submit.prevent="submitForm">
                    <div class="modal-content-fullscreen">
                        <div class="modal-header-fullscreen">
                            <h5 class="modal-title text-uppercase">Thêm báo cáo</h5>
                        </div>
                        <div class="modal-body-fullscreen">
                            <div class="row" style="margin:15px 0">
                                <div class="col-md-6 dts-col">
                                    <label for="">Tên báo cáo</label>
                                    <input type="text" class="form-control" v-model="thongTinNhomBaoCao.tenBaoCao"
                                        name="ten_bao_cao" placeholder="Nhập..." v-validate="{required:true}">
                                    <span v-if="show_msg"><span class="text-danger"
                                            v-show="errors.has('ten_bao_cao')">{{ errors.first('ten_bao_cao') }}</span></span>
                                </div>
                                <div class="col-md-6 dts-col">
                                    <label for="">Mô tả</label>
                                    <input type="text" class="form-control" v-model="thongTinNhomBaoCao.moTa"
                                        placeholder="Nhập..." name="mo_ta" v-validate="{required:true}">
                                    <span v-if="show_msg"><span class="text-danger"
                                            v-show="errors.has('mo_ta')">{{ errors.first('mo_ta') }}</span></span>
                                </div>
                                <div class="col-md-12 dts-col">
                                    <label for="">Địa chỉ file biểu mẫu</label>
                                    <el-input clearable placeholder="Nhập..."
                                        v-model="filePath" class="input-with-select" name="dia_chi_file"
                                        v-validate="{required:true}">
                                        <el-button plain type="success" size="mini" slot="append"
                                            @click="showUploadFile">
                                            upload file
                                        </el-button>
                                    </el-input>
                                    <span v-if="show_msg"><span class="text-danger"
                                            v-show="errors.has('dia_chi_file')">{{ errors.first('dia_chi_file') }}</span></span>
                                </div>
                                <div class="col-md-6 dts-col">
                                    <label for="">Thẻ <span style="color:#DC0101;display:none"> *</span></label>
                                    <el-select multiple name="the" v-validate="{required:true}"
                                        v-model="thongTinNhomBaoCao.Tags" filterable allow-create default-first-option
                                        placeholder="Nhập..."
                                        no-data-text="Không có thẻ gợi ý. Vui lòng nhập thẻ mong muốn rồi ấn Enter.">
                                        <el-option v-for="item in list_tags" :key="item.value" :label="item.label"
                                            :value="item.value">
                                        </el-option>
                                    </el-select>
                                    <span v-if="show_msg"><span class="text-danger"
                                            v-show="errors.has('the')">{{ errors.first('the') }}</span></span>
                                </div>
                                <div class="col-md-3 dts-col">
                                    <label class="typo__label">Loại báo cáo </label>
                                    <eselect name="loai_bao_cao" v-validate="{required:true}" @change="chonLoaiBaoCao"
                                        style="width:100%" v-model="thongTinNhomBaoCao.reportLoopType" collapseTags
                                        :placeholder="'Chọn'" filterable :data="list_loai_bao_cao"
                                        :fields="['name','value']" />
                                    <span v-if="show_msg"><span class="text-danger"
                                            v-show="errors.has('loai_bao_cao')">{{ errors.first('loai_bao_cao') }}</span></span>
                                </div>
                                <div class="col-md-3 dts-col">
                                    <label class="typo__label">Đối tượng lặp <span style="color:#DC0101"
                                            v-show="canDoiTuong">*</span></label>
                                    <eselect name="doi_tuong_lap" v-validate="{required:canDoiTuong ? true : false}"
                                        style="width:100%" v-model="thongTinNhomBaoCao.doiTuongLap" collapseTags
                                        :placeholder="'Chọn'" filterable :data="list_doi_tuong_lap"
                                        :fields="['name','value']" />
                                    <span v-if="show_msg"><span class="text-danger"
                                            v-show="errors.has('doi_tuong_lap')">{{ errors.first('doi_tuong_lap') }}</span></span>
                                </div>
                                <div class="col-md-5  dts-col">
                                    <label for="">Đơn vị</label>
                                    <eselect style="width:100%" multiple collapseTags @change="chonDonVi"
                                        v-model="thongTinNhomBaoCao.donVi" no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" :placeholder="'Chọn'" filterable
                                        :data="list_don_vi_duoc_phep_ot" :fields="['tenDonVi','maDonVi']" />
                                </div>
                                <div class="col-md-2 dts-col">
                                    <label for="">Cấp học</label>
                                    <eselect style="width:100%" multiple v-model="thongTinNhomBaoCao.capHoc"
                                        @change="chonDonVi" no-match-text="Không tìm thấy bản ghi nào"
                                         no-data-text="danh sách lựa chọn trống"
                                        collapse-tags :placeholder="'Chọn'" filterable
                                        :data="danh_sach_cap_hoc_duoc_phep_ot" :fields="['name','id']" />
                                </div>
                                <div class="col-md-5 dts-col">
                                    <label for="">Trường học</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        v-model="thongTinNhomBaoCao.truongHoc" no-data-text="danh sách lựa chọn trống"
                                         collapse-tags
                                        :placeholder="'Chọn'" filterable
                                        :data="danh_sach_truong_hoc_duoc_phep_ot" :fields="['name','value']" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer-fullscreen">
                            <el-button type="primary" size="mini" @click.prevent='submitForm' style="margin: 0 5px">Thêm
                            </el-button>
                            <el-button type="default" size="mini" data-dismiss="modal">Đóng
                            </el-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div v-if="hien_thi_upload_file">
            <Import @close="dongModalImport" @success="ganLink($event)"></Import>
        </div>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import rest_api from "../../../utils/rest_api";
    import dialog from '../../../utils/dialog';
    import ESelectVue from '../../ui/ESelect.vue';
    import Import from "./ImportFile.vue";
    import VeeValidate, {
        Validator
    } from 'vee-validate';
    Vue.use(VeeValidate);
    Vue.use(ElementUI);
    export default {
        props: ['nhom_cha', 'show'],
        watch: {

            show: function (newVal) {
                console.log("show:" + newVal)
                if (newVal) {
                    $("#modal_them_bao_cao").modal();
                    console.log("Mount trong thêm báo cáo")
                    console.log("Nhóm cha")
                    console.log(JSON.stringify(this.nhom_cha))
                    this.danh_sach_cap_hoc_duoc_phep = this.nhom_cha.capHocList;
                    this.mapCapHocDuocPhep(this.danh_sach_cap_hoc_duoc_phep)
                    this.list_don_vi_duoc_phep = this.nhom_cha.donViList;
                    this.danh_sach_truong_hoc_duoc_phep = this.nhom_cha.maTruongList;
                    this.thongTinBaoCao = this.nhom_cha;
                    this.getDonVi();
                } else {

                    $("#modal_them_bao_cao").modal('hide');
                }
            },
        },
        components: {
            'eselect': ESelectVue,
            'Import': Import,
        },
        data() {
            return {
                canDoiTuong: false,
                list_doi_tuong_lap: [{
                        name: "Phòng",
                        value: "1"
                    },
                    {
                        name: "Trường",
                        value: "2"
                    }, {
                        name: "Khối",
                        value: "3"
                    }, {
                        name: "Lớp",
                        value: "4"
                    }
                ],
                show_msg: false,
                hien_thi_upload_file: false,
                thongtin: JSON.parse(window.userInfo),
                danh_sach_cap_hoc: window.listCapHoc,
                danh_sach_truong_hoc_duoc_phep_ot: [],
                list_don_vi_duoc_phep: [],
                list_don_vi_duoc_phep_ot: [],
                danh_sach_cap_hoc_duoc_phep: [],
                danh_sach_cap_hoc_duoc_phep_ot: [],
                list_don_vi: [],
                list_tags: [],
                danh_sach_truong_hoc: [],
                list_loai_bao_cao: [{
                    name: "Báo cáo không lặp",
                    value: "KHONG_LAP"
                }, {
                    name: "Báo cáo lặp đơn dòng",
                    value: "LAP_DON_DONG"
                }, {
                    name: "Báo cáo lặp đa dòng",
                    value: "LAP_DA_DONG"
                }],
                thongTinNhomBaoCao: {},
                filePath: "",
            }
        },
        mounted: function () {
            this.customMessage();
            $(this.$refs.modal_them_bao_cao).on("hidden.bs.modal", this.close);
        },
        methods: {
            chonLoaiBaoCao() {
                let kq = false;
                if (this.thongTinNhomBaoCao.reportLoopType == 'KHONG_LAP') {
                    kq = false
                } else {
                    kq = true
                }
                this.canDoiTuong = kq;
            },
            getLoaiBaoCao(e) {
                let kq = false;
                if (e == 'KHONG_LAP' || e == "" || e == null) {
                    kq = false
                } else {
                    kq = true
                }
                this.canDoiTuong = kq;
            },
            dongModalImport() {
                console.log("Đóng modal import")
                this.hien_thi_upload_file = false
            },
            mapCapHocDuocPhep(e) {
                let dt = e;
                this.danh_sach_cap_hoc_duoc_phep_ot = [];
                console.log("map danh sách cấp học được phép:");
                console.log(JSON.stringify(e));
                for (let i = 0; i < dt.length; i++) {
                    for (let j = 0; j < this.danh_sach_cap_hoc.length; j++) {
                        if (dt[i] == this.danh_sach_cap_hoc[j].id) {
                            this.danh_sach_cap_hoc_duoc_phep_ot.push(this.danh_sach_cap_hoc[j])
                        }
                    }
                }
            },
            ganLink(e) {
                console.log("gán link trong file thêm báo cáo")
                this.filePath = e;
                this.thongBao('success', 'Upload file & Gán địa chỉ thành công');
                this.hien_thi_upload_file = false;
            },
            showUploadFile() {
                this.hien_thi_upload_file = true;
                console.log("show_import");
            },
            chonDonVi() {
                console.log("Chọn đơn vị trong thêm nhóm báo cáo");
                this.thongTinNhomBaoCao.truongHoc = "";
                this.danh_sach_truong_hoc = [];
                this.getTruongHoc();
            },
            getTruongHoc() {
                const loadingGetSchool = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    maDonVi: this.thongTinNhomBaoCao.donVi,
                    capHoc: this.thongTinNhomBaoCao.capHoc,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loadingGetSchool.close();
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
                        this.danh_sach_truong_hoc = data_demo;
                        this.mapTruongHocDuocPhep(this.danh_sach_truong_hoc_duoc_phep)
                    } else {
                        this.danh_sach_truong_hoc = [];
                    }
                });
            },
            mapTruongHocDuocPhep(e) {
                let dt = [];
                 if (e&&e.length>0){
                    dt = e;
                    this.danh_sach_truong_hoc_duoc_phep_ot = [];
                    console.log("map danh sách trường học được phép 4: ");
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.danh_sach_truong_hoc.length; j++) {
                            if (dt[i] == this.danh_sach_truong_hoc[j].value) {
                                this.danh_sach_truong_hoc_duoc_phep_ot.push(this.danh_sach_truong_hoc[j])
                            }
                        }
                    }
                }
                else{
                    this.danh_sach_truong_hoc_duoc_phep_ot = this.danh_sach_truong_hoc;
                }

            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                tenDonVi: data.data.rows[i].tenDonVi + " - [" + data.data.rows[i].maDonVi +
                                    "]",
                                maDonVi: data.data.rows[i].maDonVi,
                            }
                            data_demo.push(obj);
                        }
                        this.list_don_vi = data_demo;
                        this.mapDonVi(this.list_don_vi_duoc_phep);
                        this.getTruongHoc();
                    }
                });
            },
            mapDonVi(e) {
                let dt = [];
                 if (e&&e.length>0){
                    dt = e;
                    this.list_don_vi_duoc_phep_ot = [];
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.list_don_vi.length; j++) {
                            if (dt[i] == this.list_don_vi[j].maDonVi) {
                                this.list_don_vi_duoc_phep_ot.push(this.list_don_vi[j])
                            }
                        }
                    }
                } else {
                    this.list_don_vi_duoc_phep_ot = this.list_don_vi
                }

            },
            ThemNhomBaoCao() {
                let params = {
                    "dataReq": {
                        analyticReportGroupId: this.nhom_cha.ma,
                        capHocList: this.thongTinNhomBaoCao.capHoc,
                        description: this.thongTinNhomBaoCao.moTa,
                        donViList: this.thongTinNhomBaoCao.donVi,
                        maTruongList: this.thongTinNhomBaoCao.truongHoc,
                        tags: this.thongTinNhomBaoCao.Tags,
                        name: this.thongTinNhomBaoCao.tenBaoCao,
                        reportLoopType: this.thongTinNhomBaoCao.reportLoopType,
                        templateFile: this.filePath,
                        maSoList: [this.thongtin.ma_so],
                    }
                }
                console.log(params);
                console.log("params");
                this.$confirm('Xác nhận thêm mới thông tin?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Vui lòng chờ trong giây lát...',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-analytic-api/BcChiTiet/createBc", params, (
                            data) => {
                            loading.close()
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.thongBao('success', 'Thêm thông tin thành công');
                                this.$emit('success')
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
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
            customMessage() {
                const dict = {
                    custom: {
                        ten_bao_cao: {
                            required: () => 'Tên báo cáo không thể trống'
                        },
                        mo_ta: {
                            required: () => 'Mô tả không thể trống'
                        },
                        dia_chi_file: {
                            required: () => 'Địa chỉ file không thể trống'
                        },
                        // don_vi: {
                        //     required: () => 'Đơn vị không thể trống'
                        // },
                        // cap_hoc: {
                        //     required: () => 'Cấp học không thể trống'
                        // },
                        // truong_hoc: {
                        //     required: () => 'Trường học không thể trống'
                        // },
                        the: {
                            required: () => 'Thẻ tags không thể trống'
                        },
                        loai_bao_cao: {
                            required: () => 'Loại báo cáo không thể trống'
                        },
                    }
                };
                this
                    .$validator
                    .localize('vi', dict);
            },
            submitForm() {

                this.show_msg = true;
                this
                    .$validator
                    .validateAll()
                    .then(result => {
                        if (result) {
                            this.ThemNhomBaoCao();
                        }
                    });
            },
            close() {
                console.log("Đóng modal")
                this.$emit('close');
            },
        }
    }

</script>
<style scoped="scoped">
    .dts-col {
        margin: 10px 0;
    }

</style>

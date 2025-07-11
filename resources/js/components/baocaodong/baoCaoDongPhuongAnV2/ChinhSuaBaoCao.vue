<template>
    <div>
        <el-dialog title="Chỉnh sửa thông tin báo cáo" :visible.sync="hien_thi" fullscreen>
            <form @submit.prevent="submitForm">

                <div class="row" style="margin:15px 0">
                    <div class="col-md-6 dts-col">
                        <label for="">Tên báo cáo</label>
                        <input type="text" class="form-control" v-model="thongTinBaoCao.name" name="ten_bao_cao"
                            placeholder="Nhập..." v-validate="{required:true}">
                        <span v-if="show_msg"><span class="text-danger"
                                v-show="errors.has('ten_bao_cao')">{{ errors.first('ten_bao_cao') }}</span></span>
                    </div>
                    <div class="col-md-6 dts-col">
                        <label for="">Mô tả báo cáo</label>
                        <input type="text" class="form-control" v-model="thongTinBaoCao.description" name="mo_ta"
                            placeholder="Nhập..." v-validate="{required:true}">
                        <span v-if="show_msg"><span class="text-danger"
                                v-show="errors.has('mo_ta')">{{ errors.first('mo_ta') }}</span></span>
                    </div>
                    <div class="col-md-12 dts-col">
                        <label for="">Địa chỉ file biểu mẫu</label>
                        <el-input clearable placeholder="Nhập..." v-model="filePath"
                            class="input-with-select" name="dia_chi_file" v-validate="{required:true}">
                            <el-button size='mini' plain type="success" slot="append" @click="showUploadFile">
                                upload file
                            </el-button>
                        </el-input>
                        <span v-if="show_msg"><span class="text-danger"
                                v-show="errors.has('dia_chi_file')">{{ errors.first('dia_chi_file') }}</span></span>
                    </div>
                    <div class="col-md-6 dts-col">
                        <label for="">Thẻ</label>
                        <el-select multiple name="the" v-validate="{required:true}" v-model="thongTinBaoCao.tags"
                            filterable allow-create default-first-option placeholder="Nhập..."
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
                            style="width:100%" v-model="thongTinBaoCao.reportLoopType" collapseTags
                            :placeholder="'Chọn'" filterable :data="list_loai_bao_cao" :fields="['name','value']" />
                        <span v-if="show_msg"><span class="text-danger"
                                v-show="errors.has('loai_bao_cao')">{{ errors.first('loai_bao_cao') }}</span></span>
                    </div>
                    <div class="col-md-3 dts-col">
                        <label class="typo__label">Đối tượng lặp <span v-show="canDoiTuong" style="color:#DC0101">*</span>
                        </label>
                        <eselect name="doi_tuong_lap" v-validate="{required:canDoiTuong ? true : false}"
                            style="width:100%" v-model="thongTinBaoCao.doiTuongLap" collapseTags :placeholder="'Chọn'"
                            filterable :data="list_doi_tuong_lap" :fields="['name','value']" />
                        <span v-if="show_msg"><span class="text-danger"
                                v-show="errors.has('doi_tuong_lap')">{{ errors.first('doi_tuong_lap') }}</span></span>
                    </div>
                    <div class="col-md-5 dts-col">
                        <label for="">Đơn vị</label>
                        <eselect name="ma_don_vi" v-validate="{required:true}"  style="width:100%" collapseTags multiple v-model="thongTinBaoCao.donViList" @change="ChonDonVi"
                            no-match-text="Không tìm thấy bản ghi nào" no-data-text="danh sách lựa chọn trống"
                            :placeholder="'Chọn'" filterable :data="danh_sach_don_vi_duoc_phep_ot"
                            :fields="['tenDonVi','maDonVi']" />
                        <span v-if="show_msg"><span class="text-danger"
                                v-show="errors.has('ma_don_vi')">{{ errors.first('ma_don_vi') }}</span></span>
                    </div>
                    <div class="col-md-2 dts-col">
                        <label for="">Cấp học</label>
                        <eselect name="cap_hoc" v-validate="{required:true}"  style="width:100%" multiple v-model="thongTinBaoCao.capHocList" @change="ChonDonVi"
                            collapseTags no-match-text="Không tìm thấy bản ghi nào"
                            no-data-text="danh sách lựa chọn trống" :placeholder="'Chọn'" filterable
                            :data="danh_sach_cap_hoc_duoc_phep_ot" :fields="['name','id']" />
                        <span v-if="show_msg"><span class="text-danger"
                                v-show="errors.has('cap_hoc')">{{ errors.first('cap_hoc') }}</span></span>
                    </div>
                    <div class="col-md-5 dts-col">
                        <label for="">Trường học</label>
                        <eselect style="width:100%" v-model="thongTinBaoCao.maTruongList" multiple collapseTags
                            no-match-text="Không tìm thấy bản ghi nào" no-data-text="danh sách lựa chọn trống"
                            :placeholder="'Chọn'" filterable :data="danh_sach_truong_hoc_duoc_phep_ot"
                            :fields="['name','value']" />
                    </div>
                </div>
            </form>

            <div slot="footer" class="dialog-footer">
                <el-button type="warning" size="mini" @click.prevent="submitForm">
                    Chỉnh sửa
                </el-button>
                <el-button type="default" size="mini" @click.prevent="close">Đóng
                </el-button>
            </div>
        <div v-show="hien_thi_upload_file">
            <Import @close="hien_thi_upload_file=false" :show="hien_thi_upload_file" @success="ganLink($event)">
            </Import>
        </div>
        </el-dialog>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
    import Import from "./ImportFile.vue";
    import dialog from '../../../utils/dialog';
    export default {
        props: [
            'item', 'show'
        ],
        components: {
            'eselect': ESelectVue,
            'Import': Import,
        },
        data() {
            return {
                hien_thi: false,
                thongTinBaoCao: {},
                canDoiTuong: false,
                thongtin: JSON.parse(window.userInfo),
                danh_sach_cap_hoc_full: window.listCapHoc,
                danh_sach_don_vi_full: [],
                danh_sach_truong_hoc_full: [],
                danh_sach_don_vi_duoc_phep: [],
                danh_sach_don_vi_duoc_phep_ot: [],
                danh_sach_cap_hoc_duoc_phep: [],
                danh_sach_cap_hoc_duoc_phep_ot: [],
                danh_sach_truong_hoc_duoc_phep: [],
                danh_sach_truong_hoc_duoc_phep_ot: [],
                list_tags: [],
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
                hien_thi_chinh_sua_bao_cao: false,
                hien_thi_upload_file: false,
                show_msg: false,
                filePath: "",
            };
        },
        watch: {
            item: function (newVal) {
                console.log('watch item in update report:' + this.show)
                if (newVal && this.show) {
                    console.log("watch item chỉnh sửa" + newVal)
                    this.getThongTinBaoCao(newVal)
                }
            },
            show: function (newVal) {
                if (newVal) {
                    this.hien_thi = true;
                    // $("#modal_chinh_sua_bao_cao").modal();
                    // console.log("mout trong chỉnh sửa báo cáo 123456789");
                    this.getFullDonVi();
                    this.customMessage();
                } else {

                    this.hien_thi = false;
                    // $("#modal_chinh_sua_bao_cao").modal('hide');
                }
            },
        },
        mounted: function () {
            // console.log('Mount chỉnh sửa báo cáo')
            // $(this.$refs.modal_chinh_sua_bao_cao).on("hidden.bs.modal", this.close);
        },
        methods: {
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
            chonLoaiBaoCao() {
                let kq = false;
                if (this.thongTinBaoCao.reportLoopType == 'KHONG_LAP') {
                    kq = false
                } else {
                    kq = true
                }
                this.canDoiTuong = kq;
            },
            ganLink(e) {
                this.filePath = e;
                this.thongBao('success', 'Upload file & gán địa chỉ thành công')
                this.hien_thi_upload_file = false;
            },
            ChonDonVi() {
                this.danh_sach_truong_hoc_duoc_phep_ot = [];
                this.thongTinBaoCao.maTruongList = [];
                this.getTruongHoc();
            },
            showUploadFile() {
                console.log("hien_thi_upload_file = true")
                this.hien_thi_upload_file = true;
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
                        doi_tuong_lap: {
                            required: () => 'Đối tượng lặp là bắt buộc đối với báo cáo lặp dòng'
                        },
                        ma_don_vi: {
                            required: () => 'Đơn vị không thể trống'
                        },
                        cap_hoc: {
                            required: () => 'Cấp học không thể trống'
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
                            this.ChinhSuaBaoCao();
                        }
                    });
            },
            ChinhSuaBaoCao() {
                let params = {
                    "dataReq": {
                        analyticReportGroupId: this.thongTinBaoCao.analyticReportGroupId,
                        capHocList: this.thongTinBaoCao.capHocList,
                        description: this.thongTinBaoCao.description,
                        donViList: this.thongTinBaoCao.donViList,
                        maTruongList: this.thongTinBaoCao.maTruongList,
                        reportLoopType: this.thongTinBaoCao.reportLoopType,
                        tags: this.thongTinBaoCao.tags,
                        ma: this.thongTinBaoCao.ma,
                        name: this.thongTinBaoCao.name,
                        templateFile: this.filePath,
                        maSoList: [this.thongtin.ma_so],
                    }
                }
                this.$confirm('Xác nhận chỉnh sửa thông tin?', 'Thông báo', {
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
                        rest_api.post("/csdlgd-analytic-api/BcChiTiet/updateBc", params, (
                            data) => {
                            loading.close()
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.thongBao('success', 'Chỉnh sửa dữ liệu thành công')
                                let dl = this.idBaoCao;
                                this.$emit('success', dl);
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            getFullDonVi() {
                const loadingGetSchool = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loadingGetSchool.close();
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
                        this.danh_sach_don_vi_full = data_demo;
                        console.log("get full đơn vị")
                        this.getFullTruongHoc();
                    }
                });
            },

            getTruongHoc() {
                const loadingGetSchool = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    maDonVi: this.thongTinBaoCao.donViList,
                    capHoc: this.thongTinBaoCao.capHocList,
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
                        this.danh_sach_truong_hoc_full = data_demo;
                        this.getThongTinBaoCao2(this.item);
                    } else {
                        this.danh_sach_truong_hoc_full = [];
                    }
                });
            },
            getFullTruongHoc() {
                const loadingGetSchool = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    maDonVi: [],
                    capHoc: [],
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
                        this.danh_sach_truong_hoc_full = data_demo;

                        console.log("getFullTruongHoc")
                        this.getThongTinBaoCao(this.item);
                    } else {
                        this.danh_sach_truong_hoc_full = [];
                    }
                });
            },
            getThongTinNhomCha(e) {
                const loadingLayThongTinNhomCha = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let idNhomCha = e.analyticReportGroupId;
                let params = {
                    id: idNhomCha
                }
                rest_api.get("/csdlgd-analytic-api/nhomBc/getBc", params, (data) => {
                    loadingLayThongTinNhomCha.close();
                    if (data.data.rc == 0) {
                        let dt = data.data.item;
                        console.log("thông tin nhóm cha chỉnh sửa");
                        this.danh_sach_don_vi_duoc_phep = dt.donViList;
                        console.log(this.danh_sach_don_vi_duoc_phep);
                        this.mapDonViDuocPhep(this.danh_sach_don_vi_duoc_phep)
                        this.danh_sach_cap_hoc_duoc_phep = dt.capHocList;
                        this.mapCapHocDuocPhep(this.danh_sach_cap_hoc_duoc_phep)
                        this.danh_sach_truong_hoc_duoc_phep = dt.maTruongList;
                        this.mapTruongHocDuocPhep(this.danh_sach_truong_hoc_duoc_phep)
                    } else {}
                });
            },
            mapTruongHocDuocPhep(e) {
                let dt = [];
                if (e) {
                    dt = e;
                }
                this.danh_sach_truong_hoc_duoc_phep_ot = [];
                console.log("map danh sách trường học được phép1:");
                console.log(JSON.stringify(e));
                if (dt.length > 0) {
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.danh_sach_truong_hoc_full.length; j++) {
                            if (dt[i] == this.danh_sach_truong_hoc_full[j].value) {
                                this.danh_sach_truong_hoc_duoc_phep_ot.push(this.danh_sach_truong_hoc_full[j])
                            }
                        }
                    }
                } else {
                    this.danh_sach_truong_hoc_duoc_phep_ot = this.danh_sach_truong_hoc_full;
                }
            },
            mapCapHocDuocPhep(e) {
                let dt = [];
                if (e) {
                    dt = e;
                }
                this.danh_sach_cap_hoc_duoc_phep_ot = [];
                console.log("map danh sách cấp học được phép:");
                console.log(JSON.stringify(e));
                if (dt.length > 0) {

                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.danh_sach_cap_hoc_full.length; j++) {
                            if (dt[i] == this.danh_sach_cap_hoc_full[j].id) {
                                this.danh_sach_cap_hoc_duoc_phep_ot.push(this.danh_sach_cap_hoc_full[j])
                            }
                        }
                    }
                } else {
                    this.danh_sach_cap_hoc_full = this.danh_sach_cap_hoc_full
                }
            },
            mapDonViDuocPhep(e) {
                this.danh_sach_don_vi_duoc_phep_ot = [];
                console.log("map danh sách đơn vị được phép 1:");
                console.log(JSON.stringify(e));
                console.log(JSON.stringify(this.danh_sach_don_vi_full));
                let dt = [];
                if (e) {
                    dt = e;
                }
                if (dt.length > 0) {
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.danh_sach_don_vi_full.length; j++) {
                            if (dt[i] == this.danh_sach_don_vi_full[j].maDonVi) {
                                this.danh_sach_don_vi_duoc_phep_ot.push(this.danh_sach_don_vi_full[j])
                            }
                        }
                    }
                } else {
                    this.danh_sach_don_vi_duoc_phep_ot = this.danh_sach_don_vi_full;
                }
            },
            getThongTinBaoCao(e) {
                const loadingGetThongTin = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.idBaoCao = e;
                let params = {
                    id: e
                }
                rest_api.get("/csdlgd-analytic-api/BcChiTiet/getBcChiTiet", params, (data) => {
                    loadingGetThongTin.close();
                    if (data.data.rc == 0) {
                        let thongtinbaocao = data.data.item;
                        this.thongTinBaoCao = data.data.item;
                        this.chonLoaiBaoCao();
                        this.filePath = this.thongTinBaoCao.templateFile;
                        console.error("123")
                        this.getThongTinNhomCha(thongtinbaocao)
                    } else {}
                });
            },
            getThongTinBaoCao2(e) {
                const loadingGetThongTin = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.idBaoCao = e;
                let params = {
                    id: e
                }
                rest_api.get("/csdlgd-analytic-api/BcChiTiet/getBcChiTiet", params, (data) => {
                    loadingGetThongTin.close();
                    if (data.data.rc == 0) {
                        let thongtinbaocao = data.data.item;
                        console.error("321")
                        this.getThongTinNhomCha(thongtinbaocao)
                    } else {}
                });
            },
            reset() {},
            close() {
                this.hien_thi = false;
                this.reset();
                this.$emit('close');
            },
        },
    };

</script>
<style scope="scoped">
    .dts-col {
        margin-top: 5px;
    }

    .el-dialog__body {
        height: calc(100vh - 120px)
    }

</style>

<template>
    <div id="modal_them_nhom_bao_cao" ref="modal_them_nhom_bao_cao" class="modal fade">
        <div class="modal-dialog-fullscreen">
            <form @submit.prevent="submitForm">
                <div class="modal-content-fullscreen">
                    <div class="modal-header-fullscreen">
                        <h5 class="modal-title text-uppercase">Thêm nhóm báo cáo</h5>
                    </div>
                    <div class="modal-body-fullscreen">
                        <div class="row" style="margin:15px 0">
                            <div class="col-md-12 dts-col">
                                <label for="">Tên nhóm báo cáo</label>
                                <input type="text" class="form-control" v-model="thongTinNhomBaoCao.tenNhom"
                                    name="ten_bao_cao" placeholder="Nhập..." v-validate="{required:true}">
                                <span v-if="show_msg"><span class="text-danger"
                                        v-show="errors.has('ten_bao_cao')">{{ errors.first('ten_bao_cao') }}</span></span>
                            </div>
                            <div class="col-md-5  dts-col">
                                <label for="">Đơn vị</label>
                                <eselect style="width:100%" multiple collapseTags @change="chonDonVi"
                                    v-model="thongTinNhomBaoCao.donVi" no-match-text="Không tìm thấy bản ghi nào"
                                    name="don_vi" v-validate="{required:true}" no-data-text="danh sách lựa chọn trống"
                                    :placeholder="'Chọn'" filterable :data="list_don_vi_duoc_phep_ot"
                                    :fields="['tenDonVi','maDonVi']" />
                                <span v-if="show_msg"><span class="text-danger"
                                        v-show="errors.has('don_vi')">{{ errors.first('don_vi') }}</span></span>
                            </div>
                            <div class="col-md-2 dts-col">
                                <label for="">Cấp học</label>
                                <eselect style="width:100%" multiple v-model="thongTinNhomBaoCao.capHoc"
                                    @change="chonDonVi" no-match-text="Không tìm thấy bản ghi nào" name="cap_hoc"
                                    v-validate="{required:true}" no-data-text="danh sách lựa chọn trống" collapse-tags
                                    :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc_duoc_phep_ot"
                                    :fields="['name','id']" />
                                <span v-if="show_msg"><span class="text-danger"
                                        v-show="errors.has('cap_hoc')">{{ errors.first('cap_hoc') }}</span></span>
                            </div>
                            <div class="col-md-5 dts-col">
                                <label for="">Trường học</label>
                                <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                    v-model="thongTinNhomBaoCao.truongHoc" no-data-text="danh sách lựa chọn trống"
                                    name="truong_hoc" v-validate="{required:true}" collapse-tags
                                    :placeholder="'Chọn'" filterable
                                    :data="danh_sach_truong_hoc_duoc_phep_ot" :fields="['name','value']" />
                                <span v-if="show_msg"><span class="text-danger"
                                        v-show="errors.has('truong_hoc')">{{ errors.first('truong_hoc') }}</span></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-fullscreen">
                        <el-button type="primary" @click.prevent="submitForm" size="mini" style="margin: 0 5px">Thêm mới
                        </el-button>
                        <el-button type="default" size="mini" data-dismiss="modal">Đóng
                        </el-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
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
                    console.log("Mount trong thêm nhóm báo cáo");
                    console.log("Nhóm cha")
                    console.log(JSON.stringify(this.nhom_cha))
                    this.danh_sach_cap_hoc_duoc_phep = this.nhom_cha.capHocList;
                    this.mapCapHocDuocPhep(this.danh_sach_cap_hoc_duoc_phep)
                    this.list_don_vi_duoc_phep = this.nhom_cha.donViList;
                    this.danh_sach_truong_hoc_duoc_phep = this.nhom_cha.maTruongList;
                    this.getDonVi();
                    $("#modal_them_nhom_bao_cao").modal();
                } else {
                    $("#modal_them_nhom_bao_cao").modal('hide');
                }
            },
        },
        components: {
            'eselect': ESelectVue,
        },
        data() {
            return {
                show_msg: false,
                thongtin: JSON.parse(window.userInfo),
                danh_sach_cap_hoc: window.listCapHoc,
                danh_sach_cap_hoc_duoc_phep: [],
                danh_sach_cap_hoc_duoc_phep_ot: [],
                list_don_vi: [],
                list_don_vi_duoc_phep: [],
                list_don_vi_duoc_phep_ot: [],
                danh_sach_truong_hoc: [],
                danh_sach_truong_hoc_duoc_phep: [],
                danh_sach_truong_hoc_duoc_phep_ot: [],
                thongTinNhomBaoCao: {
                    donVi: "",
                    capHoc: "",
                    truongHoc: "",
                    tenNhom: ""
                }
            }
        },
        mounted: function () {
            this.customMessage();
            $(this.$refs.modal_them_nhom_bao_cao).on("hidden.bs.modal", this.close);
        },
        methods: {
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
                        this.mapTruongHocDuocPhep(this.danh_sach_truong_hoc_duoc_phep);
                    } else {
                        this.danh_sach_truong_hoc = [];
                    }
                });
            },
            getDonVi() {
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
                        this.list_don_vi = data_demo;
                        this.mapDonVi(this.list_don_vi_duoc_phep);
                        this.getTruongHoc();
                    }
                });
            },
            mapTruongHocDuocPhep(e) {
                let dt = [];
                this.danh_sach_truong_hoc_duoc_phep_ot = [];
                console.log("map danh sách trường học được phép 5:");
                 if (e&&e.length>0){
                    dt = e;
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.danh_sach_truong_hoc.length; j++) {
                            if (dt[i] == this.danh_sach_truong_hoc[j].value) {
                                this.danh_sach_truong_hoc_duoc_phep_ot.push(this.danh_sach_truong_hoc[j])
                            }
                        }
                    }
                } else {
                    this.danh_sach_truong_hoc_duoc_phep_ot = this.danh_sach_truong_hoc
                }
            },
            mapCapHocDuocPhep(e) {
                this.danh_sach_cap_hoc_duoc_phep_ot = [];
                console.log("map danh sách cấp học được phép:");
                let dt = [];
                 if (e&&e.length>0){
                    dt = e
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.danh_sach_cap_hoc.length; j++) {
                            if (dt[i] == this.danh_sach_cap_hoc[j].id) {
                                this.danh_sach_cap_hoc_duoc_phep_ot.push(this.danh_sach_cap_hoc[j])
                            }
                        }
                    }
                } else {
                    this.danh_sach_cap_hoc_duoc_phep_ot = this.danh_sach_cap_hoc;
                }
            },
            mapDonVi(e) {
                console.log("map danh sách đơn vị được phép 3:");
                this.list_don_vi_duoc_phep_ot = [];
                let dt = [];
                 if (e&&e.length>0){
                    dt = e
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.list_don_vi.length; j++) {
                            if (dt[i] == this.list_don_vi[j].maDonVi) {
                                this.list_don_vi_duoc_phep_ot.push(this.list_don_vi[j])
                            }
                        }
                    }
                } else {
                    this.list_don_vi_duoc_phep_ot = this.list_don_vi;
                }
            },
            ThemNhomBaoCao() {
                let params = {
                    "reqData": {
                        capHocList: this.thongTinNhomBaoCao.capHoc,
                        donViList: this.thongTinNhomBaoCao.donVi,
                        groupName: this.thongTinNhomBaoCao.tenNhom,
                        maTruongList: this.thongTinNhomBaoCao.truongHoc,
                        parentId: this.nhom_cha.ma,
                        treeLevel: this.nhom_cha.treeLevel + 1,
                        maSoList: [this.thongtin.ma_so],
                    }
                }
                console.log(params);
                console.log("params");
                this.$confirm('Xác nhận thêm thông tin?', 'Thông báo', {
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
                        rest_api.post("/csdlgd-analytic-api/nhomBc/createBc", params, (
                            data) => {
                            loading.close()
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.thongBao('success', 'Thêm nhóm báo cáo thành công')
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
                        don_vi: {
                            required: () => 'Đơn vị không thể trống'
                        },
                        cap_hoc: {
                            required: () => 'Cấp học không thể trống'
                        },
                        truong_hoc: {
                            required: () => 'Trường học không thể trống'
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
            reset() {},
            close() {
                this.reset();
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

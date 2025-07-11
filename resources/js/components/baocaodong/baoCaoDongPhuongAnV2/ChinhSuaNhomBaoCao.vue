<template>
    <el-dialog title="Chỉnh sửa nhóm báo cáo" :visible.sync="hien_thi" fullscreen>
        <form @submit.prevent="submitForm">
            <div class="row" style="margin:15px 0">
                <div class="col-md-12 dts-col">
                    <label for="">Tên nhóm báo cáo</label>
                    <input type="text" class="form-control" v-model="thongTinNhomBaoCao.groupName" name="ten_bao_cao"
                        placeholder="Nhập..." v-validate="{required:true}">
                    <span v-if="show_msg"><span class="text-danger"
                            v-show="errors.has('ten_bao_cao')">{{ errors.first('ten_bao_cao') }}</span></span>
                </div>
                <div class="col-md-5  dts-col">
                    <label for="">Đơn vị</label>
                    <eselect style="width:100%" multiple collapseTags @change="chonDonVi"
                        v-model="thongTinNhomBaoCao.donViList" no-match-text="Không tìm thấy bản ghi nào" name="don_vi"
                        v-validate="{required:true}" no-data-text="danh sách lựa chọn trống"
                        :placeholder="'Chọn'" filterable :data="list_don_vi_duoc_phep_ot"
                        :fields="['tenDonVi','maDonVi']" />
                    <span v-if="show_msg"><span class="text-danger"
                            v-show="errors.has('don_vi')">{{ errors.first('don_vi') }}</span></span>
                </div>
                <div class="col-md-2 dts-col">
                    <label for="">Cấp học</label>
                    <eselect style="width:100%" multiple v-model="thongTinNhomBaoCao.capHocList" @change="chonDonVi"
                        no-match-text="Không tìm thấy bản ghi nào" name="cap_hoc" v-validate="{required:true}"
                        no-data-text="danh sách lựa chọn trống" collapse-tags :placeholder="'Chọn'" filterable
                        :data="danh_sach_cap_hoc_duoc_phep_ot" :fields="['name','id']" />
                    <span v-if="show_msg"><span class="text-danger"
                            v-show="errors.has('cap_hoc')">{{ errors.first('cap_hoc') }}</span></span>
                </div>
                <div class="col-md-5 dts-col">
                    <label for="">Trường học</label>
                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                        v-model="thongTinNhomBaoCao.maTruongList" no-data-text="danh sách lựa chọn trống"
                        name="truong_hoc" v-validate="{required:true}" collapse-tags :placeholder="'Chọn'"
                        filterable :data="danh_sach_truong_hoc_duoc_phep_ot" :fields="['name','value']" />
                    <span v-if="show_msg"><span class="text-danger"
                            v-show="errors.has('truong_hoc')">{{ errors.first('truong_hoc') }}</span></span>
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
    </el-dialog>
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
                    console.log("mouted trong chỉnh sửa nhóm báo cáo");
                    console.log("Nhóm");
                    console.log(JSON.stringify(this.nhom_cha))
                    if (this.nhom_cha.treeLevel != 1) {
                        this.getThongTinNhomCha(this.nhom_cha.parentId)
                    } else {
                        this.danh_sach_cap_hoc_duoc_phep = this.nhom_cha.capHocList;
                        this.mapCapHocDuocPhep(this.danh_sach_cap_hoc_duoc_phep)
                        this.list_don_vi_duoc_phep = this.nhom_cha.donViList;
                        this.mapDonVi(this.list_don_vi_duoc_phep);
                        this.danh_sach_truong_hoc_duoc_phep = this.nhom_cha.maTruongList;
                        this.mapTruongHocDuocPhep(this.danh_sach_truong_hoc_duoc_phep);
                    }
                    this.thongTinNhomBaoCao = JSON.parse(JSON.stringify(this.nhom_cha));
                    // $("#modal_chinh_sua_nhom_bao_cao").modal();
                    this.hien_thi = true;
                } else {
                    this.hien_thi = false;
                    // $("#modal_chinh_sua_nhom_bao_cao").modal('hide');
                }
            },
        },
        components: {
            'eselect': ESelectVue,
        },
        data() {
            return {
                hien_thi: false,
                show_msg: false,
                thongtin: JSON.parse(window.userInfo),
                danh_sach_cap_hoc: [],
                danh_sach_cap_hoc_duoc_phep: [],
                danh_sach_cap_hoc_duoc_phep_ot: [],
                list_don_vi: JSON.parse(localStorage["danh_sach_don_vi_full"]),
                list_don_vi_duoc_phep: [],
                list_don_vi_duoc_phep_ot: [],
                danh_sach_truong_hoc: JSON.parse(localStorage["danh_sach_truong_hoc_full"]),
                danh_sach_truong_hoc_duoc_phep: [],
                danh_sach_truong_hoc_duoc_phep_ot: [],
                thongTinNhomBaoCao: {}
            }
        },
        mounted: function () {
            console.log("Danh sách cấp học")
            let check = localStorage["list_cap_hoc"];
            if(check){
                this.danh_sach_cap_hoc = JSON.parse(localStorage["list_cap_hoc"]);
            }
            else{
                this.danh_sach_cap_hoc = [];
            }
            console.error(this.danh_sach_cap_hoc)
            this.customMessage();
            this.getDonVi();
            $(this.$refs.modal_chinh_sua_nhom_bao_cao).on("hidden.bs.modal", this.close);
        },
        methods: {
            getThongTinNhomCha(e) {
                this.danh_sach_cap_hoc_duoc_phep = [];
                this.list_don_vi_duoc_phep = [];
                this.danh_sach_truong_hoc_duoc_phep = [];
                const loading = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    id: e
                }
                rest_api.get("/csdlgd-analytic-api/nhomBc/getBc", params, (data) => {
                    loading.close();
                    if (data.data.rc == 0) {
                        console.log("Thông tin nhóm báo cáo trả vê");
                        console.log(data);
                        let dulieu = data.data.item;
                        this.danh_sach_cap_hoc_duoc_phep = dulieu.capHocList;
                        this.mapCapHocDuocPhep(this.danh_sach_cap_hoc_duoc_phep);
                        this.list_don_vi_duoc_phep = dulieu.donViList;
                        this.mapDonVi(this.list_don_vi_duoc_phep);
                        this.danh_sach_truong_hoc_duoc_phep = dulieu.maTruongList;
                        this.mapTruongHocDuocPhep(this.danh_sach_truong_hoc_duoc_phep);
                    } else {}
                });
            },
            mapTruongHocDuocPhep(e) {
                let dt = [];
                if (e && e.length > 0) {
                    dt = e;
                    this.danh_sach_truong_hoc_duoc_phep_ot = [];
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.danh_sach_truong_hoc.length; j++) {
                            if (dt[i] == this.danh_sach_truong_hoc[j].value) {
                                this.danh_sach_truong_hoc_duoc_phep_ot.push(this.danh_sach_truong_hoc[j])
                            }
                        }
                    }
                } else {
                    this.danh_sach_truong_hoc_duoc_phep_ot = this.danh_sach_truong_hoc;
                }
            },
            mapDonVi(e) {
                console.log("map danh sách đơn vị được phép 4:");
                console.log(e)
                console.log(this.list_don_vi)
                let dt = [];
                if (e && e.length > 0) {
                    console.log('1')
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
                    console.log('2')
                    this.list_don_vi_duoc_phep_ot = this.list_don_vi;
                }
                console.log(this.list_don_vi_duoc_phep_ot)
            },
            mapCapHocDuocPhep(e) {
                let dt = e;
                this.danh_sach_cap_hoc_duoc_phep_ot = [];
                console.error("map danh sách cấp học được phép:");
                console.log(JSON.stringify(dt));
                console.log(JSON.stringify(this.danh_sach_cap_hoc));
                for (let i = 0; i < dt.length; i++) {
                    for (let j = 0; j < this.danh_sach_cap_hoc.length; j++) {
                        if (dt[i] == this.danh_sach_cap_hoc[j].id) {
                            this.danh_sach_cap_hoc_duoc_phep_ot.push(this.danh_sach_cap_hoc[j])
                        }
                    }
                }
            },
            chonDonVi() {
                console.log("Chọn đơn vị trong thêm nhóm báo cáo");
                this.thongTinNhomBaoCao.maTruongList = "";
                this.danh_sach_truong_hoc_duoc_phep_ot = [];
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
                    maDonVi: this.thongTinNhomBaoCao.donViList,
                    capHoc: this.thongTinNhomBaoCao.capHocList,
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
                const loadingGetDonVi = this.$loading({
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
                    loadingGetDonVi.close();
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
                    }
                    this.getTruongHoc();
                });
            },
            ThemNhomBaoCao() {
                let params = {
                    "reqData": this.thongTinNhomBaoCao
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
                        rest_api.post("/csdlgd-analytic-api/nhomBc/updateBc", params, (
                            data) => {
                            loading.close()
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.thongBao('success', 'Chỉnh sửa thông tin thành công')
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
                this.hien_thi = false;
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
    .el-dialog__body{
        height:calc(100vh - 120)
    }
</style>

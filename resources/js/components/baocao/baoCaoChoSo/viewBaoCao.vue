<template>
    <div id="modal_thong_tin" ref="modal_thong_tin" class="modal fade">
        <div class="modal-dialog-fullscreen">
            <div class="modal-content-fullscreen">
                <div class="modal-header-fullscreen">
                    <h5 class="modal-title text-uppercase">{{ten}}</h5>
                </div>
                <div class="modal-body-fullscreen">
                    <div class="row" style="display:flex">
                        <div class="col-md-4">
                            <label for="">Chọn đơn vị </label>
                            <eselect style="width:100%" multiple collapseTags v-model="donVi"
                                :disabled="thongtin.role>3" @change="chonDonVi" :placeholder="'Chọn'" filterable
                                :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                        </div>
                        <div class="col-md-3">
                            <label for="">Chọn trường học </label>
                            <eselect style="width:100%" multiple collapseTags :disabled="thongtin.role==5" v-model="truongHoc"
                                :placeholder="'Chọn trương học'" filterable :data="ds_truong_hoc"
                                :fields="['name','value']" />
                        </div>
                        <div class="col-md-3" v-if="caphoc==4||caphoc==5">
                            <label for="">Nhóm cấp học</label>
                            <eselect style="width:100%" multiple collapseTags v-model="nhomTreMamNon"
                                :placeholder="'Chọn'" filterable :data="nhom_tre_doc_lap" :fields="['name','value']" />
                        </div>
                        <div class="col-md-3" style="width:10% !important">
                            <label for="">Năm học <sup style="color:#DC0101">*</sup></label>
                            <el-select v-model="namHoc" filterable collapse-tags placeholder="Select"
                                v-validate="{ required: true }" name="nam_hoc">
                                <el-option v-for="item in list_nam_hoc" :key="item.id" :label="item.name"
                                    :value="item.id">
                                </el-option>
                            </el-select>
                            <span v-if="show_msg"><span class="text-danger"
                                    v-show="errors.has('nam_hoc')">{{ errors.first('nam_hoc') }}</span></span>
                        </div>
                        <div class="col-md-2" style="width:10% !important" v-if="canhocky">
                            <label for="">Học kỳ <sup style="color:#DC0101">*</sup></label>
                            <el-select v-model="hocKy" filterable placeholder="Chọn học kỳ"
                                v-validate="{ required: true }" name="hoc_ky">
                                <el-option v-for="item in list_hoc_ky" :key="item.id" :label="item.name"
                                    :value="item.id">
                                </el-option>
                            </el-select>
                            <span v-if="show_msg"><span class="text-danger"
                                    v-show="errors.has('hoc_ky')">{{ errors.first('hoc_ky') }}</span></span>
                        </div>
                    </div>
                    <div class="row" style="padding-top:15px;">
                        <div class="col-md-12 text-center">
                            <el-button type="primary" @click.prevent="themTruongHocSubmit" size="mini">Xem báo cáo
                            </el-button>
                            <el-button @click.prevent="TaiBaoCao" :disabled="!taiXuong" type="success" size="mini">Tải
                                xuống
                            </el-button>
                        </div>
                    </div>
                    <div class="row" style="padding-top:15px;">
                        <div class="col-md-12" v-if="taiXuong">
                            <div id="editor" ref="editor"></div>
                            <div id="iframe-wrapper" :style="iframe.wrapperStyle">
                                <iframe :src="iframe.src" :style="iframe.style" :height="iframe.style.height"
                                    :width="iframe.style.width" type="application/pdf" frameborder="0"></iframe>
                            </div>
                        </div>
                        <div class="col-md-12" v-else>
                            <div
                                style="width:100%;height:75vh !important;text-align:center;background:#F2F2F2;border-radius:6px;padding-top:6%;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-fullscreen">
                    <button type="default" size="mini" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import rest_api from "../../../utils/rest_api";
    import constant from "../../../utils/constant";
    // import ESelectVue from '../../../ui/ESelect.vue';
    import ESelectVue from '../../ui/ESelect.vue';
    import VueAlertify from "vue-alertify";
    import VeeValidate, {
        Validator
    } from 'vee-validate';
    Vue.use(VeeValidate);
    Vue.use(ElementUI);
    Vue.use(VueAlertify, {

        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
    $(document).ready(function () {});
    export default {
        props: [
            'ten', 'cln', 'caphoc', 'namhientai', 'canhocky', 'item'
        ],
        watch: {
            item: function (newVal) {
                console.log("newVal" + newVal)
                if (newVal) {
                    this.taiXuong = false;
                    this.linkExcel = "";
                    $("#modal_thong_tin").modal();
                } else {

                    $(this.$refs.modal_thong_tin).on("hidden.bs.modal", this.close);
                }
            },
            caphoc: function (newVal) {
                if (newVal) {
                    // this.truongHoc = [];
                    this.nhomTreMamNon = [];
                    this.ds_truong_hoc = []
                    // this.donVi = [];
                    this.mapDuLieuSanCo();
                    this.getTruongHoc();
                } else {

                }
            },
        },
        components: {
            'eselect': ESelectVue,
        },
        data() {
            return {
                baseLink: "/view-excel?path=",
                linkExcel: "",
                linkDowndLoad: "",
                hocKy: "",
                taiXuong: false,
                thongtin: JSON.parse(window.userInfo),
                truongHoc: [],
                date: new Date(),
                donVi: [],
                namHoc: "",
                namHocHienTai: "",
                list_don_vi: [],
                ds_truong_hoc: [],
                nhomTreMamNon: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_hoc_ky: constant.LIST_HOC_KY,
                nhom_tre_doc_lap: constant.NHOM_TRE_DOC_LAP,
                show_msg: false,

                loaded: false,
                iframe: {
                    src: "",
                    style: null,
                    wrapperStyle: null,
                }
            }
        },
        mounted: function () {
            this.customMessage();
            this.getDonVi()
            this.bindNamHoc();
            console.log('THông tin đăng nhập:')
            console.log(this.thongtin)
            $(this.$refs.modal_thong_tin).on("hidden.bs.modal", this.close);

            let editor = this.$refs.editor;
            this.iframe.style = {
                position: 'absolute',
                width: window.innerWidth,
                height: window.innerHeight,
                top: 0 + "px",
                left: 0 + "px",
            }
            this.iframe.wrapperStyle = {
                overflow: 'hidden',
                height: 0 + "px",
                width: 0 + "px",
            }
            console.log(this.iframe)
            console.log("***")
        },
        methods: {
            mapDuLieuSanCo(){
            if (this.thongtin.role > 3) {
                let dv = this.thongtin.ma_don_vi.toString()
                this.donVi = [dv];
                if (this.thongtin.role == 5) {
                    let th = this.thongtin.ma_truong_hoc.toString();
                    this.truongHoc = [th]
                }
            }
            },
            TaiBaoCao() {
                // window.location.href = this.linkDowndLoad;
                console.log('****');
                console.log(this.linkDowndLoad);
                window.open(this.linkDowndLoad, '_blank');
            },
            themTruongHocSubmit() {
                this.show_msg = true;
                this
                    .$validator
                    .validateAll()
                    .then(result => {
                        if (result) {
                            this.getDataBaoCao();
                        }
                    });
            },
            getDataBaoCao() {
                this.linkExcel = "";
                this.linkDowndLoad = "";
                this.taiXuong = false;
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    "capHoc": this.caphoc,
                    "namHoc": this.namHoc,
                    "collectionName": this.cln,
                    "maTruongs": this.truongHoc,
                    "maDonVis": this.donVi
                };
                if (this.canhocky) {
                    params.hocKy = parseInt(this.hocKy);
                }
                if (this.caphoc == 4 || this.caphoc == 5) {
                    params.maNhomCapHocs = this.nhomTreMamNon;
                }
                this.iframe.src = "";
                rest_api.post("/csdlgd-report-api/download-excel/get-report-link/", params, (data) => {

                    console.log("thông tin trả về:" + JSON.stringify(data.data));
                    if (data.data.rc == 0) {

                        setTimeout(() => {
                            loading.close();
                        }, 5000);
                        this.taiXuong = true;
                        this.iframe.src = this.baseLink + this.thongtin.tenMien + data.data.urlContext;
                        console.log('link frame:')
                        console.log(this.iframe.src)
                        this.linkDowndLoad = this.thongtin.tenMien + data.data.urlContext;
                    } else {
                        loading.close();
                        this
                            .$alertify
                            .success("Báo cáo đang trong quá trình tổng hợp. Vui lòng thử lại sau.")
                    }
                });
            },
            bindNamHoc() {
                this.namHocHienTai = this
                    .date
                    .getFullYear();
                let thangNay = this
                    .date
                    .getMonth();
                thangNay = parseInt(thangNay) + 1;
                if (thangNay > 8) {
                    console.log("tháng > 8");
                } else {
                    this.namHocHienTai -= 1;
                    console.log("tháng không lớn hơn 8");
                }
                console.log(this.namHocHienTai);
                console.log(this.list_nam_hoc);
                for (let i = 0; i < this.list_nam_hoc.length; i++) {
                    if (this.list_nam_hoc[i].id == this.namHocHienTai) {
                        this.namHoc = this.list_nam_hoc[i].id;
                    }
                }
            },
            chonDonVi() {
                this.ds_truong_hoc = [];
                this.truongHoc = [];
                this.getTruongHoc();
            },
            customMessage() {
                const dict = {
                    custom: {
                        don_vi: {
                            required: () => 'Đơn vị không thể trống'
                        },
                        cap_hoc: {
                            required: () => 'Cấp học không thể trống'
                        },
                        truong_hoc: {
                            required: () => 'Trường học không thể trống'
                        },
                        nam_hoc: {
                            required: () => 'Năm học không thể trống'
                        },
                        hoc_ky: {
                            required: () => 'Học kỳ không thể trống'
                        },
                        nhom_tre_doc_lap: {
                            required: () => 'Nhóm trẻ mầm non không thể trống'
                        },
                    }
                };
                this
                    .$validator
                    .localize('vi', dict);
            },

            getTruongHoc() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    capHoc: [],
                    maDonVi: this.donVi,
                };
                if(this.caphoc&&this.caphoc!=''){
                    params.capHoc = [this.caphoc];
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
                        this.ds_truong_hoc = data_demo;
                    }
                });
            },
            getDonVi() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    // loading.close();
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
                        this.getTruongHoc();
                    } else {
                        this
                            .$alertify
                            .error("Có lỗi sảy ra trong quá trình lấy đơn vị quản lý. Vui lòng thử lại sau.")
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
    /*  */

    .row {
        margin: 0;
    }

</style>

<template>
<div>

    <div id="BcCanBoTheoCoCau" ref="BcCanBoTheoCoCau" class="modal fade">
        <!-- Nội dung báo cáo -->
        <div class="modal-dialog" style="width: 100%; height:50vh; margin: 0 auto !important;">
            <div class="modal-content">
                <!-- Nội dung header -->
                <div class="modal-header" style="position: relative">
                    <button
                        type="button"
                        class="close btn btn-danger"
                        style="position: absolute; top: 2px; right: 2px;"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="close()">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>{{tenBaoCao}}</h3>
                        </div>
                    </div>
                </div>
                <!-- Hết nội dung header + bắt đầu thân -->
                <div class="modal-body clearfix">
                    <div class="row">
                        <div v-if="this.thongtin.role!=5" class="col-md-4 timkiem">
                            <label class="typo__label">Chọn đơn vị</label>
                            <div v-if="thongtin.role!=5">
                                <div v-if="this.thongtin.role==2||this.thongtin.role==3">
                                    <multiselect
                                        v-model="danhSachDonVi"
                                        :options="list_don_vi"
                                        :multiple="true"
                                        @close="ChonDonVi()"
                                        :close-on-select="false"
                                        :clear-on-select="false"
                                        :preserve-search="false"
                                        deselectLabel="Đã chọn"
                                        selectLabel="Chưa chọn"
                                        selectedLabel="Đã chọn"
                                        :custom-label="setNameDonVi"
                                        placeholder="Chọn đơn vị"
                                        label="maDonVi"
                                        track-by="tenDonVi"
                                        :preselect-first="true">
                                        <template
                                            v-if="danhSachDonVi.length>1"
                                            slot="selection"
                                            slot-scope="{ values, search, isOpen }">
                                            <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }}
                                                đơn vị được chọn</span>
                                        </template>
                                    </multiselect>
                                </div>
                                <div v-else="v-else">
                                    <input
                                        class="form-control"
                                        type="text"
                                        :value="thongtin.display_name"
                                        disabled="disabled"/>
                                </div>
                            </div>
                            <div v-if="thongtin.role==5">
                                <input
                                    :disabled="thongtin.role == 5"
                                    class="form-control"
                                    placeholder="Nhập..."/>
                            </div>
                            <!-- <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> -->
                        </div>
                        <div class="col-md-3 timkiem">
                            <label class="typo__label">Chọn trường học</label>
                            <div v-if="thongtin.role!=5">
                                <multiselect
                                    v-model="danhSachTruongHoc"
                                    :options="list_truong_hoc"
                                    :multiple="true"
                                    @close="ChonTruongHoc()"
                                    :close-on-select="false"
                                    :clear-on-select="false"
                                    :preserve-search="false"
                                    deselectLabel="Đã chọn"
                                    selectLabel="Chưa chọn"
                                    selectedLabel="Đã chọn"
                                    :custom-label="setNameTruongHoc"
                                    placeholder="Chọn trường học"
                                    label="maTruongHoc"
                                    track-by="tenTruongHoc"
                                    :preselect-first="true">
                                    <template
                                        v-if="danhSachTruongHoc.length>1"
                                        slot="selection"
                                        slot-scope="{ values, search, isOpen }">
                                        <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }}
                                            trường học được chọn</span>
                                    </template>
                                </multiselect>
                            </div>
                            <div v-if="thongtin.role==5">
                                <input
                                    :disabled="thongtin.role == 5"
                                    class="form-control"
                                    :value="this.thongtin.display_name"
                                    placeholder="Nhập..."/>
                            </div>
                            <!-- <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> -->
                        </div>
                        <div class="col-md-2 timkiem">
                            <label class="typo__label">Năm học</label>
                            <multiselect
                                v-model="danhSachNamHoc"
                                :options="list_nam_hoc"
                                @close="ChonNamHoc()"
                                :custom-label="setNameNamHoc"
                                placeholder="Chọn năm học"
                                label="name"
                                deselectLabel="Đã chọn"
                                selectLabel="Chưa chọn"
                                selectedLabel="Đã chọn"
                                track-by="name"></multiselect>
                        </div>
                        <div class="col-md-3">
                            <div class="baoButton">
                                <button @click.prevent="getData2" class="btn btn-success">Xem trước file</button>
                                <button @click.prevent="exPort" class="btn btn-info">Tải xuống</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="col-md-12">
                            <button
                                class="btn btn-default"
                                type="button"
                                data-dismiss="modal"
                                aria-hidden="true"
                                v-on:click="close()">Đóng</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hết nội dung báo cáo -->
    </div>
        <popup-limit :show="show_chose" @close="show_chose=false" @getExcel="getData" @taiXuong="exPort" @getExcel2="getData2" @getPfd="exPortPDF"></popup-limit>
</div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../../utils/rest_api';
    import array_util from '../../../utils/array_utils';
    import constant from "../../../utils/constant";
    import utils from '../../../utils';
    import dialog from '../../../utils/dialog';
    import api from './../../api';
    import VueAlertify from "vue-alertify";
    import PopupExportLimit from "./PopupChoseExportData";
    Vue.use(VueAlertify, {
        notifier: {
            delay: 2,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
    export default {
        props: [
            'ten', 'tenbaocao', 'item', 'namhientai'
        ],
        watch: {},
        components: {
            Multiselect,
            'popup-limit': PopupExportLimit,
        },
        data() {
            return {
                thongtin: {},
                linkiframe:"",
                linkExcel:"",
                linkPdf: '',
                show_chose: false,
                tenBaoCao: '',
                pdf: false,
                collectionName: '',
                capHoc: '',
                nam_hoc: '',
                TieuDe: '',
                Report: [],
                list_don_vi: [],
                list_truong_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                danhSachDonVi: [],
                danhSachTruongHoc: [],
                danhSachNamHoc: [],
                ds_don_vi: [],
                ds_truong_hoc: []
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            $("#BcCanBoTheoCoCau").modal();
            $(this.$refs.BcCanBoTheoCoCau).on("hidden.bs.modal", this.close);
            this.bindDuLieu();
            this.nam_hoc = this.namhientai;
            this.findNamHoc();
            this.getDonVi();
            if (this.thongtin.role == 5) {
                this.ds_truong_hoc = [this.thongtin.ma_truong_hoc];
                console.log("đăng nhập là trường");
            }
        },

        methods: {
            beforeGetData(){
                this.show_chose = true;
            },
            // Xuất pdf
            exPortPDF() {
                let url = "xuat-bao-cao-pdf";
                if (this.thongtin.role == 5) {
                    this.ds_truong_hoc = [this.thongtin.ma_truong_hoc]
                }
                let params = {
                    "capHoc": this.capHoc,
                    "namHoc": this.nam_hoc,
                    "collectionName": this.collectionName,
                    "maTruongs": this.ds_truong_hoc,
                    "maDonVis": this.ds_don_vi
                };
                this
                    .$alertify
                    .success("Đang lấy dữ liệu... Vui lòng chờ...")
                api.post(url, params, (data) => {
                    if (data.data.rc == -1) {
                        this.linkPdf = data.data.file;
                    window.open(this.linkPdf, "_blank");
                        this.pdf = true;
                    }
                    console.log("Xuất pfd trả về:" + this.linkPdf);
                });
            },
            // Xuất excel
            exPort() {
                this.CheckDuLieu();
                let url = "xuat-excel";
                if (this.thongtin.role == 5) {
                    this.ds_truong_hoc = [this.thongtin.ma_truong_hoc]
                }
                let params = {
                    "capHoc": this.capHoc,
                    "namHoc": this.nam_hoc,
                    "collectionName": this.collectionName,
                    "maTruongs": this.ds_truong_hoc,
                    "maDonVis": this.ds_don_vi
                };
                dialog.confirmDialog(
                    "Xác nhận tải xuống dữ liệu? Vui lòng chờ trong thời gian tải xuống.",
                    "Xác nhận",
                    () => {
                        api.post(url, params, (data) => {
                            let a = document.createElement('a');
                            a.href = data.data.file;
                            document
                                .body
                                .appendChild(a);
                            a.click();
                            document
                                .body
                                .removeChild(a);
                        });
                    }
                );

            },
            // Check dữ liệu
            CheckDuLieu() {
                if (this.thongtin.role != 5) {
                    if (this.danhSachDonVi.length == 0) {
                        this.ds_don_vi = [];
                    }
                    if (this.danhSachTruongHoc.length == 0) {
                        this.ds_truong_hoc = [];
                    }
                }

            },
            // Lấy dữ liệu
            getData() {
                this.pdf = false;
                this.CheckDuLieu();
                this.TieuDe = "";
                this.Report = [];
                this
                    .$alertify
                    .success("Đang lấy dữ liệu... Vui lòng chờ...")
                let params = {
                    "capHoc": this.capHoc,
                    "namHoc": this.nam_hoc,
                    "collectionName": this.collectionName,
                    "maTruongs": this.ds_truong_hoc,
                    "maDonVis": this.ds_don_vi
                };
                rest_api.post("/csdlgd-report-api/download-excel/get-report-link/", params, (data) => {
                    console.log("thông tin trả về:" + JSON.stringify(data.data));
                    this.linkExcel = data.data.urlContext;
                    this.linkExcel = this.thongtin.tenMien+this.linkExcel;
                    this.linkiframe = "/view-excel?path=" + this.linkExcel;
                    console.log("link excel = " + this.linkiframe)
                    window.open(this.linkiframe, "_blank");
                    return;
                    if (data.data.rc === 0) {
                        this.TieuDe = data.data;
                        if (!this.TieuDe.namHoc) {
                            this.TieuDe.namHoc = this.namhientai;
                        }
                        this.Report = data.data.reportData;
                        if (this.Report.length == 0) {
                            this
                                .$alertify
                                .error("Không có bản ghi nào được tìm thấy")

                        } else {
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công")
                        }
                    } else {
                        this
                            .$alertify
                            .error("Vui lòng thử lại...")
                    }

                });
            },
            // Lấy dữ liệu
            getData2() {
                this.pdf = false;
                this.CheckDuLieu();
                this.TieuDe = "";
                this.Report = [];
                this
                    .$alertify
                    .success("Đang lấy dữ liệu... Vui lòng chờ...")
                let params = {
                    "capHoc": this.capHoc,
                    "namHoc": this.nam_hoc,
                    "collectionName": this.collectionName,
                    "maTruongs": this.ds_truong_hoc,
                    "maDonVis": this.ds_don_vi
                };
                rest_api.post("/csdlgd-report-api/download-excel/get-report-link/", params, (data) => {
                    console.log("thông tin trả về:" + JSON.stringify(data.data));
                    this.linkExcel = data.data.urlContext;
                    this.linkExcel = this.thongtin.tenMien+this.linkExcel;
                    this.linkiframe = "/view-excel?path=" + this.linkExcel;
                    console.log("link excel = " + this.linkiframe)
                    window.open(this.linkiframe, "_blank");
                    return;
                    if (data.data.rc === 0) {
                        this.TieuDe = data.data;
                        if (!this.TieuDe.namHoc) {
                            this.TieuDe.namHoc = this.namhientai;
                        }
                        this.Report = data.data.reportData;
                        if (this.Report.length == 0) {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy")

                        } else {
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công")
                        }
                    } else {
                        this
                            .$alertify
                            .error("Vui lòng thử lại...")
                    }

                });
            },
            // Chọn đơn vị
            ChonDonVi() {
                console.log("chọn đơn vị");
                console.log(JSON.stringify(this.danhSachDonVi));
                this.ds_don_vi = [];
                this.list_truong_hoc = [];
                this.ds_truong_hoc = [];
                this.danhSachTruongHoc = [];
                if (this.danhSachDonVi) {
                    let lsdv = this
                        .danhSachDonVi
                        .map((obj) => {
                            return obj['maDonVi']
                        });
                    this.ds_don_vi = lsdv;
                    console.log("danh sách đơn vị:" + JSON.stringify(this.ds_don_vi));
                    this.getTruongHoc();
                }
            },
            // Gán năm học
            findNamHoc() {
                console.log("gán Năm học" + this.namhientai);
                this.nam_hoc = this.namhientai
                for (let i = 0; i < this.list_nam_hoc.length; i++) {
                    if (this.list_nam_hoc[i].id == this.namhientai) {
                        this.danhSachNamHoc = this.list_nam_hoc[i];
                    }
                }
            },
            // Chọn trường học
            ChonTruongHoc() {
                console.log("chọn trường học");
                console.log(JSON.stringify(this.danhSachTruongHoc));
                this.ds_truong_hoc = [];
                if (this.danhSachTruongHoc) {
                    let lsth = this
                        .danhSachTruongHoc
                        .map((obj) => {
                            return obj['maTruongHoc']
                        });
                    this.ds_truong_hoc = lsth;
                    console.log("danh sách trường học:" + JSON.stringify(this.ds_truong_hoc));
                }
            },
            // Chọn năm học
            ChonNamHoc() {
                console.log("chọn trường học");
                console.log(JSON.stringify(this.danhSachNamHoc));
                this.nam_hoc = '';
                if (this.danhSachNamHoc) {
                    this.nam_hoc = this.danhSachNamHoc.id;
                }
                console.log("Năm học" + this.nam_hoc);
            },
            // Lấy danh sách đơn vị
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.province
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        this.list_don_vi = data.data.rows;
                        if (this.thongtin.role == 4) {
                            this.danhSachDonVi = this.list_don_vi;
                            this.ds_don_vi = [
                                this
                                    .list_don_vi[0]
                                    .maDonVi
                            ];
                        }
                        console.log("Danh sách đơn vị:" + JSON.stringify(this.danhSachDonVi));
                        this.getTruongHoc();
                    }

                });
            },
            // Lấy trường học
            getTruongHoc() {
                array_util.clearArrays(this.list_truong_hoc);
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: [this.capHoc]
                };
                if (this.danhSachDonVi.length == 0) {
                    params.maDonVi = [];
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    if (data.data != null) {
                        if (data.data.code == 200) {
                            array_util.clearArrays(this.list_truong_hoc);
                            this.list_truong_hoc = data.data.rows;
                        }
                    }
                });
            },
            // Gán dữ liệu
            bindDuLieu() {
                this.tenBaoCao = this.ten;
                this.collectionName = this.tenbaocao;
                this.capHoc = this.item;
            },

            // định nghĩa cho đơn vị
            setNameDonVi({tenDonVi, maDonVi}) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // định nghĩa cho trường
            setNameTruongHoc({tenTruongHoc, maTruongHoc}) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            // định nghĩa cho cấp học
            setNameCapHoc({name}) {
                return `${name}`
            },
            // định nghĩa cho năm học
            setNameNamHoc({name}) {
                return `${name}`
            },
            close() {
                this.$emit('close')
            }
        }
    }
</script>
<style scoped="scoped">
    @import "../../../../../node_modules/selectwithsearch.css";

    a,
    h2,
    h3,
    h4,
    h5,
    h6,
    hr h1,
    label,
    p,
    span {
        padding: 0 !important;
        margin: 0 !important;
    }

    .red {
        color: #DC0101;
    }

    .cg {
        vertical-align: middle;
    }

    .noidung {
        height: 400px;
        overflow-x: scroll;
    }

    .noidung th,
    td {
        border: 1px solid black !important;
    }
    .vh {
        text-transform: uppercase;
    }
    .qh,
    .tn {
        font-size: 10pt;
    }
    .baoButton {
        padding-top: 18px;
    }
    .baoButton > button {
        padding: 4px 0;
        width:39%;
    }
    .baoButton > button {
        padding: 4px 0;
        width:39%;
    }
    .baoButton2 > button {
        padding: 3px 15px;
    }
</style>

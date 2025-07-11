<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> BÁO CÁO <span class="kytu">
                        &raquo;</span> BÁO CÁO ĐỘNG</span>
            </div>
        </div>
        <div class="row">
            <div></div>
        </div>
        <div class="row" style="">
            <MultiSplitPane split="horizontal" height="600px" width="100%" resizerWidth="10px" :nested="true"
                classes="v-pane-custom" @onPaneCollapsed="onPaneCollapsed" @onPaneExpanded="onPaneExpanded">
                <Pane>
                    <template v-slot:content>
                        <div class="bd" style="width:100%;height:100%">
                            <v-jstree :data="listReport">
                                <template slot-scope="_">
                                    <div style="display: inherit" @click="ChonBaoCao(_.vm, _.model, $event)">
                                        <i :class="_.vm.themeIconClasses" role="presentation" v-if="_.model.menu"></i>
                                        <i style="padding-left:4px" class="far fa-file" role="presentation"
                                            v-if="!_.model.menu"></i>
                                        {{_.model.text}}
                                        <button class="btn btn-danger"
                                            v-if="_.model.treeLeve!=1&&_.model.children==null"
                                            style="height:21px; padding:0px 5px; margin-left:10px;"
                                            @click="DeletaReport(_.vm, _.model, $event)">Xóa</button>
                                    </div>
                                </template>
                            </v-jstree>
                        </div>
                    </template>
                </Pane>
                <Pane>
                    <template v-slot:content>
                        <div class="bd" style="width:100%;height:100%">
                            <p>Nội dung phần hiển thị</p>
                        </div>
                    </template>
                </Pane>
            </MultiSplitPane>
        </div>
        <div v-if="show_upload">
            <Import @close="show_upload=false" @success="ganLink($event)"></Import>
        </div>
        <div v-if="show_xuat_bao_cao">
            <Export :item="idBaoCao" @close="show_xuat_bao_cao=false" @success="ganLink($event)"></Export>
        </div>
    </div>
</template>
<script>
    import {
        MultiSplitPane,
        Pane
    } from 'vue-multi-split-pane'
    import QueryBuilder from "query-builder-vue";
    import rest_api from "../../utils/rest_api";
    import api from './../api';
    import dialog from '../../utils/dialog';
    import Import from "./TieuChiBaoCao/fileImport.vue";
    import Export from "./TieuChiBaoCao/Export.vue";
    import VJstree from 'vue-jstree'
    import VueAlertify from "vue-alertify";
    import ElementUI from 'element-ui';
    import ESelectVue from '../ui/ESelect.vue';
    export default {
        components: {
            MultiSplitPane,
            Pane,
            VJstree,
            'eselect': ESelectVue,
            'Import': Import,
            'Export': Export,
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                list_cap_hoc_2: window.listCapHoc,
                listReport: [],
                baoCaoDaChon: {},
                baoCaoDaChonThem: {},
                filePath: "",
                idBaoCao: "",
                running: true,
                add_report: false,
                show_parent: false,
                show_child: false,
                show_info: 1,
                show_upload: false,
                show_xuat_bao_cao: false,
                list_don_vi: [],
                list_tags: [],
                ds_truong_hoc: [],
                ds_truong_hoc_them: [],
                ds_truong_hoc_2: [],
                list_loai_bao_cao: [{
                    name: "Báo cáo cộng dồn",
                    value: "1"
                }],
                noiDungBaoCao: {}
            };
        },
        mounted: function () {
            this.getReport();
            this.getDonVi();
            this.onPaneCollapsed();
            this.onPaneExpanded();
            this.getTruongHocThem();
        },
        methods: {
            getTieuChiHocSinh() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let url = "/csdlgd-analytic-api/criteria/search?skip=0&limit=9999"
                const params = {
                    "doiTuong": "HocSinh",
                    "maTieuChi": "",
                    "tenTieuChi": "",
                    "textSreach": "",
                    "tieuChiHeThong": null,
                };
                rest_api.post(url, params, response => {
                    let data_source = [];
                    if (response.data.rc === 0) {
                        data_source = response.data.rows;
                    } else {}
                    localStorage["danh_sach_tieu_chi_hoc_sinh"] = JSON.stringify(data_source);
                });
            },
            getTieuChiTruongHoc() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let url = "/csdlgd-analytic-api/criteria/search?skip=0&limit=9999"
                const params = {
                    "doiTuong": "TruongHoc",
                    "maTieuChi": "",
                    "tenTieuChi": "",
                    "textSreach": "",
                    "tieuChiHeThong": null,
                };
                rest_api.post(url, params, response => {
                    let data_source = [];
                    if (response.data.rc === 0) {
                        data_source = response.data.rows;
                    } else {}
                    localStorage["danh_sach_tieu_chi_truong_hoc"] = JSON.stringify(data_source);
                });
            },
            getTieuChiKqht() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let url = "/csdlgd-analytic-api/criteria/search?skip=0&limit=9999"
                const params = {
                    "doiTuong": "KQHT",
                    "maTieuChi": "",
                    "tenTieuChi": "",
                    "textSreach": "",
                    "tieuChiHeThong": null,
                };
                rest_api.post(url, params, response => {
                    let data_source = [];
                    if (response.data.rc === 0) {
                        data_source = response.data.rows;
                    } else {}
                    localStorage["danh_sach_tieu_chi_ket_qua_hoc_tap"] = JSON.stringify(data_source);
                });
            },
            getTieuChiLopHoc() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let url = "/csdlgd-analytic-api/criteria/search?skip=0&limit=9999"
                const params = {
                    "doiTuong": "LopHoc",
                    "maTieuChi": "",
                    "tenTieuChi": "",
                    "textSreach": "",
                    "tieuChiHeThong": null,
                };
                rest_api.post(url, params, response => {
                    let data_source = [];
                    if (response.data.rc === 0) {
                        data_source = response.data.rows;
                    } else {}
                    localStorage["danh_sach_tieu_chi_lop_hoc"] = JSON.stringify(data_source);
                });
            },
            getTieuChiCanBo() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let url = "/csdlgd-analytic-api/criteria/search?skip=0&limit=9999"
                const params = {
                    "doiTuong": "GiaoVien",
                    "maTieuChi": "",
                    "tenTieuChi": "",
                    "textSreach": "",
                    "tieuChiHeThong": null,
                };
                rest_api.post(url, params, response => {
                    let data_source = [];
                    if (response.data.rc === 0) {
                        data_source = response.data.rows;
                    } else {}
                    localStorage["danh_sach_tieu_chi_can_bo_giao_vien"] = JSON.stringify(data_source);
                });
            },
            onPaneCollapsed(paneIndex, paneClass, containerClass) {
                console.log(
                    `${paneIndex}. pane collapsed. Pane class: '${paneClass}' MultiSplitPane class: '${containerClass}'`
                )
            },
            onPaneExpanded(paneIndex, paneClass, containerClass) {
                console.log(
                    `${paneIndex}. pane expanded. Pane class: '${paneClass}' MultiSplitPane class: '${containerClass}'`
                )
            },
            demo() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.getTieuChiCanBo();
                this.getTieuChiLopHoc();
                this.getTieuChiKqht();
                this.getTieuChiTruongHoc();
                this.getTieuChiHocSinh();
                console.log(this.idBaoCao);
                var idbc = this.idBaoCao;
                let params = {
                    "id": this.idBaoCao,
                };
                rest_api.get("/csdlgd-analytic-api/BcChiTiet/convertExcelFileToHtml", params, (data) => {
                    let dataHtml = data.data.item;
                    $.ajax({
                        url: '/submit-data-sso',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            dataHtml: dataHtml,
                        }
                    }).done(function (ketqua) {
                    loading.close();
                        let uri = '/analytic-template-edit?id=' + idbc;
                        window.open(uri);
                    });
                    console.log(dataHtml);
                });
            },
            ExportBaoCao() {
                console.log(this.idBaoCao);
                this.show_xuat_bao_cao = true;
            },
            ganLink(e) {
                this.filePath = e;
                console.log("gán xong e" + e);
                this
                    .$alertify
                    .success("Gán địa chỉ thành công")
            },
            showUploadFile() {
                this.show_upload = true;
                console.log("show_import");
            },
            addChildReport() {
                console.log("Thêm con");
                this.add_report = true;
                this.running = true;
                setTimeout(() => this.running = false, 3000);
            },
            SubmitAddChildReport() {
                let params = {
                    "dataReq": {
                        analyticReportGroupId: this.baoCaoDaChon.ma,
                        capHocList: this.noiDungBaoCao.capHocList,
                        description: this.noiDungBaoCao.description,
                        donViList: this.noiDungBaoCao.donViList,
                        maTruongList: this.noiDungBaoCao.maTruongList,
                        tags: this.noiDungBaoCao.tags,
                        name: this.noiDungBaoCao.name,
                        templateFile: this.filePath,
                        maSoList: [this.thongtin.ma_so],
                    }
                }
                // if (!params.dataReq.analyticReportGroupId || params.dataReq.capHocList.length == 0 || !params.dataReq
                //     .description || params.dataReq.donViList.length == 0 || params.dataReq.maTruongList.length == 0 || !
                //     params.dataReq
                //     .tags || !params.dataReq.name || !params.dataReq.templateFile) {
                //     this
                //         .$alertify
                //         .error("Vui lòng bổ sung thông tin bắt buộc");
                //     return
                // }
                console.log(JSON.stringify(params));
                dialog.confirmDialog("Xác nhận thêm thông tin báo cáo?", "Đồng ý", () => {
                    rest_api.post("/csdlgd-analytic-api/BcChiTiet/createBc", params, (
                        data) => {
                        console.log(JSON.stringify(data));
                        if (data.data.rc == 0) {
                            this
                                .$alertify
                                .success("Thêm dữ liệu báo cáo thành công");
                            this.getReport();
                        } else {
                            this
                                .$alertify
                                .error(data.rd);
                        }
                    });
                });
            },
            SubmitUpdateChildReport() {
                let params = {
                    "dataReq": {
                        analyticReportGroupId: this.noiDungBaoCao.analyticReportGroupId,
                        capHocList: this.noiDungBaoCao.capHocList,
                        description: this.noiDungBaoCao.description,
                        donViList: this.noiDungBaoCao.donViList,
                        maTruongList: this.noiDungBaoCao.maTruongList,
                        tags: this.noiDungBaoCao.tags,
                        ma: this.noiDungBaoCao.ma,
                        name: this.noiDungBaoCao.name,
                        templateFile: this.filePath,
                        maSoList: [this.thongtin.ma_so],
                    }
                }
                // if (!params.dataReq.analyticReportGroupId || params.dataReq.capHocList.length == 0 || !params.dataReq
                //     .description || params.dataReq.donViList.length == 0 || params.dataReq.maTruongList.length == 0 || !
                //     params.dataReq.tags || !params.dataReq.name || !params.dataReq.templateFile) {
                //     this
                //         .$alertify
                //         .error("Vui lòng bổ sung thông tin bắt buộc");
                //     return
                // }
                dialog.confirmDialog("Xác nhận chỉnh sửa thông tin báo cáo?", "Đồng ý", () => {
                    rest_api.post("/csdlgd-analytic-api/BcChiTiet/updateBc", params, (
                        data) => {
                        console.log(JSON.stringify(data));
                        if (data.data.rc == 0) {
                            this
                                .$alertify
                                .success("Chỉnh sửa dữ liệu báo cáo thành công");
                            this.getReport();
                        } else {
                            this
                                .$alertify
                                .error(data.rd);
                        }
                    });
                });
            },
            themNhomCon() {
                this.show_info = 3;
                setTimeout(() => this.show_info = 2, 500);
            },
            addChildGroup() {
                let params = {
                    "reqData": {
                        capHocList: this.baoCaoDaChonThem.capHocList,
                        donViList: this.baoCaoDaChonThem.donViList,
                        groupName: this.baoCaoDaChonThem.groupName,
                        maTruongList: this.baoCaoDaChonThem.maTruongList,
                        parentId: this.baoCaoDaChon.ma,
                        treeLevel: this.baoCaoDaChon.treeLevel + 1,
                        maSoList: [this.thongtin.ma_so],
                    }
                }
                // if (params.reqData.capHocList.length == 0 || params.reqData.donViList.length == 0 || params.reqData
                //     .maTruongList.length == 0 || !params.reqData.groupName) {
                //     this
                //         .$alertify
                //         .error("Vui lòng bổ sung thông tin bắt buộc");
                //     return
                // }
                dialog.confirmDialog("Xác nhận thêm thông tin báo cáo?", "Đồng ý", () => {
                    rest_api.post("/csdlgd-analytic-api/nhomBc/createBc", params, (
                        data) => {
                        console.log(JSON.stringify(data));
                        if (data.data.rc == 0) {
                            this
                                .$alertify
                                .success("Thêm dữ liệu nhóm báo cáo thành công");
                            this.getReport();
                        } else {
                            this
                                .$alertify
                                .error(data.rd);
                        }
                    });
                });
            },
            update() {
                let params = {
                    "reqData": this.baoCaoDaChon
                }
                // if (params.reqData.capHocList.length == 0 || params.reqData.donViList.length == 0 || params.reqData
                //     .maTruongList.length == 0 || !params.reqData.groupName) {
                //     this
                //         .$alertify
                //         .error("Vui lòng bổ sung thông tin bắt buộc");
                //     return
                // }
                dialog.confirmDialog("Xác nhận chỉnh sửa thông tin báo cáo?", "Đồng ý", () => {
                    rest_api.post("/csdlgd-analytic-api/nhomBc/updateBc", params, (
                        data) => {
                        console.log(JSON.stringify(data));
                        if (data.data.rc == 0) {
                            this
                                .$alertify
                                .success("Chỉnh sửa dữ liệu thành công");
                            this.getReport();
                        } else {
                            this
                                .$alertify
                                .error(data.rd);
                        }
                    });
                });
            },
            exampleFunction() {
                console.log("demo thôi chứ biết làm clg đ");
            },
            DeletaReport(a, b, c) {
                console.log("xóa báo cáo");
                let dachon = b;
                console.log(dachon);
                if (dachon.menu) {
                    console.log("Xóa nhóm");
                    var url = "/csdlgd-analytic-api/nhomBc/deleteBc"
                } else {
                    console.log("Xóa con");
                    var url = "/csdlgd-analytic-api/BcChiTiet/deleteBcChiTiet"
                }
                console.log(url);
                let params = {
                    "id": dachon.value
                }
                dialog.confirmDialog("Xác nhận xóa dữ liệu của báo cáo này?", "Đồng ý", () => {
                    rest_api.post(url, params, (
                        data) => {
                        console.log(JSON.stringify(data));
                        if (data.data.rc == 0) {
                            this
                                .$alertify
                                .success("Xóa dữ liệu thành công");
                            this.getReport();
                        } else {
                            this
                                .$alertify
                                .error(data.rd);
                        }
                    });
                });
            },
            chonDonVi() {
                this.ds_truong_hoc = [];
                this.baoCaoDaChon.maTruongList = [];
                this.getTruongHoc();
            },
            chonCapHoc() {
                this.ds_truong_hoc = [];
                this.baoCaoDaChon.maTruongList = [];
                this.getTruongHoc();
            },
            dongChonDonVi(e) {
                console.log("Đóng chọn đơn vị");
                console.log(e);
            },
            chonDonViThem() {
                this.ds_truong_hoc_them = [];
                this.baoCaoDaChonThem.maTruongList = [];
                this.getTruongHocThem();
            },
            chonCapHocThem() {
                this.ds_truong_hoc_them = [];
                this.baoCaoDaChonThem.maTruongList = [];
                this.getTruongHocThem();
            },
            chonDonVi2() {
                this.ds_truong_hoc_2 = [];
                this.noiDungBaoCao.maTruongList = [];
                this.getTruongHoc2();
            },
            chonCapHoc2() {
                this.ds_truong_hoc_2 = [];
                this.noiDungBaoCao.maTruongList = [];
                this.getTruongHoc2();
            },
            getTruongHoc() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    maDonVi: this.baoCaoDaChon.donViList,
                    // maDonVi: [],
                    capHoc: this.baoCaoDaChon.capHocList,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    // console.log("lấy trường học công" + JSON.stringify(data));
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
            getTruongHocThem() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    maDonVi: this.baoCaoDaChonThem.donViList,
                    // maDonVi: [],
                    capHoc: this.baoCaoDaChonThem.capHocList,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    // console.log("lấy trường học công" + JSON.stringify(data));
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
                        this.ds_truong_hoc_them = data_demo;
                    }
                });
            },
            getTruongHoc2() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    maDonVi: this.noiDungBaoCao.donViList,
                    // maDonVi: [],
                    capHoc: this.noiDungBaoCao.capHocList,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    // console.log("lấy trường học công" + JSON.stringify(data));
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
                        this.ds_truong_hoc_2 = data_demo;
                    }
                });
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    // console.log("lấy đơn vị thành công" + JSON.stringify(data));
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
                });
            },
            getReport() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {}
                let url = "/csdlgd-analytic-api/quanLyNhomBc/getDanhSach?maSo=" + this.thongtin.ma_so;
                rest_api.post(url, params, (data) => {
                    loading.close();
                    if (data.data.rc == 0) {
                        this.listReport = data.data.item.children;
                    } else {}
                });
            },
            ChonBaoCao(a, b, c) {
                this.show_info = 1;
                this.add_report = false;
                this.running = false;
                let dachon = b;
                if (dachon.menu) {
                    console.log("gọi api lấy chi tiết cha");
                    this.getParentReportInfo(dachon.value);
                    this.idBaoCao = dachon.value;
                } else {
                    console.log("Gọi api lấy chi tiết con");
                    this.idBaoCao = dachon.value;
                    this.getReportInfo(dachon.value);
                }
            },
            getReportInfo(e) {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.idBaoCao = e;
                this.show_parent = false;
                this.show_child = true;
                let params = {
                    id: e
                }
                rest_api.get("/csdlgd-analytic-api/BcChiTiet/getBcChiTiet", params, (data) => {
                    loading.close();
                    if (data.data.rc == 0) {
                        console.log(JSON.stringify(data));
                        this.noiDungBaoCao = data.data.item;
                        this.filePath = this.noiDungBaoCao.templateFile;
                        console.log("^^^^^^^^");
                        console.log(JSON.stringify(this.noiDungBaoCao));
                        this.getTruongHoc2();
                    } else {}
                });
            },
            getParentReportInfo(e) {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.show_parent = true;
                this.show_child = false;
                let params = {
                    id: e
                }
                rest_api.get("/csdlgd-analytic-api/nhomBc/getBc", params, (data) => {
                    loading.close();
                    if (data.data.rc == 0) {
                        console.log(JSON.stringify(data));
                        this.baoCaoDaChon = data.data.item;
                        this.getTruongHoc();
                    } else {}
                });
            }
        },
    };
</script>
<style>
    .bd {
        border: 1px solid slategrey;
        height: 60vh;
        overflow-y: scroll;
    }
    .tree-default {
        /* overflow: inherit !important; */
        display: inline-block !important;
    }
    .v-pane .horizontal {
        /* width: calc((100% - 20px) * 1.5 + 10px) !important; */
    }
    .v-pane[data-v-b7f37b34] {
        display: contents;
        width: calc((100% - 20px) * 0.8 + 10px);
    }
</style>

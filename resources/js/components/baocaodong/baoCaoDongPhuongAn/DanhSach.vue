<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> BÁO CÁO <span class="kytu">
                        &raquo;</span> BÁO CÁO BIỂU MẪU ĐỘNG</span>
            </div>
        </div>
        <div class="row">
            <div></div>
        </div>
        <div class="row" style="">
            <MultiSplitPane split="horizontal" height="80vh" width="100%" resizerWidth="10px" :nested="true"
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
                                        <!-- <button class="btn btn-danger"
                                            v-if="_.model.treeLeve!=1&&_.model.children==null"
                                            style="height:21px; padding:0px 5px; margin-left:10px;"
                                            @click="DeletaReport(_.vm, _.model, $event)">Xóa</button> -->
                                    </div>
                                </template>
                            </v-jstree>
                        </div>
                    </template>
                </Pane>
                <Pane>
                    <template v-slot:content>
                        <div class="bd" style="width:100%;height:100%">
                            <div v-if="hien_thi_thong_tin_bao_cao||hien_thi_thong_tin_nhom_bao_cao">
                                <div v-if="hien_thi_thong_tin_nhom_bao_cao">
                                    <ThongTinNhomBaoCao @themThanhCong="themNhomConThanhCong"
                                        @XoaXongNhomBc="xoaBaoCaoThanhCong" @thembaocaothanhcong="themNhomConThanhCong"
                                        :item="idBaoCao">
                                    </ThongTinNhomBaoCao>
                                </div>
                                <div v-if="hien_thi_thong_tin_bao_cao">
                                    <ThongTinBaoCao @themThanhCong="themNhomConThanhCong"
                                        @xoaThanhCong="xoaBaoCaoThanhCong" @thembaocaothanhcong="themNhomConThanhCong"
                                        :item="idBaoCao"></ThongTinBaoCao>
                                </div>
                            </div>
                            <div v-else style="min-height:300px;text-align:center;padding-top:50px;">
                                <!-- <img style="width:100px" src="https://i.gifer.com/EhFI.gif" alt=""> -->
                                <div>
                                    <i class="el-icon-loading"></i>
                                    <p>
                                        <span></span>Vui lòng chọn báo cáo/nhóm báo cáo để xem chi tiết...</p>
                                </div>
                            </div>
                        </div>
                    </template>
                </Pane>
            </MultiSplitPane>
        </div>
    </div>
</template>
<script>
    import {
        MultiSplitPane,
        Pane
    } from 'vue-multi-split-pane'
    import rest_api from "../../../utils/rest_api";
    import VJstree from 'vue-jstree'
    import ThongTinNhomBaoCao from './ThongTinNhomBaoCao.vue';
    import ThongTinBaoCao from './ThongTinBaoCao.vue';
    export default {
        components: {
            MultiSplitPane,
            Pane,
            VJstree,
            'ThongTinNhomBaoCao': ThongTinNhomBaoCao,
            'ThongTinBaoCao': ThongTinBaoCao,
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                list_cap_hoc_2: window.listCapHoc,
                listReport: [],
                danh_sach_truong_hoc_full: [],
                danh_sach_don_vi_full: [],
                hien_thi_thong_tin_nhom_bao_cao: false,
                hien_thi_thong_tin_bao_cao: false,
                idBaoCao: "",
            };
        },
        mounted: function () {
            this.getReport();
            this.getFullDonVi();
            this.onPaneCollapsed();
            this.onPaneExpanded();
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
                        localStorage["danh_sach_don_vi_full"] = JSON.stringify(this.danh_sach_don_vi_full)
                        this.getFullTruongHoc();
                    } else {

                        this.danh_sach_don_vi_full = [];
                        localStorage["danh_sach_don_vi_full"] = JSON.stringify(this.danh_sach_don_vi_full)
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
                        localStorage["danh_sach_truong_hoc_full"] = JSON.stringify(this
                            .danh_sach_truong_hoc_full)
                    } else {
                        this.danh_sach_truong_hoc_full = [];
                        localStorage["danh_sach_truong_hoc_full"] = JSON.stringify(this
                            .danh_sach_truong_hoc_full)
                    }
                });
            },
            xoaBaoCaoThanhCong() {
                this.hien_thi_thong_tin_bao_cao = false;
                this.hien_thi_thong_tin_nhom_bao_cao = false;
                this.getReport();
            },
            themNhomConThanhCong() {
                this.getReport()
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
            getReport() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {}
                let url = "/csdlgd-analytic-api/quanLyNhomBc/getDanhSach?maSo=" + this.thongtin.ma_so;
                rest_api.post(url, params, (data) => {
                    loading.close();
                    if (data.data.rc == 0) {
                        this.listReport = data.data.item.children;
                        // this.thongBao('success', 'Lấy dữ liệu thành công');
                    } else {
                        this.thongBao('error', data.data.rd)
                    }
                });
            },
            ChonBaoCao(a, b, c) {
                let dachon = b;
                this.idBaoCao = "";
                // this.hien_thi_thong_tin_nhom_bao_cao = false;
                if (dachon.menu) {
                    console.log("gọi api lấy chi tiết cha");
                    this.idBaoCao = dachon.value;
                    this.hien_thi_thong_tin_nhom_bao_cao = true;
                    this.hien_thi_thong_tin_bao_cao = false;

                } else {
                    console.log("Gọi api lấy chi tiết con");
                    this.idBaoCao = dachon.value;
                    this.hien_thi_thong_tin_bao_cao = true;
                    this.hien_thi_thong_tin_nhom_bao_cao = false;
                }
            },
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


    .v-pane[data-v-b7f37b34] {
        display: contents;
        width: calc((100% - 20px) * 0.8 + 10px);
    }

</style>

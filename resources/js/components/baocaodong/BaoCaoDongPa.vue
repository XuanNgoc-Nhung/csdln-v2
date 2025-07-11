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
                                    <div style="display: inherit" @click="customItemClick1(_.vm, _.model, $event)">
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
                            <div v-if="Object.keys(baoCaoDaChon).length!=0||Object.keys(noiDungBaoCao).length!=0">
                                <div v-if="!add_report">
                                    <div v-if="show_parent">
                                        <div v-if="show_info==1">
                                            <div class="row" style="margin:20px 0">
                                                <div class="col-md-12">
                                                    <label>Tên nhóm báo cáo<span style="color:#DC0101;display:none">
                                                            *</span></label>
                                                    <el-input clearable placeholder="Nhập..." class=""
                                                        v-model="baoCaoDaChon.groupName">
                                                    </el-input>
                                                </div>
                                                <div class="col-md-12" style="margin:10px 0">
                                                    <label for="">Phân quyền:</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="typo__label">Chọn đơn vị <span
                                                            style="color:#DC0101;display:none">
                                                            *</span></label>
                                                    <eselect style="width:100%" multiple collapseTags
                                                        v-model="baoCaoDaChon.donViList" @change="chonDonVi"
                                                        :placeholder="'Chọn'" filterable :data="list_don_vi"
                                                        :fields="['tenDonVi','maDonVi']" />
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="typo__label">Chọn cấp học <span
                                                            style="color:#DC0101;display:none">
                                                            *</span></label>
                                                    <eselect style="width:100%" multiple collapseTags
                                                        v-model="baoCaoDaChon.capHocList" @change="chonCapHoc"
                                                        :placeholder="'Chọn'" filterable :data="list_cap_hoc_2"
                                                        :fields="['name','id']" />
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="typo__label">Chọn trường học <span
                                                            style="color:#DC0101;display:none">
                                                            *</span></label>
                                                    <eselect style="width:100%" multiple collapseTags
                                                        v-model="baoCaoDaChon.maTruongList"
                                                        :placeholder="'Chọn'" filterable
                                                        :data="ds_truong_hoc" :fields="['name','value']" />
                                                </div>
                                                <div class="col-md-12"
                                                    style="padding-top:10px; text-align:center;padding-top:30px;">
                                                    <button class="btn btn-primary"
                                                        v-on:click.prevent="themNhomCon()">Thêm nhóm
                                                        con</button>
                                                    <button class="btn btn-primary"
                                                        v-on:click.prevent="addChildReport()">Thêm báo
                                                        cáo</button>
                                                    <button class="btn btn-primary"
                                                        v-on:click.prevent="update()">Sửa</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else-if="show_info==2">
                                            <div class="row" style="margin:5px 0">
                                                <div class="col-md-12" style="padding-bottom:10px">
                                                    <span style="border-bottom:1px solid silver">THÊM NHÓM BÁO CÁO
                                                        CON</span>
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Tên nhóm báo cáo <span style="color:#DC0101;display:none">
                                                            *</span></label>
                                                    <el-input clearable placeholder="Nhập..." class=""
                                                        v-model="baoCaoDaChonThem.groupName">
                                                    </el-input>
                                                </div>
                                                <div class="col-md-12" style="margin:10px 0">
                                                    <label for="">Phân quyền:</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="typo__label">Chọn đơn vị <span
                                                            style="color:#DC0101;display:none">
                                                            *</span></label>
                                                    <eselect style="width:100%" multiple collapseTags
                                                        visible-change="dongChonDonVi"
                                                        v-model="baoCaoDaChonThem.donViList" @change="chonDonViThem"
                                                        :placeholder="'Chọn'" filterable :data="list_don_vi"
                                                        :fields="['tenDonVi','maDonVi']" />
                                                    <!-- <el-select v-model="baoCaoDaChonThem.donViList" multiple filterable collapseTags @change="chonDonViThem"
                                                         placeholder="Chọn đơn vị">
                                                        <el-option v-for="item in list_don_vi" :key="item.maDonVi"
                                                            :label="item.tenDonVi" :value="item.maDonVi">
                                                        </el-option>
                                                    </el-select> -->
                                                </div>
                                                <div class="col-md-2">
                                                    <label class="typo__label">Chọn cấp học <span
                                                            style="color:#DC0101;display:none">
                                                            *</span></label>
                                                    <eselect style="width:100%" multiple collapseTags
                                                        v-model="baoCaoDaChonThem.capHocList" @change="chonCapHocThem"
                                                        :placeholder="'Chọn'" filterable :data="list_cap_hoc_2"
                                                        :fields="['name','id']" />
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="typo__label">Chọn trường học <span
                                                            style="color:#DC0101;display:none">
                                                            *</span></label>
                                                    <eselect style="width:100%" multiple collapseTags
                                                        v-model="baoCaoDaChonThem.maTruongList"
                                                        :placeholder="'Chọn'" filterable
                                                        :data="ds_truong_hoc_them" :fields="['name','value']" />
                                                </div>
                                                <div class="col-md-12"
                                                    style="padding-top:10px; text-align:center;padding-top:30px;">
                                                    <button class="btn btn-primary"
                                                        v-on:click.prevent="addChildGroup()">Thêm</button>
                                                    <button class="btn btn-default"
                                                        v-on:click.prevent="show_info=1">Quay
                                                        lại</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else class="text-center" style="margin:40px;">
                                            <img style="width:100px" src="https://i.gifer.com/Y3il.gif" alt="">
                                            <p>Vui lòng đợi trong giây lát...</p>
                                        </div>
                                    </div>
                                    <div v-if="show_child">
                                        <div class="row" style="padding:0 15px">
                                            <div class="col-md-6">
                                                <label>Tên báo cáo <span style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <el-input clearable placeholder="Nhập..." class="" v-model="noiDungBaoCao.name">
                                                </el-input>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Mô tả <span style="color:#DC0101;display:none"> *</span></label>
                                                <el-input clearable placeholder="Nhập..." class=""
                                                    v-model="noiDungBaoCao.description">
                                                </el-input>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="">Địa chỉ file biểu mẫu <span
                                                        style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <el-input clearable placeholder="Please input" v-model="filePath"
                                                    class="input-with-select">
                                                    <el-button plain type="success" slot="append" @click="showUploadFile">
                                                        upload file
                                                    </el-button>
                                                </el-input>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Thẻ <span style="color:#DC0101;display:none"> *</span></label>
                                                <el-select v-model="noiDungBaoCao.tags" multiple filterable allow-create
                                                    default-first-option placeholder="Nhập..."
                                                    no-data-text="Không có thẻ gợi ý. Vui lòng nhập thẻ mong muốn rồi ấn Enter.">
                                                    <el-option v-for="item in list_tags" :key="item.value"
                                                        :label="item.label" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="typo__label">Loại báo cáo <span
                                                        style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <eselect style="width:100%" collapseTags
                                                    v-model="noiDungBaoCao.loaiBaoCao" :placeholder="'Chọn'" filterable
                                                    :data="list_loai_bao_cao" :fields="['name','value']" />
                                            </div>
                                            <div class="col-md-12" style="margin:10px 0">
                                                <label for="">Phân quyền:</label>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="typo__label">Chọn đơn vị <span
                                                        style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <eselect style="width:100%" multiple collapseTags
                                                    v-model="noiDungBaoCao.donViList" @change="chonDonVi2"
                                                    :placeholder="'Chọn'" filterable :data="list_don_vi"
                                                    :fields="['tenDonVi','maDonVi']" />
                                            </div>
                                            <div class="col-md-2">
                                                <label class="typo__label">Chọn cấp học <span
                                                        style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <eselect style="width:100%" multiple collapseTags
                                                    v-model="noiDungBaoCao.capHocList" @change="chonCapHoc2"
                                                    :placeholder="'Chọn'" filterable :data="list_cap_hoc_2"
                                                    :fields="['name','id']" />
                                            </div>
                                            <div class="col-md-5">
                                                <label class="typo__label">Chọn trường học <span
                                                        style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <eselect style="width:100%" multiple collapseTags
                                                    v-model="noiDungBaoCao.maTruongList"
                                                    :placeholder="'Chọn'" filterable :data="ds_truong_hoc_2"
                                                    :fields="['name','value']" />
                                            </div>
                                            <div class="col-md-12 text-center" style="padding-top:20px">
                                                <button class="btn btn-success" v-on:click.prevent="ExportBaoCao()">Xuất
                                                    báo
                                                    cáo</button>
                                                <button class="btn btn-primary"
                                                    v-on:click.prevent="SubmitUpdateChildReport()">Chỉnh
                                                    sửa
                                                </button>
                                                <button class="btn btn-primary" v-on:click.prevent="demo()">
                                                    Chỉnh sửa template
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div v-else>
                                    <div v-if="running" class="text-center" style="padding:20px">
                                        <img style="width:100px" src="https://i.gifer.com/Y3il.gif" alt="">
                                        <p>Vui lòng đợi trong giây lát...</p>
                                    </div>
                                    <div v-else>
                                        <div class="row" style="padding:0 15px">
                                            <div class="col-md-6">
                                                <label>Tên báo cáo <span style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <el-input clearable placeholder="Nhập..." class="" v-model="noiDungBaoCao.name">
                                                </el-input>
                                            </div>
                                            <div class="col-md-6">
                                                <label>Mô tả <span style="color:#DC0101;display:none"> *</span></label>
                                                <el-input clearable placeholder="Nhập..." class=""
                                                    v-model="noiDungBaoCao.description">
                                                </el-input>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="">Địa chỉ file biểu mẫu <span
                                                        style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <el-input clearable placeholder="Please input" v-model="filePath"
                                                    class="input-with-select">
                                                    <el-button plain type="success" slot="append" @click="showUploadFile">
                                                        upload file
                                                    </el-button>
                                                </el-input>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">Thẻ <span style="color:#DC0101;display:none"> *</span></label>
                                                <el-select v-model="noiDungBaoCao.tags" multiple filterable allow-create
                                                    default-first-option placeholder="Nhập..."
                                                    no-data-text="Không có thẻ gợi ý. Vui lòng nhập thẻ mong muốn rồi ấn Enter.">
                                                    <el-option v-for="item in list_tags" :key="item.value"
                                                        :label="item.label" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="typo__label">Loại báo cáo <span
                                                        style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <eselect style="width:100%" collapseTags
                                                    v-model="noiDungBaoCao.loaiBaoCao" :placeholder="'Chọn'" filterable
                                                    :data="list_loai_bao_cao" :fields="['name','value']" />
                                            </div>
                                            <div class="col-md-12" style="margin:10px 0">
                                                <label for="">Phân quyền:</label>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="typo__label">Chọn đơn vị <span
                                                        style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <eselect style="width:100%" multiple collapseTags
                                                    v-model="noiDungBaoCao.donViList" @change="chonDonVi2"
                                                    :placeholder="'Chọn'" filterable :data="list_don_vi"
                                                    :fields="['tenDonVi','maDonVi']" />
                                            </div>
                                            <div class="col-md-2">
                                                <label class="typo__label">Chọn cấp học <span
                                                        style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <eselect style="width:100%" multiple collapseTags
                                                    v-model="noiDungBaoCao.capHocList" @change="chonCapHoc2"
                                                    :placeholder="'Chọn'" filterable :data="list_cap_hoc_2"
                                                    :fields="['name','id']" />
                                            </div>
                                            <div class="col-md-5">
                                                <label class="typo__label">Chọn trường học <span
                                                        style="color:#DC0101;display:none">
                                                        *</span></label>
                                                <eselect style="width:100%" multiple collapseTags
                                                    v-model="noiDungBaoCao.maTruongList"
                                                    :placeholder="'Chọn'" filterable :data="ds_truong_hoc_2"
                                                    :fields="['name','value']" />
                                            </div>
                                            <div class="col-md-12 text-center" style="padding-top:20px">
                                                <button class="btn btn-default"
                                                    v-on:click.prevent="add_report=false;running=false;">Quay
                                                    lại</button>
                                                <button class="btn btn-primary"
                                                    v-on:click.prevent="SubmitAddChildReport()">Thêm
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else style="min-height:300px;text-align:center;padding-top:50px;">
                                <img style="width:100px" src="https://i.gifer.com/EhFI.gif" alt="">
                                <div>
                                    <p>
                                        <span></span>Vui lòng chọn báo cáo/nhóm báo cáo để xem chi tiết...</p>
                                </div>
                            </div>
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
                dialog.confirmDialog("Xác nhận thêm thông tin báo cáo?", "Xác nhận", () => {
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
            customItemClick1(a, b, c) {
                this.show_info = 1;
                this.add_report = false;
                this.running = false;
                let dachon = b;
                if (dachon.menu) {
                    console.log("gọi api lấy chi tiết cha");
                    // this.getParentReportInfo(dachon.value);
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

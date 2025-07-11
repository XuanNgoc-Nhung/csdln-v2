<template>
    <div>
        <div id="modal_update_tieuchi" ref="modal_update_tieuchi" class="modal fade">
            <div class="modal-dialog modal-dialog-fullscreen" style="">
                <div class="modal-content modal-content-fullscreen" style="">
                    <div class="modal-header modal-header-fullscreen" style="">
                        <h4>Chỉnh sửa tiêu chí</h4>
                    </div>
                    <div class="modal-body modal-body-fullscreen" style="padding-bottom:200px;">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="">Mã tiêu chí</label>
                                <input type="text" disabled v-model="maTieuChi" class="form-control">
                            </div>
                            <div class="col-md-2">
                                <label for="">Tên tiêu chí
                                </label>
                                <input type="text" v-model="tenTieuChi" placeholder="Nhập..."
                                    class="form-control">co
                            </div>
                            <div class="col-md-2">
                                <label for="">Đối tượng</label>
                                <el-select v-model="doiTuong" @change="ChonDoiTuong" placeholder="Chọn đối tượng">
                                    <el-option v-for="item in list_doi_tuong" :key="item.value" :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-md-2">
                                <label for="">Phương pháp tính</label>
                                <el-select v-model="phuongPhapTinh" placeholder="Chọn phương pháp tính">
                                    <el-option v-for="item in list_phuong_phap_tinh" :key="item.value"
                                        :label="item.label" :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-md-4">
                                <label for="">Thẻ (tag)</label>
                                <el-select v-model="Tags" :multiple-limit="setLimmit()" multiple filterable allow-create
                                    default-first-option placeholder="Nhập...">
                                    <el-option v-for="item in options" :key="item.value" :label="item.label"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-md-6">
                                <label for="">Mô tả</label>
                                <input type="text" placeholder="Nhập..." v-model="moTa" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label for="">Lý do yêu cầu sửa</label>
                                <input type="text" placeholder="Nhập..." v-model="lyDo" class="form-control">
                            </div>
                            <div class="col-md-12" style="padding-top:15px;">
                                <label for="">Nhóm điềus kiện <span><button v-if="!suaQuery"
                                            @click.prevent="chinhSuaDieuKien">update</button></span></label>
                                <!-- <vue-query-builder :rules="rules" :maxDepth="3" :labels="labels" v-model="query">
                                </vue-query-builder> -->
                                <div v-if="!suaQuery">
                                    <pre><small>{{query_demo}}</small></pre>

                                </div>
                                <div v-else>
                                    <div v-if="doiTuong">
                                        <vue-query-builder :rules="rules" :maxDepth="3" v-model="query_demo">
                                            <template v-slot:default="slotProps">
                                                <query-builder-group v-bind="slotProps" :query.sync="query" />
                                            </template>
                                        </vue-query-builder>
                                    </div>
                                    <div v-else>
                                        <pre>Chọn đối tượng</pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-fullscreen" style="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                        </button>
                        <button class="btn btn-primary" @click.prevent="update()">Sửa</button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import VueQueryBuilder from 'vue-query-builder';
    import rest_api from '../../../utils/rest_api';
    import dialog from '../../../utils/dialog';
    import ElementUI from 'element-ui';
    Vue.use(ElementUI);
    import VueAlertify from "vue-alertify";
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
    export default {
        props: [
            'item'
        ],
        watch: {},
        data() {
            return {
                query_demo: {},
                suaQuery: false,
                list_phuong_phap_tinh: [{
                    value: '3',
                    label: 'Đếm (count)'
                }, {
                    value: '1',
                    label: 'Cộng (sum)'
                }, {
                    value: '2',
                    label: 'Trung bình (avg)'
                }],
                list_doi_tuong: [{
                    value: 'GiaoVien',
                    label: 'Cán bộ, Giáo viên'
                }, {
                    value: 'LopHoc',
                    label: 'Lớp học'
                }, {
                    value: 'KQHT',
                    label: 'Kết quả học tập'
                }, {
                    value: 'TruongHoc',
                    label: 'Trường học, điểm trường'
                }, {
                    value: 'HocSinh',
                    label: 'Học sinh'
                }],
                options: [{
                    value: 'Trường học',
                    label: 'Trường học'
                }, {
                    value: 'Giáo viên',
                    label: 'Giáo viên'
                }, {
                    value: 'Học sinh',
                    label: 'Học sinh'
                }],
                Tags: [],
                query: [],
                doiTuong: "",
                idBanGhi: "",
                lyDo: "",
                moTa: "",
                tenTieuChi: "",
                maTieuChi: "",
                phuongPhapTinh: "",
                rules: [],
                labels: {
                    "matchType": "Loại",
                    "matchTypes": [{
                            "id": "all",
                            "label": "AND"
                        },
                        {
                            "id": "any",
                            "label": "OR"
                        }
                    ],
                    "addRule": "Thêm quy định",
                    "removeRule": "&times;",
                    "addGroup": "Thêm nhóm",
                    "removeGroup": "&times;",
                    "textInputPlaceholder": "value",
                }
            }
        },
        mounted: function () {
            $("#modal_update_tieuchi").modal();
            console.log("id update");
            this.getInfo();
            $(this.$refs.modal_update_tieuchi).on("hidden.bs.modal", this.close);
        },
        components: {
            VueQueryBuilder,
            MyCustomQueryBuilderGroup
        },
        methods: {
            chinhSuaDieuKien() {

                dialog.confirmDialog(
                    "Xác nhận chỉnh sửa Nhóm điều kiện?",
                    "Đồng ý",
                    () => {
                        this.query_demo = {};
                        this.suaQuery = true;
                    }
                );

            },
            bindData(e) {
                this.maTieuChi = e.maTieuChi;
                this.idBanGhi = e.id;
                this.tenTieuChi = e.tenTieuChi;
                this.doiTuong = e.doiTuong;
                this.phuongPhapTinh = e.calculation;
                this.Tags = e.relatedIndicators;
                this.moTa = e.moTa;
                this.lyDo = e.lyDo;
                this.query = e.filters;
                this.query_demo = e.filters;
                this.ChonDoiTuong();
            },
            getInfo() {
                let params = {
                    id: this.item.id,
                }
                console.log(JSON.stringify(params));
                rest_api.get("/csdlgd-analytic-api/criteria/infor", params, data => {
                    console.log("Data trả về:");
                    console.log(JSON.stringify(data.data));
                    if (data.data.rc == 0) {
                        this.bindData(data.data.item);
                    }
                });
            },
            update() {
                this.query = JSON.parse(JSON.stringify(this.query_demo));
                console.log(JSON.stringify(this.query));
                if (this.query.children && this.query.children.length) {
                    for (let i = 0; i < this.query.children.length; i++) {
                        if (this.query.children[i].type == "query-builder-rule") {
                            this.query.children[i].rule = this.query.children[i].query.rule;
                            this.query.children[i].operator = this.query.children[i].query.operator;
                            this.query.children[i].value = this.query.children[i].query.value;
                            this.query.children[i].type = this.query.children[i].query.type;
                            this.query.children[i].query = "";
                        }
                        if (this.query.children[i].type == "query-builder-group") {
                            for (let j = 0; j < this.query.children[i].query.children.length; j++) {
                                if (this.query.children[i].query.children[j].type == "query-builder-rule") {
                                    this.query.children[i].query.children[j].rule = this.query.children[i].query
                                        .children[j]
                                        .query.rule;
                                    this.query.children[i].query.children[j].operator = this.query.children[i].query
                                        .children[j].query.operator;
                                    this.query.children[i].query.children[j].value = this.query.children[i].query
                                        .children[
                                            j].query.value;
                                    this.query.children[i].query.children[j].type = this.query.children[i].query
                                        .children[j]
                                        .query.type;
                                    this.query.children[i].query.children[j].query = "";
                                }
                                if (this.query.children[i].query.children[j].type == "query-builder-group") {
                                    for (let k = 0; k < this.query.children[i].query.children[j].query.children
                                        .length; k++) {
                                        if (this.query.children[i].query.children[j].query.children[k].type ==
                                            "query-builder-rule") {
                                            this.query.children[i].query.children[j].query.children[k].rule = this.query
                                                .children[i].query
                                                .children[j].query.children[k].query.rule;
                                            this.query.children[i].query.children[j].query.children[k].operator = this
                                                .query
                                                .children[i].query
                                                .children[j].query.children[k].query.operator;
                                            this.query.children[i].query.children[j].query.children[k].value = this
                                                .query
                                                .children[i].query
                                                .children[j].query.children[k].query.value;
                                            this.query.children[i].query.children[j].query.children[k].type = this.query
                                                .children[i].query
                                                .children[j].query.children[k].query.type;
                                            this.query.children[i].query.children[j].query.children[k].query = "";
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                let params = {
                    calculation: this.phuongPhapTinh,
                    doiTuong: this.doiTuong,
                    filters: this.query,
                    tenTieuChi: this.tenTieuChi,
                    maTieuChi: this.maTieuChi,
                    relatedIndicators: this.Tags,
                    moTa: this.moTa,
                    lyDo: this.lyDo,
                    id: this.idBanGhi,
                }
                console.log(JSON.stringify(params));




                dialog.confirmDialog(
                    "Xác nhận chỉnh sửa thông tin?",
                    "Đồng ý",
                    () => {
                        rest_api.post("/csdlgd-analytic-api/criteria/update", params, data => {
                            if (data.data.rc == 0) {
                                this.$alertify
                                    .success("Chỉnh sửa thành công");
                                this.$emit('success')
                            } else {
                                this.$alertify
                                    .error(data.data.rd);
                            }
                        });
                    }
                );



            },
            getChoices(e) {
                let choice = [];
                if (e == "DM_MON_DAY_GV") {
                    choice = JSON.parse(localStorage["danh_sach_mon_day_giao_vien_sme"])
                }
                if (e == "DM_BAC_LUONG") {
                    choice = JSON.parse(localStorage["danh_sach_bac_luong_sme"])
                }
                if (e == "DM_TRINH_DO_CHUYEN_MON") {
                    choice = JSON.parse(localStorage["danh_sach_trinh_do_chuyen_mon_sme"])
                }
                if (e == "DM_TRANG_THAI_CAN_BO") {
                    choice = JSON.parse(localStorage["danh_sach_trang_thai_can_bo_sme"])
                }
                if (e == "DM_TINH") {
                    choice = JSON.parse(localStorage["danh_sach_tinh_sme"])
                }
                if (e == "DM_XA") {
                    choice = JSON.parse(localStorage["danh_sach_xa_sme"])
                }
                if (e == "DM_GIAO_VIEN_CHU_NHIEM_GIOI") {
                    choice = JSON.parse(localStorage["danh_sach_giao_vien_chu_nhiem_gioi_sme"])
                }
                if (e == "DM_CAP_HOC") {
                    choice = JSON.parse(localStorage["danh_sach_cap_hoc_sme"])
                }
                if (e == "DM_LOAI_CAN_BO") {
                    choice = JSON.parse(localStorage["danh_sach_chuc_vu_sme"])
                }
                if (e == "DM_TRINH_DO_TIN_HOC") {
                    choice = JSON.parse(localStorage["danh_sach_trinh_do_tin_hoc_sme"])
                }
                if (e == "DM_GIAO_VIEN_GIOI") {
                    choice = JSON.parse(localStorage["danh_sach_giao_vien_day_gioi_sme"])
                }
                if (e == "DM_LOAI_CCHI_NNGU") {
                    choice = JSON.parse(localStorage["danh_sach_loai_chung_chi_ngoai_ngu_sme"])
                }
                if (e == "DM_DAN_TOC") {
                    choice = JSON.parse(localStorage["danh_sach_dan_toc_sme"])
                }
                if (e == "DM_TRINH_DO_LLCT") {
                    choice = JSON.parse(localStorage["danh_sach_trinh_do_ly_luan_chinh_tri_sme"])
                }
                if (e == "DM_NHOM_CCHI_NNGU") {
                    choice = JSON.parse(localStorage["danh_sach_nhom_chung_chi_ngoai_ngu_sme"])
                }
                if (e == "DM_GV_TONG_PTRACH_DOI_GIOI") {
                    choice = JSON.parse(localStorage["danh_sach_giao_vien_tong_phu_trach_gioi_sme"])
                }
                if (e == "DM_BOI_DUONG_CBQL_COT_CAN") {
                    choice = JSON.parse(localStorage["danh_sach_boi_duong_can_bo_cot_can_sme"])
                }
                if (e == "DM_NGOAI_NGU") {
                    choice = JSON.parse(localStorage["danh_sach_ngoai_ngu_chinh_sme"])
                }
                if (e == "DM_BOI_DUONG_TX") {
                    choice = JSON.parse(localStorage["danh_sach_ket_qua_boi_duong_thuong_xuyen_sme"])
                }
                if (e == "DM_KHUNG_NLUC_NNGU") {
                    choice = JSON.parse(localStorage["danh_sach_khung_nang_luc_ngoai_ngu_sme"])
                }
                if (e == "DM_TRINH_DO_NGOAI_NGU") {
                    choice = JSON.parse(localStorage["danh_sach_trinh_do_ngoai_ngu_sme"])
                }
                if (e == "DM_HUYEN") {
                    choice = JSON.parse(localStorage["danh_sach_huyen_sme"])
                }
                if (e == "DM_DG_VIEN_CHUC") {
                    choice = JSON.parse(localStorage["danh_sach_danh_gia_vien_chuc_sme"])
                }
                if (e == "DM_CHUNG_CHI_TIENG_DTOC_TSO") {
                    choice = JSON.parse(localStorage["danh_sach_chung_chi_tieng_dan_toc_thieu_so_sme"])
                }
                if (e == "DM_HINH_THUC_HOP_DONG") {
                    choice = JSON.parse(localStorage["danh_sach_hinh_thuc_hop_dong_sme"])
                }
                if (e == "DM_TRINH_DO_QLGD") {
                    choice = JSON.parse(localStorage["danh_sach_trinh_do_quan_ly_giao_duc_sme"])
                }
                if (e == "DM_NGACH_CC") {
                    choice = JSON.parse(localStorage["danh_sach_ngach_hang_sme"])
                }
                if (e == "DM_BOI_DUONG_NVU") {
                    choice = JSON.parse(localStorage["danh_sach_boi_duong_nghiep_vu_sme"])
                }
                if (e == "DM_GIOI_TINH") {
                    choice = JSON.parse(localStorage["danh_sach_gioi_tinh_sme"])
                }
                if (e == "DM_TRINH_DO") {
                    choice = JSON.parse(localStorage["danh_sach_trinh_do_khac_sme"])
                }
                if (e == "DM_CHUYEN_MON") {
                    choice = JSON.parse(localStorage["danh_sach_chuyen_nganh_dao_tao_khac_sme"])
                }
                if (e == "DM_NHOM_CAN_BO") {
                    choice = JSON.parse(localStorage["danh_sach_loai_can_bo_sme"])
                }
                if (e == "DM_TON_GIAO") {
                    choice = JSON.parse(localStorage["danh_sach_ton_giao_sme"])
                }
                if (e == "DM_BOI_DUONG_THAY_SACH") {
                    choice = JSON.parse(localStorage["danh_sach_boi_duong_thay_sach_sme"])
                }
                if (e == "DM_CAP_DAY_GV_MOET") {
                    choice = JSON.parse(localStorage["danh_sach_cap_day_gv_moet_sme"])
                }
                if (e == "DM_TRANG_THAI_HOC_SINH") {
                    choice = JSON.parse(localStorage["danh_sach_cap_trang_thai_hoc_sinh_sme"])
                }
                if (e == "DM_NUOC") {
                    choice = JSON.parse(localStorage["danh_sach_nuoc_sme"])
                }
                if (e == "DM_DIEN_CHINH_SACH") {
                    choice = JSON.parse(localStorage["danh_sach_dien_chinh_sach_sme"])
                }
                if (e == "DM_LOAI_KHUYET_TAT") {
                    choice = JSON.parse(localStorage["danh_sach_loai_khuyet_tat_sme"])
                }
                if (e == "DM_HINH_THUC_DAO_TAO_HOC_TAP") {
                    choice = JSON.parse(localStorage["danh_sach_hinh_thuc_dao_tao_hoc_tap_sme"])
                }
                if (e == "DM_LOP_HUONG_NGHIEP_DAY_NGHE") {
                    choice = JSON.parse(localStorage["danh_sach_huong_nghiep_sme"])
                }
                if (e == "DM_LY_DO_THOI_HOC") {
                    choice = JSON.parse(localStorage["danh_sach_ly_do_thoi_hoc_sme"])
                }
                if (e == "DM_HOC_BAN_TRU") {
                    choice = JSON.parse(localStorage["danh_sach_hoc_ban_tru_sme"])
                }
                if (e == "DM_KHU_VUC") {
                    choice = JSON.parse(localStorage["danh_sach_khu_vuc_sme"])
                }
                if (e == "DM_KHOI") {
                    choice = JSON.parse(localStorage["danh_sach_khoi_sme"])
                }
                return choice;
            },
            ChonDoiTuong() {
                this.rules = []
                let params = {
                    "doiTuong": this.doiTuong,
                }
                rest_api.get("/csdlgd-admin/sme/getSmeTheoDoiTuong", params, data => {
                    if (data.data.rc == 0) {
                        let dt_dm = data.data.tableData;
                        for (let i = 0; i < dt_dm.length; i++) {
                            let obj = {
                                type: "text",
                                id: dt_dm[i].constantDescription,
                                kieuDuieu: dt_dm[i].entityType,
                                label: dt_dm[i].moetExcelValue,
                                choices: this.getChoices(dt_dm[i].constantType)
                            }
                            this.rules.push(obj)
                        }
                        console.log("List rules:");
                        console.log(JSON.stringify(this.rules));
                    } else {
                        // *****
                    }
                });
            },
            setLimmit() {
                return 5
            },

            close() {
                this.$emit('close');
            },
        },
        computed: {}
    }

</script>
<style scoped="scoped">
    /* @import "../../../../../../node_modules/css-custom.css"; */

    .text-right label {
        padding: 6px 0;
    }

    .nav-tabs>li.active>a {
        font-weight: bold;
        color: forestgreen;
        border-top: 4px solid forestgreen;
    }

    .rct {
        margin: 5px -15px !important;
        display: flex;
    }

    .rct>.col-md-7,
    .col-md-2,
    .col-md-4,
    .col-md-5 {
        align-self: center;
    }

    .cg {
        text-align: center;
    }

    .bt>a>b>i {
        color: #DC0101;
        border: 1px solid black;
        padding: 5px 6px;
        border-radius: 23%;
    }

    .el-tag+.el-tag {
        margin-left: 10px;
    }

    .button-new-tag {
        margin-left: 10px;
        height: 24px;
        line-height: 0px;
        padding-top: 0;
        padding-bottom: 0;
    }

    .input-new-tag {
        width: 90px;
        margin-left: 10px;
        vertical-align: bottom;
    }

</style>

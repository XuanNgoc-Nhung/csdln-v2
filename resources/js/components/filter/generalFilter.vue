<template>
    <div>

        <div style="margin-top: 20px">
            <!-- đơn vị -->
            <div class="col-md-4 pxn-col">
                <div>
                    <label class="typo__label">Chọn đơn vị:</label>
                    <multiselect v-model="danhSachDonVi" :options="list_don_vi" :multiple="true"
                        :close-on-select="false" :clear-on-select="false" :preserve-search="false"
                        deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                        :custom-label="setNameDonVi" placeholder="Chọn đơn vị" @close="chonXongDonVi" label="maDonVi"
                        track-by="tenDonVi" :preselect-first="true">
                        <template v-if="danhSachDonVi.length>1" slot="selection"
                            slot-scope="{ values, search, isOpen }">
                            <span class="multiselect__single"
                                v-if="values.length &amp;&amp; !isOpen">{{ values.length }}
                                đơn vị được chọn</span>
                        </template>
                    </multiselect>
                    <!-- <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> -->
                </div>
            </div>
            <!-- end đơn vị -->
            <!-- Cấp học -->
            <div class="col-md-2 pxn-col">
                <div>
                    <label class="typo__label">Chọn cấp học</label>
                    <multiselect v-model="danhSachCapHoc" :options="list_cap_hoc" :multiple="true"
                        :close-on-select="false" :clear-on-select="false" :preserve-search="false"
                        deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                        :custom-label="setNameCapHoc" placeholder="Chọn cấp học" label="name" @close="chonXongCapHoc"
                        track-by="name">
                        <template v-if="danhSachCapHoc.length>1" slot="selection"
                            slot-scope="{ values, search, isOpen }">
                            <span class="multiselect__single"
                                v-if="values.length &amp;&amp; !isOpen">{{ values.length }}
                                cấp học được chọn</span>
                        </template>
                    </multiselect>
                </div>
            </div>
            <!-- end cấp học-->
            <div class="col-md-2 pxn-col">
                <label>Mã trường học:</label>
                <input @input.prevent="setParamsFilter" v-model="maTruongHoc" class="form-control"
                    placeholder="Nhập..." />
            </div>
            <!-- Cấp học -->
            <div class="col-md-4 pxn-col">
                <div>
                    <label class="typo__label">Chọn trường học</label>
                    <multiselect v-model="danhSachTruongHoc" :options="list_truong_hoc" :multiple="true"
                        :close-on-select="false" :clear-on-select="false" deselectLabel="Đã chọn"
                        selectLabel="Chưa chọn" selectedLabel="Đã chọn" :custom-label="setNameTruongHoc"
                        placeholder="Chọn trường học" label="maTruongHoc" track-by="maTruongHoc">
                        <template v-if="danhSachTruongHoc.length>1" slot="selection"
                            slot-scope="{ values, search, isOpen }">
                            <span class="multiselect__single"
                                v-if="values.length &amp;&amp; !isOpen">{{ values.length }}
                                trường học được chọn</span>
                        </template>
                    </multiselect>
                </div>
            </div>
            <!-- end cấp học-->
            <!-- Năm học -->
            <div class="col-md-2 pxn-col">
                <label class="typo__label">Năm học</label>
                <multiselect v-model="danhSachNamHoc" :options="list_nam_hoc" :custom-label="setNameNamHoc"
                    placeholder="Chọn năm học" label="name" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                    selectedLabel="Đã chọn" track-by="name"></multiselect>
            </div>
            <!-- End năm học -->
            <!-- endform -->
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect'
    import constant from "../../utils/constant";
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import {
        mapMutations,
        mapState
    } from 'vuex';
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {

        components: {
            Multiselect
        },
        computed: {
            ...mapState(['filterGeneral'])
        },
        watch: {
            danhSachDonVi: function (newVal) {
                this.ds_don_vi = [];
                if (newVal) {
                    let lsdv = newVal.map((obj) => {
                        return obj['maDonVi']
                    });
                    this.ds_don_vi = lsdv;

                }
                this.getTruongHoc();
                this.setParamsFilter();
            },
            danhSachCapHoc: function (newVal) {
                this.ds_cap_hoc = [];
                if (newVal) {

                    let lsch = newVal.map((obj) => {
                        return obj['id']
                    });
                    this.ds_cap_hoc = lsch;
                }
                this.setParamsFilter();
                this.getTruongHoc();
            },
            danhSachTruongHoc: function (newVal) {
                this.ds_truong_hoc = [];
                if (newVal) {
                    let lsth = newVal.map((obj) => {
                        return obj['maTruongHoc']
                    });
                    this.ds_truong_hoc = lsth;
                }
                this.setParamsFilter();
                this.getTruongHoc();
            },

            danhSachNamHoc: function (newVal) {
                console.log("Chọn các năm học:" + JSON.stringify(newVal));
                this.namHoc = "";
                if (newVal) {

                    this.namHoc = newVal
                        .id
                    console
                        .log("map xong:" + JSON.stringify(this.namHoc));
                }
                this.setParamsFilter();
            },
            "filterGeneral": {
                handler: function (val) {
                    if (val.hasCallack) {
                        this.$emit('timkiem')
                    }
                },
                deep: true
            }
        },

        data() {
            return {
                chonDonVi: [
                    {constantType: 'DM_TRANG_THAI_CAN_BO',list_data: []},
                    {constantType: 'DM_TON_GIAO',list_data: []},
                    {constantType: 'DM_DAN_TOC',list_data: []},
                    {constantType: 'DM_NHOM_CAN_BO',list_data: []},
                    {constantType: 'DM_MON_DAY_GV',list_data: []},
                    {constantType: 'DM_LOAI_CAN_BO',list_data: []},
                    {constantType: 'DM_HINH_THUC_HOP_DONG',list_data: []},
                    {constantType: 'DM_NHIEM_VU_KIEM_NHIEM',list_data: []},
                    {constantType: 'DM_NGACH_CC',list_data: []},
                    {constantType: 'DM_BOI_DUONG_TX',list_data: []},
                    {constantType: 'DM_TRINH_DO_CHUYEN_MON',list_data: []},
                    {constantType: 'DM_TRINH_DO_LLCT',list_data: []},
                    {constantType: 'DM_TRINH_DO_QLGD',list_data: []},
                    {constantType: 'DM_BOI_DUONG_NVU',list_data: []},
                    {constantType: 'DM_BOI_DUONG_CBQL_COT_CAN',list_data: []},
                    {constantType: 'DM_BOI_DUONG_CBQL_COT_CAN',list_data: []},
                    {constantType: 'DM_BOI_DUONG_THAY_SACH',list_data: []},
                    {constantType: 'DM_NGOAI_NGU',list_data: []},
                    {constantType: 'DM_TRINH_DO_NGOAI_NGU',list_data: []},
                    {constantType: 'DM_NHOM_CCHI_NNGU',list_data: []},
                    {constantType: 'DM_LOAI_CCHI_NNGU',list_data: []},
                    {constantType: 'DM_KHUNG_NLUC_NNGU',list_data: []},
                    {constantType: 'DM_TRINH_DO_TIN_HOC',list_data: []},
                    {constantType: 'DM_CHUYEN_MON',list_data: []},
                    {constantType: 'DM_TRINH_DO',list_data: []},
                    {constantType: 'DM_CHUYEN_MON',list_data: []},
                    {constantType: 'DM_TRINH_DO',list_data: []},
                    {constantType: 'DM_CHUNG_CHI_TIENG_DTOC_TSO',list_data: []},
                    {constantType: 'DM_DG_VIEN_CHUC',list_data: []},
                    {constantType: 'DM_GIAO_VIEN_GIOI',list_data: []},
                    {constantType: 'DM_GIAO_VIEN_CHU_NHIEM_GIOI',list_data: []},
                    {constantType: 'DM_GV_TONG_PTRACH_DOI_GIOI',list_data: []},
                    {constantType: 'DM_KQ_CHUAN_NGHE_NGHIEP',list_data: []},
                    {constantType: 'DM_BAC_LUONG',list_data: []},
                    {constantType: 'MA_KHOA_DAO_TAO_SU_PHAM',list_data: []},
                    {constantType: 'MA_KHOA_DAO_TAO_NGOAI_NGU',list_data: []},
                    {constantType: 'MA_DON_VI',list_data: []},
                    {constantType: 'MA_DON_VI_TO_CHUC',list_data: []},
                    {constantType: 'MA_THOI_LUONG_BOI_DUONG',list_data: []},
                    {constantType: 'MA_HINH_THUC',list_data: []},
                    {constantType: 'MA_KET_QUA_SU_PHAM',list_data: []},
                    {constantType: 'MA_KET_QUA_NGOAI_NGU',list_data: []},
                    {constantType: 'DM_HINH_THUC_DAO_TAO',list_data: []},
                    {constantType: 'DM_KHEN_THUONG_GV',list_data: []},
                    {constantType: 'MA_LOAI_HINH_BOI_DUONG',list_data: []},
                    {constantType: 'DM_NHOM_MAU',list_data: []},
                    {constantType: 'DM_DOI_TUONG_CHINH_SACH',list_data: []},
                    {constantType: 'DM_VUNG_KHO_KHAN',list_data: []},
                    {constantType: 'DM_KHU_VUC',list_data: []},
                    {constantType: 'DM_LOAI_KHUYET_TAT',list_data: []},
                    {constantType: 'LOAI_NHAP_HOC',list_data: []},
                    {constantType: 'DM_SO_BUOI_HOC_TREN_TUAN',list_data: []},
                    {constantType: 'DM_HOC_BAN_TRU',list_data: []},
                    {constantType: 'DM_LOP_HUONG_NGHIEP_DAY_NGHE',list_data: []},
                    {constantType: 'THANH_PHAN_GIA_DINH',list_data: []},
                    {constantType: 'DM_NHOM_TUOI_MN',list_data: []},
                    {constantType: 'MA_BUOI_HOC',list_data: []},
                    {constantType: 'DM_TIET_HOC',list_data: []},
                    {constantType: 'DM_KIEU_LOP',list_data: []},
                    {constantType: 'MA_CHUONG_TRINH_HOC_NN',list_data: []},
                    {constantType: 'DM_TIET_HOC_NGOAI_NGU',list_data: []},
                    {constantType: 'DM_HINH_THUC_DAO_TAO_HOC_TAP',list_data: []},
                    {constantType: 'DM_LOP_DAO_TAO_BOI_DUONG',list_data: []},
                    {constantType: 'DM_PHAN_BAN',list_data: []},
                    {constantType: 'DM_BO_SACH_GIAO_KHOA_SU_DUNG',list_data: []},
                    {constantType: 'DM_LOAI_HINH_DAO_TAO',list_data: []},
                    {constantType: 'DM_LOAI_HINH_TRUONG',list_data: []},
                    {constantType: 'DM_MUC_DAT_CHUAN_QG_CLGD',list_data: []},
                    {constantType: 'DM_GIAI_DOAN_KQHT',list_data: []},
                    {constantType: 'DM_MON_HOC',list_data: []},
                    {constantType: 'DM_TINH',list_data: []},
                    {constantType: 'DM_HUYEN',list_data: []},
                    {constantType: 'DM_XA',list_data: []},
                    {constantType: 'DM_CAP_HOC',list_data: []},
                    {constantType: 'DM_GIOI_TINH',list_data: []},
                    {constantType: 'DM_CAP_DAY_GV_MOET',list_data: []},
                    {constantType: 'DM_TRANG_THAI_HOC_SINH',list_data: []},
                    {constantType: 'DM_NUOC',list_data: []},
                    {constantType: 'DM_DIEN_CHINH_SACH',list_data: []},
                    {constantType: 'DM_LY_DO_THOI_HOC',list_data: []},
                    {constantType: 'DM_KHOI',list_data: []},
                    {constantType: 'DM_NHOM_CAP_HOC',list_data: []},
                    {constantType: 'DM_TRUNG_TAM',list_data: []},
                    {constantType: 'DM_LOAI_TRUONG',list_data: []},
                    {constantType: 'DM_LOAI_TRUNG_TAM',list_data: []},
                    {constantType: 'DM_DU_AN',list_data: []},
                    {constantType: 'DM_VUNG',list_data: []},
                ]

            }
        },
        mounted: function () {
            console.log(window.userInfo);
            this.thongtin = JSON.parse(window.userInfo);
            console.log("thông tin đăng nhập" + JSON.stringify(this.thongtin));
            this.getDonViSync();
            this.getTruongHoc(() => {
                console.log("Check 222222222222");
                if (this.thongtin.role == 5) {
                    console.log("là trường");
                    for (let i = 0; i < this.list_truong_hoc.length; i++) {
                        if (this.list_truong_hoc[i].maTruongHoc == this.thongtin.ma_truong_hoc) {
                            this.danhSachTruongHoc = [this.list_truong_hoc[i]];
                            this.setParamsFilter(true);
                        }
                    }
                }
            });
        },
        methods: {
            ...mapMutations(['setFilter']),
            setParamsFilter(hasCallack = false) {
                this.setFilter({
                    listDonVi: this.ds_don_vi,
                    listCapHoc: this.ds_cap_hoc,
                    listTruongHoc: this.ds_truong_hoc,
                    maTruongHoc: this.maTruongHoc,
                    namHoc: this.namHoc
                });
            },
            chonXongDonVi() {
                console.log("Chọn xong đơn vị");
                // Chọn xong đơn vị thì lấy trường
                this.getTruongHoc();
            },
            chonXongCapHoc() {
                console.log("Chọn xong cấp học");
                // Chọn xong cấp học thì lấy trường
                this.getTruongHoc();
            },
            chonXongNamHoc() {
                console.log("Chọn xong cấp học" + JSON.stringify(this.danhSachNamHoc));
                this.namHoc = this.danhSachNamHoc.id;
                // Chọn xong cấp học thì lấy trường
                this.setParamsFilter();
            },
            async getDonViSync() {
                try {
                    let params = {
                        "start": 0,
                        "limit": 9999,
                        "maTinhThanh": this.thongtin.province,
                        // "loaiDonVi": 2
                    };
                    let data = await rest_api.getAsync("/internal-api/dmDonVi/filter", params);
                    console.log("object", data);
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        this.list_don_vi = data.data.rows;
                        if (this.thongtin.role == 4) {
                            for (let i = 0; i < this.list_don_vi.length; i++) {
                                if (this.list_don_vi[i].maDonVi == this.thongtin.ma_don_vi) {
                                    this.danhSachDonVi = [this.list_don_vi[i]];
                                }
                            }
                        }
                        if (this.thongtin.role == 5) {
                            for (let i = 0; i < this.list_don_vi.length; i++) {
                                if (this.list_don_vi[i].maDonVi == this.thongtin.ma_don_vi) {
                                    this.danhSachDonVi = [this.list_don_vi[i]];
                                }
                            }
                        }
                    }
                } catch (err) {
                    //
                }
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.province,
                    // "loaiDonVi": 2
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        this.list_don_vi = data.data.rows;
                    }
                });
            },
            getTruongHoc(ck = () => {}) {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    console.log("lấy trường");
                    if (data.data.code == 200) {
                        this.list_truong_hoc = data.data.rows;
                        ck();
                    }
                });
            },
            setNameDonVi({
                tenDonVi,
                maDonVi
            }) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            setNameTruongHoc({
                tenTruongHoc,
                maTruongHoc
            }) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            setNameCapHoc({
                name
            }) {
                return `${name}`
            },
            setNameNamHoc({
                name
            }) {
                return `${name}`
            }
        }
    }

</script>

<style scoped="scoped">
    @import "../../../../node_modules/selectwithsearch.css";

    .pxn-col {
        padding-top: 5px;
    }

</style>

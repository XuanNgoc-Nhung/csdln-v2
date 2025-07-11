<template>
    <div>
        <div class="row" style="margin:0">
            <div class="col-md-12">
                <h4>
                    Thông tin nhóm báo cáo
                </h4>
            </div>
            <div class="col-md-12">
                <label for="">Tên nhóm báo cáo</label>
                <input type="text" class="form-control" disabled :value="thongTinBaoCao.groupName">
            </div>
            <div class="col-md-12">
                <label for="">Đơn vị áp dụng</label>
                <eselect style="width:100%" multiple collapseTags v-model="thongTinBaoCao.donViList"
                    :placeholder="'Chọn'" filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
            </div>
            <div class="col-md-4">
                <label for="">Cấp học áp dụng</label>
                <eselect style="width:100%" multiple collapseTags v-model="thongTinBaoCao.capHocList"
                    :placeholder="'Chọn'" filterable :data="list_cap_hoc_2" :fields="['name','id']" />
            </div>
            <div class="col-md-8">
                <label for="">Trường học áp dụng</label>
                <eselect style="width:100%" multiple collapseTags v-model="thongTinBaoCao.maTruongList"
                    :placeholder="'Chọn'" filterable :data="ds_truong_hoc" :fields="['name','value']" />
            </div>
            <hr>
            <div class="col-md-12 text-center" style="margin-top:15px" v-if="false">
                <el-button size="mini" type="primary" @click.prevent="ThemNhomBaoCao">Thêm nhóm con</el-button>
                <el-button size="mini" type="warning" @click.prevent="ChinhSuaNhomBaoCao">Chỉnh sửa</el-button>
                <el-button size="mini" type="danger" @click.prevent="XoaNhomBaoCao" :disabled="thongTinBaoCao.hasChild">
                    Xóa</el-button>
                <el-button size="mini" type="primary" @click.prevent="ThemBaoCaoCon">Thêm báo cáo</el-button>
            </div>
        </div>
        <ThemNhomBaoCao :show="hien_thi_them_nhom_bao_cao" :nhom_cha="thongTinBaoCao" @success="themNhomThanhCong"
            @close="hien_thi_them_nhom_bao_cao=false"></ThemNhomBaoCao>
        <ChinhSuaNhomBaoCao :show="hien_thi_chinh_sua_nhom_bao_cao" :nhom_cha="thongTinBaoCao"
            @success="chinhSuaThanhCong" @close="hien_thi_chinh_sua_nhom_bao_cao=false"></ChinhSuaNhomBaoCao>
        <ThemBaoCao :show="hien_thi_them_bao_cao" :nhom_cha="thongTinBaoCao" @success="themBaoCaoThanhCong"
            @close="dongModalThemBaoCao">
        </ThemBaoCao>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
    import ThemNhomBaoCao from './ThemNhomBaoCao.vue';
    import ChinhSuaNhomBaoCao from './ChinhSuaNhomBaoCao.vue';
    import ThemBaoCao from './ThemBaoCao.vue';
    export default {
        props: [
            'item'
        ],
        components: {
            'eselect': ESelectVue,
            'ThemNhomBaoCao': ThemNhomBaoCao,
            'ChinhSuaNhomBaoCao': ChinhSuaNhomBaoCao,
            'ThemBaoCao': ThemBaoCao,
        },
        data() {
            return {
                thongTinBaoCao: {},
                thongtin: JSON.parse(window.userInfo),
                list_cap_hoc_2: window.listCapHoc,
                list_don_vi: [],
                ds_truong_hoc: [],
                hien_thi_them_nhom_bao_cao: false,
                hien_thi_chinh_sua_nhom_bao_cao: false,
                hien_thi_them_bao_cao: false,
            };
        },
        watch: {
            item: function (newVal) {
                console.log("item thay đổi:" + newVal);
                if (newVal) {
                    this.getThongTinNhomBaoCao(newVal)
                }
            },
        },
        mounted: function () {
            this.getThongTinNhomBaoCao(this.item);
            this.getDanhSachDonVi();
        },
        methods: {
            dongModalThemBaoCao() {
                this.hien_thi_them_bao_cao = false;
                this.hien_thi_chinh_sua_nhom_bao_cao = false;
                this.hien_thi_them_nhom_bao_cao = false;
                console.log("Đóng modal thêm báo cáo trong thông thin nhóm báo cáo")
            },
            themBaoCaoThanhCong() {
                this.hien_thi_them_bao_cao = false;
                this.hien_thi_chinh_sua_nhom_bao_cao = false;
                this.hien_thi_them_nhom_bao_cao = false;
                this.$emit('thembaocaothanhcong')
            },
            ThemBaoCaoCon() {
                this.hien_thi_them_bao_cao = true;
                this.hien_thi_chinh_sua_nhom_bao_cao = false;
                this.hien_thi_them_nhom_bao_cao = false;
                console.log("Thêm báo cáo");
            },
            XoaNhomBaoCao() {
                console.log("Xóa báo cáo:" + JSON.stringify(this.thongTinBaoCao))
                if (!this.thongTinBaoCao.hasChild) {
                    let params = {
                        "id": this.item
                    }
                    this.$confirm('Xác nhận xóa dữ liệu?', 'Thông báo', {
                            confirmButtonText: 'Xóa',
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
                            rest_api.post('/csdlgd-analytic-api/nhomBc/deleteBc', params, (
                                data) => {
                                loading.close()
                                console.log(JSON.stringify(data));
                                if (data.data.rc == 0) {
                                    this.thongBao("success", data.data.rd);
                                    this.$emit('XoaXongNhomBc')
                                } else {
                                    this.thongBao('error', data.data.rd)
                                }
                            });
                        })
                        .catch(_ => {});
                } else {
                    this.thongBao('error', 'Không thể xóa báo cáo nầy do đang chứa báo cáo hoặc nhóm báo cáo')
                }
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
            chinhSuaThanhCong() {
                this.hien_thi_them_bao_cao = false;
                this.hien_thi_chinh_sua_nhom_bao_cao = false;
                this.hien_thi_them_nhom_bao_cao = false;
                this.getThongTinNhomBaoCao(this.item);
                this.$emit('themThanhCong')
            },
            ChinhSuaNhomBaoCao() {
                this.hien_thi_them_bao_cao = false;
                this.hien_thi_them_nhom_bao_cao = false;
                this.hien_thi_chinh_sua_nhom_bao_cao = true;
                console.log("Chỉnh sửa nhóm báo cáo");
            },
            themNhomThanhCong() {
                this.hien_thi_them_bao_cao = false;
                this.hien_thi_them_nhom_bao_cao = false;
                this.hien_thi_chinh_sua_nhom_bao_cao = false;
                this.$emit('themThanhCong')
            },
            ThemNhomBaoCao() {
                console.log("Thêm nhóm báo cáo con");
                this.hien_thi_them_bao_cao = false;
                this.hien_thi_chinh_sua_nhom_bao_cao = false;
                this.hien_thi_them_nhom_bao_cao = false;
                this.hien_thi_them_nhom_bao_cao = true;
            },
            getTruongHoc() {
                const loadingGetTruongHoc = this.$loading({
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
                    loadingGetTruongHoc.close();
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
            getDanhSachDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
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
            getThongTinNhomBaoCao(e) {
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
                        console.log(JSON.stringify(data));
                        this.thongTinBaoCao = data.data.item;
                        this.getTruongHoc();
                    } else {}
                });
            }
        },
    };

</script>
<style>
</style>

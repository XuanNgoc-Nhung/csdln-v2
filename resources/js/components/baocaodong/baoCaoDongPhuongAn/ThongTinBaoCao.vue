<template>
    <div>
        <div class="row" style="margin:0">
            <div class="col-md-12 dts-col">
                <h4>
                    THÔNG TIN BÁO CÁO
                </h4>
            </div>
            <div class="col-md-12 dts-col">
                <label for="">Tên báo cáo</label>
                <input type="text" class="form-control" disabled :value="thongTinBaoCao.name">
            </div>
            <div class="col-md-12 dts-col">
                <label for="">Mô tả báo cáo</label>
                <input type="text" class="form-control" disabled :value="thongTinBaoCao.description">
            </div>
            <div class="col-md-12 dts-col">
                <label for="">Địa chỉ file biểu mẫu</label>
                <el-input clearable disabled placeholder="Nhập..." v-model="thongTinBaoCao.templateFile"
                    class="input-with-select">
                    <el-button plain type="success" size="mini"
                        @click.prevent="taiXuongFileTemplate(thongTinBaoCao.templateFile)" slot="append">
                        Tải xuống
                    </el-button>
                </el-input>
            </div>
            <div class="col-md-6 dts-col">
                <label for="">Thẻ</label>
                <el-select multiple v-model="thongTinBaoCao.tags" filterable allow-create default-first-option
                    placeholder="Nhập..." no-data-text="Không có thẻ gợi ý. Vui lòng nhập thẻ mong muốn rồi ấn Enter.">
                    <el-option v-for="item in list_tags" :key="item.value" :label="item.label" :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <div class="col-md-6 dts-col">
                <label class="typo__label">Loại báo cáo</label>
                <eselect style="width:100%" :disabled="true" v-model="thongTinBaoCao.reportLoopType" collapseTags
                    :placeholder="'Chọn'" filterable :data="list_loai_bao_cao" :fields="['name','value']" />
            </div>
            <el-row :gutter="20">
                <el-col :span='12'>
                    <el-table :data="danh_sach_don_vi_duoc_phep_ot" border style="width: 100%" max-height="250">
                        <el-table-column type="index" label="STT" align="center" width="60">
                        </el-table-column>
                        <el-table-column label="Tên" header-align="center">
                            <template slot-scope="scope">
                                <p>{{ scope.row.tenDonVi }}</p>
                            </template>
                        </el-table-column>
                        <el-table-column label="Mã" align="center" width="60">
                            <template slot-scope="scope">
                                <p>{{ scope.row.maDonVi }}</p>
                            </template>
                        </el-table-column>
                    </el-table>
                </el-col>
                <el-col :span='12'>
                    <el-table :data="danh_sach_cap_hoc_duoc_phep_ot" border style="width: 100%" height="200">
                        <el-table-column type="index" label="STT" align="center" width="60">
                        </el-table-column>
                        <el-table-column label="Tên" header-align="center">
                            <template slot-scope="scope">
                                <p>{{ scope.row.name }}</p>
                            </template>
                        </el-table-column>
                        <el-table-column label="Mã" align="center" width="60">
                            <template slot-scope="scope">
                                <p>{{ scope.row.id }}</p>
                            </template>
                        </el-table-column>
                    </el-table>
                </el-col>
                <el-col :span='8'>Trường học </el-col>
            </el-row>
            <div class="dp-none col-md-12 dts-col">
                <label for="">Đơn vị</label>
                <eselect style="width:100%" v-model="thongTinBaoCao.donViList" multiple collapseTags
                    no-match-text="Không tìm thấy bản ghi nào" no-data-text="danh sách lựa chọn trống"
                    :placeholder="'Chọn'" filterable :data="danh_sach_don_vi_duoc_phep_ot"
                    :fields="['tenDonVi','maDonVi']" />
            </div>
            <div class="col-md-12 dp-none dts-col">
                <label for="">Cấp học</label>
                <eselect style="width:100%" multiple v-model="thongTinBaoCao.capHocList" collapseTags
                    no-match-text="Không tìm thấy bản ghi nào" no-data-text="danh sách lựa chọn trống"
                    :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc_duoc_phep_ot"
                    :fields="['name','id']" />
            </div>
            <div class="col-md-12 dp-none dts-col">
                <label for="">Trường học</label>
                <eselect style="width:100%" v-model="thongTinBaoCao.maTruongList" multiple collapseTags
                    no-match-text="Không tìm thấy bản ghi nào" no-data-text="danh sách lựa chọn trống"
                    :placeholder="'Chọn'" filterable :data="danh_sach_truong_hoc_duoc_phep_ot"
                    :fields="['name','value']" />
            </div>
            <div class="col-md-12 dts-col text-center">
                <el-button size="mini" type="info" @click.prevent="XuatBaoCao">Xuất báo cáo</el-button>
                <el-button type="danger" size="mini" @click.prevent="xoaBaoCao">Xóa</el-button>
                <el-button size="mini" type="warning" @click="chinhSuaBaoCao">Chỉnh sửa</el-button>
                <el-button size="mini" type="primary" @click.prevent="ChinhSuaTemplate">Chỉnh sửa template</el-button>
                <!-- <button class="btn btn-primary" @click.prevent="ChinhSuaTemplateLapDong">Chỉnh sửa template (2)</button> -->
            </div>
        </div>
        <!-- <div v-if="hien_thi_chinh_sua_bao_cao"> -->
        <ChinhSuaBaoCao :show="hien_thi_chinh_sua_bao_cao" :item="idBaoCao" @success="chinhSuaThanhCong($event)"
            @close="hien_thi_chinh_sua_bao_cao=false">
        </ChinhSuaBaoCao>
        <!-- </div> -->
        <!-- <div v-if="hien_thi_xuat_bao_cao"> -->
        <XuatBaoCao :show="hien_thi_xuat_bao_cao" :nameReport="thongTinBaoCao.name" :item="idBaoCao"
            @success="themBaoCaoThanhCong" @close="hien_thi_xuat_bao_cao=false">
        </XuatBaoCao>
        <!-- </div> -->
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
    import dialog from '../../../utils/dialog';
    import ChinhSuaBaoCao from './ChinhSuaBaoCao';
    import XuatBaoCao from './XuatBaoCao';
    export default {
        props: [
            'item'
        ],
        components: {
            'eselect': ESelectVue,
            'ChinhSuaBaoCao': ChinhSuaBaoCao,
            'XuatBaoCao': XuatBaoCao,
        },
        data() {
            return {
                thongTinBaoCao: {},
                idBaoCao: "",
                thongtin: JSON.parse(window.userInfo),
                danh_sach_cap_hoc_full: window.listCapHoc,
                danh_sach_don_vi_full: [],
                danh_sach_truong_hoc_full: [],
                danh_sach_don_vi_duoc_phep: [],
                danh_sach_don_vi_duoc_phep_ot: [],
                danh_sach_cap_hoc_duoc_phep: [],
                danh_sach_cap_hoc_duoc_phep_ot: [],
                danh_sach_truong_hoc_duoc_phep: [],
                danh_sach_truong_hoc_duoc_phep_ot: [],
                list_tags: [],
                list_loai_bao_cao: [{
                    name: "Chưa có thông tin",
                    value: null
                }, {
                    name: "Chưa có thông tin",
                    value: ""
                }, {
                    name: "Báo cáo không lặp",
                    value: "KHONG_LAP"
                }, {
                    name: "Báo cáo lặp đơn dòng",
                    value: "LAP_DON_DONG"
                }, {
                    name: "Báo cáo lặp đa dòng",
                    value: "LAP_DA_DONG"
                }],
                hien_thi_chinh_sua_bao_cao: false,
                hien_thi_xuat_bao_cao: false,
            };
        },
        watch: {
            item: function (newVal) {
                if (newVal) {
                    this.idBaoCao = newVal;
                    this.getThongTinBaoCao(newVal)
                }
            },
        },
        mounted: function () {
            this.getFullDonVi();
            this.idBaoCao = this.item;
        },
        methods: {
            xoaBaoCao() {
                console.log("xóa báo cáo");
                var url = "/csdlgd-analytic-api/BcChiTiet/deleteBcChiTiet";
                let params = {
                    "id": this.idBaoCao
                }
                this.$confirm('Xác nhận xóa báo cáo?', 'Xóa báo cáo', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass: 'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const loadingXoaTemplate = this.$loading({
                            lock: true,
                            text: 'Vui lòng chờ trong giây lát...',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post(url, params, (
                            data) => {
                            loadingXoaTemplate.close();
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.$emit('xoaThanhCong')
                                this.thongBao("success", data.data.rd);
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
            chinhSuaThanhCong(e) {
                this.hien_thi_chinh_sua_bao_cao = false;
                this.hien_thi_xuat_bao_cao = false;
                this.getThongTinBaoCao(e);
                this.$emit('themThanhCong')
            },
            taiXuongFileTemplate(e) {
                console.log(JSON.stringify(e));
                console.log(JSON.stringify(this.thongtin));
                let diaChiFile = this.thongtin.tenMien + e;
                window.open(diaChiFile);
            },
            themBaoCaoThanhCong() {
                console.log("Thêm báo cáo thành công");
            },
            ChinhSuaTemplateLapDong() {
                console.log("Chỉnh sửa template báo cáo lặp dòng");
                var idbc = this.idBaoCao;
                let uri = '/analytic-template-edit?id=' + idbc;
                window.open(uri);
            },
            ChinhSuaTemplate() {
                const loadingChinhSuaTemplate = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                var idbc = this.idBaoCao;
                let params = {
                    "id": this.idBaoCao,
                };
                rest_api.get("/csdlgd-analytic-api/BcChiTiet/convertExcelFileToHtml", params, (response) => {
                    loadingChinhSuaTemplate.close();
                    let dataHtml = response.data.item;
                    console.log("dữ liệu trả về:");
                    console.log(response);
                    if (response.data.rc == 0) {
                        this.thongBao('success', 'Vui lòng đợi trong giây lát')
                        $.ajax({
                            url: '/submit-data-sso',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                dataHtml: dataHtml,
                            }
                        }).done(function (ketqua) {
                            if (ketqua.code == 0) {
                                console.log("Kết quả trả về hàm post:")
                                let uri = '/analytic-template-edit?id=' + idbc;
                                window.open(uri, '_blank');
                            } else {
                                this.thongBao('error', 'Vui lòng thử lại.')
                            }
                        });
                    } else {
                        this.thongBao('error', 'Hệ thống đang bận. Vui lòng thử lại sau.');
                    }
                });
            },
            XuatBaoCao() {
                console.log("Xuất báo cáo");
                this.hien_thi_xuat_bao_cao = true;
            },
            chinhSuaBaoCao() {
                console.log("Chỉnh sửa báo cáo");
                this.hien_thi_chinh_sua_bao_cao = false;
                this.hien_thi_xuat_bao_cao = false;
                this.hien_thi_chinh_sua_bao_cao = true;
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
                        this.getFullTruongHoc();
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
                        this.getThongTinBaoCao(this.item);
                    } else {
                        this.danh_sach_truong_hoc_full = [];
                    }
                });
            },
            getThongTinNhomCha(e) {
                const loadingLayThongTinNhomCha = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let idNhomCha = e.analyticReportGroupId;
                let params = {
                    id: idNhomCha
                }
                rest_api.get("/csdlgd-analytic-api/nhomBc/getBc", params, (data) => {
                    loadingLayThongTinNhomCha.close();
                    if (data.data.rc == 0) {
                        let dt = data.data.item;
                        console.log("thông tin nhóm cha 12");
                        this.danh_sach_don_vi_duoc_phep = dt.donViList;
                        console.log(this.danh_sach_don_vi_duoc_phep);
                        this.mapDonViDuocPhep(this.danh_sach_don_vi_duoc_phep)
                        this.danh_sach_cap_hoc_duoc_phep = dt.capHocList;
                        this.mapCapHocDuocPhep(this.danh_sach_cap_hoc_duoc_phep)
                        this.danh_sach_truong_hoc_duoc_phep = dt.maTruongList;
                        this.mapTruongHocDuocPhep(this.danh_sach_truong_hoc_duoc_phep)
                    } else {}
                });
            },
            mapTruongHocDuocPhep(e) {
                let dt = [];
                if (e) {
                    dt = e;
                }
                this.danh_sach_truong_hoc_duoc_phep_ot = [];
                console.log("map danh sách trường học được phép 3:");
                if (dt.length > 0) {
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.danh_sach_truong_hoc_full.length; j++) {
                            if (dt[i] == this.danh_sach_truong_hoc_full[j].value) {
                                this.danh_sach_truong_hoc_duoc_phep_ot.push(this.danh_sach_truong_hoc_full[j])
                            }
                        }
                    }
                } else {
                    this.danh_sach_truong_hoc_duoc_phep_ot = this.danh_sach_truong_hoc_full;
                }
            },
            mapCapHocDuocPhep(e) {
                let dt = [];
                if (e) {
                    dt = e;
                }
                this.danh_sach_cap_hoc_duoc_phep_ot = [];
                console.log("map danh sách cấp học được phép:");
                console.log(JSON.stringify(e));
                if (dt.length > 0) {
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.danh_sach_cap_hoc_full.length; j++) {
                            if (dt[i] == this.danh_sach_cap_hoc_full[j].id) {
                                this.danh_sach_cap_hoc_duoc_phep_ot.push(this.danh_sach_cap_hoc_full[j])
                            }
                        }
                    }
                } else {
                    this.danh_sach_cap_hoc_duoc_phep_ot = this.danh_sach_cap_hoc_full;
                }
            },
            mapDonViDuocPhep(e) {
                this.danh_sach_don_vi_duoc_phep_ot = [];
                console.error("map danh sách đơn vị được phép 5:");
                let dt = [];
                if (e) {
                    dt = e;
                }
                console.error(JSON.stringify(dt));
                if (dt.length > 0) {
                    for (let i = 0; i < dt.length; i++) {
                        for (let j = 0; j < this.danh_sach_don_vi_full.length; j++) {
                            if (dt[i] == this.danh_sach_don_vi_full[j].maDonVi) {
                                this.danh_sach_don_vi_duoc_phep_ot.push(this.danh_sach_don_vi_full[j])
                            }
                        }
                    }
                } else {
                    this.danh_sach_don_vi_duoc_phep_ot = this.danh_sach_don_vi_full;
                }
            },
            getThongTinBaoCao(e) {
                const loadingGetThongTin = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.idBaoCao = e;
                let params = {
                    id: e
                }
                rest_api.get("/csdlgd-analytic-api/BcChiTiet/getBcChiTiet", params, (data) => {
                    loadingGetThongTin.close();
                    if (data.data.rc == 0) {
                        let thongtinbaocao = data.data.item;
                        this.thongTinBaoCao = data.data.item;
                        console.log("Thông tin báo cáo trả về:")
                        console.log(JSON.stringify(thongtinbaocao))
                        this.getThongTinNhomCha(thongtinbaocao)
                    } else {}
                });
            }
        },
    };

</script>
<style scope="scoped">
    .dts-col {
        margin-top: 5px;
    }

    .el-input.is-disabled .el-input__inner {
        color: #303133 !important;
    }

    .dp-none {
        display: none !important;
    }

</style>

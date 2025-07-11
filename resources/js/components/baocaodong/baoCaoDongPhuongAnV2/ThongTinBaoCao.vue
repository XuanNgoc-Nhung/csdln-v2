<template>
    <div style="padding:12px" v-loading.fullscreen.lock="loading" :element-loading-text="loadingText"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <p v-loading="!thongTinBaoCao.name" style="font-size:18px !important; color:blue">
            {{thongTinBaoCao.name}}</p>
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <el-col :span="16">
                    <label class="typo__label">Đơn vị <sup class="red"><b>*</b></sup></label>
                    <div>
                        <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags v-model="donVi" @change="ChonDonVi"
                            :placeholder="'Chọn'" filterable :data="danh_sach_don_vi" :fields="['name','value']" />
                    </div>
                </el-col>
                <el-col :span="8">
                    <label class="typo__label">Cấp học  <sup class="red"><b>*</b></sup></label>
                    <div>
                        <eselect style="width:100%" multiple :disabled="thongtin.role==5" collapseTags v-model="capHoc" @change="ChonDonVi"
                            :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc" :fields="['name','id']" />
                    </div>
                </el-col>
                <el-col :span="16">
                    <label class="typo__label">Trường học</label>
                    <div>
                        <eselect style="width:100%" multiple :disabled="thongtin.role==5" collapseTags v-model="truongHoc" :placeholder="'Chọn'"
                            filterable :data="danh_sach_truong_hoc" :fields="['name','value']" />
                    </div>
                </el-col>
                <el-col :span="8">
                    <label class="typo__label">Năm học <sup class="red"><b>*</b></sup></label>
                    <div>
                        <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                            :data="danh_sach_nam_hoc" :fields="['name','id']" />
                    </div>
                </el-col>
                <el-col :span="8">
                    <label class="typo__label">Học kỳ</label>
                    <div>
                        <eselect style="width:100%" collapseTags v-model="hocKy" :placeholder="'Chọn'" filterable
                            :data="danh_sach_hoc_ky" :fields="['name','value']" />
                    </div>
                </el-col>
                <el-col :span="8">
                    <label class="typo__label">Giai đoạn</label>
                    <div>
                        <eselect style="width:100%" collapseTags v-model="giaiDoan" :placeholder="'Chọn'" filterable
                            :data="danh_sach_giai_doan" :fields="['name','value']" />
                    </div>
                </el-col>
                <el-col :span="24" class="text-center">
                    <el-button type="success" size="mini" @click.prevent="xemOnline">Xem online
                    </el-button>
                    <el-button type="primary" size="mini" @click.prevent="taiXuong">Tải xuống
                    </el-button>
                    <div v-if="false">
                        <el-button type="danger" size="mini" @click.prevent="xoaBaoCao">Xóa</el-button>
                        <el-button size="mini" type="warning" @click="chinhSuaBaoCao">Chỉnh sửa</el-button>
                        <el-button size="mini" type="primary" @click.prevent="ChinhSuaTemplate">Chỉnh sửa template
                        </el-button>
                    </div>
                </el-col>
            </el-row>
        </div>
        <div>
            <ChinhSuaBaoCao :show="hien_thi_chinh_sua_bao_cao" :item="idBaoCao" @success="chinhSuaThanhCong($event)"
                @close="hien_thi_chinh_sua_bao_cao=false">
            </ChinhSuaBaoCao>
        </div>
    </div>
</template>
<script>
    import constant from '../../../utils/constant';
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
    import ChinhSuaBaoCao from './ChinhSuaBaoCao';
    export default {
        props: [
            'item'
        ],
        components: {
            'eselect': ESelectVue,
            'ChinhSuaBaoCao': ChinhSuaBaoCao,
        },
        data() {
            return {
                baseLink: "/view-excel?path=",
                hien_thi_chinh_sua_bao_cao: false,
                loading: false,
                loadingText: "Loading...",
                thongTinBaoCao: {},
                idBaoCao: "",
                donVi: [],
                capHoc: [],
                truongHoc: [],
                namHoc: '',
                hocKy: '',
                giaiDoan: '',
                thongtin: JSON.parse(window.userInfo),
                danh_sach_don_vi: [],
                danh_sach_cap_hoc: window.listCapHoc,
                danh_sach_truong_hoc: [],
                danh_sach_nam_hoc: constant.LIST_YEARS_FULL,
                danh_sach_hoc_ky: [{
                        name: "Học kỳ I",
                        value: 1
                    },
                    {
                        name: "Học kỳ II",
                        value: 2
                    },
                    {
                        name: "Cả năm",
                        value: 3
                    },
                ],
                danh_sach_giai_doan: [{
                    name: "Giữa kỳ I",
                    value: "GK1"
                }, {
                    name: "Cuối kỳ I",
                    value: "CK1"
                }, {
                    name: "Giữa kỳ II",
                    value: "GK2"
                }, {
                    name: "Cuối kỳ II",
                    value: "CK2"
                }],
            };
        },
        watch: {
            item: function (newVal) {
                if (newVal) {
                    console.log("item thay đổi")
                    this.idBaoCao = newVal;
                    this.getThongTinBaoCao(this.idBaoCao);
                }
            },
        },
        mounted: function () {
            this.getThongTinBaoCao(this.item);
            this.namHoc = this.thongtin.namHocHienTai;

        },
        methods: {
            chinhSuaThanhCong(e) {
                this.hien_thi_chinh_sua_bao_cao = false;
                this.getThongTinBaoCao(e);
                this.$emit('themThanhCong')
            },
            chinhSuaBaoCao() {
                console.log("Ấn chỉnh sửa báo cáo")
                this.idBaoCao = this.item;
                this.hien_thi_chinh_sua_bao_cao = true;
            },
            xoaBaoCao() {
                console.log("xóa báo cáo");
                var url = "/csdlgd-analytic-api/BcChiTiet/deleteBcChiTiet";
                let params = {
                    "id": this.item
                }
                this.$confirm('Xác nhận xóa báo cáo?', 'Xóa báo cáo', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass:'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.loadingText = "Đang xoá...";
                        this.loading = true;
                        rest_api.post(url, params, (
                            data) => {
                            this.loading = false;
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                    this.thongBao("success", data.data.rd);
                                this.$emit('xoaThanhCong')
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            xemOnline() {
                if (!this.donVi || this.donVi.length == 0) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin đơn vị.')
                    return;
                }
                if (!this.capHoc || this.capHoc.length == 0) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin cấp học.')
                    return;
                }
                if (!this.namHoc || this.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin năm học.')
                    return;
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    "capHoc": String(this.capHoc),
                    "hocKy": this.hocKy,
                    "maGiaiDoan": this.giaiDoan,
                    "maDonVis": this.donVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.truongHoc,
                    "namHoc": this.namHoc,
                    "id": this.item
                }
                if (this.hocKy && this.hocKy != "" && this.hocKy != null) {
                    params.hocKy = parseInt(this.hocKy);
                }
                rest_api.post("/csdlgd-analytic-api/download-excel/get-report-link", params, data => {

                    if (data.data.rc == 0) {
                        if (data.data.urlContext) {
                            this.thongBao('success', 'Đang mở trong thẻ mới...');
                            let uri = this.thongtin.tenMien + data.data.urlContext;
                            var d = new Date();
                            var n = d.getTime();
                            let url = this.baseLink + uri + '?t=' + n;
                            console.log("url")
                            console.log(url)
                            setTimeout(() => {
                                window.open(url, '_blank');
                                loading.close();
                            }, 1500);
                        } else {
                            this.thongBao('error', 'Báo cáo này chưa có dữ liệu');
                            loading.close();
                        }
                    } else {
                        this.thongBao('error',
                            'Mẫu báo cáo chưa được cấu hình điều kiện. Vui lòng chọn chức năng Cấu hình Template trước khi Xuất dữ liệu báo cáo!'
                        )
                        loading.close();
                    }
                });
            },
            taiXuong() {

                if (!this.donVi || this.donVi.length == 0) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin đơn vị.')
                    return;
                }
                if (!this.capHoc || this.capHoc.length == 0) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin cấp học.')
                    return;
                }
                if (!this.namHoc || this.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin năm học.')
                    return;
                }
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.thongBao('success','Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        const loading = this.$loading({
                            lock: true,
                            text: 'Vui lòng chờ trong giây lát...',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        let params = {
                            "capHoc": String(this.capHoc),
                            "hocKy": this.hocKy,
                            "maGiaiDoan": this.giaiDoan,
                            "maDonVis": this.donVi,
                            "maSo": this.thongtin.ma_so,
                            "maTruongs": this.truongHoc,
                            "namHoc": this.namHoc,
                            "id": this.item
                        }
                        if (this.hocKy && this.hocKy != "" && this.hocKy != null) {
                            params.hocKy = parseInt(this.hocKy);
                        }
                        rest_api.post("/csdlgd-analytic-api/download-excel/get-report-link", params, data => {
                            if (data.data.rc == 0) {
                                if (data.data.urlContext) {
                                    this.thongBao('success', 'Đang lưu file...');
                                    let uri = this.thongtin.tenMien + data.data.urlContext;
                                    var d = new Date();
                                    var n = d.getTime();
                                    let url = uri + '?t=' + n;
                                    setTimeout(() => {
                                        window.open(url);
                                        loading.close();
                                    }, 500);
                                } else {
                                    loading.close();
                                    this.thongBao('error', 'Báo cáo này chưa có dữ liệu');
                                }
                            } else {
                                loading.close();
                                this.thongBao('error',
                                    'Mẫu báo cáo chưa được cấu hình điều kiện. Vui lòng chọn chức năng Cấu hình Template trước khi Xuất dữ liệu báo cáo!'
                                )
                            }
                        });
                    })
                    .catch(_ => {});
            },
            ChonDonVi() {
                console.log("chọn đơn vị");
                this.truongHoc = [];
                this.danh_sach_truong_hoc = [];
                this.getTruongHoc();
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
            getDonVi() {
                this.loadingText = "Lấy thông tin đơn vị."
                this.loading = true;
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    this.loading = false;
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    " - [" + data.data.rows[i].maDonVi +
                                    "]",
                                value: data.data.rows[i].maDonVi,
                            }
                            data_demo.push(obj);
                        }
                        this.danh_sach_don_vi = data_demo;
                    }
                });
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
            getTruongHoc() {
                this.loadingText = "Lấy thông tin trường học."
                this.loading = true;
                let params = {
                    maDonVi: this.donVi,
                    capHoc: this.capHoc,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    this.loading = false;
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
                    } else {
                        this.danh_sach_truong_hoc = [];
                    }
                });
            },
            getThongTinBaoCao(e) {
                this.loadingText = "Lấy thông tin báo cáo";
                this.idBaoCao = e;
                let params = {
                    id: e
                }
                this.loading = true;
                rest_api.get("/csdlgd-analytic-api/BcChiTiet/getBcChiTiet", params, (response) => {
                    this.loading = false;
                    if (response.data.rc == 0) {
                        this.thongTinBaoCao = response.data.item;
                        if (this.thongTinBaoCao) {
                            this.capHoc = this.thongTinBaoCao.capHocList;
                            this.donVi = this.thongTinBaoCao.donViList;
                            this.maTruong = this.thongTinBaoCao.maTruongList;
                            this.getDonVi();
                            this.getTruongHoc();
                            if(this.thongtin.role==5){
                                console.log('Đăng nhập bằng tài khoản trường:')
                                console.warn(this.thongtin)
                                this.donVi = [this.thongtin.ma_don_vi];
                                this.capHoc = this.thongtin.listCapHoc;
                                this.truongHoc = [this.thongtin.ma_truong_hoc];
                                console.error('Thông tin đơn vị:')
                                console.error(this.donVi)
                            }
                        }
                    } else {

                        this.getDonVi();
                        this.getTruongHoc();
                        this.thongBao('error', response.data.rd)
                    }
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

<template>
    <div>
        <Breadcrumb :menu="'Báo cáo'" :desc="'Báo cáo EMIS'" />

        <div class="card-bieu-do">
            <form role="form">
                <el-row :gutter="24">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-form ref="ruleForm">
                        <el-col :sm="24" :lg="12">
                            <label class="typo__label">Đơn vị quản lý</label>
                            <eselect style="width:100%" @change="chonCapHoc" collapseTags :disabled="thongtin.role>3"
                                v-model="maPhongSelected" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :lg="6">
                            <label class="typo__label">Cấp học </label>
                            <el-tooltip content="Tham số cấp học chỉ hỗ trợ cho việc tra cứu danh sách trường học" placement="top">
                                <a class="helpText"><i class="el-icon-info"></i></a>
                            </el-tooltip>
                            <eselect multiple style="width:100%" collapseTags v-model="capHoc" :placeholder="'Chọn'"
                                @change="chonCapHoc" :disabled="thongtin.role==5" filterable :data="list_cap_hoc"
                                :fields="['name','id']" />
                        </el-col>

                        <el-col  :sm="12" :lg="6">
                            <label class="typo__label">Năm học <sup class="red">*</sup></label>
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :sm="24" :lg="12">
                            <label class="typo__label">Trường học</label>
                            <eselect style="width:100%" collapseTags v-model="truongHoc" :disabled="thongtin.role==5"
                                     :placeholder="'Chọn'" filterable :data="ds_truong_hoc" :fields="['name','value']" />
                        </el-col>
                    </el-form>
                    <!-- Hết năm học -->
                    <el-col :span="24">
                        <div class="text-center">
                            <el-button class="bt-chinh" size="mini" type="success" @click.prevent="getListReport">
                                Tìm kiếm
                            </el-button>
                        </div>
                    </el-col>
                </el-row>

            </form>
        </div>
        <div class="card-bieu-do" v-if="listCateReport.length>0">
            <el-row :gutter="24">
                <el-col :span="24">
                    <el-tabs type="border-card2">
                        <el-tab-pane v-for="(nd,i) in listCateReport" :key="i">
                            <span slot="label"> {{ nd.category }}</span>
                            <p>Ghi chú: - Để thống kê báo cáo Emis đầu năm. Trường nộp dữ liệu cấp sở ,vui lòng chọn nộp
                                "Kết
                                quả cân
                                đo-Sức khỏe" Kỳ báo cáo : Giữa năm trên Quản lý nhà trường.</p>

                            <h4 class="pt-10 title-18" style="margin-bottom: 20px">Danh sách báo cáo EMIS</h4>
                            <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background: #e4ebf5; text-align:center">
                                        <th class="text-center">
                                            <p>STT</p>
                                        </th>

                                        <th>
                                            <p>Tên báo cáo</p>
                                        </th>
                                        <th>
                                            <p>Mã báo cáo</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Thao tác</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="nd.children.length>0">
                                    <tr v-for="(ndbc, index) in nd.children" :key="index">
                                        <td class="text-center">
                                            <p>{{ index + 1 }}</p>
                                        </td>

                                        <td>
                                            <p>
                                                {{ ndbc.tenBaoCao }}</p>
                                        </td>
                                        <td class="text-left">
                                            <p>
                                                {{ ndbc.maBaoCao }}</p>
                                        </td>
                                        <td class="text-center">
                                            <!-- <el-button size="mini" type="primary" :disabled="isDisabled"
                                                       @click.prevent="showInFo(ndbc)">Xem báo cáo
                                            </el-button>
                                            <el-button type="primary" size="mini"
                                                       v-if="thongtin.role!=20&&thongtin!=40"
                                                       @click.prevent="getExcel(ndbc.xlsxFile)">Xuất excel
                                            </el-button> -->

                                            <el-tooltip content="Xem báo cáo" placement="top">
                                                <i @click.prevent="showInFo(ndbc)" :disabled="isDisabled"
                                                   class="el-icon-view"></i>
                                            </el-tooltip>
                                            <el-tooltip content="Xuất excel" placement="top"
                                                        v-if="thongtin.role!=20&&thongtin!=40">
                                                <i @click.prevent="getExcel(ndbc.xlsxFile)"
                                                   class="el-icon-download"></i>
                                            </el-tooltip>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <p>Không có danh sách báo cáo</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </el-tab-pane>
                    </el-tabs>
                </el-col>
            </el-row>
        </div>
        <div v-else class="card-bieu-do">
            <div class="responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead></thead>
                    <tbody>
                        <tr>
                            <td colspan="11" class="text-center">
                                <p>Không có dữ liệu</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="false">
            <div class="row">
                <div class="col-md-12">
                    <p>
                        <span style="color:blue"><b>Ghi chú:</b></span>
                        <span style="color:#DC0101">1</span>
                        - Tham số cấp học chỉ hỗ trợ cho việc tra cứu danh sách trường học. <br>
                        - Để thống kê báo cáo Emis đầu năm. Trường nộp dữ liệu cấp sở ,vui lòng chọn nộp "Kết quả cân
                        đo-Sức khỏe" Kỳ báo cáo : Giữa năm trên Quản lý nhà trường.
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import Vue from 'vue';
    import ESelectVue from '../ui/ESelect.vue';
    import constant from "../../utils/constant";
    import ElementUI from 'element-ui';
    import Breadcrumb from '../ui/Breadcrumb.vue';

    Vue.use(ElementUI);
    export default {
        props: ['info'],
        components: {
            'eselect': ESelectVue,
            Breadcrumb
        },
        data() {
            return {
                ojDonVi: "",
                capHoc: "",
                truongHoc: "",
                date: new Date(),
                listCateReport: [],
                maPhongSelected: "",
                tenSoDangNhap: "",
                demo: "#idBaoCao",
                id: "idBaoCao",
                ct: "cate",
                idmenu: "#menu",
                menu: "menu",
                active_el: 0,
                ds_bao_cao: [],
                huong_dan: false,
                list_don_vi: [],
                ds_truong_hoc: [],
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                isDisabled: false,
                ma_truong_hoc: "",
                ma_don_vi: "",
                cap_hoc: "",
                codeReport: "",
                namHoc: "",
                linkdowLoad: "",
                linkBaoCao: "",
                thongtin: {},
                bao_cao_dau_nam: [],
                bao_cao_cuoi_nam: [],
                bao_cao_nam: []
            }
        },
        watch: {
            ojDonVi: function (newVal) {
                console.log("thay đổi đơn vị");
                console.log(JSON.stringify(newVal));
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            console.log("thông tin đăng nhập");
            console.log(JSON.stringify(this.thongtin));
            this.namHoc = this.thongtin.namHocHienTai;
            console.log(this.thongtin);
            this.ma_don_vi = this.thongtin.province;
            this.getDonVi();
            this.getTruongHoc();
            if (this.thongtin.role >= 3) {
                this.maPhongSelected = this.thongtin.ma_don_vi;
            }
            if (this.thongtin.role == 5) {
                this.truongHoc = this.thongtin.ma_truong_hoc;
                this.capHoc = this.thongtin.listCapHoc
            }
            this.getListReport();
        },
        methods: {
            getTruongHoc() {
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                let params = {
                    capHoc: [],
                    maDonVi: []
                };
                if (this.maPhongSelected) {
                    params.maDonVi = [this.maPhongSelected]
                }
                if (this.capHoc) {
                    params.capHoc = this.capHoc
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    // loading.close();
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
            chonCapHoc() {
                this.ds_truong_hoc = [];
                this.truongHoc = "";
                this.getTruongHoc();
            },
            activate: function (el) {
                this.active_el = el;
            },
            getDonVi() {
                this.list_don_vi = [];
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.province
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    if (data.data.statusResponse == 0 && data.data.rows.length > 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            console.log("console.log");
                            let obj = {
                                name: data.data.rows[i].tenDonVi + ' - [' + data.data.rows[i].maDonVi +
                                    ']',
                                value: data.data.rows[i].maDonVi,
                                so_dang_nhap: data.data.rows[i].tenTinhThanh,
                                ma_so: data.data.rows[i].maTinhThanh,
                            }
                            this.list_don_vi.push(obj);
                        }

                    }
                });
            },
            getListReport() {
                this.listCateReport = [];
                if (!this.namHoc) {
                    this.thongBao('error', 'Thiếu thông tin năm học.')
                    return;
                }
                let params = {
                    "namHoc": this.namHoc,
                    "maPhongSelected": this.maPhongSelected,
                    "maTruongSelected": this.truongHoc,
                    "tenBaoCao": "baoCaoEmis"
                };
                console.log("param:" + JSON.stringify(params));
                const loadingBaoCao = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-report-api/danhSachBaoCao", params, (data) => {
                    loadingBaoCao.close();
                    console.log("trả về");
                    this.listCateReport = data.data;
                    console.log(JSON.stringify(this.listCateReport))
                    if (this.listCateReport.length > 0) {
                        // this.thongBao('success', 'Lấy dữ liệu báo cáo thành công.')
                    } else {
                        // this.thongBao('error', 'Không tìm thấy bản ghi nào.')
                    }
                });
            },
            getReportRole(e) {
                if (e.xlsxFileContext) {
                    this.linkBaoCao = this.thongtin.tenMien + e.xlsxFileContext;
                    this.codeReport = this.linkBaoCao;

                    let baseLink = "/view-excel?path="
                    if (this.thongtin.ma_so == 36) {
                        console.log('Xem online office:')
                        baseLink = 'https://view.officeapps.live.com/op/view.aspx?src='
                    }
                    let urlView = baseLink + this.linkBaoCao;
                    window.open(urlView, "_blank");
                } else {
                    this.isDisabled = true;
                    let params = {
                        "loaiBaoCao": "baoCaoEmis",
                        "maBaoCao": e.maBaoCao,
                        "namHoc": this.namHoc
                    };
                    if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                        params.parentRole = 20;
                    }
                    if (this.thongtin.role == 4) {
                        params.parentRole = 40
                    }
                    this.thongBao('success', 'Dang tổng hợp báo cáo. Vui lòng chờ...')
                    const loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    rest_api.get("/csdlgd-report-api/danhSachBaoCao/getBanTo", params, (data) => {
                        loading.close();
                        console.log("tv:" + JSON.stringify(data));
                        this.isDisabled = false;
                        if (data.data.rc == 0) {
                            if (data.data.item != "") {
                                this.linkBaoCao = data.data.item;
                                this.codeReport = this.linkBaoCao;

                                let baseLink = "/view-excel?path="
                                if (this.thongtin.ma_so == 36) {
                                    console.log('Xem online office:')
                                    baseLink = 'https://view.officeapps.live.com/op/view.aspx?src='
                                }
                                let urlView = baseLink + this
                                    .linkBaoCao;
                                console.log('xem....')
                                window.open(urlView, "_blank");
                            } else {
                                this.linkBaoCao = "";

                                this.thongBao('error', 'Báo cáo này chưa có thông tin.')
                            }
                        } else {
                            this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
                        }
                    });
                }
            },
            //
            showInFo(e) {
                console.log("thông tin bẳn:" + JSON.stringify(e));
                if (this.thongtin.role2 != 1 && this.thongtin.role2 != 2 && this.thongtin.role2 != 3 && this.thongtin
                    .role2 != 4 && this.thongtin.role2 != 5) {
                    console.log("check");
                    this.getReportRole(e);
                } else {
                    if (e.xlsxFile == "") {
                        this.thongBao('error', 'Báo cáo này chưa có dữ liệu.')
                        return;
                    }
                    let baseLink = "/view-excel?path="
                    if (this.thongtin.ma_so == 36) {
                        console.log('Xem online office:')
                        baseLink = 'https://view.officeapps.live.com/op/view.aspx?src='
                    }
                    let urlView = baseLink + e.xlsxFile;
                    console.log("link excel = " + urlView)
                    window.open(urlView, "_blank");
                }
                console.log("xem chi tiết của mã:" + e);
            },
            getExcel(e) {
                if (e == "") {
                    this.thongBao('error', 'Báo cáo này chưa có dữ liệu.')
                    return;
                }
                window.open(e, '_blank');
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
        }
    }

</script>
<style scoped="scoped">
    .active a {
        background: rgb(228, 235, 245) !important;
    }

    .nav-tabs>li {
        display: grid;
    }

    .tbc>a {
        color: blue;
        font-weight: bold;
        font-size: 16px;
        border: 1px solid;
        display: block;
        height: 100%;
        padding: 7px;
        text-align: center;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        margin: 0 auto;
        background: #f6f6f6;
    }

    .el-input.is-disabled .el-input__inner {
        color: #303133 !important;
    }

</style>

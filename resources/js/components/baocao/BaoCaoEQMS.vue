<template>
    <div>
        <Breadcrumb :menu="'Báo cáo'" :desc="'Báo cáo EQMS'" />
        <!-- form search -->
        <div class="card-bieu-do">
            <el-form ref="ruleForm">
                <el-row :gutter="24">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12">
                        <label class="typo__label">Đơn vị quản lý</label>
                        <eselect style="width:100%" collapseTags v-model="maPhongSelected" @change="chonCapHoc"
                                 :disabled="thongtin.role!=2" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                 :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="12" :sm="12" :md="12" :lg="6">
                        <label class="typo__label">Cấp học</label>
                        <el-tooltip content="Tham số cấp học chỉ hỗ trợ cho việc tra cứu danh sách trường học" placement="top">
                            <a class="helpText"><i class="el-icon-info"></i></a>
                        </el-tooltip>
                        <eselect style="width:100%" multiple collapseTags v-model="capHoc" @change="chonCapHoc"
                                 :disabled="thongtin.role==5" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                                 :fields="['name','id']" />
                    </el-col>
                    <el-col :xs="12" :sm="12" :md="6" :lg="6">
                        <label class="typo__label">Năm học <span style="color:#DC0101">*</span> </label>
                        <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                 :data="list_nam_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="12" :lg="12">
                        <label class="typo__label">Trường học</label>
                        <eselect style="width:100%" collapseTags v-model="truongHoc" :disabled="thongtin.role==5"
                                 :placeholder="'Chọn'" filterable :data="ds_truong_hoc" :fields="['name','value']" />
                    </el-col>

                    <el-col :span="24" class="text-center">
                        <el-button size="mini" @click.prevent="getListReport()" type="success">
                            Tìm kiếm
                        </el-button>
                    </el-col>

                </el-row>

            </el-form>
         
        </div>
        <div v-if="listCateReport.length>0" class="card-bieu-do" style="margin-top:16px">
            <el-row :gutter="24">
                <el-col :span="24">
                    <el-tabs type="border-card2">
                        <el-tab-pane v-for="(nd,i) in listCateReport" :key="i" :label="nd.category">
                            <span slot="label"> {{ nd.category }}</span>

                            <h4  class="title-18" style="margin-top: 5px;margin-bottom: 20px">Danh sách báo cáo EQMS</h4>
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
                                        <td class="">
                                            <p>
                                                {{ ndbc.maBaoCao }}</p>
                                        </td>
                                        <td class="text-center">

                                            <el-tooltip content="Xem báo cáo" placement="top">
                                                <i @click.prevent="showInFo(ndbc)" :disabled="isDisabled"
                                                   class="el-icon-view"></i>
                                            </el-tooltip>
                                            <el-tooltip content="Xuất excel" placement="top"
                                                        v-if="thongtin.role!=20&&thongtin!=40">
                                                <i @click.prevent="getExcel(ndbc)" class="el-icon-download"></i>
                                            </el-tooltip>
                                            <!-- <el-button size="mini" @click.prevent="showInFo(ndbc)"
                                                               :disabled="isDisabled" type="primary">
                                                        Xem báo cáo
                                                    </el-button>
                                                    <el-button size="mini" v-if="thongtin.role!=20&&thongtin!=40"
                                                               @click.prevent="getExcel(ndbc)" type="primary">
                                                        Xuất excel
                                                    </el-button> -->
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
                    <el-tab-pane v-for="(nd,i) in []" :key="i">
                        <span slot="label">
                            <!-- {{(i+1)+'. '+ nd.category}} -->
                        </span>
                    </el-tab-pane>
                </el-col>
            </el-row>
        </div>
        <div v-else>
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
                    <p><span style="color:blue"><b>Ghi chú:</b></span> <span style="color:#DC0101">1</span> - Tham số
                        cấp
                        học chỉ hỗ trợ cho việc tra cứu danh sách trường học. </p>
                </div>
            </div>
        </div>
        <div v-if="show_info">
            <XemBaoCao :show="show_info" :item="codeReport" @close="show_info=false"></XemBaoCao>
        </div>
        <XuatBaoCao :show="hien_thi_xem_bao_cao_dong" :donvi="maPhongSelected" :caphoc="capHoc" :truonghoc="truongHoc"
            @close="hien_thi_xem_bao_cao_dong=false" :item="idBaoCaoDong"></XuatBaoCao>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import ESelectVue from '../ui/ESelect.vue';
    import array_util from '../../utils/array_utils';
    import Vue from 'vue';
    import XuatBaoCao from './xuatBaoCaoEqms';
    import constant from "../../utils/constant";
    import XemBaoCao from './baocaochobo/ViewBaoCao'
    import ElementUI from 'element-ui';
    import Breadcrumb from '../ui/Breadcrumb.vue';

    Vue.use(ElementUI);
    export default {
        props: ['info'],
        components: {
            "XemBaoCao": XemBaoCao,
            "XuatBaoCao": XuatBaoCao,
            'eselect': ESelectVue,
            Multiselect,
            Breadcrumb
        },
        data() {
            return {

                ojDonVi: "",
                capHoc: [],
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
                thongtin: {},
                hien_thi_xem_bao_cao_dong: false,
                idBaoCaoDong: "60642fe95362d4ce5aa5e22e",
                list_don_vi: [],
                ds_truong_hoc: [],
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                isDisabled: false,
                show_info: false,
                ma_truong_hoc: "",
                ma_don_vi: "",
                cap_hoc: "",
                codeReport: "",
                danhSachNamHoc: "",
                namHoc: "",
                linkdowLoad: "",
                linkBaoCao: "",
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
            this.namHoc = this.thongtin.namHocHienTai;
            this.ma_don_vi = this.thongtin.province;
            this.getDonVi();
            this.getTruongHoc();
            if (this.thongtin.role == 5) {
                this.truongHoc = this.thongtin.ma_truong_hoc
                this.capHoc = this.thongtin.listCapHoc;
            }
            if (this.thongtin.role > 3) {
                this.maPhongSelected = this.thongtin.ma_don_vi
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
            // định nghĩa cho năm học
            setNameNamHoc({
                name
            }) {
                return `${name}`
            },

            nameWithLang({
                tenDonVi,
                maDonVi
            }) {
                return `${tenDonVi} - [${maDonVi}]`
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
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (data.data.statusResponse == 0 && data.data.rows.length > 0) {
                        let demo = data.data.rows;
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
                        console.log("danh sách đơn vị:");
                        console.log(this.list_don_vi);
                        // for (let i = 0; i < this.list_don_vi.length; i++) {
                        //     console.log("giá trị:" + this.list_don_vi[i].value);
                        //     if (this.list_don_vi[i].value == this.thongtin.ma_don_vi) {
                        //         // this.tenSoDangNhap = this.list_don_vi[i].so_dang_nhap;
                        //         this.maPhongSelected = this.list_don_vi[i].value;
                        //     }
                        // }
                    }
                });
            },
            getListReport() {
                this.listCateReport = [];
                if (!this.namHoc) {
                    this.thongBao('error', 'Vui lòng chọn năm học để lấy danh sách báo cáo.')
                    return;
                }
                let params = {
                    "namHoc": this.namHoc,
                    "maPhongSelected": this.maPhongSelected,
                    "maTruongSelected": this.truongHoc,
                    "tenBaoCao": "baoCaoEQMS"
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
                    this.listCateReport = data.data;
                    if (data.data) {
                        let list_bao_cao = data.data;
                        console.log("Báo cáo tạm:");
                        console.log(list_bao_cao);
                        let obj = {
                            "maBaoCao": "eqms-giua-nam-ck1-khoi1",
                            "capHoc": 1,
                            "hocKy": 1,
                            "maGiaiDoan": "CK1",
                            "idBaoCao": "60642fe95362d4ce5aa5e22e",
                            "type": "baocaodong",
                            "roles": [
                                1,
                                2,
                                3,
                                4,
                                5,
                                20,
                                40,
                                2022,
                                2028,
                                2029
                            ],
                            "capHocList": [
                                1
                            ],
                            "tenBaoCao": "Báo cáo thống kê kết quả học tập khối 1 của trường tiểu học cuối kì 1 (TT27)",
                        };
                        let obj2 = {
                            "maBaoCao": "eqms-cuoi-nam-ck2-khoi1",
                            "capHoc": 1,
                            "hocKy": 2,
                            "maGiaiDoan": "CK2",
                            "idBaoCao": "609e40d55362d41840d53a14",
                            "type": "baocaodong",
                            "roles": [
                                1,
                                2,
                                3,
                                4,
                                5,
                                20,
                                40,
                                2022,
                                2028,
                                2029
                            ],
                            "capHocList": [
                                1
                            ],
                            "tenBaoCao": "Báo cáo thống kê kết quả học tập khối 1 của trường tiểu học cuối kì 2 (TT27)",

                        }

                        // list_bao_cao[0].children.push(obj);
                        // list_bao_cao[0].children.push(obj2);
                        console.log("check xem nếu trường tiểu học thì mới push")
                        console.log(JSON.stringify(this.thongtin))
                        let checkPush = false;
                        if (this.thongtin.listCapHoc == null || this.thongtin.listCapHoc.length == 0) {
                            checkPush = true;
                        } else {
                            for (let i = 0; i < this.thongtin.listCapHoc.length; i++) {
                                if (this.thongtin.listCapHoc[i] == 1) {
                                    checkPush = true;
                                }
                            }
                        }
                        console.log("Check push là:" + checkPush)
                        if (checkPush) {
                            this.listCateReport = list_bao_cao;
                        }
                        // this.thongBao('success', 'Lấy dữ liệu báo cáo thành công.')
                    } else {
                        // this.thongBao('error', 'Không tìm thấy bản ghi nào.')
                    }
                });
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
            getReportRole(e) {
                this.isDisabled = true;
                let params = {
                    "loaiBaoCao": "baoCaoEQMS",
                    "maBaoCao": e.maBaoCao,
                    "namHoc": this.namHoc
                };
                if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                    params.parentRole = 20;
                }
                if (this.thongtin.role == 4) {
                    params.parentRole = 40
                }
                this.thongBao('success', 'Đang tổng hợp báo cáo. Vui lòng chờ...')

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-report-api/danhSachBaoCao/getBanTo", params, (data) => {
                    console.log("tv:" + JSON.stringify(data));
                    this.isDisabled = false;
                    loading.close();
                    if (data.data.rc == 0) {
                        if (data.data.item != "") {
                            this.linkBaoCao = data.data.item;
                            console.log("gán xong link:");
                            console.log(JSON.stringify(this.linkBaoCao));
                            // this.show_info = true;
                            this.codeReport = this.linkBaoCao;

                            let urlView = "/view-excel?path=" + this
                                .linkBaoCao;
                            console.log("link excel = " + urlView)
                            window.open(urlView, "_blank");
                            console.log("hiện:" + this.show_info);
                        } else {
                            this.linkBaoCao = "";
                            this.thongBao('error', 'Báo cáo này chưa có thông tin.')
                        }
                    } else {
                        this.thongBao('error', 'Có lỗi xảy ra. Vui lòng thử lại sau.')
                    }
                });
            },
            //
            showInFo(e) {
                let baocao = e;
                if (baocao.type == 'baocaodong') {
                    const loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    let params = {
                        "capHoc": e.capHoc,
                        "hocKy": e.hocKy,
                        "maGiaiDoan": e.maGiaiDoan,
                        "maDonVi": this.maPhongSelected,
                        "maDonVis": [],
                        "maSo": this.thongtin.ma_so,
                        // "maTruongHoc": this.truongHoc,
                        "maTruongs": [],
                        "namHoc": this.namHoc,
                        "id": e.idBaoCao
                    }
                    if (this.thongtin.role == 5) {
                        params.maTruongHoc = this.thongtin.ma_truong_hoc
                    }
                    if (this.truongHoc && this.truongHoc != "") {
                        params.maTruongs = [this.truongHoc]
                    }
                    if (this.maPhongSelected && this.maPhongSelected != "") {
                        params.maDonVis = [this.maPhongSelected]
                    }
                    rest_api.post("/csdlgd-analytic-api/download-excel/get-report-link", params, data => {
                        loading.close();
                        if (data.data.rc == 0) {
                            if (data.data.urlContext) {
                                let baseLink = "/view-excel?path=";
                                if (this.thongtin.ma_so == 36) {
                                    baseLink = 'https://view.officeapps.live.com/op/view.aspx?src='
                                }
                                let linkExcel = baseLink + this.thongtin.tenMien + data.data.urlContext;
                                window.open(linkExcel, '_blank').focus();
                            } else {
                                this.thongBao('error', 'Báo cáo này chưa có dữ liệu.')
                            }
                        } else {

                            this.thongBao('error',
                                'Mẫu báo cáo chưa được cấu hình điều kiện. Vui lòng chọn chức năng Cấu hình Template trước khi Xuất dữ liệu báo cáo!'
                            )
                        }
                    });
                } else {
                    if (this.thongtin.role2 != 1 && this.thongtin.role2 != 2 && this.thongtin.role2 != 3 && this
                        .thongtin
                        .role2 != 4 && this.thongtin.role2 != 5 && this.truongHoc != "") {
                        console.log("check");
                        this.getReportRole(e);
                    } else {
                        if (e.xlsxFileContext == "") {
                            this.thongBao('error', 'Báo cáo này chưa có dữ liệu.')
                            return;
                        }
                        let baseLink = "/view-excel?path=";
                        if (this.thongtin.ma_so == 36) {
                            baseLink = 'https://view.officeapps.live.com/op/view.aspx?src='
                        }
                        let urlView = baseLink + this.thongtin.tenMien + e
                            .xlsxFileContext;
                        console.log("link excel = " + urlView)
                        window.open(urlView, "_blank");
                    }
                }
                console.log("thông tin bẳn:" + JSON.stringify(e));

                console.log("xem chi tiết của mã:" + e);
            },
            getExcel(e) {
                let data = e;
                if (data.type == "baocaodong") {
                    const loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    let params = {
                        "capHoc": data.capHoc,
                        "hocKy": data.hocKy,
                        "maGiaiDoan": data.maGiaiDoan,
                        "maDonVi": this.maPhongSelected,
                        "maDonVis": [],
                        "maSo": this.thongtin.ma_so,
                        // "maTruongHoc": this.truongHoc,
                        "maTruongs": [],
                        "namHoc": this.namHoc,
                        "id": data.idBaoCao
                    }
                    if (this.thongtin.role == 5) {
                        params.maTruongHoc = this.thongtin.ma_truong_hoc
                    }
                    if (this.truongHoc && this.truongHoc != "") {
                        params.maTruongs = [this.truongHoc]
                    }
                    if (this.maPhongSelected && this.maPhongSelected != "") {
                        params.maDonVis = [this.maPhongSelected]
                    }
                    rest_api.post("/csdlgd-analytic-api/download-excel/get-report-link", params, data => {
                        loading.close();
                        if (data.data.rc == 0) {
                            if (data.data.urlContext) {
                                let linkExcel = this.thongtin.tenMien + data.data.urlContext;
                                window.open(linkExcel, '_blank');
                            } else {
                                this.thongBao('error', 'Báo cáo này chưa có dữ liệu.')
                            }
                        } else {

                            this.thongBao('error',
                                'Mẫu báo cáo chưa được cấu hình điều kiện. Vui lòng chọn chức năng Cấu hình Template trước khi Xuất dữ liệu báo cáo!'
                            )
                        }
                    });

                } else {
                    let ex = this.thongtin.tenMien + data.xlsxFileContext
                    if (ex == "") {
                        this.thongBao('error', 'Báo cáo này chưa có dữ liệu.')
                        return;
                    }
                    window.open(ex, '_blank');
                }
            }
        }
    }

</script>
<style>
    p {
        font-size: 16px;
    }

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

    .el-tabs__item {
        font-size: 16px !important;
    }

</style>

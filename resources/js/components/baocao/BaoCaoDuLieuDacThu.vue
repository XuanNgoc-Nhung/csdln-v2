<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Báo cáo <span
                class="kytu"> &raquo;</span>  Báo cáo đặc thù</span>
            </div>
        </div>
        <!-- form search -->

        <form role="form">
            <div class="row">
                <!-- <div class="col-md-4"> <label class="typo__label">Chọn đơn vị:</label>
                <multiselect v-model="ojDonVi" :options="list_don_vi"
                :custom-label="nameWithLang" placeholder="Chọn đơn vị" label="maDonVi"
                track-by="maDonVi"></multiselect> </div> -->

                <!-- Năm học -->
                <div class="col-md-3 timkiem">
                    <label class="typo__label">Năm học</label>
                    <multiselect
                        v-model="danhSachNamHoc"
                        :options="list_nam_hoc"
                        :custom-label="setNameNamHoc"
                        placeholder="Chọn năm học"
                        label="name"
                        deselectLabel="Đã chọn"
                        selectLabel="Chưa chọn"
                        selectedLabel="Đã chọn"
                        track-by="name"></multiselect>
                </div>
                <!-- Hết năm học -->

            </div>
        </form>
        <hr style="margin:5px 0"/>
        <div v-if="listCateReport.length>0">
            <div class="tbc">
                <ul class="nav nav-tabs " style=" display: flex">
                    <li
                        style="width: 20%;  display:gird;"
                        v-for="(bc,i) in listCateReport"
                        @click="activate(i)"
                        :class="{ active : active_el == i }">
                        <a data-toggle="tab" style="width:100%" :href="idmenu+i">{{bc.category}}</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div
                    v-for="(nd,i) in listCateReport"
                    :id="menu+i"
                    class="tab-pane fade in"
                    @click="activate(i)"
                    :class="{ active : active_el == i }">
                    <div class="row">
                        <div class="col-md-12" style="padding-right: 17px;">
                            <div class="">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr style="background: #e4ebf5; text-align:center">
                                        <th class="text-center">
                                            <p>STT</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Tên báo cáo</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Mã báo cáo</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Thao tác</p>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="nd.children.length>0">
                                    <tr v-for="(ndbc, index) in nd.children">
                                        <td class="text-center">
                                            <p>{{index + 1}}</p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ndbc.tenBaoCao}}</p>
                                        </td>
                                        <td>
                                            <p>
                                                {{ndbc.maBaoCao}}</p>
                                        </td>
                                        <td class="text-center">
                                            <button
                                                class="btn btn-info"
                                                :disabled="isDisabled"
                                                @click.prevent="showInFo(ndbc)">Xem
                                            </button>
                                            <template v-if="ndbc.maBaoCao!='SoLuongGVNNDuongBDNLNN'&&ndbc.maBaoCao!='SoLuongGVNNDuongBDNLSP'">
                                                <button v-if="thongtin.role!=20&&thongtin.role!=40" class="btn btn-info"
                                                        @click.prevent="getExcel(ndbc)">Tải file
                                                </button>
                                            </template>

                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <p>Không có danh sách báo cáo</p>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
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
        <div v-if="show_info">
        <XemBaoCao
            :item="codeReport"
            :infodangnhap="thongtin"
            @close="show_info=false"></XemBaoCao>

        </div>

        <div v-if="showDetail">
            <component
                :namhientai="namHocHienTai"
                :tenbaocao="collectionName"
                :ten="tbc"
                @close="showDetail=false"
                :is="current_view"></component>
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import Vue from 'vue';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils';
    import HuongDan from '../huongdan/BaoCaoChoSo'
    import BaoCaoGiaoVienBoiDuongNangLucNgoaiNgu from "./baoCaoDacThu/BaoCaoGiaoVienNgoaiNguDuocBoiDuongNangLucNgoaiNgu";
    import BaoCaoGiaoVienBoiDuongNangLucSuPham from "./baoCaoDacThu/BaoCaoGiaoVienNgoaiNguDuocBoiDuongNangLucSuPham";
    import constant from "../../utils/constant";
    import XemBaoCao from './baocaochobo/ViewBaoCao'

    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {
        props: ['info'],
        components: {
            "HuongDan": HuongDan,
            "XemBaoCao": XemBaoCao,
            'BaoCaoGiaoVienBoiDuongNangLucNgoaiNgu': BaoCaoGiaoVienBoiDuongNangLucNgoaiNgu,
            'BaoCaoGiaoVienBoiDuongNangLucSuPham': BaoCaoGiaoVienBoiDuongNangLucSuPham,
            Multiselect
        },
        data() {
            return {
                thongtin:{},
                tenMien:"",
                ojDonVi: "",
                tbc: "",
                current_view: "",
                collectionName: "",
                date: new Date(),
                listCateReport: [],
                demo: "#idBaoCao",
                id: "idBaoCao",
                ct: "cate",
                idmenu: "#menu",
                menu: "menu",
                active_el: 0,
                namHocHienTai: '',
                ds_bao_cao: [],
                huong_dan: false,
                showDetail: false,
                list_don_vi: [],
                list_truong_hoc: [],
                list_cap_hoc: constant.LIST_CAP_HOC_KHONG_LIEN,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                show_info: false,
                ma_truong_hoc: "",
                ma_don_vi: "",
                cap_hoc: "",
                codeReport: "",
                danhSachNamHoc: "",
                isDisabled: false,
                linkBaoCao: "",
                namHocHienTai: "",
                linkdowLoad: "",
                bao_cao_dau_nam: [],

                bao_cao_cuoi_nam: [],

                bao_cao_nam: []
            }
        },
        watch: {
            danhSachNamHoc: function (newVal) {
                console.log("năm học thay đổi:" + JSON.stringify(newVal));
                this.namHocHienTai = "";
                if (newVal) {
                    this.namHocHienTai = newVal.id;
                }

                this.getListReport();
            },
            ojDonVi: function (newVal) {
                console.log("thay đổi đơn vị");
                console.log(JSON.stringify(newVal));
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.tenMien = this.thongtin.tenMien;
            console.log("thông tin đăng nhập");

            // this.namHocHienTai  = this     .date     .getFullYear();
            this.namHocHienTai = this
                .date
                .getFullYear();
            let thangNay = this
                .date
                .getMonth();
            thangNay = parseInt(thangNay) + 1;
            if (thangNay > 8) {
                console.log("tháng > 7");
                // tháng lớn hơn 7. lấy năm nay là năm học hiện tại
            } else {
                this.namHocHienTai -= 1;
                console.log("tháng không lớn hơn 7");
                // tháng nhỏ hơn hoặc bằng 7. lấy năm ngoái là năm học hiện tại
            }

            // for(let i=0;i<this.list_nam_hoc.length,i++){
            // if(this.list_nam_hoc[i].id==this.namHocHienTai){
            // this.namHocHienTai=this.list_nam_hoc[i];     } }

            for (let i = 0; i < this.list_nam_hoc.length; i++) {
                if (this.list_nam_hoc[i].id == this.namHocHienTai) {
                    this.danhSachNamHoc = this.list_nam_hoc[i];
                }
            }

            console.log(this.thongtin);
            this.ma_don_vi = this.thongtin.province;
            this.getDonVi();
            setTimeout(() => {

                // this.getListReport();
            }, 250);
        },
        methods: {
            // định nghĩa cho năm học
            setNameNamHoc({name}) {
                return `${name}`
            },

            nameWithLang({tenDonVi, maDonVi}) {
                return `${tenDonVi} - [${maDonVi}]`
            },

            activate: function (el) {
                this.active_el = el;
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.province
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    // console.log("thông tin đơn vị trả về:" + JSON.stringify(data));
                    this.list_don_vi = data.data.rows;
                });
            },
            getListReport() {
                this.listCateReport = [];
                if (!this.namHocHienTai) {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để lấy danh sách báo cáo.");
                    return;
                }
                let params = {
                    "namHoc": this.namHocHienTai,
                    "tenBaoCao": "baoCaoDacThu"
                };
                console.log("param:" + params);
                rest_api.get("/csdlgd-report-api/danhSachBaoCao", params, (data) => {
                    console.log("trả về");
                    console.log(JSON.stringify(data.data));
                    this.listCateReport = data.data;
                    if (this.listCateReport.length > 0) {
                        // this
                        //     .$alertify
                        //     .success("Lấy dữ liệu báo cáo thành công.")
                    } else {
                        // this
                        //     .$alertify
                        //     .error("Không tìm thấy bản ghi nào.")
                    }
                },60000, true);
            },

            getReportRole(e) {
                this.show_info = true;
                this.isDisabled = true;
                let params = {
                    "loaiBaoCao": "baoCaoEmis",
                    "maBaoCao": e.maBaoCao,
                    "namHoc": this.namHocHienTai
                };
                if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                    params.parentRole = 20;
                }
                if (this.thongtin.role == 4) {
                    params.parentRole = 40
                }
                this
                    .$alertify
                    .success("Đang tổng hợp báo cáo. Vui lòng chờ...")
                rest_api.get("/csdlgd-report-api/danhSachBaoCao/getBanTo", params, (data) => {
                    console.log("tv:" + JSON.stringify(data));
                    this.isDisabled = false;
                    if (data.data.rc == 0) {
                        if (data.data.item != "") {
                            this.linkBaoCao = data
                            console.log("gán xong link:");
                            console.log(JSON.stringify(this.linkBaoCao));
                            this.show_info = true;
                            this.codeReport = this.linkBaoCao;
                            console.log("hiện:" + this.show_info);
                        } else {
                            this.linkBaoCao = "";
                            this
                                .$alertify
                                .error("Báo cáo này chưa có thông tin.")
                        }
                    } else {
                        this
                            .$$alertify
                            .error("Có lỗi sảy ra. Vui lòng thử lại.")
                    }
                });
            },
            showInFo(e) {
                console.log("1");
                if (e.maBaoCao == "SoLuongGVNNDuongBDNLNN" || e.maBaoCao == "SoLuongGVNNDuongBDNLSP") {
                    console.log("báo cáo đặc biệt"  + JSON.stringify(e));
                    this.collectionName = e.maBaoCao;
                    this.tbc = e.tenBaoCao;
                    if (e.maBaoCao == "SoLuongGVNNDuongBDNLNN"){
                        this.current_view = BaoCaoGiaoVienBoiDuongNangLucNgoaiNgu;
                        console.log("Báo cáo 1")
                    }
                    else {
                        this.current_view = BaoCaoGiaoVienBoiDuongNangLucSuPham;
                        console.log("Báo cáo 12")
                    }
                    this.showDetail = true;

                }
                else {
                    console.log("lấy ");
                    this.layFileBaoCao(e);
                }
            },
            layFileBaoCao(e){
                console.log(JSON.stringify(e));
                let cdnUrlView = "/view-excel?path=";
                let firstUrl = cdnUrlView +e.xlsxFile;
                let params = {
                    "reportTypeId": e.maBaoCao,
                    "namHoc": this.namHocHienTai
                };
                this.codeReport = firstUrl;
                rest_api.post("/csdlgd-analytic-api/download-excel/get-report-link", params, data => {
                    console.log("lấy trả về: "+ JSON.stringify(data.data));
                    if(data.data.rc==0){
                        let baseUrl = "/view-excel?path="+ this.tenMien;
                        if(data.data.urlContext){
                            let linkIframe = baseUrl + data.data.urlContext;
                            this.codeReport = linkIframe;
                            this.show_info = true;
                        }
                        else{
                            this.codeReport = firstUrl;
                            this.show_info = true;
                        }
                    }
                    else{
                        console.log("khác 0");
                        this.codeReport = firstUrl;
                            this.show_info = true;
                    }
                });
            },
            getExcel(e) {
                console.log(JSON.stringify(e));
                let firstUrl = e.xlsxFile;
                let params = {
                    "reportTypeId": e.maBaoCao,
                    "namHoc": this.namHocHienTai
                };
                rest_api.post("/csdlgd-analytic-api/download-excel/get-report-link", params, data => {
                    if(data.data.rc==0){
                        let baseUrl = this.tenMien;
                        if(data.data.urlContext){
                            let linkTai = baseUrl + data.data.urlContext;
                            console.log("Link tải:" + linkTai);
                            window.open(linkTai, '_blank');
                        }
                        else{
                            let linkTai = firstUrl;
                            console.log("Link tải:" + linkTai);
                            window.open(linkTai, '_blank');
                        }
                    }
                    else{
                            let linkTai = firstUrl;
                            console.log("Link tải:" + linkTai);
                            window.open(linkTai, '_blank');
                    }
                });
            }
        }
    }
</script>
<style scoped="scoped">

    @import "../../../../node_modules/selectwithsearch.css";

    p {
        font-size: 12px;
    }

    .active a {
        background: rgb(228, 235, 245) !important;
    }

    .nav-tabs > li {
        display: grid;
    }

    li > a {
        color: blue;
        font-weight: bold !important;
        font-size: 12px;
        border: 1px solid whitesmoke;
        display: block;
        height: 100%;
        padding: 7px;
        text-align: center;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
        margin: 0 auto;
        background: #f6f6f6;
        text-transform: uppercase;
    }
</style>

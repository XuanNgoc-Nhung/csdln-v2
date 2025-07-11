<template>
    <div>
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :span="12" class="text-uppercase">
                <a href=""> TRANG CHỦ</a>
                <span>
                    <span class="kytu">
                        &raquo;</span>Báo cáo
                    <span class="kytu">
                        &raquo;</span>
                    Báo cáo đơn vị</span>
            </el-col>
        </el-row>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
            </div>
        </div>
        <div>
            <!---->
            <div class="tbc">
                <ul class="nav nav-tabs " style=" display: flex">
                    <li style="width: 20%;  display:gird;" v-for="(bc,i) in listReport" @click="activate(i)" :key="i"
                        :class="{ active : active_el == i }">
                        <a data-toggle="tab" style="width:100%" :href="idmenu+i">{{bc.category}}</a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div v-for="(nd,i) in listReport" :id="menu+i" :key="i" class="tab-pane fade in" @click="activate(i)"
                     :class="{ active : active_el == i }">
                    <div class="row">
                        <div class="col-md-12" style="padding-right: 17px;">
                            <div class="">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr style="background: #e4ebf5; text-align:center">
                                        <th>
                                            <p>STT</p>
                                        </th>
                                        <th>
                                            <p>Mã báo cáo</p>
                                        </th>
                                        <th>
                                            <p>Tên báo cáo</p>
                                        </th>
                                        <th>
                                            <p>Thao tác</p>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(ndbc, index) in nd.children" :key="index">
                                        <td class="text-center">
                                            <p>{{index + 1}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p>{{ndbc.maBaoCao}}</p>
                                        </td>
                                        <td>
                                            <p>{{ndbc.tenBaoCao}}</p>
                                        </td>
                                        <td class="text-center">
                                            <el-button type="success" size="mini"
                                                       v-on:click="ShowReport(nd.capHoc, ndbc.collectionName,ndbc.tenBaoCao)">Xem báo cáo
                                            </el-button>
                                        </td>
                                    </tr>
                                    <!-- end demo -->
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- <div v-if="showDetail"> -->
            <viewBaoCao :item="showDetail" :caphoc="capHoc" :namhientai="namHocHienTai" :canhocky="canHocKy" :cln="collectionName"
                        :ten="tbc" :dangnhap="thongtin" @close="showDetail=false"></viewBaoCao>
            <!-- </div> -->
        </div>
    </div>
</template>
<script>
import rest_api from '../../../utils/rest_api';
import array_util from '../../../utils/array_utils';
import Vue from 'vue';
import VueAlertify from 'vue-alertify';
// import viewBaoCao from './baoCaoChoSo/viewBaoCao';
import viewBaoCao from './queryBaoCao';
Vue.use(VueAlertify);
export default {
    props: [],
    components: {
        'viewBaoCao': viewBaoCao,
    },
    data() {
        return {
            namHocHienTai: "",
            canHocKy: "",
            date: new Date(),
            current_view: "",
            huong_dan: false,
            showDetail: false,
            show_demo: false,
            listReport: [],
            collectionName: '',
            tbc: '',
            capHoc: '',
            thongtin: JSON.parse(window.userInfo),
            demo: "#idBaoCao",
            id: "idBaoCao",
            ct: "cate",
            idmenu: "#menu",
            menu: "menu",
            active_el: 0
        }
    },
    mounted: function () {
        this.namHocHienTai = this.thongtin.namHocHienTai;
        console.log("Năm học hiện tại:" + this.namHocHienTai);
        this.getReport();
        this.getDonVi();
    },

    watch: {},
    methods: {
        getDonVi(){
            this.fullscreenLoading = true;

            let params = {
                "start": 0,
                "limit": 100,
                "maTinhThanh": this.thongtin.ma_so,
            };
            rest_api.get('/internal-api/dmDonVi/filter', params).then(
                response => {
                    console.log("Lấy đơn vị trả về:")
                    console.log(response)
                }
            ).catch((error) => {
                this.thongBao('success', 'Hệ thống đang cập nhật dữ liệu. Vui lòng chờ trong ít phút.');
                this.fullscreenLoading = false;
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
        xemHuongDan() {
            console.log("xem hướng dẫn")
            this.huong_dan = true;
        },
        getReport() {
            let params = {
                "namHoc": 2019,
                "tenBaoCao": "baoCaoChoSo"
            };
            rest_api.get("/csdlgd-report-api/danhSachBaoCao", params, (data) => {
                if (array_util.isArray(data.data)) {
                    array_util.clearArrays(this.listReport);
                    this.listReport = data.data;
                }
            }, 60000, true);

        },
        activate: function (el) {
            this.active_el = el;
        },
        ShowReport(e, n, t) {
            console.log("ấn xem" + this.showDetail)
            // const loading = this.$loading({
            //     lock: true,
            //     text: 'Loading',
            //     spinner: 'el-icon-loading',
            //     background: 'rgba(0, 0, 0, 0.7)'
            // });
            this.canHocKy = this.checkCanHocKy(n);
            this.tbc = t;
            this.capHoc = e;
            this.collectionName = n;
            if(this.showDetail ==true){
                this.showDetail=false;
            }
            this.showDetail = true;
        },
        checkCanHocKy(e) {
            if (e == "BcDanhHieuHocSinh" || e == "BcDiemTrungBinhMon" || e == "BcTinhHinhHanhKiemCuaHocSinh" || e ==
                "BcTinhHinhHocLucCuaHocSinh" || e == "BcHocLucHanhKiemTheoDiaPhuong" ||
                e == "BcSoHocSinhLenLopLuuBanThiLai" || e ==
                "BcPhanLoaiDiemSoTheoMonHocKhoiLop" || e == "BcSuPhatTrienCuaTre") {
                return true;
            } else {
                return false;
            }
        }
    }
}

</script>
<style scoped="scoped">
th {
    text-align: center;
}

li>a {
    color: blue;
    font-weight: bold !important;
    font-size: 16px;
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

.panel {
    clear: both;
}

#cate0 {
    padding-top: 5px;
}

.active a {
    background: rgb(228, 235, 245) !important;
}

.nav-tabs>li {
    display: grid;
}

p {
    margin: 0;
    font-size: 16px;
}

.table>tbody>tr>td {
    vertical-align: middle;
}

</style>

<template>
    <div class="baoCaoDonVi" v-loading="loading" :element-loading-text="loadingText" element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">


        <Breadcrumb :menu="'Báo cáo'" :desc="'Báo cáo đơn vị'" />
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <el-col :span="24">
                    <el-tabs type="border-card2">
                        <el-tab-pane v-for="(nd,i) in listReport" :key="i">
                            <span slot="label"> {{nd.category}}</span>
                            <label class="table-name">Danh sách báo cáo đơn vị</label>
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
                                            <!-- <el-button size="mini" type="primary"
                                                    @click.prevent="ShowReport(nd.capHoc, ndbc.collectionName,ndbc.tenBaoCao,nd.category)">Xem báo cáo
                                                </el-button> -->

                                            <el-tooltip content="Xem báo cáo" placement="top">
                                                <i @click.prevent="ShowReport(nd.capHoc, ndbc.collectionName,ndbc.tenBaoCao,nd.category)"
                                                   class="el-icon-view"></i>
                                            </el-tooltip>
                                            <!-- <el-button type="success" size="mini"
                                                    v-if="thongtin.role!=20&&thongtin!=40"
                                                    @click.prevent="getExcel(ndbc.xlsxFile)">Xuất excel
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
                    <!-- <div v-if="showDetail"> -->
                    <viewBaoCao :item="showDetail" :category="category" :list_don_vi="danh_sach_don_vi" :caphoc="capHoc"
                        :canhocky="canHocKy" :cln="collectionName" :ten="tbc" :dangnhap="thongtin"
                        @close="showDetail=false">
                    </viewBaoCao>
                    <!-- </div> -->
                </el-col>
            </el-row>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import Vue from 'vue';
    import VueAlertify from 'vue-alertify';
    // import viewBaoCao from './baoCaoChoSo/viewBaoCao';
    import viewBaoCao from './baoCaoChoSo/queryBaoCao';
    import Breadcrumb from './../ui/Breadcrumb.vue';

    Vue.use(VueAlertify);
    export default {
        props: [],
        components: {
            'viewBaoCao': viewBaoCao,
            Breadcrumb
        },
        data() {
            return {
                bao_cao_nha_tre_them: [{
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.4.7',
                        tenBaoCao: 'Thống kê số lượng học sinh theo dân tộc.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.4.8',
                        tenBaoCao: 'Thống kê số lượng học sinh theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.4.9',
                        tenBaoCao: 'Thống kê số lượng học sinh theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.4.10',
                        tenBaoCao: 'Thống kê số lượng học sinh theo huyện, thành phố.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.3.5',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo chức vụ.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.3.6',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo vị trí việc làm.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.3.7',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.3.8',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.3.9',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo huyện, thành phố.',
                    },
                ],
                bao_cao_mau_giao_them: [{
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.4.6',
                        tenBaoCao: 'Thống kê số lượng học sinh theo dân tộc.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.4.7',
                        tenBaoCao: 'Thống kê số lượng học sinh theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.4.8',
                        tenBaoCao: 'Thống kê số lượng học sinh theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.4.9',
                        tenBaoCao: 'Thống kê số lượng học sinh theo huyện, thành phố.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.3.5',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo chức vụ.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.3.6',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo vị trí việc làm.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.3.7',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.3.8',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'A.3.9',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo huyện, thành phố.',
                    },
                ],
                bao_cao_tieu_hoc_them: [{
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.4.6',
                        tenBaoCao: 'Thống kê số lượng học sinh theo dân tộc.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.4.7',
                        tenBaoCao: 'Thống kê số lượng học sinh theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.4.8',
                        tenBaoCao: 'Thống kê số lượng học sinh theo khối lớp.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.4.9',
                        tenBaoCao: 'Thống kê số lượng học sinh theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.4.10',
                        tenBaoCao: 'Thống kê số lượng học sinh theo huyện, thành phố.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.4.11',
                        tenBaoCao: 'Thống kê số lượng học sinh theo đánh giá, xếp loại.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.4.12',
                        tenBaoCao: 'Thống kê số lượng học sinh lên lớp, lưu ban, thi lại.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.4.13',
                        tenBaoCao: 'Thống kê số lượng học sinh theo môn học.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.4.14',
                        tenBaoCao: 'Thống kê số lượng học sinh lớp đầu cấp.',
                    },

                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.3.6',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo chức vụ.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.3.7',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo vị trí việc làm.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.3.8',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.3.9',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'B.3.10',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo huyện, thành phố.',
                    },
                ],
                bao_cao_thcs_them: [{
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.4.7',
                        tenBaoCao: 'Thống kê số lượng học sinh theo dân tộc.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.4.8',
                        tenBaoCao: 'Thống kê số lượng học sinh theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.4.9',
                        tenBaoCao: 'Thống kê số lượng học sinh theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.4.10',
                        tenBaoCao: 'Thống kê số lượng học sinh theo huyện, thành phố.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.4.11',
                        tenBaoCao: 'Thống kê số lượng học sinh học nghề.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.4.12',
                        tenBaoCao: 'Thống kê số lượng học sinh học theo tổ hợp môn/môn tự chọn.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.4.13',
                        tenBaoCao: 'Thống kê số lượng học sinh học theo môn học.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.4.14',
                        tenBaoCao: 'Thống kê số lượng học sinh lớp đầu cấp.',
                    },


                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.3.6',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo chức vụ.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.3.7',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo vị trí việc làm.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.3.8',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.3.9',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'C.3.10',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo huyện, thành phố.',
                    },
                ],
                bao_cao_thpt_them: [{
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.4.8',
                        tenBaoCao: 'Thống kê số lượng học sinh theo dân tộc.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.4.9',
                        tenBaoCao: 'Thống kê số lượng học sinh theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.4.10',
                        tenBaoCao: 'Thống kê số lượng học sinh theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.4.11',
                        tenBaoCao: 'Thống kê số lượng học sinh theo huyện, thành phố.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.4.12',
                        tenBaoCao: 'Thống kê số lượng học sinh học nghề.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.4.13',
                        tenBaoCao: 'Thống kê số lượng học sinh học theo tổ hợp môn/môn tự chọn.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.4.14',
                        tenBaoCao: 'Thống kê số lượng học sinh theo môn học.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.4.15',
                        tenBaoCao: 'Thống kê số lượng học sinh lớp đầu cấp.',
                    },

                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.3.6',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo chức vụ.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.3.7',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo vị trí việc làm.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.3.8',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.3.9',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'D.3.10',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo huyện, thành phố.',
                    },
                ],
                bao_cao_gdtx_them: [{
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.4.5',
                        tenBaoCao: 'Thống kê số lượng học sinh theo dân tộc.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.4.6',
                        tenBaoCao: 'Thống kê số lượng học sinh theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.4.7',
                        tenBaoCao: 'Thống kê số lượng học sinh theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.4.8',
                        tenBaoCao: 'Thống kê số lượng học sinh theo huyện, thành phố.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.4.9',
                        tenBaoCao: 'Thống kê số lượng học sinh học nghề.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.4.10',
                        tenBaoCao: 'Thống kê số lượng học sinh học theo tổ hợp môn/môn tự chọn.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.4.11',
                        tenBaoCao: 'Thống kê số lượng học sinh theo môn học.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.4.12',
                        tenBaoCao: 'Thống kê số lượng học sinh lớp đầu cấp.',
                    },

                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.3.6',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo chức vụ.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.3.7',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo vị trí việc làm.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.3.8',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo giới tính.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.3.9',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo đơn vị.',
                    },
                    {
                        collectionName: 'BcDanhSachTruongHoc',
                        maBaoCao: 'E.3.10',
                        tenBaoCao: 'Thống kê số lượng cán bộ theo huyện, thành phố.',
                    },
                ],
                loading: false,
                danh_sach_don_vi: [],
                loadingText: 'Loading...',
                canHocKy: "",
                category: '',
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
            this.getReport();
            this.getDonVi();
        },

        watch: {},
        methods: {
            getDonVi() {
                try {
                    this.loadingText = 'Lấy danh sách đơn vị...';
                    let params = {
                        "start": 0,
                        "limit": 9999,
                        "maTinhThanh": this.thongtin.ma_so
                    };
                    this.loading = true;
                    console.log("pr ẻty" + JSON.stringify(params));
                    rest_api.get("/internal-api/dmDonVi/filter", params, (response) => {
                        if (response.data.code == 200) {
                            let dulieu = response.data.rows;
                            console.log(dulieu)
                            let mang = [];
                            if (dulieu && dulieu.length > 0) {
                                for (let i = 0; i < dulieu.length; i++) {
                                    let obj = {
                                        name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                            ' - [' + dulieu[i].maDonVi + ']',
                                        value: dulieu[i].maDonVi
                                    }
                                    mang.push(obj)
                                }
                            }
                            this.danh_sach_don_vi = mang;
                        }
                        this.loading = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Không lấy được danh sách đơn vị. Vui lòng thử lại sau ít phút.')
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
                        if (this.thongtin.ma_so == '08') { //gán dữ liệu giả cho sở 08
                            //nhà trẻ
                            let nha_tre = this.listReport[0].children;
                            nha_tre = nha_tre.concat(this.bao_cao_nha_tre_them)
                            nha_tre.sort((a, b) => {

                                let aArr = a.maBaoCao.split('.');
                                let bArr = b.maBaoCao.split('.');

                                console.log(aArr[0]);

                                if (aArr[0] !== bArr[0]) {
                                    if (aArr[0] < bArr[0]) {
                                        return -1;
                                    }
                                    if (aArr[0] > bArr[0]) {
                                        return 1;
                                    }
                                } else {
                                    if (parseInt(aArr[1]) !== parseInt(bArr[1])) {
                                        if (parseInt(aArr[1]) < parseInt(bArr[1])) {
                                            return -1;
                                        }
                                        if (parseInt(aArr[1]) > parseInt(bArr[1])) {
                                            return 1;
                                        }
                                    } else {
                                        if (parseInt(aArr[2]) !== parseInt(bArr[2])) {
                                            if (parseInt(aArr[2]) < parseInt(bArr[2])) {
                                                return -1;
                                            }
                                            if (parseInt(aArr[2]) > parseInt(bArr[2])) {
                                                return 1;
                                            }
                                        }
                                    }
                                }

                                return true;
                            });
                            this.listReport[0].children = JSON.parse(JSON.stringify(nha_tre))

                            //mẫu giáo
                            let mau_giao = this.listReport[1].children;
                            mau_giao = mau_giao.concat(this.bao_cao_mau_giao_them)
                            mau_giao.sort((a, b) => {

                                let aArr = a.maBaoCao.split('.');
                                let bArr = b.maBaoCao.split('.');

                                console.log(aArr[0]);

                                if (aArr[0] !== bArr[0]) {
                                    if (aArr[0] < bArr[0]) {
                                        return -1;
                                    }
                                    if (aArr[0] > bArr[0]) {
                                        return 1;
                                    }
                                } else {
                                    if (parseInt(aArr[1]) !== parseInt(bArr[1])) {
                                        if (parseInt(aArr[1]) < parseInt(bArr[1])) {
                                            return -1;
                                        }
                                        if (parseInt(aArr[1]) > parseInt(bArr[1])) {
                                            return 1;
                                        }
                                    } else {
                                        if (parseInt(aArr[2]) !== parseInt(bArr[2])) {
                                            if (parseInt(aArr[2]) < parseInt(bArr[2])) {
                                                return -1;
                                            }
                                            if (parseInt(aArr[2]) > parseInt(bArr[2])) {
                                                return 1;
                                            }
                                        }
                                    }
                                }

                                return true;
                            });
                            this.listReport[1].children = JSON.parse(JSON.stringify(mau_giao))

                            //tiểu học
                            let tieu_hoc = this.listReport[2].children;
                            tieu_hoc = tieu_hoc.concat(this.bao_cao_tieu_hoc_them)
                            tieu_hoc.sort((a, b) => {

                                let aArr = a.maBaoCao.split('.');
                                let bArr = b.maBaoCao.split('.');

                                console.log(aArr[0]);

                                if (aArr[0] !== bArr[0]) {
                                    if (aArr[0] < bArr[0]) {
                                        return -1;
                                    }
                                    if (aArr[0] > bArr[0]) {
                                        return 1;
                                    }
                                } else {
                                    if (parseInt(aArr[1]) !== parseInt(bArr[1])) {
                                        if (parseInt(aArr[1]) < parseInt(bArr[1])) {
                                            return -1;
                                        }
                                        if (parseInt(aArr[1]) > parseInt(bArr[1])) {
                                            return 1;
                                        }
                                    } else {
                                        if (parseInt(aArr[2]) !== parseInt(bArr[2])) {
                                            if (parseInt(aArr[2]) < parseInt(bArr[2])) {
                                                return -1;
                                            }
                                            if (parseInt(aArr[2]) > parseInt(bArr[2])) {
                                                return 1;
                                            }
                                        }
                                    }
                                }

                                return true;
                            });
                            this.listReport[2].children = JSON.parse(JSON.stringify(tieu_hoc))

                            //THCS
                            let thcs = this.listReport[3].children;
                            thcs = thcs.concat(this.bao_cao_thcs_them)
                            thcs.sort((a, b) => {

                                let aArr = a.maBaoCao.split('.');
                                let bArr = b.maBaoCao.split('.');

                                console.log(aArr[0]);

                                if (aArr[0] !== bArr[0]) {
                                    if (aArr[0] < bArr[0]) {
                                        return -1;
                                    }
                                    if (aArr[0] > bArr[0]) {
                                        return 1;
                                    }
                                } else {
                                    if (parseInt(aArr[1]) !== parseInt(bArr[1])) {
                                        if (parseInt(aArr[1]) < parseInt(bArr[1])) {
                                            return -1;
                                        }
                                        if (parseInt(aArr[1]) > parseInt(bArr[1])) {
                                            return 1;
                                        }
                                    } else {
                                        if (parseInt(aArr[2]) !== parseInt(bArr[2])) {
                                            if (parseInt(aArr[2]) < parseInt(bArr[2])) {
                                                return -1;
                                            }
                                            if (parseInt(aArr[2]) > parseInt(bArr[2])) {
                                                return 1;
                                            }
                                        }
                                    }
                                }

                                return true;
                            });
                            this.listReport[3].children = JSON.parse(JSON.stringify(thcs))

                            //THPT
                            let thpt = this.listReport[4].children;
                            thpt = thpt.concat(this.bao_cao_thpt_them)
                            console.error('****')
                            console.error(JSON.stringify(thpt))
                            thpt = thpt.sort((a, b) => {
                                let aArr = a.maBaoCao.split('.');
                                let bArr = b.maBaoCao.split('.');

                                console.log(aArr[0]);

                                if (aArr[0] !== bArr[0]) {
                                    if (aArr[0] < bArr[0]) {
                                        return -1;
                                    }
                                    if (aArr[0] > bArr[0]) {
                                        return 1;
                                    }
                                } else {
                                    if (parseInt(aArr[1]) !== parseInt(bArr[1])) {
                                        if (parseInt(aArr[1]) < parseInt(bArr[1])) {
                                            return -1;
                                        }
                                        if (parseInt(aArr[1]) > parseInt(bArr[1])) {
                                            return 1;
                                        }
                                    } else {
                                        if (parseInt(aArr[2]) !== parseInt(bArr[2])) {
                                            if (parseInt(aArr[2]) < parseInt(bArr[2])) {
                                                return -1;
                                            }
                                            if (parseInt(aArr[2]) > parseInt(bArr[2])) {
                                                return 1;
                                            }
                                        }
                                    }
                                }

                                return true;
                            });
                            console.error('Sau')
                            console.error(thpt)
                            this.listReport[4].children = JSON.parse(JSON.stringify(thpt))

                            //GDTX
                            let gdtx = this.listReport[5].children;
                            gdtx = gdtx.concat(this.bao_cao_gdtx_them)
                            gdtx.sort((a, b) => {
                                let aArr = a.maBaoCao.split('.');
                                let bArr = b.maBaoCao.split('.');

                                console.log(aArr[0]);

                                if (aArr[0] !== bArr[0]) {
                                    if (aArr[0] < bArr[0]) {
                                        return -1;
                                    }
                                    if (aArr[0] > bArr[0]) {
                                        return 1;
                                    }
                                } else {
                                    if (parseInt(aArr[1]) !== parseInt(bArr[1])) {
                                        if (parseInt(aArr[1]) < parseInt(bArr[1])) {
                                            return -1;
                                        }
                                        if (parseInt(aArr[1]) > parseInt(bArr[1])) {
                                            return 1;
                                        }
                                    } else {
                                        if (parseInt(aArr[2]) !== parseInt(bArr[2])) {
                                            if (parseInt(aArr[2]) < parseInt(bArr[2])) {
                                                return -1;
                                            }
                                            if (parseInt(aArr[2]) > parseInt(bArr[2])) {
                                                return 1;
                                            }
                                        }
                                    }
                                }

                                return true;
                            });
                            this.listReport[5].children = JSON.parse(JSON.stringify(gdtx))
                        }
                    }
                }, 60000, true);

            },
            activate: function (el) {
                this.active_el = el;
            },
            ShowReport(e, n, t, category) {
                console.log("ấn xem" + this.showDetail)
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                this.category = category
                this.canHocKy = this.checkCanHocKy(n);
                this.tbc = t;
                this.capHoc = e;
                this.collectionName = n;
                if (this.showDetail == true) {
                    this.showDetail = false;
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
    li>a {
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
        font-size: 12px;
    }

    .table>tbody>tr>td {
        vertical-align: middle;
    }

    .el-tabs.el-tabs--top {
        padding-top: 10px;
    }

    .table p {
        font-size: 14px;
        margin: 0;
    }

</style>

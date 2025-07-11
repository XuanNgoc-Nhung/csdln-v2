<template>
    <div id="BcCanBoTheoCoCau" ref="BcCanBoTheoCoCau" class="modal fade">
        <!-- Nội dung báo cáo -->
        <div class="modal-dialog" style="width: 100%; margin: 0 auto !important;">
            <div class="modal-content">
                <!-- Nội dung header -->
                <div class="modal-header" style="position: relative">
                    <button
                        type="button"
                        class="close btn btn-danger"
                        style="position: absolute; top: 2px; right: 2px;"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="close()">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-md-12">
                            <h3>{{tenBaoCao}}</h3>
                        </div>
                    </div>
                </div>
                <!-- Hết nội dung header + bắt đầu thân -->
                <div class="modal-body clearfix">
<!--                    <div class="row">-->
<!--                        <div v-if="this.thongtin.role2!=5" class="col-md-4 timkiem">-->
<!--                            <label class="typo__label">Chọn đơn vị:</label>-->
<!--                            <div v-if="thongtin.role!=5">-->
<!--                                <div v-if="this.thongtin.role2==2||this.thongtin.role==3">-->
<!--                                    <multiselect-->
<!--                                        v-model="danhSachDonVi"-->
<!--                                        :options="list_don_vi"-->
<!--                                        :multiple="true"-->
<!--                                        @close="ChonDonVi()"-->
<!--                                        :close-on-select="false"-->
<!--                                        :clear-on-select="false"-->
<!--                                        :preserve-search="false"-->
<!--                                        deselectLabel="Đã chọn"-->
<!--                                        selectLabel="Chưa chọn"-->
<!--                                        selectedLabel="Đã chọn"-->
<!--                                        :custom-label="setNameDonVi"-->
<!--                                        placeholder="Chọn đơn vị"-->
<!--                                        label="maDonVi"-->
<!--                                        track-by="tenDonVi"-->
<!--                                        :preselect-first="true">-->
<!--                                        <template-->
<!--                                            v-if="danhSachDonVi.length>1"-->
<!--                                            slot="selection"-->
<!--                                            slot-scope="{ values, search, isOpen }">-->
<!--                                            <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }}-->
<!--                                                đơn vị được chọn</span>-->
<!--                                        </template>-->
<!--                                    </multiselect>-->
<!--                                </div>-->
<!--                                <div v-else="v-else">-->
<!--                                    <input-->
<!--                                        class="form-control"-->
<!--                                        type="text"-->
<!--                                        :value="thongtin.display_name"-->
<!--                                        disabled="disabled"/>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                            <div v-if="thongtin.role==5">-->
<!--                                <input-->
<!--                                    :disabled="thongtin.role == 5"-->
<!--                                    class="form-control"-->
<!--                                    placeholder="Nhập..."/>-->
<!--                            </div>-->
<!--                            &lt;!&ndash; <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> &ndash;&gt;-->
<!--                        </div>-->
<!--                        <div v-if="this.thongtin.role2!=5" class="col-md-2 timkiem">-->
<!--                            <div>-->
<!--                                <label class="typo__label">Chọn cấp học</label>-->
<!--                                <div v-if="thongtin.role2!=5">-->
<!--                                    <multiselect-->
<!--                                        v-model="danhSachCapHoc"-->
<!--                                        :options="list_cap_hoc"-->
<!--                                        :close-on-select="true"-->
<!--                                        :clear-on-select="false"-->
<!--                                        :preserve-search="false"-->
<!--                                        @close="ChonCapHoc()"-->
<!--                                        deselectLabel="Đã chọn"-->
<!--                                        selectLabel="Chưa chọn"-->
<!--                                        selectedLabel="Đã chọn"-->
<!--                                        :custom-label="setNameCapHoc"-->
<!--                                        placeholder="Chọn cấp học"-->
<!--                                        label="name"-->
<!--                                        track-by="name">-->
<!--                                    </multiselect>-->
<!--                                </div>-->
<!--                                <div v-if="thongtin.role==5">-->
<!--                                    <input-->
<!--                                        :disabled="thongtin.role == 5"-->
<!--                                        class="form-control"-->
<!--                                        placeholder="Cấp học"/>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="col-md-4 timkiem">-->
<!--                            <label class="typo__label">Chọn trường học:</label>-->
<!--                            <div v-if="thongtin.role2!=5">-->
<!--                                <multiselect-->
<!--                                    v-model="danhSachTruongHoc"-->
<!--                                    :options="list_truong_hoc"-->
<!--                                    @close="ChonTruongHoc()"-->
<!--                                    :close-on-select="true"-->
<!--                                    :clear-on-select="false"-->
<!--                                    :preserve-search="false"-->
<!--                                    deselectLabel="Đã chọn"-->
<!--                                    selectLabel="Chưa chọn"-->
<!--                                    selectedLabel="Đã chọn"-->
<!--                                    :custom-label="setNameTruongHoc"-->
<!--                                    placeholder="Chọn trường học"-->
<!--                                    label="maTruongHoc"-->
<!--                                    track-by="tenTruongHoc"-->
<!--                                    :preselect-first="true">-->
<!--                                </multiselect>-->
<!--                            </div>-->
<!--                            <div v-if="thongtin.role2==5">-->
<!--                                <input-->
<!--                                    :disabled="thongtin.role2 == 5"-->
<!--                                    class="form-control"-->
<!--                                    :value="this.thongtin.display_name"-->
<!--                                    placeholder="Nhập..."/>-->
<!--                            </div>-->
<!--                            &lt;!&ndash; <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> &ndash;&gt;-->
<!--                        </div>-->
<!--                        <div class="col-md-2 timkiem">-->
<!--                            <label class="typo__label">Năm học:</label>-->
<!--                            <multiselect-->
<!--                                v-model="danhSachNamHoc"-->
<!--                                :options="list_nam_hoc"-->
<!--                                @close="ChonNamHoc()"-->
<!--                                :custom-label="setNameNamHoc"-->
<!--                                placeholder="Chọn năm học"-->
<!--                                label="name"-->
<!--                                deselectLabel="Đã chọn"-->
<!--                                selectLabel="Chưa chọn"-->
<!--                                selectedLabel="Đã chọn"-->
<!--                                track-by="name"></multiselect>-->
<!--                        </div>-->
<!--                    </div>-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="baoButton">
<!--                                <button class="btn btn-primary" @click.prevent="getData">Tìm kiếm</button>-->
                                <button
                                    :disabled="Report.length==0"
                                    @click.prevent="exPort()"
                                    class="btn btn-success">Xuất Excel
                                </button>
                                <button
                                    :disabled="Report.length==0"
                                    @click.prevent="exPortPDF()"
                                    class="btn btn-info">Xuất PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <hr/>
                    <div class="row">
                        <div class="col-md-12">
                            <div v-if="Report.length>0" class="text-center">
                                <div v-if="pdf">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="pull-right baoButton2">
                                                <button @click="pdf=false" class="btn btn-danger">
                                                    Quay lại
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 xembaocao">
                                            <iframe style="width:100%; height:100vh" :src="linkPdf"></iframe>
                                        </div>
                                    </div>
                                </div>
                                <div v-else="v-else">
                                    <div class="xembaocao form-group clearfix table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr>
                                                <th class="tn vh" colspan="5">
                                                    <b>{{TieuDe.tenDonViQuanLy}}</b>
                                                </th>
                                                <th colspan="10" class="qh vh">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</th>
                                            </tr>
                                            <tr>
                                                <th colspan="5" class="tn vh">
                                                    <b>{{TieuDe.tenDonVi}}</b>
                                                </th>
                                                <th colspan="10" class="tn">Độc lập - Tự do - Hạnh phúc</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                            <tr>
                                                <th colspan="15" class="text-uppercase red text-center">
                                                    <h4>SỐ LƯỢNG GIÁO VIÊN NGOẠI NGỮ ĐƯỢC BỒI DƯỠNG NÂNG CAO NĂNG LỰC SƯ PHẠM</h4>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="15" class="text-uppercase red text-center">
                                                    <h4>Năm học:
                                                        {{TieuDe.namHoc}}-{{TieuDe.namHoc+1}}</h4>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                                <th style="border-bottom: 1px solid black;"></th>
                                            </tr>
                                            </thead>
                                            <tbody class="noidung">
                                            <tr>
                                                <th class="cg text-center" rowspan="2">STT</th>
                                                <th class="cg text-center" rowspan="2"><p>Tên khóa bồi dưỡng</p></th>
                                                <th class="cg text-center" rowspan="2"><p>Đơn vị bồi dưỡng</p></th>
                                                <th class="cg text-center" rowspan="2"><p>Đơn vị tổ chức thi</p></th>
                                                <th class="cg text-center" rowspan="2"><p>Tổng số lượt người tham gia</p></th>
                                                <th class="cg text-center" colspan="3"><p>Loại hình bồi dưỡng</p></th>
                                                <th class="cg text-center" colspan="2"><p>Hình thức bồi dưỡng</p></th>
                                                <th class="cg text-center" colspan="4"><p>Thời lượng bồi dưỡng</p></th>
                                                <th class="cg text-center" rowspan="2"><p>Số người hoàn thành khóa bồi dưỡng</p></th>
                                            </tr>
                                            <tr style="background:#f9f9f9">
                                                <th class="cg text-center" ><p>Trong nước</p></th>
                                                <th class="cg text-center" ><p>Liên kết</p></th>
                                                <th class="cg text-center" ><p>Nước ngoài</p></th>
                                                <th class="cg text-center" ><p>Trực tiếp</p></th>
                                                <th class="cg text-center" ><p>Trực tuyến</p></th>
                                                <th class="cg text-center" ><p>1-3 tháng</p></th>
                                                <th class="cg text-center" ><p>3-6 tháng</p></th>
                                                <th class="cg text-center" ><p>6-9 tháng</p></th>
                                                <th class="cg text-center" ><p>Khác</p></th>
                                            </tr>
                                            <tr v-for="(ctbc,i) in Report" style="background: white;">
                                                <td class="text-center">{{i+1}}</td>
                                                <td>{{ctbc.maKhoaBoiDuong}}</td>
                                                <td>{{ctbc.maDonViBoiDuong}}</td>
                                                <td>{{ctbc.maDonViToChuc}}</td>
                                                <td class="text-center">{{ctbc.tongSo}}</td>
                                                <td class="text-center">{{ctbc.maLoaiHinhTrongNuoc}}</td>
                                                <td class="text-center">{{ctbc.maLoaiHinhLienKet}}</td>
                                                <td class="text-center">{{ctbc.maLoaiHinhNuocNgoai}}</td>
                                                <td class="text-center">{{ctbc.hinhThucTrucTiep}}</td>
                                                <td class="text-center">{{ctbc.hinhThucTrucTuyen}}</td>
                                                <td class="text-center">{{ctbc.thoiLuong13}}</td>
                                                <td class="text-center">{{ctbc.thoiLuong36}}</td>
                                                <td class="text-center">{{ctbc.thoiLuong69}}</td>
                                                <td class="text-center">{{ctbc.khac}}</td>
                                                <td class="text-center">{{ctbc.hoanThanh}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div v-else="v-else" class="text-center">
                                <p>Không có dữ liệu</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="col-md-12">
                            <button
                                class="btn btn-danger"
                                type="button"
                                data-dismiss="modal"
                                aria-hidden="true"
                                v-on:click="close()">Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hết nội dung báo cáo -->
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../../utils/rest_api';
    import array_util from '../../../utils/array_utils';
    import constant from "../../../utils/constant";
    import utils from '../../../utils';
    import dialog from '../../../utils/dialog';
    import api from './../../api';
    import VueAlertify from "vue-alertify";

    Vue.use(VueAlertify, {
        notifier: {
            delay: 2,
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
            'ten', 'tenbaocao', 'item', 'namhientai'
        ],
        watch: {},
        components: {
            Multiselect
        },
        data() {
            return {
                thongtin: {},
                linkPdf: '',
                tenBaoCao: '',
                pdf: false,
                collectionName: '',
                capHoc: '',
                nam_hoc: '',
                TieuDe: '',
                Report: [],
                list_don_vi: [],
                list_truong_hoc: [],
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                danhSachDonVi: [],
                ds_cap_hoc: "",
                danhSachCapHoc: [],
                danhSachTruongHoc: [],
                danhSachNamHoc: [],
                ds_don_vi: [],
                ds_truong_hoc: ""
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            $("#BcCanBoTheoCoCau").modal();
            $(this.$refs.BcCanBoTheoCoCau).on("hidden.bs.modal", this.close);
            this.bindDuLieu();
            this.nam_hoc = this.namhientai;
            this.findNamHoc();
            this.getDonVi();
            if (this.thongtin.role2 == 5) {
                this.ds_truong_hoc = this.thongtin.ma_truong_hoc;
                console.log("đăng nhập là trường");
            }
            this.getData();
        },

        methods: {
            ChonCapHoc() {
                console.log("CHọn cấp học")
                console.log(JSON.stringify(this.danhSachCapHoc));
                this.ds_truong_hoc = "";
                this.danhSachTruongHoc = [];
                if (this.danhSachCapHoc) {
                    this.ds_cap_hoc = this.danhSachCapHoc.id;
                    console.log("Câp học:")
                    console.log(JSON.stringify(this.ds_cap_hoc))
                    this.getTruongHoc();
                }
            },
            // Xuất pdf
            exPortPDF() {
                let url = "xuat-bao-cao-pdf";
                // if (this.thongtin.role2 == 5) {
                //     this.ds_truong_hoc = [this.dangnhap.ma_truong_hoc]
                // }
                // if (!this.ds_truong_hoc||this.ds_truong_hoc.length==0){
                //     this.$alertify.error("Vui lòng chọn trường học để lấy thông tin.");
                //     return;
                // }
                let params = {
                    // "capHoc": this.ds_cap_hoc,
                    "namHoc": this.nam_hoc,
                    "collectionName": this.collectionName,
                    // "maTruongs": [this.ds_truong_hoc],
                    // "maDonVis": this.ds_don_vi
                };
                this
                    .$alertify
                    .success("Đang lấy dữ liệu... Vui lòng chờ...")
                api.post(url, params, (data) => {
                    if (data.data.rc == -1) {
                        this.linkPdf = data.data.file;
                        this.pdf = true;
                    }
                    console.log("Xuất pfd trả về:" + this.linkPdf);
                });
            },
            // Xuất excel
            exPort() {
                // this.CheckDuLieu();
                let url = "xuat-excel";
                // if (this.thongtin.role2 == 5) {
                //     this.ds_truong_hoc = [this.dangnhap.ma_truong_hoc]
                // }
                // if (!this.ds_truong_hoc||this.ds_truong_hoc.length==0){
                //     this.$alertify.error("Vui lòng chọn trường học để lấy thông tin.");
                //     return;
                // }
                let params = {
                    // "capHoc": this.ds_cap_hoc,
                    "namHoc": this.nam_hoc,
                    "collectionName": this.collectionName,
                    // "maTruongs": [this.ds_truong_hoc],
                    // "maDonVis": this.ds_don_vi
                };
                dialog.confirmDialog(
                    "Xác nhận tải xuống dữ liệu? Vui lòng chờ trong thời gian tải xuống.",
                    "Xác nhận",
                    () => {
                        api.post(url, params, (data) => {
                            let a = document.createElement('a');
                            a.href = data.data.file;
                            document
                                .body
                                .appendChild(a);
                            a.click();
                            document
                                .body
                                .removeChild(a);
                        });
                    }
                );

            },
            // Check dữ liệu
            CheckDuLieu() {
                console.log("check:" + this.danhSachTruongHoc)
                if (this.thongtin.role2 != 5) {
                    if (this.danhSachDonVi.length == 0) {
                        this.ds_don_vi = [];
                    }
                    if (this.danhSachTruongHoc == null) {
                        this.ds_truong_hoc = "";
                    }
                }

            },
            // Lấy dữ liệu
            getData() {
                this.pdf = false;
                // this.CheckDuLieu();
                this.TieuDe = "";
                this.Report = [];
                console.log("lấy:" + this.ds_truong_hoc)
                // if (!this.ds_truong_hoc||this.ds_truong_hoc.length==0){
                //     this.$alertify.error("Vui lòng chọn trường học để lấy thông tin.");
                //     return;
                // }
                this
                    .$alertify
                    .success("Đang lấy dữ liệu... Vui lòng chờ...")
                let params = {
                    // "capHoc": this.ds_cap_hoc,
                    "namHoc": this.nam_hoc,
                    "collectionName": this.collectionName,
                    // "collectionName": "BcCanBoCheDoLaoDong",
                    // "maTruongs": [this.ds_truong_hoc],
                    // "maDonVis": this.ds_don_vi
                };
                rest_api.post("/csdlgd-report-api/baoCao/report/", params, (data) => {
                    if (data.data.rc === 0) {
                        this.TieuDe = data.data;
                        if (!this.TieuDe.namHoc) {
                            this.TieuDe.namHoc = this.namhientai;
                        }
                        this.Report = data.data.reportData;
                        if (this.Report.length == 0) {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy")

                        } else {
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công")
                        }
                    } else {
                        this
                            .$alertify
                            .error("Vui lòng thử lại...")
                    }

                });
            },
            // Chọn đơn vị
            ChonDonVi() {
                console.log("chọn đơn vị");
                console.log(JSON.stringify(this.danhSachDonVi));
                this.ds_don_vi = [];
                this.list_truong_hoc = [];
                this.ds_truong_hoc = "";
                this.danhSachTruongHoc = [];
                if (this.danhSachDonVi) {
                    let lsdv = this
                        .danhSachDonVi
                        .map((obj) => {
                            return obj['maDonVi']
                        });
                    this.ds_don_vi = lsdv;
                    console.log("danh sách đơn vị:" + JSON.stringify(this.ds_don_vi));
                    this.getTruongHoc();
                }
            },
            // Gán năm học
            findNamHoc() {
                console.log("gán năm học:" + this.namhientai);
                this.nam_hoc = this.namhientai
                for (let i = 0; i < this.list_nam_hoc.length; i++) {
                    if (this.list_nam_hoc[i].id == this.namhientai) {
                        this.danhSachNamHoc = this.list_nam_hoc[i];
                    }
                }
            },
            // Chọn trường học
            ChonTruongHoc() {
                console.log("chọn trường học");
                console.log(JSON.stringify(this.danhSachTruongHoc));
                this.ds_truong_hoc = "";
                if (this.danhSachTruongHoc) {
                    let lsth = this
                        .danhSachTruongHoc.maTruongHoc;
                    this.ds_truong_hoc = lsth;
                    console.log("danh sách trường học:" + JSON.stringify(this.ds_truong_hoc));
                }
            },
            // Chọn năm học
            ChonNamHoc() {
                console.log("chọn trường học");
                console.log(JSON.stringify(this.danhSachNamHoc));
                this.nam_hoc = '';
                if (this.danhSachNamHoc) {
                    this.nam_hoc = this.danhSachNamHoc.id;
                }
                console.log("Năm học:" + this.nam_hoc);
            },
            // Lấy danh sách đơn vị
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.province
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        this.list_don_vi = data.data.rows;
                        if (this.thongtin.role2 == 4) {
                            this.danhSachDonVi = this.list_don_vi;
                            this.ds_don_vi = [
                                this
                                    .list_don_vi[0]
                                    .maDonVi
                            ];
                        }
                        console.log("Danh sách đơn vị:" + JSON.stringify(this.danhSachDonVi));
                        this.getTruongHoc();
                    }

                });
            },
            // Lấy trường học
            getTruongHoc() {
                array_util.clearArrays(this.list_truong_hoc);

                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: [this.ds_cap_hoc]
                };if (!this.ds_cap_hoc||this.ds_cap_hoc.length==0){
                    params.capHoc = [];
                }
                if (this.danhSachDonVi.length == 0) {
                    params.maDonVi = [];
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    if (data.data != null) {
                        if (data.data.code == 200) {
                            array_util.clearArrays(this.list_truong_hoc);
                            this.list_truong_hoc = data.data.rows;
                            console.log("danh sách trường học trả về:")
                            console.log(JSON.stringify(this.list_truong_hoc))
                        }
                    }
                });
            },
            // Gán dữ liệu
            bindDuLieu() {
                this.tenBaoCao = this.ten;
                this.collectionName = this.tenbaocao;
            },

            // định nghĩa cho đơn vị
            setNameDonVi({tenDonVi, maDonVi}) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // định nghĩa cho trường
            setNameTruongHoc({tenTruongHoc, maTruongHoc}) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            // định nghĩa cho cấp học
            setNameCapHoc({name}) {
                return `${name}`
            },
            // định nghĩa cho năm học
            setNameNamHoc({name}) {
                return `${name}`
            },
            close() {
                this.$emit('close')
            }
        }
    }
</script>
<style scoped="scoped">
    @import "../../../../../node_modules/selectwithsearch.css";

    a,
    h2,
    h3,
    h4,
    h5,
    h6,
    hr h1,
    label,
    p,
    span {
        padding: 0 !important;
        margin: 0 !important;
    }

    .red {
        color: #DC0101;
    }

    .cg {
        vertical-align: middle;
    }

    .noidung {
        height: 400px;
        overflow-x: scroll;
    }

    .noidung th,
    td {
        border: 1px solid black !important;
    }

    .vh {
        text-transform: uppercase;
    }

    .qh,
    .tn {
        font-size: 10pt;
    }

    .baoButton {
        text-align:right;
    }

    .baoButton > button {
        padding: 3px 15px;
    }


    .baoButton2 > button {
        padding: 3px 15px;
    }
</style>

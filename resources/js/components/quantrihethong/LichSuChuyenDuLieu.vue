<template>
    <!-- start template -->
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ </a><span><span class="kytu"> &raquo;</span> TIẾP NHẬN DỮ LIỆU QLNT <span
                        class="kytu"> &raquo;</span> LỊCH SỬ TIwẾP NHẬN DỮ LIỆUsss</span>
            </div>
        </div>
        <div>
            <div class="row">
                <div class="col-md-4 timkiem">
                    <label class="typo__label">Chọn đơn vị</label>
                    <div v-if="thongtin.role<4">
                        <multiselect v-model="danhSachDonVi" :options="ds_don_vi_custom" group-values="libs"
                            group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                            deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextDonVi"
                            :close-on-select="false" :multiple="true" @close="ChonDonVi" :clear-on-select="false"
                            :preserve-search="false" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                            selectedLabel="Đã chọn" :custom-label="setNameDonVi" placeholder="Chọn đơn vị"
                            track-by="tenDonVi">
                            <template v-if="danhSachDonVi.length>0" slot="selection"
                                slot-scope="{ values, search, isOpen }">
                                <span class="multiselect__single"
                                    v-if="values.length &amp;&amp; !isOpen">{{ danhSachDonVi.length }}
                                    đơn vị được chọn</span>
                            </template>
                            <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                            <span slot="noOptions">Danh sách trống</span>
                        </multiselect>
                    </div>
                    <div v-if="thongtin.role==5||thongtin.role==4">
                        <input disabled v-model="tenDonViDangNhap" class="form-control"
                            placeholder="Chọn" />
                    </div>
                    <!-- <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> -->
                </div>
                <div class="col-md-2 timkiem">
                    <div>
                        <label class="typo__label">Chọn cấp học</label>
                        <div v-if="thongtin.role!=5">
                            <multiselect v-model="danhSachCapHoc" :options="ds_cap_hoc_custom" group-values="libs"
                                group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                                deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextCapHoc"
                                :close-on-select="false" @close="ChonCapHoc" :multiple="true" :clear-on-select="false"
                                :preserve-search="false" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                                selectedLabel="Đã chọn" :custom-label="setNameCapHoc" placeholder="Chọn cấp học"
                                label="name" track-by="name">
                                <template v-if="danhSachCapHoc.length>0" slot="selection"
                                    slot-scope="{ values, search, isOpen }">
                                    <span class="multiselect__single"
                                        v-if="values.length &amp;&amp; !isOpen">{{ danhSachCapHoc.length }}
                                        cấp học được chọn</span>
                                </template>
                                <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                                <span slot="noOptions">Danh sách trống</span>
                            </multiselect>
                        </div>
                        <div v-if="thongtin.role==5">
                            <input :disabled="thongtin.role == 5" class="form-control" placeholder="Cấp học"
                                :value="capHocDangNhap" />
                        </div>
                    </div>
                </div>
                <!-- Mã trường -->
                <!-- hết mã trường -->
                <!-- Trường học -->
                <div class="col-md-4 timkiem">
                    <div v-if="thongtin.role!=5">
                        <label class="typo__label">Chọn trường học</label>
                        <multiselect v-model="danhSachTruongHoc" :options="list_truong_hoc_custom" group-values="libs"
                            group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                            deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextTruong"
                            :multiple="true" @close="ChonTruongHoc" :close-on-select="false" :clear-on-select="false"
                            deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                            :custom-label="setNameTruongHoc" placeholder="Chọn trường học" label="maTruongHoc"
                            track-by="maTruongHoc">
                            <template v-if="danhSachTruongHoc.length>0" slot="selection"
                                slot-scope="{ values, search, isOpen }">
                                <span class="multiselect__single"
                                    v-if="values.length &amp;&amp; !isOpen">{{ danhSachTruongHoc.length }}
                                    trường học được chọn</span>
                            </template>
                            <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                            <span slot="noOptions">Danh sách trống</span>
                        </multiselect>
                    </div>
                    <div v-if="thongtin.role==5">
                        <label>Trường học</label>
                        <input :disabled="thongtin.role == 5" :value="thongtin.display_name" class="form-control"
                            placeholder="Nhập..." />
                    </div>
                </div>
                <!-- Hết trường học -->
                <!-- Năm học -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Năm học</label>
                    <multiselect v-model="danhSachNamHoc" :options="list_nam_hoc" :custom-label="setNameNamHoc"
                        placeholder="Chọn năm học" label="name" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                        selectedLabel="Đã chọn" track-by="name"></multiselect>
                </div>
                <!-- Hết năm học -->
                <!-- Thời gian đẩy -->
                <div class="col-md-2 timkiem">
                    <label>Ngày bắt đầu đẩy</label>
                    <date-picker v-model="ngayBatDau" :config="configDate" @dp-change="ChonNgayDauNamBatDau"
                        placeholder="Chọn ngày bắt đầu"></date-picker>
                </div>
                <div class="col-md-2 timkiem">
                    <label>Ngày kết thúc đẩy</label>
                    <date-picker v-model="ngayKetThuc" :config="configDate" placeholder="Chọn ngày kết thúc">
                    </date-picker>
                </div>
                <!-- Hết thời gian đẩy -->
                <!-- Mã giao dịch -->
                <div class="col-md-2 timkiem">
                    <label>Mã lần đẩy</label>
                    <input v-model="ma_giao_dich" class="form-control" placeholder="Nhập..." />
                </div>
                <!-- Hết mã giao dịch -->
                <!-- Trạng thái -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Đối tác</label>
                    <multiselect v-model="danhSachDoiTac" :options="ds_doi_tac" :custom-label="setNameDoiTac"
                        placeholder="Chọn đối tác" label="tenDoiTac" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                        selectedLabel="Đã chọn" track-by="tenDoiTac"></multiselect>
                </div>
                <div class="col-md-4 timkiem">
                    <label class="typo__label">Trạng thái</label>
                    <multiselect v-model="danhSachTrangThai" :options="ds_trang_thai_tiep_nhan_du_lieu"
                        :custom-label="setNameDanhSachTrangThai" placeholder="Chọn trạng thái" label="name"
                        deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn" track-by="name">
                    </multiselect>
                </div>
                <!-- hết trạng thái -->
                <!-- Loại đồng bộ -->
                <div class="col-md-4 timkiem">
                    <label class="typo__label">Loại đồng bộ</label>
                    <multiselect v-model="danhSachLoaiDongBo" :options="ds_loai_dong_bo"
                        :custom-label="setNameDanhSachTrangThai" placeholder="Chọn loại đợt" label="name"
                        deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn" track-by="name">
                    </multiselect>
                </div>
                <!-- Hết loại đồng bộ -->
                <!-- Loại đợt -->
                <div class="col-md-4 timkiem">
                    <label class="typo__label">Loại đợt</label>
                    <multiselect v-model="danhSachLoaiDot" :options="ds_loai_dot"
                        :custom-label="setNameDanhSachTrangThai" placeholder="Chọn loại đợt" label="name"
                        deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn" track-by="name">
                    </multiselect>
                </div>
                <!-- Hết loại đợt -->
                <!-- Đối tác -->
                <!-- Hết đối tác -->
            </div>
        </div>
        <!-- end filter -->
        <!-- button -->
        <div class="row text-center">
            <button class="btn btn-success" @click.prevent="truocKhiTim()">Tìm kiếm
            </button>
        </div>
        <hr style="margin:5px 0;" />
        <!-- end button -->
        <!-- Danh sách dữ liệu -->
        <div class="row">
            <div class="col-md-12 table-responsive">
                <table class="table table-bordered table-striped table-hover"
                    style="font-size:12px; width:100%; overflow-x:scroll;">
                    <thead>
                        <tr style="background: #e4ebf5; font-size:12px;">
                            <th class="text-center">STT</th>
                            <th class="text-center">Mã lần đẩy</th>
                            <th class="text-center">Đối tác</th>
                            <th class="text-center">Tên trường</th>
                            <th class="text-center">Mã trường</th>
                            <th class="text-center">Thời gian đẩy</th>
                            <th class="text-center">Thời gian xử lý</th>
                            <th class="text-center">Loại đồng bộ</th>
                            <th class="text-center">Năm đồng bộ</th>
                            <th class="text-center">Loại đợt</th>
                            <th class="text-center">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-if="ds_lich_su_chuyen_du_lieu_truong.length==0">
                            <th colspan="11" class="text-center" style="font-weight:400">
                                <p>Không có dữ liệu</p>
                            </th>
                        </tr>
                        <tr v-else="v-else" v-for="(px,index) in ds_lich_su_chuyen_du_lieu_truong">
                            <td class="text-center">{{(currentPage-1)*limit + index+1}}</td>
                            <td>{{px.reqMessId}}</td>
                            <td>{{px.tenDoitac}}</td>
                            <td>{{px.tenTruongHoc}}</td>
                            <td>{{px.maTruongHoc}}</td>
                            <td>{{px.timeDay}}</td>
                            <td>
                                <p>{{px.timePhanHoi}}</p>
                            </td>
                            <td>{{getLoaiDuLieu(parseInt(px.loaiDuLieu))}}</td>
                            <td>{{px.namHoc}}-{{px.namHoc+1}}</td>
                            <td>{{getDot(parseInt(px.loaiDot))}}</td>
                            <td class="text-center link" style="text-align: center">
                                <a style="padding:0px 5px; border:1px solid blue; border-radius:50%" title="Chi tiết"
                                    href="#" v-on:click.prevent="detail(px.maGiaoDich, px.loaiDuLieu)">
                                    <i class="fas fa-info"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
                <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                <template >
                    <ChiTietLichSuChuyenDuLieu :show="show_detail" :item="du_lieu" @close="show_detail=false"></ChiTietLichSuChuyenDuLieu>
                </template>
        </div>

        <!-- hết danh sách -->
    </div>
    <!-- end template -->
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import constant from "../../utils/constant";
    import datePicker from "vue-bootstrap-datetimepicker";
    import moment from "moment";
    import ChiTiet from "./ChiTietLichSuChuyenDuLieu";
    import {
        mapState,
        mapMutations
    } from 'vuex';
    import Page from "../ui/PagingCustom";
    import VueAlertify from "vue-alertify";
    import {
        Loading
    } from 'element-ui';
    Vue.use(VueAlertify, {

        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {
        props: ['trangcu'],
        components: {
            Multiselect,
            datePicker,
            ChiTietLichSuChuyenDuLieu: ChiTiet,
            Page: Page
        },
        data() {
            return {
                //custom lại để cho chọn tất cả

                ds_don_vi_custom: [{
                    selectAll: 'Chọn tất cả',
                    libs: []
                }, ],
                list_truong_hoc_custom: [],

                ds_cap_hoc_custom: [{
                    selectAll: 'Chọn tất cả',
                    libs: []
                }, ],
                // dùng chung
                capHocDangNhap: "",
                thongTinTrangCu: [],
                trangbatdau: false,
                show_detail: false,
                total_rows: 0,
                du_lieu: {},
                start: 0,
                currentPage: 1,
                limit: 25,
                ds_lich_su_chuyen_du_lieu_truong: [],
                pr: "",
                tenDonViDangNhap: "",
                thongtin: {},
                configDate: {
                    format: "DD/MM/YYYY",
                    useCurrent: false,
                    showTodayButton: true,
                    locale: "vi"
                },
                // filter
                date: new Date(),
                namHocHienTai: "",
                maTruongHoc: "",
                dot_dong_bo: "",
                loai_dong_bo: "",
                ma_giao_dich: "",
                doi_tac: "",
                namHoc: "",
                ngayBatDau: "",
                ngayKetThuc: "",
                danhSachDonVi: [],
                danhSachCapHoc: [],
                danhSachTruongHoc: [],
                danhSachNamHoc: [],
                danhSachLoaiDongBo: [],
                danhSachLoaiDot: [],
                danhSachDoiTac: [],
                danhSachTrangThai: [],
                // danh sách để gủi đi
                status: "",
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_truong_hoc: [],
                ds_doi_tac: [],
                list_don_vi: [],
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_truong_hoc: [],
                ds_trang_thai_tiep_nhan_du_lieu: constant.ds_trang_thai_tiep_nhan_du_lieu,
                ds_loai_dot: constant.ds_loai_tiep_nhan_du_lieu,
                ds_loai_dong_bo: constant.ds_loai_dong_bo_tiep_nhan_du_lieu,
                // end_filter
            }
        },
        watch: {
            danhSachTrangThai: function (newVal) {
                console.log("watch trạng thái:" + JSON.stringify(newVal));
                this.status = "";
                if (newVal) {
                    this.status = newVal.id;
                }
            },
            danhSachCapHoc: function (newVal) {},
            danhSachNamHoc: function (newVal) {
                console.log("watch Năm học:" + newVal);
                this.namHoc = "";
                if (newVal) {
                    this.namHoc = newVal
                        .id
                    console
                        .log("map xong:" + JSON.stringify(this.namHoc));
                }
            },
            danhSachLoaiDot: function (newVal) {
                console.log("watch đợt");
                this.dot_dong_bo = "";
                if (newVal) {
                    this.dot_dong_bo = newVal.id

                }
                console.log("map xong:" + this.dot_dong_bo);
            },
            danhSachLoaiDongBo: function (newVal) {
                console.log("watch loại");
                this.loai_dong_bo = "";
                if (newVal) {
                    this.loai_dong_bo = newVal.id

                }
                console.log("map xong:" + this.loai_dong_bo);
            },
            danhSachDoiTac: function (newVal) {
                console.log("watch đối tác");
                this.doi_tac = "";
                if (newVal) {
                    this.doi_tac = newVal.maDoiTac
                }
                console.log("CHọn xong đối tác:" + this.doi_tac);
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.ds_cap_hoc_custom[0].libs = this.list_cap_hoc;
            if (this.thongtin.role == 5) {
                this.maTruongHoc = this.thongtin.ma_truong_hoc;
                this.bindCapHocDangNhap();
            }
            this.namHocHienTai = this
                .date
                .getFullYear();
            let thangNay = this
                .date
                .getMonth();
            thangNay = parseInt(thangNay) + 1;
            if (thangNay > 8) {} else {
                this.namHocHienTai -= 1;
            }
            this.findNamHoc();
            if (this.thongtin.role == 5) {
                this.maTruongHoc = this.thongtin.ma_truong_hoc
            }
            this.getDonVi(() => {
                console.log("Lấy đơn vị")
                // check trang cũ hay không
                if (this.trangcu != "[]") {
                    this.thongTinTrangCu = this.trangcu;
                    this.chuyenHuong(() => {
                        if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                            this.getDanhSachLichSuChuyenDuLieu();
                        }
                    });
                    return
                } else {
                    if (this.thongtin.role == 4 || this.thongtin.role == 5) {
                        console.log("Thông tin đăng nhập là trường:");
                        console.log(JSON.stringify(this.list_don_vi))
                        for (let i = 0; i < this.list_don_vi.length; i++) {
                            if (this.list_don_vi[i].maDonVi == this.thongtin.ma_don_vi) {
                                console.log("1")
                                this.danhSachDonVi = [this.list_don_vi[i]];
                                console.log("21")
                                console.log(JSON.stringify(this.danhSachDonVi))
                                this.tenDonViDangNhap = this
                                    .danhSachDonVi[0]
                                    .tenDonVi;
                                console.log(JSON.stringify("Tên đơn vị đăng nhập:" + this.tenDonViDangNhap))
                            }
                        }
                        setTimeout(() => {
                            // this.getDanhSachLichSuChuyenDuLieu();
                        }, 100);
                    } else {
                        // this.getDanhSachLichSuChuyenDuLieu();
                    }
                }
            });
            this.getTruongHoc();
            this.getListDoiTac();
        },
        methods: {
            truocKhiTim() {
                console.log("**********************");
                this.trangbatdau = !this.trangbatdau;
            },
            limitTextTruong(count) {
                return `và ${count} trường học khác`
            },
            limitTextCapHoc(count) {
                return `và ${count} cấp học khác`
            },
            limitTextDonVi(count) {
                return `và ${count} đơn vị khác`
            },
            ChonTruongHoc() {
                this.ds_truong_hoc = [];
                console.log("Chọn trường học:")
                if (this.danhSachTruongHoc) {
                    let lsth = this.danhSachTruongHoc.map((obj) => {
                        return obj['maTruongHoc']
                    });
                    this.ds_truong_hoc = lsth;
                }
                console.log("Danh sách trường học được chọn:" + JSON.stringify(this.ds_truong_hoc))
            },
            ChonCapHoc() {
                console.log("Chọn cấp học")
                this.thongTinTrangCu = [];
                this.list_truong_hoc_custom = [];
                this.ds_cap_hoc = [];
                this.ds_truong_hoc = [];
                this.danhSachTruongHoc = [];
                if (this.danhSachCapHoc) {
                    let lsch = this.danhSachCapHoc.map((obj) => {
                        return obj['id']
                    });
                    this.ds_cap_hoc = lsch;
                }
                this.getTruongHoc();
            },

            ChonDonVi() {
                console.log("Chọn đơn vị");
                this.list_truong_hoc_custom = [];
                this.ds_don_vi = [];
                this.ds_truong_hoc = [];
                this.thongTinTrangCu = [];
                this.danhSachTruongHoc = [];
                if (this.danhSachDonVi) {
                    let lsdv = this.danhSachDonVi.map((obj) => {
                        return obj['maDonVi']
                    });
                    this.ds_don_vi = lsdv;
                }
                console.log("Danh sách đơn vị sau khi chọn là:");
                console.log(JSON.stringify(this.ds_don_vi))
                this.getTruongHoc();
            },
            bindCapHocDangNhap() {
                if (this.thongtin.listCapHoc.length == 1) {
                    for (let i = 0; i < this.thongtin.listCapHoc.length; i++) {
                        if (this.thongtin.listCapHoc[0] == 1) {
                            this.capHocDangNhap = "Tiểu học";
                        }
                        if (this.thongtin.listCapHoc[0] == 2) {
                            this.capHocDangNhap = "THCS";
                        }
                        if (this.thongtin.listCapHoc[0] == 3) {
                            this.capHocDangNhap = "THPT";
                        }
                        if (this.thongtin.listCapHoc[0] == 4) {
                            this.capHocDangNhap = "Nhà trẻ";
                        }
                        if (this.thongtin.listCapHoc[0] == 5) {
                            this.capHocDangNhap = "Nhà trẻ";
                        }
                        if (this.thongtin.listCapHoc[0] == 6) {
                            this.capHocDangNhap = "GDTX";
                        }
                    }
                } else {
                    if (this.thongtin.listCapHoc[0] == 4 && this.thongtin.listCapHoc[1] == 5) {
                        this.capHocDangNhap = "Mầm non";
                    } else {
                        this.capHocDangNhap = "Trường liên cấp";
                    }
                }
            },
            // gán năm học

            findNamHoc() {
                for (let i = 0; i < this.list_nam_hoc.length; i++) {
                    if (this.list_nam_hoc[i].id == this.namHocHienTai) {
                        this.danhSachNamHoc = this.list_nam_hoc[i];
                    }
                }
            },
            // bind dữ liệu khi chuyển hướng
            chuyenHuong(ch = () => {}) {

                window
                    .history
                    .replaceState("", "CSDL Ngành", "Data-transfer-schedule");
                this.thongTinTrangCu = JSON.parse(this.thongTinTrangCu)
                if (this.thongTinTrangCu.namHoc) {
                    // Nếu có năm học
                    for (let i = 0; i < this.list_nam_hoc.length; i++) {
                        if (this.list_nam_hoc[i].id == this.thongTinTrangCu.namHoc) {
                            this.danhSachNamHoc = this.list_nam_hoc[i];
                        }
                    }
                }
                if (this.thongTinTrangCu.maTruongHoc) {
                    this.maTruongHoc = this.thongTinTrangCu.maTruongHoc;
                    this.getTruongHoc(() => {
                        for (let i = 0; i < this.list_truong_hoc_custom[0].libs.length; i++) {
                            if (this.list_truong_hoc_custom[0].libs[i].maTruongHoc == this.thongTinTrangCu
                                .maTruongHoc) {
                                this.danhSachTruongHoc = [this.list_truong_hoc_custom[0].libs[i]];
                                this.ds_truong_hoc = this
                                    .danhSachTruongHoc
                                    .map((obj) => obj.maTruongHoc);
                                ch();
                            }
                        }
                    })
                }
            },
            // Tìm kiếm danh sách dữ liệu
            getDanhSachLichSuChuyenDuLieu() {
                this.ds_lich_su_chuyen_du_lieu_truong = [];
                let params = {
                    status: this.status,
                    capHoc: this.ds_cap_hoc,
                    loaiDayDuLieu: this.loai_dong_bo,
                    loaiDot: this.dot_dong_bo,
                    maDoiTacCha: this.doi_tac,
                    maDonVi: this.ds_don_vi,
                    maGiaoDich: this.ma_giao_dich,
                    maTruong: this.maTruongHoc,
                    maTruongHoc: this.ds_truong_hoc,
                    namDayDulieu: this.namHoc,
                    timeDayEnd: this.ngayKetThuc,
                    start: this.start,
                    limit: this.limit,
                    timeDayStart: this.ngayBatDau
                };
                console.log("1234567890-");
                this.pr = params;
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/history-syncdata/school/v2", params, data => {
                    loading.close();
                    if (data.data.rc == 0) {
                        array_util.clearArrays(this.ds_lich_su_chuyen_du_lieu_truong);
                        this.ds_lich_su_chuyen_du_lieu_truong = data.data.rows;
                        this.total_rows = data.data.total;
                        if (this.total_rows == 0) {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy");
                            return;

                        } else {

                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công");
                        }
                    } else {
                        this
                            .$alertify
                            .error(data.data.rd);
                        return;
                    }
                }, 60000, true);
            },
            // Lấy danh sách đơn vị
            getDonVi(ck = () => {}) {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so,
                };
                console.log("pr lấy đơn vị:" + JSON.stringify(params))
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    // console.log("lấy đơn vị thành công" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        this.list_don_vi = data.data.rows;
                        let obj = {
                            selectAll: "Chọn tất cả",
                            libs: this.list_don_vi
                        }
                        this.ds_don_vi_custom = [obj];
                        if (this.thongtin.role == 5) {
                            console.log("Thông tin đăng nhập là trường nè");
                        }
                        ck();
                    }
                });
            },
            // Chọn ngày bắt đầu đẩy
            ChonNgayDauNamBatDau() {
                if (this.ngayBatDau != null) {
                    let endDauNam = moment(this.ngayBatDau, "DD/MM/YYYY")
                        .add(10, "days")
                        .format("DD/MM/YYYY");
                    this.ngayKetThuc = endDauNam;
                }
            },
            // Lấy trường học
            getTruongHoc(gt = () => {}) {
                this.list_truong_hoc_custom = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc
                };
                if (this.thongTinTrangCu.maTruongHoc) {
                    params.maTruong = this.thongTinTrangCu.maTruongHoc;
                }
                console.log("laays truowngf hocj:");
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    if (data.data.code == 200) {
                        this.list_truong_hoc = data.data.rows;
                        let obj = {
                            selectAll: "Chọn tất cả",
                            libs: this.list_truong_hoc,
                        }
                        this.list_truong_hoc_custom = [obj];
                        gt();
                    }
                });
            },
            // định nghĩa cho đơn vị
            setNameDonVi({
                tenDonVi,
                maDonVi
            }) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // định nghĩa cho trường
            setNameTruongHoc({
                tenTruongHoc,
                maTruongHoc
            }) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            // định nghĩa cho cấp học
            setNameCapHoc({
                name
            }) {
                return `${name}`
            },
            // định nghĩa cho năm học
            setNameNamHoc({
                name
            }) {
                return `${name}`
            },
            // định nghĩa cho đối tác
            setNameDoiTac({
                tenDoiTac,
                maDoiTac
            }) {
                return `${tenDoiTac} - [${maDoiTac}]`
            },
            // định nghĩa cho trạng thái
            setNameDanhSachTrangThai({
                name
            }) {
                return `${name}`
            },
            // Lấy danh sách đối tác

            getListDoiTac() {
                let params = {
                    start: 0,
                    limit: 99999,
                    trangThai: 1
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/heThongDoiTac/getMaDoiTacCha", params, data => {
                    loading.close();
                    console.log("danh sách đối tác trả về:" + JSON.stringify(data.data))
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_doi_tac);
                        this.ds_doi_tac = data.data.rows;
                        let doi_tac_tmp = [];
                        for (let i = 0; i < this.ds_doi_tac.length; i++) {
                            let obj = {};
                            obj.maDoiTac = this.ds_doi_tac[i];
                            obj.tenDoiTac = this.ds_doi_tac[i];
                            doi_tac_tmp.push(obj);
                        }
                        this.ds_doi_tac = doi_tac_tmp;
                    }
                });
            },
            getLoaiDuLieu(loai) {
                var res = loai;
                switch (loai) {
                    case 1:
                        res = "Sửa học sinh theo lô";
                        break;
                    case 2:
                        res = "Sửa giáo viên theo lô";
                        break;
                    case 3:
                        res = "Đẩy thông tin đầu năm";
                        break;
                    case 4:
                        res = "Đẩy thông tin học sinh biến động";
                        break;
                    case 5:
                        res = "Đẩy thông tin điểm";
                        break;
                    case 6:
                        res = "Đẩy thông tin cuối năm";
                        break;
                    case 8:
                        res = "Đẩy dữ liệu đầu năm (*)";
                        break;
                    case 9:
                        res = "EQMS giữa năm";
                        break;
                    default:
                        res = loai;
                }
                return res;
            },

            ...mapMutations(['setLoaiDuLieu']),
            getDot(loai) {
                var res = loai;
                switch (loai) {
                    case 1:
                        res = "Đẩy thông tin đầu năm";
                        break;
                    case 2:
                        res = "Đẩy thông tin phát sinh";
                        break;
                    case 3:
                        res = "Đẩy thông tin cuối năm";
                        break;
                    case 4:
                        res = "Đồng bộ dữ liệu cũ";
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            // Lấy lại danh sách dữ liệu
            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getDanhSachLichSuChuyenDuLieu();
            },
            // Xem chi tiết
            detail(px, dl) {
                console.log("Xem chi tiết")
                this.du_lieu = px;
                this.setLoaiDuLieu(dl);
                this.show_detail = true;
            }
        }
    }

</script>
<style scoped="scoped">
    @import "../../../../node_modules/selectwithsearch.css";

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        padding: 0;
        margin: 0;
    }

    hr {
        margin: 5px;
    }

    .timkiem input {
        margin-bottom: 10px;
    }

</style>

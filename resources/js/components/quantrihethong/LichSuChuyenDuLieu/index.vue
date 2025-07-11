<template>
    <div>
        <Breadcrumb :menu="'Tiếp nhận dữ liệu QLNT'" :desc="'Lịch sử tiếp nhận dữ liệu'" />
        <div class="card-bieu-do">
            <el-form :model='dataSearch' :rules="rules" ref="ruleForm">
                <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :sm="24" :lg="12">
                        <label class="typo__label">Đơn vị quản lý</label>
                        <eselect style="width:100%" @change="layLaiTruong" :disabled="thongtin.role>3" multiple
                                 collapseTags v-model="donVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                 :fields="['tenDonVi','maDonVi']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Cấp học </label>
                        <eselect style="width:100%" @change="layLaiTruong" :disabled="thongtin.role==5" multiple
                                 collapseTags v-model="capHoc" :placeholder="'Chọn'" filterable
                                 :data="danh_sach_cap_hoc_full" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Năm học <span style="color:#DC0101">*</span> </label>
                        <el-form-item prop="namHoc">
                            <eselect style="width:100%" ref="namHoc" collapseTags v-model="dataSearch.namHoc"
                                     :placeholder="'Chọn'" filterable :data="list_nam_hoc" :fields="['name','id']" />
                        </el-form-item>
                    </el-col>
                    <el-col :sm="24" :lg="12">
                        <label class="typo__label">Trường học <span style="color:#DC0101">*</span> </label>

                        <el-form-item prop="truongHoc">
                            <eselect ref="truongHoc" style="width:100%" multiple collapseTags
                                     :disabled="thongtin.role==5" v-model="dataSearch.truongHoc" :placeholder="'Chọn'"
                                     filterable :data="list_truong_hoc" :fields="['name','value']" />
                        </el-form-item>
                        <!--
                        <div v-if="thongtin.role==5">
                            <input :disabled="thongtin.role == 5" :value="thongtin.display_name" class="form-control"
                                placeholder="Nhập..." />
                        </div> -->
                    </el-col>

                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Ngày nhận dữ liệu</label>
                        <date-picker :lang="lang" class="dts-chonNgay" v-model="ngayBatDauDay" placeholder="Chọn ngày"
                                     valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                        </date-picker>
                    </el-col>
                    <!--                <el-col :span="4">-->
                    <!--                    <label class="typo__label">Ngày kết thúc </label>-->
                    <!--                    <date-picker class="dts-chonNgay" v-model="ngayKetThucDay" placeholder="Chọn ngày" valueType="format"-->
                    <!--                                 value-type="DD/MM/YYYY" format="DD/MM/YYYY">-->
                    <!--                    </date-picker>-->
                    <!--                </el-col>-->
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Mã lần đẩy </label>
                        <el-input clearable placeholder="Nhập..." @change="maGiaoDich = maGiaoDich.trim()"
                                  @input="maGiaoDich = maGiaoDich.trim()" v-model.trim="maGiaoDich"></el-input>
                    </el-col>

                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Đối tác </label>
                        <eselect style="width:100%" collapseTags v-model="maDoiTac" :placeholder="'Chọn'" filterable
                                 :data="list_doi_tac" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Trạng thái </label>
                        <eselect style="width:100%" collapseTags v-model="trangThai" :placeholder="'Chọn'" filterable
                                 :data="list_trang_thai" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Loại đồng bộ </label>
                        <eselect style="width:100%" collapseTags v-model="loaiDongBo" :placeholder="'Chọn'" filterable
                                 :data="list_loai_dong_bo" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Loại đợt</label>
                        <eselect style="width:100%" collapseTags v-model="loaiDot" :placeholder="'Chọn'" filterable
                                 :data="list_loai_dot" :fields="['name','id']" />
                    </el-col>

                    <el-col :span="24" class="text-center">
                        <el-button class="bt-chinh" size="mini" @click.prevent="submitForm('ruleForm')" type="success">Tìm
                            kiếm
                        </el-button>
                    </el-col>
                </el-row>
            </el-form>

        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <el-col :span="24" class="">
                    <label class="table-name">Lịch sử tiếp nhận dữ liệu</label>
                </el-col>
                <el-col :span="24" style="padding:0">
                    <el-table
                            :data="danh_sach_du_lieu"
                            border
                            stripe
                           max-height="600"
                            empty-text="Không có bản ghi nào"
                    >
                        <!-- STT -->
                        <el-table-column
                                label="STT"
                                align="center"
                                fixed="left"
                                :min-width="columnWidths.stt"
                        >
                            <template #default="{ $index }">
                                <p>{{ (currentPage - 1) * limit + $index + 1 }}</p>
                            </template>
                        </el-table-column>

                        <!-- Thao tác -->
                        <el-table-column
                                label="Thao tác"
                                align="center"
                                fixed="right"
                                :min-width="columnWidths.thaoTac"
                        >
                            <template #default="{ row }">
                                <el-tooltip content="Xem chi tiết" placement="left">
                                    <i
                                            class="el-icon-view"
                                            @click.prevent="xemChiTiet(row.maGiaoDich, row.loaiDuLieu)"
                                    ></i>
                                </el-tooltip>
                            </template>
                        </el-table-column>

                        <!-- Mã lần đẩy -->
                        <el-table-column
                                label="Mã lần đẩy"
                                :min-width="columnWidths.maLanDay"
                        >
                            <template #default="{ row }">
                                <p>{{ row.reqMessId }}</p>
                            </template>
                        </el-table-column>

                        <!-- Đối tác -->
                        <el-table-column
                                label="Đối tác"
                                :min-width="columnWidths.doiTac"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenDoitac }}</p>
                            </template>
                        </el-table-column>

                        <!-- Trường học -->
                        <el-table-column
                                label="Trường học"
                                :min-width="columnWidths.truongHoc"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenTruongHoc }}</p>
                            </template>
                        </el-table-column>

                        <!-- Mã trường -->
                        <el-table-column
                                label="Mã trường"
                                align="center"
                                :min-width="columnWidths.maTruong"
                        >
                            <template #default="{ row }">
                                <p>{{ row.maTruongHoc }}</p>
                            </template>
                        </el-table-column>

                        <!-- Thời gian nhận -->
                        <el-table-column
                                label="Thời gian nhận"
                                :min-width="columnWidths.thoiGianNhan"
                        >
                            <template #default="{ row }">
                                <p>{{ row.timeDay }}</p>
                            </template>
                        </el-table-column>

                        <!-- Thời gian xử lý -->
                        <el-table-column
                                label="Thời gian xử lý"
                                :min-width="columnWidths.thoiGianXuLy"
                        >
                            <template #default="{ row }">
                                <p>{{ row.timePhanHoi }}</p>
                            </template>
                        </el-table-column>

                        <!-- Loại đồng bộ -->
                        <el-table-column
                                label="Loại đồng bộ"
                                :min-width="columnWidths.loaiDongBo"
                        >
                            <template #default="{ row }">
                                <p>{{ getLoaiDuLieu(parseInt(row.loaiDuLieu)) }}</p>
                            </template>
                        </el-table-column>

                        <!-- Năm đồng bộ -->
                        <el-table-column
                                label="Năm đồng bộ"
                                align="center"
                                :min-width="columnWidths.namDongBo"
                        >
                            <template #default="{ row }">
                                <p>{{ row.namHoc }}-{{ row.namHoc + 1 }}</p>
                            </template>
                        </el-table-column>

                        <!-- Loại đợt -->
                        <el-table-column
                                label="Loại đợt"
                                :min-width="columnWidths.loaiDot"
                        >
                            <template #default="{ row }">
                                <p>{{ getDot(parseInt(row.loaiDot)) }}</p>
                            </template>
                        </el-table-column>
                    </el-table>

<!--                    <div class="table-responsive">-->
<!--                        <table class="table table-striped table-bordered table-hover">-->
<!--                            <thead>-->
<!--                                <tr style="background:rgb(228, 235, 245)">-->
<!--                                    <th class="text-center fixed-column fixed-col1">-->
<!--                                        <p>STT</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center fixed-column fixed-col2">-->
<!--                                        <p>Thao tác</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Mã lần đẩy</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center">-->
<!--                                        <p>Đối tác</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Trường học</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center">-->
<!--                                        <p>Mã trường</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Thời gian nhận</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Thời gian xử lý</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Loại đồng bộ</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center">-->
<!--                                        <p>Năm đồng bộ</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Loại đợt</p>-->
<!--                                    </th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody v-if="danh_sach_du_lieu.length===0">-->
<!--                                <tr>-->
<!--                                    <td class="text-center" colspan="11">-->
<!--                                        <p>Không có bản ghi nào</p>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                            <tbody v-else>-->
<!--                                <tr v-for="(px,index) in danh_sach_du_lieu">-->
<!--                                    <td class="text-center fixed-column fixed-col1">-->
<!--                                        <p>{{(currentPage-1)*limit + index+1}}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center fixed-column fixed-col2">-->
<!--                                        <el-tooltip content="Xem chi tiết " placement="left">-->
<!--                                            &lt;!&ndash; <el-button plain type="info"-->
<!--                                            v-on:click.prevent="xemChiTiet(px.maGiaoDich, px.loaiDuLieu)"-->
<!--                                            size="mini" icon="el-icon-info"></el-button> &ndash;&gt;-->
<!--                                            <i @click.prevent="xemChiTiet(px.maGiaoDich, px.loaiDuLieu)"-->
<!--                                                class="el-icon-view"></i>-->
<!--                                        </el-tooltip>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{px.reqMessId}} </p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{px.tenDoitac}}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{px.tenTruongHoc}}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <p>{{px.maTruongHoc}}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{px.timeDay}}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{px.timePhanHoi}}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{getLoaiDuLieu(parseInt(px.loaiDuLieu))}}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <p>{{px.namHoc}}-{{px.namHoc+1}}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{getDot(parseInt(px.loaiDot))}}</p>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
                </el-col>

                <el-col :span="24">
                    <PhanTrang :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                    </PhanTrang>
                </el-col>
            </el-row>
        </div>
        <div>
            <ChiTietLichSuChuyenDuLieu :show="show_chi_tiet" :item="duLieuChiTiet" @close="show_chi_tiet=false">
            </ChiTietLichSuChuyenDuLieu>
        </div>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import constant from '../../../utils/constant';
    import ESelectVue from '../../ui/ESelect.vue';
    import PhanTrang from "../../ui/PagingCustom";
    import ChonSoLuong from "../../ui/chonSoLuongBanGhi";
    import moment from 'moment';
    import ChiTietLichSuChuyenDuLieu from "./ChiTietLichSuChuyenDuLieu";
    import DatePicker from 'vue2-datepicker';
    import {
        mapState,
        mapMutations
    } from 'vuex';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/vi';
    import Breadcrumb from "../../ui/Breadcrumb.vue";

    export default {
        props: ['trangcu'],
        components: {
            'eselect': ESelectVue,
            "PhanTrang": PhanTrang,
            ChonSoLuong: ChonSoLuong,
            ChiTietLichSuChuyenDuLieu: ChiTietLichSuChuyenDuLieu,
            Breadcrumb
        },
        data() {
            return {
                columnWidths: {
                    stt: 50,
                    thaoTac: 100,
                    maLanDay: 120,
                    doiTac: 150,
                    truongHoc: 150,
                    maTruong: 120,
                    thoiGianNhan: 150,
                    thoiGianXuLy: 150,
                    loaiDongBo: 150,
                    namDongBo: 130,
                    loaiDot: 100,
                },

                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false,
                },
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                soLuongBanGhiHienThi: 25,
                trangbatdau: false,
                show_chi_tiet: false,
                duLieuChiTiet: {},
                danh_sach_du_lieu: [],
                thongtin: JSON.parse(window.userInfo),
                donVi: [],
                capHoc: [],
                truongHoc: [],
                date: new Date(),
                namHoc: "",
                ngayBatDauDay: "",
                ngayKetThucDay: "",
                maGiaoDich: "",
                maDoiTac: "",
                trangThai: "",
                loaiDongBo: "",
                loaiDot: "",
                dataSearch: {
                    truongHoc: [],
                    namHoc: '',
                },
                rules: {
                    truongHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'blur'
                    }, ],
                    namHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                },
                list_don_vi: [],
                danh_sach_cap_hoc_full: window.listCapHoc,
                list_truong_hoc: [],
                list_doi_tac: [],
                list_trang_thai: constant.ds_trang_thai_tiep_nhan_du_lieu,
                list_loai_dong_bo: constant.ds_loai_dong_bo_tiep_nhan_du_lieu,
                list_loai_dot: constant.ds_loai_tiep_nhan_du_lieu,
                list_nam_hoc: constant.LIST_YEARS_FULL,
            }
        },
        watch: {},
        mounted: function () {
            this.dataSearch.namHoc = this.thongtin.namHocHienTai;
            console.log("Thông tin đăng nhập:")
            console.log(this.thongtin)
            if (this.thongtin.role > 3) {
                this.donVi = [this.thongtin.ma_don_vi];
            }
            if (this.thongtin.role == 5) {
                this.capHoc = this.thongtin.listCapHoc;
                this.dataSearch.truongHoc = [this.thongtin.ma_truong_hoc.toUpperCase()]
            }
            this.getDonVi();
            this.getDoiTac();
            if (this.trangcu != 0) {
                if (this.trangcu.dotDay) {
                    this.maGiaoDich = this.trangcu.dotDay;
                }
                if (this.trangcu.namHoc) {
                    this.dataSearch.namHoc = this.trangcu.namHoc;
                }
                if (this.trangcu.maTruongHoc) {
                    this.dataSearch.truongHoc = [this.trangcu.maTruongHoc];
                }
                window
                    .history
                    .replaceState("", "Cơ sở dữ liệu ngành", "Data-transfer-schedule");
                this.getData();
            } else {
                // console.log("Lấy dữ liệu")
                // this.getData();
            }
        },
        methods: {
            // Tính toán độ rộng cột dựa trên nội dung
            updateColumnWidths() {
                this.columnWidths = {
                    stt: 50,
                    thaoTac: 100,
                    maLanDay: this.calculateWidth('reqMessId'),
                    doiTac: this.calculateWidth('tenDoitac'),
                    truongHoc: this.calculateWidth('tenTruongHoc'),
                    maTruong: this.calculateWidth('maTruongHoc'),
                    thoiGianNhan: this.calculateWidth('timeDay'),
                    thoiGianXuLy: this.calculateWidth('timePhanHoi'),
                    loaiDongBo: this.calculateWidth('loaiDuLieu'),
                    namDongBo: 130,
                    loaiDot: this.calculateWidth('loaiDot'),
                };
            },

            // Hàm tính toán độ rộng cột dựa trên nội dung
            calculateWidth(columnKey) {
                const getDisplayValueLength = (value, columnKey) => {
                    if (columnKey === 'loaiDuLieu') {
                        return this.getLoaiDuLieu(parseInt(value)).length;
                    } else if (columnKey === 'loaiDot') {
                        return this.getDot(parseInt(value)).length;
                    }
                    return (value || '').toString().length;
                };

                const maxContentLength = this.danh_sach_du_lieu.reduce((max, row) => {
                    const value = row[columnKey];
                    return Math.max(max, getDisplayValueLength(value, columnKey));
                }, 0);

                return Math.max(100, maxContentLength * 10) + 20; // Mỗi ký tự chiếm 10px, tối thiểu 100px
            },

            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.truocKhiTim();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            ...mapMutations(['setLoaiDuLieu']),
            xemChiTiet(px, dl) {
                console.log("Xem chi tiết");
                this.duLieuChiTiet = px;
                this.setLoaiDuLieu(dl);
                this.show_chi_tiet = true;
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
            getData() {
                console.log("Lấy dữ liệu")
                if (!this.maGiaoDich || this.maGiaoDich == '') {
                    if (!this.dataSearch.truongHoc || this.dataSearch.truongHoc.length == 0) {
                        this.thongBao('error', 'Vui lòng bổ sung thông tin trường học');
                        return;
                    }
                    if (!this.dataSearch.namHoc || this.dataSearch.namHoc == '') {
                        this.thongBao('error', 'Vui lòng bổ sung thông tin năm học');
                        return;
                    }
                }
                this.danh_sach_du_lieu = [];
                let params = {
                    status: this.trangThai,
                    capHoc: this.capHoc,
                    loaiDayDuLieu: this.loaiDongBo,
                    loaiDot: this.loaiDot,
                    maDoiTac: this.maDoiTac,
                    maDonVi: this.donVi,
                    maGiaoDich: this.maGiaoDich,
                    maTruongHoc: this.dataSearch.truongHoc,
                    namDayDulieu: this.dataSearch.namHoc,
                    timeDayEnd: this.ngayBatDauDay,
                    start: this.start,
                    limit: this.limit,
                    timeDayStart: this.ngayBatDauDay
                };
                console.log("1234567890-");
                this.pr = params;
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/history-syncdata/school", params, data => {
                    loading.close();
                    if (data.data.rc == 0) {
                        this.danh_sach_du_lieu = data.data.rows;
                        this.total_rows = data.data.total;
                        this.updateColumnWidths()
                        if (this.total_rows == 0) {
                            // this.thongBao('error', 'Không có bản ghi nào được tìm thấy')
                            return;

                        } else {
                            // this.thongBao('success', 'Lấy dữ liệu thành công');
                        }
                    } else {
                        this.thongBao('error', data.data.rd)
                        return;
                    }
                });
            },

            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                this.soLuongBanGhiHienThi = e.soluong;
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            truocKhiTim() {
                console.log("Ấn tìm kiếm")
                this.total_rows = 0;
                this.trangbatdau = !this.trangbatdau;
            },
            getDoiTac() {

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
                rest_api.get("/internal-api/heThongDoiTac/filter", params, data => {
                    loading.close();
                    console.log("danh sách đối tác trả về:" + JSON.stringify(data.data))
                    if (data.data.statusResponse == 0) {
                        let tmp = data.data.rows;
                        let lst = [];
                        for (let i = 0; i < tmp.length; i++) {
                            let obj = {
                                name: tmp[i].tenDoiTac,
                                value: tmp[i].maDoiTac,
                            }
                            lst.push(obj);
                        }
                        this.list_doi_tac = lst;
                    } else {
                        this.list_doi_tac = [];
                    }
                });
            },
            chonNgayBatDau(e) {
                console.log("Chọn ngày bắt đầu:" + e)
                if (this.ngayBatDauDay != null) {
                    let start = moment(this.ngayBatDauDay, "DD/MM/YYYY")
                        .add(10, "days")
                        .format("DD/MM/YYYY");
                    this.ngayKetThucDay = start;
                }
            },
            layLaiTruong() {
                this.list_truong_hoc = [];
                this.dataSearch.truongHoc = [];
                this.getTruongHoc();
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.list_don_vi = [];
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    if (data.data.statusResponse == 0) {
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                tenDonVi: data_demo[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data_demo[i].maDonVi + ']',
                                maDonVi: data_demo[i].maDonVi,
                            }
                            this.list_don_vi.push(obj)
                        }
                        this.getTruongHoc();
                    } else {
                        this.thongBao('error', data.data.message)
                    }
                });
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                let params = {
                    maDonVi: this.donVi,
                    capHoc: this.capHoc,
                };
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
                        this.list_truong_hoc = data_demo;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">
    .dts-chonNgay {
        width: 100%;
    }

</style>

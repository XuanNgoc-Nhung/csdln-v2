<template>
    <div class="emis-hocsinh">
        <div>
            <span>Báo cáo theo tiêu chí:</span>
            <div v-for="(nd,i) in list_tieu_chi_chon" class="danhsachtieuchi" style="display:inline-block">
                <span class="red">›</span>
                <div style="display:inline">
                    <a href="#" @click.prevent="" class="inputieuchi">{{nd.name}}</a>
                    <a href="#" @click.prevent="deleteListTieuChi(i)"
                        style="margin-left:-2px; padding:4px; background:#FA8258" title="Xóa tiêu chí"
                        class="inputieuchi">x</a>
                </div>
            </div>
            <div style="display:inline">
                <select v-if="thongtin.role==5" v-bind:class="{ thieutieuchi: thieu_tieu_chi }"
                    @change.prevent="onChonTieuChi(TieuChi)" v-model="TieuChi" class="chon">
                    <option :value="TieuChi">
                        +Thêm tiêu chí</option>
                    <option v-for="(op,i) in list_tieu_chi_truong" v-bind:disabled="op.status" :value="op.index">
                        {{op.name}}</option>
                </select>
                <select v-if="thongtin.role!=5" v-bind:class="{ thieutieuchi: thieu_tieu_chi }"
                    @change.prevent="onChonTieuChi(TieuChi)" v-model="TieuChi" class="chon">
                    <option :value="TieuChi">
                        +Thêm tiêu chí</option>
                    <option v-for="(op,i) in list_tieu_chi" v-bind:disabled="op.status" :value="op.index">{{op.name}}
                    </option>
                </select>
                <span v-if="thieu_tieu_chi" class="red">
                    <span>
                        <img style="width:20px;"
                            src="https://media3.giphy.com/media/103XIj60oDbZNm/giphy.gif?cid=790b76119b0a85f4efc36f7cdcb827e087a43512ca28a0b7&rid=giphy.gif"
                            alt="" /></span>
                    Vui lòng chọn ít nhất 1 tiêu chí</span>
            </div>
        </div>
        <div style="padding-top:15px;">
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true"
                aria-controls="collapseOne">
                + Lọc nâng cao
            </a>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div id="collapseOne" class="panel-collapse collapse text-center" role="tabpanel"
                        aria-labelledby="headingOne" v-if="list_tieu_chi_chon.length==0">
                        <p>Bạn chưa chọn tiêu chí nào</p>
                    </div>
                    <div v-else="v-else" id="collapseOne" class="panel-collapse collapse in" role="tabpanel"
                        aria-labelledby="headingOne">
                        <div class="panel-body">
                            <div class="row">
                                <div v-if="check_don_vi_quan_ly || check_truong" class="col-md-3"
                                    style="margin-bottom:15px;">
                                    <label>Đơn vị quản lý:</label>
                                    <eselect style="width:100%" @change="getTruongHoc" multiple
                                        no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="DonViQuanLy"
                                        :placeholder="'Chọn'" filterable :data="ds_don_vi"
                                        :fields="['tenDonVi','maDonVi']" />
                                </div>
                                <div v-if="check_cap_day" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Cấp dạy:</label>
                                    <eselect style="width:100%" @change="getTruongHoc" multiple
                                        no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="CapDay"
                                        :placeholder="'Chọn cấp dạy'" filterable :data="list_cap_hoc"
                                        :fields="['name','id']" />
                                </div>
                                <div v-if="check_truong" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Trường:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="TruongHoc"
                                        :placeholder="'Chọn'" filterable :data="ds_truong_hoc"
                                        :fields="['tenMaTruong','maTruongHoc']" />
                                </div>
                                <div v-if="check_nam_hoc" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Năm học:</label>
                                    <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="NamHoc"
                                        :placeholder="'Chọn năm học'" filterable :data="list_years"
                                        :fields="['name','id']" />
                                </div>
                                <div v-if="check_trang_thai" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Trạng thái:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="TrangThaiCanBo"
                                        :placeholder="'Chọn trạng thái'" filterable :data="list_trang_thai_can_bo"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_gioi_tinh" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Giới tính:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="GioiTinh"
                                        :placeholder="'Chọn giới tính'" filterable :data="list_gioi_tinh"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_loai_hinh_truong" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Loại hình trường:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="loaiHinhDaoTao"
                                        :placeholder="'Chọn loại hình trường'" filterable :data="list_loai_hinh_truong"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_loai_hop_dong" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Loại hợp đồng:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="LoaiHopDong"
                                        :placeholder="'Chọn loại hợp đồng'" filterable
                                        :data="list_loai_hop_dong_lam_viec" :fields="['name','value']" />
                                </div>
                                <div v-if="check_nhom_can_bo" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Nhóm cán bộ:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="NhomCanBo"
                                        :placeholder="'Chọn nhóm cán bộ'" filterable :data="list_nhom_can_bo"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_trinh_do_chuyen_mon" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Trình độ chuyên môn:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="TrinhDoChuyenMon"
                                        :placeholder="'Chọn nhóm trình độ chuyên môn'" filterable
                                        :data="list_trinh_do_chuyen_mon" :fields="['name','value']" />
                                </div>
                                <div v-if="check_khu_vuc" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Khu vực:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="KhuVuc"
                                        :placeholder="'Chọn khu vực'" filterable :data="list_khu_vuc"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_loai_can_bo" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Loại cán bộ:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="LoaiCanBo"
                                        :placeholder="'Chọn loại cán bộ'" filterable :data="list_loai_can_bo"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_do_tuoi" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Độ tuổi:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="DoTuoi"
                                        :placeholder="'Chọn độ tuổi'" filterable :data="list_do_tuoi"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_danh_gia_chuan_nghe_nghiep" class="col-md-3"
                                    style="margin-bottom:15px;">
                                    <label>Loại đánh giá:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="LoaiDanhGia"
                                        :placeholder="'Chọn loại đánh giá'" filterable
                                        :data="list_danh_gia_chuan_nghe_nghiep" :fields="['name','value']" />
                                </div>
                                <div v-if="check_dan_toc_thieu_so" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Dân tộc thiểu số:</label>
                                    <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="DanTocThieuSo"
                                        :placeholder="'Chọn'" filterable :data="BooleanValue"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_giao_vien_phu_trach_doi" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Giáo viên phụ trách Đội:</label>
                                    <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags
                                        v-model="GiaoVienPhuTrachDoi" :placeholder="'Chọn'" filterable
                                        :data="BooleanValue" :fields="['name','value']" />
                                </div>
                                <div v-if="check_mon_day" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Môn dạy:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="maMonHoc"
                                        :placeholder="'Chọn môn dạy'" filterable :data="list_mon_day"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_dan_toc" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Dân tộc:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="maDanToc"
                                        :placeholder="'Chọn dân tộc'" filterable :data="ds_dan_toc"
                                        :fields="['name','value']" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -->
        </div>
        <div class="row">
            <div class="col-md-12 text-center" style="display: flex;justify-content: center;">
                <el-button size="mini" type="success" @click.prevent="TienHanhLoc">Tra cứu</el-button>
            </div>
        </div>
        <!-- -->
        <div class="row">
            <div class="col-md-12" style="text-align:center; display:none;">
                <a data-toggle="collapse" title="Ẩn/Hiện biểu đồ" data-parent="" href="#collapse2">
                    <i class="fas fa-chevron-circle-up"></i>
                </a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" style="display: flex;align-items: center;">
                <label style="margin-right:5px">
                    <input type="checkbox" :disabled="list_table_rows.length==0" @click="checkVertical" />
                    Xuất dữ liệu ngang</label>
                <el-button type="success" size="mini" :disabled="list_table_rows.length==0" @click.prevent="XuatFileExcel">Xuất excel
                    <!-- <span>
                        <div class="loader"></div>
                    </span> -->
                </el-button>
                <el-button @click.prevent="loadTemplateModal" size="mini" type="info" >Tải mẫu</el-button>
                <el-button :disabled="list_tieu_chi_chon.length==0" @click.prevent="saveTemplateModal" size="mini" type="warning">Lưu
                    mẫu</el-button>
            </div>
            <div class="col-md-12">
                <div class="table-responsive row_tp">
                    <table id="textTable" class="table table-bordered table-report">
                        <thead>
                            <tr style="background:rgb(228, 235, 245);">
                                <template v-for="th in list_table_header">
                                    <th class="">{{th.value}}</th>
                                </template>
                            </tr>
                        </thead>
                        <tbody v-if="list_table_rows.length==0">
                            <tr>
                                <td class="" colspan="17">
                                    <p>Không có bản ghi nào được tìm thấy</p>
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="rennder-data" v-else="v-else" v-html="htmlrender"></tbody>
                    </table>
                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                </div>
            </div>
        </div>

        <el-dialog title="Lưu mẫu" :visible.sync="canBoModalSave" :close-on-click-modal="false"
            :close-on-press-escape="false" :before-close="handleClose">
            <div>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <label>Tên mẫu</label>
                        <el-input clearable v-on:keyup.enter="saveTemplate" v-model="NameTemplate"
                            placeholder="Nhập..." />
                    </el-col>
                </el-row>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button size="mini" type="primary" @click.prevent="saveTemplate">Lưu</el-button>
            </span>
        </el-dialog>
        <el-dialog title="Chọn mẫu" :visible.sync="canBoModalLoad" :close-on-click-modal="false"
            :close-on-press-escape="false" :before-close="handleClose">
            <div>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <label>Tên mẫu</label>
                        <el-input clearable v-model="searchTemp" @input="getTemplate"
                            placeholder="Nhập..." />

                        <!-- <input v-model="searchTemp" type="text" class="form-control" placeholder="Chọn template"
                        @input="getTemplate" /> -->
                    <div class="renderTemp" style="max-height:300px">
                        <div v-if="listTemp.length">
                            <ul class="nav nav-pills nav-stacked">
                                <li style="display:flex;justify-content: space-between;" v-for="item in listTemp">
                                    <a href="#" @click.prevent="chooseTemp(item)">{{parseName(item.request)}}</a>
                                    <a style="margin-left: 15px;color:#DC0101;" href="#"
                                        @click.prevent="DeleteTemp(item)">Xóa</a>

                                </li>
                            </ul>
                        </div>
                        <div v-else="v-else">
                            <p>Bạn chưa lưu mẫu nào!</p>
                        </div>
                    </div>
                    </el-col>
                </el-row>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button size="mini" type="primary" @click.prevent="loadTemplate">Tải mẫu</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import array_util from "../../../utils/array_utils";
    import ElementUI from 'element-ui';
    import utils from '../../../utils'
    import ESelectVue from '../../ui/ESelect.vue';
    import constant from "../../../utils/constant";
    import Vue from "vue";
    import Page from '../../ui/PagingCustom';
    import VueAlertify from "vue-alertify";
    import FileSaver from 'file-saver';

    import api from "../../api";
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            // dialogs default title
            title: 'Thông báo',
            // ok button text
            ok: 'Đồng ý',
            // cancel button text
            cancel: 'Hủy'
        }
    });
    Vue.use(ElementUI);
    export default {
        props: ["infologin"],
        components: {
            "Page": Page,
            'eselect': ESelectVue,
        },
        data() {
            return {
                // list_mon_day: constant.danh_sach_mon_hoc_tra_cuu_hoc_tap,
                list_mon_day: [],
                BooleanValue: [{
                    value: 1,
                    name: 'Có'
                }, {
                    value: 2,
                    name: 'Không'
                }],
                // -----------------
                htmlrender: '',
                thongtindangnhap: "",
                canBoModalSave: false,
                canBoModalLoad: false,
                dowload: false,
                isVertical: 0,
                // phân trang
                NameTemplate: "",
                listTemp: [],
                searchTemp: "",
                total_rows: 0,
                start: 0,
                currentPage: 1,
                limit: 25,
                // check list
                thieu_tieu_chi: false,
                list_years: [],
                // Các loại check của cán bộ
                check_khoi_hoc: false,
                check_trang_thai: false,
                check_don_vi_quan_ly: false,
                check_ton_giao: false,
                check_vung_chinh_sach: false,
                check_bo_sung: false,
                check_truong: false,
                check_nam_hoc: false,
                check_gioi_tinh: false,
                check_dan_toc_thieu_so: false,
                check_loai_hinh_truong: false,
                check_loai_hop_dong: false,
                check_nhom_can_bo: false,
                check_trinh_do_chuyen_mon: false,
                check_khu_vuc: false,
                check_mon_day: false,
                check_dan_toc: false,
                check_loai_can_bo: false,
                check_cap_day: false,
                check_do_tuoi: false,
                check_giao_vien_phu_trach_doi: false,
                check_danh_gia_chuan_nghe_nghiep: false,
                check_nghi_huu_trong_nam: false,
                check_tuyen_moi_trong_nam: false,
                // hết các biến check
                TrangThai: '',
                CapHoc: '',
                KhoiHoc: '',
                thongtin: {},
                TieuChi: "",
                // các biến dùng ở trong form
                list_table_header: [],
                list_table_rows: [],
                ds_don_vi: [],
                ds_dan_toc: [],
                ds_ton_giao: [],
                list_tieu_chi_chon: [],
                ds_truong_hoc: [],
                // -----------------
                list_tieu_chi: [{
                    "name": "Đơn vị quản lý",
                    "nameCol": "maDonVi",
                    "status": false,
                    "index": "1"
                }, {
                    "name": "Cấp dạy",
                    "nameCol": "capHoc",
                    "status": false,
                    "index": "2"
                }, {
                    "name": "Trường học",
                    "nameCol": "maTruongHoc",
                    "status": false,
                    "index": "3"
                }, {
                    "name": "Năm học",
                    "nameCol": "namHoc",
                    "status": false,
                    "index": "4"
                }, {
                    "name": "Trạng thái",
                    "nameCol": "trangThai",
                    "status": false,
                    "index": "5"
                }, {
                    "name": "Giới tính",
                    "nameCol": "gioiTinh",
                    "status": false,
                    "index": "6"
                }, {
                    "name": "Loại hình trường",
                    "nameCol": "loaiHinhDaoTao",
                    "status": false,
                    "index": "7"
                }, {
                    "name": "Loại hợp đồng",
                    "nameCol": "loaiHopDong",
                    "status": false,
                    "index": "8"
                }, {
                    "name": "Nhóm cán bộ",
                    "nameCol": "loaiCanBo",
                    "status": false,
                    "index": "9"
                }, {
                    "name": "Trình độ chuyên môn",
                    "nameCol": "trinhDoChuyenMonCaoNhat",
                    "status": false,
                    "index": "10"
                }, {
                    "name": "Khu vực",
                    "nameCol": "maKhuVuc",
                    "status": false,
                    "index": "11"
                }, {
                    "name": "Loại cán bộ",
                    "nameCol": "maChucVu",
                    "status": false,
                    "index": "12"
                }, {
                    "name": "Độ tuổi",
                    "nameCol": "doTuoi",
                    "status": false,
                    "index": "13"
                }, {
                    "name": "Đánh giá chuẩn nghề nghiệp",
                    "nameCol": "dgKqChuanNgheNghiep",
                    "status": false,
                    "index": "14"
                }, {
                    "name": "Dân tộc thiểu số",
                    "nameCol": "danTocThieuSo",
                    "status": false,
                    "index": "15"
                }, {
                    "name": "Giáo viên phụ trách đội",
                    "nameCol": "chuyenTrachDoi",
                    "status": false,
                    "index": "16"
                }, {
                    "name": "Môn dạy",
                    "nameCol": "maMonHoc",
                    "status": false,
                    "index": "17"
                }, {
                    "name": "Dân tộc",
                    "nameCol": "maDanToc",
                    "status": false,
                    "index": "18"
                }],
                list_tieu_chi_truong: [{
                        "name": "Cấp dạy",
                        "nameCol": "capHoc",
                        "status": false,
                        "index": "2"
                    }, {
                        "name": "Năm học",
                        "nameCol": "namHoc",
                        "status": false,
                        "index": "4"
                    }, {
                        "name": "Trạng thái",
                        "nameCol": "trangThai",
                        "status": false,
                        "index": "5"
                    }, {
                        "name": "Giới tính",
                        "nameCol": "gioiTinh",
                        "status": false,
                        "index": "6"
                    }, {
                        "name": "Loại hình trường",
                        "nameCol": "loaiHinhDaoTao",
                        "status": false,
                        "index": "7"
                    }, {
                        "name": "Loại hợp đồng",
                        "nameCol": "loaiHopDong",
                        "status": false,
                        "index": "8"
                    }, {
                        "name": "Nhóm cán bộ",
                        "nameCol": "loaiCanBo",
                        "status": false,
                        "index": "9"
                    }, {
                        "name": "Trình độ chuyên môn",
                        "nameCol": "trinhDoChuyenMonCaoNhat",
                        "status": false,
                        "index": "10"
                    }, {
                        "name": "Khu vực",
                        "nameCol": "maKhuVuc",
                        "status": false,
                        "index": "11"
                    }, {
                        "name": "Loại cán bộ",
                        "nameCol": "maChucVu",
                        "status": false,
                        "index": "12"
                    }, {
                        "name": "Độ tuổi",
                        "nameCol": "doTuoi",
                        "status": false,
                        "index": "13"
                    }, {
                        "name": "Đánh giá chuẩn nghề nghiệp",
                        "nameCol": "dgKqChuanNgheNghiep",
                        "status": false,
                        "index": "14"
                    }, {
                        "name": "Dân tộc thiểu số",
                        "nameCol": "danTocThieuSo",
                        "status": false,
                        "index": "15"
                    }, {
                        "name": "Giáo viên phụ trách đội",
                        "nameCol": "chuyenTrachDoi",
                        "status": false,
                        "index": "16"
                    },
                    {
                        "name": "Môn dạy",
                        "nameCol": "maMonHoc",
                        "status": false,
                        "index": "17"
                    },
                    {
                        "name": "Dân tộc",
                        "nameCol": "maDanToc",
                        "status": false,
                        "index": "18"
                    }
                ],
                //Nội dung gửi đi của cán bộ
                listCol: [],
                sreachRequest: [],
                sreachRequestValues: [],
                check_disabled: [],
                don_vi_quan_ly: {
                    name: "Đơn vị quản lý",
                    nameSreach: "maDonVi",
                    values: ""
                },
                cap_day: {
                    name: "Cấp dạy",
                    nameSreach: "capHoc",
                    values: ""
                },
                truong_hoc: {
                    name: "Trường học",
                    nameSreach: "maTruongHoc",
                    values: ""
                },
                nam_hoc: {
                    name: "Năm học",
                    nameSreach: "namHoc",
                    value: ""
                },
                trang_thai_can_bo: {
                    name: "Trạng thái",
                    nameSreach: "trangThai",
                    values: ""
                },
                gioi_tinh: {
                    name: "Giới tính",
                    nameSreach: "gioiTinh",
                    value: ''
                },
                loai_hinh_truong: {
                    name: "Loại hình trường",
                    nameSreach: "loaiHinhDaoTao",
                    values: ""
                },
                loai_hop_dong: {
                    name: "Loại hợp đồng",
                    nameSreach: "loaiHopDong",
                    values: ""
                },
                nhom_can_bo: {
                    name: "Nhóm cán bộ",
                    nameSreach: "loaiCanBo",
                    values: ""
                },
                trinh_do_chuyen_mon: {
                    name: "Trình độ chuyên môn",
                    nameSreach: "trinhDoChuyenMonCaoNhat",
                    values: ""
                },
                khu_vuc: {
                    name: "Khu vực",
                    nameSreach: "maKhuVuc",
                    values: ""
                },
                mon_day: {
                    name: "Môn dạy",
                    nameSreach: "maMonHoc",
                    values: ""
                },
                dan_toc: {
                    name: "Dân tộc",
                    nameSreach: "maDanToc",
                    values: ""
                },
                loai_can_bo: {
                    name: "Loại cán bộ",
                    nameSreach: "maChucVu",
                    values: ""
                },
                do_tuoi: {
                    name: "Độ tuổi",
                    nameSreach: "doTuoi",
                    values: ""
                },
                danh_gia_chuan_nghe_nghiep: {
                    name: "Đánh giá chuẩn nghề nghiệp",
                    nameSreach: "dgKqChuanNgheNghiep",
                    values: ""
                },
                dan_toc_thieu_so: {
                    name: "Dân tộc thiểu số",
                    nameSreach: "danTocThieuSo",
                    value: ""
                },
                giao_vien_phu_trach_doi: {
                    name: "Giáo viên phụ trách đội",
                    nameSreach: "chuyenTrachDoi",
                    value: ""
                },
                nghi_huu_trong_nam: {
                    name: "Nghỉ hưu trong năm",
                    nameSreach: "nghiHuuTrongNam",
                    value: ""
                },
                tuyen_moi_trong_nam: {
                    name: "Tuyển mới trong năm",
                    nameSreach: "tuyenMoiTrongNam",
                    value: ""
                },
                // Phần param cho cán bộ
                list_trang_thai_can_bo: [],
                list_gioi_tinh: constant.GIOI_TINH,
                list_loai_hinh_truong: [],
                list_loai_hop_dong_lam_viec: [],
                list_nhom_can_bo: constant.NHOM_CAN_BO,
                list_trinh_do_chuyen_mon: [],
                list_khu_vuc: [],
                list_loai_can_bo: [],
                list_do_tuoi: constant.DO_TUOI,
                list_danh_gia_chuan_nghe_nghiep: [],
                // list_cap_hoc: constant.LIST_CAP_HOC_KHONG_LIEN,
                list_cap_hoc: window.listCapHoc,
                DonViQuanLy: "",
                CapDay: [],
                TruongHoc: "",
                NamHoc: "",
                TrangThaiCanBo: "",
                GioiTinh: '',
                loaiHinhDaoTao: "",
                LoaiHopDong: "",
                NhomCanBo: "",
                TrinhDoChuyenMon: "",
                KhuVuc: "",
                maMonHoc: "",
                maDanToc: "",
                LoaiCanBo: "",
                DoTuoi: "",
                LoaiDanhGia: "",
                DanTocThieuSo: "",
                GiaoVienPhuTrachDoi: "",
                NghiHuuTrongNam: "",
                TuyenMoiTrongNam: ""
            };
        },
        watch: {
            check_truong: function (params) {
                console.log(params);
                this.TruongHoc = [];
                //     array_util.clearArrays(this.ds_truong_hoc);
                // if (this.check_truong && this.DonViQuanLy.length != 0) {
                //     this.getTruongHoc();
                // }
            },
            // Check thay đổi đơn vị quản lý
            DonViQuanLy: function (newVal) {
                this.TruongHoc = "";
                // if (newVal.length == 0) {
                //     this.ds_truong_hoc = [];
                // } else {
                //     this.getTruongHoc();
                // }
            },
            CapDay: function (newVal) {
                this.TruongHoc = "";
                // if (this.check_truong && this.DonViQuanLy.length != 0) {
                //     this.getTruongHoc();
                // }
            },
            list_tieu_chi_chon: function (newVal) {
                console.log("check sự thay đổi của list tiêu chí đã chọn");
                // this.checkDisabled();
                this.LocCot();
                this.putIntoAdvancedFiltering();
            },
            // Check các thay đổi của lọc nâng cao
            check_don_vi_quan_ly: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn đơn vị quản lý");
                    this.DonViQuanLy = "";
                    this.TruongHoc = "";
                    this.check_truong = false;
                }
            },
            check_cap_day: function (newVal) {
                if (!newVal) {
                    console.log("bỏ chọn cấp dạy");
                    this.CapDay = [];
                }
            },
            check_nam_hoc: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn năm học");
                    this.NamHoc = "";
                }
            },
            check_trang_thai: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn trạng thái");
                    this.TrangThaiCanBo = "";
                }
            },
            check_gioi_tinh: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn giới tính");
                    this.GioiTinh = "";
                }
            },
            check_dan_toc_thieu_so: function (newVal) {
                if (!newVal) {
                    this.DanTocThieuSo = '';
                }
            },
            check_giao_vien_phu_trach_doi: function (newVal) {
                if (!newVal) {
                    this.GiaoVienPhuTrachDoi = 0;
                }
            },
            check_loai_hinh_truong: function (newVal) {
                if (!newVal) {
                    console.log("bỏ chọn loại hình trường");
                    this.loaiHinhDaoTao = "";
                }
            },
            check_loai_hop_dong: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn loại hợp đồng");
                    this.LoaiHopDong = "";
                }
            },
            check_nhom_can_bo: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn nhóm cán bộ");
                    this.NhomCanBo = "";
                }
            },
            check_trinh_do_chuyen_mon: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn trình độ chuyên môn");
                    this.TrinhDoChuyenMon = "";
                }
            },
            check_khu_vuc: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn khu vực");
                    this.KhuVuc = "";
                }
            },
            check_mon_day: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn môn dạy");
                    this.maMonHoc = "";
                }
            },
            check_dan_toc: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn dân tộc");
                    this.maDanToc = "";
                }
            },
            check_loai_can_bo: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn loại cán bộ");
                    this.LoaiCanBo = "";
                }
            },
            check_do_tuoi: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn độ tuổi");
                    this.DoTuoi = "";
                }
            },
            check_danh_gia_chuan_nghe_nghiep: function (newVal) {
                if (!newVal) {
                    console.log("Bỏ chọn đánh giá chuẩn nghề nghiệp");
                    this.LoaiDanhGia = "";
                }
            },
            check_bo_sung: function (newVal) {
                console.log("Bỏ chọn bổ sung");
                this.NghiHuuTrongNam = "";
                this.TuyenMoiTrongNam = "";
            },
            // Hết check thay đổi của lọc nâng cao giáo viên check thay đổi list tiêu chí
            // chọn
        },
        mounted: function () {
            this.ganSME();
            this.list_trang_thai_can_bo = this.list_trang_thai_can_bo.filter(item => item.value !== "");
            this.list_loai_hinh_truong = this.list_loai_hinh_truong.filter(item => item.value !== "");
            this.list_loai_hop_dong_lam_viec = this.list_loai_hop_dong_lam_viec.filter(item => item.value !== "");
            this.list_trinh_do_chuyen_mon = this.list_trinh_do_chuyen_mon.filter(item => item.value !== "");
            this.list_khu_vuc = this.list_khu_vuc.filter(item => item.value !== "");
            this.list_loai_can_bo = this.list_loai_can_bo.filter(item => item.value !== "");
            this.list_danh_gia_chuan_nghe_nghiep = this.list_danh_gia_chuan_nghe_nghiep.filter(item => item
                .value !== "");
            this.list_mon_day = this.list_mon_day.filter(item => item.value !== "");
            this.list_mon_day = this.list_mon_day.filter(item => item.value !== 0);
            this.list_mon_day = this.list_mon_day.filter(item => item.value !== '0');
            this.thongtin = JSON.parse(this.infologin);
            this.getDonVi();
            this.ganDanToc();
            this.ganTonGiao();
            this.ds_dan_toc = this.ds_dan_toc.filter(item => item.value !== "");
            this.ds_ton_giao = this.ds_ton_giao.filter(item => item.value !== "");
            this.list_years = this.getYear();
            console.log("trang thái cán bộ:")
            console.error(this.list_trang_thai_can_bo)
            this.list_trang_thai_can_bo= this.uniqByKeepFirst(this.list_trang_thai_can_bo, it => it.value)
            for(let k=0;k<this.list_trang_thai_can_bo.length;k++){
                this.list_trang_thai_can_bo[k].value = parseInt(this.list_trang_thai_can_bo[k].value)
            }
        },
        methods: {
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

            handleClose(){
                console.log('handleClose');
                this.canBoModalLoad = false;
                this.canBoModalSave = false;
            },
            uniqByKeepFirst(a, key) {
                let seen = new Set();
                return a.filter(item => {
                    let k = key(item);
                    return seen.has(k) ? false : seen.add(k);
                });
            }
            ,
            ganSME() {
                let ds_dt = localStorage["danh_sach_mon_day_giao_vien_sme"];
                if (ds_dt) {
                    this.list_mon_day = JSON.parse(ds_dt)
                    this.list_trang_thai_can_bo = JSON.parse(localStorage["danh_sach_trang_thai_can_bo_sme"]);
                    this.list_loai_hinh_truong = JSON.parse(localStorage["danh_sach_loai_hinh_truong_sme"]);
                    this.list_loai_hop_dong_lam_viec = JSON.parse(localStorage["danh_sach_hinh_thuc_hop_dong_sme"]);
                    this.list_trinh_do_chuyen_mon = JSON.parse(localStorage["danh_sach_trinh_do_chuyen_mon_sme"]);
                    this.list_khu_vuc = JSON.parse(localStorage["danh_sach_khu_vuc_sme"]);
                    this.list_loai_can_bo = JSON.parse(localStorage["danh_sach_chuc_vu_sme"]);
                    this.list_danh_gia_chuan_nghe_nghiep = JSON.parse(localStorage[
                        "danh_sach_danh_gia_chuan_nghe_nghiep_sme"]);
                } else {
                    this.list_mon_day = [];
                }
            },
            DeleteTemp(item) {
                let params = {};
                rest_api.post(
                    "/csdlgd-report-fetch/template/delete/" + item.id,
                    params,
                    (data) => {
                        if (data.status == 200) {
                            this.getTemplate();
                        }
                    },
                    10000,
                    false
                );
            },
            chooseTemp(item) {
                this.searchTemp = this.parseName(item.request);
                this.listCol = JSON
                    .parse(item.request)
                    .colList;
                this.sreachRequest = JSON
                    .parse(item.request)
                    .requestLists;
                this.sreachRequestValues = JSON
                    .parse(item.request)
                    .requestList;
            },
            parseName(item) {
                return JSON
                    .parse(item)
                    .name
            },
            getTemplate() {
                let value = this.searchTemp;
                let params = {
                    "name": this.searchTemp,
                    "type": 1
                };
                let html = '';
                rest_api.post("/csdlgd-report-fetch/template/search", params, (data) => {
                    if (data.status == 200) {
                        this.listTemp = data.data.rows;
                    }
                }, 10000, false);
            },
            loadTemplateModal() {
                this.getTemplate();
                this.canBoModalLoad = true;
            },
            loadTemplate() {
                if (this.searchTemp == '') {
                    this.thongBao('error','Vui lòng chọn mẫu')
                    return;
                }
                this.list_tieu_chi_chon = this.listCol;
                this.pushDataTemplate(this.sreachRequest);
                this.pushDataTemplate(this.sreachRequestValues);
                this.canBoModalLoad = false;
                this.searchTemp = '';
            },
            pushDataTemplate(data) {
                data.forEach((item) => {
                    if (item.nameSreach == "gioiTinh") {
                        if (item.value)
                            this.GioiTinh = '1';
                        else
                            this.GioiTinh = '0';
                    }
                    if (item.nameSreach == "maDonVi") {
                        this.DonViQuanLy = item.values
                    }
                    if (item.nameSreach == "capHoc") {
                        this.CapDay = item.values
                    }
                    if (item.nameSreach == "maTruongHoc") {
                        this.TruongHoc = item.values
                    }
                    if (item.nameSreach == "namHoc") {
                        this.NamHoc = item.value
                    }
                    if (item.nameSreach == "trangThai") {
                        this.TrangThaiCanBo = item.values
                    }
                    if (item.nameSreach == "loaiHinhDaoTao") {
                        this.loaiHinhDaoTao = item.values
                    }
                    if (item.nameSreach == "loaiHopDong") {
                        this.LoaiHopDong = item.values
                    }
                    if (item.nameSreach == "loaiCanBo") {
                        this.NhomCanBo = item.values
                    }
                    if (item.nameSreach == "trinhDoChuyenMonCaoNhat") {
                        this.TrinhDoChuyenMon = item.values
                    }
                    if (item.nameSreach == "maKhuVuc") {
                        this.KhuVuc = item.values
                    }
                    if (item.nameSreach == "maMonHoc") {
                        this.maMonHoc = item.values
                    }
                    if (item.nameSreach == "maDanToc") {
                        this.maDanToc = item.values
                    }
                    if (item.nameSreach == "maChucVu") {
                        this.LoaiCanBo = item.values
                    }
                    if (item.nameSreach == "doTuoi") {
                        this.DoTuoi = item.values
                    }
                    if (item.nameSreach == "dgKqChuanNgheNghiep") {
                        this.LoaiDanhGia = item.values
                    }
                    if (item.nameSreach == "danTocThieuSo") {
                        if (item.value) {
                            this.DanTocThieuSo = 1
                        } else {
                            this.DanTocThieuSo = 2
                        }
                    }
                    if (item.nameSreach == "chuyenTrachDoi") {
                        if (item.value) {
                            this.GiaoVienPhuTrachDoi = 1
                        } else {
                            this.GiaoVienPhuTrachDoi = 2
                        }
                    }
                })
            },
            saveTemplateModal() {
                this.NameTemplate = '';
                this.canBoModalSave = true;
            },
            saveTemplate() {
                let name = this.NameTemplate;
                if (!name) {
                        this.thongBao('error','Vui lòng nhập tên mẫu')
                } else {
                    this.TienHanhLoc2();
                    if (!this.list_tieu_chi_chon.length) {
                        this
                            .$alertify
                            .error("Vui lòng quay lại và chọn các tiêu chí trước.");
                    } else {
                        let params = {
                            "colList": this.listCol,
                            "requestLists": this.sreachRequest,
                            "requestList": this.sreachRequestValues,
                            "start": this.start,
                            "limit": this.limit,
                            "type": 1,
                            "name": name
                        };
                        rest_api.post("/csdlgd-report-fetch/template/save", params, (data) => {
                            if (data.data.rc == 0) {
                                this.thongBao('success',data.data.rd)
                                this.canBoModalSave = false;
                            } else {

                                this.thongBao('error',data.data.rd)
                            }
                        });
                    }
                }
            },
            getYear() {
                let y = new Date().getFullYear();
                return [{
                    id: y - 2,
                    name: (y - 2) + '-' + (
                        y - 1
                    )
                }, {
                    id: y - 1,
                    name: (y - 1) + '-' + y
                }, {
                    id: y,
                    name: y + '-' + (
                        y + 1
                    )
                }]
            },
            XuatFileExcel(e) {
                $(e.target).attr("disabled", true);
                $(e.target).addClass('show');
                if (this.dowload) {
                    let url = "/xuat-excel-bao-cao-dong-can-bo";
                    let params = {
                        "colList": this.listCol,
                        "requestLists": this.sreachRequest,
                        "requestList": this.sreachRequestValues,
                        "start": this.start,
                        "limit": this.limit,
                        "turn": this.isVertical
                    };
                    api.post(url, params, (data) => {
                        $(e.target).removeClass('show');
                        $(e.target).attr("disabled", false);
                        $(e.target).removeAttr("disabled");
                        let currentDate = new Date();
                        let fileName = '';
                        var thangNay = parseInt(currentDate.getMonth()) + 1;
                        if (thangNay < 10) {
                            thangNay = '0' + thangNay;
                        }
                        fileName = this.thongtin.ma_so + '_Bao_cao_can_bo_' + currentDate.getDate() + thangNay +
                            (currentDate.getFullYear());
                        FileSaver.saveAs(data.data.file, fileName);
                    });
                } else {
                    $(e.target).removeClass('show');
                    $(e.target).attr("disabled", false);
                    $(e.target).removeAttr("disabled");
                    // alert("Không có dữ liệu nào để xuất!")
                    this.thongBao('error','Không có dữ liệu để xuất')
                }
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            xemHuongDan() {
                var a = {
                        title: 'ok',
                        status: true
                    },
                    b = {
                        title: 'test',
                        status: true
                    },
                    c = {
                        title: 'test1',
                        status: true
                    },
                    d = {
                        title: 'test',
                        status: true
                    };
                var i = [
                        a, b
                    ],
                    j = [c, d];
                i.forEach(function (el1) {
                    j.forEach(function (el2) {
                        if (el2.title === el1.title) {
                            el2.status = false;
                        }
                    })
                });
                console.log();
            },
            LocCot() {
                let i = this.list_tieu_chi_chon;
                let j = this.list_tieu_chi;
                let k = [];
                // console.log(JSON.stringify("i :" + i)); console.log(JSON.stringify("j :"
                // +j));
                i.forEach(function (el1) {
                    j.forEach(function (el2) {
                        if (el2.nameCol === el1.nameCol) {
                            el2.status = false;
                            k.push(el2.nameCol)
                        }
                    })
                });
                this.checkDisabled(k);
            },
            checkVertical(e) {
                if ($(e.target).is(":checked")) {
                    this.isVertical = 1
                } else {
                    this.isVertical = 0
                }
            },
            TienHanhLoc() {
                this.total_rows = 0;
                this.list_table_header = [];
                this.list_table_rows = [];
                if (this.list_tieu_chi_chon.length == 0) {
                    this.thieu_tieu_chi = true;
                    // utils.showDialog("Thông báo", "Vui lòng bổ sung tiêu chí lấy báo cáo", null, () => {
                    //     setTimeout(() => {
                    //         this.thieu_tieu_chi = false;
                    //     }, 4000);
                    // });
                    setTimeout(() => {
                            this.thieu_tieu_chi = false;
                        }, 4000);
                    return;
                }
                this.sreachRequest = [];
                this.sreachRequestValues = [];
                // console.log(JSON.stringify(this.DonViQuanLy));
                if (this.DonViQuanLy) {
                    console.log("có đơn vị");
                    this.don_vi_quan_ly.values = this.DonViQuanLy;
                    this
                        .sreachRequest
                        .push(this.don_vi_quan_ly);
                }
                if (this.CapDay) {
                    console.log("có cấp dạy");
                    this.cap_day.values = this.CapDay;
                    this
                        .sreachRequest
                        .push(this.cap_day);
                }
                if (this.TruongHoc) {
                    this.truong_hoc.values = this.TruongHoc;
                    if (this.truong_hoc.values.length) {
                        this
                            .sreachRequest
                            .push(this.truong_hoc);
                    }
                    console.log("có trường học :" + this.truong_hoc.values);
                }
                if (this.NamHoc) {
                    console.log("Có năm học");
                    this.nam_hoc.value = this.NamHoc;
                    this
                        .sreachRequestValues
                        .push(this.nam_hoc);
                }
                if (this.TrangThaiCanBo) {
                    this.trang_thai_can_bo.values = this.TrangThaiCanBo;
                    this
                        .sreachRequest
                        .push(this.trang_thai_can_bo);
                }
                if (this.GioiTinh) {
                    this.gioi_tinh.value = parseInt(this.GioiTinh);
                    this
                        .sreachRequestValues
                        .push(this.gioi_tinh);
                }
                if (this.loaiHinhDaoTao) {
                    this.loai_hinh_truong.values = this.loaiHinhDaoTao;
                    this
                        .sreachRequest
                        .push(this.loai_hinh_truong);
                }
                if (this.LoaiHopDong) {
                    this.loai_hop_dong.values = this
                        .LoaiHopDong
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.loai_hop_dong);
                }
                if (this.NhomCanBo) {
                    this.nhom_can_bo.values = this.NhomCanBo;
                    this
                        .sreachRequest
                        .push(this.nhom_can_bo);
                }
                if (this.TrinhDoChuyenMon) {
                    this.trinh_do_chuyen_mon.values = this
                        .TrinhDoChuyenMon
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.trinh_do_chuyen_mon);
                }
                if (this.KhuVuc) {
                    this.khu_vuc.values = this
                        .KhuVuc
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.khu_vuc);
                }
                if (this.maMonHoc) {
                    this.mon_day.values = this
                        .maMonHoc
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.mon_day);
                }
                if (this.maDanToc) {
                    this.dan_toc.values = this
                        .maDanToc
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.dan_toc);
                }
                if (this.LoaiCanBo) {
                    this.loai_can_bo.values = this
                        .LoaiCanBo
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.loai_can_bo);
                }
                if (this.DoTuoi) {
                    this.do_tuoi.values = this
                        .DoTuoi
                        .map(String);
                    this.DoTuoi;
                    this
                        .sreachRequest
                        .push(this.do_tuoi);
                }
                if (this.LoaiDanhGia) {
                    this.danh_gia_chuan_nghe_nghiep.values = this
                        .LoaiDanhGia
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.danh_gia_chuan_nghe_nghiep);
                }
                if (this.DanTocThieuSo) {
                    if (this.DanTocThieuSo == 1) {
                        this.dan_toc_thieu_so.value = true;
                    } else {
                        this.dan_toc_thieu_so.value = false;
                    }
                    this
                        .sreachRequestValues
                        .push(this.dan_toc_thieu_so);
                }
                if (this.GiaoVienPhuTrachDoi) {
                    if (this.GiaoVienPhuTrachDoi == 1) {
                        this.giao_vien_phu_trach_doi.value = 1;
                    } else {
                        this.giao_vien_phu_trach_doi.value = 0;
                    }
                    this
                        .sreachRequestValues
                        .push(this.giao_vien_phu_trach_doi);
                }
                this.ganIndex();
                console.log("Danh sách cột" + JSON.stringify(this.listCol));
                console.log("Danh sách lọc" + JSON.stringify(this.sreachRequest));
                this.getData();
            },
            TienHanhLoc2() {
                this.sreachRequest = [];
                this.sreachRequestValues = [];
                if (this.DonViQuanLy) {
                    console.log("có đơn vị");
                    this.don_vi_quan_ly.values = this.DonViQuanLy;
                    this
                        .sreachRequest
                        .push(this.don_vi_quan_ly);
                }
                if (this.CapDay) {
                    console.log("có cấp dạy");
                    this.cap_day.values = this.CapDay;
                    this
                        .sreachRequest
                        .push(this.cap_day);
                }
                if (this.TruongHoc) {
                    this.truong_hoc.values = this.TruongHoc;
                    if (this.truong_hoc.values.length) {
                        this
                            .sreachRequest
                            .push(this.truong_hoc);
                    }
                    console.log("có trường học :" + this.truong_hoc.values);
                }
                if (this.NamHoc) {
                    console.log("Có năm học");
                    this.nam_hoc.value = this.NamHoc;
                    this
                        .sreachRequestValues
                        .push(this.nam_hoc);
                }
                if (this.TrangThaiCanBo) {
                    this.trang_thai_can_bo.values = this.TrangThaiCanBo;
                    this
                        .sreachRequest
                        .push(this.trang_thai_can_bo);
                }
                if (this.GioiTinh) {
                    this.gioi_tinh.value = parseInt(this.GioiTinh);
                    this
                        .sreachRequestValues
                        .push(this.gioi_tinh);
                }
                if (this.loaiHinhDaoTao) {
                    this.loai_hinh_truong.values = this.loaiHinhDaoTao;
                    this
                        .sreachRequest
                        .push(this.loai_hinh_truong);
                }
                if (this.LoaiHopDong) {
                    this.loai_hop_dong.values = this
                        .LoaiHopDong
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.loai_hop_dong);
                }
                if (this.NhomCanBo) {
                    this.nhom_can_bo.values = this.NhomCanBo;
                    this
                        .sreachRequest
                        .push(this.nhom_can_bo);
                }
                if (this.TrinhDoChuyenMon) {
                    this.trinh_do_chuyen_mon.values = this
                        .TrinhDoChuyenMon
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.trinh_do_chuyen_mon);
                }
                if (this.KhuVuc) {
                    this.khu_vuc.values = this
                        .KhuVuc
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.khu_vuc);
                }
                if (this.maMonHoc) {
                    this.mon_day.values = this
                        .maMonHoc
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.maMonHoc);
                }
                if (this.maDanToc) {
                    this.dan_toc.values = this
                        .maDanToc
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.maDanToc);
                }
                if (this.LoaiCanBo) {
                    this.loai_can_bo.values = this
                        .LoaiCanBo
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.loai_can_bo);
                }
                if (this.DoTuoi) {
                    this.do_tuoi.values = this
                        .DoTuoi
                        .map(String);
                    this.DoTuoi;
                    this
                        .sreachRequest
                        .push(this.do_tuoi);
                }
                if (this.LoaiDanhGia) {
                    this.danh_gia_chuan_nghe_nghiep.values = this
                        .LoaiDanhGia
                        .map(String);
                    this
                        .sreachRequest
                        .push(this.danh_gia_chuan_nghe_nghiep);
                }
                if (this.DanTocThieuSo) {
                    if (this.DanTocThieuSo == 1) {
                        this.dan_toc_thieu_so.value = true;
                    } else {
                        this.dan_toc_thieu_so.value = false;
                    }
                    this
                        .sreachRequestValues
                        .push(this.dan_toc_thieu_so);
                }
                if (this.GiaoVienPhuTrachDoi) {
                    if (this.GiaoVienPhuTrachDoi == 1) {
                        this.giao_vien_phu_trach_doi.value = 1;
                    } else {
                        this.giao_vien_phu_trach_doi.value = 0;
                    }
                    this
                        .sreachRequestValues
                        .push(this.giao_vien_phu_trach_doi);
                }
                this.ganIndex();
            },
            ganIndex() {
                this.listCol = this.list_tieu_chi_chon;
                for (let i = 0; i < this.listCol.length; i++) {
                    this
                        .listCol[i]
                        .index = i;
                }
            },
            getData() {
                console.log("lấy dữ liệu");
                let params = {
                    "colList": this.listCol,
                    "requestLists": this.sreachRequest,
                    "requestList": this.sreachRequestValues,
                    "start": this.start,
                    "limit": this.limit
                };
                const loading1 = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-fetch/BaoCaoGiaoVien/sreach", params, (data) => {
                    loading1.close()
                    var html = '';
                    console.log("lấy báo cáo trả về" + JSON.stringify(data));
                    this.total_rows = data.data.total;
                    console.log("tổng số bản ghi:" + this.total_rows);
                    this.list_table_header = data.data.tableHeaders;
                    console.log("các cột");
                    console.log(JSON.stringify(this.list_table_header));
                    this.list_table_rows = data.data.tableRows;
                    console.log("các hàng");
                    console.log(JSON.stringify(this.list_table_rows));
                    if (this.list_table_rows) {
                        this.dowload = true;
                        this
                            .list_table_rows
                            .forEach(function (item) {
                                html += '<tr>';
                                item
                                    .col
                                    .forEach(function (i) {
                                        html += '<td class="">' + i.value + '</td>'
                                    });
                                html += '</tr>';
                            });
                    } else {
                        this.dowload = false;
                        html += '<tr><td>Không bản ghi nào được tìm thấy</td></tr>';
                    }
                    this.htmlrender = html;
                    setTimeout(() => {
                        this.MergeCommonRows();
                    }, 200)
                }, 60000, true);
            },
            MergeCommonRows() {
                console.log('số cột :' + this.list_table_header.length);
                let lengthCol = this.list_table_header.length;
                let ar = Array.from(Array(lengthCol - 2).keys());
                $('#textTable').margetable({
                    type: 2,
                    colindex: ar
                });
            },
            // Lấy trường học
            getTruongHoc() {
                let params = {
                    "capHoc": this.CapDay,
                    "maDonVi": this.DonViQuanLy
                };
                // const loading2 = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, (data) => {
                    // loading2.close();
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_truong_hoc);
                        this.ds_truong_hoc = data.data.rows;
                        for (let i = 0; i < this.ds_truong_hoc.length; i++) {
                            this.ds_truong_hoc[i].tenMaTruong = this.ds_truong_hoc[i].tenTruongHoc + " - [" +
                                this.ds_truong_hoc[i].maTruongHoc + "]";
                        }
                    }
                });
            },
            getDonVi() {
                let params = {
                    start: 0,
                    limit: 999,
                    maTinhThanh: this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, data => {
                    if (data.data.statusResponse == 0) {
                        let dl = [];
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                tenDonVi: data_demo[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data_demo[i].maDonVi + ']',
                                maDonVi: data_demo[i].maDonVi,
                            }
                            dl.push(obj);
                        }
                        this.ds_don_vi = dl;
                    } else {
                        this.ds_don_vi = [];
                    }
                });
            },
            ganDanToc() {
                let ds_dt = localStorage["danh_sach_dan_toc_sme"];
                if (ds_dt) {
                    this.ds_dan_toc = JSON.parse(ds_dt)
                } else {
                    this.ds_dan_toc = [];
                }
            },
            ganTonGiao() {
                let ds_tg = localStorage["danh_sach_ton_giao_sme"];
                if (ds_tg) {
                    this.ds_ton_giao = JSON.parse(ds_tg)
                } else {
                    this.ds_ton_giao = [];
                }
            },
            LocNangCao() {
                console.log("Lọc nâng cao");
                this.show_fillter = true;
            },
            NhapDuLieuLoc() {
                console.log("Nhập dữ liệu lọc");
            },
            onChonTieuChi(e) {
                console.log("chọn tiêu chí" + JSON.stringify(e));
                for (let i = 0; i < this.list_tieu_chi.length; i++) {
                    if (this.list_tieu_chi[i].index == e) {
                        this
                            .list_tieu_chi_chon
                            .push(this.list_tieu_chi[i]);
                        this
                            .list_tieu_chi[i]
                            .status = true;
                        if (e == 2) {}
                    }
                }
                this.LocCot();
                return;
            },
            deleteListTieuChi(e) {
                console.log("xóa tiêu chí" + e);
                for (let i = 0; i < this.list_tieu_chi_chon.length; i++) {
                    if (e == i) {
                        console.log(this.list_tieu_chi_chon[i]);
                        this
                            .list_tieu_chi_chon
                            .splice(e, 1);
                    }
                }
                console.log("dãy sau:" + JSON.stringify(this.list_tieu_chi_chon));
                return;
                this
                    .list_tieu_chi_chon
                    .splice(e, 1);
            },
            checkDisabled(e) {
                this.ResetDisabled();
                for (let i = 0; i < e.length; i++) {
                    for (let j = 0; j < this.list_tieu_chi.length; j++) {
                        if (e[i] == this.list_tieu_chi[j].nameCol) {
                            console.log("12");
                            console.log(e[i]);
                            this
                                .list_tieu_chi[j]
                                .status = true;
                        }
                    }
                }
                console.log("sau khi check xem có những ai trong list tiêu chí đã chọn");
                console.log(JSON.stringify(this.list_tieu_chi_chon));
                // sau khi check xong thì đưa xuống lọc nâng cao
                this.putIntoAdvancedFiltering();
            },
            putIntoAdvancedFiltering() {
                this.check_khoi_hoc = false,
                    this.check_trang_thai = false,
                    this.check_don_vi_quan_ly = false,
                    this.check_ton_giao = false,
                    this.check_vung_chinh_sach = false,
                    this.check_bo_sung = false,
                    this.check_truong = false,
                    this.check_nam_hoc = false,
                    this.check_gioi_tinh = false,
                    this.check_dan_toc_thieu_so = false,
                    this.check_loai_hinh_truong = false,
                    this.check_loai_hop_dong = false,
                    this.check_nhom_can_bo = false,
                    this.check_trinh_do_chuyen_mon = false,
                    this.check_khu_vuc = false,
                    this.check_mon_day = false,
                    this.check_dan_toc = false,
                    this.check_loai_can_bo = false,
                    this.check_cap_day = false,
                    this.check_do_tuoi = false,
                    this.check_giao_vien_phu_trach_doi = false,
                    this.check_danh_gia_chuan_nghe_nghiep = false,
                    this.check_nghi_huu_trong_nam = false,
                    this.check_tuyen_moi_trong_nam = false,
                    this.check_dan_toc_thieu_so = false,
                    console.log("check lọc nang cao gồm gì?");
                for (let i = 0; i < this.list_tieu_chi_chon.length; i++) {
                    console.log(JSON.stringify(this.list_tieu_chi_chon));
                    if (this.list_tieu_chi_chon[i].nameCol == "maDonVi") {
                        // console.log("chọn có mã đơn vị");
                        this.check_don_vi_quan_ly = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "capHoc") {
                        // console.log("chọn có mã đơn vị");
                        this.check_cap_day = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "maTruongHoc") {
                        // console.log("chọn có mã đơn vị");
                        this.check_truong = true;
                        this.check_don_vi_quan_ly = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "namHoc") {
                        // console.log("chọn có mã đơn vị");
                        this.check_nam_hoc = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "trangThai") {
                        // console.log("chọn có mã đơn vị");
                        this.check_trang_thai = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "gioiTinh") {
                        // console.log("chọn có mã đơn vị");
                        this.check_gioi_tinh = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "loaiHinhDaoTao") {
                        // console.log("chọn có mã đơn vị");
                        this.check_loai_hinh_truong = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "loaiHopDong") {
                        // console.log("chọn có mã đơn vị");
                        this.check_loai_hop_dong = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "loaiCanBo") {
                        // console.log("chọn có mã đơn vị");
                        this.check_nhom_can_bo = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "dgKqChuanNgheNghiep") {
                        // console.log("chọn có mã đơn vị");
                        this.check_danh_gia_chuan_nghe_nghiep = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "trinhDoChuyenMonCaoNhat") {
                        // console.log("chọn có mã đơn vị");
                        this.check_trinh_do_chuyen_mon = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "maKhuVuc") {
                        // console.log("chọn có mã đơn vị");
                        this.check_khu_vuc = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "maMonHoc") {
                        // console.log("chọn có mã đơn vị");
                        this.check_mon_day = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "maDanToc") {
                        // console.log("chọn có mã đơn vị");
                        this.check_dan_toc = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "maChucVu") {
                        // console.log("chọn có mã đơn vị");
                        this.check_loai_can_bo = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "doTuoi") {
                        // console.log("chọn có mã đơn vị");
                        this.check_do_tuoi = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "danTocThieuSo") {
                        console.log("chọn dân tộc thiểu số");
                        this.check_dan_toc_thieu_so = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "chuyenTrachDoi") {
                        this.check_giao_vien_phu_trach_doi = true;
                    }
                }
            },
            ResetDisabled() {
                for (let i = 0; i < this.list_tieu_chi.length; i++) {
                    this
                        .list_tieu_chi[i]
                        .status = false;
                }
            }
        }
    };

</script>
<style scoped="scoped">
    a,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    label,
    p,
    span {
        margin: 0;
        padding: 0;
    }

    .red {
        color: #DC0101;
        padding: 0 2px;
    }

    .list-advan label {
        font-weight: normal;
    }

    .inputieuchi {
        display: inline-block;
        line-height: 1;
        background: #ccc5c5;
        padding: 4px 10px;
        color: black;
        transition: background-color 3s linear;
    }

    .chon {
        height: 24px;
    }

    .locnangcao {
        padding: 5px;
        display: inline-flex;
    }

    .thongtinbosung {
        height: 34px;
        vertical-align: middle;
        align-items: center;
        display: flex;
    }

    .kichhoat {
        background: #64FE2E;
        transition: background-color 3s linear;
        color: black;
        margin-top: 1px;
        border-radius: 4px;
    }

    .thieutieuchi {
        /* background: #64FE2E; */
        border: 2px solid red;
    }

    .e-multiselect .e-multi-select-wrapper.e-down-icon,
    .e-multiselect.e-checkbox .e-multi-select-wrapper {
        border: 1px solid black;
    }

    .form-control {
        height: 30px;
    }

    .loader {
        border: 3px solid #f3f3f3;
        /* Light grey */
        border-top: 3px solid #3498db;
        /* Blue */
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .btn-info {
        position: relative;
    }

    .btn-info span {
        display: none;
        position: absolute;
        top: 5px;
        right: -25px;
    }

    .btn-info.show span {
        display: block;
    }

</style>

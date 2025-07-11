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
            <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne2" aria-expanded="true"
                aria-controls="collapseOne2">
                + Lọc nâng cao
            </a>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div id="collapseOne2" class="panel-collapse collapse text-center" role="tabpanel"
                        aria-labelledby="headingOne" v-if="list_tieu_chi_chon.length==0">
                        <p>Bạn chưa chọn tiêu chí nào</p>
                    </div>
                    <div v-else="v-else" id="collapseOne2" class="panel-collapse collapse in" role="tabpanel"
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

                                    <!-- -->
                                </div>
                                <div v-if="check_cap_day" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Cấp học:</label>
                                    <!-- <ejs-multiselect
                                        class="form-control"
                                        id="multiselect"
                                        v-model="CapDay"
                                        :dataSource="list_cap_hoc"
                                        :showClearButton='false'
                                        placeholder="Chọn cấp học"
                                        :allowFiltering='true'
                                        :filtering='timCapHoc'
                                        mode="CheckBox"
                                        :fields="dscd"
                                        :showSelectAll="showSelectAll"
                                        selectAllText="Chọn tất cả"
                                        unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect> -->
                                    <eselect style="width:100%" @change="getTruongHoc" multiple
                                        no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="CapDay"
                                        :placeholder="'Chọn cấp dạy'" filterable :data="list_cap_hoc"
                                        :fields="['name','id']" />

                                </div>
                                <div v-if="check_truong" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Trường:</label>
                                    <!-- <ejs-multiselect
                                        style="border:1px solid blue; "
                                        class="form-control"
                                        id="multiselect"
                                        v-model="TruongHoc"
                                        :dataSource="ds_truong_hoc"
                                        :showClearButton='false'
                                        placeholder="Chọn trường"
                                        :allowFiltering='true'
                                        :filtering='timTruongHoc'
                                        mode="CheckBox"
                                        :fields="dsth"
                                        :showSelectAll="showSelectAll"
                                        selectAllText="Chọn tất cả"
                                        unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect> -->
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="TruongHoc"
                                        :placeholder="'Chọn'" filterable :data="ds_truong_hoc"
                                        :fields="['tenMaTruong','maTruongHoc']" />
                                    <!-- -->
                                </div>
                                <div v-if="check_nam_hoc" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Năm học:</label>
                                    <!-- <select v-model="NamHoc" class="form-control" style="width:100%">
                                        <option value="">Chọn năm học</option>
                                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                    </select> -->
                                    <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="NamHoc"
                                        :placeholder="'Chọn năm học'" filterable :data="list_years"
                                        :fields="['name','id']" />
                                </div>
                                <div v-if="check_loai_hinh_truong" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Loại hình trường:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="loaiHinhDaoTao"
                                        :placeholder="'Chọn loại hình trường'" filterable :data="list_loai_hinh_truong"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_loai_truong" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Loại trường:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="LoaiTruong"
                                        :placeholder="'Chọn loại trường'" filterable :data="list_loai_truong"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_chuan_truong" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Chuẩn quốc gia:</label>
                                    <!-- <ejs-multiselect class="form-control" id="multiselect" v-model="ChuanTruong"
                                        :dataSource="list_chuan_truong" :showClearButton='false'
                                        placeholder="Chuẩn quốc gia" :allowFiltering='true' :filtering='timChuanTruong'
                                        mode="CheckBox" :fields="dslhd" :showSelectAll="showSelectAll"
                                        selectAllText="Chọn tất cả" unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect> -->
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="ChuanTruong"
                                        :placeholder="'Chọn'" filterable :data="list_chuan_truong"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_khu_vuc" class="col-md-3" style="margin-bottom:15px;">
                                    <label>khu vực:</label>
                                    <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="KhuVuc"
                                        :placeholder="'Chọn khu vực'" filterable :data="list_khu_vuc"
                                        :fields="['name','value']" />
                                </div>
                                <div v-if="check_truong_qt" class="col-md-3" style="margin-bottom:15px;">
                                    <label>Trường quốc tế:</label>
<!--                                    <ejs-dropdownlist v-model="TruongQuocTe" placeholder='Trường quốc tế'-->
<!--                                        :dataSource='BooleanValue' :fields='dsldg'></ejs-dropdownlist>-->
                                    <!-- <label><input v-model="TruongQuocTe" type="checkbox"><span
                                    style="padding-right:10px;font-weight: normal;">Là trường quốc
                                    tế</span></label>-->

                                    <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="TruongQuocTe"
                                        :placeholder="'Chọn'" filterable :data="BooleanValue"
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
        <!-- Biểu đồ dữ liệu -->
        <div>
            <div style="padding-top:15px; display:none;">
                <div>
                    <div id="collapse2" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div>
                                <div style="width:80%; margin:0 auto;">
                                    <apexchart width="90%" height="300px;" type="bar" :options="options"
                                        :series="series"></apexchart>
                                </div>
                            </div>
                            <div class="text-center text-uppercase">
                                <h4>Biểu đồ thống kê</h4>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -->
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
                    <input :disabled="list_table_rows.length==0" type="checkbox" @click="checkVertical" />
                    Xuất dữ liệu ngang</label>
                <el-button :disabled="list_table_rows.length==0" size="mini" type="success"
                    @click.prevent="XuatFileExcel">Xuất excel
                </el-button>

                <el-button @click.prevent="loadTemplateModal" size="mini" type="info">Tải mẫu</el-button>
                <el-button :disabled="list_tieu_chi_chon.length==0" @click.prevent="saveTemplateModal" size="mini"
                    type="warning">Lưu
                    mẫu</el-button>

                <!-- <button :disabled="list_table_rows.length==0" class="btn btn-info" @click.prevent="XuatFileExcel">Tải
                    xuống
                    <span>
                        <div class="loader"></div>
                    </span>
                </button>

                <button @click.prevent="loadTemplateModal" class="btn btn-primary" style="margin: 5px;">Tải mẫu</button>
                <button @click.prevent="saveTemplateModal" class="btn btn-primary" style="margin-right: 5px;">Lưu
                    mẫu</button> -->
            </div>
            <div class="col-md-12">
                <div class="table-responsive row_tp">
                    <table id="textTableSchool" class="table table-bordered table-report">
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
        <el-dialog title="Lưu mẫu" :visible.sync="SchoolModalSave" :close-on-click-modal="false"
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
        <el-dialog title="Chọn mẫu" :visible.sync="SchoolModalLoad" :close-on-click-modal="false"
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
        <div id="SchoolModalLoad" v-if="false" class="modal fade" role="dialog">
            <div class="modal-dialog modal-lg">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Chọn mẫu</h4>
                    </div>
                    <div class="modal-body">
                        <input v-model="searchTemp" type="text" class="form-control" placeholder="Chọn template"
                            @input="getTemplate" />
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
                    </div>
                    <div class="modal-footer">
                        <el-button type="info" size="mini" @click.prevent="loadTemplate">Tải mẫu</el-button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import rest_api from "../../../utils/rest_api";
    import array_util from "../../../utils/array_utils";
    import utils from '../../../utils'
    import ElementUI from 'element-ui';
    import ESelectVue from '../../ui/ESelect.vue';
    import constant from "../../../utils/constant";
    import Vue from "vue";
    import VueAlertify from "vue-alertify";
    import Page from '../../ui/PagingCustom';
    import FileSaver from 'file-saver';
    Vue.use(VueAlertify);
    Vue.use(ElementUI);
    export default {
        props: ["infologin"],
        components: {
            "Page": Page,
            'eselect': ESelectVue,
        },

        data() {
            return {
                BooleanValue: [{
                    value: 0,
                    name: 'Tất cả'
                }, {
                    value: 1,
                    name: 'Có'
                }, {
                    value: 2,
                    name: 'Không'
                }],
                NameTemplate: "",
                listTemp: [],
                searchTemp: "",
                // -----------------
                htmlrender: '',
                thongtindangnhap: "",
                dowload: false,
                isVertical: 0,
                // phân trang

                total_rows: 0,
                start: 0,
                currentPage: 1,
                limit: 25,
                // Biểu đồ

                options: {
                    chart: {
                        id: 'vuechart-example'
                    },
                    xaxis: {
                        categories: [
                            "Phòng Uông Bí",
                            "Phòng Hạ Long",
                            "Phòng Đầm Hà",
                            "Phòng Tiên Yên",
                            "Phòng Quảng Yên",
                            "Phòng Cô Tô"
                        ]
                    }
                },
                series: [{
                    name: 'series-1',
                    data: [
                        45,
                        50,
                        49,
                        60,
                        70,
                        30
                    ]
                }],
                // check list
                showSelectAll: true,
                dsdv: {
                    text: "tenMaDonVi",
                    value: "maDonVi"
                },
                dsth: {
                    text: "tenMaTruong",
                    value: "maTruongHoc"
                },
                dscd: {
                    text: "name",
                    value: "id"
                },
                dstt: {
                    text: "name",
                    value: "value"
                },
                dslht: {
                    text: "name",
                    value: "value"
                },
                dslhd: {
                    text: "name",
                    value: "value"
                },
                dsncb: {
                    text: "name",
                    value: "value"
                },
                dstdcm: {
                    text: "name",
                    value: "value"
                },
                dskv: {
                    text: "name",
                    value: "value"
                },
                dslcb: {
                    text: "name",
                    value: "value"
                },
                dsdt: {
                    text: "name",
                    value: "value"
                },
                dsldg: {
                    text: "name",
                    value: "value"
                },
                trues: true,
                falses: false,
                ChonTatCaLocNangCao: false,
                thieu_tieu_chi: false,
                SchoolModalLoad: false,
                SchoolModalSave: false,
                list_years: [],
                LoaiBaoCao: '2',
                // Các loại check của cán bộ
                check_chuan_truong: false,
                check_loai_truong: false,
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
                check_loai_can_bo: false,
                check_cap_day: false,
                check_do_tuoi: false,
                check_giao_vien_phu_trach_doi: false,
                check_danh_gia_chuan_nghe_nghiep: false,
                check_nghi_huu_trong_nam: false,
                check_tuyen_moi_trong_nam: false,
                check_truong_qt: false,
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
                    "name": "Cấp học",
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
                    "name": "Loại hình trường",
                    "nameCol": "loaiHinhDaoTao",
                    "status": false,
                    "index": "5"
                }, {
                    "name": "Chuẩn quốc gia",
                    "nameCol": "chuanQuocGia",
                    "status": false,
                    "index": "8"
                }, {
                    "name": "Loại trường",
                    "nameCol": "maLoaiTruong",
                    "status": false,
                    "index": "7"
                }, {
                    "name": "Khu vực",
                    "nameCol": "maKhuVuc",
                    "status": false,
                    "index": "6"
                }, {
                    "name": "Trường quốc tế",
                    "nameCol": "truongQuocTe",
                    "status": false,
                    "index": "9"
                }],
                list_tieu_chi_truong: [{
                    "name": "Cấp học",
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
                    "name": "Khu vực",
                    "nameCol": "maKhuVuc",
                    "status": false,
                    "index": "11"
                }],
                //Nội dung gửi đi của cán bộ
                listCol: [],
                sreachRequest: [],
                SchoolModalSave: false,
                sreachRequestValues: [],
                check_disabled: [],
                don_vi_quan_ly: {
                    name: "Đơn vị quản lý",
                    nameSreach: "maDonVi",
                    values: ""
                },
                cap_day: {
                    name: "Cấp học",
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

                loai_truong: {
                    name: "Loại truong",
                    nameSreach: "maLoaiTruong",
                    values: ""
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
                truong_qt: {
                    name: "Trường quốc tế",
                    nameSreach: "truongQuocTe",
                    values: ""
                },
                khu_vuc: {
                    name: "Khu vực",
                    nameSreach: "maKhuVuc",
                    values: ""
                },
                chuan_truong: {
                    name: "Chuẩn quốc gia",
                    nameSreach: "chuanQuocGia",
                    values: ""
                },

                // Phần param cho cán bộ

                list_loai_hinh_truong: constant.LOAI_HINH_TRUONG,
                list_khu_vuc: constant.KHU_VUC,
                list_do_tuoi: constant.DO_TUOI,
                // list_cap_hoc: constant.LIST_CAP_HOC,
                list_cap_hoc: window.listCapHoc,
                list_loai_truong: constant.LOAI_TRUONG,
                list_chuan_truong: constant.CHUAN_TRUONG,
                DonViQuanLy: "",
                CapDay: [],
                TruongHoc: "",
                NamHoc: "",
                TrangThaiCanBo: "",
                GioiTinh: '',
                loaiHinhDaoTao: "",
                KhuVuc: "",
                DanTocThieuSo: "",
                LoaiTruong: "",
                ChuanTruong: "",
                TruongQuocTe: ''
            };
        },
        watch: {
            check_truong: function (params) {
                console.log(params);
                this.TruongHoc = [],
                    array_util.clearArrays(this.ds_truong_hoc);
                if (this.check_truong && this.DonViQuanLy.length != 0) {
                    this.getTruongHoc();
                }
            },
            // Check thay đổi đơn vị quản lý
            DonViQuanLy: function (newVal) {
                this.TruongHoc = "";
                if (newVal.length == 0) {
                    this.ds_truong_hoc = [];
                } else {
                    this.getTruongHoc();
                }
            },
            CapDay: function (newVal) {
                this.TruongHoc = "";
                if (this.check_truong && this.DonViQuanLy.length != 0) {
                    this.getTruongHoc();
                }
            },

            list_tieu_chi_chon: function (newVal) {
                console.log("check sự thay đổi của list tiêu chí đã chọn");
                // this.checkDisabled();
                this.LocCot();
                this.putIntoAdvancedFiltering();
            },
            // Check các thay đổi của lọc nâng cao

            check_loai_truong: function (newVal) {
                if (!newVal) {
                    console.log("bỏ chọn cấp dạy");
                    this.LoaiTruong = "";
                }
            },
            check_truong_qt: function (newVal) {
                if (!newVal) {
                    this.TruongQuocTe = 0;
                }
            },
            check_chuan_truong: function (newVal) {
                if (!newVal) {
                    console.log("bỏ chọn cấp dạy");
                    this.ChuanTruong = "";
                }
            },
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
                    this.DanTocThieuSo = "";
                }
            },
            check_giao_vien_phu_trach_doi: function (newVal) {
                if (!newVal) {
                    this.GiaoVienPhuTrachDoi = "";
                }
            },
            check_loai_hinh_truong: function (newVal) {
                if (!newVal) {
                    console.log("bỏ chọn loại hình đào tạo");
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
            this.thongtin = JSON.parse(this.infologin);
            console.log("thông tin đăng nhập" + JSON.stringify(this.thongtin));
            console.log(
                "thông tin đăng nhập" + JSON.stringify(this.list_trang_thai_can_bo)
            );
            this.getDonVi();
            this.getDanToc();
            this.getTonGiao();
            this.list_years = this.getYear();
        },
        methods: {
            handleClose(){
                console.log('handleClose');
                this.SchoolModalSave = false;
                this.SchoolModalLoad = false;
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
                    "type": 3
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
                this.SchoolModalLoad = true;
            },
            loadTemplate() {
                if (this.searchTemp == '') {
                    alert('Vui lòng chọn mẫu');
                    return;
                }
                this.list_tieu_chi_chon = this.listCol;
                this.pushDataTemplate(this.sreachRequest);
                this.pushDataTemplate(this.sreachRequestValues);
                this.SchoolModalLoad = false;
                this.searchTemp = '';
            },
            pushDataTemplate(data) {
                data.forEach((item) => {

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
                    if (item.nameSreach == "loaiHinhDaoTao") {
                        this.loaiHinhDaoTao = item.values
                    }
                    if (item.nameSreach == "maKhuVuc") {
                        this.KhuVuc = item.values
                    }
                    if (item.nameSreach == "maLoaiTruong") {
                        this.LoaiTruong = item.values
                    }
                    if (item.nameSreach == "chuanQuocGia") {
                        this.ChuanTruong = item.values
                    }
                    if (item.nameSreach == "truongQuocTe") {
                        if (item.value)
                            this.TruongQuocTe = 1;
                        else
                            this.TruongQuocTe = 2;
                    }
                })
            },
            saveTemplateModal() {
                this.NameTemplate = '';
                this.SchoolModalSave = true;
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
            saveTemplate() {
                let name = this.NameTemplate;
                if (!name) {
                    // this
                    //     .$alertify
                    //     .error("Vui lòng nhập tên template.");
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
                            "type": 3,
                            "name": name
                        };
                        rest_api.post("/csdlgd-report-fetch/template/save", params, (data) => {
                            if (data.data.rc == 0) {
                                // this
                                //     .$alertify
                                //     .success("Lưu template thành công.");
                                    this.thongBao('success',data.data.rd)
                                this.SchoolModalSave = false;
                            } else {
                                // this
                                //     .$alertify
                                //     .error("Thất bại." + data.data.rd);
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
                    let url = "/xuat-excel-bao-cao-dong-truong-hoc";
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
                        fileName = this.thongtin.ma_so + '_Bao_cao_truong_hoc_' + currentDate.getDate() +
                            thangNay + (currentDate.getFullYear());
                        // alert(fileName)
                        FileSaver.saveAs(data.data.file, fileName);
                    });
                } else {
                    $(e.target).removeClass('show');
                    $(e.target).attr("disabled", false);
                    $(e.target).removeAttr("disabled");
                    alert("Không có dữ liệu nào để xuất!")
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
                    if (this.don_vi_quan_ly.values.length) {
                        this
                            .sreachRequest
                            .push(this.don_vi_quan_ly);
                    }

                }
                if (this.CapDay) {
                    console.log("có cấp dạy");
                    this.cap_day.values = this
                        .CapDay
                        .map(String);
                    if (this.cap_day.values.length) {
                        this
                            .sreachRequest
                            .push(this.cap_day);
                    }

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
                if (this.TruongQuocTe) {
                    if (this.TruongQuocTe == 1) {
                        this.truong_qt.value = true;
                    } else {
                        this.truong_qt.value = false;
                    }
                    this
                        .sreachRequestValues
                        .push(this.truong_qt);
                }
                if (this.loaiHinhDaoTao) {
                    this.loai_hinh_truong.values = this.loaiHinhDaoTao;
                    if (this.loai_hinh_truong.values.length) {
                        this
                            .sreachRequest
                            .push(this.loai_hinh_truong);
                    }
                }
                if (this.ChuanTruong) {
                    this.chuan_truong.values = this.ChuanTruong;
                    if (this.chuan_truong.values.length) {
                        this
                            .sreachRequest
                            .push(this.chuan_truong);
                    }

                }
                if (this.KhuVuc) {
                    this.khu_vuc.values = this
                        .KhuVuc
                        .map(String);
                    if (this.khu_vuc.values.length) {
                        this
                            .sreachRequest
                            .push(this.khu_vuc);
                    }
                }
                if (this.LoaiTruong) {
                    this.loai_truong.values = this
                        .LoaiTruong
                        .map(String);
                    if (this.loai_truong.values.length) {
                        this
                            .sreachRequest
                            .push(this.loai_truong);
                    }

                }
                this.ganIndex();
                console.log("Danh sách cột" + JSON.stringify(this.listCol));
                console.log("Danh sách lọc" + JSON.stringify(this.sreachRequest));
                this.getData();

            },
            TienHanhLoc2() {
                this.total_rows = 0;

                this.sreachRequest = [];
                this.sreachRequestValues = [];

                if (this.DonViQuanLy) {
                    console.log("có đơn vị");
                    this.don_vi_quan_ly.values = this.DonViQuanLy;
                    if (this.don_vi_quan_ly.values.length) {
                        this
                            .sreachRequest
                            .push(this.don_vi_quan_ly);
                    }

                }
                if (this.CapDay) {
                    console.log("có cấp dạy");
                    this.cap_day.values = this
                        .CapDay
                        .map(String);
                    if (this.cap_day.values.length) {
                        this
                            .sreachRequest
                            .push(this.cap_day);
                    }

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
                if (this.TruongQuocTe) {
                    if (this.TruongQuocTe == 1) {
                        this.truong_qt.value = true;
                    } else {
                        this.truong_qt.value = false;
                    }
                    this
                        .sreachRequestValues
                        .push(this.truong_qt);
                }
                if (this.loaiHinhDaoTao) {
                    this.loai_hinh_truong.values = this.loaiHinhDaoTao;
                    if (this.loai_hinh_truong.values.length) {
                        this
                            .sreachRequest
                            .push(this.loai_hinh_truong);
                    }
                }
                if (this.ChuanTruong) {
                    this.chuan_truong.values = this.ChuanTruong;
                    if (this.chuan_truong.values.length) {
                        this
                            .sreachRequest
                            .push(this.chuan_truong);
                    }

                }
                if (this.KhuVuc) {
                    this.khu_vuc.values = this
                        .KhuVuc
                        .map(String);
                    if (this.khu_vuc.values.length) {
                        this
                            .sreachRequest
                            .push(this.khu_vuc);
                    }
                }
                if (this.LoaiTruong) {
                    this.loai_truong.values = this
                        .LoaiTruong
                        .map(String);
                    if (this.loai_truong.values.length) {
                        this
                            .sreachRequest
                            .push(this.loai_truong);
                    }

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
                const loading6 = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post(
                    "/csdlgd-report-fetch/BaoCaoTruongHoc/search",
                    params,
                    (data) => {
                        loading6.close();
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
                    },
                    10000,
                    true
                );
            },
            MergeCommonRows() {
                let lengthCol = this.list_table_header.length;
                let ar = Array.from(Array(lengthCol - 2).keys());

                $('#textTableSchool').margetable({
                    type: 2,
                    colindex: ar
                });

            },
            // các hàm custom phần check list

            timDonVi: function (args) {
                var searchData = this.ds_don_vi;
                var query = new Query();
                query = (args.text != "") ?
                    query.where("tenMaDonVi", "contains", args.text, true) :
                    query;
                args.updateData(searchData, query);
            },
            timCapHoc: function (args) {
                var searchData = this.list_cap_hoc;
                var query = new Query();
                query = (args.text != "") ?
                    query.where("name", "contains", args.text, true) :
                    query;
                args.updateData(searchData, query);
            },
            timTruongHoc: function (args) {
                var searchData = this.ds_truong_hoc;
                var query = new Query();
                query = (args.text != "") ?
                    query.where("tenMaTruong", "contains", args.text, true) :
                    query;
                args.updateData(searchData, query);
            },
            timLoaiTruong: function (args) {
                var searchData = this.list_loai_truong;
                var query = new Query();
                query = (args.text != "") ?
                    query.where("name", "contains", args.text, true) :
                    query;
                args.updateData(searchData, query);
            },

            timloaiHinhDaoTao: function (args) {
                var searchData = this.list_loai_hinh_truong;
                var query = new Query();
                query = (args.text != "") ?
                    query.where("name", "contains", args.text, true) :
                    query;
                args.updateData(searchData, query);
            },
            timChuanTruong: function (args) {
                var searchData = this.list_chuan_truong;
                var query = new Query();
                query = (args.text != "") ?
                    query.where("name", "contains", args.text, true) :
                    query;
                args.updateData(searchData, query);
            },

            timKhuVuc: function (args) {
                var searchData = this.list_khu_vuc;
                var query = new Query();
                query = (args.text != "") ?
                    query.where("name", "contains", args.text, true) :
                    query;
                args.updateData(searchData, query);
            },

            //
            // Lấy trường học
            getTruongHoc() {
                let params = {
                    "capHoc": this.CapDay,
                    "maDonVi": this.DonViQuanLy
                };
                //  const loading5 = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, (data) => {
                    // loading5.close()
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
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_don_vi);
                        this.ds_don_vi = data.data.rows;
                        for (let i = 0; i < this.ds_don_vi.length; i++) {
                            this.ds_don_vi[i].tenMaDonVi = this.ds_don_vi[i].tenDonVi + " - [" + this.ds_don_vi[
                                i].maDonVi + "]";
                        }
                    }
                });
            },
            getDanToc() {
                let params = {
                    start: 0,
                    limit: 999
                };
                rest_api.get("/internal-api/dmDanToc/filter", params, data => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_dan_toc);
                        this.ds_dan_toc = data.data.rows;
                    }
                });
            },
            getTonGiao() {
                let params = {
                    start: 0,
                    limit: 999
                };
                rest_api.get("/internal-api/dmTonGiao/filter", params, data => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_ton_giao);
                        this.ds_ton_giao = data.data.rows;
                    }
                });
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
                    this.check_truong = false,
                    this.check_nam_hoc = false,
                    this.check_loai_hinh_truong = false,
                    this.check_khu_vuc = false,
                    this.check_loai_can_bo = false,
                    this.check_cap_day = false;
                this.check_dan_toc_thieu_so = false;
                this.check_loai_truong = false;
                this.check_chuan_truong = false;
                this.check_truong_qt = false;
                console.log("check lọc nang cao gồm gì?");
                for (let i = 0; i < this.list_tieu_chi_chon.length; i++) {
                    console.log(JSON.stringify(this.list_tieu_chi_chon));
                    if (this.list_tieu_chi_chon[i].nameCol == "truongQuocTe") {
                        // console.log("chọn có mã đơn vị");
                        this.check_truong_qt = true;
                    }
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
                    if (this.list_tieu_chi_chon[i].nameCol == "gioiTinh") {
                        // console.log("chọn có mã đơn vị");
                        this.check_gioi_tinh = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "loaiHinhDaoTao") {
                        // console.log("chọn có mã đơn vị");
                        this.check_loai_hinh_truong = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "maKhuVuc") {
                        // console.log("chọn có mã đơn vị");
                        this.check_khu_vuc = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "danTocThieuSo") {
                        console.log("chọn dân tộc thiểu số");
                        this.check_dan_toc_thieu_so = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "maLoaiTruong") {
                        this.check_loai_truong = true;
                    }
                    if (this.list_tieu_chi_chon[i].nameCol == "chuanQuocGia") {
                        this.check_chuan_truong = true;
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

<template>
    <div>
        <div v-loading.fullscreen.lock="fullScreenLoading" element-loading-text="Loading..."
            element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
            <Breadcrumb :menu="'Kết chuyển dữ liệu'" :desc="'Lịch sử đẩy dữ liệu lên Ioc'" />
            <div class="card-bieu-do">
                <el-form ref="ruleForm">
                    <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                        <el-col :span="24">
                            <div class="table-name">Thông tin tìm kiếm</div>
                        </el-col>
                        <el-col :sm="12" :lg="8">
                            <label class="typo__label">Đơn vị quản lý</label>
                            <div>
                                <eselect style="width:100%;" :disabled="thongtin.role>3" @change="ChonCapHoc() " multiple collapseTags
                                    v-model="ds_don_vi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                    :fields="['name','value']" />
                            </div>
                        </el-col>
                        <el-col :sm="12" :lg="8">
                            <div>
                                <label class="typo__label">Cấp học</label>
                                <div>
                                    <eselect style="width:100%;" @change="ChonCapHoc()" :disabled="thongtin.role==5" multiple collapseTags
                                        v-model="ds_cap_hoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                                        :fields="['name','id']" />
                                </div>
                            </div>
                        </el-col>
                        <el-col :sm="12" :lg="8">
                            <label class="typo__label">Năm học <span class="red">*</span></label>
                            <eselect style="width:100%;" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </el-col>

                        <el-col :sm="12" :lg="8">
                            <div>
                                <label class="typo__label">Trường học</label>
                                <eselect style="width:100%;" :disabled="thongtin.role==5" multiple collapseTags
                                    v-model="ds_truong_hoc" :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                    :fields="['name','value']" />
                            </div>
                        </el-col>
                        <el-col :sm="12" :lg="8">
                            <label class="typo__label">Mã lần đẩy</label>
                            <el-input v-model="messageId" placeholder="Nhập..." clearable>
                            </el-input>
                        </el-col>

                        <el-col :sm="12" :lg="8">
                            <label class="typo__label">Loại dữ liệu</label>
                            <eselect style="width:100%;" collapseTags v-model="ds_yeu_cau" :placeholder="'Chọn'"
                                filterable :data="list_yeu_cau" :fields="['name','key']" />
                        </el-col>
                        <el-col :sm="24" :lg="24" class="text-center">
                            <el-button class="bt-chinh" plain type="success" size="mini"
                                @click.prevent="checkTruocKhiTimKiem()">Tìm kiếm
                            </el-button>
                        </el-col>

                    </el-row>
                </el-form>

            </div>
            <div class="card-bieu-do">
                <el-row :gutter="24">

                    <el-col :span="24">
                        <div class="centerBetweenFlex">
                            <label class="table-name">Danh sách trường đẩy dữ liệu lên Ioc</label>
                        </div>
                    </el-col>
                    <el-col :span="24">
                        <div class="table-responsive row_tp">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr style="background:#e4ebf5">
                                        <th class="text-center">
                                            <p>STT</p>
                                        </th>
                                        <th class="">
                                            <p>Tên trường</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Mã Trường</p>
                                        </th>
                                        <th class="">
                                            <p>Cấp học</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Năm học</p>
                                        </th>
                                        <th class="">
                                            <p>Loại dữ liệu</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Thời gian đẩy</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Mã lần đẩy</p>
                                        </th>
                                        <th class="">
                                            <p>Trạng thái</p>
                                        </th>
                                        <th class="">
                                            <p>Mã lỗi và mô tả</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Xem kết quả xử lý</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="listKetChuyen.length===0">
                                    <tr>
                                        <td class="text-center" colspan="23">
                                            <p>Không có bản ghi nào</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else="v-else">
                                    <tr v-for="(tg,index) in listKetChuyen">
                                        <td class="text-center">
                                            <p>{{(currentPage-1)*limit + index+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.tenTruongHoc}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.maTruongHoc}}</p>
                                        </td>
                                        <td>
                                            <p>{{getCapHoc(parseInt(tg.capHoc))}} </p>
                                        </td>
                                        <td>
                                            <p>{{tg.namHoc}} - {{(parseInt(tg.namHoc) + 1)}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.type}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.createdTime}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.messageId}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.responseDescription}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.errorDescription}}</p>
                                        </td>
                                        <td class="text-center">
                                            <a title="Chỉnh sửa" v-on:click="xemChiTiet(tg)">
                                                <i class="el-icon-view"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </el-col>
                    <el-col :span="24">
                        <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                        </Page>
                        <ThongTin :show="show_info" :item="idBanGhi" @success="onCreatedData($event)"
                            @close="show_info=false"></ThongTin>
                    </el-col>
                </el-row>
            </div>
        </div>

        <!-- Add modal for detail view -->
        <el-dialog 
            :title="titleDialog"
            :visible.sync="showDetailModal" 
            width="80%"
            :before-close="() => { showDetailModal = false; detailData = []; titleDialog = ''; }">
            <div class="table-responsive" style="padding: 0 24px;">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr style="background:#e4ebf5">
                            <th class="text-center">STT</th>
                            <th class="">Tên</th>
                            <th class="text-center">Mã</th>
                            <th class="">Lỗi</th>
                            <th class="text-center">Mã lỗi</th>
                            <th class="">Mô tả</th>
                        </tr>
                    </thead>
                    <tbody v-if="detailData.length === 0">
                        <tr>
                            <td class="text-center" colspan="10">
                                <p>Không có dữ liệu</p>
                            </td>
                        </tr>
                    </tbody>
                    <tbody v-else>
                        <tr v-for="(item, index) in detailData" :key="index">
                            <td class="text-center">{{index + 1}}</td>
                            <td>{{item.name}}</td>
                            <td class="text-center">{{item.ma}}</td>
                            <td>{{item.errorDescription}}</td>
                            <td class="text-center">{{item.error}}</td>
                            <td>{{item.errorFieldTitle}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button @click="showDetailModal = false; detailData = []">Đóng</el-button>
            </span>
        </el-dialog>

        <!-- Form thêm mới -->
        <el-dialog title="Thêm mới" :visible.sync="show_them_moi" width="30%" :before-close="() => { show_them_moi = false; resetFormThemMoi(); }">
            <el-form ref="formThemMoi" :model="formThemMoi" :rules="rules" label-width="120px">
                <el-form-item label="Tên" prop="ten">
                    <el-input v-model="formThemMoi.ten"></el-input>
                </el-form-item>
                <el-form-item label="Mã" prop="ma">
                    <el-input v-model="formThemMoi.ma"></el-input>
                </el-form-item>
                <el-form-item label="Mô tả" prop="moTa">
                    <el-input type="textarea" v-model="formThemMoi.moTa"></el-input>
                </el-form-item>
                <el-form-item label="Trạng thái" prop="trangThai">
                    <el-select v-model="formThemMoi.trangThai" placeholder="Chọn trạng thái">
                        <el-option label="Hoạt động" :value="1"></el-option>
                        <el-option label="Không hoạt động" :value="0"></el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button @click="show_them_moi = false; resetFormThemMoi();">Hủy</el-button>
                <el-button type="primary" @click="themMoi">Lưu</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import constant from "../../utils/constant";
    import datePicker from "vue-bootstrap-datetimepicker";
    import api from './../api';
    import utils from '../../utils'
    import moment from "moment";
    import ElementUI from 'element-ui';
    import Page from "../ui/PagingCustom";
    import ThongTin from "./ThongTinLichSuChuyenDuLieuLenBo";
    import VueAlertify from "vue-alertify";
    import ESelectVue from '../ui/ESelect.vue';
    import Breadcrumb from '../ui/Breadcrumb.vue';

    Vue.use(ElementUI);

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
    export default {
        props: ['trangcu'],
        components: {
            'eselect': ESelectVue,
            Multiselect,
            Page: Page,
            ThongTin: ThongTin,
            Breadcrumb
        },
        computed: {},
        data() {
            return {
                windowWidth: window.innerWidth,
                columnWidths: {
                    maTruong: 100,
                    tenTruong: 200,
                    maDoiTac: 120,
                },
                fullScreenLoading: false,
                //custom chọn tất cả
                ds_don_vi_custom: [],
                ds_cap_hoc_custom: [{
                    selectAll: 'Chọn tất cả',
                    libs: []
                }, ],
                // thông tin người đăng nhập
                date: new Date(),
                slectAll: false,
                hienthibutton: false,
                namHocHienTai: "",
                tenDonViDangNhap: "",
                capHocDangNhap: "",
                thongTinTrangCu: {},
                thongtin: {},
                list_don_vi: [],
                lsDelete: [],
                // Add new data properties for modal
                showDetailModal: false,
                detailData: [],
                titleDialog: "",

                list_dong_bo_du_lieu_hk1: constant.list_dong_bo_du_lieu_hk1,
                list_dong_bo_du_lieu_hk2: constant.list_dong_bo_du_lieu_hk2,
                list_dong_bo_du_lieu_cn: constant.list_dong_bo_du_lieu_cn,
                // list_yeu_cau: constant.list_dong_bo_du_lieu_day_len_bo_full,
                list_yeu_cau: [{
                        key: '1',
                        name: 'Trường'
                    },
                    {
                        key: '2',
                        name: 'Cán bộ'
                    },
                    {
                        key: '3',
                        name: 'Học sinh'
                    },
                    {
                        key: '4',
                        name: 'Kết quả học tập'
                    },
                ],
                list_yeu_cau_full: constant.list_dong_bo_du_lieu_day_len_bo_full,

                list_trang_thai: constant.list_trang_thai_day_len_bo,
                list_cap_hoc: window.listCapHoc,
                list_truong_hoc: [],
                list_doi_tac: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_hoc_ky: constant.LIST_HOC_KY,
                //
                listKetChuyen: [],
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_doi_tac: [],
                ds_yeu_cau: '',
                ds_trang_thai: "",
                ds_truong_hoc: [],
                params: {},
                namHoc: "",
                total_rows: 0,
                start: 0,
                limit: 25,
                currentPage: 1,
                danhSachDonVi: [],
                danhSachCapHoc: [],
                maTruongHoc: "",
                danhSachLoaiYeuCau: [],
                danhSachTrangThai: [],
                danhSachTruongHoc: [],
                danhSachNamHoc: [],
                danhSachDoiTac: [],
                hocKy: 1,
                giaiDoanKqht: "",
                idBanGhi: "",
                show_info: false,
                trangbatdau: false,
                list_giai_doan: JSON.parse(localStorage["danh_sach_giai_doan_kqht_sme"]),
                messageId: "",
                formThemMoi: {
                    ten: '',
                    ma: '',
                    moTa: '',
                    trangThai: 1
                },
                show_them_moi: false,
                rules: {
                    ten: [
                        { required: true, message: 'Vui lòng nhập tên', trigger: 'blur' },
                    ],
                    ma: [
                        { required: true, message: 'Vui lòng nhập mã', trigger: 'blur' },
                    ],
                    moTa: [
                        { required: true, message: 'Vui lòng nhập mô tả', trigger: 'blur' },
                    ],
                    trangThai: [
                        { required: true, message: 'Vui lòng chọn trạng thái', trigger: 'change' },
                    ],
                },
            };
        },
        mounted() {
            console.log('3456789')
            this.updateWidth()
            this.thongtin = JSON.parse(window.userInfo);
            console.log(this.thongtin)
            console.log('Thông tin')
            this.ds_cap_hoc_custom[0].libs = this.list_cap_hoc;
            this.checkQuyenDayDL();
            this.namHocHienTai = this.thongtin.namHocHienTai;
            this.findNamHoc();
            if (this.thongtin.role == 5) {
                this.bindCapHocDangNhap();
                this.ds_cap_hoc = this.thongtin.listCapHoc;
                this.ds_truong_hoc = [this.thongtin.ma_truong_hoc.toUpperCase()]
            }
            if (this.thongtin.role > 3) {
                this.ds_don_vi = [this.thongtin.ma_don_vi]
            }

            this.getDonVi(() => {
                console.log("trang cũ nè:" + this.trangcu);
                console.log("trang cũ nè:" + this.trangcu.length);
                if (this.trangcu == "[]") {
                    console.log("trang cũ là 1 mảng");
                    // không tồn tại trang cũ
                    // this.getDanhSachLichSuChuyenDuLieu();
                } else {
                    console.log("trang cũ tồn tại");
                    this.thongTinTrangCu = this.trangcu;
                    console.log(this.thongTinTrangCu);
                    console.log("check:");
                    console.log("123456:" + JSON.stringify(this.thongTinTrangCu));
                    this.chuyenHuong(() => {
                        console.log("chuyeern huowngs xong");
                        console.log(JSON.stringify(this.thongTinTrangCu));
                    });
                }

            });
            this.getTruongHoc();
            this.getListDoiTac();
            this.getDanhSachLichSuChuyenDuLieu();

        },

        watch: {
            listKetChuyen(newData) {
                this.updateColumnWidths();
            },
            slectAll: function (newVal) {
                if (newVal) {
                    this.lsDelete = [];
                    for (let i = 0; i < this.listKetChuyen.length; i++) {
                        this
                            .lsDelete
                            .push(this.listKetChuyen[i].id);
                    }
                } else {
                    this.lsDelete = [];
                }
            },
            danhSachCapHoc: function (newVal) {

            },

            danhSachTruongHoc: function (newVal) {

                console.log("map trường xong:");
                console.log(JSON.stringify(this.ds_truong_hoc))
            },
            danhSachNamHoc: function (newVal) {
                console.log("watch Năm học");
                this.namHoc = "";
                this.params = {};
                if (newVal) {
                    this.namHoc = newVal
                        .id
                    console
                        .log("map xong:" + JSON.stringify(this.namHoc));
                }
            },

            danhSachDoiTac: function (newVal) {
                this.ds_doi_tac = [];
                this.params = {};
                if (newVal) {
                    let lsdt = newVal.map((obj) => {
                        return obj['maDoiTac']
                    });
                    this.ds_doi_tac = lsdt;
                }
                console.log("map xong đối tác:" + JSON.stringify(this.ds_doi_tac));
            },
            danhSachLoaiYeuCau: function (newVal) {
                console.log("watch loại yêu cầu:" + JSON.stringify(newVal));
                this.params = {};
                this.ds_yeu_cau = "";
                if (newVal) {
                    this.ds_yeu_cau = newVal.id
                }
                console.log("CHọn xong loại yêu cầu:" + this.ds_yeu_cau);
            },
            danhSachTrangThai: function (newVal) {
                console.log("watch đối tác");
                this.ds_trang_thai = "";
                this.params = {};
                if (newVal) {
                    this.ds_trang_thai = newVal.id
                }
                console.log("CHọn xong đối tác:" + this.ds_trang_thai);
            }
        },
        methods: {
            updateWidth() {
                this.windowWidth = window.innerWidth;
            },

            updateColumnWidths() {
                this.columnWidths = {
                    tenTruong: this.calculateColumnWidth(this.listKetChuyen, 'tenTruong'),
                    maTruong: this.calculateColumnWidth(this.listKetChuyen, 'maTruong'),
                    maDoiTac: 120,
                };
            },
            calculateColumnWidth(data, key) {
                // Tính toán độ rộng cột dựa trên dữ liệu
                let maxLength = Math.max(...data.map((row) => row[key]?.length || 0));
                return (maxLength * 10 || 100) + 20; // Ví dụ: 10px cho mỗi ký tự + padding
            },

            getBackGround(stt) {
                let result = 'white'
                if (stt == 0) {
                    result = '#C3F78B'
                }
                if (stt == 1) {
                    result = '#7DEBF3'
                }
                if (stt == 2) {
                    result = '#C9FFE5'
                }
                if (stt == 3) {
                    result = '#F8B28C'
                }
                if (stt == 4) {
                    result = '#9CCDF3'
                }
                if (stt == 5) {
                    result = '#F59078'
                }
                if (stt == 6) {
                    result = '#EBCB78'
                }
                if (stt == 7) {
                    result = '#ADDCFF'
                }
                if (stt == 9) {
                    result = '#FFDDAA'
                }
                if (stt == 10) {
                    result = '#ADDCFF'
                }
                if (stt == 11) {
                    result = '#48BC4D'
                }
                if (stt == 12) {
                    result = '#EC9F9F'
                }
                if (stt == 13) {
                    result = '#48BC4D'
                }
                return result;

                var res = loai;
                switch (loai) {
                    case 0:
                        res = 'bd-stt dlb-choDay'
                        break;
                    case 1:
                        res = 'bd-stt dlb-dangDay'
                        break;
                    case 2:
                        res = 'bd-stt dlb-dayThanhCong'
                        break;
                    case 3:
                        res = 'bd-stt dlb-dayLoi'
                        break;
                    case 4:
                        res = 'bd-stt dlb-canDayLai'
                        break;
                    case 5:
                        res = 'bd-stt dlb-thieuMatKhauKetChuyen'
                        break;
                    case 9:
                        res = 'bd-stt dlb-choTongHop'
                        break;
                    case 10:
                        res = 'bd-stt dlb-dangTongHop'
                        break;
                    case 11:
                        res = 'bd-stt dlb-tongHopXong'
                        break;
                    case 12:
                        res = 'bd-stt dlb-tongHopLoi'
                        break;
                    case 13:
                        res = 'bd-stt dlb-hoanThanh'
                        break;
                    case 6:
                        res = 'bd-stt dlb-taiKhoanKhongChinhXac'
                        break;
                    default:
                        res = "dlb-nothing";
                }
                return res;
            },
            getBuocHienTai(e) {
                for (let i = 0; i < this.list_yeu_cau_full.length; i++) {
                    if (this.list_yeu_cau_full[i].key == e) {
                        return this.list_yeu_cau_full[i].name;
                    }
                }
            },
            checkQuyenDayDL() {

                this.fullScreenLoading = true;
                rest_api.get("/csdlgd-admin/duyetDayDuLieu/checkDayDuLieu", {}, (data) => {

                    this.fullScreenLoading = false;
                    this.hienthibutton = data.data.item;
                });
            },
            xemChiTiet(e) {
                let params = {
                    messageId: e?.messageId??'',
                };
                this.fullScreenLoading = true;
                rest_api.get("/csdlgd-push/lichSuKetChuyenIoc/ask-result", params, response => {
                    this.fullScreenLoading = false;
                    if(response.data.code == 200) {
                        this.detailData = response.data.rows;
                        this.titleDialog = `Chi tiết: ${e.tenTruongHoc} - [${e.maTruongHoc}] - ${e.type}`;
                        this.showDetailModal = true;
                    } else {
                        this.$alertify.error(response.data.message || 'Có lỗi xảy ra khi lấy dữ liệu chi tiết');
                    }
                }, 60000, true);
            },
            checkTruocKhiTimKiem() {
                this.trangbatdau = !this.trangbatdau;
            },
            ChonTruongHoc() {
                console.log("Chọn trường học");
                this.ds_truong_hoc = [];
                this.params = {};
                if (this.danhSachTruongHoc) {
                    let lsth = this.danhSachTruongHoc.map((obj) => {
                        return obj['maTruongHoc']
                    });
                    this.ds_truong_hoc = lsth;
                }
                console.log("Chọn xong trường:" + this.ds_truong_hoc)
            },
            ChonCapHoc() {
                // this.thongTinTrangCu = [];
                // console.log("Chọn cấp hocj cấp học");
                // this.ds_cap_hoc = [];
                // this.params = {};
                // this.ds_truong_hoc = [];
                // this.danhSachTruongHoc = [];
                // if (this.danhSachCapHoc) {
                //     let lsch = this.danhSachCapHoc.map((obj) => {
                //         return obj['id']
                //     });
                //     this.ds_cap_hoc = lsch;
                // }
                if(this.ds_cap_hoc){
                this.getTruongHoc();
                }
            },
            ChonDonVi() {
                console.log("mới chọn đơn vị xong");
                this.ds_don_vi = [];
                this.params = {};
                this.ds_truong_hoc = [];
                this.thongTinTrangCu = [];
                this.danhSachTruongHoc = [];
                if (this.danhSachDonVi) {
                    let lsdv = this.danhSachDonVi.map((obj) => {
                        return obj['maDonVi']
                    });
                    this.ds_don_vi = lsdv;
                }
                console.log('xong:' + this.ds_don_vi)
                this.getTruongHoc();

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
            // tìm cấp học

            getCapHoc(loai) {
                var res = loai;
                switch (loai) {
                    case 1:
                        res = 'Cấp 1'
                        break;
                    case 2:
                        res = 'Cấp 2'
                        break;
                    case 3:
                        res = 'Cấp 3'
                        break;
                    case 4:
                        res = 'Nhà trẻ'
                        break;
                    case 5:
                        res = 'Mẫu giáo'
                        break;
                    case 6:
                        res = 'GDTX'
                        break;
                    case 12:
                        res = 'Liên cấp 1+2'
                    case 13:
                        res = 'Liên cấp 1+3'
                    case 23:
                        res = 'Liên cấp 2+3'
                        break;
                    case 123:
                        res = 'Liên cấp 1+2+3'
                    default:
                        res = loai;
                }
                return res;
            },
            // gán năm học

            findNamHoc() {
                console.log("năm học hiện tại a:" + this.namHocHienTai);
                for (let i = 0; i < this.list_nam_hoc.length; i++) {
                    console.log("năm" + JSON.stringify(this.list_nam_hoc[i]));
                    if (this.list_nam_hoc[i].id == this.namHocHienTai) {
                        this.danhSachNamHoc = this.list_nam_hoc[i];
                    }
                }
            },
            // bind dữ liệu khi chuyển hướng
            chuyenHuong(ch = () => {}) {
                window
                    .history
                    .replaceState("", "CSDL Ngành", "moet-transfer-history");
                this.thongTinTrangCu = JSON.parse(this.thongTinTrangCu)
                // alert(this.thongTinTrangCu); return
                console.log("trang cũ nè:" + JSON.stringify(this.thongTinTrangCu));
                if (this.thongTinTrangCu.namHoc) {
                    // Nếu có năm học
                    for (let i = 0; i < this.list_nam_hoc.length; i++) {
                        if (this.list_nam_hoc[i].id == this.thongTinTrangCu.namHoc) {
                            this.danhSachNamHoc = this.list_nam_hoc[i];
                            console.log("Năm học: " + JSON.stringify(this.danhSachNamHoc));
                        }
                    }
                }
                if (this.thongTinTrangCu.maTruongHoc) {
                    this.getTruongHoc(() => {
                        for (let i = 0; i < this.list_truong_hoc.length; i++) {
                            if (this.list_truong_hoc[i].maTruongHoc == this.thongTinTrangCu.maTruongHoc) {
                                this.danhSachTruongHoc = [this.list_truong_hoc[i]];
                                this.ds_truong_hoc = this
                                    .danhSachTruongHoc
                                    .map((obj) => obj.maTruongHoc);
                                ch();
                            }
                        }

                        this.getDanhSachLichSuChuyenDuLieu();
                    })
                    console.log("lấy trường chuyển hướng");
                }

                // this.getDanhSachLichSuChuyenDuLieu(); if (this.chuyenhuong.dotDay) {
                // this.idDay = this.chuyenhuong.dotDay; console.log("đợt đẩy" + this.idDay) }
                // setTimeout(() => { }, 200);
            },
            // xuất excel

            XuatExcel() {

                let url = "xuat-excel-lich-su-day-du-lieu-len-bo";

                let params = {
                    hocKy: parseInt(this.hocKy),
                    maGiaiDoanKqht: this.giaiDoanKqht,
                    maTruongHoc: this.maTruongHoc,
                    namHoc: this.namHoc,
                    trangThai: this.ds_trang_thai,
                    loaiYeuCau: this.ds_yeu_cau,
                    maDonVis: this.ds_don_vi,
                    maCapHocs: this.ds_cap_hoc,
                    maTruongs: this.ds_truong_hoc,
                    maDoiTacs: this.ds_doi_tac
                };
                this.params = params;
                if (this.thongtin.role == 4) {
                    params.maDonVi = this.thongtin.ma_don_vi;
                };
                if (this.thongtin.role == 5) {
                    params.maTruongHoc = this.thongtin.ma_truong_hoc;
                };
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.thongBao('success', 'Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
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
                    })
                    .catch(_ => {});
                // utils.confirmDialog(
                //     "Xác nhận tải xuống dữ liệu. Vui lòng chờ trong thời gian tải xuống",
                //     "Đống ý",
                //     () => {

                //     }
                // )
            },
            // hiển thị thông tin

            showInfo(e) {
                console.log("xem thông tin:" + JSON.stringify(e));
                this.idBanGhi = e;
                this.show_info = true;
            },

            layLai(e) {
                // console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.lsDelete = [];
                this.selectAll = false;
                this.currentPage = e.currentPage;
                this.getDanhSachLichSuChuyenDuLieu();
            },
            dayLai() {
                if (this.lsDelete.length > 0) {
                    this.$confirm('Xác nhận đẩy lại thông tin đã chọn?', 'Thông báo', {
                            confirmButtonText: 'Đẩy',
                            cancelButtonText: 'Hủy',
                            closeOnClickModal: false,
                        })
                        .then(_ => {
                            console.log("Đồng ý xóa danh sách học sinh:");
                            console.log(this.lsDelete);
                            let params = {
                                listId: this.lsDelete,
                            };
                            this.fullScreenLoading = true;
                            rest_api.post("/csdlgd-admin/dayLenBo/updateDayLai", params, data => {
                                if (data.data.rc == 0) {
                                    this.thongBao('success',
                                        'Yêu cầu đẩy dữ liệu đang ở trạng thái chờ tổng hợp dữ liệu.')
                                    this.trangbatdau = !this.trangbatdau;
                                    this.lsDelete = [];
                                    this.slectAll = false;
                                } else {
                                    this
                                        .$alertify
                                        .error(data.data.rd)
                                }
                                this.fullScreenLoading = false;
                            });
                        })
                        .catch(_ => {});
                    // utils.confirmDialog(
                    //     "Xác nhận đẩy lại thông tin đã chọn?",
                    //     "Đồng ý",
                    //     () => {}
                    // );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn ít nhất 1 bản ghi.")
                }
            },
            // lấy tên trạng thái đẩy\
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
            getClass(loai) {

                var res = loai;
                switch (loai) {
                    case 0:
                        res = 'bd-stt dlb-choDay'
                        break;
                    case 1:
                        res = 'bd-stt dlb-dangDay'
                        break;
                    case 2:
                        res = 'bd-stt dlb-dayThanhCong'
                        break;
                    case 3:
                        res = 'bd-stt dlb-dayLoi'
                        break;
                    case 4:
                        res = 'bd-stt dlb-canDayLai'
                        break;
                    case 5:
                        res = 'bd-stt dlb-thieuMatKhauKetChuyen'
                        break;
                    case 9:
                        res = 'bd-stt dlb-choTongHop'
                        break;
                    case 10:
                        res = 'bd-stt dlb-dangTongHop'
                        break;
                    case 11:
                        res = 'bd-stt dlb-tongHopXong'
                        break;
                    case 12:
                        res = 'bd-stt dlb-tongHopLoi'
                        break;
                    case 13:
                        res = 'bd-stt dlb-hoanThanh'
                        break;
                    case 6:
                        res = 'bd-stt dlb-taiKhoanKhongChinhXac'
                        break;
                    default:
                        res = "dlb-nothing";
                }
                return res;
            },
            getTrangThaiDay(loai) {
                var res = loai;
                switch (loai) {
                    case 0:
                        res = 'Chờ đẩy'
                        break;
                    case 1:
                        res = 'Đang đẩy'
                        break;
                    case 2:
                        res = 'Đẩy thành công'
                        break;
                    case 3:
                        res = 'Đẩy lỗi'
                        break;
                    case 4:
                        res = 'Cần đẩy lại'
                        break;
                    case 5:
                        res = 'Thiếu mật khẩu kết chuyển'
                        break;
                    case 9:
                        res = 'Chờ tổng hợp'
                        break;
                    case 10:
                        res = 'Đang tổng hợp'
                        break;
                    case 11:
                        res = 'Tổng hợp xong'
                        break;
                    case 12:
                        res = 'Tổng hợp lỗi'
                        break;
                    case 13:
                        res = 'Hoàn thành'
                        break;
                    case 6:
                        res = 'Tài khoản kết chuyển không chính xác'
                        break;
                    case 7:
                        res = 'Content chưa đúng'
                        break;
                    default:
                        res = "Chưa rõ";
                }
                return res;

            },
            // check trước khi lấy dữ liệu
            getDanhSachLichSuChuyenDuLieu() {
                let params = {
                    start: this.start,
                    limit: this.limit,
                    hocKy: parseInt(this.hocKy),
                    maGiaiDoanKqht: this.giaiDoanKqht,
                    // maTruongHoc: this.maTruongHoc,
                    namHoc: this.namHoc,
                    trangThai: this.ds_trang_thai,
                    loaiYeuCau: this.ds_yeu_cau,
                    idPhongList: this.ds_don_vi,
                    maCapHocs: this.ds_cap_hoc,
                    maTruongList: this.ds_truong_hoc,
                    messageId: this.messageId || ''
                };
                console.log("params lúc đầu:" + JSON.stringify(params));
                this.params = params;
                if (this.thongtin.role == 4) {
                    params.idPhongList = [this.thongtin.ma_don_vi];
                };
                if (this.thongtin.role == 5) {
                    params.maTruongList = [this.thongtin.ma_truong_hoc];
                };
                console.log(JSON.stringify(params));
                this.fullScreenLoading = true;

                rest_api.post("/csdlgd-push/lichSuKetChuyenIoc/search", params, data => {
                    this.fullScreenLoading = false;
                    if (data.data.statusResponse == 0) {
                        this.listKetChuyen = data.data.rows;
                        this.updateColumnWidths()
                        if (data.data.rows == null) {
                            this.listKetChuyen = [];
                        }
                        this.total_rows = data.data.total;
                    } else {
                        this.thongBao('error', data.data.message || 'Có lỗi xảy ra khi lấy dữ liệu');
                        return;
                    }
                }, 60000, true);
                return;
            },
            // Lấy danh sách trường học Lấy trường học
            getTruongHoc(gt = () => {}) {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc
                };
                if (this.thongTinTrangCu.maTruongHoc) {
                    params.maTruong = this.thongTinTrangCu.maTruongHoc;
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    console.error('1234567890')
                    console.log("lấy trường");
                    if (data.data.code == 200) {
                        let data_arr = data.data.rows;
                        let tmp = [];
                        for (let i = 0; i < data_arr.length; i++) {
                            let obj = {
                                name: data_arr[i].tenTruongHoc + ' - [' + data_arr[i].maTruongHoc + ']',
                                value: data_arr[i].maTruongHoc
                            }
                            tmp.push(obj)
                        }
                        this.list_truong_hoc = tmp;
                        gt();
                    }
                });
            },
            // Lấy danh sách đối tác

            getListDoiTac() {
                let params = {
                    start: 0,
                    limit: 99999,
                    trangThai: 1
                };
                this.fullScreenLoading = true;
                rest_api.get("/internal-api/heThongDoiTac/filter", params, data => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_doi_tac);
                        this.list_doi_tac = data.data.rows;
                    }
                    this.fullScreenLoading = false
                });
            },

            // Lấy danh sách đơn vị
            getDonVi(ck = () => {}) {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                console.log("pr ẻty" + JSON.stringify(params));
                this.fullScreenLoading = true;
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    this.fullScreenLoading = false;
                    console.log("lấy đơn vị thành công" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        let data_arr = data.data.rows;
                        let tmp = [];
                        for (let i = 0; i < data_arr.length; i++) {
                            let obj = {
                                name: data_arr[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data_arr[i].maDonVi + ']',
                                value: data_arr[i].maDonVi
                            }
                            tmp.push(obj)
                        }
                        this.list_don_vi = tmp;
                        if (this.thongtin.role == 5 || this.thongtin.role == 4) {
                            for (let i = 0; i < this.list_don_vi.length; i++) {
                                if (this.list_don_vi[i].maDonVi == this.thongtin.ma_don_vi) {
                                    this.tenDonViDangNhap = this.list_don_vi[i].tenDonVi;
                                }
                            }
                        }
                        ck();
                    }
                });
            },

            // set name định nghĩa cho đơn vị
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
            setNameByIdValue({
                name
            }) {
                return `${name}`
            }, // định nghĩa cho trạng thái
            setNameDanhSachDongBo({
                name
            }) {
                return `${name}`
            },
            showThemMoi() {
                this.typeUpdate = "Xác nhận thêm mới?"
                this.type = 1;
                // Reset form data first
                this.dataAddOrUpdate = {
                    maSoAdd: '',
                    tenQuanHuyenAdd: '',
                    maQuanHuyenAdd: '',
                    tenPhuongXaAdd: '',
                    maPhuongXaAdd: '',
                    soLuongToAdd: 0
                };
                // Reset form validation
                if (this.$refs.ruleForm) {
                    this.$refs.ruleForm.resetFields();
                }
                // Set default values based on role
                if (this.thongtin.role > 1) {
                    this.dataAddOrUpdate.maSoAdd = this.thongtin.ma_so;
                }
                // Show modal after resetting
                this.show_add_or_update = true;
            },
            resetFormThemMoi() {
                this.formThemMoi = {
                    ten: '',
                    ma: '',
                    moTa: '',
                    trangThai: 1
                };
                if (this.$refs.formThemMoi) {
                    this.$refs.formThemMoi.resetFields();
                }
            },
            themMoi() {
                // Implement the logic to add new data
                console.log("Thêm mới:", this.formThemMoi);
                this.show_add_or_update = false;
            },
        }
    };

</script>
<style scoped="scoped">
    .timkiem {
        padding-top: 15px;
    }

    .row_tp {
        margin-top: 0;
    }

    .cg {
        vertical-align: middle;
    }

</style>

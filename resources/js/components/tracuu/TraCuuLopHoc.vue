<template>
    <div>
        <!-- Bắt đầu template -->
        <!-- Header -->
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Tra cứu <span class="kytu">
                        &raquo;</span> Tra cứu lớp học</span>
            </div>
        </div>
        <!-- Kết thúc header -->
        <!-- bắt đầu fillter -->
        <div>
            <div class="row">
                <div class="col-md-4 timkiem">
                    <label class="typo__label">Chọn đơn vị</label>
                    <div v-if="thongtin.role<4">

                        <eselect style="width:100%" multiple collapseTags v-model="ds_don_vi" @change="ChonDonVi"
                                 :placeholder="'Chọn'" filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                    </div>
                    <div v-if="thongtin.role==5||thongtin.role==4">
                        <input disabled v-model="tenDonViDangNhap" class="form-control" placeholder="Chọn" />
                    </div>
                </div>
                <div class="col-md-2 timkiem">
                    <div>
                        <label class="typo__label">Chọn cấp học</label>
                        <div v-if="thongtin.role!=5">

                            <eselect style="width:100%" multiple collapseTags v-model="ds_cap_hoc" @change="ChonCapHoc"
                                     :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                        </div>
                        <div v-if="thongtin.role==5">
                            <input :disabled="thongtin.role == 5" class="form-control" placeholder="Cấp học"
                                :value="capHocDangNhap" />
                        </div>
                    </div>
                </div>
                <!-- Khối học -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Khối học </label>
                    <eselect style="width:100%" multiple collapseTags v-model="ds_khoi_hoc" @change="chonKhoiHoc"
                             :placeholder="'Chọn'" filterable :data="list_khoi_hoc" :fields="['name','id']" />
                </div>
                <!-- Hết khối học -->
                <!-- Trường học -->
                <div class="col-md-4 timkiem">
                    <div v-if="thongtin.role!=5">
                        <label class="typo__label">Chọn trường học </label>
                        <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags v-model="ds_truong_hoc" :placeholder="'Chọn'"
                                 filterable :data="list_truong_hoc" :fields="['tenTruongHoc','maTruongHoc']" />
                    </div>
                    <div v-if="thongtin.role==5">
                        <label>Trường học</label>
                        <input :disabled="thongtin.role == 5" :value="thongtin.display_name" class="form-control"
                            placeholder="Nhập..." />
                    </div>
                </div>
                <!-- Hết trường học -->
            </div>
            <div class="row">
                <!-- Tên lớp học -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Tên lớp học</label>
                    <input v-model="ClassName"   v-on:keyup.enter="getListClass" type="text" placeholder="Nhập..." class="form-control" />
                </div>
                <!-- Hết tên lớp học -->
                <!-- Tên GVCN học -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Tên GVCN</label>
                    <input v-model="TeacherName" v-on:keyup.enter="getListClass" type="text" placeholder="Nhập..." class="form-control" />
                </div>
                <!-- Hết tên GVCN -->
                <!-- Mã lớp mầm non -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Nhóm trẻ mầm non </label>

                    <eselect style="width:100%"  collapseTags v-model="maLopMamNon"
                             :placeholder="'Chọn'" filterable :disabled="!coLopMamNon" :data="list_ma_lop_mm_non" :fields="['name','value']" />
                </div>
                <!-- Hết mã lớp mầm non -->
                <!-- Năm học -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Năm học</label>
                    <multiselect v-model="danhSachNamHoc" :options="list_nam_hoc" :custom-label="setNameNamHoc"
                        placeholder="Chọn" label="name" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                        selectedLabel="Đã chọn" track-by="name"></multiselect>
                </div>
                <!-- Hết năm học -->
                <div class="col-md-4">
                    <label class="typo__label">Tìm kiếm nâng cao <span style="color:#DC0101">*</span></label>
                    <el-select v-model="danhSachTimKiemNangCao" multiple filterable collapse-tags
                        placeholder="Chọn nội dung tìm kiếm nâng cao" no-data-text="Không có dữ liệu"
                        no-match-text="Không có dữ liệu phù hợp">
                        <el-option v-for="item in list_tim_kiem_nang_cao" :key="item.value" :label="item.name"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="row">
                <!-- Tùy chọn hiển thị -->
                <div class="col-md-4 timkiem">
                    <label class="typo__label">Nội dung hiển thị <span style="color:#DC0101">*</span></label>
                    <div>
                        <multiselect v-model="danhSachTimKiem" :options="ds_tim_kiem_tra_cuu_lop_hoc"
                            group-values="libs" group-label="selectAll" :group-select="true"
                            selectGroupLabel="Ấn để chọn tất cả" deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1"
                            :limit-text="limitTextTieuChi" :close-on-select="false" :multiple="true"
                            :clear-on-select="false" :preserve-search="false" deselectLabel="Đã chọn"
                            selectLabel="Chưa chọn" selectedLabel="Đã chọn" :custom-label="setNameNamHoc"
                            placeholder="Chọn" track-by="name">
                            <template v-if="danhSachDonVi.length>0" slot="selection"
                                slot-scope="{ values, search, isOpen }">
                                <span class="multiselect__single"
                                    v-if="values.length &amp;&amp; !isOpen">{{ danhSachTimKiem.length }}
                                    tiêu chí được chọn</span>
                            </template>
                            <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                            <span slot="noOptions">Danh sách trống</span>
                        </multiselect>
                    </div>
                </div>
                <!-- Hết tùy chọn hiển thị -->
            </div>
            <div class="row">
                <!-- Tìm kiếm nâng cao -->
                <div class="col-md-2" v-if="hienThiNangCao.lopChuyen">
                    <label>Lớp chuyên</label>
                    <select v-model="nangCao.lopChuyen" class="form-control">
                        <option value="">Chọn</option>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.lopBanTru">
                    <label>Lớp bán trú</label>
                    <select v-model="nangCao.lopBanTru" class="form-control">
                        <option value="">Chọn</option>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.coHocSinhHocNghe">
                    <label>Lớp có học sinh học nghề</label>
                    <select v-model="nangCao.coHocSinhHocNghe" class="form-control">
                        <option value="">Chọn</option>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.lopGhep">
                    <label>Lớp ghép</label>
                    <select v-model="nangCao.lopGhep" class="form-control">
                        <option value="">Chọn</option>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.maLopGhep">
                    <label>Mã lớp ghép</label>
                    <input class="form-control" type="text" v-model="nangCao.maLopGhep" placeholder="Nhập...">
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.lopVnen">
                    <label>Lớp VNEN</label>
                    <select v-model="nangCao.lopVnen" class="form-control">
                        <option value="">Chọn</option>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.lopCoTreKhuyetTat">
                    <label>Lớp có trẻ khuyết tật</label>
                    <select v-model="nangCao.lopCoTreKhuyetTat" class="form-control">
                        <option value="">Chọn</option>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.lopChuyenBiet">
                    <label>Lớp chuyên biệt</label>
                    <select v-model="nangCao.lopChuyenBiet" class="form-control">
                        <option value="">Chọn</option>
                        <option value="1">Có</option>
                        <option value="0">Không</option>
                    </select>
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.soBuoiTrenTuan">
                    <label>Số buổi học/tuần</label>
                    <input class="form-control" type="text" v-model="nangCao.soBuoiTrenTuan"
                        placeholder="Nhập...">
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.moetCode">
                    <label>Mã định danh</label>
                    <input class="form-control" type="text" v-model="nangCao.moetCode" placeholder="Nhập...">
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.maNn1">
                    <label>Ngoại ngữ 1</label>
                    <el-select v-model="nangCao.maNn1" filterable collapse-tags placeholder="Chọn"
                        no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                        <el-option v-for="item in list_mon_ngoai_ngu" :key="item.value" :label="item.name"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-2" v-if="hienThiNangCao.maNn2">
                    <label>Ngoại ngữ 2</label>
                    <el-select v-model="nangCao.maNn2" filterable collapse-tags placeholder="Chọn"
                        no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                        <el-option v-for="item in list_mon_ngoai_ngu" :key="item.value" :label="item.name"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <!-- Khu vực -->
            </div>
            <!-- Hết tìm kiếm nâng cao -->
        </div>
        
        <!-- hết filter -->
        <!-- buttom -->
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-success" @click.prevent="checkTruocKhiTim()">Tìm kiếm</button>
                <button class="btn btn-info" :disabled="list_lop_hoc.length==0" @click.prevent="CheckXuatExcel()">Xuất
                    Excel</button>
            </div>
        </div>
        <!-- hết button -->
        
        <!-- Bắt đầu danh sách lớp học-->
        <div class="row">
            <!-- Button -->
            <div class="col-md-12">
                <div class="pull-right">
                    <button class="btn btn-danger" v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==20" @click.prevent="DeleteClass"
                        style="margin:2px 0; float:right">Xóa</button>
                    <button class="btn btn-danger" v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==20" @click.prevent="DeleteMoetCode"
                        style="margin:2px 4px; float:right">Xóa mã định danh</button>
                </div>
            </div>
            <!-- Hết button -->
            <!-- Danh sách chi tiết -->
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr style="background:#e4ebf5">
                            <tr style="background: #e4ebf5; font-size:12px;">
                                <th class="cg">
                                    <p>STT</p>
                                </th>
                                <th class="cg" v-for="(item,i) in cotHienThi" :key="i">
                                    <p>{{item.name}}</p>
                                </th>
                                <th class="cg">
                                    <p>Sửa</p>
                                </th>
                                <th class="cg">
                                    <input type="checkbox" v-model="slectAll" />
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="list_lop_hoc.length==0">
                            <tr>
                                <td :colspan="danhSachTimKiem.length+3" class="cg">
                                    <p>Không có bản ghi nào</p>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="(lh,i) in list_lop_hoc" :key="i">
                                <td class="text-center">
                                    <p>{{(currentPage-1)*limit + i+1}}</p>
                                </td>
                                <td v-if="hangHienThi.maTruongHoc">
                                    <p>{{lh.maTruongHoc}}</p>
                                </td>
                                <td v-if="hangHienThi.tenTruongHoc">
                                    <p>{{lh.tenTruongHoc}}</p>
                                </td>
                                <td v-if="hangHienThi.maLopHoc">
                                    <a href="#" @click.prevent="showInFo(lh.maLopHoc)">{{lh.maLopHoc}}</a>
                                </td>
                                <td v-if="hangHienThi.moetCode">
                                    <p>{{lh.moetCode}}</p>
                                </td>
                                <td v-if="hangHienThi.tenLopHoc">
                                    <a href="#" @click.prevent="showInFo(lh.maLopHoc)">{{lh.tenLopHoc}}</a>
                                </td>
                                <td v-if="hangHienThi.khoiHoc">
                                    <p>{{lh.khoiHoc}}</p>
                                </td>
                                <td v-if="hangHienThi.tenGiaoVienCn">
                                    <p>{{lh.tenGiaoVienCn}}</p>
                                </td>
                                <td v-if="hangHienThi.buoiHoc">
                                    <p>{{lh.buoiHoc}}</p>
                                </td>
                                <td v-if="hangHienThi.maNn1">
                                    <p>{{lh.maNn1}}</p>
                                </td>
                                <td v-if="hangHienThi.maNn2">
                                    <p>{{lh.maNn2}}</p>
                                </td>
                                <!-- <td v-if="hangHienThi.HeChuyen">
                                    <p>{{lh.HeChuyen}}</p>
                                </td> -->
                                <td v-if="hangHienThi.phanBan">
                                    <p>{{getTenPhanBan(lh.phanBan)}}</p>
                                </td>
                                <td v-if="hangHienThi.lopChuyen">
                                    <p>{{lh.lopChuyen}}</p>
                                </td>
                                <td v-if="hangHienThi.coHocSinhHocNghe">
                                    <p>{{lh.coHocSinhHocNghe}}</p>
                                </td>
                                <td v-if="hangHienThi.lopGhep">
                                    <p>{{lh.lopGhep}}</p>
                                </td>
                                <td v-if="hangHienThi.maLopGhep">
                                    <p>{{lh.maLopGhep}}</p>
                                </td>
                                <td v-if="hangHienThi.lopBanTru">
                                    <p>{{lh.lopBanTru}}</p>
                                </td>
                                <td v-if="hangHienThi.soBuoiTrenTuan">
                                    <p v-if="lh.soBuoiTrenTuan" class="text-center">{{lh.soBuoiTrenTuan}} buổi/tuần</p>
                                </td>
                                <td v-if="hangHienThi.maDiemTruong">
                                    <p>{{lh.maDiemTruong}}</p>
                                </td>
                                <!-- Hết nội dung hiển thị mặc định -->
<!--
                                <td v-if="hangHienThi.lopVnen">
                                    <p>{{lh.lopVnen}}</p>
                                </td>
                                <td v-if="hangHienThi.lopCoTreKhuyetTat">
                                    <p>{{lh.lopCoTreKhuyetTat}}</p>
                                </td>
                                <td v-if="hangHienThi.lopChuyenBiet">
                                    <p>{{lh.lopChuyenBiet}}</p>
                                </td> -->
                                <td class="text-center">
                                    <a title="Chỉnh sửa" href="#" v-on:click.prevent="ShowUpdate(lh.maLopHoc)"><i
                                            class="far fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" v-model="lsDelete" :value="lh.maLopHoc" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Phân trang -->
                <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                <!-- Hết phân trang -->
                <!-- Thông tin lớp học -->
                <!-- Hết thông tin lớp học -->
            </div>
            <!-- <div v-if="show_update"> -->
            <update-lophoc :show="show_update" :item="dataUpdate" @close="show_update=false"
                @success="dongSuaHs($event)">
            </update-lophoc>
            <!-- </div> -->
            <!-- <div v-if="showThongTinLopHoc"> -->
            <thongtin-lophoc :show="showThongTinLopHoc" :item="dataLopHoc" @close="showThongTinLopHoc=false">
            </thongtin-lophoc>
            <!-- </div> -->
            <!-- Hết danh sách chi tiết -->
        </div>
        <!-- Hết danh sách lớp học -->
        <!-- Kết thúc template -->
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import constant from '../../utils/constant';
    import ChinhSua from './LopHoc/ChinhSua'
    import ThongTin from './LopHoc/ThongTin'
    import moment from "moment";
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import api from '../api';
    import Page from "../ui/PagingCustom";
    import ESelectVue from '../ui/ESelect.vue';
    import dialog from '../../utils/dialog';
    import VueAlertify from "vue-alertify";
    import utils from '../../utils';
    import ElementUI from 'element-ui';
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
        components: {
            Multiselect,
            Page: Page,
            'thongtin-lophoc': ThongTin,
            'eselect': ESelectVue,
            'update-lophoc': ChinhSua
        },
        props: ['trangcu'],
        data() {
            return {
                trangbatdau: true,
                show_update: false,
                dataUpdate: "",
                danhSachTimKiemNangCao: [],
                hienThiNangCao: {
                    lopChuyen: false,
                    lopBanTru: false,
                    coHocSinhHocNghe: false,
                    lopGhep: false,
                    maLopGhep: false,
                    lopVnen: false,
                    lopCoTreKhuyetTat: false,
                    lopChuyenBiet: false,
                    soBuoiTrenTuan: false,
                },
                list_tim_kiem_nang_cao: [{
                        value: 'lopChuyen',
                        name: "Lớp chuyên"
                    },
                    {
                        value: 'lopBanTru',
                        name: "Lớp bán trú"
                    },
                    {
                        value: 'coHocSinhHocNghe',
                        name: "Có học sinh học nghề"
                    },
                    {
                        value: 'lopGhep',
                        name: "Lớp ghép"
                    },
                    {
                        value: 'maLopGhep',
                        name: "Mã lớp ghép"
                    },
                    {
                        value: 'lopVnen',
                        name: "Lớp VNEN"
                    },
                    {
                        value: 'lopCoTreKhuyetTat',
                        name: "Lớp có trẻ khuyết tật"
                    },
                    {
                        value: 'lopChuyenBiet',
                        name: "Lớp chuyên biệt"
                    },
                    {
                        value: 'soBuoiTrenTuan',
                        name: "Số buổi học trên tuần"
                    },
                    {
                        value: 'moetCode',
                        name: "Mã định danh"
                    },
                    {
                        value: 'maNn1',
                        name: "Ngoại ngữ 1"
                    },
                    {
                        value: 'maNn2',
                        name: "Ngoại ngữ 2"
                    },
                ],
                nangCao: {
                    lopChuyen: '',
                    lopBanTru: '',
                    coHocSinhHocNghe: '',
                    lopGhep: '',
                    maLopGhep: '',
                    lopVnen: '',
                    lopCoTreKhuyetTat: '',
                    lopChuyenBiet: '',
                    soBuoiTrenTuan: '',
                    moetCode: '',
                    maNn1: '',
                    maNn2: '',
                },
                timKiemNangCao: true,
                cotHienThi: [],
                hangHienThi: {},
                //chọn tất cả
                list_ma_lop_mm_non: [],
                maLopMamNon: "",
                coLopMamNon: false,
                tenDonViDangNhap: "",
                capHocDangNhap: "",
                chuyenhuong: {},
                thongtin: JSON.parse(window.userInfo),
                list_phan_ban: [],
                date: new Date(),
                slectAll: false,
                lsDelete: [],
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                // thông tin
                showThongTinLopHoc: false,
                dataLopHoc: {},
                // phần dùng trong filter
                list_cap_mot: constant.khoiCapMot,
                list_cap_hai: constant.khoiCapHai,
                list_cap_ba: constant.khoiCapBa,
                list_mam_non: constant.khoiMamNon,
                list_nha_tre: constant.khoiNhaTre,
                lop_nha_tre: constant.lopNhaTre,
                lop_mau_giao: constant.lopMauGiao,
                ClassName: "",
                TeacherName: "",
                danhSachDonVi: [],
                list_don_vi: [],
                danhSachNamHoc: [],
                list_nam_hoc: [],
                danhSachTruongHoc: [],
                list_truong_hoc: [],
                danhSachCapHoc: [],
                danhSachTimKiem: [],
                danhSachTimKiemTruong: [{
                        key: 'maLopHoc',
                        name: "Mã lớp",
                        stt: 3
                    },
                    {
                        key: 'moetCode',
                        name: "Mã định danh",
                        stt: 4
                    },
                    {
                        key: 'tenLopHoc',
                        name: "Tên lớp học",
                        stt: 5
                    },
                    {
                        key: 'khoiHoc',
                        name: "Khối học/Nhóm lớp",
                        stt: 6
                    },
                    {
                        key: 'tenGiaoVienCn',
                        name: "Giáo viên chủ nhiệm",
                        stt: 7
                    },
                    {
                        key: 'buoiHoc',
                        name: "Buổi học",
                        stt: 8
                    },
                    {
                        key: 'maNn1',
                        name: "Học ngoại ngữ 1",
                        stt: 9
                    },
                    {
                        key: 'maNn2',
                        name: "Học ngoại ngữ 2",
                        stt: 10
                    },
                    // {
                    //     key: 'heChuyen',
                    //     name: "Hệ chuyên",
                    //     stt: 11
                    // },
                    {
                        key: 'phanBan',
                        name: "Phân ban",
                        stt: 12
                    },
                    {
                        key: 'lopChuyen',
                        name: "Lớp chuyên",
                        stt: 13
                    },
                    {
                        key: 'coHocSinhHocNghe',
                        name: "Học sinh học nghề",
                        stt: 14
                    },
                    {
                        key: 'lopGhep',
                        name: "Lớp ghép",
                        stt: 15
                    },
                    {
                        key: 'maLopGhep',
                        name: "Ghép vào lớp",
                        stt: 16
                    },
                    {
                        key: 'lopBanTru',
                        name: "Lớp bán trú",
                        stt: 17
                    },
                    {
                        key: 'soBuoiTrenTuan',
                        name: "Số buổi học trên tuần",
                        stt: 18
                    },
                    // {
                    //     key: 'maDiemTruong',
                    //     name: "Điểm trường",
                    //     stt: 19
                    // },
                ],
                danhSachTimKiemSo: [{
                        key: 'maTruongHoc',
                        name: "Mã trường",
                        stt: 1
                    },
                    {
                        key: 'tenTruongHoc',
                        name: "Tên trường",
                        stt: 2
                    },
                    {
                        key: 'maLopHoc',
                        name: "Mã lớp",
                        stt: 3
                    },
                    {
                        key: 'moetCode',
                        name: "Mã định danh",
                        stt: 4
                    },
                    {
                        key: 'tenLopHoc',
                        name: "Tên lớp học",
                        stt: 5
                    },
                    {
                        key: 'khoiHoc',
                        name: "Khối học/Nhóm lớp",
                        stt: 6
                    },
                    {
                        key: 'tenGiaoVienCn',
                        name: "Giáo viên chủ nhiệm",
                        stt: 7
                    },
                    {
                        key: 'buoiHoc',
                        name: "Buổi học",
                        stt: 8
                    },
                    {
                        key: 'maNn1',
                        name: "Học ngoại ngữ 1",
                        stt: 9
                    },
                    {
                        key: 'maNn2',
                        name: "Học ngoại ngữ 2",
                        stt: 10
                    },
                    // {
                    //     key: 'heChuyen',
                    //     name: "Hệ chuyên",
                    //     stt: 11
                    // },
                    {
                        key: 'phanBan',
                        name: "Phân ban",
                        stt: 12
                    },
                    {
                        key: 'lopChuyen',
                        name: "Lớp chuyên",
                        stt: 13
                    },
                    {
                        key: 'coHocSinhHocNghe',
                        name: "Học sinh học nghề",
                        stt: 14
                    },
                    {
                        key: 'lopGhep',
                        name: "Lớp ghép",
                        stt: 15
                    },
                    {
                        key: 'maLopGhep',
                        name: "Ghép vào lớp",
                        stt: 16
                    },
                    {
                        key: 'lopBanTru',
                        name: "Lớp bán trú",
                        stt: 17
                    },
                    {
                        key: 'soBuoiTrenTuan',
                        name: "Số buổi học trên tuần",
                        stt: 18
                    },
                    // {
                    //     key: 'maDiemTruong',
                    //     name: "Điểm trường",
                    //     stt: 19
                    // },
                ],
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_khoi_hoc: [],
                ds_truong_hoc: [],
                list_lop_hoc: [],
                list_cap_hoc: window.listCapHoc,
                list_khoi_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                ds_tim_kiem_tra_cuu_lop_hoc: [{
                    selectAll: 'Chọn tất cả',
                    libs: constant.danh_sach_tim_kiem_danh_sach_lop_hoc
                }],
                list_mon_ngoai_ngu: constant.list_mon_ngoai_ngu
            }
        },
        watch: {
            danhSachTimKiemNangCao: function (newVal) {
                if (2 > 0) {
                    let noidung_hienthi = newVal;
                    this.hienThiNangCao.lopChuyen = false;
                    this.hienThiNangCao.lopBanTru = false;
                    this.hienThiNangCao.coHocSinhHocNghe = false;
                    this.hienThiNangCao.lopGhep = false;
                    this.hienThiNangCao.maLopGhep = false;
                    this.hienThiNangCao.lopVnen = false;
                    this.hienThiNangCao.lopCoTreKhuyetTat = false;
                    this.hienThiNangCao.lopChuyenBiet = false;
                    this.hienThiNangCao.soBuoiTrenTuan = false;
                    this.hienThiNangCao.moetCode = false;
                    this.hienThiNangCao.maNn1 = false;
                    this.hienThiNangCao.maNn2 = false;
                    for (let i = 0; i < noidung_hienthi.length; i++) {
                        if (noidung_hienthi[i] == "lopChuyen") {
                            this.hienThiNangCao.lopChuyen = true
                        }
                        if (noidung_hienthi[i] == "lopBanTru") {
                            this.hienThiNangCao.lopBanTru = true
                        }
                        if (noidung_hienthi[i] == "coHocSinhHocNghe") {
                            this.hienThiNangCao.coHocSinhHocNghe = true
                        }
                        if (noidung_hienthi[i] == "lopGhep") {
                            this.hienThiNangCao.lopGhep = true
                        }
                        if (noidung_hienthi[i] == "maLopGhep") {
                            this.hienThiNangCao.maLopGhep = true
                        }
                        if (noidung_hienthi[i] == "lopVnen") {
                            this.hienThiNangCao.lopVnen = true
                        }
                        if (noidung_hienthi[i] == "lopCoTreKhuyetTat") {
                            this.hienThiNangCao.lopCoTreKhuyetTat = true
                        }
                        if (noidung_hienthi[i] == "lopChuyenBiet") {
                            this.hienThiNangCao.lopChuyenBiet = true
                        }
                        if (noidung_hienthi[i] == "soBuoiTrenTuan") {
                            this.hienThiNangCao.soBuoiTrenTuan = true
                        }
                        if (noidung_hienthi[i] == "moetCode") {
                            this.hienThiNangCao.moetCode = true
                        }
                        if (noidung_hienthi[i] == "maNn1") {
                            this.hienThiNangCao.maNn1 = true
                        }
                        if (noidung_hienthi[i] == "maNn2") {
                            this.hienThiNangCao.maNn2 = true
                        }
                    }
                    console.log(JSON.stringify(this.hienThiNangCao));
                }
            },
            slectAll: function (newVal) {
                if (newVal) {
                    this.lsDelete = [];
                    for (let i = 0; i < this.list_lop_hoc.length; i++) {
                        this
                            .lsDelete
                            .push(this.list_lop_hoc[i].maLopHoc);
                    }
                } else {
                    this.lsDelete = [];
                }
            },
            danhSachDonVi: function (newVal) {},
            danhSachCapHoc: function (newVal) {},
            danhSachTruongHoc: function (newVal) {
                console.log("watch Trường học");
                this.ds_truong_hoc = [];
                this.params = {};
                if (newVal) {
                    let lsth = newVal.map((obj) => {
                        return obj['maTruongHoc']
                    });
                    this.ds_truong_hoc = lsth;
                }
                if (this.chuyenhuong.maTruongHoc) {
                    // Nếu chuyển hướng có mã trường học this.getListStudent();
                    this.getListClass();
                }
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
                } else {
                    console.log("Năm học trống");
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                }
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            this.thongtin = JSON.parse(window.userInfo);
            this.list_phan_ban = this.list_phan_ban.filter(item => item.value !== "");
            if (this.thongtin.role == 5) {
                this.danhSachTimKiem = this.danhSachTimKiemTruong;
                console.log("Đăng nhập trường:23456")
                if (this.list_cap_hoc) {
                    let lsch = this.list_cap_hoc.map((obj) => {
                        return obj['id']
                    });
                    this.ds_cap_hoc = lsch;
                } else {
                    this.ds_cap_hoc = [];
                }
                this.bindKhoiHoc();
            } else {
                this.danhSachTimKiem = this.danhSachTimKiemSo;
            }
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
            if (this.thongtin.role == 5) {
                this.bindCapHocDangNhap();
            }
            this.findNamHoc();
            this.getTruongHoc();
            this.bindCotHeader();
            this.ganCot();
            this.getDonVi(() => {
                if (this.trangcu == "[]") {
                    // this.getListClass();
                } else {
                    console.log("Trang cũ");
                    this.chuyenhuong = JSON.parse(this.trangcu);
                    console.log("chuyển hướng:");
                    console.log(JSON.stringify(this.chuyenhuong));
                    this.chuyenHuong();
                }
            });
        },
        methods: {
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_phan_ban_sme"];
                if (tmp) {
                    this.list_phan_ban = JSON.parse(localStorage["danh_sach_phan_ban_sme"]);
                }
            },
            getTenPhanBan(e) {
                let res = "";
                for (let i = 0; i < this.list_phan_ban.length; i++) {
                    if (this.list_phan_ban[i].value == e) {
                        res = this.list_phan_ban[i].name
                    }
                }
                return res;
            },
            ShowUpdate(e) {
                this.dataUpdate = e;
                console.log("Hiển thị thông tin lớp học:" + e)
                this.show_update = true;
            },
            dongSuaHs(e) {
                this.show_update = false;
                // this.tuKhoa = e;
                this.checkTruocKhiTim()
            },
            checkTruocKhiTim() {
                this.lsDelete = [];
                this.trangbatdau = !this.trangbatdau;
            },
            // gán các cột hiển thị dữ liệu
            bindCotHeader() {
                this.danhSachTimKiem.sort(this.sapXepMang)
            },
            sapXepMang(a, b) {
                if (a.stt < b.stt) {
                    return -1;
                }
                if (a.stt > b.stt) {
                    return 1;
                }
                return 0;
            },
            limitTextTieuChi(count) {
                return `và ${count} nội dung khác`
            },
            ChonTruongHoc() {
                console.log("chọn trường học");
                this.ds_truong_hoc = [];
                this.params = {};
                if (this.danhSachTruongHoc) {
                    let lsth = this.danhSachTruongHoc.map((obj) => {
                        return obj['maTruongHoc']
                    });
                    this.ds_truong_hoc = lsth;
                }
                console.log("Chọn trường học rồi:" + this.ds_truong_hoc)
                if (this.chuyenhuong.maTruongHoc) {
                    // Nếu chuyển hướng có mã trường học this.getListStudent();
                    this.getListClass();
                }
            },
            ChonCapHoc() {
                this.list_ma_lop_mm_non = [];
                this.maLopMamNon = "";
                this.list_khoi_hoc = []


                this.params = {};
                this.ds_truong_hoc = [];
                this.ds_khoi_hoc = [];
                this.thongTinTrangCu = [];
                this.getTruongHoc();
                this.bindKhoiHoc();
            },
            ChonDonVi() {
                this.params = {};
                this.ds_truong_hoc = [];
                this.thongTinTrangCu = [];
                console.log('Đơn vị:' + this.ds_don_vi)
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
            boPhanTuTrung(arr) {
                return arr.filter((value, index, arr) => arr.indexOf(value) === index);
            },
            moKhoiHoc() {
                if (this.list_khoi_hoc.length == 0) {
                    this.$alertify.error(
                        "Danh sách khối học trống. Chọn cấp học để lấy danh sách khối học.");
                }
            },
            moNhom() {
                if (this.list_ma_lop_mm_non.length == 0) {
                    if (this.coLopMamNon) {
                        this.$alertify.error(
                            "Danh sách nhóm trẻ mầm non trống. Chọn khối học để lấy danh sách nhóm trẻ.");
                    }
                }
            },
            chonKhoiHoc() {
                this.coLopMamNon = false;
                this.maLopMamNon = "";
                let list_tmp = [];
                if (this.ds_khoi_hoc) {
                    console.log(JSON.stringify(this.ds_khoi_hoc))
                    for (let i = 0; i < this.ds_khoi_hoc.length; i++) {
                        console.log("Danh sách khối học:" + JSON.stringify(this.ds_khoi_hoc[i]))
                        if (this.ds_khoi_hoc[i] == 13) {
                            this.coLopMamNon = true;
                            console.log("Có khối 13")
                            console.log(JSON.stringify(this.lop_nha_tre));
                            for (let a = 0; a < this.lop_nha_tre.length; a++) {
                                list_tmp.push(this.lop_nha_tre[a]);
                            }
                        }
                        if (this.ds_khoi_hoc[i] == 16) {
                            this.coLopMamNon = true;
                            console.log("Có khối 16")
                            for (let b = 0; b < this.lop_mau_giao.length; b++) {
                                list_tmp.push(this.lop_mau_giao[b]);
                            }
                        }
                    }
                    console.log("khối mã:")
                    console.log(JSON.stringify(list_tmp))
                    this.list_ma_lop_mm_non = list_tmp;
                }
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
            CheckXuatExcel() {
                if (this.thongtin.role2 == 5) {
                    this.ds_truong_hoc = [this.thongtin.ma_truong_hoc]
                }
                if (this.total_rows >40000) {
                    this.$alertify.error("Dữ liệu quá lớn. Vui lòng giới hạn dữ liệu tìm kiếm.");
                    return;
                }
                else{
                 this.xuatExcel();
                }
            },
            //Xuất excel
            xuatExcel() {
                let url = "xuat-excel-danh-sach-tra-cuu-lop-hoc";
                let prKhoiHoc = JSON.parse(JSON.stringify(this.ds_khoi_hoc));
                let params = {
                    "capHoc": this.ds_cap_hoc,
                    "khoiHoc": prKhoiHoc,
                    "listMaDonViReq": this.ds_don_vi,
                    "listMaTruongHocReq": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "tenGvcn": this.TeacherName,
                    "maNhomLopMn": this.maLopMamNon,
                    "colExcels": this.danhSachTimKiem,
                    "keySearch": this.ClassName
                };
                if (this.thongtin.role == 2 || this.thongtin.role == 3 || this.thongtin.role == 20 || this.thongtin
                    .role == 40) {
                    params.maPhongs = this.ds_don_vi;
                }
                if (this.thongtin.role == 4) {
                    params.maPhongs = [this.thongtin.ma_don_vi];
                }
                if (this.thongtin.role == 5) {
                    params.maTruongHocs = [this.thongtin.ma_truong_hoc];
                }
                console.log("Danh sách khối học gửi đi" + this.ds_khoi_hoc);
                if (params.khoiHoc) {
                    for (let i = 0; i < params.khoiHoc.length; i++) {
                        if (params.khoiHoc[i] == 13) {
                            params.khoiHoc.push(14)
                            params.khoiHoc.push(15)
                        }
                        if (params.khoiHoc[i] == 16) {
                            params.khoiHoc.push(17)
                            params.khoiHoc.push(18)
                        }
                    }
                }
                console.log("Danh sách khối học gửi đi" + this.ds_khoi_hoc);
                let unique = (value, index, self) => {
                    return self.indexOf(value) === index
                }
                params.khoiHoc = params.khoiHoc.filter(unique);
                dialog.confirmDialog(
                    "Xác nhận tải xuống file thông tin. Vui lòng chờ trong thời gian tải xuống.",
                    "Đồng ý",
                    () => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(url, params, (data) => {
                            loading.close();
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
            // Chuyển hướng từ trang kết chuyển dữ liệu
            demoFunction() {
                console.log("ở trong này thì thích viết đéo gì chả được");
                console.log("chán bỏ me ra chả muốn làm clg cả");
            },
            chuyenHuong() {
                window
                    .history
                    .replaceState("", "CSDL Ngành", "Look-up-classes");
                if (this.chuyenhuong.namHoc) {
                    // this.namHoc = this.chuyenhuong.namHoc;
                    this.namHocHienTai = this.chuyenhuong.namHoc,
                        this.findNamHoc();
                }
                if (this.chuyenhuong.maTruongHoc) {
                    this.layTruongChuyenHuong();
                }
                console.log("11111111111");
            },
            // Lấy danh sách trường chuyển hướng sang
            layTruongChuyenHuong() {
                this.list_truong_hoc = [];
                let params = {
                    maTruong: this.chuyenhuong.maTruongHoc,
                    loose: true
                };
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
                            selectAll: 'Chọn tất cả',
                            libs: this.list_truong_hoc,
                        }
                        console.log(
                            "danh sách trường chueyern hướng:" + JSON.stringify(this.list_truong_hoc)
                        );
                    }
                    this.danhSachTruongHoc = [this.list_truong_hoc[0]];
                    console.log("bind đoạn này nè");
                });
            },
            // xóa moetcode
            DeleteMoetCode() {
                console.log(this.lsDelete);
                if (this.lsDelete.length > 0) {
                    dialog.confirmDialog(
                        "Xác nhận xóa mã định danh của các bản ghi đã chọn?",
                        "Đồng ý",
                        () => {
                            let params = {
                                loaiDuLieu: 2,
                                lstMaLopHocs: this.lsDelete,
                                namHoc: this.namHoc
                            };
                            const loading = this.$loading({
                                lock: true,
                                text: 'Loading',
                                spinner: 'el-icon-loading',
                                background: 'rgba(0, 0, 0, 0.7)'
                            });
                            rest_api.post("/csdlgd-admin/DataTruong/deleteMoetCode", params, data => {
                                loading.close();
                                if (data.data.rc == 0) {
                                    this
                                        .$alertify
                                        .success("Xóa dữ liệu thành công");
                                    this.getListClass();
                                } else {
                                    this
                                        .$alertify
                                        .error(data.data.rd)
                                }
                            });
                        }
                    );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn ít nhất 1 lớp học.")
                }
            },
            // Xóa lớp học
            DeleteClass() {
                console.log(this.lsDelete);
                if (this.lsDelete.length > 0) {
                    dialog.confirmDialog(
                        "Xác nhận xóa các bản ghi đã chọn?",
                        "Đồng ý",
                        () => {
                            console.log("Đồng ý xóa danh sách học sinh:");
                            console.log(this.lsDelete);
                            let params = {
                                listMa: this.lsDelete,
                                namHoc: this.namHoc
                            };
                            const loading = this.$loading({
                                lock: true,
                                text: 'Loading',
                                spinner: 'el-icon-loading',
                                background: 'rgba(0, 0, 0, 0.7)'
                            });
                            rest_api.post("/csdlgd-admin/lopHoc/delete", params, data => {
                                loading.close();
                                if (data.data.rc == 0) {
                                    this
                                        .$alertify
                                        .success("Xóa dữ liệu thành công");
                                    this.getListClass();
                                } else {
                                    this
                                        .$alertify
                                        .error(data.data.rd)
                                }
                            });
                        }
                    );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn ít nhất 1 lớp học.")
                }
            },
            // Bind khối học
            bindKhoiHoc() {
                console.log(JSON.stringify(this.ds_cap_hoc))
                this.list_khoi_hoc = [];
                console.log("Bind khối học");
                for (let i = 0; i < this.ds_cap_hoc.length; i++) {
                    if (this.ds_cap_hoc[i] == 1) {
                        console.log("có bằng 1");
                        for (let i = 0; i < this.list_cap_mot.length; i++) {
                            console.log(this.list_cap_mot[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_mot[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 2) {
                        console.log("có bằng 2");
                        for (let i = 0; i < this.list_cap_hai.length; i++) {
                            console.log(this.list_cap_hai[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_hai[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 3) {
                        console.log("có bằng 3");
                        for (let i = 0; i < this.list_cap_ba.length; i++) {
                            console.log(this.list_cap_ba[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_ba[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 4) {
                        console.log("có bằng 4");
                        for (let i = 0; i < this.list_nha_tre.length; i++) {
                            console.log(this.list_nha_tre[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_nha_tre[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 5) {
                        console.log("có bằng 5");
                        for (let i = 0; i < this.list_mam_non.length; i++) {
                            console.log(this.list_mam_non[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_mam_non[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 45) {
                        console.log("có bằng 5");
                        for (let i = 0; i < this.list_nha_tre.length; i++) {
                            console.log(this.list_nha_tre[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_nha_tre[i])
                        }
                        for (let i = 0; i < this.list_mam_non.length; i++) {
                            console.log(this.list_mam_non[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_mam_non[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 6) {
                        console.log("có bằng 6");
                        for (let i = 0; i < this.list_cap_mot.length; i++) {
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_mot[i])
                        }
                        for (let i = 0; i < this.list_cap_hai.length; i++) {
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_hai[i])
                        }
                        for (let i = 0; i < this.list_cap_ba.length; i++) {
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_ba[i])
                        }
                    }
                    this.list_khoi_hoc = this.boPhanTuTrung(this.list_khoi_hoc);
                    this.list_khoi_hoc.sort((a, b) => (a.id > b.id) ? 1 : -1)
                }
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc,
                    loose: true
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    console.log("lấy trường");
                    if (data.data.statusResponse ==0) {
                        let dulieu = data.data.rows;
                        let ldv =[];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenTruongHoc: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                maTruongHoc: dulieu[i].maTruongHoc
                            }
                            ldv.push(obj)
                        }
                        this.list_truong_hoc = ldv;
                    }
                    else{
                        this.list_truong_hoc = [];
                    }
                });
            },
            // Xem thông tin lớp
            showInFo(e) {
                this.showThongTinLopHoc = true;
                this.dataLopHoc = e;
                console.log("xem chi tiết" + this.dataLopHoc);
            },
            // Lấy danh sách đơn vị
            getDonVi(ck = () => {}) {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                console.log("pr ẻty" + JSON.stringify(params));
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    // console.log("lấy đơn vị thành công" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        let ldv = []
                        let dulieu = data.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenDonVi: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                maDonVi: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi = ldv;
                        if (this.thongtin.role == 4 || this.thongtin.role == 5) {
                            for (let i = 0; i < this.list_don_vi.length; i++) {
                                if (this.list_don_vi[i].maDonVi == this.thongtin.ma_don_vi) {
                                    this.danhSachDonVi = [this.list_don_vi[i]];
                                    this.tenDonViDangNhap = this.list_don_vi[i].tenDonVi;
                                }
                            }
                        }
                        ck();
                    }
                });
            },
            // gán các cột hiển thị
            ganCot() {
                this.hangHienThi = {};
                this.cotHienThi = this.danhSachTimKiem;
                console.log("cột hiển thị:");
                for (let i = 0; i < this.cotHienThi.length; i++) {
                    if (this.cotHienThi[i].key == "maLopHoc") {
                        this.hangHienThi.maLopHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenLopHoc") {
                        this.hangHienThi.tenLopHoc = true;
                    }
                    if (this.cotHienThi[i].key == "khoiHoc") {
                        this.hangHienThi.khoiHoc = true;
                    }
                    if (this.cotHienThi[i].key == "lopChuyen") {
                        this.hangHienThi.lopChuyen = true;
                    }
                    if (this.cotHienThi[i].key == "lopBanTru") {
                        this.hangHienThi.lopBanTru = true;
                    }
                    if (this.cotHienThi[i].key == "coHocSinhHocNghe") {
                        this.hangHienThi.coHocSinhHocNghe = true;
                    }
                    if (this.cotHienThi[i].key == "lopChuyen") {
                        this.hangHienThi.lopChuyen = true;
                    }
                    if (this.cotHienThi[i].key == "phanBan") {
                        this.hangHienThi.phanBan = true;
                    }
                    if (this.cotHienThi[i].key == "maDiemTruong") {
                        this.hangHienThi.maDiemTruong = true;
                    }
                    if (this.cotHienThi[i].key == "lopGhep") {
                        this.hangHienThi.lopGhep = true;
                    }
                    if (this.cotHienThi[i].key == "maLopGhep") {
                        this.hangHienThi.maLopGhep = true;
                    }
                    if (this.cotHienThi[i].key == "lopVnen") {
                        this.hangHienThi.lopVnen = true;
                    }
                    if (this.cotHienThi[i].key == "lopCoTreKhuyetTat") {
                        this.hangHienThi.lopCoTreKhuyetTat = true;
                    }
                    if (this.cotHienThi[i].key == "lopChuyenBiet") {
                        this.hangHienThi.lopChuyenBiet = true;
                    }
                    if (this.cotHienThi[i].key == "soBuoiTrenTuan") {
                        this.hangHienThi.soBuoiTrenTuan = true;
                    }
                    if (this.cotHienThi[i].key == "buoiHoc") {
                        this.hangHienThi.buoiHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenGiaoVienCn") {
                        this.hangHienThi.tenGiaoVienCn = true;
                    }
                    if (this.cotHienThi[i].key == "maTruongHoc") {
                        this.hangHienThi.maTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenTruongHoc") {
                        this.hangHienThi.tenTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "moetCode") {
                        this.hangHienThi.moetCode = true;
                    }
                    if (this.cotHienThi[i].key == "maNn1") {
                        this.hangHienThi.maNn1 = true;
                    }
                    if (this.cotHienThi[i].key == "maNn2") {
                        this.hangHienThi.maNn2 = true;
                    }
                }
                console.log("Hàng hiển thị:" + JSON.stringify(this.hangHienThi));
            },
            // Lấy danh sách lớp
            getListClass() {
                this.slectAll = false;
                this.lsDelete = [];
                this.bindCotHeader();
                this.ganCot();
                let dataSreachList = [];
                if (this.timKiemNangCao) {
                    console.log("Tìm nâng cao ở đây:");
                    console.log(JSON.stringify(this.timKiemNangCao));
                    console.log(JSON.stringify(this.nangCao));
                    if (this.hienThiNangCao.lopChuyen) {
                        if (this.nangCao.lopChuyen) {
                            let obj = {
                                "key": "lopChuyen",
                                "value": parseInt(this.nangCao.lopChuyen),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopBanTru) {
                        if (this.nangCao.lopBanTru) {
                            let obj = {
                                "key": "lopBanTru",
                                "value": parseInt(this.nangCao.lopBanTru),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.coHocSinhHocNghe) {
                        if (this.nangCao.coHocSinhHocNghe) {
                            let demoHN = parseInt(this.nangCao.coHocSinhHocNghe)
                            let obj = {
                                "key": "coHocSinhHocNghe",
                                "value": Boolean(demoHN),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopGhep) {
                        if (this.nangCao.lopGhep) {
                            let obj = {
                                "key": "lopGhep",
                                "value": parseInt(this.nangCao.lopGhep),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLopGhep) {
                        if (this.nangCao.maLopGhep) {
                            let obj = {
                                "key": "maLopGhep",
                                "value": this.nangCao.maLopGhep,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopVnen) {
                        if (this.nangCao.lopVnen) {
                            let obj = {
                                "key": "lopVnen",
                                "value": parseInt(this.nangCao.lopVnen),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopCoTreKhuyetTat) {
                        if (this.nangCao.lopCoTreKhuyetTat) {
                            let demoKT = parseInt(this.nangCao.lopCoTreKhuyetTat);
                            let obj = {
                                "key": "lopCoTreKhuyetTat",
                                "value": Boolean(demoKT),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopChuyenBiet) {
                        if (this.nangCao.lopChuyenBiet) {
                            let demoCB = parseInt(this.nangCao.lopChuyenBiet)
                            let obj = {
                                "key": "lopChuyenBiet",
                                "value": Boolean(demoCB),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.soBuoiTrenTuan) {
                        if (this.nangCao.soBuoiTrenTuan) {
                            let obj = {
                                "key": "soBuoiTrenTuan",
                                "value": parseInt(this.nangCao.soBuoiTrenTuan),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.moetCode) {
                        if (this.nangCao.moetCode) {
                            let obj = {
                                "key": "moetCode",
                                "value": this.nangCao.moetCode,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maNn1) {
                        if (this.nangCao.maNn1) {
                            let obj = {
                                "key": "maNn1",
                                "value": this.nangCao.maNn1,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maNn2) {
                        if (this.nangCao.maNn2) {
                            let obj = {
                                "key": "maNn2",
                                "value": this.nangCao.maNn2,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                }
                console.log("Lọc nâng cao gồm:");
                console.log(JSON.stringify(dataSreachList));
                let prKhoiHoc = JSON.parse(JSON.stringify(this.ds_khoi_hoc));
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "capHoc": this.ds_cap_hoc,
                    "khoiHoc": prKhoiHoc,
                    "listMaDonViReq": this.ds_don_vi,
                    "listMaTruongHocReq": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "tenGvcn": this.TeacherName,
                    "colExcels": this.danhSachTimKiem,
                    "maNhomLopMn": this.maLopMamNon,
                    "dataSreachList": dataSreachList,
                    "keySearch": this.ClassName
                };
                console.log("Danh sách khối học gửi đi" + this.ds_khoi_hoc);
                if (params.khoiHoc) {
                    console.log("Lớp học gồmL" + params.khoiHoc);
                    for (let i = 0; i < params.khoiHoc.length; i++) {
                        if (params.khoiHoc[i] == 13) {
                            params.khoiHoc.push(14)
                            params.khoiHoc.push(15)
                        }
                        if (params.khoiHoc[i] == 16) {
                            params.khoiHoc.push(17)
                            params.khoiHoc.push(18)
                        }
                    }
                    console.log("Lớp học gồm sau" + params.khoiHoc);
                    console.log("***" + this.ds_khoi_hoc)
                }
                console.log("Danh sách khối học gửi đi" + this.ds_khoi_hoc);
                let unique = (value, index, self) => {
                    return self.indexOf(value) === index
                }
                params.khoiHoc = params.khoiHoc.filter(unique);
                console.log(" lấy lớp" + JSON.stringify(params));
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/lopHoc/search2", params, data => {
                    loading.close();
                    this.list_lop_hoc = [];
                    this.total_rows = 0;
                    if (data.data.rc == 0) {
                        this.list_lop_hoc = data.data.tableData;
                        this.total_rows = data.data.totalRows;
                        if (this.total_rows == 0) {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy.")
                        } else {
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công")
                        }
                    } else {
                        this
                            .$alertify
                            .error(data.data.rd)
                    }
                });
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getListClass()
            },
            // gán năm học
            findNamHoc() {
                for (let i = 0; i < this.list_nam_hoc.length; i++) {
                    if (this.list_nam_hoc[i].id == this.namHocHienTai) {
                        this.danhSachNamHoc = this.list_nam_hoc[i];
                    }
                }
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
    a,
    p,
    span {}
    .cg {
        text-align: center;
        align-items: center;
    }
    input[type=checkbox] {
        margin: 0 !important;
    }
</style>

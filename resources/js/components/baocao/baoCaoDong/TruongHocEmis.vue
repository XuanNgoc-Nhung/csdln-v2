<template>
    <div v-loading.fullscreen="fullscreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :gutter="24" class="dts-card">
            <el-col :span="12">
                <label>Tiêu chí báo cáo <sup class="red">*</sup></label>
                <eselectlimit style="width:100%" :limit="30" multiple collapseTags v-model="NoiDungHienThi" @input="ChonNoiDungHienThi"
                    :placeholder="'Chọn'" filterable :data="list_tieu_chi" :fields="['name','nameCol']" />
            </el-col>
            <el-col :span="12">
                <label style="color:white">Biểu mẫu:</label>
                <div v-if="tenBieuMauBaoCao">
                    <span style="color:blue"><b>Bạn đang sử dụng mẫu báo cáo:</b></span><span class="red">
                        {{tenBieuMauBaoCao}}</span>
                </div>
            </el-col>
            <el-col :span="24">
                <draggable class="list-group" tag="div" v-model="list_tieu_chi_hien_thi" v-bind="dragOptions"
                    @start="drag = true" @end="drag = false">
                    <transition-group type="transition">
                        <li class="list-group-item" v-for="(item,i) in list_tieu_chi_hien_thi" :key="item.nameCol">
                            <span>{{i+1}}:
                                {{ item.name }}</span>
                        </li>
                    </transition-group>
                </draggable>
            </el-col>
        </el-row>
        <el-row :gutter="24" class="dts-card">
            <el-collapse v-model="activeNames">
                <el-collapse-item name="1">
                    <template slot="title">
                        <span style="padding-left:12px;color:blue"> <b><i>Bộ lọc dữ liệu</i></b></span>
                    </template>
                    <el-col :span="8">
                        <label>Đơn vị </label>
                        <eselect style="width:100%" @change="LayLaiTruongHoc" multiple collapseTags
                            v-model="noiDungTimKiem.maDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :span="4">
                        <label>Cấp dạy </label>
                        <eselect style="width:100%" multiple collapseTags @change="LayLaiTruongHoc"
                            v-model="noiDungTimKiem.capHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                            :fields="['name','id']" />
                    </el-col>
                    <el-col :span="8">
                        <label>Trường học </label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.maTruongHoc" :placeholder="'Chọn'" filterable
                            :data="list_truong_hoc" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="4">
                        <label>Năm học </label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.namHoc" :placeholder="'Chọn'" filterable :data="list_nam_hoc"
                            :fields="['name','id']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Loại hình đào tạo</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.loaiHinhDaoTao" :placeholder="'Chọn'" filterable :data="danh_sach_loai_hinh_dao_tao"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Loại hình trường</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.loaiHinhTruong" :placeholder="'Chọn'" filterable :data="danh_sach_loai_hinh_truong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Chuẩn quốc gia</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.chuanQuocGia" :placeholder="'Chọn'" filterable
                            :data="danh_sach_chuan_quoc_gia" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Vùng khó khăn</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.maVungKhoKhan" :placeholder="'Chọn'" filterable
                            :data="danh_sach_vung_kho_khan" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Chương trình giáo dục cơ bản</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.chuongTrinhGiaoDucCoBan" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Môi trường phù hợp với hs khuyết tật</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.coHaTangTlhtPhuHopHskt" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Có lớp không chuyên</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.coLopKhongChuyen" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Công tác tư vấn học đường</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.congTacTuVanHocDuong" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Công trình vệ sinh</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.congTrinhVeSinh" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Chương trình giáo dục vệ sinh đôi tay</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.ctGdvsDoiTay" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Đạt chất lượng tối thiểu</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.datChatLuongToiThieu" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Dạy nghề phổ thông</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.dayNghePhoThong" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Điện lưới</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.dienLuoi" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Học 2 buổi/ngày</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hoc2BuoiNgay" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Học sinh bán trú</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hocSinhBanTru" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Học sinh nội trú</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hocSinhNoiTru" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Học sinh khuyết tật</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hocSinhKhuyetTat" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Khai thác Internet để dạy học</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.khaiThacInternetDayHoc" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Kỹ năng sống giáo dục xã hội</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.kyNangSongGdxh" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Nguồn nước sạch</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.nguonNuocSach" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Trường quốc tế</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.truongQuocTe" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Vùng đặc biệt khó khăn</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.vungDacBietKhoKhan" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Trung tâm hướng nghiệp</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.ttGdtxHuongNghiep" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Trung tâm giáo dục thường xuyên</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.ttGdtxHuyen" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Trung tâm ngoại ngữ có vốn nước ngoài</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.ttNnCoVonNuocNgoai" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>

                </el-collapse-item>
            </el-collapse>
        </el-row>
        <el-row :gutter="24">
            <el-col :span="24" class="text-center">
                <el-button type="success" size="mini" @click.prevent="checkTruocKhiTim">Tìm kiếm</el-button>
            </el-col>
        </el-row>
        <el-row :gutter="24">
            <el-col :span="24" style="padding:0">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <el-row :gutter="24">
                            <el-col :span="8" class="reset">
                                <ChonSoLuong @chonXongSoLuong="ChonSoLuongBanGhi($event)">
                                </ChonSoLuong>
                            </el-col>
                            <el-col :span="16" class="reset">
                                <div class="text-right" style="padding-bottom:5px">
                                    <el-tooltip content="Xuất excel" placement="top">
                                        <el-button type="primary" size="mini" @click.prevent="XacNhanTaiXuong">Tải xuống
                                        </el-button>
                                    </el-tooltip>
                                    <el-tooltip content="Lưu lại nội dung hiển thị và bộ lọc dữ liệu" placement="top">
                                        <el-button type="info" size="mini" @click.prevent="XacNhanLuuMau">Lưu mẫu
                                        </el-button>
                                    </el-tooltip>
                                    <el-tooltip content="Sử dụng nội dung hiển thị và bộ lọc dữ liệu có sẵn"
                                        placement="top">
                                        <el-button type="info" size="mini" @click.prevent="TaiMau">Tải mẫu
                                        </el-button>
                                    </el-tooltip>
                                </div>
                            </el-col>
                        </el-row>
                        <div class="table-responsive">
                            <table id="textTableCanBo" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background:rgb(228, 235, 245);">
                                        <template v-for="th in ten_cac_cot">
                                            <th class="text-center">
                                                <p>{{th.value}}</p>
                                            </th>
                                        </template>
                                    </tr>
                                </thead>
                                <tbody v-if="cac_hang.length==0">
                                    <tr>
                                        <td class="text-center" :colspan="ten_cac_cot.length">
                                            <p>Không có bản ghi nào được tìm thấy</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody class="rennder-data" v-else v-html="htmlrender"></tbody>
                            </table>
                        </div>
                        <PhanTrang v-show="total_rows>0" :tongbanghi="total_rows" :soluonghienthi="soLuongBanGhiHienThi"
                            :batdau="trangbatdau" @pageChange="layLai($event)">
                        </PhanTrang>
                    </div>
                </div>
            </el-col>
        </el-row>
        <el-row :gutter="24">
            <el-col :span="24">
                <el-dialog title="Mẫu có sẵn" width="70%" custom-class="dts-dialog" top="10vh"
                    :visible.sync="hien_thi_mau">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Tên mẫu</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Mã</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Thời gian tạo</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Thao tác</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="danh_sach_mau_co_san.length==0">
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in danh_sach_mau_co_san" :key="i">
                                    <td class="text-center">{{i+1}}
                                    </td>
                                    <td>
                                        <p>{{item.ten}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.id}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.timeCreate}}</p>
                                    </td>
                                    <td class="text-center">
                                        <el-tooltip content="Áp dụng" placement="left">
                                            <el-button size="mini" type="success" icon="el-icon-check"
                                                @click.prevent="ApDungTemplate(item)">
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip content="Xóa" placement="right">
                                            <el-button size="mini" type="danger" icon="el-icon-delete"
                                                @click.prevent="xoaTemplate(item.id)">
                                            </el-button>
                                        </el-tooltip>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </el-dialog>
                <el-dialog title="Lưu mẫu" width="40%" top="10vh" :visible.sync="hien_thi_nhap_ten_mau">
                    <label>Tên mẫu: <span class="red">*</span> </label>
                    <input class="form-control" type="text" placeholder="Nhập..." v-model="tenMau"></input>
                    <span slot="footer" class="dialog-footer">
                        <el-button class="dts-button-close" size="mini" @click="hien_thi_nhap_ten_mau = false">Đóng
                        </el-button>
                        <el-button type="primary" size="mini" @click.prevent="LuuMau">Lưu lại</el-button>
                    </span>
                </el-dialog>
                <el-dialog title="Tải xuống dữ liệu" width="40%" top="10vh" :visible.sync="hien_thi_tai_xuong_du_lieu">
                    <!-- <el-checkbox disabled v-model="xuatDuLieuNgang">Xuất dữ liệu ngang</el-checkbox> -->
                    <span slot="footer" class="dialog-footer">
                        <el-button class="dts-button-close" size="mini" @click="hien_thi_tai_xuong_du_lieu = false">Đóng
                        </el-button>
                        <el-button type="primary" size="mini" @click.prevent="taiXuongExcel">Tải xuống</el-button>
                    </span>
                </el-dialog>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import draggable from "vuedraggable";
    import ESelectVue from '../../ui/ESelect.vue';
    import ESelectVueLimit from '../../ui/ESelectLimit.vue';
    import rest_api from '../../../utils/rest_api';
    import api from "../../api";
    import constant from '../../../utils/constant';
    import PhanTrang from "../../ui/PhanTrang";
    import ChonSoLuong from "../../ui/chonSoLuongBanGhi";
    import FileSaver from 'file-saver';
    export default {
        components: {
            draggable,
            'eselect': ESelectVue,
            'eselectlimit': ESelectVueLimit,
            PhanTrang: PhanTrang,
            ChonSoLuong: ChonSoLuong,
        },
        props: ['danh_sach_don_vi', 'danh_sach_truong_hoc'],
        data() {
            return {
                // activeNames: ['1'],
                activeNames: [],
                fullscreenLoading: false,
                thongtin: JSON.parse(window.userInfo),
                danh_sach_du_lieu: [],
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                soLuongBanGhiHienThi: 25,
                list_don_vi: [],
                list_truong_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                danh_sach_doi_tac: [],
                danh_sach_loai_hinh_dao_tao: [],
                danh_sach_loai_hinh_truong: [],
                danh_sach_chuan_quoc_gia: [],
                danh_sach_vung_kho_khan: [],
                list_co_khong: [{
                    value: 1,
                    name: 'Có'
                }, {
                    value: 0,
                    name: 'Không'
                }],
                list_cap_hoc: window.listCapHoc,
                hien_thi_sap_xep: false,
                danhSachTieuChi: [],
                noiDungTimKiem: {
                    maDonVi: [],
                    maTruongHoc: [],
                    namHoc: '',
                    maTruongHoc: [],
                    loaiHinhDaoTao: [],
                    loaiHinhTruong: [],
                    chuanQuocGia: [],
                    maVungKhoKhan: [],
                    chuongTrinhGiaoDucCoBan: '',
                    coHaTangTlhtPhuHopHskt: '',
                    coLopKhongChuyen: '',
                    congTacTuVanHocDuong: '',
                    congTrinhVeSinh: '',
                    ctGdvsDoiTay: '',
                    datChatLuongToiThieu: '',
                    dayNghePhoThong: '',
                    dienLuoi: '',
                    hoc2BuoiNgay: '',
                    hocSinhBanTru: '',
                    hocSinhNoiTru: '',
                    hocSinhKhuyetTat: '',
                    khaiThacInternetDayHoc: '',
                    kyNangSongGdxh: '',
                    nguonNuocSach: '',
                    suDungMayTinhDayHoc: '',
                    truongQuocTe: '',
                    vungDacBietKhoKhan: '',
                    ttGdtxHuongNghiep: '',
                    ttGdtxHuyen: '',
                    ttNnCoVonNuocNgoai: '',
                },
                NoiDungHienThi: ['namHoc'],
                list_tieu_chi_hien_thi: [{
                    index: 0,
                    name: "Năm học",
                    nameCol: "namHoc",
                    status: true
                }],
                danhSachBoLoc: [],
                list_tieu_chi: [{
                        "name": "Đơn vị quản lý",
                        "nameCol": "maDonVi",
                    }, {
                        "name": "Cấp dạy",
                        "nameCol": "capHoc",
                    }, {
                        "name": "Trường học",
                        "nameCol": "maTruongHoc",
                    }, {
                        "name": "Năm học",
                        "nameCol": "namHoc",
                    },
                    {
                        "name": 'Loại hình đào tạo',
                        'nameCol': 'loaiHinhDaoTao'
                    },
                    {
                        "name": 'Loại hình trường',
                        'nameCol': 'loaiHinhTruong'
                    },
                    {
                        "name": 'Chuẩn quốc gia',
                        'nameCol': 'chuanQuocGia'
                    },
                    {
                        "name": 'Vùng khó khăn',
                        'nameCol': 'maVungKhoKhan'
                    },
                    {
                        "name": 'Chương trình giáo dục cơ bản',
                        'nameCol': 'chuongTrinhGiaoDucCoBan'
                    },
                    {
                        "name": 'Môi trường phù hợp với học sinh khuyết tật',
                        'nameCol': 'coHaTangTlhtPhuHopHskt'
                    },
                    {
                        "name": 'Lớp không chuyên',
                        'nameCol': 'coLopKhongChuyen'
                    },
                    {
                        "name": 'Công tác tư vấn học đường',
                        'nameCol': 'congTacTuVanHocDuong'
                    },
                    {
                        "name": 'Công trình vệ sinh',
                        'nameCol': 'congTrinhVeSinh'
                    },
                    {
                        "name": 'Giáo dục vệ sinh đôi tay',
                        'nameCol': 'ctGdvsDoiTay'
                    },
                    {
                        "name": 'Đạt chất lượng tối thiểu',
                        'nameCol': 'datChatLuongToiThieu'
                    },
                    {
                        "name": 'Dạy nghề phổ thông',
                        'nameCol': 'dayNghePhoThong'
                    },
                    {
                        "name": 'Điện lưới',
                        'nameCol': 'dienLuoi'
                    },
                    {
                        "name": 'Học 2 buổi/ngày',
                        'nameCol': 'hoc2BuoiNgay'
                    },
                    {
                        "name": 'Học sinh bán trú',
                        'nameCol': 'hocSinhBanTru'
                    },
                    {
                        "name": 'Học sinh nội trú',
                        'nameCol': 'hocSinhNoiTru'
                    },
                    {
                        "name": 'Học sinh khuyết tật',
                        'nameCol': 'hocSinhKhuyetTat'
                    },
                    {
                        "name": 'Khai tác Internet dạy học',
                        'nameCol': 'khaiThacInternetDayHoc'
                    },
                    {
                        "name": 'Kỹ năng sống giáo dục xã hội',
                        'nameCol': 'kyNangSongGdxh'
                    },
                    {
                        "name": 'Nguồn nước sạch',
                        'nameCol': 'nguonNuocSach'
                    },
                    {
                        "name": 'Sử dụng máy tính dạy học',
                        'nameCol': 'suDungMayTinhDayHoc'
                    },
                    {
                        "name": 'Trường quốc tế',
                        'nameCol': 'truongQuocTe'
                    },
                    {
                        "name": 'Vùng đặc biệt khó khăn',
                        'nameCol': 'vungDacBietKhoKhan'
                    },
                    {
                        "name": 'Trung tâm hướng nghiệp',
                        'nameCol': 'ttGdtxHuongNghiep'
                    },
                    {
                        "name": 'Trung tâm giáo dục thường xuyên',
                        'nameCol': 'ttGdtxHuyen'
                    },
                    {
                        "name": 'Trung tâm ngoại ngữ có vốn nước ngoài',
                        'nameCol': 'ttNnCoVonNuocNgoai'
                    },
                ],
                list_hien_thi_da_sap_xep: [],
                drag: false,
                trangbatdau: false,
                colList: [],
                requestList: [],
                requestLists: [],
                cac_hang: [],
                ten_cac_cot: [],
                hien_thi_mau: false,
                hien_thi_nhap_ten_mau: false,
                hien_thi_tai_xuong_du_lieu: false,
                xuatDuLieuNgang: false,
                danh_sach_mau_co_san: [],
                tenMau: "",
                tenBieuMauBaoCao: "",
                hienThiBoLoc: {}
            };
        },
        watch: {
            danh_sach_don_vi: function (newVal) {
                console.log("Danh sách đơn vị thay đổi:");
                if (newVal) {
                    this.list_don_vi = newVal;
                } else {
                    this.list_don_vi = [];
                }
            },
            danh_sach_truong_hoc: function (newVal) {
                console.log("Danh sách trường học thay đổi:");
                if (newVal) {
                    this.list_truong_hoc = newVal;
                } else {
                    this.list_truong_hoc = [];
                }
            },
        },
        mounted: function () {
            this.layDanhSachDoiTac();
            console.log("Mounted");
            this.noiDungTimKiem.namHoc = this.thongtin.namHocHienTai;
            this.ganDuLieuSME();
        },
        methods: {
            xoaTenBieuMauBaoCao() {
                this.tenBieuMauBaoCao = '';
            },
            layDanhSachDoiTac() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    "start": 0,
                    "limit": 9999,
                };
                rest_api.get("/internal-api/heThongDoiTac/filter", params, (data) => {
                    loading.close();
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenDoiTac + " - [" + data.data.rows[i].maDoiTac +
                                    "]",
                                value: data.data.rows[i].maDoiTac,
                            }
                            data_demo.push(obj);
                        }
                        this.danh_sach_doi_tac = data_demo;
                    }
                });
            },
            ChonNoiDungHienThi() {
                this.xoaTenBieuMauBaoCao()
                if (this.NoiDungHienThi.length > 0) {
                    let data = this.NoiDungHienThi;
                    let mang = [];
                    for (let i = 0; i < data.length; i++) {
                        for (let j = 0; j < this.list_tieu_chi.length; j++) {
                            if (this.list_tieu_chi[j].nameCol == data[i]) {
                                let obj = {
                                    name: this.list_tieu_chi[j].name,
                                    nameCol: this.list_tieu_chi[j].nameCol,
                                }
                                mang.push(obj)
                            }
                        }
                    }
                    this.list_tieu_chi_hien_thi = mang;
                } else {
                    this.list_tieu_chi_hien_thi = [];
                }
            },
            taiXuongExcel() {
                let url = "/xuat-excel-bao-cao-dong-truong-hoc";
                this.ganLaiViTri();
                if (this.list_hien_thi_da_sap_xep.length == 0) {
                    this.thongBao("error", "Thiếu tiêu chí báo cáo")
                    return;
                }
                this.colList = this.list_hien_thi_da_sap_xep;
                this.ganDanhSachRequestList();
                this.ganDanhSachRequestValue();

                let hasNamHoc = false;
                for(let p = 0; p<this.requestList.length; p++){
                    console.log(p)
                    if(this.requestList[p].nameSreach = 'namHoc'){
                        hasNamHoc = true;
                    }
                }
                if (!hasNamHoc) {
                    this.thongBao('error', 'Vui lòng bổ sung giá trị năm học trong bộ lọc tìm kiếm.')
                    return;
                }
                let params = {
                    "colList": this.colList,
                    "requestLists": this.requestLists,
                    "requestList": this.requestList,
                    "start": 0,
                    "limit": 999999,
                    "turn": this.xuatDuLieuNgang
                };
                this.fullscreenLoading = true;
                this.hien_thi_tai_xuong_du_lieu = false;
                api.post(url, params, (data) => {
                    this.fullscreenLoading = false;
                    this.thongBao("success", "Tải xuống thành công");
                    this.hien_thi_mau = false;
                    let currentDate = new Date();
                    let fileName = '';
                    var thangNay = parseInt(currentDate.getMonth()) + 1;
                    if (thangNay < 10) {
                        thangNay = '0' + thangNay;
                    }
                    fileName = this.thongtin.ma_so + '_Bao_cao_truong_hoc_' + currentDate.getDate() + thangNay +
                        (currentDate.getFullYear());
                    FileSaver.saveAs(data.data.file, fileName);
                });
            },
            XacNhanTaiXuong() {
                let coNamHoc = false;
                console.log("***")
                console.log(this.NoiDungHienThi)
                for (let i = 0; i < this.NoiDungHienThi.length; i++) {
                    if (this.NoiDungHienThi[i] == 'namHoc') {
                        coNamHoc = true;
                    }
                }
                if (!coNamHoc) {
                    this.thongBao('error', 'Tiêu chí năm học là bắt buộc. Vui lòng bổ sung.')
                    return;
                }
                this.hien_thi_tai_xuong_du_lieu = true;
            },
            ApDungTemplate(e) {
                console.log("Thông tin mẫu áp dụng:")
                let du_lieu = JSON.parse(e.request);
                console.log(du_lieu)
                this.$confirm('Xác nhận áp dụng mẫu đã chọn?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.fullscreenLoading = true;
                        setTimeout(() => {
                            this.tenBieuMauBaoCao = du_lieu.name;
                            let colList = du_lieu.colList;
                            // Check nội dung hiển thị
                            if (colList && colList.length > 0) {
                                let duLieuColList = [];
                                let list_tieu_chi_hien_thi = [];
                                for (let i = 0; i < colList.length; i++) {
                                    let obj = {
                                        index: i,
                                        name: colList[i].name,
                                        nameCol: colList[i].nameCol,
                                        status: true
                                    }
                                    duLieuColList.push(colList[i].nameCol)
                                    list_tieu_chi_hien_thi.push(obj)
                                }
                                this.NoiDungHienThi = duLieuColList;
                                this.list_tieu_chi_hien_thi = list_tieu_chi_hien_thi;
                            }
                            // Check tìm kiếm đơn
                            let requestList = du_lieu.requestList;
                            if (requestList && requestList.length > 0) {
                                for (let j = 0; j < requestList.length; j++) {
                                    let nameSreach = requestList[j].nameSreach;
                                    let valueSearch;
                                    if (requestList[j].value === true) {
                                        valueSearch = 1;
                                    } else if (requestList[j].value === false) {
                                        valueSearch = 0;
                                    } else {
                                        valueSearch = requestList[j].value;
                                    }
                                    this.noiDungTimKiem[nameSreach] = valueSearch
                                }
                            }
                            // Check tìm kiếm theo mảng
                            let requestLists = du_lieu.requestLists;
                            if (requestLists && requestLists.length > 0) {
                                for (let j = 0; j < requestLists.length; j++) {
                                    let nameSreach = requestLists[j].nameSreach;
                                    let valueSearch = requestLists[j].values;
                                    this.noiDungTimKiem[nameSreach] = valueSearch;
                                }
                            }
                            this.fullscreenLoading = false;
                            this.thongBao("success", "Áp dụng thành công");
                            this.hien_thi_mau = false;
                        }, 1500)
                    })
                    .catch(_ => {});
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
            xoaTemplate(e) {
                this.$confirm('Xác nhận xóa mẫu này?', 'Xóa dữ liệu', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass:'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        let params = {}
                        this.fullscreenLoading = true;
                        rest_api.post(
                            "/csdlgd-report-fetch/template/delete/" + e,
                            params,
                            (data) => {
                                this.fullscreenLoading = false;
                                console.log("Xóa template")
                                console.log(data)
                                if (data.data.rc == 0) {
                                    this.TaiMau();
                                    this.thongBao("success", data.data.rd);
                                    return;
                                } else {
                                    this.thongBao("error", data.data.rd);
                                    return;
                                }
                            },
                        );
                    })
                    .catch(_ => {});
            },
            XacNhanLuuMau() {
                console.log("Lưu mẫu")
                this.ganLaiViTri();
                this.colList = this.list_hien_thi_da_sap_xep;
                this.ganDanhSachRequestList();
                this.ganDanhSachRequestValue();
                if (this.colList.length == 0) {
                    this.thongBao("error", "Vui lòng bổ sung tiêu chí.")
                    return;
                }
                let coNamHoc = false;
                for (let i = 0; i < this.list_hien_thi_da_sap_xep.length; i++) {
                    if (this.list_hien_thi_da_sap_xep[i].nameCol == 'namHoc') {
                        coNamHoc = true;
                    }
                }
                if (!coNamHoc) {
                    this.thongBao('error', 'Tiêu chí năm học là bắt buộc. Vui lòng bổ sung.')
                    return;
                }
                this.hien_thi_nhap_ten_mau = true;
            },
            LuuMau() {
                if (!this.tenMau) {
                    this.thongBao("error", "Vui lòng bổ sung tên mẫu")
                    return;
                }
                this.$confirm('Xác nhận lưu lại mẫu?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        let params = {
                            "colList": this.colList,
                            "requestLists": this.requestLists,
                            "requestList": this.requestList,
                            "start": this.start,
                            "limit": this.limit,
                            "type": 3,
                            "name": this.tenMau
                        };
                        this.fullscreenLoading = true;
                        rest_api.post("/csdlgd-report-fetch/template/save", params, (data) => {
                            this.fullscreenLoading = false;
                            if (data.data.rc == 0) {
                                this.thongBao("success", "Mẫu đã được lưu lại");
                                this.hien_thi_nhap_ten_mau = false;
                                this.tenMau = "";
                            } else {
                                this.thongBao("error", "Có lỗi sảy ra. Vui lòng thửu lại")
                            }
                        });
                    })
                    .catch(_ => {});
            },
            TaiMau() {
                console.log("Tải mẫu");
                let params = {
                    "name": "",
                    "type": 3
                };
                this.fullscreenLoading = true;
                rest_api.post("/csdlgd-report-fetch/template/search", params, (data) => {
                    this.fullscreenLoading = false;
                    console.log(data)
                    if (data.data.rc == 0) {
                        this.danh_sach_mau_co_san = data.data.rows;
                        if (data.data.total == 0) {
                            // this.thongBao("error", "Không tìm thấy bản ghi nào")
                            return;
                        } else {
                            this.hien_thi_mau = true;
                        }
                    } else {
                        this.thongBao("error", "Hệ thống đang bận. Vui lòng thử lại sau")
                        return;
                    }
                });
            },
            getData() {
                this.ganLaiViTri();
                if (this.list_hien_thi_da_sap_xep.length == 0) {
                    this.thongBao("error", "Thiếu tiêu chí báo cáo")
                    return;
                }
                let coNamHoc = false;
                for (let i = 0; i < this.list_hien_thi_da_sap_xep.length; i++) {
                    if (this.list_hien_thi_da_sap_xep[i].nameCol == 'namHoc') {
                        coNamHoc = true;
                    }
                }
                if (!coNamHoc) {
                    this.thongBao('error', 'Tiêu chí năm học là bắt buộc. Vui lòng bổ sung.')
                    return;
                }
                this.colList = this.list_hien_thi_da_sap_xep;
                this.ganDanhSachRequestList();
                this.ganDanhSachRequestValue();
                let hasNamHoc = false;
                for(let p = 0; p<this.requestList.length; p++){
                    console.log(p)
                    if(this.requestList[p].nameSreach = 'namHoc'){
                        hasNamHoc = true;
                    }
                }
                if (!hasNamHoc) {
                    this.thongBao('error', 'Vui lòng bổ sung giá trị năm học trong bộ lọc tìm kiếm.')
                    return;
                }
                let params = {
                    "colList": this.colList,
                    "requestLists": this.requestLists,
                    "requestList": this.requestList,
                    "start": this.start,
                    "limit": this.limit
                };
                console.log("Params lấy dữ liệu:")
                console.log(params);
                this.fullscreenLoading = true;
                rest_api.post("/csdlgd-report-fetch/BaoCaoTruongHoc/search", params, (data) => {
                    this.fullscreenLoading = false;
                    var html = '';
                    console.log("lấy báo cáo trả về" + JSON.stringify(data));
                    this.total_rows = data.data.total;
                    console.log("tổng số bản ghi:" + this.total_rows);
                    this.ten_cac_cot = data.data.tableHeaders;
                    console.log("các cột");
                    console.log(JSON.stringify(this.ten_cac_cot));
                    this.cac_hang = data.data.tableRows;
                    console.log("các hàng");
                    console.log(JSON.stringify(this.cac_hang));
                    if (this.cac_hang) {
                        this.dowload = true;
                        this
                            .cac_hang
                            .forEach(function (item) {
                                html += '<tr>';
                                item
                                    .col
                                    .forEach(function (i) {
                                        html += '<td class=""> <p>' + i.value + '</p></td>'
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
                });
            },
            MergeCommonRows() {
                console.log('số cột :' + this.ten_cac_cot.length);
                let lengthCol = this.ten_cac_cot.length;
                let ar = Array.from(Array(lengthCol - 2).keys());
                $('#textTableCanBo').margetable({
                    type: 2,
                    colindex: ar
                });
            },
            ganDanhSachRequestValue() {
                let data = [];
                if (this.noiDungTimKiem.namHoc) {
                    let obj = {
                        name: "Năm học",
                        nameSreach: "namHoc",
                        value: this.noiDungTimKiem.namHoc
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.chuongTrinhGiaoDucCoBan !== '') {
                    let obj = {
                        name: "Chương trình giáo dục cơ bản",
                        nameSreach: "chuongTrinhGiaoDucCoBan",
                        value: Boolean(this.noiDungTimKiem.chuongTrinhGiaoDucCoBan)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.coHaTangTlhtPhuHopHskt !== '') {
                    let obj = {
                        name: "Môi trường phù hợp hs khuyết tật",
                        nameSreach: "coHaTangTlhtPhuHopHskt",
                        value: Boolean(this.noiDungTimKiem.coHaTangTlhtPhuHopHskt)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.coLopKhongChuyen !== '') {
                    let obj = {
                        name: "Có lớp không chuyên",
                        nameSreach: "coLopKhongChuyen",
                        value: Boolean(this.noiDungTimKiem.coLopKhongChuyen)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.congTacTuVanHocDuong !== '') {
                    let obj = {
                        name: "Có lớp không chuyên",
                        nameSreach: "congTacTuVanHocDuong",
                        value: Boolean(this.noiDungTimKiem.congTacTuVanHocDuong)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.congTrinhVeSinh !== '') {
                    let obj = {
                        name: "Công trình vệ sinh",
                        nameSreach: "congTrinhVeSinh",
                        value: Boolean(this.noiDungTimKiem.congTrinhVeSinh)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.ctGdvsDoiTay !== '') {
                    let obj = {
                        name: "Giáo dục vệ sinh đôi tay",
                        nameSreach: "ctGdvsDoiTay",
                        value: Boolean(this.noiDungTimKiem.ctGdvsDoiTay)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.datChatLuongToiThieu !== '') {
                    let obj = {
                        name: "Đạt chất lượng tối thiểu",
                        nameSreach: "datChatLuongToiThieu",
                        value: Boolean(this.noiDungTimKiem.datChatLuongToiThieu)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.dayNghePhoThong !== '') {
                    let obj = {
                        name: "Dạy nghề phổ thông",
                        nameSreach: "dayNghePhoThong",
                        value: Boolean(this.noiDungTimKiem.dayNghePhoThong)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.dienLuoi !== '') {
                    let obj = {
                        name: "Điện lưới",
                        nameSreach: "dienLuoi",
                        value: Boolean(this.noiDungTimKiem.dienLuoi)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hoc2BuoiNgay !== '') {
                    let obj = {
                        name: "Học 2 buổi/ngày",
                        nameSreach: "hoc2BuoiNgay",
                        value: Boolean(this.noiDungTimKiem.hoc2BuoiNgay)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hocSinhBanTru !== '') {
                    let obj = {
                        name: "Học sinh bán trú",
                        nameSreach: "hocSinhBanTru",
                        value: Boolean(this.noiDungTimKiem.hocSinhBanTru)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hocSinhNoiTru !== '') {
                    let obj = {
                        name: "Học sinh nội trú",
                        nameSreach: "hocSinhNoiTru",
                        value: Boolean(this.noiDungTimKiem.hocSinhNoiTru)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hocSinhKhuyetTat !== '') {
                    let obj = {
                        name: "Học sinh khuyết tật",
                        nameSreach: "hocSinhKhuyetTat",
                        value: Boolean(this.noiDungTimKiem.hocSinhKhuyetTat)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.khaiThacInternetDayHoc !== '') {
                    let obj = {
                        name: "Khai thác Internet dạy học",
                        nameSreach: "khaiThacInternetDayHoc",
                        value: Boolean(this.noiDungTimKiem.khaiThacInternetDayHoc)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.kyNangSongGdxh !== '') {
                    let obj = {
                        name: "Kỹ năng sống giáo dục xã hội",
                        nameSreach: "kyNangSongGdxh",
                        value: Boolean(this.noiDungTimKiem.kyNangSongGdxh)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.nguonNuocSach !== '') {
                    let obj = {
                        name: "Kỹ năng sống giáo dục xã hội",
                        nameSreach: "nguonNuocSach",
                        value: Boolean(this.noiDungTimKiem.nguonNuocSach)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.truongQuocTe !== '') {
                    let obj = {
                        name: "Trường quốc tế",
                        nameSreach: "truongQuocTe",
                        value: Boolean(this.noiDungTimKiem.truongQuocTe)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.vungDacBietKhoKhan !== '') {
                    let obj = {
                        name: "Vùng đặc biệt khó khăn",
                        nameSreach: "vungDacBietKhoKhan",
                        value: Boolean(this.noiDungTimKiem.vungDacBietKhoKhan)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.ttGdtxHuongNghiep !== '') {
                    let obj = {
                        name: "Trung tâm hướng nghiệp",
                        nameSreach: "ttGdtxHuongNghiep",
                        value: Boolean(this.noiDungTimKiem.ttGdtxHuongNghiep)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.ttGdtxHuyen !== '') {
                    let obj = {
                        name: "Trung tâm hướng nghiệp",
                        nameSreach: "ttGdtxHuyen",
                        value: Boolean(this.noiDungTimKiem.ttGdtxHuyen)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.ttNnCoVonNuocNgoai !== '') {
                    let obj = {
                        name: "Trung tâm ngoại ngữ có vốn nước ngoài",
                        nameSreach: "ttNnCoVonNuocNgoai",
                        value: Boolean(this.noiDungTimKiem.ttNnCoVonNuocNgoai)
                    }
                    data.push(obj);
                }
                this.requestList = data;
            },
            ganDanhSachRequestList() {
                let data = [];
                if (this.noiDungTimKiem.maDonVi && this.noiDungTimKiem.maDonVi.length > 0) {
                    console.log("Có đơn vị");
                    let obj = {
                        name: "Đơn vị quản lý",
                        nameSreach: "maDonVi",
                        values: this.noiDungTimKiem.maDonVi
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.capHoc && this.noiDungTimKiem.capHoc.length > 0) {
                    console.log("Có cấp dạy");
                    let obj = {
                        name: "Cấp dạy",
                        nameSreach: "capHoc",
                        values: this.noiDungTimKiem.capHoc
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.maTruongHoc && this.noiDungTimKiem.maTruongHoc.length > 0) {
                    let obj = {
                        name: "Trường học",
                        nameSreach: "maTruongHoc",
                        values: this.noiDungTimKiem.maTruongHoc
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.loaiHinhDaoTao && this.noiDungTimKiem.loaiHinhDaoTao.length > 0) {
                    let obj = {
                        name: "Loại hình đào tạo",
                        nameSreach: "loaiHinhDaoTao",
                        values: this.noiDungTimKiem.loaiHinhDaoTao
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.loaiHinhTruong && this.noiDungTimKiem.loaiHinhTruong.length > 0) {
                    let obj = {
                        name: "Loại hình trường",
                        nameSreach: "loaiHinhTruong",
                        values: this.noiDungTimKiem.loaiHinhTruong
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.chuanQuocGia && this.noiDungTimKiem.chuanQuocGia.length > 0) {
                    let obj = {
                        name: "Chuẩn quốc gia",
                        nameSreach: "chuanQuocGia",
                        values: this.noiDungTimKiem.chuanQuocGia
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.maVungKhoKhan && this.noiDungTimKiem.maVungKhoKhan.length > 0) {
                    let obj = {
                        name: "Vùng khó khăn",
                        nameSreach: "maVungKhoKhan",
                        values: this.noiDungTimKiem.maVungKhoKhan
                    }
                    data.push(obj);
                }

                this.requestLists = data;
            },
            getTrueFalse(e) {
                let result = Boolean(e);
                return result;
            },
            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                this.soLuongBanGhiHienThi = e.soluong;
            },
            checkTruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_loai_hinh_dao_tao_sme"];
                if (tmp) {
                    this.danh_sach_loai_hinh_dao_tao = JSON.parse(localStorage["danh_sach_loai_hinh_dao_tao_sme"]);
                    this.danh_sach_loai_hinh_truong = JSON.parse(localStorage["danh_sach_loai_hinh_truong_sme"]);
                    this.danh_sach_chuan_quoc_gia = JSON.parse(localStorage["danh_sach_chuan_quoc_gia_sme"]);
                    this.danh_sach_vung_kho_khan = JSON.parse(localStorage["danh_sach_doi_tuong_uu_tien_sme"]);
                }
                this.removeEmptyElement();
                this.mapIntValue();
                this.removeDuplicateArrray();
            },
            removeDuplicateArrray() {
                this.danh_sach_loai_hinh_dao_tao = this.uniqByKeepFirst(this.danh_sach_loai_hinh_dao_tao, item => item.value);
                this.danh_sach_loai_hinh_truong = this.uniqByKeepFirst(this.danh_sach_loai_hinh_truong, item => item.value);
            },
            uniqByKeepFirst(a, key) {
                let seen = new Set();
                return a.filter(item => {
                    let k = key(item);
                    return seen.has(k) ? false : seen.add(k);
                });
            },
            mapIntValue() {
                for (let i = 0; i < this.danh_sach_chuan_quoc_gia.length; i++) {
                    this.danh_sach_chuan_quoc_gia[i].value = parseInt(this.danh_sach_chuan_quoc_gia[i].value);
                }
                for (let i = 0; i < this.danh_sach_loai_hinh_dao_tao.length; i++) {
                    this.danh_sach_loai_hinh_dao_tao[i].value = parseInt(this.danh_sach_loai_hinh_dao_tao[i].value);
                }
                for (let i = 0; i < this.danh_sach_loai_hinh_truong.length; i++) {
                    this.danh_sach_loai_hinh_truong[i].value = parseInt(this.danh_sach_loai_hinh_truong[i].value);
                }
            },
            removeEmptyElement() {
                this.danh_sach_loai_hinh_dao_tao = this.danh_sach_loai_hinh_dao_tao.filter(item => item.value !== "");
                this.danh_sach_loai_hinh_truong = this.danh_sach_loai_hinh_truong.filter(item => item.value !== "");
                this.danh_sach_chuan_quoc_gia = this.danh_sach_chuan_quoc_gia.filter(item => item.value !== "");
                this.danh_sach_vung_kho_khan = this.danh_sach_vung_kho_khan.filter(item => item.value !== "");
            },
            LayLaiTruongHoc() {
                this.noiDungTimKiem.maTruongHoc = [];
                this.getTruongHoc();
                this.xoaTenBieuMauBaoCao();
            },
            getTruongHoc() {
                this.fullscreenLoading = true;
                let params = {
                    maDonVi: this.noiDungTimKiem.maDonVi,
                    capHoc: this.noiDungTimKiem.capHoc,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    this.fullscreenLoading = false;
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
            ganLaiViTri() {
                let data = [];
                let start = 0;
                console.log("Map lại vị trí hiển thị")
                for (let i = 0; i < this.list_tieu_chi_hien_thi.length; i++) {
                    let obj = {
                        name: this.list_tieu_chi_hien_thi[i].name,
                        nameCol: this.list_tieu_chi_hien_thi[i].nameCol,
                        index: start,
                        status: true,
                    }
                    start++
                    data.push(obj);
                }
                this.list_hien_thi_da_sap_xep = data;
                console.log(this.list_hien_thi_da_sap_xep)
            }
        },
        computed: {
            dragOptions() {
                return {
                    animation: 200,
                    group: "description",
                    disabled: false,
                    ghostClass: "ghost"
                };
            }
        }
    };

</script>
<style scoped="scoped">
    .button {
        margin-top: 35px;
    }

    .flip-list-move {
        transition: transform 0.5s;
    }

    .no-move {
        transition: transform 0s;
    }

    .ghost {
        opacity: 0.5;
        background: #c8ebfb;
    }

    .list-group {
        min-height: 20px;
        padding: 5px;
        border: 1px solid gainsboro
    }

    .list-group-item {
        cursor: move;
        display: inline-flex !important;
        padding: 4px 10px;
    }

    .list-group-item i {
        cursor: pointer;
    }

    .dts-card.el-row {
        border: 1px solid silver;
        border-radius: 4px;
    }

</style>

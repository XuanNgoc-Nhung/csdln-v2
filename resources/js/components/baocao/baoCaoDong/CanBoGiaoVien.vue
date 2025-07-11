<template>
    <div v-loading.fullscreen="fullscreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :gutter="24" class="dts-card">
            <el-col :span="12">
                <label>Tiêu chí báo cáo <sup class="red">*</sup></label>
                <eselectlimit style="width:100%" :limit="30" multiple collapseTags v-model="NoiDungHienThi"
                    @input="ChonNoiDungHienThi" :placeholder="'Chọn'" filterable :data="list_tieu_chi"
                    :fields="['name','nameCol']" />
            </el-col>
            <el-col :span="12">
                <label style="color:white">Biểu mẫu:</label>
                <div v-if="tenBieuMauBaoCao">
                    <!-- <marquee width="100%" direction="left" scrollamount="6"> -->
                    <span style="color:blue"><b>Bạn đang sử dụng mẫu báo cáo:</b></span><span class="red">
                        {{tenBieuMauBaoCao}}</span>
                    <!-- </marquee> -->
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
                    <el-row>
                        <el-col :span="8">
                            <label>Tiêu chí</label>
                            <eselect style="width:100%" multiple collapseTags v-model="danhSachBoLoc"
                                @change="ChonTieuChiBoLoc" :placeholder="'Chọn'" filterable
                                :data="danh_sach_tieu_chi_tim_kiem" :fields="['name','value']" />
                        </el-col>
                    </el-row>
                    <div>
                        <el-col v-if="hienThiBoLoc.maDonVi" :span="8">
                            <label>Đơn vị </label>
                            <eselect style="width:100%" @change="LayLaiTruongHoc" multiple collapseTags
                                v-model="noiDungTimKiem.maDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.capHoc" :span="4">
                            <label>Cấp dạy </label>
                            <eselect style="width:100%" multiple collapseTags @change="LayLaiTruongHoc"
                                v-model="noiDungTimKiem.capHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                                :fields="['name','id']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.maTruongHoc" :span="8">
                            <label>Trường học </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.maTruongHoc" :placeholder="'Chọn'" filterable
                                :data="list_truong_hoc" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.namHoc" :span="4">
                            <label>Năm học </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                                v-model="noiDungTimKiem.namHoc" :placeholder="'Chọn'" filterable :data="list_nam_hoc"
                                :fields="['name','id']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.trangThai" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trạng thái </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.trangThai" :placeholder="'Chọn'" filterable
                                :data="list_trang_thai" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.gioiTinh" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Giới tính </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.gioiTinh" :placeholder="'Chọn'" filterable
                                :data="list_gioi_tinh" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.loaiHinhDaoTao" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Loại hình trường </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.loaiHinhDaoTao" :placeholder="'Chọn'" filterable
                                :data="list_loai_hinh_truong" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.loaiHopDong" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Loại hợp đồng </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.loaiHopDong" :placeholder="'Chọn'" filterable
                                :data="list_loai_hop_dong_lam_viec" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.loaiCanBo" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Nhóm cán bộ </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.loaiCanBo" :placeholder="'Chọn'" filterable
                                :data="list_nhom_can_bo" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.maTrinhDoChuyenMonCaoNhat" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trình độ chuyên môn </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.maTrinhDoChuyenMonCaoNhat" :placeholder="'Chọn'" filterable
                                :data="list_trinh_do_chuyen_mon" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.maKhuVuc" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Khu vực </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.maKhuVuc" :placeholder="'Chọn'" filterable :data="list_khu_vuc"
                                :fields="['name','value']" />
                        </el-col>
                        <!-- <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Loại cán bộ </label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags v-model="noiDungTimKiem.loaiCanBo"
                            :placeholder="'Chọn'" filterable :data="list_loai_can_bo" :fields="['name','value']" />
                    </el-col> -->
                        <el-col v-if="hienThiBoLoc.doTuoi" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Độ tuổi </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.doTuoi" :placeholder="'Chọn'" filterable :data="list_do_tuoi"
                                :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.dgKqChuanNgheNghiep" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Đánh giá chuẩn nghề nghiệp </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.dgKqChuanNgheNghiep" :placeholder="'Chọn'" filterable
                                :data="list_danh_gia_chuan_nghe_nghiep" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.danTocThieuSo" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Dân tộc thiểu số </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.danTocThieuSo" :placeholder="'Chọn'" filterable
                                :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.chuyenTrachDoi" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Giáo viên phụ trách đội</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.chuyenTrachDoi" :placeholder="'Chọn'" filterable
                                :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.thamGiaBdTxuyen" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Tham gia bồi dưỡng thường xuyên</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.thamGiaBdTxuyen" :placeholder="'Chọn'" filterable
                                :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.maMonHoc" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Môn dạy </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.maMonHoc" :placeholder="'Chọn'" filterable :data="list_mon_day"
                                :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.maDanToc" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Dân tộc </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.maDanToc" :placeholder="'Chọn'" filterable :data="list_dan_toc"
                                :fields="['name','value']" />
                        </el-col>
                        <!-- Mới -->
                        <el-col v-if="hienThiBoLoc.trinhDoGvien" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trình độ giáo viên</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.trinhDoGvien" :placeholder="'Chọn'" filterable
                                :data="danh_sach_trinh_do_giao_vien" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.trinhDoDaoTao" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trình độ đào tạo</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.trinhDoDaoTao" :placeholder="'Chọn'" filterable
                                :data="danh_sach_trinh_do_dao_tao" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.hinhThucDaoTao" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Hình thức đào tạo</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.hinhThucDaoTao" :placeholder="'Chọn'" filterable
                                :data="danh_sach_hinh_thuc_dao_tao" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.maChuyenNganhDaoTao" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Chuyên ngành đào tạo</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.maChuyenNganhDaoTao" :placeholder="'Chọn'" filterable
                                :data="danh_sach_chuyen_nganh_dao_tao" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.trinhDoVanHoa" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trình độ văn hóa</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.trinhDoVanHoa" :placeholder="'Chọn'" filterable
                                :data="danh_sach_trinh_do_van_hoa" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.trinhDoTinHoc" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trình độ tin học</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.trinhDoTinHoc" :placeholder="'Chọn'" filterable
                                :data="danh_sach_trinh_do_tin_hoc" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.trinhDoNgoaiNgu" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trình độ ngoại ngữ</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.trinhDoNgoaiNgu" :placeholder="'Chọn'" filterable
                                :data="danh_sach_trinh_do_ngoai_ngu" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.trinhDoLyLuanChinhTri" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trình độ lý luận chính trị</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.trinhDoLyLuanChinhTri" :placeholder="'Chọn'" filterable
                                :data="danh_sach_trinh_do_ly_luan_chinh_tri" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.trinhDoQuanLyNhaNuoc" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trình độ quản lý nhà nước</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.trinhDoQuanLyNhaNuoc" :placeholder="'Chọn'" filterable
                                :data="danh_sach_trinh_do_quan_ly_nha_nuoc" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.trinhDoQuanLyGiaoDuc" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trình độ quản lý giáo dục</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.trinhDoQuanLyGiaoDuc" :placeholder="'Chọn'" filterable
                                :data="danh_sach_trinh_do_quan_ly_giao_duc" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.maNgach" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Mã ngạch</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.maNgach" :placeholder="'Chọn'" filterable
                                :data="danh_sach_ma_ngach" :fields="['name','value']" />
                        </el-col>
                        <!-- <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Loại giáo viên</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags v-model="noiDungTimKiem.loaiGiaoVien"
                            :placeholder="'Chọn'" filterable :data="list_dan_toc" :fields="['name','value']" />
                    </el-col> -->
                        <el-col v-if="hienThiBoLoc.dayNhomLop" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Dạy nhóm lớp</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.dayNhomLop" :placeholder="'Chọn'" filterable
                                :data="danh_sach_nhom_lop" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.dayNhomLopKiemNhiem" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Dạy nhóm lớp kiêm nhiệm</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.dayNhomLopKiemNhiem" :placeholder="'Chọn'" filterable
                                :data="danh_sach_nhom_lop" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.monDayChinh" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Môn dạy chính</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.monDayChinh" :placeholder="'Chọn'" filterable
                                :data="danh_sach_nhom_lop" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.monDayKiemNhiem" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Môn dạy kiêm nhiệm</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.monDayKiemNhiem" :placeholder="'Chọn'" filterable
                                :data="danh_sach_nhom_lop" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.nhiemVuKiemNhiem" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Nhiệm vụ kiêm nhiệm</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.nhiemVuKiemNhiem" :placeholder="'Chọn'" filterable
                                :data="danh_sach_nhiem_vu_kiem_nhiem" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.bacLuong" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Bậc lương</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.bacLuong" :placeholder="'Chọn'" filterable
                                :data="danh_sach_bac_luong" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.heSo" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Hệ số lương</label>
                            <el-input-number style="width:100%" controls-position="right" v-model="noiDungTimKiem.heSo"
                                :step="0.01" :min="0">
                            </el-input-number>
                        </el-col>
                        <!-- <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Ngày hưởng</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags v-model="noiDungTimKiem.ngayHuong"
                            :placeholder="'Chọn'" filterable :data="list_dan_toc" :fields="['name','value']" />
                    </el-col> -->
                        <el-col v-if="hienThiBoLoc.vuotKhung" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Vượt khung</label>
                            <el-input clearable size="small" placeholder="Nhập..." type="number"
                                v-model="noiDungTimKiem.vuotKhung">
                            </el-input>
                        </el-col>
                        <el-col v-if="hienThiBoLoc.chuyenNganhDaoTaoChinh" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Môn ngoại ngữ chính</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.chuyenNganhDaoTaoChinh" :placeholder="'Chọn'" filterable
                                :data="danh_sach_mon_ngoai_ngu" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.chuyenNganhDaoTaoChinh" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Chuyên ngành đào tạo chính</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.chuyenNganhDaoTaoChinh" :placeholder="'Chọn'" filterable
                                :data="danh_sach_chuyen_nganh_dao_tao_chinh" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.trinhDoDaoTaoCnChinh" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Trình độ đào tạo chuyên ngành chính</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.trinhDoDaoTaoCnChinh" :placeholder="'Chọn'" filterable
                                :data="danh_sach_trinh_do_dao_tao_chuyen_nganh_chinh" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.danhGiaVienChuc" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Đánh giá viên chức </label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.danhGiaVienChuc" :placeholder="'Chọn'" filterable
                                :data="danh_sach_danh_gia_vien_chuc" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.thanhPhanGiaDinh" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Thành phần gia đình</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.thanhPhanGiaDinh" :placeholder="'Chọn'" filterable
                                :data="danh_sach_thanh_phan_gia_dinh" :fields="['name','value']" />
                        </el-col>
                        <el-col v-if="hienThiBoLoc.maDoiTac" :xs="24" :sm="12" :md="8" :lg="6">
                            <label>Đối tác</label>
                            <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                                v-model="noiDungTimKiem.maDoiTac" :placeholder="'Chọn'" filterable
                                :data="danh_sach_doi_tac" :fields="['name','value']" />
                        </el-col>
                    </div>
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
                hienThiBoLoc: {},
                danhSachBoLoc: [],
                danh_sach_tieu_chi_tim_kiem: [{
                        name: 'Đơn vị',
                        value: 'maDonVi'
                    },
                    {
                        name: 'Cấp dạy',
                        value: 'capHoc'
                    },
                    {
                        name: 'Trường học',
                        value: 'maTruongHoc'
                    },
                    {
                        name: 'Năm học',
                        value: 'namHoc'
                    },
                    {
                        name: 'Trạng thái',
                        value: 'trangThai'
                    },
                    {
                        name: 'Giới tính',
                        value: 'gioiTinh'
                    },
                    {
                        name: 'Loại hình trường',
                        value: 'loaiHinhDaoTao'
                    },
                    {
                        name: 'Loại hợp đồng',
                        value: 'loaiHopDong'
                    },
                    {
                        name: 'Nhóm cán bộ',
                        value: 'loaiCanBo'
                    },
                    {
                        name: 'Trình độ chuyên môn',
                        value: 'maTrinhDoChuyenMonCaoNhat'
                    },
                    {
                        name: 'Khu vực',
                        value: 'maKhuVuc'
                    },
                    {
                        name: 'Độ tuổi',
                        value: 'doTuoi'
                    },
                    {
                        name: 'Đánh giá chuẩn nghề nghiệp',
                        value: 'dgKqChuanNgheNghiep'
                    },
                    {
                        name: 'Dân tộc thiểu số',
                        value: 'danTocThieuSo'
                    },
                    {
                        name: 'Giáo viên phụ trách đội',
                        value: 'chuyenTrachDoi'
                    },
                    {
                        name: 'Tham gia bồi dưỡng thường xuyên',
                        value: 'thamGiaBdTxuyen'
                    },
                    {
                        name: 'Môn dạy',
                        value: 'maMonHoc'
                    },
                    {
                        name: 'Dân tộc',
                        value: 'maDanToc'
                    },
                    {
                        name: 'Trình độ giáo viên',
                        value: 'trinhDoGvien'
                    },
                    {
                        name: 'Trình độ đào tạo',
                        value: 'trinhDoDaoTao'
                    },
                    {
                        name: 'Hình thức đào tạo',
                        value: 'hinhThucDaoTao'
                    },
                    {
                        name: 'Chuyên ngành đào tạo',
                        value: 'maChuyenNganhDaoTao'
                    },
                    {
                        name: 'Trình độ văn hoá',
                        value: 'trinhDoVanHoa'
                    },
                    {
                        name: 'Trình độ tin học',
                        value: 'trinhDoTinHoc'
                    },
                    {
                        name: 'Trình độ ngoại ngữ',
                        value: 'trinhDoNgoaiNgu'
                    },
                    {
                        name: 'Trình độ lý luận chính trị',
                        value: 'trinhDoLyLuanChinhTri'
                    },
                    {
                        name: 'Trình độ quản lý nhà nước',
                        value: 'trinhDoQuanLyNhaNuoc'
                    },
                    {
                        name: 'Trình độ quản lý giáo dục',
                        value: 'trinhDoQuanLyGiaoDuc'
                    },
                    {
                        name: 'Mã ngạch',
                        value: 'maNgach'
                    },
                    {
                        name: 'Dạy nhóm lớp',
                        value: 'dayNhomLop'
                    },
                    {
                        name: 'Dạy nhóm lớp kiêm nhiệm',
                        value: 'dayNhomLopKiemNhiem'
                    },
                    {
                        name: 'Môn dạy chính',
                        value: 'monDayChinh'
                    },
                    {
                        name: 'Môn dạy kiêm nhiệm',
                        value: 'monDayKiemNhiem'
                    },
                    {
                        name: 'Nhiệm vụ kiêm nhiệm',
                        value: 'nhiemVuKiemNhiem'
                    },
                    {
                        name: 'Bậc lương',
                        value: 'bacLuong'
                    },
                    {
                        name: 'Hệ số lương',
                        value: 'heSo'
                    },
                    {
                        name: 'Vượt khung',
                        value: 'vuotKhung'
                    },
                    {
                        name: 'Môn ngoại ngữ chính',
                        value: 'monNgoaiNguChinh'
                    },
                    {
                        name: 'Chuyên ngành đào tạo chính',
                        value: 'chuyenNganhDaoTaoChinh'
                    },
                    {
                        name: 'Trình độ đào tạo chuyên ngành chính',
                        value: 'trinhDoDaoTaoCnChinh'
                    },
                    {
                        name: 'Đánh giá viên chức',
                        value: 'danhGiaVienChuc'
                    },
                    {
                        name: 'Thành phần gia đình',
                        value: 'thanhPhanGiaDinh'
                    },
                    {
                        name: 'Đối tác',
                        value: 'maDoiTac'
                    },
                ],
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
                list_trang_thai: [],
                list_gioi_tinh: [],
                list_loai_hinh_truong: [],
                list_loai_hop_dong_lam_viec: [],
                list_nhom_can_bo: constant.NHOM_CAN_BO,
                list_trinh_do_chuyen_mon: [],
                list_khu_vuc: [],
                list_loai_can_bo: [],
                list_do_tuoi: constant.DO_TUOI,
                list_danh_gia_chuan_nghe_nghiep: [],
                list_mon_day: [],
                list_dan_toc: [],
                danh_sach_trinh_do_giao_vien: [],
                danh_sach_trinh_do_dao_tao: [],
                danh_sach_hinh_thuc_dao_tao: [],
                danh_sach_chuyen_nganh_dao_tao: [],
                danh_sach_trinh_do_van_hoa: [],
                danh_sach_trinh_do_tin_hoc: [],
                danh_sach_trinh_do_ngoai_ngu: [],
                danh_sach_trinh_do_ly_luan_chinh_tri: [],
                danh_sach_trinh_do_quan_ly_nha_nuoc: [],
                danh_sach_trinh_do_quan_ly_giao_duc: [],
                danh_sach_ma_ngach: [],
                danh_sach_nhom_lop: [],
                danh_sach_nhiem_vu_kiem_nhiem: [],
                danh_sach_bac_luong: [],
                danh_sach_mon_ngoai_ngu: [],
                danh_sach_chuyen_nganh_dao_tao_chinh: [],
                danh_sach_trinh_do_dao_tao_chuyen_nganh_chinh: [],
                danh_sach_danh_gia_vien_chuc: [],
                danh_sach_thanh_phan_gia_dinh: [],
                danh_sach_doi_tac: [],
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
                    maTrinhDoChuyenMonCaoNhat: [],
                    loaiHinhDaoTao: [],
                    loaiHopDong: [],
                    gioiTinh: [],
                    danTocThieuSo: [],
                    chuyenTrachDoi: [],
                    thamGiaBdTxuyen: [],
                    trinhDoGvien: [],
                    trinhDoDaoTao: [],
                    hinhThucDaoTao: [],
                    maChuyenNganhDaoTao: [],
                    trinhDoVanHoa: [],
                    trinhDoTinHoc: [],
                    trinhDoNgoaiNgu: [],
                    trinhDoLyLuanChinhTri: [],
                    trinhDoQuanLyNhaNuoc: [],
                    trinhDoQuanLyGiaoDuc: [],
                    maNgach: [],
                    dayNhomLop: [],
                    dayNhomLopKiemNhiem: [],
                    monDayChinh: [],
                    monDayKiemNhiem: [],
                    nhiemVuKiemNhiem: [],
                    bacLuong: [],
                    heSo: '',
                    vuotKhung: '',
                    monNgoaiNguChinh: [],
                    chuyenNganhDaoTaoChinh: [],
                    trinhDoDaoTaoCnChinh: [],
                    danhGiaVienChuc: [],
                    dgKqChuanNgheNghiep: [],
                    thanhPhanGiaDinh: [],
                    maDoiTac: [],
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
                    }, {
                        "name": "Trạng thái",
                        "nameCol": "trangThai",
                    }, {
                        "name": "Giới tính",
                        "nameCol": "gioiTinh",
                    }, {
                        "name": "Loại hình trường",
                        "nameCol": "loaiHinhDaoTao",
                    }, {
                        "name": "Loại hợp đồng",
                        "nameCol": "loaiHopDong",
                    }, {
                        "name": "Nhóm cán bộ",
                        "nameCol": "loaiCanBo",
                    }, {
                        "name": "Trình độ chuyên môn",
                        "nameCol": "trinhDoChuyenMonCaoNhat",
                    }, {
                        "name": "Khu vực",
                        "nameCol": "maKhuVuc",
                    },
                    // {
                    //     "name": "Loại cán bộ",
                    //     "nameCol": "maChucVu",
                    // },
                    {
                        "name": "Độ tuổi",
                        "nameCol": "doTuoi",
                    }, {
                        "name": "Đánh giá chuẩn nghề nghiệp",
                        "nameCol": "dgKqChuanNgheNghiep",
                    }, {
                        "name": "Dân tộc thiểu số",
                        "nameCol": "danTocThieuSo",
                    }, {
                        "name": "Giáo viên phụ trách đội",
                        "nameCol": "chuyenTrachDoi",
                    }, {
                        "name": "Môn dạy",
                        "nameCol": "maMonHoc",
                    }, {
                        "name": "Dân tộc",
                        "nameCol": "maDanToc",
                    }, {
                        "name": "Chức vụ",
                        "nameCol": "chucVu",
                    }, {
                        "name": "Trình độ giáo viên",
                        "nameCol": "trinhDoGvien",
                    }, {
                        "name": "Trình độ đào tạo",
                        "nameCol": "trinhDoDaoTao",
                    }, {
                        "name": "Hình thức đào tạo",
                        "nameCol": "hinhThucDaoTao",
                    }, {
                        "name": "Chuyên ngành đào tạo",
                        "nameCol": "maChuyenNganhDaoTao",
                    },
                    {
                        "name": "Trình độ văn hóa",
                        "nameCol": "trinhDoVanHoa",
                    },
                    {
                        "name": "Trình độ tin học",
                        "nameCol": "trinhDoTinHoc",
                    },
                    {
                        "name": "Trình độ ngoại ngữ",
                        "nameCol": "trinhDoNgoaiNgu",
                    },
                    {
                        "name": "Trình độ lý luận chính trị",
                        "nameCol": "trinhDoLyLuanChinhTri",
                    },
                    {
                        "name": "Trình độ quản lý nhà nước",
                        "nameCol": "trinhDoQuanLyNhaNuoc",
                    },
                    {
                        "name": "Trình độ quản lý giáo dục",
                        "nameCol": "trinhDoQuanLyGiaoDuc",
                    },
                    {
                        "name": "Tham gia bồi dưỡng thường xuyên",
                        "nameCol": "thamGiaBdTxuyen",
                    },
                    {
                        "name": "Mã ngạch",
                        "nameCol": "maNgach",
                    },
                    {
                        "name": "Dạy nhóm lớp",
                        "nameCol": "dayNhomLop",
                    },
                    {
                        "name": "Dạy nhóm lớp kiêm nhiệm",
                        "nameCol": "dayNhomLopKiemNhiem",
                    },
                    {
                        "name": "Môn dạy chính",
                        "nameCol": "monDayChinh",
                    },
                    {
                        "name": "Môn dạy kiêm nhiệm",
                        "nameCol": "monDayKiemNhiem",
                    },
                    {
                        "name": "Nhiệm vụ kiêm nhiệm",
                        "nameCol": "nhiemVuKiemNhiem",
                    },
                    {
                        "name": "Bậc lương",
                        "nameCol": "bacLuong",
                    },
                    {
                        "name": "Hệ số lương",
                        "nameCol": "heSo",
                    },
                    {
                        "name": "Vượt khung",
                        "nameCol": "vuotKhung",
                    },
                    {
                        "name": "Môn ngoại ngữ chính",
                        "nameCol": "monNgoaiNguChinh",
                    },
                    {
                        "name": "Chuyên ngành đào tạo chính",
                        "nameCol": "chuyenNganhDaoTaoChinh",
                    },
                    {
                        "name": "Trình độ đào tạo chuyên ngành chính",
                        "nameCol": "trinhDoDaoTaoCnChinh",
                    },
                    {
                        "name": "Đánh giá viên chức",
                        "nameCol": "danhGiaVienChuc",
                    },
                    {
                        "name": "Thành phần gia đình",
                        "nameCol": "thanhPhanGiaDinh",
                    },
                    {
                        "name": "Đối tác",
                        "nameCol": "maDoiTac",
                    }
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
            console.log(this.thongtin)
            this.noiDungTimKiem.namHoc = this.thongtin.namHocHienTai;
            if (this.thongtin.role != 2) {
                this.ganThongTin();
            }
            this.ganDuLieuSME();
        },
        methods: {
            ChonTieuChiBoLoc() {
                for (let i = 0; i < this.danhSachBoLoc.length; i++) {
                    this.hienThiBoLoc[this.danhSachBoLoc[i]] = true;
                }
                console.log(this.hienThiBoLoc)
                for (let j = 0; j < this.danh_sach_tieu_chi_tim_kiem.length; j++) {
                    let index = this.getIndexInArray(this.danh_sach_tieu_chi_tim_kiem[j].value,
                        this.danhSachBoLoc);
                    if (index == -1) {
                        this.hienThiBoLoc[this.danh_sach_tieu_chi_tim_kiem[j].value] = false;
                        // this.hienThiBoLoc.
                    }
                }
                console.log(this.noiDungTimKiem);
                // this.hienThiBoLoc[this.danhSachBoLoc[index]] = false



            },
            ganThongTin() {
                this.noiDungTimKiem.maDonVi = [this.thongtin.ma_don_vi];
                this.noiDungTimKiem.capHoc = this.thongtin.listCapHoc;
                this.noiDungTimKiem.maTruongHoc = [this.thongtin.ma_truong_hoc]
            },
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
                let url = "/xuat-excel-bao-cao-dong-can-bo";
                this.ganLaiViTri();
                if (this.list_hien_thi_da_sap_xep.length == 0) {
                    this.thongBao("error", "Thiếu tiêu chí báo cáo")
                    return;
                }
                this.colList = this.list_hien_thi_da_sap_xep;
                this.ganDanhSachRequestList();
                this.ganDanhSachRequestValue();
                let hasNamHoc = false;
                for (let p = 0; p < this.requestList.length; p++) {
                    console.log(p)
                    if (this.requestList[p].nameSreach = 'namHoc') {
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
                    fileName = this.thongtin.ma_so + '_Bao_cao_can_bo_' + currentDate.getDate() + thangNay +
                        (currentDate.getFullYear());
                    FileSaver.saveAs(data.data.file, fileName);
                });
                // this.fullscreenLoading = true;
                // this.hien_thi_tai_xuong_du_lieu = false;
                // setTimeout(() => {
                //     this.fullscreenLoading = false;
                //     this.thongBao("success", "Tải xuống thành công");
                //     this.hien_thi_mau = false;
                // }, 5000)
            },
            XacNhanTaiXuong() {
                let coNamHoc = false;
                if (!this.NoiDungHienThi || this.NoiDungHienThi.length == 0) {
                    this.thongBao('error', 'Vui lòng bổ sung tiêu chí.')
                    return;
                }
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
                        closeOnClickModal: false,
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
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
                                    if (valueSearch && valueSearch.length > 0) {
                                        for (let p = 0; p < valueSearch.length; p++) {
                                            if (valueSearch[p] === true) {
                                                valueSearch[p] = 1
                                            }
                                            if (valueSearch[p] === false) {
                                                valueSearch[p] = 0
                                            }
                                        }
                                    }
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
                        confirmButtonClass: 'el-button--danger',
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
                console.log(this.hienThiBoLoc);
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
                            "type": 1,
                            "name": this.tenMau,
                            "hienThiBoLoc": this.hienThiBoLoc,

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
                    "type": 1
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
                for (let p = 0; p < this.requestList.length; p++) {
                    console.log(p)
                    if (this.requestList[p].nameSreach = 'namHoc') {
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
                rest_api.post("/csdlgd-report-fetch/BaoCaoGiaoVien/sreach", params, (data) => {
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
                this.requestList = data;
            },
            getIndexOfArray(val, arr) {
                let array = arr.map(function (item) {
                    return item.value;
                });
                let index = array.indexOf(val);
                return index;
            },
            getIndexInArray(val, arr) {
                let index = arr.indexOf(val);
                return index;
            },
            ganDanhSachRequestList() {
                let data = [];
                console.log("Bộ lọc:")
                console.log(this.danhSachBoLoc)
                console.log(this.danh_sach_tieu_chi_tim_kiem)
                for (let i = 0; i < this.danhSachBoLoc.length; i++) {
                    if (this.danhSachBoLoc[i] != 'namHoc') {
                        let obj = {
                            name: this.danh_sach_tieu_chi_tim_kiem[this.getIndexOfArray(this.danhSachBoLoc[i], this
                                .danh_sach_tieu_chi_tim_kiem)].name,
                            nameSreach: this.danh_sach_tieu_chi_tim_kiem[this.getIndexOfArray(this.danhSachBoLoc[i],
                                this.danh_sach_tieu_chi_tim_kiem)].value,
                            values: this.noiDungTimKiem[this.danh_sach_tieu_chi_tim_kiem[this.getIndexOfArray(this
                                .danhSachBoLoc[i], this.danh_sach_tieu_chi_tim_kiem)].value]
                        }
                        if (this.danhSachBoLoc[i] == 'capHoc') {
                            obj.values = this.mapToString(obj.values);
                        }
                        if (this.danhSachBoLoc[i] == 'danTocThieuSo') {
                            obj.values = this.mapToBoolean(obj.values);
                        }
                        if (obj.values && obj.values.length) {
                            data.push(obj);
                        }
                    }

                }
                this.requestLists = data;
            },
            mapToString(arr) {
                let result = [];
                if (arr) {
                    for (let i = 0; i < arr.length; i++) {
                        result.push(arr[i].toString());
                    }
                }
                return result;
            },
            mapToBoolean(arr) {
                let result = [];
                if (arr) {
                    for (let i = 0; i < arr.length; i++) {
                        result.push(Boolean(Number(arr[i])));
                    }
                }
                return result;
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
                let tmp = localStorage["danh_sach_mon_hoc_sme"];
                if (tmp) {
                    this.list_trang_thai = JSON.parse(localStorage["danh_sach_trang_thai_can_bo_sme"]);
                    this.list_gioi_tinh = JSON.parse(localStorage["danh_sach_gioi_tinh_sme"]);
                    this.list_loai_hinh_truong = JSON.parse(localStorage["danh_sach_loai_hinh_truong_sme"]);
                    this.list_loai_hop_dong_lam_viec = JSON.parse(localStorage["danh_sach_hinh_thuc_hop_dong_sme"]);
                    this.list_trinh_do_chuyen_mon = JSON.parse(localStorage["danh_sach_trinh_do_chuyen_mon_sme"]);
                    this.list_khu_vuc = JSON.parse(localStorage["danh_sach_khu_vuc_sme"]);
                    this.list_loai_can_bo = JSON.parse(localStorage["danh_sach_loai_can_bo_sme"]);
                    this.list_danh_gia_chuan_nghe_nghiep = JSON.parse(localStorage[
                        "danh_sach_danh_gia_chuan_nghe_nghiep_sme"]);
                    this.list_mon_day = JSON.parse(localStorage["danh_sach_mon_day_giao_vien_sme"]);
                    this.list_dan_toc = JSON.parse(localStorage["danh_sach_dan_toc_sme"]);
                    this.danh_sach_trinh_do_giao_vien = JSON.parse(localStorage["danh_sach_trinh_do_chinh_sme"]);
                    this.danh_sach_trinh_do_dao_tao = JSON.parse(localStorage["danh_sach_trinh_do_chuyen_mon_sme"]);
                    this.danh_sach_hinh_thuc_dao_tao = JSON.parse(localStorage["danh_sach_hinh_thuc_dao_tao_sme"]);
                    this.danh_sach_chuyen_nganh_dao_tao = JSON.parse(localStorage["danh_sach_nganh_dao_tao_sme"]);
                    this.danh_sach_trinh_do_van_hoa = JSON.parse(localStorage["danh_sach_trinh_do_van_hoa_sme"]);
                    this.danh_sach_trinh_do_tin_hoc = JSON.parse(localStorage["danh_sach_trinh_do_tin_hoc_sme"]);
                    this.danh_sach_trinh_do_ngoai_ngu = JSON.parse(localStorage["danh_sach_trinh_do_ngoai_ngu_sme"]);
                    this.danh_sach_trinh_do_ly_luan_chinh_tri = JSON.parse(localStorage[
                        "danh_sach_trinh_do_ly_luan_chinh_tri_sme"]);
                    this.danh_sach_trinh_do_quan_ly_nha_nuoc = JSON.parse(localStorage[
                        "danh_sach_trinh_do_quan_ly_nha_nuoc_sme"]);
                    this.danh_sach_trinh_do_quan_ly_giao_duc = JSON.parse(localStorage[
                        "danh_sach_trinh_do_quan_ly_giao_duc_sme"]);
                    this.danh_sach_ma_ngach = JSON.parse(localStorage["danh_sach_ngach_hang_sme"]);
                    this.danh_sach_nhom_lop = JSON.parse(localStorage["danh_sach_mon_day_giao_vien_sme"]);
                    this.danh_sach_nhiem_vu_kiem_nhiem = JSON.parse(localStorage["danh_sach_nhiem_vu_kiem_nhiem_sme"]);
                    this.danh_sach_bac_luong = JSON.parse(localStorage["danh_sach_bac_luong_sme"]);
                    this.danh_sach_mon_ngoai_ngu = JSON.parse(localStorage["danh_sach_ngoai_ngu_chinh_sme"]);
                    this.danh_sach_chuyen_nganh_dao_tao_chinh = JSON.parse(localStorage[
                        "danh_sach_chuyen_nganh_dao_tao_chinh_sme"]);
                    this.danh_sach_trinh_do_dao_tao_chuyen_nganh_chinh = JSON.parse(localStorage[
                        "danh_sach_trinh_do_chinh_sme"]);
                    this.danh_sach_danh_gia_vien_chuc = JSON.parse(localStorage["danh_sach_danh_gia_vien_chuc_sme"]);
                    this.danh_sach_thanh_phan_gia_dinh = JSON.parse(localStorage["danh_sach_thanh_phan_gia_dinh_sme"]);
                }
                this.removeEmptyElement();
                this.mapIntValue();
                this.removeDuplicateArrray();
            },
            removeDuplicateArrray() {
                this.list_trang_thai = [...new Map(this.list_trang_thai.map(item => [JSON.stringify(item), item]))
                    .values()
                ];
                this.list_gioi_tinh = [...new Map(this.list_gioi_tinh.map(item => [JSON.stringify(item), item]))
                    .values()
                ];
                this.list_loai_hinh_truong = [...new Map(this.list_loai_hinh_truong.map(item => [JSON.stringify(item),
                    item
                ])).values()];
                this.list_loai_hop_dong_lam_viec = [...new Map(this.list_loai_hop_dong_lam_viec.map(item => [JSON
                    .stringify(item), item
                ])).values()];
                this.list_trinh_do_chuyen_mon = [...new Map(this.list_trinh_do_chuyen_mon.map(item => [JSON.stringify(
                    item), item])).values()];
                this.list_khu_vuc = [...new Map(this.list_khu_vuc.map(item => [JSON.stringify(item), item])).values()];
                this.list_loai_can_bo = [...new Map(this.list_loai_can_bo.map(item => [JSON.stringify(item), item]))
                    .values()
                ];
                this.list_danh_gia_chuan_nghe_nghiep = [...new Map(this.list_danh_gia_chuan_nghe_nghiep.map(item => [
                    JSON.stringify(item), item
                ])).values()];
                this.list_mon_day = [...new Map(this.list_mon_day.map(item => [
                    JSON.stringify(item), item
                ])).values()];
                this.list_dan_toc = [...new Map(this.list_dan_toc.map(item => [
                    JSON.stringify(item), item
                ])).values()];
                this.danh_sach_trinh_do_giao_vien = [...new Map(this.danh_sach_trinh_do_giao_vien.map(item => [
                    JSON.stringify(item), item
                ])).values()];
                this.danh_sach_trinh_do_dao_tao = [...new Map(this.danh_sach_trinh_do_dao_tao.map(item => [
                    JSON.stringify(item), item
                ])).values()];
                this.danh_sach_hinh_thuc_dao_tao = [...new Map(this.danh_sach_hinh_thuc_dao_tao.map(item => [
                    JSON.stringify(item), item
                ])).values()];
                this.danh_sach_trinh_do_dao_tao_chuyen_nganh_chinh = [...new Map(this
                    .danh_sach_trinh_do_dao_tao_chuyen_nganh_chinh.map(item => [
                        JSON.stringify(item), item
                    ])).values()];
                this.danh_sach_danh_gia_vien_chuc = [...new Map(this.danh_sach_danh_gia_vien_chuc.map(item => [
                    JSON.stringify(item), item
                ])).values()];
            },
            mapIntValue() {
                for (let i = 0; i < this.danh_sach_thanh_phan_gia_dinh.length; i++) {
                    this.danh_sach_thanh_phan_gia_dinh[i].value = parseInt(this.danh_sach_thanh_phan_gia_dinh[i].value);
                }
                for (let i = 0; i < this.danh_sach_trinh_do_dao_tao_chuyen_nganh_chinh.length; i++) {
                    this.danh_sach_trinh_do_dao_tao_chuyen_nganh_chinh[i].value = parseInt(this
                        .danh_sach_trinh_do_dao_tao_chuyen_nganh_chinh[i].value);
                }
                for (let i = 0; i < this.list_trang_thai.length; i++) {
                    this.list_trang_thai[i].value = parseInt(this.list_trang_thai[i].value);
                }
                for (let i = 0; i < this.list_loai_hinh_truong.length; i++) {
                    this.list_loai_hinh_truong[i].value = parseInt(this.list_loai_hinh_truong[i].value);
                }
                for (let i = 0; i < this.list_danh_gia_chuan_nghe_nghiep.length; i++) {
                    this.list_danh_gia_chuan_nghe_nghiep[i].value = parseInt(this.list_danh_gia_chuan_nghe_nghiep[i]
                        .value);
                }
                for (let i = 0; i < this.list_gioi_tinh.length; i++) {
                    this.list_gioi_tinh[i].value = parseInt(this.list_gioi_tinh[i]
                        .value);
                }
                for (let i = 0; i < this.danh_sach_trinh_do_giao_vien.length; i++) {
                    this.danh_sach_trinh_do_giao_vien[i].value = parseInt(this.danh_sach_trinh_do_giao_vien[i]
                        .value);
                }
                for (let i = 0; i < this.danh_sach_nhiem_vu_kiem_nhiem.length; i++) {
                    this.danh_sach_nhiem_vu_kiem_nhiem[i].value = parseInt(this.danh_sach_nhiem_vu_kiem_nhiem[i]
                        .value);
                }
            },
            removeEmptyElement() {
                this.list_trang_thai = this.list_trang_thai.filter(item => item.value !== "");
                this.list_gioi_tinh = this.list_gioi_tinh.filter(item => item.value !== "");
                this.list_loai_hinh_truong = this.list_loai_hinh_truong.filter(item => item.value !== "");
                this.list_loai_hop_dong_lam_viec = this.list_loai_hop_dong_lam_viec.filter(item => item.value !== "");
                this.list_trinh_do_chuyen_mon = this.list_trinh_do_chuyen_mon.filter(item => item.value !== "");
                this.list_khu_vuc = this.list_khu_vuc.filter(item => item.value !== "");
                this.list_loai_can_bo = this.list_loai_can_bo.filter(item => item.value !== "");
                this.list_danh_gia_chuan_nghe_nghiep = this.list_danh_gia_chuan_nghe_nghiep.filter(item => item
                    .value !== "");
                this.list_mon_day = this.list_mon_day.filter(item => item.value !== "");
                this.list_mon_day = this.list_mon_day.filter(item => item.value != 0);
                this.list_dan_toc = this.list_dan_toc.filter(item => item.value !== "");
                this.danh_sach_trinh_do_giao_vien = this.danh_sach_trinh_do_giao_vien.filter(item => item.value !== "");
                this.danh_sach_trinh_do_dao_tao = this.danh_sach_trinh_do_dao_tao.filter(item => item.value !== "");
                this.danh_sach_hinh_thuc_dao_tao = this.danh_sach_hinh_thuc_dao_tao.filter(item => item.value !== "");
                this.danh_sach_chuyen_nganh_dao_tao = this.danh_sach_chuyen_nganh_dao_tao.filter(item => item.value !==
                    "");
                this.danh_sach_trinh_do_tin_hoc = this.danh_sach_trinh_do_tin_hoc.filter(item => item.value !== "");
                this.danh_sach_trinh_do_ngoai_ngu = this.danh_sach_trinh_do_ngoai_ngu.filter(item => item.value !== "");
                this.danh_sach_trinh_do_ly_luan_chinh_tri = this.danh_sach_trinh_do_ly_luan_chinh_tri.filter(item =>
                    item.value !== "");
                this.danh_sach_trinh_do_quan_ly_nha_nuoc = this.danh_sach_trinh_do_quan_ly_nha_nuoc.filter(item => item
                    .value !== "");
                this.danh_sach_trinh_do_quan_ly_giao_duc = this.danh_sach_trinh_do_quan_ly_giao_duc.filter(item => item
                    .value !== "");
                this.danh_sach_ma_ngach = this.danh_sach_ma_ngach.filter(item => item.value !== "");
                this.danh_sach_nhom_lop = this.danh_sach_nhom_lop.filter(item => item.value !== "");
                this.danh_sach_nhiem_vu_kiem_nhiem = this.danh_sach_nhiem_vu_kiem_nhiem.filter(item => item.value !==
                    "");
                this.danh_sach_bac_luong = this.danh_sach_bac_luong.filter(item => item.value !== "");
                this.danh_sach_mon_ngoai_ngu = this.danh_sach_mon_ngoai_ngu.filter(item => item.value !== "");
                this.danh_sach_chuyen_nganh_dao_tao_chinh = this.danh_sach_chuyen_nganh_dao_tao_chinh.filter(item =>
                    item.value !== "");
                this.danh_sach_trinh_do_dao_tao_chuyen_nganh_chinh = this.danh_sach_trinh_do_dao_tao_chuyen_nganh_chinh
                    .filter(item => item.value !== "");
                this.danh_sach_danh_gia_vien_chuc = this.danh_sach_danh_gia_vien_chuc.filter(item => item.value !== "");
                this.danh_sach_trinh_do_van_hoa = this.danh_sach_trinh_do_van_hoa.filter(item => item.value !== "");
                this.danh_sach_thanh_phan_gia_dinh = this.danh_sach_thanh_phan_gia_dinh.filter(item => item.value !==
                    "");
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

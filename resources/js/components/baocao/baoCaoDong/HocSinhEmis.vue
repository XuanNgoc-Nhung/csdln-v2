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
                        <label>Nhóm máu</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.nhomMau" :placeholder="'Chọn'" filterable :data="danh_sach_nhom_mau"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Khuyết tật</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.khuyetTat" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Diện chính sách</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.maDtuongCsach" :placeholder="'Chọn'" filterable
                            :data="danh_sach_dien_chinh_sach" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Thành phần gia đình</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.tphanGdinh" :placeholder="'Chọn'" filterable
                            :data="danh_sach_thanh_phan_gia_dinh" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Diện ưu tiên</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.dtuongUuTien" :placeholder="'Chọn'" filterable
                            :data="danh_sach_doi_tuong_uu_tien" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Đội viên</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.doiVien" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Đoàn viên</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.doanVien" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Đảng viên</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.dangVien" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Loại khuyết tật</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.maLoaiKhuyetTat" :placeholder="'Chọn'" filterable
                            :data="danh_sach_loai_khuyet_tat" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Khu vực</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.maKhuVuc" :placeholder="'Chọn'" filterable :data="danh_sach_khu_vuc"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Loại nhập học</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.loaiNhapHoc" :placeholder="'Chọn'" filterable
                            :data="danh_sach_loai_nhap_hoc" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Học kỹ năng skss</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.hocKnsSkss" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Khối học</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.khoiHoc" :placeholder="'Chọn'" filterable :data="danh_sach_khoi_hoc"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Trạng thái</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.trangThai" :placeholder="'Chọn'" filterable
                            :data="danh_sach_trang_thai" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Hỗ trợ học tập</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.htHoTro" :placeholder="'Chọn'" filterable
                            :data="danh_sach_hinh_thuc_ho_tro" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Thời điểm rời trường</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.thoiDiemRoiTruong" :placeholder="'Chọn'" filterable
                            :data="danh_sach_thoi_diem_roi_truong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Kiểm tra sức khỏe dinh dưỡng <span class="red"><sup>*</sup></span></label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.kiemTraSucKhoeDinhDuong" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Tình trạng dinh dưỡng <span class="red"><sup>*</sup></span></label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.tinhTrangDinhDuong" :placeholder="'Chọn'" filterable
                            :data="danh_sach_tinh_trang_dinh_duong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Cha dân tộc </label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.chaDanToc" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Mẹ dân tộc</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.meDanToc" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Lý do thôi học</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" multiple collapseTags
                            v-model="noiDungTimKiem.maLyDoThoiHoc" :placeholder="'Chọn'" filterable
                            :data="danh_sach_ly_do_thoi_hoc" :fields="['name','value']" />
                    </el-col>

                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Học tiếng dân tộc</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hocSinhTiengDanToc" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Học song ngữ</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hocSongNgu" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Học bán trú dân nuôi</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hocSinhBanTruDanNuoi" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Học nội trú dân nuôi</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hocSinhNoiTruDanNuoi" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Khuyết tật không đánh giá</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.khuyetTatKhongDanhGia" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Hộ nghèo</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hoNgheo" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Hỗ trợ nhà ở</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.htroNhaO" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Được cấp tiền hàng tháng</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.capTienHangThang" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Được cấp gạo</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.capGao" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Học chương trình GD của Bộ</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hocCtgdCuaBo" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Được hỗ trợ chi phí học tập</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.htChiPhiHocTap" :placeholder="'Chọn'" filterable
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
                        <label>Học sinh PTDT bán trú</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.hocSinhPtdtBanTru" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Chuyển sang học nghề</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.chuyenSangHocNghe" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Biết bơi kỳ 1</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.bietBoiKy1" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Biết bơi kỳ 2</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.bietBoiKy2" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Mẹ bị bệnh trong thời kỳ mang thai</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.meBiBenhTatTrongTkMangThai" :placeholder="'Chọn'" filterable
                            :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Cận thị</label>
                        <eselect style="width:100%" @change="xoaTenBieuMauBaoCao" collapseTags
                            v-model="noiDungTimKiem.canThi" :placeholder="'Chọn'" filterable :data="list_co_khong"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" :lg="6">
                        <label>Chỉ số BMI</label>
                        <el-input clearable placeholder="Nhập..." v-model="noiDungTimKiem.chiSoBmi">
                            <template slot="prepend"> <i style="font-size:12px">C.nặng/(C.cao)<sup>2</sup></i>
                            </template>
                        </el-input>
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
                list_gioi_tinh: [],
                danh_sach_doi_tac: [],
                danh_sach_nhom_mau: [],
                danh_sach_dien_chinh_sach: [],
                danh_sach_thanh_phan_gia_dinh: [],
                danh_sach_doi_tuong_uu_tien: [],
                danh_sach_loai_khuyet_tat: [],
                danh_sach_khu_vuc: [],
                danh_sach_loai_nhap_hoc: [],
                danh_sach_khoi_hoc: [],
                danh_sach_trang_thai: [{
                        name: 'Đang học',
                        value: 1
                    },
                    {
                        name: 'Chuyển khỏi trường',
                        value: 3
                    },
                    {
                        name: 'Bỏ học',
                        value: 4
                    },
                ],
                danh_sach_hinh_thuc_ho_tro: [],
                danh_sach_thoi_diem_roi_truong: [],
                danh_sach_tinh_trang_dinh_duong: [],
                danh_sach_ly_do_thoi_hoc: [],
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
                        "name": "Nhóm máu",
                        "nameCol": "nhomMau",
                    }, {
                        "name": "Khuyết tật",
                        "nameCol": "khuyetTat",
                    }, {
                        "name": "Diện chính sách",
                        "nameCol": "maDtuongCsach",
                    },
                    {
                        "name": 'Thành phần gia đình',
                        "nameCol": 'tphanGdinh'
                    },
                    {
                        "name": 'Diện ưu tiên',
                        "nameCol": 'dtuongUuTien'
                    },
                    {
                        "name": 'Đội viên',
                        "nameCol": 'doiVien'
                    },
                    {
                        "name": 'Đoàn viên',
                        "nameCol": 'doanVien'
                    },
                    {
                        "name": 'Đảng viên',
                        "nameCol": 'dangVien'
                    },
                    {
                        "name": 'Loại khuyết tật',
                        "nameCol": 'maLoaiKhuyetTat'
                    },
                    {
                        "name": 'Khu vực',
                        "nameCol": 'maKhuVuc'
                    },
                    {
                        "name": 'Loại nhập học',
                        "nameCol": 'loaiNhapHoc'
                    },
                    {
                        "name": 'Học kỹ năng skss',
                        "nameCol": 'hocKnsSkss'
                    },
                    {
                        "name": 'Khối học',
                        "nameCol": 'khoiHoc'
                    },
                    {
                        "name": 'Trạng thái',
                        "nameCol": 'trangThai'
                    },
                    {
                        "name": 'Hỗ trợ học tập',
                        "nameCol": 'htHoTro'
                    },
                    {
                        "name": 'Thời điểm rời trường',
                        "nameCol": 'thoiDiemRoiTruong'
                    },
                    {
                        "name": 'Kiểm tra sức khỏe dinh dưỡng',
                        "nameCol": 'kiemTraSucKhoeDinhDuong'
                    },
                    {
                        "name": 'Tình trạng dinh dưỡng',
                        "nameCol": 'tinhTrangDinhDuong'
                    },
                    {
                        "name": 'Cha dân tộc',
                        "nameCol": 'chaDanToc'
                    },
                    {
                        "name": 'Mẹ dân tộc',
                        "nameCol": 'meDanToc'
                    },

                    {
                        "name": 'Lý do thôi học',
                        "nameCol": 'maLyDoThoiHoc'
                    },
                    {
                        "name": 'Học tiếng dân tộc',
                        "nameCol": 'hocSinhTiengDanToc'
                    },
                    {
                        "name": 'Học song ngữ',
                        "nameCol": 'hocSongNgu'
                    },
                    {
                        "name": 'Học bán trú dân nuôi',
                        "nameCol": 'hocSinhBanTruDanNuoi'
                    },
                    {
                        "name": 'Học nội trú dân nuôi',
                        "nameCol": 'hocSinhNoiTruDanNuoi'
                    },
                    {
                        "name": 'Khuyết tật không đánh giá',
                        "nameCol": 'khuyetTatKhongDanhGia'
                    },
                    {
                        "name": 'Hộ nghèo',
                        "nameCol": 'hoNgheo'
                    },
                    {
                        "name": 'Được hỗ trợ nhà ở',
                        "nameCol": 'htroNhaO'
                    },
                    {
                        "name": 'Được cấp tiền hàng tháng',
                        "nameCol": 'capTienHangThang'
                    },
                    {
                        "name": 'Được cấp gạo',
                        "nameCol": 'capGao'
                    },
                    {
                        "name": 'Học chương trình GD của bộ',
                        "nameCol": 'hocCtgdCuaBo'
                    },
                    {
                        "name": 'Được hỗ trợ chi phí học tập',
                        "nameCol": 'htChiPhiHocTap'
                    },
                    {
                        "name": 'Học sinh bán trú',
                        "nameCol": 'hocSinhBanTru'
                    },
                    {
                        "name": 'Học sinh nội trú',
                        "nameCol": 'hocSinhNoiTru'
                    },
                    {
                        "name": 'Học sinh PTDT Bán trú',
                        "nameCol": 'hocSinhPtdtBanTru'
                    },
                    {
                        "name": 'Chuyển sang học nghề',
                        "nameCol": 'chuyenSangHocNghe'
                    },
                    {
                        "name": 'Biết bơi kỳ 1',
                        "nameCol": 'bietBoiKy1'
                    },
                    {
                        "name": 'Biết bơi kỳ 2',
                        "nameCol": 'bietBoiKy2'
                    },
                    {
                        "name": 'Mẹ bị bệnh trong thời kỳ mang thai',
                        "nameCol": 'meBiBenhTatTrongTkMangThai'
                    },
                    {
                        "name": 'Cận thị',
                        "nameCol": 'canThi'
                    },
                    {
                        "name": 'Chỉ số BMI',
                        "nameCol": 'chiSoBmi'
                    }
                ],
                noiDungTimKiem: {
                    maDonVi: [],
                    namHoc: '',
                    maTruongHoc: [],
                    nhomMau: [],
                    khuyetTat: [],
                    maDtuongCsach: [],
                    tphanGdinh: [],
                    dtuongUuTien: [],
                    doiVien: [],
                    doanVien: [],
                    dangVien: [],
                    maLoaiKhuyetTat: [],
                    maKhuVuc: [],
                    loaiNhapHoc: [],
                    hocKnsSkss: [],
                    khoiHoc: [],
                    trangThai: [],
                    htHoTro: [],
                    thoiDiemRoiTruong: [],
                    kiemTraSucKhoeDinhDuong: [],
                    tinhTrangDinhDuong: [],
                    chaDanToc: '',
                    meDanToc: '',
                    maLyDoThoiHoc: [],
                    hocSinhTiengDanToc: '',
                    hocSongNgu: '',
                    hocSinhBanTruDanNuoi: '',
                    hocSinhNoiTruDanNuoi: '',
                    khuyetTatKhongDanhGia: '',
                    hoNgheo: '',
                    htroNhaO: '',
                    capTienHangThang: '',
                    capGao: '',
                    hocCtgdCuaBo: '',
                    htChiPhiHocTap: '',
                    hocSinhBanTru: '',
                    hocSinhNoiTru: '',
                    hocSinhPtdtBanTru: '',
                    chuyenSangHocNghe: '',
                    bietBoiKy1: '',
                    bietBoiKy2: '',
                    meBiBenhTatTrongTkMangThai: '',
                    canThi: '',
                    chiSoBmi: '',
                },
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
                let url = "/xuat-excel-bao-cao-dong-hoc-sinh";
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
                    fileName = this.thongtin.ma_so + '_Bao_cao_can_bo_' + currentDate.getDate() + thangNay +
                        (currentDate.getFullYear());
                    FileSaver.saveAs(data.data.file, fileName);
                });
            },
            XacNhanTaiXuong() {
                this.ganLaiViTri();
                if (this.NoiDungHienThi.length == 0) {
                    this.thongBao("error", "Thiếu tiêu chí báo cáo")
                    return;
                }
                let coNamHoc = false;
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
                                    console.log('valueSearch')
                                    console.log(valueSearch)
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
                            "type": 2,
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
                    "type": 2
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
                rest_api.post("/csdlgd-report-fetch/BaoCaoHocSinh/sreach", params, (data) => {
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
                if (this.noiDungTimKiem.chaDanToc !== '') {
                    let obj = {
                        name: "Cha dân tộc",
                        nameSreach: "chaDanToc",
                        value: Boolean(this.noiDungTimKiem.chaDanToc)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.meDanToc !== '') {
                    let obj = {
                        name: "Mẹ dân tộc",
                        nameSreach: "meDanToc",
                        value: Boolean(this.noiDungTimKiem.meDanToc)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hocSinhTiengDanToc !== '') {
                    let obj = {
                        name: "Học tiếng dân tộc",
                        nameSreach: "hocSinhTiengDanToc",
                        value: Boolean(this.noiDungTimKiem.hocSinhTiengDanToc)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hocSongNgu !== '') {
                    let obj = {
                        name: "Học song ngữ",
                        nameSreach: "hocSongNgu",
                        value: Boolean(this.noiDungTimKiem.hocSongNgu)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hocSinhBanTruDanNuoi !== '') {
                    let obj = {
                        name: "Học bán trú dân nuôi",
                        nameSreach: "hocSinhBanTruDanNuoi",
                        value: Boolean(this.noiDungTimKiem.hocSinhBanTruDanNuoi)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hocSinhNoiTruDanNuoi !== '') {
                    let obj = {
                        name: "Học nội trú dân nuôi",
                        nameSreach: "hocSinhNoiTruDanNuoi",
                        value: Boolean(this.noiDungTimKiem.hocSinhNoiTruDanNuoi)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.khuyetTatKhongDanhGia !== '') {
                    let obj = {
                        name: "Khuyết tật không đánh giá",
                        nameSreach: "khuyetTatKhongDanhGia",
                        value: Boolean(this.noiDungTimKiem.khuyetTatKhongDanhGia)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hoNgheo !== '') {
                    let obj = {
                        name: "Hộ nghèo",
                        nameSreach: "hoNgheo",
                        value: Boolean(this.noiDungTimKiem.hoNgheo)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.htroNhaO !== '') {
                    let obj = {
                        name: "Hỗ trợ nhà ở",
                        nameSreach: "htroNhaO",
                        value: Boolean(this.noiDungTimKiem.htroNhaO)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.capTienHangThang !== '') {
                    let obj = {
                        name: "Được cấp tiền hàng tháng",
                        nameSreach: "capTienHangThang",
                        value: Boolean(this.noiDungTimKiem.capTienHangThang)
                    }
                    data.push(obj);
                }


                if (this.noiDungTimKiem.capGao !== '') {
                    let obj = {
                        name: "Được cấp gạo",
                        nameSreach: "capGao",
                        value: Boolean(this.noiDungTimKiem.capGao)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hocCtgdCuaBo !== '') {
                    let obj = {
                        name: "Học chương trình GD của Bộ",
                        nameSreach: "hocCtgdCuaBo",
                        value: Boolean(this.noiDungTimKiem.hocCtgdCuaBo)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.htChiPhiHocTap !== '') {
                    let obj = {
                        name: "Được hỗ trợ chi phí học tập",
                        nameSreach: "htChiPhiHocTap",
                        value: Boolean(this.noiDungTimKiem.htChiPhiHocTap)
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
                if (this.noiDungTimKiem.hocSinhPtdtBanTru !== '') {
                    let obj = {
                        name: "Học sinh PTDT bán trú",
                        nameSreach: "hocSinhPtdtBanTru",
                        value: Boolean(this.noiDungTimKiem.hocSinhPtdtBanTru)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.chuyenSangHocNghe !== '') {
                    let obj = {
                        name: "Chuyển sang học nghề",
                        nameSreach: "chuyenSangHocNghe",
                        value: Boolean(this.noiDungTimKiem.chuyenSangHocNghe)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.bietBoiKy1 !== '') {
                    let obj = {
                        name: "Biết bơi kỳ 1",
                        nameSreach: "bietBoiKy1",
                        value: Boolean(this.noiDungTimKiem.bietBoiKy1)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.bietBoiKy2 !== '') {
                    let obj = {
                        name: "Biết bơi kỳ 2",
                        nameSreach: "bietBoiKy2",
                        value: Boolean(this.noiDungTimKiem.bietBoiKy2)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.meBiBenhTatTrongTkMangThai !== '') {
                    let obj = {
                        name: "Mẹ bị bệnh trong thời kỳ mang thai",
                        nameSreach: "meBiBenhTatTrongTkMangThai",
                        value: Boolean(this.noiDungTimKiem.meBiBenhTatTrongTkMangThai)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.canThi !== '') {
                    let obj = {
                        name: "Cận thị",
                        nameSreach: "canThi",
                        value: Boolean(this.noiDungTimKiem.canThi)
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.chiSoBmi !== '') {
                    let obj = {
                        name: "Chỉ số BMI",
                        nameSreach: "chiSoBmi",
                        value: parseFloat(this.noiDungTimKiem.chiSoBmi)
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
                if (this.noiDungTimKiem.nhomMau && this.noiDungTimKiem.nhomMau.length > 0) {
                    let obj = {
                        name: "Nhóm máu",
                        nameSreach: "nhomMau",
                        values: this.noiDungTimKiem.nhomMau
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.khuyetTat && this.noiDungTimKiem.khuyetTat.length > 0) {
                    let obj = {
                        name: "Khuyết tật",
                        nameSreach: "khuyetTat",
                        values: this.noiDungTimKiem.khuyetTat
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.maDtuongCsach && this.noiDungTimKiem.maDtuongCsach.length > 0) {
                    let obj = {
                        name: "Diện chính sách",
                        nameSreach: "maDtuongCsach",
                        values: this.noiDungTimKiem.maDtuongCsach
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.tphanGdinh && this.noiDungTimKiem.tphanGdinh.length > 0) {
                    let obj = {
                        name: "Thành phần gia đình",
                        nameSreach: "tphanGdinh",
                        values: this.noiDungTimKiem.tphanGdinh
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.dtuongUuTien && this.noiDungTimKiem.dtuongUuTien.length > 0) {
                    let obj = {
                        name: "Diện ưu tiên",
                        nameSreach: "dtuongUuTien",
                        values: this.noiDungTimKiem.dtuongUuTien
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.doiVien && this.noiDungTimKiem.doiVien.length > 0) {
                    let obj = {
                        name: "Đội viên",
                        nameSreach: "doiVien",
                        values: this.noiDungTimKiem.doiVien
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.doanVien && this.noiDungTimKiem.doanVien.length > 0) {
                    let obj = {
                        name: "Đoàn viên",
                        nameSreach: "doanVien",
                        values: this.noiDungTimKiem.doanVien
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.dangVien && this.noiDungTimKiem.dangVien.length > 0) {
                    let obj = {
                        name: "Đảng viên",
                        nameSreach: "dangVien",
                        values: this.noiDungTimKiem.dangVien
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.maLoaiKhuyetTat && this.noiDungTimKiem.maLoaiKhuyetTat.length > 0) {
                    let obj = {
                        name: "Loại khuyết tật",
                        nameSreach: "maLoaiKhuyetTat",
                        values: this.noiDungTimKiem.maLoaiKhuyetTat
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.maKhuVuc && this.noiDungTimKiem.maKhuVuc.length > 0) {
                    let obj = {
                        name: "Khu vực",
                        nameSreach: "maKhuVuc",
                        values: this.noiDungTimKiem.maKhuVuc
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.loaiNhapHoc && this.noiDungTimKiem.loaiNhapHoc.length > 0) {
                    let obj = {
                        name: "Loại nhập học",
                        nameSreach: "loaiNhapHoc",
                        values: this.noiDungTimKiem.loaiNhapHoc
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.hocKnsSkss && this.noiDungTimKiem.hocKnsSkss.length > 0) {
                    let obj = {
                        name: "Học kỹ năng skss",
                        nameSreach: "hocKnsSkss",
                        values: this.noiDungTimKiem.hocKnsSkss
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.khoiHoc && this.noiDungTimKiem.khoiHoc.length > 0) {
                    let obj = {
                        name: "Khối học",
                        nameSreach: "khoiHoc",
                        values: this.noiDungTimKiem.khoiHoc
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.trangThai && this.noiDungTimKiem.trangThai.length > 0) {
                    let obj = {
                        name: "Trạng thái",
                        nameSreach: "trangThai",
                        values: this.noiDungTimKiem.trangThai
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.htHoTro && this.noiDungTimKiem.htHoTro.length > 0) {
                    let obj = {
                        name: "Hỗ trợ học tập",
                        nameSreach: "htHoTro",
                        values: this.noiDungTimKiem.htHoTro
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.thoiDiemRoiTruong && this.noiDungTimKiem.thoiDiemRoiTruong.length > 0) {
                    let obj = {
                        name: "Thời điểm rời trường",
                        nameSreach: "thoiDiemRoiTruong",
                        values: this.noiDungTimKiem.thoiDiemRoiTruong
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.kiemTraSucKhoeDinhDuong && this.noiDungTimKiem.kiemTraSucKhoeDinhDuong.length >
                    0) {
                    let obj = {
                        name: "Kiểm tra sức khỏe dinh dưỡng",
                        nameSreach: "kiemTraSucKhoeDinhDuong",
                        values: this.noiDungTimKiem.kiemTraSucKhoeDinhDuong
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.tinhTrangDinhDuong && this.noiDungTimKiem.tinhTrangDinhDuong.length > 0) {
                    let obj = {
                        name: "Tình trạng dinh dưỡng",
                        nameSreach: "tinhTrangDinhDuong",
                        values: this.noiDungTimKiem.tinhTrangDinhDuong
                    }
                    data.push(obj);
                }
                if (this.noiDungTimKiem.maLyDoThoiHoc && this.noiDungTimKiem.maLyDoThoiHoc.length > 0) {
                    let obj = {
                        name: "Lý do thôi học",
                        nameSreach: "maLyDoThoiHoc",
                        values: this.noiDungTimKiem.maLyDoThoiHoc
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
                let tmp = localStorage["danh_sach_gioi_tinh_sme"];
                if (tmp) {
                    this.list_gioi_tinh = JSON.parse(localStorage["danh_sach_gioi_tinh_sme"]);
                    this.danh_sach_nhom_mau = JSON.parse(localStorage["danh_sach_nhom_mau_sme"]);
                    this.danh_sach_dien_chinh_sach = JSON.parse(localStorage["danh_sach_doi_tuong_chinh_sach_sme"]);
                    this.danh_sach_thanh_phan_gia_dinh = JSON.parse(localStorage["danh_sach_thanh_phan_gia_dinh_sme"]);
                    this.danh_sach_doi_tuong_uu_tien = JSON.parse(localStorage["danh_sach_doi_tuong_uu_tien_sme"]);
                    this.danh_sach_loai_khuyet_tat = JSON.parse(localStorage["danh_sach_loai_khuyet_tat_sme"]);
                    this.danh_sach_khu_vuc = JSON.parse(localStorage["danh_sach_khu_vuc_sme"]);
                    this.danh_sach_loai_nhap_hoc = JSON.parse(localStorage["danh_sach_loai_nhap_hoc_sme"]);
                    this.danh_sach_khoi_hoc = JSON.parse(localStorage["danh_sach_khoi_sme"]);
                    this.danh_sach_hinh_thuc_ho_tro = JSON.parse(localStorage[
                        "danh_sach_hinh_thuc_hoc_tro_moet_code_sme"]);
                    this.danh_sach_thoi_diem_roi_truong = JSON.parse(localStorage[
                        "danh_sach_thoi_diem_roi_truong_sme"]);
                    this.danh_sach_tinh_trang_dinh_duong = JSON.parse(localStorage[
                        "danh_sach_tinh_trang_dinh_duong_sme"]);
                    this.danh_sach_ly_do_thoi_hoc = JSON.parse(localStorage["danh_sach_ly_do_thoi_hoc_sme"]);
                }
                this.removeEmptyElement();
                this.mapIntValue();
                this.removeDuplicateArrray();
                this.sapXepMang();
            },
            sapXepMang() {
                this.danh_sach_khoi_hoc.sort((a, b) => (a.value > b.value) ? 1 : -1)
                this.danh_sach_tinh_trang_dinh_duong.sort((a, b) => (a.value > b.value) ? 1 : -1)
            },
            uniqByKeepFirst(a, key) {
                let seen = new Set();
                return a.filter(item => {
                    let k = key(item);
                    return seen.has(k) ? false : seen.add(k);
                });
            },
            removeDuplicateArrray() {
                this.list_gioi_tinh = [...new Map(this.list_gioi_tinh.map(item => [JSON.stringify(item), item]))
                    .values()
                ];
                this.danh_sach_khoi_hoc = this.uniqByKeepFirst(this.danh_sach_khoi_hoc, item => item.value);
            },
            mapIntValue() {
                for (let i = 0; i < this.danh_sach_thoi_diem_roi_truong.length; i++) {
                    this.danh_sach_thoi_diem_roi_truong[i].value = parseInt(this.danh_sach_thoi_diem_roi_truong[i]
                        .value);
                }
                for (let i = 0; i < this.danh_sach_hinh_thuc_ho_tro.length; i++) {
                    this.danh_sach_hinh_thuc_ho_tro[i].value = parseInt(this.danh_sach_hinh_thuc_ho_tro[i].value);
                }
                for (let i = 0; i < this.danh_sach_khoi_hoc.length; i++) {
                    this.danh_sach_khoi_hoc[i].value = parseInt(this.danh_sach_khoi_hoc[i].value);
                }
                for (let i = 0; i < this.danh_sach_loai_nhap_hoc.length; i++) {
                    this.danh_sach_loai_nhap_hoc[i].value = parseInt(this.danh_sach_loai_nhap_hoc[i].value);
                }
                for (let i = 0; i < this.danh_sach_nhom_mau.length; i++) {
                    this.danh_sach_nhom_mau[i].value = parseInt(this.danh_sach_nhom_mau[i].value);
                }
                for (let i = 0; i < this.danh_sach_thanh_phan_gia_dinh.length; i++) {
                    this.danh_sach_thanh_phan_gia_dinh[i].value = parseInt(this.danh_sach_thanh_phan_gia_dinh[i].value);
                }
                for (let i = 0; i < this.danh_sach_doi_tuong_uu_tien.length; i++) {
                    this.danh_sach_doi_tuong_uu_tien[i].value = parseInt(this.danh_sach_doi_tuong_uu_tien[i].value);
                }
            },
            removeEmptyElement() {
                this.list_gioi_tinh = this.list_gioi_tinh.filter(item => item.value !== "");
                this.danh_sach_nhom_mau = this.danh_sach_nhom_mau.filter(item => item.value !== "");
                this.danh_sach_dien_chinh_sach = this.danh_sach_dien_chinh_sach.filter(item => item.value !== "");
                this.danh_sach_thanh_phan_gia_dinh = this.danh_sach_thanh_phan_gia_dinh.filter(item => item.value !==
                    "");
                this.danh_sach_doi_tuong_uu_tien = this.danh_sach_doi_tuong_uu_tien.filter(item => item.value !== "");
                this.danh_sach_loai_khuyet_tat = this.danh_sach_loai_khuyet_tat.filter(item => item.value !== "");
                this.danh_sach_khu_vuc = this.danh_sach_khu_vuc.filter(item => item.value !== "");
                this.danh_sach_loai_nhap_hoc = this.danh_sach_loai_nhap_hoc.filter(item => item.value !== "");
                this.danh_sach_khoi_hoc = this.danh_sach_khoi_hoc.filter(item => item.value !== "");
                this.danh_sach_hinh_thuc_ho_tro = this.danh_sach_hinh_thuc_ho_tro.filter(item => item
                    .value); // Bỏ cả các phần tử có value là null
                this.danh_sach_thoi_diem_roi_truong = this.danh_sach_thoi_diem_roi_truong.filter(item => item.value !==
                    "");
                this.danh_sach_tinh_trang_dinh_duong = this.danh_sach_tinh_trang_dinh_duong.filter(item => item
                    .value !== "");
                this.danh_sach_ly_do_thoi_hoc = this.danh_sach_ly_do_thoi_hoc.filter(item => item.value !== "");
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

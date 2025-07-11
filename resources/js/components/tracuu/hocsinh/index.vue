<template>
    <!-- bắt đầu template -->
    <div>
        <Breadcrumb :menu="'Tra cứu'" :desc="'Tra cứu học sinh'" />
        <div class="card-bieu-do">
            <el-form ref="ruleForm">
                <el-row :gutter="24" style="margin-bottom:0px " class="">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :sm="24" :md="12" v-if="namHoc<2025">
                        <label class="typo__label">Đơn vị</label>
                        <div>
                            <eselect style="width:100%" :disabled="thongtin.role>3" multiple collapseTags
                                v-model="ds_don_vi" @change="ChonDonVi" :placeholder="'Chọn'" filterable
                                :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                        </div>
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <div>
                            <label class="typo__label">Cấp học</label>
                            <div>
                                <eselect style="width:100%" multiple collapseTags :disabled="thongtin.role==5"
                                    v-model="ds_cap_hoc" @change="ChonCapHoc" :placeholder="'Chọn'" filterable
                                    :data="list_cap_hoc" :fields="['name','id']" />
                            </div>
                        </div>
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Năm học <span class="red">*</span></label>
                        <eselect style="width:100%" @change="chonNamHoc()" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                 :data="list_nam_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="24" :md="12">
                        <div>
                            <label class="typo__label">Trường học</label>
                            <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags
                                v-model="ds_truong_hoc" :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                :fields="['tenTruongHoc','maTruongHoc']" />
                        </div>
                    </el-col>

                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Khối học/Nhóm lớp</label>
                        <eselect style="width:100%" multiple collapseTags v-model="ds_khoi_hoc" :placeholder="'Chọn'"
                            filterable :data="list_khoi_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Tên lớp học</label>
                        <el-input v-model="tenLopHoc" v-on:keyup.enter="getListStudent" clearable
                            @change="tenLopHoc = tenLopHoc.trim()" placeholder="Nhập..." />
                    </el-col>

                    <el-col :sm="12" :md="6">
                        <label>Từ khóa tìm kiếm</label>
                        <el-input v-model="tuKhoa" v-on:keyup.enter="getListStudent" clearable
                            @change="tuKhoa=tuKhoa.trim()" placeholder="Tên/mã/số CMND,..." />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label>Mã định danh công dân</label>
                        <el-input v-model="maCuDan" v-on:keyup.enter="getListStudent" clearable
                            @change="maCuDan = maCuDan.trim()" placeholder="Nhập..." />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label>Trạng thái</label>
                        <eselect style="width:100%" collapseTags v-model="trangThai" :placeholder="'Chọn'" filterable
                            :data="list_trang_thai_hoc_sinh" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label>Giới tính</label>
                        <eselect style="width:100%" collapseTags v-model="gioiTinh" :placeholder="'Chọn'" filterable
                            :data="list_gioi_tinh" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Nội dung hiển thị <span class="red">*</span></label>
                        <div>
                            <eselect style="width:100%" multiple collapseTags v-model="danhSachNoiDungHienThi"
                                @input="chonNoiDungHienThi" :placeholder="'Chọn'" filterable
                                :data="list_noi_dung_hien_thi" :fields="['name','key']" />
                        </div>
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Tìm kiếm nâng cao</label>
                        <eselect style="width:100%" multiple collapseTags v-model="danhSachTimKiemNangCao"
                            :placeholder="'Chọn'" filterable :data="list_tim_kiem_nang_cao"
                            :fields="['name','value']" />
                    </el-col>
                    <template v-if="danhSachTimKiemNangCao.length>0">
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.ngaySinh">
                            <label>Ngày sinh</label>
                            <!-- <date-picker :config="configDatePicker" placeholder="Chọn" v-model="nangCao.ngaySinh">
                        </date-picker> -->
                            <date-picker v-model="nangCao.ngaySinh" placeholder="Chọn ngày" valueType="format"
                                value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                            </date-picker>
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.noiSinh">
                            <label>Nơi sinh</label>
                            <el-input clearable @change="nangCao.noiSinh = nangCao.noiSinh.trim()" placeholder="Nhập..."
                                v-model="nangCao.noiSinh">
                            </el-input>
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maDanToc">
                            <label>Dân tộc</label>
                            <eselect style="width:100%" multiple collapseTags v-model="nangCao.maDanToc"
                                :placeholder="'Chọn'" filterable :data="list_dan_toc" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maTonGiao">
                            <label>Tôn giáo</label>
                            <eselect style="width:100%" multiple collapseTags v-model="nangCao.maTonGiao"
                                :placeholder="'Chọn'" filterable :data="list_ton_giao" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maLopHocCn">
                            <label>Tên lớp học</label>
                            <el-input type="text" clearable @change="nangCao.maLopHocCn = nangCao.maLopHocCn.trim()"
                                v-model="nangCao.maLopHocCn" placeholder="Nhập..." />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.dchiThtru">
                            <label>Địa chỉ thường trú</label>
                            <el-input clearable placeholder="Nhập..."
                                @change="nangCao.dchiThtru = nangCao.dchiThtru.trim()" v-model="nangCao.dchiThtru">
                            </el-input>
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.dchiTmtru">
                            <label>Địa chỉ tạm trú</label>
                            <el-input clearable placeholder="Nhập..." v-model="nangCao.dchiTmtru">
                            </el-input>
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maKhuVuc">
                            <label>Khu vực</label>
                            <eselect style="width:100%" multiple collapseTags v-model="nangCao.list_khu_vuc"
                                :placeholder="'Chọn'" filterable :data="list_khu_vuc" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.gioiTinh">
                            <label>Giới tính</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.gioiTinh" :placeholder="'Chọn'"
                                filterable :data="list_gioi_tinh" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.loaiNhapHoc">
                            <label>Loại nhập học</label>
                            <el-select v-model="nangCao.loaiNhapHoc" filterable collapse-tags placeholder="Chọn">
                                <el-option v-for="item in list_loai_nhap_hoc" :key="item.value" :label="item.name"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maLyDoThoiHoc">
                            <label>Lý do thôi học</label>
                            <eselect style="width:100%" multiple collapseTags v-model="nangCao.maLyDoThoiHoc"
                                :placeholder="'Chọn'" filterable :data="list_thoi_hoc" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.doiVien">
                            <label>Đội viên</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.doiVien" :placeholder="'Chọn'"
                                filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.doanVien">
                            <label>Đoàn viên</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.doanVien" :placeholder="'Chọn'"
                                filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.khuyetTat">
                            <label>Khuyết tật</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.khuyetTat" :placeholder="'Chọn'"
                                filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.lopGhep">
                            <label>Lớp ghép</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.lopGhep" :placeholder="'Chọn'"
                                filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.lopChuyen">
                            <label>Lớp chuyên</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.lopChuyen" :placeholder="'Chọn'"
                                filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.danTocThieuSo">
                            <label>Dân tộc thiểu số</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.danTocThieuSo"
                                :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.hoNgheo">
                            <label>Hộ nghèo</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.hoNgheo" :placeholder="'Chọn'"
                                filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.moetCode">
                            <label>Mã định danh bộ GD&ĐT</label>
                            <el-input clearable @change="nangCao.moetCode = nangCao.moetCode" placeholder="Nhập..."
                                v-model="nangCao.moetCode">
                            </el-input>
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maDtuongCsach">
                            <label>Đối tượng chính sách</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.maDtuongCsach"
                                :placeholder="'Chọn'" filterable :data="danh_sach_doi_tuong_chinh_sach_sme"
                                :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.kiemTraSucKhoeDinhDuong">
                            <label>Kiểm tra sức khoẻ dinh dưỡng</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.kiemTraSucKhoeDinhDuong"
                                :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.isKhamSkDky">
                            <label>Khám sức khoẻ định kỳ</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.isKhamSkDky" :placeholder="'Chọn'"
                                filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.isSuyDduongTheTcoi">
                            <label>Suy dinh dưỡng thể thấp còi</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.isSuyDduongTheTcoi"
                                :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.isTheoDoiBdoCcao">
                            <label>Theo dõi biểu đồ chiều cao</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.isTheoDoiBdoCcao"
                                :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.isTheoDoiBdoCnang">
                            <label>Theo dõi biểu đồ cân nặng</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.isTheoDoiBdoCnang"
                                :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.benhMat">
                            <label>Bệnh về mắt</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.benhMat" :placeholder="'Chọn'"
                                filterable :data="list_benh_ve_mat" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.bietBoiKy1">
                            <label>Biết bơi kỳ 1</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.bietBoiKy1" :placeholder="'Chọn'"
                                filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.bietBoiKy2">
                            <label>Biết bơi kỳ 2</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.bietBoiKy2" :placeholder="'Chọn'"
                                filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.hocSinhBanTru">
                            <label>Học sinh bán trú</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.hocSinhBanTru"
                                :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.noiChuyenDi">
                            <label>Nơi chuyển đi</label>
                            <el-select v-model="nangCao.noiChuyenDi" filterable
                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="(item,i) in danh_sach_chuyen_di" :key="i"
                                    :label="item.name" :value="item.value">
                                </el-option>
                            </el-select>
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.isSuyDduongTheNheCan">
                            <label>Suy dinh dưỡng thể nhẹ cân</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.isSuyDduongTheNheCan"
                                :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.isSuyDduongTheCoiCoc">
                            <label>Suy dinh dưỡng thể còi cọc</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.isSuyDduongTheCoiCoc"
                                :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                    </template>
                    <el-col :span="24" class="text-center">
                        <el-button class="bt-chinh" type="success" size="mini" @click.prevent="checkTruocKhiTim()">Tìm
                            kiếm
                        </el-button>

                    </el-col>
                </el-row>
            </el-form>
        </div>
        <div ref="scrollToMe"></div>
        <div class="card-bieu-do">
            <el-row :gutter="24">

                <!-- <el-col :span="12" class="">
                    <label class="table-name">Danh sách học sinh</label>
                </el-col>
                <el-col :span="12">
                    <div class="text-right" style="padding-bottom:5px">
                        <span style="padding-right:20px" v-if="lsDelete.length"><b>Đã chọn
                                {{ lsDelete.length }} bản ghi</b></span>
                        <el-tooltip content="Đẩy lại dữ liệu lên bộ" placement="top">
                            <el-button class="bt-phu" v-if="lsDelete.length" plain size="mini"
                                @click.prevent="dayLenBo()" type="primary">Đẩy dữ
                                liệu
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Xóa dữ liệu học sinh" placement="top"
                            v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==83||thongtin.ma_so==34||thongtin.ma_so==20||true">
                            <el-button class="bt-xoa" plain v-if="lsDelete.length" :disabled="thongtin.role>4&&false"
                                size="mini" @click.prevent="DeleteStudent()" type="danger">Xóa
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Xóa mã định danh" placement="top"
                            v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==34||thongtin.ma_so==20||true">
                            <el-button class="bt-xoa" plain v-if="lsDelete.length" :disabled="thongtin.role>4&&false"
                                size="mini" @click.prevent="DeleteMoetCode()" type="danger">Xóa mã định danh Bộ
                                GĐ&ĐT
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Xuất dữ liệu" placement="top">
                            <el-button class="bt-chinh" v-bind:disabled="list_hocsinh.length==0" type="success"
                                size="mini" @click.prevent="xuatDuLieuHocSinh">Xuất
                                Excel
                            </el-button>
                        </el-tooltip>
                    </div>
                </el-col> -->

                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <label class="table-name">Danh sách học sinh</label>
                        <div class="text-right">
                            <span style="padding-right:20px" v-if="lsDelete.length"><b>Đã chọn
                                {{ lsDelete.length }} bản ghi</b></span>
                        <el-tooltip content="Đẩy lại dữ liệu lên bộ" placement="top">
                            <el-button class="bt-phu" v-if="lsDelete.length" plain size="mini"
                                @click.prevent="dayLenBo()" type="primary">Đẩy dữ
                                liệu
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Xóa dữ liệu học sinh" placement="top"
                            v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==83||thongtin.ma_so==34||thongtin.ma_so==20||true">
                            <el-button class="bt-xoa" plain v-if="lsDelete.length" :disabled="thongtin.role>4&&false"
                                size="mini" @click.prevent="DeleteStudent()" type="danger">Xóa
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Xóa mã định danh" placement="top"
                            v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==34||thongtin.ma_so==20||true">
                            <el-button class="bt-xoa" plain v-if="lsDelete.length" :disabled="thongtin.role>4&&false"
                                size="mini" @click.prevent="DeleteMoetCode()" type="danger">Xóa mã định danh Bộ
                                GĐ&ĐT
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Xuất dữ liệu" placement="top">
                            <el-button class="bt-chinh" v-bind:disabled="list_hocsinh.length==0" type="success"
                                size="mini" @click.prevent="xuatDuLieuHocSinh">Xuất
                                Excel
                            </el-button>
                        </el-tooltip>
                        </div>
                    </div>
                </el-col>

                <el-col :span="24">
                    <el-table
                            :data="list_hocsinh"
                            border
                            style="width: 100%"
                            empty-text="Không có bản ghi nào"
                            max-height="600"
                    >
                        <!-- Cột checkbox -->
                        <el-table-column
                                fixed="left"
                                align="center"
                                width="50"
                        >
                            <template #header>
                                <input type="checkbox" v-model="slectAll" @change="chonTatCa" />
                            </template>
                            <template #default="{ row }">
                                <input type="checkbox" v-model="lsDelete" :value="row.hocSinhTheoNamId" />
                            </template>
                        </el-table-column>

                        <!-- Cột STT -->
                        <el-table-column
                                fixed="left"
                                align="center"
                                label="STT"
                                :width="start > 9999 ? 70 : 60"
                        >
                            <template #default="{ $index }">
                                {{ (currentPage - 1) * limit + $index + 1 }}
                            </template>
                        </el-table-column>

                        <!-- Cột Thao tác -->
                        <el-table-column
                                fixed="right"
                                align="center"
                                label="Thao tác"
                                width="90"
                        >
                            <template #default="{ row }">
                                <el-tooltip content="Sửa" placement="top">
                                    <i @click.prevent="ShowUpdate(row.hocSinhTheoNamId)" class="el-icon-edit"></i>
                                </el-tooltip>
                            </template>
                        </el-table-column>

                        <!-- Các cột động -->
                        <el-table-column
                                v-for="(col, index) in cotHienThi"
                                :key="index"
                                :fixed="col.fixed || false"
                                :align="col.align || 'left'"
                                :min-width="columnWidths[col.key]"
                                :label="col.name"
                        >
                            <template #default="scope">
                                <template v-if="col.key === 'maHocSinh' || col.key === 'hoTen'">
                                    <a href="#" @click.prevent="showInFo(scope.row['hocSinhTheoNamId'])">
                                        {{ scope.row[col.key] }}
                                    </a>
                                </template>
                                <template v-else-if="col.key == 'trangThai'">
                                    <p v-bind:style="{ backgroundColor: getBackGround(scope.row['trangThaiInt']) }"
                                       class="bd-stt">{{ scope.row[col.key] }}</p>

                                </template>
                                <template v-else>
                                    <p>{{ scope.row[col.key] }}</p>
                                </template>
                            </template>
                        </el-table-column>

                    </el-table>


<!--                    <div class="table-responsive">-->
<!--                        <table class="table table-bordered table-striped table-hover table-fixed">-->
<!--                            <thead>-->
<!--                                <tr style="background:#e4ebf5">-->
<!--                                    <th class="cg fixed-column fixedCol1">-->
<!--                                        <input type="checkbox" v-model="slectAll" @change="chonTatCa">-->
<!--                                    </th>-->
<!--                                    <th class="cg fixed-column fixedCol2">-->
<!--                                        <p>STT</p>-->
<!--                                    </th>-->
<!--                                    <th class="cg fixed-column fixedCol3">-->
<!--                                        <p>Thao tác</p>-->
<!--                                    </th>-->
<!--                                    <th v-for="(item,i) in cotHienThi" :key="i">-->
<!--                                        <p>{{ item.name }}</p>-->
<!--                                    </th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody v-if="list_hocsinh.length==0">-->
<!--                                <tr>-->
<!--                                    <td :colspan="cotHienThi.length+3" class="cg">-->
<!--                                        <p>Không có bản ghi nào</p>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                            <tbody v-else>-->
<!--                                <tr v-for="(hs,i) in list_hocsinh" :key="i">-->
<!--                                    <td class="text-center fixed-column fixedCol1">-->
<!--                                        <input type="checkbox" v-model="lsDelete" :value="hs.hocSinhTheoNamId">-->
<!--                                    </td>-->
<!--                                    <td class="text-center fixed-column fixedCol2">-->
<!--                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center fixed-column fixedCol3">-->
<!--                                        <el-tooltip content="Sửa" placement="left">-->
<!--                                            &lt;!&ndash; <el-button type="warning"-->
<!--                                               size="mini"> &ndash;&gt;-->
<!--                                            <i @click.prevent="ShowUpdate(hs.hocSinhTheoNamId)"-->
<!--                                                class="el-icon-edit"></i>-->
<!--                                            &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                        </el-tooltip>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maTruongHoc">-->
<!--                                        <p>{{ hs.maTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.tenTruongHoc">-->
<!--                                        <p>{{ hs.tenTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.khoiHoc">-->
<!--                                        <p>{{ hs.khoiHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.tenLopHoc">-->
<!--                                        <p>{{ hs.tenLopHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maHocSinh">-->
<!--                                        <a href="#" v-on:click.prevent="showInFo(hs.hocSinhTheoNamId)"-->
<!--                                            title="Chi tiết">{{ hs.maHocSinh }}</a>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.moetCode">-->
<!--                                        <p>{{ hs.moetCode }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.hoTen" style="text-align:left">-->
<!--                                        <a href="#" v-on:click.prevent="showInFo(hs.hocSinhTheoNamId)"-->
<!--                                            title="Chi tiết">{{ hs.hoTen }}</a>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.ngaySinh">-->
<!--                                        <p>{{ hs.ngaySinh }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.gioiTinh">-->
<!--                                        <p>{{ hs.gioiTinh }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maDanToc">-->
<!--                                        <p>{{ hs.maDanToc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.trangThai" class="text-center">-->
<!--                                        &lt;!&ndash;                                        <el-button :class="getTrangThai(hs.trangThai)" size="mini">{{ hs.trangThai }}&ndash;&gt;-->
<!--                                        &lt;!&ndash;                                        </el-button>&ndash;&gt;-->
<!--                                        <p>{{ hs.trangThai }}</p>-->
<!--                                        &lt;!&ndash; <el-button v-if="hs.trangThai=='Đang học'" size="mini" class="hoverSuccess"-->
<!--                                               type="success">{{ hs.trangThai }}-->
<!--                                    </el-button>-->
<!--                                    <el-button v-if="hs.trangThai=='Bỏ học'" size="mini" class="hoverWarning"-->
<!--                                               type="warning">{{ hs.trangThai }}-->
<!--                                    </el-button>-->
<!--                                    <el-button v-if="hs.trangThai=='Chuyển khỏi trường'" size="mini"-->
<!--                                               class="hoverDanger" type="danger">{{ hs.trangThai }}-->
<!--                                    </el-button> &ndash;&gt;-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.soCmnd">-->
<!--                                        <p>{{ hs.soCmnd }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.ngayCapCmnd">-->
<!--                                        <p>{{ hs.ngayCapCmnd }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.noiCapCmnd">-->
<!--                                        <p>{{ hs.noiCapCmnd }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.sdt">-->
<!--                                        <p>{{ hs.sdt }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.email">-->
<!--                                        <p>{{ hs.email }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.soDienThoaiMe">-->
<!--                                        <p>{{ hs.soDienThoaiMe }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.dchiThtru">-->
<!--                                        <p>{{ hs.dchiThtru }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.dchiTmtru">-->
<!--                                        <p>{{ hs.dchiTmtru }}</p>-->
<!--                                    </td>-->

<!--                                    <td v-if="hangHienThi.noiSinh">-->
<!--                                        <p>{{ hs.noiSinh }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.hoNgheo">-->
<!--                                        <p>{{ hs.hoNgheo }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maDtuongCsach">-->
<!--                                        <p>{{ hs.maDtuongCsach }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.soDienThoaiBo">-->
<!--                                        <p>{{ hs.soDienThoaiBo }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.hoTenBo">-->
<!--                                        <p>{{ hs.hoTenBo }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.hoTenMe">-->
<!--                                        <p>{{ hs.hoTenMe }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.citizenId">-->
<!--                                        <p>{{ hs.citizenId }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.kiemTraSucKhoeDinhDuong">-->
<!--                                        <p>{{ hs.kiemTraSucKhoeDinhDuong }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.isKhamSkDky">-->
<!--                                        <p>{{ hs.isKhamSkDky }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.chieuCao">-->
<!--                                        <p>{{ hs.chieuCao }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.chieuCaoKy2">-->
<!--                                        <p>{{ hs.chieuCaoKy2 }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.canNang">-->
<!--                                        <p>{{ hs.canNang }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.canNangKy2">-->
<!--                                        <p>{{ hs.canNangKy2 }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.benhMat">-->
<!--                                        <p>{{ hs.benhMat }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.bietBoiKy1">-->
<!--                                        <p>{{ hs.bietBoiKy1 }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.bietBoiKy2">-->
<!--                                        <p>{{ hs.bietBoiKy2 }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.hocSinhBanTru">-->
<!--                                        <p>{{ hs.hocSinhBanTru }}</p>-->
<!--                                    </td>-->
<!--                                    &lt;!&ndash; <td v-if="hangHienThi.isSuyDduongTheNheCan">-->
<!--                                        <p>{{ hs.isSuyDduongTheNheCan }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.isSuyDduongTheCoiCoc">-->
<!--                                        <p>{{ hs.isSuyDduongTheCoiCoc }}</p>-->
<!--                                    </td> &ndash;&gt;-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
                </el-col>
                <el-col v-show="total_rows" :span="24">
                    <PhanTrang :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                    </PhanTrang>
                </el-col>
                <!-- <el-col :span="12">
                    <ChonSoLuong @chonXongSoLuong="ChonSoLuongBanGhi($event)">
                    </ChonSoLuong>
                </el-col>
                <el-col :span="12">
                    <PhanTrang v-show="total_rows>0" :tongbanghi="total_rows" :soluonghienthi="soLuongBanGhiHienThi"
                        :batdau="trangbatdau" @pageChange="layLai($event)">
                    </PhanTrang>
                </el-col> -->
                <XuatExcel :show="show_excel_hoc_sinh" @close="show_excel_hoc_sinh=false" @submit="submitExcel($event)"
                    :rowsview="limit" :total="total_rows" :limit="10">
                </XuatExcel>
                <ChinhSua :isView="isView" :show="show_update" :item="dataUpdateHocSinh" @close="show_update=false"
                    @success="dongSuaHs($event)">
                </ChinhSua>
                <ThongTin :show="show_info" :item="dataInfoHocSinh" @close="show_info=false" @close2="dongSuaHs()">
                </ThongTin>

            </el-row>
        </div>
    </div>
</template>
<script>
    import constant from '../../../utils/constant';
    import array_util from '../../../utils/array_utils';
    import rest_api from '../../../utils/rest_api';
    import UpdateHocSinh from './ChinhSua';
    import ThongTinHocSinh from './thongTin';
    import api from '../../api';
    import PhanTrang from "../../ui/PagingCustom";
    import ChonSoLuong from "../../ui/chonSoLuongBanGhi";
    import XuatExcel from '../../ui/chonSoLuongXuatExcel';
    import VueAlertify from "vue-alertify";
    import ElementUI from 'element-ui';
    import ESelectVue from '../../ui/ESelect.vue';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import Breadcrumb from '../../ui/Breadcrumb.vue';

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
            DatePicker,
            'eselect': ESelectVue,
            'ChinhSua': UpdateHocSinh,
            'ThongTin': ThongTinHocSinh,
            "PhanTrang": PhanTrang,
            ChonSoLuong: ChonSoLuong,
            XuatExcel: XuatExcel,
            Breadcrumb
        },
        data() {
            return {
                dataInfoHocSinh: "",
                dataSreachList: [],
                list_day_len_bo: [],
                list_dan_toc: [],
                list_ton_giao: [],
                list_khu_vuc: constant.KHU_VUC,
                list_loai_nhap_hoc: constant.LOAI_NHAP_HOC,
                list_thoi_hoc: constant.LY_DO_THOI_HOC,
                show_excel_hoc_sinh: false,
                show_update: false,
                isView: false,
                show_info: false,
                start_excel_hoc_sinh: 0,
                tenLopHoc: "",
                limit_excel_hoc_sinh: 800,
                timKiemNangCao: true,
                hienThiNangCao: {
                    ngaySinh: false,
                    noiSinh: false,
                    maDanToc: false,
                    maTonGiao: false,
                    maLopHocCn: false,
                    dchiThtru: false,
                    dchiTmtru: false,
                    maKhuVuc: false,
                    gioiTinh: false,
                    loaiNhapHoc: false,
                    maLyDoThoiHoc: false,
                    doiVien: false,
                    doanVien: false,
                    khuyetTat: false,
                    lopGhep: false,
                    lopChuyen: false,
                    danTocThieuSo: false,
                    hoNgheo: false,
                    moetCode: false,
                    maDtuongCsach: false,
                    kiemTraSucKhoeDinhDuong: false,
                    isKhamSkDky: false,
                    isSuyDduongTheTcoi: false,
                    isTheoDoiBdoCcao: false,
                    isTheoDoiBdoCnang: false,
                    chieuCao: false,
                    chieuCaoKy2: false,
                    canNang: false,
                    canNangKy2: false,
                    benhMat: false,
                    bietBoiKy1: false,
                    bietBoiKy2: false,
                    hocSinhBanTru: false,
                    noiChuyenDi: false,
                    isSuyDduongTheNheCan: false,
                    isSuyDduongTheCoiCoc: false,
                },
                khoi_cap_mot: constant.khoiCapMot,
                khoi_cap_hai: constant.khoiCapHai,
                khoi_cap_ba: constant.khoiCapBa,
                khoi_cap_4: constant.khoiHocNhaTre,
                khoi_cap_5: constant.khoiHocMauGiao,
                danhSachTimKiemNangCao: [],
                list_tim_kiem_nang_cao: [{
                        value: 'ngaySinh',
                        name: "Ngày sinh"
                    },
                    {
                        value: 'noiSinh',
                        name: "Nơi sinh"
                    },
                    {
                        value: 'maDanToc',
                        name: "Dân tộc"
                    },
                    {
                        value: 'maTonGiao',
                        name: "Tôn giáo"
                    },
                    {
                        value: 'dchiThtru',
                        name: "Địa chỉ thường trú"
                    },
                    {
                        value: 'dchiTmtru',
                        name: "Địa chỉ tạm trú"
                    },
                    {
                        value: 'maKhuVuc',
                        name: "Khu vực"
                    },
                    {
                        value: 'loaiNhapHoc',
                        name: "Loại nhập học"
                    },
                    {
                        value: 'maLyDoThoiHoc',
                        name: "Lý do thôi học"
                    },
                    {
                        value: 'doiVien',
                        name: "Đội viên"
                    },
                    {
                        value: 'doanVien',
                        name: "Đoàn viên"
                    },
                    {
                        value: 'khuyetTat',
                        name: "Khuyết tật"
                    },
                    {
                        value: 'lopGhep',
                        name: "Lớp ghép"
                    },
                    {
                        value: 'lopChuyen',
                        name: "Lớp chuyên"
                    },
                    {
                        value: 'danTocThieuSo',
                        name: "Dân tộc thiểu số"
                    },
                    {
                        value: 'hoNgheo',
                        name: "Hộ nghèo"
                    },
                    {
                        value: 'moetCode',
                        name: "Mã định danh bộ GD&ĐT"
                    },
                    {
                        value: 'maDtuongCsach',
                        name: "Đối tượng chính sách"
                    },
                    {
                        value: 'kiemTraSucKhoeDinhDuong',
                        name: "Kiểm tra sức khoẻ dinh dưỡng"
                    },
                    // {
                    //     value: 'isKhamSkDky',
                    //     name: "Khám sức khoẻ định kỳ"
                    // },
                    // {
                    //     value: 'isSuyDduongTheTcoi',
                    //     name: "Suy dinh dưỡng thể thấp còi"
                    // },
                    // {
                    //     value: 'isTheoDoiBdoCcao',
                    //     name: "Theo dõi biểu đồ chiều cao"
                    // },
                    // {
                    //     value: 'isTheoDoiBdoCnang',
                    //     name: "Theo dõi biểu đồ cân nặng"
                    // },
                    {
                        value: 'benhMat',
                        name: 'Bệnh về mắt'
                    },
                    {
                        value: 'bietBoiKy1',
                        name: 'Biết bơi kỳ 1'
                    },
                    {
                        value: 'bietBoiKy2',
                        name: 'Biết bơi kỳ 2'
                    },
                    {
                        value: 'hocSinhBanTru',
                        name: 'Học sinh bán trú'
                    },
                    // {
                    //     value: 'noiChuyenDi',
                    //     name: 'Nơi chuyển đi'
                    // },
                    // {
                    //     value: 'isSuyDduongTheNheCan',
                    //     name: 'Suy dinh dưỡng thể nhẹ cân'
                    // },
                    // {
                    //     value: 'isSuyDduongTheCoiCoc',
                    //     name: 'Suy dinh dưỡng thể còi cọc'
                    // },
                ],
                nangCao: {
                    ngaySinh: "",
                    noiSinh: "",
                    maDanToc: "",
                    maTonGiao: "",
                    maLopHocCn: "",
                    dchiThtru: "",
                    khoiHoc: "",
                    dchiTmtru: "",
                    maKhuVuc: "",
                    gioiTinh: "",
                    loaiNhapHoc: "",
                    maLyDoThoiHoc: "",
                    doiVien: '',
                    doanVien: '',
                    khuyetTat: '',
                    lopGhep: '',
                    lopChuyen: '',
                    danTocThieuSo: '',
                    hoNgheo: '',
                    moetCode: '',
                    maDtuongCsach: '',
                    kiemTraSucKhoeDinhDuong: '',
                    isKhamSkDky: '',
                    isSuyDduongTheTcoi: '',
                    isTheoDoiBdoCcao: '',
                    chieuCao: '',
                    chieuCaoKy2: '',
                    canNang: '',
                    canNangKy2: '',
                },
                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                danhSachTimKiem: [],
                danhSachNoiDungHienThi: [],
                danhSachMaTimKiemSo: [
                    "maTruongHoc",
                    "tenTruongHoc",
                    "khoiHoc",
                    "tenLopHoc",
                    "maHocSinh",
                    "moetCode",
                    "hoTen",
                    "ngaySinh",
                    "gioiTinh",
                    "maDanToc",
                    "trangThai",
                ],
                danhSachMaTimKiemTruong: [
                    "khoiHoc",
                    "tenLopHoc",
                    "maHocSinh",
                    "moetCode",
                    "kiemTraSucKhoeDinhDuong",
                    "isKhamSkDky",
                    "isSuyDduongTheTcoi",
                    "isTheoDoiBdoCcao",
                    "isTheoDoiBdoCnang",
                    "chieuCao",
                    "chieuCaoKy2",
                    "canNang",
                    "canNangKy2",
                    "benhMat",
                    "bietBoiKy1",
                    "bietBoiKy2",
                    "isSuyDduongTheNheCan",
                    "isSuyDduongTheCoiCoc",
                    "hoTen",
                    "ngaySinh",
                    "gioiTinh",
                    "maDanToc",
                    "trangThai",
                ],
                cotHienThi: [],
                columnWidths : {},
                hangHienThi: {},
                list_noi_dung_hien_thi: [],
                capHocDangNhap: "",
                tenDonViDangNhap: "",
                // thông tin người dùng
                slectAll: false,
                dataUpdateHocSinh: "",
                dataEditHocSinh: {},
                thongtin: {},
                danh_sach_chuyen_di: [],
                date: new Date(),
                list_hocsinh: [],
                list_don_vi: [],
                lsDelete: [],
                list_cap_hoc: window.listCapHoc,
                list_trang_thai_hoc_sinh: constant.list_trang_thai_hoc_sinh,
                list_cap_mot: constant.khoiCapMot,
                list_cap_hai: constant.khoiCapHai,
                list_cap_ba: constant.khoiCapBa,
                list_mam_non: constant.khoiMamNon,
                list_nha_tre: constant.khoiNhaTre,
                lop_nha_tre: constant.lopNhaTre,
                lop_mau_giao: constant.lopMauGiao,
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                soLuongBanGhiHienThi: 25,
                // dùng trong filter
                namHocHienTai: "",
                trangThai: "",
                tuKhoa: "",
                maCuDan: "",
                gioiTinh: "",
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_khoi_hoc: [],
                ds_truong_hoc: [],
                namHoc: '',
                danhSachCapHoc: [],
                danhSachKhoiHoc: [],
                list_truong_hoc: [],
                danh_sach_doi_tuong_chinh_sach_sme: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_gioi_tinh: [{
                        name: "Nam",
                        value: 1
                    },
                    {
                        name: "Nữ",
                        value: 0
                    },
                ],
                list_co_khong: [{
                        name: "Có",
                        value: 1
                    },
                    {
                        name: "Không",
                        value: 0
                    },
                ],
                list_benh_ve_mat: [{
                        name: 'Bình thường',
                        value: '00'
                    },
                    {
                        name: 'Cận thị',
                        value: '01'
                    },
                    {
                        name: 'Viễn thị',
                        value: '02'
                    },
                    {
                        name: 'Loạn thị',
                        value: '03'
                    },
                    {
                        name: 'Đục thủy tinh thể',
                        value: '04'
                    },
                    {
                        name: 'Thoái hóa điểm',
                        value: '05'
                    },
                    {
                        name: 'Bệnh khô mắt',
                        value: '06'
                    },
                    {
                        name: 'Bệnh khác về mắt',
                        value: '07'
                    },
                    {
                        name: 'Bệnh lác',
                        value: '08'
                    },
                ],
                // Check xem trang từ bên kết chuyển dữ liệu sang hay không
                chuyenhuong: {},
                isDisabledPhong: false,
                list_khoi_hoc: [],
                trangbatdau: true
            }
        },
        watch: {
            list_hocsinh:{
                handler() {
                    // Tính toán lại độ rộng khi dữ liệu thay đổi
                    this.calculateColumnWidths();
                },
                immediate: true,
            },
            danhSachTimKiemNangCao: function (newVal) {
                if (2 > 0) {
                    console.log("tìm:");
                    let noidung_hienthi = newVal;
                    this.hienThiNangCao.ngaySinh = false;
                    this.hienThiNangCao.noiSinh = false;
                    this.hienThiNangCao.maDanToc = false;
                    this.hienThiNangCao.maTonGiao = false;
                    this.hienThiNangCao.maLopHocCn = false;
                    this.hienThiNangCao.dchiThtru = false;
                    this.hienThiNangCao.dchiTmtru = false;
                    this.hienThiNangCao.maKhuVuc = false;
                    this.hienThiNangCao.gioiTinh = false;
                    this.hienThiNangCao.loaiNhapHoc = false;
                    this.hienThiNangCao.maLyDoThoiHoc = false;
                    this.hienThiNangCao.doiVien = false;
                    this.hienThiNangCao.doanVien = false;
                    this.hienThiNangCao.khuyetTat = false;
                    this.hienThiNangCao.lopGhep = false;
                    this.hienThiNangCao.lopChuyen = false;
                    this.hienThiNangCao.danTocThieuSo = false;
                    this.hienThiNangCao.hoNgheo = false;
                    this.hienThiNangCao.moetCode = false;
                    this.hienThiNangCao.maDtuongCsach = false;
                    this.hienThiNangCao.kiemTraSucKhoeDinhDuong = false;
                    this.hienThiNangCao.isKhamSkDky = false;
                    this.hienThiNangCao.isSuyDduongTheTcoi = false;
                    this.hienThiNangCao.isTheoDoiBdoCcao = false;
                    this.hienThiNangCao.isTheoDoiBdoCnang = false;
                    this.hienThiNangCao.chieuCao = false;
                    this.hienThiNangCao.chieuCaoKy2 = false;
                    this.hienThiNangCao.canNang = false;
                    this.hienThiNangCao.canNangKy2 = false;
                    this.hienThiNangCao.benhMat = false;
                    this.hienThiNangCao.bietBoiKy1 = false;
                    this.hienThiNangCao.bietBoiKy2 = false;
                    this.hienThiNangCao.hocSinhBanTru = false;
                    this.hienThiNangCao.noiChuyenDi = false;
                    this.hienThiNangCao.isSuyDduongTheNheCan = false;
                    this.hienThiNangCao.isSuyDduongTheCoiCoc = false;
                    for (let i = 0; i < noidung_hienthi.length; i++) {
                        if (noidung_hienthi[i] == "ngaySinh") {
                            this.hienThiNangCao.ngaySinh = true
                        }
                        if (noidung_hienthi[i] == "noiSinh") {
                            this.hienThiNangCao.noiSinh = true
                        }
                        if (noidung_hienthi[i] == "maDanToc") {
                            this.hienThiNangCao.maDanToc = true
                        }
                        if (noidung_hienthi[i] == "maTonGiao") {
                            this.hienThiNangCao.maTonGiao = true
                        }
                        if (noidung_hienthi[i] == "maLopHocCn") {
                            this.hienThiNangCao.maLopHocCn = true
                        }
                        if (noidung_hienthi[i] == "dchiThtru") {
                            this.hienThiNangCao.dchiThtru = true
                        }
                        if (noidung_hienthi[i] == "dchiTmtru") {
                            this.hienThiNangCao.dchiTmtru = true
                        }
                        if (noidung_hienthi[i] == "maKhuVuc") {
                            this.hienThiNangCao.maKhuVuc = true
                        }
                        if (noidung_hienthi[i] == "gioiTinh") {
                            this.hienThiNangCao.gioiTinh = true
                        }
                        if (noidung_hienthi[i] == "loaiNhapHoc") {
                            this.hienThiNangCao.loaiNhapHoc = true
                        }
                        if (noidung_hienthi[i] == "maLyDoThoiHoc") {
                            this.hienThiNangCao.maLyDoThoiHoc = true
                        }
                        if (noidung_hienthi[i] == "doiVien") {
                            this.hienThiNangCao.doiVien = true
                        }
                        if (noidung_hienthi[i] == "doanVien") {
                            this.hienThiNangCao.doanVien = true
                        }
                        if (noidung_hienthi[i] == "khuyetTat") {
                            this.hienThiNangCao.khuyetTat = true
                        }
                        if (noidung_hienthi[i] == "lopGhep") {
                            this.hienThiNangCao.lopGhep = true
                        }
                        if (noidung_hienthi[i] == "lopChuyen") {
                            this.hienThiNangCao.lopChuyen = true
                        }
                        if (noidung_hienthi[i] == "danTocThieuSo") {
                            this.hienThiNangCao.danTocThieuSo = true
                        }
                        if (noidung_hienthi[i] == "hoNgheo") {
                            this.hienThiNangCao.hoNgheo = true
                        }
                        if (noidung_hienthi[i] == "moetCode") {
                            this.hienThiNangCao.moetCode = true
                        }
                        if (noidung_hienthi[i] == "maDtuongCsach") {
                            this.hienThiNangCao.maDtuongCsach = true
                        }
                        if (noidung_hienthi[i] == "kiemTraSucKhoeDinhDuong") {
                            this.hienThiNangCao.kiemTraSucKhoeDinhDuong = true
                        }
                        if (noidung_hienthi[i] == "isKhamSkDky") {
                            this.hienThiNangCao.isKhamSkDky = true
                        }
                        if (noidung_hienthi[i] == "isSuyDduongTheTcoi") {
                            this.hienThiNangCao.isSuyDduongTheTcoi = true
                        }
                        if (noidung_hienthi[i] == "isTheoDoiBdoCcao") {
                            this.hienThiNangCao.isTheoDoiBdoCcao = true
                        }
                        if (noidung_hienthi[i] == "isTheoDoiBdoCnang") {
                            this.hienThiNangCao.isTheoDoiBdoCnang = true
                        }
                        if (noidung_hienthi[i] == "chieuCao") {
                            this.hienThiNangCao.chieuCao = true
                        }
                        if (noidung_hienthi[i] == "chieuCaoKy2") {
                            this.hienThiNangCao.chieuCaoKy2 = true
                        }
                        if (noidung_hienthi[i] == "canNang") {
                            this.hienThiNangCao.canNang = true
                        }
                        if (noidung_hienthi[i] == "canNangKy2") {
                            this.hienThiNangCao.canNangKy2 = true
                        }
                        if (noidung_hienthi[i] == "benhMat") {
                            this.hienThiNangCao.benhMat = true
                        }
                        if (noidung_hienthi[i] == "bietBoiKy1") {
                            this.hienThiNangCao.bietBoiKy1 = true
                        }
                        if (noidung_hienthi[i] == "bietBoiKy2") {
                            this.hienThiNangCao.bietBoiKy2 = true
                        }
                        if (noidung_hienthi[i] == "hocSinhBanTru") {
                            this.hienThiNangCao.hocSinhBanTru = true
                        }
                        if (noidung_hienthi[i] == "noiChuyenDi") {
                            this.hienThiNangCao.noiChuyenDi = true
                        }
                        if (noidung_hienthi[i] == "isSuyDduongTheNheCan") {
                            this.hienThiNangCao.isSuyDduongTheNheCan = true
                        }
                        if (noidung_hienthi[i] == "isSuyDduongTheCoiCoc") {
                            this.hienThiNangCao.isSuyDduongTheCoiCoc = true
                        }
                    }
                    console.log(JSON.stringify(this.hienThiNangCao));
                }
            },
            lsDelete: function (newVal) {
                console.log("Danh sách trường học update");
                let new_data = [];
                this.list_day_len_bo = [];
                console.log(newVal)
                if (newVal && newVal.length > 0) {
                    let data = newVal;
                    if (data.length == this.list_hocsinh.length && data.length > 0) {
                        this.slectAll = true;

                    } else {
                        this.slectAll = false;
                    }
                    for (let i = 0; i < data.length; i++) {
                        for (let j = 0; j < this.list_hocsinh.length; j++) {
                            if (data[i] == this.list_hocsinh[j].hocSinhTheoNamId) {
                                new_data.push(this.list_hocsinh[j]);
                            }
                        }
                    }
                    this.mapDuLieuDayLai(new_data);
                } else {
                    this.slectAll = false;
                }
            },
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.namHoc = this.thongtin.namHocHienTai;
            this.ganDuLieuSME();
            this.mapKhoiHoc(this.thongtin.listCapHoc);
            
            this.getDonVi()
            this.danh_sach_chuyen_di = JSON.parse(localStorage["danh_sach_chuyen_di_sme"]);
            if (this.thongtin.role > 3) {
                this.ds_don_vi = [this.thongtin.ma_don_vi]
            }
            if (this.thongtin.role == 5) {
                this.ds_cap_hoc = this.thongtin.listCapHoc;
                this.danhSachNoiDungHienThi = this.danhSachMaTimKiemTruong;
                this.list_noi_dung_hien_thi = constant.danh_sach_tim_kiem_danh_sach_hoc_sinh_so
            } else {
                this.danhSachNoiDungHienThi = this.danhSachMaTimKiemSo;
                this.list_noi_dung_hien_thi = constant.danh_sach_tim_kiem_danh_sach_hoc_sinh_so
            }
            if (this.thongtin.ma_so == 36 || this.thongtin.ma_so == 19) {
                let obj1 = {
                    key: 'soDienThoaiBo',
                    name: "Số điện thoại bố",
                    stt: 23
                }
                let obj2 = {
                    key: 'soDienThoaiMe',
                    name: "Số điện thoại mẹ",
                    stt: 17
                }
                this.list_noi_dung_hien_thi.push(obj1)
                this.list_noi_dung_hien_thi.push(obj2)
            }
            this.list_noi_dung_hien_thi = this.list_noi_dung_hien_thi.map(item => item).sort((a, b) => parseInt(a
                .stt) - parseInt(b.stt));
            if (this.thongtin.role == 4) {
                this.isDisabledPhong = true;
            }
            if (this.thongtin.role == 5) {
                console.log("đăng nhập là trường:");
                this.ds_cap_hoc = this.thongtin.listCapHoc;
                this.bindCapHocDangNhap();

                this.ds_truong_hoc = [this.thongtin.ma_truong_hoc];
                let checkSso = this.thongtin.sso;
                if (checkSso) {
                    console.log('Trường sso')
                    let obj = {
                        tenTruongHoc: this.thongtin.display_name + ' - [' + this.thongtin.ma_truong_hoc + ']',
                        maTruongHoc: this.thongtin.ma_truong_hoc
                    }
                    this.list_truong_hoc = [obj];
                    console.log(this.list_truong_hoc)

                } else {
                    this.getThongTinTruong();
                }
            } else {
                this.getTruongHoc();
            }
            this.chonNoiDungHienThi();
            this.bindCotHeader();
            this.ganCot();;
            this.calculateColumnWidths();
            if (this.trangcu != '[]') {
                console.log("có dữ liệu trang cũ")
                let trangcu = JSON.parse(this.trangcu)
                this.namHoc = parseInt(trangcu.namHoc);
                this.ds_truong_hoc = [trangcu.maTruongHoc];
                window
                    .history
                    .replaceState("", "Quản lý tài khoản", "Look-up-students");
                this.getListStudent();
            } else {
                console.log("Không có dữ liệu trang cũ")
            }
            // this.getListStudent();
        },
        methods: {
            chonNamHoc(){
                console.log("chọn năm học");
                console.log(this.namHoc);
                this.ds_truong_hoc = [];
                this.ds_don_vi = [];
                this.getTruongHoc();
            },
            calculateColumnWidths() {
                const columnWidths = {};
                this.cotHienThi.forEach((col) => {
                    const field = col.key;

                    // Xử lý nội dung cột
                    const rows = this.list_hocsinh.map((row) => {
                        // // Sử dụng getTenPhanBan nếu field là "phanBan"
                        // if (field === "phanBan") {
                        //     return this.getTenPhanBan(row[field]) || "";
                        // }
                        return row[field]?.toString() || ""; // Nội dung mặc định
                    });

                    const header = col.name || ""; // Tiêu đề cột

                    // Tìm nội dung dài nhất
                    const longestContent = [header, ...rows].reduce((a, b) => (a.length > b.length ? a : b), "");

                    // Tính độ rộng cột
                    const charWidth = 10; // Chiều rộng trung bình ký tự (px)
                    const padding = 20; // Padding thêm
                    columnWidths[field] = longestContent.length * charWidth + padding;
                });
                this.columnWidths = columnWidths; // Cập nhật độ rộng
            },

            getListHocSinh(e) {
                console.log("getListHocSinh")
                console.log(e);
                let data = [];
                let du_lieu = "";
                e.forEach(item => {
                    data.push(item.maHocSinh);
                })
                for (let i = 0; i < data.length; i++) {
                    du_lieu += data[i];
                    if (i < data.length - 1) {
                        du_lieu += ',';
                    }
                }
                return du_lieu;
            },
            mapDuLieuDayLai(e) {
                console.log("Map lại dữ liệu đẩy lên bộ:")
                console.log(e);
                let group = e.reduce((r, a) => {
                    r[a.maTruongHoc] = [...r[a.maTruongHoc] || [], a];
                    return r;
                }, {});
                console.log("group");
                console.log(group);
                let du_lieu = []
                Object.keys(group).forEach((key) => {
                    let obj = {
                        maTruong: key,
                        buocDays: [4],
                        listNopRieng: this.getListHocSinh(group[key]),

                    }
                    if (this.thongtin.role == 5) {
                        obj.maTruong = this.thongtin.ma_truong_hoc
                    }
                    du_lieu.push(obj)

                });
                this.list_day_len_bo = du_lieu;
                console.log(this.list_day_len_bo);
            },
            dayLenBo() {
                console.log("đẩy lại dữ liệu lên bộ:")
                if (!this.list_day_len_bo || this.list_day_len_bo.length == 0) {
                    this.thongBao('error', 'Vui lòng chọn bản ghi cần đẩy lại thông tin');
                } else {
                    this.$confirm('Xác nhận đẩy lại thông tin?', 'Thông báo', {
                            confirmButtonText: 'Đẩy',
                            cancelButtonText: 'Hủy',
                            closeOnClickModal: false,
                        })
                        .then(_ => {
                            console.log(this.list_day_len_bo);
                            let params = {
                                "hocKy": 1,
                                "truongCanDayRequests": this.list_day_len_bo,
                                "namHoc": this.namHoc,
                                // "lstCapHoc": this.cap_hoc_day,
                            }
                            const loadingPush = this.$loading({
                                lock: true,
                                text: 'Loading',
                                spinner: 'el-icon-loading',
                                background: 'rgba(0, 0, 0, 0.7)'
                            });
                            rest_api.post("/csdlgd-admin/dayLenBo/taoYeuCau", params, (data) => {
                                console.log(JSON.stringify(data));
                                loadingPush.close()
                                if (data.data.rc == 0) {
                                    this.thongBao("success",
                                        'Hệ thống đang bắt đầu đẩy dữ liệu lên bộ. Theo dõi quá trình đẩy ở chức năng Lịch sử đẩy dữ liệu lên Bộ.'
                                    )

                                } else {
                                    this.thongBao('error', response.data.rd)
                                }
                            });
                        })
                        .catch(_ => {});
                }
            },
            scrollToElement() {
                console.log("kéo lên đầu")
                const el = this.$refs.scrollToMe;
                console.log(el)
                if (el) {
                    el.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            },
            chonTatCa() {
                console.log("Chọn cả:")
                console.log(this.slectAll)
                let danhsach = [];
                if (this.slectAll) {
                    for (let i = 0; i < this.list_hocsinh.length; i++) {
                        danhsach.push(this.list_hocsinh[i].hocSinhTheoNamId);
                    }
                }
                this.lsDelete = danhsach;
            },
            getTrangThai(e) {
                if (e == "Đang học") {
                    return "dts-status-active"
                }
                if (e == "Bỏ học") {
                    return "dts-status-error"
                }
                if (e == "Chuyển khỏi trường") {
                    return "dts-status-un-active"
                }
            },
            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                this.soLuongBanGhiHienThi = e.soluong;
            },
            chonNoiDungHienThi() {
                console.log(this.danhSachNoiDungHienThi.length)
                console.log("NỘi dung hiển thị")
                let danhSachTimKiem = [];
                for (let i = 0; i < this.danhSachNoiDungHienThi.length; i++) {
                    for (let j = 0; j < this.list_noi_dung_hien_thi.length; j++) {
                        if (this.danhSachNoiDungHienThi[i] == this.list_noi_dung_hien_thi[j].key) {
                            danhSachTimKiem.push(this.list_noi_dung_hien_thi[j]);
                        }
                    }
                }
                this.danhSachTimKiem = danhSachTimKiem;
            },
            getThongTinTruong() {
                try {
                    let params = {
                        p_ma: this.thongtin.ma_truong_hoc
                    };
                    rest_api.get("/internal-api/dmTruongHoc/detail", params, response => {
                        console.log("lấy thông tin trường");
                        console.log(response)
                        if (response.data.code == 200) {
                            let obj = {
                                tenTruongHoc: response.data.data.tenTruongHoc + ' - [' + this.thongtin
                                    .ma_truong_hoc + ']',
                                maTruongHoc: response.data.data.maTruongHoc
                            }
                            this.list_truong_hoc = [obj]
                        } else {
                            let obj = {
                                tenTruongHoc: this.thongtin.username + ' - [' + this.thongtin
                                    .ma_truong_hoc + ']',
                                maTruongHoc: this.thongtin.ma_truong_hoc
                            }
                            this.list_truong_hoc = [obj]
                        }
                    });
                } catch (e) {

                }
            },
            ganDuLieuSME() {
                console.log("check & gán sme")
                let tmp = localStorage["danh_sach_doi_tuong_chinh_sach_sme"];
                if (tmp) {
                    this.list_dan_toc = JSON.parse(localStorage["danh_sach_dan_toc_sme"]);
                    this.list_dan_toc = this.list_dan_toc.filter(item => item.value !== "");
                    this.list_ton_giao = JSON.parse(localStorage["danh_sach_ton_giao_sme"]);
                    this.list_ton_giao = this.list_ton_giao.filter(item => item.value !== "");
                    this.danh_sach_doi_tuong_chinh_sach_sme = JSON.parse(localStorage[
                        "danh_sach_doi_tuong_chinh_sach_sme"]);
                    this.danh_sach_doi_tuong_chinh_sach_sme = this.danh_sach_doi_tuong_chinh_sach_sme.filter(item =>
                        item.value !== "");
                }
            },
            getBackGround(tt){
                if (tt == 1){
                    return '#C9FFE5'
                }
                if (tt == 4){
                    return '#f3cccc'
                }
                if (tt == 3){
                    return '#EBCB78'
                }
                return  '';
            },
            // Hiển thị thông tin
            showInFo(e) {
                console.log('hiển thị thông tin:')
                this.isView = true;
                // this.show_update = true;
                this.show_info = true;
                this.dataInfoHocSinh = e;
                this.dataUpdateHocSinh = e;
            },
            dongSuaHs(e) {
                if (e) {
                    var du_lieu = {};
                    // let arr_update = Object.keys(e)
                    // this.show_update = false;
                    // for (let i = 0; i < this.list_hocsinh.length; i++) {
                    //     if (this.list_hocsinh[i].maHocSinh == e.maHocSinh) {
                    //         du_lieu = this.list_hocsinh[i]
                    //     }
                    // }
                    // for (let j = 0; j < arr_update.length; j++) {
                    //     console.log(arr_update[j])
                    //     du_lieu[arr_update[j]] = e[arr_update[j]];
                    // }
                    console.log(du_lieu)
                    this.show_update = false;
                    this.checkTruocKhiTim()
                } else {
                    this.show_update = false;
                    this.checkTruocKhiTim()
                }
                // const loadingCs = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                // setTimeout(() => {
                //     loadingCs.close();
                //     this.show_update = false;
                //     this.checkTruocKhiTim()
                // }, 5000);
            },
            ShowUpdate(e) {

                this.isView = false
                this.show_update = true;
                this.dataUpdateHocSinh = e;
                console.log(this.dataUpdateHocSinh);
                console.log("****");
                console.log("click chỉnh sửa" + e);
            },
            checkTruocKhiTim() {
                this.lsDelete = [];
                this.trangbatdau = !this.trangbatdau;
            },
            xuatDuLieuHocSinh() {
                if (this.danhSachTimKiem.length == 0) {
                    // this.$alertify.error("Vui lòng chọn nội dung hiển thị.");
                    this.thongBao('error', 'Vui lòng chọn nội dung hiển thị')
                    return;
                }
                if (this.total_rows < 5000000) {
                    console.log("Xuat luon khong can check");
                    this.start_excel_hoc_sinh = 0;
                    this.limit_excel_hoc_sinh = 5000000;
                    this.xuatExcel()
                } else {
                    this.CheckXuatExcel();
                }
            },
            moKhoiHoc() {
                if (!this.ds_cap_hoc || this.ds_cap_hoc.length == 0) {
                    // this.$alertify.error("Vui lòng chọn cấp học để lấy danh sách khối học");
                    this.thongBao('error', 'Vui lòng chọn cấp học để lấy danh sách khối học')
                    return;
                }
            },
            chonKhoiHoc() {
                this.ds_khoi_hoc = [];
                if (this.danhSachKhoiHoc) {
                    let lsch = this.danhSachKhoiHoc.map((obj) => {
                        return obj['id']
                    });
                    for (let i = 0; i < lsch.length; i++) {
                        if (lsch[i] == 13) {
                            lsch.push('14');
                            lsch.push('15');
                        }
                        if (lsch[i] == 16) {
                            lsch.push('17');
                            lsch.push('18');
                        }
                    }
                    this.ds_khoi_hoc = lsch;
                }
                console.log(this.ds_khoi_hoc);
            },
            ChonCapHoc() {
                this.params = {};
                this.ds_truong_hoc = [];
                this.ds_khoi_hoc = [];
                this.thongTinTrangCu = [];
                this.mapKhoiHoc(this.ds_cap_hoc);
                this.getTruongHoc();
            },
            mapKhoiHoc(e) {
                console.log("map cấp học đã chọn:")
                console.log(e)
                let dulieu = e;
                let khoihoc = [];
                if (dulieu) {
                    for (let i = 0; i < dulieu.length; i++) {
                        if (dulieu[i] == 1) {
                            khoihoc = khoihoc.concat(this.khoi_cap_mot)
                        };
                        if (dulieu[i] == 2) {
                            khoihoc = khoihoc.concat(this.khoi_cap_hai)
                        };
                        if (dulieu[i] == 3) {
                            khoihoc = khoihoc.concat(this.khoi_cap_ba)
                        };
                        if (dulieu[i] == 4) {
                            khoihoc = khoihoc.concat(this.khoi_cap_4)
                        };
                        if (dulieu[i] == 5) {
                            khoihoc = khoihoc.concat(this.khoi_cap_5)
                        };
                        if (dulieu[i] == 45) {
                            khoihoc = khoihoc.concat(this.khoi_cap_4, this.khoi_cap_5)
                        };
                        if (dulieu[i] == 6) {
                            khoihoc = khoihoc.concat(this.khoi_cap_mot, this.khoi_cap_hai, this.khoi_cap_ba, this
                                .khoi_cap_4, this.khoi_cap_5)
                        };
                    }
                } else {
                    khoihoc = khoihoc.concat(this.khoi_cap_mot, this.khoi_cap_hai, this.khoi_cap_ba, this
                        .khoi_cap_4, this.khoi_cap_5)
                }
                console.log("Khối học sau map:");
                khoihoc.sort((a, b) => (a.id > b.id) ? 1 : -1);
                let khoihoc_unique = [];
                khoihoc_unique = [...new Set(khoihoc.map(item => item))];
                this.list_khoi_hoc = khoihoc_unique;
            },
            // Bind khối học
            boPhanTuTrung(arr) {
                return arr.filter((value, index, arr) => arr.indexOf(value) === index);
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
            limitTextTieuChi(count) {
                return `và ${count} nội dung khác`
            },
            ChonTieuChi() {
                this.bindTieuChiTimKiem();
            },
            bindTieuChiTimKiem() {
                console.log("Bind tiêu chí tìm kiếm");
                console.log(JSON.stringify(this.danhSachTimKiem));
                for (let i = 0; i < this.danhSachTimKiem.length; i++) {
                    if (this.danhSachTimKiem[i].key == 'ma_hoc_sinh') {
                        console.log("có mã học sinh");
                    }
                }
            },
            ChonDonVi() {
                this.params = {};
                this.ds_truong_hoc = [];
                this.thongTinTrangCu = [];
                console.log('Đơn vị:' + this.ds_don_vi)
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
                            this.capHocDangNhap = "Mẫu giáo";
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
                this.show_excel_hoc_sinh = true;
            },
            submitExcel(e) {
                console.log("submitExcel");
                console.log(e)
                if (e.from == 1) {
                    this.start_excel_hoc_sinh = 0;
                } else {
                    this.start_excel_hoc_sinh = (e.from - 1) * this.limit;
                }
                if (e.to == e.from) {
                    this.limit_excel_hoc_sinh = this.limit;
                } else {
                    let chenh_lech = e.to - e.from;
                    this.limit_excel_hoc_sinh = (chenh_lech + 1) * this.limit
                }
                console.log(this.start_excel_hoc_sinh)
                console.log(this.limit_excel_hoc_sinh)
                this.xuatExcel();
            },
            xuatExcel() {
                console.log("xuất excel");
                let url = "xuat-excel-danh-sach-tra-cuu-hoc-sinh";
                this.ganDataSreachList();
                let params = {
                    "countInPage ": 5000,
                    "capHocs": this.ds_cap_hoc,
                    "gioiTinh": this.gioiTinh,
                    "limit": this.limit_excel_hoc_sinh,
                    "start": this.start_excel_hoc_sinh,
                    "keyword": this.tuKhoa,
                    "maCuDan": this.maCuDan,
                    "maTruongHocs": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "tenLopHoc": this.tenLopHoc,
                    "lstKhoiHoc": this.ds_khoi_hoc,
                    "colExcels": this.danhSachTimKiem,
                    "dataSreachList": this.dataSreachList,
                    "trangThai": this.trangThai
                };
                console.log("Dữ liệu xuất excel 123456789:" + JSON.stringify(params));
                if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                    params.maPhongs = this.ds_don_vi;
                }
                if (this.thongtin.role == 4) {
                    params.maPhongs = [this.thongtin.ma_don_vi];
                }
                if (this.thongtin.role == 5) {
                    params.maTruongHocs = [this.thongtin.ma_truong_hoc];
                }
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.thongBao('success', 'Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        const loadingExcel = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(url, params, (data) => {
                            loadingExcel.close();
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
            },
            // Xóa mã định danh

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
            DeleteMoetCode() {
                console.log(this.lsDelete);
                if (this.lsDelete.length > 0) {
                    this.$confirm('Xác nhận xóa mã định danh các học sinh đã chọn?', 'Xóa dữ liệu', {
                            confirmButtonText: 'Xóa',
                            cancelButtonText: 'Hủy',
                            confirmButtonClass: 'el-button--danger',
                            closeOnClickModal: false,
                        })
                        .then(_ => {
                            let params = {
                                loaiDuLieu: 3,
                                lstId: this.lsDelete,
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
                                    this.thongBao("success", data.data.rd);
                                    this.getListStudent();
                                } else {
                                    this.thongBao('error', data.data.rd);
                                }
                            });
                        })
                        .catch(_ => {});
                } else {
                    // this
                    //     .$alertify
                    //     .error("Vui lòng chọn ít nhất 1 học sinh.")

                    this.thongBao('error', 'Vui lòng chọn học sinh.')
                }
            },
            // Xóa danh sách học sinh đã chọn
            DeleteStudent() {
                console.log(this.lsDelete);
                if (this.lsDelete.length > 0) {
                    this.$confirm('Xác nhận xóa các bản ghi đã chọn?', 'Xóa dữ liệu', {
                            confirmButtonText: 'Xóa',
                            cancelButtonText: 'Hủy',
                            confirmButtonClass: 'el-button--danger',
                            closeOnClickModal: false,
                        })
                        .then(_ => {
                            let hocSinhTheoNamIds = [];
                            for (let i = 0; i < this.lsDelete.length; i++) {
                                console.log("danh sách xóa:" + JSON.stringify(this.lsDelete));
                                for (let j = 0; j < this.list_hocsinh.length; j++) {
                                    console.log("danh sách học sinh:" + JSON.stringify(this.list_hocsinh));
                                    if (this.lsDelete[i] == this.list_hocsinh[j].hocSinhTheoNamId) {
                                        console.log("Trùng:" + JSON.stringify(this.lsDelete[i]));
                                        hocSinhTheoNamIds.push(this.list_hocsinh[j].maHocSinh);
                                    }
                                }
                            }
                            let params = {
                                listMa: hocSinhTheoNamIds,
                                hocSinhTheoNamIds: this.lsDelete,
                                namHoc: this.namHoc
                            };
                            const loadingb = this.$loading({
                                lock: true,
                                text: 'Loading',
                                spinner: 'el-icon-loading',
                                background: 'rgba(0, 0, 0, 0.7)'
                            });
                            rest_api.post("/csdlgd-admin/hocSinh/delete", params, data => {
                                loadingb.close();
                                if (data.data.rc == 0) {
                                    this.thongBao('success', data.data.rd);
                                    this.getListStudent();
                                } else {
                                    this.thongBao('error', data.data.rd);
                                }
                            });
                        })
                        .catch(_ => {});
                } else {
                    // this
                    //     .$alertify
                    //     .error("Vui lòng chọn ít nhất 1 học sinh.")

                    this.thongBao('error', 'Vui lòng chọn học sinh.')
                }
            },
            // Lấy lại danh sách học sinh
            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getListStudent()
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc,
                    namHoc: this.namHoc,
                    loose: true
                };
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    // loading.close();
                    console.log("lấy trường");
                    console.log(data)
                    if (data.data.statusResponse == 0) {
                        let dulieu = data.data.rows;
                        let ldv = [];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenTruongHoc: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                maTruongHoc: dulieu[i].maTruongHoc
                            }
                            ldv.push(obj)
                        }
                        this.list_truong_hoc = ldv;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },
            // gán các cột hiển thị dữ liệu
            locCotHienThi() {
                var flags = [],
                    sau_khi_loc = [],
                    l = this.danhSachTimKiem.length;
                for (let i = 0; i < l; i++) {
                    if (flags[this.danhSachTimKiem[i].stt]) continue;
                    flags[this.danhSachTimKiem[i].stt] = true;
                    sau_khi_loc.push(this.danhSachTimKiem[i]);
                }
                this.danhSachTimKiem = sau_khi_loc;
                this.danhSachTimKiem.sort(this.sapXepMang)
                console.log("Nội dung cột sau khi lọc:" + JSON.stringify(sau_khi_loc));
            },
            bindCotHeader() {
                this.locCotHienThi();
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
            // gán các cột hiển thị
            ganCot() {
                this.hangHienThi = {};
                this.cotHienThi = this.danhSachTimKiem;
                console.log("cột hiển thị:");
                for (let i = 0; i < this.cotHienThi.length; i++) {
                    if (this.cotHienThi[i].key == "maTruongHoc") {
                        this.hangHienThi.maTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenTruongHoc") {
                        this.hangHienThi.tenTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "khoiHoc") {
                        this.hangHienThi.khoiHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenLopHoc") {
                        this.hangHienThi.tenLopHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenHocSinh") {
                        this.hangHienThi.tenHocSinh = true;
                    }
                    if (this.cotHienThi[i].key == "hoTen") {
                        this.hangHienThi.hoTen = true;
                    }
                    if (this.cotHienThi[i].key == "moetCode") {
                        this.hangHienThi.moetCode = true;
                    }
                    if (this.cotHienThi[i].key == "maHocSinh") {
                        this.hangHienThi.maHocSinh = true;
                    }
                    if (this.cotHienThi[i].key == "trangThai") {
                        this.hangHienThi.trangThai = true;
                    }
                    if (this.cotHienThi[i].key == "gioiTinh") {
                        this.hangHienThi.gioiTinh = true;
                    }
                    if (this.cotHienThi[i].key == "ngaySinh") {
                        this.hangHienThi.ngaySinh = true;
                    }
                    if (this.cotHienThi[i].key == "noiSinh") {
                        this.hangHienThi.noiSinh = true;
                    }
                    if (this.cotHienThi[i].key == "maDanToc") {
                        this.hangHienThi.maDanToc = true;
                    }
                    if (this.cotHienThi[i].key == "maTonGiao") {
                        this.hangHienThi.maTonGiao = true;
                    }
                    if (this.cotHienThi[i].key == "capHoc") {
                        this.hangHienThi.capHoc = true;
                    }
                    if (this.cotHienThi[i].key == "dchiThtru") {
                        this.hangHienThi.dchiThtru = true;
                    }
                    if (this.cotHienThi[i].key == "dchiTmtru") {
                        this.hangHienThi.dchiTmtru = true;
                    }
                    if (this.cotHienThi[i].key == "soCmnd") {
                        this.hangHienThi.soCmnd = true;
                    }
                    if (this.cotHienThi[i].key == "soDthoaiCdinh") {
                        this.hangHienThi.soDthoaiCdinh = true;
                    }
                    if (this.cotHienThi[i].key == "dienThoaiHieuTruong") {
                        this.hangHienThi.dienThoaiHieuTruong = true;
                    }
                    if (this.cotHienThi[i].key == "doiVien") {
                        this.hangHienThi.doiVien = true;
                    }
                    if (this.cotHienThi[i].key == "doanVien") {
                        this.hangHienThi.doanVien = true;
                    }
                    if (this.cotHienThi[i].key == "hoNgheo") {
                        this.hangHienThi.hoNgheo = true;
                    }
                    if (this.cotHienThi[i].key == "email") {
                        this.hangHienThi.email = true;
                    }
                    if (this.cotHienThi[i].key == "hieuTruong") {
                        this.hangHienThi.hieuTruong = true;
                    }
                    if (this.cotHienThi[i].key == "hoTenBo") {
                        this.hangHienThi.hoTenBo = true;
                    }
                    if (this.cotHienThi[i].key == "soDienThoaiBo") {
                        this.hangHienThi.soDienThoaiBo = true;
                    }
                    if (this.cotHienThi[i].key == "hoTenMe") {
                        this.hangHienThi.hoTenMe = true;
                    }
                    if (this.cotHienThi[i].key == "citizenId") {
                        this.hangHienThi.citizenId = true;
                    }
                    if (this.cotHienThi[i].key == "soDienThoaiMe") {
                        this.hangHienThi.soDienThoaiMe = true;
                    }
                    if (this.cotHienThi[i].key == "soCmnd") {
                        this.hangHienThi.soCmnd = true;
                    }
                    if (this.cotHienThi[i].key == "ngayCapCmnd") {
                        this.hangHienThi.ngayCapCmnd = true;
                    }
                    if (this.cotHienThi[i].key == "noiCapCmnd") {
                        this.hangHienThi.noiCapCmnd = true;
                    }
                    if (this.cotHienThi[i].key == "dchiThtru") {
                        this.hangHienThi.dchiThtru = true;
                    }
                    if (this.cotHienThi[i].key == "dchiTmtru") {
                        this.hangHienThi.dchiTmtru = true;
                    }
                    if (this.cotHienThi[i].key == "sdt") {
                        this.hangHienThi.sdt = true;
                    }
                    if (this.cotHienThi[i].key == "maDtuongCsach") {
                        this.hangHienThi.maDtuongCsach = true;
                    }
                    if (this.cotHienThi[i].key == "kiemTraSucKhoeDinhDuong") {
                        this.hangHienThi.kiemTraSucKhoeDinhDuong = true;
                    }
                    if (this.cotHienThi[i].key == "isKhamSkDky") {
                        this.hangHienThi.isKhamSkDky = true;
                    }
                    if (this.cotHienThi[i].key == "isSuyDduongTheTcoi") {
                        this.hangHienThi.isSuyDduongTheTcoi = true;
                    }
                    if (this.cotHienThi[i].key == "isTheoDoiBdoCcao") {
                        this.hangHienThi.isTheoDoiBdoCcao = true;
                    }
                    if (this.cotHienThi[i].key == "isTheoDoiBdoCnang") {
                        this.hangHienThi.isTheoDoiBdoCnang = true;
                    }
                    if (this.cotHienThi[i].key == "chieuCao") {
                        this.hangHienThi.chieuCao = true;
                    }
                    if (this.cotHienThi[i].key == "chieuCaoKy2") {
                        this.hangHienThi.chieuCaoKy2 = true;
                    }
                    if (this.cotHienThi[i].key == "canNang") {
                        this.hangHienThi.canNang = true;
                    }
                    if (this.cotHienThi[i].key == "canNangKy2") {
                        this.hangHienThi.canNangKy2 = true;
                    }
                    if (this.cotHienThi[i].key == "benhMat") {
                        this.hangHienThi.benhMat = true;
                    }
                    if (this.cotHienThi[i].key == "bietBoiKy1") {
                        this.hangHienThi.bietBoiKy1 = true;
                    }
                    if (this.cotHienThi[i].key == "bietBoiKy2") {
                        this.hangHienThi.bietBoiKy2 = true;
                    }
                    if (this.cotHienThi[i].key == "hocSinhBanTru") {
                        this.hangHienThi.hocSinhBanTru = true;
                    }
                    if (this.cotHienThi[i].key == "noiChuyenDi") {
                        this.hangHienThi.noiChuyenDi = true;
                    }
                    if (this.cotHienThi[i].key == "isSuyDduongTheNheCan") {
                        this.hangHienThi.isSuyDduongTheNheCan = true;
                    }
                    if (this.cotHienThi[i].key == "isSuyDduongTheCoiCoc") {
                        this.hangHienThi.isSuyDduongTheCoiCoc = true;
                    }
                }
                console.log("Hàng hiển thị:" + JSON.stringify(this.hangHienThi));
            },
            // Lấy danh sách học sinh
            ganDataSreachList() {
                let dataSreachList = [];
                if (this.timKiemNangCao) {
                    if (this.hienThiNangCao.ngaySinh) {
                        if (this.nangCao.ngaySinh) {
                            let obj = {
                                "key": "ngaySinh",
                                "value": this.nangCao.ngaySinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.noiSinh) {
                        if (this.nangCao.noiSinh) {
                            let obj = {
                                "key": "noiSinh",
                                "value": this.nangCao.noiSinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maDanToc) {
                        if (this.nangCao.maDanToc) {
                            let obj = {
                                "key": "maDanToc",
                                "values": this.nangCao.maDanToc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maTonGiao) {
                        if (this.nangCao.maTonGiao) {
                            let obj = {
                                "key": "maTonGiao",
                                "values": this.nangCao.maTonGiao,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLopHocCn) {
                        if (this.nangCao.maLopHocCn) {
                            let obj = {
                                "key": "tenLopHoc",
                                "value": this.nangCao.maLopHocCn,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dchiThtru) {
                        if (this.nangCao.dchiThtru) {
                            let obj = {
                                "key": "dchiThtru",
                                "value": this.nangCao.dchiThtru,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dchiTmtru) {
                        if (this.nangCao.dchiTmtru) {
                            let obj = {
                                "key": "dchiTmtru",
                                "value": this.nangCao.dchiTmtru,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maKhuVuc) {
                        if (this.nangCao.maKhuVuc) {
                            let obj = {
                                "key": "maKhuVuc",
                                "values": this.nangCao.maKhuVuc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.gioiTinh) {
                        if (this.nangCao.gioiTinh) {
                            let obj = {
                                "key": "gioiTinh",
                                "value": parseInt(this.nangCao.gioiTinh),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.loaiNhapHoc) {
                        if (this.nangCao.loaiNhapHoc) {
                            let obj = {
                                "key": "loaiNhapHoc",
                                "value": this.nangCao.loaiNhapHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLyDoThoiHoc) {
                        if (this.nangCao.maLyDoThoiHoc) {
                            let obj = {
                                "key": "maLyDoThoiHoc",
                                "values": this.nangCao.maLyDoThoiHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doiVien) {
                        if (this.nangCao.doiVien) {
                            let obj = {
                                "key": "doiVien",
                                "value": this.nangCao.doiVien,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doanVien) {
                        if (this.nangCao.doanVien) {
                            let obj = {
                                "key": "doanVien",
                                "value": this.nangCao.doanVien,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.khuyetTat) {
                        if (this.nangCao.khuyetTat) {
                            let obj = {
                                "key": "khuyetTat",
                                "value": parseInt(this.nangCao.khuyetTat),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopGhep) {
                        if (this.nangCao.lopGhep) {
                            let obj = {
                                "key": "lopGhep",
                                "value": this.nangCao.lopGhep,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.khoiHoc) {
                        if (this.nangCao.khoiHoc) {
                            let obj = {
                                "key": "khoiHoc",
                                "value": this.nangCao.khoiHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopChuyen) {
                        if (this.nangCao.lopChuyen) {
                            let vl = "";
                            if (this.nangCao.lopChuyen == 1) {
                                vl = true;
                            }
                            if (this.nangCao.lopChuyen == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "lopChuyen",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.danTocThieuSo) {
                        if (this.nangCao.danTocThieuSo) {
                            let vl = "";
                            if (this.nangCao.danTocThieuSo == 1) {
                                vl = true;
                            }
                            if (this.nangCao.danTocThieuSo == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "danToc",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.hoNgheo) {
                        if (this.nangCao.hoNgheo === 1 || this.nangCao.hoNgheo === 0) {
                            let obj = {
                                "key": "hoNgheo",
                                "value": Boolean(this.nangCao.hoNgheo),
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
                    if (this.hienThiNangCao.maDtuongCsach) {
                        if (this.nangCao.maDtuongCsach) {
                            let obj = {
                                "key": "maDtuongCsach",
                                "value": this.nangCao.maDtuongCsach,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.kiemTraSucKhoeDinhDuong) {
                        if (this.nangCao.kiemTraSucKhoeDinhDuong === 1 || this.nangCao.kiemTraSucKhoeDinhDuong === 0) {
                            let obj = {
                                "key": "kiemTraSucKhoeDinhDuong",
                                "value": Boolean(this.nangCao.kiemTraSucKhoeDinhDuong),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.isKhamSkDky) {
                        if (this.nangCao.isKhamSkDky === 1 || this.nangCao.isKhamSkDky === 0) {
                            let obj = {
                                "key": "isKhamSkDky",
                                "value": Boolean(this.nangCao.isKhamSkDky),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.isSuyDduongTheTcoi) {
                        if (this.nangCao.isSuyDduongTheTcoi === 1 || this.nangCao.isSuyDduongTheTcoi === 0) {
                            let obj = {
                                "key": "isSuyDduongTheTcoi",
                                "value": Boolean(this.nangCao.isSuyDduongTheTcoi),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.isTheoDoiBdoCcao) {
                        if (this.nangCao.isTheoDoiBdoCcao === 1 || this.nangCao.isTheoDoiBdoCcao === 0) {
                            let obj = {
                                "key": "isTheoDoiBdoCcao",
                                "value": Boolean(this.nangCao.isTheoDoiBdoCcao),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.isTheoDoiBdoCnang) {
                        if (this.nangCao.isTheoDoiBdoCnang === 1 || this.nangCao.isTheoDoiBdoCnang === 0) {
                            let obj = {
                                "key": "isTheoDoiBdoCnang",
                                "value": Boolean(this.nangCao.isTheoDoiBdoCnang),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.benhMat) {
                        if (this.nangCao.benhMat) {
                            let obj = {
                                "key": "benhMat",
                                "value": this.nangCao.benhMat,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.bietBoiKy1) {
                        if (this.nangCao.bietBoiKy1 === 1 || this.nangCao.bietBoiKy1 === 0) {
                            let obj = {
                                "key": "bietBoiKy1",
                                "value": Boolean(this.nangCao.bietBoiKy1),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.bietBoiKy2) {
                        if (this.nangCao.bietBoiKy2 === 1 || this.nangCao.bietBoiKy2 === 0) {
                            let obj = {
                                "key": "bietBoiKy2",
                                "value": Boolean(this.nangCao.bietBoiKy2),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.hocSinhBanTru) {
                        if (this.nangCao.hocSinhBanTru === 1 || this.nangCao.hocSinhBanTru === 0) {
                            let obj = {
                                "key": "hocSinhBanTru",
                                "value": Boolean(this.nangCao.hocSinhBanTru),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.noiChuyenDi) {
                        if (this.nangCao.noiChuyenDi) {
                            let obj = {
                                "key": "noiChuyenDi",
                                "value": this.nangCao.noiChuyenDi,
                            }   
                            dataSreachList.push(obj)
                        }
                    }
                    

                    if (this.hienThiNangCao.isSuyDduongTheNheCan) {
                        if (this.nangCao.isSuyDduongTheNheCan === 1 || this.nangCao.isSuyDduongTheNheCan === 0) {
                            let obj = {
                                "key": "isSuyDduongTheNheCan",
                                "value": Boolean(this.nangCao.isSuyDduongTheNheCan),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.isSuyDduongTheCoiCoc) {
                        if (this.nangCao.isSuyDduongTheCoiCoc === 1 || this.nangCao.isSuyDduongTheCoiCoc === 0) {
                            let obj = {
                                "key": "isSuyDduongTheCoiCoc",
                                "value": Boolean(this.nangCao.isSuyDduongTheCoiCoc),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                }
                this.dataSreachList = dataSreachList;
            },
            mapToUpperCase(arr) {
                console.log("nhận vào:")
                console.log(arr)
                let result = [];
                if (arr && arr.length > 0) {
                    for (let i = 0; i < arr.length; i++) {
                        result.push(arr[i].toUpperCase())
                    }
                }
                return result
            },

            getListStudent() {
                this.slectAll = false;
                this.lsDelete = [];
                if (this.danhSachTimKiem.length == 0) {
                    // this.$alertify.error("Vui lòng chọn nội dung hiển thị.");
                    this.thongBao('error', 'Vui lòng chọn nội dung hiển thị')
                    return;
                }
                this.ganDataSreachList();
                console.log("THông tin tìm kiếm nâng cao:");
                console.log(JSON.stringify(this.dataSreachList));
                this.bindCotHeader();
                this.ganCot();
                this.list_hocsinh = [];
                // let ds_truong = this.mapToUpperCase(this.ds_truong_hoc);
                // console.log('ds trường viết hoa: ' )
                // console.log(ds_truong)

                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "capHocs": this.ds_cap_hoc,
                    "gioiTinh": this.gioiTinh,
                    "keyword": this.tuKhoa,
                    "maCuDan": this.maCuDan,
                    "maTruongHocs": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "tenLopHoc": this.tenLopHoc,
                    "lstKhoiHoc": this.ds_khoi_hoc,
                    "colExcels": this.danhSachTimKiem,
                    "dataSreachList": this.dataSreachList,
                    "trangThai": this.trangThai
                };
                if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                    params.maPhongs = this.ds_don_vi;
                }
                if (this.thongtin.role == 4) {
                    params.maPhongs = [this.thongtin.ma_don_vi];
                }
                if (this.thongtin.role == 5) {
                    params.maTruongHocs = [this.thongtin.ma_truong_hoc];
                }
                console.log("tìm kiếm học sinh:" + JSON.stringify(params))
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.calculateColumnWidths();

                rest_api.post("/csdlgd-admin/hocSinh/search3", params, (respon) => {
                    loading.close();
                    if (respon.data.rc == 0) {
                        if (respon.data.tableData.length == 0) {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy");
                            console.log("không có bản ghi nào được tìm thấy");
                            this.total_rows = 0;
                            return;
                        } else {
                            this.list_hocsinh = respon.data.tableData;
                            this.total_rows = respon.data.totalRows;
                            setTimeout(() => {
                                this.scrollToElement();
                            });
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công.")
                        }
                    } else {
                        this.total_rows = 0;
                        this
                            .$alertify
                        // .error(respon.data.rd);

                        this.thongBao('error', respon.data.rd)
                        return;
                    }
                })
            },
            // Chuyển hướng từ trang kết chuyển dữ liệu
            // Lấy danh sách đơn vị
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                console.log("pr ẻty" + JSON.stringify(params));
                const loadingdonvi = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loadingdonvi.close();
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
                                    this.tenDonViDangNhap = this.list_don_vi[i].tenDonVi;
                                }
                            }
                        }
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">
    /* @import "../../../../../node_modules/selectwithsearch.css"; */

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

    .cg {
        text-align: center;
        align-items: center;
    }

    .multiselect--disabled {
        background: white;
    }

    input[type=checkbox] {
        margin: 0 !important;
    }

</style>

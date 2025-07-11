<template>
    <div v-loading.fullscreen.lock="fullScreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <Breadcrumb :menu="'Tra cứu'" :desc="'Tra cứu kết quả học tập'" />
        <!-- hết header -->
        <!-- bắt đầu fillter -->
        <div class="card-bieu-do">

            <el-form ref="ruleForm">
                <el-row :gutter="24" class="">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :sm="24" :md="12" v-if="namHoc<2025">
                        <label class="typo__label">Đơn vị quản lý</label>
                        <div>
                            <eselect style="width:100%" :disabled="thongtin.role>3" multiple collapseTags
                                     v-model="ds_don_vi" @change="ChonDonVi" :placeholder="'Chọn'" filterable
                                     :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                        </div>
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Cấp học </label>
                        <eselect style="width:100%" multiple collapseTags :disabled="thongtin.role==5"
                                 v-model="ds_cap_hoc" @change="ChonCapHoc" :placeholder="'Chọn'" filterable
                                 :data="list_cap_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Năm học <span class="red">*</span></label>
                        <eselect style="width:100%" @change="chonNamHoc()" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                 :data="list_nam_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="24" :md="12">
                        <div>
                            <label class="typo__label">Trường học </label>
                            <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags
                                     v-model="ds_truong_hoc" :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                     :fields="['tenTruongHoc','maTruongHoc']" />
                        </div>
                    </el-col>

                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Khối học/Nhóm tuổi</label>
                        <eselect style="width:100%" multiple collapseTags v-model="ds_khoi_hoc" :placeholder="'Chọn'"
                                 filterable :data="list_khoi_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label>Tên lớp học</label>
                        <el-input type="text" clearable @change="nangCao.tenLopHoc = nangCao.tenLopHoc.trim()"
                                  placeholder="Nhập..." v-model="nangCao.tenLopHoc" />
                    </el-col>

                    <el-col :sm="12" :md="6">
                        <label>Từ khóa</label>
                        <el-input v-model="tuKhoa" v-on:keyup.enter="getListStudent" clearable
                                  @change="tuKhoa = tuKhoa.trim()" placeholder="Tên/mã/số CMND,..." />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label>Giai đoạn</label>
                        <el-select v-model="giaiDoan" filterable collapse-tags placeholder="Chọn"
                                   no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                            <el-option v-for="item in list_giai_doan" :key="item.value" :label="item.name"
                                       :value="item.value">
                            </el-option>
                        </el-select>
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label>Học kỳ</label>
                        <eselect style="width:100%" collapseTags v-model="hocKy" :placeholder="'Chọn'" filterable
                                 :data="list_hoc_ky" :fields="['name','value']" />
                    </el-col>

                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Tìm kiếm nâng cao</label>
                        <eselect style="width:100%" multiple collapseTags v-model="danhSachTimKiemNangCao"
                                 :placeholder="'Chọn'" filterable :data="list_tim_kiem_nang_cao"
                                 :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Nội dung hiển thị <span class="red">*</span></label>
                        <div>
                            <eselect style="width:100%" multiple collapseTags v-model="danhSachNoiDungHienThi"
                                     @input="chonNoiDungHienThi" :placeholder="'Chọn'" filterable
                                     :data="list_noi_dung_hien_thi" :fields="['name','key']" />
                        </div>
                    </el-col>
                    <template v-if="danhSachTimKiemNangCao.length>0" style="padding-top:5px">
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.kiemTraSucKhoeDinhDuong">
                            <label>Kiểm tra sức khỏe dinh dưỡng</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.kiemTraSucKhoeDinhDuong"
                                     :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.hthanhCtrinhLhoc">
                            <label>Hoàn thành chương trình lớp học</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.hthanhCtrinhLhoc"
                                     :placeholder="'Chọn'" filterable :data="list_hoan_thanh_hay_khong"
                                     :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.hoanThanhChuongTrinhMamMon">
                            <label>Hoàn thành chương trình mầm non</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.hoanThanhChuongTrinhMamMon"
                                     :placeholder="'Chọn'" filterable :data="list_hoan_thanh_hay_khong"
                                     :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.hoanThanhChuongTrinhTieuHoc">
                            <label>Hoàn thành chương trình tiểu học</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.hoanThanhChuongTrinhTieuHoc"
                                     :placeholder="'Chọn'" filterable :data="list_hoan_thanh_hay_khong"
                                     :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.isKhamSkDky">
                            <label>Khám sức khỏe định kỳ</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.isKhamSkDky" :placeholder="'Chọn'"
                                     filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.kthuongCnam">
                            <label>Khen thưởng cuối năm</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.kthuongCnam" :placeholder="'Chọn'"
                                     filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.kthuongDxuat">
                            <label>Khen thưởng đột xuất</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.kthuongDxuat"
                                     :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.lamQuenThoc">
                            <label>Làm quen tin học</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.lamQuenThoc" :placeholder="'Chọn'"
                                     filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.lenLop">
                            <label>Lên lớp</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.lenLop" :placeholder="'Chọn'"
                                     filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.phoiIchayHhap">
                            <label>Có bệnh về ỉa chảy, hô hấp</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.phoiIchayHhap"
                                     :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.suyDduongTheTcoi">
                            <label>Suy dinh dưỡng thể thấp còi</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.suyDduongTheTcoi"
                                     :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.theoDoiBdoCcao">
                            <label>Theo dõi biểu đồ chiều cao</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.theoDoiBdoCcao"
                                     :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.theoDoiBdoCnang">
                            <label>Theo dõi biểu đồ cân nặng</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.theoDoiBdoCnang"
                                     :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maHocLuc">
                            <label>Học lực</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.maHocLuc" :placeholder="'Chọn'"
                                     filterable :data="list_hoc_luc" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maHanhKiem">
                            <label>Hạnh kiểm</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.maHanhKiem" :placeholder="'Chọn'"
                                     filterable :data="list_hanh_kiem" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maDanhHieu">
                            <label>Danh hiệu</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.maDanhHieu" :placeholder="'Chọn'"
                                     filterable :data="list_danh_hieu" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.renLuyenLai">
                            <label>Rèn luyện lại</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.renLuyenLai" :placeholder="'Chọn'"
                                     filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.soNgayNghi">
                            <label>Số ngày nghỉ</label>
                            <input type="number" v-on:keyup.enter="getListStudent" class="form-control"
                                   placeholder="Nhập..." v-model="nangCao.soNgayNghi">

                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.thiLai">
                            <label>Thi lại</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.thiLai" :placeholder="'Chọn'"
                                     filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" class="col-md-2" v-if="hienThiNangCao.totNghiep">
                            <label>Tốt nghiệp</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.totNghiep" :placeholder="'Chọn'"
                                     filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maLoaiTotNghiep">
                            <label>Loại tốt nghiệp</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.maLoaiTotNghiep"
                                     :placeholder="'Chọn'" filterable :data="ds_loai_tot_nghiep_sme"
                                     :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.duXetTotNghiep">
                            <label>Dự xét tốt nghiệp</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.duXetTotNghiep"
                                     :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.maMonHoc">
                            <label>Môn học</label>
                            <el-select v-model="nangCao.maMonHoc" filterable collapse-tags placeholder="Chọn"
                                       no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in danh_sach_mon_hoc_tra_cuu_hoc_tap" :key="item.id"
                                           :label="item.name" :value="item.id">
                                </el-option>
                            </el-select>
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.moetCode">
                            <label>Mã định danh bộ GD&ĐT</label>
                            <el-input type="text" v-on:keyup.enter="getListStudent" clearable
                                      @change="nangCao.moetCode = nangCao.moetCode.trim()" placeholder="Nhập..."
                                      v-model="nangCao.moetCode" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.trangThai">
                            <label>Trạng thái</label>

                            <eselect style="width:100%" collapseTags v-model="nangCao.trangThai" :placeholder="'Chọn'"
                                     filterable :data="list_trang_thai_hoc_sinh" :fields="['name','id']" />
                            <!-- <select v-model="nangCao.trangThai" class="form-control">
                                <option value="">Chọn</option>
                                <option value="1">Đang học</option>
                                <option value="3">Chuyển khỏi trường</option>
                                <option value="4">Bỏ học</option>
                            </select> -->
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.chieuCao">
                            <label>Chiều cao</label>
                            <el-input type="text" @change="nangCao.chieuCao" clearable placeholder="Nhập..."
                                      v-model="nangCao.chieuCao" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.canNang">
                            <label>Cân nặng</label>
                            <el-input type="text" clearable @change="nangCao.canNang = nangCao.canNang.trim()"
                                      placeholder="Nhập..." v-model="nangCao.canNang" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.benhMat">
                            <label>Bệnh về mắt</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.benhMat" :placeholder="'Chọn'"
                                     filterable :data="list_benh_ve_mat" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.isBietBoiKy1">
                            <label>Biết bơi kỳ 1</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.isBietBoiKy1"
                                     :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.isBietBoiKy2">
                            <label>Biết bơi kỳ 2</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.isBietBoiKy2"
                                     :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.tieuChiBoSung">
                            <label>Tiêu chí bố sung</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.tieuChiBoSung"
                                     :placeholder="'Chọn'" filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.TvDgtx">
                            <label>Đánh giá Tiếng Việt</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.TvDgtx" :placeholder="'Chọn'"
                                     filterable :data="danh_sach_kq_danh_gia_mon" :fields="['name','value']" />
                        </el-col>
                        <!-- <el-col :sm="12" :md="6" v-if="hienThiNangCao.tenLopHoc">
                            <label>Tên lớp học</label>
                            <el-input type="text" clearable @change="nangCao.tenLopHoc = nangCao.tenLopHoc.trim()"
                                placeholder="Nhập..." v-model="nangCao.tenLopHoc" />
                        </el-col> -->
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
                        <el-col :sm="12" :md="6" v-if="hienThiNangCao.beoPhi">
                            <label>Béo phì, thừa cân</label>
                            <eselect style="width:100%" collapseTags v-model="nangCao.beoPhi" :placeholder="'Chọn'"
                                     filterable :data="list_co_khong" :fields="['name','value']" />
                        </el-col>
                    </template>
                    <el-col :span="24" class="text-center">
                        <el-button class="bt-chinh" plain type="success" size="mini"
                                   @click.prevent="checkTruocKhiTim()">Tìm
                            kiếm
                        </el-button>
                        <el-button class="bt-phu" v-if="danhSachTimKiemNangCao.length>0"
                                   @click.prevent="danhSachTimKiemNangCao=[]" plain type="primary" size="mini"> Đóng tìm kiếm
                            nâng
                            cao
                        </el-button>
                    </el-col>

                </el-row>

            </el-form>
        </div>

        <!-- hết filter -->
        <!-- buttom -->
        <!-- hết button -->
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <!-- <el-col :span="12" class="">
                    <label class="table-name">Danh sách kết quả học tập học sinh</label>
                </el-col>
                <el-col :span="12">
                    <div class="text-right" style="padding-bottom:5px">
                        <span style="padding-right:20px" v-if="lsDelete.length"><b>Đã chọn
                                {{ lsDelete.length }} bản ghi</b></span>
                        <el-tooltip content="Xóa dữ liệu kết quả học tập" placement="top">
                            <el-button class="bt-chinh" v-if="lsDelete.length" plain size="mini"
                                @click.prevent="DeleteStudent()" type="danger">Xóa
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Xuất dữ liệu" placement="top">
                            <el-button class="bt-chinh" plain type="success" :disabled="list_hocsinh.length==0"
                                size="mini" @click.prevent="xuatDuLieuKetQuaHocTap()">Xuất excel
                            </el-button>
                        </el-tooltip>
                    </div>
                </el-col> -->

                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <label class="table-name">Danh sách kết quả học tập học sinh</label>
                        <div class="text-right">
                            <span style="padding-right:20px" v-if="lsDelete.length"><b>Đã chọn
                                    {{ lsDelete.length }} bản ghi</b></span>
                            <el-tooltip content="Xóa dữ liệu kết quả học tập" placement="top">
                                <el-button class="bt-xoa" v-if="lsDelete.length" plain size="mini"
                                           @click.prevent="DeleteStudent()" type="danger">Xóa
                                </el-button>
                            </el-tooltip>
                            <el-tooltip content="Đẩy lại dữ liệu lên bộ" placement="top">
                                <el-button class="bt-phu" v-if="lsDelete.length" plain size="mini"
                                           @click.prevent="dayLenBo()" type="primary">Đẩy dữ
                                    liệu
                                </el-button>
                            </el-tooltip>
                            <el-tooltip content="Xuất dữ liệu" placement="top">
                                <el-button class="bt-chinh" plain type="success" :disabled="list_hocsinh.length==0"
                                    size="mini" @click.prevent="xuatDuLieuKetQuaHocTap()">Xuất excel
                                </el-button>
                            </el-tooltip>
                        </div>
                    </div>
                </el-col>
                <el-col :span="24">

                    <div>
                        <el-table
                                max-height="700"
                                :data="list_hocsinh"
                                fit border style="width: 100%"
                                empty-text="Không có bản ghi nào"
                        >
                            <!-- Checkbox Column -->
                            <el-table-column width="50" align="center" fixed>
                                <template #header>
                                    <input type="checkbox" v-model="slectAll" @change="ChonTatCa" />
                                </template>
                                <template #default="scope">
                                    <input type="checkbox" v-model="lsDelete" :value="scope.row.tongKetHsId" />
                                </template>
                            </el-table-column>

                            <!-- STT Column -->
                            <el-table-column
                                    label="STT"
                                    :width="start > 9999 ? 70 : 60"
                                    align="center"
                                    fixed="left"
                            >
                                <template #default="scope">
                                    <span>{{ (currentPage - 1) * limit + scope.$index + 1 }}</span>
                                </template>
                            </el-table-column>

                            <!-- Dynamic Columns -->
                            <el-table-column
                                    v-for="(item, i) in cotHienThi"
                                    :key="i"
                                    :label="item.name"
                                    :prop="item.key"
                                    :fixed="item.fixed || false"
                                    :min-width="columnWidths[item.key]"
                            >
                                <template #default="scope">
                                    <template v-if="item.key === 'tenHocSinh' || item.key === 'maHocSinh'">
                                        <a href="#" @click.prevent="getInfo(scope.row.tongKetHsId)">
                                            {{ scope.row[item.key] }}
                                        </a>
                                    </template>
                                    <template v-else-if="item.key === 'khoiHoc'">
                                        <span v-if="scope.row.khoiHoc === 13 || scope.row.khoiHoc === 14 || scope.row.khoiHoc === 15">Nhà trẻ</span>
                                        <span v-else-if="scope.row.khoiHoc === 16 || scope.row.khoiHoc === 17 || scope.row.khoiHoc === 18">Mẫu giáo</span>
                                        <span v-else>{{ scope.row.khoiHoc }}</span>
                                    </template>
                                    <template v-else-if="item.key === 'namHoc'">
                                        <span>{{ scope.row.namHoc }} - {{ scope.row.namHoc + 1 }}</span>
                                    </template>
                                    <template v-else-if="item.key === 'hocKy'">
                                        <span>{{getHocKy(scope.row.hocKy)}}</span>
                                    </template>
                                    <template v-else>
                                        <span>{{ scope.row[item.key] }}</span>
                                    </template>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>


<!--                    <div class="table-responsive">-->
<!--                        <table class="table table-bordered table-striped table-hover">-->
<!--                            <thead>-->
<!--                                <tr style="background:#e4ebf5">-->
<!--                                    <th class="cg fixed-column fixedCol1">-->
<!--                                        <input type="checkbox" v-model="slectAll" @change="ChonTatCa" /></th>-->
<!--                                    <th class="cg fixed-column fixedCol2">-->
<!--                                        <p>STT</p>-->
<!--                                    </th>-->
<!--                                    <th v-for="(item,i) in cotHienThi" :key="i">-->
<!--                                        <p>{{ item.name }}</p>-->
<!--                                    </th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody v-if="list_hocsinh.length==0">-->
<!--                                <tr>-->
<!--                                    <td :colspan="danhSachTimKiem.length+3" class="cg">-->
<!--                                        <p>Không có bản ghi nào</p>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                            <tbody v-else>-->
<!--                                <tr v-for="(hs,i) in list_hocsinh" :key="i">-->
<!--                                    <td class="text-center fixed-column fixedCol1">-->
<!--                                        <input type="checkbox" v-model="lsDelete" :value="hs.tongKetHsId" />-->
<!--                                    </td>-->
<!--                                    <td class="text-center fixed-column fixedCol2">-->
<!--                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maTruongHoc">-->
<!--                                        <p>{{ hs.maTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.tenTruongHoc">-->
<!--                                        <p>{{ hs.tenTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.capHoc">-->
<!--                                        <p>{{ hs.capHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.khoiHoc">-->
<!--                                        <p v-if="hs.khoiHoc==13||hs.khoiHoc==14||hs.khoiHoc==15">Nhà trẻ</p>-->
<!--                                        <p v-else-if="hs.khoiHoc==16||hs.khoiHoc==17||hs.khoiHoc==18">Mẫu giáo-->
<!--                                        </p>-->
<!--                                        <p v-else>{{ hs.khoiHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.tenLopHoc">-->
<!--                                        <p>{{ hs.tenLopHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.tenHocSinh">-->
<!--                                        <a href="#" v-on:click.prevent="getInfo(hs.tongKetHsId)">{{ hs.tenHocSinh }}</a>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maHocSinh">-->
<!--                                        <a href="#" v-on:click.prevent="getInfo(hs.tongKetHsId)">{{ hs.maHocSinh }}</a>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.moetCode">-->
<!--                                        <p>{{ hs.moetCode }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.trangThai">-->
<!--                                        &lt;!&ndash; <p>{{getTrangThaiHocSinh(hs.trangThai)}}</p> &ndash;&gt;-->
<!--                                        <p>{{ hs.trangThai }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.diemTongKet">-->
<!--                                        <p>{{ hs.diemTongKet }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.namHoc">-->
<!--                                        <p>{{ hs.namHoc }} - {{ hs.namHoc + 1 }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.hocKy">-->
<!--                                        <p>{{ getHocKy(hs.hocKy) }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.giaiDoan">-->
<!--                                        <p>{{ hs.giaiDoan }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maHocLuc">-->
<!--                                        <p>{{ hs.maHocLuc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maHanhKiem">-->
<!--                                        <p>{{ hs.maHanhKiem }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maDanhHieu">-->
<!--                                        <p>{{ hs.maDanhHieu }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.hthanhCtrinhLhoc">-->
<!--                                        <p>{{ hs.hthanhCtrinhLhoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.hoanThanhChuongTrinhMamMon">-->
<!--                                        <p>{{ hs.hoanThanhChuongTrinhMamMon }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.hoanThanhChuongTrinhTieuHoc">-->
<!--                                        <p>{{ hs.hoanThanhChuongTrinhTieuHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.kthuongCnam">-->
<!--                                        <p>{{ hs.kthuongCnam }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.kthuongDxuat">-->
<!--                                        <p>{{ hs.kthuongDxuat }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.lenLop">-->
<!--                                        <p>{{ hs.lenLop }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.renLuyenLai">-->
<!--                                        <p>{{ hs.renLuyenLai }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.thiLai">-->
<!--                                        <p>{{ hs.thiLai }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.duXetTotNghiep">-->
<!--                                        <p>{{ hs.duXetTotNghiep }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.totNghiep">-->
<!--                                        <p>{{ hs.totNghiep }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maLoaiTotNghiep">-->
<!--                                        <p>{{ hs.maLoaiTotNghiep }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.soNgayNghi">-->
<!--                                        <p>{{ hs.soNgayNghi }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.danhGiaKQGiaoDuc">-->
<!--                                        <p>{{ hs.danhGiaKQGiaoDuc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.kqHocTap">-->
<!--                                        <p>{{ hs.kqHocTap }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.kqRenLuyen">-->
<!--                                        <p>{{ hs.kqRenLuyen }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.kiemTraSucKhoeDinhDuong">-->
<!--                                        <p v-if="hs.kiemTraSucKhoeDinhDuong">Có</p>-->
<!--                                        <p v-else>Không</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.chieuCao">-->
<!--                                        <p v-if="hs.chieuCao">{{ hs.chieuCao.toFixed(1) }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.canNang">-->
<!--                                        <p v-if="hs.canNang">{{ hs.canNang.toFixed(1) }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.benhMat">-->
<!--                                        <p>{{ getTenBenhVeMat(hs.benhMat) }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.isBietBoiKy1">-->
<!--                                        <p>{{ hs.isBietBoiKy1 }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.isBietBoiKy2">-->
<!--                                        <p>{{ hs.isBietBoiKy2 }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.tieuChiBoSung">-->
<!--                                        <p>{{ hs.tieuChiBoSung }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.TvDgtx">-->
<!--                                        <p>{{ hs.TvDgtx }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.LoaiChungChiNghe">-->
<!--                                        <p>{{ hs.LoaiChungChiNghe }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.khenThuongCapHuyen">-->
<!--                                        <p>{{ hs.khenThuongCapHuyen }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.TinhTrangDinhDuong">-->
<!--                                        <p>{{ hs.TinhTrangDinhDuong }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.isKhamSkDky">-->
<!--                                        <p>{{ hs.isKhamSkDky }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.isSuyDduongTheNheCan">-->
<!--                                        <p>{{ hs.isSuyDduongTheNheCan }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.isSuyDduongTheCoiCoc">-->
<!--                                        <p>{{ hs.isSuyDduongTheCoiCoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.beoPhi">-->
<!--                                        <p>{{ hs.beoPhi }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.suyDduongTheTcoi">-->
<!--                                        <p>{{ hs.suyDduongTheTcoi }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.theoDoiBdoCcao">-->
<!--                                        <p>{{ hs.theoDoiBdoCcao }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.theoDoiBdoCnang">-->
<!--                                        <p>{{ hs.theoDoiBdoCnang }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.phoiIchayHhap">-->
<!--                                        <p>{{ hs.phoiIchayHhap }}</p>-->
<!--                                    </td>-->
<!--                                    &lt;!&ndash;-->
<!--                <td v-if="hangHienThi.isKhamSkDky">-->
<!--                    <p>{{hs.isKhamSkDky}}</p>-->
<!--                </td>-->
<!--                <td v-if="hangHienThi.lamQuenThoc">-->
<!--                    <p>{{hs.lamQuenThoc}}</p>-->
<!--                </td>-->
<!--                <td v-if="hangHienThi.soCmnd">-->
<!--                    <p>{{hs.soCmnd}}</p>-->
<!--                </td>-->
<!--                <td v-if="hangHienThi.phoiIchayHhap">-->
<!--                    <p>{{hs.phoiIchayHhap}}</p>-->
<!--                </td>-->
<!--                <td v-if="hangHienThi.suyDduongTheTcoi">-->
<!--                    <p>{{hs.suyDduongTheTcoi}}</p>-->
<!--                </td>-->
<!--                <td v-if="hangHienThi.theoDoiBdoCcao">-->
<!--                    <p>{{hs.theoDoiBdoCcao}}</p>-->
<!--                </td>-->
<!--                <td v-if="hangHienThi.theoDoiBdoCnang">-->
<!--                    <p>{{hs.theoDoiBdoCnang}}</p>-->
<!--                </td>-->
<!--                <td v-if="hangHienThi.maMonHoc">-->
<!--                    <p>{{hs.maMonHoc}}</p>-->
<!--                </td> &ndash;&gt;-->
<!--                                    &lt;!&ndash; <td class="text-center">-->
<!--                                <el-button size="mini" @click.prevent="hienThiDiemChiTietMon(hs)"-->
<!--                                    type="primary">Xem điểm-->
<!--                                </el-button>-->
<!--                            </td> &ndash;&gt;-->
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
                <ThongTin :show="show_info" :item="idHocSinh" @close="show_info=false"></ThongTin>
                <XuatExcel :show="show_excel_kqht" @close="show_excel_kqht=false" @submit="submitExcel($event)"
                    :rowsview="limit" :total="total_rows" :limit="10">
                </XuatExcel>
                <el-col v-if="false" :span="24" style="padding:0">
                    <el-row :gutter="24">
                        <el-col :span="24" class="reset">
                            <div class="text-right" style="padding-bottom:5px">
                                <span style="padding-right:20px" v-if="lsDelete.length"><b>Đã chọn
                                        {{ lsDelete.length }} bản ghi</b></span>
                                <el-tooltip content="Xóa dữ liệu kết quả học tập" placement="top">
                                    <el-button class="bt-chinh" v-if="lsDelete.length" plain size="mini"
                                        @click.prevent="DeleteStudent()" type="danger">Xóa
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="Xuất dữ liệu" placement="top">
                                    <el-button class="bt-chinh" plain type="success" :disabled="list_hocsinh.length==0"
                                        size="mini" @click.prevent="xuatDuLieuKetQuaHocTap()">Xuất excel
                                    </el-button>
                                </el-tooltip>
                            </div>
                        </el-col>
                    </el-row>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="cg fixed-column fixedCol1">
                                        <input type="checkbox" v-model="slectAll" @change="ChonTatCa" /></th>
                                    <th class="cg fixed-column fixedCol2">
                                        <p>STT</p>
                                    </th>
                                    <th v-for="(item,i) in cotHienThi" :key="i">
                                        <p>{{ item.name }}</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_hocsinh.length==0">
                                <tr>
                                    <td :colspan="danhSachTimKiem.length+3" class="cg">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(hs,i) in list_hocsinh" :key="i">
                                    <td class="text-center fixed-column fixedCol1">
                                        <input type="checkbox" v-model="lsDelete" :value="hs.tongKetHsId" />
                                    </td>
                                    <td class="text-center fixed-column fixedCol2">
                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>
                                    </td>
                                    <td v-if="hangHienThi.maTruongHoc">
                                        <p>{{ hs.maTruongHoc }}</p>
                                    </td>
                                    <td v-if="hangHienThi.tenTruongHoc">
                                        <p>{{ hs.tenTruongHoc }}</p>
                                    </td>
                                    <td v-if="hangHienThi.capHoc">
                                        <p>{{ hs.capHoc }}</p>
                                    </td>
                                    <td v-if="hangHienThi.khoiHoc">
                                        <p v-if="hs.khoiHoc==13||hs.khoiHoc==14||hs.khoiHoc==15">Nhà trẻ</p>
                                        <p v-else-if="hs.khoiHoc==16||hs.khoiHoc==17||hs.khoiHoc==18">Mẫu giáo
                                        </p>
                                        <p v-else>{{ hs.khoiHoc }}</p>
                                    </td>
                                    <td v-if="hangHienThi.tenLopHoc">
                                        <p>{{ hs.tenLopHoc }}</p>
                                    </td>
                                    <td v-if="hangHienThi.tenHocSinh">
                                        <a href="#" v-on:click.prevent="getInfo(hs.tongKetHsId)">{{ hs.tenHocSinh }}</a>
                                    </td>
                                    <td v-if="hangHienThi.maHocSinh">
                                        <a href="#" v-on:click.prevent="getInfo(hs.tongKetHsId)">{{ hs.maHocSinh }}</a>
                                    </td>
                                    <td v-if="hangHienThi.moetCode">
                                        <p>{{ hs.moetCode }}</p>
                                    </td>
                                    <td v-if="hangHienThi.trangThai">
                                        <!-- <p>{{getTrangThaiHocSinh(hs.trangThai)}}</p> -->
                                        <p>{{ hs.trangThai }}</p>
                                    </td>
                                    <td v-if="hangHienThi.diemTongKet">
                                        <p>{{ hs.diemTongKet }}</p>
                                    </td>
                                    <td v-if="hangHienThi.namHoc">
                                        <p>{{ hs.namHoc }} - {{ hs.namHoc + 1 }}</p>
                                    </td>
                                    <td v-if="hangHienThi.hocKy">
                                        <p>{{ getHocKy(hs.hocKy) }}</p>
                                    </td>
                                    <td v-if="hangHienThi.giaiDoan">
                                        <p>{{ hs.giaiDoan }}</p>
                                    </td>
                                    <td v-if="hangHienThi.maHocLuc">
                                        <p>{{ hs.maHocLuc }}</p>
                                    </td>
                                    <td v-if="hangHienThi.maHanhKiem">
                                        <p>{{ hs.maHanhKiem }}</p>
                                    </td>
                                    <td v-if="hangHienThi.maDanhHieu">
                                        <p>{{ hs.maDanhHieu }}</p>
                                    </td>
                                    <td v-if="hangHienThi.hthanhCtrinhLhoc">
                                        <p>{{ hs.hthanhCtrinhLhoc }}</p>
                                    </td>
                                    <td v-if="hangHienThi.hoanThanhChuongTrinhMamMon">
                                        <p>{{ hs.hoanThanhChuongTrinhMamMon }}</p>
                                    </td>
                                    <td v-if="hangHienThi.hoanThanhChuongTrinhTieuHoc">
                                        <p>{{ hs.hoanThanhChuongTrinhTieuHoc }}</p>
                                    </td>
                                    <td v-if="hangHienThi.kthuongCnam">
                                        <p>{{ hs.kthuongCnam }}</p>
                                    </td>
                                    <td v-if="hangHienThi.kthuongDxuat">
                                        <p>{{ hs.kthuongDxuat }}</p>
                                    </td>
                                    <td v-if="hangHienThi.lenLop">
                                        <p>{{ hs.lenLop }}</p>
                                    </td>
                                    <td v-if="hangHienThi.renLuyenLai">
                                        <p>{{ hs.renLuyenLai }}</p>
                                    </td>
                                    <td v-if="hangHienThi.thiLai">
                                        <p>{{ hs.thiLai }}</p>
                                    </td>
                                    <td v-if="hangHienThi.duXetTotNghiep">
                                        <p>{{ hs.duXetTotNghiep }}</p>
                                    </td>
                                    <td v-if="hangHienThi.totNghiep">
                                        <p>{{ hs.totNghiep }}</p>
                                    </td>
                                    <td v-if="hangHienThi.maLoaiTotNghiep">
                                        <p>{{ hs.maLoaiTotNghiep }}</p>
                                    </td>
                                    <td v-if="hangHienThi.soNgayNghi">
                                        <p>{{ hs.soNgayNghi }}</p>
                                    </td>
                                    <td v-if="hangHienThi.danhGiaKQGiaoDuc">
                                        <p>{{ hs.danhGiaKQGiaoDuc }}</p>
                                    </td>
                                    <td v-if="hangHienThi.kqHocTap">
                                        <p>{{ hs.kqHocTap }}</p>
                                    </td>
                                    <td v-if="hangHienThi.kqRenLuyen">
                                        <p>{{ hs.kqRenLuyen }}</p>
                                    </td>
                                    <td v-if="hangHienThi.kiemTraSucKhoeDinhDuong">
                                        <p v-if="hs.kiemTraSucKhoeDinhDuong">Có</p>
                                        <p v-else>Không</p>
                                    </td>
                                    <td v-if="hangHienThi.chieuCao">
                                        <p v-if="hs.chieuCao">{{ hs.chieuCao.toFixed(1) }}</p>
                                    </td>
                                    <td v-if="hangHienThi.canNang">
                                        <p v-if="hs.canNang">{{ hs.canNang.toFixed(1) }}</p>
                                    </td>
                                    <td v-if="hangHienThi.benhMat">
                                        <p>{{ getTenBenhVeMat(hs.benhMat) }}</p>
                                    </td>
                                    <td v-if="hangHienThi.isBietBoiKy1">
                                        <p>{{ hs.isBietBoiKy1 }}</p>
                                    </td>
                                    <td v-if="hangHienThi.isBietBoiKy2">
                                        <p>{{ hs.isBietBoiKy2 }}</p>
                                    </td>
                                    <td v-if="hangHienThi.tieuChiBoSung">
                                        <p>{{ hs.tieuChiBoSung }}</p>
                                    </td>
                                    <td v-if="hangHienThi.TvDgtx">
                                        <p>{{ hs.TvDgtx }}</p>
                                    </td>
                                    <td v-if="hangHienThi.LoaiChungChiNghe">
                                        <p>{{ hs.LoaiChungChiNghe }}</p>
                                    </td>
                                    <td v-if="hangHienThi.khenThuongCapHuyen">
                                        <p>{{ hs.khenThuongCapHuyen }}</p>
                                    </td>
                                    <td v-if="hangHienThi.TinhTrangDinhDuong">
                                        <p>{{ hs.TinhTrangDinhDuong }}</p>
                                    </td>
                                    <td v-if="hangHienThi.isKhamSkDky">
                                        <p>{{ hs.isKhamSkDky }}</p>
                                    </td>
                                    <td v-if="hangHienThi.isSuyDduongTheNheCan">
                                        <p>{{ hs.isSuyDduongTheNheCan }}</p>
                                    </td>
                                    <td v-if="hangHienThi.isSuyDduongTheCoiCoc">
                                        <p>{{ hs.isSuyDduongTheCoiCoc }}</p>
                                    </td>
                                    <td v-if="hangHienThi.beoPhi">
                                        <p>{{ hs.beoPhi }}</p>
                                    </td>
                                    <td v-if="hangHienThi.suyDduongTheTcoi">
                                        <p>{{ hs.suyDduongTheTcoi }}</p>
                                    </td>
                                    <td v-if="hangHienThi.theoDoiBdoCcao">
                                        <p>{{ hs.theoDoiBdoCcao }}</p>
                                    </td>
                                    <td v-if="hangHienThi.theoDoiBdoCnang">
                                        <p>{{ hs.theoDoiBdoCnang }}</p>
                                    </td>
                                    <td v-if="hangHienThi.phoiIchayHhap">
                                        <p>{{ hs.phoiIchayHhap }}</p>
                                    </td>
                                    <!--
                        <td v-if="hangHienThi.isKhamSkDky">
                            <p>{{hs.isKhamSkDky}}</p>
                        </td>
                        <td v-if="hangHienThi.lamQuenThoc">
                            <p>{{hs.lamQuenThoc}}</p>
                        </td>
                        <td v-if="hangHienThi.soCmnd">
                            <p>{{hs.soCmnd}}</p>
                        </td>
                        <td v-if="hangHienThi.phoiIchayHhap">
                            <p>{{hs.phoiIchayHhap}}</p>
                        </td>
                        <td v-if="hangHienThi.suyDduongTheTcoi">
                            <p>{{hs.suyDduongTheTcoi}}</p>
                        </td>
                        <td v-if="hangHienThi.theoDoiBdoCcao">
                            <p>{{hs.theoDoiBdoCcao}}</p>
                        </td>
                        <td v-if="hangHienThi.theoDoiBdoCnang">
                            <p>{{hs.theoDoiBdoCnang}}</p>
                        </td>
                        <td v-if="hangHienThi.maMonHoc">
                            <p>{{hs.maMonHoc}}</p>
                        </td> -->
                                    <!-- <td class="text-center">
                                        <el-button size="mini" @click.prevent="hienThiDiemChiTietMon(hs)"
                                            type="primary">Xem điểm
                                        </el-button>
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <el-row :gutter="24">
                        <el-col :span="12">
                            <ChonSoLuong @chonXongSoLuong="ChonSoLuongBanGhi($event)">
                            </ChonSoLuong>
                        </el-col>
                        <el-col :span="12">

                            <PhanTrang v-show="total_rows>0" :tongbanghi="total_rows"
                                :soluonghienthi="soLuongBanGhiHienThi" :batdau="trangbatdau"
                                @pageChange="layLai($event)">
                            </PhanTrang>
                        </el-col>
                    </el-row>
                    <ThongTin :show="show_info" :item="idHocSinh" @close="show_info=false"></ThongTin>
                    <XuatExcel :show="show_excel_kqht" @close="show_excel_kqht=false" @submit="submitExcel($event)"
                        :rowsview="limit" :total="total_rows" :limit="10">
                    </XuatExcel>
                </el-col>
            </el-row>
        </div>
        <div>
            <div v-if="showEditHocSinh">
                <component :item="dataEditHocSinh" :is="current_view" @close="showEditHocSinh=false"
                    @reload="onReLoad()"></component>
            </div>
            <!-- Hết chỉnh sửa học sinh -->
            <!-- Thông tin -->
            <!-- <div v-if="show_info"> -->
        </div>
        <div>
            <el-dialog title="Điểm chi tiết môn" top="5vh" width="75%" :visible.sync="show_diem_chi_tiet_mon">
                <el-row :gutter="24" style="height:70vh; overflow:scroll">
                    <el-col :span="12">
                        <p>Học kỳ 1</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" style="white-space: normal;">
                                <thead style="background:#d6d6d6">
                                    <tr class="text-center">
                                        <th class="text-center">
                                            <p>STT</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Môn học</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Loại điểm</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Điểm số</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Nhận xét</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="thongTinDiem.ky1.length">
                                        <tr v-for="(item,index) in thongTinDiem.ky1">
                                            <td class="text-center">
                                                <p>{{ index + 1 }}</p>
                                            </td>
                                            <td>
                                                <p>{{ item.tenMonHoc }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{ item.loaiDiem }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{ item.diemSo }}</p>
                                            </td>
                                            <td>
                                                <p>{{ item.nhanXetCuaGv }}</p>
                                            </td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <p>Chưa có dữ liệu</p>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </el-col>
                    <el-col :span="12">
                        <p>Học kỳ 2</p>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" style="white-space: normal;">
                                <thead style="background:#d6d6d6">
                                    <tr class="text-center">
                                        <th class="text-center">
                                            <p>STT</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Môn học</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Loại điểm</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Điểm số</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Nhận xét</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template v-if="thongTinDiem.ky2.length">
                                        <tr v-for="(item,index) in thongTinDiem.ky2">
                                            <td class="text-center">
                                                <p>{{ index + 1 }}</p>
                                            </td>
                                            <td>
                                                <p>{{ item.tenMonHoc }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{ item.loaiDiem }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{ item.diemSo }}</p>
                                            </td>
                                            <td>
                                                <p>{{ item.nhanXetCuaGv }}</p>
                                            </td>
                                        </tr>
                                    </template>
                                    <template v-else>
                                        <tr>
                                            <td colspan="5" class="text-center">
                                                <p>Chưa có dữ liệu</p>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </el-col>
                </el-row>
                <div slot="footer" class="dialog-footer">
                    <el-button class="bt-phu" size="mini" @click="show_diem_chi_tiet_mon = false">Đóng</el-button>
                </div>
            </el-dialog>
        </div>
    </div>
    <!-- hết template -->
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import constant from '../../utils/constant';
    import moment from "moment";
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import ThongTin from './ThongTinKetQuaHocTap';
    import ChinhSua from './ChinhSuaKetQuaHocTapHocSinh'
    import api from '../api';
    import Page from "../ui/PagingCustom";
    import PhanTrang from "../ui/PagingCustom";
    import ChonSoLuong from "../ui/chonSoLuongBanGhi";
    import ESelectVue from '../ui/ESelect.vue';
    import dialog from '../../utils/dialog';
    import VueAlertify from "vue-alertify";
    import utils from '../../utils';
    import ElementUI from 'element-ui';
    import XuatExcel from '../ui/chonSoLuongXuatExcel';
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
            Multiselect,
            Page: Page,
            'thongtin-hocsinh': ThongTin,
            'ChinhSua': ChinhSua,
            'ThongTin': ThongTin,
            'eselect': ESelectVue,
            "PhanTrang": PhanTrang,
            ChonSoLuong: ChonSoLuong,
            XuatExcel: XuatExcel,
            Breadcrumb
        },
        data() {
            return {
                fullScreenLoading: false,
                show_diem_chi_tiet_mon: false,
                thongTinDiem: {
                    ky1: [],
                    ky2: []
                },
                ds_loai_tot_nghiep_sme: [],
                list_giai_doan: [],
                danhSachTimKiemNangCao: [],
                hienThiNangCao: {
                    kiemTraSucKhoeDinhDuong: false,
                    chieuCao: false,
                    canNang: false,
                    benhMat: false,
                    isBietBoiKy1: false,
                    isBietBoiKy2: false,
                    tieuChiBoSung: false,
                    TvDgtx: false,
                    hthanhCtrinhLhoc: false,
                    hoanThanhChuongTrinhMamMon: false,
                    hoanThanhChuongTrinhTieuHoc: false,
                    isKhamSkDky: false,
                    kthuongCnam: false,
                    kthuongDxuat: false,
                    lamQuenThoc: false,
                    lenLop: false,
                    phoiIchayHhap: false,
                    suyDduongTheTcoi: false,
                    theoDoiBdoCcao: false,
                    theoDoiBdoCnang: false,
                    maHocLuc: false,
                    maHanhKiem: false,
                    maDanhHieu: false,
                    renLuyenLai: false,
                    thiLai: false,
                    soNgayNghi: false,
                    totNghiep: false,
                    maLoaiTotNghiep: false,
                    duXetTotNghiep: false,
                    maMonHoc: false,
                    moetCode: false,
                    trangThai: false,
                },
                list_tim_kiem_nang_cao: [
                    // {
                    //     value: 'kiemTraSucKhoeDinhDuong',
                    //     name: "Kiểm tra sức khỏe dinh dưỡng"
                    // },
                    {
                        value: 'hthanhCtrinhLhoc',
                        name: "Hoàn thành chương trình lớp học"
                    }, {
                        value: 'hoanThanhChuongTrinhMamMon',
                        name: "Hoàn thành chương trình mầm non"
                    }, {
                        value: 'hoanThanhChuongTrinhTieuHoc',
                        name: "Hoàn thành chương trình tiểu học"
                    },
                    {
                        value: 'isKhamSkDky',
                        name: "Khám sức khỏe định kỳ"
                    },
                    // {
                    //     value: 'kthuongCnam',
                    //     name: "Khen thưởng cuối năm"
                    // },
                    // {
                    //     value: 'kthuongDxuat',
                    //     name: "Khen thưởng đột xuất"
                    // },
                    {
                        value: 'lamQuenThoc',
                        name: "Làm quen tin học"
                    },
                    {
                        value: 'lenLop',
                        name: "Lên lớp"
                    },
                    {
                        value: 'phoiIchayHhap',
                        name: "Có bệnh về ỉa chảy, hô hấp"
                    },
                    {
                        value: 'suyDduongTheTcoi',
                        name: "Suy dinh dưỡng thể thấp còi"
                    },
                    {
                        value: 'theoDoiBdoCcao',
                        name: "Theo dõi biểu đồ chiều cao"
                    },
                    {
                        value: 'theoDoiBdoCnang',
                        name: "Theo dõi biểu đồ cân nặng"
                    },
                    {
                        value: 'renLuyenLai',
                        name: "Rèn luyện lại"
                    },
                    {
                        value: 'thiLai',
                        name: "Thi lại"
                    },
                    {
                        value: 'soNgayNghi',
                        name: "Số ngày nghỉ"
                    },
                    {
                        value: 'totNghiep',
                        name: "Tốt nghiệp"
                    },
                    {
                        value: 'maLoaiTotNghiep',
                        name: "Loại tốt nghiệp"
                    },
                    {
                        value: 'duXetTotNghiep',
                        name: "Dự xét tốt nghiệp"
                    },
                    // {
                    //     value: 'maMonHoc',
                    //     name: "Môn học"
                    // },
                    {
                        value: 'moetCode',
                        name: "Mã định danh bộ GD&ĐT"
                    },
                    {
                        value: 'trangThai',
                        name: "Trạng thái"
                    },
                    {
                        value: 'maHocLuc',
                        name: "Học lực"
                    },
                    {
                        value: 'maHanhKiem',
                        name: "Hạnh kiểm"
                    },
                    {
                        value: 'maDanhHieu',
                        name: "Danh hiệu"
                    },
                    // {
                    //     value: 'chieuCao',
                    //     name: "Chiều cao"
                    // }, {
                    //     value: 'canNang',
                    //     name: "Cân nặng"
                    // },
                    // {
                    //     value: 'benhMat',
                    //     name: "Bệnh về mắt"
                    // }, {
                    //     value: 'isBietBoiKy1',
                    //     name: "Biết bơi kỳ 1"
                    // }, {
                    //     value: 'isBietBoiKy2',
                    //     name: "Biết bơi kỳ 2"
                    // }
                    // , {
                    //     value: 'tieuChiBoSung',
                    //     name: "Tiêu chí bổ sung"
                    // },
                    {
                        value: 'TvDgtx',
                        name: "Đánh giá Tiếng Việt"
                    },
                    {
                        value: 'tenLopHoc',
                        name: "Tên lớp học"
                    },
                    {
                        value: 'isSuyDduongTheNheCan',
                        name: 'Suy dinh dưỡng thể nhẹ cân'
                    },
                    {
                        value: 'isSuyDduongTheCoiCoc',
                        name: 'Suy dinh dưỡng thể còi cọc'
                    },
                    {
                        value: 'beoPhi',
                        name: 'Béo phì, thừa cân'
                    },
                ],
                nangCao: {
                    kiemTraSucKhoeDinhDuong: '',
                    chieuCao: '',
                    canNang: '',
                    benhMat: '',
                    isBietBoiKy1: '',
                    isBietBoiKy2: '',
                    tieuChiBoSung: [],
                    TvDgtx: [],
                    tenLopHoc: '',
                    isSuyDduongTheNheCan: '',
                    isSuyDduongTheCoiCoc: '',
                    beoPhi: '',
                    hthanhCtrinhLhoc: '',
                    hoanThanhChuongTrinhMamMon: '',
                    hoanThanhChuongTrinhTieuHoc: '',
                    isKhamSkDky: '',
                    kthuongCnam: '',
                    kthuongDxuat: '',
                    lamQuenThoc: '',
                    lenLop: '',
                    phoiIchayHhap: '',
                    suyDduongTheTcoi: '',
                    theoDoiBdoCcao: '',
                    theoDoiBdoCnang: '',
                    maHocLuc: '',
                    maHanhKiem: '',
                    maDanhHieu: '',
                    renLuyenLai: '',
                    thiLai: '',
                    soNgayNghi: '',
                    totNghiep: '',
                    maLoaiTotNghiep: '',
                    duXetTotNghiep: '',
                    maMonHoc: '',
                    moetCode: '',
                    trangThai: '',
                },
                ds_benh_ve_mat_sme: [],
                cotHienThi: [],
                columnWidths : {},
                hangHienThi: {},
                danhSachTimKiem: [],
                danhSachNoiDungHienThi: [],
                danhSachMaTimKiemSo: [
                    "maTruongHoc",
                    "tenTruongHoc",
                    "khoiHoc",
                    "tenLopHoc",
                    "tenHocSinh",
                    "maHocSinh",
                    "moetCode",
                    "trangThai",
                    "diemTongKet",
                    "namHoc",
                    "hocKy",
                    "giaiDoan",
                    "maHocLuc",
                    "maHanhKiem",
                    "maDanhHieu",
                    "kqHocTap",
                    "kqRenLuyen",
                    "kiemTraSucKhoeDinhDuong",
                ],
                danhSachMaTimKiemTruong: [
                    "khoiHoc",
                    "tenLopHoc",
                    "tenHocSinh",
                    "maHocSinh",
                    "moetCode",
                    "trangThai",
                    "diemTongKet",
                    "namHoc",
                    "hocKy",
                    "giaiDoan",
                    "maHocLuc",
                    "maHanhKiem",
                    "maDanhHieu",
                    "kqHocTap",
                    "kqRenLuyen",
                    "kiemTraSucKhoeDinhDuong",
                ],
                list_noi_dung_hien_thi: constant.danh_sach_tim_kiem_danh_sach_ket_qua_hoc_tap,
                danh_sach_mon_hoc_tra_cuu_hoc_tap: constant.danh_sach_mon_hoc_tra_cuu_hoc_tap,
                khoi_cap_mot: constant.khoiCapMot,
                khoi_cap_hai: constant.khoiCapHai,
                khoi_cap_ba: constant.khoiCapBa,
                khoi_cap_4: constant.khoiHocNhaTre,
                khoi_cap_5: constant.khoiHocMauGiao,
                // thông tin người dùng
                isDisabled: false,
                slectAll: false,
                showDataHocSinh: false,
                show_info: false,
                idHocSinh: "",
                showEditHocSinh: false,
                trangbatdau: false,
                current_view: ChinhSua,
                dataEditHocSinh: {},
                thongtin: {},
                dataHocSinh: {},
                date: new Date(),
                list_hocsinh: [],
                list_don_vi: [],
                list_khoi_hoc: [],
                list_hoc_luc: [{
                        name: "Giỏi",
                        value: "G"
                    },
                    {
                        name: "Khá",
                        value: "K"
                    },
                    {
                        name: "Trung bình",
                        value: "TB"
                    },
                    {
                        name: "Yếu",
                        value: "Y"
                    },
                    {
                        name: "Kém",
                        value: "KEM"
                    }
                ],
                list_hanh_kiem: [{
                        name: "Tốt",
                        value: "T"
                    },
                    {
                        name: "Khá",
                        value: "K"
                    },
                    {
                        name: "Trung bình",
                        value: "TB"
                    },
                    {
                        name: "Yếu",
                        value: "Y"
                    }
                ],
                list_danh_hieu: [{
                        name: "Vượt trội",
                        value: "VUOTTROI"
                    },
                    {
                        name: "Xuất sắc",
                        value: "XUATSAC"
                    },
                    {
                        name: "Giỏi",
                        value: "GIOI"
                    },
                    {
                        name: "Tiêu biểu",
                        value: "TIEUBIEU"
                    },
                    {
                        name: "Tiên tiến",
                        value: "TT"
                    }
                ],
                list_co_khong: [{
                        name: 'Có',
                        value: 1
                    },
                    {
                        name: 'Không',
                        value: 0
                    }
                ],
                list_hoan_thanh_hay_khong: [{
                        name: 'Hoàn thành',
                        value: 1
                    },
                    {
                        name: 'Chưa hoàn thành',
                        value: 0
                    }
                ],
                danh_sach_kq_danh_gia_mon: [{
                        name: 'Hoàn thành tốt',
                        value: 'T'
                    },
                    {
                        name: 'Hoàn thành',
                        value: 'H'
                    },
                    {
                        name: 'Chưa hoàn thành',
                        value: 'C'
                    }
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
                lsDelete: [],
                list_cap_hoc: window.listCapHoc,
                list_trang_thai_hoc_sinh: constant.list_trang_thai_hoc_sinh,
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                start_excel_kqht: 0,
                limit_excel_kqht: 30000,
                show_excel_kqht: false,
                soLuongBanGhiHienThi: 25,
                // dùng trong filter
                hocKy: "",
                tenDonViDangNhap: "",
                capHocDangNhap: "",
                tuKhoa: "",
                giaiDoan: "",
                gioiTinh: "",
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_khoi_hoc: [],
                ds_truong_hoc: [],
                namHoc: "",
                list_day_len_bo:[],
                danhSachCapHoc: [],
                list_truong_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_hoc_ky: [{
                        name: "Học kỳ I",
                        value: 1
                    },
                    {
                        name: "Học kỳ II",
                        value: 2
                    },
                    {
                        name: "Cả năm",
                        value: 3
                    },
                ],
                noiDungTimKiem: [],
                // Check xem trang từ bên kết chuyển dữ liệu sang hay không
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
                    this.hienThiNangCao.kiemTraSucKhoeDinhDuong = false;
                    this.hienThiNangCao.chieuCao = false;
                    this.hienThiNangCao.canNang = false;
                    this.hienThiNangCao.benhMat = false;
                    this.hienThiNangCao.isBietBoiKy1 = false;
                    this.hienThiNangCao.isBietBoiKy2 = false;
                    this.hienThiNangCao.tieuChiBoSung = false;
                    this.hienThiNangCao.TvDgtx = false;
                    this.hienThiNangCao.tenLopHoc = false;
                    this.hienThiNangCao.isSuyDduongTheNheCan = false;
                    this.hienThiNangCao.isSuyDduongTheCoiCoc = false;
                    this.hienThiNangCao.beoPhi = false;
                    this.hienThiNangCao.hthanhCtrinhLhoc = false;
                    this.hienThiNangCao.hoanThanhChuongTrinhMamMon = false;
                    this.hienThiNangCao.hoanThanhChuongTrinhTieuHoc = false;
                    this.hienThiNangCao.isKhamSkDky = false;
                    this.hienThiNangCao.kthuongCnam = false;
                    this.hienThiNangCao.kthuongDxuat = false;
                    this.hienThiNangCao.lamQuenThoc = false;
                    this.hienThiNangCao.lenLop = false;
                    this.hienThiNangCao.phoiIchayHhap = false;
                    this.hienThiNangCao.suyDduongTheTcoi = false;
                    this.hienThiNangCao.theoDoiBdoCcao = false;
                    this.hienThiNangCao.theoDoiBdoCnang = false;
                    this.hienThiNangCao.maHocLuc = false;
                    this.hienThiNangCao.maHanhKiem = false;
                    this.hienThiNangCao.maDanhHieu = false;
                    this.hienThiNangCao.renLuyenLai = false;
                    this.hienThiNangCao.thiLai = false;
                    this.hienThiNangCao.soNgayNghi = false;
                    this.hienThiNangCao.totNghiep = false;
                    this.hienThiNangCao.maLoaiTotNghiep = false;
                    this.hienThiNangCao.duXetTotNghiep = false;
                    this.hienThiNangCao.maMonHoc = false;
                    this.hienThiNangCao.moetCode = false;
                    this.hienThiNangCao.trangThai = false;
                    for (let i = 0; i < noidung_hienthi.length; i++) {
                        if (noidung_hienthi[i] == "kiemTraSucKhoeDinhDuong") {
                            this.hienThiNangCao.kiemTraSucKhoeDinhDuong = true
                        }
                        if (noidung_hienthi[i] == "chieuCao") {
                            this.hienThiNangCao.chieuCao = true
                        }
                        if (noidung_hienthi[i] == "canNang") {
                            this.hienThiNangCao.canNang = true
                        }
                        if (noidung_hienthi[i] == "benhMat") {
                            this.hienThiNangCao.benhMat = true
                        }
                        if (noidung_hienthi[i] == "isBietBoiKy1") {
                            this.hienThiNangCao.isBietBoiKy1 = true
                        }
                        if (noidung_hienthi[i] == "isBietBoiKy2") {
                            this.hienThiNangCao.isBietBoiKy2 = true
                        }
                        if (noidung_hienthi[i] == "tieuChiBoSung") {
                            this.hienThiNangCao.tieuChiBoSung = true
                        }
                        if (noidung_hienthi[i] == "TvDgtx") {
                            this.hienThiNangCao.TvDgtx = true
                        }
                        if (noidung_hienthi[i] == "tenLopHoc") {
                            this.hienThiNangCao.tenLopHoc = true
                        }
                        if (noidung_hienthi[i] == "isSuyDduongTheNheCan") {
                            this.hienThiNangCao.isSuyDduongTheNheCan = true
                        }
                        if (noidung_hienthi[i] == "isSuyDduongTheCoiCoc") {
                            this.hienThiNangCao.isSuyDduongTheCoiCoc = true
                        }
                        if (noidung_hienthi[i] == "beoPhi") {
                            this.hienThiNangCao.beoPhi = true
                        }
                        if (noidung_hienthi[i] == "suyDduongTheTcoi") {
                            this.hienThiNangCao.suyDduongTheTcoi = true
                        }
                        if (noidung_hienthi[i] == "theoDoiBdoCcao") {
                            this.hienThiNangCao.theoDoiBdoCcao = true
                        }
                        if (noidung_hienthi[i] == "theoDoiBdoCnang") {
                            this.hienThiNangCao.theoDoiBdoCnang = true
                        }
                        if (noidung_hienthi[i] == "hthanhCtrinhLhoc") {
                            this.hienThiNangCao.hthanhCtrinhLhoc = true
                        }
                        if (noidung_hienthi[i] == "hoanThanhChuongTrinhMamMon") {
                            this.hienThiNangCao.hoanThanhChuongTrinhMamMon = true
                        }
                        if (noidung_hienthi[i] == "hoanThanhChuongTrinhTieuHoc") {
                            this.hienThiNangCao.hoanThanhChuongTrinhTieuHoc = true
                        }
                        if (noidung_hienthi[i] == "isKhamSkDky") {
                            this.hienThiNangCao.isKhamSkDky = true
                        }
                        if (noidung_hienthi[i] == "kthuongCnam") {
                            this.hienThiNangCao.kthuongCnam = true
                        }
                        if (noidung_hienthi[i] == "kthuongDxuat") {
                            this.hienThiNangCao.kthuongDxuat = true
                        }
                        if (noidung_hienthi[i] == "lamQuenThoc") {
                            this.hienThiNangCao.lamQuenThoc = true
                        }
                        if (noidung_hienthi[i] == "lenLop") {
                            this.hienThiNangCao.lenLop = true
                        }
                        if (noidung_hienthi[i] == "phoiIchayHhap") {
                            this.hienThiNangCao.phoiIchayHhap = true
                        }
                        if (noidung_hienthi[i] == "suyDduongTheTcoi") {
                            this.hienThiNangCao.suyDduongTheTcoi = true
                        }
                        if (noidung_hienthi[i] == "theoDoiBdoCcao") {
                            this.hienThiNangCao.theoDoiBdoCcao = true
                        }
                        if (noidung_hienthi[i] == "theoDoiBdoCnang") {
                            this.hienThiNangCao.theoDoiBdoCnang = true
                        }
                        if (noidung_hienthi[i] == "maHocLuc") {
                            this.hienThiNangCao.maHocLuc = true
                        }
                        if (noidung_hienthi[i] == "maHanhKiem") {
                            this.hienThiNangCao.maHanhKiem = true
                        }
                        if (noidung_hienthi[i] == "maDanhHieu") {
                            this.hienThiNangCao.maDanhHieu = true
                        }
                        if (noidung_hienthi[i] == "renLuyenLai") {
                            this.hienThiNangCao.renLuyenLai = true
                        }
                        if (noidung_hienthi[i] == "thiLai") {
                            this.hienThiNangCao.thiLai = true
                        }
                        if (noidung_hienthi[i] == "soNgayNghi") {
                            this.hienThiNangCao.soNgayNghi = true
                        }
                        if (noidung_hienthi[i] == "totNghiep") {
                            this.hienThiNangCao.totNghiep = true
                        }
                        if (noidung_hienthi[i] == "maLoaiTotNghiep") {
                            this.hienThiNangCao.maLoaiTotNghiep = true
                        }
                        if (noidung_hienthi[i] == "duXetTotNghiep") {
                            this.hienThiNangCao.duXetTotNghiep = true
                        }
                        if (noidung_hienthi[i] == "maMonHoc") {
                            this.hienThiNangCao.maMonHoc = true
                        }
                        if (noidung_hienthi[i] == "moetCode") {
                            this.hienThiNangCao.moetCode = true
                        }
                        if (noidung_hienthi[i] == "trangThai") {
                            this.hienThiNangCao.trangThai = true
                        }
                    }
                    console.log(JSON.stringify(this.hienThiNangCao));
                }
            },
            lsDelete: function (newVal) {
                console.log("Danh sách trường học update");
                console.log(newVal)
                let new_data = [];
                this.list_day_len_bo = [];
                if (newVal) {
                    let data = newVal;
                    console.log("Danh học sinh: " + JSON.stringify(data));
                    if (data.length == this.list_hocsinh.length && data.length > 0) {
                        this.slectAll = true;
                    } else {
                        this.slectAll = false;
                    }

                    for (let i = 0; i < data.length; i++) {
                        for (let j = 0; j < this.list_hocsinh.length; j++) {
                            if (data[i] == this.list_hocsinh[j].tongKetHsId) {
                                new_data.push(this.list_hocsinh[j]);
                            }
                        }
                    }
                    this.mapDuLieuDayLai(new_data);
                } else {
                    this.checkAll = false;
                }
            },
        },
        mounted: function () {
            this.ganDuLieuSME();
            console.log("Thông tin user:")
            this.thongtin = JSON.parse(window.userInfo);
            console.log(this.thongtin)
            this.namHoc = this.thongtin.namHocHienTai;
            if (this.thongtin.role > 3) {
                this.ds_don_vi = [this.thongtin.ma_don_vi]
            }
            if (this.thongtin.role == 5) {
                this.ds_cap_hoc = this.thongtin.listCapHoc;
                this.danhSachNoiDungHienThi = this.danhSachMaTimKiemTruong;
            } else {
                this.danhSachNoiDungHienThi = this.danhSachMaTimKiemSo;
            }
            if (this.thongtin.role == 4 || this.thongtin.role == 5) {
                this.isDisabled = true;
            }
            if (this.thongtin.role == 5) {
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
            this.getDonVi();
            this.bindCotHeader();
            this.ganCot();
            this.mapKhoiHoc(this.thongtin.listCapHoc);
            this.calculateColumnWidths();
            if (this.trangcu != '[]') {
                console.log("có dữ liệu trang cũ")
                let trangcu = JSON.parse(this.trangcu)
                this.namHoc = parseInt(trangcu.namHoc);
                this.hocKy = parseInt(trangcu.hocKy);
                this.ds_truong_hoc = [trangcu.maTruongHoc];
                window
                    .history
                    .replaceState("", "CSDL Ngành", "Look-up-academi-results");
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
                this.getTruongHoc();
            },
            calculateColumnWidths() {
                const columnWidths = {};
                this.cotHienThi.forEach((col) => {
                    const field = col.key;

                    // Xử lý nội dung cột
                    const rows = this.list_hocsinh.map((row) => {
                        // // Sử dụng getTenPhanBan nếu field là "phanBan"
                        if (field === "hocKy") {
                            return this.getHocKy(row[field]) || "";
                        }
                        if (field === "namHoc") {
                            return (row[field] + ' - ' + (row[field]+1)) || "";
                        }
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
            hienThiDiemChiTietMon(item) {
                try {
                    let params = {
                        maHocSinh: item.maHocSinh,
                        namHoc: item.namHoc,
                        hocKy: item.hocKy,
                    };
                    rest_api.post("/csdlgd-admin/kqht-hs/diemChiTiet", params, response => {
                        console.log("lấy thông tin điểm chi tiêt môn");
                        console.log(response.data)
                        if (response.data.rc == 0) {
                            this.show_diem_chi_tiet_mon = true;
                            this.thongTinDiem.ky1 = response.data.ki1
                            this.thongTinDiem.ky2 = response.data.ki2
                        } else {
                            this.thongTinDiem.ky1 = []
                            this.thongTinDiem.ky2 = []
                            this.thongBao('error', response.data.rd)
                        }
                        console.log('Thông tin điểm:')
                        console.log(this.thongTinDiem)
                    });

                } catch (e) {

                }
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
            getTenBenhVeMat(e) {
                let kq = "";
                for (let i = 0; i < this.ds_benh_ve_mat_sme.length; i++) {
                    if (e == this.ds_benh_ve_mat_sme[i].value && e != '') {
                        kq = this.ds_benh_ve_mat_sme[i].label
                    }
                }
                return kq;
            },
            submitExcel(e) {
                console.log("submitExcel");
                console.log(e)
                if (e.from == 1) {
                    this.start_excel_kqht = 0;
                } else {
                    this.start_excel_kqht = (e.from - 1) * this.limit;
                }
                if (e.to == e.from) {
                    this.limit_excel_kqht = this.limit;
                } else {
                    let chenh_lech = e.to - e.from;
                    this.limit_excel_kqht = (chenh_lech + 1) * this.limit
                }
                this.xuatExcel();
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
            xuatDuLieuKetQuaHocTap() {
                console.log("Xuất dữ liệu kết quả học tập");
                if (this.danhSachTimKiem.length == 0) {
                    this.$alertify.error("Vui lòng chọn nội dung hiển thị.");
                    return;
                }
                console.log(" Xuat du lieu excel:" + this.total_rows)
                if (this.total_rows < 50000) {
                    console.log("Xuat luon khong can check");
                    this.start_excel_kqht = 0;
                    this.limit_excel_kqht = 50000;
                    this.xuatExcel()
                } else {
                    this.CheckXuatExcel();
                }
            },
            CheckXuatExcel() {
                this.show_excel_kqht = true;
            },
            xuatExcel() {
                console.log("Hàm xuất excel")
                this.bindCotHeader();
                this.ganCot();
                let dataSreachList = [];
                this.bindDataSearchList();
                let params = {
                    "start": this.start_excel_kqht,
                    "limit": this.limit_excel_kqht,
                    "capHocs": this.ds_cap_hoc,
                    "khoiHocs": this.ds_khoi_hoc,
                    "hocKy": this.hocKy,
                    "keyword": this.tuKhoa,
                    "giaiDoan": this.giaiDoan,
                    "maTruongHocs": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "colExcels": this.danhSachTimKiem,
                    "maPhongs": this.ds_don_vi,
                    "dataSreachList": this.noiDungTimKiem,
                };
                if (this.ds_cap_hoc && this.ds_cap_hoc.length > 0) {
                    let ds_cap_hoc = [];
                    for (let i = 0; i < this.ds_cap_hoc.length; i++) {
                        if (this.ds_cap_hoc[i] == 45) {
                            ds_cap_hoc.push(4)
                            ds_cap_hoc.push(5)
                        } else {
                            ds_cap_hoc.push(this.ds_cap_hoc[i]);
                        }
                    }
                    console.log('Danh sách cấp học cần gửi đi:')
                    let unique = (value, index, self) => {
                        return self.indexOf(value) === index
                    }
                    params.capHocs = ds_cap_hoc.filter(unique);
                }
                console.log("Dữ liệu xuất excel")
                let url = "xuat-excel-danh-sach-tra-cuu-kqht";
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        console.log(params);
                        this.thongBao('success', 'Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        this.fullScreenLoading = true;
                        api.post(url, params, (data) => {
                            this.fullScreenLoading = false;
                            let a = document.createElement('a');
                            a.href = data.data.file;
                            document
                                .body
                                .appendChild(a);
                            a.click();
                            document
                                .body
                                .removeChild(a);
                        })
                    })
                    .catch(_ => {});
            },
            ChonTatCa() {
                let danhsach = [];
                if (this.slectAll) {
                    for (let i = 0; i < this.list_hocsinh.length; i++) {
                        danhsach.push(this.list_hocsinh[i].tongKetHsId);
                    }
                }
                this.lsDelete = danhsach;
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
                        buocDays: [51,52],
                        listNopRieng: this.getListHocSinh(group[key]),

                    }
                    if (this.thongtin.role == 5) {
                        obj.maTruong = this.thongtin.ma_truong_hoc
                    }
                    du_lieu.push(obj)

                });
                this.list_day_len_bo = du_lieu;
                console.log(this.list_day_len_bo);
            },getListHocSinh(e) {
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
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_benh_ve_mat_sme"];
                if (tmp) {
                    this.list_giai_doan = JSON.parse(localStorage["danh_sach_giai_doan_kqht_sme"]);
                    this.ds_loai_tot_nghiep_sme = JSON.parse(localStorage["danh_sach_loai_tot_nghiep"]);
                    this.ds_benh_ve_mat_sme = JSON.parse(localStorage["danh_sach_benh_ve_mat_sme"]);
                }
            },
            getTrangThaiHocSinh(e) {
                if (e == 1) {
                    return "Đang học"
                }
                if (e == 3) {
                    return "Chuyển khỏi trường"
                }
                if (e == 4) {
                    return "Bỏ học"
                }
            },
            getHocKy(loai) {
                var res = parseInt(loai);
                switch (res) {
                    case 1:
                        res = 'Học kỳ I';
                        break;
                    case 2:
                        res = 'Học kỳ II';
                        break;
                    case 3:
                        res = 'Cả năm';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            checkTruocKhiTim() {
                this.lsDelete = [];
                this.total_rows = 0;
                this.trangbatdau = !this.trangbatdau;
            },
            limitTextTieuChi(count) {
                return `và ${count} nội dung khác`
            },
            ChonDonVi() {
                this.params = {};
                this.ds_truong_hoc = [];
                this.thongTinTrangCu = [];
                console.log('Đơn vị:' + this.ds_don_vi)
                this.getTruongHoc();
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
            getInfo(e) {
                this.idHocSinh = e;
                this.show_info = true;
            },
            getCapHoc(loai) {
                var res = loai;
                switch (loai) {
                    case 1:
                        res = 'Tiểu học'
                        break;
                    case 2:
                        res = 'Trung học Cơ sở'
                        break;
                    case 3:
                        res = 'Trung học Phổ thông'
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            onUpdatedData() {
                setTimeout(() => {
                    this.showEditHocSinh = false;
                }, 1500);
            },
            // Chỉnh sửa học sinh
            EditStudent(e) {
                this.showEditHocSinh = true;
                this.dataEditHocSinh = e;
                console.log("123456789");
            },
            // Thông tin học sinh
            // Xóa danh sách học sinh đã chọn

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
            DeleteStudent() {
                console.log(this.lsDelete);
                if (this.lsDelete.length > 0) {
                    this.$confirm('Xác nhận xóa dữ liệu ' + this.lsDelete.length + ' bản ghi đã chọn?', 'Xóa dữ liệu', {
                            confirmButtonText: 'Xóa',
                            cancelButtonText: 'Hủy',
                            confirmButtonClass: 'el-button--danger',
                            closeOnClickModal: false,
                        })
                        .then(_ => {
                            let params = {
                                listMa: this.lsDelete,
                                namHoc: this.namHoc
                            };
                            this.fullScreenLoading = true;
                            rest_api.post("/csdlgd-admin/kqht-hs/delete", params, data => {
                                this.fullScreenLoading = false;
                                if (data.data.rc == 0) {
                                    this.thongBao('success', data.data.rd);
                                    this.getListStudent();
                                } else {
                                    this
                                        .$alertify
                                        .error(data.data.rd)
                                }
                            });
                        })
                        .catch(_ => {});
                } else {
                    this.thongBao('error', 'Vui lòng chọn học sinh để xóa dữ liệu')
                }
            },
            // Lấy lại danh sách học sinh
            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getListStudent()
            },
            // Lấy danh sách trường học Lấy trường học
            getTruongHoc(gt = () => {}) {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc,
                    loose: true,
                    namHoc: this.namHoc
                }
                // this.fullScreenLoading = true;
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    console.log("lấy trường");
                    // this.fullScreenLoading = false;
                    if (data.data.code == 200) {
                        let dulieu = data.data.rows;
                        let ldv = [];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenTruongHoc: dulieu[i].tenTruongHoc + ' - [' + dulieu[i]
                                    .maTruongHoc + ']',
                                maTruongHoc: dulieu[i].maTruongHoc
                            }
                            ldv.push(obj);
                        }
                        if (this.thongtin.role != 5) {
                            this.list_truong_hoc = ldv;
                        }
                    }
                });
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
            // gán các cột hiển thị
            ganCot() {
                this.hangHienThi = {};
                this.cotHienThi = this.danhSachTimKiem;
                console.log("cột hiển thị:");
                for (let i = 0; i < this.cotHienThi.length; i++) {
                    if (this.cotHienThi[i].key == "maHocSinh") {
                        this.hangHienThi.maHocSinh = true;
                    }
                    if (this.cotHienThi[i].key == "moetCode") {
                        this.hangHienThi.moetCode = true;
                    }
                    if (this.cotHienThi[i].key == "trangThai") {
                        this.hangHienThi.trangThai = true;
                    }
                    if (this.cotHienThi[i].key == "tenHocSinh") {
                        this.hangHienThi.tenHocSinh = true;
                    }
                    if (this.cotHienThi[i].key == "tenLopHoc") {
                        this.hangHienThi.tenLopHoc = true;
                    }
                    if (this.cotHienThi[i].key == "isSuyDduongTheNheCan") {
                        this.hangHienThi.isSuyDduongTheNheCan = true;
                    }
                    if (this.cotHienThi[i].key == "isSuyDduongTheCoiCoc") {
                        this.hangHienThi.isSuyDduongTheCoiCoc = true;
                    }
                    if (this.cotHienThi[i].key == "beoPhi") {
                        this.hangHienThi.beoPhi = true;
                    }
                    if (this.cotHienThi[i].key == "suyDduongTheTcoi") {
                        this.hangHienThi.suyDduongTheTcoi = true;
                    }
                    if (this.cotHienThi[i].key == "theoDoiBdoCcao") {
                        this.hangHienThi.theoDoiBdoCcao = true;
                    }
                    if (this.cotHienThi[i].key == "theoDoiBdoCnang") {
                        this.hangHienThi.theoDoiBdoCnang = true;
                    }
                    if (this.cotHienThi[i].key == "hocKy") {
                        this.hangHienThi.hocKy = true;
                    }
                    if (this.cotHienThi[i].key == "giaiDoan") {
                        this.hangHienThi.giaiDoan = true;
                    }
                    if (this.cotHienThi[i].key == "namHoc") {
                        this.hangHienThi.namHoc = true;
                    }
                    if (this.cotHienThi[i].key == "khoiHoc") {
                        this.hangHienThi.khoiHoc = true;
                    }
                    if (this.cotHienThi[i].key == "capHoc") {
                        this.hangHienThi.capHoc = true;
                    }
                    if (this.cotHienThi[i].key == "maTruongHoc") {
                        this.hangHienThi.maTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenTruongHoc") {
                        this.hangHienThi.tenTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "diemTongKet") {
                        this.hangHienThi.diemTongKet = true;
                    }
                    if (this.cotHienThi[i].key == "kiemTraSucKhoeDinhDuong") {
                        this.hangHienThi.kiemTraSucKhoeDinhDuong = true;
                    }
                    if (this.cotHienThi[i].key == "chieuCao") {
                        this.hangHienThi.chieuCao = true;
                    }
                    if (this.cotHienThi[i].key == "canNang") {
                        this.hangHienThi.canNang = true;
                    }
                    if (this.cotHienThi[i].key == "benhMat") {
                        this.hangHienThi.benhMat = true;
                    }
                    if (this.cotHienThi[i].key == "isBietBoiKy1") {
                        this.hangHienThi.isBietBoiKy1 = true;
                    }
                    if (this.cotHienThi[i].key == "isBietBoiKy2") {
                        this.hangHienThi.isBietBoiKy2 = true;
                    }
                    if (this.cotHienThi[i].key == "tieuChiBoSung") {
                        this.hangHienThi.tieuChiBoSung = true;
                    }
                    if (this.cotHienThi[i].key == "TvDgtx") {
                        this.hangHienThi.TvDgtx = true;
                    }
                    if (this.cotHienThi[i].key == "hthanhCtrinhLhoc") {
                        this.hangHienThi.hthanhCtrinhLhoc = true;
                    }
                    if (this.cotHienThi[i].key == "hoanThanhChuongTrinhMamMon") {
                        this.hangHienThi.hoanThanhChuongTrinhMamMon = true;
                    }
                    if (this.cotHienThi[i].key == "hoanThanhChuongTrinhTieuHoc") {
                        this.hangHienThi.hoanThanhChuongTrinhTieuHoc = true;
                    }
                    if (this.cotHienThi[i].key == "isKhamSkDky") {
                        this.hangHienThi.isKhamSkDky = true;
                    }
                    if (this.cotHienThi[i].key == "kthuongCnam") {
                        this.hangHienThi.kthuongCnam = true;
                    }
                    if (this.cotHienThi[i].key == "kthuongDxuat") {
                        this.hangHienThi.kthuongDxuat = true;
                    }
                    if (this.cotHienThi[i].key == "lamQuenThoc") {
                        this.hangHienThi.lamQuenThoc = true;
                    }
                    if (this.cotHienThi[i].key == "soCmnd") {
                        this.hangHienThi.soCmnd = true;
                    }
                    if (this.cotHienThi[i].key == "lenLop") {
                        this.hangHienThi.lenLop = true;
                    }
                    if (this.cotHienThi[i].key == "maHocLuc") {
                        this.hangHienThi.maHocLuc = true;
                    }
                    if (this.cotHienThi[i].key == "maHanhKiem") {
                        this.hangHienThi.maHanhKiem = true;
                    }
                    if (this.cotHienThi[i].key == "maDanhHieu") {
                        this.hangHienThi.maDanhHieu = true;
                    }
                    if (this.cotHienThi[i].key == "phoiIchayHhap") {
                        this.hangHienThi.phoiIchayHhap = true;
                    }
                    if (this.cotHienThi[i].key == "suyDduongTheTcoi") {
                        this.hangHienThi.suyDduongTheTcoi = true;
                    }
                    if (this.cotHienThi[i].key == "theoDoiBdoCcao") {
                        this.hangHienThi.theoDoiBdoCcao = true;
                    }
                    if (this.cotHienThi[i].key == "theoDoiBdoCnang") {
                        this.hangHienThi.theoDoiBdoCnang = true;
                    }
                    if (this.cotHienThi[i].key == "maHocLuc") {
                        this.hangHienThi.maHocLuc = true;
                    }
                    if (this.cotHienThi[i].key == "maHanhKiem") {
                        this.hangHienThi.maHanhKiem = true;
                    }
                    if (this.cotHienThi[i].key == "maDanhHieu") {
                        this.hangHienThi.maDanhHieu = true;
                    }
                    if (this.cotHienThi[i].key == "renLuyenLai") {
                        this.hangHienThi.renLuyenLai = true;
                    }
                    if (this.cotHienThi[i].key == "thiLai") {
                        this.hangHienThi.thiLai = true;
                    }
                    if (this.cotHienThi[i].key == "soNgayNghi") {
                        this.hangHienThi.soNgayNghi = true;
                    }
                    if (this.cotHienThi[i].key == "totNghiep") {
                        this.hangHienThi.totNghiep = true;
                    }
                    if (this.cotHienThi[i].key == "maLoaiTotNghiep") {
                        this.hangHienThi.maLoaiTotNghiep = true;
                    }
                    if (this.cotHienThi[i].key == "duXetTotNghiep") {
                        this.hangHienThi.duXetTotNghiep = true;
                    }
                    if (this.cotHienThi[i].key == "maMonHoc") {
                        this.hangHienThi.maMonHoc = true;
                    }
                    if (this.cotHienThi[i].key == "danhGiaKQGiaoDuc") {
                        this.hangHienThi.danhGiaKQGiaoDuc = true;
                    }
                    if (this.cotHienThi[i].key == "kqHocTap") {
                        this.hangHienThi.kqHocTap = true;
                    }
                    if (this.cotHienThi[i].key == "kqRenLuyen") {
                        this.hangHienThi.kqRenLuyen = true;
                    }
                    if (this.cotHienThi[i].key == "LoaiChungChiNghe") {
                        this.hangHienThi.LoaiChungChiNghe = true;
                    }
                    if (this.cotHienThi[i].key == "khenThuongCapHuyen") {
                        this.hangHienThi.khenThuongCapHuyen = true;
                    }
                    if (this.cotHienThi[i].key == "TinhTrangDinhDuong") {
                        this.hangHienThi.TinhTrangDinhDuong = true;
                    }
                    if (this.cotHienThi[i].key == "isKhamSkDky") {
                        this.hangHienThi.isKhamSkDky = true;
                    }
                }
                console.log("Hàng hiển thị:" + JSON.stringify(this.hangHienThi));
            },
            // Lấy danh sách học sinh
            bindDataSearchList() {

                let dataSreachList = [];
                if (this.danhSachTimKiemNangCao.length > 0) {
                    console.log(JSON.stringify(this.nangCao));
                    if (this.hienThiNangCao.hthanhCtrinhLhoc) {
                        if (this.nangCao.hthanhCtrinhLhoc) {
                            let vl = "";
                            if (this.nangCao.hthanhCtrinhLhoc == 1) {
                                vl = true;
                            }
                            if (this.nangCao.hthanhCtrinhLhoc == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "hthanhCtrinhLhoc",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.kiemTraSucKhoeDinhDuong) {
                        if (this.nangCao.kiemTraSucKhoeDinhDuong) {
                            let obj = {
                                "key": "kiemTraSucKhoeDinhDuong",
                                "value": parseInt(this.nangCao.kiemTraSucKhoeDinhDuong),
                            }
                            dataSreachList.push(obj)
                        }
                    }

                    if (this.hienThiNangCao.chieuCao) {
                        if (this.nangCao.chieuCao) {
                            let obj = {
                                "key": "chieuCao",
                                "value": this.nangCao.chieuCao,
                            }
                            dataSreachList.push(obj)
                        }
                    }

                    if (this.hienThiNangCao.canNang) {
                        if (this.nangCao.canNang) {
                            let obj = {
                                "key": "canNang",
                                "value": this.nangCao.canNang,
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
                    if (this.hienThiNangCao.isBietBoiKy1) {
                        if (this.nangCao.isBietBoiKy1 === 1 || this.nangCao.isBietBoiKy1 === 0) {
                            let vl = "";
                            if (this.nangCao.isBietBoiKy1 == 1) {
                                vl = true;
                            }
                            if (this.nangCao.isBietBoiKy1 == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "isBietBoiKy1",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.isBietBoiKy2) {
                        if (this.nangCao.isBietBoiKy2 === 1 || this.nangCao.isBietBoiKy2 === 0) {
                            let vl = "";
                            if (this.nangCao.isBietBoiKy2 == 1) {
                                vl = true;
                            }
                            if (this.nangCao.isBietBoiKy2 == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "isBietBoiKy2",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.TvDgtx) {
                        if (this.nangCao.TvDgtx.length > 0) {
                            let obj = {
                                "key": "TvDgtx",
                                "value": this.TvDgtx,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.tieuChiBoSung) {
                        if (this.nangCao.tieuChiBoSung.length > 0) {
                            let obj = {
                                "key": "tieuChiBoSung",
                                "value": this.tieuChiBoSung,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.hoanThanhChuongTrinhMamMon) {
                        if (this.nangCao.hoanThanhChuongTrinhMamMon) {
                            let vl = "";
                            if (this.nangCao.hoanThanhChuongTrinhMamMon == 1) {
                                vl = true;
                            }
                            if (this.nangCao.hoanThanhChuongTrinhMamMon == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "hoanThanhChuongTrinhMamMon",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.isSuyDduongTheNheCan) {
                        if (this.nangCao.isSuyDduongTheNheCan === 1 || this.nangCao.isSuyDduongTheNheCan === 0) {
                            let vl = "";
                            if (this.nangCao.isSuyDduongTheNheCan == 1) {
                                vl = true;
                            }
                            if (this.nangCao.isSuyDduongTheNheCan == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "isSuyDduongTheNheCan",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.isSuyDduongTheCoiCoc) {
                        if (this.nangCao.isSuyDduongTheCoiCoc === 1 || this.nangCao.isSuyDduongTheCoiCoc === 0) {
                            let vl = "";
                            if (this.nangCao.isSuyDduongTheCoiCoc == 1) {
                                vl = true;
                            }
                            if (this.nangCao.isSuyDduongTheCoiCoc == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "isSuyDduongTheCoiCoc",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.hoanThanhChuongTrinhTieuHoc) {
                        if (this.nangCao.hoanThanhChuongTrinhTieuHoc) {
                            let vl = "";
                            if (this.nangCao.hoanThanhChuongTrinhTieuHoc == 1) {
                                vl = true;
                            }
                            if (this.nangCao.hoanThanhChuongTrinhTieuHoc == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "hoanThanhChuongTrinhTieuHoc",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.beoPhi) {
                        if (this.nangCao.beoPhi) {
                            let vl = "";
                            if (this.nangCao.beoPhi == 1) {
                                vl = true;
                            }
                            if (this.nangCao.beoPhi == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "beoPhi",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.isKhamSkDky) {
                        if (this.nangCao.isKhamSkDky === 1||this.nangCao.isKhamSkDky=== 0) {
                            let vl = "";
                            if (this.nangCao.isKhamSkDky == 1) {
                                vl = true;
                            }
                            if (this.nangCao.isKhamSkDky == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "isKhamSkDky",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.kthuongCnam) {
                        if (this.nangCao.kthuongCnam) {
                            let vl = "";
                            if (this.nangCao.kthuongCnam == 1) {
                                vl = true;
                            }
                            if (this.nangCao.kthuongCnam == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "kthuongCnam",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.kthuongDxuat) {
                        if (this.nangCao.kthuongDxuat) {
                            let vl = "";
                            if (this.nangCao.kthuongDxuat == 1) {
                                vl = true;
                            }
                            if (this.nangCao.kthuongDxuat == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "kthuongDxuat",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lamQuenThoc) {
                        if (this.nangCao.lamQuenThoc) {
                            let vl = "";
                            if (this.nangCao.lamQuenThoc == 1) {
                                vl = true;
                            }
                            if (this.nangCao.lamQuenThoc == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "lamQuenThoc",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lenLop) {
                        if (this.nangCao.lenLop) {
                            let vl = "";
                            if (this.nangCao.lenLop == 1) {
                                vl = true;
                            }
                            if (this.nangCao.lenLop == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "lenLop",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.phoiIchayHhap) {
                        if (this.nangCao.phoiIchayHhap) {
                            let vl = "";
                            if (this.nangCao.phoiIchayHhap == 1) {
                                vl = true;
                            }
                            if (this.nangCao.phoiIchayHhap == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "phoiIchayHhap",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.suyDduongTheTcoi) {
                        if (this.nangCao.suyDduongTheTcoi) {
                            let vl = "";
                            if (this.nangCao.suyDduongTheTcoi == 1) {
                                vl = true;
                            }
                            if (this.nangCao.suyDduongTheTcoi == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "suyDduongTheTcoi",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.theoDoiBdoCcao) {
                        if (this.nangCao.theoDoiBdoCcao) {
                            let vl = "";
                            if (this.nangCao.theoDoiBdoCcao == 1) {
                                vl = true;
                            }
                            if (this.nangCao.theoDoiBdoCcao == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "theoDoiBdoCcao",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.theoDoiBdoCnang) {
                        if (this.nangCao.theoDoiBdoCnang) {
                            let vl = "";
                            if (this.nangCao.theoDoiBdoCnang == 1) {
                                vl = true;
                            }
                            if (this.nangCao.theoDoiBdoCnang == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "theoDoiBdoCnang",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maHocLuc) {
                        if (this.nangCao.maHocLuc) {
                            let obj = {
                                "key": "maHocLuc",
                                "value": this.nangCao.maHocLuc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maHanhKiem) {
                        if (this.nangCao.maHanhKiem) {
                            let obj = {
                                "key": "maHanhKiem",
                                "value": this.nangCao.maHanhKiem,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maDanhHieu) {
                        if (this.nangCao.maDanhHieu) {
                            let obj = {
                                "key": "maDanhHieu",
                                "value": this.nangCao.maDanhHieu,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.renLuyenLai) {
                        if (this.nangCao.renLuyenLai) {
                            let vl = "";
                            if (this.nangCao.renLuyenLai == 1) {
                                vl = true;
                            }
                            if (this.nangCao.renLuyenLai == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "renLuyenLai",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.thiLai) {
                        if (this.nangCao.thiLai) {
                            let vl = "";
                            if (this.nangCao.thiLai == 1) {
                                vl = true;
                            }
                            if (this.nangCao.thiLai == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "thiLai",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.totNghiep) {
                        if (this.nangCao.totNghiep) {
                            let vl = "";
                            if (this.nangCao.totNghiep == 1) {
                                vl = true;
                            }
                            if (this.nangCao.totNghiep == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "totNghiep",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLoaiTotNghiep) {
                        if (this.nangCao.maLoaiTotNghiep) {
                            let obj = {
                                "key": "maLoaiTotNghiep",
                                "value": this.nangCao.maLoaiTotNghiep,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.duXetTotNghiep) {
                        if (this.nangCao.duXetTotNghiep) {
                            let vl = "";
                            if (this.nangCao.duXetTotNghiep == 1) {
                                vl = true;
                            }
                            if (this.nangCao.duXetTotNghiep == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "duXetTotNghiep",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.soNgayNghi) {
                        if (this.nangCao.soNgayNghi !== '') {
                            let obj = {
                                "key": "soNgayNghi",
                                "value": parseInt(this.nangCao.soNgayNghi),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maMonHoc) {
                        if (this.nangCao.maMonHoc) {
                            let obj = {
                                "key": "maMonHoc",
                                "value": this.nangCao.maMonHoc,
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
                    if (this.hienThiNangCao.trangThai) {
                        if (this.nangCao.trangThai) {
                            let obj = {
                                "key": "trangThai",
                                "value": parseInt(this.nangCao.trangThai),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                }

                if (true || this.hienThiNangCao.tenLopHoc) {
                    if (this.nangCao.tenLopHoc) {
                        let obj = {
                            "key": "tenLopHoc",
                            "value": this.nangCao.tenLopHoc,
                        }
                        dataSreachList.push(obj)
                    }
                }
                console.log("Nội dung tìm kiếm nâng cao");
                console.log(JSON.stringify(dataSreachList));
                this.noiDungTimKiem = dataSreachList;
            },
            getListStudent() {
                if (!this.namHoc || this.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin năm học')
                    return;
                }
                if (this.danhSachTimKiem.length == 0) {
                    this.thongBao('error', 'Vui lòng chọn nội dung hiển thị')
                    return;
                }
                this.slectAll = false;
                this.lsDelete = [];
                this.bindCotHeader();
                this.ganCot();
                this.list_hocsinh = [];
                this.bindDataSearchList();
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "capHocs": this.ds_cap_hoc,
                    "khoiHocs": this.ds_khoi_hoc,
                    "hocKy": this.hocKy,
                    "keyword": this.tuKhoa,
                    "giaiDoan": this.giaiDoan,
                    "maTruongHocs": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "colExcels": this.danhSachTimKiem,
                    "maPhongs": this.ds_don_vi,
                    "dataSreachList": this.noiDungTimKiem,
                };
                if (this.thongtin.role == 5) {
                    params.maTruongHocs = [this.thongtin.ma_truong_hoc];
                }
                if (this.ds_cap_hoc && this.ds_cap_hoc.length > 0) {
                    let ds_cap_hoc = [];
                    for (let i = 0; i < this.ds_cap_hoc.length; i++) {
                        if (this.ds_cap_hoc[i] == 45) {
                            ds_cap_hoc.push(4)
                            ds_cap_hoc.push(5)
                        } else {
                            ds_cap_hoc.push(this.ds_cap_hoc[i]);
                        }
                    }
                    console.log('Danh sách cấp học cần gửi đi:')
                    let unique = (value, index, self) => {
                        return self.indexOf(value) === index
                    }
                    params.capHocs = ds_cap_hoc.filter(unique);
                }
                console.log("caphoc" + JSON.stringify(params))
                this.fullScreenLoading = true;
                this.calculateColumnWidths();
                rest_api.post("/csdlgd-admin/kqht-hs/filters3", params, (respon) => {
                    this.fullScreenLoading = false;
                    if (respon.data.rc == 0) {
                        if (respon.data.tableData.length == 0) {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy");
                            console.log("không có bản ghi nào được tìm thấy");
                            return;
                        } else {
                            this.list_hocsinh = respon.data.tableData;
                            this.total_rows = respon.data.totalRows;
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công.")
                        }
                    } else {
                        this
                            .$alertify
                            .error(respon.data.rd);
                        return;
                    }
                })
            },
            // Lấy danh sách đơn vị
            getDonVi(ck = () => {}) {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                console.log("pr ẻty" + JSON.stringify(params));
                // this.fullScreenLoading = true;
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    // this.fullScreenLoading = false;
                    // console.log("lấy đơn vị thành công" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        let ldv = []
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                tenDonVi: data_demo[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data_demo[i].maDonVi + ']',
                                maDonVi: data_demo[i].maDonVi,
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
                        ck();
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">
    /* @import "../../../../node_modules/selectwithsearch.css"; */
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

    .multiselect--disabled {
        background: white;
    }

    input[type=checkbox] {
        margin: 0 !important;
    }

</style>

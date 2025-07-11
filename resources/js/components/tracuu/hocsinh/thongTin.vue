<template>
    <div>
        <el-dialog title="Thông tin học sinh" :visible.sync="show_thong_tin" top="5vh" width="90%"
                   :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
            <form>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <div class="row" ref="scrollToMe">
                            <div class="col-sm-3 col-md-2">
                                <div class="thumbnail" style="text-align:center;">
                                    <div v-if="info.avatar">
                                        <img style="width: 100%;max-width: 250px;height: auto" :src="info.avatar"
                                             width="100%" alt="hình ảnh học sinh"/>
                                    </div>
                                    <div v-else>
                                        <img style="width: 100%;max-width: 250px;height: auto"
                                             src="https://www.drupal.org/files/issues/default-avatar.png" width="120px"
                                             height="150px;" alt=""/>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="moet-code text-center" style="padding-left:15px;">Mã học sinh CSDL:
                                        <span><b>{{ info.maHocSinh }}</b></span></p>
                                </div>
                            </div>
                            <div class="col-sm-9 col-md-10">
                                <div class="row">
                                    <div class="col-md-6">
                                        <!-- Khối học -->
                                        <div class="form-group">
                                            <label class="typo__label">Khối học <span style="display:none"> * </span></label>
                                            <input disabled class="form-control"
                                                   :value="getTen2(info.khoiHoc, list_khoi_hoc)">
                                        </div>

                                        <!-- Nhóm tuổi -->
                                        <div class="form-group"
                                             v-if="info.capHoc == 4 || info.capHoc == 5 || info.capHoc == 45">
                                            <label class="typo__label">Nhóm tuổi <span style="display:none"> * </span></label>
                                            <input disabled class="form-control"
                                                   :value="getTen(info.maNhomTuoiMn, list_nhom_tuoi_mam_non)">
                                        </div>

                                        <!-- Lớp học -->
                                        <div class="form-group">
                                            <label class="typo__label">Lớp học <span style="display:none"> * </span></label>
                                            <input disabled class="form-control"
                                                   :value="getTen(info.maLopHocCn, list_lop_hoc)">
                                        </div>

                                        <!-- Họ tên -->
                                        <div class="form-group">
                                            <label class="typo__label">Họ tên <span style="display:none"> * </span></label>
                                            <input class="form-control" disabled v-model="info.hoTen">
                                        </div>

                                        <!-- Ngày sinh -->
                                        <div class="form-group">
                                            <label class="typo__label">Ngày sinh <span style="display:none"> * </span></label>
                                            <input class="form-control" disabled v-model="info.ngaySinh">
                                        </div>

                                        <!-- Giới tính -->
                                        <div class="form-group">
                                            <label class="typo__label">Giới tính <span style="display:none"> * </span></label>
                                            <el-select disabled v-model="info.gioiTinh">
                                                <el-option label="Nam" :value="1"></el-option>
                                                <el-option label="Nữ" :value="0"></el-option>
                                            </el-select>
                                        </div>

                                        <!-- Trạng thái học sinh -->
                                        <div class="form-group">
                                            <label class="typo__label">Trạng thái học sinh <span style="display:none"> * </span></label>
                                            <input disabled class="form-control"
                                                   :value="getTen(info.trangThai, list_tt_hs)">
                                        </div>

                                        <!-- Tôn giáo -->
                                        <div class="form-group">
                                            <label class="typo__label">Tôn giáo</label>
                                            <input disabled class="form-control"
                                                   :value="getTen(info.maTonGiao, list_tongiao)">
                                        </div>

                                        <!-- Dân tộc -->
                                        <div class="form-group">
                                            <label class="typo__label">Dân tộc </label>
                                            <input disabled class="form-control"
                                                   :value="getTen(info.maDanToc, list_dantoc)">
                                        </div>
                                        <!-- Dân tộc -->
                                        <div class="form-group">
                                            <label class="typo__label">Quốc tịch <span style="display:none"> * </span></label>
                                            <input disabled class="form-control"
                                                   :value="getTen(info.maQuocTich, list_quoctich)">
                                        </div>
                                        <!-- Dân tộc -->
                                        <!-- <div class="form-group">
                                            <label class="typo__label">Dân tộc <span style="display:none"> * </span></label>
                                            <input disabled class="form-control"
                                                   :value="getTen(info.maDanToc, list_dantoc)">
                                        </div> -->

                                        <!-- Dân tộc trên giấy khai sinh -->
                                        <div class="form-group">
                                            <label class="typo__label">Dân tộc trên giấy khai sinh<span
                                                    style="display:none"> * </span></label>
                                            <input disabled class="form-control"
                                                   v-model="info.hocBaDanTocTheoGiayKhaiSinh">
                                        </div>

                                        <!-- Mã định danh công dân -->
                                        <div class="form-group">
                                            <label class="typo__label">Mã định danh công dân</label>
                                            <input class="form-control" disabled v-model="info.citizenId">
                                        </div>

                                        <!-- Mã định danh bộ GD&ĐT -->
                                        <div class="form-group">
                                            <label class="typo__label">Mã định danh bộ GD&ĐT</label>
                                            <input class="form-control" disabled v-model="info.moetCode">
                                        </div>

                                        <!-- Ngày vào trường -->
                                        <div class="form-group">
                                            <label class="typo__label">Ngày vào trường</label>
                                            <date-picker class="form-control" disabled style="min-width: 50px;"
                                                         v-model="info.ngayVaoTruong" :lang="lang"
                                                         ></date-picker>
                                        </div>

                                        <!-- Ngày trạng thái -->
                                        <div class="form-group">
                                            <label class="typo__label">Ngày trạng thái <span style="display:none"> * </span></label>
                                            <input class="form-control" disabled v-model="info.ngayTrangThai">
                                        </div>

                                        <!-- Lý do bỏ học -->
                                        <div class="form-group" v-if="info.trangThai == 4">
                                            <label class="typo__label">Lý do bỏ học <span style="display:none"> * </span></label>
                                            <input disabled class="form-control"
                                                   :value="getTen(info.maLyDoThoiHoc, list_ly_do_thoi_hoc)">
                                        </div>

                                        <!-- Thời điểm chuyển trường/bỏ học -->
                                        <div class="form-group">
                                            <label class="typo__label">Thời điểm chuyển trường/bỏ học của học sinh</label>
                                            <input disabled class="form-control" :value="info.thoiDiemRoiTruong">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="tieuDeThongTin"><b>Thông tin hộ khẩu, quê quán</b></div>

                                        <div class="form-group">
                                            <label class="typo__label">Quê quán</label>
                                            <textarea rows="3" disabled class="form-control"
                                                      v-model="info.queQuan"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="typo__label">Địa chỉ thường trú</label>
                                            <textarea rows="3" disabled class="form-control"
                                                      v-model="info.dchiThtru"></textarea>
                                        </div>

                                        <div class="tieuDeThongTin"><b>Thông tin khác</b></div>

                                        <div class="form-group">
                                            <label class="typo__label">Nơi sinh</label>
                                            <el-input clearable placeholder="Nhập..."
                                                      disabled
                                                      @change="check_confirm_come_back = true;info.noiSinh = info.noiSinh.trim()"
                                                      @input="nhapNoiSinh()" v-model="info.noiSinh"/>
<!--                                            <el-select :disabled="true" v-model="info.NoiSinhTinhThanh" filterable-->
<!--                                                       collapse-tags-->
<!--                                                       placeholder="Chọn" no-data-text="Không có dữ liệu"-->
<!--                                                       no-match-text="Không có dữ liệu phù hợp">-->
<!--                                                <el-option v-for="(item,i) in danh_sach_tinh" :key="i"-->
<!--                                                           :label="item.tenTinhThanh +' - ['+item.maTinhThanh+']'"-->
<!--                                                           :value="item.maTinhThanh">-->
<!--                                                </el-option>-->
<!--                                            </el-select>-->
                                        </div>

<!--                                        <div class="form-group">-->
<!--                                            <el-select :disabled="true" v-model="info.NoiSinhQuanHuyen" filterable-->
<!--                                                       collapse-tags-->
<!--                                                       placeholder="Chọn" no-data-text="Không có dữ liệu"-->
<!--                                                       no-match-text="Không có dữ liệu phù hợp">-->
<!--                                                <el-option v-for="(item,i) in danh_sach_huyen" :key="i"-->
<!--                                                           :label="item.tenQuanHuyen+' - ['+item.maQuanHuyen+']'"-->
<!--                                                           :value="item.maQuanHuyen">-->
<!--                                                </el-option>-->
<!--                                            </el-select>-->
<!--                                        </div>-->

<!--                                        <div class="form-group">-->
<!--                                          -->
<!--                                        </div>-->

                                        <div class="form-group">
                                            <label class="typo__label">Chỗ ở hiện nay</label>
                                            <textarea rows="3" disabled class="form-control"
                                                      v-model="noiOHienNay"></textarea>
                                        </div>

                                        <div class="form-group">
                                            <label class="typo__label">Nhóm máu</label>
                                            <input disabled class="form-control"
                                                   :value="getTen(info.nhomMau,list_nhommau)">
                                        </div>

                                        <div class="form-group">
                                            <label class="typo__label">Thành phần gia đình</label>
                                            <input disabled class="form-control"
                                                   :value="getTen(info.tphanGdinh,list_tpgd)">
                                        </div>

                                        <div class="form-group">
                                            <label class="typo__label">Số điện thoại liên hệ</label>
                                            <input disabled class="form-control" v-model="info.soDthoaiDdong">
                                        </div>

                                        <div class="form-group">
                                            <label class="typo__label">Email</label>
                                            <input class="form-control" disabled v-model="info.email">
                                        </div>

                                        <div class="form-group">
                                            <label class="typo__label">Sổ đăng bộ</label>
                                            <input class="form-control" disabled v-model="info.soDangBo">
                                        </div>

                                        <div class="form-group">
                                            <label class="typo__label">Thứ tự</label>
                                            <input class="form-control" disabled v-model="info.thuTu">
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Nơi chuyển đi</label>
                                            </div>
                                            <div class="">
                                                <el-select :disabled="true" v-model="info.noiChuyenDi" clearable
                                                    filterable collapse-tags placeholder=""
                                                    @change="chonNoiChuyenDi()"
                                                    no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in danh_sach_chuyen_di" :key="i"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Chuyển đi đến tỉnh</label>
                                                    <el-select v-model="info.chuyenDiDenTinh"
                                                        filterable collapse-tags placeholder=""
                                                        @change="chonChuyenDiDenTinh()"
                                                        clearable
                                                        :disabled="true"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in danh_sach_tinh" :key="i"
                                                            :label="item.tenTinhThanh +' - ['+item.maTinhThanh+']'"
                                                            :value="item.maTinhThanh">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Chuyển đi đến huyện</label>
                                                    <el-select :disabled="true" v-model="info.chuyenDiDenQuanHuyen"
                                                        filterable collapse-tags placeholder=""
                                                        clearable
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in danh_sach_huyen_chuyen_di"
                                                            :key="i"
                                                            :label="item.tenQuanHuyen+' - ['+item.maQuanHuyen+']'"
                                                            :value="item.maQuanHuyen">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <label>Chuyển đến từ tỉnh</label>
                                                    <el-select :disabled="true" v-model="info.chuyenDenTuTinh"
                                                        filterable collapse-tags placeholder=""
                                                        clearable
                                                        @change="chonChuyenDenTuTinh()" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in danh_sach_tinh" :key="i"
                                                            :label="item.tenTinhThanh +' - ['+item.maTinhThanh+']'"
                                                            :value="item.maTinhThanh">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-sm-6">
                                                    <label>Chuyển đến từ huyện</label>
                                                    <el-select :disabled="true" v-model="info.chuyenDenTuQuanHuyen"
                                                        filterable collapse-tags placeholder=""
                                                        clearable
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in danh_sach_huyen_chuyen_den"
                                                            :key="i"
                                                            :label="item.tenQuanHuyen+' - ['+item.maQuanHuyen+']'"
                                                            :value="item.maQuanHuyen">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-12">
                                <hr style="margin-top:0px">
                                <el-tabs type="border-card2">
                                    <el-tab-pane>
                                        <span slot="label">Thông tin cá nhân</span>

                                        <div v-if="info.capHoc==45||info.capHoc==4||info.capHoc==5">
                                            <div class="row">
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="khuVuc">Khu vực</label>
                                                        <input disabled id="khuVuc" class="form-control"
                                                               :value="getTen(info.maKhuVuc, list_kv)">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="loaiKhuyetTat">Loại khuyết tật</label>
                                                        <input disabled id="loaiKhuyetTat" class="form-control"
                                                               :value="getTen(info.maLoaiKhuyetTat, list_lkt)">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="doiTuongCsach">Đối tượng chính sách</label>
                                                        <input disabled id="doiTuongCsach" class="form-control"
                                                               :value="getTen(info.maDtuongCsach, list_dtcs)">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="doiTuongUuTien">Đối tượng ưu tiên</label>
                                                        <input disabled id="doiTuongUuTien" class="form-control"
                                                               :value="getTen(info.dtuongUuTien, list_dtut)">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="soCmnd">Số CMND/CCCD/ĐDCN</label>
                                                        <input type="text" id="soCmnd" class="form-control" disabled
                                                               v-model="info.soCmnd"/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Ngày cấp CMND/CCCD/ĐDCN</label>
                                                    <div>
                                                        <!-- <date-picker class="form-control" disabled
                                                                     style="min-width: 50px;" v-model="info.ngayCapCmnd"
                                                                     :lang="lang" ></date-picker> -->
                                                                     
                                                        <input type="text" class="form-control" disabled
                                                        v-model="info.ngayCapCmnd"/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Nơi cấp CMND/CCCD/ĐDCN</label>
                                                    <div>
                                                        <input type="text" class="form-control" disabled
                                                               v-model="info.noiCapCmnd"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="soHoChieu">Số hộ chiếu</label>
                                                        <input type="text" id="soHoChieu" class="form-control" disabled
                                                               v-model="info.soHoChieu"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="ngayCapHoChieu">Ngày cấp hộ chiếu</label>
                                                        <input type="text" id="ngayCapHoChieu" class="form-control"
                                                               disabled v-model="info.ngayCapHoChieu"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="noiCapHoChieu">Nơi cấp hộ chiếu</label>
                                                        <input type="text" id="noiCapHoChieu" class="form-control"
                                                               disabled v-model="info.noiCapHoChieu"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="loaiNhapHoc">Loại nhập học</label>
                                                        <input disabled id="loaiNhapHoc" class="form-control"
                                                               :value="getTen(info.loaiNhapHoc, list_loai_nhap_hoc)"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group" style="visibility:hidden">
                                                        <label class="typo__label" for="loaiNhapHoc">Loại nhập học</label>
                                                        <input disabled id="loaiNhapHoc" class="form-control"
                                                               :value="getTen(info.loaiNhapHoc, list_loai_nhap_hoc)"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6 ">
                                                    <div class="form-group">
                                                        <i v-if="info.buoiHoc == 4 || info.buoiHoc == 5 || info.buoiHoc == 6"
                                                           style="color:#01856b;" class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="hocHaiBuoi">Học 2 buổi</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.tuyenMoiMn" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="hsTuyenMoi">HS tuyển mới</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.lopBanTru" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="treLopBanTru">Trẻ lớp bán trú</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.htChiPhiHocTap" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="htChiPhiHocTap">Hỗ trợ chi phí học tập</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.capTienHangThang" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="capTienHangThang">Cấp tiền hàng tháng</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.htroNhaO" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="hoTroNhaO">Hỗ trợ nhà ở</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.benhMat" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="benhMat">Bệnh về mắt</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.isBietBoiKy1" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="bietBoiKy1">Học sinh biết bơi kỳ I</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.isBietBoiKy2" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="bietBoiKy2">Học sinh biết bơi kỳ II</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.chaDanToc" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="chaDanToc">Có cha dân tộc</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.meDanToc" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="meDanToc">Có mẹ dân tộc</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.isPhCoSmartPhone" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="phCoSmartPhone">Phụ huynh có Smartphone</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <i v-if="info.isPhCoMayTinhInternet" style="color:#01856b;"
                                                           class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        <label class="typo__label" for="phCoMayTinhInternet">Phụ huynh có Máy tính
                                                            Internet</label>
                                                    </div>
                                                </div>


                                            </div>

                                        </div>
                                        <div v-else-if="info.capHoc==1">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Khu vực</label>
                                                    <input disabled class="form-control"
                                                           :value="getTen(info.maKhuVuc,list_kv)">
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Loại khuyết tật</label>
                                                    <input disabled class="form-control"
                                                           :value="getTen(info.maLoaiKhuyetTat,list_lkt)">
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Đối tượng chính sách</label>
                                                    <input disabled class="form-control"
                                                           :value="getTen(info.maDtuongCsach,list_dtcs)">
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Đối tượng ưu tiên</label>
                                                    <input disabled class="form-control"
                                                           :value="getTen(info.dtuongUuTien,list_dtut)">
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Số CMND/CCCD/ĐDCN</label>
                                                    <input type="text" class="form-control" disabled
                                                           v-model="info.soCmnd"/>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Ngày cấp CMND/CCCD/ĐDCN</label>
                                                    <div>
                                                        <!-- <date-picker class="form-control" disabled
                                                                     style="min-width: 50px;" v-model="info.ngayCapCmnd"
                                                                     :lang="lang" ></date-picker> -->
                                                                     
                                                        <input type="text" class="form-control" disabled
                                                        v-model="info.ngayCapCmnd"/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Nơi cấp CMND/CCCD/ĐDCN</label>
                                                    <div>
                                                        <input type="text" class="form-control" disabled
                                                               v-model="info.noiCapCmnd"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Số hộ chiếu</label>
                                                    <input type="text" class="form-control" disabled
                                                           v-model="info.soHoChieu"/>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Ngày cấp hộ chiếu</label>
                                                    <input type="text" class="form-control" disabled
                                                           v-model="info.ngayCapHoChieu"/>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Nơi cấp hộ chiếu</label>
                                                    <input type="text" class="form-control" disabled
                                                           v-model="info.noiCapHoChieu"/>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Loại nhập học</label>
                                                    <input disabled class="form-control"
                                                           :value="getTen(info.loaiNhapHoc,list_loai_nhap_hoc)">
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Số buổi học trên tuần</label>
                                                    <input type="text" class="form-control" disabled
                                                           :value="getTen(info.soBuoiTrenTuan,list_buoi_hoc_tren_tuan)">
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Học bán trú</label>
                                                    <input disabled class="form-control"
                                                           :value="getTen(info.maHocBanTru,list_hoc_ban_tru)">
                                                </div>
                                                <div class="col-md-12"></div>


                                                <!-- Các cột có biểu tượng (i) được chuyển xuống đây -->
                                                <div class="col-sm-6 col-md-4 form-group">
            <span>
                <i v-if="info.khuyetTat" style="color:#01856b;" class="fas fa-check-square"></i>
                <i v-else class="far fa-square"></i>
            </span>
                                                    <label class="typo__label">Khuyết tật</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
            <span>
                <i v-if="info.isHoTroNhaO" style="color:#01856b;" class="fas fa-check-square"></i>
                <i v-else class="far fa-square"></i>
            </span>
                                                    <label class="typo__label">Hỗ trợ nhà ở</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
            <span>
                <i v-if="info.benhVeMat" style="color:#01856b;" class="fas fa-check-square"></i>
                <i v-else class="far fa-square"></i>
            </span>
                                                    <label class="typo__label">Bệnh về mắt</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
            <span>
                <i v-if="info.isHoTroChiPhiHocTap" style="color:#01856b;" class="fas fa-check-square"></i>
                <i v-else class="far fa-square"></i>
            </span>
                                                    <label class="typo__label">Hỗ trợ chi phí học tập</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
            <span>
                <i v-if="info.isCapTienHangThang" style="color:#01856b;" class="fas fa-check-square"></i>
                <i v-else class="far fa-square"></i>
            </span>
                                                    <label class="typo__label">Cấp tiền hàng tháng</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
            <span>
                <i v-if="info.isBietBoiKy1" style="color:#01856b;" class="fas fa-check-square"></i>
                <i v-else class="far fa-square"></i>
            </span>
                                                    <label class="typo__label">Học sinh biết bơi kỳ I</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
            <span>
                <i v-if="info.isBietBoiKy2" style="color:#01856b;" class="fas fa-check-square"></i>
                <i v-else class="far fa-square"></i>
            </span>
                                                    <label class="typo__label">Học sinh biết bơi kỳ II</label>
                                                </div>


                                                <!-- Moving sections with checkboxes to the bottom -->
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.isPhCoSmartPhone" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Phụ huynh có Smartphone</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.isPhCoMayTinhInternet" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Phụ huynh có Máy tính Internet</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.chaDanToc" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Có cha dân tộc</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.meDanToc" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Có mẹ dân tộc</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.hocSinhBanTru" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học sinh bán trú</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.lopBanTru" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học sinh lớp bán trú</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.hocSinhBanTruDanNuoi" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học sinh bán trú dân nuôi</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.hocSinhNoiTru" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học sinh nội trú</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.hocSinhNoiTruDanNuoi" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học sinh nội trú dân nuôi</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.doiVien" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Đội viên</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.hocLopMg5T" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Đã học lớp mẫu giáo 5 tuổi</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.hocCtgdCuaBo" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học chương trình giáo dục của Bộ</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.hocSinhTiengDanToc" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học tiếng dân tộc</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.tangCuongTviet" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Tăng cường tiếng Việt</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.hocSongNgu" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học song ngữ</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.nhuCauHtroNngu" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học sinh nhu cầu hỗ trợ ngoại ngữ</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.hocSinhDanTocTroGiang" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học sinh dân tộc trợ giảng</label>
                                                </div>

                                            </div>

                                        </div>
                                        <div v-else-if="info.capHoc==2||info.capHoc==3">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Khu vực</label>
                                                    <div>
                                                        <input disabled class="form-control"
                                                               :value="getTen(info.maKhuVuc, list_kv)">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Loại khuyết tật</label>
                                                    <div>
                                                        <input disabled class="form-control"
                                                               :value="getTen(info.maLoaiKhuyetTat, list_lkt)">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Đối tượng chính sách</label>
                                                    <div>
                                                        <input disabled class="form-control"
                                                               :value="getTen(info.maDtuongCsach, list_dtcs)">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Đối tượng ưu tiên</label>
                                                    <div>
                                                        <input disabled class="form-control"
                                                               :value="getTen(info.dtuongUuTien, list_dtut)">
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Số CMND/CCCD/ĐDCN</label>
                                                    <div>
                                                        <input type="text" class="form-control" disabled
                                                               v-model="info.soCmnd"/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Ngày cấp CMND/CCCD/ĐDCN</label>
                                                    <div>
                                                        <input type="text" class="form-control" disabled
                                                               v-model="info.ngayCapCmnd"/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Nơi cấp CMND/CCCD/ĐDCN</label>
                                                    <div>
                                                        <input type="text" class="form-control" disabled
                                                               v-model="info.noiCapCmnd"/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Số hộ chiếu</label>
                                                    <div>
                                                        <input type="text" class="form-control" disabled
                                                               v-model="info.soHoChieu"/>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Ngày cấp hộ chiếu</label>
                                                    <div>
                                                        <input type="text" class="form-control" disabled
                                                               v-model="info.ngayCapHoChieu"/>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Nơi cấp hộ chiếu</label>
                                                    <input type="text" class="form-control" disabled
                                                           v-model="info.noiCapHoChieu"/>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Loại nhập học</label>
                                                    <input disabled class="form-control"
                                                           :value="getTen(info.loaiNhapHoc, list_loai_nhap_hoc)"/>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Số buổi học trên tuần</label>
                                                    <input type="text" disabled class="form-control"
                                                           :value="getTen(info.soBuoiTrenTuan, list_buoi_hoc_tren_tuan)"/>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Hướng nghiệp, dạy nghề</label>
                                                    <input disabled class="form-control"
                                                           :value="getTen(info.maLopHuongNghiepDayNghe, list_huong_nghiep)"/>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Học bán trú</label>
                                                    <input disabled class="form-control"
                                                           :value="getTen(info.maHocBanTru, list_hoc_ban_tru)"/>

                                                </div>
                                                <div class="col-md-12"></div>

                                                <!-- The rows with the far class are moved to the end below -->
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.khuyetTat" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Khuyết tật</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.khuyetTatKhongDanhGia" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Khuyết tật không đánh giá</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.isHoTroNhaO" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Hỗ trợ nhà ở</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.isHoTroChiPhiHocTap" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Hỗ trợ chi phí học tập</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.isCapTienHangThang" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Cấp tiền hàng tháng</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.benhVeMat" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Bệnh về mắt</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.isBietBoiKy1" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học sinh biết bơi kỳ I</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <span v-if="info.isBietBoiKy2" style="color:#01856b;"
                                                          class="fas fa-check-square"></span>
                                                    <span v-else class="far fa-square"></span>
                                                    <label class="typo__label">Học sinh biết bơi kỳ II</label>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.chaDanToc" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Có cha dân tộc</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.meDanToc" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Có mẹ dân tộc</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.isPhCoSmartPhone" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Phụ huynh có Smartphone</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.isPhCoMayTinhInternet" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Phụ huynh có Máy tính Internet</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.doiVien" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Đội viên</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.doanVien" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Đoàn viên</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.hocSinhBanTru" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Học sinh bán trú</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.lopBanTru" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Học sinh lớp bán trú</label>
                                                </div>



                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.hocSinhBanTruDanNuoi" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Học sinh bán trú dân nuôi</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.hocSinhPtdtBanTru" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Học sinh phổ thông dân tộc bán trú</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.hocSinhNoiTru" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Học sinh nội trú</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.hocSinhNoiTruDanNuoi" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Học sinh nội trú dân nuôi</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.hocSongNgu" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Học song ngữ</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.hocSinhTiengDanToc" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Học tiếng dân tộc</label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
    <span>
        <i v-if="info.hocCtgdCuaBo" style="color:#01856b;" class="fas fa-check-square"></i>
        <i v-else class="far fa-square"></i>
    </span>
                                                    <label class="typo__label">Học chương trình giáo dục của Bộ</label>
                                                </div>


                                            </div>


                                        </div>
                                        <div v-else>
                                            <div class="row">
                                                <div class="col-md-12 text-center">
                                                    <p><b>Chưa có dữ liệu</b></p>
                                                </div>
                                            </div>
                                        </div>
                                    </el-tab-pane>
                                    <el-tab-pane label="Config">
                                        <span slot="label">Thông tin liên hệ, gia đình</span>

                                        <div class="row">
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Họ tên bố</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.hoTenBo">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Nghề nghiệp bố</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.ngheNghiepBo">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Năm sinh bố</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.ngaySinhBo">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Nơi làm việc bố</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.noiLamViecBo">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Số điện thoại bố</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.soDienThoaiBo">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Số CCCD/CMND/ĐDCN bố</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.soCmndCha">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Bố là người dân tộc</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.boLaNguoiDanToc">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Họ tên mẹ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.hoTenMe">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Nghề nghiệp mẹ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.ngheNghiepMe">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Năm sinh mẹ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.ngaySinhMe">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Nơi làm việc mẹ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.noiLamViecMe">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Số điện thoại mẹ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.soDienThoaiMe">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Số CCCD/CMND/ĐDCN mẹ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.soCmndMe">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Mẹ là người dân tộc</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.meLaNguoiDanToc">
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Họ tên người giám hộ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.hoTenNguoiGiamHo">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Nghề nghiệp người giám hộ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.ngheNghiepNguoiGiamHo">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Năm sinh người giám hộ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.ngaySinhNguoiGiamHo">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Nơi làm việc người giám hộ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.noiLamViecNguoiGiamHo">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Số điện thoại người giám hộ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.dienThoaiNguoiGiamHo">
                                            </div>
                                            <div class="col-md-4 col-6 form-group">
                                                <label class="typo__label"><b>Số CCCD/CMND/ĐDCN người giám hộ</b></label>
                                                <input class="form-control" disabled type="text" v-model="info.soCmndNguoiGiamHo">
                                            </div>
                                        </div>

                                    </el-tab-pane>
                                </el-tabs>


                            </div>
                        </div>
                    </el-col>
                </el-row>
            </form>

            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <!-- <el-button type="primary" @click.prevent="submitForm('ruleForm')" size="mini">Lưu</el-button> -->
            </span>
        </el-dialog>

    </div>
</template>
<script>
import moment, {
    parseTwoDigitYear
} from 'moment'
import utils from '../../../utils'
import constant from '../../../utils/constant';
import datePicker from 'vue2-datepicker';
import rest_api from '../../../utils/rest_api';
import array_util from '../../../utils/array_utils';
import timeutils from "../../../utils/time_utils";
import 'vue2-datepicker/index.css';
import 'vue2-datepicker/locale/vi';
import api from '../../api';
import VueAlertify from "vue-alertify";

Vue.use(VueAlertify, {
    notifier: {
        delay: 5,
        position: 'top-right'
    },
    glossary: {
        title: 'Thông báo',
        ok: 'Đồng ý',
        cancel: 'Hủy'
    }
});
export default {
    props: [
        'item', 'show'
    ],
    watch: {
        show: function (newVal, oldVal) {
            console.log("newVal = " + newVal);
            if (newVal) {
                this.getDanhSachTinh();
                this.getDataStudent();
                this.layHuyen();
                $("#modal_info_student").modal();
            } else {
                this.show_thong_tin = false;
                $("#modal_info_student").modal('hide');
            }
        },
        'info.NoiSinhTinhThanh': function (val) {
            this.danh_sach_huyen = []
            console.log('111')
            if (val) {
                this.layHuyen(val, 'den');
            }
        },
    },
    data() {
        return {
            show_thong_tin:false,
            danh_sach_huyen: [],
            danh_sach_tinh: [],
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            configDate: {
                format: 'DD/MM/YYYY',
                useCurrent: false,
                showTodayButton: true,
                locale: 'vi'
            },
            configDatePicker: {
                format: 'YYYY-MM-DD',
                useCurrent: false,
                showTodayButton: true,
                locale: 'vi'
            },
            info: {},
            danh_sach_huyen_chuyen_di: [],
            danh_sach_huyen_chuyen_den: [],
            list_tt_hs: [{
                name: "Chọn",
                value: ""
            }, {
                name: "Đang học",
                value: 1
            }, {
                name: "Chuyển khỏi trường",
                value: 3
            }, {
                name: "Bỏ học",
                value: 4
            },],
            danh_sach_chuyen_di: [],
            list_dantoc: [],
            list_quoctich: [],
            list_tongiao: [],
            list_nhommau: [],
            list_dtcs: [],
            list_dtut: [],
            list_kv: [],
            list_lkt: [],
            list_loai_nhap_hoc: [],
            list_buoi_hoc_tren_tuan: [],
            list_hoc_ban_tru: [],
            list_huong_nghiep: [],
            list_tpgd: [],
            list_nhom_tuoi_mam_non: [],
            list_ly_do_thoi_hoc: [],
            list_khoi_hoc: constant.list_khoi_hoc,
            khoi_mot: constant.khoiCapMot,
            khoi_hai: constant.khoiCapHai,
            khoi_ba: constant.khoiCapBa,
            khoi_mam_non: constant.khoi_mam_non_hai_cap,
            list_lop_hoc: [{
                name: "chọn",
                value: ""
            }],
            noiOHienNay: ''
        }
    },
    mounted: function () {
        this.ganDuLieuSME();
        console.log("mount thông tin học sinh");
        console.log(JSON.stringify(this.item));
        
        this.danh_sach_chuyen_di = JSON.parse(localStorage["danh_sach_chuyen_di_sme"]);
        // $("#modal_info_student").modal();
        $(this.$refs.modal_info_student).on("hidden.bs.modal", this.close);
    },
    components: {
        datePicker
    },
    methods: {

        chonNoiChuyenDi() {
                console.log('chonNoiChuyenDi')
                this.danh_sach_huyen_chuyen_di = []
                console.log(this.info.noiChuyenDi)
                this.info.chuyenDiDenQuanHuyen = ''
                if (this.info.noiChuyenDi) {
                    this.layHuyen(this.info.chuyenDiDenTinh, 'di');
                }
            },
            chonChuyenDiDenTinh() {
                console.log('chonChuyenDiDenTinh')
                this.info.chuyenDiDenQuanHuyen = ''
                console.log(this.info.chuyenDiDenTinh)
                if (this.info.chuyenDiDenTinh) {
                    this.layHuyen(this.info.chuyenDiDenTinh, 'di');
                }
            },
            chonChuyenDenTuTinh(){
                console.log('chonChuyenDenTuTinh')
                this.info.chuyenDenTuQuanHuyen = ''
                console.log(this.info.chuyenDiDenTinh)
                if (this.info.chuyenDiDenTinh) {
                    this.layHuyen(this.info.chuyenDiDenTinh, 'den');
                }
            },
        layHuyen(tinh, loai) {
            console.log('layHuyen');
            console.log('Lấy huyện chuyển ', loai);

            let params = {
                "start": 0,
                "limit": 9999,
                "ma": '',
                "ten": '',
                "trangthai": 1,
            };
            // if (loai === 'den') {
                params.check = false
            // }
            console.log("lấy ds quận huyện:");
            console.log(params);
            rest_api.get("/internal-api/dmQuanHuyen/filter", params, response => {
                console.log('Lấy huyện trả về');
                console.log(response);
                if (response.data.code == 200) {
                        this.danh_sach_huyen_chuyen_den = response.data.rows;
                        this.danh_sach_huyen_chuyen_di = response.data.rows;
                }
                console.log('danh_sach_huyen');
                console.log(this.danh_sach_huyen_chuyen_den);
                console.log('danh_sach_huyen');
                console.log(this.danh_sach_huyen_chuyen_di);
            });
        },
        getDanhSachTinh() {
            let params = {
                "start": 0,
                "limit": 99,
                "ma": '',
                "ten": '',
                "trangthai": 1,
            };
            this.danh_sach_tinh = [];
            rest_api.get("/internal-api/dmTinhThanh/filter", params, (response) => {
                console.log('response');
                console.log(response);
                if (response.data.code == 200) {
                    this.danh_sach_tinh = response.data.rows;
                }

            });
        },
        handleClose() {
            this.close()
        },
        getNoiOHienNay() {
            console.log('getNoiOHienNay');
            console.log(this.info);
            console.log(this.info.dchiThtru);
            console.log(this.info.dchiTmtru);
            let result = this.info.dchiThtru ?? this.info.dchiTmtru ?? ''
            console.log('result');
            console.log(result);
            return result
        },
        scrollToElement() {
            console.log("kéo lên đầu")
            const el = this.$refs.scrollToMe;
            if (el) {
                el.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        },
        ganDuLieuSME() {
            console.log("gasn du lieu sme")
            let tmp = localStorage["danh_sach_dan_toc_sme"];
            if (tmp) {
                this.list_dantoc = JSON.parse(localStorage["danh_sach_dan_toc_sme"]);
                this.list_quoctich = JSON.parse(localStorage["danh_sach_quoc_tich_sme"]);
                this.list_tongiao = JSON.parse(localStorage["danh_sach_ton_giao_sme"]);
                this.list_nhommau = JSON.parse(localStorage["danh_sach_nhom_mau_sme"]);
                this.list_dtcs = JSON.parse(localStorage["danh_sach_doi_tuong_chinh_sach_sme"]);
                this.list_dtut = JSON.parse(localStorage["danh_sach_doi_tuong_uu_tien_sme"]);
                this.list_kv = JSON.parse(localStorage["danh_sach_khu_vuc_sme"]);
                this.list_lkt = JSON.parse(localStorage["danh_sach_loai_khuyet_tat_sme"]);
                this.list_loai_nhap_hoc = JSON.parse(localStorage["danh_sach_loai_nhap_hoc_sme"]);
                this.list_buoi_hoc_tren_tuan = JSON.parse(localStorage["danh_sach_so_buoi_hoc_tren_tuan_sme"]);
                this.list_hoc_ban_tru = JSON.parse(localStorage["danh_sach_hoc_ban_tru_sme"]);
                this.list_huong_nghiep = JSON.parse(localStorage["danh_sach_huong_nghiep_sme"]);
                this.list_tpgd = JSON.parse(localStorage["danh_sach_thanh_phan_gia_dinh_sme"]);
                this.list_nhom_tuoi_mam_non = JSON.parse(localStorage["danh_sach_nhom_tuoi_mam_non_sme"]);
                this.list_ly_do_thoi_hoc = JSON.parse(localStorage["danh_sach_ly_do_thoi_hoc_sme"]);
            }
        },
        getTen(val, lst) {
            let ten = "";
            for (let i = 0; i < lst.length; i++) {
                if (val == lst[i].value) {
                    ten = lst[i].name;
                }
            }
            return ten;
        },
        getTen2(val, lst) {
            let ten = "";
            for (let i = 0; i < lst.length; i++) {
                if (val == lst[i].id) {
                    ten = lst[i].name;
                }
            }
            return ten;
        },
        close() {
            console.log("close modal");
            this.$emit('close');
        },
        getDanhSachLop() {
            let params = {
                "maTruong": this.info.maTruongHoc,
                "namHoc": this.info.namHoc,
                "khoiHoc": this.info.khoiHoc,
            };
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.get('/csdlgd-admin/lopHoc/findGroupMaLopHoc', params, data => {
                loading.close();
                let data_demo = data.data.tableData;

                for (let i = 0; i < data_demo.length; i++) {
                    let obj = {
                        name: data_demo[i].tenLopHoc,
                        value: data_demo[i].maLopHoc,
                    };
                    this.list_lop_hoc.push(obj);
                }
            });
        },
        getDataStudent() {
            let params = {
                "idHsTheoNam": this.item,
            };

            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.get("/csdlgd-admin/hocSinh/infor", params, (data) => {
                console.log("Data trả về:");
                console.log(JSON.stringify(data.data));
                if (data.data != null) {
                    console.error("Có dữ liệu:")
                    this.info = data.data;
                    console.log(this.info)
                    loading.close();
                    this.scrollToElement();
                    let capHocHs = this.info.capHoc;
                    this.noiOHienNay = this.info.dchiThtru ?? this.info.dchiTmtru ?? ''
                    if (capHocHs) {
                        if (capHocHs == 1) {
                            this.list_khoi_hoc = this.khoi_mot
                        }
                        if (capHocHs == 2) {
                            this.list_khoi_hoc = this.khoi_hai
                        }
                        if (capHocHs == 3) {
                            this.list_khoi_hoc = this.khoi_ba
                        }
                        if (capHocHs == 4 || capHocHs == 5 || capHocHs == 45) {
                            this.list_khoi_hoc = this.khoi_mam_non
                        }
                    }
                    if (this.info.khoiHoc == 13 || this.info.khoiHoc == 14 || this.info.khoiHoc == 15) {
                        this.info.khoiHoc = 13
                    }
                    if (this.info.khoiHoc == 16 || this.info.khoiHoc == 17 || this.info.khoiHoc == 18) {
                        this.info.khoiHoc = 16
                    }
                    this.getDanhSachLop();
                    this.show_thong_tin = true;
                } else {
                    loading.close();
                    utils.showDialog(
                        "Thông báo",
                        "Đã xảy ra lỗi trong quá trình lấy dữ liệu. Vui lòng thử lại.",
                        null,
                        () => {
                        }
                    );
                }
            });
        },
    }
}

</script>
<style scoped="scoped">
label{
    margin-bottom: 8px;
}

.text-right label {
    padding: 6px 0;
}

.nav-tabs > li.active > a {
    font-weight: bold;
    color: forestgreen;
    border-top: 4px solid forestgreen;
}

.rct {
    margin: 20px -15px !important;
    display: flex;
}

.rct > .col-md-7,
.col-md-1,
.col-md-2,
.col-md-3,
.col-md-12,
    /* .col-md-6, */
.col-md-9,
.col-md-10,
.col-md-11,
.col-md-12,
.col-md-12,
.col-md-5 {
    align-self: center;
}

.cg {
    text-align: center;
}

.bt > a > b > i {
    color: #DC0101;
    border: 1px solid black;
    padding: 5px 6px;
    border-radius: 23%;
}

.tieuDeThongTin {
    color: #337ab7
}

.pt-2 {
    padding-top: 9px;
}

.ptb-10 {
    padding: 5px 0;
}

.blockInfo .row {
    padding: 5px 0;
}

</style>

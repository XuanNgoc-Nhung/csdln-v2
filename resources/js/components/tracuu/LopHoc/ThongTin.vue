<template>
    <div v-loading.fullscreen.lock="fullScreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog title="Thông tin lớp học" :visible.sync="show" top="5vh" width="1200"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
            <form style="padding-bottom:0; margin-bottom:0 !important">
                <el-row :gutter="24"  style="padding-bottom:0; margin-bottom:0 !important">
                    <el-col :span="24" style="padding-bottom:0 !important; padding-top:0 !important">
                        <div ref="scrollToMe" style="margin-bottom: 20px"></div>
                        <div class="row" v-if="thongTinLopHoc.capHoc==4||thongTinLopHoc.capHoc==5">
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Nhóm lớp </label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" disabled class="form-control"
                                            :value="getTen2(thongTinLopHoc.khoiHoc,list_khoi_hoc)">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Nhóm tuổi <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maNhomTuoiMn,list_nhom_tuoi_mam_non)" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Tên lớp <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" disabled v-model="thongTinLopHoc.tenLopHoc"
                                            class="form-control" />
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học bán trú</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maHocBanTru,list_hoc_ban_tru)"
                                               disabled class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã định danh</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" v-model="thongTinLopHoc.moetCode" disabled
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Điểm trường</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maDiemTruong,list_diem_truong)"
                                            disabled class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <!--                                <div class="row form-group">-->
                                <!--                                    <div class="col-sm-12">-->
                                <!--                                        <label class="typo__label">Giáo viên chủ nhiệm</label>-->
                                <!--                                    </div>-->
                                <!--                                    <div class="col-sm-12">-->
                                <!--                                        <input type="text" :value="getTen(thongTinLopHoc.maGvcn,list_gvcn)" disabled-->
                                <!--                                            class="form-control">-->
                                <!--                                    </div>-->
                                <!--                                </div>-->

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã GVCN đầu năm</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="thongTinLopHoc.maGvcn" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã GVCN cuối năm</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="thongTinLopHoc.maGvcnCn" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" disabled v-model="thongTinLopHoc.maLopHoc"
                                               class="form-control" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Ghép vào lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" disabled v-model="thongTinLopHoc.maLopGhep"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Buổi học</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.buoiHoc,list_buoi_hoc)"
                                               disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số thứ tự</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="thongTinLopHoc.thuTu" disabled class="form-control">
                                    </div>
                                </div>



                            </div>
                            <div class="col-sm-12"></div>
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopBanTru" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Bán trú</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopGhep" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Nhóm trẻ ghép</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <i v-if="thongTinLopHoc.ctrinhGdmnMoi" style="color:#01856b;"
                                               class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i>
                                            C.trình giáo dục MN mới
                                        </label>

                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.ctrinhCsocGduc" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">C.trình chăm sóc giáo dục</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.dayChuongTrinhLamQuenNgoaiNgu" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Dạy chương trình làm quen Ngoại ngữ</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.hoc2BuoiNgay" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Học 2 buổi/ngày</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopCoTreKhuyetTat" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Có trẻ khuyết tật</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row" v-if="thongTinLopHoc.capHoc==1">
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Khối</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen2(thongTinLopHoc.khoiHoc,list_khoi_hoc)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Tên lớp <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" disabled v-model="thongTinLopHoc.tenLopHoc"
                                            class="form-control" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã định danh</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" disabled v-model="thongTinLopHoc.moetCode"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số buổi học/tuần</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.soBuoiTrenTuan,list_so_buoi_hoc_tren_tuan)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số tiết học/tuần</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maTietHoc,list_so_tiet_hoc_tren_tuan)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Điểm trường</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maDiemTruong,list_diem_truong)"
                                            disabled class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">

                                    <div class="col-sm-12">
                                        <label class="typo__label">Ghép vào lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" disabled class="form-control"
                                            v-model="thongTinLopHoc.maLopGhep" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã GVCN đầu năm</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="thongTinLopHoc.maGvcnDn" disabled
                                               class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã GVCN cuối năm</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="thongTinLopHoc.maGvcnCn" disabled
                                               class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">

                                    <div class="col-sm-12">
                                        <label class="typo__label">Học bán trú</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maHocBanTru,list_hoc_ban_tru)"
                                               disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Hình thức học tập</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                               :value="getTen(thongTinLopHoc.maHthucDtaoHtap,list_hinh_thuc_dao_tao_hoc_tap)"
                                               disabled class="form-control">
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học ngoại ngữ 1</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maNn1,list_ngoai_ngu)" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Chương trình học (NN1)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maChuongTrinhHocNn1,list_chuong_trinh_hoc_nn)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số tiết NN/tuần (NN1)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maSoTietNgoaiNgu1,list_so_tiet_nn)" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học ngoại ngữ 2</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maNn2,list_ngoai_ngu)" disabled
                                            class="form-control">
                                    </div>
                                </div>



                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Chương trình học (NN2)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maChuongTrinhHocNn2,list_chuong_trinh_hoc_nn)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số tiết NN/tuần (NN2)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maSoTietNgoaiNgu2,list_so_tiet_nn)" disabled
                                            class="form-control">
                                    </div>
                                </div>



                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Lớp đào tạo, bồi dưỡng</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maLopDtaoBduong,list_lop_dao_tao_boi_duong)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Lớp hướng nghiệp dạy nghề</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maLopHnghiepDayNghe,list_day_nghe_huong_nghiep)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Bộ sách giáo khoa sử dụng</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maBoSgkSuDung,list_bo_sgk)"
                                            disabled class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Kiểu lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maKieuLop,list_bo_tuc)"
                                            disabled class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số thứ tự</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="thongTinLopHoc.thuTu" disabled class="form-control">
                                    </div>
                                </div>

                            </div>

                            <div class="col-sm-12"></div>
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopBanTru" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Bán trú</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopGhep" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Lớp ghép</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopVnen" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Lớp VNEN</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.thietBiDhocTviet" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Đủ TBDH - Tiếng Việt</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.thietBiDhocToan" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Đủ TBDH - Toán</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.daiDienChaMeLop" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Có Đ.diện cha, mẹ hs lớp</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.daiDienChaMeTruong" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Có Đ.diện cha, mẹ hs trường</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopChuyenBiet" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Chuyên biệt</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.isLopMuChu" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Lớp xóa mù chữ</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row" v-if="thongTinLopHoc.capHoc==2||thongTinLopHoc.capHoc==3">
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Khối</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen2(thongTinLopHoc.khoiHoc,list_khoi_hoc)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Tên lớp <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" disabled v-model="thongTinLopHoc.tenLopHoc"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" disabled v-model="thongTinLopHoc.maLopHoc"
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã định danh</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" v-model="thongTinLopHoc.moetCode" disabled
                                            class="form-control" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số buổi học/tuần</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.soBuoiTrenTuan,list_so_buoi_hoc_tren_tuan)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Điểm trường</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maDiemTruong,list_diem_truong)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số thứ tự</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="thongTinLopHoc.thuTu" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Kiểu lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maKieuLop,list_bo_tuc)"
                                            disabled class="form-control">
                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-6">
                                <!--                                <div class="row form-group">-->
                                <!--                                    <div class="col-sm-12">-->
                                <!--                                        <label class="typo__label">Giáo viên chủ nhiệm</label>-->
                                <!--                                    </div>-->
                                <!--                                    <div class="col-sm-12">-->
                                <!--                                        <input type="text" :value="getTen(thongTinLopHoc.maGvcn,list_gvcn)" disabled-->
                                <!--                                            class="form-control">-->
                                <!--                                    </div>-->
                                <!--                                </div>-->

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã GVCN đầu năm</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="thongTinLopHoc.maGvcn" disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã GVCN cuối năm</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="thongTinLopHoc.maGvcnCn" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học ngoại ngữ 1</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maNn1,list_ngoai_ngu)" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Chương trình học (NN1)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maChuongTrinhHocNn1,list_chuong_trinh_hoc_nn)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số tiết NN/tuần (NN1)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maSoTietNgoaiNgu1,list_so_tiet_nn)" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học ngoại ngữ 2</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" :value="getTen(thongTinLopHoc.maNn2,list_ngoai_ngu)" disabled
                                            class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Chương trình học (NN2)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maChuongTrinhHocNn2,list_chuong_trinh_hoc_nn)"
                                            disabled class="form-control">
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số tiết NN/tuần (NN2)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text"
                                            :value="getTen(thongTinLopHoc.maSoTietNgoaiNgu2,list_so_tiet_nn)" disabled
                                            class="form-control">
                                    </div>
                                </div>


                            </div>

                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Ghép vào lớp</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" disabled class="form-control"
                                                       v-model="thongTinLopHoc.maLopGhep" />
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Hệ chuyên</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" :value="thongTinLopHoc.maHeChuyen" disabled
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Lớp đào tạo, bồi dưỡng</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text"
                                                       :value="getTen(thongTinLopHoc.maLopDtaoBduong,list_lop_dao_tao_boi_duong)"
                                                       disabled class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Lớp hướng nghiệp dạy nghề</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text"
                                                       :value="getTen(thongTinLopHoc.maLopHnghiepDayNghe,list_day_nghe_huong_nghiep)"
                                                       disabled class="form-control">
                                            </div>
                                        </div>


                                    </div>
                                    <div class="col-sm-6">

                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Học bán trú</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" :value="getTen(thongTinLopHoc.maHocBanTru,list_hoc_ban_tru)"
                                                       disabled class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Học nghề phổ thông</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" :value="thongTinLopHoc.maLopHuongNghiepDayNghe" disabled
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Hình thức học tập</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text"
                                                       :value="getTen(thongTinLopHoc.maHthucDtaoHtap,list_hinh_thuc_dao_tao_hoc_tap)"
                                                       disabled class="form-control">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Bộ sách giáo khoa sử dụng</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <input type="text" :value="getTen(thongTinLopHoc.maBoSgkSuDung,list_bo_sgk)"
                                                       disabled class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>



                            <div class="col-sm-12">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopGhep" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Lớp ghép</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopChuyen" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Lớp chuyên</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopBanTru" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Bán trú</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.coHocSinhHocNghe" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Học sinh học nghề</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopVnen" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Lớp VNEN</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopTinHoc" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Lớp tin học</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.lopChuyenBiet" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Lớp chuyên biệt</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.daiDienChaMeLop" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Có đại diện cha mẹ học sinh lớp</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <i v-if="thongTinLopHoc.daiDienChaMeTruong" style="color:#01856b;" class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                        <label class="typo__label">Có đại diện cha mẹ học sinh trường</label>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <i v-if="thongTinLopHoc.lopCoTreKhuyetTat" style="color:#01856b;"
                                               class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i>

                                            Có học sinh khuyết tật
                                        </label>
                                    </div>

                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">

                                            <i v-if="thongTinLopHoc.isHocctgdSKSSvaHIV" style="color:#01856b;"
                                               class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i>

                                            Học chương trình giáo dục của Bộ GD&ĐT về sức khỏe sinh sản và HIV/AIDS dựa trên kỹ năng sống
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                            </div>


                        </div>

                    </el-col>
                </el-row>
            </form>

            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>

            </span>
        </el-dialog>

    </div>
</template>
<script>
    import utils from '../../../utils'
    import constant from '../../../utils/constant';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import rest_api from '../../../utils/rest_api';
    export default {
        props: [
            'item', 'show'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.getThongTinLopHoc(this.item);
                    $("#modal_info_class").modal();
                } else {
                    $("#modal_info_class").modal('hide');
                }
            },
        },
        data() {
            return {
                fullScreenLoading: false,
                thongTinLopHoc: {},
                tmp: {},
                tmpbt: {},
                list_diem_truong: [{
                    name: "Chọn",
                    value: ""
                }, ],
                list_gvcn: [{
                    name: "Chọn",
                    value: ""
                }, ],
                list_khoi_hoc: constant.list_khoi_hoc,
                khoi_mot: constant.khoiCapMot,
                khoi_hai: constant.khoiCapHai,
                khoi_ba: constant.khoiCapBa,
                khoi_mam_non: constant.khoi_mam_non_hai_cap,
                list_nhom_thang: [{
                    name: "Chọn",
                    value: ""
                }, {
                    name: "13-24 Tháng",
                    value: "02"
                }, {
                    name: "25-36 Tháng",
                    value: "03"
                }, {
                    name: "3-12 Tháng",
                    value: "01"
                }],
                list_nhom_tuoi: [{
                    name: "Chọn",
                    value: ""
                }, {
                    name: "3-4 Tuổi",
                    value: "04"
                }, {
                    name: "4-5 Tuổi",
                    value: "05"
                }, {
                    name: "5-6 Tuổi",
                    value: "06"
                }],
                list_nhom_tuoi_mam_non: [],
                list_buoi_hoc: [],
                list_hoc_ban_tru: [],
                list_so_buoi_hoc_tren_tuan: [],
                list_so_tiet_hoc_tren_tuan: [],
                list_ngoai_ngu: [],
                list_so_tiet_nn: [],
                list_chuong_trinh_hoc_nn: [],
                list_hinh_thuc_dao_tao_hoc_tap: [],
                list_lop_dao_tao_boi_duong: [],
                list_day_nghe_huong_nghiep: [],
                list_phan_ban: [],
                list_bo_sgk: [],
                list_bo_tuc: [],
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            // $("#modal_info_class").modal();
            // this.getThongTinLopHoc(this.item);
            $(this.$refs.modal_info_class).on("hidden.bs.modal", this.close);
        },
        components: {
            datePicker,
        },
        methods: {
            handleClose(){
                this.close()
            },
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_nhom_tuoi_mam_non_sme"];
                if (tmp) {
                    this.list_nhom_tuoi_mam_non = JSON.parse(localStorage["danh_sach_nhom_tuoi_mam_non_sme"]);
                    this.list_buoi_hoc = JSON.parse(localStorage["danh_sach_buoi_hoc_sme"]);
                    this.list_hoc_ban_tru = JSON.parse(localStorage["danh_sach_hoc_ban_tru_sme"]);
                    this.list_so_buoi_hoc_tren_tuan = JSON.parse(localStorage["danh_sach_so_buoi_hoc_tren_tuan_sme"]);
                    this.list_so_tiet_hoc_tren_tuan = JSON.parse(localStorage["danh_sach_so_tiet_hoc_tren_tuan_sme"]);
                    this.list_ngoai_ngu = JSON.parse(localStorage["danh_sach_ngoai_ngu_chinh_sme"]);
                    this.list_so_tiet_nn = JSON.parse(localStorage["danh_sach_so_tiet_hoc_ngoai_ngu_sme"]);
                    this.list_chuong_trinh_hoc_nn = JSON.parse(localStorage[
                        "danh_sach_chuong_trinh_hoc_ngoai_ngu_sme"]);
                    this.list_hinh_thuc_dao_tao_hoc_tap = JSON.parse(localStorage[
                        "danh_sach_hinh_thuc_dao_tao_hoc_tap_sme"]);
                    this.list_lop_dao_tao_boi_duong = JSON.parse(localStorage["danh_sach_lop_dao_tao_boi_duong_sme"]);
                    this.list_day_nghe_huong_nghiep = JSON.parse(localStorage["danh_sach_huong_nghiep_sme"]);
                    this.list_phan_ban = JSON.parse(localStorage["danh_sach_phan_ban_sme"]);
                    this.list_bo_sgk = JSON.parse(localStorage["danh_sach_bo_sach_giao_khoa_sme"]);
                    this.list_bo_tuc = JSON.parse(localStorage["danh_sach_lop_bo_tuc_thcs_sme"]);
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
            chonGvCn() {
                this.thongTinLopHoc.maGvcnCn = this.thongTinLopHoc.maGvcn;
            },
            getGvCn() {
                let params = {
                    "maTruong": this.thongTinLopHoc.maTruongHoc,
                    "namHoc": this.thongTinLopHoc.namHoc,
                };
                this.fullScreenLoading = true;
                rest_api.get('/csdlgd-admin/giaoVien/danhSachGvcn', params, data => {
                    this.fullScreenLoading = false;
                    let data_demo = data.data.rows;
                    for (let i = 0; i < data_demo.length; i++) {
                        let obj = {
                            name: data_demo[i].tenCanBo + " - " + data_demo[i].maGiaoVien,
                            value: data_demo[i].maGiaoVien,
                        };
                        this.list_gvcn.push(obj);
                    }
                    console.log("list_gvcn trường:");
                    console.log(JSON.stringify(this.list_gvcn));
                });


            },
            chonNhomLop() {
                this.thongTinLopHoc.maNhomTuoiMn = "";
                if (this.thongTinLopHoc.khoiHoc == 13) {
                    this.list_nhom_tuoi_mam_non = this.list_nhom_thang;
                }
                if (this.thongTinLopHoc.khoiHoc == 16) {
                    this.list_nhom_tuoi_mam_non = this.list_nhom_tuoi;
                }
            },
            getThongTinLopHoc(e) {
                console.log("lấy thông tin học sinh");
                let params = {
                    "id": e,
                };
                this.fullScreenLoading = true;
                rest_api.get("/csdlgd-admin/lopHoc/infor", params, (data) => {
                    this.fullScreenLoading = false;
                    if (data.data) {
                        this.thongTinLopHoc = data.data;
                        let capHocHs = this.thongTinLopHoc.capHoc;
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
                        if (this.thongTinLopHoc.khoiHoc == 13 || this.thongTinLopHoc.khoiHoc == 14 || this
                            .thongTinLopHoc.khoiHoc == 15) {
                            this.thongTinLopHoc.khoiHoc = 13
                            this.list_nhom_tuoi_mam_non = this.list_nhom_thang;
                        }
                        if (this.thongTinLopHoc.khoiHoc == 16 || this.thongTinLopHoc.khoiHoc == 17 || this
                            .thongTinLopHoc.khoiHoc == 18) {
                            this.thongTinLopHoc.khoiHoc = 16
                            this.list_nhom_tuoi_mam_non = this.list_nhom_tuoi;
                        }
                        this.getDiemTruong();
                        this.getGvCn();
                        this.scrollToElement();
                    } else {
                        this.thongBao("error", data.data.rd)
                    }
                });
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
            getDiemTruong() {
                let params = {
                    "maTruong": this.thongTinLopHoc.maTruongHoc,
                    "namHoc": this.thongTinLopHoc.namHoc,
                };
                this.fullScreenLoading = true;
                rest_api.get('/csdlgd-admin/diemTruongTheoNam/findData', params, data => {
                    this.fullScreenLoading = false;
                    let data_demo = data.data.rows;
                    for (let i = 0; i < data_demo.length; i++) {
                        let obj = {
                            name: data_demo[i].tenDiemTruong,
                            value: data_demo[i].maDiemTruong,
                        };
                        this.list_diem_truong.push(obj);
                    }
                    console.log("Điểm trường:");
                    console.log(JSON.stringify(this.list_diem_truong));
                });
            },
            reset() {},
            close() {
                this.$emit('close');
            },
        }
    }

</script>
<style scoped="scoped">
    .text-right label {
        padding: 6px 0;
    }

    .nav-tabs>li.active>a {
        font-weight: bold;
        color: forestgreen;
        border-top: 4px solid forestgreen;
    }

    .rct {
        margin: 20px -15px !important;
        display: flex;
    }

    .rct>.col-sm-12,
    .col-md-2,
    .col-md-4,
    .col-md-5 {
        align-self: center;
    }

    .cg {
        text-align: center;
    }

    .bt>a>b>i {
        color: #DC0101;
        border: 1px solid black;
        padding: 5px 6px;
        border-radius: 23%;
    }

</style>

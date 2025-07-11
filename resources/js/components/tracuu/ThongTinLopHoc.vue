<template>
    <div id="modal_import_file" ref="modal_import_file" class="modal fade" style="">
        <div class="modal-dialog-fullscreen" style="">
            <div class="modal-content-fullscreen">
                <div class="modal-header-fullscreen">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h5 class="modal-title text-uppercase">Thông tin lớp {{info.tenLopHoc}} <span
                            v-if="info.tenTruongHoc">- Trường {{info.tenTruongHoc}}</span></h5>
                </div>
                <div class="modal-body-fullscreen">
                    <div v-if="info.capHoc==4||info.capHoc==5" class="row" style="margin:25px 0 0 0;">
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Nhóm lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenKhoiHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Nhóm tuổi</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maNhomTuoiMn">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Tên lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenLopHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Mã lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Mã định danh</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.moetCode">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Điểm trường</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenDiemTruong">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Buổi học</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenBuoiHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Có trẻ khuyết tật</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopCoTreKhuyetTat" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Tên giáo viên chủ nhiệm</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenGvcn">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Nhóm trẻ ghép</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopGhep" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Ghép vào lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopGhep">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Bán trú</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopBanTru" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học bán trú</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.hocBanTru">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>C.trình giáo dục MN mới</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.ctrinhGdmnMoi" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>C.trình chăm sóc giáo dục</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.ctrinhCsocGduc" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="info.capHoc==1" style="margin:25px 0 0 0;" class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Khối</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenKhoiHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Tên lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenLopHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Mã lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Mã định danh</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.moetCode">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Số buổi học/tuần</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.soBuoiTrenTuan">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Số tiết học/tuần</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maTietHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Điểm trường</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenDiemTruong">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Lớp ghép</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopGhep" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Ghép vào lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopGhep">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Lớp VNEN</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopVnen" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Đủ TBDH - Tiếng Việt</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.thietBiDhocTviet" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Đủ TBDH - Toán</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.thietBiDhocToan" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Có Đ.diện cha, mẹ hs lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.daiDienChaMeLop" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Có Đ.diện cha, mẹ hs trường</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.daiDienChaMeTruong" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Tên giáo viên chủ nhiệm</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenGvcn">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học ngoại ngữ 1</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenNgoaiNgu1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Chương trình học (NN1)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maChuongTrinhHocNn1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Số tiết NN/tuần (NN1)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maSoTietNgoaiNgu1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học ngoại ngữ 2</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenNgoaiNgu2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Chương trình học (NN2)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maChuongTrinhHocNn2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Số tiết NN/tuần (NN2)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maSoTietNgoaiNgu2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Bán trú</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopBanTru" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học bán trú</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.hocBanTru">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Chuyên biệt</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopChuyenBiet" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Hình thức học tập</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maHthucDtaoHtap">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Đào tạo, bồi dưỡng</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopDtaoBduong">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Hướng nghiệp dạy nghề</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopHnghiepDayNghe">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="info.capHoc==2" style="margin:25px 0 0 0;" class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Khối</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenKhoiHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Tên lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenLopHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Mã lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Mã định danh</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.moetCode">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Số buổi học/tuần</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.soBuoiTrenTuan">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Điểm trường</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenDiemTruong">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Lớp ghép</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopGhep" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Ghép vào lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopGhep">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Lớp VNEN</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopVnen" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học sinh học nghề</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.coHocSinhHocNghe" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Lớp bổ túc THCS</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maKieuLop">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Tên giáo viên chủ nhiệm</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenGvcn">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học ngoại ngữ 1</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenNgoaiNgu1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Chương trình học (NN1)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maChuongTrinhHocNn1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Số tiết NN/tuần (NN1)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maSoTietNgoaiNgu1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học ngoại ngữ 2</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenNgoaiNgu2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Chương trình học (NN2)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maChuongTrinhHocNn2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Số tiết NN/tuần (NN2)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maSoTietNgoaiNgu2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Bán trú</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopBanTru" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học bán trú</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.hocBanTru">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Hình thức học tập</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maHthucDtaoHtap">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Đào tạo, bồi dưỡng</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopDtaoBduong">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Hướng nghiệp dạy nghề</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopHnghiepDayNghe">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="info.capHoc==3" style="margin:25px 0 0 0;" class="row">
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Khối</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenKhoiHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Tên lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenLopHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Mã lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopHoc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Mã định danh</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.moetCode">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Số buổi học/tuần</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.soBuoiTrenTuan">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Điểm trường</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenDiemTruong">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Lớp ghép</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopGhep" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Ghép vào lớp</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopGhep">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Lớp chuyên</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopChuyen" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Phân ban</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenPhanBan">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học sinh học nghề</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.coHocSinhHocNghe" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Lớp bổ túc THPT</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maKieuLop">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Tên giáo viên chủ nhiệm</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenGvcn">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học ngoại ngữ 1</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenNgoaiNgu1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Chương trình học (NN1)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maChuongTrinhHocNn1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Số tiết NN/tuần (NN1)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maSoTietNgoaiNgu1">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học ngoại ngữ 2</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.tenNgoaiNgu2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Chương trình học (NN2)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maChuongTrinhHocNn2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Số tiết NN/tuần (NN2)</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maSoTietNgoaiNgu2">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Bán trú</label>
                                </div>
                                <div class="col-md-7">
                                    <p><span>
                                            <i v-if="info.lopBanTru" style="color:blue;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Học bán trú</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.hocBanTru">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Hình thức học tập</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maHthucDtaoHtap">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Đào tạo, bồi dưỡng</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopDtaoBduong">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5 text-right">
                                    <label>Hướng nghiệp dạy nghề</label>
                                </div>
                                <div class="col-md-7">
                                    <input class="form-control" disabled :value="info.maLopHnghiepDayNghe">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-fullscreen clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import moment from 'moment'
    import utils from '../../utils'
    import api from '../api';
    $(document).ready(function () {
        console.log("ready!");
    });
    export default {
        props: [
            'item', 'show'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.reset();
                    $("#modal_import_file").modal();
                } else {
                    $("#modal_import_file").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                console.log("mã lớp");
                this.mlh = newVal;
                console.log(newVal);
                this.getDataClass();
            }
        },
        data() {
            return {
                mlh: "",
                info: {},
                linkPdf: ""
            }
        },
        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_import_file).on("hidden.bs.modal", this.close);
        },
        methods: {
            getDataClass() {
                let params = {
                    "id": this.mlh,
                };
                rest_api.get("/csdlgd-admin/lopHoc/findOne", params, (data) => {
                    if (data.data != null) {
                        this.info = data.data;
                        console.log(this.info);
                    } else {
                        utils.showDialog(
                            "Thông báo",
                            "Đã xảy ra lỗi trong quá trình lấy dữ liệu. Vui lòng thử lại.",
                            null,
                            () => {}
                        );
                    }
                });
            },
            reset() {
                this.capmot = "";
                this.ten_lydo = "";
            },
            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            }
        }
    }

</script>
<style scoped="scoped">
    input[disabled]{
        margin-bottom:6px;
    }
    label{
    padding-top: 4px;
    }
    i{
        padding-top: 3px;
    }
</style>

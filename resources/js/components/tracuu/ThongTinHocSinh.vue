<template>
    <div>
        <div id="modal_info_teacher" ref="modal_info_teacher" class="modal fade">
            <div class="modal-dialog modal-dialog-fullscreen" style="">
                <div class="modal-content modal-content-fullscreen" style="">
                    <div class="modal-header modal-header-fullscreen" style="">
                        <h4>Thông tin hồ sơ học sinh</h4>
                    </div>
                    <div class="modal-body modal-body-fullscreen" style="padding-bottom:200px;">
                        <div class="row" style="margin:0">
                            <div class="col-md-2">
                                <div class="thumbnail" style="text-align:center;">
                                    <div v-if="info.avatar">
                                        <img :src="info.avatar" width="100%" alt="hình ảnh học sinh" />
                                    </div>
                                    <div v-else>
                                        <img src="https://www.drupal.org/files/issues/default-avatar.png" width="120px"
                                            height="150px;" alt="" />
                                    </div>
                                    <div>
                                        <p style="color:blue;padding-left:15px;">Mã định danh:
                                            <span>{{info.moetCode}}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6" style="">
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Khối học  <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input disabled class="form-control"
                                                    :value="getTen2(info.khoiHoc,list_khoi_hoc)">
                                            </div>
                                        </div>
                                        <div class="row rct" v-if="info.capHoc==4||info.capHoc==5||info.capHoc==45">
                                            <div class="col-md-4 text-right">
                                                <label>Nhóm tuổi  <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input disabled class="form-control"
                                                    :value="getTen(info.maNhomTuoiMn,list_nhom_tuoi_mam_non)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Lớp học  <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input disabled class="form-control"
                                                    :value="getTen(info.maLopHocCn,list_lop_hoc)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Họ tên <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" disabled v-model="info.hoTen">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Ngày sinh <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <date-picker class="form-control" disabled style="min-width: 50px;"
                                                    v-model="info.ngaySinh" :config="configDate"
                                                    placeholder="Chọn ngày">
                                                </date-picker>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Giới tính <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" disabled v-model="info.gioiTinh">
                                                    <option value="">Chọn</option>
                                                    <option value="1">Nam</option>
                                                    <option value="0">Nữ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Trạng thái HS <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input disabled class="form-control"
                                                    :value="getTen(info.trangThai,list_tt_hs)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Dân tộc <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input disabled class="form-control"
                                                    :value="getTen(info.maDanToc,list_dantoc)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Tôn giáo</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input disabled class="form-control"
                                                    :value="getTen(info.maTonGiao,list_tongiao)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>SĐT liên hệ</label>
                                            </div>
                                            <div class="col-md-8"><input disabled class="form-control"
                                                    v-model="info.soDthoaiCdinh">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" disabled
                                                    v-model="info.email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="">
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Mã học sinh</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" disabled
                                                    v-model="info.maHocSinh">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Nhóm máu</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input disabled class="form-control"
                                                    :value="getTen(info.nhomMau,list_nhommau)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>T.phần gia đình</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input disabled class="form-control"
                                                    :value="getTen(info.tphanGdinh,list_tpgd)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Nơi sinh</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" disabled
                                                    v-model="info.noiSinh">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Thôn xóm</label>
                                            </div>
                                            <div class="col-md-8"><input disabled class="form-control"
                                                    v-model="info.maTthonTmtru">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                <label>Quê quán</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea rows="3" disabled class="form-control"
                                                    v-model="info.queQuan"></textarea>
                                            </div>
                                        </div>
                                        <div class="row" style="padding:8px 0 !important">
                                            <div class="col-md-4 text-right">
                                                <label>Chỗ ở hiện nay</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea rows="3" disabled class="form-control"
                                                    v-model="info.dchiTmtru"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                <label>Đ/C thường trú</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea rows="3" disabled class="form-control"
                                                    v-model="info.dchiThtru"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" style="margin:0">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#thong-tin-chinh-sua-ca-nhan-hoc-sinh"><b>I. Thông tin cá nhân</b></a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#thong-tin-chinh-sua-lien-he-hoc-sinh"><b>II. Thông tin liên hệ, gia đình</b></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="thong-tin-chinh-sua-ca-nhan-hoc-sinh" class="tab-pane fade in active"
                                        style="width:95%;padding-top:25px; margin:0 auto;">
                                        <div v-if="info.capHoc==45||info.capHoc==4||info.capHoc==5">
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khu vực</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maKhuVuc,list_kv)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>HS tuyển mới</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.tuyenMoiMn" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Có cha dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.chaDanToc" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.khuyetTat" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Trẻ lớp bán trú</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.lopBanTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Có mẹ dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.meDanToc" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Loại khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maLoaiKhuyetTat,list_lkt)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học 2 buổi</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.buoiHoc==4||info.buoiHoc==5||info.buoiHoc==6"
                                                        style="color:blue;" class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có Smartphone</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isPhCoSmartPhone" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng chính sách</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maDtuongCsach,list_dtcs)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ I</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isBietBoiKy1" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có M.tính Internet</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isPhCoMayTinhInternet" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng ưu tiên</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.dtuongUuTien,list_dtut)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ II</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isBietBoiKy2" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>    
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else-if="info.capHoc==1">
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khu vực</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maKhuVuc,list_kv)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Đội viên</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.doiVien" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>    
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh B.Trú D.Nuôi</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhBanTruDanNuoi" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>   
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.khuyetTat" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>   
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học tiếng D.Tộc</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhTiengDanToc" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh N.Trú D.Nuôi</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhNoiTruDanNuoi" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Loại khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maLoaiKhuyetTat,list_lkt)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học song ngữ</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSongNgu" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh bán trú</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhBanTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng chính sách</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maDtuongCsach,list_dtcs)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Loại nhập học </b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.loaiNhapHoc,list_loai_nhap_hoc)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh nội trú</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhNoiTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng ưu tiên</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.dtuongUuTien,list_dtut)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Số buổi học trên tuần</b></div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" disabled
                                                        :value="getTen(info.soBuoiTrenTuan,list_buoi_hoc_tren_tuan)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh PTDT bán trú</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhPtdtBanTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học CTGD của Bộ</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocCtgdCuaBo" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh lớp B.Trú</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.lopBanTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>

                                                </div>
                                                <div class="col-md-2 text-right"><b>Có mẹ dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.meDanToc" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đã học lớp MG 5 tuổi</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocLopMg5T" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học bán trú</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maHocBanTru,list_hoc_ban_tru)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Có cha dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.chaDanToc" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ I</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isBietBoiKy1" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>HSDT có nhu cầu HT NN</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.nhuCauHtroNngu" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có Smartphone</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isPhCoSmartPhone" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ II</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isBietBoiKy2" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>HSDT có TL T.Cường TV</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.tangCuongTviet" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có M.tính Internet</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isPhCoMayTinhInternet" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right">
                                                    <!-- <b>Bệnh về mắt</b> -->
                                                </div>
                                                <div class="col-md-2">
                                                    
                                                    <!-- <i v-if="info.benhVeMat" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i> -->
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh DT trợ giảng</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhDanTocTroGiang" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else-if="info.capHoc==2||info.capHoc==3">
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khu vực</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maKhuVuc,list_kv)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>CMTND/TCC</b></div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" disabled v-model="info.soCmnd" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh B.Trú D.Nuôi</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhBanTruDanNuoi" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.khuyetTat" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Ngày cấp</b></div>
                                                <div class="col-md-2">
                                                    <date-picker class="form-control" disabled style="min-width: 50px;"
                                                        v-model="info.ngayCapCmnd" :config="configDate"
                                                        placeholder="Chọn ngày">
                                                    </date-picker>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh N.Trú D.Nuôi</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhNoiTruDanNuoi" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>

                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Loại khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maLoaiKhuyetTat,list_lkt)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Nơi cấp</b></div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" disabled
                                                        v-model="info.noiCapCmnd" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh bán trú</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhBanTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khuyết tật không ĐG</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.khuyetTatKhongDanhGia" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Đội viên</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.doiVien" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh nội trú</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhNoiTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng chính sách</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maDtuongCsach,list_dtcs)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Đoàn viên</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.doanVien" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh PTDT bán trú</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhPtdtBanTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng ưu tiên</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.dtuongUuTien,list_dtut)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học tiếng D.Tộc</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSinhTiengDanToc" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Có mẹ dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.meDanToc" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học CTGD của Bộ</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocCtgdCuaBo" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học song ngữ</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.hocSongNgu" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Có cha dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.chaDanToc" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>H.nghiệp, D.nghề</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maLopHuongNghiepDayNghe,list_huong_nghiep)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>Loại nhập học</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.loaiNhapHoc,list_loai_nhap_hoc)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có Smartphone</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isPhCoSmartPhone" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ I</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isBietBoiKy1" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Số buổi học trên tuần</b></div>
                                                <div class="col-md-2">
                                                    <input type="text" disabled class="form-control"
                                                        :value="getTen(info.soBuoiTrenTuan,list_buoi_hoc_tren_tuan)">
                                                </div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có M.tính Internet</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isPhCoMayTinhInternet" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ II</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.isBietBoiKy2" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh lớp B.Trú</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.lopBanTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div v-if="info.capHoc==3" class="col-md-2 text-right">
                                                    <!-- <b>T.vấn giáo dục hướng nghiệp</b> -->
                                                </div>
                                                <div v-if="info.capHoc==3" class="col-md-2">
                                                    <!-- <i v-if="info.Huongnghiep" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i> -->
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right">
                                                    <!-- <b>Bệnh về mắt</b> -->
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- <i v-if="info.benhVeMat" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i> -->
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học bán trú</b></div>
                                                <div class="col-md-2">
                                                    <input disabled class="form-control"
                                                        :value="getTen(info.maHocBanTru,list_hoc_ban_tru)">
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
                                    </div>
                                    <div id="thong-tin-chinh-sua-lien-he-hoc-sinh" class="tab-pane fade"
                                        style="width:95%; padding-top:25px;margin:0 auto;">
                                        <div class="row rct" style="padding-top:15px">
                                            <div class="col-md-2 text-right"><b>Tên bố</b></div>
                                            <div class="col-md-2"><input class="form-control" disabled type="text"
                                                    v-model="info.hoTenBo"></div>
                                            <div class="col-md-2 text-right"><b>Tên mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" disabled type="text"
                                                    v-model="info.hoTenMe"></div>
                                            <div class="col-md-2 text-right"><b>Tên người Đ.đầu</b></div>
                                            <div class="col-md-2"><input class="form-control" disabled type="text"
                                                    v-model="info.hoTenNguoiGiamHo"></div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-2 text-right"><b>Nghề nghiệp bố</b></div>
                                            <div class="col-md-2"><input class="form-control" disabled type="text"
                                                    v-model="info.ngheNghiepBo"></div>
                                            <div class="col-md-2 text-right"><b>Nghề nghiệp mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" disabled type="text"
                                                    v-model="info.ngheNghiepMe"></div>
                                            <div class="col-md-2 text-right"><b>Nghề nghiệp người Đ.đầu</b></div>
                                            <div class="col-md-2"><input class="form-control" disabled type="text"
                                                    v-model="info.ngheNghiepNguoiGiamHo"></div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-2 text-right"><b>Năm sinh bố</b></div>
                                            <div class="col-md-2"><input class="form-control" disabled type="text"
                                                    v-model="info.ngaySinhBo"></div>
                                            <div class="col-md-2 text-right"><b>Năm sinh mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" disabled type="text"
                                                    v-model="info.ngaySinhMe"></div>
                                            <div class="col-md-2 text-right"><b>Năm sinh người Đ.đầu</b></div>
                                            <div class="col-md-2"><input class="form-control" disabled type="text"
                                                    v-model="info.ngaySinhNguoiGiamHo"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-fullscreen" style="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import moment, {
        parseTwoDigitYear
    } from 'moment'
    import utils from '../../utils'
    import constant from '../../utils/constant';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import timeutils from "../../utils/time_utils";
    import api from '../api';
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
            'item'
        ],
        watch: {},
        data() {
            return {
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
                }, ],
                list_dantoc: JSON.parse(localStorage["danh_sach_dan_toc_sme"]),
                list_tongiao: JSON.parse(localStorage["danh_sach_ton_giao_sme"]),
                list_nhommau: JSON.parse(localStorage["danh_sach_nhom_mau_sme"]),
                list_dtcs: JSON.parse(localStorage["danh_sach_doi_tuong_chinh_sach_sme"]),
                list_dtut: JSON.parse(localStorage["danh_sach_doi_tuong_uu_tien_sme"]),
                list_kv: JSON.parse(localStorage["danh_sach_khu_vuc_sme"]),
                list_lkt: JSON.parse(localStorage["danh_sach_loai_khuyet_tat_sme"]),
                list_loai_nhap_hoc: JSON.parse(localStorage["danh_sach_loai_nhap_hoc_sme"]),
                list_buoi_hoc_tren_tuan: JSON.parse(localStorage["danh_sach_so_buoi_hoc_tren_tuan_sme"]),
                list_hoc_ban_tru: JSON.parse(localStorage["danh_sach_hoc_ban_tru_sme"]),
                list_huong_nghiep: JSON.parse(localStorage["danh_sach_huong_nghiep_sme"]),
                list_tpgd: JSON.parse(localStorage["danh_sach_thanh_phan_gia_dinh_sme"]),
                list_nhom_tuoi_mam_non: JSON.parse(localStorage["danh_sach_nhom_tuoi_mam_non_sme"]),
                list_khoi_hoc: constant.list_khoi_hoc,
                khoi_mot: constant.khoiCapMot,
                khoi_hai: constant.khoiCapHai,
                khoi_ba: constant.khoiCapBa,
                khoi_mam_non: constant.khoi_mam_non_hai_cap,
                list_lop_hoc: [{name:"chọn",value:""}],
            }
        },
        mounted: function () {
            console.log("mount");
            console.log(JSON.stringify(this.item));
            $("#modal_info_teacher").modal();
            this.getDataStudent();
            $(this.$refs.modal_info_teacher).on("hidden.bs.modal", this.close);
        },
        components: {
            datePicker
        },
        methods: {
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
                rest_api.get('/csdlgd-admin/lopHoc/findGroupMaLopHoc', params, data => {
                    let data_demo = data.data.tableData;
                    for(let i=0;i<data_demo.length;i++){
                        let obj = {
                            name:data_demo[i].tenLopHoc,
                            value:data_demo[i].maLopHoc,
                        };
                        this.list_lop_hoc.push(obj);
                    }

                });
            },
            getDataStudent() {
                let params = {
                    "idHsTheoNam": this.item,
                };
                rest_api.get("/csdlgd-admin/hocSinh/infor", params, (data) => {
                    console.log("Data trả về:");
                    console.log(JSON.stringify(data.data));
                    if (data.data != null) {
                        this.info = data.data;
                        let capHocHs = this.info.capHoc;
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
        margin: 5px -15px !important;
        display: flex;
    }

    .rct>.col-md-7,
    .col-md-1,
    .col-md-2,
    .col-md-3,
    .col-md-8,
    /* .col-md-6, */
    .col-md-9,
    .col-md-10,
    .col-md-11,
    .col-md-12,
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

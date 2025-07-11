<template>
    <div>
        <div id="modal_update_info_student" ref="modal_update_info_student" class="modal fade">
            <div class="modal-dialog modal-dialog-fullscreen" style="">
                <div class="modal-content modal-content-fullscreen" style="">
                    <div class="modal-header modal-header-fullscreen" style="">
                        <h4>CHỈNH SỬA THÔNG TIN HỒ SƠ HỌC SINH</h4>
                    </div>
                    <div class="modal-body modal-body-fullscreen" style="padding-bottom:200px;">
                        <div class="row" style="margin:0" ref="scrollToMe">
                            <div class="col-md-2">
                                <div class="thumbnail" style="text-align:center;">
                                    <div v-if="info.avatar">
                                        <img :src="info.avatar" width="100%" alt="hình ảnh học sinh" />
                                    </div>
                                    <div v-else>
                                        <img src="https://www.drupal.org/files/issues/default-avatar.png" width="120px"
                                            height="150px;" alt="" />
                                    </div>
                                </div>
                                <div>
                                    <p style="color:blue;padding-left:15px;">Mã học sinh CSDL:
                                        <span><b>{{ info.maHocSinh }}</b></span></p>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6" style="">
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Khối học <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <el-select v-model="info.khoiHoc" @change="chonKhoiHoc()" filterable
                                                    collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_khoi_hoc" :key="item.value"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row rct" v-if="info.capHoc==4||info.capHoc==5||info.capHoc==45">
                                            <div class="col-md-4 text-right">
                                                <label>Nhóm tuổi <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!-- <el-select v-model="info.maNhomTuoiMn" @change="chonKhoiHoc()"
                                                    filterable collapse-tags placeholder="Chọn"
                                                    no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_nhom_tuoi_mam_non" :key="item.id"
                                                        :label="item.name" :value="item.id">
                                                    </el-option>
                                                </el-select> -->
                                                <input :disabled="false" class="form-control"
                                                    :value="getTen(info.maNhomTuoiMn,list_nhom_tuoi_mam_non)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Lớp học <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input :disabled="false" class="form-control"
                                                    :value="getTen(info.maLopHocCn,list_lop_hoc)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Họ tên <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" :disabled="false" v-model="info.hoTen">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Ngày sinh <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <date-picker class="form-control" :disabled="false"
                                                    style="min-width: 50px;" v-model="info.ngaySinh" :lang="lang"
                                                    placeholder="Chọn ngày">
                                                </date-picker>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Giới tính <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" :disabled="false" v-model="info.gioiTinh">
                                                    <option value="">Chọn</option>
                                                    <option value="1">Nam</option>
                                                    <option value="0">Nữ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Trạng thái học sinh <span style="color:#DC0101"> *
                                                    </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input :disabled="false" class="form-control"
                                                    :value="getTen(info.trangThai,list_tt_hs)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Tôn giáo</label>
                                            </div>
                                            <div class="col-md-8">
                                                <!-- <input :disabled="false" class="form-control"
                                                    :value="getTen(info.maTonGiao,list_tongiao)">
                                                     -->
                                                <el-select v-model="info.maTonGiao" filterable collapse-tags
                                                    placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_tongiao" :key="i"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Dân tộc <span style="color:#DC0101"> * </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input :disabled="false" class="form-control"
                                                    :value="getTen(info.maDanToc,list_dantoc)">

                                                <el-select v-model="info.maDanToc" filterable collapse-tags
                                                    @change="chonDanToc()" placeholder="Chọn"
                                                    no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_dantoc" :key="i"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Dân tộc trên giấy khai sinh<span style="color:#DC0101"> *
                                                    </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input :disabled="false" class="form-control"
                                                    :value="getTen(info.danTocTheoGiayKhaiSinh,list_dantoc)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Mã định danh công dân</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" :disabled="false"
                                                    v-model="info.citizenId">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Mã định danh bộ GD&ĐT</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" :disabled="false"
                                                    v-model="info.moetCode">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Ngày vào trường</label>
                                            </div>
                                            <div class="col-md-8">
                                                <date-picker class="form-control" :disabled="false"
                                                    style="min-width: 50px;" v-model="info.ngayVaoTruong" :lang="lang"
                                                    placeholder="Chọn ngày">
                                                </date-picker>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Trạng thái học sinh <span style="color:#DC0101"> *
                                                    </span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input :disabled="false" class="form-control"
                                                    :value="getTen(info.trangThai,list_tt_hs)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Ngày trạng thái <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <date-picker class="form-control" :disabled="false"
                                                    style="min-width: 50px;" v-model="info.ngayTrangThai" :lang="lang"
                                                    placeholder="Chọn ngày">
                                                </date-picker>
                                            </div>
                                        </div>
                                        <div class="row rct" v-if="info.trangThai==4">
                                            <div class="col-md-4 text-right">
                                                <label>Lý do bỏ học <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input :disabled="false" class="form-control"
                                                    :value="getTen(info.maLyDoThoiHoc,list_ly_do_thoi_hoc)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Thời điểm chuyển trường/bỏ học của học sinh</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input :disabled="false" class="form-control"
                                                    :value="info.thoiDiemRoiTruong">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="">
                                        <h5 class="tieuDeThongTin"><b>Thông tin hộ khẩu, quê quán</b></h5>
                                        <!--                                        <div class="row">-->
                                        <!--                                            <div class="col-md-4 text-right">-->
                                        <!--                                                <label>Hộ khẩu thường trú</label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-8">-->
                                        <!--                                                <div class="row">-->
                                        <!--                                                    <div class="col-md-6 pt-2">-->
                                        <!--                                                        <input :disabled="false" placeholder="Tỉnh thành" class="form-control">-->
                                        <!--                                                    </div>-->
                                        <!--                                                    <div class="col-md-6 pt-2">-->
                                        <!--                                                        <input :disabled="false" placeholder="Quận huyện" class="form-control">-->
                                        <!--                                                    </div>-->
                                        <!--                                                    <div class="col-md-6 pt-2">-->
                                        <!--                                                        <input :disabled="false" placeholder="Phường Xã" class="form-control">-->
                                        <!--                                                    </div>-->
                                        <!--                                                    <div class="col-md-6 pt-2">-->
                                        <!--                                                        <input :disabled="false" placeholder="Tổ thôn" class="form-control">-->
                                        <!--                                                    </div>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <div class="row" style="padding:8px 0 !important">
                                            <div class="col-md-4 text-right">
                                                <label>Quê quán</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea rows="3" :disabled="false" class="form-control"
                                                    v-model="info.queQuan"></textarea>
                                            </div>
                                        </div>

                                        <div class="row" style="padding:8px 0 !important">
                                            <div class="col-md-4 text-right">
                                                <label>Địa chỉ thường trú</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea rows="3" :disabled="false" class="form-control"
                                                    v-model="info.dchiThtru"></textarea>
                                            </div>
                                        </div>
                                        <!--                                        <div class="row rct">-->
                                        <!--                                            <div class="col-md-4 text-right">-->
                                        <!--                                                <label>Thôn xóm</label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-8"><input placeholder="Thôn xóm" :disabled="false" class="form-control"-->
                                        <!--                                                                         v-model="info.maTthonTmtru">-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <!--                                        <div class="row">-->
                                        <!--                                            <div class="col-md-4 text-right">-->
                                        <!--                                                <label>Quê quán</label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-8">-->
                                        <!--                                                <textarea rows="3" placeholder="Quê quán" :disabled="false" class="form-control"-->
                                        <!--                                                          v-model="info.queQuan"></textarea>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                        <h5 class="tieuDeThongTin"><b>Thông tin khác</b></h5>

                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Nơi sinh</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" :disabled="false"
                                                    v-model="info.noiSinh">
                                            </div>
                                        </div>
                                        <div class="row" style="padding:8px 0 !important">
                                            <div class="col-md-4 text-right">
                                                <label>Chỗ ở hiện nay</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea rows="3" :disabled="false" class="form-control"
                                                    v-model="info.dchiTmtru"></textarea>
                                            </div>
                                        </div>

                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Nhóm máu</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input :disabled="false" class="form-control"
                                                    :value="getTen(info.nhomMau,list_nhommau)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Thành phần gia đình</label>
                                            </div>
                                            <div class="col-md-8">
                                                <input :disabled="false" class="form-control"
                                                    :value="getTen(info.tphanGdinh,list_tpgd)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Số điện thoại liên hệ</label>
                                            </div>
                                            <div class="col-md-8"><input :disabled="false" class="form-control"
                                                    v-model="info.soDthoaiDdong">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" :disabled="false"
                                                    v-model="info.email">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Sổ đăng bộ</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" :disabled="false"
                                                    v-model="info.soDangBo">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Thứ tự</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" :disabled="false"
                                                    v-model="info.thuTu">
                                            </div>
                                        </div>
                                        <!--                                        <div class="row">-->
                                        <!--                                            <div class="col-md-4 text-right">-->
                                        <!--                                                <label>Địa chỉ thường trú</label>-->
                                        <!--                                            </div>-->
                                        <!--                                            <div class="col-md-8">-->
                                        <!--                                                <textarea rows="3" :disabled="false" class="form-control"-->
                                        <!--                                                          v-model="info.dchiThtru"></textarea>-->
                                        <!--                                            </div>-->
                                        <!--                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" style="margin:0">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#thong-tin-chinh-sua-ca-nhan-hoc-sinh-update"><b>I.
                                                Thông
                                                tin cá nhân</b></a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#thong-tin-chinh-sua-lien-he-hoc-sinh-update"><b>II.
                                                Thông
                                                tin liên hệ, gia đình</b></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="thong-tin-chinh-sua-ca-nhan-hoc-sinh-update"
                                        class="tab-pane fade in active"
                                        style="width:95%;padding-top:25px; margin:0 auto;">
                                        <div v-if="info.capHoc==45||info.capHoc==4||info.capHoc==5">
                                            <div class="row blockInfo">
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Khu vực</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maKhuVuc,list_kv)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Khuyết tật</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.khuyetTat" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Loại khuyết tật</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maLoaiKhuyetTat,list_lkt)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Đối tượng chính sách</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maDtuongCsach,list_dtcs)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Đối tượng ưu tiên</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.dtuongUuTien,list_dtut)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Hỗ trợ chi phí học tập</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.htChiPhiHocTap" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-6 text-right"><b>Cấp tiền hàng tháng</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.capTienHangThang" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Hỗ trợ nhà ở</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.htroNhaO" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right">
                                                            <b>Bệnh về mắt</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.benhMat" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh biết bơi kỳ I</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isBietBoiKy1" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh biết bơi kỳ II</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isBietBoiKy2" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Có cha dân tộc</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.chaDanToc" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Có mẹ dân tộc</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.meDanToc" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Phụ huynh có Smartphone</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isPhCoSmartPhone" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Phụ huynh có Máy tính
                                                                Internet</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isPhCoMayTinhInternet" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Số hộ chiếu</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.soHoChieu" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Ngày cấp hộ chiếu</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.ngayCapHoChieu" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Nơi cấp hộ chiếu</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.noiCapHoChieu" />
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="col-md-4">


                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học 2 buổi</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.buoiHoc==4||info.buoiHoc==5||info.buoiHoc==6"
                                                                style="color:blue;" class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>HS tuyển mới</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.tuyenMoiMn" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Loại nhập học </b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.loaiNhapHoc,list_loai_nhap_hoc)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Trẻ lớp bán trú</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.lopBanTru" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div v-else-if="info.capHoc==1">
                                            <div class="row">
                                                <div class="col-md-4 blockInfo">
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Khu vực</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maKhuVuc,list_kv)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Khuyết tật</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.khuyetTat" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Loại khuyết tật</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maLoaiKhuyetTat,list_lkt)">
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Đối tượng chính sách</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maDtuongCsach,list_dtcs)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Đối tượng ưu tiên</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.dtuongUuTien,list_dtut)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Hỗ trợ nhà ở</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isHoTroNhaO" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right">
                                                            <b>Bệnh về mắt</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.benhVeMat" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Hỗ trợ chi phí học tập</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isHoTroChiPhiHocTap" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Cấp tiền hàng tháng</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isCapTienHangThang" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh biết bơi kỳ I</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isBietBoiKy1" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh biết bơi kỳ II</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isBietBoiKy2" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 blockInfo">
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Số hộ chiếu</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.soHoChieu" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Ngày cấp hộ chiếu</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.ngayCapHoChieu" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Nơi cấp hộ chiếu</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.noiCapHoChieu" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Phụ huynh có Smartphone</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isPhCoSmartPhone" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Phụ huynh có Máy tính
                                                                Internet</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isPhCoMayTinhInternet" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Có cha dân tộc</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.chaDanToc" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Có mẹ dân tộc</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.meDanToc" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 blockInfo">
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Loại nhập học </b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.loaiNhapHoc,list_loai_nhap_hoc)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Số buổi học trên tuần</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                :value="getTen(info.soBuoiTrenTuan,list_buoi_hoc_tren_tuan)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học bán trú</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maHocBanTru,list_hoc_ban_tru)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh bán trú</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhBanTru" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh lớp bán trú</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.lopBanTru" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh bán trú dân
                                                                nuôi</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhBanTruDanNuoi" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh phổ thông dân tộc
                                                                bán
                                                                trú</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhPtdtBanTru" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh nội trú</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhNoiTru" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh nội trú dân
                                                                nuôi</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhNoiTruDanNuoi" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Đội viên</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.doiVien" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Đã học lớp mẫu giáo 5
                                                                tuổi</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocLopMg5T" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học chương trình giáo dục
                                                                của Bộ</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocCtgdCuaBo" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học tiếng dân tộc</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhTiengDanToc" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Tăng cường tiếng Việt</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.tangCuongTviet" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học song ngữ</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSongNgu" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh nhu cầu hỗ trợ
                                                                ngoại
                                                                ngữ</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.nhuCauHtroNngu" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh dân tộc trợ
                                                                giảng</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhDanTocTroGiang" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div v-else-if="info.capHoc==2||info.capHoc==3">
                                            <div class="row">
                                                <div class="col-md-4 blockInfo">
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Khu vực</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maKhuVuc,list_kv)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Khuyết tật</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.khuyetTat" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Loại khuyết tật</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maLoaiKhuyetTat,list_lkt)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Khuyết tật không đánh
                                                                giá</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.khuyetTatKhongDanhGia" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Đối tượng chính sách</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maDtuongCsach,list_dtcs)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Đối tượng ưu tiên</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.dtuongUuTien,list_dtut)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Hỗ trợ nhà ở</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isHoTroNhaO" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Hỗ trợ chi phí học tập</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isHoTroChiPhiHocTap" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Cấp tiền hàng tháng</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isCapTienHangThang" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right">
                                                            <b>Bệnh về mắt</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.benhVeMat" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh biết bơi kỳ I</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isBietBoiKy1" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh biết bơi kỳ II</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isBietBoiKy2" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 blockInfo">
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>CMTND/TCC</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.soCmnd" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Ngày cấp</b></div>
                                                        <div class="col-md-6">
                                                            <date-picker class="form-control" :disabled="false"
                                                                style="min-width: 50px;" v-model="info.ngayCapCmnd"
                                                                :lang="lang" placeholder="Chọn ngày">
                                                            </date-picker>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Nơi cấp</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.noiCapCmnd" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Số hộ chiếu</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.soHoChieu" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Ngày cấp hộ chiếu</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.ngayCapHoChieu" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Nơi cấp hộ chiếu</b></div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control" :disabled="false"
                                                                v-model="info.noiCapHoChieu" />
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Có cha dân tộc</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.chaDanToc" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Có mẹ dân tộc</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.meDanToc" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Phụ huynh có Smartphone</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isPhCoSmartPhone" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Phụ huynh có Máy tính
                                                                Internet</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.isPhCoMayTinhInternet" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 blockInfo">
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Loại nhập học</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.loaiNhapHoc,list_loai_nhap_hoc)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Số buổi học trên tuần</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" :disabled="false" class="form-control"
                                                                :value="getTen(info.soBuoiTrenTuan,list_buoi_hoc_tren_tuan)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Đội viên</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.doiVien" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Đoàn viên</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.doanVien" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh bán trú</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhBanTru" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh lớp bán trú</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.lopBanTru" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học bán trú</b></div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maHocBanTru,list_hoc_ban_tru)">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh bán trú dân
                                                                nuôi</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhBanTruDanNuoi" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh phổ thông dân tộc
                                                                bán
                                                                trú</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhPtdtBanTru" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh nội trú</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhNoiTru" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học sinh nội trú dân
                                                                nuôi</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhNoiTruDanNuoi" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học song ngữ</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSongNgu" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học tiếng dân tộc</b></div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocSinhTiengDanToc" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Học chương trình giáo dục
                                                                của
                                                                Bộ</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <i v-if="info.hocCtgdCuaBo" style="color:blue;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 text-right"><b>Hướng nghiệp, dạy nghề</b>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input :disabled="false" class="form-control"
                                                                :value="getTen(info.maLopHuongNghiepDayNghe,list_huong_nghiep)">
                                                        </div>
                                                    </div>
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
                                    <div id="thong-tin-chinh-sua-lien-he-hoc-sinh-update" class="tab-pane fade"
                                        style="width:95%; padding-top:25px;margin:0 auto;">
                                        <div class="row rct" style="padding-top:15px">
                                            <div class="col-md-2 text-right"><b>Họ tên bố</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.hoTenBo"></div>
                                            <div class="col-md-2 text-right"><b>Họ tên mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.hoTenMe"></div>
                                            <div class="col-md-2 text-right"><b>Họ tên người giám hộ</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.hoTenNguoiGiamHo"></div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-2 text-right"><b>Nghề nghiệp bố</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.ngheNghiepBo"></div>
                                            <div class="col-md-2 text-right"><b>Nghề nghiệp mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.ngheNghiepMe"></div>
                                            <div class="col-md-2 text-right"><b>Nghề nghiệp người giám hộ</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.ngheNghiepNguoiGiamHo"></div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-2 text-right"><b>Năm sinh bố</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.ngaySinhBo"></div>
                                            <div class="col-md-2 text-right"><b>Năm sinh mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.ngaySinhMe"></div>
                                            <div class="col-md-2 text-right"><b>Năm sinh người giám hộ</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.ngaySinhNguoiGiamHo"></div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-2 text-right"><b>Nơi làm việc bố</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.noiLamViecBo"></div>
                                            <div class="col-md-2 text-right"><b>Nơi làm việc mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.noiLamViecMe"></div>
                                            <div class="col-md-2 text-right"><b>Nơi làm việc người giám hộ</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.noiLamViecNguoiGiamHo"></div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-2 text-right"><b>Số điện thoại bố</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.soDienThoaiBo"></div>
                                            <div class="col-md-2 text-right"><b>Số điện thoại mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.soDienThoaiMe"></div>
                                            <div class="col-md-2 text-right"><b>Số điện thoại người giám hộ</b>
                                            </div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.dienThoaiNguoiGiamHo">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-2 text-right"><b>Số CCCD/CMND/ĐDCN bố</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.soCmndCha"></div>
                                            <div class="col-md-2 text-right"><b>Số CCCD/CMND/ĐDCN mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.soCmndMe"></div>
                                            <div class="col-md-2 text-right"><b>Số CCCD/CMND/ĐDCN người giám hộ</b>
                                            </div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.soCmndNguoiGiamHo"></div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-2 text-right"><b>Bố là người dân tộc</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.soCmndCha"></div>
                                            <div class="col-md-2 text-right"><b>Mẹ là người dân tộc</b></div>
                                            <div class="col-md-2"><input class="form-control" :disabled="false"
                                                    type="text" v-model="info.soCmndMe"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-fullscreen" style="">
                        <el-button class="dts-button-close" size="mini" data-dismiss="modal">Đóng
                        </el-button>
                        <el-button type="warning" size="mini" @click.prevent="update()">Chỉnh sửa</el-button>
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
    import utils from '../../../utils'
    import constant from '../../../utils/constant';
    import datePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/vi';
    import rest_api from '../../../utils/rest_api';
    import array_util from '../../../utils/array_utils';
    import timeutils from "../../../utils/time_utils";
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
                    this.getDataStudent();
                    $("#modal_update_info_student").modal();
                } else {
                    $("#modal_update_info_student").modal('hide');
                }
            },
        },
        data() {
            return {

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
                list_dantoc: [],
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
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            console.log("mount thông tin học sinh");
            console.log(JSON.stringify(this.item));
            // $("#modal_update_info_student").modal();
            $(this.$refs.modal_update_info_student).on("hidden.bs.modal", this.close);
        },
        components: {
            datePicker
        },
        methods: {

            update() {
                if (this.info.capHoc == 4 || this.info.capHoc == 5) {
                    if (!this.info.maNhomTuoiMn) {
                        this.$alertify.error("Thiếu nhóm tuổi");
                        return;
                    }
                }
                if (!this.info.hoTenNguoiGiamHo && !this.info.hoTenMe) {
                    this.$alertify.error("Bổ sung họ tên mẹ hoặc người đỡ đầu");
                    return;
                }
                if (!this.info.khoiHoc) {
                    this.$alertify.error("Thiếu khối học");
                    return;
                }
                if (!this.info.maLopHocCn) {
                    this.$alertify.error("Thiếu lớp học");
                    return;
                }
                if (!this.info.hoTen) {
                    this.$alertify.error("Thiếu Họ tên học sinh");
                    return;
                }
                if (this.info.gioiTinh != "0" && this.info.gioiTinh != "1") {
                    this.$alertify.error("Thiếu Giới tính");
                    return;
                }
                if (!this.info.ngaySinh) {
                    this.$alertify.error("Thiếu ngày sinh");
                    return;
                }
                if (!this.info.trangThai) {
                    this.$alertify.error("Thiếu trạng thái học sinh");
                    return;
                }
                if (this.info.trangThai == 4) {
                    if (!this.info.maLyDoThoiHoc) {
                        this.$alertify.error("Thiếu lý do bỏ học");
                        return;
                    }
                }
                if (!this.info.ngayTrangThai) {
                    this.$alertify.error("Thiếu ngày trạng thái học sinh");
                    return;
                }
                if (!this.info.maDanToc) {
                    this.$alertify.error("Thiếu dân tộc");
                    return;
                }
                if (this.info.capHoc == 3 || this.info.capHoc == 2) {

                    if (this.info.soCmnd != null && this.info.soCmnd != "") {
                        if (this.info.soCmnd.length != 12 && this.info.soCmnd.length != 9) {
                            this.$alertify.error("CMTND/TCC gồm 9 hoặc 12 số");
                            return;
                        }
                    }
                }
                if (this.info.khuyetTat) {
                    this.info.khuyetTat = 1
                } else {
                    this.info.khuyetTat = 0
                }
                if (this.info.doiVien) {
                    this.info.doiVien = 1
                } else {
                    this.info.doiVien = 0
                }
                if (this.info.doanVien) {
                    this.info.doanVien = 1
                } else {
                    this.info.doanVien = 0
                }
                if (this.info.khuyetTat) {
                    this.info.khuyetTat = 1
                } else {
                    this.info.khuyetTat = 0
                }

                let params = {
                    updateHocSinhRequest: this.info,
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/hocSinh/update", params, data => {
                    loading.close();
                    if (data.data.rc == 0) {
                        this.thongBao('success', data.data.rd);
                        let dt = this.info.maHocSinh;
                        console.log('DataFill:')
                        console.log(this.dataFill)
                        this.dataFill.maHocSinh = this.info.maHocSinh;
                        this.$emit('success', this.dataFill);
                    } else {
                        utils.showDialog("Thất bại", data.data.rd, null, () => {});
                        this.thongBao('error', data.data.rd);
                    }
                });
                // this.$confirm('Xác nhận chỉnh sửa dữ liệu?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {
                //     })
                //     .catch(_ => {});
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
            chonKhoiHoc() {
                let result = this.list_khoi_hoc.filter(obj => {
                    return obj.id === this.info.khoiHoc;
                })
                this.dataFill.khoiHoc = result.length ? result[0].name : ''
                console.log('result:')
                console.log(this.dataFill.khoiHoc)
                this.info.maNhomTuoiMn = "";
                this.info.maLopHocCn = "";
                this.list_lop_hoc = [{
                    name: "chọn",
                    value: ""
                }];
                this.getDanhSachLop();
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
                        this.info = data.data;
                        loading.close();
                        this.scrollToElement();
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
                        loading.close();
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

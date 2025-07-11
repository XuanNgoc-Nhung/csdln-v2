<template>
    <div>
        <div id="modal_info_teacher" ref="modal_info_teacher" class="modal fade">
            <div class="modal-dialog modal-dialog-fullscreen" style="">
                <div class="modal-content modal-content-fullscreen" style="">
                    <div class="modal-header modal-header-fullscreen" style="">
                        <h4>CHI TIẾT HỒ SƠ CÁN BỘ</h4>
                    </div>
                    <div class="modal-body modal-body-fullscreen" style="padding-bottom:200px;">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="thumbnail" style="text-align:center; width:80%">
                                    <div v-if="thongtin_giaovien.avatar">
                                        <img :src="thongtin_giaovien.avatar" width="100%" alt="hình ảnh học sinh" />
                                    </div>
                                    <div v-else>
                                        <img src="https://www.drupal.org/files/issues/default-avatar.png" width="120px"
                                            height="150px;" alt="" />
                                    </div>
                                    <div>
                                        <p style="color:blue">Mã định danh: <span>{{thongtin_giaovien.moetCode}}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="row rct">
                                    <div class="col-md-2 text-right">
                                        <label>Họ tên <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" disabled v-model="thongtin_giaovien.tenGiaoVien">
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <label>Mã cán bộ</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input class="form-control" disabled v-model="thongtin_giaovien.maGiaoVien">
                                    </div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right">
                                        <label>Ngày sinh <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <date-picker class="form-control" disabled style="min-width: 50px;"
                                            v-model="thongtin_giaovien.ngaySinh" :config="configDate"
                                            placeholder="Chọn ngày">
                                        </date-picker>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <label>Dân tộc</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input disabled class="form-control"
                                            :value="getTen(thongtin_giaovien.maDanToc,list_dantoc)">
                                    </div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right">
                                        <label>Giới tính <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" disabled v-model="thongtin_giaovien.gioiTinh">
                                            <option value="">Chọn</option>
                                            <option value="1">Nam</option>
                                            <option value="0">Nữ</option>
                                        </select>
                                        <!-- <input class="form-control"
                                        :value="parseInt(thongtin_giaovien.gioiTinh)=== 1 ? 'Nam' : 'Nữ'"> -->
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <label>Tôn giáo</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input disabled class="form-control"
                                            :value="getTen(thongtin_giaovien.maTonGiao,list_ton_giao)">
                                    </div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right">
                                        <label>Trạng thái CB <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input disabled class="form-control"
                                            :value="getTen(thongtin_giaovien.trangThai,list_trang_thai_can_bo)">
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <label>Nơi sinh</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input disabled class="form-control" v-model="thongtin_giaovien.noiSinh">
                                    </div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right">
                                        <label>CMTND/TCC <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-md-4">
                                        <input disabled class="form-control" v-model="thongtin_giaovien.soCmnd">
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <label>Quê quán</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input disabled class="form-control" v-model="thongtin_giaovien.queQuan">
                                    </div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right">
                                        <label>Ngày cấp CMTND/TCC</label>
                                    </div>
                                    <div class="col-md-4">
                                        <!-- <input class="form-control" :value="thongtin_giaovien.ngayCapCmnd"> -->
                                        <date-picker disabled class="form-control" style="min-width: 50px;"
                                            v-model="thongtin_giaovien.ngayCapCmnd" :config="configDate"
                                            placeholder="Chọn ngày">
                                        </date-picker>
                                    </div>
                                    <div class="col-md-2 text-right">
                                        <label>Số sổ BHXH</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input disabled class="form-control" v-model="thongtin_giaovien.soSoBhxh">
                                    </div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right">
                                        <label>Email</label>
                                    </div>
                                    <div class="col-md-4">
                                        <input disabled class="form-control" v-model="thongtin_giaovien.email">
                                    </div>
                                    <div class="col-md-2"></div>
                                    <div class="col-md-2">
                                        <label>Đoàn viên</label>
                                        <span style="padding-left:15px;">
                                            <i v-if="thongtin_giaovien.doanVien" style="color:blue;"
                                                class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i>
                                        </span>
                                    </div>
                                    <div class="col-md-2">
                                        <label>Đảng viên</label>
                                        <span style="padding-left:15px;">
                                            <i v-if="thongtin_giaovien.dangVien" style="color:blue;"
                                                class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" href="#home"><b>I. Vị trí việc làm</b></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#menu1"><b>II. Phụ cấp</b></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#menu2"><b>III. Đào tạo, bồi dưỡng</b></a>
                            </li>
                            <li>
                                <a data-toggle="tab" href="#menu3"><b>IV. Đánh giá, phân loại</b></a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div id="home" class="tab-pane fade in active">
                                <div class="row" style="width:94%; margin:25px auto;">
                                    <div class="col-md-4">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Vị trí việc làm <span style="color:#DC0101">*</span></b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.loaiCanBo,list_loai_can_bo)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Môn dạy</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maMonHoc,list_mon_day)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Môn dạy kiêm nhiệm</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.monDayKiemNhiem,list_mon_day)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Nhóm chức vụ</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.chucVu,list_chuc_vu)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Hình thức hợp đồng</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.loaiHopDong,list_hinh_thuc_hop_dong)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Ngày tuyển</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <date-picker disabled class="form-control" style="min-width: 50px;"
                                                    v-model="thongtin_giaovien.ngayTuyenDung" :config="configDate"
                                                    placeholder="Chọn ngày">
                                                </date-picker>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Cơ quan tuyển dụng</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" disabled class="form-control"
                                                    v-model="thongtin_giaovien.coQuanTuyenDung" />
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Nghề nghiệp khi được tuyển dụng</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" disabled class="form-control"
                                                    v-model="thongtin_giaovien.ngheNghiepTuyenDung" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Nhiệm vụ kiêm nhiệm</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.nhiemVuKiemNhiem,list_nhiem_vu_kiem_nhiem)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Số tiết thực dạy trên tuần</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled type="text" class="form-control"
                                                    v-model="thongtin_giaovien.soTietThucDay1Tuan" />
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Số tiết thực kiêm nhiệm/tuần</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled type="text" class="form-control"
                                                    v-model="thongtin_giaovien.soTietKiemNhiem1Tuan" />
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b style=" ">Đã tập huấn dạy KN sống (HIV,
                                                        SKSS...)</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <i v-if="thongtin_giaovien.tapHuanKnsSkss" style="color:blue;"
                                                    class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b style=" ">Dạy học sinh khuyết tật hòa nhập</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <i v-if="thongtin_giaovien.dayHsktHocHoaNhap" style="color:blue;"
                                                    class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b style=" ">Đang dạy 1 buổi/ngày</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <i v-if="thongtin_giaovien.day1BuoiTrenNgay" style="color:blue;"
                                                    class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b style=" ">Đang dạy 2 buổi/ngày</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <i v-if="thongtin_giaovien.day2BuoiTrenNgay" style="color:blue;"
                                                    class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b style=" ">Tham gia chương trình bồi dưỡng thường xuyên</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <i v-if="thongtin_giaovien.thamGiaBdTxuyen" style="color:blue;"
                                                    class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Ngạch/Hạng</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maNgach,list_ma_ngach_hang)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b style=" ">Có CC bồi dưỡng TCCD</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <i v-if="thongtin_giaovien.coCcBdChucDanhNgheNghiep" style="color:blue;"
                                                    class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="menu1" class="tab-pane fade">
                                <div class="row" style="width:94%; margin:25px auto;">
                                    <div class="col-md-6">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Mức phụ cấp thu hút nghề (%)</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" disabled class="form-control"
                                                    v-model="thongtin_giaovien.mucPhuCapThuHut" />
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Mức phụ cấp thâm niên (%)</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" disabled class="form-control"
                                                    v-model="thongtin_giaovien.mucPhuCapThamNien" />
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Mức phụ cấp ưu đãi nghề (%)</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" disabled class="form-control"
                                                    v-model="thongtin_giaovien.mucPhuCapUuDai" />
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Mức phụ cấp chức vụ lãnh đạo(%)</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" disabled class="form-control"
                                                    v-model="thongtin_giaovien.mucPhuCapLanhDao" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Bậc lương</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.bacLuong,list_bac_luong)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Phần trăm vượt khung (%)</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" disabled class="form-control"
                                                    v-model="thongtin_giaovien.vuotKhung" />
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Hệ số lương</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input type="text" disabled class="form-control"
                                                    v-model="thongtin_giaovien.heSoLuong" />
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Ngày hưởng</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <date-picker disabled class="form-control" style="min-width: 50px;"
                                                    v-model="thongtin_giaovien.ngayHuong" :config="configDate"
                                                    placeholder="Chọn ngày">
                                                </date-picker>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="menu2" class="tab-pane fade">
                                <div class="row" style="width:94%; margin:25px auto;">
                                    <div class="col-md-4">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Kết quả bồi dưỡng thường xuyên</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.kqBdTx,list_kqbd_tx)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Trình độ chuyên môn nghiệp vụ <span style="color:#DC0101">*</span></b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.trinhDoChuyenMonCaoNhat,list_trinh_do_cm_nv)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Trình độ lý luận chính trị</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.trinhDoLyLuanChinhTri,list_trinh_do_llct)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Trình độ quản lý giáo dục</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.trinhDoQuanLyGiaoDuc,list_trinh_do_qlgd)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Tham gia bồi dưỡng nghiệp vụ quản lý giáo dục</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maBoiDuongNvu,list_boi_duong_nvu)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Tham gia bồi dưỡng CBQL/GV cốt cán</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maBoiDuongCbqlCotCan,list_boi_duong_cbqlcc)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Tham gia bồi dưỡng thay sách</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maBoiDuongThaySach,list_boi_duong_thay_sach)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Ngoại ngữ chính</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.monNgoaiNguChinh,list_ngoai_ngu_chinh)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Trình độ đào tạo ngoại ngữ</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.trinhDoNgoaiNgu,list_trinh_do_nn)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Nhóm chứng chỉ ngoại ngữ</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maNhomCchiNngu,list_nhom_cc_nn)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Loại chứng chỉ ngoại ngữ</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maLoaiCchiNngu,list_loai_cc_nn)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Điểm ngoại ngữ</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled type="text" class="form-control"
                                                    v-model="thongtin_giaovien.diemNgoaiNgu" />
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Khung năng lực ngoại ngữ</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maKhungNlucNngu,list_khung_nl_nn)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Trình độ tin học</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.trinhDoTinHoc,list_trinh_do_th)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Chuyên ngành chính</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.chuyenNganhDaoTaoChinh,list_cn_dt_chinh)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Trình độ chính</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.trinhDoDaoTaoCnChinh,list_trinh_do_chinh)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Cơ sở đào tạo</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled type="text" class="form-control"
                                                    v-model="thongtin_giaovien.tenCsDaoTaoBd" />
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Chuyên ngành khác</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.chuyenNganhDaoTaoKhac,list_cn_dt_khac)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Trình độ khác</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.trinhDoDaoTaoCnKhac,list_trinh_do_khac)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Giáo viên có chứng chỉ tiếng dân tộc thiểu số</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maChungChiTiengDtocTso,list_cc_tieng_dt_ts)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Quá trình đào tạo bồi dưỡng</b></p>
                                            </div>
                                            <div class="col-md-5">
                                                <a href="#" title="xem chi tiết" @click.prevent="viewNangLuc()"><b><i
                                                            style="border:1px solid #cfcfef;border-radius:4px; padding:5px 6px"
                                                            class="fas fa-plus"></i> Chi tiết</b> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="menu3" class="tab-pane fade">
                                <div class="row" style="width:94%; margin:25px auto;">
                                    <div class="col-md-4">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Đánh giá viên chức/ công chức</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.danhGiaVienChuc,list_danh_gia_vien_chuc)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Đánh giá chuẩn nghề nghiệp CBQL/GV</b></p>
                                            </div>
                                            <div class="col-md-5">
                                                <a href="#" title="xem chi tiết"
                                                    @click.prevent="viewDanhGiaKqChuanNn()"><b><i
                                                            style="border:1px solid #cfcfef;border-radius:4px; padding:5px 6px"
                                                            class="fas fa-plus"></i> Chi tiết</b> </a>
                                                <!-- <button class="btn btn-info"
                                                    @click="viewDanhGiaKqChuanNn()">xem & Sửa</button> -->
                                            </div>
                                        </div>
                                        <!-- <p><b>Đánh giá chuẩn nghề nghiệp CBQL/GV:</b><span></span></p> -->
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Giáo viên dạy giỏi</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.gvDayGioi,list_gv_day_gioi)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Giáo viên chủ nhiệm giỏi</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maGiaoVienChuNhiemGioi,list_gv_cn_gioi)">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Tổng phụ trách Đội giỏi</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled class="form-control"
                                                    :value="getTen(thongtin_giaovien.maGvTongPtrachDoiGioi,list_tong_pt_gioi)">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-5 text-right">
                                                <p><b>Danh hiệu phong tặng</b></p>
                                            </div>
                                            <div class="col-md-7">
                                                <input disabled type="text" class="form-control"
                                                    v-model="thongtin_giaovien.danhHieuPhongTang" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-fullscreen" style="">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- div modal -->
        <div>
            <div id="modal_danh_gia_chuan_nghe_nghiep_gv2" ref="modal_danh_gia_chuan_nghe_nghiep_gv2" class="modal fade" style="font-size:18px;">
                <div class="modal-dialog" style="width:95%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Đánh giá chuẩn nghề nghiệp: <b>{{thongtin_giaovien.tenGiaoVien}}
                                    ({{thongtin_giaovien.ngaySinh}})</b></h5>
                        </div>
                        <div class="modal-body" style="width: 100%;margin: 0 auto;">
                            <div style="height: 65vh;overflow: scroll;">
                                <div class="">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg">
                                                    <p>STT</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Tiêu chí</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Nội dung đánh giá</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Tự đánh giá</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Cấp trên đánh giá</p>
                                                </th>
                                                <!-- <th class="cg">
                                                    <p>Thao tác</p>
                                                </th> -->
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_dg_chuan_nn==0">
                                            <tr>
                                                <td class="cg bt" colspan="5">
                                                    <p>Không có bản ghi nào</p>
                                                    <!-- <a href="#" title="thêm" @click.prevent="themItemDanhGia()"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in list_dg_chuan_nn" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.maTieuChi}}</p>
                                                    <!-- <input type="text" disabled class="form-control"
                                                        v-model="item.noiDungDanhGia"> -->
                                                    <!-- <p>{{getTenTieuChiDg(item.maTieuChi)}}</p> -->
                                                    <!-- <el-select v-model="item.maTieuChi" disabled style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_tieu_chi" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select> -->
                                                </td>
                                                <td>
                                                    <p>{{item.noiDungDanhGia}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.tuDanhGia,list_danh_gia)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.capTrenDanhGia,list_danh_gia)}}</p>
                                                </td>
                                                <!-- <td class="cg bt">
                                                    <a href="#" title="xóa" @click.prevent="xoaItemDanhGia(i)"><b><i
                                                                style="color:#DC0101; background: gainsboro;"
                                                                class="fas fa-times"></i></b> </a>
                                                    <a href="#"
                                                        v-show="i+1==list_dg_chuan_nn.length"
                                                        title="thêm" @click.prevent="themItemDanhGia(i)"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td> -->
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button type="button" class="btn btn-danger" @click.prevent="closemodal2"
                                data-dismiss="modal">Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="modal_nl" ref="modal_nl" class="modal fade" style="font-size:18px;">
                <div class="modal-dialog" style="width:95%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-uppercase">Quá trình đào tạo, bồi dưỡng</h5>
                        </div>
                        <div class="modal-body" style="width: 100%;margin: 0 auto;">
                            <div style="height: 65vh;overflow: scroll;">
                                <div class="">
                                    <h6><b>Quá trình đào tạo bồi dưỡng</b></h6>
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg">
                                                    <p>STT</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Tên trường</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Chuyên ngành đào tạo, bồi dưỡng</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Từ ngày - đến ngày</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Hình thức</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Văn bằng, chứng chỉ</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_qua_trinh_dtbd.length==0">
                                            <tr>
                                                <td class="cg bt" colspan="8">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in list_qua_trinh_dtbd" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.tenTruong}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.maNhomChuyenNganh,list_cn_dt_khac)}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{item.tuThangNam}} - {{item.denThangnam}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.maHinhThucDaoTao,list_ht_dt)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.maVbChungChi,list_trinh_do_cm_nv2)}}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <h6><b>Quá trình bồi dưỡng nâng cao năng lực sư phạm</b></h6>
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg">
                                                    <p>STT</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Khóa đào tạo bồi dưỡng</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Đơn vị bồi dưỡng</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Đơn vị tổ chức</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Thời lượng bồi dưỡng</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Loại hình bồi dưỡng</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Hình thức</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Kết quả đạt được</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="qua_trinh_sp==0">
                                            <tr>
                                                <td class="cg bt" colspan="8">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in qua_trinh_sp" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaKhoaDaoTao,list_khoa_dao_tao_sp)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaDonViBoiDuong,list_dv)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaDonViToChuc,list_dv_tc)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaThoiLuongBoiDuong,list_tl_bd)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaLoaiHinhBoiDuong,list_lh_bd)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaHinhThuc,list_hinh_thuc)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaKetQua,list_kq_bd_sp)}}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    
                                    <h6><b>Quá trình bồi dưỡng nâng cao năng lực ngoại ngữ</b></h6>
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg">
                                                    <p>STT</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Khóa đào tạo bồi dưỡng</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Đơn vị tổ chức thi</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Đơn vị bồi dưỡng</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Đơn vị tổ chức</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Thời lượng bồi dưỡng</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Loại hình bồi dưỡng</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Hình thức</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Kết quả đạt được</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="qua_trinh_nn==0">
                                            <tr>
                                                <td class="cg bt" colspan="9">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in qua_trinh_nn" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaKhoaDaoTao,list_khoa_dao_tao_nn)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaDonViToChucThi,list_dv)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaDonViBoiDuong,list_dv)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaDonViToChuc,list_dv_tc)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaThoiLuongBoiDuong,list_tl_bd)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaLoaiHinhBoiDuong,list_lh_bd)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaHinhThuc,list_hinh_thuc)}}</p>
                                                </td>
                                                <td>
                                                    <p>{{getTen(item.MaKetQua,list_kq_bd_nn)}}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button type="button" class="btn btn-danger" @click.prevent="closemodal2"
                                data-dismiss="modal">Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end div -->
    </div>
</template>
<script>
    import moment from 'moment'
    import utils from '../../utils'
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
                thongtin_giaovien: {},
                list_dantoc: [],
                list_ton_giao: [],
                list_trang_thai_can_bo: [],
                list_loai_can_bo: [],
                list_mon_day: [],
                list_chuc_vu: [],
                list_hinh_thuc_hop_dong: [],
                list_nhiem_vu_kiem_nhiem: [],
                list_ma_ngach_hang: [],
                list_kqbd_tx: [],
                list_trinh_do_cm_nv: [],
                list_trinh_do_cm_nv2: [],
                list_trinh_do_llct: [],
                list_trinh_do_qlgd: [],
                list_boi_duong_nvu: [],
                list_boi_duong_cbqlcc: [],
                list_boi_duong_thay_sach: [],
                list_ngoai_ngu_chinh: [],
                list_trinh_do_nn: [],
                list_nhom_cc_nn: [],
                list_loai_cc_nn: [],
                list_khung_nl_nn: [],
                list_trinh_do_th: [],
                list_cn_dt_chinh: [],
                list_trinh_do_chinh: [],
                list_cn_dt_khac: [],
                list_trinh_do_khac: [],
                list_cc_tieng_dt_ts: [],
                list_danh_gia_vien_chuc: [],
                list_gv_day_gioi: [],
                list_gv_cn_gioi: [],
                list_tong_pt_gioi: [],
                list_bac_luong: [],
                list_tieu_chi: [],
                list_danh_gia: [],
                list_khoa_dao_tao_sp: [],
                list_khoa_dao_tao_nn: [],
                list_dv: [],
                list_dv_tc: [],
                list_tl_bd: [],
                list_hinh_thuc: [],
                list_lh_bd: [],
                list_kq_bd_sp: [],
                list_ht_dt: [],
                list_kq_bd_nn: [],
                qua_trinh_sp: [],
                qua_trinh_sp_old: [],
                qua_trinh_nn: [],
                qua_trinh_nn_old: [],
                list_dg_chuan_nn: [],
                list_qua_trinh_dtbd: [],
                list_qua_trinh_dtbd_old: [],
            }
        },
        mounted: function () {
            this.getTrinhDoCmNvSME2();
            this.ganDuLieuSME();
            this.mapToIntTrangThaiCanBo();
            $("#modal_info_teacher").modal();
            console.log("mã giáo viên update:");
            console.log(JSON.stringify(this.item));
            this.getThongTinGiaoVien(this.item);
            $(this.$refs.modal_info_teacher).on("hidden.bs.modal", this.close);
            $(this.$refs.modal_danh_gia_chuan_nghe_nghiep_gv2).on("hidden.bs.modal", this.closemodal2);
            $(this.$refs.modal_nl).on("hidden.bs.modal", this.closemodal3);
        },
        components: {
            datePicker
        },
        methods: {

            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_ton_giao_sme"];
                if (tmp) {
                    this.list_kq_bd_nn = JSON.parse(localStorage["danh_sach_ket_qua_boi_duong_ngoai_ngu_sme"]);
                    this.list_kq_bd_sp = JSON.parse(localStorage["danh_sach_ket_qua_boi_duong_su_pham_sme"]);
                    this.list_hinh_thuc = JSON.parse(localStorage["danh_sach_hinh_thuc_sme"]);
                    this.list_tl_bd = JSON.parse(localStorage["danh_sach_thoi_luong_boi_duong_sme"]);
                    this.list_dv_tc = JSON.parse(localStorage["danh_sach_don_vi_to_chuc_sme"]);
                    this.list_dv = JSON.parse(localStorage["danh_sach_don_vi_sme"]);
                    this.list_khoa_dao_tao_nn = JSON.parse(localStorage["danh_sach_khoa_dao_tao_ngoai_ngu_sme"]);
                    this.list_khoa_dao_tao_sp = JSON.parse(localStorage["danh_sach_khoa_dao_tao_su_pham_sme"]);
                    this.list_lh_bd = JSON.parse(localStorage["danh_sach_loai_hinh_boi_duong_sme"]);
                    this.list_ht_dt = JSON.parse(localStorage["danh_sach_hinh_thuc_dao_tao_sme"]);
                    this.list_bac_luong = JSON.parse(localStorage["danh_sach_bac_luong_sme"]);
                    this.list_danh_gia = JSON.parse(localStorage["danh_sach_danh_gia_chuan_nghe_nghiep_sme"]);
                    this.list_tong_pt_gioi = JSON.parse(localStorage["danh_sach_giao_vien_chu_nhiem_gioi_sme"]);
                    this.list_gv_cn_gioi = JSON.parse(localStorage["danh_sach_giao_vien_chu_nhiem_gioi_sme"]);
                    this.list_gv_day_gioi = JSON.parse(localStorage["danh_sach_giao_vien_day_gioi_sme"]);
                    this.list_danh_gia_vien_chuc = JSON.parse(localStorage["danh_sach_danh_gia_vien_chuc_sme"]);
                    this.list_cc_tieng_dt_ts = JSON.parse(localStorage["danh_sach_chung_chi_tieng_dan_toc_thieu_so_sme"]);
                    this.list_trinh_do_khac = JSON.parse(localStorage["danh_sach_trinh_do_khac_sme"]);
                    this.list_cn_dt_khac = JSON.parse(localStorage["danh_sach_chuyen_nganh_dao_tao_khac_sme"]);
                    this.list_trinh_do_chinh = JSON.parse(localStorage["danh_sach_trinh_do_chinh_sme"]);
                    this.list_cn_dt_chinh = JSON.parse(localStorage["danh_sach_chuyen_nganh_dao_tao_chinh_sme"]);
                    this.list_trinh_do_th = JSON.parse(localStorage["danh_sach_trinh_do_tin_hoc_sme"]);
                    this.list_khung_nl_nn = JSON.parse(localStorage["danh_sach_khung_nang_luc_ngoai_ngu_sme"]);
                    this.list_loai_cc_nn = JSON.parse(localStorage["danh_sach_loai_chung_chi_ngoai_ngu_sme"]);
                    this.list_nhom_cc_nn = JSON.parse(localStorage["danh_sach_nhom_chung_chi_ngoai_ngu_sme"]);
                    this.list_nhom_cc_nn = JSON.parse(localStorage["danh_sach_nhom_chung_chi_ngoai_ngu_sme"]);
                    this.list_trinh_do_nn = JSON.parse(localStorage["danh_sach_trinh_do_ngoai_ngu_moet_code_sme"]);
                    this.list_ngoai_ngu_chinh = JSON.parse(localStorage["danh_sach_ngoai_ngu_chinh_sme"]);
                    this.list_boi_duong_thay_sach = JSON.parse(localStorage["danh_sach_boi_duong_thay_sach_sme"]);
                    this.list_boi_duong_cbqlcc = JSON.parse(localStorage["danh_sach_boi_duong_can_bo_cot_can_sme"]);
                    this.list_boi_duong_nvu = JSON.parse(localStorage["danh_sach_boi_duong_nghiep_vu_sme"]);
                    this.list_trinh_do_qlgd = JSON.parse(localStorage["danh_sach_trinh_do_quan_ly_giao_duc_sme"]);
                    this.list_trinh_do_llct = JSON.parse(localStorage["danh_sach_trinh_do_ly_luan_chinh_tri_sme"]);
                    this.list_trinh_do_cm_nv = JSON.parse(localStorage["danh_sach_trinh_do_chuyen_mon_sme"]);
                    this.list_kqbd_tx = JSON.parse(localStorage["danh_sach_ket_qua_boi_duong_thuong_xuyen_sme"]);
                    this.list_ma_ngach_hang = JSON.parse(localStorage["danh_sach_ngach_hang_sme"]);
                    this.list_nhiem_vu_kiem_nhiem = JSON.parse(localStorage["danh_sach_nhiem_vu_kiem_nhiem_sme"]);
                    this.list_hinh_thuc_hop_dong = JSON.parse(localStorage["danh_sach_hinh_thuc_hop_dong_sme"]);
                    this.list_chuc_vu = JSON.parse(localStorage["danh_sach_chuc_vu_sme"]);
                    this.list_mon_day = JSON.parse(localStorage["danh_sach_mon_day_giao_vien_sme"]);
                    this.list_loai_can_bo = JSON.parse(localStorage["danh_sach_loai_can_bo_sme"]);
                    this.list_dantoc = JSON.parse(localStorage["danh_sach_dan_toc_sme"]);
                    this.list_ton_giao = JSON.parse(localStorage["danh_sach_ton_giao_sme"]);
                    this.list_trang_thai_can_bo = JSON.parse(localStorage["danh_sach_trang_thai_can_bo_sme"]);
                }
            },
            mapToIntTrangThaiCanBo() {
                console.log("map it ttcb");
                for (let i = 0; i < this.list_trang_thai_can_bo.length; i++) {
                    if (this.list_trang_thai_can_bo[i].value) {
                        this.list_trang_thai_can_bo[i].value = parseInt(this.list_trang_thai_can_bo[i].value)
                    }
                }
                for (let j = 0; j < this.list_loai_can_bo.length; j++) {
                    if (this.list_loai_can_bo[j].value) {
                        this.list_loai_can_bo[j].value = parseInt(this.list_loai_can_bo[j].value)
                    }
                }
                for (let k = 0; k < this.list_trinh_do_chinh.length; k++) {
                    if (this.list_trinh_do_chinh[k].value) {
                        this.list_trinh_do_chinh[k].value = parseInt(this.list_trinh_do_chinh[k].value)
                    }
                }
                for (let l = 0; l < this.list_kqbd_tx.length; l++) {
                    if (this.list_kqbd_tx[l].value) {
                        this.list_kqbd_tx[l].value = parseInt(this.list_kqbd_tx[l].value)
                    }
                }
                for (let l = 0; l < this.list_gv_day_gioi.length; l++) {
                    if (this.list_gv_day_gioi[l].value) {
                        this.list_gv_day_gioi[l].value = parseInt(this.list_gv_day_gioi[l].value)
                    }
                }
                for (let l = 0; l < this.list_danh_gia.length; l++) {
                    if (this.list_danh_gia[l].value) {
                        this.list_danh_gia[l].value = parseInt(this.list_danh_gia[l].value)
                    }
                }
                for (let l = 0; l < this.list_trinh_do_khac.length; l++) {
                    if (this.list_trinh_do_khac[l].value) {
                        this.list_trinh_do_khac[l].value = parseInt(this.list_trinh_do_khac[l].value)
                    }
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
            getTenTieuChiDg(e) {
                let ten = "";
                for (let i = 0; i < this.list_tieu_chi.length; i++) {
                    if (e == this.list_tieu_chi[i].value) {
                        ten = this.list_tieu_chi[i].name;
                    }
                }
                return ten;
            },
            getTrinhDoCmNvSME2() {
                let params = {
                    "constantType": "DM_TRINH_DO_CHUYEN_MON"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].constantCode,
                            }
                            this.list_trinh_do_cm_nv2.push(obj);
                        }
                        console.log("list_trinh_do_cm_nv2 sme:");
                        console.log(JSON.stringify(this.list_trinh_do_cm_nv2));
                    }
                });
            },
            getTieuChiSME() {
                console.log("tiêu chí chuẩn nn")
                let pr = "";
                if (this.thongtin_giaovien.capHoc == 4 || this.thongtin_giaovien.capHoc == 5) {
                    if (this.thongtin_giaovien.loaiCanBo == 1) {
                        // quản lý mần non
                        pr = "TIEU_CHI_DGKQ_CHUAN_NN_CBQL_MN"
                    }
                    if (this.thongtin_giaovien.loaiCanBo == 2) {
                        //giáo viên mầm non
                        pr = "TIEU_CHI_DGKQ_CHUAN_NN_GV_MN"
                    }
                } else {
                    if (this.thongtin_giaovien.loaiCanBo == 1) {
                        // quản lý pt
                        pr = "TIEU_CHI_DGKQ_CHUAN_NN_CBQL_PT"
                    }
                    if (this.thongtin_giaovien.loaiCanBo == 2) {
                        //giáo viên pt
                        pr = "TIEU_CHI_DGKQ_CHUAN_NN_GV_PT"
                    }
                }
                let params = {
                    "constantType": pr
                }
                console.log("tiêu chí chuẩn nn" + params)
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].mappingCode,
                            }
                            this.list_tieu_chi.push(obj);
                        }
                        console.log("list_tieu_chi sme:");
                        console.log(JSON.stringify(this.list_tieu_chi));
                    }
                });
            },
            getThongTinGiaoVien(e) {
                console.log("e");
                console.log(JSON.stringify(e));
                let params = {
                    "canBoTheoNamId": e.canBoTheoNamId,
                };
                rest_api.get("/csdlgd-admin/giaoVien/infor", params, (data) => {
                    if (data.data.maGiaoVien) {
                        // this.$alertify.success("Lấy dữ liệu thành công");
                        this.thongtin_giaovien = data.data;
                        // this.list_dg_chuan_nn = this.thongtin_giaovien.canBoTheoNamDanhGiaKqChuanNgheNghiepEntities;
                        this.list_dg_chuan_nn = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .canBoTheoNamDanhGiaKqChuanNgheNghiepEntities))
                        this.list_qua_trinh_dtbd = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .quaTrinhDaoTaoBoiDuongs));
                        if (this.list_qua_trinh_dtbd.length > 0) {
                            for (let i = 0; i < this.list_qua_trinh_dtbd.length; i++) {
                                if (
                                    this.list_qua_trinh_dtbd[i].tuThangNam) {
                                    this.list_qua_trinh_dtbd[i].tuThangNam = this.list_qua_trinh_dtbd[i]
                                        .tuThangNam.slice(0, 10);
                                }
                                if (
                                    this.list_qua_trinh_dtbd[i].denThangnam) {
                                    this.list_qua_trinh_dtbd[i].denThangnam = this.list_qua_trinh_dtbd[i]
                                        .denThangnam.slice(0, 10);
                                }
                            }
                        }
                        this.list_qua_trinh_dtbd_old = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .quaTrinhDaoTaoBoiDuongs))
                        if (this.list_qua_trinh_dtbd_old.length > 0) {
                            for (let i = 0; i < this.list_qua_trinh_dtbd_old.length; i++) {
                                if (
                                    this.list_qua_trinh_dtbd_old[i].tuThangNam) {
                                    this.list_qua_trinh_dtbd_old[i].tuThangNam = this.list_qua_trinh_dtbd_old[i]
                                        .tuThangNam.slice(0, 10);
                                }
                                if (
                                    this.list_qua_trinh_dtbd_old[i].denThangnam) {
                                    this.list_qua_trinh_dtbd_old[i].denThangnam = this.list_qua_trinh_dtbd_old[
                                        i].denThangnam.slice(0, 10);
                                }
                            }
                        }
                        this.getTieuChiSME();
                        this.getQuaTrinhNgoaiNgu("1");
                        this.getQuaTrinhSuPham("2");
                    } else {
                        this.$alertify.error("Lỗi." + data.data.rd);
                    }
                });
                // rest_api.get("/csdlgd-admin/giaoVien/infor", params, (data) => {
                //     if (data.data.maGiaoVien) {
                //         this.$alertify.success("Lấy dữ liệu thành công");
                //         this.thongtin_giaovien = data.data;
                //         this.list_dg_chuan_nn = this.thongtin_giaovien.canBoTheoNamDanhGiaKqChuanNgheNghiepEntities;
                //         this.getTieuChiSME();
                //         this.getQuaTrinhNgoaiNgu("1");
                //         this.getQuaTrinhSuPham("2");
                //     } else {
                //         this.$alertify.error("Lỗi." + data.data.rd);
                //     }
                // });
            },
            getQuaTrinhNgoaiNgu(e) {
                let params = {
                    id: this.thongtin_giaovien.canBoTheoNamId,
                    type: e,
                };
                rest_api.post("/csdlgd-admin/giaoVien/lstQuaTrinh", params, data => {
                    if (data.data.rc == 0) {
                        this.qua_trinh_nn_old = JSON.parse(JSON.stringify(data.data.rows));
                        this.qua_trinh_nn = JSON.parse(JSON.stringify(data.data.rows));
                    } else {
                        this.qua_trinh_nn = [];
                    }
                    console.log(JSON.stringify(this.qua_trinh_nn));
                });
            },
            getQuaTrinhSuPham(e) {
                let params = {
                    id: this.thongtin_giaovien.canBoTheoNamId,
                    type: e,
                };
                rest_api.post("/csdlgd-admin/giaoVien/lstQuaTrinh", params, data => {
                    if (data.data.rc == 0) {
                        this.qua_trinh_sp = JSON.parse(JSON.stringify(data.data.rows));
                        this.qua_trinh_sp_old = JSON.parse(JSON.stringify(data.data.rows));
                    } else {
                        this.qua_trinh_sp = [];
                    }
                    console.log("########################");
                    console.log(JSON.stringify(this.qua_trinh_sp));
                });
            },
            reset() {
                this.capmot = "";
                this.ten_lydo = "";
            },
            closemodal2() {
                $(this.$refs.modal_danh_gia_chuan_nghe_nghiep_gv2).on("hidden.bs.modal");
            },
            closemodal3() {
                $(this.$refs.modal_nl).on("hidden.bs.modal");
            },
            close() {
                console.log("close modal");
                this.$emit('close');
            },
            resetQt() {
                this.qua_trinh_sp = JSON.parse(JSON.stringify(this.qua_trinh_sp_old));;
                this.qua_trinh_nn = JSON.parse(JSON.stringify(this.qua_trinh_nn_old));;
            },
            resetChuanNn() {
                this.list_dg_chuan_nn = JSON.parse(JSON.stringify(this.thongtin_giaovien
                    .canBoTheoNamDanhGiaKqChuanNgheNghiepEntities));
            },
            viewDanhGiaKqChuanNn() {
                $("#modal_danh_gia_chuan_nghe_nghiep_gv2").modal();
            },
            viewNangLuc() {
                $("#modal_nl").modal();
            },
            xoaItemDanhGia(e) {
                console.log("xóa ở vị trí:" + e);
                this.list_dg_chuan_nn.splice(e, 1);
            },
            themItemDanhGia(e) {
                console.log("xóa ở vị trí:" + e);
                let obj = {
                    maTieuChi: "",
                    noiDungDanhGia: "",
                    tuDanhGia: "",
                    capTrenDanhGia: "",
                }
                this.list_dg_chuan_nn.push(obj);
            },
            xoaItemBdSp(e) {
                console.log("xóa ở vị trí:" + e);
                this.qua_trinh_sp.splice(e, 1);
            },
            themItemBdSp(e) {
                console.log("xóa ở vị trí:" + e);
                let obj = {
                    MaKetQua: "",
                    MaHinhThuc: "",
                    MaLoaiHinhBoiDuong: "",
                    MaKhoaDaoTao: "",
                    MaThoiLuongBoiDuong: "",
                    MaDonViToChuc: "",
                    MaDonViBoiDuong: "",
                }
                this.qua_trinh_sp.push(obj);
            },
            xoaItemBdNn(e) {
                console.log("xóa ở vị trí:" + e);
                this.qua_trinh_nn.splice(e, 1);
            },
            themItemBdNn(e) {
                console.log("xóa ở vị trí:" + e);
                let obj = {
                    MaKetQua: "",
                    MaHinhThuc: "",
                    MaLoaiHinhBoiDuong: "",
                    MaDonViToChucThi: "",
                    MaKhoaDaoTao: "",
                    MaThoiLuongBoiDuong: "",
                    MaDonViToChuc: "",
                    MaDonViBoiDuong: "",
                }
                this.qua_trinh_nn.push(obj);
            }
        }
    }
</script>
<style scoped="scoped">
    @import "../../../../node_modules/css-custom.css";
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

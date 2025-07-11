<template>
    <div>
        <div id="modal_info_teacher" ref="modal_info_teacher" class="modal fade">
            <div class="modal-dialog modal-dialog-fullscreen" style="">
                <div class="modal-content modal-content-fullscreen" style="">
                    <div class="modal-header modal-header-fullscreen" style="">
                        <h4>CHỈNH SỬA HỒ SƠ HỌC SINH</h4>
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
                                <div class="row rct">
                                    <div class="col-md-2 text-right"><b>Khối học</b></div>
                                    <div class="col-md-4">
                                        <el-select v-model="info.khoiHoc" filterable collapse-tags placeholder="Chọn"
                                            no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="item in list_khoi_hoc" :key="item.value" :label="item.name"
                                                :value="item.value">
                                            </el-option>
                                        </el-select></div>
                                    <div class="col-md-2 text-right"><b>Mã học sinh</b></div>
                                    <div class="col-md-4"><input class="form-control" disabled v-model="info.maHocSinh"></div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right"><b>Lớp học</b></div>
                                    <div class="col-md-4"><input class="form-control" v-model="info.maLopHocCn"></div>
                                    <div class="col-md-2 text-right"><b>Nhóm máu</b></div>
                                    <div class="col-md-4">
                                        <el-select v-model="info.nhomMau" filterable collapse-tags placeholder="Chọn"
                                            no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="item in list_nhommau" :key="item.value" :label="item.name"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right"><b>Họ tên</b></div>
                                    <div class="col-md-4"><input class="form-control" v-model="info.hoTen"></div>
                                    <div class="col-md-2 text-right"><b>Thành phần gia đình</b></div>
                                    <div class="col-md-4">
                                        <el-select v-model="info.tphanGdinh" filterable collapse-tags placeholder="Chọn"
                                            no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="item in list_tpgd" :key="item.value" :label="item.name"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right"><b>Ngày sinh</b></div>
                                    <div class="col-md-4">
                                        <date-picker class="form-control" style="min-width: 50px;"
                                            v-model="info.ngaySinh" :config="configDate" placeholder="Chọn ngày">
                                        </date-picker>
                                    </div>
                                    <div class="col-md-2 text-right"><b>Nơi sinh</b></div>
                                    <div class="col-md-4"><input class="form-control" v-model="info.noiSinh"></div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right"><b>Giới tính</b></div>
                                    <div class="col-md-4">
                                        <select class="form-control" v-model="info.gioiTinh">
                                            <option value="">Chọn</option>
                                            <option value="1">Nam</option>
                                            <option value="0">Nữ</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2 text-right"><b>Thôn xóm</b></div>
                                    <div class="col-md-4"><input class="form-control" placeholder="Nhập..." v-model="info.maTthonTmtru"></div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right"><b>Trạng thái HS</b></div>
                                    <div class="col-md-4">
                                        <el-select v-model="info.trangThai" filterable collapse-tags placeholder="Chọn"
                                            no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="item in list_tt_hs" :key="item.value" :label="item.name"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-md-2 text-right"><b>Quê quán</b></div>
                                    <div class="col-md-4">
                                        <textarea rows="1" class="form-control" v-model="info.queQuan"></textarea></div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right"><b>Dân tộc</b></div>
                                    <div class="col-md-4">
                                        <el-select v-model="info.maDanToc" filterable collapse-tags placeholder="Chọn"
                                            no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="item in list_dantoc" :key="item.value" :label="item.name"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-md-2 text-right"><b>Chỗ ở hiện nay</b></div>
                                    <div class="col-md-4">
                                        <textarea rows="1" class="form-control" v-model="info.dchiTmtru"></textarea>
                                    </div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right"><b>Tôn giáo</b></div>
                                    <div class="col-md-4">
                                        <el-select v-model="info.maTonGiao" filterable collapse-tags placeholder="Chọn"
                                            no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="item in list_tongiao" :key="item.value" :label="item.name"
                                                :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                    <div class="col-md-2 text-right"><b>Đ/C thường trú</b></div>
                                    <div class="col-md-4">
                                        <textarea rows="1" class="form-control" v-model="info.dchiThtru"></textarea>
                                    </div>
                                </div>
                                <div class="row rct">
                                    <div class="col-md-2 text-right"><b>SĐT liên hệ</b></div>
                                    <div class="col-md-4"><input class="form-control" v-model="info.soDthoaiCdinh"></div>
                                    <div class="col-md-2 text-right"><b>Email</b></div>
                                    <div class="col-md-4"><input class="form-control" v-model="info.email"></div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row" style="margin:0">
                            <div class="col-md-12">
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a data-toggle="tab" href="#home"><b>I. Thông tin cá nhân</b></a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#menu1"><b>II. Thông tin liên hệ, gia đình</b></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="home" class="tab-pane fade in active" style="width:95%;padding-top:25px; margin:0 auto;">
                                        <div v-if="info.capHoc==45||info.capHoc==4||info.capHoc==5">
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khu vực</b></div>
                                                <div class="col-md-2">
                                                    <el-select filterable v-model="info.maKhuVuc" collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_kv" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>HS tuyển mới</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.tuyenMoiMn" /></div>
                                                <div class="col-md-2 text-right"><b>Có cha dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.chaDanToc" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.khuyetTat" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Trẻ lớp bán trú</b></div>
                                                <div class="col-md-2">
                                                    <i v-if="info.lopBanTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Có mẹ dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.meDanToc" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Loại khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.maLoaiKhuyetTat" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_lkt" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học 2 buổi</b></div>
                                                <div class="col-md-2">
                                                <i v-if="info.buoiHoc==4||info.buoiHoc==5||info.buoiHoc==6" style="color:blue;"
                                                    class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                            </div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có Smartphone</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isPhCoSmartPhone" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng chính sách</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.maDtuongCsach" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dtcs" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ I</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isBietBoiKy1" /></div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có M.tính Internet</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isPhCoMayTinhInternet" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng ưu tiên</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.dtuongUuTien" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dtut" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ II</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isBietBoiKy2" /></div>
                                            </div>
                                        </div>
                                        <div v-else-if="info.capHoc==1">
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khu vực</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.maKhuVuc" filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_kv" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Đội viên</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.doiVien" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh B.Trú D.Nuôi</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhBanTruDanNuoi" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.khuyetTat" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học tiếng D.Tộc</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhTiengDanToc" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh N.Trú D.Nuôi</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhNoiTruDanNuoi" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Loại khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.maLoaiKhuyetTat" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_lkt" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học song ngữ</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSongNgu" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học Sinh bán trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhBanTru" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng chính sách</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.maDtuongCsach" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dtcs" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Loại nhập học </b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.loaiNhapHoc" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_loai_nhap_hoc" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh nội trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhNoiTru" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng ưu tiên</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.dtuongUuTien" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dtut" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Số buổi học trên tuần</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.soBuoiTrenTuan" disabled filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_buoi_hoc_tren_tuan" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh PTDT bán trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhPtdtBanTru" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học CTGD của Bộ</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocCtgdCuaBo" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh lớp B.Trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" disabled v-model="info.lopBanTru" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Có mẹ dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.meDanToc" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đã học lớp MG 5 tuổi</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocLopMg5T" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học bán trú</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.maHocBanTru" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_hoc_ban_tru" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Có cha dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.chaDanToc" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ I</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isBietBoiKy1" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>HSDT có nhu cầu HT NN</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.nhuCauHtroNngu" /></div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có Smartphone</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isPhCoSmartPhone" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ II</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isBietBoiKy2" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>HSDT có TL T.Cường TV</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.tangCuongTviet" /></div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có M.tính Internet</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isPhCoMayTinhInternet" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Bệnh về mắt</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh DT trợ giảng</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhDanTocTroGiang" /></div>
                                            </div>
                                        </div>
                                        <div v-else-if="info.capHoc==2||info.capHoc==3">
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khu vực</b></div>
                                                <div class="col-md-2">
                                                    <el-select filterable v-model="info.maKhuVuc" collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_kv" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Số CMND</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.soCmnd" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh B.Trú D.Nuôi</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhBanTruDanNuoi" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.khuyetTat" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Ngày cấp</b></div>
                                                <div class="col-md-2">
                                        <date-picker class="form-control" style="min-width: 50px;"
                                            v-model="info.ngayCapCmnd" :config="configDate" placeholder="Chọn ngày">
                                        </date-picker>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh N.Trú D.Nuôi</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhNoiTruDanNuoi" /></div>
                                            </div>

                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Loại khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.maLoaiKhuyetTat" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_lkt" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Nơi cấp</b></div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" v-model="info.noiCapCmnd" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học Sinh bán trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhBanTru" />
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khuyết tật không ĐG</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.khuyetTatKhongDanhGia" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Đội viên</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.doiVien" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh nội trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhNoiTru" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng chính sách</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.maDtuongCsach" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dtcs" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Đoàn viên</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.doanVien" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh PTDT bán trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhPtdtBanTru" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Đối tượng ưu tiên</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.dtuongUuTien" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dtut" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học tiếng D.Tộc</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSinhTiengDanToc" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Có mẹ dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.meDanToc" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học CTGD của Bộ</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocCtgdCuaBo" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học song ngữ</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocSongNgu" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Có cha dân tộc</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.chaDanToc" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>H.nghiệp, D.nghề</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.maLopHuongNghiepDayNghe" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_huong_nghiep" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Loại nhập học</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.loaiNhapHoc" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_loai_nhap_hoc" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có Smartphone</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isPhCoSmartPhone" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ I</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isBietBoiKy1" /></div>
                                                <div class="col-md-2 text-right"><b>Số buổi học trên tuần</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.soBuoiTrenTuan" disabled filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_buoi_hoc_tren_tuan" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>P.Huynh có M.tính Internet</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isPhCoMayTinhInternet" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học sinh biết bơi kỳ II</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isBietBoiKy2" /></div>
                                                <div class="col-md-2 text-right"><b>Học sinh lớp B.Trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" disabled v-model="info.lopBanTru" />
                                                </div>
                                                 <div v-if="info.capHoc==3" class="col-md-2 text-right"><b>T.vấn giáo dục hướng nghiệp</b></div>
                                                <div v-if="info.capHoc==3" class="col-md-2">
                                                    <input type="checkbox"  />
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Bệnh về mắt</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.isBietBoiKy2" /></div>
                                                <div class="col-md-2 text-right"><b>Học bán trú</b></div>
                                                <div class="col-md-2">
                                                    <el-select v-model="info.maHocBanTru" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_hoc_ban_tru" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
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
                                    <div id="menu1" class="tab-pane fade" style="width:95%; padding-top:25px;margin:0 auto;">
                                        <div class="row rct" style="padding-top:15px">
                                            <div class="col-md-2 text-right"><b>Tên bố</b></div>
                                            <div class="col-md-2"><input class="form-control" type="text"
                                                    v-model="info.hoTenBo"></div>
                                            <div class="col-md-2 text-right"><b>Tên mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" type="text"
                                                    v-model="info.hoTenMe"></div>
                                            <div class="col-md-2 text-right"><b>Tên người Đ.đầu</b></div>
                                            <div class="col-md-2"><input class="form-control" type="text"
                                                    v-model="info.hoTenNguoiGiamHo"></div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-2 text-right"><b>Nghề nghiệp bố</b></div>
                                            <div class="col-md-2"><input class="form-control" type="text"
                                                    v-model="info.ngheNghiepBo"></div>
                                            <div class="col-md-2 text-right"><b>Nghề nghiệp mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" type="text"
                                                    v-model="info.ngheNghiepMe"></div>
                                            <div class="col-md-2 text-right"><b>Nghề nghiệp người Đ.đầu</b></div>
                                            <div class="col-md-2"><input class="form-control" type="text"
                                                    v-model="info.ngheNghiepNguoiGiamHo"></div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-2 text-right"><b>Năm sinh bố</b></div>
                                            <div class="col-md-2"><input class="form-control" type="text"
                                                    v-model="info.namSinhBo"></div>
                                            <div class="col-md-2 text-right"><b>Năm sinh mẹ</b></div>
                                            <div class="col-md-2"><input class="form-control" type="text"
                                                    v-model="info.namSinhMe"></div>
                                            <div class="col-md-2 text-right"><b>Năm sinh người Đ.đầu</b></div>
                                            <div class="col-md-2"><input class="form-control" type="text"
                                                    v-model="info.ngaySinhNguoiGiamHo"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-fullscreen" style="">
                        <button class="btn btn-primary" @click.prevent="update()">Sửa</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import moment, { parseTwoDigitYear } from 'moment'
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
                list_dantoc: [{
                    name: "Chọn",
                    value: ""
                }],
                list_tongiao: [{
                    name: "Chọn",
                    value: ""
                }],
                list_nhommau: [{
                    name: "Chọn",
                    value: ""
                }],
                list_dtcs: [{
                    name: "Chọn",
                    value: ""
                }],
                list_dtut: [{
                    name: "Chọn",
                    value: ""
                }],
                list_kv: [{
                    name: "Chọn",
                    value: ""
                }],
                list_lkt: [{name: "Chọn",value: ""}],
                list_loai_nhap_hoc: [{name: "Chọn",value: ""}],
                list_buoi_hoc_tren_tuan: [{name: "Chọn",value: ""}],
                list_hoc_ban_tru: [{name: "Chọn",value: ""}],
                list_huong_nghiep: [{name: "Chọn",value: ""}],
                list_tpgd: [{name: "Chọn",value: ""}],
                list_khoi_hoc: constant.list_khoi_hoc,
            }
        },
        mounted: function () {
            console.log("mount");
            console.log(JSON.stringify(this.item));
            $("#modal_info_teacher").modal();
            this.getDataStudent();
            this.getDanTocSME();
            this.getTonGiaoSME();
            this.getNhomMauSME();
            this.getDtcsSME();
            this.getDtutSME();
            this.getKvSME();
            this.getLktSME();
            this.getLoaiNhapHocSME();
            this.getBuoiHocTuanSME();
            this.getHocBanTruSME();
            this.getHuongNghiepSME();
            this.getThanhPhanGdSME();
            $(this.$refs.modal_info_teacher).on("hidden.bs.modal", this.close);
        },
        components: {
            datePicker
        },
        methods: {
            close(){
                console.log("close modal");
                this.$emit('close');},
            getThanhPhanGdSME() {
                let params = {
                    "constantType": "THANH_PHAN_GIA_DINH"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: parseInt(lsdt[i].mappingCode),
                            }
                            this.list_tpgd.push(obj);
                        }
                        console.log("list_tpgd sme:");
                        console.log(JSON.stringify(this.list_tpgd));
                    }
                });
            },
            getHuongNghiepSME() {
                let params = {
                    "constantType": "DM_LOP_HUONG_NGHIEP_DAY_NGHE"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].mappingCode,
                            }
                            this.list_huong_nghiep.push(obj);
                        }
                        console.log("list_huong_nghiep sme:");
                        console.log(JSON.stringify(this.list_huong_nghiep));
                    }
                });
            },
            getHocBanTruSME() {
                let params = {
                    "constantType": "DM_HOC_BAN_TRU"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].mappingCode,
                            }
                            this.list_hoc_ban_tru.push(obj);
                        }
                        console.log("list_hoc_ban_tru sme:");
                        console.log(JSON.stringify(this.list_hoc_ban_tru));
                    }
                });
            },
            getBuoiHocTuanSME() {
                let params = {
                    "constantType": "DM_SO_BUOI_HOC_TREN_TUAN"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: parseInt(lsdt[i].mappingCode),
                            }
                            this.list_buoi_hoc_tren_tuan.push(obj);
                        }
                        console.log("list_buoi_hoc_tren_tuan sme:");
                        console.log(JSON.stringify(this.list_buoi_hoc_tren_tuan));
                    }
                });
            },
            getLoaiNhapHocSME() {
                let params = {
                    "constantType": "LOAI_NHAP_HOC"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: parseInt(lsdt[i].mappingCode),
                            }
                            this.list_loai_nhap_hoc.push(obj);
                        }
                        console.log("list_loai_nhap_hoc sme:");
                        console.log(JSON.stringify(this.llist_loai_nhap_hocist_lkt));
                    }
                });
            },
            getLktSME() {
                let params = {
                    "constantType": "DM_LOAI_KHUYET_TAT"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].mappingCode,
                            }
                            this.list_lkt.push(obj);
                        }
                        console.log("list_lkt sme:");
                        console.log(JSON.stringify(this.list_lkt));
                    }
                });
            },
            getKvSME() {
                let params = {
                    "constantType": "DM_KHU_VUC"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].mappingCode,
                            }
                            this.list_kv.push(obj);
                        }
                        console.log("list_kv sme:");
                        console.log(JSON.stringify(this.list_kv));
                    }
                });
            },
            getDtutSME() {
                let params = {
                    "constantType": "DM_VUNG_KHO_KHAN"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: parseInt(lsdt[i].mappingCode),
                            }
                            this.list_dtut.push(obj);
                        }
                        console.log("list_dtut sme:");
                        console.log(JSON.stringify(this.list_dtut));
                    }
                });
            },
            getDtcsSME() {
                let params = {
                    "constantType": "DM_DOI_TUONG_CHINH_SACH"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].mappingCode,
                            }
                            this.list_dtcs.push(obj);
                        }
                        console.log("list_dtcs sme:");
                        console.log(JSON.stringify(this.list_dtcs));
                    }
                });
            },
            getNhomMauSME() {
                let params = {
                    "constantType": "DM_NHOM_MAU"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: parseInt(lsdt[i].mappingCode),
                            }
                            this.list_nhommau.push(obj);
                        }
                        console.log("list_nhommau sme:");
                        console.log(JSON.stringify(this.list_nhommau));
                    }
                });
            },
            getDanTocSME() {
                let params = {
                    "constantType": "DM_DAN_TOC"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].mappingCode,
                            }
                            this.list_dantoc.push(obj);
                        }
                        console.log("list_dantoc sme:");
                        console.log(JSON.stringify(this.list_dantoc));
                    }
                });
            },
            getTonGiaoSME() {
                let params = {
                    "constantType": "DM_TON_GIAO"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].mappingCode,
                            }
                            this.list_tongiao.push(obj);
                        }
                        console.log("list_tongiao sme:");
                        console.log(JSON.stringify(this.list_tongiao));
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
            update(){
                if(!this.info.hoTenNguoiGiamHo&&!this.info.hoTenMe){
                    this.$alertify.error("Bổ sung họ tên mẹ hoặc người đỡ đầu");
                    return;
                }
                console.log("Chỉnh sửa học sinh");
                console.log(JSON.stringify(this.info));
                utils.confirmDialog("Xác nhận chỉnh sửa học sinh", "Chỉnh sửa", () => {
                    let params = {
                        updateHocSinhRequest: this.info,
                    };
                    rest_api.post("/csdlgd-admin/hocSinh/update", params, data => {
                        if (data.data.rc == 0) {
                            this.$alertify.success("Chỉnh sửa thành công");
                            this.$emit('close2');
                        } else {
                            utils.showDialog("Thất bại", data.data.message, null, () => {});
                        }
                    });
                })
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
    .col-md-1,
    .col-md-2,
    .col-md-3,
    .col-md-8,
    .col-md-6,
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

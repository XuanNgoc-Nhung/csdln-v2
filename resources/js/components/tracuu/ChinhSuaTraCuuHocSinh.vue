<template>
    <div>
        <div id="modal_info_teacher" ref="modal_info_teacher" class="modal fade">
            <div class="modal-dialog modal-dialog-fullscreen" style="">
            <form>
                <div class="modal-content modal-content-fullscreen" style="">
                    <div class="modal-header modal-header-fullscreen" style="">
                        <h4>Chỉnh sửa hồ sơ học sinh</h4>
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
                                        <p class="moet-code" style="padding-left:15px;">Mã định danh:
                                            <span>{{info.moetCode}}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-md-6" style="">
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Khối học <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <div>
                                                    <el-select v-model="info.khoiHoc" @change="chonKhoiHoc()" filterable
                                                        collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_khoi_hoc" :key="item.id"
                                                            :label="item.name" :value="item.id">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row rct" v-if="info.capHoc==4||info.capHoc==5||info.capHoc==45">
                                            <div class="col-md-4 text-right">
                                                <label>Nhóm tuổi <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <!-- <input type="text" class="form-control" disabled
                                                    :value="getTen(info.maNhomTuoiMn,list_nhom_tuoi_mam_non)"> -->
                                                <div v-if="info.khoiHoc==13">
                                                    <select class="form-control" @change="chonNhomTuoi()" v-model="info.maNhomTuoiMn">
                                                        <option value="">Chọn</option>
                                                        <option value="01">3-12 Tháng</option>
                                                        <option value="02">13-24 Tháng</option>
                                                        <option value="03">25-36 Tháng</option>
                                                    </select>
                                                </div>
                                                <div v-if="info.khoiHoc==16">
                                                    <select class="form-control"  @change="chonNhomTuoi()"  v-model="info.maNhomTuoiMn">
                                                        <option value="">Chọn</option>
                                                        <option value="04">3-4 Tuổi</option>
                                                        <option value="05">4-5 Tuổi</option>
                                                        <option value="06">5-6 Tuổi</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- LH_7900001_2020_1000661069 -->
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Lớp học <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <el-select v-model="info.maLopHocCn" @change="chonLopHoc()" filterable
                                                    collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="item in list_lop_hoc" :key="item.value"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Họ tên <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <input class="form-control" v-model="info.hoTen">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Ngày sinh <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <date-picker class="form-control" style="min-width: 50px;"
                                                @dp-change="ChonNgaySinh"
                                                    v-model="info.ngaySinh" :config="configDate"
                                                    placeholder="Chọn ngày">
                                                </date-picker>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Giới tính <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <select class="form-control" v-model="info.gioiTinh">
                                                    <option value="">Chọn</option>
                                                    <option value="1">Nam</option>
                                                    <option value="0">Nữ</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Trạng thái HS <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <el-select v-model="info.trangThai" @change="chonTrangThai()" filterable collapse-tags
                                                    placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="item in list_tt_hs" :key="item.value"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Dân tộc <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="col-md-8">
                                                <el-select v-model="info.maDanToc" filterable collapse-tags
                                                    placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="item in list_dantoc" :key="item.value"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Tôn giáo</label>
                                            </div>
                                            <div class="col-md-8">
                                                <el-select v-model="info.maTonGiao" filterable collapse-tags
                                                    placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="item in list_tongiao" :key="item.value"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>SĐT liên hệ</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control"
                                                    v-model="info.soDthoaiCdinh">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" v-model="info.email">
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
                                                <el-select v-model="info.nhomMau" filterable collapse-tags
                                                    placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="item in list_nhommau" :key="item.value"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>T.phần gia đình</label>
                                            </div>
                                            <div class="col-md-8">
                                                <el-select v-model="info.tphanGdinh" filterable collapse-tags
                                                    placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="item in list_tpgd" :key="item.value"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Nơi sinh</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control" v-model="info.noiSinh">
                                            </div>
                                        </div>
                                        <div class="row rct">
                                            <div class="col-md-4 text-right">
                                                <label>Thôn xóm</label>
                                            </div>
                                            <div class="col-md-8"><input class="form-control"
                                                    v-model="info.maTthonTmtru">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                <label>Quê quán</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea rows="3" class="form-control"
                                                    v-model="info.queQuan"></textarea>
                                            </div>
                                        </div>
                                        <div class="row" style="padding:8px 0 !important">
                                            <div class="col-md-4 text-right">
                                                <label>Chỗ ở hiện nay</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea rows="3" class="form-control"
                                                    v-model="info.dchiTmtru"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4 text-right">
                                                <label>Đ/C thường trú</label>
                                            </div>
                                            <div class="col-md-8">
                                                <textarea rows="3" class="form-control"
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
                                        <a data-toggle="tab" href="#thong-tin-ca-nhan-hoc-sinh"><b>I. Thông tin cá nhân</b></a>
                                    </li>
                                    <li>
                                        <a data-toggle="tab" href="#thong-tin-lien-he-hoc-sinh"><b>II. Thông tin liên hệ, gia đình</b></a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="thong-tin-ca-nhan-hoc-sinh" class="tab-pane fade in active"
                                        style="width:95%;padding-top:25px; margin:0 auto;">
                                        <div v-if="info.capHoc==45||info.capHoc==4||info.capHoc==5">
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khu vực</b></div>
                                                <div class="col-md-2">
                                                    <el-select filterable v-model="info.maKhuVuc" collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
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
                                                    <i v-if="info.buoiHoc==4||info.buoiHoc==5||info.buoiHoc==6"
                                                        style="color:blue;" class="fas fa-check-square"></i>
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
                                                    <el-select v-model="info.maKhuVuc" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
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
                                                    <input type="checkbox" @change="chonHocSinhBanTruDanNuoi()"
                                                        v-model="info.hocSinhBanTruDanNuoi" /></div>
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
                                                    <input type="checkbox" @change="chonHocSinhNoiTruDanNuoi()"
                                                        v-model="info.hocSinhNoiTruDanNuoi" /></div>
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
                                                <div class="col-md-2 text-right"><b>Học sinh bán trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" @change="chonHocSinhBanTru()"
                                                        v-model="info.hocSinhBanTru" /></div>
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
                                                    <input type="checkbox" @change="chonHocSinhNoiTru()"
                                                        v-model="info.hocSinhNoiTru" /></div>
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
                                                    <input type="text" class="form-control" disabled
                                                        :value="getTen(info.soBuoiTrenTuan,list_buoi_hoc_tren_tuan)">
                                                    <!-- <el-select v-model="info.soBuoiTrenTuan" disabled filterable
                                                        collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_buoi_hoc_tren_tuan"
                                                            :key="item.value" :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select> -->
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh PTDT bán trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" @change="chonHocSinhPtdtBanTru()"
                                                        v-model="info.hocSinhPtdtBanTru" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Học CTGD của Bộ</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.hocCtgdCuaBo" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh lớp B.Trú</b></div>
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
                                                <div class="col-md-2 text-right">
                                                    <!-- <b>Bệnh về mắt</b> -->
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- <input type="checkbox" /> -->
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
                                                    <el-select filterable v-model="info.maKhuVuc" collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_kv" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </div>
                                                <div class="col-md-2 text-right"><b>CMTND/TCC</b></div>
                                                <div class="col-md-2">
                                                    <input type="text" class="form-control" v-model="info.soCmnd" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh B.Trú D.Nuôi</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" @change="chonHocSinhBanTruDanNuoi()"
                                                        v-model="info.hocSinhBanTruDanNuoi" /></div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right"><b>Khuyết tật</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" v-model="info.khuyetTat" />
                                                </div>
                                                <div class="col-md-2 text-right"><b>Ngày cấp</b></div>
                                                <div class="col-md-2">
                                                    <date-picker class="form-control" style="min-width: 50px;"
                                                        v-model="info.ngayCapCmnd" :config="configDate"
                                                        placeholder="Chọn ngày">
                                                    </date-picker>
                                                </div>
                                                <div class="col-md-2 text-right"><b>Học sinh N.Trú D.Nuôi</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" @change="chonHocSinhNoiTruDanNuoi()"
                                                        v-model="info.hocSinhNoiTruDanNuoi" /></div>
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
                                                <div class="col-md-2 text-right"><b>Học sinh bán trú</b></div>
                                                <div class="col-md-2">
                                                    <input type="checkbox" @change="chonHocSinhBanTru"
                                                        v-model="info.hocSinhBanTru" />
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
                                                    <input type="checkbox" @change="chonHocSinhNoiTru()"
                                                        v-model="info.hocSinhNoiTru" /></div>
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
                                                    <input type="checkbox" @change="chonHocSinhPtdtBanTru()"
                                                        v-model="info.hocSinhPtdtBanTru" /></div>
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
                                                    <el-select v-model="info.maLopHuongNghiepDayNghe" filterable
                                                        collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
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
                                                    <input type="text" disabled class="form-control"
                                                        :value="getTen(info.soBuoiTrenTuan,list_buoi_hoc_tren_tuan)">
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
                                                    <i v-if="info.lopBanTru" style="color:blue;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square"></i>
                                                </div>
                                                <div v-if="info.capHoc==3" class="col-md-2 text-right">
                                                    <!-- <b>T.vấn giáo dục hướng nghiệp </b> -->
                                                </div>
                                                <div v-if="info.capHoc==3" class="col-md-2">
                                                    <!-- <input type="checkbox" /> -->
                                                </div>
                                            </div>
                                            <div class="row rct">
                                                <div class="col-md-2 text-right">
                                                    <!-- <b>Bệnh về mắt</b> -->
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- <input type="checkbox" v-model="info.isBietBoiKy2" /> -->
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
                                    <div id="thong-tin-lien-he-hoc-sinh" class="tab-pane fade"
                                        style="width:95%; padding-top:25px;margin:0 auto;">
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
                                            <div class="col-md-2">
                                                <date-picker class="form-control" style="min-width: 50px;"
                                                    @dp-change="ChonNgaySinhBo" v-model="info.ngaySinhBo"
                                                    :config="configDate" placeholder="Chọn ngày">
                                                </date-picker>
                                            </div>
                                            <div class="col-md-2 text-right"><b>Năm sinh mẹ</b></div>
                                            <div class="col-md-2">
                                                <date-picker class="form-control" style="min-width: 50px;"
                                                    @dp-change="ChonNgaySinhMe" v-model="info.ngaySinhMe"
                                                    :config="configDate" placeholder="Chọn ngày">
                                                </date-picker>
                                            </div>
                                            <div class="col-md-2 text-right"><b>Năm sinh người Đ.đầu</b></div>
                                            <div class="col-md-2">
                                                <date-picker class="form-control" style="min-width: 50px;"
                                                    @dp-change="ChonNgaySinhNGH" v-model="info.ngaySinhNguoiGiamHo"
                                                    :config="configDate" placeholder="Chọn ngày">
                                                </date-picker>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-fullscreen" style="">
                         <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                        </button>
                        <button class="btn btn-primary" @click.prevent="update()">Sửa</button>
                    </div>
                </div>
            </form>
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
                list_lop_hoc: [{
                    name: "Chọn",
                    value: ""
                }],
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
            anPhim(e){
                console.log("ấn phím" + e);
            },
            chonTrangThai(){

            },
            chonLopHoc() {
                console.log("Chọn lớp học");
                this.info.maLopHocDn = this.info.maLopHocCn;
                console.log(JSON.stringify(this.info.maLopHocDn));
            },
            ChonNgaySinh() {
                let d = this.info.ngaySinh.slice(-4, 10);
                this.info.namSinh = parseInt(d);
            },
            ChonNgaySinhMe() {
                let d = this.info.ngaySinhMe.slice(-4, 10);
                this.info.namSinhMe = d;
            },
            ChonNgaySinhBo() {
                let d = this.info.ngaySinhBo.slice(-4, 10);
                this.info.namSinhBo = d;
            },
            ChonNgaySinhNGH() {
                let d = this.info.ngaySinhNguoiGiamHo.slice(-4, 10);
                this.info.namSinhNguoiGiamHo = d;
            },
            chonKhoiHoc() {
                this.info.maNhomTuoiMn = "";
                this.info.maLopHocCn = "";
                this.list_lop_hoc = [{
                    name: "chọn",
                    value: ""
                }];
                this.getDanhSachLop();
            },
            chonNhomTuoi(){
                this.info.maLopHocCn = "";
                this.list_lop_hoc = [{
                    name: "chọn",
                    value: ""
                }];
                this.getDanhSachLop();
            },
            chonHocSinhBanTruDanNuoi() {
                if (this.info.hocSinhBanTruDanNuoi) {
                    this.info.hocSinhNoiTruDanNuoi = false;
                    this.info.hocSinhBanTru = false;
                    this.info.hocSinhNoiTru = false;
                    this.info.hocSinhPtdtBanTru = false;
                }
            },
            chonHocSinhNoiTruDanNuoi() {
                if (this.info.hocSinhNoiTruDanNuoi) {
                    this.info.hocSinhBanTruDanNuoi = false;
                    this.info.hocSinhBanTru = false;
                    this.info.hocSinhNoiTru = false;
                    this.info.hocSinhPtdtBanTru = false;
                }
            },
            chonHocSinhBanTru() {
                if (this.info.hocSinhBanTru) {
                    this.info.hocSinhBanTruDanNuoi = false;
                    this.info.hocSinhNoiTruDanNuoi = false;
                    this.info.hocSinhNoiTru = false;
                    this.info.hocSinhPtdtBanTru = false;
                }
            },
            chonHocSinhNoiTru() {
                if (this.info.hocSinhNoiTru) {
                    this.info.hocSinhBanTruDanNuoi = false;
                    this.info.hocSinhNoiTruDanNuoi = false;
                    this.info.hocSinhBanTru = false;
                    this.info.hocSinhPtdtBanTru = false;
                }
            },
            chonHocSinhPtdtBanTru() {
                if (this.info.hocSinhPtdtBanTru) {
                    this.info.hocSinhBanTruDanNuoi = false;
                    this.info.hocSinhNoiTruDanNuoi = false;
                    this.info.hocSinhBanTru = false;
                    this.info.hocSinhNoiTru = false;
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
            getDanhSachLop() {
                let params = {
                    "maTruong": this.info.maTruongHoc,
                    "namHoc": this.info.namHoc,
                    "khoiHoc": this.info.khoiHoc,
                    "maNhomTuoiMn": this.info.maNhomTuoiMn,
                };
                rest_api.get('/csdlgd-admin/lopHoc/findGroupMaLopHoc', params, data => {
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
            close() {
                console.log("close modal");
                this.$emit('close');
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
                        if (this.info.maTruongHoc && this.info.namHoc && this.info.khoiHoc) {
                            this.getDanhSachLop();
                        }

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
                    rest_api.post("/csdlgd-admin/hocSinh/update", params, data => {
                        if (data.data.rc == 0) {
                            this.$alertify.success("Chỉnh sửa thành công");
                            let dt = this.info.maHocSinh;
                            this.$emit('success', dt);
                        } else {
                            utils.showDialog("Thất bại", data.data.message, null, () => {});
                        }
                    });
                // utils.confirmDialog("Xác nhận chỉnh sửa học sinh", "Chỉnh sửa", () => {
                // })
            }
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

<template>
    <div v-loading="loadingFullScreen" element-loading-text="Loading..." element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog title="Chỉnh sửa thông tin học sinh" :visible.sync="show" top="5vh" :close-on-click-modal="false"
            width="1600px" :close-on-press-escape="false" :before-close="handleClose">
            <el-form :model='info' :rules="rules" ref="ruleForm">
                <el-row :gutter="24">
                    <el-col :span="24">
                        <div class="row" ref="scrollToMe">
                            <div class="col-sm-3 col-md-2">
                                <div class="thumbnail" style="text-align:center;">
                                    <div v-if="info.avatar">
                                        <img :src="info.avatar" width="100%" alt="hình ảnh học sinh" />
                                    </div>
                                    <div v-else>
                                        <img style="height: auto;max-width: 100%"
                                            src="https://www.drupal.org/files/issues/default-avatar.png" width="100%"
                                            alt="" />
                                    </div>
                                    <div>
                                        <p class="moet-code" style="padding-left:15px;">Mã định danh bộ GD&ĐT:
                                            <span class="d-block">{{ info.moetCode }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-9 col-md-10">
                                <div class="row">
                                    <div class="col-md-6" style="">
                                        <div class="form-group">
                                            <div class="">
                                                <label>Khối học <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="">
                                                <div>
                                                    <!-- {{ list_khoi_hoc  }} -->
                                                    <el-form-item prop="khoiHoc">
                                                        <el-select :disabled="isView" v-model="info.khoiHoc"
                                                            @change="chonKhoiHoc()" filterable collapse-tags
                                                            placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp" ref="khoiHoc">
                                                            <el-option v-for="(item,i) in list_khoi_hoc"
                                                                :key="item.value" :label="item.name"
                                                                :value="item.value">
                                                            </el-option>
                                                        </el-select>
                                                    </el-form-item>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="info.capHoc==4||info.capHoc==5||info.capHoc==45">
                                            <div class="">
                                                <label>Nhóm tuổi <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="">
                                                <!-- <input type="text" class="form-control" disabled
                                                            :value="getTen(info.maNhomTuoiMn,list_nhom_tuoi_mam_non)"> -->

                                                <el-form-item prop="maNhomTuoiMn">
                                                    <div v-if="info.khoiHoc==13">
                                                        <select :disabled="isView" class="form-control"
                                                            ref="maNhomTuoiMn" @change="chonNhomTuoi()"
                                                            v-model="info.maNhomTuoiMn">
                                                            <option value="">Chọn</option>
                                                            <option value="01">3-12 Tháng</option>
                                                            <option value="02">13-24 Tháng</option>
                                                            <option value="03">25-36 Tháng</option>
                                                        </select>
                                                    </div>
                                                    <div v-if="info.khoiHoc==16">
                                                        <select :disabled="isView" class="form-control"
                                                            ref="maNhomTuoiMn" @change="chonNhomTuoi()"
                                                            v-model="info.maNhomTuoiMn">
                                                            <option value="">Chọn</option>
                                                            <option value="04">3-4 Tuổi</option>
                                                            <option value="05">4-5 Tuổi</option>
                                                            <option value="06">5-6 Tuổi</option>
                                                        </select>
                                                    </div>
                                                </el-form-item>
                                            </div>
                                        </div>


                                        <!-- LH_7900001_2020_1000661069 -->
                                        <div class="form-group">
                                            <div class="">
                                                <label>Lớp học <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="">

                                                <el-form-item prop="maLopHocCn">
                                                    <el-select :disabled="isView" v-model="info.maLopHocCn"
                                                        @change="chonLopHoc()" filterable collapse-tags
                                                        placeholder="Chọn" ref="maLopHocCn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,index) in list_lop_hoc" :key="index"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Họ tên <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="">
                                                <el-form-item prop="hoTen">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true;info.hoTen=info.hoTen.trim()"
                                                        ref="hoTen" @input="nhapHoTen()" v-model="info.hoTen" />
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Ngày sinh<span style="color:#DC0101">
                                                        *</span></label>
                                            </div>
                                            <div class="">
                                                <el-form-item prop="ngaySinh">
                                                    <date-picker :disabled="isView" style="width:100%"
                                                        v-model="info.ngaySinh" :disabledDate="disableInvalidDates"
                                                        @change="chonNgaySinh()" placeholder="Chọn ngày" ref="ngaySinh"
                                                        valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                                    </date-picker>
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Giới tính <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="">

                                                <el-form-item prop="gioiTinh">
                                                    <select :disabled="isView" class="form-control" ref="gioiTinh"
                                                        @change="chonGioiTinh()" v-model="info.gioiTinh">
                                                        <option value="">Chọn</option>
                                                        <option value="1">Nam</option>
                                                        <option value="0">Nữ</option>
                                                    </select>
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Trạng thái học sinh <span style="color:#DC0101">
                                                        *</span></label>
                                            </div>
                                            <div class="">

                                                <el-form-item prop="trangThai">
                                                    <el-select :disabled="isView" v-model="info.trangThai"
                                                        @change="chonTrangThai()" ref="trangThai" filterable
                                                        collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,index) in list_tt_hs" :key="index"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group" v-if="info.trangThai==4">
                                            <div class="">
                                                <label>Lý do bỏ học <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="">
                                                <el-select :disabled="isView" v-model="info.maLyDoThoiHoc" filterable
                                                    collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_ly_do_thoi_hoc" :key="i"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Ngày trạng thái <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="">
                                                <el-form-item prop="ngayTrangThai">
                                                    <date-picker :disabled="isView" style="width:100%"
                                                        ref="ngayTrangThai" :disabledDate="disableInvalidDates"
                                                        v-model="info.ngayTrangThai" placeholder="Chọn ngày"
                                                        valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                                    </date-picker>
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Dân tộc <span style="color:#DC0101"> *</span></label>
                                            </div>
                                            <div class="">
                                                <el-form-item prop="maDanToc">
                                                    <el-select :disabled="isView" v-model="info.maDanToc" filterable
                                                        collapse-tags @change="chonDanToc()" placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu" ref="maDanToc"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_dantoc" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Quốc tịch</label>
                                            </div>
                                            <div class="">
                                                <el-form-item prop="maDanToc">
                                                    <el-select :disabled="isView" v-model="info.maQuocTich" filterable
                                                        collapse-tags placeholder="Chọn"
                                                        clearable
                                                        no-data-text="Không có dữ liệu" ref="maDanToc"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_quoctich" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Tôn giáo</label>
                                            </div>
                                            <div class="">
                                                <el-select :disabled="isView" v-model="info.maTonGiao" filterable
                                                    collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_tongiao" :key="i"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Số điện thoại liên hệ</label>
                                            </div>
                                            <div class="">
                                                <el-form-item prop="soDthoaiDdong">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        ref="soDthoaiDdong"
                                                        @change="check_confirm_come_back = true;info.soDthoaiDdong = info.soDthoaiDdong.trim()"
                                                        v-model="info.soDthoaiDdong" />
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Dân tộc trên giấy khai sinh</label>
                                            </div>
                                            <div class="">
                                                <el-form-item prop="hocBaDanTocTheoGiayKhaiSinh">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        ref="hocBaDanTocTheoGiayKhaiSinh"
                                                        @change="check_confirm_come_back = true;info.hocBaDanTocTheoGiayKhaiSinh = info.hocBaDanTocTheoGiayKhaiSinh.trim()"
                                                        v-model="info.hocBaDanTocTheoGiayKhaiSinh" />
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Email</label>
                                            </div>
                                            <div class="">
                                                <el-form-item prop="email">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        ref="email"
                                                        @change="check_confirm_come_back = true;info.email = info.email.trim()"
                                                        v-model.trim="info.email" />
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Mã định danh công dân</label>
                                            </div>
                                            <div class="">
                                                <el-input :disabled="isView" clearable placeholder=""
                                                    @change="check_confirm_come_back = true" disabled
                                                    v-model="info.citizenId" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6" style="">
                                        <div class="form-group">
                                            <div class="">
                                                <label>Mã định danh bộ GD&ĐT </label>
                                            </div>
                                            <div class="">
                                                <el-form-item prop="moetCode">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true"
                                                        v-model.trim="info.moetCode" />
                                                </el-form-item>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Mã học sinh</label>
                                            </div>
                                            <div class="">
                                                <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                    @change="check_confirm_come_back = true" disabled
                                                    v-model="info.maHocSinh" />
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="">
                                                <label>Quê quán</label>
                                            </div>
                                            <el-input type="textarea" :disabled="isView" :row="1"
                                                @change="info.queQuan = info.queQuan.trim()" @input="nhapQueQuan()"
                                                v-model="info.queQuan"></el-input>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class="">
                                                <label>Nơi sinh</label>
                                            </div>
                                            <div class="">
                                                <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                    @change="check_confirm_come_back = true;info.noiSinh = info.noiSinh.trim()"
                                                    @input="nhapNoiSinh()" v-model="info.noiSinh" />
                                            </div>
                                        </div>
                                        <!-- <div class="form-group">
                                            <div class="">
                                                <label>Thôn xóm</label>
                                            </div>
                                            <div class="">
                                                <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                    @change="check_confirm_come_back = true;info.maTthonTmtru = info.maTthonTmtru.trim()"
                                                    v-model="info.maTthonTmtru" />
                                            </div>
                                        </div> -->
                                        <div class="form-group">
                                            <div class="">
                                                <label>Chỗ ở hiện nay</label>
                                            </div>
                                            <div class="form-group">
                                                <el-input type="textarea" :disabled="true" :row="1"
                                                    @change="info.dchiTmtru = info.dchiTmtru.trim()"
                                                    @input="nhapChoOHienNay()" v-model="info.dchiTmtru"></el-input>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Nơi chuyển đi</label>
                                            </div>
                                            <div class="">
                                                <el-select :disabled="isView" v-model="info.noiChuyenDi" clearable
                                                    filterable collapse-tags placeholder="Chọn"
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
                                                        filterable collapse-tags placeholder="Chọn"
                                                        @change="chonChuyenDiDenTinh()"
                                                        clearable
                                                        :disabled="isView"
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
                                                    <el-select :disabled="isView" v-model="info.chuyenDiDenQuanHuyen"
                                                        filterable collapse-tags placeholder="Chọn"
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
                                                    <el-select :disabled="isView" v-model="info.chuyenDenTuTinh"
                                                        filterable collapse-tags placeholder="Chọn"
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
                                                    <el-select :disabled="isView" v-model="info.chuyenDenTuQuanHuyen"
                                                        filterable collapse-tags placeholder="Chọn"
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
                                        
                                        <div class="form-group">
                                            <div class="">
                                                <label>Địa chỉ thường trú</label>
                                            </div>
                                            <div class="">
                                                <el-input type="textarea" :disabled="isView" :row="1"
                                                    @change="info.dchiThtru = info.dchiThtru.trim()"
                                                    @input="nhapDcThuongTru()" v-model="info.dchiThtru"></el-input>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Nhóm máu</label>
                                            </div>
                                            <div class="">
                                                <el-select :disabled="isView" v-model="info.nhomMau" filterable
                                                    collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_nhommau" :key="i"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="">
                                                <label>Thành phần gia đình</label>
                                            </div>
                                            <div class="">
                                                <el-select :disabled="isView" v-model="info.tphanGdinh" filterable
                                                    collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_tpgd" :key="i" :label="item.name"
                                                        :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin:0">
                            <div class="">
                                <el-tabs type="border-card2">
                                    <el-tab-pane>
                                        <span slot="label">Thông tin cá nhân</span>
                                        <div v-if="info.capHoc == 45 || info.capHoc == 4 || info.capHoc == 5">
                                            <div class="row">
                                                <!-- <div class="col-sm-6 col-md-4 form-group">
                                                        <label>
                                                            Khu vực

                                                        </label>
                                                        <el-select :disabled="isView" filterable v-model="info.maKhuVuc" collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item, i) in list_kv" :key="i" :label="item.name" :value="item.value"></el-option>
                                                        </el-select>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>
                                                            Đối tượng chính sách

                                                        </label>
                                                        <el-select :disabled="isView" v-model="info.maDtuongCsach" filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item, i) in list_dtcs" :key="i" :label="item.name" :value="item.value"></el-option>
                                                        </el-select>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>
                                                            Đối tượng ưu tiên

                                                        </label>
                                                        <el-select :disabled="isView" v-model="info.dtuongUuTien" filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item, i) in list_dtut" :key="i" :label="item.name" :value="item.value"></el-option>
                                                        </el-select>
                                                    </div>

                                                    <div class="col-sm-12 col-md-12 form-group">
                                                       <div class="row">
                                                           <div class="col-md-4">


                                                               <label>
                                                                   Loại khuyết tật

                                                               </label>
                                                               <el-select :disabled="isView" v-model="info.maLoaiKhuyetTat" filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                                                   <el-option v-for="(item, i) in list_lkt" :key="i" :label="item.name" :value="item.value"></el-option>
                                                               </el-select>
                                                           </div>
                                                       </div>
                                                    </div> -->
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="khuVuc">Khu vực</label>
                                                        <el-select :disabled="isView" filterable v-model="info.maKhuVuc"
                                                            collapse-tags placeholder="Chọn"
                                                            no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item, i) in list_kv" :key="i"
                                                                :label="item.name" :value="item.value"></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="loaiKhuyetTat">Loại khuyết
                                                            tật</label>
                                                        <el-select :disabled="isView" v-model="info.maLoaiKhuyetTat"
                                                            filterable collapse-tags placeholder="Chọn"
                                                            no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item, i) in list_lkt" :key="i"
                                                                :label="item.name" :value="item.value"></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="doiTuongCsach">Đối tượng chính
                                                            sách</label>

                                                        <el-select :disabled="isView" v-model="info.maDtuongCsach"
                                                            filterable collapse-tags placeholder="Chọn"
                                                            no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item, i) in list_dtcs" :key="i"
                                                                :label="item.name" :value="item.value"></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="doiTuongUuTien">Đối tượng ưu
                                                            tiên</label>
                                                        <el-select :disabled="isView" v-model="info.dtuongUuTien"
                                                            filterable collapse-tags placeholder="Chọn"
                                                            no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item, i) in list_dtut" :key="i"
                                                                :label="item.name" :value="item.value"></el-option>
                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label>Số CMND/CCCD/ĐDCN</label>
                                                        <el-form-item prop="soCmnd">
                                                            <el-input :disabled="isView" type="text"
                                                                placeholder="Nhập..." clearable
                                                                v-model.trim="info.soCmnd" />
                                                        </el-form-item>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Ngày cấp CMND/CCCD/ĐDCN</label>
                                                    <div>
                                                        <!-- <date-picker class="form-control"  placeholder="Nhập..." style="min-width: 50px;"
                                                            v-model="info.ngayCapCmnd" :lang="lang"></date-picker> -->
                                                        <date-picker :disabled="isView" style="width:100%"
                                                            v-model="info.ngayCapCmnd"
                                                            :disabledDate="disableInvalidDates" @change="chonNgaySinh()"
                                                            placeholder="Chọn ngày" ref="ngaySinh" valueType="format"
                                                            value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                                        </date-picker>

                                                        <!-- <input type="text" class="form-control" disabled
                                                            v-model="info.ngayCapCmnd"/> -->
                                                    </div>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label class="typo__label">Nơi cấp CMND/CCCD/ĐDCN</label>
                                                    <div>
                                                        <el-input clearable placeholder="Nhập..." type="text"
                                                            v-model="info.noiCapCmnd" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6" v-if="false">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="soHoChieu">Số hộ chiếu</label>
                                                        <el-input clearable type="text" placeholder="Nhập..."
                                                            id="soHoChieu" v-model="info.soHoChieu" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6" v-if="false">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="ngayCapHoChieu">Ngày cấp hộ
                                                            chiếu</label>
                                                        <!-- <el-input clearable type="text"  placeholder="Nhập..." id="ngayCapHoChieu"
                                                            v-model="info.ngayCapHoChieu" /> -->
                                                        <date-picker :disabled="isView" style="width:100%"
                                                            v-model="info.ngayCapHoChieu"
                                                            :disabledDate="disableInvalidDates" @change="chonNgaySinh()"
                                                            placeholder="Chọn ngày" ref="ngaySinh" valueType="format"
                                                            value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                                        </date-picker>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6" v-if="false">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="noiCapHoChieu">Nơi cấp hộ
                                                            chiếu</label>
                                                        <el-input clearable type="text" placeholder="Nhập..."
                                                            id="noiCapHoChieu" v-model="info.noiCapHoChieu" />
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group">
                                                        <label class="typo__label" for="loaiNhapHoc">Loại nhập
                                                            học</label>
                                                        <!-- <el-input clearable id="loaiNhapHoc"
                                                            :value="getTen(info.loaiNhapHoc, list_loai_nhap_hoc)" /> -->
                                                        <el-select v-model="info.loaiNhapHoc" filterable collapse-tags
                                                            placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item,i) in list_loai_nhap_hoc" :key="i"
                                                                :label="item.name" :value="item.value">
                                                            </el-option>
                                                        </el-select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 col-6">
                                                    <div class="form-group" style="visibility:hidden">
                                                        <label class="typo__label" for="loaiNhapHoc">Loại nhập
                                                            học</label>
                                                        <el-input clearable id="loaiNhapHoc"
                                                            :value="getTen(info.loaiNhapHoc, list_loai_nhap_hoc)" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>
                                                        <input type="checkbox" v-model="info.khuyetTat" />
                                                        Khuyết tật
                                                    </label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>
                                                        <input type="checkbox" v-model="info.tuyenMoiMn" />
                                                        HS tuyển mới
                                                    </label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>
                                                        <i v-if="info.buoiHoc == 4 || info.buoiHoc == 5 || info.buoiHoc == 6"
                                                            style="color: #01856b;" class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        Học 2 buổi
                                                    </label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>
                                                        <i v-if="info.lopBanTru" style="color: #01856b;"
                                                            class="fas fa-check-square"></i>
                                                        <i v-else class="far fa-square"></i>
                                                        Trẻ lớp bán trú
                                                    </label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>
                                                        <input type="checkbox" v-model="info.chaDanToc" />
                                                        Có cha dân tộc
                                                    </label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>
                                                        <input type="checkbox" v-model="info.meDanToc" />
                                                        Có mẹ dân tộc
                                                    </label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>
                                                        <input type="checkbox" v-model="info.isPhCoSmartPhone" />
                                                        Phụ huynh có Smartphone
                                                    </label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>
                                                        <input type="checkbox" v-model="info.isBietBoiKy1" />
                                                        Học sinh biết bơi kỳ I
                                                    </label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>
                                                        <input type="checkbox" v-model="info.isPhCoMayTinhInternet" />
                                                        Phụ huynh có Máy tính Internet
                                                    </label>
                                                </div>

                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>
                                                        <input type="checkbox" v-model="info.isBietBoiKy2" />
                                                        Học sinh biết bơi kỳ II
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                        <div v-else-if="info.capHoc==1">
                                            <div class="row">
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>Số CMND/CCCD/ĐDCN</label>
                                                    <el-form-item prop="soCmnd">
                                                        <el-input :disabled="isView" type="text" placeholder="Nhập..."
                                                            clearable v-model.trim="info.soCmnd" />
                                                    </el-form-item>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>Ngày cấp CMND/CCCD/ĐDCN</label>
                                                            <date-picker :disabled="isView" style="width:100%"
                                                                v-model="info.ngayCapCmnd"
                                                                :disabledDate="disableInvalidDates"
                                                                placeholder="Chọn ngày" valueType="format"
                                                                value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                                    </date-picker>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>Nơi cấp CMND/CCCD/ĐDCN</label>
                                                            <el-input type="text" clearable placeholder="Nhập..."
                                                                v-model="info.noiCapCmnd" />
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>Khu vực</label>
                                                            <el-select :disabled="isView" v-model="info.maKhuVuc"
                                                                filterable collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item,i) in list_kv" :key="i"
                                                                    :label="item.name" :value="item.value">
                                                                </el-option>
                                                            </el-select>
                                                </div>
                                                <div class="col-sm-6 col-md-4 form-group">
                                                    <label>Loại nhập học </label>
                                                            <el-select :disabled="isView" v-model="info.loaiNhapHoc"
                                                                filterable collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item,i) in list_loai_nhap_hoc"
                                                                    :key="i" :label="item.name" :value="item.value">
                                                                </el-option>
                                                            </el-select>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>Số buổi học trên tuần</label>
                                                            <el-input :disabled="isView" type="text" disabled
                                                                :value="getTen(info.soBuoiTrenTuan,list_buoi_hoc_tren_tuan)" />
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>Đối tượng chính sách</label>
                                                            <el-select :disabled="isView" v-model="info.maDtuongCsach"
                                                                filterable collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item,i) in list_dtcs" :key="i"
                                                                    :label="item.name" :value="item.value">
                                                                </el-option>
                                                            </el-select>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>Đối tượng ưu tiên</label>
                                                            <el-select :disabled="isView" v-model="info.dtuongUuTien"
                                                                filterable collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item,i) in list_dtut" :key="i"
                                                                    :label="item.name" :value="item.value">
                                                                </el-option>
                                                            </el-select>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>Loại khuyết tật</label>
                                                            <el-select :disabled="isView" v-model="info.maLoaiKhuyetTat"
                                                                filterable collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item,i) in list_lkt" :key="i"
                                                                    :label="item.name" :value="item.value">
                                                                </el-option>
                                                            </el-select>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>Học bán trú</label>
                                                            <el-select :disabled="isView" v-model="info.maHocBanTru"
                                                                filterable collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item,i) in list_hoc_ban_tru" :key="i"
                                                                    :label="item.name" :value="item.value">
                                                                </el-option>
                                                            </el-select>
                                                    </div>
                                                    <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox" v-model="info.khuyetTat" />
                                                                Khuyết tật
                                                            </label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox" @change="chonHocSinhBanTru()"
                                                                    v-model="info.hocSinhBanTru" />
                                                                Học sinh bán trú
                                                            </label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <div>
                                                            <label>
                                                                <input type="checkbox"
                                                                    @change="chonHocSinhBanTruDanNuoi()"
                                                                    v-model="info.hocSinhBanTruDanNuoi" />
                                                                Học sinh bán trú dân nuôi
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <div>
                                                            <label>
                                                                <input type="checkbox" v-model="info.doiVien" />
                                                                Đội viên
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <div>
                                                            <label>
                                                                <input type="checkbox"
                                                                    v-model="info.hocSinhTiengDanToc" />
                                                                Học tiếng dân tộc
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <div>
                                                            <label>
                                                                <input type="checkbox"
                                                                    @change="chonHocSinhNoiTruDanNuoi()"
                                                                    v-model="info.hocSinhNoiTruDanNuoi" />
                                                                Học sinh nội trú dân nuôi
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <div>
                                                            <label>
                                                                <input type="checkbox" v-model="info.hocSongNgu" />
                                                                Học song ngữ
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <div>
                                                            <label>
                                                                <input type="checkbox" @change="chonHocSinhNoiTru()"
                                                                    v-model="info.hocSinhNoiTru" />
                                                                Học sinh nội trú
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <div>
                                                            <label>
                                                                <input type="checkbox" @change="chonHocSinhPtdtBanTru()"
                                                                    v-model="info.hocSinhPtdtBanTru" />
                                                                Học sinh phổ thông dân tộc bán trú
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <div>
                                                            <label>
                                                                <input type="checkbox" v-model="info.hocCtgdCuaBo" />
                                                                Học chương trình giáo dục của Bộ
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <div>
                                                            <label>
                                                                <!-- <i v-if="info.lopBanTru" style="color:#01856b;"
                                                                class="fas fa-check-square"></i>
                                                            <i v-else class="far fa-square"></i>
                                                             -->
                                                                <input type="checkbox" disabled
                                                                    v-model="info.lopBanTru" />
                                                                Học sinh lớp bán trú
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>
                                                            <input type="checkbox" v-model="info.meDanToc" />
                                                            Có mẹ dân tộc
                                                        </label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>
                                                            <input type="checkbox" v-model="info.hocLopMg5T" />
                                                            Đã học lớp mẫu giáo 5 tuổi
                                                        </label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>
                                                            <input type="checkbox" v-model="info.chaDanToc" />
                                                            Có cha dân tộc
                                                        </label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>
                                                            <input type="checkbox" v-model="info.isBietBoiKy1" />
                                                            Học sinh biết bơi kỳ I
                                                        </label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>
                                                            <input type="checkbox" v-model="info.nhuCauHtroNngu" />
                                                            Học sinh có nhu cầu hỗ trợ ngoại ngữ
                                                        </label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>
                                                            <input type="checkbox" v-model="info.isPhCoSmartPhone" />
                                                            Phụ huynh có Smartphone
                                                        </label>
                                                    </div>

                                                    <div class="col-sm-6 col-md-4 form-group">
                                                        <label>
                                                            <input type="checkbox" v-model="info.isBietBoiKy2" />
                                                            Học sinh biết bơi kỳ II
                                                        </label>
                                                    </div>

                                                </div>
                                        </div>
                                        <div v-else-if="info.capHoc==2||info.capHoc==3">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <!-- <el-form-item prop="soCmnd"> -->
                                                            <label>Số CMND/CCCD/ĐDCN</label>
                                                            <el-form-item prop="soCmnd">
                                                                <el-input :disabled="isView" type="text"
                                                                    placeholder="Nhập..." clearable
                                                                    v-model.trim="info.soCmnd" />
                                                            </el-form-item>
                                                            <!-- </el-form-item> -->
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div><label>Ngày cấp CMND/CCCD/ĐDCN</label></div>
                                                            <div class="">
                                                                <date-picker :disabled="isView" style="width:100%"
                                                                    v-model="info.ngayCapCmnd"
                                                                    :disabledDate="disableInvalidDates"
                                                                    placeholder="Chọn ngày" valueType="format"
                                                                    value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                                                </date-picker>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div><label>Nơi cấp CMND/CCCD/ĐDCN</label></div>
                                                            <div class="">
                                                                <input type="text" class="form-control"
                                                                    v-model="info.noiCapCmnd" />
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>Đối tượng chính sách</label>
                                                            <el-select :disabled="isView" v-model="info.maDtuongCsach"
                                                                filterable collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item, i) in list_dtcs" :key="i"
                                                                    :label="item.name" :value="item.value"></el-option>
                                                            </el-select>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>Đối tượng ưu tiên</label>
                                                            <el-select :disabled="isView" v-model="info.dtuongUuTien"
                                                                filterable collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item, i) in list_dtut" :key="i"
                                                                    :label="item.name" :value="item.value"></el-option>
                                                            </el-select>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>Số buổi học trên tuần</label>
                                                            <input type="text" disabled class="form-control"
                                                                :value="getTen(info.soBuoiTrenTuan, list_buoi_hoc_tren_tuan)" />
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>Hướng nghiệp, dạy nghề</label>
                                                            <el-select :disabled="isView"
                                                                v-model="info.maLopHuongNghiepDayNghe" filterable
                                                                collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item, i) in list_huong_nghiep"
                                                                    :key="i" :label="item.name" :value="item.value">
                                                                </el-option>
                                                            </el-select>
                                                        </div>
                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>Loại nhập học</label>
                                                            <el-select :disabled="isView" v-model="info.loaiNhapHoc"
                                                                filterable collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item, i) in list_loai_nhap_hoc"
                                                                    :key="i" :label="item.name" :value="item.value">
                                                                </el-option>
                                                            </el-select>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>Học bán trú</label>
                                                            <el-select :disabled="isView" v-model="info.maHocBanTru"
                                                                filterable collapse-tags placeholder="Chọn"
                                                                no-data-text="Không có dữ liệu"
                                                                no-match-text="Không có dữ liệu phù hợp">
                                                                <el-option v-for="(item, i) in list_hoc_ban_tru"
                                                                    :key="i" :label="item.name" :value="item.value">
                                                                </el-option>
                                                            </el-select>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div><label>Loại khuyết tật</label></div>
                                                            <div class="">
                                                                <el-select :disabled="isView"
                                                                    v-model="info.maLoaiKhuyetTat" filterable
                                                                    collapse-tags placeholder="Chọn"
                                                                    no-data-text="Không có dữ liệu"
                                                                    no-match-text="Không có dữ liệu phù hợp">
                                                                    <el-option v-for="(item,i) in list_lkt" :key="i"
                                                                        :label="item.name" :value="item.value">
                                                                    </el-option>
                                                                </el-select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="row">


                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div>
                                                                <label>
                                                                    <input type="checkbox" v-model="info.khuyetTat" />
                                                                    Khuyết tật
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox"
                                                                    v-model="info.khuyetTatKhongDanhGia" />
                                                                Khuyết tật không đánh giá
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div>
                                                                <label>
                                                                    <input type="checkbox"
                                                                        @change="chonHocSinhBanTruDanNuoi()"
                                                                        v-model="info.hocSinhBanTruDanNuoi" />
                                                                    Học sinh bán trú dân nuôi
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div>
                                                                <label>
                                                                    <input type="checkbox"
                                                                        @change="chonHocSinhNoiTruDanNuoi()"
                                                                        v-model="info.hocSinhNoiTruDanNuoi" />
                                                                    Học sinh nội trú dân nuôi
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox" @change="chonHocSinhBanTru"
                                                                    v-model="info.hocSinhBanTru" />
                                                                Học sinh bán trú
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox" @change="chonHocSinhNoiTru()"
                                                                    v-model="info.hocSinhNoiTru" />
                                                                Học sinh nội trú
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div>
                                                                <label>
                                                                    <input type="checkbox"
                                                                        @change="chonHocSinhPtdtBanTru()"
                                                                        v-model="info.hocSinhPtdtBanTru" />
                                                                    Học sinh phổ thông dân tộc bán trú
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div>
                                                                <label>
                                                                    <input type="checkbox" v-model="info.doiVien" />
                                                                    Đội viên
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div>
                                                                <label>
                                                                    <input type="checkbox" v-model="info.doanVien" />
                                                                    Đoàn viên
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div>
                                                                <label>
                                                                    <input type="checkbox"
                                                                        v-model="info.hocSinhTiengDanToc" />
                                                                    Học tiếng dân tộc
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox" v-model="info.chaDanToc" />
                                                                Có cha dân tộc
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <div>
                                                                <label>
                                                                    <input type="checkbox" v-model="info.meDanToc" />
                                                                    Có mẹ dân tộc
                                                                </label>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox" v-model="info.hocCtgdCuaBo" />
                                                                Học chương trình giáo dục của Bộ
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox" v-model="info.hocSongNgu" />
                                                                Học song ngữ
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox"
                                                                    v-model="info.isPhCoSmartPhone" />
                                                                Phụ huynh có Smartphone
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox" v-model="info.isBietBoiKy1" />
                                                                Học sinh biết bơi kỳ I
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox" v-model="info.isBietBoiKy2" />
                                                                Học sinh biết bơi kỳ II
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <input type="checkbox"
                                                                    v-model="info.isPhCoMayTinhInternet" />
                                                                Phụ huynh có Máy tính Internet
                                                            </label>
                                                        </div>

                                                        <div class="col-sm-6 col-md-4 form-group">
                                                            <label>
                                                                <!--                                                                    <input type="checkbox" v-model="info.lopBanTru" />-->
                                                                <span>
                                                                    <!-- <i v-if="info.lopBanTru" style="color:#01856b;"
                                                                        class="fas fa-check-square"></i>
                                                                    <i v-else class="far fa-square"></i>
                                                                     -->
                                                                    <input type="checkbox" disabled
                                                                        v-model="info.lopBanTru" />
                                                                </span>
                                                                Học sinh lớp bán trú
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div>




                                            </div>


                                        </div>
                                        <div v-else>
                                            <div class="row">
                                                <div class=" text-center">
                                                    <p><label>Chưa có dữ liệu</label></p>
                                                </div>
                                            </div>
                                        </div>
                                    </el-tab-pane>
                                    <el-tab-pane label="Config">
                                        <span slot="label">Thông tin liên hệ, gia đình</span>

                                        <div class="row">
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div><label>Họ tên bố</label></div>
                                                <div class="">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true;info.hoTenBo = info.hoTenBo.trim()"
                                                        type="text" v-model="info.hoTenBo" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Họ tên mẹ</label></div>
                                                <div class="">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true;info.hoTenMe = info.hoTenMe.trim()"
                                                        type="text" v-model="info.hoTenMe" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Họ tên người giám hộ</label></div>
                                                <div class="">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true;info.hoTenNguoiGiamHo = info.hoTenNguoiGiamHo.trim()"
                                                        type="text" v-model="info.hoTenNguoiGiamHo" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Nghề nghiệp bố</label></div>
                                                <div class="">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true;info.ngheNghiepBo = info.ngheNghiepBo.trim()"
                                                        type="text" v-model="info.ngheNghiepBo" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Nghề nghiệp mẹ</label></div>
                                                <div class="">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true;info.ngheNghiepMe = info.ngheNghiepMe.trim()"
                                                        type="text" v-model="info.ngheNghiepMe" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Nghề nghiệp người giám hộ</label>
                                                </div>
                                                <div class="">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true;info.ngheNghiepNguoiGiamHo=info.ngheNghiepNguoiGiamHo.trim()"
                                                        type="text" v-model="info.ngheNghiepNguoiGiamHo" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Năm sinh bố</label></div>
                                                <div class="">
                                                    <date-picker :disabled="isView" style="width:100%"
                                                        v-model="info.ngaySinhBo" :disabledDate="disableInvalidDates"
                                                        placeholder="Chọn ngày" valueType="format"
                                                        value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                                    </date-picker>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Năm sinh mẹ</label></div>
                                                <div class="">
                                                    <date-picker :disabled="isView" style="width:100%"
                                                        v-model="info.ngaySinhMe" :disabledDate="disableInvalidDates"
                                                        placeholder="Chọn ngày" valueType="format"
                                                        value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                                    </date-picker>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Năm sinh người giám hộ</label></div>
                                                <div class="">
                                                    <date-picker :disabled="isView" style="width:100%"
                                                        v-model="info.ngaySinhNguoiGiamHo"
                                                        :disabledDate="disableInvalidDates" placeholder="Chọn ngày"
                                                        valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                                    </date-picker>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Nơi làm việc bố</label></div>
                                                <div class="">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true;info.noiLamViecBo = info.noiLamViecBo.trim()"
                                                        type="text" v-model="info.noiLamViecBo" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Nơi làm việc mẹ</label></div>
                                                <div class="">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true;info.noiLamViecMe = info.noiLamViecMe.trim()"
                                                        type="text" v-model="info.noiLamViecMe" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group">
                                                <div class=""><label>Nơi làm việc người giám hộ</label>
                                                </div>
                                                <div class="">
                                                    <el-input :disabled="isView" clearable placeholder="Nhập..."
                                                        @change="check_confirm_come_back = true;info.noiLamViecNguoiGiamHo = info.noiLamViecNguoiGiamHo.trim()"
                                                        type="text" v-model="info.noiLamViecNguoiGiamHo" />
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4 form-group"></div>


                                        </div>


                                    </el-tab-pane>
                                </el-tabs>
                            </div>
                        </div>
                    </el-col>
                </el-row>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button v-if="!isView" type="primary" @click.prevent="submitForm('ruleForm')" size="mini">Lưu
                </el-button>
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
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import rest_api from '../../../utils/rest_api';
    import array_util from '../../../utils/array_utils';
    import timeutils from "../../../utils/time_utils";
    import api from '../../api';
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import VueAlertify from "vue-alertify";
    import {
        LGeoJson
    } from 'vue2-leaflet';

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
            'item', 'show', 'isView'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.dataFill = {}
                    this.getDataStudent();
                    // $("#modal_info_teacher").modal();
                } else {
                    // $("#modal_info_teacher").modal('hide');
                }
            },
            'info.chuyenDiDenTinh': function (val) {
                this.danh_sach_huyen_chuyen_den = []
                console.log('111')
                if (val) {
                    this.layHuyen(val, 'den');
                }
            },
            'info.chuyenDenTuTinh': function (val) {
                this.danh_sach_huyen_chuyen_di = []
                if (val) {
                    this.layHuyen(val, 'di');
                }
            }
        },
        data() {
            return {
                danh_sach_huyen_chuyen_di: [],
                danh_sach_huyen_chuyen_den: [],
                configDate: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                loadingFullScreen: false,
                check_confirm_come_back: false,
                info: {},
                rules: {
                    khoiHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    maNhomTuoiMn: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    maLopHocCn: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    hoTen: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    moetCode: [{
                        validator: this.validateMoetCode,
                        trigger: ['blur', 'change']
                    }],
                    maDanToc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    ngayTrangThai: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    ngaySinh: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    trangThai: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    gioiTinh: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    soDthoaiDdong: [{
                        pattern: /^0\d+$/,
                        message: 'Số điện thoại không đúng',
                        trigger: ['blur', 'change']
                    }],

                    email: [{
                        type: 'email',
                        message: 'Vui lòng nhập đúng định dạng email',
                        trigger: ['blur', 'change']
                    }],
                    //CMND nếu nhập thì phải nhập 9 hoặc 12 số

                    soCmnd: [{
                        validator: (rule, value, callback) => {
                            if (!value) {
                                callback(); // Không bắt buộc nên cho phép bỏ trống
                                return;
                            }
                            // Nếu dân tộc là 55 thì cho phép tối đa 100 ký tự
                            if (this.info.maDanToc == 55) {
                                if (value.length > 100) {
                                    callback(new Error('Số CMND/CCCD không được vượt quá 100 ký tự'));
                                    return;
                                }
                            } else {
                                // Nếu không phải dân tộc 55 thì phải là 9 hoặc 12 ký tự
                                if (value.length != 9 && value.length != 12) {
                                    callback(new Error('Số CMND/CCCD phải là 9 hoặc 12 ký tự'));
                                    return;
                                }
                            }
                            callback(); // Không có lỗi
                        },
                        trigger: ['blur', 'change']
                    }, ],
                },

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
                danh_sach_chuyen_di: [],
                list_nhom_tuoi_mam_non: [],
                list_ly_do_thoi_hoc: [],
                list_khoi_hoc: constant.list_khoi_hoc,
                khoi_mot: constant.khoiCapMot,
                khoi_hai: constant.khoiCapHai,
                khoi_ba: constant.khoiCapBa,
                khoi_mam_non: constant.khoi_mam_non_hai_cap,
                list_lop_hoc: [{
                    name: "Chọn",
                    value: ""
                }],
                dataFill: {},
                danh_sach_tinh: []
            }
        },
        mounted: function () {
            console.log('Mountd chỉnh sửa');
            this.ganDuLieuSME();
            this.mapToIntThongTinHocSinh();
            this.getDanhSachTinh();
            // $(this.$refs.modal_info_teacher).on("hidden.bs.modal", this.close);
        },
        components: {
            DatePicker
        },
        methods: {
            chonNoiChuyenDi() {
                console.log('chonNoiChuyenDi')
                this.danh_sach_huyen_chuyen_di = []
                console.log(this.info.noiChuyenDi)
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
            chonChuyenDenTuTinh() {
                console.log('chonChuyenDenTuTinh')
                this.info.chuyenDenTuQuanHuyen = ''
                console.log(this.info.chuyenDenTuTinh)
                if (this.info.chuyenDenTuTinh) {
                    this.layHuyen(this.info.chuyenDenTuTinh, 'den');
                }
            },
            validateMoetCode(rule, value, callback) {
                // Kiểm tra độ dài và không có chữ cái

                if (!value) {
                    return callback(); // Không có lỗi
                }
                const isValidLength = value.length === 10;
                const hasNoLetters = /^[^a-zA-Z]*$/.test(value);
                if (!isValidLength) {
                    callback(new Error('Mã định danh bao gồm 10 chữ số.'));
                } else if (!hasNoLetters) {
                    callback(new Error('Vui lòng không nhập chữ cái.'));
                } else {
                    callback(); // Không có lỗi
                }
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
            disableInvalidDates(date) {
                const today = new Date();
                const selected = new Date(date);
                return selected > today; // Vô hiệu hóa các ngày sau ngày hôm nay
            },
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.update();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            handleClose() {
                if (this.check_confirm_come_back) {
                    this.$confirm(
                            'Các thông tin vừa nhập sẽ bị mất khi đóng trang. Thầy cô có muốn tiếp tục chỉnh sửa, kiểm tra và lưu lại thông tin đã nhập?',
                            'Thông báo', {
                                confirmButtonText: 'Rời khỏi trang',
                                cancelButtonText: 'Tiếp tục chỉnh sửa',
                                confirmButtonClass: 'el-button--danger',
                                closeOnClickModal: false,
                            })
                        .then(_ => {
                            this.close()
                            // $('#modal_info_teacher').modal('hide');
                        })
                        .catch(_ => {});
                } else {

                    this.close()
                    // $('#modal_info_teacher').modal('hide');
                }
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
                console.log("gab dux lieu sme")
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
                    this.danh_sach_chuyen_di = JSON.parse(localStorage["danh_sach_chuyen_di_sme"]);
                    this.list_nhom_tuoi_mam_non = JSON.parse(localStorage["danh_sach_nhom_tuoi_mam_non_sme"]);
                    this.list_ly_do_thoi_hoc = JSON.parse(localStorage["danh_sach_ly_do_thoi_hoc_sme"]);
                }
                console.log(this.danh_sach_chuyen_di);
            },
            mapToIntThongTinHocSinh() {
                console.log("map it tths");
                for (let i = 0; i < this.list_loai_nhap_hoc.length; i++) {
                    if (this.list_loai_nhap_hoc[i].value) {
                        this.list_loai_nhap_hoc[i].value = parseInt(this.list_loai_nhap_hoc[i].value)
                    }
                }
                for (let i = 0; i < this.list_nhommau.length; i++) {
                    if (this.list_nhommau[i].value) {
                        this.list_nhommau[i].value = parseInt(this.list_nhommau[i].value)
                    }
                }
                for (let i = 0; i < this.list_tpgd.length; i++) {
                    if (this.list_tpgd[i].value) {
                        this.list_tpgd[i].value = parseInt(this.list_tpgd[i].value)
                    }
                }
                for (let i = 0; i < this.list_dtut.length; i++) {
                    if (this.list_dtut[i].value) {
                        this.list_dtut[i].value = parseInt(this.list_dtut[i].value)
                    }
                }
            },
            anPhim(e) {
                console.log("ấn phím" + e);
            },
            chonDanToc() {
                this.check_confirm_come_back = true;
                console.log(this.list_dantoc)
                let result = this.list_dantoc.filter(obj => {
                    return obj.value === this.info.maDanToc;
                })
                this.dataFill.maDanToc = result.length ? result[0].label : ''
                //set lại validate
                this.$refs.info.validateField('soCmnd');
                console.log(this.dataFill)
            },
            chonQuocTich() {
                this.check_confirm_come_back = true;
                console.log(this.list_quoctich)
                let result = this.list_quoctich.filter(obj => {
                    return obj.value === this.info.maQuocTich;
                })
                this.dataFill.maQuocTich = result.length ? result[0].label : ''
                //set lại validate
                console.log(this.dataFill)
            },
            chonTrangThai() {
                this.check_confirm_come_back = true;
                let result = this.list_tt_hs.filter(obj => {
                    return obj.value === this.info.trangThai;
                })
                this.dataFill.trangThai = result.length ? result[0].name : ''
                console.log(this.dataFill)
            },
            //start data fill
            chonGioiTinh() {
                this.check_confirm_come_back = true;
                if (this.info.gioiTinh == 1) {
                    this.dataFill.gioiTinh = 'Nam'
                } else {
                    this.dataFill.gioiTinh = 'Nữ'
                }
                console.log(this.dataFill)
            },
            chonNgaySinh() {
                this.check_confirm_come_back = true;
                this.dataFill.ngaySinh = this.info.ngaySinh;
                console.log(this.dataFill)
            },
            nhapDcThuongTru() {
                this.check_confirm_come_back = true;
                this.dataFill.dchiThtru = this.info.dchiThtru;
                console.log(this.dataFill)
            },
            nhapChoOHienNay() {
                this.check_confirm_come_back = true;
                this.dataFill.dchiTmtru = this.info.dchiTmtru;
                console.log(this.dataFill)
            },
            nhapQueQuan() {
                this.check_confirm_come_back = true;
                this.dataFill.queQuan = this.info.queQuan;
                console.log(this.dataFill)
            },
            nhapNoiSinh() {
                this.check_confirm_come_back = true;
                this.dataFill.noiSinh = this.info.noiSinh;
                console.log(this.dataFill)
            },
            nhapHoTen() {
                this.check_confirm_come_back = true;
                this.dataFill.hoTen = this.info.hoTen.trim();
                console.log(this.dataFill)
            },
            //end datafill
            chonLopHoc() {
                this.check_confirm_come_back = true;
                console.log("Chọn lớp học");
                this.info.maLopHocDn = this.info.maLopHocCn;
                console.log(JSON.stringify(this.info.maLopHocDn));
                let result = this.list_lop_hoc.filter(obj => {
                    return obj.value === this.info.maLopHocCn;
                })
                this.dataFill.tenLopHoc = result.length ? result[0].name : ''
                console.log(this.dataFill)
            },
            ChonNgaySinhMe() {
                this.check_confirm_come_back = true;
                let d = this.info.ngaySinhMe.slice(-4, 10);
                this.info.namSinhMe = d;
            },
            ChonNgaySinhBo() {
                this.check_confirm_come_back = true;
                console.log("Chọn ngày sinh bố:")
                console.log(this.info.ngaySinhBo)
                let d = this.info.ngaySinhBo.slice(-4, 10);
                this.info.namSinhBo = d;
            },
            ChonNgaySinhNGH() {
                this.check_confirm_come_back = true;
                let d = this.info.ngaySinhNguoiGiamHo.slice(-4, 10);
                this.info.namSinhNguoiGiamHo = d;
            },
            chonKhoiHoc() {
                this.check_confirm_come_back = true;
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
            chonNhomTuoi() {
                this.check_confirm_come_back = true;
                this.info.maLopHocCn = "";
                this.list_lop_hoc = [{
                    name: "chọn",
                    value: ""
                }];
                this.getDanhSachLop();
            },
            chonHocSinhBanTruDanNuoi() {
                this.check_confirm_come_back = true;
                if (this.info.hocSinhBanTruDanNuoi) {
                    this.info.hocSinhNoiTruDanNuoi = false;
                    this.info.hocSinhBanTru = false;
                    this.info.hocSinhNoiTru = false;
                    this.info.hocSinhPtdtBanTru = false;
                }
            },
            chonHocSinhNoiTruDanNuoi() {
                this.check_confirm_come_back = true;
                if (this.info.hocSinhNoiTruDanNuoi) {
                    this.info.hocSinhBanTruDanNuoi = false;
                    this.info.hocSinhBanTru = false;
                    this.info.hocSinhNoiTru = false;
                    this.info.hocSinhPtdtBanTru = false;
                }
            },
            chonHocSinhBanTru() {
                this.check_confirm_come_back = true;
                if (this.info.hocSinhBanTru) {
                    this.info.hocSinhBanTruDanNuoi = false;
                    this.info.hocSinhNoiTruDanNuoi = false;
                    this.info.hocSinhNoiTru = false;
                    this.info.hocSinhPtdtBanTru = false;
                }
            },
            chonHocSinhNoiTru() {
                this.check_confirm_come_back = true;
                if (this.info.hocSinhNoiTru) {
                    this.info.hocSinhBanTruDanNuoi = false;
                    this.info.hocSinhNoiTruDanNuoi = false;
                    this.info.hocSinhBanTru = false;
                    this.info.hocSinhPtdtBanTru = false;
                }
            },
            chonHocSinhPtdtBanTru() {
                this.check_confirm_come_back = true;
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
                this.check_confirm_come_back = false;
                this.$emit('close');
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
                    this.scrollToElement();
                    console.log(JSON.stringify(data.data));
                    if (data.data != null) {

                        this.info = data.data;
                        this.info.dchiTmtru = this.info.dchiThtru ?? (this.info.dchiTmtru ?? '')
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
                        if (this.info.chuyenDiDenTinh) {
                            this.layHuyen(this.info.chuyenDiDenTinh, 'den');
                        }
                        if (this.info.chuyenDenTuTinh) {
                            this.layHuyen(this.info.chuyenDenTuTinh, 'di');
                        }

                    } else {
                        utils.showDialog(
                            "Thông báo",
                            "Đã xảy ra lỗi trong quá trình lấy dữ liệu. Vui lòng thử lại.",
                            null,
                            () => {}
                        );
                    }
                    loading.close();
                });
            },
            layHuyen(tinh, loai) {
                console.log('layHuyen');
                console.log('Lấy huyện chuyển ', loai);

                let params = {
                    "start": 0,
                    "limit": 9999,
                    "ma": '',
                    "ten": '',
                    "maTinhThanh": tinh ?? this.info?.syncMaSoGd,
                    "trangthai": 1,
                    "check": false,
                    "namHoc": this.info.namHoc
                };
                if (loai == 'den') {
                    params.check = false
                }
                console.log("lấy ds quận huyện:");
                console.log(params);
                // this.danh_sach_huyen_chuyen_di = [];
                // this.danh_sach_huyen_chuyen_den = [];
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, response => {
                    console.log('Lấy huyện trả về');
                    console.log(response);
                    if (response.data.code == 200) {
                        let du_lieu = response.data.rows;
                        //xoa bỏ các phần tử có maQuanHuyen trùng nhau
                        du_lieu = du_lieu.filter((item, index, self) =>
                            index === self.findIndex((t) => t.maQuanHuyen === item.maQuanHuyen)
                        );
                        if (loai == 'den') {
                            this.danh_sach_huyen_chuyen_di = du_lieu;
                        } else {
                            this.danh_sach_huyen_chuyen_den = du_lieu;
                        }
                    } else {
                        this.thongBao('error', response.data.rd);
                    }
                    console.log('danh_sach_huyen_chuyen_den');
                    console.log(this.danh_sach_huyen_chuyen_den);
                    console.log('danh_sach_huyen_chuyen_di');
                    console.log(this.danh_sach_huyen_chuyen_di);
                });
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
                // if (this.info.capHoc == 3 || this.info.capHoc == 2) {
                if (this.info?.maDanToc != 55) {
                    if (this.info?.soCmnd == null || this.info?.soCmnd == "") {
                        // this.thongBao('error', "Thiếu CMTND/TCC");
                        // return;
                    } else {
                        if (this.info?.soCmnd?.length != 12 && this.info?.soCmnd?.length != 9) {
                            this.thongBao('error', "CMTND/TCC gồm 9 hoặc 12 số");
                            return;
                        }
                    }
                }
                // }
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

                this.$confirm('Xác nhận chỉnh sửa dữ liệu?', 'Thông báo', {
                        confirmButtonText: 'Lưu',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
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
                                this.$alertify.success("Chỉnh sửa thông tin học sinh thành công");
                                let dt = this.info.maHocSinh;
                                console.log('DataFill:')
                                console.log(this.dataFill)
                                this.dataFill.maHocSinh = this.info.maHocSinh;
                                this.$emit('success', this.dataFill);
                            } else {
                                // utils.showDialog("Thất bại", data.data.message, null, () => {
                                // });
                                this.thongBao('error', data.data.rd);
                            }
                        });
                    })
                    .catch(_ => {});
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




    .cg {
        text-align: center;
    }

    .bt>a>b>i {
        color: #DC0101;
        border: 1px solid black;
        padding: 5px 6px;
        border-radius: 23%;
    }

    .el-textarea.is-disabled .el-textarea__inner {
        background-color: #eee !important;
        color: black !important;
        border-color: #dcdfe6 !important;
    }

</style>

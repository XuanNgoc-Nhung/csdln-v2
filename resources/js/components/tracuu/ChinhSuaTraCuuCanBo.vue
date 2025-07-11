<template>
    <div>
        <el-dialog title="Chỉnh sửa hồ sơ cán bộ" :visible.sync="show" top="5vh" width="90%"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
            <el-form :model='thongtin_giaovien' :rules="rules" ref="ruleForm">
                <el-row :gutter="24">
                    <el-col :span="4">
                        <div class="thumbnail" style="text-align:center;">
                            <div v-if="thongtin_giaovien.avatar">
                                <img style="width: 100%;max-width: 250px;height: auto" :src="thongtin_giaovien.avatar" width="100%" alt="hình ảnh cán bộ, giáo viên" />
                            </div>
                            <div v-else>
                                <img style="width: 100%;max-width: 250px;height: auto" src="https://www.drupal.org/files/issues/default-avatar.png" width="120px"
                                    height="150px;" alt="" />
                            </div>
                            <div>
                                <p class="moet-code">Mã định danh bộ GD&ĐT:
                                    <span class="d-block">{{ thongtin_giaovien.moetCode }}</span>
                                </p>
                            </div>
                        </div>
                    </el-col>
                    <el-col :span="20">
                        <div class="row mt-0">
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Họ tên <span style="color:#DC0101">*</span></label>
                                    <el-form-item prop="tenGiaoVien">
                                        <el-input
                                                @change="check_confirm_come_back = true;thongtin_giaovien.tenGiaoVien = thongtin_giaovien.tenGiaoVien.trim()"
                                                clearable placeholder="Nhập..." ref="tenGiaoVien"
                                                v-model="thongtin_giaovien.tenGiaoVien" />
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Ngày sinh <span style="color:#DC0101">*</span></label>
                                    <el-form-item prop="ngaySinh">
                                        <date-picker style="width:100%" v-model="thongtin_giaovien.ngaySinh"
                                                     ref="ngaySinh" @change="ChonNgaySinh" placeholder="Chọn ngày"
                                                     valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                        </date-picker>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Giới tính </label>
                                    <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%"
                                             collapseTags v-model="thongtin_giaovien.gioiTinh" filterable
                                             :data="list_gioi_tinh" :fields="['name','value']" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Trạng thái CB <span style="color:#DC0101">*</span></label>
                                    <el-form-item prop="trangThai">
                                        <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%"
                                                 collapseTags ref="trangThai" v-model="thongtin_giaovien.trangThai"
                                                 filterable :data="list_trang_thai_can_bo" :fields="['name','value']" />
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Ngày trạng thái <span style="color:#DC0101">*</span></label>
                                    <el-form-item prop="ngayTrangThai">
                                        <date-picker style="width:100%" v-model="thongtin_giaovien.ngayTrangThai"
                                                     placeholder="Chọn ngày" valueType="format" value-type="DD/MM/YYYY"
                                                     format="DD/MM/YYYY">
                                        </date-picker>
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group" v-if="thongtin_giaovien.trangThai==8">
                                <div >
                                    <label class="typo__label">Lý do thôi việc <span style="color:#DC0101">*</span></label>
                                    <el-form-item prop="lyDoNghiViec">
                                        <el-input
                                                @change="check_confirm_come_back = true;thongtin_giaovien.lyDoNghiViec = thongtin_giaovien.lyDoNghiViec.trim()"
                                                clearable placeholder="Nhập..." type="text" ref="lyDoNghiViec"
                                                v-model="thongtin_giaovien.lyDoNghiViec" />
                                    </el-form-item>
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">CMTND/TCC <span style="color:#DC0101">*</span></label>
                                    <el-form-item prop="soCmnd">
                                        <el-input
                                                @change="check_confirm_come_back = true;thongtin_giaovien.soCmnd = thongtin_giaovien.soCmnd.trim()"
                                                clearable placeholder="Nhập..." type="number" ref="soCmnd"
                                                v-model="thongtin_giaovien.soCmnd" />
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Ngày cấp CMTND/TCC</label>
                                    <date-picker style="width:100%" v-model="thongtin_giaovien.ngayCapCmnd"
                                                 placeholder="Chọn ngày" valueType="format" value-type="DD/MM/YYYY"
                                                 format="DD/MM/YYYY">
                                    </date-picker>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Email</label>
                                    <el-input
                                            @change="check_confirm_come_back = true;thongtin_giaovien.email = thongtin_giaovien.email.trim()"
                                            clearable placeholder="Nhập..." v-model="thongtin_giaovien.email" />
                                </div>
                            </div>
                            <div v-if="(thongtin.ma_so==36)||(thongtin.role==2&&thongtin.ma_so==19)" class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Số điện thoại</label>
                                    <el-input
                                            @change="check_confirm_come_back = true;thongtin_giaovien.soDienThoai= thongtin_giaovien.soDienThoai.trim()"
                                            clearable placeholder="Nhập..." v-model="thongtin_giaovien.soDienThoai" />
                                </div>
                            </div>

                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Mã định danh bộ GD&ĐT</label>
                                </div>
                                <div >
                                    <el-form-item prop="moetCode">
                                        <el-input
                                                @change="check_confirm_come_back = true;thongtin_giaovien.moetCode = thongtin_giaovien.moetCode.trim()"
                                                clearable placeholder="Nhập..."
                                                v-model.trim="thongtin_giaovien.moetCode" />
                                    </el-form-item>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Mã cán bộ</label>
                                </div>
                                <div >
                                    <el-input
                                            @change="check_confirm_come_back = true;thongtin_giaovien.maGiaoVien = thongtin_giaovien.maGiaoVien.trim()"
                                            clearable placeholder="Nhập..." disabled
                                            v-model="thongtin_giaovien.maGiaoVien" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Dân tộc</label>
                                </div>
                                <div >
                                    <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%"
                                             collapseTags v-model="thongtin_giaovien.maDanToc" filterable
                                             :data="list_dantoc" :fields="['name','value']" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Tôn giáo</label>
                                </div>
                                <div >
                                    <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%"
                                             collapseTags v-model="thongtin_giaovien.maTonGiao" filterable
                                             :data="list_ton_giao" :fields="['name','value']" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group">
                                <div >
                                    <label class="typo__label">Số sổ BHXH</label>
                                </div>
                                <div >
                                    <el-input
                                            @change="check_confirm_come_back = true;thongtin_giaovien.soSoBhxh = thongtin_giaovien.soSoBhxh.trim()"
                                            clearable placeholder="Nhập..." v-model="thongtin_giaovien.soSoBhxh" />
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-md-4 form-group" style="display:block">
                                <div >
                                    <label class="typo__label">Nơi sinh</label>
                                </div>
                                <div >
            <textarea
                    @change="check_confirm_come_back = true;thongtin_giaovien.noiSinh = thongtin_giaovien.noiSinh.trim()"
                    class="form-control" v-model="thongtin_giaovien.noiSinh"
                    rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-4 form-group" style="display:block">
                                <div >
                                    <label class="typo__label">Quê quán</label>
                                </div>
                                <div >
            <textarea
                    @change="check_confirm_come_back = true;thongtin_giaovien.queQuan = thongtin_giaovien.queQuan.trim()"
                    class="form-control" v-model="thongtin_giaovien.queQuan"
                    rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-12 col-md-12">
                                <div class="">

                                    <label class="typo__label" style="">
                                        <input type="checkbox" v-model="thongtin_giaovien.tuyenMoi" />

                                        Là tuyển mới</label>

                                </div>
                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <div class="">
                                    <label class="typo__label">
                                        <input type="checkbox" v-model="thongtin_giaovien.doanVien" />
                                        Đoàn viên</label>

                                </div>

                            </div>
                            <div class="form-group col-sm-12 col-md-12">
                                <label class="typo__label">
                                    <input type="checkbox" v-model="thongtin_giaovien.dangVien" />
                                    Đảng viên</label>

                            </div>
                        </div>

                    </el-col>
                    <el-col :span="24">
                        <hr style="margin-top:0">
                        <el-tabs type="border-card2 " v-model="activeName">
                            <el-tab-pane>
                                <span slot="label">1. Vị trí việc làm
                                    <span v-if="loiTab0">
                                        <i class="el-icon-warning" style="color:red"></i>
                                    </span>
                                </span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Cấp dạy</label>
                                            <el-form-item prop="capHoc">
                                                <eselect placeholder="Chọn" :disabled="thongtin.role!=5" style="width:100%" collapseTags ref="capHoc" v-model="thongtin_giaovien.capHoc" filterable :data="list_cap_hoc" :fields="['name','id']" />
                                            </el-form-item>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Loại cán bộ <span style="color:#DC0101">*</span></label>
                                            <el-form-item prop="loaiCanBo">
                                                <eselect placeholder="Chọn" @change="submitForm2('ruleForm')" style="width:100%" collapseTags ref="loaiCanBo" v-model="thongtin_giaovien.loaiCanBo" filterable :data="list_loai_can_bo" :fields="['name','value']" />
                                            </el-form-item>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Môn dạy</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.maMonHoc" filterable :data="list_mon_day" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Môn dạy kiêm nhiệm</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.monDayKiemNhiem" filterable :data="list_mon_day" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Nhóm chức vụ</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.chucVu" filterable :data="list_chuc_vu" :fields="['name','value']" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Ngày tuyển</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.tuyenMoi" filterable :data="list_co_khong" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Ngày tuyển</label>
                                            <date-picker style="width:100%" v-model="thongtin_giaovien.ngayTuyenDung" placeholder="Chọn ngày" valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                                            </date-picker>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Nhiệm vụ kiêm nhiệm</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.nhiemVuKiemNhiem" filterable :data="list_nhiem_vu_kiem_nhiem" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Số tiết thực dạy trên tuần</label>
                                        </div>
                                        <div class="">
                                            <el-input @change="check_confirm_come_back = true;thongtin_giaovien.soTietThucDay1Tuan = thongtin_giaovien.soTietThucDay1Tuan.trim()" type="text" clearable placeholder="Nhập..." v-model="thongtin_giaovien.soTietThucDay1Tuan" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Số tiết thực kiêm nhiệm/tuần</label>
                                        </div>
                                        <div class="">
                                            <el-input @change="check_confirm_come_back = true;thongtin_giaovien.soTietKiemNhiem1Tuan = thongtin_giaovien.soTietKiemNhiem1Tuan.trim()" type="text" placeholder="Nhập..." clearable v-model="thongtin_giaovien.soTietKiemNhiem1Tuan" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Hình thức hợp đồng <span style="color:#DC0101">*</span></label>
                                            <el-form-item prop="loaiHopDong">
                                                <eselect placeholder="Chọn" @change="submitForm2('ruleForm')" style="width:100%" collapseTags ref="loaiHopDong" v-model="thongtin_giaovien.loaiHopDong" filterable :data="list_hinh_thuc_hop_dong" :fields="['name','value']" />
                                            </el-form-item>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Cơ quan tuyển dụng</label>
                                            <el-input @change="check_confirm_come_back = true;thongtin_giaovien.coQuanTuyenDung = thongtin_giaovien.coQuanTuyenDung.trim()" type="text" clearable placeholder="Nhập..." v-model="thongtin_giaovien.coQuanTuyenDung" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Nghề nghiệp khi được tuyển dụng</label>
                                            <el-input @change="check_confirm_come_back = true;thongtin_giaovien.ngheNghiepTuyenDung = thongtin_giaovien.ngheNghiepTuyenDung.trim()" type="text" clearable placeholder="Nhập..." v-model="thongtin_giaovien.ngheNghiepTuyenDung" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Ngạch/Hạng</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.maNgach" filterable :data="list_ma_ngach_hang" :fields="['name','value']" />
                                        </div>
                                    </div>



                                </div>
                                <div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <input type="checkbox" v-model="thongtin_giaovien.tapHuanKnsSkss" />
                                            <label class="typo__label">Đã tập huấn dạy kỹ năng sống (HIV, SKSS...)</label>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <input type="checkbox" v-model="thongtin_giaovien.dayHsktHocHoaNhap" />
                                            <label class="typo__label">Dạy học sinh khuyết tật hòa nhập</label>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <input type="checkbox" @change="ChonDay1BuoiTrenNgay()" v-model="thongtin_giaovien.day1BuoiTrenNgay" />
                                            <label class="typo__label">Đang dạy 1 buổi/ngày</label>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <input type="checkbox" @change="ChonDay2BuoiTrenNgay()" v-model="thongtin_giaovien.day2BuoiTrenNgay" />
                                            <label class="typo__label">Đang dạy 2 buổi/ngày</label>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <input type="checkbox" v-model="thongtin_giaovien.thamGiaBdTxuyen" />
                                            <label class="typo__label">Tham gia chương trình bồi dưỡng thường xuyên</label>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            <input type="checkbox" v-model="thongtin_giaovien.coCcBdChucDanhNgheNghiep" />
                                            <label class="typo__label">Có CC bồi dưỡng TCCD</label>
                                        </div>
                                    </div>

                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="Config">
                                <span slot="label">2. Phụ cấp
                                    <span v-if="loiTab1">
                                        <i class="el-icon-warning" style="color:red"></i>
                                    </span>
                                </span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Bậc lương <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="submitForm2('ruleForm')" style="width:100%"
                                                     collapseTags v-model="thongtin_giaovien.bacLuong" filterable
                                                     :data="list_bac_luong" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Phần trăm vượt khung (%)</label>
                                        </div>
                                        <div class="">
                                            <el-input-number @change="check_confirm_come_back = true"
                                                             v-model="thongtin_giaovien.vuotKhung" controls-position="right"
                                                             :precision="2" :step="0.01" :max="100" :min="0">
                                            </el-input-number>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Hệ số lương <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div class="">
                                            <el-form-item prop="heSoLuong">
                                                <el-input-number @change="submitForm2('ruleForm')"
                                                                 v-model="thongtin_giaovien.heSoLuong" ref="heSoLuong"
                                                                 controls-position="right" :precision="2" :step="0.01" :max="100"
                                                                 :min="0">
                                                </el-input-number>
                                            </el-form-item>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Ngày hưởng</label>
                                        </div>
                                        <div class="">
                                            <date-picker style="width:100%" v-model="thongtin_giaovien.ngayHuong"
                                                         placeholder="Chọn ngày" valueType="format" value-type="DD/MM/YYYY"
                                                         format="DD/MM/YYYY">
                                            </date-picker>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Mức phụ cấp thu hút nghề (%)</label>
                                        </div>
                                        <div class="">
                                            <el-input-number @change="check_confirm_come_back = true"
                                                             v-model="thongtin_giaovien.mucPhuCapThuHut"
                                                             controls-position="right" :precision="2" :step="0.01" :max="100"
                                                             :min="0">
                                            </el-input-number>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Mức phụ cấp thâm niên (%)</label>
                                        </div>
                                        <div class="">
                                            <el-input-number @change="check_confirm_come_back = true"
                                                             v-model="thongtin_giaovien.mucPhuCapThamNien"
                                                             controls-position="right" :precision="2" :step="0.01" :max="100"
                                                             :min="0">
                                            </el-input-number>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Mức phụ cấp ưu đãi nghề (%)</label>
                                        </div>
                                        <div class="">
                                            <el-input-number disabled @change="check_confirm_come_back = true"
                                                             v-model="thongtin_giaovien.mucPhuCapUuDai" controls-position="right"
                                                             :precision="2" :step="0.01" :max="90" :min="0">
                                            </el-input-number>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Mức phụ cấp chức vụ lãnh đạo (%) <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div class="">
                                            <el-form-item prop="mucPhuCapLanhDao">
                                                <el-input-number @change="submitForm2('ruleForm')"
                                                                 ref="mucPhuCapLanhDao"
                                                                 v-model="thongtin_giaovien.mucPhuCapLanhDao"
                                                                 controls-position="right" :precision="2" :step="0.01" :max="100"
                                                                 :min="0">
                                                </el-input-number>
                                            </el-form-item>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-sm-6">
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Diễn biến quá trình lương</label>
                                            </div>
                                            <div class="col-md-12">
                                                <el-tooltip content="Chi tiết" placement="top">
                                                    <el-button plain size="mini" @click.prevent="dienBienQtLuong()"
                                                               type="primary" icon="el-icon-plus">Chi tiết
                                                    </el-button>
                                                </el-tooltip>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="Role">
                                <span slot="label">3. Đào tạo, bồi dưỡng
                                    <span v-if="loiTab2">
                                        <i class="el-icon-warning" style="color:red"></i>
                                    </span>
                                </span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Kết quả bồi dưỡng thường xuyên</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.kqBdTx" filterable :data="list_kqbd_tx" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Trình độ chuyên môn nghiệp vụ <span style="color:#DC0101">*</span></label>
                                            <el-form-item prop="trinhDoChuyenMonCaoNhat">
                                                <eselect placeholder="Chọn" @change="submitForm2('ruleForm')" style="width:100%" collapseTags ref="trinhDoChuyenMonCaoNhat" v-model="thongtin_giaovien.trinhDoChuyenMonCaoNhat" filterable :data="list_trinh_do_cm_nv" :fields="['name','value']" />
                                            </el-form-item>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Trình độ lý luận chính trị</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.trinhDoLyLuanChinhTri" filterable :data="list_trinh_do_llct" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Trình độ quản lý giáo dục</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.trinhDoQuanLyGiaoDuc" filterable :data="list_trinh_do_qlgd" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Tham gia bồi dưỡng nghiệp vụ quản lý giáo dục</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.maBoiDuongNvu" filterable :data="list_boi_duong_nvu" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Tham gia bồi dưỡng CBQL/GV cốt cán</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.maBoiDuongCbqlCotCan" filterable :data="list_boi_duong_cbqlcc" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Tham gia bồi dưỡng thay sách</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.maBoiDuongThaySach" filterable :data="list_boi_duong_thay_sach" :fields="['name','value']" />
                                        </div>
                                    </div>


                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Trình độ tin học</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.trinhDoTinHoc" filterable :data="list_trinh_do_th" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Chuyên ngành chính</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.chuyenNganhDaoTaoChinh" filterable :data="list_cn_dt_chinh" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Trình độ chính</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.trinhDoDaoTaoCnChinh" filterable :data="list_trinh_do_chinh" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Cơ sở đào tạo</label>
                                        </div>
                                        <div class="">
                                            <el-input @change="check_confirm_come_back = true;thongtin_giaovien.tenCsDaoTaoBd = thongtin_giaovien.tenCsDaoTaoBd.trim()" type="text" clearable placeholder="Nhập..." v-model="thongtin_giaovien.tenCsDaoTaoBd" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Chuyên ngành khác</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.chuyenNganhDaoTaoKhac" filterable :data="list_cn_dt_khac" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Trình độ khác</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.trinhDoDaoTaoCnKhac" filterable :data="list_trinh_do_khac" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Giáo viên có chứng chỉ tiếng dân tộc thiểu số</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.maChungChiTiengDtocTso" filterable :data="list_cc_tieng_dt_ts" :fields="['name','value']" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Ngoại ngữ chính</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.monNgoaiNguChinh" filterable :data="list_ngoai_ngu_chinh" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Trình độ đào tạo ngoại ngữ</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.trinhDoNgoaiNgu" filterable :data="list_trinh_do_nn" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Nhóm chứng chỉ ngoại ngữ</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.maNhomCchiNngu" filterable :data="list_nhom_cc_nn" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Loại chứng chỉ ngoại ngữ</label>
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.maLoaiCchiNngu" filterable :data="list_loai_cc_nn" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Khung năng lực ngoại ngữ</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%" collapseTags v-model="thongtin_giaovien.maKhungNlucNngu" filterable :data="list_khung_nl_nn" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Điểm ngoại ngữ</label>
                                        </div>
                                       <div class="row">
                                           <div class="col-sm-7">
                                               <el-input @change="check_confirm_come_back = true" type="number" clearable placeholder="Nhập..." v-model="thongtin_giaovien.diemNgoaiNgu" />
                                           </div>
                                           <div class="col-sm-5">
                                               <el-tooltip content="Chi tiết" placement="top">
                                                   <el-button plain size="mini" @click.prevent="viewDaoTaoNn()" type="primary" icon="el-icon-plus">Chi tiết</el-button>
                                               </el-tooltip>
                                           </div>
                                       </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Quá trình đào tạo bồi dưỡng</label>
                                        </div>
                                        <div class="">
                                            <el-tooltip content="Chi tiết" placement="top">
                                                <el-button plain size="mini" @click.prevent="viewNangLuc(list_qua_trinh_dtbd)" type="primary" icon="el-icon-plus">Chi tiết</el-button>
                                            </el-tooltip>
                                        </div>
                                    </div>


                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="Role">
                                <span slot="label">4. Đánh giá, phân loại</span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Đánh giá viên chức/ công chức</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%"
                                                     collapseTags v-model="thongtin_giaovien.danhGiaVienChuc" filterable
                                                     :data="list_danh_gia_vien_chuc" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Tự đánh giá chuẩn nghề nghiệp</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%"
                                                     collapseTags v-model="thongtin_giaovien.tuDanhGiaKqChuanNgheNghiep"
                                                     filterable :data="list_danh_gia" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Cấp trên đánh giá chuẩn nghề nghiệp</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%"
                                                     collapseTags v-model="thongtin_giaovien.dgKqChuanNgheNghiep"
                                                     filterable :data="list_danh_gia" :fields="['name','value']" />
                                        </div>
                                    </div>


                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Giáo viên dạy giỏi</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%"
                                                     collapseTags v-model="thongtin_giaovien.gvDayGioi" filterable
                                                     :data="list_gv_day_gioi" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Giáo viên chủ nhiệm giỏi</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%"
                                                     collapseTags v-model="thongtin_giaovien.maGiaoVienChuNhiemGioi"
                                                     filterable :data="list_gv_cn_gioi" :fields="['name','value']" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Tổng phụ trách Đội giỏi</label>
                                        </div>
                                        <div class="">
                                            <eselect placeholder="Chọn" @change="check_confirm_come_back = true" style="width:100%"
                                                     collapseTags v-model="thongtin_giaovien.maGvTongPtrachDoiGioi"
                                                     filterable :data="list_tong_pt_gioi" :fields="['name','value']" />
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Danh hiệu phong tặng</label>
                                        </div>
                                        <div class="">
                                            <el-input
                                                    @change="check_confirm_come_back = true;thongtin_giaovien.danhHieuPhongTang = thongtin_giaovien.danhHieuPhongTang.trim()"
                                                    type="text" placeholder="Nhập..." clearable
                                                    v-model="thongtin_giaovien.danhHieuPhongTang" />
                                        </div>
                                    </div>


                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Đánh giá chuẩn nghề nghiệp CBQL/GV</label>
                                        </div>
                                        <div class="">
                                            <el-tooltip content="Chi tiết" placement="top">
                                                <el-button plain size="mini" @click.prevent="viewDanhGiaKqChuanNn()"
                                                           type="primary" icon="el-icon-plus">Chi tiết
                                                </el-button>
                                            </el-tooltip>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Khen thưởng</label>
                                        </div>
                                        <div class="">
                                            <el-tooltip content="Chi tiết" placement="right">
                                                <el-button plain size="mini" @click.prevent="chiTietKhenThuong()"
                                                           type="primary" icon="el-icon-plus">Chi tiết
                                                </el-button>
                                            </el-tooltip>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div class="">
                                            <label class="typo__label">Kỷ luật</label>
                                        </div>
                                        <div class="">
                                            <el-tooltip content="Chi tiết" placement="right">
                                                <el-button plain size="mini" @click.prevent="chiTietKyLuat()"
                                                           type="primary" icon="el-icon-plus">Chi tiết
                                                </el-button>
                                            </el-tooltip>
                                        </div>
                                    </div>
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                    </el-col>
                    <template>
                        <info-luong :show="show_qua_trinh_luong" :item="qua_trinh_luong"
                            @success="onUpdatedDataQtLuong($event)" @close="onCloseQtLuong($event)"></info-luong>
                        <info-dt-nn :show="show_dao_tao_nn" :item="list_dao_tao_ngoai_ngu"
                            @success="onUpdatedDataNgoaiNgu($event)" @close="onCloseNgoaiNgu($event)"></info-dt-nn>
                        <info-qtbd :show="show_qt_bd" :item="listQuaTrinhDtBd" @success="onUpdatedDataQtbd($event)"
                            @close="onCloseQtbd($event)">
                        </info-qtbd>
                        <info-khen-thuong :show="show_chi_tiet_khen_thuong" :item="list_khen_thuong"
                            @success="onUpdatedDataQtKhenThuong($event)" @close="onCloseQtKhenThuong($event)">
                        </info-khen-thuong>
                        <info-ky-luat :show="show_chi_tiet_ky_luat" :item="list_ky_luat"
                            @success="onUpdatedDataQtKyLuat($event)" @close="onCloseQtKyLuat($event)"></info-ky-luat>
                        <el-dialog
                            :title="'Đánh giá chuẩn nghề nghiệp' + thongtin_giaovien.tenGiaoVien + ' - ['+thongtin_giaovien.ngaySinh + ']' "
                            :visible.sync="update_modal_danh_gia_chuan_nghe_nghiep_gv" top="5vh" width="80%"
                            :close-on-click-modal="false" append-to-body :close-on-press-escape="false"
                            :before-close="handleClose">
                            <form>
                                <el-row :gutter="24">
                                    <el-col :span="24">

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
                                                        <p>{{ i + 1 }}</p>
                                                    </td>
                                                    <td>
                                                        <p>Tiêu chí {{ item.maTieuChi }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ item.noiDungDanhGia }}</p>
                                                    </td>
                                                    <td>
                                                        <el-select v-model="item.tuDanhGia" style="min-width:200px"
                                                            filterable collapse-tags placeholder="Chọn"
                                                            no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item,i) in  list_danh_gia" :key="i"
                                                                :label="item.name" :value="item.value">
                                                            </el-option>
                                                        </el-select>
                                                    </td>
                                                    <td>
                                                        <el-select v-model="item.capTrenDanhGia" style="min-width:200px"
                                                            filterable collapse-tags placeholder="Chọn"
                                                            no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item,i) in  list_danh_gia" :key="i"
                                                                :label="item.name" :value="item.value">
                                                            </el-option>
                                                        </el-select>
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
                                    </el-col>
                                </el-row>
                            </form>
                            <span slot="footer" class="dialog-footer">
                                <!-- <el-button class="bt-phu" type="default" @click="resetChuanNn" size="mini">Đặt lại
                                </el-button> -->
                                <el-button class="bt-chinh" size="mini" type="default"
                                    @click.prevent="update_modal_danh_gia_chuan_nghe_nghiep_gv=false">
                                    Đóng</el-button>
                            </span>
                        </el-dialog>
                    </template>
                </el-row>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="default" style="margin-right:5px" @click.prevent="handleClose()">Đóng
                </el-button>
                <el-button type="primary" size="mini" @click.prevent="submitForm('ruleForm')">Lưu
                </el-button>
            </span>
        </el-dialog>
        <!-- div modal -->
        <div>
            <!-- <div v-if="show_qt_bd&&false">
                <info-qtbd :item="listQuaTrinhDtBd" @success="onUpdatedDataQtbd($event)" @close="onCloseQtbd($event)">
                </info-qtbd>
            </div> -->
            <!-- <div v-if="show_qua_trinh_luong">
                <info-luong :item="qua_trinh_luong" @success="onUpdatedDataQtLuong($event)"
                    @close="onCloseQtLuong($event)"></info-luong>
            </div> -->
            <!-- <div v-if="show_chi_tiet_khen_thuong">
                <info-khen-thuong :item="list_khen_thuong" @success="onUpdatedDataQtKhenThuong($event)"
                    @close="onCloseQtKhenThuong($event)"></info-khen-thuong>
            </div> -->
            <!-- <div v-if="show_chi_tiet_ky_luat">
                <info-ky-luat :item="list_ky_luat" @success="onUpdatedDataQtKyLuat($event)"
                    @close="onCloseQtKyLuat($event)"></info-ky-luat>
            </div> -->
            <!-- <div v-if="false&&show_dao_tao_nn">
                <info-dt-nn :item="list_dao_tao_ngoai_ngu" @success="onUpdatedDataNgoaiNgu($event)"
                    @close="onCloseNgoaiNgu($event)"></info-dt-nn> -->
            <!-- </div> -->
        </div>
        <!-- end div -->
    </div>
</template>
<script>
    import moment from 'moment'
    import utils from '../../utils'
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import rest_api from '../../utils/rest_api';
    // import ThongTinQtLuong from './quaTrinhLuong'
    // import ThongTinDaoTaoNgoaiNgu from './GiaoVienThongTinDaoTaoNn'
    // import ThongTinQtBd from './quaTrinhBoiDuongNangCaoNangLuc'
    // import ThongTinKhenThuong from './GiaoVienThongTinKhenThuong'
    // import ThongTinKyLuat from './GiaoVienThongTinKyLuat'

    import ESelectVue from '../ui/ESelect.vue';
    import ThongTinQtLuong from './CanBoGiaoVien/ChinhSuaThongTinQuatTrinhLuong'
    import ThongTinDaoTaoNgoaiNgu from './CanBoGiaoVien/ChinhSuaThongTinDaoTaoNgoaiNgu'
    import ThongTinQtBd from './CanBoGiaoVien/ChinhSuaquaTrinhBoiDuongNangCaoNangLuc'
    import ThongTinKhenThuong from './CanBoGiaoVien/ChinhSuaQuaTrinhKhenThuong'
    import ThongTinKyLuat from './CanBoGiaoVien/ChinhSuaQuaTrinhKyLuat'

    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
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
            'item', 'show'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.getThongTinGiaoVien(this.item);
                    $("#modal_update_teacher").modal();
                } else {
                    this.resetForm('ruleForm')
                    $("#modal_update_teacher").modal('hide');
                }
            },
        },
        data() {
            return {
                check_confirm_come_back: false,
                fullScreenLoading: false,
                thongtin: JSON.parse(window.userInfo),
                listQuaTrinhDtBd: {},
                show_qt_bd: false,
                show_qua_trinh_luong: false,
                show_chi_tiet_khen_thuong: false,
                show_chi_tiet_ky_luat: false,
                show_dao_tao_nn: false,
                configDate: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                thongtin_giaovien: {},
                activeName: 0,
                loiTab0: false,
                loiTab1: false,
                loiTab2: false,
                rules: {
                    tenGiaoVien: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    ngaySinh: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    trinhDoChuyenMonCaoNhat: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    mucPhuCapLanhDao: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    loaiHopDong: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    loaiCanBo: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    lyDoNghiViec: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    soCmnd: [{
                            pattern: /^\d+$/,
                            message: 'Vui lòng nhập đúng định dạng',
                            trigger: ['blur', 'change']
                        },
                        {
                            pattern: /^\d{9}(?:\d{3})?$/,
                            message: 'Số CMND/CCCD có 9 hoặc 12 số',
                            trigger: ['blur', 'change']
                        }, {
                            required: true,
                            message: 'Vui lòng nhập thông tin',
                            trigger: 'change'
                        },
                    ],
                    heSoLuong: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    bacLuong: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],

                    moetCode: [{
                        validator: this.validateMoetCode,
                        trigger: ['blur', 'change']
                    }],
                    trangThai: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    ngayTrangThai: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],


                },
                qua_trinh_luong: [],
                qua_trinh_luong_old: [],
                list_khen_thuong: [],
                list_khen_thuong_old: [],
                list_ky_luat: [],
                list_ky_luat_old: [],
                list_dao_tao_ngoai_ngu: [],
                list_dao_tao_ngoai_ngu_old: [],
                qua_trinh_sp: [],
                qua_trinh_sp_old: [],
                qua_trinh_nn: [],
                qua_trinh_nn_old: [],
                list_dg_chuan_nn: [],
                list_qua_trinh_dtbd: [],
                list_qua_trinh_dtbd_old: [],
                list_tieu_chi: [{
                    name: "Chọn",
                    value: ""
                }],
                list_gioi_tinh: [{
                        name: 'Nam',
                        value: 1
                    },
                    {
                        name: 'Nữ',
                        value: 0
                    },
                ],
                list_ton_giao: [],
                list_dantoc: [],
                list_trang_thai_can_bo: [],
                list_loai_can_bo: [],
                list_cap_hoc: window.listCapHoc,
                list_mon_day: [],
                list_chuc_vu: [],
                list_hinh_thuc_hop_dong: [],
                list_co_khong: [{
                        name: 'Có',
                        value: true
                    },
                    {
                        name: 'Không',
                        value: false
                    },
                ],
                list_nhiem_vu_kiem_nhiem: [],
                list_ma_ngach_hang: [],
                list_kqbd_tx: [],
                list_trinh_do_cm_nv: [],
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
                list_danh_gia: [],
                update_modal_danh_gia_chuan_nghe_nghiep_gv: false,
                // *****
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            this.mapToIntTrangThaiCanBo();
            $(this.$refs.modal_update_teacher).on("hidden.bs.modal", this.close);
            // $(this.$refs.update_modal_danh_gia_chuan_nghe_nghiep_gv).on("hidden.bs.modal", this.closemodal2);
            $(this.$refs.modal_nl).on("hidden.bs.modal", this.closemodal3);
        },
        components: {
            DatePicker,
            'eselect': ESelectVue,
            'info-qtbd': ThongTinQtBd,
            'info-luong': ThongTinQtLuong,
            'info-khen-thuong': ThongTinKhenThuong,
            'info-ky-luat': ThongTinKyLuat,
            'info-dt-nn': ThongTinDaoTaoNgoaiNgu,
        },
        methods: {
            submitForm2(formName) {
                this.loiTab0 = false;
                this.loiTab1 = false;
                this.loiTab2 = false;
                this.check_confirm_come_back = true;
                console.log('submitForm')
                this.$refs[formName].validate((valid, object) => {
                    if (valid) {} else {
                        console.log('validate false');
                        let keys = Object.values(object)
                        console.log(keys)
                        let tabs0 = ['loaiCanBo', 'loaiHopDong'];
                        let tabs1 = ['mucPhuCapLanhDao', 'heSoLuong', 'bacLuong'];
                        let tabs2 = ['trinhDoChuyenMonCaoNhat'];
                        let tabs3 = ['trinhDoChuyenMonCaoNhat'];
                        for (let i = 0; i < keys.length; i++) {
                            console.log(keys[i]);
                            let fi = keys[i][0].field;
                            console.log(fi);

                            if (tabs0.includes(fi)) {
                                this.loiTab0 = true;
                            }
                            if (tabs1.includes(fi)) {
                                this.loiTab1 = true;
                            }
                            if (tabs2.includes(fi)) {
                                this.loiTab2 = true;
                            }
                        }
                    }
                });
            },

            validateMoetCode(rule, value, callback) {
                if (!value) {
                    return callback(); // Không có lỗi
                }
                // Kiểm tra độ dài và không có chữ cái
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
            submitForm(formName) {
                console.log('submitForm')
                this.loiTab0 = false;
                this.loiTab2 = false;
                this.$refs[formName].validate((valid, object) => {
                    if (valid) {
                        console.log('Validate success')
                        this.update();
                    } else {
                        console.log('validate false');
                        let keys = Object.values(object)
                        console.log(keys)
                        let tabs0 = ['loaiCanBo', 'loaiHopDong'];
                        let tabs2 = ['trinhDoChuyenMonCaoNhat'];
                        let tabs1 = ['mucPhuCapLanhDao', 'heSoLuong', 'bacLuong'];
                        for (let i = 0; i < keys.length; i++) {
                            console.log(keys[i]);
                            let fi = keys[i][0].field;
                            console.log(fi);

                            if (tabs0.includes(fi)) {
                                this.loiTab0 = true;
                            }
                            if (tabs1.includes(fi)) {
                                this.loiTab1 = true;
                            }
                            if (tabs2.includes(fi)) {
                                this.loiTab2 = true;
                            }
                        }
                        console.log(keys[0][0]);
                        let f = keys[0][0].field;
                        console.log(f);
                        if (f) {
                            setTimeout(() => this.$refs[f].focus(), 200);
                        }
                    }
                });
            },
            resetForm(formName) {
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
            },
            handleClose() {
                console.log('handleClose');
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
                            this.resetForm('ruleForm')
                            this.close();
                            // $("#modal_update_teacher").modal('hide')
                        })
                        .catch(_ => {});
                } else {
                    this.resetForm('ruleForm')
                    this.close();
                    // $("#modal_update_teacher").modal('hide')
                }
            },
            diChuyenDenDanhSach() {
                console.log("kéo lên đầu")
                const el = this.$refs.danhSachDuLieu;
                console.log(el)
                if (el) {
                    el.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            },

            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_ton_giao_sme"];
                if (tmp) {
                    this.list_ton_giao = JSON.parse(localStorage["danh_sach_ton_giao_sme"]);
                    this.list_dantoc = JSON.parse(localStorage["danh_sach_dan_toc_sme"]);
                    this.list_trang_thai_can_bo = JSON.parse(localStorage["danh_sach_trang_thai_can_bo_sme"]);
                    this.list_loai_can_bo = JSON.parse(localStorage["danh_sach_loai_can_bo_sme"]);
                    this.list_mon_day = JSON.parse(localStorage["danh_sach_mon_day_giao_vien_sme"]);
                    this.list_chuc_vu = JSON.parse(localStorage["danh_sach_chuc_vu_sme"]);
                    this.list_hinh_thuc_hop_dong = JSON.parse(localStorage["danh_sach_hinh_thuc_hop_dong_sme"]);
                    this.list_nhiem_vu_kiem_nhiem = JSON.parse(localStorage["danh_sach_nhiem_vu_kiem_nhiem_sme"]);
                    this.list_ma_ngach_hang = JSON.parse(localStorage["danh_sach_ngach_hang_sme"]);
                    this.list_kqbd_tx = JSON.parse(localStorage["danh_sach_ket_qua_boi_duong_thuong_xuyen_sme"]);
                    this.list_trinh_do_cm_nv = JSON.parse(localStorage["danh_sach_trinh_do_chuyen_mon_sme"]);
                    this.list_trinh_do_llct = JSON.parse(localStorage["danh_sach_trinh_do_ly_luan_chinh_tri_sme"]);
                    this.list_trinh_do_qlgd = JSON.parse(localStorage["danh_sach_trinh_do_quan_ly_giao_duc_sme"]);
                    this.list_boi_duong_nvu = JSON.parse(localStorage["danh_sach_boi_duong_nghiep_vu_sme"]);
                    this.list_boi_duong_cbqlcc = JSON.parse(localStorage["danh_sach_boi_duong_can_bo_cot_can_sme"]);
                    this.list_boi_duong_thay_sach = JSON.parse(localStorage["danh_sach_boi_duong_thay_sach_sme"]);
                    this.list_ngoai_ngu_chinh = JSON.parse(localStorage["danh_sach_ngoai_ngu_chinh_sme"]);
                    this.list_trinh_do_nn = JSON.parse(localStorage["danh_sach_trinh_do_ngoai_ngu_sme"]);
                    this.list_nhom_cc_nn = JSON.parse(localStorage["danh_sach_nhom_chung_chi_ngoai_ngu_sme"]);
                    this.list_loai_cc_nn = JSON.parse(localStorage["danh_sach_loai_chung_chi_ngoai_ngu_sme"]);
                    this.list_khung_nl_nn = JSON.parse(localStorage["danh_sach_khung_nang_luc_ngoai_ngu_sme"]);
                    this.list_trinh_do_th = JSON.parse(localStorage["danh_sach_trinh_do_tin_hoc_sme"]);
                    this.list_cn_dt_chinh = JSON.parse(localStorage["danh_sach_chuyen_nganh_dao_tao_chinh_sme"]);
                    this.list_trinh_do_chinh = JSON.parse(localStorage["danh_sach_trinh_do_chinh_sme"]);
                    this.list_cn_dt_khac = JSON.parse(localStorage["danh_sach_chuyen_nganh_dao_tao_khac_sme"]);
                    this.list_trinh_do_khac = JSON.parse(localStorage["danh_sach_trinh_do_khac_sme"]);
                    this.list_cc_tieng_dt_ts = JSON.parse(localStorage[
                        "danh_sach_chung_chi_tieng_dan_toc_thieu_so_sme"]);
                    this.list_danh_gia_vien_chuc = JSON.parse(localStorage["danh_sach_danh_gia_vien_chuc_sme"]);
                    this.list_gv_day_gioi = JSON.parse(localStorage["danh_sach_giao_vien_day_gioi_sme"]);
                    this.list_gv_cn_gioi = JSON.parse(localStorage["danh_sach_giao_vien_chu_nhiem_gioi_sme"]);
                    this.list_tong_pt_gioi = JSON.parse(localStorage["danh_sach_giao_vien_tong_phu_trach_gioi_sme"]);
                    this.list_bac_luong = JSON.parse(localStorage["danh_sach_bac_luong_sme"]);
                    // this.list_danh_gia = JSON.parse(localStorage["danh_sach_danh_gia_chuan_nghe_nghiep_moet_code_sme"]);
                    this.list_danh_gia = JSON.parse(localStorage["danh_sach_danh_gia_chuan_nghe_nghiep_sme"]);

                    this.list_trang_thai_can_bo = this.removeDuplicatesByValue(this.list_trang_thai_can_bo, 'value')
                    this.list_loai_can_bo = this.removeDuplicatesByValue(this.list_loai_can_bo, 'value')
                    this.list_chuc_vu = this.removeDuplicatesByValue(this.list_chuc_vu, 'value')
                    this.list_trinh_do_qlgd = this.removeDuplicatesByValue(this.list_trinh_do_qlgd, 'value')
                    this.list_bac_luong = this.removeDuplicatesByValue(this.list_bac_luong, 'value')
                }
            },
            removeDuplicatesByValue(array, key) {
                const uniqueArray = array.filter((obj, index, self) => {
                    return index === self.findIndex((o) => (
                        o[key] === obj[key]
                    ));
                });
                uniqueArray.sort((a, b) => {
                    if (a[key] < b[key]) return -1;
                    if (a[key] > b[key]) return 1;
                    return 0;
                });
                return uniqueArray;
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
                for (let l = 0; l < this.list_trinh_do_khac.length; l++) {
                    if (this.list_trinh_do_khac[l].value) {
                        this.list_trinh_do_khac[l].value = parseInt(this.list_trinh_do_khac[l].value)
                    }
                }
            },
            ChonNgaySinh() {
                console.log("Chọn ngày sinh giáo viên")
                this.check_confirm_come_back = true;
                if (this.thongtin_giaovien.ngaySinh) {
                    let d = this.thongtin_giaovien.ngaySinh.slice(-4, 10);
                    this.thongtin_giaovien.namSinh = parseInt(d);
                    console.log(this.thongtin_giaovien.namSinh)
                    console.log(this.thongtin_giaovien.ngaySinh)
                }
            },
            ChonDay1BuoiTrenNgay() {
                this.check_confirm_come_back = true;
                if (this.thongtin_giaovien.day1BuoiTrenNgay) {
                    this.thongtin_giaovien.day2BuoiTrenNgay = false;
                }
            },
            ChonDay2BuoiTrenNgay() {
                this.check_confirm_come_back = true;
                if (this.thongtin_giaovien.day2BuoiTrenNgay) {
                    this.thongtin_giaovien.day1BuoiTrenNgay = false;
                }
            },
            onUpdatedDataQtbd(e) {
                console.log("emit event:");
                console.log(JSON.stringify(e));
                this.show_qt_bd = false;
                this.list_qua_trinh_dtbd = e.dtbd;
                this.qua_trinh_nn = e.nn;
                this.qua_trinh_sp = e.sp;
                this.list_qua_trinh_dtbd_old = JSON.parse(JSON.stringify(e.dtbd));
                this.qua_trinh_nn_old = JSON.parse(JSON.stringify(e.nn));
                this.qua_trinh_sp_old = JSON.parse(JSON.stringify(e.sp));
            },
            onUpdatedDataQtLuong(e) {
                console.log("emit event:");
                console.log(JSON.stringify(e.qtl));
                this.show_qua_trinh_luong = false;
                this.qua_trinh_luong = e.qtl;
                this.qua_trinh_luong_old = JSON.parse(JSON.stringify(e.qtl));
            },
            onUpdatedDataQtKhenThuong(e) {
                this.show_chi_tiet_khen_thuong = false;
                this.list_khen_thuong = e.lkt;
                this.list_khen_thuong_old = JSON.parse(JSON.stringify(e.lkt));
            },
            onUpdatedDataQtKyLuat(e) {
                this.show_chi_tiet_ky_luat = false;
                this.list_ky_luat = e.lkt;
                this.list_ky_luat_old = JSON.parse(JSON.stringify(e.lkt));
            },
            onUpdatedDataNgoaiNgu(e) {
                this.show_dao_tao_nn = false;
                this.list_dao_tao_ngoai_ngu = e.lnn;
                this.list_dao_tao_ngoai_ngu_old = JSON.parse(JSON.stringify(e.lnn));
            },
            onCloseQtbd(e) {
                console.log("dữ liệu sp cũ:");
                console.log(JSON.stringify(this.qua_trinh_sp_old));
                console.log("dữ liệu dtbd cũ:");
                console.log(JSON.stringify(this.list_qua_trinh_dtbd_old));
                console.log("dữ liệu nn cũ:");
                console.log(JSON.stringify(this.qua_trinh_nn_old));
                console.log("dữ liệu emit:");
                console.log(JSON.stringify(e));
                this.list_qua_trinh_dtbd = JSON.parse(JSON.stringify(this.list_qua_trinh_dtbd_old));
                this.qua_trinh_nn = JSON.parse(JSON.stringify(this.qua_trinh_nn_old));
                this.qua_trinh_sp = JSON.parse(JSON.stringify(this.qua_trinh_sp_old));
                this.show_qt_bd = false;
            },
            onCloseQtLuong(e) {
                console.log(JSON.stringify(this.qua_trinh_luong_old));
                console.log("dữ liệu emit:");
                console.log(JSON.stringify(e.qtl));
                this.qua_trinh_luong = JSON.parse(JSON.stringify(this.qua_trinh_luong_old));
                this.show_qua_trinh_luong = false;
            },
            onCloseQtKhenThuong(e) {
                this.list_khen_thuong = JSON.parse(JSON.stringify(this.list_khen_thuong_old));
                this.show_chi_tiet_khen_thuong = false;
            },
            onCloseQtKyLuat(e) {
                this.list_ky_luat = JSON.parse(JSON.stringify(this.list_ky_luat_old));
                this.show_chi_tiet_ky_luat = false;
            },
            onCloseNgoaiNgu(e) {
                this.list_dao_tao_ngoai_ngu = JSON.parse(JSON.stringify(this.list_dao_tao_ngoai_ngu_old));
                this.show_dao_tao_nn = false;
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
                    }
                });
            },
            getThongTinGiaoVien(e) {
                console.log("lấy thông tin cán bộ");
                let params = {
                    "canBoTheoNamId": e.canBoTheoNamId,
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-admin/giaoVien/infor", params, (data) => {
                    loading.close();
                    if (data.data.maGiaoVien) {
                        // this.thongBao("success", "Lấy dữ liệu thành công");
                        this.thongtin_giaovien = data.data;
                        console.log(JSON.stringify(this.thongtin_giaovien));
                        console.log("***********");
                        // this.list_dg_chuan_nn = this.thongtin_giaovien.canBoTheoNamDanhGiaKqChuanNgheNghiepEntities;
                        this.list_dg_chuan_nn = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .canBoTheoNamDanhGiaKqChuanNgheNghiepEntities))
                        this.list_qua_trinh_dtbd = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .quaTrinhDaoTaoBoiDuongs));
                        this.qua_trinh_luong = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .quaTrinhLuongs));
                        this.list_khen_thuong = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .lstKhenThuongs));
                        this.list_khen_thuong_old = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .lstKhenThuongs));
                        this.list_ky_luat = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .lstKyLuats));
                        this.list_ky_luat_old = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .lstKyLuats));
                        this.list_dao_tao_ngoai_ngu = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .quaTrinhNgoaiNgus));
                        this.list_dao_tao_ngoai_ngu_old = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .quaTrinhNgoaiNgus));
                        console.log("**********1");
                        console.log(this.qua_trinh_luong);
                        console.log(JSON.stringify(this.qua_trinh_luong));
                        if (this.qua_trinh_luong.length > 0) {
                            for (let i = 0; i < this.qua_trinh_luong.length; i++) {
                                if (this.qua_trinh_luong[i].ngayThangNam) {
                                    this.qua_trinh_luong[i].ngayThangNam = this.qua_trinh_luong[i]
                                        .ngayThangNam
                                        .slice(0, 10);
                                }
                            }
                        }
                        this.qua_trinh_luong_old = JSON.parse(JSON.stringify(this.thongtin_giaovien
                            .quaTrinhLuongs));

                        console.log("**********2");
                        if (this.qua_trinh_luong_old.length > 0) {
                            for (let i = 0; i < this.qua_trinh_luong.length; i++) {
                                if (this.qua_trinh_luong_old[i].ngayThangNam) {
                                    this.qua_trinh_luong_old[i].ngayThangNam = this.qua_trinh_luong_old[i]
                                        .ngayThangNam
                                        .slice(0, 10);
                                }
                            }
                        }

                        console.log("**********3");
                        if (this.list_qua_trinh_dtbd.length > 0) {
                            console.log(JSON.stringify("$$$$$$$$$$$"));
                            console.log(JSON.stringify(this.list_qua_trinh_dtbd));
                            for (let i = 0; i < this.list_qua_trinh_dtbd.length; i++) {
                                if (this.list_qua_trinh_dtbd[i].tuThangNam) {
                                    this.list_qua_trinh_dtbd[i].tuThangNam = this.list_qua_trinh_dtbd[i]
                                        .tuThangNam
                                        .slice(0, 10);
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

                        console.log("**********4");
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
                                            i]
                                        .denThangnam.slice(0, 10);
                                }
                            }
                        }
                        this.getTieuChiSME();
                        this.getQuaTrinhNgoaiNgu("1");
                        this.getQuaTrinhSuPham("2");
                        this.diChuyenDenDanhSach();
                    } else {
                        this.thongBao("error", "Lỗi." + data.data.rd);
                    }
                    console.log("lấy xong");
                });
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
                // $("#update_modal_danh_gia_chuan_nghe_nghiep_gv").modal('hide');
                this.update_modal_danh_gia_chuan_nghe_nghiep_gv = false;
            },
            closemodal3() {
                $(this.$refs.modal_nl).on("hidden.bs.modal");
            },
            close() {
                this.$emit('close');
            },
            update() {
                console.log(this.thongtin_giaovien.gioiTinh);
                if (this.thongtin_giaovien.noiSinh != "11223344") {
                    if (!this.thongtin_giaovien.tenGiaoVien) {
                        this.thongBao("error", "Họ tên không được để trống");
                        return;
                    }
                    if (!this.thongtin_giaovien.ngaySinh) {
                        this.thongBao("error", "Ngày sinh không được để trống");
                        return;
                    }
                    // if (this.thongtin_giaovien.gioiTinh != 0 && this.thongtin_giaovien.gioiTinh != 1) {
                    //     this.thongBao("error", "Giới tính không được để trống");
                    //     return;
                    // }
                    if (!this.thongtin_giaovien.trangThai) {
                        this.thongBao("error", "Trạng thái CB không được để trống");
                        return;
                    }
                    if (this.thongtin_giaovien.trangThai == 8) {
                        if (!this.thongtin_giaovien.lyDoNghiViec) {
                            this.thongBao("error", "Thiếu lý do thôi việc");
                            return;
                        }
                    }
                    if (!this.thongtin_giaovien.ngayTrangThai) {
                        this.thongBao("error", "Ngày trạng thái không được để trống");
                        return;
                    }
                    if (!this.thongtin_giaovien.soCmnd) {
                        this.thongBao("error", "CMTND/TCC không được để trống");
                        return;
                    }
                    if (this.thongtin_giaovien.soCmnd.length != 12 && this.thongtin_giaovien.soCmnd.length != 9) {
                        this.thongBao("error", "CMTND/TCC gồm 9 hoặc 12 số");
                        return;
                    }
                    if (!this.thongtin_giaovien.loaiCanBo) {
                        this.thongBao("error", "Vị trí việc làm không được để trống");
                        return;
                    }
                    if (!this.thongtin_giaovien.trinhDoChuyenMonCaoNhat) {
                        this.thongBao("error", "Trình độ chuyên môn nghiệp vụ không được để trống");
                        return;
                    }
                    if (this.thongtin_giaovien.loaiCanBo == 1) {
                        if (!this.thongtin_giaovien.chuyenNganhDaoTaoChinh) {
                            this.thongBao("error", "Thiếu Chuyên ngành chính");
                            return;
                        }
                        if (!this.thongtin_giaovien.trinhDoDaoTaoCnChinh) {
                            this.thongBao("error", "Thiếu trình độ chính");
                            return;
                        }
                        if (!this.thongtin_giaovien.mucPhuCapLanhDao) {
                            this.thongBao("error",
                                "Cán bộ quản lý bắt buộc phải nhập Mức phụ cấp chức vụ lãnh đạo (%)");
                            return;
                        }
                        if (!this.thongtin_giaovien.loaiHopDong) {
                            this.thongBao("error", "Cán bộ quản lý bắt buộc phải chọn Hình thức hợp đồng");
                            return;
                        }
                        if (this.thongtin_giaovien.loaiHopDong == 1 || this.thongtin_giaovien.loaiHopDong == 8) {
                            if (!this.thongtin_giaovien.maNgach) {
                                this.thongBao("error", "Thiếu Ngạch/Hạng");
                                return;
                            }
                            if (!this.thongtin_giaovien.mucPhuCapUuDai) {
                                this.thongBao("error", "Thiếu Mức phụ cấp ưu đãi nghề (%)");
                                return;
                            }
                            if (!this.thongtin_giaovien.bacLuong) {
                                this.thongBao("error", "Thiếu Bậc lương");
                                return;
                            }
                            if (!this.thongtin_giaovien.heSoLuong) {
                                this.thongBao("error", "Thiếu Hệ số lương");
                                return;
                            }
                        }
                    }
                    if (this.thongtin_giaovien.loaiCanBo == 2) {
                        if (!this.thongtin_giaovien.maMonHoc) {
                            this.thongBao("error", "Giáo viên bắt buộc phải chọn Môn dạy");
                            return;
                        }
                        if (!this.thongtin_giaovien.loaiHopDong) {
                            this.thongBao("error", "Giáo viên bắt buộc phải chọn Hình thức hợp đồng");
                            return;
                        }
                        if (!this.thongtin_giaovien.chuyenNganhDaoTaoChinh) {
                            this.thongBao("error", "Thiếu Chuyên ngành chính");
                            return;
                        }
                        if (!this.thongtin_giaovien.trinhDoDaoTaoCnChinh) {
                            this.thongBao("error", "Thiếu trình độ chính");
                            return;
                        }
                        if (this.thongtin_giaovien.loaiHopDong == 1 || this.thongtin_giaovien.loaiHopDong == 8) {
                            if (!this.thongtin_giaovien.maNgach) {
                                this.thongBao("error", "Thiếu Ngạch/Hạng");
                                return;
                            }
                            if (!this.thongtin_giaovien.mucPhuCapUuDai) {
                                this.thongBao("error", "Thiếu Mức phụ cấp ưu đãi nghề (%)");
                                return;
                            }
                        }
                        if (this.thongtin_giaovien.loaiHopDong == 1 || this.thongtin_giaovien.loaiHopDong == 8 || this
                            .thongtin_giaovien.loaiHopDong == 2) {
                            if (!this.thongtin_giaovien.bacLuong) {
                                this.thongBao("error", "Thiếu Bậc lương");
                                return;
                            }
                            if (!this.thongtin_giaovien.heSoLuong) {
                                this.thongBao("error", "Thiếu Hệ số lương");
                                return;
                            }
                        }
                        if (this.thongtin_giaovien.chucVu == 8) {
                            if (!this.thongtin_giaovien.mucPhuCapLanhDao) {
                                this.thongBao("error",
                                    "Tổ trưởng chuyên môn bắt buộc phải nhập Mức phụ cấp chức vụ lãnh đạo (%)");
                                return;
                            }
                        }
                        if (this.thongtin_giaovien.chucVu == 9) {
                            if (!this.thongtin_giaovien.mucPhuCapLanhDao) {
                                this.thongBao("error",
                                    "Tổ phó chuyên môn bắt buộc phải nhập Mức phụ cấp chức vụ lãnh đạo (%)");
                                return;
                            }
                        }
                    }
                    if (this.thongtin_giaovien.loaiCanBo == 3) {
                        if (this.thongtin_giaovien.loaiHopDong == 1 || this.thongtin_giaovien.loaiHopDong == 8) {
                            if (!this.thongtin_giaovien.maNgach) {
                                this.thongBao("error", "Thiếu Ngạch/Hạng");
                                return;
                            }
                        }
                        if (this.thongtin_giaovien.loaiHopDong == 1 || this.thongtin_giaovien.loaiHopDong == 8 || this
                            .thongtin_giaovien.loaiHopDong == 2) {
                            if (!this.thongtin_giaovien.bacLuong) {
                                this.thongBao("error", "Thiếu Bậc lương");
                                return;
                            }
                            if (!this.thongtin_giaovien.heSoLuong) {
                                this.thongBao("error", "Thiếu Hệ số lương");
                                return;
                            }
                        }
                    }
                    if (this.thongtin_giaovien.maMonHoc == "34" || this.thongtin_giaovien.maMonHoc == "35" || this
                        .thongtin_giaovien.maMonHoc == "TAH" || this.thongtin_giaovien.maMonHoc == "TNA" || this
                        .thongtin_giaovien.maMonHoc == "TPP" || this.thongtin_giaovien.maMonHoc == "TTG" || this
                        .thongtin_giaovien.maMonHoc == "TDU") {
                        if (!this.thongtin_giaovien.monNgoaiNguChinh) {
                            this.thongBao("error", "Thiếu Ngoại ngữ chính");
                            return;
                        }
                    }
                    if (this.thongtin_giaovien.monNgoaiNguChinh) {
                        if (!this.thongtin_giaovien.maNhomCchiNngu) {
                            this.thongBao("error", "Thiếu Nhóm chứng chỉ ngoại ngữ");
                            return;
                        }
                        if (!this.thongtin_giaovien.maLoaiCchiNngu) {
                            this.thongBao("error", "Thiếu Loại chứng chỉ ngoại ngữ");
                            return;
                        }
                        if (!this.thongtin_giaovien.maKhungNlucNngu) {
                            this.thongBao("error", "Thiếu Khung năng lực ngoại ngữ");
                            return;
                        }
                    }
                }
                // *********************
                if (this.thongtin_giaovien.thamGiaBdTxuyen) {
                    this.thongtin_giaovien.thamGiaBdTxuyen = 1
                } else {
                    this.thongtin_giaovien.thamGiaBdTxuyen = 0
                }
                if (this.thongtin_giaovien.tapHuanKnsSkss) {
                    this.thongtin_giaovien.tapHuanKnsSkss = 1
                } else {
                    this.thongtin_giaovien.tapHuanKnsSkss = 0
                }
                if (this.thongtin_giaovien.dayHsktHocHoaNhap) {
                    this.thongtin_giaovien.dayHsktHocHoaNhap = 1
                } else {
                    this.thongtin_giaovien.dayHsktHocHoaNhap = 0
                }
                if (this.thongtin_giaovien.day1BuoiTrenNgay) {
                    this.thongtin_giaovien.day1BuoiTrenNgay = 1
                } else {
                    this.thongtin_giaovien.day1BuoiTrenNgay = 0
                }
                if (this.thongtin_giaovien.day2BuoiTrenNgay) {
                    this.thongtin_giaovien.day2BuoiTrenNgay = 1
                } else {
                    this.thongtin_giaovien.day2BuoiTrenNgay = 0
                }
                // if (this.thongtin_giaovien.kqBdTx) {
                //     this.thongtin_giaovien.kqBdTx = 1
                // } else {
                //     this.thongtin_giaovien.kqBdTx = 0
                // }
                if (this.thongtin_giaovien.doanVien) {
                    this.thongtin_giaovien.doanVien = 1
                } else {
                    this.thongtin_giaovien.doanVien = 0
                }
                if (this.thongtin_giaovien.dangVien) {
                    this.thongtin_giaovien.dangVien = 1
                } else {
                    this.thongtin_giaovien.dangVien = 0
                }
                this.thongtin_giaovien.canBoTheoNamQtbdNcnlSuphamList = this.qua_trinh_sp;
                this.thongtin_giaovien.canBoTheoNamQtbdNcnlNgoainguList = this.qua_trinh_nn;
                this.thongtin_giaovien.canBoTheoNamQtbdNcnlNgoainguList = this.qua_trinh_nn;
                this.thongtin_giaovien.canBoTheoNamDanhGiaKqChuanNgheNghiepEntities = this.list_dg_chuan_nn;
                this.thongtin_giaovien.lstKyLuats = this.list_ky_luat;
                this.thongtin_giaovien.lstKhenThuongs = this.list_khen_thuong;
                this.thongtin_giaovien.quaTrinhNgoaiNgus = this.list_dao_tao_ngoai_ngu;
                this.thongtin_giaovien.quaTrinhLuongs = this.qua_trinh_luong;
                if (this.list_qua_trinh_dtbd.length > 0) {
                    for (let i = 0; i < this.list_qua_trinh_dtbd.length; i++) {
                        if (
                            this.list_qua_trinh_dtbd[i].tuThangNam) {
                            this.list_qua_trinh_dtbd[i].tuThangNam = this.list_qua_trinh_dtbd[i].tuThangNam +
                                "T00:00:00.0";
                        }
                        if (
                            this.list_qua_trinh_dtbd[i].denThangnam) {
                            this.list_qua_trinh_dtbd[i].denThangnam = this.list_qua_trinh_dtbd[i].denThangnam +
                                "T00:00:00.0";
                        }
                    }
                }
                if (this.thongtin_giaovien.trangThai != 8) {
                    this.thongtin_giaovien.lyDoNghiViec = null;
                }
                this.thongtin_giaovien.quaTrinhDaoTaoBoiDuongs = this.list_qua_trinh_dtbd;
                console.log(JSON.stringify(this.thongtin_giaovien));

                let params = {
                    updateGiaoVienRequest: this.thongtin_giaovien,
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/giaoVien/update", params, data => {
                    loading.close();
                    if (data.data.rc == 0) {
                        this.thongBao("success", "Chỉnh sửa thông tin giáo viên thành công");
                        this.$emit('success');
                    } else {
                        // utils.showDialog("Thất bại", data.data.rd, null, () => {
                        // });
                        this.thongBao("error", data.data.rd);
                    }
                });
                // this.$confirm('Xác nhận chỉnh sửa thông tin?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {
                //     })
                //     .catch(_ => {});
            },
            resetChuanNn() {
                this.list_dg_chuan_nn = JSON.parse(JSON.stringify(this.thongtin_giaovien
                    .canBoTheoNamDanhGiaKqChuanNgheNghiepEntities));
            },
            viewDanhGiaKqChuanNn() {
                console.log('Xem đánh giá');

                this.update_modal_danh_gia_chuan_nghe_nghiep_gv = true;
                // $("#update_modal_danh_gia_chuan_nghe_nghiep_gv").modal();
            },
            dienBienQtLuong() {
                console.log('dienBienQtLuong');
                console.log(JSON.stringify(this.qua_trinh_luong));
                this.show_qua_trinh_luong = true;
            },
            chiTietKhenThuong() {
                console.log(JSON.stringify(this.list_khen_thuong));
                this.show_chi_tiet_khen_thuong = true;
            },
            chiTietKyLuat() {
                console.log(JSON.stringify(this.list_ky_luat));
                this.show_chi_tiet_ky_luat = true;
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
            viewDaoTaoNn() {
                console.log("đào tạo ngoại ngữ:");
                console.log(JSON.stringify(this.list_dao_tao_ngoai_ngu));
                this.show_dao_tao_nn = true;
            },
            viewNangLuc(e) {
                console.log("xem quá trình bồi dưỡng");
                this.listQuaTrinhDtBd.nn = this.qua_trinh_nn;
                this.listQuaTrinhDtBd.sp = this.qua_trinh_sp;
                this.listQuaTrinhDtBd.dtbd = this.list_qua_trinh_dtbd;
                console.log(JSON.stringify(this.listQuaTrinhDtBd));
                this.show_qt_bd = true;
            },
            themItemDanhGia(e) {
                console.log("xóa ở vị trí:" + e);
                let obj = {
                    maTieuChi: "",
                    noiDungDanhGia: "",
                    tuDanhGia: "",
                    capTrenDanhGia: "",
                }
                console.log("123123");
                this.list_dg_chuan_nn.push(obj);
            },
            xoaItemDanhGia(e) {
                console.log("xóa ở vị trí:" + e);
                this.list_dg_chuan_nn.splice(e, 1);
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
        margin: 16px -15px !important;
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

    .el-input-number {
        width: 100% !important;
    }

    .modal-body-fullscreen {
        height: calc(100vh - 100px) !important;
    }

</style>

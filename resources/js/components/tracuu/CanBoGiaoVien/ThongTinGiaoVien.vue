<template>
    <div>
        <el-dialog title="Thông tin hồ sơ cán bộ" :visible.sync="show" width="90%"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
            <el-form :model='thongtin_giaovien' ref="ruleForm">
                <el-row :gutter="24">
                    <el-col :span="24">
                        <div class="row" ref="danhSachDuLieu">
                            <div class="col-md-2">
                                <div class="thumbnail" style="text-align:center;">
                                    <div>
                                        <div v-if="thongtin_giaovien.avatar">
                                            <img style="width: 100%;max-width: 250px;height: auto" :src="thongtin_giaovien.avatar" width="100%" alt="hình ảnh học sinh"/>
                                        </div>
                                        <div v-else>
                                            <img style="width: 100%;max-width: 250px;height: auto" src="https://www.drupal.org/files/issues/default-avatar.png" width="100%" alt=""/>
                                        </div>
                                        <div>
                                            <p class="moet-code">Mã cán bộ: <span class="d-block">{{ thongtin_giaovien.maGiaoVien }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Họ tên <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div >
                                            <input class="form-control" disabled v-model="thongtin_giaovien.tenGiaoVien">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Ngày sinh <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div >
                                            <input class="form-control" disabled v-model="thongtin_giaovien.ngaySinh">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Giới tính <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div >
                                            <el-select disabled v-model="thongtin_giaovien.gioiTinh">
                                                <el-option label="Nam" :value="1"></el-option>
                                                <el-option label="Nữ" :value="0"></el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Trạng thái <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.trangThai,list_trang_thai_can_bo)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Ngày trạng thái <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div >
                                            <date-picker class="form-control" disabled style="min-width: 50px;" v-model="thongtin_giaovien.ngayTrangThai"
                                                         :config="configDate" placeholder="Chọn ngày"></date-picker>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group" v-if="thongtin_giaovien.trangThai==8">
                                        <div >
                                            <label class="typo__label">Lý do thôi việc <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div >
                                            <input class="form-control" disabled type="text" v-model="thongtin_giaovien.lyDoNghiViec">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">CMTND/TCC <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div >
                                            <input class="form-control" disabled type="number" v-model="thongtin_giaovien.soCmnd">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Ngày cấp CMTND/TCC</label>
                                        </div>
                                        <div >
                                            <date-picker class="form-control" disabled style="min-width: 50px;" v-model="thongtin_giaovien.ngayCapCmnd"
                                                         :config="configDate" placeholder=""></date-picker>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Quê quán</label>
                                        </div>
                                        <div >
                                            <textarea class="form-control" disabled style="height: 36px; max-height: 100%" v-model="thongtin_giaovien.queQuan" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Nơi sinh</label>
                                        </div>
                                        <div >
                                            <textarea class="form-control" disabled style="height: 36px; max-height: 100%" v-model="thongtin_giaovien.noiSinh" rows="3"></textarea>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Dân tộc</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maDanToc,list_dantoc)">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Tôn giáo</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maTonGiao,list_ton_giao)">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Thành phần gia đình</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.thanhPhanGiaDinh,list_tpgd)">
                                        </div>
                                    </div>



                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Số sổ BHXH</label>
                                        </div>
                                        <div >
                                            <input class="form-control" disabled v-model="thongtin_giaovien.soSoBhxh">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Email</label>
                                        </div>
                                        <div >
                                            <input class="form-control" disabled v-model="thongtin_giaovien.email">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Tình trạng sức khoẻ hiện tại</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="thongtin_giaovien.tinhTrangSucKhoe">
                                        </div>
                                    </div>

                                    <div v-if="(thongtin.ma_so==36)||(thongtin.role==2&&thongtin.ma_so==19)" class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Số điện thoại</label>
                                        </div>
                                        <div >
                                            <input class="form-control" disabled v-model="thongtin_giaovien.soDienThoai">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Nơi kết nạp Đoàn</label>
                                        </div>
                                        <div >
                                            <input class="form-control" disabled v-model="thongtin_giaovien.noiVaoDoan">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Nơi kết nạp Đảng</label>
                                        </div>
                                        <div >
                                            <input class="form-control" disabled v-model="thongtin_giaovien.noiVaoDang">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Mã định danh bộ GD&ĐT</label>
                                        </div>
                                        <div >
                                            <input class="form-control" disabled v-model="thongtin_giaovien.moetCode">
                                        </div>
                                    </div>





                                </div>

                                <div>
                                    <div class="row form-group">

                                        <div class="col-md-12" style="align-self:center">
                                            <i v-if="thongtin_giaovien.tuyenMoi" style="color:#01856B;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i>

                                            <label class="typo__label">Là tuyển mới</label>
                                        </div>
                                    </div>
                                    <div class="row form-group">

                                        <div class="col-md-12" style="align-self:center">
                                            <i v-if="thongtin_giaovien.doanVien" style="color:#01856B;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i>
                                            <label class="typo__label">Đoàn viên</label>
                                        </div>
                                    </div>

                                    <div class="row form-group">

                                        <div class="col-md-12" style="align-self:center">
                                            <i v-if="thongtin_giaovien.dangVien" style="color:#01856B;" class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i>
                                            <label class="typo__label" >Đảng viên</label>
                                        </div>
                                    </div>
                                </div>
                                <!-- *********** -->
                            </div>
                        </div>
                        <hr>
                        <el-tabs type="border-card2">
                            <el-tab-pane>
                                <span slot="label">Vị trí việc làm</span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Cấp dạy <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div >
                                            <eselect :disabled="true" style="width:100%" collapseTags ref="capHoc"
                                                     v-model="thongtin_giaovien.capHoc" filterable
                                                     :data="list_cap_hoc"
                                                     :fields="['name','id']"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Loại cán bộ <span style="color:#DC0101">*</span></label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.loaiCanBo,list_loai_can_bo)">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Môn dạy</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maMonHoc,list_mon_day)">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Môn dạy kiêm nhiệm</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.monDayKiemNhiem,list_mon_day)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Cơ quan tuyển dụng</label>
                                        </div>
                                        <div >
                                            <input type="text" disabled class="form-control" v-model="thongtin_giaovien.coQuanTuyenDung"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Nhiệm vụ kiêm nhiệm</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control"
                                                   :value="getTen(thongtin_giaovien.nhiemVuKiemNhiem,list_nhiem_vu_kiem_nhiem)">
                                        </div>
                                    </div>



                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Số tiết thực dạy trên tuần</label>
                                        </div>
                                        <div >
                                            <input type="text" disabled class="form-control"
                                                   v-model="thongtin_giaovien.soTietThucDay1Tuan"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Số tiết thực kiêm nhiệm/tuần</label>
                                        </div>
                                        <div >
                                            <input type="text" disabled class="form-control"
                                                   v-model="thongtin_giaovien.soTietKiemNhiem1Tuan"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Ngạch/Hạng</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maNgach,list_ma_ngach_hang)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Nghề nghiệp khi được tuyển dụng</label>
                                        </div>
                                        <div >
                                            <input type="text" disabled class="form-control" v-model="thongtin_giaovien.ngheNghiepTuyenDung"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Nhóm chức vụ</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.chucVu,list_chuc_vu)">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Hình thức hợp đồng</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.loaiHopDong,list_hinh_thuc_hop_dong)">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Tuyển mới</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="thongtin_giaovien.tuyenMoi?'Có':'Không'">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Ngày tuyển dụng</label>
                                        </div>
                                        <div >
                                            <date-picker class="form-control" disabled style="min-width: 50px;"
                                                         v-model="thongtin_giaovien.ngayTuyenDung"
                                                         :config="configDate"
                                                         placeholder="Chọn ngày">
                                            </date-picker>
                                        </div>
                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="row form-group">

                                            <div class="col-md-12">
                                                <i v-if="thongtin_giaovien.chuyenTrachDoi" style="color:#01856B;" class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                                <label class="typo__label">Chuyên trách đội</label>
                                            </div>
                                        </div>
                                        <div class="row form-group">

                                            <div class="col-md-12">
                                                <i v-if="thongtin_giaovien.tapHuanKnsSkss" style="color:#01856B;" class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                                <label class="typo__label">Đã tập huấn dạy kỹ năng sống (HIV, SKSS...)</label>
                                            </div>
                                        </div>

                                        <div class="row form-group">

                                            <div class="col-md-12">
                                                <i v-if="thongtin_giaovien.dayHsktHocHoaNhap" style="color:#01856B;" class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                                <label class="typo__label">Dạy học sinh khuyết tật hòa nhập</label>
                                            </div>
                                        </div>

                                        <div class="row form-group">

                                            <div class="col-md-12">
                                                <i v-if="thongtin_giaovien.day1BuoiTrenNgay" style="color:#01856B;" class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                                <label class="typo__label">Đang dạy 1 buổi/ngày</label>
                                            </div>
                                        </div>

                                        <div class="row form-group">

                                            <div class="col-md-12">
                                                <i v-if="thongtin_giaovien.day2BuoiTrenNgay" style="color:#01856B;" class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                                <label class="typo__label">Đang dạy 2 buổi/ngày</label>
                                            </div>
                                        </div>

                                        <div class="row form-group">

                                            <div class="col-md-12">
                                                <i v-if="thongtin_giaovien.thamGiaBdTxuyen" style="color:#01856B;" class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                                <label class="typo__label">Tham gia chương trình bồi dưỡng thường xuyên</label>
                                            </div>
                                        </div>



                                        <div class="row form-group">

                                            <div class="col-md-12">
                                                <i v-if="thongtin_giaovien.coCcBdChucDanhNgheNghiep" style="color:#01856B;" class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square"></i>
                                                <label class="typo__label">Có CC bồi dưỡng TCCD</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane>
                                <span slot="label">Phụ cấp</span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Mức phụ cấp thu hút nghề (%)</label>
                                        </div>
                                        <div >
                                            <input type="text" disabled class="form-control" v-model="thongtin_giaovien.mucPhuCapThuHut"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Mức phụ cấp thâm niên (%)</label>
                                        </div>
                                        <div >
                                            <input type="text" disabled class="form-control" v-model="thongtin_giaovien.mucPhuCapThamNien"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Mức phụ cấp ưu đãi nghề (%)</label>
                                        </div>
                                        <div >
                                            <input disabled type="text" class="form-control" v-model="thongtin_giaovien.mucPhuCapUuDai"/>
                                        </div>
                                    </div>



                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Mức phụ cấp chức vụ lãnh đạo (%)</label>
                                        </div>
                                        <div >
                                            <input type="text" disabled class="form-control" v-model="thongtin_giaovien.mucPhuCapLanhDao"/>
                                        </div>
                                    </div>


                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Bậc lương</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.bacLuong,list_bac_luong)">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Ngày vào biên chế</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="thongtin_giaovien.ngayVaoBienChe">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Phần trăm vượt khung (%)</label>
                                        </div>
                                        <div >
                                            <input type="text" disabled class="form-control" v-model="thongtin_giaovien.vuotKhung"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Hệ số lương</label>
                                        </div>
                                        <div >
                                            <input type="text" disabled class="form-control" v-model="thongtin_giaovien.heSoLuong"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Ngày hưởng</label>
                                        </div>
                                        <div >
                                            <date-picker class="form-control" disabled style="min-width: 50px;" v-model="thongtin_giaovien.ngayHuong"
                                                         :config="configDate" placeholder="Chọn ngày">
                                            </date-picker>
                                        </div>
                                    </div>


                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Diễn biến quá trình lương</label>
                                        </div>
                                        <div >
                                            <el-tooltip content="Xem chi tiết" placement="top">
                                                <el-button plain size="mini" @click.prevent="dienBienQtLuong()" type="primary" icon="el-icon-plus">Chi tiết
                                                </el-button>
                                            </el-tooltip>
                                        </div>
                                    </div>

                                </div>
                            </el-tab-pane>
                            <el-tab-pane>
                                <span slot="label">Đào tạo, bồi dưỡng</span>
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Kết quả bồi dưỡng thường xuyên</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.kqBdTx,list_kqbd_tx)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Trình độ chuyên môn nghiệp vụ cao nhất <span style="color:#DC0101"> *</span></label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.trinhDoChuyenMonCaoNhat,list_trinh_do_cm_nv)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Trình độ lý luận chính trị</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.trinhDoLyLuanChinhTri,list_trinh_do_llct)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Trình độ quản lý giáo dục</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.trinhDoQuanLyGiaoDuc,list_trinh_do_qlgd)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Tham gia bồi dưỡng nghiệp vụ QLGD</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maBoiDuongNvu,list_boi_duong_nvu)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Tham gia bồi dưỡng CBQL/GV cốt cán</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maBoiDuongCbqlCotCan,list_boi_duong_cbqlcc)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Chương trình dạy ngoại ngữ</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="thongtin_giaovien.chuongTrinhDayNN">
                                        </div>
                                    </div>


                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Chuyên ngành đào tạo chính</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.chuyenNganhDaoTaoChinh,list_cn_dt_chinh)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Trình độ chính</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.trinhDoDaoTaoCnChinh,list_trinh_do_chinh)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Cơ sở đào tạo</label>
                                        </div>
                                        <div >
                                            <input type="text" disabled class="form-control" v-model="thongtin_giaovien.tenCsDaoTaoBd">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Chuyên ngành đào tạo khác</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.chuyenNganhDaoTaoKhac,list_cn_dt_khac)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Trình độ khác</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.trinhDoDaoTaoCnKhac,list_trinh_do_khac)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Chứng chỉ tiếng dân tộc thiểu số</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maChungChiTiengDtocTso,list_cc_tieng_dt_ts)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Nhóm chứng chỉ ngoại ngữ</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maNhomCchiNngu,list_nhom_cc_nn)">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Loại chứng chỉ ngoại ngữ</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maLoaiCchiNngu,list_loai_cc_nn)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Khung năng lực ngoại ngữ</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maKhungNlucNngu,list_khung_nl_nn)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Trình độ tin học</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.trinhDoTinHoc,list_trinh_do_th)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Tham gia bồi dưỡng thay sách</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.maBoiDuongThaySach,list_boi_duong_thay_sach)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Ngoại ngữ chính</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.monNgoaiNguChinh,list_ngoai_ngu_chinh)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Trình độ ngoại ngữ chính</label>
                                        </div>
                                        <div >
                                            <input disabled class="form-control" :value="getTen(thongtin_giaovien.trinhDoNgoaiNgu,list_trinh_do_nn)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Quá trình đào tạo bồi dưỡng</label>
                                        </div>
                                        <div >
                                            <el-tooltip content="Xem chi tiết" placement="top">
                                                <el-button plain size="mini" @click.prevent="viewNangLuc(list_qua_trinh_dtbd)" type="primary" icon="el-icon-plus">Chi tiết</el-button>
                                            </el-tooltip>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-md-4 form-group">
                                        <div >
                                            <label class="typo__label">Điểm Ngoại ngữ</label>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-7">
                                                <input type="text" disabled class="form-control" v-model="thongtin_giaovien.diemNgoaiNgu">
                                            </div>
                                            <div class="col-sm-5">
                                                <el-tooltip content="Xem chi tiết" placement="top">
                                                    <el-button plain size="mini" @click.prevent="viewDaoTaoNn()" type="primary" icon="el-icon-plus">Chi tiết</el-button>
                                                </el-tooltip>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </el-tab-pane>
                            <el-tab-pane>
                                <span slot="label">Đánh giá, phân loại</span>
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4 form-group">
                                        <label class="typo__label">Đánh giá viên chức/ công chức</label>
                                        <div >
                                            <input disabled class="form-control"
                                                   :value="getTen(thongtin_giaovien.danhGiaVienChuc,list_danh_gia_vien_chuc)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 form-group">
                                        <label class="typo__label">Tự đánh giá chuẩn nghề nghiệp</label>
                                        <div >
                                            <input disabled class="form-control"
                                                   :value="getTen(thongtin_giaovien.tuDanhGiaKqChuanNgheNghiep,list_danh_gia)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 form-group">
                                        <label class="typo__label">Cấp trên đánh giá chuẩn nghề nghiệp</label>
                                        <div >
                                            <input disabled class="form-control"
                                                   :value="getTen(thongtin_giaovien.dgKqChuanNgheNghiep,list_danh_gia)">
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-4 form-group">
                                        <label class="typo__label">Tổng phụ trách Đội giỏi</label>
                                        <div >
                                            <input disabled class="form-control"
                                                   :value="getTen(thongtin_giaovien.maGvTongPtrachDoiGioi,list_tong_pt_gioi)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 form-group">
                                        <label class="typo__label">Danh hiệu phong tặng</label>
                                        <div >
                                            <input type="text" class="form-control" disabled
                                                   v-model="thongtin_giaovien.danhHieuPhongTang"/>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-4 form-group">
                                        <label class="typo__label">Giáo viên dạy giỏi</label>
                                        <div >
                                            <input disabled class="form-control"
                                                   :value="getTen(thongtin_giaovien.gvDayGioi,list_gv_day_gioi)">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 form-group">
                                        <label class="typo__label">Giáo viên chủ nhiệm giỏi</label>
                                        <div >
                                            <input disabled class="form-control"
                                                   :value="getTen(thongtin_giaovien.maGiaoVienChuNhiemGioi,list_gv_cn_gioi)">
                                        </div>
                                    </div>



                                </div>
                                <div class="row">
                                    <div class="col-sm-6 col-lg-4 form-group">
                                        <label class="typo__label">Đánh giá chuẩn nghề nghiệp CBQL/GV</label>
                                        <div >
                                            <el-tooltip content="Xem chi tiết" placement="top">
                                                <el-button plain size="mini" @click.prevent="viewDanhGiaKqChuanNn()"
                                                           type="primary" icon="el-icon-plus">Chi tiết
                                                </el-button>
                                            </el-tooltip>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 form-group">
                                        <label class="typo__label">Khen thưởng</label>
                                        <div >
                                            <el-tooltip content="Xem chi tiết" placement="right">
                                                <el-button plain size="mini" @click.prevent="chiTietKhenThuong()"
                                                           type="primary" icon="el-icon-plus">Chi tiết
                                                </el-button>
                                            </el-tooltip>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-4 form-group">
                                        <label class="typo__label">Kỷ luật</label>
                                        <div >
                                            <el-tooltip content="Xem chi tiết" placement="right">
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
                </el-row>

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
                        :title="'Đánh giá chuẩn nghề nghiệp: ' + thongtin_giaovien.tenGiaoVien + ' - ['+thongtin_giaovien.ngaySinh + ']' "
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
                                                style="color:#01856B; background: chartreuse;"
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
                                                style="color:#01856B; background: chartreuse;"
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
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="default" style="margin-right:5px" @click.prevent="handleClose()">Đóng
                </el-button>
            </span>
        </el-dialog>

    </div>
</template>
<script>
import moment from 'moment'
import utils from '../../../utils'
import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
import datePicker from 'vue-bootstrap-datetimepicker';
import rest_api from '../../../utils/rest_api';
import ESelectVue from '../../ui/ESelect.vue';
import array_util from '../../../utils/array_utils';
import timeutils from "../../../utils/time_utils";
import ThongTinQtBd from './ThongTinQuaTrinhBoiDuongNangCaoNangLuc'
import ThongTinQtLuong from './ThongTinQuaTrinhLuong'
import ThongTinKhenThuong from './ThongTinKhenThuongGiaoVien'
import ThongTinKyLuat from './ThongTinKyLuatGiaoVien'
import ThongTinDaoTaoNgoaiNgu from './ThongTinDaoTaoNn'
import api from '../../api';

export default {
    props: [
        'item', 'show'
    ],
    watch: {
        show: function (newVal, oldVal) {
            console.log("newVal = " + newVal);
            if (newVal) {
                this.getThongTinGiaoVien(this.item);
                $("#modal_info_teacher").modal();
            } else {
                $("#modal_info_teacher").modal('hide');
            }
        },
    },
    data() {
        return {
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
            configDatePicker: {
                format: 'YYYY-MM-DD',
                useCurrent: false,
                showTodayButton: true,
                locale: 'vi'
            },
            update_modal_danh_gia_chuan_nghe_nghiep_gv:false,
            thongtin_giaovien: {},
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
            list_ton_giao: [],
            list_dantoc: [],
            list_trang_thai_can_bo: [],
            list_loai_can_bo: [],
            list_cap_hoc: window.listCapHoc,
            list_tpgd: [],
            list_mon_day: [],
            list_chuc_vu: [],
            list_hinh_thuc_hop_dong: [],
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
            // *****
        }
    },
    mounted: function () {
        this.ganDuLieuSME();
        // $("#modal_info_teacher").modal();

        this.mapToIntTrangThaiCanBo();
        $(this.$refs.modal_info_teacher).on("hidden.bs.modal", this.close);
        // $(this.$refs.modal_danh_gia_chuan_nghe_nghiep).on("hidden.bs.modal", this.closemodal2);
        $(this.$refs.modal_nl).on("hidden.bs.modal", this.closemodal3);
    },
    components: {
        datePicker,
        'eselect': ESelectVue,
        'info-qtbd': ThongTinQtBd,
        'info-luong': ThongTinQtLuong,
        'info-khen-thuong': ThongTinKhenThuong,
        'info-ky-luat': ThongTinKyLuat,
        'info-dt-nn': ThongTinDaoTaoNgoaiNgu,
    },
    methods: {
        
        handleClose() {
            this.close();
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
            for (let l = 0; l < this.list_danh_gia.length; l++) {
                if (this.list_danh_gia[l].value) {
                    this.list_danh_gia[l].value = parseInt(this.list_danh_gia[l].value)
                }
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
                this.list_tpgd = JSON.parse(localStorage["danh_sach_thanh_phan_gia_dinh_sme"]);
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
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.get("/csdlgd-admin/giaoVien/infor", params, (data) => {
                loading.close();
                if (data.data.maGiaoVien) {
                    // this.thongBao("success","Lấy dữ liệu thành công")
                    this.thongtin_giaovien = data.data;
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
                    if (this.qua_trinh_luong_old.length > 0) {
                        for (let i = 0; i < this.qua_trinh_luong.length; i++) {
                            if (this.qua_trinh_luong_old[i].ngayThangNam) {
                                this.qua_trinh_luong_old[i].ngayThangNam = this.qua_trinh_luong_old[i]
                                    .ngayThangNam
                                    .slice(0, 10);
                            }
                        }
                    }
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
                } else {
                    this.thongBao("error", data.data.rd)
                }
                this.diChuyenDenDanhSach();
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
            this.update_modal_danh_gia_chuan_nghe_nghiep_gv = false;
            // $(this.$refs.modal_danh_gia_chuan_nghe_nghiep).on("hidden.bs.modal");
        },
        closemodal3() {
            $(this.$refs.modal_nl).on("hidden.bs.modal");
        },
        close() {
            this.$emit('close');
        },
        resetChuanNn() {
            this.list_dg_chuan_nn = JSON.parse(JSON.stringify(this.thongtin_giaovien
                .canBoTheoNamDanhGiaKqChuanNgheNghiepEntities));
        },
        viewDanhGiaKqChuanNn() {
            this.update_modal_danh_gia_chuan_nghe_nghiep_gv = true;
            // $("#modal_danh_gia_chuan_nghe_nghiep").modal();
        },
        dienBienQtLuong() {
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
.fas,.far{
    font-size: 18px;
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
.col-md-2,
.col-md-4,
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

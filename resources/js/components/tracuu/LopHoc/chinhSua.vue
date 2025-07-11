<template>
    <div v-loading.fullscreen.lock="fullScreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog title="Chỉnh sửa thông tin lớp học" :visible.sync="show" top="5vh" width="1200" :close-on-click-modal="false"
            :close-on-press-escape="false" :before-close="handleClose">
            <el-form style="margin-bottom:0 !important" :model='thongTinLopHoc' :rules="rules" ref="ruleForm">
                <el-row :gutter="24" style="margin-bottom:0 !important">
                    <div style="margin-bottom: 20px" ref="scrollToMe"></div>
                    <el-col :span="24" style="padding-top:0 !important">
                        <div class="row form-group" v-if="thongTinLopHoc.capHoc==4||thongTinLopHoc.capHoc==5">
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Nhóm lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-input clearable @change="check_confirm_come_back = true" type="text" disabled
                                                  :value="getTen2(thongTinLopHoc.khoiHoc,list_khoi_hoc)">
                                        </el-input>
                                        <!-- <el-select @change="check_confirm_come_back = true" @change="chonNhomLop()" v-model="thongTinLopHoc.khoiHoc" filterable collapse-tags
                                                placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_khoi_hoc" :key="item.id" :label="item.name"
                                                    :value="item.id">
                                                </el-option>
                                            </el-select> -->
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Nhóm tuổi <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-form-item prop="maNhomTuoiMn">
                                            <el-select @change="check_confirm_come_back = true"
                                                       v-model="thongTinLopHoc.maNhomTuoiMn" filterable collapse-tags
                                                       placeholder="Chọn" ref="maNhomTuoiMn" no-data-text="Không có dữ liệu"
                                                       no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_nhom_tuoi_mam_non" :key="i"
                                                           :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </el-form-item>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Tên lớp <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-sm-12">

                                        <el-form-item prop="tenLopHoc">
                                            <el-input ref="tenLopHoc" clearable @change="check_confirm_come_back = true"
                                                      type="text" v-model="thongTinLopHoc.tenLopHoc" />
                                        </el-form-item>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-input clearable @change="check_confirm_come_back = true" type="text" disabled
                                                  v-model="thongTinLopHoc.maLopHoc" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã định danh</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-input clearable @change="check_confirm_come_back = true" type="text"
                                                  v-model="thongTinLopHoc.moetCode" disabled />
                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Điểm trường</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maDiemTruong" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_diem_truong" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Buổi học</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true" v-model="thongTinLopHoc.buoiHoc"
                                                   filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_buoi_hoc" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Giáo viên chủ nhiệm</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <!-- <el-input clearable @change="check_confirm_come_back = true" type="text" disabled v-model="thongTinLopHoc.tenGvcn"
                                                /> -->

                                        <el-select v-model="thongTinLopHoc.maGvcn" @change="chonGvCn()" filterable
                                                   collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_gvcn" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Ghép vào lớp
                                        </label>
                                        <el-input placeholder="Nhập" style="width: 100%" clearable @change="check_confirm_come_back = true" type="text"
                                                  v-model="thongTinLopHoc.maLopGhep" />
                                    </div>

                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học bán trú</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maHocBanTru" filterable collapse-tags placeholder="Chọn"
                                                   no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_hoc_ban_tru" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12"></div>
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.lopCoTreKhuyetTat" />
                                            Có trẻ khuyết tật
                                        </label>
                                    </div>

                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.lopGhep" />
                                            Nhóm trẻ ghép
                                        </label>
                                    </div>

                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.lopBanTru" />

                                            Bán trú
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.ctrinhGdmnMoi" />
                                            C.trình giáo dục MN mới
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.ctrinhCsocGduc" />
                                            C.trình chăm sóc giáo dục
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" v-if="thongTinLopHoc.capHoc==1">
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Khối</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-input clearable @change="check_confirm_come_back = true" type="text" disabled
                                                  :value="getTen2(thongTinLopHoc.khoiHoc,list_khoi_hoc)">
                                        </el-input>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Tên lớp <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <!-- <el-input clearable @change="check_confirm_come_back = true" type="text"
                                            v-model="thongTinLopHoc.tenLopHoc" /> -->
                                        <el-form-item prop="tenLopHoc">
                                            <el-input ref="tenLopHoc" clearable @change="check_confirm_come_back = true"
                                                      type="text" v-model="thongTinLopHoc.tenLopHoc" />
                                        </el-form-item>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-input clearable @change="check_confirm_come_back = true" type="text" disabled
                                                  v-model="thongTinLopHoc.maLopHoc" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã định danh</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-input clearable @change="check_confirm_come_back = true" type="text" disabled
                                                  v-model="thongTinLopHoc.moetCode" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số buổi học/tuần</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.soBuoiTrenTuan" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_so_buoi_hoc_tren_tuan" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số tiết học/tuần</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maTietHoc" filterable collapse-tags placeholder="Chọn"
                                                   no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_so_tiet_hoc_tren_tuan" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Điểm trường</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maDiemTruong" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_diem_truong" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Ghép vào lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-input placeholder="Nhập" clearable @change="check_confirm_come_back = true" type="text"
                                                  v-model="thongTinLopHoc.maLopGhep" />
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Hình thức học tập</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maHthucDtaoHtap" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_hinh_thuc_dao_tao_hoc_tap" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Đào tạo, bồi dưỡng</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maLopDtaoBduong" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_lop_dao_tao_boi_duong" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Hướng nghiệp dạy nghề</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maLopHnghiepDayNghe" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_day_nghe_huong_nghiep" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Giáo viên chủ nhiệm</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select v-model="thongTinLopHoc.maGvcn" @change="chonGvCn()" filterable
                                                   collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_gvcn" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học ngoại ngữ 1</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true" v-model="thongTinLopHoc.maNn1"
                                                   filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_ngoai_ngu" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Chương trình học (NN1)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maChuongTrinhHocNn1" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_chuong_trinh_hoc_nn" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số tiết NN/tuần (NN1)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maSoTietNgoaiNgu1" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_so_tiet_nn" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học ngoại ngữ 2</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true" v-model="thongTinLopHoc.maNn2"
                                                   filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_ngoai_ngu" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Chương trình học (NN2)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maChuongTrinhHocNn2" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_chuong_trinh_hoc_nn" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số tiết NN/tuần (NN2)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maSoTietNgoaiNgu2" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_so_tiet_nn" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học bán trú</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maHocBanTru" filterable collapse-tags placeholder="Chọn"
                                                   no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_hoc_ban_tru" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Bộ sách giáo khoa sử dụng</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maBoSgkSuDung" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_bo_sgk" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Kiểu lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true" filterable
                                                   v-model="thongTinLopHoc.maKieuLop" collapse-tags placeholder="Chọn"
                                                   no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_bo_tuc" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12"></div>
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.lopGhep" />
                                            Lớp ghép
                                        </label>
                                    </div>

                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.lopBanTru" />
                                            Bán trú
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>


                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.lopVnen" />
                                            Lớp VNEN
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.thietBiDhocTviet" />
                                            Đủ TBDH - Tiếng Việt
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.thietBiDhocToan" />
                                            Đủ TBDH - Toán
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.daiDienChaMeLop" />
                                            Có Đ.diện cha, mẹ hs lớp
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.daiDienChaMeTruong" />
                                            Có Đ.diện cha, mẹ hs trường
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.lopChuyenBiet" />
                                            Chuyên biệt
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row form-group" v-if="thongTinLopHoc.capHoc==2">
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Khối</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-input clearable @change="check_confirm_come_back = true" type="text" disabled
                                                  :value="getTen2(thongTinLopHoc.khoiHoc,list_khoi_hoc)" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Tên lớp <span style="color:#DC0101">*</span></label>
                                    </div>
                                    <div class="col-sm-12">
                                        <!-- <el-input clearable @change="check_confirm_come_back = true" type="text"
                                            v-model="thongTinLopHoc.tenLopHoc" /> -->

                                        <el-form-item prop="tenLopHoc">
                                            <el-input ref="tenLopHoc" clearable @change="check_confirm_come_back = true"
                                                      type="text" v-model="thongTinLopHoc.tenLopHoc" />
                                        </el-form-item>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-input clearable @change="check_confirm_come_back = true" type="text" disabled
                                                  v-model="thongTinLopHoc.maLopHoc" />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Mã định danh</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-input clearable @change="check_confirm_come_back = true" type="text"
                                                  v-model="thongTinLopHoc.moetCode" disabled />
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số buổi học/tuần</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.soBuoiTrenTuan" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_so_buoi_hoc_tren_tuan" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Điểm trường</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maDiemTruong" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_diem_truong" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Kiểu lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true" filterable
                                                   v-model="thongTinLopHoc.maKieuLop" collapse-tags placeholder="Chọn"
                                                   no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_bo_tuc" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Giáo viên chủ nhiệm</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select v-model="thongTinLopHoc.maGvcn" @change="chonGvCn()" filterable
                                                   collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_gvcn" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học ngoại ngữ 1</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true" v-model="thongTinLopHoc.maNn1"
                                                   filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_ngoai_ngu" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Chương trình học (NN1)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maChuongTrinhHocNn1" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_chuong_trinh_hoc_nn" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số tiết NN/tuần (NN1)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maSoTietNgoaiNgu1" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_so_tiet_nn" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Học ngoại ngữ 2</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true" v-model="thongTinLopHoc.maNn2"
                                                   filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_ngoai_ngu" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Chương trình học (NN2)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maChuongTrinhHocNn2" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_chuong_trinh_hoc_nn" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Số tiết NN/tuần (NN2)</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maSoTietNgoaiNgu2" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_so_tiet_nn" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">

                                        <div class="row form-group">

                                            <div class="col-sm-12">
                                                <label class="typo__label">Học bán trú</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select @change="check_confirm_come_back = true"
                                                           v-model="thongTinLopHoc.maHocBanTru" filterable collapse-tags placeholder="Chọn"
                                                           no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_hoc_ban_tru" :key="i" :label="item.name"
                                                               :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">

                                        <div class="row form-group">

                                            <div class="col-sm-12">
                                                <label class="typo__label">Ghép vào lớp</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-input placeholder="Nhập" clearable @change="check_confirm_come_back = true" type="text"
                                                          v-model="thongTinLopHoc.maLopGhep" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Bộ sách giáo khoa sử dụng</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maBoSgkSuDung" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_bo_sgk" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Hướng nghiệp dạy nghề</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maLopHnghiepDayNghe" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_day_nghe_huong_nghiep" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">


                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Hình thức học tập</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maHthucDtaoHtap" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_hinh_thuc_dao_tao_hoc_tap" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Đào tạo, bồi dưỡng</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maLopDtaoBduong" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_lop_dao_tao_boi_duong" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12"></div>
                            <div class="col-sm-6">
                                <div class=" form-group">
                                    <label class="typo__label">
                                        <input @change="check_confirm_come_back = true" type="checkbox"
                                               v-model="thongTinLopHoc.lopBanTru" />
                                        Bán trú
                                    </label>
                                </div>
                                <div class=" form-group">
                                    <label class="typo__label">
                                        <input @change="check_confirm_come_back = true" type="checkbox"
                                               v-model="thongTinLopHoc.lopGhep" />
                                        Lớp ghép
                                    </label>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.lopVnen" />
                                            Lớp VNEN
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.coHocSinhHocNghe" />
                                            Học sinh học nghề
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row form-group" v-if="thongTinLopHoc.capHoc==3">
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Khối</label>
                                            </div>
                                            <div class="col-sm-12">

                                                <el-input clearable @change="check_confirm_come_back = true" type="text" disabled
                                                          :value="getTen2(thongTinLopHoc.khoiHoc,list_khoi_hoc)" />
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Tên lớp <span style="color:#DC0101">*</span></label>
                                            </div>
                                            <div class="col-sm-12">

                                                <el-form-item prop="tenLopHoc">
                                                    <el-input ref="tenLopHoc" clearable @change="check_confirm_come_back = true"
                                                              type="text" v-model="thongTinLopHoc.tenLopHoc" />
                                                </el-form-item>
                                                <!-- <el-input clearable @change="check_confirm_come_back = true" type="text"
                                                    v-model="thongTinLopHoc.tenLopHoc" /> -->
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Mã lớp</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-input clearable @change="check_confirm_come_back = true" type="text" disabled
                                                          v-model="thongTinLopHoc.maLopHoc" />
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Mã định danh</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-input clearable @change="check_confirm_come_back = true" type="text"
                                                          v-model="thongTinLopHoc.moetCode" disabled />
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Số buổi học/tuần</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select @change="check_confirm_come_back = true"
                                                           v-model="thongTinLopHoc.soBuoiTrenTuan" filterable collapse-tags
                                                           placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                           no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_so_buoi_hoc_tren_tuan" :key="i"
                                                               :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Điểm trường</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select @change="check_confirm_come_back = true"
                                                           v-model="thongTinLopHoc.maDiemTruong" filterable collapse-tags
                                                           placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                           no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_diem_truong" :key="i" :label="item.name"
                                                               :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Phân ban</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select @change="check_confirm_come_back = true" v-model="thongTinLopHoc.phanBan"
                                                           filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                           no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_phan_ban" :key="i" :label="item.name"
                                                               :value="parseInt(item.value)">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Giáo viên chủ nhiệm</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select v-model="thongTinLopHoc.maGvcn" @change="chonGvCn()" filterable
                                                           collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                           no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_gvcn" :key="i" :label="item.name"
                                                               :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Học ngoại ngữ 1</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select @change="check_confirm_come_back = true" v-model="thongTinLopHoc.maNn1"
                                                           filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                           no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_ngoai_ngu" :key="i" :label="item.name"
                                                               :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Chương trình học (NN1)</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select @change="check_confirm_come_back = true"
                                                           v-model="thongTinLopHoc.maChuongTrinhHocNn1" filterable collapse-tags
                                                           placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                           no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_chuong_trinh_hoc_nn" :key="i"
                                                               :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Số tiết NN/tuần (NN1)</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select @change="check_confirm_come_back = true"
                                                           v-model="thongTinLopHoc.maSoTietNgoaiNgu1" filterable collapse-tags
                                                           placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                           no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_so_tiet_nn" :key="i" :label="item.name"
                                                               :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Học ngoại ngữ 2</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select @change="check_confirm_come_back = true" v-model="thongTinLopHoc.maNn2"
                                                           filterable collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                           no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_ngoai_ngu" :key="i" :label="item.name"
                                                               :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Chương trình học (NN2)</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select @change="check_confirm_come_back = true"
                                                           v-model="thongTinLopHoc.maChuongTrinhHocNn2" filterable collapse-tags
                                                           placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                           no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_chuong_trinh_hoc_nn" :key="i"
                                                               :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-sm-12">
                                                <label class="typo__label">Số tiết NN/tuần (NN2)</label>
                                            </div>
                                            <div class="col-sm-12">
                                                <el-select @change="check_confirm_come_back = true"
                                                           v-model="thongTinLopHoc.maSoTietNgoaiNgu2" filterable collapse-tags
                                                           placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                           no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="(item,i) in list_so_tiet_nn" :key="i" :label="item.name"
                                                               :value="item.value">
                                                    </el-option>
                                                </el-select>
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
                                                        <el-input clearable @change="check_confirm_come_back = true" type="text" placeholder="Nhập"
                                                                  v-model="thongTinLopHoc.maLopGhep" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">




                                                <div class="row form-group">
                                                    <div class="col-sm-12">
                                                        <label class="typo__label">Học bán trú</label>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <el-select @change="check_confirm_come_back = true"
                                                                   v-model="thongTinLopHoc.maHocBanTru" filterable collapse-tags placeholder="Chọn"
                                                                   no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="(item,i) in list_hoc_ban_tru" :key="i" :label="item.name"
                                                                       :value="item.value">
                                                            </el-option>
                                                        </el-select>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="col-sm-6">


                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Kiểu lớp</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true" filterable
                                                   v-model="thongTinLopHoc.maKieuLop" collapse-tags placeholder="Chọn"
                                                   no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_bo_tuc" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Bộ sách giáo khoa sử dụng</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maBoSgkSuDung" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_bo_sgk" :key="i" :label="item.name"
                                                       :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Hướng nghiệp dạy nghề</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maLopHnghiepDayNghe" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_day_nghe_huong_nghiep" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>



                            </div>
                            <div class="col-sm-6">


                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Hình thức học tập</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maHthucDtaoHtap" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_hinh_thuc_dao_tao_hoc_tap" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">Đào tạo, bồi dưỡng</label>
                                    </div>
                                    <div class="col-sm-12">
                                        <el-select @change="check_confirm_come_back = true"
                                                   v-model="thongTinLopHoc.maLopDtaoBduong" filterable collapse-tags
                                                   placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                   no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="(item,i) in list_lop_dao_tao_boi_duong" :key="i"
                                                       :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-12"></div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="typo__label">
                                        <input @change="check_confirm_come_back = true" type="checkbox"
                                               v-model="thongTinLopHoc.lopGhep" />
                                        Lớp ghép
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="typo__label">
                                        <input @change="check_confirm_come_back = true" type="checkbox"
                                               v-model="thongTinLopHoc.lopBanTru" />
                                        Bán trú
                                    </label>
                                </div>
                                <div class="row form-group">
                                    <div class="col-sm-12">
                                        <label class="typo__label">
                                            <input @change="check_confirm_come_back = true" type="checkbox"
                                                   v-model="thongTinLopHoc.lopChuyen" />
                                            Lớp chuyên
                                        </label>
                                    </div>
                                    <div class="col-sm-12">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="typo__label">
                                        <input @change="check_confirm_come_back = true" type="checkbox"
                                               v-model="thongTinLopHoc.coHocSinhHocNghe" />
                                        Học sinh học nghề
                                    </label>
                                </div>

                            </div>
                        </div>
                    </el-col>
                </el-row>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button type="primary" @click.prevent="submitForm('ruleForm')" size="mini">Lưu</el-button>
            </span>
        </el-dialog>
        <div v-if="false" id="modal_update_class" ref="modal_update_class" class="modal fade">
            <div class="modal-dialog modal-dialog-fullscreen" style="">
                <form>
                    <div class="modal-content modal-content-fullscreen" style="">
                        <div class="modal-header modal-header-fullscreen" style="">
                            <h4>CHỈNH SỬA LỚP HỌC</h4>
                        </div>
                        <div class="modal-body modal-body-fullscreen" style="padding-bottom:200px;">

                        </div>
                        <div class="modal-footer modal-footer-fullscreen">
                            <el-button type="default" size="mini" @click.prevent="handleClose()">Đóng
                            </el-button>
                            <el-button type="warning" size="mini" @click.prevent="update()">Lưu</el-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import utils from '../../../utils'
    import constant from '../../../utils/constant';
    import rest_api from '../../../utils/rest_api';
    import api from '../../api';
    export default {
        props: [
            'item', 'show'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.getThongTinLopHoc(this.item);
                    $("#modal_update_class").modal();
                } else {
                    $("#modal_update_class").modal('hide');
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
                check_confirm_come_back: false,
                rules: {
                    maNhomTuoiMn: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    tenLopHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                }
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            this.mapIntValue();
            $(this.$refs.modal_update_class).on("hidden.bs.modal", this.close);
        },
        components: {},
        methods: {

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
                console.log("handleClose")
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
                            this.check_confirm_come_back = false;
                            // this.$refs[formName].resetFields();
                            this.close()

                        })
                        .catch(_ => {});
                } else {
                    this.check_confirm_come_back = false;
                    // this.$refs[formName].resetFields();
                    this.close()
                }
            },
            resetForm(formName) {},
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
            mapIntValue() {
                for (let k = 0; k < this.list_so_buoi_hoc_tren_tuan.length; k++) {
                    if (this.list_so_buoi_hoc_tren_tuan[k].value) {
                        this.list_so_buoi_hoc_tren_tuan[k].value = parseInt(this.list_so_buoi_hoc_tren_tuan[k].value)
                    }
                }
                for (let k = 0; k < this.list_buoi_hoc.length; k++) {
                    if (this.list_buoi_hoc[k].value) {
                        this.list_buoi_hoc[k].value = parseInt(this.list_buoi_hoc[k].value)
                    }
                }
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
                this.check_confirm_come_back = true;
                this.thongTinLopHoc.maGvcnCn = this.thongTinLopHoc.maGvcn;
            },
            getGvCn() {
                let params = {
                    "maTruong": this.thongTinLopHoc.maTruongHoc,
                    "namHoc": this.thongTinLopHoc.namHoc,
                };
                this.fullScreenLoading = true;
                this.list_gvcn = [];
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
                console.log("lấy thông tin cán bộ");
                let params = {
                    "id": e,
                };
                this.fullScreenLoading = true;
                rest_api.get("/csdlgd-admin/lopHoc/infor", params, (data) => {
                    this.fullScreenLoading = false;
                    if (data.data) {
                        console.log("Thông tin lớp học trả về:")
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
            update() {
                if (!this.thongTinLopHoc.khoiHoc) {
                    this.thongBao("error", "Thiếu khối học")
                    return;
                }
                if (this.thongTinLopHoc.capHoc == 4 || this.thongTinLopHoc.capHoc == 5) {
                    if (!this.thongTinLopHoc.maNhomTuoiMn) {
                        this.thongBao("error", "Thiếu nhóm tuổi")
                        return;
                    }
                }
                if (!this.thongTinLopHoc.tenLopHoc) {
                    this.thongBao("error", "Thiếu tên lớp học")
                    return;
                }
                if (this.thongTinLopHoc.lopGhep) {
                    this.thongTinLopHoc.lopGhep = 1
                } else {
                    this.thongTinLopHoc.lopGhep = 0
                }
                if (this.thongTinLopHoc.lopBanTru) {
                    this.thongTinLopHoc.lopBanTru = 1
                } else {
                    this.thongTinLopHoc.lopBanTru = 0
                }
                if (this.thongTinLopHoc.lopChuyen) {
                    this.thongTinLopHoc.lopChuyen = 1
                } else {
                    this.thongTinLopHoc.lopChuyen = 0
                }
                if (this.thongTinLopHoc.lopVnen) {
                    this.thongTinLopHoc.lopVnen = 1
                } else {
                    this.thongTinLopHoc.lopVnen = 0
                }

                let params = {
                    updateLopHocRequest: this.thongTinLopHoc,
                };

                this.fullScreenLoading = true;
                rest_api.post("/csdlgd-admin/lopHoc/update", params, data => {
                    this.fullScreenLoading = false;
                    if (data.data.rc == 0) {
                        this.thongBao("success", data.data.rd)
                        this.$emit('success');
                    } else {
                        this.thongBao("success", data.data.rd)
                    }
                });
                // this.$confirm('Xác nhận chỉnh sửa?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {
                //     })
                //     .catch(_ => {});
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
        margin: 20px -15px !important;
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

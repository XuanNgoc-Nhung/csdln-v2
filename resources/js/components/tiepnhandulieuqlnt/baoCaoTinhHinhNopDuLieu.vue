<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <Breadcrumb :menu="'Tiếp nhận dữ liệu QLNT'" :desc="'BC tình hình nộp dữ liệu'"
            :subDesc="'Báo cáo tình hình nộp dữ liệu cấp Trường'" />
        <div class="card-bieu-do">
            <el-form :model='dataSearch' :rules="rules" ref="ruleForm">
                <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :sm="24" :lg="12">
                        <label class="typo__label">Đơn vị quản lý </label>
                        <eselect style="width:100%" @change="layLaiTruong" :disabled="thongtin.role>3" multiple
                                 collapseTags v-model="donVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                 :fields="['tenDonVi','maDonVi']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Cấp học </label>
                        <eselect style="width:100%" :disabled="thongtin.role==5" @change="layLaiTruong" multiple
                                 collapseTags v-model="capHoc" :placeholder="'Chọn'" filterable
                                 :data="danh_sach_cap_hoc_full" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Năm học <span class="red">*</span></label>
                        <el-form-item prop="namHoc">
                            <eselect style="width:100%" collapseTags v-model="dataSearch.namHoc" :placeholder="'Chọn'"
                                     filterable :data="list_nam_hoc" :fields="['name','id']" />
                        </el-form-item>
                    </el-col>
                    <el-col :sm="24" :lg="12">
                        <label class="typo__label">Trường học <span style="color:#DC0101">*</span></label>

                        <el-form-item prop="truongHoc">
                            <eselect style="width:100%" ref="truongHoc" multiple collapseTags
                                     :disabled="thongtin.role==5" v-model="dataSearch.truongHoc" :placeholder="'Chọn'"
                                     filterable :data="list_truong_hoc" :fields="['name','value']" />
                        </el-form-item>
                    </el-col>

                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Học kỳ</label>
                        <eselect style="width:100%" collapseTags v-model="hocKy" :placeholder="'Tất cả'" filterable
                                 :data="list_hoc_ky" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Loại dữ liệu <span class="red">*</span></label>
                        <el-form-item prop="loaiDuLieu">
                            <eselect style="width:100%" collapseTags v-model="dataSearch.loaiDuLieu"
                                     @change="chonLoaiDuLieu" :placeholder="'Chọn'" filterable :data="list_loai_du_lieu"
                                     :fields="['name','id']" />
                        </el-form-item>
                    </el-col>

                    <el-col :span="24" class="text-center">
                        <el-button class="bt-chinh" size="mini" @click.prevent="submitForm('ruleForm')" type="success">Tìm
                            kiếm
                        </el-button>
                    </el-col>
                </el-row>
            </el-form>

        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24" v-show="dataSearch.loaiDuLieu">
                <el-col :lg=20>
                    <div>
                        <p><b>Ghi chú:</b></p>
                        <ul style="margin-bottom:0 ">
                            <li style="">
                                <p style="">Mầm non: số trẻ hoàn thành chương trình Mầm non
                                    (Dữ
                                    liệu nộp Học kỳ 2- Giai đoạn cuối kỳ 2).</p>
                            </li>
                            <li style="">
                                <p style="">Tiểu học: số học sinh
                                    được đánh giá hoàn thành chương trình tiểu học (Dữ liệu nộp Học kỳ 2
                                    -
                                    Giai
                                    đoạn
                                    cuối kỳ 2).</p>
                            </li>
                            <li style="">
                                <p style="">THCS,THPT: Số học sinh
                                    được xét tốt nghiệp (Dữ liệu nộp học kỳ cuối năm).</p>
                            </li>
                        </ul>
                    </div>
                </el-col>

                <el-col :span="24" >
                   <div style="display: flex; justify-content: space-between;align-items: center;margin-bottom: 15px">
                       <label style="" class="table-name">Báo cáo tình hình nộp dữ liệu cấp trường</label>
                       <el-button class="bt-chinh" v-if="total_rows" type="success" size="mini"
                                  @click.prevent="getDataExcel()">
                           Xuất Excel
                       </el-button>
                   </div>
                    <div v-if="dataSearch.loaiDuLieu==-1" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="text-center" style="background:#e4ebf5">
                                    <th rowspan="3">
                                        <p>STT</p>
                                    </th>
                                    <th rowspan="3">
                                        <p>Mã trường</p>
                                    </th>
                                    <th rowspan="3">
                                        <p>Trường học</p>
                                    </th>
                                    <th rowspan="3">
                                        <p>Đối tác</p>
                                    </th>
                                    <th rowspan="3">
                                        <p>Cấp học</p>
                                    </th>
                                    <th rowspan="3">
                                        <p>Đơn vị quản lý</p>
                                    </th>
                                    <th colspan="6">
                                        <p>Cán bộ - Giáo viên</p>
                                    </th>
                                    <th colspan="5">
                                        <p>Lớp</p>
                                    </th>
                                    <th colspan="3">
                                        <p>Học sinh</p>
                                    </th>
                                    <th colspan="5">
                                        <p>Kết quả học tập</p>
                                    </th>
                                </tr>
                                <tr class="text-center" style="background:#e4ebf5">
                                    <th rowspan="2">
                                        <p>Tổng số CB-GV trên QLNT</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Tổng số CB-GV đã nộp</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                    <th colspan="3">
                                        <p>Đề án ngoại ngữ</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Tổng số lớp trên QLNT</p>
                                    </th>
                                    <th colspan="3">
                                        <p>Số lớp đã nộp</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Tổng số HS trên QLNT</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Tổng số HS đã nộp</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                    <th colspan="3">
                                        <p>Số HS đã nộp có KQHT</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Số HS Tốt nghiệp <sup style="color:#DC0101">(1)</sup></p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                                <tr class="text-center" style="background:#e4ebf5">
                                    <th>
                                        <p>Giáo viên ngoại ngữ</p>
                                    </th>
                                    <th>
                                        <p>GV được BDNCNL Ngoại ngữ</p>
                                    </th>
                                    <th>
                                        <p>GV được BDNCNL Sư phạm</p>
                                    </th>
                                    <th>
                                        <p>Tổng</p>
                                    </th>
                                    <th>
                                        <p>Số lớp ghép</p>
                                    </th>
                                    <th>
                                        <p>Số lớp đơn</p>
                                    </th>
                                    <th>
                                        <p>Học kỳ I</p>
                                    </th>
                                    <th>
                                        <p>Học kỳ II</p>
                                    </th>
                                    <th>
                                        <p>Cả năm</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="25" class="text-center">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td class="text-center">
                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maDoiTac }}</p>
                                    </td>
                                    <td>
                                        <p v-if="item.capHoc==1">Tiểu học</p>
                                        <p v-else-if="item.capHoc==2">THCS</p>
                                        <p v-else-if="item.capHoc==3">THPT</p>
                                        <p v-else-if="item.capHoc==4">Nhà trẻ</p>
                                        <p v-else-if="item.capHoc==5">Mẫu giáo</p>
                                        <p v-else-if="item.capHoc==6">GDTX</p>
                                        <p v-else-if="item.capHoc==45">Mầm non</p>
                                        <p v-else-if="item.capHoc==12">Trường liên cấp TH+THCS</p>
                                        <p v-else-if="item.capHoc==13">Trường liên cấp TH+THPT</p>
                                        <p v-else-if="item.capHoc==23">Trường liên THCS+THPT</p>
                                        <p v-else-if="item.capHoc==123">Trường liên cấp TH+THCS+THPT</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenDonVi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlCanBo.tongSoBanGhiTrenQlnt }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlCanBo.tongSoBanGhiDaNop }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlCanBo.ngayNopCuoi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlDeAnNgoaiNgu.soGvNgoaiNgu }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlDeAnNgoaiNgu.soGvCoQuaTrinhBdncnlnn }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlDeAnNgoaiNgu.soGvCoQuaTrinhBdncnlsp }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlLopHoc.tongSoBanGhiTrenQlnt }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlLopHoc.tongSoBanGhiDaNop }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlLopHoc.soLopGhep }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlLopHoc.soLopDon }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlLopHoc.ngayNopCuoi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlHocSinh.tongSoBanGhiTrenQlnt }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlHocSinh.tongSoBanGhiDaNop }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.dlHocSinh.ngayNopCuoi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ getSoHocSinhTheoHocKy(item.dlKqht, 1) }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ getSoHocSinhTheoHocKy(item.dlKqht, 2) }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ getSoHocSinhTheoHocKy(item.dlKqht, 3) }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ getSoHocSinhTotNghiep(item.dlKqht) }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ getNgayNopCuoi(item.dlKqht) }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="dataSearch.loaiDuLieu==2" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Mã trường</p>
                                    </th>
                                    <th>
                                        <p>Trường học</p>
                                    </th>
                                    <th>
                                        <p>Đối tác</p>
                                    </th>
                                    <th>
                                        <p>Cấp học</p>
                                    </th>
                                    <th>
                                        <p>Đơn vị quản lý</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Tổng số CB-GV đã nộp từ QLNT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số CB-GV đang làm việc đã nộp năm học trước</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số CB-GV đang làm việc đã nộp</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="12" class="text-center">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td class="text-center">
                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maDoiTac }}</p>
                                    </td>
                                    <td>
                                        <p v-if="item.capHoc==1">Tiểu học</p>
                                        <p v-else-if="item.capHoc==2">THCS</p>
                                        <p v-else-if="item.capHoc==3">THPT</p>
                                        <p v-else-if="item.capHoc==4">Nhà trẻ</p>
                                        <p v-else-if="item.capHoc==5">Mẫu giáo</p>
                                        <p v-else-if="item.capHoc==6">GDTX</p>
                                        <p v-else-if="item.capHoc==45">Mầm non</p>
                                        <p v-else-if="item.capHoc==12">Trường liên cấp TH+THCS</p>
                                        <p v-else-if="item.capHoc==13">Trường liên cấp TH+THPT</p>
                                        <p v-else-if="item.capHoc==23">Trường liên THCS+THPT</p>
                                        <p v-else-if="item.capHoc==123">Trường liên cấp TH+THCS+THPT</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenDonVi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiTrenQlnt }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiDaNopNamTruoc }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiDaNop }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.ngayNopCuoi }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="dataSearch.loaiDuLieu==3" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th rowspan="2" class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th rowspan="2" class="text-center">
                                        <p>Mã trường</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Trường học</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Đối tác</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Cấp học</p>
                                    </th>
                                    <th rowspan="2">
                                        <p>Đơn vị quản lý</p>
                                    </th>
                                    <th rowspan="2" class="text-center">
                                        <p>Tổng số lớp trên QLNT</p>
                                    </th>
                                    <th colspan="4" class="text-center">
                                        <p>Số lớp đã nộp</p>
                                    </th>
                                    <th rowspan="2" class="text-center">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                                <tr style="background:#e4ebf5">
                                    <th>
                                        <p>Tổng năm học trước</p>
                                    </th>
                                    <th>
                                        <p>Tổng</p>
                                    </th>
                                    <th>
                                        <p>Số lớp ghép</p>
                                    </th>
                                    <th>
                                        <p>Số lớp đơn</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="12" class="text-center">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td class="text-center">
                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maDoiTac }}</p>
                                    </td>
                                    <td>
                                        <p v-if="item.capHoc==1">Tiểu học</p>
                                        <p v-else-if="item.capHoc==2">THCS</p>
                                        <p v-else-if="item.capHoc==3">THPT</p>
                                        <p v-else-if="item.capHoc==4">Nhà trẻ</p>
                                        <p v-else-if="item.capHoc==5">Mẫu giáo</p>
                                        <p v-else-if="item.capHoc==6">GDTX</p>
                                        <p v-else-if="item.capHoc==45">Mầm non</p>
                                        <p v-else-if="item.capHoc==12">Trường liên cấp TH+THCS</p>
                                        <p v-else-if="item.capHoc==13">Trường liên cấp TH+THPT</p>
                                        <p v-else-if="item.capHoc==23">Trường liên THCS+THPT</p>
                                        <p v-else-if="item.capHoc==123">Trường liên cấp TH+THCS+THPT</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenDonVi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiTrenQlnt }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiDaNopNamTruoc }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiDaNop }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.soLopGhep }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.soLopDon }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.ngayNopCuoi }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="dataSearch.loaiDuLieu==4" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Mã trường</p>
                                    </th>
                                    <th>
                                        <p>Đối tác</p>
                                    </th>
                                    <th>
                                        <p>Trường học</p>
                                    </th>
                                    <th>
                                        <p>Cấp học</p>
                                    </th>
                                    <th>
                                        <p>Đơn vị quản lý</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Tổng số HS đang học trên QLNT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số HS đang học đã nộp năm học trước</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số HS đang học đã nộp</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="12" class="text-center">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td class="text-center">
                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maDoiTac }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenTruong }}</p>
                                    </td>
                                    <td>
                                        <p v-if="item.capHoc==1">Tiểu học</p>
                                        <p v-else-if="item.capHoc==2">THCS</p>
                                        <p v-else-if="item.capHoc==3">THPT</p>
                                        <p v-else-if="item.capHoc==4">Nhà trẻ</p>
                                        <p v-else-if="item.capHoc==5">Mẫu giáo</p>
                                        <p v-else-if="item.capHoc==6">GDTX</p>
                                        <p v-else-if="item.capHoc==45">Mầm non</p>
                                        <p v-else-if="item.capHoc==12">Trường liên cấp TH+THCS</p>
                                        <p v-else-if="item.capHoc==13">Trường liên cấp TH+THPT</p>
                                        <p v-else-if="item.capHoc==23">Trường liên THCS+THPT</p>
                                        <p v-else-if="item.capHoc==123">Trường liên cấp TH+THCS+THPT</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenDonVi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiTrenQlnt }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiDaNopNamTruoc }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiDaNop }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.ngayNopCuoi }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="dataSearch.loaiDuLieu==5" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Mã trường</p>
                                    </th>
                                    <th>
                                        <p>Trường học</p>
                                    </th>
                                    <th>
                                        <p>Đối tác</p>
                                    </th>
                                    <th>
                                        <p>Cấp học</p>
                                    </th>
                                    <th>
                                        <p>Đơn vị quản lý</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Tổng số HS trên QLNT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số HS đã nộp</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số HS đã nộp có KQHT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số HS tốt nghiệp <sup><i>(<span style="color:#DC0101">1</span>)</i></sup>
                                        </p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="11" class="text-center">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td class="text-center">
                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maDoiTac }}</p>
                                    </td>
                                    <td>
                                        <p v-if="item.capHoc==1">Tiểu học</p>
                                        <p v-else-if="item.capHoc==2">THCS</p>
                                        <p v-else-if="item.capHoc==3">THPT</p>
                                        <p v-else-if="item.capHoc==4">Nhà trẻ</p>
                                        <p v-else-if="item.capHoc==5">Mẫu giáo</p>
                                        <p v-else-if="item.capHoc==6">GDTX</p>
                                        <p v-else-if="item.capHoc==45">Mầm non</p>
                                        <p v-else-if="item.capHoc==12">Trường liên cấp TH+THCS</p>
                                        <p v-else-if="item.capHoc==13">Trường liên cấp TH+THPT</p>
                                        <p v-else-if="item.capHoc==23">Trường liên THCS+THPT</p>
                                        <p v-else-if="item.capHoc==123">Trường liên cấp TH+THCS+THPT</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenDonVi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiTrenQlnt }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoHocSinhDaNop }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoBanGhiDaNop }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.tongSoHocSinhTotNghiep }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.ngayNopCuoi }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="dataSearch.loaiDuLieu==14" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="text-center">
                                        <p>Mã trường</p>
                                    </th>
                                    <th>
                                        <p>Trường học</p>
                                    </th>
                                    <th>
                                        <p>Đối tác</p>
                                    </th>
                                    <th>
                                        <p>Cấp học</p>
                                    </th>
                                    <th>
                                        <p>Đơn vị quản lý</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ký hiệu</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Tình trạng</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="8" class="text-center">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td>
                                        <p>{{ item.maTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maDoiTac }}</p>
                                    </td>
                                    <td>
                                        <p v-if="item.capHoc==1">Tiểu học</p>
                                        <p v-else-if="item.capHoc==2">THCS</p>
                                        <p v-else-if="item.capHoc==3">THPT</p>
                                        <p v-else-if="item.capHoc==4">Nhà trẻ</p>
                                        <p v-else-if="item.capHoc==5">Mẫu giáo</p>
                                        <p v-else-if="item.capHoc==6">GDTX</p>
                                        <p v-else-if="item.capHoc==45">Mầm non</p>
                                        <p v-else-if="item.capHoc==12">Trường liên cấp TH+THCS</p>
                                        <p v-else-if="item.capHoc==13">Trường liên cấp TH+THPT</p>
                                        <p v-else-if="item.capHoc==23">Trường liên THCS+THPT</p>
                                        <p v-else-if="item.capHoc==123">Trường liên cấp TH+THCS+THPT</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenDonVi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.ngayNopCuoi }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.kyHieuBieuMau }}</p>
                                    </td>
                                    <td>
                                        <p v-html="item.duLieuLoi"></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="dataSearch.loaiDuLieu==16" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <!-- <th class="text-center"> <p>STT trường</p> </!-->
                                    <th class="text-center">
                                        <p>Mã trường</p>
                                    </th>
                                    <th>
                                        <p>Trường học</p>
                                    </th>
                                    <th>
                                        <p>Đối tác</p>
                                    </th>
                                    <th>
                                        <p>Cấp học</p>
                                    </th>
                                    <th>
                                        <p>Đơn vị quản lý</p>
                                    </th>
                                    <th class="text-center">
                                        <p>GV ngoại ngữ</p>
                                    </th>
                                    <th class="text-center">
                                        <p>GV được BDNCNL Ngoại ngữ</p>
                                    </th>
                                    <th class="text-center">
                                        <p>GV được BDNCNL Sư phạm</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <!-- <td class="text-center"> <p>{{(currentPage-1)*(limit) + item.stt}}</p>
                                </td> -->
                                    <td>
                                        <p>{{ item.maTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ item.maDoiTac }}</p>
                                    </td>
                                    <td>
                                        <p v-if="item.capHoc==1">Tiểu học</p>
                                        <p v-else-if="item.capHoc==2">THCS</p>
                                        <p v-else-if="item.capHoc==3">THPT</p>
                                        <p v-else-if="item.capHoc==4">Nhà trẻ</p>
                                        <p v-else-if="item.capHoc==5">Nhà trẻ</p>
                                        <p v-else-if="item.capHoc==45">Mầm non</p>
                                        <p v-else-if="item.capHoc==12">Trường liên cấp TH+THCS</p>
                                        <p v-else-if="item.capHoc==13">Trường liên cấp TH+THPT</p>
                                        <p v-else-if="item.capHoc==23">Trường liên THCS+THPT</p>
                                        <p v-else-if="item.capHoc==123">Trường liên cấp TH+THCS+THPT</p>
                                    </td>
                                    <td>
                                        <p>{{ item.tenDonVi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.soGvNgoaiNgu }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.soGvCoQuaTrinhBdncnlnn }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.soGvCoQuaTrinhBdncnlsp }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ item.ngayNopCuoi }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </el-col>
                <!-- <el-col :span="12">
                    <ChonSoLuong @chonXongSoLuong="ChonSoLuongBanGhi($event)">
                    </ChonSoLuong>
                </el-col>
                <el-col :span="12">
                    <PhanTrang v-show="total_rows>0" :tongbanghi="total_rows" :soluonghienthi="soLuongBanGhiHienThi"
                        :batdau="trangbatdau" @pageChange="layLai($event)">
                    </PhanTrang>
                </el-col> -->
                <el-col :span="24">
                    <PhanTrang :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                    </PhanTrang>
                </el-col>
            </el-row>
        </div>
    </div>
</template>
<script>
    import rest_api from "../../utils/rest_api";
    import ESelectVue from '../ui/ESelect.vue';
    import constant from '../../utils/constant';
    import ChonSoLuong from "../ui/chonSoLuongBanGhi";
    import PhanTrang from "../ui/PagingCustom";
    import moment from 'moment';
    import VueAlertify from "vue-alertify";
    import Breadcrumb from "../ui/Breadcrumb.vue";

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
        components: {
            'eselect': ESelectVue,
            "PhanTrang": PhanTrang,
            ChonSoLuong: ChonSoLuong,
            Breadcrumb
        },
        computed: {},
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                trangbatdau: false,
                loading: {
                    status: false,
                    text: 'Loading...'
                },
                list_du_lieu: [],
                donVi: [],
                capHoc: [],
                truongHoc: [],
                dataSearch: {
                    truongHoc: [],
                    namHoc: '',
                    loaiDuLieu: '',
                },
                rules: {
                    truongHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['blur', 'change']
                    }, ],
                    namHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    loaiDuLieu: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                },
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                soLuongBanGhiHienThi: 25,
                date: new Date(),
                namHoc: "",
                hocKy: "",
                loaiDuLieu: "",
                list_don_vi: [],
                danh_sach_cap_hoc_full: window.listCapHoc,
                list_truong_hoc: [],
                list_loai_du_lieu: constant.list_loai_du_lieu_bao_cao_tinh_hinh_nop_du_lieu,
                list_hoc_ky: [{
                    name: "Học kỳ I",
                    value: "1"
                }, {
                    name: "Học kỳ II",
                    value: "2"
                }, {
                    name: "Cả năm",
                    value: "3"
                }],
                list_nam_hoc: constant.LIST_YEARS_FULL,
            }
        },
        mounted() {
            this.dataSearch.namHoc = this.thongtin.namHocHienTai;
            this.getDonVi();
            console.log("Đơn vị là:")
            console.log(this.thongtin)
            if (this.thongtin.role == 5) {

                this.dataSearch.truongHoc = [this.thongtin.ma_truong_hoc]
                if (this.thongtin.sso && this.thongtin.sso == true) {

                    let obj = {
                        name: this.thongtin.display_name + ' - [' + this.thongtin.ma_truong_hoc + ']',
                        value: this.thongtin.ma_truong_hoc
                    }
                    this.list_truong_hoc = [obj]
                } else {
                    this.getThongTinTruong();
                    // Tài khoản đăng nhập là trường;
                }
                if (this.thongtin.listCapHoc) {
                    this.capHoc = this.thongtin.listCapHoc;
                } else {
                    this.capHoc = [];
                }
            }
            if (this.thongtin.role > 3) {
                this.donVi = [this.thongtin.ma_don_vi];
            }
        },
        watch: {},
        methods: {
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.TruocKhiTim();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            getThongTinTruong() {
                try {
                    let params = {
                        p_ma: this.thongtin.ma_truong_hoc
                    };
                    rest_api.get("/internal-api/dmTruongHoc/detail", params, response => {
                        console.log("lấy thông tin trường");
                        console.log(response)
                        if (response.data.code == 200) {
                            let obj = {
                                name: response.data.data.tenTruongHoc + ' - [' + this.thongtin
                                    .ma_truong_hoc + ']',
                                value: response.data.data.maTruongHoc
                            }
                            this.list_truong_hoc = [obj]
                        } else {
                            let obj = {
                                name: this.thongtin.username + ' - [' + this.thongtin.ma_truong_hoc + ']',
                                value: this.thongtin.ma_truong_hoc
                            }
                            this.list_truong_hoc = [obj]
                        }
                    });
                } catch (e) {

                }
            },

            getDataExcel() {
                console.log('getDataExcel');
                let params = {
                    capHocList: this.capHoc,
                    hocKy: this.hocKy,
                    loaiDuLieu: this.dataSearch.loaiDuLieu,
                    maDonViList: this.donVi,
                    maTruongHocList: this.dataSearch.truongHoc,
                    namHoc: this.dataSearch.namHoc,
                };
                if (this.thongtin.role == 5) {
                    params.maDonViList = [];
                }

                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        console.log('Đồng ý xuất');
                        this.loading.status = true;
                        // this.thongBao('success', 'Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        rest_api.post(
                            "/csdlgd-report-api/bao-cao-tinh-hinh-nop-du-lieu/excel",
                            params,
                            data => {
                                this.loading.status = false;
                                if (data.data.rc == 0) {
                                    console.log("thành công");
                                    let url = this.thongtin.tenMien + data.data.urlContext;
                                    console.log("tải ở:" + url);
                                    window.open(url);

                                } else {
                                    // this.$alertify.error("Có lỗi sảy ra. Vui lòng thử lại.")
                                    this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
                                }
                            }
                        );
                    })
                    .catch(_ => {
                        console.log('Văng');
                    });

            },
            getNgayNopCuoi(e) {
                console.log("ngayNopCuoi")
                let duLieu = e;
                let result = null;
                for (let i = duLieu.length - 1; i >= 0; i--) {
                    if (duLieu[i].hocKi == 3 && duLieu[i].ngayNopCuoi) {
                        console.log("Ngày nộp cuối kì 3")
                        result = duLieu[i].ngayNopCuoi
                        return result;
                    }
                    if (duLieu[i].hocKi == 2 && duLieu[i].ngayNopCuoi) {
                        console.log("Ngày nộp cuối kì 2")
                        result = duLieu[i].ngayNopCuoi
                        console.log(result)
                        return result;
                    }
                    if (duLieu[i].hocKi == 1 && duLieu[i].ngayNopCuoi) {
                        console.log("Ngày nộp cuối kì 1")
                        result = duLieu[i].ngayNopCuoi
                        return result;
                    }
                }
                return result;
            },
            getSoHocSinhTotNghiep(e) {
                let duLieu = e;
                let result = null;
                for (let i = duLieu.length - 1; i >= 0; i--) {
                    if (duLieu[i].hocKi == 3 && duLieu[i].tongSoHocSinhTotNghiep) {
                        result = duLieu[i].tongSoHocSinhTotNghiep
                        return result;
                    }
                    if (duLieu[i].hocKi == 2 && duLieu[i].tongSoHocSinhTotNghiep) {
                        result = duLieu[i].tongSoHocSinhTotNghiep
                        return result;
                    }
                    if (duLieu[i].hocKi == 1 && duLieu[i].tongSoHocSinhTotNghiep) {
                        result = duLieu[i].tongSoHocSinhTotNghiep
                        return result;
                    }
                }
                return result;
            },
            getSoHocSinhTheoHocKy(e, a) {
                let hocKy = a
                let duLieu = e;
                let result = "";
                console.log(duLieu)
                for (let i = 0; i < duLieu.length; i++) {
                    if (duLieu[i].hocKi == hocKy) {
                        result = duLieu[i].tongSoBanGhiDaNop
                    }
                }
                return result;
            },
            chonLoaiDuLieu() {
                this.list_du_lieu = [];
                this.total_rows = 0;
            },
            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                console.log("Chọn số lượng bản ghi:")
                console.log(JSON.stringify(e));
                this.soLuongBanGhiHienThi = e.soluong;
            },
            getData() {
                console.log("Lấy dữ liệu");
                if (!this.dataSearch.truongHoc || this.dataSearch.truongHoc.length == 0) {
                    // this
                    //     .$alertify
                    //     .error("Vui lòng chọn trường học.");
                    this.thongBao('error', 'Vui lòng chọn trường học.')
                    return;
                }
                if (!this.dataSearch.loaiDuLieu) {
                    // this
                    //     .$alertify
                    //     .error("Vui lòng chọn loại dữ liệu.");
                    this.thongBao('error', 'Vui lòng chọn loại dữ liệu.')
                    return;
                }
                if (!this.dataSearch.namHoc) {
                    // this
                    //     .$alertify
                    //     .error("Vui lòng chọn năm học.");
                    this.thongBao('error', 'Vui lòng chọn năm học.')
                    return;
                } else {
                    let params = {
                        start: this.start,
                        limit: this.limit,
                        capHocList: this.capHoc,
                        hocKy: this.hocKy,
                        loaiDuLieu: this.dataSearch.loaiDuLieu,
                        maDonViList: this.donVi,
                        maTruongHocList: this.dataSearch.truongHoc,
                        namHoc: this.dataSearch.namHoc,
                    };
                    if (this.thongtin.role == 5) {
                        params.maDonViList = [];
                    }
                    this.list_du_lieu = [];
                    console.log("params:" + JSON.stringify(params));
                    this.loading.status = true;
                    rest_api.post(
                        "/csdlgd-report-api/bao-cao-tinh-hinh-nop-du-lieu",
                        params,
                        data => {
                            this.loading.status = false;
                            console.log("dữ liệu trả về:");
                            if (data.data.rc == 0) {
                                this.list_du_lieu = data.data.tableData;
                                this.total_rows = data.data.totalRows;
                                if (this.total_rows == 0) {
                                    // this
                                    //     .$alertify
                                    //     .error("Không có bản ghi nào được tìm thấy");
                                } else {
                                    // this
                                    //     .$alertify
                                    //     .success("Lấy dữ liệu thành công.");
                                }
                            } else {
                                // this
                                //     .$alertify
                                //     .error(data.data.rd);
                                this.thongBao('error', data.data.rd)
                            }
                        },
                    );
                }
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            layLaiTruong() {
                this.list_truong_hoc = [];
                this.dataSearch.truongHoc = [];
                this.getTruongHoc();
            },
            TruocKhiTim() {
                console.log("Ấn tìm kiếm")
                this.lsTruongUpdate = [];
                this.total_rows = 0;
                this.trangbatdau = !this.trangbatdau;
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.list_don_vi = [];
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    if (data.data.statusResponse == 0) {
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                tenDonVi: data_demo[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data_demo[i].maDonVi + ']',
                                maDonVi: data_demo[i].maDonVi,
                            }
                            this.list_don_vi.push(obj)
                        }
                        this.getTruongHoc();
                    } else {
                        // this.$alertify.error(data.data.message);
                        this.thongBao('error', data.data.message)
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
            getTruongHoc() {
                this.list_truong_hoc = [];
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                let params = {
                    maDonVi: this.donVi,
                    capHoc: this.capHoc,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    // loading.close();
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenTruongHoc + " - [" + data.data.rows[i]
                                    .maTruongHoc + "]",
                                value: data.data.rows[i].maTruongHoc,
                            }
                            data_demo.push(obj);
                        }
                        if (this.thongtin.role != 5) {
                            this.list_truong_hoc = data_demo;
                        }
                    } else {
                        if (this.thongtin.role != 5) {
                            this.list_truong_hoc = [];
                        }
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">
    .text-center {
        text-align: center;
        align-items: center;
        vertical-align: middle;
    }

    .text-center>th {
        text-align: center;
    }

</style>

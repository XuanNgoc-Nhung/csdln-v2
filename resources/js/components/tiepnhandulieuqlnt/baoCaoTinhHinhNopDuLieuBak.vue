con<template>
    <div>
        <!-- header -->
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ </a>
                <span>
                    <span class="kytu">
                        &raquo;</span> TIẾP NHẬN DỮ LIỆU QLNT
                    <span class="kytu">
                        &raquo;</span> Báo cáo tình hình nộp dữ liệu trường học</span>
            </div>
        </div>
        <!-- header end -->
        <!-- Bắt đầu filter -->
        <div>
            <div class="row">
                <div class="col-md-4 timkiem">
                    <label class="typo__label">Chọn đơn vị</label>
                    <div v-if="thongtin.role!=5&&thongtin.role!=4">
                        <multiselect v-model="danhSachDonVi" :options="ds_don_vi_custom" group-values="libs"
                            group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                            deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextDonVi"
                            :close-on-select="false" :multiple="true" @close="ChonDonVi" :clear-on-select="false"
                            :preserve-search="false" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                            selectedLabel="Đã chọn" :custom-label="setNameDonVi" placeholder="Chọn đơn vị"
                            track-by="tenDonVi">
                            <template v-if="danhSachDonVi.length>0" slot="selection"
                                slot-scope="{ values, search, isOpen }">
                                <span class="multiselect__single"
                                    v-if="values.length &amp;&amp; !isOpen">{{ danhSachDonVi.length }}
                                    đơn vị được chọn</span>
                            </template>
                            <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                            <span slot="noOptions">Danh sách trống</span>
                        </multiselect>
                    </div>
                    <div v-if="thongtin.role==5||thongtin.role==4">
                        <input disabled v-model="tenDonViDangNhap" class="form-control" placeholder="Chọn" />

                    </div>
                </div>
                <div class="col-md-2 timkiem">
                    <div>
                        <label class="typo__label">Chọn cấp học</label>
                        <div v-if="thongtin.role!=5">
                            <multiselect v-model="danhSachCapHoc" :options="ds_cap_hoc_custom" group-values="libs"
                                group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                                deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextCapHoc"
                                :close-on-select="false" @close="ChonCapHoc" :multiple="true" :clear-on-select="false"
                                :preserve-search="false" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                                selectedLabel="Đã chọn" :custom-label="setNameCapHoc" placeholder="Chọn cấp học"
                                label="name" track-by="name">
                                <template v-if="danhSachCapHoc.length>0" slot="selection"
                                    slot-scope="{ values, search, isOpen }">
                                    <span class="multiselect__single"
                                        v-if="values.length &amp;&amp; !isOpen">{{ danhSachCapHoc.length }}
                                        cấp học được chọn</span>
                                </template>
                                <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                                <span slot="noOptions">Danh sách trống</span>
                            </multiselect>
                        </div>
                        <div v-if="thongtin.role==5">
                            <input :disabled="thongtin.role == 5" class="form-control" placeholder="Cấp học"
                                :value="capHocDangNhap" />
                        </div>
                    </div>
                </div>
                <!-- Trường học -->
                <div class="col-md-4 timkiem">
                    <div v-if="thongtin.role!=5">
                        <label class="typo__label">Chọn trường học</label>
                        <multiselect v-model="danhSachTruongHoc" :options="list_truong_hoc_custom" group-values="libs"
                            group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                            deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextTruong"
                            :multiple="true" @close="ChonTruongHoc" :close-on-select="false" :clear-on-select="false"
                            deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                            :custom-label="setNameTruongHoc" placeholder="Chọn trường học" label="maTruongHoc"
                            track-by="maTruongHoc">
                            <template v-if="danhSachTruongHoc.length>0" slot="selection"
                                slot-scope="{ values, search, isOpen }">
                                <span class="multiselect__single"
                                    v-if="values.length &amp;&amp; !isOpen">{{ danhSachTruongHoc.length }}
                                    trường học được chọn</span>
                            </template>
                            <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                            <span slot="noOptions">Danh sách trống</span>
                        </multiselect>
                    </div>
                    <div v-if="thongtin.role==5">
                        <label>Trường học</label>
                        <input :disabled="thongtin.role == 5" :value="thongtin.display_name" class="form-control"
                            placeholder="Nhập..." />
                    </div>
                </div>
                <!-- Hết trường học -->
                <!-- Năm học -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Năm học
                        <span style="color:#DC0101">*</span></label>
                    <multiselect v-model="danhSachNamHoc" :options="list_nam_hoc" :custom-label="setNameNamHoc"
                        placeholder="Chọn năm học" label="name" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                        selectedLabel="Đã chọn" track-by="name"></multiselect>
                </div>
                <!-- Hết năm học -->
                <!-- Trạng thái -->

                <div class="col-md-2 timkiem">
                    <label>Học kỳ</label>
                    <select v-model="hocKy"
                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                        style="width:100%">
                        <option value="">Tất cả</option>
                        <option value="1">Học kỳ I</option>
                        <option value="2">Học kỳ II</option>
                        <option value="3">Cả năm</option>
                    </select>
                </div>
                <!-- Hết trạng thái -->
                <!-- Loại dữ liệu -->
                <div class="col-md-3">
                    <label class="typo__label">Loại dữ liệu
                        <span style="color:#DC0101">*</span></label>
                    <multiselect v-model="danhSachLoaiDuLieu" :options="list_loai_du_lieu" @close="chonLoaiDuLieu"
                        :custom-label="setNameNamHoc" placeholder="Chọn dữ liệu" label="name" deselectLabel="Đã chọn"
                        selectLabel="Chưa chọn" selectedLabel="Đã chọn" track-by="name"></multiselect>
                </div>
            </div>
        </div>
        <hr />
        <!-- hết filter -->
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-success" @click.prevent="checkTruocKhiTim()">Tìm kiếm</button>
                <button :disabled="list_du_lieu.length==0" class="btn btn-info" @click.prevent="getDataExcel()">Xuất Excel</button>
            </div>
        </div>
        <!-- hết button -->
        <hr />
        <!-- Bắt đầu danh sách học sinh-->
        <div class="row">
            <!-- Danh sách chi tiết -->
            <div class="col-md-12">
                <div class="responsive">
                    <div v-if="loaiDuLieu==-1" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr class="cg" style="background:#e4ebf5">
                                    <th rowspan="3"><p>STT</p></th>
                                    <th rowspan="3"><p>Mã trường</p></th>
                                    <th rowspan="3"><p>Tên trường</p></th>
                                    <th rowspan="3"><p>Đối tác</p></th>
                                    <th rowspan="3"><p>Cấp học</p></th>
                                    <th rowspan="3"><p>Đơn vị quản lý</p></th>
                                    <th colspan="6"><p>Cán bộ - Giáo viên</p></th>
                                    <th colspan="5"><p>Lớp</p></th>
                                    <th colspan="3"><p>Học sinh</p></th>
                                    <th colspan="3"><p>Kết quả học tập</p></th>
                                </tr>
                                <tr class="cg" style="background:#e4ebf5">
                                    <th rowspan="2"><p>Tổng số CB-GV trên QLNT</p></th>
                                    <th rowspan="2"><p>Tổng số CB-GV đã nộp</p></th>
                                    <th rowspan="2"><p>Ngày nộp cuối</p></th>
                                    <th colspan="3"><p>Đề án ngoại ngữ</p></th>
                                    <th rowspan="2"><p>Tổng số lớp trên QLNT</p></th>
                                    <th colspan="3"><p>Số lớp đã nộp</p></th>
                                    <th rowspan="2"><p>Ngày nộp cuối</p></th>
                                    <th rowspan="2"><p>Tổng số HS trên QLNT</p></th>
                                    <th rowspan="2"><p>Tổng số HS đã nộp</p></th>
                                    <th rowspan="2"><p>Ngày nộp cuối</p></th>
                                    <th rowspan="2"><p>Số HS đã nộp có KQHT</p></th>
                                    <th rowspan="2"><p>Số HS Tốt nghiệp <sup style="color:#DC0101">(1)</sup></p></th>
                                    <th rowspan="2"><p>Ngày nộp cuối</p></th>
                                </tr>
                                <tr class="cg" style="background:#e4ebf5">
                                    <th><p>Giáo viên ngoại ngữ</p></th>
                                    <th><p>GV được BDNCNL Ngoại ngữ</p></th>
                                    <th><p>GV được BDNCNL Sư phạm</p></th>
                                    <th><p>Tổng</p></th>
                                    <th><p>Số lớp ghép</p></th>
                                    <th><p>Số lớp đơn</p></th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="23" class="cg">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td class="cg">
                                        <p>{{(currentPage-1)*limit + i+1}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.tenTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maDoiTac}}</p>
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
                                        <p>{{item.tenDonVi}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.dlCanBo.tongSoBanGhiTrenQlnt}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.dlCanBo.tongSoBanGhiDaNop}}</p>
                                    </td>
                                    <td class="cg"><p>{{item.dlCanBo.ngayNopCuoi}}</p></td>
                                    <td class="cg"><p>{{item.dlDeAnNgoaiNgu.soGvNgoaiNgu}}</p></td>
                                    <td class="cg"><p>{{item.dlDeAnNgoaiNgu.soGvCoQuaTrinhBdncnlnn}}</p></td>
                                    <td class="cg"><p>{{item.dlDeAnNgoaiNgu.soGvCoQuaTrinhBdncnlsp}}</p></td>
                                    <td class="cg"><p>{{item.dlLopHoc.tongSoBanGhiTrenQlnt}}</p></td>
                                    <td class="cg"><p>{{item.dlLopHoc.tongSoBanGhiDaNop}}</p></td>
                                    <td class="cg"><p>{{item.dlLopHoc.soLopGhep}}</p></td>
                                    <td class="cg"><p>{{item.dlLopHoc.soLopDon}}</p></td>
                                    <td class="cg"><p>{{item.dlLopHoc.ngayNopCuoi}}</p></td>
                                    <td class="cg"><p>{{item.dlHocSinh.tongSoBanGhiTrenQlnt}}</p></td>
                                    <td class="cg"><p>{{item.dlHocSinh.tongSoBanGhiDaNop}}</p></td>
                                    <td class="cg"><p>{{item.dlHocSinh.ngayNopCuoi}}</p></td>
                                    <td class="cg"><p>{{item.dlKqht.tongSoBanGhiDaNop}}</p></td>
                                    <td class="cg"><p>{{item.dlKqht.tongSoHocSinhTotNghiep}}</p></td>
                                    <td class="cg"><p>{{item.dlKqht.ngayNopCuoi}}</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="loaiDuLieu==2" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="cg">
                                        <p>STT</p>
                                    </th>
                                    <th class="cg">
                                        <p>Mã trường</p>
                                    </th>
                                    <th class="cg">
                                        <p>Tên trường</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đối tác</p>
                                    </th>
                                    <th class="cg">
                                        <p>Cấp học</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đơn vị</p>
                                    </th>
                                    <th class="cg">
                                        <p>Tổng số CB-GV đã nộp từ QLNT</p>
                                    </th>
                                    <th class="cg">
                                        <p>Số CB-GV đang làm việc đã nộp năm học trước</p>
                                    </th>
                                    <th class="cg">
                                        <p>Số CB-GV đang làm việc đã nộp</p>
                                    </th>
                                    <th class="cg">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="12" class="cg">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td class="cg">
                                        <p>{{(currentPage-1)*limit + i+1}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.tenTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maDoiTac}}</p>
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
                                        <p>{{item.tenDonVi}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiTrenQlnt}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiDaNopNamTruoc}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiDaNop}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.ngayNopCuoi}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="loaiDuLieu==3" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th rowspan="2" class="cg">
                                        <p>STT</p>
                                    </th>
                                    <th rowspan="2" class="cg">
                                        <p>Mã trường</p>
                                    </th>
                                    <th rowspan="2" class="cg">
                                        <p>Tên trường</p>
                                    </th>
                                    <th rowspan="2" class="cg">
                                        <p>Đối tác</p>
                                    </th>
                                    <th rowspan="2" class="cg">
                                        <p>Cấp học</p>
                                    </th>
                                    <th rowspan="2" class="cg">
                                        <p>Đơn vị</p>
                                    </th>
                                    <th rowspan="2" class="cg">
                                        <p>Tổng số lớp trên QLNT</p>
                                    </th>
                                    <th colspan="4" class="cg">
                                        <p>Số lớp đã nộp</p>
                                    </th>
                                    <th rowspan="2" class="cg">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                                <tr style="background:#e4ebf5">
                                    <th><p>Tổng năm học trước</p></th>
                                    <th><p>Tổng</p></th>
                                    <th><p>Số lớp ghép</p></th>
                                    <th><p>Số lớp đơn</p></th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="12" class="cg">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td class="cg">
                                        <p>{{(currentPage-1)*limit + i+1}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.tenTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maDoiTac}}</p>
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
                                        <p>{{item.tenDonVi}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiTrenQlnt}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiDaNopNamTruoc}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiDaNop}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.soLopGhep}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.soLopDon}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.ngayNopCuoi}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="loaiDuLieu==4" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="cg">
                                        <p>STT</p>
                                    </th>
                                    <th class="cg">
                                        <p>Mã trường</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đối tác</p>
                                    </th>
                                    <th class="cg">
                                        <p>Tên trường</p>
                                    </th>
                                    <th class="cg">
                                        <p>Cấp học</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đơn vị</p>
                                    </th>
                                    <th class="cg">
                                        <p>Tổng số HS đang học trên QLNT</p>
                                    </th>
                                    <th class="cg">
                                        <p>Số HS đang học đã nộp năm học trước</p>
                                    </th>
                                    <th class="cg">
                                        <p>Số HS đang học đã nộp</p>
                                    </th>
                                    <th class="cg">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="12" class="cg">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>

                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td class="cg">
                                        <p>{{(currentPage-1)*limit + i+1}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maDoiTac}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.tenTruong}}</p>
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
                                        <p>{{item.tenDonVi}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiTrenQlnt}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiDaNopNamTruoc}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiDaNop}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.ngayNopCuoi}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="loaiDuLieu==5" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="cg">
                                        <p>STT</p>
                                    </th>
                                    <th class="cg">
                                        <p>Mã trường</p>
                                    </th>
                                    <th class="cg">
                                        <p>Tên trường</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đối tác</p>
                                    </th>
                                    <th class="cg">
                                        <p>Cấp học</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đơn vị</p>
                                    </th>
                                    <th class="cg">
                                        <p>Tổng số HS trên QLNT</p>
                                    </th>
                                    <th class="cg">
                                        <p>Số HS đã nộp</p>
                                    </th>
                                    <th class="cg">
                                        <p>Số HS đã nộp có KQHT</p>
                                    </th>
                                    <th class="cg">
                                        <p>Số HS tốt nghiệp <sup><i>(<span style="color:#DC0101">1</span>)</i></sup></p>
                                    </th>
                                    <th class="cg">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="11" class="cg">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>

                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td class="cg">
                                        <p>{{(currentPage-1)*limit + i+1}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.tenTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maDoiTac}}</p>
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
                                        <p>{{item.tenDonVi}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiTrenQlnt}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoHocSinhDaNop}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoBanGhiDaNop}}</p>
                                    </td>
                                    <td class="cg">
                                        <p>{{item.tongSoHocSinhTotNghiep}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.ngayNopCuoi}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="loaiDuLieu==14" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="cg">
                                        <p>Mã trường</p>
                                    </th>
                                    <th class="cg">
                                        <p>Tên trường</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đối tác</p>
                                    </th>
                                    <th class="cg">
                                        <p>Cấp học</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đơn vị</p>
                                    </th>
                                    <th class="cg">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                    <th class="cg">
                                        <p>Ký hiệu</p>
                                    </th>
                                    <th class="cg">
                                        <p>Tình trạng</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="8" class="cg">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <td>
                                        <p>{{item.maTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.tenTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maDoiTac}}</p>
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
                                        <p>{{item.tenDonVi}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.ngayNopCuoi}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.kyHieuBieuMau}}</p>
                                    </td>
                                    <td>
                                        <p v-html="item.duLieuLoi"></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-if="loaiDuLieu==16" class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <!-- <th class="cg"> <p>STT trường</p> </!-->
                                    <th class="cg">
                                        <p>Mã trường</p>
                                    </th>
                                    <th class="cg">
                                        <p>Tên trường</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đối tác</p>
                                    </th>
                                    <th class="cg">
                                        <p>Cấp học</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đơn vị</p>
                                    </th>
                                    <th class="cg">
                                        <p>GV ngoại ngữ</p>
                                    </th>
                                    <th class="cg">
                                        <p>GV được BDNCNL Ngoại ngữ</p>
                                    </th>
                                    <th class="cg">
                                        <p>GV được BDNCNL Sư phạm</p>
                                    </th>
                                    <th class="cg">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_du_lieu.length==0">
                                <tr>
                                    <td colspan="9" class="cg">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_du_lieu" :key="i">
                                    <!-- <td class="text-center"> <p>{{(currentPage-1)*(limit) + item.stt}}</p>
                                    </td> -->
                                    <td>
                                        <p>{{item.maTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.tenTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.maDoiTac}}</p>
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
                                        <p>{{item.tenDonVi}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.soGvNgoaiNgu}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.soGvCoQuaTrinhBdncnlnn}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.soGvCoQuaTrinhBdncnlsp}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.ngayNopCuoi}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        v-if="loaiDuLieu!=16&&loaiDuLieu!=14&&loaiDuLieu!=2&&loaiDuLieu!=3&&loaiDuLieu!=4&&loaiDuLieu!=5&&loaiDuLieu!=-1">
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <p>Vui lòng chọn loại dữ liệu cần tìm kiếm.</p>
                            </div>
                        </div>
                    </div>
                    <!-- Phân trang -->
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                    <!-- Hết phân trang -->

                        <div v-if="loaiDuLieu==5">
                            <p><b>Ghi chú:</b></p>
                            <p style="font-weight:bold"><span style="color:#DC0101;font-weight:bold">1</span>: Số học sinh tốt nghiệp:</p>
                            <ul style="font-weight:bold">
                                <li style=""><p style="color:green;font-weight:bold">Mầm non: <i style="color:blue;font-weight:400">Số trẻ hoàn thành chương trình mầm non (Dữ liệu nộp học kỳ 2).</i></p></li>
                                <li style=""><p style="color:green">Tiểu học: <i style="color:blue;font-weight:400">Số học sinh được đánh giá hoàn thành chương trình tiểu học (Dữ liệu nộp Học kỳ 2 - Giao đoạn cuối học kỳ 2).</i></p></li>
                                <li style=""><p style="color:green">THCS,THPT: <i style="color:blue;font-weight:400">Số học sinh được xét tốt nghiệp (Dữ liệu nộp học kỳ cuối năm).</i></p></li>
                            </ul>
                        </div>
                        <div v-if="loaiDuLieu==-1">
                            <p><b>Ghi chú:</b></p>
                            <p style="font-weight:bold"><span style="color:#DC0101;font-weight:bold">1</span>: Số học sinh tốt nghiệp:</p>
                            <ul style="font-weight:bold">
                                <li style=""><p style="color:green;font-weight:bold">Mầm non: <i style="color:blue;font-weight:400">số trẻ hoàn thành chương trình Mầm non (Dữ liệu nộp Học kỳ 2).</i></p></li>
                                <li style=""><p style="color:green">Tiểu học: <i style="color:blue;font-weight:400"> số học sinh được đánh giá hoàn thành chương trình tiểu học (Dữ liệu nộp Học kỳ 2 - Giai đoạn cuối kỳ 2).</i></p></li>
                                <li style=""><p style="color:green">THCS,THPT,GDTX: <i style="color:blue;font-weight:400">Số học sinh được xét tốt nghiệp (Dữ liệu nộp học kỳ cuối năm).</i></p></li>
                            </ul>
                        </div>
                    <!-- Chỉnh sửa học sinh -->
                </div>
            </div>
            <!-- Hết danh sách chi tiết -->
        </div>
        <!-- Hết danh sách học sinh -->
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    import constant from '../../utils/constant';
    import moment from "moment";
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import api from '../api';
    import Page from "../ui/PagingCustom2";
    import dialog from '../../utils/dialog';
    import VueAlertify from "vue-alertify";
    import utils from '../../utils';
    import {
        Loading
    } from 'element-ui';
    Vue.use(VueAlertify, {

        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            // dialogs default title
            title: 'Thông báo',
            // ok button text
            ok: 'Đồng ý',
            // cancel button text
            cancel: 'Hủy'
        }
    });
    export default {
        components: {
            Multiselect,
            Page: Page
        },
        props: [
             'domain'
        ],
        watch: {
            danhSachNamHoc: function (newVal) {
                this.namHocHienTai = "";
                this.params = {};
                if (newVal) {
                    this.namHocHienTai = newVal
                        .id
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                }
            },
            danhSachLoaiDuLieu: function (newVal) {
                this.total_rows = 0;
                this.list_du_lieu = [];
            }
        },

        data() {
            return {
                trangbatdau: false,
                tenDonViDangNhap: "",
                capHocDangNhap: "",

                ds_don_vi_custom: [{
                    selectAll: 'Chọn tất cả',
                    libs: []
                }, ],

                ds_cap_hoc_custom: [{
                    selectAll: 'Chọn tất cả',
                    libs: []
                }, ],
                list_truong_hoc_custom: [{
                    selectAll: 'Chọn tất cả',
                    libs: []
                }],
                //
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                thongtin: JSON.parse(window.userInfo),
                list_cap_hoc: window.listCapHoc,
                danhSachCapHoc: [],
                list_don_vi: [],
                ds_don_vi: [],
                danhSachDonVi: [],
                list_truong_hoc: [],
                danhSachTruongHoc: [],
                danhSachLoaiDuLieu: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_loai_du_lieu: constant.list_loai_du_lieu_bao_cao_tinh_hinh_nop_du_lieu,
                danhSachNamHoc: [],
                list_du_lieu: [],
                date: new Date(),
                hocKy: 1,
                namHocHienTai: "",
                tenMien: "",
                loaiDuLieu: "",
                ds_cap_hoc: [],
                ds_truong_hoc: []
            }
        },

        mounted() {
            console.log("Mount báo cáo");
            this.tenMien = this.thongtin.tenMien;
            if (this.thongtin.role == 5) {
                this.bindCapHocDangNhap();
            }
            this.ds_cap_hoc_custom[0].libs = this.list_cap_hoc;
            this.namHocHienTai = this
                .date
                .getFullYear();
            let thangNay = this
                .date
                .getMonth();
            thangNay = parseInt(thangNay) + 1;
            if (thangNay > 8) {} else {
                this.namHocHienTai -= 1;
            }
            this.namHoc = this.namHocHienTai;
            this.findNamHoc();
            this.getDonVi();
            this.getTruongHoc();
        },

        methods: {
            checkTruocKhiTim(){
                console.log("ấn tìm kiếm");
                this.trangbatdau = !this.trangbatdau;
            },
            getDataExcel() {
                if (!this.loaiDuLieu) {
                    this
                        .$alertify
                        .error("Vui lòng chọn loại dữ liệu.");
                    return;
                }
                if (!this.namHocHienTai) {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học.");
                    return;
                } else {
                    let params = {
                        capHocList: this.ds_cap_hoc,
                        hocKy: this.hocKy,
                        loaiDuLieu: this.loaiDuLieu,
                        maDonViList: this.ds_don_vi,
                        maTruongHocList: this.ds_truong_hoc,
                        namHoc: this.namHocHienTai,
                    };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                    rest_api.post(
                        "/csdlgd-report-api/bao-cao-tinh-hinh-nop-du-lieu/excel",
                        params,
                        data => {
                            loading.close();
                            if(data.data.rc==0){
                                console.log("thành công");
                                let url =this.tenMien + data.data.urlContext;
                                console.log("tải ở:" + url);
                                window.open(url);
                                // alert(url)
                                // window.open(url, '_blank');


                            }
                            else{
                                this.$alertify.error("Có lỗi sảy ra. Vui lòng thử lại.")
                            }
                        },60000,true
                    );
                }

            },
            bindCapHocDangNhap() {
                if (this.thongtin.listCapHoc.length == 1) {
                    for (let i = 0; i < this.thongtin.listCapHoc.length; i++) {
                        if (this.thongtin.listCapHoc[0] == 1) {
                            this.capHocDangNhap = "Tiểu học";
                        }
                        if (this.thongtin.listCapHoc[0] == 2) {
                            this.capHocDangNhap = "THCS";
                        }
                        if (this.thongtin.listCapHoc[0] == 3) {
                            this.capHocDangNhap = "THPT";
                        }
                        if (this.thongtin.listCapHoc[0] == 4) {
                            this.capHocDangNhap = "Nhà trẻ";
                        }
                        if (this.thongtin.listCapHoc[0] == 5) {
                            this.capHocDangNhap = "Nhà trẻ";
                        }
                        if (this.thongtin.listCapHoc[0] == 6) {
                            this.capHocDangNhap = "GDTX";
                        }
                    }
                } else {
                    if (this.thongtin.listCapHoc[0] == 4 && this.thongtin.listCapHoc[1] == 5) {
                        this.capHocDangNhap = "Mầm non";
                    } else {
                        this.capHocDangNhap = "Trường liên cấp";
                    }
                }
            },
            //đếm số phần tử khác được chọn trong select

            limitTextTruong(count) {
                return `và ${count} trường học khác`
            },
            limitTextCapHoc(count) {
                return `và ${count} cấp học khác`
            },
            limitTextDonVi(count) {
                return `và ${count} đơn vị khác`
            },

            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            ChonTruongHoc() {
                console.log("chọn trường học");
                this.ds_truong_hoc = "";
                if (this.danhSachTruongHoc) {
                    let lsth = this
                        .danhSachTruongHoc
                        .map((obj) => {
                            return obj['maTruongHoc']
                        });
                    this.ds_truong_hoc = lsth
                    console.log("Danh sách trường học:");
                    console.log(JSON.stringify(this.ds_truong_hoc));
                }
            },
            // Lấy dữ liệu
            getData() {
                if (!this.loaiDuLieu) {
                    this
                        .$alertify
                        .error("Vui lòng chọn loại dữ liệu.");
                    return;
                }
                if (!this.namHocHienTai) {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học.");
                    return;
                } else {
                    let params = {
                        start: this.start,
                        limit: this.limit,
                        capHocList: this.ds_cap_hoc,
                        hocKy: this.hocKy,
                        loaiDuLieu: this.loaiDuLieu,
                        maDonViList: this.ds_don_vi,
                        maTruongHocList: this.ds_truong_hoc,
                        namHoc: this.namHocHienTai,
                    };
                    this.total_rows = 0;
                    this.list_du_lieu = [];
                    console.log("params:" + JSON.stringify(params));

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                    rest_api.post(
                        "/csdlgd-report-api/bao-cao-tinh-hinh-nop-du-lieu",
                        params,
                        data => {
                            loading.close();
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

                                this
                                    .$alertify
                                    .error(data.data.rd);
                            }
                        },
                        60000,
                        true
                    );
                }
            },
            chonLoaiDuLieu() {
                console.log("chọn loại dữ liệu");
                this.loaiDuLieu = "";
                if (this.danhSachLoaiDuLieu) {
                    this.loaiDuLieu = this.danhSachLoaiDuLieu.id;
                }

            },
            ChonCapHoc() {
                this.list_truong_hoc_custom = [];
                this.danhSachTruongHoc = [];
                this.ds_truong_hoc = [];
                this.ds_cap_hoc = [];
                if (this.danhSachCapHoc) {
                    let lsch = this
                        .danhSachCapHoc
                        .map((obj) => {
                            return obj['id']
                        });
                    this.ds_cap_hoc = lsch;
                }
                this.getTruongHoc();
            },

            ChonDonVi() {
                console.log("Chọn đơn vị:");
                // console.log(JSON.stringify(this.danhSachDonVi));
                this.ds_truong_hoc = [];
                this.list_truong_hoc_custom = [];
                this.danhSachTruongHoc = [];
                if (this.danhSachDonVi) {
                    let lsdv = this
                        .danhSachDonVi
                        .map((obj) => {
                            return obj['maDonVi']
                        });
                    this.ds_don_vi = lsdv;
                }
                console.log("danh sách đơn vị:" + JSON.stringify(this.ds_don_vi));
                this.getTruongHoc();
            },

            // Lấy danh sách trường học Lấy trường học
            getTruongHoc() {
                this.list_truong_hoc_custom = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    if (data.data.code == 200) {
                        this.list_truong_hoc = data.data.rows;
                        console.log("demo ở đây:");
                        let obj = {
                            selectAll: "Chọn tất cả",
                            libs: this.list_truong_hoc,
                        }
                        this.list_truong_hoc_custom = [obj];
                        // if(data.data.rows.length>0){
                        //     this.list_truong_hoc_custom[0].selectAll = "Chọn tất cả";
                        //     this.list_truong_hoc_custom[0].libs = data.data.rows;}
                    }
                });
            },
            // Lấy danh sách đơn vị
            getDonVi(ck = () => {}) {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.province
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        this.list_don_vi = data.data.rows;
                        this.ds_don_vi_custom[0].libs = this.list_don_vi;
                        if (this.thongtin.role == 4 || this.thongtin.role == 5 || this.thongtin.role == 40) {
                            if (this.thongtin.role == 4 || this.thongtin.role == 5) {
                                for (let i = 0; i < this.list_don_vi.length; i++) {
                                    if (this.list_don_vi[i].maDonVi == this.thongtin.ma_don_vi) {
                                        this.ds_don_vi = [this.thongtin.ma_don_vi];
                                        this.danhSachDonVi = [this.list_don_vi[i]];
                                        this.tenDonViDangNhap = this.list_don_vi[i].tenDonVi;
                                    }
                                }
                            }
                        }
                        ck();
                    }
                });
            },
            // gán năm học
            findNamHoc() {
                for (let i = 0; i < this.list_nam_hoc.length; i++) {
                    if (this.list_nam_hoc[i].id == this.namHocHienTai) {
                        this.danhSachNamHoc = this.list_nam_hoc[i];
                    }
                }
            },
            // định nghĩa cho đơn vị
            setNameDonVi({
                tenDonVi,
                maDonVi
            }) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // định nghĩa cho trường
            setNameTruongHoc({
                tenTruongHoc,
                maTruongHoc
            }) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            // định nghĩa cho cấp học
            setNameCapHoc({
                name
            }) {
                return `${name}`
            },
            // định nghĩa cho năm học
            setNameNamHoc({
                name
            }) {
                return `${name}`
            }
        }

    }

</script>

<style scoped="scoped">
    @import "../../../../node_modules/selectwithsearch.css";

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        padding: 0;
        margin: 0;
    }

    hr {
        margin: 5px;
    }

    a,
    p,
    span {
    }

    .cg {
        text-align: center;
        align-items: center;
        vertical-align: middle;
    }
    .cg>th{
        text-align:center;
    }

</style>

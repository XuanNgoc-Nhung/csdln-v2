<template>
    <!-- bắt đầu template -->
    <div>
        <!-- bắt đầu header -->
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Tra cứu<span class="kytu">
                        &raquo;</span> Tra cứu học sinh</span>
            </div>
        </div>
        <!-- hết header -->
        <!-- bắt đầu fillter -->
        <div>
            <div class="row">
                <div class="col-md-4 timkiem">
                    <label class="typo__label">Chọn đơn vị</label>
                    <div v-if="thongtin.role<4">
                        <multiselect v-model="danhSachDonVi" :options="ds_don_vi_custom" group-values="libs"
                            group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                            deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextDonVi"
                            :close-on-select="false" :multiple="true" @close="ChonDonVi" :clear-on-select="false"
                            :preserve-search="false" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                            selectedLabel="Đã chọn" :custom-label="setNameDonVi" placeholder="Chọn" track-by="tenDonVi">
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
                                selectedLabel="Đã chọn" :custom-label="setNameCapHoc" placeholder="Chọn" label="name"
                                track-by="name">
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
                <!-- Khối học -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Khối học</label>
                    <multiselect v-model="danhSachKhoiHoc" :options="list_khoi_hoc" :multiple="true"
                        :custom-label="setNameCapHoc" @close="chonKhoiHoc" placeholder="Chọn" label="name"
                        @open="moKhoiHoc" :close-on-select="false" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                        selectedLabel="Đã chọn" track-by="name">
                        <template v-if="danhSachKhoiHoc.length>1" slot="selection"
                            slot-scope="{ values, search, isOpen }">
                            <span class="multiselect__single"
                                v-if="values.length &amp;&amp; !isOpen">{{ values.length }}
                                khối học được chọn</span>
                        </template>
                    </multiselect>
                </div>
                <!-- Hết khối học -->
                <!-- Trường học -->
                <div class="col-md-4 timkiem">
                    <div v-if="thongtin.role!=5">
                        <label class="typo__label">Chọn trường học</label>
                        <multiselect v-model="danhSachTruongHoc" :options="list_truong_hoc_custom" group-values="libs"
                            group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                            deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextTruong"
                            :multiple="true" @close="ChonTruongHoc" :close-on-select="false" :clear-on-select="false"
                            deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                            :custom-label="setNameTruongHoc" placeholder="Chọn" label="maTruongHoc"
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
            </div>
            <div class="row">
                <!-- Từ khóa -->
                <div class="col-md-4 timkiem">
                    <label>Từ khóa</label>
                    <input v-model="tuKhoa" class="form-control" placeholder="Tên/mã/số CMND,..." />
                </div>
                <!-- Hết từ khóa -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Tên lớp học</label>
                    <input v-model="tenLopHoc" class="form-control" placeholder="Nhập..." />
                </div>
                <!-- Giới tính -->

                <div class="col-md-2 timkiem">
                    <label>Giới tính</label>
                    <select v-model="gioiTinh"
                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                        style="width:100%">
                        <option value=''>Chọn</option>
                        <option value='1'>Nam
                        </option>
                        <option value='0'>Nữ</option>
                    </select>
                </div>
                <!-- hết giới tính -->
                <!-- Trạng thái -->

                <div class="col-md-2 timkiem">
                    <label>Trạng thái</label>
                    <select v-model="trangThai"
                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                        style="width:100%">
                        <option value="">Chọn</option>
                        <option v-for="(tt,i) in list_trang_thai_hoc_sinh" :key="i" :value="tt.id">{{tt.name}}</option>
                    </select>
                </div>
                <!-- Hết trạng thái -->
                <!-- Năm học -->
                <div class="col-md-2 timkiem">
                    <label class="typo__label">Năm học</label>
                    <multiselect v-model="danhSachNamHoc" :options="list_nam_hoc" :custom-label="setNameNamHoc"
                        placeholder="Chọn" label="name" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                        selectedLabel="Đã chọn" track-by="name"></multiselect>
                </div>
                <!-- Hết năm học -->

            </div>
            <div class="row">
                <!-- Tùy chọn hiển thị -->
                <div class="col-md-4 timkiem">
                    <label class="typo__label">Nội dung hiển thị<span style="color:#DC0101">*</span></label>
                    <div>
                        <multiselect v-model="danhSachTimKiem" :options="ds_tim_kiem_tra_cuu_hoc_sinh"
                            group-values="libs" group-label="selectAll" :group-select="true"
                            selectGroupLabel="Ấn để chọn tất cả" deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1"
                            :limit-text="limitTextTieuChi" :close-on-select="false" :multiple="true"
                            @close="ChonTieuChi" :clear-on-select="false" :preserve-search="false"
                            deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                            :custom-label="setNameNamHoc" placeholder="Chọn" track-by="name">
                            <template v-if="danhSachDonVi.length>0" slot="selection"
                                slot-scope="{ values, search, isOpen }">
                                <span class="multiselect__single"
                                    v-if="values.length &amp;&amp; !isOpen">{{ danhSachTimKiem.length }}
                                    tiêu chí được chọn</span>
                            </template>
                            <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                            <span slot="noOptions">Danh sách trống</span>
                        </multiselect>
                    </div>
                </div>
                <!-- Hết tùy chọn hiển thị -->
                <!-- nâng cao -->
                <!-- <div class="col-md-3">
                    <div style="padding-top:28px;">
                        <input v-model="timKiemNangCao" type="checkbox">
                        Tìm kiếm nâng cao
                    </div>
                </div> -->
                <div class="col-md-4">
                    <label class="typo__label">Tìm kiếm nâng cao<span style="color:#DC0101">*</span></label>
                    <!-- <el-select v-model="danhSachTimKiemNangCao" multiple filterable collapse-tags
                        placeholder="Chọn nội dung tìm kiếm nâng cao" no-data-text="Không có dữ liệu"
                        no-match-text="Không có dữ liệu phù hợp">
                        <el-option v-for="item in list_tim_kiem_nang_cao" :key="item.value" :label="item.name"
                            :value="item.value">
                        </el-option>
                    </el-select> -->

                        <eselect style="width:100%" multiple collapseTags v-model="danhSachTimKiemNangCao" :placeholder="'Chọn'"
                            filterable :data="list_tim_kiem_nang_cao" :fields="['name','value']" />
                </div>
            </div>
            <!-- Tìm kiếm nâng cao -->
            <div v-if="timKiemNangCao">
                <hr v-if="danhSachTimKiemNangCao.length>0" />
                <div class="row">
                    <div class="col-md-2" v-if="hienThiNangCao.ngaySinh">
                        <label>Ngày sinh</label>
                        <date-picker :config="configDatePicker" placeholder="Chọn" v-model="nangCao.ngaySinh">
                        </date-picker>
                    </div>
                    <!-- Nơi sinh -->
                    <div class="col-md-2" v-if="hienThiNangCao.noiSinh">
                        <label>Nơi sinh</label>
                        <input type="text" class="form-control" v-model="nangCao.noiSinh" placeholder="Nhập...">
                    </div>
                    <!-- Dân tộc -->
                    <div class="col-md-2" v-if="hienThiNangCao.maDanToc">
                        <label>Dân tộc</label>

                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.maDanToc" :placeholder="'Chọn'"
                            filterable :data="list_dan_toc" :fields="['name','value']" />
                    </div>
                    <!-- Tôn giáo -->
                    <div class="col-md-2" v-if="hienThiNangCao.maTonGiao">
                        <label>Tôn giáo</label>
                        <!-- <el-select v-model="nangCao.maTonGiao" multiple filterable collapse-tags placeholder="Chọn"
                            no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                            <el-option v-for="item in list_ton_giao" :key="item.value" :label="item.name"
                                :value="item.value">
                            </el-option>
                        </el-select> -->
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.maTonGiao" :placeholder="'Chọn'"
                            filterable :data="list_ton_giao" :fields="['name','value']" />
                    </div>
                    <!-- Tôn giáo -->
                    <div class="col-md-2" v-if="hienThiNangCao.maLopHocCn">
                        <label>Tên lớp học</label>
                        <input type="text" class="form-control" v-model="nangCao.maLopHocCn"
                            placeholder="Nhập...">
                    </div>
                    <!-- Địa chỉ thường trú -->

                    <div class="col-md-2" v-if="hienThiNangCao.dchiThtru">
                        <label>Địa chỉ thường trú</label>
                        <input type="text" class="form-control" v-model="nangCao.dchiThtru"
                            placeholder="Nhập...">
                    </div>
                    <!-- Địa chỉ tạm trú -->
                    <div class="col-md-2" v-if="hienThiNangCao.dchiTmtru">
                        <label>Địa chỉ tạm trú</label>
                        <input type="text" class="form-control" v-model="nangCao.dchiTmtru"
                            placeholder="Nhập...">
                    </div>
                    <!-- Khu vực -->
                    <div class="col-md-2" v-if="hienThiNangCao.maKhuVuc">
                        <label>Khu vực</label>
                        <!-- <el-select v-model="nangCao.maKhuVuc" multiple filterable collapse-tags placeholder="Chọn">
                            <el-option v-for="item in list_khu_vuc" :key="item.value" :label="item.name"
                                :value="item.value">
                            </el-option>
                        </el-select> -->
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.list_khu_vuc" :placeholder="'Chọn'"
                            filterable :data="list_khu_vuc" :fields="['name','value']" />
                    </div>
                    <!-- Khu vực -->
                    <div class="col-md-2" v-if="hienThiNangCao.gioiTinh">
                        <label>Giới tính</label>
                        <select v-model="nangCao.gioiTinh" class="form-control">
                            <option value="">Chọn</option>
                            <option value="1">Nam</option>
                            <option value="0">Nữ</option>
                        </select>
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.loaiNhapHoc">
                        <label>Loại nhập học</label>
                        <el-select v-model="nangCao.loaiNhapHoc" filterable collapse-tags placeholder="Chọn">
                            <el-option v-for="item in list_loai_nhap_hoc" :key="item.value" :label="item.name"
                                :value="item.value">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.maLyDoThoiHoc">
                        <label>Lý do thôi học</label>
                        <!-- <el-select v-model="nangCao.maLyDoThoiHoc" multiple filterable collapse-tags placeholder="Chọn">
                            <el-option v-for="item in list_thoi_hoc" :key="item.value" :label="item.name"
                                :value="item.value">
                            </el-option>
                        </el-select> -->
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.maLyDoThoiHoc" :placeholder="'Chọn'"
                            filterable :data="list_thoi_hoc" :fields="['name','value']" />
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.doiVien">
                        <label>Đội viên</label>
                        <select v-model="nangCao.doiVien"
                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                            style="width:100%">
                            <option value=''>Chọn</option>
                            <option value='1'>Có</option>
                            <option value='0'>Không</option>
                        </select>
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.doanVien">
                        <label>Đoàn viên</label>
                        <select v-model="nangCao.doanVien"
                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                            style="width:100%">
                            <option value=''>Chọn</option>
                            <option value='1'>Có</option>
                            <option value='0'>Không</option>
                        </select>
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.khuyetTat">
                        <label>Khuyết tật</label>
                        <select v-model="nangCao.khuyetTat"
                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                            style="width:100%">
                            <option value=''>Chọn</option>
                            <option value='1'>Có</option>
                            <option value='0'>Không</option>
                        </select>
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.lopGhep">
                        <label>Lớp ghép</label>
                        <select v-model="nangCao.lopGhep"
                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                            style="width:100%">
                            <option value=''>Chọn</option>
                            <option value='1'>Có</option>
                            <option value='0'>Không</option>
                        </select>
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.lopChuyen">
                        <label>Lớp chuyên</label>
                        <select v-model="nangCao.lopChuyen"
                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                            style="width:100%">
                            <option value=''>Chọn</option>
                            <option value='1'>Có</option>
                            <option value='0'>Không</option>
                        </select>
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.danTocThieuSo">
                        <label>Dân tộc thiểu số</label>
                        <select v-model="nangCao.danTocThieuSo"
                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                            style="width:100%">
                            <option value=''>Chọn</option>
                            <option value='1'>Có</option>
                            <option value='0'>Không</option>
                        </select>
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.doiTuongChinhSach">
                        <label>Đối tượng C.sách</label>
                        <!-- <el-select v-model="nangCao.doiTuongChinhSach" multiple collapse-tags filterable
                            placeholder="Chọn">
                            <el-option v-for="item in list_dtcs" :key="item.value" :label="item.name"
                                :value="item.value">
                            </el-option>
                        </el-select> -->
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.doiTuongChinhSach" :placeholder="'Chọn'"
                            filterable :data="list_dtcs" :fields="['name','value']" />
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.moetCode">
                        <label>Mã định danh</label>
                        <input type="text" class="form-control" v-model="nangCao.moetCode"
                            placeholder="Nhập...">
                    </div>
                </div>
            </div>
            <!-- Hết tìm kiếm nâng cao -->
        </div>
        
        <!-- hết filter -->
        <!-- buttom -->
        <div class="row">
            <div class="col-md-12 text-center">
                <button class="btn btn-success" @click.prevent="checkTruocKhiTim()">Tìm kiếm</button>
                <button v-bind:disabled="list_hocsinh.length==0" class="btn btn-info" :show="show_excel_hoc_sinh"
                    @close="show_excel_hoc_sinh=false" :limit="10" @click.prevent="xuatDuLieuHocSinh">Xuất
                    Excel</button>
                <!-- <button v-if="list_hocsinh.length>0" class="btn btn-info" v-on:click.prevent="CheckXuatExcel()">Xuất
                    Excel</button> -->
            </div>
        </div>
        <!-- hết button -->
        
        <!-- Bắt đầu danh sách học sinh-->
        <div class="row">
            <!-- Button -->
            <div class="col-md-12">
                <div class="pull-right">
                    <button class="btn btn-danger" v-if="thongtin.role!=5" @click.prevent="DeleteStudent"
                        style="margin:2px 0; float:right">Xóa</button>
                    <button class="btn btn-danger" v-if="thongtin.role!=5" style="margin:2px 4px; float:right"
                        @click.prevent="DeleteMoetCode">Xóa mã định danh</button>
                </div>
            </div>
            <!-- Hết button -->
            <!-- Danh sách chi tiết -->
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr style="background:#e4ebf5">
                                <th class="cg">
                                    <p>STT</p>
                                </th>
                                <th v-for="item in cotHienThi" class="cg">
                                    <p>{{item.name}}</p>
                                </th>
                                <th class="cg">
                                    <p>Sửa</p>
                                </th>
                                <th class="cg">
                                    <input type="checkbox" v-model="slectAll">
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="list_hocsinh.length==0">
                            <tr>
                                <td :colspan="danhSachTimKiem.length+3" class="cg">
                                    <p>Không có bản ghi nào</p>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="(hs,i) in list_hocsinh" :key="i">
                                <td class="text-center">
                                    <p>{{(currentPage-1)*limit + i+1}}</p>
                                </td>
                                <td v-if="hangHienThi.maTruongHoc">
                                    <p>{{hs.maTruongHoc}}</p>
                                </td>
                                <td v-if="hangHienThi.tenTruongHoc">
                                    <p>{{hs.tenTruongHoc}}</p>
                                </td>
                                <td v-if="hangHienThi.capHoc">
                                    <p>{{hs.capHoc}}</p>
                                </td>
                                <td v-if="hangHienThi.khoiHoc">
                                    <p>{{hs.khoiHoc}}</p>
                                </td>
                                <td v-if="hangHienThi.tenLopHoc">
                                    <p>{{hs.tenLopHoc}}</p>
                                </td>
                                <td v-if="hangHienThi.tenHocSinh">
                                    <p>{{hs.tenHocSinh}}</p>
                                </td>
                                <td v-if="hangHienThi.hoTen" style="text-align:left">
                                    <a href="#" v-on:click.prevent="showInFo(hs.hocSinhTheoNamId)"
                                        title="Chi tiết">{{hs.hoTen}}</a>
                                    <!-- <p>{{hs.hoTen}}</p> -->
                                </td>
                                <td v-if="hangHienThi.maHocSinh">
                                    <!-- <a title="Chỉnh sửa" v-on:click.prevent="ShowUpdate(hs.hocSinhTheoNamId)"><i class="far fa-edit">Sửa</i></a> -->
                                    <a href="#" v-on:click.prevent="showInFo(hs.hocSinhTheoNamId)"
                                        title="Chi tiết">{{hs.maHocSinh}}</a>
                                    <!-- <p>{{hs.hoTen}}</p> -->
                                </td>
                                <td v-if="hangHienThi.moetCode">
                                    <p>{{hs.moetCode}}</p>
                                </td>
                                <td v-if="hangHienThi.ngaySinh">
                                    <p>{{hs.ngaySinh}}</p>
                                </td>
                                <td v-if="hangHienThi.gioiTinh">
                                    <p>{{hs.gioiTinh}}</p>
                                </td>
                                <td v-if="hangHienThi.trangThai">
                                    <p>{{hs.trangThai}}</p>
                                </td>
                                <td v-if="hangHienThi.maDanToc">
                                    <p>{{hs.maDanToc}}</p>
                                </td>
                                <td v-if="hangHienThi.maTonGiao">
                                    <p>{{hs.maTonGiao}}</p>
                                </td>
                                <td v-if="hangHienThi.noiSinh">
                                    <p>{{hs.noiSinh}}</p>
                                </td>
                                <td v-if="hangHienThi.dchiThtru">
                                    <p>{{hs.dchiThtru}}</p>
                                </td>
                                <td v-if="hangHienThi.dchiTmtru">
                                    <p>{{hs.dchiTmtru}}</p>
                                </td>
                                <td v-if="hangHienThi.soCmnd">
                                    <p>{{hs.soCmnd}}</p>
                                </td>
                                <td v-if="hangHienThi.soDthoaiCdinh">
                                    <p>{{hs.soDthoaiCdinh}}</p>
                                </td>
                                <td v-if="hangHienThi.maDtuongCsach">
                                    <p>{{hs.maDtuongCsach}}</p>
                                </td>
                                <td v-if="hangHienThi.hoTenBo">
                                    <p>{{hs.hoTenBo}}</p>
                                </td>
                                <td v-if="hangHienThi.hoTenMe">
                                    <p> {{hs.hoTenMe}}</p>
                                </td>
                                <td v-if="hangHienThi.hieuTruong">
                                    <p>{{hs.hieuTruong}}</p>
                                </td>
                                <td v-if="hangHienThi.email">
                                    <p>{{hs.email}}</p>
                                </td>
                                <td v-if="hangHienThi.doiVien">
                                    <p>{{hs.doiVien}}</p>
                                </td>
                                <td v-if="hangHienThi.doanVien">
                                    <p>{{hs.doanVien}}</p>
                                </td>
                                <td class="text-center">
                                    <a title="Chỉnh sửa" v-on:click.prevent="ShowUpdate(hs.hocSinhTheoNamId)"><i
                                            class="far fa-edit"></i></a>
                                </td>
                                <td class="text-center">
                                    <input type="checkbox" v-model="lsDelete" :value="hs.hocSinhTheoNamId">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Phân trang -->
                <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                <!-- Hết phân trang -->
                <!-- Chỉnh sửa học sinh -->
                <div v-if="show_update">
                    <update-hocsinh :item="dataUpdateHocSinh" @close="show_update=false" @success="dongSuaHs()">
                    </update-hocsinh>
                </div>
                <div v-if="show_info">
                    <info-hocsinh :item="dataInfoHocSinh" @close="show_info=false" @close2="dongSuaHs()">
                    </info-hocsinh>
                </div>
                <!-- Hết chỉnh sửa học sinh -->
                <!-- Xuất dữ liệu excel có start và limit -->
                <popup-limit-hoc-sinh :show="show_excel_hoc_sinh" @close="show_excel_hoc_sinh=false"
                    @submit="submitExcelCanBo($event)" :rowsview="limit" :limit="10"></popup-limit-hoc-sinh>
            </div>
            <!-- Hết danh sách chi tiết -->
        </div>
        <!-- Hết danh sách học sinh -->
    </div>
    <!-- hết template -->
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import constant from '../../utils/constant';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import moment from "moment";
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import UpdateHocSinh from './ChinhSuaTraCuuHocSinh';
    import ThongTinHocSinh from './ThongTinHocSinh';
    import api from '../api';
    import Page from "../ui/PagingCustom";
    import dialog from '../../utils/dialog';
    import VueAlertify from "vue-alertify";
    import utils from '../../utils';
    import ElementUI from 'element-ui';
    import ESelectVue from '../ui/ESelect.vue';
    import PopupExportLimit from '../ui/checkExportExcel';
    Vue.use(ElementUI);
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
        props: ['trangcu'],
        components: {
            Multiselect,
            datePicker,
            Page: Page,
            'eselect': ESelectVue,
            'update-hocsinh': UpdateHocSinh,
            'info-hocsinh': ThongTinHocSinh,
            'popup-limit-hoc-sinh': PopupExportLimit,
        },
        data() {
            return {
                list_dan_toc: [],
                list_ton_giao: [],
                list_dtcs: JSON.parse(localStorage["danh_sach_doi_tuong_chinh_sach_sme"]),
                list_khu_vuc: constant.KHU_VUC,
                list_loai_nhap_hoc: constant.LOAI_NHAP_HOC,
                list_thoi_hoc: constant.LY_DO_THOI_HOC,
                show_excel_hoc_sinh: false,
                show_update: false,
                show_info: false,
                start_excel_hoc_sinh: 0,
                tenLopHoc: "",
                limit_excel_hoc_sinh: 800,
                timKiemNangCao: true,
                hienThiNangCao: {
                    ngaySinh: false,
                    noiSinh: false,
                    maDanToc: false,
                    maTonGiao: false,
                    maLopHocCn: false,
                    dchiThtru: false,
                    dchiTmtru: false,
                    maKhuVuc: false,
                    gioiTinh: false,
                    loaiNhapHoc: false,
                    maLyDoThoiHoc: false,
                    doiVien: false,
                    doanVien: false,
                    khuyetTat: false,
                    lopGhep: false,
                    lopChuyen: false,
                    danTocThieuSo: false,
                    doiTuongChinhSach: false,
                    moetCode: false,
                },
                danhSachTimKiemNangCao: [],
                list_tim_kiem_nang_cao: [{
                        value: 'ngaySinh',
                        name: "Ngày sinh"
                    },
                    {
                        value: 'noiSinh',
                        name: "Nơi sinh"
                    },
                    {
                        value: 'maDanToc',
                        name: "Dân tộc"
                    },
                    {
                        value: 'maTonGiao',
                        name: "Tôn giáo"
                    },
                    // {
                    //     value: 'maLopHocCn',
                    //     name: "Tên lớp học"
                    // },
                    {
                        value: 'dchiThtru',
                        name: "Địa chỉ thường trú"
                    },
                    {
                        value: 'dchiTmtru',
                        name: "Địa chỉ tạm trú"
                    },
                    {
                        value: 'maKhuVuc',
                        name: "Khu vực"
                    },
                    // {
                    //     value: 'gioiTinh',
                    //     name: "Giới tính"
                    // },
                    {
                        value: 'loaiNhapHoc',
                        name: "Loại nhập học"
                    },
                    {
                        value: 'maLyDoThoiHoc',
                        name: "Lý do thôi học"
                    },
                    {
                        value: 'doiVien',
                        name: "Đội viên"
                    },
                    {
                        value: 'doanVien',
                        name: "Đoàn viên"
                    },
                    {
                        value: 'khuyetTat',
                        name: "Khuyết tật"
                    },
                    {
                        value: 'lopGhep',
                        name: "Lớp ghép"
                    },
                    {
                        value: 'lopChuyen',
                        name: "Lớp chuyên"
                    },
                    {
                        value: 'danTocThieuSo',
                        name: "Dân tộc thiểu số"
                    },
                    {
                        value: 'doiTuongChinhSach',
                        name: "Đối tượng chính sách"
                    },
                    {
                        value: 'moetCode',
                        name: "Mã định danh"
                    },
                ],
                nangCao: {
                    ngaySinh: "",
                    noiSinh: "",
                    maDanToc: "",
                    maTonGiao: "",
                    maLopHocCn: "",
                    dchiThtru: "",
                    khoiHoc: "",
                    dchiTmtru: "",
                    maKhuVuc: "",
                    gioiTinh: "",
                    loaiNhapHoc: "",
                    maLyDoThoiHoc: "",
                    doiVien: '',
                    doanVien: '',
                    khuyetTat: '',
                    lopGhep: '',
                    lopChuyen: '',
                    danTocThieuSo: '',
                    doiTuongChinhSach: '',
                    moetCode: '',

                },
                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                danhSachTimKiem: [],
                danhSachTimKiemSo: [{
                        key: 'maTruongHoc',
                        name: "Mã trường",
                        stt: 1
                    },
                    {
                        key: 'tenTruongHoc',
                        name: "Tên trường",
                        stt: 2
                    },
                    {
                        key: 'khoiHoc',
                        name: "Khối học",
                        stt: 4
                    },
                    {
                        key: 'tenLopHoc',
                        name: "Lớp học",
                        stt: 5
                    },
                    {
                        key: 'tenHocSinh',
                        name: "Tên",
                        stt: 6
                    },
                    {
                        key: 'hoTen',
                        name: "Họ tên",
                        stt: 7
                    },
                    {
                        key: 'maHocSinh',
                        name: "Mã học sinh",
                        stt: 8
                    },
                    {
                        key: 'moetCode',
                        name: "Mã định danh",
                        stt: 9
                    },
                ],
                danhSachTimKiemTruong: [
                    {
                        key: 'khoiHoc',
                        name: "Khối học",
                        stt: 4
                    },
                    {
                        key: 'tenLopHoc',
                        name: "Lớp học",
                        stt: 5
                    },
                    {
                        key: 'tenHocSinh',
                        name: "Tên",
                        stt: 6
                    },
                    {
                        key: 'hoTen',
                        name: "Họ tên",
                        stt: 7
                    },
                    {
                        key: 'maHocSinh',
                        name: "Mã học sinh",
                        stt: 8
                    },
                    {
                        key: 'moetCode',
                        name: "Mã định danh",
                        stt: 9
                    },
                ],
                cotHienThi: [],
                hangHienThi: {},
                ds_tim_kiem_tra_cuu_hoc_sinh: [{
                    selectAll: 'Chọn tất cả',
                    libs: constant.danh_sach_tim_kiem_danh_sach_hoc_sinh
                }],
                ds_don_vi_custom: [],
                list_truong_hoc_custom: [],
                ds_cap_hoc_custom: [{
                    selectAll: 'Chọn tất cả',
                    libs: []
                }],
                capHocDangNhap: "",
                tenDonViDangNhap: "",
                // thông tin người dùng
                slectAll: false,
                dataUpdateHocSinh: "",
                dataEditHocSinh: {},
                thongtin: {},
                date: new Date(),
                list_truong_hoc: [],
                list_hocsinh: [],
                list_don_vi: [],
                lsDelete: [],
                list_cap_hoc: window.listCapHoc,
                list_trang_thai_hoc_sinh: constant.list_trang_thai_hoc_sinh,
                list_cap_mot: constant.khoiCapMot,
                list_cap_hai: constant.khoiCapHai,
                list_cap_ba: constant.khoiCapBa,
                list_mam_non: constant.khoiMamNon,
                list_nha_tre: constant.khoiNhaTre,
                lop_nha_tre: constant.lopNhaTre,
                lop_mau_giao: constant.lopMauGiao,
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                // dùng trong filter
                namHocHienTai: "",
                trangThai: "",
                tuKhoa: "",
                gioiTinh: "",
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_khoi_hoc: [],
                ds_truong_hoc: [],
                namHoc: "",
                danhSachDonVi: [],
                danhSachCapHoc: [],
                danhSachTruongHoc: [],
                danhSachKhoiHoc: [],
                danhSachNamHoc: [],
                list_truong_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                // Check xem trang từ bên kết chuyển dữ liệu sang hay không
                chuyenhuong: {},
                isDisabledPhong: false,
                list_khoi_hoc: [],
                trangbatdau: true
            }
        },
        watch: {
            danhSachTimKiemNangCao: function (newVal) {
                if (2 > 0) {
                    console.log("tìm:");
                    let noidung_hienthi = newVal;
                    this.hienThiNangCao.ngaySinh = false;
                    this.hienThiNangCao.noiSinh = false;
                    this.hienThiNangCao.maDanToc = false;
                    this.hienThiNangCao.maTonGiao = false;
                    this.hienThiNangCao.maLopHocCn = false;
                    this.hienThiNangCao.dchiThtru = false;
                    this.hienThiNangCao.dchiTmtru = false;
                    this.hienThiNangCao.maKhuVuc = false;
                    this.hienThiNangCao.gioiTinh = false;
                    this.hienThiNangCao.loaiNhapHoc = false;
                    this.hienThiNangCao.maLyDoThoiHoc = false;
                    this.hienThiNangCao.doiVien = false;
                    this.hienThiNangCao.doanVien = false;
                    this.hienThiNangCao.khuyetTat = false;
                    this.hienThiNangCao.lopGhep = false;
                    this.hienThiNangCao.lopChuyen = false;
                    this.hienThiNangCao.danTocThieuSo = false;
                    this.hienThiNangCao.doiTuongChinhSach = false;
                    this.hienThiNangCao.moetCode = false;
                    for (let i = 0; i < noidung_hienthi.length; i++) {
                        if (noidung_hienthi[i] == "ngaySinh") {
                            this.hienThiNangCao.ngaySinh = true
                        }
                        if (noidung_hienthi[i] == "noiSinh") {
                            this.hienThiNangCao.noiSinh = true
                        }
                        if (noidung_hienthi[i] == "maDanToc") {
                            this.hienThiNangCao.maDanToc = true
                        }
                        if (noidung_hienthi[i] == "maTonGiao") {
                            this.hienThiNangCao.maTonGiao = true
                        }
                        if (noidung_hienthi[i] == "maLopHocCn") {
                            this.hienThiNangCao.maLopHocCn = true
                        }
                        if (noidung_hienthi[i] == "dchiThtru") {
                            this.hienThiNangCao.dchiThtru = true
                        }
                        if (noidung_hienthi[i] == "dchiTmtru") {
                            this.hienThiNangCao.dchiTmtru = true
                        }
                        if (noidung_hienthi[i] == "maKhuVuc") {
                            this.hienThiNangCao.maKhuVuc = true
                        }
                        if (noidung_hienthi[i] == "gioiTinh") {
                            this.hienThiNangCao.gioiTinh = true
                        }
                        if (noidung_hienthi[i] == "loaiNhapHoc") {
                            this.hienThiNangCao.loaiNhapHoc = true
                        }
                        if (noidung_hienthi[i] == "maLyDoThoiHoc") {
                            this.hienThiNangCao.maLyDoThoiHoc = true
                        }
                        if (noidung_hienthi[i] == "doiVien") {
                            this.hienThiNangCao.doiVien = true
                        }
                        if (noidung_hienthi[i] == "doanVien") {
                            this.hienThiNangCao.doanVien = true
                        }
                        if (noidung_hienthi[i] == "khuyetTat") {
                            this.hienThiNangCao.khuyetTat = true
                        }
                        if (noidung_hienthi[i] == "lopGhep") {
                            this.hienThiNangCao.lopGhep = true
                        }
                        if (noidung_hienthi[i] == "lopChuyen") {
                            this.hienThiNangCao.lopChuyen = true
                        }
                        if (noidung_hienthi[i] == "danTocThieuSo") {
                            this.hienThiNangCao.danTocThieuSo = true
                        }
                        if (noidung_hienthi[i] == "doiTuongChinhSach") {
                            this.hienThiNangCao.doiTuongChinhSach = true
                        }
                        if (noidung_hienthi[i] == "moetCode") {
                            this.hienThiNangCao.moetCode = true
                        }
                    }
                    console.log(JSON.stringify(this.hienThiNangCao));

                    // ngaySinh: "",
                    // noiSinh: "",
                    // maDanToc: "",
                    // maTonGiao: "",
                    // maLopHocCn: "",
                    // dchiThtru: "",
                    // dchiTmtru: "",
                    // maKhuVuc: "",
                    // gioiTinh: "",
                    // loaiNhapHoc: "",
                    // maLyDoThoiHoc: "",
                    // doiVien: '',
                    // doanVien: '',
                    // khuyetTat: '',
                    // lopGhep: '',
                    // lopChuyen: '',
                    // danTocThieuSo: '',
                    // doiTuongChinhSach: '',
                }
            },

            slectAll: function (newVal) {
                if (newVal) {
                    this.lsDelete = [];
                    for (let i = 0; i < this.list_hocsinh.length; i++) {
                        this
                            .lsDelete
                            .push(this.list_hocsinh[i].hocSinhTheoNamId);
                    }
                } else {
                    this.lsDelete = [];
                }
            },
            danhSachDonVi: function (newVal) {},
            danhSachCapHoc: function (newVal) {},

            danhSachTruongHoc: function (newVal) {},
            danhSachNamHoc: function (newVal) {
                console.log("watch Năm học");
                this.namHoc = "";
                this.params = {};
                if (newVal) {
                    this.namHoc = newVal
                        .id
                    console
                        .log("map xong:" + JSON.stringify(this.namHoc));
                } else {
                    console.log("Năm học trống");
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                }
            }
        },
        mounted: function () {
             if(this.thongtin.role==5){
                this.danhSachTimKiem = this.danhSachTimKiemTruong;
            }
            else{
                this.danhSachTimKiem = this.danhSachTimKiemSo;
            }
            // gán biến thông tin đăng nhập
            this.list_dtcs = this.list_dtcs.filter(item => item.value !== "");
            this.thongtin = JSON.parse(window.userInfo);

            this.ds_cap_hoc_custom[0].libs = this.list_cap_hoc;
            if (this.thongtin.role == 4) {
                this.isDisabledPhong = true;
            }
            if (this.thongtin.role == 5) {
                console.log("đăng nhập là trường:");
                this.ds_cap_hoc = this.thongtin.listCapHoc;
                this.bindCapHocDangNhap();
                this.bindKhoiHoc();
            }
            this.namHocHienTai = this
                .date
                .getFullYear();
            let thangNay = this
                .date
                .getMonth();
            thangNay = parseInt(thangNay) + 1;
            if (thangNay > 8) {
                console.log("tháng > 7");
                // tháng lớn hơn 7. lấy năm nay là năm học hiện tại
            } else {
                this.namHocHienTai -= 1;
                console.log("tháng không lớn hơn 7");
                // tháng nhỏ hơn hoặc bằng 7. lấy năm ngoái là năm học hiện tại
            }
            this.findNamHoc();
            this.getTruongHoc();
            this.getDanToc();
            this.getTonGiao();
            this.bindCotHeader();
            this.ganCot();
            this.getDonVi(() => {
                if (this.trangcu == "[]") {
                    // this.getListStudent();
                } else {
                    console.log("Trang cũ");
                    this.chuyenhuong = JSON.parse(this.trangcu);
                    console.log("chuyển hướng:");
                    console.log(JSON.stringify(this.chuyenhuong));
                    this.chuyenHuong();
                }

            });
        },
        methods: {
            // Hiển thị thông tin
            showInFo(e) {
                this.show_info = true;
                this.dataInfoHocSinh = e;
            },
            dongSuaHs() {
                this.show_update = false;
                // this.tuKhoa = e;
                this.checkTruocKhiTim()
            },
            ShowUpdate(e) {
                this.show_update = true;
                this.dataUpdateHocSinh = e;
                console.log(this.dataUpdateHocSinh);
                console.log("****");
                console.log("click chỉnh sửa" + e);
            },
            checkTruocKhiTim() {
                this.lsDelete = [];
                this.trangbatdau = !this.trangbatdau;
            },
            xuatDuLieuHocSinh() {
                this.CheckXuatExcel();
            },
            getDanToc() {
                let params = {
                    start: 0,
                    limit: 100,
                };
                rest_api.get("/internal-api/dmDanToc/filter", params, data => {
                    console.log("lấy dân tộc trả về:" + JSON.stringify(data.data));
                    if (data.data.statusResponse == 0) {
                        let lsdt = data.data.rows;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].tenDanToc,
                                value: lsdt[i].maDanToc
                            }
                            this.list_dan_toc.push(obj);
                        }
                    } else {
                        this.list_dan_toc = [{
                            name: 'Chọn tôn giáo',
                            value: ''
                        }];
                    }
                });
            },
            getTonGiao() {
                let params = {
                    start: 0,
                    limit: 100,
                };
                rest_api.get("/internal-api/dmTonGiao/filter", params, data => {
                    console.log("lấy tôn giáo trả về:" + JSON.stringify(data.data));
                    if (data.data.statusResponse == 0) {
                        let lstg = data.data.rows;
                        for (let i = 0; i < lstg.length; i++) {
                            let obj = {
                                name: lstg[i].tenTonGiao,
                                value: lstg[i].maTonGiao
                            }
                            this.list_ton_giao.push(obj);
                        }
                    } else {
                        this.list_ton_giao = [{
                            name: 'Chọn tôn giáo',
                            value: ''
                        }];
                    }
                });
            },
            moKhoiHoc() {
                if (!this.ds_cap_hoc || this.ds_cap_hoc.length == 0) {
                    this.$alertify.error("Vui lòng chọn cấp học để lấy danh sách khối học");
                    return;
                }
            },
            chonKhoiHoc() {
                this.ds_khoi_hoc = [];
                if (this.danhSachKhoiHoc) {
                    let lsch = this.danhSachKhoiHoc.map((obj) => {
                        return obj['id']
                    });
                    for (let i = 0; i < lsch.length; i++) {
                        if (lsch[i] == 13) {
                            lsch.push('14');
                            lsch.push('15');
                        }
                        if (lsch[i] == 16) {
                            lsch.push('17');
                            lsch.push('18');
                        }
                    }
                    this.ds_khoi_hoc = lsch;
                }
                console.log(this.ds_khoi_hoc);
            },
            ChonTruongHoc() {
                console.log("watch Trường học");
                this.ds_truong_hoc = [];
                this.params = {};
                if (this.danhSachTruongHoc) {
                    let lsth = this.danhSachTruongHoc.map((obj) => {
                        return obj['maTruongHoc']
                    });
                    this.ds_truong_hoc = lsth;
                }
            },
            ChonCapHoc() {
                this.danhSachKhoiHoc = [];
                this.ds_khoi_hoc = [];
                this.thongTinTrangCu = [];
                this.ds_cap_hoc = [];
                this.list_truong_hoc_custom = [];
                this.params = {};
                this.ds_truong_hoc = [];
                this.list_khoi_hoc = [];
                this.danhSachTruongHoc = [];
                if (this.danhSachCapHoc) {
                    let lsch = this.danhSachCapHoc.map((obj) => {
                        return obj['id']
                    });
                    this.ds_cap_hoc = lsch;
                }
                console.log("Danh sách cấp học sau khi chọn" + this.ds_cap_hoc);
                this.getTruongHoc();
                this.bindKhoiHoc();
            },
            submitExcelCanBo(e) {
                if (e.from == 1) {
                    this.start_excel_hoc_sinh = 0;
                } else {
                    this.start_excel_hoc_sinh = (e.from - 1) * 5000;
                }
                this.limit_excel_hoc_sinh = ((e.to) * 5000) - this.start_excel_hoc_sinh;
                console.log("excel");
                console.log("bắt đầu:" + this.start_excel_hoc_sinh);
                console.log("số lượng:" + this.limit_excel_hoc_sinh);
                this.xuatExcel();
            },
            // Bind khối học
            bindKhoiHoc() {
                this.list_khoi_hoc = [];
                console.log("Bind khối học");
                for (let i = 0; i < this.ds_cap_hoc.length; i++) {
                    if (this.ds_cap_hoc[i] == 1) {
                        console.log("có bằng 1");
                        for (let i = 0; i < this.list_cap_mot.length; i++) {
                            console.log(this.list_cap_mot[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_mot[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 2) {
                        console.log("có bằng 2");
                        for (let i = 0; i < this.list_cap_hai.length; i++) {
                            console.log(this.list_cap_hai[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_hai[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 3) {
                        console.log("có bằng 3");
                        for (let i = 0; i < this.list_cap_ba.length; i++) {
                            console.log(this.list_cap_ba[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_ba[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 4) {
                        console.log("có bằng 4");
                        for (let i = 0; i < this.list_nha_tre.length; i++) {
                            console.log(this.list_nha_tre[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_nha_tre[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 5) {
                        console.log("có bằng 5");
                        for (let i = 0; i < this.list_mam_non.length; i++) {
                            console.log(this.list_mam_non[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_mam_non[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 45) {
                        console.log("có bằng 5");
                        for (let i = 0; i < this.list_nha_tre.length; i++) {
                            console.log(this.list_nha_tre[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_nha_tre[i])
                        }
                        for (let i = 0; i < this.list_mam_non.length; i++) {
                            console.log(this.list_mam_non[i]);
                            this
                                .list_khoi_hoc
                                .push(this.list_mam_non[i])
                        }
                    }
                    if (this.ds_cap_hoc[i] == 6) {
                        console.log("có bằng 6");
                        for (let i = 0; i < this.list_cap_mot.length; i++) {
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_mot[i])
                        }
                        for (let i = 0; i < this.list_cap_hai.length; i++) {
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_hai[i])
                        }
                        for (let i = 0; i < this.list_cap_ba.length; i++) {
                            this
                                .list_khoi_hoc
                                .push(this.list_cap_ba[i])
                        }
                    }
                    console.log("Khối học sau khi map:" + JSON.stringify(this.list_khoi_hoc));

                    this.list_khoi_hoc = this.boPhanTuTrung(this.list_khoi_hoc);
                    console.log("đây:" + JSON.stringify(this.list_khoi_hoc))
                }
            },
            boPhanTuTrung(arr) {
                return arr.filter((value, index, arr) => arr.indexOf(value) === index);
            },
            limitTextTruong(count) {
                return `và ${count} trường học khác`
            },
            limitTextCapHoc(count) {
                return `và ${count} cấp học khác`
            },
            limitTextDonVi(count) {
                return `và ${count} đơn vị khác`
            },
            limitTextTieuChi(count) {
                return `và ${count} nội dung khác`
            },
            ChonTieuChi() {
                this.bindTieuChiTimKiem();
            },
            bindTieuChiTimKiem() {
                console.log("Bind tiêu chí tìm kiếm");
                console.log(JSON.stringify(this.danhSachTimKiem));
                for (let i = 0; i < this.danhSachTimKiem.length; i++) {
                    if (this.danhSachTimKiem[i].key == 'ma_hoc_sinh') {
                        console.log("có mã học sinh");
                    }
                }
            },
            ChonDonVi() {
                console.log("Chọn đơn vị");
                this.ds_don_vi = [];
                this.params = {};
                this.ds_truong_hoc = [];
                this.list_truong_hoc_custom = [];
                this.thongTinTrangCu = [];
                this.danhSachTruongHoc = [];
                if (this.danhSachDonVi) {
                    let lsdv = this.danhSachDonVi.map((obj) => {
                        return obj['maDonVi']
                    });
                    this.ds_don_vi = lsdv;
                }
                console.log("cHọn xong đơn vị:" + this.ds_don_vi)
                this.getTruongHoc();
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
            CheckXuatExcel() {
                if (this.danhSachTimKiem.length == 0) {
                    this.$alertify.error("Vui lòng chọn nội dung hiển thị.");
                    return;
                }
                if (this.thongtin.role == 5) {
                    this.ds_truong_hoc = [this.thongtin.ma_truong_hoc]
                }
                // this.show_excel_hoc_sinh = true;
                if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                    console.log("quyển bao phòng");
                    if (this.ds_don_vi.length != 1) {
                        if (this.ds_truong_hoc.length == 0) {
                            this
                                .$alertify
                                .error(
                                    "Chức năng xuất Excel danh sách học sinh chỉ hỗ trợ cho 1 đơn vị nhất định hoặc 1 số trường nhất định!"
                                )
                            return
                        } else {
                            // this.xuatExcel();
                            this.show_excel_hoc_sinh = true;
                        }
                    } else {
                        // this.xuatExcel();
                        this.show_excel_hoc_sinh = true;
                    }
                } else {
                    console.log("Cho xuất");
                    // this.xuatExcel()

                    this.show_excel_hoc_sinh = true;
                }
            },

            xuatExcel() {
                console.log("xuất excel");
                let url = "xuat-excel-danh-sach-tra-cuu-hoc-sinh";

                let dataSreachList = [];
                if (this.timKiemNangCao) {
                    if (this.hienThiNangCao.ngaySinh) {
                        if (this.nangCao.ngaySinh) {
                            let obj = {
                                "key": "ngaySinh",
                                "value": this.nangCao.ngaySinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.noiSinh) {
                        if (this.nangCao.noiSinh) {
                            let obj = {
                                "key": "noiSinh",
                                "value": this.nangCao.noiSinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maDanToc) {
                        if (this.nangCao.maDanToc) {
                            let obj = {
                                "key": "maDanToc",
                                "values": this.nangCao.maDanToc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maTonGiao) {
                        if (this.nangCao.maTonGiao) {
                            let obj = {
                                "key": "maTonGiao",
                                "values": this.nangCao.maTonGiao,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLopHocCn) {
                        if (this.nangCao.maLopHocCn) {
                            let obj = {
                                "key": "tenLopHoc",
                                "value": this.nangCao.maLopHocCn,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dchiThtru) {
                        if (this.nangCao.dchiThtru) {
                            let obj = {
                                "key": "dchiThtru",
                                "value": this.nangCao.dchiThtru,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dchiTmtru) {
                        if (this.nangCao.dchiTmtru) {
                            let obj = {
                                "key": "dchiTmtru",
                                "value": this.nangCao.dchiTmtru,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maKhuVuc) {
                        if (this.nangCao.maKhuVuc) {
                            let obj = {
                                "key": "maKhuVuc",
                                "values": this.nangCao.maKhuVuc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.gioiTinh) {
                        if (this.nangCao.gioiTinh) {
                            let obj = {
                                "key": "gioiTinh",
                                "value": parseInt(this.nangCao.gioiTinh),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.loaiNhapHoc) {
                        if (this.nangCao.loaiNhapHoc) {
                            let obj = {
                                "key": "loaiNhapHoc",
                                "value": this.nangCao.loaiNhapHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLyDoThoiHoc) {
                        if (this.nangCao.maLyDoThoiHoc) {
                            let obj = {
                                "key": "maLyDoThoiHoc",
                                "values": this.nangCao.maLyDoThoiHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doiVien) {
                        if (this.nangCao.doiVien) {
                            let obj = {
                                "key": "doiVien",
                                "value": this.nangCao.doiVien,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doanVien) {
                        if (this.nangCao.doanVien) {
                            let obj = {
                                "key": "doanVien",
                                "value": this.nangCao.doanVien,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.khuyetTat) {
                        if (this.nangCao.khuyetTat) {
                            let obj = {
                                "key": "khuyetTat",
                                "value": parseInt(this.nangCao.khuyetTat),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopGhep) {
                        if (this.nangCao.lopGhep) {
                            let obj = {
                                "key": "lopGhep",
                                "value": this.nangCao.lopGhep,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.khoiHoc) {
                        if (this.nangCao.khoiHoc) {
                            let obj = {
                                "key": "khoiHoc",
                                "value": this.nangCao.khoiHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopChuyen) {
                        if (this.nangCao.lopChuyen) {
                            let vl = "";
                            if (this.nangCao.lopChuyen == 1) {
                                vl = true;
                            }
                            if (this.nangCao.lopChuyen == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "lopChuyen",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.danTocThieuSo) {
                        if (this.nangCao.danTocThieuSo) {
                            let vl = "";
                            if (this.nangCao.danTocThieuSo == 1) {
                                vl = true;
                            }
                            if (this.nangCao.danTocThieuSo == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "danToc",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doiTuongChinhSach) {

                        if (this.nangCao.doiTuongChinhSach) {
                            let obj = {
                                "key": "maDtuongCsach",
                                "values": this.nangCao.doiTuongChinhSach,
                            }
                            dataSreachList.push(obj)
                        }
                        // if (this.nangCao.doiTuongChinhSach) {
                        //     let vl = "";
                        //     if (this.nangCao.doiTuongChinhSach == 1) {
                        //         vl = true;
                        //     }
                        //     if (this.nangCao.doiTuongChinhSach == 0) {
                        //         vl = false;
                        //     }
                        //     let obj = {
                        //         "key": "doiTuongChinhSach",
                        //         "value": vl,
                        //     }
                        //     dataSreachList.push(obj)
                        // }
                    }
                    if (this.hienThiNangCao.moetCode) {
                        if (this.nangCao.moetCode) {
                            let obj = {
                                "key": "moetCode",
                                "value": this.nangCao.moetCode,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                }
                let params = {
                    "countInPage ": 5000,
                    "limit": this.limit_excel_hoc_sinh,
                    "start": this.start_excel_hoc_sinh,
                    "capHocs": this.ds_cap_hoc,
                    "gioiTinh": this.gioiTinh,
                    "trangThai": this.trangThai,
                    "limit": this.limit_excel_hoc_sinh,
                    "start": this.start_excel_hoc_sinh,
                    "keyword": this.tuKhoa,
                    "maTruongHocs": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "tenLopHoc": this.tenLopHoc,
                    "lstKhoiHoc": this.ds_khoi_hoc,
                    "colExcels": this.danhSachTimKiem,
                    "dataSreachList": dataSreachList,
                    "trangThai": this.trangThai
                };
                console.log("Dữ liệu xuất excel 123456789:" + JSON.stringify(params));

                if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                    params.maPhongs = this.ds_don_vi;
                }
                if (this.thongtin.role == 4) {
                    params.maPhongs = [this.thongtin.ma_don_vi];
                }
                if (this.thongtin.role == 5) {
                    params.maTruongHocs = [this.thongtin.ma_truong_hoc];
                }

                dialog.confirmDialog(
                    "Xác nhận tải xuống file thông tin. Vui lòng chờ trong thời gian tải xuống.",
                    "Đồng ý",
                    () => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(url, params, (data) => {
                            loading.close();
                            let a = document.createElement('a');
                            a.href = data.data.file;
                            document
                                .body
                                .appendChild(a);
                            a.click();
                            document
                                .body
                                .removeChild(a);
                        });
                    }
                );
            },
            // Chuyển hướng từ trang kết chuyển dữ liệu

            chuyenHuong() {
                window
                    .history
                    .replaceState("", "CSDL Ngành", "Look-up-students");
                if (this.chuyenhuong.namHoc) {
                    // this.namHoc = this.chuyenhuong.namHoc;
                    this.namHocHienTai = this.chuyenhuong.namHoc,
                        this.findNamHoc();
                }

                if (this.chuyenhuong.maTruongHoc) {
                    this.ds_truong_hoc = [this.chuyenhuong.maTruongHoc];
                    this.layTruongChuyenHuong();
                }
            },
            // Lấy danh sách trường chuyển hướng sang
            layTruongChuyenHuong() {
                this.list_truong_hoc = [];
                this.list_truong_hoc_custom = [];
                let params = {
                    maTruong: this.chuyenhuong.maTruongHoc,
                    loose: true
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    if (data.data.code == 200) {
                        this.list_truong_hoc = data.data.rows;
                        console.log(
                            "danh sách trường chueyern hướng:" + JSON.stringify(this.list_truong_hoc)
                        );
                    }
                    let obj = {
                        selectAll: 'Chọn tất cả',
                        libs: this.list_truong_hoc,
                    }
                    this.list_truong_hoc_custom = [obj]
                    this.danhSachTruongHoc = [this.list_truong_hoc[0]];
                    console.log("bind đoạn này nè");
                    this.getListStudent();
                });
            },

            // Xóa mã định danh

            DeleteMoetCode() {
                console.log(this.lsDelete);
                if (this.lsDelete.length > 0) {

                    dialog.confirmDialog(
                        "Xác nhận xóa mã định danh của bản ghi đã chọn?",
                        "Đồng ý",
                        () => {
                            let params = {
                                loaiDuLieu: 3,
                                lstId: this.lsDelete,
                                namHoc: this.namHoc
                            };
                            rest_api.post("/csdlgd-admin/DataTruong/deleteMoetCode", params, data => {
                                if (data.data.rc == 0) {
                                    this
                                        .$alertify
                                        .success("Xóa dữ liệu thành công");
                                    this.getListStudent();
                                } else {
                                    this
                                        .$alertify
                                        .error(data.data.rd)
                                }
                            });
                        }
                    );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn ít nhất 1 học sinh.")
                }

            },

            // Xóa danh sách học sinh đã chọn
            DeleteStudent() {
                console.log(this.lsDelete);
                if (this.lsDelete.length > 0) {
                    dialog.confirmDialog(
                        "Xác nhận xóa các bản ghi đã chọn?",
                        "Đồng ý",
                        () => {
                            console.log("Đồng ý xóa danh sách học sinh:");
                            console.log(this.lsDelete);
                            let hocSinhTheoNamIds = [];
                            for (let i = 0; i < this.lsDelete.length; i++) {
                                console.log("danh sách xóa:" + JSON.stringify(this.lsDelete));
                                for (let j = 0; j < this.list_hocsinh.length; j++) {
                                    console.log("danh sách học sinh:" + JSON.stringify(this.list_hocsinh));
                                    if (this.lsDelete[i] == this.list_hocsinh[j].hocSinhTheoNamId) {
                                        console.log("Trùng:" + JSON.stringify(this.lsDelete[i]));
                                        hocSinhTheoNamIds.push(this.list_hocsinh[j].maHocSinh);
                                    }
                                }
                            }

                            let params = {
                                listMa: hocSinhTheoNamIds,
                                hocSinhTheoNamIds: this.lsDelete,
                                namHoc: this.namHoc
                            };
                            rest_api.post("/csdlgd-admin/hocSinh/delete", params, data => {
                                if (data.data.rc == 0) {
                                    this
                                        .$alertify
                                        .success("Xóa dữ liệu thành công");
                                    this.getListStudent();
                                } else {
                                    this
                                        .$alertify
                                        .error(data.data.rd)
                                }
                            });
                        }
                    );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn ít nhất 1 học sinh.")
                }

            },
            // Lấy lại danh sách học sinh
            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getListStudent()
            },
            getTruongHoc(gt = () => {}) {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc,
                    loose: true
                };
                // if (this.thongTinTrangCu.maTruongHoc) {     params.maTruong =
                // this.thongTinTrangCu.maTruongHoc; }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    console.log("lấy trường");
                    if (data.data.code == 200) {
                        this.list_truong_hoc = data.data.rows;
                        let obj = {
                            selectAll: 'Chọn tất cả',
                            libs: this.list_truong_hoc,
                        };
                        this.list_truong_hoc_custom = [obj]
                        gt();
                    }
                });
            },
            // gán các cột hiển thị dữ liệu
            locCotHienThi() {

                var flags = [],
                    sau_khi_loc = [],
                    l = this.danhSachTimKiem.length;
                for (let i = 0; i < l; i++) {
                    if (flags[this.danhSachTimKiem[i].stt]) continue;
                    flags[this.danhSachTimKiem[i].stt] = true;
                    sau_khi_loc.push(this.danhSachTimKiem[i]);
                }
                this.danhSachTimKiem = sau_khi_loc;
                this.danhSachTimKiem.sort(this.sapXepMang)
                console.log("Nội dung cột sau khi lọc:" + JSON.stringify(sau_khi_loc));
            },
            bindCotHeader() {
                this.locCotHienThi();
            },
            sapXepMang(a, b) {
                if (a.stt < b.stt) {
                    return -1;
                }
                if (a.stt > b.stt) {
                    return 1;
                }
                return 0;
            },
            // gán các cột hiển thị
            ganCot() {
                this.hangHienThi = {};
                this.cotHienThi = this.danhSachTimKiem;
                console.log("cột hiển thị:");
                for (let i = 0; i < this.cotHienThi.length; i++) {
                    if (this.cotHienThi[i].key == "maTruongHoc") {
                        this.hangHienThi.maTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenTruongHoc") {
                        this.hangHienThi.tenTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "khoiHoc") {
                        this.hangHienThi.khoiHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenLopHoc") {
                        this.hangHienThi.tenLopHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenHocSinh") {
                        this.hangHienThi.tenHocSinh = true;
                    }
                    if (this.cotHienThi[i].key == "hoTen") {
                        this.hangHienThi.hoTen = true;
                    }
                    if (this.cotHienThi[i].key == "moetCode") {
                        this.hangHienThi.moetCode = true;
                    }
                    if (this.cotHienThi[i].key == "maHocSinh") {
                        this.hangHienThi.maHocSinh = true;
                    }
                    if (this.cotHienThi[i].key == "trangThai") {
                        this.hangHienThi.trangThai = true;
                    }
                    if (this.cotHienThi[i].key == "gioiTinh") {
                        this.hangHienThi.gioiTinh = true;
                    }
                    if (this.cotHienThi[i].key == "ngaySinh") {
                        this.hangHienThi.ngaySinh = true;
                    }
                    if (this.cotHienThi[i].key == "noiSinh") {
                        this.hangHienThi.noiSinh = true;
                    }
                    if (this.cotHienThi[i].key == "maDanToc") {
                        this.hangHienThi.maDanToc = true;
                    }
                    if (this.cotHienThi[i].key == "maTonGiao") {
                        this.hangHienThi.maTonGiao = true;
                    }
                    if (this.cotHienThi[i].key == "capHoc") {
                        this.hangHienThi.capHoc = true;
                    }
                    if (this.cotHienThi[i].key == "dchiThtru") {
                        this.hangHienThi.dchiThtru = true;
                    }
                    if (this.cotHienThi[i].key == "dchiTmtru") {
                        this.hangHienThi.dchiTmtru = true;
                    }
                    if (this.cotHienThi[i].key == "soCmnd") {
                        this.hangHienThi.soCmnd = true;
                    }
                    if (this.cotHienThi[i].key == "soDthoaiCdinh") {
                        this.hangHienThi.soDthoaiCdinh = true;
                    }
                    if (this.cotHienThi[i].key == "dienThoaiHieuTruong") {
                        this.hangHienThi.dienThoaiHieuTruong = true;
                    }
                    if (this.cotHienThi[i].key == "doiVien") {
                        this.hangHienThi.doiVien = true;
                    }
                    if (this.cotHienThi[i].key == "doanVien") {
                        this.hangHienThi.doanVien = true;
                    }
                    if (this.cotHienThi[i].key == "maDtuongCsach") {
                        this.hangHienThi.maDtuongCsach = true;
                    }
                    if (this.cotHienThi[i].key == "email") {
                        this.hangHienThi.email = true;
                    }
                    if (this.cotHienThi[i].key == "hieuTruong") {
                        this.hangHienThi.hieuTruong = true;
                    }
                    if (this.cotHienThi[i].key == "hoTenBo") {
                        this.hangHienThi.hoTenBo = true;
                    }
                    if (this.cotHienThi[i].key == "soDienThoaiBo") {
                        this.hangHienThi.soDienThoaiBo = true;
                    }
                    if (this.cotHienThi[i].key == "hoTenMe") {
                        this.hangHienThi.hoTenMe = true;
                    }
                    if (this.cotHienThi[i].key == "soDienThoaiMe") {
                        this.hangHienThi.soDienThoaiMe = true;
                    }
                }
                console.log("Hàng hiển thị:" + JSON.stringify(this.hangHienThi));

            },
            // Lấy danh sách học sinh
            getListStudent() {
                this.slectAll = false;
                this.lsDelete = [];
                if (this.danhSachTimKiem.length == 0) {
                    this.$alertify.error("Vui lòng chọn nội dung hiển thị.");
                    return;
                }
                let dataSreachList = [];
                if (this.timKiemNangCao) {
                    if (this.hienThiNangCao.ngaySinh) {
                        if (this.nangCao.ngaySinh) {
                            let obj = {
                                "key": "ngaySinh",
                                "value": this.nangCao.ngaySinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.noiSinh) {
                        if (this.nangCao.noiSinh) {
                            let obj = {
                                "key": "noiSinh",
                                "value": this.nangCao.noiSinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maDanToc) {
                        if (this.nangCao.maDanToc) {
                            let obj = {
                                "key": "maDanToc",
                                "values": this.nangCao.maDanToc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maTonGiao) {
                        if (this.nangCao.maTonGiao) {
                            let obj = {
                                "key": "maTonGiao",
                                "values": this.nangCao.maTonGiao,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLopHocCn) {
                        if (this.nangCao.maLopHocCn) {
                            let obj = {
                                "key": "tenLopHoc",
                                "value": this.nangCao.maLopHocCn,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dchiThtru) {
                        if (this.nangCao.dchiThtru) {
                            let obj = {
                                "key": "dchiThtru",
                                "value": this.nangCao.dchiThtru,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dchiTmtru) {
                        if (this.nangCao.dchiTmtru) {
                            let obj = {
                                "key": "dchiTmtru",
                                "value": this.nangCao.dchiTmtru,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maKhuVuc) {
                        if (this.nangCao.maKhuVuc) {
                            let obj = {
                                "key": "maKhuVuc",
                                "values": this.nangCao.maKhuVuc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.gioiTinh) {
                        if (this.nangCao.gioiTinh) {
                            let obj = {
                                "key": "gioiTinh",
                                "value": parseInt(this.nangCao.gioiTinh),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.loaiNhapHoc) {
                        if (this.nangCao.loaiNhapHoc) {
                            let obj = {
                                "key": "loaiNhapHoc",
                                "value": this.nangCao.loaiNhapHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLyDoThoiHoc) {
                        if (this.nangCao.maLyDoThoiHoc) {
                            let obj = {
                                "key": "maLyDoThoiHoc",
                                "values": this.nangCao.maLyDoThoiHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doiVien) {
                        if (this.nangCao.doiVien) {
                            let obj = {
                                "key": "doiVien",
                                "value": this.nangCao.doiVien,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doanVien) {
                        if (this.nangCao.doanVien) {
                            let obj = {
                                "key": "doanVien",
                                "value": this.nangCao.doanVien,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.khuyetTat) {
                        if (this.nangCao.khuyetTat) {
                            let obj = {
                                "key": "khuyetTat",
                                "value": parseInt(this.nangCao.khuyetTat),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopGhep) {
                        if (this.nangCao.lopGhep) {
                            let obj = {
                                "key": "lopGhep",
                                "value": this.nangCao.lopGhep,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.khoiHoc) {
                        if (this.nangCao.khoiHoc) {
                            let obj = {
                                "key": "khoiHoc",
                                "value": this.nangCao.khoiHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopChuyen) {
                        if (this.nangCao.lopChuyen) {
                            let vl = "";
                            if (this.nangCao.lopChuyen == 1) {
                                vl = true;
                            }
                            if (this.nangCao.lopChuyen == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "lopChuyen",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.danTocThieuSo) {
                        if (this.nangCao.danTocThieuSo) {
                            let vl = "";
                            if (this.nangCao.danTocThieuSo == 1) {
                                vl = true;
                            }
                            if (this.nangCao.danTocThieuSo == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "danToc",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doiTuongChinhSach) {

                        if (this.nangCao.doiTuongChinhSach) {
                            let obj = {
                                "key": "maDtuongCsach",
                                "values": this.nangCao.doiTuongChinhSach,
                            }
                            dataSreachList.push(obj)
                        }
                        // if (this.nangCao.doiTuongChinhSach) {
                        //     let vl = "";
                        //     if (this.nangCao.doiTuongChinhSach == 1) {
                        //         vl = true;
                        //     }
                        //     if (this.nangCao.doiTuongChinhSach == 0) {
                        //         vl = false;
                        //     }
                        //     let obj = {
                        //         "key": "doiTuongChinhSach",
                        //         "value": vl,
                        //     }
                        //     dataSreachList.push(obj)
                        // }
                    }
                    if (this.hienThiNangCao.moetCode) {
                        if (this.nangCao.moetCode) {
                            let obj = {
                                "key": "moetCode",
                                "value": this.nangCao.moetCode,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                }
                console.log("THông tin tìm kiếm nâng cao:");
                console.log(JSON.stringify(dataSreachList));
                this.bindCotHeader();
                this.ganCot();
                this.list_hocsinh = [];
                this.total_rows = 0;
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "capHocs": this.ds_cap_hoc,
                    "gioiTinh": this.gioiTinh,
                    "trangThai": this.trangThai,
                    "keyword": this.tuKhoa,
                    "maTruongHocs": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "tenLopHoc": this.tenLopHoc,
                    "lstKhoiHoc": this.ds_khoi_hoc,
                    "colExcels": this.danhSachTimKiem,
                    "dataSreachList": dataSreachList,
                    "trangThai": this.trangThai
                };
                if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                    params.maPhongs = this.ds_don_vi;
                }
                if (this.thongtin.role == 4) {
                    params.maPhongs = [this.thongtin.ma_don_vi];
                }
                if (this.thongtin.role == 5) {
                    params.maTruongHocs = [this.thongtin.ma_truong_hoc];
                }
                console.log("tìm kiếm học sinh:" + JSON.stringify(params))

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/hocSinh/search2", params, (respon) => {
                    loading.close();
                    if (respon.data.rc == 0) {
                        if (respon.data.tableData.length == 0) {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy");
                            console.log("không có bản ghi nào được tìm thấy");
                            return;
                        } else {
                            this.list_hocsinh = respon.data.tableData;
                            this.total_rows = respon.data.totalRows;
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công.")
                        }

                    } else {
                        this
                            .$alertify
                            .error(respon.data.rd);
                        return;
                    }
                })
            },


            xuatExcelCu() {
                let url = "xuat-excel-danh-sach-tra-cuu-hoc-sinh";
                this.slectAll = false;
                this.lsDelete = [];
                if (this.danhSachTimKiem.length == 0) {
                    this.$alertify.error("Vui lòng chọn nội dung hiển thị.");
                    return;
                }
                let dataSreachList = [];
                if (this.timKiemNangCao) {
                    if (this.hienThiNangCao.ngaySinh) {
                        if (this.nangCao.ngaySinh) {
                            let obj = {
                                "key": "ngaySinh",
                                "value": this.nangCao.ngaySinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.noiSinh) {
                        if (this.nangCao.noiSinh) {
                            let obj = {
                                "key": "noiSinh",
                                "value": this.nangCao.noiSinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maDanToc) {
                        if (this.nangCao.maDanToc) {
                            let obj = {
                                "key": "maDanToc",
                                "values": this.nangCao.maDanToc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maTonGiao) {
                        if (this.nangCao.maTonGiao) {
                            let obj = {
                                "key": "maTonGiao",
                                "values": this.nangCao.maTonGiao,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLopHocCn) {
                        if (this.nangCao.maLopHocCn) {
                            let obj = {
                                "key": "tenLopHoc",
                                "value": this.nangCao.maLopHocCn,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dchiThtru) {
                        if (this.nangCao.dchiThtru) {
                            let obj = {
                                "key": "dchiThtru",
                                "value": this.nangCao.dchiThtru,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dchiTmtru) {
                        if (this.nangCao.dchiTmtru) {
                            let obj = {
                                "key": "dchiTmtru",
                                "value": this.nangCao.dchiTmtru,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maKhuVuc) {
                        if (this.nangCao.maKhuVuc) {
                            let obj = {
                                "key": "maKhuVuc",
                                "values": this.nangCao.maKhuVuc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.gioiTinh) {
                        if (this.nangCao.gioiTinh) {
                            let obj = {
                                "key": "gioiTinh",
                                "value": parseInt(this.nangCao.gioiTinh),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.loaiNhapHoc) {
                        if (this.nangCao.loaiNhapHoc) {
                            let obj = {
                                "key": "loaiNhapHoc",
                                "value": this.nangCao.loaiNhapHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLyDoThoiHoc) {
                        if (this.nangCao.maLyDoThoiHoc) {
                            let obj = {
                                "key": "maLyDoThoiHoc",
                                "values": this.nangCao.maLyDoThoiHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doiVien) {
                        if (this.nangCao.doiVien) {
                            let obj = {
                                "key": "doiVien",
                                "value": this.nangCao.doiVien,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doanVien) {
                        if (this.nangCao.doanVien) {
                            let obj = {
                                "key": "doanVien",
                                "value": this.nangCao.doanVien,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.khuyetTat) {
                        if (this.nangCao.khuyetTat) {
                            let obj = {
                                "key": "khuyetTat",
                                "value": parseInt(this.nangCao.khuyetTat),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopGhep) {
                        if (this.nangCao.lopGhep) {
                            let obj = {
                                "key": "lopGhep",
                                "value": this.nangCao.lopGhep,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.khoiHoc) {
                        if (this.nangCao.khoiHoc) {
                            let obj = {
                                "key": "khoiHoc",
                                "value": this.nangCao.khoiHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopChuyen) {
                        if (this.nangCao.lopChuyen) {
                            let vl = "";
                            if (this.nangCao.lopChuyen == 1) {
                                vl = true;
                            }
                            if (this.nangCao.lopChuyen == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "lopChuyen",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.danTocThieuSo) {
                        if (this.nangCao.danTocThieuSo) {
                            let vl = "";
                            if (this.nangCao.danTocThieuSo == 1) {
                                vl = true;
                            }
                            if (this.nangCao.danTocThieuSo == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "danToc",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doiTuongChinhSach) {
                        if (this.nangCao.doiTuongChinhSach) {
                            let vl = "";
                            if (this.nangCao.doiTuongChinhSach == 1) {
                                vl = true;
                            }
                            if (this.nangCao.doiTuongChinhSach == 0) {
                                vl = false;
                            }
                            let obj = {
                                "key": "doiTuongChinhSach",
                                "value": vl,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.moetCode) {
                        if (this.nangCao.moetCode) {
                            let obj = {
                                "key": "moetCode",
                                "value": this.nangCao.moetCode,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                }
                console.log("THông tin tìm kiếm nâng cao:");
                console.log(JSON.stringify(dataSreachList));
                this.bindCotHeader();
                this.ganCot();
                this.list_hocsinh = [];
                this.total_rows = 0;
                let params = {
                    "capHocs": this.ds_cap_hoc,
                    "gioiTinh": this.gioiTinh,
                    "trangThai": this.trangThai,
                    "limit": this.limit_excel_hoc_sinh,
                    "start": this.start_excel_hoc_sinh,
                    "countInPage ": 5000,
                    "keyword": this.tuKhoa,
                    "maTruongHocs": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "tenLopHoc": this.tenLopHoc,
                    "lstKhoiHoc": this.ds_khoi_hoc,
                    "colExcels": this.danhSachTimKiem,
                    "trangThai": this.trangThai
                };
                if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                    params.maPhongs = this.ds_don_vi;
                }
                if (this.thongtin.role == 4) {
                    params.maPhongs = [this.thongtin.ma_don_vi];
                }
                if (this.thongtin.role == 5) {
                    params.maTruongHocs = [this.thongtin.ma_truong_hoc];
                }
                dialog.confirmDialog(
                    "Xác nhận tải xuống file thông tin. Vui lòng chờ trong thời gian tải xuống.",
                    "Đồng ý",
                    () => {
                        api.post(url, params, (data) => {
                            let a = document.createElement('a');
                            a.href = data.data.file;
                            document
                                .body
                                .appendChild(a);
                            a.click();
                            document
                                .body
                                .removeChild(a);
                        });
                    }
                );
            },
            // Chuyển hướng từ trang kết chuyển dữ liệu

            // Lấy danh sách đơn vị
            getDonVi(ck = () => {}) {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                console.log("pr ẻty" + JSON.stringify(params));
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    // console.log("lấy đơn vị thành công" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        this.list_don_vi = data.data.rows;
                        let obj = {
                            selectAll: 'Chọn tất cả',
                            libs: this.list_don_vi,
                        };
                        this.ds_don_vi_custom = [obj];
                        if (this.thongtin.role == 4 || this.thongtin.role == 5) {
                            for (let i = 0; i < this.list_don_vi.length; i++) {
                                if (this.list_don_vi[i].maDonVi == this.thongtin.ma_don_vi) {
                                    this.danhSachDonVi = [this.list_don_vi[i]];
                                    this.tenDonViDangNhap = this.list_don_vi[i].tenDonVi;
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
            },
            // định nghĩa cho đối tác
            setNameDoiTac({
                tenDoiTac,
                maDoiTac
            }) {
                return `${tenDoiTac} - [${maDoiTac}]`
            },
            // định nghĩa cho trạng thái
            setNameDanhSachTrangThai({
                name
            }) {
                return `${name}`
            }
        }
    }

</script>
<style scoped="scoped">


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
    span {}

    .cg {
        text-align: center;
        align-items: center;
    }

    .multiselect--disabled {
        background: white;
    }

    input[type=checkbox] {
        margin: 0 !important;
    }

</style>

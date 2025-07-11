<template>
    <div>
        <div>
            <!-- template -->
            <div class="row page-header">
                <div class="col-sm-6 text-uppercase">
                    <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> hệ thống <span class="kytu">
                            &raquo;</span> Nộp dữ liệu sso </span>
                </div>
                <div class="col-sm-6">
                    <!--                    <marquee width="100%" direction="left" scrollamount="6">-->
                    <!--                        <span style="color:blue"><b>Thông báo:</b></span><span class="red"> Từ 01/08/2021, cần tạo lại-->
                    <!--                            dữ liệu năm học mới trên hệ thống CSDL ngành năm học 2021-2022 để tạo tài khoản SSO.</span>-->
                    <!--                    </marquee>-->
                </div>
            </div>
            <!-- end header -->

            <el-tabs type="border-card2">
                <el-tab-pane>
                    <span slot="label">1. Dữ liệu giáo viên</span>

                    <div class="row" style="padding-top:15px;">
                        <!-- đơn vị -->
                        <div class="col-md-3 timkiem">
                            <label class="typo__label">Đơn vị quản lý <span style="color:#DC0101">*</span></label>
                            <div>
                                <eselect style="width:100%" multiple collapseTags v-model="ds_don_vi"
                                    @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                    :fields="['tenDonVi','maDonVi']" />
                            </div>
                        </div>
                        <!-- end đơn vị -->
                        <!-- cấp học -->
                        <div class="col-md-2 timkiem">
                            <div>
                                <label class="typo__label">Cấp học <sup style="color:#DC0101">1</sup></label>
                                <div v-if="thongtin.role2!=5">
                                    <eselect style="width:100%" collapseTags v-model="ds_cap_hoc" @change="ChonCapHoc"
                                        :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />

                                </div>
                                <div v-if="thongtin.role2==5">
                                    <input :disabled="thongtin.role2 == 5" class="form-control" placeholder="Cấp học" />
                                </div>
                            </div>
                        </div>
                        <!-- end cấp học -->
                        <!-- Trường học -->
                        <div class="col-md-3 timkiem">
                            <div v-if="thongtin.role2!=5">
                                <label class="typo__label">Trường học </label>
                                <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags
                                    v-model="ds_truong_hoc" :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                    :fields="['tenTruongHoc','maTruongHoc']" />
                            </div>
                            <div v-if="thongtin.role2==5">
                                <label>Trường học:</label>
                                <input :disabled="thongtin.role2 == 5" :value="thongtin.display_name"
                                    class="form-control" placeholder="Nhập..." />
                            </div>
                        </div>
                        <!-- Hết trường học -->
                        <!-- Năm học -->
                        <div class="col-md-2 timkiem">
                            <label class="typo__label">Năm học <span style="color:#DC0101">*</span></label>
                            <!-- <multiselect v-model="danhSachNamHoc" :options="list_nam_hoc" :custom-label="setNameNamHoc"
                                placeholder="Chọn năm học" label="name" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                                selectedLabel="Đã chọn" track-by="name"></multiselect>
                                 -->
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </div>
                        <div class="col-md-2 timkiem">
                            <label class="typo__label">Từ khóa</label>
                            <input type="text" v-model="email" class="form-control"
                                placeholder="Email hoặc mã giáo viên">
                        </div>
                        <!-- Hết năm học -->
                    </div>
                    <!-- end filter -->
                    <!-- button -->
                    <div class="row text-center">
                        <el-button type="success" @click.prevent="checkBeforeSearchTeacher()" size="mini">Tìm kiếm
                        </el-button>
                        <!--                        <el-button @click.prevent="ImportDataTeacher(1)" type="primary" size="mini">Import dữ liệu-->
                        <!--                        </el-button>-->
                        <!-- <button size="mini" type="success" @click.prevent="DownloadTemplate(1)">Download template
                        </button> -->
                        <!-- <button
                        v-bind:disabled="list_giao_vien.length==0"
                        size="mini" type="info"
                        @click.prevent="getDownLoadExcel(2)">Xuất Excel 3
                    </button> -->
                        <el-button v-bind:disabled="list_giao_vien.length==0" size="mini" type="info"
                            :show="show_excel_giao_vien" @close="show_excel_giao_vien=false" :limit="10"
                            @click.prevent="xuatDuLieuGiaoVien">Xuất Excel
                        </el-button>
                        <el-button type="danger" size="mini" @click.prevent="deteteTeacher()">Xóa dữ liệu
                        </el-button>
                    </div>
                    <hr />
                    <!-- end button -->
                    <!-- Danh sách giáo viên -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Mã giáo viên</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Họ tên</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Giới tính</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Trường học</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Tỉnh thành</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Email</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày sinh</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số CMND</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số điện thoại</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày cập nhật</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Thao tác</p>
                                    </th>
                                    <th class="text-center">
                                        <input v-model="slectAll2" @click="ChonTatCa2" type="checkbox" />
                                        <span>Chọn tất cả</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_giao_vien.length===0">
                                <tr>
                                    <td class="text-center" colspan="13">
                                        <p>Không có bản ghi nào được tìm thấy</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(px,index) in list_giao_vien" :key='index'
                                    v-bind:class="{ mauDo: px.syncMaSoGd!==thongtin.ma_so }">
                                    <td class="text-center">{{ (currentPage - 1) * limit_teacher + index + 1 }}</td>
                                    <td>
                                        <p>{{ px.maGiaoVien }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.tenGiaoVien }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ parseInt(px.gioiTinh) === 1 ? 'Nam' : 'Nữ' }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.tenTruongHoc }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.tenTinhThanh }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.email }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.ngaySinh }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.soCmnd }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.soDienThoaiDiDong }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ px.ngayCapNhat }}</p>
                                    </td>
                                    <td class="text-center">
                                        <div>
                                            <el-tooltip content="Chỉnh sửa" placement="top">
                                                <el-button
                                                    :disabled="px.syncMaSoGd!=thongtin.ma_so && thongtin.username!='hcm_sgd'"
                                                    type="warning" @click.prevent="showUpdateGiaoVien(px)" size="mini">
                                                    <i class="el-icon-edit"></i></el-button>
                                            </el-tooltip>
                                        </div>
                                    </td>
                                    <td>
                                        <div v-if="px.syncMaSoGd==thongtin.ma_so">
                                            <input type="checkbox" :disabled="px.syncMaSoGd!=thongtin.ma_so"
                                                v-model="lsDelete2" :value="px.maGiaoVien" />
                                            <span style="font-size:12px">chọn</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Page :total_rows="total_rows" @pageChange="layLaiGiaoVien($event)"></Page>
                </el-tab-pane>
                <el-tab-pane>
                    <span slot="label">2. Dữ liệu cán bộ phòng sở</span>

                    <div class="row" style="padding-top:15px;">
                        <!-- đơn vị -->
                        <div class="col-md-4 timkiem">
                            <label class="typo__label">Đơn vị quản lý <span style="color:#DC0101">*</span></label>
                            <div>
                                <eselect style="width:100%" multiple collapseTags v-model="ds_don_vi"
                                    @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                    :fields="['tenDonVi','maDonVi']" />

                            </div>
                            <!-- <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> -->
                        </div>
                        <!-- end đơn vị -->
                        <!-- Năm học -->
                        <div class="col-md-2 timkiem">
                            <label class="typo__label">Năm học <span style="color:#DC0101">*</span></label>
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </div>
                        <div class="col-md-4 timkiem">
                            <label class="typo__label"> Từ khóa</label>
                            <input type="text" v-model="email" class="form-control" placeholder="Email hoặc mã cán bộ">
                        </div>
                        <!-- Hết năm học -->
                    </div>
                    <!-- end filter -->
                    <!-- button -->
                    <div class="row text-center">
                        <el-button size="mini" type="success" @click.prevent="checkBeforeSearchCanBo()">Tìm kiếm
                        </el-button>
                        <!--                        <el-button @click.prevent="ImportDataTeacher(3)" size="mini" type="primary">Import dữ liệu-->
                        <!--                        </el-button>-->
                        <!-- <button size="mini" type="success" @click.prevent="DownloadTemplate(3)">Download template
                        </button> -->
                        <!-- <button
                        v-bind:disabled="list_giao_vien.length==0"
                        size="mini" type="info"
                        @click.prevent="getDownLoadExcel(2)">Xuất Excel 1
                    </button> -->
                        <el-button v-bind:disabled="list_can_bo.length==0" size="mini" type="info"
                            :show="show_excel_can_bo" @close="show_excel_can_bo=false" :limit="10"
                            @click.prevent="xuatDuLieuCanBo">Xuất
                            Excel
                        </el-button>
                        <el-button size="mini" type="danger" @click.prevent="deteteCanBo()">Xóa dữ liệu
                        </el-button>
                    </div>
                    <hr />
                    <!-- end button -->
                    <!-- Danh sách cán bộ phòng/sở -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Mã giáo viên</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Họ tên</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Giới tính</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Chức vụ</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Quận huyện</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Tỉnh thành</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Email</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Địa chỉ</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày sinh</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số CMND</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số điện thoại</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày cập nhật</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Thao tác</p>
                                    </th>
                                    <th class="text-center">
                                        <input v-model="slectAll3" @click="ChonTatCa3" type="checkbox" />
                                        <span>Chọn tất cả</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_can_bo.length===0">
                                <tr>
                                    <td class="text-center" colspan="15">
                                        <p>Không có bản ghi nào được tìm thấy</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(px,index) in list_can_bo" :key="index"
                                    v-bind:class="{ mauDo: px.syncMaSoGd!==thongtin.ma_so }">
                                    <td class="text-center">{{ (currentPage - 1) * limit_teacher + index + 1 }}</td>
                                    <td>
                                        <p>{{ px.maCanBo }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.tenCanBo }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ parseInt(px.gioiTinh) === 1 ? 'Nam' : 'Nữ' }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.tenChucVu }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.tenHuyen }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.tenTinh }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.email }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.diaChi }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.ngaySinh }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.soCmnd }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.soDienThoaiDiDong }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ px.ngayCapNhat }}</p>
                                    </td>
                                    <td class="text-center">
                                        <el-tooltip v-if="px.syncMaSoGd==thongtin.ma_so && thongtin.username!='hcm_sgd'"
                                            class="item" effect="dark" content="Chỉnh sửa" placement="left-start">
                                            <el-button type="warning" @click="showUpdateCanBoPhongSo(px)" size="mini"
                                                icon="el-icon-edit">
                                            </el-button>
                                        </el-tooltip>
                                    </td>
                                    <td>
                                        <div v-if="px.syncMaSoGd==thongtin.ma_so">
                                            <input type="checkbox" :disabled="px.syncMaSoGd!=thongtin.ma_so"
                                                v-model="lsDelete3" :value="px.maCanBo" />
                                            <span style="font-size:12px">chọn</span>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Page :total_rows="total_rows_can_bo" @pageChange="layLaiCanBo($event)"></Page>
                </el-tab-pane>
                <el-tab-pane>
                    <span slot="label">3. Dữ liệu học sinh</span>
                    <!-- Nội dung phần học sinh -->
                    <!-- start filter -->
                    <div class="row" style="padding-top:15px;">
                        <!-- đơn vị -->
                        <div class="col-md-3 timkiem">
                            <label class="typo__label">Đơn vị quản lý <span style="color:#DC0101">*</span></label>
                            <div>
                                <eselect style="width:100%" multiple collapseTags v-model="ds_don_vi"
                                    @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                    :fields="['tenDonVi','maDonVi']" />

                            </div>
                            <!-- <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> -->
                        </div>
                        <!-- end đơn vị -->
                        <!-- cấp học -->
                        <div class="col-md-2 timkiem">
                            <div>
                                <label class="typo__label">Cấp học <sup style="color:#DC0101">1</sup></label>
                                <div v-if="thongtin.role2!=5">
                                    <eselect style="width:100%" collapseTags v-model="ds_cap_hoc" @change="ChonCapHoc"
                                        :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />

                                </div>
                                <div v-if="thongtin.role2==5">
                                    <input :disabled="thongtin.role2 == 5" class="form-control" placeholder="Cấp học" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 timkiem">
                            <label class="typo__label">Khối học</label>
                            <eselect style="width:100%" collapseTags v-model="ds_khoi_hoc" :placeholder="'Chọn'"
                                filterable :data="list_khoi_hoc" :fields="['name','id']" />
                        </div>
                        <!-- end cấp học -->
                        <!-- Trường học -->
                        <div class="col-md-3 timkiem">
                            <div v-if="thongtin.role2!=5">
                                <label>Trường học</label>
                                <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags
                                    v-model="ds_truong_hoc" :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                    :fields="['tenTruongHoc','maTruongHoc']" />
                            </div>
                            <div v-if="thongtin.role2==5">
                                <label>Trường học</label>
                                <input :disabled="thongtin.role2 == 5" :value="thongtin.display_name"
                                    class="form-control" placeholder="Nhập..." />
                            </div>
                        </div>
                        <!-- Hết trường học -->
                        <!-- Năm học -->
                        <div class="col-md-2 timkiem">
                            <label class="typo__label">Năm học <span style="color:#DC0101">*</span></label>
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </div>
                        <div class="col-md-3 timkiem">
                            <label class="typo__label">Mã/họ tên học sinh</label>
                            <input type="text" v-model="Keyword" class="form-control" placeholder="Mã/họ tên học sinh">
                        </div>
                        <div class="col-md-2 timkiem">
                            <label class="typo__label">Lớp học</label>
                            <input type="text" v-model="tenLop" class="form-control" placeholder="Nhập...">
                        </div>
                        <!-- Hết năm học -->
                    </div>
                    <!-- end filter -->
                    <!-- button -->
                    <div class="row text-center">
                        <el-button size="mini" type="success" @click.prevent="checkBeforeSearchStudent()">Tìm kiếm
                        </el-button>
                        <!--                        <el-button @click.prevent="ImportDataTeacher(2)" size="mini" type="primary">Import dữ liệu-->
                        <!--                        </el-button>-->
                        <!-- <button size="mini" type="success" @click.prevent="DownloadTemplate(2)">Download template
                        </button> -->
                        <!-- <button
                        v-bind:disabled="list_hoc_sinh.length==0"
                        size="mini" type="info"
                        @click.prevent="getDownLoadExcel(1)">Xuất Excel 2
                    </button> -->
                        <el-button v-bind:disabled="list_hoc_sinh.length==0" size="mini" type="info"
                            :show="show_excel_hoc_sinh" @close="show_excel_hoc_sinh=false" :limit="10"
                            @click.prevent="xuatDuLieuHocSinh">Xuất Excel
                        </el-button>
                        <el-button size="mini" type="danger" @click.prevent="deteteStudent()">Xóa dữ liệu
                        </el-button>
                    </div>
                    <hr />
                    <!-- end button -->
                    <!-- Danh sách học sinh -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Mã học sinh</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Tên học sinh</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Giới tính</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày sinh</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Lớp học</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Địa chỉ</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số CMND</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số điện thoại</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Ngày cập nhật</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Thao tác</p>
                                    </th>
                                    <th class="text-center">
                                        <input type="checkbox" @click="ChonTatCa" v-model="slectAll" />
                                        <span>Chọn tất cả</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_hoc_sinh.length===0">
                                <tr>
                                    <td class="text-center" colspan="12">
                                        <p>Không có bản ghi nào được tìm thấy</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(px,index) in list_hoc_sinh" :key="index">
                                    <td class="text-center">{{ (currentPageStudent - 1) * limit_student + index + 1 }}
                                    </td>
                                    <td>
                                        <p>{{ px.maHocSinh }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.hoTen }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ parseInt(px.gioiTinh) === 1 ? 'Nam' : 'Nữ' }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.ngaySinh }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.maLopHoc }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.dchiThtru }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.soCmnd }}</p>
                                    </td>
                                    <td>
                                        <p>{{ px.soDthoaiDdong }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ px.ngayCapNhat }}</p>
                                    </td>
                                    <td class="text-center">
                                        <el-tooltip class="item" effect="dark" content="Chỉnh sửa"
                                            placement="left-start">
                                            <el-button type="warning" @click="ChinhSuaThongTinHocSinh(px)" size="mini"
                                                icon="el-icon-edit">
                                            </el-button>
                                        </el-tooltip>
                                    </td>
                                    <td>
                                        <input type="checkbox" v-model="lsDelete" :value="px.maHocSinh" />
                                        <span style="font-size:12px">chọn</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Page :total_rows="total_rows_student" @pageChange="layLaiHocSinh($event)"></Page>
                    <!-- Hết danh sách giáo viên -->
                    <!-- hết nội dung phần học sinh -->
                </el-tab-pane>
                <el-tab-pane label="Role">
                    <span slot="label">4. Xóa dữ liệu</span>

                    <!-- start filter -->
                    <div class="row" style="padding-top:15px;">
                        <!-- Loại dữ liệu -->
                        <div class="col-md-2">
                            <label>Chọn loại dữ liệu <span style="color:#DC0101">*</span></label>
                            <select v-model="loaiDuLieuXoa" class="form-control">
                                <option value="">Chọn loại dữ liệu</option>
                                <option value="1">Dữ liệu học sinh</option>
                                <option value="2">Dữ liệu giáo viên</option>
                            </select>
                        </div>
                        <!-- đơn vị -->
                        <div class="col-md-4 timkiem">
                            <label class="typo__label">Đơn vị quản lý <span style="color:#DC0101">*</span></label>
                            <div>
                                <eselect style="width:100%" multiple collapseTags v-model="ds_don_vi"
                                    @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                    :fields="['tenDonVi','maDonVi']" />

                            </div>
                            <!-- <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> -->
                        </div>
                        <!-- end đơn vị -->
                        <!-- cấp học -->
                        <div class="col-md-2 timkiem">
                            <div>
                                <label class="typo__label">Cấp học <sup style="color:#DC0101">1</sup></label>
                                <div v-if="thongtin.role2!=5">
                                    <eselect style="width:100%" collapseTags v-model="ds_cap_hoc" @change="ChonCapHoc"
                                        :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />

                                </div>
                                <div v-if="thongtin.role2==5">
                                    <input :disabled="thongtin.role2 == 5" class="form-control" placeholder="Cấp học" />
                                </div>
                            </div>
                        </div>
                        <!-- end cấp học -->
                        <!-- Trường học -->
                        <div class="col-md-4 timkiem">
                            <div v-if="thongtin.role2!=5">
                                <label class="typo__label">Trường học </label>
                                <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags
                                    v-model="ds_truong_hoc" :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                    :fields="['tenTruongHoc','maTruongHoc']" />
                            </div>
                            <div v-if="thongtin.role2==5">
                                <label>Trường học:</label>
                                <input :disabled="thongtin.role2 == 5" :value="thongtin.display_name"
                                    class="form-control" placeholder="Nhập..." />
                            </div>
                        </div>
                        <!-- Hết trường học -->
                        <!-- Năm học -->
                        <div class="col-md-2 timkiem">
                            <label class="typo__label">Năm học <span style="color:#DC0101">*</span></label>

                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </div>
                        <!-- Hết năm học -->
                    </div>
                    <!-- end filter -->
                    <!-- button -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <el-button size="mini" type="danger" @click.prevent="xoaDuLieu()">Xóa dữ liệu</el-button>
                        </div>
                    </div>
                </el-tab-pane>
                <el-tab-pane label="Role">
                    <span slot="label">5. Kết chuyển dữ liệu</span>

                    <div class="row" style="padding-top:15px;">
                        <!-- Loại dữ liệu -->
                        <div class="col-md-2">
                            <label>Chọn loại dữ liệu <span style="color:#DC0101">*</span></label>
                            <select v-model="loaiDuLieuKetChuyen" class="form-control">
                                <option value="">Chọn loại dữ liệu</option>
                                <option value="1">Dữ liệu học sinh</option>
                                <option value="2">Dữ liệu giáo viên</option>
                                <option value="3">Dữ liệu cán bộ</option>
                            </select>
                        </div>
                        <!-- đơn vị -->
                        <div class="col-md-4 timkiem">
                            <label class="typo__label">Đơn vị quản lý</label>
                            <div>
                                <eselect style="width:100%" multiple collapseTags v-model="ds_don_vi"
                                    @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                    :fields="['tenDonVi','maDonVi']" />

                            </div>
                            <!-- <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> -->
                        </div>
                        <!-- end đơn vị -->
                        <!-- cấp học -->
                        <div class="col-md-2 timkiem">
                            <div>
                                <label class="typo__label">Cấp học <sup style="color:#DC0101">1</sup></label>
                                <div v-if="thongtin.role2!=5">
                                    <eselect style="width:100%" collapseTags v-model="ds_cap_hoc" @change="ChonCapHoc"
                                        :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />

                                </div>
                                <div v-if="thongtin.role2==5">
                                    <input :disabled="thongtin.role2 == 5" class="form-control" placeholder="Cấp học" />
                                </div>
                            </div>
                        </div>
                        <!-- end cấp học -->
                        <!-- Trường học -->
                        <div class="col-md-4 timkiem">
                            <div v-if="thongtin.role2!=5">
                                <label class="typo__label">Trường học <span class="red">*</span></label>
                                <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags
                                    v-model="ds_truong_hoc" :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                    :fields="['tenTruongHoc','maTruongHoc']" />
                            </div>
                            <div v-if="thongtin.role2==5">
                                <label>Trường học:</label>
                                <input :disabled="thongtin.role2 == 5" :value="thongtin.display_name"
                                    class="form-control" placeholder="Nhập..." />
                            </div>
                        </div>
                        <!-- Hết trường học -->
                        <!-- Năm học -->
                        <div class="col-md-2 timkiem">
                            <label class="typo__label">Năm học <span style="color:#DC0101">*</span></label>

                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </div>
                        <!-- Hết năm học -->
                    </div>
                    <!-- end filter -->
                    <!-- button -->
                    <hr />
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <el-button size="mini" type="primary" @click.prevent="ketChuyenDuLieu()">Kết chuyển dữ
                                liệu
                            </el-button>
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>
            <div class="row">
                <div class="col-md-12 text-left">
                    <p><b style="color:blue">Ghi chú:</b> <span style="color:#DC0101">1</span> - Tham số cấp học chỉ hỗ trợ
                        cho việc tìm kiếm trường học. Không phục vụ cho công việc tra cứu.</p>
                </div>
            </div>
            <!-- ghi chú -->
            <!-- end filter -->
            <!-- import dữ liệu sso -->
            <XemBaoCao :show="show_info" :item="TypeImport" :nh="nhip" @close="show_info=false" @done="ReloadPage">
            </XemBaoCao>
            <popup-limit-giao-vien :show="show_excel_giao_vien" @close="show_excel_giao_vien=false"
                @submit="submitExcelGiaoVien($event)" :rowsview="limit_teacher" :limit="10"></popup-limit-giao-vien>
            <popup-limit-hoc-sinh :show="show_excel_hoc_sinh" @close="show_excel_hoc_sinh=false"
                @submit="submitExcelHocSinh($event)" :rowsview="limit_student" :limit="10"></popup-limit-hoc-sinh>
            <popup-limit-can-bo :show="show_excel_can_bo" @close="show_excel_can_bo=false"
                @submit="submitExcelCanBo($event)" :rowsview="limit_can_bo" :limit="10"></popup-limit-can-bo>
            <!-- Chỉnh sửa cán bộ -->
            <!-- <div v-if="show_update_teacher"> -->
            <update-giaovien :show="show_update_teacher" :item="du_lieu_chinh_sua_giao_vien" @success="getListTeacher()"
                @close="show_update_teacher=false">
            </update-giaovien>
            <!-- </div> -->
            <update-cbps :show="show_update_cbps" :item="du_lieu_chinh_sua_cbps" @success="getListCanBoPhongSo()"
                @close="show_update_cbps=false">
            </update-cbps>
            <update-hoc-sinh :namhoc="namHoc" :show="show_update_hoc_sinh" :listKhoiHoc="list_khoi_hoc"
                :item="du_lieu_chinh_sua_hoc_sinh" @success="getListStudent()" @close="show_update_hoc_sinh=false">
            </update-hoc-sinh>
            <!--  -->
        </div>
    </div>
</template>
<script>
    import utils from '../../utils';
    import api from './../api';
    import dialog from '../../utils/dialog';
    import constant from "../../utils/constant";
    import Multiselect from 'vue-multiselect';
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import XemBaoCao from './PopUpNopDuLieuSSO'
    import ChinhSuaGiaoVien from './traCuuSSO/ChinhSuaGiaoVien'
    import ChinhSuaCanBoPhongSo from './traCuuSSO/ChinhSuaCanBoPhongSo'
    import ChinhSuaHocSinh from './traCuuSSO/ChinhSuaHocSinh'
    import moment from "moment";
    import Page from '../ui/PagingCustom';
    import ESelectVue from '../ui/ESelect.vue';
    import PopupExportLimit from './popUpcheckExportExcel';
    import VueAlertify from "vue-alertify";

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
    // start script
    export default {
        components: {
            Multiselect,
            "XemBaoCao": XemBaoCao,
            "Page": Page,
            'popup-limit-giao-vien': PopupExportLimit,
            'popup-limit-hoc-sinh': PopupExportLimit,
            'popup-limit-can-bo': PopupExportLimit,
            'update-giaovien': ChinhSuaGiaoVien,
            'update-cbps': ChinhSuaCanBoPhongSo,
            'update-hoc-sinh': ChinhSuaHocSinh,
            'eselect': ESelectVue,
        },
        watch: {
            lsDelete: function (newVal) {
                if (this.lsDelete.length === this.list_hoc_sinh.length) {
                    this.slectAll = true;
                } else {
                    this.slectAll = false;
                }
            },
            lsDelete2: function (newVal) {
                console.log("Danh sách xóa");
                // this.slectAll2 = false;
                console.log(newVal);
                if (this.lsDelete2.length === this.list_giao_vien.length) {
                    this.slectAll2 = true;
                } else {
                    this.slectAll2 = false;
                }
            },
            lsDelete3: function (newVal) {
                console.log("Danh sách xóa");
                // this.slectAll2 = false;
                console.log(newVal);
                if (this.lsDelete3.length == this.list_can_bo.length) {
                    this.slectAll3 = true;
                } else {
                    this.slectAll3 = false;
                }
            },
            danhSachDonVi: function (newVal) {},
            danhSachCapHoc: function (newVal) {
                this.ds_cap_hoc = "";
                this.ds_truong_hoc = [];
                this.danhSachTruongHoc = [];
                if (newVal) {
                    this.ds_cap_hoc = newVal.id;
                }
                console.log("cấp học:" + this.ds_cap_hoc);
                this.getTruongHoc();
            },
            danhSachTruongHoc: function (newVal) {},

        },
        data() {
            return {
                // check xuất excel
                show_excel_giao_vien: false,
                show_excel_hoc_sinh: false,
                show_excel_can_bo: false,
                start_excel_giao_vien: 0,
                limit_excel_giao_vien: 800,
                ds_don_vi_custom: [],
                // Phần xóa
                email: "",
                Keyword: "",
                tenLop: "",
                loaiDuLieuXoa: "",
                loaiDuLieuKetChuyen: "",
                ds_don_vi: [],
                // phần import
                show_info: false,
                TypeImport: "",
                nhip: "",
                //
                ds_cap_hoc: [],
                ds_truong_hoc: [],
                lsDelete: [],
                lsDelete2: [],
                lsDelete3: [],
                slectAll2: false,
                slectAll3: false,
                slectAll: false,
                currentPageCanBo: 1,
                currentPageStudent: 1,
                currentPage: 1,
                total_rows: 0,
                total_rows_student: 0,
                total_rows_can_bo: 0,
                start_teacher: 0,
                start_can_bo: 0,
                start_student: 0,
                limit_teacher: 25,
                limit_can_bo: 25,
                limit_student: 25,
                list_don_vi: [],
                list_truong_hoc: [],
                list_giao_vien: [],
                list_can_bo: [],
                list_hoc_sinh: [],
                danhSachDonVi: [],
                danhSachCapHoc: [],
                namHoc: "",
                danhSachTruongHoc: [],
                thongtin: {},
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_hoc_ky: constant.LIST_HOC_KY,
                date: new Date(),
                show_update_teacher: false,
                show_update_cbps: false,
                show_update_hoc_sinh: false,
                du_lieu_chinh_sua_hoc_sinh: {},
                du_lieu_chinh_sua_giao_vien: {},
                du_lieu_chinh_sua_cbps: {},
                ds_khoi_hoc: '',
                list_khoi_hoc: [],
                khoi_cap_mot: constant.khoiCapMot,
                khoi_cap_hai: constant.khoiCapHai,
                khoi_cap_ba: constant.khoiCapBa,
                khoi_cap_4: constant.khoiHocNhaTre,
                khoi_cap_5: constant.khoiHocMauGiao,
            }
        },
        mounted() {
            this.thongtin = JSON.parse(window.userInfo);
            if (this.thongtin.role2 == 5) {
                this.tenDonViDangNhap = this.thongtin.display_name;
            }

            this.mapKhoiHoc(this.thongtin.listCapHoc);
            console.log("thông tin đăng nhập:" + JSON.stringify(this.thongtin));
            // lấy năm hiện tại

            this.namHoc = this.thongtin.namHocHienTai;
            // this.namHoc = 2021;
            if (this.thongtin.role2 == 5) {
                this.maTruongHoc = this.thongtin.ma_truong_hoc
            }
            this.getDonVi(() => {
                console.log("Check 222222222222");
            });
            this.getTruongHoc();
            // setTimeout(() => {     this.checkBeforeSearch(); }, 100);
        },
        methods: {
            ketChuyenDuLieu() {
                if (!this.ds_truong_hoc.length) {
                    this
                        .$alertify
                        .error('Chưa chọn trường học để kết chuyển')
                }
            },

            ChinhSuaThongTinHocSinh(e) {
                this.show_update_hoc_sinh = true;
                this.du_lieu_chinh_sua_hoc_sinh = e;
                console.log(this.du_lieu_chinh_sua_hoc_sinh)
                console.log("Chỉnh sửa học sinh");
            },
            // Chỉnh sửa giáo viên
            showUpdateGiaoVien(e) {
                this.show_update_teacher = true;
                this.du_lieu_chinh_sua_giao_vien = e;
                console.log("Chỉnh sửa giáo viên");
            },
            // Chỉnh sửa giáo viên
            showUpdateCanBoPhongSo(e) {
                this.show_update_cbps = true;
                this.du_lieu_chinh_sua_cbps = e;
                console.log("Chỉnh sửa giáo viên");
            },
            submitExcelGiaoVien(e) {
                if (e.from == 1) {
                    this.start_excel_giao_vien = 0;
                } else {
                    this.start_excel_giao_vien = (e.from - 1) * this.limit_teacher;
                }
                this.limit_excel_giao_vien = (e.to) * this.limit_teacher;
                this.getDownLoadExcel(2);
            },
            submitExcelHocSinh(e) {
                console.error('submitExcelHocSinh')
                console.error(e)
                if (e.from == 1) {
                    this.start_excel_giao_vien = 0;
                } else {
                    this.start_excel_giao_vien = (e.from - 1) * this.limit_student;
                }
                this.limit_excel_giao_vien = (e.to) * this.limit_student;
                this.getDownLoadExcel(1);
            },
            submitExcelCanBo(e) {
                if (e.from == 1) {
                    this.start_excel_giao_vien = 0;
                } else {
                    this.start_excel_giao_vien = (e.from - 1) * this.limit_can_bo;
                }
                this.limit_excel_giao_vien = (e.to) * this.limit_can_bo;
                this.getDownLoadExcel(3);
            },
            xuatDuLieuGiaoVien() {
                console.log("Xuất danh sách dữ liệu giáo viên");
                this.show_excel_giao_vien = true;
            },
            xuatDuLieuCanBo() {
                console.log("Xuất danh sách dữ liệu giáo viên");
                this.show_excel_can_bo = true;
            },
            xuatDuLieuHocSinh() {
                console.log("Xuất danh sách dữ liệu học sinh");
                this.show_excel_hoc_sinh = true;
            },
            ChonDonVi() {
                this.ds_truong_hoc = [];
                this.danhSachTruongHoc = [];
                this.getTruongHoc();
            },
            ChonCapHoc() {
                this.ds_truong_hoc = [];
                this.ds_khoi_hoc = '';
                this.danhSachTruongHoc = [];
                if (this.ds_cap_hoc) {
                    this.mapKhoiHoc([this.ds_cap_hoc]);
                } else {
                    this.mapKhoiHoc(null);
                }
                this.getTruongHoc();
            },
            mapKhoiHoc(e) {
                console.log("map cấp học đã chọn:")
                console.log(e)
                let dulieu = e;
                let khoihoc = [];
                if (dulieu) {
                    for (let i = 0; i < dulieu.length; i++) {
                        if (dulieu[i] == 1) {
                            khoihoc = khoihoc.concat(this.khoi_cap_mot)
                        };
                        if (dulieu[i] == 2) {
                            khoihoc = khoihoc.concat(this.khoi_cap_hai)
                        };
                        if (dulieu[i] == 3) {
                            khoihoc = khoihoc.concat(this.khoi_cap_ba)
                        };
                        if (dulieu[i] == 4) {
                            khoihoc = khoihoc.concat(this.khoi_cap_4)
                        };
                        if (dulieu[i] == 5) {
                            khoihoc = khoihoc.concat(this.khoi_cap_5)
                        };
                        if (dulieu[i] == 45) {
                            khoihoc = khoihoc.concat(this.khoi_cap_4, this.khoi_cap_5)
                        };
                        if (dulieu[i] == 6) {
                            khoihoc = khoihoc.concat(this.khoi_cap_mot, this.khoi_cap_hai, this.khoi_cap_ba, this
                                .khoi_cap_4, this.khoi_cap_5)
                        };
                    }
                } else {
                    khoihoc = khoihoc.concat(this.khoi_cap_mot, this.khoi_cap_hai, this.khoi_cap_ba, this
                        .khoi_cap_4, this.khoi_cap_5)
                }
                console.log("Khối học sau map:");
                khoihoc.sort((a, b) => (a.id > b.id) ? 1 : -1);
                let khoihoc_unique = [];
                khoihoc_unique = [...new Set(khoihoc.map(item => item))];
                this.list_khoi_hoc = khoihoc_unique;
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
            getTruongHocById(e) {
                // for (let i=0;i<this.list_truong_hoc.length;i++){
                //     if (this.list_truong_hoc[i].maTruongHoc==e){
                //         return (this.list_truong_hoc[i].tenTruongHoc);
                //     }
                // }
                let params = {
                    ma: e
                };
                // rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                //     return("hgfhgf")
                // });
            },
            ChonTatCa3() {
                console.log("Chọn:" + this.slectAll3)
                if (!this.slectAll3) {
                    this.slectAll3 = [];
                    for (let i = 0; i < this.list_can_bo.length; i++) {
                        if (this.list_can_bo[i].syncMaSoGd == this.thongtin.ma_so) {
                            this
                                .lsDelete3
                                .push(this.list_can_bo[i].maCanBo);
                        }
                    }
                } else {
                    this.lsDelete3 = [];
                }
            },
            ChonTatCa2() {
                console.log("Chọn:" + this.slectAll2)
                if (!this.slectAll2) {
                    this.lsDelete2 = [];
                    for (let i = 0; i < this.list_giao_vien.length; i++) {
                        if (this.list_giao_vien[i].syncMaSoGd == this.thongtin.ma_so) {
                            this
                                .lsDelete2
                                .push(this.list_giao_vien[i].maGiaoVien);
                        }
                    }
                } else {
                    this.lsDelete2 = [];
                }
            },
            ChonTatCa() {
                if (!this.slectAll) {
                    this.lsDelete = [];
                    for (let i = 0; i < this.list_hoc_sinh.length; i++) {
                        this
                            .lsDelete
                            .push(this.list_hoc_sinh[i].maHocSinh);
                    }
                } else {
                    this.lsDelete = [];
                }
            },
            // Xóa dữ liệu toàn cục
            xoaDuLieu() {
                let uri = "";
                if (this.loaiDuLieuXoa == 1) {
                    uri = "/csdlgd-admin/sso/deleteHocSinh";
                    console.log("dữ liệu học sinh");
                } else if (this.loaiDuLieuXoa == 2) {
                    uri = "/csdlgd-admin/sso/deleteGiaoVien";
                    console.log("Dữ liệu giáo viên");
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn loại dữ liệu muốn xóa.");
                    return
                    console.log("thiếu dữ liệu");
                }
                if (this.ds_don_vi.length == 0) {
                    this
                        .$alertify
                        .error("Vui lòng chọn đơn vị.")
                    return
                }
                if (this.ds_cap_hoc) {
                    if (this.ds_cap_hoc.length != 0) {
                        if (this.ds_truong_hoc.length == 0) {
                            this
                                .$alertify
                                .error("Khi chọn cấp học. Vui lòng bổ sung thêm trường học.");
                            return;
                        }
                    }
                }
                let params = {
                    lstMaDonVi: this.ds_don_vi,
                    lstMaTruong: this.ds_truong_hoc,
                    namHoc: this.namHoc
                };
                let dachon = "Xác nhận xóa dữ liệu?"
                if (this.ds_truong_hoc.length == 0) {
                    dachon = "Xác nhận xóa dữ liệu của các đơn vị đã chọn?";
                } else {
                    dachon = "Xác nhận xóa dữ liệu của các trường học đã chọn?";
                }
                dialog.confirmDialog(dachon,
                    "Đồng ý",
                    () => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post(uri, params, data => {
                            loading.close();
                            console.log("xóa trả về");
                            console.log(data);
                            if (data.data.rc == 0) {
                                this
                                    .$alertify
                                    .success(data.data.rd)
                            } else {
                                this
                                    .$alertify
                                    .error("Xóa dữ liệu thất bại. Vui lòng thử lại.")
                            }
                        });
                    }
                );
            },
            // tải file mẫu
            DownloadTemplate(e) {
                if (e == 1) {
                    window.location.href = "https://tichhop.csdl.edu.vn/exportExcel/FileUpLoadDuLieuGiaoVien.xlsx"
                }
                if (e == 2) {
                    window.location.href = "https://tichhop.csdl.edu.vn/exportExcel/FileUpLoadDuLieuHocSinh.xlsx"
                }
                if (e == 3) {
                    window.location.href = "https://tichhop.csdl.edu.vn/exportExcel/FileUpLoadDuLieuCanbo.xlsx"
                }
            },
            // Load lại trang
            ReloadPage() {
                // dialog.confirmDialog(
                //     "Import file thành công. Hệ thống sẽ tiến hành tải lại trang",
                //     "Đồng ý",
                //     () => {                        location.reload();
                //     }
                // );
            },
            // import dữ liệu
            ImportDataTeacher(e) {
                this.show_info = true;
                this.TypeImport = e;
                this.nhip = this.namHoc;
                console.log(this.nhip);
                console.log(this.show_info);
                console.log("Loại" + this.TypeImport);
                console.log("tiến hành imoirt");
            },
            // Xuất dữ liệu ra excel
            getDownLoadExcel(e) {
                let url = "xuat-excel-du-lieu-sso";
                let params = {
                    type: e,
                    start: this.start_excel_giao_vien,
                    limit: this.limit_excel_giao_vien,
                    email: this.email,
                    lstMaDonVi: this.ds_don_vi,
                    lstMaTruongHoc: this.ds_truong_hoc,
                    namHoc: this.namHoc,
                    Keyword: '',
                    tenLop: '',
                    maKhoi: '',
                };
                if (e == 1) {
                    params.Keyword = this.Keyword;
                    params.tenLop = this.tenLop;
                    params.maKhoi = this.ds_khoi_hoc.toString()
                }
                dialog.confirmDialog(
                    "Xác nhận tải xuống dữ liệu. Vui lòng chờ trong thời gian tải xuống",
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
            // Xóa cán bộ
            deteteCanBo() {
                console.log(this.lsDelete3);
                if (this.lsDelete3.length > 0) {
                    dialog.confirmDialog(
                        "Bạn có muốn xóa dữ liệu của " + this.lsDelete3.length + " cán bộ này?",
                        "Đồng ý",
                        () => {
                            console.log("Đồng ý xóa danh sách học sinh:");
                            console.log(this.lsDelete3);
                            let params = {
                                lstMa: this.lsDelete3,
                                namHoc: this.namHoc
                            };
                            console.log("xóa dữ liệu học sinh");
                            console.log("dữ liệu xóa:" + JSON.stringify(params));
                            const loading = this.$loading({
                                lock: true,
                                text: 'Loading',
                                spinner: 'el-icon-loading',
                                background: 'rgba(0, 0, 0, 0.7)'
                            });
                            rest_api.post("/csdlgd-admin/sso/deleteCanBoPhongSo", params, data => {
                                loading.close();
                                console.log("xóa trả về");
                                console.log(data);
                                if (data.data.rc == 0) {
                                    this
                                        .$alertify
                                        .success("Xóa dữ liệu thành công")
                                    this.getListCanBoPhongSo();
                                } else {
                                    this
                                        .$alertify
                                        .error("Xóa dữ liệu thất bại. Vui lòng thử lại.")
                                }
                            });
                        }
                    );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn cán bộ để xóa dữ liệu")
                    return;
                }
            },
            // Xóa giáo viên
            deteteTeacher() {
                console.log(this.lsDelete2);
                if (this.lsDelete2.length > 0) {
                    dialog.confirmDialog(
                        "Bạn có muốn xóa dữ liệu của " + this.lsDelete2.length + " giáo viên này?",
                        "Đồng ý",
                        () => {
                            console.log("Đồng ý xóa danh sách học sinh:");
                            console.log(this.lsDelete2);
                            let params = {
                                lstMa: this.lsDelete2,
                                namHoc: this.namHoc
                            };
                            console.log("xóa dữ liệu học sinh");
                            console.log("dữ liệu xóa:" + JSON.stringify(params));
                            const loading = this.$loading({
                                lock: true,
                                text: 'Loading',
                                spinner: 'el-icon-loading',
                                background: 'rgba(0, 0, 0, 0.7)'
                            });
                            rest_api.post("/csdlgd-admin/sso/deleteGiaoVien", params, data => {
                                loading.close();
                                console.log("xóa trả về");
                                console.log(data);
                                if (data.data.rc == 0) {
                                    this.thongBao('success', data.data.rd)
                                    this.getListTeacher();
                                } else {
                                    this
                                        .$alertify
                                        .error("Xóa dữ liệu thất bại. Vui lòng thử lại.")
                                }
                            });
                        }
                    );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn cán bộ để xoá dữ liệu.")
                    return;
                }
            },
            thongBao(typeNoty, message) {
                let msg = "";
                let cl = "";
                if (message) {
                    msg = message;
                }
                let type = "success";
                if (typeNoty) {
                    type = typeNoty
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
                    type: type,
                    duration: 5000
                });
            },
            // hết xóa giáo viên Xóa giáo viên
            deteteStudent() {
                console.log(this.lsDelete);
                if (this.lsDelete.length > 0) {
                    dialog.confirmDialog(
                        "Bạn có muốn xóa dữ liệu của " + this.lsDelete.length + " học sinh này?",
                        "Đồng ý",
                        () => {
                            console.log("Đồng ý xóa danh sách học sinh:");
                            console.log(this.lsDelete);
                            let params = {
                                lstMa: this.lsDelete,
                                namHoc: this.namHoc
                            };
                            console.log("Học sinh xóa:" + JSON.stringify(params));
                            console.log("dữ liệu xóa:" + JSON.stringify(params));
                            const loading = this.$loading({
                                lock: true,
                                text: 'Loading',
                                spinner: 'el-icon-loading',
                                background: 'rgba(0, 0, 0, 0.7)'
                            });
                            rest_api.post("/csdlgd-admin/sso/deleteHocSinh", params, data => {
                                loading.close();
                                console.log("xóa trả về");
                                console.log(data);
                                if (data.data.rc == 0) {
                                    // this
                                    //     .$alertify
                                    //     .success("Xóa dữ liệu thành công")
                                    this.thongBao('success', data.data.rd)
                                    this.getListStudent();
                                } else {
                                    this
                                        .$alertify
                                        .error("Xóa dữ liệu thất bại. Vui lòng thử lại.")
                                }
                            });
                        }
                    );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn học sinh để xoá dữ liệu.")
                    return;
                }
            },
            // hết xóa giáo viên
            checkBeforeSearchTeacher() {
                this.list_giao_vien = [];
                this.total_rows = 0;
                console.log(this.namHoc);
                if (!this.namHoc) {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                    return;
                }
                console.log("Không");
                if (!this.email) {
                    console.log("Một");
                    console.log(this.danhSachTruongHoc.length);
                    if (this.danhSachTruongHoc.length == 0) {
                        console.log("Hai");
                        console.log(this.ds_don_vi.length);
                        if (this.ds_don_vi.length == 0) {
                            console.log("Ba");
                            this
                                .$alertify
                                .error("Vui lòng chọn đơn vị để tìm kiếm");
                            return;
                        }
                    }
                }
                console.log("check trước khi tìm kiếm");
                this.getListTeacher();
            },
            checkBeforeSearchCanBo() {
                this.list_can_bo = [];
                this.total_rows_can_bo = 0;
                console.log(this.namHoc);
                if (!this.namHoc) {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                    return;
                }
                if (!this.email) {
                    console.log("Một");
                    console.log(this.danhSachTruongHoc.length);
                    console.log("Hai");
                    console.log(this.ds_don_vi.length);
                    if (this.ds_don_vi.length == 0) {
                        console.log("Ba");
                        this
                            .$alertify
                            .error("Vui lòng chọn đơn vị để tìm kiếm");
                        return;
                    }
                }
                this.getListCanBoPhongSo();
            },
            checkBeforeSearchStudent() {
                this.list_hoc_sinh = [];
                this.total_rows_student = 0;
                console.log(this.namHoc);
                if (!this.namHoc) {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                    return;
                }
                if (!this.Keyword || this.Keyword == '') {
                    if (!this.ds_truong_hoc || this.ds_truong_hoc.length == 0) {
                        if (!this.ds_don_vi || this.ds_don_vi.length == 0) {
                            this
                                .$alertify
                                .error("Vui lòng chọn đơn vị để tìm kiếm");
                            return;
                        }
                    }
                }
                console.log("check trước khi tìm kiếm");
                this.getListStudent();
            },
            // Lấy lại danh sách giáo viên
            layLaiGiaoVien(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start_teacher = e.start;
                this.limit_teacher = e.limit;
                this.currentPage = e.currentPage;
                this.getListTeacher()
            },
            //Lấy lại học sinh
            layLaiHocSinh(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start_student = e.start;
                this.limit_student = e.limit;
                this.currentPageStudent = e.currentPage;
                this.getListStudent()
            },
            //Lấy lại học sinh
            layLaiCanBo(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start_can_bo = e.start;
                this.limit_can_bo = e.limit;
                this.currentPageCanBo = e.currentPage;
                this.getListCanBoPhongSo()
            },
            // Lấy danh sách giáo viên
            getListTeacher() {
                // xóa danh sách cũ
                console.log("Lấy danh sách giáo viên");
                let params = {
                    offset: this.start_teacher,
                    limit: this.limit_teacher,
                    email: this.email,
                    lstMaDonVi: this.ds_don_vi,
                    lstMaTruongHoc: this.ds_truong_hoc,
                    namHoc: this.namHoc
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/sso/giaoVien", params, data => {
                    loading.close();
                    console.log("lấy danh sách giáo viên trả về:" + JSON.stringify(data));
                    if (data.data.danhSachGiaoVien) {
                        this.list_giao_vien = data.data.danhSachGiaoVien;
                        this.total_rows = data.data.total;
                        console.log("danh sách giáo viên:" + JSON.stringify(this.list_giao_vien));
                        if (this.list_giao_vien.length == 0) {
                            // this
                            //     .$alertify
                            //     .error('Không có bản ghi nào được tìm thấy');
                        }
                        if (this.list_giao_vien.length > 0) {
                            // this
                            //     .$alertify
                            //     .success('Lấy dữ liệu thành công.')
                        }
                    }
                });
            },
            // Lấy danh sách giáo viên
            getListCanBoPhongSo() {
                // xóa danh sách cũ
                console.log("Lấy danh sách giáo viên");
                let params = {
                    offset: this.start_can_bo,
                    limit: this.limit_can_bo,
                    email: this.email,
                    lstMaDonVi: this.ds_don_vi,
                    namHoc: this.namHoc
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/sso/canBoPhongSo", params, data => {
                    loading.close();
                    console.log("lấy danh sách cán bộ phòng sở trả về:" + JSON.stringify(data.data));
                    if (data.data.danhSachCanBoPhongSo) {
                        this.list_can_bo = data.data.danhSachCanBoPhongSo;
                        this.total_rows_can_bo = data.data.total;
                        console.log("danh sách cán bộ phòng sở:" + JSON.stringify(this.list_can_bo));
                        if (this.list_can_bo.length == 0) {
                            // this
                            //     .$alertify
                            //     .error('Không có bản ghi nào được tìm thấy');
                        }
                        if (this.list_can_bo.length > 0) {
                            // this
                            //     .$alertify
                            //     .success('Lấy dữ liệu thành công.')
                        }
                    }
                });
            },
            // Lấy danh sách học sinh
            getListStudent() {
                // xóa danh sách cũ
                this.list_hoc_sinh = [];
                this.total_rows_student = 0;
                console.log("Lấy danh sách học sinh");
                let params = {
                    offset: this.start_student,
                    limit: this.limit_student,
                    lstMaDonVi: this.ds_don_vi,
                    lstMaTruongHoc: this.ds_truong_hoc,
                    namHoc: this.namHoc,
                    maKhoi: this.ds_khoi_hoc.toString(),
                    Keyword: this.Keyword,
                    tenLop: this.tenLop,
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/sso/hocSinh", params, data => {
                    loading.close();
                    console.log("lấy danh sách học sinh trả về:" + JSON.stringify(data));
                    if (data.data.listDanhSachHocSinh) {
                        this.list_hoc_sinh = data.data.listDanhSachHocSinh;
                        this.total_rows_student = data.data.total;
                        console.log("danh sách giáo viên:" + JSON.stringify(this.list_hoc_sinh));
                        if (this.list_hoc_sinh.length == 0) {
                            // this
                            //     .$alertify
                            //     .error('Không có bản ghi nào được tìm thấy');
                        }
                        if (this.list_hoc_sinh.length > 0) {
                            // this
                            //     .$alertify
                            //     .success('Lấy dữ liệu thành công.')
                        }
                    }
                });
            },
            // Lấy trường học
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi
                };
                if (this.ds_cap_hoc != 6) {
                    if (this.ds_cap_hoc.length == 0) {
                        params.capHoc = [];
                    } else {
                        params.capHoc = [this.ds_cap_hoc];
                    }
                } else {
                    params.capHoc = ['-1', '-2', '6']
                }
                console.log("deno ahihi" + JSON.stringify(params));
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
                        let ldv = []
                        let dulieu = data.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenTruongHoc: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                maTruongHoc: dulieu[i].maTruongHoc
                            }
                            ldv.push(obj)
                        }
                        this.list_truong_hoc = ldv;
                    }
                });
            },
            // Lấy danh sách đơn vị
            getDonVi(ck = () => {}) {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_don_vi
                };
                if (this.thongtin.role2 == 5 || this.thongtin.role2 == 4) {
                    params.maTinhThanh = "",
                        params.maQuanHuyen = this.thongtin.ma_don_vi;
                }
                console.log("pr ẻty" + JSON.stringify(params));
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    console.log("lấy đơn vị thành công" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        let ldv = []
                        let dulieu = data.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenDonVi: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                maDonVi: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi = ldv;
                        ck();
                    }
                });
            },
            // gán năm học
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
    // end script

</script>
<style scoped="scoped">

    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    label {
        padding: 0;
        margin: 0;
    }

    hr {
        margin: 5px;
    }

    .timkiem {
        height: 65px;
    }

    thead tr th {
        text-align: center;
        vertical-align: middle;
    }

    .table-bordered>tbody>tr>td {
        vertical-align: middle;
        padding: 5px;
    }

    p {
        font-size: 12px;
    }

    .table>thead>tr>th {
        padding: 4px;
    }

    .choose-action .dropdown .dropdown-toggle {
        box-sizing: border-box;
        display: inline-block;
        width: 100%;
        background-color: #57A0D4;
        padding: 3px 15px;
        font-weight: 500;
        /* min-width: 150px; */
        width: 100%;
        font-size: 12px;
        cursor: pointer;
        text-align: center;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
        color: #FFF;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 5px;
        margin-bottom: 0;
    }

    .choose-action .dropdown-menu>li>a {
        padding: 3px 10px;
    }

    .navbar-nav>li>.dropdown-menu {
        width: 100%;
    }

    .navbar-nav>li {
        width: 100%;
    }

    .pxn-bao-header {
        display: flex;
        align-items: center;
    }

    .mauDo {
        background: #f3cccc !important;
    }

</style>

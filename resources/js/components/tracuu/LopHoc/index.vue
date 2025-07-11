<template>
    <div v-loading.fullscreen.lock="fullScreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <Breadcrumb :menu="'Tra cứu'" :desc="'Tra cứu lớp học'" />
        <div class="card-bieu-do">
            <el-form ref="ruleForm">
                <el-row :gutter="24">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :sm="24" :md="12" :lg="12" v-if="namHoc<2025">
                        <label class="typo__label">Đơn vị quản lý</label>
                        <eselect :disabled="thongtin.role>2" style="width:100%" multiple collapseTags
                                 v-model="ds_don_vi" @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                 :fields="['tenDonVi','maDonVi']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <div>
                            <label class="typo__label">Cấp học</label>
                            <div>
                                <eselect style="width:100%" :disabled="list_cap_hoc.length==1" multiple collapseTags
                                         v-model="ds_cap_hoc" @change="ChonCapHoc" :placeholder="'Chọn'" filterable
                                         :data="list_cap_hoc" :fields="['name','id']" />
                            </div>
                        </div>
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label class="typo__label">Năm học <span class="red">*</span></label>
                        <eselect style="width:100%" @change="chonNamHoc()" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                 :data="list_nam_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="24" :md="12" :lg="12">
                        <label class="typo__label">Trường học </label>
                        <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags
                                 v-model="ds_truong_hoc" :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                 :fields="['tenTruongHoc','maTruongHoc']" />
                    </el-col>

                    <el-col :sm="12" :md="12" :lg="6">
                        <label class="typo__label">Khối học </label>
                        <eselect style="width:100%" multiple collapseTags v-model="ds_khoi_hoc" @change="chonKhoiHoc"
                                 :placeholder="'Chọn'" filterable :data="list_khoi_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label class="typo__label">Nhóm trẻ mầm non </label>
                        <eselect style="width:100%" collapseTags v-model="maLopMamNon" :placeholder="'Chọn'" filterable
                                 :data="list_ma_lop_mm_non" :fields="['name','value']" />
                    </el-col>

                    <el-col :sm="12" :md="12" :lg="6">
                        <label class="typo__label">Tên lớp học</label>
                        <el-input v-model="ClassName" @change="ClassName = ClassName.trim()"
                                  v-on:keyup.enter="getListClass" type="text" placeholder="Nhập..." clearable />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label class="typo__label">Giáo viên chủ nhiệm</label>
                        <el-input v-model="TeacherName" @change="TeacherName = TeacherName.trim()"
                                  v-on:keyup.enter="getListClass" type="text" placeholder="Nhập..." clearable />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label class="typo__label">Tìm kiếm nâng cao </label>
                        <eselect style="width:100%" multiple collapseTags v-model="danhSachTimKiemNangCao"
                                 :placeholder="'Chọn'" filterable :data="list_tim_kiem_nang_cao"
                                 :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label class="typo__label">Nội dung hiển thị <span style="color:#DC0101">*</span></label>
                        <eselect style="width:100%" multiple collapseTags v-model="danhSachNoiDungHienThi"
                                 @input="chonNoiDungHienThi" :placeholder="'Chọn'" filterable :data="list_noi_dung_hien_thi"
                                 :fields="['name','key']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.lopChuyen">
                        <label>Lớp chuyên</label>
                        <eselect style="width:100%" collapseTags v-model="nangCao.lopChuyen" :placeholder="'Chọn'"
                                 filterable :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.lopBanTru">
                        <label>Lớp bán trú</label>
                        <eselect style="width:100%" collapseTags v-model="nangCao.lopBanTru" :placeholder="'Chọn'"
                                 filterable :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" class="col-md-2" v-if="hienThiNangCao.coHocSinhHocNghe">
                        <label>Lớp có học sinh học nghề</label>
                        <eselect style="width:100%" collapseTags v-model="nangCao.coHocSinhHocNghe" :placeholder="'Chọn'"
                                 filterable :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.lopGhep">
                        <label>Lớp ghép</label>
                        <eselect style="width:100%" collapseTags v-model="nangCao.lopGhep" :placeholder="'Chọn'" filterable
                                 :data="list_co_khong" :fields="['name','value']" />

                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.maLopGhep">
                        <label>Mã lớp ghép</label>
                        <el-input type="text" @change="nangCao.maLopGhep = nangCao.maLopGhep.trim()"
                                  v-model.trim="nangCao.maLopGhep" placeholder="Nhập..." clearable />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.lopVnen">
                        <label>Lớp VNEN</label>
                        <eselect style="width:100%" collapseTags v-model="nangCao.lopVnen" :placeholder="'Chọn'" filterable
                                 :data="list_co_khong" :fields="['name','value']" />

                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.lopCoTreKhuyetTat">
                        <label>Lớp có trẻ khuyết tật</label>
                        <eselect style="width:100%" collapseTags v-model="nangCao.lopCoTreKhuyetTat" :placeholder="'Chọn'"
                                 filterable :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.lopChuyenBiet">
                        <label>Lớp chuyên biệt</label>
                        <eselect style="width:100%" collapseTags v-model="nangCao.lopChuyenBiet" :placeholder="'Chọn'"
                                 filterable :data="list_co_khong" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.soBuoiTrenTuan">
                        <label>Số buổi học/tuần</label>
                        <el-input clearable @change="nangCao.soBuoiTrenTuan" type="text"
                                  v-model.trim="nangCao.soBuoiTrenTuan" placeholder="Nhập..." />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.moetCode">
                        <label>Mã định danh</label>
                        <el-input type="text" clearable @change="nangCao.moetCode = nangCao.moetCode.trim()"
                                  v-model="nangCao.moetCode" placeholder="Nhập..." />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.maNn1">
                        <label>Ngoại ngữ 1</label>
                        <eselect style="width:100%" collapseTags v-model="nangCao.maNn1" :placeholder="'Chọn'" filterable
                                 :data="list_mon_ngoai_ngu" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6" v-if="hienThiNangCao.maNn2">
                        <label>Ngoại ngữ 2</label>
                        <eselect style="width:100%" collapseTags v-model="nangCao.maNn2" :placeholder="'Chọn'" filterable
                                 :data="list_mon_ngoai_ngu" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="24" class='text-center'>
                        <el-button class="bt-chinh" type="success" size="mini" @click.prevent="checkTruocKhiTim()">Tìm kiếm
                        </el-button>
                    </el-col>

                    <!-- </el-row> -->
                    <!-- <el-row :gutter="24"> -->

                </el-row>
            </el-form>

        </div>
        <div ref="scrollToMe"></div>
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <!-- <el-col :span="12" class="">
                    <label class="table-name">Danh sách lớp học</label>
                </el-col>
                <el-col :span="12">
                    <div class="text-right">
                        <span style="padding-right:20px" v-if="lsDelete.length"><b>Đã chọn
                                {{ lsDelete.length }} bản ghi</b></span>
                        <el-tooltip content="Xóa dữ liệu lớp học" placement="top"
                            v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==83||thongtin.ma_so==20||true">
                            <el-button class="bt-xoa" plain v-if="lsDelete.length" :disabled="thongtin.role>4&&false"
                                size="mini" @click.prevent="DeleteClass()" type="danger">Xóa
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Xóa mã định danh" placement="top"
                            v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==20">
                            <el-button class="bt-xoa" plain v-if="lsDelete.length" :disabled="thongtin.role>4&&false"
                                size="mini" @click.prevent="DeleteMoetCode()" type="danger">Xóa mã định danh
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Xuất dữ liệu" placement="top">
                            <el-button class="bt-chinh" type="success" size="mini" :disabled="list_lop_hoc.length==0"
                                @click.prevent="XuatDuLieuLopHoc()">
                                Xuất
                                Excel
                            </el-button>
                        </el-tooltip>
                    </div>
                </el-col> -->
                
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <label class="table-name">Danh sách lớp học</label>
                        <div class="text-right">
                            <span style="padding-right:20px" v-if="lsDelete.length"><b>Đã chọn
                                    {{ lsDelete.length }} bản ghi</b></span>
                            <el-tooltip content="Xóa dữ liệu lớp học" placement="top"
                                v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==83||thongtin.ma_so==20||true">
                                <el-button class="bt-xoa" plain v-if="lsDelete.length" :disabled="thongtin.role>4&&false"
                                    size="mini" @click.prevent="DeleteClass()" type="danger">Xóa
                                </el-button>
                            </el-tooltip>
                            <el-tooltip content="Xóa mã định danh" placement="top"
                                v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==20">
                                <el-button class="bt-xoa" plain v-if="lsDelete.length" :disabled="thongtin.role>4&&false"
                                    size="mini" @click.prevent="DeleteMoetCode()" type="danger">Xóa mã định danh
                                </el-button>
                            </el-tooltip>
                            <el-tooltip content="Xuất dữ liệu" placement="top">
                                <el-button class="bt-chinh" type="success" size="mini" :disabled="list_lop_hoc.length==0"
                                    @click.prevent="XuatDuLieuLopHoc()">
                                    Xuất
                                    Excel
                                </el-button>
                            </el-tooltip>
                        </div>
                    </div>
                </el-col>

                <el-col :span="24">
                    <el-table
                            :data="list_lop_hoc"
                            border
                            empty-text="Không có dữ liệu"
                            max-height="600"
                            style="width: 100%"
                    >
                        <!-- Checkbox Column -->
                        <el-table-column
                                width="40"
                                align="center"
                                fixed="left"
                        >
                            <template #header>
                                <input type="checkbox" v-model="slectAll" @change="chonTatCa">
                            </template>
                            <template #default="{ row }">
                                <input type="checkbox" v-model="lsDelete" :value="row.maLopHoc" />
                            </template>
                        </el-table-column>

                        <!-- Index Column -->
                        <el-table-column
                                label="STT"
                                :width="start > 9999 ? 70 : 60"
                                align="center"
                                fixed="left"
                        >
                            <template #default="scope">
                                <p>{{ (currentPage - 1) * limit + scope.$index + 1 }}</p>
                            </template>
                        </el-table-column>

                        <!-- Actions Column -->
                        <el-table-column
                                label="Thao tác"
                                align="center"
                                width="90"
                                fixed="right"
                        >
                            <template #default="scope">
                                <el-tooltip content="Xem phân công" placement="top">
                                    <i @click.prevent="xemPhanCong(scope.row.maLopHoc,scope.row.tenTruongHoc +' - '+scope.row.tenLopHoc)" class="el-icon-view"></i>
                                </el-tooltip>
                                <el-tooltip content="Sửa" placement="top">
                                    <i @click.prevent="ShowUpdate(scope.row.maLopHoc)" class="el-icon-edit"></i>
                                </el-tooltip>
                            </template>
                        </el-table-column>

                        <!-- Dynamic Columns -->
                        <el-table-column
                                v-for="(col, index) in cotHienThi"
                                :key="index"
                                :fixed="windowWidth > 1200 ? (col.fixed || false) : false"
                                :align="col.align || 'left'"
                                :min-width="columnWidths[col.key]"
                                :label="col.name"
                        >
                            <template #default="scope">
                                <template v-if="col.key === 'maLopHoc' || col.key === 'tenLopHoc'">
                                    <a href="#" @click.prevent="showInFo(scope.row['maLopHoc'])">
                                        {{ scope.row[col.key] }}
                                    </a>
                                </template>
                                <template v-else-if="col.key === 'phanBan'">
                                    <p>{{ getTenPhanBan(scope.row.phanBan) }}</p>
                                </template>
                                <template v-else-if="col.key === 'soBuoiTrenTuan'">
                                    <p v-if="scope.row.soBuoiTrenTuan">{{ scope.row[col.key] }} buổi/tuần</p>
                                </template>
                                <template v-else>
                                    <p>{{ scope.row[col.key] }}</p>
                                </template>
                            </template>
                        </el-table-column>
                    </el-table>

<!--                    <div class="table-responsive">-->
<!--                        <table class="table table-bordered table-striped table-hover">-->
<!--                            <thead>-->
<!--                                <tr style="background:#e4ebf5">-->
<!--                                    <th class="text-center fixed-column fixedCol1">-->
<!--                                        <input type="checkbox" v-model="slectAll" @change="chonTatCa">-->
<!--                                    </th>-->
<!--                                    <th class="text-center fixed-column fixedCol2">-->
<!--                                        <p>STT</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center fixed-column fixedCol3">-->
<!--                                        <p>Thao tác</p>-->
<!--                                    </th>-->
<!--                                    <th v-for="(item,i) in cotHienThi" :key="i">-->
<!--                                        <p>{{ item.name }}</p>-->
<!--                                    </th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody v-if="list_lop_hoc.length==0">-->
<!--                                <tr>-->
<!--                                    <td :colspan="danhSachTimKiem.length+3" class="text-center">-->
<!--                                        <p>Không có bản ghi nào</p>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                            <tbody v-else>-->
<!--                                <tr v-for="(lh,i) in list_lop_hoc" :key="i">-->
<!--                                    <td class="text-center fixed-column fixedCol1">-->
<!--                                        <input type="checkbox" v-model="lsDelete" :value="lh.maLopHoc" />-->
<!--                                    </td>-->
<!--                                    <td class="text-center fixed-column fixedCol2">-->
<!--                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center fixed-column fixedCol3">-->
<!--                                        <el-tooltip content="Xem phân công" placement="top">-->
<!--                                            <i @click.prevent="xemPhanCong(lh.maLopHoc)" class="el-icon-view"></i>-->
<!--                                        </el-tooltip>-->
<!--                                        <el-tooltip content="Sửa" placement="top">-->
<!--                                            <i @click.prevent="ShowUpdate(lh.maLopHoc)" class="el-icon-edit"></i>-->
<!--                                        </el-tooltip>-->

<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maTruongHoc">-->
<!--                                        <p>{{ lh.maTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.tenTruongHoc">-->
<!--                                        <p>{{ lh.tenTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maLopHoc">-->
<!--                                        <a href="#" @click.prevent="showInFo(lh.maLopHoc)">{{ lh.maLopHoc }}</a>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.moetCode">-->
<!--                                        <p>{{ lh.moetCode }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.tenLopHoc">-->
<!--                                        <a href="#" @click.prevent="showInFo(lh.maLopHoc)">{{ lh.tenLopHoc }}</a>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.khoiHoc">-->
<!--                                        <p>{{ lh.khoiHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.tenGiaoVienCn">-->
<!--                                        <p>{{ lh.tenGiaoVienCn }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.buoiHoc">-->
<!--                                        <p>{{ lh.buoiHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maNn1">-->
<!--                                        <p>{{ lh.maNn1 }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maNn2">-->
<!--                                        <p>{{ lh.maNn2 }}</p>-->
<!--                                    </td>-->
<!--                                    &lt;!&ndash; <td v-if="hangHienThi.HeChuyen">-->
<!--                    <p>{{lh.HeChuyen}}</p>-->
<!--                </td> &ndash;&gt;-->
<!--                                    <td v-if="hangHienThi.phanBan">-->
<!--                                        <p>{{ getTenPhanBan(lh.phanBan) }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.lopChuyen">-->
<!--                                        <p>{{ lh.lopChuyen }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.coHocSinhHocNghe">-->
<!--                                        <p>{{ lh.coHocSinhHocNghe }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.lopGhep">-->
<!--                                        <p>{{ lh.lopGhep }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maLopGhep">-->
<!--                                        <p>{{ lh.maLopGhep }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.lopBanTru">-->
<!--                                        <p>{{ lh.lopBanTru }}</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.soBuoiTrenTuan">-->
<!--                                        <p v-if="lh.soBuoiTrenTuan" class="text-center">{{ lh.soBuoiTrenTuan }}-->
<!--                                            buổi/tuần</p>-->
<!--                                    </td>-->
<!--                                    <td v-if="hangHienThi.maDiemTruong">-->
<!--                                        <p>{{ lh.maDiemTruong }}</p>-->
<!--                                    </td>-->
<!--                                    &lt;!&ndash; Hết nội dung hiển thị mặc định &ndash;&gt;-->
<!--                                    &lt;!&ndash;-->
<!--                <td v-if="hangHienThi.lopVnen">-->
<!--                    <p>{{lh.lopVnen}}</p>-->
<!--                </td>-->
<!--                <td v-if="hangHienThi.lopCoTreKhuyetTat">-->
<!--                    <p>{{lh.lopCoTreKhuyetTat}}</p>-->
<!--                </td>-->
<!--                <td v-if="hangHienThi.lopChuyenBiet">-->
<!--                    <p>{{lh.lopChuyenBiet}}</p>-->
<!--                </td> &ndash;&gt;-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
                </el-col>
                <el-col v-show="total_rows" :span="24">
                    <PhanTrang :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                    </PhanTrang>
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
                <div>
                    <XuatExcel :show="show_excel_lop_hoc" @close="show_excel_lop_hoc=false"
                        @submit="submitExcel($event)" :rowsview="limit" :total="total_rows" :limit="10">
                    </XuatExcel>
                    <ChinhSua :show="show_update" :item="dataUpdate" @close="show_update=false" @success="dongSuaHs()">
                    </ChinhSua>
                    <ThongTin :show="showThongTinLopHoc" :item="dataLopHoc" @close="showThongTinLopHoc=false"
                        @close2="dongSuaHs()">
                    </ThongTin>
                </div>
            </el-row>
        </div>
        <el-row :gutter="24">
            <el-col :span="24">
                <el-dialog :title="`Phân công giảng dạy${tenLopPhanCong ? (' - '+ tenLopPhanCong):''}`" :close-on-click-modal="false" :close-on-press-escape="false"
                    :visible.sync="hien_thi_phan_cong" width="90%" top="5vh" :before-close="handleClose">
                    <el-row :gutter="24">
                        <el-col :span='12'>
                            <div class="table-responsive pt-0">
                                <h5>Học kỳ I:</h5>
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr style="background:#e4ebf5">
                                            <th class="text-center">
                                                <p>STT</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Môn học</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Giáo viên giảng dạy</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="thongTinPhanMon.ky1.length==0">
                                        <tr>
                                            <td :colspan="4" class="text-center">
                                                <p>Không có bản ghi nào</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr v-for="(item,i) in thongTinPhanMon.ky1" :key="i">
                                            <td class="text-center">{{ (i + 1) }}
                                            </td>
                                            <td>
                                                <p> {{ item.tenMonHoc }} - [{{ item.maMonHoc }}]</p>
                                            </td>
                                            <td>
                                                <p v-for="(gv,j) in item.phanCongGvInfoList">
                                                    {{ j + 1 }}. {{ gv.tenCanBo }} - [{{ gv.maGiaoVien }}]
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </el-col>
                        <el-col :span='12'>
                            <div class="table-responsive pt-0">
                                <h5>Học kỳ II:</h5>
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr style="background:#e4ebf5">
                                            <th class="text-center">
                                                <p>STT</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Môn học</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Giáo viên giảng dạy</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="thongTinPhanMon.ky2.length==0">
                                        <tr>
                                            <td :colspan="4" class="text-center">
                                                <p>Không có bản ghi nào</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr v-for="(item,i) in thongTinPhanMon.ky2" :key="i">
                                            <td class="text-center">{{ (i + 1) }}
                                            </td>
                                            <td>
                                                <p> {{ item.tenMonHoc }} - [{{ item.maMonHoc }}]</p>
                                            </td>
                                            <td>
                                                <p v-for="(gv,j) in item.phanCongGvInfoList">
                                                    {{ j + 1 }}. {{ gv.tenCanBo }} - [{{ gv.maGiaoVien }}]
                                                </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </el-col>
                    </el-row>
                    <span slot="footer" class="dialog-footer">
                        <el-button class="bt-phu" size="mini" @click="hien_thi_phan_cong = false">Đóng</el-button>
                    </span>
                </el-dialog>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import constant from '../../../utils/constant';
    import ChinhSua from './ChinhSua'
    import ThongTin from './ThongTin'
    import array_util from '../../../utils/array_utils';
    import rest_api from '../../../utils/rest_api';
    import api from '../../api';
    import ESelectVue from '../../ui/ESelect.vue';
    import dialog from '../../../utils/dialog';
    import utils from '../../../utils';
    import PhanTrang from "../../ui/PagingCustom";
    import ChonSoLuong from "../../ui/chonSoLuongBanGhi";
    import XuatExcel from '../../ui/chonSoLuongXuatExcel';
    import ElementUI from 'element-ui';
    import Breadcrumb from './../../ui/Breadcrumb.vue';
    Vue.use(ElementUI);

    export default {
        components: {
            PhanTrang: PhanTrang,
            ChonSoLuong: ChonSoLuong,
            XuatExcel: XuatExcel,
            ThongTin: ThongTin,
            'eselect': ESelectVue,
            ChinhSua: ChinhSua,
            Breadcrumb
        },
        props: ['trangcu'],
        data() {
            return {
                windowWidth: window.innerWidth,
                trangbatdau: true,
                hien_thi_phan_cong: false,
                thongTinPhanMon: {
                    ky1: [],
                    ky2: [],
                },
                fullScreenLoading: false,
                tenLopPhanCong:'',
                show_update: false,
                dataUpdate: "",
                danhSachNoiDungHienThi: [],
                list_noi_dung_hien_thi: [],
                danhSachTimKiemNangCao: [],
                hienThiNangCao: {
                    lopChuyen: false,
                    lopBanTru: false,
                    coHocSinhHocNghe: false,
                    lopGhep: false,
                    maLopGhep: false,
                    lopVnen: false,
                    lopCoTreKhuyetTat: false,
                    lopChuyenBiet: false,
                    soBuoiTrenTuan: false,
                },
                list_tim_kiem_nang_cao: [
                    {
                        value: 'lopChuyen',
                        name: "Lớp chuyên"
                    },
                    {
                        value: 'lopBanTru',
                        name: "Lớp bán trú"
                    },
                    {
                        value: 'coHocSinhHocNghe',
                        name: "Có học sinh học nghề"
                    },
                    {
                        value: 'lopGhep',
                        name: "Lớp ghép"
                    },
                    {
                        value: 'maLopGhep',
                        name: "Mã lớp ghép"
                    },
                    {
                        value: 'lopVnen',
                        name: "Lớp VNEN"
                    },
                    {
                        value: 'lopCoTreKhuyetTat',
                        name: "Lớp có trẻ khuyết tật"
                    },
                    {
                        value: 'lopChuyenBiet',
                        name: "Lớp chuyên biệt"
                    },
                    {
                        value: 'soBuoiTrenTuan',
                        name: "Số buổi học trên tuần"
                    },
                    {
                        value: 'moetCode',
                        name: "Mã định danh"
                    },
                    {
                        value: 'maNn1',
                        name: "Ngoại ngữ 1"
                    },
                    {
                        value: 'maNn2',
                        name: "Ngoại ngữ 2"
                    },
                ],
                nangCao: {
                    lopChuyen: '',
                    lopBanTru: '',
                    coHocSinhHocNghe: '',
                    lopGhep: '',
                    maLopGhep: '',
                    lopVnen: '',
                    lopCoTreKhuyetTat: '',
                    lopChuyenBiet: '',
                    soBuoiTrenTuan: '',
                    moetCode: '',
                    maNn1: '',
                    maNn2: '',
                },
                timKiemNangCao: true,
                cotHienThi: [],
                columnWidths:{},
                hangHienThi: {},
                //chọn tất cả
                list_ma_lop_mm_non: [],
                maLopMamNon: "",
                coLopMamNon: false,
                tenDonViDangNhap: "",
                capHocDangNhap: "",
                chuyenhuong: {},
                thongtin: JSON.parse(window.userInfo),
                list_phan_ban: [],
                date: new Date(),
                slectAll: false,
                lsDelete: [],
                start: 0,
                show_excel_lop_hoc: false,
                start_excel_lop_hoc: 0,
                limit_excel_lop_hoc: 50000,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                soLuongBanGhiHienThi: 25,
                // thông tin
                showThongTinLopHoc: false,
                dataLopHoc: {},
                // phần dùng trong filter
                list_cap_mot: constant.khoiCapMot,
                list_cap_hai: constant.khoiCapHai,
                list_cap_ba: constant.khoiCapBa,
                list_mam_non: constant.khoiMamNon,
                list_nha_tre: constant.khoiNhaTre,
                lop_nha_tre: constant.lopNhaTre,
                lop_mau_giao: constant.lopMauGiao,
                ClassName: "",
                TeacherName: "",
                danhSachDonVi: [],
                list_don_vi: [],
                danhSachNamHoc: [],
                list_gioi_tinh: [{
                        name: "Nam",
                        value: 1
                    },
                    {
                        name: "Nữ",
                        value: 0
                    },
                ],
                list_co_khong: [{
                        name: "Có",
                        value: 1
                    },
                    {
                        name: "Không",
                        value: 0
                    },
                ],
                list_truong_hoc: [],
                danhSachCapHoc: [],
                danhSachTimKiem: [],
                danh_sach_tim_kiem_kqht: [
                    {
                        key: 'tenLopHoc',
                        name: "Tên lớp học",
                        stt: 5,
                        width: 120,
                    },
                    {
                        key: 'maLopHoc',
                        name: "Mã lớp",
                        stt: 3,
                        width: 280,
                    },
                    {
                        key: 'moetCode',
                        name: "Mã định danh",
                        stt: 4,
                        width: 120,
                    },

                    {
                        key: 'khoiHoc',
                        name: "Khối học/Nhóm lớp",
                        stt: 6,
                        width: 170,

                    },
                    {
                        key: 'tenGiaoVienCn',
                        name: "Giáo viên chủ nhiệm",
                        stt: 7,
                        width: 250,
                    },
                    {
                        key: 'buoiHoc',
                        name: "Buổi học",
                        stt: 8
                    },
                    {
                        key: 'maNn1',
                        name: "Học ngoại ngữ 1",
                        stt: 9,
                        width: 150,
                    },
                    {
                        key: 'maNn2',
                        name: "Học ngoại ngữ 2",
                        stt: 10,
                        width: 150,
                    },
                    // {
                    //     key: 'heChuyen',
                    //     name: "Hệ chuyên",
                    //     stt: 11
                    // },
                    {
                        key: 'phanBan',
                        name: "Phân ban",
                        stt: 12,
                        width: 160,
                    },
                    {
                        key: 'lopChuyen',
                        name: "Lớp chuyên",
                        stt: 13,
                        width: 120,
                    },
                    {
                        key: 'coHocSinhHocNghe',
                        name: "Học sinh học nghề",
                        stt: 14,
                        width: 160,
                    },
                    {
                        key: 'lopGhep',
                        name: "Lớp ghép",
                        stt: 15,
                        width: 120,
                    },
                    {
                        key: 'maLopGhep',
                        name: "Ghép vào lớp",
                        stt: 16,
                        width: 120,
                    },
                    {
                        key: 'lopBanTru',
                        name: "Lớp bán trú",
                        stt: 17,
                        width: 120,
                    },
                    {
                        key: 'soBuoiTrenTuan',
                        name: "Số buổi học trên tuần",
                        stt: 18,
                        width: 180,
                    },
                    // {
                    //     key: 'maDiemTruong',
                    //     name: "Điểm trường",
                    //     stt: 19
                    // },
                ],
                danh_sach_tim_kiem_kqht_so: [
                    {
                        key: 'tenTruongHoc',
                        name: "Trường học",
                        stt: 2,
                        width: 250,
                        fixed:'left',
                    },
                    {
                        key: 'maTruongHoc',
                        name: "Mã trường",
                        stt: 1,
                        width: 150,
                        fixed:'left',
                    },
                    {
                        key: 'tenLopHoc',
                        name: "Tên lớp học",
                        stt: 5,
                        width: 120,
                        fixed:'left',
                    },
                    {
                        key: 'maLopHoc',
                        name: "Mã lớp",
                        stt: 3,
                        width: 280,
                    },
                    {
                        key: 'moetCode',
                        name: "Mã định danh",
                        stt: 4,
                        width: 120,
                    },

                    {
                        key: 'khoiHoc',
                        name: "Khối học/Nhóm lớp",
                        stt: 6,
                        width: 170,
                    },
                    {
                        key: 'tenGiaoVienCn',
                        name: "Giáo viên chủ nhiệm",
                        stt: 7,
                        width: 250,
                    },
                    {
                        key: 'buoiHoc',
                        name: "Buổi học",
                        stt: 8
                    },
                    {
                        key: 'maNn1',
                        name: "Học ngoại ngữ 1",
                        stt: 9,
                        width: 150,
                    },
                    {
                        key: 'maNn2',
                        name: "Học ngoại ngữ 2",
                        stt: 10,
                        width: 150,
                    },
                    // {
                    //     key: 'heChuyen',
                    //     name: "Hệ chuyên",
                    //     stt: 11
                    // },
                    {
                        key: 'phanBan',
                        name: "Phân ban",
                        stt: 12,
                        width: 160,
                    },
                    {
                        key: 'lopChuyen',
                        name: "Lớp chuyên",
                        stt: 13,
                        width: 120,
                    },
                    {
                        key: 'coHocSinhHocNghe',
                        name: "Học sinh học nghề",
                        stt: 14,
                        width: 160,
                    },
                    {
                        key: 'lopGhep',
                        name: "Lớp ghép",
                        stt: 15
                    },
                    {
                        key: 'maLopGhep',
                        name: "Ghép vào lớp",
                        stt: 16,
                        width: 120,
                    },
                    {
                        key: 'lopBanTru',
                        name: "Lớp bán trú",
                        stt: 17,
                        width: 120,
                    },
                    {
                        key: 'soBuoiTrenTuan',
                        name: "Số buổi học trên tuần",
                        stt: 18,
                        width: 180,
                    },
                    // {
                    //     key: 'maDiemTruong',
                    //     name: "Điểm trường",
                    //     stt: 19
                    // },
                ],
                danhSachMaTimKiemSo: [
                    "maTruongHoc",
                    "tenTruongHoc",
                    "maLopHoc",
                    "moetCode",
                    "tenLopHoc",
                    "khoiHoc",
                    "tenGiaoVienCn",
                    "buoiHoc",
                    "maNn1",
                    "maNn2",
                    "phanBan",
                    "lopChuyen",
                    "coHocSinhHocNghe",
                    "lopGhep",
                    "maLopGhep",
                    "lopBanTru",
                    "soBuoiTrenTuan",
                ],
                danhSachMaTimKiemTruong: [
                    "maLopHoc",
                    "moetCode",
                    "tenLopHoc",
                    "khoiHoc",
                    "tenGiaoVienCn",
                    "buoiHoc",
                    "maNn1",
                    "maNn2",
                    "phanBan",
                    "lopChuyen",
                    "coHocSinhHocNghe",
                    "lopGhep",
                    "maLopGhep",
                    "lopBanTru",
                    "soBuoiTrenTuan",
                ],
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_khoi_hoc: [],
                ds_truong_hoc: [],
                namHoc: "",
                list_lop_hoc: [],
                list_cap_hoc: window.listCapHoc,
                list_khoi_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_mon_ngoai_ngu: constant.list_mon_ngoai_ngu
            }
        },
        watch: {
            list_lop_hoc:{
                handler() {
                    // Tính toán lại độ rộng khi dữ liệu thay đổi
                    this.calculateColumnWidths();
                },
                immediate: true,
            },
            danhSachTimKiemNangCao: function (newVal) {
                if (2 > 0) {
                    let noidung_hienthi = newVal;
                    this.hienThiNangCao.lopChuyen = false;
                    this.hienThiNangCao.lopBanTru = false;
                    this.hienThiNangCao.coHocSinhHocNghe = false;
                    this.hienThiNangCao.lopGhep = false;
                    this.hienThiNangCao.maLopGhep = false;
                    this.hienThiNangCao.lopVnen = false;
                    this.hienThiNangCao.lopCoTreKhuyetTat = false;
                    this.hienThiNangCao.lopChuyenBiet = false;
                    this.hienThiNangCao.soBuoiTrenTuan = false;
                    this.hienThiNangCao.moetCode = false;
                    this.hienThiNangCao.maNn1 = false;
                    this.hienThiNangCao.maNn2 = false;
                    for (let i = 0; i < noidung_hienthi.length; i++) {
                        if (noidung_hienthi[i] == "lopChuyen") {
                            this.hienThiNangCao.lopChuyen = true
                        }
                        if (noidung_hienthi[i] == "lopBanTru") {
                            this.hienThiNangCao.lopBanTru = true
                        }
                        if (noidung_hienthi[i] == "coHocSinhHocNghe") {
                            this.hienThiNangCao.coHocSinhHocNghe = true
                        }
                        if (noidung_hienthi[i] == "lopGhep") {
                            this.hienThiNangCao.lopGhep = true
                        }
                        if (noidung_hienthi[i] == "maLopGhep") {
                            this.hienThiNangCao.maLopGhep = true
                        }
                        if (noidung_hienthi[i] == "lopVnen") {
                            this.hienThiNangCao.lopVnen = true
                        }
                        if (noidung_hienthi[i] == "lopCoTreKhuyetTat") {
                            this.hienThiNangCao.lopCoTreKhuyetTat = true
                        }
                        if (noidung_hienthi[i] == "lopChuyenBiet") {
                            this.hienThiNangCao.lopChuyenBiet = true
                        }
                        if (noidung_hienthi[i] == "soBuoiTrenTuan") {
                            this.hienThiNangCao.soBuoiTrenTuan = true
                        }
                        if (noidung_hienthi[i] == "moetCode") {
                            this.hienThiNangCao.moetCode = true
                        }
                        if (noidung_hienthi[i] == "maNn1") {
                            this.hienThiNangCao.maNn1 = true
                        }
                        if (noidung_hienthi[i] == "maNn2") {
                            this.hienThiNangCao.maNn2 = true
                        }
                    }
                    console.log(JSON.stringify(this.hienThiNangCao));
                }
            },

            lsDelete: function (newVal) {
                console.log("Danh sách trường học update");
                console.log(newVal)
                if (newVal) {
                    let data = newVal;
                    if (data.length == this.list_lop_hoc.length && data.length > 0) {
                        this.slectAll = true;
                    } else {
                        this.slectAll = false;
                    }
                } else {
                    this.slectAll = false;
                }
            },
        },
        mounted: function () {
            this.updateWidth()
            this.ganDuLieuSME();
            this.thongtin = JSON.parse(window.userInfo);
            this.namHoc = this.thongtin.namHocHienTai;
            this.removeEmptyElement();
            if (this.thongtin.role == 5) {
                this.ds_truong_hoc = [this.thongtin.ma_truong_hoc];
                this.danhSachNoiDungHienThi = this.danhSachMaTimKiemTruong;
                this.list_noi_dung_hien_thi = this.danh_sach_tim_kiem_kqht
                if (this.list_cap_hoc) {
                    let lsch = this.list_cap_hoc.map((obj) => {
                        return obj['id']
                    });
                    this.ds_cap_hoc = lsch;
                } else {
                    this.ds_cap_hoc = [];
                }
                if (this.thongtin.sso && this.thongtin.sso == true) {
                    let obj = {
                        tenTruongHoc: this.thongtin.display_name + ' - [' + this.thongtin.ma_truong_hoc + ']',
                        maTruongHoc: this.thongtin.ma_truong_hoc
                    }
                    this.list_truong_hoc = [obj]
                } else {
                    this.getThongTinTruong();
                }
                // this.bindCapHocDangNhap();
                this.bindKhoiHoc();
            } else {
                this.danhSachNoiDungHienThi = this.danhSachMaTimKiemSo;
                this.list_noi_dung_hien_thi = this.danh_sach_tim_kiem_kqht_so
            }
            this.chonNoiDungHienThi();
            this.bindCotHeader();
            this.ganCot();
            this.getDonVi();
            this.chonKhoiHoc();
            this.calculateColumnWidths();
            if (this.trangcu != '[]') {
                console.log("có dữ liệu trang cũ")
                let trangcu = JSON.parse(this.trangcu)
                this.namHoc = parseInt(trangcu.namHoc);
                this.ds_truong_hoc = [trangcu.maTruongHoc];
                window
                    .history
                    .replaceState("", "CSDL Ngành", "Look-up-classes");
                this.getListClass();
            } else {
                console.log("Không có dữ liệu trang cũ")
            }
            // this.getListClass();
        },
        methods: {
            chonNamHoc(){
                console.log("chọn năm học");
                console.log(this.namHoc);
                this.ds_don_vi = [];
                this.ds_truong_hoc = [];
                this.getTruongHoc();
            },
            updateWidth() {
                this.windowWidth = window.innerWidth;
            },

            calculateColumnWidths() {
                const columnWidths = {};
                this.cotHienThi.forEach((col) => {
                    const field = col.key;

                    // Xử lý nội dung cột
                    const rows = this.list_lop_hoc.map((row) => {
                        // Sử dụng getTenPhanBan nếu field là "phanBan"
                        if (field === "phanBan") {
                            return this.getTenPhanBan(row[field]) || "";
                        }
                        return row[field]?.toString() || ""; // Nội dung mặc định
                    });

                    const header = col.name || ""; // Tiêu đề cột

                    // Tìm nội dung dài nhất
                    const longestContent = [header, ...rows].reduce((a, b) => (a.length > b.length ? a : b), "");

                    // Tính độ rộng cột
                    const charWidth = 10; // Chiều rộng trung bình ký tự (px)
                    const padding = 20; // Padding thêm
                    columnWidths[field] = longestContent.length * charWidth + padding;
                });
                this.columnWidths = columnWidths; // Cập nhật độ rộng
            },

            handleClose() {
                console.log('handleClose')
                this.hien_thi_phan_cong = false;
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
                                tenTruongHoc: response.data.data.tenTruongHoc + ' - [' + this.thongtin
                                    .ma_truong_hoc + ']',
                                maTruongHoc: response.data.data.maTruongHoc
                            }
                            this.list_truong_hoc = [obj]
                        } else {
                            let obj = {
                                tenTruongHoc: this.thongtin.username + ' - [' + this.thongtin
                                    .ma_truong_hoc + ']',
                                maTruongHoc: this.thongtin.ma_truong_hoc
                            }
                            this.list_truong_hoc = [obj]
                        }
                    });
                } catch (e) {

                }
            },
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
            chonTatCa() {
                console.log("Chọn cả:")
                console.log(this.slectAll)
                let danhsach = [];
                if (this.slectAll) {
                    for (let i = 0; i < this.list_lop_hoc.length; i++) {
                        danhsach.push(this.list_lop_hoc[i].maLopHoc);
                    }
                }
                this.lsDelete = danhsach;
            },
            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                this.soLuongBanGhiHienThi = e.soluong;
            },
            XuatDuLieuLopHoc() {
                // if (this.danhSachTimKiem.length == 0) {
                //     this.$alertify.error("Vui lòng chọn nội dung hiển thị.");
                //     return;
                // }
                // if (this.total_rows < 500) {
                //     console.log("Xuat luon khong can check");
                //     this.start_excel_lop_hoc = 0;
                //     this.limit_excel_lop_hoc = 50000;
                //     this.xuatExcel()
                // } else {
                //     this.show_excel_lop_hoc = true;
                // }
                this.start_excel_lop_hoc = 0;
                this.limit_excel_lop_hoc = 50000;
                this.xuatExcel()
            },
            removeEmptyElement() {
                this.list_phan_ban = this.list_phan_ban.filter(item => item.value !== "");
            },
            chonNoiDungHienThi() {
                console.log("NỘi dung hiển thị")
                let danhSachTimKiem = [];
                for (let i = 0; i < this.danhSachNoiDungHienThi.length; i++) {
                    for (let j = 0; j < this.list_noi_dung_hien_thi.length; j++) {
                        if (this.danhSachNoiDungHienThi[i] == this.list_noi_dung_hien_thi[j].key) {
                            danhSachTimKiem.push(this.list_noi_dung_hien_thi[j]);
                        }
                    }
                }
                this.danhSachTimKiem = danhSachTimKiem;
                this.bindCotHeader();
                this.ganCot();
            },
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_phan_ban_sme"];
                if (tmp) {
                    this.list_phan_ban = JSON.parse(localStorage["danh_sach_phan_ban_sme"]);
                }
            },
            getTenPhanBan(e) {
                let res = "";
                for (let i = 0; i < this.list_phan_ban.length; i++) {
                    if (this.list_phan_ban[i].value == e) {
                        res = this.list_phan_ban[i].name
                    }
                }
                return res;
            },
            ShowUpdate(e) {
                this.dataUpdate = e;
                console.log("Hiển thị thông tin lớp học:" + e)
                this.show_update = true;
            },
            xemPhanCong(maLop,tenLop) {
                this.tenLopPhanCong = tenLop??''
                this.fullScreenLoading = true;
                let params = {
                    maLopHoc: maLop
                }
                this.thongTinPhanMon.ky1 = [];
                this.thongTinPhanMon.ky2 = [];
                rest_api.get('/csdlgd-admin/lopMonGiaoVien/byMaLopHoc', params, (response) => {
                    this.fullScreenLoading = false;
                    console.log('response lớp môn giáo viên')
                    console.log(response.data)
                    if (response.data.rc == 0) {
                        this.thongTinPhanMon.ky1 = response.data.ky1 ? response.data.ky1 : [];
                        this.thongTinPhanMon.ky2 = response.data.ky2 ? response.data.ky2 : [];
                        this.hien_thi_phan_cong = true;
                    } else {
                        this.thongBao('error', response.data.rd)
                    }
                });
            },
            dongSuaHs(e) {
                this.show_update = false;
                // this.tuKhoa = e;
                this.checkTruocKhiTim()
            },
            checkTruocKhiTim() {
                this.lsDelete = [];
                this.trangbatdau = !this.trangbatdau;
            },
            // gán các cột hiển thị dữ liệu
            bindCotHeader() {
                this.danhSachTimKiem.sort(this.sapXepMang)
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
            limitTextTieuChi(count) {
                return `và ${count} nội dung khác`
            },
            ChonCapHoc() {
                if (this.thongtin.role == 5) {

                } else {
                    this.list_ma_lop_mm_non = [];
                    this.maLopMamNon = "";
                    this.list_khoi_hoc = []


                    this.params = {};
                    this.ds_truong_hoc = [];
                    this.ds_khoi_hoc = [];
                    this.thongTinTrangCu = [];
                    if (this.thongtin.role != 5) {
                        this.getTruongHoc();
                    }
                }
                this.bindKhoiHoc();
            },
            ChonDonVi() {
                this.params = {};
                this.ds_truong_hoc = [];
                this.thongTinTrangCu = [];
                console.log('Đơn vị:' + this.ds_don_vi)
                this.getTruongHoc();
            },
            boPhanTuTrung(arr) {
                return arr.filter((value, index, arr) => arr.indexOf(value) === index);
            },
            moKhoiHoc() {
                if (this.list_khoi_hoc.length == 0) {

                    this.thongBao("error", "Chọn cấp học để lấy danh sách khối học");
                }
            },
            moNhom() {
                if (this.list_ma_lop_mm_non.length == 0) {
                    if (this.coLopMamNon) {
                        this.thongBao("error", "Chọn khối học để lấy danh sách nhóm trẻ");
                    }
                }
            },
            chonKhoiHoc() {
                console.log("Chọn khối hóc")
                console.log(this.ds_khoi_hoc.length)
                this.coLopMamNon = false;
                this.maLopMamNon = "";
                let list_tmp = [];
                if (this.ds_khoi_hoc.length > 0) {
                    console.log(JSON.stringify(this.ds_khoi_hoc))
                    for (let i = 0; i < this.ds_khoi_hoc.length; i++) {
                        console.log("Danh sách khối học:" + JSON.stringify(this.ds_khoi_hoc[i]))
                        if (this.ds_khoi_hoc[i] == 13) {
                            this.coLopMamNon = true;
                            console.log("Có khối 13")
                            console.log(JSON.stringify(this.lop_nha_tre));
                            for (let a = 0; a < this.lop_nha_tre.length; a++) {
                                list_tmp.push(this.lop_nha_tre[a]);
                            }
                        }
                        if (this.ds_khoi_hoc[i] == 16) {
                            this.coLopMamNon = true;
                            console.log("Có khối 16")
                            for (let b = 0; b < this.lop_mau_giao.length; b++) {
                                list_tmp.push(this.lop_mau_giao[b]);
                            }
                        }
                    }
                    console.log("khối mã:")
                    console.log(JSON.stringify(list_tmp))
                    this.list_ma_lop_mm_non = list_tmp;
                } else {
                    console.log("ahihi")
                    console.log(this.thongtin)
                    if (!this.thongtin.listCapHoc || this.thongtin.listCapHoc == null || this.thongtin.listCapHoc
                        .length == 0) {
                        this.coLopMamNon = true;
                    }
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
            CheckXuatExcel() {
                if (this.thongtin.role2 == 5) {
                    this.ds_truong_hoc = [this.thongtin.ma_truong_hoc]
                }
                if (this.total_rows > 40000) {

                    this.thongBao("error", "Dữ liệu quá lớn. Vui lòng giới hạn dữ liệu tìm kiếm");
                    return;
                } else {
                    this.xuatExcel();
                }
            },

            submitExcel(e) {
                console.log("submitExcel");
                console.log(e)
                if (e.from == 1) {
                    this.start_excel_lop_hoc = 0;
                } else {
                    this.start_excel_lop_hoc = (e.from - 1) * this.limit;
                }
                if (e.to == e.from) {
                    this.limit_excel_lop_hoc = this.limit;
                } else {
                    let chenh_lech = e.to - e.from;
                    this.limit_excel_lop_hoc = (chenh_lech + 1) * this.limit
                }
                console.log(this.start_excel_lop_hoc)
                console.log(this.limit_excel_lop_hoc)
                this.xuatExcel();
            },
            xuatExcel() {
                let url = "xuat-excel-danh-sach-tra-cuu-lop-hoc";
                let prKhoiHoc = JSON.parse(JSON.stringify(this.ds_khoi_hoc));
                let params = {
                    "start": this.start_excel_lop_hoc,
                    "limit": this.limit_excel_lop_hoc,
                    "capHoc": this.ds_cap_hoc,
                    "khoiHoc": prKhoiHoc,
                    "listMaDonViReq": this.ds_don_vi,
                    "listMaTruongHocReq": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "tenGvcn": this.TeacherName,
                    "maNhomLopMn": this.maLopMamNon,
                    "colExcels": this.danhSachTimKiem,
                    "keySearch": this.ClassName
                };
                if (this.thongtin.role == 2 || this.thongtin.role == 3 || this.thongtin.role == 20 || this.thongtin
                    .role == 40) {
                    params.maPhongs = this.ds_don_vi;
                }
                if (this.thongtin.role == 4) {
                    params.maPhongs = [this.thongtin.ma_don_vi];
                }
                if (this.thongtin.role == 5) {
                    params.maTruongHocs = [this.thongtin.ma_truong_hoc];
                    params.capHoc = [];
                }
                console.log("Danh sách khối học gửi đi" + this.ds_khoi_hoc);
                if (params.khoiHoc) {
                    for (let i = 0; i < params.khoiHoc.length; i++) {
                        if (params.khoiHoc[i] == 13) {
                            params.khoiHoc.push(14)
                            params.khoiHoc.push(15)
                        }
                        if (params.khoiHoc[i] == 16) {
                            params.khoiHoc.push(17)
                            params.khoiHoc.push(18)
                        }
                    }
                }
                console.log("Danh sách khối học gửi đi" + this.ds_khoi_hoc);
                let unique = (value, index, self) => {
                    return self.indexOf(value) === index
                }
                params.khoiHoc = params.khoiHoc.filter(unique);
                this.$confirm('Xác nhận tải xuống dữ liệu?',
                        'Thông báo', {
                            confirmButtonText: 'Xác nhận',
                            cancelButtonText: 'Hủy',
                            closeOnClickModal: false,
                        })
                    .then(_ => {
                        this.thongBao('success', 'Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        this.fullScreenLoading = true;
                        api.post(url, params, (data) => {
                            this.fullScreenLoading = false;
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
                    })
                    .catch(_ => {});
            },
            // Chuyển hướng từ trang kết chuyển dữ liệu
            demoFunction() {
                console.log("ở trong này thì thích viết đéo gì chả được");
                console.log("chán bỏ me ra chả muốn làm clg cả");
            },
            chuyenHuong() {
                window
                    .history
                    .replaceState("", "CSDL Ngành", "Look-up-classes");
                if (this.chuyenhuong.namHoc) {
                    this.namHoc = this.chuyenhuong.namHoc;
                }
                if (this.chuyenhuong.maTruongHoc) {
                    this.ds_truong_hoc = this.chuyenhuong.maTruongHoc;
                }
                console.log("11111111111");
            },
            DeleteMoetCode() {
                console.log(this.lsDelete);
                if (this.lsDelete.length > 0) {
                    this.$confirm('Xác nhận xóa mã định danh các bản ghi đã chọn?', 'Xóa mã định danh', {
                            confirmButtonText: 'Xóa',
                            cancelButtonText: 'Hủy',
                            confirmButtonClass: 'el-button--danger',
                            closeOnClickModal: false,
                        })
                        .then(_ => {
                            let params = {
                                loaiDuLieu: 2,
                                lstMaLopHocs: this.lsDelete,
                                namHoc: this.namHoc
                            };
                            this.fullScreenLoading = true;
                            rest_api.post("/csdlgd-admin/DataTruong/deleteMoetCode", params, data => {
                                this.fullScreenLoading = false;
                                if (data.data.rc == 0) {
                                    this.thongBao('success', data.data.rd);
                                    this.getListClass();
                                } else {
                                    this.thongBao("error", data.data.rd);
                                }
                            });
                        })
                        .catch(_ => {});
                } else {
                    this.thongBao("error", "Vui lòng chọn ít nhất 1 lớp học");
                }
            },
            // Xóa lớp học
            DeleteClass() {
                console.log(this.lsDelete);
                if (this.lsDelete.length > 0) {
                    this.$confirm('Xác nhận xóa dữ liệu các bản ghi đã chọn?', 'Xóa dữ liệu', {
                            confirmButtonText: 'Xóa',
                            cancelButtonText: 'Hủy',
                            confirmButtonClass: 'el-button--danger',
                            closeOnClickModal: false,
                        })
                        .then(_ => {
                            let params = {
                                listMa: this.lsDelete,
                                namHoc: this.namHoc
                            };
                            this.fullScreenLoading = true;
                            rest_api.post("/csdlgd-admin/lopHoc/delete", params, data => {

                                this.fullScreenLoading = false;
                                if (data.data.rc == 0) {
                                    this.thongBao("success", data.data.rd);
                                    this.getListClass();
                                } else {
                                    this.thongBao("error", data.data.rd);
                                }
                            });
                        })
                        .catch(_ => {});

                } else {
                    this.thongBao("error", "Vui lòng chọn ít nhất 1 lớp học");
                }
            },
            // Bind khối học
            bindKhoiHoc() {
                console.log(JSON.stringify(this.ds_cap_hoc))
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
                    this.list_khoi_hoc = this.boPhanTuTrung(this.list_khoi_hoc);
                    this.list_khoi_hoc.sort((a, b) => (a.id > b.id) ? 1 : -1)
                }
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc,
                    namHoc: this.namHoc
                };

                // this.fullScreenLoading = true;
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    // this.fullScreenLoading = false;
                    console.log("lấy trường");
                    if (data.data.statusResponse == 0) {
                        let dulieu = data.data.rows;
                        let ldv = [];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenTruongHoc: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                maTruongHoc: dulieu[i].maTruongHoc
                            }
                            ldv.push(obj)
                        }
                        this.list_truong_hoc = ldv;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },
            // Xem thông tin lớp
            showInFo(e) {
                this.showThongTinLopHoc = true;
                this.dataLopHoc = e;
                console.log("xem chi tiết" + this.dataLopHoc);
            },
            // Lấy danh sách đơn vị
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                console.log("pr ẻty" + JSON.stringify(params));
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
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
                        if (this.thongtin.role > 3) {
                            if (this.thongtin.ma_phong && this.thongtin.ma_phong != "") {
                                this.ds_don_vi = [this.thongtin.ma_phong]
                            } else {
                                this.ds_don_vi = [this.thongtin.ma_so];
                            }
                        }
                        if (this.thongtin.role != 5) {
                            this.getTruongHoc();
                        }
                    }
                });
            },
            // gán các cột hiển thị
            ganCot() {
                this.hangHienThi = {};
                this.cotHienThi = this.danhSachTimKiem;
                console.log("cột hiển thị:");
                for (let i = 0; i < this.cotHienThi.length; i++) {
                    if (this.cotHienThi[i].key == "maLopHoc") {
                        this.hangHienThi.maLopHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenLopHoc") {
                        this.hangHienThi.tenLopHoc = true;
                    }
                    if (this.cotHienThi[i].key == "khoiHoc") {
                        this.hangHienThi.khoiHoc = true;
                    }
                    if (this.cotHienThi[i].key == "lopChuyen") {
                        this.hangHienThi.lopChuyen = true;
                    }
                    if (this.cotHienThi[i].key == "lopBanTru") {
                        this.hangHienThi.lopBanTru = true;
                    }
                    if (this.cotHienThi[i].key == "coHocSinhHocNghe") {
                        this.hangHienThi.coHocSinhHocNghe = true;
                    }
                    if (this.cotHienThi[i].key == "lopChuyen") {
                        this.hangHienThi.lopChuyen = true;
                    }
                    if (this.cotHienThi[i].key == "phanBan") {
                        this.hangHienThi.phanBan = true;
                    }
                    if (this.cotHienThi[i].key == "maDiemTruong") {
                        this.hangHienThi.maDiemTruong = true;
                    }
                    if (this.cotHienThi[i].key == "lopGhep") {
                        this.hangHienThi.lopGhep = true;
                    }
                    if (this.cotHienThi[i].key == "maLopGhep") {
                        this.hangHienThi.maLopGhep = true;
                    }
                    if (this.cotHienThi[i].key == "lopVnen") {
                        this.hangHienThi.lopVnen = true;
                    }
                    if (this.cotHienThi[i].key == "lopCoTreKhuyetTat") {
                        this.hangHienThi.lopCoTreKhuyetTat = true;
                    }
                    if (this.cotHienThi[i].key == "lopChuyenBiet") {
                        this.hangHienThi.lopChuyenBiet = true;
                    }
                    if (this.cotHienThi[i].key == "soBuoiTrenTuan") {
                        this.hangHienThi.soBuoiTrenTuan = true;
                    }
                    if (this.cotHienThi[i].key == "buoiHoc") {
                        this.hangHienThi.buoiHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenGiaoVienCn") {
                        this.hangHienThi.tenGiaoVienCn = true;
                    }
                    if (this.cotHienThi[i].key == "maTruongHoc") {
                        this.hangHienThi.maTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenTruongHoc") {
                        this.hangHienThi.tenTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "moetCode") {
                        this.hangHienThi.moetCode = true;
                    }
                    if (this.cotHienThi[i].key == "maNn1") {
                        this.hangHienThi.maNn1 = true;
                    }
                    if (this.cotHienThi[i].key == "maNn2") {
                        this.hangHienThi.maNn2 = true;
                    }
                }
                console.log("Hàng hiển thị:" + JSON.stringify(this.hangHienThi));
            },
            // Lấy danh sách lớp
            getListClass() {
                if (!this.namHoc) {
                    this.thongBao('error', 'Vui bổ sung năm học')
                    return;
                }
                this.slectAll = false;
                this.lsDelete = [];
                this.bindCotHeader();
                this.ganCot();
                let dataSreachList = [];
                if (this.timKiemNangCao) {
                    console.log("Tìm nâng cao ở đây:");
                    console.log(JSON.stringify(this.timKiemNangCao));
                    console.log(JSON.stringify(this.nangCao));
                    if (this.hienThiNangCao.lopChuyen) {
                        if (this.nangCao.lopChuyen) {
                            let obj = {
                                "key": "lopChuyen",
                                "value": parseInt(this.nangCao.lopChuyen),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopBanTru) {
                        if (this.nangCao.lopBanTru) {
                            let obj = {
                                "key": "lopBanTru",
                                "value": parseInt(this.nangCao.lopBanTru),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.coHocSinhHocNghe) {
                        if (this.nangCao.coHocSinhHocNghe) {
                            let demoHN = parseInt(this.nangCao.coHocSinhHocNghe)
                            let obj = {
                                "key": "coHocSinhHocNghe",
                                "value": Boolean(demoHN),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopGhep) {
                        if (this.nangCao.lopGhep) {
                            let obj = {
                                "key": "lopGhep",
                                "value": parseInt(this.nangCao.lopGhep),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maLopGhep) {
                        if (this.nangCao.maLopGhep) {
                            let obj = {
                                "key": "maLopGhep",
                                "value": this.nangCao.maLopGhep,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopVnen) {
                        if (this.nangCao.lopVnen) {
                            let obj = {
                                "key": "lopVnen",
                                "value": parseInt(this.nangCao.lopVnen),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopCoTreKhuyetTat) {
                        if (this.nangCao.lopCoTreKhuyetTat) {
                            let demoKT = parseInt(this.nangCao.lopCoTreKhuyetTat);
                            let obj = {
                                "key": "lopCoTreKhuyetTat",
                                "value": Boolean(demoKT),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.lopChuyenBiet) {
                        if (this.nangCao.lopChuyenBiet) {
                            let demoCB = parseInt(this.nangCao.lopChuyenBiet)
                            let obj = {
                                "key": "lopChuyenBiet",
                                "value": Boolean(demoCB),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.soBuoiTrenTuan) {
                        if (this.nangCao.soBuoiTrenTuan) {
                            let obj = {
                                "key": "soBuoiTrenTuan",
                                "value": parseInt(this.nangCao.soBuoiTrenTuan),
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
                    if (this.hienThiNangCao.maNn1) {
                        if (this.nangCao.maNn1) {
                            let obj = {
                                "key": "maNn1",
                                "value": this.nangCao.maNn1,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maNn2) {
                        if (this.nangCao.maNn2) {
                            let obj = {
                                "key": "maNn2",
                                "value": this.nangCao.maNn2,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                }
                console.log("Lọc nâng cao gồm:");
                console.log(JSON.stringify(dataSreachList));
                let prKhoiHoc = JSON.parse(JSON.stringify(this.ds_khoi_hoc));
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "capHoc": this.ds_cap_hoc,
                    "khoiHoc": prKhoiHoc,
                    "listMaDonViReq": this.ds_don_vi,
                    "listMaTruongHocReq": this.ds_truong_hoc,
                    "namHoc": this.namHoc,
                    "tenGvcn": this.TeacherName,
                    "colExcels": this.danhSachTimKiem,
                    "maNhomLopMn": this.maLopMamNon,
                    "dataSreachList": dataSreachList,
                    "keySearch": this.ClassName
                };
                console.log("Danh sách khối học gửi đi" + this.ds_khoi_hoc);
                if (params.khoiHoc) {
                    console.log("Lớp học gồmL" + params.khoiHoc);
                    for (let i = 0; i < params.khoiHoc.length; i++) {
                        if (params.khoiHoc[i] == 13) {
                            params.khoiHoc.push(14)
                            params.khoiHoc.push(15)
                        }
                        if (params.khoiHoc[i] == 16) {
                            params.khoiHoc.push(17)
                            params.khoiHoc.push(18)
                        }
                    }
                    console.log("Lớp học gồm sau" + params.khoiHoc);
                    console.log("***" + this.ds_khoi_hoc)
                }
                console.log("Danh sách khối học gửi đi" + this.ds_khoi_hoc);
                let unique = (value, index, self) => {
                    return self.indexOf(value) === index
                }
                params.khoiHoc = params.khoiHoc.filter(unique);
                console.log(" lấy lớp" + JSON.stringify(params));
                // if(this.thongtin.role==5){
                //     params.capHoc = [];
                // }
                this.calculateColumnWidths();
                this.fullScreenLoading = true;
                this.total_rows = 0;

                rest_api.post("/csdlgd-admin/lopHoc/search3", params, data => {
                    this.fullScreenLoading = false;
                    this.list_lop_hoc = [];
                    this.total_rows = 0;
                    if (data.data.rc == 0) {
                        this.list_lop_hoc = data.data.tableData;
                        this.total_rows = data.data.totalRows;
                        if (this.total_rows == 0) {
                            // this.thongBao("error", "Không có bản ghi nào được tìm thấy");
                        } else {
                            this.scrollToElement();
                            // this.thongBao("success", "Lấy dữ liệu thành công");
                        }
                    } else {
                        this.thongBao("error", data.data.rd);
                    }
                });
            },
            mapToUpperCase(arr) {
                let result = [];
                if (arr && arr.length > 0) {
                    for (let i = 0; i < arr.length; i++) {
                        result.push(arr[i].toUpperCase())
                    }
                }
                return result
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getListClass()
            },
        }
    }

</script>
<style scoped="scoped">
    .el-dialog__body {
        padding-top: 0
    }

h5{
    margin-top:0
}
</style>

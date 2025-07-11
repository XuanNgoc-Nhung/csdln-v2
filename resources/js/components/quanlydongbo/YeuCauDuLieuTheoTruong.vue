<template>
    <div>
        <Breadcrumb :menu="'Kết chuyển dữ liệu'" :desc="'Kết chuyển dữ liệu lên Bộ'" />
        <div class="card-bieu-do">
            <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                <el-form ref="ruleForm">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <!-- đơn vị -->
                    <el-col :sm="24" :md="12">
                        <label class="typo__label">Đơn vị quản lý</label>
                        <eselect style="width:100%" :disabled="thongtin.role>3" multiple collapseTags
                            v-model="ds_don_vi" :placeholder="'Chọn'" filterable @change="ChonDonVi" :data="list_don_vi"
                            :fields="['tenDonVi','maDonVi']" />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label class="typo__label">Cấp học</label>

                        <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags
                            v-model="ds_cap_hoc" :placeholder="'Chọn'" filterable @change="ChonCapHoc"
                            :data="list_cap_hoc" :fields="['name','id']" />
                        <!-- <div v-if="thongtin.role==5">
                                <input :disabled="thongtin.role == 5" class="form-control" placeholder="Cấp học"
                                    :value="capHocDangNhap" />
                            </div> -->
                    </el-col>
                    <!-- end cấp học -->
                    <!-- Năm học -->
                    <el-col :sm="12" :md="6">
                        <!-- <multiselect v-model="danhSachNamHoc" :options="list_nam_hoc" :custom-label="setNameNamHoc"
                                placeholder="Chọn năm học" label="name" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                                selectedLabel="Đã chọn" track-by="name"></multiselect> -->

                        <label class="typo__label">Năm học <span class="red">*</span></label>
                        <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                 :data="list_nam_hoc" :fields="['name','id']" />
                    </el-col>
                    <!-- Hết năm học -->
                    <!-- Trường học -->
                    <el-col :sm="24" :md="12">

                        <label class="typo__label">Trường học</label>
                        <eselect style="width:100%" multiple collapseTags :disabled="thongtin.role==5"
                            v-model="ds_truong_hoc" :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                            :fields="['tenTruongHoc','maTruongHoc']" />
                        <!-- <div v-if="thongtin.role==5">
                                <label>Trường học</label>
                                <input :disabled="thongtin.role == 5" :value="thongtin.display_name" class="form-control"
                                    placeholder="Nhập..." />
                            </div> -->
                    </el-col>
                    <!-- Hết trường học -->

                    <el-col :sm="12" :md="6">
                        <label>Mã trường bổ sung
                            <el-tooltip effect="dark"
                                content="Nhập danh sách mã trường, các mã trường được ngăn cách với nhau bằng dấu phẩy (,)."
                                placement="top">
                                <a class="helpText"><i class="el-icon-info"></i></a>
                            </el-tooltip>
                        </label>

                        <el-input  @change="maTruongBoSung = maTruongBoSung.trim()"
                            v-model="maTruongBoSung" />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label>Cấp học đẩy dữ liệu
                            <el-tooltip effect="dark"
                                content="Chỉ sử dụng với trường liên cấp: sẽ chỉ đẩy dữ liệu của các cấp học được chọn của trường."
                                placement="top">
                                <a class="helpText"><i class="el-icon-info"></i></a>
                            </el-tooltip>
                        </label>
                        <eselect style="width:100%;" multiple collapseTags v-model="lstCapHoc" :placeholder="'Chọn'"
                            filterable :data="list_cap_hoc" :fields="['name','id']" />
                    </el-col>

                    <el-col :sm="24" :md="12">
                        <label>Thời gian nhận từ QLNT cuối</label>
                        <div>
                            <el-date-picker
                                    style="width: 100%"
                                    v-model="tuNgay"
                                    type="daterange"
                                    align="center"
                                    format="dd/MM/yyyy"
                                    value-format="dd/MM/yyyy"
                                    start-placeholder="Từ ngày"
                                    end-placeholder="Đến ngày">
                            </el-date-picker>
                        </div>
<!--                        <div class="input-group input-daterange">-->

<!--                            <date-picker :lang="lang" class="dts-chonNgay" v-model="tuNgay" placeholder="Chọn"-->
<!--                                valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">-->
<!--                            </date-picker>-->
<!--                            &lt;!&ndash; <date-picker :config="configDatePicker" placeholder="Ngày bắt đầu" @dp-change="ChonNgayBatDau"-->
<!--                                             v-model="tuNgay"></date-picker> &ndash;&gt;-->
<!--                            <div class="input-to">đến</div>-->
<!--                            &lt;!&ndash; <date-picker :config="configDatePicker" placeholder="Ngày kết thúc" v-model="denNgay"></date-picker> &ndash;&gt;-->

<!--                            <date-picker :lang="lang" class="dts-chonNgay" v-model="denNgay" placeholder="Chọn"-->
<!--                                valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">-->
<!--                            </date-picker>-->
<!--                        </div>-->
                    </el-col>

                    <!-- học kỳ -->
                    <el-col :sm="12" :md="6">
                        <label>Học kỳ <span class="red">*</span></label>
                        <eselect style="width:100%" collapseTags v-model="hocKy" @change="ChonHocKy"
                            :placeholder="'Chọn'" filterable :data="list_hoc_ky" :fields="['name','id']" />
                    </el-col>
                    <!-- Hết học kỳ -->
                    <!-- Từ ngày -->

                    <!-- loại đồng bộ -->
                    <el-col :sm="12" :md="6" v-if="loaiDanhSach==2" class="timkiem">
                        <label class="typo__label">Loại đồng bộ</label>
                        <multiselect v-model="danhSachLoaiDongBo" :options="ds_loai_dong_bo_ket_chuyen_du_lieu"
                            :custom-label="setNameByIdValue" placeholder="Chọn loại đồng bộ" label="name"
                            deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                            :preselect-first="true" track-by="name"></multiselect>
                    </el-col>
                    <!-- hết loại đồng bộ -->
                    <!-- Chỉ hiện trường chưa đẩy -->
                    <!-- <div v-if="loaiDanhSach==1" class="col-md-3 timkiem" style="display:flex; align-items:center">
                            <input v-model="truongChuaHoanThanh" type="checkbox" />
                            <span>Trường chưa hoàn thành (<span style="color:#DC0101">**</span>)
                            </span>
                        </div> -->
                    <!-- hết chỉ hiện trường chưa dẩy -->
                    <!-- end filter -->
                    <!-- button -->
                    <el-col :span="24" class="text-center">
                        <el-button class="bt-chinh" plain type="success" size="mini"
                            @click.prevent="checkTruocKhiTim()">Tìm kiếm
                        </el-button>
                    </el-col>
                </el-form>
            </el-row>
        </div>
        <!-- end button -->
        <!-- start danh sách -->
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <el-col v-if='false' :span="12">
                        <label class="table-name">Danh sách trường kết chuyển dữ liệu lên Bộ</label>
                    <!-- <p><b>Ghi chú: </b> NT: Nhà trẻ; MG: Mẫu giáo; TH: Tiểu học; THCS: Trung học Cở sở;
                        THPT: Trung học phổ thông.</p> -->
                </el-col>
                <el-col v-if='false' :span="12" class="text-right">
                    <el-button class="bt-phu" type="success dpull-right" v-if="hienHanhDong&&thongtin.role==125"
                        style="margin:0 0 0 15px;" v-on:click.prevent="showCreatSyncData">
                        Thêm mới lịch đồng bộ
                    </el-button>

                    <el-tooltip content="Xóa dữ liệu" placement="top">
                        <el-button class="bt-xoa"
                            v-if="hienHanhDong&&(truong_duoc_phep||hienthibutton||true)&&CacTruongDay.length"
                            type="danger" size="mini" v-on:click.prevent="xoaDuLieuNhieuTruong">
                            Xóa
                        </el-button>
                    </el-tooltip>
                    <el-tooltip content="Đẩy dữ liệu lên bộ" placement="top">
                        <el-button class="bt-chinh" v-if="hienthibutton&&hienHanhDong&&CacTruongDay.length"
                            type="primary" size="mini" v-on:click.prevent="dayLaiDuLieu2">
                            Đẩy lên Bộ
                        </el-button>
                    </el-tooltip>
                    <el-tooltip content="Xuất dữ liệu " placement="top">
                        <el-button class="bt-chinh" type="primary" size="mini" v-if="hienHanhDong"
                            :disabled="list_truong_hoc_chua_day.length==0" v-on:click.prevent="getDownLoad">
                            Xuất Excel
                        </el-button>
                    </el-tooltip>
                </el-col>
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <label class="table-name">Danh sách trường kết chuyển dữ liệu lên Bộ</label>
                        <div class="text-right">
                            <el-button class="bt-phu" type="success dpull-right" v-if="hienHanhDong&&thongtin.role==125"
                        style="margin:0 0 0 15px;" v-on:click.prevent="showCreatSyncData">
                        Thêm mới lịch đồng bộ
                    </el-button>

                    <el-tooltip content="Xóa dữ liệu" placement="top">
                        <el-button class="bt-xoa"
                            v-if="hienHanhDong&&(truong_duoc_phep||hienthibutton||true)&&CacTruongDay.length"
                            type="danger" size="mini" v-on:click.prevent="xoaDuLieuNhieuTruong">
                            Xóa
                        </el-button>
                    </el-tooltip>
                    <el-tooltip content="Đẩy dữ liệu lên bộ" placement="top">
                        <el-button class="bt-chinh" v-if="hienthibutton&&hienHanhDong&&CacTruongDay.length"
                            type="primary" size="mini" v-on:click.prevent="dayLaiDuLieu2">
                            Đẩy lên Bộ
                        </el-button>
                    </el-tooltip>
                    <el-tooltip content="Xuất dữ liệu " placement="top">
                        <el-button class="bt-chinh" type="primary" size="mini" v-if="hienHanhDong"
                            :disabled="list_truong_hoc_chua_day.length==0" v-on:click.prevent="getDownLoad">
                            Xuất Excel
                        </el-button>
                    </el-tooltip>
                        </div>
                    </div>
                </el-col>


                <el-col :span="24">
                    <el-table
                            max-height="600"
                            :data="list_truong_hoc_chua_day"
                            style="width: 100%"
                            border
                            :header-cell-style="{ background: '#e4ebf5' }"

                            empty-text="Không có bản ghi nào được tìm thấy"
                    >
                        <!-- STT Column -->
                        <el-table-column
                                label="STT"
                                :fixed=" windowWidth > 1200 ? 'left' : false"
                                align="center"
                                :width="start > 9999 ? 70 : 60"
                        >
                            <template #default="scope">
                                {{ (currentPage - 1) * limit + scope.$index + 1 }}
                            </template>
                        </el-table-column>

                        <!-- Trường học -->
                        <el-table-column  :fixed=" windowWidth > 1200 ? 'left' : false" label="Trường học"  :min-width="columnWidths.truongHoc">
                            <template #default="scope">
                                {{ scope.row.tenTruongHoc }} - {{ scope.row.maTruongHoc }}
                            </template>
                        </el-table-column>

                        <!-- Đối tác -->
                        <el-table-column label="Đối tác" align="center" :min-width="150">
                            <template #default="scope">
                                {{ scope.row.maDoiTac }}
                            </template>
                        </el-table-column>

                        <!-- Năm học -->
                        <el-table-column label="Năm học" align="center" width="120">
                            <template #default="scope">
                                {{ scope.row.namHoc }}-{{ scope.row.namHoc + 1 }}
                            </template>
                        </el-table-column>

                        <!-- Ngày nhận -->
                        <el-table-column label="Ngày nhận" align="center" width="120">
                            <template #default="scope">
                                {{ scope.row.ngayNopTuQlntCuoi }}
                            </template>
                        </el-table-column>

                        <!-- Trường duyệt -->
                        <el-table-column label="Trường duyệt" align="center" width="120">
                            <template #default="scope">
                                {{ scope.row.ngayTruongDuyet }}
                            </template>
                        </el-table-column>

                        <!-- Sở/Phòng duyệt -->
                        <el-table-column
                                :label="ds_cap_hoc.toString() === [3, 6].toString() || ds_cap_hoc.toString() === [6, 3].toString() || ds_cap_hoc.toString() === [3].toString() || ds_cap_hoc.toString() === [6].toString() ? 'Sở duyệt' : 'Phòng duyệt'"
                                align="center"
                                width="120"
                        >
                            <template #default="scope">
                                {{ scope.row.ngayPhongDuyet }}
                            </template>
                        </el-table-column>

                        <!-- Dữ liệu đã nộp -->
                        <el-table-column label="Dữ liệu đã nộp" header-align="center">
                            <el-table-column label="Cán bộ" align="center" width="100">
                                <template #default="scope">
                                    <a href="#" @click.prevent="ChuyenHuongCanBo(scope.row)">
                                        <span v-html="scope.row.countGvStr"></span>
                                    </a>
                                </template>
                            </el-table-column>

                            <el-table-column label="Học sinh" align="center" width="100">
                                <template #default="scope">
                                    <a href="#" @click.prevent="ChuyenHuongHocSinh(scope.row)">
                                        <span v-html="scope.row.countHsStr"></span>
                                    </a>
                                </template>
                            </el-table-column>

                            <el-table-column label="Lớp học" align="center" width="100">
                                <template #default="scope">
                                    <a href="#" @click.prevent="ChuyenHuongLopHoc(scope.row)">
                                        <span v-html="scope.row.countLhStr"></span>
                                    </a>
                                </template>
                            </el-table-column>

                            <el-table-column label="KQ giữa kỳ" align="center" width="120">
                                <template #default="scope">
                                    <a href="#" @click.prevent="ChuyenHuongKqht(scope.row)">
                                        <span v-html="scope.row.countKqGiuaKy"></span>
                                    </a>
                                </template>
                            </el-table-column>

                            <el-table-column label="KQ cuối kỳ" align="center" width="120">
                                <template #default="scope">
                                    <a href="#" @click.prevent="ChuyenHuongKqht(scope.row)">
                                        <span v-html="scope.row.ketQuaLienCap"></span>
                                    </a>
                                </template>
                            </el-table-column>
                        </el-table-column>

                        <!-- Chọn loại dữ liệu -->
                        <el-table-column
                                label="Chọn loại dữ liệu"
                                v-if="hienHanhDong && (hienthibutton || truong_duoc_phep || true)"

                                width="320"
                        >
                            <template #header>
                                <div style="width:100%">

                                    <div style="margin-bottom: 8px">Loại dữ liệu</div>
                                    <eselect style="width:100%" multiple collapseTags
                                             v-model="danhSachChonDongBo" @change="chonDuLieuDay"
                                             :placeholder="'Chọn'" filterable :data="list_dong_bo_du_lieu"
                                             :fields="['name','key']" />
                                </div>
                            </template>
                            <template #default="scope">
                                <el-select
                                        v-model="scope.row.key"
                                        multiple
                                        filterable
                                        collapse-tags
                                        placeholder="Chọn"
                                        @change="chonDuLieuDay"
                                >
                                    <el-option
                                            v-for="item in scope.row.thongTinBuocDays"
                                            :key="item.key"
                                            :label="item.name"
                                            :value="item.key"
                                    />
                                </el-select>
                            </template>
                        </el-table-column>

                        <!-- Thao tác -->
                        <el-table-column label="Thao tác" align="center" width="120" fixed="right">
                            <template #default="scope">

                                <el-tooltip content="Duyệt" placement="top">
                                    <i @click.prevent="DuyetLenCapTren(scope.row)" class="el-icon-check"></i>
                                </el-tooltip>
                                <el-tooltip content="Từ chối" placement="top">
                                    <i @click.prevent="tuChoiPhong(scope.row)" class="el-icon-close"></i>
                                </el-tooltip>
                            </template>
                        </el-table-column>
                    </el-table>

<!--                    <div class="table-responsive">-->
<!--                        <table class="table table-bordered table-striped table-hover bieudo-pxn"-->
<!--                            style="width:max-content;max-width:max-content;min-width:100%">-->
<!--                            <thead style="background: #e4ebf5">-->
<!--                                <tr>-->
<!--                                    <th rowspan="2" class="fixed-column fixed-col1">-->
<!--                                        <p>STT</p>-->
<!--                                    </th>-->

<!--                                    <th rowspan="2">-->
<!--                                        <p>Trường học</p>-->
<!--                                    </th>-->
<!--                                    <th rowspan="2">-->
<!--                                        <p>Đối tác</p>-->
<!--                                    </th>-->
<!--                                    <th rowspan="2" class="text-center">-->
<!--                                        <p>Năm học</p>-->
<!--                                    </th>-->
<!--                                    <th rowspan="2" class="text-center">-->
<!--                                        <p>Ngày nhận</p>-->
<!--                                    </th>-->
<!--                                    <th rowspan="2" class="text-center">-->
<!--                                        <p>Trường duyệt</p>-->
<!--                                    </th>-->
<!--                                    <th rowspan="2" class="text-center">-->
<!--                                        <p>-->
<!--                                            {{-->
<!--                                        ds_cap_hoc.toString() == [3, 6].toString() || ds_cap_hoc.toString() == [6, 3].toString() || ds_cap_hoc.toString() == [3].toString() || ds_cap_hoc.toString() == [6].toString() ? 'Sở' : 'Phòng'-->
<!--                                    }}-->
<!--                                            duyệt</p>-->
<!--                                    </th>-->
<!--                                    <th colspan="5" class="text-center">-->
<!--                                        <p>Dữ liệu đã nộp</p>-->
<!--                                    </th>-->
<!--                                    <th v-if="hienHanhDong&&(hienthibutton||truong_duoc_phep||true)"-->
<!--                                        rowspan="2">-->
<!--                                        <div>Chọn loại dữ liệu</div>-->
<!--                                        <div style="width:100%">-->


<!--                                            <eselect style="width:100%" multiple collapseTags-->
<!--                                                v-model="danhSachChonDongBo" @change="chonDuLieuDay"-->
<!--                                                :placeholder="'Chọn'" filterable :data="list_dong_bo_du_lieu"-->
<!--                                                :fields="['name','key']" />-->
<!--                                        </div>-->
<!--                                    </th>-->
<!--                                    <th rowspan="2" class="text-center">-->
<!--                                        <p>Thao tác</p>-->
<!--                                    </th>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <th class="text-center">-->
<!--                                        <p>Cán bộ</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center">-->
<!--                                        <p>Học sinh</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center">-->
<!--                                        <p>Lớp học</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center">-->
<!--                                        <p>KQ giữa kỳ</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center">-->
<!--                                        <p>KQ cuối kỳ</p>-->
<!--                                    </th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody v-if="list_truong_hoc_chua_day.length==0">-->
<!--                                <tr>-->
<!--                                    <td class="text-center" colspan="14">-->
<!--                                        <p>Không có bản ghi nào được tìm thấy</p>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                            <tbody v-else>-->
<!--                                <tr v-for="(yc,index) in list_truong_hoc_chua_day" :key="index">-->
<!--                                    <td class="text-center fixed-column fixed-col1">-->
<!--                                        <p>{{ (currentPage - 1) * limit + index + 1 }}</p>-->
<!--                                    </td>-->

<!--                                    <td>-->
<!--                                        <p>{{ yc.tenTruongHoc }}-->
<!--                                            - -->
<!--                                            {{ yc.maTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ yc.maDoiTac }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <p>{{ yc.namHoc }}-{{ yc.namHoc + 1 }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <p>{{ yc.ngayNopTuQlntCuoi }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <p>{{ yc.ngayTruongDuyet }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <p>{{ yc.ngayPhongDuyet }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <a href="#" title="Xem chi tiết" @click.prevent="ChuyenHuongCanBo(yc)">-->
<!--                                            <p v-html="yc.countGvStr"></p>-->
<!--                                        </a>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <a href="#" title="Xem chi tiết"-->
<!--                                            @click.prevent="ChuyenHuongHocSinh(yc)">-->
<!--                                            <p v-html="yc.countHsStr"></p>-->
<!--                                        </a>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <a href="#" title="Xem chi tiết" @click.prevent="ChuyenHuongLopHoc(yc)">-->
<!--                                            <p v-html="yc.countLhStr"></p>-->
<!--                                        </a>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <a href="#" title="Xem chi tiết" @click.prevent="ChuyenHuongKqht(yc)">-->
<!--                                            <p v-html="yc.countKqGiuaKy"></p>-->
<!--                                        </a>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <a href="#" title="Xem chi tiết" @click.prevent="ChuyenHuongKqht(yc)">-->
<!--                                            <p v-html="yc.ketQuaLienCap"></p>-->
<!--                                        </a>-->
<!--                                    </td>-->
<!--                                    <td v-if="hienHanhDong&&(hienthibutton||truong_duoc_phep||true)">-->
<!--                                        <div>-->
<!--                                            &lt;!&ndash; Thay đổi &ndash;&gt;-->
<!--                                            &lt;!&ndash; <el-select clearable v-model="yc.key" multiple filterable collapse-tags-->
<!--                                        placeholder="Chọn loại dữ liệu" no-data-text="Không có dữ liệu"-->
<!--                                        @change="chonDuLieuDay" no-match-text="Không có dữ liệu phù hợp">-->
<!--                                        <el-option v-for="item in yc.thongTinBuocDays" :key="item.key"-->
<!--                                            :label="item.name" :value="item.key">-->
<!--                                        </el-option>-->
<!--                                    </el-select>-->
<!--                                     &ndash;&gt;-->
<!--                                            <eselect style="width:100%" multiple collapseTags v-model="yc.key"-->
<!--                                                @change="chonDuLieuDay" :placeholder="'Chọn'" filterable-->
<!--                                                :data="yc.thongTinBuocDays" :fields="['name','key']" />-->
<!--                                            &lt;!&ndash; Hết thay đổi &ndash;&gt;-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                    &lt;!&ndash; <td> <p>{{getTrangThai(yc.status)}}</p> </!&ndash;&gt;-->
<!--                                    <td class="text-center">-->
<!--                                        <div v-if="hienHanhDong">-->
<!--                                            <el-tooltip v-if="false" content="Kiểm tra dữ liệu" placement="top">-->
<!--                                                &lt;!&ndash; <el-button size="mini" type="info"> &ndash;&gt;-->
<!--                                                <i @click.prevent="ChuyenHuong(yc)" class="el-icon-eleme"></i>-->
<!--                                                &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                            </el-tooltip>-->
<!--                                            <el-tooltip v-if="false" content="Xem lịch sử " placement="top">-->
<!--                                                &lt;!&ndash; <el-button type="info"  size="mini"> &ndash;&gt;-->
<!--                                                <i class="el-icon-notebook-2"-->
<!--                                                   @click.prevent="XemLichSu(yc)"></i>-->
<!--                                                &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                            </el-tooltip>-->
<!--                                            <el-tooltip v-if="thongtin.role==5||true" content="Duyệt"-->
<!--                                                        placement="top">-->
<!--                                                &lt;!&ndash; <el-button type="primary"-->
<!--                                            size="mini"></el-button> &ndash;&gt;-->
<!--                                                <i @click.prevent="DuyetLenCapTren(yc)"-->
<!--                                                   class="el-icon-check"></i>-->
<!--                                            </el-tooltip>-->
<!--                                            <el-tooltip-->
<!--                                                    v-if="thongtin.role==4||(thongtin.ma_so==36&&thongtin.role==2)"-->
<!--                                                    content="Duyệt" placement="top">-->
<!--                                                &lt;!&ndash; <el-button type="primary" @click.prevent="DuyetLenCapTrenPhong(yc)"-->
<!--                                            size="mini"></el-button> &ndash;&gt;-->
<!--                                                <i @click.prevent="DuyetLenCapTrenPhong(yc)"-->
<!--                                                   class="el-icon-check"></i>-->
<!--                                            </el-tooltip>-->
<!--                                            <el-tooltip v-if="thongtin.role==4" content="Từ chối"-->
<!--                                                        placement="top">-->
<!--                                                &lt;!&ndash; <el-button type="danger"-->
<!--                                            size="mini"> &ndash;&gt;-->
<!--                                                <i @click.prevent="tuChoiPhong(yc)" class="el-icon-close"></i>-->
<!--                                                &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                            </el-tooltip>-->
<!--                                            <el-tooltip v-if="thongtin.role==2||thongtin.role==3"-->
<!--                                                        content="Từ chối" placement="top">-->
<!--                                                <i @click.prevent="tuChoiSo(yc)" class="el-icon-close"></i>-->
<!--                                                &lt;!&ndash; <el-button type="danger" @click.prevent="tuChoiSo(yc)" size="mini">-->
<!--                                            <i class="el-icon-remove"></i></el-button> &ndash;&gt;-->
<!--                                            </el-tooltip>-->
<!--                                            <el-tooltip v-if="2==3" content="Xóa" placement="top">-->
<!--                                                <el-button type="danger" @click.prevent="ConFirmDelete(yc)"-->
<!--                                                           size="mini">-->
<!--                                                    <i class="el-icon-s-promotion"></i></el-button>-->
<!--                                            </el-tooltip>-->
<!--                                        </div>-->
<!--                                    </td>-->

<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
                </el-col>
                <el-col :span="24">
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                </el-col>
            </el-row>
        </div>
        <!-- Nhúng component -->
        <template v-if="show_create">
            <ThemMoiYeuCau :show="show_create" @close="show_create=false" @success="getData"></ThemMoiYeuCau>
        </template>
        <!-- hết nhúng -->
        <!-- component đẩy dữ liệu -->
        <DayLaiDuLieu :show="show_daylai" :cap_hoc_day="lstCapHoc" :item="CacTruongDay" :namhoc="namHoc"
            :hocky="hocKyDayDuLieu" @dongmodal="show_daylai=false" @successDay="DayXong"></DayLaiDuLieu>
        <!-- hết component đẩy dữ liệu -->
        <!-- component đẩy dữ liệu -->
        <XoaDuLieu :show="show_xoanhieutruong" :item="CacTruongDay" :namhoc="namHoc" :hocky="hocKyDayDuLieu"
            @dongmodal="show_xoanhieutruong=false" @successDay="DayXong"></XoaDuLieu>
        <!-- hết component đẩy dữ liệu -->
        <!-- end danh sách -->
        <!-- end button -->
        <!-- end template -->
    </div>
</template>
<script>
    // import datePicker from 'vue-bootstrap-datetimepicker';
    import DatePicker from 'vue2-datepicker';
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import constant from "../../utils/constant";
    import api from './../api';
    import DayLaiDuLieu from './DayLaiDuLieu'
    import moment from "moment";
    import TruongChuaDayDuLieu from './TruongChuaDayDuLieu';
    import XoaDuLieu from './xoaDuLieuNhieuTruong';
    import utils from '../../utils'
    import ThemMoi from './ThemYeuCauDongBoDuLieuTheoTruong';
    import Page from "../ui/PagingCustom";
    import ESelectVue from '../ui/ESelect.vue';
    import VueAlertify from "vue-alertify";
    import ElementUI from 'element-ui';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/vi';
    import Breadcrumb from '../ui/Breadcrumb.vue';

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
        components: {
            Multiselect,
            "DayLaiDuLieu": DayLaiDuLieu,
            "XoaDuLieu": XoaDuLieu,
            Page,
            DatePicker,
            'eselect': ESelectVue,
            "TruongChuaDayDuLieu": TruongChuaDayDuLieu,
            "ThemMoiYeuCau": ThemMoi,
            Breadcrumb
        },
        watch: {
            // danhSachNamHoc: function (newVal) {
            //     console.log("watch Năm học");
            //     this.namHoc = "";
            //     if (newVal) {
            //         this.namHoc = newVal
            //             .id
            //         console
            //             .log("map xong:" + JSON.stringify(this.namHoc));
            //     }
            // },
            danhSachLoaiDongBo: function (newVal) {
                this.ds_loai_dong_bo = "";
                if (newVal) {
                    this.ds_loai_dong_bo = newVal.id
                }
            },
            danhSachTrangThai: function (newVal) {
                console.log("watch trạng thái");
                this.ds_trang_thai = "";
                if (newVal) {
                    this.ds_trang_thai = newVal.id
                }
            },
            danhSachChonDongBo: function (newVal) {
                console.log("watch:" + JSON.stringify(newVal));
                if (newVal) {
                    // danh sách yêu cầu được chọn
                    let ds_key = newVal;
                    // var list_key_duoc_chon = ds_key.map(function (item) {
                    //     return item['key'];
                    // });
                    var list_key_duoc_chon = newVal;
                    console.log("key được chọn:" + JSON.stringify(list_key_duoc_chon));
                    this
                        .list_truong_hoc_chua_day
                        .map((yeuCau) => {
                            let buocDay = yeuCau
                                .thongTinBuocDays
                                .map((obj) => obj.key);
                            let existKey = [];
                            buocDay.map((obj) => {
                                if (list_key_duoc_chon.includes(obj)) {
                                    existKey.push(obj);
                                }
                            });
                            yeuCau.key = existKey;
                            console.log("các key" + JSON.stringify(existKey));
                        });
                    console.log("sau khi map");
                    // find lại data
                    this.reBindData();
                }
            }
        },
        data() {
            return {
                windowWidth: window.innerWidth,
                columnWidths: {
                    truongHoc: 200, // Giá trị mặc định hoặc từ API
                    maDoiTac: 150,
                    chonLoaiDuLieu: 200,
                },
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false,
                },
                // custom lại để chọn tất cả
                lstCapHoc: [],
                capHocDangNhap: "",
                loaiDanhSach: 1,
                // Ngày thàng
                tuNgay: "",
                denNgay: "",
                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                // Phần chọn đổng bộ
                list_dong_bo_du_lieu_hk1: constant.list_dong_bo_du_lieu_hk1,
                list_dong_bo_du_lieu_hk2: constant.list_dong_bo_du_lieu_hk2,
                list_dong_bo_du_lieu_cn: constant.list_dong_bo_du_lieu_cn,
                list_dong_bo_du_lieu: constant.list_dong_bo_du_lieu_hk1,
                danhSachChonDongBo: [],
                dsTruongDay: [],
                CacTruongDay: [],
                tenDonViDangNhap: "",
                hocKyDayDuLieu: "",
                show_xoanhieutruong: false,
                show_daylai: false,
                // THêm mới lịch đồng bộ
                show_create: false,
                // thông tin trường chưa đẩy
                thongTinTruongChuaDay: {},
                start2: 0,
                laTruong: 0,
                limit2: 25,
                currentPage2: 1,
                // dùng chung
                truong_duoc_phep: false,
                truongChuaHoanThanh: false,
                thongtin: {},
                date: new Date(),
                hienHanhDong: true,
                list_truong_hoc_chua_day: [],
                total_rows: 0,
                start: 0,
                currentPage: 1,
                limit: 25,
                pr: "",
                namHoc: "",
                // dùng trong filter
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_truong_hoc: [],
                // ds_trang_thai: [],
                ds_loai_dong_bo: [],
                list_don_vi: [],
                // list_cap_hoc: constant.LIST_CAP_HOC_KHONG_LIEN,
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_hoc_ky: constant.LIST_HOC_KY,
                ds_loai_dong_bo_ket_chuyen_du_lieu: constant.ds_loai_dong_bo_ket_chuyen_du_lieu,
                ds_trang_thai_ket_chuyen_du_lieu: constant.ds_trang_thai_ket_chuyen_du_lieu,
                list_truong_hoc: [],
                danhSachNamHoc: [],
                danhSachLoaiDongBo: [],
                danhSachTrangThai: [],
                maTruongHoc: "",
                hienthibutton: false,
                trangbatdau: true,
                hocKy: 1,
                maTruongBoSung: "",
                lstMaTruongBoSung: [],
            }
        },
        props: [],
        mounted() {
            this.updateWidth()

            this.thongtin = JSON.parse(window.userInfo);
            if (this.thongtin.role == 5) {
                this.ds_cap_hoc = this.thongtin.listCapHoc;
                this.ds_truong_hoc = [this.thongtin.ma_truong_hoc.toUpperCase()]
            }
            if (this.thongtin.role > 3) {
                this.ds_don_vi = [this.thongtin.ma_don_vi]
            }
            if (this.thongtin.username == 'ad_namdinh_vnpt') {
                this.hienHanhDong = false;
            }
            this.checkQuyenDay();
            this.checkQuyenDayDL();
            if (this.thongtin.role == 5) {
                this.bindCapHocDangNhap();
            }
            console.log("thông tin đăng nhập:" + JSON.stringify(this.thongtin));
            // lấy năm hiện tại
            this.namHoc = this.thongtin.namHocHienTai;
            console.log(this.namHoc);
            if (this.thongtin.role == 5) {
                this.maTruongHoc = this.thongtin.ma_truong_hoc
            }
            this.getDonVi(() => {
                console.log("Check 222222222222");
            });

            this.getTruongHoc();
            // setTimeout(() => {
            //     this.checkBeforeSearch();
            // }, 100);
        },
        methods: {
            updateWidth() {
                this.windowWidth = window.innerWidth;
            },

            updateColumnWidths(){
                console.log('updateColumnWidths')

                this.columnWidths = {


                    truongHoc: this.calculateWidth('truongHoc'),
                    maDoiTac: this.calculateWidth('maDoiTac'),

                };
            },
            // Hàm tính toán độ rộng cột dựa trên nội dung
            calculateWidth(columnKey) {
                const getDisplayValueLength = (value, columnKey) => {
                    return (value || '').toString().length;
                };

                const maxContentLength = this.list_truong_hoc_chua_day.reduce((max, row) => {
                    const value = row[columnKey];
                    if (columnKey === 'truongHoc') {
                        let str = (row['tenTruongHoc'] + ' - ' + row['maTruongHoc']).toString().length
                        return Math.max(max, str);
                    }
                    return Math.max(max, getDisplayValueLength(value, columnKey));
                }, 0);

                return Math.max(100, maxContentLength * 10); // Mỗi ký tự chiếm 10px, tối thiểu 100px
            },
            chonDuLieuDay() {
                let truongCanDayRequests = this
                    .list_truong_hoc_chua_day
                    .map((obj) => {
                        return {
                            maTruong: obj.maTruongHoc,
                            buocDays: obj.key,
                            capTruong: obj.capTruong,
                            tenTruong: obj.tenTruongHoc
                        }
                    });
                this.truongCanDayRequests = JSON.parse(JSON.stringify(truongCanDayRequests));
                console.log('Chọn dữ liệu đẩy');
                this.dsTruongDay = [];
                for (let b = 0; b < this.truongCanDayRequests.length; b++) {
                    if (this.truongCanDayRequests[b].buocDays.length > 0) {
                        console.log("123" + JSON.stringify(this.truongCanDayRequests[b]));
                        this
                            .dsTruongDay
                            .push(this.truongCanDayRequests[b])
                    }
                }
                this.CacTruongDay = this.dsTruongDay;
            },
            ChonHocKy() {
                this.danhSachChonDongBo = [];
                this.list_dong_bo_du_lieu = [];
                if (this.hocKy == 1) {
                    this.list_dong_bo_du_lieu = this.list_dong_bo_du_lieu_hk1
                }
                if (this.hocKy == 2) {
                    this.list_dong_bo_du_lieu = this.list_dong_bo_du_lieu_hk2
                }
                if (this.hocKy == 3) {
                    this.list_dong_bo_du_lieu = this.list_dong_bo_du_lieu_cn
                }
            },
            checkQuyenDayDL() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-admin/duyetDayDuLieu/checkDayDuLieu", {}, (data) => {
                    loading.close();
                    this.hienthibutton = data.data.item;
                });
            },
            DuyetLenCapTren(e) {
                console.log("click duyệt lên cấp trên");
                console.log(JSON.stringify(e));
                let url = "/csdlgd-admin/duyetDay/updateDuyetDdl?statusAction=4&idUpdate=" + e.id;
                this.$confirm(
                        "Xác nhận duyệt lên cấp trên: " + e.tenTruongHoc + ". (Mã: " + e.maTruongHoc +
                        ")?",
                        'Duyệt trường học', {
                            confirmButtonText: 'Duyệt',
                            cancelButtonText: 'Đóng',
                            closeOnClickModal: false,
                        })
                    .then(_ => {
                        const params = {};
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post(url, params, (data) => {
                            loading.close();
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                // this
                                //     .$alertify
                                //     .success("Duyệt thành công");

                                this.thongBao('success', data.data.rd)
                                this.getData();
                            } else {
                                this.thongBao('error', data.data.rd)
                                // return;
                            }
                        });
                    })
                    .catch(_ => {});


                // utils.confirmDialog(
                //     "Xác nhận duyệt lên cấp trên: " + e.tenTruongHoc + ". (Mã: " + e.maTruongHoc +
                //     ")?",
                //     "Duyệt",
                //     () => {
                //         const params = {};
                //         const loading = this.$loading({
                //             lock: true,
                //             text: 'Loading',
                //             spinner: 'el-icon-loading',
                //             background: 'rgba(0, 0, 0, 0.7)'
                //         });
                //         rest_api.post(url, params, (data) => {
                //             loading.close();
                //             console.log(JSON.stringify(data));
                //             if (data.data.rc == 0) {
                //                 this
                //                     .$alertify
                //                     .success("Duyệt thành công");
                //                 this.getData();
                //             } else {
                //                 this.thongBao('error', data.data.rd)
                //                 // return;
                //             }
                //         });
                //     }
                // )
            },
            DuyetLenCapTrenPhong(e) {
                let url = "/csdlgd-admin/duyetDay/updateDuyetDdl?statusAction=1&idUpdate=" + e.id;
                this.$confirm(
                        "Xác nhận duyệt lên cấp trên: " + e.tenTruongHoc + ". (Mã: " + e.maTruongHoc +
                        ")?",
                        'Duyệt trường hoc', {
                            confirmButtonText: 'Duyệt',
                            cancelButtonText: 'Đóng',
                            closeOnClickModal: false,
                        })
                    .then(_ => {
                        const params = {};
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post(url, params, (data) => {
                            loading.close();
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                // this
                                //     .$alertify
                                //     .success("Duyệt thành công");

                                this.thongBao('success', data.data.rd)
                                this.getData();
                            } else {
                                this.thongBao('error', data.data.rd)
                                // return;
                            }
                        });
                    })
                    .catch(_ => {});


                // utils.confirmDialog(
                //     "Xác nhận duyệt lên cấp trên: " + e.tenTruongHoc + ". (Mã: " + e.maTruongHoc +
                //     ")?",
                //     "Duyệt",
                //     () => {
                //     }
                // )
            },
            tuChoi(e) {
                console.log("click duyệt lên cấp trên");
                console.log(JSON.stringify(e));
                let url = "/csdlgd-admin/duyetDay/updateDuyetDdl?statusAction=-4&idUpdate=" + e.id;
                let msg = "Xác nhận từ chối duyệt: " + e.tenTruongHoc + ". (Mã: " + e.maTruongHoc +
                    ")?"
                this.$confirm(msg, 'Từ chối duyệt trường học', {
                        confirmButtonText: 'Từ chối',
                        cancelButtonText: 'Đóng',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const params = {};
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post(url, params, (data) => {
                            loading.close();
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.thongBao('success', data.data.rd)
                                this.getData();
                            } else {
                                this.thongBao('error', data.data.rd)
                                // return;
                            }
                        });
                    })
                    .catch(_ => {});
            },
            tuChoiPhong(e) {
                let url = "/csdlgd-admin/duyetDay/updateDuyetDdl?statusAction=-1&idUpdate=" + e.id;
                let msg = "Xác nhận từ chối duyệt: " + e.tenTruongHoc + ". (Mã: " + e.maTruongHoc +
                    ")?"
                this.$confirm(msg, 'Từ chối duyệt trường học', {
                        confirmButtonText: 'Từ chối',
                        cancelButtonText: 'Đóng',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const params = {};
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post(url, params, (data) => {
                            loading.close();
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.thongBao('success', data.data.rd)
                                this.getData();
                            } else {
                                this.thongBao('error', data.data.rd)
                                // return;
                            }
                        });
                    })
                    .catch(_ => {});
                // utils.confirmDialog(
                //     "Xác nhận từ chối duyệt: " + e.tenTruongHoc + ". (Mã: " + e.maTruongHoc +
                //     ")?",
                //     "Đồng ý",
                //     () => {
                //         const params = {};
                //         const loading = this.$loading({
                //             lock: true,
                //             text: 'Loading',
                //             spinner: 'el-icon-loading',
                //             background: 'rgba(0, 0, 0, 0.7)'
                //         });
                //         rest_api.post(url, params, (data) => {
                //             loading.close();
                //             console.log(JSON.stringify(data));
                //             if (data.data.rc == 0) {
                //                 this
                //                     .$alertify
                //                     .success("Từ chối thành công");
                //                 this.getData();
                //             } else {
                //                 this
                //                     .$alertify
                //                     .error(data.data.rd);
                //                 // return;
                //             }
                //         });
                //     }
                // )
            },
            tuChoiSo(e) {
                let url = "/csdlgd-admin/duyetDay/updateDdlSo?statusAction=-2&idUpdate=" + e.id;
                let msg = "Xác nhận từ chối duyệt: " + e.tenTruongHoc + ". (Mã: " + e.maTruongHoc +
                    ")?"
                this.$confirm(msg, 'Từ chối duyệt trường học', {
                        confirmButtonText: 'Từ chối',
                        cancelButtonText: 'Đóng',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const params = {};
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post(url, params, (data) => {
                            loading.close();
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.thongBao('success', data.data.rd)
                                this.getData();
                            } else {
                                this.thongBao('error', data.data.rd)
                                // return;
                            }
                        });
                    })
                    .catch(_ => {});
                // utils.confirmDialog(
                //     "Xác nhận từ chối duyệt: " + e.tenTruongHoc + ". (Mã: " + e.maTruongHoc +
                //     ")?",
                //     "Đồng ý",
                //     () => {
                //         const params = {};
                //         const loading = this.$loading({
                //             lock: true,
                //             text: 'Loading',
                //             spinner: 'el-icon-loading',
                //             background: 'rgba(0, 0, 0, 0.7)'
                //         });
                //         rest_api.post(url, params, (data) => {
                //             loading.close();
                //             console.log(JSON.stringify(data));
                //             if (data.data.rc == 0) {
                //                 this
                //                     .$alertify
                //                     .success("Từ chối thành công");
                //                 this.getData();
                //             } else {
                //                 this
                //                     .$alertify
                //                     .error(data.data.rd);
                //                 // return;
                //             }
                //         });
                //     }
                // )
            },
            checkQuyenDay() {
                let lst_school = constant.truong_duoc_phep_day_xoa_du_lieu;
                console.log("danh sách trường được phép xóa" + JSON.stringify(lst_school));
                this.truong_duoc_phep = false;
                for (let i = 0; i < lst_school.length; i++) {
                    if (this.thongtin.ma_truong_hoc == lst_school[i]) {
                        this.truong_duoc_phep = true;
                    }
                }
            },
            limitTextDuLieu(count) {
                return `và ${count} loại dữ liệu khác`
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
            ChonCapHoc() {
                this.ds_truong_hoc = [];
                this.getTruongHoc();
            },
            ChonDonVi() {
                console.log("Danh sách đơn vị sau khi map:" + JSON.stringify(this.ds_don_vi))
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
                            this.capHocDangNhap = "Mẫu giáo";
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
            // Chọn loại danh sách
            chonLoaiDanhSach(e) {
                this.loaiDanhSach = e;
            },
            // Chọn ngày bắt đầu
            ChonNgayBatDau() {
                if (this.tuNgay != null) {
                    let endCuoiNam = moment(this.tuNgay, 'DD/MM/YYYY')
                        .add(6, 'days')
                        .format('DD/MM/YYYY');
                    this.denNgay = endCuoiNam;
                }
            },
            // Xóa
            ConFirmDelete(e) {
                console.log(e);
                utils.confirmDialog(
                    "Xác nhận xoá dữ liệu của trường: " + e.tenTruongHoc + ". (Mã: " + e.maTruongHoc +
                    ")?",
                    "Đồng ý",
                    () => {
                        const params = {
                            "maTruongHoc": e.maTruongHoc
                        };
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.get("/csdlgd-admin/yeuCauDuLieuTruong/clear-data", params, (data) => {
                            loading.close();
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this
                                    .$alertify
                                    .success("Xóa thành công");
                                this.getData();
                            } else {
                                this.thongBao('error', data.data.rd)
                                // return;
                            }
                        });
                    }
                )
            },
            // xem lịch sửu
            XemLichSu(e) {
                let uri = 'moet-transfer-history?';
                if (e.maTruongHoc) {
                    uri += '&maTruongHoc=' + e.maTruongHoc;
                }
                if (e.namHoc) {
                    uri += '&namHoc=' + e.namHoc;
                }
                // if (e.loaiDongBo) {     uri += '&loaiDongBo=' + e.loaiDongBo; } if (e.id) {
                // uri += '&dotDay=' + e.id; }
                console.log("link:" + uri);
                console.log(uri);
                window.location.href = uri;
            },
            // Kiểm tra dữ liệu
            ChuyenHuong(e) {
                console.log("param:" + JSON.stringify(e));
                let uri = 'Data-transfer-schedule?';
                if (e.maTruongHoc) {
                    uri += '&maTruongHoc=' + e.maTruongHoc;
                }
                if (e.namHoc) {
                    uri += '&namHoc=' + e.namHoc;
                }
                // if (e.loaiDongBo) {     uri += '&loaiDongBo=' + e.loaiDongBo; }
                if (e.id) {
                    uri += '&dotDay=' + e.id;
                }
                console.log("link:" + uri);
                window.location.href = uri;
            },
            // chuyển hướng cán bộ
            ChuyenHuongCanBo(e) {
                console.log("param:" + JSON.stringify(e));
                let uri = 'Look-up-officials?';
                if (e.maTruongHoc) {
                    uri += '&maTruongHoc=' + e.maTruongHoc;
                }
                if (e.namHoc) {
                    uri += '&namHoc=' + e.namHoc;
                }
                console.log("link:" + uri);
                window.location.href = uri;
            },
            // chuyển hướng học sinh
            ChuyenHuongHocSinh(e) {
                let uri = 'Look-up-students?';
                if (e.maTruongHoc) {
                    uri += '&maTruongHoc=' + e.maTruongHoc;
                }
                if (e.namHoc) {
                    uri += '&namHoc=' + e.namHoc;
                }
                console.log("link:" + uri);
                window.location.href = uri;
            },
            // chuyển hướng lớp học
            ChuyenHuongLopHoc(e) {
                let uri = 'Look-up-classes?';
                if (e.maTruongHoc) {
                    uri += '&maTruongHoc=' + e.maTruongHoc;
                }
                if (e.namHoc) {
                    uri += '&namHoc=' + e.namHoc;
                }
                console.log("link:" + uri);
                window.location.href = uri;
            },
            // chuyển hướng kqht
            ChuyenHuongKqht(e) {
                let uri = 'Look-up-academi-results?';
                if (e._id.maTruongHoc) {
                    uri += '&maTruongHoc=' + e._id.maTruongHoc;
                }
                if (e._id.namHoc) {
                    uri += '&namHoc=' + e._id.namHoc;
                }
                if (e._id.hocKy) {
                    uri += '&hocKy=' + e._id.hocKy;
                }
                console.log("link:" + uri);
                window.location.href = uri;
            },
            // bind lại
            reBindData() {
                this
                    .list_truong_hoc_chua_day
                    .map((truongHoc) => {
                        truongHoc
                            .key
                            .map((key, index) => {
                                let buocDay = truongHoc
                                    .thongTinBuocDays
                                    .find((obj) => obj == key);
                                if (buocDay) {
                                    console.log("Buoc day: ", buocDay);
                                    truongHoc.key[index] = buocDay;
                                }
                            });
                    });
                this.chonDuLieuDay();
            },
            // đẩy xong
            DayXong() {
                this.show_xoanhieutruong = false;
                console.log("lấy lại danh sách");
                this.CacTruongDay = [];
                this.getData();
            },
            // Đẩy lại dữ liệu
            dayLaiDuLieu2() {
                console.log("Đẩy lại:" + JSON.stringify(this.list_truong_hoc_chua_day));
                let truongCanDayRequests = this
                    .list_truong_hoc_chua_day
                    .map((obj) => {
                        return {
                            maTruong: obj.maTruongHoc,
                            buocDays: obj.key,
                            capTruong: obj.capTruong,
                            tenTruong: obj.tenTruongHoc
                        }
                    });
                this.truongCanDayRequests = JSON.parse(JSON.stringify(truongCanDayRequests));
                // return
                this.DayLai();
            },
            xoaDuLieuNhieuTruong() {
                let truongCanDayRequests = this
                    .list_truong_hoc_chua_day
                    .map((obj) => {
                        return {
                            maTruong: obj.maTruongHoc,
                            buocDays: obj.key,
                            capTruong: obj.capTruong,
                            tenTruong: obj.tenTruongHoc
                        }
                    });
                this.truongCanDayRequests = JSON.parse(JSON.stringify(truongCanDayRequests));
                // return
                this.XoaDuLieu();
            },
            DayLai() {
                this.dsTruongDay = [];
                for (let b = 0; b < this.truongCanDayRequests.length; b++) {
                    if (this.truongCanDayRequests[b].buocDays.length > 0) {
                        console.log("123" + JSON.stringify(this.truongCanDayRequests[b]));
                        this
                            .dsTruongDay
                            .push(this.truongCanDayRequests[b])
                    }
                }
                this.show_daylai = true;
                this.CacTruongDay = this.dsTruongDay;
                console.log("các trương đẩy:" + JSON.stringify(this.CacTruongDay));
                for (let c = 0; c < this.dsTruongDay.length; c++) {
                    console.log("convert:" + JSON.stringify(this.dsTruongDay[c].buocDays));
                    var names = this
                        .dsTruongDay[c]
                        .buocDays
                        .map(function (item) {
                            return item;
                        });
                    this
                        .dsTruongDay[c]
                        .buocDays = names;
                    for (let d = 0; d < this.dsTruongDay[c].buocDays.length; d++) {
                        this
                            .dsTruongDay[c]
                            .buocDays[d] = parseInt(this.dsTruongDay[c].buocDays[d])
                    }
                }
                this.namHoc = this.namHoc;
                this.hocKyDayDuLieu = this.hocKy;
                console.log("đẩy lại:" + JSON.stringify(this.CacTruongDay));
            },
            XoaDuLieu() {
                this.dsTruongDay = [];
                for (let b = 0; b < this.truongCanDayRequests.length; b++) {
                    console.log("hihi" + JSON.stringify(this.truongCanDayRequests[b]));
                    if (this.truongCanDayRequests[b].buocDays.length > 0) {
                        console.log("123" + JSON.stringify(this.truongCanDayRequests[b]));
                        this
                            .dsTruongDay
                            .push(this.truongCanDayRequests[b])
                    }
                }
                this.show_xoanhieutruong = true;
                this.CacTruongDay = this.dsTruongDay;
                console.log("các trương đẩy:" + JSON.stringify(this.CacTruongDay));
                for (let c = 0; c < this.dsTruongDay.length; c++) {
                    console.log("convert:" + JSON.stringify(this.dsTruongDay[c].buocDays));
                    var names = this
                        .dsTruongDay[c]
                        .buocDays
                        .map(function (item) {
                            return item;
                        });
                    this
                        .dsTruongDay[c]
                        .buocDays = names;
                    for (let d = 0; d < this.dsTruongDay[c].buocDays.length; d++) {
                        this
                            .dsTruongDay[c]
                            .buocDays[d] = parseInt(this.dsTruongDay[c].buocDays[d])
                    }
                }
                this.namHoc = this.namHoc;
                this.hocKyDayDuLieu = this.hocKy;
                console.log("đẩy lại:" + JSON.stringify(this.CacTruongDay));
            },
            // Lấy lại trường chưa đẩy
            LayLaiTruongChuaDay(e) {
                console.log("lấy lại trường chưa đẩy ở bên ngoài:" + JSON.stringify(e));
                this.start2 = e.start;
                this.limit2 = e.limit;
                this.currentPage2 = e.currentPage;
                this.getTruongChuaDay()
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
            // xuất excel trường đẩy dữ liệu
            getDownLoad() {
                let url = "xuat-excel-ket-chuyen-du-lieu";
                let params = {
                    capHocList: this.ds_cap_hoc,
                    maDonViList: this.ds_don_vi,
                    maTruongHoc: this.maTruongHoc,
                    matruongHocList: this.lstMaTruongBoSung,
                    namHoc: this.namHoc,
                    hocKy: this.hocKy,
                    // loaiDongBo: this.ds_loai_dong_bo, status: this.ds_trang_thai,
                    showOnlyIncompleteSchool: this.truongChuaHoanThanh
                };
                // check lại params
                console.log("params 1:" + JSON.stringify(params));
                // if (params.loaiDongBo.length == 0) {     params.loaiDongBo = ""; } if
                // (params.status.length == 0) { params.status = ""; }
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                        confirmButtonClass:'bt-chinh'
                    })
                    .then(_ => {
                        this.thongBao('success', 'Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(url, params, (data) => {
                            loading.close()
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
                // utils.confirmDialog(
                //     "Xác nhận tải xuống dữ liệu. Vui lòng chờ trong thời gian tải xuống",
                //     "Đồng ý",
                //     () => {
                //     }
                // )
            },
            // thêm mới lịch đồng bộ
            showCreatSyncData() {
                this.show_create = true;
                console.log("thêm mới:" + this.show_create);
            },
            // lấy lại dữ liệu
            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            // Lấy tên loại dữ liệu
            getLoaiDuLieu(loai) {
                var res = loai;
                switch (loai) {
                    case 1:
                        res = 'Dữ liệu đầu năm'
                        break;
                    case 2:
                        res = 'Dữ liệu phát sinh'
                        break;
                    case 3:
                        res = 'Dữ liệu cuối năm'
                        break;
                    case 4:
                        res = 'Dữ liệu năm học cũ'
                        break;
                    case 5:
                        res = 'Dữ liệu tức thời'
                        break;
                    default:
                        res = "Không xác định";
                }
                return res;
            },
            // Lấy tên trạng thái
            getTrangThai(loai) {
                var res = loai;
                switch (loai) {
                    case -1:
                        res = 'Dữ liệu lỗi'
                        break;
                    case 1:
                        res = 'Dữ liệu mới tạo'
                        break;
                    case 2:
                        res = 'Đang xử lý'
                        break;
                    case 5:
                        res = 'Trường hoàn thành'
                        break;
                    case 6:
                        res = 'Phòng đã duyệt'
                        break;
                    case 7:
                        res = 'Sở đã duyệt'
                        break;
                    default:
                        res = "Không xác định";
                }
                return res;
            },
            // Lấy trường học
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc
                };
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    // loading.close();
                    console.log("lấy trường");
                    if (data.data.code == 200) {
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
                        this.list_truong_hoc = []
                    }
                });
            },
            themTruongBoSung() {
                let ds_ma_truong = this.ds_truong_hoc;
                let lstMaTruong = [];
                this.lstMaTruongBoSung = this.maTruongBoSung.split(',');
                for (let i = 0; i < this.lstMaTruongBoSung.length; i++) {
                    this.lstMaTruongBoSung[i] = this.lstMaTruongBoSung[i].trim();
                }
                this.lstMaTruongBoSung = this.lstMaTruongBoSung.filter(item => item !== "");
                lstMaTruong = this.ds_truong_hoc.concat(this.lstMaTruongBoSung);
                const uniqueLstMaTruong = lstMaTruong.filter((x, i, a) => a.indexOf(x) == i)
                this.lstMaTruongBoSung = uniqueLstMaTruong;
            },
            checkTruocKhiTim() {
                if (!this.namHoc) {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                    return;
                }
                this.themTruongBoSung();
                this.danhSachChonDongBo = [];
                this.trangbatdau = !this.trangbatdau;
            },
            checkBeforeSearch() {
                if (!this.namHoc) {
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                    return;
                }
                this.danhSachChonDongBo = [];
                console.log("check trước khi tìm kiếm");
                this.getData();
            },
            getComBoData() {
                // if (this.ds_loai_dong_bo.length == 0) {
                //     this
                //         .$alertify
                //         .error("Vui lòng chọn loại đồng bộ tìm kiếm");
                //     return;
                // }
                this.getTruongChuaDay();
            },
            // lấy dữ liệu
            getData() {
                this.list_truong_hoc_chua_day = [];
                this.total_rows = 0;
                let params = {
                    lstCapHoc: this.lstCapHoc,
                    capHocList: this.ds_cap_hoc,
                    maDonViList: this.ds_don_vi,
                    maTruongHoc: this.maTruongHoc,
                    matruongHocList: this.lstMaTruongBoSung,
                    namHoc: this.namHoc,
                    hocKy: this.hocKy,
                    startDate: this.tuNgay ? this.tuNgay[0] : null,
                    endDate: this.tuNgay ? this.denNgay[1] : null,
                    // loaiDongBo: this.ds_loai_dong_bo, status: this.ds_trang_thai,
                    start: this.start,
                    showOnlyIncompleteSchool: this.truongChuaHoanThanh,
                    limit: this.limit
                };
                if (this.maTruongHoc) {
                    params.maTruongHoc = this.maTruongHoc;
                }
                // check lại params
                console.log("params 1:" + JSON.stringify(params));
                // if (params.loaiDongBo.length == 0) {     params.loaiDongBo = ""; } if
                // (params.status.length == 0) { params.status = ""; }
                this.pr = params;
                console.log("params 2:" + JSON.stringify(this.pr));
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/yeuCauDuLieuTruong/search2", params, (data) => {
                    loading.close()
                    // console.log("trả về:" + JSON.stringify(data.data));
                    if (data.data.rc == 0) {
                        if (data.data.totalRows == 0) {
                            // số bản ghi bằng 0
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy");
                            return;
                        }
                        if (data.data.totalRows > 0) {
                            this.total_rows = data.data.totalRows;
                            // số bản ghi >0
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công.");
                            // this.list_truong_hoc_chua_day = data.data.tableData;
                            this.list_truong_hoc_chua_day = data
                                .data
                                .tableData
                                .map((obj) => {
                                    return {
                                        ...obj,
                                        key: []
                                    }
                                });
                            this.updateColumnWidths()

                            return;
                        }

                    } else {
                        // Lấy thất bại
                        this
                            .$alertify
                            .error(data.data.rd);
                        return;
                    }

                    // console.log("object"); return;
                });
            },
            getTruongChuaDay() {
                if (!this.namHoc) {
                    // Yêu cầu chọn năm học khi tìm kiếm
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                    console.log("ds_loai_dong_bo");
                    console.log(this.ds_loai_dong_bo);
                    return;
                }
                console.log("danh sách đơn vị:" + this.ds_don_vi);
                if (this.ds_don_vi == "") {
                    // Yêu cầu chọn năm học khi tìm kiếm
                    this
                        .$alertify
                        .error("Vui lòng chọn đơn vị để tìm kiếm");
                    return;
                }
                this.loaiDanhSach = 2;
                let params = {
                    capHocList: this.ds_cap_hoc,
                    maDonViList: this.ds_don_vi,
                    maTruongHoc: this.maTruongHoc,
                    matruongHocList: this.lstMaTruongBoSung,
                    namHoc: this.namHoc,
                    hocKy: this.hocKy,
                    loaiDongBo: this.ds_loai_dong_bo,
                    //status: this.ds_trang_thai,
                    start: this.start2,
                    limit: this.limit2,
                    showOnlyIncompleteSchool: this.truongChuaHoanThanh
                };
                // check lại params
                console.log("params 1:" + JSON.stringify(params));
                // if (params.loaiDongBo.length == 0) {     params.loaiDongBo = ""; } if
                // (params.status.length == 0) { params.status = ""; }
                this.pr = params;
                this.thongTinTruongChuaDay = [];
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post(
                    "/csdlgd-admin/yeuCauDuLieuTruong/search-truong-chua-ddl",
                    params,
                    (data) => {
                        loading.close();
                        console.log("Thông tin trường chưa đẩy trả về:");
                        console.log(JSON.stringify(data.data));
                        if (data.data.rc == 0) {
                            this.thongTinTruongChuaDay = data.data;
                            if (this.thongTinTruongChuaDay.totalRows > 0) {
                                // this
                                //     .$alertify
                                //     .success("Lấy dữ liệu thành công");
                            } else {
                                // this
                                //     .$alertify
                                //     .error("Không tìm thấy bản ghi nào");
                            }
                        } else {
                            this
                                .$alertify
                                .error(data.data.rd);
                        }
                    },
                );
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
            setNameByIdValue({
                name
            }) {
                return `${name}`
            }, // định nghĩa cho trạng thái
            setNameDanhSachDongBo({
                name
            }) {
                return `${name}`
            },
            // Lấy danh sách đơn vị
            getDonVi(ck = () => {}) {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                // if (this.thongtin.role == 5 || this.thongtin.role == 4) {
                //     params.maTinhThanh = "",
                //     params.maQuanHuyen = this.thongtin.ma_don_vi;
                // }
                console.log("pr ẻty" + JSON.stringify(params));
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
                        let dulieu = data.data.rows;
                        let ldv = [];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenDonVi: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                maDonVi: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi = ldv;
                        if (this.thongtin.role == 5 || this.thongtin.role == 4) {
                            console.log("lấy đơn vị xong đăng nhập là trường:" + JSON.stringify(this.thongtin))
                            for (let i = 0; i < this.list_don_vi.length; i++) {
                                console.log("lượt:" + JSON.stringify(this.list_don_vi[i]));
                                if (this.list_don_vi[i].maDonVi == this.thongtin.ma_don_vi) {
                                    this.tenDonViDangNhap = this.list_don_vi[i].tenDonVi;
                                }
                            }
                        }
                        ck();
                    }
                });
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
        vertical-align: middle;
    }

    .table-bordered>tbody>tr>td {
        vertical-align: middle;
        padding: 5px;
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

    .input-group .form-control {
        z-index: 0;
    }

    .daduyet {
        background: #d6ffd8 !important;
    }

</style>

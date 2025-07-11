<template>
    <div v-loading.fullscreen.lock="fullScreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <Breadcrumb :menu="'Tiếp nhận dữ liệu QLNT'" :desc="'Cấu hình lịch đồng bộ'"
            :subDesc="'Cấu hình lịch đồng bộ cấp Trường'" />
        <div class="card-bieu-do">
            <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                <el-col :span="24">
                    <div class="table-name">Thông tin tìm kiếm</div>
                </el-col>
                <el-form ref="ruleForm">

                    <el-col :sm="24" :lg="12">
                        <label class="typo__label">Đơn vị quản lý </label>
                        <eselect style="width:100%" @change="layLaiTruong" :disabled="thongtin.role>2" multiple
                            collapseTags v-model="donVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                            :fields="['tenDonVi','maDonVi']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Cấp học </label>
                        <eselect style="width:100%" @change="layLaiTruong" multiple collapseTags v-model="capHoc"
                            :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc_full" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Năm học <span class="red">*</span></label>
                        <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                 :data="list_nam_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="24" :lg="12">
                        <label class="typo__label">Trường học</label>
                        <eselect style="width:100%" multiple collapseTags v-model="truongHoc" :placeholder="'Chọn'"
                                 filterable :data="list_truong_hoc" :fields="['name','value']" />
                    </el-col>



                    <el-col :sm="12" :lg="6">
                        <label class="typo__label">Trạng thái </label>
                        <eselect style="width:100%; height: 36px" collapseTags v-model="trangThai" :placeholder="'Chọn'"
                            filterable :data="list_trang_thai" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="24" class="text-center">
                        <el-button class="bt-chinh" plain size="mini" v-on:click.prevent="TruocKhiTim()" type="success">
                            Tìm kiếm
                        </el-button>
                    </el-col>
                </el-form>
            </el-row>
        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24">

                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <label class="table-name">Cấu hình năm học cấp trường</label>
                        <div class="text-right">
                            <span style="padding-right:20px" v-if="lsTruongUpdate.length"><b>Đã chọn
                                    {{ lsTruongUpdate.length }} bản ghi</b></span>
                            <el-tooltip content="Khóa các bản ghi đã chọn" placement="top">
                                <el-button plain v-if="lsTruongUpdate.length" :disabled="thongtin.role>4" size="mini"
                                    @click.prevent="KhoaCacBanGhiDaChon(1)" class="bt-phu lock-btn" type="primary">Khóa
                                </el-button>

                                <!-- <button class="btn btn-mini btn-sm" style="background:#6c757d; color:white" :disabled="thongtin.role>4"
                                                @click.prevent="KhoaCacBanGhiDaChon(1)" size="mini"
                                                    icon="el-icon-lock">Khóa</button> -->
                            </el-tooltip>
                            <el-tooltip content="Mở khóa các bản ghi đã chọn" placement="top">
                                <el-button class="bt-phu" v-if="lsTruongUpdate.length" plain :disabled="thongtin.role>4"
                                    size="mini" @click.prevent="KhoaCacBanGhiDaChon(2)" type="primary">Mở
                                    khóa
                                </el-button>
                            </el-tooltip>
                            <el-tooltip content="Chỉnh sửa các bản ghi đã chọn" placement="top">
                                <el-button class="bt-phu" v-if="lsTruongUpdate.length" plain :disabled="thongtin.role>4"
                                    size="mini" @click.prevent="KhoaCacBanGhiDaChon(3)" type="primary">Chỉnh sửa
                                </el-button>
                            </el-tooltip>
                            <el-tooltip content="Thêm mới cấu hình trường" placement="top">
                                <el-button class="bt-chinh" plain :disabled="thongtin.role>4" size="mini"
                                    @click.prevent="ThemMoiCauHinhTruong()" type="primary">Thêm mới
                                </el-button>
                            </el-tooltip>
                        </div>
                    </div>
                </el-col>
                <el-col v-if="false" :span="12" class="">
                    <label class="table-name">Cấu hình năm học cấp trường</label>
                </el-col>
                <el-col v-if="false" :span="12">
                    <div class="text-right">
                        <span style="padding-right:20px" v-if="lsTruongUpdate.length"><b>Đã chọn
                                {{ lsTruongUpdate.length }} bản ghi</b></span>
                        <el-tooltip content="Khóa các bản ghi đã chọn" placement="top">
                            <el-button plain v-if="lsTruongUpdate.length" :disabled="thongtin.role>4" size="mini"
                                @click.prevent="KhoaCacBanGhiDaChon(1)" class="bt-phu lock-btn" type="primary">Khóa
                            </el-button>

                            <!-- <button class="btn btn-mini btn-sm" style="background:#6c757d; color:white" :disabled="thongtin.role>4"
                                                @click.prevent="KhoaCacBanGhiDaChon(1)" size="mini"
                                                    icon="el-icon-lock">Khóa</button> -->
                        </el-tooltip>
                        <el-tooltip content="Mở khóa các bản ghi đã chọn" placement="top">
                            <el-button class="bt-phu" v-if="lsTruongUpdate.length" plain :disabled="thongtin.role>4"
                                size="mini" @click.prevent="KhoaCacBanGhiDaChon(2)" type="primary">Mở
                                khóa
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Chỉnh sửa các bản ghi đã chọn" placement="top">
                            <el-button class="bt-phu" v-if="lsTruongUpdate.length" plain :disabled="thongtin.role>4"
                                size="mini" @click.prevent="KhoaCacBanGhiDaChon(3)" type="primary">Chỉnh sửa
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Thêm mới cấu hình trường" placement="top">
                            <el-button class="bt-chinh" plain :disabled="thongtin.role>4" size="mini"
                                @click.prevent="ThemMoiCauHinhTruong()" type="primary">Thêm mới
                            </el-button>
                        </el-tooltip>
                    </div>
                </el-col>
                <el-col :span="24">
                    <el-table
                            :data="danh_sach_du_lieu"
                            border
                            max-height="600"
                            stripe
                            style="width: 100%"
                            empty-text="Không có dữ liệu"

                    >
                        <!-- Chọn tất cả Column -->
                        <el-table-column
                                label=""
                                width="50"
                                align="center"
                                fixed="left"
                        >
                            <template #header>
                                <input type="checkbox" v-model="checkAll" @change="chonTatCa" />
                            </template>
                            <template #default="{ row }">

                                <input type="checkbox" v-model="lsTruongUpdate" :value="row.maTruongHoc" />
                            </template>
                        </el-table-column>

                        <!-- STT Column -->
                        <el-table-column
                                label="STT"
                                :width="start > 9999 ? 70 : 60"
                                align="center"

                        >

                            <template #default="{ $index }">
                                <p>{{ (currentPage - 1) * limit + $index + 1 }}</p>
                            </template>
                        </el-table-column>

                        <!-- Thao tác Column -->
                        <el-table-column
                                label="Thao tác"
                                :width="columnWidths.thaoTac"
                                fixed="right"
                                align="center"
                        >
                            <template #default="{ row }">
                                <el-tooltip v-if="row.status == 1" content="Khóa" placement="left">
                                    <i
                                            :disabled="thongtin.role < 4"
                                            @click.prevent="thayDoiTrangThaiTungBanGhi(row.maTruongHoc, 1)"
                                            class="el-icon-lock"
                                    ></i>
                                </el-tooltip>
                                <el-tooltip v-else content="Mở khóa" placement="left">
                                    <i
                                            :disabled="thongtin.role < 4"
                                            @click.prevent="thayDoiTrangThaiTungBanGhi(row.maTruongHoc, 2)"
                                            class="el-icon-unlock"
                                    ></i>
                                </el-tooltip>
                                <el-tooltip content="Chỉnh sửa" placement="right">
                                    <i @click.prevent="chinhSuaNgay(row)" class="el-icon-edit"></i>
                                </el-tooltip>
                            </template>
                        </el-table-column>

                        <!-- Các cột còn lại -->
                        <el-table-column
                                label="Đơn vị quản lý"
                                :min-width="columnWidths.donVi"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenDonVi }}</p>
                            </template>
                        </el-table-column>
                        <el-table-column

                                label="Trường học"
                                :min-width="columnWidths.truongHoc"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenTruongHoc }}</p>
                            </template>
                        </el-table-column>

                        <el-table-column
                                label="Mã trường"
                                :min-width="columnWidths.maTruong"

                        >
                            <template #default="{ row }">
                                <p>{{ row.maTruongHoc }}</p>
                            </template>
                        </el-table-column>



                        <el-table-column
                                label="Ngày bắt đầu"
                                :min-width="columnWidths.ngayBatDau"
                                align="center"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tuNgay }}</p>
                            </template>
                        </el-table-column>

                        <el-table-column
                                label="Ngày kết thúc"
                                :min-width="columnWidths.ngayKetThuc"
                                align="center"
                        >
                            <template #default="{ row }">
                                <p>{{ row.denNgay }}</p>
                            </template>
                        </el-table-column>

                        <el-table-column
                                label="Trạng thái"
                                :min-width="columnWidths.trangThai"
                                align="center"
                        >
                            <template #default="{ row }">
                                <p :class="getClass(row.status)">
                                    {{ row.status == 1 ? 'Đang hoạt động' : 'Ngừng hoạt động' }}
                                </p>
                            </template>
                        </el-table-column>
                    </el-table>


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
        <!-- modal -->
        <div>
            <el-dialog :title=" getTitle(typeUpdate) + ' cấu hình lịch đồng bộ cấp trường'"
                :visible.sync="modal_confirm_update" width="90%" :close-on-click-modal="false"
                :close-on-press-escape="false" :before-close="handleClose">
                <el-form :model='dataFormUpdate' :rules="rulesUpdate" ref="ruleFormUpdate">
                    <el-row :gutter="24">
                        <el-col :span="24" v-if="typeUpdate==3||typeUpdate==4">
                            <h5 v-if="typeUpdate!=4">Hệ thống sẽ thực hiện {{ getType(typeUpdate) }} dữ liệu của <span
                                    v-if="danh_sach_truong_da_chon.length>1">{{ danh_sach_truong_da_chon.length }}</span>
                                trường
                                sau.</h5>
                            <h5 v-else>Hệ thống sẽ thực hiện chỉnh sửa dữ liệu của {{ total_rows }} trường đã tìm thấy.
                            </h5>
                            <div class="block" v-if="typeUpdate==4" style="padding-bottom:15px">
                                <el-switch style="width:49%" v-model="updateAllDateData"
                                    active-text="Thay đổi thời gian tiếp nhận">
                                </el-switch>
                            </div>
                            <div v-if="typeUpdate==3" class="block" style="margin-top: 24px">
                                <p>Thời hạn nộp: <span class="red">*</span></p>
                                <div class="row">
                                    <div class="col-md-4">
                                        <el-form-item prop="tuNgay">
                                            <el-date-picker
                                                    style="width: 100%"
                                                    v-model="dataFormUpdate.tuNgay"
                                                    type="daterange"
                                                    align="center"
                                                    format="dd/MM/yyyy"
                                                    value-format="dd/MM/yyyy"
                                                    start-placeholder="Từ ngày"
                                                    end-placeholder="Đến ngày">
                                            </el-date-picker>
                                        </el-form-item>
<!--                                        <div class="input-group input-daterange">-->
<!--                                            <el-form-item prop="tuNgay">-->
<!--                                                <date-picker :lang="lang" v-model="dataFormUpdate.tuNgay"-->
<!--                                                             placeholder="Chọn ngày" ref="tuNgay" valueType="format"-->
<!--                                                             value-type="DD/MM/YYYY" format="DD/MM/YYYY" @change="chonNgayBatDau">-->
<!--                                                </date-picker>-->
<!--                                            </el-form-item>-->
<!--                                            <div class="input-to">đến</div>-->

<!--                                            <el-form-item prop="denNgay">-->
<!--                                                <date-picker :lang="lang" ref="denNgay" v-model="dataFormUpdate.denNgay"-->
<!--                                                             @change="check_confirm_come_back = true" placeholder="Chọn ngày"-->
<!--                                                             valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">-->
<!--                                                </date-picker>-->
<!--                                            </el-form-item>-->
<!--                                        </div>-->
                                    </div>
                                </div>
                            </div>
                            <div v-if="typeUpdate==4" class="block" style="padding-bottom:15px;">
                                <p>Thời hạn nộp:</p>
                                <div class="input-group input-daterange">
                                    <date-picker :lang="lang" :disabled="!updateAllDateData" v-model="tuNgay"
                                        placeholder="Chọn ngày" valueType="format" value-type="DD/MM/YYYY"
                                        format="DD/MM/YYYY" @change="chonNgayBatDau">
                                    </date-picker>
                                    <div class="input-to">đến</div>
                                    <date-picker :lang="lang" :disabled="!updateAllDateData" v-model="denNgay"
                                        placeholder="Chọn ngày" valueType="format" value-type="DD/MM/YYYY"
                                        format="DD/MM/YYYY"></date-picker>
                                </div>
                            </div>
                            <div class="block" v-if="typeUpdate==4" style="padding-bottom:15px">
                                <el-switch style="width:49%" v-model="updateAllSttData"
                                    active-text="Thay đổi trạng thái tiếp nhận">
                                </el-switch>
                            </div>
                            <div class="block" v-if="typeUpdate==4">
                                <el-switch style="display: block" :disabled="!updateAllSttData" v-model="sttAllData"
                                    active-color="#13ce66" inactive-color="#ff4949" active-text="Mở khóa toàn bộ"
                                    inactive-text="Khóa toàn bộ">
                                </el-switch>
                            </div>
                        </el-col>
                        <el-col :span="24" v-if="typeUpdate!=4" class="">
                            <span class="table-name">
                                <h5 v-if="typeUpdate==2||typeUpdate==1">Hệ thống sẽ thực hiện {{ getType(typeUpdate) }} dữ liệu của
                                    <span
                                        v-if="danh_sach_truong_da_chon.length>1">{{ danh_sach_truong_da_chon.length }}</span>
                                    trường
                                    sau.</h5>
                                <!-- <h5 v-else>Hệ thống sẽ thực hiện chỉnh sửa dữ liệu của {{ total_rows }} trường đã tìm
                                    thấy.
                                </h5> -->
                            </span>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr style="background:#e4ebf5">
                                            <th class="text-center">
                                                <p>STT</p>
                                            </th>
                                            <th class="">
                                                <p>Tên trường</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Mã trường</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="danh_sach_truong_da_chon.length==0">
                                        <tr>
                                            <td colspan="3" class="cg">
                                                <p>Không có bản ghi nào</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr v-for="(item,i) in danh_sach_truong_da_chon" :key="i">
                                            <td class="text-center">{{ i + 1 }}
                                            </td>
                                            <td>
                                                <p>{{ item.name }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{ item.code }}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </el-col>
                    </el-row>
                </el-form>
                <span slot="footer" class="dialog-footer">
                    <el-button class="bt-phu" type="default" @click="handleClose" size="mini">Đóng</el-button>
                    <el-button class="bt-chinh" size="mini" type="primary"
                        @click.prevent="submitForm('ruleFormUpdate')">Lưu</el-button>
                </span>
            </el-dialog>
            <!-- Thêm -->
            <el-dialog top="80px" title="Thêm mới cấu hình lịch đồng bộ cấp trường" :visible.sync="modal_confirm_add" width="90%"
                :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
                <el-form :model='dataFormAdd' :rules="rules" ref="ruleForm">
                    <el-row :gutter="24" class="">
                        <el-col :sm="24"  :md="16" :lg="12">
                            <label>Đơn vị quản lý </label>
                            <eselect style="width:100%" @change="layLaiTruongAdd" :disabled="thongtin.role>2" multiple
                                collapseTags v-model="donViAdd" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                :fields="['tenDonVi','maDonVi']" />
                        </el-col>
                        <el-col :sm="12"  :md="8" :lg="6">
                            <label>Cấp học </label>
                            <eselect style="width:100%" @change="layLaiTruongAdd" multiple collapseTags
                                v-model="capHocAdd" :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc_full"
                                :fields="['name','id']" />
                        </el-col>
                        <el-col :sm="12"  :md="8" :lg="6">
                            <label>Năm học <span style="color:#DC0101">*</span></label>
                            <el-form-item prop="namHoc">
                                <eselect style="width:100%" collapseTags v-model="dataFormAdd.namHoc"
                                         @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                         ref="namHoc" :data="list_nam_hoc" :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="24"  :md="16" :lg="12">
                            <label>Trường học <span class="red">*</span></label>
                            <el-form-item prop="truongHocAdd">
                                <eselect style="width:100%" ref="truongHocAdd" multiple collapseTags
                                    @change="check_confirm_come_back = true" v-model="dataFormAdd.truongHocAdd"
                                    :placeholder="'Chọn'" filterable :data="list_truong_hoc_add"
                                    :fields="['name','value']" />
                            </el-form-item>
                        </el-col>

                        <el-col :sm="24"  :md="16" :lg="12">
                            <label>Thời hạn nộp: <span style="color:#DC0101">*</span></label>
                            <div>

<!--                                <el-form-item prop="tuNgayAdd">-->
<!--                                    <date-picker ref="tuNgayAdd" :lang="lang" v-model="dataFormAdd.tuNgayAdd"-->
<!--                                        placeholder="Chọn ngày" valueType="format" value-type="DD/MM/YYYY"-->
<!--                                        format="DD/MM/YYYY" @change="chonNgayBatDauAdd">-->
<!--                                    </date-picker>-->
<!--                                </el-form-item>-->
<!--                                <div class="input-to">đến</div>-->
<!--                                <el-form-item prop="denNgayAdd">-->
<!--                                    <date-picker ref="denNgayAdd" :lang="lang" v-model="dataFormAdd.denNgayAdd"-->
<!--                                        @change="check_confirm_come_back = true" placeholder="Chọn ngày"-->
<!--                                        valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">-->
<!--                                    </date-picker>-->
<!--                                </el-form-item>-->
                                <el-form-item prop="tuNgayAdd">
                                    <el-date-picker
                                            style="width: 100%"
                                            v-model="dataFormAdd.tuNgayAdd"
                                            type="daterange"
                                            align="center"
                                            format="dd/MM/yyyy"
                                            value-format="dd/MM/yyyy"
                                            start-placeholder="Từ ngày"
                                            end-placeholder="Đến ngày">
                                    </el-date-picker>
                                </el-form-item>
                            </div>
                        </el-col>
                    </el-row>
                </el-form>
                <span slot="footer" class="dialog-footer">
                    <el-button class="bt-phu" type="default" @click="handleClose" size="mini">Đóng</el-button>
                    <el-button class="bt-chinh" size="mini" type="primary" @click.prevent="submitForm('ruleForm')">Lưu
                    </el-button>
                </span>
            </el-dialog>
            <div id="modal_bao_loi" ref="modal_bao_loi" class="modal fade" data-keyboard="false" data-backdrop="static"
                style="font-size:18px;">
                <div class="modal-dialog" style="width:50%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title text-uppercase">Thông báo</h4>
                        </div>

                        <div class="modal-body" style="width: 100%;margin: 0 auto;">
                            <p>Danh sách trường học đã tồn tại cấu hình</p>
                            <div class="table-responsive" style="max-height:30vh !important;">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr style="background:rgb(228, 235, 245)">
                                            <th class="text-center">
                                                <p>STT</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Mã trường</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Tên trường</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(tt,index) in danh_sach_truong_hoc_them_that_bai">
                                            <td class="text-center">
                                                <p>{{ index + 1 }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{ tt.ma }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tt.ten }}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from "../../utils/rest_api";
    import constant from '../../utils/constant';
    import utils from '../../utils'
    import PhanTrang from "../ui/PagingCustom";
    import ChonSoLuong from "../ui/chonSoLuongBanGhi";
    import ESelectVue from '../ui/ESelect.vue';
    import moment from 'moment';
    import dialog from "../../utils/dialog";
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import 'vue2-datepicker/locale/vi';
    import Breadcrumb from "../ui/Breadcrumb.vue";

    export default {
        components: {
            "PhanTrang": PhanTrang,
            'eselect': ESelectVue,
            ChonSoLuong: ChonSoLuong,
            DatePicker,
            Breadcrumb
        },
        computed: {},
        data() {
            return {
                columnWidths: {
                    stt: 50,
                    thaoTac: 100,
                    donVi: 200,
                    maTruong: 120,
                    truongHoc: 250,
                    ngayBatDau: 150,
                    ngayKetThuc: 150,
                    trangThai: 150,
                },
                fullScreenLoading: false,
                check_confirm_come_back: false,
                lang: {
                    formatLocale: {
                        firstDayOfWeek: 1,
                    },
                    monthBeforeYear: false,
                },
                thongtin: JSON.parse(window.userInfo),
                danh_sach_truong_hoc_them_that_bai: [],
                donVi: [],
                donViAdd: [],
                capHoc: [],
                capHocAdd: [],
                truongHoc: [],
                truongHocAdd: [],
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                soLuongBanGhiHienThi: 25,
                duLieuTimKiem: {},
                sttAllData: null,
                updateAllSttData: false,
                updateAllDateData: false,
                trangbatdau: false,
                trangThai: null,
                date: new Date(),
                namHoc: "",
                list_don_vi: [],
                list_don_vi_add: [],
                danh_sach_cap_hoc_full: window.listCapHoc,
                list_truong_hoc: [],
                list_truong_hoc_add: [],
                list_trang_thai: [{
                    name: "Đang hoạt động",
                    value: 1
                }, {
                    name: "Ngừng hoạt động",
                    value: 2
                }],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                danh_sach_du_lieu: [],
                checkAll: false,
                lsTruongUpdate: [],
                danh_sach_truong_da_chon: [],
                typeUpdate: null,
                modal_confirm_add: false,
                modal_confirm_update: false,
                dataFormUpdate: {
                    tuNgay: '',
                    denNgay: ''
                },
                rulesUpdate: {
                    tuNgay: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    denNgay: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                },
                dataFormAdd: {
                    truongHocAdd: [],
                    namHoc: '',
                    tuNgayAdd: [],
                    denNgayAdd: ''
                },
                rules: {
                    truongHocAdd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    namHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    tuNgayAdd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    denNgayAdd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                }
            }
        },
        mounted() {
            this.namHoc = this.thongtin.namHocHienTai;
            this.getDonVi();
            this.getData();
            $(this.$refs.modal_bao_loi).on("hidden.bs.modal", this.closeModalBaoLoi);
        },
        watch: {
            danh_sach_du_lieu(newData) {

            },

            lsTruongUpdate: function (newVal) {
                console.log("Danh sách trường học update");
                console.log(newVal)
                if (newVal) {
                    let data = newVal;
                    if (data.length == this.danh_sach_du_lieu.length && data.length > 0) {
                        this.checkAll = true;
                    } else {
                        this.checkAll = false;
                    }
                } else {
                    this.checkAll = false;
                }
            },
        },
        methods: {
// Tính toán lại độ rộng của cột khi dữ liệu thay đổi
            updateColumnWidths() {
                // Bạn có thể sử dụng phương pháp đo độ rộng của nội dung tại đây.
                // Giả sử bạn cần tính toán lại các chiều rộng dựa trên các dữ liệu từ API
                this.columnWidths = {
                    stt: 50,
                    thaoTac: 100,
                    donVi: this.calculateColumnWidth(this.danh_sach_du_lieu, 'tenDonVi'),
                    maTruong: 120,
                    truongHoc: this.calculateColumnWidth(this.danh_sach_du_lieu, 'tenTruongHoc'),
                    ngayBatDau: 140,
                    ngayKetThuc: 140,
                    trangThai: 160,
                };
            },
            calculateColumnWidth(data, key) {
                // Tính toán độ rộng cột dựa trên dữ liệu
                let maxLength = Math.max(...data.map((row) => row[key]?.length || 0));
                return maxLength * 10 + 20; // Ví dụ: 10px cho mỗi ký tự + padding
            },
            getClass(stt) {
                return stt == 1 ? 'banGhiDangHoatDong' : 'banGhiNgungHoatDong'
            },
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log(formName)
                        console.log('Validate success')
                        if (formName == 'ruleForm') {
                            this.SubmitThemCauHinhTruong();
                        } else {
                            if (this.typeUpdate == 1 || this.typeUpdate == 2 || this.typeUpdate == 3) {
                                this.thayDoiTrangThai();
                            } else {
                                this.chinhSuaToanBo();
                            }
                        }
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            resetForm(formName) {
                this.dataFormAdd = {
                    truongHocAdd: [],
                    namHoc: '',
                    tuNgayAdd: '',
                    denNgayAdd: ''
                }
                this.donViAdd = [];
                this.capHocAdd = [];
                this.check_confirm_come_back = false;
                if (this.$refs[formName]) {

                    this.$refs[formName].resetFields();
                }
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
                            this.resetForm('ruleForm')
                            this.resetForm('ruleFormUpdate')
                            this.modal_confirm_add = false;
                            this.modal_confirm_update = false;
                        })
                        .catch(_ => {});
                } else {

                    this.resetForm('ruleForm')
                    this.resetForm('ruleFormUpdate')
                    this.modal_confirm_add = false;
                    this.modal_confirm_update = false;

                }
            },
            SubmitThemCauHinhTruong() {


                let params = {
                    dsMaTruong: this.dataFormAdd.truongHocAdd,
                    maSo: this.thongtin.ma_so,
                    namHoc: this.dataFormAdd.namHoc,
                    ngayBatDau: this.dataFormAdd.tuNgayAdd[0],
                    ngayKetThuc: this.dataFormAdd.tuNgayAdd[1],
                };
                this.$confirm('Xác nhận thêm mới?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {

                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/yeuCauDuLieuTruong/chdbdl-truong", params, data => {
                            loading.close();
                            if (data.data.rc == 0) {
                                this.thongBao('success', 'Thêm mới thành công')
                                this.getData();
                                this.modal_confirm_add = false;
                                this.reSetFormAdd();
                            } else if (data.data.rc == 1) {
                                this.thongBao('error', data.data.rd)
                                // // let dulieu = data.data.item;
                                // // console.log("Dulieu")
                                // // console.log(dulieu)
                                // // console.log(this.list_truong_hoc_add)
                                // // let list_error = [];
                                // // for (let i = 0; i < dulieu.length; i++) {
                                // //     for (let j = 0; j < this.list_truong_hoc_add.length; j++) {
                                // //         if (dulieu[i] == this.list_truong_hoc_add[j].value) {
                                // //             let obj = {
                                // //                 ten: this.list_truong_hoc_add[j].label,
                                // //                 ma: dulieu[i]
                                // //             }
                                // //             list_error.push(obj)
                                // //         }
                                // //     }
                                // // }
                                // // this.danh_sach_truong_hoc_them_that_bai = list_error;

                                // this.reSetFormAdd();
                                // $("#modal_confirm_add").modal('hide');
                                // $("#modal_bao_loi").modal();
                            } else if (data.data.rc == -1) {
                                this.thongBao('error', 'Trường đã tồn tại cấu hình')
                                let dulieu = data.data.item;
                                console.log("Dulieu")
                                console.log(dulieu)
                                console.log(this.list_truong_hoc_add)
                                let list_error = [];
                                for (let i = 0; i < dulieu.length; i++) {
                                    for (let j = 0; j < this.list_truong_hoc_add.length; j++) {
                                        if (dulieu[i] == this.list_truong_hoc_add[j].value) {
                                            let obj = {
                                                ten: this.list_truong_hoc_add[j].label,
                                                ma: dulieu[i]
                                            }
                                            list_error.push(obj)
                                        }
                                    }
                                }
                                this.danh_sach_truong_hoc_them_that_bai = list_error;
                                this.reSetFormAdd();
                                this.modal_confirm_add = false;
                                $("#modal_bao_loi").modal();
                            } else {
                                this.thongBao('error', data.data.rd)
                                this.closeModalBaoLoi();
                                this.closeModalAdd();
                                this.closeModalUpdate();
                            }
                        });
                    })
                    .catch(_ => {});
            },
            reSetFormAdd() {
                this.donViAdd = [];
                this.capHocAdd = [];
                this.dataFormAdd.truongHocAdd = [];
                this.dataFormAdd.tuNgayAdd = [];
                this.dataFormAdd.denNgayAdd = null;
            },
            ThemMoiCauHinhTruong() {
                this.dataFormAdd.namHoc = this.namHoc;
                this.modal_confirm_add = true;
            },
            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                console.log("Chọn số lượng bản ghi:")
                console.log(JSON.stringify(e));
                this.lsTruongUpdate = [];
                this.soLuongBanGhiHienThi = e.soluong;
            },
            chinhSuaNgay(e) {
                this.lsTruongUpdate = [];
                this.dataFormUpdate.tuNgay = null;
                this.dataFormUpdate.denNgay = null;
                if (e) {
                    this.dataFormUpdate.tuNgay = [e.tuNgay,e.denNgay];
                    this.dataFormUpdate.denNgay = e.denNgay;
                    this.lsTruongUpdate = [e.maTruongHoc];
                    this.KhoaCacBanGhiDaChon(3);
                }
            },
            chinhSuaToanBo() {
                console.log("Chỉnh sửa toàn bộ");
                this.duLieuTimKiem.tuNgay = null;
                this.duLieuTimKiem.denNgay = null;
                if (this.updateAllSttData) {
                    let stt = null;
                    if (this.sttAllData) {
                        stt = 1;
                    } else {
                        stt = 0
                    }
                    this.duLieuTimKiem.statusUpdate = stt;
                }
                if (this.updateAllDateData) {
                    if (!this.dataFormUpdate.tuNgay) {
                        this.thongBao('error', "Vui lòng bổ sung thời hạn tiếp nhận dữ liệu")
                        return;
                    }
                    this.duLieuTimKiem.tuNgay = this.dataFormUpdate.tuNgay[0];
                    this.duLieuTimKiem.denNgay = this.dataFormUpdate.denNgay[0];
                }

                let params = this.duLieuTimKiem;
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/yeuCauDongBo/updateAllNopDuLieu", params, data => {
                    loading.close();
                    if (data.data.rc == 0) {
                        if (this.duLieuTimKiem.statusUpdate == 1) {
                            this.thongBao('success',
                                'Mở khóa cấu hình nộp dữ liệu cấp trường thành công ')
                        } else {
                            this.thongBao('success',
                                'Khóa cấu hình nộp dữ liệu cấp trường thành công ')
                        }
                        this.getData();
                    } else {
                        this.thongBao('error', data.data.rd)
                    }
                });
                // this.$confirm('Xác nhận chỉnh sửa?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {
                //     })
                //     .catch(_ => {});
            },
            thayDoiTrangThaiTungBanGhi(a, b) {
                this.lsTruongUpdate = [a];
                console.log("Thay đổi trạng thái từng bản ghi riêng lẻ:")
                console.log(a)
                console.log(b)
                //b:1-khóa,2-mở khóa;
                let obj = {
                    dsMaTruong: this.lsTruongUpdate,
                    maSo: this.thongtin.ma_so,
                    namHoc: this.namHoc,
                    statusUpdate: null,
                    tuNgay: null,
                    denNgay: null,
                }
                if (b == 1) {
                    obj.statusUpdate = 0;
                }
                if (b == 2) {
                    obj.statusUpdate = 1;
                }
                console.log("Dữ liệu chỉnh sửa:")
                let msg = 'Xác nhận' + (b == 1 ? ' khóa ' : ' mở khóa ') + ' cấu hình?';
                this.$confirm(msg, 'Cập nhật trạng thái', {
                        confirmButtonText: b == 1 ? 'Khóa' : 'Mở khóa',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        let params = obj
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.put("/csdlgd-admin/yeuCauDuLieuTruong/chdbdl", params, data => {
                            loading.close();
                            if (data.data.rc == 0) {
                                if (params.statusUpdate == 1) {
                                    this.thongBao('success',
                                        'Mở khóa cấu hình nộp dữ liệu cấp trường thành công ')
                                } else {
                                    this.thongBao('success',
                                        'Khóa cấu hình nộp dữ liệu cấp trường thành công ')
                                }
                                this.getData();
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            chonNgayBatDau(e) {
                console.log("Chọn ngày bắt đầu:" + e)
                this.check_confirm_come_back = true;
                if (this.dataFormUpdate.tuNgay != null) {
                    let endDauNam = moment(this.dataFormUpdate.tuNgay, "DD/MM/YYYY")
                        .add(10, "days")
                        .format("DD/MM/YYYY");
                    this.dataFormUpdate.denNgay = endDauNam;
                }
            },
            chonNgayBatDauAdd(e) {
                this.check_confirm_come_back = true;
                console.log("Chọn ngày bắt đầu:" + e)
                if (this.dataFormAdd.tuNgayAdd != null) {
                    let endDauNam = moment(this.dataFormAdd.tuNgayAdd, "DD/MM/YYYY")
                        .add(10, "days")
                        .format("DD/MM/YYYY");
                    this.dataFormAdd.denNgayAdd = endDauNam;
                }
            },
            getType(e) {
                if (e == 1) {
                    return "khóa"
                } else if (e == 2) {
                    return "mở khóa"
                } else if (e == 3) {
                    return "thay đổi thời gian tiếp nhận"
                } else {
                    return "thay đổi trạng thái"
                }
            },
            getTitle(e) {
                if (e == 1) {
                    return "Khóa"
                } else if (e == 2) {
                    return "Mở khóa"
                } else if (e == 3) {
                    return "Chỉnh sửa"
                } else {
                    return "Chỉnh sửa"
                }
            },
            thayDoiTrangThai() {
                console.log("Thay đổi trạng thái:")
                console.log(this.typeUpdate)
                //typeupdate: 1-khóa, 2-mở khóa, 3-thay đổi thời gian
                let stt = null;
                let type = this.typeUpdate;
                // if (type == 3) {
                //     if (!this.dataFormUpdate.tuNgay || !this.dataFormUpdate.denNgay) {
                //         this.thongBao('error', 'Vui lòng bổ sung thời hạn tiếp nhận dữ liệu')
                //         return;
                //     }
                // }
                var canhbao = "Xác nhận";
                if (type == 1) {
                    canhbao = "Xác nhận khóa dữ liệu";
                    stt = 0
                }
                if (type == 2) {
                    canhbao = "Xác nhận mở khóa dữ liệu";
                    stt = 1
                }
                if (type == 3) {
                    canhbao = "Xác nhận thay đổi thời hạn tiếp nhận dữ liệu";
                }
                console.log("Chỉnh sửa:")
                let obj = {
                    dsMaTruong: this.lsTruongUpdate,
                    maSo: this.thongtin.ma_so,
                    namHoc: this.namHoc,
                    statusUpdate: stt,
                    tuNgay: this.dataFormUpdate.tuNgay[0],
                    denNgay: this.dataFormUpdate.tuNgay[1],
                }
                if (type == 1 || type == 2) {
                    obj.tuNgay = null;
                    obj.denNgay = null;
                }


                let params = obj;
                const loadingBind = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.put("/csdlgd-admin/yeuCauDuLieuTruong/chdbdl", params, data => {
                    loadingBind.close();
                    if (data.data.rc == 0) {
                        this.thongBao('success',
                            'Chỉnh sửa cấu hình năm học cấp trường thành công.')
                        this.getData();
                    } else {
                        this.thongBao('error', data.data.rd)
                    }
                });
                // this.$confirm(canhbao, 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {
                //     })
                //     .catch(_ => {});
            },
            closeModalUpdate() {
                this.modal_confirm_update = false;
            },
            closeModalAdd() {
                this.modal_confirm_add = false;
            },
            closeModalBaoLoi() {
                $("#modal_bao_loi").modal('hide');
                this.getData();
            },
            KhoaCacBanGhiDaChon(e) {
                if (this.lsTruongUpdate.length <= 0) {
                    this.thongBao('error', 'Vui lòng chọn trường học')
                    return;
                }
                this.typeUpdate = e
                const loadingBind = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                console.log("Khóa các bản ghi đã chọn");
                this.danh_sach_truong_da_chon = [];
                console.log(this.lsTruongUpdate);
                for (let i = 0; i < this.lsTruongUpdate.length; i++) {
                    for (let j = 0; j < this.danh_sach_du_lieu.length; j++) {
                        if (this.lsTruongUpdate[i] == this.danh_sach_du_lieu[j].maTruongHoc) {
                            let obj = {
                                name: this.danh_sach_du_lieu[j].tenTruongHoc,
                                code: this.lsTruongUpdate[i]
                            }
                            this.danh_sach_truong_da_chon.push(obj)
                        }
                    }
                }
                console.log(this.danh_sach_truong_da_chon);
                loadingBind.close();
                this.modal_confirm_update = true;
            },
            chonTatCa() {
                console.log("Chọn cả:")
                console.log(this.checkAll)
                let danhsach = [];
                if (this.checkAll) {
                    for (let i = 0; i < this.danh_sach_du_lieu.length; i++) {
                        danhsach.push(this.danh_sach_du_lieu[i].maTruongHoc);
                    }
                }
                this.lsTruongUpdate = danhsach;
            },
            getTenTrangThai(e) {
                if (e == 1) {
                    return "Đang hoạt động";
                } else {
                    return "Ngừng hoạt động";
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
            getData() {
                console.log("Lấy dữ liệu");
                // this.total_rows = 0;
                this.lsTruongUpdate = [];
                this.danh_sach_du_lieu = [];
                this.duLieuTimKiem = {};
                this.modal_confirm_update = false;


                let danhsachcaphoc = []
                if (this.capHoc && this.capHoc.length > 0) {
                    for (let i = 0; i < this.capHoc.length; i++) {
                        danhsachcaphoc.push(this.capHoc[i].toString());
                    }
                }
                // if (this.truongHoc.length == 0) {
                //     this.thongBao('error', 'Vui lòng bổ sung trường học')
                //     return;
                // }
                let params = {
                    dsMaDonVi: this.donVi,
                    dsCapHoc: danhsachcaphoc,
                    dsMaTruong: this.truongHoc,
                    maSo: this.thongtin.ma_so,
                    namHoc: this.namHoc,
                    status: this.trangThai,
                };
                if (params.status != 1 && params.status != 2) {
                    params.status = null;
                }
                if (params.status == 2) {
                    params.status = 0;
                }
                if (this.thongtin.role > 2) {
                    params.dsMaDonVi = [this.thongtin.ma_don_vi]
                }
                this.duLieuTimKiem = params;
                let url = "/csdlgd-admin/yeuCauDuLieuTruong/chdbdl?start=" + this.start + "&limit=" + this.limit;
                console.log("url là:" + url)
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.total_rows = 0;
                rest_api.post(url, params, data => {
                    loading.close();
                    if (data.data.rc == 0) {
                        this.total_rows = data.data.totalRows;
                        this.danh_sach_du_lieu = data.data.tableData
                        // this.thongBao('success','Lấy dữ liệu thành công')
                        this.updateColumnWidths();
                    } else {
                        this.danh_sach_du_lieu = [];
                        this.thongBao('error', data.data.rd)
                    }
                });
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
                this.truongHoc = [];
                this.getTruongHoc();
            },
            layLaiTruongAdd() {
                this.check_confirm_come_back = true;
                this.list_truong_hoc_add = [];
                this.dataFormAdd.truongHocAdd = [];
                this.getTruongHocAdd();
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
                    console.log("Lấy đơn vị trả về:")
                    console.log(JSON.stringify(data))
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
                        if (this.thongtin.role > 2) {
                            this.donVi = [this.list_don_vi[0].maDonVi];
                            this.donViAdd = [this.list_don_vi[0].maDonVi];
                        }
                        this.getTruongHoc();
                        this.getTruongHocAdd();
                    } else {
                        this.thongBao('error', data.data.message)
                    }
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
                        this.list_truong_hoc = data_demo;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },

            getTruongHocAdd() {
                this.list_truong_hoc_add = [];
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                let params = {
                    maDonVi: this.donViAdd,
                    capHoc: this.capHocAdd,
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
                                label: data.data.rows[i].tenTruongHoc,
                            }
                            data_demo.push(obj);
                        }
                        this.list_truong_hoc_add = data_demo;
                    } else {
                        this.list_truong_hoc_add = [];
                    }
                });
            }
        }
    }

</script>
<style scoped="scoped">
    .mx-datepicker {
        width: 100% !important;
    }

    .el-switch__label * {
        padding-top: 3px !important;
    }

    .reset {
        padding: 0 !important;
    }

    h5 {
        padding: 0;
        margin: 0;
    }

</style>

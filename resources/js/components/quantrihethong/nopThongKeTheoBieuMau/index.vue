<template>
    <div>
        <Breadcrumb :menu="'Báo cáo'" :desc="'Nộp thống kê theo biểu mẫu'" />
        <div class="card-bieu-do">
            <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                <el-col :span="24">
                    <div class="table-name">Thông tin tìm kiếm</div>
                </el-col>
                <el-form ref="ruleForm">
                    <el-col :sm="12" :md="6">
                        <label>Tên báo cáo</label>
                        <el-input clearable @change="tenBaoCao = tenBaoCao.trim()" v-model="tenBaoCao"
                            placeholder="Nhập..." />
                    </el-col>
                    <el-col :sm="12" :md="6">
                        <label>Loại báo cáo</label>
                        <eselect style="width:100%" collapseTags v-model="loaiBaoCao" :placeholder="'Chọn'" filterable
                            :data="danh_sach_loai_bao_cao" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="24" class="text-center">
                        <el-button plain type="success" size="mini" @click.prevent="checkTruocKhiTim()">Tìm kiếm
                        </el-button>
                    </el-col>
                </el-form>
            </el-row>
        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <!-- <el-col :span="12">
                    <label class="table-name">Danh sách báo cáo theo biểu mẫu</label>
                </el-col>
                <el-col :span="12" class='text-right'>
                    <el-button v-if="thongtin.role!=5" class="bt-chinh" size="mini" type="primary "
                        @click.prevent="ThemYeuCau">
                        Thêm mới
                    </el-button>
                </el-col> -->
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <label class="table-name">Danh sách báo cáo theo biểu mẫu</label>
                        <div class="text-right">
                            <el-button v-if="thongtin.role!=5" class="bt-chinh" size="mini" type="primary "
                                @click.prevent="ThemYeuCau">
                                Thêm mới
                            </el-button>
                        </div>
                    </div>
                </el-col>
                <el-col :span="24">

                    <template v-if="thongtin.role==5">
                        <el-table
                                :data="list_yeu_cau"
                                fit
                                border
                                empty-text="Không có dữ liệu"
                        >
                            <!-- STT Column -->
                            <el-table-column
                                    label="STT"
                                    align="center"
                                    fixed
                                    :width="start > 9999 ? 70 : 60"
                            >
                                <template #default="scope">
                                    <p>{{ (currentPage - 1) * limit + scope.$index + 1 }}</p>
                                </template>
                            </el-table-column>

                            <!-- Thao Tác Column -->
                            <el-table-column
                                    label="Thao tác"
                                    align="center"
                                    fixed="right"
                                    width="120"
                            >
                                <template #default="scope">
                                    <el-tooltip content="Nộp dữ liệu" placement="top">
                                        <i @click.prevent="TruongNopDuLieu(scope.row)" class="el-icon-upload2"></i>
                                    </el-tooltip>
                                    <el-tooltip v-if="scope.row.daNopBaoCao" content="Xem file đã nộp" placement="top">
                                        <i @click.prevent="xemOnline(scope.row)" class="el-icon-view"></i>
                                    </el-tooltip>
                                    <el-tooltip content="Tải file đã nộp" placement="top" v-if="scope.row.daNopBaoCao">
                                        <i @click.prevent="taiXuongFileDaNop(scope.row)" class="el-icon-download"></i>
                                    </el-tooltip>
                                </template>
                            </el-table-column>

                            <!-- Tên Báo Cáo Column -->
                            <el-table-column
                                    label="Tên báo cáo"
                                    fixed
                                    :min-width="columnWidths['tenBaoCao']"
                            >
                                <template #default="scope">
                                    <p>{{ scope.row.tenBaoCao }}</p>
                                </template>
                            </el-table-column>

                            <!-- Đơn Vị Yêu Cầu Column -->
                            <el-table-column
                                    label="Đơn vị yêu cầu"
                                    :min-width="columnWidths['tenDonViTao']"
                            >
                                <template #default="scope">
                                    <p>{{ rutGonTenDonVi(scope.row.tenDonViTao) }}</p>
                                </template>
                            </el-table-column>

                            <!-- File Biểu Mẫu Column -->
                            <el-table-column
                                    label="File biểu mẫu"
                                    align="center"
                                    :min-width="columnWidths['filePath']"
                            >
                                <template #default="scope">
                                    <div v-if="scope.row.filePath">
                                        <el-tooltip content="Tải file" placement="top">
                                            <i @click.prevent="taiFile(scope.row.filePath)" class="el-icon-download"></i>
                                        </el-tooltip>
                                    </div>
                                </template>
                            </el-table-column>

                            <!-- Other Columns -->
                            <el-table-column
                                    v-for="column in dynamicColumns"
                                    :key="column.key"
                                    :label="column.label"
                                    :min-width="columnWidths[column.key]"
                            >
                                <template #default="scope">
                                    <p>{{ scope.row[column.key] }}</p>
                                </template>
                            </el-table-column>
                        </el-table>

<!--                        <div class="table-responsive">-->
<!--                            <table class="table table-bordered table-striped table-hover"-->
<!--                                style="font-size:12px; width:max-content;max-width:max-content;min-width:100%">-->
<!--                                <thead style="background: #e4ebf5">-->
<!--                                    <tr>-->
<!--                                        <th class="cg">-->
<!--                                            <p>STT</p>-->
<!--                                        </th>-->
<!--                                        <th class="cg">-->
<!--                                            <p>Thao tác</p>-->
<!--                                        </th>-->
<!--                                        <th>-->
<!--                                            <p>Tên báo cáo</p>-->
<!--                                        </th>-->
<!--                                        <th>-->
<!--                                            <p>Đơn vị yêu cầu</p>-->
<!--                                        </th>-->
<!--                                        <th>-->
<!--                                            <p>File biểu mẫu</p>-->
<!--                                        </th>-->
<!--                                        <th class="cg">-->
<!--                                            <p>Bắt đầu</p>-->
<!--                                        </th>-->
<!--                                        <th class="cg">-->
<!--                                            <p>Kết thúc</p>-->
<!--                                        </th>-->
<!--                                        <th class="cg">-->
<!--                                            <p>Trạng thái báo cáo</p>-->
<!--                                        </th>-->
<!--                                        <th class="cg">-->
<!--                                            <p>Trạng thái nộp</p>-->
<!--                                        </th>-->
<!--                                    </tr>-->
<!--                                </thead>-->
<!--                                <tbody v-if="list_yeu_cau.length==0">-->
<!--                                    <tr>-->
<!--                                        <td colspan="9" class="text-center">-->
<!--                                            <p>Không có dữ liệu</p>-->
<!--                                        </td>-->
<!--                                    </tr>-->
<!--                                </tbody>-->
<!--                                <tbody>-->
<!--                                    <tr v-for="(hs,i) in list_yeu_cau" v-bind:class="getClass(hs)">-->
<!--                                        <td class="text-center">-->
<!--                                            <p>{{ (currentPage - 1) * limit + i + 1 }}</p>-->
<!--                                        </td>-->
<!--                                        <td class="">-->
<!--                                            <el-tooltip content="Nộp dữ liệu" placement="top">-->
<!--                                                <i @click.prevent="TruongNopDuLieu(hs)" class="el-icon-upload2"></i>-->
<!--                                            </el-tooltip>-->
<!--                                            <el-tooltip v-if="hs.daNopBaoCao" content="Xem file đã nộp" placement="top">-->
<!--                                                <i @click.prevent="xemOnline(hs)" class="el-icon-view"></i>-->
<!--                                            </el-tooltip>-->
<!--                                            <el-tooltip content="Tải file đã nộp" placement="top" v-if="hs.daNopBaoCao">-->
<!--                                                <i @click.prevent="taiXuongFileDaNop(hs)" class="el-icon-download"></i>-->
<!--                                            </el-tooltip>-->
<!--                                        </td>-->
<!--                                        <td>-->
<!--                                            <p>{{ hs.tenBaoCao }}</p>-->
<!--                                        </td>-->
<!--                                        <td>-->
<!--                                            <p>{{ rutGonTenDonVi(hs.tenDonViTao) }}</p>-->
<!--                                        </td>-->
<!--                                        <td class="text-center">-->
<!--                                            <div class="text-center" v-if="hs.filePath">-->
<!--                                                <el-tooltip content="Tải file" placement="top">-->
<!--                                                    <i @click.prevent="taiFile(hs.filePath)"-->
<!--                                                        class="el-icon-download"></i>-->
<!--                                                </el-tooltip>-->

<!--                                            </div>-->
<!--                                        </td>-->
<!--                                        <td class="text-center">-->
<!--                                            <p>{{ hs.ngayApDung }}</p>-->
<!--                                        </td>-->
<!--                                        <td class="text-center">-->
<!--                                            <p>{{ hs.ngayKetThuc }}</p>-->
<!--                                        </td>-->
<!--                                        <td class="text-center">-->
<!--                                            <p v-if="hs.trangThaiBaoCao==1">Đang hoạt động</p>-->
<!--                                            <p v-else>Ngừng hoạt động</p>-->
<!--                                        </td>-->
<!--                                        <td class="text-center">-->
<!--                                            {{ hs.trangThai == 1 ? 'Đã nộp' : 'Chưa nộp' }}-->
<!--                                        </td>-->
<!--                                    </tr>-->
<!--                                </tbody>-->
<!--                            </table>-->
<!--                        </div>-->
                    </template>
                    <template v-if="thongtin.role==2||thongtin.role==3">
                        <el-table
                                :data="list_yeu_cau"
                                border
                                fit
                                max-height="600"
                                empty-text="Không có dữ liệu"
                        >
                            <!-- STT Column -->
                            <el-table-column
                                    label="STT"
                                    width="50"
                                    align="center"
                                    :width="start > 9999 ? 70 : 60"
                                    fixed
                            >
                                <template #default="{ $index }">
                                    {{ (currentPage - 1) * limit + $index + 1 }}
                                </template>
                            </el-table-column>

                            <!-- Thao tác Column -->
                            <el-table-column label="Thao tác" width="180" align="center"  fixed="right">
                                <template #default="{ row }">
                                    <el-tooltip v-if="htTruongHocNop" content="Xem danh sách đơn vị đã nộp">
                                        <i class="el-icon-view" @click.prevent="XemChiTietTruongDaNop(row)"></i>
                                    </el-tooltip>

                                    <el-tooltip content="Khóa" v-if="row.hasEditAndUploadFile && row.trangThai == 1">
                                        <i @click="Khoa(row)" class="el-icon-lock"></i>
                                    </el-tooltip>
                                    <el-tooltip content="Mở khóa" v-if="row.hasEditAndUploadFile && row.trangThai == 2">
                                        <i @click="MoKhoa(row)" class="el-icon-unlock"></i>
                                    </el-tooltip>
                                    <el-tooltip content="Chỉnh sửa" v-if="row.hasEditAndUploadFile">
                                        <i @click="ChinhSua(row)" class="el-icon-edit"></i>
                                    </el-tooltip>
                                    <el-tooltip content="Xóa" v-if="row.hasEditAndUploadFile">
                                        <i @click="Xoa(row)" class="el-icon-delete"></i>
                                    </el-tooltip>
                                    <el-tooltip v-if="row.countSchoolDone" content="Xuất Excel">
                                        <i class="el-icon-tickets" @click="TongHop(row.id)"></i>
                                    </el-tooltip>
                                    <el-tooltip v-else
                                                content="Không thực hiện được do các đơn vị chưa nộp báo cáo"
                                                placement="left">
                                        <i class="el-icon-tickets disabled"></i>
                                    </el-tooltip>
                                </template>
                            </el-table-column>

                            <el-table-column
                                    v-if="htTenBaoCao"
                                    label="Tên báo cáo"
                                    :min-width="columnWidths2.tenBaoCao"
                            >
                                <template #default="{ row }">
                                    <p>{{ row.tenBaoCao }}</p>
                                </template>
                            </el-table-column>

                            <el-table-column
                                    v-if="htDonViYeuCau"
                                    label="Đơn vị yêu cầu"
                                    :min-width="columnWidths2.donViYeuCau"
                            >
                                <template #default="{ row }">
                                    <p>{{ rutGonTenDonVi(row.tenDonViTao) }}</p>
                                </template>
                            </el-table-column>

                            <el-table-column
                                    v-if="htFileBieuMau"
                                    label="File biểu mẫu"
                                    align="center"
                                    width="130"
                            >
                                <template #default="{ row }">
                                    <el-tooltip v-if="row.filePath" content="Tải file" placement="top">
                                        <i @click.prevent="taiFile(row.filePath)" class="el-icon-download"></i>
                                    </el-tooltip>
                                    <el-tooltip v-if="row.hasEditAndUploadFile" content="Up file" placement="top">
                                        <i @click.prevent="SuaFile(row)" class="el-icon-upload2"></i>
                                    </el-tooltip>
                                </template>
                            </el-table-column>

                            <el-table-column
                                    v-if="htNgayBatDau"
                                    label="Bắt đầu"
                                    :min-width="columnWidths2.ngayBatDau"
                                    align="center"
                            >
                                <template #default="{ row }">
                                    <p>{{ row.ngayApDung }}</p>
                                </template>
                            </el-table-column>

                            <el-table-column
                                    v-if="htNgayKetThuc"
                                    label="Kết thúc"
                                    :min-width="columnWidths2.ngayKetThuc"
                                    align="center"
                            >
                                <template #default="{ row }">
                                    <p>{{ row.ngayKetThuc }}</p>
                                </template>
                            </el-table-column>

                            <el-table-column
                                    v-if="htSoTruong"
                                    label="Số đơn vị đã nộp"
                                    :min-width="columnWidths2.soTruong"
                                    align="center"
                            >
                                <template #default="{ row }">
                                    <p>{{ row.countSchoolDone }}/{{ row.countSchoolTotal }}</p>
                                </template>
                            </el-table-column>

                            <el-table-column
                                    v-if="htTrangThai"
                                    label="Trạng thái báo cáo"
                                    :min-width="180"
                                    align="center"
                            >
                                <template #default="{ row }">
                                    <p :class="getClass2(row.trangThai)">
                                        {{ row.trangThai == 1 ? 'Đang hoạt động' : 'Ngừng hoạt động' }}
                                    </p>
                                </template>
                            </el-table-column>

                        </el-table>

                    </template>
                    <div v-if="thongtin.role==4">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover"
                                style="font-size:12px; width:max-content;max-width:max-content;min-width:100%">
                                <thead style="background: #e4ebf5">
                                    <tr>
                                        <th class="cg fixed-column fixed-col1">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg" v-if="htDonViYeuCau">
                                            <p>Đơn vị yêu cầu</p>
                                        </th>
                                        <th class="cg" v-if="htTenBaoCao">
                                            <p>Tên báo cáo</p>
                                        </th>
                                        <th class="cg text-center" v-if="htFileBieuMau">
                                            <p>File biểu mẫu</p>
                                        </th>
                                        <th class="cg" v-if="htNgayBatDau">
                                            <p>Bắt đầu</p>
                                        </th>
                                        <th class="cg" v-if="htNgayKetThuc">
                                            <p>Kết thúc</p>
                                        </th>
                                        <th class="cg" v-if="htTrangThai">
                                            <p>Trạng thái báo cáo</p>
                                        </th>
                                        <th class="cg" v-if="htTrangThai">
                                            <p>Trạng thái nộp</p>
                                        </th>
                                        <th class="cg" v-if="htTruongHocNop">
                                            <p>Xem báo cáo đơn vị yêu cầu nộp</p>
                                        </th>
                                        <th class="cg" v-if="htSoTruong">
                                            <p>Số đơn vị đã nộp</p>
                                        </th>
                                        <th class="cg">
                                            <p>Hành động</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_yeu_cau.length==0">
                                    <tr>
                                        <td colspan="12" class="text-center">
                                            <p>Không có dữ liệu</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody>
                                    <tr v-for="(hs,i) in list_yeu_cau">
                                        <td class="text-center fixed-column fixed-col1">
                                            <p>{{ (currentPage - 1) * limit + i + 1 }}</p>
                                        </td>
                                        <td v-if="htDonViYeuCau">
                                            <p>{{ rutGonTenDonVi(hs.tenDonViTao) }}</p>
                                        </td>
                                        <td v-if="htTenBaoCao">
                                            <p>{{ hs.tenBaoCao }}</p>
                                        </td>
                                        <td class="text-left">
                                            <div v-if="!hs.baoCaoPhongNop">
                                                <el-tooltip v-if="hs.filePath" content="Tải file" placement="top">
                                                    <i @click.prevent="taiFile(hs.filePath)"
                                                        class="el-icon-download"></i>
                                                </el-tooltip>
                                                <el-tooltip v-if="hs.hasEditAndUploadFile" content="Up file"
                                                    placement="top">
                                                    <i @click.prevent="SuaFile(hs)" class="el-icon-upload2"></i>
                                                </el-tooltip>
                                            </div>
                                            <div v-else>
                                                <span v-if="hs.filePath">
                                                    <el-tooltip content="Tải file" placement="top">
                                                        <i @click.prevent="taiFile(hs.filePath)"
                                                            class="el-icon-download"></i>
                                                    </el-tooltip>
                                                </span>
                                                <el-tooltip v-if="hs.hasEditAndUploadFile" content="Up file"
                                                    placement="top">
                                                    <i @click.prevent="SuaFile(hs)" class="el-icon-upload2"></i>
                                                </el-tooltip>
                                            </div>

                                            <!-- </el-button> -->
                                        </td>
                                        <td v-if="htNgayBatDau">
                                            <p>{{ hs.ngayApDung }}</p>
                                        </td>
                                        <td v-if="htNgayKetThuc">
                                            <p>{{ hs.ngayKetThuc }}</p>
                                        </td>
                                        <td v-if="htTrangThai" class="text-center">
                                            <p v-bind:class="getClass2(hs.trangThai)">
                                                {{ hs.trangThai == 1 ? 'Đang hoạt động' : 'Ngừng hoạt động' }}</p>
                                        </td>
                                        <td class="text-center">
                                            <div v-if="!hs.baoCaoPhongNop">
                                            </div>
                                            <div v-else>
                                                {{ hs.daNopBaoCao ? 'Đã nộp' : 'Chưa nộp' }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <el-tooltip v-if="!hs.baoCaoPhongNop" content="Xem" placement="top">
                                                <el-button class="bt-phu" @click.prevent="XemChiTietTruongDaNop(hs)"
                                                    size="mini" type="success">
                                                    Xem báo cáo
                                                </el-button>
                                            </el-tooltip>
                                        </td>
                                        <td class="cg" v-if="htSoTruong">
                                            <p>{{ hs.countSchoolDone }}/{{ hs.countSchoolTotal }}</p>
                                        </td>

                                        <td class="text-left">
                                            <!--  -->
                                            <div v-if="!hs.baoCaoPhongNop">
                                                <el-tooltip v-if="hs.countSchoolDone>0" content="Xuất excel">
                                                    <i class="el-icon-tickets " @click="TongHop(hs.id)"></i>
                                                </el-tooltip>

                                                <el-tooltip v-else
                                                    content="Không thực hiện được do các đơn vị chưa nộp báo cáo"
                                                    placement="left">
                                                    <i class="el-icon-tickets disabled"></i>
                                                </el-tooltip>
                                                <el-tooltip content="Khóa"
                                                    v-if="hs.hasEditAndUploadFile&&hs.trangThai==1">
                                                    <i @click="Khoa(hs)" class="el-icon-lock "></i>
                                                </el-tooltip>
                                                <el-tooltip content="Mở khóa"
                                                    v-if="hs.hasEditAndUploadFile&&hs.trangThai==2">
                                                    <i @click="MoKhoa(hs)" class="el-icon-unlock "></i>
                                                </el-tooltip>
                                                <el-tooltip content="Chỉnh sửa" v-if="hs.hasEditAndUploadFile">
                                                    <i @click="ChinhSua(hs)" class="el-icon-edit "></i>
                                                </el-tooltip>
                                                <el-tooltip content="Xóa" v-if="hs.hasEditAndUploadFile">
                                                    <i @click="Xoa(hs)" class="el-icon-delete "></i>
                                                </el-tooltip>
                                            </div>
                                            <div v-else>
                                                <!-- <el-button v-if="hs.daNopBaoCao" style="margin:5px;"
                                                @click.prevent="taiXuongFileDaNop(hs)" size="mini" type="success">Tải
                                                file
                                                đã nộp
                                            </el-button> -->
                                                <!-- <el-button v-if="hs.daNopBaoCao" style="margin:5px;"
                                                @click.prevent="xemOnline(hs)" size="mini" type="info">Xem file đã nộp
                                            </el-button> -->

                                                <el-tooltip content="Nộp dữ liệu" placement="top">
                                                    <i @click.prevent="TruongNopDuLieu(hs)" class="el-icon-upload2"></i>
                                                </el-tooltip>
                                                <el-tooltip content="Xem file đã nộp" v-if="hs.daNopBaoCao"
                                                    placement="top">
                                                    <i @click.prevent="xemOnline(hs)" class="el-icon-view"></i>
                                                </el-tooltip>
                                                <el-tooltip content="Tải file đã nộp" placement="top"
                                                    v-if="hs.daNopBaoCao">
                                                    <i @click.prevent="taiXuongFileDaNop(hs)"
                                                        class="el-icon-download"></i>
                                                </el-tooltip>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </el-col>
                <el-col :span="24">
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                </el-col>
            </el-row>
        </div>
        <div v-if="false" class="panel panel-default">
            <div class="panel-body">
                <!-- Button thao tác -->
                <div class="row pxn-bao-header">
                    <div class="col-md-5 text-left">
                        <!-- <b> Chú thích:</b>
                        <div style="width:20px; height:15px; background:#f3cccc;display:inline-block"></div>: Yêu cầu đã
                        hết hạn.
                        <div style="width:20px; height:15px; background:#AFFDD9;display:inline-block"></div>: Chưa tới
                        thời hạn nộp -->
                    </div>
                    <div class="col-md-7 text-right" v-if="thongtin.role!=5">
                        <!-- <el-button type="info" size="mini" data-toggle="collapse" data-target="#tuychonhienthi">Tùy chọn
                            hiển
                            thị
                        </el-button> -->
                        <el-button class="bt-chinh" size="mini" type="primary " @click.prevent="ThemYeuCau">
                            Thêm mới
                        </el-button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="tuychonhienthi" class="collapse">
                            <input v-model="htTenBaoCao" type="checkbox" />
                            <span>Tên báo cáo</span>
                            <input v-model="htTrangThai" type="checkbox" />
                            <span>Trạng thái</span>
                            <input v-model="htDonViYeuCau" type="checkbox" />
                            <span>Đơn vị yêu cầu</span>
                            <input v-model="htTruongHocNop" type="checkbox" />
                            <span>Trường học nộp</span>
                            <input v-model="htFileBieuMau" type="checkbox" />
                            <span>File biểu mẫu</span>
                            <input v-model="htNgayBatDau" type="checkbox" />
                            <span>Ngày bắt đầu</span>
                            <input v-model="htNgayKetThuc" type="checkbox" />
                            <span>Ngày kết thúc</span>
                            <input v-model="htSoTruong" type="checkbox" />
                            <span>Số trường đã nộp</span>
                        </div>
                    </div>
                </div>
                <!-- hết button -->
                <!-- Bảng của trường -->
                <div style="min-height:50%" v-if="thongtin.role==5">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover"
                            style="font-size:12px; width:max-content;max-width:max-content;min-width:100%">
                            <thead style="background: #e4ebf5">
                                <tr>
                                    <th class="cg">
                                        <p>STT</p>
                                    </th>
                                    <th class="cg">
                                        <p>Thao tác</p>
                                    </th>
                                    <th>
                                        <p>Tên báo cáo</p>
                                    </th>
                                    <th>
                                        <p>Đơn vị yêu cầu</p>
                                    </th>
                                    <th>
                                        <p>File biểu mẫu</p>
                                    </th>
                                    <th class="cg">
                                        <p>Bắt đầu</p>
                                    </th>
                                    <th class="cg">
                                        <p>Kết thúc</p>
                                    </th>
                                    <th class="cg">
                                        <p>Trạng thái báo cáo</p>
                                    </th>
                                    <th class="cg">
                                        <p>Trạng thái nộp</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_yeu_cau.length==0">
                                <tr>
                                    <td colspan="9" class="text-center">
                                        <p>Không có dữ liệu</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr v-for="(hs,i) in list_yeu_cau" v-bind:class="getClass(hs)">
                                    <td class="text-center">
                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>
                                    </td>
                                    <td class="">
                                        <el-tooltip content="Nộp dữ liệu" placement="top">
                                            <i @click.prevent="TruongNopDuLieu(hs)" class="el-icon-upload2"></i>
                                        </el-tooltip>
                                        <el-tooltip v-if="hs.daNopBaoCao" content="Xem file đã nộp" placement="top">
                                            <i @click.prevent="xemOnline(hs)" class="el-icon-view"></i>
                                        </el-tooltip>
                                        <el-tooltip content="Tải file đã nộp" placement="top" v-if="hs.daNopBaoCao">
                                            <i @click.prevent="taiXuongFileDaNop(hs)" class="el-icon-download"></i>
                                        </el-tooltip>
                                    </td>
                                    <td>
                                        <p>{{ hs.tenBaoCao }}</p>
                                    </td>
                                    <td>
                                        <p>{{ rutGonTenDonVi(hs.tenDonViTao) }}</p>
                                    </td>
                                    <td class="text-center">
                                        <div class="text-center" v-if="hs.filePath">
                                            <el-tooltip content="Tải file" placement="top">
                                                <i @click.prevent="taiFile(hs.filePath)" class="el-icon-download"></i>
                                            </el-tooltip>

                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ hs.ngayApDung }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ hs.ngayKetThuc }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p v-if="hs.trangThaiBaoCao==1">Đang hoạt động</p>
                                        <p v-else>Ngừng hoạt động</p>
                                    </td>
                                    <td class="text-center">
                                        {{ hs.trangThai == 1 ? 'Đã nộp' : 'Chưa nộp' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                </div>
                <!-- hết bảng của trường -->
                <!-- Bảng của admin sở -->
                <div v-if="thongtin.role==2||thongtin.role==3">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover"
                            style="width:max-content;max-width:max-content;min-width:100%">
                            <thead style="background: #e4ebf5">
                                <tr>
                                    <th class="cg fixed-column fixed-col1">
                                        <p>STT</p>
                                    </th>
                                    <th class="cg">
                                        <p>Thao tác</p>
                                    </th>
                                    <th v-if="htDonViYeuCau">
                                        <p>Đơn vị yêu cầu</p>
                                    </th>
                                    <th v-if="htTenBaoCao">
                                        <p>Tên báo cáo</p>
                                    </th>
                                    <th v-if="htFileBieuMau">
                                        <p>File biểu mẫu</p>
                                    </th>
                                    <th class="cg" v-if="htNgayBatDau">
                                        <p>Bắt đầu</p>
                                    </th>
                                    <th class="cg" v-if="htNgayKetThuc">
                                        <p>Kết thúc</p>
                                    </th>
                                    <th class="cg" v-if="htSoTruong">
                                        <p>Số đơn vị đã nộp</p>
                                    </th>
                                    <th class="cg" v-if="htTrangThai">
                                        <p>Trạng thái báo cáo</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_yeu_cau.length==0">
                                <tr>
                                    <td colspan="12" class="text-center">
                                        <p>Không có dữ liệu</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr v-for="(hs,i) in list_yeu_cau">
                                    <td class="text-center fixed-column fixed-col1">
                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>
                                    </td>
                                    <td class="text-center">
                                        <el-tooltip v-if="htTruongHocNop" content="Xem danh sách đơn vị đã nộp"
                                            placement="top">
                                            <i @click.prevent="XemChiTietTruongDaNop(hs)" class="el-icon-view"></i>
                                        </el-tooltip>
                                        <el-dropdown v-if="false" trigger="click">
                                            <!-- <el-button size="mini" type="primary"> -->
                                            <i class="el-icon-arrow-down el-icon--right"></i>
                                            <!-- </el-button> -->
                                            <el-dropdown-menu v-if="false" slot="dropdown">
                                                <el-dropdown-item>
                                                    <p @click="TongHop(hs.id)"><i class="el-icon-download "></i>Tổng
                                                        hợp</p>
                                                </el-dropdown-item>
                                                <el-dropdown-item v-if="hs.hasEditAndUploadFile&&hs.trangThai==1">
                                                    <p @click="Khoa(hs)"><i class="el-icon-lock "></i>Khóa</p>
                                                </el-dropdown-item>
                                                <el-dropdown-item v-if="hs.hasEditAndUploadFile&&hs.trangThai==2">
                                                    <p @click="MoKhoa(hs)"><i class="el-icon-unlock "></i>Mở khóa</p>
                                                </el-dropdown-item>
                                                <el-dropdown-item v-if="hs.hasEditAndUploadFile">
                                                    <p @click="ChinhSua(hs)"><i class="el-icon-edit "></i>Chỉnh sửa</p>
                                                </el-dropdown-item>
                                                <el-dropdown-item v-if="hs.hasEditAndUploadFile">
                                                    <p @click="Xoa(hs)"><i class="el-icon-delete "></i>Xóa</p>
                                                </el-dropdown-item>
                                            </el-dropdown-menu>
                                        </el-dropdown>
                                        <!--  -->
                                        <el-tooltip v-if="hs.countSchoolDone" content="Xuất excel">
                                            <i class="el-icon-tickets " @click="TongHop(hs.id)"></i>
                                        </el-tooltip>

                                        <el-tooltip v-else content="Không thực hiện được do các đơn vị chưa nộp báo cáo"
                                            placement="left">
                                            <i class="el-icon-tickets disabled"></i>
                                        </el-tooltip>
                                        <el-tooltip content="Khóa" v-if="hs.hasEditAndUploadFile&&hs.trangThai==1">
                                            <i @click="Khoa(hs)" class="el-icon-lock "></i>
                                        </el-tooltip>
                                        <el-tooltip content="Mở khóa" v-if="hs.hasEditAndUploadFile&&hs.trangThai==2">
                                            <i @click="MoKhoa(hs)" class="el-icon-unlock "></i>
                                        </el-tooltip>
                                        <el-tooltip content="Chỉnh sửa" v-if="hs.hasEditAndUploadFile">
                                            <i @click="ChinhSua(hs)" class="el-icon-edit "></i>
                                        </el-tooltip>
                                        <el-tooltip content="Xóa" v-if="hs.hasEditAndUploadFile">
                                            <i @click="Xoa(hs)" class="el-icon-delete "></i>
                                        </el-tooltip>

                                        <!--  -->


                                        <!-- <el-button size="mini" type="primary" title="Tải xuống file tổng hợp"
                                        @click="TongHop(hs.id)">
                                        <i class="el-icon-download"></i>
                                    </el-button>
                                    <el-button v-if="hs.hasEditAndUploadFile&&hs.trangThai==1" size="mini" type="danger" title="Khóa"
                                        @click="Khoa(hs)">
                                        <i class="el-icon-lock"></i>
                                    </el-button>
                                    <el-button v-else size="mini"  disabled title="Khóa">
                                        <i class="el-icon-lock"></i>
                                    </el-button>
                                    <el-button v-if="hs.hasEditAndUploadFile&&hs.trangThai==2" size="mini" type="success" title="Mở Khóa"
                                        @click="MoKhoa(hs)">
                                        <i class="el-icon-unlock"></i>
                                    </el-button>
                                    <el-button v-else size="mini"  disabled title="Mở khóa">
                                        <i class="el-icon-unlock"></i>
                                    </el-button>
                                    <el-button v-if="hs.hasEditAndUploadFile" size="mini" type="danger" title="Xóa"
                                        @click="Xoa(hs)">
                                        <i class="el-icon-delete"></i>
                                    </el-button>
                                    <el-button v-else size="mini"  disabled title="Xóa">
                                        <i class="el-icon-delete"></i>
                                    </el-button>
                                    <el-button v-if="hs.hasEditAndUploadFile" size="mini" type="warning" title="Chỉnh sửa"
                                        @click="ChinhSua(hs)">
                                        <i class="el-icon-edit"></i>
                                    </el-button>
                                    <el-button v-else size="mini"  disabled title="Chỉnh sửa">
                                        <i class="el-icon-edit"></i>
                                    </el-button> -->
                                    </td>
                                    <td v-if="htDonViYeuCau">
                                        <p>{{ rutGonTenDonVi(hs.tenDonViTao) }}</p>
                                    </td>
                                    <td v-if="htTenBaoCao">
                                        <p>{{ hs.tenBaoCao }}</p>
                                    </td>
                                    <td v-if="htFileBieuMau" class="text-left">
                                        <span v-if="hs.filePath">
                                            <!-- <el-button size="mini" type="success"
                                                title="Tải file"> -->
                                            <el-tooltip content="Tải file" placement="top">
                                                <i @click.prevent="taiFile(hs.filePath)" class="el-icon-download"></i>
                                            </el-tooltip>
                                            <!-- </el-button> -->
                                        </span>
                                        <!-- <span v-else>
                                        <el-button size="mini" type="default" disabled
                                            title="Chưa có file biểu mẫu.">
                                            <i class="fas fa-download"></i>
                                        </el-button>
                                    </span> -->
                                        <!-- <el-button size="mini" v-if="hs.hasEditAndUploadFile" type="info"
                                        title="Chỉnh sửa" > -->
                                        <!-- <el-tooltip content="Up file" placement="top">
                                        <i v-if="hs.hasEditAndUploadFile" @click="SuaFile(hs)"
                                            class="fas fa-upload"></i>
                                    </el-tooltip> -->

                                        <el-tooltip v-if="hs.hasEditAndUploadFile" content="Up file" placement="top">
                                            <i @click.prevent="SuaFile(hs)" class="el-icon-upload2"></i>
                                        </el-tooltip>

                                        <!-- </el-button> -->
                                    </td>
                                    <td class="text-center" v-if="htNgayBatDau">
                                        <p>{{ hs.ngayApDung }}</p>
                                    </td>
                                    <td class="text-center" v-if="htNgayKetThuc">
                                        <p>{{ hs.ngayKetThuc }}</p>
                                    </td>
                                    <td class="cg" v-if="htSoTruong">
                                        <p>{{ hs.countSchoolDone }}/{{ hs.countSchoolTotal }}</p>
                                    </td>
                                    <td v-if="htTrangThai" class="text-center">
                                        <p v-bind:class="getClass2(hs.trangThai)">
                                            {{ hs.trangThai == 1 ? 'Đang hoạt động' : 'Ngừng hoạt động' }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                </div>
                <div v-if="thongtin.role==4">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover"
                            style="font-size:12px; width:max-content;max-width:max-content;min-width:100%">
                            <thead style="background: #e4ebf5">
                                <tr>
                                    <th class="cg fixed-column fixed-col1">
                                        <p>STT</p>
                                    </th>
                                    <th class="cg" v-if="htDonViYeuCau">
                                        <p>Đơn vị yêu cầu</p>
                                    </th>
                                    <th class="cg" v-if="htTenBaoCao">
                                        <p>Tên báo cáo</p>
                                    </th>
                                    <th class="cg text-center" v-if="htFileBieuMau">
                                        <p>File biểu mẫu</p>
                                    </th>
                                    <th class="cg" v-if="htNgayBatDau">
                                        <p>Bắt đầu</p>
                                    </th>
                                    <th class="cg" v-if="htNgayKetThuc">
                                        <p>Kết thúc</p>
                                    </th>
                                    <th class="cg" v-if="htTrangThai">
                                        <p>Trạng thái báo cáo</p>
                                    </th>
                                    <th class="cg" v-if="htTrangThai">
                                        <p>Trạng thái nộp</p>
                                    </th>
                                    <th class="cg" v-if="htTruongHocNop">
                                        <p>Xem báo cáo đơn vị yêu cầu nộp</p>
                                    </th>
                                    <th class="cg" v-if="htSoTruong">
                                        <p>Số đơn vị đã nộp</p>
                                    </th>
                                    <th class="cg">
                                        <p>Hành động</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="list_yeu_cau.length==0">
                                <tr>
                                    <td colspan="12" class="text-center">
                                        <p>Không có dữ liệu</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody>
                                <tr v-for="(hs,i) in list_yeu_cau">
                                    <td class="text-center fixed-column fixed-col1">
                                        <p>{{ (currentPage - 1) * limit + i + 1 }}</p>
                                    </td>
                                    <td v-if="htDonViYeuCau">
                                        <p>{{ rutGonTenDonVi(hs.tenDonViTao) }}</p>
                                    </td>
                                    <td v-if="htTenBaoCao">
                                        <p>{{ hs.tenBaoCao }}</p>
                                    </td>
                                    <td class="text-left">
                                        <div v-if="!hs.baoCaoPhongNop">
                                            <el-tooltip v-if="hs.filePath" content="Tải file" placement="top">
                                                <i @click.prevent="taiFile(hs.filePath)" class="el-icon-download"></i>
                                            </el-tooltip>
                                            <el-tooltip v-if="hs.hasEditAndUploadFile" content="Up file"
                                                placement="top">
                                                <i @click.prevent="SuaFile(hs)" class="el-icon-upload2"></i>
                                            </el-tooltip>
                                        </div>
                                        <div v-else>
                                            <span v-if="hs.filePath">
                                                <el-tooltip content="Tải file" placement="top">
                                                    <i @click.prevent="taiFile(hs.filePath)"
                                                        class="el-icon-download"></i>
                                                </el-tooltip>
                                            </span>
                                            <el-tooltip v-if="hs.hasEditAndUploadFile" content="Up file"
                                                placement="top">
                                                <i @click.prevent="SuaFile(hs)" class="el-icon-upload2"></i>
                                            </el-tooltip>
                                        </div>

                                        <!-- </el-button> -->
                                    </td>
                                    <td v-if="htNgayBatDau">
                                        <p>{{ hs.ngayApDung }}</p>
                                    </td>
                                    <td v-if="htNgayKetThuc">
                                        <p>{{ hs.ngayKetThuc }}</p>
                                    </td>
                                    <td v-if="htTrangThai" class="text-center">
                                        <p v-bind:class="getClass2(hs.trangThai)">
                                            {{ hs.trangThai == 1 ? 'Đang hoạt động' : 'Ngừng hoạt động' }}</p>
                                    </td>
                                    <td class="text-center">
                                        <div v-if="!hs.baoCaoPhongNop">
                                        </div>
                                        <div v-else>
                                            {{ hs.daNopBaoCao ? 'Đã nộp' : 'Chưa nộp' }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <el-tooltip v-if="!hs.baoCaoPhongNop" content="Xem" placement="top">
                                            <el-button class="bt-phu" @click.prevent="XemChiTietTruongDaNop(hs)"
                                                size="mini" type="success">
                                                Xem báo cáo
                                            </el-button>
                                        </el-tooltip>
                                    </td>
                                    <td class="cg" v-if="htSoTruong">
                                        <p>{{ hs.countSchoolDone }}/{{ hs.countSchoolTotal }}</p>
                                    </td>

                                    <td class="text-left">
                                        <!--  -->
                                        <div v-if="!hs.baoCaoPhongNop">
                                            <el-tooltip v-if="hs.countSchoolDone>0" content="Xuất excel">
                                                <i class="el-icon-tickets " @click="TongHop(hs.id)"></i>
                                            </el-tooltip>

                                            <el-tooltip v-else
                                                content="Không thực hiện được do các đơn vị chưa nộp báo cáo"
                                                placement="left">
                                                <i class="el-icon-tickets disabled"></i>
                                            </el-tooltip>
                                            <el-tooltip content="Khóa" v-if="hs.hasEditAndUploadFile&&hs.trangThai==1">
                                                <i @click="Khoa(hs)" class="el-icon-lock "></i>
                                            </el-tooltip>
                                            <el-tooltip content="Mở khóa"
                                                v-if="hs.hasEditAndUploadFile&&hs.trangThai==2">
                                                <i @click="MoKhoa(hs)" class="el-icon-unlock "></i>
                                            </el-tooltip>
                                            <el-tooltip content="Chỉnh sửa" v-if="hs.hasEditAndUploadFile">
                                                <i @click="ChinhSua(hs)" class="el-icon-edit "></i>
                                            </el-tooltip>
                                            <el-tooltip content="Xóa" v-if="hs.hasEditAndUploadFile">
                                                <i @click="Xoa(hs)" class="el-icon-delete "></i>
                                            </el-tooltip>
                                        </div>
                                        <div v-else>
                                            <!-- <el-button v-if="hs.daNopBaoCao" style="margin:5px;"
                                            @click.prevent="taiXuongFileDaNop(hs)" size="mini" type="success">Tải
                                            file
                                            đã nộp
                                        </el-button> -->
                                            <!-- <el-button v-if="hs.daNopBaoCao" style="margin:5px;"
                                            @click.prevent="xemOnline(hs)" size="mini" type="info">Xem file đã nộp
                                        </el-button> -->

                                            <el-tooltip content="Nộp dữ liệu" placement="top">
                                                <i @click.prevent="TruongNopDuLieu(hs)" class="el-icon-upload2"></i>
                                            </el-tooltip>
                                            <el-tooltip content="Xem file đã nộp" v-if="hs.daNopBaoCao" placement="top">
                                                <i @click.prevent="xemOnline(hs)" class="el-icon-view"></i>
                                            </el-tooltip>
                                            <el-tooltip content="Tải file đã nộp" placement="top" v-if="hs.daNopBaoCao">
                                                <i @click.prevent="taiXuongFileDaNop(hs)" class="el-icon-download"></i>
                                            </el-tooltip>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                </div>
                <!-- hết bảng của admin sở -->
            </div>
        </div>

        <el-dialog title="Chi tiết" top="5vh" :visible.sync="chitiet_truongdanop" width="80%"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
            <form>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <span class="table-name">Danh sách đơn vị đã nộp</span>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover"
                                style="font-size:16px; ">
                                <thead>
                                    <tr style="background: #e4ebf5; text-align:center">
                                        <th class="text-center">STT</th>
                                        <th >Tên đơn vị</th>
                                        <th >Mã đơn vị</th>
                                        <th class="text-center">Trạng thái nộp</th>
                                        <th class="text-center">File đã nộp</th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_don_vi_da_nop.length==0">
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <p>Không có dữ liệu</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item, j) in list_don_vi_da_nop">
                                        <td class="text-center">{{ j + 1 }}</td>
                                        <td>{{ item.tenTruongHoc ?? item.tenDonVi }}</td>
                                        <td>{{ item.maTruongHoc ?? item.maDonVi }}</td>
                                        <td class="text-center">
                                            <template v-if="item.trangThai == 0">
                                                Chưa nộp
                                            </template>
                                            <template v-else>
                                                Đã nộp
                                            </template>
                                        </td>
                                        <td class="text-center">
                                            <div v-if="item.trangThai==1">
                                                <el-button class="bt-phu" size="mini"
                                                    @click.prevent="XemFileYeuCau(item)" type="success">Xem
                                                    trước file
                                                </el-button>
                                                <el-button class="bt-phu" size="mini"
                                                    @click.prevent="taiXuongFileTruong(item)" type="info">Tải
                                                    xuống
                                                </el-button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <el-tabs v-if="false" type="border-card2">
                            <el-tab-pane>
                            </el-tab-pane>
                        </el-tabs>
                    </el-col>
                </el-row>
            </form>
            <span slot="footer" class="dialog-footer">
                <el-button class="bt-chinh" type="primary" @click="taiXuongFileExcel()" size="mini">Tải xuống</el-button>
                <el-button class="bt-phu" type="default" @click="handleClose" size="mini">Đóng</el-button>
            </span>
        </el-dialog>
        <div id="chitiet_truongdanop" ref="chitiet_truongdanop" class="modal fade">
            <div class="modal-dialog" style="width: 90%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chi tiết
                        </h4>
                    </div>
                    <div class="modal-body">
                        <!-- -->

                        <el-tabs type="border-card2">
                            <!-- <el-tab-pane>
                                <span slot="label">1. Đơn vị được yêu cầu</span>
                                <div style="height:55%; overflow:auto">
                                    <table class="table table-striped table-bordered table-hover"
                                        style="font-size:12px; ">
                                        <thead>
                                            <tr style="background: #e4ebf5; text-align:center">
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Tên đơn vị</th>
                                                <th class="text-center">Mã đơn vị</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_don_vi_da_nop.length==0">
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <p>Không có dữ liệu</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item, j) in list_don_vi_da_nop">
                                                <td class="text-center">{{ j + 1 }}</td>
                                                <td>{{ item.tenDonVi }}</td>
                                                <td class="text-center">{{ item.maDonVi }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </el-tab-pane> -->

                            <el-tab-pane>
                                <span slot="label">1. Thông tin chi tiết</span>

                                <div style="height:55%; overflow:auto">
                                    <table class="table table-striped table-bordered table-hover"
                                        style="font-size:12px; ">
                                        <thead>
                                            <tr style="background: #e4ebf5; text-align:center">
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Tên trường</th>
                                                <th class="text-center">Mã trường</th>
                                                <th class="text-center">Trạng thái nộp</th>
                                                <th class="text-center">File đã nộp</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_truong_da_nop.length==0">
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <p>Không có dữ liệu</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <!-- list_truong_da_nop -->
                                            <tr v-for="(item, j) in list_truong_da_nop">
                                                <td class="text-center">{{ j + 1 }}</td>
                                                <td>{{ item.tenTruongHoc ?? item.tenDonVi }}</td>
                                                <td class="text-center">{{ item.maTruongHoc ?? item.maDonVi }}</td>
                                                <td class="text-center">
                                                    <template v-if="item.trangThai == 0">
                                                        Chưa nộp
                                                    </template>
                                                    <template v-else>
                                                        Đã nộp
                                                    </template>
                                                </td>
                                                <td class="text-center">
                                                    <div v-if="item.trangThai==1">
                                                        <el-button class="bt-phu" size="mini"
                                                            @click.prevent="XemFileYeuCau(item)" type="success">Xem
                                                            trước file
                                                        </el-button>
                                                        <el-button class="bt-phu" size="mini"
                                                            @click.prevent="taiXuongFileTruong(item)" type="info">Tải
                                                            xuống
                                                        </el-button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                        <ul v-if="false" class="nav nav-tabs">
                            <li class="active" style="display:none">
                                <a data-toggle="tab" href="#home">Đơn vị được yêu cầu</a>
                            </li>
                            <li class="active">
                                <!-- <a data-toggle="tab" href="#menu1">Trường học được yêu cầu</a> -->
                                <a data-toggle="tab" href="#menu1">Đơn vị được yêu cầu</a>
                            </li>
                        </ul>
                        <div v-if="false" class="tab-content" style="padding-top:15px">
                            <div id="home" style="display:none" class="tab-pane fade in active">
                                <div style="height:55%; overflow:auto">
                                    <table class="table table-striped table-bordered table-hover"
                                        style="font-size:12px; ">
                                        <thead>
                                            <tr style="background: #e4ebf5; text-align:center">
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Tên đơn vị</th>
                                                <th class="text-center">Mã đơn vị</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_don_vi_da_nop.length==0">
                                            <tr>
                                                <td colspan="3" class="text-center">
                                                    <p>Không có dữ liệu</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else="v-else">
                                            <!-- list_truong_da_nop -->
                                            <tr v-for="(item, j) in list_don_vi_da_nop">
                                                <td class="text-center">{{ j + 1 }}</td>
                                                <td>{{ item.tenDonVi }}</td>
                                                <td class="text-center">{{ item.maDonVi }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="menu1" class="tab-pane fade in active">
                                <div style="height:55%; overflow:auto">
                                    <table class="table table-striped table-bordered table-hover"
                                        style="font-size:12px; ">
                                        <thead>
                                            <tr style="background: #e4ebf5; text-align:center">
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Tên đơn vị</th>
                                                <th class="text-center">Mã đơn vị</th>
                                                <th class="text-center">Trạng thái nộp</th>
                                                <th class="text-center">File đã nộp</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_truong_da_nop.length==0">
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <p>Không có dữ liệu</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else="v-else">
                                            <!-- list_truong_da_nop -->
                                            <tr v-for="(item, j) in list_truong_da_nop">
                                                <td class="text-center">{{ j + 1 }}</td>
                                                <td>{{ item.tenTruongHoc }}</td>
                                                <td class="text-center">{{ item.maTruongHoc }}</td>
                                                <td class="text-center">
                                                    <template v-if="item.trangThai == 0">
                                                        Chưa nộp
                                                    </template>
                                                    <template v-else="v-else">
                                                        Đã nộp
                                                    </template>
                                                </td>
                                                <td class="text-center">
                                                    <div v-if="item.trangThai==1">
                                                        <el-button class="bt-chinh" size="mini"
                                                            @click.prevent="XemFileYeuCau(item)" type="primary">Xem báo
                                                            cáo
                                                        </el-button>
                                                        <el-button class="bt-chinh" size="mini"
                                                            @click.prevent="taiXuongFileTruong(item)" type="success">
                                                            Xuất excel
                                                        </el-button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- -->
                    </div>
                    <div class="modal-footer clearfix">
                        <el-button class="bt-phu" type="default" size="mini" data-dismiss="modal">Đóng
                        </el-button>
                    </div>
                </div>

            </div>

        </div>
        <!-- hết danh sách -->
        <!-- Kết thúc template -->
        <!-- Pop up thêm mới -->

        <!-- <div v-if="show_themmoi"> -->
        <ThemMoi :show="show_themmoi" @close="show_themmoi=false" @done="doneCreated()"></ThemMoi>
        <!-- </div> -->
        <!-- end popup -->
        <div v-if="show_excel">
            <XemBaoCao :item="this.link_xem_chi_tiet" @close="show_excel=false"></XemBaoCao>
        </div>
        <!-- popup chỉnh sửa -->

        <!-- <div v-if="show_chinhsua"> -->
        <ChinhSua :show="show_chinhsua" :item="thongTinBanGhi" @close="show_chinhsua=false" @done="getData">
        </ChinhSua>
        <!-- </div> -->

        <template>
            <upLoadFile @close="show_file=false" :show="show_file" :banghi="thongTinYeuCau"
                @doneUpLoadFile="doneUpLoadFile()">
            </upLoadFile>
        </template>
    </div>
</template>
<script>
    import rest_api from '../../../utils/rest_api';
    import constant from "../../../utils/constant";
    import timeutils from "../../../utils/time_utils";
    import ElementUI from 'element-ui';
    import api from '../../api';
    import utils from '../../../utils'
    import VueAlertify from 'vue-alertify';
    import moment from "moment";
    import ThemMoi from './themMoi';
    import XemBaoCao from './../XemThongTinTruongNopBieuMau';
    import ChinhSua from './../ChinhSuaYeuCauNopThongKeTheoBieuMau';
    import Page from '../../ui/PagingCustom';
    import ESelectVue from '../../ui/ESelect.vue';
    import upLoadFile from './upLoadFile';
    import Breadcrumb from '../../ui/Breadcrumb.vue';

    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {

        components: {
            ThemMoi: ThemMoi,
            ChinhSua: ChinhSua,
            upLoadFile: upLoadFile,
            XemBaoCao: XemBaoCao,
            Page: Page,
            'eselect': ESelectVue,
            Breadcrumb
        },

        computed: {},
        props: [],

        data() {

            return {
                columnWidths2: {
                    tenBaoCao: 200,    // Default width for the "Tên báo cáo" column
                    donViYeuCau: 150,  // Default width for the "Đơn vị yêu cầu" column
                    fileBieuMau: 150,  // Default width for the "File biểu mẫu" column
                    ngayBatDau: 150,   // Default width for the "Bắt đầu" column
                    ngayKetThuc: 150,  // Default width for the "Kết thúc" column
                    soTruong: 150,     // Default width for the "Số đơn vị đã nộp" column
                    trangThai: 150,    // Default width for the "Trạng thái báo cáo" column
                },
                columnWidths: {}, // Object to store calculated widths
                dynamicColumns: [
                    { label: "Bắt đầu", key: "ngayApDung" },
                    { label: "Kết thúc", key: "ngayKetThuc" },
                    { label: "Trạng thái báo cáo", key: "trangThaiBaoCao" },
                    { label: "Trạng thái nộp", key: "trangThai" },
                ],

                chitiet_truongdanop: false,
                // Tùy chỉnh hiển thị
                link_xem_chi_tiet: "",
                thongTinYeuCau: {},
                thongtin: JSON.parse(window.userInfo),
                show_excel: false,
                htTenBaoCao: true,
                htTrangThai: true,
                htDonViYeuCau: true,
                htTruongHocNop: true,
                htFileBieuMau: true,
                htNgayBatDau: true,
                htNgayKetThuc: true,
                htSoTruong: true,
                // thêm mới
                date: new Date(),
                homNay: "",
                show_themmoi: false,
                show_file: false,
                show_chinhsua: false,
                thongTinBanGhi: {},
                loaiBaoCao: "",
                tenBaoCao: "",
                list_yeu_cau: [],
                list_truong_da_nop: [],
                list_don_vi_da_nop: [],
                idBaoCao: null,
                start: 0,
                currentPage: 1,
                limit: 25,
                total_rows: 0,
                trangbatdau: false,
                baseLink: "/view-excel?path=",
                danh_sach_loai_bao_cao: [{
                        name: "Báo cáo cộng dồn",
                        value: 0
                    },
                    {
                        name: "Báo cáo lặp dòng",
                        value: 1
                    },
                ],
            }
        },

        mounted() {
            // gán thông tin đăng nhập
            this.homNay = this.getTime(this.date);
            this.getData();
            this.calculateColumnWidths();
        },

        watch: {
            list_yeu_cau:{
                handler(){
                    this.calculateColumnWidths()
                },
                deep: true
            }

        },

        methods: {
            calculateColumnWidths2() {
                this.list_yeu_cau.forEach(row => {
                    // Calculate widths dynamically based on content
                    this.columnWidths2.tenBaoCao = Math.max(this.columnWidths2.tenBaoCao, row.tenBaoCao.length * 10);
                    this.columnWidths2.donViYeuCau = Math.max(this.columnWidths2.donViYeuCau, row.tenDonViTao.length * 10);
                    this.columnWidths2.fileBieuMau = Math.max(this.columnWidths2.fileBieuMau, row.filePath ? row.filePath.length * 10 : 150);
                    this.columnWidths2.ngayBatDau = Math.max(this.columnWidths2.ngayBatDau, row.ngayApDung.length * 10);
                    this.columnWidths2.ngayKetThuc = Math.max(this.columnWidths2.ngayKetThuc, row.ngayKetThuc.length * 10);
                    this.columnWidths2.soTruong = Math.max(this.columnWidths2.soTruong, row.countSchoolDone.toString().length * 10);
                    this.columnWidths2.trangThai = Math.max(this.columnWidths2.trangThai, row.trangThai == 1 ? 15 : 18);  // Example for "Trạng thái"
                });
            },
            calculateColumnWidths() {
                // Example logic to calculate min-width dynamically
                const sampleData = [...this.list_yeu_cau, { tenBaoCao: "Tên báo cáo" }]; // Include headers for calculation

                this.columnWidths = {
                    stt: "60px",
                    thaoTac: "150px",
                    tenBaoCao: this.getDynamicMinWidth(sampleData, "tenBaoCao"),
                    tenDonViTao: this.getDynamicMinWidth(sampleData, "tenDonViTao"),
                    filePath: "100px",
                    ngayApDung: "100px",
                    ngayKetThuc: "100px",
                    trangThaiBaoCao: "150px",
                    trangThai: "100px",
                };
            },
            getDynamicMinWidth(data, key) {
                // Calculate min-width based on the longest text in the column
                const maxLength = Math.max(
                    ...data.map((item) => (item[key] ? item[key].toString().length : 0))
                );
                // Base min-width is 50px, add 7px per character
                return Math.max(50, maxLength * 7) + "px";
            },


            handleClose() {
                this.chitiet_truongdanop = false;
            },
            taiFile(e) {
                console.log("Tải file" + e)
                let url = this.thongtin.tenMien + e
                window.open(url);
            },
            rutGonTenDonVi(e) {
                if (e) {
                    let result = "[Trống]";
                    result = e.replace("Giáo dục và Đào tạo", "GD&ĐT");
                    return result;

                } else {
                    return '[Trống]';
                }
            },
            xemOnline(e) {
                let url = "xuat-excel-truong-hoc-da-nop-bao-cao-theo-bieu-mau";
                let params = {
                    "bmTruongId": e.id
                };
                if (this.thongtin.role == 4) {
                    params.bmTruongId = e.idBieuMauPhongNop;
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                api.post(url, params, (data) => {
                    loading.close()
                    var d = new Date();
                    var n = d.getTime();
                    let url = this.baseLink + data.data.file + '?v=' + n;
                    // let url = this.baseLink + 'https://dongbo.csdl.edu.vn' + data.linkBaoCaoDaNop;
                    window.open(url, '_blank');
                });
            },
            taiXuongFileDaNop(e) {
                let url = "xuat-excel-truong-hoc-da-nop-bao-cao-theo-bieu-mau";
                let params = {
                    "bmTruongId": e.id
                };
                if (this.thongtin.role == 4) {
                    params.bmTruongId = e.idBieuMauPhongNop;
                }
                this.$confirm('Xác nhận tải xuống file thông tin?', 'Thông báo', {
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
            },
            layLai(e) {

                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            checkTruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
            soSanh(e) {
                let kt = moment(e, "DD-MM-YYYY");
                let hn = moment(this.homNay, "DD-MM-YYYY");
                console.log(kt);
                console.log(hn);
                if (kt < hn) {
                    return true;
                } else {
                    return false;
                }
            },
            getClass(e) {
                let start = moment(e.ngayApDung, "DD-MM-YYYY");
                let end = moment(e.ngayKetThuc, "DD-MM-YYYY");
                let hn = moment(this.homNay, "DD-MM-YYYY");
                if (end < hn) {
                    return ('hetHan')
                }
                if (start > hn) {
                    return ('chuaDen')
                }
            },
            getClass2(stt) {
                return stt == 1 ? 'banGhiDangHoatDong' : stt == 0 ? 'banGhiNgungHoatDong' : 'banGhiDaXoa'
            },
            soSanh2(e) {
                let kt = moment(e, "DD-MM-YYYY");
                let hn = moment(this.homNay, "DD-MM-YYYY");
                if (kt < hn) {
                    return true;
                } else {
                    return false;
                }
            },
            getTime(date) {
                return timeutils.dateToString(new Date(date));
            },
            getTrangThaiTruong(e) {
                if (e == 0) {
                    return ("Chưa nộp");
                } else if (e == 1) {
                    return ("Đã nộp")
                }
            },
            getTrangThaiBaoCao(e) {
                if (e == 1) {
                    return ("Đang hoạt đông");
                } else {
                    return ("Ngưng hoạt động")
                }
            },
            // Tải xuống file trường
            taiXuongFileTruong(e) {
                let url = "xuat-excel-truong-hoc-da-nop-bao-cao-theo-bieu-mau";
                let params = {
                    "bmTruongId": e.id
                };
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
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
                    })
                    .catch(_ => {});
            },
            // Tải xuống file trường
            XemFileYeuCau(e) {
                let url = "xuat-excel-truong-hoc-da-nop-bao-cao-theo-bieu-mau";
                let params = {
                    "bmTruongId": e.id
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                api.post(url, params, (data) => {
                    loading.close();
                    var d = new Date();
                    var n = d.getTime();
                    let url = this.baseLink + data.data.file + '?v=' + n;
                    // let url = this.baseLink + 'https://dongbo.csdl.edu.vn' + data.linkBaoCaoDaNop;
                    window.open(url, '_blank');
                });
            },
            // Tổng hợp báo cáo
            TongHop(e) {
                let uri = 'tong-hop-thong-ke-theo-bieu-mau';
                let params = {
                    "id": e
                };
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        closeOnClickModal: false,
                        cancelButtonText: 'Hủy',
                    })
                    .then(_ => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(uri, params, (response) => {
                            if (response.data.rc == 0) {

                                this.thongBao('success',
                                    'Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                                loading.close();
                                let a = document.createElement('a');
                                a.href = response.data.file;
                                document
                                    .body
                                    .appendChild(a);
                                a.click();
                                document
                                    .body
                                    .removeChild(a);
                            } else {
                                this.thongBao('error', response.data.rd);
                                loading.close();
                            }
                            return;
                        });
                    })
                    .catch(_ => {});
            },
            TruongNopDuLieu(e) {
                let start = e.ngayApDung;
                let end = e.ngayKetThuc;
                start = moment(start, "DD-MM-YYYY");
                end = moment(end, "DD-MM-YYYY");
                let hn = moment(this.homNay, "DD-MM-YYYY");
                if (start > hn) {
                    this.thongBao('error', 'Chưa đến thời gian nộp dữ liệu.')
                    return;
                } else if (end < hn) {
                    this.thongBao('error', 'Yêu cầu đã hết hạn.')
                    return;
                } else {
                    console.log("hiển thị thêm file của:" + e);
                    this.thongTinYeuCau = e;
                    this.show_file = true;

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
            // Chỉnh sửa file
            SuaFile(e) {
                console.log("hiển thị thêm file của:" + e);
                this.thongTinYeuCau = e;
                this.show_file = true;
            },
            // thêm yêu cầu
            ThemYeuCau() {
                console.log("thêm yêu cầu ");
                this.show_themmoi = true;
            },
            // Show modal chi tiết trường học đã nộp
            XemChiTietTruongDaNop(data) {
                console.log("Xem chi tiết");
                console.log(data);
                this.idBaoCao = data?.id??''
                // this.list_truong_da_nop = [];
                this.list_don_vi_da_nop = [];
                // this.list_truong_da_nop = data.truongHocNopList;
                this.list_don_vi_da_nop = [...data.donViNopList, ...data.truongHocNopList];
                // $('#chitiet_truongdanop').modal('show');
                this.chitiet_truongdanop = true;
            },
            taiXuongFileExcel(){
                console.log("xuất excel");
                let url = `xuat-excel-danh-sach-truong-nop-thong-ke-theo-bieu-mau`;
                let params = {
                    id:this.idBaoCao
                };
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.thongBao('success', 'Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        const loadingExcel = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(url, params, (data) => {
                            loadingExcel.close();
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
            // Chỉnh sửa
            ChinhSua(e) {
                console.log("chỉnh sửa yêu cầu");
                this.thongTinBanGhi = e;
                this.show_chinhsua = true;
            },
            // Khóa yêu cầu
            Khoa(e) {
                console.log("Yêu cầu:" + JSON.stringify(e));
                this.$confirm('Xác nhận khóa yêu cầu?', 'Khóa yêu cầu', {
                        confirmButtonText: 'Khóa',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {

                        let params = {
                            id: e.id,
                            type: 2
                        };
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/nop-bieu-mau/action", params, data => {
                            loading.close();
                            if (data.data.rc == 0) {
                                this.thongBao('success', 'Khóa thành công')
                                this.getData();
                                return
                            } else {
                                this.thongBao('error', 'Khóa yêu cầu thất bại. Vui lòng thử lại sau')
                            }
                        });
                    })
                    .catch(_ => {});
            },
            // Thêm xong
            doneCreated() {
                this.show_themmoi = false;
                this.thongBao('success', 'Thêm mới thành công')
                this.getData();
            },
            // Khóa yêu cầu
            MoKhoa(e) {
                console.log("Yêu cầu:" + JSON.stringify(e));

                this.$confirm('Xác nhận mở khóa yêu cầu?', 'Thông báo', {
                        confirmButtonText: 'Mở khóa',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        let params = {
                            id: e.id,
                            type: 3
                        };
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/nop-bieu-mau/action", params, data => {
                            loading.close();
                            if (data.data.rc == 0) {
                                this.thongBao('success', 'Mở khóa thành công')
                                this.getData();
                                return
                            } else {
                                this.thongBao('error', 'Mở khóa yêu cầu thất bại. Vui lòng thử lại sau.')
                            }
                        });
                    })
                    .catch(_ => {});
            },
            // Xíoas yêu cầu
            Xoa(e) {
                console.log("Yêu cầu:" + JSON.stringify(e));
                this.$confirm('Xác nhận xóa yêu cầu?', 'Xóa yêu cầu', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass: 'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        let params = {
                            id: e.id,
                            type: 1
                        };
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/nop-bieu-mau/action", params, data => {
                            loading.close();
                            if (data.data.rc == 0) {
                                this.thongBao('success', data.data.rd);
                                this.getData();
                                return
                            } else {
                                this.thongBao('error', data.data.rd);
                            }
                        });
                    })
                    .catch(_ => {});
            },
            // Lấy dữ liệu
            getData() {
                this.list_yeu_cau = [];
                this.total_rows = 0;
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "loaiBaoCao": this.loaiBaoCao,
                    "tenBaoCao": this.tenBaoCao
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/nop-bieu-mau/filter", params, (data) => {
                    loading.close();
                    if (data.data.rc == 0) {
                        // this.thongBao('success', 'Lấy dữ liệu thành công.')
                        this.list_yeu_cau = data.data.tableData;
                        this.total_rows = data.data.totalRows;
                        this.calculateColumnWidths()
                        this.calculateColumnWidths2()
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

    .pxn-bao-header {

        display: flex;
        align-items: center;
    }

    .thaotac a {
        font-weight: bold;
    }

    #tuychonhienthi span {
        padding-right: 10px;
        font-size: 12px;
    }

    .thaotac .dropdown .dropdown-menu {
        right: 0;
        left: auto;
    }

    .thaotac .dropdown .dropdown-menu li a {
        padding: 3px;
        font-weight: normal;
    }

    .thaotac .dropdown .dropdown-menu li a:hover {
        background: #3d8bcd;
    }

    .thaotac .dropdown .dropdown-menu li.divider {
        margin: 0;
    }

    .cg {
        text-align: center;
        align-items: center;
    }

    .hetHan {
        background: #f3cccc !important;
    }

    .chuaDen {
        background: #AFFDD9 !important;
    }

    .table>tbody>tr>td>button {
        font-size: 12px;
    }
    .table-responsive{
        max-height: 50vh !important;
    }

</style>

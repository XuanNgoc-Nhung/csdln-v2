<template>
    <div>
        <Breadcrumb :menu="'Tra cứu'" :desc="'Tra cứu trường học'" />
        <div class="card-bieu-do">
            <el-form ref="ruleForm">
                <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :md="12" :lg="6" v-if="thongtin.role==1">
                        <label>Sở Giáo dục</label>
                        <eselect style="width:100%" :disabled="thongtin.role>1" @change="ChonDonViSo" collapseTags
                                 v-model="maSo" :placeholder="'Chọn'" filterable :data="list_don_vi_so"
                                 :fields="['name','value']" />
                    </el-col>
                    <el-col :md="12" :lg="6">
                        <label>Đơn vị quản lý</label>
                        <div>
                            <eselect style="width:100%" :disabled="thongtin.role>3" collapseTags v-model="maPhong"
                                     :placeholder="'Chọn'" filterable :data="list_don_vi_phong" :fields="['name','value']" />
                        </div>
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label>Cấp học</label>
                        <div>
                            <eselect style="width:100%" collapseTags v-model="capHoc" :placeholder="'Chọn'" filterable
                                     :data="list_cap_hoc" :fields="['name','id']" />
                        </div>
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label>Nhóm cấp học</label>
                        <div>
                            <eselect style="width:100%" collapseTags v-model="maNhomCapHoc" :placeholder="'Chọn'"
                                     filterable :data="list_nhom_cap_hoc" :fields="['name','value']" />
                        </div>
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label>Trạng thái</label>
                        <el-select v-model="trangThai" placeholder="Tất cả" clearable>
                            <el-option label="Tất cả" value=""></el-option>
                            <el-option label="Đang hoạt động" value="1"></el-option>
                            <el-option label="Ngưng hoạt động" value="0"></el-option>
                            <el-option label="Đã xóa" value="-1"></el-option>
                        </el-select>
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label>Loại hình đào tạo</label>
                        <!-- <select v-model="loaiHinhDaoTao" class="form-control">
                                <option v-for="lh in list_loai_hinh_dao_tao" :value="lh.value">{{lh.name}}</option>
                            </select> -->
                        <eselect style="width:100%" collapseTags v-model="loaiHinhDaoTao" :placeholder="'Chọn'"
                                 filterable :data="list_loai_hinh_dao_tao" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label>Mã trường học</label>
                        <el-input clearable v-on:keyup.enter="getData" @change="maTruongHoc = maTruongHoc.trim()"
                                  v-model.trim="maTruongHoc" placeholder="Nhập..." />
                    </el-col>
                    <el-col :sm="12" :md="12" :lg="6">
                        <label>Tên trường học</label>
                        <el-input clearable v-on:keyup.enter="getData" @change="tenTruongHoc = tenTruongHoc.trim()"
                                  v-model="tenTruongHoc" placeholder="Nhập..." />
                    </el-col>

                    <el-col :span="24" class="text-center">
                        <el-button class="bt-chinh" plain type="success" size="mini" @click.prevent="TruocKhiTim()">
                            Tìm kiếm
                        </el-button>
                    </el-col>

                </el-row>
            </el-form>

        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <!-- <el-col :span="12" class="">
                    <label  class="table-name">Danh sách trường học</label>
                </el-col>
                <el-col :span="12">
                    <div class="pull-right">
                        <el-button class="bt-phu" style="margin:0 5px;" type="primary" size="mini"
                            v-on:click.prevent="showImport()">Nhập theo biểu mẫu
                        </el-button>
                        <el-button class="bt-chinh" type="primary" size="mini"
                            :disabled="ds_truong_hoc.length==0" v-on:click.prevent="xuatExcel()">
                            Xuất excel
                        </el-button>
                        <el-button class="bt-chinh" type="primary" size="mini"
                            v-on:click.prevent="showCreat()"> Thêm mới
                        </el-button>
                    </div>
                </el-col> -->
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <label  class="table-name">Danh sách trường học</label>
                        <div class="text-right">
                            <el-button class="bt-phu" style="margin:0 5px;" type="primary" size="mini"
                                v-on:click.prevent="showImport()">Nhập theo biểu mẫu
                            </el-button>
                            <el-button class="bt-chinh" type="primary" size="mini"
                                :disabled="ds_truong_hoc.length==0" v-on:click.prevent="xuatExcel()">
                                Xuất excel
                            </el-button>
                            <el-button class="bt-chinh" type="primary" size="mini"
                                v-on:click.prevent="showCreat()"> Thêm mới
                            </el-button>
                        </div>
                    </div>
                </el-col>
                <el-col :span="24">
                    <template>
                        <el-table
                                :data="ds_truong_hoc"
                                border
                                style="width: 100%"
                                empty-text="Chưa có dữ liệu"
                                max-height="600"
                        >
                            <!-- STT -->
                            <el-table-column
                                    prop="index"
                                    label="STT"
                                    align="center"
                                    fixed="left"
                                    :width="start > 9999 ? 70 : 60"
                            >
                                <template #default="{ $index }">
                                    <p>{{ (currentPage - 1) * limit + $index + 1 }}</p>
                                </template>
                            </el-table-column>

                            <!-- Thao tác -->
                            <el-table-column
                                    label="Thao tác"
                                    align="center"
                                    fixed="right"
                                    width="120"
                            >
                                <template #default="{ row }">
                                    <el-tooltip content="Xem" placement="top">
                                        <i @click.prevent="showInfo(row)" class="el-icon-view"></i>
                                    </el-tooltip>
                                    <el-tooltip content="Sửa" placement="top">
                                        <i @click.prevent="showUpdate(row)" class="el-icon-edit"></i>
                                    </el-tooltip>
                                    <el-tooltip content="Xóa" v-if="row.trangThai !== -1" placement="top">
                                        <i class="el-icon-delete" @click.prevent="deleteUnit(row)"></i>
                                    </el-tooltip>
                                    <el-tooltip content="Xóa" v-else placement="top">
                                        <i
                                                class="el-icon-delete disabled"
                                                @click.prevent="thongBao('error', 'Không thể thực hiện do trường đã xóa')"
                                        ></i>
                                    </el-tooltip>
                                </template>
                            </el-table-column>

                            <!-- Các cột dữ liệu -->
                            <el-table-column :min-width="columnWidths['maTruongHoc']" prop="maTruongHoc" label="Mã trường học"   :fixed=" windowWidth > 1200 ? 'left' : false"/>
                            <el-table-column :min-width="columnWidths['tenTruongHoc']" prop="tenTruongHoc" label="Tên trường học"   :fixed=" windowWidth > 1200 ? 'left' : false"/>
                            <el-table-column
                                    label="Cấp học"
                                    width="100px"
                            >
                                <template #default="{ row }">
                                    <p>{{ getTenCapHoc(row.capHoc) }}</p>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    label="Nhóm cấp học"
                                    :min-width="columnWidths['maNhomCapHoc']"
                            >
                                <template #default="{ row }">
                                    <p>{{ getTenNhomCapHoc(row.maNhomCapHoc) }}</p>
                                </template>
                            </el-table-column>
                            <el-table-column  :min-width="columnWidths['tenDonVi']" prop="tenDonVi" label="Đơn vị quản lý" />
                            <el-table-column :min-width="columnWidths['tenQuanHuyen']" prop="tenQuanHuyen" label="Quận huyện" />
                            <el-table-column prop="tenTinhThanh" label="Tỉnh thành" :min-width="columnWidths['tenTinhThanh']"/>
                            <el-table-column
                                    label="Loại hình đào tạo"
                                    width="150"
                            >
                                <template #default="{ row }">
                                    <p>{{ getLoaiHinhDaoTao(row.loaiHinhDaoTao) }}</p>
                                </template>
                            </el-table-column>
                            <el-table-column
                                    prop="ngayThanhLap"
                                    label="Ngày thành lập"
                                    width="150"
                                    align="center"
                            />
                            <el-table-column
                                    label="Trạng thái"
                                    width="160"
                            >
                                <template #default="{ row }">
                                    <p :class="getStatusType(row.trangThai)" size="mini">
                                        {{ getTrangThai(row.trangThai) }}
                                    </p>
                                </template>
                            </el-table-column>

                            <!-- Điểm trường -->
                            <el-table-column
                                    label="Điểm trường"
                                    align="center"
                                    width="130"
                            >
                                <template #default="{ row }">
                                    <el-button
                                            class="bt-chinh"
                                            type="info"
                                            size="mini"
                                            @click.prevent="XemDiemTruong(row)"
                                    >
                                        Danh sách
                                    </el-button>
                                </template>
                            </el-table-column>
                        </el-table>


                    </template>
<!--                    <div class="table-responsive" role="region" aria-labelledby="caption" tabindex="0">-->
<!--                        <table class="table table-striped table-bordered table-hover">-->
<!--                            <thead>-->
<!--                                <tr style="background:rgb(228, 235, 245)">-->
<!--                                    <th class="text-center fixed-column fixed-col1 pin">-->
<!--                                        <p>STT</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center fixed-column fixed-col2 pin">-->
<!--                                        <p>Thao tác</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Mã trường học</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Tên trường học</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Cấp học</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Nhóm cấp học</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Đơn vị quản lý</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Quận huyện</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Tỉnh thành</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Loại hình đào tạo</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center">-->
<!--                                        <p>Ngày thành lập</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Trạng thái</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center">-->
<!--                                        <p>Điểm trường</p>-->
<!--                                    </th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody v-if="ds_truong_hoc.length===0">-->
<!--                                <tr>-->
<!--                                    <td class="text-center" colspan="23">-->
<!--                                        <p>Không có bản ghi nào</p>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                            <tbody v-else>-->
<!--                                <tr v-for="(tg,index) in ds_truong_hoc">-->
<!--                                    <td class="text-center fixed-column fixed-col1 pin">-->
<!--                                        <p>{{ (currentPage - 1) * limit + index + 1 }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-left fixed-column fixed-col2 pin">-->

<!--                                        <el-tooltip content="Xem" placement="top">-->
<!--                                            <i @click.prevent="showInfo(tg)" class="el-icon-view"></i>-->
<!--                                        </el-tooltip>-->
<!--                                        <el-tooltip content="Sửa" placement="top">-->
<!--                                            <i @click.prevent="showUpdate(tg)" class="el-icon-edit"></i>-->
<!--                                        </el-tooltip>-->
<!--                                        <el-tooltip content="Xóa" v-if="tg.trangThai!=-1" placement="top">-->
<!--                                            <i class="el-icon-delete" @click.prevent="deleteUnit(tg)"></i>-->
<!--                                        </el-tooltip>-->
<!--                                        <el-tooltip v-else content="Xóa" placement="top">-->
<!--                                            <i class="el-icon-delete disabled"-->
<!--                                                @click.prevent="thongBao('error','Không thể thực hiện do trường đã xóa')"></i>-->
<!--                                        </el-tooltip>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ tg.maTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ tg.tenTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ getTenCapHoc(tg.capHoc) }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ getTenNhomCapHoc(tg.maNhomCapHoc) }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ tg.tenDonVi }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ tg.tenQuanHuyen }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ tg.tenTinhThanh }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ getLoaiHinhDaoTao(tg.loaiHinhDaoTao) }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <p>{{ tg.ngayThanhLap }}</p>-->
<!--                                    </td>-->
<!--                                    &lt;!&ndash; <td class="text-center"><p v-if="tg.ngayThanhLap">{{getTime(tg.ngayThanhLap)}}</p></td> &ndash;&gt;-->
<!--                                    <td class="text-left">-->
<!--                                        &lt;!&ndash; <p v-if="tg.trangThai==-1" type="danger">Đã xoá-->
<!--                                    </p>-->
<!--                                    <p v-if="tg.trangThai==1" type="success">Đang hoạt động-->
<!--                                    </p>-->
<!--                                    <p v-if="tg.trangThai==0" type="warning">Ngừng hoạt động-->
<!--                                    </p> &ndash;&gt;-->
<!--                                        <p :class="getStatusType(tg.trangThai)" size="mini">-->
<!--                                            {{ getTrangThai(tg.trangThai) }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center">-->
<!--                                        <el-button class="bt-chinh" type="info" size="mini"-->
<!--                                            @click.prevent="XemDiemTruong(tg)">Danh sách-->
<!--                                        </el-button>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
                </el-col>
                <el-col v-show="total_rows" :span="24">
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                    </Page>
                </el-col>
            </el-row>
        </div>
        <!-- hết tìm kiếm -->
        <!-- danh sách -->
        <div v-if='false' class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                            </div>
                            <div class="col-sm-6 ">
                                <div class="pull-right">
                                    <el-button class="bt-phu" style="margin:0 5px;" type="primary" size="mini"
                                        v-on:click.prevent="showImport()">Nhập theo biểu mẫu
                                    </el-button>
                                    <el-button class="bt-chinh" type="primary" size="mini"
                                        :disabled="ds_truong_hoc.length==0" v-on:click.prevent="xuatExcel()">
                                        Xuất excel
                                    </el-button>
                                    <el-button class="bt-chinh" type="primary" size="mini"
                                        v-on:click.prevent="showCreat()"> Thêm mới
                                    </el-button>
                                </div>
                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;" />
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive" role="region" aria-labelledby="caption" tabindex="0">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr style="background:rgb(228, 235, 245)">
                                                <th class="text-center fixed-column fixed-col1 pin">
                                                    <p>STT</p>
                                                </th>
                                                <th class="text-center fixed-column fixed-col2 pin">
                                                    <p>Thao tác</p>
                                                </th>
                                                <th>
                                                    <p>Mã trường học</p>
                                                </th>
                                                <th>
                                                    <p>Tên trường học</p>
                                                </th>
                                                <th>
                                                    <p>Cấp học</p>
                                                </th>
                                                <th>
                                                    <p>Nhóm cấp học</p>
                                                </th>
                                                <th>
                                                    <p>Đơn vị quản lý</p>
                                                </th>
                                                <th>
                                                    <p>Quận huyện</p>
                                                </th>
                                                <th>
                                                    <p>Tỉnh thành</p>
                                                </th>
                                                <th>
                                                    <p>Loại hình đào tạo</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Ngày thành lập</p>
                                                </th>
                                                <th>
                                                    <p>Trạng thái</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Điểm trường</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="ds_truong_hoc.length===0">
                                            <tr>
                                                <td class="text-center" colspan="23">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(tg,index) in ds_truong_hoc">
                                                <td class="text-center fixed-column fixed-col1 pin">
                                                    <p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                                </td>
                                                <td class="text-left fixed-column fixed-col2 pin">

                                                    <el-tooltip content="Xem" placement="top">
                                                        <i @click.prevent="showInfo(tg)" class="el-icon-view"></i>
                                                    </el-tooltip>
                                                    <el-tooltip content="Sửa" placement="top">
                                                        <i @click.prevent="showUpdate(tg)" class="el-icon-edit"></i>
                                                    </el-tooltip>
                                                    <el-tooltip content="Xóa" v-if="tg.trangThai!=-1" placement="top">
                                                        <i class="el-icon-delete" @click.prevent="deleteUnit(tg)"></i>
                                                    </el-tooltip>
                                                    <el-tooltip v-else content="Xóa" placement="top">
                                                        <i class="el-icon-delete disabled"
                                                            @click.prevent="thongBao('error','Không thể thực hiện do trường đã xóa')"></i>
                                                    </el-tooltip>
                                                </td>
                                                <td>
                                                    <p>{{ tg.maTruongHoc }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ tg.tenTruongHoc }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ getTenCapHoc(tg.capHoc) }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ getTenNhomCapHoc(tg.maNhomCapHoc) }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ tg.tenDonVi }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ tg.tenQuanHuyen }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ tg.tenTinhThanh }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ getLoaiHinhDaoTao(tg.loaiHinhDaoTao) }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{ tg.ngayThanhLap }}</p>
                                                </td>
                                                <!-- <td class="text-center"><p v-if="tg.ngayThanhLap">{{getTime(tg.ngayThanhLap)}}</p></td> -->
                                                <td class="text-left">
                                                    <!-- <p v-if="tg.trangThai==-1" type="danger">Đã xoá
                                                </p>
                                                <p v-if="tg.trangThai==1" type="success">Đang hoạt động
                                                </p>
                                                <p v-if="tg.trangThai==0" type="warning">Ngừng hoạt động
                                                </p> -->
                                                    <p :class="getStatusType(tg.trangThai)" size="mini">
                                                        {{ getTrangThai(tg.trangThai) }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <el-button class="bt-chinh" type="info" size="mini"
                                                        @click.prevent="XemDiemTruong(tg)">Danh sách
                                                    </el-button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                                </Page>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- hết danh sách -->
        <!-- modal điểm trường -->
        <el-dialog :close-on-click-modal="false" width="90%" :close-on-press-escape="false" :before-close="dongModal"
            :title="'Danh sách điểm trường: '+tmpTruongHoc.tenTruongHoc +' - ['+tmpTruongHoc.maTruongHoc+']'"
            :visible.sync="show_diem_truong">
            <el-row :gutter="24">


                <el-col :sm="6" :lg="3">
                    <el-select class="input-with-select" v-model="namHoc" no-match-text="Không tìm thấy bản ghi nào"
                        no-data-text="danh sách lựa chọn trống" collapse-tags style="width:100%" filterable
                        placeholder="Chọn năm học">
                        <el-option v-for="(item,i) in list_nam_hoc" :key="i" :label="item.name" :value="item.id">
                        </el-option>
                    </el-select>
                </el-col>
                <el-col :sm="6" :lg="3">
                    <el-button plain size="mini" style=" width:100%; padding-left:10px;font-size:14px; line-height:1.1"
                        class="bt-chinh" @click="XemDiemTruong(tmpTruongHoc)" type="success">Thống
                        kê
                    </el-button>
                </el-col>

                <el-col style='padding-top:5px' :span="24">
                                            <div style="text-align: right">
                                                <span style="padding-right:20px" v-if="list_diem_truong_delete.length"><b>Đã chọn
                                                    {{ list_diem_truong_delete.length }} bản ghi</b></span>
                                                <el-tooltip v-if="list_diem_truong_delete.length"
                                                            :content="list_diem_truong_delete.length?'Xóa dữ liệu điểm trường':'Chọn điểm trường cần xóa'"
                                                            placement="top">
                                                    <el-button size="mini" style="font-size:14px; line-height:1.1" plain class="bt-xoa"
                                                               :disabled="list_diem_truong_delete.length==0" @click.prevent="xoaDiemTruong()"
                                                               type="danger">
                                                        Xóa điểm trường
                                                    </el-button>
                                                </el-tooltip>
                                            </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr style="background:rgb(228, 235, 245)">
                                    <th class="cg">
                                        <input type="checkbox" v-model="selectAllDiemTruong"
                                            @change="chonTatCaDiemTruong">
                                    </th>
                                    <th>
                                        <p>STT</p>
                                    </th>
                                    <th>
                                        <p>Phòng</p>
                                    </th>
                                    <th>
                                        <p>Mã điểm trường</p>
                                    </th>
                                    <th>
                                        <p>Tên điểm trường</p>
                                    </th>
                                    <th>
                                        <p>Địa chỉ</p>
                                    </th>
                                    <th>
                                        <p>Khoảng cách tới trường chính</p>
                                    </th>
                                    <th>
                                        <p>Diện tích</p>
                                    </th>
                                    <th>
                                        <p>Số điện thoại</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="ds_diem_truong.length===0">
                                <tr>
                                    <td class="text-center" colspan="9">
                                        <p>Không tìm thấy bản ghi nào</p>
                                        <!-- <p>Trường học không có điểm trường năm học {{namHoc}} - {{namHoc+1}}</p> -->
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(dt,index) in ds_diem_truong" :key="index">
                                    <td class="text-center">
                                        <input type="checkbox" v-model="list_diem_truong_delete"
                                            :value="dt.maDiemTruong" />
                                    </td>
                                    <td class="text-center">
                                        <p>{{ index + 1 }}</p>
                                    </td>
                                    <td>
                                        <p>{{ getTenDonVi(dt.maPhong) }}</p>
                                    </td>
                                    <td>
                                        <p>{{ dt.maDiemTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ dt.tenDiemTruong }}</p>
                                    </td>
                                    <td>
                                        <p>{{ dt.diaChi }}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ dt.khoangCach }} km</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ dt.dienTich }} m<sup>2</sup></p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{ dt.dienThoai }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </el-col>
            </el-row>

            <span slot="footer" class="dialog-footer">
                <el-button class="bt-phu" type="default" @click="show_diem_truong = false" size="mini">Đóng</el-button>
            </span>
        </el-dialog>
        <!-- Thêm trường học -->
        <ChinhSuaTruongHoc :show="show_update" @close="show_update=false" :item="dataEditTruongHoc"
            @thanhcong="onCreatedData($event)"></ChinhSuaTruongHoc>
        <ThongTinTruongHoc @close="show_info=false" :show="show_info" :item="dataInfoTruongHoc"
            @thanhcong="onCreatedData($event)"></ThongTinTruongHoc>
        <ThemMoiTruongHoc @close="show_create=false" :show="show_create" :item="dataInfoTruongHoc"
            @thanhcong="onCreatedData($event)"></ThemMoiTruongHoc>
        <ImportTruongHoc :show="show_import" @close="show_import=false" :info="thongTinImport"
            @success="onCreatedData()">
        </ImportTruongHoc>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../../utils/rest_api';
    import array_util from '../../../utils/array_utils';
    import timeutils from '../../../utils/time_utils';
    import Page from '../../ui/PagingCustom';
    import ESelectVue from '../../ui/ESelect.vue';
    import ThemMoi from './themMoi';
    import ChinhSua from './chinhSua.vue';
    import ThongTin from './thongTin';
    import Import from './../pupupImportExcel/importChung.vue';
    import dialog from '../../../utils/dialog';
    import constant from '../../../utils/constant';
    import api from './../../api';
    import Breadcrumb from '../../ui/Breadcrumb.vue';

    export default {
        components: {
            "ThemMoiTruongHoc": ThemMoi,
            "ChinhSuaTruongHoc": ChinhSua,
            "ThongTinTruongHoc": ThongTin,
            "ImportTruongHoc": Import,
            Multiselect,
            "Page": Page,
            'eselect': ESelectVue,
            Breadcrumb
        },
        computed: {},
        data() {
            return {
                windowWidth: window.innerWidth,
                columnWidths : [],
                thongTinImport: {
                    title: 'Nhập trường học',
                    pathImport: '/api-import-truong-hoc',
                    pathTemplate: '/templateImport/Template_Truong_Hoc.xlsx'
                },
                show_diem_truong: false,
                selectAllDiemTruong: false,
                list_diem_truong_delete: [],
                thongtin: JSON.parse(window.userInfo),
                thongtinso: {},
                tmpTruongHoc: {},
                date: new Date(),
                namHoc: "",
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_cap_hoc: window.listCapHoc,
                list_nhom_cap_hoc: [{
                        name: 'Mầm non',
                        value: '01'
                    },
                    {
                        name: 'Mẫu giáo',
                        value: '02'
                    },
                    {
                        name: 'Nhà trẻ',
                        value: '03'
                    },
                    {
                        name: 'Nhóm nhà trẻ độc lập',
                        value: '04'
                    },
                    {
                        name: 'Lớp mẫu giáo độc lập',
                        value: '05'
                    },
                    {
                        name: 'Tiểu học',
                        value: '06'
                    },
                    {
                        name: 'THCS',
                        value: '07'
                    },
                    {
                        name: 'THPT',
                        value: '08'
                    },
                    {
                        name: 'PTCS',
                        value: '09'
                    },
                    {
                        name: 'Trung học',
                        value: '10'
                    },
                    {
                        name: 'Phổ thông',
                        value: '11'
                    },
                    {
                        name: 'GDTX Tỉnh',
                        value: '12'
                    },
                    {
                        name: 'GDTX Huyện',
                        value: '13'
                    },
                    {
                        name: 'TTKTTHHN',
                        value: '14'
                    },
                    {
                        name: 'Lớp nhô',
                        value: '15'
                    },
                    {
                        name: 'MN-TH',
                        value: '16'
                    },
                    {
                        name: 'MN-PT',
                        value: '17'
                    },
                    {
                        name: 'MN-PTCS',
                        value: '18'
                    },
                    {
                        name: 'Nhóm trẻ, lớp mẫu giáo độc lập',
                        value: '19'
                    },
                ],
                ds_truong_hoc: [],
                ds_diem_truong: [],
                list_loai_hinh_dao_tao: [{
                        name: "Công lập - [1]",
                        value: 1
                    },
                    {
                        name: "Tư thục - [2]",
                        value: 2
                    },
                    {
                        name: "GDTX - [3]",
                        value: 3
                    },
                    {
                        name: "Ngoài công lập - [4]",
                        value: 4
                    }, {
                        name: "Dân lập - [5]",
                        value: 5
                    },
                ],
                start: 0,
                currentPage: 1,
                resTrang: 1,
                limit: 25,
                total_rows: 0,
                //  tìm kiếm
                danhSachDonViSo: "",
                danhSachDonViPhong: "",
                danhSachCapHoc: "",
                list_don_vi_so: [],
                list_don_vi_phong: [],
                //  gửi đi
                maSo: "",
                maPhong: "",
                capHoc: "",
                maNhomCapHoc: "",
                tenTruongHoc: "",
                maTruongHoc: "",
                loaiHinhDaoTao: "",
                trangThai: "",
                //  Thêm trường học
                trangbatdau: false,
                show_create: false,
                //    Chỉnh sửa trường học
                show_update: false,
                dataEditTruongHoc: {},
                //    thông tin trường học
                show_info: false,
                dataInfoTruongHoc: {},
                //    import
                show_import: false,
            }
        },
        mounted() {
            this.updateWidth()

            if (this.thongtin.role > 1) {
                this.maSo = this.thongtin.ma_so;
            }
            this.ganDuLieuSME();
            this.getDonViCapSo();
            this.getDonViCapPhong();
            // this.getData();
            this.namHoc = this.thongtin.namHocHienTai;
        },
        watch: {
            ds_truong_hoc: {
                handler(newValue) {
                    if (newValue && newValue.length) {
                        this.calculateColumnWidths(); // Tính toán lại độ rộng khi dữ liệu thay đổi
                    }
                },
                immediate: true,
            },
            list_diem_truong_delete: function (newVal) {
                if (newVal) {
                    let data = newVal;
                    if (data.length == this.ds_diem_truong.length && data.length > 0) {
                        this.selectAllDiemTruong = true;
                    } else {
                        this.selectAllDiemTruong = false;
                    }
                } else {
                    this.selectAllDiemTruong = false;
                }
            },
        },
        methods: {
            updateWidth() {
                this.windowWidth = window.innerWidth;
            },
            calculateColumnWidths() {
                const columnWidths = {};

                // Danh sách các cột trong bảng
                const columns = [
                    { prop: "maTruongHoc", label: "Mã trường học" },
                    { prop: "tenTruongHoc", label: "Tên trường học" },
                    { prop: "capHoc", label: "Cấp học", customContent: this.getTenCapHoc },
                    { prop: "maNhomCapHoc", label: "Nhóm cấp học", customContent: this.getTenNhomCapHoc },
                    { prop: "tenDonVi", label: "Đơn vị quản lý" },
                    { prop: "tenQuanHuyen", label: "Quận huyện" },
                    { prop: "tenTinhThanh", label: "Tỉnh thành" },
                    { prop: "loaiHinhDaoTao", label: "Loại hình đào tạo", customContent: this.getLoaiHinhDaoTao },
                    { prop: "ngayThanhLap", label: "Ngày thành lập" },
                    { prop: "trangThai", label: "Trạng thái", customContent: this.getTrangThai },
                ];

                columns.forEach((col) => {
                    // Dữ liệu cho cột hiện tại
                    const field = col.prop;
                    const rows = this.ds_truong_hoc.map((row) => {
                        if (col.customContent) {
                            // Nếu cột sử dụng hàm tuỳ chỉnh, gọi hàm tuỳ chỉnh
                            return col.customContent(row[field]) || "";
                        }
                        return row[field]?.toString() || "";
                    });

                    const header = col.label; // Tiêu đề cột
                    const longestContent = [header, ...rows].reduce(
                        (a, b) => (a.length > b.length ? a : b),
                        ""
                    );

                    // Tính toán chiều rộng
                    const charWidth = 10; // Chiều rộng trung bình của 1 ký tự
                    const padding = 20; // Padding thêm
                    columnWidths[field] = longestContent.length * charWidth + padding;
                });

                this.columnWidths = columnWidths;
            },

            dongModal() {
                this.show_diem_truong = false;

            },

            getClass(stt) {
                return stt == 1 ? 'banGhiDangHoatDong' : stt == 0 ? 'banGhiNgungHoatDong' : 'banGhiDaXoa'
            },
            getTenDonVi(e) {
                let data = "";
                if (e) {
                    for (let i = 0; i < this.list_don_vi_phong.length; i++) {
                        if (this.list_don_vi_phong[i].value == e) {
                            data = this.list_don_vi_phong[i].name
                        }
                    }
                }
                return data
            },
            xoaDiemTruong() {
                if (this.list_diem_truong_delete.length <= 0) {
                    this.thongBao('error', 'Vui lòng chọn điểm trường cần xóa');
                    return;
                }
                if (!this.namHoc || this.namHoc == '') {
                    this.thongBao('error', 'Thiếu năm học');
                    return;
                }
                let params = {
                    maDiemTruongs: this.list_diem_truong_delete,
                    namHoc: this.namHoc
                }
                console.log("Dữ liệu xóa:")
                console.log(params)
                this.$confirm('Xác nhận xóa dữ liệu điểm trường đã chọn?', 'Xóa dữ liệu', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass: 'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        let loadingdel = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/diemTruongTheoNam/delelte-list", params, (data) => {
                            loadingdel.close();
                            console.log("Xóa điểm trường trả về:")
                            console.log(data)
                            if (data.data.rc == 0) {
                                this.thongBao("success", data.data.rd)
                                this.XemDiemTruong(this.tmpTruongHoc);
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
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
            chonTatCaDiemTruong() {
                let danhsach = [];
                if (this.selectAllDiemTruong) {
                    for (let i = 0; i < this.ds_diem_truong.length; i++) {
                        danhsach.push(this.ds_diem_truong[i].maDiemTruong);
                    }
                }
                this.list_diem_truong_delete = danhsach;
            },
            XemDiemTruong(e) {
                this.tmpTruongHoc = e;
                this.ds_diem_truong = [];
                this.list_diem_truong_delete = [];
                this.selectAllDiemTruong = false;
                let params = {
                    namHoc: this.namHoc,
                    maTruongs: [e.maTruongHoc]
                }
                let loadingdt = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/diemTruongTheoNam/finds", params, (data) => {
                    loadingdt.close();
                    if (data.data.rc == 0) {
                        // this.thongBao('success', 'Lấy dữ liệu điểm trường thành công')
                        this.ds_diem_truong = data.data.rows;
                    } else {
                        this.ds_diem_truong = [];
                        let msg = "Trường học chưa có dữ liệu điểm trường năm học " + this.namHoc + '-' + (this
                            .namHoc + 1);
                        // this.thongBao('error', msg)
                    }
                });
                this.show_diem_truong = true;
            },
            ganDuLieuSME() {
                // let tmp = localStorage["danh_sach_loai_hinh_dao_tao_sme"];
                // if (tmp) {
                //     this.list_loai_hinh_dao_tao = JSON.parse(localStorage["danh_sach_loai_hinh_dao_tao_sme"])
                // }
            },
            // Xuất  danh sách trường học
            xuatExcel() {
                let url = "xuat-excel-danh-sach-truong-hoc";
                let params = {
                    "start": 0,
                    "limit": 10000,
                    "ma": this.maTruongHoc,
                    "ten": this.tenTruongHoc,
                    "trangthai": this.trangThai,
                    "caphoc": this.capHoc,
                    "maNhomCapHoc": this.maNhomCapHoc,
                    "matinhthanh": this.maSo,
                    "madonvi": this.maPhong,
                    "loaihinhdaotao": this.loaiHinhDaoTao
                };

                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.thongBao('success', 'Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        let loadingex = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(url, params, (data) => {
                            loadingex.close();
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
                // dialog.confirmDialog(
                //     "Xác nhận tải xuống dữ liệu. Vui lòng chờ trong thời gian tải xuống?",
                //     "Đồng ý",
                //     () => {
                //     }
                // );
            },
            TruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
            // Import trường học
            showImport() {
                console.log("Import file từ excel");
                this.show_import = true;
            },
            // Xóa trường học
            deleteUnit(e) {
                this.$confirm('Xác nhận xóa trường học này?', 'Xóa trường học', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass: 'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const uri = "/api_xoa_truong_hoc";
                        let params = {
                            id: e.maTruongHoc,
                        };
                        let loadingdel = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(uri, params, (response) => {
                            loadingdel.close();
                            console.log("xóa:" + JSON.stringify(response));
                            if (response.data.code === 200) {
                                this.thongBao("success", response.data.message)
                                this.getData();
                            } else {
                                this.thongBao('error', response.data.message)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            // Chỉnh sửa trường học
            showUpdate(tg) {
                console.log(tg);
                this.dataEditTruongHoc = tg;
                this.show_update = true;
            },
            // xem thông tin trường học
            showInfo(e) {
                console.log("Xem thông tin trường học");
                console.log(e);
                this.dataInfoTruongHoc = e;
                this.show_info = true;
            },
            // Thêm trường thành công
            onCreatedData() {
                this.show_create = false;
                this.show_update = false;
                this.getData();
            },
            //   thêm trường học
            showCreat() {
                console.log("thêm mới trường học");
                this.show_create = true;
            },
            //   Lấy lại dữ liệu
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            // định nghĩa cho đơn vị
            setNameDonVi({
                tenDonVi,
                maDonVi
            }) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // định nghĩa cho cấp học
            setNameCapHoc({
                name
            }) {
                return `${name}`
            },
            // Lấy danh sách sở
            getDonViCapSo() {
                if (this.thongtin.role > 3) {
                    this.maSo = this.thongtin.ma_so;
                }
                let params = {
                    "start": 0,
                    "limit": 1000,
                    "loaiDonVi": 1
                };
                let loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    let dulieu = data.data.rows;
                    let ldvs = [];
                    for (let i = 0; i < dulieu.length; i++) {
                        let obj = {
                            name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                ' - [' + dulieu[i].maDonVi + ']',
                            value: dulieu[i].maDonVi
                        }
                        ldvs.push(obj);
                    }
                    this.list_don_vi_so = ldvs;
                });
            },
            getDonViCapPhong() {
                if (this.thongtin.role > 3) {
                    this.maPhong = this.thongtin.ma_don_vi;
                }
                let params = {
                    "start": 0,
                    "limit": 1000,
                    "maTinhThanh": this.maSo,
                    //   "loaiDonVi": 2
                };
                let loading2 = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading2.close();
                    let dulieu = data.data.rows;
                    let ldvs = [];
                    for (let i = 0; i < dulieu.length; i++) {
                        let obj = {
                            name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                ' - [' + dulieu[i].maDonVi + ']',
                            value: dulieu[i].maDonVi
                        }
                        ldvs.push(obj);
                    }
                    this.list_don_vi_phong = ldvs;
                });
            },
            // Chọn sở
            ChonDonViSo() {
                this.list_don_vi_phong = [];
                this.maPhong = "";
                this.getDonViCapPhong();
            },
            onChonCapHoc() {
                this.capHoc = "";
                if (this.danhSachCapHoc) {
                    this.capHoc = this.danhSachCapHoc.id;
                }
                console.log("cấp học:" + this.capHoc);
            },
            // Chọn sở
            onChonDonViPhong() {
                if (this.danhSachDonViPhong) {
                    this.maPhong = this.danhSachDonViPhong.maDonVi;
                } else {
                    this.maPhong = "";
                }
            },
            getData() {
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "ma": this.maTruongHoc,
                    "ten": this.tenTruongHoc,
                    "trangthai": this.trangThai,
                    "maNhomCapHoc": this.maNhomCapHoc,
                    "caphoc": this.capHoc,
                    "matinhthanh": this.maSo,
                    "madonvi": this.maPhong,
                    "loaihinhdaotao": this.loaiHinhDaoTao
                };
                console.log("lấy dữ liệu:");
                console.log(JSON.stringify(params));
                let loading2 = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmTruongHoc/filter", params, (data) => {
                    loading2.close();
                    if (array_util.isArray(data.data.rows)) {
                        this.total_rows = data.data.total;
                        array_util.clearArrays(this.ds_truong_hoc);
                        this.ds_truong_hoc = data.data.rows;
                        if (this.total_rows > 0) {
                            // this.thongBao('success', 'Lấy dữ liệu thành công')
                        } else {
                            // this.thongBao('error', 'Không có bản ghi nào được tìm thấy')
                        }
                    }
                });
            },
            getTenCapHoc(e) {
                var res = null;
                for (let i = 0; i < this.list_cap_hoc.length; i++) {
                    if (this.list_cap_hoc[i].id == e) {
                        res = this.list_cap_hoc[i].name;
                    }
                }
                if (res === null) {
                    res = 'Liên cấp ' + e;
                }
                return res;
            },
            getTenNhomCapHoc(loai) {
                var res = '';
                for (let i = 0; i < this.list_nhom_cap_hoc.length; i++) {
                    if (this.list_nhom_cap_hoc[i].value == loai) {
                        res = this.list_nhom_cap_hoc[i].name;
                    }
                }
                return res;
            },
            getLoaiHinhDaoTao(loai) {
                var res = loai;
                for (let i = 0; i < this.list_loai_hinh_dao_tao.length; i++) {
                    if (this.list_loai_hinh_dao_tao[i].value == res) {
                        return this.list_loai_hinh_dao_tao[i].name;
                    }
                }
            },
            getTime(date) {
                return timeutils.dateToString(new Date(date));
            },
            getStatusType(check) {
                var res = parseInt(check);
                switch (check) {
                    case 1:
                        res = 'banGhiDangHoatDong'
                        break;
                    case 0:
                        res = 'banGhiNgungHoatDong'
                        break;
                    case -1:
                        res = 'banGhiDaXoa'
                        break;
                    case 2:
                        res = 'banGhiGiaiThe'
                        break;
                    default:
                        res = check;
                }
                return res;
            },
            getTrangThai(loai) {
                var res = parseInt(loai);
                switch (loai) {
                    case 1:
                        res = 'Đang hoạt động'
                        break;
                    case 0:
                        res = 'Ngừng hoạt động'
                        break;
                    case -1:
                        res = 'Đã xóa'
                        break;
                    case 2:
                        res = 'Giải thể'
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
        }
    }

</script>
<style scoped="scoped">
    .el-select .el-input.is-disabled .el-input__inner {
        color: #303133 !important;
    }

    th {
        align-items: center;
    }

    .col-sm-3 {
        height: 75px;
    }

</style>

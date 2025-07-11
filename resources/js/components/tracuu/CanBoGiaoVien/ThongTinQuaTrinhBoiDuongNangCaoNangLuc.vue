<template>
    <div>
        <el-dialog title="Quá trình đào tạo, bồi dưỡng" :visible.sync="show" top="5vh" width="80%"
            :close-on-click-modal="false" append-to-body :close-on-press-escape="false" :before-close="handleClose">
            <form>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <span class="table-name">Quá trình đào tạo bồi dưỡng</span>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background:#e4ebf5">
                                        <th class="cg">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg">
                                            <p>Tên trường <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Chuyên ngành đào tạo, bồi dưỡng <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Từ ngày <span style="color:#DC0101">*</span> - đến ngày</p>
                                        </th>
                                        <th class="cg">
                                            <p>Hình thức <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Văn bằng, chứng chỉ <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <!-- <th class="cg">
                                            <p>Thao tác</p>
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody v-if="list_qua_trinh_dtbd.length==0">
                                    <tr>
                                        <td class="cg bt" colspan="9">
                                            <p>Không có bản ghi nào</p>
                                            <!-- <el-tooltip content="Thêm" placement="top">
                                                <el-button plain size="mini" @click.prevent="themItemBdDt()"
                                                    icon="el-icon-plus" type="primary"> Thêm
                                                </el-button>
                                            </el-tooltip> -->
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item,i) in list_qua_trinh_dtbd" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" v-model="item.tenTruong"
                                                placeholder="Nhập...">
                                        </td>
                                        <td>
                                            <el-select v-model="item.maNhomChuyenNganh" style="min-width:200px"
                                                filterable collapse-tags placeholder="Chọn"
                                                no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_cn_dt_khac" :key="i"
                                                    :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <div class="input-group input-daterange">
                                                <date-picker :config="configDatePicker" placeholder="Ngày bắt đầu"
                                                    v-model="item.tuThangNam ">
                                                </date-picker>
                                                <div class="input-group-addon">đến</div>
                                                <date-picker :config="configDatePicker" placeholder="Ngày kết thúc"
                                                    v-model="item.denThangnam">
                                                </date-picker>
                                            </div>
                                        </td>
                                        <td>
                                            <el-select v-model="item.maHinhThucDaoTao" style="min-width:200px"
                                                filterable collapse-tags placeholder="Chọn"
                                                no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_ht_dt" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.maVbChungChi" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_trinh_do_cm_nv2" :key="i"
                                                    :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <!-- <td class="text-center">

                                            <el-tooltip content="Xóa" placement="top">
                                                <i class="el-icon-delete" @click.prevent="xoaItemDtBd(i)"></i>
                                            </el-tooltip>
                                            <el-tooltip v-show="i+1==list_qua_trinh_dtbd.length" content="Thêm"
                                                placement="top">
                                                <i class="el-icon-plus" @click.prevent="themItemBdDt(i)"></i>
                                            </el-tooltip>

                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </el-col>
                    <el-col :span="24">
                        <span class="table-name">Quá trình bồi dưỡng nâng cao năng lực sư phạm</span>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background:#e4ebf5">
                                        <th class="cg">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg">
                                            <p>Khóa đào tạo <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị bồi dưỡng <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị tổ chức <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Thời lượng bồi dưỡng <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Loại hình bồi dưỡng <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Hình thức <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Kết quả đạt được <span class="red">*</span></p>
                                        </th>
                                        <!-- <th class="cg">
                                            <p>Thao tác</p>
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody v-if="qua_trinh_sp==0">
                                    <tr>
                                        <td class="cg bt" colspan="9">
                                            <p>Không có bản ghi nào</p>
                                            <!-- <el-tooltip content="Thêm" placement="top">
                                                <el-button plain size="mini" @click.prevent="themItemBdSp()"
                                                    icon="el-icon-plus" type="primary"> Thêm
                                                </el-button>
                                            </el-tooltip> -->
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item,i) in qua_trinh_sp" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaKhoaDaoTao" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_khoa_dao_tao_sp" :key="i"
                                                    :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaDonViBoiDuong" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_dv" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaDonViToChuc" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_dv_tc" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaThoiLuongBoiDuong" style="min-width:200px"
                                                filterable collapse-tags placeholder="Chọn"
                                                no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_tl_bd" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaLoaiHinhBoiDuong" style="min-width:200px"
                                                filterable collapse-tags placeholder="Chọn"
                                                no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_lh_bd" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaHinhThuc" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_hinh_thuc" :key="i"
                                                    :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaKetQua" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_kq_bd_sp" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <!-- <td class="text-center">

                                            <el-tooltip content="Xóa" placement="top">
                                                <i class="el-icon-delete" @click.prevent="xoaItemBdSp(i)"></i>
                                            </el-tooltip>
                                            <el-tooltip v-show="i+1==qua_trinh_sp.length" content="Thêm"
                                                placement="top">
                                                <i class="el-icon-plus" @click.prevent="themItemBdSp(i)"></i>
                                            </el-tooltip>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </el-col>
                    <el-col :span="24">
                        <span class="table-name">Quá trình bồi dưỡng nâng cao năng lực ngoại ngữ</span>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background:#e4ebf5">
                                        <th class="cg">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg">
                                            <p>Khóa đào tạo <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị tổ chức thi <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị bồi dưỡng <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị tổ chức <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Thời lượng bồi dưỡng <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Loại hình bồi dưỡng <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Hình thức <span class="red">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Kết quả đạt được <span class="red">*</span></p>
                                        </th>
                                        <!-- <th class="cg">
                                            <p>Thao tác</p>
                                        </th> -->
                                    </tr>
                                </thead>
                                <tbody v-if="qua_trinh_nn==0">
                                    <tr>
                                        <td class="cg bt" colspan="10">
                                            <p>Không có bản ghi nào</p>
                                            <!-- <el-tooltip content="Thêm" placement="top">
                                                <el-button plain size="mini" @click.prevent="themItemBdNn()"
                                                    icon="el-icon-plus" type="primary"> Thêm
                                                </el-button>
                                            </el-tooltip> -->
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item,i) in qua_trinh_nn" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaKhoaDaoTao" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_khoa_dao_tao_nn" :key="i"
                                                    :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaDonViToChucThi" style="min-width:200px"
                                                filterable collapse-tags placeholder="Chọn"
                                                no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_dv" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaDonViBoiDuong" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_dv" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaDonViToChuc" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_dv_tc" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaThoiLuongBoiDuong" style="min-width:200px"
                                                filterable collapse-tags placeholder="Chọn"
                                                no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_tl_bd" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaLoaiHinhBoiDuong" style="min-width:200px"
                                                filterable collapse-tags placeholder="Chọn"
                                                no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_lh_bd" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaHinhThuc" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_hinh_thuc" :key="i"
                                                    :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.MaKetQua" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="(item,i) in list_kq_bd_nn" :key="i" :label="item.name"
                                                    :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <!-- <td class="text-center">
                                            <el-tooltip content="Xóa" placement="top">
                                                <i class="el-icon-delete" @click.prevent="xoaItemBdNn(i)"></i>
                                            </el-tooltip>
                                            <el-tooltip v-show="i+1==qua_trinh_sp.length" content="Thêm"
                                                placement="top">
                                                <i class="el-icon-plus" @click.prevent="themItemBdNn(i)"></i>
                                            </el-tooltip>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </el-col>
                </el-row>
            </form>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="default" style="margin-right:5px" @click.prevent="handleClose()">Đóng
                </el-button>
                <!-- <el-button type="primary" size="mini" @click.prevent="resetQt">Lưu
                </el-button> -->
            </span>
        </el-dialog>

        <div v-if="false" id="modal_nl" ref="modal_nl" class="modal fade" style="font-size:18px;">
            <div class="modal-dialog modal-dialog-fullscreen">
                <form>
                    <div class="modal-content modal-content-fullscreen">
                        <div class="modal-header modal-header-fullscreen">
                            <h5 class="modal-title text-uppercase">Quá trình đào tạo, bồi dưỡng</h5>
                        </div>
                        <div class="modal-body modal-body-fullscreen">
                            <div style="">
                                <div class="">
                                    <h6><b>Quá trình đào tạo bồi dưỡng</b></h6>
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg">
                                                    <p>STT</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Tên trường <span style="color:#DC0101">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Chuyên ngành đào tạo, bồi dưỡng <span
                                                            style="color:#DC0101">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Từ ngày <span style="color:#DC0101">*</span> - đến ngày</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Hình thức <span style="color:#DC0101">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Văn bằng, chứng chỉ <span style="color:#DC0101">*</span></p>
                                                </th>
                                                <!-- <th class="cg">
                                                    <p>Thao tác</p>
                                                </th> -->
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_qua_trinh_dtbd.length==0">
                                            <tr>
                                                <td class="cg bt" colspan="9">
                                                    <p>Không có bản ghi nào</p>
                                                    <!-- <el-tooltip content="Thêm" placement="top">
                                                        <el-button plain size="mini" @click.prevent="themItemBdDt()"
                                                            icon="el-icon-plus" type="primary"> Thêm
                                                        </el-button>
                                                    </el-tooltip> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in list_qua_trinh_dtbd" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" v-model="item.tenTruong"
                                                        placeholder="Nhập...">
                                                </td>
                                                <td>
                                                    <el-select v-model="item.maNhomChuyenNganh" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_cn_dt_khac" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <div class="input-group input-daterange">
                                                        <date-picker :config="configDatePicker"
                                                            placeholder="Ngày bắt đầu" v-model="item.tuThangNam ">
                                                        </date-picker>
                                                        <div class="input-group-addon">đến</div>
                                                        <date-picker :config="configDatePicker"
                                                            placeholder="Ngày kết thúc" v-model="item.denThangnam">
                                                        </date-picker>
                                                    </div>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.maHinhThucDaoTao" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_ht_dt" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.maVbChungChi" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_trinh_do_cm_nv2" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <!-- <td class="text-center">

                                                    <el-tooltip content="Xóa" placement="top">
                                                        <i class="el-icon-delete" @click.prevent="xoaItemDtBd(i)"></i>
                                                    </el-tooltip>
                                                    <el-tooltip v-show="i+1==list_qua_trinh_dtbd.length" content="Thêm"
                                                        placement="top">
                                                        <i class="el-icon-plus" @click.prevent="themItemBdDt(i)"></i>
                                                    </el-tooltip>
                                                </td> -->
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h6><b>Quá trình bồi dưỡng nâng cao năng lực sư phạm</b></h6>
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg">
                                                    <p>STT</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Khóa đào tạo <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Đơn vị bồi dưỡng <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Đơn vị tổ chức <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Thời lượng bồi dưỡng <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Loại hình bồi dưỡng <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Hình thức <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Kết quả đạt được <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Thao tác</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="qua_trinh_sp==0">
                                            <tr>
                                                <td class="cg bt" colspan="9">
                                                    <p>Không có bản ghi nào</p>
                                                    <el-tooltip content="Thêm" placement="top">
                                                        <el-button plain size="mini" @click.prevent="themItemBdSp()"
                                                            icon="el-icon-plus" type="primary"> Thêm
                                                        </el-button>
                                                    </el-tooltip>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in qua_trinh_sp" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaKhoaDaoTao" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_khoa_dao_tao_sp" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaDonViBoiDuong" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_dv" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaDonViToChuc" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_dv_tc" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaThoiLuongBoiDuong"
                                                        style="min-width:200px" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_tl_bd" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaLoaiHinhBoiDuong" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_lh_bd" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaHinhThuc" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_hinh_thuc" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaKetQua" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_kq_bd_sp" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td class="text-center">

                                                    <el-tooltip content="Xóa" placement="top">
                                                        <i class="el-icon-delete" @click.prevent="xoaItemBdSp(i)"></i>
                                                    </el-tooltip>
                                                    <el-tooltip v-show="i+1==qua_trinh_sp.length" content="Thêm"
                                                        placement="top">
                                                        <i class="el-icon-plus" @click.prevent="themItemBdSp(i)"></i>
                                                    </el-tooltip>

                                                    <!-- <el-tooltip content="Xóa" placement="left">
                                                    <el-button plain size="mini" @click.prevent="xoaItemBdSp(i)"
                                                        icon="el-icon-delete" type="danger">
                                                    </el-button>
                                                </el-tooltip>

                                                <el-tooltip v-show="i+1==qua_trinh_sp.length" content="Thêm"
                                                    placement="top">
                                                    <el-button plain size="mini" @click.prevent="themItemBdSp(i)"
                                                        icon="el-icon-plus" type="primary">
                                                    </el-button>
                                                </el-tooltip> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <h6><b>Quá trình bồi dưỡng nâng cao năng lực ngoại ngữ</b></h6>
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg">
                                                    <p>STT</p>
                                                </th>
                                                <th class="cg">
                                                    <p>Khóa đào tạo <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Đơn vị tổ chức thi <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Đơn vị bồi dưỡng <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Đơn vị tổ chức <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Thời lượng bồi dưỡng <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Loại hình bồi dưỡng <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Hình thức <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Kết quả đạt được <span class="red">*</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Thao tác</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="qua_trinh_nn==0">
                                            <tr>
                                                <td class="cg bt" colspan="10">
                                                    <p>Không có bản ghi nào</p>
                                                    <el-tooltip content="Thêm" placement="top">
                                                        <el-button plain size="mini" @click.prevent="themItemBdNn()"
                                                            icon="el-icon-plus" type="primary"> Thêm
                                                        </el-button>
                                                    </el-tooltip>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in qua_trinh_nn" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaKhoaDaoTao" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_khoa_dao_tao_nn" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaDonViToChucThi" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_dv" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaDonViBoiDuong" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_dv" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaDonViToChuc" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_dv_tc" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaThoiLuongBoiDuong"
                                                        style="min-width:200px" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_tl_bd" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaLoaiHinhBoiDuong" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_lh_bd" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaHinhThuc" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_hinh_thuc" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaKetQua" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="(item,i) in list_kq_bd_nn" :key="i"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td class="text-center">
                                                    <!-- <el-tooltip content="Xóa" placement="left">
                                                    <el-button plain size="mini" @click.prevent="xoaItemBdNn(i)"
                                                        icon="el-icon-delete" type="danger">
                                                    </el-button>
                                                </el-tooltip>

                                                <el-tooltip v-show="i+1==qua_trinh_nn.length" content="Thêm"
                                                    placement="top">
                                                    <el-button plain size="mini" @click.prevent="themItemBdNn(i)"
                                                        icon="el-icon-plus" type="primary">
                                                    </el-button>
                                                </el-tooltip> -->

                                                    <el-tooltip content="Xóa" placement="top">
                                                        <i class="el-icon-delete" @click.prevent="xoaItemBdNn(i)"></i>
                                                    </el-tooltip>
                                                    <el-tooltip v-show="i+1==qua_trinh_sp.length" content="Thêm"
                                                        placement="top">
                                                        <i class="el-icon-plus" @click.prevent="themItemBdNn(i)"></i>
                                                    </el-tooltip>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer modal-footer-fullscreen clearfix">
                            <el-button size="mini" class="dts-button-close" style="margin-right:5px"
                                data-dismiss="modal">Đóng
                            </el-button>
                            <!-- <el-button type="primary" size="mini" @click.prevent="resetQt()">Lưu lại </el-button> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import moment from 'moment'
    import utils from '../../../utils';
    export default {
        props: ['item', 'show'],
        watch: {
            item: function (newVal, oldVal) {
                this.nation_status = newVal.trangThai;
            },
            show: function (newVal, oldVal) {
                this.list_qua_trinh_dtbd = this.item.dtbd;
                this.qua_trinh_nn = this.item.nn;
                this.qua_trinh_sp = this.item.sp;
            }
        },
        components: {},
        data() {
            return {

                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                list_qua_trinh_dtbd: [],
                qua_trinh_sp: [],
                qua_trinh_nn: [],
                list_cn_dt_khac: [],
                list_trinh_do_cm_nv2: [
                    // {name:'Tiến sĩ',value:'01'},
                    // {name:'Thạc sĩ',value:'02'},
                    // {name:'Đại học',value:'03'},
                    // {name:'Cao đẳng',value:'04'},
                    // {name:'Trung cấp',value:'05'},
                    // {name:'Trình độ khác',value:'06'},
                    // {name:'Bác sĩ chuyên khoa 1',value:'07'},
                    // {name:'Bác sĩ chuyên khoa 2',value:'08'},
                    // {name:'TH 12+2',value:'09'},
                    // {name:'TH 9+3',value:'10'},
                    // {name:'Dưới THSP',value:'11'},
                    // {name:'Đại học và có chứng chỉ BDNVSP',value:'13'},
                    // {name:'Cao đẳng và có chứng chỉ BDNVSP',value:'14'},
                    // {name:'Trung cấp và có chứng chỉ BDNVSP',value:'15'},
                    // {name:'Đại học sư phạm',value:'16'},
                    // {name:'Cao đẳng sư phạm',value:'17'},
                    // {name:'Trung cấp sư phạm',value:'18'},
                    // {name:'Giáo sư',value:'19'},
                    // {name:'Phó giáo sư',value:'20'},
                    // {name:'Chưa qua đào tạo sư phạm',value:'21'},
                ],
                list_khoa_dao_tao_sp: [],
                list_khoa_dao_tao_nn: [],
                list_dv: [],
                list_dv_tc: [],
                list_tl_bd: [],
                list_hinh_thuc: [],
                list_kq_bd_sp: [],
                list_kq_bd_nn: [],
                list_ht_dt: [],
                list_lh_bd: [],
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
        },
        methods: {

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
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_don_vi_to_chuc_moet_code_sme"];
                if (tmp) {
                    this.list_cn_dt_khac = JSON.parse(localStorage[
                        "danh_sach_chuyen_nganh_dao_tao_khac_moet_code_sme"]);
                    this.list_trinh_do_cm_nv2 = JSON.parse(localStorage["danh_sach_trinh_do_chuyen_mon_moet_code_sme"]);
                    this.list_khoa_dao_tao_sp = JSON.parse(localStorage[
                        "danh_sach_khoa_dao_tao_su_pham_moet_code_sme"]);
                    this.list_khoa_dao_tao_nn = JSON.parse(localStorage[
                        "danh_sach_khoa_dao_tao_ngoai_ngu_moet_code_sme"]);
                    this.list_dv = JSON.parse(localStorage["danh_sach_don_vi_moet_code_sme"]);
                    this.list_dv_tc = JSON.parse(localStorage["danh_sach_don_vi_to_chuc_moet_code_sme"]);
                    this.list_tl_bd = JSON.parse(localStorage["danh_sach_thoi_luong_boi_duong_moet_code_sme"]);
                    this.list_hinh_thuc = JSON.parse(localStorage["danh_sach_hinh_thuc_moet_code_sme"]);
                    this.list_kq_bd_sp = JSON.parse(localStorage["danh_sach_ket_qua_boi_duong_su_pham_moet_code_sme"]);
                    this.list_kq_bd_nn = JSON.parse(localStorage[
                        "danh_sach_ket_qua_boi_duong_ngoai_ngu_moet_code_sme"]);
                    this.list_ht_dt = JSON.parse(localStorage["danh_sach_hinh_thuc_dao_tao_moet_code_sme"]);
                    this.list_lh_bd = JSON.parse(localStorage["danh_sach_loai_hinh_boi_duong_moet_code_sme"]);
                }
            },
            handleClose() {
                console.log('handleClose');
                this.close();

            },
            resetQt() {
                for (let i = 0; i < this.list_qua_trinh_dtbd.length; i++) {
                    if (!this.list_qua_trinh_dtbd[i].tenTruong) {
                        this.thongBao("error", "Thiếu tên trường")
                        return;
                    }
                    if (!this.list_qua_trinh_dtbd[i].maNhomChuyenNganh) {
                        this.thongBao("error", "Thiếu chuyên ngành đào tạo, bồi dưỡng")
                        return;
                    }
                    if (!this.list_qua_trinh_dtbd[i].tuThangNam) {
                        this.thongBao("error", "Thiếu từ ngày")
                        return;
                    }
                    if (!this.list_qua_trinh_dtbd[i].maHinhThucDaoTao) {
                        this.thongBao("error", "Thiếu hình thức")
                        return;
                    }
                    if (!this.list_qua_trinh_dtbd[i].maVbChungChi) {
                        this.thongBao("error", "Thiếu văn bằng, chứng chỉ")
                        return;
                    }
                    if (this.list_qua_trinh_dtbd[i].tuThangNam) {
                        
                        let bd = moment(this.list_qua_trinh_dtbd[i].tuThangNam, "DD-MM-YYYY");
                        let kt = moment(this.list_qua_trinh_dtbd[i].denThangnam, "DD-MM-YYYY");
                        if (kt < bd) {
                            this.thongBao("error", "Giá trị Đến ngày phải lớn hơn hoặc bằng Từ ngày")
                            return;
                        }
                    }
                }
                for (let i = 0; i < this.qua_trinh_sp.length; i++) {
                    if (!this.qua_trinh_sp[i].MaKhoaDaoTao) {
                        this.thongBao("error", "Thiếu khóa đào tạo bồi dưỡng sư phạm")
                        return;
                    }
                    if (!this.qua_trinh_sp[i].MaDonViBoiDuong) {
                        this.thongBao("error", "Thiếu Đơn vị bồi dưỡng bồi dưỡng sư phạm")
                        return;
                    }
                    if (!this.qua_trinh_sp[i].MaDonViToChuc) {
                        this.thongBao("error", 'Thiếu đơn vị tổ chức sư phạm')
                        return;
                    }
                    if (!this.qua_trinh_sp[i].MaThoiLuongBoiDuong) {
                        this.thongBao("error", 'Thiếu Thời lượng bồi dưỡng Sư phạm')
                        return;
                    }
                    if (!this.qua_trinh_sp[i].MaHinhThuc) {
                        this.thongBao("error", 'Thiếu Loại hình bồi dưỡng Sư phạm')
                        return;
                    }
                    if (!this.qua_trinh_sp[i].MaHinhThuc) {
                        this.thongBao("error", 'Thiếu Hình thức đào tạo Sư phạm')
                        return;
                    }
                    if (!this.qua_trinh_sp[i].MaKetQua) {
                        this.thongBao("error", 'Thiếu Kết quả đạt được Sư phạm')
                        return;
                    }
                }
                for (let i = 0; i < this.qua_trinh_nn.length; i++) {
                    if (!this.qua_trinh_nn[i].MaKhoaDaoTao) {
                        this.thongBao("error", 'Thiếu Khóa đào tạo, bồi dưỡng Ngoại ngữ')
                        return;
                    }
                    if (!this.qua_trinh_nn[i].MaDonViToChucThi) {
                        this.thongBao("error", 'Thiếu Khóa đào tạo, bồi dưỡng Ngoại ngữ')
                        return;
                    }
                    if (!this.qua_trinh_nn[i].MaDonViBoiDuong) {
                        this.thongBao("error", "Thiếu Đơn vị bồi dưỡng Ngoại ngữ");
                        return;
                    }
                    if (!this.qua_trinh_nn[i].MaDonViToChuc) {
                        this.thongBao("error", "Thiếu Đơn vị tổ chức Ngoại ngữ");
                        return;
                    }
                    if (!this.qua_trinh_nn[i].MaThoiLuongBoiDuong) {
                        this.thongBao("error", "Thiếu Thời lượng bồi dưỡng Ngoại ngữ");
                        return;
                    }
                    if (!this.qua_trinh_nn[i].MaLoaiHinhBoiDuong) {
                        this.thongBao("error", "Thiếu Loại hình bồi dưỡng Ngoại ngữ");
                        return;
                    }
                    if (!this.qua_trinh_nn[i].MaHinhThuc) {
                        this.thongBao("error", "Thiếu Hình thức đào tạo Ngoại ngữ");
                        return;
                    }
                    if (!this.qua_trinh_nn[i].MaKetQua) {
                        this.thongBao("error", "Thiếu Kết quả đạt được Ngoại ngữ");
                        return;
                    }
                }
                let obj = {
                    nn: this.qua_trinh_nn,
                    sp: this.qua_trinh_sp,
                    dtbd: this.list_qua_trinh_dtbd,
                };

                utils.confirmDialog("Xác nhận lưu lại thông tin", "Đồng ý", () => {
                    this.$emit('success', obj);
                })
            },
            themItemBdDt(e) {
                if (this.list_qua_trinh_dtbd.length == 0) {
                    let obj = {
                        tenTruong: "",
                        maNhomChuyenNganh: "",
                        tuThangNam: "",
                        denThangnam: "",
                        maHinhThucDaoTao: "",
                        maVbChungChi: "",
                    }
                    this.list_qua_trinh_dtbd.push(obj);
                } else {
                    for (let i = 0; i < this.list_qua_trinh_dtbd.length; i++) {
                        if (!this.list_qua_trinh_dtbd[i].tenTruong) {
                            this.thongBao("error", "Thiếu Tên Trường");
                            return;
                        }
                        if (!this.list_qua_trinh_dtbd[i].maNhomChuyenNganh) {
                            this.thongBao("error", "Thiếu chuyên ngành đào tạo, bồi dưỡng");
                            return;
                        }
                        if (!this.list_qua_trinh_dtbd[i].tuThangNam) {
                            this.thongBao("error", "Thiếu từ ngày");
                            return;
                        }
                        if (!this.list_qua_trinh_dtbd[i].maHinhThucDaoTao) {
                            this.thongBao("error", "Thiếu Hình thức");
                            return;
                        }
                        if (!this.list_qua_trinh_dtbd[i].maVbChungChi) {
                            this.thongBao("error", "Thiếu Văn bằng, chứng chỉ");
                            return;
                        }
                        if (this.list_qua_trinh_dtbd[i].tuThangNam) {
                            let bd = moment(this.list_qua_trinh_dtbd[i].tuThangNam, "DD-MM-YYYY");
                            let kt = moment(this.list_qua_trinh_dtbd[i].denThangnam, "DD-MM-YYYY");
                            if (kt < bd) {
                                this.thongBao("error", "Giá trị Đến ngày phải lớn hơn hoặc bằng Từ ngày");
                                return;
                            }
                        }
                    }
                    let obj = {
                        tenTruong: "",
                        maNhomChuyenNganh: "",
                        tuThangNam: "",
                        denThangnam: "",
                        maHinhThucDaoTao: "",
                        maVbChungChi: "",
                    }
                    this.list_qua_trinh_dtbd.push(obj);
                }
            },
            themItemBdSp(e) {
                if (this.qua_trinh_sp.length == 0) {
                    let obj = {
                        MaKetQua: "",
                        MaHinhThuc: "",
                        MaLoaiHinhBoiDuong: "",
                        MaKhoaDaoTao: "",
                        MaThoiLuongBoiDuong: "",
                        MaDonViToChuc: "",
                        MaDonViBoiDuong: "",
                    }
                    this.qua_trinh_sp.push(obj);
                } else {
                    for (let i = 0; i < this.qua_trinh_sp.length; i++) {
                        if (!this.qua_trinh_sp[i].MaKhoaDaoTao) {
                            this.thongBao("error", "Thiếu Khóa đào tạo bồi dưỡng Sư phạm");
                            return;
                        }
                        if (!this.qua_trinh_sp[i].MaDonViBoiDuong) {
                            this.thongBao("error", "Thiếu Đơn vị bồi dưỡng Sư phạm");
                            return;
                        }
                        if (!this.qua_trinh_sp[i].MaDonViToChuc) {
                            this.thongBao("error", "Thiếu Đơn vị tổ chức Sư phạm");
                            return;
                        }
                        if (!this.qua_trinh_sp[i].MaThoiLuongBoiDuong) {
                            this.thongBao("error", "Thiếu Thời lượng bồi dưỡng Sư phạm");
                            return;
                        }
                        if (!this.qua_trinh_sp[i].MaHinhThuc) {
                            this.thongBao("error", "Thiếu Loại hình bồi dưỡng Sư phạm");
                            return;
                        }
                        if (!this.qua_trinh_sp[i].MaHinhThuc) {
                            this.thongBao("error", "Thiếu Hình thức đào tạo Sư phạm");
                            return;
                        }
                        if (!this.qua_trinh_sp[i].MaKetQua) {
                            this.thongBao("error", "Thiếu Kết quả đạt được Sư phạm");
                            return;
                        }
                    }
                    let obj = {
                        MaKetQua: "",
                        MaHinhThuc: "",
                        MaLoaiHinhBoiDuong: "",
                        MaKhoaDaoTao: "",
                        MaThoiLuongBoiDuong: "",
                        MaDonViToChuc: "",
                        MaDonViBoiDuong: "",
                    }
                    this.qua_trinh_sp.push(obj);
                }
            },
            themItemBdNn(e) {
                if (this.qua_trinh_nn.length == 0) {
                    let obj = {
                        MaKetQua: "",
                        MaHinhThuc: "",
                        MaLoaiHinhBoiDuong: "",
                        MaDonViToChucThi: "",
                        MaKhoaDaoTao: "",
                        MaThoiLuongBoiDuong: "",
                        MaDonViToChuc: "",
                        MaDonViBoiDuong: "",
                    }
                    this.qua_trinh_nn.push(obj);
                } else {
                    for (let i = 0; i < this.qua_trinh_nn.length; i++) {
                        if (!this.qua_trinh_nn[i].MaKhoaDaoTao) {
                            this.thongBao("error", "Thiếu Khóa đào tạo, bồi dưỡng Ngoại ngữ");
                            return;
                        }
                        if (!this.qua_trinh_nn[i].MaDonViToChucThi) {
                            this.thongBao("error", "Thiếu Đơn vị tổ chức thi Ngoại ngữ");
                            return;
                        }
                        if (!this.qua_trinh_nn[i].MaDonViBoiDuong) {
                            this.thongBao("error", "Thiếu Đơn vị bồi dưỡng Ngoại ngữ");
                            return;
                        }
                        if (!this.qua_trinh_nn[i].MaDonViToChuc) {
                            this.thongBao("error", "Thiếu Đơn vị tổ chức Ngoại ngữ");
                            return;
                        }
                        if (!this.qua_trinh_nn[i].MaThoiLuongBoiDuong) {
                            this.thongBao("error", "Thiếu Thời lượng bồi dưỡng Ngoại ngữ");
                            return;
                        }
                        if (!this.qua_trinh_nn[i].MaLoaiHinhBoiDuong) {
                            this.thongBao("error", "Thiếu Loại hình bồi dưỡng Ngoại ngữ");
                            return;
                        }
                        if (!this.qua_trinh_nn[i].MaHinhThuc) {
                            this.thongBao("error", "Thiếu Hình thức đào tạo Ngoại ngữ");
                            return;
                        }
                        if (!this.qua_trinh_nn[i].MaKetQua) {
                            this.thongBao("error", "Thiếu Kết quả đạt được Ngoại ngữ");
                            return;
                        }
                    }
                    let obj = {
                        MaKetQua: "",
                        MaHinhThuc: "",
                        MaLoaiHinhBoiDuong: "",
                        MaDonViToChucThi: "",
                        MaKhoaDaoTao: "",
                        MaThoiLuongBoiDuong: "",
                        MaDonViToChuc: "",
                        MaDonViBoiDuong: "",
                    }
                    this.qua_trinh_nn.push(obj);
                }
            },
            xoaItemBdNn(e) {
                console.log("xóa ở vị trí:" + e);
                this.qua_trinh_nn.splice(e, 1);
            },
            xoaItemDtBd(e) {
                console.log("xóa ở vị trí:" + e);
                this.list_qua_trinh_dtbd.splice(e, 1);
            },
            xoaItemBdSp(e) {
                console.log("xóa ở vị trí:" + e);
                this.qua_trinh_sp.splice(e, 1);
            },
            close() {
                let obj = {
                    nn: this.qua_trinh_nn,
                    sp: this.qua_trinh_sp,
                    dtbd: this.list_qua_trinh_dtbd,
                };
                this.$emit('close', obj);
            },
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
        margin: 5px -15px !important;
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

    hr {
        border-color: #DC0101;
        width: 50%
    }

</style>

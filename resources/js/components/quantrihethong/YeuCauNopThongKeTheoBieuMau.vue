<template>
    <div>
        <!-- bắt đầu template -->
        <!-- header -->
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Báo cáo <span class="kytu">
                        &raquo;</span> Nộp thống kê theo biểu mẫu</span>
            </div>
        </div>
        <!-- bắt đầu fillter -->
        <div>
            <div class="row">
                <!--                Tên báo cáo-->

                <div class="col-md-3 timkiem">
                    <label>Tên báo cáo</label>
                    <input v-model="tenBaoCao" class="form-control" placeholder="Nhập..." />
                </div>
                <!--                Hết tên báo cáo-->
                <!--               Loại báo cáo -->

                <div class="col-md-3 timkiem">
                    <label>Loại báo cáo</label>
                    <select v-model="loaiBaoCao" class="form-control">
                        <option value="">Chọn loại báo cáo</option>
                        <option value="0">Báo cáo cộng dồn</option>
                        <option value="1">Báo cáo ghép dòng</option>
                    </select>
                </div>
                <!--                Hết loại báo cáo-->
            </div>
        </div>
        <!-- hết filter -->
        <!--        Button-->
        <div class="row" style="padding-top:10px">
            <div class="col-md-12 text-center">
                <el-button size="mini" type="success" @click.prevent="checkTruocKhiTim()">Tìm kiếm</el-button>
            </div>
        </div>


        <hr />
        <!-- {{ list_yeu_cau }} -->
        <!-- end header -->
        <!-- Danh sách -->
        <div class="panel panel-default">
            <div class="panel-body">
                <!-- Button thao tác -->
                <div class="row pxn-bao-header">
                    <div class="col-md-5">
                    </div>
                    <div class="col-md-7 text-right" v-if="thongtin.role!=5">
                        <el-button type="info" size="mini" data-toggle="collapse" data-target="#tuychonhienthi">Tùy chọn
                            hiển
                            thị
                        </el-button>
                        <el-button size="mini" type="primary " @click.prevent="ThemYeuCau">
                            Thêm yêu cầu
                        </el-button>
                    </div>
                    <div class="col-md-7 text-right" v-if="thongtin.role==5">
                        <b> Chú thích:</b>
                        <div style="width:20px; height:15px; background:#f3cccc;display:inline-block"></div>: Yêu cầu đã
                        hết hạn.
                        <div style="width:20px; height:15px; background:#a5d8c0;display:inline-block"></div>: Chưa tới
                        thời hạn nộp
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
                <hr />
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
                                        <p>Tên báo cáo</p>
                                    </th>
                                    <th class="cg">
                                        <p>Đơn vị yêu cầu</p>
                                    </th>
                                    <th class="cg">
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
                                    <th class="cg">
                                        <p>Thao tác</p>
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
                                        <p>{{(currentPage-1)*limit + i+1}}</p>
                                    </td>
                                    <td>
                                        <p>{{hs.tenBaoCao}}</p>
                                    </td>
                                    <td>
                                        <p>{{rutGonTenDonVi(hs.tenDonViTao)}}</p>
                                    </td>
                                    <td>
                                        <div class="text-center" v-if="hs.filePath">
                                            <a style="padding:9px 14px;margin:5px;" class="btn btn-primary"
                                                :href="hs.filePath">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        </div>
                                        <div class="text-center" v-else>
                                            <p>Chưa có file yêu cầu</p>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <p>{{hs.ngayApDung}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{hs.ngayKetThuc}}</p>
                                    </td>
                                    <td class="text-center">
                                        <el-button v-if="hs.trangThaiBaoCao==1" size="mini" type="success">
                                            Đang hoạt động
                                        </el-button>
                                        <el-button v-else size="mini" type="danger">
                                            Ngừng hoạt động
                                        </el-button>
                                    </td>
                                    <td class="text-center">
                                        <el-button v-if="hs.trangThai==1" size="mini" type="info">
                                            Đã nộp
                                        </el-button>
                                        <el-button v-else size="mini" type="warning">
                                            Chưa nộp
                                        </el-button>

                                        </p>
                                    </td>
                                    <td class="cg">
                                        <el-button v-if="hs.daNopBaoCao" style="margin:5px;"
                                            @click.prevent="taiXuongFileDaNop(hs)" size="mini" type="success">Tải file
                                            đã nộp
                                        </el-button>
                                        <el-button v-if="hs.daNopBaoCao" style="margin:5px;"
                                            @click.prevent="xemOnline(hs)" size="mini" type="info">Xem file đã nộp
                                        </el-button>
                                        <el-button style="margin:5px;" @click.prevent="TruongNopDuLieu(hs)" size="mini"
                                            type="primary">Nộp dữ liệu
                                        </el-button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                </div>
                <!-- hết bảng của trường -->
                <!-- Bảng của admin sở -->
                <div v-if="thongtin.role!=5">
                    <div style="min-height:300px; " class="table-responsive">
                        <table class="table table-bordered table-striped table-hover"
                            style="font-size:12px; width:max-content;max-width:max-content;min-width:100%">
                            <thead style="background: #e4ebf5">
                                <tr>
                                    <th class="cg">
                                        <p>STT</p>
                                    </th>
                                    <th class="cg" v-if="htTenBaoCao">
                                        <p>Tên báo cáo</p>
                                    </th>
                                    <th class="cg" v-if="htDonViYeuCau">
                                        <p>Đơn vị yêu cầu</p>
                                    </th>
                                    <th class="cg" v-if="htFileBieuMau">
                                        <p>File biểu mẫu</p>
                                    </th>
                                    <th class="cg" v-if="htNgayBatDau">
                                        <p>Bắt đầu</p>
                                    </th>
                                    <th class="cg" v-if="htNgayKetThuc">
                                        <p>Kết thúc</p>
                                    </th>
                                    <th class="cg" v-if="htTrangThai">
                                        <p>Trạng thái</p>
                                    </th>
                                    <th class="cg" v-if="htTruongHocNop">
                                        <p>Trường học nộp</p>
                                    </th>
                                    <th class="cg" v-if="htSoTruong">
                                        <p>Số trường đã nộp</p>
                                    </th>
                                    <th class="cg">
                                        <p>Thao tác</p>
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
                                    <td class="text-center">
                                        <p>{{(currentPage-1)*limit + i+1}}</p>
                                    </td>
                                    <td v-if="htTenBaoCao">
                                        <p>{{hs.tenBaoCao}}</p>
                                    </td>
                                    <td v-if="htDonViYeuCau">
                                        <p>{{rutGonTenDonVi(hs.tenDonViTao)}}</p>
                                    </td>
                                    <td v-if="htFileBieuMau" class="text-center">
                                        <!-- <a style="padding:9px 14px;margin:5px;" class="btn btn-primary"
                                            :href="hs.filePath" title="Tải file ">
                                            <i class="fas fa-download"></i>
                                        </a> -->
                                        <a :href="hs.filePath">
                                            <el-button size="mini" v-if="hs.hasEditAndUploadFile" type="primary"
                                                title="Tải file">
                                                <i class="fas fa-download"></i>
                                            </el-button>
                                        </a>
                                        <el-button size="mini" v-if="hs.hasEditAndUploadFile" type="info"
                                            title="Chỉnh sửa" @click="SuaFile(hs)">
                                            <i class="fas fa-upload"></i>
                                        </el-button>
                                    </td>
                                    <td v-if="htNgayBatDau">
                                        <p>{{hs.ngayApDung}}</p>
                                    </td>
                                    <td v-if="htNgayKetThuc">
                                        <p>{{hs.ngayKetThuc}}</p>
                                    </td>
                                    <td v-if="htTrangThai" class="text-center">

                                        <el-button v-if="hs.trangThai==1" size="mini" type="success">
                                            Đang hoạt động
                                        </el-button>
                                        <el-button v-else size="mini" type="danger">
                                            Ngừng hoạt động
                                        </el-button>
                                    </td>
                                    <td v-if="htTruongHocNop" class="text-center">
                                        <el-button size="mini" type="info" title="Chỉnh sửa"
                                            @click="XemChiTietTruongDaNop(hs)">
                                            Chi tiết
                                        </el-button>
                                    </td>
                                    <td class="cg" v-if="htSoTruong">
                                        <p>{{hs.countSchoolDone}}/{{hs.truongHocNopList.length}} trường.</p>
                                    </td>
                                    <td class="text-center">

                                        <el-dropdown trigger="click">
                                            <el-button size="mini" type="primary">
                                                Thao tác<i class="el-icon-arrow-down el-icon--right"></i>
                                            </el-button>
                                            <el-dropdown-menu slot="dropdown">
                                                <el-dropdown-item>
                                                    <p @click="TongHop(hs.id)"> <i class="el-icon-download "></i>Tổng
                                                        hợp</p>
                                                </el-dropdown-item>
                                                <el-dropdown-item v-if="hs.hasEditAndUploadFile&&hs.trangThai==1">
                                                    <p @click="Khoa(hs)"> <i class="el-icon-lock "></i>Khóa</p>
                                                </el-dropdown-item>
                                                <el-dropdown-item v-if="hs.hasEditAndUploadFile&&hs.trangThai==2">
                                                    <p @click="MoKhoa(hs)"> <i class="el-icon-unlock "></i>Mở khóa</p>
                                                </el-dropdown-item>
                                                <el-dropdown-item v-if="hs.hasEditAndUploadFile">
                                                    <p @click="ChinhSua(hs)"> <i class="el-icon-edit "></i>Chỉnh sửa</p>
                                                </el-dropdown-item>
                                                <el-dropdown-item v-if="hs.hasEditAndUploadFile">
                                                    <p @click="Xoa(hs)"> <i class="el-icon-delete "></i>Xóa</p>
                                                </el-dropdown-item>
                                            </el-dropdown-menu>
                                        </el-dropdown>


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
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                </div>
                <!-- hết bảng của admin sở -->
            </div>
        </div>
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
                            <el-tab-pane>
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
                                            <!-- list_truong_da_nop -->
                                            <tr v-for="(item, j) in list_don_vi_da_nop">
                                                <td class="text-center">{{ j + 1 }}</td>
                                                <td>{{ item.tenDonVi }}</td>
                                                <td class="text-center">{{ item.maDonVi }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </el-tab-pane>

                            <el-tab-pane>
                                <span slot="label">2. Trường học được yêu cầu</span>
                                
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
                                                <td>{{ item.tenTruongHoc }}</td>
                                                <td class="text-center">{{ item.maTruongHoc }}</td>
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
                                                        <el-button size="mini" @click.prevent="XemFileYeuCau(item)"
                                                            type="success">Xem trước file
                                                        </el-button>
                                                        <el-button size="mini" @click.prevent="taiXuongFileTruong(item)"
                                                            type="info">Tải xuống
                                                        </el-button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                        <ul class="nav nav-tabs" v-if="false">
                            <li class="active" style="display:none">
                                <a data-toggle="tab" href="#home">Đơn vị được yêu cầu</a>
                            </li>
                            <li class="active">
                                <a data-toggle="tab" href="#menu1">Trường học được yêu cầu</a>
                            </li>
                        </ul>
                        <div  v-if="false" class="tab-content" style="padding-top:15px">
                            <div id="home" style="display:none" class="tab-pane fade in active">
                            </div>
                            <div id="menu1" class="tab-pane fade in active">
                            </div>
                        </div>

                        <!-- -->
                    </div>
                    <div class="modal-footer clearfix">
                        <el-button type="default" size="mini" data-dismiss="modal">Đóng
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
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import dialog from '../../../js/utils/dialog';
    import constant from "../../utils/constant";
    import timeutils from "../../utils/time_utils";
    import ElementUI from 'element-ui';
    import api from '../api';
    import utils from '../../utils'
    import VueAlertify from 'vue-alertify';
    import moment from "moment";
    import ThemMoi from './ThemYeuCauNopThongKeTheoBieuMau';
    import XemBaoCao from './XemThongTinTruongNopBieuMau';
    import ChinhSua from './ChinhSuaYeuCauNopThongKeTheoBieuMau';
    import Page from '../ui/PagingCustom';
    import upLoadFile from './ImportFileYeuCauTkBm';

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
        },

        computed: {},
        props: [],

        data() {

            return {
                // Tùy chỉnh hiển thị
                link_xem_chi_tiet: "",
                thongTinYeuCau: {},
                thongtin: JSON.parse(window.userInfo),
                show_excel: false,
                htTenBaoCao: true,
                htTrangThai: true,
                htDonViYeuCau: false,
                htTruongHocNop: true,
                htFileBieuMau: true,
                htNgayBatDau: false,
                htNgayKetThuc: false,
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
                start: 0,
                currentPage: 1,
                limit: 25,
                total_rows: 0,
                trangbatdau: false,
                baseLink: "/view-excel?path=",
            }
        },

        mounted() {
            // gán thông tin đăng nhập
            this.homNay = this.getTime(this.date);
            this.getData();
        },

        watch: {},

        methods: {
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
                // dialog.confirmDialog("Xác nhận tổng hợp báo cáo?", "Đồng ý", () => {
                //     let params = {};
                //     let uri = '/csdlgd-admin/nop-bieu-mau/tongHop-download?id=' + e
                //     rest_api.post(uri, params, data => {
                //         console.log("tổng hợp trả về:" + JSON.stringify(data));
                //         let fileTai = data.data.file;
                //         //
                //         const b64toBlob = (b64Data, contentType = '', sliceSize = 512) => {
                //             const byteCharacters = atob(b64Data);
                //             const byteArrays = [];

                //             for (let offset = 0; offset < byteCharacters.length; offset +=
                //                 sliceSize) {
                //                 const slice = byteCharacters.slice(offset, offset + sliceSize);

                //                 const byteNumbers = new Array(slice.length);
                //                 for (let i = 0; i < slice.length; i++) {
                //                     byteNumbers[i] = slice.charCodeAt(i);
                //                 }

                //                 const byteArray = new Uint8Array(byteNumbers);
                //                 byteArrays.push(byteArray);
                //             }

                //             const blob = new Blob(byteArrays, {
                //                 type: contentType
                //             });
                //             return blob;
                //         }

                //         const contentType =
                //             'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
                //         const b64Data = fileTai;

                //         const blob = b64toBlob(b64Data, contentType);
                //         const blobUrl = URL.createObjectURL(blob);
                //         console.log("Thử:" + blobUrl);
                //         dialog.confirmDialog(
                //             "Tổng hợp xong. Xác nhận tải xuống file tổng hợp?",
                //             "Đồng ý",
                //             () => {
                //                 window.location.href = blobUrl;
                //             }
                //         );

                //         return;
                //     });
                // });
                let uri = 'tong-hop-thong-ke-theo-bieu-mau';
                let params = {
                    "id": e
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
                        api.post(uri, params, (data) => {
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
                this.list_truong_da_nop = [];
                this.list_don_vi_da_nop = [];
                this.list_truong_da_nop = data.truongHocNopList;
                this.list_don_vi_da_nop = data.donViNopList;
                $('#chitiet_truongdanop').modal('show');
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
                        confirmButtonText: 'Xác nhận',
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
                        console.log("lấy sanh sách yêu cầu: " + JSON.stringify(data.data));
                        // this.thongBao('success', 'Lấy dữ liệu thành công.')
                        this.list_yeu_cau = data.data.tableData;
                        this.total_rows = data.data.totalRows;
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

    .table-responsive {
        min-height: 70%;
    }

    .cg {
        text-align: center;
        align-items: center;
    }

    .hetHan {
        background: #f3cccc !important;
    }

    .chuaDen {
        background: #a5d8c0 !important;
    }

    .table>tbody>tr>td>button {
        font-size: 12px;
    }

</style>

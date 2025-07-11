<template>
    <div v-loading="loading" element-loading-text="Loading..." element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <div>
            <div class="row page-header">
                <div class="col-sm-6 text-uppercase">
                    <a href="#">TRANG CHỦ</a>
                    <span>
                        <span class="kytu">
                            &raquo;</span> BÁO CÁO ĐỘNG THỬ NGHIỆM
                        <span class="kytu">
                            &raquo;</span>Nhập liệu tiêu chí ngoài</span>
                </div>
            </div>
            <!-- tìm kiếm -->
            <div>
                <div class="card-bieu-do">
                    <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                        <el-col :span="6">
                            <label class="typo__label">Đơn vị quản lý</label>
                            <eselect collapseTags v-model="maDonViQuanLy" :disabled="thongtin.role>=4"
                                :placeholder="'Chọn'" @change="ChonCapHoc" filterable :data="list_don_vi"
                                :fields="['tenDonVi','maDonVi']" />
                        </el-col>
                        <el-col :span="4">
                            <label class="typo__label">Cấp học</label>
                            <eselect collapseTags v-model="capHoc" :disabled="thongtin.role==5" @change="ChonCapHoc"
                                :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :span="6">
                            <label class="typo__label">Trường học</label>
                            <eselect style="width:100%" collapseTags v-model="maTruongHoc" :disabled="thongtin.role==5"
                                :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                :fields="['tenTruongHoc','maTruongHoc']" />
                        </el-col>
                        <el-col :span="4">
                            <label class="typo__label">Năm học <span class="red">*</span></label>
                            <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                :data="list_nam_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :span="4">
                            <label class="typo__label">Học kỳ</label>
                            <eselect style="width:100%" collapseTags v-model="hocKy" :placeholder="'Chọn'" filterable
                                :data="list_hoc_ky" :fields="['name','value']" />
                        </el-col>
                        <el-col :span="6">
                            <label class="typo__label">Giai đoạn</label>
                            <eselect style="width:100%" collapseTags v-model="maGiaiDoan" :placeholder="'Chọn'"
                                filterable :data="list_giai_doan" :fields="['name','value']" />
                        </el-col>
                        <el-col :span="6">
                            <label class="typo__label">Tiêu chí gốc <sup class="red">*</sup></label>
                            <eselect style="width:100%" collapseTags v-model="tieuChiGoc" @change="ChonTieuChiGoc"
                                :placeholder="'Chọn'" filterable :data="danh_sach_tieu_chi_goc"
                                :fields="['name','value']" />
                        </el-col>
                        <el-col :span="4">
                            <label class="typo__label">Mã tiêu chí</label>
                            <input disabled class="form-control" placeholder="Nhập..." v-model="maTieuChi">
                        </el-col>
                        <el-col :span="8">
                            <label class="typo__label">Tên tiêu chí</label>
                            <input class="form-control" disabled placeholder="Nhập..." v-model="tenTieuChi">
                        </el-col>
                        <el-col :span="24" class="text-center">
                            <el-button plain size="mini" v-on:click.prevent="TruocKhiTim()" type="success">Tìm kiếm
                            </el-button>
                            <el-button plain size="mini" @click.prevent="themTieuChiNgoai()" type="primary">Thêm
                                mới
                            </el-button>
                        </el-col>
                    </el-row>
                </div>
            </div>
            <el-row :gutter="24">
                <el-col :span="24" style="padding:0">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <el-row :gutter="24">
                                <el-col :span="8" class="reset">
                                    <ChonSoLuong @chonXongSoLuong="ChonSoLuongBanGhi($event)">
                                    </ChonSoLuong>
                                </el-col>
                                <el-col :span="16" class="reset">
                                    <div class="text-right" style="padding-bottom:5px">
                                        <el-tooltip content="Tùy chọn nội dung hiển thị" placement="top">
                                            <el-button type="info" size="mini" data-toggle="collapse"
                                                data-target="#tuychonhienthi">Tùy chọn
                                                hiển
                                                thị
                                            </el-button>
                                        </el-tooltip>
                                    </div>
                                </el-col>
                            </el-row>
                            <el-row :gutter="24">
                                <el-col :span="24">
                                    <div id="tuychonhienthi" class="collapse">
                                        <input v-model="hienThiTatCa" @change="chonHienThiTatCa" type="checkbox" />
                                        <span style="padding-right:15px">Tất cả</span>
                                        <input v-model="hienThi.donViQuanLy" type="checkbox" />
                                        <span style="padding-right:15px">Đơn vị quản lý</span>
                                        <input v-model="hienThi.capHoc" type="checkbox" />
                                        <span style="padding-right:15px">Cấp học</span>
                                        <input v-model="hienThi.maTruongHoc" type="checkbox" />
                                        <span style="padding-right:15px">Trường học</span>
                                        <input v-model="hienThi.namHoc" type="checkbox" />
                                        <span style="padding-right:15px">Năm học</span>
                                        <input v-model="hienThi.hocKy" type="checkbox" />
                                        <span style="padding-right:15px">Học kỳ</span>
                                        <input v-model="hienThi.maGiaiDoan" type="checkbox" />
                                        <span style="padding-right:15px">Giai đoạn</span>
                                        <input disabled v-model="hienThi.tenTieuChi" type="checkbox" />
                                        <span style="padding-right:15px">Tên tiêu chí</span>
                                        <input disabled v-model="hienThi.maTieuChi" type="checkbox" />
                                        <span style="padding-right:15px">Mã tiêu chí</span>
                                        <input disabled v-model="hienThi.maNhapLieu" type="checkbox" />
                                        <span style="padding-right:15px">Mã nhập liệu</span>
                                        <input disabled v-model="hienThi.giaTri" type="checkbox" />
                                        <span style="padding-right:15px">Giá trị</span>
                                    </div>
                                </el-col>
                            </el-row>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr style="background:rgb(228, 235, 245)">
                                            <th class="text-center">
                                                <p>STT</p>
                                            </th>
                                            <th class="text-center" style="min-width:200px" v-if='hienThi.donViQuanLy'>
                                                <p>Đơn vị quản lý</p>
                                            </th>
                                            <th class="text-center" v-if='hienThi.capHoc' style="width:min-100px">
                                                <p>Cấp học</p>
                                            </th>
                                            <th class="text-center" v-if='hienThi.maTruongHoc' style="min-width:200px">
                                                <p>Trường học</p>
                                            </th>
                                            <th class="text-center" v-if='hienThi.namHoc' style="min-width:100px">
                                                <p>Năm học</p>
                                            </th>
                                            <th class="text-center" v-if='hienThi.hocKy' style="min-width:100px">
                                                <p>Học kỳ</p>
                                            </th>
                                            <th class="text-center" v-if='hienThi.maGiaiDoan' style="min-width:100px">
                                                <p>Giai đoạn</p>
                                            </th>
                                            <th class="text-center" v-if='hienThi.tenTieuChi'>
                                                <p>Tên tiêu chí</p>
                                            </th>
                                            <th class="text-center" v-if='hienThi.maTieuChi'>
                                                <p>Mã tiêu chí</p>
                                            </th>
                                            <th class="text-center" v-if='hienThi.maNhapLieu'>
                                                <p>Mã nhập liệu</p>
                                            </th>
                                            <th class="text-center" v-if='hienThi.giaTri'>
                                                <p>Giá trị</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Thao tác</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="danh_sach_du_lieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="10">
                                                <p>Không có bản ghi nào</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr v-for="(tt,index) in danh_sach_du_lieu" v-bind:class="getClass(tt)"
                                            :key='index'>
                                            <td class="text-center">
                                                <p>{{(currentPage-1)*limit + index+1}}</p>
                                            </td>
                                            <td v-if='hienThi.donViQuanLy'>
                                                <template v-if="tt.type!='add'&&tt.type!='update'">
                                                    <p>{{getTenDonVi(tt.maDonViQuanLy)}}</p>
                                                </template>
                                                <template v-else>
                                                    <eselect collapseTags v-model="tt.maDonViQuanLy"
                                                        @change="ChonDonViThem(tt)" :disabled="thongtin.role>=4"
                                                        style="min-width:200px" :placeholder="'Chọn'" filterable
                                                        :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                                                </template>
                                            </td>
                                            <td v-if='hienThi.capHoc'>
                                                <template v-if="tt.type!='add'&&tt.type!='update'">
                                                    <p>{{getTenCapHoc(tt.capHocList)}}</p>
                                                </template>
                                                <template v-else>
                                                    <eselect collapseTags v-model="tt.capHocList"
                                                        :disabled="thongtin.role==5" :placeholder="'Chọn'"
                                                        @change="ChonDonViThem(tt)" style="min-width:100px" filterable
                                                        :data="list_cap_hoc" :fields="['name','id']" />
                                                </template>
                                            </td>
                                            <td v-if='hienThi.maTruongHoc'>
                                                <template v-if="tt.type!='add'&&tt.type!='update'">
                                                    <p>{{getTenTruongHoc(tt.maTruongHoc)}}</p>
                                                </template>
                                                <template v-else>
                                                    <eselect style="width:100%;min-width:200px" collapseTags
                                                        @change="tinhToanMaNhapLieu(tt)" :disabled="thongtin.role==5"
                                                        v-model="tt.maTruongHoc" :placeholder="'Chọn'" filterable
                                                        :data="list_truong_hoc_them"
                                                        :fields="['tenTruongHoc','maTruongHoc']" />
                                                </template>
                                            </td>
                                            <td class="text-center" v-if='hienThi.namHoc'>
                                                <template v-if="tt.type!='add'&&tt.type!='update'">
                                                    <p>{{tt.namHoc}} - {{tt.namHoc+1}}</p>
                                                </template>
                                                <template v-else>
                                                    <eselect style="width:100%;min-width:100px" collapseTags
                                                        @change="tinhToanMaNhapLieu(tt)" v-model="tt.namHoc"
                                                        :placeholder="'Chọn'" filterable :data="list_nam_hoc"
                                                        :fields="['name','id']" />
                                                </template>
                                            </td>
                                            <td class="text-center" v-if='hienThi.hocKy'>
                                                <template v-if="tt.type!='add'&&tt.type!='update'">
                                                    <p>{{tt.hocKy}}</p>
                                                </template>
                                                <template v-else>
                                                    <eselect collapseTags v-model="tt.hocKy" :placeholder="'Chọn'"
                                                        @change="tinhToanMaNhapLieu(tt)" style="min-width:100px"
                                                        filterable :data="list_hoc_ky" :fields="['name','value']" />
                                                </template>
                                            </td>
                                            <td class="text-center" v-if='hienThi.maGiaiDoan'>
                                                <template v-if="tt.type!='add'&&tt.type!='update'">
                                                    <p>{{tt.maGiaiDoan}}</p>
                                                </template>
                                                <template v-else>
                                                    <eselect style="width:100%;min-width:100px" collapseTags
                                                        @change="tinhToanMaNhapLieu(tt)" v-model="tt.maGiaiDoan"
                                                        :placeholder="'Chọn'" filterable :data="list_giai_doan"
                                                        :fields="['name','value']" />
                                                </template>
                                            </td>
                                            <td v-if='hienThi.tenTieuChi'>
                                                <p>{{tt.tenTieuChi}} </p>
                                            </td>
                                            <td v-if='hienThi.maTieuChi'>
                                                <p>{{tt.maTieuChi}}</p>
                                            </td>
                                            <td v-if='hienThi.maNhapLieu'>
                                                <p v-if="tt.type!='add'&&tt.type!='update'">{{tt.maNhapLieu}}</p>
                                                <p v-else style="color:blue">{{tt.maNhapLieu}}</p>
                                            </td>
                                            <td v-if='hienThi.giaTri'>
                                                <p v-if="tt.type!='add'&&tt.type!='update'">{{tt.giaTri}}</p>
                                                <input style="min-width:70px" type="text"
                                                    @input="tinhToanMaNhapLieu(tt)"
                                                    v-if="tt.type=='add'||tt.type=='update'" placeholder="Nhập..."
                                                    class="form-control" v-model="tt.giaTri">
                                            </td>
                                            <td class="text-center">
                                                <el-tooltip v-if='tt.type!="add"&&tt.type!="update"' content="Chỉnh sửa"
                                                    placement="top">
                                                    <el-button plain type="warning" @click.prevent="chinhSuaTieuChi(tt)"
                                                        size="mini">
                                                        <i class="el-icon-edit"></i>
                                                    </el-button>
                                                </el-tooltip>
                                                <el-tooltip v-if='tt.type!="add"&&tt.type!="update"' content="Clone"
                                                    placement="top">
                                                    <el-button plain type="info" @click.prevent="cloneTieuChi(tt)"
                                                        size="mini">
                                                        <i class="el-icon-document-copy"></i>
                                                    </el-button>
                                                </el-tooltip>
                                                <el-tooltip v-if='tt.type!="add"&&tt.type!="update"' content="Xóa"
                                                    placement="top">
                                                    <el-button plain type="danger" @click.prevent="xoaTieuChi(tt)"
                                                        size="mini">
                                                        <i class="el-icon-delete-solid"></i>
                                                    </el-button>
                                                </el-tooltip>
                                                <el-tooltip v-if='tt.type=="add"||tt.type=="update"' content="Lưu lại"
                                                    placement="top">
                                                    <el-button plain type="primary" @click.prevent="LuuLaiTieuChi(tt)"
                                                        size="mini">
                                                        <i class="el-icon-check"></i>
                                                    </el-button>
                                                </el-tooltip>
                                                <el-tooltip v-if='tt.type=="add"||tt.type=="update"' content="Hủy"
                                                    placement="top">
                                                    <el-button plain type="danger" @click.prevent="HuyThemMoi(tt)"
                                                        size="mini">
                                                        <i class="el-icon-error"></i>
                                                    </el-button>
                                                </el-tooltip>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <PhanTrang v-show="total_rows>0" :tongbanghi="total_rows"
                                :soluonghienthi="soLuongBanGhiHienThi" :batdau="trangbatdau"
                                @pageChange="layLai($event)">
                            </PhanTrang>
                        </div>
                    </div>
                </el-col>
            </el-row>
        </div>
        <!-- Thêm mới tiêu chí -->
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import PhanTrang from "../../ui/PhanTrang";
    import ChonSoLuong from "../../ui/chonSoLuongBanGhi";
    import ESelectVue from '../../ui/ESelect.vue';
    import rest_api from "../../../utils/rest_api";
    import constant from '../../../utils/constant';
    Vue.use(ElementUI);
    export default {
        props: ['trangcu'],
        components: {
            "PhanTrang": PhanTrang,
            'eselect': ESelectVue,
            ChonSoLuong: ChonSoLuong,
        },
        computed: {},
        data() {
            return {
                loading: false,
                thongtin: JSON.parse(window.userInfo),
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                soLuongBanGhiHienThi: 25,
                danh_sach_du_lieu: [],
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_giai_doan: [{
                        name: 'Giữa kỳ I',
                        value: 'GKI'
                    },
                    {
                        name: 'Cuối kỳ I',
                        value: 'CKI'
                    },
                    {
                        name: 'Giữa kỳ II',
                        value: 'GKII'
                    },
                    {
                        name: 'Cuối kỳ II',
                        value: 'CKII'
                    }
                ],
                list_hoc_ky: [{
                        name: "Học kỳ I",
                        value: 1
                    },
                    {
                        name: "Học kỳ II",
                        value: 2
                    },
                    {
                        name: "Cả năm",
                        value: 3
                    },
                ],
                checkAdd: false,
                trangbatdau: false,
                tieuChiGoc: "",
                danh_sach_tieu_chi_goc: [],
                list_don_vi: [],
                list_truong_hoc: [],
                list_truong_hoc_them: [],
                maDonViQuanLy: '',
                capHoc: '',
                maTruongHoc: '',
                namHoc: '',
                hocKy: '',
                maGiaiDoan: '',
                tenTieuChi: '',
                maTieuChi: '',
                hienThiTatCa: false,
                show_them_moi_tieu_chi: false,
                show_chinh_sua_tieu_chi: false,
                hienThi: {
                    donViQuanLy: true,
                    capHoc: false,
                    maTruongHoc: true,
                    namHoc: true,
                    hocKy: false,
                    maGiaiDoan: false,
                    tenTieuChi: true,
                    maTieuChi: true,
                    giaTri: true,
                    maNhapLieu: true,
                },
                du_lieu_chinh_sua: {}
            };
        },
        mounted() {
            console.log(this.thongtin)
            if (this.thongtin.role == 4) {
                this.maDonViQuanLy = this.thongtin.ma_phong;
            }
            if (this.thongtin.role == 5) {
                this.maDonViQuanLy = this.thongtin.ma_don_vi;
                this.maTruongHoc = this.thongtin.ma_truong_hoc;
                this.capHoc = this.thongtin.listCapHoc[0]
            }
            // console.log(this.trangcu)
            if (this.trangcu && this.trangcu != []) {
                let mtc = JSON.parse(this.trangcu);
                console.log(mtc)
                this.tieuChiGoc = mtc.maTieuChi
                this.maTieuChi = mtc.maTieuChi
                console.log(this.tieuChiGoc)
            }
            this.getDanhSachTieuChiGoc();
            this.getDonVi();
            this.getDanhSachToanBoTruong();
            console.log("Thông tin đăng nhập:")
            console.log(this.thongtin);
            this.namHoc = this.thongtin.namHocHienTai;
            this.getData();
            window
                .history
                .replaceState("", "Cơ sở dữ liệu ngành", "dynamic-report-external-indicator");
        },
        watch: {},
        methods: {
            tinhToanMaNhapLieu(e) {
                console.log('Tính toán mã nhập liệu')
                let params = e;
                if (params.maDonViQuanLy && params.maDonViQuanLy != '') {
                    console.log(params.maDonViQuanLy.length);
                    if (params.maDonViQuanLy.length == 2) {
                        params.maSo = this.thongtin.ma_so
                    }
                    if (params.maDonViQuanLy.length == 3) {
                        params.maSo = this.thongtin.ma_so
                        params.maPhong = params.maDonViQuanLy
                    }
                } else {
                    params.maSo = this.thongtin.ma_so
                    params.maPhong = ''
                }
                let tieu_chi_nhap = params.maTieuChi;
                if (params.maSo && params.maSo != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.maSo;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.maPhong && params.maPhong != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.maPhong;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.capHocList && params.capHocList != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.capHocList;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.maTruongHoc && params.maTruongHoc != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.maTruongHoc;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.namHoc && params.namHoc != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.namHoc;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.hocKy && params.hocKy != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.hocKy;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.maGiaiDoan && params.maGiaiDoan != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.maGiaiDoan;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                params.maNhapLieu = tieu_chi_nhap;
                console.log(params)
            },
            ChonDonViThem(e) {
                let item = e;
                item.maTruongHoc = '';
                this.list_truong_hoc_them = [];
                this.tinhToanMaNhapLieu(item);
                this.getTruongHocThem(e);
            },
            getClass(e) {
                if (e.type == 'add' || e.type == 'update') {
                    return ('themMoi')
                }
            },
            HuyThemMoi(e) {
                let data = e;
                if (data.type == 'update') {
                    this.$confirm('Xác nhận thao tác?', 'Thông báo', {
                            confirmButtonText: 'Xác nhận',
                            cancelButtonText: 'Hủy',
                            closeOnClickModal: false,
                        })
                        .then(_ => {
                            this.checkAdd = false;
                            if (data.type == 'update') {
                                data.type = '';
                            } else {
                                this.danh_sach_du_lieu.pop();
                            }
                        })
                        .catch(_ => {});
                } else {
                    this.checkAdd = false;
                    this.danh_sach_du_lieu.pop();
                }
            },
            chonHienThiTatCa() {
                console.log("Chọn hiển thị tất cả:")
                console.log(this.hienThiTatCa)
                if (this.hienThiTatCa) {
                    this.hienThi.donViQuanLy = true;
                    this.hienThi.capHoc = true;
                    this.hienThi.maTruongHoc = true;
                    this.hienThi.namHoc = true;
                    this.hienThi.hocKy = true;
                    this.hienThi.maGiaiDoan = true;
                } else {
                    this.hienThi.donViQuanLy = false;
                    this.hienThi.capHoc = false;
                    this.hienThi.maTruongHoc = false;
                    this.hienThi.namHoc = false;
                    this.hienThi.hocKy = false;
                    this.hienThi.maGiaiDoan = false;
                }
            },
            LuuLaiTieuChi(e) {
                console.log("Lưu lại tiêu chí:")
                let params = e;
                if (!params.giaTri || params.giaTri == "") {
                    this.thongBao('error', "Vui lòng nhập giá trị.");
                    return
                }

                if (params.maDonViQuanLy && params.maDonViQuanLy != '') {
                    console.log(params.maDonViQuanLy.length);
                    if (params.maDonViQuanLy.length == 2) {
                        params.maSo = this.thongtin.ma_so
                    }
                    if (params.maDonViQuanLy.length == 3) {
                        params.maSo = this.thongtin.ma_so
                        params.maPhong = params.maDonViQuanLy
                    }
                } else {
                    params.maSo = this.thongtin.ma_so
                    params.maPhong = ''

                }
                let tieu_chi_nhap = params.maTieuChi;
                if (params.maSo && params.maSo != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.maSo;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.maPhong && params.maPhong != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.maPhong;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.capHocList && params.capHocList != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.capHocList;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.maTruongHoc && params.maTruongHoc != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.maTruongHoc;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.namHoc && params.namHoc != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.namHoc;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.hocKy && params.hocKy != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.hocKy;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                if (params.maGiaiDoan && params.maGiaiDoan != '') {
                    tieu_chi_nhap = tieu_chi_nhap + '_' + params.maGiaiDoan;
                } else {
                    tieu_chi_nhap = tieu_chi_nhap + '_all'
                }
                params.maNhapLieu = tieu_chi_nhap;
                var uri = '';
                let msg = '';
                var check = '';
                if (params.type == 'update') {
                    check = 'update';
                    uri = '/csdlgd-analytic-api/external-data/update';
                    msg = "Xác nhận thêm mới thông tin?"
                }
                if (params.type == 'add') {
                    check = 'add';
                    uri = '/csdlgd-analytic-api/external-data/insert';
                    msg = "Xác nhận chỉnh sửa thông tin?";
                }
                console.error(params)
                var du_lieu = JSON.parse(JSON.stringify(params));
                if (params.type == 'update') {
                    this.$confirm(msg, 'Thông báo', {
                            confirmButtonText: 'Xác nhận',
                            cancelButtonText: 'Hủy',
                            closeOnClickModal: false,
                        })
                        .then(_ => {
                            console.log("Thông tin thêm:")
                            // delete params.type;
                            rest_api.post(uri, params, response => {
                                console.log('thêm mới trả về:')
                                console.log(response)
                                if (response.data.rc == 0) {
                                    this.thongBao('success', 'Chỉnh sửa thành công');
                                    this.checkAdd = false;
                                    this.getData();
                                } else {
                                    this.thongBao('error', response.data.rd)
                                }
                            });
                        })
                        .catch(_ => {});
                } else {
                    console.log("Thông tin thêm:")
                    // delete params.type;
                    rest_api.post(uri, params, response => {
                        console.log('thêm mới trả về:')
                        console.log(response)
                        if (response.data.rc == 0) {
                            this.thongBao('success', 'Thêm mới thành công');
                            // this.checkAdd = false;
                            // du_lieu.type = '';
                            // this.danh_sach_du_lieu.pop();
                            // this.danh_sach_du_lieu.push(du_lieu)
                            this.getData();
                        } else {
                            this.thongBao('error', response.data.rd)
                        }
                    });
                }
            },
            themTieuChiNgoai() {
                if (this.checkAdd == true) {
                    this.thongBao('error', 'Có tiêu chí chưa được lưu lại');
                    return;
                }
                if (!this.maTieuChi || this.maTieuChi == "") {
                    this.thongBao('error', 'Vui lòng bổ sung tiêu chí gốc.');
                    return;
                }
                let obj = {
                    type: 'add',
                    capHocList: this.capHoc,
                    giaTri: '',
                    hocKy: this.hocKy,
                    maDonViQuanLy: this.maDonViQuanLy,
                    maGiaiDoan: this.maGiaiDoan,
                    maTieuChi: this.maTieuChi,
                    maTruongHoc: this.maTruongHoc,
                    namHoc: this.namHoc,
                    tenTieuChi: this.tenTieuChi,
                    maNhapLieu: '',
                }
                this.danh_sach_du_lieu.push(obj);
                this.checkAdd = true;
            },
            ChonTieuChiGoc() {
                console.log(this.tieuChiGoc);
                this.tenTieuChi = "";
                this.maTieuChi = "";
                if (this.tieuChiGoc && this.tieuChiGoc != '') {
                    for (let i = 0; i < this.danh_sach_tieu_chi_goc.length; i++) {
                        if (this.danh_sach_tieu_chi_goc[i].value == this.tieuChiGoc) {
                            console.log("Chính là thằng này:")
                            console.log(this.danh_sach_tieu_chi_goc[i]);
                            this.tenTieuChi = this.danh_sach_tieu_chi_goc[i].label;
                            this.maTieuChi = this.danh_sach_tieu_chi_goc[i].value;
                        }
                    }
                }
            },
            getTenDonVi(e) {
                let name = "";
                if (e) {
                    for (let i = 0; i < this.list_don_vi.length; i++) {
                        if (this.list_don_vi[i].maDonVi == e) {
                            name = this.list_don_vi[i].tenDonVi
                        }
                    }
                }
                return name;
            },
            getTenCapHoc(e) {
                let name = "";
                if (e) {
                    for (let i = 0; i < this.list_cap_hoc.length; i++) {
                        if (this.list_cap_hoc[i].id == e) {
                            name = this.list_cap_hoc[i].name
                        }
                    }
                }
                return name;
            },
            getTenTruongHoc(e) {
                let name = "";
                if (e) {
                    for (let i = 0; i < this.list_truong_hoc.length; i++) {
                        if (this.list_truong_hoc[i].maTruongHoc == e) {
                            name = this.list_truong_hoc[i].tenTruongHoc
                        }
                    }
                }
                return name;
            },
            xoaTieuChi(e) {
                this.$confirm('Xác nhận xóa tiêu chí?', 'Xóa tiêu chí', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass: 'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.loading = true;
                        let params = {
                            id: e.idStr
                        }
                        rest_api.get("/csdlgd-analytic-api/external-data/delete", params, response => {
                            this.loading = false;
                            console.log(response)
                            // this.thongBao('success', 'Xóa dữ liệu thành công.')
                            if (response.data.rc == 0) {
                                this.thongBao("success", response.data.rd);
                                this.getData();
                            } else {
                                this.thongBao("error", response.data.rd);
                            }
                        });
                    })
                    .catch(_ => {});
            },
            cloneTieuChi(e) {
                if (this.checkAdd == true) {
                    this.thongBao('error', 'Có tiêu chí chưa được lưu lại');
                    return;
                }
                let data = JSON.parse(JSON.stringify(e));
                delete data.id;
                delete data.idStr;
                data.type = 'add';
                this.danh_sach_du_lieu.push(data);
                this.checkAdd = true;
            },
            chinhSuaTieuChi(e) {
                let data = e;
                if (this.checkAdd) {
                    this.thongBao('error', 'Có tiêu chí chưa được lưu lại')
                    return;
                }
                this.checkAdd = true;
                data.type = 'update'
            },
            ChonCapHoc() {
                this.maTruongHoc = '';
                this.list_truong_hoc = [];
                this.getDanhSachToanBoTruong();
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
            getTruongHocThem(e) {
                let item = e;
                this.loading = true;
                this.list_truong_hoc_them = [];
                let params = {
                    maDonVi: [],
                    capHoc: []
                };
                if (item.maDonViQuanLy) {
                    params.maDonVi = [item.maDonViQuanLy];
                }
                if (item.capHocList && item.capHocList != '') {
                    params.capHoc = [item.capHocList];
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    this.loading = false;
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
                        this.list_truong_hoc_them = ldv;
                    } else {
                        this.list_truong_hoc_them = [];
                    }
                });
            },
            getDanhSachToanBoTruong() {
                this.loading = true;
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: [],
                    capHoc: []
                };
                if (this.maDonViQuanLy) {
                    params.maDonVi = [this.maDonViQuanLy];
                }
                if (this.capHoc) {
                    params.capHoc = [this.capHoc];
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    this.loading = false;
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
                        this.list_truong_hoc_them = ldv;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },
            getDanhSachTruong(e) {
                let data = [];
                let don_vi = e;
                if (don_vi) {
                    for (let i = 0; i < don_vi.length; i++) {
                        for (let j = 0; j < this.list_truong_hoc.length; j++) {
                            if (don_vi[i] == this.list_truong_hoc[j].maDonVi) {
                                data.push(this.list_truong_hoc[j])
                            }
                        }
                    }
                }
                return data;
            },
            getDanhSachTieuChiGoc() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let url = "/csdlgd-analytic-api/criteria/search?skip=0&limit=9999"
                const params = {
                    "doiTuong": 'Custom',
                    "maTieuChi": '',
                    "tenTieuChi": '',
                    "textSreach": '',
                    "tieuChiHeThong": false,
                };
                this.danh_sach_tieu_chi_goc = [];
                rest_api.post(url, params, response => {
                    loading.close();
                    console.log("response:")
                    console.error(response)
                    if (response.data.rc == 0) {
                        let data = response.data.rows;
                        if (data.length > 0) {
                            for (let i = 0; i < data.length; i++) {
                                let obj = {
                                    name: data[i].tenTieuChi + " - [" + data[i].maTieuChi + "]",
                                    value: data[i].maTieuChi,
                                    label: data[i].tenTieuChi
                                }
                                if (data[i].maTieuChi == this.tieuChiGoc) {
                                    this.tenTieuChi = data[i].tenTieuChi;
                                }
                                this.danh_sach_tieu_chi_goc.push(obj);
                            }
                        } else {
                            this.thongBao('error', 'Vui lòng bổ sung tiêu chí hệ thống.')
                        }
                    } else {}
                });
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                this.list_don_vi = [];
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
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
                    } else {}
                });
            },
            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                console.log("Chọn số lượng bản ghi:")
                console.log(JSON.stringify(e));
                this.soLuongBanGhiHienThi = e.soluong;
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            TruocKhiTim() {
                console.log("Ấn tìm kiếm")
                this.total_rows = 0;
                this.trangbatdau = !this.trangbatdau;
            },
            getData() {
                if (!this.tieuChiGoc) {
                    this.thongBao('error', 'Vui lòng bổ sung tiêu chí gốc.')
                    return;
                }
                this.loading = true;
                this.checkAdd = false;
                this.show_them_moi_tieu_chi = false;
                this.show_chinh_sua_tieu_chi = false;
                let analyticExternalData = {};
                if (this.maDonViQuanLy) {
                    analyticExternalData.maDonViQuanLy = this.maDonViQuanLy
                }
                if (this.maGiaiDoan) {
                    analyticExternalData.maGiaiDoan = this.maGiaiDoan
                }
                if (this.maTieuChi) {
                    analyticExternalData.maTieuChi = this.maTieuChi
                }
                if (this.maTruongHoc) {
                    analyticExternalData.maTruongHoc = this.maTruongHoc
                }
                if (this.tenTieuChi) {
                    analyticExternalData.tenTieuChi = this.tenTieuChi
                }
                if (this.namHoc) {
                    analyticExternalData.namHoc = this.namHoc
                }
                let params = {
                    start: this.start,
                    limit: this.limit,
                    analyticExternalData
                }
                this.danh_sach_du_lieu = [];
                this.total_rows = 0;
                rest_api.post("/csdlgd-analytic-api/external-data/find-all", params, data => {
                    this.loading = false;
                    console.log("Danh sách tiêu chí ngoài:")
                    console.log(data)
                    if (data.statusText == 'OK') {
                        console.log("Lấy thành công");
                        if (data.data.content.length >= 1) {
                            data.data.content.forEach(item => {
                                item.type = '';
                                if (item.capHocList) {
                                    item.capHocList = parseInt(item.capHocList);
                                }
                                this.danh_sach_du_lieu.push(item)
                            })
                            this.total_rows = data.data.totalElements
                            // this.thongBao('success', 'Lấy dữ liệu thành công')
                        } else {
                            // this.thongBao('error', 'Không có bản ghi nào được tìm thấy')
                        }
                    } else {
                        this.thongBao('error', data.data.rd)
                    }
                });
            }
        }
    };

</script>
<style scoped="scoped">
    .themMoi {
        background: #a5d8c0 !important;
    }

</style>

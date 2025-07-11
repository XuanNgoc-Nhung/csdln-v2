<template>
    <div v-loading.fullscreen.lock="fullScreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <Breadcrumb :menu="'Danh mục'" :desc="'Tổ thôn'" />

        <el-form ref="ruleForm">
            <el-row :gutter="24" class="card-bieu-do">
                <el-col :span="24">
                    <div class="table-name">Thông tin tìm kiếm</div>
                </el-col>

                <el-col :sm="12"  :md="12" :lg="6">
                    <label>Tỉnh thành</label>
                    <div>
                        <eselect style="width:100%" :disabled="thongtin.role>1" collapseTags v-model="maSo"
                                 :placeholder="'Chọn'" @change="ChonTinhThanh" filterable :data="list_don_vi_so"
                                 :fields="['name','value']" />
                    </div>
                </el-col>
                <el-col :sm="12"  :md="12" :lg="6">
                    <label>Quận huyện</label>
                    <div>
                        <eselect style="width:100%" :disabled="thongtin.role>3" collapseTags @change="ChonQuanHuyen"
                                 v-model="maQuanHuyen" :placeholder="'Chọn'" filterable :data="list_don_vi_huyen"
                                 :fields="['name','value']" />
                    </div>
                </el-col>
                <el-col :sm="12"  :md="12" :lg="6">
                    <label>Phường xã</label>
                    <eselect style="width:100%" collapseTags v-model="maPhuongXa" :placeholder="'Chọn'" filterable
                             :data="list_don_vi_xa" :fields="['name','value']" />
                </el-col>
                <el-col :sm="12"  :md="12" :lg="6">
                    <label>Tên tổ thôn</label>
                    <el-input clearable v-model="tenToThon" @change="tenToThon = tenToThon.trim()"
                              placeholder="Nhập..." />
                </el-col>
                <el-col :sm="12"  :md="12" :lg="6">
                    <label>Mã tổ thôn</label>
                    <el-input clearable v-model="maToThon" @change="maToThon = maToThon.trim()" placeholder="Nhập..." />
                </el-col>
                <el-col :sm="12"  :md="12" :lg="6">
                    <label>Trạng thái</label>
                    <eselect style="width:100%" collapseTags v-model="trangThai" :placeholder="'Chọn'" filterable
                             :data="list_trang_thai" :fields="['name','value']" />
                </el-col>
                <el-col :span="24" class="text-center">
                    <el-button class="bt-chinh" size="mini" type="success" v-on:click.prevent="TruocKhiTim()">Tìm kiếm
                    </el-button>
                </el-col>

            </el-row>
        </el-form>
        <el-row :gutter="24" class="card-bieu-do">
            <!-- <el-col :span="12">
                <label>Danh sách tổ thôn</label>
            </el-col>
            <el-col :span="12" class="text-right">
                <el-button class="bt-phu" size="mini" type="primary" @click.prevent="showImport()">Nhập theo biểu mẫu
                </el-button>
                <el-button class="bt-chinh" size="mini" type="primary" @click.prevent="showThemMoi()">Thêm mới
                </el-button>
            </el-col> -->
            
            <el-col :span="24">
                <div class="centerBetweenFlex">
                    <label class="table-name">Danh sách tổ thôn</label>
                    <div class="text-right">
                        <el-button class="bt-phu" style="margin-left:5px;" @click.prevent="showImport" size="mini"
                            type="primary">Nhập theo
                            biểu mẫu
                        </el-button>
                        <el-button class="bt-chinh" type="success" size="mini" @click.prevent="showThemMoi"> Thêm mới
                        </el-button>
                    </div>
                </div>
            </el-col>
            <el-col :span="24" class="table-header">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr style="background:rgb(228, 235, 245)">
                                <th class="text-center fixed-column fixed-col1">
                                    <p>STT</p>
                                </th>

                                <th class="text-center ">
                                    <p>Mã tổ thôn</p>
                                </th>
                                <th>
                                    <p>Tên tổ thôn</p>
                                </th>
                                <th>
                                    <p>Phường xã</p>
                                </th>
                                <th>
                                    <p>Quận huyện</p>
                                </th>
                                <th>
                                    <p>Tỉnh thành</p>
                                </th>
                                <th>
                                    <p>Ngày cập nhật</p>
                                </th>
                                <th class="text-center">
                                    <p>Trạng thái</p>
                                </th>
                                <th class="text-center">
                                    <p>Thao tác</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="list_data.length===0">
                            <tr>
                                <td class="text-center" colspan="23">
                                    <p>Không có bản ghi nào</p>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="(qh,index) in list_data" :key="index">
                                <td class="text-center fixed-column fixed-col1">
                                    <p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                </td>

                                <td class="text-center">
                                    <p>{{ qh.maToThon }}</p>
                                </td>
                                <td>
                                    <p>{{ qh.tenToThon }}</p>
                                </td>
                                <td>
                                    <p>{{ qh.tenPhuongXa }}</p>
                                </td>
                                <td>
                                    <p>{{ qh.tenQuanHuyen }}</p>
                                </td>
                                <td>
                                    <p>{{ qh.tenTinhThanh }}</p>
                                </td>
                                <td>
                                    <p>{{ getTime(qh.ngayCapNhat) }}</p>
                                </td>
                                <td class="text-center">
                                    <p v-bind:class="getClass(qh.trangThai)">
                                        {{ parseInt(qh.trangThai) === 1 ? 'Đang hoạt động' : 'Ngưng hoạt động' }}</p>
                                </td>
                                <td class="text-center ">
                                    <el-tooltip v-if="qh.trangThai==1" content="Khóa " placement="top">
                                        <!-- <el-button type="warning"  size="mini"> -->
                                        <i class="el-icon-lock" @click.prevent="thayDoiTrangThai(qh,1)"
                                           style="color: white;"></i>
                                        <!-- </el-button> -->
                                    </el-tooltip>
                                    <el-tooltip v-else content="Mở khóa" placement="top">
                                        <!-- <el-button type="success" @click.prevent="thayDoiTrangThai(qh,2)" size="mini"> -->
                                        <i class="el-icon-unlock" @click.prevent="thayDoiTrangThai(qh,2)"
                                           style="color: white;"></i>
                                        <!-- </el-button> -->
                                    </el-tooltip>
                                    <el-tooltip content="Chỉnh sửa" placement="top">
                                        <!-- <el-button type="warning" @click.prevent="chinhSuaPhuongXa(qh)" size="mini"> -->
                                        <i class="el-icon-edit" @click.prevent="chinhSuaPhuongXa(qh)"
                                           style="color: white;"></i>
                                        <!-- </el-button> -->
                                    </el-tooltip>
                                    <el-tooltip content="Xóa" placement="top">
                                        <!-- <el-button type="danger"  size="mini"> -->
                                        <i class="el-icon-delete" @click.prevent="xoaPhuongXa(qh)"
                                           style="color: white;"></i>
                                        <!-- </el-button> -->
                                    </el-tooltip>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </el-col>
            <el-col :span="24">
                <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                </Page>
            </el-col>
            <ImportQuanHuyen :info="thongTinImport" :show="show_import" @close="show_import=false"
                @success="onCreatedData($event)">
            </ImportQuanHuyen>

            <el-dialog :title="type==1?'Thêm mới tổ thôn':'Chỉnh sửa tổ thôn'" :visible.sync="show_add_or_update"
                width="80%" :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
                <el-form :model='dataAddOrUpdate' :rules="rules" ref="ruleForm">
                    <el-row :gutter="24" class="card-bieu-do">
                        <el-col :sm="12"  :md="12" :lg="8">
                            <label>Tỉnh thành <span style="color:#DC0101">*</span></label>
                            <el-form-item prop="maSoAdd">
                                <eselect style="width:100%" :disabled="thongtin.role>1" collapseTags
                                    @change="ChonTinhThanhAdd" v-model="dataAddOrUpdate.maSoAdd" :placeholder="'Chọn'"
                                    filterable :data="list_don_vi_so" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="12"  :md="12" :lg="8">
                            <label>Quận huyện <span style="color:#DC0101">*</span></label>
                            <el-form-item prop="maQuanHuyenAdd">
                                <eselect style="width:100%" :disabled="thongtin.role>3||type==2" collapseTags
                                    v-model="dataAddOrUpdate.maQuanHuyenAdd" @change="ChonQuanHuyenAdd"
                                    :placeholder="'Chọn'" filterable :data="list_don_vi_huyen_add"
                                    :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="12"  :md="12" :lg="8">
                            <label>Phường xã <span style="color:#DC0101">*</span> </label>
                            <el-form-item prop="maPhuongXaAdd">
                                <eselect style="width:100%" collapseTags :disabled="type==2"
                                    @change="check_confirm_come_back = true" v-model="dataAddOrUpdate.maPhuongXaAdd"
                                    :placeholder="'Chọn'" filterable :data="list_don_vi_xa_add"
                                    :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="12"  :md="12" :lg="8">
                            <label>Mã tổ thôn <span style="color:#DC0101">*</span></label>
                            <el-form-item prop="maToThonAdd">
                                <el-input clearable :disabled="type==2" v-model="dataAddOrUpdate.maToThonAdd"
                                    @change="check_confirm_come_back = true;dataAddOrUpdate.maToThonAdd=dataAddOrUpdate.maToThonAdd.trim()"
                                    placeholder="Nhập..." />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="12"  :md="12" :lg="8">
                            <label>Tên tổ thôn <span style="color:#DC0101">*</span></label>
                            <el-form-item prop="tenToThonAdd">
                                <el-input clearable v-model="dataAddOrUpdate.tenToThonAdd" placeholder="Nhập..."
                                    @change="check_confirm_come_back = true;dataAddOrUpdate.tenToThonAdd=dataAddOrUpdate.tenToThonAdd.trim()" />
                            </el-form-item>
                        </el-col>
                    </el-row>
                </el-form>
                <span slot="footer" class="dialog-footer">
                    <el-button class="bt-phu" type="default" @click="handleClose" size="mini">Đóng</el-button>
                    <el-button class="bt-chinh" size="mini" type="primary" @click.prevent="submitForm('ruleForm')">
                        {{ type == 1 ? 'Lưu' : 'Lưu' }}</el-button>
                </span>
            </el-dialog>
        </el-row>
    </div>
</template>
<script>
    import rest_api from '../../../utils/rest_api';
    import Page from '../../ui/PagingCustom';
    import timeutils from '../../../utils/time_utils';
    import utils from '../../../utils'
    import Import from './../pupupImportExcel/importChung.vue';
    import ESelectVue from '../../ui/ESelect.vue';
    import ElementUI from 'element-ui';
    import Breadcrumb from '../../ui/Breadcrumb.vue';

    Vue.use(ElementUI);
    export default {
        components: {
            "Page": Page,
            'eselect': ESelectVue,
            "ImportQuanHuyen": Import,
            Breadcrumb
        },
        computed: {},
        data() {
            return {
                fullScreenLoading: false,
                check_confirm_come_back: false,
                thongTinImport: {
                    title: 'Nhập tổ thôn',
                    pathImport: '/api-import-to-thon',
                    pathTemplate: '/templateImport/Template_To_Thon.xlsx'
                },
                thongtin: JSON.parse(window.userInfo),
                list_don_vi_so: [],
                list_don_vi_huyen: [],
                list_don_vi_huyen_add: [],
                list_don_vi_xa: [],
                list_don_vi_xa_add: [],
                list_data: [],
                list_trang_thai: [{
                        name: 'Đang hoạt động',
                        value: '1'
                    },
                    {
                        name: 'Ngưng hoạt động',
                        value: '0'
                    },
                ],
                type: null,
                typeUpdate: null,
                trangThaiUpdate: "",
                maSo: "",
                maSoAdd: "",
                maQuanHuyen: "",
                maQuanHuyenAdd: "",
                tenPhuongXa: "",
                tenPhuongXaAdd: "",
                maPhuongXa: "",
                maPhuongXaAdd: "",
                maToThon: "",
                maToThonAdd: "",
                tenToThon: "",
                tenToThonAdd: "",
                trangThai: "",
                start: 0,
                currentPage: 1,
                resTrang: 1,
                limit: 25,
                total_rows: 0,
                trangbatdau: false,
                show_import: false,
                show_add_or_update: false,
                dataAddOrUpdate: {
                    maSoAdd: '',
                    maQuanHuyenAdd: '',
                    maPhuongXaAdd: '',
                    maToThonAdd: '',
                    tenToThonAdd: '',
                },
                rules: {
                    maSoAdd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'blur'
                    }, ],
                    maQuanHuyenAdd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    maPhuongXaAdd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    maToThonAdd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    tenToThonAdd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                }
            }
        },
        mounted() {
            if (this.thongtin.role == 4) {
                this.maQuanHuyen = this.thongtin.ma_phong;
                this.dataAddOrUpdate.maQuanHuyenAdd = this.thongtin.ma_phong;
                this.getPhuongXa();
                this.getPhuongXaAdd();
            }
            if (this.thongtin.role > 1) {
                this.maSo = this.thongtin.ma_so;
                this.dataAddOrUpdate.maSoAdd = this.thongtin.ma_so;
                this.getQuanHuyen();
                this.getQuanHuyenAdd();
            }
            this.getDonVi();
            // this.getData();
        },
        watch: {},
        methods: {
            getClass(stt) {
                return stt == 1 ? 'banGhiDangHoatDong' : 'banGhiNgungHoatDong'
            },
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.themQuanHuyen();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
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
                            this.show_add_or_update = false;
                        })
                        .catch(_ => {});
                } else {
                    this.resetForm('ruleForm')
                    this.show_add_or_update = false;

                }
            },
            resetForm(formName) {
                this.dataAddOrUpdate = {
                    maSoAdd: '',
                    maQuanHuyenAdd: '',
                    maPhuongXaAdd: '',
                    maToThonAdd: '',
                    tenToThonAdd: '',
                };
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
            },
            ChonQuanHuyen() {
                this.maPhuongXa = "";
                this.list_don_vi_xa = [];
                if (this.maQuanHuyen) {
                    this.getPhuongXa();
                }
            },
            ChonQuanHuyenAdd() {
                this.check_confirm_come_back = true;
                this.dataAddOrUpdate.maPhuongXaAdd = "";
                this.list_don_vi_xa_add = [];
                if (this.dataAddOrUpdate.maQuanHuyenAdd) {
                    this.getPhuongXaAdd();
                }
            },
            ChonTinhThanh() {
                this.maQuanHuyen = "";
                this.maPhuongXa = "";
                this.list_don_vi_huyen = [];
                this.list_don_vi_xa = [];
                if (this.maSo) {
                    this.getQuanHuyen();
                }
            },
            ChonTinhThanhAdd() {
                this.check_confirm_come_back = true;
                this.dataAddOrUpdate.maQuanHuyenAdd = "";
                this.list_don_vi_huyen_add = [];
                if (this.dataAddOrUpdate.maSoAdd) {
                    this.getQuanHuyenAdd();
                }
            },
            getPhuongXa() {
                let params = {
                    start: 0,
                    limit: 999,
                    maTinhThanh: this.maSo,
                    maQuanHuyen: this.maQuanHuyen,
                };
                rest_api.get(
                    "/internal-api/dmPhuongXa/filter",
                    params,
                    data => {
                        if (data.data.statusResponse == 0) {
                            let dulieu = data.data.rows;
                            let ldvs = [];
                            for (let i = 0; i < dulieu.length; i++) {
                                let obj = {
                                    name: dulieu[i].tenPhuongXa +
                                        ' - [' + dulieu[i].maPhuongXa + ']',
                                    value: dulieu[i].maPhuongXa
                                }
                                ldvs.push(obj);
                            }

                            ldvs.sort((a, b) => (a.name > b.name) ? 1 : -1)
                            this.list_don_vi_xa = ldvs;
                        } else {
                            this.list_don_vi_xa = [];
                        }
                    },
                );
            },
            getPhuongXaAdd() {
                let params = {
                    start: 0,
                    limit: 999,
                    maTinhThanh: this.dataAddOrUpdate.maSoAdd,
                    maQuanHuyen: this.dataAddOrUpdate.maQuanHuyenAdd,
                };
                rest_api.get(
                    "/internal-api/dmPhuongXa/filter",
                    params,
                    data => {
                        if (data.data.statusResponse == 0) {
                            let dulieu = data.data.rows;
                            let ldvs = [];
                            for (let i = 0; i < dulieu.length; i++) {
                                let obj = {
                                    name: dulieu[i].tenPhuongXa +
                                        ' - [' + dulieu[i].maPhuongXa + ']',
                                    value: dulieu[i].maPhuongXa
                                }
                                ldvs.push(obj);
                            }

                            ldvs.sort((a, b) => (a.name > b.name) ? 1 : -1)
                            this.list_don_vi_xa_add = ldvs;
                        } else {
                            this.list_don_vi_xa_add = [];
                        }
                    },
                );
            },
            getQuanHuyen() {
                let params = {
                    start: 0,
                    limit: 999,
                    maTinhThanh: this.maSo
                };
                rest_api.get(
                    "/internal-api/dmQuanHuyen/filter",
                    params,
                    data => {
                        if (data.data.statusResponse == 0) {
                            let dulieu = data.data.rows;
                            let ldvs = [];
                            for (let i = 0; i < dulieu.length; i++) {
                                let obj = {
                                    name: dulieu[i].tenQuanHuyen +
                                        ' - [' + dulieu[i].maQuanHuyen + ']',
                                    value: dulieu[i].maQuanHuyen
                                }
                                ldvs.push(obj);
                            }

                            ldvs.sort((a, b) => (a.name > b.name) ? 1 : -1)
                            this.list_don_vi_huyen = ldvs;
                        } else {
                            this.list_don_vi_huyen = [];
                        }
                    },
                );
            },
            getQuanHuyenAdd() {
                let params = {
                    start: 0,
                    limit: 999,
                    maTinhThanh: this.dataAddOrUpdate.maSoAdd
                };
                rest_api.get(
                    "/internal-api/dmQuanHuyen/filter",
                    params,
                    data => {
                        if (data.data.statusResponse == 0) {
                            let dulieu = data.data.rows;
                            let ldvs = [];
                            for (let i = 0; i < dulieu.length; i++) {
                                let obj = {
                                    name: dulieu[i].tenQuanHuyen +
                                        ' - [' + dulieu[i].maQuanHuyen + ']',
                                    value: dulieu[i].maQuanHuyen
                                }
                                ldvs.push(obj);
                            }

                            ldvs.sort((a, b) => (a.name > b.name) ? 1 : -1)
                            this.list_don_vi_huyen_add = ldvs;
                        } else {
                            this.list_don_vi_huyen_add = [];
                        }
                    },
                );
            },
            onCreatedData() {
                this.$alertify.success('Thêm tổ thôn thành công.');
                this.TruocKhiTim();
            },
            showImport() {
                this.show_import = true;
            },
            thayDoiTrangThai(e, stt) {
                this.type = 2;
                this.dataAddOrUpdate.maSoAdd = e.maTinhthanh;
                this.dataAddOrUpdate.maQuanHuyenAdd = e.maQuanHuyen;
                this.dataAddOrUpdate.maPhuongXaAdd = e.maPhuongXa;
                this.dataAddOrUpdate.maToThonAdd = e.maToThon;
                this.dataAddOrUpdate.tenToThonAdd = e.tenToThon;
                if (stt == 1) {
                    this.trangThaiUpdate = 0;
                    this.typeUpdate = 3
                } else {
                    this.trangThaiUpdate = 1;
                    this.typeUpdate = 4
                }
                this.themQuanHuyen();
            },
            chinhSuaPhuongXa(e) {
                this.typeUpdate = 2
                this.type = 2;
                this.trangThaiUpdate = e.trangThai;
                this.dataAddOrUpdate.maSoAdd = e.maTinhthanh;
                this.dataAddOrUpdate.maQuanHuyenAdd = e.maQuanHuyen;
                this.dataAddOrUpdate.maPhuongXaAdd = e.maPhuongXa;
                this.dataAddOrUpdate.maToThonAdd = e.maToThon;
                this.dataAddOrUpdate.tenToThonAdd = e.tenToThon;
                if (this.thongtin.role == 1) {
                    this.getQuanHuyenAdd();
                }
                this.getPhuongXaAdd()
                this.show_add_or_update = true;
            },
            xoaPhuongXa(e) {
                let ma = e.maToThon;
                let url = "/internal-api/dmToThon/delete?ma=" + ma
                let params = {};
                this.$confirm('Xác nhận xóa tổ thôn?', 'Xóa tổ thôn', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass: 'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.fullScreenLoading = true;
                        rest_api.delete(url, params, (response) => {
                            this.fullScreenLoading = false;
                            console.log(response);
                            if (response.data.statusResponse == 0) {
                                this.thongBao("success", response.data.message)
                                this.getData();
                            } else {
                                this.thongBao("error", response.data.message)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            showThemMoi() {
                this.typeUpdate = 1,
                    this.type = 1;
                this.show_add_or_update = true;
            },
            themQuanHuyen() {
                console.log('Action');
                // typeUpdate 1: thêm mới, 2: sửa, 3:khóa, 4:mở khóa
                let msg = '';
                if (this.typeUpdate == 1) {
                    msg = 'Xác nhận thêm mới tổ thôn?'
                }
                if (this.typeUpdate == 2) {
                    msg = 'Xác nhận chỉnh sửa tổ thôn?'
                }
                if (this.typeUpdate == 3) {
                    msg = 'Xác nhận khóa tổ thôn?'
                }
                if (this.typeUpdate == 4) {
                    msg = 'Xác nhận mở khóa tổ thôn?'
                }
                if (this.typeUpdate == 1 || this.typeUpdate == 2) {
                    const params = {
                        maToThon: this.dataAddOrUpdate.maToThonAdd,
                        tenToThon: this.dataAddOrUpdate.tenToThonAdd,
                        maPhuongXa: this.dataAddOrUpdate.maPhuongXaAdd,
                    };
                    let url = "";
                    if (this.type == 1) {
                        url = "/internal-api/dmToThon/create"
                        let loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post(url, params, (response) => {
                            loading.close();
                            if (response.data.code == 200) {
                                this.thongBao('success', response.data.message);
                                this.show_add_or_update = false;
                                this.TruocKhiTim();
                            } else {
                                this.thongBao('error', response.data.message);
                                return;
                            }
                        });
                    } else {
                        url = "/internal-api/dmToThon/update";
                        params.trangThai = this.trangThaiUpdate;
                        this.fullScreenLoading = true;
                        rest_api.put(url, params, (response) => {
                            this.fullScreenLoading = false;
                            if (response.data.code == 200) {
                                this.thongBao('success', response.data.message);
                                this.show_add_or_update = false;
                                this.TruocKhiTim();
                            } else {
                                this.thongBao('error', response.data.message);
                                return;
                            }
                        });
                    }
                } else {

                    this.$confirm(msg, 'Cập nhật trạng thái', {
                            confirmButtonText: this.typeUpdate == 3 ? 'Khóa' : 'Mở khóa',
                            cancelButtonText: 'Hủy',
                            closeOnClickModal: false,
                        })
                        .then(_ => {
                            const params = {
                                maToThon: this.dataAddOrUpdate.maToThonAdd,
                                tenToThon: this.dataAddOrUpdate.tenToThonAdd,
                                maPhuongXa: this.dataAddOrUpdate.maPhuongXaAdd,
                            };
                            let url = "";
                            if (this.type == 1) {
                                url = "/internal-api/dmToThon/create"
                                let loading = this.$loading({
                                    lock: true,
                                    text: 'Loading',
                                    spinner: 'el-icon-loading',
                                    background: 'rgba(0, 0, 0, 0.7)'
                                });
                                rest_api.post(url, params, (response) => {
                                    loading.close();
                                    if (response.data.code == 200) {
                                        this.thongBao('success', response.data.message);
                                        this.show_add_or_update = false;
                                        this.TruocKhiTim();
                                    } else {
                                        this.$alertify.error(response.data.message);
                                        return;
                                    }
                                });
                            } else {
                                url = "/internal-api/dmToThon/update";
                                params.trangThai = this.trangThaiUpdate;
                                this.fullScreenLoading = true;
                                rest_api.put(url, params, (response) => {
                                    this.fullScreenLoading = false;
                                    if (response.data.code == 200) {
                                        this.thongBao('success', response.data.message);
                                        this.show_add_or_update = false;
                                        this.TruocKhiTim();
                                    } else {
                                        this.$alertify.error(response.data.message);
                                        return;
                                    }
                                });
                            }
                        })
                        .catch(_ => {});
                }
            },
            getTime(date) {
                return timeutils.convertTime(new Date(date));
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            TruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
            getData() {
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "trangthai": this.trangThai,
                    "ma": this.maToThon,
                    "ten": this.tenToThon,
                    "maTinhThanh": this.maSo,
                    "maPhuongXa": this.maPhuongXa,
                    "maQuanHuyen": this.maQuanHuyen,
                };
                this.fullScreenLoading = true;
                rest_api.get("/internal-api/dmToThon/filter", params, (data) => {
                    this.fullScreenLoading = false;
                    if (data.data.statusResponse == 0) {
                        this.total_rows = data.data.total;
                        if (this.total_rows) {
                            // this.thongBao('success',"Lấy dữ liệu thành công");
                        } else {
                            // this.thongBao('error',"Không tìm thấy bản ghi nào");
                        }
                        this.list_data = data.data.rows;
                    } else {
                        this.$alertify.error(data.data.message);
                    }
                });
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 100,
                };
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    if (data.data.statusResponse == 0) {
                        let dulieu = data.data.rows;
                        let ldvs = [];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].tenTinhThanh +
                                    ' - [' + dulieu[i].maTinhThanh + ']',
                                value: dulieu[i].maTinhThanh
                            }
                            ldvs.push(obj);
                        }

                        ldvs.sort((a, b) => (a.name > b.name) ? 1 : -1)
                        this.list_don_vi_so = ldvs;
                    } else {
                        this.list_don_vi_so = [];
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">

</style>

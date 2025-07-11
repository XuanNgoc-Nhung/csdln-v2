<template>
    <div>
        <Breadcrumb :menu="'Kết chuyển dữ liệu'" :desc="'Mật khẩu kết chuyển lên Bộ'"/>
        <div class="card-bieu-do">

            <el-form ref="ruleForm">
                <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :sm="16" :lg="8">
                        <label for="">Đơn vị quản lý</label>
                        <eselect style="width:100%" @change="chonDonVi" no-match-text="Không tìm thấy bản ghi nào"
                                 no-data-text="danh sách lựa chọn trống" collapse-tags v-model="maDonVi"
                                 :placeholder="'Chọn'" filterable :data="danh_sach_don_vi"
                                 :fields="['tenDonVi','maDonVi']"/>
                    </el-col>
                    <el-col :sm="8" :lg="8">
                        <label for="">Cấp học</label>
                        <eselect style="width:100%" @change="chonDonVi" no-match-text="Không tìm thấy bản ghi nào"
                                 no-data-text="danh sách lựa chọn trống" collapse-tags v-model="maCapHoc"
                                 :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc_full"
                                 :fields="['name','id']"/>
                    </el-col>
                    <el-col :sm="16" :lg="8">
                        <label for="">Trường học</label>
                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                 no-data-text="danh sách lựa chọn trống" collapse-tags v-model="maTruongHoc"
                                 :placeholder="'Chọn'" filterable :data="danh_sach_truong_hoc"
                                 :fields="['name','value']"/>
                    </el-col>
                    <el-col :span="24" class="text-center">
                        <label style="color:transparent" for="">Năm học</label>
                        <el-button class="bt-chinh" plain size="mini" v-on:click.prevent="checkTruocKhiTim()" type="success">Tìm
                            kiếm
                        </el-button>
                    </el-col>

                </el-row>
            </el-form>
        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <!-- <el-col :span="12" class="">
                    <label  class="table-name">Danh sách mật khẩu kết chuyển lên Bộ</label>
                </el-col>
                <el-col :span="12">
                    <div class="text-right">
                        <el-tooltip placement="top">
                            <div slot="content">Thêm mới mật khẩu kết chuyển</div>
                            <el-button class="bt-chinh" plain type="primary" @click.prevent="themMoiMatKhauKetChuyen"
                                       size="mini">
                                Thêm mới
                            </el-button>
                        </el-tooltip>
                        <el-tooltip placement="top">
                            <div slot="content">Import mật khẩu kết chuyển theo biểu mẫu</div>
                            <el-button class="bt-phu" plain @click.prevent="showImport" type="primary" size="mini">
                                Nhập theo biểu mẫu
                            </el-button>
                        </el-tooltip>
                    </div>
                </el-col> -->
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <label class="table-name">Danh sách mật khẩu kết chuyển lên Bộ</label>
                        <div class="text-right">
                            <el-tooltip placement="top">
                                <div slot="content">Thêm mới mật khẩu kết chuyển</div>
                                <el-button class="bt-chinh" plain type="primary" @click.prevent="themMoiMatKhauKetChuyen"
                                           size="mini">
                                    Thêm mới
                                </el-button>
                            </el-tooltip>
                            <el-tooltip placement="top">
                                <div slot="content">Import mật khẩu kết chuyển theo biểu mẫu</div>
                                <el-button class="bt-phu" plain @click.prevent="showImport" type="primary" size="mini">
                                    Nhập theo biểu mẫu
                                </el-button>
                            </el-tooltip>
                        </div>
                    </div>
                </el-col>
                <el-col :span="24">
                    <el-table
                            :data="danh_sach_mat_khau_ket_chuyen"
                            border
                            stripe
                            max-height="600"
                            empty-text="Không có bản ghi nào"
                    >
                        <!-- STT -->
                        <el-table-column
                                label="STT"
                                align="center"
                                fixed="left"
                                :width="columnWidths.stt"
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
                                :width="columnWidths.thaoTac"
                        >
                            <template #default="{ row }">
                                <el-tooltip content="Chỉnh sửa" placement="right">
                                    <i @click="showUpdate(row)" class="el-icon-edit"></i>
                                </el-tooltip>
                            </template>
                        </el-table-column>

                        <!-- Tên đăng nhập -->
                        <el-table-column
                                label="Tên đăng nhập"
                                fixed="left"
                                :width="150"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenDangNhap }}</p>
                            </template>
                        </el-table-column>

                        <!-- Mã Trường -->
                        <el-table-column
                                label="Mã Trường"
                                align="center"
                                :min-width="columnWidths.maTruong"
                        >
                            <template #default="{ row }">
                                <p>{{ row.maTruong }}</p>
                            </template>
                        </el-table-column>

                        <!-- Tên Trường -->
                        <el-table-column
                                label="Tên Trường"
                                :min-width="columnWidths.tenTruong"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenTruong }}</p>
                            </template>
                        </el-table-column>

                        <!-- Tỉnh thành -->
                        <el-table-column
                                label="Tỉnh thành"
                                :min-width="columnWidths.tenTinhThanh"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenTinhThanh }}</p>
                            </template>
                        </el-table-column>

                        <!-- Đơn vị quản lý -->
                        <el-table-column
                                label="Đơn vị quản lý"
                                :min-width="columnWidths.tenDonVi"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenDonvi }}</p>
                            </template>
                        </el-table-column>

                        <!-- Cấp học -->
                        <el-table-column
                                label="Cấp học"
                                :min-width="columnWidths.capHoc"
                        >
                            <template #default="{ row }">
                                <p>{{ getCapHoc(row.capHoc) }}</p>
                            </template>
                        </el-table-column>
                    </el-table>

<!--                    <div class="table-responsive">-->
<!--                        <table class="table table-striped table-bordered table-hover">-->
<!--                            <thead>-->
<!--                            <tr style="background:#e4ebf5">-->
<!--                                <th class="text-center  fixed-column fixed-col1">-->
<!--                                    <p>STT</p>-->
<!--                                </th>-->
<!--                                <th class="text-center  fixed-column fixed-col2">-->
<!--                                    <p>Thao tác </p>-->
<!--                                </th>-->
<!--                                <th>-->
<!--                                    <p>Tên đăng nhập</p>-->
<!--                                </th>-->
<!--                                <th class="text-center">-->
<!--                                    <p>Mã Trường</p>-->
<!--                                </th>-->
<!--                                <th>-->
<!--                                    <p>Tên Trường</p>-->
<!--                                </th>-->
<!--                                <th>-->
<!--                                    <p>Tỉnh thành</p>-->
<!--                                </th>-->
<!--                                <th>-->
<!--                                    <p>Đơn vị quản lý</p>-->
<!--                                </th>-->
<!--                                <th>-->
<!--                                    <p>Cấp học</p>-->
<!--                                </th>-->
<!--                            </tr>-->
<!--                            </thead>-->
<!--                            <tbody v-if="danh_sach_mat_khau_ket_chuyen.length===0">-->
<!--                            <tr>-->
<!--                                <td class="text-center" colspan="23">-->
<!--                                    <p>Không có bản ghi nào</p>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                            </tbody>-->
<!--                            <tbody v-else>-->
<!--                            <tr v-for="(tg,index) in danh_sach_mat_khau_ket_chuyen">-->
<!--                                <td class="text-center fixed-column fixed-col1">-->
<!--                                    <p>{{ (currentPage - 1) * limit + index + 1 }}</p>-->
<!--                                </td>-->
<!--                                <td class="text-center fixed-column fixed-col2">-->
<!--                                    &lt;!&ndash; <a title="Chỉnh sửa" v-on:click="showUpdate(tg)">-->
<!--                                        <i class="far fa-edit"></i>-->
<!--                                    </a> &ndash;&gt;-->

<!--                                    <el-tooltip content="Chỉnh sửa" placement="right">-->
<!--                                        <i @click="showUpdate(tg)" class="el-icon-edit"></i>-->
<!--                                    </el-tooltip>-->
<!--                                </td>-->
<!--                                <td>-->
<!--                                    <p>{{ tg.tenDangNhap }}</p>-->
<!--                                </td>-->
<!--                                <td class="text-center">-->
<!--                                    <p>{{ tg.maTruong }}</p>-->
<!--                                </td>-->
<!--                                <td>-->
<!--                                    <p>{{ tg.tenTruong }}</p>-->
<!--                                </td>-->
<!--                                <td>-->
<!--                                    <p>{{ tg.tenTinhThanh }}</p>-->
<!--                                </td>-->
<!--                                <td>-->
<!--                                    <p>{{ tg.tenDonvi }}</p>-->
<!--                                </td>-->
<!--                                <td>-->
<!--                                    <p>{{ getCapHoc(tg.capHoc) }}</p>-->
<!--                                </td>-->
<!--                            </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
                </el-col>
                <el-col :span="24">
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                    </Page>
                </el-col>
            </el-row>
        </div>
        <div class="row" v-if="false">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row group-button-table">
                            <div class="col-sm-12 text-right">
                                <el-tooltip placement="top">
                                    <div slot="content">Thêm mới mật khẩu kết chuyển</div>
                                    <el-button class="bt-chinh" plain type="primary" @click.prevent="themMoiMatKhauKetChuyen"
                                               size="mini">
                                        Thêm mới
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip placement="top">
                                    <div slot="content">Import mật khẩu kết chuyển theo biểu mẫu</div>
                                    <el-button class="bt-phu" plain @click.prevent="showImport" type="primary" size="mini">
                                        Nhập theo biểu mẫu
                                    </el-button>
                                </el-tooltip>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr style="background:#e4ebf5">
                                            <th class="text-center  fixed-column fixed-col1">
                                                <p>STT</p>
                                            </th>
                                            <th class="text-center  fixed-column fixed-col2">
                                                <p>Thao tác </p>
                                            </th>
                                            <th>
                                                <p>Tên đăng nhập</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Mã Trường</p>
                                            </th>
                                            <th>
                                                <p>Tên Trường</p>
                                            </th>
                                            <th>
                                                <p>Tỉnh thành</p>
                                            </th>
                                            <th>
                                                <p>Đơn vị quản lý</p>
                                            </th>
                                            <th>
                                                <p>Cấp học</p>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="danh_sach_mat_khau_ket_chuyen.length===0">
                                        <tr>
                                            <td class="text-center" colspan="23">
                                                <p>Không có bản ghi nào</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(tg,index) in danh_sach_mat_khau_ket_chuyen">
                                            <td class="text-center fixed-column fixed-col1">
                                                <p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                            </td>
                                            <td class="text-center fixed-column fixed-col2">
                                                <!-- <a title="Chỉnh sửa" v-on:click="showUpdate(tg)">
                                                    <i class="far fa-edit"></i>
                                                </a> -->

                                                <el-tooltip content="Chỉnh sửa" placement="right">
                                                    <i @click="showUpdate(tg)" class="el-icon-edit"></i>
                                                </el-tooltip>
                                            </td>
                                            <td>
                                                <p>{{ tg.tenDangNhap }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{ tg.maTruong }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tg.tenTruong }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tg.tenTinhThanh }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tg.tenDonvi }}</p>
                                            </td>
                                            <td>
                                                <p>{{ getCapHoc(tg.capHoc) }}</p>
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
        <div>

            <el-dialog title="Thêm tài khoản kết chuyển lên Bộ" :visible.sync="modal_them_moi" width="1000px"
                       :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
                <div>
                    <el-form :model='dataAddOrUpdate' :rules="rules" ref="ruleForm">
                        <el-row :gutter="24">
                            <el-col :sm="24" :md="16" :lg="12">
                                <label>Đơn vị quản lý</label>
                                <el-form-item>
                                    <eselect style="width:100%" @change="chonDonViThemMatKhau"
                                             no-match-text="Không tìm thấy bản ghi nào"
                                             no-data-text="danh sách lựa chọn trống" collapse-tags
                                             v-model="maDonViThemMatKhau" :placeholder="'Chọn'" filterable
                                             :data="danh_sach_don_vi" :fields="['tenDonVi','maDonVi']"/>
                                </el-form-item>
                            </el-col>
                            <el-col :sm="24" :md="8" :lg="12">
                                <label>Cấp học</label>
                                <el-form-item>
                                    <eselect style="width:100%" @change="chonDonViThemMatKhau"
                                             no-match-text="Không tìm thấy bản ghi nào"
                                             no-data-text="danh sách lựa chọn trống" collapse-tags
                                             v-model="maCapHocThemMatKhau" :placeholder="'Chọn'" filterable
                                             :data="danh_sach_cap_hoc_full" :fields="['name','id']"/>
                                </el-form-item>
                            </el-col>
                            <el-col :sm="24" md="24" :lg="24">
                                <label>Trường học <span style="color:#DC0101">*</span></label>
                                <el-form-item prop="maTruongHocThemMatKhau">
                                    <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                             no-data-text="danh sách lựa chọn trống" collapse-tags
                                             @change="check_confirm_come_back = true"
                                             v-model="dataAddOrUpdate.maTruongHocThemMatKhau"
                                             ref="maTruongHocThemMatKhau"
                                             :placeholder="'Chọn'" filterable
                                             :data="danh_sach_truong_hoc_them_mat_khau" :fields="['name','value']"/>
                                </el-form-item>
                            </el-col>
                            <el-col :sm="24" :lg="12">
                                <label>Tên đăng nhập <span style="color:#DC0101">*</span></label>
                                <el-form-item prop="tenDangNhapThemMatKhau">
                                    <el-input clearable placeholder="Nhập" ref="tenDangNhapThemMatKhau"
                                              @input="check_confirm_come_back = true;dataAddOrUpdate.tenDangNhapThemMatKhau=dataAddOrUpdate.tenDangNhapThemMatKhau.trim()"
                                              v-model.trim="dataAddOrUpdate.tenDangNhapThemMatKhau">
                                    </el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :sm="24" :lg="12">
                                <label>Mật khẩu <span style="color:#DC0101">*</span></label>
                                <el-form-item prop="matKhauThemMatKhau">
<!--                                    <el-input clearable v-model.trim="dataAddOrUpdate.matKhauThemMatKhau"-->
<!--                                              @input="check_confirm_come_back = true;dataAddOrUpdate.matKhauThemMatKhau=dataAddOrUpdate.matKhauThemMatKhau.trim()"-->
<!--                                              ref="matKhauThemMatKhau"-->
<!--                                              placeholder="Nhập" show-password>-->
<!--                                    </el-input>-->
                                    <InputPassword
                                            ref="matKhauThemMatKhau"
                                            @input="check_confirm_come_back = true;dataAddOrUpdate.matKhauThemMatKhau=dataAddOrUpdate.matKhauThemMatKhau.trim()"
                                            v-model.trim="dataAddOrUpdate.matKhauThemMatKhau"></InputPassword>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button class="bt-phu" type="default" @click="handleClose" size="mini">Đóng</el-button>
                    <el-button class="bt-chinh" size="mini" type="primary" @click.prevent="submitForm('ruleForm')">Lưu</el-button>
                </span>
            </el-dialog>
        </div>
        <div>
            <ChinhSua :show="hien_thi_chinh_sua" :item="thongTinChinhSua" @success="onUpdateData($event)"
                      @close="hien_thi_chinh_sua=false"></ChinhSua>

            <Import :show="show_import" @close="show_import=false"></Import>

        </div>
    </div>
</template>
<script>
import VueAlertify from "vue-alertify";
import rest_api from "../../../utils/rest_api";
import Page from "../../ui/PagingCustom";
import ChinhSua from "./chinhSua";
import ThemMoi from "./themMoi";
import Import from "./import";
import constant from "../../../utils/constant";
import dialog from "../../../utils/dialog";
import utils from "../../../utils";
import ESelectVue from '../../ui/ESelect.vue';
import Breadcrumb  from "../../ui/Breadcrumb.vue";
import InputPassword from "./InputPassword";
import {
    Loading
} from 'element-ui';

Vue.use(VueAlertify, {
    notifier: {
        delay: 5,
        position: 'top-right'
    }
});
export default {
    props: ["info"],
    components: {
        'eselect': ESelectVue,
        Page: Page,
        ThemMoi: ThemMoi,
        ChinhSua: ChinhSua,
        Import: Import,
        Breadcrumb,
        InputPassword
    },
    computed: {},
    data() {
        return {
            columnWidths:{
                stt: 50,
                thaoTac: 100,
                tenDangNhap: 150,
                maTruong: 120,
                tenTruong: 200,
                tenTinhThanh: 150,
                tenDonVi: 300,
                capHoc: 150,
            },
            show_msg: false,
            show_import: false,
            limit: 25,
            total_rows: 0,
            start: 0,
            currentPage: 1,
            thongTinChinhSua: {},
            hien_thi_them_moi: false,
            hien_thi_chinh_sua: false,
            trangbatdau: false,
            thongtin: {},
            danh_sach_mat_khau_ket_chuyen: [],
            danh_sach_don_vi: [],
            danh_sach_cap_hoc_full: window.listCapHoc,
            danh_sach_truong_hoc: [],
            maDonVi: "",
            maCapHoc: "",
            maTruongHoc: "",
            danh_sach_don_vi_them_mat_khau: [],
            danh_sach_truong_hoc_them_mat_khau: [],
            maDonViThemMatKhau: "",
            maCapHocThemMatKhau: "",
            maTruongHocThemMatKhau: "",
            tenDangNhapThemMatKhau: "",
            matKhauThemMatKhau: "",
            // Thêm mới
            check_confirm_come_back: false,
            modal_them_moi: false,
            form: {
                name: '',
                region: '',
                date1: '',
                date2: '',
                delivery: false,
                type: [],
                resource: '',
                desc: ''
            },
            dataAddOrUpdate: {
                maTruongHocThemMatKhau: '',
                matKhauThemMatKhau: '',
                tenDangNhapThemMatKhau: '',
            },
            rules: {
                maTruongHocThemMatKhau: [{
                    required: true,
                    message: 'Vui lòng nhập thông tin',
                    trigger: 'change'
                },],
                matKhauThemMatKhau: [{
                    required: true,
                    message: 'Vui lòng nhập thông tin',
                    trigger: 'change'
                },],
                tenDangNhapThemMatKhau: [{
                    required: true,
                    message: 'Vui lòng nhập thông tin',
                    trigger: 'change'
                },],
            }
        };
    },
    mounted() {
        this.thongtin = JSON.parse(this.info);
        this.getDonVi();
        this.getTruongHocThemMatKhau();
        this.getMatKhauKetChuyen();
    },
    watch: {},
    methods: {
        // Cập nhật giá trị min-width cho từng cột
        updateColumnWidths() {
            this.columnWidths = {
                stt: 50,
                thaoTac: 100,
                tenDangNhap: this.calculateWidth('tenDangNhap'),
                maTruong: this.calculateWidth('maTruong'),
                tenTruong: this.calculateWidth('tenTruong'),
                tenTinhThanh: this.calculateWidth('tenTinhThanh'),
                tenDonVi: this.calculateWidth('tenDonvi'),
                capHoc: 150,
            };
        },

        // Hàm tính toán độ rộng cho cột dựa vào dữ liệu
        calculateWidth(columnKey) {
            const maxContentLength = this.danh_sach_mat_khau_ket_chuyen.reduce(
                (max, row) => Math.max(max, (row[columnKey] || '').length),
                0
            );
            console.log(maxContentLength)
            return Math.max(100, maxContentLength * 10) + 20; // Mỗi ký tự chiếm khoảng 10px, tối thiểu là 100px
        },

        submitForm(formName) {
            console.log('submitForm')
            this.$refs[formName].validate((valid) => {
                if (valid) {
                    console.log('Validate success')
                    this.SubmitThemMoi();
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        showImport() {
            this.show_import = true;
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
                        this.modal_them_moi = false;
                    })
                    .catch(_ => {
                    });
            } else {
                this.resetForm('ruleForm')
                this.modal_them_moi = false;
            }
        },
        resetForm(formName) {
            this.maDonViThemMatKhau = '';
            this.maCapHocThemMatKhau = '';
            this.dataAddOrUpdate = {
                maTruongHocThemMatKhau: '',
                matKhauThemMatKhau: '',
                tenDangNhapThemMatKhau: '',
            };
            this.check_confirm_come_back = false;
            this.$refs[formName].resetFields();
        },
        close() {
        },
        reset() {
        },
        onUpdateData() {
            this.hien_thi_chinh_sua = false;
            this.getMatKhauKetChuyen();
        },
        showUpdate(e) {
            console.log("thay chỉnh sửa mật khẩu kết chuyển");
            this.thongTinChinhSua = e;
            this.hien_thi_chinh_sua = true;
        },
        SubmitThemMoi() {

            let params = {
                maTruong: this.dataAddOrUpdate.maTruongHocThemMatKhau,
                matKhau: this.dataAddOrUpdate.matKhauThemMatKhau,
                tenDangNhap: this.dataAddOrUpdate.tenDangNhapThemMatKhau
            };
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.post("/csdlgd-push/KetChuyenDL/createMKKC", params, data => {
                loading.close();
                if (data.data.code === 200) {
                    console.log("Thành công");
                    this.reset();
                    this.modal_them_moi = false;
                    this.thongBao('success', data.data.message)
                    this.trangbatdau = !this.trangbatdau;
                } else {
                    this.thongBao('error', data.data.message);
                    return;
                }
            });
            // this.$confirm('Xác nhận thêm thông tin?', 'Thông báo', {
            //         confirmButtonText: 'Thêm',
            //         cancelButtonText: 'Hủy',
            //     })
            //     .then(_ => {
            //     })
            //     .catch(_ => {});
        },
        chonDonViThemMatKhau() {
            this.check_confirm_come_back = true;
            this.danh_sach_truong_hoc_them_mat_khau = [];
            this.dataAddOrUpdate.maTruongHocThemMatKhau = "";
            this.getTruongHocThemMatKhau();
        },
        themMoiMatKhauKetChuyen() {
            this.modal_them_moi = true;
        },
        getCapHoc(loai) {
            var res = parseInt(loai);
            switch (res) {
                case 1:
                    res = 'Tiểu học';
                    break;
                case 2:
                    res = 'THCS';
                    break;
                case 3:
                    res = 'THPT';
                    break;
                case 4:
                    res = 'Nhà trẻ';
                    break;
                case 5:
                    res = 'Mẫu giáo';
                    break;
                case 12:
                    res = 'PTCS';
                    break;
                case 1245:
                    res = 'MN-PTCS';
                    break;
                case 145:
                    res = 'MN-TH';
                    break;
                case 23:
                    res = 'Trung học';
                    break;
                case 123:
                    res = 'Phổ thông';
                    break;
                case 12345:
                    res = 'MN-PT';
                    break;
                case 45:
                    res = 'Mầm non';
                    break;
                case 6:
                    res = 'GDTX';
                    break;
                default:
                    res = loai;
            }
            return res;
        },
        getMatKhauKetChuyen() {
            this.danh_sach_mat_khau_ket_chuyen = [];
            this.total_rows = 0;
            const params = {
                start: this.start,
                limit: this.limit,
                maTinhThanh: this.thongtin.province,
                maDonVi: this.maDonVi,
                capHoc: this.maCapHoc,
                maTruongHoc: this.maTruongHoc,
            };
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.post("/csdlgd-push/KetChuyenDL/filterMatKhauKc", params, response => {
                loading.close();
                if (response.data.code === 200) {
                    this.danh_sach_mat_khau_ket_chuyen = response.data.rows;
                    console.log('danh_sach_mat_khau_ket_chuyen');
                    console.log(this.danh_sach_mat_khau_ket_chuyen);
                    if (this.danh_sach_mat_khau_ket_chuyen == null) {
                        this.danh_sach_mat_khau_ket_chuyen = [];
                    }
                    this.total_rows = response.data.total;
                    if (this.total_rows == 0) {
                        // this
                        //     .$alertify
                        //     .error("Không có bản ghi nào được tìm thấy");
                    }
                    this.total_rows = response.data.total;
                    this.updateColumnWidths();
                } else {
                    if (response.data.total != 0) {
                        this.thongBao('error', response.data.message)
                    }
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
        layLai(e) {
            console.log("lấy lại danh sách:" + JSON.stringify(e));
            this.start = e.start;
            this.limit = e.limit;
            this.currentPage = e.currentPage;
            this.getMatKhauKetChuyen();
        },
        checkTruocKhiTim() {
            this.trangbatdau = !this.trangbatdau;
        },
        chonDonVi() {
            console.log("Chọn đơn vị/cấp học");
            this.danh_sach_truong_hoc = [];
            this.maTruongHoc = "";
            this.getTruongHoc();
        },
        getTruongHoc() {
            // const loading = this.$loading({
            //     lock: true,
            //     text: 'Loading',
            //     spinner: 'el-icon-loading',
            //     background: 'rgba(0, 0, 0, 0.7)'
            // });
            let params = {
                maDonVi: [],
                capHoc: [],
            };
            if (this.maDonVi) {
                params.maDonVi = [this.maDonVi]
            }
            ;
            if (this.maCapHoc) {
                params.capHoc = [this.maCapHoc]
            }
            ;
            rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
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
                    this.danh_sach_truong_hoc = data_demo;
                    // loading.close();
                } else {
                    this.danh_sach_truong_hoc = [];
                    // loading.close();
                }
            });
        },
        getTruongHocThemMatKhau() {
            // const loading = this.$loading({
            //     lock: true,
            //     text: 'Loading',
            //     spinner: 'el-icon-loading',
            //     background: 'rgba(0, 0, 0, 0.7)'
            // });
            let params = {
                maDonVi: [],
                capHoc: [],
            };
            if (this.maDonViThemMatKhau) {
                params.maDonVi = [this.maDonViThemMatKhau]
            }
            ;
            if (this.maCapHocThemMatKhau) {
                params.capHoc = [this.maCapHocThemMatKhau]
            }
            ;
            rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
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
                    this.danh_sach_truong_hoc_them_mat_khau = data_demo;
                    // loading.close();
                } else {
                    this.danh_sach_truong_hoc_them_mat_khau = [];
                    // loading.close();
                }
            });
        },
        getDonVi() {
            let params = {
                "start": 0,
                "limit": 9999,
                "maTinhThanh": this.thongtin.ma_so
            };
            const loadingDv = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                loadingDv.close();
                if (data.data.statusResponse == 0) {
                    let data_demo = data.data.rows;
                    for (let i = 0; i < data_demo.length; i++) {
                        let obj = {
                            tenDonVi: data_demo[i].tenDonVi + ' - [' + data_demo[i].maDonVi + ']',
                            maDonVi: data_demo[i].maDonVi,
                        }
                        this.danh_sach_don_vi.push(obj);
                    }
                    this.getTruongHoc();
                }
            });
        }
    }
};

</script>
<style scoped="scoped">
</style>

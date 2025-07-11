<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
       
        <Breadcrumb :menu="'Hệ thống'" :desc="'Quản lý người dùng'"/>
        <el-row :span="20" class="card-bieu-do">
            <el-form ref="ruleForm">

                <el-col :span="24">
                    <div class="table-name">Thông tin tìm kiếm</div>
                </el-col>
                <el-col :xs="24" :sm="12" :md="6">
                    <label>Sở giáo dục</label>
                    <eselect :disabled="thongtin.role==2" collapseTags v-model="dataSearch.maDonVi"
                             @change="chonDonViSo"
                             :placeholder="'Chọn'" filterable :data="list_don_vi_so" :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="6">
                    <label>Phòng giáo dục</label>
                    <eselect collapseTags v-model="dataSearch.maPhong" :placeholder="'Chọn'" filterable
                             :data="list_don_vi_phong" :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="6">
                    <label>Vai trò</label>
                    <eselect collapseTags v-model="dataSearch.role" :placeholder="'Chọn'" filterable
                             :data="list_vai_tro"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="6">
                    <label>Trạng thái</label>
                    <eselect collapseTags v-model="dataSearch.trangThai" :placeholder="'Chọn'" filterable
                             :data="list_trang_thai" :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="6">
                    <label>Tên tài khoản</label>
                    <el-input clearable placeholder="Nhập..." @change="dataSearch.hoTen = dataSearch.hoTen.trim()"
                              v-model="dataSearch.hoTen"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="6">
                    <label>Email</label>
                    <el-input clearable placeholder="Nhập..." @change="dataSearch.email = dataSearch.email.trim()"
                              v-model="dataSearch.email"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="6">
                    <label>Tên đăng nhập</label>
                    <el-input clearable placeholder="Nhập..." @change="dataSearch.username = dataSearch.username.trim()"
                              v-model="dataSearch.username"></el-input>
                </el-col>
                <el-col :span="24" class="text-center">
                    <el-button class="bt-chinh" size="mini" type="success" @click.prevent="getDataPageOne">Tìm kiếm</el-button>
                </el-col>
            </el-form>
        </el-row>
        <el-row :span="20" class="card-bieu-do">
            <!-- <el-col :span="12">
                <label  class="table-name">Danh sách người dùng</label>
            </el-col>
            <el-col :span="12" class="text-right">
                <el-tooltip effect="dark" content="Thêm mới người dùng" placement="top">
                    <el-button class="bt-chinh" size="mini" @click.prevent="showAdd" type="primary">Thêm mới</el-button>
                </el-tooltip>
            </el-col> -->

            <el-col :span="24">
                <div class="centerBetweenFlex">
                    <label  class="table-name">Danh sách người dùng</label>
                    <div class="text-right">
                        <el-tooltip effect="dark" content="Thêm mới người dùng" placement="top">
                            <el-button class="bt-chinh" size="mini" @click.prevent="showAdd" type="primary">Thêm mới</el-button>
                        </el-tooltip>
                    </div>
                </div>
            </el-col>

            <el-col :span="24" class="pd-t-0">
                <el-table
                        :data="list_user"
                        max-height="600"
                        border
                        fit
                        stripe
                        empty-text="Không có dữ liệu"
                >
                    <!-- STT Column -->
                    <el-table-column
                            label="STT"
                            :width="((paginate.curentPage - 1) * paginate.limit + 1) > 9999 ? 70 : 60"
                            align="center"
                            fixed="left"
                    >
                        <template #default="{ $index }">
                            <p>{{ (paginate.curentPage - 1) * paginate.limit + $index + 1 }}</p>
                        </template>
                    </el-table-column>

                    <!-- Thao tác Column -->
                    <el-table-column
                            label="Thao tác"
                            width="150"
                            align="center"
                            fixed="right"
                    >
                        <template #default="{ row }">
                            <template v-if="!row.isSso || row.isSso === false">
                                <el-tooltip v-if="row.role != thongtin.role" content="Chỉnh sửa" placement="left">
                                    <i @click.prevent="showUpdate(row)" class="el-icon-edit"></i>
                                </el-tooltip>
                                <el-tooltip v-else content="Không thể thực hiện do không đủ quyền. Vui lòng liên hệ quản trị viên." placement="left">
                                    <i class="el-icon-edit disabled"></i>
                                </el-tooltip>
                                <el-tooltip v-if="row.trangThai === 1 && row.role != thongtin.role" content="Khoá" placement="left">
                                    <i @click.prevent="thayDoiTrangThai(row, 0)" class="el-icon-lock"></i>
                                </el-tooltip>
                                <el-tooltip v-else-if="row.trangThai === 0 && row.role != thongtin.role" content="Mở khoá" placement="left">
                                    <i @click.prevent="thayDoiTrangThai(row, 1)" class="el-icon-unlock"></i>
                                </el-tooltip>
                                <el-tooltip v-else content="Không thể thực hiện do không đủ quyền. Vui lòng liên hệ quản trị viên." placement="left">
                                    <i v-if="row.trangThai === 1" class="el-icon-lock disabled"></i>
                                    <i v-else class="el-icon-unlock disabled"></i>
                                </el-tooltip>
                                <el-tooltip v-if="row.role != thongtin.role" content="Đổi mật khẩu" placement="right">
                                    <i @click.prevent="showResetPass(row)" class="el-icon-key"></i>
                                </el-tooltip>
                                <el-tooltip v-else content="Không thể thực hiện do không đủ quyền. Vui lòng liên hệ quản trị viên." placement="left">
                                    <i class="el-icon-key disabled"></i>
                                </el-tooltip>
                            </template>
                            <template v-else>
                                <el-tooltip content="Tài khoản sso. Không thể thay đổi." placement="left">
                                    <i class="el-icon-edit disabled"></i>
                                </el-tooltip>
                                <el-tooltip content="Tài khoản sso. Không thể thay đổi." placement="left">
                                    <i class="el-icon-lock disabled"></i>
                                </el-tooltip>
                                <el-tooltip content="Tài khoản sso. Không thể thay đổi." placement="left">
                                    <i class="el-icon-key disabled"></i>
                                </el-tooltip>
                            </template>
                        </template>
                    </el-table-column>
                    <!-- Tên đăng nhập Column -->
                    <el-table-column label="Tên đăng nhập" fixed="left" :min-width="columnWidths['username']">
                        <template #default="{ row }">
                            <p>{{ row.username }}</p>
                        </template>
                    </el-table-column>
                    <!-- Tên tài khoản Column -->
                    <el-table-column label="Tên tài khoản"  :min-width="columnWidths['hoTen']">
                        <template #default="{ row }">
                            <p>{{ row.hoTen }}</p>
                        </template>
                    </el-table-column>



                    <!-- Email Column -->
                    <el-table-column label="Email" min-width="150" :min-width="columnWidths['email']">
                        <template #default="{ row }">
                            <p>{{ row.email }}</p>
                        </template>
                    </el-table-column>

                    <!-- Vai trò Column -->
                    <el-table-column label="Vai trò" min-width="150" :min-width="columnWidths['role']">
                        <template #default="{ row }">
                            <p>{{ getRoleName(row.role) }}</p>
                        </template>
                    </el-table-column>

                    <!-- Loại tài khoản Column -->
                    <el-table-column label="Loại tài khoản" min-width="150">
                        <template #default="{ row }">
                            <p>{{ row.isSso ? 'Tài khoản SSO' : 'Tài khoản thường' }}</p>
                        </template>
                    </el-table-column>

                    <!-- Trạng thái Column -->
                    <el-table-column label="Trạng thái" min-width="150">
                        <template #default="{ row }">
                            <p :class="getClass(row.trangThai)">
                                {{ row.trangThai !== 1 ? 'Ngừng hoạt động' : 'Đang hoạt động' }}
                            </p>
                        </template>
                    </el-table-column>
                </el-table>


<!--                <div class="table-responsive">-->
<!--                    <table class="table table-bordered table-striped table-hover">-->
<!--                        <thead>-->
<!--                        <tr style="background:#e4ebf5">-->
<!--                            <th class="text-center fixed-column fixed-col1">-->
<!--                                <p>STT</p>-->
<!--                            </th>-->
<!--                            <th class="text-center fixed-column fixed-col2">-->
<!--                                <p>Thao tác</p>-->
<!--                            </th>-->
<!--                            &lt;!&ndash;                            <th class="text-center"><p>Đơn vị quản lý</p></th>&ndash;&gt;-->
<!--                            <th>-->
<!--                                <p>Tên tài khoản</p>-->
<!--                            </th> <th>-->
<!--                                <p>Tên đăng nhập</p>-->
<!--                            </th>-->
<!--                            <th>-->
<!--                                <p>Email</p>-->
<!--                            </th>-->
<!--                            &lt;!&ndash;                            <th class="text-center"><p>Số điện thoại</p></th>&ndash;&gt;-->
<!--                            <th>-->
<!--                                <p>Vai trò</p>-->
<!--                            </th>-->
<!--                            <th>-->
<!--                                <p>Loại tài khoản</p>-->
<!--                            </th>-->
<!--                            <th>-->
<!--                                <p>Trạng thái</p>-->
<!--                            </th>-->
<!--                        </tr>-->
<!--                        </thead>-->
<!--                        <tbody v-if="list_user.length==0">-->
<!--                        <tr>-->
<!--                            <td colspan="7">-->
<!--                                <p class="text-center">Không có dữ liệu</p>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        </tbody>-->
<!--                        <tbody v-else>-->
<!--                        <tr v-for="(item,i) in list_user" :key="i">-->
<!--                            <td class="text-center fixed-column fixed-col1">-->
<!--                                <p>{{ (paginate.curentPage - 1) * paginate.limit + i + 1 }}</p>-->
<!--                            </td>-->
<!--                            <td class="text-center fixed-column fixed-col2">-->
<!--                                <template v-if="!item.isSso||item.isSso == false">-->
<!--                                    <el-tooltip v-if="item.role!=thongtin.role" content="Chỉnh sửa"-->
<!--                                                placement="left">-->
<!--                                        &lt;!&ndash; <el-button type="warning" size="mini"> &ndash;&gt;-->
<!--                                        <i @click.prevent="showUpdate(item)" class="el-icon-edit"></i>-->
<!--                                        &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                    </el-tooltip>-->
<!--                                    <el-tooltip v-else-->
<!--                                                content="Không thể thực hiện do không đủ quyền. Vui lòng liên hệ quản trị viên."-->
<!--                                                placement="left">-->
<!--                                        &lt;!&ndash; <el-button size="mini"> &ndash;&gt;-->
<!--                                        <i class="el-icon-edit disabled"></i>-->
<!--                                        &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                    </el-tooltip>-->
<!--                                    <el-tooltip v-if="item.trangThai===1&&item.role!=thongtin.role" content="Khoá"-->
<!--                                                placement="left">-->
<!--                                        &lt;!&ndash; <el-button type="danger" class="lock-btn"-->
<!--                                             size="mini"> &ndash;&gt;-->
<!--                                        <i @click.prevent="thayDoiTrangThai(item,0)" class="el-icon-lock"></i>-->
<!--                                        &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                    </el-tooltip>-->
<!--                                    <el-tooltip v-else-if="item.trangThai===0&&item.role!=thongtin.role"-->
<!--                                                content="Mở khoá" placement="left">-->
<!--                                        &lt;!&ndash; <el-button type="success" size="mini"> &ndash;&gt;-->
<!--                                        <i class="el-icon-unlock" @click.prevent="thayDoiTrangThai(item,1)"></i>-->
<!--                                        &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                    </el-tooltip>-->
<!--                                    <el-tooltip v-else-->
<!--                                                content="Không thể thực hiện do không đủ quyền. Vui lòng liên hệ quản trị viên."-->
<!--                                                placement="left">-->
<!--                                        &lt;!&ndash; <el-button size="mini"> &ndash;&gt;-->
<!--                                        <i v-if="item.trangThai===1" class="el-icon-lock disabled"></i>-->
<!--                                        <i v-else class="el-icon-unlock disabled"></i>-->
<!--                                        &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                    </el-tooltip>-->
<!--                                    <el-tooltip v-if="item.role!=thongtin.role" content="Đổi mật khẩu"-->
<!--                                                placement="right">-->
<!--                                        &lt;!&ndash; <el-button type="info" size="mini"> &ndash;&gt;-->
<!--                                        <i @click.prevent="showResetPass(item)" class="el-icon-key"></i>-->
<!--                                        &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                    </el-tooltip>-->
<!--                                    <el-tooltip v-else-->
<!--                                                content="Không thể thực hiện do không đủ quyền. Vui lòng liên hệ quản trị viên."-->
<!--                                                placement="left">-->
<!--                                        &lt;!&ndash; <el-button type="info" size="mini" @click.prevent="showResetPass(item)"> &ndash;&gt;-->
<!--                                        <i class="el-icon-key disabled"></i>-->
<!--                                        &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                    </el-tooltip>-->
<!--                                </template>-->
<!--                                <template v-else>-->
<!--                                    <el-tooltip-->
<!--                                        content="Tài khoản sso. Không thể thay đổi."-->
<!--                                        placement="left">-->
<!--                                        &lt;!&ndash; <el-button size="mini"> &ndash;&gt;-->
<!--                                        <i class="el-icon-edit disabled" ></i>-->
<!--                                        &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                    </el-tooltip>-->
<!--                                    <el-tooltip-->
<!--                                        content="Tài khoản sso. Không thể thay đổi."-->
<!--                                        placement="left">-->
<!--                                        &lt;!&ndash; <el-button size="mini"> &ndash;&gt;-->
<!--                                        <i class="el-icon-lock disabled"></i>-->
<!--                                        &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                    </el-tooltip>-->
<!--                                    <el-tooltip-->
<!--                                        content="Tài khoản sso. Không thể thay đổi."-->
<!--                                        placement="left">-->
<!--                                        &lt;!&ndash; <el-button type="info" size="mini" @click.prevent="showResetPass(item)"> &ndash;&gt;-->
<!--                                        <i class="el-icon-key disabled"></i>-->
<!--                                        &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                    </el-tooltip>-->
<!--                                    &lt;!&ndash;                                    <el-tooltip content="Tài khoản sso. Không thể thay đổi."&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                                placement="left">&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                        &lt;!&ndash; <el-button type="default" plain size="mini"> &ndash;&gt;&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                        <i class="el-icon-thumb disabled" @click.prevent="callToSso"></i>&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                        &lt;!&ndash; </el-button> &ndash;&gt;&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                    </el-tooltip>&ndash;&gt;-->
<!--                                </template>-->
<!--                            </td>-->
<!--                            &lt;!&ndash;                            <td><p>{{ item.tenDonVi }}</p></td>&ndash;&gt;-->
<!--                            <td>-->
<!--                                <p>{{ item.hoTen }}</p>-->
<!--                            </td>-->
<!--                            <td>-->
<!--                                <p>{{ item.username }}</p>-->
<!--                            </td>-->
<!--                            <td>-->
<!--                                <p>{{ item.email }}</p>-->
<!--                            </td>-->
<!--                            &lt;!&ndash;                            <td><p>{{ item.sdt }}</p></td>&ndash;&gt;-->
<!--                            <td>-->
<!--                                <p>{{ getRoleName(item.role) }}</p>-->
<!--                            </td>-->
<!--                            <td class="text-left">-->
<!--                                <p>-->
<!--                                    &lt;!&ndash;                                    <el-button&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                        :class="{ 'dts-status-primary': item.isSso==true, 'dts-status-info': item.isSso!=true  }"&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                        size="mini">&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                        {{ item.isSso === true ? 'Tài khoản SSO' : 'Tài khoản thường' }}&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                    </el-button>&ndash;&gt;-->

<!--                                    {{ item.isSso ? 'Tài khoản SSO' : 'Tài khoản thường' }}-->
<!--                                    &lt;!&ndash; <el-button v-if="item.isSso" size="mini" class="hoverWarning" type="warning">Tài khoản sso</el-button>-->
<!--                                <el-button v-else size="mini" class="hoverSuccess" type="success">Tài khoản thường</el-button> &ndash;&gt;-->
<!--                                </p>-->
<!--                            </td>-->
<!--                            <td>-->
<!--                                <p v-bind:class="getClass(item.trangThai)">-->
<!--                                    {{ item.trangThai != 1 ? 'Ngừng hoạt động' : 'Đang hoạt động' }}-->
<!--                                    &lt;!&ndash;                                    <el-button&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                        :class="{ 'dts-status-active': item.trangThai==1, 'dts-status-un-active': item.trangThai!=1  }"&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                        size="mini">&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                        {{ item.trangThai === 1 ? 'Đang hoạt động' : 'Ngừng hoạt động' }}&ndash;&gt;-->
<!--                                    &lt;!&ndash;                                    </el-button>&ndash;&gt;-->
<!--                                    &lt;!&ndash; <el-button v-if="item.trangThai!=1" size="mini" class="hoverWarning" type="warning">Ngừng hoạt động</el-button>-->
<!--                                <el-button v-else size="mini" class="hoverSuccess" type="success">Đang hoạt động</el-button> &ndash;&gt;-->
<!--                                </p>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        </tbody>-->
<!--                    </table>-->
<!--                </div>-->
            </el-col>
            <el-col :span="24">
                <Pagination :batdau="paginate.startPage" :total_rows="paginate.total"
                            @pageChange="layLaiDuLieu($event)"></Pagination>
            </el-col>
            <div>
                <themMoi v-if="show_add" :list_vai_tro="list_vai_tro" :list_don_vi_so="list_don_vi_so"
                         @close="show_add = false" @addSuccess="addSuccess"></themMoi>
                <chinhSua v-if="show_update" :item="dataEdit" :list_vai_tro="list_vai_tro"
                          :list_don_vi_so="list_don_vi_so" @close="show_update = false" @updateSuccess="updateSuccess">
                </chinhSua>
                <!--                Đổi mật khẩu-->
                <el-dialog append-to-body :close-on-click-modal="false" :close-on-press-escape="false" width="40%" top="10vh" title="Thay đổi mật khẩu" :visible.sync="show_reset_pass">

                    <el-form ref="doiMatKhau" :rules="rulesDoiMatKhau" :model="dataReSet">
                        <el-row :gutter="20">
                            <el-col :md="12">
                                <label>Mật khẩu mới: <span class="red">*</span></label>
                                <el-form-item prop="pass">
                                    <el-input clearable placeholder="Nhập..." @change="dataReSet.pass = dataReSet.pass.trim()"
                                              v-model="dataReSet.pass" show-password></el-input>
                                </el-form-item>
                            </el-col>
                            <el-col :md="12">
                                <label>Nhập lại mật khẩu mới: <span class="red">*</span></label>
                                <el-form-item prop="rePass">
                                    <el-input clearable placeholder="Nhập..."
                                              @change="dataReSet.rePass = dataReSet.rePass.trim()" v-model="dataReSet.rePass"
                                              show-password>
                                    </el-input>
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                    <span slot="footer" class="dialog-footer">
                        <el-button class="bt-phu" size="mini" @click.prevent="handleClose()">Huỷ</el-button>
                        <el-button class="bt-chinh" size="mini" type="primary" @click.prevent="confirmResetPass">Lưu</el-button>
                    </span>
                </el-dialog>
            </div>
        </el-row>
    </div>
</template>
<script>
import ElementUI from 'element-ui';
import rest_api from "../../../utils/rest_api";
import ESelectVue from '../../ui/ESelect.vue';
import Pagination from '../../ui/PagingCustom';
import themMoi from "./add";
import chinhSua from "./update";
import Breadcrumb from '../../ui/Breadcrumb.vue';

Vue.use(ElementUI);
export default {
    components: {
        'eselect': ESelectVue,
        Pagination,
        themMoi,
        chinhSua,
        Breadcrumb
    },
    watch: {
        list_user: {
            handler(newValue) {
                if (newValue && newValue.length) {
                    this.calculateColumnWidths(); // Tính toán lại độ rộng khi dữ liệu thay đổi
                }
            },
            immediate: true,
        },

    },
    data() {
        return {
            thongtin: {},
            loading: {
                text: 'Loading...',
                status: false,
            },
            paginate: {
                start: 0,
                limit: 25,
                total: 0,
                curentPage: 1,
                startPage: true,
            },
            dataSearch: {
                hoTen: '',
                email: '',
                maPhong: '',
                maDonVi: '',
                role: '',
                trangThai: '',
                username: '',
            },
            list_don_vi_phong: [],
            list_don_vi_so: [],
            list_vai_tro: [],
            list_trang_thai: [{
                name: 'Đang hoạt động',
                value: 1
            },
                {
                    name: 'Ngừng hoạt động',
                    value: 0
                }
            ],
            list_user: [],
            show_add: false,
            show_update: false,
            dataEdit: {},
            show_reset_pass: false,
            dataReSet: {},
            rulesDoiMatKhau: {
                pass: [
                    { required: true, message: 'Vui lòng nhập mật khẩu mới.', trigger: 'blur' },
                    { min: 6, message: 'Mật khẩu phải có ít nhất 6 ký tự.', trigger: 'blur' }
                ],
                rePass: [
                    { required: true, message: 'Vui lòng nhập lại mật khẩu.', trigger: 'blur' },
                    { validator: this.validateRePass, trigger: 'blur' }
                ]
            },
            columnWidths: {},
        }
    },
    mounted() {
        this.thongtin = JSON.parse(window.userInfo);
        console.log('Mount nộp dữ liệu sso');
        console.warn(this.thongtin)
        if (this.thongtin.role > 1) {
            this.dataSearch.maDonVi = this.thongtin.ma_so;
        }
        this.getData();
        this.getVaiTro();
        this.getTinhThanh();
        this.getDonViPhong();
    },
    methods: {
        validateRePass(rule, value, callback) {
            if (value === '') {
                callback(new Error('Vui lòng nhập lại mật khẩu.'));
            } else if (value !== this.dataReSet.pass) {
                callback(new Error('Mật khẩu nhập lại không khớp.'));
            } else {
                callback();
            }
        },
        calculateColumnWidths() {
            // Base widths for padding, borders, etc.
            const baseWidth = 150;

            // Helper function to measure text width
            const measureTextWidth = (text) => {
                const canvas = document.createElement("canvas");
                const context = canvas.getContext("2d");
                context.font = "14px Arial"; // Match the table's font style
                return Math.ceil(context.measureText(text).width);
            };

            // Initialize widths
            const newWidths = {
                hoTen: baseWidth,
                username: baseWidth,
                email: baseWidth,
                role: baseWidth,
            };

            // Iterate through the data to find the max width for each column
            this.list_user.forEach((row) => {
                newWidths.hoTen = Math.max(newWidths.hoTen, measureTextWidth(row.hoTen || ""));
                newWidths.username = Math.max(newWidths.username, measureTextWidth(row.username || ""));
                newWidths.email = Math.max(newWidths.email, measureTextWidth(row.email || ""));
                newWidths.role = Math.max(newWidths.role, measureTextWidth(this.getRoleName(row.role) || ""));
            });

            // Add some padding to each calculated width
            Object.keys(newWidths).forEach((key) => {
                newWidths[key] += 20; // Add padding
            });

            // Update columnWidths
            this.columnWidths = newWidths;
        },

        getClass(stt) {
            return stt == 1 ? 'banGhiDangHoatDong' : stt == 0 ? 'banGhiNgungHoatDong' : 'banGhiDaXoa'
        },
        handleClose() {
            this.$confirm(
                'Các thông tin vừa nhập sẽ bị mất khi đóng trang. Thầy cô có muốn tiếp tục chỉnh sửa, kiểm tra và lưu lại thông tin đã nhập?',
                'Thông báo', {
                    confirmButtonText: 'Rời khỏi trang',
                    cancelButtonText: 'Tiếp tục chỉnh sửa',
                    confirmButtonClass: 'el-button--danger',
                    closeOnClickModal: false,
                })
                .then(_ => {
                    this.$refs.doiMatKhau.resetFields();
                    this.show_reset_pass = false;
                })
                .catch(_ => {
                });
        },
        confirmResetPass() {
            // console.log('confirmResetPass')
            // if (!this.dataReSet || !this.dataReSet.pass || this.dataReSet.pass == '') {
            //     this.thongBao('warning', 'Vui lòng nhập mật khẩu mới.');
            //     return;
            // }
            // if (this.dataReSet.pass != this.dataReSet.rePass) {
            //     this.thongBao('warning', 'Mật khẩu nhập lại không đúng.');
            //     return;
            // }
            this.$refs.doiMatKhau.validate((valid) => {
                if (valid) {
                    this.$confirm('Xác nhận thay đổi mật khẩu của tài khoản?', 'Đổi mật khẩu', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                        .then(_ => {
                            console.log('Đồng ý sửa mk')
                            let params = {
                                username: this.dataReSet.username,
                                password: this.dataReSet.pass
                            }
                            this.loading.text = 'Đang thay đổi...';
                            this.loading.status = true;
                            rest_api.put("/csdlgd-user/adminUser/password", params, (response) => {
                                console.log('Thay đổi trạng thái tài khoản:')
                                console.log(response)
                                if (response.data.rc == 0) {
                                    this.thongBao('success', 'Cập nhật mật khẩu thành công');
                                    this.show_reset_pass = false;
                                    this.dataReSet = {};
                                    this.getData();
                                } else {
                                    this.thongBao('error', response.data.rd)
                                }
                                this.loading.status = false;
                            });
                        })
                        .catch(_ => {
                        });
                } else {
                    // this.thongBao('error', 'Vui lòng kiểm tra lại thông tin.');
                }
            });

        },
        showResetPass(item) {
            console.log('showResetPass');
            this.dataReSet = item;
            this.show_reset_pass = true;
        },
        callToSso() {
            this.thongBao('warning',
                'Để thay đổi thông tin của tài khoản SSO vui lòng liên hệ với admin để được hỗ trợ.')
        },
        thayDoiTrangThai(item, type) {
            let title = (type == 1 ? 'Mở khóa' : 'Khóa') + ' tài khoản'

            let msg = "Xác nhận " + (type == 1 ? 'mở khóa' : 'khóa') + " tài khoản?";
            this.$confirm(msg, 'Thông báo', {
                confirmButtonText: type == 1 ? 'Mở khóa' : 'Khóa',
                cancelButtonText: 'Hủy',
                closeOnClickModal: false,
            })
                .then(_ => {
                    let params = {
                        username: item.username,
                        trangThai: type
                    }
                    this.loading.text = 'Đang thay đổi trạng thái...';
                    this.loading.status = true;
                    rest_api.put("/csdlgd-user/adminUser/trangThai", params, (response) => {
                        console.log('Thay đổi trạng thái tài khoản:')
                        console.log(response)
                        if (response.data.rc == 0) {
                            this.thongBao('success', 'Cập nhật trạng thái thành công');
                            this.getData();
                        } else {
                            this.thongBao('error', response.data.rd)
                        }
                        this.loading.status = false;
                    });
                })
                .catch(_ => {
                });

        },
        getRoleName(role) {
            let result = '';
            for (let i = 0; i < this.list_vai_tro.length; i++) {
                if (this.list_vai_tro[i].value == role) {
                    result = this.list_vai_tro[i].name;
                }
            }
            if (role == 2) {
                return 'Admin sở - [2]'
            }
            return result;
        },
        updateSuccess() {
            console.log('updateSuccess')
            this.show_update = false;
            this.getDataPageOne();
        },
        addSuccess() {

            console.log('addSuccess')
            this.show_add = false;
            this.getDataPageOne();
        },
        showUpdate(e) {
            console.log('showUpdate')
            console.log(e);
            this.dataEdit = e;
            this.show_update = true;
        },
        showAdd() {
            console.log('showAdd')
            this.show_add = true;
        },
        getDataPageOne() {
            this.paginate.startPage = !this.paginate.startPage;
        },
        layLaiDuLieu(e) {
            console.log('layLaiDuLieu');
            this.paginate.start = e.start;
            this.paginate.limit = e.limit;
            this.paginate.curentPage = e.currentPage;
            this.getData()
        },
        chonDonViSo() {
            this.dataSearch.maPhong = '';
            this.list_don_vi_phong = [];
            if (this.dataSearch.maDonVi) {
                this.getDonViPhong();
            }
        },
        getData() {
            console.log('getData');
            this.list_user = [];
            this.paginate.total = 0;
            try {
                let startLimit = {
                    "start": this.paginate.start,
                    "limit": this.paginate.limit,
                };
                let params = {
                    ...startLimit,
                    ...this.dataSearch
                };
                console.log('Thông tin lấy dữ liệu')
                console.log(params)
                this.loading.text = 'Đang lấy dữ liệu...';
                this.loading.status = true;
                rest_api.post("/csdlgd-user/adminUser/search", params, (response) => {
                    console.log('res danh sách cấu hình đối tác trường')
                    console.log(response)
                    this.loading.status = false;
                    if (response.data.rc == 0) {
                        if (response.data.tableData && response.data.tableData.length > 0) {
                            this.list_user = response.data.tableData;
                            this.paginate.total = response.data.totalRows;
                            // this.thongBao('success', 'Lấy dữ liệu thành công')
                        } else {
                            // this.thongBao('warning', 'Không tìm thấy dữ liệu');
                            this.list_user = [];
                        }
                    } else {
                        this.thongBao('error', response.data.rd)
                    }
                });
            } catch (e) {

            }
        },
        getDonViPhong() {
            console.log('getDonVi');
            this.list_don_vi_phong = [];
            try {
                console.log("Lấy danh sách đơn vị:")
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.dataSearch.maDonVi,
                    "loaiDonVi": 2
                };
                this.loading.status = true;
                this.loading.text = 'Lấy danh sách đơn vị';
                rest_api.get("/internal-api/dmDonVi/filter", params, (response) => {
                    console.log("res lấy đơn vị:")
                    console.log(response)
                    if (response.data.code == 200) {
                        let ldv = []
                        let dulieu = response.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                value: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi_phong = ldv;
                    } else {

                    }
                    this.loading.status = false;
                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
            }
        },
        getVaiTro() {
            console.log('getVaiTro');
            this.list_vai_tro = [];
            try {
                console.log("Lấy danh sách tỉnh thành:")
                let params = {};
                this.loading.status = true;
                this.loading.text = 'Lấy danh sách vai trò';
                rest_api.get("/csdlgd-user/adminRole/getRole", params, (response) => {
                    console.log("res lấy đơn vị sở:")
                    console.log(response)
                    if (response.data) {
                        let ldv = []
                        let dulieu = response.data;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].roleName +
                                    ' - [' + dulieu[i].roleId + ']',
                                value: dulieu[i].roleId,
                                parent: dulieu[i].parentRole
                            }
                            ldv.push(obj)
                        }
                        this.list_vai_tro = ldv;
                    } else {

                    }
                    this.loading.status = false;
                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
            }
        },
        getTinhThanh() {
            console.log('getTinhThanh');
            this.list_don_vi_so = [];
            try {
                console.log("Lấy danh sách tỉnh thành:")
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "loaiDonVi": 1,
                    "check": false
                };
                this.loading.status = true;
                this.loading.text = 'Lấy danh sách đơn vị';
                rest_api.get("/internal-api/dmDonVi/filter", params, (response) => {
                    console.log("res lấy đơn vị sở:")
                    console.log(response)
                    if (response.data.code == 200) {
                        let ldv = []
                        let dulieu = response.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                value: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi_so = ldv;
                    } else {

                    }
                    this.loading.status = false;
                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
            }
        },
        thongBao(typeNoty, message) {
            let msg = "";
            let cl = "";
            if (message) {
                msg = message;
            }
            let type = "success";
            if (typeNoty) {
                type = typeNoty
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
                type: type,
                duration: 5000
            });
        },
    }
}

</script>
<style scoped="scoped">
.mt-15 {
    margin-top: 15px !important;
}

</style>

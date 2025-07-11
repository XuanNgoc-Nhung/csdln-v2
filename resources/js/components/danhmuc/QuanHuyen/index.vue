<template>
    <div>
        <Breadcrumb :menu="'Danh mục'" :desc="'Quận huyện'" />
        <el-form ref="ruleForm">
            <el-row :gutter="24" class="card-bieu-do">
                <el-col :span="24">
                    <div class="table-name">Thông tin tìm kiếm</div>
                </el-col>
                <el-col :sm="12" :md="12" :lg="6">
                    <label>Năm học <sup class="red">*</sup></label>
                    <div>
                        <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                            :data="list_nam_hoc" :fields="['name', 'id']" />
                    </div>
                </el-col>
                <el-col :sm="12" :md="12" :lg="6">
                    <label>Tỉnh thành</label>
                    <div>
                        <eselect style="width:100%" :disabled="thongtin.role > 1" collapseTags v-model="maSo"
                            :placeholder="'Chọn'" filterable :data="list_don_vi_so" :fields="['name', 'value']" />
                    </div>
                </el-col>
                <el-col :sm="12" :md="12" :lg="6">
                    <label>Tên quận huyện</label>
                    <el-input clearable v-model="tenQuanHuyen" @change="tenQuanHuyen = tenQuanHuyen.trim()"
                        placeholder="Nhập..." />
                </el-col>
                <el-col :sm="12" :md="12" :lg="6">
                    <label>Mã quận huyện</label>
                    <el-input clearable v-model="maQuanHuyen" @change="maQuanHuyen = maQuanHuyen.trim()"
                        placeholder="Nhập..." />
                </el-col>
                <el-col :sm="12" :md="12" :lg="6">
                    <label>Trạng thái</label>
                    <!-- <select class="form-control" style="height: 36px !important" v-model="trangThai">
                        <option value=''>Tất cả</option>
                        <option value='1'>Đang hoạt động</option>
                        <option value='0'>Ngưng hoạt động</option>
                    </select> -->
                    <el-select v-model="trangThai" placeholder="Tất cả" clearable style="height: 36px !important;">
                        <el-option label="Tất cả" value=""></el-option>
                        <el-option label="Đang hoạt động" value="1"></el-option>
                        <el-option label="Ngưng hoạt động" value="0"></el-option>
                    </el-select>

                </el-col>
                <el-col :span="24" class="text-center">
                    <el-button class="bt-chinh" size="mini" type="success" v-on:click.prevent="TruocKhiTim()">Tìm kiếm
                    </el-button>
                </el-col>

            </el-row>
        </el-form>

        <el-row :gutter="24" class="card-bieu-do" style="padding-top:5px; margin-top:16px !important">
            <el-col :span="24">
                <div class="centerBetweenFlex">
                    <label class="table-name">Danh sách quận huyện</label>
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

                                <th class="text-center">
                                    <p>Mã quận huyện</p>
                                </th>
                                <th>
                                    <p>Tên quận huyện</p>
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
                        <tbody v-if="ds_quan_huyen.length===0">
                            <tr>
                                <td class="text-center" colspan="23">
                                    <p>Không có bản ghi nào</p>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="(qh,index) in ds_quan_huyen" :key="index">
                                <td class="text-center fixed-column fixed-col1">
                                    <p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                </td>

                                <td class="text-center">
                                    <p>{{ qh.maQuanHuyen }}</p>
                                </td>
                                <td>
                                    <p>{{ qh.tenQuanHuyen }}</p>
                                </td>
                                <td>
                                    <p>{{ qh.tenTinhThanh }}</p>
                                </td>
                                <td>
                                    <p>{{ getTime(qh.ngayCapNhat)}}</p>
                                </td>
                                <td class="text-center">
                                    <p v-bind:class="getClass(qh.trangThai)">
                                        {{ parseInt(qh.trangThai) === 1 ? 'Đang hoạt động' : 'Ngưng hoạt động' }}</p>
                                </td>
                                <td class="text-center">

                                    <el-tooltip v-if="qh.trangThai==1" content="Khóa " placement="top">
                                        <i @click.prevent="thayDoiTrangThai(qh,1)" class="el-icon-lock"></i>
                                        <!-- <el-button type="warning" @click.prevent="thayDoiTrangThai(qh,1)" size="mini">
                                        <i class="el-icon-lock"   ></i>
                                    </el-button> -->
                                    </el-tooltip>
                                    <el-tooltip v-else content="Mở khóa" placement="top">
                                        <i class="el-icon-unlock" @click.prevent="thayDoiTrangThai(qh,2)"></i>
                                        <!-- <el-button type="success" @click.prevent="thayDoiTrangThai(qh,2)" size="mini"><i
                                            class="el-icon-unlock"   ></i>
                                        </el-button> -->
                                    </el-tooltip>
                                    <el-tooltip content="Sửa" placement="top">

                                        <i class="el-icon-edit" @click.prevent="chinhSuaQuanHuyen(qh)"></i>
                                        <!-- <el-button type="warning" @click.prevent="chinhSuaQuanHuyen(qh)" size="mini">
                                        <i class="el-icon-edit"   ></i>
                                        </el-button> -->
                                    </el-tooltip>
                                    <el-tooltip content="Xóa" placement="top">

                                        <!-- <el-button type="danger" @click.prevent="xoaQuanHuyen(qh)" size="mini"> -->
                                        <i class="el-icon-delete" @click.prevent="xoaQuanHuyen(qh)"></i>
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
            <ImportQuanHuyen :show="show_import" :info="thongTinImport" @close="show_import=false"
                @success="onCreatedData($event)">
            </ImportQuanHuyen>
            <el-dialog :title="type==1?'Thêm mới quận huyện':'Chỉnh sửa quận huyện'" :visible.sync="show_add_or_update"
                width="80%" :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
                <el-form :model='dataAddOrUpdate' :rules="rules" ref="ruleForm">
                    <el-row :gutter="24">
                        <el-col :sm="12" :md="12" :lg="8">
                            <label>Tỉnh thành <sup class="red">*</sup></label>
                            <el-form-item prop="maSoAdd">
                                <eselect style="width:100%" :disabled="thongtin.role>1" collapseTags ref="maSoAdd"
                                    v-model="dataAddOrUpdate.maSoAdd" :placeholder="'Chọn'" filterable
                                    :data="list_don_vi_so" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="12" :md="12" :lg="8">
                            <label>Mã quận huyện <sup class="red">*</sup></label>
                            <el-form-item prop="maQuanHuyenAdd">
                                <el-input clearable ref="maQuanHuyenAdd" @change="nhapDuLieuInput()" :disabled="type==2"
                                    v-model="dataAddOrUpdate.maQuanHuyenAdd" placeholder="Nhập..." />
                            </el-form-item>
                        </el-col>
                        <el-col :sm="12" :md="12" :lg="8">
                            <label>Tên quận huyện <sup class="red">*</sup></label>
                            <el-form-item prop="tenQuanHuyenAdd">
                                <el-input clearable ref="tenQuanHuyenAdd" @change="nhapDuLieuInput()"
                                    v-model="dataAddOrUpdate.tenQuanHuyenAdd" placeholder="Nhập..." />
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
    import Breadcrumb from '../../ui/Breadcrumb.vue';
    import constant from '../../../utils/constant';
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
                check_confirm_come_back: false,
                thongTinImport: {
                    title: 'Nhập quận huyện',
                    pathImport: '/api-import-quan-huyen',
                    pathTemplate: '/templateImport/Template_Quan_Huyen.xlsx'
                },
                thongtin: JSON.parse(window.userInfo),
                list_don_vi_so: [],
                ds_quan_huyen: [],
                type: null,
                typeUpdate: null,
                trangThaiUpdate: "",
                maSo: "",
                namHoc: "",
                list_nam_hoc: constant.LIST_YEARS_FULL,
                tenQuanHuyen: "",
                maQuanHuyen: "",
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
                    tenQuanHuyenAdd: '',
                    maQuanHuyenAdd: '',
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
                    tenQuanHuyenAdd: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                }
            }
        },
        mounted() {
            console.log("mounted quận huyện");
            this.thongtin = JSON.parse(window.userInfo);
            this.namHoc = this.thongtin.namHocHienTai;
            if (this.thongtin.role > 1) {
                this.maSo = this.thongtin.ma_so;
                this.dataAddOrUpdate.maSoAdd = this.thongtin.ma_so;
            }
            this.getDonVi();
            // this.getData();
        },
        methods: {
            trimValue(text) {
                return text.trim();
            },
            nhapDuLieuInput() {
                console.log('nhapDuLieuInput');
                this.check_confirm_come_back = true;
                this.dataAddOrUpdate.maQuanHuyenAdd = this.dataAddOrUpdate.maQuanHuyenAdd.trim();
                this.dataAddOrUpdate.tenQuanHuyenAdd = this.dataAddOrUpdate.tenQuanHuyenAdd.trim();
            },
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
            onCreatedData() {
                this.thongBao('success', 'Thêm dữ liệu thành công')
                this.TruocKhiTim();
            },
            showImport() {
                this.show_import = true;
            },
            thayDoiTrangThai(e, stt) {
                this.typeUpdate = "Xác nhận thay đổi trạng thái Quận huyện?"
                this.type = 2;
                this.dataAddOrUpdate.maSoAdd = e.maTinhThanh;
                this.dataAddOrUpdate.tenQuanHuyenAdd = e.tenQuanHuyen;
                this.dataAddOrUpdate.maQuanHuyenAdd = e.maQuanHuyen;
                let msg = 'Xác nhận khóa quận huyện?'
                if (stt == 1) {
                    this.trangThaiUpdate = 0;
                    msg = 'Xác nhận khóa quận huyện?'
                } else {
                    this.trangThaiUpdate = 1;
                    msg = 'Xác nhận mở khóa quận huyện?'
                }

                this.$confirm(msg, 'Cập nhật trạng thái', {
                        closeOnClickModal: false,
                        confirmButtonText: this.trangThaiUpdate == 1 ? 'Mở khóa' : 'Khóa',
                        cancelButtonText: 'Hủy',
                    })
                    .then(_ => {
                        this.themQuanHuyen();
                    })
                    .catch(_ => {});
            },
            handleClose() {
                console.log('check_confirm_come_back');
                console.log(this.check_confirm_come_back);
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
                            this.dataAddOrUpdate = {
                                maSoAdd: '',
                                tenQuanHuyenAdd: '',
                                maQuanHuyenAdd: '',
                            }
                            this.resetForm('ruleForm')
                            this.show_add_or_update = false;
                        })
                        .catch(_ => {});
                } else {
                    this.dataAddOrUpdate = {
                        maSoAdd: '',
                        tenQuanHuyenAdd: '',
                        maQuanHuyenAdd: '',
                    }
                    this.resetForm('ruleForm')
                    this.show_add_or_update = false;
                }
            },

            resetForm(formName) {
                this.check_confirm_come_back = false;
                this.$refs[formName].resetFields();
            },
            chinhSuaQuanHuyen(e) {
                this.typeUpdate = "Xác nhận chỉnh sửa dữ liệu?"
                this.type = 2;
                this.trangThaiUpdate = e.trangThai;
                this.dataAddOrUpdate.maSoAdd = e.maTinhThanh;
                this.dataAddOrUpdate.tenQuanHuyenAdd = e.tenQuanHuyen;
                this.dataAddOrUpdate.maQuanHuyenAdd = e.maQuanHuyen;
                this.show_add_or_update = true;
            },
            xoaQuanHuyen(e) {
                let ma = e.maQuanHuyen;
                let url = "/internal-api/dmQuanHuyen/delete?ma=" + ma
                console.log("đồng ý xóa");
                let params = {};

                this.$confirm('Xác nhận xóa quận huyện?',
                        'Xóa quận huyện', {
                            confirmButtonText: 'Xóa',
                            cancelButtonText: 'Hủy',
                            closeOnClickModal: false,
                            confirmButtonClass: 'el-button--danger'
                        })
                    .then(_ => {
                        let loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.delete(url, params, (response) => {
                            loading.close();
                            console.log("Xóa")
                            console.log(response);
                            if (response.data.statusResponse == 0) {
                                this.thongBao("success", response.data.message)
                                this.getData();
                            } else {
                                this.thongBao('error', response.data.message)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            showThemMoi() {
                this.typeUpdate = "Xác nhận thêm mới?"
                this.type = 1;
                this.dataAddOrUpdate = {
                    maSoAdd: '',
                    tenQuanHuyenAdd: '',
                    maQuanHuyenAdd: '',
                }
                this.resetForm('ruleForm')
                if (this.thongtin.role != 1) {
                    this.dataAddOrUpdate.maSoAdd = this.thongtin.ma_so;
                }
                this.show_add_or_update = true;
            },
            themQuanHuyen() {

                const params = {
                    ma: this.dataAddOrUpdate.maQuanHuyenAdd,
                    maTinhThanh: this.dataAddOrUpdate.maSoAdd,
                    ten: this.dataAddOrUpdate.tenQuanHuyenAdd,
                };
                let url = "";
                if (this.type == 1) {
                    url = "/internal-api/dmQuanHuyen/create"
                    let loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    rest_api.post(url, params, (response) => {
                        loading.close();
                        console.log(response);
                        if (response.data.code == 200) {
                            this.thongBao('success', response.data.message)
                            this.show_add_or_update = false;
                            this.TruocKhiTim();
                        } else {
                            this.thongBao('error', response.data.message)
                            return;
                        }
                    });
                } else {
                    url = "/internal-api/dmQuanHuyen/update";
                    params.trangThai = this.trangThaiUpdate;
                    let loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    rest_api.put(url, params, (response) => {
                        loading.close();
                        if (response.data.code == 200) {
                            this.thongBao('success', response.data.message)
                            this.show_add_or_update = false;
                            this.TruocKhiTim();
                        } else {
                            this.thongBao('error', response.data.message)
                            return;
                        }
                    });
                }
                // this.$confirm(this.typeUpdate,
                //     'Thông báo', {
                //         confirmButtonText: this.type==1?'Thêm':'Sửa',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {
                //         // đồng ý
                //     })
                //     .catch(_ => {
                //     });
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
                    "ma": this.maQuanHuyen,
                    "ten": this.tenQuanHuyen,
                    "maTinhThanh": this.maSo,
                    "trangthai": this.trangThai,
                };
                let loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (data) => {
                    loading.close();
                    if (data.data.statusResponse == 0) {
                        this.total_rows = data.data.total;
                        this.ds_quan_huyen = data.data.rows;
                    } else {}
                });
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 100,
                };
                let loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    loading.close();
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

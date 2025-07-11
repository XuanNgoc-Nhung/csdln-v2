<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog width="80%" top="15vh" :title="text_header" custom-class="showThongTinLoiImportSSO"
            :visible.sync="show_add" :close-on-press-escape="false" append-to-body :close-on-click-modal="false"
            :before-close="closeImport">
            <el-row :gutter="20">
                <el-form :model='dataAdd' :rules="rules" ref="ruleForm">
                    <el-col :xs="24" :sm="12" :md="8" >
                        <label>Tên tài khoản: <span class="red">*</span></label>
                        <el-form-item prop="hoTen">
                            <el-input clearable placeholder="Nhập..." maxlength="50"
                                @change="check_confirm_come_back = true;dataAdd.hoTen = dataAdd.hoTen.trim()" ref="hoTen" v-model="dataAdd.hoTen"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" >
                        <label>Tên đăng nhập: <span class="red">*</span></label>
                        <el-form-item prop="username">
                            <el-input clearable placeholder="Nhập..." maxlength="30"
                                @change="check_confirm_come_back = true;dataAdd.username = dataAdd.username.trim()" ref="username" v-model="dataAdd.username">
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" >
                        <label>Email: <span class="red">*</span></label>
                        <el-form-item prop="email">
                            <el-input clearable placeholder="Nhập..." maxlength="100"
                                @change="check_confirm_come_back = true;dataAdd.email = dataAdd.email.trim()" ref="email" v-model="dataAdd.email"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" >
                        <label>Số điện thoại: <span class="red">*</span></label>
                        <el-form-item prop="sdt">
                            <el-input clearable placeholder="Nhập..." @change="dataAdd.sdt = dataAdd.sdt.trim()" ref="sdt" maxlength="11" @input="nhapSoDienThoai"
                                v-model="dataAdd.sdt"></el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8" >
                        <label>Vai trò: <span class="red">*</span></label>
                        <el-form-item prop="role">
                            <eselect collapseTags ref="role" v-model="dataAdd.role" @change="chonVaiTro"
                                :placeholder="'Chọn'" filterable :data="list_vai_tro" :fields="['name','value']" />
                        </el-form-item>
                    </el-col>
                    <template v-if="dataAdd.parentRole==2">
                        <el-col :xs="24" :sm="12" :md="8" >
                            <label>Cấp học: <span class="red">*</span></label>

                            <el-form-item prop="capHocList">
                                <eselect collapseTags ref="capHocList" v-model="dataAdd.capHocList" multiple
                                         @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                         :data="list_cap_hoc" :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="24" :md="8" >
                            <label>Đơn vị quản lý: <span class="red">*</span></label>

                            <el-form-item prop="maDonVi">
                                <eselect collapseTags ref="maDonVi" v-model="dataAdd.maDonVi"
                                    @change="check_confirm_come_back = true" :disabled="thongtin.role!=1"
                                    :placeholder="'Chọn'" filterable :data="list_don_vi_so"
                                    :fields="['name','value']" />
                            </el-form-item>
                        </el-col>

                    </template>
                    <template v-if="dataAdd.parentRole==4">
                        <el-col :xs="24" :sm="12" :md="8" >
                            <label>Cấp học: </label>
                            <el-form-item prop="capHocList">
                                <eselect collapseTags ref="capHocList" v-model="dataAdd.capHocList" multiple
                                         @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                         :data="list_cap_hoc" :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="24" :md="8" >
                            <label>Đơn vị: <span class="red">*</span></label>
                            <el-form-item prop="maDonVi">
                                <eselect collapseTags ref="maDonVi" v-model="dataAdd.maDonVi" :placeholder="'Chọn'"
                                    @change="check_confirm_come_back = true" filterable :data="list_don_vi"
                                    :fields="['name','value']" />
                            </el-form-item>
                        </el-col>

                    </template>

                    <template v-if="dataAdd.parentRole==5">
                        <el-col :xs="24" :sm="12" :md="8" >
                            <label>Cấp học: <span class="red">*</span></label>
                            <el-form-item prop="capHocList">
                                <eselect collapseTags ref="capHocList" v-model="dataAdd.capHocList" multiple
                                         @change="chonDonVi" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                                         :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                        <el-col :xs="24" :sm="24" :md="8" >
                            <label>Đơn vị: <span class="red">*</span></label>
                            <el-form-item prop="maDonVi">
                                <eselect collapseTags ref="maDonVi" v-model="dataAdd.maDonVi" @change="chonDonVi"
                                    :placeholder="'Chọn'" filterable :data="list_don_vi" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>

                        <el-col :xs="24" :sm="24" :md="16" >
                            <label>Trường học: <span class="red">*</span></label>
                            <el-form-item prop="maTruongHoc">
                                <eselect collapseTags ref="maTruongHoc" v-model="dataAdd.maTruongHoc"
                                    @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                    :data="list_truong_hoc" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                    </template>
                </el-form>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="default" @click="closeImport">Huỷ</el-button>
                <el-button size="mini" type="primary" @click.prevent="submitForm('ruleForm')">Lưu</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';

    export default {
        props: ['list_vai_tro', 'list_don_vi_so'],
        components: {
            'eselect': ESelectVue,
        },
        watch: {},
        data() {
            return {
                check_confirm_come_back: false,
                loading: {
                    status: false,
                    text: 'Loading...'
                },
                show_add: false,
                text_header: 'Thêm mới tài khoản',
                thongtin: {},
                dataAdd: {
                    parentRole: null,
                    hoTen: '',
                    email: '',
                    maDonVi: '',
                    maSo: '',
                    sdt: '',
                    maPhong: '',
                    maTruongHoc: '',
                    role: '',
                    trangThai: 1,
                    roleType: 1,
                    username: '',
                    capHocList: [],
                },

                rules: {
                    hoTen: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    email: [{
                        type: 'email',
                        message: 'Email không đúng định dạng',
                        trigger: ['blur', 'change']
                    }, {
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }],
                    maDonVi: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    maPhong: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    maTruongHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    role: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    username: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    capHocList: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    sdt: [{
                        pattern: /^0\d+$/,
                        message: 'Số điện thoại không đúng định dạng',
                        trigger: ['blur', 'change']
                    }, {
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                },
                list_cap_hoc: window.listCapHoc,
                list_don_vi: [],
                list_truong_hoc: [],
            }
        },

        mounted: function () {
            console.log('Mounted thêm mới người dùng')
            this.thongtin = JSON.parse(window.userInfo);
            console.log(this.list_vai_tro)
            this.getTinhThanh();
            this.show_add = true;
        },
        methods: {
            nhapSoDienThoai() {
                this.check_confirm_come_back = true
                this.dataAdd.sdt = this.dataAdd.sdt.replace(/\D/g, '');
            },
            validateNumber(event) {
                if (event && event.target) {
                    // Lấy giá trị nhập vào từ sự kiện input
                    let value = event.target.value;

                    // Loại bỏ các ký tự không phải số từ giá trị
                    value = value.replace(/[^0-9]/g, '');

                    // Cập nhật giá trị trong trường input
                    event.target.value = value;
                }
            },
            chonDonVi() {
                this.check_confirm_come_back = true;
                this.getTruongHoc();
            },

            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.confirmAdd();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            getTinhThanh() {
                console.log('getTinhThanh')
                try {
                    let params = {
                        "start": 0,
                        "limit": 100
                    };
                    rest_api.get("/internal-api/dmTinhThanh/filter", params, (response) => {
                        if (response.data.code == 200) {
                            let ldv = []
                            let dulieu = response.data.rows;
                            for (let i = 0; i < dulieu.length; i++) {
                                let obj = {
                                    name: dulieu[i].tenTinhThanh +
                                        ' - [' + dulieu[i].maTinhThanh + ']',
                                    value: dulieu[i].maTinhThanh,
                                }
                                ldv.push(obj)
                            }
                            this.list_don_tinh = ldv;
                            console.log("Danh sách tỉnh thành:")
                            console.log(this.list_don_tinh);
                        } else {
                            this.thongBao('error', 'Không lấy được danh sách tỉnh thành.')
                        }
                    });
                } catch (e) {}
            },
            chonDonViSo() {},
            getTruongHoc() {
                console.log('getTruongHoc');
                this.dataAdd.maTruongHoc = '';
                this.list_truong_hoc = [];
                try {
                    console.log("Lấy danh sách đơn vị:")
                    let params = {
                        maDonVi: [],
                        capHoc: this.dataAdd.capHocList
                    };
                    if (this.dataAdd.maDonVi && this.dataAdd.maDonVi != '') {
                        params.maDonVi = [this.dataAdd.maDonVi]
                    }
                    this.loading.status = true;
                    this.loading.text = 'Lấy danh sách trường học';
                    rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, (response) => {
                        console.log("res lấy trường học:")
                        console.log(response)
                        if (response.data.code == 200) {
                            let ldv = []
                            let dulieu = response.data.rows;
                            for (let i = 0; i < dulieu.length; i++) {
                                let obj = {
                                    name: dulieu[i].tenTruongHoc +
                                        ' - [' + dulieu[i].maTruongHoc + ']',
                                    value: dulieu[i].maTruongHoc,
                                    maDonVi: dulieu[i].maDonVi,
                                    capHoc: dulieu[i].capHoc
                                }
                                ldv.push(obj)
                            }
                            this.list_truong_hoc = ldv;
                        } else {

                        }
                        this.loading.status = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
                }
            },
            getDonVi() {
                console.log('getDonVi');
                this.list_don_vi = [];
                try {
                    console.log("Lấy danh sách đơn vị:")
                    let params = {
                        "start": 0,
                        "limit": 9999,
                        "maTinhThanh": this.thongtin.ma_so,
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
                            this.list_don_vi = ldv;
                        } else {

                        }
                        this.loading.status = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
                }
            },
            getDonViPhong() {
                console.log('getDonVi');
                this.list_don_vi = [];
                try {
                    console.log("Lấy danh sách đơn vị:")
                    let params = {
                        "start": 0,
                        "limit": 9999,
                        "maTinhThanh": this.thongtin.ma_so,
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
                            this.list_don_vi = ldv;
                        } else {

                        }
                        this.loading.status = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
                }
            },
            chonVaiTro() {
                this.loading.text = 'Vui lòng đợi...';
                this.check_confirm_come_back = true;
                this.loading.status = true;
                console.log('chonVaiTro');
                console.log(this.dataAdd?.role);
                if(!this.dataAdd?.role){
                    return;
                }
                console.log(this.list_vai_tro);
                let vaiTro = this.list_vai_tro.find((obj) => {
                    return obj.value == this.dataAdd?.role;
                });
                console.log(vaiTro)
                this.dataAdd.parentRole = vaiTro.parent;
                if (this.dataAdd?.parentRole == 2 || this.dataAdd?.parentRole == 3) {
                    //Thêm sở
                    this.dataAdd.maDonVi = this.thongtin.ma_so;
                }
                if (this.dataAdd?.parentRole == 4) {
                    //    Thêm phòng
                    this.dataAdd.maDonVi = '';
                    this.getDonViPhong();
                }
                if (this.dataAdd?.parentRole == 5) {
                    // Thêm trường
                    this.dataAdd.maDonVi = '';
                    this.getDonVi()
                    this.getTruongHoc();
                }
                setTimeout(() => {
                    this.loading.status = false;
                }, 500)
            },
            confirmAdd() {
                console.log('confirmAdd')
                // console.log(this.dataAdd);
                var params = {}
                if (!this.dataAdd.hoTen || this.dataAdd.hoTen == '') {
                    this.thongBao('warning', 'Vui lòng bổ sung tên tài khoản');
                    return;
                }
                if (!this.dataAdd.username || this.dataAdd.username == '') {
                    this.thongBao('warning', 'Vui lòng bổ sung tên đăng nhập')
                    return;
                }
                if (!this.dataAdd.email || this.dataAdd.email == '') {
                    this.thongBao('warning', 'Vui lòng bổ sung email');
                    return;
                }
                if (!this.dataAdd.sdt || this.dataAdd.sdt == '') {
                    this.thongBao('warning', 'Vui lòng bổ sung số điện thoại');
                    return;
                }
                if (!this.dataAdd.role || this.dataAdd.role == '') {
                    this.thongBao('warning', 'Vui lòng bổ sung vai trò');
                    return;
                }
                if (this.dataAdd?.parentRole == 2) {
                    console.log('Thêm tài khoản sở');
                    if (!this.dataAdd?.capHocList) {
                        this.thongBao('warning', 'Vui lòng bổ sung cấp học');
                        return;
                    }
                }
                if (this.dataAdd?.parentRole == 4) {
                    console.log('Thêm tài khoản phòng');
                    if (!this.dataAdd?.maDonVi || this.dataAdd?.maDonVi == '') {
                        this.thongBao('warning', 'Vui lòng bổ sung đơn vị');
                        return;
                    }
                    if (!this.dataAdd?.capHocList || this.dataAdd?.capHocList?.length == 0) {
                        this.thongBao('warning', 'Vui lòng bổ sung cấp học');
                        return;
                    }
                }
                if (this.dataAdd?.parentRole == 5) {
                    console.log('Thêm tài khoản trường');
                    console.log('Thêm tài khoản phòng');
                    if (!this.dataAdd?.maDonVi || this.dataAdd?.maDonVi == '') {
                        this.thongBao('warning', 'Vui lòng bổ sung đơn vị');
                        return;
                    }
                    if (!this.dataAdd?.maTruongHoc || this.dataAdd?.maTruongHoc == '') {
                        this.thongBao('warning', 'Vui lòng bổ sung trường học');
                        return;
                    }
                }
                params = JSON.parse(JSON.stringify(this.dataAdd));
                console.log('Thông tin thêm mới:')
                console.log(params)
                if (params?.parentRole == 5) {
                    console.log('Gán lại cấp học:')
                    console.log(this.list_truong_hoc)
                    let infoSchool = this.list_truong_hoc.find((obj) => {
                        return obj.value == this.dataAdd.maTruongHoc
                    });
                    if (infoSchool && infoSchool.capHoc) {
                        params.capHocList = [infoSchool.capHoc]
                    }
                }
                delete params.maPhong;
                delete params.maSo;
                console.log('Thông tin thêm mới');
                console.log(params)

                console.log(this.dataAdd)
                this.loading.status = true;
                this.loading.text = 'Vui lòng đợi...';
                rest_api.post("/csdlgd-user/adminUser", params, (response) => {
                    console.log("res thêm user")
                    console.log(response)
                    if (response.data.rc == 0) {
                        this.thongBao('success', 'Thêm mới thành công');
                        this.$emit('addSuccess');
                    } else {
                        this.thongBao('error', response.data.rd);
                    }
                    this.loading.status = false;
                });
                // this.$confirm('Xác nhận thêm mới thông tin người dùng?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {})
                //     .catch(_ => {});
            },
            closeImport() {
                console.log('closeImport');
                
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
                            this.close();
                        })
                        .catch(_ => {});
                } else {
                    this.close();
                }
            },
            close() {
                this.check_confirm_come_back = false;
                this.resetForm('ruleForm')
                this.$emit('close');

            },
            resetForm(formName) {
                this.check_confirm_come_back = false;
                this.dataAdd = {
                    parentRole: null,
                    hoTen: '',
                    email: '',
                    maDonVi: '',
                    maSo: '',
                    sdt: '',
                    maPhong: '',
                    maTruongHoc: '',
                    role: '',
                    trangThai: 1,
                    roleType: 1,
                    username: '',
                    capHocList: [],
                }
                this.$refs[formName].resetFields();
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
    .bg-purple {
        background: #d3dce6;
    }

    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }

    .mt-15 {
        margin-top: 15px
    }

    .mb-15 {
        margin-bottom: 15px
    }

    .pd-10 {
        padding: 10px
    }

</style>

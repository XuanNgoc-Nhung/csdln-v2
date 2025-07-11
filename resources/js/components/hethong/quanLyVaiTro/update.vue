<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog width="90%" top="4vh" :title="text_header" custom-class="showThongTinLoiImportSSO" :visible.sync="show_update"
            :close-on-press-escape="false" append-to-body :close-on-click-modal="false" 
            :before-close="closeImport">
            <el-form :model='dataEdit' :rules="rules" ref="ruleForm">
                <el-row :gutter="20">
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Tên vai trò: <span class="red">*</span></label>
                        <el-form-item prop="roleName">
                            <el-input clearable placeholder="Nhập..." @change="check_confirm_come_back = true;dataEdit.roleName = dataEdit.roleName.trim()" ref="roleName" v-model="dataEdit.roleName">
                            </el-input>
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Vai trò gốc: <span class="red">*</span></label>
                        <el-form-item prop="parentRole">
                            <eselect collapseTags ref="parentRole" @change="check_confirm_come_back = true" v-model="dataEdit.parentRole" :placeholder="'Chọn'"
                                filterable :data="list_vai_tro_goc" :fields="['name','value']" />
                        </el-form-item>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8">
                        <label>Mô tả: <span class="red">*</span></label>
                        <el-form-item prop="description">
                            <el-input clearable ref="description" @change="check_confirm_come_back = true;dataEdit.description = dataEdit.description.trim()" placeholder="Nhập..." v-model="dataEdit.description">
                            </el-input>
                        </el-form-item>
                    </el-col>
                </el-row>
                <el-row :gutter="20">
                    <el-col :xs="24" :sm="12">
                        <label class="typo__label">Phân quyền chức năng<span class="red">*</span></label>
                        <div v-if="danh_sach_chuc_nang" class="bd Dts-scoll" :style="{  maxHeight: maxHeight + 'px' }">
                            <v-jstree :data="danh_sach_chuc_nang" show-checkbox="show-checkbox" multiple="multiple"
                                allow-batch="allow-batch" whole-row="whole-row" @item-click="clickChucNang"></v-jstree>
                        </div>
                    </el-col>
                    <el-col :xs="24" :sm="12">
                        <label class="typo__label">Phân quyền báo cáo<span class="red">*</span></label>
                        <div class="bd Dts-scoll" v-if="danh_sach_bao_cao" :style="{  height: maxHeight + 'px'}">
                            <v-jstree :data="danh_sach_bao_cao" show-checkbox="show-checkbox" multiple="multiple"
                                allow-batch="allow-batch" whole-row="whole-row" @item-click="clickBaoCao"></v-jstree>
                        </div>
                    </el-col>
                </el-row>
            </el-form>
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
    import 'vue2-datepicker/index.css';
    import VJstree from 'vue-jstree'

    export default {
        props: ['item'],
        components: {
            VJstree,
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
                show_update: false,
                text_header: 'Chỉnh sửa thông tin vai trò',
                dataEdit: {
                    description: '',
                    maSo: '',
                    parentRole: '',
                    roleName: '',
                },
                rules: {
                    description: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    parentRole: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    roleName: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                },
                thongtin: {},
                list_vai_tro_goc: [{
                        name: 'Sở',
                        value: 2
                    },
                    {
                        name: 'Phòng',
                        value: 4
                    },
                ],
                danh_sach_chuc_nang: [],
                danh_sach_bao_cao: [],
                maxHeight: window.innerHeight,
            }
        },

        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.maxHeight -= 400;
            this.getDetail();
        },
        methods: {
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.confirmUpdate();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            clickChucNang(node) {
                console.log("nội dung:")
                this.check_confirm_come_back = true;
                console.log(node)
                let allCheck = [];
                if (node && node.parentItem && node.parentItem.children) {
                    console.log('1')
                    allCheck = node
                        .parentItem
                        .children
                        .filter((obj) => obj.selected);
                }
                if (node && node.model && node.model.selected) {
                    console.log('2')
                    node.parentItem.selected = true;
                } else {

                    console.log('3')
                    if (!allCheck.length) {
                        node.parentItem.selected = false;
                    }
                }
            },
            clickBaoCao(node) {
                console.log("nội dung:")
                this.check_confirm_come_back = true;
                console.log(node)
                let allCheck = [];
                if (node && node.parentItem && node.parentItem.children) {
                    console.log('4')
                    allCheck = node
                        .parentItem
                        .children
                        .filter((obj) => obj.selected);
                }
                if (node && node.model && node.model.selected) {
                    console.log('5')
                    node.parentItem.selected = true;
                } else {

                    console.log('6')
                    if (!allCheck.length) {
                        node.parentItem.selected = false;
                    }
                }
            },
            getListFunction() {
                try {
                    let params = {
                        "roleId": this.item.roleId
                    };
                    this.loading.text = 'Đang lấy thông tin chi tiết';
                    this.loading.status = true;
                    rest_api.post("/csdlgd-user/adminRole/listFunction", params, (response) => {
                        if (response.data.rc == 0) {
                            console.log('Thông tin phân quyền:')
                            console.log(response)
                            let duLieu = JSON.parse(JSON.stringify(response.data));
                            this.danh_sach_chuc_nang = duLieu.item.menu;
                            this.danh_sach_bao_cao = duLieu.item.baoCaoRoleResponses;
                            console.log(this.danh_sach_bao_cao)
                            console.log(this.danh_sach_chuc_nang)
                        } else {}
                        setTimeout(() => {
                            this.loading.status = false;
                            this.show_update = true;
                            // this.thongBao('success', 'Lấy thông tin thành công');
                        }, 500)
                    });
                } catch (e) {
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút');
                }
            },
            getDetail() {
                if (this.item) {
                    console.log('Lấy chi tiết thông tin')
                    console.log(this.item);
                    this.dataEdit = JSON.parse(JSON.stringify(this.item));
                    this.getListFunction();
                } else {
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút');
                }
            },
            confirmUpdate() {
                console.log('confirmUpdate');
                console.log(this.dataEdit)
                // if (!this.dataEdit.roleName || this.dataEdit.roleName == '') {
                //     this.thongBao('error', 'Vui lòng bổ sung tên vai trò');
                //     return
                // }
                // if (!this.dataEdit.parentRole || this.dataEdit.parentRole == '') {
                //     this.thongBao('error', 'Vui lòng bổ sung thông tin vai trò gốc');
                //     return
                // }
                console.log(this.danh_sach_bao_cao)
                console.log(this.danh_sach_chuc_nang)

                this.addData();
                // this.$confirm('Xác nhận chỉnh sửa dữ liệu', 'Thông báo', {
                //     confirmButtonText: 'Lưu',
                //     cancelButtonText: 'Hủy',
                // })
                //     .then(_ => {
                //     })
                //     .catch(_ => {});
            },
            addData() {
                try {
                    let paưrams = {
                        roleName: this.dataEdit.roleName,
                        parentRole: this.dataEdit.parentRole,
                        description: this.dataEdit.description,
                        maSo: this.thongtin.ma_so
                    };

                    let params = {
                        "roleDto": {
                            roleName: this.dataEdit.roleName,
                            parentRole: this.dataEdit.parentRole,
                            description: this.dataEdit.description,
                            maSo: this.thongtin.ma_so
                        },
                        "listReport": this.danh_sach_bao_cao,
                        "listMenu": this.danh_sach_chuc_nang,
                        "roleUpdate": this.item.roleId
                    };
                    console.log('Chỉnh sửa:')
                    console.error(params)
                    this.loading.text = 'Vui lòng đợi...';
                    this.loading.status = true;
                    rest_api.post("/csdlgd-user/adminRole/updateFunction", params, (response) => {
                        if (response && response.data.rc == 0) {
                            this.thongBao('success', 'Chỉnh sửa vai trò thành công');
                            this.loading.status = false;
                            this.$emit('updateSuccess');
                        } else {
                            this.thongBao('error', response.data.rd)
                        }
                        this.loading.status = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Có lỗi trong quá trình thao tác. Vui lòng thử lại');
                }
            },
            closeImport() {
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
                            this.$emit('close');
                        })
                        .catch(_ => {});
                } else {
                    this.$emit('close');
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

    .bd {
        border: 1px solid slategrey;
        height: calc(100vh - 240px);
        overflow-y: scroll;
    }

</style>

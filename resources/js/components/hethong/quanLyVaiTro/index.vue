<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <Breadcrumb :menu="'Hệ thống'" :desc="'Quản lý vai trò'"/>
        <el-row :span="20" class="card-bieu-do">
            <!-- <el-col :span="12">
                <label  class="table-name">Danh sách vai trò</label>
            </el-col>
            <el-col :span="12" class="text-right">
                <el-tooltip effect="dark" content="Thêm mới" placement="top">
                    <el-button class="bt-chinh" @click.prevent="showAdd" size="mini" type="primary">Thêm mới</el-button>
                </el-tooltip>
            </el-col> -->
            <el-col :span="24">
                <div class="centerBetweenFlex">
                    <label  class="table-name">Danh sách vai trò</label>
                    <div class="text-right">
                        <el-tooltip effect="dark" content="Thêm mới" placement="top">
                            <el-button class="bt-chinh" @click.prevent="showAdd" size="mini" type="primary">Thêm mới</el-button>
                        </el-tooltip>
                    </div>
                </div>
            </el-col>
            
            <el-col :span="24" class="pd-t-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr style="background:#e4ebf5">
                                <th class="text-center fixed-column fixed-col1">
                                    <p>STT</p>
                                </th>

                                <th>
                                    <p>Tên vai trò</p>
                                </th>
                                <th style="width: 120px">
                                    <p>Vai trò gốc</p>
                                </th>
                                <th>
                                    <p>Mô tả</p>
                                </th>
                                <th class="text-center" style="width: 120px">
                                    <p>Thao tác</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="list_data.length==0">
                            <tr>
                                <td colspan="7">
                                    <p class="text-center">Không có dữ liệu</p>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="(item,i) in list_data" :key="i">
                                <td class="text-center fixed-column fixed-col1">
                                    <p>{{ i + 1 }}</p>
                                </td>

                                <td>
                                    <p>{{ item.roleName }}</p>
                                </td>
                                <td>
                                    <p>{{parseInt(item.parentRole)=== 2 ? 'Sở' : 'Phòng'}}</p>
                                </td>
                                <td>
                                    <p>{{ item.description }}</p>
                                </td>
                                <td class="text-center">
                                    <div v-if="!item.builtIn">
                                        <el-tooltip content="Sửa" placement="top">
                                            <i @click.prevent="showUpdate(item)" class="el-icon-edit"></i>
                                        </el-tooltip>
                                        <el-tooltip content="Xóa" placement="top">
                                            <i class="el-icon-delete" @click.prevent="confirmDel(item)"></i>
                                        </el-tooltip>

                                        <!-- <el-tooltip content="Chỉnh sửa" placement="left">
                                            <el-button type="warning" @click.prevent="showUpdate(item)" size="mini">
                                                <i class="el-icon-edit"></i>
                                            </el-button>
                                        </el-tooltip>
                                        <el-tooltip content="Xoá" placement="right">
                                            <el-button type="danger" @click.prevent="confirmDel(item)" size="mini">
                                                <i class="el-icon-delete"></i>
                                            </el-button>
                                        </el-tooltip> -->
                                    </div>
                                    <div v-else>
                                        <el-tooltip content="Không thể thực hiện do không đủ quyền. Vui lòng liên hệ quản trị viên." placement="left">
                                            <i class="el-icon-edit disabled"
                                               @click.prevent="thongBao('error','Không thể thực hiện do không đủ quyền. Vui lòng liên hệ quản trị viên.')"></i>
                                        </el-tooltip>
                                        <el-tooltip content="Không thể thực hiện do không đủ quyền. Vui lòng liên hệ quản trị viên." placement="right">
                                            <!-- <el-button type="danger"
                                                @click.prevent="thongBao('error','Vai trò mặc định. Không thể xoá')"
                                                size="mini"> -->
                                            <i @click.prevent="thongBao('error','Không thể thực hiện do không đủ quyền. Vui lòng liên hệ quản trị viên.')"
                                               class="el-icon-delete disabled"></i>
                                            <!-- </el-button> -->
                                        </el-tooltip>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </el-col>
        </el-row>
        <el-row :gutter="24">
            <el-col :span="24">
                <chinhSua v-if="show_update" @close="show_update = false" @updateSuccess="updateSuccess"
                    :item="dataEdit"></chinhSua>
                <themMoi v-if="show_add" @close="show_add = false" @addSuccess="addSuccess"></themMoi>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
    import constant from "../../../utils/constant";
    import Pagination from '../../ui/PagingCustom';
    import chinhSua from './update';
    import themMoi from './add';
    import dialog from "../../../utils/dialog";
    import Breadcrumb from '../../ui/Breadcrumb.vue';

    Vue.use(ElementUI);
    export default {
        components: {
            chinhSua,
            themMoi,
            Pagination,
            'eselect': ESelectVue,
            Breadcrumb
        },
        watch: {
            activeName: function (newVal) {
                if (newVal) {
                    this.loading.status = true;
                    this.loading.text = 'Vui lòng đợi...';
                    setTimeout(() => {
                        this.loading.status = false;
                    }, 500)
                }
            }
        },
        data() {
            return {
                thongtin: {},
                activeName: 'duLieuGiaoVien',
                loading: {
                    text: 'Loading...',
                    status: false,
                },
                list_data: [],
                show_update: false,
                show_add: false,
                dataEdit: {}
            }
        },
        mounted() {
            this.thongtin = JSON.parse(window.userInfo);
            console.log('Mount quản lý vai trò');
            console.warn(this.thongtin);
            this.getData();
        },
        methods: {
            addSuccess() {
                console.log('addSuccess')
                this.show_add = false;
                this.getData();
            },
            updateSuccess() {
                console.log('updateSuccess');
                this.show_update = false;
                this.getData();
            },
            confirmDel(e) {
                console.log('confirmDel')
                if (e) {
                    try {
                        this.$confirm('Xác nhận xoá thông tin vai trò?', 'Xóa vai trò', {
                                confirmButtonText: 'Xóa',
                                cancelButtonText: 'Hủy',
                                confirmButtonClass: 'el-button--danger',
                                closeOnClickModal: false,
                            })
                            .then(_ => {
                                let params = {
                                    "roleId": e.roleId,
                                };
                                this.loading.text = 'Đang xoá...';
                                this.loading.status = true;
                                rest_api.post("/csdlgd-user/adminRole/deleteRole", params, (response) => {
                                    if (response.data.rc == 0) {
                                        this.thongBao('success', response.data.rd);
                                        this.getData();
                                    } else {
                                        this.thongBao('error', response.data.rd);
                                        this.loading.status = false;
                                    }

                                });
                            })
                            .catch(_ => {});
                    } catch (e) {

                    }
                } else {
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút');
                }
            },
            showUpdate(e) {
                console.log('showUpdate');
                if (e) {
                    this.dataEdit = e;
                    this.show_update = true;
                } else {
                    this.thongBao('error', 'Vui lòng thử lại sau');
                }
            },
            showAdd() {
                console.log('showAdd')
                this.show_add = true;
            },
            getData() {
                console.log('getData')
                try {
                    this.loading.status = true;
                    this.loading.text = 'Lấy danh sách vai trò';
                    let params = {};
                    rest_api.get("/csdlgd-user/adminRole/getRole", params, (response) => {
                        console.log('res vai trò');
                        console.log(response)
                        this.loading.status = false;
                        if (response.data && response.data.length > 0) {
                            console.log(response.data)
                            this.list_data = response.data;
                            // this.thongBao('success', 'Lấy dữ liệu thành công');
                        } else {
                            // this.thongBao('error', 'Không tìm thấy dữ liệu');
                        }

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

<template>
    <!-- Bắt đầu template -->
    <div>
        <!-- Header -->
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> hệ thống <span class="kytu"> &raquo;</span> quản lý vai trò</span>
            </div>
        </div>
        <!-- Kết thúc header -->
        <!-- Danh sách -->
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-12">
                        <button class="btn btn-primary pull-right" style="margin:5px 0" v-on:click.prevent="showCreat()">
                            Thêm mới
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead style="background:rgba(228, 235, 243, 1)">
                                    <tr>
                                        <th class="cg text-center">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg text-center">
                                            <p>Tên</p>
                                        </th>
                                        <th class="cg">
                                            <p>Vai trò gốc</p>
                                        </th>
                                        <th class="cg">
                                            <p>Mô tả</p>
                                        </th>
                                        <th class="cg">
                                            <p>Thao tác</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_role.length>0">
                                    <tr v-for="(item,i) in list_role">
                                        <td>
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{item.roleName}}</p>
                                        </td>
                                        <td>
                                            <p>{{parseInt(item.parentRole)=== 2 ? 'Sở' : 'Phòng'}}</p>
                                        </td>
                                        <td>
                                            <p>{{item.description}}</p>
                                        </td>
                                        <td class="cg">
                                            <button class="btn btn-info" v-if="item.builtIn" disabled title="Không được phép" v-on:click="showUpdate(item)">Sửa & phân quyền
                                            </button>
                                            <button class="btn btn-primary" v-else title="Chỉnh sửa" v-on:click="showUpdate(item)">Sửa & phân quyền
                                            </button>
                                            <button class="btn btn-info" v-if="item.builtIn" disabled title="Không được phép" v-on:click="DeleteRole(item)">Xóa
                                            </button>
                                            <button class="btn btn-primary" v-else title="Xóa" v-on:click="DeleteRole(item)">Xóa
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr>
                                        <td colspan="5"><p>Không có bản ghi nào</p></td>
                                    </tr>
                                </tbody>
                            </table>
                            <!-- Phân trang -->
                            <!-- <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page> -->

                            <div v-if="show_create">
                                <ThemMoiRole @close="show_create=false" @success="onCreatedData($event)"></ThemMoiRole>
                            </div>
                            <div v-if="show_update">
                                <ChinhSuaRole :item="dataEdit" @close="show_update=false" @success="onCreatedData($event)"></ChinhSuaRole>
                            </div>
                            <!-- Hết phân trang -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hết danh sách -->
    </div>
    <!-- hết template -->
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import constant from '../../utils/constant';
    import moment from "moment";
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import api from '../api';
    import Page from "../ui/PagingCustom";
    import dialog from '../../utils/dialog';
    import VueAlertify from "vue-alertify";
    import ThemMoiRole from './ThemMoiRole';
    import ChinhSuaRole from './ChinhSuaRole';
    import utils from '../../utils';
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
    export default {
        components: {
            Multiselect,
            "ThemMoiRole": ThemMoiRole,
            "ChinhSuaRole": ChinhSuaRole,
            Page: Page
        },
        props: [],
        data() {
            return {
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                dataEdit: {},
                list_role: [],
                show_create: false,
                show_update: false,
            }
        },
        watch: {},
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.getData();
        },
        methods: {
            // Xóa quyền
            DeleteRole(e){
                let params = {
                    "roleId": e.roleId,
                };
                dialog.confirmDialogWithTitle('Xóa vai trò',"Xác nhận xóa vai trò này?", "Đồng ý", () => {
                    rest_api.post("/csdlgd-user/adminRole/deleteRole", params, (data) => {
                        if (data.data.rc == 0) {
                            this
                                .$alertify
                                .success("Xóa vai trò thành công");
                                this.getData();
                        } else {
                            this
                                .$alertify
                                .error("Thất bại:" + data.data.rd + ".Vui lòng thử lại.")
                        }
                    });
                });
            },
            onCreatedData(){
                console.log("thêm mới thành công");
                this.getData();
            },
            // Chỉnh sửa
            showUpdate(e){
                this.show_update = true;
                this.dataEdit = e;
                console.log("Chỉnh sửa");
            },
            showCreat() {
                console.log("hiển thị lấy danh sách");
                this.show_create = true;
            },
            // Lấy danh sách
            getData() {
                let params = {};
                rest_api.get("/csdlgd-user/adminRole/getRole", params, (data) => {
                    if (data.status == 200) {
                        this.list_role = data.data
                    } else {}
                },60000, true);
            }
        }
    }
</script>
<style scoped="scoped">
    /*@import "../../../../node_modules/selectwithsearch.css";*/
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    label,
    span {
        padding: 0;
        margin: 0;
    }
    hr {
        margin: 5px;
    }
    a,
    button,
    input,
    label,
    p,
    span {
    }
    .cg {
        text-align: center;
        align-items: center;
    }
    .timkiem > input {
        margin-bottom: 10px;
    }
    .table > tbody > tr > td {
        vertical-align: middle;
        padding: 5px;
    }

    .multiselect--disabled {
        background: white;
    }
</style>

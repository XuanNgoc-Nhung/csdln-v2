<template>

    <div id="modal_create_adminso" ref="modal_create_adminso" class="modal fade">
        <div class="modal-dialog" style="display:contents; height:100%">
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Chỉnh sửa vai trò</h4>
                </div>
                <div class="modal-body">
                    <!-- Nội dung -->
                    <div class="row">
                        <!-- Tên vai trò -->
                        <div class="col-sm-3">
                            <label class="typo__label">Tên vai trò <span class="red">*</span></label>
                            <input
                                v-model="roleName"
                                type="text"
                                placeholder="Nhập..."
                                class="form-control"/></div>
                        <!-- Vai trò gốc -->

                        <div class="col-sm-3">
                            <label class="typo__label">Vai trò gốc <span class="red">*</span></label>
                            <select v-model="parentRole" class="form-control" id="">
                                <option value="">Chọn vai trò gốc</option>
                                <option value="2">Sở</option>
                                <option value="4">Phòng</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <label class="typo__label">Mô tả vai trò <span class="red">*</span></label>
                            <input
                                v-model="description"
                                type="text"
                                placeholder="Mô tả vai trò"
                                class="form-control"/></div>
                        <!-- Phân quyền chức năng -->
                        <!-- đoạn check -->
                        <!-- phân quyền menu-->
                        <div class="col-md-6">
                            <label class="typo__label">Phân quyền chức năng<span class="red">*</span></label>
                            <div v-if="listView" class="bd">
                                <v-jstree
                                    :data="listView"
                                    show-checkbox="show-checkbox"
                                    multiple="multiple"
                                    allow-batch="allow-batch"
                                    whole-row="whole-row"
                                    @item-click="itemClick"></v-jstree>

                            </div>
                        </div>
                        <!-- hết phân quyền menu + bắt đầu phân quyền báo cáo -->
                        <div class="col-md-6">
                            <label class="typo__label">Phân quyền báo cáo<span class="red">*</span></label>
                            <div class="bd" v-if="listReport">
                                <v-jstree
                                    :data="listReport"
                                    show-checkbox="show-checkbox"
                                    multiple="multiple"
                                    allow-batch="allow-batch"
                                    whole-row="whole-row"
                                    @item-click="itemClick2"></v-jstree>
                            </div>
                        </div>
                        <!-- hết phân quyền báo cáo -->
                        <!-- Hết đoạn check -->
                    </div>
                    <!-- Hết nội dung -->
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="pxn-col col-md-6 text-left">
                        </div>
                        <div class="pxn-col col-md-6">

                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                            </button>
                            <button type="submit" @click.prevent="upDateRole()" class="btn btn-primary">Sửa</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</template>

<script>

    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import dialog from '../../utils/dialog';
    import array_util from '../../utils/array_utils';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'
    import constant from "../../utils/constant";
    import api from '../api';
    import VJstree from 'vue-jstree'

    Vue.use(VueAlertify, {

        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            // dialogs default title
            title: 'Thông báo',
            // ok button text
            ok: 'Đồng ý',
            // cancel button text
            cancel: 'Hủy'
        }
    });
    export default {
        props: ['item'],
        components: {

            Multiselect,
            VJstree
        },
        computed: {},
        data() {
            return {
                description: "",
                roleName: "",
                parentRole: "",
                value: [],
                listView: null,
                listReport: null
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.getInfoRole(this.item);
            console.log("Thông tin chỉnh sửa:" + JSON.stringify(this.item))
            this.bindData();
            $("#modal_create_adminso").modal();
            $(this.$refs.modal_create_adminso).on("hidden.bs.modal", this.close);
        },
        watch: {},
        methods: {
            //gán dữ liệu
            bindData() {
                this.roleName = this.item.roleName;
                this.description = this.item.description;
                this.parentRole = this.item.parentRole;
            },
            getInfoRole(e) {
                let params = {
                    "roleId": e.roleId
                };
                rest_api.post("/csdlgd-user/adminRole/listFunction", params, (data) => {
                    if (data.data.rc == 0) {
                        console.log("trước:" + this.listReport);
                        this.listView = data.data.item.menu;
                        this.listReport = JSON.parse(
                            JSON.stringify(data.data.item.baoCaoRoleResponses)
                        );
                        console.log("sau khi gán:" + JSON.stringify(this.listReport));
                        console.log("sau:" + this.listReport.length);
                    } else {}
                });
            },
            itemClick(node) {
                console.log("nội dung:")
                console.log(node.parentObj)
                let allCheck = [];
                if (node.parentObj.children) {
                    allCheck = node
                        .parentObj
                        .children
                        .filter((obj) => obj.selected);
                }
                if (node.model.selected) {
                    node.parentObj.selected = true;
                } else {
                    if (!allCheck.length) {
                        node.parentObj.selected = false;
                    }
                }
            },
            itemClick2(node) {
                let allCheck2 = [];
                if (node.parentObj.children) {
                    allCheck2 = node
                        .parentObj
                        .children
                        .filter((obj) => obj.selected);
                }
                if (node.model.selected) {
                    node.parentObj.selected = true;
                } else {
                    if (!allCheck2.length) {
                        node.parentObj.selected = false;
                    }
                }
                console.log("chọn:");
                console.log(JSON.stringify(node.parentObj));
            },
            upDateRole() {
                console.log("thêm mới role");
                let params = {
                    "roleDto": {
                        "roleName": this.roleName,
                        "parentRole": this.parentRole,
                        "roleId":  this.item.roleId,
                        "description": this.description
                    },
                    "listReport": this.listReport,
                    "listMenu": this.listView,
                    "roleUpdate": this.item.roleId
                };
                console.log("param thêm là:");
                console.log(JSON.stringify(params))
                console.log("thông tin chỉnh sửa role:" + JSON.stringify(params));

                dialog.confirmDialog("Xác nhận thay đổi?", "Đồng ý", () => {
                    rest_api.post("/csdlgd-user/adminRole/updateFunction", params, (data) => {
                        if (data.data.rc == 0) {
                            this
                                .$alertify
                                .success("Chỉnh sửa thành công");
                            this.doneUpdate();
                            this.close();
                        } else {
                            this
                                .$alertify
                                .error("Thất bại:" + data.data.rd + ".Vui lòng thử lại.")
                        }
                    });
                });

            },
            doneUpdate() {
                this.$emit('success');
            },
            close() {
                this.$emit('close');
            }
        }

    }
</script>

<style scoped="scoped">
    /*@import "../../../../node_modules/selectwithsearch.css";*/

    a,
    button,
    input,
    label,
    p,
    span {
    }

    .red {
        color: #DC0101;
    }

    .pxn-col {}

    .pxn-col > input,
    select {
        margin-bottom: 10px;
    }

    .multiselect--disabled {
        background: white;
    }

    .bd {
        border: 1px solid slategrey;
        height: 40%;
        overflow-y: scroll;
    }

    input.form-control {
        margin: 0 0 10px;
    }
</style>

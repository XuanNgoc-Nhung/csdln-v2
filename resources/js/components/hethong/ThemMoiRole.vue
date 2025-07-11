<template>

    <div id="modal_create_adminso" ref="modal_create_adminso" class="modal fade">
        <div class="modal-dialog" style="width: 90%">
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
                    <h4 class="modal-title text-uppercase">Thêm mới vai trò</h4>
                </div>
                <div class="modal-body">
                    <!-- Nội dung -->
                    <div class="row">
                        <!-- Tên vai trò -->

                        <div class="col-md-3">
                            <label class="typo__label">Tên vai trò <span class="red">*</span></label>
                            <input
                                v-model="roleName"
                                type="text"
                                placeholder="Nhập..."
                                class="form-control"/></div>
                        <!-- Vai trò gốc -->

                        <div class="col-md-3">
                            <label class="typo__label">Vai trò gốc <span class="red">*</span></label>
                            <select v-model="parentRole" class="form-control" id="">
                                <option value="">Chọn vai trò gốc</option>
                                <option value="2">Sở</option>
                                <option value="4">Phòng</option>
                            </select>
                        </div>
                        <!-- Đơn vị -->

                        <!-- <div class="col-sm-3"> -->
                        <!-- <label class="typo__label">Đơn vị phụ trách (<span
                        class="red">*</span>):</label> <select class="form-control" id=""> <option
                        value="">Chọn đơn vị</option> </select> </div> -->
                        <!-- Mô tả -->

                        <div class="col-md-3">
                            <label class="typo__label">Mô tả vai trò <span class="red">*</span></label>
                            <input
                                v-model="description"
                                type="text"
                                placeholder="Mô tả vai trò"
                                class="form-control"/></div>
                        <!-- Phân quyền chức năng -->
                        <hr/>
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
                            <button type="submit" @click.prevent="TaoNguoiDung()" class="btn btn-primary">Thêm</button>
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
        props: [],
        components: {

            Multiselect
        },
        data() {
            return {description: "", roleName: "", parentRole: ""}
        },
        mounted: function () {

            this.thongtin = JSON.parse(window.userInfo);
            $("#modal_create_adminso").modal();
            $(this.$refs.modal_create_adminso).on("hidden.bs.modal", this.close);
        },
        watch: {},
        methods: {
            TaoNguoiDung() {
                if(!this.parentRole){
                    this.$alertify.error("Vui lòng bổ sung thông tin.");
                    return;
                }
                console.log("thêm mới role");
                let params = {
                    "roleName": this.roleName,
                    "description": this.description,
                    "parentRole": this.parentRole,
                    "maSo": this.thongtin.ma_don_vi
                };

                dialog.confirmDialog("Xác nhận thêm role mới?", "Đồng ý", () => {
                    rest_api.post("/csdlgd-user/adminRole/createRole", params, (data) => {
                        console.log("thêm trả về:" + JSON.stringify(data));
                        if (data.data.rc == 0) {
                            this
                                .$alertify
                                .success("Thêm mới vai trò thành công");
                            this.close();
                        } else {
                            this
                                .$alertify
                                .error("Thất bại:" + data.data.rd + ".Vui lòng thử lại.")
                        }
                    });
                });
            },
            close() {
                console.log("đóng");
                this.$emit('success')
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
    }
</style>

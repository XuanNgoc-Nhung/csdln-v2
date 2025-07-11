<template>
    <div id="modal_update_user" ref="modal_update_user" class="modal fade">
        <div class="modal-dialog" style="width: 70%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h3 class="modal-title text-uppercase">Chỉnh sửa thông tin người dùng</h3>
                </div>
                <div class="modal-body" style="width: 90%;margin: 0 auto;">
                    <div class="row student-info">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tên người dùng</div>
                                <div class="col-md-8">
                                    <input
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tên đăng nhập</div>
                                <div class="col-md-8">
                                    <input
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tỉnh thành</div>
                                <div class="col-md-8">
                                    <select
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn tỉnh thành--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row student-info">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tỉnh thành</div>
                                <div class="col-md-8">
                                    <select
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn tỉnh thành--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tỉnh thành</div>
                                <div class="col-md-8">
                                    <select
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn tỉnh thành--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tên người dùng</div>
                                <div class="col-md-8">
                                    <input
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row student-info">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tỉnh thành</div>
                                <div class="col-md-8">
                                    <select
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn tỉnh thành--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-4">Tên người dùng</div>
                                <div class="col-md-8">
                                    <input
                                        class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                        style="width:100%"
                                        type="text"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="UpdateUser()" class="btn btn-primary">Sửa</button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>

    $(document).ready(function () {
        console.log("ready!");
    });

    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'

    Vue.use(VueAlertify);
    export default {
        props: ['item', 'show'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_update_user").modal();
                } else {
                    $("#modal_update_user").modal('hide');
                }
            },
            item:function (newVal) {
                console.log("sửa của:");
                console.log("123456" + JSON.stringify(newVal));

            }
        },
        data() {
            return {
                student_code: '',
            }
        },
        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_update_user).on("hidden.bs.modal", this.close);
        },
        methods: {
            UpdateUser() {
                utils.confirmDialog("Bạn có muốn chỉnh sửa thông tin người dùng này?", "Sửa", () => {

                    const params = {
                    };
                    this.$emit('success', params);
                    this.close();
                })
            },
            close() {
                console.log("Đóng modal");
                this.$emit('close');
            },


        }

    }
</script>


<style scoped>
    .col-md-8 {
        padding-bottom: 25px;
    }

    .student-info span {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 19px;
    }

    .thumbnail {
        position: relative;
    }

    #box-img .thumbnail {
        width: 150px;
        height: 150px;
    }

    .control-label {
        display: block;
        float: left;
    }

    #change_image {
        position: absolute;
        bottom: 10px;
        left: 10px;
    }

    .img_preview {
        width: 150px;
        height: 150px;
    }

    .required {
        font-size: 12px;
        color: #DC0101
    }
</style>

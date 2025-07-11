<template>
    <div id="modal_doi_mat_khau" ref="modal_doi_mat_khau" class="modal fade">
        <div class="modal-dialog" style="width: 40%">
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
                    <h4 class="modal-title text-uppercase">Đổi mật khẩu</h4>
                </div>
                <div class="modal-body clearfix">
                    <div>
                        <marquee behavior="" direction="">
                            <span style="color:#DC0101">
                                <span style="font-size:18px;">Thông báo:</span>
                                Bạn đang sử dụng mật khẩu mặc định. Vui lòng đổi mật khẩu để đảm bảo tính bảo
                                mật.</span>
                        </marquee>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <label style="line-height: 34px;">Nhập mật khẩu mới:(<span style="color:#DC0101;">*</span>)</label>
                                <input type="password" v-model="password" class="form-control control-inline"/>
                                <span style="color:#DC0101;font-size: 12px">{{thongbao}}</span>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <label style="line-height: 34px;">Nhập lại mật khẩu mới: (<span style="color:#DC0101;">*</span>)</label>
                                <input
                                    type="password"
                                    v-model="repassword"
                                    class="form-control control-inline"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Để sau
                    </button>
                    <button type="button" class="btn btn-primary" @click.prevent="changePass">Đổi mật khẩu
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import utils from '../../utils';
    import dialog from "../../utils/dialog";
    import api from "./../api";
    $(document).ready(function () {
        console.log("ready!");
    });
    export default {
        props: [
            'item', 'show'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_doi_mat_khau").modal();
                } else {
                    $("#modal_doi_mat_khau").modal('hide');
                }
            },
            item: function (newVal) {
                this.infoUser = newVal;
                console.log("thông tin" + JSON.stringify(this.infoUser))
            }
        },
        data() {
            return {password: "", repassword: "",thongbao:"", infoUser: {}, showerr: false}
        },
        mounted: function () {
            console.log("12345678987654321345678909876543");
        },
        methods: {
            changePass() {
                if (this.password != this.repassword) {
                    showDialog("Thông báo", "Vui lòng nhập lại chính xác mật khẩu mới", null, () => {
                        return;
                    });
                    return;
                }
                dialog.confirmDialog("Xác nhận đổi mật khẩu?", "Đồng ý", () => {
                    const uri = "/doi_mat_khau_ban_than";
                    let params = {
                        password: this.password,
                        username: this.infoUser.username,
                    };
                    // console.log("mk" + JSON.stringify(params))
                    api.post(uri, params, response => {
                        console.log("đổi mật khẩu trả về:")
                        console.log(JSON.stringify(response));
                        if (response.data.rc === 0) {
                            showDialog("Thông báo", "Đổi mật khẩu thành công. Vui lòng đăng nhập lại.", null, () => {
                                setTimeout(() => {
                                    this.LogOut();
                                }, 200)
                            });
                        } else {
                            this.thongbao= response.data.rd
                            showDialog("Thất bại", "Vui kiểm tra lại thông tin.", null, () => {
                                return;
                            });
                        }
                    });
                });
            },
            LogOut(){
                console.log("Đăng xuất");
                let logout = 'logout';
                window.location.href = logout;
            },
            close(){}
        }
    }
</script>
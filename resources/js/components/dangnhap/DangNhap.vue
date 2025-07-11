<template>
    <div class="container">
        <div class="col-md-5 col-md-offset-3">
            <div class="login-panel panel panel-default">
                <div class="panel-body row" style="padding-top: 0; padding-bottom:0;">
                    <div class=" panel panel-default" style="margin-bottom:0">
                        <div class="panel-heading">
                            <h3 class="panel-title">Đăng nhập hệ thống</h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <input v-model="user_name" class="form-control" placeholder="Tên đăng nhập"
                                       autofocus>
                            </div>
                            <div class="form-group">
                                <input v-model="pass" class="form-control" placeholder="Mật khẩu người dùng"
                                       autofocus>
                            </div>
                            <label>Mã hình:</label>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control text-center" name="username" v-model="capcha"
                                               disabled
                                               autofocus>
                                    </div>
                                    <div class="col-md-6">
                                        <a href="" v-on:click.prevent="getCapCha()" class="btn btn-primary">Đổi mã</a>
                                    </div>
                                </div>
                            </div>
                            <label>Nhập mã hình:</label>
                            <div class="form-group">
                                <input class="form-control" v-model="capchanhap" placeholder="Nhập..."
                                       autofocus>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input name="remember" type="checkbox" value="Remember Me">Nhớ tài khoản
                                </label>
                            </div>
                            <input v-if="chophepdangnhap" type="submit" v-on:click="DangNhap()" value="Đăng nhập"
                                   class="btn btn-lg btn-success btn-block"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'
    import api from '../api';
    Vue.use(VueAlertify);
    export default {
        components: {},
        data() {
            return {
                capcha:"",
                capchanhap:"",
                solannhapsai:0,
                chophepdangnhap:true,
                user_name:'',
                pass:'',
            }
        },
        mounted: function () {
            this.capcha = this.rndStr(3);
        },
        methods: {

            rndStr(len) {
                let text = "";
                let chars = "abcdefghijklmnopqrstuvwxyz0123456789";

                for (let i = 0; i < len; i++) {
                    text += chars.charAt(Math.floor(Math.random() * chars.length))
                }
                return text
            },
            getCapCha() {
                this.capcha = this.rndStr(3);
            },
            DangNhap() {
                console.log(this.capcha);
                console.log(this.capchanhap);
                console.log("Submit đăng nhập");
                if (this.capcha===this.capchanhap) {
                    console.log("nhập mã capcha đúng");
                    let params = {
                        "username":this.user_name,
                        "password": this.pass,
                    };
                    const uri = "/login";
                    console.log("111111");
                    console.log(params);
                    api.post(uri, params, (res) => {
                        console.log("kết quả khi đăng nhập");
                        // console.log("here: " + JSON.stringify(res));
                        console.log(JSON.stringify(res));
                    });
                }
                else{
                    console.log("nhập mã capcha sai");
                    this.$alertify.error('Bạn đã nhập sai mã hình...');
                    this.solannhapsai++;
                    console.log(this.solannhapsai);
                    if(this.solannhapsai>=5){
                        console.log("Khóa tài khoản trong vòng 10p");
                        this.chophepdangnhap=false;
                        this.$alertify.error('Nhập sai mã hình quá số lần cho phép. Vui lòng thử lại sau 10p...');
                    }
                    return;
                }
            }
        }
    }
</script>
<style scoped>
</style>

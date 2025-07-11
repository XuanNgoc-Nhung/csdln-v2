<template>

    <div id="modal_them_quanhuyen" ref="modal_them_quanhuyen" class="modal fade">

        <div class="modal-dialog" style="width: 60%">

            <div class="modal-content">
                <form @submit.prevent="themQuanHuyenSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm quận huyện mới</h4>
                    </div>
                    <div class="modal-body clearfix">

                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trực thuộc tỉnh (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_tinhthanh"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px"
                                        v-model="ma_tinhthanh">
                                        <option value=''>--Chọn tỉnh thành--</option>
                                        <option v-for="tinhthanh in list_tinhthanh" :value="tinhthanh.maTinhThanh">{{tinhthanh.tenTinhThanh}}</option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_tinhthanh')">{{ errors.first('ma_tinhthanh') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã quận huyện (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="ma_quanhuyen" type="text"
                                           min="0"
                                           v-model="ma_quanhuyen"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_quanhuyen')">{{ errors.first('ma_quanhuyen') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên tên quận huyện (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true }" name="ten_quanhuyen" type="text"
                                           min="0"
                                           v-model="ten_quanhuyen"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_quanhuyen')">{{ errors.first('ten_quanhuyen') }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                        </button>
                        <button type="submit" class="btn btn-primary">Thêm
                        </button>
                    </div>
                </form>
            </div>


        </div>

    </div>

</template>

<script>

    import moment from 'moment'
    import utils from '../../utils'
    import api from '../api';
    import vi from 'vee-validate/dist/locale/vi';
    import VeeValidate, {Validator} from 'vee-validate';
    //Validator.localize('vi', vi);
    Vue.use(VeeValidate);

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: ['item', 'show'],


        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.reset();
                    $("#modal_them_quanhuyen").modal();
                } else {
                    $("#modal_them_quanhuyen").modal('hide');
                }
            }
        },

        data() {
            return {
                ma_quanhuyen: '',
                ten_quanhuyen: '',
                ma_tinhthanh:'',
                list_tinhthanh:[],
                show_msg:false
            }
        },
        mounted: function () {
            this.LayDanhSachTinhThanh();
            $(this.$refs.modal_them_quanhuyen).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_tinhthanh: {
                            required: () => 'Mã tỉnh thành không thể trống',
                        },
                        ma_quanhuyen: {
                            required: () => 'Mã quận huyện không thể trống',
                            max: () => 'Mã quận huyện không vượt quá 30 ký tự',
                            regex: () => 'Mã quận huyện chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        ten_quanhuyen: {
                            required: () => 'Tên quận huyện không thể trống'
                        },
                    }
                };
                this.$validator.localize('vi', dict);
            },
            themQuanHuyenSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.createQuanHuyen();
                    }
                });
            },
            LayDanhSachTinhThanh() {
                console.log("lấy danh sách tỉnh thành");

                const uri = "/api_lay_danh_sach_tinh_thanh";
                let params = {
                    "start": '0',
                    "limit": '100',
                    "ten_tinhthanh": this.ten_tinhthanh,
                };
                api.get(uri, params, (respon) => {
                    console.log(respon);
                    this.list_tinhthanh = respon.data.rows;
                })
            },
            createQuanHuyen() {
                if(this.ma_tinhthanh == ''){
                    utils.showDialog("Thông báo","Vui lòng chọn tỉnh thành");
                    return;
                }
                utils.confirmDialog("Xác nhận thêm quận huyện", "Thêm", () => {
                    const uri = "/api_them_quan_huyen";
                    const params = {
                        ma_quanhuyen: this.ma_quanhuyen,
                        ma_tinhthanh: this.ma_tinhthanh,
                        ten_quanhuyen: this.ten_quanhuyen,
                    };
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm quận huyện thành công", null, () => {
                                this.$emit('success', params);
                                this.show_msg = false;
                                this.reset();
                                this.close();
                            });
                        } else {
                            utils.showDialog("Thất bại", response.data.message, null, () => {
                            });
                        }
                    });
                })
            },

            reset() {
                this.ma_quanhuyen = "";
                this.ten_quanhuyen = "";
                this.ma_tinhthanh = "";
            },

            close() {
                console.log("close modal");
                this.show_msg = false;
                this.reset();
                this.$emit('close');
            },

        }

    }
</script>


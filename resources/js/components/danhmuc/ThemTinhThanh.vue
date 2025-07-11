<template>

    <div id="modal_them_tinhthanh" ref="modal_them_tinhthanh" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="themTinhThanhSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm tỉnh thành mới</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã tỉnh thành (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="ma_tinhthanh" type="text"
                                           min="0"
                                           v-model="ma_tinhthanh"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_tinhthanh')">{{ errors.first('ma_tinhthanh') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên tỉnh thành (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true }" name="ten_tinhthanh" type="text"
                                           min="0"
                                           v-model="ten_tinhthanh"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_tinhthanh')">{{ errors.first('ten_tinhthanh') }}</span></span>
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
                    $("#modal_them_tinhthanh").modal();
                } else {
                    $("#modal_them_tinhthanh").modal('hide');
                }
            }
        },

        data() {
            return {
                ma_tinhthanh: '',
                ten_tinhthanh: '',
                show_msg: false
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_tinhthanh).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_tinhthanh: {
                            required: () => 'Mã tỉnh thành không thể trống',
                            max: () => 'Mã tỉnh thành không vượt quá 30 ký tự',
                            regex: () => 'Mã tỉnh thành chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        ten_tinhthanh: {
                            required: () => 'Tên tỉnh thành không thể trống'
                        },
                    }
                };
                this.$validator.localize('vi', dict);
            },
            themTinhThanhSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.themTinhThanh();
                    }
                });
            },
            themTinhThanh() {
                utils.confirmDialog("Xác nhận thêm tỉnh thành", "Thêm", () => {
                    const uri = "/api_them_tinh_thanh";
                    const params = {
                        ma_tinhthanh: this.ma_tinhthanh,
                        ten_tinhthanh: this.ten_tinhthanh,
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm tỉnh thành thành công", null, () => {
                                this.$emit('success', params);
                                this.reset();
                                this.show_msg = false;
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
                this.ma_tinhthanh= "";
                this.ten_tinhthanh = "";
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


<template>

    <div id="modal_them_cndt" ref="modal_them_cndt" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="themChuyenNganhDaoTaoSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm chuyên ngành đào tạo</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã chuyên ngành (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="ma_chuyennganh" type="text"
                                           min="0"
                                           v-model="ma_chuyennganh"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_chuyennganh')">{{ errors.first('ma_chuyennganh') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên chuyên ngành (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true}" name="ten_chuyennganh" type="text"
                                           min="0"
                                           v-model="ten_chuyennganh"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_chuyennganh')">{{ errors.first('ten_chuyennganh') }}</span></span>
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
                    $("#modal_them_cndt").modal();
                } else {
                    $("#modal_them_cndt").modal('hide');
                }
            }
        },

        data() {
            return {
                ma_chuyennganh: '',
                ten_chuyennganh: '',
                show_msg:false
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_cndt).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_chuyennganh: {
                            required: () => 'Mã chuyên ngành không thể trống',
                            max: () => 'Mã chuyên ngành không vượt quá 30 ký tự',
                            regex: () => 'Mã chuyên ngành chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        ten_chuyennganh: {
                            required: () => 'Tên chuyên ngành không thể trống',
                        }
                    }
                };
                this.$validator.localize('vi', dict);
            },
            themChuyenNganhDaoTaoSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.createNation();
                    }
                });
            },
            createNation() {
                utils.confirmDialog("Xác nhận thêm chuyên ngành đào tạo", "Thêm", () => {
                    const uri = "/api_them_chuyen_nganh_dao_tao";
                    const params = {
                        ma_chuyennganh: this.ma_chuyennganh,
                        ten_chuyennganh: this.ten_chuyennganh,
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm chuyên ngành đào tạo thành công", null, () => {
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
                this.ma_chuyennganh = "";
                this.ten_chuyennganh = "";
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


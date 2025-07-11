<template>

    <div id="modal_them_dantoc" ref="modal_them_dantoc" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="themDantocSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm dân tộc mới</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã dân tộc (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="nation_code" type="text"
                                           min="0"
                                           v-model="nation_code"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('nation_code')">{{ errors.first('nation_code') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên dân tộc (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true}" name="nation_name" type="text"
                                           min="0"
                                           v-model="nation_name"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('nation_name')">{{ errors.first('nation_name') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Loại dân tộc (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="nation_type"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px"
                                        v-model="nation_type">
                                        <option value=''>--Chọn loại dân tộc--</option>
                                        <option value='1'>--Thiểu số--</option>
                                        <option value='2'>--Đa số--</option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('nation_type')">{{ errors.first('nation_type') }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                        </button>
                        <button type="submit" class="btn btn-primary">Thêm dân tộc
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
                    $("#modal_them_dantoc").modal();
                } else {
                    $("#modal_them_dantoc").modal('hide');
                }
            }
        },

        data() {
            return {
                nation_code: '',
                nation_name: '',
                nation_type:'',
                show_msg: false
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_dantoc).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        nation_code: {
                            required: () => 'Mã dân tộc không thể trống',
                            max: () => 'Mã dân tộc không vượt quá 30 ký tự',
                            regex: () => 'Mã dân tộc chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        nation_name: {
                            required: () => 'Tên dân tộc không thể trống',
                        },
                        nation_type: {
                            required: () => 'Loại dân tộc không thể trống',
                        },
                    }
                };
                this.$validator.localize('vi', dict);
            },
            themDantocSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.createNation();
                    }
                });
            },

            createNation() {
                utils.confirmDialog("Xác nhận thêm dân tộc", "Thêm", () => {
                    const uri = "/api_them_dan_toc";
                    const params = {
                        nation_code: this.nation_code,
                        nation_name: this.nation_name,
                        nation_type: this.nation_type,
                    };
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm dân tộc thành công", null, () => {
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
                this.nation_code = "";
                this.nation_name = "";
                this.nation_type = "";
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


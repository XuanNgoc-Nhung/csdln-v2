<template>

    <div id="modal_them_tongiao" ref="modal_them_tongiao" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="themTonGiaoSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm tôn giáo mới</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã tôn giáo (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="ma_tongiao" type="text"
                                           min="0"
                                           v-model="ma_tongiao"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_tongiao')">{{ errors.first('ma_tongiao') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên tôn giáo (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true}" name="ten_tongiao" type="text"
                                           min="0"
                                           v-model="ten_tongiao"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_tongiao')">{{ errors.first('ten_tongiao') }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                        </button>
                        <button type="submit" class="btn btn-primary">Thêm tôn giáo
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
                    $("#modal_them_tongiao").modal();
                } else {
                    $("#modal_them_tongiao").modal('hide');
                }
            }
        },

        data() {
            return {
                ma_tongiao: '',
                ten_tongiao: '',
                show_msg: false
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_tongiao).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_tongiao: {
                            required: () => 'Mã tôn giáo không thể trống',
                            max: () => 'Mã tôn giáo không vượt quá 30 ký tự',
                            regex: () => 'Mã tôn giáo chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        ten_tongiao: {
                            required: () => 'Tên tôn giáo không thể trống',
                        }
                    }
                };
                this.$validator.localize('vi', dict);
            },
            themTonGiaoSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.createNation();
                    }
                });
            },
            createNation() {
                utils.confirmDialog("Xác nhận thêm tôn giáo", "Thêm", () => {
                    const uri = "/api_them_ton_giao";
                    const params = {
                        ma_tongiao: this.ma_tongiao,
                        ten_tongiao: this.ten_tongiao,
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm tôn giáo thành công", null, () => {
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
                this.ma_tongiao = "";
                this.ma_cuabo = "";
                this.ten_tongiao = "";
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


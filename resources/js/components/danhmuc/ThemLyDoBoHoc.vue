<template>

    <div id="modal_them_lydobohoc" ref="modal_them_lydobohoc" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="themLyDoBoHocSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm lý do bỏ học</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã lý do (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="ma_lydo" type="text"
                                           min="0"
                                           v-model="ma_lydo"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_lydo')">{{ errors.first('ma_lydo') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên lý do (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true}" name="ten_lydo" type="text"
                                           min="0"
                                           v-model="ten_lydo"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_lydo')">{{ errors.first('ten_lydo') }}</span></span>
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
                    $("#modal_them_lydobohoc").modal();
                } else {
                    $("#modal_them_lydobohoc").modal('hide');
                }
            }
        },

        data() {
            return {
                ma_lydo: '',
                ten_lydo: '',
                show_msg:false
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_lydobohoc).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_lydo: {
                            required: () => 'Mã lý do không thể trống',
                            max: () => 'Mã lý do không vượt quá 30 ký tự',
                            regex: () => 'Mã lý do chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        ten_lydo: {
                            required: () => 'Tên lý do không thể trống',
                        }
                    }
                };
                this.$validator.localize('vi', dict);
            },
            themLyDoBoHocSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.createNation();
                    }
                });
            },
            createNation() {
                console.log("Thêm lý do bỏ học");
                utils.confirmDialog("Xác nhận thêm lý do bỏ học", "Thêm", () => {
                    const uri = "/api_them_ly_do_bo_hoc";
                    const params = {
                        ma_lydo: this.ma_lydo,
                        ten_lydo: this.ten_lydo,
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm lý do bỏ học thành công", null, () => {
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
                this.ma_lydo = "";
                this.ten_lydo = "";
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


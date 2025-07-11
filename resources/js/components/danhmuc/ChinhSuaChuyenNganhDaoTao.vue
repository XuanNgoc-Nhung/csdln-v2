<template>

    <div id="modal_chinhsua_cndt" ref="modal_chinhsua_cndt" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="suaChuyenNganhDaoTaoSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa chuyên ngành đào tạo</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã chuyên ngành (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text"
                                           disabled
                                           v-model="ma_chuyennganh"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
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
                                    <span class="text-danger" v-show="errors.has('ten_chuyennganh')">{{ errors.first('ten_chuyennganh') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trạng thái</label>
                                </div>
                                <div class="col-sm-8">
                                    <select
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px"
                                        v-model="trangThai">
                                        <option value='1'>--Đang hoạt động--</option>
                                        <option value='0'>--Ngừng hoạt động--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                        </button>
                        <button type="submit" class="btn btn-primary">Sửa</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</template>
<script>

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
                    $("#modal_chinhsua_cndt").modal();
                } else {
                    $("#modal_chinhsua_cndt").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                console.log("abc");
                console.log(newVal.maCuaBo);

                this.trangThai = newVal.trangThai;
                this.ten_chuyennganh = newVal.tenCnganhDtao;
                this.ma_chuyennganh = newVal.maCnganhDtao;
            }
        },

        data() {
            return {
                trangThai: '',
                ten_chuyennganh: '',
                ma_chuyennganh: '',
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");

            $(this.$refs.modal_chinhsua_cndt).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ten_chuyennganh: {
                            required: () => 'Tên chuyên ngành không thể trống',
                        }
                    }
                };
                this.$validator.localize('vi', dict);
            },
            suaChuyenNganhDaoTaoSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.updateChuyenNganh();
                    }
                });
            },
            updateChuyenNganh() {
                console.log("Chỉnh sửa chuyên ngành đào tạo");
                utils.confirmDialog("Xác nhận chỉnh sửa chuyên ngành đào tạo", "Sửa", () => {
                    const uri = "/api_chinh_sua_chuyen_nganh_dao_tao";
                    const params = {
                        trangThai: this.trangThai,
                        ten_chuyennganh: this.ten_chuyennganh,
                        ma_chuyennganh: this.ma_chuyennganh,
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log(response.data);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa chuyên ngành đào tạo thành công", null, () => {
                                this.$emit('success', params);
                                this.reset();
                                this.close();

                                console.log("123:");
                                console.log(params);
                            });
                        } else {
                            utils.showDialog("Thất bại", response.data.message, null, () => {
                            });
                        }
                    });
                })
            },

            reset() {
            },

            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            },

        }

    }
</script>


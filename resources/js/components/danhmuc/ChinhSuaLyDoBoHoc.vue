<template>

    <div id="modal_chinhsua_lydobohoc" ref="modal_chinhsua_lydobohoc" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="suaLyDoBoHocSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa lý do bỏ học</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã lý do bỏ học (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text"
                                           disabled
                                           v-model="ma_lydo"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên lý do bỏ học (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true}" name="ten_lydo" type="text"
                                           min="0"
                                           v-model="ten_lydo"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span class="text-danger" v-show="errors.has('ten_lydo')">{{ errors.first('ten_lydo') }}</span>
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
                    $("#modal_chinhsua_lydobohoc").modal();
                } else {
                    $("#modal_chinhsua_lydobohoc").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                console.log("abc");
                console.log(newVal.maCuaBo);

                this.trangThai = newVal.trangThai;
                this.ten_lydo = newVal.tenLyDoBoHoc;
                this.ma_lydo = newVal.maLyDoBoHoc;
            }
        },

        data() {
            return {
                trangThai: '',
                ten_lydo: '',
                ma_lydo:'',
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_chinhsua_lydobohoc).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ten_lydo: {
                            required: () => 'Tên lý do không thể trống',
                        }
                    }
                };
                this.$validator.localize('vi', dict);
            },
            suaLyDoBoHocSubmit(){
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.updateLyDo();
                    }
                });
            },
            updateLyDo() {
                console.log("Chỉnh sửa chuyên ngành đào tạo");
                utils.confirmDialog("Xác nhận chỉnh sửa lý do bỏ học", "Sửa", () => {
                    const uri = "/api_chinh_sua_ly_do_bo_hoc";
                    const params = {
                        trangThai: this.trangThai,
                        ten_lydo: this.ten_lydo,
                        ma_lydo: this.ma_lydo,
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log( response.data);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa lý do bỏ học thành công", null, () => {
                                this.$emit('success', params);
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
            },

            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            },

        }

    }
</script>


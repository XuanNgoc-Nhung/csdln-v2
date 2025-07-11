<template>

    <div id="modal_chinhsua_dantoc" ref="modal_chinhsua_dantoc" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="suaDantocSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa dân tộc</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã dân tộc (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text"
                                           disabled
                                           v-model="nation_code"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
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
                                    <span class="text-danger" v-show="errors.has('nation_name')">{{ errors.first('nation_name') }}</span>
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
                                    <span class="text-danger" v-show="errors.has('nation_type')">{{ errors.first('nation_type') }}</span>
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
                                        v-model="nation_status">
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
                    $("#modal_chinhsua_dantoc").modal();
                } else {
                    $("#modal_chinhsua_dantoc").modal('hide');
                }
            },

            item: function (newVal, oldVal) {
                this.nation_name = newVal.tenDanToc;
                this.nation_code = newVal.maDanToc;
                this.nation_type = newVal.loaiDanToc;
                this.nation_status = newVal.trangThai;
            }
        },

        data() {
            return {
                nation_code: '',
                nation_name: '',
                nation_type:'',
                nation_status:'',
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_chinhsua_dantoc).on("hidden.bs.modal", this.close);
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
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
            suaDantocSubmit(){
                //this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.updateNation();
                    }
                });
            },
            updateNation() {
                utils.confirmDialog("Xác nhận chỉnh sửa dân tộc", "Sửa", () => {
                    const uri = "/api_chinh_sua_dan_toc";
                    const params = {
                        nation_code: this.nation_code,
                        nation_name: this.nation_name,
                        nation_type: this.nation_type,
                        nation_status: this.nation_status,
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log("ok nè");
                        console.log( response.data);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa dân tộc thành công", null, () => {
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


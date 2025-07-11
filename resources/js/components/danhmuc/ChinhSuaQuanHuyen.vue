<template>

    <div id="modal_chinhsua_quanhuyen" ref="modal_chinhsua_quanhuyen" class="modal fade">

        <div class="modal-dialog" style="width: 60%">

            <div class="modal-content">
                <form @submit.prevent="suaQuanHuyenSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa quận huyện</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã quận huyện (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text"
                                           disabled
                                           v-model="ma_quanhuyen"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trực thuộc tỉnh thành (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_tinhthanh"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px"
                                        v-model="ma_tinhthanh">
                                        <option value="">--Chọn tỉnh thành--</option>
                                        <option v-for="tinhthanh in list_tinhthanh" :value="tinhthanh.maTinhThanh">{{tinhthanh.tenTinhThanh}}</option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('ma_tinhthanh')">{{ errors.first('ma_tinhthanh') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên quận huyện (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true }" name="ten_quanhuyen" type="text"
                                           v-model="ten_quanhuyen"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span class="text-danger" v-show="errors.has('ten_quanhuyen')">{{ errors.first('ten_quanhuyen') }}</span>
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
                                        v-model="trangThai"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px">
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
                    $("#modal_chinhsua_quanhuyen").modal();
                } else {
                    $("#modal_chinhsua_quanhuyen").modal('hide');
                }
            },

            item: function (newVal, oldVal) {
                this.ma_tinhthanh = newVal.maTinhThanh;
                this.ten_quanhuyen = newVal.tenQuanHuyen;
                this.ma_quanhuyen = newVal.maQuanHuyen;
                this.trangThai = newVal.trangThai;
            }
        },

        data() {
            return {
                ma_tinhthanh: '',
                ten_quanhuyen: '',
                ma_quanhuyen: '',
                trangThai:"",
                list_tinhthanh:[],
            }
        },
        mounted: function () {
            this.LayDanhSachTinhThanh();
            $(this.$refs.modal_chinhsua_quanhuyen).on("hidden.bs.modal", this.close);
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_tinhthanh: {
                            required: () => 'Tỉnh thành không thể trống',
                        },
                        ten_quanhuyen: {
                            required: () => 'Tên quận huyện không thể trống'
                        },
                    }
                };
                this.$validator.localize('vi', dict);
            },
            suaQuanHuyenSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.updateNation();
                    }
                });
            },
            LayDanhSachTinhThanh() {
                console.log("lấy danh sách tỉnh thành");

                const uri = "/api_lay_danh_sach_tinh_thanh";
                let params = {
                    "start": '0',
                    "limit": '100',
                };
                api.get(uri, params, (respon) => {
                    console.log(respon);
                    this.list_tinhthanh = respon.data.rows;
                })
            },
            updateNation() {
                utils.confirmDialog("Xác nhận chỉnh sửa quận huyện", "Sửa", () => {
                    const uri = "/api_chinh_sua_quan_huyen";
                    const params = {
                        ma_tinhthanh: this.ma_tinhthanh,
                        ma_quanhuyen: this.ma_quanhuyen,
                        ten_quanhuyen: this.ten_quanhuyen,
                        trangThai: this.trangThai,
                    };
                    api.post(uri, params, (response) => {
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa quận huyện thành công", null, () => {
                                this.$emit('success', params);
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
            },

            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            },

        }

    }
</script>


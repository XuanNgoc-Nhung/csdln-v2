<template>

    <div id="modal_chinhsua_phuongxa" ref="modal_chinhsua_phuongxa" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="suaPhuongXaSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa quận Phường xã mới</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã phường xã (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text"
                                           disabled
                                           min="0"
                                           v-model="ma_phuongxa"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trực thuộc tỉnh (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_tinhthanh"
                                        @change="LayDanhSachQuanHuyen()"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px"
                                        v-model="ma_tinhthanh">
                                        <option value=''>--Chọn tỉnh thành--</option>
                                        <option v-for="tinhthanh in list_tinhthanh" :value="tinhthanh.maTinhThanh">
                                            {{tinhthanh.tenTinhThanh}}
                                        </option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('ma_tinhthanh')">{{ errors.first('ma_tinhthanh') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trực thuộc huyện (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_quanhuyen"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px"
                                        v-model="ma_quanhuyen">
                                        <option value=''>--Chọn quận huyện--</option>
                                        <option v-for="quanhuyen in list_quanhuyen" :value="quanhuyen.maQuanHuyen">
                                            {{quanhuyen.tenQuanHuyen}}
                                        </option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('ma_quanhuyen')">{{ errors.first('ma_quanhuyen') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên phường xã (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true }" name="ten_phuongxa" type="text"
                                           min="0"
                                           v-model="ten_phuongxa"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span class="text-danger" v-show="errors.has('ten_phuongxa')">{{ errors.first('ten_phuongxa') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Số lượng tổ</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text"
                                           min="0"
                                           v-model="soluong_to"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
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
                    $("#modal_chinhsua_phuongxa").modal();
                } else {
                    $("#modal_chinhsua_phuongxa").modal('hide');
                }
            },

            item: function (newVal, oldVal) {
                console.log("gán giá trị");
                console.log(newVal.maQuanHuyen +";"+ newVal.maTinhThanh);
                this.ma_tinhthanh = newVal.maTinhThanh;
                console.log("1111");
                console.log(this.ma_tinhthanh);
                this.ma_quanhuyen = newVal.maQuanHuyen;
                this.ma_phuongxa = newVal.maPhuongXa;
                this.ten_phuongxa = newVal.tenPhuongXa;
                this.trangThai = newVal.trangThai;
                this.soluong_to = newVal.slTo;
            }
        },

        data() {
            return {
                ma_quanhuyen: '',
                soluong_to: '',
                ten_quanhuyen: '',
                ma_tinhthanh: '',
                ma_phuongxa: '',
                ten_phuongxa: '',
                trangThai: '',
                list_tinhthanh: [],
                list_quanhuyen: [],
            }
        },
        mounted: function () {
            this.LayDanhSachTinhThanh();
            $(this.$refs.modal_chinhsua_phuongxa).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_tinhthanh: {
                            required: () => 'Tỉnh thành không thể trống',
                        },
                        ma_quanhuyen: {
                            required: () => 'Quận huyện không thể trống',
                        },
                        ten_phuongxa: {
                            required: () => 'Tên phường xã không thể trống'
                        },
                    }
                };
                this.$validator.localize('vi', dict);
            },
            suaPhuongXaSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.updatePhuongXa();
                    }
                });
            },
            LayDanhSachTinhThanh() {
                this.ma_quanhuyen= '';
                console.log("mqh :" +this.ma_quanhuyen);
                console.log("lấy danh sách tỉnh thành");

                const uri = "/api_lay_danh_sach_tinh_thanh";
                let params = {
                    "start": '0',
                    "limit": '1000',
                };
                api.get(uri, params, (respon) => {
                    console.log(respon);
                    this.list_tinhthanh = respon.data.rows;
                });
                this.LayDanhSachQuanHuyen();
            },
            LayDanhSachQuanHuyen() {
                console.log("lấy danh sách tỉnh thành");
                const uri = "/api_lay_danh_sach_quan_huyen";
                let params = {
                    "start": '0',
                    "limit": '999',
                    "ma_tinhthanh": this.ma_tinhthanh,
                };
                api.get(uri, params, (respon) => {
                    console.log("Lấy list quận huyện");
                    console.log(respon);
                    this.list_quanhuyen = respon.data.rows;
                });
                this.ma_quanhuyen='';
            },
            updatePhuongXa() {
                if (this.ma_quanhuyen == '') {
                    utils.showDialog("Thông báo", "Vui lòng chọn quận huyện");
                    return;
                }
                utils.confirmDialog("Xác nhận chỉnh sửa phường xã", "Sửa", () => {
                    const uri = "/api_chinh_sua_phuong_xa";
                    const params = {
                        ma_quanhuyen: this.ma_quanhuyen,
                        ma_phuongxa: this.ma_phuongxa,
                        ten_phuongxa: this.ten_phuongxa,
                        soluong_to: this.soluong_to,
                        trangThai: this.trangThai,
                    };
                    console.log("1111");
                    console.log(params);
                    api.post(uri, params, (response) => {
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa phường xã thành công", null, () => {
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
                this.ma_quanhuyen = '';
                this.ma_tinhthanh = '';
                this.ten_phuongxa = '';

            },
            reSetQuanHuyen(){
                console.log("reset quaajn huyeejn");
                this.ma_quanhuyen='';
            },

            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            },

        }

    }
</script>


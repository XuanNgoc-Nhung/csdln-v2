<template>

    <div id="modal_them_phuongxa" ref="modal_them_phuongxa" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="themPhuongXaSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm Phường xã mới</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trực thuộc tỉnh (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_tinhthanh"
                                        @change="onTinhThanhChange"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px"
                                        v-model="ma_tinhthanh">
                                        <option value=''>--Chọn tỉnh thành--</option>
                                        <option v-for="tinhthanh in list_tinhthanh" :value="tinhthanh.maTinhThanh">
                                            {{tinhthanh.tenTinhThanh}}
                                        </option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_tinhthanh')">{{ errors.first('ma_tinhthanh') }}</span></span>
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
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_quanhuyen')">{{ errors.first('ma_quanhuyen') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã phường xã (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="ma_phuongxa" type="text"
                                           min="0"
                                           v-model="ma_phuongxa"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_phuongxa')">{{ errors.first('ma_phuongxa') }}</span></span>
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
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_phuongxa')">{{ errors.first('ten_phuongxa') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Số lượng tổ</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="number"
                                           min="0"
                                           v-model="soluong_to"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
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
                    $("#modal_them_phuongxa").modal();
                } else {
                    $("#modal_them_phuongxa").modal('hide');
                }
            }
        },

        data() {
            return {
                ma_quanhuyen: '',
                ten_quanhuyen: '',
                ma_tinhthanh: '',
                soluong_to: '',
                ma_phuongxa: '',
                ten_phuongxa: '',
                list_tinhthanh: [],
                list_quanhuyen: [],
                show_msg: false
            }
        },
        mounted: function () {
            this.LayDanhSachTinhThanh();
            $(this.$refs.modal_them_phuongxa).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_donvi: {
                            required: () => 'Mã đơn vị không thể trống',
                            max: () => 'Mã đơn vị không vượt quá 30 ký tự',
                            regex: () => 'Mã đơn vị chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        ten_donvi: {
                            required: () => 'Tên đơn vị không thể trống'
                        },
                        loai_donvi: {
                            required: () => 'Loại đơn vị không thể trống'
                        },
                        donvi_quanly: {
                            required: () => 'Đơn vị quản lý không thể trống'
                        },
                        email_donvi: {
                            required: () => 'Email không thể trống',
                            email: () => 'Email không đúng định dạng'
                        },
                        sdt_donvi: {
                            required: () => 'Số điện thoại đơn vị không thể trống',
                            max: () => 'Số điện thoại đơn vị không vượt quá 10 ký tự',
                            regex: () => 'Số điện thoại không đúng định dạng'
                        },
                        diachi_donvi: {
                            required: () => 'Địa chỉ đơn vị không thể trống'
                        },
                        tinh_thanh: {
                            required: () => 'Tỉnh thành không thể trống'
                        },
                        quan_huyen: {
                            required: () => 'Quận huyện không thể trống'
                        },
                        xa_phuong: {
                            required: () => 'Xã phường không thể trống'
                        }
                    }
                };
                this.$validator.localize('vi', dict);
            },
            themPhuongXaSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.createPhuongXa();
                    }
                });
            },
            LayDanhSachTinhThanh() {
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
                //this.LayDanhSachQuanHuyen();
            },
            LayDanhSachQuanHuyen() {
                console.log("lấy danh sách tỉnh thành");
                const uri = "/api_lay_danh_sach_quan_huyen";
                let params = {
                    "start": '0',
                    "limit": '100',
                    "ma_tinhthanh": this.ma_tinhthanh,
                };
                api.get(uri, params, (respon) => {
                    console.log("Lấy list quận huyện");
                    console.log(respon);
                    this.list_quanhuyen = respon.data.rows;
                })
            },
            createPhuongXa() {
                if (this.ma_quanhuyen == '') {
                    utils.showDialog("Thông báo", "Vui lòng chọn quận huyện");
                    return;
                }
                utils.confirmDialog("Xác nhận thêm phường xã", "Thêm", () => {
                    const uri = "/api_them_xa_phuong";
                    const params = {
                        ma_quanhuyen: this.ma_quanhuyen,
                        ma_phuongxa: this.ma_phuongxa,
                        ten_phuongxa: this.ten_phuongxa,
                        soluong_to: this.soluong_to,
                    };
                    api.post(uri, params, (response) => {
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm xã phường thành công", null, () => {
                                this.$emit('success', params);
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
            onTinhThanhChange() {
                if (this.ma_tinhthanh === "") {
                    this.ds_quan_huyen = [];
                    this.ma_quanhuyen = '';
                    return;
                }
                this.ma_quanhuyen = "";
                this.LayDanhSachQuanHuyen();
            },
            reset() {
                this.ma_quanhuyen = "";
                this.ma_phuongxa = "";
                this.ten_phuongxa = "";
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


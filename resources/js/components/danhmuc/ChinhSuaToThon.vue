<template>

    <div id="modal_chinhsua_tothon" ref="modal_chinhsua_tothon" class="modal fade">

        <div class="modal-dialog" style="width: 40%;">

            <div class="modal-content">
                <form @submit.prevent="suaToThonSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa tổ thôn</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trực thuộc tỉnh (<span
                                            style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_tinhthanh"
                                        @change="onTinhThanhChange()"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px" v-model="ma_tinhthanh">
                                        <option value=''>--Chọn tỉnh thành--</option>
                                        <option v-for="tinhthanh in list_tinhthanh" :value="tinhthanh.maTinhThanh">
                                            {{tinhthanh.tenTinhThanh}}
                                        </option>
                                    </select>
                                    <span class="text-danger"
                                        v-show="errors.has('ma_tinhthanh')">{{ errors.first('ma_tinhthanh') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trực thuộc huyện (<span
                                            style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_quanhuyen"
                                        @change="onQuanHuyenChange()"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px" v-model="ma_quanhuyen">
                                        <option value=''>--Chọn quận huyện--</option>
                                        <option v-for="quanhuyen in list_quanhuyen" :value="quanhuyen.maQuanHuyen">
                                            {{quanhuyen.tenQuanHuyen}}
                                        </option>
                                    </select>
                                    <span class="text-danger"
                                        v-show="errors.has('ma_quanhuyen')">{{ errors.first('ma_quanhuyen') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trực thuộc xã, phường (<span
                                            style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_phuongxa"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px" v-model="ma_phuongxa">
                                        <option value=''>--Chọn phường xã--</option>
                                        <option v-for="px in list_phuongxa" :value="px.maPhuongXa">
                                            {{px.tenPhuongXa}}
                                        </option>
                                    </select>
                                    <span class="text-danger"
                                        v-show="errors.has('ma_phuongxa')">{{ errors.first('ma_phuongxa') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã tổ thôn (<span
                                            style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled type="text" min="0" v-model="ma_tothon" placeholder="Nhập..."
                                        class="form-control control-inline" style="min-width: 50px; max-width: 250px" />
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên tổ thôn (<span
                                            style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true }" name="ten_tothon" type="text" min="0"
                                        v-model="ten_tothon" placeholder="Nhập..." class="form-control control-inline"
                                        style="min-width: 50px; max-width: 250px" />
                                    <span class="text-danger"
                                        v-show="errors.has('ten_tothon')">{{ errors.first('ten_tothon') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trạng thái</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-model="trangThai"
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
                        <button type="submit" class="btn btn-primary">Sửa
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
    import VeeValidate, {
        Validator
    } from 'vee-validate';
    //Validator.localize('vi', vi);
    Vue.use(VeeValidate);

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: ['item', 'show'],


        watch: {
            show: function (newVal, oldVal) {
                if (newVal) {
                    this.reset();
                    $("#modal_chinhsua_tothon").modal();
                } else {
                    $("#modal_chinhsua_tothon").modal('hide');
                }
            },

            item: function (newVal, oldVal) {
                console.log("gán:" + JSON.stringify(newVal));
                this.ma_tothon = newVal.maToThon;
                this.ten_tothon = newVal.tenToThon;
                this.ma_tinhthanh = newVal.maTinhthanh;
                this.ma_quanhuyen = newVal.maQuanHuyen;
                this.ma_phuongxa = newVal.maPhuongXa;
                this.trangThai = newVal.trangThai;
                this.LayDanhSachQuanHuyen();
                this.LayDanhSachPhuongXa();
            }
        },

        data() {
            return {
                list_tinhthanh: [],
                list_phuongxa: [],
                list_quanhuyen: [],
                ma_tothon: '',
                ten_tothon: '',
                ma_phuongxa: '',
                ma_tinhthanh: '',
                ma_quanhuyen: '',
                trangThai: '',
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            this.LayDanhSachTinhThanh();
            this.LayDanhSachPhuongXa();
            $(this.$refs.modal_chinhsua_tothon).on("hidden.bs.modal", this.close);
        },

        methods: {
            customMessage() {
                const dict = {
                    custom: {
                        ma_tinhthanh: {
                            required: () => 'Tỉnh thành không thể trống',
                        },
                        ma_quanhuyen: {
                            required: () => 'Quận Huyện không thể trống',
                        },
                        ma_phuongxa: {
                            required: () => 'Phường Xã không thể trống',
                        },
                        ma_tothon: {
                            required: () => 'Mã tổ thôn không thể trống',
                            max: () => 'Mã tổ thôn không vượt quá 30 ký tự',
                            regex: () => 'Mã tổ thôn chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        ten_tothon: {
                            required: () => 'Tên tổ thôn không thể trống'
                        },
                    }
                };
                this.$validator.localize('vi', dict);
            },
            suaToThonSubmit() {
                //this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result) {
                        this.UpdateToThon();
                    }
                });
            },
            LayDanhSachTinhThanh() {
                console.log("lấy danh sách tỉnh thành");
                console.log(this.ma_tinhthanh);

                const uri = "/api_lay_danh_sach_tinh_thanh";
                let params = {
                    "start": '0',
                    "limit": '1000',
                    "ma_tinhthanh": this.ma_tinhthanh,

                };
                api.get(uri, params, (respon) => {
                    console.log(respon);
                    this.list_tinhthanh = respon.data.rows;
                });
                this.LayDanhSachQuanHuyen();
                this.ma_quanhuyen = '';
            },
            LayDanhSachQuanHuyen() {
                console.log("lấy danh sách tỉnh thành");
                const uri = "/api_lay_danh_sach_quan_huyen";
                let params = {
                    "start": '0',
                    "limit": '100',
                    "ma_tinhthanh": this.ma_tinhthanh,
                };
                console.log("lấy qh: 123:" + params);
                api.get(uri, params, (respon) => {
                    console.log("Lấy list quận huyện");
                    console.log(respon);
                    this.list_quanhuyen = respon.data.rows;
                });
                this.LayDanhSachPhuongXa();
                console.log("iiiiiiii");
                console.log(this.ma_quanhuyen);
            },
            LayDanhSachPhuongXa() {
                console.log("lấy danh sách xã phường");
                const uri = "/api_lay_danh_sach_xa_phuong";
                let params = {
                    "start": 0,
                    "limit": 999,
                    "ma_quanhuyen": this.ma_quanhuyen,
                };
                api.get(uri, params, (respon) => {
                    console.log("hihiahihi");
                    console.log(respon);
                    this.list_phuongxa = respon.data.rows;
                });

            },
            UpdateToThon() {
                console.log("Thêm tổ thôn");

                const uri = "/api_chinh_sua_to_thon";
                const params = {
                    ma_tothon: this.ma_tothon,
                    ten_tothon: this.ten_tothon,
                    ma_phuongxa: this.ma_phuongxa,
                    trangThai: this.trangThai,
                };
                api.post(uri, params, (response) => {
                    console.log(response);
                    if (response.data.code === 200) {
                        utils.showDialog("Thông báo", "Chỉnh sửa tổ thôn thành công", null, () => {
                            this.$emit('success', params);
                            this.reset();
                            this.close();
                        });
                    } else {
                        utils.showDialog("Thất bại", response.data.message, null, () => {});
                    }
                });
                // utils.confirmDialog("Xác nhận chỉnh sửa tổ thôn", "Sửa", () => {})
            },

            reset() {
                this.ma_tothon = "";
                this.ten_tothon = "";
                this.ma_phuongxa = "";
            },
            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            },
            onTinhThanhChange() {
                if (this.list_tinhthanh === "") {
                    return;
                }
                this.ma_quanhuyen = "";
                this.ma_phuongxa = "";
                this.LayDanhSachQuanHuyen();
            },
            onQuanHuyenChange() {
                if (this.list_quanhuyen === "") {
                    return;
                }
                this.ma_phuongxa = "";
                this.LayDanhSachPhuongXa();
            }

        }

    }

</script>

<template>

    <div id="modal_them_tothon" ref="modal_them_tothon" class="modal fade">

        <div class="modal-dialog" style="width: 40%;">

            <div class="modal-content">
                <form @submit.prevent="themToThonSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm tổ thôn mới</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Trực thuộc tỉnh (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_tinhthanh" @change="onTinhThanhChange" class="form-control" v-model="ma_tinhthanh" title="Chọn tỉnh thành" style="min-width: 50px; max-width: 250px">
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
                                        @change="onQuanHuyenChange()"
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
                                    <label class="pull-right" style="line-height: 34px;">Trực thuộc xã, phường (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_phuongxa"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px"
                                        v-model="ma_phuongxa">
                                        <option value=''>--Chọn phường xã--</option>
                                        <option v-for="px in list_phuongxa" :value="px.maPhuongXa">
                                            {{px.tenPhuongXa}}
                                        </option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_phuongxa')">{{ errors.first('ma_phuongxa') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã tổ thôn (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="ma_tothon" type="text"
                                           min="0"
                                           v-model="ma_tothon"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_tothon')">{{ errors.first('ma_tothon') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên tổ thôn (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true }" name="ten_tothon" type="text"
                                           min="0"
                                           v-model="ten_tothon"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_tothon')">{{ errors.first('ten_tothon') }}</span></span>
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

    import utils from '../../utils';
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
                    $("#modal_them_tothon").modal();
                } else {
                    $("#modal_them_tothon").modal('hide');
                }
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
                show_msg:false
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            this.LayDanhSachTinhThanh();
            $(this.$refs.modal_them_tothon).on("hidden.bs.modal", this.close);
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
            themToThonSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.createToThon();
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
            },
            getQuanHuyen() {
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
                });
            },
            getPhuongXa() {
                console.log("lấy danh sách xã phường");
                const uri = "/api_lay_danh_sach_xa_phuong";
                let params = {
                    "start": 0,
                    "limit": 999,
                    "ma_quanhuyen": this.ma_quanhuyen,
                };
                api.get(uri, params, (respon) => {
                    this.list_phuongxa = respon.data.rows;
                });

            },
            createToThon() {
                if(this.ma_phuongxa == ''||this.ten_tothon==''||this.ma_tothon==''){
                    utils.showDialog("Thông báo","Vui lòng kiểm tra lại dữ liệu!");
                    return;
                }
                utils.confirmDialog("Xác nhận thêm tổ thôn", "Thêm", () => {
                    const uri = "/api_them_to_thon";
                    const params = {
                        ma_tothon: this.ma_tothon,
                        ten_tothon: this.ten_tothon,
                        ma_phuongxa: this.ma_phuongxa,
                    };
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm tổ thôn thành công", null, () => {
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
                this.ma_tothon = "";
                this.ten_tothon = "";
                this.ma_phuongxa = "";
                this.ma_tinhthanh = "";
                this.ma_quanhuyen = "";
                this.ds_quan_huyen = [];
                this.ds_phuong_xa = [];
            },
            close() {
                console.log("close modal");
                this.show_msg = false;
                this.reset();
                this.$emit('close');
            },
            onTinhThanhChange(){
                if (this.ma_tinhthanh === "") {
                    this.ds_quan_huyen = [];
                    this.ma_quanhuyen = "";
                    this.ds_phuong_xa = [];
                    this.ma_phuongxa = "";
                    return;
                }
                this.ma_quanhuyen = "";
                this.ma_phuongxa = "";
                this.getQuanHuyen();
            },
            onQuanHuyenChange(){
                if (this.ma_quanhuyen === "") {
                    this.ds_phuong_xa = [];
                    this.ma_phuongxa = "";
                    return;
                }
                this.ma_phuongxa = "";
                this.getPhuongXa();
            }
        }

    }
</script>


<template>

    <div id="modal_them_donvi" ref="modal_them_donvi" class="modal fade">

        <div class="modal-dialog" style="width: 70%">

            <div class="modal-content">
                <form @submit.prevent="themDonViSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm đơn vị mới</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Mã đơn vị (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="ma_donvi" type="text"
                                           min="0"
                                           v-model="ma_donvi"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_donvi')">{{ errors.first('ma_donvi') }}</span></span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Tên đơn vị (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ required: true }" name="ten_donvi" type="text"
                                           min="0"
                                           v-model="ten_donvi"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_donvi')">{{ errors.first('ten_donvi') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Loại đơn vị (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <select @change="loaiDonViChange" v-validate="{ required: true}" name="loai_donvi"
                                        v-model="loai_donvi"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value=''>Chọn loại đơn vị</option>
                                        <option value='1'>Sở</option>
                                        <option value='2'>Phòng</option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('loai_donvi')">{{ errors.first('loai_donvi') }}</span></span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Đơn vị quản lý (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ required: true}" name="donvi_quanly" type="text"
                                           placeholder="Nhập..."
                                           v-model="donvi_quanly"
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('donvi_quanly')">{{ errors.first('donvi_quanly') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div v-if="loai_donvi == 2" style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Đơn vị cha (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <span dat="1" :test="is_validate_don_vi_cha"></span>
                                    <select v-validate="{ required: is_validate_don_vi_cha}" name="don_vi_cha"
                                            v-model="don_vi_cha"
                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                            style="width:100%">
                                        <option value="">Chọn đơn vị cha</option>
                                        <option v-for="dv in list_so" :value="dv.maDonVi">
                                            {{dv.tenDonVi}}
                                        </option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('don_vi_cha')">{{ errors.first('don_vi_cha') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Email đơn vị (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ required: true, email : true}" name="email_donvi" type="text"
                                           min="0"
                                           v-model="email_donvi"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('email_donvi')">{{ errors.first('email_donvi') }}</span></span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">SĐT đơn vị (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ required: true, max:10, regex: /0[0-9]{9}/}" name="sdt_donvi" type="text"
                                           min="0"
                                           v-model="sdt_donvi"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('sdt_donvi')">{{ errors.first('sdt_donvi') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Website đơn vị</label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text"
                                           min="0"
                                           v-model="website_donvi"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Địa chỉ đơn vị (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ required: true}" name="diachi_donvi" type="text"
                                           min="0"
                                           v-model="diachi_donvi"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('diachi_donvi')">{{ errors.first('diachi_donvi') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Tỉnh thành (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <select v-validate="{ required: true}" name="tinh_thanh"
                                        v-model="ma_tinh_thanh" @change="onTinhThanhChange"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn tỉnh thành--</option>
                                        <option v-for="tt in list_tinh_thanh" :value="tt.maTinhThanh">{{tt.tenTinhThanh}}</option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('tinh_thanh')">{{ errors.first('tinh_thanh') }}</span></span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Quận huyện (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <select v-validate="{ required: true}" name="quan_huyen"
                                        v-model="ma_quan_huyen" @change="onQuanHuyenChange"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value=''>--Chọn quận huyện--</option>
                                        <option v-for="qh in list_quan_huyen" :value='qh.maQuanHuyen'>{{qh.tenQuanHuyen}}</option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('quan_huyen')">{{ errors.first('quan_huyen') }}</span></span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Xã phường (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <select v-validate="{ required: true}" name="xa_phuong"
                                        v-model="ma_phuong_xa" @change="onPhuongXaChange"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value=''>--Chọn--</option>
                                        <option v-for="px in list_phuong_xa" :value='px.maPhuongXa'>{{px.tenPhuongXa}}</option>
                                    </select>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('xa_phuong')">{{ errors.first('xa_phuong') }}</span></span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Tổ thôn</label>
                                </div>
                                <div class="col-sm-4">
                                    <select
                                        v-model="ma_to_thon"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value=''>--Chọn--</option>
                                        <option v-for="tt in list_to_thon" :value='tt.maToThon'>{{tt.tenToThon}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                        </button>
                        <!--<button type="button" class="btn btn-primary" v-on:click.prevent="themDonVi">Thêm-->
                        <!--</button>-->

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
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import timeutils from '../../utils/time_utils';
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
                    //this.reset();
                    $("#modal_them_donvi").modal();
                } else {
                    $("#modal_them_donvi").modal('hide');
                }
            }
        },

        data() {
            return {
                list_tinh_thanh:[],
                list_quan_huyen:[],
                list_phuong_xa:[],
                list_to_thon:[],
                list_so: [],
                ma_donvi:'',
                ten_donvi:'',
                loai_donvi:'',
                email_donvi:'',
                sdt_donvi:'',
                website_donvi:'',
                diachi_donvi:'',
                donvi_quanly:'',
                ma_tinh_thanh:'',
                ma_quan_huyen:'',
                ma_phuong_xa:'',
                ma_to_thon:'',
                don_vi_cha:'',
                show_msg: false,
                is_validate_don_vi_cha: false
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_donvi).on("hidden.bs.modal", this.close);
            this.getTinhThanh();
            this.getDanhSachSo();
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
                        don_vi_cha: {
                            required: () => 'Đơn vị cha không thể trống'
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
            themDonViSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.themDonVi();
                    }
                });
            },
            themDonVi() {
                if(this.loai_donvi == 2){
                    if(this.don_vi_cha != this.ma_tinh_thanh){
                        utils.showDialog('Thông báo','Đơn vị cha và tỉnh thành không trùng khớp');
                        return;
                    }
                }
                utils.confirmDialog("Xác nhận thêm đơn vị", "Thêm", () => {
                    const uri = "/api_them_don_vi";
                    const params = {
                        ma_donvi: this.ma_donvi,
                        ten_donvi: this.ten_donvi,
                        loai_donvi: this.loai_donvi,
                        donvi_quanly: this.donvi_quanly,
                        email_donvi: this.email_donvi,
                        sdt_donvi: this.sdt_donvi,
                        website_donvi: this.website_donvi,
                        diachi_donvi: this.diachi_donvi,
                        ma_tinh_thanh: this.ma_tinh_thanh,
                        ma_quan_huyen: this.ma_quan_huyen,
                        ma_phuong_xa: this.ma_phuong_xa,
                        ma_to_thon: this.ma_to_thon,
                        don_vi_cha:this.don_vi_cha
                    };
                    console.log("thêm đơn vị:"+JSON.stringify(params));
                    api.post(uri, params, (response) => {
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm đơn vị thành công", null, () => {
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
                //this.list_tinh_thanh = [],
                this.list_quan_huyen = [],
                this.list_phuong_xa = [],
                this.list_to_thon = [],
                this.ma_donvi = '',
                this.ten_donvi = '',
                this.loai_donvi = '',
                this.email_donvi = '',
                this.sdt_donvi= '',
                this.website_donvi='',
                this.diachi_donvi = '',
                this.donvi_quanly = '',
                this.ma_tinh_thanh = '',
                this.ma_quan_huyen = '',
                this.ma_phuong_xa = '',
                this.ma_to_thon  = ''
            },
            close() {
                console.log("close modal");
                this.reset();
                this.show_msg = false;
                this.$emit('close');
            },
            loaiDonViChange(){
                if(this.loai_donvi == 2){
                    this.is_validate_don_vi_cha = true;
                }else{
                    this.is_validate_don_vi_cha = false;
                }
                console.log(this.is_validate_don_vi_cha);
            },

            onTinhThanhChange() {
                console.log("thay đổi tỉnh thành");
                if (this.ma_tinh_thanh === '') {
                    this.ma_quan_huyen = '';
                    this.ma_phuong_xa = '';
                    this.ma_to_thon = '';
                    this.list_quan_huyen = [];
                    this.list_phuong_xa = [];
                    this.list_to_thon = [];
                }else{
                    this.getQuanHuyen();
                }
            },
            onQuanHuyenChange() {
                console.log("thay đổi quận huyện");
                if (this.ma_quan_huyen === '') {
                    this.ma_phuong_xa = '';
                    this.ma_to_thon = '';
                    this.list_phuong_xa = [];
                    this.list_to_thon = [];
                }else{
                    this.getPhuongXa();
                }
            },
            onPhuongXaChange() {
                console.log("thay đổi phường");
                if (this.ma_phuong_xa === '') {
                    this.ma_to_thon = '';
                    this.list_to_thon = [];
                }else{
                    this.getToThon();
                }
            },
            getTinhThanh() {
                console.log("Lấy danh sách tỉnh thành");
                let params = {
                    "start": 0,
                    "limit": 100,
                };
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.list_tinh_thanh = data.data.rows;
                    }
                });

            },
            getQuanHuyen() {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maTinhThanh": this.ma_tinh_thanh,
                };
                console.log("lấy ds quận huyện:" + JSON.stringify(params));
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.list_quan_huyen = data.data.rows;
                    }
                });
            },
            getPhuongXa() {
                console.log("lấy px của : "+ this.ma_quan_huyen)
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maQuanHuyen": this.ma_quan_huyen,
                };
                rest_api.get("/internal-api/dmPhuongXa/filter", params, (data) => {
                    console.log("11111111111111");
                    console.log(JSON.stringify(params));
                    if (array_util.isArray(data.data.rows)) {
                        this.list_phuong_xa = data.data.rows;
                    }
                });
            },
            getToThon() {
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maPhuongXa": this.ma_phuong_xa,
                };
                console.log("lấy ds tổ thôn:" + JSON.stringify(params));
                rest_api.get("/internal-api/dmToThon/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.list_to_thon = data.data.rows;
                    }
                });
            },
            getDanhSachSo() {
                let params = {
                    "start": 0,
                    "limit": 1000,
                    "loaiDonVi": 1
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_so);
                        this.list_so = data.data.rows;
                    }
                });
            },

        }

    }
</script>


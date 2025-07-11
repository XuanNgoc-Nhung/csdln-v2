<template>
    <div id="modal_update_donvi" ref="modal_update_donvi" class="modal fade">

        <div class="modal-dialog" style="width: 70%">

            <div class="modal-content">
                <form @submit.prevent="suaDonViSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa đơn vị</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Mã đơn vị (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input disabled v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_.-]*$/ }" name="ma_donvi" type="text"
                                           min="0"
                                           v-model="ma_donvi"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('ma_donvi')">{{ errors.first('ma_donvi') }}</span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Tên đơn vị (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ required: true}" type="text"
                                           name="ten_donvi"
                                           min="0"
                                           v-model="ten_donvi"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('ten_donvi')">{{ errors.first('ten_donvi') }}</span>
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
                                        <option value=''>--Chọn--</option>
                                        <option value="1">Sở</option>
                                        <option value="2">Phòng</option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('loai_donvi')">{{ errors.first('loai_donvi') }}</span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Đơn vị quản lý (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ required: true}" name="donvi_quanly" type="text"
                                           min="0"
                                           v-model="donvi_quanly"
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('donvi_quanly')">{{ errors.first('donvi_quanly') }}</span>
                                </div>
                            </div>
                        </div>
                        <div v-if="loai_donvi == 2" style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Đơn vị cha (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <select v-validate="{ required: is_validate_don_vi_cha}" name="don_vi_cha"
                                            v-model="don_vi_cha"
                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                            style="width:100%">
                                        <option value="">Chọn đơn vị cha</option>
                                        <option v-for="dv in list_so" :value="dv.maDonVi">
                                            {{dv.tenDonVi}}
                                        </option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('don_vi_cha')">{{ errors.first('don_vi_cha') }}</span>
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
                                    <span class="text-danger" v-show="errors.has('email_donvi')">{{ errors.first('email_donvi') }}</span>
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
                                    <span class="text-danger" v-show="errors.has('sdt_donvi')">{{ errors.first('sdt_donvi') }}</span>
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
                                    <span class="text-danger" v-show="errors.has('diachi_donvi')">{{ errors.first('diachi_donvi') }}</span>
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
                                        v-model="tinh_thanh"
                                        @change="LayDanhSachQuanHuyen()"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn tỉnh thành--</option>
                                        <option v-for="tt in list_tinhthanh" :value="tt.maTinhThanh">{{tt.tenTinhThanh}}</option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('tinh_thanh')">{{ errors.first('tinh_thanh') }}</span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Quận huyện (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <select v-validate="{ required: true}" name="quan_huyen"
                                        v-model="quan_huyen"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn quận huyện--</option>
                                        <option v-for="qh in list_quanhuyen" :value='qh.maQuanHuyen'>{{qh.tenQuanHuyen}}</option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('quan_huyen')">{{ errors.first('quan_huyen') }}</span>
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
                                        v-model="xa_phuong"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value="">--Chọn Xã phường--</option>
                                        <option v-for="px in list_phuongxa" :value='px.maPhuongXa'>{{px.tenPhuongXa}}</option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('xa_phuong')">{{ errors.first('xa_phuong') }}</span>
                                </div>
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Tổ thôn</label>
                                </div>
                                <div class="col-sm-4">
                                    <select
                                        v-model="to_thon"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="width:100%">
                                        <option value=''>--Chọn Tổ thôn--</option>
                                        <option v-for="tt in list_tothon" :value='tt.maToThon'>{{tt.tenToThon}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2">
                                    <label class="pull-right" style="line-height: 34px;">Trạng thái</label>
                                </div>
                                <div class="col-sm-4">
                                    <select v-validate="{ required: true}" name="trang_thai"
                                            v-model="trang_thai"
                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                            style="width:100%">
                                        <option value=''>--Chọn--</option>
                                        <option value='1'>Đang hoạt động</option>
                                        <option value='0'>Ngừng hoạt động</option>
                                    </select>

                                    <span class="text-danger" v-show="errors.has('trang_thai')">{{ errors.first('trang_thai') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                        </button>
                        <!--<button type="button" class="btn btn-primary" v-on:click="suaDonVi">Sửa-->
                        <!--</button>-->
                        <button type="submit" class="btn btn-warning">Sửa
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
                    $("#modal_update_donvi").modal();
                } else {
                    $("#modal_update_donvi").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                console.log("newVal = " + JSON.stringify(newVal));
                this.bindData(newVal);
                //this.ma_donvi = newVal.maDonVi;
            },
            tinh_thanh: function (newVal, oldVal) {
                this.LayDanhSachQuanHuyen();
            },
            quan_huyen: function (newVal, oldVal) {
                this.LayDanhSachPhuongXa();
                this.xa_phuong = this.item.maPhuongXa;
            },
            xa_phuong: function (newVal, oldVal) {
                this.LayDanhSachToThon();
                this.to_thon = this.item.maToThon;
            }
        },

        data() {
            return {
                list_tinhthanh:[],
                list_quanhuyen:[],
                list_phuongxa:[],
                list_tothon:[],
                ma_donvi: '',
                ten_donvi: '',
                loai_donvi: '',
                donvi_quanly:'',
                email_donvi:'',
                sdt_donvi:'',
                website_donvi:'',
                diachi_donvi:'',
                tinh_thanh:'',
                quan_huyen:'',
                xa_phuong:'',
                to_thon:'',
                trang_thai:1,
                don_vi_cha:'',
                is_validate_don_vi_cha:false

            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_update_donvi).on("hidden.bs.modal", this.close);
            this.LayDanhSachTinhThanh();
            this.getDanhSachSo();
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_donvi: {
                            required: () => 'Mã đơn vị không thể trống',
                            max: () => 'Tên đơn vị không vượt quá 30 ký tự',
                            regex: () => 'Tên đơn vị chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
                        ten_donvi: {
                            required: () => 'Tên đơn vị không thể trống'
                        },
                        don_vi_cha: {
                            required: () => 'Đơn vị cha không thể trống'
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
                        },
                        trang_thai: {
                            required: () => 'Trạng thái không thể trống'
                        },
                    }
                };
                this.$validator.localize('vi', dict);
            },
            suaDonViSubmit(){
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.suaDonVi();
                    }
                });
            },
            suaDonVi() {
                if(this.loai_donvi == 2){
                    if(this.don_vi_cha != this.tinh_thanh){
                        utils.showDialog('Thông báo','Đơn vị cha và tỉnh thành không trùng khớp');
                        return;
                    }
                }
                utils.confirmDialog("Xác nhận chỉnh sửa đơn vị", "Sửa", () => {
                    const uri = "/api_chinh_sua_don_vi";
                    const params = {
                        address: this.diachi_donvi,
                        donViQuanLy: this.donvi_quanly,
                        email: this.email_donvi,
                        loaiDonVi: this.loai_donvi,
                        ma: this.ma_donvi,
                        maDonViCha: this.don_vi_cha,
                        maPhuongXa: this.xa_phuong,
                        maQuanHuyen: this.quan_huyen,
                        maTinhThanh: this.tinh_thanh,
                        maToThon: this.to_thon,
                        soDienThoai: this.sdt_donvi,
                        ten: this.ten_donvi,
                        website: this.website_donvi,
                        trangThai: this.trang_thai,
                    };
                    console.log('pram sua' + JSON.stringify(params));
                    api.post(uri, params, (response) => {
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa thành công", null, () => {
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
                this.ma_tongiao = "";
                this.ma_cuabo = "";
                this.ten_tongiao = "";
            },
            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            },
            bindData(item){
                this.ma_donvi = item.maDonVi;
                this.ten_donvi = item.tenDonVi;
                this.loai_donvi = item.loaiDonVi;
                this.donvi_quanly = item.donViQuanLy;
                this.email_donvi = item.email;
                this.sdt_donvi = item.sdt;
                this.website_donvi = item.website;
                this.diachi_donvi = item.address;
                this.to_thon = item.maToThon;
                this.tinh_thanh = item.maTinhThanh;
                this.quan_huyen = item.maQuanHuyen;
                this.trang_thai = item.trangThai;
                this.don_vi_cha = item.maDonViCha;
            },
            LayDanhSachTinhThanh() {
                console.log("lấy danh sách tỉnh thành");
                const uri = "/api_lay_danh_sach_tinh_thanh";
                let params = {
                    "start":0,
                    "limit":9999,
                };
                api.get(uri, params, (respon) => {
                    console.log(respon);
                    this.list_tinhthanh = respon.data.rows;
                })
            },

            LayDanhSachQuanHuyen() {
                if(this.tinh_thanh == ''){
                    this.list_quanhuyen = [];
                    this.list_phuongxa = [];
                    this.list_tothon = [];
                    this.quan_huyen = '';
                    this.xa_phuong = '';
                    this.to_thon = '';
                }else{
                    const uri = "/api_lay_danh_sach_quan_huyen";
                    let params = {
                        "start": 0,
                        "limit": 999,
                        "ma_tinhthanh": this.tinh_thanh,
                    };
                    api.get(uri, params, (respon) => {
                        this.list_quanhuyen = respon.data.rows;
                    })
                }
            },
            LayDanhSachPhuongXa() {
                if(this.quan_huyen == ''){
                    this.list_phuongxa = [];
                    this.list_tothon = [];
                    this.xa_phuong = '';
                    this.to_thon = '';
                }else{
                    let params = {
                        "start": 0,
                        "limit": 1000,
                        "maQuanHuyen": this.quan_huyen
                    };
                    rest_api.get("/internal-api/dmPhuongXa/filter", params, (data) => {
                        if (array_util.isArray(data.data.rows)) {
                            this.list_phuongxa = data.data.rows;
                            console.log(JSON.stringify(data));
                        }
                    });
                }
            },
            LayDanhSachToThon() {
                if(this.xa_phuong == ''){
                    this.list_tothon = [];
                    this.to_thon == '';
                }else{
                    let params = {
                        "start": 0,
                        "limit": 1000,
                        "maPhuongXa": this.xa_phuong
                    };
                    rest_api.get("/internal-api/dmToThon/filter", params, (data) => {

                        if (array_util.isArray(data.data.rows)) {
                            this.list_tothon = data.data.rows;
                        }
                    });
                }
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
            loaiDonViChange(){
                if(this.loai_donvi == 2){
                    this.is_validate_don_vi_cha = true;
                }else{
                    this.is_validate_don_vi_cha = false;
                }
                console.log(this.is_validate_don_vi_cha);
            },

        }

    }
</script>


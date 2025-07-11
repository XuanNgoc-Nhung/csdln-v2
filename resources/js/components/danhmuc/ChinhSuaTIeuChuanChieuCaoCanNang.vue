<template>

    <div id="modal_chinhsua_tieu_chuan" ref="modal_chinhsua_tieu_chuan" class="modal fade">

        <div class="modal-dialog" style="width:50%">

            <div class="modal-content">
                <form @submit.prevent="suaChuanChieuCaoCanNangSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa chuẩn chiều cao, cân nặng</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2 text-right">
                                    <label>Mã tiêu chuẩn (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input disabled type="text"
                                           min="0"
                                           disabled
                                           v-model="ma_tieuchuan"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <label>Loại tiêu chuẩn (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <select v-validate="{ required: true}" name="loai_tieuchuan" class="form-control" v-model="loai_tieuchuan">
                                        <option value=''>Chọn loại tiêu chuẩn</option>
                                        <option value='1'>Chiều cao bé trai</option>
                                        <option value='2'>Cân nặng bé trai</option>
                                        <option value='3'>Chiều cao bé gái</option>
                                        <option value='4'>Cân nặng bé gái</option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('loai_tieuchuan')">{{ errors.first('loai_tieuchuan') }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2 text-right">
                                    <label >Số Tháng (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ required: true, regex: /^[0-9]*$/}" name="thang" type="text"
                                           min="1"
                                           v-model="thang"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('thang')">{{ errors.first('thang') }}</span>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <label>Trung bình (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ required: true, regex: /^[0-9]*$/}" name="standard0" type="text"
                                           min="0"
                                           v-model="standard0"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('standard0')">{{ errors.first('standard0') }}</span>
                                </div>

                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2 text-right">
                                    <label>Thiếu chuẩn 1</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ regex: /^[0-9]*$/}" name="standard1" type="text"
                                           min="0"
                                           v-model="standard1"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('standard1')">{{ errors.first('standard1') }}</span>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <label>Vượt chuẩn 1</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ regex: /^[0-9]*$/}" name="standardSub1" type="text"
                                           min="0"
                                           v-model="standardSub1"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('standardSub1')">{{ errors.first('standardSub1') }}</span>
                                </div>
                            </div>
                        </div>


                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2 text-right">
                                    <label>Thiếu chuẩn 2</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ regex: /^[0-9]*$/}" name="standard2" type="text"
                                           min="0"
                                           v-model="standard2"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('standard2')">{{ errors.first('standard2') }}</span>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <label >Vượt chuẩn 2 </label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ regex: /^[0-9]*$/}" name="standardSub2" type="text"
                                           min="0"
                                           v-model="standardSub2"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('standardSub2')">{{ errors.first('standardSub2') }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2 text-right">
                                    <label >Thiếu chuẩn 3</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ regex: /^[0-9]*$/}" name="standard3" type="text"
                                           min="0"
                                           v-model="standard3"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('standard3')">{{ errors.first('standard3') }}</span>
                                </div>
                                <div class="col-sm-2 text-right">
                                    <label >Vượt chuẩn 3</label>
                                </div>
                                <div class="col-sm-4">
                                    <input v-validate="{ regex: /^[0-9]*$/}" name="standardSub3" type="text"
                                           min="0"
                                           v-model="standardSub3"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px;"/>
                                    <span class="text-danger" v-show="errors.has('standardSub3')">{{ errors.first('standardSub3') }}</span>
                                </div>
                            </div>
                        </div>

                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-2 text-right">
                                    <label >Trạng thái</label>
                                </div>
                                <div class="col-sm-4">
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
                    $("#modal_chinhsua_tieu_chuan").modal();
                } else {
                    $("#modal_chinhsua_tieu_chuan").modal('hide');
                }
            },

            item: function (newVal, oldVal) {
                this.trangThai = newVal.trangThai;
                this.loai_tieuchuan = newVal.loaiTieuChuan;
                this.ma_tieuchuan = newVal.maChuanChieuCaoCanNang;
                this.thang = newVal.thang;
                this.trangThai = newVal.trangThai;
                this.standardSub1 = newVal.standardSub1;
                this.standardSub2 = newVal.standardSub2;
                this.standardSub3 = newVal.standardSub3;
                this.standard0 = newVal.standard0;
                this.standard1 = newVal.standard1;
                this.standard2 = newVal.standard2;
                this.standard3 = newVal.standard3;
            }
        },

        data() {
            return {
                loai_tieuchuan: '',
                ma_tieuchuan: '',
                thang: '',
                standardSub1: '',
                standardSub2: '',
                standardSub3: '',
                standard0: '',
                standard1: '',
                standard2: '',
                standard3: '',
                trangThai:'',
            }
        },


        mounted: function () {
            $(this.$refs.modal_chinhsua_tieu_chuan).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        loai_tieuchuan: {
                            required: () => 'Loại tiêu chuẩn không thể trống'
                        },
                        thang: {
                            required: () => 'Tháng không thể trống',
                            regex:() => 'Tháng phải là số'
                        },
                        standard0: {
                            required: () => 'Tiểu chuẩn trung bình không thể trống',
                            regex: () => 'Trung bình phải là số'
                        },
                        standard1: {
                            regex: () => 'Thiếu chuẩn 1 phải là số'
                        },
                        standardSub1: {
                            regex: () => 'Vượt chuẩn 1 phải là số'
                        },
                        standard2: {
                            regex: () => 'Thiếu chuẩn 2 phải là số'
                        },
                        standardSub2: {
                            regex: () => 'Vượt chuẩn 2 phải là số'
                        },
                        standard3: {
                            regex: () => 'Thiếu chuẩn 3 phải là số'
                        },
                        standardSub3: {
                            regex: () => 'Vượt chuẩn 3 phải là số'
                        }
                    }
                };
                this.$validator.localize('vi', dict);
            },
            suaChuanChieuCaoCanNangSubmit(){
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.updateTieuChuan();
                    }
                });
            },

            updateTieuChuan() {
                console.log("Chỉnh sửa tiêu chuẩn chiều cao cân nặng");
                utils.confirmDialog("Xác nhận chỉnh sửa tiêu chuẩn", "Sửa", () => {
                    const uri = "/api_chinh_sua_tieu_chuan_chieu_cao_can_nang";
                    const params = {
                        loai_tieuchuan: this.loai_tieuchuan,
                        ma_tieuchuan: this.ma_tieuchuan,
                        thang: this.thang,
                        standardSub1: this.standardSub1,
                        standardSub2: this.standardSub2,
                        standardSub3: this.standardSub3,
                        standard0: this.standard0,
                        standard1: this.standard1,
                        standard2: this.standard2,
                        standard3: this.standard3,
                        trangThai: this.trangThai,
                    };
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa tiêu chuẩn thành công", null, () => {
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


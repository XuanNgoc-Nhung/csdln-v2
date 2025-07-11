<template>

    <div id="modal_chinhsua_linhvuc" ref="modal_chinhsua_linhvuc" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form @submit.prevent="suaLinhVucDanhGiaPhatTrienSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa lĩnh vực đánh giá phát triển</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã lĩnh vực (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text"
                                           min="0"
                                           disabled
                                           v-model="ma_linhvuc"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên lĩnh vực (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true}" name="ten_linhvuc" type="text"
                                           min="0"
                                           v-model="ten_linhvuc"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span class="text-danger" v-show="errors.has('ten_linhvuc')">{{ errors.first('ten_linhvuc') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Cấp học (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="caphoc"
                                            v-model="caphoc"
                                            @change="chonCap()"
                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                            style="min-width: 50px; max-width: 250px">
                                        <option value="">--Chọn cấp học--</option>
                                        <option value='4'>--Nhà trẻ--</option>
                                        <option value='5'>--Mầm non--</option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('caphoc')">{{ errors.first('caphoc') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Nhóm tuổi (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="khoihoc"
                                            v-model="khoihoc"
                                            class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                            style="min-width: 50px; max-width: 250px">
                                        <option value=''>--Chọn nhóm tuổi--</option>
                                        <optgroup label="Nhà trẻ" v-if="caphoc==4">
                                            <option value='13'>Từ 3-12 tháng</option>
                                            <option value='14'>Từ 13-24 tháng</option>
                                            <option value='15'>Từ 13-24 tháng</option>
                                        </optgroup>
                                        <optgroup label="Mẫu giáo" v-if="caphoc==5">
                                            <option value='16'>Từ 3-4 tuổi</option>
                                            <option value='17'>Từ 4-5 tuổi</option>
                                            <option value='18'>Từ 5-6 tuổi</option>
                                        </optgroup>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('khoihoc')">{{ errors.first('khoihoc') }}</span>
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
                    $("#modal_chinhsua_linhvuc").modal();
                } else {
                    $("#modal_chinhsua_linhvuc").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                this.trangThai = newVal.trangThai;
                this.ma_linhvuc = newVal.maLinhVucDanhGiaSuPt;
                this.ten_linhvuc = newVal.tenLinhVucDanhGiaSuPt;
                this.caphoc = newVal.capHoc;
                this.khoihoc = newVal.khoiHoc;
            }
        },

        data() {
            return {
                ma_linhvuc: '',
                ten_linhvuc: '',
                caphoc: '',
                khoihoc: '',
                trangThai: '',
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_chinhsua_linhvuc).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ten_linhvuc : {
                            required: () => 'Tên lĩnh vực không thể trống'
                        },
                        caphoc : {
                            required: () => 'Cấp học không thể trống'
                        },
                        khoihoc : {
                            required: () => 'Nhóm tuổi không thể trống'
                        }
                    }
                };
                this.$validator.localize('vi', dict);
            },
            suaLinhVucDanhGiaPhatTrienSubmit(){
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.updateLinhVuc();
                    }
                });
            },
            updateLinhVuc() {
                console.log("Chỉnh sửa lĩnh vực");
                utils.confirmDialog("Xác nhận chỉnh sửa lĩnh vực", "Sửa", () => {
                    const uri = "/api_chinh_sua_linh_vuc_danh_gia_phat_trien";
                    const params = {
                        ma_linhvuc: this.ma_linhvuc,
                        ten_linhvuc: this.ten_linhvuc,
                        khoihoc: this.khoihoc,
                        caphoc: this.caphoc,
                        trangThai: this.trangThai,
                    };
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa lĩnh vực thành công", null, () => {
                                this.$emit('success',params);
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
            chonCap(){
                this.khoihoc='';
            }
        }

    }
</script>


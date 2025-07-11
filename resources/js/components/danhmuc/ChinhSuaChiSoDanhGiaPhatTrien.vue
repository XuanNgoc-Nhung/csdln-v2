<template>

    <div id="modal_chinhsua_chiso" ref="modal_chinhsua_chiso" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form @submit.prevent="suaChiSoDanhGiaPhatTrienSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa chỉ số đánh giá phát triển</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã chỉ số (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input disabled type="text"
                                           min="0"
                                           disabled
                                           v-model="ma_chiso"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên chỉ số (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true}" name="ten_chiso" type="text"
                                           min="0"
                                           v-model="ten_chiso"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span class="text-danger" v-show="errors.has('ten_chiso')">{{ errors.first('ten_chiso') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Lĩnh vực ĐG&PT (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select v-validate="{ required: true}" name="ma_linhvuc"
                                        v-model="ma_linhvuc"
                                        @change="chonCap()"
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px">
                                        <option value="">--Chọn lĩnh vực--</option>
                                        <option v-for="lv in list_linhvuc" :value="lv.maLinhVucDanhGiaSuPt">{{lv.tenLinhVucDanhGiaSuPt}}</option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('ma_linhvuc')">{{ errors.first('ma_linhvuc') }}</span>
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
                                        <option value='5'>--Mẫu giáo--</option>

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
                                            <option value='15'>Từ 25-36 tháng</option>
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
                    $("#modal_chinhsua_chiso").modal();
                } else {
                    $("#modal_chinhsua_chiso").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                this.trangThai = newVal.trangThai;
                this.ma_linhvuc = newVal.maLinhVucDanhGiaSuPt;
                this.ma_chiso = newVal.maChiSoDanhGiaSuPt;
                this.ten_chiso = newVal.tenChiSoDanhGiaSuPt;
                this.caphoc = newVal.capHoc;
                this.khoihoc = newVal.khoiHoc;
            }
        },

        data() {
            return {
                ma_linhvuc: '',
                ma_chiso: '',
                ten_chiso: '',
                caphoc: '',
                khoihoc: '',
                trangThai: '',
                list_linhvuc:[],
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_chinhsua_chiso).on("hidden.bs.modal", this.close);
            this.LayDanhSachLinhVuc();
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_linhvuc : {
                            required: () => 'Lĩnh vực không thể trống'
                        },
                        ten_chiso : {
                            required: () => 'Tên chỉ số không thể trống'
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
            suaChiSoDanhGiaPhatTrienSubmit(){
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.updateChiSo();
                    }
                });
            },
            updateChiSo() {
                console.log("Chỉnh sửa chỉ số");
                utils.confirmDialog("Xác nhận chỉnh sửa chỉ số", "Sửa", () => {
                    const uri = "/api_chinh_sua_chi_so_danh_gia_phat_trien";
                    const params = {
                        ma_linhvuc: this.ma_linhvuc,
                        ma_chiso: this.ma_chiso,
                        ten_chiso: this.ten_chiso,
                        khoihoc: this.khoihoc,
                        caphoc: this.caphoc,
                        trangThai: this.trangThai,
                    };
                    console.log("pr là:");
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa chỉ số thành công", null, () => {
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


            LayDanhSachLinhVuc() {
                console.log("lấy danh sách lĩnh vực đánh giá và phát triển");

                const uri = "/api_lay_danh_sach_linh_vuc_danh_gia_phat_trien";
                let params = {
                    "start": 0,
                    // "start": (this.currentPage - 1) * this.pagination.per_page,
                    // "limit": this.pagination.per_page,
                    "limit": 99999,
                };
                api.get(uri, params, (respon) => {
                    console.log(respon);
                    this.list_linhvuc= respon.data.rows;
                    this.pagination.total_rows = respon.data.total;
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


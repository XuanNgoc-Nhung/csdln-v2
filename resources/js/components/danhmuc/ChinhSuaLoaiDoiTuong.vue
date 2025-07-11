<template>

    <div id="modal_chinhsua_loaidoituong" ref="modal_chinhsua_loaidoituong" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="suaLoaiDoiTuongSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chỉnh sửa loại đối tượng</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã loại đối tượng (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text"
                                           disabled
                                           v-model="ma_doituong"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên loại đối tượng (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true}" name="ten_doituong" type="text"
                                           min="0"
                                           v-model="ten_doituong"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span class="text-danger" v-show="errors.has('ten_doituong')">{{ errors.first('ten_doituong') }}</span>
                                </div>
                            </div>
                        </div>
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Tên bảng (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <select  v-validate="{ required: true}" name="ten_bang" class="form-control" v-model="ten_bang" style="max-width: 250px;">
                                        <option value=''>Tên bảng</option>
                                        <option value='1'>Giáo viên</option>
                                        <option value='2'>Lớp học</option>
                                        <option value='3'>Trường học</option>
                                        <option value='4'>Học sinh</option>
                                    </select>
                                    <span class="text-danger" v-show="errors.has('ten_bang')">{{ errors.first('ten_bang') }}</span>
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
                    $("#modal_chinhsua_loaidoituong").modal();
                } else {
                    $("#modal_chinhsua_loaidoituong").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                this.trangThai = newVal.trangThai;
                this.ten_doituong = newVal.tenLoaiDoiTuong;
                this.ma_doituong = newVal.maLoaiDoiTuong;
                this.ten_bang = newVal.type;
            }
        },
        data() {
            return {
                trangThai: '',
                ten_doituong: '',
                ma_doituong:'',
                ten_bang: ''
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_chinhsua_loaidoituong).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ten_doituong: {
                            required: () => 'Tên loại đối tượng không thể trống',
                        },
                        ten_bang: {
                            required: () => 'Tên bảng không thể trống',
                        }
                    }
                };
                this.$validator.localize('vi', dict);
            },
            suaLoaiDoiTuongSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.updateLoaiDoiTuong();
                    }
                });
            },
            updateLoaiDoiTuong() {
                utils.confirmDialog("Xác nhận chỉnh sửa loại đối tượng", "Sửa", () => {
                    const uri = "/api_chinh_sua_loai_doi_tuong";
                    const params = {
                        trangThai: this.trangThai,
                        ten_doituong: this.ten_doituong,
                        ma_doituong: this.ma_doituong,
                        ten_bang: this.ten_bang
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log( response.data);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Chỉnh sửa loại đối tượng thành công", null, () => {
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


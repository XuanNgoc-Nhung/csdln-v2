<template>

    <div id="modal_them_loaidoituong" ref="modal_them_loaidoituong" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form @submit.prevent="themLoaiDoiTuongSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm loại đối tượng</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="padding-top: 10px">
                            <div class="form-group clearfix">
                                <div class="col-sm-4">
                                    <label class="pull-right" style="line-height: 34px;">Mã loại đối tượng (<span style="color:#DC0101;">*</span>)</label>
                                </div>
                                <div class="col-sm-8">
                                    <input v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }" name="ma_doituong" type="text"
                                           min="0"
                                           v-model="ma_doituong"
                                           placeholder="Nhập..."
                                           class="form-control control-inline"
                                           style="min-width: 50px; max-width: 250px"/>
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ma_doituong')">{{ errors.first('ma_doituong') }}</span></span>
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
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_doituong')">{{ errors.first('ten_doituong') }}</span></span>
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
                                    <span v-if="show_msg"><span class="text-danger" v-show="errors.has('ten_bang')">{{ errors.first('ten_bang') }}</span></span>
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
                    $("#modal_them_loaidoituong").modal();
                } else {
                    $("#modal_them_loaidoituong").modal('hide');
                }
            }
        },

        data() {
            return {
                ma_doituong: '',
                ten_doituong: '',
                ten_bang:'',
                show_msg:false
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_loaidoituong).on("hidden.bs.modal", this.close);
            this.customMessage();
        },

        methods: {
            customMessage(){
                const dict = {
                    custom: {
                        ma_doituong: {
                            required: () => 'Mã loại đối tượng không thể trống',
                            max: () => 'Mã loại đối tượng không vượt quá 30 ký tự',
                            regex: () => 'Mã loại đối tượng chỉ chứa chữ cái, chữ số, dấu gạch dưới'
                        },
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
            themLoaiDoiTuongSubmit(){
                this.show_msg = true;
                this.$validator.validateAll().then(result => {
                    if (result){
                        this.createLoaiDoiTuong();
                    }
                });
            },
            createLoaiDoiTuong() {
                console.log("Thêm loại đối tượng");
                utils.confirmDialog("Xác nhận thêm loại đối tượng", "Thêm", () => {
                    const uri = "/api_them_loai_doi_tuong";
                    const params = {
                        ma_doituong: this.ma_doituong,
                        ten_doituong: this.ten_doituong,
                        ten_bang:this.ten_bang
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.code === 200) {
                            utils.showDialog("Thông báo", "Thêm loại đối tượng thành công", null, () => {
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
                this.ma_doituong = "";
                this.ten_doituong = "";
                this.ten_bang = "";
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


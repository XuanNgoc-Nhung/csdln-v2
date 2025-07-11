<template>

    <div id="modal_chinhsua_ycdlcu" ref="modal_chinhsua_ycdlcu" class="modal fade">

        <div class="modal-dialog" style="width:50%">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Chỉnh sửa yêu cầu đồng bộ dữ liệu cũ</h4>
                </div>
                <div class="modal-body clearfix">
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Trường học</label>
                            </div>
                            <div class="col-sm-4">
                                <select v-model="ma_truong_hoc"
                                    class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                    <option value="">Chọn trường học</option>
                                    <option v-for="th in list_truonghoc" :value="th.maTruongHoc">{{th.tenTruongHoc}}
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Năm học</label>
                            </div>
                            <div class="col-sm-4">
                                <select v-model="trang_thai"
                                    class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                    <option value="">Chọn trạng thái</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Từ năm</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" placeholder="Nhập..." v-model="tuNam" class="form-control">
                            </div>
                            <div class="col-sm-2">
                                <label class="pull-right" style="line-height: 34px;">Tới năm</label>
                            </div>
                            <div class="col-sm-4">
                                <input type="number" placeholder="Nhập..." v-model="toiNam" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                    </button>
                    <button type="button" class="btn btn-primary" v-on:click="suaYeuCau">Thêm
                    </button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>
    import moment from 'moment'
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import utils from '../../utils'
    import api from '../api';
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import constant from "../../utils/constant";

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: ['item', 'show'],
        components: {
            datePicker,

        },
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.reset();
                    $("#modal_chinhsua_ycdlcu").modal();
                } else {
                    $("#modal_chinhsua_ycdlcu").modal('hide');
                }
            },
            item: function (newVal) {
                console.log("mã tỉnh thành:" + JSON.stringify(newVal));
                this.tuNam = newVal.tuNamHoc;
                this.toiNam = newVal.toiNamHoc;
                this.idYeuCau = newVal.id;
                this.ma_truong_hoc = newVal.maTruongHoc;
                this.maSo = newVal.idSo;
                this.LayDanhSachTruongHoc();

            }
        },

        data() {
            return {
                tuNam: '',
                toiNam: '',
                ma_truong_hoc: '',
                trang_thai: '',
                list_truonghoc: [],
            }
        },


        mounted: function () {
            $(this.$refs.modal_chinhsua_ycdlcu).on("hidden.bs.modal", this.close);
        },

        methods: {
            LayDanhSachTruongHoc() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "matinhthanh": this.maSo,
                };
                rest_api.get("/internal-api/dmTruongHoc/filter", params, (data) => {
                    console.log("kết quả ls trường:" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        this.list_truonghoc = data.data.rows;
                    }
                });
            },
            suaYeuCau() {

                const uri = "/api_chinh_sua_yeu_cau_du_lieu_cu";
                const params = {
                    id: this.idYeuCau,
                    maTruongHoc: this.ma_truong_hoc,
                    tuNamHoc: this.tuNam,
                    toiNamHoc: this.toiNam,
                    trangThai: '0',
                };
                api.post(uri, params, (response) => {
                    if (response.data.rc === 0) {
                        utils.showDialog("Thông báo", "Chỉnh sửa yêu cầu thành công", null, () => {
                            this.$emit('success', params);
                            this.close();
                        });
                    } else {
                        utils.showDialog("Thất bại", response.data.rd, null, () => {
                            this.close();
                        });
                    }
                });
                // utils.confirmDialog("Xác nhận chỉnh sửa yêu cầu", "Thêm", () => {
                // })
            },

            reset() {},
            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            },
        }

    }

</script>

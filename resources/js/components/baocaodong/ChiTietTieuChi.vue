<template>
    <div id="modal_chi_tiet_tieu_chi" ref="modal_chi_tiet_tieu_chi" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">CHI TIẾT TIÊU CHÍ</h4>
                </div>
                <div class="modal-body clearfix">
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="pull-right" style="line-height: 34px;">Tên tiêu chí *</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text"
                                       min="0"
                                       disabled
                                       v-model="ten_tieu_chi"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px; max-width: 250px"/>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="pull-right" style="line-height: 34px;">Mã tiêu chí *</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text"
                                       min="0"
                                       disabled
                                       v-model="ma_tieu_chi"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px; max-width: 250px"/>
                            </div>
                        </div>
                    </div>

                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="pull-right" style="line-height: 34px;">Tiêu chí cha</label>
                            </div>
                            <div class="col-sm-8">
                                <select v-if="tieu_chi_cha.tenTieuChiCha == null"
                                        class="form-control"
                                        disabled
                                        style="min-width: 50px; max-width: 250px">
                                    <option value=''>-- Là tiêu chí cha --</option>
                                </select>
                                <select v-else
                                        class="form-control"
                                        disabled
                                        style="min-width: 50px; max-width: 250px">
                                    <option value=''>{{this.tieu_chi_cha.tenTieuChiCha}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="pull-right" style="line-height: 34px;">Trạng thái</label>
                            </div>
                            <div class="col-sm-8">
                                <select disabled
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px"
                                        v-model="trang_thai">
                                    <option value=0>Đang hoạt động</option>
                                    <option value=1>Hết hiệu lực</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="pull-right" style="line-height: 34px;">Nhóm tiêu chí *</label>
                            </div>
                            <div class="col-sm-8">
                                <select disabled
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px">
                                        <option value="">
                                            {{this.tieu_chi_cha.tenNhomTieuChi}}
                                        </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="pull-right" style="line-height: 34px;">Loại tiêu chí</label>
                            </div>
                            <div class="col-sm-8">
                                <select disabled
                                        class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                        style="min-width: 50px; max-width: 250px"
                                        v-model="loai_tieu_chi">
                                    <option value="0">Storeproc</option>
                                    <option value="1">Script</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="pull-right" style="line-height: 34px;">Script *</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text"
                                       min="0"
                                       disabled
                                       v-model="script"
                                       placeholder="Nhập..."
                                       class="form-control"
                                       style="min-width: 50px; max-width: 250px; min-height: 100px;max-height: 150px"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

    import moment from 'moment/moment'
    import utils from '../../utils'
    import api from '../api';

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: ['item', 'show', 'tieuchi'],


        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    // this.reset();
                    $("#modal_chi_tiet_tieu_chi").modal();
                } else {
                    $("#modal_chi_tiet_tieu_chi").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                if (newVal != null) {
                    this.tieu_chi_cha = newVal;
                    this.ten_tieu_chi = newVal.tenTieuChi;
                    this.ma_tieu_chi = newVal.maTieuChi;
                    this.tieu_chi_cha_id = newVal.tieuChiChaId;
                    this.nhom_tieu_chi_id = newVal.nhomTieuChiId;
                    this.trang_thai = newVal.trangThai;
                    this.script = newVal.scriptDongBo;
                    this.loai_tieu_chi = newVal.loaiTieuChi;
                    console.log("tiêu chí cha không null");
                } else {
                    this.tieu_chi_cha = null;
                    console.log("tiêu chí cha null");
                }
            }
        },

        data() {
            return {
                ma_tieu_chi: '',
                ten_tieu_chi: '',
                tieu_chi_cha_id: '',
                trang_thai: '',
                nhom_tieu_chi_id: '',
                loai_tieu_chi: '',
                script: '',


                tieu_chi_cha: {},


            }
        },
        mounted: function () {
            $(this.$refs.modal_chi_tiet_tieu_chi).on("hidden.bs.modal", this.close);
        },

        methods: {

            reset() {
                this.ten_tieu_chi = "";
                this.ma_tieu_chi = "";
                this.script = "";
                this.tieu_chi_cha = null;
                this.tieu_chi_cha_id = '';
                this.nhom_tieu_chi_id = '';
                this.trang_thai = "0";
                this.loai_tieu_chi = "";
            },

            close() {
                console.log("close modal");
                // this.reset();
                this.$emit('close');
            },

        }

    }
</script>


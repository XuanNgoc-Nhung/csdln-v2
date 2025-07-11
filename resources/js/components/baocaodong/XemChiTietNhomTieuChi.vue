<template>

    <div id="modal_xem_nhom_tieu_chi" ref="modal_xem_nhom_tieu_chi" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Xem chi tiết nhóm tiêu chí</h4>
                </div>
                <div class="modal-body clearfix">
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="pull-right" style="line-height: 34px;">Tên nhóm tiêu chí</label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text"
                                       min="0"
                                       v-model="v_ten_nhom_tieu_chi"
                                       placeholder="Nhập..."
                                       class="form-control control-inline"
                                       style="min-width: 50px;" disabled/>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="pull-right" style="line-height: 34px;">Nhóm tiêu chí cha</label>
                            </div>
                            <div class="col-sm-8">
                                <select class="form-control" v-model="v_nhom_tieu_chi_cha_id" disabled>
                                    <option value=-1 >-- Là tiêu chí cha --</option>
                                    <option v-for=" ntc in v_ds_nhom_tieu_chi" :value=ntc.nhomTieuChiId> {{ntc.tenNhomTieuChi}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div style="padding-top: 10px">
                        <div class="form-group clearfix">
                            <div class="col-sm-4">
                                <label class="pull-right" style="line-height: 34px;">Cấp nhóm</label>
                            </div>
                            <div class="col-sm-8">
                                <select class="form-control" v-model="v_cap_nhom" disabled>
                                    <option value=0> Cấp 1</option>
                                    <option value=1> Cấp 2</option>
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
                                <select class="form-control" v-model="v_trang_thai" disabled="">
                                    <option value=0> Đang hoạt động</option>
                                    <option value=1> Ngưng hoạt động</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!--                <div class="modal-footer clearfix">-->
                <!--                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy-->
                <!--                    </button>-->
                <!--                    <button type="button" class="btn btn-primary" v-on:click="createNation">Sửa-->
                <!--                    </button>-->
                <!--                </div>-->
            </div>


        </div>

    </div>

</template>

<script>

    import utils from '../../utils'
    import api from '../api';
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';

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
                    $("#modal_xem_nhom_tieu_chi").modal();
                } else {
                    $("#modal_xem_nhom_tieu_chi").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                console.log("789"+ JSON.stringify(newVal))
                this.getDataNhomTieuChiCha();
                // console.log("abc");
                // console.log(newVal.maCuaBo);
                this.v_nhom_tieu_chi_id = newVal.nhomTieuChiId;
                this.v_ten_nhom_tieu_chi = newVal.tenNhomTieuChi;
                this.v_cap_nhom = newVal.capNhom;
                this.v_trang_thai = newVal.trangThai;
                if(this.v_trang_thai === true){
                    this.v_trang_thai = 0;
                }
                if(this.v_trang_thai === false){
                    this.v_trang_thai = 1;
                }
                this.v_nhom_tieu_chi_cha_id = newVal.nhomTieuChiChaId;
                if(this.v_nhom_tieu_chi_cha_id == null){
                    this.v_nhom_tieu_chi_cha_id = -1;
                }
            }
        },

        data() {
            return {
                v_nhom_tieu_chi_id :'',
                v_ten_nhom_tieu_chi: '',
                v_nhom_tieu_chi_cha_id: -1,
                v_cap_nhom: 0,
                v_trang_thai : 0,
                v_ds_nhom_tieu_chi:[]
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_xem_nhom_tieu_chi).on("hidden.bs.modal", this.close);
        },

        methods: {

            createNation() {
                console.log("Sửa nhóm tiêu chí");
                if(this.v_ten_nhom_tieu_chi === ''){
                    utils.showDialog("Thông báo","Vui lòng điền tên nhóm tiêu chí");
                    return;
                }
                utils.confirmDialog("Xác nhận sửa nhóm tiêu chí", "Thêm", () => {
                    const uri = "/csdlgd-admin-bcdNhomTieuChi-update";
                    const params = {
                        "nhomTieuChiId" : this.v_nhom_tieu_chi_id,
                        "tenNhomTieuChi": this.v_ten_nhom_tieu_chi,
                        "nhomTieuChiChaId": this.v_nhom_tieu_chi_cha_id == -1 ? null : this.v_nhom_tieu_chi_cha_id,
                        "capNhom": this.v_cap_nhom,
                        "trangThai": this.v_trang_thai
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log(response);
                        if (response.data.rc === 0) {
                            utils.showDialog("Thông báo", "Sửa nhóm tiêu chí thành công", null, () => {
                                this.$emit('success', params);
                                // this.reset();
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
                // this.v_ten_nhom_tieu_chi = "";
                // this.v_nhom_tieu_chi_cha_id = -1;
                // this.v_cap_nhom = 0;
                // this.v_trang_thai = 0;
                // this.v_ds_nhom_tieu_chi = [];
            },
            close() {
                console.log("close modal");
                // this.reset();
                this.$emit('close');
            },

            getDataNhomTieuChiCha(){
                console.log("laasy nhoms tieu chi")
                let params = {
                    "start": 0,
                    "limit": 9999999,
                    "trangthai": 0,
                    "capNhom" : 0
                };
                rest_api.post("/csdlgd-admin/bcdNhomTieuChi/search", params, (data) => {
                    console.log("---" + JSON.stringify(data));
                    if (array_util.isArray(data.data.tableData)) {
                        array_util.clearArrays(this.v_ds_nhom_tieu_chi);
                        this.v_ds_nhom_tieu_chi = data.data.tableData;
                        console.log("---" + JSON.stringify(data));
                    }
                });
            }

        }

    }
</script>

<template>

    <div id="modal_sync_update" ref="modal_sync_update" tabindex="-1" data-backdrop="true" class="modal fade custom_md">

        <div class="modal-dialog" style="width: 60%">

            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Chỉnh sửa yêu cầu đồng bộ dữ liệu cũ</h4>
                </div>

                <div class="modal-body">
                    <div class="row student-info">

                        <div class="col-md-6 row_tp">
                            <div class="row">
                                <div class="col-md-4"><label class="pull-right lbl_field">Trường học:
                                    <span class="required_t icon_t">*</span></label></div>
                                <div class="col-md-8">
                                    <input type="text" v-model="tenTruongHoc" disabled class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 row_tp">
                            <div class="row">
                                <div class="col-md-4"><label class="pull-right lbl_field">Trạng
                                    thái:<span class="required_t icon_t">*</span></label></div>
                                <div class="col-md-8">
                                    <select ref="trang_thai" v-model="trangThai" class="form-control"
                                            style="width:100%">
                                        <option value="">-- Tất cả --</option>
                                        <option value="1">Đang hoạt động</option>
                                        <option value="0">Ngưng hoạt động</option>
                                    </select>
                                    <em class="required_t">{{errors.trangThai}}</em>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 row_tp">
                            <div class="row">
                                <div class="col-md-4"><label class="pull-right lbl_field">Từ năm
                                    học:<span class="required_t icon_t">*</span></label></div>
                                <div class="col-md-8">
                                    <select ref="tuNamHoc" v-model="tuNamHoc" class="form-control" style="width:100%">
                                        <option value="">--Chọn--</option>
                                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                    </select>
                                    <em class="required_t">{{errors.tuNamHoc}}</em>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 row_tp">
                            <div class="row">
                                <div class="col-md-4"><label class="pull-right lbl_field">Tới năm học:
                                    <span class="required_t icon_t">*</span></label></div>
                                <div class="col-md-8">
                                    <select ref="toiNamHoc" v-model="toiNamHoc" class="form-control" style="width:100%">
                                        <option value="">--Chọn--</option>
                                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                    </select>
                                    <em class="required_t">{{errors.toiNamHoc}}</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="createSyncDataOld()" class="btn btn-primary">
                        Sửa</button>
                </div>

            </div>

        </div>

    </div>

</template>

<script>

    import m_util from '../../../utils/m_utils';
    import constant from '../../../utils/constant';
    import rest_api from '../../../utils/rest_api';
    import utils from '../../../utils'
    import api from '../../api';
    import {mapMutations, mapState} from 'vuex';

    export default {

        props: ['item', 'show'],

        watch: {
            show: function (newVal, oldVal) {
                if (newVal) {
                    this.reset();
                    $("#modal_sync_update").modal();
                } else {
                    $("#modal_sync_update").modal('hide');
                }
            },
            item:function(newVal,oldVal){
                console.log("chỉnh sửa:" + JSON.stringify(newVal));
                this.maTruongHoc=newVal.maTruongHoc;
                this.tenTruongHoc=newVal.tenTruongHoc;
                this.tuNamHoc=newVal.tuNamHoc;
                this.toiNamHoc=newVal.toiNamHoc;
                this.trangThai=newVal.trangThai;
                this.idSo=newVal.idSo;
                this.idYeuCau=newVal.id;
            }
        },

        computed: {
            ...mapState(['ds_truong_hoc'])
        },

        beforeMount() {
            this.list_years = constant.LIST_YEARS_FULL;
            console.log("Year = " + JSON.stringify(this.list_years));
        },

        mounted: function () {
            $(this.$refs.modal_sync_update).on("hidden.bs.modal", this.close);
        },

        data() {
            return {
                maTruongHoc:'',
                tenTruongHoc:'',
                tuNamHoc:'',
                toiNamHoc:'',
                trangThai:'',
                idSo:'',
                idYeuCau:'',
                "ma_truong_hoc": "",
                "trang_thai": "",
                "tuNamHoc": "",
                "toiNamHoc": "",
                errors: {
                    "maTruongHoc": "",
                    "trangThai": "",
                    "tuNamHoc": "",
                    "toiNamHoc": "",
                },

                list_years: []
            }
        },

        methods: {

            ...mapMutations(['setFlagReload']),

            resetErrors() {
                this.errors = {
                    "ma_truong_hoc": "",
                    "trang_thai": "",
                    "tuNamHoc": "",
                    "toiNamHoc": "",
                };
            },

            createSyncDataOld() {

                console.log("from: " + this.tuNamHoc + ", to: " + this.toiNamHoc);
                this.resetErrors();
                if (!m_util.checkString(this.trangThai)) {
                    this.errors.trangThai = "Vui lòng chọn trạng thái";
                    // this.$refs.trangThai.focus();
                    return;
                }

                if (!m_util.checkString(this.tuNamHoc)) {
                    this.errors.tuNamHoc = "Vui lòng chọn năm bắt đầu";
                    // this.$refs.tuNamHoc.focus();
                    return;
                }

                if (!m_util.checkString(this.toiNamHoc)) {
                    this.errors.toiNamHoc = "Vui lòng chọn năm kết thúc";
                    // this.$refs.toiNamHoc.focus();
                    return;
                }

                if (parseInt(this.toiNamHoc) < parseInt(this.tuNamHoc)) {
                    this.errors.toiNamHoc = "Vui lòng chọn năm kết thúc đúng";
                    // this.$refs.toiNamHoc.focus();
                    return;
                }

                confirmDialog("Bạn muốn chỉnh sửa yêu cầu này chứ ?", "Sửa", () => {
                    // let params = {
                    //     "id":this.idYeuCau,
                    //     "maTruongHoc": this.maTruongHoc,
                    //     "toiNamHoc": this.toiNamHoc,
                    //     "trangThai": Number(this.trangThai),
                    //     "tuNamHoc": this.tuNamHoc
                    // };
                    // console.log("param chỉnh sửa:" + JSON.stringify(params));
                    // rest_api.post("/csdlgd-admin/yeuCauDuLieuCu/", params, (data) => {
                    //     console.log("data: " + JSON.stringify(data.data));
                    //     let msg = m_util.getMessageResponse(data, "Thêm yêu cầu thành công", "Thêm yêu cầu thất bại");
                    //     showDialog("Thông báo", msg, null, () => {
                    //         if (parseInt(data.data.rc) === 0) {
                    //             this.setFlagReload();
                    //             this.close();
                    //         }
                    //     }, null);
                    // }, null, true);


                    const uri = "/api_chinh_sua_phan_quyen_dong_bo";
                    const params = {
                            "id":this.idYeuCau,
                            "maTruongHoc": this.maTruongHoc,
                            "toiNamHoc": this.toiNamHoc,
                            "trangThai": Number(this.trangThai),
                            "tuNamHoc": this.tuNamHoc
                    };
                    console.log(params);
                    api.post(uri, params, (response) => {
                        console.log( response.data);
                        if (response.data.rc === 0) {
                            utils.showDialog("Thông báo", "Chỉnh sửa thành công", null, () => {
                                this.$emit('success', params);
                                this.close();
                            });
                        } else {
                            utils.showDialog("Thất bại", response.data.rd, null, () => {
                            });
                        }
                    });
                });
            },

            close() {
                this.$emit("close", 1);
            },

            reset() {
                this.resetErrors();
            }

        }

    }
</script>

<style scoped>
    label {
        position: relative;
    }
</style>

<template>
    <div>
        <div class="row">
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-3">
                        <label class="pull-right lbl_field">Chọn năm học:</label>
                    </div>
                    <div class="col-md-5">
                        <select class="form-control" v-model="namHoc">
                            <option value=''>Chọn năm học</option>
                            <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success" @click.prevent="Synce()"><i class="fa fa-search"></i>Đồng bộ
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>
<script>
    import rest_api from '../../utils/rest_api';
    import Vue from 'vue';
    import utils from '../../utils';
    import VueAlertify from 'vue-alertify';
    import constant from "../../utils/constant";

    Vue.use(VueAlertify);
    export default {

        components: {},

        data() {
            return {
                date: new Date(),
                sync_types: constant.SYNC_TYPE,
                list_years: constant.LIST_YEARS_FULL,
                namHoc: "",
            }
        },
        props: {
            maSo: {
                type: Number,
                default: '0',
            },
        },
        mounted() {
            this.namHoc = this.date.getFullYear();
            console.log(this.maSo + "là mã sở");
        },

        methods: {
            Synce() {
                let params = {
                    "namHoc": this.namHoc,
                    // "maTruongHoc": this.ma_truong_hoc,
                };
                console.log("params gửi đi:" + JSON.stringify(params));
                rest_api.post("/csdlgd-admin/yeuCauDuLieuCu/createYcDbdlCu", params, (data) => {
                    console.log("Yêu cầu đồng bộ dữ liệu cũ: " + JSON.stringify(data));
                    if (data.data.rc === 0) {
                        utils.showDialog("Thông báo", "Yêu cầu đồng bộ thành công");
                    }
                    else{
                        utils.showDialog("Lỗi", data.data.rd);
                    }
                });
            },

        }

    }
</script>
<style scoped>

</style>

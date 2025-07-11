<template>

<div>
    <div id="thongtin_ketchuyen" ref="thongtin_ketchuyen" class="modal fade">
        <div class="modal-dialog" style="width:85%">
            <div class="modal-content">
                <form role="form">
                    <div class="modal-header">
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-hidden="true"
                            v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chi tiết danh sách kết chuyển

                        </h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="xembaocao">
                                    <div class="table-responsive row_tp">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr class="text-center">
                                                    <th class="text-center">STT</th>
                                                    <th class="text-center">Loại</th>
                                                    <th class="text-center">Bắt đầu</th>
                                                    <th class="text-center">Kết thúc</th>
                                                    <th class="text-center">Trạng thái</th>
                                                    <th class="text-center">Tổng</th>
                                                    <th class="text-center">Lỗi</th>
                                                    <th class="text-center">Thành công</th>
                                                    <th class="text-center">Thao tác</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-if="listBanGhi.length==0">
                                                    <td colspan="13" class="text-center">Không có dữ liệu</td>
                                                </tr>
                                                <tr v-else="v-else" v-for="(bg,i) in listBanGhi">
                                                    <td class="text-center">{{i+1}}</td>
                                                    <td>{{bg.loaiDay}}</td>
                                                    <td class="text-center">{{bg.timeStart}}</td>
                                                    <td class="text-center">{{bg.timeUpdate}}</td>
                                                    <td>
                                                        <div v-if="bg.trangThai==1">Thành công</div>
                                                        <div v-else-if="bg.trangThai==0">Thất bại</div>
                                                        <div v-else-if="bg.trangThai==10">Đang tổng hợp</div>
                                                        <div v-else-if="bg.trangThai==11">Tổng hợp xong</div>
                                                        <div v-else-if="bg.trangThai==12">Tổng hợp lỗi</div>
                                                        <div v-else="v-else">Đang xử lý</div>
                                                    </td>
                                                    <td class="text-center">{{bg.soBanGhiDay}}
                                                        bản ghi.</td>
                                                    <td class="text-center">{{bg.soBanGhiLoi}}
                                                        bản ghi.</td>
                                                    <td class="text-center">{{bg.sobanGhiThanhCong}}
                                                        bản ghi.</td>
                                                    <td class="text-center">
                                                        <a
                                                            href="#"
                                                            class="btn btn-info"
                                                            title="Xem chi tiết"
                                                            @click.prevent="xemChiTiet(bg.messageId)">Chi tiết</a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!-- <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
    <div>
            <component :hien="show_info"
                       @closeinfo="show_info=false"
                       :item="idBanGhi"
                       :is="ThongTin">
            </component>
    </div>
</div>

</template>
<script>

    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import time_utils from '../../utils/time_utils';
    import utils from '../../utils'
    import api from '../api';
    import VeeValidate, {Validator} from 'vee-validate';
    import ThongTin from "./ChiTietKetChuyen";
    import dialog from '../../utils/dialog';
    //Validator.localize('vi', vi);
    Vue.use(VeeValidate);

    $(document).ready(function () {
        // console.log("ready!");
    });

    export default {

        props: [
            'item', 'show'
        ],
        components: {ThongTin: ThongTin,},
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    //this.reset();
                    $("#thongtin_ketchuyen").modal();
                } else {
                    $("#thongtin_ketchuyen").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                console.log("thông tin kết chuyển của: " + newVal);
                this.thongTinBanGhi = newVal;
                console.log(JSON.stringify(this.thongTinBanGhi))
                this.getChiTiet();
            }
        },

        data() {
            return {listBanGhi: [], thongTinBanGhi: '', thongTinChiTiet: '', show_info: false, ThongTin:"ThongTin",idBanGhi:""}
        },
        mounted: function () {
            $(this.$refs.thongtin_ketchuyen).on("hidden.bs.modal", this.close);
        },

        methods: {
            xemChiTiet(e) {
                console.log("xem chi tiết:" + e)
                this.idBanGhi=e
                this.show_info = true;
            },
            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            },
            reset() {
                // this.listBanGhi=[];
            },

            getChiTiet() {
                const uri = "/api_lay_thong_tin_ket_chuyen";
                const params = {
                    maTruongHoc: this.thongTinBanGhi.maTruong,
                    namHoc: this.thongTinBanGhi.namHoc
                };
                console.log("lấy chi tiết:" + params)
                api.post(uri, params, (response) => {
                    console.log("chi tiết:" + JSON.stringify(response))
                    if (response.data.statusResponse === 0) {
                        this.listBanGhi = response.data.rows;
                        if (this.listBanGhi == null) {
                            this.listBanGhi = [];
                        }
                        console.log("bản ghi là:" + JSON.stringify(this.listBanGhi))

                    } else {
                        utils.showDialog("Thất bại", response.data.message, null, () => {});
                    }
                });
            }
        }

    }
</script>
<style scoped="scoped">
    .form-check-inline {
        display: inline-flex;
        align-items: center;
        padding-left: 0;
        margin-right: 0.75rem;
    }
    .form-check-inline label {
        margin-bottom: 0;
        margin-left: 5px;
        position: relative;
        top: 2px;
    }
    .xembaocao {
        max-height: 400px;
        overflow: scroll;
    }
</style>

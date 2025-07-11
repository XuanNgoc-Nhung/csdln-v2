<template>
    <div id="modal_nl" ref="modal_nl" class="modal fade" style="font-size:18px;">
        <div class="modal-dialog" style="width:95%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase">Quá trình lương</h5>
                </div>
                <div class="modal-body" style="width: 100%;margin: 0 auto;">
                    <div style="height: 65vh;overflow: scroll;">
                        <div class="">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background:#e4ebf5">
                                        <th class="cg">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg">
                                            <p>Ngày hưởng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Ngạch/hạng <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Bậc lương <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Hệ số lương <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>% vượt khung</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_qua_trinh_luong.length==0">
                                    <tr>
                                        <td class="cg bt" colspan="6">
                                            <p>Không có bản ghi nào</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item,i) in list_qua_trinh_luong" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td class="cg">
                                            <p>{{item.ngayThangNam}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.maNgach,list_ma_ngach_hang)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.maBacLuong,list_bac_luong)}}</p>
                                        </td>
                                        <td class="cg">
                                            <p>{{item.heSoLuong}}</p>
                                        </td>
                                        <td class="cg">
                                            <p>{{item.phanTramVuotKhung}}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <el-button class="dts-button-close" size="mini" data-dismiss="modal">Đóng
                    </el-button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../../utils/rest_api';
    import moment from 'moment'
    import datePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import utils from '../../../utils';
    export default {
        props: ['item'],
        watch: {},
        components: {
            datePicker,
        },
        data() {
            return {
                configDate: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    locale: 'vi'
                },

                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                list_qua_trinh_luong: [],
                list_ma_ngach_hang: [],
                list_bac_luong: [],
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            this.list_qua_trinh_luong = this.item;
            $("#modal_nl").modal();
            $(this.$refs.modal_nl).on("hidden.bs.modal", this.close);
        },
        methods: {
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_ngach_hang_moet_code_sme"];
                if (tmp) {
                    this.list_ma_ngach_hang = JSON.parse(localStorage["danh_sach_ngach_hang_moet_code_sme"]);
                    this.list_bac_luong = JSON.parse(localStorage["danh_sach_bac_luong_moet_code_sme"]);
                }
            },
            close() {
                this.$emit('close');
            },
            getTen(val, lst) {
                let ten = "";
                for (let i = 0; i < lst.length; i++) {
                    if (val == lst[i].value) {
                        ten = lst[i].name;
                    }
                }
                return ten;
            },
        }
    }

</script>

<style scoped="scoped">
    

    .text-right label {
        padding: 6px 0;
    }

    .nav-tabs>li.active>a {
        font-weight: bold;
        color: forestgreen;
        border-top: 4px solid forestgreen;
    }

    .rct {
        margin: 5px -15px !important;
        display: flex;
    }

    .rct>.col-md-7,
    .col-md-2,
    .col-md-4,
    .col-md-5 {
        align-self: center;
    }

    .cg {
        text-align: center;
    }

    .bt>a>b>i {
        color: #DC0101;
        border: 1px solid black;
        padding: 5px 6px;
        border-radius: 23%;
    }

</style>

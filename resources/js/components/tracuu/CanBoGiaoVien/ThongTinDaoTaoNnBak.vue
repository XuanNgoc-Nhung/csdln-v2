<template>
    <div id="modal_kt" ref="modal_kt" class="modal fade" style="font-size:18px;">
        <div class="modal-dialog" style="width:95%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase">Quá trình ngoại ngữ</h5>
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
                                            <p>Ngoại ngữ khác <span style="color:#DC0101">*</span> </p>
                                        </th>
                                        <th class="cg">
                                            <p>Trình độ ngoại ngữ</p>
                                        </th>
                                        <th class="cg">
                                            <p>Điểm ngoại ngữ</p>
                                        </th>
                                        <th class="cg">
                                            <p>Ngày cấp</p>
                                        </th>
                                        <th class="cg">
                                            <p>Ghi chú</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_dao_tao_ngoai_ngu.length==0">
                                    <tr>
                                        <td class="cg bt" colspan="9">
                                            <p>Không có bản ghi nào</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item,i) in list_dao_tao_ngoai_ngu" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.maNgoaiNgu,list_ma_ngoai_ngu)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.maTrinhDoNgoaiNgu,list_trinh_do_ngoai_ngu)}}</p>
                                        </td>
                                        <td class="cg">
                                            <p>{{item.diemNgoaiNgu}}</p>
                                        </td>
                                        <td class="cg">
                                            <p>{{item.ngayCap}}</p>
                                        </td>
                                        <td>
                                            <p>{{item.ghiChu}}</p>
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
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
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
                    showTodayButton: true,
                    locale: 'vi'
                },
                list_dao_tao_ngoai_ngu: [],
                list_ma_ngoai_ngu: [],
                list_trinh_do_ngoai_ngu: [],
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            this.list_dao_tao_ngoai_ngu = this.item;
            $("#modal_kt").modal();
            $(this.$refs.modal_kt).on("hidden.bs.modal", this.close);
        },
        methods: {
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_ngoai_ngu_chinh_moet_code_sme"];
                if (tmp) {
                    this.list_ma_ngoai_ngu = JSON.parse(localStorage["danh_sach_ngoai_ngu_chinh_moet_code_sme"]);
                    this.list_trinh_do_ngoai_ngu = JSON.parse(localStorage["danh_sach_trinh_do_ngoai_ngu_sme"]);
                }
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
            close() {
                this.$emit('close');
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

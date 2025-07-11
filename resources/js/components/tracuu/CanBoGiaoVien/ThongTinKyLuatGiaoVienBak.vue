<template>
    <div id="modal_kt" ref="modal_kt" class="modal fade" style="font-size:18px;">
        <div class="modal-dialog" style="width:95%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase">Thông tin kỷ luật</h5>
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
                                            <p>Kỷ luật <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Cấp ký quyết định</p>
                                        </th>
                                        <th class="cg">
                                            <p>Số quyết định</p>
                                        </th>
                                        <th class="cg">
                                            <p>Ngày kỷ luật</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_ky_luat.length==0">
                                    <tr>
                                        <td class="cg bt" colspan="9">
                                            <p>Không có bản ghi nào</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item,i) in list_ky_luat" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.maKyLuatGv,list_ky_luat_giao_vien)}}</p>
                                        </td>
                                        <td>
                                            <p>{{item.capKyLuat}}</p>
                                        </td>
                                        <td class="cg">
                                            <p>{{item.soQuyetDinhKyLuat}}</p>
                                        </td>
                                        <td class="cg">
                                            <p>{{item.ngayKyLuat}}</p>
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
                    showTodayButton: true,
                    locale: 'vi'
                },
                list_ky_luat: [],
                list_ky_luat_giao_vien: [],
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            this.list_ky_luat = this.item;
            $("#modal_kt").modal();
            $(this.$refs.modal_kt).on("hidden.bs.modal", this.close);
        },
        methods: {
            ganDuLieuSME(){
                let tmp = localStorage["danh_sach_ky_luat_can_bo_moet_code_sme"];
                if(tmp){
                    this.list_ky_luat_giao_vien = JSON.parse(localStorage["danh_sach_ky_luat_can_bo_moet_code_sme"]);
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

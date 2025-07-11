<template>
    <div id="modal_kt" ref="modal_kt" class="modal fade" style="font-size:18px;">
        <div class="modal-dialog" style="width:95%">
            <form>
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
                                        <th class="cg">
                                            <p>Thao tác</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_dao_tao_ngoai_ngu.length==0">
                                    <tr>
                                        <td class="cg bt" colspan="9">
                                            <p>Không có bản ghi nào</p>
                                            <a href="#" title="thêm" @click.prevent="themItemBdDt()"><b><i
                                                        style="color:blue; background: chartreuse;"
                                                        class="fas fa-plus"></i></b> </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item,i) in list_dao_tao_ngoai_ngu" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <el-select v-model="item.maNgoaiNgu" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="item in list_ma_ngoai_ngu" :key="item.value"
                                                    :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.maTrinhDoNgoaiNgu" style="min-width:200px" filterable
                                                collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="item in list_trinh_do_ngoai_ngu" :key="item.value"
                                                    :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" v-model="item.diemNgoaiNgu"
                                                placeholder="Nhập...">
                                        </td>
                                        <td>
                                            <date-picker v-model="item.ngayCap" valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY"></date-picker>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" v-model="item.ghiChu"
                                                placeholder="Nhập...">
                                        </td>
                                        <td class="cg bt">
                                            <a href="#" title="xóa" @click.prevent="xoaItemDtBd(i)"><b><i
                                                        style="color:#DC0101; background: gainsboro;"
                                                        class="fas fa-trash-alt"></i></b> </a>
                                            <a href="#" v-show="i+1==list_dao_tao_ngoai_ngu.length" title="thêm"
                                                @click.prevent="themItemBdDt(i)"><b><i
                                                        style="color:blue; background: chartreuse;"
                                                        class="fas fa-plus"></i></b> </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary" @click.prevent="resetQt()">Lưu lại </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import moment from 'moment'
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue2-datepicker';
  import 'vue2-datepicker/index.css';
    import utils from '../../utils';
    import VueAlertify from "vue-alertify";
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
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
                    this.list_trinh_do_ngoai_ngu = JSON.parse(localStorage["danh_sach_trinh_do_ngoai_ngu_moet_code_sme"]);
                }
            },
            resetQt() {
                for (let i = 0; i < this.list_dao_tao_ngoai_ngu.length; i++) {
                        if (!this.list_dao_tao_ngoai_ngu[i].maNgoaiNgu) {
                            this.$alertify.error("Thiếu mã ngoại ngữ");
                            return;
                        }
                }
                let obj = {
                    lnn: this.list_dao_tao_ngoai_ngu,
                };

                utils.confirmDialog("Xác nhận lưu lại thông tin", "Đồng ý", () => {
                    this.$emit('success', obj);
                })
            },
            themItemBdDt(e) {
                if (this.list_dao_tao_ngoai_ngu.length == 0) {
                    let obj = {
                        maNgoaiNgu: "",
                        maTrinhDoNgoaiNgu: "",
                        diemNgoaiNgu: "",
                        ngayCap: "",
                        ghiChu: "",
                    }
                    console.log("thêm item qtnn");
                    this.list_dao_tao_ngoai_ngu.push(obj);
                } else {
                    for (let i = 0; i < this.list_dao_tao_ngoai_ngu.length; i++) {
                        if (!this.list_dao_tao_ngoai_ngu[i].maNgoaiNgu) {
                            this.$alertify.error("Thiếu mã ngoại ngữ");
                            return;
                        }
                    }
                    let obj = {
                        maNgoaiNgu: "",
                        maTrinhDoNgoaiNgu: "",
                        diemNgoaiNgu: "",
                        ngayCap: "",
                        ghiChu: "",
                    }
                    this.list_dao_tao_ngoai_ngu.push(obj);
                }
            },
            xoaItemDtBd(e) {
                console.log("xóa ở vị trí:" + e);
                this.list_dao_tao_ngoai_ngu.splice(e, 1);
            },
            close() {
                let obj = {
                    lnn: this.list_dao_tao_ngoai_ngu,
                };
                this.$emit('close', obj);
            },
        }
    }

</script>

<style scoped="scoped">
    @import "../../../../node_modules/css-custom.css";

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

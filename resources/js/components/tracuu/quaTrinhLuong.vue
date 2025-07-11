<template>
    <div id="modal_nl" ref="modal_nl" class="modal fade" style="font-size:18px;">
        <div class="modal-dialog" style="width:95%">
            <form>
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
                                        <th class="cg">
                                            <p>Thao tác</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_qua_trinh_luong.length==0">
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
                                    <tr v-for="(item,i) in list_qua_trinh_luong" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <date-picker v-model="item.ngayThangNam" valueType="format" format="DD/MM/YYYY"></date-picker>
                                        </td>
                                        <td>
                                            <el-select v-model="item.maNgach" style="min-width:200px"
                                                filterable collapse-tags placeholder="Chọn"
                                                no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="item in list_ma_ngach_hang" :key="item.value"
                                                    :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <el-select v-model="item.maBacLuong" style="min-width:200px"
                                                filterable collapse-tags placeholder="Chọn"
                                                no-data-text="Không có dữ liệu"
                                                no-match-text="Không có dữ liệu phù hợp">
                                                <el-option v-for="item in list_bac_luong" :key="item.value"
                                                    :label="item.name" :value="item.value">
                                                </el-option>
                                            </el-select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" v-model="item.heSoLuong"
                                                placeholder="Nhập...">
                                        </td>
                                        <td>
                                                <input type="number"
                                                    @input="item.phanTramVuotKhung = Math.round(item.phanTramVuotKhung);"
                                                    placeholder="Nhập số nguyên dương" class="form-control"
                                                    v-model="item.phanTramVuotKhung" />
                                        </td>
                                        <td class="cg bt">
                                            <a href="#" title="xóa" @click.prevent="xoaItemDtBd(i)"><b><i
                                                        style="color:#DC0101; background: gainsboro;"
                                                        class="fas fa-trash-alt"></i></b> </a>
                                            <a href="#" v-show="i+1==list_qua_trinh_luong.length" title="thêm"
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
        watch: {
        },
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
            ganDuLieuSME(){
                let tmp = localStorage["danh_sach_ngach_hang_moet_code_sme"];
                if(tmp){
                this.list_ma_ngach_hang = JSON.parse(localStorage["danh_sach_ngach_hang_moet_code_sme"]);
                this.list_bac_luong = JSON.parse(localStorage["danh_sach_bac_luong_moet_code_sme"]);
                }
            },
            chonHeSoLuong(e,b){
                console.log("chọn hết số lương");
                console.log(e);
                console.log("****");
                console.log(JSON.stringify(this.list_qua_trinh_luong[b]));
                this.list_qua_trinh_luong[b].heSoLuong= e;
            },
            resetQt(){

                    for (let i = 0; i < this.list_qua_trinh_luong.length; i++) {
                        if (!this.list_qua_trinh_luong[i].maNgach) {
                            this.$alertify.error("Thiếu ngạch/hạng");
                            return;
                        }
                        if (!this.list_qua_trinh_luong[i].maBacLuong) {
                            this.$alertify.error("Thiếu bậc lương");
                            return;
                        }
                        if (!this.list_qua_trinh_luong[i].heSoLuong) {
                            this.$alertify.error("Thiếu hệ số lương");
                            return;
                        }
                    }
                    let obj = {
                        qtl:this.list_qua_trinh_luong,
                    };

                utils.confirmDialog("Xác nhận lưu lại thông tin", "Đồng ý", () => {
                    this.$emit('success', obj);
                })
            },
            themItemBdDt(e) {
                if (this.list_qua_trinh_luong.length == 0) {
                    let obj = {
                        ngayThangNam: "",
                        maNgach: "",
                        maBacLuong: "",
                        heSoLuong: "",
                        phanTramVuotKhung: "",
                        maVbChungChi: "",
                    }
                    this.list_qua_trinh_luong.push(obj);
                } else {
                    for (let i = 0; i < this.list_qua_trinh_luong.length; i++) {
                        if (!this.list_qua_trinh_luong[i].maNgach) {
                            this.$alertify.error("Thiếu ngạch/hạng");
                            return;
                        }
                        if (!this.list_qua_trinh_luong[i].maBacLuong) {
                            this.$alertify.error("Thiếu bậc lương");
                            return;
                        }
                        if (!this.list_qua_trinh_luong[i].heSoLuong) {
                            this.$alertify.error("Thiếu hệ số lương");
                            return;
                        }
                    }
                    let obj = {
                        ngayThangNam: "",
                        maNgach: "",
                        maBacLuong: "",
                        heSoLuong: "",
                        phanTramVuotKhung: "",
                        maVbChungChi: "",
                    }
                    this.list_qua_trinh_luong.push(obj);
                }
            },
            xoaItemDtBd(e) {
                console.log("xóa ở vị trí:" + e);
                this.list_qua_trinh_luong.splice(e, 1);
            },
            close() {
                let obj = {
                    qtl: this.list_qua_trinh_luong,
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

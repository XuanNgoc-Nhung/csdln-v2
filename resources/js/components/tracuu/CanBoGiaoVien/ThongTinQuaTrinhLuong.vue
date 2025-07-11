<template>
    <div>
        <el-dialog title="Quá trình lương" :visible.sync="show" top="5vh" width="80%"
            :close-on-click-modal="false" append-to-body :close-on-press-escape="false" :before-close="handleClose">
            <form>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <label class="table-name">Danh sách quá trình lương</label>
                    </el-col>
                    <el-col :span="24">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="cg">
                                        <p>STT1</p>
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
                                    <!-- <th class="cg">
                                        <p>Thao tác</p>
                                    </th> -->
                                </tr>
                            </thead>
                            <tbody v-if="list_qua_trinh_luong.length==0">
                                <tr>
                                    <td class="cg bt" colspan="9">
                                        <p>Không có bản ghi nào</p>
                                        <!-- <el-tooltip content="Thêm" placement="top">
                                            <el-button plain size="mini" @click.prevent="themItemBdDt()"
                                                icon="el-icon-plus" type="primary"> Thêm
                                            </el-button>
                                        </el-tooltip> -->
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_qua_trinh_luong" :key="i">
                                    <td class="cg">
                                        <p>{{i+1}}</p>
                                    </td>
                                    <td>
                                        <date-picker v-model="item.NgayThangNam" valueType="format"
                                            format="DD/MM/YYYY"></date-picker>
                                    </td>
                                    <td>
                                        <el-select v-model="item.MaNgach" style="min-width:200px" filterable
                                            collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                            no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="item in list_ma_ngach_hang" :key="item.value"
                                                :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </td>
                                    <td>
                                        <el-select v-model="item.MaBacLuong" style="min-width:200px" filterable
                                            collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                            no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="item in list_bac_luong" :key="item.value"
                                                :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" v-model="item.HeSoLuong"
                                            placeholder="Nhập...">
                                    </td>
                                    <td>
                                        <input type="number"
                                            @input="item.PhanTramVuotKhung = Math.round(item.PhanTramVuotKhung);"
                                            placeholder="Nhập số nguyên dương" class="form-control"
                                            v-model="item.PhanTramVuotKhung" />
                                    </td>
                                    <!-- <td class="text-center">

                                        <el-tooltip content="Xóa" placement="top">
                                            <i class="el-icon-delete" @click.prevent="xoaItemDtBd(i)"></i>
                                        </el-tooltip>
                                        <el-tooltip v-show="i+1==list_qua_trinh_luong.length" content="Thêm"
                                            placement="top">
                                            <i class="el-icon-plus" @click.prevent="themItemBdDt(i)"></i>
                                        </el-tooltip>
                                    </td> -->
                                </tr>
                            </tbody>
                        </table>
                    </el-col>
                </el-row>
                <div class="modal-content" v-if='false'>
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
                                            <!-- <th class="cg">
                                                <p>Thao tác</p>
                                            </th> -->
                                        </tr>
                                    </thead>
                                    <tbody v-if="list_qua_trinh_luong.length==0">
                                        <tr>
                                            <td class="cg bt" colspan="9">
                                                <p>Không có bản ghi nào</p>
                                                <!-- <el-tooltip content="Thêm" placement="top">
                                                    <el-button plain size="mini" @click.prevent="themItemBdDt()"
                                                        icon="el-icon-plus" type="primary"> Thêm
                                                    </el-button>
                                                </el-tooltip> -->
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr v-for="(item,i) in list_qua_trinh_luong" :key="i">
                                            <td class="cg">
                                                <p>{{i+1}}</p>
                                            </td>
                                            <td>
                                                <date-picker v-model="item.NgayThangNam" valueType="format"
                                                    format="DD/MM/YYYY"></date-picker>
                                            </td>
                                            <td>
                                                <el-select v-model="item.MaNgach" style="min-width:200px" filterable
                                                    collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="item in list_ma_ngach_hang" :key="item.value"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </td>
                                            <td>
                                                <el-select v-model="item.MaBacLuong" style="min-width:200px" filterable
                                                    collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                    no-match-text="Không có dữ liệu phù hợp">
                                                    <el-option v-for="item in list_bac_luong" :key="item.value"
                                                        :label="item.name" :value="item.value">
                                                    </el-option>
                                                </el-select>
                                            </td>
                                            <td>
                                                <input type="number" class="form-control" v-model="item.HeSoLuong"
                                                    placeholder="Nhập...">
                                            </td>
                                            <td>
                                                <input type="number"
                                                    @input="item.phanTramVuotKhung = Math.round(item.phanTramVuotKhung);"
                                                    placeholder="Nhập số nguyên dương" class="form-control"
                                                    v-model="item.phanTramVuotKhung" />
                                            </td>
                                            <!-- <td class="text-center">

                                                <el-tooltip content="Xóa" placement="top">
                                                    <i class="el-icon-delete" @click.prevent="xoaItemDtBd(i)"></i>
                                                </el-tooltip>
                                                <el-tooltip v-show="i+1==list_qua_trinh_luong.length" content="Thêm"
                                                    placement="top">
                                                    <i class="el-icon-plus" @click.prevent="themItemBdDt(i)"></i>
                                                </el-tooltip>

                                            </td> -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <el-button size="mini" class="dts-button-close" style="margin-right:5px" data-dismiss="modal">
                            Đóng
                        </el-button>
                        <!-- <el-button type="primary" size="mini" @click.prevent="resetQt()">Lưu lại </el-button> -->
                    </div>
                </div>
            </form>
            
            <span slot="footer" class="dialog-footer">
                <el-button class="bt-phu" type="default" @click="handleClose" size="mini">Đóng</el-button>
                <!-- <el-button class="bt-chinh" size="mini" type="primary"
                    @click.prevent="resetQt()">Lưu</el-button> -->
            </span>
        </el-dialog>
    </div>

</template>
<script>
    import rest_api from '../../../utils/rest_api';
    import moment from 'moment'
    import datePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import utils from '../../../utils';
    export default {
        props: ['item','show'],
        watch: {
        show(newValue) {
        if (newValue) {
            this.list_qua_trinh_luong = this.item
        }
        }
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
            console.log(this.list_qua_trinh_luong)
            $("#modal_nl").modal();
            $(this.$refs.modal_nl).on("hidden.bs.modal", this.close);
        },
        methods: {
            thongBao(t, e) {
                let msg = "";
                let cl = "";
                if (e) {
                    msg = e;
                }
                let type = "success";
                if (t) {
                    type = t
                }
                if (type == "success") {
                    cl = "dts-noty-success"
                }
                if (type == "warning") {
                    cl = "dts-noty-warning"
                }
                if (type == "error") {
                    cl = "dts-noty-error"
                }
                if (type == "info") {
                    cl = "dts-noty-info"
                }
                this.$message({
                    customClass: cl,
                    showClose: true,
                    message: msg,
                    type: t,
                    duration: 5000
                });
            },
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_ngach_hang_moet_code_sme"];
                if (tmp) {
                    this.list_ma_ngach_hang = JSON.parse(localStorage["danh_sach_ngach_hang_moet_code_sme"]);
                    this.list_bac_luong = JSON.parse(localStorage["danh_sach_bac_luong_moet_code_sme"]);
                }
            },
            chonHeSoLuong(e, b) {
                console.log("chọn hết số lương");
                console.log(e);
                console.log("****");
                console.log(JSON.stringify(this.list_qua_trinh_luong[b]));
                this.list_qua_trinh_luong[b].HeSoLuong = e;
            },
            resetQt() {
                for (let i = 0; i < this.list_qua_trinh_luong.length; i++) {
                    if (!this.list_qua_trinh_luong[i].MaNgach) {
                        this.thongBao("error", "Thiếu ngạch/hạng");
                        return;
                    }
                    if (!this.list_qua_trinh_luong[i].MaBacLuong) {
                        this.thongBao("error", "Thiếu bậc lương");
                        return;
                    }
                    if (!this.list_qua_trinh_luong[i].HeSoLuong) {
                        this.thongBao("error", "Thiếu hệ số lương");
                        return;
                    }
                }
                let obj = {
                    qtl: this.list_qua_trinh_luong,
                };

                this.$confirm('Xác nhận lưu lại thông tin?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.$emit('success', obj);
                    })
                    .catch(_ => {});
            },
            handleClose(){
                console.log('handleClose');
                this.close();
                
            },
            themItemBdDt(e) {
                if (this.list_qua_trinh_luong.length == 0) {
                    let obj = {
                        NgayThangNam: "",
                        MaNgach: "",
                        MaBacLuong: "",
                        HeSoLuong: "",
                        phanTramVuotKhung: "",
                        maVbChungChi: "",
                    }
                    this.list_qua_trinh_luong.push(obj);
                } else {
                    for (let i = 0; i < this.list_qua_trinh_luong.length; i++) {
                        if (!this.list_qua_trinh_luong[i].MaNgach) {
                            this.thongBao("error", "Thiếu ngạch/hạng");
                            return;
                        }
                        if (!this.list_qua_trinh_luong[i].MaBacLuong) {
                            this.thongBao("error", "Thiếu bậc lương");
                            return;
                        }
                        if (!this.list_qua_trinh_luong[i].HeSoLuong) {
                            this.thongBao("error", "Thiếu hệ số lương");
                            return;
                        }
                    }
                    let obj = {
                        NgayThangNam: "",
                        MaNgach: "",
                        MaBacLuong: "",
                        HeSoLuong: "",
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

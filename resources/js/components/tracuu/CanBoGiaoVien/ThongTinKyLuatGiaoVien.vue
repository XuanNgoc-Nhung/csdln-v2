<template>
    <div>
        <el-dialog title="Quá trình kỷ luật" :visible.sync="show" top="5vh" width="80%" :close-on-click-modal="false"
            append-to-body :close-on-press-escape="false" :before-close="handleClose">
            <form>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <label class="table-name">Danh sách thông tin kỷ luật</label>
                    </el-col>
                    <el-col :span="24">

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
                                    <!-- <th class="cg">
                                        <p>Thao tác</p>
                                    </th> -->
                                </tr>
                            </thead>
                            <tbody v-if="list_ky_luat.length==0">
                                <tr>
                                    <td class="cg bt" colspan="8">
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
                                <tr v-for="(item,i) in list_ky_luat" :key="i">
                                    <td class="cg">
                                        <p>{{i+1}}</p>
                                    </td>
                                    <td>
                                        <el-select v-model="item.maKyLuatGv" style="min-width:200px" filterable
                                            collapse-tags placeholder="Chọn" no-data-text="Không có dữ liệu"
                                            no-match-text="Không có dữ liệu phù hợp">
                                            <el-option v-for="item in list_ky_luat_giao_vien" :key="item.value"
                                                :label="item.name" :value="item.value">
                                            </el-option>
                                        </el-select>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="item.capKyLuat"
                                            placeholder="Nhập...">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="item.soQuyetDinhKyLuat"
                                            placeholder="Nhập...">
                                    </td>
                                    <td>
                                        <date-picker v-model="item.ngayKyLuat" valueType="format" format="DD/MM/YYYY">
                                        </date-picker>
                                    </td>
                                    <td class="text-center">

                                        <!-- <el-tooltip content="Xóa" placement="top">
                                            <i class="el-icon-delete" @click.prevent="xoaItemDtBd(i)"></i>
                                        </el-tooltip>
                                        <el-tooltip v-show="i+1==list_ky_luat.length" content="Thêm" placement="top">
                                            <i class="el-icon-plus" @click.prevent="themItemBdDt(i)"></i>
                                        </el-tooltip> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </el-col>
                </el-row>
            </form>

            <span slot="footer" class="dialog-footer">
                <el-button class="bt-phu" type="default" @click="handleClose" size="mini">Đóng</el-button>
                <!-- <el-button class="bt-chinh" size="mini" type="primary" @click.prevent="resetQt()">Lưu</el-button> -->
            </span>
        </el-dialog>
        <div v-if="false" id="modal_kt" ref="modal_kt" class="modal fade" style="font-size:18px;">
            <div class="modal-dialog" style="width:95%">
                <form>
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
                                                <th class="cg">
                                                    <p>Thao tác</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_ky_luat.length==0">
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
                                            <tr v-for="(item,i) in list_ky_luat" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.maKyLuatGv" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_ky_luat_giao_vien"
                                                            :key="item.value" :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" v-model="item.capKyLuat"
                                                        placeholder="Nhập...">
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control"
                                                        v-model="item.soQuyetDinhKyLuat" placeholder="Nhập...">
                                                </td>
                                                <td>
                                                    <date-picker v-model="item.ngayKyLuat" valueType="format"
                                                        format="DD/MM/YYYY"></date-picker>
                                                </td>
                                                <td class="text-center">
<!-- 
                                                    <el-tooltip content="Xóa" placement="top">
                                                        <i class="el-icon-delete" @click.prevent="xoaItemDtBd(i)"></i>
                                                    </el-tooltip>
                                                    <el-tooltip v-show="i+1==list_ky_luat.length" content="Thêm"
                                                        placement="top">
                                                        <i class="el-icon-plus" @click.prevent="themItemBdDt(i)"></i>
                                                    </el-tooltip> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <el-button size="mini" class="dts-button-close" style="margin-right:5px"
                                data-dismiss="modal">
                                Đóng
                            </el-button>
                            <el-button type="primary" size="mini" @click.prevent="resetQt()">Lưu lại </el-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import utils from '../../../utils';
    export default {
        props: ['item', 'show'],
        watch: {},
        components: {},
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
            handleClose(){
                console.log('handleClose');
                this.close();
                
            },
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_ky_luat_can_bo_moet_code_sme"];
                if (tmp) {
                    this.list_ky_luat_giao_vien = JSON.parse(localStorage["danh_sach_ky_luat_can_bo_moet_code_sme"]);
                }
            },
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
            resetQt() {
                for (let i = 0; i < this.list_ky_luat.length; i++) {
                    if (!this.list_ky_luat[i].maKyLuatGv) {
                        this.thongBao("error", "Thiếu mã kỷ luật");
                        return;
                    }
                }
                let obj = {
                    lkt: this.list_ky_luat,
                };

                this.$confirm('Xác nhận lưu lại thông tin?', 'Thông báo', {
                        confirmButtonText: 'Lưu',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.$emit('success', obj);
                    })
                    .catch(_ => {});
            },
            themItemBdDt(e) {
                if (this.list_ky_luat.length == 0) {
                    let obj = {
                        maKyLuatGv: "",
                        capKyLuat: "",
                        soQuyetDinhKyLuat: "",
                        ngayKyLuat: "",
                    }
                    this.list_ky_luat.push(obj);
                } else {
                    for (let i = 0; i < this.list_ky_luat.length; i++) {
                        if (!this.list_ky_luat[i].maKyLuatGv) {
                            this.thongBao("error", "Thiếu mã kỷ luật");
                            return;
                        }
                    }
                    let obj = {
                        maKyLuatGv: "",
                        capKyLuat: "",
                        soQuyetDinhKyLuat: "",
                        ngayKyLuat: "",
                    }
                    this.list_ky_luat.push(obj);
                }
            },
            xoaItemDtBd(e) {
                console.log("xóa ở vị trí:" + e);
                this.list_ky_luat.splice(e, 1);
            },
            close() {
                let obj = {
                    lkt: this.list_ky_luat,
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

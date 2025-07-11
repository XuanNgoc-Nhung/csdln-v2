<template>
    <div>
        <el-dialog title="Quá trình ngoại ngữ" :visible.sync="show" top="5vh" width="80%"
            :close-on-click-modal="false" append-to-body :close-on-press-escape="false" :before-close="handleClose">
            <form>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <label class="table-name">Danh sách quá trình ngoại ngữ</label>
                    </el-col>
                    <el-col :span="24">
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
                                        <el-tooltip content="Thêm" placement="top">
                                            <el-button plain size="mini" @click.prevent="themItemBdDt()"
                                                icon="el-icon-plus" type="primary"> Thêm
                                            </el-button>
                                        </el-tooltip>
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
                                        <el-select v-model="item.maTrinhDoNgoaiNgu" style="min-width:200px"
                                            filterable collapse-tags placeholder="Chọn"
                                            no-data-text="Không có dữ liệu"
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
                                        <date-picker v-model="item.ngayCap" valueType="format"
                                            value-type="DD/MM/YYYY" format="DD/MM/YYYY"></date-picker>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" v-model="item.ghiChu"
                                            placeholder="Nhập...">
                                    </td>
                                    <td class="text-center">
                                        <el-tooltip content="Xóa" placement="top">
                                            <i class="el-icon-delete" @click.prevent="xoaItemDtBd(i)"></i>
                                        </el-tooltip>
                                        <el-tooltip v-show="i+1==list_dao_tao_ngoai_ngu.length" content="Thêm" placement="top">
                                            <i class="el-icon-plus" @click.prevent="themItemBdDt(qh)"></i>
                                        </el-tooltip>
                                        <!-- <el-tooltip content="Xóa" placement="left">
                                            <i plain size="mini" @click.prevent="xoaItemDtBd(i)"
                                                icon="el-icon-delete" type="danger">
                                            </i>
                                        </el-tooltip>
                                        <el-tooltip v-show="i+1==list_dao_tao_ngoai_ngu.length" content="Thêm"
                                            placement="top">
                                            <i plain size="mini" @click.prevent="themItemBdDt(i)"
                                                icon="el-icon-plus" type="primary">
                                            </i>
                                        </el-tooltip> -->
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </el-col>
                </el-row>
            </form>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="default" style="margin-right:5px" @click.prevent="handleClose()">Đóng
                </el-button>
                <el-button type="primary" size="mini" @click.prevent="resetQt">Lưu
                </el-button>
            </span>
        </el-dialog>

        <div v-if="false" id="modal_kt" ref="modal_kt" class="modal fade" style="font-size:18px;">
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
                                                    <el-tooltip content="Thêm" placement="top">
                                                        <el-button plain size="mini" @click.prevent="themItemBdDt()"
                                                            icon="el-icon-plus" type="primary"> Thêm
                                                        </el-button>
                                                    </el-tooltip>
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
                                                    <el-select v-model="item.maTrinhDoNgoaiNgu" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
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
                                                    <date-picker v-model="item.ngayCap" valueType="format"
                                                        value-type="DD/MM/YYYY" format="DD/MM/YYYY"></date-picker>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" v-model="item.ghiChu"
                                                        placeholder="Nhập...">
                                                </td>
                                                <td class="text-center">
                                                    <el-tooltip content="Xóa" placement="top">
                                                        <i class="el-icon-delete" @click.prevent="xoaItemDtBd(i)"></i>
                                                    </el-tooltip>
                                                    <el-tooltip v-show="i+1==list_dao_tao_ngoai_ngu.length" content="Thêm" placement="top">
                                                        <i class="el-icon-plus" @click.prevent="themItemBdDt(qh)"></i>
                                                    </el-tooltip>
                                                    <!-- <el-tooltip content="Xóa" placement="left">
                                                        <i plain size="mini" @click.prevent="xoaItemDtBd(i)"
                                                            icon="el-icon-delete" type="danger">
                                                        </i>
                                                    </el-tooltip>
                                                    <el-tooltip v-show="i+1==list_dao_tao_ngoai_ngu.length" content="Thêm"
                                                        placement="top">
                                                        <i plain size="mini" @click.prevent="themItemBdDt(i)"
                                                            icon="el-icon-plus" type="primary">
                                                        </i>
                                                    </el-tooltip> -->
                                                </td>
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
                            <el-button type="primary" size="mini" @click.prevent="resetQt()">Lưu lại </el-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import datePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    export default {
        props: ['item','show'],
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
            handleClose(){
                console.log('handleClose');
                this.close();
                
            },
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_ngoai_ngu_chinh_moet_code_sme"];
                if (tmp) {
                    this.list_ma_ngoai_ngu = JSON.parse(localStorage["danh_sach_ngoai_ngu_chinh_moet_code_sme"]);
                    this.list_trinh_do_ngoai_ngu = JSON.parse(localStorage[
                        "danh_sach_trinh_do_ngoai_ngu_sme"]);
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
                for (let i = 0; i < this.list_dao_tao_ngoai_ngu.length; i++) {
                    if (!this.list_dao_tao_ngoai_ngu[i].maNgoaiNgu) {
                        this.thongBao("error", "Thiếu mã ngoại ngữ");
                        return;
                    }
                }
                let obj = {
                    lnn: this.list_dao_tao_ngoai_ngu,
                };

                this.$confirm('Xác nhận lưu lại thông tin?', 'Thông báo', {
                        confirmButtonText: 'Lưu lại',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.$emit('success', obj);
                    })
                    .catch(_ => {});
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
                            this.thongBao("error", "Thiếu mã ngoại ngữ");
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

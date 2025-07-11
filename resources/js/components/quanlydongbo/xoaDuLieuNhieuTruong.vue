<template>
    <div v-loading.fullscreen.lock="fullScreenLoading" element-loading-text="Loading..."
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog title="Xóa dữ liệu" :visible.sync="show" width="60%" top="10vh" :close-on-click-modal="false"
            :close-on-press-escape="false" :before-close="handleClose">
            <form>
                <el-row :gutter="24">
                    <el-col :sm="8" :lg="3" style="padding-right:0px !important">
                        <label style="margin-bottom: 8px !important;">Năm học</label>
                        <eselect style="width:100%" :disabled="true" v-model="namHocDay" :placeholder="'Chọn'"
                            filterable :data="list_years" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="8" :lg="3" style="padding-right:0px !important; padding-left:8px !important">
                        <label style="margin-bottom: 8px !important;">Học kỳ</label>
                        <eselect style="width:100%" :disabled="true" v-model="hocKy" :placeholder="'Chọn'" filterable
                            :data="list_hoc_ky" :fields="['name','id']" />
                    </el-col>
                    <el-col :span="24">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead style="background: #e4ebf5">
                                    <tr>
                                        <th class="text-center">
                                            <p>STT</p>
                                        </th>
                                        <th >
                                            <p>Mã trường học</p>
                                        </th>
                                        <th >
                                            <p>Tên trường học</p>
                                        </th>
                                        <th >
                                            <p>Dữ liệu xóa</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="dsTruongDayLai.length==0">
                                    <tr>
                                        <td class="text-center" colspan="17">
                                            <p>Không có bản ghi nào được tìm thấy</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else="v-else">
                                    <tr v-for="(tg,index) in dsTruongDayLai">
                                        <td class="text-center">
                                            <p>{{index+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.maTruong}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.tenTruong}}</p>
                                        </td>
                                        <td>
                                            <template v-for="(bd,indexBd) in tg.buocDays">
                                                <p>
                                                    {{getNameBuocDay(bd)}};
                                                </p>
                                            </template>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </el-col>
                </el-row>
            </form>
            <span slot="footer" class="dialog-footer">
                <el-button class="bt-phu" type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button class="" size="mini" type="danger" @click.prevent="BatDauDayLai()">Xóa
                </el-button>
            </span>
            <div v-if='false'>
                <div class="form-group clearfix">
                    <label style="">Năm học:</label>
                    <select disabled v-model="namHocDay" style="background:#d6d6d6">
                        <option value="">Chọn năm học</option>
                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                    </select>
                    <label style="">Học kỳ:</label>
                    <select disabled v-model="hocKy" style="background:#d6d6d6">
                        <option value="">Chọn học kỳ</option>
                        <option value="1">Học kỳ I</option>
                        <option value="2">Học kỳ II</option>
                        <option value="3">Cả năm</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead style="background: #e4ebf5">
                                    <tr>
                                        <th class="text-center">
                                            <p>STT</p>
                                        </th>
                                        <th >
                                            <p>Mã trường học</p>
                                        </th>
                                        <th >
                                            <p>Tên trường học</p>
                                        </th>
                                        <th >
                                            <p>Dữ liệu xóa</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="dsTruongDayLai.length==0">
                                    <tr>
                                        <td class="text-center" colspan="17">
                                            <p>Không có bản ghi nào được tìm thấy</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else="v-else">
                                    <tr v-for="(tg,index) in dsTruongDayLai">
                                        <td class="text-center">
                                            <p>{{index+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.maTruong}}</p>
                                        </td>
                                        <td>
                                            <p>{{tg.tenTruong}}</p>
                                        </td>
                                        <td>
                                            <template v-for="bd in tg.buocDays">
                                                <p>
                                                    {{getNameBuocDay(bd)}};
                                                </p>
                                            </template>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <el-dialog width="50%" title="Kết quả xóa dữ liệu" :visible.sync="show_ket_qua" append-to-body>
                <form>
                    <el-row :gutter="24">
                        <el-col :span="24">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead style="background: #e4ebf5">
                                        <tr class="text-center">
                                            <td>
                                                <p>STT</p>
                                            </td>
                                            <td>
                                                <p>Mã trường</p>
                                            </td>
                                            <td>
                                                <p>Tên trường</p>
                                            </td>
                                            <td>
                                                <p>Dữ liệu</p>
                                            </td>
                                            <td>
                                                <p>Nội dung</p>
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody v-if="thongBaoXoaDuLieu.length>0">
                                        <tr v-for="(it,i) in thongBaoXoaDuLieu" :key="i" class="text-center">
                                            <td>
                                                <p>{{i+1}}</p>
                                            </td>
                                            <td class="text-left">
                                                <p>{{it.maTruong}}</p>
                                            </td>
                                            <td class="text-left">
                                                <p>{{it.tenTruong}}</p>
                                            </td>
                                            <td class="text-left">
                                                <template v-for="(bd,i) in it.buocDays">
                                                    <p>{{getNameBuocDay(bd)}};
                                                    </p>
                                                </template>
                                            </td>
                                            <td class="text-left">
                                                <p>{{it.message}}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr class="text-center">
                                            <td colspan="6">
                                                <p>Không có bản ghi nào</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </el-col>
                    </el-row>
                </form>
                <span slot="footer" class="dialog-footer">
                    <el-button type="default" @click="show_ket_qua = false" size="mini">Đóng</el-button>
                </span>
            </el-dialog>
        </el-dialog>
        <div v-if="false" id="modal_xoa_du_lieu" ref="modal_xoa_du_lieu" class="modal fade">
            <div class="modal-dialog" style="width:75%">
                <div class="modal-content">
                    <form>
                        <div class="modal-header text-uppercase">
                            <h4>Xóa dữ liệu</h4>
                        </div>
                        <div class="modal-body clearfix">
                            <div>
                                <div class="form-group clearfix">
                                    <label style="">Năm học:</label>
                                    <select disabled v-model="namHocDay" style="background:#d6d6d6">
                                        <option value="">Chọn năm học</option>
                                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                    </select>
                                    <label style="">Học kỳ:</label>
                                    <select disabled v-model="hocKy" style="background:#d6d6d6">
                                        <option value="">Chọn học kỳ</option>
                                        <option value="1">Học kỳ I</option>
                                        <option value="2">Học kỳ II</option>
                                        <option value="3">Cả năm</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive" style="height:50vh;">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead style="background: #e4ebf5">
                                                    <tr>
                                                        <th class="text-center">
                                                            <p>STT</p>
                                                        </th>
                                                        <th >
                                                            <p>Mã trường học</p>
                                                        </th>
                                                        <th >
                                                            <p>Tên trường học</p>
                                                        </th>
                                                        <th >
                                                            <p>Dữ liệu xóa</p>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="dsTruongDayLai.length==0">
                                                    <tr>
                                                        <td class="text-center" colspan="17">
                                                            <p>Không có bản ghi nào được tìm thấy</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(tg,index) in dsTruongDayLai">
                                                        <td class="text-center">
                                                            <p>{{index+1}}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{tg.maTruong}}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{tg.tenTruong}}</p>
                                                        </td>
                                                        <td>
                                                            <template v-for="bd in tg.buocDays">
                                                                <span>{{getNameBuocDay(bd)}};
                                                                </span>
                                                            </template>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <el-button type="default" size="mini" data-dismiss="modal">Hủy
                            </el-button>
                            <el-button type="danger" size="mini" @click.prevent="BatDauDayLai">Xóa
                            </el-button>
                        </div>
                    </form>
                </div>

            </div>
            <template v-if="false">
                <div>
                    <div id="modal_them_dantoc" ref="modal_them_dantoc" class="modal fade">
                        <div class="modal-dialog" style="width:55%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Thông báo</h4>
                                </div>
                                <div class="modal-body clearfix">
                                    <div>
                                        <div class="form-group clearfix">
                                            <div>
                                                <div class="table-responsive" style="height:40vh">
                                                    <table class="table table-bordered tbl-custom">
                                                        <thead style="background: #e4ebf5">
                                                            <tr class="text-center">
                                                                <td>
                                                                    <p>STT</p>
                                                                </td>
                                                                <td>
                                                                    <p>Mã trường</p>
                                                                </td>
                                                                <td>
                                                                    <p>Tên trường</p>
                                                                </td>
                                                                <td>
                                                                    <p>Dữ liệu</p>
                                                                </td>
                                                                <td>
                                                                    <p>Nội dung</p>
                                                                </td>
                                                            </tr>
                                                        </thead>
                                                        <tbody v-if="thongBaoXoaDuLieu.length>0">
                                                            <tr v-for="(it,i) in thongBaoXoaDuLieu" :key="i"
                                                                class="text-center">
                                                                <td>
                                                                    <p>{{i+1}}</p>
                                                                </td>
                                                                <td class="text-left">
                                                                    <p>{{it.maTruong}}</p>
                                                                </td>
                                                                <td class="text-left">
                                                                    <p>{{it.tenTruong}}</p>
                                                                </td>
                                                                <td class="text-left">
                                                                    <template v-for="(bd,i) in it.buocDays">
                                                                        <span>{{getNameBuocDay(bd)}};
                                                                        </span>
                                                                    </template>
                                                                </td>
                                                                <td class="text-left">
                                                                    <p>{{it.message}}</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tbody v-else>
                                                            <tr class="text-center">
                                                                <td colspan="6">
                                                                    <p>Không có bản ghi nào</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer clearfix">
                                    <button type="button" class="btn btn-default" @click="doneDelete()">Đóng
                                    </button>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </template>

        </div>
    </div>

</template>

<script>
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    import constant from "../../utils/constant";
    import eselect from "../ui/ESelect.vue";

    export default {

        props: [
            'show', 'item', 'namhoc', 'hocky'
        ],
        components: {
            eselect
        },

        watch: {
            show: function (newVal, oldVal) {
                // if (newVal) {
                //     console.log("có dữ liệu mmowis");
                //     $("#modal_xoa_du_lieu").modal();
                // } else {
                //     $("#modal_xoa_du_lieu").modal('hide');
                // }
            },
            item: function (newVal, oldVal) {
                console.log("bản ghi:" + JSON.stringify(newVal));
                this.dsTruongDayLai = newVal
            },
            namhoc: function (newVal, oldVal) {
                console.log("bản ghi:" + JSON.stringify(newVal));
                this.namHocDay = newVal
            },
            hocky: function (newVal, oldVal) {
                console.log("bản ghi:" + JSON.stringify(newVal));
                this.hocKy = newVal
            }
        },

        data() {
            return {
                list_hoc_ky: constant.LIST_HOC_KY,
                dsTruongDayLai: [],
                dsTruongDayLais: [],
                list_years: constant.LIST_YEARS_FULL,
                thongBaoXoaDuLieu: [],
                namHocDay: "",
                hocKy: "",
                show_ket_qua: false,
                fullScreenLoading: false,
            }
        },
        mounted: function () {},

        methods: {
            handleClose() {
                this.close();
                // this.reset()
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
            BatDauDayLai() {
                let truongHocMap = this
                    .dsTruongDayLai
                    .map((obj) => {
                        return {
                            tenTruong: obj.tenTruong,
                            show_truong_da_xoa: false,
                            maTruong: obj.maTruong,
                            buocDays: obj.buocDays
                        }
                    });
                this.dsTruongDayLais = truongHocMap;
                if (this.dsTruongDayLais.length == 0) {

                    this
                        .$alertify
                        .error("Vui lòng quay và chọn dữ liệu cần xóa.");
                    return
                };
                if (this.namHocDay == "") {
                    this
                        .$alertify
                        .error("Vui lòng bổ sung năm học.");
                    return;
                }
                if (this.hocKy == "") {
                    this
                        .$alertify
                        .error("Vui lòng bổ sung học kỳ.");
                    return;
                }
                if (this.hocKy == "") {
                    this
                        .$alertify
                        .error("Vui lòng bổ sung học kỳ.");
                    return;
                }
                this.$confirm('Xác nhận xóa dữ liệu?', 'Xóa dữ liệu', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass: 'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.thongBaoXoaDuLieu = [];
                        const params = {
                            "hocKy": parseInt(this.hocKy),
                            "deleteTruongs": this.dsTruongDayLais,
                            "namHoc": this.namHocDay
                        };
                        this.fullScreenLoading = true;
                        rest_api.post("/csdlgd-admin/DataTruong/delete", params, (data) => {
                            this.fullScreenLoading = false;
                            if (data.data.rc == 0) {
                                this.thongBao('success', data.data.rd)
                                this.thongBaoXoaDuLieu = data.data.rows;
                                this.show_ket_qua = true;
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});

            },
            getNameBuocDay(e) {
                switch (e) {
                    case 1:
                        return ("Trường học");
                        break;
                    case 2:
                        return ("Cán bộ");
                        break;
                    case 4:
                        return ("Học sinh");
                        break;
                    case 3:
                        return ("Lớp học");
                        break;
                    case 51:
                        return ("Kết quả học tập giữa kỳ");
                        break;
                    case 52:
                        return ("Kết quả học tập cuối kỳ");
                        break;

                    case 6:
                        return ("Khen thưởng");
                        break;
                    case 7:
                        return ("Hoàn thành chương trình mầm non");
                        break;
                    case 8:
                        return ("Xét tốt nghiệp");
                        break;
                    case 9:
                        return ("Nhập điểm thi lại");
                        break;
                    case 10:
                        return ("Thí sinh tự do");
                        break;
                    case 11:
                        return ("EQMS đầu năm");
                        break;
                    case 12:
                        return ("EQMS giữa năm");
                        break;
                    case 13:
                        return ("EQMS cuối năm");
                        break;
                    case 14:
                        return ("Đánh giá chuẩn nghề nghiệp");
                        break;
                }
            },

            doneDelete() {
                this.$emit('successDay');
            },
            close() {
                console.log("hàm close");
                this.$emit('dongmodal')
            },
            reset() {
                this.$emit('successDay');
            }
        }

    }

</script>
<style scoped="scoped">
    h4,
    p {
        padding: 0;
        margin: 0;
    }

    p,
    .table-responsive{
        margin-top: 0px !important;
    }

</style>

<template>
    <div>
        <el-dialog :title="'Đẩy dữ liệu lên ' + ( noiNop == 1 ? 'ioc' : 'Bộ')" :visible.sync="show" width="80%"
            :close-on-click-modal="false" append-to-body :close-on-press-escape="false" :before-close="handleClose">
            <form>
                <el-row :gutter="24">
                    <el-col :span="3" style="padding-right:0px !important;">
                        <label style="margin-bottom: 8px !important;">Năm học</label>
                        <eselect style="width:100%" :disabled="true" v-model="namHocDay" :placeholder="'Chọn'"
                            filterable :data="list_years" :fields="['name','id']" />
                    </el-col>
                    <el-col :span="3" style="padding-right:0px !important; padding-left:8px !important">
                        <label style="margin-bottom: 8px !important;">Học kỳ</label>
                        <eselect style="width:100%" :disabled="true" v-model="hocKy" :placeholder="'Chọn'" filterable
                            :data="list_hoc_ky" :fields="['name','id']" />
                    </el-col>
                    <el-col :span="24">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <p>STT</p>
                                        </th>
                                        <th class="">
                                            <p>Mã trường học</p>
                                        </th>
                                        <th class="">
                                            <p>Tên trường học</p>
                                        </th>
                                        <th class="">
                                            <p>Dữ liệu đẩy</p>
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
                                <tbody v-else>
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
                    </el-col>
                </el-row>
            </form>
            <span slot="footer" class="dialog-footer">
                <el-button class="bt-phu" type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button class="bt-chinh" size="mini" type="primary" @click.prevent="BatDauDayLai()">Đẩy dữ liệu
                </el-button>
            </span>
        </el-dialog>
        <div v-if="false" id="modal_day_lai" ref="modal_day_lai" class="modal fade">
            <div class="modal-dialog" style="width:60%">
                <div class="modal-content">
                    <form>
                        <div class="modal-header">
                            <h4>Đẩy dữ liệu lên {{ noiNop == 1 ? 'ioc' : 'bộ' }}</h4>
                        </div>
                        <div class="modal-body clearfix">
                            <div>
                                <div class="form-group clearfix row">
                                    <div class="col-md-4">
                                        <label style="">Năm học:</label>
                                        <eselect style="width:100%" :disabled="true" v-model="namHocDay"
                                            :placeholder="'Chọn'" filterable :data="list_years"
                                            :fields="['name','id']" />
                                    </div>
                                    <div class="col-md-4">
                                        <label style="">Học kỳ:</label>
                                        <eselect style="width:100%" :disabled="true" v-model="hocKy"
                                            :placeholder="'Chọn'" filterable :data="list_hoc_ky"
                                            :fields="['name','id']" />
                                    </div>
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
                                                        <th class="">
                                                            <p>Mã trường học</p>
                                                        </th>
                                                        <th class="">
                                                            <p>Tên trường học</p>
                                                        </th>
                                                        <th class="">
                                                            <p>Dữ liệu đẩy</p>
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
                                                            <p>{{ index + 1 }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ tg.maTruong }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ tg.tenTruong }}</p>
                                                        </td>
                                                        <td>
                                                            <template v-for="bd in tg.buocDays">
                                                                <span>{{ getNameBuocDay(bd) }};
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
                            <el-button type="primary" size="mini" @click.prevent="BatDauDayLai">Đẩy dữ liệu
                            </el-button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>

</template>

<script>
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    import constant from "../../utils/constant";
    import eselect from "../ui/ESelect.vue";

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {
        components: {
            eselect
        },

        props: [
            'show', 'item', 'namhoc', 'hocky', 'cap_hoc_day', 'noi-nop'
        ],

        watch: {
            show: function (newVal, oldVal) {
                // if (newVal) {
                //     console.log("có dữ liệu mmowis");
                //     $("#modal_day_lai").modal();
                // } else {
                //     $("#modal_day_lai").modal('hide');
                // }
            },
            item: function (newVal, oldVal) {
                console.log("bản ghi:" + JSON.stringify(newVal));
                this.dsTruongDayLai = newVal
            },
            namhoc: function (newVal, oldVal) {
                console.log("Năm học:" + JSON.stringify(newVal));
                this.namHocDay = newVal
            },
            hocky: function (newVal, oldVal) {
                console.log("bản ghi:" + JSON.stringify(newVal));
                this.hocKy = newVal
            }
        },

        data() {
            return {
                dsTruongDayLai: [],
                dsTruongDayLais: [],
                list_years: constant.LIST_YEARS_FULL,
                hocKy: "",
                namHocDay: "",
                list_hoc_ky: constant.LIST_HOC_KY,
            }
        },
        mounted: function () {
            console.log("mounted !!!!! 1111111111111111111111111111111111111111111");
            $(this.$refs.modal_day_lai).on("hidden.bs.modal", this.close);
        },

        methods: {

            handleClose() {
                console.log('handleClose');
                this.close();

            },
            BatDauDayLai() {
                let truongHocMap = this
                    .dsTruongDayLai
                    .map((obj) => {
                        return {
                            maTruong: obj.maTruong,
                            buocDays: obj.buocDays
                        }
                    });
                this.dsTruongDayLais = truongHocMap;

                if (this.dsTruongDayLais.length == 0) {
                    this.thongBao('error', "Vui lòng quay và chọn dữ liệu để đẩy.")
                    return

                };
                if (this.namHocDay == "") {
                    this.thongBao('error', "Vui lòng bổ sung năm học.")
                    return;
                }
                if (this.hocKy == "") {
                    this.thongBao('error', "Vui lòng bổ sung học kỳ.")
                    return;
                }
                const params = {
                    "hocKy": parseInt(this.hocKy),
                    "truongCanDayRequests": this.dsTruongDayLais,
                    "namHoc": this.namHocDay,
                    "lstCapHoc": this.cap_hoc_day,
                    "noiNop": this.noiNop ?? '',
                };
                rest_api.post("/csdlgd-admin/dayLenBo/taoYeuCau", params, (data) => {
                    console.log(JSON.stringify(data));
                    if (data.data.rc == 0) {

                        this.thongBao(
                            'success',
                            "Hệ thống đang bắt đầu đẩy dữ liệu lên " + (this.noiNop == 1 ? 'IOC' : 'Bộ') +
                            ". Vui lòng theo dõi tiến trình ở chức năng Lịch sử đẩy dữ liệu lên " + (this
                                .noiNop == 1 ? 'IOC' : 'Bộ')
                        );

                        setTimeout(() => {
                            console.log("đẩy thành công trả về");
                            this.close();
                            this.reset()
                        }, 2000);

                    } else {

                        this.thongBao('error', "Đẩy dữ liệu thất bại:" + data.data.rd)
                    }
                });
                // this.$confirm('Xác nhận thực hiện đẩy lại dữ liệu?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {})
                //     .catch(_ => {});

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
                        return ("ĐG chuẩn nghề nghiệp");
                        break;
                }
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

<template>

    <div id="modal_day_lai" ref="modal_day_lai" class="modal fade">
        <div class="modal-dialog" style="width:60%">
            <div class="modal-content">
                <form>
                    <div class="modal-header text-uppercase">
                        <h4>đẩy dữ liệu</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div>
                            <div class="form-group clearfix">
                                <label style="">Chọn năm học:</label>
                                <select disabled v-model="namHocDay" style="background:#d6d6d6">
                                    <option value="">Chọn năm học</option>
                                    <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                </select>
                                <label style="">Chọn học kỳ:</label>
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
                        <button type="button" class="btn btn-info" @click.prevent="BatDauDayLai">Đẩy
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</template>

<script>
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    import constant from "../../utils/constant";

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: [
            'show', 'item', 'namhoc', 'hocky'
        ],

        watch: {
            show: function (newVal, oldVal) {
                if (newVal) {
                    console.log("có dữ liệu mmowis");
                    $("#modal_day_lai").modal();
                } else {
                    $("#modal_day_lai").modal('hide');
                }
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
                dsTruongDayLai: [],
                dsTruongDayLais: [],
                list_years: constant.LIST_YEARS_FULL,
                hocKy: "",
                namHocDay: "",
                hocKy: ""
            }
        },
        mounted: function () {
            console.log("mounted !!!!! 1111111111111111111111111111111111111111111");
            $(this.$refs.modal_day_lai).on("hidden.bs.modal", this.close);
        },

        methods: {

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

                    this
                        .$alertify
                        .error("Vui lòng quay và chọn dữ liệu để đẩy.");
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
                this.$confirm('Xác nhận thực hiện đẩy dữ liệu?', 'Thông báo', {
                        confirmButtonText: 'Đẩy',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {

                        const params = {
                            "hocKy": parseInt(this.hocKy),
                            "truongCanDayRequests": this.dsTruongDayLais,
                            "namHoc": this.namHocDay
                        };
                        rest_api.post("/csdlgd-admin/dayLenBo/taoYeuCau", params, (data) => {
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this
                                    .$alertify
                                    .success(
                                        "Hệ thống đang bắt đầu đẩy dữ liệu lên Bộ. Vui lòng theo dõi tiến trình ở chức năng Lịch sử đẩy dữ liệu lên Bộ"
                                    );
                                setTimeout(() => {
                                    console.log("đẩy thành công trả về");
                                    this.close();
                                    this.reset()
                                }, 2000);

                            } else {
                                this
                                    .$alertify
                                    .error("Đẩy dữ liệu thất bại:" + data.data.rd);
                            }
                        });
                    })
                    .catch(_ => {});
                // utils.confirmDialog("Xác nhận thực hiện đẩy dữ liệu", "Đồng ý", () => {
                // })

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
    span {}

</style>

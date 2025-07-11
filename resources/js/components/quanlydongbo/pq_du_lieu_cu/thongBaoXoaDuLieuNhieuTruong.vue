<template>

    <div id="modal_xoa_du_lieu" ref="modal_xoa_du_lieu" class="modal fade">
        <div class="modal-dialog" style="width:60%">
            <div class="modal-content">
                <form>
                    <div class="modal-header text-uppercase">
                        <h4>Xóa dữ liệu</h4>
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
                                <select disabled v-model="hocKy"  style="background:#d6d6d6">
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
                                                    <th class="text-center">
                                                        <p>Mã trường học</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Tên trường học</p>
                                                    </th>
                                                    <th class="text-center">
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
                        <button type="button" class="btn btn-primary" @click.prevent="BatDauDayLai">Xóa
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
            'show', 'item', 'namhoc','hocky'
        ],

        watch: {
            show: function (newVal, oldVal) {
                if (newVal) {
                    console.log("có dữ liệu mmowis");
                    $("#modal_xoa_du_lieu").modal();
                } else {
                    $("#modal_xoa_du_lieu").modal('hide');
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
            return {}
        },
        mounted: function () {
                    $("#modal_xoa_du_lieu").modal();
            console.log("mounted !!!!! 1111111111111111111111111111111111111111111");
            $(this.$refs.modal_xoa_du_lieu).on("hidden.bs.modal", this.close);
        },

        methods: {
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
</style>

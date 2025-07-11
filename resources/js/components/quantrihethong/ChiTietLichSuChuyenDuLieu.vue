<template>
    <div>
        <el-dialog :title="'Phân công giảng dạy:'" :visible.sync="show"
            top="5vh" width="90%" :close-on-click-modal="false" append-to-body :close-on-press-escape="false"
            :before-close="handleClose">
            
            <span slot="title">
                <el-button class="bt-phu" type="default" @click="handleClose()" size="mini">Đóng</el-button>
                <!-- <el-button class="bt-chinh" size="mini" type="primary" @click.prevent="resetQt()">Lưu</el-button> -->
            </span>
            <form></form>
            
            <span slot="footer" class="dialog-footer">
                <el-button class="bt-phu" type="default" @click="handleClose()" size="mini">Đóng</el-button>
                <!-- <el-button class="bt-chinh" size="mini" type="primary" @click.prevent="resetQt()">Lưu</el-button> -->
            </span>
            </el-dialog>
        <div v-if="false" id="modal_detail" ref="modal_detail" class="modal fade">
            <div class="modal-dialog" style="width:90%; height:75vh">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            v-on:click="close()">&times;
                        </button>
                        <h4 class="modal-title">{{getDot(parseInt(infoDetail.loaiDot))}}: trường
                            {{infoDetail.tenTruongHoc}}
                            (MÃ:
                            {{infoDetail.maTruongHoc}}) - Năm học:{{infoDetail.namHoc}}-{{infoDetail.namHoc+1}}
                        </h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="row">
                            <div class="col-sm-4">
                                <label>Đối tác 1:</label>
                                <span>{{infoDetail.tenDoitac}}</span>
                                <br>
                                <label>Mã lần đẩy:</label>
                                <span>{{infoDetail.reqMessId}}</span>
                            </div>
                            <div class="col-sm-4">
                                <label>Duration time phản hồi:</label>
                                <span>{{infoDetail.timePhanHoi}}</span>
                                <br>
                                <label>Dữ liệu đẩy lên:</label>
                                <a @click.prevent="getInfoDetail(infoDetail.maGiaoDich,'1')" class="btn btn-info"
                                    href="#">Xem chi tiết</a>
                            </div>
                            <div class="col-sm-4">
                                <div>
                                    <label>Đợt đồng bộ:</label>
                                    <span>
                                        {{getLoaiDuLieu(infoDetail.loaiDuLieu)}}
                                    </span>
                                </div>
                                <label>Dữ liệu nhận được:</label>
                                <a @click.prevent="getInfoDetail(infoDetail.maGiaoDich,'2')" class="btn btn-info"
                                    href="#">Xem chi tiết</a>
                            </div>
                        </div>
                        <div class="row" style="height:60vh;overflow-x:scroll">
                            <div class="table-responsive row_tp">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr style="background: #e4ebf5">
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Tên dữ liệu</th>
                                            <th class="text-center">Nhận thành công</th>
                                            <th class="text-center">Nhận thất bại</th>
                                            <th class="text-center">Kết quả nhận</th>
                                            <th class="text-center">Đồng bộ thành công</th>
                                            <th class="text-center">Đồng bộ thất bại</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(ct,i) in infoDetail.listDetail">
                                            <td class="text-center">{{i+1}}</td>
                                            <td>{{ct.tableName}}.</td>
                                            <td>{{ct.numRecordRecievedSuccess}}
                                                bản ghi.
                                            </td>
                                            <td>{{ct.numRecordRecievedError}}
                                                bản ghi.
                                            </td>
                                            <td class="text-center">
                                                <!-- <input type="text" class="form-control" :value="ct.messRecievedDetail"> -->
                                                <div>
                                                    <button class="btn btn-info"
                                                        @click.prevent="getInfoDetail(ct.subId,'3',ct.tableName)">Xem chi
                                                        tiết
                                                    </button>
                                                </div>
                                            </td>
                                            <td>{{ct.numRecordSyncSuccess}}
                                                bản ghi.
                                            </td>
                                            <td>{{ct.numRecordSyncError}}
                                                bản ghi.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <el-button type="default" data-dismiss="modal">Đóng</el-button>
                    </div>
                </div>
            </div>
        </div>
        <!-- <ThongTin :hien="show_info" :thongtin="duLieuNhan" :cateday="loaiday"
        @closeinfo="show_info=false"></ThongTin> -->
        <template>
            <component :thongtin="duLieuNhan" :hien="show_info" :subId="subId" :tabname="tenBang" :cateday="loaiday" @closeinfo="show_info=false"
                :is="ThongTin"></component>
        </template>

    </div>
</template>

<script>
    import xmoment from "moment";
    import utils from "../../utils";
    import api from "../api";
    import vi from "vee-validate/dist/locale/vi";
    import rest_api from "../../utils/rest_api";
    import ThongTin from "./ChiTietNhanDuoc";
    import VeeValidate, {
        Validator
    } from "vee-validate";

    Vue.use(VeeValidate);

    $(document).ready(function () {});

    export default {
        props: [
            "item", "show"
        ],

        components: {
            ThongTin: ThongTin
        },
        watch: {
            item: function (newVal) {
                console.log("mã giao dịch thay đổi")
                this.maGiaoDich = newVal;
                // this.getDetail();
            },
            show: function (newVal) {
                if (newVal) {
                    $("#modal_detail").modal();
                    this.maGiaoDich = this.item;
                    this.getDetail();
                } else {

                    $(this.$refs.modal_detail).on("hidden.bs.modal", this.close);
                }
            }
        },

        data() {
            return {
                maGiaoDich: "",
                infoDetail: {},
                duLieuNhanDuoc: "",
                ma_giao_dich: "",
                ten_loai_dong_bo_du_lieu: "",
                ten_loai_dot_dong_bo: "",
                loai_du_lieu: "",
                ten_truong: "",
                nam_hoc: "",
                ten_doi_tac: "",
                thoi_gian_day: "",
                thoi_gian_phan_hoi: "",
                thoi_gian_dong_bo_xong: "",
                duration_time_dong_bo: "",
                duration_time_phan_hoi: "",
                ten_service: "",
                ma_lan_day: "",
                trang_thai: "",
                show_msg: false,
                show_info: false,
                loaiday: "",
                subId: "",
                duLieuNhan: "",
                ThongTin: "ThongTin",
                tenBang: ""
            };
        },

        mounted: function () {
            // $("#modal_detail").modal();
            $(this.$refs.modal_detail).on("hidden.bs.modal", this.close);

        },

        methods: {
            
            handleClose() {
                console.log('handleClose');
                this.this.close()
            },
            dongChiTietNhanDuoc() {
                // console.log("đóng chi tiết nhận được");
            },
            getDetail() {
                console.log("mã giao dịch:" + JSON.stringify(this.maGiaoDich));
                let params = {
                    id: this.maGiaoDich
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-report-api/history-syncdata/school/v2", params, data => {
                    loading.close();
                    if (data.data.rc == 0) {
                        //   console.log("lấy thành công:" + JSON.stringify(data.data));
                        this.infoDetail = data.data.item;
                        // console.log("thông tin:" + JSON.stringify(this.infoDetail));
                    } else {
                        // console.log("lấy thất bại");
                        utils.showDialog("Thất bại", data.data.rd, null, () => {});
                        return;
                    }
                });
            },
            getInfoDetail(e, type, name) {
                console.log("getInfoDetail");
                this.duLieuNhan = e;
                this.tenBang = name;
                this.subId = "";-
                this.loaiday = type;
                if(this.loaiday==3){
                    console.log(this.duLieuNhan)
                    // for(let i=0;i<this.infoDetail.listDetail.length;i++){
                    //     if(this.infoDetail.listDetail[i].id==this.duLieuNhan){
                    //         this.subId = this.infoDetail.listDetail[i].subId;
                    //     }
                    // }
                    this.subId = this.duLieuNhan;
                    this.duLieuNhan = this.infoDetail.maGiaoDich;
                }
                console.log("sau subId")
                console.log(this.subId)
                this.show_info = true;
            },

            reset() {
                (this.ma_giao_dich = ""),
                (this.loai_du_lieu = ""),
                (this.doi_tac = ""),
                (this.nam_day_du_lieu = ""),
                (this.trang_thai = "");
            },
            close() {
                console.log("close modal 123456777");
                this.reset();
                this.$emit("close");
            },

            getDot(loai) {
                var res = loai;
                switch (loai) {
                    case 1:
                        res = "Đẩy thông tin đầu năm";
                        break;
                    case 2:
                        res = "Đẩy thông tin phát sinh";
                        break;
                    case 3:
                        res = "Đẩy thông tin cuối năm";
                        break;
                    case 4:
                        res = "Đồng bộ dữ liệu cũ";
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getTrangThai(loai) {
                var res = loai;
                switch (loai) {
                    case 0:
                        res = "Đang xử lý";
                        break;
                    case 1:
                        res = "Đẩy thành công";
                        break;
                    case 2:
                        res = "Error";
                        break;
                    case 3:
                        res = "Đã đồng bộ";
                        break;
                    case 4:
                        res = "Lỗi trong quá trình đồng bộ";
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getLoaiDuLieu(loai) {
                var res = loai;
                switch (loai) {
                    case 1:
                        res = "Sửa học sinh theo lô";
                        break;
                    case 2:
                        res = "Sửa giáo viên theo lô";
                        break;
                    case 3:
                        res = "Đẩy thông tin đầu năm";
                        break;
                    case 4:
                        res = "Đẩy thông tin học sinh biến động";
                        break;
                    case 5:
                        res = "Đẩy thông tin điểm";
                        break;
                    case 6:
                        res = "Đẩy thông tin cuối năm";
                        break;
                    case 8:
                        res = "Đẩy dữ liệu đầu năm (*)";
                        break;
                    default:
                        res = loai;
                }
                return res;
            }
        }
    };

</script>
<style>
    label {
        margin: 0 0 5px;
        font-size: 12px;
    }

    span {}

    .detail {
        padding-top: 10px;
    }

</style>

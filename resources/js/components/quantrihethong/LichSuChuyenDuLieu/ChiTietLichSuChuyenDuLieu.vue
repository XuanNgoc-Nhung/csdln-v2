<template>
    <div>
        <el-dialog :show-close="false" :close-on-press-escape="false" :visible.sync="hien_thi" show-close :before-close="close" width="90%">
            <span slot="title" class="el-dialog__title">
                <div style="margin: 0; padding:0">{{getDot(parseInt(infoDetail.loaiDot))}}: trường
                    {{infoDetail.tenTruongHoc}}
                    (MÃ:
                    {{infoDetail.maTruongHoc}}) - Năm học: {{infoDetail.namHoc}}-{{infoDetail.namHoc+1}}
                </div>
            </span>
            <form>
                <el-row :gutter="20">
                    <el-col :span="8">
                        <span>{{infoDetail.tenDoitac}}</span>
                        <br>
                        <label>Mã lần đẩy:</label>
                        <span>{{infoDetail.reqMessId}}</span>
                    </el-col>
                    <el-col :span="8">
                        <label>Duration time phản hồi:</label>
                        <span>{{infoDetail.timePhanHoi}}</span>
                        <br>
                        <label>Dữ liệu đẩy lên:</label>
                        <el-tooltip content="Xem chi tiết " placement="top">
                            <el-button plain type="info" @click.prevent="getInfoDetail(infoDetail.maGiaoDich,'1')"
                                size="mini">Xem
                                chi tiết</el-button>
                        </el-tooltip>
                    </el-col>
                    <el-col :span="8">
                        <div>
                            <label>Đợt đồng bộ:</label>
                            <span>
                                {{getLoaiDuLieu(infoDetail.loaiDuLieu)}}
                            </span>
                        </div>
                        <label>Dữ liệu nhận được:</label>
                        <el-tooltip content="Xem chi tiết " placement="top">
                            <el-button plain type="info" @click.prevent="getInfoDetail(infoDetail.maGiaoDich,'2')"
                                size="mini">Xem
                                chi tiết</el-button>
                        </el-tooltip>
                    </el-col>
                </el-row>
                <el-row :gutter="20" >
                    <el-col :span="24">
                        <div class="table-responsives">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background: #e4ebf5">
                                        <th class="text-center">STT</th>
                                        <th>Tên dữ liệu</th>
                                        <th>Nhận thành công</th>
                                        <th>Nhận thất bại</th>
                                        <th class="text-center">Kết quả nhận</th>
                                        <th>Đồng bộ thành công</th>
                                        <th>Đồng bộ thất bại</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(ct,i) in infoDetail.listDetail">
                                        <td class="text-center">{{i+1}}</td>
                                        <td>{{getTableName(ct.tableName)}}.</td>
                                        <td>{{ct.numRecordRecievedSuccess}}
                                            bản ghi.
                                        </td>
                                        <td>{{ct.numRecordRecievedError}}
                                            bản
                                        </td>
                                        <td class="text-center">
                                            <!-- <input type="text" class="form-control" :value="ct.messRecievedDetail"> -->
                                            <div>
                                                <!--                                                    <button :disabled="ct.numRecordRecievedError==0" class="btn btn-info"-->
                                                <!--                                                            @click.prevent="getInfoDetail(ct.subId,'3',ct.tableName)">Xem chi-->
                                                <!--                                                        tiết-->
                                                <!--                                                    </button>-->

                                                <el-tooltip content="Xem chi tiết " placement="left">

                                                    <el-button plain v-if="ct.numRecordRecievedError!=0" type="info"
                                                        @click.prevent="getInfoDetail(ct.subId,'3',ct.tableName)"
                                                        size="mini">
                                                    Xem</el-button>
                                                </el-tooltip>
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
                    </el-col>
                </el-row>
            </form>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="default" @click="close()">Đóng</el-button>
            </span>
        </el-dialog>
        <template>
            <component :thongtin="duLieuNhan" :hien="show_info" :subId="subId" :tabname="tenBang" :cateday="loaiday"
                @closeinfo="dongChiTiet" :is="ThongTin"></component>
        </template>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import ThongTin from "./ChiTietNhanDuoc";
    export default {
        props: [
            'item', 'show'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.maGiaoDich = this.item;
                    this.getDetail();
                    this.hien_thi = true;
                } else {
                    this.hien_thi = false;
                    // $("#modal_thong_tin_chuyen_du_lieu").modal('hide');
                }
            },
        },
        data() {
            return {
                hien_thi: false,
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
                tenBang: "",
                list_ten_bang: [{
                        name: "Thông tin lớp học",
                        value: "LopHoc"
                    },
                    {
                        name: "Thông tin học sinh",
                        value: "HocSinhTheoNam"
                    },
                    {
                        name: "Thông tin CBQL, Giáo viên, Nhân viên",
                        value: "CanBoTheoNam"
                    },
                    {
                        name: "Điểm tổng kết môn",
                        value: "DiemTongKetMon"
                    },
                    {
                        name: "Tổng kết học sinh",
                        value: "TongKetHocSinh"
                    },
                    {
                        name: "Điểm tổng kết môn sau thi lại",
                        value: "DiemTongKetMonThiLai"
                    },
                    {
                        name: "Tổng kết học sinh sau thi lại",
                        value: "TongKetHocSinhThiLai"
                    },
                    {
                        name: "Thông tin trường học",
                        value: "TruongHocNam"
                    },
                    {
                        name: "Thông tin điểm trường",
                        value: "DiemTruong"
                    },
                    {
                        name: "Cơ sở vật chất",
                        value: "CoSoVatChat"
                    },
                    {
                        name: "Ngân sách",
                        value: "NganSach"
                    },
                    {
                        name: "Báo cáo EQMS",
                        value: "EQMS"
                    },
                    {
                        name: "Thí sinh tự do",
                        value: "ThiSinhTuDo"
                    },
                    {
                        name: "Xét tốt nghiệp học sinh",
                        value: "XetTotNghiepHocSinh"
                    },
                ],
            }
        },
        mounted: function () {
            // $(this.$refs.modal_thong_tin_chuyen_du_lieu).on("hidden.bs.modal", this.close);
        },
        components: {
            ThongTin: ThongTin
        },
        methods: {
            getTableName(e) {
                let name = "";
                for (let i = 0; i < this.list_ten_bang.length; i++) {
                    if (this.list_ten_bang[i].value == e) {
                        name = this.list_ten_bang[i].name;
                    }
                }
                return name;
            },
            getInfoDetail(e, type, name) {
                console.log("getInfoDetail");
                console.log(this.infoDetail);
                this.duLieuNhan = e;
                this.tenBang = name;
                this.subId = "";
                this.loaiday = type;
                if (this.loaiday == 3) {
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
            dongChiTiet(){
                this.show_info = false;
                console.log("Đóng chi tiết:")
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
            },
            getDetail() {
                this.infoDetail = {};
                let params = {
                    id: this.maGiaoDich
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-report-api/history-syncdata/school", params, data => {
                    console.log("Dữ liệu chi tiết trả về:")
                    console.log(data)
                    if (data.data.rc == 0) {
                        this.infoDetail = data.data.item;
                        if (this.infoDetail && this.infoDetail != null) {
                            // this.thongBao('success', 'Lấy dữ liệu thành công')
                            this.hien_thi = true;
                            // $("#modal_thong_tin_chuyen_du_lieu").modal();
                        } else {
                            this.thongBao('error', data.data.rd)
                            this.close();

                        }
                        loading.close();
                    } else {
                        this.thongBao('error', data.data.rd)
                        loading.close();
                    }
                });
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
            close() {
                this.hien_thi = false;
                this.$emit('close');
            },
        }
    }

</script>
<style scoped="scoped">

</style>

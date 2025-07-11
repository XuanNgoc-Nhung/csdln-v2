<template>
    <div id="modal_nl" ref="modal_nl" class="modal fade" style="font-size:18px;">
        <div class="modal-dialog" style="width:95%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase">Quá trình đào tạo, bồi dưỡng</h5>
                </div>
                <div class="modal-body" style="width: 100%;margin: 0 auto;">
                    <div style="height: 65vh;overflow: scroll;">
                        <div class="">
                            <h6><b>Quá trình đào tạo bồi dưỡng</b></h6>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background:#e4ebf5">
                                        <th class="cg">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg">
                                            <p>Tên trường <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Chuyên ngành đào tạo, bồi dưỡng <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Từ ngày <span style="color:#DC0101">*</span> - đến ngày</p>
                                        </th>
                                        <th class="cg">
                                            <p>Hình thức <span style="color:#DC0101">*</span></p>
                                        </th>
                                        <th class="cg">
                                            <p>Văn bằng, chứng chỉ <span style="color:#DC0101">*</span></p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_qua_trinh_dtbd.length==0">
                                    <tr>
                                        <td class="cg bt" colspan="9">
                                            <p>Không có bản ghi nào</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item,i) in list_qua_trinh_dtbd" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{item.tenTruong}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.maNhomChuyenNganh,list_cn_dt_khac)}}</p>
                                        </td>
                                        <td>
                                            <div class="input-group input-daterange">
                                                <date-picker disabled :config="configDatePicker"
                                                    placeholder="Ngày bắt đầu" v-model="item.tuThangNam ">
                                                </date-picker>
                                                <div class="input-group-addon">đến</div>
                                                <date-picker disabled :config="configDatePicker"
                                                    placeholder="Ngày kết thúc" v-model="item.denThangnam">
                                                </date-picker>
                                            </div>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.maHinhThucDaoTao,list_ht_dt)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.maVbChungChi,list_trinh_do_cm_nv2)}}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <h6><b>Quá trình bồi dưỡng nâng cao năng lực sư phạm</b></h6>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background:#e4ebf5">
                                        <th class="cg">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg">
                                            <p>Khóa đào tạo bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị tổ chức</p>
                                        </th>
                                        <th class="cg">
                                            <p>Thời lượng bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Loại hình bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Hình thức</p>
                                        </th>
                                        <th class="cg">
                                            <p>Kết quả đạt được</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="qua_trinh_sp==0">
                                    <tr>
                                        <td class="cg bt" colspan="9">
                                            <p>Không có bản ghi nào</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item,i) in qua_trinh_sp" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaKhoaDaoTao,list_khoa_dao_tao_sp)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaDonViBoiDuong,list_dv)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaDonViToChuc,list_dv_tc)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaThoiLuongBoiDuong,list_tl_bd)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaLoaiHinhBoiDuong,list_lh_bd)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaHinhThuc,list_hinh_thuc)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaKetQua,list_kq_bd_sp)}}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <h6><b>Quá trình bồi dưỡng nâng cao năng lực ngoại ngữ</b></h6>
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background:#e4ebf5">
                                        <th class="cg">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg">
                                            <p>Khóa đào tạo bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị tổ chức thi</p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị tổ chức</p>
                                        </th>
                                        <th class="cg">
                                            <p>Thời lượng bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Loại hình bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Hình thức</p>
                                        </th>
                                        <th class="cg">
                                            <p>Kết quả đạt được</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="qua_trinh_nn==0">
                                    <tr>
                                        <td class="cg bt" colspan="10">
                                            <p>Không có bản ghi nào</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(item,i) in qua_trinh_nn" :key="i">
                                        <td class="cg">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaKhoaDaoTao,list_khoa_dao_tao_nn)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaDonViToChucThi,list_dv)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaDonViBoiDuong,list_dv)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaDonViToChuc,list_dv_tc)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaThoiLuongBoiDuong,list_tl_bd)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaLoaiHinhBoiDuong,list_lh_bd)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaHinhThuc,list_hinh_thuc)}}</p>
                                        </td>
                                        <td>
                                            <p>{{getTen(item.MaKetQua,list_kq_bd_nn)}}</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                        <el-button class="dts-button-close" size="mini" data-dismiss="modal">Đóng
                        </el-button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../../utils/rest_api';
    import moment from 'moment'
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import utils from '../../../utils';
    export default {
        props: ['item'],
        watch: {
            item: function (newVal, oldVal) {
                this.nation_status = newVal.trangThai;
            }
        },
        components: {
            datePicker,
        },
        data() {
            return {

                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                list_qua_trinh_dtbd: [],
                qua_trinh_sp: [],
                qua_trinh_nn: [],
                list_cn_dt_khac: [],
                list_trinh_do_cm_nv2: [
                    // {name:'Tiến sĩ',value:'01'},
                    // {name:'Thạc sĩ',value:'02'},
                    // {name:'Đại học',value:'03'},
                    // {name:'Cao đẳng',value:'04'},
                    // {name:'Trung cấp',value:'05'},
                    // {name:'Trình độ khác',value:'06'},
                    // {name:'Bác sĩ chuyên khoa 1',value:'07'},
                    // {name:'Bác sĩ chuyên khoa 2',value:'08'},
                    // {name:'TH 12+2',value:'09'},
                    // {name:'TH 9+3',value:'10'},
                    // {name:'Dưới THSP',value:'11'},
                    // {name:'Đại học và có chứng chỉ BDNVSP',value:'13'},
                    // {name:'Cao đẳng và có chứng chỉ BDNVSP',value:'14'},
                    // {name:'Trung cấp và có chứng chỉ BDNVSP',value:'15'},
                    // {name:'Đại học sư phạm',value:'16'},
                    // {name:'Cao đẳng sư phạm',value:'17'},
                    // {name:'Trung cấp sư phạm',value:'18'},
                    // {name:'Giáo sư',value:'19'},
                    // {name:'Phó giáo sư',value:'20'},
                    // {name:'Chưa qua đào tạo sư phạm',value:'21'},
                ],
                list_khoa_dao_tao_sp: [],
                list_khoa_dao_tao_nn: [],
                list_dv: [],
                list_dv_tc: [],
                list_tl_bd: [],
                list_hinh_thuc: [],
                list_kq_bd_sp: [],
                list_kq_bd_nn: [],
                list_ht_dt: [],
                list_lh_bd: [],
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            this.list_qua_trinh_dtbd = this.item.dtbd;
            this.qua_trinh_nn = this.item.nn;
            this.qua_trinh_sp = this.item.sp;
            $("#modal_nl").modal();
            $(this.$refs.modal_nl).on("hidden.bs.modal", this.close);
        },
        methods: {
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_don_vi_to_chuc_moet_code_sme"];
                if (tmp) {
                    this.list_cn_dt_khac = JSON.parse(localStorage[
                    "danh_sach_chuyen_nganh_dao_tao_khac_moet_code_sme"]);
                    this.list_trinh_do_cm_nv2 = JSON.parse(localStorage["danh_sach_trinh_do_chuyen_mon_moet_code_sme"]);
                    this.list_khoa_dao_tao_sp = JSON.parse(localStorage[
                    "danh_sach_khoa_dao_tao_su_pham_moet_code_sme"]);
                    this.list_khoa_dao_tao_nn = JSON.parse(localStorage[
                        "danh_sach_khoa_dao_tao_ngoai_ngu_moet_code_sme"]);
                    this.list_dv = JSON.parse(localStorage["danh_sach_don_vi_moet_code_sme"]);
                    this.list_dv_tc = JSON.parse(localStorage["danh_sach_don_vi_to_chuc_moet_code_sme"]);
                    this.list_tl_bd = JSON.parse(localStorage["danh_sach_thoi_luong_boi_duong_moet_code_sme"]);
                    this.list_hinh_thuc = JSON.parse(localStorage["danh_sach_hinh_thuc_moet_code_sme"]);
                    this.list_kq_bd_sp = JSON.parse(localStorage["danh_sach_ket_qua_boi_duong_su_pham_moet_code_sme"]);
                    this.list_kq_bd_nn = JSON.parse(localStorage[
                    "danh_sach_ket_qua_boi_duong_ngoai_ngu_moet_code_sme"]);
                    this.list_ht_dt = JSON.parse(localStorage["danh_sach_hinh_thuc_dao_tao_moet_code_sme"]);
                    this.list_lh_bd = JSON.parse(localStorage["danh_sach_loai_hinh_boi_duong_moet_code_sme"]);
                }
            },
            close() {
                this.$emit('close');
            },
            getTen(val, lst) {
                let ten = "";
                for (let i = 0; i < lst.length; i++) {
                    if (val == lst[i].value) {
                        ten = lst[i].name;
                    }
                }
                return ten;
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

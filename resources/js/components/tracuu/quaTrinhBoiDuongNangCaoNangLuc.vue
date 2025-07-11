<template>
            <div id="modal_nl" ref="modal_nl" class="modal fade" style="font-size:18px;">
                <div class="modal-dialog" style="width:95%">
                    <form>
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
                                                <th class="cg">
                                                    <p>Thao tác</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_qua_trinh_dtbd.length==0">
                                            <tr>
                                                <td class="cg bt" colspan="9">
                                                    <p>Không có bản ghi nào</p>
                                                    <a href="#" title="thêm" @click.prevent="themItemBdDt()"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in list_qua_trinh_dtbd" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control" v-model="item.tenTruong"
                                                        placeholder="Nhập...">
                                                </td>
                                                <td>
                                                    <el-select v-model="item.maNhomChuyenNganh" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_cn_dt_khac" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <div class="input-group input-daterange">
                                                        <date-picker :config="configDatePicker"
                                                            placeholder="Ngày bắt đầu" v-model="item.tuThangNam ">
                                                        </date-picker>
                                                        <div class="input-group-addon">đến</div>
                                                        <date-picker :config="configDatePicker"
                                                            placeholder="Ngày kết thúc" v-model="item.denThangnam">
                                                        </date-picker>
                                                    </div>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.maHinhThucDaoTao" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_ht_dt" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.maVbChungChi" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_trinh_do_cm_nv2"
                                                            :key="item.value" :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td class="cg bt">
                                                    <a href="#" title="xóa" @click.prevent="xoaItemDtBd(i)"><b><i
                                                                style="color:#DC0101; background: gainsboro;"
                                                                class="fas fa-trash-alt"></i></b> </a>
                                                    <a href="#" v-show="i+1==list_qua_trinh_dtbd.length" title="thêm"
                                                        @click.prevent="themItemBdDt(i)"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--  -->
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
                                                <th class="cg">
                                                    <p>Thao tác</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="qua_trinh_sp==0">
                                            <tr>
                                                <td class="cg bt" colspan="9">
                                                    <p>Không có bản ghi nào</p>
                                                    <a href="#" title="thêm" @click.prevent="themItemBdSp()"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in qua_trinh_sp" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaKhoaDaoTao" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_khoa_dao_tao_sp"
                                                            :key="item.value" :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaDonViBoiDuong" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dv" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaDonViToChuc" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dv_tc" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaThoiLuongBoiDuong"
                                                        style="min-width:200px" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_tl_bd" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaLoaiHinhBoiDuong" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_lh_bd" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaHinhThuc" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_hinh_thuc" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaKetQua" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_kq_bd_sp" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td class="cg bt">
                                                    <a href="#" title="xóa" @click.prevent="xoaItemBdSp(i)"><b><i
                                                                style="color:#DC0101; background: gainsboro;"
                                                                class="fas fa-trash-alt"></i></b> </a>
                                                    <a href="#" v-show="i+1==qua_trinh_sp.length" title="thêm"
                                                        @click.prevent="themItemBdSp(i)"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--  -->
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
                                                <th class="cg">
                                                    <p>Thao tác</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="qua_trinh_nn==0">
                                            <tr>
                                                <td class="cg bt" colspan="10">
                                                    <p>Không có bản ghi nào</p>
                                                    <a href="#" title="thêm" @click.prevent="themItemBdNn()"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in qua_trinh_nn" :key="i">
                                                <td class="cg">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaKhoaDaoTao" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_khoa_dao_tao_nn"
                                                            :key="item.value" :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaDonViToChucThi" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dv" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaDonViBoiDuong" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dv" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaDonViToChuc" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_dv_tc" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaThoiLuongBoiDuong"
                                                        style="min-width:200px" filterable collapse-tags
                                                        placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_tl_bd" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaLoaiHinhBoiDuong" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_lh_bd" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaHinhThuc" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_hinh_thuc" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td>
                                                    <el-select v-model="item.MaKetQua" style="min-width:200px"
                                                        filterable collapse-tags placeholder="Chọn"
                                                        no-data-text="Không có dữ liệu"
                                                        no-match-text="Không có dữ liệu phù hợp">
                                                        <el-option v-for="item in list_kq_bd_nn" :key="item.value"
                                                            :label="item.name" :value="item.value">
                                                        </el-option>
                                                    </el-select>
                                                </td>
                                                <td class="cg bt">
                                                    <a href="#" title="xóa" @click.prevent="xoaItemBdNn(i)"><b><i
                                                                style="color:#DC0101; background: gainsboro;"
                                                                class="fas fa-trash-alt"></i></b> </a>
                                                    <a href="#" v-show="i+1==qua_trinh_nn.length" title="thêm"
                                                        @click.prevent="themItemBdNn(i)"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary" @click.prevent="resetQt()">Lưu lại </button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import moment from 'moment'
    import 'pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import utils from '../../utils';
     import VueAlertify from "vue-alertify";
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
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
                list_qua_trinh_dtbd:[],
                qua_trinh_sp:[],
                qua_trinh_nn:[],
                list_cn_dt_khac: [],
                list_trinh_do_cm_nv2: [],
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
            resetQt() {
                    for(let i=0;i<this.list_qua_trinh_dtbd.length;i++){
                        if(!this.list_qua_trinh_dtbd[i].tenTruong){this.$alertify.error("Thiếu Tên Trường"); return;}
                        if(!this.list_qua_trinh_dtbd[i].maNhomChuyenNganh){this.$alertify.error("Thiếu chuyên ngành đào tạo, bồi dưỡng"); return;}
                        if(!this.list_qua_trinh_dtbd[i].tuThangNam){this.$alertify.error("Thiếu từ ngày"); return;}
                        if(!this.list_qua_trinh_dtbd[i].maHinhThucDaoTao){this.$alertify.error("Thiếu Hình thức"); return;}
                        if(!this.list_qua_trinh_dtbd[i].maVbChungChi){this.$alertify.error("Thiếu Văn bằng, chứng chỉ"); return;}
                        if(this.list_qua_trinh_dtbd[i].tuThangNam){
                            let bd = moment(this.list_qua_trinh_dtbd[i].tuThangNam, "DD-MM-YYYY");
                            let kt = moment(this.list_qua_trinh_dtbd[i].denThangnam, "DD-MM-YYYY");
                            if (kt < bd) {
                                this.$alertify.error("Giá trị Đến ngày phải lớn hơn hoặc bằng Từ ngày");
                                return;
                            }
                        }
                    }
                    for(let i=0;i<this.qua_trinh_sp.length;i++){
                        if(!this.qua_trinh_sp[i].MaKhoaDaoTao){this.$alertify.error("Thiếu Khóa đào tạo bồi dưỡng Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaDonViBoiDuong){this.$alertify.error("Thiếu Đơn vị bồi dưỡng Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaDonViToChuc){this.$alertify.error("Thiếu Đơn vị tổ chức Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaThoiLuongBoiDuong){this.$alertify.error("Thiếu Thời lượng bồi dưỡng Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaHinhThuc){this.$alertify.error("Thiếu Loại hình bồi dưỡng Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaHinhThuc){this.$alertify.error("Thiếu Hình thức đào tạo Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaKetQua){this.$alertify.error("Thiếu Kết quả đạt được Sư phạm"); return;}
                    }
                    for(let i=0;i<this.qua_trinh_nn.length;i++){
                        if(!this.qua_trinh_nn[i].MaKhoaDaoTao){this.$alertify.error("Thiếu Khóa đào tạo, bồi dưỡng Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaDonViToChucThi){this.$alertify.error("Thiếu Đơn vị tổ chức thi Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaDonViBoiDuong){this.$alertify.error("Thiếu Đơn vị bồi dưỡng Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaDonViToChuc){this.$alertify.error("Thiếu Đơn vị tổ chức Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaThoiLuongBoiDuong){this.$alertify.error("Thiếu Thời lượng bồi dưỡng Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaLoaiHinhBoiDuong){this.$alertify.error("Thiếu Loại hình bồi dưỡng Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaHinhThuc){this.$alertify.error("Thiếu Hình thức đào tạo Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaKetQua){this.$alertify.error("Thiếu Kết quả đạt được Ngoại ngữ"); return;}
                    }
                    let obj = {
                        nn:this.qua_trinh_nn,
                        sp:this.qua_trinh_sp,
                        dtbd:this.list_qua_trinh_dtbd,
                    };

                utils.confirmDialog("Xác nhận lưu lại thông tin", "Đồng ý", () => {
                    this.$emit('success', obj);
                })
            },
            themItemBdDt(e) {
                if(this.list_qua_trinh_dtbd.length==0){
                let obj = {
                    tenTruong: "",
                    maNhomChuyenNganh: "",
                    tuThangNam: "",
                    denThangnam: "",
                    maHinhThucDaoTao: "",
                    maVbChungChi: "",
                }
                this.list_qua_trinh_dtbd.push(obj);
                }
                else{
                    for(let i=0;i<this.list_qua_trinh_dtbd.length;i++){
                        if(!this.list_qua_trinh_dtbd[i].tenTruong){this.$alertify.error("Thiếu Tên Trường"); return;}
                        if(!this.list_qua_trinh_dtbd[i].maNhomChuyenNganh){this.$alertify.error("Thiếu chuyên ngành đào tạo, bồi dưỡng"); return;}
                        if(!this.list_qua_trinh_dtbd[i].tuThangNam){this.$alertify.error("Thiếu từ ngày"); return;}
                        if(!this.list_qua_trinh_dtbd[i].maHinhThucDaoTao){this.$alertify.error("Thiếu Hình thức"); return;}
                        if(!this.list_qua_trinh_dtbd[i].maVbChungChi){this.$alertify.error("Thiếu Văn bằng, chứng chỉ"); return;}
                        if(this.list_qua_trinh_dtbd[i].tuThangNam){
                            let bd = moment(this.list_qua_trinh_dtbd[i].tuThangNam, "DD-MM-YYYY");
                            let kt = moment(this.list_qua_trinh_dtbd[i].denThangnam, "DD-MM-YYYY");
                            if (kt < bd) {
                                this.$alertify.error("Giá trị Đến ngày phải lớn hơn hoặc bằng Từ ngày");
                                return;
                            }
                        }
                    }
                    let obj = {
                    tenTruong: "",
                    maNhomChuyenNganh: "",
                    tuThangNam: "",
                    denThangnam: "",
                    maHinhThucDaoTao: "",
                    maVbChungChi: "",
                }
                this.list_qua_trinh_dtbd.push(obj);
                }
            },
            themItemBdSp(e) {
                if(this.qua_trinh_sp.length==0){
                let obj = {
                    MaKetQua: "",
                    MaHinhThuc: "",
                    MaLoaiHinhBoiDuong: "",
                    MaKhoaDaoTao: "",
                    MaThoiLuongBoiDuong: "",
                    MaDonViToChuc: "",
                    MaDonViBoiDuong: "",
                }
                this.qua_trinh_sp.push(obj);
                }
                else{
                    for(let i=0;i<this.qua_trinh_sp.length;i++){
                        if(!this.qua_trinh_sp[i].MaKhoaDaoTao){this.$alertify.error("Thiếu Khóa đào tạo bồi dưỡng Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaDonViBoiDuong){this.$alertify.error("Thiếu Đơn vị bồi dưỡng Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaDonViToChuc){this.$alertify.error("Thiếu Đơn vị tổ chức Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaThoiLuongBoiDuong){this.$alertify.error("Thiếu Thời lượng bồi dưỡng Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaHinhThuc){this.$alertify.error("Thiếu Loại hình bồi dưỡng Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaHinhThuc){this.$alertify.error("Thiếu Hình thức đào tạo Sư phạm"); return;}
                        if(!this.qua_trinh_sp[i].MaKetQua){this.$alertify.error("Thiếu Kết quả đạt được Sư phạm"); return;}
                    }
                    let obj = {
                    MaKetQua: "",
                    MaHinhThuc: "",
                    MaLoaiHinhBoiDuong: "",
                    MaKhoaDaoTao: "",
                    MaThoiLuongBoiDuong: "",
                    MaDonViToChuc: "",
                    MaDonViBoiDuong: "",
                }
                this.qua_trinh_sp.push(obj);
                }
            },
            themItemBdNn(e) {
                if(this.qua_trinh_nn.length==0){
                let obj = {
                    MaKetQua: "",
                    MaHinhThuc: "",
                    MaLoaiHinhBoiDuong: "",
                    MaDonViToChucThi: "",
                    MaKhoaDaoTao: "",
                    MaThoiLuongBoiDuong: "",
                    MaDonViToChuc: "",
                    MaDonViBoiDuong: "",
                }
                this.qua_trinh_nn.push(obj);
                }
                else{
                    for(let i=0;i<this.qua_trinh_nn.length;i++){
                        if(!this.qua_trinh_nn[i].MaKhoaDaoTao){this.$alertify.error("Thiếu Khóa đào tạo, bồi dưỡng Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaDonViToChucThi){this.$alertify.error("Thiếu Đơn vị tổ chức thi Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaDonViBoiDuong){this.$alertify.error("Thiếu Đơn vị bồi dưỡng Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaDonViToChuc){this.$alertify.error("Thiếu Đơn vị tổ chức Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaThoiLuongBoiDuong){this.$alertify.error("Thiếu Thời lượng bồi dưỡng Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaLoaiHinhBoiDuong){this.$alertify.error("Thiếu Loại hình bồi dưỡng Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaHinhThuc){this.$alertify.error("Thiếu Hình thức đào tạo Ngoại ngữ"); return;}
                        if(!this.qua_trinh_nn[i].MaKetQua){this.$alertify.error("Thiếu Kết quả đạt được Ngoại ngữ"); return;}
                    }
                    let obj = {
                    MaKetQua: "",
                    MaHinhThuc: "",
                    MaLoaiHinhBoiDuong: "",
                    MaDonViToChucThi: "",
                    MaKhoaDaoTao: "",
                    MaThoiLuongBoiDuong: "",
                    MaDonViToChuc: "",
                    MaDonViBoiDuong: "",
                }
                this.qua_trinh_nn.push(obj);
                }
            },
            xoaItemBdNn(e) {
                console.log("xóa ở vị trí:" + e);
                this.qua_trinh_nn.splice(e, 1);
            },
            xoaItemDtBd(e) {
                console.log("xóa ở vị trí:" + e);
                this.list_qua_trinh_dtbd.splice(e, 1);
            },
            xoaItemBdSp(e) {
                console.log("xóa ở vị trí:" + e);
                this.qua_trinh_sp.splice(e, 1);
            },
            close() {
                    let obj = {
                        nn:this.qua_trinh_nn,
                        sp:this.qua_trinh_sp,
                        dtbd:this.list_qua_trinh_dtbd,
                    };
                this.$emit('close', obj);
            },
        }
    }
</script>

<style scoped="scoped">
    @import "../../../../node_modules/css-custom.css";

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

<template>
    <div>
        <Breadcrumb :menu="'Tiếp nhận dữ liệu QLNT'" :desc="'BC tình hình nộp dữ liệu'"
            :subDesc="'Báo cáo tình hình nộp dữ liệu cấp Sở'" />
        <div class="card-bieu-do">
            <el-form ref="ruleForm">
                <el-row :gutter="24">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :sm="24" :lg="12">
                        <label style="margin-bottom:0" class="typo__label">Đơn vị quản lý </label>
                        <eselect style="width:100%" :disabled="thongtin.role>2" multiple collapseTags v-model="donVi"
                                 :placeholder="'Chọn'" filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label style="margin-bottom:0" class="typo__label">Cấp học</label>
                        <eselect style="width:100%" multiple collapseTags v-model="capHoc" :placeholder="'Chọn'"
                                 filterable :data="danh_sach_cap_hoc_full" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="12" :lg="6">
                        <label style="margin-bottom:0" class="typo__label">Năm học </label>
                        <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                                 :data="list_nam_hoc" :fields="['name','id']" />
                    </el-col>
                    <!--                    <el-col :sm="12" :lg="6">-->
                    <!--                        <label class="typo__label">Nội dung hiển thị  </label>-->
                    <!--                        <eselect style="width:100%" multiple collapseTags @input="ChonNoiDungHienThi" v-model="noiDungHienThi" :placeholder="'Chọn'" filterable-->
                    <!--                            :data="list_noi_dung_hien_thi" :fields="['name','value']" />-->
                    <!--                    </el-col>-->
                    <el-col :span="24" class="text-center">

                        <el-button class="bt-chinh" plain size="mini" v-on:click.prevent="TruocKhiTim()" type="success">
                            Tìm kiếm
                        </el-button>
                    </el-col>

                </el-row>
            </el-form>

        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <el-col :span="12" class="">
                    <label  class="table-name">Báo cáo tình hình nộp dữ liệu cấp Sở</label>
                </el-col>
                <el-col :span="24">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr style="background:rgb(228, 235, 245)">
                                    <th class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th v-if="hienThi.tenDonVi">
                                        <p>Đơn vị quản lý</p>
                                    </th>
                                    <th v-if="hienThi.capHoc" class="text-center">
                                        <p>Cấp học</p>
                                    </th>
                                    <!-- <th v-if="hienThi.tenTruong" class="text-center"><p>Tên trường</p></th> -->
                                    <!-- <th v-if="hienThi.maTruong" class="text-center"><p>Mã trường</p></th> -->
                                    <th v-if="hienThi.maDoiTac" class="text-center">
                                        <p>Mã đối tác</p>
                                    </th>
                                    <th v-if="hienThi.ngayNopCuoi" class="text-center">
                                        <p>Ngày nộp cuối</p>
                                    </th>
                                    <th v-if="hienThi.tongSoBanGhiDaNop" class="text-center">
                                        <p>Tổng số bản ghi đã
                                            nộp</p>
                                    </th>
                                    <th v-if="hienThi.tongSoBanGhiDaNopNamTruoc" class="text-center">
                                        <p>Tổng số bản ghi
                                            đã nộp năm trước</p>
                                    </th>
                                    <th v-if="hienThi.tongSoBanGhiTrenQlnt" class="text-center">
                                        <p>Tổng số bản ghi trên
                                            QLNT</p>
                                    </th>
                                    <th v-if="hienThi.totalCanbo" class="text-center">
                                        <p>Tổng số cán bộ</p>
                                    </th>
                                    <th v-if="hienThi.totalHocsinh" class="text-center">
                                        <p>Tổng số học sinh</p>
                                    </th>
                                    <th v-if="hienThi.totalHsTotNghep" class="text-center">
                                        <p>Tổng số học sinh tốt
                                            nghiệp</p>
                                    </th>
                                    <th v-if="hienThi.totalKQCanam" class="text-center">
                                        <p>Tổng số kết quả cả năm</p>
                                    </th>
                                    <th v-if="hienThi.totalKQHocKi1" class="text-center">
                                        <p>Tổng số kết quả học kỳ 1</p>
                                    </th>
                                    <th v-if="hienThi.totalKQHocKi2" class="text-center">
                                        <p>Tổng số kết quả học kỳ 2</p>
                                    </th>
                                    <th v-if="hienThi.totalLopDon" class="text-center">
                                        <p>Tổng số lớp đơn</p>
                                    </th>
                                    <th v-if="hienThi.totalLopGhep" class="text-center">
                                        <p>Tổng số lớp ghép</p>
                                    </th>
                                    <th v-if="hienThi.totalTruongHoc" class="text-center">
                                        <p>Tổng số trường học</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody v-if="danh_sach_du_lieu.length===0">
                                <tr>
                                    <td class="text-center" colspan="19">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(tt,index) in danh_sach_du_lieu">
                                    <td class="text-center">
                                        <p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                    </td>
                                    <td v-if="hienThi.tenDonVi">
                                        <p>{{ tt.tenDonVi }}</p>
                                    </td>
                                    <!-- <td v-if="hienThi.capHoc" class="text-center"><p>{{tt.capHoc}}</p></td> -->
                                    <!-- <td v-if="hienThi.tenTruong" class="text-center"><p>{{tt.tenTruong}}</p></td> -->
                                    <!-- <td v-if="hienThi.maTruong" class="text-center"><p>{{tt.maTruong}}</p></td> -->
                                    <!-- <td v-if="hienThi.maDoiTac" class="text-center"><p>{{tt.maDoiTac}}</p></td> -->
                                    <!-- <td v-if="hienThi.ngayNopCuoi" class="text-center"><p>{{tt.ngayNopCuoi}}</p></td> -->
                                    <!-- <td v-if="hienThi.tongSoBanGhiDaNop" class="text-center"><p>{{tt.tongSoBanGhiDaNop}}</p></td> -->
                                    <!-- <td v-if="hienThi.tongSoBanGhiDaNopNamTruoc" class="text-center"><p>{{tt.tongSoBanGhiDaNopNamTruoc}}</p></td> -->
                                    <!-- <td v-if="hienThi.tongSoBanGhiTrenQlnt" class="text-center"><p>{{tt.tongSoBanGhiTrenQlnt}}</p></td> -->
                                    <td v-if="hienThi.totalCanbo" class="text-center">
                                        <p>{{ tt.totalCanbo }}</p>
                                    </td>
                                    <td v-if="hienThi.totalHocsinh" class="text-center">
                                        <p>{{ tt.totalHocsinh }}</p>
                                    </td>
                                    <td v-if="hienThi.totalHsTotNghep" class="text-center">
                                        <p>
                                            {{ tt.totalHsTotNghep }}</p>
                                    </td>
                                    <td v-if="hienThi.totalKQCanam" class="text-center">
                                        <p>{{ tt.totalKQCanam }}</p>
                                    </td>
                                    <td v-if="hienThi.totalKQHocKi1" class="text-center">
                                        <p>{{ tt.totalKQHocKi1 }}</p>
                                    </td>
                                    <td v-if="hienThi.totalKQHocKi2" class="text-center">
                                        <p>{{ tt.totalKQHocki2 }}</p>
                                    </td>
                                    <td v-if="hienThi.totalLopDon" class="text-center">
                                        <p>{{ tt.totalLopDon }}</p>
                                    </td>
                                    <td v-if="hienThi.totalLopGhep" class="text-center">
                                        <p>{{ tt.totalLopGhep }}</p>
                                    </td>
                                    <td v-if="hienThi.totalTruongHoc" class="text-center">
                                        <p>{{ tt.totalTruongHoc }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </el-col>
                <!-- <el-col :span="12">
                    <ChonSoLuong @chonXongSoLuong="ChonSoLuongBanGhi($event)">
                    </ChonSoLuong>
                </el-col>
                <el-col :span="12">
                    <PhanTrang v-show="total_rows>0" :tongbanghi="total_rows" :soluonghienthi="soLuongBanGhiHienThi"
                        :batdau="trangbatdau" @pageChange="layLai($event)">
                    </PhanTrang>
                </el-col> -->
                
                <el-col :span="24">
                    <PhanTrang :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                    </PhanTrang>
                </el-col>
            </el-row>
        </div>
    </div>
</template>
<script>
    import rest_api from "../../utils/rest_api";
    import constant from '../../utils/constant';
    import utils from '../../utils'
    import PhanTrang from "../ui/PagingCustom";
    import ChonSoLuong from "../ui/chonSoLuongBanGhi";
    import ESelectVue from '../ui/ESelect.vue';
    import moment from 'moment';
    import dialog from "../../utils/dialog";
    import VueAlertify from "vue-alertify";
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';
    import Breadcrumb from "../ui/Breadcrumb.vue";

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
        components: {
            "PhanTrang": PhanTrang,
            'eselect': ESelectVue,
            ChonSoLuong: ChonSoLuong,
            DatePicker,
            Breadcrumb
        },
        computed: {},
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                list_noi_dung_hien_thi: [{
                        name: "Tên đơn vị",
                        value: "tenDonVi"
                    },
                    // {name:"Cấp học",value:"capHoc"},
                    // {name:"Tên trường",value:"tenTruong"},
                    // {name:"Mã trường",value:"maTruong"},
                    // {name:"Mã đối tác",value:"maDoiTac"},
                    // {name:"Ngày nộp cuối",value:"ngayNopCuoi"},
                    // {name:"Tổng số bản ghi đã nộp",value:"tongSoBanGhiDaNop"},
                    // {name:"Tổng số bản ghi đã nộp năm học trước",value:"tongSoBanGhiDaNopNamTruoc"},
                    // {name:"Tổng số bản ghi trên QLNT",value:"tongSoBanGhiTrenQlnt"},
                    {
                        name: "Tổng số cán bộ",
                        value: "totalCanbo"
                    },
                    {
                        name: "Tổng số học sinh",
                        value: "totalHocsinh"
                    },
                    {
                        name: "Tổng số học sinh tốt nghiệp",
                        value: "totalHsTotNghep"
                    },
                    {
                        name: "Tổng số kết quả cả năm",
                        value: "totalKQCanam"
                    },
                    {
                        name: "Tổng số kết quả học kỳ I",
                        value: "totalKQHocKi1"
                    },
                    {
                        name: "Tổng số kết quả học kỳ II",
                        value: "totalKQHocKi2"
                    },
                    {
                        name: "Tổng số lớp đơn",
                        value: "totalLopDon"
                    },
                    {
                        name: "Tổng số lớp ghép",
                        value: "totalLopGhep"
                    },
                    {
                        name: "Tổng số trường học",
                        value: "totalTruongHoc"
                    },
                ],
                noiDungHienThi: [
                    "tenDonVi",
                    // "capHoc",
                    // "tenTruong",
                    // "maTruong",
                    // "maDoiTac",
                    // "ngayNopCuoi",
                    // "tongSoBanGhiDaNop",
                    // "tongSoBanGhiDaNopNamTruoc",
                    // "tongSoBanGhiTrenQlnt",
                    "totalCanbo",
                    "totalHocsinh",
                    "totalHsTotNghep",
                    "totalKQCanam",
                    "totalKQHocKi1",
                    "totalKQHocKi2",
                    "totalLopDon",
                    "totalLopGhep",
                    "totalTruongHoc",
                ],
                hienThi: {
                    tenDonVi: true,
                    // capHoc:true,
                    // tenTruong:true,
                    // maTruong:true,
                    // maDoiTac:true,
                    // ngayNopCuoi:true,
                    // tongSoBanGhiDaNop:true,
                    // tongSoBanGhiDaNopNamTruoc:true,
                    // tongSoBanGhiTrenQlnt:true,
                    totalCanbo: true,
                    totalHocsinh: true,
                    totalHsTotNghep: true,
                    totalKQCanam: true,
                    totalKQHocKi1: true,
                    totalKQHocKi2: true,
                    totalLopDon: true,
                    totalLopGhep: true,
                    totalTruongHoc: true,
                },
                donVi: [],
                capHoc: [],
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                soLuongBanGhiHienThi: 25,
                trangbatdau: false,
                namHoc: "",
                list_don_vi: [],
                danh_sach_cap_hoc_full: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                danh_sach_du_lieu: [],
            }
        },
        mounted() {
            if (this.thongtin.role > 2) {
                let url = this.thongtin.tenMien + "/report-sync-status?type=2";
                window.location.href = url;
            }
            // if (this.danh_sach_cap_hoc_full.length) {
            //     this.capHoc = [];
            //     for (let i = 0; i < this.danh_sach_cap_hoc_full.length; i++) {
            //         this.capHoc.push(this.danh_sach_cap_hoc_full[i].id)
            //     }
            // }
            this.namHoc = this.thongtin.namHocHienTai;
            this.getDonVi();
            // this.getData();
        },
        watch: {},
        methods: {
            ChonNoiDungHienThi() {
                let hienThi = {
                    tenDonVi: false,
                    // capHoc:false,
                    // tenTruong:false,
                    // maTruong:false,
                    // maDoiTac:false,
                    // ngayNopCuoi:false,
                    // tongSoBanGhiDaNop:false,
                    // tongSoBanGhiDaNopNamTruoc:false,
                    // tongSoBanGhiTrenQlnt:false,
                    totalCanbo: false,
                    totalHocsinh: false,
                    totalHsTotNghep: false,
                    totalKQCanam: false,
                    totalKQHocKi1: false,
                    totalKQHocKi2: false,
                    totalLopDon: false,
                    totalLopGhep: false,
                    totalTruongHoc: false,
                };
                console.log(this.noiDungHienThi)
                for (let i = 0; i < this.noiDungHienThi.length; i++) {
                    // if(this.noiDungHienThi[i]=="capHoc"){hienThi.capHoc=true}
                    // if(this.noiDungHienThi[i]=="maDoiTac"){hienThi.maDoiTac=true}
                    // if(this.noiDungHienThi[i]=="maTruong"){hienThi.maTruong=true}
                    // if(this.noiDungHienThi[i]=="ngayNopCuoi"){hienThi.ngayNopCuoi=true}
                    if (this.noiDungHienThi[i] == "tenDonVi") {
                        hienThi.tenDonVi = true
                    }
                    // if(this.noiDungHienThi[i]=="tenTruong"){hienThi.tenTruong=true}
                    // if(this.noiDungHienThi[i]=="tongSoBanGhiDaNop"){hienThi.tongSoBanGhiDaNop=true}
                    // if(this.noiDungHienThi[i]=="tongSoBanGhiDaNopNamTruoc"){hienThi.tongSoBanGhiDaNopNamTruoc=true}
                    // if(this.noiDungHienThi[i]=="tongSoBanGhiTrenQlnt"){hienThi.tongSoBanGhiTrenQlnt=true}
                    if (this.noiDungHienThi[i] == "totalCanbo") {
                        hienThi.totalCanbo = true
                    }
                    if (this.noiDungHienThi[i] == "totalHocsinh") {
                        hienThi.totalHocsinh = true
                    }
                    if (this.noiDungHienThi[i] == "totalHsTotNghep") {
                        hienThi.totalHsTotNghep = true
                    }
                    if (this.noiDungHienThi[i] == "totalKQCanam") {
                        hienThi.totalKQCanam = true
                    }
                    if (this.noiDungHienThi[i] == "totalKQHocKi1") {
                        hienThi.totalKQHocKi1 = true
                    }
                    if (this.noiDungHienThi[i] == "totalKQHocKi2") {
                        hienThi.totalKQHocKi2 = true
                    }
                    if (this.noiDungHienThi[i] == "totalLopDon") {
                        hienThi.totalLopDon = true
                    }
                    if (this.noiDungHienThi[i] == "totalLopGhep") {
                        hienThi.totalLopGhep = true
                    }
                    if (this.noiDungHienThi[i] == "totalTruongHoc") {
                        hienThi.totalTruongHoc = true
                    }
                }
                this.hienThi = hienThi;
                console.log("Chọn nội dung hiển thị")
                console.log(this.hienThi)
            },
            ChonSoLuongBanGhi(e) {
                this.total_rows = 0;
                console.log("Chọn số lượng bản ghi:")
                console.log(JSON.stringify(e));
                this.lsTruongUpdate = [];
                this.soLuongBanGhiHienThi = e.soluong;
            },
            getData() {
                // if (this.capHoc.length == 0) {
                //     this.$alertify.error("Vui lòng bổ sung cấp học");
                //     return;
                // }
                // if (!this.namHoc || this.namHoc == "") {
                //     this.$alertify.error("Vui lòng bổ sung năm học");
                //     return;
                // }
                console.log("Lấy dữ liệu");
                this.danh_sach_du_lieu = [];
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    start: this.start,
                    limit: this.limit,
                    maDonViList: this.donVi,
                    capHocList: this.capHoc,
                    namHoc: this.namHoc,
                };
                let url = "/csdlgd-report-api/bao-cao-tinh-hinh-nop-du-lieu/theo-don-vi";
                rest_api.post(url, params, data => {
                    loading.close();
                    if (data.data.rc == 0) {
                        this.total_rows = data.data.totalRows;
                        this.danh_sach_du_lieu = data.data.tableData
                        // this.$alertify.success("Lấy dữ liệu thành công");
                    } else {
                        this.danh_sach_du_lieu = [];
                        this.$alertify.error(data.data.rd);
                    }
                });
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            TruocKhiTim() {
                console.log("Ấn tìm kiếm")
                this.lsTruongUpdate = [];
                this.total_rows = 0;
                this.trangbatdau = !this.trangbatdau;
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.list_don_vi = [];
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    console.log("Lấy đơn vị trả về:")
                    console.log(JSON.stringify(data))
                    if (data.data.statusResponse == 0) {
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                tenDonVi: data_demo[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data_demo[i].maDonVi + ']',
                                maDonVi: data_demo[i].maDonVi,
                            }
                            this.list_don_vi.push(obj)
                        }
                    } else {
                        this.$alertify.error(data.data.message);
                    }
                });
            },
        }
    }

</script>
<style scoped="scoped">

</style>

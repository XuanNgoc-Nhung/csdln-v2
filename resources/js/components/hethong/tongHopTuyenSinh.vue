<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> HỆ THỐNG<span
                class="kytu"> &raquo;</span> TỔNG HỢP TUYỂN SINH</span>
            </div>
        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                <el-col :span="4">
                    <label for="">Năm học</label>
                    <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                             :data="list_nam_hoc" :fields="['name','id']" />
                </el-col>
                <el-col :span="8">
                    <label for="">Đơn vị quản lý<span class="red">*</span></label>
                    <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                             no-data-text="danh sách lựa chọn trống" collapse-tags v-model="maDonVi"
                             :placeholder="'Chọn'" filterable :data="danh_sach_don_vi"
                             :fields="['tenDonVi','maDonVi']" />
                </el-col>
                <el-col :span="4">
                    <label for="">Cấp học</label>
                    <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                             no-data-text="danh sách lựa chọn trống" disabled collapse-tags v-model="maCapHoc"
                             :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc_full"
                             :fields="['name','id']" />
                </el-col>
                <el-col :span="2" style=" padding-right:15px;">
                    <label for="" style="color:transparent">Tìm kiếm</label>
                    <el-button plain size="mini" v-on:click.prevent="checkTruocKhiTim()"
                               style=" width:100%;font-size:14px;padding-left:10px" type="success">Tìm
                        kiếm</el-button>
                </el-col>
            </el-row>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr style="background:#e4ebf5">
                                            <th class="text-center">
                                                <p>STT</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Tên trường</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Mã Trường</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Năm học</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Trạng thái tổng hợp</p>
                                            </th>
                                            <th class="text-center">
                                                <p>Tuỳ chọn</p>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="list_data.length===0">
                                        <tr>
                                            <td class="text-center" colspan="23">
                                                <p>Không có bản ghi nào</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else="v-else">
                                        <tr v-for="(tg,index) in list_data">
                                            <td class="text-center">
                                                <p>{{ index+1}}</p>
                                            </td>
                                            <td>
                                                <p>{{tg.tenTruong}}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{tg.maTruong}}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{tg.namHoc}} - {{tg.namHoc+1}}</p>
                                            </td>
                                            <td class="text-center">
                                                <el-button v-if="!tg.status" size="mini" class="hoverWarning" type="warning">Chưa tổng hợp</el-button>
                                                <el-button v-else size="mini" class="hoverSuccess" type="success">Đã tổng hợp</el-button>
                                            </td>
                                            <td class="text-center">
                                                <el-tooltip content="Tổng hợp" placement="left">
                                                    <el-button  plain size="mini" @click.prevent="tongHop(tg)"
                                                               type="primary">
                                                        Tổng hợp
                                                    </el-button>
                                                </el-tooltip>
                                                <el-tooltip content="Tải xuống" placement="left">
                                                    <el-button :disabled="!tg.tongHop" plain size="mini" @click.prevent="taiXuong(tg.exportLink,1)"
                                                               type="success">
                                                        Tải xuống
                                                    </el-button>
                                                </el-tooltip>
                                                <el-tooltip content="Xem online" placement="left">
                                                    <el-button :disabled="!tg.tongHop" plain size="mini" @click.prevent="taiXuong(tg.exportLink,2)"
                                                               type="success">
                                                        Xem online
                                                    </el-button>
                                                </el-tooltip>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                                </Page>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import rest_api from "../../utils/rest_api";
import Page from "../ui/PagingCustom";
import ESelectVue from '../ui/ESelect.vue';
import constant from "../../utils/constant";
export default {
    props: [],
    components: {
        'eselect': ESelectVue,
        Page: Page,
    },
    computed: {},
    data() {
        return {
            show_msg: false,
            show_import: false,
            limit: 25,
            total_rows: 0,
            start: 0,
            currentPage: 1,
            thongTinChinhSua: {},
            hien_thi_them_moi: false,
            hien_thi_chinh_sua: false,
            trangbatdau: false,
            thongtin: {},
            list_data: [],
            danh_sach_don_vi: [],
            danh_sach_cap_hoc_full: window.listCapHoc,
            danh_sach_truong_hoc: [],
            list_nam_hoc: constant.LIST_YEARS_FULL,
            maDonVi: "",
            namHoc: "",
            maCapHoc: "",
            maTruongHoc: "",
            danh_sach_don_vi_them_mat_khau: [],
            danh_sach_truong_hoc_them_mat_khau: [],
            maDonViThemMatKhau: "",
            maCapHocThemMatKhau: "",
            maTruongHocThemMatKhau: "",
            tenDangNhapThemMatKhau: "",
            matKhauThemMatKhau: "",
            // Thêm mới
            form: {
                name: '',
                region: '',
                date1: '',
                date2: '',
                delivery: false,
                type: [],
                resource: '',
                desc: ''
            },
        };
    },
    mounted() {
        console.log('mount tổng hợp tuyển sinh')
        this.thongtin = JSON.parse(window.userInfo);
        this.namHoc = this.thongtin.namHocHienTai;
        this.maCapHoc = 2;
        this.getDonVi();
    },
    watch: {},
    methods: {
        taiXuong(link,type){
            let linkBaoCao = this.thongtin.tenMien + link;
            let urlView = "/view-excel?path=" + linkBaoCao;
            if(type==1){
                //Tải xuống
                window.open(linkBaoCao, "_blank");
            }else {
                window.open(urlView, "_blank");
            }
        },
        tongHop(item){

            this.$confirm('Xác nhận tổng hợp dữ liệu?', 'Thông báo', {
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy',
                closeOnClickModal: false,
            })
                .then(_ => {
                    const params = {
                        maTruongHoc: item.maTruong,
                        namHoc: item.namHoc,
                    };
                    const loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    rest_api.post("/csdlgd-report-api/excel-form/tong-hop-tuyen-sinh", params, response => {
                        loading.close();
                        if (response.data.rc ==0) {
                            this.thongBao('success','Đang tổng hợp. Quá trình tổng hợp sẽ diễn ra trong vài phút.')
                        }else{
                            this.thongBao('error',response.data.rd)
                        }
                    });
                })
                .catch(_ => {});
        },
        getData() {
            this.list_data = [];
            this.total_rows = 0;
            const params = {
                maDonVi: this.maDonVi,
                namHoc: this.namHoc,
                maTruongHoc: this.maTruongHoc,
            };
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.post("/csdlgd-report-api/excel-form/danh-sach-bc-tong-hop-tuyen-sinh", params, response => {
                loading.close();
                if (response.data.rc ==0) {
                    this.list_data = response.data.baoCaoDataList
                }else{
                    this.thongBao('error',response.data.rd)
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
        layLai(e) {
            console.log("lấy lại danh sách:" + JSON.stringify(e));
            this.start = e.start;
            this.limit = e.limit;
            this.currentPage = e.currentPage;
            this.getData();
        },
        checkTruocKhiTim() {
            this.trangbatdau = !this.trangbatdau;
        },
        getTruongHoc() {
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            let params = {
                maDonVi: [],
                capHoc: [],
            };
            if (this.maDonVi) {
                params.maDonVi = [this.maDonVi]
            };
            if (this.maCapHoc) {
                params.capHoc = [this.maCapHoc]
            };
            rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                let data_demo = [];
                if (data.data.statusResponse == 0) {
                    for (let i = 0; i < data.data.rows.length; i++) {
                        let obj = {
                            name: data.data.rows[i].tenTruongHoc + " - [" + data.data.rows[i]
                                .maTruongHoc + "]",
                            value: data.data.rows[i].maTruongHoc,
                        }
                        data_demo.push(obj);
                    }
                    this.danh_sach_truong_hoc = data_demo;
                    loading.close();
                } else {
                    this.danh_sach_truong_hoc = [];
                    loading.close();
                }
            });
        },
        getDonVi() {
            console.log('get don vi')
            let params = {
                "start": 0,
                "limit": 9999,
                "maTinhThanh": this.thongtin.ma_so
            };
            const loadingDv = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                loadingDv.close();
                if (data.data.statusResponse == 0) {
                    let data_demo = data.data.rows;
                    for (let i = 0; i < data_demo.length; i++) {
                        let obj = {
                            tenDonVi: data_demo[i].tenDonVi + ' - [' + data_demo[i].maDonVi + ']',
                            maDonVi: data_demo[i].maDonVi,
                        }
                        this.danh_sach_don_vi.push(obj);
                    }
                    this.getTruongHoc();
                }
            });
        }
    }
};

</script>
<style scoped="scoped">
</style>

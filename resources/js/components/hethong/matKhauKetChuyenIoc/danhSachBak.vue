<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> KẾT CHUYỂN DỮ LIỆU <span
                        class="kytu"> &raquo;</span> MẬT KHẨU KẾT CHUYỂN LÊN IOC </span>
            </div>
        </div>
        <div class="card-bieu-do">
            <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                <el-col :span="8">
                    <label>Đơn vị quản lý</label>
                    <eselect style="width:100%" @change="chonDonVi" no-match-text="Không tìm thấy bản ghi nào"
                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="maDonVi"
                        :placeholder="'Chọn'" filterable :data="danh_sach_don_vi"
                        :fields="['tenDonVi','maDonVi']" />
                </el-col>
                <el-col :span="4">
                    <label>Cấp học</label>
                    <eselect style="width:100%" @change="chonDonVi" no-match-text="Không tìm thấy bản ghi nào"
                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="maCapHoc"
                        :placeholder="'Chọn'" filterable :data="danh_sach_cap_hoc_full"
                        :fields="['name','id']" />
                </el-col>
                <el-col :span="8">
                    <label>Trường học</label>
                    <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="maTruongHoc"
                        :placeholder="'Chọn'" filterable :data="danh_sach_truong_hoc"
                        :fields="['name','value']" />
                </el-col>
                <el-col :span="2" style=" margin-top:25px;" >
                    <el-button plain size="mini" v-on:click.prevent="checkTruocKhiTim()"
                        style=" width:100%;font-size:14px;padding-left:10px" type="success">Tìm
                        kiếm
                    </el-button>
                </el-col>
            </el-row>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row group-button-table">
                            <div class="col-sm-12 text-right">
                                <el-tooltip placement="top">
                                    <div slot="content">Thêm mới mật khẩu kết chuyển IOC</div>
                                    <el-button plain type="primary" @click.prevent="themMoiMatKhauKetChuyen"
                                        size="mini">
                                        Thêm mới
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip placement="top">
                                    <div slot="content">Import mật khẩu kết IOC chuyển theo biểu mẫu</div>
                                    <el-button plain @click.prevent="showImport" type="success" size="mini">
                                        Nhập theo biểu mẫu
                                    </el-button>
                                </el-tooltip>
                            </div>
                        </div>
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
                                                    <p>Tên đăng nhập</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Mã Trường</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tên Trường</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tỉnh thành</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tên đơn vị</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Cấp học</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Thao tác</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="danh_sach_mat_khau_ket_chuyen.length===0">
                                            <tr>
                                                <td class="text-center" colspan="23">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else="v-else">
                                            <tr v-for="(tg,index) in danh_sach_mat_khau_ket_chuyen">
                                                <td class="text-center">
                                                    <p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ tg.tenDangNhap }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ tg.maTruong }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ tg.tenTruong }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ tg.tenTinhThanh }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ tg.tenDonvi }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ getCapHoc(tg.capHoc) }}</p>
                                                </td>
                                                <td class="text-center">
                                                    <!-- <a title="Chỉnh sửa" v-on:click="showUpdate(tg)">
                                                    <i class="far fa-edit"></i>
                                                </a> -->

                                                    <el-tooltip content="Chỉnh sửa" placement="left">
                                                        <el-button plain size="mini" @click.prevent="showUpdate(tg)"
                                                            type="warning" icon='far fa-edit'>
                                                        </el-button>
                                                    </el-tooltip>

                                                    <el-tooltip content="Xoá" placement="left">
                                                        <el-button plain size="mini" @click.prevent="demoDel(index)"
                                                            type="danger" icon='el-icon-delete'>
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
        <div>
            <div id="modal_them_moi" ref="modal_them_moi" class="modal fade">
                <div class="modal-dialog" style="width:50% !important">
                    <form>
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-uppercase">Thêm mật khẩu kết chuyển dữ liệu</h5>
                            </div>
                            <div class="modal-body">
                                <el-row :gutter="24">
                                    <el-col :span="16">
                                        <label>Chọn đơn vị</label>
                                        <eselect style="width:100%" @change="chonDonViThemMatKhau"
                                            no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags
                                            v-model="maDonViThemMatKhau" :placeholder="'Chọn'" filterable
                                            :data="danh_sach_don_vi" :fields="['tenDonVi','maDonVi']" />
                                    </el-col>
                                    <el-col :span="8">
                                        <label>Cấp học</label>
                                        <eselect style="width:100%" @change="chonDonViThemMatKhau"
                                            no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags
                                            v-model="maCapHocThemMatKhau" :placeholder="'Chọn'" filterable
                                            :data="danh_sach_cap_hoc_full" :fields="['name','id']" />
                                    </el-col>
                                    <el-col :span="16">
                                        <label>Trường học <span style="color:#DC0101">*</span></label>
                                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags
                                            v-model="maTruongHocThemMatKhau" :placeholder="'Chọn'" filterable
                                            :data="danh_sach_truong_hoc_them_mat_khau" :fields="['name','value']" />
                                    </el-col>
                                    <el-col :span="8">
                                        <label>Tên đăng nhập <span style="color:#DC0101">*</span></label>
                                        <el-input clearable placeholder="Tên đăng nhập"
                                            v-model="tenDangNhapThemMatKhau">
                                        </el-input>
                                    </el-col>
                                    <el-col :span="16">
                                        <label>Mật khẩu <span style="color:#DC0101">*</span></label>
                                        <el-input clearable v-model="matKhauThemMatKhau" placeholder="Nhập..."
                                            show-password></el-input>
                                    </el-col>
                                </el-row>
                            </div>
                            <div class="modal-footer">
                                <el-button plain type="default" size="mini" data-dismiss="modal">Đóng
                                </el-button>
                                <el-button plain type="primary" size="mini" @click.prevent="SubmitThemMoi">Thêm mới
                                </el-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div>
            <ChinhSua :show="hien_thi_chinh_sua" :item="thongTinChinhSua" @success="onUpdateData($event)"
                @close="hien_thi_chinh_sua=false"></ChinhSua>

            <Import :show="show_import" @close="show_import=false"></Import>
        </div>
    </div>
</template>
<script>
    import VueAlertify from "vue-alertify";
    import rest_api from "../../../utils/rest_api";
    import Page from "../../ui/PagingCustom";
    import ChinhSua from "./chinhSua";
    import ThemMoi from "./themMoi";
    import Import from "./import";
    import constant from "../../../utils/constant";
    import dialog from "../../../utils/dialog";
    import utils from "../../../utils";
    import ESelectVue from '../../ui/ESelect.vue';
    import {
        Loading
    } from 'element-ui';

    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {
        props: ["info"],
        components: {
            'eselect': ESelectVue,
            Page: Page,
            ThemMoi: ThemMoi,
            ChinhSua: ChinhSua,
            Import: Import,
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
                danh_sach_mat_khau_ket_chuyen: [],
                danh_sach_don_vi: [],
                danh_sach_cap_hoc_full: window.listCapHoc,
                danh_sach_truong_hoc: [],
                maDonVi: "",
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
            this.thongtin = JSON.parse(this.info);
            this.getDonVi();
            this.getTruongHocThemMatKhau();
            $(this.$refs.modal_them_moi).on("hidden.bs.modal", this.close);
        },
        watch: {},
        methods: {
            showImport() {
                this.show_import = true;
            },
            close() {},
            reset() {},
            onUpdateData() {
                this.hien_thi_chinh_sua = false;
                this.getMatKhauKetChuyen();
            },
            showUpdate(e) {
                console.log("thay chỉnh sửa mật khẩu kết chuyển");
                this.thongTinChinhSua = e;
                this.hien_thi_chinh_sua = true;
            },
            demoDel(index) {

                this.$confirm('Xác nhận xoá thông tin mật khẩu kết chuyển?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        setTimeout(() => {
                            loading.close();
                            this.thongBao('success', 'Xoá dữ liệu thành công.')
                            this.danh_sach_mat_khau_ket_chuyen.splice(index, 1)
                        }, 500)
                    })
                    .catch(_ => {});
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
            SubmitThemMoi() {
                if (!this.maTruongHocThemMatKhau) {
                    this.$alertify.error("Thiếu trường học");
                    return
                }
                if (!this.tenDangNhapThemMatKhau) {
                    this.$alertify.error("Thiếu Tên đăng nhập");
                    return
                }
                if (!this.matKhauThemMatKhau) {
                    this.$alertify.error("Thiếu mật khẩu");
                    return
                }

                let params = {
                    maTruong: this.maTruongHocThemMatKhau,
                    matKhau: this.matKhauThemMatKhau,
                    tenDangNhap: this.tenDangNhapThemMatKhau
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-push/KetChuyenDlIoc/createMKKC", params, data => {
                    loading.close();
                    if (data.data.code === 200) {
                        console.log("Thành công");
                        this.reset();
                        this
                            .$alertify
                            .success('Thêm thành công');
                        this.trangbatdau = !this.trangbatdau;
                    } else {
                        this
                            .$alertify
                            .error(data.data.message);
                        return;
                    }
                });
                // this.$confirm('Xác nhận thêm thông tin?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {})
                //     .catch(_ => {});
            },
            chonDonViThemMatKhau() {
                this.danh_sach_truong_hoc_them_mat_khau = [];
                this.maTruongHocThemMatKhau = "";
                this.getTruongHocThemMatKhau();
            },
            themMoiMatKhauKetChuyen() {
                $("#modal_them_moi").modal();
            },
            getCapHoc(loai) {
                var res = parseInt(loai);
                switch (res) {
                    case 1:
                        res = 'Tiểu học';
                        break;
                    case 2:
                        res = 'THCS';
                        break;
                    case 3:
                        res = 'THPT';
                        break;
                    case 4:
                        res = 'Nhà trẻ';
                        break;
                    case 5:
                        res = 'Mẫu giáo';
                        break;
                    case 12:
                        res = 'PTCS';
                        break;
                    case 1245:
                        res = 'MN-PTCS';
                        break;
                    case 145:
                        res = 'MN-TH';
                        break;
                    case 23:
                        res = 'Trung học';
                        break;
                    case 123:
                        res = 'Phổ thông';
                        break;
                    case 12345:
                        res = 'MN-PT';
                        break;
                    case 45:
                        res = 'Mầm non';
                        break;
                    case 6:
                        res = 'GDTX';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getMatKhauKetChuyen() {
                this.danh_sach_mat_khau_ket_chuyen = [];
                this.total_rows = 0;
                const params = {
                    start: this.start,
                    limit: this.limit,
                    maTinhThanh: this.thongtin.province,
                    maDonVi: this.maDonVi,
                    capHoc: this.maCapHoc,
                    maTruongHoc: this.maTruongHoc,
                };
                this.hien_thi_chinh_sua = false;
                this.hien_thi_them_moi = false;
                $("#modal_them_moi").modal('hide');
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-push/KetChuyenDlIoc/filterMatKhauKc", params, response => {
                    loading.close();
                    if (response.data.code === 200) {
                        this.danh_sach_mat_khau_ket_chuyen = response.data.rows;
                        if (this.danh_sach_mat_khau_ket_chuyen == null) {
                            this.danh_sach_mat_khau_ket_chuyen = [];
                        };
                        this.total_rows = response.data.total;
                        if (this.total_rows == 0) {
                            this
                                .$alertify
                                .error("Không có bản ghi nào được tìm thấy");
                        }
                        this.total_rows = response.data.total;
                    } else {
                        this
                            .$alertify
                            .error(response.data.message);
                    }
                });
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getMatKhauKetChuyen();
            },
            checkTruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
            chonDonVi() {
                console.log("Chọn đơn vị/cấp học");
                this.danh_sach_truong_hoc = [];
                this.maTruongHoc = "";
                this.getTruongHoc();
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
            getTruongHocThemMatKhau() {
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
                if (this.maDonViThemMatKhau) {
                    params.maDonVi = [this.maDonViThemMatKhau]
                };
                if (this.maCapHocThemMatKhau) {
                    params.capHoc = [this.maCapHocThemMatKhau]
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
                        this.danh_sach_truong_hoc_them_mat_khau = data_demo;
                        loading.close();
                    } else {
                        this.danh_sach_truong_hoc_them_mat_khau = [];
                        loading.close();
                    }
                });
            },
            getDonVi() {
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

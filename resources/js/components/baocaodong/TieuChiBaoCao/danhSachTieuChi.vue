<template>
    <div>
        <el-row :gutter="20">
            <el-col :xs="12" :sm="8" :md="6" :lg="4" style="align-self:center">
                <label for="">Loại tiêu chí</label>
                <eselect style="width:100%" v-model="tieu_chi_he_thong" collapseTags @change="chonLoaiTieuChi"
                    no-match-text="Không tìm thấy bản ghi nào" no-data-text="Chọn" :placeholder="'Chọn'" filterable
                    :data="list_doi_tuong" :fields="['name','value']" />
            </el-col>
            <el-col :xs="12" :sm="8" :md="6" :lg="4" style="align-self:center">
                <label for="">Mã tiêu chí</label>
                <el-input clearable placeholder="Nhập..." v-model="maTieuChi"></el-input>
            </el-col>
            <el-col :xs="12" :sm="8" :md="6" :lg="4" style="align-self:center">
                <label for="">Tên tiêu chí</label>
                <el-input clearable placeholder="Nhập..." v-model="tenTieuChi"></el-input>
            </el-col>
            <el-col :xs="12" :sm="8" :md="6" :lg="4" style="align-self:center">
                <label for="">Đối tượng</label>
                <eselect style="width:100%" v-model="doiTuong" collapseTags no-match-text="Không tìm thấy bản ghi nào"
                    no-data-text="Chọn" :placeholder="'Chọn'" filterable :data="list_the_loai"
                    :fields="['name','value']" />
            </el-col>
            <el-col :xs="12" :sm="8" :md="6" :lg="4" style="align-self:center">
                <label for="">Từ khóa</label>
                <el-input clearable placeholder="Nhập..." v-model="textSreach"></el-input>
            </el-col>
        </el-row>
        <el-row :gutter="24" style="padding-top:10px">
            <el-col :span="24" class="text-center">
                <el-button size="mini" type="primary" @click.prevent="checkTruocKhiTim()">Tìm
                    kiếm</el-button>
            </el-col>
        </el-row>
        <div class="row">
            <div class="col-sm-12">
                <div class="table-responsive" style="margin-top:5px">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr style="background:#e4ebf5">
                                <th class="text-center">
                                    <p>STT</p>
                                </th>
                                <th class="text-center">
                                    <p>Mã tiêu chí</p>
                                </th>
                                <th class="text-center">
                                    <p>Tên tiêu chí</p>
                                </th>
                                <th class="text-center">
                                    <p>Mô tả</p>
                                </th>
                                <th class="text-center">
                                    <p>Đối tượng</p>
                                </th>
                                <th class="text-center">
                                    <p>Thẻ (Tag)</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="ds_tieu_chi_trong.length===0">
                            <tr>
                                <td class="text-center" colspan="8">
                                    <p>Không có bản ghi nào</p>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="(tt,index) in ds_tieu_chi_trong">
                                <td class="text-center">
                                    <p>{{(currentPage-1)*limit + index+1}}</p>
                                </td>
                                <td class="text-center">
                                <el-tooltip content="Nhấn đúp để sao chép" placement="left">
                                    <el-button type="primary" v-on:dblclick.native="saoChepMaTieuChi(tt)" size="mini">
                                        {{tt.maTieuChi}}</el-button>
                                </el-tooltip>
                                </td>
                                <td>
                                    <p>{{tt.tenTieuChi}}</p>
                                </td>
                                <td>
                                    <p>{{tt.moTa}}</p>
                                </td>
                                <td>
                                    <p>{{tt.doiTuong}}</p>
                                </td>
                                <td>
                                    <span v-for="(tag,j) in tt.relatedIndicators">
                                        <p class="btn btn-default" style="padding:3px; margin:0 2px;">
                                            {{tag}}</p>
                                    </span>
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
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import dialog from '../../../utils/dialog';
    import Page from "../../ui/PagingCustom3";
    import ESelectVue from '../../ui/ESelect.vue';
    import constant from '../../../utils/constant';
    export default {
        components: {
            Page,
            'eselect': ESelectVue,
        },
        data() {
            return {
                trangbatdau: false,
                total_rows: 0,
                start: 0,
                currentPage: 1,
                limit: 25,
                list_don_vi: [],
                list_cap_hoc: window.listCapHoc,
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_hoc_ky: [{
                        name: "Học kỳ I",
                        value: 1
                    },
                    {
                        name: "Học kỳ II",
                        value: 2
                    },
                    {
                        name: "Cả năm",
                        value: 3
                    },
                ],
                list_giai_doan: [{
                        name: 'Giữa kỳ I',
                        value: 'GK1'
                    },
                    {
                        name: 'Cuối kỳ II',
                        value: 'CK1'
                    },
                    {
                        name: 'Giữa kỳ I',
                        value: 'GK2'
                    },
                    {
                        name: 'Cuối kỳ II',
                        value: 'CK2'
                    },
                ],
                list_truong_hoc: [],
                maDonViQuanLy: '',
                capHoc: '',
                maTruongHoc: '',
                namHoc: '',
                hocKy: '',
                maGiaiDoan: '',
                ds_tieu_chi_trong: [],
                list_doi_tuong: [{
                        name: "Tiêu chí hệ thống",
                        value: "1"
                    },
                    {
                        name: "Tiêu chí người dùng",
                        value: "2"
                    },
                ],
                list_the_loai: [{
                        name: "Cán bộ, Giáo viên",
                        value: "GiaoVien"
                    },
                    {
                        name: "Lớp học",
                        value: "LopHoc"
                    },
                    {
                        name: "Kết quả học tập",
                        value: "KQHT"
                    },
                    {
                        name: "Trường học",
                        value: "TruongHoc"
                    },
                    {
                        name: "Học sinh",
                        value: "HocSinh"
                    },
                    {
                        name: "Tiêu chí ngoài",
                        value: "Custom"
                    },
                ],
                searchTerm: "",
                maTieuChi: "",
                tenTieuChi: "",
                idUpdate: "",
                doi_tuong: "",
                doiTuong: "",
                textSreach: "",
                tieu_chi_he_thong: "",
                thongtin: JSON.parse(window.userInfo),
                hienThi: {
                    maDonViQuanLy: false,
                    capHoc: false,
                    maTruongHoc: false,
                    namHoc: false,
                    hocKy: false,
                    maGiaiDoan: false,
                    tenTieuChi: true,
                    maTieuChi: true,
                    giaTri: true,
                },
            };
        },
        mounted: function () {
            console.log("Thông tin đăng nhập:")
            console.log(this.thongtin);
            this.namHoc = this.thongtin.namHocHienTai;
            this.getDonVi();
            this.getDanhSachToanBoTruong();
        },
        methods: {
            getTenDonVi(e) {
                let name = "";
                if (e) {
                    for (let i = 0; i < this.list_don_vi.length; i++) {
                        if (this.list_don_vi[i].maDonVi == e) {
                            name = this.list_don_vi[i].tenDonVi
                        }
                    }
                }
                return name;
            },
            getTenTruongHoc(e) {
                let name = "";
                if (e) {
                    for (let i = 0; i < this.list_truong_hoc.length; i++) {
                        if (this.list_truong_hoc[i].maTruongHoc == e) {
                            name = this.list_truong_hoc[i].tenTruongHoc
                        }
                    }
                }
                return name;
            },
            chonLoaiTieuChi() {
                this.total_rows = 0;
                this.ds_tieu_chi_trong = [];
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                this.list_don_vi = [];
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    console.log("Đơn vị trả về:")
                    console.log(data)
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
                    } else {}
                });
            },
            getDanhSachToanBoTruong() {
                this.loading = true;
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: [],
                    capHoc: []
                };
                if (this.maDonViQuanLy) {
                    params.maDonVi = [this.maDonViQuanLy];
                }
                if (this.capHoc) {
                    params.capHoc = [this.capHoc];
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    this.loading = false;
                    if (data.data.statusResponse == 0) {
                        let dulieu = data.data.rows;
                        let ldv = [];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenTruongHoc: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                maTruongHoc: dulieu[i].maTruongHoc
                            }
                            ldv.push(obj)
                        }
                        this.list_truong_hoc = ldv;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },
            saoChepMaTieuChi(e) {
                var copyText = e.maTieuChi;
                navigator.clipboard.writeText(copyText);
                this.thongBao('success', "Sao chép thành công.");
            },
            ChonCapHoc() {
                this.maTruongHoc = '';
                this.list_truong_hoc = [];
                this.getDanhSachToanBoTruong();
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
            getData() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.total_rows = 0;
                this.ds_tieu_chi_trong = [];
                let url = "/csdlgd-analytic-api/criteria/search?skip=" + this.start +
                    "&limit=" + this.limit
                var params = {
                    "doiTuong": this.doiTuong,
                    "maTieuChi": this.maTieuChi,
                    "tenTieuChi": this.tenTieuChi,
                    "textSreach": this.textSreach,
                };
                this.ds_tieu_chi_trong = [];
                rest_api.post(url, params, response => {
                    loading.close();
                    console.log("Lấy ds tiêu chí trả về:")
                    console.log("của:" + this.tieu_chi_he_thong);
                    console.log(response)
                    if (response.data.rc === 0) {
                        this.total_rows = response.data.total;
                        this.ds_tieu_chi_trong = response.data.rows;
                    } else {
                        this.thongBao('error', response.data.rd)
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
            checkTruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
        },
    };

</script>
<style scoped="scoped">
    p {
        margin: 0;
        padding: 0
    }

</style>

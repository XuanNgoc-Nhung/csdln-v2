<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a>
                <span>
                    <span class="kytu">
                        &raquo;</span> Tra cứu
                    <span class="kytu">
                        &raquo;</span>Thông tin y tế học sinh</span>
            </div>
        </div>
        <div>
            <div class="card-bieu-do">
                <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                    <el-form :model='dataSearch' :rules="rules" ref="ruleForm">
                        <el-col :span="8">
                            <label class="typo__label">Đơn vị quản lý </label>
                            <eselect style="width:100%" @change="chonDonVi" :disabled="thongtin.role>2" multiple
                                collapseTags v-model="donVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                                :fields="['tenDonVi','maDonVi']" />
                        </el-col>
                        <el-col :span="8">
                            <label class="typo__label">Cấp học </label>
                            <eselect style="width:100%" @change="chonCapHoc" :disabled="thongtin.role==5" multiple
                                collapseTags v-model="capHoc" :placeholder="'Chọn'" filterable
                                :data="danh_sach_cap_hoc_full" :fields="['name','id']" />
                        </el-col>
                        <el-col :span="8">
                            <label class="typo__label">Trường học <span style="color:#DC0101">*</span> </label>

                            <el-form-item prop="truongHoc">
                                <eselect style="width:100%" collapseTags v-model="dataSearch.truongHoc"
                                    @change="ChonTruongHoc" ref="namHoc" :disabled="thongtin.role==5" :placeholder="'Chọn'"
                                    filterable :data="list_truong_hoc" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <label class="typo__label">Khối học </label>
                            <eselect style="width:100%" multiple @change="ChonKhoiHoc" collapseTags v-model="khoiHoc"
                                :placeholder="'Chọn'" filterable :data="list_khoi_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :span="8">
                            <label class="typo__label">Lớp học </label>
                            <eselect style="width:100%" multiple collapseTags v-model="lopHoc" :placeholder="'Chọn'"
                                filterable :data="list_lop_hoc" :fields="['name','id']" />
                        </el-col>
                        <el-col :span="8">
                            <label class="typo__label">Năm học <span style="color:#DC0101">*</span> </label>

                            <el-form-item prop="namHoc">
                                <eselect style="width:100%" ref="namHoc" collapseTags v-model="dataSearch.namHoc" @change="ChonNamHoc"
                                    :placeholder="'Chọn'" filterable :data="list_nam_hoc" :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                    </el-form>
                    <el-col :span="24" class="text-center">
                        <el-button size="mini" @click.prevent="submitForm('ruleForm')" type="success">Tra cứu
                        </el-button>
                    </el-col>
                </el-row>
            </div>
        </div>
        <div>
            <el-row :gutter="20">
                <el-col :span="24">
                    <el-dialog title="Danh sách báo cáo thông tin sức khỏe học sinh" width="90%" top="5vh"
                        :visible.sync="hien_thi_danh_sach_file" @close="dongModal">
                        <div>
                            <table class="table table-striped table-bordered table-hover" style="font-size:12px; ">
                                <thead>
                                    <tr>
                                        <th class="text-center">STT</th>
                                        <th class="text-center">Lớp</th>
                                        <th class="text-center">Đường dẫn file</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_link_export_excel.length==0">
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <p>Không có dữ liệu</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <!-- list_truong_da_nop -->
                                    <tr v-for="(item, j) in list_link_export_excel">
                                        <td class="text-center">{{ j + 1 }}</td>
                                        <td>
                                            <p>{{ item.tilte }}</p>
                                        </td>
                                        <td>
                                            <p>{{thongtin.tenMien}}{{item.url}}</p>
                                        </td>
                                        <td class="text-center">
                                            <el-tooltip content="Xem file online" placement="left">
                                                <!-- <el-button size="mini" type="primary" @click="xemOnline(scope.row)"
                                                    icon="el-icon-view"></el-button> -->
                                                    <i class="el-icon-view"  @click="xemOnline(item)"></i>
                                            </el-tooltip>
                                            <el-tooltip content="Tải xuống" placement="top">
                                                <!-- <el-button size="mini" type="success" @click="taiXuong(scope.row)"
                                                    icon="el-icon-download"></el-button>
                                                     -->
                                                    <i class="el-icon-download"  @click="taiXuong(item)"></i>
                                            </el-tooltip>
                                            <el-tooltip content="Sao chép địa chỉ file" placement="right">
                                                <!-- <el-button size="mini" type="info" @click="saoChep(scope.row)"
                                                    icon="el-icon-copy-document"></el-button>
                                                     -->
                                                    <i class="el-icon-copy-document" @click="saoChep(item)"></i>
                                            </el-tooltip>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <span slot="footer" class="dialog-footer">
                            <el-tooltip content="Tải xuống toàn bộ file" placement="top" effect="dark">
                                <el-button type="primary" size="mini" @click="taiXuongToanBo">Tải xuống toàn bộ
                                </el-button>
                            </el-tooltip>
                            <el-tooltip content="Đóng" placement="top" effect="dark">
                                <el-button type="default" size="mini" @click="dongModal">Đóng</el-button>
                            </el-tooltip>
                        </span>
                    </el-dialog>
                </el-col>
            </el-row>
        </div>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
    import constant from '../../../utils/constant';
    import api from './../../api';
    export default {
        components: {
            'eselect': ESelectVue,
        },
        computed: {},
        data() {
            return {
                hien_thi_danh_sach_file: false,
                loading: false,
                thongtin: JSON.parse(window.userInfo),
                khoi_cap_mot: constant.khoiCapMot,
                khoi_cap_hai: constant.khoiCapHai,
                khoi_cap_ba: constant.khoiCapBa,
                khoi_cap_4: constant.khoiHocNhaTre,
                khoi_cap_5: constant.khoiHocMauGiao,
                donVi: [],
                dataSearch: {
                    truongHoc: '',
                    namHoc: ''
                },
                rules: {
                    truongHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                    namHoc: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: 'change'
                    }, ],
                },
                capHoc: [],
                khoiHoc: [],
                lopHoc: [],
                truongHoc: "",
                date: new Date(),
                namHoc: "",
                list_link_export_excel: [],
                list_don_vi: [],
                list_khoi_hoc: [],
                list_lop_hoc: [],
                danh_sach_cap_hoc_full: window.listCapHoc,
                list_truong_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                baseLink: "/view-excel?path=",
            }
        },
        mounted() {
            this.dataSearch.namHoc = this.thongtin.namHocHienTai;
            this.getDonVi();
            if (this.thongtin.role != 5) {
                this.getTruongHoc();
            } else {
                this.dataSearch.truongHoc = this.thongtin.ma_truong_hoc;
                if (this.thongtin.sso && this.thongtin.sso == true) {
                    console.error('Trường sso')
                    let obj = {
                        name: this.thongtin.display_name + ' - [' + this.thongtin.ma_truong_hoc + ']',
                        value: this.thongtin.ma_truong_hoc
                    }
                    this.list_truong_hoc = [obj]
                } else {
                    this.getThongTinTruong();
                }
            }
            console.error('Thông tin đăng nhập:')
            console.error(this.thongtin)
            this.mapKhoiHoc(this.thongtin.listCapHoc);
            if (this.thongtin.role == 5) {
                this.dataSearch.truongHoc = this.thongtin.ma_truong_hoc;
                this.capHoc = this.thongtin.listCapHoc;
                this.getLopHoc();
            }
            console.warn("thông tin đăng nhập:")
            // console.table(this.thongtin)
        },
        watch: {},
        methods: {
            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.layToanBoDuLieu();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            getThongTinTruong() {
                try {
                    let params = {
                        p_ma: this.thongtin.ma_truong_hoc
                    };
                    rest_api.get("/internal-api/dmTruongHoc/detail", params, response => {
                        console.log("lấy thông tin trường");
                        console.log(response)
                        if (response.data.code == 200) {
                            let obj = {
                                name: response.data.data.tenTruongHoc + ' - [' + this.thongtin
                                    .ma_truong_hoc + ']',
                                value: response.data.data.maTruongHoc
                            }
                            this.list_truong_hoc = [obj]
                        } else {
                            let obj = {
                                name: this.thongtin.username + ' - [' + this.thongtin.ma_truong_hoc + ']',
                                value: this.thongtin.ma_truong_hoc
                            }
                            this.list_truong_hoc = [obj]
                        }
                    });
                } catch (e) {

                }
            },
            saoChep(e) {
                let data = e;
                let url = this.thongtin.tenMien + data.url
                navigator.clipboard.writeText(url);
                this.thongBao('success', "Sao chép địa chỉ file thành công.");
            },
            taiXuong(e) {
                console.log("Tải xuống:");
                let data = e;
                let url = this.thongtin.tenMien + data.url;
                window.open(url);
            },
            xemOnline(e) {
                console.log("Xem online:");
                let data = e;
                let url = this.baseLink + this.thongtin.tenMien + data.url;
                window.open(url, '_blank');
            },
            dongModal() {
                this.hien_thi_danh_sach_file = false;
            },
            layToanBoDuLieu() {
                if (this.dataSearch.truongHoc == "" || !this.dataSearch.truongHoc) {
                    this.thongBao('error', 'Thiếu thông tin trường học');
                    return;
                }
                if (!this.dataSearch.namHoc || this.dataSearch.namHoc == "") {
                    this.thongBao('error', 'Thiếu thông tin năm học');
                    return;
                }
                let maNhomTuoiMns = [];
                let khoiHocTheoCap = [];
                if (this.khoiHoc.length > 0) {
                    for (let i = 0; i < this.khoiHoc.length; i++) {
                        if (this.khoiHoc[i] <= 12) {
                            khoiHocTheoCap.push(this.khoiHoc[i]);
                        } else {
                            if (this.khoiHoc[i] == 13) {
                                maNhomTuoiMns.push('01')
                            }
                            if (this.khoiHoc[i] == 14) {
                                maNhomTuoiMns.push('02')
                            }
                            if (this.khoiHoc[i] == 15) {
                                maNhomTuoiMns.push('03')
                            }
                            if (this.khoiHoc[i] == 16) {
                                maNhomTuoiMns.push('04')
                            }
                            if (this.khoiHoc[i] == 17) {
                                maNhomTuoiMns.push('05')
                            }
                            if (this.khoiHoc[i] == 18) {
                                maNhomTuoiMns.push('06')
                            }
                        }
                    }
                }
                let params = {
                    "maNhomTuoiMns": maNhomTuoiMns,
                    "capHocs": this.capHoc,
                    "khoiHocs": khoiHocTheoCap,
                    "maLopHocs": this.lopHoc,
                    "maTruongHoc": this.dataSearch.truongHoc.toUpperCase(),
                    "maSo": this.thongtin.ma_so,
                    "namHoc": this.dataSearch.namHoc,
                };
                if (this.thongtin.role == 5) {
                    params.capHocs = [];
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/download-excel/get-report-thong-tin-suc-khoe", params, (response) => {
                    loading.close();
                    if (response.data.rc == 0) {
                        this.list_link_export_excel = response.data.urlContexts;
                        if (this.list_link_export_excel.length > 0) {
                            this.list_link_export_excel.sort((a, b) => (a.tilte > b.tilte) ? 1 : -1);
                            this.hien_thi_danh_sach_file = true;
                            // this.thongBao('success', 'Lấy dữ liệu thành công.')
                        } else {
                            // this.thongBao('error', 'Không lấy được dữ liệu. Vui lòng thử lại.')
                        }
                    } else {
                        this.thongBao('error', response.data.rd)
                    }
                });
            },
            taiXuongToanBo() {
                var link = document.createElement('a');
                link.style.display = 'none';
                document.body.appendChild(link);
                for (var i = 0; i < this.list_link_export_excel.length; i++) {
                    let name = this.list_link_export_excel[i].url.replace("/file/temporary/", "")
                    link.setAttribute('download', name);
                    link.setAttribute('href', this.list_link_export_excel[i].url);
                    link.click();
                }
                document.body.removeChild(link);
            },
            ChonNamHoc() {
                this.lopHoc = [];
                this.list_lop_hoc = [];
                if (this.dataSearch.namHoc) {
                    this.getLopHoc();
                }
            },
            ChonTruongHoc() {
                this.lopHoc = [];
                this.list_lop_hoc = [];
                if (this.dataSearch.truongHoc) {
                    this.getLopHoc();
                }
            },
            ChonKhoiHoc() {
                this.lopHoc = [];
                this.list_lop_hoc = [];
                if (!this.dataSearch.truongHoc || this.dataSearch.truongHoc == '') {
                    this.thongBao('error', 'Chọn trường học để lấy danh sách lớp.')
                } else {
                    this.getLopHoc();
                }
            },
            getLopHoc() {
                let params = {
                    "colExcels": [],
                    "namHoc": this.dataSearch.namHoc,
                    "capHoc": this.capHoc,
                    "khoiHoc": this.khoiHoc,
                    "listMaTruongHocReq": [this.dataSearch.truongHoc],
                };
                if (this.thongtin.role == 5) {
                    params.capHoc = [];
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.list_lop_hoc = [];
                rest_api.post("/csdlgd-admin/lopHoc/search2", params, (response) => {
                    loading.close();
                    if (response.data.rc == 0) {
                        let arr = [];
                        let dulieu = response.data.tableData;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: 'Lớp ' + dulieu[i].tenLopHoc,
                                id: dulieu[i].maLopHoc
                            }
                            arr.push(obj)
                        }
                        arr.sort((a, b) => (a.name > b.name) ? 1 : -1);
                        this.list_lop_hoc = arr;
                    }
                });
            },
            mapKhoiHoc(e) {
                console.log("map cấp học đã chọn:")
                console.log(e)
                let dulieu = e;
                let khoihoc = [];
                if (dulieu) {
                    for (let i = 0; i < dulieu.length; i++) {
                        if (dulieu[i] == 1) {
                            khoihoc = khoihoc.concat(this.khoi_cap_mot)
                        };
                        if (dulieu[i] == 2) {
                            khoihoc = khoihoc.concat(this.khoi_cap_hai)
                        };
                        if (dulieu[i] == 3) {
                            khoihoc = khoihoc.concat(this.khoi_cap_ba)
                        };
                        if (dulieu[i] == 4) {
                            khoihoc = khoihoc.concat(this.khoi_cap_4)
                        };
                        if (dulieu[i] == 5) {
                            khoihoc = khoihoc.concat(this.khoi_cap_5)
                        };
                        if (dulieu[i] == 45) {
                            khoihoc = khoihoc.concat(this.khoi_cap_4, this.khoi_cap_5)
                        };
                        if (dulieu[i] == 6) {
                            khoihoc = khoihoc.concat(this.khoi_cap_mot, this.khoi_cap_hai, this.khoi_cap_ba, this
                                .khoi_cap_4, this.khoi_cap_5)
                        };
                    }
                } else {
                    khoihoc = khoihoc.concat(this.khoi_cap_mot, this.khoi_cap_hai, this.khoi_cap_ba, this
                        .khoi_cap_4, this.khoi_cap_5)
                }
                console.log("Khối học sau map:");
                khoihoc.sort((a, b) => (a.id > b.id) ? 1 : -1);
                let khoihoc_unique = [];
                khoihoc_unique = [...new Set(khoihoc.map(item => item))];
                this.list_khoi_hoc = khoihoc_unique;
            },
            chonCapHoc() {
                this.lopHoc = [];
                this.list_lop_hoc = [];
                this.list_truong_hoc = [];
                this.khoiHoc = [];
                this.dataSearch.truongHoc = "";
                this.getTruongHoc();
                this.mapKhoiHoc(this.capHoc)
            },
            chonDonVi() {
                this.lopHoc = [];
                this.list_lop_hoc = [];
                this.list_truong_hoc = [];
                this.dataSearch.truongHoc = "";
                this.getTruongHoc();
            },
            TongHopDuLieuNhaTruong() {
                if (this.dataSearch.truongHoc == "" || !this.dataSearch.truongHoc) {
                    this.thongBao('error', 'Thiếu thông tin trường học');
                    return;
                }
                if (!this.dataSearch.namHoc || this.dataSearch.namHoc == "") {
                    this.thongBao('error', 'Thiếu thông tin năm học');
                    return;
                }
                console.log("Ấn tổng hợp")
                let url = "xuat-excel-du-thong-tin-y-te-hoc-sinh";
                let params = {
                    namHoc: this.dataSearch.namHoc,
                    maTruongHoc: this.dataSearch.truongHoc.toUpperCase()
                };
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.thongBao('success','Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(url, params, (data) => {
                            loading.close();
                            console.log("Dữ liệu trả về:")
                            console.log(data)
                            let a = document.createElement('a');
                            a.href = data.data.file;
                            document
                                .body
                                .appendChild(a);
                            a.click();
                            document
                                .body
                                .removeChild(a);
                        });
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
                        this.list_don_vi.sort((a, b) => (a.tenDonVi > b.tenDonVi) ? 1 : -1);
                        if (this.thongtin.role > 3) {
                            if (this.thongtin.ma_phong && this.thongtin.ma_phong != "") {
                                this.donVi = [this.thongtin.ma_phong]
                            } else {
                                this.donVi = [this.thongtin.ma_so];
                            }
                        }
                    } else {
                        this.$alertify.error(data.data.message);
                    }
                });
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                let params = {
                    maDonVi: this.donVi,
                    capHoc: this.capHoc,
                    loose: true
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    // loading.close();
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
                        data_demo.sort((a, b) => (a.name > b.name) ? 1 : -1);
                        this.list_truong_hoc = data_demo;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },
        }
    }

</script>

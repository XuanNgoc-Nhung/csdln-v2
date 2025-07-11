<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :span="20">
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Đơn vị: <span class="red" v-if="!dataSearch.tuKhoa||dataSearch.tuKhoa==''">*</span></label>
                <eselect multiple collapseTags v-model="dataSearch.donVis"
                         @change="ChonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Cấp học</label>
                <eselect collapseTags v-model="dataSearch.capHoc"
                         @change="chonCapHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Khối học</label>
                <eselect collapseTags v-model="dataSearch.khoiHoc" :placeholder="'Chọn'" filterable
                         :data="list_khoi_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Trường học:</label>
                <eselect multiple collapseTags v-model="dataSearch.truongHocs" :placeholder="'Chọn'" filterable
                         :data="list_truong_hoc"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Năm học:</label>
                <eselect collapseTags v-model="dataSearch.namHoc" :placeholder="'Chọn'" filterable :data="list_nam_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Từ khoá</label>
                <el-input clearable placeholder="Email hoặc mã học sinh.." v-model="dataSearch.tuKhoa"></el-input>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Tên lớp</label>
                <el-input clearable placeholder="Nhập..." v-model="dataSearch.tenLop"></el-input>
            </el-col>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="24" class="text-center">
                <el-tooltip effect="dark" content="Tìm kiếm" placement="top">
                    <el-button @click.prevent="checkTruocKhiTim" size="mini" type="success">Tìm kiếm</el-button>
                </el-tooltip>
                <el-tooltip effect="dark" content="Import dữ liệu" placement="top">
                    <el-button size="mini" @click.prevent="showImport" type="primary">Import dữ liệu</el-button>
                </el-tooltip>
                <el-tooltip effect="dark" content="Xuất Excel" placement="top">
                    <el-button size="mini" @click.prevent="XuatExcel" type="success">Xuất Excel</el-button>
                </el-tooltip>
                <el-tooltip effect="dark" content="Xoá dữ liệu" placement="top">
                    <el-button :disabled="list_hoc_sinh_checked.length==0" size="mini" @click.prevent="XoaDuLieu"
                               type="danger">Xoá
                    </el-button>
                </el-tooltip>
            </el-col>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="24">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr style="background:#e4ebf5">
                            <th class="text-center"><p>STT</p></th>
                            <th class="text-center"><p>Mã học sinh</p></th>
                            <th class="text-center"><p>Tên học sinh</p></th>
                            <th class="text-center"><p>Giới tính</p></th>
                            <th class="text-center"><p>Ngày sinh</p></th>
                            <th class="text-center"><p>Lớp học</p></th>
                            <th class="text-center"><p>Địa chỉ</p></th>
                            <th class="text-center"><p>Số CMND</p></th>
                            <th class="text-center"><p>Số điện thoại</p></th>
                            <th class="text-center"><p>Ngày cập nhật</p></th>
                            <th class="text-center"><p>Thao tác</p></th>
                            <th class="text-center">
                                <el-checkbox @change="chonTatCa" v-model="checkAll">Tất cả</el-checkbox>
                            </th>
                        </tr>
                        </thead>
                        <tbody v-if="list_hoc_sinh_.length==0">
                        <tr>
                            <td colspan="14">
                                <p class="text-center">Không có dữ liệu</p>
                            </td>
                        </tr>
                        </tbody>
                        <tbody v-else>
                        <tr v-for="(item,i) in list_hoc_sinh_"
                            :key="i">
                            <td class="text-center"><p>{{ (paginate.curentPage - 1) * paginate.limit + i + 1 }}</p>
                            </td>
                            <td class="text-center"><p>{{ item.maHocSinh }}</p></td>
                            <td><p>{{ item.hoTen }}</p></td>
                            <td class="text-center"><p>{{ parseInt(item.gioiTinh) === 1 ? 'Nam' : 'Nữ' }}</p></td>
                            <td><p>{{ item.ngaySinh }}</p></td>
                            <td class="text-center"><p>{{ item.maLopHoc }}</p></td>
                            <td><p>{{ item.dchiThtru }}</p></td>
                            <td><p>{{ item.soCmnd }}</p></td>
                            <td class="text-center"><p>{{ item.soDthoaiDdong }}</p></td>
                            <td class="text-center"><p>{{ item.ngayCapNhat }}</p></td>
                            <td class="text-center">
                                <el-tooltip content="Chỉnh sửa" placement="left">
                                    <el-button type="warning" @click.prevent="showUpdate(item)" size="mini">
                                        <i class="el-icon-edit"></i>
                                    </el-button>
                                </el-tooltip>
                            </td>
                            <td class="text-center">
                                <input type="checkbox"
                                       @change="chonMoiBanGhi"
                                       v-model="list_hoc_sinh_checked" :value="item.maHocSinh"/>
                                <span style="font-size:12px"></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :batdau="paginate.startPage"  :total_rows="paginate.total" @pageChange="layLaiDuLieu($event)"></Pagination>
            </el-col>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="24">
                <ImportFile v-if="show_import" @close="show_import = false"
                            :text_header="'Import dữ liệu học sinh'"
                            :nam_hoc="dataSearch.namHoc"
                            :sample_file_path="fileMau"
                            @success='importSuccess'
                            :path_import="'/api-import-du-lieu-sso-hoc-sinh'"></ImportFile>

                <ExportFileExcel v-if="show_export" @close="show_export = false"
                                 @checkSuccess='checkExportSuccess($event)'
                                 :params_export="paramsExport"
                ></ExportFileExcel>
                <ChinhSua v-if="show_update" @close="show_update=false" @updateSuccess="chinhSuaThanhCong"
                          :item="dataEdit"></ChinhSua>
            </el-col>
        </el-row>
    </div>
</template>
<script>
import ExportFileExcel from '../../ui/popUpExportExcelUseStartLimit.vue';
import ChinhSua from './chinhSuaHocSinh'
import ESelectVue from '../../ui/ESelect.vue';
import Pagination from '../../ui/PagingCustom';
import rest_api from "../../../utils/rest_api";
import constant from "../../../utils/constant";
import ImportFile from "./Import"
import api from "../../api";

export default {
    components: {
        'eselect': ESelectVue,
        Pagination,
        ImportFile,
        ExportFileExcel,
        ChinhSua,
    },
    watch: {},
    data() {
        return {
            fileMau: 'https://dongbo.csdl.edu.vn/exportExcel/FileUpLoadDuLieuHocSinh.xlsx',
            loading: {
                status: false,
                text: 'Loading...'
            },
            thongtin: {},
            paginate: {
                startPage:true,
                start: 0,
                limit: 25,
                total: 0,
                curentPage: 1
            },
            dataSearch: {
                donVis: [],
                capHoc: '',
                truongHocs: [],
                khoiHoc: '',
                tenLop: '',
                namHoc: '',
                tuKhoa: ''
            },
            list_don_vi: [],
            list_cap_hoc: window.listCapHoc,
            list_khoi_hoc: [],
            list_truong_hoc: [],
            list_nam_hoc: constant.LIST_YEARS_FULL,
            list_hoc_sinh_: [],
            show_import: false,
            show_export: false,
            paramsExport: {
                total: 0,
                recodOnPage: 25,
            },
            show_update: false,
            checkAll: false,
            dataEdit: {},
            list_hoc_sinh_checked: [],
            khoi_cap_mot: constant.khoiCapMot,
            khoi_cap_hai: constant.khoiCapHai,
            khoi_cap_ba: constant.khoiCapBa,
            khoi_cap_4: constant.khoiHocNhaTre,
            khoi_cap_5: constant.khoiHocMauGiao,
        }
    },
    mounted() {
        console.log('Mount dữ liệu học sinh');
        this.thongtin = JSON.parse(window.userInfo);
        this.dataSearch.namHoc = this.thongtin.namHocHienTai;
        this.getKhoiHoc(this.thongtin.listCapHoc);
        this.getDonVi();
        this.getTruongHoc();
    },
    methods: {
        getKhoiHoc(e) {
            let dulieu = e;
            let khoihoc = [];
            if (dulieu) {
                for (let i = 0; i < dulieu.length; i++) {
                    if (dulieu[i] == 1) {
                        khoihoc = khoihoc.concat(this.khoi_cap_mot)
                    }
                    ;
                    if (dulieu[i] == 2) {
                        khoihoc = khoihoc.concat(this.khoi_cap_hai)
                    }
                    ;
                    if (dulieu[i] == 3) {
                        khoihoc = khoihoc.concat(this.khoi_cap_ba)
                    }
                    ;
                    if (dulieu[i] == 4) {
                        khoihoc = khoihoc.concat(this.khoi_cap_4)
                    }
                    ;
                    if (dulieu[i] == 5) {
                        khoihoc = khoihoc.concat(this.khoi_cap_5)
                    }
                    ;
                    if (dulieu[i] == 45) {
                        khoihoc = khoihoc.concat(this.khoi_cap_4, this.khoi_cap_5)
                    }
                    ;
                    if (dulieu[i] == 6) {
                        khoihoc = khoihoc.concat(this.khoi_cap_mot, this.khoi_cap_hai, this.khoi_cap_ba, this
                            .khoi_cap_4, this.khoi_cap_5)
                    }
                    ;
                }
            } else {
                khoihoc = khoihoc.concat(this.khoi_cap_mot, this.khoi_cap_hai, this.khoi_cap_ba, this
                    .khoi_cap_4, this.khoi_cap_5)
            }
            khoihoc.sort((a, b) => (a.id > b.id) ? 1 : -1);
            let khoihoc_unique = [];
            khoihoc_unique = [...new Set(khoihoc.map(item => item))];
            this.list_khoi_hoc = khoihoc_unique;
        },
        XoaDuLieu() {
            if (this.list_hoc_sinh_checked.length == 0) {
                this.thongBao('warning', 'Vui lòng chọn học sinh cần xoá');
            } else {
                this.$confirm('Xác nhận xoá thông tin các học sinh đã chọn?', 'Thông báo', {
                    confirmButtonText: 'Xác nhận',
                    cancelButtonText: 'Hủy',
                    closeOnClickModal: false,
                })
                    .then(_ => {
                        let params = {
                            lstMa: this.list_hoc_sinh_checked,
                            namHoc: this.dataSearch.namHoc
                        };
                        this.loading.text = 'Đang xoá dữ liệu';
                        this.loading.status = true;
                        rest_api.post("/csdlgd-admin/sso/deleteHocSinh", params, response => {
                            if (response.data.rc == 0) {
                                this.thongBao('success', 'Xoá dữ liệu thành công');
                                this.getData();
                            } else {
                                this.thongBao(response.data.rd);
                                this.loading.status = false;
                            }
                        });
                    })
                    .catch(_ => {
                    });
            }
        },
        chonMoiBanGhi() {
            console.log('chonMoiBanGhi');
            if (this.list_hoc_sinh_checked.length == this.list_hoc_sinh_.length) {
                this.checkAll = true;
            } else {
                this.checkAll = false;
            }
        },
        chinhSuaThanhCong() {
            console.log('chinhSuaThanhCong');
            this.show_update = false;
            this.getData();
        },
        chonTatCa() {
            if (this.checkAll) {
                console.log('Chọn tất cả');
                let countSelected = 0;
                for (let i = 0; i < this.list_hoc_sinh_.length; i++) {
                    countSelected += 1;
                    this
                        .list_hoc_sinh_checked
                        .push(this.list_hoc_sinh_[i].maHocSinh);

                }
                if (countSelected == 0) {//Không chọn được bản ghi nào
                    this.thongBao('error', 'Danh sách học sinh trống');
                    this.checkAll = false;
                    return;
                } else {
                    this.thongBao('success', 'Đã chọn ' + this.list_hoc_sinh_.length + ' học sinh')
                }
            } else {
                console.log('Bỏ chọn tất cả');
                this.list_hoc_sinh_checked = [];
            }

        },
        showUpdate(item) {
            console.log('showUpdate')
            console.log(item)
            this.dataEdit = item;
            this.dataEdit.namHoc = this.dataSearch.namHoc;
            this.show_update = true;
        },
        XuatExcel() {
            console.log('Xuất excel');
            this.paramsExport.total = this.paginate.total;
            this.paramsExport.recodOnPage = this.paginate.limit;
            this.show_export = true;
        },
        checkExportSuccess(e) {
            console.log('checkExportSuccess')
            console.log(e)
            let url = "xuat-excel-du-lieu-sso";
            let params = {
                type: 1,//Dữ liệu học sinh
                start: e.start,
                limit: e.limit,
                Keyword: this.dataSearch.tuKhoa,
                lstMaDonVi: this.dataSearch.donVis,
                lstMaTruongHoc: this.dataSearch.truongHocs,
                namHoc: this.dataSearch.namHoc,
                maKhoi: this.dataSearch.khoiHoc,
                tenLop: this.dataSearch.tenLop,
            };
            this.loading.text = 'Đang tải dữ liệu...';
            this.loading.status = true;
            api.post(url, params, (data) => {
                setTimeout(() => {
                    this.loading.status = false;

                    let a = document.createElement('a');
                    a.href = data.data.file;
                    document
                        .body
                        .appendChild(a);
                    a.click();
                    document
                        .body
                        .removeChild(a);
                    if (!e.export_all) {//Xuất chưa hết dữ liệu
                        this.$confirm('Đã tải xuống dữ liệu. Tiếp tục tải các trang còn lại?', 'Thông báo', {
                            confirmButtonText: 'Xác nhận',
                            cancelButtonText: 'Hủy',
                            closeOnClickModal: false,
                        })
                            .then(_ => {
                            })
                            .catch(_ => {
                                this.show_export = false;
                            });
                    } else {
                        this.show_export = false;
                    }
                }, 1000)
            });
        },
        importSuccess() {
            console.log('importSuccess')
            this.thongBao('success', 'Import thành công')
            this.show_import = false;
        },
        showImport() {
            console.log("Hiển thị import file");
            this.show_import = true;
        },
        layLaiDuLieu(e) {
            this.paginate.start = e.start;
            this.paginate.limit = e.limit;
            this.paginate.curentPage = e.currentPage;
            this.getData()

        },
        checkTruocKhiTim() {
            console.log('Check trước khi tìm')
            this.paginate.startPage = !this.paginate.startPage;
        },
        getData() {
            console.log("Lấy dữ liệu");
            this.checkAll = false;
            this.list_hoc_sinh_checked = [];
            try {
                if (!this.dataSearch.tuKhoa || this.dataSearch.tuKhoa == '') {
                    if (!this.dataSearch.donVis || this.dataSearch.donVis.length == 0) {
                        this.thongBao('error', 'Vui lòng bổ sung thông tin đơn vị')
                        return;
                    }
                }
                let params = {
                    offset: this.paginate.start,
                    limit: this.paginate.limit,
                    Keyword: this.dataSearch.tuKhoa,
                    lstMaDonVi: this.dataSearch.donVis,
                    lstMaTruongHoc: this.dataSearch.truongHocs,
                    namHoc: this.dataSearch.namHoc,
                    maKhoi: this.dataSearch.khoiHoc,
                    tenLop: this.dataSearch.tenLop,
                };
                this.loading.text = 'Đang lấy dữ liệu...';
                this.loading.status = true;
                rest_api.post("/csdlgd-admin/sso/hocSinh", params, response => {
                    console.log("Dữ liệu học sinh:")
                    console.log(response)
                    if (response && response && response.data.listDanhSachHocSinh) {
                        this.list_hoc_sinh_ = response.data.listDanhSachHocSinh;
                        this.paginate.total = response.data.total;
                        if (this.paginate.total > 0) {
                            // this.thongBao('success', 'Lấy dữ liệu thành công');
                        } else {
                            // this.thongBao('warning', 'Không tìm thấy dữ liệu');
                        }
                    } else {
                        this.thongBao('error', 'Không tìm thấy dữ liệu');
                    }
                    this.loading.status = false;
                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
            }
        },
        chonCapHoc() {
            console.log('Chọn cấp học:');
            this.dataSearch.truongHocs = [];
            this.dataSearch.khoiHoc = '';
            this.list_truong_hoc = [];
            if (this.dataSearch.capHoc) {
                this.getKhoiHoc([this.dataSearch.capHoc]);
            } else {
                this.getKhoiHoc(this.thongtin.listCapHoc);
            }
            this.getTruongHoc();
        },
        ChonDonVi() {
            console.log('Chọn đơn vị:');
            this.dataSearch.truongHocs = [];
            this.list_truong_hoc = [];
            this.getTruongHoc();
        },
        getTruongHoc() {
            console.log("Lấy danh sách trường học")
            try {
                let params = {
                    maDonVi: this.dataSearch.donVis,
                    capHoc: []
                };
                if (this.dataSearch.capHoc) {
                    params.capHoc = [this.dataSearch.capHoc]
                }
                this.loading.text = 'Lấy danh sách trường học...'
                this.loading.status = true;
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, response => {
                    if (response.data.statusResponse == 0) {
                        let dulieu = response.data.rows;
                        let ldv = [];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                value: dulieu[i].maTruongHoc
                            }
                            ldv.push(obj)
                        }
                        this.list_truong_hoc = ldv;
                    } else {
                        this.list_truong_hoc = [];
                    }
                    this.loading.status = false
                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
            }
        },
        getDonVi() {
            try {
                console.log("Lấy danh sách đơn vị:")
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                this.loading.status = true;
                this.loading.text = 'Lấy danh sách đơn vị';
                rest_api.get("/internal-api/dmDonVi/filter", params, (response) => {
                    console.log("res lấy đơn vị:")
                    console.log(response)
                    if (response.data.code == 200) {
                        let ldv = []
                        let dulieu = response.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                value: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi = ldv;
                    } else {

                    }
                    this.loading.status = false;
                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
            }
        },

        thongBao(typeNoty, message) {
            let msg = "";
            let cl = "";
            if (message) {
                msg = message;
            }
            let type = "success";
            if (typeNoty) {
                type = typeNoty
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
                type: type,
                duration: 5000
            });
        },
    }
}

</script>
<style scoped="scoped">
.mauDo {
    background: #f3cccc !important;
}

</style>

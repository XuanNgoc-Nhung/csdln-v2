<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :span="24" class="text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Tra cứu <span class="kytu">
                        &raquo;</span> Trường học</span>
            </el-col>
        </el-row>
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Đơn vị:</label>
                <eselect collapseTags v-model="dataSearch.madonvi"
                         @change="chonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Cấp học</label>
                <eselect collapseTags v-model="dataSearch.caphoc"
                         @change="chonCapHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Nhóm cấp học</label>
                <eselect collapseTags v-model="dataSearch.maNhomCapHoc"
                         @change="chonCapHoc" :placeholder="'Chọn'" filterable :data="list_nhom_cap_hoc"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Trạng thái</label>
                <eselect collapseTags v-model="dataSearch.trangthai"
                         @change="chonCapHoc" :placeholder="'Chọn'" filterable :data="list_trang_thai"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Mã trường học</label>
                <el-input clearable placeholder="Nhập..." v-model="dataSearch.ma"></el-input>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Tên trường học</label>
                <el-input clearable placeholder="Nhập..." v-model="dataSearch.ten"></el-input>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Loại hình đào tạo</label>
                <eselect collapseTags v-model="dataSearch.loaihinhdaotao"
                         @change="chonCapHoc" :placeholder="'Chọn'" filterable :data="list_loai_hinh_dao_tao"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :span="24" class="text-center">
                <el-button size="mini" type="success" @click.prevent="getDataPageOne">Tìm kiếm</el-button>
                <el-button size="mini" type="primary" @click.prevent="showExport">Xuất Excel</el-button>
            </el-col>
        </el-row>
        <el-row :gutter="24" class="card-bieu-do mt-15">
            <el-col :span="24" class="text-right">
                <el-tooltip effect="dark" content="Nhập dữ liệu từ file mẫu" placement="top">
                    <el-button @click.prevent="showImport" size="mini" type="success">Import</el-button>
                </el-tooltip>
                <el-tooltip effect="dark" content="Thêm mới trường học" placement="top">
                    <el-button @click.prevent="showAdd" size="mini" type="primary">Thêm mới</el-button>
                </el-tooltip>
            </el-col>
            <el-col :span="24" class="pd-t-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr style="background:#e4ebf5">
                            <th class="text-center"><p>STT</p></th>
                            <th class="text-center"><p>Mã trường</p></th>
                            <th class="text-center"><p>Tên trường</p></th>
                            <th class="text-center"><p>Cấp học</p></th>
                            <th class="text-center"><p>Nhóm cấp học</p></th>
                            <th class="text-center"><p>Đơn vị</p></th>
                            <th class="text-center"><p>Quận huyện</p></th>
                            <th class="text-center"><p>Tỉnh thành</p></th>
                            <th class="text-center"><p>Loại hình đào tạo</p></th>
                            <th class="text-center"><p>Trạng thái</p></th>
                            <th class="text-center"><p>Điểm trường</p></th>
                            <th class="text-center"><p>Thao tác</p></th>
                        </tr>
                        </thead>
                        <tbody v-if="list_data.length==0">
                        <tr>
                            <td colspan="7">
                                <p class="text-center">Không có dữ liệu</p>
                            </td>
                        </tr>
                        </tbody>
                        <tbody v-else>
                        <tr v-for="(item,i) in list_data"
                            :key="i">
                            <td class="text-center"><p>{{ (paginate.curentPage - 1) * paginate.limit + i + 1 }}</p>
                            </td>
                            <td><p>{{ item.maTruongHoc }}</p></td>
                            <td><p>{{ item.tenTruongHoc }}</p></td>
                            <td><p>{{ getTenCapHoc(item.capHoc) }}</p></td>
                            <td><p>{{ getTenNhomCapHoc(item.maNhomCapHoc) }}</p></td>
                            <td><p>{{ getTenDonVi(item.tenDonVi) }}</p></td>
                            <td><p>{{ item.tenQuanHuyen }}</p></td>
                            <td><p>{{ item.tenTinhThanh }}</p></td>
                            <td><p>{{ getLoaiHinhDaoTao(item.loaiHinhDaoTao) }}</p></td>
                            <td class="text-center">
                                <el-button :type="getStatusType(item.trangThai)" size="mini">
                                    {{ getTrangThai(item.trangThai) }}
                                </el-button>
                            </td>
                            <td class="text-center">
                                <el-tooltip effect="dark" content="Xem danh sách điểm trường"
                                            placement='left'>
                                    <el-button type="info" size="mini">Danh sách</el-button>
                                </el-tooltip>
                            </td>
                            <td class="text-center">
                                <el-tooltip effect="dark" content="Xem thông tin chi tiết"
                                            placement='left'>
                                    <el-button type="primary" size="mini" icon="el-icon-view"></el-button>
                                </el-tooltip>
                                <el-tooltip effect="dark" content="Chỉnh sửa thông tin"
                                            placement='left'>
                                    <el-button type="warning" size="mini" icon="el-icon-edit"></el-button>
                                </el-tooltip>
                                <el-tooltip effect="dark" content="Xoá "
                                            placement='left'>
                                    <el-button type="danger" size="mini" icon="el-icon-delete-solid"></el-button>
                                </el-tooltip>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :batdau="paginate.startPage" :total_rows="paginate.total"
                            @pageChange="layLaiDuLieu($event)"></Pagination>
            </el-col>
        </el-row>
        <el-row :gutter="20">
            <el-col :span="24">
                <ExportFileExcel v-if="show_export" @close="show_export = false"
                                 @checkSuccess='checkExportSuccess($event)'
                                 :params_export="paramsExport"
                ></ExportFileExcel>

                <ImportFile v-if="show_import" @close="show_import = false"
                            :text_header="'Import dữ liệu trường học'"
                            :nam_hoc="dataSearch.namHoc"
                            :sample_file_path="sampleFilesImport"
                            @success='importSuccess'
                            :path_import="'/api-import-truong-hoc'"></ImportFile>

                <themMoi v-if="show_add"
                         @close="show_add = false" @addSuccess="addSuccess"></themMoi>
            </el-col>
        </el-row>
    </div>
</template>
<script>
import ElementUI from 'element-ui';
import rest_api from "../../../utils/rest_api";
import ESelectVue from '../../ui/ESelect.vue';
import ExportFileExcel from '../../ui/popUpExportExcelUseStartLimit.vue';
import constant from "../../../utils/constant";
import Pagination from '../../ui/PagingCustom';
import ImportFile from '../../ui/ImportExcel';
import themMoi from './add';
import api from "../../api";
Vue.use(ElementUI);
export default {
    components: {
        themMoi,
        ImportFile,
        ExportFileExcel,
        Pagination,
        'eselect': ESelectVue,
    },
    watch: {},
    data() {
        return {
            thongtin: {},
            loading: {
                text: 'Loading...',
                status: false,
            },
            paginate: {
                start: 0,
                limit: 25,
                total: 0,
                curentPage: 1,
                startPage: false,
            },
            dataSearch: {
                capHoc: '',
                madonvi: '',
                maNhomCapHoc: '',
                trangthai: '',
                ma: '',
                ten: '',
                loaihinhdaotao: '',
            },
            list_don_vi: [],
            list_cap_hoc: window.listCapHoc,
            list_nhom_cap_hoc: [
                {name: 'Mầm non', value: '01'},
                {name: 'Mẫu giáo', value: '02'},
                {name: 'Nhà trẻ', value: '03'},
                {name: 'Nhóm nhà trẻ độc lập', value: '04'},
                {name: 'Lớp mẫu giáo độc lập', value: '05'},
                {name: 'Tiểu học', value: '06'},
                {name: 'THCS', value: '07'},
                {name: 'THPT', value: '08'},
                {name: 'PTCS', value: '09'},
                {name: 'Trung học', value: '10'},
                {name: 'Phổ thông', value: '11'},
                {name: 'GDTX Tỉnh', value: '12'},
                {name: 'GDTX Huyện', value: '13'},
                {name: 'TTKTTHHN', value: '14'},
                {name: 'Lớp nhô', value: '15'},
                {name: 'MN-TH', value: '16'},
                {name: 'MN-PT', value: '17'},
                {name: 'MN-PTCS', value: '18'},
                {name: 'Nhóm trẻ, lớp mẫu giáo độc lập', value: '19'},
            ],
            list_trang_thai: [
                {name: 'Đang hoạt động', value: 1},
                {name: 'Ngừng hoạt động', value: 0},
                {name: 'Đã xoá', value: -1},
            ],
            list_loai_hinh_dao_tao: [
                {
                    name: "Dân lập",
                    value: "5"
                },
                {
                    name: "Tư thục",
                    value: "2"
                },
                {
                    name: "Công lập",
                    value: "1"
                },
                {
                    name: "GDTX",
                    value: "3"
                },
            ],
            list_data: [],
            show_add:false,
            show_export:false,
            paramsExport:{
                total: 0,
                recodOnPage: 25,
            },
            show_import:false,
            sampleFilesImport:'https://dongbo.csdl.edu.vn/exportExcel/templateImport/Template_Truong_Hoc.xlsx'
        }
    },
    mounted() {
        this.thongtin = JSON.parse(window.userInfo);
        console.log('Mount tra cứu trường học');
        console.warn(this.thongtin);
        this.getDonVi();
        this.getDataPageOne();
    },
    methods: {
        addSuccess(){
            console.log('addSuccess')
        },
        importSuccess() {
            console.log('importSuccess')
            this.thongBao('success', 'Import thành công')
            this.show_import = false;
        },
        showImport(){
            console.log('showImport')
            this.show_import=true;
        },
        checkExportSuccess(e){
            console.log('checkExportSuccess')
            let params = {
                start: e.start,
                limit: e.limit,
                caphoc: this.dataSearch.capHoc,
                loaihinhdaotao: this.dataSearch.loaihinhdaotao,
                ma: this.dataSearch.ma,
                maNhomCapHoc: this.dataSearch.maNhomCapHoc,
                madonvi: this.dataSearch.madonvi,
                matinhthanh: this.thongtin.ma_so,
                ten: this.dataSearch.ten,
                trangthai: this.dataSearch.trangthai,
            };
            let url = "xuat-excel-danh-sach-truong-hoc";
            this.$confirm('Xác nhận?', 'Thông báo', {
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy',
                closeOnClickModal: false,
            })
                .then(_ => {
                    this.loading.text = 'Đang lấy dữ liệu...';
                    this.loading.status = true;
                    api.post(url, params, (data) => {
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
                    });
                })
                .catch(_ => {});
        },
        showExport(){
            console.log('showExport');
            this.paramsExport.total = this.paginate.total;
            this.paramsExport.recodOnPage = this.paginate.limit;
            this.show_export = true;
        },
        showAdd(){
            console.log('showAdd');
            this.show_add = true;
        },
        getTrangThai(loai) {
            var res = parseInt(loai);
            switch (loai) {
                case 1:
                    res = 'Đang hoạt động'
                    break;
                case 0:
                    res = 'Ngừng hoạt động'
                    break;
                case -1:
                    res = 'Đã xóa'
                    break;
                default:
                    res = loai;
            }
            return res;
        },
        getStatusType(check) {
            var res = parseInt(check);
            switch (check) {
                case 1:
                    res = 'success'
                    break;
                case 0:
                    res = 'warning'
                    break;
                case -1:
                    res = 'danger'
                    break;
                default:
                    res = check;
            }
            return res;
        },
        getLoaiHinhDaoTao(loai) {
            var res = loai;
            for (let i = 0; i < this.list_loai_hinh_dao_tao.length; i++) {
                if (this.list_loai_hinh_dao_tao[i].value == res) {
                    return this.list_loai_hinh_dao_tao[i].name;
                }
            }
        },
        getTenDonVi(name) {
            let result = '';
            if (name) {
                result = name.replace("Giáo dục và Đào tạo", "GD&ĐT");
            }
            return result
        },
        getTenNhomCapHoc(loai) {
            var res = '';
            for (let i = 0; i < this.list_nhom_cap_hoc.length; i++) {
                if (this.list_nhom_cap_hoc[i].value == loai) {
                    res = this.list_nhom_cap_hoc[i].name;
                }
            }
            return res;
        },
        getTenCapHoc(e) {
            var res = null;
            for (let i = 0; i < this.list_cap_hoc.length; i++) {
                if (this.list_cap_hoc[i].id == e) {
                    res = this.list_cap_hoc[i].name;
                }
            }
            if (res === null) {
                res = 'Liên cấp ' + e;
            }
            return res;
        },
        layLaiDuLieu(e) {
            console.log('layLaiDuLieu');
            this.paginate.start = e.start;
            this.paginate.limit = e.limit;
            this.paginate.curentPage = e.currentPage;
            this.getData()
        },
        getData() {
            console.log('getData');
            this.list_data = [];
            this.paginate.total = 0;
            try {
                let startLimit = {
                    "start": this.paginate.start,
                    "limit": this.paginate.limit,
                };
                let params = {...startLimit, ...this.dataSearch};
                console.log('Thông tin lấy dữ liệu')
                console.log(params)
                this.loading.text = 'Đang lấy dữ liệu...';
                this.loading.status = true;
                rest_api.get("/internal-api/dmTruongHoc/filter", params, (response) => {
                    console.log('res danh sách  trường')
                    console.log(response)
                    this.loading.status = false;
                    if (response.data.statusResponse == 0) {
                        this.list_data = response.data.rows;
                        this.paginate.total = response.data.total;
                        if (this.paginate.total == 0) {
                            // this.thongBao('warning', 'Không tìm thấy bản ghi nào.');
                        }
                    } else {
                        this.thongBao('error', response.data.rd)
                    }
                });
            } catch (e) {
            }
        },
        getDataPageOne() {
            console.log('getDataPageOne')
            this.paginate.startPage = !this.paginate.startPage;
        },
        chonCapHoc() {
            console.log('chonCapHoc')
        },
        chonDonVi() {
            console.log('chonDonVi')
        },
        getDonVi() {
            console.log('getDonVi');
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
.mt-15 {
    margin-top: 15px !important;
}
</style>

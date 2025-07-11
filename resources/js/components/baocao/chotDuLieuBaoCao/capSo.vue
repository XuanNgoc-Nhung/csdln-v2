<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <Breadcrumb :menu="'Báo cáo'" :desc="'Chốt dữ liệu báo cáo'" />
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <el-col :span="24">
                    <el-tabs type="border-card2" @tab-click="handleTabClick">
                        <el-tab-pane label="Chốt theo đơn vị">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                    <label class="typo__label">Đơn vị</label>
                                    <eselect collapseTags v-model="dataSearch.maPhong" :placeholder="'Chọn'" filterable
                                        :data="list_don_vi_phong" :fields="['name','value']" />
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-2 col-lg-4">
                                    <label class="typo__label">Năm học</label>
                                    <eselect collapseTags v-model="dataSearch.namHoc" :placeholder="'Chọn'" filterable
                                        :data="list_nam_hoc" :fields="['name','id']" />
                                </div>
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                    <span style="color:transparent;display:block; line-height:1.7">Tìm kiếm</span>
                                    <el-button size="mini" type="success" @click.prevent="layDuLieuTheoDonVi">
                                        Tìm kiếm
                                    </el-button>
                                </div>
                                <div class="col-md-12" style="padding-top: 16px;">
                                    <label for="" class="table-name">Chốt dữ liệu báo cáo theo đơn vị</label>
                                </div>
                                <div class="col-md-12" style="padding-top: 16px;">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr style="background:#e4ebf5">
                                                    <th class="text-center fixed-column fixed-col1">
                                                        <p>STT</p>
                                                    </th>

                                                    <th>
                                                        <p>Đơn vị</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Năm học</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Trạng thái</p>
                                                    </th>
                                                    <th class="text-center fixed-column fixed-col2">
                                                        <p>Thao Tác</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="list_don_vi.length==0">
                                                <tr>
                                                    <td colspan="14">
                                                        <p class="text-center">Không có dữ liệu</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr v-for="(item,i) in list_don_vi" :key="i">
                                                    <td class="text-center fixed-column fixed-col1">
                                                        <p>{{ i + 1 }}</p>
                                                    </td>

                                                    <td class="text-left">
                                                        <p>{{ item.tenPhong }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ item.namHoc }} - {{ item.namHoc + 1 }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p v-bind:class="getClass(item.status)">
                                                            {{ item.status == 1 ? 'Đã chốt' : 'Chưa chốt' }}</p>
                                                        <!-- <el-button v-if="item.status==1" size="mini" class="hoverWarning" type="warning">Đã chốt</el-button>
                                    <el-button v-else size="mini" class="hoverSuccess" type="success">Chưa chốt</el-button> -->
                                                    </td>
                                                    <td class="text-center fixed-column">

                                                        <el-tooltip
                                                            :content="item.status==1?'Mở chốt dữ liệu':'Chốt dữ liệu'"
                                                            placement="top">
                                                            <i v-if="item.status==1" class="el-icon-unlock"
                                                                @click.prevent="confirmUpdateStatus(item,0)"></i>
                                                            <i v-if="item.status!=1" class="el-icon-lock"
                                                                @click.prevent="confirmUpdateStatus(item,1)"></i>
                                                        </el-tooltip>
                                                        <!-- <el-button v-if="item.status==1"  @click.prevent="confirmUpdateStatus(item,0)"  size="mini" type="success">Mở</el-button>
                                    <el-button v-else size="mini" @click.prevent="confirmUpdateStatus(item,1)" type="warning">Chốt</el-button> -->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </div>
                                    <el-col :span="24">
                                        <Pagination :batdau="paginate.startPage"
                                            :total_rows="paginate.total" @pageChange="layLaiDuLieu($event)">
                                        </Pagination>
                                    </el-col>
                                </div>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane label="Chốt theo trường">
                            <div class="row">
                                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                                    <label class="typo__label">Đơn vị</label>
                                    <eselect collapseTags v-model="dataSearch.maPhong2" :placeholder="'Chọn'"
                                        @change="chonDonVi()" filterable :data="list_don_vi_phong"
                                        :fields="['name','value']" />
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label class="typo__label">Cấp học</label>
                                    <eselect collapseTags v-model="dataSearch.capHocs" multiple @change="chonDonVi()"
                                        :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                    <label class="typo__label">Trường học</label>
                                    <eselect collapseTags v-model="dataSearch.maTruongs" multiple :placeholder="'Chọn'"
                                        filterable :data="list_truong_hoc" :fields="['name','value']" />
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" style="padding-top:20px">
                                    <label class="typo__label">Năm học</label>
                                    <eselect collapseTags v-model="dataSearch.namHoc2" :placeholder="'Chọn'" filterable
                                        :data="list_nam_hoc" :fields="['name','id']" />
                                </div>
                                <div class="col-md-12 text-center">
                                    <span style="color:transparent;display:block; line-height:1.7">Tìm kiếm</span>
                                    <el-button size="mini" type="success" @click.prevent="layDuLieuTheoTruong">
                                        Tìm kiếm
                                    </el-button>
                                </div>
                                <div class="col-md-12" style="padding-top: 16px;">
                                    <label for="" class="table-name">Chốt dữ liệu báo cáo theo trường</label>
                                </div>
                                <div class="col-md-12" style="padding-top:16px">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr style="background:#e4ebf5">
                                                    <th class="text-center">
                                                        <p>STT</p>
                                                    </th>

                                                    <th>
                                                        <p>Tên trường</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Mã trường</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Năm học</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Trạng thái</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Thao tác</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="list_truong.length==0">
                                                <tr>
                                                    <td colspan="14">
                                                        <p class="text-center">Không có dữ liệu</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else>
                                                <tr v-for="(item,i) in list_truong" :key="i">
                                                    <td class="text-center">
                                                        <p>{{ (paginate_truong.curentPage - 1) * paginate_truong.limit + i + 1 }}
                                                        </p>
                                                    </td>

                                                    <td class="text-left">
                                                        <p>{{ item.tenTruong }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ item.maTruong }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ dataSearch.namHoc2 }} - {{ dataSearch.namHoc2 + 1 }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p v-bind:class="getClass(item.status)">
                                                            {{ item.status == 1 ? 'Đã chốt' : 'Chưa chốt' }}</p>
                                                        <!-- <el-button v-if="item.status==1" size="mini" class="hoverWarning" type="warning">Đã chốt</el-button>
                                        <el-button v-else size="mini"  class="hoverSuccess"  type="success">Chưa chốt</el-button> -->
                                                    </td>
                                                    <td class="text-center">
                                                        <el-tooltip
                                                            :content="item.status==1?'Mở chốt dữ liệu':'Chốt dữ liệu'"
                                                            placement="top">
                                                            <i v-if="item.status==1" class="el-icon-unlock"
                                                                @click.prevent="confirmUpdateStatusSchool(item,0)"></i>
                                                            <i v-if="item.status!=1" class="el-icon-lock"
                                                                @click.prevent="confirmUpdateStatusSchool(item,1)"></i>
                                                        </el-tooltip>
                                                        <!-- <el-button v-if="item.status==1"  @click.prevent="confirmUpdateStatusSchool(item,0)"  size="mini" type="success">Mở</el-button>
                                        <el-button v-else size="mini" @click.prevent="confirmUpdateStatusSchool(item,1)" type="warning">Chốt</el-button> -->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <el-col :span="24">
                                        <Pagination :batdau="paginate_truong.startPage"
                                            :total_rows="paginate_truong.total" @pageChange="layLaiDuLieuTruong($event)">
                                        </Pagination>
                                    </el-col>
                                </div>
                            </div>
                        </el-tab-pane>
                    </el-tabs>
                </el-col>
            </el-row>
        </div>
    </div>
</template>
<script>
    import ESelectVue from '../../ui/ESelect.vue';
    import rest_api from "../../../utils/rest_api";
    import constant from "../../../utils/constant";
    import Pagination from '../../ui/PagingCustom';
    import Breadcrumb from '../../ui/Breadcrumb.vue';

    export default {
        components: {
            'eselect': ESelectVue,
            Pagination,
            Breadcrumb
        },
        watch: {},
        data() {
            return {
                loading: {
                    status: false,
                    text: 'Loading...'
                },
                thongtin: {},
                dataSearch: {
                    namHoc: '',
                    namHoc2: '',
                    trangThai: '',
                    capHocs: [],
                    maPhong2: '',
                    maTruongs: [],
                },
                paginate: {
                    start: 0,
                    limit: 25,
                    total: 0,
                    curentPage: 1,
                    startPage: true,
                },
                paginate_truong: {
                    start: 0,
                    limit: 25,
                    total: 0,
                    curentPage: 1,
                    startPage: true,
                },
                list_don_vi: [],
                list_don_vi_phong: [],
                list_truong: [],
                list_truong_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_cap_hoc: window.listCapHoc,
            }
        },
        mounted() {
            console.log('Mount dữ liệu giáo viên');
            this.thongtin = JSON.parse(window.userInfo);
            this.dataSearch.namHoc = this.thongtin.namHocHienTai;
            this.dataSearch.namHoc2 = this.thongtin.namHocHienTai;
            this.getDonViPhong();
            this.getTruongHoc()
            // this.layDuLieuTheoDonVi();
            // this.layDuLieuTheoTruong();
        },
        methods: {
          
            chonDonVi() {
                this.dataSearch.maTruongs = [];
                this.getTruongHoc();
            },

            getTruongHoc() {
                console.log('getTruongHoc');
                console.log("Lấy danh sách trường học")
                try {
                    let params = {
                        maDonVi: this.dataSearch.maPhong2 ? [this.dataSearch.maPhong2] : [],
                        capHoc: this.dataSearch.capHocs
                    };
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
            getDonViPhong() {
                console.log('getDonVi');
                this.list_don_vi_phong = [];
                try {
                    console.log("Lấy danh sách đơn vị:")
                    let params = {
                        "start": 0,
                        "limit": 9999,
                        "maTinhThanh": this.thongtin.ma_so,
                        "loaiDonVi": 2
                    };
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
                            this.list_don_vi_phong = ldv;
                        } else {

                        }
                        this.loading.status = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
                }
            },
            getClass(stt) {
                return stt == 0 ? 'banGhiDangHoatDong' : 'banGhiNgungHoatDong'
            },
            layLaiDuLieu(e) {
                console.log('layLaiDuLieu');
                this.paginate.start = e.start;
                this.paginate.limit = e.limit;
                this.paginate.curentPage = e.currentPage;
                this.layDuLieuTheoDonVi()
            },
            layLaiDuLieuTruong(e) {
                console.log('layLaiDuLieuTruong');
                this.paginate_truong.start = e.start;
                this.paginate_truong.limit = e.limit;
                this.paginate_truong.curentPage = e.currentPage;
                this.layDuLieuTheoTruong()
            },
            confirmUpdateStatusSchool(item, status) {
                this.$confirm('Xác nhận thay đổi trạng thái?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        console.error(item)
                        console.error(status)
                        this.loading.text = 'Vui lòng đợi...'
                        this.loading.status = true;
                        let params = {
                            namHoc: this.dataSearch.namHoc2,
                            capHocs: [3],
                            maPhong: this.thongtin.ma_so,
                            maTruongs: [item.maTruong],
                            trangThai: status
                        };
                        rest_api.post("/csdlgd-admin/chotDuLieu/update", params, response => {
                            console.log('Response:')
                            console.log(response)
                            if (response.data.rc == 0) {
                                this.thongBao('success', 'Thay đổi trạng thái thành công.')
                                this.layDuLieuTheoTruong();
                            } else {
                                this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
                            }
                            this.loading.status = false
                        });
                    })
                    .catch(_ => {});
            },
            confirmUpdateStatus(item, status) {
                this.$confirm('Xác nhận thay đổi trạng thái?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        console.error(item)
                        console.error(status)
                        this.loading.text = 'Vui lòng đợi...'
                        this.loading.status = true;
                        let params = {
                            maSo: this.thongtin.ma_so,
                            maDonVi: item.maPhong,
                            roleId: this.thongtin.role,
                            maPhongs: [item.maPhong],
                            namHoc: item.namHoc,
                            capHocs: [],
                            maTruongs: [],
                            trangThai: status
                        }
                        rest_api.post("/csdlgd-admin/chotDuLieu/updateTheoPhong", params, response => {
                            console.log('Response:')
                            console.log(response)
                            if (response.data.rc == 0) {
                                this.thongBao('success', 'Thay đổi trạng thái thành công.')
                                this.layDuLieuTheoDonVi();
                            } else {
                                this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
                            }
                            this.loading.status = false
                        });
                    })
                    .catch(_ => {});
            },
            layDuLieuTheoTruong() {
                try {
                    let params = {
                        namHoc: this.dataSearch.namHoc2,
                        capHocs: this.dataSearch.capHocs,
                        maPhong: this.dataSearch.maPhong2 ? [this.dataSearch.maPhong2] : [],
                        maTruongs: this.dataSearch.maTruongs,
                        trangThai: this.dataSearch.trangThai,
                        start: this.paginate_truong.start,
                        limit: this.paginate_truong.limit
                    };
                    
                    this.loading.text = 'Đang tải dữ liệu...';
                    this.loading.status = true;
                    this.list_truong = [];
                    this.paginate_truong.total = 0;
                    rest_api.post("/csdlgd-admin/chotDuLieu/danhSach", params, response => {
                        console.log('Response:')
                        console.log(response)
                        if (response.data.rc == 0) {
                            this.paginate_truong.total = response.data.total;
                            this.list_truong = response.data.rows;
                        } else {
                            this.thongBao('error', response.data.rd);
                        }
                        this.loading.status = false
                    });
                } catch (e) {
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
                    this.loading.status = false
                }
            },
            layDuLieuTheoDonVi() {
                try {
                    let params = {
                        namHoc: this.dataSearch.namHoc,
                        maSo: this.thongtin.ma_so,
                        maPhongs: this.dataSearch.maPhong ? [this.dataSearch.maPhong] : [],
                        start: 0,
                        limit: 9999
                    };
                    this.paginate.total = 0;
                    this.loading.text = 'Đang tải dữ liệu...';
                    this.loading.status = true;
                    this.list_don_vi = [];
                    rest_api.post("/csdlgd-admin/chotDuLieu/danhSachTheoPhong", params, response => {
                        console.log('Response:')
                        console.log(response)
                        if (response.data.rc == 0) {
                            this.list_don_vi = response.data.rows;
                            this.paginate.total = response?.data?.total ?? 0;
                        } else {
                            this.thongBao('error', response.data.rd);
                        }
                        this.loading.status = false
                    });
                } catch (e) {
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
                    this.loading.status = false
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
            resetPaginate() {
                this.paginate.total = 0;
                this.paginate_truong.total = 0;
            },
        }
    }

</script>
<style scoped="scoped">
    .el-tabs__header {
        margin-bottom: 0 !important;
    }

</style>

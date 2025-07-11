<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :span="24" class="text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Hệ thống <span class="kytu">
                        &raquo;</span> Chốt dữ liệu báo cáo</span>
            </el-col>
        </el-row>
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Đơn vị:</label>
                <eselect :disabled="thongtin.role>2" collapseTags v-model="dataSearch.donVi" @change="chonDonVi"
                    :placeholder="'Chọn'" filterable :data="list_don_vi" :fields="['name','value']" />
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="4">
                <label>Cấp học</label>
                <eselect :disabled="list_cap_hoc.length==1" multiple collapseTags v-model="dataSearch.capHoc"
                    @change="chonCapHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                    :fields="['name','id']" />
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Trường học </label>
                <eselect :disabled="thongtin.role==5" multiple collapseTags v-model="dataSearch.truongHoc"
                    :placeholder="'Chọn'" filterable :data="list_truong_hoc" :fields="['name','value']" />
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="4">
                <label>Năm học </label>
                <eselect collapseTags v-model="dataSearch.namHoc" :placeholder="'Chọn'" filterable :data="list_nam_hoc"
                    :fields="['name','id']" />
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="4">
                <label>Trạng thái</label>
                <eselect collapseTags v-model="dataSearch.trangThai" :placeholder="'Chọn'" filterable
                    :data="list_trang_thai" :fields="['name','id']" />
            </el-col>
            <el-col :span="24" class="text-center">
                <el-button size="mini" type="success" @click.prevent="getData">Tìm kiếm</el-button>
            </el-col>
        </el-row>

        <el-row :span="20" class="card-bieu-do mt-15">
            <!-- <el-col :span="5" class="text-right">
                <eselect :disabled="list_cap_hoc.length==1" ref="hanhDong" collapseTags v-model="hanhDong"
                    :placeholder="'Chọn hành động'" filterable :data="list_action" :fields="['name','value']" />
            </el-col>
            <el-col :span="2" class="text-right">
                <el-button size="mini" style="width:100%" @click.prevent="thucHienHanhDong" type="primary">Thực hiện
                </el-button>
            </el-col> -->
            <el-col :span="24" class="text-right">
                
                <span style="padding-right:20px" v-if="list_data_check.length"><b>Đã chọn
                    {{list_data_check.length}} bản ghi</b></span>
                <el-tooltip v-if="list_data_check.length" content="Khóa các trường đã chọn" placement="top">
                    <el-button size="mini" @click.prevent="thucHienHanhDong(1)" type="primary">Chốt
                    </el-button>
                </el-tooltip>
                <el-tooltip v-if="list_data_check.length" content="Mở khóa các trường đã chọn" placement="top">
                    <el-button size="mini" @click.prevent="thucHienHanhDong(2)" type="primary">Mở chốt
                    </el-button>
                </el-tooltip>
            </el-col>
            <el-col :span="24" class="pd-t-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr style="background:#e4ebf5">
                                <th class="text-center">
                                    <el-checkbox @change="chonTatCa" v-model="checkAll"></el-checkbox>
                                </th>
                                <th class="text-center">
                                    <p>STT</p>
                                </th>
                                <th class="text-center">
                                    <p>Thao tác</p>
                                </th>
                                <th class="text-center">
                                    <p>Tên trường</p>
                                </th>
                                <th class="text-center">
                                    <p>Mã trường</p>
                                </th>
                                <th class="text-center">
                                    <p>Đơn vị</p>
                                </th>
                                <th class="text-center">
                                    <p>Trạng thái</p>
                                </th>
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
                            <tr v-for="(item,i) in list_data" :key="i">
                                <td class="text-center">
                                    <input type="checkbox" @change="chonMoiBanGhi" :disabled="checkDisabled(item)"
                                        v-model="list_data_check" :value="item.maTruong" />
                                    <span style="font-size:12px"></span>
                                </td>
                                <td class="text-center">
                                    <p>{{ (paginate.curentPage - 1) * paginate.limit + i + 1 }}</p>
                                </td>
                                <td class="text-center">

                                    <el-tooltip :content="item.status==1?'Mở chốt dữ liệu':'Chốt dữ liệu'"
                                        placement="top">
                                        <i v-if="item.status==1" class="el-icon-unlock"
                                            @click.prevent="showUpdate(item.maTruong,0)"></i>
                                        <i v-if="item.status!=1" class="el-icon-lock"
                                        @click.prevent="showUpdate(item.maTruong,1)"></i>
                                    </el-tooltip>
                                </td>
                                <td>
                                    <p>{{ item.maTruong }}</p>
                                </td>
                                <td>
                                    <p>{{ item.tenTruong }}</p>
                                </td>
                                <td>
                                    <p>{{getTenDonVi( item)}}</p>
                                </td>
                                <td class="text-left">
                                    <p v-bind:class="getClass(item.status)">{{getNameStatus(item)}}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :batdau="paginate.startPage" :total_rows="paginate.total"
                    @pageChange="layLaiDuLieu($event)"></Pagination>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import rest_api from "../../../utils/rest_api";
    import ESelectVue from '../../ui/ESelect.vue';
    import Pagination from '../../ui/PagingCustom';
    import api from "../../api";
    import constant from "../../../utils/constant";

    Vue.use(ElementUI);
    export default {
        components: {
            'eselect': ESelectVue,
            Pagination,
        },
        watch: {},
        data() {
            return {
                list_data: [],
                list_data_check: [],
                checkAll: false,
                thongtin: {},
                paginate: {
                    start: 0,
                    limit: 25,
                    total: 0,
                    curentPage: 1,
                    startPage: true,
                },
                loading: {
                    text: 'Loading...',
                    status: false,
                },
                dataSearch: {
                    capHoc: [],
                    donVi: '',
                    namHoc: '',
                    hocKy: '',
                    trangThai: '',
                    truongHoc: [],
                },
                list_don_vi: [],
                list_cap_hoc: window.listCapHoc,
                list_truong_hoc: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_hoc_ky: constant.LIST_HOC_KY,
                list_trang_thai: [{
                        name: 'Đã chốt',
                        id: 1
                    },
                    {
                        name: 'Chưa chốt',
                        id: 0
                    },
                ],
                hanhDong: '',
                list_action: [],
                list_action_so: [{
                        name: '1. Chốt các trường đã chọn',
                        value: 1
                    },
                    {
                        name: '2. Mở chốt  các trường đã chọn',
                        value: 2
                    },
                    {
                        name: '3. Chốt dữ liệu các trường tìm thấy',
                        value: 3
                    },
                    {
                        name: '4. Mở chốt dữ liệu các trường tìm thấy',
                        value: 4
                    },
                    {
                        name: '5. Chốt dữ liệu toàn bộ các trường',
                        value: 5
                    },
                    {
                        name: '6. Mở chốt dữ liệu toàn bộ các trường',
                        value: 6
                    },
                ],
                list_action_phong: [{
                        name: '1. Chốt các trường đã chọn',
                        value: 1
                    },
                    {
                        name: '2. Mở chốt  các trường đã chọn',
                        value: 2
                    },
                ]
            }
        },
        mounted() {
            this.thongtin = JSON.parse(window.userInfo);
            console.log('Mount tra cứu trường học');
            console.warn(this.thongtin);
            if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                this.list_action = this.list_action_so;
            }
            if (this.thongtin.role == 4) {
                this.list_action = this.list_action_phong;
            }
            if (this.thongtin.role > 2) {
                this.dataSearch.donVi = this.thongtin.ma_don_vi;
            }
            if (this.thongtin.role && this.thongtin.role == 5) {
                this.dataSearch.truongHoc = this.thongtin.ma_truong_hoc;
                if (this.list_cap_hoc && this.list_cap_hoc.length == 1) {
                    this.dataSearch.capHoc = this.list_cap_hoc[0].id
                }
            }
            this.dataSearch.namHoc = this.thongtin.namHocHienTai;
            this.getDonVi();
            this.getTruongHoc();
            this.getDataPageOne()
        },
        methods: {

            getClass(stt) {
                return stt == 1 ? 'banGhiDangHoatDong' : 'banGhiNgungHoatDong'
            },
            getTenDonVi(item) {
                let maPhong = item.maPhong;
                let maSo = item.maSo;
                let result = '';
                if (maPhong && maPhong != '') {
                    for (let i = 0; i < this.list_don_vi.length; i++) {
                        if (this.list_don_vi[i].value == maPhong) {
                            result = this.list_don_vi[i].name;
                        }
                    }
                }
                return result
            },
            thucHienHanhDong(action) {
                this.hanhDong = action;
                console.log('thucHienHanhDong')
                if (!this.hanhDong || this.hanhDong == '') {
                    this.thongBao('warning', 'Vui lòng chọn hành động.');
                    this.$refs.hanhDong.focus();
                    return;
                } else {
                    console.log('Hành động: ' + this.hanhDong)
                    if (this.hanhDong === 1) { //chốt các trường đã chọn
                        this.chotDaChon(1);
                    }
                    if (this.hanhDong === 2) { //Mở chốt các trường đã chọn
                        this.chotDaChon(0)
                    }
                    if (this.hanhDong === 3) { //Chốt toàn bộ trường tìm thấy
                        this.updateTimThay(1);
                    }
                    if (this.hanhDong === 4) { //Mở chốt toàn bộ trường tìm thấy
                        this.updateTimThay(0)
                    }
                    if (this.hanhDong === 5) { //Chốt cả sở
                        this.updateCaSo(1)
                    }
                    if (this.hanhDong === 6) { //Mở chốt cả sở
                        this.updateCaSo(0)
                    }
                }
            },
            updateCaSo(status) {
                console.log('updateCaSo');
                let params = {
                    namHoc: this.dataSearch.namHoc,
                    capHocs: [],
                    maPhong: "",
                    maTruongs: [],
                    trangThai: status
                };
                let msg = 'Xác nhận chốt dữ liệu của tât cả các trường?'
                if (status === 0) {
                    msg = 'Xác nhận mở chốt dữ liệu của tất cả các trường?'
                }
                this.$confirm(msg, 'Thông báo', {
                        confirmButtonText: status==1?'Chốt':'Mở chốt',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.loading.text = 'Vui lòng đợi...'
                        this.loading.status = true;
                        rest_api.post("/csdlgd-admin/chotDuLieu/update", params, response => {
                            console.log('Response:')
                            console.log(response)
                            if (response.data.rc == 0) {
                                this.list_data = response.data.rows;
                                this.paginate.total = response.data.total;
                                this.thongBao('success', 'Thay đổi trạng thái thành công.')
                                this.getData();
                            } else {
                                this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
                            }
                            this.loading.status = false
                        });
                    })
                    .catch(_ => {});
            },
            updateTimThay(status) {
                console.log('chotDaChon');
                let params = {
                    namHoc: this.dataSearch.namHoc,
                    capHocs: this.dataSearch.capHoc,
                    maPhong: this.dataSearch.donVi,
                    maTruongs: this.dataSearch.truongHoc,
                    trangThai: status
                };
                let msg = 'Xác nhận chốt dữ liệu của ' + this.paginate.total + ' trường học tìm thấy?'
                if (status === 0) {
                    msg = 'Xác nhận mở chốt dữ liệu của ' + this.paginate.total + ' trường học tìm thấy?'
                }
                this.$confirm(msg, 'Thông báo', {
                        confirmButtonText: status==1?'Chốt':'Mở chốt',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.loading.text = 'Vui lòng đợi...'
                        this.loading.status = true;
                        rest_api.post("/csdlgd-admin/chotDuLieu/update", params, response => {
                            console.log('Response:')
                            console.log(response)
                            if (response.data.rc == 0) {
                                this.list_data = response.data.rows;
                                this.paginate.total = response.data.total;
                                this.thongBao('success', 'Thay đổi trạng thái thành công.')
                                this.getData();
                            } else {
                                this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
                            }
                            this.loading.status = false
                        });
                    })
                    .catch(_ => {});
            },
            chotDaChon(status) {
                if (!this.list_data_check || this.list_data_check.length == 0) {
                    this.thongBao('error', 'Vui lòng chọn trường học cần chốt dữ liệu')
                    return;
                }
                console.log('chotDaChon');
                let params = {
                    namHoc: this.dataSearch.namHoc,
                    capHocs: this.dataSearch.capHoc,
                    maPhong: this.dataSearch.donVi,
                    maTruongs: this.list_data_check,
                    trangThai: status
                };
                // let msg = 'Xác nhận chốt dữ liệu của ' + this.list_data_check.length + ' trường học đã chọn?'
                let msg = 'Xác nhận chốt dữ liệu?'
                if (status === 0) {
                    // msg = 'Xác nhận mở chốt dữ liệu của ' + this.list_data_check.length + ' trường học đã chọn?'
                    msg = 'Xác nhận mở chốt dữ liệu?'
                }
                this.$confirm(msg, 'Thông báo', {
                        confirmButtonText: status==1?'Chốt':'Mở chốt',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.loading.text = 'Vui lòng đợi...'
                        this.loading.status = true;
                        rest_api.post("/csdlgd-admin/chotDuLieu/update", params, response => {
                            console.log('Response:')
                            console.log(response)
                            if (response.data.rc == 0) {
                                this.list_data = response.data.rows;
                                this.paginate.total = response.data.total;
                                this.thongBao('success', 'Thay đổi trạng thái thành công.')
                                this.getData();
                            } else {
                                this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
                            }
                            this.loading.status = false
                        });
                    })
                    .catch(_ => {});
            },
            chonTatCa() {
                console.log('ChonTatCa')
                if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                    console.error('sở chọn')
                    if (this.checkAll) {
                        let countSelected = 0;
                        for (let i = 0; i < this.list_data.length; i++) {
                            this.list_data_check.push(this.list_data[i].maTruong);
                            countSelected += 1;
                        }
                        if (countSelected == 0) {
                            // this.thongBao('warning', 'Không chọn được dữ liệu');
                            this.checkAll = false;
                        } else {
                            // this.thongBao('success', 'Đã chọn ' + countSelected + ' bản ghi.')
                        }
                    } else {
                        this.list_data_check = [];
                        if (this.list_data && this.list_data.length > 0) {
                            // this.thongBao('warning', 'Đã bỏ chọn toàn bộ.')
                        }
                    }
                    console.error(this.list_data_check)
                } else {
                    console.error('phòng chọn')
                    if (this.checkAll) {
                        let countSelected = 0;
                        for (let i = 0; i < this.list_data.length; i++) {
                            if (this.list_data[i].roleId == 4 || this.list_data[i].status === 0) {
                                this.list_data_check.push(this.list_data[i].maTruong);
                                countSelected += 1;
                            }
                        }
                        if (countSelected == 0) {
                            // this.thongBao('warning', 'Không chọn được dữ liệu');
                            this.checkAll = false;
                        } else {
                            // this.thongBao('success', 'Đã chọn ' + countSelected + ' bản ghi.')
                        }
                    } else {
                        this.list_data_check = [];
                        if (this.list_data && this.list_data.length > 0) {
                            // this.thongBao('warning', 'Đã bỏ chọn toàn bộ.')
                        }
                    }
                }
            },
            getTrangThai(e) {

                if (e === 0) {
                    return "success"
                }
                if (e === 1) {
                    return "warning"
                }
            },
            getNameStatus(item) {
                if (item.status === 1) {
                    if (item.roleId == 2) {
                        return 'Sở đã chốt'
                    } else {
                        return 'Đã chốt'
                    }
                } else {
                    return 'Chưa chốt'
                }
            },
            checkDisabled(item) {
                if (this.thongtin.role == 2 || this.thongtin.role == 3) {
                    return false
                } else {
                    if (item.status == 0) {
                        return false;
                    } else {
                        if (item.roleId == 2 || item.roleId == 3) {
                            return true
                        } else {
                            return false
                        }
                    }
                }
            },
            showUpdate(maTruong, status) {
                this.checkAll = false;
                console.log('showUpdate')
                this.list_data_check = [maTruong];
                this.chotDaChon(status)
            },
            chonMoiBanGhi() {},
            getDataPageOne() {
                this.paginate.startPage = !this.paginate.startPage;
            },

            layLaiDuLieu(e) {
                console.log('layLaiDuLieu');
                this.paginate.start = e.start;
                this.paginate.limit = e.limit;
                this.paginate.curentPage = e.currentPage;
                this.getData()
            },
            getData() {
                // if(!this.dataSearch.truongHoc||this.dataSearch.truongHoc==''){
                //     this.thongBao('warning','Vui lòng chọn trường học');
                //     return;
                // }
                // if(!this.dataSearch.namHoc||this.dataSearch.namHoc==''){
                //     this.thongBao('warning','Vui lòng chọn năm học');
                //     return;
                // }
                // if(!this.dataSearch.hocKy||this.dataSearch.hocKy==''){
                //     this.thongBao('warning','Vui lòng chọn học kỳ');
                //     return;
                // }
                console.log('getData');
                this.list_data = [];
                this.paginate.total = 0;
                let params = {
                    namHoc: this.dataSearch.namHoc,
                    capHocs: this.dataSearch.capHoc,
                    maPhong: this.dataSearch.donVi,
                    maTruongs: this.dataSearch.truongHoc,
                    trangThai: this.dataSearch.trangThai,
                    start: this.paginate.start,
                    limit: this.paginate.limit
                };
                this.loading.text = 'Đang tải dữ liệu...';
                this.loading.status = true;
                this.checkAll = false;
                this.list_data_check = [];
                rest_api.post("/csdlgd-admin/chotDuLieu/danhSach", params, response => {
                    console.log('Response:')
                    console.log(response)
                    if (response.data.rc == 0) {
                        this.list_data = response.data.rows;
                        this.paginate.total = response.data.total;
                        // this.thongBao('success','Lấy dữ liệu thành công');
                    } else {

                        // this.thongBao('warning','Không tìm thấy dữ liệu tương ứng');
                    }
                    this.loading.status = false
                });
            },
            chonCapHoc() {
                console.log('chonCapHoc')
                if (this.thongtin.role != 5) {
                    this.dataSearch.truongHoc = [];
                    this.list_truong_hoc = [];
                    this.getTruongHoc();
                }
            },
            chonDonVi() {
                console.log('chonDonVi')
                this.chonCapHoc();
            },
            getTruongHoc() {
                console.log("Lấy danh sách trường học")
                try {
                    let params = {
                        maDonVi: [],
                        capHoc: []
                    };
                    if (this.dataSearch.capHoc && this.dataSearch.capHoc.length) {
                        params.capHoc = this.dataSearch.capHoc
                    }
                    if (this.dataSearch.donVi) {
                        params.maDonVi = [this.dataSearch.donVi]
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
                        } else {}
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

    .pd-t-0 {
        padding-top: 0;
    }

</style>

<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :span="24" class="text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> hệ thống <span class="kytu">
                        &raquo;</span> Quản lý hệ thống đối tác trường</span>
            </el-col>
        </el-row>
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Đơn vị quản lý:</label>
                <eselect multiple collapseTags v-model="dataSearch.donVis"
                         @change="chonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Cấp học</label>
                <eselect collapseTags v-model="dataSearch.capHocs"
                         multiple
                         @change="chonCapHoc" :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                         :fields="['name','id']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Trường học:</label>
                <eselect multiple collapseTags v-model="dataSearch.truongHocs" :placeholder="'Chọn'" filterable
                         :data="list_truong_hoc"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :xs="24" :sm="12" :md="8" :lg="6">
                <label>Đối tác:</label>
                <eselect collapseTags v-model="dataSearch.doiTac" :placeholder="'Chọn'" filterable :data="list_doi_tac"
                         :fields="['name','value']"/>
            </el-col>
            <el-col :span="24" class="text-center">
                <el-button size="mini" type="success" @click.prevent="getDataPageOne" >Tìm kiếm</el-button>
            </el-col>
        </el-row>
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :span="24" class="text-right">
                <el-tooltip v-if="false" effect="dark" content="Xoá dữ liệu đã chọn" placement="top">
                    <el-button @click.prevent="xoaDuLieu" size="mini" type="danger">Xoá</el-button>
                </el-tooltip>
                <el-tooltip effect="dark" content="Thêm mới" placement="top">
                    <el-button @click.prevent="showAdd" size="mini" type="primary">Thêm mới</el-button>
                </el-tooltip>
            </el-col>
            <el-col :span="24">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                        <tr style="background:#e4ebf5">
                            <th class="text-center"><p>STT</p></th>
                            <th class="text-center"><p>Mã trường</p></th>
                            <th class="text-center"><p>Trường học</p></th>
                            <th class="text-center"><p>Đơn vị quản lý</p></th>
                            <th class="text-center"><p>Đối tác</p></th>
                            <th class="text-center"><p>Thao tác</p></th>
                            <th class="text-center">
                                <el-checkbox @change="chonTatCa" v-model="checkAll">Tất cả</el-checkbox>
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
                        <tr v-for="(item,i) in list_data"
                            :key="i">
                            <td class="text-center"><p>{{ (paginate.curentPage - 1) * paginate.limit + i + 1 }}</p>
                            </td>
                            <td class="text-center"><p>{{ item.maTruongHoc }}</p></td>
                            <td><p>{{ item.tenTruongHoc }}</p></td>
                            <td><p>{{ item.tenDonVi }} - [{{parseInt(item.maDonVi)}}]</p></td>
                            <td><p>{{ item.tenDoiTac }} - [{{item.maDoiTac}}]</p></td>
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
                                       v-model="list_data_check" :value="item.id"/>
                                <span style="font-size:12px"></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <Pagination :batdau="paginate.startPage" :total_rows="paginate.total" @pageChange="layLaiDuLieu($event)"></Pagination>
            </el-col>
        </el-row>
        <el-row :gutter="24">
            <el-col :span="24">
                <chinhSua v-if="show_update" :list_doi_tac="list_doi_tac" @close="show_update = false" @updateSuccess="updateSuccess" :item="dataEdit"></chinhSua>
                <themMoi v-if="show_add" :list_doi_tac="list_doi_tac" @close="show_add = false" @addSuccess="addSuccess" ></themMoi>
            </el-col>
        </el-row>
    </div>
</template>
<script>
import ElementUI from 'element-ui';
// import 'element-ui/lib/theme-chalk/index.css';
import rest_api from "../../../utils/rest_api";
import ESelectVue from '../../ui/ESelect.vue';
import Pagination from '../../ui/PagingCustom';
import chinhSua from './update';
import themMoi from './add';

Vue.use(ElementUI);
export default {
    components: {
        'eselect': ESelectVue,
        Pagination,
        themMoi,
        chinhSua
    },
    watch: {
        activeName: function (newVal) {
            if (newVal) {
                this.loading.status = true;
                this.loading.text = 'Vui lòng đợi...';
                setTimeout(() => {
                    this.loading.status = false;
                }, 500)
            }
        }
    },
    data() {
        return {
            thongtin: {},
            activeName: 'duLieuGiaoVien',
            loading: {
                text: 'Loading...',
                status: false,
            },
            paginate:{
                start: 0,
                limit: 25,
                total: 0,
                curentPage: 1,
                startPage:true,
            },
            dataSearch: {
                donVis: [],
                capHocs: [],
                truongHocs: [],
                doiTac: ''
            },
            list_don_vi: [],
            list_cap_hoc: window.listCapHoc,
            list_truong_hoc: [],
            list_doi_tac: [],
            list_data: [],
            list_data_check: [],
            checkAll:false,
            dataEdit:{},
            show_update:false,
            show_add:false,
        }
    },
    mounted() {
        this.thongtin = JSON.parse(window.userInfo);
        console.log('Mount nộp dữ liệu sso');
        console.warn(this.thongtin)
        this.getDonVi();
        this.getTruongHoc();
        this.getDoiTac();
    },
    methods: {
        getDataPageOne(){
            this.paginate.startPage = !this.paginate.startPage;
        },
        xoaDuLieu(){
            console.log('xoaDuLieu')
            console.log(this.list_data_check)
        },
        showAdd(){
            console.log('showAdd')
            this.show_add = true;
        },
        updateSuccess(){
            console.log('updateSuccess');
            this.show_update = false;
            this.getData();
        },
        addSuccess(){
            console.log('updateSuccess');
            this.show_add = false;
            this.getData();
        },
        showUpdate(e){
            console.log('ShowUpdate')
            if(e){

                this.dataEdit = e;
                this.show_update = true;
            }
            else{
                this.thongBao('error','Có lỗi trong quá trình thao tác. Vui lòng thử lại')
            }

        },
        chonTatCa(){
            console.log('chonTatCa');
            if(this.checkAll){
                let countSelected = 0;
                for (let i = 0; i < this.list_data.length; i++) {
                    this.list_data_check.push(this.list_data[i].id);
                    countSelected += 1;

                }
                if(countSelected==0){
                    this.thongBao('warning','Không chọn được dữ liệu');
                    this.checkAll = false;
                }else {
                    this.thongBao('success','Đã chọn ' + countSelected + ' bản ghi.')
                }
            }else {
                this.list_data_check = [];
                if(this.list_data&&this.list_data.length>0){
                    this.thongBao('warning','Đã bỏ chọn toàn bộ.')
                }
            }
        },
        layLaiDuLieu(e){
            console.log('layLaiDuLieu');
            this.paginate.start = e.start;
            this.paginate.limit = e.limit;
            this.paginate.curentPage = e.currentPage;
            this.getData()
        },
        chonMoiBanGhi(){
            console.log('chonMoiBanGhi')
        },
        getData(){
            console.log('getData');
            this.list_data = [];
            this.checkAll = false;
            this.list_data_check = [];
            this.paginate.total = 0;
            try{
                let params = {
                    "start": this.paginate.start,
                    "limit": this.paginate.limit,
                    "maDoiTac": this.dataSearch.doiTac,
                    "capHocs": this.dataSearch.capHocs,
                    "maDonVis": this.dataSearch.donVis,
                    "maTruongs": this.dataSearch.truongHocs,
                };
                this.loading.text = 'Đang lấy dữ liệu...';
                this.loading.status = true;
                rest_api.post("/csdlgd-admin/heThongDoiTacTruong/danhSach", params, (response) => {
                    console.log('res danh sách cấu hình đối tác trường')
                    console.log(response)
                    this.loading.status = false;
                    if(response.data.rc==0){
                        if(response.data.rows&&response.data.rows.length>0){
                            this.list_data = response.data.rows;
                            this.paginate.total = response.data.total;
                            // this.thongBao('success','Lấy dữ liệu thành công')
                        }else{
                            // this.thongBao('warning','Không tìm thấy dữ liệu');
                            this.list_data = [];
                        }
                    }else{
                        this.thongBao('error',response.data.rd)
                    }
                });
            }catch (e) {

            }
        },
        getDoiTac() {
            console.log('getDonVi');

            try {
                console.log("Lấy danh sách đơn vị:")
                this.loading.status = true;
                this.loading.text = 'Lấy danh sách đối tác';
                let params = {
                    "start": 0,
                    "limit": 9999,
                };
                rest_api.get("/internal-api/heThongDoiTac/filter", params, (response) => {
                    console.log('res đối tác');
                    console.log(response)
                    let data_demo = [];
                    if (response.data.statusResponse == 0) {
                        for (let i = 0; i < response.data.rows.length; i++) {
                            let obj = {
                                name: response.data.rows[i].tenDoiTac + " - [" + response.data.rows[i].maDoiTac +
                                    "]",
                                value: response.data.rows[i].maDoiTac,
                            }
                            data_demo.push(obj);
                        }
                        this.list_doi_tac = data_demo;
                    }
                    else{
                        this.list_doi_tac = [];
                        this.thongBao('error','Không lấy được danh sách đối tác')
                    }
                    this.loading.status = false;

                });
            } catch (e) {
                this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
            }
        },
        chonDonVi() {
            this.dataSearch.truongHocs = [];
            this.getTruongHoc();
        },
        chonCapHoc() {
            this.chonDonVi();
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
        getTruongHoc() {
            console.log('getTruongHoc');
            console.log("Lấy danh sách trường học")
            try {
                let params = {
                    maDonVi: this.dataSearch.donVis,
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

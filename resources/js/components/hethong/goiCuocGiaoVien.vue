<template>
    <div v-loading.fullscreen.lock="loading.status">
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo; </span>HỆ THỐNG<span class="kytu">
                        &raquo;</span> GÓI CƯỚC GIÁO VIÊN</span>
            </div>
        </div>
        <!-- tìm kiếm -->
        <el-row :gutter="24">
            <el-col :span="9">
                <label>Mã giáo viên</label>
                <el-input clearable  v-on:keyup.enter="getData" v-model="maGiaoVien"
                       placeholder="Nhập..."/></el-col>
            <el-col :span="4">
                <label style="color:transparent;display:block">Tìm kiếm</label>
                <el-button type="primary" size="mini" v-on:click.prevent="getData()">Tìm kiếm</el-button></el-col>
        </el-row>
        <div class="row mt-3 " style="margin-top: 20px">
            <div class="col-sm-12 mb-10 text-right">
                <el-button size="mini" @click.prevent="showImport()" type="success">Import theo biểu mẫu</el-button>
                <el-button size="mini" type="primary" @click.prevent="showCreate">Thêm mới</el-button>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr style="background:rgb(228, 235, 245)">
                                            <th>
                                                <p>STT</p>
                                            </th>
                                            <th>
                                                <p>Tên gói cước</p>
                                            </th>
                                            <th>
                                                <p>Mã gói cước</p>
                                            </th>
                                            <th>
                                                <p>Hành động</p>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="list_data.length===0">
                                        <tr>
                                            <td class="text-center" colspan="4">
                                                <p>Không có bản ghi nào</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(tg,index) in list_data">
                                            <td class="text-center">
                                                <p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tg.maGiaoVien }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tg.goiCuoc }}</p>
                                            </td>
                                            <td class="text-center">
                                                <el-button size="mini" @click.prevent="showUpate(tg)" type="warning">Chỉnh sửa</el-button>
                                                <el-button size="mini" @click.prevent="showDelete(tg)" type="danger">Xoá</el-button>
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
            <div class="col-12">
                <el-dialog align="center" title="Thêm mới gói cước"  width="50%"
                           :close-on-press-escape="false" :close-on-click-modal="false"
                           :visible.sync="show_create">
                    <div>
                        <div class="text-left">
                            <el-row :gutter="24">
                                <el-col :span="12">
                                    <label>Giáo viên</label>
                                    <input v-model="dataAdd.maGiaoVien" type="text"
                                           placeholder="Nhập..." class="form-control" />
                                </el-col>
                                <el-col :span="12">
                                    <label>Gói cước</label>
                                    <input v-model="dataAdd.goiCuoc" type="text"
                                           placeholder="Nhập..." class="form-control" />
                                </el-col>
                                <el-col :span="24" class="text-center">
                                    <el-button size="mini" @click.prevent="show_create=false" type="danger">Huỷ</el-button>
                                    <el-button size="mini" @click.prevent="themGoiCuoc" type="primary">Thêm mới</el-button>
                                </el-col>
                            </el-row>

                        </div>
                    </div>
                </el-dialog>
                <el-dialog align="center" title="Chỉnh sửa gói cước"  width="50%"
                           :close-on-press-escape="false" :close-on-click-modal="false"
                           :visible.sync="show_update">
                    <div>
                        <div class="text-left">
                            <el-row :gutter="24">
                                <el-col :span="12">
                                    <label>Giáo viên</label>
                                    <input v-model="dataUpdate.maGiaoVien" type="text"
                                           placeholder="Nhập..." class="form-control" />
                                </el-col>
                                <el-col :span="12">
                                    <label>Gói cước</label>
                                    <input v-model="dataUpdate.goiCuoc" type="text"
                                           placeholder="Nhập..." class="form-control" />
                                </el-col>
                                <el-col :span="24" class="text-center">
                                    <el-button size="mini" @click.prevent="show_update=false" type="danger">Huỷ</el-button>
                                    <el-button size="mini" @click.prevent="chinhSuaGoiCuoc" type="warning">Chỉnh sửa</el-button>
                                </el-col>
                            </el-row>

                        </div>
                    </div>
                </el-dialog>
                <ImportData
                    :show="show_import"
                    @close="show_import=false"
                    @success="onCreatedData($event)"
                ></ImportData>
            </div>
        </div>
    </div>
</template>
<script>
import rest_api from '../../utils/rest_api';
import Page from '../ui/PagingCustom';
import ESelectVue from '../ui/ESelect.vue';
import ImportData from './importCA'
import constant from '../../utils/constant';
import api from './../api';

export default {
    components: {
        "Page": Page,
        'eselect': ESelectVue,
        ImportData
    },
    computed: {},
    data() {
        return {
            loading: {
                status: false
            },
            list_data: [],
            trangbatdau: false,
            start: 0,
            currentPage: 1,
            limit: 25,
            total_rows: 0,
            maGiaoVien: '',
            thongtin: JSON.parse(window.userInfo),
            show_create: false,
            show_update: false,
            dataAdd:{
                maGiaoVien:'',
                goiCuoc:''
            },
            dataUpdate:{},
            show_import:false
        }
    },
    mounted() {
    },
    watch: {},
    methods: {
        onCreatedData(){},
        showImport(){
            this.show_import=true;
        },
        layLai(e){
            console.log("lấy lại danh sách:" + JSON.stringify(e));
            this.start = e.start;
            this.limit = e.limit;
            this.currentPage = e.currentPage;
            this.getData();
        },
        chinhSuaGoiCuoc(){
            console.log('chinhSuaGoiCuoc')
            console.log(this.dataUpdate)

            let params = {
                maGiaoVien: this.dataUpdate.maGiaoVien,
                goiCuoc:this.dataUpdate.goiCuoc,
                id:this.dataUpdate.id
            };
            console.log("lấy dữ liệu:");
            console.log(JSON.stringify(params));
            this.loading.status = true;
            rest_api.post("/csdlgd-admin/chung-thu-so/update-by-id", params, (response) => {
                console.log('Response:')
                console.error(response)
                if(response.data.rc==0){
                    this.show_update = false;
                    this.thongBao('success','Chỉnh sửa dữ liệu thành công')
                    this.getData();
                }else {
                    this.thongBao('error',response.data.rd)
                }
                this.loading.status = false;
            });
        },
        showDelete(item){
            this.$confirm('Xác nhận xoá gói cước?', 'Thông báo', {
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy',
                closeOnClickModal: false,
            })
                .then(_ => {

                    let params = {
                        maGVList: [item.maGiaoVien],
                    };
                    console.log("lấy dữ liệu:");
                    console.log(JSON.stringify(params));
                    this.loading.status = true;
                    rest_api.post("/csdlgd-admin/chung-thu-so/delete-by-magv", params, (response) => {
                        console.log('Response:')
                        console.error(response)
                        if(response.data.rc==0){
                            this.show_create = false;
                            this.thongBao('success','Xoá dữ liệu thành công')
                            this.getData();
                        }else {
                            this.thongBao('error',response.data.rd)
                        }
                        this.loading.status = false;
                    });
                })
                .catch(_ => {});
        },
        showUpate(item){
            this.dataUpdate = item;
            this.show_update = true;
        },
        showCreate() {
            console.log('show thêm mới:')
            this.show_create = true;
        },
        themGoiCuoc(){
            let params = {
                maGiaoVien: this.dataAdd.maGiaoVien,
                goiCuoc:this.dataAdd.goiCuoc
            };
            console.log("lấy dữ liệu:");
            console.log(JSON.stringify(params));
            this.loading.status = true;
            rest_api.post("/csdlgd-admin/chung-thu-so/insert-cts", params, (response) => {
                console.log('Response:')
                console.error(response)
                if(response.data.rc==0){
                    this.show_create = false;
                    this.thongBao('success','Thêm dữ liệu thành công')
                    this.getData();
                }else {
                    this.thongBao('error',response.data.rd)
                }
                this.loading.status = false;
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

        getData() {
            if(!this.maGiaoVien||this.maGiaoVien==''){
                this.thongBao('error','Vui lòng bổ sung mã giáo viên.')
                return;
            }
            let params = {
                maGiaoVien: this.maGiaoVien
            };
            this.loading.status = true;
            rest_api.get("/csdlgd-admin/chung-thu-so/get-by-magv", params, (response) => {
                console.log('Response:')
                console.error(response)
                if(response.data.rc==0){
                    this.list_data = response.data.listCts;
                    this.total_rows = this.list_data.length;
                }
                else{
                    this.thongBao('error',response.data.rd)
                }
                this.loading.status = false;
            });
        },
    }
}
</script>
<style scoped="scoped">
th{
    text-align: center;
}
.mb-10{
    margin-bottom:10px
}
</style>


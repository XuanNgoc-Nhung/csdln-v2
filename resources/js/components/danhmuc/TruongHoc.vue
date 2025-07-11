<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TR333ANG CHsỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span class="kytu"> &raquo;</span> trường học</span>
            </div>
        </div>
        <form role="form">
            <div class="row">
                <div class="col-md-3">
                    <label>Mã trường học</label>
                    <input v-model="ma_truong_hoc" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-md-3">
                    <label>Tên trường học:</label>
                    <input v-model="ten_truong_hoc" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-md-3">
                    <label>Loại hình đào tạo:</label>
                    <select class="form-control" v-model="loai_hinh_dao_tao">
                        <option value=''>Tất cả</option>
                        <option value='1'>Công lập</option>
                        <option value='2'>Tư thục</option>
                        <option value='3'>GDTX</option>
                        <option value='4'>Bán công</option>
                        <option value='5'>Dân lập</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Trạng thái:</label>
                    <select class="form-control" v-model="trang_thai">
                        <option value=''>Tất cả</option>
                        <option value='1'>Đang hoạt động</option>
                        <option value='0'>Ngưng hoạt động</option>
                        <option value='-1'>Đã xóa</option>
                    </select>

                </div>
            </div>
            <div class="row" style="padding-top:15px;">
                <div class="col-md-3">
                    <label>Chọn sở:</label>
                    <select v-bind:disabled="thongtin.role2==2" @change="soChange()" class="form-control" v-model="so">
                        <option value=''>Tất cả</option>
                        <option v-for="dv in danh_sach_so" :key="dv.maDonVi" :value="dv.maDonVi">
                            {{dv.tenDonVi}}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Đơn vị:</label>
                    <select class="form-control" v-model="don_vi">
                        <option value=''>Tất cả</option>
                        <option v-for="dv in danh_sach_don_vi" :key="dv.maDonVi" :value="dv.maDonVi">
                            {{dv.tenDonVi}}
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Cấp học:</label>
                    <select class="form-control" v-model="cap_hoc">
                        <option value=''>Tất cả</option>
                            <option v-for="ch in ds_cap_hoc" :key="ch.id" :value="ch.id">{{ch.name}}</option>
                    </select>
                </div>
            </div>
            <div class="text-center" style="padding-top:15px">
                <button class="btn btn-success" v-on:click.prevent="getData()"><i class="fa fa-search"></i>Tìm kiếm</button>
            </div>
        </form>
        <div class="row" style="margin-top: 20px">

            <div class="col-lg-12">

                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <label>Danh sách trường học</label>
                                <button class="btn btn-success pull-right"
                                        v-on:click.prevent="showCreat()">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </button>
                                <button style="margin:0 5px;" class="btn btn-primary pull-right" v-on:click.prevent="showImport()">
                                    <i class="fas fa-upload"></i> Import
                                </button>
                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th><p>STT</p></th>
                                            <th><p>Mã Trường</p></th>
                                            <th><p>Tên Trường</p></th>
                                            <th><p>Cấp học</p></th>
                                            <th><p>Đơn vị</p></th>
                                            <th><p>Quận huyện</p></th>
                                            <th><p>Tỉnh thành</p></th>
                                            <th><p>Loại hình đào tạo</p></th>
                                            <th><p>Ngày cập nhật</p></th>
                                            <th><p>Trạng thái</p></th>
                                            <th><p>Thao tác</p></th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_truong_hoc.length===0">
                                        <tr>
                                            <td class="text-center" colspan="22"><p>Không có bản ghi nào</p></td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(tg,index) in ds_truong_hoc" :key="tg.maTruongHoc" v-bind:class="{ hoatDong: tg.trangThai==1, ngungHoatDong: tg.trangThai==0 }">
                                            <td class="text-center"><p>{{(currentPage-1)*limit + index+1}}</p></td>
                                            <td><p>{{tg.maTruongHoc}}</p></td>
                                            <td><p>{{tg.tenTruongHoc}}</p></td>
                                            <td><p>{{getCapHoc(tg.capHoc)}}</p></td>
                                            <td><p>{{tg.tenDonVi}}</p></td>
                                            <td><p>{{tg.tenQuanHuyen}}</p></td>
                                            <td><p>{{tg.tenTinhThanh}}</p></td>
                                            <td><p>{{getLoaiHinhDaoTao(tg.loaiHinhDaoTao)}}</p></td>
                                            <td class="text-center"><p>{{getTime(tg.ngayCapNhat)}}</p></td>
                                            <td class="text-center"><p>{{getTrangThai(tg.trangThai)}}</p></td>
                                            <td class="text-center">
                                                <a title="Chỉnh sửa" v-on:click="showUpdate(tg)"><i
                                                    class="far fa-edit"></i></a>
                                                <a title="Xóa" v-on:click.prevent="deleteUnit(tg)"><i
                                                    class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                    <ThemMoiTruongHoc :show="show_create" @close="show_create=false"
                                                      @success="onCreatedData($event)"></ThemMoiTruongHoc>
                                    <ChinhSuaTruongHoc :show="show_update" :item="dataEditTruongHoc"
                                                       @close="show_update=false"
                                                       @success="onCreatedData($event)"></ChinhSuaTruongHoc>
                                    <ImportTruongHoc :show="show_import"
                                                     @close="show_import=false"
                                                     @success="onCreatedData($event)"></ImportTruongHoc>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import timeutils from '../../utils/time_utils';
    import Page from '../ui/PagingCustom';
    import ThemMoi from './ThemTruonghoc';
    import ChinhSua from './ChinhSuaTruongHoc';
    import Import from './pupupImportExcel/importTruongHoc';
    import dialog from '../../utils/dialog';
    import constant from '../../utils/constant';
    import api from './../api';
    import VueAlertify from "vue-alertify";
    Vue.use(VueAlertify, {

        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            // dialogs default title
            title: 'Thông báo',
            // ok button text
            ok: 'Đồng ý',
            // cancel button text
            cancel: 'Hủy'
        }
    });
    export default {

        components: {
            "Page": Page,
            "ThemMoiTruongHoc": ThemMoi,
            "ChinhSuaTruongHoc": ChinhSua,
            "ImportTruongHoc": Import,
        },

        computed: {},

        data() {

            return {
                // ds_cap_hoc:constant.LIST_CAP_HOC,
                ds_cap_hoc: window.listCapHoc,
                ten_truong_hoc: '',
                show_create: false,
                show_update: false,
                show_import: false,
                trang_thai: '',
                total_rows: 0,
                ma_truong_hoc: '',
                ds_truong_hoc: [],
                start: 0,
                currentPage: 1,
                limit: 25,
                dataEditTruongHoc: {},
                loai_hinh_dao_tao:'',
                danh_sach_so: [],
                so: '',
                danh_sach_don_vi: [],
                don_vi: '',
                cap_hoc:'',
                thongtin:{}
            }
        },

        mounted() {
            this.thongtin = JSON.parse(window.userInfo);
            if(this.thongtin.role2==2){
                this.so = this.thongtin.ma_don_vi;
                this.getDanhSachDonVi();
            }
            console.log("thông tin đăng nhập:" + JSON.stringify(this.thongtin))
            this.getDanhSachSo();
            this.getData();
            this.getLoaiHinhDaoTao();
        },

        watch: {},

        methods: {
            getLoaiHinhDaoTao(){

                let params = {
                    "constantType": "DM_LOAI_HINH_DAO_TAO"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].mappingCode,
                            }
                            this.list_loai_hinh_dao_tao.push(obj);
                        }
                        console.log("sme trả về dân tộc:" + this.list_loai_hinh_dao_tao)
                    }
                });
            },
            getTrangThai(loai){

                var res = parseInt(loai);
                switch(loai) {
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
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },

            getTime(date) {

                return timeutils.convertTime(new Date(date));
            },
            getDanhSachSo() {
                let params = {
                    "start": 0,
                    "limit": 1000,
                    "loaiDonVi": 1
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.danh_sach_so);
                        this.danh_sach_so = data.data.rows;

                    }
                });
            },
            soChange(){
                if(this.so == ''){
                    this.danh_sach_don_vi = [];
                    this.don_vi = '';
                    return;
                }
                this.getDanhSachDonVi();
            },
            getDanhSachDonVi() {
                let params = {
                    "start": 0,
                    "limit": 1000,
                    "maTinhThanh":this.so,
                    "loaiDonVi":2
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.danh_sach_don_vi);
                        this.danh_sach_don_vi = data.data.rows;
                    }
                });
            },
            getCapHoc(loai){
                var res = '';
                if(loai.indexOf('4') != -1){
                    res  += 'Nhà trẻ ';
                }
                if(loai.indexOf('5') != -1){
                    res  += 'Mẫu giáo ';
                }
                if(loai.indexOf('1') != -1){
                    res  += 'Cấp một ';
                }
                if(loai.indexOf('2') != -1){
                    res  += 'Cấp hai ';
                }
                if(loai.indexOf('3') != -1){
                    res  += 'Cấp ba ';
                }
                return res;
            },
            getLoaiHinhDaoTao(loai){
                var res = loai;
                switch(loai) {
                    case 1:
                        res = 'Công lập';
                        break;
                    case 2:
                        res = 'Tư thục';
                        break;
                    case 3:
                        res = 'GDTX';
                        break;
                    case 4:
                        res = 'Bán công';
                        break;
                    case 5:
                        res = 'Dân lập';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getData() {
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "ma": this.ma_truong_hoc,
                    "ten": this.ten_truong_hoc,
                    "trangthai": this.trang_thai,
                    "caphoc":this.cap_hoc,
                    "matinhthanh":this.so,
                    "madonvi":this.don_vi,
                    "loaihinhdaotao":this.loai_hinh_dao_tao
                };
                rest_api.get("/internal-api/dmTruongHoc/filter", params, (data) => {
                    if (array_util.isArray(data.data.rows)) {
                        this.total_rows = data.data.total;
                        array_util.clearArrays(this.ds_truong_hoc);
                        this.ds_truong_hoc = data.data.rows;
                        if (this.total_rows>0){
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công");
                        }
                        else {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy");
                        }
                }
                },6000,true);
            },
            showCreat() {
                console.log("thêm mới tỉnh thành");
                this.show_create = true;
            },
            showUpdate(tg) {
                console.log(tg);
                this.dataEditTruongHoc = tg;
                this.show_update = true;

            },
            onCreatedData(e) {
                this.getData();
            },
            deleteUnit(e) {
                dialog.confirmDialog("Bạn có muốn xóa trường học này?", "Đồng ý", () => {
                    console.log("đồng ý xóa");
                    const uri = "/api_xoa_truong_hoc";
                    let params = {
                        id: e.maTruongHoc,
                    };
                    api.post(uri, params, (response) => {
                        console.log("xóa:" + JSON.stringify(response));
                        if (response.data.code === 200) {
                            showDialog("Thông báo", "Xóa  thành công", null, () => {
                                this.getData();
                            });
                        } else {
                            showDialog("Thất bại", response.data.message, null, () => {
                                return;
                            });
                        }
                    });
                });

            },
            showImport() {
                console.log("Import file từ excel");
                this.show_import = true;
            }
        }

    }

</script>
<style scoped>
    p,a{
        font-size: 14px;;
    }
    th{
        text-align: center;
    }
    /*.hoatDong{*/
    /*    background: #00FF00 !important;*/
    /*}*/
    /*.hoatDong:hover{*/
    /*    background: yellow !important;*/
    /*}*/
    /*.ngungHoatDong{*/
    /*    background: red !important;*/
    /*}*/
</style>

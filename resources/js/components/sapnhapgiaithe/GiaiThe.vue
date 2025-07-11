<template>
    <div>
        <Breadcrumb :menu="'Hệ thống'" :desc="'Giải thể trường học'"/>
        <div class="card-bieu-do">
            <div class="row">
                <div class="col-sm-3" v-if="thongtin.role==1">
                    <label>Sở Giáo dục</label>
                    <eselect style="width:100%" :disabled="thongtin.role>1" @change="ChonDonViSo" collapseTags
                             v-model="maSo" :placeholder="'Chọn'" filterable :data="list_don_vi_so"
                             :fields="['name','value']"/>
                </div>
                <div class="col-sm-3">
                    <label>Đơn vị quản lý</label>
                    <div>
                        <eselect style="width:100%" :disabled="thongtin.role>3" collapseTags v-model="maPhong"
                                 :placeholder="'Chọn'" filterable :data="list_don_vi_phong" :fields="['name','value']"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label>Cấp học</label>
                    <div>
                        <eselect style="width:100%" collapseTags v-model="capHoc" :placeholder="'Chọn'" filterable
                                 :data="list_cap_hoc" :fields="['name','id']"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label>Nhóm cấp học</label>
                    <div>
                        <eselect style="width:100%" collapseTags v-model="maNhomCapHoc" :placeholder="'Chọn'" filterable
                                 :data="list_nhom_cap_hoc" :fields="['name','value']"/>
                    </div>
                </div>
                <div class="col-sm-3">
                    <label>Trạng thái</label>
                    <select v-model="trangThai" class="form-control">
                        <option value=''>Tất cả</option>
                        <option value='1'>Đang hoạt động</option>
                        <option value='0'>Ngưng hoạt động</option>
                        <option value='-1'>Đã xóa</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <label>Mã trường học</label>
                    <input class="form-control" v-on:keyup.enter="getData" v-model="maTruongHoc"
                           placeholder="Nhập..."/>
                </div>
                <div class="col-sm-3">
                    <label>Tên trường học</label>
                    <input class="form-control" v-on:keyup.enter="getData" v-model="tenTruongHoc"
                           placeholder="Nhập..."/>
                </div>
                <div class="col-sm-3">
                    <label>Loại hình đào tạo</label>
                    <!-- <select v-model="loaiHinhDaoTao" class="form-control">
                        <option v-for="lh in list_loai_hinh_dao_tao" :value="lh.value">{{lh.name}}</option>
                    </select> -->
                    <eselect style="width:100%" collapseTags v-model="loaiHinhDaoTao" :placeholder="'Chọn'" filterable
                             :data="list_loai_hinh_dao_tao" :fields="['name','value']"/>
                </div>
            </div>
            <div class="text-center" style="padding-top:15px">
                <el-button type="success" size="mini" v-on:click.prevent="TruocKhiTim()">Tìm kiếm</el-button>

            </div>
        </div>
        <!-- hết tìm kiếm -->
        <!-- danh sách -->
        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 ">
                                <div class="pull-right">
                                    <div>
                                        <template v-if="lsTruongHoc.length">
                                            <button class="button btn btn-success btn-sm" @click.prevent="showDialogGiaiTheList()">Giải thể</button>
                                            <button class="button btn btn-warning btn-sm">Hủy giải thể</button>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;"/>
                        <div class="row">
                            <div class="col-sm-12">


                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr style="background:rgb(228, 235, 245)">
                                            <th class="cg">
                                                <input type="checkbox" v-model="slectAll" />
                                            </th>
                                            <th>
                                                <p>STT</p>
                                            </th>
                                            <th>
                                                <p>Mã Trường</p>
                                            </th>
                                            <th>
                                                <p>Tên Trường</p>
                                            </th>
                                            <th>
                                                <p>Cấp học</p>
                                            </th>
                                            <th>
                                                <p>Nhóm cấp học</p>
                                            </th>
                                            <th>
                                                <p>Đơn vị</p>
                                            </th>
                                            <th>
                                                <p>Quận huyện</p>
                                            </th>
                                            <th>
                                                <p>Tỉnh thành</p>
                                            </th>
                                            <th>
                                                <p>Loại hình đào tạo</p>
                                            </th>
                                            <th>
                                                <p>Ngày thành lập</p>
                                            </th>
                                            <th>
                                                <p>Trạng thái</p>
                                            </th>

                                            <th>
                                                <p>Thao tác</p>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_truong_hoc.length===0">
                                        <tr>
                                            <td class="text-center" colspan="23">
                                                <p>Không có bản ghi nào</p>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tbody v-else>
                                        <tr v-for="(tg,index) in ds_truong_hoc"
                                            v-bind:class="{ hoatDong: tg.trangThai==1, ngungHoatDong: tg.trangThai==0 }">
                                            <td class="text-center">
                                                <input type="checkbox" v-model="lsTruongHoc" :value="tg.maTruongHoc">
                                            </td>
                                            <td class="text-center">
                                                <p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tg.maTruongHoc }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tg.tenTruongHoc }}</p>
                                            </td>
                                            <td>
                                                <p>{{ getTenCapHoc(tg.capHoc )}}</p>
                                            </td>
                                            <td>
                                                <p>{{ getTenNhomCapHoc(tg.maNhomCapHoc) }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tg.tenDonVi }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tg.tenQuanHuyen }}</p>
                                            </td>
                                            <td>
                                                <p>{{ tg.tenTinhThanh }}</p>
                                            </td>
                                            <td>
                                                <p>{{ getLoaiHinhDaoTao(tg.loaiHinhDaoTao) }}</p>
                                            </td>
                                            <td class="text-center">
                                                <p>{{ tg.ngayThanhLap }}</p>
                                            </td>
                                            <!-- <td class="text-center"><p v-if="tg.ngayThanhLap">{{getTime(tg.ngayThanhLap)}}</p></td> -->
                                            <td class="text-center">
                                                <p>{{getTrangThai(tg.trangThai)}}</p>
                                            </td>

                                            <td class="text-center">
                                                <button class="button btn btn-success btn-sm" @click.prevent="showDialogGiaiThe(tg)">Giải thể</button>
                                                <button class="button btn btn-warning btn-sm">Hủy giải thể</button>

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

        <el-dialog
                :visible.sync="show_dialog_giai_the"
                append-to-body
            title="Giải thể trường học">
            <div>
                <p><strong>Thao tác giải thể trường học sẽ xóa các thông tin liên quan sau</strong></p>
                <ul>
                    <li>Hồ sơ lớp học</li>
                    <li>Hồ sơ nhân sự</li>
                    <li>Hồ sơ học sinh</li>
                    <li>Đánh giá chuẩn nghề nghiệp nhân sự</li>
                    <li>Các quá trình nhân sự</li>
                    <li>Báo cáo EMIS</li>
                </ul>
                <p><strong style="color: #DC0101">Lưu ý: Trường giải thể sẽ không khôi phục lại được dữ liệu</strong></p>
                <div class="row">
                    <div class="col-sm-3 text-right">
                        <label>Kỳ học giải thể</label>
                    </div>
                    <div class="col-sm-3">
                        <el-select v-model="ky_hoc" placeholder="--Chọn--">

                            <el-option value="" label="--Chọn--"></el-option>
                            <el-option :value="1" label="Học kì I"></el-option>
                            <el-option :value="2" label="Học kì II"></el-option>
                        </el-select>
                    </div>
                    <div class="col-sm-3">
                        <el-button size="small" type="primary" @click.prevent="">Giải thể</el-button> </div>
                </div>
            </div>
            <div slot="footer" class="dialog-footer">
               <div class="text-center">
                   <el-button size="small" type="default" @click="show_dialog_giai_the = false">Huỷ</el-button>
               </div>
            </div>
        </el-dialog>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import rest_api from '../../utils/rest_api';
import array_util from '../../utils/array_utils';
import timeutils from '../../utils/time_utils';
import Page from '../ui/PagingCustom';
import ESelectVue from '../ui/ESelect.vue';

import dialog from '../../utils/dialog';
import constant from '../../utils/constant';
import api from './../api';
import Breadcrumb from '../ui/Breadcrumb.vue';

export default {
    components: {

        Multiselect,
        "Page": Page,
        'eselect': ESelectVue,
        Breadcrumb
    },
    computed: {},
    data() {
        return {
            ky_hoc : '',
            show_dialog_giai_the : false,
            lsTruongHoc : [],
            slectAll: false,
            selectAllDiemTruong: false,
            list_diem_truong_delete: [],
            thongtin: JSON.parse(window.userInfo),
            thongtinso: {},
            tmpTruongHoc: {},
            date: new Date(),
            namHoc: "",
            list_nam_hoc: constant.LIST_YEARS_FULL,
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
            ds_truong_hoc: [],
            ds_diem_truong: [],
            list_loai_hinh_dao_tao: [
                {
                    name: "Công lập - [1]",
                    value: 1
                },
                {
                    name: "Tư thục - [2]",
                    value: 2
                },
                {
                    name: "GDTX - [3]",
                    value: 3
                },
                {
                    name: "Ngoài công lập - [4]",
                    value: 4
                },{
                    name: "Dân lập - [5]",
                    value: 5
                },
            ],
            start: 0,
            currentPage: 1,
            resTrang: 1,
            limit: 25,
            total_rows: 0,
            //  tìm kiếm
            danhSachDonViSo: "",
            danhSachDonViPhong: "",
            danhSachCapHoc: "",
            list_don_vi_so: [],
            list_don_vi_phong: [],
            //  gửi đi
            maSo: "",
            maPhong: "",
            capHoc: "",
            maNhomCapHoc: "",
            tenTruongHoc: "",
            maTruongHoc: "",
            loaiHinhDaoTao: "",
            trangThai: "",
            //  Thêm trường học
            trangbatdau: false,
            show_create: false,
            //    Chỉnh sửa trường học
            show_update: false,
            dataEditTruongHoc: {},
            //    thông tin trường học
            show_info: false,
            dataInfoTruongHoc: {},
            //    import
            show_import: false,
        }
    },
    mounted() {
        if (this.thongtin.role > 1) {
            this.maSo = this.thongtin.ma_so;
        }
        this.getDonViCapSo();
        this.getDonViCapPhong();
        this.getData();
        this.namHoc = this.thongtin.namHocHienTai;
        $(this.$refs.modal_diem_truong).on("hidden.bs.modal", this.close);
    },
    watch: {
        list_diem_truong_delete: function (newVal) {
            if (newVal) {
                let data = newVal;
                if (data.length == this.ds_diem_truong.length && data.length > 0) {
                    this.selectAllDiemTruong = true;
                } else {
                    this.selectAllDiemTruong = false;
                }
            } else {
                this.selectAllDiemTruong = false;
            }
        },

        slectAll: function (newVal) {
            if (newVal) {
                this.lsTruongHoc = [];
                for (let i = 0; i < this.ds_truong_hoc.length; i++) {
                    this
                        .lsTruongHoc
                        .push(this.ds_truong_hoc[i].maTruongHoc);
                }
            } else {
                this.lsTruongHoc = [];
            }
        },
    },
    methods: {
        showDialogGiaiThe(e){
            this.show_dialog_giai_the = true
        },
        showDialogGiaiTheList(e){
            this.show_dialog_giai_the = true
        },
        //   Lấy lại dữ liệu
        layLai(e) {
            console.log("lấy lại danh sách:" + JSON.stringify(e));
            this.start = e.start;
            this.limit = e.limit;
            this.currentPage = e.currentPage;
            this.getData()
        },

        getTenDonVi(e) {
            let data = "";
            if (e) {
                for (let i = 0; i < this.list_don_vi_phong.length; i++) {
                    if (this.list_don_vi_phong[i].value == e) {
                        data = this.list_don_vi_phong[i].name
                    }
                }
            }
            return data
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
        // Xuất  danh sách trường học

        TruocKhiTim() {
            this.trangbatdau = !this.trangbatdau;
        },
        // Import trường học
        showImport() {
            console.log("Import file từ excel");
            this.show_import = true;
        },

        // định nghĩa cho đơn vị
        setNameDonVi({
                         tenDonVi,
                         maDonVi
                     }) {
            return `${tenDonVi} - [${maDonVi}]`
        },
        // định nghĩa cho cấp học
        setNameCapHoc({
                          name
                      }) {
            return `${name}`
        },
        // Lấy danh sách sở
        getDonViCapSo() {
            if (this.thongtin.role > 3) {
                this.maSo = this.thongtin.ma_so;
            }
            let params = {
                "start": 0,
                "limit": 1000,
                "loaiDonVi": 1
            };
            let loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                loading.close();
                let dulieu = data.data.rows;
                let ldvs = [];
                for (let i = 0; i < dulieu.length; i++) {
                    let obj = {
                        name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                            ' - [' + dulieu[i].maDonVi + ']',
                        value: dulieu[i].maDonVi
                    }
                    ldvs.push(obj);
                }
                this.list_don_vi_so = ldvs;
            });
        },
        getDonViCapPhong() {
            if (this.thongtin.role > 3) {
                this.maPhong = this.thongtin.ma_don_vi;
            }
            let params = {
                "start": 0,
                "limit": 1000,
                "maTinhThanh": this.maSo,
                //   "loaiDonVi": 2
            };
            let loading2 = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                loading2.close();
                let dulieu = data.data.rows;
                let ldvs = [];
                for (let i = 0; i < dulieu.length; i++) {
                    let obj = {
                        name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                            ' - [' + dulieu[i].maDonVi + ']',
                        value: dulieu[i].maDonVi
                    }
                    ldvs.push(obj);
                }
                this.list_don_vi_phong = ldvs;
            });
        },
        // Chọn sở
        ChonDonViSo() {
            this.list_don_vi_phong = [];
            this.maPhong = "";
            this.getDonViCapPhong();
        },
        onChonCapHoc() {
            this.capHoc = "";
            if (this.danhSachCapHoc) {
                this.capHoc = this.danhSachCapHoc.id;
            }
            console.log("cấp học:" + this.capHoc);
        },
        // Chọn sở
        onChonDonViPhong() {
            if (this.danhSachDonViPhong) {
                this.maPhong = this.danhSachDonViPhong.maDonVi;
            } else {
                this.maPhong = "";
            }
        },
        getData() {
            let params = {
                "start": this.start,
                "limit": this.limit,
                "ma": this.maTruongHoc,
                "ten": this.tenTruongHoc,
                "trangthai": this.trangThai,
                "maNhomCapHoc": this.maNhomCapHoc,
                "caphoc": this.capHoc,
                "matinhthanh": this.maSo,
                "madonvi": this.maPhong,
                "loaihinhdaotao": this.loaiHinhDaoTao
            };
            console.log("lấy dữ liệu:");
            console.log(JSON.stringify(params));
            let loading2 = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.get("/internal-api/dmTruongHoc/filter", params, (data) => {
                loading2.close();
                if (array_util.isArray(data.data.rows)) {
                    this.total_rows = data.data.total;
                    array_util.clearArrays(this.ds_truong_hoc);
                    this.ds_truong_hoc = data.data.rows;
                    if (this.total_rows > 0) {
                        // this.thongBao('success', 'Lấy dữ liệu thành công')
                    } else {
                        // this.thongBao('error', 'Không có bản ghi nào được tìm thấy')
                    }
                }
            });
        },
        getTenCapHoc(e){
            var res = null;
            for (let i = 0; i < this.list_cap_hoc.length; i++) {
                if (this.list_cap_hoc[i].id == e) {
                    res = this.list_cap_hoc[i].name;
                }
            }
            if(res===null){
                res = 'Liên cấp ' + e;
            }
            return res;
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
        getLoaiHinhDaoTao(loai) {
            var res = loai;
            for (let i = 0; i < this.list_loai_hinh_dao_tao.length; i++) {
                if (this.list_loai_hinh_dao_tao[i].value == res) {
                    return this.list_loai_hinh_dao_tao[i].name;
                }
            }
        },
        getTime(date) {
            return timeutils.dateToString(new Date(date));
        },
        getStatusType(check){

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
    }
}
</script>
<style scoped="scoped">

.el-select .el-input.is-disabled .el-input__inner {
    color: #303133 !important;
}

th {
    text-align: center;
    align-items: center;
}

.col-sm-3 {
    height: 75px;
}
</style>


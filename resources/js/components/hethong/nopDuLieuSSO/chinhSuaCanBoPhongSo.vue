<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog width="70%" top="5vh" :title="text_header" custom-class="showThongTinLoiImportSSO" :visible.sync="show_update"
                   :close-on-press-escape="false"
                   append-to-body
                   :close-on-click-modal="false" :show-close="false" @before-close="closeImport">
            <el-row :gutter="20">
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Mã cán bộ <span class="red">*</span></label>
                    <el-input clearable ref="maCanBo" placeholder="Nhập..." v-model="dataEdit.maCanBo"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Tên giáo viên</label>
                    <el-input clearable placeholder="Nhập..." v-model="dataEdit.tenCanBo"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Giới tính</label>
                    <eselect collapseTags v-model="dataEdit.gioiTinh" :placeholder="'Chọn'" filterable :data="list_gioi_tinh"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Ngày sinh</label>
                    <date-picker :append-to-body="false" v-model="dataEdit.ngaySinh" placeholder="Chọn" valueType="format"
                                 value-type="DD/MM/YYYY" format="DD/MM/YYYY" >
                    </date-picker>
                </el-col>

                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Số CMND</label>
                    <el-input clearable placeholder="Nhập..." v-model="dataEdit.soCmnd"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Email</label>
                    <el-input clearable placeholder="Nhập..." v-model="dataEdit.email"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Số điện thoại</label>
                    <el-input clearable placeholder="Nhập..." v-model="dataEdit.soDienThoaiDiDong"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Địa chỉ</label>
                    <el-input clearable placeholder="Nhập..." v-model="dataEdit.diaChi"></el-input>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Tỉnh thành</label>
                    <eselect collapseTags v-model="dataEdit.maTinh" @change="chonTinhThanh" :placeholder="'Chọn'" filterable :data="danh_sach_tinh_thanh"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Quận huyện</label>
                    <eselect collapseTags v-model="dataEdit.maHuyen" :placeholder="'Chọn'" filterable :data="danh_sach_quan_huyen"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Loại tài khoản</label>
                    <el-input clearable placeholder="Nhập..." v-model="dataEdit.jobPosition"></el-input>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="danger" @click="closeImport">Huỷ</el-button>
                <el-button size="mini" type="warning" @click.prevent="confirmUpdate">Chỉnh sửa</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
import rest_api from "../../../utils/rest_api";
import DatePicker from 'vue2-datepicker';
import ESelectVue from '../../ui/ESelect.vue';
import 'vue2-datepicker/index.css';

export default {
    props: ['item'],
    components: {
        DatePicker,
        'eselect': ESelectVue,
    },
    watch: {},
    data() {
        return {
            files: null,
            loading: {
                status: false,
                text: 'Loading...'
            },
            show_update: false,
            text_header: 'Chỉnh sửa thông tin cán bộ phòng sở',
            danh_sach_tinh_thanh:[],
            danh_sach_quan_huyen:[],
            danh_sach_truong_hoc:[],
            list_gioi_tinh:[
                {name:'Nam',value:1},
                {name:'Nữ',value:0},
            ],
            list_co_khong:[
                {name:'Có',value:'1'},
                {name:'Không',value:'0'},
            ],
            dataEdit:{},
            thongtin:{},
        }
    },

    mounted: function () {
        console.log('Mounted chỉnh sửa giáo viên')
        this.thongtin = JSON.parse(window.userInfo);
        console.log(this.item)
        this.getTinhThanh();
        this.ganDuLieuChinhSua();
    },
    methods: {
        chonTinhThanh(){
            console.log('chonTinhThanh')
            this.dataEdit.maHuyen = '';
            if(this.dataEdit.maTinh){
                this.getDanhSachQuanHuyen()
            }
        },
        upDateDuLieu(){
            console.log('update dữ liệu');
            console.log('update dữ liệwwu');
            let params = {
                "actor": this.thongtin.username,
                "cMND": this.dataEdit.soCmnd,
                "diaChi": this.dataEdit.diaChi,
                "email": this.dataEdit.email,
                "gioiTinh": this.dataEdit.gioiTinh,
                "hoTen": this.dataEdit.tenCanBo,
                "maCanBo": this.dataEdit.maCanBo,
                "maQuanHuyen": this.dataEdit.maHuyen,
                "maTinhThanh": this.dataEdit.maTinh,
                "namHoc": this.dataEdit.namHoc,
                "ngaySinh": this.dataEdit.ngaySinh,
                "soDienThoai": this.dataEdit.soDienThoaiDiDong,
                "maLoaiTaiKhoan": this.dataEdit.jobPosition,

            };
            this.loading.text='Vui lòng đợi...';
            this.loading.status = true;
            rest_api.post("/csdlgd-admin/sso/editCanBoPhongSo", params, (response) => {
                if(response&&response.data.rc==0){
                    this.thongBao('success','Chỉnh sửa thành công');
                    this.loading.status = false;
                    this.$emit('updateSuccess');
                }
                else{
                    this.thongBao('error',response.data.rd)
                }
                this.loading.status = false;
            });

        },
        confirmUpdate(){
            console.log('confirmUpdate')
            console.log(this.dataEdit)
            if (!this.dataEdit.maCanBo||this.dataEdit.maCanBo==''){
                this.thongBao('error','Thiếu thông tin mã cán bộ');
                this.$refs.maCanBo.focus();
                return;
            }
            
            this.upDateDuLieu();
            // this.$confirm('Xác nhận chỉnh sửa thông tin?', 'Thông báo', {
            //     confirmButtonText: 'Xác nhận',
            //     cancelButtonText: 'Hủy',
            // })
            //     .then(_ => {
            //     })
            //     .catch(_ => {});
        },
        getDanhSachQuanHuyen(){
            console.log('Lấy danh sách quận huyện')
            console.log('Lấy quận huyện')
            try {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maTinhThanh": this.dataEdit.maTinh,
                };
                this.loading.status = true;
                this.loading.text = 'Lấy danh sách quận huyện';
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (response) => {
                    console.log(response)
                    if (response.data.code == 200) {
                        let array = response.data.rows;
                        let quan_huyen = [];
                        for (let i = 0; i < array.length; i++) {
                            let obj = {
                                name:array[i].tenQuanHuyen + ' - ['+ array[i].maQuanHuyen +']',
                                value:array[i].maQuanHuyen
                            }
                            quan_huyen.push(obj);
                        }
                        this.loading.status = false;
                        this.danh_sach_quan_huyen = quan_huyen;
                    } else {
                        this.thongBao('error', 'Không lấy đưuọc danh sách quận huyện')
                    }
                });

            } catch (e) {
                this.thongBao('error', 'Không lấy được danh sách quận huyện')
            }
        },
        ganDuLieuChinhSua(){
            console.log('Gán dữ liệu chỉnh sửa:');
            console.log(this.item);
            this.dataEdit = JSON.parse(JSON.stringify(this.item));
            if(this.dataEdit.maTinh){
                this.getDanhSachQuanHuyen();
            }
            this.show_update = true;
        },
        getTinhThanh() {
            console.log('Lấy tỉnh thành')
            try {
                let params = {
                    "start": 0,
                    "limit": 999,
                };
                this.loading.status = true;
                this.loading.text = 'Lấy danh sách tỉnh thành';
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (response) => {
                    console.log(response)
                    if (response.data.code == 200) {
                        let array = response.data.rows;
                        let tinh_thanh = [];
                        for (let i = 0; i < array.length; i++) {
                            let obj = {
                                name:array[i].tenTinhThanh + ' - ['+ array[i].maTinhThanh +']',
                                value:array[i].maTinhThanh
                            }
                            tinh_thanh.push(obj);
                        }
                        this.loading.status = false;
                        this.danh_sach_tinh_thanh = tinh_thanh;
                    } else {
                        this.thongBao('error', 'Không lấy đưuọc danh sách tỉnh thành')
                    }
                });

            } catch (e) {
                this.thongBao('error', 'Không lấy được danh sách tỉnh thành')
            }
        },
        closeImport() {
            this.$emit('close');
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

.bg-purple {
    background: #d3dce6;
}

.grid-content {
    border-radius: 4px;
    min-height: 36px;
}

.mt-15 {
    margin-top: 15px
}

.mb-15 {
    margin-bottom: 15px
}

.pd-10 {
    padding: 10px
}

</style>

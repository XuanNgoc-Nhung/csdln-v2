<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog width="95%" top="5vh" :title="text_header" :visible.sync="show_add"
                   :close-on-press-escape="false"
                   append-to-body
                   :close-on-click-modal="false" :show-close="false" @before-close="closeImport">
            <el-row :gutter="20">
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Tỉnh thành:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Quận huyện:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Phường xã:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Tổ thôn:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Đơn vị quản lý:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Mã trường:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Tên trường:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Cấp học:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Nhóm cấp học:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Loại hình đào tạo:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Loại hình trường:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Ngày thành lập:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Chuẩn quốc gia:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Website:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Tên hiệu trưởng:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Email:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Fax:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Địa chỉ:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
                <el-col :xs="24" :sm="12" :md="8" :lg="6">
                    <label>Trạng thái:</label>
                    <eselect collapseTags v-model="dataAdd" :placeholder="'Chọn'" filterable :data="[]"
                             :fields="['name','value']"/>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="danger" @click="closeImport">Huỷ</el-button>
                <el-button size="mini" type="primary" @click.prevent="confirmAdd">Thêm mới</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
import rest_api from "../../../utils/rest_api";
import ESelectVue from '../../ui/ESelect.vue';
import 'vue2-datepicker/index.css';

export default {
    props: [],
    components: {
        'eselect': ESelectVue,
    },
    watch: {},
    data() {
        return {
            loading: {
                status: false,
                text: 'Loading...'
            },
            show_add: false,
            text_header: 'Thêm mới thông tin trường học',
            dataAdd: {
                capHoc:'',
                capHocs:[],
                chiBoDang:'',
                chuanQuocGia:'',
                diaChi:'',
                email:'',
                fax:'',
                idPhong:'',
                idSo:'',
                loaiHinhDaoTao:'',
                loaiHinhTruong:'',
                ma:'',
                maDoiTac:'',
                maDonVi:'',
                maNhomCapHoc:'',
                maPxa:'',
                maQhuyen:'',
                maQuanHuyen:'',
                maTinhThanh:'',
                maTruongHoc:'',
                maTthanh:'',
                maTthon:'',
                ngayCapNhat:'',
                ngayThanhLap:'',
                sdt:'',
                sdtHieuTruong:'',
                ten:'',
                tenDonVi:'',
                tenHieuTruong:'',
                tenPhuongXa:'',
                tenQuanHuyen:'',
                tenTinhThanh:'',
                tenToThon:'',
                tenTruongHoc:'',
                trangThai:'',
                vungBienGioi:'',
                vungKhoKhan:'',
                website:'',
            },
            thongtin:{},
        }
    },

    mounted: function () {
        this.thongtin = JSON.parse(window.userInfo);
        this.show_add = true;
    },
    methods: {
        confirmAdd(){
            console.log('confirmAdd');
        },
        addData(){
            try {
                let params = {
                    roleName: this.dataAdd.roleName,
                    parentRole: this.dataAdd.parentRole,
                    description: this.dataAdd.description,
                    maSo:this.thongtin.ma_so
                };
                this.loading.text='Vui lòng đợi...';
                this.loading.status = true;
                rest_api.post("/csdlgd-user/adminRole/createRole", params, (response) => {
                    if(response&&response.data.rc==0){
                        this.thongBao('success','Thêm mới thành công');
                        this.loading.status = false;
                        this.$emit('addSuccess');
                    }
                    else{
                        this.thongBao('error',response.data.rd)
                    }
                    this.loading.status = false;
                });
            }
            catch (e) {
                this.thongBao('error','Có lỗi trong quá trình thao tác. Vui lòng thử lại');
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


</style>

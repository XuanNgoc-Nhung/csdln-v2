<template>
    <div v-loading.fullscreen.lock="loading.status">
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo; </span>HỆ THỐNG<span class="kytu">
                        &raquo;</span> ĐỒNG BỘ DANH MỤC</span>
            </div>
        </div>
        <!-- tìm kiếm -->
        <el-row :gutter="24">
            <el-col :span="6">
                <label>Loại dữ liệu</label>
                <eselect style="width:100%"   multiple
                         collapseTags v-model="loaiDuLieu" :placeholder="'Chọn'" filterable :data="danh_sach_loai_du_lieu"
                         :fields="['name','value']" />
            </el-col>
            <el-col :span="4">
                <label style="color:transparent;display:block">Đồng bộ</label>
                <el-button type="primary" size="mini" v-on:click.prevent="dongBoDuLieu()">Đồng bộ</el-button></el-col>
        </el-row>
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
            danh_sach_loai_du_lieu:[
                {name:'Trường học',value:'1'},
                {name:'Cán bộ',value:'2'},
                {name:'Học sinh',value:'3'},
                {name:'Lớp học',value:'4'},
                {name:'Kết quả học tập giữa kỳ',value:'5'},
                {name:'Kết quả học tập cuối kỳ',value:'6'},
                {name:'Đánh giá chuẩn nghề nghiệp',value:'7'},
            ],
            loaiDuLieu:[]
        }
    },
    mounted() {
    },
    watch: {},
    methods: {
        dongBoDuLieu(){
            if(this.loaiDuLieu.length==0){
                this.thongBao('error','Vui lòng chọn loại dữ liệu')
                return;
            }
            this.$confirm('Xác nhận đồng bộ danh mục đã chọn?', 'Thông báo', {
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy',
                closeOnClickModal: false,
            })
                .then(_ => {

                    const loading = this.$loading({
                        lock: true,
                        text: 'Đang đồng bộ',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    setTimeout(()=>{
                        loading.close();
                        this.thongBao('success','Đồng bộ thành công')
                    },3000)
                })
                .catch(_ => {});
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


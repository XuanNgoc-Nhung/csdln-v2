<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :span="12" class="text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> hệ thống <span class="kytu">
                        &raquo;</span> Nộp dữ liệu sso</span>
            </el-col>
<!--            <el-col :span="12" class="text-uppercase">-->
<!--                <marquee width="100%" direction="left" scrollamount="6">-->
<!--                    <span style="color:blue"><b>Thông báo:</b></span><span class="red"> Từ 01/08/2021, cần tạo lại-->
<!--                        dữ liệu năm học mới trên hệ thống CSDL ngành năm học 2021-2022 để tạo tài khoản SSO.</span>-->
<!--                </marquee>-->
<!--            </el-col>-->
        </el-row>
        <el-row :span="20" class="card-bieu-do mt-15">
            <el-col :span="24">
                <el-tabs type="border-card2"  v-model="activeName">
                    <el-tab-pane name="duLieuGiaoVien" label="1. Dữ liệu giáo viên">
                        <duLieuGiaoVien></duLieuGiaoVien>
                    </el-tab-pane>
                    <el-tab-pane name="duLieuCanBoPhongSo" label="2. Dữ liệu cán bộ phòng/sở">
                        <duLieuCanBoPhongSo></duLieuCanBoPhongSo>
                    </el-tab-pane>
                    <el-tab-pane name="duLieuHocSinh" label="3. Dữ liệu học sinh">
                        <duLieuHocSinh></duLieuHocSinh>
                    </el-tab-pane>
                    <el-tab-pane name="xoaDuLieu" label="4. Xoá dữ liệu">
                        <xoaDuLieu></xoaDuLieu>
                    </el-tab-pane>
                </el-tabs>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import duLieuGiaoVien from "./duLieuGiaoVien";
    import duLieuCanBoPhongSo from "./duLieuCanBoPhongSo";
    import duLieuHocSinh from "./duLieuHocSinh";
    import xoaDuLieu from "./xoaDuLieu";
    export default {
        components: {
            duLieuGiaoVien,
            duLieuCanBoPhongSo,
            duLieuHocSinh,
            xoaDuLieu,
        },
        watch: {
            activeName:function(newVal){
                if(newVal){
                    this.loading.status = true;
                    this.loading.text = 'Vui lòng đợi...';
                    setTimeout(()=>{
                        this.loading.status = false;
                    },500)
                }
            }
        },
        data() {
            return {
                thongtin: {},
                activeName:'duLieuGiaoVien',
                loading:{
                    text:'Loading...',
                    status:false,
                }
            }
        },
        mounted() {
            this.thongtin = JSON.parse(window.userInfo);
            console.log('Mount nộp dữ liệu sso');
            console.warn(this.thongtin)
        },
        methods: {}
    }

</script>
<style scoped="scoped">
    .mt-15 {
        margin-top: 15px !important;
    }

</style>

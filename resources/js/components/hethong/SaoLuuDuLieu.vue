<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span>Sao lưu dữ liệu</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div>
                    <p><b><span style="color:blue">Ghi chú:</span></b>Hệ thống tự động sao lưu dữ liệu vào các thời điểm 0h,6h,12h và 18h hàng ngày.</p>
                    <p>Tải xuống dữ liệu được sao lưu mới nhất ở liên kết bên dưới:</p>
                    <ul>
                        <li><p>1.Trường học.</p></li>
                        <li><p>2.Lớp học.</p></li>
                        <li><p>3.Cán bộ.</p></li>
                        <li><p>4.Học sinh.</p></li>
                        <li><p>5.Cớ sở vật chất</p></li>
                        <li><p>6.Kết quả học tập.</p></li>
                    </ul>
                    <p>Vui lòng tải xuống <span><a :href="linktai" target="_blank" title="File backup">Tại đây</a></span></p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        components: {
        },
        watch: {
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                linktai:""            }
        },
        props: [],
        mounted() {
            this.linktai = "/file/temporary/DuLieuSaoLuu-"+this.thongtin.ma_so +".zip"
        },
        methods: {
            taiFileSaoLuu(){
                console.log("tải file backup");
                console.log(this.linktai);
            }
        }
    }

</script>
<style scoped="scoped">
li{
    list-style: none;
}
</style>

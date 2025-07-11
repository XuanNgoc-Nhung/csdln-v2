<template>
    <div>
        <el-row class="thongKeCoban" :gutter="24" style="margin-left: -12px !important; margin-right: -12px !important;">
            <el-col :span="6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <el-row :gutter="20">
                            <el-col :span="24">
                                <div class="dts-box-header dts-bg-info">
                                    <p>Số lượng trường học</p>
                                    <div class="dts-box-icon icon-info">
                                        <img src="https://i.pinimg.com/originals/b1/b7/de/b1b7de37299d6d589ba3d7e28652869b.png" class="img-circle elevation-2" alt="User Image">
                                    </div>
                                </div>
                                <div class="dts-box-value">
                                    <h4>{{thongTinThongKe.truongHoc.toLocaleString()}}</h4>
                                </div>
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </el-col>
             <el-col :span="6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <el-row :gutter="20">
                            <el-col :span="24">
                                <div class="dts-box-header dts-bg-warning">
                                    <p>Số lượng cán bộ</p>
                                    <div class="dts-box-icon icon-warning">
                                        <img src="https://www.seekpng.com/png/full/138-1388073_login-icons-user-flat-icon-png.png" class="img-circle elevation-2" alt="User Image">
                                    </div>
                                </div>
                                <div class="dts-box-value">
                                    <h4>{{thongTinThongKe.giaoVien.toLocaleString()}}</h4>
                                </div>
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </el-col>
             <el-col :span="6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <el-row :gutter="20">
                            <el-col :span="24">
                                <div class="dts-box-header dts-bg-student">
                                    <p>Số lượng học sinh</p>
                                    <div class="dts-box-icon icon-student">
                                        <img src="https://toppng.com/uploads/preview/graduation-icon-icon-male-student-11553392521bnztilqdiq.png" class="img-circle elevation-2" alt="User Image">
                                    </div>
                                </div>
                                <div class="dts-box-value">
                                    <h4>{{thongTinThongKe.hocSinh.toLocaleString()}}</h4>
                                </div>
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </el-col>
             <el-col :span="6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <el-row :gutter="20">
                            <el-col :span="24">
                                <div class="dts-box-header dts-bg-danger">
                                    <p>Số học sinh bỏ học</p>
                                    <div class="dts-box-icon icon-danger">
                                        <img src="https://www.freeiconspng.com/thumbs/warning-icon-png/status-warning-icon-png-29.png" class="img-circle elevation-2" alt="User Image">
                                    </div>
                                </div>
                                <div class="dts-box-value">
                                    <h4>{{thongTinThongKe.hocSinhNghiHoc.toLocaleString()}}</h4>
                                </div>
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    export default {
        props: ['item'],
        components: {},
        watch: {
            item(newVal) {
                console.log(" thay đổi");
                if (newVal) {
                    this.thongTinThongKe = newVal;
                    console.log(this.thongTinThongKe)
                }
            }
        },
        data() {
            return {
                thongTinThongKe: {
                    truongHoc: 0,
                    giaoVien: 0,
                    hocSinh: 0,
                    lopHoc: 0,
                    hocSinhNghiHoc: 0,
                }
            };
        },
        methods: {}
    }

</script>

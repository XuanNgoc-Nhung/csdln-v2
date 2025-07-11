<template>
    <div>
        <div class="card-bieu-do" style="margin-top:25px">
            <el-row :gutter="24">
                <el-col :span="4">
                    <h5><i class="fas fa-graduation-cap"></i> Học sinh</h5>
                </el-col>
                <el-col :span="10">
                </el-col>
                <el-col :span="8" class="text-right">
                    <div v-if="thong_tin_hoc_sinh.lastUpdate" class="inline">
                        <h5> <i class="fas fa-clock"></i> Thời gian cập nhật: </h5> <span
                            style="font-weight: 600;font-size: 16px;padding-left:5px">
                            {{thong_tin_hoc_sinh.lastUpdate}}</span>
                    </div>
                </el-col>
                <el-col :span="2" class="text-right">
                    <el-button plain type="success" size="mini" @click.prevent="chuyenLinkTraCuuHocSinh">Chi tiết</el-button>
                </el-col>
                <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                <!-- Tổng quan học sinh -->
                <div>
                    <TongQuan :item="thong_tin_hoc_sinh.toanTruong?thong_tin_hoc_sinh.toanTruong.tongQuan:null" :tong="thong_tin_hoc_sinh.toanTruong?thong_tin_hoc_sinh.toanTruong.tongSoHocSinh:0" :name="''"></TongQuan>
                </div>
                <div v-if="thong_tin_hoc_sinh.toanTruong">

                    <div v-for="item in thong_tin_hoc_sinh.toanTruong.hocSinhTheoCap">
                        <div v-if="item.name=='MN'">
                            <HocSinhMn :item="item.data" :name="''"></HocSinhMn>
                        </div>
                        <div v-if="item.name=='TH'">
                            <HocSinhTieuHoc :item="item.data" :name="''"></HocSinhTieuHoc>
                        </div>
                        <div v-if="item.name=='THCS'">
                            <HocSinhTHCS :item="item.data" :name="''"></HocSinhTHCS>
                        </div>
                        <div v-if="item.name=='THPT'">
                            <HocSinhTHPT :item="item.data" :name="''"></HocSinhTHPT>
                        </div>
                    </div>
                </div>
                <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                <div v-for="item in thong_tin_hoc_sinh.theoDiemTruong">
                    <TongQuan :item="item.data" :name="item.name"></TongQuan>
                    <div v-for="cap_hoc in item.hocSinhTheoCap">
                        <div v-if="cap_hoc.name=='MN'">
                            <HocSinhMn :item="cap_hoc.data" :name="item.name"></HocSinhMn>
                        </div>
                        <div v-if="cap_hoc.name=='TH'">
                            <HocSinhTieuHoc :item="cap_hoc.data" :name="item.name"></HocSinhTieuHoc>
                        </div>
                        <div v-if="cap_hoc.name=='THCS'">
                            <HocSinhTHCS :item="cap_hoc.data" :name="item.name"></HocSinhTHCS>
                        </div>
                        <div v-if="cap_hoc.name=='THPT'">
                            <HocSinhTHPT :item="cap_hoc.data" :name="item.name"></HocSinhTHPT>
                        </div>
                    </div>
                </div>
            </el-row>
        </div>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import TongQuan from './tongQuan';
    import HocSinhTieuHoc from './hocSinhTieuHoc';
    import HocSinhTHCS from './hocSinhThcs';
    import HocSinhTHPT from './hocSinhThpt';
    import HocSinhMn from './hocSinhMn';
    import TrangThaiHocSinh from './trangThai';
    import ESelectVue from '../../../ui/ESelect.vue';
    import {
        Loading
    } from 'element-ui';
    Vue.use(ElementUI);
    export default {
        props: ['item', 'diem_truong'],
        components: {
            'eselect': ESelectVue,
            TongQuan: TongQuan,
            HocSinhTieuHoc: HocSinhTieuHoc,
            HocSinhTHCS: HocSinhTHCS,
            HocSinhTHPT: HocSinhTHPT,
            HocSinhMn: HocSinhMn,
            TrangThaiHocSinh: TrangThaiHocSinh,
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                diemTruong: [],
                list_truong_hoc: [],
                thong_tin_hoc_sinh: {},
            }
        },
        watch: {
            item: function (newVal) {
                if (newVal) {
                    console.log("Thay đổi trong thông tin chung:")
                    console.log(newVal)
                    this.thong_tin_hoc_sinh = newVal;
                    console.log(JSON.stringify(this.thong_tin_hoc_sinh))
                }
            },
            diem_truong: function (newVal) {
                if (newVal) {
                    this.list_truong_hoc = newVal;
                }
            },
        },
        mounted: function () {
            this.thong_tin_hoc_sinh = this.item
        },
        methods: {
            chuyenLinkTraCuuHocSinh() {

                let uri = 'Look-up-students';
                window.open(uri, '_blank').focus();
            },
            getTieuHoc(e) {
                if (e == 'tieuHoc') {
                    return true
                } else {
                    return false
                }
            },
            getThcs(e) {
                if (e == 'thcs') {
                    return true
                } else {
                    return false
                }
            },
            getThpt(e) {
                if (e == 'thpt') {
                    return true
                } else {
                    return false
                }
            },
            getMn(e) {
                if (e == 'Mn') {
                    return true
                } else {
                    return false
                }
            },
        }
    }

</script>
<style scoped="scoped">
    h3,
    h5 {
        margin: 0;
    }

    .card-bieu-do {
        margin: 15px 0;
        background: white;
        border-radius: 10px;

    }

    .inline {
        display: inline-flex;
    }

</style>

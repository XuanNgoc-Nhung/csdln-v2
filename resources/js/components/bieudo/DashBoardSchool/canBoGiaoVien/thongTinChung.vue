<template>
    <div>
        <div class="card-bieu-do" style="margin-top:25px">
            <el-row :gutter="24">
                <el-col :sm="10" :lg="12" >
                    <h5><i class="fas fa-graduation-cap"></i> Cán bộ - Giáo viên</h5>
                </el-col>
                <el-col :sm="10" :lg="10" class="text-right">
                    <div class="inline">
                        <h5> <i class="fas fa-clock"></i> Thời gian cập nhật: </h5> <span
                            style="font-weight: 600;font-size: 16px;padding-left:5px"> {{item.lastUpdate}}</span>
                    </div>
                </el-col>
                <el-col :sm="4" :lg="2" class="text-right">
                    <el-button plain type="success" size="mini" @click.prevent="chuyenLinkTraCuuCbgv">Chi tiết</el-button>
                </el-col>
                <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                <!-- Biểu đồ -->
                <div>
                    <TongQuan :item="thong_tin_cbgv.tongCanBoChart" :danglamviec="thong_tin_cbgv.slCbDangLamViec" :name="''"></TongQuan>
                </div>
                <div v-if="thong_tin_cbgv.toanTruong&&thong_tin_cbgv.toanTruong.cbTrinhDoChinh">
                    <TrinhDoChinh :item="thong_tin_cbgv.toanTruong.cbTrinhDoChinh" :name="''">
                    </TrinhDoChinh>
                </div>
                <div v-if="thong_tin_cbgv.toanTruong&&thong_tin_cbgv.toanTruong.cbHopDong">
                    <LoaiHopDong :item="thong_tin_cbgv.toanTruong.cbHopDong" :name="''"></LoaiHopDong>
                </div>
                <div v-if="thong_tin_cbgv.toanTruong&&thong_tin_cbgv.toanTruong.cbGioiTinh">
                    <GioiTinh :item="thong_tin_cbgv.toanTruong.cbGioiTinh" :name="''"></GioiTinh>
                </div>
                <div v-if="thong_tin_cbgv.toanTruong&&thong_tin_cbgv.toanTruong.cbDoTuoi">
                    <DoTuoi :item="thong_tin_cbgv.toanTruong.cbDoTuoi" :name="''"></DoTuoi>
                </div>
                <div v-if="thong_tin_cbgv.toanTruong&&thong_tin_cbgv.toanTruong.canBoTrangThai">
                    <TrangThai :item="thong_tin_cbgv.toanTruong.canBoTrangThai" :name="''"></TrangThai>
                </div>
            </el-row>
        </div>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import TongQuan from './tongQuan';
    import TrinhDoChinh from './trinhDoChinh';
    import LoaiHopDong from './loaiHopDong';
    import GioiTinh from './gioiTinh';
    import Demo from './demoChart';
    import Demo2 from './demoChart2';
    import Demo3 from './demoChart3';
    import DoTuoi from './doTuoi';
    import TrangThai from './trangThai';
    import ESelectVue from '../../../ui/ESelect.vue';
    import {
        Loading
    } from 'element-ui';
    Vue.use(ElementUI);
    export default {
        props: ['item'],
        components: {
            'eselect': ESelectVue,
            TongQuan: TongQuan,
            Demo: Demo,
            Demo2: Demo2,
            Demo3: Demo3,
            TrinhDoChinh: TrinhDoChinh,
            LoaiHopDong: LoaiHopDong,
            GioiTinh: GioiTinh,
            DoTuoi: DoTuoi,
            TrangThai: TrangThai,
        },
        data() {
            return {
                thong_tin_cbgv: {}
            }
        },
        watch: {
            item: function (newVal) {
                if (newVal) {
                    console.log("Thay đổi trong thông tin chung:")
                    console.log(newVal)
                    this.thong_tin_cbgv = newVal;
                    console.log(JSON.stringify(this.thong_tin_cbgv))
                }
            },
        },
        mounted: function () {
            this.thong_tin_cbgv = this.item
        },
        methods: {

            chuyenLinkTraCuuCbgv() {
                let uri = 'Look-up-officials';
                window.open(uri, '_blank').focus();
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

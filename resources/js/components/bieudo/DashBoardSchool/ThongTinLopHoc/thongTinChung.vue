<template>
    <div>
        <div class="card-bieu-do" style="margin-top:25px" v-loading="show_loading"
            element-loading-background="rgba(0, 0, 0, 0.5)">
            <el-row :gutter="24">
                <el-col :sm="24" :lg="4">
                    <h5><i class="fas fa-graduation-cap"></i> Lớp học </h5>
                </el-col>
                <el-col :sm="9" :lg="9" v-if="list_truong_hoc.length>0">
                    <div>
                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="diemTruong"
                            :placeholder="'Chọn điểm trường'" filterable :data="list_truong_hoc"
                            :fields="['name','value']" />
                    </div>
                </el-col>
                <el-col :sm="4" :lg=2 v-if="list_truong_hoc.length>0">
                    <div >
                        <el-button plain size="mini" @click.prevent="getThongKeLopHocTheoDiemTruong()"
                            style=" width:100%;font-size:14px; padding-left:10px;" type="success">Thống
                            kê</el-button>
                    </div>
                </el-col>
                <el-col :sm="6" :lg="7" class="text-right">
                    <div class="inline">
                        <h5> <i class="fas fa-clock"></i> Thời gian cập nhật: </h5> <span
                            style="font-weight: 600;font-size: 16px;padding-left:5px"> {{item.lastUpdate}}</span>
                    </div>
                </el-col>
                <el-col :sm="4" :lg="2" class="text-right">
                    <el-button plain type="success" size="mini" @click.prevent="chuyenLinkTraCuuLopHoc">Chi tiết</el-button>
                </el-col>
                <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                <!-- Trường chính -->
                <div v-for="item in thong_tin_lop_hoc.toanTruong">
                    <div v-if="item.name=='MN'">
                        <LopHocPhanTheoKhoiMamNon :item="item.data" :name="''"></LopHocPhanTheoKhoiMamNon>
                    </div>
                    <div v-if="item.name=='TH'">
                        <LopHocPhanTheoKhoiTieuHoc :item="item.data" :name="''">
                        </LopHocPhanTheoKhoiTieuHoc>
                    </div>
                    <div v-if="item.name=='THCS'">
                        <LopHocPhanTheoKhoiThcs :item="item.data" :name="''"></LopHocPhanTheoKhoiThcs>
                    </div>
                    <div v-if="item.name=='THPT'">
                        <LopHocPhanTheoKhoiThpt :item="item.data" :name="''"></LopHocPhanTheoKhoiThpt>
                    </div>
                </div>
                <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                <!-- For qua các điểm trường -->
                <div v-for="item in thong_tin_lop_hoc.theoDiemTruong">
                    <div v-for="cap_hoc in item.data">
                        <div v-if="cap_hoc.name=='MN'">
                            <LopHocPhanTheoKhoiMamNon :item="cap_hoc.data" :name="item.name"></LopHocPhanTheoKhoiMamNon>
                        </div>
                        <div v-if="cap_hoc.name=='TH'">
                            <LopHocPhanTheoKhoiTieuHoc :item="cap_hoc.data" :name="item.name">
                            </LopHocPhanTheoKhoiTieuHoc>
                        </div>
                        <div v-if="cap_hoc.name=='THCS'">
                            <LopHocPhanTheoKhoiThcs :item="cap_hoc.data" :name="item.name"></LopHocPhanTheoKhoiThcs>
                        </div>
                        <div v-if="cap_hoc.name=='THPT'">
                            <LopHocPhanTheoKhoiThpt :item="cap_hoc.data" :name="item.name"></LopHocPhanTheoKhoiThpt>
                        </div>
                    </div>
                    <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                </div>
            </el-row>
        </div>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import ESelectVue from '../../../ui/ESelect.vue';
    import rest_api from '../../../../utils/rest_api';
    import LopHocPhanTheoKhoiMamNon from './LopHocPhanTheoKhoiMn';
    import LopHocPhanTheoKhoiTieuHoc from './LopHocPhanTheoKhoiTieuHoc';
    import LopHocPhanTheoKhoiThcs from './LopHocPhanTheoKhoiThcs';
    import LopHocPhanTheoKhoiThpt from './LopHocPhanTheoKhoiThpt';
    import {
        Loading
    } from 'element-ui';
    Vue.use(ElementUI);
    export default {
        props: ['item', 'diem_truong', 'nam_hoc'],
        components: {
            'eselect': ESelectVue,
            LopHocPhanTheoKhoiMamNon: LopHocPhanTheoKhoiMamNon,
            LopHocPhanTheoKhoiTieuHoc: LopHocPhanTheoKhoiTieuHoc,
            LopHocPhanTheoKhoiThcs: LopHocPhanTheoKhoiThcs,
            LopHocPhanTheoKhoiThpt: LopHocPhanTheoKhoiThpt,
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                diemTruong: [],
                show_loading: false,
                list_truong_hoc: [],
                thong_tin_lop_hoc: {}
            }
        },
        watch: {
            diem_truong: function (newVal) {
                this.list_truong_hoc = newVal;
            },
            item: function (newVal) {
                if (newVal) {
                    // this.thongTinTruong = newVal;
                    console.log("Thay đổi trong thông tin chung:")
                    console.log(newVal)
                    this.thong_tin_lop_hoc = newVal;
                    console.log(JSON.stringify(this.thong_tin_lop_hoc))
                }
            },
        },
        mounted: function () {
            this.thong_tin_lop_hoc = this.item;
            this.list_truong_hoc = this.diem_truong;
        },
        methods: {
            chuyenLinkTraCuuLopHoc() {
                let uri = 'Look-up-classes';
                window.open(uri, '_blank').focus();
            },
            getThongKeLopHocTheoDiemTruong() {
                this.show_loading = true;
                console.log(this.diemTruong)
                this.thong_tin_lop_hoc.theoDiemTruong = [];
                let params = {
                    "namHoc": this.nam_hoc,
                    "maTruongs": [this.thongtin.ma_truong_hoc],
                    "dsMaDiemTruong": this.diemTruong,
                };
                rest_api.post("/csdlgd-report-api/dasboard/truong/lophoc", params, (data) => {
                    this.show_loading = false;
                    console.log("res:");
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        console.log("Gán")
                        this.thong_tin_lop_hoc.theoDiemTruong = data.data.item.theoDiemTruong;
                        console.log(JSON.stringify(this.thong_tin_lop_hoc.theoDiemTruong))
                    }
                });
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

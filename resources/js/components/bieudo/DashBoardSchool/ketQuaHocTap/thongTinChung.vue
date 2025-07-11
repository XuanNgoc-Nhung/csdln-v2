<template>
    <div>
        <div class="card-bieu-do" style="margin-top:25px" v-loading="show_loading"
            element-loading-background="rgba(0, 0, 0, 0.5)">
            <el-row :gutter="24">
                <el-col :span="4">
                    <h5><i class="fas fa-graduation-cap"></i>Kết quả học tập</h5>
                </el-col>
                <el-col :span="5">
                    <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                        no-data-text="danh sách lựa chọn trống" collapse-tags v-model="hocKy"
                        :placeholder="'Chọn'" filterable :data="danh_sach_hoc_ky" :fields="['name','value']" />
                </el-col>
                <el-col :span=2>
                    <el-button plain size="mini" style=" width:100%;font-size:14px; padding-left:10px;"
                        @click.prevent="getThongKe" type="success">Cập nhật</el-button>
                </el-col>
                <el-col :span="13" class="text-right">
                    <div class="inline">
                        <h5> <i class="fas fa-clock"></i> Thời gian cập nhật: </h5> <span
                            style="font-weight: 600;font-size: 16px;padding-left:5px">{{item.lastUpdate}}</span>
                    </div>
                </el-col>
                <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                <!-- Toàn trường -->
                <!-- <KetQuaHocTapMamNon></KetQuaHocTapMamNon> -->
                <div>
                    <div v-for="item in thong_tin_ket_qua_hoc_tap.toanTruong">
                        <div v-if="item.name=='MN'">
                            <div v-for="bieu_do in item.data.data">
                                <div v-if="bieu_do.data.length>0">
                                    <KetQuaHocTapMamNon :item="bieu_do.data" :name="bieu_do.name"></KetQuaHocTapMamNon>
                                </div>
                            </div>
                            <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                        </div>
                        <div v-if="item.name=='TH'">
                            <div v-if="item.data.tongQuan&&item.data.tongQuan.length>0">
                                <TongQuanTieuHoc :item="item.data.tongQuan" :name="''"></TongQuanTieuHoc>
                            </div>
                            <div v-if="item.data.hsTheoKhoiLop&&item.data.hsTheoKhoiLop.length>0">
                                <HocLucTieuHoc :item="item.data.hsTheoKhoiLop" :name="''"></HocLucTieuHoc>
                            </div>
                            <div v-if="item.data.hoanThanhCt&&item.data.hoanThanhCt.length>0">
                                <TongQuanHTCTTieuHoc :item="item.data.hoanThanhCt" :name="''"></TongQuanHTCTTieuHoc>
                            </div>
                            <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                        </div>
                        <div v-if="item.name=='THCS'">
                            <div v-if="item.data.tongQuanHocLuc&&item.data.tongQuanHocLuc.length>0">
                                <TongQuanTHCS :item="item.data.tongQuanHocLuc" :name="''"></TongQuanTHCS>
                            </div>
                            <div v-if="item.data.hocLucTheoKhoi&&item.data.hocLucTheoKhoi.length>0">
                                <HocLucTHCS :item="item.data.hocLucTheoKhoi" :name="''"></HocLucTHCS>
                            </div>
                            <div v-if="item.data.tongQuanHanhKiem&&item.data.tongQuanHanhKiem.length>0">
                                <TongQuanHanhKiemTHCS :item="item.data.tongQuanHanhKiem" :name="''">
                                </TongQuanHanhKiemTHCS>
                            </div>
                            <div v-if="item.data.hanhKiemTheoKhoi&&item.data.hanhKiemTheoKhoi.length>0">
                                <HanhKiemTHCS :item="item.data.hanhKiemTheoKhoi" :name="''"></HanhKiemTHCS>
                            </div>
                            <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                        </div>
                        <div v-if="item.name=='THPT'">
                            <div v-if="item.data.tongQuanHocLuc.length>0">
                                <TongQuanTHPT :item="item.data.tongQuanHocLuc" :name="''"></TongQuanTHPT>
                            </div>
                            <div v-if="item.data.hocLucTheoKhoi.length>0">
                                <HocLucTHPT :item="item.data.hocLucTheoKhoi" :name="''"></HocLucTHPT>
                            </div>
                            <div v-if="item.data.tongQuanHanhKiem.length>0">
                                <TongQuanHanhKiemTHPT :item="item.data.tongQuanHanhKiem" :name="''">
                                </TongQuanHanhKiemTHPT>
                            </div>
                            <div v-if="item.data.hanhKiemTheoKhoi.length>0">
                                <HanhKiemTHPT :item="item.data.hanhKiemTheoKhoi" :name="''"></HanhKiemTHPT>
                            </div>
                            <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                        </div>
                    </div>
                    <div v-if="thong_tin_ket_qua_hoc_tap.theoDiemTruong">
                        <div v-for="diem_truong in thong_tin_ket_qua_hoc_tap.theoDiemTruong">
                            <div v-for="item in diem_truong.data">
                                <div v-if="item.name=='tieuHoc'">
                                    <TongQuanTieuHoc :item="item.data.tongQuanHocLuc" :name="diem_truong.name">
                                    </TongQuanTieuHoc>
                                    <HocLucTieuHoc :item="item.data.hocLucTheoKhoi" :name="diem_truong.name">
                                    </HocLucTieuHoc>
                                    <TongQuanHTCTTieuHoc :item="item.data.hoan_thanh_chuong_trinh"
                                        :name="diem_truong.name">
                                    </TongQuanHTCTTieuHoc>
                                    <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                                </div>
                                <div v-if="item.name=='thcs'">
                                    <TongQuanTHCS :item="item.data.tongQuanHocLuc" :name="diem_truong.name">
                                    </TongQuanTHCS>
                                    <HocLucTHCS :item="item.data.hocLucTheoKhoi" :name="diem_truong.name"></HocLucTHCS>
                                    <TongQuanHanhKiemTHCS :item="item.data.tongQuanHanhKiem" :name="diem_truong.name">
                                    </TongQuanHanhKiemTHCS>
                                    <HanhKiemTHCS :item="item.data.hanhKiemTheoKhoi" :name="diem_truong.name">
                                    </HanhKiemTHCS>
                                    <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                                </div>
                                <div v-if="item.name=='thpt'">
                                    <TongQuanTHPT :item="item.data.tongQuanHocLuc" :name="diem_truong.name">
                                    </TongQuanTHPT>
                                    <HocLucTHPT :item="item.data.hocLucTheoKhoi" :name="diem_truong.name"></HocLucTHPT>
                                    <TongQuanHanhKiemTHPT :item="item.data.tongQuanHanhKiem" :name="diem_truong.name">
                                    </TongQuanHanhKiemTHPT>
                                    <HanhKiemTHPT :item="item.data.hanhKiemTheoKhoi" :name="diem_truong.name">
                                    </HanhKiemTHPT>
                                    <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </el-row>
        </div>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import rest_api from '../../../../utils/rest_api';
    import ESelectVue from '../../../ui/ESelect.vue';
    import TongQuanMN from './tongQuanMn';
    import TongQuanTieuHoc from './tongQuanTieuHoc';
    import TongQuanHTCTTieuHoc from './tongQuanHTCTTieuHoc';
    import TongQuanTHCS from './tongQuanTHCS';
    import TongQuanTHPT from './tongQuanTHPT';
    import TongQuanHanhKiemTHCS from './TongQuanHanhKiemTHCS';
    import TongQuanHanhKiemTHPT from './TongQuanHanhKiemTHPT';
    import HoanThanhCTTieuHoc from './hoanThanhChuongTrinhTieuHoc';
    import KetQuaHocTapMamNon from './KetQuaHocTapMamNon';
    import HocLucTieuHoc from './hocLucTieuHoc';
    import HocLucTHCS from './hocLucThcs';
    import HocLucTHPT from './hocLucThpt';
    import HanhKiemTHCS from './hanhKiemPhanTheoKhoiThcs';
    import HanhKiemTHPT from './hanhKiemPhanTheoKhoiThpt';
    import {
        Loading
    } from 'element-ui';
    Vue.use(ElementUI);
    export default {
        props: ['item', 'nam_hoc'],
        components: {
            'eselect': ESelectVue,
            TongQuanMN: TongQuanMN,
            TongQuanTieuHoc: TongQuanTieuHoc,
            TongQuanHTCTTieuHoc: TongQuanHTCTTieuHoc,
            TongQuanTHCS: TongQuanTHCS,
            TongQuanTHPT: TongQuanTHPT,
            HoanThanhCTTieuHoc: HoanThanhCTTieuHoc,
            KetQuaHocTapMamNon: KetQuaHocTapMamNon,
            HocLucTieuHoc: HocLucTieuHoc,
            HocLucTHCS: HocLucTHCS,
            HocLucTHPT: HocLucTHPT,
            TongQuanHanhKiemTHCS: TongQuanHanhKiemTHCS,
            TongQuanHanhKiemTHPT: TongQuanHanhKiemTHPT,
            HanhKiemTHCS: HanhKiemTHCS,
            HanhKiemTHPT: HanhKiemTHPT,
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                show_loading: false,
                hocKy: 1,
                danh_sach_hoc_ky: [{
                        name: "Học kỳ I",
                        value: 1
                    },
                    {
                        name: "Học kỳ II",
                        value: 2
                    },
                    {
                        name: "Cả năm",
                        value: 3
                    },
                ],
                thong_tin_ket_qua_hoc_tap: {},

            }
        },
        watch: {
            item: function (newVal) {
                if (newVal) {
                    this.hocKy = 1;
                    console.log("Thay đổi trong thông tin chung:")
                    console.log(newVal)
                    this.thong_tin_ket_qua_hoc_tap = newVal;
                }
            },
        },
        mounted: function () {
            console.log("mounted trong kqht:")
            console.log(JSON.stringify(this.item))
            this.thong_tin_ket_qua_hoc_tap = this.item;
        },
        methods: {
            getThongKe() {
                if (!this.hocKy) {
                    this.$alertify.error("Vui lòng chọn học kỳ");
                    return;
                }
                this.show_loading = true;
                this.thong_tin_ket_qua_hoc_tap = {};
                this.thongTinPhoDiem = {};
                let params = {
                    "namHoc": this.nam_hoc,
                    "hocKy": this.hocKy,
                    "maTruongs": [this.thongtin.ma_truong_hoc],
                    "maSo": this.thongtin.ma_so,
                };
                rest_api.post("/csdlgd-report-api/dasboard/truong/ketquahoctap", params, (data) => {
                    console.log("res kqht:");
                    this.show_loading = false;
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        this.thong_tin_ket_qua_hoc_tap = data.data.item;
                    }
                });
            }
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

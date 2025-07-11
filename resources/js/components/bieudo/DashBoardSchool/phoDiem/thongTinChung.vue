<template>
    <div>
        <div class="card-bieu-do" v-loading="show_loading" element-loading-background="rgba(0, 0, 0, 0.5)"
            style="margin-top:25px">
            <el-row :gutter="24">
                <el-col :span="4">
                    <h5><i class="fas fa-graduation-cap"></i>Phổ điểm</h5>
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
                            style="font-weight: 600;font-size: 16px;padding-left:5px"> {{item.lastUpdate}}</span>
                    </div>
                </el-col>
                <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                    <PhoDiem :item="pho_diem.toanTruong" :name="''">
                    </PhoDiem>
                <div v-if="pho_diem.theoDiemTruong">
                    <div v-for="item in pho_diem.theoDiemTruong">
                        <PhoDiem :item="item.data" :name="item.name"></PhoDiem>
                    </div>
                </div>
                <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
            </el-row>
        </div>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import PhoDiem from './PhoDiem';
    import ESelectVue from '../../../ui/ESelect.vue';
    import rest_api from '../../../../utils/rest_api';
    import {
        Loading
    } from 'element-ui';
    import VueAlertify from "vue-alertify";
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
    Vue.use(ElementUI);
    export default {
        props: ['item', 'nam_hoc'],
        components: {
            'eselect': ESelectVue,
            PhoDiem: PhoDiem,
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
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
                danh_sach_diem_truong: [],
                diemTruong: "",
                pho_diem: {},
                namHoc: "",
                show_loading: false,
            }
        },
        watch: {
            item: function (newVal) {
                if (newVal) {
                    this.hocKy = 1;
                    console.log("Thay đổi trong thông tin chung:")
                    console.log(newVal)
                    this.pho_diem = newVal;
                }
            },
            diem_truong: function (newVal) {
                if (newVal) {
                    this.diemTruong = [];
                    this.danh_sach_diem_truong = newVal;
                }
            },
            nam_hoc: function (newVal) {
                if (newVal) {
                    this.namHoc = newVal;
                }
            },
        },
        mounted: function () {
            console.log("mounted phổ điểm:")
            console.log(JSON.stringify(this.item))
            this.pho_diem = this.item;
            this.danh_sach_diem_truong = this.diem_truong;
            this.namHoc = this.nam_hoc;
        },
        methods: {
            getThongKe() {
                if (!this.hocKy) {
                    this.$alertify.error("Vui lòng chọn học kỳ");
                    return;
                }
                this.pho_diem = {};
                this.show_loading = true;
                this.thongTinPhoDiem = {};
                let params = {
                    "namHoc": this.namHoc,
                    "hocKy": this.hocKy,
                    "maTruongs": [this.thongtin.ma_truong_hoc],
                };
                rest_api.post("/csdlgd-report-api/dasboard/truong/phodiem", params, (data) => {
                    console.log("res thống kê phổ điểm:");
                    this.show_loading = false;
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        this.pho_diem = data.data.item;
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

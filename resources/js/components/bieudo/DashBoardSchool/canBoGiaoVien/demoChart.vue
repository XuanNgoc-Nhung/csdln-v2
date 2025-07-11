<template>
    <div>
        <el-col :md="12" :lg="8">
            <div class="dts-moibieudo grid-content bg-purple-light">
                <div class="dts-card-header">
                    <span class="dts-card-title">thống kê Học sinh nghỉ học theo tháng</span></span></span>
                </div>
                <div class="dts-card-body" v-loading="false" element-loading-background="rgba(0, 0, 0, 0.8)">
                    <div>
                        <div class="bieudo" id="tongquancanbogiaovien" ref="bieudo"></div>
                    </div>
                </div>
            </div>
        </el-col>
    </div>
</template>
<style>
</style>
<script>
import ApexCharts from 'apexcharts'
export default {
    props: ['item','name','tong'],
    data() {
        return {
            bieuTongQuanNhaTruong: {
                series: [],
                chart: {
                    width: '175%',
                    height: '290',
                    type: 'line',
                    zoom: {
                        enabled: true
                    },
                    toolbar: {
                        show: false
                    },
                    animations: {
                        enabled: true
                    }
                },
                colors: ['#FF9933', '#00FF00', '#FF0000', '#E91E63', '#FF9800', '#F781F3', '#FFFF00', '#19070B',
                    '#00FF40'
                ],
                stroke: {
                    curve: 'smooth',
                },
                labels: ['T9', 'T10', 'T11', 'T12', 'T1', 'T2', 'T3', 'T4', 'T5'],

            },

        }
    },
    mounted() {
        this.bindData();
    },
    components: {
        apexchart: ApexCharts,
    },
    watch: {
        item: function (newVal) {
            if (newVal) {
                console.log("Thay đổi thông tin trong biểu đồ:")
                console.log(newVal)
                this.bindData();
            }
        },},
    methods: {
        bindData() {
            console.error('123 bindData')
            this.bieuTongQuanNhaTruong.series = [ {
                "name": "Học sinh nghỉ học",
                "data": [ 9000,8000,7000,8000,9500,4500,7000,8000,8500 ]
            },{
                "name": "Nghỉ có phép",
                "data": [ 8500,7500,6000,7500,8500,3900,5300,6900,7500 ]
            },{
                "name": "Nghỉ không phép",
                "data": [ 500,500,1000,500,1000,600,1700,1100,1000 ]
            },]
            console.error(this.item)
            this.ganDuLieuBieuDoTongQuanNhaTruong();
        },
        ganDuLieuBieuDoTongQuanNhaTruong() {
            let element2  = this.$refs.bieudo;
            var chartDuong = new ApexCharts(element2, this.bieuTongQuanNhaTruong);
            chartDuong.render();
        },
    },
}

</script>
<style scoped="scoped">
.apexcharts-canvas {
    margin: 0 auto !important;
}

div#tongquancanbogiaovien {
    margin: 0 auto;
    text-align: center;
    display: table;
}
</style>

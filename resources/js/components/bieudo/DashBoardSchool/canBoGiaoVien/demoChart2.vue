<template>
    <div>
        <el-col :md="12" :lg="8">
            <div class="dts-moibieudo grid-content bg-purple-light">
                <div class="dts-card-header">
                    <span class="dts-card-title">Thống kê</span>
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
    props: ['item','name','danglamviec'],
    data() {
        return {
            duLieuBieuDo: [10, 20, 30],
            bieuTongQuanNhaTruong: {
                series: [],
                chart: {
                    width: '128%',
                    type: 'donut',
                    zoom: {
                        enabled: true
                    },
                    animations: {
                        enabled: true
                    }
                },
                colors: ['#60BFFF', '#969AFB', '#969AFB', '#90ED7D', '#014839', '#FB4444','#009966'],

                stroke: {
                    curve: 'smooth',
                },
                legend: {
                    show: true,
                    position: 'bottom',
                },
                dataLabels: {
                    formatter(val, opts) {
                        const name = opts.w.globals.labels[opts.seriesIndex]
                        const tong = opts.w.globals.seriesTotals[opts.seriesIndex]
                        return [name, val.toFixed(2) + '%']
                    },
                    style: {
                        fontSize: '12px',
                        fontWeight: 'bold',
                    },
                },
                labels: ['Đi học', 'Nghỉ học'],
                plotOptions: {
                    pie: {
                        startAngle: 0,
                        endAngle: 360,
                        expandOnClick: true,
                        offsetX: 0,
                        offsetY: 0,
                        customScale: 1,
                        dataLabels: {
                            offset: 0,
                            minAngleToShowLabel: 10
                        },
                        donut: {
                            size: '45%',
                            background: 'transparent',
                            labels: {
                                show: true,
                                name: {
                                    show: false,
                                    fontSize: '12px',
                                    fontFamily: 'Helvetica, Arial, sans-serif',
                                    fontWeight: 100,
                                    color: undefined,
                                    offsetY: 0,
                                    formatter: function (val) {
                                        return val
                                    }
                                },
                                value: {
                                    show: true,
                                    fontSize: '12px',
                                    fontFamily: 'Helvetica, Arial, sans-serif',
                                    fontWeight: 100,
                                    color: undefined,
                                    offsetY: 6,
                                    formatter: function (val) {
                                        return val
                                    }
                                },
                                total: {
                                    show: true,
                                    showAlways: true,
                                    label: 'Tổng số',
                                    fontSize: '12px',
                                    fontFamily: 'Helvetica, Arial, sans-serif',
                                    fontWeight: 100,
                                    color: '#373d3f',
                                    formatter: function (w) {
                                        let tongso = w.globals.seriesTotals.reduce((a, b) => {
                                            return a + b
                                        }, 0)
                                        return tongso.toLocaleString() + ' Hs'
                                    }
                                }
                            }
                        },
                    }
                }
            },

        }
    },
    mounted() {
        this.bindData(this.duLieuBieuDo);
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
            this.bieuTongQuanNhaTruong.series = [198123,23234];
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

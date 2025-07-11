<template>
    <div>

        <el-col :md="16" :lg="24">
            <div class="dts-moibieudo grid-content bg-purple-light">
                <div class="dts-card-header">
                    <span class="dts-card-title">Sức khỏe nuôi dưỡng {{getName(name)}}</span>
                </div>
                <div class="dts-card-body" v-loading="false" element-loading-background="rgba(0, 0, 0, 0.8)">
                    <div>
                        <div class="bieudo" ref="bieudo"></div>
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
    import Anychart from 'anychart'
    export default {
        props: ['item', 'name'],
        data() {
            return {}
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
                    this.BindData();
                }
            },
        },
        methods: {
            getName(e){
                let res="";
                if(e=='T'){
                    res = "nhà trẻ"
                }
                if(e=='N'){
                    res="Mẫu giáo"
                }
                return res;
            },
            bindData(e) {
                let series = this.item;
                let categories = ['Khám sức khỏe định kỳ', 'Theo dõi cân nặng', 'Theo dõi chiều cao',
                    'Suy sinh dưỡng thể thấp còi', 'Bị bệnh tiêu hóa, hô hấp', 'Bị béo phì', 'Được làm quen tin học'
                ];
                let element = this.$refs.bieudo;
                this.generateChart(series, categories, element)
            },
            generateChart(series, categories, element) {
                let chart;
                const options = {
                    series,
                    colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444'],
                    chart: {
                        type: "bar",
                        width: '100%',
                        height: '300',
                        stacked: true,
                        toolbar: {
                            show: true
                        },
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function (val, opts) {
                            return Math.abs(val.toLocaleString());
                        },
                        style: {
                            fontSize: '12px',
                            fontWeight: 'bold',
                        },
                    },
                    tooltip: {
                        y: {
                            formatter: function (val, opts) {
                                return ': ' + Math.abs(val.toLocaleString());
                            },
                            title: {
                                formatter: (seriesName) => seriesName,
                            },
                        },
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '50%',
                            horizontal: true,
                            dataLabels: {
                                maxItems: 2
                            }
                        }
                    },
                    xaxis: {
                        categories,
                        axisTicks: {
                            show: true
                        },
                        axisBorder: {
                            show: true
                        },
                        labels: {
                            hideOverlappingLabels: true,
                            formatter: function (val) {
                                return Math.abs(val.toLocaleString());
                            }
                        }
                    },
                    yaxis: {
                        axisTicks: {
                            show: false
                        },
                        axisBorder: {
                            show: true
                        },
                        labels: {
                            hideOverlappingLabels: false,
                            formatter: function (val, opts) {
                                return val;
                                // return Math.abs(val.toLocaleString());
                            },
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    legend: {
                        position: "top",
                        horizontalAlign: "center"
                    },
                    grid: {
                        padding: {
                            left: 13.5,
                            right: 0
                        },
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                    }
                };
                chart = new ApexCharts(element, options);
                chart.render();
                chart.updateOptions([options])
            }
        },
    }

</script>
<style scoped="scoped">
    .apexcharts-canvas {
        margin: 0 auto !important;
    }

</style>

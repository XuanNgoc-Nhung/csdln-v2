<template>
    <div>
        <el-col :md="12" :lg="8">
            <div class="dts-moibieudo grid-content bg-purple-light">
                <div class="dts-card-header">
                    <span class="dts-card-title">Thống kê thông tin sức khoẻ</span>
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
        return {
            duLieuBieuDo: [{
                name: 'Học sinh nam',
                data: [25.156, 11.124 ]
            },
                {
                    name: 'Học sinh nữ',
                    data: [11.932, 4.696]
                }

            ]
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
        },
    },
    methods: {
        bindData(e) {
            let series = this.duLieuBieuDo;
            let categories = ['Biết bơi', 'Có bệnh về mắt'];
            let element = this.$refs.bieudo
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
                    stacked: false,
                    toolbar: {
                        show: true
                    },
                },
                dataLabels: {
                    enabled: true,
                    formatter: function (val, opts) {
                        return val.toLocaleString();
                    },
                    style: {
                        fontSize: '12px',
                        fontWeight: 'bold',
                    },
                },
                plotOptions: {
                    bar: {
                        columnWidth: '70%',
                        horizontal: false,
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
                        hideOverlappingLabels: false,
                    }
                },
                yaxis: {
                    axisTicks: {
                        show: true
                    },
                    axisBorder: {
                        show: true
                    },
                    labels: {
                        hideOverlappingLabels: true,
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
                            show: true
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

div#bieudochatluongdaotaonhatruong {
    margin: 0 auto;
    text-align: center;
    display: table;
}

</style>

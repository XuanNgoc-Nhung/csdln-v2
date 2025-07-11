<template>
    <div ref="chuabieudo">
        <div class="bieudo scorllWidth" ref="bieudo"></div>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'

    export default {
        props: ['dulieu'],
        data() {
            return {}
        },
        mounted() {
            if (this.dulieu) {
                this.bindData(this.dulieu);
            }
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {

            dulieu: function (newVal) {
                if (newVal) {
                    let data_demo = newVal;
                    this.bindData(data_demo)
                }
            },
        },
        methods: {
            getWidthChart(e) {
                return '100%';
                let minWidth = this.$refs.chuabieudo.clientWidth;
                let Width = e.length * 50;
                if (Width > minWidth) {
                    return Width;
                } else {
                    return minWidth;
                }
            },
            bindData(e) {
                let element = this.$refs.bieudo;
                let series = this.dulieu.series;
                let categories = this.dulieu.category;
                let height = this.dulieu.height ? this.dulieu.height : ''
                this.generateChart(series, categories, height, element)
            },
            generateChart(series, categories, height, element) {
                console.log('1231231313')
                console.log(series)
                let chart;
                const options = {
                    series,
                    // colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444'],
                    // colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444', '#00a65a', '#FFA200',
                    //     '#60BFFF', '#90ED7D'
                    // ],
                    colors : ["#32C5A7", "#60BFFF","#F1C656", "#FF6767","#939AAE", "#B2B96A",'#00a65a', '#FFA200','#60BFFF', '#1ab394'],
                    chart: {
                        type: "bar",
                        width: this.getWidthChart(categories),
                        height: height,
                        stacked: false,
                        toolbar: {
                            show: false
                        },
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 1,
                            dataLabels: {
                                position: 'top', // top, center, bottom
                            },
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        offsetY: -20,
                        formatter: function (val, opts) {
                            return val.toLocaleString();
                        },
                        style: {
                            fontSize: '12px',
                            colors: ["#304758"]
                        }

                    },
                    noData: {
                        text: "Biểu đồ chưa có dữ liệu",
                        align: 'center',
                        verticalAlign: 'middle',
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            color: undefined,
                            fontSize: '14px',
                            fontFamily: undefined
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
                    tooltip: {
                        enabled: true,
                        fillSeriesColor: false,
                        theme: 'dark',
                        style: {
                            fontSize: '12px',
                            fontFamily: undefined
                        },
                        onDatasetHover: {
                            highlightDataSeries: false,
                        },
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

</style>

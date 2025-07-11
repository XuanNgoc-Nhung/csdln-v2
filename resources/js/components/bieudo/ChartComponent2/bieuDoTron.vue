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
        return {

        }
    },
    mounted() {

        if (this.dulieu){
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
            if(Width>minWidth){
                return Width;
            }
            else{
                return minWidth;
            }
        },
        bindData(e) {
            console.log('bindData')
            let element  = this.$refs.bieudo;
            let series = e.series;
            let categories = e.category;
            let totalText = e.totalText;
            this.generateChart(series, categories, element,totalText)
        },
        generateChart(series, categories, element,totalText) {
            let chart;
            const options = {
                series,
                colors: ["#32C5A7", "#60BFFF","#F1C656", "#FF6767","#939AAE", "#B2B96A",'#00a65a', '#FFA200','#60BFFF', '#1ab394'],
                chart: {
                    width: '70%',
                    type: 'donut',
                    zoom: {
                        enabled: true
                    },
                    animations: {
                        enabled: true
                    }
                },
                legend: {
                    show: true,
                    position:'right'
                },
                dataLabels: {
                    formatter(val, opts) {
                        const name = opts.w.globals.labels[opts.seriesIndex]
                        return [val.toFixed(2) + '%']
                    },
                    style: {
                        fontSize: '11px',
                        fontWeight: 'solid',
                    },
                    offset:0,
                },
                labels: categories,
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
                            minAngleToShowLabel: 10,
                        },
                        donut: {
                            size: '50%',
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
                                        return tongso.toLocaleString() + ' ' + totalText
                                    }
                                }
                            }
                        },
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
.apexcharts-canvas{
}
</style>

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
            if (Width > minWidth) {
                return Width;
            } else {
                return minWidth;
            }
        },
        bindData(e) {
            console.log('123456')

            let element = this.$refs.bieudo;
            let series = e.series
            let categories =e.categories;
            let totalText = e.totalText;

            this.generateChart(series, categories, element, totalText)
        },
        generateChart(series, categories, element, totalText) {
            let chart;
            const options = {
                series,
                colors: ["#32C5A7", "#60BFFF","#F1C656", "#FF6767","#939AAE", "#B2B96A",'#00a65a', '#FFA200','#60BFFF', '#1ab394'],
                stroke: {
                    curve: 'smooth',
                },
                chart: {
                    width: '100%',
                    height:'280px',
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
                legend: {
                    position: "top",
                    horizontalAlign: "center"
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
                labels: categories,
                "yaxis": [{

                    "labels": {
                        "formatter": function (val) {
                            return val.toFixed(0)
                        }
                    }
                }]
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

.apexcharts-canvas {
}
</style>

<template>
    <div>
        <div ref="chuabieudo">
            <div  class="bieudo scorllWidth" ref="bieudo"></div>
        </div>
    </div>
</template>
<style>
</style>
<script>
import ApexCharts from 'apexcharts'
export default {
    props: ['dulieu','list_label','color'],
    data() {
        return {
        }
    },
    mounted() {
        if(this.dulieu&&this.dulieu.length>0){
            // this.bindData();
        }
    },
    components: {
        apexchart: ApexCharts,
    },
    watch: {
        dulieu: function (newVal) {
            if (newVal&&newVal.length) {
                console.log("Có thay đổi trong biểu đồ cột theo nhóm")
                console.log(newVal)
                    let data_demo = newVal;
                    this.bindData(data_demo)
            }
        },
    },
    methods: {
        bindData(e) {
            console.log('bindData')
            let series = e;
            let categories = this.list_label;
            let element = this.$refs.bieudo;
            this.generateChart(series, categories, element)
        },
        generateChart(series, categories, element) {
            let chart;
            const options = {
                series,
                colors: this.color,
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
                        return + val.toLocaleString();
                    },
                    style: {
                        fontSize: '12px',
                        fontWeight: 'bold',
                        colors:['#000']
                    },

                },
                plotOptions: {
                    bar: {
                        columnWidth: '80%',
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

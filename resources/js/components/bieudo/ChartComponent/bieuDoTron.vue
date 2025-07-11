<template>
        <div ref="chuabieudo">
            <div  class="bieudo scorllWidth" ref="bieudo"></div>
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
            duLieuBieuDo: [0, 0, 0, 0, 0, 0],
            bieuTongQuanNhaTruong: {
                series: [],
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
                colors: [],

                stroke: {
                    curve: 'smooth',
                },
                legend: {
                    show: false
                },
                dataLabels: {
                    formatter(val, opts) {
                        const name = opts.w.globals.labels[opts.seriesIndex]
                        const tong = opts.w.globals.seriesTotals[opts.seriesIndex]
                        return [name, tong +' ('+ val.toFixed(2) + '%'+')']
                        return [name, val.toFixed(2) + '%']
                    }
                },
                labels: [],
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
                                        return  tongso.toLocaleString()
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
        this.bindData(this.dulieu);
    },
    components: {
        apexchart: ApexCharts,
    },
    watch: {
        dulieu: function (newVal) {
            if (newVal) {
                this.bieuTongQuanNhaTruong.series = newVal;
                this.bieuTongQuanNhaTruong.labels = this.list_label;
                this.bieuTongQuanNhaTruong.colors = this.color;
                let element = this.$refs.bieudo;
                var bieuDo = new ApexCharts(element, this.bieuTongQuanNhaTruong);
                bieuDo.render();
                bieuDo.updateOptions([this.bieuTongQuanNhaTruong])
            }
        }
    },
    methods: {
        bindData(e) {
            this.bieuTongQuanNhaTruong.series = e;
            let element = this.$refs.bieudo;
            var bieuDo = new ApexCharts(element, this.bieuTongQuanNhaTruong);
            bieuDo.render();
            bieuDo.updateOptions([this.bieuTongQuanNhaTruong])
        },
    },
}

</script>
<style scoped="scoped">
.apexcharts-canvas {
    margin: 0 auto !important;
}

div#bieudobanh {
    margin: 0 auto;
    text-align: center;
    display: table;
}

</style>

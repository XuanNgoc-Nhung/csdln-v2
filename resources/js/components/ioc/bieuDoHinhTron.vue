<template>
    <div>
        <div class="bieudo" ref="bieudo" id="bieudobanh"></div>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'
    import Anychart from 'anychart'
    export default {
        props: ['dulieu','label'],
        data() {
            return {
                duLieuBieuDo: [],
                bieuTongQuanNhaTruong: {
                    series: [20, 30, 50],
                    chart: {
                        width: '99%',
                        type: 'donut',
                        zoom: {
                            enabled: true
                        },
                        animations: {
                            enabled: true
                        }
                    },
                    colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444', '#FAB4F4', '#AABBCC',
                        '#999900'
                    ],

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
                            // return [name, tong +'('+ val.toFixed(2) + '%'+')']
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
                                            return tongso.toLocaleString();
                                            // return tongso.toLocaleString() + ' Trường'
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
            this.bindData()
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {
            dulieu: function (newVal) {
                if (newVal) {
                    this.bieuTongQuanNhaTruong.labels = this.label;
                    this.bieuTongQuanNhaTruong.series = newVal;
                    let element = this.$refs.bieudo
                    var bieuDo = new ApexCharts(element, this.bieuTongQuanNhaTruong);
                    bieuDo.render();
                    bieuDo.updateOptions([this.bieuTongQuanNhaTruong])
                }
            }
        },
        methods: {
            bindData() {
                this.bieuTongQuanNhaTruong.labels = this.label;
                this.bieuTongQuanNhaTruong.series = [0];
                let element = this.$refs.bieudo
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
        width:100%;
        text-align: center;
        display: table;
    }

</style>

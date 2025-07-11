<template>
    <div>
        <div class="bieudo" id="hanhkiemhsthcs"></div>
    </div>
</template>
<style>
</style>
<script>

    import ApexCharts from 'apexcharts'
    export default {
        props: [],
        data() {
            return {
                duLieuBieuDo: [20,30,20,15],
                bieuTongQuanNhaTruong: {
                    series: [],
                    chart: {
                        width: '100%',
                        type: 'donut',
                        zoom: {
                            enabled: true
                        },
                        animations: {
                            enabled: true
                        }
                    },
                    colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444'],

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
                            return [name, val.toFixed(2) + '%']
                        },
                        style: {
                            fontSize: '12px',
                            fontWeight: 'bold',
                        },
                    },
                    labels: ['Tốt','Khá','Trung bình','Yếu'],
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
                                            return  tongso.toLocaleString() + ' HS'
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
        },
        methods: {
            bindData() {
                this.bieuTongQuanNhaTruong.series = this.duLieuBieuDo;
                this.ganDuLieuBieuDoTongQuanNhaTruong();
            },
            ganDuLieuBieuDoTongQuanNhaTruong() {
                var chartDuong = new ApexCharts(document.querySelector("#hanhkiemhsthcs"), this.bieuTongQuanNhaTruong);
                chartDuong.render();
            },
        },
    }

</script>
<style scoped="scoped">
    .apexcharts-canvas {
        margin: 0 auto !important;
    }

    div#hanhkiemhsthcs {
        margin: 0 auto;
        text-align: center;
        display: table;
    }

</style>

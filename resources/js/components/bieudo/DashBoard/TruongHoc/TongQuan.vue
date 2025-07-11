<template>
    <div>
        <div class="bieudo" id="bieudobanh"></div>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'
    import Anychart from 'anychart'
    export default {
        props: ['dulieu'],
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                duLieuBieuDo: [0, 0, 0, 0, 0, 0],
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
                    colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444', '#FAB4F4','#AABBCC','#999900'],

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
                    labels: ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên cấp'],
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
                                        fontSize: '10pt',
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
                                        fontSize: '10pt',
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
                                        fontSize: '10pt',
                                        fontFamily: 'Helvetica, Arial, sans-serif',
                                        fontWeight: 100,
                                        color: '#373d3f',
                                        formatter: function (w) {
                                            let tongso = w.globals.seriesTotals.reduce((a, b) => {
                                                return a + b
                                            }, 0)
                                            return  tongso.toLocaleString() + ' Trường'
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
            if(this.thongtin.ma_so==10){
                console.log("Lào cai")
                this.bieuTongQuanNhaTruong.labels = ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên Cấp 1-2','Liên cấp 2-3','Khác'];
            }
            else{
                console.log("Not Lào cai")
                this.bieuTongQuanNhaTruong.labels = ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX', 'Liên cấp'];
            }
            this.bindData(this.dulieu);
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {
            dulieu: function (newVal) {
                if (newVal) {
                    this.bieuTongQuanNhaTruong.series = newVal;
                    var bieuDo = new ApexCharts(document.querySelector("#bieudobanh"), this.bieuTongQuanNhaTruong);
                    bieuDo.render();
                    bieuDo.updateOptions([this.bieuTongQuanNhaTruong])
                }
            }
        },
        methods: {
            bindData(e) {
                    this.bieuTongQuanNhaTruong.series = e;
                    var bieuDo = new ApexCharts(document.querySelector("#bieudobanh"), this.bieuTongQuanNhaTruong);
                    bieuDo.render();
                    bieuDo.updateOptions([this.bieuTongQuanNhaTruong])
            },
            ganDuLieuBieuDoTongQuanNhaTruong() {
                var chartDuong = new ApexCharts(document.querySelector("#bieudobanh"), this.bieuTongQuanNhaTruong);
                chartDuong.render();
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

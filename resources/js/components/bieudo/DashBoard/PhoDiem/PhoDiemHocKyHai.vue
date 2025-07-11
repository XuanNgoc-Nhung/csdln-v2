<template>
    <div>
        <div style="width: 100%" class="bieudo" id="phodiemhockyhai"></div>
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
                bieuDoPhoDiemHocKyHai: {
                    series: [],
                    chart: {
                        width: '100%',
                        height: '330',
                        type: 'line',
                        zoom: {
                            enabled: true
                        },
                        toolbar: {
                            show: false
                        },
                        animations: {
                            enabled: true
                        },
                    },
                    // colors: ['#4F81BC', '#c0504e', '#9BBB58', '#23BFAA', '#8064A1', '#4AACC5', '#FFFF00', '#19070B','#00FF40'],
                    colors: ["#32C5A7", "#60BFFF","#F1C656", "#FF6767","#939AAE", "#B2B96A",'#00a65a', '#FFA200','#60BFFF', '#1ab394'],
                    legend: {
                        show: true,
                        position: 'top'
                    },
                    stroke: {
                        curve: 'smooth',
                    },
                    labels: ['0', '≤1', '≤2', '≤3', '≤4', '≤5', '≤6', '≤7', '≤8', '≤9', '≤10'],
                    yaxis: {
                        labels: {
                            formatter: function (val) {
                                return (val / 1000000).toFixed(0);
                            },
                        },
                        title: {
                            text: 'Số lượng',
                            style: {
                                color: undefined,
                                fontSize: '10pt',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 200,
                                cssClass: 'apexcharts-yaxis-title',
                            },
                        },
                        labels: {
                            formatter: function (val) {
                                return val.toLocaleString();
                            },
                        },
                    },     legend: {
                            position: "bottom",
                            horizontalAlign: "center"
                        },

                },

            }
        },
        mounted() {
            this.BindData(this.dulieu);
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {
            dulieu: function (newVal, oldVal) {
                if (newVal) {
                    this.bieuDoPhoDiemHocKyHai.series = newVal;
                    var bieuDo = new ApexCharts(document.querySelector("#phodiemhockyhai"), this
                        .bieuDoPhoDiemHocKyHai);
                    bieuDo.render();
                    bieuDo.updateOptions([this.bieuDoPhoDiemHocKyHai])
                }
            }
        },
        methods: {
            BindData(e) {
                this.bieuDoPhoDiemHocKyHai.series = e;
                var bieuDo = new ApexCharts(document.querySelector("#phodiemhockyhai"), this.bieuDoPhoDiemHocKyHai);
                bieuDo.render();
                bieuDo.updateOptions([this.bieuDoPhoDiemHocKyHai])
            },
            ganDuLieuBieuDoTongQuanNhaTruong() {
                var chartDuong = new ApexCharts(document.querySelector("#phodiemhockyhai"), this.bieuDoPhoDiemHocKyHai);
                chartDuong.render();
            },
        },
    }

</script>
<style scoped="scoped">
    .apexcharts-canvas {
        margin: 0 auto !important;
    }

    div#phodiemhockyhai {
        margin: 0 auto;
        text-align: center;
        display: table;
    }

</style>

<template>
    <div>
        <div style="width: 100%" class="bieudo" id="phodiemhockymot"></div>
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
                bieuDoPhoDiemHocKyMot: {
                    series: [],
                    chart: {
                        width: '100%', // Full width
                        height: '330', // Adjust as needed
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
                    colors: [
                        "#32C5A7", "#60BFFF", "#F1C656", "#FF6767", "#939AAE",
                        "#B2B96A", '#00a65a', '#FFA200', '#60BFFF', '#1ab394'
                    ],
                    legend: {
                        show: true,
                        position: 'bottom',
                        horizontalAlign: 'center'
                    },
                    stroke: {
                        curve: 'smooth',
                    },
                    labels: ['0', '≤1', '≤2', '≤3', '≤4', '≤5', '≤6', '≤7', '≤8', '≤9', '≤10'],
                    yaxis: {
                        labels: {
                            formatter: function (val) {
                                return val.toLocaleString();
                            },
                        },
                        title: {
                            text: 'Số lượng',
                            style: {
                                fontSize: '10pt',
                                fontFamily: 'Helvetica, Arial, sans-serif',
                                fontWeight: 100,
                            },
                        },
                    }
                }

            }
        },
        mounted() {
            this.BindData(this.data);
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {
            dulieu: function (newVal) {
                console.log("wahtch phổ điểm hk1");
                if (newVal) {
                    console.log(newVal);
                    this.bieuDoPhoDiemHocKyMot.series = newVal;
                    var bieuDo = new ApexCharts(document.querySelector("#phodiemhockymot"), this
                        .bieuDoPhoDiemHocKyMot);
                    bieuDo.render();
                    bieuDo.updateOptions([this.bieuDoPhoDiemHocKyMot])
                }
            }
        },
        methods: {
            BindData(e) {
                this.bieuDoPhoDiemHocKyMot.series = e;
                var bieuDo = new ApexCharts(document.querySelector("#phodiemhockymot"), this.bieuDoPhoDiemHocKyMot);
                bieuDo.render();
                bieuDo.updateOptions([this.bieuDoPhoDiemHocKyMot])
            },
            ganDuLieuBieuDoTongQuanNhaTruong() {
                var chartDuong = new ApexCharts(document.querySelector("#phodiemhockymot"), this.bieuDoPhoDiemHocKyMot);
                chartDuong.render();
            },
        },
    }

</script>
<style scoped="scoped">
    .apexcharts-canvas {
        margin: 0 auto !important;
    }

    div#phodiemhockymot {
        margin: 0 auto;
        text-align: center;
        display: table;
    }

</style>

<template>
    <div>
        <div style="width: 100%" class="bieudo phodiemhockyhai" ref="bieudo"></div>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'
    import Anychart from 'anychart'
    export default {
        props: ['dulieu', 'namHoc'],
        data() {
            return {
                bieuDoBienDongHocLucHocSinh: {
                    series: [],
                    chart: {
                        width: '100%',
                        height: '330',
                        type: 'line',
                        zoom: {
                            enabled: true
                        },
                        toolbar: {
                            show: false,
                            position: 'top'
                        },
                        animations: {
                            enabled: true
                        },
                        legend: {
                            position: 'top',
                        }
                    },
                    // colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800', '#F781F3', '#FFFF00', '#19070B',
                    //     '#00FF40'
                    // ],

                    colors: ["#32C5A7", "#60BFFF","#F1C656", "#FF6767","#939AAE", "#B2B96A",'#00a65a', '#FFA200','#60BFFF', '#1ab394'],
                    legend: {
                        show: true,
                        position: 'top'
                    },
                    stroke: {
                        curve: 'smooth',
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
                    

                    },
                    labels: [],    legend: {
                            position: "bottom",
                            horizontalAlign: "center"
                        },

                },

            }
        },
        mounted() {
            console.log("mounted biến động học lực:")
            this.BindData(this.dulieu);
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {
            dulieu: function (newVal, oldVal) {
                if (newVal) {
                    console.log("ahihi");
                    console.log(newVal);
                    console.log('gán dữ liệu:')
                    console.log(this.namHoc)
                    let labelChart = this.getConsecutiveNumbersBefore(this.namHoc, 5)
                    console.log(labelChart)
                    this.bieuDoBienDongHocLucHocSinh.labels = labelChart;
                    this.bieuDoBienDongHocLucHocSinh.series = newVal;

                    let element = this.$refs.bieudo;
                    var bieuDo = new ApexCharts(element, this
                        .bieuDoBienDongHocLucHocSinh);
                    bieuDo.render();
                    bieuDo.updateOptions([this.bieuDoBienDongHocLucHocSinh])
                }
            }
        },
        methods: {
            getConsecutiveNumbersBefore(A, n) {
                var numbers = [];
                for (var i = A; i > A - n; i--) {
                    numbers.push(i);
                }
                numbers.sort(function (a, b) {
                    return a - b;
                });
                return numbers;
            },
            BindData(e) {
                this.bieuDoBienDongHocLucHocSinh.series = e;
                let element = this.$refs.bieudo;
                var bieuDo = new ApexCharts(element, this
                    .bieuDoBienDongHocLucHocSinh);
                bieuDo.render();
                bieuDo.updateOptions([this.bieuDoBienDongHocLucHocSinh])
            },
            ganDuLieuBieuDoTongQuanNhaTruong() {
                var chartDuong = new ApexCharts(document.querySelector("#phodiemhockyhai"), this
                    .bieuDoBienDongHocLucHocSinh);
                chartDuong.render();
            },
        },
    }

</script>
<style scoped="scoped">
    .apexcharts-canvas {
        margin: 0 auto !important;
    }

    div.phodiemhockyhai {
        margin: 0 auto;
        text-align: center;
        display: table;
    }

</style>

<template>
    <div>
        <div class="bieudo" id="phodiemhockymot"></div>
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
                duLieuBieuDo: [

                    {
                        name: 'Toán học',
                        data: [5, 5, 10, 8, 7, 5, 4, 3, 4, 6, 13]
                    },
                    {
                        name: 'Ngữ văn',
                        data: [10, 15, 21, 12, 15, 10, 12, 15, 11, 15, 12]
                    },
                    {
                        name: 'Vật lí',
                        data: [2, 2, 4, 1, 3, 4, 1, 3, 4, 6, 10]
                    },
                    {
                        name: 'Hóa học',
                        data: [14, 23, 11, 12, 14, 16, 20, 12, 29, 16, 10]
                    },
                    {
                        name: 'Lịch sử',
                        data: [30, 20, 40, 10, 30, 14, 17, 30, 24, 46, 5]
                    },
                    {
                        name: 'Địa lý',
                        data: [12, 22, 14, 41, 13, 24, 41, 23, 14, 26, 50]
                    },
                    {
                        name: 'Sinh học',
                        data: [12, 25, 4, 11, 53, 24, 21, 36, 42, 63, 40]
                    },
                    {
                        name: 'Ngoại ngữ',
                        data: [21, 12, 42, 14, 35, 42, 21, 13, 44, 56, 20]
                    },
                    {
                        name: 'GDCD',
                        data: [12, 22, 34, 41, 53, 44, 11, 43, 14, 46, 30]
                    }

                ],
                bieuDoPhoDiemHocKyHai: {
                    series: [],
                    chart: {
                        width: '190%',
                        height: '280',
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
                    colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800', '#F781F3', '#FFFF00', '#19070B',
                        '#FF0000'
                    ],
                    stroke: {
                        curve: 'smooth',
                    },
                    labels: ['0', '≤1', '≤2', '≤3', '≤4', '≤5', '≤6', '≤7', '≤8', '≤9', '≤10'],

                },

            }
        },
        mounted() {
            this.BindData();
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {},
        methods: {
            BindData(e) {
                this.bieuDoPhoDiemHocKyHai.series = this.duLieuBieuDo;
                var bieuDo = new ApexCharts(document.querySelector("#phodiemhockymot"), this.bieuDoPhoDiemHocKyHai);
                bieuDo.render();
                bieuDo.updateOptions([this.bieuDoPhoDiemHocKyHai])
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

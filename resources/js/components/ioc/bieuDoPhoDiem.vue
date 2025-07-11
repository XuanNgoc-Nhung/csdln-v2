<template>
    <div>
        <div class="bieudo" ref="bieudo" style="width:100%"></div>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'
    export default {
        props: ['dulieu'],
        data() {
            return {
                duLieuPhoDiem: {
                    series: [{
                        name: '',
                        data: []
                    }],
                    chart: {
                        width: '100%',
                        height: '250',
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
                    colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800', '#F781F3', '#FFFF00', '#19070B',
                        '#00FF40'
                    ],
                    stroke: {
                        curve: 'smooth',
                    },
                    labels: ['0', '0-1', '1-2', '2-3', '3-4', '4-5', '5-6', '6-7', '7-8', '8-9', '9-10'],

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
                    noData: {
                        text: 'Biểu đồ chưa có dữ liệu thống kê',
                        align: 'center',
                        verticalAlign: 'middle',
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            color: '#F00',
                            fontSize: '14px',
                        }
                    }

                },

            }
        },
        mounted() {

            let element = this.$refs.bieudo
            var bieuDo = new ApexCharts(element, this.duLieuPhoDiem);
            bieuDo.render();
            bieuDo.updateOptions([this.duLieuPhoDiem])
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {
            dulieu: function (newVal) {
                console.log("wahtch phổ điểm hk1");
                if (newVal) {
                    console.log(newVal);
                    this.duLieuPhoDiem.series = newVal;
                    let element = this.$refs.bieudo
                    var bieuDo = new ApexCharts(element, this.duLieuPhoDiem);
                    bieuDo.render();
                    bieuDo.updateOptions([this.duLieuPhoDiem])
                }
            }
        },
        methods: {

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

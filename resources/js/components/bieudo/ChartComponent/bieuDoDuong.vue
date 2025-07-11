<template>
    <div ref="chuabieudo">
        <div id="phodiemhockymot"  class="bieudo scorllWidth" ref="bieudo"></div>
    </div>
</template>
<style>
</style>
<script>
import ApexCharts from 'apexcharts'
export default {
    props: ['dulieu','list_label'],
    data() {
        return {
            duLieuBieuDo: {
                series: [
                    {
                        "name": "Số lượng truy cập",
                        "data": [
                            500,
                            736,
                            398,
                            327,
                            724,
                            876,
                            215
                        ]
                    },
                ],
                chart: {
                    width: '190%',
                    height: '300',
                    type: 'line',
                    zoom: {
                        enabled: true
                    },
                    toolbar: {
                        show: true
                    },
                    animations: {
                        enabled: true
                    },
                },
                // colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800', '#F781F3', '#FFFF00', '#19070B', '#00FF40'],
                colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444','#00a65a', '#FFA200', '#60BFFF', '#90ED7D'],
                stroke: {
                    curve: 'smooth',
                },
                labels: [],

            },

        }
    },
    mounted() {
        this.getWidth();
        this.BindData(this.duLieuBieuDo.series);
    },
    components: {
        apexchart: ApexCharts,
    },
    watch: {
        dulieu: function (newVal) {
            console.log("wahtch phổ điểm hk1");
            if (newVal) {
                console.log(newVal);
                this.duLieuBieuDo.series = newVal;
                this.duLieuBieuDo.labels = this.list_label;
                let element = this.$refs.bieudo;
                var bieuDo = new ApexCharts(element, this.duLieuBieuDo);
                bieuDo.render();
                bieuDo.updateOptions([this.duLieuBieuDo])
            }
        }
    },
    methods: {
        getWidth(){
            this.duLieuBieuDo.chart.width = this.getWidthChart([1]);
        },
        getWidthChart(e){
            console.log("Set chiều rộng biểu đồ")
            let minWidth = this.$refs.chuabieudo.clientWidth;
            let Width = e.length * 50;
            if(Width>minWidth){
                return Width;
            }
            else{
                return minWidth;
            }
        },
        BindData(e) {
            console.log("Dữ liệu gán")
            console.log(this.list_label)
            if(this.list_label){
                this.duLieuBieuDo.labels = this.list_label;
            }
            else{
                this.duLieuBieuDo.labels = ['25/05/2022', '26/05/2022', '27/05/2022', '28/05/2022', '29/05/2022', '30/05/2022', '31/05/2022'];
            }
            console.log(this.duLieuBieuDo.labels)
            this.duLieuBieuDo.series = e;
            let element = this.$refs.bieudo;
            var bieuDo = new ApexCharts(element, this.duLieuBieuDo);
            bieuDo.render();
            bieuDo.updateOptions([this.duLieuBieuDo])
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

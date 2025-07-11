<template>
    <div>
        <div ref="chartContainer"></div>
    </div>
</template>
<script>
    export default {
        props: ['dulieu'],
        data() {
            return {
                dataPoints: []
            }
        },
        mounted() {
            this.bindData();
        },
        components: {},
        watch: {
            dulieu: function (newVal) {
                if (newVal) {
                    console.log('có dữ liệu biểu đồ thay đổi:')
                    this.bindData();
                }
            }
        },
        methods: {
            bindData() {
                // Thực hiện cập nhật lại dataPoints
                console.log('bindData')
                console.log(this.dulieu)
                let p = [];
                let sr = this.dulieu.series;
                let ct = this.dulieu.category;
                for (let i = 0; i < sr.length; i++) {
                    let obj = {
                        label: ct[i],
                        y: sr[i],
                    }
                    p.push(obj)
                }
                this.dataPoints = p;
                console.log(this.dataPoints)
                var total = this.dataPoints.reduce((sum, dataPoint) => sum + dataPoint.y, 0);

                var options = {
                    startAngle: 120,
                    creditText:'',
                    data: [{
                        type: "doughnut",
                        showInLegend: false,
                        toolTipContent: "{label}: <strong> {y} </strong>",
                        indexLabel: "{label} - {y}%",
                        dataPoints: this.dataPoints
                    }],
                    colorSet: ["#32C5A7", "#60BFFF","#F1C656", "#FF6767","#939AAE", "#B2B96A",'#00a65a', '#FFA200','#60BFFF', '#1ab394'],
                    subtitles: [{
                        text: total?total.toLocaleString():0, // Hiển thị tổng số lượng ở giữa biểu đồ
                        verticalAlign: "center",
                        fontSize: 16,
                        dockInsidePlotArea: true
                    }],
                };
                var chartContainer = this.$refs.chartContainer;
                chartContainer.style.width = "100%"; // Giảm kích thước chiều rộng container chứa biểu đồ
                chartContainer.style.height = "100%"; // Giảm kích thước chiều cao container chứa biểu đồ
                options.data[0].dataPoints.forEach(dataPoint => {
                    var percentage = dataPoint.y ? (dataPoint.y / total * 100).toFixed(2) : 0;
                    dataPoint.indexLabel = dataPoint.label + " - " + percentage + "%";
                });
                var chart = new CanvasJS.Chart(chartContainer, options);
                
                chart.render();
            },
        },
    }

</script>
<style scoped="scoped">
</style>

<template>
    <div>
        <div class="bieudo" ref="bieudo"></div>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'
    export default {
        props: ['item', 'name'],
        data() {
            return {
                duLieuBieuDo: [{
                    data: [21, 22, 10, 28, 16]
                }]
            }
        },
        mounted() {
            this.bindData();
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {
            item: function (newVal) {
                if (newVal) {
                    console.log("Thay đổi thông tin trong biểu đồ:")
                    console.log(newVal)
                    this.bindData();
                }
            },
        },
        methods: {
            bindData(e) {
                let series = this.duLieuBieuDo;
                let categories = ['Tiến sĩ', 'Thạc sĩ', 'Đại học', 'Cao đẳng', 'Trung cấp'];
                let element = this.$refs.bieudo
                this.generateChart(series, categories, element)
            },
            generateChart(series, categories, element) {
                let chart;
                const options = {
                    series,
                    colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444'],
                    chart: {
                        height: 350,
                        type: 'bar',
                        events: {
                            mounted: (chartContext, config) => {
                                console.log("mounted", chartContext, config, config.globals.yRange);
                                setTimeout(() => {
                                    addAnnotations(config);
                                });
                            },
                            updated: (chartContext, config) => {
                                setTimeout(() => {
                                    addAnnotations(config);
                                });
                            }
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '45%',
                            distributed: true,
                        }
                    },
                    xaxis: {
                        categories,
                        labels: {
                            style: {
                                colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444'],
                                fontSize: '12px'
                            }
                        }
                    },
                };
                const addAnnotations = (config) => {
                    var seriesTotals = config.globals.stackedSeriesTotals;
                    if (seriesTotals.length == 0) {
                        seriesTotals = [0, 0, 0, 0, 0]
                    }
                    const isHorizontal = options.plotOptions.bar.horizontal;
                    chart.clearAnnotations();
                    try {
                        categories.forEach((category, index) => {
                            chart.addPointAnnotation({
                                    y: isHorizontal ?
                                        calcHorizontalY(config, index) : seriesTotals[index],
                                    x: isHorizontal ? 0 : category,
                                    label: {
                                        text: `${seriesTotals[index].toLocaleString()}`,
                                    }
                                },
                                false
                            );
                            if (isHorizontal) {
                                adjustPointAnnotationXCoord(config, index);
                            }
                        });
                    } catch (error) {
                        console.log(`Add point annotation error: ${error.message}`);
                    }
                };
                const calcHorizontalY = (config, index) => {
                    const catLength = categories.length;
                    const yRange = config.globals.yRange[0];
                    const minY = config.globals.minY;
                    const halfBarHeight = yRange / catLength / 2;
                    return minY + halfBarHeight + 2 * halfBarHeight * (catLength - 1 - index);
                };
                const adjustPointAnnotationXCoord = (config, index) => {
                    const gridWidth = config.globals.gridWidth;
                    const seriesTotal = config.globals.stackedSeriesTotals[index];
                    const minY = Math.abs(config.globals.minY);
                    const yRange = config.globals.yRange[0];
                    const xOffset = (gridWidth * (seriesTotal + minY)) / yRange;
                    const chartId = config.globals.dom.baseEl.id;
                    const circle = document.querySelector(
                        `#${chartId} .apexcharts-point-annotations circle:nth-of-type(${index + 1})`
                    );
                    const labelField = document.querySelector(
                        `#${chartId} .apexcharts-point-annotations rect:nth-of-type(${index + 1}`
                    );
                    const labelFieldXCoord = parseFloat(labelField.getAttribute("x"));
                    const text = document.querySelector(
                        `#${chartId} .apexcharts-point-annotations text:nth-of-type(${index + 1}`
                    );
                    labelField.setAttribute("x", labelFieldXCoord + xOffset);
                    text.setAttribute("x", xOffset);
                    circle.setAttribute("cx", xOffset);
                };
                chart = new ApexCharts(element, options);
                chart.render();
                chart.updateOptions([options])
            }
        },
    }
</script>
<style scoped="scoped">
    .apexcharts-canvas {
        margin: 0 auto !important;
    }
    div#bieudochatluongdaotaonhatruong {
        margin: 0 auto;
        text-align: center;
        display: table;
    }
</style>

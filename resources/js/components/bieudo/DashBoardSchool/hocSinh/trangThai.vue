<template>
    <div>
        <div class="bieudo" id="trangthaihocsinh"></div>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'
    import Anychart from 'anychart'
    export default {
        props: ['dulieu','tuychon'],
        data() {
            return {
                duLieuBieuDo: [{
                            name: 'Nam',
                            data: [12, 30]
                        },
                        {
                            name: 'Nữ',
                            data: [30, 17]
                        },

                    ]
            }
        },
        mounted() {
            this.bindData();
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {

        },
        methods: {
            bindData(e) {
                let series = this.duLieuBieuDo;
                let categories = ['Đang học','Khác'];
                let element = document.querySelector("#trangthaihocsinh");
                this.generateChart(series, categories, element)
            },
            generateChart(series, categories, element) {
                let chart;
                const options = {
                    series,
                    colors: ['#4F81BC', '#c0504e', '#9BBB58', '#23BFAA', '#8064A1', '#4AACC5'],
                    chart: {
                        type: "bar",
                        width: '100%',
                        height: '300',
                        stacked: true,
                        toolbar: {
                            show: false
                        },
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
                    dataLabels: {
                        enabled: false,
                        formatter: function (val, opts) {
                            return val.toLocaleString();
                        },
                        style: {
                            fontSize: '12px',
                            fontWeight: 'bold',
                        },
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '50%',
                            horizontal: false,
                            dataLabels: {
                                maxItems: 2
                            }
                        }
                    },
                    xaxis: {
                        categories,
                        axisTicks: {
                            show: true
                        },
                        axisBorder: {
                            show: true
                        },
                        labels: {
                            hideOverlappingLabels: false,
                        }
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
                        }
                    },
                    fill: {
                        opacity: 1
                    },
                    legend: {
                        position: "top",
                        horizontalAlign: "center"
                    },
                    grid: {
                        padding: {
                            left: 13.5,
                            right: 0
                        },
                        xaxis: {
                            lines: {
                                show: false
                            }
                        },
                    }
                };
                const addAnnotations = (config) => {
                    var seriesTotals = config.globals.stackedSeriesTotals;
                    if (seriesTotals.length == 0) {
                        seriesTotals = [0, 0, 0]
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

</style>

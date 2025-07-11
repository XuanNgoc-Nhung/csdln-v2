<template>
    <div ref="chuabieudo">
        <div class="bieudo scorllWidth" ref="bieudo"></div>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'
    export default {
        props: ['dulieu'],
        data() {
            return {}
        },
        mounted() {
            this.bindData();
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {

            dulieu: function (newVal) {
                if (newVal) {
                    let data_demo = newVal;
                    this.bindData(data_demo)
                }
            },
        },
        methods: {
            getWidthChart(e) {
                return '100%';
                let minWidth = this.$refs.chuabieudo.clientWidth;
                let Width = e.length * 50;
                if (Width > minWidth) {
                    return Width;
                } else {
                    return minWidth;
                }
            },
            bindData(e) {
                let element = this.$refs.bieudo;
                let series = this.dulieu.series;
                let categories = this.dulieu.category;
                this.generateChart(series, categories, element)
            },
            generateChart(series, categories, element) {
                let chart;
                const options = {
                    series,
                    // colors: ['#4F81BC', '#c0504e', '#9BBB58', '#23BFAA', '#8064A1', '#4AACC5'],
                    // colors: ['#969AFB', '#FFA200', '#60BFFF', '#1ab394', '#014839', '#FB4444', '#00a65a', '#FFA200',
                    //     '#60BFFF', '#1ab394'
                    // ],
                    colors : ["#32C5A7", "#60BFFF","#F1C656", "#FF6767","#939AAE", "#B2B96A",'#00a65a', '#FFA200','#60BFFF', '#1ab394'],
                    chart: {
                        type: "bar",
                        width: this.getWidthChart(categories),
                        height: '280',
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
                        enabled: true,
                        formatter: function (val, opts) {
                            return val.toLocaleString();
                        },
                        style: {
                            fontSize: '12px',
                            // fontWeight: 'bold',
                            fontWeight: 'normal', 
                            colors: ['#1D1D1D']
                        },
                    },
                    noData: {
                        text: "Biểu đồ chưa có dữ liệu",
                        align: 'center',
                        verticalAlign: 'middle',
                        offsetX: 0,
                        offsetY: 0,
                        style: {
                            color: undefined,
                            fontSize: '14px',
                            fontFamily: undefined
                        }
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '60%',
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
                    fill: {
                        opacity: 1
                    },
                    legend: {
                        position: "bottom",
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
                                        style: {
                                            color: '#1D1D1D',
                                            fontSize: '13px',
                                            fontWeight: 'bold',
                                        }
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

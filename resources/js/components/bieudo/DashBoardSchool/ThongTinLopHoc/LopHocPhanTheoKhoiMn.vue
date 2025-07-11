<template>
    <div>

        <el-col :md="12" :lg="8">
            <div class="dts-moibieudo grid-content bg-purple-light">
                <div class="dts-card-header">
                    <span class="dts-card-title">Lớp học mầm non {{name}}</span>
                </div>
                <div class="dts-card-body" v-loading="false" element-loading-background="rgba(0, 0, 0, 0.8)">
                    <div>
                        <div class="bieudo" ref='bieudo'></div>
                    </div>
                </div>
            </div>
        </el-col>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'
    import Anychart from 'anychart'
    export default {
        props: ['item', 'name'],
        data() {
            return {
                dulieuBieuDo: [{
                    name: 'Lớp',
                    data: [10, 11, 12, 13, 14]
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
            bindData() {
                let series = [{
                    name: "Số lượng",
                    data: this.item
                }];
                let categories = ['3-12 tháng', '13-24 tháng', '25-36 tháng', '3-4 tuổi', '4-5 tuổi', '5-6 tuổi'];
                let element = this.$refs.bieudo;
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
                        stackType: 'nomal',
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
                        show:false,
                        enabled: false,
                        formatter: function (val, opts) {
                            return "";
                        },
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '50',
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
                            show: true,
                            rotate: 0,
                            rotateAlways: false,
                            hideOverlappingLabels: false,
                            showDuplicates: false,
                            trim: true,
                            style: {
                                colors: [],
                                fontSize: '10px',
                                fontWeight: 400,
                            },
                            offsetY: -5,
                        },
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
                        seriesTotals = [0, 0, 0,0,0,0]
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

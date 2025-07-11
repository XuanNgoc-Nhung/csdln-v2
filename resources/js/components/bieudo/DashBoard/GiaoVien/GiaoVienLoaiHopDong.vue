<template>
    <div>
        <div class="bieudo" id="loaihopdonggiaovien"></div>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'
    import Anychart from 'anychart'
    export default {
        props: ['dulieu', 'tuychon'],
        data() {
            return {}
        },
        mounted() {
            this.bindData(this.dulieu);
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {
            dulieu: function (newVal) {
                if (newVal) {
                    let data_demo = newVal;
                    for (let i = 0; i < data_demo.length; i++) {
                        data_demo[i].name = this.getTenCapHoc(data_demo[i].name);
                    }
                    this.bindData(data_demo)
                }
            },

            tuychon: function (newVal) {
                this.hienThiGiaTriMoiO = newVal;
                let data_demo = this.dulieu;
                for (let i = 0; i < data_demo.length; i++) {
                    data_demo[i].name = this.getTenCapHoc(data_demo[i].name);
                }
                this.bindData(data_demo)
            }
        },
        methods: {
            getTenCapHoc(e) {
                var res = e;
                switch (res) {
                    case 'MN':
                        res = 'Mầm non';
                        break;
                    case 'TH':
                        res = 'Tiểu học';
                        break;
                    case 'THCS':
                        res = 'THCS';
                        break;
                    case 'THPT':
                        res = 'THPT';
                        break;
                    case 'GDTX':
                        res = 'GDTX';
                        break;
                    case 'LC':
                        res = 'Liên cấp';
                        break;
                    default:
                        res = e;
                }
                return res;
            },
            bindData(e) {
                let series = e;
                let hienthitungo = this.hienThiGiaTriMoiO;
                let categories = ['HĐ KXĐ thời gian', 'HĐ XĐ thời gian', 'HĐLĐ'];
                let element = document.querySelector("#loaihopdonggiaovien");
                this.generateChart(series, categories, element, hienthitungo)
            },
            generateChart(series, categories, element, hienthitungo) {
                let chart;
                const options = {
                    series,
                    // colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444'],

                    colors: ["#32C5A7", "#60BFFF","#F1C656", "#FF6767","#939AAE", "#B2B96A",'#00a65a', '#FFA200','#60BFFF', '#1ab394'],
                    chart: {
                        type: "bar",
                        width: '100%',
                        height: '300',
                        stacked: 'true',
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
                        enabled: hienthitungo,
                        formatter: function (val, opts) {
                            return val.toLocaleString();
                        },
                        style: {
                            fontSize: '10pt',
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

    div#bieudochatluongdaotaonhatruong {
        margin: 0 auto;
        text-align: center;
        display: table;
    }

</style>

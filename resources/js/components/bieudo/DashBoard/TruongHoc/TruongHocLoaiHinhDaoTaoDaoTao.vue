<template>
    <div>
        <div class="bieudo" id="loaihinhdaotaotruonghoc"></div>
    </div>
</template>
<style>
</style>
<script>
    import ApexCharts from 'apexcharts'
    import Anychart from 'anychart'
    export default {
        props: ['dulieu', 'tuychon', 'phantram'],
        data() {
            return {
                hienThiGiaTriMoiO: false,
            }
        },
        mounted() {
            this.bindData(this.dulieu);
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {

            dulieu: function (newVal) {
                console.log("hớ hớ hí hí ha ha he he");
                if (newVal) {
                    let data_demo = newVal;
                    for (let i = 0; i < data_demo.length; i++) {
                        data_demo[i].name = this.getTenCapHoc(data_demo[i].name);
                    }
                    console.log("Dữ liệu ")
                    console.table(data_demo);
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
            },

            phantram: function (newVal) {
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
                    case 'PTCS':
                        res = 'PTCS';
                        break
                    case 'TRUNGHOC':
                        res = 'Trung học';
                        break;
                    case 'LC145':
                        res = 'MN-TH';
                        break;
                    case 'LC12':
                        res = 'Liên cấp 1-2';
                        break
                    case 'LC23':
                        res = 'Liên cấp 2-3';
                        break;
                    case 'LCK':
                        res = 'Khác';
                        break;
                    default:
                        res = e;
                }
                return res;
            },
            bindData(e) {
                let series = e;
                let hienthitungo = this.hienThiGiaTriMoiO;
                let stackedType = 'normal';
                if (this.phantram) {
                    stackedType = '100%';
                } else {
                    stackedType = 'normal';
                }
                console.log(stackedType);
                console.log("stackedType");
                let categories = ['Công lập', 'Tư thục', 'Dân lập'];
                let element = document.querySelector("#loaihinhdaotaotruonghoc");
                this.generateChart(series, categories, element, hienthitungo, stackedType)
            },
            generateChart(series, categories, element, hienthitungo, stackedType) {
                let chart;
                const options = {
                    series,
                    // colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444','#FAB4F4','#999900','#AABBCC'],
                    colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444', '#00a65a', '#FFA200',
                        '#60BFFF', '#90ED7D'
                    ],
                    chart: {
                        type: "bar",
                        width: '100%',
                        height: '300',
                        stacked: true,
                        stackType: stackedType,
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
                            if (stackedType == '100%') {
                                return val.toFixed(2) + '%';
                            } else {
                                return val.toLocaleString();
                            }
                        },
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '50%',
                            horizontal: false,
                            dataLabels: {
                                maxItems: 0,
                                hideOverflowingLabels: false
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
                        if (stackedType == 'normal') {

                            categories.forEach((category, index) => {
                                chart.addPointAnnotation({
                                        y: isHorizontal ?
                                            calcHorizontalY(config, index) : seriesTotals[index],
                                        x: isHorizontal ? 0 : category,
                                        label: {
                                            // text: `${seriesTotals[index].toLocaleString()}`,
                                            text: `${stackedType == 'normal' ? seriesTotals[index].toLocaleString() : ''}`
                                        }
                                    },
                                    false
                                );

                                if (isHorizontal) {
                                    adjustPointAnnotationXCoord(config, index);
                                }
                            });
                        }
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

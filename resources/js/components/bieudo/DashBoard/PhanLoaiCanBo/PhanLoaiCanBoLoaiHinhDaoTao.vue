<template>
    <div>
        <div class="bieudo" id="phanloaicanbotheoloaihinh"></div>
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
            this.bindData();
        },
        components: {
            apexchart: ApexCharts,
        },
        watch: {
            dulieu: function (newVal) {
                if (newVal) {
                    let data_demo = newVal;
                    console.log(data_demo);
                    console.log("*****");
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
                    case 'NV':
                        res = 'Nhân viên';
                        break;
                    case 'QL':
                        res = 'Cán bộ quản lý';
                        break;
                    case 'GV':
                        res = 'Giáo viên';
                        break;
                    default:
                        res = e;
                }
                return res;
            },
            bindData(e) {
                let hienthitungo = this.hienThiGiaTriMoiO;
                let series = e;
                let categories = ['Công lập', 'Tư thục', 'Dân lập'];
                let element = document.querySelector("#phanloaicanbotheoloaihinh");
                this.generateChart(series, categories, element, hienthitungo)
            },
            generateChart(series, categories, element, hienthitungo) {
                let chart;
                const options = {
                    series,
                    // colors: ['#4F81BC', '#c0504e', '#9BBB58', '#23BFAA', '#8064A1', '#4AACC5'],
                    // colors: ['#969AFB', '#FFA200', '#60BFFF', '#90ED7D', '#014839', '#FB4444', '#00a65a', '#FFA200',
                    //     '#60BFFF', '#90ED7D'
                    // ],
                    colors : ["#32C5A7", "#60BFFF","#F1C656", "#FF6767","#939AAE", "#B2B96A",'#00a65a', '#FFA200','#60BFFF', '#1ab394'],
                    chart: {
                        type: "bar",
                        width: '100%',
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
                            formatter: function (val) {
                                return val.toLocaleString();
                            },
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
                                        style: {color: '#1D1D1D'}
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

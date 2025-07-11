<template>
    <div class="chart-container">
        <v-chart class="chart" :option="option" ref="chart" autoresize />
    </div>
</template>

<script>
    import {
        use
    } from 'echarts/core';
    import {
        CanvasRenderer
    } from 'echarts/renderers';
    import {
        PieChart
    } from 'echarts/charts';
    import {
        TitleComponent,
        TooltipComponent,
        LegendComponent,
    } from 'echarts/components';
    import VChart, {
        THEME_KEY
    } from 'vue-echarts';
    import {
        ref,
        defineComponent
    } from 'vue';

    use([
        CanvasRenderer,
        PieChart,
        TitleComponent,
        TooltipComponent,
        LegendComponent,
    ]);

    export default {
        props: ['dulieu'],
        name: 'HelloWorld',
        components: {
            VChart,
        },
        watch: {
            dulieu: function (newVal) {
                if (newVal) {
                    // console.log('có dữ liệu biểu đồ thay đổi:')
                    this.bindData();
                }
            }
        },
        provide: {
            [THEME_KEY]: 'light',
        },
        mounted() {
            console.log('mount biểu đồ tròn:');
            // this.fetchData(); // Gọi fetchData() một lần khi component được hiển thị
        },

        data() {
            return {
                chartInstance: null,
                option: {
                    tooltip: {
                        trigger: 'item',
                        formatter: '{a} <br/>{b} : {c} ({d}%)',
                        show: false,
                    },
                    legend: {
                        orient: 'vertical',
                        left: 'left',
                        show: false,
                    },
                    title: {
                        text: `0`,
                        textStyle: {
                            fontSize: 16,
                            fontWeight: 'bold',
                            color: '#333',
                        },
                        left: 'center',
                        top: '32%',
                    },
                    series: [{
                        name: '',
                        type: 'pie',
                        radius: ['24%', '55%'],
                        center: ['50%', '35%'],
                        stillShowZeroSum: true,
                        avoidLabelOverlap: true,
                        data: [],
                        label: {
                            show: true,
                            // formatter: '{b}: {c} ({d}%)',
                            formatter: function (params) {
                                return `${params.name}: ${params.data.value.toLocaleString()} (${params.percent}%)`;
                            },
                        },

                        labelLine: {
                            show: true,
                        },
                        emphasis: {
                            label: {
                                show: true,
                                fontSize: 14,
                                formatter: function (params) {
                                    return `${params.name}: ${params.data.value.toLocaleString()} (${params.percent}%)`;
                                },
                            }
                        },
                        itemStyle: {
                            color: function (params) {
                                // Thay đổi màu của các thành phần dựa trên index
                                // const colors = ['#969AFB', '#FFA200', '#60BFFF', '#1ab394', '#014839',
                                //     '#FB4444', '#00a65a', '#FFA200', '#60BFFF', '#90ED7D'
                                // ];
                                // const colors = ["#A0A4FD", "#F9B846","#60BFFF", "#32C5A7","#B3B96A", "#FF6767",'#00a65a', '#FFA200','#60BFFF', '#1ab394']
                                const colors = ["#32C5A7", "#60BFFF","#F1C656", "#FF6767","#939AAE", "#B2B96A",'#00a65a', '#FFA200','#60BFFF', '#1ab394']
                                return colors[params.dataIndex % colors.length];
                            },
                            borderRadius: 4,
                            borderColor: '#fff',
                            borderWidth: 1,
                        },
                    }, ],
                },
            }
        },
        methods: {
            bindData() {
                console.log('bindData')
                console.log(this.dulieu)
                if (this.dulieu) {
                    let p = [];
                    let sr = this.dulieu.series;
                    let ct = this.dulieu.category;
                    for (let i = 0; i < sr.length; i++) {
                        let obj = {
                            name: ct[i],
                            value: sr[i],
                        }
                        p.push(obj)
                    }
                    console.log(p);
                    this.option.series[0].data = p;
                    this.option.title.text = this.tinhTongMang(sr)
                } else {
                    this.option.series[0].data = [];
                }
            },
            initializeChart() {
                const ctx = this.$refs.chart.getContext('2d');
                this.chartInstance = new Line(ctx, {
                    data: {
                        labels: [], // Các nhãn trục x (thời gian)
                        datasets: [{
                            label: 'Data',
                            data: [], // Dữ liệu biểu đồ
                            borderColor: 'blue',
                            backgroundColor: 'transparent',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                });
            },
            fetchData() {
                const newData = this.generateRandomData(); // Generate random data for demonstration
                this.option.series[0].data = newData;
            },
            tinhTongMang(arr) {
                let total = arr.reduce((sum, num) => sum + num, 0);
                return total.toLocaleString()
            },
            generateRandomData() {
                const data = [];
                for (let i = 0; i < 5; i++) {
                    const label = `Label ${i + 1}`;
                    const value = Math.floor(Math.random() * 100);
                    let obj = {
                        value: value,
                        name: label
                    }
                    data.push(obj);
                }
                return data;
            }
        }
    };

</script>

<style scoped>
    .chart-container {
        position: relative;
        width: 100%;
        height: 400px;
    }

    .chart-overlay {
        position: absolute;
        top: 36%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 24px;
        font-weight: bold;
        z-index: 99;
    }

    .chart {
        width: 100%;
        height: 100%;
    }

    .chart-overlay {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 24px;
        font-weight: bold;
    }

</style>

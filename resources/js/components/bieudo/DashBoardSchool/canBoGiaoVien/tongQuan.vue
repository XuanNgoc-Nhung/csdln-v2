<template>
    <div>
        <el-col :md="12" :lg="8">
            <div class="dts-moibieudo grid-content bg-purple-light">
                <div class="dts-card-header">
                    <span class="dts-card-title">Tổng quan {{name}}<span style="color:blue; text-transform:none">(Đang
                            làm việc: {{danglamviec?danglamviec:0}}<span> / Tổng số: {{tinhTong(item?item:[])}}</span>)</span></span>
                </div>
                <div class="dts-card-body" v-loading="false" element-loading-background="rgba(0, 0, 0, 0.8)">
                    <div>
                        <BieuDoTron :dulieu="duLieuBieuDo" />
                    </div>
                </div>
            </div>
        </el-col>
    </div>
</template>
<script>
    import BieuDoTron from './../../ChartComponent2/bieuDoTronCustom'
    export default {
        props: ['item', 'name', 'danglamviec'],
        data() {
            return {
                duLieuBieuDo: {}
            }
        },
        mounted() {},
        components: {
            BieuDoTron
        },
        watch: {
            item: function (newVal) {
                if (newVal) {
                    console.log("Thay đổi thông tin trong biểu đồ:")
                    console.log(newVal)
                    this.mapBieuDoTongQuanCanBo()
                }
            },
        },
        methods: {
            tinhTong(arr) {
                let sum = 0;
                for (let i = 0; i < arr.length; i++) {
                    sum += arr[i];
                }
                return sum;
            },
            mapBieuDoTongQuanCanBo() {
                let obj = {
                    "category": ['CBQL', 'GV', 'NV'],
                    "series": this.item ? this.item : [0, 0, 0],
                    "totalText": ""
                }
                this.duLieuBieuDo = obj;
            },
        },
    }

</script>
<style scoped="scoped">
    .apexcharts-canvas {
        margin: 0 auto !important;
    }

    div#tongquancanbogiaovien {
        margin: 0 auto;
        text-align: center;
        display: table;
    }

</style>

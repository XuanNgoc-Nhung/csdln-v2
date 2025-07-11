<template>
    <div>
      
        <Breadcrumb :menu="'Báo cáo'" :desc="'Báo cáo động'"/>
        <el-tabs type="border-card2">
            <el-tab-pane>
                <span slot="label">1. BÁO CÁO CÁN BỘ</span>
                <canbo :infologin="info"></canbo>
            </el-tab-pane>
            <el-tab-pane label="Config">
                <span slot="label">2. BÁO CÁO HỌC SINH</span>
                <hocsinh :infologin="info"></hocsinh>
            </el-tab-pane>
            <el-tab-pane label="Role">
                <span slot="label">3. BÁO CÁO TRƯỜNG HỌC</span>
                <truonghoc :infologin="info"></truonghoc>
            </el-tab-pane>
        </el-tabs>
    </div>

</template>
<script>
    import Vue from "vue";
    import VueAlertify from "vue-alertify";
    Vue.use(VueAlertify);
    import VueApexCharts from 'vue-apexcharts'
    Vue.component('apexchart', VueApexCharts);
    import BaoCaoCanBo from "./BaoCaoEmis/BaoCaoCanBo";
    Vue.component('canbo', BaoCaoCanBo);
    import BaoCaoHocSinh from "./BaoCaoEmis/BaoCaoHocSinh";
    Vue.component('hocsinh', BaoCaoHocSinh);
    import BaoCaoTruongHoc from "./BaoCaoEmis/BaoCaoTruongHoc";
    import Breadcrumb from "../ui/Breadcrumb.vue";
    Vue.component('truonghoc', BaoCaoTruongHoc);

    export default {
        props: ["info"],
        components : {Breadcrumb},
        data() {
            return {
                "thongtin": ""
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(this.info);

        },
        methods: {

        }
    };

</script>
<style scoped="scoped">

    a,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6,
    label,
    p,
    span {
        margin: 0;
        padding: 0;
    }

    .red {
        color: #DC0101;
        padding: 0 2px;
    }

    .inputieuchi {
        height: 20px;
        background: #ccc5c5;
        padding: 4px 10px;
        color: black;
        transition: background-color 3s linear;
    }

    .chon {
        height: 24px;
    }

    .locnangcao {
        padding: 5px;
        display: inline-flex;
    }

    .thongtinbosung {
        height: 34px;
        vertical-align: middle;
        align-items: center;
        display: flex;
    }

    .kichhoat {
        background: #64FE2E;
        transition: background-color 3s linear;
        color: black;
        margin-top: 1px;
        border-radius: 4px;
    }

    .thieutieuchi {
        /* background: #64FE2E; */
        border: 2px solid red;
    }

    .e-multiselect .e-multi-select-wrapper.e-down-icon,
    .e-multiselect.e-checkbox .e-multi-select-wrapper {
        border: 1px solid black;
    }

    .form-control {
        padding: 0 !important;
        height: 30px;
    }

</style>

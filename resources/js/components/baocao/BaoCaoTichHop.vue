<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> BÁO CÁO <span class="kytu">
                        &raquo;</span> BÁO CÁO TÍCH HỢP</span>
            </div>
        </div>
        <div class="row" style="">
            <div class="card-bieu-do">
                <form role="form">
                    <el-row :gutter="24">
                        <el-col :span="8">
                            <label>Chọn loại báo cáo</label>
                            <eselect style="width:100%" @change="chonLoaiBaocao()" v-model="loai_bao_cao"
                                     :placeholder="'Chọn báo cáo'" filterable :data="list_bao_cao" :fields="['name','value']"/>
                        </el-col>

                    </el-row>
                    <component
                            :show="showDetail"
                            @close="showDetail=false"
                            :is="current_view">
                    </component>
                </form>
            </div>

        </div>

    </div>
</template>

<script>
    import QueryBuilder from "query-builder-vue";
    import ESelectVue from '../ui/ESelect.vue';
    import rest_api from "../../utils/rest_api";
    import dialog from '../../utils/dialog';
    import Page from "../ui/PagingCustom";
    import ThongKeCBGVDiHoc from "./BaoCaoTichHop/ThongKeCBGVDiHoc";
    import ThongKeChuanNghe from "./BaoCaoTichHop/ThongKeChuanNghe";
    import ThongKeTaiKhoan from "./BaoCaoTichHop/ThongKeTaiKhoan";
    import ThongKeTruyCap from "./BaoCaoTichHop/ThongKeTruyCap";
    import ThongKeHocLieu from "./BaoCaoTichHop/ThongKeHocLieu";
    import ThongKeTuDanhGia from "./BaoCaoTichHop/ThongKeTuDanhGia";
    import ThongKeDanhGiaNgoai from "./BaoCaoTichHop/ThongKeDanhGiaNgoai";

    export default {
        components: {
            QueryBuilder,
            Page,
            'eselect': ESelectVue,
            ThongKeCBGVDiHoc,
            ThongKeChuanNghe,
            ThongKeTaiKhoan,
            ThongKeTruyCap,
            ThongKeHocLieu,
            ThongKeTuDanhGia,
            ThongKeDanhGiaNgoai
        },
        data() {
            return {
                loai_bao_cao : '',
                current_view: "",
                showDetail: false,
                list_bao_cao : [
                    {
                        name: 'Mẫu 1: Thống kê tài khoản',
                        value: 'ThongKeTaiKhoan'
                    },
                    {
                        name: 'Mẫu 2: Thống kê truy cập',
                        value: 'ThongKeTruyCap'
                    },
                    {
                        name: 'Mẫu 3: Thống kê học liệu',
                        value: 'ThongKeHocLieu'
                    },
                    {
                        name: 'Mẫu 4: Thống kê kết quả tự đánh giá các đơn vị',
                        value: 'ThongKeTuDanhGia'
                    },
                    {
                        name: 'Mẫu 5: Thống kê kết quả đánh giá ngoài các đơn vị',
                        value: 'ThongKeDanhGiaNgoai'
                    },
                    {
                        name: 'Mẫu 7: Thống kê giáo viên, cán bộ đi học',
                        value: 'ThongKeCBGVDiHoc'
                    },
                    {
                        name: 'Mẫu 8: Thống kê đánh giá chuẩn nghề nghiệp',
                        value: 'ThongKeChuanNghe'
                    },
                ]
            };
        },
        mounted: function () {
            let demo = [];

        },
        methods: {
            chonLoaiBaocao() {

                console.log("chọn loại báo cáo");
                console.log(this.loai_bao_cao);
                this.showDetail = true;
                this.current_view = this.loai_bao_cao;
            }
        },
    };

</script>

<style>

</style>

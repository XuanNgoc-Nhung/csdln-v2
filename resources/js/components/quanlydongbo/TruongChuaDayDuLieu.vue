<template>
    <div>
        <div class="row" style="">
            <div class="col-lg-12">
                <div class="panel panel-default" style="border-top:none; margin-top:0">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="text-uppercase">Danh sách yêu cầu</label>
                            </div>
                        </div>
                        <hr style="margin: 5px 0;"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table
                                        class="table table-bordered table-striped table-hover"
                                       >
                                        <thead>
                                            <tr style="background: #e4ebf5">
                                                <th class="text-center">
                                                    <p>STT</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Đơn vị</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tên trường học</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Mã trường học</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Năm học</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="ds_truong_chua_day.length==0">
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <p>Không có dữ liệu</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else="v-else" class="bodytable">
                                            <tr v-for="(item,i) in ds_truong_chua_day">
                                                <td class="text-center">{{i+1}}</td>
                                                <td>
                                                    <p>{{item.tenDonVi}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.tenTruongHoc}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.maTruongHoc}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.namHoc}}-{{item.namHoc+1}}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Page from '../ui/PagingCustom';
    import VueAlertify from "vue-alertify";
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {
        components: {
            "Page": Page
        },
        watch: {
            item: function (newVal) {
                console.log("thông tin trường chưa đẩy dữ liệu abc");
                this.bindData(newVal);
            }
        },
        data() {
            return {ds_truong_chua_day: [], total_rows: 0, currentPage: 1, limit: 25}
        },
        props: ['item'],
        mounted() {
            // console.log("thông tin trường chưa đẩy");
        },
        methods: {
            layLai(e) {
                console.log("lấy lại danh sách");
                console.log(e);
                this.currentPage = e.currentPage
                this.limit = e
                    .limit
                    this
                    .$emit("pageChange", e);
            },
            bindData(e) {
                console.log("ghép dữ liệu");
                console.log(e);
                this.ds_truong_chua_day = [],
                this.total_rows = 0;
                if (e.tableData) {
                    this.ds_truong_chua_day = e.tableData;
                }
                this.total_rows = e.totalRows;
                this.currentPage = e.totalRows;
            }
        }
    }
</script>
<style scoped="scoped"></style>

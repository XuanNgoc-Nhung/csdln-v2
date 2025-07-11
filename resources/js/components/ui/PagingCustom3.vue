<template>
    <el-row :gutter="20" v-if="total_rows>0" style="">
        <el-col :span="6">
            <div class="inline pull-left">
                <p>Hiển thị:</p>
                <select v-model="pagination.limit" @change="onSizeChange" class="form-control" style="width:75px;">
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                    <option value="500">500</option>
                </select>
                <p>dòng/trang.</p>
            </div>
        </el-col>
        <el-col :span="8">
            <div class="vanban">
                <p><i>Hiển thị từ <span style="color:#478fca">{{start}} - {{to}}</span> /Tổng số
                        <b>{{formatNumber(total_rows)}}</b> bản ghi</i></p>
            </div>
        </el-col>
        <el-col :span="10">
            <b-pagination class="pull-right" style="margin:0;float:right" :first-text="pagination.first_text" :limit="9"
                :last-text="pagination.last_text" :total-rows="total_rows" :prev-text="pagination.next_text"
                :next-text="pagination.prev_text" v-model="currentPage" @input="chonTrang" :per-page="pagination.limit">
            </b-pagination>

        </el-col>
    </el-row>
</template>

<script>
    import {
        PaginationPlugin
    } from 'bootstrap-vue';
    import number_util from '../../utils/number_utils';

    Vue.use(PaginationPlugin);

    export default {

        props: [
            'batdau',
            'total_rows',
            'sobanghitrentrang',
        ],
        watch: {
            batdau() {
                console.log("Đưa về trang 1");
                this.currentPage = 1;
                this.start = 0;
                this.onPageChange();
            },

            sobanghitrentrang(newVal) {
                if (newVal) {
                    this.pagination.limit = this.sobanghitrentrang
                }
            },
            total_rows: function (newVal, oldVal) {
                this.rebuild();
            },
        },

        data() {
            return {
                currentPage: 1,
                pagination: {
                    "next_text": "«",
                    "prev_text": "»",
                    "per_page": 10,
                    "first_text": "Đầu",
                    "last_text": "Cuối",
                    "limit": 25,
                },
                start: 0,
                to: 25
            }
        },

        mounted() {
            //this.rebuild();
        },

        methods: {
            chonTrang() {
                console.log("Chọn trang");
                this.onPageChange();

            },

            formatNumber(num) {
                return number_util.formatNumberEx(num);
            },

            onPageChange() {
                console.log("page=" + this.currentPage);
                let ret = {
                    start: (this.currentPage - 1) * this.pagination.limit,
                    limit: this.pagination.limit,
                    currentPage: this.currentPage,
                };
                this.rebuild();
                console.log("ret = " + JSON.stringify(ret));
                this.$emit("pageChange", ret);
            },

            onSizeChange() {
                this.currentPage = 1;
                let ret = {
                    start: 0,
                    limit: this.pagination.limit,
                    currentPage: this.currentPage,

                };
                this.rebuild();
                console.log("ret = " + JSON.stringify(ret));
                console.log("lấy lại:");
                this.$emit("pageChange", ret);
            },

            rebuild() {
                this.start = (this.currentPage - 1) * this.pagination.limit + 1;
                this.to = (this.currentPage) * this.pagination.limit;
                console.log("curent paage: " + this.currentPage);
                console.log("s = " + this.start + ", to = " + this.to);
                console.log('total row : ' + this.total_rows);
                if (this.currentPage * this.pagination.limit <= this.total_rows) {
                    this.to = this.currentPage * this.pagination.limit;
                } else {
                    this.to = this.total_rows;
                }
            }

        }

    }

</script>

<style scoped>
    .inline {
        display: -webkit-box;
        /* margin: 20px 0; */
    }

    .inline p {
        vertical-align: middle;
        line-height: 34px;
        padding: 0 5px;
    }

    .vanban {
        display: -webkit-inline-box;
        line-height: 34px;
        text-align: right;
        /* margin: 20px 0; */
        text-align: right;
        float: right;
        padding-right: 15px;
    }

    .pagination>.active>a {
        z-index: 0 !important;
    }

    .pagination {
        margin: 0 im !important;
    }

</style>

<template>
    <div>
        <el-row :gutter="24" class="text-right reset">
            <el-col :span="24" class="reset" style="display:inline;float:right;padding:0;">

                <b-pagination class="pull-right" style="margin:0" :first-text="pagination.first_text" :limit="9"
                    :last-text="pagination.last_text" :total-rows="total_rows" :prev-text="pagination.next_text"
                    :next-text="pagination.prev_text" v-model="trangHienTai" @change="chonTrangHienThi"
                    :per-page="pagination.limit">
                </b-pagination>
                <div class="vanban">
                    <p><i>Hiển thị từ <span style="color:#478fca">{{start}} - {{to}}</span> /Tổng số
                            <b>{{formatNumber(total_rows)}}</b> bản ghi</i></p>
                </div>
            </el-col>
        </el-row>
    </div>
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
            'tongbanghi',
            'soluonghienthi',
        ],
        watch: {
            batdau() {
                console.log("Đưa về trang 1");
                this.trangHienTai = 1;
                this.start = 0;
                this.onPageChange();
            },

            soluonghienthi(newVal) {
                console.log("Số lượng bản ghi hiển thị trên trang thay đổi:" + newVal)
                this.pagination.limit = newVal;
                this.to = newVal;
                this.trangHienTai = 1;
                let ret = {
                    start: 0,
                    limit: this.pagination.limit,
                    currentPage: this.trangHienTai,

                };
                console.log("Lấy lại " + JSON.stringify(ret));
                this.rebuild();
                this.$emit("pageChange", ret);
            },
            tongbanghi: function (newVal, oldVal) {
                this.total_rows = this.tongbanghi
                this.rebuild();
                console.log("Số lượng tổng bản ghi thay đổi" + this.total_rows)
            },
        },

        data() {
            return {
                trangHienTai: 1,
                pagination: {
                    "next_text": "«",
                    "prev_text": "»",
                    "per_page": 10,
                    "first_text": "Đầu",
                    "last_text": "Cuối",
                    "limit": 25,
                },
                start: 0,
                to: 25,
                total_rows: 0,
            }
        },

        mounted() {
            //this.rebuild();
        },

        methods: {
            chonTrangHienThi(number) {
                console.log(number)
                // console.log("Chọn trang");
                this.trangHienTai = number;
                console.log(this.trangHienTai)
                console.log("*****")
                // const loadingtmp = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                this.onPageChange();
                // loadingtmp.close();

            },

            formatNumber(num) {
                return number_util.formatNumberEx(num);
            },

            onPageChange() {
                console.log("Trang hiện tại: " + this.trangHienTai);
                let ret = {
                    start: (this.trangHienTai - 1) * this.pagination.limit,
                    limit: this.pagination.limit,
                    currentPage: this.trangHienTai,
                };
                this.rebuild();
                console.log("ret = " + JSON.stringify(ret));
                this.$emit("pageChange", ret);
            },
            rebuild() {
                this.start = (this.trangHienTai - 1) * this.pagination.limit + 1;
                this.to = (this.trangHienTai) * this.pagination.limit;
                console.log("curent paage: " + this.trangHienTai);
                console.log("s = " + this.start + ", to = " + this.to);
                console.log('total row : ' + this.total_rows);
                if (this.trangHienTai * this.pagination.limit <= this.total_rows) {
                    this.to = this.trangHienTai * this.pagination.limit;
                } else {
                    if (this.total_rows == 0) {
                        this.to = 0
                    } else {
                        this.to = this.total_rows;
                    }
                }
            }

        }

    }

</script>

<style scoped>
    .reset {
        padding-bottom: 0 !important;
        margin-bottom: 0 !important;
    }

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

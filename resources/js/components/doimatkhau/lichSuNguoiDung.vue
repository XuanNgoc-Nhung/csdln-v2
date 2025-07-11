<script>

import rest_api from '../../utils/rest_api';
import moment from 'moment';
import Pagination from '../ui/PagingCustom';

export default {
    props: ['show'],
    components: {
        Pagination,
    },
    watch: {
        show: function (newVal, oldVal) {
            if (newVal) {
                this.getDataLichSu();
                this.hien_thi_lich_su = true;
            } else {
                this.hien_thi_lich_su = false;
            }
        },
    },
    data() {
        return {
            lang: {
                formatLocale: {
                    firstDayOfWeek: 1,
                },
                monthBeforeYear: false,
            },
            loading: {
                text: 'Loading...',
                status: false,
            },
            thongtin: JSON.parse(window.userInfo),
            danh_sach_lich_su: [],
            hien_thi_lich_su: false,
            dataSearch: {
                tuNgay: [],
                denNgay: ''
            },
            paginate: {
                start: 0,
                limit: 25,
                total: 0,
                curentPage: 1,
                startPage: true,
            },
        }
    },

    mounted: function () {
        console.log('Mounted lịch sử người dùng...')
    },

    methods: {
        chonNgayBatDau(e) {
            console.log("Chọn ngày bắt đầu:" + e)
            if (this.dataSearch.tuNgay != null) {
                let endDauNam = moment(this.dataSearch.tuNgay, "DD/MM/YYYY")
                    .add(10, "days")
                    .format("DD/MM/YYYY");
                this.dataSearch.denNgay = endDauNam;
            }
        },
        layLaiDuLieu(e) {
            console.log('layLaiDuLieu');
            this.paginate.start = e.start;
            this.paginate.limit = e.limit;
            this.paginate.curentPage = e.currentPage;
            this.getDataLichSu()
        },
        getDataLichSu() {
            console.log('Lấy data Lịch sử đăng nhập')
            console.log(this.thongtin)
            this.danh_sach_lich_su = []
            let params = {
                username: this.thongtin.username,
                startTime: this.dataSearch.tuNgay[0],
                endTime: this.dataSearch.denNgay[1],
                start: this.paginate.start,
                limit: this.paginate.limit,
            };
            this.loading.status = true;
            rest_api.post("/internal-api/lichSuDangNhap/theoTenDangNhap", params, response => {
                console.log('Dữ liệu lịch sử đăng nhập trả về')
                console.log(response.data)
                this.loading.status = false;
                if (response.data.statusResponse == 0) {
                    this.loading.status = false;
                    this.danh_sach_lich_su = response.data.data;
                    this.paginate.total = response.data.total
                } else {
                    this.loading.status = false;
                    this.danh_sach_lich_su = [];
                    this.thongBao('error', response.data.rd)
                }
            });
        },
        thongBao(t, e) {
            let msg = "";
            let cl = "";
            if (e) {
                msg = e;
            }
            let type = "success";
            if (t) {
                type = t
            }
            if (type == "success") {
                cl = "dts-noty-success"
            }
            if (type == "warning") {
                cl = "dts-noty-warning"
            }
            if (type == "error") {
                cl = "dts-noty-error"
            }
            if (type == "info") {
                cl = "dts-noty-info"
            }
            this.$message({
                customClass: cl,
                showClose: true,
                message: msg,
                type: t,
                duration: 5000
            });
        },
        dongModal() {
            console.log('Đóng modal')
            this.hien_thi_lich_su = false;
            this.$emit('close')
        },
        close() {
            console.log("đóng");
            this.hien_thi_lich_su = false;
            this.$emit('close')
        }
    }
}

</script>

<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
    top="5vh"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog :close-on-click-modal="false" @close="dongModal" :close-on-press-escape="false" width="90%"
            title="Lịch sử đăng nhập hệ thống" :visible.sync="hien_thi_lich_su">


            <el-row class="contentDialog" :gutter="24">

                <el-col :sm="24" md="12">
                    <div>
                        <label class="typo__label">
                            Thời gian truy cập
                        </label>
                    </div>

                    <div class="input-daterange" style="display: flex;align-items: center;">
<!--                        <div style="display: flex">-->
<!--                            <date-picker v-model="dataSearch.tuNgay" placeholder="Chọn ngày" valueType="format"-->
<!--                                         value-type="DD/MM/YYYY" format="DD/MM/YYYY" @change="chonNgayBatDau">-->
<!--                            </date-picker>-->
<!--                            <div class="" style="padding: 6px 12px;-->
<!--    font-size: 14px;-->
<!--    font-weight: 400;-->
<!--    line-height: 1;-->
<!--    display: flex;-->
<!--    align-items: center;-->
<!--    color: #555;-->
<!--    text-align: center;-->
<!--    height: 36px;-->
<!--    width: 80px;-->
<!--    ">đến</div>-->
<!--                            <date-picker :lang="lang" v-model="dataSearch.denNgay" placeholder="Chọn ngày"-->
<!--                                         valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY"></date-picker>-->
<!--                        </div>-->

                        <div>
                            <el-date-picker
                                    style="width: 100%"
                                    v-model="dataSearch.tuNgay"
                                    type="daterange"
                                    align="center"
                                    format="dd/MM/yyyy"
                                    value-format="dd/MM/yyyy"
                                    start-placeholder="Từ ngày"
                                    end-placeholder="Đến ngày">
                            </el-date-picker>
                        </div>

                        <el-button style="margin-left: 24px" size="mini" type="success" @click.prevent="getDataLichSu">Tìm kiếm</el-button>

                    </div>
                </el-col>

                <el-col :span="24">
                    <el-table max-height="500" border empty-text="Chưa có dữ liệu" :data="danh_sach_lich_su" style="width: 100%" v-if="danh_sach_lich_su && danh_sach_lich_su.length > 0">
                        <el-table-column label="STT" align="center" width="80">
                            <template slot-scope="scope">
                                <span>{{ (paginate.curentPage - 1) * paginate.limit + scope.$index + 1 }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="Tài khoản">
                            <template slot-scope="scope">
                                <span>{{ scope.row.username }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="Trạng thái">
                            <template slot-scope="scope">
                                <span>{{ scope.row.responseMessage }}</span>
                            </template>
                        </el-table-column>
                        <el-table-column label="Thời gian" align="center">
                            <template slot-scope="scope">
                                <span>{{ scope.row.loginTimeString }}</span>
                            </template>
                        </el-table-column>
                    </el-table>

                    <el-table v-else style="width: 100%">
                        <el-table-column>
                            <template slot-scope="scope">
                                <span class="text-center">Không có bản ghi nào</span>
                            </template>
                        </el-table-column>
                    </el-table>

                </el-col>
                <el-col :span="24">
                    <Pagination :batdau="paginate.startPage" :total_rows="paginate.total"
                        @pageChange="layLaiDuLieu($event)"></Pagination>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="default" @click.prevent="close">Đóng</el-button>
            </span>
        </el-dialog>
    </div>

</template>


<style scoped>
    .content-huong-dan {
    }

</style>

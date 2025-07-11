<template>
    <div>
        <div>
            <div class="tab-content">
                <div class="row">
                    <div class="col-md-12" style="padding-right: 17px;">
                        <div class="">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background: #e4ebf5; text-align:center">
                                        <th style="text-align:center">
                                            <p>STT</p>
                                        </th>
                                        <th style="text-align:center">
                                            <p>Đơn vị</p>
                                        </th>
                                        <th style="text-align:center">
                                            <p>Đang nộp lên CSDL
                                            </p>
                                        </th>
                                        <th style="text-align:center">
                                            <p>Tổng số lớp học
                                            </p>
                                        </th>
                                        <th style="text-align:center">
                                            <p>Tổng số cán bộ quản lý
                                            </p>
                                        </th>
                                        <th style="text-align:center">
                                            <p>Tổng số giáo viên
                                            </p>
                                        </th>
                                        <th style="text-align:center">
                                            <p>Tổng số nhân viên
                                            </p>
                                        </th>
                                        <th style="text-align:center">
                                            <p>Tổng số học sinh
                                            </p>
                                        </th>
                                        <th style="text-align:center">
                                            <p>Đang nộp lên bộ
                                            </p>
                                        </th>
                                        <th style="text-align:center">
                                            <p>Đã nộp lên bộ
                                            </p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(th,i) in ds_truong">
                                        <td class="text-center">
                                            <p>{{i+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{th.tenDonVi}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                {{th.countSchoolSync}}/{{th.totalSchool}}
                                                trường.</p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                {{th.countLh}} lớp.</p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                {{th.countCbql}} cán bộ.</p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                {{th.countGv}} giáo viên.</p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                {{th.countNv}} nhân viên.</p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                {{th.countHs}} học sinh.</p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                {{th.soTruongDangDongBoLenBo}} trường.</p>
                                        </td>
                                        <td class="text-center">
                                            <p>
                                                {{th.soTruongDaHoanThanhDbLenBo}} trường.</p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import Vue from 'vue';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils';

    Vue.use(VueAlertify);
    export default {
        props: ['info'],
        components: {},
        data() {
            return {
                total_rows: 0,
                start: 0,
                currentPage: 1,
                limit: 25,
                ds_truong: [],
                date: new Date()
            }
        },
        mounted: function () {
            this.namHoc = this.date.getFullYear();
            this.getData();
        },
        methods: {
            getData() {
                let params = {
                    start: this.start,
                    limit: this.limit,
                    namHoc: this.namHoc
                };
                rest_api.post("/csdlgd-admin/statistic/school-sync", params, data => {
                    console.log("trả về:" + JSON.stringify(data))
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.ds_truong);
                        this.ds_truong = data.data.rows;
                    }
                });
            }
        }
    }
</script>
<style scoped="scoped">
    p {
        font-size: 12px;
    }
</style>
<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog width="90%" :title="getTitle()" :visible.sync="show" :before-close="close">
            <form>
                <el-row :gutter="24">
                    <el-col :span="24">
                        <el-tabs type="border-card2">
                            <el-tab-pane label="1. Lỗi đẩy lên bộ">
                                <div>
                                    <label style="" for=""><i
                                            style="color:#DC0101" class="fas fa-exclamation-triangle"></i> <i>Để xử lý
                                            lỗi, vui
                                            lòng tra cứu <span style="color:#01856B;font-weight:700">Danh mục lỗi đẩy lên
                                                Bộ</span> theo "<span style="font-weight:700">Mã lỗi</span> " và "<span
                                                style="font-weight:700">Mô tả</span>" để xem nguyên nhân và cách xử
                                            lý!</i></label>
                                    <!-- Type data is Scholl -->
                                    <div class="text-center" v-if="loai_day==1">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover"
                                                style="font-size:16px;">
                                                <thead>
                                                    <tr style="background:#e4ebf5">
                                                        <th class="text-center cg">STT</th>
                                                        <th class="">Mã trường học</th>
                                                        <th class="">Trạng thái</th>
                                                        <th class="">Mã lỗi</th>
                                                        <th class="">Mô tả</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi_loi.length===0">
                                                    <tr>
                                                        <td class="text-center" colspan="5">Không có bản ghi nào</td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(tt,index) in list_ban_ghi_loi">
                                                        <td class="text-center">{{ index + 1 }}</td>
                                                        <td class="text-center">
                                                            <div v-if="tt.name">
                                                                {{ tt.name }}
                                                            </div>
                                                            <div v-else="v-else">[Trống]</div>
                                                        </td>
                                                        <td class="text-center">
                                                            <span v-if="tt.error == '000-000'">Thành công</span>
                                                            <span v-else="v-else">Thất bại</span>
                                                        </td>
                                                        <td class="text-center">
                                                            <span v-if="tt.error == '000-000'">Không lỗi</span>
                                                            <span v-else="v-else">{{ tt.error }}</span>
                                                        </td>

                                                        <td class="text-center">{{ tt.errorDescription }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Type data is Teacher -->
                                    <div class="text-center" v-if="loai_day==2">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover"
                                                style="font-size:16px;">
                                                <thead>
                                                    <tr style="background:#e4ebf5">
                                                        <th class="text-center cg">STT</th>
                                                        <th class="">Tên giáo viên</th>
                                                        <th class="">Mã giáo viên</th>
                                                        <th class="">Trạng thái</th>
                                                        <th class="">Mã lỗi</th>
                                                        <th class="">Mô tả</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi_loi.length===0">
                                                    <tr>
                                                        <td class="text-center" colspan="6">Không có bản ghi nào</td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(tt,index) in list_ban_ghi_loi">
                                                        <td class="text-center">{{ index + 1 }}</td>
                                                        <td>
                                                            <div v-if="tt.name">
                                                                {{ tt.name }}
                                                            </div>
                                                            <div class="text-center" v-else="v-else">[Trống]</div>
                                                        </td>
                                                        <td class="">{{ tt.clientId }}</td>
                                                        <td class="text-center">
                                                            <span v-if="tt.error == '000-000'">Thành công</span>
                                                            <span v-else="v-else">Thất bại</span>
                                                        </td>
                                                        <td>
                                                            <span v-if="tt.error == '000-000'">Không lỗi</span>
                                                            <span class=""
                                                                v-else="v-else">{{ tt.error }}</span>
                                                        </td>

                                                        <td>{{ tt.errorDescription }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Type data is Class -->
                                    <div class="text-center" v-if="loai_day==3">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover"
                                                style="font-size:16px;">
                                                <thead>
                                                    <tr style="background:#e4ebf5">
                                                        <th class="text-center cg">STT</th>
                                                        <th class="">Tên lớp học</th>
                                                        <th class="">Mã lớp học</th>
                                                        <th class="">Trạng thái</th>
                                                        <th class="">Mã lỗi</th>
                                                        <th class="">Mô tả</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi_loi.length===0">
                                                    <tr>
                                                        <td class="text-center" colspan="6">Không có bản ghi nào</td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(tt,index) in list_ban_ghi_loi">
                                                        <td class="text-center">{{ index + 1 }}</td>
                                                        <td class="text-center">
                                                            <div v-if="tt.name">
                                                                {{ tt.name }}
                                                            </div>
                                                            <div class="text-center" v-else="v-else">[Trống]</div>
                                                        </td>
                                                        <td class="">{{ tt.clientId }}</td>
                                                        <td class="text-center">
                                                            <span v-if="tt.error == '000-000'">Thành công</span>
                                                            <span v-else="v-else">Thất bại</span>
                                                        </td>
                                                        <td>
                                                            <span v-if="tt.error == '000-000'">Không lỗi</span>
                                                            <span class="text-center"
                                                                v-else="v-else">{{ tt.error }}</span>
                                                        </td>

                                                        <td>{{ tt.errorDescription }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Type data is Student -->
                                    <div class="text-center" v-if="loai_day==4">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover"
                                                style="font-size:16px;">
                                                <thead>
                                                    <tr style="background:#e4ebf5">
                                                        <th class="text-center cg">STT</th>
                                                        <th class="">Tên học sinh</th>
                                                        <th class="text-center">Mã học sinh</th>
                                                        <th class="">Trạng thái</th>
                                                        <th class="">Mã lỗi</th>
                                                        <th class="">Mô tả</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi_loi.length===0">
                                                    <tr>
                                                        <td class="text-center" colspan="6">Không có bản ghi nào</td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(tt,index) in list_ban_ghi_loi">
                                                        <td class="text-center">{{ index + 1 }}</td>
                                                        <td>
                                                            <div v-if="tt.name">
                                                                {{ tt.name }}
                                                            </div>
                                                        <div class="text-center" v-else="v-else">[Trống]</div>
                                                        </td>
                                                        <td class="">{{ tt.clientId }}</td>
                                                        <td class="text-center">
                                                            <span v-if="tt.error == '000-000'">Thành công</span>
                                                            <span v-else="v-else">Thất bại</span>
                                                        </td>
                                                        <td>
                                                            <span v-if="tt.error == '000-000'">Không lỗi</span>
                                                            <span class="text-center"
                                                                v-else="v-else">{{ tt.error }}</span>
                                                        </td>

                                                        <td>{{ tt.errorDescription }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Type data is learning outcomes -->
                                    <div class="text-center" v-if="loai_day==5">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover"
                                                style="font-size:16px;">
                                                <thead>
                                                    <tr style="background:#e4ebf5">
                                                        <th class="text-center cg">STT</th>
                                                        <th class="">Tên học sinh</th>
                                                        <th class="">Mã học sinh</th>
                                                        <th class="">Trạng thái</th>
                                                        <th class="">Mã lỗi</th>
                                                        <th class="">Mô tả</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi_loi.length===0">
                                                    <tr>
                                                        <td class="text-center" colspan="6">Không có bản ghi nào</td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(tt,index) in list_ban_ghi_loi">
                                                        <td class="text-center">{{ index + 1 }}</td>
                                                        <td>
                                                            <div v-if="tt.name">
                                                                {{ tt.name }}
                                                            </div>
                                                            <div class="text-center" v-else="v-else">[Trống]</div>
                                                        </td>
                                                        <td class="">{{ tt.clientId }}</td>
                                                        <td class="text-center">
                                                            <span v-if="tt.error == '000-000'">Thành công</span>
                                                            <span v-else="v-else">Thất bại</span>
                                                        </td>
                                                        <td>
                                                            <span v-if="tt.error == '000-000'">Không lỗi</span>
                                                            <span class="text-center"
                                                                v-else="v-else">{{ tt.error }}</span>
                                                        </td>

                                                        <td>{{ tt.errorDescription }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Type data is learning outcomes -->
                                    <div class="text-center" v-if="loai_day==7">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover"
                                                style="font-size:16px;">
                                                <thead>
                                                    <tr style="background:#e4ebf5">
                                                        <th class="text-center cg">STT</th>
                                                        <th class="">Tên học sinh</th>
                                                        <th class="">Mã học sinh</th>
                                                        <th class="">Trạng thái</th>
                                                        <th class="">Mã lỗi</th>
                                                        <th class="">Mô tả</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi_loi.length===0">
                                                    <tr>
                                                        <td class="text-center" colspan="6">Không có bản ghi nào</td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(tt,index) in list_ban_ghi_loi">
                                                        <td class="text-center">{{ index + 1 }}</td>
                                                        <td>
                                                            <div v-if="tt.name">
                                                                {{ tt.name }}
                                                            </div>
                                                            <div class="text-center" v-else="v-else">[Trống]</div>
                                                        </td>
                                                        <td class="">{{ tt.clientId }}</td>
                                                        <td class="text-center">
                                                            <span v-if="tt.error == '000-000'">Thành công</span>
                                                            <span v-else="v-else">Thất bại</span>
                                                        </td>
                                                        <td>
                                                            <span v-if="tt.error == '000-000'">Không lỗi</span>
                                                            <span class="text-center"
                                                                v-else="v-else">{{ tt.error }}</span>
                                                        </td>

                                                        <td>{{ tt.errorDescription }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Type data is learning outcomes -->
                                    <div class="text-center" v-if="loai_day==8">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover"
                                                style="font-size:16px;">
                                                <thead>
                                                    <tr style="background:#e4ebf5">
                                                        <th class="text-center cg">STT</th>
                                                        <th class="">Tên học sinh</th>
                                                        <th class="">Mã học sinh</th>
                                                        <th class="">Trạng thái</th>
                                                        <th class="">Mã lỗi</th>
                                                        <th class="">Mô tả</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi_loi.length===0">
                                                    <tr>
                                                        <td class="text-center" colspan="6">Không có bản ghi nào</td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(tt,index) in list_ban_ghi_loi">
                                                        <td class="text-center">{{ index + 1 }}</td>
                                                        <td>
                                                            <div v-if="tt.name">
                                                                {{ tt.name }}
                                                            </div>
                                                            <div class="text-center" v-else="v-else">[Trống]</div>
                                                        </td>
                                                        <td class="">{{ tt.clientId }}</td>
                                                        <td class="text-center">
                                                            <span v-if="tt.error == '000-000'">Thành công</span>
                                                            <span v-else="v-else">Thất bại</span>
                                                        </td>
                                                        <td>
                                                            <span v-if="tt.error == '000-000'">Không lỗi</span>
                                                            <span class="text-center"
                                                                v-else="v-else">{{ tt.error }}</span>
                                                        </td>

                                                        <td>{{ tt.errorDescription }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- Type data is learning outcomes -->
                                    <div class="text-center" v-if="loai_day==9">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover"
                                                style="font-size:16px;">
                                                <thead>
                                                    <tr style="background:#e4ebf5">
                                                        <th class="text-center cg">STT</th>
                                                        <th class="">Tên học sinh</th>
                                                        <th class="">Mã học sinh</th>
                                                        <th class="">Trạng thái</th>
                                                        <th class="">Mã lỗi</th>
                                                        <th class="">Mô tả</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi_loi.length===0">
                                                    <tr>
                                                        <td class="text-center" colspan="6">Không có bản ghi nào</td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(tt,index) in list_ban_ghi_loi">
                                                        <td class="text-center">{{ index + 1 }}</td>
                                                        <td>
                                                            <div v-if="tt.name">
                                                                {{ tt.name }}
                                                            </div>
                                                            <div class="text-center" v-else="v-else">[Trống]</div>
                                                        </td>
                                                        <td class="">{{ tt.clientId }}</td>
                                                        <td class="text-center">
                                                            <span v-if="tt.error == '000-000'">Thành công</span>
                                                            <span v-else="v-else">Thất bại</span>
                                                        </td>
                                                        <td>
                                                            <span v-if="tt.error == '000-000'">Không lỗi</span>
                                                            <span class="text-center"
                                                                v-else="v-else">{{ tt.error }}</span>
                                                        </td>

                                                        <td>{{ tt.errorDescription }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- endClass -->
                                    <!-- Type data is learning outcomes -->
                                    <div class="text-center" v-if="loai_day==14">
                                        <div class="table-responsive row_tp">
                                            <table class="table table-striped table-bordered table-hover"
                                                style="font-size:16px;">
                                                <thead>
                                                    <tr style="background:#e4ebf5">
                                                        <th class="text-center cg">STT</th>
                                                        <th class="">Tên cán bộ</th>
                                                        <th class="">Mã cán bộ</th>
                                                        <th class="">Trạng thái</th>
                                                        <th class="">Mã lỗi</th>
                                                        <th class="">Mô tả</th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="list_ban_ghi_loi.length===0">
                                                    <tr>
                                                        <td class="text-center" colspan="6">Không có bản ghi nào</td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(tt,index) in list_ban_ghi_loi">
                                                        <td class="text-center">{{ index + 1 }}</td>
                                                        <td>
                                                            <div v-if="tt.name">
                                                                {{ tt.name }}
                                                            </div>
                                                            <div class="text-center" v-else="v-else">[Trống]</div>
                                                        </td>
                                                        <td class="">{{ tt.clientId }}</td>
                                                        <td class="text-center">
                                                            <span v-if="tt.error == '000-000'">Thành công</span>
                                                            <span v-else="v-else">Thất bại</span>
                                                        </td>
                                                        <td>
                                                            <span v-if="tt.error == '000-000'">Không lỗi</span>
                                                            <span class="text-center"
                                                                v-else="v-else">{{ tt.error }}</span>
                                                        </td>

                                                        <td>{{ tt.errorDescription }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- endClass -->

                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="2. Lỗi đồng bộ">
                                <div class="text-center">
                                    <div class="table-responsive row_tp">
                                        <table class="table table-striped table-bordered table-hover"
                                            style="font-size:16px;">
                                            <thead>
                                                <tr style="background:#e4ebf5">
                                                    <th class="text-center cg">STT</th>
                                                    <th class="">Mã lỗi</th>
                                                    <th class="">Tên đối tượng</th>
                                                    <th class="text-center">clientId</th>
                                                    <th class="">Mô tả lỗi</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="errTransForm.length===0">
                                                <tr>
                                                    <td class="text-center" colspan="5">Không có bản ghi nào</td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else="v-else">
                                                <tr v-for="(tt,index) in errTransForm">
                                                    <td class="text-center">
                                                        <p>{{ index + 1 }}</p>
                                                    </td>
                                                    <td class="">
                                                        <p>{{ tt.error }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ tt.name }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ tt.clientId }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ tt.errorDescription }}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </el-tab-pane>
                            <el-tab-pane label="3. Danh mục lỗi">

                                <div class="text-center">
                                    <div class="table-responsive row_tp">
                                        <table class="table table-striped table-bordered table-hover"
                                            style="font-size:16px;">
                                            <thead>
                                                <tr style="background:#e4ebf5">
                                                    <th class="text-center cg">STT</th>
                                                    <th class="">Mã lỗi</th>
                                                    <th class="">Mô tả của Bộ</th>
                                                    <th class="">Nguyên nhân</th>
                                                    <th class="">Cách xử lý</th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="list_loi_day_len_bo.length===0">
                                                <tr>
                                                    <td class="text-center" colspan="5">Không có bản ghi nào</td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else="v-else">
                                                <tr v-for="(tt,index) in list_loi_day_len_bo">
                                                    <td class="text-center">
                                                        <p>{{ index + 1 }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ tt.errorCode }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ tt.errorDescription }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ tt.rootCause }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ tt.solution }}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </el-tab-pane>
                        </el-tabs>
                    </el-col>
                </el-row>
            </form>
            <span slot="footer" class="dialog-footer">
                <el-tooltip class="item" effect="dark" content="Xoá mã định danh các học sinh lỗi"
                    placement="top-start">
                    <el-button v-if="danh_sach_hoc_sinh_loi.length" type="primary" size="mini"
                        @click.prevent="xoaMaDinhDanhCacHocSinh()"> Xoá mã định danh</el-button>
                </el-tooltip>
                <el-button size="mini" @click.prevent="close()"> Đóng</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import moment from 'moment'
    import utils from '../../utils'
    import api from '../api';

    export default {
        props: [
            'item', 'show'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.danh_sach_hoc_sinh_loi = [];
                    this.ban_ghi = this.item;
                    this.loai_day = this.ban_ghi.buocHienTai;
                    this.getInfoItem(this.item)
                    this.getDanhMucLoi();
                } else {}
            },
            item: function (newVal, oldVal) {
                console.log("id lấy thông tin kết chuyển:" + JSON.stringify(newVal));
                // this.getInfoItem(newVal);
            }
        },

        data() {
            return {
                list_ban_ghi: [],
                list_loi_day_len_bo: [],
                list_ban_ghi_loi: [],
                danh_sach_hoc_sinh_loi: [],
                danh_sach_loi_xoa_ma_dinh_danh: ['MA_HOC_SINH','MA_HOC_SINH_001'],
                ban_ghi: {},
                loai_day: "",
                errTransForm: "",
                loading: {
                    status: false,
                    text: 'Loading...'
                }
            }
        },

        mounted: function () {
            console.log("mounted !!!!!");
            console.log("thông tin" + JSON.stringify(this.item));
            $(this.$refs.modal_import_file).on("hidden.bs.modal", this.close);
        },
        methods: {
            xoaMaDinhDanhCacHocSinh() {
                this.$confirm('Xác nhận xoá mã định danh các học sinh lỗi?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.xoaMaDinhDanh();
                    })
                    .catch(_ => {});
            },

            thongBao(typeNoty, msgNoty) {
                let msg = "";
                let cl = "";
                if (msgNoty) {
                    msg = msgNoty;
                }
                let type = "success";
                if (typeNoty) {
                    type = typeNoty
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
                    type: type,
                    duration: 5000
                });
            },
            xoaMaDinhDanh() {
                console.error('xoaMaDinhDanh')
                let params = {
                    loaiDuLieu: 4,
                    lstMa: this.danh_sach_hoc_sinh_loi,
                    namHoc: this.ban_ghi.namHoc
                };
                this.loading.status = true;
                rest_api.post("/csdlgd-admin/DataTruong/deleteMoetCode", params, data => {
                    console.error('Xoá trả về:')
                    console.error(data)
                    if (data.data.rc == 0) {
                        console.error('Case 1')
                        this.thongBao('success', 'Xoá mã định danh học sinh thành công')
                    } else {
                        console.error('Case 2')
                        this.thongBao('error', data.data.rd)
                    }

                    this.loading.status = false;
                });
            },
            getTitle() {
                let text = this.getLoaiDay(parseInt(this.loai_day)) + ' - Trường: ' + this.ban_ghi.tenTruong + ' - [' +
                    this.ban_ghi.maTruong + '] - ' + 'Năm học: ' + this.ban_ghi.namHoc + '-' + (this.ban_ghi.namHoc + 1)
                return text
            },
            CheckLoiCacBanGhi(arr) {
                console.error('CheckLoiCacBanGhi:')
                console.error(this.loai_day)
                console.error(arr)
                this.danh_sach_hoc_sinh_loi = [];
                for (let i = 0; i < arr.length; i++) {
                    console.error(arr[i])
                    if (this.danh_sach_loi_xoa_ma_dinh_danh.includes(arr[i].error)) {
                        console.error(arr[i].error + 'cần xoá mã định danh')
                        this.danh_sach_hoc_sinh_loi.push(arr[i].clientId)
                    }
                }
                console.error(this.danh_sach_hoc_sinh_loi)
            },
            getDanhMucLoi() {
                let params = {};
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-admin/MoetErrorDev", params, data => {
                    loading.close();
                    console.log("danh mục lỗi:");
                    console.log(JSON.stringify(data.data));
                    if (data.data.rc == 0) {
                        this.list_loi_day_len_bo = data.data.rows;
                    }
                });
            },

            getLoaiDay(loai) {
                var res = loai;
                switch (loai) {
                    case 1:
                        res = 'Đẩy dữ liệu nhà trường'
                        break;
                    case 2:
                        res = 'Đẩy dữ liệu giáo viên'
                        break;
                    case 3:
                        res = 'Đẩy dữ liệu lớp học'
                        break;
                    case 4:
                        res = 'Đẩy dữ liệu học sinh'
                        break;
                    case 5:
                        res = 'Đẩy dữ liệu học tập'
                        break;
                    case 6:
                        res = 'Đẩy dữ liệu EQMS'
                        break;
                    case 7:
                        res = 'Hoàn thành chương trình mầm non'
                        break;
                    case 8:
                        res = 'Xét tốt nghiệp'
                        break;
                    case 9:
                        res = 'Nhập điểm thi lại'
                        break;
                    case 14:
                        res = 'Đánh giá chuẩn nghề nghiệp'
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getInfoItem(e) {
                this.list_ban_ghi = [];
                this.list_ban_ghi_loi = [];
                 this.errTransForm = []
                let params = {
                    messageId: e.messageId
                };
                if (params.messageId == null) {
                    params.idBcQuaTrinh = e.id;
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-push/LichSuDay/detail", params, data => {
                    loading.close();
                    // console.log("tổng thể trả về:" + JSON.stringify(data));
                    if (data.data.code == 200) {
                        if (data.data.item.response) {
                            this.list_ban_ghi = data.data.item.response.body.result.items.item;
                            for (let i = 0; i < this.list_ban_ghi.length; i++) {
                                if (this.list_ban_ghi[i].error != "000-000") {
                                    this
                                        .list_ban_ghi_loi
                                        .push(this.list_ban_ghi[i])
                                }
                            }
                            console.log("hihi:" + JSON.stringify(this.list_ban_ghi_loi));
                            if (this.list_ban_ghi_loi && this.list_ban_ghi_loi.length) {
                                this.CheckLoiCacBanGhi(this.list_ban_ghi_loi);
                            }
                        } else {
                            this.list_ban_ghi = [];
                        }
                        if (data.data.item.errTransForm) {
                            this.errTransForm = data.data.item.errTransForm.body.result.items.item;
                            if (this.errTransForm.length == 0 || this.errTransForm == null) {
                                this.errTransForm = []

                            }
                        }
                        console.log("errTransForm là: " + JSON.stringify(data.data.item.errTransForm));

                        // this.thongBao('success','Lấy thông tin thành công.')
                    } else {
                        this.thongBao('error', 'Có lỗi trong quá trình lấy dữ liệu. Vui lòng thử lại sau.')
                    }
                });
            },
            close() {
                console.log("đóng modal");
                this.$emit('close')
            }
        }

    }

</script>
<style>
    label {
        font-size: 16px;
    }

    p {
        padding: 0;
        margin: 0;
    }

    .row_tp {
        margin-top: 5px;
    }

    .el-tabs__item.is-top {
        font-size: 16px !important;
    }

</style>

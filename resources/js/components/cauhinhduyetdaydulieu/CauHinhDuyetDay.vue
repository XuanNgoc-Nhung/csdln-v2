<template>
    <div>
        <Breadcrumb :menu="'Kết chuyển dữ liệu'" :desc="'Cấu hình duyệt/đẩy dữ liệu'" />
        <div class="card-bieu-do">
            <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                <el-form ref="ruleForm">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :sm="8" :lg="6">
                        <label>Loại đơn vị</label>
                        <!-- <el-select v-model="loai_don_vi" multiple filterable collapse-tags @change="chonLoaiDonVi"
                                placeholder="Chọn" no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in list_loai_don_vi" :key="item.value" :label="item.name"
                                    :value="item.value">
                                </el-option>
                            </el-select> -->

                        <eselect style="width:100%" multiple collapseTags v-model="loai_don_vi" @change="chonLoaiDonVi"
                            :placeholder="'Chọn'" filterable :data="list_loai_don_vi" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="16" :lg="12">
                        <label class="typo__label p-3">Đơn vị quản lý</label>
                        <eselect style="width:100%" multiple collapseTags v-model="ma_don_vi" @change="chonDonVi"
                            :placeholder="'Chọn'" filterable :data="list_don_vi" :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="8" :lg="6">
                        <label class="typo__label">Cấp học</label>
                        <eselect style="width:100%" @change="chonCapHoc" multiple collapseTags v-model="cap_hoc"
                            :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="16" :lg="12">
                        <label class="typo__label">Trường học</label>
                        <eselect style="width:100%" multiple collapseTags v-model="ma_truong_hoc" :placeholder="'Chọn'"
                            filterable :data="list_truong_hoc" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="24" class="text-center">
                        <el-button class="bt-chinh" plain type="success" size="mini"
                            @click.prevent="checkTruocKhiTim()">Tìm kiếm
                        </el-button>
                    </el-col>
                </el-form>
            </el-row>
        </div>
        <div class="card-bieu-do">

            <el-row :gutter="24">
                <!-- <el-col :span="12" class="">
                    <label  class="table-name">Danh sách trường cấu hình duyệt/đẩy lên Bộ</label>
                </el-col>
                <el-col :span="12">
                    <div class="text-right">
                        <el-tooltip content="Thêm mới cấu hình duyệt đẩy" placement="top">
                            <el-button class="bt-chinh" plain type="primary" size="mini"
                                @click.prevent="ThemMoiCauHinh()">
                                Thêm mới
                            </el-button>
                        </el-tooltip>
                    </div>
                </el-col> -->
                <el-col :span="24">
                    <div class="centerBetweenFlex">
                        <label class="table-name">Danh sách trường cấu hình duyệt/đẩy lên Bộ</label>
                        <div class="text-right">
                            <el-tooltip content="Thêm mới cấu hình duyệt đẩy" placement="top">
                                <el-button class="bt-chinh" plain type="primary" size="mini"
                                    @click.prevent="ThemMoiCauHinh()">
                                    Thêm mới
                                </el-button>
                            </el-tooltip>
                        </div>
                    </div>
                </el-col>
                <el-col :span="24">
                    <div>
                        <el-table
                                :data="list_cau_hinh"
                                border
                                stripe
                                empty-text="Không có bản ghi nào"
                                max-height="600"
                        >
                            <!-- STT -->
                            <el-table-column
                                    label="STT"
                                    align="center"
                                    width="50"
                                    fixed="left"
                            >
                                <template #default="{ $index }">
                                    <p>{{ (currentPage - 1) * limit + $index + 1 }}</p>
                                </template>
                            </el-table-column>



                            <!-- Đơn vị quản lý -->
                            <el-table-column
                                    label="Đơn vị quản lý"
                                    min-width="200"
                                    fixed
                            >
                                <template #default="{ row }">
                                    <p>{{ row.tenDonVi }}</p>
                                </template>
                            </el-table-column>

                            <!-- Loại đơn vị -->
                            <el-table-column
                                    label="Loại đơn vị"
                                    width="120"
                            >
                                <template #default="{ row }">
                                    <p>{{ getLoaiDonVi(row.loaiDonVi) }}</p>
                                </template>
                            </el-table-column>

                            <!-- Mã trường -->
                            <el-table-column
                                    label="Mã trường"
                                    align="center"
                                    width="120"
                            >
                                <template #default="{ row }">
                                    <p>{{ row.maTruongHoc }}</p>
                                </template>
                            </el-table-column>

                            <!-- Trường học -->
                            <el-table-column
                                    label="Trường học"
                                    min-width="200"
                            >
                                <template #default="{ row }">
                                    <p>{{ row.tenTruongHoc }}</p>
                                </template>
                            </el-table-column>

                            <!-- Trường được đẩy lên bộ -->
                            <el-table-column
                                    label="Trường được đẩy lên bộ"
                                    align="center"
                                    width="200"
                            >
                                <template #default="{ row }">
                                    <p v-if="row.truongDuocNopLenBo">
                                        <i style="color: blue;" class="el-icon-check"></i>
                                    </p>
                                </template>
                            </el-table-column>

                            <!-- Phòng được đẩy lên bộ -->
                            <el-table-column
                                    label="Phòng được đẩy lên bộ"
                                    align="center"
                                    width="200"
                            >
                                <template #default="{ row }">
                                    <p v-if="row.phongDuocNopLenBo">
                                        <i style="color: blue;" class="el-icon-check"></i>
                                    </p>
                                </template>
                            </el-table-column>

                            <!-- Thao tác -->
                            <el-table-column
                                    label="Thao tác"
                                    align="center"
                                    fixed="right"
                                    width="90"
                            >
                                <template #default="{ row }">
                                    <el-tooltip content="Xóa" placement="left">
                                        <i class="el-icon-delete" @click.prevent="DeleteCauHinh(row.id)"></i>
                                    </el-tooltip>
                                </template>
                            </el-table-column>
                        </el-table>
                    </div>


                </el-col>
                <el-col :span="24">
                    <!-- Phân trang -->
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                    <!-- Hết phân trang -->
                    <!-- Chỉnh sửa học sinh -->
                    <div v-if="show_update">
                        <chinhsua :item="dataUpdate" @close="show_update=false" @success="checkTruocKhiTim()">
                        </chinhsua>
                    </div>
                    <themmoi :show="show_add" @close="show_add=false" @success="checkTruocKhiTim()">
                    </themmoi>
                </el-col>
            </el-row>
        </div>
    </div>
</template>
<script>
    import constant from '../../utils/constant';
    import VueAlertify from "vue-alertify";

    import utils from '../../utils'
    import ESelectVue from '../ui/ESelect.vue';
    import ThemMoi from './ThemMoi';
    import ChinhSua from './ChinhSua';
    import Page from "../ui/PagingCustom";
    import rest_api from '../../utils/rest_api';
    import Breadcrumb from '../ui/Breadcrumb.vue';

    Vue.use(VueAlertify, {

        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            // dialogs default title
            title: 'Thông báo',
            // ok button text
            ok: 'Đồng ý',
            // cancel button text
            cancel: 'Hủy'
        }
    });
    export default {
        components: {
            Page: Page,
            'eselect': ESelectVue,
            'themmoi': ThemMoi,
            'chinhsua': ChinhSua,
            Breadcrumb
        },
        props: [],
        data() {
            return {
                thongtin: {},
                dataUpdate: {},
                ma_don_vi: [],
                maTruong: "",
                cap_hoc: [],
                ma_truong_hoc: [],
                list_cau_hinh: [],
                list_truong_hoc: [],
                list_don_vi: [],
                list_cap_hoc: window.listCapHoc,
                show_add: false,
                show_update: false,
                trangbatdau: true,
                phong: true,
                truong: true,
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                list_loai_don_vi: [{
                    name: "Phòng",
                    value: "2"
                }, {
                    name: "Trường",
                    value: "3"
                }],

                loai_don_vi: [],
            }
        },
        watch: {},
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.getDonVi();
            this.getTruongHoc();
            this.getData();

        },
        methods: {
            chonLoaiDonVi() {
                console.log("chọn loại đơn vị:");
                this.list_truong_hoc = [];
                this.phong = false;
                this.truong = false;
                for (let i = 0; i < this.loai_don_vi.length; i++) {
                    if (this.loai_don_vi[i] == 1) {
                        this.phong = true;
                    }
                    if (this.loai_don_vi[i] == 2) {
                        this.truong = true;
                    }
                }
            },


            DeleteCauHinh(e) {
                let url = "/csdlgd-admin/duyetDayDuLieu/delete/" + e;

                this.$confirm('Xác nhận xóa dữ liệu bản ghi này?', 'Xóa dữ liệu', {
                        confirmButtonText: 'Xóa',
                        cancelButtonText: 'Hủy',
                        confirmButtonClass: 'el-button--danger',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post(url, {}, data => {
                            loading.close();
                            if (data.data.rc == 0) {
                                this.thongBao("success", data.data.rd);
                                this.checkTruocKhiTim();
                            } else {
                                this.thongBao('error', data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
            },
            ShowUpdate(e) {
                this.show_update = true;
                this.dataUpdate = e;
            },
            getLoaiDonVi(e) {
                if (e == 1) {
                    return "Sở";
                }
                if (e == 2) {
                    return "Phòng";
                }
                if (e == 3) {
                    return "Trường";
                }
            },
            ThemMoiCauHinh() {
                this.show_add = true;
            },
            checkTruocKhiTim() {
                this.show_add = false;
                this.show_update = false;
                this.trangbatdau = !this.trangbatdau;
            },
            chonCapHoc() {
                this.list_truong_hoc = [];
                this.ma_truong_hoc = [];
                this.getTruongHoc();
            },
            chonDonVi() {
                this.ma_truong_hoc = [];
                this.getTruongHoc();
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
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.province
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    if (data.data.statusResponse == 0) {
                        let dm = data.data.rows;
                        this.list_don_vi = []
                        for (let i = 0; i < dm.length; i++) {
                            let obj = {
                                name: dm[i].tenDonVi,
                                value: dm[i].maDonVi
                            }
                            this.list_don_vi.push(obj)
                        }
                    }
                });
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ma_don_vi,
                    capHoc: this.cap_hoc
                };

                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    // loading.close();
                    if (data.data.code == 200) {
                        let lstth = data.data.rows;
                        for (let i = 0; i < lstth.length; i++) {
                            let obj = {
                                name: lstth[i].tenTruongHoc + ' - [' + lstth[i].maTruongHoc + ']',
                                value: lstth[i].maTruongHoc
                            }
                            this.list_truong_hoc.push(obj);
                        }
                    }
                });
            },
            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            getData() {
                this.list_cau_hinh = [];
                this.total_rows = 0;
                let params = {
                    "capHocs": this.cap_hoc,
                    "maDonVis": this.ma_don_vi,
                    "maTruongs": this.ma_truong_hoc,
                    "loaiDonVis": this.loai_don_vi,
                    "start": this.start,
                    // "maSo": this.thongtin.province,
                    "limit": this.limit,
                };

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/duyetDayDuLieu/danhSach", params, (respon) => {
                    loading.close();
                    if (respon.data.rc == 0) {
                        if (respon.data.rows.length == 0) {
                            this.thongBao('error', 'Không có bản ghi nào được tìm thấy')
                            return;
                        } else {
                            this.list_cau_hinh = respon.data.rows;
                            this.total_rows = respon.data.total;
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công.")
                        }

                    } else {
                        this.thongBao('error', respon.data.rd)
                        return;
                    }
                })
            }
        }
    }

</script>
<style scoped="scoped">
    .reset {
        padding: 0 !important;
    }

</style>

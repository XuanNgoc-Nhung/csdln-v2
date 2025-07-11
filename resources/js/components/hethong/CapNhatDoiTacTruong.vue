<template>
    <div>

        <Breadcrumb :menu="'Tiếp nhận dữ liệu QLNT'" :desc="'Hệ thống đối tác trường'" />

        <div class="card-bieu-do">

            <el-form ref="ruleForm">
                <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                    <el-col :span="24">
                        <div class="table-name">Thông tin tìm kiếm</div>
                    </el-col>
                    <el-col :sm="16" :md="16" :lg="8">
                        <label class="typo__label">Đơn vị quản lý</label>
                        <eselect style="width:100%" multiple collapseTags v-model="donVi" :placeholder="'Chọn'"
                                 filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                    </el-col>
                    <el-col :sm="8" :md="8" :lg="4">
                        <label class="typo__label">Cấp học</label>
                        <eselect style="width:100%" multiple collapseTags v-model="capHoc" :placeholder="'Chọn'"
                                 filterable :data="list_cap_hoc_2" :fields="['name','id']" />
                    </el-col>
                    <el-col :sm="16" :md="16" :lg="8">
                        <label class="typo__label">Trường học</label>
                        <eselect style="width:100%" multiple collapseTags v-model="truongHoc"
                                 :placeholder="'Chọn'" filterable :data="ds_truong_hoc"
                                 :fields="['name','value']" />
                    </el-col>
                    <el-col :sm="8" :md="8" :lg="4">
                        <label class="typo__label">Đối tác</label>
                        <!-- <el-select v-model="maDoiTac" filterable collapse-tags placeholder="Chọn"
                                no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in ds_doi_tac" :key="item.value" :label="item.name" :value="item.value">
                                </el-option>
                            </el-select> -->

                        <eselect style="width:100%" collapseTags v-model="maDoiTac" :placeholder="'Chọn'" filterable
                                 :data="ds_doi_tac" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="24" class="text-center">
                        <el-button class="bt-chinh" plain size="mini" v-on:click.prevent="TruocKhiTim()" type="success">
                            Tìm kiếm
                        </el-button>
                    </el-col>

                </el-row>
            </el-form>
        </div>
        <!-- hết tìm kiếm -->
        <!-- danh sách -->
         
        <div class="card-bieu-do">
            <el-row :gutter="24">
                <!-- <el-col :span="12" class="">
                    <label  class="table-name">Danh sách cấu hình đối tác trường</label>
                </el-col>
                <el-col :span="12">
                    <div class="text-right">
                        <span style="padding-right:20px" v-if="lsDelete.length"><b>Đã chọn {{ lsDelete.length }}
                                bản ghi</b></span>
                        <el-tooltip content="Xóa các bản ghi đã chọn" placement="top">
                            <el-button class="bt-xoa" type='danger' v-if="lsDelete.length" size="mini"
                                v-on:click.prevent="deleteUnit()"> Xóa
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Thêm mới" placement="top">
                            <el-button class="bt-chinh" type="primary" size="mini"
                                v-on:click.prevent="showCreat()"> Thêm mới
                            </el-button>
                        </el-tooltip>
                    </div>
                </el-col> -->
                
            <el-col :span="24">
                <div class="centerBetweenFlex">
                    <label class="table-name">Danh sách cấu hình đối tác trường</label>
                    <div class="text-right">
                        <span style="padding-right:20px" v-if="lsDelete.length"><b>Đã chọn {{ lsDelete.length }}
                                bản ghi</b></span>
                        <el-tooltip content="Xóa các bản ghi đã chọn" placement="top">
                            <el-button class="bt-xoa" type='danger' v-if="lsDelete.length" size="mini"
                                v-on:click.prevent="deleteUnit()"> Xóa
                            </el-button>
                        </el-tooltip>
                        <el-tooltip content="Thêm mới" placement="top">
                            <el-button class="bt-chinh" type="primary" size="mini"
                                v-on:click.prevent="showCreat()"> Thêm mới
                            </el-button>
                        </el-tooltip>
                    </div>
                </div>
            </el-col>
                <el-col :span="24">
                    <el-table
                            :data="list_doi_tac"
                            border
                            stripe
                            max-height="600"
                            empty-text="Không có bản ghi nào"
                    >
                        <!-- Checkbox chọn tất cả -->
                        <el-table-column
                                align="center"
                                fixed="left"
                                :width="columnWidths.checkbox"
                        >
                            <template #header>
                                <input type="checkbox" @change="chonTatCa" v-model="slectAll" />
                            </template>
                            <template #default="{ row }">

                                <input type="checkbox" @change="chonTungCai" v-model="lsDelete"
                                       :value="row.id" />
                            </template>
                        </el-table-column>

                        <!-- STT -->
                        <el-table-column
                                label="STT"
                                align="center"

                                :width="columnWidths.stt"
                        >
                            <template #default="{ $index }">
                                <p>{{ (currentPage - 1) * limit + $index + 1 }}</p>
                            </template>
                        </el-table-column>


                        <!-- Tên trường -->
                        <el-table-column
                                label="Tên trường"

                                :min-width="columnWidths.tenTruongHoc"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenTruongHoc }}</p>
                            </template>
                        </el-table-column>

                        <!-- Mã trường -->
                        <el-table-column
                                label="Mã trường"
                                :min-width="columnWidths.maTruongHoc"
                        >
                            <template #default="{ row }">
                                <p>{{ row.maTruongHoc }}</p>
                            </template>
                        </el-table-column>


                        <!-- Đơn vị -->
                        <el-table-column
                                label="Đơn vị"
                                :min-width="columnWidths.tenDonVi"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenDonVi }}</p>
                            </template>
                        </el-table-column>

                        <!-- Đối tác -->
                        <el-table-column
                                label="Đối tác"
                                :min-width="columnWidths.tenDoiTac"
                        >
                            <template #default="{ row }">
                                <p>{{ row.tenDoiTac }}</p>
                            </template>
                        </el-table-column>

                        <!-- Thao tác -->
                        <el-table-column
                                label="Thao tác"
                                align="center"
                                fixed="right"
                                :min-width="columnWidths.thaoTac"
                        >
                            <template #default="{ row }">
                                <el-tooltip content="Chỉnh sửa" placement="top">
                                    <i @click="showUpdate(row)" class="el-icon-edit"></i>
                                </el-tooltip>
                                <el-tooltip content="Xóa" placement="top">
                                    <i @click="setDeleItem(row)" class="el-icon-delete"></i>
                                </el-tooltip>
                            </template>
                        </el-table-column>


                    </el-table>

<!--                    <div class="table-responsive">-->
<!--                        <table class="table table-striped table-bordered table-hover">-->
<!--                            <thead>-->
<!--                                <tr style="background:rgb(228, 235, 245)">-->
<!--                                    <th class="text-center fixed-column fixedCol1">-->
<!--                                        <input type="checkbox" @change="chonTatCa" v-model="slectAll" />-->
<!--                                    </th>-->
<!--                                    <th class="text-center  fixed-column fixedCol2">-->
<!--                                        <p>STT</p>-->
<!--                                    </th>-->
<!--                                    <th class="text-center  fixed-column fixedCol3">-->
<!--                                        <p>Thao tác</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Mã trường</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Tên trường</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Đơn vị</p>-->
<!--                                    </th>-->
<!--                                    <th>-->
<!--                                        <p>Đối tác</p>-->
<!--                                    </th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody v-if="list_doi_tac.length===0">-->
<!--                                <tr>-->
<!--                                    <td class="text-center" colspan="22">-->
<!--                                        <p>Không có bản ghi nào</p>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                            <tbody v-else>-->
<!--                                <tr v-for="(tg,index) in list_doi_tac">-->
<!--                                    <td class="text-center fixed-column fixedCol1">-->
<!--                                        <input type="checkbox" @change="chonTungCai" v-model="lsDelete"-->
<!--                                            :value="tg.id" />-->
<!--                                    </td>-->
<!--                                    <td class="text-center fixed-column fixedCol2">-->
<!--                                        <p>{{ (currentPage - 1) * limit + index + 1 }}</p>-->
<!--                                    </td>-->
<!--                                    <td class="text-center fixed-column fixedCol3">-->
<!--                                        <div>-->
<!--                                            &lt;!&ndash; <el-button size="mini" type="warning" @click="showUpdate(tg)"> &ndash;&gt;-->

<!--                                            <el-tooltip content="Chỉnh sửa" placement="top">-->
<!--                                                <i @click="showUpdate(tg)" class="el-icon-edit"></i>-->
<!--                                            </el-tooltip>-->
<!--                                            &lt;!&ndash; </el-button> &ndash;&gt;-->
<!--                                            &lt;!&ndash; <el-button size="mini" type="danger" @click="setDeleItem(tg)">-->
<!--                                            </el-button> &ndash;&gt;-->
<!--                                            <el-tooltip content="Xóa" placement="top">-->
<!--                                                <i @click="setDeleItem(tg)" class="el-icon-delete"></i>-->
<!--                                            </el-tooltip>-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ tg.maTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ tg.tenTruongHoc }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ tg.tenDonVi }}</p>-->
<!--                                    </td>-->
<!--                                    <td>-->
<!--                                        <p>{{ tg.tenDoiTac }}</p>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
                </el-col>
                <el-col :span="24">
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                    </Page>
                    <create @close="show_creat=false" :show="show_creat" :doitac="ds_doi_tac"
                        @thanhcong="onCreatedData()">
                    </create>
                    <update :donvi="list_don_vi" :show="show_update" :caphoc="list_cap_hoc"
                        :doitac="ds_doi_tac" :item="data_update_doi_tac" @close="show_update=false"
                        @thanhcong="onCreatedData()">
                    </update>
                </el-col>
            </el-row>
        </div>
        <div v-if='false' class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <span style="padding-right:20px" v-if="lsDelete.length"><b>Đã chọn {{ lsDelete.length }}
                                        bản ghi</b></span>
                                <el-tooltip content="Xóa các bản ghi đã chọn" placement="top">
                                    <el-button class="bt-xoa" type='danger' v-if="lsDelete.length" size="mini"
                                        v-on:click.prevent="deleteUnit()"> Xóa
                                    </el-button>
                                </el-tooltip>
                                <el-tooltip content="Thêm mới" placement="top">
                                    <el-button class="bt-chinh" type="primary" size="mini"
                                        v-on:click.prevent="showCreat()"> Thêm mới
                                    </el-button>
                                </el-tooltip>
                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;" />
                        <div class="row">
                            <div class="col-sm-12">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hết danh sách -->
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import Page from '../ui/PagingCustom';
    import ThemMoiDoiTacTruong from './doiTacTruong/ThemMoi';
    import ChinhSuaDoiTacTruong from './doiTacTruong/ChinhSua';
    import dialog from '../../utils/dialog';
    import api from './../api';
    import ESelectVue from '../ui/ESelect.vue';
    import ElementUI from 'element-ui';
    import VueAlertify from "vue-alertify";
    import Breadcrumb from '../ui/Breadcrumb.vue';

    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
    export default {
        components: {
            "Page": Page,
            'create': ThemMoiDoiTacTruong,
            'update': ChinhSuaDoiTacTruong,
            'eselect': ESelectVue,
            Breadcrumb
        },
        watch: {
            lsDelete: function (newVal) {
                if (this.lsDelete.length == this.list_doi_tac.length) {
                    this.slectAll = true;
                }
            },
        },
        computed: {},
        data() {
            return {
                columnWidths: {
                    checkbox: 50,
                    stt: 50,
                    thaoTac: 100,
                    maTruongHoc: 120,
                    tenTruongHoc: 150,
                    tenDonVi: 150,
                    tenDoiTac: 150,
                },

                thongtin: JSON.parse(window.userInfo),
                data_update_doi_tac: {},
                show_creat: false,
                show_update: false,
                slectAll: false,
                capHoc: [],
                truongHoc: [],
                maDoiTac: "",
                total_rows: 0,
                start: 0,
                limit: 25,
                currentPage: 1,
                trangbatdau: false,
                lsDelete: [],
                list_don_vi: [],
                ds_truong_hoc: [],
                list_truong_hoc: [],
                list_doi_tac: [],
                ds_doi_tac: [],
                donVi: [],
                list_cap_hoc: [{
                    id: "",
                    name: "Chọn"
                }],
                list_cap_hoc_2: window.listCapHoc,
            }
        },

        mounted() {
            this.getDonVi();
            for (let i = 0; i < this.list_cap_hoc_2.length; i++) {
                this.list_cap_hoc.push(this.list_cap_hoc_2[i])
            }
            this.getTruongHoc();
            this.getDoiTac();
            this.getData();
        },

        watch: {
            donVi: function (newVal, oldVal) {
                this.chonDonVi();
            },
            capHoc: function (newVal, oldVal) {
                this.chonDonVi();
            }
        },
        methods: {
            // Tính toán độ rộng cột
            updateColumnWidths() {
                this.columnWidths = {
                    checkbox: 50,
                    stt: 50,
                    thaoTac: 100,
                    maTruongHoc: this.calculateWidth('maTruongHoc'),
                    tenTruongHoc: this.calculateWidth('tenTruongHoc'),
                    tenDonVi: this.calculateWidth('tenDonVi'),
                    tenDoiTac: this.calculateWidth('tenDoiTac'),
                };
            },

            // Hàm tính toán độ rộng cột dựa trên nội dung
            calculateWidth(columnKey) {
                const maxContentLength = this.list_doi_tac.reduce(
                    (max, row) => Math.max(max, (row[columnKey] || '').length),
                    0
                );
                return Math.max(100, maxContentLength * 10); // Mỗi ký tự chiếm 10px, tối thiểu 100px
            },

            chonTungCai() {
                if (this.lsDelete.length == this.list_doi_tac.length) {
                    this.slectAll = true;
                } else {
                    this.slectAll = false
                }
            },
            chonTatCa() {
                this.lsDelete = [];
                if (this.slectAll) {
                    for (let i = 0; i < this.list_doi_tac.length; i++) {
                        console.log("đối tác");
                        this.lsDelete.push(this.list_doi_tac[i].id)
                    }
                    console.log(JSON.stringify(this.lsDelete));
                } else {
                    this.lsDelete = []
                }
            },
            setDeleItem(item) {
                this.lsDelete = [item.id]
                this.deleteUnit();
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
            deleteUnit() {
                if (!this.lsDelete || this.lsDelete.length == 0) {
                    this.thongBao('error', 'Vui lòng chọn trường cần xóa.')
                    return;
                }
                let params = {
                    "ids": this.lsDelete
                }
                this.$confirm('Xác nhận xóa đối tác?', 'Xóa đối tác', {
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
                        rest_api.post("/csdlgd-admin/heThongDoiTacTruong/deleteMoreDoiTacTruong", params, (
                            data) => {
                            loading.close();
                            if (data.data.rc == 0) {
                                this.thongBao("success", data.data.rd)
                                this.getData();
                            } else {
                                this.thongBao("error", data.data.rd)
                            }
                        });
                    })
                    .catch(_ => {});
                // dialog.confirmDialog("Xác nhận xóa đối tác của trường?", "Đồng ý", () => {
                // });
            },
            showUpdate(e) {
                this.show_update = true;
                this.data_update_doi_tac = e;
            },
            onCreatedData() {
                // location.reload();
                this.show_update = false;
                this.show_creat = false;
                this.getData();
            },
            showCreat() {
                this.show_creat = true;
            },
            getData() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.slectAll = false;
                this.lsDelete = [];
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "maDoiTac": this.maDoiTac,
                    "maDonVis": this.donVi,
                    "maTruongs": this.truongHoc,
                    "capHoc": this.capHoc,
                };
                rest_api.post("/csdlgd-admin/heThongDoiTacTruong/danhSach", params, (data) => {
                    loading.close();
                    console.log("lấy đối tác thành công" + JSON.stringify(data));
                    this.list_doi_tac = [];
                    this.total_rows = 0;
                    if (data.data.rc == 0) {
                        this.list_doi_tac = data.data.rows;
                        this.total_rows = data.data.total;

                        this.updateColumnWidths()
                        // this
                        //     .$alertify
                        //     .success("Lấy dữ liệu thành công");
                    } else {
                        this
                            .$alertify
                            .error(data.data.rd);

                    }
                });
            },
            layLai(e) {
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData()
            },
            TruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
            chonCapHoc() {
                this.list_truong_hoc = [];
                this.truongHoc = [];
                this.getTruongHoc();
            },
            chonDonVi() {
                this.list_truong_hoc = [];
                this.truongHoc = [];
                this.getTruongHoc();
            },
            getTruongHoc() {
                // const loading = this.$loading({
                //     lock: true,
                //     text: 'Loading',
                //     spinner: 'el-icon-loading',
                //     background: 'rgba(0, 0, 0, 0.7)'
                // });
                let params = {
                    maDonVi: this.donVi,
                    capHoc: this.capHoc,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    // loading.close();
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenTruongHoc + " - [" + data.data.rows[i]
                                    .maTruongHoc + "]",
                                value: data.data.rows[i].maTruongHoc,
                            }
                            data_demo.push(obj);
                        }
                        this.ds_truong_hoc = data_demo;
                    }
                });
            },
            getDoiTac() {

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    "start": 0,
                    "limit": 9999,

                };
                rest_api.get("/internal-api/heThongDoiTac/filter", params, (data) => {
                    loading.close();
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenDoiTac + " - [" + data.data.rows[i].maDoiTac +
                                    "]",
                                value: data.data.rows[i].maDoiTac,
                            }
                            data_demo.push(obj);
                        }
                        this.ds_doi_tac = data_demo;
                    }
                });
            },
            getDonVi() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    let data_demo = [];
                    if (data.data.statusResponse == 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                tenDonVi: data.data.rows[i].tenDonVi + " - [" + data.data.rows[i].maDonVi +
                                    "]",
                                maDonVi: data.data.rows[i].maDonVi,
                            }
                            data_demo.push(obj);
                        }
                        this.list_don_vi = data_demo;
                    }
                });
            },
        }
    }

</script>

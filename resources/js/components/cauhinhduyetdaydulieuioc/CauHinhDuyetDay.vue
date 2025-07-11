<template>
    <div>

        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> KẾT CHUYỂN DỮ LIỆU LÊN IOC<span
                        class="kytu"> &raquo;</span> Cấu hình duyệt đẩy dữ liệu<span class="kytu">
                    </span></span>
            </div>
        </div>

        <div>
            <div class="card-bieu-do">
                <el-row :gutter="24" style="margin-bottom:0px !important;" class="">
                    <el-col :span="5">
                        <label>Loại đơn vị</label>
                        <el-select v-model="loai_don_vi" multiple filterable collapse-tags @change="chonLoaiDonVi"
                            placeholder="Chọn" no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                            <el-option v-for="item in list_loai_don_vi" :key="item.value" :label="item.name"
                                :value="item.value">
                            </el-option>
                        </el-select>
                    </el-col>
                    <el-col :span="8">
                        <label class="typo__label p-3">Chọn đơn vị</label>
                        <eselect style="width:100%" multiple collapseTags v-model="ma_don_vi" @change="chonDonVi"
                            :placeholder="'Chọn'" filterable :data="list_don_vi" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="5">
                        <label class="typo__label">Chọn cấp học</label>
                        <eselect style="width:100%" @change="chonCapHoc" multiple collapseTags v-model="cap_hoc"
                            :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                    </el-col>
                    <el-col :span="6">
                        <label class="typo__label">Chọn trường học</label>
                        <eselect style="width:100%" multiple collapseTags v-model="ma_truong_hoc"
                            :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                            :fields="['name','value']" />
                    </el-col>
                    <el-col :span="24" class="text-center">
                        <el-button plain type="success" size="mini" @click.prevent="checkTruocKhiTim()">Tìm kiếm
                        </el-button>
                    </el-col>
                </el-row>
            </div>
        </div>
        <el-row :gutter="24">
            <el-col :span="24" style="padding:0">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <el-row :gutter="24">
                            <el-col :span="24" class="reset">
                                <div class="text-right" style="padding-bottom:5px">
                                    <el-tooltip content="Thêm mới cấu hình duyệt đẩy" placement="top">
                                        <el-button plain type="primary" size="mini" @click.prevent="ThemMoiCauHinh()">
                                            Thêm mới
                                        </el-button>
                                    </el-tooltip>
                                </div>
                            </el-col>
                        </el-row>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr style="background:#e4ebf5">
                                        <th class="text-center">
                                            <p>STT</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Loại đơn vị</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Tên Phòng</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Mã trường</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Tên trường</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Trường được đẩy lên ioc</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Phòng được đẩy lên ioc</p>
                                        </th>
                                        <th class="text-center">
                                            <p>Thao tác</p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody v-if="list_cau_hinh.length==0">
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            <p>Không có bản ghi nào</p>
                                        </td>
                                    </tr>
                                </tbody>
                                <tbody v-else>
                                    <tr v-for="(ch,i) in list_cau_hinh" :key="i">
                                        <td class="text-center">
                                            <p>{{(currentPage-1)*limit + i+1}}</p>
                                        </td>
                                        <td>
                                            <p>{{getLoaiDonVi(ch.loaiDonVi)}}</p>
                                        </td>
                                        <td>
                                            <p>{{ch.tenDonVi}}</p>
                                        </td>
                                        <td>
                                            <p>{{ch.maTruongHoc}}</p>
                                        </td>
                                        <td>
                                            <p>{{ch.tenTruongHoc}}</p>
                                        </td>
                                        <td class="text-center">
                                            <p v-if="ch.truongDuocNopLenBo"><i style="color:blue"
                                                    class="fas fa-check"></i></p>
                                            <!-- <p v-else><i style="color:#DC0101" class="fas fa-times"></i></p> -->
                                        </td>
                                        <td class="text-center">
                                            <p v-if="ch.phongDuocNopLenBo"><i style="color:blue"
                                                    class="fas fa-check"></i></p>
                                            <!-- <p v-else><i style="color:#DC0101" class="fas fa-times"></i></p> -->
                                        </td>
                                        <td class="text-center">
                                            <!-- <a title="Chỉnh sửa" v-on:click.prevent="ShowUpdate(ch)"><i
                                            class="far fa-edit"></i></a> -->
                                            <!-- <a title="Xóa" v-on:click.prevent="DeleteCauHinh(ch.id)"><i
                                            class="fas fa-trash-alt"></i></a> -->

                                            <el-tooltip content="Xóa" placement="left">
                                                <el-button plain size="mini" icon="fas fa-trash-alt"
                                                    @click.prevent="DeleteCauHinh(ch.id)" type="danger">
                                                </el-button>
                                            </el-tooltip>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- Phân trang -->
                        <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                        <!-- Hết phân trang -->
                        <!-- Chỉnh sửa học sinh -->
                        <div v-if="show_update">
                            <chinhsua :item="dataUpdate" @close="show_update=false" @success="checkTruocKhiTim()">
                            </chinhsua>
                        </div>
                        <div v-if="show_add">
                            <themmoi @close="show_add=false" @success="checkTruocKhiTim()">
                            </themmoi>
                        </div>
                    </div>
                </div>
            </el-col>
        </el-row>
    </div>
</template>
<script>
    import constant from '../../utils/constant';
    import VueAlertify from "vue-alertify";
    import ElementUI from 'element-ui';
    import utils from '../../utils'
    import ESelectVue from '../ui/ESelect.vue';
    import ThemMoi from './ThemMoi';
    import ChinhSua from './ChinhSua';
    import Page from "../ui/PagingCustom";
    import rest_api from '../../utils/rest_api';
    Vue.use(ElementUI);
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
                    name: "Chọn",
                    value: ""
                }, {
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
                                this.thongBao("error", data.data.rd);
                            }
                        });
                    })
                    .catch(_ => {});
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

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
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
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy");
                            return;
                        } else {
                            this.list_cau_hinh = respon.data.rows;
                            this.total_rows = respon.data.total;
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công.")
                        }

                    } else {
                        this
                            .$alertify
                            .error(respon.data.rd);
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

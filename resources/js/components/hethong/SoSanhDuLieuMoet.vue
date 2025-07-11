<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> kết chuyển dữ liệu lên bộ<span
                        class="kytu"> &raquo;</span>SO sánh dữ liệu moet</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5 timkiem">
                <label class="typo__label">Chọn đơn vị:</label>
                <div>
                    <eselect style="width:100%" multiple collapseTags v-model="ma_don_vi" @change="chonDonVi"
                        :placeholder="'Chọn'" filterable :data="list_don_vi" :fields="['name','value']" />
                </div>
            </div>
            <div class="col-md-3 timkiem">
                <label class="typo__label">Cấp học</label>
                <div>
                    <eselect style="width:100%" @change="chonDonVi" multiple collapseTags v-model="cap_hoc"
                        :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                </div>
            </div>
            <div class="col-md-4 timkiem">
                <label class="typo__label">Trường học</label>
                <div>
                    <eselect style="width:100%" multiple collapseTags v-model="truong_hoc"
                        :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                        :fields="['name','value']" />
                </div>
            </div>
            <div class="col-md-5 timkiem">
                <label class="typo__label">Tiêu chí so sánh</label>
                <div>
                    <el-select v-model="tieu_chi_so_sanh" multiple filterable collapse-tags
                        placeholder="Chọn tiêu chí so sánh" no-data-text="Không có dữ liệu"
                        no-match-text="Không có dữ liệu phù hợp">
                        <el-option v-for="item in list_tieu_chi_so_sanh" :key="item.value" :label="item.name"
                            :disabled="item.disabled" :value="item.value">
                        </el-option>
                    </el-select>
                </div>
            </div>
            <div class="col-md-3 timkiem">
                <label class="typo__label">Tiêu chí bổ sung</label>
                <div>
                    <el-select v-model="tieu_chi_bo_sung" multiple filterable collapse-tags placeholder="Chọn đơn vị"
                        @change="chonTieuChiBoSung" no-data-text="Không có dữ liệu"
                        no-match-text="Không có dữ liệu phù hợp">
                        <el-option v-for="item in list_tieu_chi_so_sanh_bo_sung" :key="item.value" :label="item.name"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </div>
            </div>
        </div>
        <hr />
        <div class="row text-center">
            <button class="btn btn-success" @click.prevent="soSanh()">So sánh</button>
            <button class="btn btn-info" @click.prevent="checkTruocKhiTim()">Lịch sử so sánh</button>
            <button class="btn btn-primary" :disabled="this.lsDelete.length===0" @click.prevent="taiFileSoSanh()">Tải
                file so sánh</button>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <label>Danh sách lịch sử so sánh dữ liệu</label>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr style="background:#e4ebf5;text-align:center !important;">
                                <th class="cg">
                                    <label>
                                        <input type="checkbox" @change="chonTatCa" v-model="selectAll">
                                    </label>
                                    <span style="font-size: 10pt">Chọn tất cả</span>
                                </th>
                                <th class="cg">
                                    <p>STT</p>
                                </th class="cg">
                                <th class="cg">
                                    <p>Trường</p>
                                </th>
                                <th class="cg">
                                    <p>Mã trường</p>
                                </th>
                                <th class="cg">
                                    <p>Đơn vị quản lý</p>
                                </th>
                                <th class="cg">
                                    <p>Số hồ sơ trên CSDL Sở</p>
                                </th>
                                <th class="cg">
                                    <p>Số hồ sơ trên CSDL Bộ</p>
                                </th>
                                <th class="cg">
                                    <p>Số hồ sơ trên CSDL Sở chưa khớp thông tin</p>
                                </th>
                                <th class="cg">
                                    <p>Tỷ lệ chưa khớp</p>
                                </th>
                                <th class="cg">
                                    <p>Thời gian</p>
                                </th>
                                <th style="display: none;">
                                    <p>Hành động</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="list_du_lieu.length===0">
                            <tr>
                                <td class="text-center" colspan="11">
                                    <p>Không có bản ghi nào</p>
                                </td>
                            </tr>
                        </tbody>
                        <tbody v-else>
                            <tr v-for="(tt,index) in list_du_lieu" :key="index">
                                <td class="cg">
                                    <label>
                                        <input type="checkbox" @change="chonPhanTuXoa" v-model="lsDelete"
                                            :value="tt.uuid" />
                                    </label>
                                </td>
                                <td class="text-center">
                                    <p>{{ (currentPage - 1) * limit + index + 1 }}</p>
                                </td>
                                <td>
                                    <p>{{ tt.tenTruongHoc }}</p>
                                </td>
                                <td>
                                    <p>{{ tt.maTruongHoc }}</p>
                                </td>
                                <td>
                                    <p>{{ tt.tenDonVi }}</p>
                                </td>
                                <td>
                                    <p>{{ tt.soHsCsdl }}</p>
                                </td>
                                <td>
                                    <p>{{ tt.soHsMoet }}</p>
                                </td>
                                <td>
                                    <p>{{ tt.soHsChuaKhopThongTin }}</p>
                                </td>
                                <td>
                                    <p>{{ tt.tiLeHsChuaKhopThongTin }}</p>
                                </td>
                                <td>
                                    <p>{{ getTime(tt.createdTime) }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Page from "../ui/PagingCustom";
    import rest_api from '../../utils/rest_api';
    import timeutils from "../../utils/time_utils";
    import VueAlertify from "vue-alertify";
    import ElementUI from 'element-ui';
    import ESelectVue from '../ui/ESelect.vue';
    import constant from '../../utils/constant';
    import dialog from '../../../js/utils/dialog';
    Vue.use(ElementUI);
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
            Page,
            'eselect': ESelectVue,
        },
        watch: {
            lsDelete: function (newVal) {}
        },
        data() {
            return {
                selectAll: false,
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                ma_don_vi: [],
                cap_hoc: [],
                truong_hoc: [],
                tieu_chi_bo_sung: ["khongdau", "bodaucach", "dungunicode", "dungchuviethoa"],
                list_du_lieu: [],
                lsDelete: [],
                list_don_vi: [],
                trangbatdau: false,
                khongdau: true,
                bodaucach: true,
                dungunicode: true,
                dungchuviethoa: true,
                list_truong_hoc: [],
                list_cap_hoc: window.listCapHoc,
                tieu_chi_so_sanh: ['maTruongHoc', 'hoTen', 'ngaySinh'],
                list_tieu_chi_so_sanh: constant.list_tieu_chi_so_sanh,
                list_tieu_chi_so_sanh_bo_sung: constant.list_tieu_chi_so_sanh_bo_sung,
                thongtin: JSON.parse(window.userInfo),
            }
        },
        props: [],
        mounted() {
            console.log("Mount trong hs,gv" + JSON.stringify(this.list_cap_hoc));
            for (let i = 0; i < this.list_cap_hoc.length; i++) {
                this.list_cap_hoc[i].id = this.list_cap_hoc[i].id.toString();
            }
            console.log(this.list_cap_hoc);
            this.getDonVi();
            this.xemLichSu();
        },
        methods: {
            taiFileSoSanh() {
                dialog.confirmDialog(
                    "Xác nhận tải xuống file thông tin. Vui lòng chờ trong thời gian tải xuống.",
                    "Đồng ý",
                    () => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-moet-compare/compare-hoc-sinh/download-compare-single-file", this
                            .lsDelete, data => {
                                loading.close();
                                let a = document.createElement('a');
                                a.href = data.data.file;
                                document
                                    .body
                                    .appendChild(a);
                                a.click();
                                document
                                    .body
                                    .removeChild(a);
                            });
                    }
                );
            },
            chonPhanTuXoa() {
                if (this.lsDelete.length === this.list_du_lieu.length) {
                    this.selectAll = true;
                } else {
                    this.selectAll = false;
                }
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.xemLichSu();
            },
            checkTruocKhiTim() {
                this.lsDelete = [];
                this.selectAll = false;
                this.trangbatdau = !this.trangbatdau;
            },
            chonTatCa() {
                console.log("Chon tat ca");
                console.log(this.selectAll);
                if (this.selectAll) {
                    this.lsDelete = [];
                    for (let i = 0; i < this.list_du_lieu.length; i++) {
                        this
                            .lsDelete
                            .push(this.list_du_lieu[i].uuid);
                    }
                } else {
                    this.lsDelete = [];
                }
            },
            getTime(date) {
                return timeutils.convertTime(new Date(date));
            },
            getDonVi() {
                this.list_don_vi = [];
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    if (data.data.statusResponse === 0) {
                        for (let i = 0; i < data.data.rows.length; i++) {
                            let obj = {
                                name: data.data.rows[i].tenDonVi + ' - [' + data.data.rows[i].maDonVi + ']',
                                value: data.data.rows[i].maDonVi
                            }
                            this.list_don_vi.push(obj);
                        }
                    }
                });
            },
            chonDonVi() {
                this.truong_hoc = [];
                this.list_truong_hoc = [];
                this.getTruongHoc();
            },
            chonTieuChiBoSung() {
                console.log("chọn tiêu chí bổ sung.");
                console.log(JSON.stringify(this.tieu_chi_bo_sung))
                this.dungchuviethoa = false;
                this.dungunicode = false;
                this.bodaucach = false;
                this.khongdau = false;
                for (let i = 0; i < this.tieu_chi_bo_sung.length; i++) {
                    if (this.tieu_chi_bo_sung[i] == "khongdau") {
                        this.khongdau = true;
                    }
                    if (this.tieu_chi_bo_sung[i] == "bodaucach") {
                        this.bodaucach = true;
                    }
                    if (this.tieu_chi_bo_sung[i] == "dungunicode") {
                        this.dungunicode = true;
                    }
                    if (this.tieu_chi_bo_sung[i] == "dungchuviethoa") {
                        this.dungchuviethoa = true;
                    }
                }
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
            xemLichSu() {
                this.list_du_lieu = [];
                this.total_rows = 0;
                console.log("So sánh");
                let params = {
                    start: this.start,
                    limit: this.limit,
                    capHocList: this.cap_hoc,
                    maDonViList: this.ma_don_vi,
                    maTruongHocList: this.truong_hoc,
                    compareConfig: {
                        requiredFields: this.tieu_chi_so_sanh,
                        compoundToUnicode: this.dungunicode,
                        removeRepeatSpacesInName: this.bodaucach,
                        removeVietnameseMarks: this.khongdau,
                        upperCaseName: this.dungchuviethoa,
                    },
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-moet-compare/compare-hoc-sinh/search-compare-history", params, data => {
                    loading.close();
                    if (data.data.rc == 0) {
                        this.list_du_lieu = data.data.tableData;
                        this.total_rows = data.data.totalRows;
                    } else {
                        this.list_du_lieu = [];
                    }
                });
            },
            soSanh() {
                let params = {
                    start: this.start,
                    limit: this.limit,
                    capHocList: this.cap_hoc,
                    maDonViList: this.ma_don_vi,
                    maTruongHocList: this.truong_hoc,
                    compareConfig: {
                        requiredFields: this.tieu_chi_so_sanh,
                        compoundToUnicode: this.dungunicode,
                        removeRepeatSpacesInName: this.bodaucach,
                        removeVietnameseMarks: this.khongdau,
                        upperCaseName: this.dungchuviethoa,
                    },
                }
                rest_api.post("/csdlgd-moet-compare/compare-hoc-sinh/compare", params, data => {
                    if (data.data.rc == 0) {
                        this.$alertify.success(
                            "So sánh dữ liệu thành công. Vui lòng xem chi tiết tại lịch sử so sánh.");
                    } else {
                        this.$alertify.error(data.data.rd);
                    }
                }, 6000, true);
            }
        }
    }
</script>
<style scoped="scoped">
    .cg {
        text-align: center;
        vertical-align: middle;
    }
</style>

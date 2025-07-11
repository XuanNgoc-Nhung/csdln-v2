<template>
    <div>
        <el-dialog :title="nameReport" :before-close="truocKhiDong" :visible.sync="hien_thi">
            <el-row :gutter="20">
                <el-col :span="16">
                    <label for="">Đơn vị <span class="red">*</span></label>
                    <eselect style="width:100%" collapseTags v-model="donVi" @change="chonDonVi" multiple
                        :placeholder="'Chọn'" filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                </el-col>
                <el-col :span="8">
                    <label for="">Cấp học <span class="red">*</span></label>
                    <eselect style="width:100%" multiple collapseTags v-model="capHoc" @change="chonCapHoc"
                        :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                </el-col>
                <el-col :span="16">
                    <label for="">Trường học</label>
                    <eselect style="width:100%" multiple collapseTags v-model="truongHoc" :placeholder="'Chọn'"
                        filterable :data="ds_truong_hoc" :fields="['name','value']" />
                </el-col>
                <el-col :span="8">
                    <label for="">Năm học</label>
                    <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                        :data="list_nam_hoc" :fields="['name','id']" />
                </el-col>
                <el-col :span="8">
                    <label for="">Học kỳ</label>
                    <eselect style="width:100%" collapseTags v-model="hocKy" :placeholder="'Chọn'" filterable
                        :data="list_hoc_ky" :fields="['name','value']" />
                </el-col>
                <el-col :span="8">
                    <label for="">Giai đoạn</label>
                    <eselect style="width:100%" collapseTags v-model="giaiDoan" :placeholder="'Chọn'" filterable
                        :data="list_giai_doan" :fields="['name','value']" />
                </el-col>
            </el-row>
            <div class="row">
                <div class="col-md-12 text-center" style="padding-top:25px">
                    <el-button type="success" size="mini" @click.prevent="xemOnline">Xem online
                    </el-button>
                    <el-button type="primary" size="mini" @click.prevent="taiXuong">Tải xuống
                    </el-button>
                </div>
            </div>
        </el-dialog>
    </div>
</template>
<script>
    import ESelectVue from '../../ui/ESelect.vue';
    import rest_api from "../../../utils/rest_api";
    import constant from "../../../utils/constant";
    import VeeValidate, {
        Validator
    } from 'vee-validate';
    Vue.use(VeeValidate);
    $(document).ready(function () {});
    export default {
        props: [
            'item', 'show', 'nameReport'
        ],
        components: {
            'eselect': ESelectVue,
        },
        watch: {

            show: function (newVal) {
                console.log("show:" + newVal)
                if (newVal) {
                    this.hien_thi = true;
                } else {
                    this.hien_thi = false;
                }
            },
        },
        data() {
            return {
                hien_thi: false,
                baseLink: "/view-excel?path=",
                thongtin: JSON.parse(window.userInfo),
                list_cap_hoc: window.listCapHoc,
                date: new Date(),
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_don_vi: [],
                ds_truong_hoc: [],
                donVi: [],
                capHoc: [],
                hocKy: null,
                giaiDoan: null,
                truongHoc: [],
                namHoc: "",
                namHocHienTai: "",
                list_hoc_ky: [{
                    name: "Học kỳ I",
                    value: "1"
                }, {
                    name: "Học kỳ II",
                    value: "2"
                }, {
                    name: "Cả năm",
                    value: "3"
                }],
                list_giai_doan: [{
                    name: "Giữa kỳ I",
                    value: "GK1"
                }, {
                    name: "Cuối kỳ I",
                    value: "CK1"
                }, {
                    name: "Giữa kỳ II",
                    value: "GK2"
                }, {
                    name: "Cuối kỳ II",
                    value: "CK2"
                }],
            }
        },
        mounted: function () {
            this.getDonVi();
            this.getTruongHoc();
            this.namHoc = this.thongtin.namHocHienTai;
        },
        methods: {
            truocKhiDong(done) {
                this.$emit('close')
                done();
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
            xemOnline() {

                if (!this.donVi || this.donVi.length == 0) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin đơn vị.')
                    return;
                }
                if (!this.capHoc || this.capHoc.length == 0) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin cấp học.')
                    return;
                }
                if (!this.namHoc || this.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin năm học.')
                    return;
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    "capHoc": String(this.capHoc),
                    "hocKy": this.hocKy,
                    "maGiaiDoan": this.giaiDoan,
                    "maDonVis": this.donVi,
                    "maSo": this.thongtin.ma_so,
                    "maTruongs": this.truongHoc,
                    "namHoc": this.namHoc,
                    "id": this.item
                }
                if (this.hocKy && this.hocKy != "" && this.hocKy != null) {
                    params.hocKy = parseInt(this.hocKy);
                }
                rest_api.post("/csdlgd-analytic-api/download-excel/get-report-link", params, data => {

                    if (data.data.rc == 0) {
                        if (data.data.urlContext) {
                            this.thongBao('success', 'Đang mở trong thẻ mới...');
                            let uri = this.thongtin.tenMien + data.data.urlContext;
                            var d = new Date();
                            var n = d.getTime();
                            let url = this.baseLink + uri + '?time=' + n;
                            console.log("url")
                            console.log(url)
                            setTimeout(() => {
                                window.open(url, '_blank');
                                loading.close();
                            }, 1500);
                        } else {
                            this.thongBao('error', 'Báo cáo này chưa có dữ liệu');
                            loading.close();
                        }
                    } else {
                        this.thongBao('error',
                            'Mẫu báo cáo chưa được cấu hình điều kiện. Vui lòng chọn chức năng Cấu hình Template trước khi Xuất dữ liệu báo cáo!'
                        )
                        loading.close();
                    }
                });
            },
            taiXuong() {
                if (!this.donVi || this.donVi.length == 0) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin đơn vị.')
                    return;
                }
                if (!this.capHoc || this.capHoc.length == 0) {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin cấp học.')
                    return;
                }
                if (!this.namHoc || this.namHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung thông tin năm học.')
                    return;
                }
                this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                        confirmButtonText: 'Xuất',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        this.thongBao('success','Hệ thống đang tải xuống dữ liệu, vui lòng đợi trong ít phút.')
                        const loading = this.$loading({
                            lock: true,
                            text: 'Vui lòng chờ trong giây lát...',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        let params = {
                            "capHoc": String(this.capHoc),
                            "hocKy": this.hocKy,
                            "maGiaiDoan": this.giaiDoan,
                            "maDonVis": this.donVi,
                            "maSo": this.thongtin.ma_so,
                            "maTruongs": this.truongHoc,
                            "namHoc": this.namHoc,
                            "id": this.item
                        }
                        if (this.hocKy && this.hocKy != "" && this.hocKy != null) {
                            params.hocKy = parseInt(this.hocKy);
                        }
                        rest_api.post("/csdlgd-analytic-api/download-excel/get-report-link", params, data => {
                            if (data.data.rc == 0) {
                                if (data.data.urlContext) {
                                    this.thongBao('success', 'Đang lưu file...');
                                    let uri = this.thongtin.tenMien + data.data.urlContext;
                                    var d = new Date();
                                    var n = d.getTime();
                                    let url = uri + '?time=' + n;
                                    setTimeout(() => {
                                        window.open(url);
                                        loading.close();
                                    }, 500);
                                } else {
                                    loading.close();
                                    this.thongBao('error', 'Báo cáo này chưa có dữ liệu');
                                }
                            } else {
                                loading.close();
                                this.thongBao('error',
                                    'Mẫu báo cáo chưa được cấu hình điều kiện. Vui lòng chọn chức năng Cấu hình Template trước khi Xuất dữ liệu báo cáo!'
                                )
                            }
                        });
                    })
                    .catch(_ => {});
            },
            chonDonVi() {
                this.truongHoc = [];
                this.ds_truong_hoc = [];
                this.getTruongHoc();
            },
            chonCapHoc() {
                this.truongHoc = [];
                this.ds_truong_hoc = [];
                this.getTruongHoc();
            },
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.list_don_vi = [];
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    if (data.data.statusResponse == 0) {
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                tenDonVi: data_demo[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + data_demo[i].maDonVi + ']',
                                maDonVi: data_demo[i].maDonVi,
                            }
                            this.list_don_vi.push(obj)
                        }
                    } else {
                        this.thongBao('error', data.data.message)
                    }
                });
            },
            getTruongHoc() {
                this.ds_truong_hoc = [];
                const loading = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    capHoc: this.capHoc,
                    maDonVi: this.donVi,
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close()
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
                    } else {
                        this.ds_truong_hoc = [];
                    }
                });
            },
            reset() {},
            close() {
                this.reset();
                this.$emit('close');
            },
        }
    }

</script>
<style scoped="scoped">
    /*  */

    .row {
        margin: 0;
    }

</style>

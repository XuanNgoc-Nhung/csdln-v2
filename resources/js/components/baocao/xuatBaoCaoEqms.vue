<template>
    <div id="modal_thong_tin" ref="modal_thong_tin" class="modal fade">
        <div class="modal-dialog-fullscreen">
            <form @submit.prevent="themTruongHocSubmit">
                <div class="modal-content-fullscreen">
                    <div class="modal-header-fullscreen">
                        <h5 class="modal-title text-uppercase">Xuất báo cáo</h5>
                    </div>
                    <div class="modal-body-fullscreen">
                        <div class="row" style="display:flex">
                            <div class="col-md-3">
                                <label for="">Chọn đơn vị</label>
                                <el-select v-model="donVi" filterable placeholder="Chọn" @change="chonDonVi"
                                    no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp"
                                    v-validate="{ required: true }" name="don_vi">
                                    <el-option v-for="item in list_don_vi" :key="item.maDonVi" :label="item.tenDonVi"
                                        :value="item.maDonVi">
                                    </el-option>
                                </el-select>
                                <span v-if="show_msg"><span class="text-danger"
                                        v-show="errors.has('don_vi')">{{ errors.first('don_vi') }}</span></span>
                            </div>
                            <div class="col-md-2">
                                <label for="">Chọn cấp học</label>
                                <el-select v-model="capHoc" filterable="" v-validate="{ required: true }" name="cap_hoc"
                                    no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp"
                                    collapse-tags placeholder="Chọn" @change="chonCapHoc">
                                    <el-option v-for="item in list_cap_hoc_2" :key="item.value" :label="item.name"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                                <span v-if="show_msg"><span class="text-danger"
                                        v-show="errors.has('cap_hoc')">{{ errors.first('cap_hoc') }}</span></span>
                            </div>
                            <div class="col-md-3">
                                <label for="">Chọn trường học</label>
                                <el-select v-model="truongHoc" filterable collapse-tags placeholder="Chọn"
                                    no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp"
                                    v-validate="{ required: true }" name="truong_hoc">
                                    <el-option v-for="item in ds_truong_hoc" :key="item.value" :label="item.name"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                                <span v-if="show_msg"><span class="text-danger"
                                        v-show="errors.has('truong_hoc')">{{ errors.first('truong_hoc') }}</span></span>
                            </div>
                            <div class="col-md-2">
                                <label for="">Chọn năm học</label>
                                <el-select v-model="namHoc" filterable collapse-tags placeholder="Select"
                                    v-validate="{ required: true }" name="nam_hoc">
                                    <el-option v-for="item in list_nam_hoc" :key="item.id" :label="item.name"
                                        :value="item.id">
                                    </el-option>
                                </el-select>
                                <span v-if="show_msg"><span class="text-danger"
                                        v-show="errors.has('nam_hoc')">{{ errors.first('nam_hoc') }}</span></span>
                            </div>
                            <div class="col-md-2">
                                <label for="">Chọn học kỳ</label>
                                <el-select v-model="hocKy" filterable collapse-tags placeholder="Chọn"
                                    v-validate="{ required: true }" name="hoc_ky">
                                    <el-option v-for="item in list_hoc_ky" :key="item.value" :label="item.name"
                                        :value="item.value">
                                    </el-option>
                                </el-select>
                                <span v-if="show_msg"><span class="text-danger"
                                        v-show="errors.has('hoc_ky')">{{ errors.first('hoc_ky') }}</span></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" v-if="1==2">
                                <label for="">Loại hình đào tạo</label>
                                <el-select filterable collapse-tags placeholder="Chọn">
                                    <el-option v-for="item in list_loai_hinh_dao_tao" :key="item.value"
                                        :label="item.name" :value="item.value">
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="col-md-5" v-if="1==2" style="padding-top:25px">

                                <button type="button" class="btn btn-info" data-toggle="collapse"
                                    data-target="#demo">Đơn vị hiển thị lặp</button>
                                <div id="demo" class="collapse">

                                    <div class="bd">
                                        <v-jstree :data="cay_hien_thi" show-checkbox="show-checkbox" multiple="multiple"
                                            allow-batch="allow-batch" whole-row="whole-row" @item-click="itemClick">
                                        </v-jstree>

                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 text-center" style="padding-top:25px">
                                <button type="submit" class="btn btn-primary">Xem trước
                                </button>
                                <button @click.prevent="downLoad" :disabled="!taiXuong" class="btn btn-success">Tải
                                    xuống
                                </button>
                            </div>
                        </div>
                        <div class="row" style="padding-top:15px;">

                        </div>

                        <div class="row" style="padding-top:15px;" v-if="taiXuong">
                            <div class="col-md-12">

                                <el-tooltip class="item" effect="dark" content="Xem với màn hình lớn hơn"
                                    placement="top-start">
                                    <i class="el-icon-rank" @click.prevent="sangTrangLon" style="position:absolute;top:5px;left:20px;font-size:20px;"></i>
                                </el-tooltip>
                                <iframe :src="linkExcel" style="width:100%;height:-webkit-fill-available !important;"
                                    frameborder="1"></iframe>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-fullscreen">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import rest_api from "../../utils/rest_api";
    import constant from "../../utils/constant";
    import VueAlertify from "vue-alertify";
    import VeeValidate, {
        Validator
    } from 'vee-validate';
    Vue.use(VeeValidate);
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
    $(document).ready(function () {});
    export default {
        props: [
            'donvi', 'caphoc', 'truonghoc', 'show', 'item'
        ],
        watch: {
            show: function (newVal) {
                console.log("show:" + newVal)
                if (newVal) {
                    this.taiXuong = false;
                    this.linkExcel = "";
                    this.donVi = this.donvi;
                    this.capHoc = this.caphoc;
                    this.truongHoc = this.truonghoc;
                    this.show_msg = false;
                    $("#modal_thong_tin").modal();
                } else {

                    $("#modal_thong_tin").modal('hide');
                }
            },
        },
        data() {
            return {
                baseLink: "/view-excel?path=",
                linkExcel: "",
                taiXuong: "",
                show_msg: false,
                thongtin: JSON.parse(window.userInfo),
                list_cap_hoc: window.listCapHoc,
                date: new Date(),
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_don_vi: [],
                ds_truong_hoc: [],
                list_loai_hinh_dao_tao: JSON.parse(localStorage["danh_sach_loai_hinh_dao_tao_sme"]),
                list_cap_hoc_2: [{
                    name: "Chọn",
                    value: ""
                }],
                donVi: "",
                capHoc: "",
                truongHoc: "",
                namHoc: "",
                namHocHienTai: "",
                hocKy: "",
                list_hoc_ky: [{
                    name: "Chọn",
                    value: ""
                }, {
                    name: "Học kỳ I",
                    value: "1"
                }, {
                    name: "Học kỳ II",
                    value: "2"
                }, {
                    name: "Cả năm",
                    value: "3"
                }],
            }
        },
        mounted: function () {
            this.customMessage();
            $(this.$refs.modal_thong_tin).on("hidden.bs.modal", this.close);
            this.getDonVi();
            this.namHocHienTai = this
                .date
                .getFullYear();
            let thangNay = this
                .date
                .getMonth();
            thangNay = parseInt(thangNay) + 1;
            if (thangNay > 8) {
                console.log("tháng > 8");
            } else {
                this.namHocHienTai -= 1;
                console.log("tháng không lớn hơn 8");
            }
            console.log(this.namHocHienTai);
            console.log(this.list_nam_hoc);
            for (let i = 0; i < this.list_nam_hoc.length; i++) {
                if (this.list_nam_hoc[i].id == this.namHocHienTai) {
                    this.namHoc = this.list_nam_hoc[i].id;
                }
            }
            for (let i = 0; i < this.list_cap_hoc.length; i++) {
                let obj = {
                    name: this.list_cap_hoc[i].name,
                    value: this.list_cap_hoc[i].id
                }
                this.list_cap_hoc_2.push(obj);
            }
        },
        methods: {
            sangTrangLon(){
                let uri = this.linkExcel;
                window.open(uri, '_blank').focus();
            },
            downLoad() {
                window.location.href = this.taiXuong;
            },
            customMessage() {
                const dict = {
                    custom: {
                        don_vi: {
                            required: () => 'Đơn vị không thể trống'
                        },
                        cap_hoc: {
                            required: () => 'Cấp học không thể trống'
                        },
                        truong_hoc: {
                            required: () => 'Trường học không thể trống'
                        },
                        nam_hoc: {
                            required: () => 'Năm học không thể trống'
                        },
                        hoc_ky: {
                            required: () => 'Học kỳ không thể trống'
                        },
                    }
                };
                this
                    .$validator
                    .localize('vi', dict);
            },
            themTruongHocSubmit() {
                this.show_msg = true;
                this
                    .$validator
                    .validateAll()
                    .then(result => {
                        if (result) {
                            this.layDuLieuBaoCao();
                        }
                    });
            },
            layDuLieuBaoCao() {

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    "capHoc": String(this.capHoc),
                    "hocKy": parseInt(this.hocKy),
                    "maDonVi": this.donVi,
                    "maDonVis": [this.donVi],
                    "maSo": this.thongtin.ma_so,
                    "maTruongHoc": this.truongHoc,
                    "maTruongs": [this.truongHoc],
                    "namHoc": this.namHoc,
                    "id": this.item
                }
                rest_api.post("/csdlgd-analytic-api/download-excel/get-report-link", params, data => {
                    loading.close();
                    if (data.data.rc == 0) {
                        if (data.data.urlContext) {
                            this.linkExcel = this.baseLink + this.thongtin.tenMien + data.data.urlContext;
                            this.taiXuong = data.data.urlContext;
                            // this.linkExcel = "https://dongbo.csdl.edu.vn/file/temporary/thong-ke-so-luong-can-bo-quan-ly-giao-vien-nhan-vien-1612235454455.xlsx"; 
                        } else {
                            this
                                .$alertify
                                .error("Báo cáo này chưa có dữ liệu")
                        }
                    } else {
                        this
                            .$alertify
                            .error(
                                "Mẫu báo cáo chưa được cấu hình điều kiện. Vui lòng chọn chức năng Cấu hình Template trước khi Xuất dữ liệu báo cáo!"
                            )
                    }
                });
            },
            chonDonVi() {
                this.truongHoc = "";
                this.ds_truong_hoc = [];
                this.getTruongHoc();
            },
            chonCapHoc() {
                this.truongHoc = "";
                this.ds_truong_hoc = [];
                this.getTruongHoc();
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
                    let data_demo = [{
                        tenDonVi: "Chọn",
                        maDonVi: ""
                    }];
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
            getTruongHoc() {
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                let params = {
                    capHoc: [],
                    maDonVi: [],
                };
                if (this.donVi != "") {
                    params.maDonVi = [this.donVi]
                }
                if (this.capHoc != "") {
                    params.capHoc = [this.capHoc]
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    let data_demo = [{
                        name: "Chọn",
                        value: ""
                    }];
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
                        console.log(JSON.stringify(this.ds_truong_hoc.length));
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
    .row {
        margin: 0;
    }

</style>

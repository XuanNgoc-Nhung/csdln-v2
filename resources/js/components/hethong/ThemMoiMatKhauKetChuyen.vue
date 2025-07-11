<template>
    <div
        id="themmoi_matkhau_ketchuyen"
        ref="themmoi_matkhau_ketchuyen"
        class="modal fade">
        <div class="modal-dialog" style="width:75%">
            <div class="modal-content">
                <form role="form">
                    <div class="modal-header">
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-hidden="true"
                            v-on:click="close()">&times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm Mới thông Tin</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <form role="form">
                            <div class="row space20">
                                <div class="col-md-6">
                                    <label>Đơn vị:</label>
                                    <!--                                    <select v-model="madonvi" class="form-control" @change="onDonViChange()">-->
                                    <!--                                        <option value="">Chọn đơn vị</option>-->
                                    <!--                                        <option v-for="dv in listDonVi" :value="dv.maDonVi">{{dv.tenDonVi}}</option>-->
                                    <!--                                    </select>-->
                                    <div>
                                        <multiselect
                                            v-model="danhSachDonVi"
                                            :options="listDonVi"
                                            :close-on-select="true"
                                            :clear-on-select="false"
                                            :preserve-search="false"
                                            deselectLabel=""
                                            selectLabel=""
                                            selectedLabel=""
                                            :custom-label="setNameDonVi"
                                            placeholder="Chọn đơn vị"
                                            label="maDonVi"
                                            @close="ChonDonVi"
                                            track-by="tenDonVi">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Cấp học:</label>
                                    <select class="form-control" v-model="capHoc" @change="onCapHocChange()">
                                        <option value="">Chọn cấp học</option>
                                        <option v-for="ch in list_cap_hoc" :value="ch.id">{{ch.name}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row space20">
                                <div class="col-md-6">
                                    <label>
                                        Trường học (<span style="color:#DC0101">*</span>)
                                    </label>
                                    <div>
                                        <multiselect
                                            v-model="danhSachTruongHoc"
                                            :options="listTruongHoc"
                                            :close-on-select="true"
                                            :clear-on-select="false"
                                            :preserve-search="false"
                                            deselectLabel="Đã chọn"
                                            selectLabel="Chưa chọn"
                                            selectedLabel="Đã chọn"
                                            :custom-label="setNameTruongHoc"
                                            placeholder="Chọn trường học"
                                            label="maTruongHoc"
                                            @close="ChonTruongHoc()"
                                            track-by="tenTruongHoc">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>
                                        Tên đăng nhập (<span style="color:#DC0101">*</span>)
                                    </label>
                                    <input
                                        @keypress.enter.prevent=""
                                        v-model="tenDangNhap"
                                        type="text"
                                        class="form-control"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>
                                        Mật khẩu (<span style="color:#DC0101">*</span>)
                                    </label>
                                    <input
                                        @keypress.enter.prevent=""
                                        v-model="matKhau"
                                        type="text"
                                        class="form-control"/>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                        <button type="submit" @click.prevent="AddInfo()" class="btn btn-primary">Thêm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>

    import Multiselect from 'vue-multiselect'
    import rest_api from "../../utils/rest_api";
    import array_util from "../../utils/array_utils";
    import time_utils from "../../utils/time_utils";
    import utils from "../../utils";
    import api from "../api";
    import VeeValidate, {Validator} from "vee-validate";
    import dialog from "../../utils/dialog";
    Vue.use(VeeValidate);
    $(document).ready(function () {
        console.log("ready!");
    });
    export default {
        props: [
            "user", "show"
        ],
        components: {Multiselect,},
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    //this.reset();
                    $("#themmoi_matkhau_ketchuyen").modal();
                } else {
                    $("#themmoi_matkhau_ketchuyen").modal("hide");
                }
            },
            user: function (newVal, oldVal) {
                console.log("tạo:" + JSON.stringify(newVal));
                this.thongtindangnhap = newVal;
                this.getDonVi();
            }
        },
        data() {
            return {
                listDonVi: [],
                list_cap_hoc: window.listCapHoc,
                listTruongHoc: [],
                thongtindangnhap: {},
                danhSachDonVi: "",
                danhSachTruongHoc: "",
                madonvi: "",
                capHoc: "",
                ma_truong_hoc: "",
                tenDangNhap: "",
                matKhau: ""
            };
        },
        mounted: function () {
            this.getTruongHoc();
            $(this.$refs.themmoi_matkhau_ketchuyen).on("hidden.bs.modal", this.close);
        },
        methods: {
            ChonTruongHoc() {
                this.ma_truong_hoc = "";
                if (this.danhSachTruongHoc) {
                    this.ma_truong_hoc = this.danhSachTruongHoc.maTruongHoc;
                }
            },

            setNameTruongHoc({tenTruongHoc, maTruongHoc}) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            ChonDonVi() {
                this.madonvi = "";
                this.ma_truong_hoc = "";
                this.listTruongHoc = [];
                this.danhSachTruongHoc = "";
                if (this.danhSachDonVi) {
                    this.madonvi = this.danhSachDonVi.maDonVi;
                    this.getTruongHoc();
                }
            },
            // định nghĩa cho đơn vị
            setNameDonVi({tenDonVi, maDonVi}) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            close() {
                console.log("close modal");
                this.$emit("close");
            },
            reset() {
            },
            getDonVi() {
                let params = {
                    start: 0,
                    limit: 9999,
                    maTinhThanh: this.thongtindangnhap.province
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, data => {
                    loading.close();
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.listDonVi);
                        this.listDonVi = data.data.rows;
                    }
                });
            },
            onDonViChange() {
                array_util.clearArrays(this.ds_truong_hoc);
                this.ma_truong_hoc = "";
                if (this.madonvi == "") {
                    return;
                }
                this.getTruongHoc();
            },
            onCapHocChange() {
                this.ma_truong_hoc = "";
                this.listTruongHoc = [];
                this.danhSachTruongHoc = "";
                this.getTruongHoc();
            },
            AddInfo() {
                console.log("MÃ trường:" + this.ma_truong_hoc + "mật khẩu:" + this.matKhau);
                if (!this.ma_truong_hoc) {
                    this
                        .$alertify
                        .error('Thiếu trường học.');
                    return;
                }
                ;
                if (!this.matKhau) {
                    this
                        .$alertify
                        .error('Thiếu mật khẩu');
                    return;
                }
                ;
                utils.confirmDialog("Xác nhận thêm thông tin", "Thêm", () => {
                    let params = {
                        maTruong: this.ma_truong_hoc,
                        matKhau: this.matKhau,
                        tenDangNhap: this.tenDangNhap
                    };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                    rest_api.post("/csdlgd-push/KetChuyenDL/createMKKC", params, data => {
                        loading.close();
                        if (data.data.code === 200) {
                            console.log("Thành công");
                            this
                                .$alertify
                                .success('Thêm thành công');
                        } else {
                            this
                                .$alertify
                                .error(data.data.message);
                            return;
                        }
                    });
                })
            },
            getTruongHoc() {
                let params = {
                    start: 0,
                    limit: 1000,
                    madonvi: this.madonvi
                };
                if (this.capHoc) {
                    params.caphoc = parseInt(this.capHoc);
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmTruongHoc/filter", params, data => {
                    loading.close();
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.listTruongHoc);
                        this.listTruongHoc = data.data.rows;
                    }
                });
            }
        }
    };
</script>
<style scoped="scoped">
    @import "../../../../node_modules/selectwithsearch.css";

    .form-check-inline {
        display: inline-flex;
        align-items: center;
        padding-left: 0;
        margin-right: 0.75rem;
    }

    .form-check-inline label {
        margin-bottom: 0;
        margin-left: 5px;
        position: relative;
        top: 2px;
    }
</style>

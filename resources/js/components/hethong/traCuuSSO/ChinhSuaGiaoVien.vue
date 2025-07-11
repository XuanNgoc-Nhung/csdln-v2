<template>
    <div id="modal_update_giao_vien_sso" ref="modal_update_giao_vien_sso" class="modal fade">
        <div class="modal-dialog" style="width: 90%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Chỉnh sửa thông tin
                    </h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <label class="typo__label">Mã cán bộ <sup><span>(<span
                                            style="color:#DC0101">*</span>)</span></sup></label>
                            <input v-model="maCanBo" type="text" placeholder="Nhập..." class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Họ tên <sup><span>(<span
                                            style="color:#DC0101">*</span>)</span></sup></label>
                            <input v-model="hoTen" type="text" placeholder="Nhập..." class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Giới tính:</label>
                            <select v-model="gioiTinh" class="form-control">
                                <option value=''>Chọn giới tính</option>
                                <option value='1'>Nam
                                </option>
                                <option value='0'>Nữ</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Ngày sinh:</label>
                            <input v-model="ngaySinh" type="text" placeholder="Nhập..." class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Số CMND:</label>
                            <input v-model="cMND" type="text" placeholder="Nhập..." class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Email:</label>
                            <input v-model="email" type="text" placeholder="Nhập..." class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Số điện thoại:</label>
                            <input v-model="soDienThoai" type="text" placeholder="Nhập..." class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Địa chỉ:</label>
                            <input v-model="diaChi" type="text" placeholder="Nhập..." class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Tỉnh thành:</label>
                            <el-select v-model="maTinhThanh" filterable collapse-tags placeholder="Chọn đơn vị"
                                @change="chonTinhThanh()" no-data-text="Không có dữ liệu"
                                no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in ds_tinh_thanh" :key="item.value" :label="item.name"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Quận huyện:</label>
                            <el-select v-model="maQuanHuyen" filterable collapse-tags placeholder="Chọn quận huyện"
                                no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in ds_quan_huyen" :key="item.value" :label="item.name"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Mã môn học:</label>
                            <input v-model="maMonHoc" type="text" placeholder="Nhập..." class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Chủ nhiệm lớp:</label>
                            <select v-model="chuNhiemLop" class="form-control">
                                <option value="">Không</option>
                                <option value="1">Có</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="typo__label">Trường học <sup><span>(<span
                                            style="color:#DC0101">1</span>)</span></sup></label>
                            <!-- <input v-model="maTruongHoc" type="text" placeholder="Nhập..."
                                class="form-control" /> -->
                            <el-select v-model="maTruongHoc" filterable collapse-tags placeholder="Chọn trường học"
                                no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in list_truong_hoc" :key="item.value" :label="item.name"
                                    :value="item.value">
                                </el-option>
                            </el-select>
                        </div>
                        <!-- <div class="col-md-3 ">
                            <label class="typo__label">Năm học </label>
                            <el-select v-model="namHoc" filterable collapse-tags placeholder="Chọn năm học"
                                no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                <el-option v-for="item in list_nam_hoc" :key="item.id" :label="item.name"
                                    :value="item.id">
                                </el-option>
                            </el-select>
                        </div> -->
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="pxn-col col-md-6 text-left">
                            <span style="color:blue">
                                <b>Ghi chú:</b>
                            </span>
                            <ul>
                                <li><span class="red">*</span>:<span><i>thông tin bắt buộc.</i></span></li>
                                <li><span class="red" style="font-weight:bold">1</span>:<span><i>để lấy mã trường vui
                                            lòng xem tại mục <a href="/category/schools" title="Tra cứu trường học"
                                                target="_blank">Tra cứu trường học</a>.</i></span></li>
                            </ul>
                        </div>
                        <div class="pxn-col col-md-6">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                            </button>
                            <button type="submit" @click.prevent="ChinhSuaNguoiDung()"
                                class="btn btn-primary">Sửa</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    // import utils from '../../utils'
    import api from '../../api';
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../../utils/rest_api';
    import utils from '../../../utils'
    import constant from "../../../utils/constant";
    import ElementUI from 'element-ui';
    Vue.use(ElementUI);
    export default {
        props: ['item', 'show'],
        components: {
            Multiselect,
        },
        data() {
            return {
                // Dữ liệu chỉnh sửa:
                list_nam_hoc: constant.LIST_YEARS_FULL,
                maCanBo: "",
                canBoTheoNamId: "",
                actor: "",
                cMND: "",
                capDonVi: "",
                diaChi: "",
                email: "",
                gioiTinh: "",
                hoTen: "",
                maLoaiTaiKhoan: "",
                maQuanHuyen: "",
                maTinhThanh: "",
                namHoc: "",
                maMonHoc: "",
                ngaySinh: "",
                maTruongHoc: "",
                chuNhiemLop: "",
                soDienThoai: "",
                // Thông tin tài khoản đăng nhập
                thongtin: {},
                // Danh sách tỉnh thành
                ds_tinh_thanh: [{
                    name: "Chọn tỉnh thành",
                    value: ""
                }],
                ds_quan_huyen: [],
                list_truong_hoc: [],
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.getTinhThanh();
            this.getTruongHoc();
            $(this.$refs.modal_update_giao_vien_sso).on("hidden.bs.modal", this.close);
        },
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.bindDuLieu();
                    if (this.item.maTthanhThtru) {
                        this.getQuanHuyen(this.item.maTthanhThtru);
                    }
                    $("#modal_update_giao_vien_sso").modal();
                } else {
                    $("#modal_update_giao_vien_sso").modal('hide');
                }
            },
        },
        methods: {
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: [],
                    capHoc: []
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    console.log("lấy trường");
                    if (data.data.code == 200) {
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                name: data_demo[i].tenTruongHoc + " - [" + data_demo[i].maTruongHoc + "]",
                                value: data_demo[i].maTruongHoc
                            }
                            this.list_truong_hoc.push(obj)
                        }
                    }
                });
            },
            // Hàm sửa cán bộ
            ChinhSuaNguoiDung() {

                const params = {
                    "actor": this.thongtin.username,
                    "cMND": this.cMND,
                    "can_bo_theo_nam_id": this.canBoTheoNamId,
                    "diaChi": this.diaChi,
                    "email": this.email,
                    "gioiTinh": this.gioiTinh,
                    "hoTen": this.hoTen,
                    "maGiaoVien": this.maCanBo,
                    "maMonDay": this.maMonDay,
                    "maQuanHuyen": this.maQuanHuyen,
                    "maTinhThanh": this.maTinhThanh,
                    "maTruongHoc": this.maTruongHoc,
                    "namHoc": this.namHoc,
                    "ngaySinh": this.ngaySinh,
                    "soDienThoai": this.soDienThoai,
                };
                if (this.chuNhiemLop) {
                    params.isChuNhiemLop = 1;
                } else {
                    params.isChuNhiemLop = 0;
                }
                console.log("pr Chỉnh sửa cán bộ:" + JSON.stringify(params));

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/sso/editGiaoVien", params, (response) => {
                    loading.close();
                    console.log("Chỉnh sửa trả về:" + JSON.stringify(response.data));
                    if (response.data.rc === 0) {
                        this.$alertify.success("Chỉnh sửa cán cán bộ thành công.");
                        this.$emit('success');
                        this.$emit('close');

                    } else {
                        this.$alertify.error("Thất bại." + response.data.rd);
                    }
                });
                // utils.confirmDialog("Xác nhận chỉnh sửa dữ liệu", "Chỉnh sửa", () => {
                // })
            },
            // định nghĩa cho năm học
            setNameNamHoc({
                name
            }) {
                return `${name}`
            },
            chonTinhThanh() {
                console.log("chọn tỉnh thành");
                this.maQuanHuyen = "";
                this.ds_quan_huyen = [];
                this.getQuanHuyen(this.maTinhThanh);
            },
            getTinhThanh() {
                console.log("Lấy danh sách tỉnh thành");
                const uri = "/api_lay_danh_sach_tinh_thanh";
                let params = {
                    "start": '0',
                    "limit": '100',
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                api.get(uri, params, (respon) => {
                    loading.close();
                    let ds_tinh = respon.data.rows;
                    for (let i = 0; i < ds_tinh.length; i++) {
                        let obj = {
                            name: ds_tinh[i].tenTinhThanh,
                            value: ds_tinh[i].maTinhThanh,
                        }
                        this.ds_tinh_thanh.push(obj);
                    }
                })
            },
            getQuanHuyen(e) {
                const uri = "/api_lay_danh_sach_quan_huyen";
                let params = {
                    "start": '0',
                    "limit": '999',
                    "ma_tinhthanh": e,
                };

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                api.get(uri, params, (respon) => {
                    loading.close();
                    let ds_huyen = respon.data.rows;

                    for (let i = 0; i < ds_huyen.length; i++) {
                        let obj = {
                            name: ds_huyen[i].tenQuanHuyen,
                            value: ds_huyen[i].maQuanHuyen,
                        }
                        this.ds_quan_huyen.push(obj);
                    }
                });
                this.ma_quanhuyen = '';
            },
            bindDuLieu() {
                this.maCanBo = this.item.maGiaoVien;
                this.cMND = this.item.soCmnd;
                this.capDonVi = this.item.capDonVi;
                this.diaChi = this.item.dchiThtru;
                this.email = this.item.email;
                this.gioiTinh = this.item.gioiTinh;
                this.hoTen = this.item.tenGiaoVien;
                this.maLoaiTaiKhoan = this.item.maLoaiTaiKhoan;
                this.canBoTheoNamId = this.item.canBoTheoNamId;
                this.maQuanHuyen = this.item.maQhuyenThtru;
                this.maTinhThanh = this.item.maTthanhThtru;
                this.namHoc = this.item.namHoc;
                this.maMonHoc = this.item.maMonHoc;
                this.ngaySinh = this.item.ngaySinh;
                this.maTruongHoc = this.item.maTruongHoc;
                this.soDienThoai = this.item.soDienThoaiDiDong;
                if (this.item.chuNhiemLop == "1" || this.item.chuNhiemLop == 1) {
                    this.chuNhiemLop = "1";
                } else {
                    this.chuNhiemLop = "";
                }
            },
            close() {
                this.$emit('close');
            }
        }
    }

</script>
<style scoped="scoped">
    .red {
        color: #DC0101
    }

</style>

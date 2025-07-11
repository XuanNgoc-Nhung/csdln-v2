<template>
    <div id="modal_update_cbps_sso" ref="modal_update_cbps_sso" class="modal fade">
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
                            <input v-model="maCanBo" type="text" placeholder="Nhập..."
                                class="form-control" />
                        </div>
                        <div class="col-md-3">
                            <label class="typo__label">Họ tên <sup><span>(<span
                                            style="color:#DC0101">*</span>)</span></sup></label>
                            <input v-model="hoTen" type="text" placeholder="Nhập..."
                                class="form-control" />
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
                            <input v-model="ngaySinh" type="text" placeholder="Nhập..."
                                class="form-control" />
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
                            <input v-model="soDienThoai" type="text" placeholder="Nhập..."
                                class="form-control" />
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
                            <label class="typo__label">Loại tài khoản:</label>
                            <input v-model="jobPosition" type="text" placeholder="Nhập..."
                                class="form-control" />
                        </div>
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
                                <!-- <li><span class="red" style="font-weight:bold">1</span>:<span><i>để lấy mã trường vui lòng xem tại mục <a href="/category/schools" title="Tra cứu trường học" target="_blank">Tra cứu trường học</a>.</i></span></li> -->
                            </ul>
                        </div>
                        <div class="pxn-col col-md-6">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                            </button>
                            <button type="submit" @click.prevent="ChinhSuaNguoiDung()" class="btn btn-primary">Sửa</button>
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
        props: ['item','show'],
        components: {
            Multiselect,
        },
        data() {
            return {
                // Dữ liệu chỉnh sửa:
                list_nam_hoc: constant.LIST_YEARS_FULL,
                maCanBo: "",
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
                jobPosition: "",
                ngaySinh: "",
                soDienThoai: "",
                // Thông tin tài khoản đăng nhập
                thongtin: {},
                // Danh sách tỉnh thành
                ds_tinh_thanh: [{
                    name: "Chọn tỉnh thành",
                    value: ""
                }],
                ds_quan_huyen: [],
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.getTinhThanh();
            $(this.$refs.modal_update_cbps_sso).on("hidden.bs.modal", this.close);
        },
        watch: {

            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.bindDuLieu();
                    if (this.item.maTinh) {
                        this.getQuanHuyen(this.item.maTinh);
                    }
                    $("#modal_update_cbps_sso").modal();
                } else {
                    $("#modal_update_cbps_sso").modal('hide');
                }
            },
        },
        methods: {
            // Hàm sửa cán bộ
            ChinhSuaNguoiDung() {
                
                const params = {
                        "actor": this.thongtin.username,
                        "cMND": this.cMND,
                        "diaChi": this.diaChi,
                        "email": this.email,
                        "gioiTinh": this.gioiTinh,
                        "hoTen": this.hoTen,
                        "maCanBo": this.maCanBo,
                        "maLoaiTaiKhoan": this.jobPosition,
                        "maQuanHuyen": this.maQuanHuyen,
                        "maTinhThanh": this.maTinhThanh,
                        "namHoc": this.namHoc,
                        "ngaySinh": this.ngaySinh,
                        "soDienThoai": this.soDienThoai,
                    };
                    console.log("pr Chỉnh sửa cán bộ: phòng sở: " + JSON.stringify(params));
                    rest_api.post("/csdlgd-admin/sso/editCanBoPhongSo", params, (response) => {
                        console.log("Chỉnh sửa trả về:" + JSON.stringify(response.data));
                        if (response.data.rc === 0) {
                            this.$alertify.success("Chỉnh sửa dữ liệu thành công.");
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
                api.get(uri, params, (respon) => {
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
                api.get(uri, params, (respon) => {
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
                this.maCanBo = this.item.maCanBo;
                this.cMND = this.item.soCmnd;
                this.capDonVi = this.item.capDonVi;
                this.diaChi = this.item.diaChi;
                this.email = this.item.email;
                this.gioiTinh = this.item.gioiTinh;
                this.hoTen = this.item.tenCanBo;
                this.maLoaiTaiKhoan = this.item.maLoaiTaiKhoan;
                this.maQuanHuyen = this.item.maHuyen;
                this.maTinhThanh = this.item.maTinh;
                this.namHoc = this.item.namHoc;
                this.jobPosition = this.item.jobPosition;
                this.ngaySinh = this.item.ngaySinh;
                this.soDienThoai = this.item.soDienThoaiDiDong;
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

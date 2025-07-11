<template>
    <div>
        <el-dialog title="Chỉnh sửa thông tin học sinh" width="60%" top="5vh" :visible.sync="hien_thi_modal"
            @close="dongModal">
            <el-row :gutter="20">
                <el-col :span="6">
                    <label>Mã học sinh </label>
                    <input v-model="thongTinChinhSua.maHocSinh" type="text" disabled placeholder="Mã học sinh"
                        class="form-control" />
                </el-col>
                <el-col :span="6">
                    <label>Tên học sinh </label>
                    <input v-model="thongTinChinhSua.hoTen" type="text" placeholder="Tên học sinh"
                        class="form-control" />
                </el-col>
                <el-col :span="6">
                    <label>Ngày sinh </label>
                    <date-picker v-model="thongTinChinhSua.ngaySinh" placeholder="Chọn ngày" valueType="format"
                        value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                    </date-picker>
                </el-col>
                <el-col :span="6">
                    <label>Giới tính </label>
                    <eselect style="width:100%" collapseTags v-model="thongTinChinhSua.gioiTinh" :placeholder="'Chọn'"
                        filterable :data="list_gioi_tinh" :fields="['name','value']" />
                </el-col>
                <el-col :span="6">
                    <label>Số CMND </label>
                    <input v-model="thongTinChinhSua.cMND" type="text" placeholder="Số CMND" class="form-control" />
                </el-col>
                <el-col :span="6">
                    <label>Địa chỉ </label>
                    <input v-model="thongTinChinhSua.diaChi" type="text" placeholder="Địa chỉ" class="form-control" />
                </el-col>
                <el-col :span="6">
                    <label>Số điện thoại </label>
                    <input v-model="thongTinChinhSua.soDienThoai" type="text" placeholder="Số điện thoại"
                        class="form-control" />
                </el-col>
                <el-col :span="6">
                    <label>Lớp học <sup style="color:#DC0101">1</sup></label>
                    <input v-model="thongTinChinhSua.lopHoc" type="text" placeholder="Lớp học" class="form-control" />
                </el-col>
                <el-col :span="6">
                    <label>Khối học</label>
                    <eselect style="width:100%" collapseTags v-model="thongTinChinhSua.khoiHoc" :placeholder="'Chọn'"
                        filterable :data="danh_sach_khoi_hoc" :fields="['name','id']" />
                </el-col>
                <el-col :span="12">
                    <label>Trường học <sup style="color:#DC0101">2</sup> </label>
                    <eselect style="width:100%" collapseTags v-model="thongTinChinhSua.maTruongHoc"
                        :placeholder="'Chọn'" filterable :data="list_truong_hoc" :fields="['name','value']" />
                </el-col>
            </el-row>
            <el-row :gutter="24">
                <el-col :span="24">
                    <span style="color:blue">
                        <b>Ghi chú:</b>
                    </span>
                    <ul>
                        <li><span class="red" style="font-weight:bold">1 </span> :<span><i>để lấy mã lớp vui
                                    lòng xem tại mục <a href="/Look-up-classes" title="Tra cứu lớp học"
                                        target="_blank">Tra cứu lớp học</a>.</i></span></li>
                        <li><span class="red" style="font-weight:bold"> 2 </span> :<span><i>để lấy mã trường vui
                                    lòng xem tại mục <a href="/category/schools" title="Tra cứu trường học"
                                        target="_blank">Tra cứu trường học</a>.</i></span></li>
                    </ul>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" @click="dongModal">Đóng</el-button>
                <el-button size="mini" type="primary" @click="confirmChinhSua">Chỉnh sửa</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    import DatePicker from 'vue2-datepicker';
    import rest_api from '../../../utils/rest_api';
    import ESelectVue from '../../ui/ESelect.vue';
    import 'vue2-datepicker/index.css';

    export default {
        props: ['item', 'show', 'namhoc', 'listKhoiHoc'],
        components: {
            DatePicker,
            'eselect': ESelectVue,
        },
        data() {
            return {
                hien_thi_modal: false,
                list_truong_hoc: [],
                danh_sach_khoi_hoc: [{
                        id: 1,
                        name: "Khối 1"
                    }, {
                        id: 2,
                        name: "Khối 2"
                    }, {
                        id: 3,
                        name: "Khối 3"
                    }, {
                        id: 4,
                        name: "Khối 4"
                    }, {
                        id: 5,
                        name: "Khối 5"
                    }, {
                        id: 6,
                        name: "Khối 6"
                    }, {
                        id: 7,
                        name: "Khối 7"
                    }, {
                        id: 8,
                        name: "Khối 8"
                    }, {
                        id: 9,
                        name: "Khối 9"
                    }, {
                        id: 10,
                        name: "Khối 10"
                    }, {
                        id: 11,
                        name: "Khối 11"
                    }, {
                        id: 12,
                        name: "Khối 12"
                    }, {
                        id: 13,
                        name: "Trẻ từ 3-12 tháng"
                    },
                    {
                        id: 14,
                        name: "Trẻ từ 13-24 tháng"
                    },
                    {
                        id: 15,
                        name: "Trẻ từ 25-36 tháng"
                    }, {
                        id: 16,
                        name: "Trẻ từ 3-4 tuổi"
                    },
                    {
                        id: 17,
                        name: "Trẻ từ 4-5 tuổi"
                    },
                    {
                        id: 18,
                        name: "Trẻ từ 5-6 tuổi"
                    },
                ],
                thongTinChinhSua: {
                    maHocSinh: "",
                    hoTen: "",
                    ngaySinh: "",
                    gioiTinh: "",
                    cMND: "",
                    diaChi: "",
                    maTruongHoc: "",
                    namHoc: "",
                    soDienThoai: "",
                    lopHoc: "",
                    khoiHoc: "",
                },
                list_gioi_tinh: [{
                        name: "Nam",
                        value: 1
                    },
                    {
                        name: "Nữ",
                        value: 0
                    },
                ]
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.getTruongHoc();
        },
        watch: {
            show: function (val) {
                if (val) {
                    this.hien_thi_modal = true;
                } else {
                    this.hien_thi_modal = false;
                }
            },
            item: function (newVal, oldVal) {
                if (newVal) {
                    this.bindDuLieu();
                } else {}
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
            confirmChinhSua() {
                console.log("Nội dung gửi đi:")
                console.log(this.thongTinChinhSua)

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/sso/editHocSinh", this.thongTinChinhSua, (response) => {
                    loading.close();
                    console.log("Chỉnh sửa trả về:" + JSON.stringify(response.data));
                    if (response.data.rc == 0) {
                        this.thongBao("success", "Chỉnh sửa thông tin thành công")
                        this.$emit('success');
                        this.$emit('close');
                    } else {
                        this.thongBao("error", response.data.rd)
                    }
                });
                // this.$confirm('Xác nhận chỉnh sửa thông tin?', 'Thông báo', {
                //     confirmButtonText: 'Xác nhận',
                //     cancelButtonText: 'Hủy',
                // })
                //     .then(_ => {
                //     })
                //     .catch(_ => {
                //     });
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
            bindDuLieu() {
                this.thongTinChinhSua.maHocSinh = this.item.maHocSinh;
                this.thongTinChinhSua.hoTen = this.item.hoTen;
                this.thongTinChinhSua.ngaySinh = this.item.ngaySinh;
                this.thongTinChinhSua.gioiTinh = this.item.gioiTinh;
                this.thongTinChinhSua.cMND = this.item.soCmnd;
                this.thongTinChinhSua.diaChi = this.item.dchiThtru;
                this.thongTinChinhSua.maTruongHoc = this.item.maTruongHoc;
                this.thongTinChinhSua.namHoc = this.namhoc;
                this.thongTinChinhSua.soDienThoai = this.item.soDthoaiDdong;
                this.thongTinChinhSua.lopHoc = this.item.maLopHoc;
                this.thongTinChinhSua.khoiHoc = parseInt(this.item.khoiHoc);
                console.log("Thông tin chỉnh sửa:")
                console.log(this.thongTinChinhSua)
            },
            dongModal() {
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

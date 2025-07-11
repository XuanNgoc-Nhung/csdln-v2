<template>
    <div>
        <div>
            <div class="row" style="display:flex;padding-top:25px">
                <div class="col-md-4">
                    <label>Đơn vị <span style="color:#DC0101">*</span></label>
                    <el-select v-model="donVi" filterable @change="chonDonVi()" placeholder="Chọn">
                        <el-option v-for="item in list_don_vi" :key="item.name" :label="item.name" :value="item">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-2">
                    <label>Cấp học  <span style="color:#DC0101">*</span></label>
                    <el-select v-model="capHoc" @change="chonDonVi()" filterable placeholder="Chọn">
                        <el-option v-for="item in list_cap_hoc" :key="item.id" :label="item.name" :value="item">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-4">
                    <label>Trường học</label>
                    <el-select v-model="truongHoc" filterable placeholder="Chọn" no-data-text="Không có dữ liệu"
                        no-match-text="Không có dữ liệu phù hợp">
                        <el-option v-for="item in list_truong_hoc" :key="item.value" :label="item.name" :value="item">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-2">
                    <label>Loại dữ liệu  <span style="color:#DC0101">*</span></label>
                    <select v-model="loaiDuLieu" class="form-control">
                        <option value="">Chọn</option>
                        <option value="CanBo">Cán bộ</option>
                        <option value="LopHoc">Lớp học</option>
                        <option value="HocSinh">Học sinh</option>
                    </select>
                </div>
            </div>
            <div class="row" style="">
                <div class="col-md-2">
                    <label>Năm học</label>
                    <el-select v-model="namHoc" filterable placeholder="Chọn">
                        <el-option v-for="item in list_nam_hoc" :key="item.id" :label="item.name" :value="item.id">
                        </el-option>
                    </el-select>
                </div>
                <!-- <div class="col-md-2">
                    <label>Học kỳ</label>
                    <el-select v-model="hocKy" filterable placeholder="Chọn">
                        <el-option v-for="item in list_hoc_ky" :key="item.value" :label="item.name" :value="item.value">
                        </el-option>
                    </el-select>
                </div>
                <div class="col-md-2">
                    <label>Giai đoạn</label>
                    <el-select v-model="giaiDoan" filterable placeholder="Chọn">
                        <el-option v-for="item in list_giai_doan" :key="item.value" :label="item.name" :value="item.value">
                        </el-option>
                    </el-select>
                </div> -->
            </div>
            <hr/>
            <div class="row">
                <div class="col-md-3">
                    <div style="margin-top:15px;">
                        <label for="">Nội dung đã tải lên </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center">
                        <button class="btn btn-danger" @click.prevent="BackStep()">Làm lại</button>
                        <button class="btn btn-primary" @click.prevent="startStepBa()">Tiếp theo</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <!-- <div style="margin-top:15px;">
                        <label for="">Nội dung đã tải lên</label>
                    </div> -->
                    <div style="">
                        <iframe style="width:100%; height:70vh" :src="linkExcel"></iframe>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <!-- <button class="btn btn-info" @click.prevent="BackStep()">Quay lại</button>
            <button class="btn btn-primary" @click.prevent="startStepBa()">Tiếp theo</button> -->
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import moment from "moment";
    import dialog from '../../../js/utils/dialog';
    import ElementUI from 'element-ui';
    import constant from '../../utils/constant';
    import VueAlertify from "vue-alertify";
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
            Multiselect,
        },
        props: ['data_step_two'],
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                duLieuImportBuocHai: "",
                list_nam_hoc: constant.LIST_YEARS_FULL,
                ds_cap_hoc: window.listCapHoc,
                linkExcel: "",
                date: new Date(),
                loaiDuLieu: "",
                namHoc: "",
                hocKy: "",
                namHocHienTai: "",
                giaiDoan: "",
                donVi: {
                    name: "Chọn",
                    value: ""
                },
                truongHoc: {
                    name: "Chọn",
                    value: ""
                },
                capHoc: {
                    name: "Chọn",
                    value: ""
                },
                list_don_vi: [{
                    name: "Chọn",
                    value: ""
                }],
                list_giai_doan: [{
                    name: "Chọn",
                    value: ""
                },{
                    name: "Giữa kỳ I",
                    value: "GK1"
                },{
                    name: "Cuối kỳ I",
                    value: "CK1"
                },{
                    name: "Giữa kỳ II",
                    value: "GK2"
                },{
                    name: "Cuối kỳ II",
                    value: "CK2"
                }],
                list_truong_hoc: [{
                    name: "Chọn",
                    value: ""
                }],
                list_hoc_ky: [{
                    name: "Chọn",
                    value: ""
                },{
                    name: "Học Kỳ I",
                    value: "1"
                },{
                    name: "Học kỳ 2",
                    value: "2"
                },{
                    name: "Cả năm",
                    value: "3"
                }],
                list_cap_hoc: [{
                    name: "Chọn",
                    value: ""
                }],
            };
        },
        mounted: function () {
            this.namHocHienTai = this
                .date
                .getFullYear();
            let thangNay = this
                .date
                .getMonth();
            thangNay = parseInt(thangNay) + 1;
            if (thangNay > 8) {
                console.log("tháng > 7");
                // tháng lớn hơn 7. lấy năm nay là năm học hiện tại
            } else {
                this.namHocHienTai -= 1;
                console.log("tháng không lớn hơn 7");
                // tháng nhỏ hơn hoặc bằng 7. lấy năm ngoái là năm học hiện tại
            }
            console.log("năm học hiện tại" + this.namHocHienTai);
            this.findNamHoc();
            this.bindCapHoc();
            console.log("Bước 3");
            console.log(JSON.stringify(this.thongtin));
            this.ganDuLieu();
            this.getDonVi();
        },
        methods: {
            startStepBa() {
                if (!this.donVi.value) {
                    this
                        .$alertify
                        .error("Thiếu dữ liệu: Đơn vị");
                return
                }
                if (!this.capHoc.value) {
                    this
                        .$alertify
                        .error("Thiếu dữ liệu: Cấp học");
                return
                }
                if (!this.loaiDuLieu) {
                    this
                        .$alertify
                        .error("Thiếu dữ liệu: Loại dữ liệu");
                        return
                }
                dialog.confirmDialog(
                    "Xác nhận chuyển bước?",
                    "Xác nhận",
                    () => {
                        console.log("dữ liệu bước 3 xong:");
                        this
                            .$alertify
                            .success("Chuyển bước thành công");
                        let data_step_3 = {
                            donvi: this.donVi,
                            capHoc: this.capHoc,
                            truongHoc: this.truongHoc,
                            loaiDuLieu: this.loaiDuLieu,
                            namHoc: this.namHoc,
                            hocKy: this.hocKy,
                            giaiDoan: this.giaiDoan
                        }
                        let dulieu = {
                            step: 3,
                            data: data_step_3
                        }
                        this.$emit('nextStep', dulieu)
                    }
                );
            },
            findNamHoc() {
                console.log(this.list_nam_hoc);
                for (let i = 0; i < this.list_nam_hoc.length; i++) {
                    if (this.list_nam_hoc[i].id == this.namHocHienTai) {
                        this.namHoc = this.list_nam_hoc[i].id;
                    }
                    console.log(this.namHoc);
                }
            },
            chonDonVi() {
                this.truongHoc = {
                    name: "Chọn",
                    value: ""
                };
                this.list_truong_hoc = [{
                    name: "Chọn",
                    value: ""
                }];
                this.getTruongHoc();
            },
            chonCapHoc() {
                this.truongHoc = {
                    name: "Chọn",
                    value: ""
                };
                this.list_truong_hoc = [{
                    name: "Chọn",
                    value: ""
                }];
                this.getTruongHoc();
            },
            bindCapHoc() {
                for (let i = 0; i < this.ds_cap_hoc.length; i++) {
                    for (let i = 0; i < this.ds_cap_hoc.length; i++) {
                        let obj = {
                            name: this.ds_cap_hoc[i].name,
                            value: this.ds_cap_hoc[i].id,
                        }
                        this.list_cap_hoc.push(obj)
                    }
                }
            },
            getDonVi() {
                console.log("lấy đơn vị");
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.province
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (data.data.statusResponse == 0) {
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                name: data_demo[i].tenDonVi,
                                value: data_demo[i].maDonVi,
                            }
                            this.list_don_vi.push(obj)
                        }
                    }

                });
            },
            getTruongHoc() {
                let params = {
                    maDonVi: [this.donVi.value],
                    capHoc: [this.capHoc.value]
                };
                if (this.donVi.value == "") {
                    params.maDonVi = [];
                }
                if (this.capHoc.value == "") {
                    params.capHoc = [];
                }
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    console.log("lấy trường");
                    console.log(JSON.stringify(data.data));
                    if (data.data.statusResponse == 0) {
                        let data_demo = data.data.rows;
                        for (let i = 0; i < data_demo.length; i++) {
                            let obj = {
                                name: data_demo[i].tenTruongHoc,
                                value: data_demo[i].maTruongHoc,
                            }
                            this.list_truong_hoc.push(obj)
                        }
                    }
                }, 60000, true);
            },
            ganDuLieu() {
                console.log("thực hiện bước 3:");
                this.linkExcel = this.data_step_two.linkExcel;
            },
            UpLoadFile() {
                console.log("Upload file");
                this.$emit('nextStep', 3)
            },
            BackStep() {
                dialog.confirmDialog(
                    "Xác nhận Upload lại file?",
                    "Xác nhận",
                    () => {
                        location.reload()
                    })
            },
            startStepHai() {
                console.log("bước 2:");
                let params = {
                    "endIndex": parseInt(this.endIndex),
                    "hasTitle": this.hasTitle,
                    "indexTitle": parseInt(this.indexTitle),
                    "startIndex": parseInt(this.startIndex),
                    "sheetName": this.sheetName,
                    "id": this.idStepOne,
                };
                dialog.confirmDialog(
                    "Xác nhận chuyển bước?",
                    "Xác nhận",
                    () => {
                        rest_api.post("/csdlgd-data-import/import-task/select-data", params, data => {
                            console.log("dữ liệu bước 2 xong:");
                            console.log(JSON.stringify(data.data));
                            if (data.data.rc == 0) {
                                this
                                    .$alertify
                                    .success("Chuyển bước thành công");
                                let dulieu = {
                                    step: 2,
                                    data: params,
                                    linkExCel: this.linkExcel
                                }
                                console.log("Dữ liệu chuyển sang bước 3:");
                                console.log(JSON.stringify(dulieu));
                                this.$emit('nextStep', dulieu)
                            } else {
                                this
                                    .$alertify
                                    .error("Chuyển bước thất bại");
                            }
                        });
                    }
                );
            }

        }
    };

</script>
<style scoped="scoped">
    .row {
        padding-top: 15px;
        margin: 0;
    }

</style>

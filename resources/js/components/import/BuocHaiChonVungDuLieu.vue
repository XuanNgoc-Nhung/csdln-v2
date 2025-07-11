<template>
    <div>
        <div>
            <div style="display:flex;padding-top:25px" class="row">
                <div class="col-md-2">
                    <label>Trang tính  <span style="color:#DC0101">*</span></label>
                    <select v-model="sheetName" class="form-control">
                        <option value="">Chọn</option>
                        <option v-for="tt in list_trang_tinh" :key="tt" :value="tt">{{tt}}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <span style="display:block; margin-top:29px;"><input type="checkbox" v-model="hasTitle"> Bảng DL có
                        dòng tiêu đề</span>
                </div>
                <div class="col-md-2">
                    <label>Tiêu đề bảng DL nằm ở dòng <span v-if="hasTitle" style="color:#DC0101">*</span></label>
                    <input type="number" class="form-control" :disabled="!hasTitle" placeholder="Nhập..."
                        v-model="indexTitle">
                </div>
                <div class="col-md-4">
                    <label>Dữ liệu import từ dòng <span style="color:#DC0101">*</span></label>
                    <div class="input-group input-daterange">
                        <input placeholder="Nhập..." type="number" v-model="startIndex" class="form-control">
                        <div class="input-group-addon">đến</div>
                        <input placeholder="Nhập..." type="number" v-model="endIndex" class="form-control">
                    </div>
                </div>
            </div>
            <hr />
            <div class="row">
                <div class="col-md-3">

                    <div style="margin-top:15px;">
                        <label for="">Nội dung đã tải lên</label>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="text-center">
                        <button class="btn btn-danger" @click.prevent="BackStep()">Làm lại</button>
                        <button class="btn btn-primary" @click.prevent="startStepHai()">Tiếp theo</button>
                    </div>
                </div>
            </div>
            <div class="row" style="">
                <div class="col-md-12">

                    <iframe style="width:100%; height:70vh" :src="linkExcel"></iframe>
                </div>
            </div>
        </div>
        <!-- <div class="text-center">
            <button class="btn btn-info" @click.prevent="BackStep()">Quay lại</button>
            <button class="btn btn-primary" @click.prevent="startStepHai()">Tiếp theo</button>
        </div> -->
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import dialog from '../../../js/utils/dialog';
    import VueAlertify from "vue-alertify";
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
        components: {},
        props: ['data_step_one'],
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                duLieuImportBuocMot: {},
                list_trang_tinh: [],
                hasTitle: false,
                idStepOne: "",
                linkExcel: "",
                sheetName: "",
                indexTitle: "",
                startIndex: "",
                endIndex: "",
                baseLink: "/view-excel?path=",
            };
        },
        mounted: function () {
            console.log("Bước 2");
            console.log(JSON.stringify(this.thongtin));
            this.ganDuLieu();
        },
        methods: {
            ganDuLieu() {
                console.log("thực hiện bước 2:");
                this.duLieuImportBuocMot = this.data_step_one;
                // console.log(JSON.stringify(this.duLieuImportBuocMot));
                let vitri = this.duLieuImportBuocMot.item.importFileLocation.replace("/data/moetdb/static", "");
                this.linkExcel = this.baseLink + this.thongtin.tenMien + vitri;
                this.list_trang_tinh = this.duLieuImportBuocMot.item.avalableSheetsInUploadedFile;
                this.idStepOne = this.duLieuImportBuocMot.item.id;
                console.log(JSON.stringify(this.linkExcel));
            },
            UpLoadFile() {
                console.log("Upload file");
                this.$emit('nextStep', 2)
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
                if (!this.sheetName||this.sheetName=="") {
                    this
                        .$alertify
                        .error("Thiếu dữ liệu: Trang tính");
                    return;
                }
                if (!this.startIndex) {
                    this
                        .$alertify
                        .error("Thiếu dữ liệu: Dòng bắt đầu import");
                    return;
                }
                if (this.hasTitle && !this.indexTitle) {
                    this
                        .$alertify
                        .error("Thiếu dữ liệu: Vị trí dòng tiêu đề");
                    return;
                }
                if (!this.endIndex) {
                    this
                        .$alertify
                        .error("Thiếu dữ liệu: Dòng kết thúc import");
                    return;
                }
                if (parseInt(this.endIndex) < parseInt(this.startIndex)) {
                    this
                        .$alertify
                        .error("Dòng bắt đầu import phải nhỏ hơn hoặc bằng dòng kết thúc");
                    return;
                }
                if (this.hasTitle) {

                    if (parseInt(this.startIndex) <= parseInt(this.indexTitle)) {
                        this
                            .$alertify
                            .error("Dòng bắt đầu import phải lớn hơn dòng tiêu đề");
                        return;
                    }
                }
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
                                    linkExcel: this.linkExcel
                                }
                                this.$emit('nextStep', dulieu)
                            } else {
                                this
                                    .$alertify
                                    .error("Chuyển bước thất bại.");
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
        margin: 0;
    }

</style>

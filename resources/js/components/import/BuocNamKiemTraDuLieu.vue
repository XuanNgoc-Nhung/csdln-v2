<template>
    <div>
        <div class="row">
            <div class="col-md-3">
                <div style="margin-top:15px;">
                    <label for="">Nội dung đã tải lên</label>
                </div>
            </div>
            <div class="col-md-6">
                <div class="text-center">
            <button class="btn btn-danger" @click.prevent="BackStep()">Làm lại</button>
            <button class="btn btn-primary" @click.prevent="startStepNam()">Tiếp theo</button>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
            <div style="">
                <!-- <pre>{{data_step_four}}</pre> -->
                <iframe style="width:100%; height:70vh" :src="linkExcel"></iframe>
            </div>
            </div>
        </div>
        <!-- <div class="text-center">
            <button class="btn btn-info" @click.prevent="BackStep()">Quay lại</button>
            <button class="btn btn-primary" @click.prevent="startStepNam()">Tiếp theo</button>
        </div> -->
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import moment from "moment";
    import dialog from '../../../js/utils/dialog';
    import ElementUI from 'element-ui';
    import constant from '../../utils/constant';
    import VueAlertify from "vue-alertify";
    import datePicker from 'vue-bootstrap-datetimepicker';
    export default {
        components: {
            datePicker,
        },
        props: ['data_step_one', 'data_step_two', 'data_step_three', 'data_step_four', ],
        data() {
            return {
                linkExcel: "",
                thongtin: JSON.parse(window.userInfo),
            };
        },
        mounted: function () {
            this.linkExcel = this.data_step_four.linkExcel;
        },
        methods: {
            startStepNam() {
                // console.log("Dữ liệu 1:");
                // console.log(JSON.stringify(this.data_step_one));
                // console.log("Dữ liệu 2:");
                // console.log(JSON.stringify(this.data_step_two));
                // console.log("Dữ liệu 3:");
                // console.log(JSON.stringify(this.data_step_three));
                // console.log("Dữ liệu 4:");
                // console.log(JSON.stringify(this.data_step_four));
                let params = {
                    "capHoc": this.data_step_three.capHoc.value,
                    "endRowNumOfData": this.data_step_two.data.endIndex,
                    "startRowNumOfData": this.data_step_two.data.startIndex,
                    "sheetName": this.data_step_two.data.sheetName,
                    "entityType": this.data_step_three.loaiDuLieu,
                    "hasTableHeader": this.data_step_two.data.hasTitle,
                    "headerRowNum": this.data_step_two.data.indexTitle,
                    "hocKy": this.data_step_three.hocKy,
                    "id": this.data_step_two.data.id,
                    "maGiaiDoan": this.data_step_three.giaiDoan,
                    "namHoc": this.data_step_three.namHoc,
                    "maPhong": this.data_step_three.donvi.value,
                    "maTruongHoc": this.data_step_three.truongHoc.value,
                };
                console.log(JSON.stringify(params));
                dialog.confirmDialog(
                    "Xác nhận import dữ liệu?",
                    "Xác nhận",
                    () => {
                        rest_api.post("/csdlgd-data-import/import-task/start-import", params, data => {
                            console.log("dữ liệu import trả về:");
                            console.log(JSON.stringify(data.data));
                            if (data.data.rc == 0) {
                                this
                                    .$alertify
                                    .success("Chuyển bước thành công");
                                let dulieu = {
                                    step: 5,
                                    data: params,
                                }
                                this.$emit('nextStep', dulieu)
                            } else {
                                this
                                    .$alertify
                                    .error("Chuyển bước thất bại");
                            }
                        });
                    }
                );
            },
            UpLoadFile() {
                console.log("Upload file");
                this.$emit('nextStep', 5)
            },
            BackStep() {
                dialog.confirmDialog(
                    "Xác nhận Upload lại file?",
                    "Xác nhận",
                    () => {
                        location.reload()
                    })
            }

        }
    };

</script>
<style scoped="scoped">
.row{
    margin: 0;
    padding-top:20px
}
</style>

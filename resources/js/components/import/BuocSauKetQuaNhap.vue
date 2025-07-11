<template>
    <div style="height:200px; text-align:center">
        <div v-if="!importloi">
            <div v-if="hienthi" class="text-center">
                <img src="https://i.gifer.com/YVPG.gif" alt="">
                <p>Loading...</p>
            </div>
            <div v-else>
                <div class="row" style="margin:0;">
                    <div class="col-md-12">
                        <h4>Kết quả tiến trình:</h4>
                        <p>Tải xuống: <span>
                                <a v-if="hienthi1" :href="thongtinimport1">Kết quả quá trình kiểm tra tập tin</a></span>
                            <span v-if="hienthi1&&hienthi2"> hoặc </span> <span>
                                <a v-if="hienthi2" :href="thongtinimport2">Kết quả quả import</a> </span></p>
                    </div>
                </div>
            </div>
        </div>
        <div v-else>
            <h4>Tiến trình import lỗi:</h4>
            <p>{{messLoi}}</p>
            <p v-if="hienthi1||hienthi2">Tải xuống: <span>
                    <a v-if="hienthi1" :href="thongtinimport1">Kết quả quá trình kiểm tra tập tin</a></span>
                <span v-if="hienthi1&&hienthi2"> hoặc </span> <span>
                    <a v-if="hienthi2" :href="thongtinimport2">Kết quả quả import</a> </span></p>
        </div>
        <div>
            <button class="btn btn-danger" @click.prevent="BackStep()">Làm lại</button>
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
    export default {
        components: {},
        props: ['data_step_one', 'data_step_two', 'data_step_three', ],
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                importloi: false,
                hienthi: true,
                hienthi1: false,
                hienthi2: false,
                messLoi: "",
                thongtinimport1: "",
                thongtinimport2: "",
            };
        },
        mounted: function () {
            this.getData();
        },
        methods: {
            UpLoadFile() {
                console.log("Upload file");
                this.$emit('nextStep', 6)
            },

            BackStep() {
                dialog.confirmDialog(
                    "Xác nhận Upload lại file?",
                    "Xác nhận",
                    () => {
                        location.reload()
                    })
            },
            getData() {
                console.log("bước 6:");
                console.log(JSON.stringify(this.data_step_one));
                let params = {
                    id: this.data_step_one.item.id
                };
                rest_api.get("/csdlgd-data-import/import-task/view-import-task", params, (data) => {
                    console.log("kết quả cuối:");
                    console.log(JSON.stringify(data.data));
                    if (data.data.rc==0) {
                        if (data.data.item.status == "FINISHED") {
                            this.hienthi = false;
                            if (data.data.item.convertErrorUrlContext != null) {
                                this.hienthi1 = true;
                                let vitri = data.data.item.convertErrorUrlContext.replace("/data/moetdb/static",
                                    "");
                                this.thongtinimport1 = this.thongtin.tenMien + "/" + vitri;
                            }
                            if (data.data.item.pushErrorUrlContext != null) {
                                this.hienthi2 = true;
                                this.thongtinimport2 = this.thongtin.tenMien + "/" + data.data.item
                                    .pushErrorUrlContext;
                            }
                            this
                                .$alertify
                                .success("Đã xử lý");
                        } else if (data.data.item.status == "FAILED") {
                            this
                                .$alertify
                                .error("Tiến trình import thất bại");
                            this.importloi = true;
                            this.messLoi = data.data.item.importResult;
                            if (data.data.item.convertErrorUrlContext != null) {
                                this.hienthi1 = true;
                                let vitri = data.data.item.convertErrorUrlContext.replace("/data/moetdb/static",
                                    "");
                                this.thongtinimport1 = this.thongtin.tenMien + "/" + vitri;
                            }
                            if (data.data.item.pushErrorUrlContext != null) {
                                this.hienthi2 = true;
                                this.thongtinimport2 = this.thongtin.tenMien + "/" + data.data.item
                                    .pushErrorUrlContext;
                            }
                        } else {
                            setTimeout(this.getData, 5000);
                        }
                    }
                    else{
                        
                            this
                                .$alertify
                                .error("Tiến trình import thất bại: "+ data.data.rd);
                            this.importloi = true;
                            this.messLoi = data.data.rd;
                    }
                });
            }
        }
    };

</script>
<style scoped="scoped">
</style>

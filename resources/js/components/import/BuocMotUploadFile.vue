<template>
    <div style="height:200px; text-align:center">
        <div>
            <div class="alert alert-info"
                style="display: inline-flex;position: relative; min-width:50%; margin-top:15px;" role="alert">
                <label class="btn btn-default btn-file">
                    <i class="fa fa-cloud-upload"></i>
                    <span>
                        <i class="fas fa-upload"></i>
                        Chọn file</span>
                    <input ref="file_upload" multiple="false" name="file" style="display: none;" type="file"
                        @change="onFileChange" aria-invalid="false" />
                </label>
                <label v-if="tenFile!=''" class="btn btn-default btn-file" style="margin: 0 15px;">
                    <span>File đã chọn:
                        {{tenFile}}</span>
                </label>
            </div>
        </div>
        <hr />
        <div>
            <!-- <button class="btn btn-primary" @click.prevent="imPortFile()">Tiếp theo</button> -->
            <button class="btn btn-primary" @click.prevent="imPortFile2()">Tiếp theo</button>
        </div>
    </div>
</template>
<script>
    import dialog from '../../../js/utils/dialog';
    import utils from '../../../js/utils';
    import rest_api from '../../utils/rest_api';
    import api from './../api';
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
        data() {
            return {
                uri: '/api-import-buoc-mot-du-lieu-moet',
                tenFile: '',
                danh_sach_dinh_dang_excel: [
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    "application/vnd.ms-excel.sheet.macroEnabled.12",
                    "application/vnd.ms-excel",
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
                ],
                selected_file: null,
            };
        },
        methods: {
            UpLoadFile() {
                console.log("Upload file");
                this.$emit('nextStep', 1)
            },

            imPortFile() {
                console.log("Import");
                if (this.selected_file == null) {
                    utils.showDialog("Thông báo", "Vui lòng chọn file import");
                    return;
                }
                utils.confirmDialog("Xác nhận chuyển bước?", "Xác nhận", () => {
                    console.log(this.uri);
                    let params = new FormData();
                    params.append('file', this.selected_file);
                    api.postForm(this.uri, params, (data) => {
                        let stt = JSON.parse(data.data);
                        stt.tenFileImport = this.tenFile;
                        console.log("Kết quả im pọt:");
                        console.log(JSON.stringify(stt));
                        if (stt.rc === 0) {
                            let dulieu = {
                                step: 1,
                                data: stt
                            }
                            this
                                .$alertify
                                .success("Chuyển bước thành công.");
                            this.$emit('nextStep', dulieu)
                        } else {
                            this
                                .$alertify
                                .error("Import file không thành công. Vui lòng thử lại");
                            // this.xoaFile();
                            // this.reset();
                        }
                    });
                });
            },
            getBuocTiep(e) {
                let hihi = '/csdlgd-upload-helper/upload-gateway/upload-file?url=csdlgd-data-import/import-task/upload-import-file&fileLocation=uploadExcel/02122020-g949zJ-25_Bao_cao_can_bo_15092020 (2).xlsx';
                let url =
                    "/csdlgd-upload-helper/upload-gateway/upload-file?url=csdlgd-data-import/import-task/upload-import-file&fileLocation=" +
                    e;
                rest_api.post(url, {}, data => {
                    console.log("******************* trả về");
                    console.log(JSON.stringify(data));
                    // if (data && data.data) {
                        let stt = data.data;
                        console.log("1");
                        stt.tenFileImport = this.tenFile;
                        console.log("Kết quả im pọt:");
                        console.log(JSON.stringify(stt));
                        console.log("2");
                        if (stt.rc === 0) {
                            let dulieu = {
                                step: 1,
                                data: stt
                            }
                            this
                                .$alertify
                                .success("Chuyển bước thành công.");
                            this.$emit('nextStep', dulieu)
                        } else {
                            this
                                .$alertify
                                .error("Import file không thành công. Vui lòng thử lại");
                            // this.xoaFile();
                            // this.reset();
                        }
                    // } else {
                    //         this
                    //             .$alertify
                    //             .error("Import file không thành công. Vui lòng thử lại");
                    //         // this.xoaFile();
                    //         // this.reset();
                    //     }
                });
            },
            imPortFile2() {
                console.log("Import");
                if (this.selected_file == null) {
                    utils.showDialog("Thông báo", "Vui lòng chọn file import");
                    return;
                }
                utils.confirmDialog("Xác nhận chuyển bước?", "Xác nhận", () => {
                    console.log(this.uri);
                    let params = new FormData();
                    params.append('file', this.selected_file);
                    api.postForm(this.uri, params, (data) => {
                        if (data.data.rc == 0) {
                            this.getBuocTiep(data.data.file);
                        } else {
                            this
                                .$alertify
                                .error("Import file không thành công. Vui lòng thử lại");
                        }




                    });
                });
            },

            onFileChange(e) {
                const files = e.target.files;
                this.tenFile = '';
                if (!files) {
                    dialog.showDialog("Thông báo", "Trình duyệt không hỗ trợ upload file");
                    return;
                }
                this.selected_file = files[0];
                const size = parseInt(this.selected_file.size);
                console.log("kích thước file:" + size);
                if (files && files[0]) {
                    console.log(files)
                    let fileType = this.selected_file["type"];
                    let ValidImageTypes = this.danh_sach_dinh_dang_excel;
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                        dialog.showDialog("Thông báo", "Vui lòng chọn file excel");
                        this.selected_file = null;
                        return;
                    }
                    this.file_name = e
                        .target
                        .files[0]
                        .name;
                    this.tenFile = this.file_name;
                }
                console.log("upload xong");
                console.log("tên file:" + this.file_name);

            }
        },

        reset() {
            this.selected_file = null;
            this.tenFile = '';
        },
    };

</script>
<style scoped="scoped">
</style>

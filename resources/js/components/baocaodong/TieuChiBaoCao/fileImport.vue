<template>

    <div id="modal_import_mk_ket_chuyen" ref="modal_import_mk_ket_chuyen" class="modal fade">
        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content" style="padding:0 15px;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Nhập file thông tin</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="row">
                        <div style="height:200px; text-align:center">
                            <div>
                                <div class="alert alert-info"
                                    style="display: inline-flex;position: relative; min-width:50%; margin-top:15px;"
                                    role="alert">
                                    <label class="btn btn-default btn-file">
                                        <i class="fa fa-cloud-upload"></i>
                                        <span>
                                            <i class="fas fa-upload"></i>
                                            Chọn file</span>
                                        <input ref="file_upload" multiple="false" name="file" style="display: none;"
                                            type="file" @change="onFileChange" aria-invalid="false" />
                                    </label>
                                    <label v-if="tenFile!=''" class="btn btn-default btn-file" style="margin: 0 15px;">
                                        <span>File đã chọn:
                                            {{tenFile}}</span>
                                    </label>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary" v-on:click="imPortFile()">Upload file
                            </button>
                            <hr />
                        </div>
                        <div>
                            <label for="">Địa chỉ file</label>
                            <el-input clearable placeholder="Please input" style="background:cyan" v-model="linkExcel"
                                class="input-with-select">
                                <el-button plain type="success" slot="append" @click="coppyCode">gán link
                                </el-button>
                            </el-input>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>


        </div>

    </div>
</template>
<script>
    import dialog from '../../../../js/utils/dialog';
    import utils from '../../../../js/utils';
    import rest_api from '../../../utils/rest_api';
    import api from './../../api';
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
        mounted: function () {
            $("#modal_import_mk_ket_chuyen").modal();
            $(this.$refs.modal_import_mk_ket_chuyen).on("hidden.bs.modal", this.close);
        },
        data() {
            return {
                uri: '/api-import-bao-cao-dong',
                tenFile: '',
                linkExcel: '',
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
            coppyCode() {
                this.$emit('success', this.linkExcel);
                this.close;
            },
            close() {
                this.$emit('close')
            },
            imPortFile() {
                if (this.selected_file == null) {
                    utils.showDialog("Thông báo", "Vui lòng chọn file import");
                    return;
                }
                utils.confirmDialog("Xác nhận import file?", "Đồng ý", () => {
                    console.log(this.uri);
                    let params = new FormData();
                    params.append('file', this.selected_file);
                    api.postForm(this.uri, params, (data) => {
                        console.log(JSON.stringify(data.data));
                        let data_import = JSON.parse(data.data)
                        console.log(JSON.stringify(data_import));
                        if (data_import.rc == 0) {
                            this
                                .$alertify
                                .success("Lấy địa chỉ file thành công");
                            this.linkExcel = data_import.item
                            this.$emit('success', this.linkExcel);
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

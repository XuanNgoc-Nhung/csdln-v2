<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)"
         id="modal_import_truonghoc" ref="modal_import_truonghoc" class="modal fade">
        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Nhập Trường học từ file Excel</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="row">
                        <div class="col-lg-3"><label class="pull-right">Chọn File</label></div>
                        <div class="col-lg-9">
                            <div class="alert alert-info" style="display: inline-flex" role="alert">
                                <label class="btn btn-default btn-file">
                                    <i class="fa fa-cloud-upload"></i>
                                    <span><i class="fas fa-upload"></i> Chọn file</span>
                                    <input ref="file_upload" multiple="false" name="file" style="display: none;"
                                           type="file" @change="onFileChange" aria-invalid="false"/>
                                </label>
                                <label v-if="tenFile!=''" class="btn btn-default btn-file" style="margin: 0 15px;">
                                    <span>File đã chọn: {{ tenFile }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3"><label class="pull-right">Vui lòng chọn file mẫu</label></div>
                        <div class="col-lg-9">
                            <label><a :href="'/templateImport/Template_Truong_Hoc.xlsx?t='+getTime()" target="_blank"
                                      title="Tải xuống">Tại đây</a></label>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                    </button>
                    <button type="button" class="btn btn-primary" v-on:click="imPortFile()">Nhập
                    </button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>
import dialog from '../../../utils/dialog';
import utils from '../../../utils'
import rest_api from '../../../utils/rest_api';
import api from './../../api';

$(document).ready(function () {
    console.log("ready!");
});
export default {

    props: [],


    watch: {},
    data() {
        return {
            show_url_download:false,
            urlDownLoadFileErrors:'',
            loading: {
                status: false,
                text: 'Loading...'
            },
            tenFile: '',
            selected_file: null,
            thongtin: {},
            download_link: ''
        }
    },


    mounted: function () {
        $("#modal_import_truonghoc").modal();

        this.thongtin = JSON.parse(window.userInfo);
        $(this.$refs.modal_import_truonghoc).on("hidden.bs.modal", this.close);
        this.getDownload();
    },

    methods: {
        getTime() {
            let now = new Date();
            let timestamp = now.getTime();
            return timestamp
        },
        async getDownload() {
            this.download_link = this.thongtin.tenMien + '/exportExcel/templateImport/Template_Truong_Hoc.xlsx';
        },
        imPortFile() {
            console.log("Import");
            if (this.selected_file == null) {
                utils.showDialog("Thông báo", "Vui lòng thêm chọn file import");
                return;
            }
            utils.confirmDialog("Xác nhận Import file", "Đồng ý", () => {
                const uri = "/api-import-truong-hoc";
                let params = new FormData();
                params.append('file', this.selected_file);
                this.loading.status = true;
                api.postForm(uri, params, (data) => {
                    let stt = JSON.parse(data.data)
                    console.log("Dữ liệu import trả về:");
                    console.log(stt)
                    if (stt.code == 0) {
                        console.log("upload thành công");
                        utils.showDialog("Thông báo", "Import file thành công", null, () => {
                            this.$emit('success', params);
                            this.close();
                            this.reset();
                        });
                    } else if (stt.code == 1) {
                        this.urlDownLoadFileErrors = stt.urlLoi;

                    } else {
                        utils.showDialog("Thất bại", stt.message, null, () => {
                        });
                    }
                    this.loading.status = false;
                });


            });


        },
        close() {
            console.log("close modal");
            this.$emit('close');
            this.reset();
        },
        reset() {
            this.selected_file = '';
            this.tenFile = '';
        },
        onFileChange(e) {
            console.log("chọn file");
            const files = e.target.files;
            this.tenFile = '';
            if (!files) {
                dialog.showDialog("Thông báo", "Trình duyệt không hỗ trợ upload file");
                return;
            }
            this.selected_file = files[0];
            // const size = parseInt(this.selected_file.size);
            // console.log("kích thước file:"+ size);
            if (files && files[0]) {
                let fileType = this.selected_file["type"];
                let ValidImageTypes = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
                if ($.inArray(fileType, ValidImageTypes) < 0) {
                    dialog.showDialog("Thông báo", "Vui lòng chọn file excel");
                    this.selected_file = null;
                    return;
                }
                this.file_name = e.target.files[0].name;
                this.tenFile = this.file_name;
            }
            // console.log("upload xong");
            // console.log("tên file:" + this.file_name);

        }
    }

}

</script>

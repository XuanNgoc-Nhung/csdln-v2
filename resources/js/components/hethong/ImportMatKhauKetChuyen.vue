<template>

    <div id="modal_import_mk_ket_chuyen" ref="modal_import_mk_ket_chuyen" class="modal fade">

        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Nhập thông tin mật khẩu kết chuyển</h4>
                </div>
                <div class="modal-body clearfix">

                    <div class="row">
                        <div class="col-lg-3"><label class="pull-right">Chọn File</label></div>
                        <div class="col-lg-9">
                            <div class="alert alert-info" style="display: inline-flex;position: relative" role="alert">
                                <div  v-if="tenFile!=''" style="position: absolute; top: 0; right: 0">
                                    <a href="#" title="Xóa file đã chọn" class="xoafile" @click.prevent="xoaFile()">x</a>
                                </div>
                                <label class="btn btn-default btn-file">
                                    <i class="fa fa-cloud-upload"></i>
                                    <span><i class="fas fa-upload"></i> Chọn file</span>
                                    <input ref="file_upload" multiple="false"
                                           name="file" style="display: none;" type="file"
                                           @change="onFileChange"
                                           aria-invalid="false"/>
                                </label>
                                <label v-if="tenFile!=''" class="btn btn-default btn-file" style="margin: 0 15px;">
                                    <span>File đã chọn: {{tenFile}}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3"><label class="pull-right">Vui lòng chọn file mẫu</label></div>
                        <div class="col-lg-9" style="">
                            <label><a :href="download_link" target="_blank">Tại đây</a></label><br><span><b>Ghi chú:</b><i><span class="red">Vui lòng lựa chọn tệp dạng *.xlsx</span></i></span>
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

    import dialog from '../../utils/dialog';
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    import api from './../api';

    $(document).ready(function () {
        // console.log("ready!");
    });
    export default {

        props: ['item', 'show'],


        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_import_mk_ket_chuyen").modal();
                } else {
                    $("#modal_import_mk_ket_chuyen").modal('hide');
                }
            }
        },
        data() {
            return {
                tenFile: '',
                selected_file: null,
                download_link:''
            }
        },


        mounted: function () {
            // console.log("mounted !!!!!");
            $(this.$refs.modal_import_mk_ket_chuyen).on("hidden.bs.modal", this.close);
            this.getDownload();
        },

        methods: {
            //xóa file đã chọn
            xoaFile(){
                console.log("xóa file đã chọn:");
                this.selected_file = null;
                this.tenFile= "";
                console.log(this.selected_file);
                console.log(this.tenFile);
            },
            async getDownload(){
                try{
                    var response = await axios.get('/api-get-api-link');
                    var api_link = response.data;
                    api_link += '/csdlgd-push/KetChuyenDL/dowloadTemplate';
                    this.download_link = api_link;
                    console.log('api_link: ' + api_link);
                }catch(err){
                    console.log(err);
                }
            },
            imPortFile() {
                console.log("Import");
                if (this.selected_file == null) {
                    utils.showDialog("Thông báo", "Vui lòng thêm chọn file import");
                    return;
                }
                utils.confirmDialog("Xác nhận Import file", "Đồng ý", () => {
                    const uri = "/api-import-mat-khau-ket-chuyen";
                    let params = new FormData();
                    params.append('file', this.selected_file);
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                    api.postForm(uri, params, (data) => {
                        loading.close();
                        let stt = JSON.parse(data.data)
                        console.log("Dữ liệu trả về:" + JSON.stringify(stt));
                        if (stt.code == 200) {
                            console.log("upload thành công");
                            utils.showDialog("Thông báo", "Import file thành công", null, () => {
                                this.$emit('success', params);
                                this.close();
                                this.reset();
                            });
                        } else {
                            utils.showDialog("Thất bại", stt.message, null, () => {
                            });
                        }
                    });


                });


            },
            close() {
                console.log("close modal");
                console.log("đóng nè ahihihihihi");
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
<style scoped="scoped">
    .xoafile{
        color: #DC0101;
        border: 1px solid black;
        padding: 0 4px;
        margin: 0;
        border-radius: 50%;
        background: snow;
        font-weight: bold;
    }
</style>

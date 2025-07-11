<template>
    <div>
        <el-dialog title="Nhập thông tin mật khẩu kết chuyển IOC" :modal-append-to-body="false" :append-to-body="false"
            :visible.sync="show" :close-on-click-modal="false" :close-on-press-escape="false" width="40%" top="10vh"
            :before-close="handleClose">
            <el-row :gutter="24">
                <el-col :span="24">
                    <label>Vui lòng tải file mẫu <a
                            href="https://dongbo.csdl.edu.vn/exportExcel/Template_Import_mat_khau_ket_chuyen_len_Ioc.xlsx"
                            target="_blank">Tại đây</a></label>
                    <div class="alert alert-info upload-custom" role="alert">
                        <el-upload accept=".xlsx" :auto-upload="false" :limit="1" class="upload-demo" drag action="/"
                            :on-remove="handleRemove" ref="elUpload" :on-success="handleSuccess"
                            style="line-height:initial" :on-change="onchange" :file-list="fileList" multiple>
                            <div class="text-center">
                                <div style="align-items: center;">
                                    <i class="el-icon-upload"></i>
                                    <div class="el-upload__text" style="color: #DC0101;">Lựa chọn hoặc kéo thả file định
                                        dạng .xlsx</div>
                                </div>
                                <div class="el-upload__tip" style="line-height:initial" slot="tip"><i
                                        class="text-primary">Tổng dung lượng không quá {{size}}MB</i></div>
                            </div>
                        </el-upload>
                    </div>
                </el-col>
                <el-col :span="24" class="text-center" v-if="false">
                    <div class="alert alert-info" style="display: inline-flex" role="alert">
                        <label class="btn btn-default btn-file">
                            <i class="fa fa-cloud-upload"></i>
                            <span><i class="el-icon-upload2"></i> Chọn file</span>
                            <input ref="file_upload" multiple="false" name="file" style="display: none;" type="file"
                                @change="onFileChange" aria-invalid="false" />
                        </label>
                        <label v-if="tenFile!=''" class="btn btn-default btn-file" style="margin: 0 15px;">
                            <span>File đã chọn: {{ tenFile }}</span>
                        </label>

                    </div>
                    <p> <span class="red">Vui lòng lựa chọn tệp dạng .xlsx</span></p>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" @click="handleClose()">Huỷ</el-button>
                <el-button size="mini" type="info" @click="imPortFile()">Tải lên</el-button>
            </span>
        </el-dialog>

        <div v-if="false" id="modal_import_mk_ket_chuyen" ref="modal_import_mk_ket_chuyen" class="modal fade"
            data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog" style="width: 60%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Nhập thông tin mật khẩu kết chuyển IOC</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <el-row :gutter="24">
                            <el-col :span="24">
                                <label>Vui lòng tải file mẫu <a
                                        href="https://dongbo.csdl.edu.vn/exportExcel/Template_Import_mat_khau_ket_chuyen_len_Ioc.xlsx"
                                        target="_blank">Tại
                                        đây</a></label>
                                <div class="alert alert-info upload-custom" role="alert">
                                    <el-upload accept=".xlsx" :auto-upload="false" :limit="1" class="upload-demo" drag
                                        action="/" :on-remove="handleRemove" ref="elUpload" :on-success="handleSuccess"
                                        style="line-height:initial" :on-change="onchange" :file-list="fileList"
                                        multiple>
                                        <div class="text-center">
                                            <div style="align-items: center;">
                                                <i class="el-icon-upload"></i>
                                                <div class="el-upload__text" style="color: #DC0101;">Lựa chọn hoặc kéo thả
                                                    file
                                                    định dạng .xlsx</div>
                                            </div>
                                            <div class="el-upload__tip" style="line-height:initial" slot="tip"><i
                                                    class="text-primary">Tổng dung lượng không quá {{size}}MB</i></div>
                                        </div>
                                    </el-upload>
                                </div>
                            </el-col>
                        </el-row>
                        <div class="row" v-if="false">
                            <div class="col-lg-3"><label class="pull-right">Chọn File</label></div>
                            <div class="col-lg-9">
                                <div class="alert alert-info" style="display: inline-flex;position: relative"
                                    role="alert">
                                    <div v-if="tenFile!=''" style="position: absolute; top: 0; right: 0">
                                        <a href="#" title="Xóa file đã chọn" class="xoafile"
                                            @click.prevent="xoaFile()">x</a>
                                    </div>
                                    <label class="btn btn-default btn-file">
                                        <i class="fa fa-cloud-upload"></i>
                                        <span><i class="fas fa-upload"></i> Chọn file</span>
                                        <input ref="file_upload" multiple="false" name="file" style="display: none;"
                                            type="file" @change="onFileChange" aria-invalid="false" />
                                    </label>
                                    <label v-if="tenFile!=''" class="btn btn-default btn-file" style="margin: 0 15px;">
                                        <span>File đã chọn: {{tenFile}}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row" v-if="false">
                            <div class="col-lg-3"><label class="pull-right">Vui lòng chọn file mẫu</label></div>
                            <div class="col-lg-9" style="">
                                <label>
                                    <a tittle="download file template"
                                        href="https://dongbo.csdl.edu.vn/exportExcel/Template_Import_mat_khau_ket_chuyen_len_Ioc.xlsx">
                                        <b>
                                            <i>File template mẫu.</i>
                                        </b>
                                    </a></label><br><span><b>Ghi chú:</b><i><span class="red">Vui lòng lựa chọn tệp dạng
                                            *.xlsx</span></i></span>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <el-button plain type="default" @click.prevent="handleClose">Hủy
                        </el-button>
                        <el-button plain type="info" size="mini" v-on:click="imPortFile()">Nhập
                        </el-button>
                    </div>
                </div>


            </div>

        </div>
    </div>

</template>

<script>
    import dialog from '../../../utils/dialog';
    import utils from '../../../utils'
    import api from './../../api';

    $(document).ready(function () {
        // console.log("ready!");
    });
    export default {

        props: ['item', 'show'],


        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.selected_file = null;
                    this.fileList = [];
                } else {}
            }
        },
        data() {
            return {
                tenFile: '',
                selected_file: null,
                download_link: '',
                fileList: [],
                size: 3
            }
        },
        mounted: function () {
            // console.log("mounted !!!!!");
            this.getDownload();
        },
        methods: {
            handleClose() {
                console.log("handleClose");
                let checkFile = !this.selected_file || this.selected_file == null || !this.fileList || this.fileList.length == 0;
                console.log(this.selected_file);
                console.log(this.fileList);
                console.log(checkFile);
                if (!checkFile) {
                    this.$confirm(
                            'Các thông tin vừa nhập sẽ bị mất khi đóng trang. Thầy cô có muốn tiếp tục chỉnh sửa, kiểm tra và lưu lại thông tin đã nhập?',
                            'Thông báo', {
                                confirmButtonText: 'Rời khỏi trang',
                                cancelButtonText: 'Tiếp tục chỉnh sửa',
                                confirmButtonClass: 'el-button--danger',
                                closeOnClickModal: false,
                            })
                        .then(_ => {
                            this.selected_file = null;
                            this.reset();
                            this.$emit('close');
                        })
                        .catch(_ => {});

                } else {

                    this.selected_file = null;
                    this.close();
                    this.reset();
                }
            },
            handleRemove() {
                console.log("Xóa file")
                this.selected_file = null;
                this.fileList = [];
            },
            handleSuccess() {},
            onchange(file, fileList) {
                let listType = ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

                let size;
                size = this.size

                if (!file) {
                    this.fileList = [];
                    this.selected_file = null
                    return
                }
                const type = listType.includes(file.raw.type);
                const isLt2M = file.raw.size / 1024 / 1024 < size;

                if (!type) {
                    this.thongBao('error', 'Vui lòng chọn file định dạng excel .xlsx')
                    // dialog.showDialog('Thông báo', 'Vui lòng chọn file định dạng excel .xlsx')
                    this.fileList = [];
                    this.selected_file = null
                    return
                }
                if (!isLt2M) {
                    let msg = 'Vui lòng chọn file nhỏ hơn ' + size + 'MB'
                    this.thongBao('error', msg)
                    this.fileList = [];
                    this.selected_file = null
                    return;
                }
                this.fileList = []
                this.fileList = fileList.filter((item, index) => {
                    return index === fileList.length - 1
                })
                this.selected_file = new Blob([file.raw], {
                    type: file.type
                });
                return false;
            },
            //xóa file đã chọn
            xoaFile() {
                console.log("xóa file đã chọn:");
                this.selected_file = null;
                this.tenFile = "";
                console.log(this.selected_file);
                console.log(this.tenFile);
            },
            async getDownload() {
                try {
                    var response = await axios.get('/api-get-api-link');
                    var api_link = response.data;
                    api_link += '/csdlgd-push/KetChuyenDL/dowloadTemplate';
                    this.download_link = api_link;
                    console.log('api_link: ' + api_link);
                } catch (err) {
                    console.log(err);
                }
            },
            imPortFile() {
                console.log("Import");
                if (this.selected_file == null) {
                    this.thongBao('error', 'Vui lòng chọn thêm file')
                    return;
                }

                this.$confirm('Xác nhận Import file?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const uri = "/api-import-mat-khau-ket-chuyen-ioc";
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
                                // utils.showDialog("Thông báo", "Import file thành công", null, () => {
                                //     this.$emit('success', params);
                                //     this.close();
                                //     this.reset();
                                // });
                                this.thongBao('success', 'Nhập lên thành công')
                                this.close();
                                this.reset();
                            } else {
                                this.thongBao('error', stt.message)
                            }
                        });

                    })
                    .catch(_ => {});
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
<style>
    .xoafile {
        color: #DC0101;
        border: 1px solid black;
        padding: 0 4px;
        margin: 0;
        border-radius: 50%;
        background: snow;
        font-weight: bold;
    }

    .upload-custom .el-upload-dragger {
        width: 100%;
        height: auto;
        padding: 15px;
        text-align: left;
    }

    .upload-custom .el-upload-list__item-name:hover {
        color: #333333;
        max-height: 30px;
    }

    .upload-custom .el-upload-list__item {
        color: #333333;
        max-height: 30px;
    }

    .upload-custom .el-upload-list__item:hover a {
        color: #333333;
        max-height: 30px;
    }

    .upload-custom .el-upload-dragger .el-icon-upload {
        margin: 0;
        color: #333333;
        font-size: 22px;
        line-height: 22px;
    }

    .upload-custom .el-upload-list__item-name [class^=el-icon] {
        color: #ffffff;
        max-height: 30px;
    }

    .upload-custom .el-upload-list__item:hover [class^=el-icon] {
        color: #333333;
        max-height: 30px;
    }

    .upload-custom .alert a {
        color: #333333;
    }

    .upload-custom .el-upload {
        display: block;
        text-align: center;
    }

    .upload-custom.alert a,
    .upload-custom.alert a i {
        color: #000 !important;
    }

    .upload-custom a {
        cursor: pointer !important;
    }

    .el-upload__input {
        display: none !important
    }

    .el-upload-list {
        max-height: 30px !important;
    }

    input.el-upload__input {
        display: none;
    }

</style>

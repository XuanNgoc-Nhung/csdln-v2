<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog :title="info.title" :modal-append-to-body="false" :append-to-body="false" :visible.sync="show_import"
            :close-on-click-modal="false" :close-on-press-escape="false" width="40%" top="10vh"
            :before-close="handleClose">
            <el-row :gutter="24">
                <el-col :span="24">
                    <label>Vui lòng tải file mẫu <a :href="info.pathTemplate" target="_blank">Tại đây</a></label>
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
        <el-dialog :close-on-click-modal="false" :close-on-press-escape="false"
            title="Có lỗi trong quá trình import file" width="40%" :modal-append-to-body="false" :append-to-body="false"
            :visible.sync="show_thong_tin_import_loi" :before-close="handleClose2nd">
            <el-row :gutter="24">
                <el-col :span="24" class="text-center">
                    <p><span style="color:#DC0101">File import có một số thông tin lỗi. Bạn hãy khắc phục để thực hiện
                            import.</span>
                    </p>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" @click="handleClose()">Huỷ</el-button>
                <el-button size="mini" type="primary" @click="downLoadFileErr()">Tải xuống</el-button>
            </span>
        </el-dialog>
    </div>
</template>

<script>
    import dialog from '../../../utils/dialog';
    import api from './../../api';

    export default {
        props: ['show', 'info'],
        watch: {
            fileList: function (newVal) {
                console.log('File thay đổi')
                console.log(newVal)
            },
            show: function (newVal) {
                console.log('show thay đổi:' + newVal)
                this.show_import = newVal;
                this.info.pathTemplate = this.info.pathTemplate + '?t=' + this.getTime();
            }
        },
        data() {
            return {
                check_confirm_come_back: false,
                thongtin: JSON.parse(window.userInfo),
                loading: {
                    status: false,
                    text: 'Loading...'
                },
                link_template: '',
                show_thong_tin_import_loi: false,
                show_import: false,
                tenFile: '',
                linkImportLoi: '',
                fileList: [],
                size: 3
            }
        },


        mounted: function () {
            console.log('Mounted import file...')
            console.log(this.info)
            this.download_link = this.thongtin.tenMien + '';
        },

        methods: {
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
            handleClose2nd() {
                this.show_thong_tin_import_loi = false;
            },
            handleClose() {
                console.log("handleClose");
                let checkFile = !this.selected_file || this.selected_file == null || !this.fileList || this.fileList.length == 0;
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
                            this.show_thong_tin_import_loi = false;
                            this.selected_file = null;
                            this.reset();
                            this.$emit('close');
                        })
                        .catch(_ => {});
                } else {
                    this.show_thong_tin_import_loi = false;
                    this.selected_file = null;
                    this.reset();
                    this.$emit('close');
                }
            },
            getTime() {
                let now = new Date();
                let timestamp = now.getTime();
                return timestamp
            },
            imPortFile() {
                console.log("xác nhận import");
                console.log(this.selected_file)
                if (!this.selected_file || this.selected_file == null || !this.fileList || this.fileList.length == 0) {
                    this.thongBao('error', 'Vui lòng thêm file nhập')
                    return;
                }
                this.$confirm('Xác nhận tải lên?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        closeOnClickModal: false,
                        cancelButtonText: 'Hủy',
                    })
                    .then(_ => {
                        console.log('Đẩy file:')
                        let uri = this.info.pathImport;
                        let params = new FormData();
                        params.append('file', this.selected_file);
                        this.loading.status = true;
                        api.postForm(uri, params, (data) => {
                            let stt = JSON.parse(data.data)
                            console.log("Dữ liệu import trả về:");
                            console.log(stt)
                            if (stt.code == 0) {
                                this.thongBao('success', stt.message);
                            } else if (stt.code == 1) {
                                this.thongBao('error', stt.message)
                                this.show_thong_tin_import_loi = true;
                                this.linkImportLoi = stt.urlLoi;
                                console.log(this.linkImportLoi)
                            } else {
                                this.thongBao('error', stt.message)
                            }
                            this.loading.status = false;
                        });
                    })
                    .catch(_ => {});
            },
            downLoadFileErr() {
                window.open(this.linkImportLoi, '_blank');
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
                this.reset();
                this.$emit('close');
            },
            reset() {
                this.selected_file = '';
                this.fileList = [];
                this.tenFile = '';
            },
            onFileChange(e) {
                console.log("chọn file");
                const files = e.target.files;
                this.tenFile = '';
                if (!files) {
                    this.thongBao('error', 'Trình duyệt không hỗ trợ tải lên')
                    // dialog.showDialog("Thông báo", "Trình duyệt không hỗ trợ upload file");
                    return;
                }
                this.selected_file = files[0];
                // const size = parseInt(this.selected_file.size);
                // console.log("kích thước file:"+ size);
                if (files && files[0]) {
                    let fileType = this.selected_file["type"];
                    let ValidImageTypes = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                        // dialog.showDialog("Thông báo", "Vui lòng chọn file excel");
                        this.thongBao('error', 'Vui lòng chỉ tải lên file định dạng excel')
                        this.selected_file = null;
                        return;
                    }
                    this.file_name = e.target.files[0].name;
                    this.tenFile = this.file_name;
                }
            }
        }

    }

</script>

<style>
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

</style>

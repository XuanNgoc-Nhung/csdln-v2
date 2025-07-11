<template>

    <div id="modal_import_phuongxa" ref="modal_import_phuongxa" class="modal fade">

        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="close()">
                        &times;
                    </button>
                    <h4 v-if="TypeImport==1" class="modal-title text-uppercase">Nhập Dữ liệu giáo viên sso</h4>
                    <h4 v-if="TypeImport==2" class="modal-title text-uppercase">Nhập Dữ liệu học sinh sso</h4>
                    <h4 v-if="TypeImport==3" class="modal-title text-uppercase">Nhập Dữ liệu cán bộ phòng/sở</h4>
                </div>
                <div class="modal-body clearfix">

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-info" style="display: inline-flex;position: relative" role="alert">
                                <div  v-if="tenFile!=''" style="position: absolute; top: 0; right: 0">
                                    <a href="#" title="Xóa file đã chọn"class="xoafile" @click.prevent="xoaFile()">x</a>
                                </div>
                                <label class="btn btn-default btn-file">
                                    <i class="fa fa-cloud-upload"></i>
                                    <span>
                                        <i class="fas fa-upload"></i>
                                        Chọn file</span>
                                    <input
                                        ref="file_upload"
                                        multiple="false"
                                        name="file"
                                        style="display: none;"
                                        type="file"
                                        @change="onFileChange"
                                        aria-invalid="false"/>
                                </label>
                                <label
                                    v-if="tenFile!=''"
                                    class="btn btn-default btn-file"
                                    style="margin: 0 15px;">
                                    <span>File đã chọn:
                                        {{tenFile}}</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <span>
                                <b>Ghi chú:</b>Vui lòng Import dữ liệu theo đúng file mẫu. Nếu chưa có file mẫu
                                vui lòng tải xuống
                                <a
                                    v-if="TypeImport==1"
                                    href="https://dongbo.csdl.edu.vn/exportExcel/FileUpLoadDuLieuGiaoVien.xlsx">
                                    <b>
                                        <i>Template giáo viên.</i>
                                    </b>
                                </a>
                                <a
                                    v-if="TypeImport==2"
                                    href="https://dongbo.csdl.edu.vn/exportExcel/FileUpLoadDuLieuHocSinh.xlsx">
                                    <b>
                                        <i>Template học sinh.</i>
                                    </b>
                                </a>
                                <a v-if="TypeImport==3"
                                   tittle="download file template"
                                    href="https://dongbo.csdl.edu.vn/exportExcel/FileUpLoadDuLieuCanbo.xlsx">
                                    <b>
                                        <i>Template cán bộ phòng sở.</i>
                                    </b>
                                </a>
                            </span>
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
        <div v-if="show_loi">
            <XemChiTietLoi :banghi="ThongTinCacBanLoi" @closeinfo="CloseInFo()"></XemChiTietLoi>
        </div>
    </div>

</template>

<script>

    import dialog from '../../../js/utils/dialog';
    import utils from '../../../js/utils';
    import rest_api from '../../../js/utils/rest_api';
    import api from './../api';
    import XemChiTietLoi from './ThongTinCacBanLoiImport';
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

    $(document).ready(function () {
        console.log("ready!");
    });
    export default {

        props: [
            'item', 'show', 'nh'
        ],

        components: {
            "XemChiTietLoi": XemChiTietLoi
        },
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_import_phuongxa").modal();
                } else {
                    $("#modal_import_phuongxa").modal('hide');
                }
            },
            nh: function (newVal, oldVal) {
                this.namHoc = newVal;
            },
            item: function (newVal) {
                console.log("Loại dữ liệu:" + this.TypeImport);
                if (newVal) {
                    this.TypeImport = newVal;
                    if (this.TypeImport == 1) {
                        this.uri = "/api-import-du-lieu-sso-giao-vien";
                        console.log("giáo viên");
                    } else  {
                        if(this.TypeImport==2){
                            this.uri = "/api-import-du-lieu-sso-hoc-sinh";
                            console.log("Học sinh");
                        }
                        else{
                            console.log("cán bộ phòng sởs");
                            this.uri = "/api-import-du-lieu-sso-can-bo-phong-so";
                        }
                    }
                }
            }
        },
        data() {
            return {
                show_loi: false,
                tenFile: '',
                danh_sach_dinh_dang_excel:[
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                    "application/vnd.ms-excel.sheet.macroEnabled.12",
                    "application/vnd.ms-excel",
                    "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
                ],
                selected_file: null,
                download_link: '',
                ThongTinCacBanLoi: {},
                TypeImport: '',
                uri: "",
                namHoc: ""
            }
        },

        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_import_phuongxa).on("hidden.bs.modal", this.close);
            this.getDownload();
        },

        methods: {
            //Xóa file đã chọn
            xoaFile(){
                console.log("xóa file đã chọn:");
                this.selected_file = null;
                this.tenFile= "";
                console.log(this.selected_file);
                console.log(this.tenFile);},
            async getDownload() {
                try {
                    var response = await axios.get('/api-get-api-link');
                    var api_link = response.data;
                    api_link += '/dmCNganhDTao/downloadTemplate';
                    this.download_link = api_link;
                    console.log('api_link: ' + api_link);
                } catch (err) {
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
                    console.log(this.uri);
                    let params = new FormData();
                    params.append('file', this.selected_file);
                    params.append('namHoc', this.namHoc);
                    api.postForm(this.uri, params, (data) => {
                        let stt = JSON.parse(data.data);
                         if (stt.rc === 0) {
                            this
                                .$alertify
                                .success("Import file thành công.");
                            this.showLoiImport(stt);
                            this.reset();
                            this.xoaFile();
                            this.$emit('done');
                        } else {
                            this
                                .$alertify
                                .error("Import file không thành công. Vui lòng thử lại");
                            this.showLoiImport(stt);
                            this.xoaFile();
                            this.reset();
                        }
                    });
                });
            },
            CloseInFo() {
                console.log("Đóng xem thông tin lỗi");
                // window.location.reload();
            },
            showLoiImport(e) {
                console.log("hiển thị lỗi của:" + e);
                this.ThongTinCacBanLoi = e;
                this.show_loi = true
                console.log(this.ThongTinCacBanLoi);

            },
            close() {
                this.show_loi = false;
                this.selected_file = null;
                this.tenFile = '';
                console.log("close modal 2");
                this.reset();
                this.$emit('close');
            },
            reset() {
                this.selected_file = null;
                this.tenFile = '';
            },
            onFileChange(e) {
                const files = e.target.files;
                this.tenFile = '';
                if (!files) {
                    dialog.showDialog("Thông báo", "Trình duyệt không hỗ trợ upload file");
                    return;
                }
                this.selected_file = files[0];
                const size = parseInt(this.selected_file.size); console.log("kích thước file:"+ size);
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
                // console.log("upload xong"); console.log("tên file:" + this.file_name);

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

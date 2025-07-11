<template>
    <div v-loading="loading" element-loading-text="Loading..." element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog :title="thongtin.role==5?'Nộp dữ liệu':('Thêm file cho báo cáo '+ banghi.tenBaoCao)"
            :visible.sync="thongtin_nhanduoc" width="70%" append-to-body>
            <form>
                <el-row :gutter="24">
                    <el-col :span="24" class="text-center">
                        <el-upload v-if="false" accept=".xlsx" :auto-upload="false" :limit="1" class="upload-demo" drag action="/"
                            :on-remove="handleRemove" ref="elUpload" :on-success="handleSuccess"
                            style="line-height:initial" :on-change="onFileChange" :file-list="fileList" multiple>
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
                        <label class="btn btn-default button-file btn-file" tabindex="0" id="lblFile">
                            <i class="fa fa-cloud-upload"></i>
                            Chọn File (<span style="color:#DC0101">*</span>)
                            <div v-if="!tenFile">
                                <small class="text-primary">
                                    <em>Tổng dung lượng không quá 10MB</em>
                                </small>
                                <br />
                                <small class="text-secondary">
                                    <em>Định dạng file hợp lệ: *.xlsx
                                    </em>
                                </small>
                            </div>
                            <div v-if="tenFile">
                                <small>
                                    <em>File đã chọn:
                                        <b>{{tenFile}}</b>
                                    </em>
                                </small>
                                <br />
                            </div>
                            <input ref="file_upload" multiple="false" name="file" style="display: none;" type="file"
                                @change="onFileChange" aria-invalid="false" />
                        </label>
                    </el-col>
                    <el-col :span="24">
                        <h5 style="padding: 0; margin:0">Hướng dẫn thêm file biểu mẫu hợp lệ:</h5>

                    </el-col>
                    <el-col :span="24">
                        <div class="text-center">
                            <div style="">
                                <img src="images/excelupdate.png" alt="Hình ảnh" width="100%"
                                    title="Hình ảnh hướng dẫn">

                            </div>
                        </div>
                    </el-col>
                </el-row>
            </form>
            <span slot="footer" class="dialog-footer">
                <el-button class="bt-phu" type="default" @click="closeThongTin" size="mini">Đóng</el-button>
                <el-button class="bt-chinh" size="mini" type="primary" @click.prevent="ThemFile()">Tải lên</el-button>
            </span>
            <div class="modal-dialog-fullscreen" v-if="banghi&&false" style="">
                <div class="modal-content-fullscreen">
                    <div class="modal-header-fullscreen">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            v-on:click="close()">
                            &times;
                        </button>
                        <h4 v-if="thongtin.role==5" class="modal-title text-uppercase">Nộp dữ liệu</h4>
                        <h4 v-else="v-else" class="modal-title text-uppercase">Thêm file cho báo cáo
                            {{ banghi.tenBaoCao }}</h4>
                    </div>
                    <div class="modal-body-fullscreen">
                        <div class="row text-center" style="margin:0">
                            <div class="col-md-12">
                                <!-- Hết ngày kết thúc -->
                                <div class="col-md-12">
                                    <div class="row" style="margin:0">
                                        <div class="col-md-12">
                                            <label class="btn btn-default button-file btn-file" tabindex="0"
                                                id="lblFile">
                                                <i class="fa fa-cloud-upload"></i>
                                                Chọn File (<span style="color:#DC0101">*</span>)
                                                <div v-if="!tenFile">
                                                    <small class="text-primary">
                                                        <em>Tổng dung lượng không quá 10MB</em>
                                                    </small>
                                                    <br />
                                                    <small class="text-secondary">
                                                        <em>Định dạng file hợp lệ: *.xlsx
                                                        </em>
                                                    </small>
                                                </div>
                                                <div v-if="tenFile">
                                                    <small>
                                                        <em>File đã chọn:
                                                            <b>{{tenFile}}</b>
                                                        </em>
                                                    </small>
                                                    <br />
                                                </div>
                                                <input ref="file_upload" multiple="false" name="file"
                                                    style="display: none;" type="file" @change="onFileChange"
                                                    aria-invalid="false" />
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="1==2" class="row">
                            <div class="col-md-12">
                                <h5>Hướng dẫn thêm file hợp lệ cho biểu mẫu:</h5>
                                <h6><b>File Excel hợp lệ</b></h6>
                                <ul>
                                    <li>
                                        <p>Dữ liệu hợp lệ được tính theo cột từ A tới ZZ và đến 1000 dòng. Ngoài vùng
                                            trên
                                            hệ thống phần mềm không kiểm soát được dữ liệu.</p>
                                    </li>
                                </ul>
                                <h6><b>Đánh dấu tiêu trí trên file Excel</b></h6>
                                <ul>
                                    <li>
                                        <p>Bôi vàng các tiêu chí, nội dung cần tổng hợp.</p>
                                    </li>
                                    <li>
                                        <p>Chọn đúng màu vàng của excel thì hệ thống mới nhận biết được. Ngoài ra các
                                            màu
                                            khác hệ thống không nhận biết được.</p>
                                    </li>
                                </ul>
                                <!-- <div class="text-center">
                                <div style="height: 250px; overflow-y: scroll;">
                                    <img src="images/excelBieuMau.jpg" alt="Hình ảnh" width="50%" title="Hình ảnh hướng dẫn">
                                </div>
                            </div> -->
                            </div>
                        </div>
                        <div class="row" style="margin:0">
                            <div class="col-md-12">
                                <h5>Hướng dẫn thêm file biểu mẫu hợp lệ:</h5>
                                <div class="text-center">
                                    <div style="">
                                        <img src="images/excelupdate.png" alt="Hình ảnh" width="80%"
                                            title="Hình ảnh hướng dẫn">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer-fullscreen">
                        <el-button type="default" size="mini" style="margin:0 5px;" @click="closeThongTin">Đóng
                        </el-button>
                        <el-button type="primary" size="mini" @click.prevent="ThemFile()">Tải lên
                        </el-button>
                    </div>
                </div>
            </div>
        </el-dialog>
        <el-dialog title="Lỗi import file" width="70%" :visible.sync="show_thong_tin_loi">
            <div style="max-height:50vh; overflow: scroll;">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover"
                        style="font-size:12px; width:max-content;max-width:max-content;min-width:100%">
                        <thead style="background: #e4ebf5">
                            <tr>
                                <th class="text-center">
                                    <p>STT</p>
                                </th>
                                <th class="text-center">
                                    <p>Vị trí và mô tả lỗi</p>
                                </th>
                            </tr>
                        </thead>
                        <tbody v-if="errorList.length==0">
                            <tr>
                                <td colspan="2" class="text-center">
                                    <p>Không có dữ liệu</p>
                                </td>
                            </tr>
                        </tbody>
                        <tbody>
                            <tr v-for="(hs,i) in errorList">
                                <td class="text-center">
                                    <p>{{i+1}}</p>
                                </td>
                                <td>
                                    <p>{{hs}}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </el-dialog>
    </div>

</template>

<script>
    import api from './../../api';
    import dialog from '../../../utils/dialog';
    import utils from '../../../../js/utils';
    $(document).ready(function () {});
    export default {
        props: ['banghi', 'show'],
        watch: {
            banghi: function (newVal) {
                console.log("các bản ghi loi");
                if (newVal) {
                    // this.thongtin_nhanduoc = true;
                }
            },
            show: function (val) {
                console.log("val thay đổi" + val)
                if (val) {
                    this.thongtin_nhanduoc = true;
                    this.selected_file = null;
                    this.tenFile = '';
                } else {
                    this.thongtin_nhanduoc = false;

                }
            }
        },

        data() {
            return {
                tenFile: '',
                loading: false,
                show_thong_tin_loi: false,
                msgErr: '',
                errorList: [],
                fileList: [],
                thongtin: {},
                selected_file: null,
                thongtin_nhanduoc: false,
                token: window.token,
                userInfo: JSON.parse(window.userInfo)
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            console.log("bản ghi trong thêm mới:" + JSON.stringify(this.banghi));
        },

        methods: {
            closeThongTin() {
                this.selected_file = null;
                this.thongtin_nhanduoc = false;
                this.reset();
                this.$emit('close');
            },
            HuongDan() {
                $('#chitiet_truongdanop').modal('show');
            },
            reset() {},
            close() {
                console.log("Đóng modal này");

                this.reset();
                this.$emit('close');
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
            ThemFile() {
                if (!this.selected_file) {
                    this.thongBao('error', 'Vui lòng thêm file import')
                    return;
                }
                console.log("ahihihi")
                let formData = new FormData();
                let headers = {
                    'Content-Type': 'multipart/form-data',
                    'token': token
                }
                formData.append("file", this.selected_file);
                let url = "";
                if (this.thongtin.role != 5) {
                    console.log("url 1");
                    url = '/upload-file-bieu-mau?type=1&id=' + this.banghi.id + '&maDonVi=' + this.userInfo.ma_don_vi +
                        '&userId=' + this.userInfo.username + '&roleId=' + this.userInfo.role +
                        '&maSo=' + this.userInfo.ma_so;
                    if (this.thongtin.role == 4) {
                        if (!this.banghi.baoCaoPhongNop) {
                            url = '/upload-file-bieu-mau?type=1&id=' + this.banghi.id + '&maPhong=' +
                                this.thongtin.ma_don_vi.toUpperCase() + '&roleId=' + this.userInfo.role;
                        } else {
                            url = '/upload-file-bieu-mau?type=2&id=' + this.banghi.idBieuMauPhongNop + '&maPhong=' +
                                this.thongtin.ma_don_vi.toUpperCase() + '&roleId=' + this.userInfo.role;
                        }
                    }
                } else {
                    console.log("url 2");
                    url = '/upload-file-bieu-mau?type=2&id=' + this.banghi.id + '&maTruongHoc=' +
                        this.thongtin.ma_truong_hoc.toUpperCase() + '&roleId=' + this.userInfo.role;
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Vui lòng chờ trong giây lát...',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                axios
                    .post(url, formData, headers)
                    .then(response => {
                        loading.close();
                        console.log("trả về:");
                        console.log(JSON.stringify(response));
                        if (response.data.rc == 0) {
                            this.thongBao('success', 'Upload dữ liệu thành công')
                            this.doneUpload();
                        } else {
                            this.msgErr = response.data.rd;
                            this.errorList = response.data.errorList;
                            if (this.errorList == null || this.errorList.length == 0) {
                                this.errorList = [];
                                this.thongBao('error', response.data.rd)
                            } else {
                                this.show_thong_tin_loi = true;
                            }
                        }
                    })
                    .catch(error => {
                        this.response = 'Thất bại: ' + error.response;
                    });
            },
            // doneUpload
            doneUpload() {
                this.$confirm('Import file thành công. Tiến hành làm mới dữ liệu??', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Để sau',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        location.reload();
                    })
                    .catch(_ => {});
            },

            // Chọn file

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
            handleRemove(){
                console.log('handleRemove');
            },
            handleSuccess(){
                console.log('handleSuccess');
            },
            onFileChange(e) {
                console.log("chọn file");
                const files = e.target.files;
                this.tenFile = '';
                if (!files) {
                    this.thongBao('error', "Trình duyệt không hỗ trợ upload file");
                    return;
                }
                this.selected_file = files[0];
                // const size = parseInt(this.selected_file.size); console.log("kích thước
                // file:"+ size);
                if (files && files[0]) {
                    let fileType = this.selected_file["type"];
                    console.log('file typr:')

                    console.log(fileType)
                    let ValidImageTypes = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                        "application/vnd.ms-excel"
                    ];
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                        this.thongBao('error', "Vui lòng chọn file excel");
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
    .v-modal {
        display: none;
    }

</style>

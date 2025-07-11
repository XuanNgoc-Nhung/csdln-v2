<template>
    <div>
        <el-dialog title="Import file" fullscreen :visible.sync="thongtin_nhanduoc">
            <div class="modal-dialog-fullscreen" v-if="banghi" style="">
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
                        <el-button type="danger" size="mini" style="margin:0 5px;" @click="closeThongTin">Đóng
                        </el-button>
                        <el-button type="primary" size="mini" @click.prevent="ThemFile()">Thêm
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
    import api from './../api';
    import dialog from '../../utils/dialog';
    import utils from '../../../js/utils';
    $(document).ready(function () {});
    export default {

        props: ['banghi','show'],
        watch: {
            banghi: function (newVal) {
                console.log("các bản ghi loi");
                // this.thongtin_nhanduoc = true;
            },
            show:function(val){
                console.log("val thay đổi" + val)
                if(val){

                this.thongtin_nhanduoc = true;
                }
                else{
                this.thongtin_nhanduoc = false;

                }
            }
        },

        data() {
            return {
                tenFile: '',
                show_thong_tin_loi: false,
                msgErr: '',
                errorList: [],
                thongtin: {},
                selected_file: null,
                thongtin_nhanduoc: false,
                token: window.token,
                userInfo: JSON.parse(window.userInfo)
            }
        },
        mounted: function () {
            // gán biến thông tin đăng nhập
            this.thongtin = JSON.parse(window.userInfo);
            console.log("bản ghi trong thêm mới:" + JSON.stringify(this.banghi));
            // $("#thongtin_nhanduoc").modal();
            // $(this.$refs.thongtin_nhanduoc).on("hidden.bs.modal", this.close);
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
                let formData = new FormData();
                let headers = {
                    'Content-Type': 'multipart/form-data',
                    'token': token
                }
                formData.append("file", this.selected_file);
                let url = "";
                if (this.thongtin.role != 5) {
                    console.log("url 1");
                    url = '/nop-bieu-mau/upload?id=' + this.banghi.id + '&maDonVi=' + this.userInfo.ma_don_vi +
                        '&userId=' + this.userInfo.username + '&roleId=' + this.userInfo.role +
                        '&maSo=' + this.userInfo.ma_so;
                } else {
                    console.log("url 2");
                    url = '/nop-bieu-mau/truong-nop-bc?id=' + this.banghi.id + '&maTruongHoc=' +
                        this.thongtin.ma_truong_hoc + '&roleId=' + this.userInfo.role;
                }

                console.log(this.userInfo.ma_don_vi);
                console.log(this.userInfo.role);
                console.log(this.userInfo.ma_so);
                console.log(this.banghi.id);
                console.log(this.selected_file);
                console.log(url);
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                axios
                    .post(url, formData, headers)
                    .then(response => {
                        loading.close();
                        console.log("trả về:");
                        console.log(JSON.stringify(response));
                        this.success = 'Upload dữ liệu thành công';
                        this.response = JSON.stringify(response, null, 2);
                        if (response.data.rc == 0) {
                            this.thongBao('success', 'Upload dữ liệu thành công')
                            this.doneUpload();
                        } else {
                            this.msgErr = response.data.rd;
                            this.errorList = response.data.errorList;
                            if (this.errorList == null || this.errorList.length == 0) {
                                this.errorList=[];
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
                dialog.confirmDialog(
                    "Import file thành công. Tiến hành làm mới dữ liệu?",
                    "Đồng ý",
                    () => {
                        location.reload();
                    }
                );
            },

            // Chọn file

            onFileChange(e) {
                console.log("chọn file");
                const files = e.target.files;
                this.tenFile = '';
                if (!files) {
                    dialog.showDialog("Thông báo", "Trình duyệt không hỗ trợ upload file");
                    return;
                }
                this.selected_file = files[0];
                // const size = parseInt(this.selected_file.size); console.log("kích thước
                // file:"+ size);
                if (files && files[0]) {
                    let fileType = this.selected_file["type"];
                    console.log('file typr:')

                    console.log(fileType)
                    let ValidImageTypes = ["application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"];
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
    @import "../../../../node_modules/css-custom.css";

    img {
        width: 70%;
    }

</style>

<template>

    <div id="modal_import_tothon" ref="modal_import_tothon" class="modal fade">

        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Nhập gói cước giáo vin từ file Excel</h4>
                </div>
                <div class="modal-body clearfix">

                    <div class="row">
                        <div class="col-lg-3"><label class="pull-right">Chọn File</label></div>
                        <div class="col-lg-9">
                            <div class="alert alert-info" style="display: inline-flex" role="alert">
                                <label class="btn btn-default btn-file">
                                    <i class="fa fa-cloud-upload"></i>
                                    <span><i class="fas fa-upload"></i> Chọn file</span>
                                    <input ref="file_upload" multiple="false"
                                           name="file" style="display: none;" type="file"
                                           @change="onFileChange"
                                           aria-invalid="false"/>
                                </label>
                                <label v-if="tenFile!=''" class="btn btn-default btn-file" style="margin: 0 15px;">
                                    <span>File đã chọn: {{ tenFile }}</span>
                                </label>
                            </div>
                        </div>
                        <el-dialog
                            :title="dataErr.rd"
                            :visible.sync="show_thong_bao_loi"
                            width="40%"
                            top="5vh"
                            append-to-body
                            :before-close="handleClose">
                            <el-tabs type="border-card2">
                                <el-tab-pane label="Thành công">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr style="background:rgb(228, 235, 245)">
                                                <th>
                                                    <p>STT</p>
                                                </th>
                                                <th>
                                                    <p>CCCD/CMT</p>
                                                </th>
                                                <th>
                                                    <p>Mô tả</p>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody v-if="dataErr.dsThanhCong.length===0">
                                            <tr>
                                                <td class="text-center" colspan="4">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tbody v-else>
                                            <tr v-for="(tg,index) in dataErr.dsThanhCong">
                                                <td class="text-center">
                                                    {{ index + 1 }}
                                                </td>
                                                <td>
                                                    <p>{{ tg }}</p>
                                                </td>
                                                <td>
                                                    <p>Thành công</p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </el-tab-pane>
                                <el-tab-pane label="Thất bại">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                            <tr style="background:rgb(228, 235, 245)">
                                                <th>
                                                    <p>STT</p>
                                                </th>
                                                <th>
                                                    <p>CCCD/CMT</p>
                                                </th>
                                                <th>
                                                    <p>Mô tả</p>
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody v-if="dataErr.dsThatBai.length===0">
                                            <tr>
                                                <td class="text-center" colspan="4">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                            </tbody>
                                            <tbody v-else>
                                            <tr v-for="(tg,index) in dataErr.dsThatBai">
                                                <td class="text-center">
                                                    {{ index + 1 }}
                                                </td>
                                                <td>
                                                    <p>{{ tg.cmt }}</p>
                                                </td>
                                                <td>
                                                    <p>{{ tg.lyDo }}</p>
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </el-tab-pane>
                            </el-tabs>
                            <span slot="footer" class="dialog-footer">
    <el-button type="danger" @click="show_thong_bao_loi = false" size="mini">Đóng</el-button>
  </span>
                        </el-dialog>
                    </div>
                    <div class="row">
                        <div class="col-lg-3"><label class="pull-right">Vui lòng chọn file mẫu</label></div>
                        <div class="col-lg-9">
                            <!--                            <label><a disabled :href="download_link" target="_blank">Tại đây</a></label>-->
                            <b><b style="color:blue">Tại đây</b></b>
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
import api from './../api';
export default {
  props: {
  },
    props: ['item', 'show'],
    watch: {
        show: function (newVal, oldVal) {
            console.log("newVal = " + newVal);
            if (newVal) {
                $("#modal_import_tothon").modal();
            } else {
                $("#modal_import_tothon").modal('hide');
            }
        }
    },
    data() {
        return {
            tenFile: '',
            selected_file: null,
            download_link: '',
            show_thong_bao_loi: false,
            dataErr: {
                dsThanhCong:[],
                dsThatBai:[]
            }
        }
    },
    mounted: function () {
        console.log("mounted !!!!!");
        $(this.$refs.modal_import_tothon).on("hidden.bs.modal", this.close);
    },
    methods: {
        handleClose() {
            this.show_thong_bao_loi = false;
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
        imPortFile() {
            console.log("Import");
            if (this.selected_file == null) {
                utils.showDialog("Thông báo", "Vui lòng thêm chọn file import");
                return;
            }
            utils.confirmDialog("Xác nhận Import file", "Xác nhận", () => {
                const uri = "/api-import-goi-cuoc-ca";
                let params = new FormData();
                params.append('file', this.selected_file);
                api.postForm(uri, params, (data) => {
                    let stt = JSON.parse(data.data)
                    console.error(stt)
                    if (stt.code == 200) {
                        console.log("upload thành công");
                        utils.showDialog("Thông báo", "Import file thành công", null, () => {
                            this.$emit('success', params);
                            this.close();
                            this.reset();
                        });
                    } else {
                        // this.thongBao('error', stt.rd)
                        this.show_thong_bao_loi = true;
                        this.dataErr = stt;
                    }
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


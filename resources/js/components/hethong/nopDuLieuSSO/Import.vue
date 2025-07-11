<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog width="70%" :title="headerText"  custom-class="showThongTinLoiImportSSO" :visible.sync="showImport" :close-on-press-escape="false"
                   :close-on-click-modal="false" :show-close="false" @before-close="closeImport">
            <el-dialog width="70%" top="5vh" custom-class="showThongTinLoiImportSSO" title="Thông tin lỗi"
                       :visible.sync="showThongTinLoi" :close-on-press-escape="false"
                       append-to-body
                       :close-on-click-modal="false" :show-close="false">
                <el-row :gutter="20">
                    <el-row :span="24">
                        <el-col :span="24">
                            <p>Đã tiến hành import tổng số {{ ThongTinCacBanLoi.total }} bản ghi. Trong đó: Tiếp nhận
                                thành công
                                {{ ThongTinCacBanLoi.countSuccess }} bản ghi; thất bại:
                                {{ ThongTinCacBanLoi.countError }} bản ghi.</p>
                            <div class="table-responsive" style="height:60vh">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                    <tr style="background:#e4ebf5">
                                        <th class="text-center"><p>STT</p></th>
                                        <th class="text-center"><p>Tên</p></th>
                                        <th class="text-center"><p>Lỗi</p></th>
                                        <th class="text-center"><p>Vị trí lỗi (hàng trong file excel)</p></th>
                                    </tr>
                                    </thead>
                                    <tbody v-if="ThongTinCacBanLoi.messages.length==0">
                                    <tr>
                                        <td colspan="13">
                                            <p class="text-center">Không có dữ liệu</p>
                                        </td>
                                    </tr>
                                    </tbody>
                                    <tbody v-else>
                                    <tr v-for="(item,i) in ThongTinCacBanLoi.messages" :key="i">
                                        <td class="text-center"><p>{{ i + 1 }}</p></td>
                                        <td><p>{{ item.name }}</p></td>
                                        <td><p>{{ item.message }}</p></td>
                                        <td class="text-center"><p>{{ item.sttRowExcel }}</p></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </el-col>
                    </el-row>
                </el-row>
                <span slot="footer" class="dialog-footer">
                     <download-excel
                         style="display: contents"
                         :data="json_data"
                         name="thong_tin_ban_ghi_loi.xls"
                     >
                <el-button size="mini" type="primary">Tải xuống</el-button>
                               </download-excel>
                <el-button size="mini" type="danger" @click="showThongTinLoi=false">Đóng</el-button>
            </span>
            </el-dialog>
            <el-row :gutter="20">
                <el-col :span="18" :offset="3">
                    <p><b style="color: blue">Ghi chú:</b> Vui lòng import dữ liệu theo đúng định dạng <a alt="Tải xuống file mẫu" :href="sample_file_path"><i> file mẫu</i></a>. </p>
                </el-col>
                <el-col :span="18" :offset="3">
                    <div class="grid-content bg-purple pd-10 text-center">
                        <div class="alert alert-info mt-15" style="display: inline-flex;position: relative"
                             role="alert">
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
                        </div>
                        <div v-if="fileImportName" class="mt-15 mb-15">
                            <el-alert
                                show-icon
                                effect="dark"
                                type="success"
                                @close="xoaFileDaChon"
                            >
                                <template slot="title">{{ fileImportName }}</template>
                            </el-alert>
                        </div>
                    </div>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="danger" @click="closeImport">Huỷ</el-button>
                <el-button size="mini" type="primary" @click="tienHanhImport">Import</el-button>
            </span>


        </el-dialog>
    </div>
</template>

<script>
import api from "../../api";
import JsonExcel from 'vue-json-excel'

Vue.component('downloadExcel', JsonExcel)

export default {
    props: ['show', 'text_header', 'path_import', 'nam_hoc','sample_file_path'],
    components: {},
    watch: {},
    data() {
        return {
            files:null,
            loading: {
                status: false,
                text: 'Loading...'
            },
            headerText: 'Import dữ liệu',
            showImport: false,
            showThongTinLoi: false,
            fileImportName: '',
            selected_file: null,
            danh_sach_dinh_dang_excel: [
                "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                "application/vnd.ms-excel.sheet.macroEnabled.12",
                "application/vnd.ms-excel",
                "application/vnd.openxmlformats-officedocument.spreadsheetml.template",
            ],
            ThongTinCacBanLoi: {
                messages: []
            },
            json_fields: {
                'Complete name': 'Họ tên',
                'Địa chỉ': 'Mô tả lỗi',
                'SĐT': 'Vị trí lỗi',
            },
            json_data: [],
            json_meta: [
                [
                    {
                        'key': 'charset',
                        'value': 'utf-8'
                    }
                ]
            ],
        }
    },

    mounted: function () {
        console.log('Mounted import file')
        this.headerText = this.text_header;
        console.log(this.headerText)
        this.showImport = true
    },
    methods: {
        importSuccess(){
            this.$emit('success');
        },
        tienHanhImport() {
            console.log("Tiến hành import");
            if (this.selected_file == null) {
                this.thongBao('error', 'Vui lòng chọn file import');
                return;
            }

            this.$confirm('Hệ thống sẽ tiền hành lấy dữ liệu từ file đã chọn?', 'Thông báo', {
                confirmButtonText: 'Xác nhận',
                cancelButtonText: 'Hủy',
                closeOnClickModal: false,
            })
                .then(_ => {
                    this.loading.text = 'Đang import...';
                    this.loading.status = true;
                    let params = new FormData();
                    params.append('file', this.selected_file);
                    params.append('namHoc', this.nam_hoc);
                    api.postForm(this.path_import, params, (response) => {
                        let stt = JSON.parse(response.data);
                        console.log('Import trả về:')
                        console.log(stt)
                        if (stt.rc == 0) {
                            this.thongBao('success', 'Thao tác thành  công');
                            this.$confirm('Import thành công. Tiếp tục import file khác?', 'Thông báo', {
                                confirmButtonText: 'Xác nhận',
                                cancelButtonText: 'Không',
                                closeOnClickModal: false,
                            })
                                .then(_ => {
                                    console.log('Import file khác');
                                    this.showThongTinLoi = false
                                })
                                .catch(_ => {
                                    console.log('Import xong. Không import nữa');
                                    this.importSuccess();
                                });
                        } else {
                            this.thongBao('error', 'Vui lòng kiểm tra lại dữ liệu file');
                            if (stt.messages && stt.countError) {
                                let msg = 'Import thành công ' + stt.countSuccess + ' bản ghi. Thất bại ' + stt.countError + ' bản ghi. Xem thông tin lỗi?';
                                this.$confirm(msg, 'Thông báo', {
                                    confirmButtonText: 'Xác nhận',
                                    cancelButtonText: 'Hủy',
                                    closeOnClickModal: false,
                                })
                                    .then(_ => {
                                        this.showLoiImport(stt);
                                    })
                                    .catch(_ => {
                                    });
                            }
                        }
                        this.loading.status = false;
                    });
                })
                .catch(_ => {
                });
        },
        showLoiImport(e) {
            console.log('showLoiImport')
            this.loading.text = 'Vui lòng đợi...';
            this.loading.status = true;
            setTimeout(() => {
                this.ThongTinCacBanLoi = e;
                let json_data2 = this.ThongTinCacBanLoi.messages;
                json_data2.map((item, a) => {
                    let newItem = {};
                    newItem['STT'] = a + 1;
                    newItem['Họ tên'] = item.name;
                    newItem['Mô tả lỗi'] = item.message;
                    newItem['Vị trí lỗi (hàng trong file excel)'] = item.sttRowExcel;
                    return this.json_data.push(newItem);
                });
                this.loading.status = false;
                this.showThongTinLoi = true
            }, 1000)
        },
        xoaFileDaChon(e) {
            this.loading.text = 'Vui lòng đợi...'
            this.loading.status = true;
            this.selected_file = null;
            this.fileImportName = '';
            this.files = null;
            this.$refs.file_upload.value = null;
            console.log("Xoá file đã chọn")
            setTimeout(() => {
                this.thongBao('warning', 'Xoá thành công. Vui lòng chọn lại file')
                this.loading.status = false;
            }, 1000)
        },
        onFileChange(e) {
            try {
                this.files = e.target.files;
                this.fileImportName = '';
                if (!this.files) {
                    this.thongBao('error', 'Trình duyệt không hỗ trợ.')
                    return;
                }
                this.selected_file = this.files[0];
                const size = parseInt(this.selected_file.size);
                console.log("kích thước file:" + size);
                if (this.files && this.files[0]) {
                    this.loading.text = 'Đang xử lý...';
                    this.loading.status = true;
                    let fileType = this.selected_file["type"];
                    let ValidImageTypes = this.danh_sach_dinh_dang_excel;
                    if ($.inArray(fileType, ValidImageTypes) < 0) {
                        this.selected_file = null;
                        setTimeout(()=>{
                            this.thongBao('error', 'Vui lòng chọn đúng định dạng file excel');
                            this.files = null;
                            this.$refs.file_upload.value = null;
                            this.loading.status = false;
                            },500)
                        return;
                    }
                    setTimeout(() => {
                        this.file_name = e
                            .target
                            .files[0]
                            .name;
                        this.fileImportName = this.file_name;
                        this.loading.status = false;
                    }, 1000);
                }
                console.log('Tên file')
                console.log(this.fileImportName)
            } catch (e) {
                this.thongBao('error', 'Có lỗi trong quá trình thao tác. Vui lòng thử lại.')
            }
        },
        closeImport() {
            this.$emit('close');
        },

        thongBao(typeNoty, message) {
            let msg = "";
            let cl = "";
            if (message) {
                msg = message;
            }
            let type = "success";
            if (typeNoty) {
                type = typeNoty
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
                type: type,
                duration: 5000
            });
        },
    }

}
</script>
<style scoped="scoped">

.bg-purple {
    background: #d3dce6;
}

.grid-content {
    border-radius: 4px;
    min-height: 36px;
}

.mt-15 {
    margin-top: 15px
}

.mb-15 {
    margin-bottom: 15px
}

.pd-10 {
    padding: 10px
}

</style>

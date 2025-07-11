<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo; </span> HỆ THỐNG <span class="kytu">
                        &raquo;</span> IMPORT KIỂM ĐỊNH CHẤT LƯỢNG</span>
            </div>
        </div>


        <div style="margin-top:25px;" class="text-center" >
            <div style="width: 600px; display: inline-block">
                <el-card class="box-card">
                    <div v-loading.fullscreen.lock="loading" :element-loading-text="text_load" element-loading-spinner="el-icon-loading"
                         element-loading-background="rgba(0, 0, 0, 0.8)">
                        <div class="d-block d-md-flex align-items-md-center">
                            <div>
                                <el-upload
                                        :on-remove="handleRemove"
                                        :on-change="uploadFile" :on-exceed="handleExceed" :limit="1" accept=".xls,.xlsx"
                                           class="upload-excell" drag ref="uploadExcel" action="/" :auto-upload="false">
                                    <i class="el-icon-upload"></i>
                                    <div class="el-upload__text">Chọn file để import <em>click để upload</em></div>

                                </el-upload>
                            </div>
                            <div class="mt-3 mt-md-0 ml-md-2" style="padding-top:15px">

                                <el-button style="" :disabled="loading" size="small" type="success" @click="submitUpload">Import dữ liệu
                                </el-button>
                            </div>
                        </div>
                    </div>

                </el-card>
            </div>

        </div>
        <p><b style="color: blue">Ghi chú:</b> Vui lòng import dữ liệu theo đúng định dạng <a alt="Tải xuống file mẫu" :href="'/exportExcel/IMPORT_KDCL.xlsx'"><i> file mẫu</i></a>. </p>
    </div>
</template>

<script>
import XLSX from "xlsx";
import LZString from "lz-string";
import rest_api from "../../utils/rest_api";

export default {
    name: "KiemDinhChatLuong",
    data() {
        return {
            text_load: '',
            row_header: 9,
            type: '',
            loading: false,
            base64: '',
            listRows: [],
            workbook: '',
            worksheet: '',
            listRowsAll: [],
        }
    },
    methods: {
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
        handleExceed(files, fileList) {
            this.thongBao('error','Vui lòng xóa file cũ trước khi chọn file mới')
        },
        handleRemove(file, fileList){
            this.base64 = ''
        },
        uploadFile(file, fileList) {
            // this.loading = true;
            console.log(this.loading)
            console.log("Cho loading")
            console.log(fileList);
            this.text_load = 'Loading...';
            let allowedExtensions = /(\.xlsx|\.xls)$/i;
            if (!allowedExtensions.exec(file.name)) {
                // thông báo
                this.$alert('Vui lòng chỉ tải lên file định dạng excel', 'Thông báo', {
                    confirmButtonText: 'Đóng',
                    type: 'error',
                    callback: action => {
                        this.$refs.uploadExcel.clearFiles();
                    }
                });


                return false;
            }
            let reader = new FileReader();
            reader.readAsArrayBuffer(file.raw);
            reader.onloadstart = (e) => {}
            reader.onload = (e) => {
                let data = new Uint8Array(e.target.result);
                this.builData(data);

            }


        },

        builData(data) {
            console.log("***")
            this.loading = true;
            this.listRowsAll = [];
            this.workbook = XLSX.read(data, {
                type: 'array',
                cellDates: true,
                cellStyles: true
            });
            let params = [];
            this.workbook.SheetNames.forEach((sheet, index) => {
                let paramSheet = [];
                this.worksheet = this.workbook.Sheets[sheet];
                this.listRows = this.sheet2Arr(this.worksheet, this.workbook);
                console.log(this.workbook)
                this.listRows.forEach((row, i) => {
                    if (i > 7) {
                        let p = {};
                        row.forEach((value, m) => {
                            if (m < 10) {
                                p[m + 1] = value.toString();
                            }
                        });
                        paramSheet.push(p);
                    }
                });
                params.push({
                    sheetName: sheet,
                    data: paramSheet
                })

                this.listRowsAll.push({
                    sheetName: sheet,
                    data: this.listRows
                });
            });


            this.base64 = LZString.compressToBase64(JSON.stringify(params))
            console.log("Gán xong")
            this.loading = false;
        },
        sheet2Arr(sheet, workbook) {
            if(!sheet['!ref']){
                return [];
            }
            console.log("sheet")
            console.log(sheet)
            console.log("workbook")
            console.log(workbook)
            let result = [];
            let row;
            let rowNum;
            let colNum;
            let range = XLSX.utils.decode_range(sheet['!ref']) ? XLSX.utils.decode_range(sheet['!ref']) : 0;
            for (rowNum = range.s.r; rowNum <= range.e.r; rowNum++) {
                row = [];
                for (colNum = range.s.c; colNum <= range.e.c; colNum++) {
                    var nextCell = sheet[
                        XLSX.utils.encode_cell({
                            r: rowNum,
                            c: colNum
                        })
                        ];
                    if (typeof nextCell === 'undefined') {
                        row.push('');
                    } else {
                        if (nextCell.v instanceof Date) {
                            let dateMode = workbook.Workbook.WBProps.date1904;
                            let result = XLSX.SSF.format('DD/MM/YYYY', nextCell.v, {
                                date1904: dateMode
                            });
                            row.push(result);
                        } else {
                            if (typeof nextCell.v === 'undefined') {
                                row.push('');
                            } else {
                                row.push(nextCell.v);
                            }
                        }
                    }
                }
                result.push(row);
            }
            return result;
        },
        submitUpload() {

            if (!this.base64) {
                this.thongBao('error', 'Vui lòng chọn file tải lên.')
                return;
            }
            this.loading = true;
            let params = {
                data: this.base64,
            }
            this.loading = false;
            // rest_api.post(this.path, params, response => {
            //     console.log("123456789***")
            //     console.log(response)
            //     this.loading = false;
            //     if (response.data.rc ==0) {
            //         this.$emit('success', response.data)
            //     } else {
            //         this.thongBao('error', response.data.rd)
            //     }
            // });

        },
    }
}
</script>

<style>
.el-upload__input {
    display: none !important;
}

.el-link {
    font-weight: 400;
    font-size: 13px;
}

a.el-upload-list__item-name {
    height: 50px !important;
}

</style>
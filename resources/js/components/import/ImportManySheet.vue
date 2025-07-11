<template>
    <div v-loading.fullscreen.lock="loading" :element-loading-text="text_load" element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <div class="d-block d-md-flex align-items-md-center">
            <div>
                <el-upload :on-change="uploadFile" :on-exceed="handleExceed" :limit="1" accept=".xls,.xlsx"
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
</template>

<script>
    import XLSX from 'xlsx';
    import LZString from 'lz-string';
    import ExcelJS from 'exceljs';
    import rest_api from '../../utils/rest_api';
    export default {
        name: "ImportManySheet",
        props: [
            'path',
            'maTruong',
            'namHoc',
        ],
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
            handleExceed(files, fileList) {
                    this.thongBao('error','Vui lòng xóa file cũ trước khi chọn file mới')
            },
            getDataError(data, sheeName) {

                let error = data.forEach(item => {
                    return item.sheetName == sheeName
                })
                if (error) return error.data
                return []
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

            submitUpload() {
                if (!this.maTruong) {
                    this.thongBao('error', 'Vui lòng thêm thông tin trường học.')
                    return;
                }
                if (!this.namHoc) {
                    this.thongBao('error', 'Vui lòng thêm thông tin năm học.')
                    return;
                }
                if (!this.base64) {
                    this.thongBao('error', 'Vui lòng thêm file.')
                    return;
                }
                this.loading = true;
                let params = {
                    data: this.base64,
                    namHoc: this.namHoc,
                    maTruongHoc: this.maTruong,
                }

                rest_api.post(this.path, params, response => {
                    console.log("123456789***")
                    console.log(response)
                    this.loading = false;
                    if (response.data.rc ==0) {
                        this.$emit('success', response.data)
                    } else {
                        this.thongBao('error', response.data.rd)
                    }
                });

            },

        },

        mounted() {

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

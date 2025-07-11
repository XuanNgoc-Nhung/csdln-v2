<template>
    <el-row :gutter="24">
        <el-col :span="6">
            <label>Ngày lấy báo cáo</label>
            <date-picker
                    v-model="doi_tuong"
                    :config="configDate"
                    placeholder="Chọn ngày lấy báo cáo"
            ></date-picker>
        </el-col>
        <el-col :span="24">
            <div class="text-center">
                <el-button size="mini" type="success" @click.prevent="onExport()">
                    Xuất excel
                </el-button>
            </div>
        </el-col>
    </el-row>
</template>

<script>

import rest_api from "../../../utils/rest_api";
import ESelectVue from "../../ui/ESelect";
import ExcelJS from "exceljs";
import * as XLSX from "xlsx";
import dialog from "../../../utils/dialog";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
import datePicker from "vue-bootstrap-datetimepicker";


export default {
    name: "ThongKeChuanNghe",
    components : {
        'eselect': ESelectVue,
        datePicker
    },
    data(){
        let year = new Date().getFullYear();
        let years = [];
        let list_nam_hoc = [];
        for (let i = year - 5; i<= year; i++){
            years.push(i.toString() +  '-' +(i+1).toString());
            list_nam_hoc.push({
                id: i+"-"+(i+1),
                name: i+"-"+(i+1)
            })
        }
        list_nam_hoc.reverse()
        return {
            doi_tuong : '',
            list_nam_hoc: list_nam_hoc,
            nam_hoc : '',
            configDate : {
                format: "DD/MM/YYYY",
                useCurrent: true,
                showTodayButton: true,
                locale: "vi"
            }
        }
    },
    methods : {
        onExport(){
            if (!this.doi_tuong){
                dialog.showDialog('Thông báo','Vui lòng chọn ngày lấy báo cáo');
                return;
            }


            let uri = '/csdlgd-report-api/K12/baoCaoTongQuan';
            let params = {
                "day" : this.doi_tuong,
                dataType : 'ByYear'
            };
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.post(uri,params,(data)=>{
                if (data.data && data.data.status == 'SUCCESS'){
                    let items = data.data.items;
                    if (typeof items === Object){
                        items = Object.values(items);
                    }
                    this.dowloadFile(items)

                }else{
                    this.$alert('Chưa lấy được dữ liệu', 'Thông báo', {
                        confirmButtonText: 'Đóng',
                        type: 'warning',
                        center: true,
                        callback: action => {}
                    });
                }
                loading.close();
            },120000,true);
        },
        dowloadFile(data){
            let wb = new ExcelJS.Workbook();

            let sheet = wb.addWorksheet('Sheet1',{
                pageSetup:{
                    paperSize: 9,
                    fitToPage : true,
                    fitToHeight: 0,
                    fitToWidth: 1,
                }
            });
            //Header
            sheet.getCell('A1').value = 'UBND TP.HỒ CHÍ MINH';
            sheet.getCell('A2').value = 'SỞ GDĐT HỒ CHÍ MINH';
            sheet.getCell('A3').value = 'BÁO CÁO TỔNG QUAN TÀI KHOẢN'


            sheet.getCell('A5').value = `${(new Date).getDate()}/${(new Date).getMonth() + 1}/${(new Date).getFullYear()} ${(new Date).getHours()}:${(new Date).getMinutes()}`;

            sheet.mergeCells('A1:C1');
            sheet.mergeCells('A2:C2');
            sheet.mergeCells('A3:F3');
            sheet.mergeCells('A4:F4');
            sheet.mergeCells('A5:F5');

            sheet.getCell('A1').font = {
                name: 'Times New Roman',
                size: 11,
                bold: false
            };
            sheet.getCell('A2').font = {
                name: 'Times New Roman',
                size: 11,
                bold: true
            };
            sheet.getCell('A3').font = {
                name: 'Times New Roman',
                size: 11,
                bold: true
            };
            sheet.getCell('A3').alignment = {wrapText: true, vertical: 'middle', horizontal: 'center' };
            sheet.getCell('A5').alignment = {wrapText: true, vertical: 'middle', horizontal: 'right' };
            sheet.getCell('A5').font = {
                name: 'Times New Roman',
                size: 11,
                bold: false,
                italic : true,
            };




            let rows = sheet.addRows([
                ['STT','Mã trường','Tên trường','Số GV','','Số HS','','Số học liệu tạo','Tổng truy nhập (từ trước đến nay)'],
                ['','','','Đã đăng nhập','Chưa đăng nhập','Đã đăng nhập','Chưa đăng nhập','',''],
            ])

            sheet.mergeCells(`A6:A7`);
            sheet.mergeCells(`B6:B7`);
            sheet.mergeCells(`C6:C7`);
            sheet.mergeCells(`D6:E6`);
            sheet.mergeCells(`F6:G6`);
            sheet.mergeCells(`J6:J7`);
            sheet.mergeCells(`I6:I7`);

            for (let i = 6;i<=7;i++){
                let row = sheet.getRow(i);
                row.font = {
                    name: 'Times New Roman',
                    size: 11,
                    bold: true
                }
                row.eachCell(function(cell,index){

                    cell.border = {
                        top: {style:'thin'},
                        left: {style:'thin'},
                        bottom: {style:'thin'},
                        right: {style:'thin'}
                    }
                });

                row.alignment = {wrapText: true, vertical: 'middle', horizontal: 'center' };
            }


            let children = (data.children && data.children.length) ? data.children : [];

            children.forEach((item,index) => {
                let dataRow = [
                    index+1,
                    item.code || '',
                    item.title || '',
                    item.stats.total || 0,
                    item.stats.self_assessment || 0,
                    item.stats.final_assessment || 0,
                ]

                let row = sheet.addRow(dataRow)
                row.font = {
                    name: 'Times New Roman',
                    size: 11,
                    bold: false
                };
                row.eachCell(function(cell, rowNumber){
                    cell.border = {
                        top: {style:'thin'},
                        left: {style:'thin'},
                        bottom: {style:'thin'},
                        right: {style:'thin'}
                    }
                    cell.alignment = {wrapText: true, vertical: 'middle', horizontal: 'center'};
                })
            })


            sheet.columns.forEach((col, index) => {

                if(index == 0){
                    col.width = 7;
                }
                else if(index == 1){
                    col.width = 15;
                }
                else if(index == 2){
                    col.width = 40;
                }



            });
            //Export
            wb.xlsx.writeBuffer().then(function(data){
                const blob = new Blob([data],
                    { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                const url = window.URL.createObjectURL(blob);
                const anchor = document.createElement('a');
                anchor.href = url;
                anchor.download = 'THongKeDanhGiaChuanNghe.xlsx';
                anchor.click();
                window.URL.revokeObjectURL(url);
            });
        },
    }
}
</script>

<style scoped>

</style>
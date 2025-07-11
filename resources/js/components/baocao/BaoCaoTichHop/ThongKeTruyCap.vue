<template>
    <el-row :gutter="24">

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
    name: "ThongKeTruyCap",
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

            let uri = '/csdlgd-report-api/K12/baoCaoTruyCap';
            let params = {};
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.post(uri,params,(data)=>{
                if (data.data && data.data.status == 'SUCCESS'){
                    let items = data.data.items;
                    console.log(typeof items)
                    if (typeof items === 'object'){
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
            sheet.getCell('A3').value = 'BÁO CÁO THỐNG KÊ TRUY CẬP'


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

            let header;
            header = ['STT','Mã đơn vị','Tên đơn vị','Tháng trước','Tháng hiện tại','Tổng truy cập 2 tháng'];


            let rows = sheet.addRows([
                header
            ])
            let row = sheet.getRow(6);
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

            let children = (data.children && data.children.length) ? data.children : [];

            data.forEach((item,index) => {
                let dataRow = [
                    index+1,
                    item.code || '',
                    item.title || '',
                    item.beforeMonth || 0,
                    item.currentMonth || 0,
                    item.total || 0,
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
                anchor.download = 'ThongKeTruyCap.xlsx';
                anchor.click();
                window.URL.revokeObjectURL(url);
            });
        },
    }
}
</script>

<style scoped>

</style>
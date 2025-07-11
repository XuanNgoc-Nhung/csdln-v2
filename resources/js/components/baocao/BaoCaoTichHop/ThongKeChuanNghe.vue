<template>
    <el-row :gutter="24">
        <el-col :span="6">
            <label>Đối tượng <span style="color: #DC0101">*</span></label>
            <eselect style="width:100%"  v-model="doi_tuong"
                     :placeholder="'--Chọn đối tượng--'" :data="[{name : 'Giáo viên',id : 1},{name : 'Cán bộ',id : 2}]" :fields="['name','id']"/>
        </el-col>
        <el-col :span="6">
            <label>Năm học <span style="color: #DC0101">*</span></label>
            <eselect style="width:100%"  v-model="nam_hoc"
                     :placeholder="'--Chọn năm học--'" :data="list_nam_hoc" :fields="['name','id']"/>
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


export default {
    name: "ThongKeChuanNghe",
    components : {
        'eselect': ESelectVue,
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
            nam_hoc : ''
        }
    },
    methods : {
        onExport(){
            if (!this.doi_tuong){
                dialog.showDialog('Thông báo','Vui lòng chọn đối tượng lấy báo cáo');
                return;
            }
            if (!this.nam_hoc){
                dialog.showDialog('Thông báo','Vui lòng chọn năm học lấy báo cáo');
                return;
            }

            let uri = 'https://taphuan-api.csdl.edu.vn/assessment/rest/overview-stats-by-organization-tree';
            let params = {
                '_sand_client_secret' : 'ZG2yxeYLevmNVgXEIqiFWTNrRqsHYvb2',
                'org_code' : 79,
                '_sand_client_id' : 'hcm_sgd',
                'school_year': this.nam_hoc,
                'target_user': this.doi_tuong == 1 ? 'gv' : 'cbql'
            }
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            rest_api.get2(uri,params,(data)=>{
                if (data.data && data.data.success){
                    let result = data.data.result;
                    if (this.doi_tuong == 1){
                        this.dowloadFile(result,1)
                    }else{
                        this.dowloadFile(result,2)
                    }

                }else{
                    dialog.showDialog('Thông báo','Chưa lấy được dữ liệu. Vui lòng thử lại sau')
                }

                loading.close();
            },120000,true);
        },
        dowloadFile(data,type){
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
            if (type == 1){
                sheet.getCell('A3').value = 'BÁO CÁO ĐÁNH GIÁ CHUẨN NGHỀ GIÁO VIÊN'
            }else{
                sheet.getCell('A3').value = 'BÁO CÁO ĐÁNH GIÁ CHUẨN NGHỀ CÁN BỘ '
            }


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
            if (type == 1){
                header = ['STT','Mã đơn vị','Tên đơn vị','Tổng số giáo viên','Tổng số giáo viên hoàn thành tự đánh giá ','Tổng số giáo viên được thủ trưởng đánh giá'];
            }else{
                header = ['STT','Mã đơn vị','Tên đơn vị','Tổng số giáo viên','Tổng số CBQL hoàn thành tự đánh giá ','Tổng số CBQL được thủ trưởng đánh giá']

            }

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

            children.forEach((item,index) => {
                let dataRow = [
                    index+1,
                    item.organization.code || '',
                    item.organization.name || '',
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
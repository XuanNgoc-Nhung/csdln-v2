<template>
    <div style="display: flex;height: 100vh">
        <ejs-spreadsheet
            ref="spreadsheet"
            height="100%"
            :allowScrolling="true"
            :allowEditing="false"
            :allowDelete="false"
            :enableContextMenu="false"
            :showRibbon="false"
            :showFormulaBar="false"
            :allowOpen="true"
            :scrollSettings="{
                     enableVirtualization: false
                }"
            :isProtected="true"
            :created="created"></ejs-spreadsheet>
    </div>
</template>

<script>
// import '@syncfusion/ej2-base/styles/material.css';
//
// import '@syncfusion/ej2-buttons/styles/material.css';
// import '@syncfusion/ej2-dropdowns/styles/material.css';
// import '@syncfusion/ej2-inputs/styles/material.css';
// import '@syncfusion/ej2-navigations/styles/material.css';
// import '@syncfusion/ej2-popups/styles/material.css';
// import '@syncfusion/ej2-splitbuttons/styles/material.css';
// import '@syncfusion/ej2-grids/styles/material.css';
// import '@syncfusion/ej2-vue-spreadsheet/styles/material.css';

import Vue from "vue";
import { SpreadsheetPlugin } from "@syncfusion/ej2-vue-spreadsheet";
Vue.use(SpreadsheetPlugin);
import array_utils from '../utils/array_utils';
import ExcelJS from "exceljs";
import * as XLSX from "xlsx";
export default {
    data: () => {
        return {
            openUrl: '/build-excel',
            // openUrl: 'https://ej2services.syncfusion.com/production/web-services/api/spreadsheet/open',
            data:  [

            ]
        }
    },
    mounted() {

    },
    methods : {
        created: function () {
            let queryString = window.location.search;
            let urlParams = new URLSearchParams(queryString);
            let path = urlParams.get('path')


            if (path && (path.search(".xlsx") >= 0 || path.search(".xls") >= 0)){
                fetch(path,{ mode: "cors", credentials: "same-origin", referrerPolicy: "no-referrer"}) // fetch the remote url
                    .then((response) => {
                        response.blob().then((fileBlob) => { // convert the excel file to blob
                            var file = new File([fileBlob], "Sample.xlsx"); //convert the blob into file
                            // this.$refs.spreadsheet.open({ file: file }); // open the file into Spreadsheet
                            let reader = new FileReader();

                            reader.readAsArrayBuffer(file);

                            reader.onload = (e) => {
                                let data = new Uint8Array(e.target.result);
                                this.loadFileExcel(data);
                            }

                        })
                    })
            }

        },
        checkMerge(cell, arrMg) {
            let data = {
                rowSpan: 0,
                colSpan: 0
            }
            let mg = arrMg.find(item => {
                return item.address == cell
            })
            if (mg) {
                let modal = mg.model;
                data.rowSpan = (modal.bottom - modal.top) + 1;
                data.colSpan = (modal.right - modal.left + 1);
            }
            return data;
        },
        async loadFileExcel(data){

            let dataTemp = {
                definedNames: [],
                filterCollection: [],
                sortCollection: [],
                sheets: [],
            };
            let workbook = new ExcelJS.Workbook();
            await workbook.xlsx.load(data);

            workbook.eachSheet((sheet, sheetId) => {

                let paramSheet = {

                    name: sheet.name,
                    columns: []
                };


                let worksheet = workbook.getWorksheet(sheetId);

                let merges = worksheet._merges;
                let mg = []
                merges = (Object.keys(merges).map((key) => [(key), merges[key]]));
                const firstCell = worksheet.getCell(1,3);

                if (array_utils.isArray(merges)) {
                    merges.forEach(item => {

                        mg.push({
                            address: item[0],
                            model: item[1].model
                        })
                    })
                }

                let lastRow = worksheet.lastRow;
                let lastColumn = worksheet.lastColumn;
                paramSheet.usedRange = {
                    colIndex: lastColumn.number,
                    rowIndex: lastRow.number
                }

                let columnCount = worksheet.columnCount;


                for (let i = 1; i <= columnCount; i++) {
                    let column = worksheet.getColumn(i);
                    // console.log(`Column ${i} width: ${column.width}`);
                    if (i === 1) {
                        paramSheet.columns.push({
                            width: ((column.width) * 7.5) || 0
                        })
                    } else {
                        paramSheet.columns.push({
                            index: i - 1,
                            width: ((column.width) * 7.5) || 0
                        })
                    }

                }

                let rowData = [];

                for (let i = 1; i <= worksheet.rowCount; i++) {
                    let row = worksheet.getRow(i);
                    // console.log(row);

                    let r = {
                        height: 0,
                        cells: [],
                    };


                    r.height = (row.height || 15.6) * 1.4

                    let cells = []
                    for (let j = 1; j <= columnCount; j++) {
                        let cell = worksheet.getCell(i, j)


                        let style = {
                            'backgroundColor': '#FFFFFF',
                            'fontFamily': 'TimesNewRoman'
                        };


                        if (cell.fill && cell.fill.fgColor && cell.fill.fgColor.argb) {
                            let backgroundColor = cell.fill.fgColor.argb;
                            style.backgroundColor = '#' + backgroundColor
                        }
                        if (cell.font) {
                            if (cell.font.bold) {
                                style.fontWeight = 'Bold'
                            }
                            if (cell.font.italic) {
                                style.fontStyle = 'Italic'
                            }
                            if (cell.font.underline) {
                                style.textDecoration = 'Underline'
                            }

                            if (cell.font.size) {
                                style.fontSize = cell.font.size+'pt'
                            }
                        }

                        if (cell.alignment) {
                            if (cell.alignment.vertical) {
                                style.verticalAlign = cell.alignment.vertical.replace(/\b\w/g, l => l.toUpperCase())
                            }
                            if (cell.alignment.horizontal) {
                                style.textAlign = cell.alignment.horizontal.replace(/\b\w/g, l => l.toUpperCase())
                            }

                        }

                        if (cell.border) {
                            if (cell.border.top) {
                                style.borderTop = '1px solid #000000'
                            }
                            if (cell.border.bottom) {
                                style.borderBottom = '1px solid #000000'
                            }
                            if (cell.border.left) {
                                style.borderLeft = '1px solid #000000'
                            }
                            if (cell.border.right) {
                                style.borderRight = '1px solid #000000'
                            }
                        }



                        let cellInfo = {
                            "wrap": (cell.alignment && cell.alignment.wrapText) || false,
                            "isLocked": true,
                            "format": "@",
                            "style": style,
                        }

                        // console.log(cell)
                        if (cell.value && cell.formula){
                            cellInfo.formula = '='+cell.formula
                        }else{
                            cellInfo.value = cell.value
                        }

                        let mer = this.checkMerge(cell.address, mg)

                        if (mer.colSpan) cellInfo.colSpan = mer.colSpan
                        if (mer.rowSpan) cellInfo.rowSpan = mer.rowSpan

                        cells.push(cellInfo)
                        // let styleCell = cell.style;
                        // console.log(`Cell ${colIndex}${rowIndex} style: styleCell`, styleCell);

                    }
                    row.eachCell((cell, colIndex) => {


                    });
                    r.cells = cells
                    rowData.push(r)
                }

                paramSheet.rows = rowData

                dataTemp.sheets.push(paramSheet);


            });
            this.dataTempFile = this.dataTemp
            this.$refs.spreadsheet.openFromJson(
                {
                    file: {Workbook: dataTemp}
                }
            ); // open the file into Spreadsheet

        }
    }
}
</script>
<style>
@import '../../../node_modules/@syncfusion/ej2-base/styles/material.css';

@import '../../../node_modules/@syncfusion/ej2-buttons/styles/material.css';
@import '../../../node_modules/@syncfusion/ej2-dropdowns/styles/material.css';
@import '../../../node_modules/@syncfusion/ej2-inputs/styles/material.css';
@import '../../../node_modules/@syncfusion/ej2-navigations/styles/material.css';
@import '../../../node_modules/@syncfusion/ej2-popups/styles/material.css';
@import '../../../node_modules/@syncfusion/ej2-splitbuttons/styles/material.css';
@import '../../../node_modules/@syncfusion/ej2-grids/styles/material.css';
@import '../../../node_modules/@syncfusion/ej2-vue-spreadsheet/styles/material.css';
body{
    margin: 0;
}
body > div{
    display: none;
}
body > div#app{
    display: block;
}
.e-sheet > .e-scrollbar{
    height: 16px !important;
}
</style>

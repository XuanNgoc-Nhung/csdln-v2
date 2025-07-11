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
                :openUrl="openUrl"
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
                fetch(path) // fetch the remote url
                    .then((response) => {
                        response.blob().then((fileBlob) => { // convert the excel file to blob
                            var file = new File([fileBlob], "Sample.xlsx"); //convert the blob into file
                            this.$refs.spreadsheet.open({ file: file }); // open the file into Spreadsheet
                        })
                    })
            }

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
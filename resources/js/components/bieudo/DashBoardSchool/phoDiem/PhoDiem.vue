 <template>
     <div>
         <el-col :md="12" :lg="12">
             <div class="dts-moibieudo grid-content bg-purple-light">
                 <div class="dts-card-header">
                     <span class="dts-card-title">Phổ điểm {{caphoc}} {{name}}</span>
                 </div>
                 <div class="dts-card-body" v-loading="false" element-loading-background="rgba(0, 0, 0, 0.8)">
                     <div>
                         <div class="bieudo" ref="bieudo"></div>
                     </div>
                 </div>
             </div>
         </el-col>
     </div>
 </template>
 <style>
 </style>
 <script>
     import ApexCharts from 'apexcharts'
     import Anychart from 'anychart'
     export default {
         props: ['item', 'name', 'caphoc'],
         data() {
             return {
                 list_mon_hoc:[
                    {value:"DLY",name:"Địa lý"},
                    {value:"NN",name:"Ngoại ngữ"},
                    {value:"HHC",name:"Hóa học"},
                    {value:"VLY",name:"Vật lý"},
                    {value:"NVN",name:"Ngữ văn"},
                    {value:"GCD",name:"GDCD"},
                    {value:"TOC",name:"Toán"},
                    {value:"LSU",name:"Lịch sử"},
                    {value:"SHC",name:"Sinh học"},
                 ],
                 bieuDoPhoDiemHocKyHai: {
                     series: [],
                     chart: {
                         width: '100%',
                         height: '280',
                         type: 'line',
                         zoom: {
                             enabled: true
                         },
                         toolbar: {
                             show: false
                         },
                         animations: {
                             enabled: true
                         }
                     },
                     colors: ['#2E93fA', '#66DA26', '#546E7A', '#E91E63', '#FF9800', '#F781F3', '#FFFF00', '#19070B',
                         '#00FF40'
                     ],
                     stroke: {
                         curve: 'smooth',
                     },
                     labels: ['0', '≤1', '≤2', '≤3', '≤4', '≤5', '≤6', '≤7', '≤8', '≤9', '≤10'],

                 },

             }
         },
         mounted() {
             console.log("mounted trong biểu đồ phổ điểm")
         },
         components: {
             apexchart: ApexCharts,
         },
         watch: {
             item: function (newVal) {
                 if (newVal) {
                     console.log("Thay đổi thông tin trong biểu đồ phổ điểm:")
                     console.log(newVal)
                     this.BindData();
                 }
             },
         },
         methods: {
             getName(e){
                 let name = "";
                 for(let i=0;i<this.list_mon_hoc.length;i++){
                     if(e == this.list_mon_hoc[i].value){
                         name = this.list_mon_hoc[i].name;
                     }
                 }
                 console.log("mã là:" + e)
                 console.log("name là:" + name)
                 return name;
             },
             BindData(e) {
                 this.bieuDoPhoDiemHocKyHai.series = this.item;
                 let element = this.$refs.bieudo;
                 var bieuDo = new ApexCharts(element, this.bieuDoPhoDiemHocKyHai);
                 bieuDo.render();
                 bieuDo.updateOptions([this.bieuDoPhoDiemHocKyHai])
             },
         },
     }

 </script>
 <style scoped="scoped">
     .apexcharts-canvas {
         margin: 0 auto !important;
     }

     div#phodiemhockyhai {
         margin: 0 auto;
         text-align: center;
         display: table;
     }

 </style>

<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
         element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog width="40%" :title="headerText" custom-class="showThongTinLoiImportSSO" :visible.sync="showExport"
                   :close-on-press-escape="false"
                   :close-on-click-modal="false" :show-close="false" @before-close="closeExport">
            <el-row :gutter="20">
                <el-col :span="12">
                    <label>Từ trang</label>
                    <el-input-number @change="onStartPageChange" controls-position="right" v-model="dataExport.from" :min="1"
                                     :max="dataExport.to"></el-input-number>
                </el-col>
                <el-col :span="12">
                    <label>Tới trang</label>
                    <el-input-number controls-position="right" v-model="dataExport.to" :min="dataExport.from"
                                     :max="dataExport.maxPage"></el-input-number>
                </el-col>
                <el-col :span="24">
                    <p> Tìm thấy: {{dataExport.totalRecod}} bản ghi ( {{Math.ceil(dataExport.totalRecod/dataExport.recodOnPage)}} trang & {{ dataExport.recodOnPage }} bản ghi/trang). Bạn có thể xuất tối đa
                        ({{ dataExport.maxLimit / dataExport.recodOnPage }} trang)/lần </p>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="danger" @click="closeExport">Đóng</el-button>
                <el-button size="mini" type="primary" @click="xuatDuLieu">Xuất dữ liệu</el-button>
            </span>


        </el-dialog>
    </div>
</template>

<script>
export default {
    props: ['show', 'params_export'],
    components: {},
    watch: {},
    data() {
        return {
            files: null,
            loading: {
                status: false,
                text: 'Loading...'
            },
            headerText: 'Xuất dữ liệu',
            showExport: false,
            dataExport: {
                totalRecod: 0,
                recodOnPage: 25,
                maxLimit: 20000,
                from: 1,
                to: 10,
                minPage: 1,
                maxPage: 10
            }
        }
    },

    mounted: function () {
        console.log('Mounted export file')
        console.log(this.params_export)
        this.bindDataExport();
        this.showExport = true
    },
    methods: {
        onStartPageChange() {
            console.log('onPageChange');
            let countPage = Math.ceil(this.dataExport.totalRecod / this.dataExport.recodOnPage);//Số trang bên ngoài
            let maxPage = Math.ceil(this.dataExport.maxLimit / this.dataExport.recodOnPage);//Số trang tối đa có thể xuất
            console.log('countPage: ' + countPage);
            console.log('maxPage: ' + maxPage);
            if (maxPage < countPage) {
                console.log('Không xuất hết toàn bộ được');
                let maxTo = this.dataExport.from + maxPage - 1;
                console.log('có thể xuất tối đa tới trang: ' + maxTo);
                if (maxTo < countPage) {//Số trang tối đa < số trang bên ngoài
                    this.dataExport.maxPage = maxTo;
                    this.dataExport.to = maxTo
                } else {
                    console.log('Số trang tối đa > số trang bên ngoài');
                    this.dataExport.maxPage = countPage;
                    this.dataExport.to = maxTo
                }
            } else {
                console.log("Có thể xuất toàn bộ")
            }

        },
        bindDataExport() {
            this.dataExport.recodOnPage = this.params_export.recodOnPage;
            this.dataExport.totalRecod = this.params_export.total;
            this.dataExport.from = 1;
            this.dataExport.to = Math.ceil(this.dataExport.totalRecod / this.dataExport.recodOnPage);
            if (this.dataExport.totalRecod <= this.dataExport.maxLimit) {
                this.dataExport.maxPage = Math.ceil(this.dataExport.totalRecod / this.dataExport.recodOnPage);
            } else {
                this.dataExport.maxPage = Math.ceil(this.dataExport.maxLimit / this.dataExport.recodOnPage);
            }
        },
        xuatDuLieu() {
            console.log('xuất dữ liệu');
            let data = {
                start:0,
                limit:0,
                export_all:false
            }
            if(this.dataExport.from==1){
                data.start = 0
            }else{
                data.start = (this.dataExport.from-1)*this.dataExport.recodOnPage
            }
            if(this.dataExport.to>this.dataExport.from){
                data.limit = (this.dataExport.to-this.dataExport.from + 1) * this.dataExport.recodOnPage
            }else {
                data.limit = this.dataExport.recodOnPage
            }
            console.log(data)
            let countPage = Math.ceil(this.dataExport.totalRecod / this.dataExport.recodOnPage);//Tổng số trang tìm thấy
            let maxPage = Math.ceil(this.dataExport.maxLimit / this.dataExport.recodOnPage);//Số trang tối đa có thể xuất
            let countPageExport = this.dataExport.to - this.dataExport.from + 1;//Số trang sẽ xuất
            if(countPageExport<countPage){
                console.log("xuất chưa hết trang");
                data.export_all = false;
            }else{
                data.export_all = true;
                console.log("Xuất toàn bộ")
            }
            this.$emit('checkSuccess',data)
        },
        closeExport() {
            this.$emit('close');
            console.log('Đóng xuất dữ liệu excel')
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

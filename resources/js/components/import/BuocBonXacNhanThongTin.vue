<template>
    <div>
        <div>
            <div class="row">
                <div class="col-md-12 json">
                    <div>
                        <div style="background:#ddd">
                            <p>1.File: <b>{{data_step_one.tenFileImport}}</b></p>
                            <p>2.Nội dung fie:</p>
                            <div class="hienthijson">
                                <p>+ Trang tính: <b>{{data_step_two.data.sheetName}}</b></p>
                                <p>+ Bảng DL có dòng tiêu đề: <b v-if="data_step_two.data.hasTitle">có</b> <b v-else>không</b></p>
                                <p>+ Tiêu đề bảng dữ liệu nằm ở dòng: <b v-if="data_step_two.data.hasTitle">{{data_step_two.data.indexTitle}}</b></p>
                                <p>+ Dữ liệu import từ dòng <b>{{data_step_two.data.startIndex}}</b> tới dòng
                                    <b>{{data_step_two.data.endIndex}}</b></p>
                                <p>+ Năm học: <b>{{data_step_three.namHoc}}-{{data_step_three.namHoc+1}}</b></p>
                            </div>
                            <p>3.Dữ liệu:</p>
                            <div class="hienthijson">
                                <p>+ Loại DL: <b>{{getTenDuLieu(data_step_three.loaiDuLieu)}}</b></p>
                                <p>+ Năm học: <b>{{data_step_three.namHoc}}-{{data_step_three.namHoc+1}}</b></p>
                                <p>+ Học kỳ: <b>{{data_step_three.hocKy}}</b></p>
                                <p>+ Giai đoạn: <b>{{data_step_three.giaiDoan}}</b></p>
                                <p>+ Đơn vị: <b>{{data_step_three.donvi.name}}</b></p>
                                <p>+ Cấp học: <b>{{data_step_three.capHoc.name}}</b></p>
                                <p>+ Trường học: <b>{{data_step_three.truongHoc.name}}</b></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3">
                    <div style="margin-top:15px;">
                        <label for="">Nội dung đã tải lên</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="text-center">
                        <button class="btn btn-danger" @click.prevent="BackStep()">Làm lại</button>
                        <button class="btn btn-primary" @click.prevent="startStepBon()">Tiếp theo</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    
            <div style="">
                <iframe style="width:100%; height:70vh" :src="linkExcel"></iframe>
            </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <!-- <button class="btn btn-info" @click.prevent="BackStep()">Quay lại</button>
            <button class="btn btn-primary" @click.prevent="startStepBon()">Tiếp theo</button> -->
        </div>
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import moment from "moment";
    import dialog from '../../../js/utils/dialog';
    import ElementUI from 'element-ui';
    import constant from '../../utils/constant';
    import VueAlertify from "vue-alertify";
    import datePicker from 'vue-bootstrap-datetimepicker';
    Vue.use(ElementUI);
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            // dialogs default title
            title: 'Thông báo',
            // ok button text
            ok: 'Đồng ý',
            // cancel button text
            cancel: 'Hủy'
        }
    });
    export default {
        props: ['data_step_one', 'data_step_two', 'data_step_three', ],
        components: {
            datePicker,
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                fileJSON: {},
                linkExcel: "",
            };
        },
        mounted: function () {
            this.linkExcel = this.data_step_two.linkExcel;
        },
        methods: {
            getTenDuLieu(e){
                if(e=="HocSinh"){return "Học sinh"}
                if(e=="LopHoc"){return "Lớp học"}
                if(e=="CanBo"){return "Cán bộ"}
                if(e=="KetQuaHocTap"){return "Kết quả học tập"}
            },
            UpLoadFile() {
                console.log("Upload file");
                this.$emit('nextStep', 4)
            },
            BackStep() {
                dialog.confirmDialog(
                    "Xác nhận Upload lại file?",
                    "Đồng ý",
                    () => {
                        location.reload()
                    })
            },
            startStepBon(){
                
                dialog.confirmDialog(
                    "Xác nhận chuyển bước?",
                    "Đồng ý",
                    () => {
                        console.log("dữ liệu bước 3 xong:");
                        this
                            .$alertify
                            .success("Chuyển bước thành công");
                        let dulieu = {
                            step: 4,
                            data: this.data_step_two
                        }
                        this.$emit('nextStep', dulieu)
                    }
                );
            }

        }
    };

</script>
<style scoped="scoped">
    .json {
        font-size: 8px;
        height: 300px;
        overflow-x: scroll;
    }

    .hienthijson {
        padding-left: 25px;
    }
    .row{
        margin: 0;
    }

</style>

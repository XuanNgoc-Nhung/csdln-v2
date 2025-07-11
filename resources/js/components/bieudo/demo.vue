<template>
    <div>
        <div style="margin-top:25px">
            <el-tabs type="border-card2">
                <el-tab-pane label="I. THỐNG KÊ QUẢN LÝ DẠY HỌC, THI TRỰC TUYẾN">
                    <div class="card-bieu-do">
                        <el-row :gutter="24" class="thongketanggiam">
                            <el-col :span="24"><h3>I. Tổng quan</h3></el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Số giáo viên</h3>
                                        <h2>{{duLieuTkTruyCap.gv}}</h2>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Số học sinh</h3>
                                        <h2>{{duLieuTkTruyCap.hs}}</h2>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Số đơn vị sử dụng</h3>
                                        <h2>{{duLieuTkTruyCap.dvi}}</h2>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Lượt truy cập</h3>
                                        <h2>{{duLieuTkTruyCap.total}}</h2>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>
                        <el-row :gutter="24" class="thongketanggiam">
                            <el-col :span="24"><h3>II. Thống kê học liệu</h3></el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Bài giảng</h3>
                                        <h2>{{ (duLieuHocLieu.lesson ? duLieuHocLieu.lesson.totalCount.toLocaleString() : 0)}}</h2>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Bài kiểm tra</h3>
                                        <h2>{{ (duLieuHocLieu.exam ? duLieuHocLieu.exam.totalCount.toLocaleString() : 0)}}</h2>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Lớp học ảo</h3>
                                        <h2>{{ (duLieuHocLieu.onlineConference ? duLieuHocLieu.onlineConference.totalCount.toLocaleString() : 0)}}</h2>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Kế hoạch bài dạy</h3>
                                        <h2>{{ (duLieuHocLieu.lessonPlan ? duLieuHocLieu.lessonPlan.totalCount.toLocaleString() : 0)}}</h2>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Kỳ thi</h3>
                                        <h2>{{ (duLieuHocLieu.examination ? duLieuHocLieu.examination.totalCount.toLocaleString() : 0)}}</h2>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Đề thi</h3>
                                        <h2>{{ (duLieuHocLieu.courseware ? duLieuHocLieu.courseware.totalCount.toLocaleString() : 0)}}</h2>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Câu hỏi</h3>
                                        <h2>{{ (duLieuHocLieu.question ? duLieuHocLieu.question.totalCount.toLocaleString() : 0)}}</h2>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="6">
                                <div class="grid-content bg-purple-light " style="position:relative">
                                    <div class="dts-card-body thongketangiamsl school" style="height: inherit">
                                        <h3>Cuộc họp</h3>
                                        <h2>{{ (duLieuHocLieu.meeting ? duLieuHocLieu.meeting.totalCount.toLocaleString() : 0)}}</h2>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>
                    </div>
                    <div class="card-bieu-do">
                        <el-row :gutter="24" class="thongketanggiam">
                            <el-col :span="24"><h3>III. Biểu đồ tổng quan</h3></el-col>
                            <el-col :span="24">
                                <div class="dts-moibieudo grid-content bg-purple-light">
                                    <div class="dts-card-header">
                                        <span class="dts-card-title">1. Thống kê truy cập 7 ngày gần nhất</span>
                                        <span class="dts-right">
<!--                                    <el-tooltip content="Lấy lại dữ liệu" placement="top"> <i-->
<!--                                        @click.prevent="layThongKeTruyCap"-->
<!--                                        class="asLink fa-solid fa-rotate-right"></i>-->
<!--                                    </el-tooltip>-->
                            </span>
                                    </div>
                                    <div class="dts-card-body" v-loading="loading.thongKeTruyCap"
                                         element-loading-background="rgba(0, 0, 0, 0.8)">
                                        <div v-if="!loading.thongKeTruyCap">
                                            <BieuDoDuong
                                                :dulieu="duLieuBieuDo.thongKeTruyCap.data"
                                            >
                                            </BieuDoDuong>
                                        </div>
                                        <div v-else>
                                            <div class="text-center" style="height:315px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="24">
                                <div class="dts-moibieudo grid-content bg-purple-light">
                                    <div class="dts-card-header">
                                        <span class="dts-card-title">2. Thống kê tài khoản theo khối</span>
                                        <span class="dts-right">

                            </span>
                                    </div>
                                    <div class="dts-card-body" v-loading="loading.thongKeTaiKhoan"
                                         element-loading-background="rgba(0, 0, 0, 0.8)">
                                        <div v-if="!loading.thongKeTaiKhoan">
                                            <BieuDoCotTheoNhom
                                                :dulieu="duLieuBieuDo.thongKeTaiKhoan.data"
                                            >
                                            </BieuDoCotTheoNhom>
                                        </div>
                                        <div v-else style="min-height: 250px">
                                            <div class="text-center" style="height:315px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>
                    </div>

                </el-tab-pane>
                <el-tab-pane label="II. THỐNG KÊ KIỂM ĐỊNH CHẤT LƯỢNG GIÁO DỤC">
                    <div class="card-bieu-do">
                        <el-row :gutter="24" class="thongketanggiam">
                            <el-col :span="12">
                                <div class="dts-moibieudo grid-content bg-purple-light">
                                    <div class="dts-card-header">
                                        <span
                                            class="dts-card-title">Thống kê cán bộ tham gia đánh giá ngoài 5 năm</span>
                                        <span class="dts-right">
                                        </span>
                                    </div>
                                    <div class="dts-card-body" v-loading="loading.thongKeCanBoThamGiaDanhGia"
                                         element-loading-background="rgba(0, 0, 0, 0.8)">
                                        <div v-if="!loading.thongKeCanBoThamGiaDanhGia">
                                            <BieuDoCotTheoNhom
                                                :dulieu="duLieuBieuDo.thongKeCanBoThamGiaDanhGia.data"

                                            >
                                            </BieuDoCotTheoNhom>
                                        </div>
                                        <div v-else style="min-height: 250px">
                                            <div class="text-center" style="height:315px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="12">
                                <div class="dts-moibieudo grid-content bg-purple-light">
                                    <div class="dts-card-header">
                                        <span class="dts-card-title">Thống kê kết quả thực hiện ĐGCLGD</span>
                                            <span class="dts-right">

                                                <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'"
                                                        @change="layThongKeKetQuaDanhGia" filterable
                                                :data="list_nam_hoc" :fields="['name','id']"/>
                                            </span>
                                    </div>
                                    <div class="dts-card-body" v-loading="loading.thongKeKetQuaDanhGia"
                                         element-loading-background="rgba(0, 0, 0, 0.8)">
                                        <div v-if="!loading.thongKeKetQuaDanhGia">
                                            <BieuDoCotTheoNhom
                                                :dulieu="duLieuBieuDo.thongKeKetQuaDanhGia.data"
                                                :list_label="duLieuBieuDo.thongKeKetQuaDanhGia.labels"
                                                :color="duLieuBieuDo.thongKeKetQuaDanhGia.color"
                                            >
                                            </BieuDoCotTheoNhom>
                                        </div>
                                        <div v-else style="min-height: 250px">
                                            <div class="text-center" style="height:315px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>
                    </div>

                </el-tab-pane>
                <el-tab-pane label="III. THỐNG KÊ TẬP HUẤN GIÁO VIÊN">
                    <div class="card-bieu-do">
                        <el-row :gutter="24" class="thongketanggiam">
                            <el-col :span="12">
                                <div class="dts-moibieudo grid-content bg-purple-light">
                                    <div class="dts-card-header">
                                        <span
                                            class="dts-card-title">1. Thống kê cán bộ, giáo viên được cử đi học</span>
                                    </div>
                                    <div class="dts-card-body" v-loading="loading.daCuDiHoc"
                                         element-loading-background="rgba(0, 0, 0, 0.8)">
                                        <div v-if="!loading.daCuDiHoc">
                                            <BieuDoTron
                                                :dulieu="duLieuBieuDo.daCuDiHoc.data"
                                            >
                                            </BieuDoTron>
                                        </div>
                                        <div v-else style="min-height: 250px">
                                            <div class="text-center" style="height:315px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-col>
                            <el-col :span="12">
                                <div class="dts-moibieudo grid-content bg-purple-light">
                                    <div class="dts-card-header">
                                        <span
                                            class="dts-card-title">2. KẾT QUẢ TẬP HUẤN</span>
                                    </div>
                                    <div class="dts-card-body" v-loading="loading.ketQuaTapHuan"
                                         element-loading-background="rgba(0, 0, 0, 0.8)">
                                        <div v-if="!loading.ketQuaTapHuan">
                                            <BieuDoTron
                                                :dulieu="duLieuBieuDo.ketQuaTapHuan.data"
                                            >
                                            </BieuDoTron>
                                        </div>
                                        <div v-else style="min-height: 250px">
                                            <div class="text-center" style="height:315px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>


                    </div>
                    <div class="card-bieu-do">
                        <el-row :gutter="24">
                            <el-col :span="24">
                                <div class="dts-moibieudo grid-content bg-purple-light">
                                    <div class="dts-card-header">
                                        <span class="dts-card-title">Tổng quan phần đánh giá chuẩn TEMIS</span>
                                        <span class="dts-right"></span>
                                    </div>
                                    <div class="dts-card-body" v-loading="loading.thongKeTMIS"
                                         element-loading-background="rgba(0, 0, 0, 0.8)">
                                        <div>
                                            <BieuDoCotTheoNhom
                                                    :dulieu="duLieuBieuDo.thongKeTMIS.data"
                                            >
                                            </BieuDoCotTheoNhom>
                                        </div>
                                        <div v-show="loading.thongKeCanBoThamGiaDanhGia" style="min-height: 250px">
                                            <div class="text-center" style="height:315px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>
                    </div>
                </el-tab-pane>
            </el-tabs>
        </div>
    </div>
</template>
<script>
import rest_api from '../../utils/rest_api';
import ESelectVue from '../ui/ESelect.vue';
import BieuDoDuong from './ChartComponent2/bieuDoDuong'
import BieuDoCotTheoNhom from './ChartComponent2/bieuDoCotNhom'
import BieuDoTron from './ChartComponent2/bieuDoTron'
import constant from "../../utils/constant";

export default {
    props: [],
    components: {
        'eselect': ESelectVue,
        BieuDoDuong,
        BieuDoCotTheoNhom,
        BieuDoTron,
    },
    data() {

        let year = new Date().getFullYear();
        let years = [];
        let list_nam_hoc = [];
        for (let i = year - 5; i<= year; i++){
            years.push(i.toString() +  '-' +(i+1).toString());
            list_nam_hoc.push({
                id: i,
                name: i+"-"+(i+1)
            })
        }



        return {
            duLieuTkTruyCap : {gv : 0,hs : 0, dvi : 0, total : 0},

            duLieuHocLieu : {},

            duLieuBieuDo: {
                thongKeTMIS: {
                    data: null,
                    labels: years,
                    color: ['#FF0000', '#00FF00', '#006600', '#FF00FF', '#800080'],
                },
                thongKeTruyCap: {
                    data: null,
                    labels: []
                },
                thongKeTaiKhoan: {
                    data: null,
                    labels: ['khối 1', 'Khối 2', 'Khối 3', 'Khối 4', 'Khối 5'],
                    color: ['#00BB00', '#990066'],
                },
                thongKeCanBoThamGiaDanhGia: {
                    data: null,
                    labels: ['2016-2017', '2017-2018', '2018-2019', '2019-2020', '2020-2021'],
                    color: ['#FF0000', '#00FF00', '#006600', '#FF00FF', '#800080'],
                },
                thongKeKetQuaDanhGia: {
                    data: null,
                    labels: ['Mầm non', 'Tiểu học', 'THCS', 'THPT', 'GDTX'],
                    color: ['#00BB00', '#800080'],
                },
                daCuDiHoc: {
                    data: null,
                    labels: ['Đã bắt đầu học', 'Chưa đi học'],
                    color: ['#00BB00', '#800080'],
                },
                ketQuaTapHuan: {
                    data: null,
                    labels: ['Đạt', 'Chưa đạt'],
                    color: ['#00BB00', '#800080'],
                }
            },
            loading: {
                thongKeTMIS : true,
                thongKeTruyCap: true,
                thongKeTaiKhoan: true,
                thongKeCanBoThamGiaDanhGia: true,
                thongKeKetQuaDanhGia: true,
                daCuDiHoc: true,
                ketQuaTapHuan: true,
            },
            list_nam_hoc: list_nam_hoc,
            namHoc: (year-1)
        }
    },
    watch: {},
    beforeMount() {

    },
    mounted: function () {


        // this.layThongKeTaiKhoan();
        this.thongKeHocLieu();
        this.tongQuanTaiKhoan();
        this.layThongKeTruyCap();

        this.thongKeTaiKhoanTheoKhoi();

        this.layThongKeCanBoThamGiaDanhGia();
        this.layThongKeKetQuaDanhGia();
        this.layThongKeDaCuDiHoc();
        this.layThongKeTMIS();

    },
    methods: {
        thongKeTaiKhoanTheoKhoi(){
            this.loading.thongKeTaiKhoan = true;
            const today = new Date();
            const yyyy = today.getFullYear();
            let mm = today.getMonth() + 1; // Months start at 0!
            let dd = today.getDate();

            if (dd < 10) dd = '0' + dd;
            if (mm < 10) mm = '0' + mm;

            const formattedToday = dd + '/' + mm + '/' + yyyy;

            let uri = '/csdlgd-report-api/K12/hocSinhTheoKhoi';
            let params = {
                "day" : formattedToday,
            };

            rest_api.post(uri,params,(data) => {
                if (data.data && data.data.status == "SUCCESS"){
                    let labels = [];
                    let  column = data.data.columns ?  Object.values(data.data.columns) : [];
                    let items = data.data.items ? data.data.items : {}
                    let dataBieDo = [
                        {
                            "name": "Tổng số học sinh",
                            "data": []
                        },
                        {
                            "name": "Số học sinh đã login",
                            "data": []
                        },
                    ];

                    console.log(data.data.columns)

                    if(column.length){
                        console.log('1222222222222222222222222222222');
                        let totalHs = [];
                        let totalHsLogin = [];
                        column.map((item) => {
                            labels.push(item.title);
                            let total = items.total[item.code] ? items.total[item.code] : 0;
                            let totalLogin = items.totalLogin[item.code] ? items.totalLogin[item.code] : 0;
                            totalHs.push(total);
                            totalHsLogin.push(totalLogin);
                        });
                        dataBieDo = [
                            {
                                "name": "Số học sinh đã login",
                                "data": totalHsLogin
                            },
                            {
                                "name": "Tổng số học sinh",
                                "data": totalHs
                            },
                        ];
                    }
                    this.duLieuBieuDo.thongKeTaiKhoan.labels = labels;


                    this.duLieuBieuDo.thongKeTaiKhoan.data = {
                        category: labels,
                        series: dataBieDo,
                        height : '400'
                    }
                }
                this.loading.thongKeTaiKhoan = false
            },null,true)
        },





        tongQuanTaiKhoan(){
            let uri = '/csdlgd-report-api/K12/thongKeTongQuan';
            let params = {};
            rest_api.get(uri,params,(data) => {
                if (data.data && data.data.status == "SUCCESS"){
                    let result = data.data.items;
                    let hs = result[1] ? result[1] : [];
                    let gv = result[0] ? result[0] : [];
                    let dvi = result[2] ? result[2] : [];
                    let total = result[3] ? result[3] : [];

                    this.duLieuTkTruyCap.gv = gv.totalCount ? gv.totalCount.split('/')[1] : 0;
                    this.duLieuTkTruyCap.hs = hs.totalCount ? hs.totalCount.split('/')[1] : 0;
                    this.duLieuTkTruyCap.dvi = dvi.totalCount ? dvi.totalCount.split('/')[0] : 0;
                    this.duLieuTkTruyCap.total = total.totalCount ? total.totalCount.toLocaleString() : 0;
                }
            })
        },

        thongKeHocLieu(){
            let uri = '/csdlgd-report-api/K12/thongKeHocLieu';
            let params = {};
            rest_api.get(uri,params,(data) => {
                if (data.data && data.data.status == "SUCCESS"){
                    this.duLieuHocLieu = data.data.items;
                }
            },null,true)

        },

        layTMISbyYear(params,dataBuild = {total : [],self_assessment : [],final_assessment : []}){
            let uri = 'https://taphuan-api.csdl.edu.vn/assessment/rest/overview-stats'

            rest_api.get2(uri,params,(data) => {

                if (data.data && data.data.success){
                    let result = data.data.result;

                    let gv = result.find(item => {
                        return item.target_user = 'gv'
                    })
                    let cb = result.find(item => {
                        return item.target_user = 'cbql'
                    })

                    let total = (gv.total ? gv.total : 0)  + (cb.total ? cb.total : 0);
                    let self_assessment = (gv.self_assessment ? gv.self_assessment : 0)  + (cb.self_assessment ? cb.self_assessment : 0);
                    let final_assessment = (gv.final_assessment ? gv.final_assessment : 0)  + (cb.final_assessment ? cb.final_assessment : 0);

                    dataBuild.total.push(total);
                    dataBuild.self_assessment.push(self_assessment);
                    dataBuild.final_assessment.push(final_assessment);

                    if (dataBuild.total.length < 5){
                        let newParams = params;
                        newParams.school_year=this.duLieuBieuDo.thongKeTMIS.labels[dataBuild.total.length],
                        this.layTMISbyYear(newParams,dataBuild)
                    }else if (dataBuild.total.length == 5){

                        let dataBieDo = [
                            {
                                "name": "Tổng số CB/GV",
                                "data": dataBuild.total
                            },
                            {
                                "name": "Số CBGV tự đánh giá",
                                "data": dataBuild.self_assessment
                            },
                            {
                                "name": "Số CBGV thủ trưởng đánh giá",
                                "data": dataBuild.final_assessment
                            },

                        ];

                        this.duLieuBieuDo.thongKeTMIS.data = {
                            category: this.duLieuBieuDo.thongKeTMIS.labels,
                            series: dataBieDo,
                            height : '400'
                        }
                        this.loading.thongKeTMIS = false
                        return;
                    }
                }
            })

        },

        layThongKeTMIS() {
            console.log("Lấy thống kê TMIS")
            this.loading.thongKeTMIS = true;

            let params = {
                'org_code' : 79,
                '_sand_client_id' : 'hcm_sgd',
                '_sand_client_secret' : 'ZG2yxeYLevmNVgXEIqiFWTNrRqsHYvb2',
                "school_year" : this.duLieuBieuDo.thongKeTMIS.labels[0],


            }

            this.layTMISbyYear(params);


        },


        layThongKeDaCuDiHoc() {
            console.log("layThongKeDaCuDiHoc")
            let uri = 'https://taphuan-api.csdl.edu.vn/report/api/organization-learning-simple-stats';
            let params = {
                '_sand_client_secret' : 'ZG2yxeYLevmNVgXEIqiFWTNrRqsHYvb2',
                "tp_category" : 1,
                'org_code' : 79,
                '_sand_client_id' : 'hcm_sgd'
            }
            this.loading.daCuDiHoc = true;
            this.loading.ketQuaTapHuan = true
            rest_api.get2(uri,params,(data)=>{

                let dulieu = [];
                let kqTapHuan = [];
                if (data.data && data.data.success){
                    let result = data.data.result;

                    // this.duLieuBieuDo.thongKeTaiKhoan.data = [];
                    let chuaHoc = result.assigned - result.learned;
                    kqTapHuan = [result.passed,(result.learned - result.passed)]

                    dulieu = [result.learned,chuaHoc]
                    this.duLieuBieuDo.ketQuaTapHuan.data = {
                        category: this.duLieuBieuDo.ketQuaTapHuan.labels,
                        series: kqTapHuan,
                        totalText: '',
                    };
                    this.duLieuBieuDo.daCuDiHoc.data = {
                        category: this.duLieuBieuDo.daCuDiHoc.labels,
                        series: dulieu,
                        totalText: '',
                    };

                }
                this.loading.daCuDiHoc = false;
                this.loading.ketQuaTapHuan = false
            })

        },

        layThongKeKetQuaDanhGia() {

            this.loading.thongKeKetQuaDanhGia = true;

            let uri = '/csdlgd-report-api/kdclViettel/ThongKeKqDgclgd';
            let params = {namHoc : this.namHoc};
            rest_api.get(uri,params,(data)=>{

                if (data.data && data.data.StatusCode == 200){
                    let duLieu = data.data.Data;
                    let mn = duLieu.find(item =>{
                        return item.SchoolLevel == 5
                    });
                    let c1 = duLieu.find(item =>{
                        return item.SchoolLevel == 1
                    });

                    let c2 = duLieu.find(item =>{
                        return item.SchoolLevel == 2
                    });
                    let c3 = duLieu.find(item =>{
                        return item.SchoolLevel == 3
                    });
                    let gdtx = duLieu.find(item =>{
                        return item.SchoolLevel == 4
                    });
                    let dataBieDo = [
                            {
                                "name": "Tự đánh giá",
                                "data": [mn.SelfAssessmentValue,c1.SelfAssessmentValue,c2.SelfAssessmentValue,c3.SelfAssessmentValue,gdtx.SelfAssessmentValue]
                            },
                            {
                                "name": "Đánh giá ngoài",
                                "data": [mn.ExternalAssessmentValue,c1.ExternalAssessmentValue,c2.ExternalAssessmentValue,c3.ExternalAssessmentValue,gdtx.ExternalAssessmentValue]
                            },
                    ]

                    this.duLieuBieuDo.thongKeKetQuaDanhGia.data = {
                        category: this.duLieuBieuDo.thongKeKetQuaDanhGia.labels,
                        series: dataBieDo,
                        height : '400'
                    }

                }
                this.loading.thongKeKetQuaDanhGia = false;

            })

            // this.duLieuBieuDo.thongKeTaiKhoan.data = [];
            // let data = [
            //     {
            //         "name": "Tự đánh giá",
            //         "data": this.getArrayRandomNumber(5)
            //     },
            //     {
            //         "name": "Đánh giá ngoài",
            //         "data": this.getArrayRandomNumber(5)
            //     },
            // ]
            // console.log(this.duLieuBieuDo.thongKeKetQuaDanhGia)
            // setTimeout(() => {
            //     this.duLieuBieuDo.thongKeKetQuaDanhGia.data = data;
            //     this.loading.thongKeKetQuaDanhGia = false
            // }, 500);
        },

        layThongKeCanBoThamGiaDanhGiaByYear(params,dataBuild = {mn : [],c1 : [],c2 : [],c3 : [], gdtx : []}){
            let uri = '/csdlgd-report-api/kdclViettel/kqThongKeCbDanhGiaNgoai';
            rest_api.get(uri,params,(data)=>{
                if (data.data && data.data.StatusCode == 200){

                    let duLieu = data.data.Data;
                    let mn = duLieu.find(item =>{
                        return item.SchoolLevel == 5
                    });
                    let c1 = duLieu.find(item =>{
                        return item.SchoolLevel == 1
                    });

                    let c2 = duLieu.find(item =>{
                        return item.SchoolLevel == 2
                    });
                    let c3 = duLieu.find(item =>{
                        return item.SchoolLevel == 3
                    });
                    let gdtx = duLieu.find(item =>{
                        return item.SchoolLevel == 4
                    });

                    dataBuild.mn.push(mn.ExternalAssessmentValue)
                    dataBuild.c1.push(c1.ExternalAssessmentValue)
                    dataBuild.c2.push(c2.ExternalAssessmentValue)
                    dataBuild.c3.push(c3.ExternalAssessmentValue)
                    dataBuild.gdtx.push(gdtx.ExternalAssessmentValue)

                }else{
                    dataBuild.mn.push(0)
                    dataBuild.c1.push(0)
                    dataBuild.c2.push(0)
                    dataBuild.c3.push(0)
                    dataBuild.gdtx.push(0)
                }
                if ( dataBuild.mn.length < 5){
                    let newParams = params;
                    newParams.namHoc=this.list_nam_hoc[dataBuild.mn.length];
                    this.layThongKeCanBoThamGiaDanhGiaByYear(newParams,dataBuild)
                }else if (dataBuild.mn.length == 5){

                    let dataBieDo = [
                        {
                            "name": "Mầm non",
                            "data": dataBuild.mn
                        },
                        {
                            "name": "Tiểu học",
                            "data": dataBuild.c1
                        },
                        {
                            "name": "THCS",
                            "data": dataBuild.c2
                        },
                        {
                            "name": "THPT",
                            "data": dataBuild.c3
                        },
                        {
                            "name": "GDTX",
                            "data": dataBuild.gdtx
                        },
                    ];

                    let labels = this.list_nam_hoc.map(item => {
                        return item.name;
                    })

                    this.duLieuBieuDo.thongKeCanBoThamGiaDanhGia.data = {
                        category: labels,
                        series: dataBieDo,
                        height : '400'
                    }
                    this.loading.thongKeCanBoThamGiaDanhGia = false
                }
            })
        },
        layThongKeCanBoThamGiaDanhGia() {

            this.loading.thongKeCanBoThamGiaDanhGia = true;



            let params = {namHoc : this.list_nam_hoc[0].id};

            this.layThongKeCanBoThamGiaDanhGiaByYear(params)


            // rest_api.get(uri,params,(data)=>{
            //     if (data.data && data.data.StatusCode == 200){
            //
            //     }
            //
            // })
            // this.duLieuBieuDo.thongKeTaiKhoan.data = [];
            // let data = [
            //     {
            //         "name": "Mầm non",
            //         "data": this.getArrayRandomNumber(5)
            //     },
            //     {
            //         "name": "Tiểu học",
            //         "data": this.getArrayRandomNumber(5)
            //     },
            //     {
            //         "name": "THCS",
            //         "data": this.getArrayRandomNumber(5)
            //     },
            //     {
            //         "name": "THPT",
            //         "data": this.getArrayRandomNumber(5)
            //     },
            //     {
            //         "name": "GDTX",
            //         "data": this.getArrayRandomNumber(5)
            //     },
            // ]
            // console.log(this.duLieuBieuDo.thongKeCanBoThamGiaDanhGia)
            // setTimeout(() => {
            //     this.duLieuBieuDo.thongKeCanBoThamGiaDanhGia.data = data;
            //     this.loading.thongKeCanBoThamGiaDanhGia = false
            // }, 500);
        },


        layThongKeTruyCap() {
            this.loading.thongKeTruyCap = true;
            const today = new Date();
            const yyyy = today.getFullYear();
            let mm = today.getMonth() + 1; // Months start at 0!
            let dd = today.getDate();

            if (dd < 10) dd = '0' + dd;
            if (mm < 10) mm = '0' + mm;

            const formattedToday = dd + '/' + mm + '/' + yyyy;

            let uri = '/csdlgd-report-api/K12/thongKeTruyCap';
            let params = {
                "day" : formattedToday,
            };

            rest_api.post(uri,params,(data) => {
                if (data.data && data.data.status == "SUCCESS"){
                    let duLieu = data.data.rows;
                    let categories = data.data.rows[0];
                    categories.shift();
                    let series = data.data.rows[1];
                    series.shift()
                    this.duLieuBieuDo.thongKeTruyCap.data = {
                        totalText : '',
                        categories : categories,
                        series : [
                            {
                                name: 'Lượt truy cập',
                                data : series
                            }
                        ]
                    }
                }
                this.loading.thongKeTruyCap = false
            },null,true)

        },

        getArrayRandomNumber(length) {
            let arr = [];
            for (let i = 0; i < length; i++) {
                let numberRandom = Math.floor(Math.random() * 1000);
                arr.push(numberRandom)
            }
            return arr;
        }
    }
}

</script>
<style scoped="scoped">
h3,
h5 {
    margin: 0;
}

#page-wrapper {
    background: red;
}

.el-row {
    margin: 0 !important;
}

.el-col {
    border-radius: 4px;
    padding-top: 10px;
    padding-bottom: 10px;
}

.bg-purple-dark {
    background: #99a9bf;
}

.bg-purple {
    background: #d3dce6;
}

.bg-purple-light {
    /* background: #e5e9f2; */
    height: 100px;
}

.grid-content {
    border-radius: 4px;
    min-height: 36px;
}

.row-bg {
    padding: 10px 0;
    background-color: #f9fafc;
}

/* css custom */
.dts-card-header {
    background: #f2f3f8;
    height: 25px;
    color: black;
    padding: 5px;
    border-top-right-radius: 10px;
    border-top-left-radius: 10px;
}

.dts-card-title {
    color: #070707;
    padding-left: 10px;
    text-transform: uppercase;
    font-weight: bold;
}

.dts-card-body {
    padding: 5px;
    background: white;
    height: 300px;
    position: relative;
    border-bottom-right-radius: 10px !important;
    border-bottom-left-radius: 10px !important;
    border: #f2f3f8 2px solid;
}

.dts-card-body-ct {
    padding: 5px;
    background: white;
    height: 350px;
    position: relative;
    border-bottom-right-radius: 10px !important;
    border-bottom-left-radius: 10px !important;
    border: #f2f3f8 2px solid;
}

.tuychongiaodien {
    border: 1px solid;
    position: absolute;
    right: 0;
    width: 100%;
    background: navajowhite;
    z-index: 2;
}

.dts-right {
    float: right;
    padding: 0 5px;
}

.dts-right a {
    color: white;
}

.card-bieu-do {
    /* border: 1px solid #088A4B; */
    margin: 15px 0;
    background: white;
    border-radius: 10px;
}

.card-bieu-do h5 {
    font-size: 18px;
    padding-left: 10px;
    color: blue;
    font-weight: 700
}

.dts-moibieudo {
    display: contents;
    border: 1px solid blue;
}

.amount {
    font-size: 26px;
    color: deeppink;
    font-weight: 600;
}

.soluongtanggiam {
    font-size: 30px !important;
}

.anhtanggiam {
    margin-top: -10px;
}

.list-enter,
.list-leave-to {
    visibility: hidden;
    height: 0;
    margin: 0;
    padding: 0;
    opacity: 0;
}

.list-enter-active,
.list-leave-active {
    transition: all 0.3s;
}

.card-tuychon {
    padding: 10px;
}

.thongketangiamsl {
    background: #1ab394;
    border-radius: 10px;
    padding: 12px;
    color: white;
    font-size: 18px !important;
}

.thongketangiamsl h2 {
    text-align: center;
}

.el-loading-mask {
    border-bottom-right-radius: 0px !important;
    border-bottom-left-radius: 0px !important;
}

.inline {
    display: inline-flex;
}

.dts-card-body {
    height: max-content !important;
}

.asLink {
    cursor: pointer;
}

th {
    text-align: center;
    background: azure
}

.dts-card-header {
    height: 38px
}
</style>

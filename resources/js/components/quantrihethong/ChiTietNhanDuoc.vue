<template>
    <div id="thongtin_nhanduoc" ref="thongtin_nhanduoc" class="modal fade">
        <div class="modal-dialog" style="width: 60%;">
            <div class="modal-content">
                <form @submit.prevent="themToThonSubmit">
                    <div class="modal-header">
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-hidden="true"
                            v-on:click="closeinfo()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chi tiết
                        </h4>
                    </div>
                    <div v-if="type==3||type==4" class="modal-body clearfix">
                        <div class="text-center" v-if="tenBang==1">
                            <div v-if="ChiTietDuLieu.Status==1">
                                <p style="font-size:24px;">Thành công</p>
                            </div>
                            <div v-else="v-else">
                                <p style="font-size:24px;">Thất bại</p>
                            </div>
                        </div>
                        <div class="text-center" v-if="tenBang==2">
                            <div class="table-responsive row_tp" style="height:400px;">
                                <table
                                    v-if="loaiDuLieu==8"
                                    class="table table-striped table-bordered table-hover"
                                   >
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã lớp học</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ChiTietDuLieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có dữ liệu phù hợp</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(tt,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                <div v-if="tt.MaLopHoc">
                                                    {{tt.MaLopHoc}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                            <td>{{tt.Message}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="loaiDuLieu!=8">
                                    <div>
                                        <textarea
                                            class="language-json myTextArea"
                                            style="width:100%; margin:0 auto;height:50vh"
                                            :value="duLieuTextArea"
                                            id="myTextArea"
                                            cols="50"
                                            rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center" v-if="tenBang==3||tenBang==4">
                            <div class="table-responsive row_tp" style="height:400px;">
                                <table
                                    v-if="loaiDuLieu==8"
                                    class="table table-striped table-bordered table-hover"
                                    style="font-size:12px; ">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã học sinh</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ChiTietDuLieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có dữ liệu phù hợp</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(tt,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                <div v-if="tt.MaHocSinh">
                                                    {{tt.MaHocSinh}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                            <td>{{tt.Message}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="loaiDuLieu!=8">
                                    <div>
                                        <textarea
                                            class="language-json myTextArea"
                                            style="width:100%; margin:0 auto;height:50vh"
                                            :value="duLieuTextArea"
                                            id="myTextArea"
                                            cols="50"
                                            rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center" v-if="tenBang==7||tenBang==8">
                            <div class="table-responsive row_tp" style="height:400px;">
                                <table
                                    class="table table-striped table-bordered table-hover"
                                    style="font-size:12px; ">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã học sinh</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ChiTietDuLieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có bản ghi lỗi nào</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(tt,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                <div v-if="tt.MaHocSinh">
                                                    {{tt.MaHocSinh}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                            <td>{{tt.Message}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="text-center" v-if="tenBang==5||tenBang==6">
                            <div class="table-responsive row_tp" style="height:400px;">
                                <table
                                    v-if="loaiDuLieu==8"
                                    class="table table-striped table-bordered table-hover"
                                    style="font-size:12px; ">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã cán bộ</th>
                                            <th class="text-center">Tên cán bộ</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ChiTietDuLieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có dữ liệu phù hợp</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(tt,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                <div v-if="tt.MaCanBo">
                                                    {{tt.MaCanBo}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td class="text-center">
                                                <div v-if="tt.TenCanBo">
                                                    {{tt.TenCanBo}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                            <td>{{tt.Message}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="loaiDuLieu!=8">
                                    <div>
                                        <textarea
                                            class="language-json myTextArea"
                                            style="width:100%; margin:0 auto;height:50vh"
                                            :value="duLieuTextArea"
                                            id="myTextArea"
                                            cols="50"
                                            rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="type==1||type==2">
                        <textarea
                            class="language-json myTextArea"
                            style="width:100%; margin:0 auto;height:50vh"
                            id="myTextArea"
                            :value="duLieuTextArea"
                            cols="50"
                            rows="10"></textarea>
                    </div>
                    <div class="modal-footer clearfix">
                        <butto size="mini" type="default" class="btn btn-default" data-dismiss="modal">Đóng
                        </butto>
                    </div>
                </form>
            </div>

        </div>

    </div>

</template>

<script>

    import utils from '../../utils';
    import rest_api from "../../utils/rest_api";
    import api from '../api';
    import VeeValidate, {Validator} from 'vee-validate';
    import {mapState} from 'vuex';
    Vue.use(VeeValidate);
    $(document).ready(function () {});

    export default {

        props: [
            'item', 'hien', 'thongtin', 'cateday', 'tabname','subId'
        ],
        computed: {
            ...mapState(['loaiDuLieu'])
        },
        watch: {
            subId: function (newVal) {
                this.subIds = newVal;
                console.log("subId");
                console.log(this.subIds);
            },
            thongtin: function (newVal) {
                this.id = newVal;
            },
            cateday: function (newVal) {
                this.type = newVal;
            },
            hien: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {

            this.getTenBang(this.tabname);
            console.log("Tên bảng:" + this.tabname);
            console.log("Loại đẩy:" + this.cateday);
            console.log("Thông tin:" + this.thongtin);
            this.id = this.thongtin;
            this.type = this.cateday;
                    this.ChiTietDuLieu = "";
                    $("#thongtin_nhanduoc").modal();
                    this.getDetail();
                    console.log("lấy thông tin");
                } else {
                    $("#thongtin_nhanduoc").modal('hide');
                }
            },
            tabname: function (newVal) {
                console.log(newVal);
                this.tenBang = newVal;
                console.log("tên bảng: 12:" + this.tenBang);
                if (newVal == "TruongHocNam") {
                    this.tenBang = 1;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
                if (newVal == "LopHoc") {
                    this.tenBang = 2;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
                if (newVal == "HoSoHocSinh") {
                    this.tenBang = 3;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
                if (newVal == "HocSinhTheoNam") {
                    this.tenBang = 4;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
                if (newVal == "HoSoGiaoVien") {
                    this.tenBang = 5;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
                if (newVal == "CanBoTheoNam") {
                    this.tenBang = 6;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
                if (newVal == "DiemTongKetMon") {
                    this.tenBang = 7;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
                if (newVal == "TongKetHocSinh") {
                    this.tenBang = 8;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
            }
        },

        data() {
            return {id: "", type: '', ChiTietDuLieu: "", tenBang: "",duLieuTextArea:"",subIds:""}
        },
        mounted: function () {
            // console.log("Loại dữ liệu:" + this.loaiDuLieu);
            this.getTenBang(this.tabname);
            console.log("Tên bảng:" + this.tabname);
            console.log("Loại đẩy:" + this.cateday);
            console.log("Thông tin:" + this.thongtin);
            this.id = this.thongtin;
            this.type = this.cateday;
            // $("#thongtin_nhanduoc").modal();
            // this.getDetail();
            $(this.$refs.thongtin_nhanduoc).on("hidden.bs.modal", this.closeinfo);
            // this.getDetail();
        },

        methods: {
            getTenBang(e){
                if (e == "TruongHocNam") {
                    this.tenBang = 1;
                }
                if (e == "LopHoc") {
                    this.tenBang = 2;
                }
                if (e == "HoSoHocSinh") {
                    this.tenBang = 3;
                }
                if (e == "HocSinhTheoNam") {
                    this.tenBang = 4;
                }
                if (e == "HoSoGiaoVien") {
                    this.tenBang = 5;
                }
                if (e == "CanBoTheoNam") {
                    this.tenBang = 6;
                }
                if (e == "DiemTongKetMon") {
                    this.tenBang = 7;
                }
                if (e == "TongKetHocSinh") {
                    this.tenBang = 8;
                }
            },
            getDetail() {
                this.ChiTietDuLieu = "";
                let params = {
                    id: this.id,
                    type: this.type
                };
                if(this.type==3){
                    params.subId = this.subIds
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get(
                    "/csdlgd-report-api/history-syncdata/school/detail-response/v2",
                    params,
                    data => {
                        loading.close();
                        console.log("Dữ liệu lấy trả về:" + JSON.stringify(data))
                        if (data.data.rc == 0) {
                            this.ChiTietDuLieu = data.data.item.detail;
                            this.ChiTietDuLieu = JSON.stringify(this.ChiTietDuLieu);
                            var obj = JSON.parse(JSON.parse(this.ChiTietDuLieu));
                            var pretty = JSON.stringify(obj, undefined, 2);
                            console.log("dữ liệu trả về:" + pretty);
                            this.duLieuTextArea = pretty;
                            // var ugly = document
                            //     .getElementById('myTextArea')
                            //     .value;
                            // document
                            //     .getElementById('myTextArea')
                            //     .value = pretty;
                            if (this.loaiDuLieu == 8) {
                                if (this.type == 3 || this.type == 4) {
                                    this.ChiTietDuLieu = JSON.parse(this.ChiTietDuLieu);
                                    this.ChiTietDuLieu = JSON.parse(this.ChiTietDuLieu);
                                }
                            }
                            if (this.loaiDuLieu != 8) {
                                console.log("loại dữ liệu: !=8");
                                if (this.type == 3 || this.type == 4) {
                                    console.log(this.ChiTietDuLieu);
                                    if (this.tenBang == 1) {
                                        this.ChiTietDuLieu = JSON.parse(this.ChiTietDuLieu);
                                        this.ChiTietDuLieu = JSON.parse(this.ChiTietDuLieu);
                                    }
                                }
                                if (this.tenBang == 7 || this.tenBang == 8) {
                                    console.log("thông tin nhận được của đẩy điểm các thứ:");
                                    this.ChiTietDuLieu = JSON.parse(JSON.parse(this.ChiTietDuLieu));
                                    console.log(this.ChiTietDuLieu);
                                }
                            }
                        } else {
                            utils.showDialog("Thất bại", data.data.rd, null, () => {});
                            return;
                        }
                    }
                );
            },
            reset() {
                this.ChiTietDuLieu = ""
            },
            closeinfo() {
                this.reset();
                console.log("đóng tỏng chi tiết nhận được");
                this.$emit('closeinfo');
            }
        }

    }
</script>

<template>
    <div>
        <el-dialog title="Chi tiết thông tin" :show-close="false" :visible.sync="hien_thi_noi_dung" :close-on-press-escape="false" :close-on-click-modal="false" width="80%">
            <form >
                <el-row :gutter="20">
                    <el-col :span="24">
                        <div v-if="type==3||type==4">
                            <div class="text-center" v-if="tenBang==1">
                                <div v-if="ChiTietDuLieu.Status==1">
                                    <p style="font-size:24px;">Thành công</p>
                                </div>
                                <div v-else>
                                    <p style="font-size:24px;">Thất bại</p>
                                </div>
                            </div>
                            <div class="text-center" v-if="tenBang==2">
                                <div class="table-responsive row_tp"  >
                                    <table v-if="loaiDuLieu==8" class="table table-striped table-bordered table-hover"
                                       >
                                        <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Mã lớp học</th>
                                                <th >Trạng thái</th>
                                                <th >Mô tả</th>
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
                                            <textarea class="language-json myTextArea"
                                                style="width:100%; margin:0 auto;height:50vh" :value="duLieuTextArea"
                                                id="myTextArea" cols="50" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center" v-if="tenBang==3||tenBang==4">
                                <div class="table-responsives row_tp"  >
                                    <table v-if="loaiDuLieu==8" class="table table-striped table-bordered table-hover"
                                        style="font-size:12px; ">
                                        <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th class="">Mã học sinh</th>
                                                <th>Trạng thái</th>
                                                <th >Mô tả</th>
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
                                                    <div v-else>[Trống]</div>
                                                </td>
                                                <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                                <td>{{tt.Message}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-if="loaiDuLieu!=8">
                                        <div>
                                            <textarea class="language-json myTextArea"
                                                style="width:100%; margin:0 auto;height:50vh" :value="duLieuTextArea"
                                                id="myTextArea" cols="50" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center" v-if="tenBang==7||tenBang==8">
                                <div class="table-responsive row_tp"  >
                                    <table class="table table-striped table-bordered table-hover"
                                        style="font-size:12px; ">
                                        <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th class="">Mã học sinh</th>
                                                <th>Trạng thái</th>
                                                <th >Mô tả</th>
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
                                <div class="table-responsive row_tp"  >
                                    <table v-if="loaiDuLieu==8" class="table table-striped table-bordered table-hover"
                                        style="font-size:12px; ">
                                        <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Mã cán bộ</th>
                                                <th class="text-center">Tên cán bộ</th>
                                                <th>Trạng thái</th>
                                                <th >Mô tả</th>
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
                                            <textarea class="language-json myTextArea"
                                                style="width:100%; margin:0 auto;height:50vh" :value="duLieuTextArea"
                                                id="myTextArea" cols="50" rows="10"></textarea>
                                        </div>Ki
                                    </div>
                                </div>
                            </div>
                            <div class="text-center" v-if="tenBang==9">
                                <div class="table-responsive row_tp"  >
                                    <table v-if="loaiDuLieu==8" class="table table-striped table-bordered table-hover"
                                        style="font-size:12px; ">
                                        <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Mã điểm trường</th>
                                                <th class="text-center">Tên điểm trường</th>
                                                <th>Trạng thái</th>
                                                <th >Mô tả</th>
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
                                                    <div v-if="tt.MaDiemTruong">
                                                        {{tt.MaDiemTruong}}
                                                    </div>
                                                    <div v-else="v-else">[Trống]</div>
                                                </td>
                                                <td>
                                                    <div v-if="tt.TenDiemTruong">
                                                        {{tt.TenDiemTruong}}
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
                                            <textarea class="language-json myTextArea"
                                                style="width:100%; margin:0 auto;height:50vh" :value="duLieuTextArea"
                                                id="myTextArea" cols="50" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center" v-if="tenBang==10">
                                <div class="table-responsive row_tp"  >
                                    <table v-if="loaiDuLieu==8" class="table table-striped table-bordered table-hover"
                                        style="font-size:12px; ">
                                        <thead>
                                            <tr>
                                                <th class="text-center">STT</th>
                                                <th class="text-center">Mã thí sinh</th>
                                                <th class="text-center">Tên thí sinh</th>
                                                <th>Trạng thái</th>
                                                <th >Mô tả</th>
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
                                                    <div v-if="tt.MaThiSinhTuDo">
                                                        {{tt.MaThiSinhTuDo}}
                                                    </div>
                                                    <div v-else="v-else">[Trống]</div>
                                                </td>
                                                <td>
                                                    <div v-if="tt.TenThiSinh">
                                                        {{tt.TenThiSinh}}
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
                                            <textarea class="language-json myTextArea"
                                                style="width:100%; margin:0 auto;height:50vh" :value="duLieuTextArea"
                                                id="myTextArea" cols="50" rows="10"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-if="type==1||type==2">
                            <textarea class="language-json myTextArea" style="width:100%; margin:0 auto;height:50vh"
                                id="myTextArea" :value="duLieuTextArea" cols="50" rows="10"></textarea>
                        </div>
                    </el-col>
                </el-row>
            </form>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="default" @click="closeinfo()">Đóng</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    import utils from '../../../utils';
    import rest_api from "../../../utils/rest_api";
    import {
        mapState
    } from 'vuex';
    export default {
        props: [
            'item', 'hien', 'thongtin', 'cateday', 'tabname', 'subId'
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
                console.log("newVal hien = " + newVal);
                if (newVal) {
                    console.log("watch chỗ hiện" + this.subId)
                    this.subIds = this.subId;
                    this.getTenBang(this.tabname);
                    console.log("Tên bảng:" + this.tabname);
                    console.log("Loại đẩy:" + this.cateday);
                    console.log("Thông tin:" + this.thongtin);
                    this.id = this.thongtin;
                    this.type = this.cateday;
                    this.ChiTietDuLieu = "";
                    this.getDetail();
                    console.log("lấy thông tin");
                } else {
                    this.hien_thi_noi_dung = false;
                }
            },
            tabname: function (newVal) {
                console.log(newVal);
                this.tenBang = newVal;
                this.id = this.thongtin;
                this.type = this.cateday;
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
                if (newVal == "DiemTongKetMon" || newVal == "DiemTongKetMonThiLai") {
                    this.tenBang = 7;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
                if (newVal == "TongKetHocSinh" || newVal == "TongKetHocSinh") {
                    this.tenBang = 8;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
                if (newVal == "DiemTruong") {
                    this.tenBang = 9;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
                if (newVal == "ThiSinhTuDo") {
                    this.tenBang = 10;
                    console.log("Tên Bảng Dữ Liệu:" + this.tenBang)
                }
            }
        },

        data() {
            return {
                id: "",
                type: '',
                ChiTietDuLieu: "",
                tenBang: "",
                duLieuTextArea: "",
                subIds: "",
                hien_thi_noi_dung: false,
            }
        },
        mounted: function () {},

        methods: {
            getTenBang(e) {
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
                if (this.type == 3) {
                    params.subId = this.subIds
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get(
                    "/csdlgd-report-api/history-syncdata/school/detail-response",
                    params,
                    data => {
                        console.log("Dữ liệu lấy trả về:" + JSON.stringify(data))
                        if (data.data.rc == 0) {
                            this.ChiTietDuLieu = data.data.item.detail;
                            this.ChiTietDuLieu = JSON.stringify(this.ChiTietDuLieu);
                            var obj = JSON.parse(JSON.parse(this.ChiTietDuLieu));
                            var pretty = JSON.stringify(obj, undefined, 2);
                            console.log("dữ liệu trả về:" + pretty);
                            this.duLieuTextArea = pretty;
                            console.log('loaiDuLieu');
                            console.log(this.loaiDuLieu);
                            
                            if (this.loaiDuLieu == 8) {
                                console.log('type = 8');
                                
                                if (this.type == 3 || this.type == 4) {
                                    console.log('case 1');
                                    
                                    this.ChiTietDuLieu = JSON.parse(this.ChiTietDuLieu);
                                }
                                console.log('ChiTietDuLieu');
                                console.log(this.ChiTietDuLieu);
                                
                                
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
                            this.hien_thi_noi_dung = true;
                            loading.close();
                        } else {
                            loading.close();
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

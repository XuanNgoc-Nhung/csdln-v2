<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6">
                <h3 class=" text-uppercase">CẤU HÌNH DỮ LIỆU NĂM HỌC CŨ</h3>
            </div>
            <div class="col-sm-6 pull-right">
                <button class="btn btn-info pull-right" @click.prevent="xemHuongDan()" style="margin-top:15px;">Hướng dẫn</button>
                <HuongDan :show="huong_dan" @close="huong_dan=false"></HuongDan>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label class="pull-right lbl_field">Cấp học:</label>
                    </div>
                    <div class="col-md-6">
                        <select @change="onCapHocChange" v-model="caphoc" title="Chọn cấp học" class="form-control"
                                style="width:100%">
                            <option value="">Chọn cấp học</option>
                            <option v-for="ch in ds_cap_hoc" :value="ch.id">{{ch.name}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label class="pull-right lbl_field">Trạng thái:</label>
                    </div>
                    <div class="col-md-6">
                        <select v-model="trang_thai" class="form-control" style="width:100%">
                            <option value=''>Tất cả</option>
                            <option value='1'>Đang hoạt động</option>
                            <option value='0'>Ngừng hoạt động</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row_tp">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                        <label class="pull-right lbl_field">Đơn vị:</label>
                    </div>
                    <div class="col-md-6">
                        <select @change="onDonviChange" v-model="ma_don_vi" class="form-control" style="width:100%">
                            <option v-for="dv in ds_don_vi" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-4">
                        <label class="pull-right lbl_field">Trường học:</label>
                    </div>
                    <div class="col-md-6">
                        <select v-model="ma_truong_hoc" class="form-control" style="width:100%">
                            <option value="">Chọn trường học</option>
                            <option v-for="tr in ds_truong_hoc" :value="tr.maTruongHoc">{{tr.tenTruongHoc}}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="row row_tp">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-success" @click.prevent="onBtnSearchClick"><i class="fa fa-search"></i>Tìm
                            kiếm
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 20px">

            <div class="col-lg-12">

                <div class="panel panel-default">

                    <div class="panel-body">

                        <div class="row">
                            <div class="col-sm-12">
                                <label>Danh sách phân quyền đồng bộ dữ liệu cũ</label>
                                <button class="btn btn-success pull-right" v-on:click.prevent="showCreatSyncData">
                                    <i class="fa fa-plus" aria-hidden="true"></i> Thêm mới
                                </button>
                            </div>
                        </div>
                        <hr style="margin: 10px 0 0;"/>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                        <tr>
                                            <th>STT</th>
                                            <th>Trường học</th>
                                            <th>Từ năm học</th>
                                            <th>Đến năm học</th>
                                            <th>Ngày cập nhật</th>
                                            <th>Trạng thái</th>
                                            <th>Thao tác</th>
                                        </tr>
                                        </thead>
                                        <tbody v-if="ds_yeu_cau.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có dữ liệu phù hợp</td>
                                        </tr>
                                        </tbody>
                                        <tbody>
                                        <tr v-for="(ds, index) in ds_yeu_cau">
                                            <td>{{index+1}}</td>
                                            <td>{{ds.tenTruongHoc}}</td>
                                            <td>{{ds.tuNamHoc}}-{{ds.tuNamHoc+1}}</td>
                                            <td>{{ds.toiNamHoc}}-{{ds.toiNamHoc+1}}</td>
                                            <td>{{ds.ngayCapNhat}}</td>
                                            <td>
                                                {{parseInt(ds.trangThai)=== 1 ? 'Đang hoạt động' : 'Ngưng hoạt động'}}
                                            </td>
                                            <td class="text-center">
                                                <a title="Chỉnh sửa" v-on:click="showUpdate(ds)"><i
                                                    class="far fa-edit"></i></a>
                                                <a v-if="ds.trangThai==1" title="Thay đổi trạng thái"
                                                   v-on:click="updateStatus(ds)"><i class="fas fa-lock-open"></i></a>
                                                <a v-if="ds.trangThai==0" title="Thay đổi trạng thái"
                                                   v-on:click="updateStatus(ds)"><i class="fas fa-lock"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <Page :total_rows="ds_yeu_cau.length"></Page>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <TaoYeuCauDongBoDuLieuCu :show="show_create" @close="show_create=false" @success="onUpdatedData($event)" :dangnhap="user"></TaoYeuCauDongBoDuLieuCu>
        <SuaYeuCauDongBoDuLieuCu :show="show_update" :item="dataEditDuLieu"
                                 @close="show_update=false"
                                 @success="onUpdatedData($event)"></SuaYeuCauDongBoDuLieuCu>
    </div>

</template>

<script>

    import dialog from '../../../utils/dialog';
    import rest_api from '../../../utils/rest_api';
    import encode_util from '../../../utils/encode_util';
    import array_util from '../../../utils/array_utils';
    import constant from '../../../utils/constant';
    import {mapMutations, mapState} from 'vuex';
    import TaoYeuCauDongBoDuLieuCu from './TaoYeuCauDongBoDuLieuCu';
    import SuaYeuCauDongBoDuLieuCu from './SuaYeuCauDongBoDuLieuCu';
    import Page from '../../ui/PagingCustom';
    import HuongDan from '../../huongdan/PhanQuyenDuLieuCu'
    import api from './../../api';
    import utils from '../../../utils'

    export default {
        props: ['info'],
        watch: {
            info: function (newVal) {
                console.log("thông tin đăng nhập danh sách:");
                this.thong_tin = newVal;
            }
        },
        components: {
            "TaoYeuCauDongBoDuLieuCu": TaoYeuCauDongBoDuLieuCu,
            "SuaYeuCauDongBoDuLieuCu": SuaYeuCauDongBoDuLieuCu,
            "Page": Page,
            "HuongDan": HuongDan,
        },

        computed: {
            ...mapState([
                'ds_don_vi',
                'common_info',
                'ds_truong_hoc',
                'flag_reload'
            ])
        },

        data() {

            return {
                thong_tin: '',
                show_create: false,
                huong_dan: false,
                show_update: false,
                ma_don_vi: "",
                ma_truong_hoc: "",
                caphoc: "",
                trang_thai: '',
                ds_cap_hoc: [],
                ds_yeu_cau: [],
                start: 0,
                limit: 25,
                total_rows: 0,
                dataEditDuLieu: {},
                user:{}
            }
        },

        mounted() {
            this.thongtin = JSON.parse(this.info);
            console.log("đăng nhập nè: " + JSON.stringify(this.thongtin));
            this.ma_don_vi = JSON.parse(this.thongtin.ma_don_vi);
            console.log("đơn vị:" + JSON.stringify(this.ma_don_vi));

            this.ds_cap_hoc = constant.LIST_CAP_HOC;
            let commonData = encode_util.decryptCommonDatas();
            this.setCommonInfo(commonData);
            this.getDsDonVi();
            this.getData();
        },

        methods: {

            xemHuongDan(){
                console.log("xem hướng dẫn")
                this.huong_dan=true;
            },
            ...mapMutations([
                'setCommonInfo',
                'setDsDonVi',
                'setDsTruongHoc',
                'setAllSchool',
                'clearDsTruongHoc']
            ),

            getUrl() {
                return "/forward-api";
            },
            updateStatus(e) {
                console.log("thay đổi trạng thái của:" + JSON.stringify(e));

                let url = "thay-doi-trang-thai-phan-quyen-du-lieu-cu";
                let params = {
                    "id": e.id,
                    "maTruongHoc": e.maTruongHoc,
                    "tuNamHoc": e.tuNamHoc,
                    "toiNamHoc": e.toiNamHoc,
                };
                if (e.trangThai == 0) {
                    params.trangThai = 1;
                }
                if (e.trangThai == 1) {
                    params.trangThai = 0;
                }
                console.log("param gửi đi:" + JSON.stringify(params));
                utils.confirmDialog("Xác nhận thay đổi trạng thái", "Đồng ý", () => {
                    api.post(url, params, (response) => {
                        console.log("res thay đổi trạng thái trả về:" + JSON.stringify(response));
                        if (response.data.rc == 0) {
                            utils.showDialog("Thông báo", "Thay đổi trạng thái thành công", null, () => {
                                this.getData();
                            });
                        } else {
                            utils.showDialog("Thất bại", response.data.rd, null, () => {
                            });
                        }
                    });
                })
            },

            showValue() {
                console.log("value: " + this.value);
            },

            onCapHocChange() {
                if (this.caphoc === "") {
                    return;
                }
                this.ma_truong_hoc = "";
                this.getDsTruongHoc();
            },

            onDonviChange() {
                if (this.ma_don_vi === "") {
                    return;
                }
                this.ma_truong_hoc = "";
                this.getDsTruongHoc();
            },
            showUpdate(ds) {
                console.log("Chỉnh sửa phân quyền dữ liệu cũ" + JSON.stringify(ds));
                this.dataEditDuLieu = ds;
                this.show_update = true;

            },
            findIdDonvi() {
                if (this.ma_don_vi === "") {
                    return null;
                }
                for (let i = 0; i < this.ds_don_vi.length; i++) {
                    if (this.ds_don_vi[i].maDonVi === this.ma_don_vi) {
                        return {
                            key: this.ds_don_vi[i].loaiDonVi === constant.LOAI_DONVI_SO ? "idso" : "idphong",
                            value: this.ma_don_vi
                        }
                    }
                }
                return null;
            },

            getDsTruongHoc() {
                let params = {
                    "start": 0,
                    "limit": 10000,
                    "caphoc": this.caphoc,
                    "matinhthanh": this.thongtin.province,
                    "maquanhuyen": this.thongtin.district
                };
                let dv = this.findIdDonvi();
                if (dv !== null) {
                    params[dv.key] = dv.value;
                }
                rest_api.get("/internal-api/dmTruongHoc/filter", params, (data) => {
                    console.log("data trường học: " + JSON.stringify(data.data));
                    if (array_util.isArray(data.data.rows)) {
                        this.setDsTruongHoc(data.data.rows);
                    }
                });
            },
            getDsDonVi() {
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maTinhThanh": this.thongtin.province,
                    "maQuanHuyen": this.thongtin.district
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    // console.log("data: " + JSON.stringify(data.data));
                    if (array_util.isArray(data.data.rows)) {
                        this.setDsDonVi(data.data.rows);
                    }
                });
            },

            getData() {
                let params = {
                    "capHoc": this.caphoc,
                    // "maDonVi": this.ma_don_vi,
                    "maDonVi": this.ma_don_vi,
                    "start": this.start,
                    "limit": this.limit,
                    "maTruongHoc": this.ma_truong_hoc,
                    "trangThai": this.trang_thai,
                };
                console.log("params:" + params);
                rest_api.post("/csdlgd-admin/yeuCauDuLieuCu/search", params, (data) => {
                    console.log("data dl cũ: " + JSON.stringify(data));
                    if (array_util.isArray(data.data.tableData)) {
                        this.total_rows = data.data.totalRows;
                        array_util.clearArrays(this.ds_yeu_cau);
                        this.ds_yeu_cau = data.data.tableData;
                    }
                });
            },

            showCreatSyncData() {
                // if (this.ds_truong_hoc.length === 0) {
                //     showDialog("Thông báo", "Vui lòng chọn đơn vị hoặc cấp học để có danh sách trường học");
                //     return;
                // }
                console.log("thêm phân quyền dữ liệu cũ:");
                console.log("tt đn:"+ JSON.stringify(this.thongtin));
                this.user=this.thongtin;
                console.log("user"+JSON.stringify(this.user));
                this.show_create = true;
            },

            onBtnSearchClick() {
                this.getData();
            },

            onBlockClick() {
                dialog.confirmDialog("Bạn có muốn thay đổi trạng thái email này?", "Đồng ý", () => {
                });
            },
            onUpdatedData(e) {
                this.getData();
            }

        }

    }

</script>
<style scoped>

</style>

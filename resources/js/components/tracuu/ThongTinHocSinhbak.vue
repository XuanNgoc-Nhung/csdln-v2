<template>
    <div id="modal_import_file" ref="modal_import_file" class="modal fade">
        <div class="modal-dialog-fullscreen">
            <div class="modal-content-fullscreen">
                <div class="modal-header-fullscreen">
                    <h4>CHI TIẾT HỒ SƠ HỌC SINH</h4>
                </div>
                <div class="modal-body-fullscreen" style="padding-top:15px">
                    <div class="row" style="margin:0">
                        <div class="col-md-2">
                            <div class="thumbnail" style="text-align:center;">
                                <div v-if="info.avatar">
                                    <img :src="info.avatar" width="100%" alt="hình ảnh học sinh" />
                                </div>
                                <div v-else>
                                    <img src="https://www.drupal.org/files/issues/default-avatar.png" width="120px"
                                        height="150px;" alt="" />
                                </div>
                                <div>
                                    <p style="color:blue;padding-left:15px;">Mã định danh: <span>{{info.moetCode}}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Họ tên</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.hoTen">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Ngày sinh</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.ngaySinh">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Giới tính</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="getGioiTinh(info.gioiTinh)">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Trạng thái HS</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.tenTrangThai">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Dân tộc</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.maDanToc">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Tôn giáo</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.maTonGiao">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Mã học sinh</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="mhs">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Nơi sinh</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.noiSinh">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Thôn xóm</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.maTthonTmtru">
                                        </div>
                                    </div>
                                    <div class="row" style="">
                                        <div class="col-md-4 text-right">
                                            <label>Quê quán</label>
                                        </div>
                                        <div class="col-md-8">
                                            <!-- <input class="form-control" disabled :value="info.queQuan"> -->
                                            <textarea disabled rows="3" class="form-control"
                                                :value="info.queQuan"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Chỗ ở hiện nay</label>
                                        </div>
                                        <div class="col-md-8">
                                            <!-- <input class="form-control" disabled :value="info.dchiTmtru"> -->
                                            <textarea disabled rows="3" class="form-control"
                                                :value="info.dchiTmtru"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>T.phần gia đình</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.strTphanGdinh">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Nhóm máu</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.tenNhomMau">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>SĐT liên hệ</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.soDthoaiDdong">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Email</label>
                                        </div>
                                        <div class="col-md-8">
                                            <input class="form-control" disabled :value="info.email">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 text-right">
                                            <label>Đ/C thường trú</label>
                                        </div>
                                        <div class="col-md-8">
                                            <textarea disabled rows="3" class="form-control"
                                                :value="info.dchiThtru"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row" style="margin:0">
                        <div class="col-md-12">
                            <ul class="nav nav-tabs">
                                <li class="active">
                                    <a data-toggle="tab" href="#home"><b>I. Thông tin cá nhân</b></a>
                                </li>
                                <li>
                                    <a data-toggle="tab" href="#menu1"><b>II. Thông tin liên hệ, gia đình</b></a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div id="home" class="tab-pane fade in active" style="width:95%; margin:0 auto;">
                                    <div class="row" style="">
                                        <div class="col-md-4">
                                            <p><b>Khuyết tật </b><span>
                                                    <i v-if="info.khuyetTat" style="color:blue;padding-left:15px;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square" style="padding-left:15px"></i>
                                                </span></p>
                                            <p><b>Đối tượng chính sách: </b><span>{{info.maDtuongCsach}}
                                                </span></p>
                                            <p><b>Đối tượng ưu tiên: </b><span>{{info.strDtuongUuTien}}</span></p>
                                            <p><b>HS B.trú D.nuôi </b><span>
                                                    <i v-if="info.hocSinhBanTruDanNuoi" style="color:blue;padding-left:15px;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square" style="padding-left:15px"></i></span></p>
                                            <p><b>HS N.trú D.nuôi </b><span>
                                                    <i v-if="info.hocSinhNoiTruDanNuoi" style="color:blue;padding-left:15px;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square" style="padding-left:15px"></i></span></p>
                                            <p><b>HS bán trú </b><span>
                                                    <i v-if="info.hocSinhBanTru" style="color:blue;padding-left:15px;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square" style="padding-left:15px"></i>
                                                </span></p>
                                            <p><b>HS nội trú </b><span>
                                                <i v-if="info.hocSinhNoiTru" style="color:blue;padding-left:15px;"
                                                    class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square" style="padding-left:15px"></i></span></p>
                                            <p><b>HS PTDT bán trú </b>
                                                <i v-if="info.hocSinhPtdtBanTru" style="color:blue;padding-left:15px;"
                                                    class="fas fa-check-square"></i>
                                                <i v-else class="far fa-square" style="padding-left:15px"></i></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><b>CMTND/TCC: </b><span>{{info.soCmnd}}</span></p>
                                            <p><b>Ngày cấp: </b><span>{{info.ngayCapCmnd}}</span></p>
                                            <p><b>Nơi cấp: </b><span>{{info.noiCapCmnd}}</span></p>
                                            <p><b>Có mẹ dân tộc </b><span>
                                                    <i v-if="info.meDanToc" style="color:blue;padding-left:15px;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square" style="padding-left:15px"></i></span></p>
                                            <p><b>Có cha dân tộc </b><span>
                                                    <i v-if="info.chaDanToc" style="color:blue;padding-left:15px;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square" style="padding-left:15px"></i></span></p>
                                            <p><b>Học CTGD của Bộ </b><span>
                                                    <i v-if="info.hocCtgdCuaBo" style="color:blue;padding-left:15px;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square" style="padding-left:15px"></i></span></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><b>Đội viên </b><span>
                                                    <i v-if="info.doiVien" style="color:blue;padding-left:15px;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square" style="padding-left:15px"></i></span></p>
                                            <p><b>Ngày vào đội: </b><span>{{info.ngayVaoDoi}}</span></p>
                                            <p><b>Đoàn viên </b><span>
                                                    <i v-if="info.doanVien" style="color:blue;padding-left:15px;"
                                                        class="fas fa-check-square"></i>
                                                    <i v-else class="far fa-square" style="padding-left:15px"></i></span></p>
                                            <p><b>Ngày vào đoàn: </b><span>{{info.ngayVaoDoan}}</span></p>
                                        </div>
                                    </div>
                                </div>
                                <div id="menu1" class="tab-pane fade" style="width:95%; margin:0 auto;">
                                    <div class="row" style="">
                                        <div class="col-md-4">
                                            <p><b>Tên bố: </b><span>{{info.hoTenBo}}</span></p>
                                            <p><b>Nghề nghiệp bố: </b><span>{{info.ngheNghiepBo}}</span></p>
                                            <p><b>Năm sinh bố: </b><span>{{info.namSinhBo}}</span></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><b>Tên mẹ: </b><span>{{info.hoTenMe}}</span></p>
                                            <p><b>Nghề nghiệp mẹ: </b><span>{{info.ngheNghiepMe}}</span></p>
                                            <p><b>Năm sinh mẹ: </b><span>{{info.namSinhMe}}</span></p>
                                        </div>
                                        <div class="col-md-4">
                                            <p><b>Tên người Đ.đầu: </b><span>{{info.hoTenNguoiGiamHo}}</span></p>
                                            <p><b>Nghề nghiệp người
                                                    Đ.đầu: </b><span>{{info.ngheNghiepNguoiGiamHo}}</span></p>
                                            <p><b>Năm sinh người Đ.đầu: </b><span>{{info.ngaySinhNguoiGiamHo}}</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-fullscreen">
                    <button class="btn btn-info" style="margin:0 15px;" @click.prevent="getPDF(mhs)">Xuất PDF</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import moment from 'moment'
    import utils from '../../utils'
    import api from '../api';

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {
        props: [
            'item', 'show'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.reset();
                    $("#modal_import_file").modal();
                } else {
                    $("#modal_import_file").modal('hide');
                }
            },
        },

        data() {
            return {
                tendantoc: "",
                tentongiao: "",
                mhs: "",
                namHoc: "",
                info: {},
                linkPdf: ""
            }
        },
        mounted: function () {
            this.getDataStudent();
            console.log("mounted !!!!!");
            $(this.$refs.modal_import_file).on("hidden.bs.modal", this.close);
        },
        methods: {
            getGioiTinh(e) {
                if (e == 1) {
                    return "Nam";
                }
                if (e == 0) {
                    return "Nữ";
                }
            },
            getPDF(e) {
                let url = "xuat-bao-cao-pdf-thong-tin-hoc-sinh";
                let params = {
                    "maHocSinh": e,
                    "namHoc": this.namHoc,
                };
                api.post(url, params, (data) => {
                    if (data.data.rc == -1) {
                        this.linkPdf = data.data.file;
                        // window.location.replace(this.linkPdf,'_blank');
                        window.open(this.linkPdf, '_blank');
                    }
                });
            },
            layDanToc(ma) {
                let params = {
                    start: 0,
                    limit: 1,
                    ma: ma
                };
                rest_api.get("/internal-api/dmDanToc/filter", params, data => {
                    if (data.data.total == 1) {
                        if (array_util.isArray(data.data.rows)) {
                            this.tendantoc = data
                                .data
                                .rows[0]
                                .tenDanToc;
                        }
                    }
                });
            },
            layTonGiao(ma) {
                let params = {
                    start: 0,
                    limit: 1,
                    ma: ma
                };
                rest_api.get("/internal-api/dmTonGiao/filter", params, data => {
                    if (data.data.total == 1) {
                        if (array_util.isArray(data.data.rows)) {
                            this.tentongiao = data
                                .data
                                .rows[0]
                                .tenTonGiao;
                        }
                    }
                });
            },
            getDataStudent() {
                console.log("lấy thông tin của học sinh" + JSON.stringify(this.item));
                let params = {
                    "idHsTheoNam": this.item.idHsTheoNam,
                };
                rest_api.get("/csdlgd-admin/hocSinh", params, (data) => {
                    if (data.data != null) {
                        this.info = data.data;
                        if (this.info.maTonGiao) {
                            this.layTonGiao(this.info.maTonGiao);
                        }
                        if (this.info.maDanToc) {
                            this.layDanToc(this.info.maDanToc);
                        }
                        this.info.khuyetTat = Boolean(this.info.khuyetTat);
                        this.info.hocSinhBanTruDanNuoi = Boolean(this.info.hocSinhBanTruDanNuoi);
                        this.info.hocSinhNoiTruDanNuoi = Boolean(this.info.hocSinhNoiTruDanNuoi);
                        this.info.hocSinhBanTru = Boolean(this.info.hocSinhBanTru);
                        this.info.hocSinhNoiTru = Boolean(this.info.hocSinhNoiTru);
                        this.info.hocSinhPtdtBanTru = Boolean(this.info.hocSinhPtdtBanTru);
                        this.info.meDanToc = Boolean(this.info.meDanToc);
                        this.info.chaDanToc = Boolean(this.info.chaDanToc);
                        this.info.hocCtgdCuaBo = Boolean(this.info.hocCtgdCuaBo);
                        this.info.doiVien = Boolean(this.info.doiVien);
                        this.info.doanVien = Boolean(this.info.doanVien);
                        console.log("info student" + JSON.stringify(this.info))
                    } else {
                        utils.showDialog(
                            "Thông báo",
                            "Đã xảy ra lỗi trong quá trình lấy dữ liệu. Vui lòng thử lại.",
                            null,
                            () => {}
                        );
                    }
                });
            },
            reset() {
                this.capmot = "";
                this.ten_lydo = "";
            },
            close() {
                console.log("close modal");
                this.reset();
                this.$emit('close');
            }
        }

    }

</script>
<style scoped="scoped">
    @import "../../../../node_modules/css-custom.css";

    .text-right label {
        padding: 6px 0;
    }

    .nav-tabs>li.active>a {
        font-weight: bold;
        color: forestgreen;
        border-top: 4px solid forestgreen;
    }

    input[type=checkbox] {
        margin-left: 15px;
    }

    textarea {
        margin: 0px 0 6px 0 !important;
    }

</style>

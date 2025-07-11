<template>
    <div id="modal_thongtin_truonghoc" ref="modal_thongtin_truonghoc" class="modal fade">
        <div class="modal-dialog" style="width: 100%; margin:0 !important">
            <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title text-uppercase">Thông tin trường học</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div class="row">
                                <div class="col-sm-3">
                                    <label>Tỉnh thành</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.tenTinhThanh"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Quận huyện</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.tenQuanHuyen"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Phường xã</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.tenPhuongXa"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Tổ thôn</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.maTthon"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Đơn vị quản lý</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.tenDonVi"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Mã trường học</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.maTruongHoc"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Tên trường học</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.tenTruongHoc"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Cấp học</label>
                                    <input class="form-control" disabled v-model="tenCapHoc"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Loại hình đào tạo</label>
                                    <select class="form-control" disabled v-model="thongTinTruong.loaiHinhDaoTao">
                                        <option v-for="lh in ds_loai_hinh_dao_tao" :value="lh.value" :key="lh.value">{{lh.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>Loại hình trường</label>
                                    <select class="form-control" disabled v-model="thongTinTruong.loaiHinhTruong">
                                        <option v-for="lh in ds_loai_hinh_truong" :value="lh.value" :key="lh.value">{{lh.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>Ngày thành lập</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.ngayThanhLap"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Chuẩn quốc gia</label>
                                    <select class="form-control" disabled v-model="thongTinTruong.chuanQuocGia">
                                        <option v-for="lh in ds_chuan_quoc_gia" :value="lh.value" :key="lh.value">{{lh.name}}</option>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <label>Website</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.website"/>
                                </div>
                                <!-- <div class="col-sm-3">
                                    <label>Số điện thoại</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.sdt"/>
                                </div> -->
                                <div class="col-sm-3">
                                    <label>Tên hiệu trưởng</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.tenHieuTruong"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Email</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.email"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Fax</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.fax"/>
                                </div>
                                <!-- <div class="col-sm-3">
                                    <label>SĐT hiệu trưởng</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.sdtHieuTruong"/>
                                </div> -->
                                <div class="col-sm-3">
                                    <label>Địa chỉ</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.diaChi"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Trạng thái</label>
                                    <select class="form-control" disabled v-model="thongTinTruong.trangThai">
                                        <option value="0">Ngưng hoạt động</option>
                                        <option value="1">Đang hoạt động</option>
                                        <option value="-1">Đã xóa</option>
                                    </select>
                                </div>
                                <!-- <div class="col-sm-3">
                                    <label>Năm đạt chuẩn QG mức 1:</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.datChuanQgMuc1"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Năm đạt chuẩn QG mức 2:</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.datChuanQgMuc2"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Năm đạt KĐCL cấp độ 1:</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.datKdclCapDo1"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Năm đạt KĐCL cấp độ 2:</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.datKdclCapDo2"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Năm đạt KĐCL cấp độ 3:</label>
                                    <input class="form-control" disabled v-model="thongTinTruong.datKdclCapDo3"/>
                                </div>
                                <div class="col-sm-6">
                                      <label>Thông tin thêm:</label>
                                    <div style="width:100%">
                                        <div class="democheck">
                                            <input disabled v-model="thongTinTruong.vungKhoKhan" type="checkbox" />
                                            <span>Vùng khó khăn</span>
                                        </div>
                                        <div class="democheck">
                                            <input disabled v-model="thongTinTruong.vungBienGioi" type="checkbox" />
                                            <span>Vùng biên giới</span>
                                        </div>
                                        <div class="democheck">
                                            <input disabled v-model="thongTinTruong.chiBoDang" type="checkbox" />
                                            <span>Chi bộ đảng</span>
                                        </div>
                                    </div>
                                </div> -->
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                        </button>
                    </div>
            </div>
        </div>
    </div>
</template>
<script>
    import constant from '../../../utils/constant';
    export default {
        props: ['item'],
        components: {
        },
        watch: {},
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                thongTinTruong:{},
                tenCapHoc:"",
                ds_loai_hinh_dao_tao: [],
                ds_loai_hinh_truong: [],
                ds_chuan_quoc_gia: [],
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            $("#modal_thongtin_truonghoc").modal();
            $(this.$refs.modal_thongtin_truonghoc).on("hidden.bs.modal", this.close);
            console.log(JSON.stringify(this.item));
            this.thongTinTruong = this.item;
            this.getCapHoc(this.thongTinTruong.capHoc);
        },
        methods: {
            
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_loai_hinh_dao_tao_sme"];
                if (tmp) {
                    this.ds_loai_hinh_dao_tao = JSON.parse(localStorage["danh_sach_loai_hinh_dao_tao_sme"]);
                    this.ds_loai_hinh_truong = JSON.parse(localStorage["danh_sach_loai_hinh_truong_sme"]);
                    this.ds_chuan_quoc_gia = JSON.parse(localStorage["danh_sach_chuan_quoc_gia_sme"]);
                }
            },
            getCapHoc(loai){
                var res = parseInt(loai);
                switch(res) {
                    case 1:
                        res = 'Tiểu học';
                        break;
                    case 2:
                        res = 'THCS';
                        break;
                    case 3:
                        res = 'THPT';
                        break;
                    case 4:
                        res = 'Nhà trẻ';
                        break;
                    case 5:
                        res = 'Mẫu giáo';
                        break;
                    case 12:
                        res = 'PTCS';
                        break;
                    case 145:
                        res = 'MN-TH';
                        break;
                    case 12345:
                        res = 'MN-PT';
                        break;
                    case 1245:
                        res = 'MN-PTCS';
                        break;
                    case 23:
                        res = 'Trung học';
                        break;
                    case 123:
                        res = 'Phổ thông';
                        break;
                    case 45:
                        res = 'Mầm non';
                        break;
                    case 6:
                        res = 'GDTX';
                        break;
                    default:
                        res = loai;
                }
                this.tenCapHoc = res;
                return res;
            },
            close(){
                console.log("Đóng thông tin trường học");
                this.$emit('close')
            }
        }
    }
</script>
<style scoped="scoped">
    .col-sm-3,.col-sm-6 {
        padding-top: 7px;
    }
    .democheck {
        width: 33.33%;
        float: left;
    }
</style>

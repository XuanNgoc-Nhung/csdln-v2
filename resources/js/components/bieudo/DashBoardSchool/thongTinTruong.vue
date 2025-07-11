<template>
    <div>
        <div class="card-bieu-do" style="margin-top:25px">
            <el-row :gutter="24">
                <el-col :span="12">
                    <h5> <i class="fas fa-school"></i> Thông tin trường</h5>
                </el-col>
                <el-col :span="12" class="text-right">
                    <div class="inline">
                        <h5> <i class="fas fa-clock"></i> Thời gian cập nhật:</h5> <span
                            style="font-weight: 600;font-size: 16px;padding-left:5px">
                            {{thongTinTruong.ngayCapNhat}}</span>
                    </div>
                </el-col>
                <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0"></el-col>
                <el-col :span="8">
                    <span>Tên trường</span>
                    <input placeholder=" " class="form-control" disabled :value="thongTinTruong.tenTruongHoc">
                </el-col>
                <el-col :span="8">
                    <span>Mã trường</span>
                    <input placeholder=" " class="form-control" disabled :value="thongTinTruong.maTruongHoc">
                </el-col>
                <el-col :span="8">
                    <span>Cấp học</span>
                    <input placeholder=" " class="form-control" disabled :value="getTenCapHoc(thongTinTruong.capHoc)">
                </el-col>
                <el-col :span="8">
                    <span>Đơn vị quản lý</span>
                    <input placeholder=" " class="form-control" disabled :value="thongTinTruong.donViQuanLy">
                </el-col>
                <el-col :span="8">
                    <span>Loại hình đào tạo</span>
                    <input placeholder=" " class="form-control" disabled
                        :value="getTenLoaiHinhDaoTao(thongTinTruong.loaiHinhDaoTao)">
                </el-col>
                <el-col :span="8">
                    <span>Loại hình trường</span>
                    <input placeholder=" " class="form-control" disabled
                        :value="getTenLoaiHinhTruong(thongTinTruong.loaiHinhTruong)">
                </el-col>
                <el-col :span="8">
                    <span>Tên Quận/Huyện</span>
                    <input placeholder=" " class="form-control" disabled :value="thongTinTruong.tenQuanHuyen">
                </el-col>
                <el-col :span="8">
                    <span>Tên Phường/Xã</span>
                    <input placeholder=" " class="form-control" disabled :value="thongTinTruong.tenPhuongXa">
                </el-col>
                <el-col :span="8">
                    <span>Địa chỉ</span>
                    <input placeholder=" " class="form-control" disabled :value="thongTinTruong.diaChi">
                </el-col>
            </el-row>
            <el-row>
                <el-collapse accordion>
                    <el-collapse-item name="1">
                        <template slot="title">
                            <el-col :span="24" class="text-right">
                                <!-- Chi tiết<i class="header-icon el-icon-info"></i> -->
                                <el-button plain size="mini" style="font-size:14px; padding-left:10px;" type="success">Xem
                                    thêm</el-button>
                            </el-col>
                        </template>
                        <div>
                            <el-col :span="8">
                                <span>Số điện thoại nhà trường</span>
                                <input placeholder=" " class="form-control" disabled :value="thongTinTruong.dienThoai">
                            </el-col>
                            <el-col :span="8">
                                <span>Fax</span>
                                <input placeholder=" " class="form-control" disabled :value="thongTinTruong.fax">
                            </el-col>
                            <el-col :span="8">
                                <span>Email nhà trường</span>
                                <input placeholder=" " class="form-control" disabled :value="thongTinTruong.email">
                            </el-col>
                            <el-col :span="8">
                                <span>Website</span>
                                <input placeholder=" " class="form-control" disabled :value="thongTinTruong.website">
                            </el-col>
<!--                            <el-col :span="8">-->
<!--                                <span>Hiệu trưởng</span>-->
<!--                                <input placeholder=" " class="form-control" disabled :value="thongTinTruong.hieuTruong">-->
<!--                            </el-col>-->
                            <el-col :span="8">
                                <span>SĐT hiệu trưởng</span>
                                <input placeholder=" " class="form-control" disabled
                                    :value="thongTinTruong.sdtHieuTruong">
                            </el-col>
                            <el-col :span="8">
                                <span>Chuẩn quốc gia</span>
                                <input placeholder=" " class="form-control" disabled
                                    :value="getChuanQuocGia(thongTinTruong.chuanQuocGia)">
                            </el-col>
                            <el-col :span="8">
                                <span>Khu vực</span>
                                <input placeholder=" " class="form-control" disabled
                                    :value="getKhuVuc(thongTinTruong.khuVuc)">
                            </el-col>
                            <el-col :span="8">
                                <span>Chính sách vùng</span>
                                <input placeholder=" " class="form-control" disabled
                                       :value="thongTinTruong.chinhSachVung">
                            </el-col>
                            <el-col :span="8">
                                <span>Số điện thoại hiệu trưởng</span>
                                <input placeholder=" " class="form-control" disabled
                                       :value="thongTinTruong.dienThoaiHieuTruong">
                            </el-col>
                            <el-col :span="8">
                                <span>Khu vực</span>
                                <input placeholder=" " class="form-control" disabled
                                       :value="thongTinTruong.maKhuVuc">
                            </el-col>
                            <el-col :span="8">
                                <span>Số điểm trường</span>
                                <input placeholder=" " class="form-control" disabled
                                       :value="thongTinTruong.soDiemTruong">
                            </el-col>
                            <el-col :span="8">
                                <span>Mã trung tâm</span>
                                <input placeholder=" " class="form-control" disabled
                                       :value="thongTinTruong.maTrungTam">
                            </el-col>
                            <el-col :span="8">
                                <span>Kinh tuyến</span>
                                <input placeholder=" " class="form-control" disabled
                                       :value="thongTinTruong.kinhTuyen">
                            </el-col>
                            <el-col :span="8">
                                <span>Vĩ tuyến</span>
                                <input placeholder=" " class="form-control" disabled
                                       :value="thongTinTruong.viTuyen">
                            </el-col>
                            <el-col :span="8">
                                <span>Vị trí bản đồ</span>
                                <input placeholder=" " class="form-control" disabled
                                       :value="thongTinTruong.viTriBanDo">
                            </el-col>
                            <el-col :span="8"><span>Chương trình giáo dục vệ sinh đôi tay</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.CtGdvsDoiTay"></el-col>
                            <el-col :span="8"><span>Dạy nghề phổ thông</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.dayNghePhoThong"></el-col>
                            <el-col :span="8"><span>Diện tích</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.dienTich"></el-col>
                            <el-col :span="8"><span>Email hiệu trưởng</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.emailHieuTruong"></el-col>
                            <el-col :span="8"><span>Tên hiệu trưởng</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.hieuTruong"></el-col>
                            <el-col :span="8"><span>Mã trung tâm</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.maLoaiTrungTam"></el-col>
                            <el-col :span="8"><span>Mã vùng khó khăn</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.maVungKhoKhan"></el-col>
                            <el-col :span="8"><span>Có kế hoạch phòng chống thiên tai dịch bệnh</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.khPcThienTaiDichBenh"></el-col>
                            <el-col :span="8"><span>Có học chương trình song ngữ</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.isCoChuongTrinhSongNgu"></el-col>
                            <el-col :span="8"><span>Tổng số cán bộ</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.tongSoCanBo"></el-col>
                            <el-col :span="8"><span>Tổng csố lớp học</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.tongSoLopHoc"></el-col>
                            <el-col :span="8"><span>Tổng số học sinh</span><input placeholder=" " class="form-control" disabled :value="thongTinTruong.tongSoHocSinh"></el-col>


                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.hoc2BuoiNgay)"></el-checkbox> <span> Học 2 buổi/ngày</span></el-col>
                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.hocSinhBanTru)"></el-checkbox> <span> Có học sinh bán trú</span></el-col>
                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.hocSinhNoiTru)"></el-checkbox> <span> Có học sinh nội trú</span></el-col>
                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.hocSinhKhuyetTat)"></el-checkbox> <span> Có học sinh khuyết tật</span></el-col>
                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.chuongTrinhGiaoDucCoBan)"></el-checkbox> <span> Chương trình giáo dục cơ bản</span></el-col>
                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.coLopKhongChuyen)"></el-checkbox> <span> Có lớp không chuyên</span></el-col>
                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.congTrinhVeSinh)"></el-checkbox> <span> Có công trình vệ sinh</span></el-col>
                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.datChatLuongToiThieu)"></el-checkbox> <span> Đạt chất lượng tối thiểu</span></el-col>
                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.kyNangSongGdxh)"></el-checkbox> <span> Kỹ năng sống giáo dục xã hội</span></el-col>
                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.truongQuocTe)"></el-checkbox> <span> Trường quốc tế</span></el-col>
                            <el-col :span="8"><el-checkbox :value="getValue(thongTinTruong.tuVanHuongNghiep)"></el-checkbox> <span> Tư vấn hướng nghiệp</span></el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.chiBoDang)"></el-checkbox> <span> Có chi bộ đảng</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.hsNoiTru)"></el-checkbox> <span> Có học
                                    sinh nội
                                    trú</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.vungDbKhoKhan)"></el-checkbox> <span> Vùng
                                    đặc biệt
                                    khó khăn</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.sdMayTinh)"></el-checkbox> <span> Có sử
                                    dụng máy
                                    tính phục vụ dạy học</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.nuocUong)"></el-checkbox> <span> Có nước
                                    uống</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.cshtChoHskt)"></el-checkbox> <span> Có CS
                                    hạ tầng,
                                    TL học tập, MT học tập phù hợp và tiếp cận với HS khuyết tật</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.ktInternetDayHoc)"></el-checkbox> <span> Có
                                    khai
                                    thác internet cho dạy học</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.coCtVeSinhTheoGt)"></el-checkbox> <span> Có
                                    công
                                    trình vệ sinh riêng rẽ cho từng giới tính</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.ctacTuVanHd)"></el-checkbox> <span> Có bộ
                                    phận làm
                                    công tác tư vấn học đường</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.coDien)"></el-checkbox> <span> Có điện
                                    (điện
                                    lưới)</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.choRuaTay)"></el-checkbox> <span> Có chỗ
                                    rửa tay
                                    thuận tiện(bao gồm nước và xà phòng)</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.pcThienTaiBdkh)"></el-checkbox> <span> Có
                                    KH G.Dục
                                    phòng, chống thiên tai và Ứng phó biến đổi khí hậu</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.nuocSach)"></el-checkbox> <span> Có nguồn
                                    nước
                                    sạch</span>
                            </el-col>
                            <el-col :span="8">
                                <el-checkbox :value="getValue(thongTinTruong.pbienKnsSkss)"></el-checkbox> <span>Phổ biến cho CMHS về các CTGD phòng, chống HIV trên nền tảng kỹ năng sống và giáo dục sức khỏe sinh sản.</span>
                            </el-col>
                        </div>
                    </el-collapse-item>
                </el-collapse>
            </el-row>
        </div>
        <div class="card-bieu-do" v-if="list_diem_truong.length>0" style="margin-top:25px">
            <el-row :gutter="24">
                <el-col :span="24">
                    <h5> <i class="fas fa-school"></i> Danh sách điểm trường</h5>
                </el-col>
                <el-col :span="24" style="border-bottom:1px solid #ddd;padding:0;padding-left:5px;"></el-col>
                <el-col :span="24">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="text-center">
                                        <p>STT</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Mã điểm trường</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Tên điểm trường</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Địa chỉ</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Khoảng cách tới trường chính</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Diện tích</p>
                                    </th>
                                    <th class="text-center">
                                        <p>Số điện thoại</p>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(item,index) in list_diem_truong" :key="index">
                                    <td class="text-center">
                                        <p>{{index+1}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.maDiemTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.tenDiemTruong}}</p>
                                    </td>
                                    <td>
                                        <p>{{item.diaChi}}</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.khoangCach}} km</p>
                                    </td>
                                    <td class="text-center">
                                        <p>{{item.dienTich}} m<sup>2</sup></p>
                                    </td>
                                    <td class="text-right">
                                        <p>{{item.dienThoai}}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </el-col>
            </el-row>
        </div>
    </div>
</template>
<script>
    import rest_api from '../../../utils/rest_api';
    import ElementUI from 'element-ui';
    import {
        Loading
    } from 'element-ui';
    Vue.use(ElementUI);
    export default {
        props: ['item','nam_hoc'],
        components: {},
        data() {
            return {
                demo: true,
                thongTinTruong: {},
                list_diem_truong: [],
                cap_hoc: [{
                        "value": "5",
                        "label": "Mẫu giáo"
                    },
                    {
                        "value": "6",
                        "label": "GDTX Huyện"
                    },
                    {
                        "value": "12",
                        "label": "PTCS"
                    },
                    {
                        "value": "1",
                        "label": "Tiểu học"
                    },
                    {
                        "value": "1245",
                        "label": "MN - PTCS"
                    },
                    {
                        "value": "5",
                        "label": "Lớp mẫu giáo độc lập"
                    },
                    {
                        "value": "12345",
                        "label": "MN - PT"
                    },
                    {
                        "value": "45",
                        "label": "Nhóm trẻ, lớp mẫu giáo độc lập"
                    },
                    {
                        "value": "2",
                        "label": "THCS"
                    },
                    {
                        "value": "4",
                        "label": "Nhóm nhà trẻ độc lập"
                    },
                    {
                        "value": "6",
                        "label": "GDTX Tỉnh"
                    },
                    {
                        "value": "45",
                        "label": "Mầm non"
                    },
                    {
                        "value": "3",
                        "label": "THPT"
                    },
                    {
                        "value": "23",
                        "label": "Trung học"
                    },
                    {
                        "value": "123",
                        "label": "Phổ thông"
                    },
                    {
                        "value": "6",
                        "label": "Lớp nhô"
                    },
                    {
                        "value": "4",
                        "label": "Nhà trẻ"
                    },
                    {
                        "value": "145",
                        "label": "MN - TH"
                    },
                    {
                        "value": "6",
                        "label": "TTKTTHHN"
                    }
                ],
                loai_hinh_truong: [{
                    "name": "Trẻ em thiệt thòi",
                    "label": "Trẻ em thiệt thòi",
                    "value": "9"
                }, {
                    "name": "Mầm non",
                    "label": "Mầm non",
                    "value": "11"
                }, {
                    "name": "TT GDNN - GDTX (Sát nhập theo TTLT số 39/2015)",
                    "label": "TT GDNN - GDTX (Sát nhập theo TTLT số 39/2015)",
                    "value": "13"
                }, {
                    "name": "TT GDTX - DN - HN (Các tên gọi khác)",
                    "label": "TT GDTX - DN - HN (Các tên gọi khác)",
                    "value": "14"
                }, {
                    "name": "Dân tộc bán trú",
                    "label": "Dân tộc bán trú",
                    "value": "7"
                }, {
                    "name": "Trẻ em khuyết tật",
                    "label": "Trẻ em khuyết tật",
                    "value": "3"
                }, {
                    "name": "Khuyết tật",
                    "label": "Khuyết tật",
                    "value": "18"
                }, {
                    "name": "Trường phổ thông",
                    "label": "Trường phổ thông",
                    "value": "1"
                }, {
                    "name": "Trường THPT kỹ thuật",
                    "label": "Trường THPT kỹ thuật",
                    "value": "8"
                }, {
                    "name": "Trường chuyên",
                    "label": "Trường chuyên",
                    "value": "6"
                }, {
                    "name": "TT GDTX",
                    "label": "TT GDTX",
                    "value": "12"
                }, {
                    "name": "Năng khiếu nghệ thuật",
                    "label": "Năng khiếu nghệ thuật",
                    "value": "4"
                }, {
                    "name": "Dân tộc nội trú",
                    "label": "Dân tộc nội trú",
                    "value": "2"
                }, {
                    "name": "Năng khiếu thể dục thể thao",
                    "label": "Năng khiếu thể dục thể thao",
                    "value": "5"
                }],
                chuan_quoc_gia: [{
                    "name": "Mức chuẩn chất lượng tối thiểu",
                    "label": "Mức chuẩn chất lượng tối thiểu",
                    "value": "3"
                }, {
                    "name": "Đạt chuẩn mức 2",
                    "label": "Đạt chuẩn mức 2",
                    "value": "2"
                }, {
                    "name": "Đạt chuẩn mức 1",
                    "label": "Đạt chuẩn mức 1",
                    "value": "1"
                }],
                loai_hinh_dao_tao: [{
                    "name": "Tư thục",
                    "label": "Tư thục",
                    "value": "2"
                }, {
                    "name": "GDTX",
                    "label": "GDTX",
                    "value": "3"
                }, {
                    "name": "Ngoài công lập",
                    "label": "Ngoài công lập",
                    "value": "2"
                }, {
                    "name": "Dân lập",
                    "label": "Dân lập",
                    "value": "5"
                }, {
                    "name": "Công lập",
                    "label": "Công lập",
                    "value": "1"
                }],
                khu_vuc: [{
                    "name": "Biên giới - Hải đảo",
                    "label": "Biên giới - Hải đảo",
                    "value": "01"
                }, {
                    "name": "Miền núi - vùng sâu",
                    "label": "Miền núi - vùng sâu",
                    "value": "04"
                }, {
                    "name": "Đồng bằng",
                    "label": "Đồng bằng",
                    "value": "03"
                }, {
                    "name": "Đô thị",
                    "label": "Đô thị",
                    "value": "02"
                }]
            }
        },
        watch: {
            item: function (newVal) {
                if (newVal) {
                    this.thongTinTruong = newVal;
                    this.getDiemTruong();
                }
            },
        },
        mounted: function () {
            this.thongTinTruong = this.item
        },
        methods: {
            getValue(e) {
                if (e == '1' || e == true) {
                    return true
                } else {
                    return false
                }
            },
            getKhuVuc(e) {
                let res = "";
                for (let i = 0; i < this.khu_vuc.length; i++) {
                    if (this.khu_vuc[i].value == e) {
                        res = this.khu_vuc[i].name;
                    }
                }
                return res;
            },
            getChuanQuocGia(e) {
                let res = "";
                for (let i = 0; i < this.chuan_quoc_gia.length; i++) {
                    if (e == this.chuan_quoc_gia[i].value) {
                        res = this.chuan_quoc_gia[i].name;
                    }
                }
                return res;
            },
            getTenLoaiHinhDaoTao(e) {
                let res = "";
                for (let i = 0; i < this.loai_hinh_dao_tao.length; i++) {
                    if (e == this.loai_hinh_dao_tao[i].value) {
                        res = this.loai_hinh_dao_tao[i].name;
                    }
                }
                return res;
            },
            getTenLoaiHinhTruong(e) {
                let res = "";
                for (let i = 0; i < this.loai_hinh_truong.length; i++) {
                    if (e == this.loai_hinh_truong[i].value) {
                        res = this.loai_hinh_truong[i].name;
                    }
                }
                return res;
            },
            getTenCapHoc(e) {
                let res = "";
                for (let i = 0; i < this.cap_hoc.length; i++) {
                    if (this.cap_hoc[i].value == e) {
                        res = this.cap_hoc[i].label;
                    }
                }
                return res;
            },
            getDiemTruong() {
                this.list_diem_truong = [];
                let params = {
                    "namHoc": this.nam_hoc,
                    "maTruongs": [this.thongTinTruong.maTruongHoc]
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-report-api/dasboard/truong/diemtruong", params, (data) => {
                    loading.close();
                    console.log(data.data);
                    if (data.data.rc == 0) {
                        this.list_diem_truong = data.data.item
                    }
                });
            }
        }
    }

</script>
<style scoped="scoped">
    h3,
    h5 {
        margin: 0;
    }

    .card-bieu-do {
        margin: 15px 0;
        background: white;
        border-radius: 10px;
    }

    .inline {
        display: inline-flex;
    }

    .el-input-group__prepend {
        color: #303133 !important;
    }

    .nameInput {
        color: black
    }

    .el-input-group__prepend {
        width: 37% !important;
    }

    .el-input.is-disabled .el-input__inner {
        color: #303133 !important;
    }

    .form-control {
        font-size: 14px;
    }

</style>

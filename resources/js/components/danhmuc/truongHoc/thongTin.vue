<template>
    <div v-loading="loadingFullScreen" element-loading-text="Loading..." element-loading-spinner="el-icon-loading"
        element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog title="Thông tin trường học" :visible.sync="show_dialog" width="95%" top="5vh"
            :before-close="handleClose">
            <el-form class="dialogView">
                <el-row :gutter="24">
                    <el-col :span="24">
                        <h4>I. Thông tin chung</h4>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Tỉnh thành</label>
                        <eselect :disabled="thongtin.role>1" collapseTags v-model="formEdit.maTthanh"
                            @change="chonTinhThanh" :placeholder="''" filterable :data="list_tinh_thanh"
                            :fields="['tenTinhThanh','maTinhThanh']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Quận huyện <sup class="red">*</sup></label>
                        <eselect disabled collapseTags v-model="formEdit.maQhuyen" @change="chonQuanHuyen"
                            :placeholder="''" filterable :data="list_quan_huyen"
                            :fields="['tenQuanHuyen','maQuanHuyen']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Phường xã</label>
                        <eselect disabled collapseTags v-model="formEdit.maPxa" @change="chonPhuongXa" :placeholder="''"
                            filterable :data="list_phuong_xa" :fields="['tenPhuongXa','maPhuongXa']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Tổ thôn</label>
                        <el-select v-model="formEdit.maTthon" filterable disabled allow-create default-first-option
                            :no-match-text="'Không có dữ liệu'" :no-data-text="'Không có gợi ý'"
                            placeholder="">
                            <el-option v-for="item in list_to_thon" :key="item.maToThon" :label="item.tenToThon"
                                :value="item.maToThon">
                            </el-option>
                        </el-select>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Đơn vị quản lý <sup class="red">*</sup></label>
                        <eselect disabled collapseTags v-model="formEdit.maDonVi" :placeholder="''" filterable
                            :data="list_don_vi_so" :fields="['tenDonVi','maDonVi']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Mã trường học</label>
                        <el-input disabled placeholder="" v-model="formEdit.maTruongHoc" :disabled="true">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Tên trường học <sup class="red">*</sup></label>
                        <el-input disabled placeholder="" v-model="formEdit.tenTruongHoc">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Cấp học</label>
                        <eselect multiple disabled v-model="formEdit.capHocs" :placeholder="''" filterable
                            :data="list_cap_hoc" :fields="['name','id']" />
                    </el-col>

                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Nhóm cấp học</label>
                        <eselect collapseTags disabled v-model="formEdit.maNhomCapHoc" :placeholder="''" filterable
                            :data="list_ma_nhom_cap_hoc" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Loại hình đào tạo <sup class="red">*</sup></label>
                        <eselect collapseTags disabled v-model="formEdit.loaiHinhDaoTao" :placeholder="''" filterable
                            :data="list_loai_hinh_dao_tao" :fields="['name','value']" />
                    </el-col>

                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Loại hình trường <sup class="red">*</sup></label>
                        <eselect collapseTags disabled v-model="formEdit.loaiHinhTruong" :placeholder="''" filterable
                            :data="list_loai_hinh_truong" :fields="['name','value']" />
                    </el-col>

                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Ngày thành lập</label>
                        <date-picker disabled v-model="formEdit.ngayThanhLap" placeholder=""
                            valueType="format" value-type="DD/MM/YYYY" format="DD/MM/YYYY">
                        </date-picker>
                    </el-col>

                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Chuẩn quốc gia <sup class="red">*</sup></label>
                        <eselect disabled collapseTags v-model="formEdit.chuanQuocGia" :placeholder="''" filterable
                            :data="list_chuan_quoc_gia" :fields="['name','value']" />
                    </el-col>

                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Website</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.website">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Tên hiệu trưởng</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.tenHieuTruong">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Email trường</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.email">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Email hiệu trưởng</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.emailHieuTruong">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Fax</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.fax">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Địa chỉ</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.diaChi">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Trạng thái</label>
                        <eselect collapseTags disabled v-model="formEdit.trangThai" :placeholder="''" filterable
                            :data="list_trang_thai" :fields="['name','value']" />
                    </el-col>
                    <el-col :span="24">
                        <h4>II. Thông tin khác</h4>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Điện thoại trường học</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.sdt">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Điện thoại hiệu trưởng</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.sdtHieuTruong">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Khu vực</label>
                        <eselect collapseTags disabled v-model="formEdit.khuVuc" :placeholder="''" filterable
                            :data="list_khu_vuc" :fields="['name','value']" />
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Vùng đặc biệt khó khăn</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.vungDbKhoKhan">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có nước uống</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.nuocUong">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có khai thác internet cho dạy học</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.ktInternetDayHoc">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có công trình vệ sinh riêng rẽ cho từng giới tính</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.coCtVeSinhTheoGt">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có bộ phận công tác tư vấn học đường</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.ctacTuVanHd">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có điện (điện lưới)</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.coDien">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có chỗ rửa tay thuận tiện (nước + xà phòng)</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.choRuaTay">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Trường có sử dụng nguồn nước sạch</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.nuocSach">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Trường có sử dụng máy tính dạy học</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.sdMayTinh">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Số điểm trường</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.soDiemTruong">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Mã trung tâm</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.maTrungTam">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Kinh tuyến</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.kinhTuyen">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Vĩ tuyến</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.viTuyen">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Vị trí bản đồ</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.viTriBanDo">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Chương trình giáo dục cơ bản</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.chuongTrinhGiaoDucCoBan">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có lớp không chuyên</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.coLopKhongChuyen">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có công trình vệ sinh</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.congTrinhVeSinh">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Chương trình giáo dục vệ sinh đôi tay</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.ctGdvsDoiTay">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Đạt chất lượng tối thiểu</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.datChatLuongToiThieu">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Dạy nghề phổ thông</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.dayNghePhoThong">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Diện tích</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.dienTich">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Học 2 buổi trên ngày</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.hoc2BuoiNgay">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có học sinh bán trú</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.hocSinhBanTru">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có học sinh nội trú</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.hocSinhNoiTru">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có học sinh khuyết tật</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.hocSinhKhuyetTat">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Kỹ năng sống giáo dục xã hội</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.kyNangSongGdxh">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Mã vùng khó khăn</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.maVungKhoKhan">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Mã loại trung tâm</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.maLoaiTrungTam">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có kế hoạch phòng chống thiên tai dịch bệnh</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.khPcThienTaiDichBenh">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có chương trình học song ngữ</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.isCoChuongTrinhSongNgu">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Tổng số cán bộ</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.tongSoCanBo">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Tổng số lớp học</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.tongSoLopHoc">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Tổng số học sinh</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.tongSoHocSinh">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Trường quốc tế</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.truongQuocTe">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>T.vấn giáo dục hướng nghiệp</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.tuVanHuongNghiep">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8">
                        <label>Có CS hạ tầng, TL học tập, MT học tập phù hợp và tiếp cận với HS khuyết tật</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.cshtChoHskt">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8">
                        <label>Có KH G.Dục phòng, chống thiên tai và Ứng phó biến đổi khí hậu</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.pcThienTaiBdkh">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="24" :md="8">
                        <label>Phổ biến cho CMHS về các CTGD phòng, chống HIV trên nền tảng KNS&SKSS</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.pbienKnsSkss">
                        </el-input>
                    </el-col>
                    <el-col :xs="24" :sm="12" :md="8">
                        <label>Có chi bộ Đảng</label>
                        <el-input clearable disabled placeholder="" v-model="formEdit.coChiBoDang">
                        </el-input>
                    </el-col>
                </el-row>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="close" size="mini">Đóng</el-button>
            </span>
        </el-dialog>

    </div>
</template>

<script>
    import ESelectVue from '../../ui/ESelect.vue';
    import rest_api from "../../../utils/rest_api";
    import DatePicker from 'vue2-datepicker';
    import 'vue2-datepicker/index.css';

    export default {
        name: "chinhSua",
        props: ['show', 'item'],
        components: {
            'eselect': ESelectVue,
            DatePicker
        },
        data() {
            return {
                thongtin: JSON.parse(window.userInfo),
                show_dialog: false,
                loadingFullScreen: false,
                formEdit: {},
                list_tinh_thanh: [],
                list_quan_huyen: [],
                list_phuong_xa: [],
                list_to_thon: [],
                list_don_vi_so: [],
                list_loai_hinh_dao_tao: [{
                        name: "Công lập - [1]",
                        value: 1
                    },
                    {
                        name: "Tư thục - [2]",
                        value: 2
                    },
                    {
                        name: "GDTX - [3]",
                        value: 3
                    }, {
                        name: "Dân lập - [5]",
                        value: 5
                    },
                ],
                list_cap_hoc: window.listCapHoc,

                list_ma_nhom_cap_hoc: [{
                        name: 'Mầm non',
                        value: '01'
                    },
                    {
                        name: 'Mẫu giáo',
                        value: '02'
                    },
                    {
                        name: 'Nhà trẻ',
                        value: '03'
                    },
                    {
                        name: 'Nhóm nhà trẻ độc lập',
                        value: '04'
                    },
                    {
                        name: 'Lớp mẫu giáo độc lập',
                        value: '05'
                    },
                    {
                        name: 'Tiểu học',
                        value: '06'
                    },
                    {
                        name: 'THCS',
                        value: '07'
                    },
                    {
                        name: 'THPT',
                        value: '08'
                    },
                    {
                        name: 'PTCS',
                        value: '09'
                    },
                    {
                        name: 'Trung học',
                        value: '10'
                    },
                    {
                        name: 'Phổ thông',
                        value: '11'
                    },
                    {
                        name: 'GDTX Tỉnh',
                        value: '12'
                    },
                    {
                        name: 'GDTX Huyện',
                        value: '13'
                    },
                    {
                        name: 'TTKTTHHN',
                        value: '14'
                    },
                    {
                        name: 'Lớp nhô',
                        value: '15'
                    },
                    {
                        name: 'MN-TH',
                        value: '16'
                    },
                    {
                        name: 'MN-PT',
                        value: '17'
                    },
                    {
                        name: 'MN-PTCS',
                        value: '18'
                    },
                    {
                        name: 'Nhóm trẻ, lớp mẫu giáo độc lập',
                        value: '19'
                    }
                ],
                list_loai_hinh_truong: [],
                list_chuan_quoc_gia: [],
                list_khu_vuc: [],
                list_trang_thai: [{
                        name: 'Ngưng hoạt động',
                        value: 0
                    },
                    {
                        name: 'Đang hoạt động',
                        value: 1
                    },
                    {
                        name: 'Đã xoá',
                        value: -1
                    },
                ],
            }
        },
        watch: {
            show: function (newVal) {
                console.log("Show thông tin thay thay đổi:" + newVal)
                if (newVal) {
                    this.bindDataUpdate();
                    this.show_dialog = true;
                } else {
                    this.show_dialog = false;
                }
            }
        },
        mounted() {
            console.log("Mounted...")
            this.ganDuLieuSME();
        },
        methods: {
            setCapHocFromArr(arr) {
                var unique_arr = [];
                if (arr) {
                    let duLieu = arr.join('');
                    let mang = duLieu.split('');
                    console.log("setCapHocFromArr");
                    unique_arr = [...new Set(mang)];
                    unique_arr.sort(function (a, b) {
                        return a - b;
                    });
                    console.log(unique_arr)
                }
                return unique_arr.join('')
            },
            convertArrayIntToArrayString(arr) {
                let result = [];
                if (arr) {
                    result = arr;
                    for (let i = 0; i < result.length; i++) {
                        result[i] = result[i].toString();
                    }
                }
                return result;
            },
            convertArrayStringToArrayInt(arr) {
                if (arr && arr.length > 0) {
                    for (let i = 0; i < arr.length; i++) {
                        arr[i] = parseInt(arr[i]);
                    }
                    return arr;
                }
            },
            xacNhanChinhSua() {
                this.formEdit.ma = this.formEdit.maTruongHoc;
                this.formEdit.ten = this.formEdit.tenTruongHoc;
                this.formEdit.maQuanHuyen = this.formEdit.maQhuyen;
                this.formEdit.maTinhThanh = this.formEdit.maTthanh;
                console.log("Dữ liệu chỉnh sửa:")
                let capHoc = this.setCapHocFromArr(this.formEdit.capHocs);
                console.log("Cấp học chỉnh sửa:")
                console.log(capHoc);
                this.formEdit.capHoc = parseInt(capHoc);
                this.formEdit.capHocs = this.convertArrayIntToArrayString(this.formEdit.capHocs);

                console.log(this.formEdit);
                if (!this.formEdit || !this.formEdit.ten || !this.formEdit.maDonVi || !this.formEdit.loaiHinhDaoTao || !
                    this.formEdit.maQuanHuyen || !this.formEdit.maTinhThanh || this.formEdit.chuanQuocGia === '' || !
                    this.formEdit.loaiHinhTruong || !this.formEdit.maDonVi) {
                    this.thongBao('error', 'Vui lòng kiểm tra & bổ sung thông tin bắt buộc')
                    return;
                }
                let params = JSON.parse(JSON.stringify(this.formEdit))
                if (params.ngayThanhLap) {
                    let darr = params.ngayThanhLap
                        .split("/")
                    var dobj = new Date(
                        parseInt(darr[2]),
                        parseInt(darr[1]) - 1,
                        parseInt(darr[0])
                    );
                    dobj = dobj.toISOString();
                    params.ngayThanhLap = dobj;
                }
                this.loadingFullScreen = true;
                rest_api.put("/internal-api/dmTruongHoc/update", params, (response) => {
                    console.log("Chỉnh sửa trả về:")
                    console.log(response)
                    if (response.data.code == 200) {
                        this.thongBao('success', 'Chỉnh sửa trường học thành công');
                        this.$emit('thanhcong')
                    } else {
                        this.thongBao('error', 'Vui lòng thử lại sau ít phút.')
                    }
                    this.loadingFullScreen = false;
                });
                // this.$confirm('Xác nhận chỉnh sửa thông tin?', 'Thông báo', {
                //     confirmButtonText: 'Xác nhận',
                //     cancelButtonText: 'Hủy',
                // })
                //     .then(_ => {
                //     })
                //     .catch(_ => {
                //     });
            },
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_loai_hinh_dao_tao_sme"];
                if (tmp) {
                    this.list_loai_hinh_truong = this.mapToArrayInt(JSON.parse(localStorage[
                        "danh_sach_loai_hinh_truong_sme"]));
                    this.list_chuan_quoc_gia = this.mapToArrayInt(JSON.parse(localStorage[
                        "danh_sach_chuan_quoc_gia_sme"]));
                }
            },
            mapToArrayInt(data) {
                console.log("data")
                console.log(data)
                let du_lieu = [];
                for (let i = 0; i < data.length; i++) {
                    if (data[i].value) {
                        let obj = {
                            label: data[i].label,
                            name: data[i].name,
                            value: parseInt(data[i].value)
                        }
                        du_lieu.push(obj);
                    }
                }
                return du_lieu;
            },
            getDonViQuanLy() {
                let params = {
                    "start": 0,
                    "limit": 100,
                    "maTinhThanh": this.formEdit.maTthanh,
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (response) => {
                    if (response.data.code == 200) {
                        let ldv = []
                        let dulieu = response.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenDonVi: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                maDonVi: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi_so = ldv;
                    } else {
                        this.thongBao('error', 'Không lấy được danh sách đơn vị.')
                    }
                });
            },
            chonPhuongXa() {
                this.formEdit.maTthon = '';
                if (this.formEdit.maPxa) {
                    this.getToThon();
                }
            },
            chonQuanHuyen() {
                this.formEdit.maTthon = '';
                this.formEdit.maPxa = '';
                if (this.formEdit.maQhuyen) {
                    this.getPhuongXa();
                }
            },
            chonTinhThanh() {
                this.formEdit.maTthon = '';
                this.formEdit.maPxa = '';
                this.formEdit.maQhuyen = '';
                this.formEdit.maDonVi = '';
                if (this.formEdit.maTthanh) {
                    this.getQuanHuyen();
                    this.getDonViQuanLy();
                }
            },
            getToThon() {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maPhuongXa": this.formEdit.maPxa,
                    "maQuanHuyen": this.formEdit.maQhuyen,
                    "maTinhThanh": this.formEdit.maTthanh
                };
                rest_api.get("/internal-api/dmToThon/filter", params, (response) => {
                    if (response.data.code == 200) {
                        this.list_to_thon = response.data.rows;
                    } else {
                        this.thongBao('error', 'Không lấy được danh sách tổ thốn.')
                    }
                });
            },
            getPhuongXa() {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maQuanHuyen": this.formEdit.maQhuyen,
                    "maTinhThanh": this.formEdit.maTthanh
                };
                rest_api.get("/internal-api/dmPhuongXa/filter", params, (response) => {
                    if (response.data.code == 200) {
                        this.list_phuong_xa = response.data.rows;
                    } else {
                        this.thongBao('error', 'Không lấy được danh sách phường xã.')
                    }
                });
            },
            getQuanHuyen() {
                let params = {
                    "start": 0,
                    "limit": 999,
                    "maTinhThanh": this.formEdit.maTthanh
                };
                rest_api.get("/internal-api/dmQuanHuyen/filter", params, (response) => {
                    if (response.data.code == 200) {
                        this.list_quan_huyen = response.data.rows;
                    } else {
                        this.thongBao('error', 'Không lấy được danh sách quận huyện.')
                    }
                });
            },
            getTinhThanh() {
                let params = {
                    "start": 0,
                    "limit": 100
                };
                rest_api.get("/internal-api/dmTinhThanh/filter", params, (response) => {
                    if (response.data.code == 200) {
                        this.list_tinh_thanh = response.data.rows;
                        console.log("Danh sách tỉnh thành:")
                        console.log(this.list_tinh_thanh);
                    } else {
                        this.thongBao('error', 'Không lấy được danh sách tỉnh thành.')
                    }
                });
            },
            bindDataUpdate() {
                console.log("gán:")
                console.log(this.item)
                this.formEdit = JSON.parse(JSON.stringify(this.item));
                let capHoc = JSON.parse(JSON.stringify(this.item)).capHoc;
                let array_cap_hoc = capHoc.split('');
                this.formEdit.capHocs = this.convertArrayStringToArrayInt(array_cap_hoc);
                this.getTinhThanh();
                this.getQuanHuyen();
                this.getPhuongXa();
                this.getToThon();
                this.getDonViQuanLy();
            },

            handleClose() {
                console.log("handleClose");
                this.close();
            },
            close() {
                this.$emit('close');
            },

            thongBao(t, e) {
                let msg = "";
                let cl = "";
                if (e) {
                    msg = e;
                }
                let type = "success";
                if (t) {
                    type = t
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
                    type: t,
                    duration: 5000
                });
            },
        },
    }

</script>

<style scoped>
    .red {
        font-weight: 700;
        font-size: 12px;
    }
    h4{
        padding: 0;
        margin: 0;
        color: #01856B !important;
    }

</style>

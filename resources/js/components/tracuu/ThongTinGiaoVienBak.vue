<template>
    <div id="modal_info_teacher" ref="modal_info_teacher" class="modal fade">
        <div class="modal-dialog modal-dialog-fullscreen" style="">
            <div class="modal-content modal-content-fullscreen" style="">
                <div class="modal-header modal-header-fullscreen" style="">
                    <h4>CHI TIẾT HỒ SƠ CÁN BỘ</h4>
                </div>
                <div class="modal-body modal-body-fullscreen" style="">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="thumbnail" style="text-align:center; width:80%">
                                <div v-if="thongtin_giaovien.avatar">
                                    <img :src="thongtin_giaovien.avatar" width="100%" alt="hình ảnh học sinh" />
                                </div>
                                <div v-else>
                                    <img src="https://www.drupal.org/files/issues/default-avatar.png" width="120px"
                                        height="150px;" alt="" />
                                </div>
                                <div>
                                    <p style="color:blue">Mã định danh: <span>{{thongtin_giaovien.moetCode}}</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-2 text-right">
                                    <label>Họ tên</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.tenGiaoVien">
                                </div>
                                <div class="col-md-2 text-right">
                                    <label>Mã cán bộ</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.maGiaoVien">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 text-right">
                                    <label>Ngày sinh</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.ngaySinh">
                                </div>
                                <div class="col-md-2 text-right">
                                    <label>Dân tộc</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.maDanToc">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 text-right">
                                    <label>Giới tính</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled
                                        :value="parseInt(thongtin_giaovien.gioiTinh)=== 1 ? 'Nam' : 'Nữ'">
                                </div>
                                <div class="col-md-2 text-right">
                                    <label>Tôn giáo</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.maTonGiao">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 text-right">
                                    <label>Trạng thái CB</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.tenTrangThai">
                                </div>
                                <div class="col-md-2 text-right">
                                    <label>Nơi sinh</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.noiSinh">
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-md-2 text-right">
                                    <label>CMTND/TCC</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.soCmnd">
                                </div>

                                <div class="col-md-2 text-right">
                                    <label>Quê quán</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.queQuan">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 text-right">
                                    <label>Ngày cấp CMTND/TCC</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.ngayCapCmnd">
                                </div>
                                <div class="col-md-2 text-right">
                                    <label>Số sổ BHXH</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.soSoBhxh">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2 text-right">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-4">
                                    <input class="form-control" disabled :value="thongtin_giaovien.email">
                                </div>
                                <div class="col-md-2"></div>
                                <div class="col-md-2">
                                    <label>Đoàn viên</label>
                                    <span style="padding-left:15px;">
                                        <i v-if="thongtin_giaovien.doanVien" style="color:blue;"
                                            class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                    </span>
                                </div>
                                <div class="col-md-2">
                                    <label>Đảng viên</label>
                                    <span style="padding-left:15px;">
                                        <i v-if="thongtin_giaovien.dangVien" style="color:blue;"
                                            class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a data-toggle="tab" href="#home"><b>I. Vị trí việc làm</b></a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#menu1"><b>II. Phụ cấp</b></a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#menu2"><b>III. Đào tạo, bồi dưỡng</b></a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#menu3"><b>IV. Đánh giá, phân loại</b></a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#menu4"><b>V. Quá trình đào tạo, bồi dưỡng</b></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="home" class="tab-pane fade in active">
                            <div class="row" style="width:94%; margin:25px auto;">
                                <div class="col-md-4">
                                    <p><b>Vị trí việc làm:</b>
                                        <span>{{getViTriViecLam(thongtin_giaovien.loaiCanBo)}}</span></p>

                                    <p><b>Môn dạy:</b>
                                        <span>{{thongtin_giaovien.maMonHoc}}</span>
                                    </p>
                                    <p><b>Môn dạy kiêm nhiệm:</b>
                                        <span>{{thongtin_giaovien.monDayKiemNhiem}}</span>
                                    </p>
                                    <p><b>Nhóm chức vụ:</b>
                                        <span>{{thongtin_giaovien.chucVu}}</span>
                                    </p>
                                    <p><b>Hình thức hợp đồng:</b>
                                        <span>{{thongtin_giaovien.loaiHopDong}}</span>
                                    </p>
                                    <p><b>Ngày tuyển:</b>
                                        <span>{{thongtin_giaovien.ngayTuyenDung}}</span>
                                    </p>
                                    <p><b>Cơ quan tuyển dụng:</b>
                                        <span>{{thongtin_giaovien.coQuanTuyenDung}}</span>
                                    </p>
                                    <p><b>Nghề nghiệp khi được tuyển dụng:</b>
                                        <span>{{thongtin_giaovien.ngheNghiepTuyenDung}}</span>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p><b>Nhiệm vụ kiêm nhiệm:</b>
                                        <span>{{thongtin_giaovien.tenNhiemVuKiemNhiem}}</span>
                                    </p>
                                    <p><b>Số tiết thực dạy trên tuần:</b>
                                        <span>{{thongtin_giaovien.soTietThucDay1Tuan}}</span>
                                    </p>
                                    <p><b>Số tiết thực kiêm nhiệm/tuần:</b>
                                        <span>{{thongtin_giaovien.soTietKiemNhiem1Tuan}}</span>
                                    </p>
                                    <p>
                                    <label>Đã tập huấn dạy KN sống (HIV, SKSS...)</label>
                                    <span style="padding-left:15px;">
                                        <i v-if="thongtin_giaovien.tapHuanKnsSkss" style="color:blue;"
                                            class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                    </span></p>
                                    <p>
                                    <label>Dạy học sinh khuyết tật hòa nhập</label>
                                    <span style="padding-left:15px;">
                                        <i v-if="thongtin_giaovien.dayHsktHocHoaNhap" style="color:blue;"
                                            class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                    </span></p>
                                    <p><b>Đang dạy 1 buổi/ngày</b>
                                    <span style="padding-left:15px;">
                                        <i v-if="thongtin_giaovien.day1BuoiTrenNgay" style="color:blue;"
                                            class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                    </span>
                                    </p>
                                    <p><b>Đang dạy 2 buổi/ngày</b>
                                    <span style="padding-left:15px;">
                                        <i v-if="thongtin_giaovien.day2BuoiTrenNgay" style="color:blue;"
                                            class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                    </span>
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p><b>Tham gia chương trình bồi dưỡng thường xuyên</b>
                                    <span style="padding-left:15px;">
                                        <i v-if="thongtin_giaovien.thamGiaBdTxuyen" style="color:blue;"
                                            class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                    </span>
                                    </p>
                                    <p><b>Ngạch/Hạng:</b>
                                        <span>{{thongtin_giaovien.maNgach}}</span>
                                    </p>
                                    <p><b>Có CC bồi dưỡng TCCD</b>
                                    <span style="padding-left:15px;">
                                        <i v-if="thongtin_giaovien.coCcBdChucDanhNgheNghiep" style="color:blue;"
                                            class="fas fa-check-square"></i>
                                        <i v-else class="far fa-square"></i>
                                    </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div id="menu1" class="tab-pane fade">
                            <div class="row" style="width:94%; margin:25px auto;">
                                <div class="col-md-6">
                                    <p><b>Mức phụ cấp thu hút nghề (%): </b><span>{{thongtin_giaovien.mucPhuCapThuHut}}</span></p>
                                    <p><b>Mức phụ cấp thâm niên (%): </b><span>{{thongtin_giaovien.mucPhuCapThamNien}}</span></p>
                                    <p><b>Mức phụ cấp ưu đãi nghề (%): </b><span>{{thongtin_giaovien.mucPhuCapUuDai}}</span></p>
                                    <p><b>Mức phụ cấp chức vụ lãnh đạo (%): </b><span>{{thongtin_giaovien.mucPhuCapLanhDao}}</span></p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>Bậc lương: </b><span>{{thongtin_giaovien.tenBacLuong}}</span></p>
                                    <p><b>Phần trăm vượt khung (%): </b><span>{{thongtin_giaovien.vuotKhung}}</span></p>
                                    <p><b>Hệ số lương: </b><span>{{thongtin_giaovien.heSoLuong}}</span></p>
                                    <p><b>Ngày hưởng: </b><span>{{thongtin_giaovien.ngayHuong}}</span></p>
                                </div>
                            </div>
                        </div>
                        <div id="menu2" class="tab-pane fade">
                            <div class="row" style="width:94%; margin:25px auto;">
                                <div class="col-md-4">
                                    <p><b>Kết quả bồi dưỡng thường xuyên: </b><span>{{thongtin_giaovien.tenKqBdTx}}</span></p>
                                    <p><b>Trình độ chuyên môn nghiệp vụ: </b><span>{{thongtin_giaovien.trinhDoChuyenMonCaoNhat}}</span></p>
                                    <p><b>Trình độ lý luận chính trị: </b><span>{{thongtin_giaovien.trinhDoLyLuanChinhTri}}</span></p>
                                    <p><b>Trình độ quản lý giáo dục: </b><span>{{thongtin_giaovien.trinhDoQuanLyGiaoDuc}}</span></p>
                                    <p><b>Tham gia bồi dưỡng nghiệp vụ quản lý giáo dục: </b><span>{{thongtin_giaovien.maBoiDuongNvu}}</span></p>
                                    <p><b>Tham gia bồi dưỡng CBQL/GV cốt cán: </b><span>{{thongtin_giaovien.maBoiDuongCbqlCotCan}}</span></p>
                                    <p><b>Tham gia bồi dưỡng thay sách: </b><span>{{thongtin_giaovien.maBoiDuongThaySach}}</span></p>
                                </div>
                                <div class="col-md-4">
                                    <p><b>Ngoại ngữ chính: </b><span>{{thongtin_giaovien.monNgoaiNguChinh}}</span></p>
                                    <p><b>Trình độ đào tạo ngoại ngữ: </b><span>{{thongtin_giaovien.trinhDoNgoaiNgu}}</span></p>
                                    <p><b>Nhóm chứng chỉ ngoại ngữ: </b><span>{{thongtin_giaovien.maNhomCchiNngu}}</span></p>
                                    <p><b>Loại chứng chỉ ngoại ngữ: </b><span>{{thongtin_giaovien.maLoaiCchiNngu}}</span></p>
                                    <p><b>Điểm ngoại ngữ: </b><span>{{thongtin_giaovien.diemNgoaiNgu}}</span></p>
                                    <p><b>Khung năng lực ngoại ngữ: </b><span>{{thongtin_giaovien.maKhungNlucNngu}}</span></p>
                                    <p><b>Trình độ tin học: </b><span>{{thongtin_giaovien.trinhDoTinHoc}}</span></p>
                                </div>
                                <div class="col-md-4">
                                    <p><b>Chuyên ngành chính: </b><span>{{thongtin_giaovien.chuyenNganhDaoTaoChinh}}</span></p>
                                    <p><b>Trình độ chính: </b><span>{{thongtin_giaovien.tenTrinhDoDaoTaoCnChinh}}</span></p>
                                    <p><b>Cơ sở đào tạo: </b><span>{{thongtin_giaovien.tenCsDaoTaoBd}}</span></p>
                                    <p><b>Chuyên ngành khác: </b><span>{{thongtin_giaovien.chuyenNganhDaoTaoKhac}}</span></p>
                                    <p><b>Trình độ khác: </b><span>{{thongtin_giaovien.tenTrinhDoDaoTaoCnKhac}}</span></p>
                                    <p><b>Giáo viên có chứng chỉ tiếng dân tộc thiểu số: </b><span>{{thongtin_giaovien.maChungChiTiengDtocTso}}</span></p>
                                </div>
                            </div>
                        </div>
                        <div id="menu3" class="tab-pane fade">
                            <div class="row" style="width:94%; margin:25px auto;">
                                    <div class="col-md-4">
                                        <p><b>Đánh giá viên chức/ công chức: </b><span>{{thongtin_giaovien.danhGiaVienChuc}}</span></p>
                                        <p><b>Đánh giá chuẩn nghề nghiệp CBQL/GV: </b><span></span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><b>Giáo viên dạy giỏi: </b><span>{{thongtin_giaovien.tenGvDayGioi}}</span></p>
                                        <p><b>Giáo viên chủ nhiệm giỏi: </b><span>{{thongtin_giaovien.maGiaoVienChuNhiemGioi}}</span></p>
                                    </div>
                                    <div class="col-md-4">
                                        <p><b>Tổng phụ trách Đội giỏi: </b><span>{{thongtin_giaovien.maGvTongPtrachDoiGioi}}</span></p>
                                        <p><b>Danh hiệu phong tặng: </b><span>{{thongtin_giaovien.danhHieuPhongTang}}</span></p>
                                    </div>
                            </div>
                        </div>
                        <div id="menu4" class="tab-pane fade">
                            <div class="responsive">
                                <div class="row">
                                    <div class="col-md-5">
                                        <label>Chọn quá trình:</label>
                                        <select @change="getQuaTrinh" class="form-control" v-model="typeQuaTrinh">
                                            <option value="1">Quá trình bồi dưỡng nâng cao năng lực ngoại ngữ</option>
                                            <option value="2">Quá trình bồi dưỡng nâng cao năng lực sư phạm</option>
                                        </select>
                                    </div>
                                </div>
                                <hr style="padding:0; margin:7px 0" />
                                <table v-if="typeQuaTrinh==1" class="table table-bordered table-striped table-hover">
                                    <thead style="background:#e4ebf5">
                                        <th class="cg">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg">
                                            <p>Khóa đào tạo bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị tổ chức thi</p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị tổ chức</p>
                                        </th>
                                        <th class="cg">
                                            <p>Thời lượng bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Loại hình bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Hình thức</p>
                                        </th>
                                        <th class="cg">
                                            <p>Kết quả đạt được</p>
                                        </th>
                                    </thead>
                                    <tbody v-if="list_qua_trinh.length==0">
                                        <tr>
                                            <td colspan="9" class="cg">
                                                <p>Danh sách quá trình đào tạo, bồi dưỡng trống </p>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(item,i) in list_qua_trinh">
                                            <td>
                                                <p>{{i+1}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.tenKhoaDaoTao}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.tenDonViToChucThi}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.tenDonViBoiDuong}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.tenDonViToChuc}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.thoiLuongBoiDuong}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.loaiHinhBoiDuong}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.hinhThuc}} </p>
                                            </td>
                                            <td>
                                                <p>{{item.ketQua}}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table v-if="typeQuaTrinh==2" class="table table-bordered table-striped table-hover">
                                    <thead style="background:#e4ebf5">
                                        <th class="cg">
                                            <p>STT</p>
                                        </th>
                                        <th class="cg">
                                            <p>Khóa đào tạo bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Đơn vị tổ chức</p>
                                        </th>
                                        <th class="cg">
                                            <p>Thời lượng bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Loại hình bồi dưỡng</p>
                                        </th>
                                        <th class="cg">
                                            <p>Hình thức</p>
                                        </th>
                                        <th class="cg">
                                            <p>Kết quả đạt được</p>
                                        </th>
                                    </thead>
                                    <tbody v-if="list_qua_trinh.length==0">
                                        <tr>
                                            <td colspan="9" class="cg">
                                                <p>Danh sách quá trình đào tạo, bồi dưỡng trống</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(item,i) in list_qua_trinh">
                                            <td>
                                                <p>{{i+1}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.khoaDaoTao}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.donViBoiDuong}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.donViToChuc}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.thoiLuongBoiDuong}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.loaiHinhBoiDuong}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.hinhThuc}}</p>
                                            </td>
                                            <td>
                                                <p>{{item.ketQua}}</p>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer modal-footer-fullscreen" style="">
                    <button class="btn btn-info" @click.prevent="getPDF(thongtin_giaovien.canBoTheoNamId)">Xuất PDF</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>

        </div>

    </div>

</template>

<script>
    import moment from 'moment'
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import timeutils from "../../utils/time_utils";
    import api from '../api';
    import VueAlertify from "vue-alertify";
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

        props: [
            'item', 'show', 'namhoc'
        ],

        watch: {},

        data() {
            return {
                maGiaoVien: '',
                canBoTheoNamId: '',
                thongtin_giaovien: {},
                tendantoc: "",
                tentongiao: "",
                typeQuaTrinh: 1,
                tenchuyennganh: "",
                list_qua_trinh: [],
                list_ket_qua_boi_duong_nam: [],
            }
        },

        mounted: function () {
            $("#modal_info_teacher").modal();
            console.log("mounted !!!!!");
            this.canBoTheoNamId = this.item.canBoTheoNamId;
            this.getData();
            this.getKetQuaBoiDuongThuongXuyenNam();
            $(this.$refs.modal_info_teacher).on("hidden.bs.modal", this.close);
        },

        methods: {
            LayKetQuaBoiDuongNam(e) {
                let co = false;
                for (let i = 0; i < this.list_ket_qua_boi_duong_nam.length; i++) {
                    if (this.list_ket_qua_boi_duong_nam[i].value = e) {
                        co = true;
                        return this.list_ket_qua_boi_duong_nam[i].name;
                    }
                }
                if (!co) {
                    return "Không xác định"
                }
            },

            getKetQuaBoiDuongThuongXuyenNam() {
                let params = {
                    "constantType": "DM_BOI_DUONG_TX"
                }
                rest_api.post("/csdlgd-admin/sme/getDanhSach", params, data => {
                    console.log("Kqbdn:" + JSON.stringify(data.data));
                    if (data.data.rc == 0) {
                        let lsdt = data.data.tableData;
                        for (let i = 0; i < lsdt.length; i++) {
                            let obj = {
                                name: lsdt[i].constantTitle,
                                value: lsdt[i].mappingCode,
                            }
                            this.list_ket_qua_boi_duong_nam.push(obj);
                        }
                        console.log("sme trả kqbd:" + this.list_ket_qua_boi_duong_nam)
                    }
                });
            },
            getTrangThaiCanBo(loai) {
                var res = parseInt(loai);
                console.log("Vị trí việc làm:" + res)
                switch (loai) {
                    case 1:
                        res = 'Đang làm việc';
                        break;
                    case 2:
                        res = 'Chuyển công tác';
                        break;
                    case 3:
                        res = 'Nghỉ hưu';
                        break;
                    case 5:
                        res = 'Nghỉ việc';
                        break;
                    case 6:
                        res = 'Tạm nghỉ';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getViTriViecLam(loai) {
                var res = parseInt(loai);
                console.log("Vị trí việc làm:" + res)
                switch (loai) {
                    case 1:
                        res = 'Cán bộ quản lý';
                        break;
                    case 2:
                        res = 'Giáo viên';
                        break;
                    case 3:
                        res = 'Nhân viên';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getChucVu(loai) {
                let d = typeof (loai);
                var res = loai;
                switch (loai) {
                    case "1":
                        res = 'Hiệu trưởng';
                        break;
                    case "2":
                        res = 'Phó hiệu trưởng';
                        break;
                    case "8":
                        res = 'Tổ trưởng chuyên môn';
                        break;
                    case "3":
                        res = 'Nhân viên y tế';
                        break;
                    case "9":
                        res = 'Tổ phó chuyên môn';
                        break;
                    case "16":
                        res = 'Giám đốc';
                        break;
                    case "17":
                        res = 'Phó giám đốc';
                        break;
                    case "14":
                        res = 'Nhân viên thư viện';
                        break;
                    case "15":
                        res = 'Nhân viên y tế';
                        break;
                    case "24":
                        res = 'Giáo viên';
                        break;
                    case "25":
                        res = 'Giáo viên mầm non';
                        break;
                    case "26":
                        res = 'Giáo viên thỉnh giảng';
                        break;
                    case "27":
                        res = 'Hội đồng quản trị';
                        break;
                    case "6":
                        res = 'Nhân viên khác';
                        break;
                    case "4":
                        res = 'Nhân viên thí nghiệm';
                        break;
                    case "5":
                        res = 'Nhân viên kỹ thuật nghiệp vụ';
                        break;
                    case "10":
                        res = 'Nhân viên kế toán';
                        break;
                    case "11":
                        res = 'Nhân viên văn thư';
                        break;
                    case "7":
                        res = 'Nhân viên bảo vệ';
                        break;
                    case "18":
                        res = 'Trợ giảng ngôn ngữ L1';
                        break;
                    case "19":
                        res = 'Trợ giảng ngôn ngữ L2';
                        break;
                    case "12":
                        res = 'Nhân viên cấp dưỡng';
                        break;
                    case "13":
                        res = 'Nhân viên bảo mẫu';
                        break;
                    case "20":
                        res = 'Nhân viên thủ quỹ';
                        break;
                    case "21":
                        res = 'Nhân viên công nghệ thông tin';
                        break;
                    case "22":
                        res = 'Nhân viên hỗ trợ GĐ khuyết tật';
                        break;
                    case "23":
                        res = 'Nhân viên giáo vụ';
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getQuaTrinh() {
                let params = {
                    id: this.thongtin_giaovien.canBoTheoNamId,
                    type: this.typeQuaTrinh,
                };
                rest_api.post("/csdlgd-admin/giaoVien/lstQuaTrinh", params, data => {
                    if (data.data.rc == 0) {
                        this.list_qua_trinh = data.data.rows;
                        if (this.list_qua_trinh.length == 0) {}
                    }
                });
            },
            getTime(date) {
                return timeutils.dateToString(new Date(date));
            },
            getPDF(e) {
                let url = "xuat-bao-cao-pdf-thong-tin-can-bo";
                let params = {
                    "canBoTheoNamId": e,
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
                    ma: ma,
                };
                rest_api.get("/internal-api/dmDanToc/filter", params, data => {
                    if (data.data.total == 1) {
                        if (array_util.isArray(data.data.rows)) {
                            this.tendantoc = data.data.rows[0].tenDanToc;
                        }
                    }
                });
            },
            layTonGiao(ma) {
                let params = {
                    start: 0,
                    limit: 1,
                    ma: ma,
                };
                rest_api.get("/internal-api/dmTonGiao/filter", params, data => {
                    if (data.data.total == 1) {
                        if (array_util.isArray(data.data.rows)) {
                            this.tentongiao = data.data.rows[0].tenTonGiao;
                        }
                    }
                });
            },
            layChuyenNganhDaoTao(ma) {
                let params = {
                    start: 0,
                    limit: 1,
                    ma: ma,
                };
                rest_api.get("/internal-api/dmCNganhDTao/filter", params, data => {
                    console.log("chuyên ngành" + JSON.stringify(data));
                    if (data.data.total == 1) {
                        if (array_util.isArray(data.data.rows)) {
                            this.tenchuyennganh = data.data.rows[0].tenCnganhDtao;
                        }
                    }
                });
            },
            getDanToc(e) {
                return this.layDanToc(e);
            },
            getData() {
                let params = {
                    // "maGiaoVien": this.maGiaoVien,
                    "canBoTheoNamId": this.canBoTheoNamId,
                    // "namHoc": this.namhoc,
                };
                rest_api.get("/csdlgd-admin/giaoVien", params, (data) => {
                    console.log(JSON.stringify(data.data));
                    if (data&&data.data&&data.data.maGiaoVien) {
                        // this.$alertify.success("Lấy dữ liệu thành công");
                        this.thongtin_giaovien = data.data;
                        if (this.thongtin_giaovien.maDanToc) {
                            this.layDanToc(this.thongtin_giaovien.maDanToc);
                        }
                        if (this.thongtin_giaovien.maTonGiao) {
                            this.layTonGiao(this.thongtin_giaovien.maTonGiao);
                        }
                        if (this.thongtin_giaovien.maChuyenNganhDaoTao) {
                            this.layChuyenNganhDaoTao(this.thongtin_giaovien.maChuyenNganhDaoTao);
                        }
                        if (this.thongtin_giaovien.canBoTheoNamId) {
                            this.getQuaTrinh();
                        }
                    } else {
                        this.$alertify.error("Lỗi: không tìm thấy dữ liệu");
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

</style>

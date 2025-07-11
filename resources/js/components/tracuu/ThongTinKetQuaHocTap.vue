<template>
    <div>
        <el-dialog title="Thông tin kết quả học tập" :visible.sync="show" top="5vh" :close-on-click-modal="false"
            width="90%" :close-on-press-escape="false" :before-close="handleClose">
            <el-form style="margin-bottom: 0">
                <el-row :gutter="24" style="margin-bottom: 5px !important;">
                    <el-col :span="24">
                        <template v-if="duLieuHocSinh.isFormMn">
                            <div class="row">
                                <!-- Item 1 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Họ và tên</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.hoTen">
                                    </div>
                                </div>

                                <!-- Item 2 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Mã học sinh</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.maHocSinh">
                                    </div>
                                </div>

                                <!-- Item 3 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Mã định danh Bộ GDT&ĐT</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.moetCode">
                                    </div>
                                </div>

                                <!-- Item 4 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Lớp học</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.tenLopHoc">
                                    </div>
                                </div>

                                <!-- Item 5 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Năm học</label>
                                        <input type="text" disabled class="form-control" :value="getNamHoc(kqhtHocSinh.namHoc)">
                                    </div>
                                </div>

                                <!-- Item 6 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Học kỳ</label>
                                        <input type="text" disabled class="form-control" :value="getHocKy(kqhtHocSinh.hocKy)">
                                    </div>
                                </div>

                                <!-- Item 7 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Trạng thái</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.tenTrangThai">
                                    </div>
                                </div>

                                <!-- Item 8 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Số ngày nghỉ</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.soNgayNghi">
                                    </div>
                                </div>

                                <!-- Item 9 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Nhận xét GVCN</label>
                                        <textarea disabled class="form-control" :value="kqhtHocSinh.nhanXet"></textarea>
                                    </div>
                                </div>
                            </div>


                            <div class="row rcs">
                                <div class="col-md-12">
                                    <div class="table-responsive" style="margin-top: 0">
                                        <table class="table table-striped table-bordered table-hover"
                                            style="white-space: normal;">
                                            <thead style="background:#d6d6d6">
                                                <tr class="text-center">
                                                    <th class="text-center">
                                                        <p>Khám sức khỏe định kỳ</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Theo dõi biểu đồ cân nặng</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Kênh tăng trưởng cân nặng</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Theo dõi biểu đồ chiều cao</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Suy dinh dưỡng thể thấp còi</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Suy dinh dưỡng thể còi cọc</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Trẻ bị phổi, ỉa chảy, hô hấp</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Trẻ bị bệnh béo phì</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Trẻ được làm quen tin học</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <p><span>
                                                                <span v-if="kqhtHocSinh.isKhamSkDky" style="color: #01856B;"
                                                                    class="fas fa-check-square"></span>
                                                                <span v-else class="far fa-square"></span></span></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p><span>
                                                                <span v-if="kqhtHocSinh.isTheoDoiBdoCnang"
                                                                    style="color: #01856B;"
                                                                    class="fas fa-check-square"></span>
                                                                <span v-else class="far fa-square"></span></span></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p><span>
                                                                {{ kqhtHocSinh.tenKenhTtruongCnang }}</span>
                                                        </p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p><span>
                                                                <span v-if="kqhtHocSinh.isTheoDoiBdoCcao"
                                                                    style="color: #01856B;"
                                                                    class="fas fa-check-square"></span>
                                                                <span v-else class="far fa-square"></span></span></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p><span>
                                                                <span v-if="kqhtHocSinh.isSuyDduongTheTcoi"
                                                                    style="color: #01856B;"
                                                                    class="fas fa-check-square"></span>
                                                                <span v-else class="far fa-square"></span></span></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p><span>
                                                                <span v-if="kqhtHocSinh.isSuyDduongTheCoiCoc" style="color: #01856B;"
                                                                    class="fas fa-check-square"></span>
                                                                <span v-else class="far fa-square"></span></span></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p><span>
                                                                <span v-if="kqhtHocSinh.isPhoiIchayHhap"
                                                                    style="color: #01856B;"
                                                                    class="fas fa-check-square"></span>
                                                                <span v-else class="far fa-square"></span></span></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p><span>
                                                                <span v-if="kqhtHocSinh.isBeoPhi" style="color: #01856B;"
                                                                    class="fas fa-check-square"></span>
                                                                <span v-else class="far fa-square"></span></span></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p><span>
                                                                <span v-if="kqhtHocSinh.isLamQuenThoc"
                                                                    style="color: #01856B;"
                                                                    class="fas fa-check-square"></span>
                                                                <span v-else class="far fa-square"></span></span></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div>
                                        <span style="padding-left:15px;">
                                            <i v-if="kqhtHocSinh.isHoanThanhChuongTrinhMamMon" style="color: #01856B;"
                                                class="fas fa-check-square"></i>
                                            <i v-else class="far fa-square"></i></span>
                                        <label class="typo__label">Hoàn thành chương trình mầm non</label>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-if="duLieuHocSinh.isFormC1">
                            <div class="row">
                                <!-- Item 1 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Họ và tên</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.hoTen">
                                    </div>
                                </div>

                                <!-- Item 2 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Mã học sinh</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.maHocSinh">
                                    </div>
                                </div>

                                <!-- Item 3 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Mã định danh Bộ GDT&ĐT</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.moetCode">
                                    </div>
                                </div>

                                <!-- Item 4 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Lớp học</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.tenLopHoc">
                                    </div>
                                </div>

                                <!-- Item 5 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Trạng thái</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.tenTrangThai">
                                    </div>
                                </div>

                                <!-- Item 10 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Giai đoạn</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.tenGiaiDoan">
                                    </div>
                                </div>
                                

                                <!-- Item 7 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Nhận xét GVCN</label>
                                        <textarea disabled style="height: 36px; max-width: 100%" class="form-control" :value="kqhtHocSinh.nhanXet"></textarea>
                                    </div>
                                </div>

                                <!-- Item 8 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Năm học</label>
                                        <input type="text" disabled class="form-control" :value="getNamHoc(kqhtHocSinh.namHoc)">
                                    </div>
                                </div>

                                <!-- Item 9 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Học kỳ</label>
                                        <input type="text" disabled class="form-control" :value="getHocKy(kqhtHocSinh.hocKy)">
                                    </div>
                                </div><!-- Item 6 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Số ngày nghỉ</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.soNgayNghi">
                                    </div>
                                </div>
                                <!-- Item 6 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Số ngày nghỉ có phép</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.soNgayNghiCoPhep">
                                    </div>
                                </div>
                                <!-- Item 6 -->
                                <div class="col-sm-6 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Số ngày nghỉ không phép</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.soNgayNghiKhongPhep">
                                    </div>
                                </div>

                            </div>



                            <div class="row">
                                <div class="col-md-12">
                                    <h5><b>
                                            <span>Môn học, hoạt động giáo dục</span>
                                        </b></h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead style="background:#d6d6d6">
                                                <tr class="text-center">
                                                    <th style="width:5%" class="text-center">
                                                        <p>STT</p>
                                                    </th>
                                                    <th style="width:25%">
                                                        <p>Môn học</p>
                                                    </th>
                                                    <th style="width:10%" class="text-center">
                                                        <p>Điểm số</p>
                                                    </th>
                                                    <th style="width:10%" class="text-center">
                                                        <p>Đánh giá</p>
                                                    </th>
                                                    <th>
                                                        <p>Nhận xét</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>1</p>
                                                    </td>
                                                    <td>
                                                        <p>Tiếng việt</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.tvDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.tvDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.tvNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>2</p>
                                                    </td>
                                                    <td>
                                                        <p>Toán</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.toDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.toDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.toNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>3</p>
                                                    </td>
                                                    <td>
                                                        <p>Tự nhiên và xã hội</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.txDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.txDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.txNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>4</p>
                                                    </td>
                                                    <td>
                                                        <p>Ngoại ngữ</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nnDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nnDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.nnNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr v-if="kqhtHocSinh.namHoc<=2021">
                                                    <td class="text-center">
                                                        <p>5</p>
                                                    </td>
                                                    <td>
                                                        <p>Tin học</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.thDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.thDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.thNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr v-else>
                                                    <td class="text-center">
                                                        <p>5</p>
                                                    </td>
                                                    <td>
                                                        <p>TH-CN (Tin học)</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.thDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.thDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.thNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>6</p>
                                                    </td>
                                                    <td>
                                                        <p>Tiếng dân tộc</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.dtDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.dtDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.dtNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>7</p>
                                                    </td>
                                                    <td>
                                                        <p>Đạo đức</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.ddDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.ddNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>8</p>
                                                    </td>
                                                    <td>
                                                        <p>Âm nhạc</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.anDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.anNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>9</p>
                                                    </td>
                                                    <td>
                                                        <p>Mỹ thuật</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.mtDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.mtNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>10</p>
                                                    </td>
                                                    <td>
                                                        <p>Thủ công</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.tcDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.tcNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>11</p>
                                                    </td>
                                                    <td>
                                                        <p v-if="kqhtHocSinh.khoiHoc==1">Giáo dục thể chất</p>
                                                        <p v-else>Thể dục</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p></p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.tdDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.tdNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>12</p>
                                                    </td>
                                                    <td>
                                                        <p>Khoa học</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.khDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.khDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.khNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>13</p>
                                                    </td>
                                                    <td>
                                                        <p>Lịch sử & địa lý</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.ldDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.ldDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.ldNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>14</p>
                                                    </td>
                                                    <td>
                                                        <p>Kỹ thuật</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.ktDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.ktDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.ktNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>15</p>
                                                    </td>
                                                    <td>
                                                        <p>Hoạt động trải nghiệm</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <!-- <p>{{kqhtHocSinh.ktDiem}}</p> -->
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.hdtnDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.hdtnNx }}</p>
                                                    </td>
                                                </tr>
                                                <tr v-if="kqhtHocSinh.namHoc>2021">
                                                    <td class="text-center">
                                                        <p>16</p>
                                                    </td>
                                                    <td>
                                                        <p>TH-CN (Công nghệ)</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.cnDiem }}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.cnDgtx }}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{ kqhtHocSinh.cnNx }}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 style="margin-top: 20px"><b>
                                            <span>Năng lực, phẩm chất (TT27)</span>
                                        </b></h5>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead style="background:#d6d6d6">
                                                <tr class="text-center">
                                                    <th class="text-center">
                                                        <p>STT</p>
                                                    </th>
                                                    <th class="text-center" colspan="3">
                                                        <p>Năng lực, phẩm chất</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Đánh giá</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="1==2">
                                                <tr>
                                                    <td class="text-center">
                                                        <p>1</p>
                                                    </td>
                                                    <td>
                                                        <p>Tự phục vụ, tự quản</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlTpvtq }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>2</p>
                                                    </td>
                                                    <td>
                                                        <p>Hợp tác</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlHt }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>3</p>
                                                    </td>
                                                    <td>
                                                        <p>Tự học, giải quyết vấn đề</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlThgqvd }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>4</p>
                                                    </td>
                                                    <td>
                                                        <p>Chăm học, chăm làm</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcChcl }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>5</p>
                                                    </td>
                                                    <td>
                                                        <p>Tự tin, trách nhiệm</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcTttn }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>6</p>
                                                    </td>
                                                    <td>
                                                        <p>Trung thực, kỉ luật</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcTtkl }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>7</p>
                                                    </td>
                                                    <td>
                                                        <p>Đoàn kết, yêu thương</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcDkyt }}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>1</p>
                                                    </td>
                                                    <td class="text-center" rowspan="10">
                                                        <p>Năng lực cốt lõi</p>
                                                    </td>
                                                    <td class="text-center" rowspan="3">
                                                        <p>Năng lực chung</p>
                                                    </td>
                                                    <td>
                                                        <p>Tự chủ và tự học</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlTuChuTuHoc }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>2</p>
                                                    </td>
                                                    <td>
                                                        <p>Giao tiếp và hợp tác</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlGiaoTiepHopTac }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>3</p>
                                                    </td>
                                                    <td>
                                                        <p>Giải quyết vấn đề và sáng tạo</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlGquyetVdeSangTao }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>4</p>
                                                    </td>
                                                    <td class="text-center" rowspan="7">
                                                        <p>Năng lực đặc thù</p>
                                                    </td>
                                                    <td>
                                                        <p>Ngôn ngữ</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlNgonNgu }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>5</p>
                                                    </td>
                                                    <td>
                                                        <p>Tính toán</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlTinhToan }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>6</p>
                                                    </td>
                                                    <td>
                                                        <p>Khoa học</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlKhoaHoc }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>7</p>
                                                    </td>
                                                    <td>
                                                        <p>Công nghệ</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlCongNghe }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>8</p>
                                                    </td>
                                                    <td>
                                                        <p>Tin học</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlTinHoc }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>9</p>
                                                    </td>
                                                    <td>
                                                        <p>Thẩm mĩ</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlThamMi }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>10</p>
                                                    </td>
                                                    <td>
                                                        <p>Thể chất</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlTheChat }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>11</p>
                                                    </td>
                                                    <td class="text-center" rowspan="5" colspan="2">
                                                        <p>Phẩm chất chủ yếu</p>
                                                    </td>
                                                    <td>
                                                        <p>Yêu nước</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcYeuNuoc }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>12</p>
                                                    </td>
                                                    <td>
                                                        <p>Nhân ái</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcNhanAi }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>13</p>
                                                    </td>
                                                    <td>
                                                        <p>Chăm chỉ</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcChamChi }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>14</p>
                                                    </td>
                                                    <td>
                                                        <p>Trung thực</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcTrungThuc }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>15</p>
                                                    </td>
                                                    <td>
                                                        <p>Trách nhiệm</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcTrachNhiem }}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5 style="margin-top: 20px"><b>
                                        <span>Năng lực, phẩm chất (TT22)</span>
                                    </b></h5>

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead style="background:#d6d6d6">
                                                <tr class="text-center">
                                                    <th class="text-center">
                                                        <p>STT</p>
                                                    </th>
                                                    <th class="text-center" colspan="2">
                                                        <p>Năng lực, phẩm chất</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Đánh giá</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>1</p>
                                                    </td>
                                                    <td class="text-center" rowspan="3">
                                                        <p>Năng lực</p>
                                                    </td>
                                                    <td>
                                                        <p>Tự phục vụ, tự quản</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlTpvtq }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>2</p>
                                                    </td>
                                                    <td>
                                                        <p>Hợp tác</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlHt }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>3</p>
                                                    </td>
                                                    <td>
                                                        <p>Tự học và giải quyết vấn đề</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.nlThgqvd }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>4</p>
                                                    </td>
                                                    <td class="text-center" rowspan="4">
                                                        <p>Phẩm chất</p>
                                                    </td>
                                                    <td>
                                                        <p>Chăm học, Chăm làm</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcChcl }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>5</p>
                                                    </td>
                                                    <td>
                                                        <p>Tự tin, Trách nhiệm</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcTttn }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>6</p>
                                                    </td>
                                                    <td>
                                                        <p>Trung thực, Kỉ luật</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcTtkl }}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-center">
                                                        <p>7</p>
                                                    </td>
                                                    <td>
                                                        <p>Đoàn kết, Yêu thương</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{ kqhtHocSinh.pcDkyt }}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row chudam">
                                <!-- Item 1 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Danh hiệu</label>
                                    <input type="text" class="form-control" :value="kqhtHocSinh.tenDanhHieu" disabled>
                                </div>

                                <!-- Item 2 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Đánh giá kết quả giáo dục</label>
                                    <input type="text" class="form-control" :value="getDanhGiaKetQuaGiaoDuc(kqhtHocSinh.danhGiaKQGiaoDuc)" disabled>
                                </div>

                                <!-- Item 10 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Năng lực (VNEN)</label>
                                    <input type="text" class="form-control" :value="kqhtHocSinh.nangLuc" disabled>
                                </div>

                                <!-- Item 11 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Phẩm chất (VNEN)</label>
                                    <input type="text" class="form-control" :value="kqhtHocSinh.phamChat" disabled>
                                </div>

                                <!-- Item 12 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Kết quả học tập (VNEN)</label>
                                    <input type="text" class="form-control" :value="kqhtHocSinh.ketQuaHocTapVnen" disabled>
                                </div>

                                <!-- Item 13 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Đánh giá (VNEN)</label>
                                    <input type="text" class="form-control" :value="kqhtHocSinh.danhGiaVnen" disabled>
                                </div>

                                <!-- Item 14 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Danh hiệu thi đua (VNEN)</label>
                                    <input type="text" class="form-control" :value="kqhtHocSinh.danhHieuThiDuaVnen" disabled>
                                </div>

                                <!-- Item 15 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Nhận xét năng lực phẩm chất (VNEN)</label>
                                    <input type="text" class="form-control" :value="kqhtHocSinh.nhanXetNangLucPhamChat" disabled>
                                </div>

                                <!-- Item 3 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Lý do đánh giá bổ sung</label>
                                    <textarea class="form-control" v-model="kqhtHocSinh.lyDoDanhGiaBoSung" rows="2" disabled></textarea>
                                </div>

                                <!-- Item 4 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Nội dung khen thưởng</label>
                                    <textarea class="form-control" v-model="kqhtHocSinh.ndungKthuong" rows="2" disabled></textarea>
                                </div>

                                <!-- Item 5 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Khen thưởng cấp Huyện trở lên</label>
                                    <textarea class="form-control" rows="2" :value="kqhtHocSinh.khenThuongCapHuyen" disabled></textarea>
                                </div>

                                <!-- Item 6 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Nhận xét môn học & hoạt động giáo dục</label>
                                    <textarea class="form-control" rows="2" :value="kqhtHocSinh.nxMonHocVaHDGD" disabled></textarea>
                                </div>

                                <!-- Item 7 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Nhận xét phẩm chất chủ yếu</label>
                                    <textarea class="form-control" rows="2" :value="kqhtHocSinh.nxPhamChatChuYeu" disabled></textarea>
                                </div>

                                <!-- Item 8 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Nhận xét năng lực chung</label>
                                    <textarea class="form-control" rows="2" :value="kqhtHocSinh.nxNangLucChung" disabled></textarea>
                                </div>

                                <!-- Item 9 -->
                                <div class="col-sm-6 col-md-6 col-lg-4 form-group">
                                    <label class="typo__label">Nhận xét năng lực đặc thù</label>
                                    <textarea class="form-control" rows="2" :value="kqhtHocSinh.nxNangLucDacThu" disabled></textarea>
                                </div>


                            </div>

                            <div class="row">
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <span v-if="kqhtHocSinh.isLenLop" style="color: #01856B;" class="fas fa-check-square"></span>
                                            <span v-else class="far fa-square"></span>
                                            <label class="typo__label">Lên lớp</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <span v-if="kqhtHocSinh.isGuiHtruongChoLenLop" style="color: #01856B;" class="fas fa-check-square"></span>
                                            <span v-else class="far fa-square"></span>
                                            <label class="typo__label">Gửi hiệu trưởng cho lên lớp</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <span v-if="kqhtHocSinh.isHthanhCtrinhLhoc" style="color: #01856B;" class="fas fa-check-square"></span>
                                            <span v-else class="far fa-square"></span>
                                            <label class="typo__label">Hoàn thành chương trình lớp học</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <span v-if="kqhtHocSinh.isHoanThanhChuongTrinhTieuHoc" style="color: #01856B;" class="fas fa-check-square"></span>
                                            <span v-else class="far fa-square"></span>
                                            <label class="typo__label">Hoàn thành chương trình tiểu học</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <span v-if="kqhtHocSinh.isDanhGiaBoSung" style="color: #01856B;" class="fas fa-check-square"></span>
                                            <span v-else class="far fa-square"></span>
                                            <label class="typo__label">Đánh giá bổ sung</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <span v-if="kqhtHocSinh.isKthuongCnam" style="color: #01856B;" class="fas fa-check-square"></span>
                                            <span v-else class="far fa-square"></span>
                                            <label class="typo__label">Khen thưởng cuối năm</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12 form-group">
                                            <span v-if="kqhtHocSinh.isKthuongDxuat" style="color: #01856B;" class="fas fa-check-square"></span>
                                            <span v-else class="far fa-square"></span>
                                            <label class="typo__label">Khen thưởng đột xuất</label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </template>
                        <template v-if="duLieuHocSinh.isFormRest">
                            <div class="row">
                                <!-- Column 1 -->
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Họ và tên</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.hoTen">
                                    </div>
                                    <div class="form-group">
                                        <label class="typo__label">Mã học sinh</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.maHocSinh">
                                    </div>
                                    <div class="form-group">
                                        <label class="typo__label">Mã định danh Bộ GDT&ĐT</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.moetCode">
                                    </div>
                                </div>

                                <!-- Column 2 -->
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label class="typo__label">Lớp học</label>
                                        <input type="text" disabled class="form-control" :value="kqhtHocSinh.tenLopHoc">
                                    </div>
                                    <div class="form-group">
                                        <label class="typo__label">Năm học</label>
                                        <input type="text" disabled class="form-control" :value="getNamHoc(kqhtHocSinh.namHoc)">
                                    </div>
                                    <div class="form-group">
                                        <label class="typo__label">Học kỳ</label>
                                        <input type="text" disabled class="form-control" :value="getHocKy(kqhtHocSinh.hocKy)">
                                    </div>
                                </div>

                                <!-- Column 3 -->
                                <div class="col-sm-6 col-md-4 col-lg-4">
                                   <div class="row">
                                       <div class="col-sm-6 col-md-12 form-group">
                                           <label class="typo__label">Trạng thái</label>
                                           <input type="text" disabled class="form-control" :value="kqhtHocSinh.tenTrangThai">
                                       </div>
                                       <div class="col-sm-6 col-md-12 form-group">
                                           <label class="typo__label">Số ngày nghỉ</label>
                                           <input type="text" disabled class="form-control" :value="kqhtHocSinh.soNgayNghi">
                                       </div>
                                       <div class="col-sm-6 col-md-12 form-group">
                                           <label class="typo__label">Nhận xét GVCN</label>
                                           <textarea disabled style="height: 36px; max-width: 100%" class="form-control"
                                                     :value="kqhtHocSinh.nhanXet"></textarea>
                                       </div>
                                   </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="row" style="margin:0">
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover">
                                                <thead style="background:#d6d6d6">
                                                    <tr class="text-center">
                                                        <th class="text-center">
                                                            <p>STT</p>
                                                        </th>
                                                        <th>
                                                            <p>Môn học</p>
                                                        </th>
                                                        <th class="text-center">
                                                            <p>Điểm số</p>
                                                        </th>
                                                        <th class="text-center">
                                                            <p>Điểm đánh giá</p>
                                                        </th>
                                                        <th class="text-center">
                                                            <p>Điểm thi lại</p>
                                                        </th>
                                                        <th class="text-center">
                                                            <p>Điểm đánh giá lại</p>
                                                        </th>
                                                        <th>
                                                            <p>Nhận xét</p>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody v-if="listDiemTKM.length===0">
                                                    <tr>
                                                        <td class="text-center" colspan="18">
                                                            Không
                                                            có dữ
                                                            liệu phù hợp
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody v-else="v-else">
                                                    <tr v-for="(px,index) in listDiemTKM">
                                                        <td class="text-center">
                                                            <p>{{ index + 1 }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ px.tenMonHoc }}</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <p>{{ px.diemSo == -1 ? 'MG' : px.diemSo }}</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <p>{{ px.diemDanhGia }}</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <p>{{ px.diemThiLai }}</p>
                                                        </td>
                                                        <td class="text-center">
                                                            <p>{{ px.diemDanhGiaLai }}</p>
                                                        </td>
                                                        <td>
                                                            <p>{{ px.nhanXetCuaGv }}</p>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row" style="margin:24px 0 0 0">
                                    <div class="col-sm-6 col-md-4">

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Khen thưởng</label>
                                            </div>
                                            <div class="col-md-12">
                                                <textarea class="form-control" disabled v-model="kqhtHocSinh.khenThuong" rows="1"></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Kỷ luật</label>
                                            </div>
                                            <div class="col-md-12">
                                                <textarea class="form-control" disabled v-model="kqhtHocSinh.kyLuat" rows="1"></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Loại tốt nghiệp</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.maLoaiTotNghiep">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Lý do miễn thi</label>
                                            </div>
                                            <div class="col-md-12">
                                                <textarea class="form-control" disabled v-model="kqhtHocSinh.lyDoMien" rows="1"></textarea>
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Chứng chỉ nghề</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.chungChiNghe">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Loại chứng chỉ nghề</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.loaiChungChiNghe">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Kết quả học tập (TT22)</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.kqHocTap">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Kết quả rèn luyện (TT22)</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.kqRenLuyen">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Khen thưởng cấp Huyện trở lên</label>
                                            </div>
                                            <div class="col-md-12">
                                                <textarea disabled class="form-control" :value="kqhtHocSinh.khenThuongCapHuyen"></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-6 col-md-4 col-lg-4">
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Điểm tổng kết (TT58)</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.diemTongKet">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Học lực (TT58)</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.tenHocLuc">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Hạnh kiểm (TT58)</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.tenHanhKiem">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Danh hiệu</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.tenDanhHieu">
                                            </div>
                                        </div>



                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Trung bình môn sau thi lại (TT58)</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.diemTongKetSauThiLai">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Học lực sau thi lại (TT58)</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.maHocLucSauThiLai">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Hạnh kiểm sau thi lại (TT58)</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.maHanhKiemSauThiLai">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Kết quả học tập sau thi lại (TT22)</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.kqHocTapSauThiLai">
                                            </div>
                                        </div>

                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <label class="typo__label">Kết quả rèn luyện sau rèn luyện lại (TT22)</label>
                                            </div>
                                            <div class="col-md-12">
                                                <input type="text" disabled class="form-control" :value="kqhtHocSinh.kqRenLuyenSauThiLai">
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-sm-12 col-md-4">


                                        <div class="row">
                                            <div class="col-md-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="typo__label">Đánh giá bổ sung sau thi lại</label>
                                                    <input type="text" disabled class="form-control" :value="kqhtHocSinh.danhGiaBoSungSauThiLai">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="typo__label">Năng lực (VNEN)</label>
                                                    <input type="text" disabled class="form-control" :value="kqhtHocSinh.nangLuc">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="typo__label">Phẩm chất (VNEN)</label>
                                                    <input type="text" disabled class="form-control" :value="kqhtHocSinh.phamChat">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="typo__label">Kết quả học tập (VNEN)</label>
                                                    <input type="text" disabled class="form-control" :value="kqhtHocSinh.ketQuaHocTapVnen">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="typo__label">Đánh giá (VNEN)</label>
                                                    <input type="text" disabled class="form-control" :value="kqhtHocSinh.danhGiaVnen">
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="typo__label">Danh hiệu thi đua (VNEN)</label>
                                                    <input type="text" class="form-control" :value="kqhtHocSinh.danhHieuThiDuaVnen" disabled>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-6">
                                                <div class="form-group">
                                                    <label class="typo__label">Nhận xét NLPC (VNEN)</label>
                                                    <input type="text" class="form-control" :value="kqhtHocSinh.nhanXetNangLucPhamChat" disabled>
                                                </div>
                                            </div>
                                        </div>



                                    </div>

                                </div>

                                <div style="margin:0px 0 0 0" class="row">
                                    <div class="col-sm-6">
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <span v-if="kqhtHocSinh.isLenLop" style="color: #01856B;" class="fas fa-check-square"></span>
                                                <span v-else class="far fa-square"></span>
                                                <label class="typo__label">Lên lớp</label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <span v-if="kqhtHocSinh.isRenLuyenLai" style="color: #01856B;" class="fas fa-check-square"></span>
                                                <span v-else class="far fa-square"></span>
                                                <label class="typo__label">Rèn luyện lại</label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <span v-if="kqhtHocSinh.isThiLai" style="color: #01856B;" class="fas fa-check-square"></span>
                                                <span v-else class="far fa-square"></span>
                                                <label class="typo__label">Thi lại</label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <span v-if="kqhtHocSinh.isDuXetTotNghiep" style="color: #01856B;" class="fas fa-check-square"></span>
                                                <span v-else class="far fa-square"></span>
                                                <label class="typo__label">Dự xét tốt nghiệp</label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <span v-if="kqhtHocSinh.isTotNghiep" style="color: #01856B;" class="fas fa-check-square"></span>
                                                <span v-else class="far fa-square"></span>
                                                <label class="typo__label">Tốt nghiệp</label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <span v-if="kqhtHocSinh.isMien" style="color: #01856B;" class="fas fa-check-square"></span>
                                                <span v-else class="far fa-square"></span>
                                                <label class="typo__label">Được miễn thi</label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <span v-if="kqhtHocSinh.isDacCach" style="color: #01856B;" class="fas fa-check-square"></span>
                                                <span v-else class="far fa-square"></span>
                                                <label class="typo__label">Được đặc cách</label>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <span v-if="kqhtHocSinh.isLenLopSauThiLai" style="color: #01856B;" class="fas fa-check-square"></span>
                                                <span v-else class="far fa-square"></span>
                                                <label class="typo__label">Lên lớp sau thi lại</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </template>
                    </el-col>
                </el-row>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <!-- <el-button type="primary" @click.prevent="submitForm('ruleForm')" size="mini">Lưu</el-button> -->
            </span>
        </el-dialog>


    </div>
</template>
<script>
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import moment from 'moment'
    import constant from "../../utils/constant";
    import VueAlertify from "vue-alertify";
    import utils from '../../utils'
    import api from '../api';
    import ElementUI from 'element-ui';

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
                    console.log("Hiện lên")
                    this.layThongTinKetQuaHocTap(this.item);
                    $("#modal_thong_tin_kqht").modal();
                } else {
                    $("#modal_thong_tin_kqht").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                console.log("thông tin học sinh" + newVal);
                // this.layThongTinKetQuaHocTap(newVal);
            }
        },
        data() {
            return {
                capHocHocSinh: "",
                listDiemTKM: [],
                duLieuHocSinh: {},
                kqhtHocSinh: {},
                list_years: constant.LIST_YEARS_FULL,
                Hoanthanh: "H",
                Tot: 'T',
                Dat: "D",
                ChuaDat: "C"
            }
        },
        mounted: function () {
            console.log(JSON.stringify(this.item));
            $(this.$refs.modal_thong_tin_kqht).on("hidden.bs.modal", this.close);
        },
        methods: {
            handleClose(){
                this.close();
            },
            getDanhGiaKetQuaGiaoDuc(e) {
                let tmp = localStorage["danh_sach_danh_gia_ket_qua_giao_duc"];
                if (tmp) {
                    let tam = JSON.parse(localStorage["danh_sach_danh_gia_ket_qua_giao_duc"])
                    let list_danh_gia = tam;
                    for (let i = 0; i < list_danh_gia.length; i++) {
                        if (e == list_danh_gia[i].value) {
                            return list_danh_gia[i].label
                        }
                    }
                }

            },
            getNamHoc(e) {
                let date = e + "-" + (e + 1);
                return date;
            },
            getHocKy(e) {
                if (e == 1) {
                    return "I";
                }
                if (e == 2) {
                    return "II";
                }
                if (e == 3) {
                    return "Cả năm";
                }
            },
            layThongTinKetQuaHocTap(e) {
                let params = {
                    "id": e
                };
                console.log("lấy thông tin nè:" + JSON.stringify(params));
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/csdlgd-admin/kqht-hs", params, (data) => {
                    loading.close();
                    if (data.data.rc == 0) {
                        // this
                        //     .$alertify
                        //     .success("Lấy thông tin thành công");
                        this.duLieuHocSinh = data.data;
                        this.kqhtHocSinh = this.duLieuHocSinh.kqhtHocSinh;
                        this.listDiemTKM = this.kqhtHocSinh.listDiemTKM;
                    } else {
                        this
                            .$alertify
                            .error(data.data.rd);

                    }
                });
            },
            reset() {},
            close() {
                this.reset();
                this.$emit('close');
            },
            getLoaiDanhGia(loai) {
                var res = loai;
                switch (loai) {
                    case 0:
                        res = 'Môn chấm điểm'
                        break;
                    case 1:
                        res = 'Môn nhận xét'
                        break;
                    case 2:
                        res = 'Kết hợp CĐ & NX'
                        break;
                    case 3:
                        res = 'Đánh giá theo TT 22'
                        break;
                    case 4:
                        res = 'Đánh giá theo VNEN'
                        break;
                    default:
                        res = loai;
                }
                return res;
            },
            getLoaiDanhGia2(loai) {
                var res = loai;
                switch (loai) {
                    case "T":
                        res = 'Tốt'
                        break;
                    case "H":
                        res = 'Hoàn thành'
                        break;
                    case "C":
                        res = 'Chưa đạt'
                        break;
                    case "Đ":
                        res = 'Đạt'
                        break;
                    default:
                        res = loai;
                }
                return res;
            }
        }
    }

</script>
<style scoped="scoped">
    input[disabled] {

    }

    label {

        font-weight: normal;
    }

    i {
        padding-top: 3px;
    }

    input[type=checkbox] {
        margin-left: 15px;
    }

    textarea {

    }

    .chudam p {
        font-weight: bold;
    }

    .rcs {
        display: flex;
        margin-bottom: 20px;
    }

    .col-md-7,
    .col-md-6 {
        align-self: center;
    }

</style>

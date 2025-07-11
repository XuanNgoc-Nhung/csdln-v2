<template>

    <div
        id="chinh_sua_kqht"
        ref="chinh_sua_kqht"
        class="modal fade"
        style="font-size:18px;">
        <div class="modal-dialog" style="width:85%">
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Chỉnh sửa kết quả học tập</h4>
                </div>
                <div class="modal-body" style="width: 95%;margin: 0 auto;">
                    <!-- check form cấp học -->
                    <div v-if="duLieuHocSinh.isFormMn">
                        <div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Họ & tên:</label>
                                    <input disabled="disabled" v-model="kqhtHocSinh.hoTen" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Mã học sinh:</label>
                                    <input
                                        disabled="disabled"
                                        v-model="kqhtHocSinh.maHocSinh"
                                        class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Lớp học:</label>
                                    <input
                                        disabled="disabled"
                                        v-model="kqhtHocSinh.tenLopHoc"
                                        class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                    <label >
                                        Trường học:</label>
                                    <input
                                        disabled="disabled"
                                        v-model="kqhtHocSinh.tenTruongHoc"
                                        class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Năm học:</label>
                                    <select v-model="kqhtHocSinh.namHoc" class="form-control">
                                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Học kỳ:</label>
                                    <select v-model="kqhtHocSinh.hocKy" class="form-control">
                                        <option value="">Chọn học kỳ</option>
                                        <option value="1">Học kỳ I</option>
                                        <option value="2">Học kỳ II</option>
                                        <option value="3">Cả năm</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Số ngày nghỉ:</label>
                                    <input v-model="kqhtHocSinh.soNgayNghi" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Nhận xét:</label>
                                    <input v-model="kqhtHocSinh.nhanXet" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Ghi chú:</label>
                                    <input v-model="kqhtHocSinh.ghiChu" class="form-control"/>
                                </div>
                            </div>
                            <!-- phần check true/false -->

                            <hr style="margin:5px 0"/>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isKhamSkDky"/>
                                        <span>Khám sức khỏe định kỳ</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isTheoDoiBdoCnang"/>
                                        <span>Theo dõi biểu đồ chức năng</span>
                                    </div>

                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isTheoDoiBdoCcao"/>
                                        <span>Theo dõi biểu đồ chiều cao</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isSuyDduongTheTcoi"/>
                                        <span>Suy dinh dưỡng thể thấp còi</span>
                                    </div>

                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isPhoiIchayHhap"/>
                                        <span>Bệnh phổi, ỉa chảy, hô hấp</span>
                                    </div>

                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isBeoPhi"/>
                                        <span>Bệnh béo phì</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isLamQuenThoc"/>
                                        <span>Đã làm quen tin học</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- cấp 1 -->
                    <div v-if="duLieuHocSinh.isFormC1">
                        <div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Họ & tên:</label>
                                    <input disabled="disabled" v-model="kqhtHocSinh.hoTen" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Mã học sinh:</label>
                                    <input
                                        disabled="disabled"
                                        v-model="kqhtHocSinh.maHocSinh"
                                        class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Lớp học:</label>
                                    <input
                                        disabled="disabled"
                                        v-model="kqhtHocSinh.tenLopHoc"
                                        class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                    <label >
                                        Trường học:</label>
                                    <input
                                        disabled="disabled"
                                        v-model="kqhtHocSinh.tenTruongHoc"
                                        class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Điểm tổng kết:</label>
                                    <input v-model="kqhtHocSinh.diemTongKet" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Học lực:</label>
                                    <select v-model="kqhtHocSinh.maHocLuc" class="form-control">
                                        <option value="">Chọn học lực</option>
                                        <option value="G">Giỏi</option>
                                        <option value="K">Khá</option>
                                        <option value="TB">Trung bình</option>
                                        <option value="Y">Yếu</option>
                                        <option value="K">Kém</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Hạnh kiểm:</label>
                                    <select v-model="kqhtHocSinh.maHanhKiem" class="form-control">
                                        <option value="">Chọn hạnh kiểm</option>
                                        <option value="T">Tốt</option>
                                        <option value="K">Khá</option>
                                        <option value="TB">Trung bình</option>
                                        <option value="Y">Yếu</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Năm học:</label>
                                    <select v-model="kqhtHocSinh.namHoc" class="form-control">
                                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Học kỳ:</label>
                                    <select v-model="kqhtHocSinh.hocKy" class="form-control">
                                        <option value="">Chọn học kỳ</option>
                                        <option value="1">Học kỳ I</option>
                                        <option value="2">Học kỳ II</option>
                                        <option value="3">Cả năm</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Số ngày nghỉ:</label>
                                    <input v-model="kqhtHocSinh.soNgayNghi" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Nhận xét:</label>
                                    <input v-model="kqhtHocSinh.nhanXet" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Thành tích đặc biệt:</label>
                                    <input v-model="kqhtHocSinh.ttichDbiet" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Thời điểm đánh giá:</label>
                                    <select v-model="kqhtHocSinh.giaiDoan" class="form-control">
                                        <option value="">Chọn thời điểm đánh giá</option>
                                        <option value="GK1">Giữa kỳ I</option>
                                        <option value="GK2">Giữa kỳ II</option>
                                        <option value="CK1">Cuối kỳ I</option>
                                        <option value="CK2">Cuối kỳ II</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Danh hiệu:
                                    </label>
                                    <select v-model="kqhtHocSinh.MaDanhHieu" class="form-control">
                                        <option value="">Chọn danh hiệu
                                            {{kqhtHocSinh.MaDanhHieu}}</option>
                                        <option value="TT">Học sinh tiên tiến</option>
                                        <option value="GIOI">Học sinh giỏi</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Nội dung khen thưởng:</label>
                                    <input v-model="kqhtHocSinh.ndungKthuong" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Kỷ luật:</label>
                                    <input v-model="kqhtHocSinh.kyLuat" class="form-control"/>
                                </div>
                                <div v-if="kqhtHocSinh.isRenLuyenLai" class="col-md-2">
                                    <label>Lý do rèn luyện lại:</label>
                                    <input v-model="kqhtHocSinh.lyDoRenLuyenLai" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Ghi chú:</label>
                                    <input v-model="kqhtHocSinh.ghiChu" class="form-control"/>
                                </div>
                            </div>
                            <!-- phần check true/false -->

                            <hr style="margin:5px 0"/>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isKthuongCnam"/>
                                        <span>Khen thưởng cuối năm</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isKthuongDxuat"/>
                                        <span>Khen thưởng đề xuất</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isHthanhCtrinhLhoc"/>
                                        <span>Hoàn thành chương trình lớp học</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isLenLop"/>
                                        <span>Lên lớp</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isRenLuyenLai"/>
                                        <span>Rèn luyện lại</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isGuiHtruongChoLenLop"/>
                                        <span>Gửi hiệu trưởng cho lên lớp</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Phần danh sách đạt hay chưa đạt -->

                            <hr style="margin:5px 0"/>
                            <div class="row">
                                <div class="col-md-12 ldg">
                                    <span>Đánh giá Tiếng Việt:
                                        <select v-model="kqhtHocSinh.tvDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Toán:
                                        <select v-model="kqhtHocSinh.ToDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Tự nhiên - Xã hội:
                                        <select v-model="kqhtHocSinh.TxDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Ngoại ngữ:
                                        <select v-model="kqhtHocSinh.NnDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Tin học:
                                        <select v-model="kqhtHocSinh.ThDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Tiếng Dân tộc:
                                        <select v-model="kqhtHocSinh.DtDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Đạo đức:
                                        <select v-model="kqhtHocSinh.DdDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Âm nhạc:
                                        <select v-model="kqhtHocSinh.AnDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Mỹ thuật:
                                        <select v-model="kqhtHocSinh.MtDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Thủ công:
                                        <select v-model="kqhtHocSinh.TcDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Thể dục:
                                        <select v-model="kqhtHocSinh.TdDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Khoa học:
                                        <select v-model="kqhtHocSinh.KhDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Lịch sử - Địa lý:
                                        <select v-model="kqhtHocSinh.LdDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Kỹ thuật:
                                        <select v-model="kqhtHocSinh.KtDgtx">

                                            <option value="T">Tốt</option>
                                            <option value="H">Hoàn thành</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Năng lực phục vụ tự quản:
                                        <select v-model="kqhtHocSinh.NlTpvtq">

                                            <option value="T">Tốt</option>
                                            <option value="Đ">Đạt</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Năng lực hợp tác:
                                        <select v-model="kqhtHocSinh.NlHt">

                                            <option value="T">Tốt</option>
                                            <option value="Đ">Đạt</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Năng lực học & giải quyết vấn đề:
                                        <select v-model="kqhtHocSinh.NlThgqvd">

                                            <option value="T">Tốt</option>
                                            <option value="Đ">Đạt</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Phẩm chất chăm học chăm làm:
                                        <select v-model="kqhtHocSinh.PcChcl">

                                            <option value="T">Tốt</option>
                                            <option value="Đ">Đạt</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Phẩm chất tự tin trách nhiệm:
                                        <select v-model="kqhtHocSinh.PcTttn">

                                            <option value="T">Tốt</option>
                                            <option value="Đ">Đạt</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Phẩm chất trung thực kỷ luật:
                                        <select v-model="kqhtHocSinh.PcTtkl">

                                            <option value="T">Tốt</option>
                                            <option value="Đ">Đạt</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                    <span>Đánh giá Phẩm chất đoàn kết yêu thương:
                                        <select v-model="kqhtHocSinh.PcDkyt">

                                            <option value="T">Tốt</option>
                                            <option value="Đ">Đạt</option>
                                            <option value="C">Chưa đạt</option>
                                        </select>
                                    </span>
                                </div>
                            </div>
                            <!-- Phần danh sách điểm -->

                            <hr style="margin:5px 0"/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive row_tp">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead style="background:rgb(206, 206, 206)">
                                                <tr>
                                                    <th class="text-center">
                                                        <p>STT</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>ID môn học</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Tên môn học</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Mã môn học</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Loại đánh giá</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Điểm đánh giá</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Điểm số</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Nhận xét của Giáo viên</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Điểm thi lại</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Điểm đánh giá thi lại</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="listDiemTKM.length===0">
                                                <tr>
                                                    <td class="text-center" colspan="10">
                                                        <p>
                                                            <p>Không có dữ liệu</p>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else="v-else">

                                                <tr v-for="(item,i) in listDiemTKM">
                                                    <td class="text-center">
                                                        <p>{{i+1}}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{item.diemTongKetMonId}}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{item.tenMonHoc}}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{item.maMonHoc}}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{getLoaiDanhGia(item.loaiDanhGia)}}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <!-- check cấp học -->
                                                        <!-- Kiểm tra xem có phải môn đánh giá không-->
                                                        <div v-if="item.loaiDanhGia==1||item.loaiDanhGia==2">
                                                            <div v-if="kqhtHocSinh.capHoc==1">
                                                                <!-- cấp 1 -->
                                                                <select v-model="item.diemDanhGia">

                                                                    <option value="A">Hoàn thành</option>
                                                                    <option value="A+">Hoàn thành tốt</option>
                                                                    <option value="B">Chưa hoàn thành</option>
                                                                </select>

                                                            </div>
                                                            <div v-if="kqhtHocSinh.capHoc==2||kqhtHocSinh.capHoc==3">
                                                                <!-- cấp 2 hoặc 3-->
                                                                <select v-model="item.diemDanhGia">

                                                                    <option value="Đ">Đạt</option>
                                                                    <option value="CĐ">Chưa đạt</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <!-- Kiểm tra xem có là môn chấm diểm không -->
                                                        <div v-if="item.loaiDanhGia==0||item.loaiDanhGia==2">
                                                            <input
                                                                placeholder="Nhập..."

                                                                type="text"
                                                                v-model="item.diemSo"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input

                                                            type="text"
                                                            placeholder="Nhập..."
                                                            v-model="item.nhanXetCuaGv"/>
                                                    </td>
                                                    <td class="text-center">
                                                        <input

                                                            type="text"
                                                            placeholder="Nhập..."
                                                            v-model="item.diemThiLai"/>
                                                    </td>
                                                    <td class="text-center">
                                                        <select v-model="item.diemDanhGiaLai">

                                                            <option value="Đ">Đạt</option>
                                                            <option value="CĐ">Chưa đạt</option>
                                                            <option value="HT">Hoàn thành</option>
                                                            <option value="CHT">Chưa hoàn thành</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- còn lại -->
                    <div v-if="duLieuHocSinh.isFormRest">
                        <div>
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Họ & tên:</label>
                                    <input disabled="disabled" v-model="kqhtHocSinh.hoTen" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Mã học sinh:</label>
                                    <input
                                        disabled="disabled"
                                        v-model="kqhtHocSinh.maHocSinh"
                                        class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Lớp học:</label>
                                    <input
                                        disabled="disabled"
                                        v-model="kqhtHocSinh.tenLopHoc"
                                        class="form-control"/>
                                </div>
                                <div class="col-md-4">
                                    <label >
                                        Trường học:</label>
                                    <input
                                        disabled="disabled"
                                        v-model="kqhtHocSinh.tenTruongHoc"
                                        class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Điểm tổng kết:</label>
                                    <input v-model="kqhtHocSinh.diemTongKet" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Học lực:</label>
                                    <select v-model="kqhtHocSinh.maHocLuc" class="form-control">
                                        <option value="">Chọn học lực</option>
                                        <option value="G">Giỏi</option>
                                        <option value="K">Khá</option>
                                        <option value="TB">Trung bình</option>
                                        <option value="Y">Yếu</option>
                                        <option value="K">Kém</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Hạnh kiểm:</label>
                                    <select v-model="kqhtHocSinh.maHanhKiem" class="form-control">
                                        <option value="">Chọn hạnh kiểm</option>
                                        <option value="T">Tốt</option>
                                        <option value="K">Khá</option>
                                        <option value="TB">Trung bình</option>
                                        <option value="Y">Yếu</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Năm học:</label>
                                    <select v-model="kqhtHocSinh.namHoc" class="form-control">
                                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Học kỳ:</label>
                                    <select v-model="kqhtHocSinh.hocKy" class="form-control">
                                        <option value="">Chọn học kỳ</option>
                                        <option value="1">Học kỳ I</option>
                                        <option value="2">Học kỳ II</option>
                                        <option value="3">Cả năm</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Số ngày nghỉ:</label>
                                    <input v-model="kqhtHocSinh.soNgayNghi" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Nhận xét:</label>
                                    <input v-model="kqhtHocSinh.nhanXet" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Thành tích đặc biệt:</label>
                                    <input v-model="kqhtHocSinh.ttichDbiet" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Thời điểm đánh giá:</label>
                                    <select v-model="kqhtHocSinh.giaiDoan" class="form-control">
                                        <option value="">Chọn thời điểm đánh giá</option>
                                        <option value="GK1">Giữa kỳ I</option>
                                        <option value="GK2">Giữa kỳ II</option>
                                        <option value="CK1">Cuối kỳ I</option>
                                        <option value="CK2">Cuối kỳ II</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Danh hiệu:
                                    </label>
                                    <select v-model="kqhtHocSinh.MaDanhHieu" class="form-control">
                                        <option value="">Chọn danh hiệu
                                            {{kqhtHocSinh.MaDanhHieu}}</option>
                                        <option value="TT">Học sinh tiên tiến</option>
                                        <option value="GIOI">Học sinh giỏi</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Nội dung khen thưởng:</label>
                                    <input v-model="kqhtHocSinh.ndungKthuong" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Kỷ luật:</label>
                                    <input v-model="kqhtHocSinh.kyLuat" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Đánh giá năng lực (Lớp VNEN):</label>
                                    <input v-model="kqhtHocSinh.NangLuc" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Đánh giá phẩm chất (Lớp VNEN):</label>
                                    <input v-model="kqhtHocSinh.PhamChat" class="form-control"/>
                                </div>
                                <div v-if="kqhtHocSinh.isRenLuyenLai" class="col-md-2">
                                    <label>Lý do rèn luyện lại:</label>
                                    <input v-model="kqhtHocSinh.lyDoRenLuyenLai" class="form-control"/>
                                </div>
                                <div class="col-md-2">
                                    <label>Ghi chú:</label>
                                    <input v-model="kqhtHocSinh.ghiChu" class="form-control"/>
                                </div>
                            </div>
                            <!-- phần check true/false -->

                            <hr style="margin:5px 0"/>
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isLamQuenThoc"/>
                                        <span>Đã làm quen tin học</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isRenLuyenLai"/>
                                        <span>Rèn luyện lại</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.IsDuXetTotNghiep"/>
                                        <span>Dự xét tốt nghiệp</span>
                                    </div>
                                    <div class="checkTrueFalse">
                                        <input type="checkbox" v-model="kqhtHocSinh.isTotNghiep"/>
                                        <span>Tốt nghiệp</span>
                                    </div>
                                </div>
                            </div>
                            <!-- Phần danh sách đạt hay chưa đạt -->

                            <hr style="margin:5px 0"/>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive row_tp">
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead style="background:rgb(206, 206, 206)">
                                                <tr>
                                                    <th class="text-center">
                                                        <p>STT</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>ID môn học</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Tên môn học</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Mã môn học</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Loại đánh giá</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Điểm đánh giá</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Điểm số</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Nhận xét của Giáo viên</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Điểm thi lại</p>
                                                    </th>
                                                    <th class="text-center">
                                                        <p>Điểm đánh giá thi lại</p>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody v-if="listDiemTKM.length===0">
                                                <tr>
                                                    <td class="text-center" colspan="10">
                                                        <p>
                                                            <p>Không có dữ liệu</p>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tbody v-else="v-else">

                                                <tr v-for="(item,i) in listDiemTKM">
                                                    <td class="text-center">
                                                        <p>{{i+1}}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{item.diemTongKetMonId}}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{item.tenMonHoc}}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <p>{{item.maMonHoc}}</p>
                                                    </td>
                                                    <td>
                                                        <p>{{getLoaiDanhGia(item.loaiDanhGia)}}</p>
                                                    </td>
                                                    <td class="text-center">
                                                        <!-- check cấp học -->
                                                        <!-- Kiểm tra xem có phải môn đánh giá không-->
                                                        <div v-if="item.loaiDanhGia==1||item.loaiDanhGia==2">
                                                            <div v-if="kqhtHocSinh.capHoc==1">
                                                                <!-- cấp 1 -->
                                                                <select v-model="item.diemDanhGia">

                                                                    <option value="A">Hoàn thành</option>
                                                                    <option value="A+">Hoàn thành tốt</option>
                                                                    <option value="B">Chưa hoàn thành</option>
                                                                </select>

                                                            </div>
                                                            <div v-if="kqhtHocSinh.capHoc==2||kqhtHocSinh.capHoc==3">
                                                                <!-- cấp 2 hoặc 3-->
                                                                <select v-model="item.diemDanhGia">

                                                                    <option value="Đ">Đạt</option>
                                                                    <option value="CĐ">Chưa đạt</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <!-- Kiểm tra xem có là môn chấm diểm không -->
                                                        <div v-if="item.loaiDanhGia==0||item.loaiDanhGia==2">
                                                            <input
                                                                placeholder="Nhập..."

                                                                type="text"
                                                                v-model="item.diemSo"/>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <input

                                                            type="text"
                                                            placeholder="Nhập..."
                                                            v-model="item.nhanXetCuaGv"/>
                                                    </td>
                                                    <td class="text-center">
                                                        <input

                                                            type="text"
                                                            placeholder="Nhập..."
                                                            v-model="item.diemThiLai"/>
                                                    </td>
                                                    <td class="text-center">
                                                        <select v-model="item.diemDanhGiaLai">

                                                            <option value="Đ">Đạt</option>
                                                            <option value="CĐ">Chưa đạt</option>
                                                            <option value="HT">Hoàn thành</option>
                                                            <option value="CHT">Chưa hoàn thành</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" @click.prevent="confirmUpdate()" class="btn btn-primary">Chỉnh sửa</button>
                </div>
            </div>

        </div>

    </div>

</template>

<script>
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import moment from 'moment'
    import constant from "../../utils/constant";
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
                    $("#chinh_sua_kqht").modal();
                } else {
                    $("#chinh_sua_kqht").modal('hide');
                }
            },
            item: function (newVal, oldVal) {
                console.log("thông tin học sinh" + newVal);
                this.tongKetHsId = newVal;
                this.layThongTinKetQuaHocTap(newVal);
            }
        },

        data() {
            return {
                capHocHocSinh: "",
                tongKetHsId: "",
                listDiemTKM: [],
                duLieuHocSinh: {},
                kqhtHocSinh: {},
                list_years: constant.LIST_YEARS_FULL
            }
        },

        mounted: function () {
            console.log("11111111111111111111111");
            console.log(JSON.stringify(this.item));
            this.layThongTinKetQuaHocTap(this.item);
            $("#chinh_sua_kqht").modal();
            $(this.$refs.chinh_sua_kqht).on("hidden.bs.modal", this.close);
        },
        methods: {
            layThongTinKetQuaHocTap(e) {

                let params = {
                    "id": e
                };
                rest_api.get("/csdlgd-admin/kqht-hs", params, (data) => {
                    console.log("Học sinh trả về:" + JSON.stringify(data));
                    if (data.data.rc == 0) {
                        this.duLieuHocSinh = data.data;
                        this.kqhtHocSinh = data.data.kqhtHocSinh;
                        // check phần input
                        if (this.kqhtHocSinh.MaDanhHieu == null) {
                            this.kqhtHocSinh.MaDanhHieu = "";
                        }
                        if (this.kqhtHocSinh.giaiDoan == null) {
                            this.kqhtHocSinh.giaiDoan = "";
                        }
                        // check phần điểm
                        console.log("bind dữ liệu");
                        console.log(JSON.stringify(this.kqhtHocSinh.tvDgtx));
                        this.listDiemTKM = this.kqhtHocSinh.listDiemTKM;
                        for (let i = 0; i < this.listDiemTKM.length; i++) {
                            if (this.listDiemTKM[i].diemDanhGia == null) {
                                this
                                    .listDiemTKM[i]
                                    .diemDanhGia = "";
                            }
                            if (this.listDiemTKM[i].diemDanhGiaLai == null) {
                                this
                                    .listDiemTKM[i]
                                    .diemDanhGiaLai = "";
                            }
                        }
                    }
                    console.log("dữ liệu học sinh:" + JSON.stringify(this.duLieuHocSinh));

                });
            },
            reset() {
                this.$emit('reload');
            },
            close() {
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
                        res = "Chưa rõ";
                }
                return res;
            },
            confirmUpdate() {
                this.chinhSuaKetQuaHocTap();
                // utils.confirmDialog("Xác nhận chỉnh sửa dữ liệu", "Sửa", () => {

                // })
            },
            chinhSuaKetQuaHocTap() {
                console.log("Chỉnh sửa kết quả học tập:");
                console.log(JSON.stringify(this.kqhtHocSinh));
                // check phần chọn đánh giá
                this.kqhtHocSinh.tongKetHsId = this.tongKetHsId;
                if (this.kqhtHocSinh.tvDgtx == "") {
                    this.kqhtHocSinh.tvDgtx = null;
                }
                if (this.kqhtHocSinh.ToDgtx == "") {
                    this.kqhtHocSinh.ToDgtx = null;
                }
                if (this.kqhtHocSinh.TxDgtx == "") {
                    this.kqhtHocSinh.TxDgtx = null;
                }
                if (this.kqhtHocSinh.NnDgtx == "") {
                    this.kqhtHocSinh.NnDgtx = null;
                }
                if (this.kqhtHocSinh.string == "") {
                    this.kqhtHocSinh.string = null;
                }
                if (this.kqhtHocSinh.DtDgtx == "") {
                    this.kqhtHocSinh.DtDgtx = null;
                }
                if (this.kqhtHocSinh.DdDgtx == "") {
                    this.kqhtHocSinh.DdDgtx = null;
                }
                if (this.kqhtHocSinh.AnDgtx == "") {
                    this.kqhtHocSinh.AnDgtx = null;
                }
                if (this.kqhtHocSinh.MtDgtx == "") {
                    this.kqhtHocSinh.MtDgtx = null;
                }
                if (this.kqhtHocSinh.TcDgtx == "") {
                    this.kqhtHocSinh.TcDgtx = null;
                }
                if (this.kqhtHocSinh.TdDgtx == "") {
                    this.kqhtHocSinh.TdDgtx = null;
                }
                if (this.kqhtHocSinh.ThDgtx == "") {
                    this.kqhtHocSinh.ThDgtx = null;
                }
                if (this.kqhtHocSinh.KhDgtx == "") {
                    this.kqhtHocSinh.KhDgtx = null;
                }
                if (this.kqhtHocSinh.LdDgtx == "") {
                    this.kqhtHocSinh.LdDgtx = null;
                }
                if (this.kqhtHocSinh.KtDgtx == "") {
                    this.kqhtHocSinh.KtDgtx = null;
                }
                if (this.kqhtHocSinh.NlTpvtq == "") {
                    this.kqhtHocSinh.NlTpvtq = null;
                }
                if (this.kqhtHocSinh.NlHt == "") {
                    this.kqhtHocSinh.NlHt = null;
                }
                if (this.kqhtHocSinh.NlThgqvd == "") {
                    this.kqhtHocSinh.NlThgqvd = null;
                }
                if (this.kqhtHocSinh.PcChcl == "") {
                    this.kqhtHocSinh.PcChcl = null;
                }
                if (this.kqhtHocSinh.PcTttn == "") {
                    this.kqhtHocSinh.PcTttn = null;
                }
                if (this.kqhtHocSinh.PcTtkl == "") {
                    this.kqhtHocSinh.PcTtkl = null;
                }
                if (this.kqhtHocSinh.PcDkyt == "") {
                    this.kqhtHocSinh.PcDkyt = null;
                }
                // hết check chọn đánh giá
                for (let i = 0; i < this.kqhtHocSinh.listDiemTKM.length; i++) {
                    if (this.kqhtHocSinh.listDiemTKM[i].diemDanhGia == "") {
                        this
                            .kqhtHocSinh
                            .listDiemTKM[i]
                            .diemDanhGia = null
                    }
                    if (this.kqhtHocSinh.listDiemTKM[i].diemDanhGiaLai == "") {
                        this
                            .kqhtHocSinh
                            .listDiemTKM[i]
                            .diemDanhGiaLai = null
                    }
                }
                // check phần true/false
                if (this.kqhtHocSinh.isKhamSkDky == true) {
                    this.kqhtHocSinh.isKhamSkDky = 1;
                } else {
                    this.kqhtHocSinh.isKhamSkDky = 0;
                }

                if (this.kqhtHocSinh.isTheoDoiBdoCnang == true) {
                    this.kqhtHocSinh.isTheoDoiBdoCnang = 1;
                } else {
                    this.kqhtHocSinh.isTheoDoiBdoCnang = 0;
                }

                if (this.kqhtHocSinh.isTheoDoiBdoCcao == true) {
                    this.kqhtHocSinh.isTheoDoiBdoCcao = 1;
                } else {
                    this.kqhtHocSinh.isTheoDoiBdoCcao = 0;
                }
                if (this.kqhtHocSinh.isSuyDduongTheTcoi == true) {
                    this.kqhtHocSinh.isSuyDduongTheTcoi = 1;
                } else {
                    this.kqhtHocSinh.isSuyDduongTheTcoi = 0;
                }
                if (this.kqhtHocSinh.isPhoiIchayHhap == true) {
                    this.kqhtHocSinh.isPhoiIchayHhap = 1;
                } else {
                    this.kqhtHocSinh.isPhoiIchayHhap = 0;
                }
                if (this.kqhtHocSinh.isBeoPhi == true) {
                    this.kqhtHocSinh.isBeoPhi = 1;
                } else {
                    this.kqhtHocSinh.isBeoPhi = 0;
                }
                if (this.kqhtHocSinh.isLamQuenThoc == true) {
                    this.kqhtHocSinh.isLamQuenThoc = 1;
                } else {
                    this.kqhtHocSinh.isLamQuenThoc = 0;
                }
                if (this.kqhtHocSinh.isKthuongCnam == true) {
                    this.kqhtHocSinh.isKthuongCnam = 1;
                } else {
                    this.kqhtHocSinh.isKthuongCnam = 0;
                }
                if (this.kqhtHocSinh.isKthuongDxuat == true) {
                    this.kqhtHocSinh.isKthuongDxuat = 1;
                } else {
                    this.kqhtHocSinh.isKthuongDxuat = 0;
                }
                if (this.kqhtHocSinh.isHthanhCtrinhLhoc == true) {
                    this.kqhtHocSinh.isHthanhCtrinhLhoc = 1;
                } else {
                    this.kqhtHocSinh.isHthanhCtrinhLhoc = 0;
                }
                if (this.kqhtHocSinh.isLenLop == true) {
                    this.kqhtHocSinh.isLenLop = 1;
                } else {
                    this.kqhtHocSinh.isLenLop = 0;
                }
                if (this.kqhtHocSinh.isRenLuyenLai == true) {
                    this.kqhtHocSinh.isRenLuyenLai = 1;
                } else {
                    this.kqhtHocSinh.isRenLuyenLai = 0;
                }
                if (this.kqhtHocSinh.isGuiHtruongChoLenLop == true) {
                    this.kqhtHocSinh.isGuiHtruongChoLenLop = 1;
                } else {
                    this.kqhtHocSinh.isGuiHtruongChoLenLop = 0;
                }
                if (this.kqhtHocSinh.isDuXetTotNghiep == true) {
                    this.kqhtHocSinh.isDuXetTotNghiep = 1;
                } else {
                    this.kqhtHocSinh.isDuXetTotNghiep = 0;
                }
                if (this.kqhtHocSinh.isTotNghiep == true) {
                    this.kqhtHocSinh.isTotNghiep = 1;
                } else {
                    this.kqhtHocSinh.isTotNghiep = 0;
                }
                console.log("sau khi bind:" + JSON.stringify(this.kqhtHocSinh));
                let params = this.kqhtHocSinh;
                console.log("Dữ liệu sửa:" + JSON.stringify(params));
                rest_api.post("/csdlgd-admin/kqht-hs/update", params, (data) => {
                    console.log("Dữ liệu chỉnh sửa kqht trả về:" + JSON.stringify(data));
                    if (data.data.rc == 0) {
                        console.log("Chỉnh sửa thành công");
                        this
                            .$alertify
                            .success("Chỉnh sửa thành công");
                        this.reset();
                        this.close();
                    } else {
                        this
                            .$alertify
                            .error("Chỉnh sửa thất bại:" + data.data.rd);
                    }

                });
            }
        }

    }
</script>
<style scoped="scoped">
    label,
    p,
    span {
        font-size: 14px;
    }
    p {
        padding: 0;
        margin: 0;
        font-size: 12px;
    }
    .checkTrueFalse {
        padding: 5px;
        display: inline-flex;
    }
    .row_tp {
        height: 400px;
    }
    .row_tp select {
        height: 23px;
        font-size: 12px;
    }
    .ldg span {
        padding-right: 10px;
        display: inline-block;
        width: 33%;
    }
</style>

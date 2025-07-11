<template>
    <!-- bắt đầu template -->
    <div>
        <div>
            <!-- bắt đầu header -->
            <div class="row page-header">
                <div class="col-sm-6 text-uppercase">
                    <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Tra cứu <span class="kytu">
                            &raquo;</span> Tra cứu cán bộ, giáo viên</span>
                </div>
            </div>
            <!-- hết header -->
            <!-- bắt đầu fillter -->
            <div>
                <div class="row">
                    <div class="col-md-4 timkiem">
                        <label class="typo__label">Chọn đơn vị</label>
                        <div v-if="thongtin.role<4">

                            <eselect style="width:100%" multiple collapseTags v-model="ds_don_vi" @change="ChonDonVi"
                                     :placeholder="'Chọn'" filterable :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                        </div>
                        <div v-if="thongtin.role==5||thongtin.role==4">
                            <input disabled v-model="tenDonViDangNhap" class="form-control" placeholder="Chọn" />
                        </div>
                    </div>
                    <div class="col-md-2 timkiem">
                        <div>
                            <label class="typo__label">Chọn cấp học</label>
                            <div v-if="thongtin.role!=5">
                                <eselect style="width:100%" multiple collapseTags v-model="ds_cap_hoc" @change="ChonCapHoc"
                                         :placeholder="'Chọn'" filterable :data="list_cap_hoc" :fields="['name','id']" />
                            </div>
                            <div v-if="thongtin.role==5">
                                <input :disabled="thongtin.role == 5" class="form-control" placeholder="Cấp học"
                                    :value="capHocDangNhap" />
                            </div>
                        </div>
                    </div>
                    <!-- Trường học -->
                    <div class="col-md-4 timkiem">
                        <div v-if="thongtin.role!=5">
                            <label class="typo__label">Chọn trường học</label>
                            <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags v-model="ds_truong_hoc" :placeholder="'Chọn'"
                                     filterable :data="list_truong_hoc" :fields="['tenTruongHoc','maTruongHoc']" />
                        </div>
                        <div v-if="thongtin.role==5">
                            <label>Trường học:</label>
                            <input :disabled="thongtin.role == 5" :value="thongtin.display_name" class="form-control"
                                placeholder="Nhập..." />
                        </div>
                    </div>
                    <!-- Hết trường học -->
                    <!-- Năm học -->
                    <div class="col-md-2 timkiem">
                        <label class="typo__label">Năm học</label>
                        <multiselect v-model="danhSachNamHoc" :options="list_nam_hoc" :custom-label="setNameNamHoc"
                            placeholder="Chọn" label="name" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                            selectedLabel="Đã chọn" track-by="name"></multiselect>
                    </div>
                    <!-- Hết năm học -->
                    <!-- Từ khóa -->
                    <div class="col-md-4 timkiem">
                        <label>Từ khóa</label>
                        <input  v-on:keyup.enter="getData" v-model="tuKhoa" class="form-control" placeholder="Tên/mã/số CMND,..." />
                    </div>
                    <div class="col-md-2 timkiem">
                        <label class="typo__label">Trình độ đào tạo CN chính</label>
                        <el-select v-model="chuyenNganh" multiple filterable collapse-tags placeholder="Chọn"
                            no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                            <el-option v-for="item in list_chuyen_nganh" :key="item.id" :label="item.name"
                                :value="item.id">
                            </el-option>
                        </el-select>
                    </div>
                    <div class="col-md-2 timkiem">
                        <label>Giới tính</label>
                        <select v-model="gioiTinh"
                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                            style="width:100%">
                            <option value=''>Chọn</option>
                            <option value='1'>Nam
                            </option>
                            <option value='0'>Nữ</option>
                        </select>
                    </div>
                    <!-- hết giới tính -->
                    <!-- Loại cán bộ -->
                    <div class="col-sm-2">
                        <label>Loại cán bộ</label>
                        <select @change="onChangeLoaiCanBo" v-model="loaiCanBo" class="form-control" style="width:100%">
                            <option value=''>Chọn</option>
                            <option value='1'>Cán bộ quản lý</option>
                            <option value='2'>Giáo viên</option>
                            <option value='3'>Nhân viên</option>
                        </select>
                    </div>
                    <!-- Hết loại cán bộ -->
                    <div class="col-sm-2">
                        <label>Trạng thái</label>
                        <el-select v-model="trangThai" filterable collapse-tags placeholder="Chọn"
                            no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                            <el-option v-for="item in list_trang_thai_can_bo" :key="item.value" :label="item.name"
                                :value="item.value">
                            </el-option>
                        </el-select>
                    </div>
                    <!-- Tùy chọn hiển thị -->
                    <div class="col-sm-4 timkiem">
                        <label class="typo__label">Nội dung hiển thị <span style="color:#DC0101">*</span></label>
                        <div>
                            <multiselect v-model="danhSachTimKiem" :options="ds_tim_kiem_tra_cuu_can_bo"
                                group-values="libs" group-label="selectAll" :group-select="true"
                                selectGroupLabel="Ấn để chọn tất cả" deselectGroupLabel="Ấn để bỏ chọn tất cả"
                                :limit="1" :limit-text="limitTextTieuChi" :close-on-select="false" :multiple="true"
                                @close="ChonTieuChi" :clear-on-select="false" :preserve-search="false"
                                deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                                :custom-label="setNameNamHoc" placeholder="Chọn" track-by="name">
                                <template v-if="danhSachDonVi.length>0" slot="selection"
                                    slot-scope="{ values, search, isOpen }">
                                    <span class="multiselect__single"
                                        v-if="values.length &amp;&amp; !isOpen">{{ danhSachTimKiem.length }}
                                        tiêu chí được chọn</span>
                                </template>
                                <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                                <span slot="noOptions">Danh sách trống</span>
                            </multiselect>
                        </div>
                    </div>
                    <!-- Hết tùy chọn hiển thị -->
                    <!-- Nâng cao -->
                    <div class="col-md-4 timKiem">
                        <label class="typo__label">Tìm kiếm nâng cao<span style="color:#DC0101">*</span></label>
                        <eselect style="width:100%" multiple collapseTags v-model="danhSachTimKiemNangCao"
                            :placeholder="'Chọn'" filterable :data="list_tim_kiem_nang_cao"
                            :fields="['name','value']" />
                    </div>
                </div>
                <div class="row">
                    <!-- Hết chức vụ -->
                    <div class="col-md-2" v-if="hienThiNangCao.gioiTinh">
                        <label>Giới tính</label>
                        <select v-model="nangCao.gioiTinh" class="form-control">
                            <option value="">Chọn giới tính</option>
                            <option value="1">Nam</option>
                            <option value="0">Nữ</option>
                        </select>
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.ngaySinh">
                        <label>Ngày sinh</label>
                        <date-picker :config="configDatePicker" placeholder="Chọn" v-model="nangCao.ngaySinh">
                        </date-picker>
                    </div>
                    <!-- Dân tộc -->
                    <div class="col-md-2" v-if="hienThiNangCao.doTuoi">
                        <label>Độ tuổi</label>
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.doTuoi" :placeholder="'Chọn'"
                            filterable :data="list_do_tuoi" :fields="['name','value']" />
                    </div>
                    <!-- Tôn giáo -->
                    <div class="col-md-2" v-if="hienThiNangCao.maTonGiao">
                        <label>Tôn giáo</label>
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.maTonGiao"
                            :placeholder="'Chọn'" filterable :data="list_ton_giao" :fields="['name','value']" />
                    </div>
                    <!-- Tôn giáo -->
                    <div class="col-md-2" v-if="hienThiNangCao.chucVu">
                        <label>Chức vụ</label>
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.chucVu" :placeholder="'Chọn'"
                            filterable :data="list_chucvu" :fields="['name','value']" />
                    </div>
                    <!-- Địa chỉ thường trú -->
                    <div class="col-md-2" v-if="hienThiNangCao.dchiThtru">
                        <label>Địa chỉ thường trú</label>
                        <input type="text" class="form-control" v-model="nangCao.dchiThtru"
                            placeholder="Nhập...">
                    </div>
                    <!-- Khu vực -->
                    <div class="col-md-2" v-if="hienThiNangCao.maKhuVuc">
                        <label>Khu vực</label>
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.maKhuVuc"
                            :placeholder="'Chọn'" filterable :data="list_khu_vuc" :fields="['name','value']" />
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.soCmnd">
                        <label>Số CMTND/TCC</label>
                        <input type="text" class="form-control" v-model="nangCao.soCmnd" placeholder="Nhập...">
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.dangVien">
                        <label>Đảng viên</label>
                        <select v-model="nangCao.dangVien"
                            class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                            style="width:100%">
                            <option value=''>Chọn</option>
                            <option value='1'>Có</option>
                            <option value='0'>Không</option>
                        </select>
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.bacLuong">
                        <label>Bậc lương</label>
                        <input type="number" class="form-control" v-model="nangCao.bacLuong"
                            placeholder="Nhập...">
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.heSoLuong">
                        <label>Hệ số lương</label>
                        <input type="number" class="form-control" v-model="nangCao.heSoLuong"
                            placeholder="Nhập...">
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.moetCode">
                        <label>Mã định danh</label>
                        <input type="text" class="form-control" v-model="nangCao.moetCode"
                            placeholder="Nhập...">
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.maMonHoc">
                        <label>Môn dạy</label>
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.maMonHoc"
                            :placeholder="'Chọn'" filterable :data="list_mon_day" :fields="['name','id']" />
                    </div>
                    <div class="col-md-2" v-if="hienThiNangCao.maDanToc">
                        <label>Dân tộc</label>
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.maDanToc"
                            :placeholder="'Chọn'" filterable :data="list_dan_toc" :fields="['name','value']" />
                    </div>
                    <div class="col-md-4" v-if="hienThiNangCao.maTrinhDoChuyenMonCaoNhat">
                        <label class="typo__label">Trình độ chuyên môn nghiệp vụ</label>
                        <eselect style="width:100%" multiple collapseTags v-model="nangCao.maTrinhDoChuyenMonCaoNhat"
                            :placeholder="'Chọn'" filterable :data="list_chuyen_mon" :fields="['name','value']" />
                    </div>
                </div>
                <!-- Hết tìm kiếm nâng cao -->
            </div>

            <!-- hết filter -->
            <!-- buttom -->
            <div class="row">
                <div class="col-md-12 text-center">
                    <button class="btn btn-success" @click.prevent="checkTruocKhiTim()">Tìm kiếm</button>
                    <button :disabled="list_giaovien.length==0" class="btn btn-info" v-on:click="CheckXuatExcel()">Xuất
                        Excel
                    </button>
                </div>
            </div>

            <!-- Bắt đầu danh sách học sinh-->
            <div class="row">
                <!-- Button -->
                <div class="col-md-12">
                    <div class="pull-right">
                        <button class="btn btn-danger" v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==20" @click.prevent="DeleteTeacher"
                            style="margin:2px 0; float:right">Xóa
                        </button>
                        <button class="btn btn-danger" v-if="thongtin.role!=5||thongtin.ma_so==86||thongtin.ma_so==20" style="margin:2px 4px; float:right"
                            @click.prevent="DeleteModetCode">Xóa mã định danh
                        </button>
                    </div>
                </div>
                <!-- Hết button -->
                <!-- Danh sách chi tiết -->
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr style="background:#e4ebf5">
                                    <th class="cg">
                                        <p>STT</p>
                                    </th>
                                    <th class="cg" v-for="(item,i) in cotHienThi" :key="i">
                                        <p>{{item.name}}</p>
                                    </th>
                                    <th class="cg">
                                        <p>Phân công giảng dạy</p>
                                    </th>
                                    <th class="cg">
                                        <p>Sửa</p>
                                    </th>
                                    <th class="cg">
                                        <input type="checkbox" v-model="slectAll" />
                                    </th>
                                </tr>
                            </thead>
                            <!-- <small>{{hangHienThi}}</small> -->
                            <tbody v-if="list_giaovien.length==0">
                                <tr>
                                    <td :colspan="danhSachTimKiem.length+4" class="cg">
                                        <p>Không có bản ghi nào</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody v-else>
                                <tr v-for="(item,i) in list_giaovien" :key="i">
                                    <td class="text-center">{{(currentPage-1)*(limit) + i+1}}
                                    </td>
                                    <td v-if="hangHienThi.tenTruongHoc">
                                        <p>{{item.tenTruongHoc}}</p>
                                    </td>
                                    <td v-if="hangHienThi.maGiaoVien">
                                        <a href="#"
                                            v-on:click.prevent="showInFo(item.canBoTheoNamId)">{{item.maGiaoVien}}</a>
                                    </td>
                                    <td v-if="hangHienThi.moetCode">
                                        <p>{{item.moetCode}}</p>
                                    </td>
                                    <td v-if="hangHienThi.tenCanBo" style="font-size:12px;text-align:left">
                                        <a href="#"
                                            v-on:click.prevent="showInFo(item.canBoTheoNamId)">{{item.tenCanBo}}</a>
                                    </td>
                                    <td v-if="hangHienThi.ngaySinh">
                                        <p>{{item.ngaySinh}}</p>
                                    </td>
                                    <td v-if="hangHienThi.gioiTinh">
                                        <p>{{item.gioiTinh}}</p>
                                    </td>
                                    <td v-if="hangHienThi.trangThai">
                                        <p>{{item.trangThai}}</p>
                                    </td>
                                    <td v-if="hangHienThi.maDanToc">
                                        <p>{{item.maDanToc}}</p>
                                    </td>
                                    <td v-if="hangHienThi.loaiCanBo">
                                        <p>{{item.loaiCanBo}}</p>
                                    </td>
                                    <td v-if="hangHienThi.chucVu">
                                        <p>{{item.chucVu}}</p>
                                    </td>
                                    <td v-if="hangHienThi.loaiHopDong">
                                        <p>{{item.loaiHopDong}}</p>
                                    </td>
                                    <td v-if="hangHienThi.maTrinhDoChuyenMonCaoNhat">
                                        <p>{{item.maTrinhDoChuyenMonCaoNhat}}</p>
                                    </td>
                                    <td v-if="hangHienThi.maMonHoc">
                                        <p>{{item.maMonHoc}}</p>
                                    </td>
                                    <td v-if="hangHienThi.soDienThoaiDiDong">
                                        <p>{{item.soDienThoaiDiDong}}</p>
                                    </td>
<!-- Hết nội dung hiển thị mặc định -->
                                    <!-- <td v-if="hangHienThi.capHoc">
                                        <p>{{item.capHoc}}</p>
                                    </td>
                                    <td v-if="hangHienThi.doTuoi">
                                        <p>{{item.doTuoi}}</p>
                                    </td>
                                    <td v-if="hangHienThi.trinhDoDaoTaoCnChinh">
                                        <p>{{item.trinhDoDaoTaoCnChinh}}</p>
                                    </td>
                                    <td v-if="hangHienThi.maTonGiao">
                                        <p>{{item.maTonGiao}}</p>
                                    </td>
                                    <td v-if="hangHienThi.bacLuong">
                                        <p>{{item.bacLuong}}</p>
                                    </td>
                                    <td v-if="hangHienThi.heSoLuong">
                                        <p>{{item.heSoLuong}}</p>
                                    </td>
                                    <td v-if="hangHienThi.ngayTuyenDung">
                                        <p>{{item.ngayTuyenDung}}</p>
                                    </td>
                                    <td v-if="hangHienThi.ngayVaoBienChe">
                                        <p>{{item.ngayVaoBienChe}}</p>
                                    </td>
                                    <td v-if="hangHienThi.noiDungKhenThuong">
                                        <p>{{item.noiDungKhenThuong}}</p>
                                    </td>
                                    <td v-if="hangHienThi.gvDayGioi">
                                        <p>{{item.gvDayGioi}}</p>
                                    </td>
                                    <td v-if="hangHienThi.dchiThtru">
                                        <p>{{item.dchiThtru}}</p>
                                    </td>
                                    <td v-if="hangHienThi.soCmnd">
                                        <p>{{item.soCmnd}}</p>
                                    </td>
                                    <td v-if="hangHienThi.ngayCapCmnd">
                                        <p>{{item.ngayCapCmnd}}</p>
                                    </td>
                                    <td v-if="hangHienThi.noiCapCmnd">
                                        <p>{{item.noiCapCmnd}}</p>
                                    </td>
                                    <td v-if="hangHienThi.email">
                                        <p>{{item.email}}</p>
                                    </td>
                                    <td v-if="hangHienThi.tenHieuTruong">
                                        <p>{{item.tenHieuTruong}}</p>
                                    </td>
                                    <td v-if="hangHienThi.dangVien">
                                        <p>{{item.dangVien}}</p>
                                    </td>
                                    <td v-if="hangHienThi.tenCsDaoTaoBd">
                                        <p>{{item.tenCsDaoTaoBd}}</p>
                                    </td>
                                    <td v-if="hangHienThi.soDienThoaiDiDong">
                                        <p>{{item.soDienThoaiDiDong}}</p>
                                    </td> -->
                                    <td class="text-center">
                                        <a v-if="item.loaiCanBo!='Nhân viên'" href="#" class="btn btn-info"
                                            v-on:click.prevent="showInFoPcgd(item)">Xem chi
                                            tiết</a>
                                    </td>
                                    <td class="text-center">
                                        <a title="Chỉnh sửa" href="#"
                                            v-on:click.prevent="ShowUpdate(item.canBoTheoNamId)"><i
                                                class="far fa-edit"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" v-model="lsDelete" :value="item.canBoTheoNamId" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Phân trang -->
                    <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)"></Page>
                    <!-- Hết phân trang -->
                    <!-- Thông tin giáo viên -->
                    <!-- <div v-if="showInFoGiaoVien"> -->
                    <info-giaovien :show="showInFoGiaoVien" :namhoc="namHoc" :item="dataInFoGiaoVien"
                        @success="onUpdatedData($event)" @close="showInFoGiaoVien=false"></info-giaovien>
                    <!-- </div> -->
                    <!-- Hết thông tin học sinh -->
                    <!-- Chỉnh sửa giáo viên -->
                    <!-- <div v-if="show_update"> -->
                    <update-giaovien :show="show_update" :item="dataUpdateGiaoVien" @close="show_update=false"
                        @success="dongSuaGv()">
                    </update-giaovien>
                    <!-- </div> -->
                    <!-- Hết chỉnh sửa thông tin giáo viên -->
                    <!-- show lỗi xóa -->
                    <div>
                        <div id="modal_import_file" ref="modal_import_file" class="modal fade" style="font-size:18px;">
                            <div class="modal-dialog" style="width:60%">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" v-on:click="close()"
                                            aria-hidden="true">
                                            &times;
                                        </button>
                                        <h5 class="modal-title text-uppercase">Thông báo</h5>
                                        <p>{{loinhanloi}}</p>
                                    </div>
                                    <div class="modal-body" style="width: 100%;margin: 0 auto;">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <thead>
                                                            <tr style="background:#e4ebf5">
                                                                <th class="cg">
                                                                    <p>STT</p>
                                                                </th>
                                                                <th class="cg">
                                                                    <p>Mã giáo viên</p>
                                                                </th>
                                                                <th class="cg">
                                                                    <p>Mã lớp chủ nhiệm</p>
                                                                </th>
                                                                <th class="cg">
                                                                    <p>Tên lớp</p>
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <!-- <small>{{hangHienThi}}</small> -->
                                                        <tbody v-if="list_loixoa_giaovien.length==0">
                                                            <tr>
                                                                <td colspan="5" class="cg">
                                                                    <p>Không có bản ghi nào</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                        <tbody v-else>
                                                            <tr v-for="(item,i) in list_loixoa_giaovien" :key="i">
                                                                <td class="text-center">{{i+1}}
                                                                </td>
                                                                <td>
                                                                    <p>{{item.maGvcnCn}}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{item.maLopHoc}}</p>
                                                                </td>
                                                                <td>
                                                                    <p>{{item.tenLopHoc}}</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer clearfix">
                                        <button type="button" class="btn btn-default" @click.prevent="close"
                                            data-dismiss="modal">Đóng
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- hết show lỗi xóa -->
                </div>
                <!-- Hết danh sách chi tiết -->
            </div>
            <!-- Hết danh sách học sinh -->
        </div>
        <div id="phanconggiangday" ref="phanconggiangday" class="modal fade" style="font-size:18px;">
            <div class="modal-dialog" style="width:95%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><b>Phân công giảng dạy: </b> {{tenGvPcgd}} ({{maGvPcgd}})</h5>
                    </div>
                    <div class="modal-body" style="width: 100%;margin: 0 auto;">
                        <div style="height: 65vh;overflow: scroll;">
                            <div class="row" style="padding-bottom:200px">
                                <div class="col-md-6">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg" rowspan="2">
                                                    <p>STT</p>
                                                </th>
                                                <th class="cg" colspan="2">
                                                    <p>Học kỳ I</p>
                                                </th>
                                                <th class="cg" rowspan="2">
                                                    <p>Thao tác</p>
                                                </th>
                                            </tr>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg">
                                                    <p>Lớp học <span style="color:#DC0101"> *</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Môn học <span style="color:#DC0101"> *</span></p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_phan_cong_giang_day_hk1.length==0">
                                            <tr>
                                                <td class="text-center bt" colspan="4">
                                                    <p>Không có bản ghi nào</p>
                                                    <a href="#" title="thêm" @click.prevent="themItemPcgdHk1()"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in list_phan_cong_giang_day_hk1" :key="i">
                                                <td class="text-center">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <div v-if="item.chinhsua">
                                                        <el-select v-model="item.maLopHoc"
                                                            @change="ChonLopHocKy1(item,i)" filterable collapse-tags
                                                            placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="item in list_lop_hoc" :key="item.value"
                                                                :label="item.name" :value="item.value">
                                                            </el-option>
                                                        </el-select>
                                                    </div>
                                                    <div v-else>

                                                        <input type="text" class="form-control" :value="item.tenLopHoc"
                                                            disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div v-if="item.chinhsua">
                                                        <el-select v-model="item.maMonHoc"
                                                            @change="chinhSuaPcgdHk1(item,i)" filterable collapse-tags
                                                            placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="item in item.list_mon_hoc"
                                                                :key="item.value" :label="item.name"
                                                                :value="item.value">
                                                            </el-option>
                                                        </el-select>
                                                    </div>
                                                    <div v-else>

                                                        <input type="text" class="form-control" :value="item.tenMonHoc"
                                                            disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center bt">
                                                    <a href="#" title="Chỉnh sửa"
                                                        @click.prevent="updateItemPcgdHk1(item,i)"><b><i
                                                                style="color:blue; background: gainsboro;"
                                                                class="far fa-edit"></i></b> </a>
                                                    <a href="#" title="xóa"
                                                        @click.prevent="xoaItemPcgdHk1(item,i)"><b><i
                                                                style="color:#DC0101; background: gainsboro;"
                                                                class="fas fa-trash-alt"></i></b> </a>
                                                    <a href="#" v-show="i+1==list_phan_cong_giang_day_hk1.length"
                                                        title="thêm" @click.prevent="themItemPcgdHk1(i)"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg" rowspan="2">
                                                    <p>STT</p>
                                                </th>
                                                <th class="cg" colspan="2">
                                                    <p>Học kỳ II</p>
                                                </th>
                                                <th class="cg" rowspan="2">
                                                    <p>Thao tác</p>
                                                </th>
                                            </tr>
                                            <tr style="background:#e4ebf5">
                                                <th class="cg">
                                                    <p>Lớp học <span style="color:#DC0101"> *</span></p>
                                                </th>
                                                <th class="cg">
                                                    <p>Môn học <span style="color:#DC0101"> *</span></p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_phan_cong_giang_day_hk2.length==0">
                                            <tr>
                                                <td class="cg bt" colspan="4">
                                                    <p>Không có bản ghi nào</p>
                                                    <a href="#" title="thêm" @click.prevent="themItemPcgdHk2()"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in list_phan_cong_giang_day_hk2" :key="i">
                                                <td class="text-center">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td>
                                                    <div v-if="item.chinhsua">
                                                        <el-select v-model="item.maLopHoc"
                                                            @change="ChonLopHocKy2(item,i)" filterable collapse-tags
                                                            placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="item in list_lop_hoc" :key="item.value"
                                                                :label="item.name" :value="item.value">
                                                            </el-option>
                                                        </el-select>
                                                    </div>
                                                    <div v-else>

                                                        <input type="text" class="form-control" :value="item.tenLopHoc"
                                                            disabled>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div v-if="item.chinhsua">
                                                        <el-select v-model="item.maMonHoc"
                                                            @change="chinhSuaPcgdHk2(item,i)" filterable collapse-tags
                                                            placeholder="Chọn" no-data-text="Không có dữ liệu"
                                                            no-match-text="Không có dữ liệu phù hợp">
                                                            <el-option v-for="item in item.list_mon_hoc"
                                                                :key="item.value" :label="item.name"
                                                                :value="item.value">
                                                            </el-option>
                                                        </el-select>
                                                    </div>
                                                    <div v-else>

                                                        <input type="text" class="form-control" :value="item.tenMonHoc"
                                                            disabled>
                                                    </div>
                                                </td>
                                                <td class="text-center bt">
                                                    <a href="#" title="Chỉnh sửa"
                                                        @click.prevent="updateItemPcgdHk2(item,i)"><b><i
                                                                style="color:blue; background: gainsboro;"
                                                                class="far fa-edit"></i></b> </a>
                                                    <a href="#" title="xóa"
                                                        @click.prevent="xoaItemPcgdHk2(item,i)"><b><i
                                                                style="color:#DC0101; background: gainsboro;"
                                                                class="fas fa-trash-alt"></i></b> </a>
                                                    <a href="#" v-show="i+1==list_phan_cong_giang_day_hk2.length"
                                                        title="thêm" @click.prevent="themItemPcgdHk2(i)"><b><i
                                                                style="color:blue; background: chartreuse;"
                                                                class="fas fa-plus"></i></b> </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="col-md-12">
                                    <p><span><b style="color:blue">Ghi chú: </b> Sau khi chọn dữ liệu môn học, thông tin dữ liệu của bản ghi sẽ được tự động cập nhật.</span></p>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- hết template -->
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import constant from '../../utils/constant';
    import moment from "moment";
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import ThongTinGV from './CanBoGiaoVien/ThongTinGiaoVien'
    import UpdateGiaoVien from './ChinhSuaTraCuuCanBo'
    import ChinhSua from './ChinhSuaTraCuuCanBo'
    import datePicker from 'vue-bootstrap-datetimepicker';
    import api from '../api';
    import Page from "../ui/PagingCustom";
    import dialog from '../../utils/dialog';
    import VueAlertify from "vue-alertify";
    import ESelectVue from '../ui/ESelect.vue';
    import utils from '../../utils';
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
    export default {
        props: ['trangcu'],
        components: {
            Multiselect,
            datePicker,
            'eselect': ESelectVue,
            Page: Page,
            'info-giaovien': ThongTinGV,
            'update-giaovien': UpdateGiaoVien,
        },
        data() {
            return {
                list_lop_hoc: [],
                loinhanloi: "",
                maTruongHocPcgd: "",
                tenGvPcgd: "",
                maGvPcgd: "",
                show_loi_xoa: false,
                list_phan_cong_giang_day: [],
                list_phan_cong_giang_day_hk1: [],
                list_phan_cong_giang_day_hk2: [],
                list_loixoa_giaovien: [],
                danhSachTimKiemNangCao: [],
                hienThiNangCao: {
                    ngaySinh: false,
                    maTonGiao: false,
                    chucVu: false,
                    dchiThtru: false,
                    maKhuVuc: false,
                    gioiTinh: false,
                    trangThai: false,
                    dangVien: false,
                    soCmnd: false,
                    doTuoi: false,
                    maDanToc: false,
                    bacLuong: false,
                    heSoLuong: false,
                },
                list_tim_kiem_nang_cao: [{
                        value: 'ngaySinh',
                        name: "Ngày sinh"
                    },
                    {
                        value: 'maTonGiao',
                        name: "Tôn giáo"
                    },
                    {
                        value: 'dchiThtru',
                        name: "Địa chỉ thường trú"
                    },
                    {
                        value: 'maKhuVuc',
                        name: "Khu vực"
                    },
                    // {
                    //     value: 'trinhDoDaoTaoCnChinh',
                    //     name: "Trình độ đào tạo chuyên ngành chính"
                    // },
                    {
                        value: 'dangVien',
                        name: "Đảng viên"
                    },
                    // {
                    //     value: 'soCmnd',
                    //     name: "Số CMND"
                    // },
                    {
                        value: 'doTuoi',
                        name: "Độ tuổi"
                    },
                    {
                        value: 'bacLuong',
                        name: "Bậc lương"
                    },
                    {
                        value: 'heSoLuong',
                        name: "Hệ số lương"
                    },
                    {
                        value: 'maTrinhDoChuyenMonCaoNhat',
                        name: "Trình độ chuyên môn NV cao nhất"
                    },
                    {
                        value: 'moetCode',
                        name: "Mã định danh"
                    },
                    {
                        value: 'maMonHoc',
                        name: "Môn dạy"
                    },
                    {
                        value: 'chucVu',
                        name: "Chức vụ"
                    },
                    {
                        value: 'maDanToc',
                        name: "Dân tộc"
                    },
                ],
                timKiemNangCao: true,
                nangCao: {
                    ngaySinh: "",
                    maTonGiao: "",
                    chucVu: "",
                    maDanToc: "",
                    dchiThtru: "",
                    maKhuVuc: "",
                    gioiTinh: "",
                    dangVien: '',
                    soCmnd: '',
                    doTuoi: '',
                    bacLuong: '',
                    heSoLuong: '',
                    maTrinhDoChuyenMonCaoNhat: '',
                    trinhDoDaoTaoCnChinh: '',
                    moetCode: '',
                    maMonHoc: '',
                },
                configDatePicker: {
                    format: 'DD/MM/YYYY',
                    useCurrent: false,
                    showTodayButton: true,
                    locale: 'vi'
                },
                danhSachTimKiem: [],
                danhSachTimKiemTruong: [
                    {
                        key: 'maGiaoVien',
                        name: "Mã cán bộ",
                        stt: 2
                    },
                    {
                        key: 'moetCode',
                        name: "Mã định danh",
                        stt: 3
                    },
                    {
                        key: 'tenCanBo',
                        name: "Họ tên",
                        stt: 4
                    },
                    {
                        key: 'ngaySinh',
                        name: "Ngày sinh",
                        stt: 5
                    },
                    {
                        key: 'gioiTinh',
                        name: "Giới tính",
                        stt: 6
                    },
                    {
                        key: 'trangThai',
                        name: "Trạng thái",
                        stt: 7
                    },
                    {
                        key: 'maDanToc',
                        name: "Dân tộc",
                        stt: 8
                    },
                    {
                        key: 'loaiCanBo',
                        name: "Vị trí việc làm",
                        stt: 9
                    },
                    {
                        key: 'chucVu',
                        name: "Nhóm chức vụ",
                        stt: 10
                    },
                    {
                        key: 'loaiHopDong',
                        name: "Hình thức hợp đồng",
                        stt: 11
                    },
                    {
                        key: 'maTrinhDoChuyenMonCaoNhat',
                        name: "T.Độ chuyên môn nghiệp vụ",
                        stt: 12
                    },
                    {
                        key: 'maMonHoc',
                        name: "Môn dạy",
                        stt: 13
                    },
                ],
                danhSachTimKiemSo: [{
                        key: 'tenTruongHoc',
                        name: "Tên trường",
                        stt: 1
                    },
                    {
                        key: 'maGiaoVien',
                        name: "Mã cán bộ",
                        stt: 2
                    },
                    {
                        key: 'moetCode',
                        name: "Mã định danh",
                        stt: 3
                    },
                    {
                        key: 'tenCanBo',
                        name: "Họ tên",
                        stt: 4
                    },
                    {
                        key: 'ngaySinh',
                        name: "Ngày sinh",
                        stt: 5
                    },
                    {
                        key: 'gioiTinh',
                        name: "Giới tính",
                        stt: 6
                    },
                    {
                        key: 'trangThai',
                        name: "Trạng thái",
                        stt: 7
                    },
                    {
                        key: 'maDanToc',
                        name: "Dân tộc",
                        stt: 8
                    },
                    {
                        key: 'loaiCanBo',
                        name: "Vị trí việc làm",
                        stt: 9
                    },
                    {
                        key: 'chucVu',
                        name: "Nhóm chức vụ",
                        stt: 10
                    },
                    {
                        key: 'loaiHopDong',
                        name: "Hình thức hợp đồng",
                        stt: 11
                    },
                    {
                        key: 'maTrinhDoChuyenMonCaoNhat',
                        name: "T.Độ chuyên môn nghiệp vụ",
                        stt: 12
                    },
                    {
                        key: 'maMonHoc',
                        name: "Môn dạy",
                        stt: 13
                    },
                ],
                cotHienThi: [],
                hangHienThi: {},
                ds_tim_kiem_tra_cuu_can_bo: [{
                    selectAll: 'Chọn tất cả',
                    libs:[]
                }],
                ds_don_vi_custom: [],
                list_truong_hoc_custom: [],
                ds_cap_hoc_custom: [{
                    selectAll: 'Chọn tất cả',
                    libs: []
                }],
                capHocDangNhap: "",
                tenDonViDangNhap: "",
                // thông tin người dùng
                slectAll: false,
                show_update: false,
                showInFoGiaoVien: false,
                current_view: ChinhSua,
                dataInFoGiaoVien: {},
                thongtin: {},
                dataHocSinh: {},
                date: new Date(),
                list_truong_hoc: [],
                list_giaovien: [],
                list_don_vi: [],
                lsDelete: [],
                start: 0,
                total_rows: 0,
                currentPage: 1,
                limit: 25,
                // dùng trong filter
                namHocHienTai: "",
                trangThai: "",
                tuKhoa: "",
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_truong_hoc: [],
                namHoc: "",
                danhSachDonVi: [],
                danhSachCapHoc: [],
                danhSachTruongHoc: [],
                danhSachNamHoc: [],
                list_truong_hoc: [],
                loaiCanBo: "",
                chucVu: "",
                maDanToc: "",
                chuyenNganhDaoTao: "",
                danhSachChucVu: "",
                dataUpdateGiaoVien: {},
                maChuyenNganhDaoTao: "",
                // trinhDoDaoTaoCnChinh: "",
                chuyenNganh: [],
                gioiTinh: "",
                list_nam_hoc: constant.LIST_YEARS_FULL,
                // Check xem trang từ bên kết chuyển dữ liệu sang hay không
                chuyenhuong: {},
                isDisablePhong: false,
                trangbatdau: false,
                list_mon_hoc: [],
                list_trang_thai_can_bo: [],
                list_chucvu: [],
                list_ton_giao: [],
                list_dan_toc: [],
                list_chuyen_mon: [],
                list_cap_hoc: window.listCapHoc,
                list_mon_day: constant.danh_sach_mon_hoc_tra_cuu_hoc_tap,
                list_chuyen_nganh: constant.list_chuyen_nganh,
                list_khu_vuc: constant.KHU_VUC,
                list_do_tuoi: constant.DO_TUOI,
            }
        },
        watch: {
            danhSachTimKiemNangCao: function (newVal) {
                if (2 > 0) {
                    console.log("tìm:");
                    let noidung_hienthi = newVal;
                    this.hienThiNangCao.ngaySinh = false;
                    this.hienThiNangCao.maTonGiao = false;
                    this.hienThiNangCao.chucVu = false;
                    this.hienThiNangCao.maDanToc = false;
                    this.hienThiNangCao.loaiCanBo = false;
                    this.hienThiNangCao.dchiThtru = false;
                    this.hienThiNangCao.maKhuVuc = false;
                    this.hienThiNangCao.gioiTinh = false;
                    this.hienThiNangCao.trangThai = false;
                    this.hienThiNangCao.dangVien = false;
                    this.hienThiNangCao.soCmnd = false;
                    this.hienThiNangCao.doTuoi = false;
                    this.hienThiNangCao.bacLuong = false;
                    this.hienThiNangCao.heSoLuong = false;
                    this.hienThiNangCao.maTrinhDoChuyenMonCaoNhat = false;
                    // this.hienThiNangCao.trinhDoDaoTaoCnChinh = false;
                    this.hienThiNangCao.moetCode = false;
                    this.hienThiNangCao.maMonHoc = false;
                    for (let i = 0; i < noidung_hienthi.length; i++) {
                        if (noidung_hienthi[i] == "ngaySinh") {
                            this.hienThiNangCao.ngaySinh = true
                        }
                        if (noidung_hienthi[i] == "maTonGiao") {
                            this.hienThiNangCao.maTonGiao = true
                        }
                        if (noidung_hienthi[i] == "chucVu") {
                            this.hienThiNangCao.chucVu = true
                        }
                        if (noidung_hienthi[i] == "maDanToc") {
                            this.hienThiNangCao.maDanToc = true
                        }
                        if (noidung_hienthi[i] == "loaiCanBo") {
                            this.hienThiNangCao.loaiCanBo = true
                        }
                        if (noidung_hienthi[i] == "dchiThtru") {
                            this.hienThiNangCao.dchiThtru = true
                        }
                        if (noidung_hienthi[i] == "maKhuVuc") {
                            this.hienThiNangCao.maKhuVuc = true
                        }
                        if (noidung_hienthi[i] == "gioiTinh") {
                            this.hienThiNangCao.gioiTinh = true
                        }
                        if (noidung_hienthi[i] == "trangThai") {
                            this.hienThiNangCao.trangThai = true
                        }
                        if (noidung_hienthi[i] == "dangVien") {
                            this.hienThiNangCao.dangVien = true
                        }
                        if (noidung_hienthi[i] == "soCmnd") {
                            this.hienThiNangCao.soCmnd = true
                        }
                        if (noidung_hienthi[i] == "doTuoi") {
                            this.hienThiNangCao.doTuoi = true
                        }
                        if (noidung_hienthi[i] == "bacLuong") {
                            this.hienThiNangCao.bacLuong = true
                        }
                        if (noidung_hienthi[i] == "heSoLuong") {
                            this.hienThiNangCao.heSoLuong = true
                        }
                        if (noidung_hienthi[i] == "maTrinhDoChuyenMonCaoNhat") {
                            this.hienThiNangCao.maTrinhDoChuyenMonCaoNhat = true
                        }
                        if (noidung_hienthi[i] == "trinhDoDaoTaoCnChinh") {
                            this.hienThiNangCao.trinhDoDaoTaoCnChinh = true
                        }
                        if (noidung_hienthi[i] == "moetCode") {
                            this.hienThiNangCao.moetCode = true
                        }
                        if (noidung_hienthi[i] == "maMonHoc") {
                            this.hienThiNangCao.maMonHoc = true
                        }
                    }
                    console.log(JSON.stringify(this.hienThiNangCao));
                }
            },
            danhSachChucVu: function (newVal) {
                console.log("chọn chức vụ:");
                if (newVal) {
                    this.chucVu = newVal.value;
                } else {
                    this.chucVu = "";
                }
                console.log("chức vự:" + JSON.stringify(this.chucVu));
            },
            slectAll: function (newVal) {
                if (newVal) {
                    this.lsDelete = [];
                    for (let i = 0; i < this.list_giaovien.length; i++) {
                        this
                            .lsDelete
                            .push(this.list_giaovien[i].canBoTheoNamId);
                    }
                } else {
                    this.lsDelete = [];
                }
            },
            danhSachDonVi: function (newVal) {},
            danhSachCapHoc: function (newVal) {},
            danhSachTruongHoc: function (newVal) {},
            danhSachNamHoc: function (newVal) {
                console.log("watch Năm học");
                this.namHoc = "";
                this.params = {};
                if (newVal) {
                    this.namHoc = newVal
                        .id
                    console
                        .log("map xong:" + JSON.stringify(this.namHoc));
                } else {
                    console.log("Năm học trống");
                    this
                        .$alertify
                        .error("Vui lòng chọn năm học để tìm kiếm");
                }
            },
            chuyenNganhDaoTao: function (newVal) {
                console.log("chọn chuyên ngành đào tạo");
                if (newVal) {
                    this.maChuyenNganhDaoTao = newVal.maCnganhDtao;
                    console.log("map xong:" + JSON.stringify(this.maChuyenNganhDaoTao));
                } else {
                    this.maChuyenNganhDaoTao = "";
                }
            },
            slectAll: function (newVal) {
                if (newVal) {
                    this.lsDelete = [];
                    for (let i = 0; i < this.list_giaovien.length; i++) {
                        this
                            .lsDelete
                            .push(this.list_giaovien[i].canBoTheoNamId);
                    }
                } else {
                    this.lsDelete = [];
                }
            }
        },
        mounted: function () {
            this.ganDuLieuSME();
            this.list_chucvu = this.list_chucvu.filter(item => item.value !== "");
            this.list_chuyen_mon = this.list_chuyen_mon.filter(item => item.value !== "");
            for (let i = 0; i < this.list_chucvu.length; i++) {
                this.list_chucvu[i].value = parseInt(this.list_chucvu[i].value);
            }
            this.list_do_tuoi = this.list_do_tuoi.filter(item => item.value !== "");
            this.list_ton_giao = this.list_ton_giao.filter(item => item.value !== "");
            this.list_dan_toc = this.list_dan_toc.filter(item => item.value !== "");

            this.list_chuyen_nganh = this.list_chuyen_nganh.filter(item => item.id !== "");
            this.list_mon_hoc = this.list_mon_hoc.filter(item => item.value !== "");
            this.thongtin = JSON.parse(window.userInfo);
            if (this.thongtin.role == 5) {
                this.danhSachTimKiem = this.danhSachTimKiemTruong;
            } else {
                this.danhSachTimKiem = this.danhSachTimKiemSo
            }
            this.ds_cap_hoc_custom[0].libs = this.list_cap_hoc;
            if (this.thongtin.role == 4) {
                this.isDisablePhong = true;
            }
            if (this.thongtin.role == 5) {
                this.bindCapHocDangNhap();
            }
            if(this.thongtin.role==2&&this.thongtin.ma_so==19){
                this.danhSachTimKiem.push(
                    {
                        key: 'soDienThoaiDiDong',
                        name: "Số điện thoại",
                        stt: 14
                    },)
                this.ds_tim_kiem_tra_cuu_can_bo[0].libs = constant.danh_sach_tim_kiem_danh_sach_can_bo_cap_so;
            }
            else{
                this.ds_tim_kiem_tra_cuu_can_bo[0].libs = constant.danh_sach_tim_kiem_danh_sach_can_bo;
            }
            this.namHocHienTai = this
                .date
                .getFullYear();
            let thangNay = this
                .date
                .getMonth();
            thangNay = parseInt(thangNay) + 1;
            if (thangNay > 8) {
                console.log("tháng > 7");
                // tháng lớn hơn 7. lấy năm nay là năm học hiện tại
            } else {
                this.namHocHienTai -= 1;
                console.log("tháng không lớn hơn 7");
                // tháng nhỏ hơn hoặc bằng 7. lấy năm ngoái là năm học hiện tại
            }
            this.findNamHoc();
            this.getTruongHoc();
            this.getDonVi(() => {
                if (this.trangcu == "[]") {
                    // this.getData();
                } else {
                    console.log("Trang cũ");
                    this.chuyenhuong = JSON.parse(this.trangcu);
                    console.log("chuyển hướng:");
                    console.log(JSON.stringify(this.chuyenhuong));
                    this.chuyenHuong();
                }
            });
            // $("#modal_import_file").modal();
            $(this.$refs.modal_import_file).on("hidden.bs.modal", this.close);
            $(this.$refs.modal_nl).on("hidden.bs.modal", this.closemodal3);
            this.bindCotHeader();
            this.ganCot();
        },
        methods: {
            ganDuLieuSME() {
                let tmp = localStorage["danh_sach_mon_hoc_sme"];
                if (tmp) {
                    this.list_mon_hoc = JSON.parse(localStorage["danh_sach_mon_hoc_sme"]);
                    this.list_trang_thai_can_bo = JSON.parse(localStorage["danh_sach_trang_thai_can_bo_sme"]);
                    this.list_chucvu = JSON.parse(localStorage["danh_sach_chuc_vu_sme"]);
                    this.list_ton_giao = JSON.parse(localStorage["danh_sach_ton_giao_sme"]);
                    this.list_dan_toc = JSON.parse(localStorage["danh_sach_dan_toc_sme"]);
                    this.list_chuyen_mon = JSON.parse(localStorage["danh_sach_trinh_do_chuyen_mon_sme"]);
                }
            },
            ChonLopHocKy1(e, p) {
                console.log("chọn lớp học ");
                console.log(JSON.stringify(e));
                this.list_phan_cong_giang_day_hk1[p].maMonHoc = "";
                this.list_phan_cong_giang_day_hk1[p].tenMonHoc = "[Chưa chọn]";
                this.list_phan_cong_giang_day_hk1[p].list_mon_hoc = [];
                if (e.type == 1) {
                    this.updateItemPcgdHk1(e, p);
                } else {
                    let params = {
                        "maLopHoc": e.maLopHoc,
                    }
                    rest_api.get("/csdlgd-admin/lopMon/byMaLopHoc", params, data => {
                        if (data.data.rc == 0) {
                            console.log("data lớp môn trả về:");
                            let dt_dm = data.data.rows;
                            for (let i = 0; i < dt_dm.length; i++) {
                                let obj = {
                                    name: dt_dm[i].tenMonHoc,
                                    value: dt_dm[i].maMonHoc,
                                    lopMonId: dt_dm[i].lopMonId,
                                };
                                this.list_phan_cong_giang_day_hk1[p].list_mon_hoc.push(obj)
                            }
                            console.log("Môn của nó:");
                            console.log(JSON.stringify(this.list_phan_cong_giang_day_hk1[p].list_mon_hoc));
                        } else {
                            this.$alertify.error(data.data.rd);
                        }
                    });
                }
            },
            ChonLopHocKy2(e, p) {
                console.log("chọn lớp học ");
                console.log(JSON.stringify(e));
                this.list_phan_cong_giang_day_hk2[p].maMonHoc = "";
                this.list_phan_cong_giang_day_hk2[p].tenMonHoc = "[Chưa chọn]";
                this.list_phan_cong_giang_day_hk2[p].list_mon_hoc = [{
                    name: "Chọn",
                    value: ""
                }];
                if (e.type == 1) {
                    this.updateItemPcgdHk2(e, p);
                } else {
                    let params = {
                        "maLopHoc": e.maLopHoc,
                    }
                    rest_api.get("/csdlgd-admin/lopMon/byMaLopHoc", params, data => {
                        console.log("data lớp môn trả về:");
                        console.log(JSON.stringify(data));
                        if (data.data.rc == 0) {
                            let dt_dm = data.data.rows;
                            for (let i = 0; i < dt_dm.length; i++) {
                                let obj = {
                                    name: dt_dm[i].tenMonHoc,
                                    value: dt_dm[i].maMonHoc,
                                    lopMonId: dt_dm[i].lopMonId,
                                };
                                this.list_phan_cong_giang_day_hk2[p].list_mon_hoc.push(obj)
                            }
                        } else {
                            this.$alertify.error(data.data.rd);
                        }
                    });
                }
            },
            chinhSuaPcgdHk1(e, i) {
                if (e.maMonHoc == "" || !e.maMonHoc) {
                    this.$alertify.error("Thiếu mã môn học");
                    return;
                }
                if (e.type == 1) {
                    console.log("Sửa");
                    console.log(JSON.stringify(e));
                    let lopMonId = "";
                    let list_lop_mon = e.list_mon_hoc;
                    console.log(JSON.stringify(list_lop_mon));
                    for (let y = 0; y < list_lop_mon.length; y++) {
                        if (list_lop_mon[y].value == e.maMonHoc) {
                            lopMonId = list_lop_mon[y].lopMonId;
                        }
                    }
                    console.log("object" + lopMonId);
                    let params = {
                        "id": e.lopMonGiaoVienId,
                        "maLopHoc": e.maLopHoc,
                        "maMonHoc": e.maMonHoc,
                        "maGiaoVien": e.maGiaoVien,
                        "hocKy": e.hocKy,
                        "lopMonId": lopMonId,
                    }

                    const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/lopMonGiaoVien/update", params, data => {
                            loading.close();
                            console.log("data update trả về:");
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.$alertify.success("Chỉnh sửa thành công");
                                this.list_phan_cong_giang_day_hk1[i].chinhsua = false;
                                let obj = {
                                    maGiaoVien: this.maGvPcgd,
                                    tenCanBo: this.tenGvPcgd,
                                    maTruongHoc: this.maTruongHocPcgd,
                                }
                                this.showInFoPcgd(obj)
                            } else {
                                this.$alertify.error(data.data.rd);
                            }
                        });
                    // utils.confirmDialog("Xác nhận chỉnh sửa thông tin", "Đồng ý", () => {

                    // })
                } else {
                    let lopMonId = "";
                    let list_lop_mon = e.list_mon_hoc;
                    for (let y = 0; y < list_lop_mon.length; y++) {
                        if (list_lop_mon[y].value == e.maMonHoc) {
                            lopMonId = list_lop_mon[y].lopMonId;
                        }
                    }
                    let params = {
                        "maLopHoc": e.maLopHoc,
                        "maMonHoc": e.maMonHoc,
                        "maGiaoVien": e.maGiaoVien,
                        "hocKy": e.hocKy,
                        "lopMonId": lopMonId,
                        "maTruong": this.maTruongHocPcgd,
                    }
                    utils.confirmDialog("Xác nhận thêm mới thông tin", "Đồng ý", () => {

                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/lopMonGiaoVien/create", params, data => {
                            loading.close();
                            if (data.data.rc == 0) {
                                this.$alertify.success("Thêm thành công");
                                this.list_phan_cong_giang_day_hk1[i].chinhsua = false;
                                let obj = {
                                    maGiaoVien: this.maGvPcgd,
                                    tenCanBo: this.tenGvPcgd,
                                    maTruongHoc: this.maTruongHocPcgd
                                }
                                this.showInFoPcgd(obj)
                            } else {
                                this.$alertify.error(data.data.rd);
                            }
                        });

                    })

                }
            },
            chinhSuaPcgdHk2(e, i) {
                if (e.maMonHoc == "" || !e.maMonHoc) {
                    this.$alertify.error("Thiếu mã môn học");
                    return;
                }
                if (e.type == 1) {

                    let lopMonId = "";
                    let list_lop_mon = e.list_mon_hoc;
                    for (let y = 0; y < list_lop_mon.length; y++) {
                        if (list_lop_mon[y].value == e.maMonHoc) {
                            lopMonId = list_lop_mon[y].lopMonId;
                        }
                    }
                    let params = {
                        "id": e.lopMonGiaoVienId,
                        "maLopHoc": e.maLopHoc,
                        "maMonHoc": e.maMonHoc,
                        "maGiaoVien": e.maGiaoVien,
                        "hocKy": e.hocKy,
                        "lopMonId": lopMonId,
                    }


                    const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/lopMonGiaoVien/update", params, data => {
                            loading.close();
                            console.log("data update trả về:");
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.$alertify.success("Chỉnh sửa thành công");
                                this.list_phan_cong_giang_day_hk2[i].chinhsua = false;
                                let obj = {
                                    maGiaoVien: this.maGvPcgd,
                                    tenCanBo: this.tenGvPcgd,
                                    maTruongHoc: this.maTruongHocPcgd,
                                }
                                this.showInFoPcgd(obj)
                            } else {
                                this.$alertify.error(data.data.rd);
                            }
                        });
                    // utils.confirmDialog("Xác nhận chỉnh sửa thông tin", "Đồng ý", () => {

                    // })
                } else {
                    let lopMonId = "";
                    let list_lop_mon = e.list_mon_hoc;
                    for (let y = 0; y < list_lop_mon.length; y++) {
                        if (list_lop_mon[y].value == e.maMonHoc) {
                            lopMonId = list_lop_mon[y].lopMonId;
                        }
                    }
                    let params = {
                        "maLopHoc": e.maLopHoc,
                        "maMonHoc": e.maMonHoc,
                        "maGiaoVien": e.maGiaoVien,
                        "hocKy": e.hocKy,
                        "lopMonId": lopMonId,
                        "maTruong": this.maTruongHocPcgd,
                    }
                    utils.confirmDialog("Xác nhận thêm mới thông tin", "Đồng ý", () => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/lopMonGiaoVien/create", params, data => {
                            loading.close();
                            if (data.data.rc == 0) {
                                this.$alertify.success("Thêm thành công");
                                this.list_phan_cong_giang_day_hk2[i].chinhsua = false;
                                let obj = {
                                    maGiaoVien: this.maGvPcgd,
                                    tenCanBo: this.tenGvPcgd,
                                    maTruongHoc: this.maTruongHocPcgd
                                }
                                this.showInFoPcgd(obj)
                            } else {
                                this.$alertify.error(data.data.rd);
                            }
                        });

                    })

                }
            },
            updateItemPcgdHk1(a, e) {
                if (a.type == 1) {
                    this.list_phan_cong_giang_day_hk1[e].list_mon_hoc = [];
                    console.log("chọn:");
                    console.log(JSON.stringify(a));
                    let params = {
                        "maLopHoc": a.maLopHoc,
                    }
                    const loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    rest_api.get("/csdlgd-admin/lopMon/byMaLopHoc", params, data => {
                        loading.close();
                        console.log("data lớp môn trả về:");
                        console.log(JSON.stringify(data));
                        if (data.data.rc == 0) {
                            let dt_dm = data.data.rows;
                            for (let i = 0; i < dt_dm.length; i++) {
                                let obj = {
                                    name: dt_dm[i].tenMonHoc,
                                    value: dt_dm[i].maMonHoc,
                                    lopMonId: dt_dm[i].lopMonId,
                                };
                                this.list_phan_cong_giang_day_hk1[e].list_mon_hoc.push(obj)
                            }
                        } else {
                            this.$alertify.error(data.data.rd);
                        }
                    });


                    for (let i = 0; i < this.list_phan_cong_giang_day_hk1.length; i++) {
                        if (e == i) {
                            this.list_phan_cong_giang_day_hk1[i].chinhsua = true;
                        } else {
                            this.list_phan_cong_giang_day_hk1[i].chinhsua = false;
                        }
                    }
                    for (let j = 0; j < this.list_phan_cong_giang_day_hk2.length; j++) {
                        this.list_phan_cong_giang_day_hk2[j].chinhsua = false;
                    }
                } else {
                    this.list_phan_cong_giang_day_hk1[e].chinhsua = true;
                }
            },
            updateItemPcgdHk2(a, e) {
                if (a.type == 1) {
                    this.list_phan_cong_giang_day_hk2[e].list_mon_hoc = [];
                    console.log("chọn:");
                    console.log(JSON.stringify(a));
                    let params = {
                        "maLopHoc": a.maLopHoc,
                    }

                    const loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    rest_api.get("/csdlgd-admin/lopMon/byMaLopHoc", params, data => {
                        loading.close();
                        console.log("data lớp môn trả về:");
                        console.log(JSON.stringify(data));
                        if (data.data.rc == 0) {
                            let dt_dm = data.data.rows;
                            for (let i = 0; i < dt_dm.length; i++) {
                                let obj = {
                                    name: dt_dm[i].tenMonHoc,
                                    value: dt_dm[i].maMonHoc,
                                    lopMonId: dt_dm[i].lopMonId,
                                };
                                this.list_phan_cong_giang_day_hk2[e].list_mon_hoc.push(obj)
                            }
                        } else {
                            this.$alertify.error(data.data.rd);
                        }
                    });


                    for (let i = 0; i < this.list_phan_cong_giang_day_hk2.length; i++) {
                        if (e == i) {
                            this.list_phan_cong_giang_day_hk2[i].chinhsua = true;
                        } else {
                            this.list_phan_cong_giang_day_hk2[i].chinhsua = false;
                        }
                    }
                    for (let j = 0; j < this.list_phan_cong_giang_day_hk1.length; j++) {
                        this.list_phan_cong_giang_day_hk1[j].chinhsua = false;
                    }
                } else {
                    this.list_phan_cong_giang_day_hk2[e].chinhsua = true;
                }
            },
            themItemPcgdHk1() {
                for (let j = 0; j < this.list_phan_cong_giang_day_hk2.length; j++) {
                    this.list_phan_cong_giang_day_hk2[j].chinhsua = false;
                }
                for (let j = 0; j < this.list_phan_cong_giang_day_hk1.length; j++) {
                    if (!this.list_phan_cong_giang_day_hk1[j].maMonHoc || !this.list_phan_cong_giang_day_hk1[j]
                        .maLopHoc) {
                        this.list_phan_cong_giang_day_hk1[j].chinhsua = true;
                        this.$alertify.error("Thiếu dữ liệu ở bản ghi thứ " + (j + 1));
                        return;
                    }
                    if (this.list_phan_cong_giang_day_hk1[j].type == 2) {
                        this.$alertify.error("Dữ liệu ở bản ghi thứ " + (j + 1) + " chưa được lưu lại.");
                        return;
                    }
                }
                for (let j = 0; j < this.list_phan_cong_giang_day_hk1.length; j++) {
                    this.list_phan_cong_giang_day_hk1[j].chinhsua = false;
                }
                let obj = {
                    type: 2,
                    list_mon_hoc: [],
                    tenLopHoc: "[Trống]",
                    tenMonHoc: "[Trống]",
                    maGiaoVien: this.maGvPcgd,
                    hocKy: 1,
                    chinhsua: true,
                    maMonHoc: "",
                    maLopHoc: "",
                }
                this.list_phan_cong_giang_day_hk1.push(obj);

            },
            themItemPcgdHk2() {
                for (let j = 0; j < this.list_phan_cong_giang_day_hk1.length; j++) {
                    this.list_phan_cong_giang_day_hk1[j].chinhsua = false;
                }
                for (let j = 0; j < this.list_phan_cong_giang_day_hk2.length; j++) {
                    if (!this.list_phan_cong_giang_day_hk2[j].maMonHoc || !this.list_phan_cong_giang_day_hk2[j]
                        .maLopHoc) {
                        this.list_phan_cong_giang_day_hk2[j].chinhsua = true;
                        this.$alertify.error("Thiếu dữ liệu ở bản ghi thứ " + (j + 1));
                        return;
                    }
                    if (this.list_phan_cong_giang_day_hk2[j].type == 2) {
                        this.$alertify.error("Dữ liệu ở bản ghi thứ " + (j + 1) + " chưa được lưu lại.");
                        return;
                    }
                }

                for (let j = 0; j < this.list_phan_cong_giang_day_hk2.length; j++) {
                    this.list_phan_cong_giang_day_hk2[j].chinhsua = false;
                }
                let obj = {
                    type: 2,
                    list_mon_hoc: [],
                    tenLopHoc: "[Trống]",
                    tenMonHoc: "[Trống]",
                    maGiaoVien: this.maGvPcgd,
                    hocKy: 2,
                    chinhsua: true,
                    maMonHoc: "",
                    maLopHoc: "",
                }
                this.list_phan_cong_giang_day_hk2.push(obj);

            },
            xoaItemPcgdHk1(e, i) {
                if (e.type == 1) {

                    let params = {
                        "id": e.lopMonGiaoVienId,
                        "maLopHoc": e.maLopHoc,
                        "maMonHoc": e.maMonHoc,
                    }
                    utils.confirmDialog("Xác nhận xóa thông tin", "Đồng ý", () => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/lopMonGiaoVien/delete", params, data => {
                            loading.close();
                            console.log("data update trả về:");
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.$alertify.success("Xóa thành công");
                                this.list_phan_cong_giang_day_hk1.splice(i, 1);
                            } else {
                                this.$alertify.error(data.data.rd);
                            }
                        });

                    })
                } else {

                    this.list_phan_cong_giang_day_hk1.splice(i, 1);
                }
            },
            xoaItemPcgdHk2(e, i) {
                if (e.type == 1) {

                    let params = {
                        "id": e.lopMonGiaoVienId,
                        "maLopHoc": e.maLopHoc,
                        "maMonHoc": e.maMonHoc,
                    }
                    utils.confirmDialog("Xác nhận xóa thông tin", "Đồng ý", () => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/lopMonGiaoVien/delete", params, data => {
                            loading.close();
                            console.log("data update trả về:");
                            console.log(JSON.stringify(data));
                            if (data.data.rc == 0) {
                                this.$alertify.success("Xóa thành công");
                                this.list_phan_cong_giang_day_hk2.splice(i, 1);
                            } else {
                                this.$alertify.error(data.data.rd);
                            }
                        });

                    })
                } else {
                    this.list_phan_cong_giang_day_hk2.splice(i, 1);
                }
            },
            getDanhSachLop(e) {
                let params = {
                    "maTruong": this.maTruongHocPcgd,
                    "namHoc": this.namHoc,
                };
                console.log("lấy lớp");
                this.list_lop_hoc = [];

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get('/csdlgd-admin/lopMon/byMaGiaoVien', params, data => {
                    console.log(JSON.stringify(data));
                    let data_demo = data.data.rows;
                    this.list_lop_hoc = [];
                    console.log("lấy lớp xxxx");
                    for (let i = 0; i < data_demo.length; i++) {
                        let obj = {
                            name: data_demo[i].tenLopHoc,
                            value: data_demo[i].maLopHoc,
                        };
                        this.list_lop_hoc.push(obj);
                    }

                });
            },
            closemodal3() {
                $(this.$refs.phanconggiangday).on("hidden.bs.modal");
            },
            showInFoPcgd(e) {
                console.log("HIển thị phân công giảng dạy:")
                console.log(JSON.stringify(e));
                this.tenGvPcgd = e.tenCanBo;
                this.maGvPcgd = e.maGiaoVien;
                this.maTruongHocPcgd = e.maTruongHoc;
                this.list_phan_cong_giang_day_hk1 = [];
                this.list_phan_cong_giang_day_hk2 = [];
                let params = {
                    "maGiaoVien": e.maGiaoVien,
                    "namHoc": this.namHoc,
                }
                const loadingpcgd = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.getDanhSachLop(e);
                console.log("lấy môn");

                rest_api.get("/csdlgd-admin/lopMonGiaoVien/danhSach", params, data => {
                    console.log("Lấy danh sách lớp dạy của giáo viên:" + JSON.stringify(params))
                    console.log("Lấy danh sách lớp dạy của giáo viên:" + JSON.stringify(data))
                    console.log(JSON.stringify(data.data));
                    if (data.data.rc == 0 || data.data.rc == 2) {

                        console.log("lấy môn 2");
                        let data_dm = data.data.rows;
                        for (let i = 0; i < data_dm.length; i++) {
                            console.log("lấy môn ***");
                            if (data_dm[i].hocKy == 1) {
                                let obj = {
                                    type: 1,
                                    list_mon_hoc: [],
                                    tenLopHoc: data_dm[i].tenLopHoc,
                                    tenMonHoc: data_dm[i].tenMonHoc,
                                    maGiaoVien: data_dm[i].maGiaoVien,
                                    hocKy: data_dm[i].hocKy,
                                    chinhsua: false,
                                    maMonHoc: data_dm[i].maMonHoc,
                                    maLopHoc: data_dm[i].maLopHoc,
                                    lopMonGiaoVienId: data_dm[i].lopMonGiaoVienId
                                }
                                this.list_phan_cong_giang_day_hk1.push(obj);
                            }
                            if (data_dm[i].hocKy == 2) {
                                let obj = {
                                    type: 1,
                                    list_mon_hoc: [],
                                    tenLopHoc: data_dm[i].tenLopHoc,
                                    tenMonHoc: data_dm[i].tenMonHoc,
                                    maGiaoVien: data_dm[i].maGiaoVien,
                                    hocKy: data_dm[i].hocKy,
                                    chinhsua: false,
                                    maMonHoc: data_dm[i].maMonHoc,
                                    maLopHoc: data_dm[i].maLopHoc,
                                    lopMonGiaoVienId: data_dm[i].lopMonGiaoVienId
                                }
                                this.list_phan_cong_giang_day_hk2.push(obj);
                            }
                        }
                        loadingpcgd.close();
                        $("#phanconggiangday").modal();
                    } else {
                        loadingpcgd.close();
                        this.$alertify.error(data.data.rd);
                    }
                });
            },
            dongSuaGv() {
                this.checkTruocKhiTim()
                // location.reload();
                // console.log("đóng ở ngoài");
                // this.show_update = true;
            },
            ShowUpdate(e) {
                // var stored_datas = JSON.parse(localStorage["danh_sach_trang_thai_can_bo_sme"]);
                // console.log("click chỉnh sửa");
                // console.log("e");
                // console.log(JSON.stringify(stored_datas));
                this.dataUpdateGiaoVien.canBoTheoNamId = e;
                console.log(this.dataUpdateGiaoVien);
                console.log("*******");
                this.show_update = true;
            },
            // Hiển thị thông tin
            showInFo(e) {
                this.dataInFoGiaoVien.canBoTheoNamId = e;
                this.showInFoGiaoVien = true;
            },
            close() {
                this.show_loi_xoa = false;
            },
            checkTruocKhiTim() {
                this.lsDelete = [];
                this.show_update = false;
                this.trangbatdau = !this.trangbatdau;
            },
            ChonTieuChi() {
                // this.bindTieuChiTimKiem();
            },
            limitTextTieuChi(count) {
                return `và ${count} nội dung khác`
            },
            ChonTruongHoc() {
                this.ds_truong_hoc = [];
                this.params = {};
                if (this.danhSachTruongHoc) {
                    let lsth = this.danhSachTruongHoc.map((obj) => {
                        return obj['maTruongHoc']
                    });
                    this.ds_truong_hoc = lsth;
                }
                console.log("Trường sau chọn:" + this.ds_truong_hoc)
            },

            ChonCapHoc() {
                this.params = {};
                this.ds_truong_hoc = [];
                this.ds_khoi_hoc = [];
                this.thongTinTrangCu = [];
                this.getTruongHoc();
            },
            ChonCapHoca2() {
                console.log("Chọn cấp học ở đây");
                this.thongTinTrangCu = [];
                console.log("watch cấp học");
                this.ds_cap_hoc = [];
                this.params = {};
                this.ds_truong_hoc = [];
                this.danhSachTruongHoc = [];
                if (this.danhSachCapHoc) {
                    let lsch = this.danhSachCapHoc.map((obj) => {
                        return obj['id']
                    });
                    this.ds_cap_hoc = lsch;
                }
                console.log("xong" + this.ds_cap_hoc)
                this.getTruongHoc();
            },

            ChonDonVi() {
                this.params = {};
                this.ds_truong_hoc = [];
                this.thongTinTrangCu = [];
                console.log('Đơn vị:' + this.ds_don_vi)
                this.getTruongHoc();
            },
            ChonDonVi2() {
                console.log("Chọn đơn vị")
                this.ds_don_vi = [];
                this.params = {};
                this.ds_truong_hoc = [];
                this.thongTinTrangCu = [];
                this.danhSachTruongHoc = [];
                if (this.danhSachDonVi) {
                    let lsdv = this.danhSachDonVi.map((obj) => {
                        return obj['maDonVi']
                    });
                    this.ds_don_vi = lsdv;
                }
                console.log("Danh sách dv:" + this.ds_don_vi);
                this.getTruongHoc();
            },
            //đếm số phần tử khác được chọn trong select
            limitTextTruong(count) {
                return `và ${count} trường học khác`
            },
            limitTextCapHoc(count) {
                return `và ${count} cấp học khác`
            },
            limitTextDonVi(count) {
                return `và ${count} đơn vị khác`
            },
            // Chọn trình độ đào tạo
            bindCapHocDangNhap() {
                if (this.thongtin.listCapHoc.length == 1) {
                    for (let i = 0; i < this.thongtin.listCapHoc.length; i++) {
                        if (this.thongtin.listCapHoc[0] == 1) {
                            this.capHocDangNhap = "Tiểu học";
                        }
                        if (this.thongtin.listCapHoc[0] == 2) {
                            this.capHocDangNhap = "THCS";
                        }
                        if (this.thongtin.listCapHoc[0] == 3) {
                            this.capHocDangNhap = "THPT";
                        }
                        if (this.thongtin.listCapHoc[0] == 4) {
                            this.capHocDangNhap = "Nhà trẻ";
                        }
                        if (this.thongtin.listCapHoc[0] == 5) {
                            this.capHocDangNhap = "Nhà trẻ";
                        }
                        if (this.thongtin.listCapHoc[0] == 6) {
                            this.capHocDangNhap = "GDTX";
                        }
                    }
                } else {
                    if (this.thongtin.listCapHoc[0] == 4 && this.thongtin.listCapHoc[1] == 5) {
                        this.capHocDangNhap = "Mầm non";
                    } else {
                        this.capHocDangNhap = "Trường liên cấp";
                    }
                }
            },
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            // Check xuất excle
            CheckXuatExcel() {
                if (this.danhSachTimKiem.length == 0) {
                    this.$alertify.error("Vui lòng chọn nội dung hiển thị.");
                    return;
                }
                if (this.thongtin.role == 5) {
                    this.ds_truong_hoc = [this.thongtin.ma_truong_hoc]
                }
                if (this.total_rows >40000) {
                    this.$alertify.error("Dữ liệu quá lớn. Vui lòng giới hạn dữ liệu tìm kiếm.");
                    return;
                }
                else{
                 this.xuatExcel();
                }
            },
            // Xuất excel
            xuatExcel() {
                let url = "xuat-excel-danh-sach-tra-cuu-can-bo";
                if (this.thongtin.role == 5) {
                    this.ds_truong_hoc = [this.thongtin.ma_truong_hoc]
                }
                let dataSreachList = [];
                if (this.timKiemNangCao) {
                    console.log(JSON.stringify(this.nangCao));
                    if (this.hienThiNangCao.ngaySinh) {
                        if (this.nangCao.ngaySinh) {
                            let obj = {
                                "key": "ngaySinh",
                                "value": this.nangCao.ngaySinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maTonGiao) {
                        if (this.nangCao.maTonGiao) {
                            let obj = {
                                "key": "maTonGiao",
                                "values": this.nangCao.maTonGiao,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maDanToc) {
                        if (this.nangCao.maDanToc) {
                            let obj = {
                                "key": "maDanToc",
                                "values": this.nangCao.maDanToc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.chucVu) {
                        if (this.nangCao.chucVu) {
                            let obj = {
                                "key": "chucVu",
                                "values": this.nangCao.chucVu,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dchiThtru) {
                        if (this.nangCao.dchiThtru) {
                            let obj = {
                                "key": "dchiThtru",
                                "value": this.nangCao.dchiThtru,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maKhuVuc) {
                        if (this.nangCao.maKhuVuc) {
                            let obj = {
                                "key": "maKhuVuc",
                                "values": this.nangCao.maKhuVuc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.gioiTinh) {
                        if (this.nangCao.gioiTinh) {
                            let obj = {
                                "key": "gioiTinh",
                                "value": parseInt(this.nangCao.gioiTinh),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dangVien) {
                        if (this.nangCao.dangVien) {
                            let obj = {
                                "key": "dangVien",
                                "value": parseInt(this.nangCao.dangVien),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doTuoi) {
                        if (this.nangCao.doTuoi) {
                            let obj = {
                                "key": "doTuoi",
                                "values": this.nangCao.doTuoi,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.bacLuong) {
                        if (this.nangCao.bacLuong) {
                            let obj = {
                                "key": "bacLuong",
                                "value": this.nangCao.bacLuong,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.heSoLuong) {
                        if (this.nangCao.heSoLuong) {
                            let obj = {
                                "key": "heSoLuong",
                                "value": this.nangCao.heSoLuong,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maTrinhDoChuyenMonCaoNhat) {
                        if (this.nangCao.maTrinhDoChuyenMonCaoNhat && this.nangCao.maTrinhDoChuyenMonCaoNhat != "") {
                            let obj = {
                                "key": "maTrinhDoChuyenMonCaoNhat",
                                "values": this.nangCao.maTrinhDoChuyenMonCaoNhat,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.trinhDoDaoTaoCnChinh) {
                        if (this.nangCao.trinhDoDaoTaoCnChinh) {
                            let obj = {
                                "key": "trinhDoDaoTaoCnChinh",
                                "value": this.nangCao.trinhDoDaoTaoCnChinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.moetCode) {
                        if (this.nangCao.moetCode) {
                            let obj = {
                                "key": "moetCode",
                                "value": this.nangCao.moetCode,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maMonHoc) {
                        if (this.nangCao.maMonHoc) {
                            let obj = {
                                "key": "maMonHoc",
                                "values": this.nangCao.maMonHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.soDienThoaiDiDong) {
                        if (this.nangCao.soDienThoaiDiDong) {
                            let obj = {
                                "key": "soDienThoaiDiDong",
                                "value": this.nangCao.soDienThoaiDiDong,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                }
                let params = {
                    "loaiCanBo": this.loaiCanBo,
                    "namHoc": this.namHoc,
                    "gioiTinh": this.gioiTinh,
                    "keyword": this.tuKhoa,
                    "maDanToc": this.maDanToc,
                    "capHocs": this.ds_cap_hoc,
                    "maTruongs": this.ds_truong_hoc,
                    "dataSreachList": dataSreachList,
                    "trangThai": parseInt(this.trangThai),
                    "maChuyenNganhDaoTao": this.maChuyenNganhDaoTao,
                    "trinhDoDaoTaoCnChinh": this.chuyenNganh,
                    "colExcels": this.danhSachTimKiem,
                };
                if (this.thongtin.role == 2 || this.thongtin.role == 3 || this.thongtin.role == 20) {
                    params.maDonVis = this.ds_don_vi;
                }
                if (this.thongtin.role == 4 || this.thongtin.role == 40) {
                    params.maDonVis = [this.thongtin.ma_don_vi];
                }
                dialog.confirmDialog(
                    "Xác nhận tải xuống dữ liệu. Vui lòng chờ trong thời gian tải xuống?",
                    "Đồng ý",
                    () => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        api.post(url, params, (data) => {
                            loading.close();
                            let a = document.createElement('a');
                            a.href = data.data.file;
                            document
                                .body
                                .appendChild(a);
                            a.click();
                            document
                                .body
                                .removeChild(a);
                        });
                    }
                );
            },
            //xóa mã định danh
            DeleteModetCode() {
                let canBoTheoNamId = [];
                for (let i = 0; i < this.lsDelete.length; i++) {
                    console.log("danh sách xóa:" + JSON.stringify(this.lsDelete));
                    for (let j = 0; j < this.list_giaovien.length; j++) {
                        console.log("danh sách học sinh:" + JSON.stringify(this.list_giaovien));
                        if (this.lsDelete[i] == this.list_giaovien[j].maGiaoVien) {
                            console.log("Trùng:" + JSON.stringify(this.lsDelete[i]));
                            canBoTheoNamId.push(this.list_giaovien[j].maGiaoVien);
                        }
                    }
                }
                if (this.lsDelete.length > 0) {
                    dialog.confirmDialog(
                        "Xác nhận xóa mã định danh của các bản ghi đã chọn?",
                        "Đồng ý",
                        () => {
                            console.log("Đồng ý xóa danh sách:");
                            console.log(this.lsDelete);
                            let params = {
                                loaiDuLieu: 1,
                                lstId: this.lsDelete,
                                namHoc: this.namHoc
                            };
                            const loading = this.$loading({
                                lock: true,
                                text: 'Loading',
                                spinner: 'el-icon-loading',
                                background: 'rgba(0, 0, 0, 0.7)'
                            });
                            rest_api.post("/csdlgd-admin/DataTruong/deleteMoetCode", params, data => {
                                loading.close();
                                if (data.data.rc == 0) {
                                    this
                                        .$alertify
                                        .success("Xóa dữ liệu thành công");
                                    this.getData();
                                } else {
                                    this
                                        .$alertify
                                        .errot(data.data.rd);
                                }
                            });
                        }
                    );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn ít nhất 1 cán bộ.")
                }
            },
            // Xóa danh sách giáo viên
            DeleteTeacher() {
                console.log(this.lsDelete);
                let canBoTheoNamId = [];
                for (let i = 0; i < this.lsDelete.length; i++) {
                    console.log("danh sách xóa:" + JSON.stringify(this.lsDelete));
                    for (let j = 0; j < this.list_giaovien.length; j++) {
                        console.log("danh sách học sinh:" + JSON.stringify(this.list_giaovien));
                        if (this.lsDelete[i] == this.list_giaovien[j].canBoTheoNamId) {
                            console.log("Trùng:" + JSON.stringify(this.lsDelete[i]));
                            canBoTheoNamId.push(this.list_giaovien[j].maGiaoVien);
                        }
                    }
                }
                if (this.lsDelete.length > 0) {
                    dialog.confirmDialog(
                        // "Bạn có muốn xóa dữ liệu của " + this.lsDelete.length + " cán bộ này?",
                        "Xác nhận xóa các bản ghi đã chọn?",
                        "Đồng ý",
                        () => {
                            console.log("Đồng ý xóa danh sách:");
                            console.log(this.lsDelete);
                            let params = {
                                canBoTheoNamIds: this.lsDelete,
                                listMa: canBoTheoNamId,
                                namHoc: this.namHoc
                            };
                            const loading = this.$loading({
                                lock: true,
                                text: 'Loading',
                                spinner: 'el-icon-loading',
                                background: 'rgba(0, 0, 0, 0.7)'
                            });
                            rest_api.post("/csdlgd-admin/giaoVien/delete", params, data => {
                                loading.close();
                                if (data.data.rc == 0) {
                                    this
                                        .$alertify
                                        .success("Xóa dữ liệu thành công");
                                    this.getData();
                                } else {
                                    console.log("showw lỗi xóa");
                                    this.show_loi_xoa = true;
                                    $("#modal_import_file").modal();
                                    this.loinhanloi = "Bạn không thể xóa.";
                                    this.loinhanloi = data.data.rd;
                                    this.list_loixoa_giaovien = data.data.rows;
                                    console.log(JSON.stringify(this.list_loixoa_giaovien))
                                    console.log(JSON.stringify(this.show_loi_xoa))
                                }
                            });
                        }
                    );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn ít nhất 1 cán bộ.")
                }
            },
            // Lấy danh sách dữ liệu cán bộ
            // gán các cột hiển thị dữ liệu
            bindCotHeader() {
                this.danhSachTimKiem.sort(this.sapXepMang)
            },
            sapXepMang(a, b) {
                if (a.stt < b.stt) {
                    return -1;
                }
                if (a.stt > b.stt) {
                    return 1;
                }
                return 0;
            },
            // gán các cột hiển thị
            ganCot() {
                this.hangHienThi = {};
                this.cotHienThi = this.danhSachTimKiem;
                console.log("cột hiển thị:");
                for (let i = 0; i < this.cotHienThi.length; i++) {
                    if (this.cotHienThi[i].key == "maGiaoVien") {
                        this.hangHienThi.maGiaoVien = true;
                    }
                    if (this.cotHienThi[i].key == "tenCanBo") {
                        this.hangHienThi.tenCanBo = true;
                    }
                    if (this.cotHienThi[i].key == "gioiTinh") {
                        this.hangHienThi.gioiTinh = true;
                    }
                    if (this.cotHienThi[i].key == "trangThai") {
                        this.hangHienThi.trangThai = true;
                    }
                    if (this.cotHienThi[i].key == "ngaySinh") {
                        this.hangHienThi.ngaySinh = true;
                    }
                    if (this.cotHienThi[i].key == "doTuoi") {
                        this.hangHienThi.doTuoi = true;
                    }
                    if (this.cotHienThi[i].key == "maDanToc") {
                        this.hangHienThi.maDanToc = true;
                    }
                    if (this.cotHienThi[i].key == "loaiCanBo") {
                        this.hangHienThi.loaiCanBo = true;
                    }
                    if (this.cotHienThi[i].key == "maTonGiao") {
                        this.hangHienThi.maTonGiao = true;
                    }
                    if (this.cotHienThi[i].key == "chucVu") {
                        this.hangHienThi.chucVu = true;
                    }
                    if (this.cotHienThi[i].key == "trinhDoDaoTaoCnChinh") {
                        this.hangHienThi.trinhDoDaoTaoCnChinh = true;
                    }
                    if (this.cotHienThi[i].key == "maTrinhDoChuyenMonCaoNhat") {
                        this.hangHienThi.maTrinhDoChuyenMonCaoNhat = true;
                    }
                    if (this.cotHienThi[i].key == "ngayTuyenDung") {
                        this.hangHienThi.ngayTuyenDung = true;
                    }
                    if (this.cotHienThi[i].key == "ngayVaoBienChe") {
                        this.hangHienThi.ngayVaoBienChe = true;
                    }
                    if (this.cotHienThi[i].key == "noiDungKhenThuong") {
                        this.hangHienThi.noiDungKhenThuong = true;
                    }
                    if (this.cotHienThi[i].key == "tenTruongHoc") {
                        this.hangHienThi.tenTruongHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenHieuTruong") {
                        this.hangHienThi.tenHieuTruong = true;
                    }
                    if (this.cotHienThi[i].key == "dienThoaiHieuTruong") {
                        this.hangHienThi.dienThoaiHieuTruong = true;
                    }
                    if (this.cotHienThi[i].key == "capHoc") {
                        this.hangHienThi.capHoc = true;
                    }
                    if (this.cotHienThi[i].key == "trangThai") {
                        this.hangHienThi.trangThai = true;
                    }
                    if (this.cotHienThi[i].key == "dangVien") {
                        this.hangHienThi.dangVien = true;
                    }
                    if (this.cotHienThi[i].key == "soCmnd") {
                        this.hangHienThi.soCmnd = true;
                    }
                    if (this.cotHienThi[i].key == "ngayCapCmnd") {
                        this.hangHienThi.ngayCapCmnd = true;
                    }
                    if (this.cotHienThi[i].key == "noiCapCmnd") {
                        this.hangHienThi.noiCapCmnd = true;
                    }
                    if (this.cotHienThi[i].key == "soDienThoai") {
                        this.hangHienThi.soDienThoai = true;
                    }
                    if (this.cotHienThi[i].key == "email") {
                        this.hangHienThi.email = true;
                    }
                    if (this.cotHienThi[i].key == "dchiThtru") {
                        this.hangHienThi.dchiThtru = true;
                    }
                    if (this.cotHienThi[i].key == "bacLuong") {
                        this.hangHienThi.bacLuong = true;
                    }
                    if (this.cotHienThi[i].key == "heSoLuong") {
                        this.hangHienThi.heSoLuong = true;
                    }
                    if (this.cotHienThi[i].key == "gvDayGioi") {
                        this.hangHienThi.gvDayGioi = true;
                    }
                    if (this.cotHienThi[i].key == "maTrinhDoChuyenMonCaoNhat") {
                        this.hangHienThi.maTrinhDoChuyenMonCaoNhat = true;
                    }
                    if (this.cotHienThi[i].key == "trinhDoDaoTaoCnChinh") {
                        this.hangHienThi.trinhDoDaoTaoCnChinh = true;
                    }
                    // if (this.cotHienThi[i].key == "chuyenNganh") {
                    //     this.hangHienThi.chuyenNganh = true;
                    // }
                    if (this.cotHienThi[i].key == "moetCode") {
                        this.hangHienThi.moetCode = true;
                    }
                    if (this.cotHienThi[i].key == "maMonHoc") {
                        this.hangHienThi.maMonHoc = true;
                    }
                    if (this.cotHienThi[i].key == "tenCsDaoTaoBd") {
                        this.hangHienThi.tenCsDaoTaoBd = true;
                    }
                    if (this.cotHienThi[i].key == "soDienThoaiDiDong") {
                        this.hangHienThi.soDienThoaiDiDong = true;
                    }
                    if (this.cotHienThi[i].key == "loaiHopDong") {
                        this.hangHienThi.loaiHopDong = true;
                    }
                }
                console.log("Hàng hiển thị:" + JSON.stringify(this.hangHienThi));
            },
            getData() {
                this.slectAll = false;
                this.lsDelete = [];
                if (this.danhSachTimKiem.length == 0) {
                    this.$alertify.error("Vui lòng chọn nội dung hiển thị.");
                    return;
                }
                let dataSreachList = [];
                if (this.timKiemNangCao) {
                    console.log(JSON.stringify(this.nangCao));
                    if (this.hienThiNangCao.ngaySinh) {
                        if (this.nangCao.ngaySinh) {
                            let obj = {
                                "key": "ngaySinh",
                                "value": this.nangCao.ngaySinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maTonGiao) {
                        if (this.nangCao.maTonGiao) {
                            let obj = {
                                "key": "maTonGiao",
                                "values": this.nangCao.maTonGiao,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maDanToc) {
                        if (this.nangCao.maDanToc) {
                            let obj = {
                                "key": "maDanToc",
                                "values": this.nangCao.maDanToc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.chucVu) {
                        if (this.nangCao.chucVu) {
                            let obj = {
                                "key": "chucVu",
                                "values": this.nangCao.chucVu,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dchiThtru) {
                        if (this.nangCao.dchiThtru) {
                            let obj = {
                                "key": "dchiThtru",
                                "value": this.nangCao.dchiThtru,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maKhuVuc) {
                        if (this.nangCao.maKhuVuc) {
                            let obj = {
                                "key": "maKhuVuc",
                                "values": this.nangCao.maKhuVuc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.gioiTinh) {
                        if (this.nangCao.gioiTinh) {
                            let obj = {
                                "key": "gioiTinh",
                                "value": parseInt(this.nangCao.gioiTinh),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.dangVien) {
                        if (this.nangCao.dangVien) {
                            let obj = {
                                "key": "dangVien",
                                "value": parseInt(this.nangCao.dangVien),
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.doTuoi) {
                        if (this.nangCao.doTuoi) {
                            let obj = {
                                "key": "doTuoi",
                                "values": this.nangCao.doTuoi,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.bacLuong) {
                        if (this.nangCao.bacLuong) {
                            let obj = {
                                "key": "bacLuong",
                                "value": this.nangCao.bacLuong,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.heSoLuong) {
                        if (this.nangCao.heSoLuong) {
                            let obj = {
                                "key": "heSoLuong",
                                "value": this.nangCao.heSoLuong,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maTrinhDoChuyenMonCaoNhat) {
                        if (this.nangCao.maTrinhDoChuyenMonCaoNhat && this.nangCao.maTrinhDoChuyenMonCaoNhat != "") {
                            let obj = {
                                "key": "trinhDoChuyenMonCaoNhat",
                                "values": this.nangCao.maTrinhDoChuyenMonCaoNhat,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.trinhDoDaoTaoCnChinh) {
                        if (this.nangCao.trinhDoDaoTaoCnChinh) {
                            let obj = {
                                "key": "trinhDoDaoTaoCnChinh",
                                "value": this.nangCao.trinhDoDaoTaoCnChinh,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.moetCode) {
                        if (this.nangCao.moetCode) {
                            let obj = {
                                "key": "moetCode",
                                "value": this.nangCao.moetCode,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.maMonHoc) {
                        if (this.nangCao.maMonHoc) {
                            let obj = {
                                "key": "maMonHoc",
                                "values": this.nangCao.maMonHoc,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    if (this.hienThiNangCao.soDienThoaiDiDong) {
                        if (this.nangCao.soDienThoaiDiDong) {
                            let obj = {
                                "key": "soDienThoaiDiDong",
                                "value": this.nangCao.soDienThoaiDiDong,
                            }
                            dataSreachList.push(obj)
                        }
                    }
                    // if (this.hienThiNangCao.chuyenNganh) {
                    //     if (this.nangCao.chuyenNganh) {
                    //         let obj = {
                    //             "key": "chuyenNganh",
                    //             "value": this.nangCao.chuyenNganh,
                    //         }
                    //         dataSreachList.push(obj)
                    //     }
                    // }
                }
                console.log("lọc nâng cao");
                console.log(JSON.stringify(dataSreachList));
                this.bindCotHeader();
                this.ganCot();
                this.list_giaovien = [];
                this.total_rows = 0;
                if (this.namHoc == '') {
                    utils.showDialog("Thông báo", "Vui lòng kiểm tra lại dữ liệu!");
                    return;
                }
                let params = {
                    "start": this.start,
                    "limit": this.limit,
                    "loaiCanBo": this.loaiCanBo,
                    // "chucVu": this.chucVu,
                    "namHoc": this.namHoc,
                    "dataSreachList": dataSreachList,
                    "gioiTinh": this.gioiTinh,
                    "keyword": this.tuKhoa,
                    "maChuyenNganhDaoTao": this.maChuyenNganhDaoTao,
                    // "maDanToc": this.maDanToc,
                    // "maDonVis": this.dsDonVi,
                    "colExcels": this.danhSachTimKiem,
                    "capHocs": this.ds_cap_hoc,
                    "trangThai": parseInt(this.trangThai),
                    "maTruongs": this.ds_truong_hoc,
                    "trinhDoDaoTaoCnChinh": this.chuyenNganh,
                };
                if (this.thongtin.role == 2 || this.thongtin.role == 3 || this.thongtin.role == 20) {
                    params.maDonVis = this.ds_don_vi;
                }
                if (this.thongtin.role == 4 || this.thongtin.role == 40) {
                    params.maDonVis = [this.thongtin.ma_don_vi];
                }
                console.log("param lấy dữ liệu:" + JSON.stringify(params))
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/giaoVien/search2", params, (data) => {
                    loading.close();
                    console.log("danh sách cán bộ:" + JSON.stringify(data))
                    if (data.data.rc === 0) {
                        if (data.data.totalRows == 0) {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy");
                            return;
                        } else {
                            this.total_rows = data.data.totalRows;
                            this.list_giaovien = data.data.tableData;
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công.")
                        }
                    } else {
                        this
                            .$alertify
                            .error(data.data.rd);
                        return;
                        // utils.showDialog("Thông báo", data.data.rd, null, () => {}); return;
                    }
                });
            },
            onChangeLoaiCanBo() {
                this.chucVu = '';
            },
            // Chuyển hướng từ trang kết chuyển dữ liệu
            chuyenHuong() {
                window
                    .history
                    .replaceState("", "CSDL Ngành", "Look-up-officials");
                if (this.chuyenhuong.namHoc) {
                    // this.namHoc = this.chuyenhuong.namHoc;
                    this.namHocHienTai = this.chuyenhuong.namHoc,
                        this.findNamHoc();
                }
                if (this.chuyenhuong.maTruongHoc) {
                    this.ds_truong_hoc = [this.chuyenhuong.maTruongHoc];
                    this.layTruongChuyenHuong();
                }
                console.log("11111111111");
            },
            // Lấy danh sách trường chuyển hướng sang
            layTruongChuyenHuong() {
                this.list_truong_hoc = [];
                this.list_truong_hoc_custom = [];
                let params = {
                    maTruong: this.chuyenhuong.maTruongHoc,
                    loose: true
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    console.log("trả về:" + JSON.stringify(data));
                    if (data.data.code == 200) {
                        this.list_truong_hoc = data.data.rows;
                        console.log(
                            "danh sách trường chueyern hướng:" + JSON.stringify(this.list_truong_hoc)
                        );
                        let obj = {
                            selectAll: 'Chọn tất cả',
                            libs: this.list_truong_hoc
                        };
                        this.list_truong_hoc_custom = [obj];
                    }
                    this.danhSachTruongHoc = [this.list_truong_hoc[0]];
                    console.log("bind đoạn này nè");
                    this.getData();
                });
            },
            getTruongHoc(gt = () => {}) {
                this.list_truong_hoc = [];
                this.list_truong_hoc_custom = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc,
                    loose: true
                };
                // if (this.thongTinTrangCu.maTruongHoc) {     params.maTruong =
                // this.thongTinTrangCu.maTruongHoc; }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    console.log("lấy trường");
                    if (data.data.statusResponse ==0) {
                        let dulieu = data.data.rows;
                        let ldv =[];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenTruongHoc: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                maTruongHoc: dulieu[i].maTruongHoc
                            }
                            ldv.push(obj)
                        }
                        this.list_truong_hoc = ldv;
                    }
                    else{
                        this.list_truong_hoc = [];
                    }
                });
            },
            // Lấy danh sách đơn vị
            getDonVi() {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        let ldv = []
                        let dulieu = data.data.rows;
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenDonVi: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                    ' - [' + dulieu[i].maDonVi + ']',
                                maDonVi: dulieu[i].maDonVi
                            }
                            ldv.push(obj)
                        }
                        this.list_don_vi = ldv;
                        if (this.thongtin.role == 4 || this.thongtin.role == 5) {
                            for (let i = 0; i < this.list_don_vi.length; i++) {
                                if (this.list_don_vi[i].maDonVi == this.thongtin.ma_don_vi) {
                                    this.ds_don_vi = [this.thongtin.ma_don_vi];
                                    this.danhSachDonVi = [this.list_don_vi[i]];
                                    this.tenDonViDangNhap = this.list_don_vi[i].tenDonVi;
                                }
                            }
                        }
                    }
                });
            },
            // gán năm học
            findNamHoc() {
                for (let i = 0; i < this.list_nam_hoc.length; i++) {
                    if (this.list_nam_hoc[i].id == this.namHocHienTai) {
                        this.danhSachNamHoc = this.list_nam_hoc[i];
                    }
                }
            },
            // định nghĩa cho đơn vị
            setNameDonVi({
                tenDonVi,
                maDonVi
            }) {
                return `${tenDonVi} - [${maDonVi}]`
            },
            // định nghĩa cho trường
            setNameTruongHoc({
                tenTruongHoc,
                maTruongHoc
            }) {
                return `${tenTruongHoc} - [${maTruongHoc}]`
            },
            // định nghĩa cho cấp học
            setNameCapHoc({
                name
            }) {
                return `${name}`
            },
            // định nghĩa cho năm học
            setNameNamHoc({
                name
            }) {
                return `${name}`
            },
            // định nghĩa cho chuyên ngành
            setNameChuyenNganh({
                tenCnganhDtao
            }) {
                return `${tenCnganhDtao}`
            },
            // định nghĩa cho dân tộc
            setNameDanToc({
                tenDanToc
            }) {
                return `${tenDanToc}`
            },
            // định nghĩa cho đối tác
            setNameDoiTac({
                tenDoiTac,
                maDoiTac
            }) {
                return `${tenDoiTac} - [${maDoiTac}]`
            },
            // định nghĩa cho trạng thái
            setNameDanhSachTrangThai({
                name
            }) {
                return `${name}`
            }
        }
    }

</script>
<style scoped="scoped">
    @import "../../../../node_modules/selectwithsearch.css";

    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        padding: 0;
        margin: 0;
    }

    hr {
        margin: 5px;
    }

    a,
    p,
    span {}

    .cg {
        text-align: center;
        align-items: center;
    }

    .multiselect--disabled {
        background: white;
    }

    .multiselect__content-wrapper {
        z-index: 9 !important;
    }

    input[type=checkbox] {
        margin: 0 !important;
    }

    .bt>a>b>i {
        color: #DC0101;
        border: 1px solid black;
        padding: 5px 6px;
        border-radius: 23%;
    }

    .input.el-input__inner {
        color: #303133 !important;
    }

</style>

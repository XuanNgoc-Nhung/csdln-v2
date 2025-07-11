    <template>
        <div class="emis-hocsinh">
            <div>
                <span>Báo cáo theo tiêu chí:</span>
                <div v-for="(nd,i) in list_tieu_chi_chon" class="danhsachtieuchi" style="display:inline-block">
                    <span class="red">›</span>
                    <div style="display:inline">
                        <a href="#" @click.prevent="" class="inputieuchi">{{nd.name}}</a>
                        <a href="#" @click.prevent="deleteListTieuChi(i)"
                            style="margin-left:-2px; padding:4px; background:#FA8258" title="Xóa tiêu chí"
                            class="inputieuchi">x</a>
                    </div>
                </div>
                <div style="display:inline">
                    <select v-if="thongtin.role==5" v-bind:class="{ thieutieuchi: thieu_tieu_chi }"
                        @change.prevent="onChonTieuChi(TieuChi)" v-model="TieuChi" class="chon">
                        <option :value="TieuChi">
                            +Thêm tiêu chí</option>
                        <option v-for="(op,i) in list_tieu_chi_truong" v-bind:disabled="op.status" :value="op.index">
                            {{op.name}}</option>
                    </select>
                    <select v-if="thongtin.role!=5" v-bind:class="{ thieutieuchi: thieu_tieu_chi }"
                        @change.prevent="onChonTieuChi(TieuChi)" v-model="TieuChi" class="chon">
                        <option :value="TieuChi">
                            +Thêm tiêu chí</option>
                        <option v-for="(op,i) in list_tieu_chi" v-bind:disabled="op.status" :value="op.index">{{op.name}}
                        </option>
                    </select>
                    <span v-if="thieu_tieu_chi" class="red">
                        <span>
                            <img style="width:20px;"
                                src="https://media3.giphy.com/media/103XIj60oDbZNm/giphy.gif?cid=790b76119b0a85f4efc36f7cdcb827e087a43512ca28a0b7&rid=giphy.gif"
                                alt="" /></span>
                        Vui lòng chọn ít nhất 1 tiêu chí</span>
                </div>
            </div>
            <div style="padding-top:15px;">
                <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne1" aria-expanded="true"
                    aria-controls="collapseOne1">
                    + Lọc nâng cao
                </a>
                <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                    <div class="panel panel-default">
                        <div id="collapseOne1" class="panel-collapse collapse text-center" role="tabpanel"
                            aria-labelledby="headingOne" v-if="list_tieu_chi_chon.length==0">
                            <p>Bạn chưa chọn tiêu chí nào</p>
                        </div>
                        <div v-else="v-else" id="collapseOne1" class="panel-collapse collapse in" role="tabpanel"
                            aria-labelledby="headingOne">
                            <div class="panel-body">
                                <div class="row" style="display:none">
                                    <div class="col-md-12" style="border-bottom: 1px solid bisque;">
                                        <h5 style="display:inline; margin-right:15px;">Chọn tiêu chí để lọc</h5>
                                        <span>
                                            <input v-model="ChonTatCaLocNangCao" type="checkbox" />Chọn tất cả</span>
                                    </div>

                                </div>
                                <div class="row">
                                    <div v-if="check_don_vi_quan_ly || check_truong" class="col-md-3"
                                        style="margin-bottom:15px;">
                                        <label>Đơn vị quản lý:</label>

                                        <eselect style="width:100%" @change="layLaiTruong" multiple
                                            no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="DonViQuanLy"
                                            :placeholder="'Chọn'" filterable :data="ds_don_vi"
                                            :fields="['tenDonVi','maDonVi']" />
                                    </div>
                                    <div v-if="check_cap_day" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Cấp học:</label>

                                        <eselect style="width:100%" @change="getTruongHoc" multiple
                                            no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="CapHoc"
                                            :placeholder="'Chọn cấp dạy'" filterable :data="list_cap_hoc"
                                            :fields="['name','id']" />

                                    </div>
                                    <div v-if="check_truong" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Trường:</label>
                                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="TruongHoc"
                                            :placeholder="'Chọn'" filterable :data="ds_truong_hoc"
                                            :fields="['tenMaTruong','maTruongHoc']" />
                                        <!-- -->
                                    </div>
                                    <div v-if="check_nam_hoc" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Năm học:</label>
                                        <!-- <select v-model="namHoc" class="form-control" style="width:100%">
                                            <option value="">Chọn năm học</option>
                                            <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                        </select> -->
                                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="namHoc"
                                            :placeholder="'Chọn năm học'" filterable :data="list_years"
                                            :fields="['name','id']" />
                                    </div>
                                    <div v-if="check_loai_nhap_hoc" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Loại nhập học:</label>
                                        <!-- <ejs-multiselect
                                            style="border:1px solid blue"
                                            class="form-control"
                                            id="multiselect"
                                            v-model="LoaiNhapHoc"
                                            :dataSource="list_loai_nhap_hoc"
                                            :showClearButton='false'
                                            placeholder="Chọn loại nhập học"
                                            :allowFiltering='true'
                                            :filtering='timLoaiNhapHoc'
                                            mode="CheckBox"
                                            :fields="dscd"
                                            :showSelectAll="showSelectAll"
                                            selectAllText="Chọn tất cả"
                                            unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect> -->

                                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="LoaiNhapHoc"
                                            :placeholder="'Chọn loại nhập học'" filterable :data="list_loai_nhap_hoc"
                                            :fields="['name','id']" />
                                    </div>
                                    <div v-if="check_thoi_hoc" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Lý do thôi học:</label>

                                        <!-- <ejs-multiselect
                                            style="border:1px solid blue"
                                            class="form-control"
                                            id="multiselect"
                                            v-model="ThoiHoc"
                                            :dataSource="list_thoi_hoc"
                                            :showClearButton='false'
                                            placeholder="Chọn lý do thôi học"
                                            :allowFiltering='true'
                                            :filtering='timThoiHoc'
                                            mode="CheckBox"
                                            :fields="dstt"
                                            :showSelectAll="showSelectAll"
                                            selectAllText="Chọn tất cả"
                                            unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect> -->

                                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="ThoiHoc"
                                            :placeholder="'Chọn lý do thôi học'" filterable :data="list_thoi_hoc"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_khoi_hoc" class="col-md-3" style="margin-bottom:15px;">
                                        <label>khối:</label>

                                        <!-- <ejs-multiselect
                                            style="border:1px solid blue"
                                            class="form-control"
                                            id="multiselect"
                                            v-model="KhoiHoc"
                                            :dataSource="list_khoi_hoc"
                                            :showClearButton='false'
                                            placeholder="Chọn khối"
                                            :allowFiltering='true'
                                            :filtering='timKhoiHoc'
                                            mode="CheckBox"
                                            :fields="dscd"
                                            :showSelectAll="showSelectAll"
                                            selectAllText="Chọn tất cả"
                                            unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect> -->
                                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="KhoiHoc"
                                            :placeholder="'Chọn khối học'" filterable :data="list_khoi_hoc"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_loai_khuyet_tat" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Loại khuyết tất:</label>

                                        <!-- <ejs-multiselect
                                            style="border:1px solid blue"
                                            class="form-control"
                                            id="multiselect"
                                            v-model="LoaiKhuyetTat"
                                            :dataSource="list_loai_khuyet_tat"
                                            :showClearButton='false'
                                            placeholder="Chọn loại khuyết tật"
                                            :allowFiltering='true'
                                            :filtering='timLoaiKhuyetTat'
                                            mode="CheckBox"
                                            :fields="dstt"
                                            :showSelectAll="showSelectAll"
                                            selectAllText="Chọn tất cả"
                                            unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect> -->

                                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="LoaiKhuyetTat"
                                            :placeholder="'Chọn loại khuyết tật'" filterable :data="list_loai_khuyet_tat"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_trang_thai" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Trạng thái:</label>

                                        <!-- <ejs-multiselect
                                            style="border:1px solid blue"
                                            class="form-control"
                                            id="multiselect"
                                            v-model="TrangThaiHS"
                                            :dataSource="list_trang_thai_hs"
                                            :showClearButton='false'
                                            placeholder="Chọn đơn vị"
                                            :allowFiltering='true'
                                            :filtering='timTrangThai'
                                            mode="CheckBox"
                                            :fields="dstt"
                                            :showSelectAll="showSelectAll"
                                            selectAllText="Chọn tất cả"
                                            unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect> -->

                                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="TrangThaiHS"
                                            :placeholder="'Chọn trạng thái'" filterable :data="list_trang_thai_hs"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_gioi_tinh" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Giới tính:</label>
                                        <!-- <ejs-dropdownlist
                                            v-model="GioiTinh"
                                            placeholder='Chọn giới tính'
                                            :dataSource='list_gioi_tinh'
                                            :fields='dsldg'></ejs-dropdownlist> -->

                                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="GioiTinh"
                                            :placeholder="'Chọn giới tính'" filterable :data="list_gioi_tinh"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_loai_hinh_truong" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Loại hình trường:</label>
                                        <!-- <ejs-multiselect
                                            class="form-control"
                                            id="multiselect"
                                            v-model="loaiHinhDaoTao"
                                            :dataSource="list_loai_hinh_truong"
                                            :showClearButton='false'
                                            placeholder="Chọn loại hình trường"
                                            :allowFiltering='true'
                                            :filtering='timloaiHinhDaoTao'
                                            mode="CheckBox"
                                            :fields="dslht"
                                            :showSelectAll="showSelectAll"
                                            selectAllText="Chọn tất cả"
                                            unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect> -->
                                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="loaiHinhDaoTao"
                                            :placeholder="'Chọn loại hình trường'" filterable :data="list_loai_hinh_truong"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_khu_vuc" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Khu vực:</label>
                                        <!-- <ejs-multiselect
                                            class="form-control"
                                            id="multiselect"
                                            v-model="KhuVuc"
                                            :dataSource="list_khu_vuc"
                                            :showClearButton='false'
                                            placeholder="Chọn khu vực"
                                            :allowFiltering='true'
                                            :filtering='timKhuVuc'
                                            mode="CheckBox"
                                            :fields="dskv"
                                            :showSelectAll="showSelectAll"
                                            selectAllText="Chọn tất cả"
                                            unSelectAllText="Bỏ chọn tất cả"></ejs-multiselect> -->
                                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="KhuVuc"
                                            :placeholder="'Chọn khu vực'" filterable :data="list_khu_vuc"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_dan_toc_thieu_so" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Dân tộc thiểu số:</label>
                                        <!-- <ejs-dropdownlist
                                            v-model="DanTocThieuSo"
                                            placeholder='Dân tộc thiểu số'
                                            :dataSource='BooleanValue'
                                            :fields='dsldg'></ejs-dropdownlist> -->


                                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="DanTocThieuSo"
                                            :placeholder="'Chọn'" filterable :data="BooleanValue"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_khuyet_tat" class="col-md-3">
                                        <label>Khuyết tật:</label>
                                        <!-- <ejs-dropdownlist
                                            v-model="KhuyetTat"
                                            placeholder='Khuyết tật'
                                            :dataSource='BooleanValue'
                                            :fields='dsldg'></ejs-dropdownlist> -->
                                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="KhuyetTat"
                                            :placeholder="'Chọn'" filterable :data="BooleanValue"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_doi_tuong_chinh_sach" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Đối tượng</label>
                                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags
                                            v-model="DoiTuongChinhSach" :placeholder="'Chọn'" filterable
                                            :data="BooleanValue" :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_lop_ghep" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Lớp ghép:</label>
                                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="LopGhep"
                                            :placeholder="'Chọn'" filterable :data="BooleanValue"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_lop_chuyen" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Lớp chuyên:</label>
                                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="LopChuyen"
                                            :placeholder="'Chọn'" filterable :data="BooleanValue"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_doi_vien" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Đội viên</label>
                                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="DoiVien"
                                            :placeholder="'Chọn'" filterable :data="BooleanValue"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_doan_vien" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Đoàn viên</label>
                                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="DoanVien"
                                            :placeholder="'Chọn'" filterable :data="BooleanValue"
                                            :fields="['name','value']" />
                                    </div>
                                    <div v-if="check_dang_vien" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Đàng viên:</label>
                                        <eselect style="width:100%" no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="DangVien"
                                            :placeholder="'Chọn'" filterable :data="BooleanValue"
                                            :fields="['name','value']" />
                                    </div>

                                    <div v-if="check_dan_toc" class="col-md-3" style="margin-bottom:15px;">
                                        <label>Dân tộc:</label>
                                        <eselect style="width:100%" multiple no-match-text="Không tìm thấy bản ghi nào"
                                            no-data-text="danh sách lựa chọn trống" collapse-tags v-model="maDanToc"
                                            :placeholder="'Chọn dân tộc'" filterable :data="ds_dan_toc"
                                            :fields="['name','value']" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- -->
            </div>
            <div class="row">
                <div class="col-md-12 text-center" style="display: flex;justify-content: center;">
                    <el-button size="mini" type="success" @click.prevent="TienHanhLoc">Tra cứu</el-button>
                </div>
            </div>
            <!-- Biểu đồ dữ liệu -->

            <!-- -->
            <div class="row">
                <div class="col-md-12" style="text-align:center; display:none;">
                    <a data-toggle="collapse" title="Ẩn/Hiện biểu đồ" data-parent="" href="#collapse2">
                        <i class="fas fa-chevron-circle-up"></i>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12" style="display: flex;align-items: center;">
                    <label style="margin-right:5px">
                        <input :disabled="list_table_rows.length==0" type="checkbox" @click="checkVertical" />
                        Xuất dữ liệu ngang</label>
                    <el-button :disabled="list_table_rows.length==0" size="mini" type="success"
                        @click.prevent="XuatFileExcel">Xuất excel
                    </el-button>

                    <el-button @click.prevent="loadTemplateModal" size="mini" type="info">Tải mẫu</el-button>
                    <el-button :disabled="list_tieu_chi_chon.length==0" @click.prevent="saveTemplateModal" size="mini"
                        type="warning">Lưu
                        mẫu</el-button>

                </div>
                <div class="col-md-12">
                    <div class="table-responsive row_tp">
                        <table id="textTableHS" class="table table-bordered table-report">
                            <thead>
                                <tr style="background:rgb(228, 235, 245);">
                                    <template v-for="th in list_table_header">
                                        <th class="">{{th.value}}</th>
                                    </template>
                                </tr>
                            </thead>
                            <tbody v-if="list_table_rows.length==0">
                                <tr>
                                    <td class="" colspan="17">
                                        <p>Không có bản ghi nào được tìm thấy</p>
                                    </td>
                                </tr>
                            </tbody>
                            <tbody class="rennder-data" v-else="v-else" v-html="htmlrender"></tbody>
                        </table>
                        <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                    </div>
                </div>
            </div>

            <el-dialog title="Lưu mẫu" :visible.sync="hocSinhModalSave" :close-on-click-modal="false"
                :close-on-press-escape="false" :before-close="handleClose">
                <div>
                    <el-row :gutter="24">
                        <el-col :span="24">
                            <label>Tên mẫu</label>
                            <el-input clearable v-on:keyup.enter="saveTemplate" v-model="NameTemplate"
                                placeholder="Nhập..." />
                        </el-col>
                    </el-row>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                    <el-button size="mini" type="primary" @click.prevent="saveTemplate">Lưu</el-button>
                </span>
            </el-dialog>
            <el-dialog title="Chọn mẫu" :visible.sync="hocSinhModalLoad" :close-on-click-modal="false"
                :close-on-press-escape="false" :before-close="handleClose">
                <div>
                    <el-row :gutter="24">
                        <el-col :span="24">
                            <label>Tên mẫu</label>
                            <el-input clearable v-model="searchTemp" @input="getTemplate" placeholder="Nhập..." />

                            <!-- <input v-model="searchTemp" type="text" class="form-control" placeholder="Chọn template"
                            @input="getTemplate" /> -->
                            <div class="renderTemp" style="max-height:300px">
                                <div v-if="listTemp.length">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li style="display:flex;justify-content: space-between;" v-for="item in listTemp">
                                            <a href="#" @click.prevent="chooseTemp(item)">{{parseName(item.request)}}</a>
                                            <a style="margin-left: 15px;color:#DC0101;" href="#"
                                                @click.prevent="DeleteTemp(item)">Xóa</a>

                                        </li>
                                    </ul>
                                </div>
                                <div v-else="v-else">
                                    <p>Bạn chưa lưu mẫu nào!</p>
                                </div>
                            </div>
                        </el-col>
                    </el-row>
                </div>
                <span slot="footer" class="dialog-footer">
                    <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                    <el-button size="mini" type="primary" @click.prevent="loadTemplate">Tải mẫu</el-button>
                </span>
            </el-dialog>
            <div id="hocSinhModalSave" v-if="false" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Nhập tên template</h4>
                        </div>
                        <div class="modal-body">
                            <p>
                                <input class="form-control" v-on:keyup.enter="saveTemplate" placeholder="Nhập..."
                                    v-model="NameTemplate" type="text" /></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" @click.prevent="saveTemplate">Save
                                template</button>
                        </div>
                    </div>

                </div>
            </div>
            <div id="hocSinhModalLoad" v-if="false" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Chọn template</h4>
                        </div>
                        <div class="modal-body">
                            <input v-model="searchTemp" type="text" class="form-control" placeholder="Chọn template"
                                @input="getTemplate" />
                            <div class="renderTemp" style="max-height:300px">
                                <div v-if="listTemp.length">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li style="display:flex;justify-content: space-between;" v-for="item in listTemp">
                                            <a href="#" @click.prevent="chooseTemp(item)">{{parseName(item.request)}}</a>
                                            <a style="margin-left: 15px;color:#DC0101;" href="#"
                                                @click.prevent="DeleteTemp(item)">Xóa</a>

                                        </li>
                                    </ul>
                                </div>
                                <div v-else="v-else">
                                    <p>Bạn chưa lưu template nào!</p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <el-button type="info" size="mini" @click.prevent="loadTemplate">Tải mẫu</el-button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </template>

    <script>
        import rest_api from "../../../utils/rest_api";
        import array_util from "../../../utils/array_utils";
        import utils from '../../../utils'
        import constant from "../../../utils/baocaohs";
        import ESelectVue from '../../ui/ESelect.vue';
        import Vue from "vue";
        import VueAlertify from "vue-alertify";
        import ElementUI from 'element-ui';
        import Page from '../../ui/PagingCustom';
        Vue.use(VueAlertify);
        import {
            Query
        } from '@syncfusion/ej2-data';
        import api from "../../api";
        import FileSaver from 'file-saver';

        Vue.use(ElementUI);
        export default {
            props: ["infologin"],
            components: {
                "Page": Page,
                'eselect': ESelectVue
            },

            data() {
                return {
                    BooleanValue: [{
                        value: 1,
                        name: 'Có'
                    }, {
                        value: 2,
                        name: 'Không'
                    }],

                    NameTemplate: "",
                    listTemp: [],
                    searchTemp: "",
                    // -----------------
                    htmlrender: '',
                    thongtindangnhap: "",
                    hocSinhModalLoad: false,
                    hocSinhModalSave: false,
                    dowload: false,
                    isVertical: false,
                    // phân trang

                    total_rows: 0,
                    start: 0,
                    currentPage: 1,
                    limit: 25,
                    // Biểu đồ check list
                    showSelectAll: true,
                    dsdv: {
                        text: "tenMaDonVi",
                        value: "maDonVi"
                    },
                    dsth: {
                        text: "tenMaTruong",
                        value: "maTruongHoc"
                    },
                    dscd: {
                        text: "name",
                        value: "id"
                    },
                    dstt: {
                        text: "name",
                        value: "value"
                    },
                    dslht: {
                        text: "name",
                        value: "value"
                    },
                    dslhd: {
                        text: "name",
                        value: "value"
                    },
                    dsncb: {
                        text: "name",
                        value: "value"
                    },
                    dstdcm: {
                        text: "name",
                        value: "value"
                    },
                    dskv: {
                        text: "name",
                        value: "value"
                    },
                    dslcb: {
                        text: "name",
                        value: "value"
                    },
                    dsdt: {
                        text: "name",
                        value: "value"
                    },
                    dsldg: {
                        text: "name",
                        value: "value"
                    },
                    trues: true,
                    falses: false,
                    ChonTatCaLocNangCao: false,
                    thieu_tieu_chi: false,
                    list_years: [],
                    LoaiBaoCao: '2',
                    // Các loại check của cán bộ
                    check_doi_vien: false,
                    check_doan_vien: false,
                    check_dang_vien: false,
                    check_thoi_hoc: false,
                    check_loai_khuyet_tat: false,
                    check_lop_ghep: false,
                    check_lop_chuyen: false,
                    check_doi_tuong_chinh_sach: false,
                    check_khuyet_tat: false,
                    check_khoi_hoc: false,
                    check_loai_nhap_hoc: false,
                    check_dan_toc: false,
                    check_trang_thai: false,
                    check_don_vi_quan_ly: false,
                    check_ton_giao: false,
                    check_vung_chinh_sach: false,
                    check_bo_sung: false,
                    check_truong: false,
                    check_nam_hoc: false,
                    check_gioi_tinh: false,
                    check_dan_toc_thieu_so: false,
                    check_loai_hinh_truong: false,
                    check_khu_vuc: false,
                    check_cap_day: false,
                    TrangThai: '',
                    CapHoc: [],
                    KhoiHoc: '',
                    LoaiNhapHoc: "",
                    maDanToc: "",
                    ThoiHoc: "",
                    DoiTuongChinhSach: '',
                    thongtin: {},
                    TieuChi: "",
                    // các biến dùng ở trong form
                    list_table_header: [],
                    list_table_rows: [],
                    ds_don_vi: [],
                    ds_dan_toc: [],
                    ds_ton_giao: [],
                    list_tieu_chi_chon: [],
                    ds_truong_hoc: [],
                    // -----------------
                    list_tieu_chi: [{
                        "name": "Đơn vị quản lý",
                        "nameCol": "maDonVi",
                        "status": false,
                        "index": "1"
                    }, {
                        "name": "Trường học",
                        "nameCol": "maTruongHoc",
                        "status": false,
                        "index": "2"
                    }, {
                        "name": "Cấp học",
                        "nameCol": "capHoc",
                        "status": false,
                        "index": "3"
                    }, {
                        "name": "Khối học",
                        "nameCol": "khoiHoc",
                        "status": false,
                        "index": "4"
                    }, {
                        "name": "Năm học",
                        "nameCol": "namHoc",
                        "status": false,
                        "index": "5"
                    }, {
                        "name": "Loại nhập học",
                        "nameCol": "loaiNhapHoc",
                        "status": false,
                        "index": "12"
                    }, {
                        "name": "Lý do thôi học",
                        "nameCol": "maLyDoThoiHoc",
                        "status": false,
                        "index": "13"
                    }, {
                        "name": "Trạng thái",
                        "nameCol": "trangThai",
                        "status": false,
                        "index": "6"
                    }, {
                        "name": "Giới tính",
                        "nameCol": "gioiTinh",
                        "status": false,
                        "index": "7"
                    }, {
                        "name": "Loại hình trường",
                        "nameCol": "loaiHinhDaoTao",
                        "status": false,
                        "index": "8"
                    }, {
                        "name": "Khu vực",
                        "nameCol": "maKhuVuc",
                        "status": false,
                        "index": "9"
                    }, {
                        "name": "Đối tượng chính sách",
                        "nameCol": "dtuongCsach",
                        "status": false,
                        "index": "10"
                    }, {
                        "name": "Loại khuyết tật",
                        "nameCol": "maLoaiKhuyetTat",
                        "status": false,
                        "index": "11"
                    }, {
                        "name": "Dân tộc thiểu số",
                        "nameCol": "danToc",
                        "status": false,
                        "index": "14"
                    }, {
                        "name": "Khuyết tật",
                        "nameCol": "khuyetTat",
                        "status": false,
                        "index": "15"
                    }, {
                        "name": "Lớp ghép",
                        "nameCol": "lopGhep",
                        "status": false,
                        "index": "17"
                    }, {
                        "name": "Lớp chuyên",
                        "nameCol": "lopChuyen",
                        "status": false,
                        "index": "18"
                    }, {
                        "name": "Đội viên",
                        "nameCol": "doiVien",
                        "status": false,
                        "index": "19"
                    }, {
                        "name": "Đoàn viên",
                        "nameCol": "doanVien",
                        "status": false,
                        "index": "20"
                    }, {
                        "name": "Đảng viên",
                        "nameCol": "dangVien",
                        "status": false,
                        "index": "21"
                    }, {
                        "name": "Dân tộc",
                        "nameCol": "maDanToc",
                        "status": false,
                        "index": "22"
                    }],
                    list_tieu_chi_truong: [{
                        "name": "Cấp học",
                        "nameCol": "capHoc",
                        "status": false,
                        "index": "3"
                    }, {
                        "name": "Khối học",
                        "nameCol": "khoiHoc",
                        "status": false,
                        "index": "4"
                    }, {
                        "name": "Năm học",
                        "nameCol": "namHoc",
                        "status": false,
                        "index": "5"
                    }, {
                        "name": "Loại nhập học",
                        "nameCol": "loaiNhapHoc",
                        "status": false,
                        "index": "12"
                    }, {
                        "name": "Lý do thôi học",
                        "nameCol": "maLyDoThoiHoc",
                        "status": false,
                        "index": "13"
                    }, {
                        "name": "Trạng thái",
                        "nameCol": "trangThai",
                        "status": false,
                        "index": "6"
                    }, {
                        "name": "Giới tính",
                        "nameCol": "gioiTinh",
                        "status": false,
                        "index": "7"
                    }, {
                        "name": "Loại hình trường",
                        "nameCol": "loaiHinhDaoTao",
                        "status": false,
                        "index": "8"
                    }, {
                        "name": "Khu vực",
                        "nameCol": "maKhuVuc",
                        "status": false,
                        "index": "9"
                    }, {
                        "name": "Đối tượng chính sách",
                        "nameCol": "dtuongCsach",
                        "status": false,
                        "index": "10"
                    }, {
                        "name": "Loại khuyết tật",
                        "nameCol": "maLoaiKhuyetTat",
                        "status": false,
                        "index": "11"
                    }, {
                        "name": "Dân tộc thiểu số",
                        "nameCol": "danToc",
                        "status": false,
                        "index": "14"
                    }, {
                        "name": "Khuyết tật",
                        "nameCol": "khuyetTat",
                        "status": false,
                        "index": "15"
                    }, {
                        "name": "Lớp ghép",
                        "nameCol": "lopGhep",
                        "status": false,
                        "index": "17"
                    }, {
                        "name": "Lớp chuyên",
                        "nameCol": "lopChuyen",
                        "status": false,
                        "index": "18"
                    }, {
                        "name": "Đội viên",
                        "nameCol": "doiVien",
                        "status": false,
                        "index": "19"
                    }, {
                        "name": "Đoàn viên",
                        "nameCol": "doanVien",
                        "status": false,
                        "index": "20"
                    }, {
                        "name": "Đảng viên",
                        "nameCol": "dangVien",
                        "status": false,
                        "index": "21"
                    }, {
                        "name": "Dân tộc",
                        "nameCol": "maDanToc",
                        "status": false,
                        "index": "22"
                    }],
                    //Nội dung gửi đi của cán bộ
                    listCol: [],
                    sreachRequest: [],
                    sreachRequestValues: [],
                    check_disabled: [],
                    don_vi_quan_ly: {
                        name: "Đơn vị quản lý",
                        nameSreach: "maDonVi",
                        values: ""
                    },
                    cap_day: {
                        name: "Cấp dạy",
                        nameSreach: "capHoc",
                        values: ""
                    },
                    doi_vien: {
                        name: "Đội viên",
                        nameSreach: "doiVien",
                        values: ""
                    },
                    doan_vien: {
                        name: "Đoàn viên",
                        nameSreach: "doanVien",
                        values: ""
                    },
                    dang_vien: {
                        name: "Đảng viên",
                        nameSreach: "dangVien",
                        values: ""
                    },
                    lop_ghep: {
                        name: "Lớp ghép",
                        nameSreach: "lopGhep",
                        values: ""
                    },
                    lop_chuyen: {
                        name: "Lớp chuyên",
                        nameSreach: "lopChuyen",
                        values: ""
                    },
                    loai_khuyet_tat: {
                        name: "Loại khuyết tật",
                        nameSreach: "maLoaiKhuyetTat",
                        values: ""
                    },
                    ma_thoi_hoc: {
                        name: "Lý do thôi học",
                        nameSreach: "maLyDoThoiHoc",
                        values: ""
                    },
                    khoi_hoc: {
                        name: "Khối học",
                        nameSreach: "khoiHoc",
                        values: ""
                    },
                    truong_hoc: {
                        name: "Trường học",
                        nameSreach: "maTruongHoc",
                        values: ""
                    },
                    nam_hoc: {
                        name: "Năm học",
                        nameSreach: "namHoc",
                        value: ""
                    },
                    trang_thai_hs: {
                        name: "Trạng thái",
                        nameSreach: "trangThai",
                        values: ""
                    },
                    gioi_tinh: {
                        name: "Giới tính",
                        nameSreach: "gioiTinh",
                        value: ''
                    },
                    loai_hinh_truong: {
                        name: "Loại hình trường",
                        nameSreach: "loaiHinhDaoTao",
                        values: ""
                    },
                    loai_nhap_hoc: {
                        name: "Loại nhập học",
                        nameSreach: "loaiNhapHoc",
                        values: ""
                    },
                    dan_toc: {
                        name: "Dân tộc",
                        nameSreach: "maDanToc",
                        values: ""
                    },
                    khu_vuc: {
                        name: "Khu vực",
                        nameSreach: "maKhuVuc",
                        values: ""
                    },

                    dan_toc_thieu_so: {
                        name: "Dân tộc thiểu số",
                        nameSreach: "danToc",
                        value: ""
                    },
                    khuyet_tat: {
                        name: "Khuyết tật",
                        nameSreach: "khuyetTat",
                        values: ""
                    },
                    doi_tuong_chinh_sach: {
                        name: "Đối tượng chính sách",
                        nameSreach: "dtuongCsach",
                        values: ""
                    },
                    // Phần param cho cán bộ
                    list_trang_thai_hs: constant.TRANG_THAI_HS,
                    list_gioi_tinh: constant.GIOI_TINH,
                    list_loai_hinh_truong: constant.LOAI_HINH_TRUONG,
                    list_khoi_hoc: constant.KHOI_HOC,
                    list_loai_khuyet_tat: constant.KHUYET_TAT,
                    list_nhom_can_bo: constant.NHOM_CAN_BO,
                    list_loai_nhap_hoc: constant.LOAI_NHAP_HOC,
                    list_thoi_hoc: constant.LY_DO_THOI_HOC,
                    list_khu_vuc: constant.KHU_VUC,

                    // list_cap_hoc: constant.LIST_CAP_HOC_KHONG_LIEN,
                    list_cap_hoc: window.listCapHoc,
                    DonViQuanLy: "",
                    TruongHoc: "",
                    namHoc: "",
                    LoaiKhuyetTat: "",
                    TrangThaiHS: "",
                    GioiTinh: '',
                    loaiHinhDaoTao: "",
                    KhuVuc: "",
                    LoaiCanBo: "",
                    DoTuoi: "",
                    LoaiDanhGia: "",
                    DanTocThieuSo: "",
                    KhuyetTat: "",
                    LopGhep: "",
                    LopChuyen: "",
                    DoiVien: "",
                    DangVien: "",
                    DoanVien: ""
                };
            },
            watch: {
                check_truong: function (params) {
                    console.log(params);
                    this.TruongHoc = [],
                        array_util.clearArrays(this.ds_truong_hoc);
                    // if (this.check_truong && this.DonViQuanLy.length != 0) {
                    //     this.getTruongHoc();
                    // }
                },
                // Check thay đổi đơn vị quản lý
                DonViQuanLy: function (newVal) {
                    this.TruongHoc = "";
                    // if (newVal.length == 0) {
                    //     this.ds_truong_hoc = [];
                    // } else {
                    //     this.getTruongHoc();
                    // }
                },

                list_tieu_chi_chon: function (newVal) {
                    console.log("check sự thay đổi của list tiêu chí đã chọn");
                    // this.checkDisabled();
                    this.LocCot();
                    this.putIntoAdvancedFiltering();
                },
                // Check các thay đổi của lọc nâng cao

                check_doi_vien: function (newVal) {
                    if (!newVal) {
                        this.DoiVien = 0;
                    }
                },
                check_dang_vien: function (newVal) {
                    if (!newVal) {
                        this.DangVien = 0;
                    }
                },
                check_doan_vien: function (newVal) {
                    if (!newVal) {
                        this.DoanVien = 0;
                    }
                },
                check_don_vi_quan_ly: function (newVal) {
                    if (!newVal) {
                        console.log("Bỏ chọn đơn vị quản lý");
                        this.DonViQuanLy = "";
                        this.TruongHoc = "";
                        this.check_truong = false;
                    }
                },
                check_dan_toc_thieu_so: function (newVal) {
                    if (!newVal) {
                        this.DanTocThieuSo = "";
                    }
                },
                check_lop_ghep: function (newVal) {
                    if (!newVal) {
                        this.LopGhep = "";
                    }
                },
                check_lop_chuyen: function (newVal) {
                    if (!newVal) {
                        this.LopChuyen = "";
                    }
                },
                check_khuyet_tat: function (newVal) {
                    if (!newVal) {
                        this.KhuyetTat = "";
                    }
                },
                check_doi_tuong_chinh_sach: function (newVal) {
                    if (!newVal) {
                        this.DoiTuongChinhSach = "";
                    }
                },
                check_cap_day: function (newVal) {
                    if (!newVal) {
                        console.log("bỏ chọn cấp dạy");
                        this.CapHoc = [];
                    }
                },
                check_khoi_hoc: function (newVal) {
                    if (!newVal) {
                        console.log("bỏ chọn khoi day");
                        this.KhoiHoc = "";
                    }
                },
                check_thoi_hoc: function (newVal) {
                    if (!newVal) {
                        console.log("bỏ chọn khoi day");
                        this.ThoiHoc = "";
                    }
                },
                check_loai_nhap_hoc: function (newVal) {
                    if (!newVal) {
                        console.log("bỏ chọn nhap hoc");
                        this.LoaiNhapHoc = "";
                    }
                },
                check_dan_toc: function (newVal) {
                    if (!newVal) {
                        console.log("bỏ chọn nhap hoc");
                        this.maDanToc = "";
                    }
                },
                check_dan_toc: function (newVal) {
                    if (!newVal) {
                        console.log("bỏ chọn nhap hoc");
                        this.maDanToc = "";
                    }
                },
                check_loai_khuyet_tat: function (newVal) {
                    if (!newVal) {
                        console.log("bỏ chọn khuet tat");
                        this.LoaiKhuyetTat = "";
                    }
                },
                check_nam_hoc: function (newVal) {
                    if (!newVal) {
                        console.log("Bỏ chọn năm học");
                        this.namHoc = "";
                    }
                },
                check_trang_thai: function (newVal) {
                    if (!newVal) {
                        console.log("Bỏ chọn trạng thái");
                        this.TrangThaiHS = "";
                    }
                },
                check_gioi_tinh: function (newVal) {
                    if (!newVal) {
                        console.log("Bỏ chọn giới tính");
                        this.GioiTinh = "";
                    }
                },
                check_loai_hinh_truong: function (newVal) {
                    if (!newVal) {
                        console.log("bỏ chọn loại hình trường");
                        this.loaiHinhDaoTao = "";
                    }
                },

                check_khu_vuc: function (newVal) {
                    if (!newVal) {
                        console.log("Bỏ chọn khu vực");
                        this.KhuVuc = "";
                    }
                },

                // Hết check thay đổi của lọc nâng cao giáo viên check thay đổi list tiêu chí
                // chọn

            },
            mounted: function () {
                this.thongtin = JSON.parse(this.infologin);
                console.log("thông tin đăng nhập" + JSON.stringify(this.thongtin));
                this.getDonVi();
                this.getDanToc();
                this.getTonGiao();

                this.ds_dan_toc = this.ds_dan_toc.filter(item => item.value !== "");
                this.ds_ton_giao = this.ds_ton_giao.filter(item => item.value !== "");
                this.list_years = this.getYear();
            },
            methods: {

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

                handleClose() {
                    console.log('handleClose');
                    this.hocSinhModalLoad = false;
                    this.hocSinhModalSave = false;
                },
                layLaiTruong() {
                    console.log("laays laji truowngf")
                    this.getTruongHoc();
                },
                DeleteTemp(item) {
                    let params = {};
                    rest_api.post(
                        "/csdlgd-report-fetch/template/delete/" + item.id,
                        params,
                        (data) => {

                            if (data.status == 200) {
                                this.getTemplate();
                            }

                        },
                        10000,
                        false
                    );

                },
                chooseTemp(item) {
                    this.searchTemp = this.parseName(item.request);
                    this.listCol = JSON
                        .parse(item.request)
                        .colList;
                    this.sreachRequest = JSON
                        .parse(item.request)
                        .requestLists;
                    this.sreachRequestValues = JSON
                        .parse(item.request)
                        .requestList;
                },
                parseName(item) {
                    return JSON
                        .parse(item)
                        .name
                },
                getTemplate() {
                    let value = this.searchTemp;
                    let params = {
                        "name": this.searchTemp,
                        "type": 2
                    };
                    let html = '';
                    rest_api.post("/csdlgd-report-fetch/template/search", params, (data) => {

                        if (data.status == 200) {
                            this.listTemp = data.data.rows;
                        }

                    }, 10000, false);
                },
                loadTemplateModal() {
                    this.getTemplate();
                    this.hocSinhModalLoad = true;
                },
                loadTemplate() {
                    if (this.searchTemp == '') {
                        this.thongBao('error', 'Vui lòng chọn mẫu.')
                        return;
                    }
                    this.list_tieu_chi_chon = this.listCol;
                    this.pushDataTemplate(this.sreachRequest);
                    this.pushDataTemplate(this.sreachRequestValues);
                    this.hocSinhModalLoad = false;
                    this.searchTemp = '';
                },
                pushDataTemplate(data) {
                    data.forEach((item) => {
                        if (item.nameSreach == "gioiTinh") {
                            if (item.value)
                                this.GioiTinh = '1';
                            else
                                this.GioiTinh = '0';
                        }
                        if (item.nameSreach == "maDonVi") {
                            this.DonViQuanLy = item.values
                        }
                        if (item.nameSreach == "capHoc") {
                            this.CapHoc = item.values
                        }
                        if (item.nameSreach == "khoiHoc") {
                            this.KhoiHoc = item.values
                        }
                        if (item.nameSreach == "maTruongHoc") {
                            this.TruongHoc = item.values
                        }
                        if (item.nameSreach == "namHoc") {
                            this.namHoc = item.value
                        }
                        if (item.nameSreach == "trangThai") {
                            this.TrangThaiHS = item.values
                        }
                        if (item.nameSreach == "loaiHinhDaoTao") {
                            this.loaiHinhDaoTao = item.values
                        }
                        if (item.nameSreach == "maKhuVuc") {
                            this.KhuVuc = item.values
                        }
                        if (item.nameSreach == "doTuoi") {
                            this.DoTuoi = item.values
                        }
                        if (item.nameSreach == "loaiNhapHoc") {
                            this.LoaiNhapHoc = item.values
                        }
                        if (item.nameSreach == "maDanToc") {
                            this.maDanToc = item.values
                        }
                        if (item.nameSreach == "maLyDoThoiHoc") {
                            this.ThoiHoc = item.values
                        }
                        if (item.nameSreach == "maDtuongCsach") {
                            if (item.value) {
                                this.DoiTuongChinhSach = 1
                            } else {
                                this.DoiTuongChinhSach = 2
                            }
                        }
                        if (item.nameSreach == "maLoaiKhuyetTat") {
                            this.LoaiKhuyetTat = item.values
                        }
                        if (item.nameSreach == "danToc") {
                            if (item.value) {
                                this.DanTocThieuSo = 1
                            } else {
                                this.DanTocThieuSo = 2
                            }
                        }
                        if (item.nameSreach == "khuyetTat") {
                            this.KhuyetTat = item.value
                        }
                        if (item.nameSreach == "dtuongCsach") {
                            this.GiaoVienPhuTrachDoi = item.value
                        }
                        if (item.nameSreach == "lopChuyen") {
                            if (item.value) {
                                this.LopChuyen = 1
                            } else {
                                this.LopChuyen = 2
                            }
                        }
                        if (item.nameSreach == "lopGhep") {
                            if (item.value) {
                                this.LopGhep = 1
                            } else {
                                this.LopGhep = 2
                            }
                        }
                        if (item.nameSreach == "dangVien") {
                            if (item.value) {
                                this.DangVien = 1
                            } else {
                                this.DangVien = 2
                            }
                        }
                        if (item.nameSreach == "doanVien") {
                            if (item.value) {
                                this.DoanVien = 1
                            } else {
                                this.DoanVien = 2
                            }
                        }
                        if (item.nameSreach == "doiVien") {
                            if (item.value) {
                                this.DoiVien = 1
                            } else {
                                this.DoiVien = 2
                            }
                        }

                    })
                },
                saveTemplateModal() {
                    this.NameTemplate = '';
                    this.hocSinhModalSave = true;
                },
                saveTemplate() {
                    let name = this.NameTemplate;
                    if (!name) {
                        this.thongBao('error', 'Vui lòng nhập tên mẫu')
                    } else {
                        this.TienHanhLoc2();
                        if (!this.list_tieu_chi_chon.length) {
                            this
                                .$alertify
                                .error("Vui lòng quay lại và chọn các tiêu chí trước.");
                        } else {
                            let params = {
                                "colList": this.listCol,
                                "requestLists": this.sreachRequest,
                                "requestList": this.sreachRequestValues,
                                "start": this.start,
                                "limit": this.limit,
                                "type": 2,
                                "name": name
                            };
                            console.log(params);
                            rest_api.post("/csdlgd-report-fetch/template/save", params, (data) => {
                                if (data.data.rc == 0) {
                                    this.thongBao('success', data.data.rd)
                                    this.hocSinhModalSave = false;
                                } else {
                                    this.thongBao('error', data.data.rd)
                                }
                            });

                        }

                    }

                },
                getYear() {
                    let y = new Date().getFullYear();
                    return [{
                        id: y - 2,
                        name: (y - 2) + '-' + (
                            y - 1
                        )
                    }, {
                        id: y - 1,
                        name: (y - 1) + '-' + y
                    }, {
                        id: y,
                        name: y + '-' + (
                            y + 1
                        )
                    }]
                },
                XuatFileExcel(e) {
                    $(e.target).attr("disabled", true);
                    $(e.target).addClass('show');
                    if (this.dowload) {

                        let url = "/xuat-excel-bao-cao-dong-hoc-sinh";
                        let params = {
                            "colList": this.listCol,
                            "requestLists": this.sreachRequest,
                            "requestList": this.sreachRequestValues,
                            "start": this.start,
                            "limit": this.limit,
                            "turn": this.isVertical
                        };
                        api.post(url, params, (data) => {
                            $(e.target).removeClass('show');
                            $(e.target).attr("disabled", false);
                            $(e.target).removeAttr("disabled");
                            let currentDate = new Date();
                            let fileName = '';
                            var thangNay = parseInt(currentDate.getMonth()) + 1;
                            if (thangNay < 10) {
                                thangNay = '0' + thangNay;
                            }
                            fileName = this.thongtin.ma_so + '_Bao_cao_hoc_sinh_' + currentDate.getDate() +
                                thangNay + (currentDate.getFullYear());
                            FileSaver.saveAs(data.data.file, fileName);
                        });
                    } else {
                        $(e.target).removeClass('show');
                        $(e.target).attr("disabled", false);
                        $(e.target).removeAttr("disabled");
                        alert("Không có dữ liệu nào để xuất!")
                    }
                },
                layLai(e) {
                    console.log("lấy lại danh sách:" + JSON.stringify(e));
                    this.start = e.start;
                    this.limit = e.limit;
                    this.currentPage = e.currentPage;
                    this.getData();
                },
                xemHuongDan() {
                    var a = {
                            title: 'ok',
                            status: true
                        },
                        b = {
                            title: 'test',
                            status: true
                        },
                        c = {
                            title: 'test1',
                            status: true
                        },
                        d = {
                            title: 'test',
                            status: true
                        };
                    var i = [
                            a, b
                        ],
                        j = [c, d];
                    i.forEach(function (el1) {
                        j.forEach(function (el2) {
                            if (el2.title === el1.title) {
                                el2.status = false;
                            }
                        })
                    });
                    console.log();
                },
                LocCot() {
                    let i = this.list_tieu_chi_chon;
                    let j = this.list_tieu_chi;
                    let k = [];
                    // console.log(JSON.stringify("i :" + i)); console.log(JSON.stringify("j :"
                    // +j));
                    i.forEach(function (el1) {
                        j.forEach(function (el2) {
                            if (el2.nameCol === el1.nameCol) {
                                el2.status = false;
                                k.push(el2.nameCol)
                            }
                        })
                    });
                    this.checkDisabled(k);

                },
                checkVertical(e) {
                    if ($(e.target).is(":checked")) {
                        this.isVertical = 1
                    } else {
                        this.isVertical = 0
                    }

                },
                TienHanhLoc() {
                    console.log('TienHanhLoc:');
                    this.total_rows = 0;
                    this.list_table_header = [];
                    this.list_table_rows = [];
                    if (this.list_tieu_chi_chon.length == 0) {
                        this.thieu_tieu_chi = true;
                        // utils.showDialog("Thông báo", "Vui lòng bổ sung tiêu chí lấy báo cáo", null, () => {
                        //     setTimeout(() => {
                        //         this.thieu_tieu_chi = false;
                        //     }, 4000);

                        // });
                        setTimeout(() => {
                            this.thieu_tieu_chi = false;
                        }, 4000);
                        return;
                    }
                    this.sreachRequest = [];
                    this.sreachRequestValues = [];
                    // console.log(JSON.stringify(this.DonViQuanLy));
                    if (this.DonViQuanLy) {
                        console.log("có đơn vị");
                        this.don_vi_quan_ly.values = this.DonViQuanLy;
                        if (this.don_vi_quan_ly.values.length) {
                            this
                                .sreachRequest
                                .push(this.don_vi_quan_ly);
                        }

                    }
                    if (this.CapHoc) {
                        console.log("có cấp dạy");
                        this.cap_day.values = this.CapHoc;
                        if (this.cap_day.values.length) {
                            this
                                .sreachRequest
                                .push(this.cap_day);
                        }
                    }
                    if (this.LoaiKhuyetTat) {
                        console.log("có khuyet tat");
                        this.loai_khuyet_tat.values = this.LoaiKhuyetTat;
                        if (this.loai_khuyet_tat.values.length) {
                            this
                                .sreachRequest
                                .push(this.loai_khuyet_tat);
                        }
                    }
                    if (this.ThoiHoc) {
                        console.log("Lydo thoi hoc");
                        this.ma_thoi_hoc.values = this.ThoiHoc;
                        if (this.ma_thoi_hoc.values.length) {
                            this
                                .sreachRequest
                                .push(this.ma_thoi_hoc);
                        }
                    }
                    if (this.TruongHoc) {
                        this.truong_hoc.values = this.TruongHoc;
                        if (this.truong_hoc.values.length) {
                            this
                                .sreachRequest
                                .push(this.truong_hoc);
                        } else {}
                        console.log("có trường học :" + this.truong_hoc.values);
                    }
                    if (this.namHoc) {
                        console.log("Có năm học");
                        let nam_hoc = {
                            name: "Năm học",
                            nameSreach: "namHoc",
                            value: this.namHoc
                        }
                        console.log(nam_hoc)
                        if (this.namHoc) {
                            console.log(nam_hoc);
                            this
                                .sreachRequestValues
                                .push(nam_hoc);
                        } else {
                            console.log('Không đẩy năm học');
                        }
                        console.log(this.sreachRequestValues);

                    }
                    if (this.TrangThaiHS) {
                        this.trang_thai_hs.values = this.TrangThaiHS;
                        if (this.trang_thai_hs.values.length) {
                            this
                                .sreachRequest
                                .push(this.trang_thai_hs);
                        }
                    }
                    if (this.GioiTinh) {
                        this.gioi_tinh.value = parseInt(this.GioiTinh);
                        this
                            .sreachRequestValues
                            .push(this.gioi_tinh);
                    }
                    if (this.LoaiNhapHoc) {
                        this.loai_nhap_hoc.values = this.LoaiNhapHoc;
                        if (this.loai_nhap_hoc.values.length) {

                            this
                                .sreachRequest
                                .push(this.loai_nhap_hoc);
                        }

                    }
                    if (this.maDanToc) {
                        this.dan_toc.values = this.maDanToc;
                        if (this.dan_toc.values.length) {
                            this
                                .sreachRequest
                                .push(this.dan_toc);
                        }

                    }
                    if (this.loaiHinhDaoTao) {
                        this.loai_hinh_truong.values = this.loaiHinhDaoTao;
                        if (this.loai_hinh_truong.values.length) {
                            this
                                .sreachRequest
                                .push(this.loai_hinh_truong);
                        }

                    }
                    if (this.KhoiHoc) {
                        this.khoi_hoc.values = this.KhoiHoc;
                        if (this.khoi_hoc.values.length) {
                            this
                                .sreachRequest
                                .push(this.khoi_hoc);
                        }

                    }

                    if (this.KhuVuc) {
                        this.khu_vuc.values = this
                            .KhuVuc
                            .map(String);
                        this
                            .sreachRequest
                            .push(this.khu_vuc);
                    }

                    if (this.DanTocThieuSo) {
                        if (this.DanTocThieuSo == 1) {
                            this.dan_toc_thieu_so.value = true;
                        } else {
                            this.dan_toc_thieu_so.value = false;
                        }
                        this
                            .sreachRequestValues
                            .push(this.dan_toc_thieu_so);
                    }
                    if (this.LopGhep) {
                        if (this.LopGhep == 1) {
                            this.lop_ghep.value = 1;
                        } else {
                            this.lop_ghep.value = 0;
                        }

                        this
                            .sreachRequestValues
                            .push(this.lop_ghep);
                    }
                    if (this.LopChuyen) {
                        if (this.LopChuyen == 1) {
                            this.lop_chuyen.value = 1;
                        } else {
                            this.lop_chuyen.value = 0;
                        }
                        this
                            .sreachRequestValues
                            .push(this.lop_chuyen);
                    }
                    if (this.KhuyetTat) {
                        if (this.KhuyetTat == 1) {
                            this.khuyet_tat.value = 1;
                        } else {
                            this.khuyet_tat.value = 0;
                        }

                        this
                            .sreachRequestValues
                            .push(this.khuyet_tat);
                    }
                    if (this.DoiTuongChinhSach) {
                        if (this.DoiTuongChinhSach == 1) {
                            this.doi_tuong_chinh_sach.value = true;
                        } else {
                            this.doi_tuong_chinh_sach.value = false;
                        }
                        this
                            .sreachRequestValues
                            .push(this.doi_tuong_chinh_sach);
                    }
                    if (this.DoiVien) {
                        if (this.DoiVien == 1) {
                            this.doi_vien.value = 1;
                        } else {
                            this.doi_vien.value = 0;
                        }

                        this
                            .sreachRequestValues
                            .push(this.doi_vien);
                    }
                    if (this.DoanVien) {
                        if (this.DoanVien == 1) {
                            this.doan_vien.value = 1;
                        } else {
                            this.doan_vien.value = 0;
                        }

                        this
                            .sreachRequestValues
                            .push(this.doan_vien);
                    }
                    if (this.DangVien) {
                        if (this.DangVien == 1) {
                            this.dang_vien.value = 1;
                        } else {
                            this.dang_vien.value = 0;
                        }

                        this
                            .sreachRequestValues
                            .push(this.dang_vien);
                    }
                    this.ganIndex();
                    console.log("Danh sách cột" + JSON.stringify(this.listCol));
                    console.log("Danh sách lọc" + JSON.stringify(this.sreachRequest));
                    this.getData();

                },
                TienHanhLoc2() {
                    this.sreachRequest = [];
                    this.sreachRequestValues = [];
                    if (this.DonViQuanLy) {
                        console.log("có đơn vị");
                        this.don_vi_quan_ly.values = this.DonViQuanLy;
                        if (this.don_vi_quan_ly.values.length) {
                            this
                                .sreachRequest
                                .push(this.don_vi_quan_ly);
                        }

                    }
                    if (this.CapHoc) {
                        console.log("có cấp dạy");
                        this.cap_day.values = this.CapHoc;
                        if (this.cap_day.values.length) {
                            this
                                .sreachRequest
                                .push(this.cap_day);
                        }
                    }
                    if (this.LoaiKhuyetTat) {
                        console.log("có khuyet tat");
                        this.loai_khuyet_tat.values = this.LoaiKhuyetTat;
                        if (this.loai_khuyet_tat.values.length) {
                            this
                                .sreachRequest
                                .push(this.loai_khuyet_tat);
                        }
                    }
                    if (this.ThoiHoc) {
                        console.log("Lydo thoi hoc");
                        this.ma_thoi_hoc.values = this.ThoiHoc;
                        if (this.ma_thoi_hoc.values.length) {
                            this
                                .sreachRequest
                                .push(this.ma_thoi_hoc);
                        }
                    }
                    if (this.TruongHoc) {
                        this.truong_hoc.values = this.TruongHoc;
                        if (this.truong_hoc.values.length) {
                            this
                                .sreachRequest
                                .push(this.truong_hoc);
                        } else {}
                        console.log("có trường học :" + this.truong_hoc.values);
                    }
                    if (this.namHoc) {
                        console.log("Có năm học");
                        this.nam_hoc.value = this.namHoc;
                        if (this.nam_hoc.value.length) {
                            this
                                .sreachRequestValues
                                .push(this.nam_hoc);
                        }

                    }
                    if (this.TrangThaiHS) {
                        this.trang_thai_hs.values = this.TrangThaiHS;
                        if (this.trang_thai_hs.values.length) {
                            this
                                .sreachRequest
                                .push(this.trang_thai_hs);
                        }
                    }
                    if (this.GioiTinh) {
                        this.gioi_tinh.value = parseInt(this.GioiTinh);
                        this
                            .sreachRequestValues
                            .push(this.gioi_tinh);
                    }
                    if (this.LoaiNhapHoc) {
                        this.loai_nhap_hoc.values = this.LoaiNhapHoc;
                        if (this.loai_nhap_hoc.values.length) {

                            this
                                .sreachRequest
                                .push(this.loai_nhap_hoc);
                        }

                    }
                    if (this.maDanToc) {
                        this.dan_toc.values = this.maDanToc;
                        if (this.dan_toc.values.length) {
                            this
                                .sreachRequest
                                .push(this.dan_toc);
                        }

                    }
                    if (this.loaiHinhDaoTao) {
                        this.loai_hinh_truong.values = this.loaiHinhDaoTao;
                        if (this.loai_hinh_truong.values.length) {
                            this
                                .sreachRequest
                                .push(this.loai_hinh_truong);
                        }

                    }
                    if (this.KhoiHoc) {
                        this.khoi_hoc.values = this.KhoiHoc;
                        if (this.khoi_hoc.values.length) {
                            this
                                .sreachRequest
                                .push(this.khoi_hoc);
                        }

                    }

                    if (this.KhuVuc) {
                        this.khu_vuc.values = this
                            .KhuVuc
                            .map(String);
                        this
                            .sreachRequest
                            .push(this.khu_vuc);
                    }

                    if (this.DanTocThieuSo) {
                        if (this.DanTocThieuSo == 1) {
                            this.dan_toc_thieu_so.value = true;
                        } else {
                            this.dan_toc_thieu_so.value = false;
                        }
                        this
                            .sreachRequestValues
                            .push(this.dan_toc_thieu_so);
                    }
                    if (this.LopGhep) {
                        if (this.LopGhep == 1) {
                            this.lop_ghep.value = 1;
                        } else {
                            this.lop_ghep.value = 0;
                        }

                        this
                            .sreachRequestValues
                            .push(this.lop_ghep);
                    }
                    if (this.LopChuyen) {
                        if (this.LopChuyen == 1) {
                            this.lop_chuyen.value = 1;
                        } else {
                            this.lop_chuyen.value = 0;
                        }
                        this
                            .sreachRequestValues
                            .push(this.lop_chuyen);
                    }
                    if (this.KhuyetTat) {
                        if (this.KhuyetTat == 1) {
                            this.khuyet_tat.value = 1;
                        } else {
                            this.khuyet_tat.value = 0;
                        }

                        this
                            .sreachRequestValues
                            .push(this.khuyet_tat);
                    }
                    if (this.DoiTuongChinhSach) {
                        if (this.DoiTuongChinhSach == 1) {
                            this.doi_tuong_chinh_sach.value = true;
                        } else {
                            this.doi_tuong_chinh_sach.value = false;
                        }
                        this
                            .sreachRequestValues
                            .push(this.doi_tuong_chinh_sach);
                    }
                    if (this.DoiVien) {
                        if (this.DoiVien == 1) {
                            this.doi_vien.value = 1;
                        } else {
                            this.doi_vien.value = 0;
                        }

                        this
                            .sreachRequestValues
                            .push(this.doi_vien);
                    }
                    if (this.DoanVien) {
                        if (this.DoanVien == 1) {
                            this.doan_vien.value = 1;
                        } else {
                            this.doan_vien.value = 0;
                        }

                        this
                            .sreachRequestValues
                            .push(this.doan_vien);
                    }
                    if (this.DangVien) {
                        if (this.DangVien == 1) {
                            this.dang_vien.value = 1;
                        } else {
                            this.dang_vien.value = 0;
                        }

                        this
                            .sreachRequestValues
                            .push(this.dang_vien);
                    }
                    this.ganIndex();

                },
                ganIndex() {
                    this.listCol = this.list_tieu_chi_chon;
                    for (let i = 0; i < this.listCol.length; i++) {
                        this
                            .listCol[i]
                            .index = i;
                    }
                },
                getData() {
                    console.log("lấy dữ liệu");
                    let params = {
                        "colList": this.listCol,
                        "requestLists": this.sreachRequest,
                        "requestList": this.sreachRequestValues,
                        "start": this.start,
                        "limit": this.limit
                    };
                    const loading4 = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    rest_api.post("/csdlgd-report-fetch/BaoCaoHocSinh/sreach", params, (data) => {
                        loading4.close()

                        var html = '';
                        console.log("lấy báo cáo trả về" + JSON.stringify(data));
                        this.total_rows = data.data.total;
                        console.log("tổng số bản ghi:" + this.total_rows);
                        this.list_table_header = data.data.tableHeaders;
                        console.log("các cột");
                        console.log(JSON.stringify(this.list_table_header));
                        this.list_table_rows = data.data.tableRows;
                        console.log("các hàng");
                        console.log(JSON.stringify(this.list_table_rows));

                        if (this.list_table_rows) {
                            this.dowload = true;
                            this
                                .list_table_rows
                                .forEach(function (item) {
                                    html += '<tr>';
                                    item
                                        .col
                                        .forEach(function (i) {
                                            html += '<td class="">' + i.value + '</td>'
                                        });
                                    html += '</tr>';
                                });
                        } else {
                            this.dowload = false;
                            html += '<tr><td>Không bản ghi nào được tìm thấy</td></tr>';
                        }
                        this.htmlrender = html;
                        setTimeout(() => {
                            this.MergeCommonRows();
                        }, 200)
                    }, 60000, true);
                },
                MergeCommonRows() {

                    console.log('số cột :' + this.list_table_header.length);
                    let lengthCol = this.list_table_header.length;
                    let ar = Array.from(Array(lengthCol - 2).keys());

                    $('#textTableHS').margetable({
                        type: 2,
                        colindex: ar
                    });

                },
                // các hàm custom phần check list

                timDonVi: function (args) {
                    var searchData = this.ds_don_vi;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("tenMaDonVi", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timCapHoc: function (args) {
                    var searchData = this.list_cap_hoc;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timTruongHoc: function (args) {
                    var searchData = this.ds_truong_hoc;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("tenMaTruong", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timTrangThai: function (args) {
                    var searchData = this.list_trang_thai_hs;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timLoaiKhuyetTat: function (args) {
                    var searchData = this.list_loai_khuyet_tat;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timLoaiNhapHoc: function (args) {
                    var searchData = this.list_loai_nhap_hoc;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timThoiHoc: function (args) {
                    var searchData = this.list_thoi_hoc;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timKhoiHoc: function (args) {
                    var searchData = this.list_khoi_hoc;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timloaiHinhDaoTao: function (args) {
                    var searchData = this.list_loai_hinh_truong;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timLoaiHopDong: function (args) {
                    var searchData = this.list_loai_hop_dong_lam_viec;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timNhomCanBo: function (args) {
                    var searchData = this.list_nhom_can_bo;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timTrinhDoChuyenMon: function (args) {
                    var searchData = this.list_trinh_do_chuyen_mon;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },

                timKhuVuc: function (args) {
                    var searchData = this.list_khu_vuc;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timLoaiCanBo: function (args) {
                    var searchData = this.list_loai_can_bo;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },

                timDoTuoi: function (args) {
                    var searchData = this.list_do_tuoi;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },
                timLoaiDanhGia: function (args) {
                    var searchData = this.list_danh_gia_chuan_nghe_nghiep;
                    var query = new Query();
                    query = (args.text != "") ?
                        query.where("name", "contains", args.text, true) :
                        query;
                    args.updateData(searchData, query);
                },

                //
                // Lấy trường học
                getTruongHoc() {
                    let params = {
                        "capHoc": this.CapHoc,
                        "maDonVi": this.DonViQuanLy
                    };
                    console.log("lấy trường")
                    // const loading2 = this.$loading({
                    //     lock: true,
                    //     text: 'Loading',
                    //     spinner: 'el-icon-loading',
                    //     background: 'rgba(0, 0, 0, 0.7)'
                    // });
                    rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, (data) => {
                        // loading2.close()
                        if (array_util.isArray(data.data.rows)) {
                            array_util.clearArrays(this.ds_truong_hoc);
                            this.ds_truong_hoc = data.data.rows;
                            for (let i = 0; i < this.ds_truong_hoc.length; i++) {
                                this.ds_truong_hoc[i].tenMaTruong = this.ds_truong_hoc[i].tenTruongHoc + " - [" +
                                    this.ds_truong_hoc[i].maTruongHoc + "]";
                            }
                        }
                    });
                },

                getDonVi() {
                    let params = {
                        start: 0,
                        limit: 999,
                        maTinhThanh: this.thongtin.ma_so
                    };
                    rest_api.get("/internal-api/dmDonVi/filter", params, data => {
                        if (array_util.isArray(data.data.rows)) {
                            array_util.clearArrays(this.ds_don_vi);
                            this.ds_don_vi = data.data.rows;
                            for (let i = 0; i < this.ds_don_vi.length; i++) {
                                this.ds_don_vi[i].tenMaDonVi = this.ds_don_vi[i].tenDonVi + " - [" + this.ds_don_vi[
                                    i].maDonVi + "]";
                            }
                        }
                    });
                },
                getDanToc() {
                    let ds_dt = localStorage["danh_sach_dan_toc_sme"];
                    if (ds_dt) {
                        this.ds_dan_toc = JSON.parse(ds_dt)
                    } else {
                        this.ds_dan_toc = [];
                    }
                },
                getTonGiao() {
                    let ds_tg = localStorage["danh_sach_ton_giao_sme"];
                    if (ds_tg) {
                        this.ds_ton_giao = JSON.parse(ds_tg)
                    } else {
                        this.ds_ton_giao = [];
                    }
                },
                LocNangCao() {
                    console.log("Lọc nâng cao");
                    this.show_fillter = true;
                },
                NhapDuLieuLoc() {
                    console.log("Nhập dữ liệu lọc");
                },
                onChonTieuChi(e) {
                    console.log("chọn tiêu chí" + JSON.stringify(e));
                    for (let i = 0; i < this.list_tieu_chi.length; i++) {
                        if (this.list_tieu_chi[i].index == e) {
                            this
                                .list_tieu_chi_chon
                                .push(this.list_tieu_chi[i]);
                            this
                                .list_tieu_chi[i]
                                .status = true;
                        }
                    }
                    this.LocCot();
                    return;
                },
                deleteListTieuChi(e) {
                    console.log("xóa tiêu chí" + e);
                    for (let i = 0; i < this.list_tieu_chi_chon.length; i++) {
                        if (e == i) {
                            console.log(this.list_tieu_chi_chon[i]);
                            this
                                .list_tieu_chi_chon
                                .splice(e, 1);
                        }
                    }
                    console.log("dãy sau:" + JSON.stringify(this.list_tieu_chi_chon));
                    return;
                    this
                        .list_tieu_chi_chon
                        .splice(e, 1);
                },
                checkDisabled(e) {
                    this.ResetDisabled();
                    for (let i = 0; i < e.length; i++) {
                        for (let j = 0; j < this.list_tieu_chi.length; j++) {
                            if (e[i] == this.list_tieu_chi[j].nameCol) {
                                console.log("12");
                                console.log(e[i]);
                                this
                                    .list_tieu_chi[j]
                                    .status = true;
                            }

                        }
                    }
                    console.log("sau khi check xem có những ai trong list tiêu chí đã chọn");
                    console.log(JSON.stringify(this.list_tieu_chi_chon));
                    // sau khi check xong thì đưa xuống lọc nâng cao
                    this.putIntoAdvancedFiltering();
                },
                putIntoAdvancedFiltering() {
                    this.check_doi_vien = false,
                        this.check_doan_vien = false,
                        this.check_dang_vien = false,
                        this.check_lop_ghep = false,
                        this.check_lop_chuyen = false,
                        this.check_doi_tuong_chinh_sach = false,
                        this.check_khuyet_tat = false,
                        this.check_loai_khuyet_tat = false,
                        this.check_thoi_hoc = false,
                        this.check_khoi_hoc = false,
                        this.check_loai_nhap_hoc = false,
                        this.check_dan_toc = false,
                        this.check_trang_thai = false,
                        this.check_don_vi_quan_ly = false,
                        this.check_ton_giao = false,
                        this.check_vung_chinh_sach = false,
                        this.check_bo_sung = false,
                        this.check_truong = false,
                        this.check_nam_hoc = false,
                        this.check_gioi_tinh = false,
                        this.check_dan_toc_thieu_so = false,
                        this.check_loai_hinh_truong = false,
                        this.check_khu_vuc = false,
                        this.check_cap_day = false;

                    console.log("check lọc nang cao gồm gì?");
                    for (let i = 0; i < this.list_tieu_chi_chon.length; i++) {
                        console.log(JSON.stringify(this.list_tieu_chi_chon));
                        if (this.list_tieu_chi_chon[i].nameCol == "maDonVi") {
                            // console.log("chọn có mã đơn vị");
                            this.check_don_vi_quan_ly = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "capHoc") {
                            // console.log("chọn có mã đơn vị");
                            this.check_cap_day = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "khoiHoc") {
                            // console.log("chọn có mã đơn vị");
                            this.check_khoi_hoc = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "maLyDoThoiHoc") {
                            // console.log("chọn có mã đơn vị");
                            this.check_thoi_hoc = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "loaiNhapHoc") {
                            // console.log("chọn có mã đơn vị");
                            this.check_loai_nhap_hoc = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "maDanToc") {
                            // console.log("chọn có mã đơn vị");
                            this.check_dan_toc = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "maLoaiKhuyetTat") {
                            // console.log("chọn có mã đơn vị");
                            this.check_loai_khuyet_tat = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "maTruongHoc") {
                            // console.log("chọn có mã đơn vị");
                            this.check_truong = true;
                            this.check_don_vi_quan_ly = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "namHoc") {
                            // console.log("chọn có mã đơn vị");
                            this.check_nam_hoc = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "trangThai") {
                            // console.log("chọn có mã đơn vị");
                            this.check_trang_thai = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "gioiTinh") {
                            // console.log("chọn có mã đơn vị");
                            this.check_gioi_tinh = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "loaiHinhDaoTao") {
                            // console.log("chọn có mã đơn vị");
                            this.check_loai_hinh_truong = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "maKhuVuc") {
                            // console.log("chọn có mã đơn vị");
                            this.check_khu_vuc = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "danToc") {
                            // console.log("chọn có mã đơn vị");
                            this.check_dan_toc_thieu_so = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "khuyetTat") {
                            // console.log("chọn có mã đơn vị");
                            this.check_khuyet_tat = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "dtuongCsach") {
                            // console.log("chọn có mã đơn vị");
                            this.check_doi_tuong_chinh_sach = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "lopGhep") {
                            // console.log("chọn có mã đơn vị");
                            this.check_lop_ghep = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "lopChuyen") {
                            // console.log("chọn có mã đơn vị");
                            this.check_lop_chuyen = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "doiVien") {
                            // console.log("chọn có mã đơn vị");
                            this.check_doi_vien = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "doanVien") {
                            // console.log("chọn có mã đơn vị");
                            this.check_doan_vien = true;
                        }
                        if (this.list_tieu_chi_chon[i].nameCol == "dangVien") {
                            // console.log("chọn có mã đơn vị");
                            this.check_dang_vien = true;
                        }
                    }

                },
                ResetDisabled() {
                    for (let i = 0; i < this.list_tieu_chi.length; i++) {
                        this
                            .list_tieu_chi[i]
                            .status = false;

                    }
                }
            }
        };

    </script>
    <style scoped="scoped">
        a,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        label,
        p,
        span {
            margin: 0;
            padding: 0;
        }

        .red {
            color: #DC0101;
            padding: 0 2px;
        }

        .list-advan label {
            font-weight: normal;
        }

        .inputieuchi {
            display: inline-block;
            line-height: 1;
            background: #ccc5c5;
            padding: 4px 10px;
            color: black;
            transition: background-color 3s linear;
        }

        .chon {
            height: 24px;
        }

        .locnangcao {
            padding: 5px;
            display: inline-flex;
        }

        .thongtinbosung {
            height: 34px;
            vertical-align: middle;
            align-items: center;
            display: flex;
        }

        .kichhoat {
            background: #64FE2E;
            transition: background-color 3s linear;
            color: black;
            margin-top: 1px;
            border-radius: 4px;
        }

        .thieutieuchi {
            /* background: #64FE2E; */
            border: 2px solid red;
        }

        .e-multiselect .e-multi-select-wrapper.e-down-icon,
        .e-multiselect.e-checkbox .e-multi-select-wrapper {
            border: 1px solid black;
        }

        .form-control {
            height: 30px;
        }

        .loader {
            border: 3px solid #f3f3f3;
            /* Light grey */
            border-top: 3px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .btn-info {
            position: relative;
        }

        .btn-info span {
            display: none;
            position: absolute;
            top: 5px;
            right: -25px;
        }

        .btn-info.show span {
            display: block;
        }

    </style>

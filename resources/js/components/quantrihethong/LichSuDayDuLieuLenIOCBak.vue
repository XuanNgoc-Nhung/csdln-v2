<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Kết chuyển dữ liệu lên IOC <span
                        class="kytu"> &raquo;</span> lịch sử đẩy dữ liệu lên IOC</span>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 timkiem">
                <label class="typo__label">Chọn đơn vị</label>
                <div v-if="thongtin.role<4">
                    <multiselect v-model="danhSachDonVi" :options="ds_don_vi_custom" group-values="libs"
                        group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                        deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextDonVi"
                        :close-on-select="false" :multiple="true" @close="ChonDonVi" :clear-on-select="false"
                        :preserve-search="false" deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                        :custom-label="setNameDonVi" placeholder="Chọn đơn vị" track-by="tenDonVi">
                        <template v-if="danhSachDonVi.length>0" slot="selection"
                            slot-scope="{ values, search, isOpen }">
                            <span class="multiselect__single"
                                v-if="values.length &amp;&amp; !isOpen">{{ danhSachDonVi.length }}
                                đơn vị được chọn</span>
                        </template>
                        <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                        <span slot="noOptions">Danh sách trống</span>
                    </multiselect>
                </div>
                <div v-if="thongtin.role==5||thongtin.role==4">
                    <input disabled v-model="tenDonViDangNhap" class="form-control" placeholder="Chọn" />

                </div>
                <!-- <pre class="language-json"><code>{{ danhSachDonVi }}</code></pre> -->
            </div>
            <!-- end đơn vị -->
            <!-- cấp học -->
            <div class="col-md-2 timkiem">
                <div>
                    <label class="typo__label">Chọn cấp học</label>
                    <div v-if="thongtin.role!=5">

                        <multiselect v-model="danhSachCapHoc" :options="ds_cap_hoc_custom" group-values="libs"
                            group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                            deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextCapHoc"
                            :close-on-select="false" @close="ChonCapHoc" :multiple="true" :clear-on-select="false"
                            :preserve-search="false" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                            selectedLabel="Đã chọn" :custom-label="setNameCapHoc" placeholder="Chọn cấp học"
                            label="name" track-by="name">
                            <template v-if="danhSachCapHoc.length>0" slot="selection"
                                slot-scope="{ values, search, isOpen }">
                                <span class="multiselect__single"
                                    v-if="values.length &amp;&amp; !isOpen">{{ danhSachCapHoc.length }}
                                    cấp học được chọn</span>
                            </template>
                            <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                            <span slot="noOptions">Danh sách trống</span>
                        </multiselect>
                    </div>
                    <div v-if="thongtin.role==5">
                        <input :disabled="thongtin.role == 5" class="form-control" placeholder="Cấp học"
                            :value="capHocDangNhap" />
                    </div>
                </div>
            </div>
            <!-- end cấp học -->
            <!-- Mã trường -->
            <!-- <div class="col-md-2 timkiem">
                <label>Mã trường học</label>
                <div v-if="thongtin.role!=5">
                    <input v-model="maTruongHoc" class="form-control" placeholder="Nhập..." />
                </div>
                <div v-if="thongtin.role==5">
                    <input :disabled="thongtin.role == 5" class="form-control" placeholder="Cấp học"
                        :value="thongtin.ma_truong_hoc" />
                </div>
            </div> -->
            <!-- hết mã trường -->
            <!-- Trường học -->
            <div class="col-md-4 timkiem">
                <div v-if="thongtin.role!=5">
                    <label class="typo__label">Chọn trường học</label>

                    <multiselect v-model="danhSachTruongHoc" :options="list_truong_hoc_custom" group-values="libs"
                        group-label="selectAll" :group-select="true" selectGroupLabel="Ấn để chọn tất cả"
                        deselectGroupLabel="Ấn để bỏ chọn tất cả" :limit="1" :limit-text="limitTextTruong"
                        :multiple="true" @close="ChonTruongHoc" :close-on-select="false" :clear-on-select="false"
                        deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                        :custom-label="setNameTruongHoc" placeholder="Chọn trường học" label="maTruongHoc"
                        track-by="maTruongHoc">
                        <template v-if="danhSachTruongHoc.length>0" slot="selection"
                            slot-scope="{ values, search, isOpen }">
                            <span class="multiselect__single"
                                v-if="values.length &amp;&amp; !isOpen">{{ danhSachTruongHoc.length }}
                                trường học được chọn</span>
                        </template>
                        <span slot="noResult">Không tìm thấy kết quả nào với từ khóa trên.</span>
                        <span slot="noOptions">Danh sách trống</span>
                    </multiselect>
                    <!--                    <multiselect v-model="danhSachTruongHoc" :options="list_truong_hoc" :multiple="true"-->
                    <!--                                 :close-on-select="false" :clear-on-select="false" deselectLabel="Đã chọn"-->
                    <!--                                 selectLabel="Chưa chọn" selectedLabel="Đã chọn" :custom-label="setNameTruongHoc"-->
                    <!--                                 placeholder="Chọn trường học" label="maTruongHoc" track-by="maTruongHoc">-->
                    <!--                        <template v-if="danhSachTruongHoc.length>1" slot="selection"-->
                    <!--                                  slot-scope="{ values, search, isOpen }">-->
                    <!--                            <span class="multiselect__single"-->
                    <!--                                  v-if="values.length &amp;&amp; !isOpen">{{ values.length }}-->
                    <!--                                trường học được chọn</span>-->
                    <!--                        </template>-->
                    <!--                    </multiselect>-->
                </div>
                <div v-if="thongtin.role==5">
                    <label>Trường học</label>
                    <input :disabled="thongtin.role == 5" :value="thongtin.display_name" class="form-control"
                        placeholder="Nhập..." />
                </div>
            </div>
            <!-- Hết trường học -->
            <!-- Năm học -->
            <div class="col-md-2 timkiem">
                <label class="typo__label">Năm học</label>
                <multiselect v-model="danhSachNamHoc" :options="list_nam_hoc" :custom-label="setNameNamHoc"
                    placeholder="Chọn năm học" label="name" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                    selectedLabel="Đã chọn" track-by="name"></multiselect>
            </div>
            <!-- Hết năm học -->
            <!-- học kỳ -->
            <div class="col-md-2 timkiem">
                <label>Học kỳ</label>
                <select v-model="hocKy" @change="ChonHocKy" class="form-control">
                    <option v-for="hk in list_hoc_ky" :value='hk.id'>
                        {{hk.name}}
                    </option>
                </select>
            </div>
            <!-- hết học kỳ -->
            <!-- Giai đoạn -->

            <div class="col-md-2">
                <label>Giai đoạn</label>
                <el-select v-model="giaiDoanKqht" filterable collapse-tags placeholder="Chọn"
                    no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                    <el-option v-for="item in list_giai_doan" :key="item.value" :label="item.name" :value="item.value">
                    </el-option>
                </el-select>
            </div>
            <!-- hết giai đoạn -->
            <!-- Đối tác -->
            <div class="col-md-2 timkiem">
                <label class="typo__label">Đối tác</label>
                <!-- <multiselect v-model="ds_doi_tac" :options="list_doi_tac" :multiple="true" :close-on-select="false"
                    :clear-on-select="false" deselectLabel="Đã chọn" selectLabel="Chưa chọn" selectedLabel="Đã chọn"
                    :custom-label="setNameDoiTac" placeholder="Chọn đối tác" label="maDoiTac" track-by="maDoiTac">
                    <template v-if="danhSachDoiTac.length>1" slot="selection" slot-scope="{ values, search, isOpen }">
                        <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }}
                            đối tác được chọn</span>
                    </template>
                </multiselect> -->
                <!-- {{ds_doi_tac}} -->
                <el-select v-model="ds_doi_tac" multiple filterable collapse-tags placeholder="Chọn"
                    no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                    <el-option v-for="item in list_doi_tac" :key="item.maDoiTac" :label="item.tenDoiTac"
                        :value="item.maDoiTac">
                    </el-option>
                </el-select>
            </div>
            <!-- Hết đối tác -->
<!--            <div class="col-md-2 timkiem">-->
<!--                <label class="typo__label">Loại dữ liệu</label>-->
<!--                <el-select v-model="ds_yeu_cau" filterable collapse-tags placeholder="Chọn"-->
<!--                    no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">-->
<!--                    <el-option v-for="item in list_yeu_cau" :key="item.key" :label="item.name" :value="item.key">-->
<!--                    </el-option>-->
<!--                </el-select>-->
<!--              -->
<!--                -->
<!--            </div>-->
            <!-- Hết đối tác -->
            <!-- trạng thái-->
            <div class="col-md-2 timkiem">
                <label class="typo__label">Trạng thái</label>
                <multiselect v-model="danhSachTrangThai" :options="list_trang_thai" :custom-label="setNameByIdValue"
                    placeholder="Chọn trạng thái" label="name" deselectLabel="Đã chọn" selectLabel="Chưa chọn"
                    selectedLabel="Đã chọn" track-by="name"></multiselect>
            </div>
            <!-- Hết trạng thái -->
            <!-- hết chỉ hiện trường chưa dẩy -->
        </div>

        <!-- end filter -->
        <!-- button -->
        <div class="row text-center">
            <button class="btn btn-success" @click.prevent="checkTruocKhiTimKiem()">Tìm kiếm
            </button>
            <button :disabled="listKetChuyen.length==0" class="btn btn-info" v-on:click.prevent="XuatExcel()">Xuất Excel
            </button>
        </div>
        <!-- <pre class="language-json"><code>{{params}}</code></pre> -->
        <!-- end button -->
        <!-- end header -->
        <!-- bảng hiển thị -->

        <div class="row" style="margin-top: 20px">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12" style="margin-bottom:10px;">
                                <div class="pull-right">
                                    <button class="btn btn-primary" v-if="hienthibutton" @click.prevent="dayLai"
                                        style="margin:2px 0; float:right">Đẩy lại</button>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="table-responsive row_tp">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th rowspan="2" class="text-center cg">
                                                    <p>STT</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Tên trường</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Mã trường</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Cấp học</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Đối tác</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Năm học</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Học kỳ</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Giai đoạn</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Loại dữ liệu</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Thời gian đẩy</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Trạng thái</p>
                                                </th>
                                                <th colspan="4" class="text-center cg">
                                                    <p>Bản ghi</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Xem lỗi</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg">
                                                    <p>Trạng thái của IOC</p>
                                                </th>
                                                <th rowspan="2" class="text-center cg" v-if="hienthibutton">
                                                    <input type="checkbox" v-model="slectAll">
                                                    <!-- <span>Chọn tất cả</span> -->
                                                </th>
                                            </tr>
                                            <tr style="background:#e4ebf5">
                                                <th class="text-center">
                                                    <p>Nhận từ QLNT</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Đẩy lên IOC <span style="color:#DC0101">*</span></p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Thành công</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Thất bại</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="listKetChuyen.length===0">
                                            <tr>
                                                <td class="text-center" colspan="18">Không có dữ
                                                    liệu phù hợp
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else="v-else">
                                            <tr v-for="(px,index) in listKetChuyen">
                                                <td class="text-center">{{(currentPage-1)*limit + index + 1}}</td>
                                                <td>{{px.tenTruong}}</td>
                                                <td>{{px.maTruong}}</td>
                                                <td>{{getCapHoc(px.capHoc)}}</td>
                                                <td>{{px.maDoiTac}}</td>
                                                <td>{{px.namHoc}}-{{parseInt(px.namHoc)+1}}</td>
                                                <td>
                                                    <p v-if="px.hocKy==1">Học kỳ I</p>
                                                    <p v-if="px.hocKy==2">Học kỳ II</p>
                                                    <p v-if="px.hocKy==3">Cả năm</p>
                                                </td>
                                                <td>
                                                    <p v-if="px.maGiaiDoan=='GK1'">Giữa kỳ I</p>
                                                    <p v-if="px.maGiaiDoan=='GK2'">Giữa kỳ II</p>
                                                    <p v-if="px.maGiaiDoan=='CK1'">Cuối kỳ I</p>
                                                    <p v-if="px.maGiaiDoan=='CK2'">Cuối kỳ II</p>
                                                </td>
                                                <td>
                                                    <p>{{getBuocHienTai(px.buocHienTai)}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>
                                                        {{px.timeStart}}
                                                    </p>
                                                </td>
                                                <td>
                                                    <p>{{getTrangThaiDay(px.trangThai)}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{px.banGhiNhan}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{px.banGhiGui}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{px.tongThanhCong}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{px.tongThatBai + px.tongHopLoi}}</p>
                                                </td>
                                                <td class="text-center" style="text-align:center">
                                                    <a v-if="(px.tongThatBai+px.tongHopLoi > 0 )" href="#"
                                                        title="Xem bản ghi lỗi" v-on:click.prevent="showInfo(px)">
                                                        <i class="fas fa-info-circle"></i>
                                                    </a>
                                                </td>
                                                <td>
                                                    <p v-if="px.error">{{px.error}} / {{px.errorDescription }}</p>
                                                </td>
                                                <td class="text-center" v-if="hienthibutton">
                                                    <input type="checkbox" v-model="lsDelete" :value="px.id">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                                </Page>
                                <!-- <template v-if="show_info"> -->
                                    <ThongTin :show="show_info" :item="idBanGhi" @success="onCreatedData($event)"
                                        @close="show_info=false"></ThongTin>
                                <!-- </template> -->

                                <div class="row">
                                    <div class="col-md-12">
                                        <label style="color:blue">Ghi chú:</label>
                                        <ul>
                                            <!-- <li>
                        <span style="color:#DC0101">*</span>:
                        <span>
                            <i>Thời gian là ngày nhận từ QLNT cuối. Filter thời gian chỉ áp dụng cho các
                                trường đã đẩy dữ liệu.</i>
                        </span>
                    </li>
                    <li>
                        <span style="color:#DC0101">**</span>:
                        <span>
                            <i>Khi tích chọn trường chưa đẩy, hệ thống sẽ chỉ hiện thỉ ra những trường chưa
                                hoàn thành việc đẩy dữ liệu.</i>
                        </span>
                    </li>
                    <li v-if="thongtin.role!=5">
                        <span style="color:#DC0101">***</span>:
                        <span>
                            <i>Danh sách trường chưa đẩy dữ liệu khác so với danh sách trường chưa hoàn
                                thành việc đẩy dữ liệu.</i>
                        </span>
                    </li> -->
                                            <li style="list-style-type: none;">
                                                <span style="color:#DC0101">*</span>:
                                                <span>Số lượng bản ghi KQHT đẩy lên IOC là kết quả của học sinh có trạng
                                                    thái đang học.</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- hết bảng hiển thị -->
    </div>

</template>
<script>
    import Multiselect from 'vue-multiselect'
    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import constant from "../../utils/constant";
    import datePicker from "vue-bootstrap-datetimepicker";
    import api from './../api';
    import utils from '../../utils'
    import moment from "moment";
    import ElementUI from 'element-ui';
    import Page from "../ui/PagingCustom";
    import ThongTin from "./ThongTinLichSuChuyenDuLieuLenBo";
    import VueAlertify from "vue-alertify";
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
            Page: Page,
            ThongTin: ThongTin
        },
        computed: {},
        data() {
            return {
                //custom chọn tất cả
                ds_don_vi_custom: [],
                list_truong_hoc_custom: [],
                ds_cap_hoc_custom: [{
                    selectAll: 'Chọn tất cả',
                    libs: []
                }, ],
                // thông tin người đăng nhập
                date: new Date(),
                slectAll: false,
                hienthibutton: false,
                namHocHienTai: "",
                tenDonViDangNhap: "",
                capHocDangNhap: "",
                thongTinTrangCu: {},
                thongtin: {},
                list_don_vi: [],
                lsDelete: [],

                list_dong_bo_du_lieu_hk1: constant.list_dong_bo_du_lieu_hk1,
                list_dong_bo_du_lieu_hk2: constant.list_dong_bo_du_lieu_hk2,
                list_dong_bo_du_lieu_cn: constant.list_dong_bo_du_lieu_cn,
                list_yeu_cau: constant.list_dong_bo_du_lieu_day_len_bo_full,
                list_yeu_cau_full: constant.list_dong_bo_du_lieu_day_len_bo_full,

                list_trang_thai: constant.list_trang_thai_day_len_bo,
                list_cap_hoc: window.listCapHoc,
                list_truong_hoc: [],
                list_doi_tac: [],
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_hoc_ky: constant.LIST_HOC_KY,
                //
                listKetChuyen: [],
                ds_don_vi: [],
                ds_cap_hoc: [],
                ds_doi_tac: [],
                ds_yeu_cau: "",
                ds_trang_thai: "",
                ds_truong_hoc: [],
                params: {},
                namHoc: "",
                total_rows: 0,
                start: 0,
                limit: 25,
                currentPage: 1,
                //
                danhSachDonVi: [],
                danhSachCapHoc: [],
                maTruongHoc: "",
                danhSachLoaiYeuCau: [],
                danhSachTrangThai: [],
                danhSachTruongHoc: [],
                danhSachNamHoc: [],
                danhSachDoiTac: [],
                hocKy: 1,
                giaiDoanKqht: "",
                idBanGhi: "",
                show_info: false,
                trangbatdau: false,
                list_giai_doan: JSON.parse(localStorage["danh_sach_giai_doan_kqht_sme"]),
            };
        },

        mounted() {
            // khai báo thông tin đăng nhập

            this.thongtin = JSON.parse(window.userInfo);
            this.ds_cap_hoc_custom[0].libs = this.list_cap_hoc;
            this.checkQuyenDayDL();
            this.namHocHienTai =  this.thongtin.namHocHienTai;
            this.findNamHoc();
            if (this.thongtin.role == 5) {
                this.bindCapHocDangNhap();
            }

            this.getDonVi(() => {
                console.log("trang cũ nè:" + this.trangcu);
                console.log("trang cũ nè:" + this.trangcu.length);
                if (this.trangcu == "[]") {
                    console.log("trang cũ là 1 mảng");
                    // không tồn tại trang cũ
                    // this.getDanhSachLichSuChuyenDuLieu();
                } else {
                    console.log("trang cũ tồn tại");
                    this.thongTinTrangCu = this.trangcu;
                    console.log(this.thongTinTrangCu);
                    console.log("check:");
                    console.log("123456:" + JSON.stringify(this.thongTinTrangCu));
                    this.chuyenHuong(() => {
                        console.log("chuyeern huowngs xong");
                        console.log(JSON.stringify(this.thongTinTrangCu));
                    });
                }

            });
            this.getTruongHoc();
            this.getListDoiTac();

        },

        watch: {
            slectAll: function (newVal) {
                if (newVal) {
                    this.lsDelete = [];
                    for (let i = 0; i < this.listKetChuyen.length; i++) {
                        this
                            .lsDelete
                            .push(this.listKetChuyen[i].id);
                    }
                } else {
                    this.lsDelete = [];
                }
            },
            danhSachCapHoc: function (newVal) {

            },

            danhSachTruongHoc: function (newVal) {

                console.log("map trường xong:");
                console.log(JSON.stringify(this.ds_truong_hoc))
            },
            danhSachNamHoc: function (newVal) {
                console.log("watch Năm học");
                this.namHoc = "";
                this.params = {};
                if (newVal) {
                    this.namHoc = newVal
                        .id
                    console
                        .log("map xong:" + JSON.stringify(this.namHoc));
                }
            },

            danhSachDoiTac: function (newVal) {
                this.ds_doi_tac = [];
                this.params = {};
                if (newVal) {
                    let lsdt = newVal.map((obj) => {
                        return obj['maDoiTac']
                    });
                    this.ds_doi_tac = lsdt;
                }
                console.log("map xong đối tác:" + JSON.stringify(this.ds_doi_tac));
            },
            danhSachLoaiYeuCau: function (newVal) {
                console.log("watch loại yêu cầu:" + JSON.stringify(newVal));
                this.params = {};
                this.ds_yeu_cau = "";
                if (newVal) {
                    this.ds_yeu_cau = newVal.id
                }
                console.log("CHọn xong loại yêu cầu:" + this.ds_yeu_cau);
            },
            danhSachTrangThai: function (newVal) {
                console.log("watch đối tác");
                this.ds_trang_thai = "";
                this.params = {};
                if (newVal) {
                    this.ds_trang_thai = newVal.id
                }
                console.log("CHọn xong đối tác:" + this.ds_trang_thai);
            }
        },
        methods: {
            getBuocHienTai(e) {
                for (let i = 0; i < this.list_yeu_cau_full.length; i++) {
                    if (this.list_yeu_cau_full[i].key == e) {
                        return this.list_yeu_cau_full[i].name;
                    }
                }
            },
            ChonHocKy() {
                this.danhSachLoaiYeuCau = "";
                this.list_yeu_cau = [];
                console.log("chọn học kỳ");
                if (this.hocKy == 1) {
                    this.list_yeu_cau = this.list_yeu_cau_full
                }
                if (this.hocKy == 2) {
                    this.list_yeu_cau = this.list_yeu_cau_full
                }
                if (this.hocKy == 3) {
                    this.list_yeu_cau = this.list_yeu_cau_full
                }
            },
            checkQuyenDayDL() {

                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                rest_api.get("/csdlgd-admin/duyetDayDuLieu/checkDayDuLieu", {}, (data) => {
                    loading.close();
                    this.hienthibutton = data.data.item;
                });
            },
            checkTruocKhiTimKiem() {
                this.trangbatdau = !this.trangbatdau;
            },
            ChonTruongHoc() {
                console.log("Chọn trường học");
                this.ds_truong_hoc = [];
                this.params = {};
                if (this.danhSachTruongHoc) {
                    let lsth = this.danhSachTruongHoc.map((obj) => {
                        return obj['maTruongHoc']
                    });
                    this.ds_truong_hoc = lsth;
                }
                console.log("Chọn xong trường:" + this.ds_truong_hoc)
            },
            ChonCapHoc() {
                this.thongTinTrangCu = [];
                console.log("Chọn cấp hocj cấp học");
                this.ds_cap_hoc = [];
                this.list_truong_hoc_custom = [];
                this.params = {};
                this.ds_truong_hoc = [];
                this.danhSachTruongHoc = [];
                if (this.danhSachCapHoc) {
                    let lsch = this.danhSachCapHoc.map((obj) => {
                        return obj['id']
                    });
                    this.ds_cap_hoc = lsch;
                }
                this.getTruongHoc();
            },
            ChonDonVi() {
                console.log("mới chọn đơn vị xong");
                this.ds_don_vi = [];
                this.list_truong_hoc_custom = [];
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
                console.log('xong:' + this.ds_don_vi)
                this.getTruongHoc();

            },
            limitTextTruong(count) {
                return `và ${count} trường học khác`
            },
            limitTextCapHoc(count) {
                return `và ${count} cấp học khác`
            },
            limitTextDonVi(count) {
                return `và ${count} đơn vị khác`
            },

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
            // tìm cấp học

            getCapHoc(loai) {
                var res = loai;
                switch (loai) {
                    case 1:
                        res = 'Cấp 1'
                        break;
                    case 2:
                        res = 'Cấp 2'
                        break;
                    case 3:
                        res = 'Cấp 3'
                        break;
                    case 4:
                        res = 'Nhà trẻ'
                        break;
                    case 5:
                        res = 'Mẫu giáo'
                        break;
                    case 6:
                        res = 'GDTX'
                        break;
                    case 12:
                        res = 'Liên cấp 1+2'
                    case 13:
                        res = 'Liên cấp 1+3'
                    case 23:
                        res = 'Liên cấp 2+3'
                        break;
                    case 123:
                        res = 'Liên cấp 1+2+3'
                    default:
                        res = loai;
                }
                return res;
            },
            // gán năm học

            findNamHoc() {
                console.log("năm học hiện tại a:" + this.namHocHienTai);
                for (let i = 0; i < this.list_nam_hoc.length; i++) {
                    console.log("năm" + JSON.stringify(this.list_nam_hoc[i]));
                    if (this.list_nam_hoc[i].id == this.namHocHienTai) {
                        this.danhSachNamHoc = this.list_nam_hoc[i];
                    }
                }
            },
            // bind dữ liệu khi chuyển hướng
            chuyenHuong(ch = () => {}) {
                window
                    .history
                    .replaceState("", "CSDL Ngành", "moet-transfer-history");
                this.thongTinTrangCu = JSON.parse(this.thongTinTrangCu)
                // alert(this.thongTinTrangCu); return
                console.log("trang cũ nè:" + JSON.stringify(this.thongTinTrangCu));
                if (this.thongTinTrangCu.namHoc) {
                    // Nếu có năm học
                    for (let i = 0; i < this.list_nam_hoc.length; i++) {
                        if (this.list_nam_hoc[i].id == this.thongTinTrangCu.namHoc) {
                            this.danhSachNamHoc = this.list_nam_hoc[i];
                            console.log("Năm học: " + JSON.stringify(this.danhSachNamHoc));
                        }
                    }
                }
                if (this.thongTinTrangCu.maTruongHoc) {
                    this.getTruongHoc(() => {
                        for (let i = 0; i < this.list_truong_hoc.length; i++) {
                            if (this.list_truong_hoc[i].maTruongHoc == this.thongTinTrangCu.maTruongHoc) {
                                this.danhSachTruongHoc = [this.list_truong_hoc[i]];
                                this.ds_truong_hoc = this
                                    .danhSachTruongHoc
                                    .map((obj) => obj.maTruongHoc);
                                ch();
                            }
                        }

                        this.getDanhSachLichSuChuyenDuLieu();
                    })
                    console.log("lấy trường chuyển hướng");
                }

                // this.getDanhSachLichSuChuyenDuLieu(); if (this.chuyenhuong.dotDay) {
                // this.idDay = this.chuyenhuong.dotDay; console.log("đợt đẩy" + this.idDay) }
                // setTimeout(() => { }, 200);
            },
            // xuất excel

            XuatExcel() {

                let url = "xuat-excel-lich-su-day-du-lieu-len-bo";

                let params = {
                    hocKy: parseInt(this.hocKy),
                    maGiaiDoanKqht: this.giaiDoanKqht,
                    maTruongHoc: this.maTruongHoc,
                    namHoc: this.namHoc,
                    trangThai: "",
                    loaiYeuCau: "",
                    maDonVis: [],
                    maCapHocs: [],
                    maTruongs: [],
                    maDoiTacs: []
                };
                console.log("params lúc đầu:" + JSON.stringify(params));
                if (this.ds_don_vi.length > 0) {
                    params.maDonVis = this.ds_don_vi;

                }
                if (this.ds_cap_hoc.length > 0) {
                    params.maCapHocs = this.ds_cap_hoc;
                }
                if (this.ds_truong_hoc.length > 0) {
                    params.maTruongs = this.ds_truong_hoc;
                }
                if (this.ds_doi_tac.length > 0) {
                    params.maDoiTacs = this.ds_doi_tac;
                }
                if (this.ds_yeu_cau != "") {
                    params.loaiYeuCau = this.ds_yeu_cau;
                }
                if (this.ds_trang_thai != "") {
                    params.trangThai = this.ds_trang_thai;
                }
                console.log("sau:" + JSON.stringify(params));
                this.params = params;

                if (this.thongtin.role == 4) {
                    params.maDonVi = this.thongtin.ma_don_vi;
                };
                if (this.thongtin.role == 5) {
                    params.maTruongHoc = this.thongtin.ma_truong_hoc;
                };


                utils.confirmDialog(
                    "Xác nhận tải xuống dữ liệu. Vui lòng chờ trong thời gian tải xuống",
                    "Đống ý",
                    () => {
                        api.post(url, params, (data) => {
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
                )
            },
            // hiển thị thông tin

            showInfo(e) {
                console.log("xem thông tin:" + JSON.stringify(e));
                this.idBanGhi = e;
                this.show_info = true;
            },

            layLai(e) {
                // console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.lsDelete = [];
                this.selectAll = false;
                this.currentPage = e.currentPage;
                this.getDanhSachLichSuChuyenDuLieu();
            },
            dayLai() {
                if (this.lsDelete.length > 0) {
                    utils.confirmDialog(
                        "Xác nhận đẩy lại thông tin đã chọn?",
                        "Đồng ý",
                        () => {
                            console.log("Đồng ý xóa danh sách học sinh:");
                            console.log(this.lsDelete);
                            let params = {
                                listId: this.lsDelete,
                            };
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                            rest_api.post("/csdlgd-admin/dayLenBo/updateDayLai", params, data => {
                                loading.close();
                                if (data.data.rc == 0) {
                                    this
                                        .$alertify
                                        .success("Chờ tổng hợp");
                                    this.trangbatdau = !this.trangbatdau;
                                    this.lsDelete = [];
                                    this.slectAll = false;
                                } else {
                                    this
                                        .$alertify
                                        .error(data.data.rd)
                                }
                            });
                        }
                    );
                } else {
                    this
                        .$alertify
                        .error("Vui lòng chọn ít nhất 1 bản ghi.")
                }
            },
            // lấy tên trạng thái đẩy\
            getTrangThaiDay(loai) {
                var res = loai;
                switch (loai) {
                    case 0:
                        res = 'Chờ đẩy'
                        break;
                    case 1:
                        res = 'Đang đẩy'
                        break;
                    case 2:
                        res = 'Đẩy thành công'
                        break;
                    case 3:
                        res = 'Đẩy lỗi'
                        break;
                    case 4:
                        res = 'Cần đẩy lại'
                        break;
                    case 5:
                        res = 'Thiếu mật khẩu kết chuyển'
                        break;
                    case 9:
                        res = 'Chờ tổng hợp'
                        break;
                    case 10:
                        res = 'Đang tổng hợp'
                        break;
                    case 11:
                        res = 'Tổng hợp xong'
                        break;
                    case 12:
                        res = 'Tổng hợp lỗi'
                        break;
                    case 13:
                        res = 'Hoàn thành'
                        break;
                    case 6:
                        res = 'Tài khoản kết chuyển không chính xác'
                        break;
                    default:
                        res = "Chưa rõ";
                }
                return res;

            },
            // check trước khi lấy dữ liệu
            getDanhSachLichSuChuyenDuLieu() {
                let params = {
                    start: this.start,
                    limit: this.limit,
                    hocKy: parseInt(this.hocKy),
                    maGiaiDoanKqht: this.giaiDoanKqht,
                    maTruongHoc: this.maTruongHoc,
                    namHoc: this.namHoc,
                    trangThai: "",
                    loaiYeuCau: "",
                    maDonVis: [],
                    maCapHocs: [],
                    maTruongs: [],
                    maDoiTacs: []
                };
                console.log("params lúc đầu:" + JSON.stringify(params));
                if (this.ds_don_vi.length > 0) {
                    params.maDonVis = this.ds_don_vi;

                }
                if (this.ds_cap_hoc.length > 0) {
                    params.maCapHocs = this.ds_cap_hoc;
                }
                if (this.ds_truong_hoc.length > 0) {
                    params.maTruongs = this.ds_truong_hoc;
                }
                if (this.ds_doi_tac.length > 0) {
                    params.maDoiTacs = this.ds_doi_tac;
                }
                if (this.ds_yeu_cau != "") {
                    params.loaiYeuCau = this.ds_yeu_cau;
                }
                if (this.ds_trang_thai != "") {
                    params.trangThai = this.ds_trang_thai;
                }
                console.log("sau:" + JSON.stringify(params));
                this.params = params;

                if (this.thongtin.role == 4) {
                    params.maDonVi = this.thongtin.ma_don_vi;
                };
                if (this.thongtin.role == 5) {
                    params.maTruongHoc = this.thongtin.ma_truong_hoc;
                };
                console.log(JSON.stringify(params));

                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                rest_api.post("/csdlgd-push/LichSuDay/DanhSachTruong", params, data => {
                    loading.close()
                    if (data.data.statusResponse == 0) {
                        this.listKetChuyen = data.data.rows;
                        console.log(JSON.stringify(this.listKetChuyen[0]));
                        if (data.data.rows == null) {
                            this.listKetChuyen = [];
                        }
                        this.total_rows = data.data.total;
                        if (this.total_rows == 0) {
                            // this
                            //     .$alertify
                            //     .error("Không có bản ghi nào được tìm thấy.");
                            return;
                        }
                        if (this.total_rows > 0) {
                            // this
                            //     .$alertify
                            //     .success("Lấy dữ liệu thành công.");
                            return;
                        }
                    } else {
                        this
                            .$alertify
                            .error(data.data.rd);
                        return;
                    }
                }, 60000, true);
                return;
            },
            // Lấy danh sách trường học Lấy trường học
            getTruongHoc(gt = () => {}) {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.ds_don_vi,
                    capHoc: this.ds_cap_hoc
                };
                if (this.thongTinTrangCu.maTruongHoc) {
                    params.maTruong = this.thongTinTrangCu.maTruongHoc;
                }
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    console.log("lấy trường");
                    if (data.data.code == 200) {
                        this.list_truong_hoc = data.data.rows;
                        let obj = {
                            selectAll: 'Chọn tất cả',
                            libs: this.list_truong_hoc
                        };
                        this.list_truong_hoc_custom = [obj];
                        gt();
                    }
                });
            },
            // Lấy danh sách đối tác

            getListDoiTac() {
                let params = {
                    start: 0,
                    limit: 99999,
                    trangThai: 1
                };
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                rest_api.get("/internal-api/heThongDoiTac/filter", params, data => {
                    loading.close();
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_doi_tac);
                        this.list_doi_tac = data.data.rows;
                    }
                });
            },

            // Lấy danh sách đơn vị
            getDonVi(ck = () => {}) {
                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.ma_so
                };
                console.log("pr ẻty" + JSON.stringify(params));
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    loading.close();
                    // console.log("lấy đơn vị thành công" + JSON.stringify(data));
                    if (array_util.isArray(data.data.rows)) {
                        array_util.clearArrays(this.list_don_vi);
                        this.list_don_vi = data.data.rows;
                        let obj = {
                            selectAll: 'Chọn tất cả',
                            libs: this.list_don_vi
                        }
                        this.ds_don_vi_custom = [obj];
                        if (this.thongtin.role == 5 || this.thongtin.role == 4) {
                            for (let i = 0; i < this.list_don_vi.length; i++) {
                                if (this.list_don_vi[i].maDonVi == this.thongtin.ma_don_vi) {
                                    this.tenDonViDangNhap = this.list_don_vi[i].tenDonVi;
                                }
                            }
                        }
                        ck();
                    }
                });
            },

            // set name định nghĩa cho đơn vị
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
            // định nghĩa cho đối tác
            setNameDoiTac({
                tenDoiTac,
                maDoiTac
            }) {
                return `${tenDoiTac} - [${maDoiTac}]`
            },
            // định nghĩa cho trạng thái
            setNameByIdValue({
                name
            }) {
                return `${name}`
            }, // định nghĩa cho trạng thái
            setNameDanhSachDongBo({
                name
            }) {
                return `${name}`
            },
            // Lấy danh sách đơn vị
        }
    };

</script>
<style scoped="scoped">

    .row_tp {
        margin-top: 0;
    }

    p {
        padding: 0;
        margin: 0;
        font-size: 12px;
    }

    .cg {
        vertical-align: middle;
    }

</style>

<template>
  <div id="modal_chinhsua_truonghoc" ref="modal_chinhsua_truonghoc" class="modal fade">
    <div class="modal-dialog" style="width: 90%">
      <div class="modal-content">
        <form @submit.prevent="suaTruongHocSubmit">
          <div class="modal-header">
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-hidden="true"
              v-on:click="close()"
            >&times;</button>
            <h4 class="modal-title text-uppercase">Chỉnh sửa trường học</h4>
          </div>
          <div class="modal-body clearfix">
            <div style="padding-top: 10px">
              <div class="form-group clearfix">
                <div class="col-sm-3 inputhemtruong">
                  <label>
                    Mã trường học (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <input
                    disabled
                    v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }"
                    name="ma_truong_hoc"
                    type="text"
                    min="0"
                    v-model="ma_truong_hoc"
                    placeholder="Nhập..."
                    class="form-control control-inline"
                  />
                  <span
                    class="text-danger"
                    v-show="errors.has('ma_truong_hoc')"
                  >{{ errors.first('ma_truong_hoc') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>
                    Tên trường học (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <input
                    v-validate="{ required: true }"
                    name="ten_truong_hoc"
                    type="text"
                    min="0"
                    v-model="ten_truong_hoc"
                    placeholder="Nhập..."
                    class="form-control control-inline"
                  />
                  <span
                    class="text-danger"
                    v-show="errors.has('ten_truong_hoc')"
                  >{{ errors.first('ten_truong_hoc') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>
                    Cấp học (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <select
                    v-validate="{ required: true }"
                    name="capHoc"
                    class="form-control"
                    v-model="capHoc"
                  >
                    <option value>Chọn cấp học</option>
                    <option v-for="ch in ds_cap_hoc" :value="ch.id">{{ch.name}}</option>
                  </select>
                    <span
                      class="text-danger"
                      v-show="errors.has('capHoc')"
                    >{{ errors.first('capHoc') }}</span>
                </div>

                <div class="col-sm-3 inputhemtruong">
                  <label>
                    Chuẩn quốc gia (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <select
                    v-validate="{ required: true }"
                    name="chuan_quoc_gia"
                    @change="onTinhThanhChange"
                    v-model="chuan_quoc_gia"
                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                  >
                    <option value>--Chọn chuẩn quốc gia--</option>
                    <option value="0">Không đạt chuẩn</option>
                    <option value="1">Chuẩn mức 1</option>
                    <option value="2">Chuẩn mức 2</option>
                  </select>
                  <span
                    class="text-danger"
                    v-show="errors.has('chuan_quoc_gia')"
                  >{{ errors.first('chuan_quoc_gia') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>
                    Tỉnh thành (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <select
                    v-validate="{ required: true }"
                    name="ma_tinh_thanh"
                    @change="onTinhThanhChange"
                    v-model="ma_tinh_thanh"
                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                  >
                    <option value>--Chọn tỉnh thành--</option>
                    <option v-for="tt in ds_tinh_thanh" :value="tt.maTinhThanh">{{tt.tenTinhThanh}}</option>
                  </select>
                  <span
                    class="text-danger"
                    v-show="errors.has('ma_tinh_thanh')"
                  >{{ errors.first('ma_tinh_thanh') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>
                    Quận huyện (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <select
                    v-validate="{ required: true }"
                    name="ma_quan_huyen"
                    @change="onQuanHuyenChange"
                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                    v-model="ma_quan_huyen"
                  >
                    <option value>--Chọn quận huyện--</option>
                    <option v-for="qh in ds_quan_huyen" :value="qh.maQuanHuyen">{{qh.tenQuanHuyen}}</option>
                  </select>
                  <span
                    class="text-danger"
                    v-show="errors.has('ma_quan_huyen')"
                  >{{ errors.first('ma_quan_huyen') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>Phường xã</label>
                  <select
                    v-validate="{ required: true }"
                    name="ma_phuong_xa"
                    @change="onPhuongXaChange"
                    v-model="ma_phuong_xa"
                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                  >
                    <option value>--Chọn phường xã--</option>
                    <option v-for="px in ds_phuong_xa" :value="px.maPhuongXa">{{px.tenPhuongXa}}</option>
                  </select>
                  <span
                    class="text-danger"
                    v-show="errors.has('ma_phuong_xa')"
                  >{{ errors.first('ma_phuong_xa') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>Tổ thôn</label>
                  <select
                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                  >
                    <option value>--Chọn tổ thôn--</option>
                    <option v-for="tt in ds_to_thon" :value="tt.maToThon">{{tt.tenToThon}}</option>
                  </select>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>Đơn vị quản lý</label>
                  <select
                    v-model="ma_don_vi_quan_ly"
                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                  >
                    <option value>--Chọn đơn vị--</option>
                    <option v-for="dv in ds_don_vi_quan_ly" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                  </select>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>
                    Loại hình đào tạo (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <select
                    v-validate="{ required: true }"
                    name="loai_hinh_dao_tao"
                    v-model="loai_hinh_dao_tao"
                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                  >
                    <option value>--Tất cả--</option>
                    <option value="1">Công lập</option>
                    <option value="2">Tư thục</option>
                    <option value="3">GDTX</option>
                    <option value="4">Bán công</option>
                    <option value="5">Dân lập</option>
                  </select>
                  <span
                    class="text-danger"
                    v-show="errors.has('loai_hinh_dao_tao')"
                  >{{ errors.first('loai_hinh_dao_tao') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>
                    Loại hình trường (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <select
                    v-validate="{ required: true }"
                    name="loai_hinh_truong"
                    v-model="loai_hinh_truong"
                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                  >
                    <option value>--Chọn loại hình trường--</option>
                    <option value="1">Bình thường</option>
                    <option value="2">Dân tộc nội trú</option>
                    <option value="3">Khuyết tật</option>
                    <option value="4">Năng khiếu nghệ thuật</option>
                    <option value="5">Năng khiếu TDTT</option>
                    <option value="6">Trường chuyên</option>
                    <option value="7">Dân tộc bán trú</option>
                    <option value="8">Trường THPT kỹ thuật</option>
                    <option value="9">Trẻ em thiệt thòi</option>
                  </select>
                  <span
                    class="text-danger"
                    v-show="errors.has('loai_hinh_truong')"
                  >{{ errors.first('loai_hinh_truong') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>Website</label>
                  <input
                    type="text"
                    min="0"
                    v-model="website"
                    placeholder="Nhập..."
                    class="form-control control-inline"
                  />
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>Số điện thoại</label>
                  <input
                    v-validate="{max:10, regex: /0[0-9]{9}/}"
                    name="so_dien_thoai"
                    type="text"
                    min="0"
                    v-model="so_dien_thoai"
                    placeholder="Nhập..."
                    class="form-control control-inline"
                  />
                  <span
                    class="text-danger"
                    v-show="errors.has('so_dien_thoai')"
                  >{{ errors.first('so_dien_thoai') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>Email</label>
                  <input
                    v-validate="{email : true}"
                    name="email"
                    type="text"
                    min="0"
                    v-model="email"
                    placeholder="Nhập..."
                    class="form-control control-inline"
                  />
                  <span class="text-danger" v-show="errors.has('email')">{{ errors.first('email') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>Fax</label>
                  <input
                    type="text"
                    min="0"
                    v-model="fax"
                    placeholder="Nhập..."
                    class="form-control control-inline"
                  />
                </div>

                <div class="col-sm-3 inputhemtruong">
                  <label>Tên hiệu trưởng</label>
                  <input
                    type="text"
                    min="0"
                    v-model="ten_hieu_truong"
                    placeholder="Nhập..."
                    class="form-control control-inline"
                  />
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>SĐT hiệu trưởng</label>
                  <input
                    v-validate="{max:10, regex: /0[0-9]{9}/}"
                    name="so_dien_thoai_hieu_truong"
                    type="text"
                    min="0"
                    v-model="so_dien_thoai_hieu_truong"
                    placeholder="Nhập..."
                    class="form-control control-inline"
                  />
                  <span
                    class="text-danger"
                    v-show="errors.has('so_dien_thoai_hieu_truong')"
                  >{{ errors.first('so_dien_thoai_hieu_truong') }}</span>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>Ngày thành lập</label>
                  <date-picker
                    v-model="ngay_thanh_lap"
                    :config="configDate"
                    placeholder="Chọn ngày thành lập "
                  ></date-picker>
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>Địa chỉ</label>
                  <input
                    type="text"
                    min="0"
                    v-model="dia_chi"
                    placeholder="Nhập..."
                    class="form-control control-inline"
                  />
                </div>
                <div class="col-sm-3 inputhemtruong">
                  <label>Trạng thái</label>
                  <select
                    v-model="trang_thai"
                    class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                  >
                    <option value="1">Đang hoạt động</option>
                    <option value="0">Ngừng hoạt động</option>
                  </select>
                </div>
                <div class="col-sm-3 inputhemtruong">
                    <div style="width:50%; float:left;">
                  <input
                    :checked="vung_kho_khan"
                    id="vung_kho_khan"
                    type="checkbox"
                    v-model="vung_kho_khan"
                  />
                  <label for="vung_kho_khan">Vùng khó khăn</label>
                  </div>
                  <div style="width:50%; float:left;">
                  <input
                    :checked="vung_bien_gioi"
                    id="vung_bien_gioi"
                    type="checkbox"
                    v-model="vung_bien_gioi"
                  />
                  <label>Vùng biên giới</label></div>
                  <div style="width:50%; float:left;">
                  <input
                    :checked="chi_bo_dang"
                    id="chi_bo_dang"
                    type="checkbox"
                    v-model="chi_bo_dang"
                  />
                  <label>Chi bộ đảng</label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer clearfix">
            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-primary">Sửa</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import rest_api from "../../utils/rest_api";
import array_util from "../../utils/array_utils";
import time_utils from "../../utils/time_utils";
import utils from "../../utils";
import api from "../api";
import constant from "../../utils/constant";
import "pc-bootstrap4-datetimepicker/build/css/bootstrap-datetimepicker.css";
import datePicker from "vue-bootstrap-datetimepicker";
import vi from "vee-validate/dist/locale/vi";
import VeeValidate, { Validator } from "vee-validate";
//Validator.localize('vi', vi);
Vue.use(VeeValidate);

$(document).ready(function() {
  console.log("ready!");
});

export default {
  props: ["item", "show"],
  components: {
    datePicker
  },
  watch: {
    show: function(newVal, oldVal) {
      console.log("newVal = " + newVal);
      if (newVal) {
        //this.reset();
        $("#modal_chinhsua_truonghoc").modal();
      } else {
        $("#modal_chinhsua_truonghoc").modal("hide");
      }
    },
    item: function(newVal, oldVal) {
      this.thongTinTruongHoc = newVal;
      console.log(
        "Dữ liệu chỉnh sửa:" + JSON.stringify(this.thongTinTruongHoc)
      );
      this.ma_truong_hoc = newVal.maTruongHoc;
      this.ten_truong_hoc = newVal.tenTruongHoc;
      this.ma_tinh_thanh = newVal.maTthanh;
      this.ma_quan_huyen = newVal.maQhuyen;
      this.ma_phuong_xa = newVal.maPxa;
      this.ma_to_thon = newVal.maTthon;
      this.ma_don_vi_quan_ly = newVal.maDonVi;
      this.loai_hinh_dao_tao = newVal.loaiHinhDaoTao;
      this.loai_hinh_truong = newVal.loaiHinhTruong;
      this.website = newVal.website;
      this.so_dien_thoai = newVal.sdt;
      this.email = newVal.email;
      this.fax = newVal.fax;
      this.vung_kho_khan = newVal.vungKhoKhan;
      this.vung_bien_gioi = newVal.vungBienGioi;
      this.chi_bo_dang = newVal.chiBoDang;
      this.dia_chi = newVal.diaChi;
      this.so_dien_thoai_hieu_truong = newVal.sdtHieuTruong;
      this.ngay_thanh_lap = time_utils.convertDateDatNT(newVal.ngayThanhLap);
    //   this.setCapHoc(newVal.capHoc);
      this.capHoc=newVal.capHoc;
    //   this.cap_hoc = this.getCapHoc(newVal.capHoc);
      this.chuan_quoc_gia = newVal.chuanQuocGia;

      this.getQuanHuyen();
      this.getPhuongXa();
      this.getToThon();
      this.getDanhSachDonViQuanLy();
      console.log("ngay thanh lap : " + newVal.ngayThanhLap);
    }
  },

  data() {
    return {
      capHoc: "",
      ds_cap_hoc: constant.LIST_CAP_HOC,
      ds_tinh_thanh: [],
      ds_quan_huyen: [],
      ds_phuong_xa: [],
      ds_to_thon: [],
      ma_truong_hoc: "",
      ten_truong_hoc: "",
      ma_tinh_thanh: "",
      ma_quan_huyen: "",
      ma_phuong_xa: "",
      cap_hoc: "",
      nha_tre: false,
      mau_giao: false,
      cap_mot: false,
      cap_hai: false,
      cap_ba: false,
      loai_hinh_dao_tao: "",
      loai_hinh_truong: "",
      ds_don_vi_quan_ly: [],
      ma_don_vi_quan_ly: "",
      chuan_quoc_gia: "",
      vung_kho_khan: false,
      vung_bien_gioi: false,
      chi_bo_dang: false,
      website: "",
      so_dien_thoai: "",
      email: "",
      fax: "",
      ngay_thanh_lap: "",
      ten_hieu_truong: "",
      so_dien_thoai_hieu_truong: "",
      dia_chi: "",
      configDate: {
        format: "DD/MM/YYYY",
        useCurrent: false,
        showTodayButton: true,
        locale: "vi"
      },
      trang_thai: 1,
      thongTinTruongHoc: {},
      show_msg: false
    };
  },

  mounted: function() {
    this.customMessage();
    this.getTinhThanh();
    $(this.$refs.modal_chinhsua_truonghoc).on("hidden.bs.modal", this.close);
  },

  methods: {
    customMessage() {
      const dict = {
        custom: {
          ten_truong_hoc: {
            required: () => "Tên trường học không thể trống"
          },
          chuan_quoc_gia: {
            required: () => "Chuẩn quốc gia không thể trống"
          },
          loai_hinh_dao_tao: {
            required: () => "Loại hình đào tạo không thể trống"
          },
          loai_hinh_truong: {
            required: () => "Loại hình trường không thể trống"
          },
          ma_tinh_thanh: {
            required: () => "Tỉnh thành không thể trống"
          },
          ma_quan_huyen: {
            required: () => "Quận Huyện không thể trống"
          },
          capHoc: {
            required: () => "Vui lòng chọn cấp học."
          },
          ma_phuong_xa: {
            required: () => "Phường xã không thể trống"
          },
          email: {
            email: () => "Email không đúng định dạng"
          },
          so_dien_thoai: {
            regex: () => "Số điện thoại không đúng"
          },
          so_dien_thoai_hieu_truong: {
            regex: () => "Số điện thoại không đúng"
          }
        }
      };
      this.$validator.localize("vi", dict);
    },
    suaTruongHocSubmit() {
        console.log("chỉnh sửa học sinh")
      this.$validator.validateAll().then(result => {
        if (result) {
          this.updateTruongHoc();
        }
      });
      // this.$validator.extend('checkCapHoc', {
      //     getMessage: field => field + ' Cấp học không thể trống.',
      //     validate: (value) => {
      //         return this.password == value ? true : false;
      //     }
      // });
    },

    updateTruongHoc() {
      utils.confirmDialog("Xác nhận sửa trường học", "Sửa", () => {
        const uri = "/api_chinh_sua_truong_hoc";
        const params = {
          capHoc: this.capHoc,
          chiBoDang: this.chi_bo_dang ? 1 : 0,
          chuanQuocGia: this.chuan_quoc_gia,
          diaChi: this.dia_chi,
          email: this.email,
          fax: this.fax,
          idSo: this.ma_tinh_thanh,
          loaiHinhDaoTao: this.loai_hinh_dao_tao,
          loaiHinhTruong: this.loai_hinh_truong,
          ma: this.ma_truong_hoc,
          maDonVi: this.ma_don_vi_quan_ly,
          maPhuongXa: this.ma_phuong_xa,
          maQuanHuyen: this.ma_quan_huyen,
          maTinhThanh: this.ma_tinh_thanh,
          maToThon: this.ma_to_thon,
          ngayThanhLap: this.ngay_thanh_lap,
          sdt: this.so_dien_thoai,
          sdtHieuTruong: this.so_dien_thoai_hieu_truong,
          ten: this.ten_truong_hoc,
          tenHieuTruong: this.ten_hieu_truong,
          trangThai: this.trang_thai,
          vungBienGioi: this.vung_bien_gioi ? 1 : 0,
          vungKhoKhan: this.vung_kho_khan ? 1 : 0,
          website: this.website
        };
        if(this.ma_don_vi_quan_ly!=this.ma_tinh_thanh){
          params.idPhong = this.ma_don_vi_quan_ly
        }
        api.post(uri, params, response => {
          console.log(response);
          if (response.data.code === 200) {
            utils.showDialog(
              "Thông báo",
              "Sửa trường học thành công",
              null,
              () => {
                this.$emit("success", params);
                //this.reset();
                this.close();
              }
            );
          } else {
            utils.showDialog("Thất bại", response.data.message, null, () => {});
          }
        });
      });
    },
    getCapHoc(caphoc) {
      var text = "";
      if (this.nha_tre) {
        text += "4";
      }
      if (this.mau_giao) {
        text += "5";
      }
      if (this.cap_mot) {
        text += "1";
      }
      if (this.cap_hai) {
        text += "2";
      }
      if (this.cap_ba) {
        text += "3";
      }
      return text;
    },
    setCapHoc(caphoc) {
      if (caphoc.indexOf("4") != -1) {
        this.nha_tre = true;
      }
      if (caphoc.indexOf("5") != -1) {
        this.mau_giao = true;
      }
      if (caphoc.indexOf("1") != -1) {
        this.cap_mot = true;
      }
      if (caphoc.indexOf("2") != -1) {
        this.cap_hai = true;
      }
      if (caphoc.indexOf("3") != -1) {
        this.cap_ba = true;
      }
      console.log("ttt : " + caphoc.indexOf("1"));
    },
    checkCapHocChecked(ch) {
      console.log(this.capHoc.indexOf("1"));
      if (this.cap_hoc.indexOf(ch) != -1) {
        return true;
      }
      return false;
    },
    close() {
      console.log("close modal");
      //this.reset();
      this.$emit("close");
    },
    getDanhSachDonViQuanLy() {
      let params = {
        start: 0,
        limit: 1000,
        maTinhThanh: this.ma_tinh_thanh,
      };
      rest_api.get("/internal-api/dmDonVi/filter", params, data => {
        if (array_util.isArray(data.data.rows)) {
          array_util.clearArrays(this.ds_don_vi_quan_ly);
          this.ds_don_vi_quan_ly = data.data.rows;
        }
      });
    },

    getTinhThanh() {
      let params = {
        start: 0,
        limit: 100
      };
      rest_api.get("/internal-api/dmTinhThanh/filter", params, data => {
        if (array_util.isArray(data.data.rows)) {
          array_util.clearArrays(this.ds_tinh_thanh);
          this.ds_tinh_thanh = data.data.rows;
        }
      });
    },
    getQuanHuyen() {
      let params = {
        start: 0,
        limit: 999,
        maTinhThanh: this.ma_tinh_thanh
      };
      console.log("lấy ds quận huyện:" + params);
      rest_api.get("/internal-api/dmQuanHuyen/filter", params, data => {
        if (array_util.isArray(data.data.rows)) {
          this.ds_quan_huyen = data.data.rows;
        }
      });
    },
    getPhuongXa() {
      let params = {
        start: 0,
        limit: 100,
        maTinhThanh: this.ma_tinh_thanh,
        maQuanHuyen: this.ma_quan_huyen
      };
      console.log("lấy ds quận huyện:" + params);
      rest_api.get("/internal-api/dmPhuongXa/filter", params, data => {
        if (array_util.isArray(data.data.rows)) {
          this.ds_phuong_xa = data.data.rows;
        }
      });
    },
    getToThon() {
      let params = {
        start: 0,
        limit: 100,
        maTinhThanh: this.ma_tinh_thanh,
        maQuanHuyen: this.ma_quan_huyen,
        maPhuongXa: this.ma_phuong_xa
      };
      console.log("lấy ds quận huyện:" + params);
      rest_api.get("/internal-api/dmToThon/filter", params, data => {
        if (array_util.isArray(data.data.rows)) {
          this.ds_to_thon = data.data.rows;
        }
      });
    },
    onTinhThanhChange() {
      array_util.clearArrays(this.ds_quan_huyen);
      array_util.clearArrays(this.ds_phuong_xa);
      array_util.clearArrays(this.ds_to_thon);
      array_util.clearArrays(this.ds_don_vi_quan_ly);
      if (this.ma_tinh_thanh === "") {
        this.ma_quan_huyen = "";
        this.ma_phuong_xa = "";
        this.ma_to_thon = "";
        this.ma_don_vi_quan_ly = "";
        return;
      }
      this.ma_quan_huyen = "";
      this.ma_phuong_xa = "";
      this.ma_to_thon = "";
      this.getQuanHuyen();
      this.getDanhSachDonViQuanLy();
    },
    onQuanHuyenChange() {
      console.log("chọn huyện");
      array_util.clearArrays(this.ds_phuong_xa);
      array_util.clearArrays(this.ds_to_thon);
      if (this.ma_quan_huyen === "") {
        this.ma_phuong_xa = "";
        this.ma_to_thon = "";
        return;
      }
      this.ma_phuong_xa = "";
      this.ma_to_thon = "";
      console.log(this.ma_phuong_xa);
      this.getPhuongXa();
    },
    onPhuongXaChange() {
      array_util.clearArrays(this.ds_to_thon);
      if (this.ma_phuong_xa === "") {
        this.ma_to_thon = "";
        return;
      }
      this.ma_to_thon = "";
      this.getToThon();
    }
  }
};
</script>
<style scoped>
.form-check-inline {
  display: inline-flex;
  align-items: center;
  padding-left: 0;
  margin-right: 0.75rem;
}
.form-check-inline label {
  margin-bottom: 0;
  margin-left: 5px;
  position: relative;
  top: 2px;
}
    .inputhemtruong{
        height:80px;
    }
</style>

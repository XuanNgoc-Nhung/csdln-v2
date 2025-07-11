<template>
  <div id="modal_them_monhoc" ref="modal_them_monhoc" class="modal fade">
    <div class="modal-dialog" style="width:80%">
      <div class="modal-content">
        <form @submit.prevent="themMonHocSubmit">
          <div class="modal-header">
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-hidden="true"
              v-on:click="close()"
            >&times;</button>
            <h4 class="modal-title text-uppercase">Thêm môn học</h4>
          </div>
          <div class="modal-body clearfix">
            <div style="padding-top: 10px">
              <div class="form-group clearfix">
                <div class="col-sm-3 inputhemmon">
                  <label>
                    Mã môn học (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <input
                    v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }"
                    name="ma_monhoc"
                    v-model="ma_monhoc"
                    type="text"
                    placeholder="Nhập..."
                    class="form-control ng-pristine ng-valid-maxlength ng-touched"
                  />
                  <span v-if="show_msg">
                    <span
                      class="text-danger"
                      v-show="errors.has('ma_monhoc')"
                    >{{ errors.first('ma_monhoc') }}</span>
                  </span>
                </div>
                <div class="col-sm-3 inputhemmon">
                  <label>
                    Tên môn học (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <input
                    v-validate="{ required: true }"
                    name="ten_monhoc"
                    v-model="ten_monhoc"
                    type="text"
                    placeholder="Nhập..."
                    class="form-control ng-pristine ng-valid-maxlength ng-touched"
                  />
                  <span v-if="show_msg">
                    <span
                      class="text-danger"
                      v-show="errors.has('ten_monhoc')"
                    >{{ errors.first('ten_monhoc') }}</span>
                  </span>
                </div>
                <div class="col-sm-3 inputhemmon">
                  <label>
                    Tên viết tắt (
                    <span style="color:#DC0101;">*</span>)
                  </label>
                  <input
                    v-validate="{ required: true, max:30, regex: /^[a-zA-Z0-9_]*$/ }"
                    name="ten_viettat"
                    v-model="ten_viettat"
                    type="text"
                    placeholder="Nhập..."
                    class="form-control ng-pristine ng-valid-maxlength ng-touched"
                  />
                  <span v-if="show_msg">
                    <span
                      class="text-danger"
                      v-show="errors.has('ten_viettat')"
                    >{{ errors.first('ten_viettat') }}</span>
                  </span>
                </div>
                <div class="col-sm-3 inputhemmon">
                  <label>Loại đánh giá (
                    <span style="color:#DC0101;">*</span>)</label>
                  <select
                    v-model="loai_danh_gia"
                    v-validate="{ required: true }" name="loai_danh_gia"
                    class="form-control ng-pristine ng-valid-maxlength ng-touched"
                    style="width:100%"
                  >
                    <option value>--Chọn hình thức đánh giá--</option>
                    <option value="1">--Đánh giá--</option>
                    <option value="2">--Chấm điểm--</option>
                    <option value="3">--Kết hợp Đánh giá và Chấm điểm--</option>
                  </select>
                  <span v-if="show_msg"><span class="text-danger" v-show="errors.has('loai_danh_gia')">{{ errors.first('loai_danh_gia') }}</span></span>
                </div>
                <div class="col-sm-3 inputhemmon">
                  <label>Cấp học <span style="color:#DC0101">*</span></label>
                  <div style="padding-top:7px;">
                    <div style="width:33%; float:left">
                      <input v-model="capmot" type="checkbox" value />
                      <label>
                        Cấp
                        1
                      </label>
                    </div>
                    <div style="width:33%; float:left">
                      <input v-model="caphai" type="checkbox" value />
                      <label>
                        Cấp
                        2
                      </label>
                    </div>
                    <div style="width:33%; float:left">
                      <input v-model="capba" type="checkbox" value />
                      <label>Cấp 3</label>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6 inputhemmon">
                  <label>Tính chất môn</label>
                  <br />
                  <div style="width:30%; float:left">
                    <label>
                      <input v-model="tieng_dan_toc" type="checkbox" value />Tiếng
                      dân tộc
                    </label>
                  </div>
                  <div style="width:30%; float:left">
                    <label>
                      <input v-model="mon_ngoai_ngu" type="checkbox" value />Ngoại
                      ngữ
                    </label>
                  </div>
                  <div style="width:30%; float:left">
                    <label>
                      <input v-model="mien_giam" type="checkbox" value />Miễn
                      giảm
                    </label>
                  </div>
                  <div style="width:30%; float:left">
                    <label>
                      <input v-model="thuc_hanh" type="checkbox" value />Thực
                      hành
                    </label>
                  </div>
                  <div style="width:30%; float:left">
                    <label>
                      <input v-model="mon_nghe" type="checkbox" value />Môn
                      nghề
                    </label>
                  </div>
                </div>
                <div v-if="mon_nghe">
                  <div class="col-sm-3 inputhemmon">
                    <label >Nhóm nghề</label>
                    <select
                      v-model="nhom_nghe"
                      class="form-control ng-pristine ng-valid-maxlength ng-touched"
                      style="width:100%"
                    >
                      <option value>--Chọn nhóm nghề--</option>
                      <option value="1">--Nhóm nghề Nông Lâm--</option>
                      <option value="2">--Nhóm nghề tiểu thủ Công Nghiệp--</option>
                      <option value="3">--Nhóm nghề dịch vụ--</option>
                      <option value="5">--Nhóm nghề tin học ứng dụng--</option>
                      <option value="4">--Nhóm nghề khác--</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="modal-footer clearfix">
            <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
            <button type="submit" class="btn btn-primary">Thêm</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";
import utils from "../../utils";
import api from "../api";
import vi from "vee-validate/dist/locale/vi";
import VeeValidate, { Validator } from "vee-validate";
//Validator.localize('vi', vi);
Vue.use(VeeValidate);

$(document).ready(function() {
  console.log("ready!");
});

export default {
  props: ["item", "show"],

  watch: {
    show: function(newVal, oldVal) {
      console.log("newVal = " + newVal);
      if (newVal) {
        this.reset();
        $("#modal_them_monhoc").modal();
      } else {
        $("#modal_them_monhoc").modal("hide");
      }
    }
  },

  data() {
    return {
      ma_monhoc: "",
      ten_monhoc: "",
      ten_viettat: "",
      tieng_dan_toc: "",
      mon_ngoai_ngu: "",
      mon_nghe: "",
      nhom_nghe: "",
      loai_danh_gia: "",
      mien_giam: "",
      thuc_hanh: "",
      capmot: "",
      caphai: "",
      capba: "",
      caphoc: "",
      show_msg: false
    };
  },

  mounted: function() {
    console.log("mounted !!!!!");
    $(this.$refs.modal_them_monhoc).on("hidden.bs.modal", this.close);
    this.customMessage();
  },

  methods: {
    customMessage() {
      const dict = {
        custom: {
          ma_monhoc: {
            required: () => "Mã môn học không thể trống",
            max: () => "Mã môn học không vượt quá 30 ký tự",
            regex: () => "Mã môn học chỉ chứa chữ cái, chữ số, dấu gạch dưới"
          },
          ten_monhoc: {
            required: () => "Tên môn học không thể trống"
          },
          ten_viettat: {
            required: () => "Tên viết tắt không thể trống",
            max: () => "Tên viết tắt không vượt quá 30 ký tự",
            regex: () => "Tên viết tắt chỉ chứa chữ cái, chữ số, dấu gạch dưới"
          },
          loai_danh_gia:{
            required: () => "Vui lòng chọn loại đánh giá.",
          }
        }
      };
      this.$validator.localize("vi", dict);
    },
    themMonHocSubmit() {
      this.show_msg = true;
      this.$validator.validateAll().then(result => {
        if (result) {
          this.createNation();
        }
      });
    },
    createNation() {
      console.log("Thêm môn học");
      this.caphoc = "";
      if (this.tieng_dan_toc == true) {
        this.tieng_dan_toc = 1;
      } else {
        this.tieng_dan_toc = 0;
      }
      if (this.mon_ngoai_ngu == true) {
        this.mon_ngoai_ngu = 1;
      } else {
        this.mon_ngoai_ngu = 0;
      }
      if (this.mien_giam == true) {
        this.mien_giam = 1;
      } else {
        this.mien_giam = 0;
      }
      if (this.thuc_hanh == true) {
        this.thuc_hanh = 1;
      } else {
        this.thuc_hanh = 0;
      }
      if (this.mon_nghe == true) {
        this.mon_nghe = 1;
      } else {
        this.mon_nghe = 0;
        this.nhom_nghe = "";
      }
      if (this.capmot == true) {
        this.caphoc = this.caphoc + "1";
      }
      if (this.caphai == true) {
        this.caphoc = this.caphoc + "2";
      }
      if (this.capba == true) {
        this.caphoc = this.caphoc + "3";
      }
      console.log("cấp:" + this.caphoc)
      if(this.caphoc==null||this.caphoc==""){
            utils.showDialog("Thông báo", "Vui lòng chọn cấp học.", null, () => {});
          return;

      }
      utils.confirmDialog("Xác nhận thêm môn học", "Thêm", () => {
        const uri = "/api_them_mon_hoc";
        const params = {
          ma_monhoc: this.ma_monhoc,
          ten_monhoc: this.ten_monhoc,
          ten_viettat: this.ten_viettat,
          tieng_dan_toc: this.tieng_dan_toc,
          mon_ngoai_ngu: this.mon_ngoai_ngu,
          mon_nghe: this.mon_nghe,
          nhom_nghe: this.nhom_nghe,
          loai_danh_gia: this.loai_danh_gia,
          mien_giam: this.mien_giam,
          thuc_hanh: this.thuc_hanh,
          caphoc: this.caphoc
        };
        console.log("các params");
        console.log(params);
        api.post(uri, params, response => {
          console.log(response);
          if (response.data.code === 200) {
            utils.showDialog(
              "Thông báo",
              "Thêm môn học thành công",
              null,
              () => {
                this.$emit("success");
                this.reset();
                this.show_msg = false;
                this.close();
              }
            );
          } else {
            utils.showDialog("Thất bại", response.data.message, null, () => {});
          }
        });
      });
    },

    reset() {
      this.ma_monhoc = "";
      this.ten_monhoc = "";
      this.ten_viettat = "";
      this.tieng_dan_toc = "";
      this.mon_ngoai_ngu = "";
      this.mon_nghe = "";
      this.nhom_nghe = "";
      this.loai_danh_gia = "";
      this.mien_giam = "";
      this.thuc_hanh = "";
      this.capmot = "";
      this.caphai = "";
      this.capba = "";
      this.caphoc = "";
      this.ma_lydo = "";
      this.ten_lydo = "";
    },
    close() {
      console.log("close modal");
      this.show_msg = false;
      this.reset();
      this.$emit("close");
    }
  }
};
</script>
<style scoped>
.inputhemmon{
    height:100px;
}
label{}
</style>


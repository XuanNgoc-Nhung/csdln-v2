<template>
  <div class="modal fade giam-han" id="BcTinhHinhLopHocMonDacBiet" ref="BcTinhHinhLopHocMonDacBiet">
    <div class="modal-dialog" style="width: 90%; margin: 0 auto !important;">
      <div class="modal-content">
        <div class="modal-header" style="position: relative">
          <button
            type="button"
            class="close btn btn-danger"
            style="position: absolute; top: 2px; right: 2px;"
            data-dismiss="modal"
            aria-hidden="true"
            v-on:click="close()"
          >&times;</button>
          
                    <div class="row">
                        <div class="col-sm-8 col-md-7">
                            <h3 class="modal-title vh"> {{tenHoSo}} Tiểu học đoàn kết - Đầu năm
                            </h3>
                        </div>
                    </div>
        </div>
        <div class="modal-body clearfix">
          <div class="row">
            <div class="col-lg-12 pull-right text-right">
              <button class="btn btn-success"> Xuất Excel</button>
            </div>
          </div>
          <div style="padding-top: 10px">
            <div class="text-center">
              <ul class="nav nav-tabs">
                <!-- <li class="active"><a data-toggle="tab" href="#emis">Trường</a></li> -->
                <li
                  v-for="(sheet,i) in infoEmis.emisInfoSubReportList"
                  @click="activate(i)"
                  :class="{ active : active_el == i }"
                >
                  <a
                    data-toggle="tab"
                    @click.prevent="handleClickShow(sheet)"
                    href="#emis1"
                  >{{sheet.displayName}}</a>
                </li>
              </ul>
              <div class="tab-content">
                <div id="emis1" class="tab-pane in active fade">
                  <div class="">
                    <div class="xembaocao">
                      <div id="view"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import rest_api from "../../../utils/rest_api";
import array_util from "../../../utils/array_utils";
import constant from "../../../utils/constant";
import utils from "../../../utils";
import api from "./../../api";
import ExcelToHtml from "./../../../excelToHtml";
import XLSX from "xlsx";
export default {
  props: ["show", "item", "truongHoc", "namhoc"],

  data() {
    return {
      date: new Date(),
      infoEmis: {},
      active_el: 0,
      tenHoSo:"Hồ sơ trường",
    };
  },
  watch: {
    show: function(newVal, oldVal) {
      if (newVal) {
        $("#BcTinhHinhLopHocMonDacBiet").modal();
      } else {
        $("#BcTinhHinhLopHocMonDacBiet").modal("hide");
      }
    },
    item: function(newVal) {
      console.log("watch:" + JSON.stringify(newVal));
      this.infoEmis = newVal;
    },
    truongHoc: function(newVal) {
      this.truongHoc = newVal;
      console.log("trường học thay đổi:" + JSON.stringify(newVal));
    }
  },
  mounted: function() {
    $(this.$refs.BcTinhHinhLopHocMonDacBiet).on("hidden.bs.modal", this.close);
    console.log("mount:" + JSON.stringify(this.item));
    this.infoEmis = this.item;
    this.handleClickShow();
  },
  methods: {
    activate: function(el) {
      this.active_el = el;
    },
    close() {
      this.reset();
      this.$emit("close");
    },
    reset() {},
    getExcel(e) {
      console.log("lấy file excel của:" + JSON.stringify(e));
    },
    handleClickShow(e) {
      // this.tenHoSo = e.displayName;
      console.log("demo:" + JSON.stringify(e));
      if (!e) {
        console.log("không có e");
        this.emisReportName = this.infoEmis.emisReportName + ".Truong";
      }
      if (e != undefined) {
        this.emisReportName = e.emisReportName;
      }
      console.log("tên báo cáo:" + JSON.stringify(this.emisReportName));
      let url = "render-excel";
      let params = {
        maTruongHoc: this.truongHoc,
        emisReportName: this.emisReportName,
        namHoc: this.namhoc
      };
      console.log("params:" + JSON.stringify(params));
      api.post(url, params, data => {
        let file = data.data;
        let fr = new FileReader();
        let workbook = XLSX.read(file, { type: "base64" });
        let worksheet = workbook.Sheets[workbook.SheetNames[0]];
        let html = XLSX.utils.sheet_to_html(worksheet);
        $("#view").html(html);
      });
    }
  }
};
</script>
<style scoped>
h3 {
  margin: 0;
  font-weight: bold;
}
.red {
  color: #DC0101;
}
.cg {
  vertical-align: middle;
  text-align: center;
}
.ct {
  text-align: left;
}
.noidung {
  height: 400px;
  overflow-x: scroll;
}

.hienthi {
  padding-top: 50px;
}

th {
  border: 1px solid black !important;
}

td {
  border: 1px dotted black !important;
}

.noidung th,
td {
  border: 1px solid black !important;
}

.xembaocao {
  /* max-height: 600px; */
  /* overflow: scroll; */
}

.avtive {
  display: contents;
}

p {
  font-weight: 100;
  margin: 0;
}

td {
  border: solid 1px black !important;
}
#view{
        height: 400px;
        overflow-x: scroll;
}
</style>

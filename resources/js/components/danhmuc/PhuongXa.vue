<template>
  <div>
      <div class="row page-header">
          <div class="col-sm-6 text-uppercase">
              <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> Danh mục <span class="kytu"> &raquo;</span> Phường xã</span>
          </div>
      </div>
    <div class="row">
      <div class="col-sm-3">
          <label>Trực thuộc tỉnh:</label>
          <select
            @change="onTinhThanhChange"
            v-model="ma_tinh_thanh"
            title="Chọn tỉnh thành"
            class="form-control"
            style="width:100%"
          >
            <option value>Chọn tỉnh thành</option>
            <option v-for="tt in ds_tinh_thanh" :value="tt.maTinhThanh">{{tt.tenTinhThanh}}</option>
          </select>
      </div>
      <div class="col-sm-3">
        <label>Quận/huyện:</label>
        <select v-model="ma_quan_huyen" class="form-control" style="width:100%">
          <option value>Chọn quận huyện</option>
          <option v-for="tt in ds_quan_huyen" :value="tt.maQuanHuyen">{{tt.tenQuanHuyen}}</option>
        </select>
      </div>
      <div class="col-sm-3">
            <label>Mã phường xã:</label>
            <input v-model="ma_phuong_xa" class="form-control" placeholder="Nhập..." />
          </div>
          <div class="col-md-3">
            <label>Tên phường/xã:</label>
            <input v-model="ten_phuong_xa" class="form-control" placeholder="Nhập..." />
          </div>

      <div class="col-sm-3">
            <label>Trạng thái:</label>
            <select v-model="trang_thai" class="form-control" style="width:100%">
              <option value>--Tất cả--</option>
              <option value="1">Đang hoạt động</option>
              <option value="0">Ngừng hoạt động</option>
            </select>
      </div>
    </div>
    <div class="row text-center">

      <div class="col-sm-12" style="padding-top:20px;">
            <button  class="btn btn-success" v-on:click.prevent="getData()">
              <i class="fa fa-search"></i>Tìm kiếm
            </button>
      </div>
    </div>

    <div class="row" style="margin-top: 20px">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-12">
                <label>Danh sách phường xã</label>
                <button class="btn btn-success pull-right" v-on:click.prevent="showCreat()">
                  <i class="fa fa-plus" aria-hidden="true"></i> Thêm</button>
                <button
                  style="margin:0 5px;"
                  class="btn btn-primary pull-right"
                  v-on:click.prevent="showImport()"
                >
                  <i class="fas fa-upload"></i> Import
                </button>
              </div>
            </div>
            <hr style="margin: 10px 0 0;" />
            <div class="row">
              <div class="col-sm-12">
                <div class="table-responsive row_tp">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th class="text-center"><p>STT</p></th>
                        <th class="text-center"><p>Mã phường xã</p></th>
                        <th class="text-center"><p>Tên phường/xã</p></th>
                        <th class="text-center"><p>Số lượng tổ</p></th>
                        <th class="text-center"><p>Trực thuộc quận/huyện</p></th>
                        <th class="text-center"><p>Trực thuộc tỉnh/thành</p></th>
                        <th class="text-center"><p>Ngày cập nhật</p></th>
                        <th class="text-center"><p>Trạng thái</p></th>
                        <th class="text-center"><p>Thao tác</p></th>
                      </tr>
                    </thead>
                    <tbody v-if="ds_phuong_xa.length===0">
                      <tr>
                        <td class="text-center" colspan="9"><p>Không có bản ghi nào</p></td>
                      </tr>
                    </tbody>
                    <tbody v-else>
                      <tr v-for="(px,index) in ds_phuong_xa">
                        <td class="text-center"><p>{{(currentPage-1)*limit + index+1}}</p></td>
                        <td class="text-center"><p>{{px.maPhuongXa}}</p></td>
                        <td><p>{{px.tenPhuongXa}}</p></td>
                        <td class="text-center"><p>{{px.slTo}}</p></td>
                        <td><p>{{px.tenQuanHuyen}}</p></td>
                        <td><p>{{px.tenTinhThanh}}</p></td>
                        <td class="text-center"><p>{{getTime(px.ngayCapNhat)}}</p></td>
                        <td class="text-center"><p>{{parseInt(px.trangThai)=== 1 ? 'Đang hoạt động' : 'Ngưng hoạt động'}}</p></td>
                        <td class="text-center">
                          <a href="#" title="Chỉnh sửa" v-on:click.prevent="showUpdate(px)">
                            <i class="far fa-edit"></i>
                          </a>
                          <a href="#" title="Xóa" v-on:click.prevent="deleteData(px)">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                  <ThemMoiPhuongXa
                    :show="show_create"
                    @close="show_create=false"
                    @success="onCreatedData($event)"
                  ></ThemMoiPhuongXa>
                  <ChinhSuaPhuongXa
                    :show="show_update"
                    :item="dataEditPhuongXa"
                    @close="show_update=false"
                    @success="onUpdatedData($event)"
                  ></ChinhSuaPhuongXa>
                  <ImportPhuongXa
                    :show="show_import"
                    @close="show_import=false"
                    @success="onCreatedData($event)"
                  ></ImportPhuongXa>
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
import dialog from "../../utils/dialog";
import api from "../api";
import rest_api from "../../utils/rest_api";
import array_util from "../../utils/array_utils";
import timeutils from "../../utils/time_utils";
import Page from "../ui/PagingCustom";
import ThemMoi from "./ThemPhuongXa";
import ChinhSua from "./ChinhSuaPhuongXa";
import Import from "./pupupImportExcel/importXaPhuong";
import VueAlertify from "vue-alertify";

Vue.use(VueAlertify);
export default {
  components: {
    Page: Page,
    ThemMoiPhuongXa: ThemMoi,
    ChinhSuaPhuongXa: ChinhSua,
    ImportPhuongXa: Import
  },

  computed: {},

  data() {
    return {
      ma_tinh_thanh: "",
      ten_tinh_thanh: "",
      ten_quan_huyen: "",
      ma_quan_huyen: "",
      ten_phuong_xa: "",
      ma_phuong_xa: "",

      show_create: false,
      show_update: false,
      show_import: false,
      trang_thai: "",
      total_rows: 0,
      ds_tinh_thanh: [],
      ds_quan_huyen: [],
      ds_phuong_xa: [],
      start: 0,
      currentPage: 1,
      limit: 25,
      dataEditPhuongXa: {}
    };
  },

  mounted() {
    this.getTinhThanh();
    //this.getQuanHuyen();
    this.getData();
  },

  watch: {},

  methods: {
    layLai(e) {
      console.log("lấy lại danh sách:" + JSON.stringify(e));
      this.start = e.start;
      this.limit = e.limit;
      this.currentPage = e.currentPage;
      this.getData();
    },

    getTime(date) {
      return timeutils.convertTime(new Date(date));
    },

    getTinhThanh() {
      let params = {
        start: 0,
        limit: 100
      };
      rest_api.get(
        "/internal-api/dmTinhThanh/filter",
        params,
        data => {
          if (array_util.isArray(data.data.rows)) {
            this.ds_tinh_thanh = data.data.rows;
          }
        },
        10000,
        true
      );
    },
    getQuanHuyen() {
      let params = {
        start: 0,
        limit: 999,
        maTinhThanh: this.ma_tinh_thanh
      };
      console.log("lấy ds quận huyện:" + params);
      rest_api.get(
        "/internal-api/dmQuanHuyen/filter",
        params,
        data => {
          if (array_util.isArray(data.data.rows)) {
            this.ds_quan_huyen = data.data.rows;
          }
        },
        10000,
        true
      );
    },
    getData() {
      let params = {
        start: this.start,
        limit: this.limit,
        ma: this.ma_phuong_xa,
        ten: this.ten_phuong_xa,
        maTinhThanh: this.ma_tinh_thanh,
        maQuanHuyen: this.ma_quan_huyen,
        trangthai: this.trang_thai
      };
      console.log("lấy ds px:" + JSON.stringify(params));
      rest_api.get(
        "/internal-api/dmPhuongXa/filter",
        params,
        data => {
          if (array_util.isArray(data.data.rows)) {
            this.total_rows = data.data.total;
            console.log("số hàng: " + this.total_rows);
            array_util.clearArrays(this.ds_phuong_xa);
            this.ds_phuong_xa = data.data.rows;
            console.log("kết quả:" + JSON.stringify(this.ds_phuong_xa));
          }
        },
        10000,
        true
      );
    },
    showCreat() {
      console.log("thêm mới tỉnh thành");
      this.show_create = true;
    },
    showImport() {
      console.log("Import file từ excel");
      this.show_import = true;
    },
    showUpdate(px) {
      this.dataEditPhuongXa = px;
      this.show_update = true;
    },
    onCreatedData() {
      // this.$alertify.success('Thêm quận huyện thành công.');
      this.getData();
    },
    onUpdatedData(e) {
      // this.$alertify.success('Chỉnh sửa quận huyện thành công.');
      this.getData();
    },
    deleteData(qh) {
      console.log(JSON.stringify(qh));
      dialog.confirmDialog("Bạn có muốn xóa phường xã này?", "Đồng ý", () => {
        console.log("đồng ý xóa");
        const uri = "/api_xoa_phuong_xa";
        let params = {
          id: qh.maPhuongXa
        };
        api.post(uri, params, response => {
          if (response.data.code === 200) {
            showDialog("Thông báo", "Xóa phường xã thành công", null, () => {
              this.getData();
            });
          } else {
            showDialog("Thất bại", response.data.message, null, () => {
              return;
            });
          }
        });
      });
    },
    onTinhThanhChange() {
      if (this.ma_tinh_thanh === "") {
        this.ds_quan_huyen = [];
        this.ma_quan_huyen = "";
        return;
      }
      this.ma_quan_huyen = "";
      this.getQuanHuyen();
    }
  }
};
</script>
<style scoped>
  th{
    text-align: center;
  }
  p{
    font-size: 14px;
  }
</style>

<template>
  <div>
      <div class="row page-header">
          <div class="col-sm-6 text-uppercase">
              <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> hệ thống <span class="kytu"> &raquo;</span> Quản lý đối tác</span>
          </div>
      </div>
    <form role="form" class="form-inline">
      <div class="row">
        <div class="col-sm-2 col-md-2">
          <label>Mã đối tác:</label>
          <input v-model="ma_doi_tac" class="form-control" placeholder="Nhập..." />
        </div>
        <div class="col-sm-2 col-md-2">
          <label>Tên đối tác:</label>
          <input v-model="ten_doi_tac" class="form-control" placeholder="Nhập..." />
        </div>
        <div class="col-sm-2 col-md-2">
          <label>Tên đăng nhập:</label>
          <input v-model="ten_dang_nhap" class="form-control" placeholder="Nhập..." />
        </div>
        <div class="col-sm-2 col-md-2">
          <label>Trạng thái:</label>
          <select class="form-control" v-model="trang_thai">
            <option value>Tất cả</option>
            <option value="1">Đang hoạt động</option>
            <option value="0">Ngưng hoạt động</option>
          </select>
        </div>
        <div class="col-sm-1 col-md-1">
          <button class="btn btn-success" style="margin-top:24px;" v-on:click.prevent="getData()">
            <i class="fa fa-search"></i>Tìm kiếm
          </button>
        </div>
      </div>
    </form>

    <div class="row" style="margin-top: 20px">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-body">
            <div class="row">
              <div class="col-sm-12">
                <label>Danh sách đối tác</label>
                <button class="btn btn-success pull-right" v-on:click.prevent="showCreat()">
                  <i class="fa fa-plus" aria-hidden="true"></i> Thêm</button>
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
                        <th class="text-center"><p>Mã đối tác</p></th>
                        <th class="text-center"><p>Tên đối tác</p></th>
                        <th class="text-center"><p>Tên đăng nhập</p></th>
                        <th class="text-center"><p>Trạng thái</p></th>
                        <th class="text-center"><p>Thao tác</p></th>
                      </tr>
                    </thead>
                    <tbody v-if="ds_doi_tac.length===0">
                      <tr>
                        <td class="text-center" colspan="6"><p>Không có bản ghi nào</p></td>
                      </tr>
                    </tbody>
                    <tbody v-else>
                      <tr v-for="(tg,index) in ds_doi_tac">
                        <td class="text-center"><p>{{(currentPage-1)*limit + index+1}}</p></td>
                        <td><p>{{tg.maDoiTac}}</p></td>
                        <td><p>{{tg.tenDoiTac}}</p></td>
                        <td><p>{{tg.tenDangNhap}}</p></td>
                        <td class="text-center"><p>{{parseInt(tg.trangThai)=== 1 ? 'Đang hoạt động' : 'Ngưng hoạt động'}}</p></td>
                        <td class="text-center">
                          <a title="Chỉnh sửa" v-on:click="showUpdate(tg)">
                            <i class="far fa-edit"></i>
                          </a>
                          <a title="Xóa" v-on:click.prevent="deleteUnit(tg)">
                            <i class="fas fa-trash-alt"></i>
                          </a>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>
                  <ThemMoiDoiTac
                    :show="show_create"
                    @close="show_create=false"
                    @success="onCreatedData($event)"
                  ></ThemMoiDoiTac>
                  <ChinhSuaDoiTac
                    :show="show_update"
                    :item="dataEditDoiTac"
                    @close="show_update=false"
                    @success="onCreatedData($event)"
                  ></ChinhSuaDoiTac>
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
import rest_api from "../../utils/rest_api";
import array_util from "../../utils/array_utils";
import timeutils from "../../utils/time_utils";
import Page from "../ui/PagingCustom";
import ThemMoi from "./ThemDoiTac";
import utils from "../../utils";
import ChinhSua from "./ChinhSuaDoiTac";
import api from "../api";

export default {
  components: {
    Page: Page,
    ThemMoiDoiTac: ThemMoi,
    ChinhSuaDoiTac: ChinhSua
  },

  computed: {},

  data() {
    return {
      ten_doi_tac: "",
      show_create: false,
      show_update: false,
      trang_thai: "",
      total_rows: 0,
      ma_doi_tac: "",
      ten_dang_nhap: "",
      ds_doi_tac: [],
      start: 0,
      currentPage: 1,
      limit: 25,
      dataEditDoiTac: {}
    };
  },

  mounted() {
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

    getData() {
      let params = {
        start: this.start,
        limit: this.limit,
        maDoiTac: this.ma_doi_tac,
        tenDoitac: this.ten_doi_tac,
        tenDangNhap: this.ten_dang_nhap,
        trangThai: this.trang_thai
      };
      rest_api.get("/internal-api/heThongDoiTac/filter", params, data => {
        if (array_util.isArray(data.data.rows)) {
          this.total_rows = data.data.total;
          array_util.clearArrays(this.ds_doi_tac);
          this.ds_doi_tac = data.data.rows;
          console.log("---" + JSON.stringify(data));
        }
      });
    },
    showCreat() {
      console.log("thêm mới tỉnh thành");
      this.show_create = true;
    },
    showUpdate(tt) {
      this.dataEditDoiTac = tt;
      this.show_update = true;
    },
    onCreatedData(e) {
      this.getData();
    },
    deleteUnit(tt) {
      utils.confirmDialog("Xác nhận chỉnh xóa đối tác", "Xóa", () => {
        const uri = "/api_xoa_doi_tac";
        let params = {
          id: tt.maDoiTac
        };
        api.post(uri, params, response => {
          console.log(response);
          if (response.data.code === 200) {
            utils.showDialog(
              "Thông báo",
              "Xóa đối tác thành công",
              null,
              () => {
                this.getData();
              }
            );
          } else {
            utils.showDialog("Thất bại", response.data.message, null, () => {});
          }
        });
      });
    }
  }
};
</script>
<style scoped>
.form-control {
  width: 100%;
}
th{
  text-align: center;
}
p{
  font-size: 14px;
}
</style>

<template>

    <div id="themmoi_ketchuyen" ref="themmoi_ketchuyen" class="modal fade">

        <div class="modal-dialog" style="width:97%">

            <div class="modal-content">
                <form  role="form">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Thêm Mới kết chuyển dữ liệu
                        </h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div style="width:90%; margin:0 auto">
                            <form role="form">
                            <div class="row space30">
                                <div class="col-md-3">
                                <label>Loại yêu cầu:</label>
                                <select  v-model="loaiYeuCau" class="form-control">
                                    <option value="">Chọn loại yêu cầu</option>
                                    <option value="1">Thông tin trường</option>
                                    <option value="2">Giáo viên</option>
                                    <option value="3">Lớp học</option>
                                    <option value="4">Học sinh</option>
                                    <option value="5">Kết quả học tập</option>
                                    <option value="6">EQMS</option>
                                </select>
                                </div>
                                <div v-if="loaiYeuCau==5" class="col-md-3">
                                <label>Mục:</label>
                                <select v-model="mucYeuCau" class="form-control">
                                    <option value="">Chọn mục</option>
                                    <option value="1">Kết quả học tập</option>
                                    <option value="2">Xét tốt nghiệp</option>
                                    <option value="3">Nhập điểm thi lại</option>
                                </select>
                                </div>
                                <div v-if="loaiYeuCau==6" class="col-md-3">
                                <label>Mục:</label>
                                <select v-model="mucYeuCau" class="form-control">
                                    <option value="">Chọn mục</option>
                                    <option value="4">EQMS đầu năm</option>
                                    <option value="5">EQMS giữa năm</option>
                                    <option value="6">EQMS cuối năm</option>
                                </select>
                                </div>
                                <div class="col-md-3">
                                <label>Năm học:</label>
                                    <select class="form-control" v-model="namHoc">
                                        <option value=''>Chọn năm học</option>
                                        <option v-for="y in list_years" :value="y.id">{{y.name}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                <label>Tỉnh thành:</label>
                                        <select disabled v-model="tinhthanh" class="form-control">
                                            <option v-for="tt in ds_tinh_thanh" :value="tt.maTinhThanh">{{tt.tenTinhThanh}}</option>
                                        </select>                                                     
                                </div>
                            </div>
                            <div class="row space30">
                                <div class="col-md-3">
                                    <label>Đơn vị:</label>
                                    <select class="form-control" v-model="maDonVi">
                                        <option value="">Chọn đơn vị</option>
                                        <option v-for="dv in listDonVi" :value="dv.maDonVi">{{dv.tenDonVi}}</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                <label>Cấp học:</label>
                                    <select class="form-control" v-model="capHoc">
                                        <option value="">Chọn cấp học</option>
                                        <option value="1">Cấp 1</option>
                                        <option value="2">Cấp 2</option>
                                        <option value="3">Cấp 3</option>
                                        <option value="4">Nhà trẻ</option>
                                        <option value="5">Mẫu giáo</option>
                                        <option value="12">Trường liên cấp 12</option>
                                        <option value="23">Trường liên cấp 23</option>
                                        <option value="13">Trường liên cấp 13</option>
                                        <option value="123">Trường liên cấp 123</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Trường học:</label>
                                    <select class="form-control" v-model="maTruongHoc">
                                        <option value="">Chọn trường học</option>
                                        <option v-for="th in listTruongHoc" :value="th.maTruongHoc">{{th.tenTruongHoc}}</option>
                                    </select>
                                </div>
                            </div>
                            </form>




                        </div>
                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button @click.prevent="getTruongHoc()" class="btn btn-primary">Tìm kiếm</button>
                                <button  @click.prevent="" class="btn btn-danger">Cập nhật trạng thái</button>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="xembaocao">
                                    
                <div class="table-responsive row_tp">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr class="text-center">
                        <th>STT</th>
                        <th>Mã trường</th>
                        <th>Tên trường</th>
                        <th>Cấp học</th>
                        <th>Số bản ghi</th>
                        <th>Đơn vị</th>
                        <th>Chọn tất cả</th>
                      </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(th,i) in listTruongHoc">
                        <td>{{i+1}}</td>
                        <td>{{th.maTruongHoc}}</td>
                        <td>{{th.tenTruongHoc}}</td>
                        <td>{{th.capHoc}}</td>
                        <td>{{th.idSo}}</td>
                        <td>{{th.tenDonVi}}</td>
                        <td>
                            <input type="checkbox">
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                                </div>
                            </div>
                        </div>
                  <Page :total_rows="total_rows" @pageChange="layLai($event)"></Page>

                    </div>

                    <div class="modal-footer text-center clearfix" style="text-align:center">
                        <button type="submit" @click.prevent="updatePass()" class="btn btn-info">Cập nhật
                        </button>
                        <button type="submit" @click.prevent="updatePass()" class="btn btn-primary">Đẩy lại
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Hủy bỏ
                        </button>
                    </div>
                </form>
            </div>


        </div>

    </div>

</template>

<script>

    import rest_api from '../../utils/rest_api';
    import array_util from '../../utils/array_utils';
    import time_utils from '../../utils/time_utils';
    import utils from '../../utils'
    import api from '../api';
    import Page from "../ui/PagingCustom";
    import VeeValidate, {Validator} from 'vee-validate';
    import dialog from '../../utils/dialog';
    import constant from "../../utils/constant";
    // import VueFormWizard from 'vue-form-wizard';
    // import 'vue-form-wizard/dist/vue-form-wizard.min.css';
    // import {FormWizard, TabContent} from 'vue-form-wizard';
    // import 'vue-form-wizard/dist/vue-form-wizard.min.css';
    //Validator.localize('vi', vi);
    Vue.use(VeeValidate);
    // Vue.use(VueFormWizard)

    

//local registration

    $(document).ready(function () {
        // console.log("ready!");
    });

    export default {

        props: ['user', 'show'],
        components: {
    Page: Page,
        },
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    //this.reset();
                    $("#themmoi_ketchuyen").modal();
                } else {
                    $("#themmoi_ketchuyen").modal('hide');
                }
            },
            user: function(newVal, oldVal) {
            this.thongtindangnhap = newVal;
            this.tinhthanh = this.thongtindangnhap.province;
            this.getDonVi();
            this.getTinhThanh();
            }
        },

        data() {
            return {
                start: 0,
                currentPage: 1,
                limit: 25,
                maTruongHoc:'',
    total_rows: 0,
                loaiYeuCau:'',
                thongtindangnhap:{},
                tinhthanh:'',
                maDonVi:'',
                capHoc:'',
                mucYeuCau:'',
                listDonVi:[],
                ds_tinh_thanh:[],
                listTruongHoc:[],
                namHoc:'',
                list_years: constant.LIST_YEARS_FULL,
            }
        },
        mounted: function () {
            $(this.$refs.themmoi_ketchuyen).on("hidden.bs.modal", this.close);
        },

        methods: {
    layLai(e) {
      console.log("lấy lại danh sách:" + JSON.stringify(e));
      this.start = e.start;
      this.limit = e.limit;
      this.currentPage = e.currentPage;
      this.getTruongHoc();
    },
  getTinhThanh() {
      let params = {
        start: 0,
        limit: 25,
        ma: this.thongtindangnhap.province
      };
      console.log("pr" + JSON.stringify(params));
      rest_api.get(
        "/internal-api/dmTinhThanh/filter",
        params,
        data => {
          if (array_util.isArray(data.data.rows)) {
            array_util.clearArrays(this.ds_tinh_thanh);
            this.ds_tinh_thanh = data.data.rows;
            console.log("tỉnh abc: " + JSON.stringify(this.ds_tinh_thanh));
          }
        },
      );
    },




            Demo(){
                console.log("123123132131321");
            },
            
            getDonVi() {
            let params = {
                start: 0,
                limit: 9999,
            // console.log("THông TIn Đăng nahassssssssssjp:" + JSON.stringify(this.thongtindangnhap));
                maTinhThanh: this.thongtindangnhap.province
            };
            rest_api.get("/internal-api/dmDonVi/filter", params, data => {
                if (array_util.isArray(data.data.rows)) {
                array_util.clearArrays(this.listDonVi);
                this.listDonVi = data.data.rows;
                }
            });
            },
            close() {
                console.log("close modal");
                this.$emit('close');
            },
            reset() {
            },
            updatePass(){
                console.log("chỉnh sửa mật khẩu");
                
            dialog.confirmDialog("Bạn có muốn xóa trường học này?", "Đồng ý", () => {
            this.$emit('success');
            this.reset();
            this.close();
            });
            },
    getTruongHoc() {
      let params = {
        start: this.start,
        limit: this.limit,
        caphoc: parseInt(this.capHoc),
        madonvi: this.maDonVi
      };
      rest_api.get("/internal-api/dmTruongHoc/filter", params, data => {
        if (array_util.isArray(data.data.rows)) {
        this.total_rows = data.data.total;
          array_util.clearArrays(this.listTruongHoc);
          this.listTruongHoc = data.data.rows;
        }
      });
    }
        }

    }
</script>
<style scoped>
    .form-check-inline{
        display: inline-flex;
        align-items: center;
        padding-left: 0;
        margin-right: .75rem;
    }
    .form-check-inline label{
        margin-bottom: 0;
        margin-left: 5px;
        position: relative;
        top: 2px;
    }
    .xembaocao {
        max-height: 400px;
        overflow: scroll;
    }
</style>

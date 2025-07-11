<template>
    <div id="thongtin_nhanduoc" ref="thongtin_nhanduoc" class="modal fade">
        <div class="modal-dialog" style="width: 70%;">

            <div class="modal-content">
                <form @submit.prevent="themToThonSubmit">
                    <div class="modal-header">
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-hidden="true"
                            v-on:click="closeinfo()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chi tiết</h4>
                    </div>
                    <!-- <div class="modal-body clearfix">
                        <textarea name="" id="" :value="ChiTietDuLieu" style="width:100%; margin:0 auto;height:50vh"></textarea></div> -->

<!-- Bảng thông tin chi tiết -->


                <div class="table-responsive row_tp" style="height:350px;font-size:12px;">
                  <table class="table table-striped table-bordered table-hover">
                    <thead>
                      <tr class="text-center">
                        <th class="text-center">STT</th>
                        <th class="text-center">Mã</th>
                        <th class="text-center">Tên</th>
                        <th class="text-center">Mã lỗi</th>
                        <th class="text-center">Mô tả lỗi</th>
                      </tr>
                    </thead>
                    <tbody v-if="ChiTietDuLieu.length===0">
                      <tr>
                        <td class="text-center" colspan="22">Không có dữ liệu phù hợp</td>
                      </tr>
                    </tbody>
                    <tbody v-else>
                      <tr v-for="(px,index) in ChiTietDuLieu">
                        <td class="text-center">{{index + 1}}</td>
                        <td class="text-center">{{px.clientId}}</td>
                        <td>{{px.name}}</td>
                        <td class="text-center">{{px.error}}</td>
                        <td>{{px.errorDescription}}</td>
                      </tr>
                    </tbody>
                  </table>
                </div>

<!-- Hết nội dung bảng -->

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</template>

<script>

    import utils from '../../utils';
import rest_api from "../../utils/rest_api";
    import api from '../api';
    import VeeValidate, {Validator} from 'vee-validate';
    Vue.use(VeeValidate);
    $(document).ready(function () {});

    export default {

        props: [
            'item', 'hien'
        ],
        watch: {
            item:function(newVal){
                this.messageId= newVal;
            },
            hien: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#thongtin_nhanduoc").modal();
                    this.getDetail();
                } else {
                    $("#thongtin_nhanduoc").modal('hide');
                }
            },
        },

        data() {
            return {
                id:"",
                type:'',
                ChiTietDuLieu:"Loading...",
                messageId:""
            }
        },
        mounted: function () {
            $(this.$refs.thongtin_nhanduoc).on("hidden.bs.modal", this.closeinfo);
                // this.getDetail();
        },

        methods: {
            getDetail() {
                let params = {
                    messageId:this.messageId,
                };
                rest_api.post("/csdlgd-push/LichSuDay/detail", params, data => {
                    // console.log("chi tiết trả về:" + JSON.stringify(data))
                    if (data.data.code == 200) {
                        this.ChiTietDuLieu = data.data.item.response.body.result.items.item;
                        this.ChiTietDuLieu= JSON.parse(this.ChiTietDuLieu);
                        console.log("thông tin của bản ghi:" + JSON.stringify(this.ChiTietDuLieu));
                    } else {
                        console.log("lấy thất bại");
                        utils.showDialog("Thất bại", data.data.rd, null, () => {});
                        return;
                    }
                });
            },
            reset() {
                // console.log("reset trong chi tiết nhận được")
                this.ChiTietDuLieu = "Loading..."
            },
            closeinfo() {
                this.reset();
                console.log("đóng tỏng chi tiết nhận được");
                this.$emit('closeinfo');
            }
        }
    }
</script>

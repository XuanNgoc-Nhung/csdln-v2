<template>

    <div id="modal_them_dantoc" ref="modal_them_dantoc" class="modal fade">

        <div class="modal-dialog">

            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-hidden="true"
                            v-on:click="close()">
                            &times;
                        </button>
                        <h3 v-if="loaiThaoTac==1" class="modal-title">Duyệt dữ liệu</h3>
                        <h3 v-else-if="loaiThaoTac==0" class="modal-title">Từ chối yêu cầu</h3>
                        <h3 v-else-if="loaiThaoTac==2" class="modal-title">Đẩy dữ liệu lên bộ</h3>
                    </div>
                    <div class="modal-body clearfix">
                        <div>
                            <div class="form-group clearfix">
                                <label style="line-height: 34px;">Ghi chú:</label>
                                <textarea v-model="note" style="width:100%; border-radius:5px;" rows="4"></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                        </button>
                        <button type="submit" class="btn btn-primary" @click.prevent="ThucHien()">Thực hiện
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

</template>

<script>

    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';

    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: ['show','item','type'],

        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.reset();
                    $("#modal_them_dantoc").modal();
                } else {
                    $("#modal_them_dantoc").modal('hide');
                }
            },
            type: function(newVal,oldVal) {
                console.log("loại confirm:" + newVal);
                this.loaiThaoTac=newVal;
            },
            item: function(newVal, oldVal){
                console.log("bản ghi:" + JSON.stringify(newVal));
                this.banGhi=newVal;
            }
        },

        data() {
            return {
                note:"",
                banGhi:{},
                loaiThaoTac:"",

            }
        },
        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_them_dantoc).on("hidden.bs.modal", this.close);
        },

        methods: {
            ThucHien(){
                console.log(this.loaiThaoTac);
                console.log(JSON.stringify(this.banGhi.id));
                console.log(this.note);
                utils.confirmDialog("Xác nhận thực hiện thao tác", "Đồng ý", () => {
                    const uri = "/api_them_dan_toc";
                    const params = {
                    "id": this.banGhi.id,
                    "type": this.loaiThaoTac,
                    "note": this.note,
                    };
                    
                rest_api.post("/csdlgd-admin/yeuCauDuLieuTruong/unit-confirm", params, (data) => {
                    console.log(JSON.stringify(data));
                    if (data.data.rc == 0) {
                                if(this.loaiThaoTac==2){
                                    this.$alertify.success("Hệ thống đang tiến hành nộp dữ liệu. Vui lòng xem kết quả tại LỊCH SỬ ĐẨY DỮ LIỆU. Quá trình này có thể diễn ra từ 5-10 phút.");
                                }
                                else{
                                    this.$alertify.success("Thực hiện thao tác thành công");
                                }
                                this.reset();
                                this.close();
                            return;

                    } else {
                        this
                            .$alertify
                            .error(data.data.rd);
                        return;
                    }

                });
                })

            },

            reset() {
                this.note="";
            },

            close() {
                this.reset();
                this.$emit('close');
            }
        }

    }
</script>
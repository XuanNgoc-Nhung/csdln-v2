<template>

    <div id="xoa_ketchuyen" ref="xoa_ketchuyen" class="modal fade">

        <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Xóa kết chuyển dữ liệu</h4>
                </div>
                <div class="modal-body clearfix">

                    <div class="row space30">
                        <div class="col-sm-6"> <label>Mã trường:</label>
                            <textarea class="form-control" style="min-height:34px"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label for="">Loại yêu cầu (<span style="color:#DC0101">*</span> )</label>
                            <select class="form-control" id="">
                                <option value="">Chọn loại yêu cầu</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <span><b>Ghi chú:</b><i>Nhập nhiều trường thì mã trường cách nhau bởi dấu phẩy (,), tối đa 4000 ký tự.</i></span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Hủy
                    </button>
                    <button type="button" class="btn btn-primary" v-on:click="DeleteData()">Xóa
                    </button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>

    import dialog from '../../utils/dialog';
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    import api from './../api';

    $(document).ready(function () {
        console.log("ready!");
    });
    export default {

        props: ['item', 'show'],


        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#xoa_ketchuyen").modal();
                } else {
                    $("#xoa_ketchuyen").modal('hide');
                }
            }
        },
        data() {
            return {
                tenFile: '',
                selected_file: null,
                download_link:''
            }
        },


        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.xoa_ketchuyen).on("hidden.bs.modal", this.close);
        },

        methods: {
            DeleteData() {
                utils.confirmDialog("Xác nhận xóa", "Đồng ý", () => {
                                this.close();
                                this.reset();
                });


            },
            close() {
                this.$emit('close');
                this.reset();
            },
            reset() {
            }
        }
    }
</script>


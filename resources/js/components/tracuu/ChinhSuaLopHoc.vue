<template>
    <div id="modal_create_sync" ref="modal_create_sync" class="modal fade">
        <div class="modal-dialog" style="width: 75%; height:95vh">
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="close()">
                        &times;
                    </button>
                    <div class="row">
                        <div class="col-md-7">
                            <h3 class="modal-title text-uppercase">Chỉnh sửa lớp học</h3>
                        </div>
                    </div>
                </div>
                <div
                    class="modal-body"
                    style="width: 100%;margin: 0 auto;height: 85%;overflow: scroll;">
                    <div style="padding-top: 10px">
                        <p>{{duLieuLopHoc}}</p>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="UpdateStudent()" class="btn btn-primary">Chỉnh sửa</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    $(document).ready(function () {
        console.log("ready!");
    });
    import array_util from '../../utils/array_utils';
    import rest_api from '../../utils/rest_api';
    import datePicker from 'vue-bootstrap-datetimepicker';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils';
    import dialog from '../../utils/dialog';
    import api from '../api';
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        }
    });
    export default {
        components: {
            datePicker
        },
        props: [
            'item', 'show'
        ],
        watch: {
            show: function (newVal, oldVal) {
                console.log("Chỉnh sửa 1234567890 = " + newVal);
                if (newVal) {
                    $("#modal_create_sync").modal();
                } else {
                    $("#modal_create_sync").modal('hide');
                }
            },
            item: function (newVal) {
                this.getDataClass(newVal);
            }
        },
        data() {
            return {duLieuLopHoc: {}}
        },
        mounted: function () {
            $(this.$refs.modal_create_sync).on("hidden.bs.modal", this.close);
        },
        methods: {
            close() {
                console.log("Đóng modal");
                this.$emit('close');
            },
            getDataClass(e) {
                let params = {
                    "id": e
                };
                rest_api.get("/csdlgd-admin/lopHoc/findOne", params, (data) => {
                    console.log("Dữ liệu lớp học trả về:" + JSON.stringify(data));
                    this.duLieuLopHoc = data.data

                });
            }
        }
    }
</script>
<style scoped="scoped">
    label {
        font-size: 12px;
    }
    .col-md-2,
    .col-sm-3 {
        margin-bottom: 15px;
    }
    .checkdieukien {
        margin-top: 25px;
        text-align: left;
    }
    .form-control {
        font-size: 12px;
        height: 30px;
    }
</style>
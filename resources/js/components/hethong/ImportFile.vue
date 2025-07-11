<template>

    <div id="modal_import_file" ref="modal_import_file" class="modal fade"  style="font-size:18px;">
        <div class="modal-dialog" style="width: 40%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h3 class="modal-title text-uppercase">Nhập THÔNG TIN</h3>
                </div>
                <div class="modal-body" style="width: 90%;margin: 0 auto;">
                    <div class="row" style="padding-bottom: 15px;">
                        <div class="col-md-5"><label>Nhập thông tin từ Excel:</label></div>
                        <div class="col-md-7">
                            <label class="btn btn-default btn-file" tabindex="0" id="lblFile">
                                <i class="fa fa-cloud-upload"></i> Lựa chọn file Excel
                                <br>
                                <small class="text-primary"><em>Tổng dung lượng không quá 10MB</em></small>
                                <br>
                                <small class="text-secondary"><em>Định dạng file hợp lệ: *.xlsx </em>
                                </small>
                                <input ng-disabled="readonly" ngf-select="addFile(anhTheFile)"
                                       ng-model="anhTheFile" ngf-max-size="10MB" ngf-pattern="'image/*'"
                                       accept="image/png, image/jpeg" name="anhTheFile" type="file"
                                       style="display:none" ngf-valid-only="true" ngf-multiple="false"
                                       class="ng-pristine ng-untouched ng-valid ng-empty" aria-invalid="false">
                            </label>
                        </div>
                    </div>
                    <div class="row text-center">
                        <p>Vui lòng tải mẫu file import thông tin <a href="#">tại đây</a></p>
                    </div>
                </div>

                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                    <button type="button" v-on:click="ImportFile()" class="btn btn-primary">Tải lên</button>
                </div>
            </div>


        </div>

    </div>

</template>

<script>

    $(document).ready(function () {
        console.log("ready!");
    });

    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'

    Vue.use(VueAlertify);
    export default {
        props: ['item', 'show'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#modal_import_file").modal();
                } else {
                    $("#modal_import_file").modal('hide');
                }
            }
        },
        data() {
            return {
                student_code:'',
            }
        },
        mounted: function () {
            console.log("mounted !!!!!");
            $(this.$refs.modal_import_file).on("hidden.bs.modal", this.close);
        },
        methods: {
            ImportFile(){
                utils.confirmDialog("Xác nhận tải file?", "Đồng ý", () => {
                    const params = {
                    };
                    this.$emit('success', params);
                    this.close();
                })
            },

            close() {
                console.log("Đóng modal");
                this.$emit('close');
            },

        }

    }
</script>


<style scoped>
    .student-info img {
        width: 100%;
    }

    .student-info span {
        font-weight: bold;
        text-transform: uppercase;
        font-size: 19px;
    }

    .thumbnail {
        position: relative;
    }

    #box-img .thumbnail {
        width: 150px;
        height: 150px;
    }

    .control-label {
        display: block;
        float: left;
    }

    #change_image {
        position: absolute;
        bottom: 10px;
        left: 10px;
    }

    .img_preview {
        width: 150px;
        height: 150px;
    }

    .required {
        font-size: 12px;
        color: #DC0101
    }
</style>

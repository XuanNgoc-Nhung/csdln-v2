<template>
    <div>
        <div class="row criteria-title" style="margin:0 30px;">
            <h5>THÔNG TIN TÌM KIẾM </h5>
        </div>
        <div class="row criteria-search">
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Mã tiêu chí</label>
                        </div>
                        <div class="col-md-8">
                            <input
                                class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                style="width:100%"
                                type="text"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Tên tiêu chí</label>
                        </div>
                        <div class="col-md-8">
                            <input
                                class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                style="width:100%"
                                type="text"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Loại đối tượng</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                <option value="">--Tất cả--</option>
                                <option value="">--Nhà vệ sinh--</option>
                                <option value="">--Phòng tập--</option>
                                <option value="">--Thiết bị giảng dạy--</option>
                                <option value="">--Thư viện--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Loại dữ liệu</label>
                        </div>
                        <div class="col-md-8">
                            <select
                                class="form-control ng-pristine ng-valid ng-empty text-center ng-valid-maxlength ng-touched"
                                style="width:100%">
                                <option value="">--Tất cả--</option>
                                <option value="">--Dạng số--</option>
                                <option value="">--Dữ liệu logic Đúng/Sai--</option>
                                <option value="">--Dữ liệu dạng chuỗi--</option>
                                <option value="">--Dữ liệu dạng list--</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Cấp học</label>
                        </div>
                        <div class="col-md-8">
                            <!--                            <div class="w20">-->
                            <!--                                <input type="checkbox"> Nhà trẻ-->
                            <!--                            </div>-->
                            <!--                            <div class="w20">-->
                            <!--                                <input type="checkbox"> Mẫu giáo-->
                            <!--                            </div>-->
                            <!--                            <div class="w20">-->
                            <!--                                <input type="checkbox"> Tiểu học-->
                            <!--                            </div>-->
                            <!--                            <div class="w20">-->
                            <!--                                <input type="checkbox"> THCS-->
                            <!--                            </div>-->
                            <!--                            <div class="w20">-->
                            <!--                                <input type="checkbox"> THPT-->

                            <!--                            </div>-->
                            <div>
                                <label class="typo__label">Simple select / dropdown</label>
                                <multiselect v-model="value" :options="options" :multiple="true"
                                             :close-on-select="false" :clear-on-select="false" :preserve-search="true"
                                             placeholder="Chọn" label="name" track-by="name" :preselect-first="true">
                                    <template slot="selection" slot-scope="{ values, search, isOpen }"><span
                                        class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} giá trị được chọn</span>
                                    </template>
                                </multiselect>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4">
                            <label>Trạng thái</label>
                        </div>
                        <div class="col-md-8">
                            <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                                    style="width:100%">
                                <option value="">--Tất cả--</option>
                                <option value="">--Đang hoạt động--</option>
                                <option value="">--Ngừng hoạt động--</option>
                            </select>
                            <pre class="language-json"><code>{{ value  }}</code></pre>
                        </div>
                    </div>
                </div>
            </div>
            <div class="button-search">
                <a href="" class="btn btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Tìm kiếm</a>
            </div>
        </div>
        <div style="background: #ddd;height: 20px;"></div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueAlertify from 'vue-alertify';
    import Import from './ImportFile';
    import utils from '../../utils'

    Vue.use(VueAlertify);
    export default {
        components: {
            'import-file': Import,
        },

        data() {
            return {
                lookuser: false,
                showImportFile: false,
                value: [],
                options: [
                    {name: 'Mầm non', language: 'JavaScript'},
                    {name: 'Cấp 1', language: 'Elixir'},
                    {name: 'Cấp 2', language: 'Elixir'},
                    {name: 'Cấp 3', language: 'Elixir'},
                ]

            }
        },
        methods: {
            nameWithLang({name, language}) {
                return `${name} — [${language}]`;
            },
            Khoa() {
                utils.confirmDialog("Bạn có muốn thay đổi trạng thái này?", "Đồng ý", () => {
                    this.lookuser = !this.lookuser;
                    this.$alertify.success('Thay đổi thành công');
                })
            },
            InfoData() {
                console.log("hiện thị form thông tin người dùng");
                $("#modal_info_data").modal();
            },
            showCreatSyncData() {
                console.log("hiện thị form thông tin người dùng");
                $("#modal_sync_old").modal();
            },
            createDataCriteria() {
                console.log("thêm");
                utils.confirmDialog("Xác nhận thêm mới yêu cầu?", "Thêm", () => {

                    $("#modal_sync_old").modal('hide');
                    this.$alertify.success('Thêm Thành Công.');
                })
            },
            showEditSyncData() {
                console.log("hiện thị form thông tin người dùng");
                $("#modal_sync_edit").modal();
            },
            showUpdateSyncData() {
                console.log("thêm");
                utils.confirmDialog("Bạn có muốn chỉnh sửa?", "Sửa", () => {

                    $("#modal_sync_edit").modal('hide');
                    this.$alertify.success('Chỉnh Sửa Thành Công.');
                })

            },
            showImportData() {
                console.log("Hiển thị form tải file");
                $('#modal_import_file').modal();
                this.showImportFile = true;
            },
            onImportData() {
                this.$alertify.success('Tải lên thành công thành công.');
            }
        }
    }
</script>

<style scoped>
    th, td {
        text-align: center;
    }

    .w125 {
        width: 12.5%;
        float: left;
    }

    .w875 {
        width: 87.5%;
        float: left;
    }

    .col-md-12 {
        padding-bottom: 15px;
    }

    .abc {
        padding-bottom: 25px;
    }

    .abc span {
        color: #DC0101;
    }

    .text-center a {
        padding: 5px;
    }

    .panel-body {
        width: 90%;
        margin: 0 auto;
    }

    .panel-body .col-md-6 {
        padding-bottom: 20px;
    }

    .pull-right button {
        margin: 7px;
    }

    .criteria-search {
        margin: 0 auto;
        padding-bottom: 20px;
        padding-top: 15px;
        background: #fff;
    }

    .criteria-search label {
        font-weight: 400;
        text-align: right;
        float: right;
        font-size: 12px;

    }

    .w20 {
        width: 19%;
        display: inline-table;
    }

    .criteria-search input, select {
        border-radius: 4px;
    }

    .criteria-title {
        border-bottom: 1px solid #ddd;
        background: #fff;

    }

    .criteria-title h3 {
        text-transform: uppercase;
        border: 1px solid #e7e7e7;
        border-bottom: 1px solid transparent;
        border-top-left-radius: 3px;
        border-top-right-radius: 3px;
        vertical-align: middle;
        padding: 14px;
    }

    .button-search {
        margin: 0 auto;
        display: block;
        text-align: center;
    }

    .list_user {
        margin: 0 auto;
        background: white;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .list_header {

    }

    .list_header h4 {
        float: left;
    }

    .list_header button {
        float: right;
    }

    .text-center a {
        padding: 5px;
    }

    .panel-body {
        padding: 5px 15px;
    }
</style>

<template>
    <div>
        <div id="modal_faq" ref="modal_faq" class="modal fade">
            <div class="modal-dialog" style="">
                <div class="modal-content" style="">
                    <div class="modal-header">
                        <button type="button" class="el-dialog__headerbtn" data-dismiss="modal" aria-label="Close">
                            <i class="el-dialog__close el-icon el-icon-close"></i>
                        </button>
                        <h4 class="modal-title"> Các câu hỏi thường gặp</h4>

                    </div>
                    <div class="modal-body" style="padding-bottom:200px;">
                        <div class="panel-group" id="accordion">
                            <div style="">
                                <div class="row" style="display:flex">
                                    <div class="col-md-4" style="align-self:center">
                                        <label class="typo__label">Tìm kiếm</label>
                                        <input type="text" v-model="searchTerm" class="form-control"
                                            placeholder="Nhập...">
                                    </div>
                                    <div class="col-md-3" style="align-self:flex-end">
                                        <button v-if="thongtin.role==1" class="btn btn-info"
                                            @click.prevent="AddFaq()">Thêm câu hỏi mới</button>
                                    </div>
                                </div>
                            </div>
                            <!-- item -->
                            <div v-if="hienthi">
                                <div v-for="(item,i) in filterByTerm" :key=i class="panel panel-default"
                                    :class="{ 'in' : i == 0 }">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion"
                                                :href="idmenu+i"><b
                                                    style="color:#01856B"><i>{{i+1}}.{{item.cauHoi}}</i></b></a>
                                        </h4>
                                    </div>
                                    <div :id="menu+i" class="panel-collapse collapse" :class="{ 'in' : i == 0 }">
                                        <div class="panel-body">
                                            <div v-html="item.traLoi"></div>
                                        </div>
                                        <div class="panel-footer">
                                            <a href="#" v-if="thongtin.role==1" @click.prevent="Update(item)"
                                                class="btn btn-primary">Chỉnh sửa</a>
                                            <a href="#" v-if="thongtin.role==1" @click.prevent="Delete(item)"
                                                class="btn btn-danger">Xóa</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-else>
                                <div class="text-center">
                                    <img style="width:100px"
                                        src="https://energyregulators.org/wp-content/uploads/2020/02/a0eff71a957fd517-blue-loading-icon-techinfobit.gif"
                                        alt="">
                                    <div>
                                        <p>Vui lòng đợi trong giây lát...</p>
                                    </div>
                                </div>
                            </div>
                            <!-- **** -->
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-fullscreen" style="">
                        <el-button type="default"  data-dismiss="modal" size="mini">Đóng</el-button>
<!--                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng-->
<!--                        </button>-->
                    </div>
                </div>
            </div>
        </div>
        <!-- end div -->
        <div v-if="show_add">
            <ThemMoiFaq @close="show_add=false" @success="onUpdatedData()"></ThemMoiFaq>
        </div>
        <div v-if="show_update">
            <UpdateFaq @close="show_update=false" :item="dataUpdate" @success="onUpdatedData()"></UpdateFaq>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import ThemMoi from './ThemCauHoiMoiFaq'
    import Update from './ChinhSuaCauHoiFaq'
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    export default {
        components: {
            'ThemMoiFaq': ThemMoi,
            'UpdateFaq': Update,
        },
        data() {
            return {
                list_cau_hoi: [],
                idmenu: "#menu",
                menu: "menu",
                searchTerm: "",
                editorData: '',
                show_add: false,
                hienthi: false,
                show_update: false,
                thongtin: {},
                dataUpdate: {},
            };
        },
        computed: {
            filterByTerm() {
                return this.list_cau_hoi.filter(item => {
                    return item.cauHoi.toLowerCase().includes(this.searchTerm.toLowerCase());
                });
            }
        },
        mounted: function () {

            $(document).on("click", ".huongdan", () => {
                this.show_create = true;
                console.log(this.info);
                this.thongtin = this.info;
            });
            $("#modal_faq").modal();
            this.thongtin = JSON.parse(window.userInfo);
            this.getData();
            $(this.$refs.modal_faq).on("hidden.bs.modal", this.close);
        },
        methods: {
            getData() {
                this.list_cau_hoi = [];
                let params = {
                    start: 0,
                    limit: 1000,
                };
                rest_api.get("/csdlgd-admin/CauHoi/danhSach", params, data => {
                    if (data.data.rc == 0) {
                        this.list_cau_hoi = data.data.rows;
                        this.hienthi = true;
                    } else {
                        this.list_cau_hoi = [];
                    }
                });
            },
            onUpdatedData() {
                this.show_add = false;
                this.show_update = false;
                this.getData();
            },
            AddFaq() {
                console.log("thêm câu hỏi mới");
                this.show_add = true;
            },
            Update(e) {
                this.dataUpdate = e;
                this.show_update = true;
            },
            close() {
                this.$emit('close')
            },
            Delete(e) {
                utils.confirmDialog("Xác nhận xóa thông tin", "Đồng ý", () => {
                    rest_api.post("/csdlgd-admin/CauHoi/delete", e.id, data => {
                        console.log("data update trả về:");
                        console.log(JSON.stringify(data));
                        if (data.data.rc == 0) {
                            this.$alertify.success("Xóa thành công");
                            this.getData();
                        } else {
                            this.$alertify.error(data.data.rd);
                        }
                    });

                })
            }
        }
    }

</script>
<style scoped="scoped">

    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }

</style>

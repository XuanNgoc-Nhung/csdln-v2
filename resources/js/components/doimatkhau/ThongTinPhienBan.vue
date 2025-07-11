<template>
    <div id="modal_show_thongtin_phienban" ref="modal_show_thongtin_phienban" class="modal fade">
        <div class="modal-dialog modal-tongthe">
            <div class="modal-content" style="height:100%; position:relative">
                <div class="modal-header">
                    <h4 class="modal-title text-uppercase">Hướng dẫn sử dụng</h4>
                </div>
                <div class="modal-body clearfix">
                    <div class="row">
                        <div class="col-sm-6">
                            <!--                            Nội dung phần tiêu đề-->
                            <div>
                                <label class="typo__label">Chọn danh mục:</label>
                                <multiselect v-model="noiDungHuongDan"
                                             :options="list_menu_admin_so"
                                             group-values="danhMucCon"
                                             deselectLabel="Đã chọn"
                                             selectLabel="Chưa chọn"
                                             @close="ChonDanhMuc"
                                             selectedLabel="Đã chọn"
                                             placeholder="Chọn danh mục"
                                             :disabled="isDisabled"
                                             group-label="danhMuc"
                                             :group-select="false"
                                             track-by="name" label="name"><span slot="noResult">Không tìm thấy kết quả. Vui lòng thử lại.</span>
                                </multiselect>
                            </div>
                            <!--                            Hết phần nội dung-->
                        </div>
                    </div>
                    <hr/>
                    <div class="row baonoidung">
                        <div class="tieuDeNoiDUng">
                            <h5>Hướng dẫn sử dụng <span v-if="noiDungHuongDan.name">- {{noiDungHuongDan.name}}</span>
                            </h5>
                        </div>
                        <div class="col-md-12">
                            <h4>{{noiDungHuongDan.name}}</h4>
                            <div class="noiDungHuongDan">
                                <i>{{noiDungHuongDan}}</i>
                                <div v-if="mucHuongDan=='1-1'">
                                    Biểu đồ giáo viên
                                </div>
                                <div v-if="mucHuongDan=='1-2'">
                                    Biểu đồ xếp loại học lực
                                </div>
                                <div v-if="mucHuongDan=='1-3'">
                                    Biểu đồ học sinh
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="position:absolute; bottom:15px; right:15px;">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>

        </div>

    </div>

</template>

<script>
    import dialog from "../../utils/dialog";
    import api from "./../api";
    import Multiselect from 'vue-multiselect'
    import Page from "../ui/PagingCustom";
    import ThongTin from "../tracuu/ThongTinKetQuaHocTap";
    import ChinhSua from "../tracuu/ChinhSuaKetQuaHocTapHocSinh";

    export default {
        props: [],
        watch: {},
        components: {
            Multiselect,
        },
        data() {
            return {
                isDisabled: false,
                list_menu_admin_so: [
                    {
                        danhMuc: 'Biểu đồ',
                        danhMucCon: [
                            {name: 'Giáo viên', value: '1-1'},
                            {name: 'Xếp loại học lực', value: '1-2'},
                            {name: 'Học sinh', value: '1-3'},
                        ], $isDisabled: true
                    },
                    {
                        danhMuc: 'Tiếp nhận dữ liệu QLNT',
                        danhMucCon: [
                            {name: 'Cấu hình lịch đồng bộ', value: '2-1'},
                            {name: 'Nhập liệu', value: '2-2'},
                            {name: 'BC tình hình nộp dữ liệu', value: '2-3'},
                            {name: 'Lịch sử tiếp nhận dữ liệu', value: '2-4'},
                        ]
                    },
                    {
                        danhMuc: 'Kết chuyển dữ liệu lên bộ',
                        danhMucCon: [
                            {name: 'Mật khẩu kết chuyển', value: '3-1'},
                            {name: 'Kết chuyển dữ liệu', value: '3-2'},
                            {name: 'Lịch sử đẩy dữ liệu lên bộ', value: '3-3'},
                        ]
                    },
                    {
                        language: 'Báo cáo',
                        danhMucCon: [
                            {name: 'Báo cáo EMIS', value: '4-1'},
                            {name: 'Báo cáo đơn vị', value: '4-2'},
                            {name: 'Báo cáo động', value: '4-3'},
                            {name: 'Báo cáo EQMS', value: '4-4'},
                            {name: 'Báo cáo đặc thù', value: '4-5'},
                            {name: 'Nộp thống kê theo biểu mẫu', value: '4-6'},
                        ]
                    },
                    {
                        danhMuc: 'Tra cứu',
                        danhMucCon: [
                            {name: 'Tra cứu học sinh', value: '5-1'},
                            {name: 'Tra cứu cán bộ', value: '5-2'},
                            {name: 'Tra cứu lớp học', value: '5-3'},
                            {name: 'Tra cứu kết quả học tập', value: '5-4'},
                            {name: 'Tra cứu trường học', value: '5-5'},
                        ]
                    },
                    {
                        danhMuc: 'Hệ thống',
                        danhMucCon: [
                            {name: 'Quản lý người dùng', value: '6-1'},
                            {name: 'Quản lý vai trò', value: '6-2'},
                            {name: 'Quản lý nộp dữ liệu SSO', value: '6-3'},
                        ]
                    }
                ],
                noiDungHuongDan: {},
                mucHuongDan: '',
            }
        },

        mounted: function () {
            $("#modal_show_thongtin_phienban").modal();
            $(this.$refs.modal_show_thongtin_phienban).on("hidden.bs.modal", this.close);
        },

        methods: {
            ChonDanhMuc() {
                this.mucHuongDan = "";
                if (this.noiDungHuongDan) {
                    this.mucHuongDan = this.noiDungHuongDan.value;
                }
                console.log("Chọn danh mục:" + this.mucHuongDan)
            },
            close() {
                this.$emit('close')
            }
        }
    }
</script>
<style scoped="scoped">
    @import "../../../../node_modules/selectwithsearch.css";

    .bd {
        border: 1px solid #ddd;
    }

    hr {
        margin: 0;
        padding: 0;
    }

    .modal-tongthe {
        width: 80%;
        height: 90vh !important;
        min-height: 90vh !important;
        max-height: 90vh !important;
        position: relative;
        margin: 15px auto;
    }

    .modal-header {
        height: 10%;
    }

    .modal-body {
        height: 80%;
        padding: 0 15px;
    }

    .modal-footer {
        height: 10%;
        position: absolute;
        bottom: 0;
        width: 100%;
    }

    .accordion {
        background-color: #eee;
        color: #444;
        cursor: pointer;
        padding: 18px;
        width: 100%;
        border: none;
        text-align: left;
        outline: none;
        font-size: 15px;
        transition: 0.4s;
    }

    .active, .accordion:hover {
        background-color: #ccc;
    }

    .panel {
        padding: 0 18px;
        display: none;
        background-color: white;
        overflow: hidden;
    }

    .noidunghuongdan {
        height: 49vh;
        overflow-y: scroll;
        position: relative;
    }

    .tieuDeNoiDung {
        position: absolute;
        top: -16px;
        left: 30%;
        border: 1px solid red;
        background: white;
        width: 40%;
        text-align: center;
        text-transform: uppercase;
    }

    .baonoidung {
        border: 1px solid red;
        position: relative;
        padding-top: 20px;
        margin-top: 20px;
    }
</style>

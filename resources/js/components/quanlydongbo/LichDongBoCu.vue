<template>
    <div>
        <div class="row page-header">
            <div class="col-sm-6">
                <h3 class=" text-uppercase">CẤU HÌNH LỊCH ĐỒNG BỘ CŨ</h3>
            </div>
            <div class="col-sm-6 pull-right">
                <button class="btn btn-info pull-right" @click.prevent="xemHuongDan()" style="margin-top:15px;">Hướng dẫn</button>
                <HuongDan :show="huong_dan" @close="huong_dan=false"></HuongDan>
            </div>
        </div>
        <component
                :info="info"
                :is="current_view"
                @callback="callBack($event)">
        </component>
    </div>
</template>
<script>

    import api from '../api';
    import utils from '../../utils';
    import rest_api from '../../utils/rest_api';
    import Page from '../ui/PagingCustom';
    import DanhSachLichDongBo from './lich_dong_bo/DanhSachLichDongBoCu';
    import ThemLichDongBo from './lich_dong_bo/ThemLichDongBoCu';
    import SuaLichDongBo from './lich_dong_bo/SuaLichDongBoCu';
    import HuongDan from '../huongdan/CauHinhLichDongBo';
     Vue.use(VueAlertify, {
                notifier: {
                    delay: 5,
                    position: 'top-right'
                }
            });

    export default {

        components: {
            'Page': Page,
            "HuongDan": HuongDan,
        },

        props: ['info'],

        watch: {
            currentPage: function () {
                this.makePage();
            }
        },

        data() {
            return {
                huong_dan:false,
                current_view: DanhSachLichDongBo,

                total_rows: 0,

                showCreateSyncCalendar: false,
                showUpdateSyncCalendar: false,
                showShowSyncCalendar: false,

                list_dongbo: [],
                list_header: [],

                currentPage: 1,
                pagination: {
                    "next_text": "<",
                    "prev_text": ">",
                    "total_rows": 0,
                    "per_page": 10,
                    "first_text": "Đầu",
                    "last_text": "Cuối",
                    "limit": 100,
                },

                dataInfo: {},
                start: 1,
                limit: 25,

            }
        },

        mounted: function () {
            this.LayDanhSachYeuCauDongBo();
        },

        methods: {
            xemHuongDan(){
                console.log("xem hướng dẫn")
                this.huong_dan=true;
            },

            callBack(view) {
                console.log("call-back: " + view);
                switch (parseInt(view)) {
                    case 1:
                        this.current_view = ThemLichDongBo;
                        break;
                    case 2:
                        this.current_view = SuaLichDongBo;
                        break;
                    default:
                        this.current_view = DanhSachLichDongBo;
                        break;
                }
            },

            onPageChange(data) {

            },

            makePage() {
                console.log(this.currentPage);
                this.LayDanhSachYeuCauDongBo();
            },
            LayDanhSachYeuCauDongBo() {

                let uri = "/csdlgd-admin/yeuCauDongBo/list-old";

                let params = {
                    "start": this.start,
                    "limit": this.limit,
                };
                rest_api.get(uri, params, (data) => {
                    console.log("data:" + JSON.stringify(data.data));
                });
                // api.get(uri, params, (respon) => {
                //     console.log(respon);
                //     this.list_dongbo = respon.data.tableData;
                //     this.list_header = respon.data.tableHeaders;
                //     this.pagination.total_rows = respon.data.totalRows;
                // })
            },
            showCreateSync() {
                console.log("hiện form");
                $("#modal_create_sync").modal();
                this.showCreateSyncCalendar = true;
            },
            showUpdateSync() {
                console.log("hiện form");
                $("#modal_update_sync").modal();
                this.showUpdateSyncCalendar = true;
            },
            showInfoSync(nd) {
                console.log("xem thông tin cấu hình đồng bộ");
                console.log(nd);
                $("#modal_info_sync").modal();
                this.showShowSyncCalendar = true;
                this.dataInfo = nd;
            },
            onCreatedData() {
                this.LayDanhSachYeuCauDongBo();
                this.$alertify.success('Thêm cấu hình thành công.');
            },
            onUpdateData() {
                this.$alertify.success('Chỉnh sửa cấu hình thành công.');
            },
            deleteSync(i) {
                console.log("xóa cấu hình lịch đồng bộ");
                utils.confirmDialog("Xác nhận xóa dân tộc", "Thêm", () => {
                    const uri = "/api_xoa_cau_hinh_lich_dong_bo";
                    const params = {
                        id: this.list_dongbo[i].id,
                    };
                    api.post(uri, params, (respon) => {
                        console.log(respon.data);
                        if (respon.data.code === 200) {
                            utils.showDialog("Thông báo", "Bạn đã xóa thành công!", null, () => {
                            });
                            this.list_dantoc.splice(i, 1);
                        } else {
                            utils.showDialog("Thất bại", respon.data.message);
                        }
                    })
                })
            }
        }
    }
</script>
<style scoped>
    th, td {
        text-align: center;
    }
</style>

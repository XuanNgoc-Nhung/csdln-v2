<template>
    <div id="thongtin_nhanduoc" ref="thongtin_nhanduoc" class="modal fade">
        <div class="modal-dialog" style="width: 70%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-hidden="true"
                        v-on:click="closeinfo()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Chi tiết import thông tin</h4>
                    <p>Đã tiến hành import tổng số {{duLieuTong.total}} bản ghi. Trong đó: Tiếp nhận thành công
                        {{duLieuTong.countSuccess}} bản ghi; thất bại: {{duLieuTong.countError}} bản ghi.</p>
                </div>
                <div class="table-responsive row_tp" style="height:350px;font-size:12px;">
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr class="text-center">
                            <th class="text-center">STT</th>
                            <th class="text-center">Tên</th>
                            <th class="text-center">Lỗi</th>
                            <th class="text-center">Vị trí lỗi (hàng trong file excel)</th>
                        </tr>
                        </thead>
                        <tbody v-if="cacBanGhi.length===0">
                        <tr>
                            <td class="text-center" colspan="22">Không có dữ liệu phù hợp</td>
                        </tr>
                        </tbody>
                        <tbody v-else>
                        <tr v-for="(px,index) in cacBanGhi">
                            <td class="text-center">{{index + 1}}</td>
                            <td>{{px.name}}</td>
                            <td>{{px.message}}</td>
                            <td class="text-center">{{px.sttRowExcel}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer clearfix">
                    <div class="row">
                        <div class="col-md-12 baobutton float-right">
                           <div class="demothoi" style="display:inline-block">
                               <download-excel
                                   :data="json_data"
                                   name="thong_tin_ban_ghi_loi.xls"
                               >
                                   <button type="button" class="btn btn-info">Tải xuống
                                   </button>
                               </download-excel>
                           </div>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue'
    import JsonExcel from 'vue-json-excel'

    Vue.component('downloadExcel', JsonExcel)
    $(document).ready(function () {
    });
    export default {

        props: [
            'banghi', 'hien'
        ],
        watch: {
            banghi: function (newVal) {
            },
        },

        data() {
            return {
                cacBanGhi: [],
                duLieuTong: {},
                //    Phần dành cho xuất excel
                json_fields: {
                    'Complete name': 'Họ tên',
                    'Địa chỉ': 'Mô tả lỗi',
                    'SĐT': 'Vị trí lỗi',
                },
                json_data: [],
                json_meta: [
                    [
                        {
                            'key': 'charset',
                            'value': 'utf-8'
                        }
                    ]
                ],
            }
        },
        mounted: function () {
            $("#thongtin_nhanduoc").modal();
            this.bindDuLieuCacBanGhi();
            $(this.$refs.thongtin_nhanduoc).on("hidden.bs.modal", this.closeinfo);
        },

        methods: {
            bindDuLieuCacBanGhi() {
                this.duLieuTong = this.banghi;
                this.cacBanGhi = this.duLieuTong.messages;
                console.log("Các bản ghi lỗi:");
                console.log(JSON.stringify(this.cacBanGhi));
                let json_data2 = this.cacBanGhi;
                json_data2.map((item,a)=>{
                    let newItem = {};
                    newItem['STT'] = a+1;
                    newItem['Họ tên'] = item.name;
                    newItem['Mô tả lỗi'] = item.message;
                    newItem['Vị trí lỗi (hàng trong file excel)'] = item.sttRowExcel;
                    return this.json_data.push(newItem);
                });
            },
            reset() {
            },
            closeinfo() {
                this.reset();
                this.$emit('closeinfo');
            }
        }
    }
</script>
<style scoped="scoped">
    .baobutton{
        /*display: flex;*/
        /*float: right;*/
    }
    .baobutton>button{
        padding: 5px 15px;
        margin: 0 10px;
    }
</style>

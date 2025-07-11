    <template>
    <div id="modal_kt" ref="modal_kt" class="modal fade" style="font-size:18px;">
        <div class="modal-dialog" style="width:95%">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-uppercase">chỉnh sửa cấu hình duyệt đẩy dữ liệu</h5>
                </div>
                <div class="modal-body" style="width: 100%;margin: 0 auto;">
                    <div>
                    <!-- <div style="height: 65vh;overflow: scroll;"> -->
                        <div class="row rct" style="margin-top:10px;display:flex">
                            <div class="col-md-2">
                                <label>Loại đơn vị <span style="color:#DC0101"> *</span></label>
                                <input type="text" class="form-control" disabled :value="getLoaiDonVi(thongtincauhinh.loaiDonVi)">
                            </div>
                            <div class="col-md-4">
                                <label class="typo__label p-3">Đơn vị quản lý <span style="color:#DC0101"> *</span></label>
                                <input type="text" class="form-control" disabled :value="thongtincauhinh.tenDonVi">
                            </div>
                            <div class="col-md-2">
                                <label class="typo__label">Cấp học</label>
                                <input type="text" class="form-control" value="Chọn cấp học" disabled>
                            </div>
                            <div class="col-md-4">
                                <label class="typo__label">Trường học  <span v-if="truong" style="color:#DC0101"> *</span></label>
                                <input type="text" disabled class="form-control" :value="thongtincauhinh.tenTruongHoc">
                            </div>
                        </div>
                        <div class="row" style="padding-top:20px;">
                            <div class="col-md-12">
                                <span style="margin:0 10px 0 0"><input :disabled="thongtincauhinh.loaiDonVi!=2" style="margin-right:10px" v-model="phongDuocNopLenBo" type="checkbox">Phòng được đẩy lên Bộ</span>
                                <span style="margin:0 10px"><input  :disabled="thongtincauhinh.loaiDonVi!=3" style="margin-right:10px" v-model="truongDuocNopLenBo" type="checkbox">Trường được đẩy lên Bộ</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" @click.prevent="themMoi()" >Sửa</button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import constant from '../../utils/constant';
    import VueAlertify from "vue-alertify";
    import ElementUI from 'element-ui';
    import ThemMoi from './ThemMoi';
    import ESelectVue from '../ui/ESelect.vue';
    import utils from '../../utils'
    import Page from "../ui/PagingCustom";
    import rest_api from '../../utils/rest_api';
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
    export default {
        props: ['item'],
        watch: {},
        components: {
            'eselect': ESelectVue,
        },
        data() {
            return {
                thongtincauhinh:{},
                maTruong: "",
                phongDuocNopLenBo: false,
                truongDuocNopLenBo: false,
                phong: false,
                truong: false,
                maTruong: "",
                thongtin: {},
                maTruongHocs: [],
                cap_hoc: "",
                list_cap_hoc: window.listCapHoc,
                list_loai_don_vi: [{
                    name: "Phòng",
                    value: "1"
                }, {
                    name: "Trường",
                    value: "2"
                }],
                loai_don_vi: [],
                list_don_vi: [],
                list_truong_hoc: [],
                maPhongs: [],
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.thongtincauhinh = this.item;
            if(this.thongtincauhinh.phongDuocNopLenBo){this.phongDuocNopLenBo=true;}
            if(this.thongtincauhinh.truongDuocNopLenBo){this.truongDuocNopLenBo=true;}
            $("#modal_kt").modal();
            $(this.$refs.modal_kt).on("hidden.bs.modal", this.close);
        },
        methods: {
            getLoaiDonVi(e){
                if(e==1){return "Sở";}
                if(e==2){return "Phòng";}
                if(e==3){return "Trường";}},
            themMoi(){
                let params = {
                        id: this.thongtincauhinh.id,
                        truongDuocNopLenBo: this.truongDuocNopLenBo,
                        phongDuocNopLenBo: this.phongDuocNopLenBo,
                    };
                console.log(JSON.stringify(params));
                utils.confirmDialog("Xác nhận chỉnh sửa", "Chỉnh sửa", () => {

                    rest_api.post("/csdlgd-admin/duyetDayDuLieu/updateCauHinh", params, data => {
                        if (data.data.rc == 0) {
                            this.$alertify.success("Chỉnh sửa thành công");
                            this.$emit('success');
                        } else {
                            utils.showDialog("Thất bại", data.data.rd, null, () => {});
                        }
                    });
                })
            },
            close() {
                this.$emit('close');
            },
        }
    }

</script>

<style scoped="scoped">
    p,
    span,
    label {
        font-size: 12px;
        margin: 0;
    }

</style>

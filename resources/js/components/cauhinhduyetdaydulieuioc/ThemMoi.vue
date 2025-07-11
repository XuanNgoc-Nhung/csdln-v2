<template>
    <div>

        <div id="modal_kt" ref="modal_kt" class="modal fade" style="font-size:18px;">
            <div class="modal-dialog" style="width:95%">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-uppercase">Thêm Mới cấu hình duyệt đẩy dữ liệu</h5>
                    </div>
                    <div class="modal-body" style="width: 100%;margin: 0 auto;">
                        <!-- <div style="height: 65vh;overflow: scroll;"> -->
                        <div style="">
                            <div class="row rct" style="margin-top:10px;display:flex">
                                <div class="col-md-2">
                                    <label>Loại đơn vị <span style="color:#DC0101"> *</span></label>
                                    <el-select v-model="loai_don_vi" multiple filterable collapse-tags
                                        @change="chonLoaiDonVi" placeholder="Chọn" no-data-text="Không có dữ liệu"
                                        no-match-text="Không có dữ liệu phù hợp">
                                        <el-option v-for="item in list_loai_don_vi" :key="item.value" :label="item.name"
                                            :value="item.value">
                                        </el-option>
                                    </el-select>
                                </div>
                                <div class="col-md-4">
                                    <label class="typo__label p-3">Chọn đơn vị <span style="color:#DC0101"> *</span></label>
                                    <eselect style="width:100%" multiple collapseTags v-model="maPhongs"
                                        :placeholder="'Chọn'" filterable :data="list_don_vi"
                                        :fields="['name','value']" />
                                </div>
                                <div class="col-md-2">
                                    <label class="typo__label">Chọn cấp học</label>
                                    <eselect style="width:100%" :disabled="phong&&!truong" multiple collapseTags
                                        v-model="cap_hoc" @change="chonCapHoc" :placeholder="'Chọn'" filterable
                                        :data="list_cap_hoc" :fields="['name','id']" />
                                </div>
                                <div class="col-md-4">
                                    <label class="typo__label">Chọn trường học <span v-if="truong" style="color:#DC0101">
                                            *</span></label>
                                    <eselect style="width:100%" :disabled="phong&&!truong" multiple collapseTags
                                        v-model="maTruongHocs" :placeholder="'Chọn'" filterable
                                        :data="list_truong_hoc" :fields="['name','value']" />
                                </div>
                            </div>
                            <div class="row" style="padding-top:20px;">
                                <div class="col-md-12">
                                    <span style="margin:0 10px 0 0"><input :disabled="truong&&!phong"
                                            v-model="phongDuocNopLenBo" type="checkbox" style="margin-right:10px">Phòng
                                        được đẩy lên IOC</span>
                                    <span style="margin:0 10px"><input :disabled="phong&&!truong"
                                            v-model="truongDuocNopLenBo" type="checkbox"
                                            style="margin-right:10px">Trường được đẩy lên IOC</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <el-button plain type="default" size="mini" data-dismiss="modal">Đóng</el-button>
                        <el-button plain type="primary" size="mini" @click.prevent="themMoi()">Thêm</el-button>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div id="modal_import_file" ref="modal_import_file" class="modal fade" style="font-size:18px;">
                <div class="modal-dialog" style="width:75%">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">DANH SÁCH LOẠI ĐƠN VỊ ĐÃ CÓ CẤU HÌNH DUYỆT ĐẨY</h5>
                        </div>
                        <div class="modal-body" style="width: 100%;margin: 0 auto;">
                            <div style="height: 55vh;overflow: scroll;">
                                <div class="">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="text-center">
                                                    <p>STT</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Mã đơn vị</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tên đơn vị</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Mã trường</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tên trường</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="list_loi==0">
                                            <tr>
                                                <td class="text-center bt" colspan="5">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(item,i) in list_loi" :key="i">
                                                <td class="text-center">
                                                    <p>{{i+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{item.maPhong}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.tenDonVi}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.maTruongHoc}}</p>
                                                </td>
                                                <td>
                                                    <p>{{item.tenTruong}}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer clearfix">
                            <el-button plain type="default" size="mini" data-dismiss="modal">Đóng
                            </el-button>
                        </div>
                    </div>
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
        props: [],
        watch: {

            maPhongs: function (newVal, oldVal) {
                this.chonDonVi();
            }
        },
        components: {
            'eselect': ESelectVue,
        },
        data() {
            return {
                maTruong: "",
                list_loi: [],
                messloi: "",
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
            this.getDonVi();
            $(this.$refs.modal_import_file).on("hidden.bs.modal", this.closemodal2);
            $("#modal_kt").modal();
            $(this.$refs.modal_kt).on("hidden.bs.modal", this.close);
        },
        methods: {
            closemodal2() {
                $(this.$refs.modal_import_file).on("hidden.bs.modal");
            },
            themMoi() {
                if (this.loai_don_vi.length == 0) {
                    this.$alertify.error("Thiếu loại đơn vị");
                    return
                };
                if (this.maPhongs.length == 0) {
                    this.$alertify.error("Thiếu đơn vị");
                    return
                };
                if (this.truong && this.maTruongHocs.length == 0) {
                    this.$alertify.error("Thiếu trường học");
                    return
                };
                let params = {
                    maPhongs: this.maPhongs,
                    maTruongHocs: this.maTruongHocs,
                    phong: this.phong,
                    truong: this.truong,
                    truongDuocNopLenBo: this.truongDuocNopLenBo,
                    phongDuocNopLenBo: this.phongDuocNopLenBo,
                };
                console.log(JSON.stringify(params));

                this.$confirm('Xác nhận thêm mới?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        const loading = this.$loading({
                            lock: true,
                            text: 'Loading',
                            spinner: 'el-icon-loading',
                            background: 'rgba(0, 0, 0, 0.7)'
                        });
                        rest_api.post("/csdlgd-admin/duyetDayDuLieu/taoCauHinh", params, data => {
                            loading.close()
                            if (data.data.rc == 0) {
                                this.$alertify.success("Thêm mới thành công");
                                this.$emit('success');
                            } else if (data.data.rc == 304) {
                                this.messloi = data.data.rd;
                                this.list_loi = data.data.rows;
                                $("#modal_import_file").modal();
                            } else {
                                utils.showDialog("Thất bại", data.data.rd, null, () => {});
                            }
                        });
                    })
                    .catch(_ => {});
            },
            chonLoaiDonVi() {
                console.log("chọn loại đơn vị:");
                this.maTruongHocs = []
                this.maPhongs = []
                this.list_truong_hoc = [];
                this.phong = false;
                this.truong = false;
                this.phongDuocNopLenBo = false;
                this.truongDuocNopLenBo = false;
                for (let i = 0; i < this.loai_don_vi.length; i++) {
                    if (this.loai_don_vi[i] == 1) {
                        this.phong = true;
                    }
                    if (this.loai_don_vi[i] == 2) {
                        this.truong = true;
                    }
                }
                console.log(this.phong);
                console.log(this.truong);
            },
            close() {
                this.$emit('close');
            },
            chonCapHoc() {
                this.list_truong_hoc = [];
                this.maTruongHocs = []
                this.getTruongHoc();
            },
            chonDonVi() {
                this.maTruongHocs = []
                this.list_truong_hoc = [];
                this.getTruongHoc();
            },
            getDonVi() {

                let params = {
                    "start": 0,
                    "limit": 9999,
                    "maTinhThanh": this.thongtin.province
                };
                rest_api.get("/internal-api/dmDonVi/filter", params, (data) => {
                    if (data.data.statusResponse == 0) {
                        let dm = data.data.rows;
                        this.list_don_vi = []
                        for (let i = 0; i < dm.length; i++) {
                            let obj = {
                                name: dm[i].tenDonVi,
                                value: dm[i].maDonVi
                            }
                            this.list_don_vi.push(obj)
                        }
                    }
                });
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: this.maPhongs,
                    capHoc: this.cap_hoc
                };
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    if (data.data.code == 200) {
                        let lstth = data.data.rows;
                        for (let i = 0; i < lstth.length; i++) {
                            let obj = {
                                name: lstth[i].tenTruongHoc + ' - [' + lstth[i].maTruongHoc + ']',
                                value: lstth[i].maTruongHoc
                            }
                            this.list_truong_hoc.push(obj);
                        }
                    }
                });
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

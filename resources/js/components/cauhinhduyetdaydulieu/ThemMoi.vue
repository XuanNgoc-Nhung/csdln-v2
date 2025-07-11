<template>
    <div>

        <el-dialog title="Thêm mới cấu hình duyệt đẩy dữ liệu" :visible.sync="show" width="80%"
            :close-on-click-modal="false" :close-on-press-escape="false" :before-close="handleClose">
            <div>
                <el-form :model='formData' :rules="rules" ref="ruleForm">
                    <el-row :gutter="24">
                        <el-col :md="8" :lg="6">
                            <label>Loại đơn vị <span style="color:#DC0101"> *</span></label>
                            <el-form-item prop="loai_don_vi">
                                <!-- <el-select v-model="formData.loai_don_vi" ref="loai_don_vi" multiple filterable
                                    collapse-tags @change="chonLoaiDonVi" placeholder="Chọn"
                                    no-data-text="Không có dữ liệu" no-match-text="Không có dữ liệu phù hợp">
                                    <el-option v-for="item in list_loai_don_vi" :key="item.value" :label="item.name"
                                        :value="item.value">
                                    </el-option>
                                </el-select> -->
                                <eselect style="width:100%" ref="loai_don_vi" collapseTags
                                    v-model="formData.loai_don_vi" @change="chonLoaiDonVi" :placeholder="'Chọn'"
                                    filterable :data="list_loai_don_vi" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :md="16" :lg="12"  v-if="formData.loai_don_vi=='2'">
                            <label class="typo__label p-3">Đơn vị quản lý</label>
                                <eselect style="width:100%" multiple collapseTags
                                    v-model="formData.maPhongs" @change="chonDonViQuanLy" :placeholder="'Chọn'"
                                    filterable :data="list_don_vi" :fields="['name','value']" />
                        </el-col>
                        <el-col :md="16" :lg="12" v-else>
                            <label class="typo__label p-3">Đơn vị quản lý <span style="color:#DC0101">
                                    *</span></label>
                            <el-form-item prop="maPhongs">
                                <eselect style="width:100%" ref="maPhongs" multiple collapseTags
                                    v-model="formData.maPhongs" @change="chonDonViQuanLy" :placeholder="'Chọn'"
                                    filterable :data="list_don_vi" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                        <el-col :md="8" :lg="6" v-if="formData.loai_don_vi==2">
                            <label class="typo__label">Cấp học</label>

                            <el-form-item prop="cap_hoc">
                                <eselect style="width:100%" ref="cap_hoc" :disabled="phong&&!truong" multiple
                                    collapseTags v-model="formData.cap_hoc" @change="chonCapHoc"
                                    :placeholder="'Chọn'" filterable :data="list_cap_hoc"
                                    :fields="['name','id']" />
                            </el-form-item>
                        </el-col>
                        <el-col :md="16" :lg="12" v-if="formData.loai_don_vi==2">
                            <label class="typo__label">Trường học <span style="color:#DC0101">
                                    *</span></label>
                            <el-form-item prop="maTruongHocs">
                                <eselect style="width:100%" :disabled="phong&&!truong" multiple collapseTags
                                    @change="check_confirm_come_back = true" ref="maTruongHocs"
                                    v-model="formData.maTruongHocs" :placeholder="'Chọn'" filterable
                                    :data="list_truong_hoc" :fields="['name','value']" />
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <!-- <el-row :gutter="24">
                        <el-col :span="24">
                            <span style="margin:0 10px 0 0"><input :disabled="truong&&!phong"
                                    v-model="phongDuocNopLenBo" type="checkbox">Phòng
                                được đẩy lên Bộ</span>
                            <span style="margin:0 10px"><input :disabled="phong&&!truong"
                                    @change="check_confirm_come_back = true" v-model="truongDuocNopLenBo"
                                    type="checkbox">Trường được đẩy lên Bộ</span>
                        </el-col>
                    </el-row> -->
                </el-form>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button type="default" @click="handleClose" size="mini">Đóng</el-button>
                <el-button size="mini" type="primary" @click.prevent="submitForm('ruleForm')">Lưu</el-button>
            </span>
            <el-dialog :close-on-click-modal="false" :close-on-press-escape="false" width="50%"
                title="DANH SÁCH LOẠI ĐƠN VỊ ĐÃ CÓ CẤU HÌNH DUYỆT ĐẨY" :visible.sync="modal_import_file" append-to-body>
                <div>
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

                <span slot="footer" class="dialog-footer">
                    <el-button type="default" @click="modal_import_file=false" size="mini">Đóng</el-button>
                </span>
            </el-dialog>
        </el-dialog>
        <div v-if="false" id="modal_kt" ref="modal_kt" class="modal fade" style="font-size:18px;">
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
                                    <label class="typo__label p-3">Đơn vị quản lý <span style="color:#DC0101">
                                            *</span></label>
                                    <eselect style="width:100%" multiple collapseTags v-model="maPhongs"
                                        @change="check_confirm_come_back = true" :placeholder="'Chọn'" filterable
                                        :data="list_don_vi" :fields="['name','value']" />
                                </div>
                                <div class="col-md-2">
                                    <label class="typo__label">Cấp học</label>
                                    <eselect style="width:100%" :disabled="phong&&!truong" multiple collapseTags
                                        v-model="cap_hoc" @change="chonCapHoc" :placeholder="'Chọn'" filterable
                                        :data="list_cap_hoc" :fields="['name','id']" />
                                </div>
                                <div class="col-md-4">
                                    <label class="typo__label">Trường học <span style="color:#DC0101">
                                            *</span></label>
                                    <eselect style="width:100%" :disabled="phong&&!truong" multiple collapseTags
                                        @change="check_confirm_come_back = true" v-model="maTruongHocs"
                                        :placeholder="'Chọn'" filterable :data="list_truong_hoc"
                                        :fields="['name','value']" />
                                </div>
                            </div>
                            <div class="row" style="padding-top:20px;">
                                <div class="col-md-12">
                                    <span style="margin:0 10px 0 0"><input :disabled="truong&&!phong"
                                            v-model="phongDuocNopLenBo" type="checkbox" style="margin-right:10px">Phòng
                                        được đẩy lên Bộ</span>
                                    <span style="margin:0 10px"><input :disabled="phong&&!truong"
                                            @change="check_confirm_come_back = true" v-model="truongDuocNopLenBo"
                                            type="checkbox" style="margin-right:10px">Trường được đẩy lên Bộ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer clearfix">
                        <el-button plain type="default" size="mini" @click.prevent="handleClose()">Đóng</el-button>
                        <el-button plain type="primary" size="mini" @click.prevent="themMoi()">Lưu</el-button>
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
        props: ['show'],
        watch: {
            show: function (newVal, oldVal) {
                if (newVal) {
                    this.formData = {
                        loai_don_vi: 1,
                        maPhongs: [],
                        cap_hoc: '',
                        maTruongHocs: []
                    }
                    this.truong = false;
                    this.phong = false;
                    this.truongDuocNopLenBo = false;
                    this.phongDuocNopLenBo = false;
                this.check_confirm_come_back = false;
                this.$refs['ruleForm'].resetFields();
                }
            },
            maPhongs: function (newVal, oldVal) {
                this.chonDonVi();
            }
        },
        components: {
            'eselect': ESelectVue,
        },
        data() {
            return {
                formData: {
                    loai_don_vi: 1,
                    maPhongs: [],
                    cap_hoc: '',
                    maTruongHocs: []
                },
                rules: {
                    loai_don_vi: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                    maPhongs: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                    maTruongHocs: [{
                        required: true,
                        message: 'Vui lòng nhập thông tin',
                        trigger: ['change', 'blur']
                    }, ],
                },
                maTruong: "",
                list_loi: [],
                messloi: "",
                modal_import_file: false,
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
                    value: 1
                }, {
                    name: "Trường",
                    value: 2
                }],
                loai_don_vi: [],
                list_don_vi: [],
                list_truong_hoc: [],
                maPhongs: [],
                check_confirm_come_back: false,
            }
        },
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            this.getDonVi();
        },
        methods: {

            submitForm(formName) {
                console.log('submitForm')
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        console.log('Validate success')
                        this.themMoi();
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            handleClose() {
                if (this.check_confirm_come_back) {
                    this.$confirm(
                            'Các thông tin vừa nhập sẽ bị mất khi đóng trang. Thầy cô có muốn tiếp tục chỉnh sửa, kiểm tra và lưu lại thông tin đã nhập?',
                            'Thông báo', {
                                confirmButtonText: 'Rời khỏi trang',
                                cancelButtonText: 'Tiếp tục chỉnh sửa',
                                confirmButtonClass: 'el-button--danger',
                                closeOnClickModal: false,
                            })
                        .then(_ => {
                            this.$emit('close');
                        })
                        .catch(_ => {});
                } else {
                    this.$emit('close');
                }
            },
            closemodal2() {
                this.modal_import_file = false;
            },
            themMoi() {
                let params = {
                    maPhongs: this.formData.maPhongs,
                    maTruongHocs: this.formData.maTruongHocs,
                    phong: this.formData.loai_don_vi==1?true:false,
                    truong: this.formData.loai_don_vi==2?true:false,
                    truongDuocNopLenBo: this.formData.loai_don_vi==2?true:false,
                    phongDuocNopLenBo: this.formData.loai_don_vi==1?true:false,
                };
                console.log(JSON.stringify(params));

                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/csdlgd-admin/duyetDayDuLieu/taoCauHinh", params, data => {
                    loading.close()
                    if (data.data.rc == 0) {
                        this.$alertify.success("Thêm mới cấu hình duyệt đẩy dữ liệu thành công");
                        this.$emit('success');
                    } else if (data.data.rc == 304) {
                        this.messloi = data.data.rd;
                        this.list_loi = data.data.rows;
                        this.modal_import_file = true;
                    } else {
                        utils.showDialog("Thất bại", data.data.rd, null, () => {});
                    }
                });
            },
            chonLoaiDonVi() {
                this.check_confirm_come_back = true;
                console.log("chọn loại đơn vị:");
                this.formData.maTruongHocs = []
                this.formData.maPhongs = []
                this.list_truong_hoc = [];
                this.phong = false;
                this.truong = false;
                this.phongDuocNopLenBo = false;
                this.truongDuocNopLenBo = false;
                this.rules.maTruongHocs.required = false;
                console.log(this.formData.loai_don_vi);
                for (let i = 0; i < this.formData.loai_don_vi.length; i++) {
                    if (this.formData.loai_don_vi[i] == 1) {
                        this.phong = true;
                    }
                    if (this.formData.loai_don_vi[i] == 2) {
                        this.truong = true;
                    }
                }
                console.log(this.rules.maTruongHocs);
            },
            close() {
                this.$emit('close');
            },
            chonDonViQuanLy() {
                this.check_confirm_come_back = true;
                this.list_truong_hoc = [];
                this.formData.maTruongHocs = []
                this.getTruongHoc();
            },
            chonCapHoc() {
                this.check_confirm_come_back = true;
                this.list_truong_hoc = [];
                this.formData.maTruongHocs = []
                this.getTruongHoc();
            },
            chonDonVi() {
                this.check_confirm_come_back = true;
                this.formData.maTruongHocs = []
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
                    maDonVi: this.formData.maPhongs,
                    capHoc: this.formData.cap_hoc
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
        margin: 0;
    }

</style>

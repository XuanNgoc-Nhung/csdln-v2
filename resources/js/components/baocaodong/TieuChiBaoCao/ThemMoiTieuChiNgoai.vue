<template>
    <div>

        <el-dialog title="Thêm mới tiêu chí" width="90%" top="5vh" :visible.sync="show_add" @close="dongModal">
            <el-row :gutter="20">
                <el-col :span="6">
                    <label class="typo__label">Đơn vị quản lý</label>
                    <eselect collapseTags v-model="maDonViQuanLy" :placeholder="'Chọn'" @change="ChonCapHoc" filterable
                        :data="list_don_vi" :fields="['tenDonVi','maDonVi']" />
                </el-col>
                <el-col :span="4">
                    <label class="typo__label">Cấp học</label>
                    <eselect collapseTags v-model="capHoc" @change="ChonCapHoc" :placeholder="'Chọn'" filterable
                        :data="list_cap_hoc" :fields="['name','id']" />
                </el-col>
                <el-col :span="6">
                    <label class="typo__label">Trường học</label>
                    <eselect style="width:100%" collapseTags v-model="maTruongHoc" :placeholder="'Chọn'" filterable
                        :data="list_truong_hoc" :fields="['tenTruongHoc','maTruongHoc']" />
                </el-col>
                <el-col :span="4">
                    <label class="typo__label">Năm học</label>
                    <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                        :data="list_nam_hoc" :fields="['name','id']" />
                </el-col>
                <el-col :span="4">
                    <label class="typo__label">Học kỳ</label>
                    <eselect style="width:100%" collapseTags v-model="hocKy" :placeholder="'Chọn'" filterable
                        :data="list_hoc_ky" :fields="['name','id']" />
                </el-col>
                <el-col :span="6">
                    <label class="typo__label">Giai đoạn</label>
                    <eselect style="width:100%" collapseTags v-model="maGiaiDoan" :placeholder="'Chọn'" filterable
                        :data="list_giai_doan" :fields="['name','value']" />
                </el-col>
                <el-col :span="4">
                    <label class="typo__label">Tên tiêu chí <span class="red"><sup>*</sup></span></label>
                    <el-input clearable placeholder="Nhập..." v-model="tenTieuChi"></el-input>
                </el-col>
                <el-col :span="6">
                    <label class="typo__label">Mã tiêu chí <span class="red"><sup>*</sup></span></label>
                    <el-input clearable placeholder="Nhập..." v-model="maTieuChi"></el-input>
                </el-col>
                <el-col :span="4">
                    <label class="typo__label">Giá trị <span class="red"><sup>*</sup></span></label>
                    <el-input clearable placeholder="Nhập..." v-model="giaTri"></el-input>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" @click="dongModal">Đóng</el-button>
                <el-button size="mini" type="primary" @click="confirmThemMoi">Thêm mới</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    import ElementUI from 'element-ui';
    import rest_api from "../../../utils/rest_api";
    import constant from '../../../utils/constant';
    import ESelectVue from '../../ui/ESelect.vue';
    Vue.use(ElementUI);
    export default {

        props: ['show', 'list_don_vi', 'list_truong','item'],
        components: {
            'eselect': ESelectVue,
        },
        mounted: function () {
            this.namHoc = this.thongtin.namHocHienTai;
        },
        data() {
            return {
                show_add:false,
                thongtin: JSON.parse(window.userInfo),
                list_cap_hoc: window.listCapHoc,
                maDonViQuanLy: '',
                capHoc: '',
                list_truong_hoc: [],
                list_hoc_ky: constant.LIST_HOC_KY,
                list_giai_doan: [{
                        name: 'Giữa kỳ I',
                        value: 'GK1'
                    },
                    {
                        name: 'Cuối kỳ II',
                        value: 'CK1'
                    },
                    {
                        name: 'Giữa kỳ I',
                        value: 'GK2'
                    },
                    {
                        name: 'Cuối kỳ II',
                        value: 'CK2'
                    },
                ],
                maTruongHoc: '',
                namHoc: '',
                list_nam_hoc: constant.LIST_YEARS_FULL,
                hocKy: '',
                maGiaiDoan: '',
                tenTieuChi: '',
                maTieuChi: '',
                giaTri: '',
            };
        },

        watch: {
            list_truong: function (val) {
                if (val) {
                    this.list_truong_hoc = val;
                }
            },
            show: function (val) {
                if (val) {
                    this.show_add = true;
                }else{
                    this.show_add=false
                }
            },
            item:function(val){
                if(val){
                    let data = val;
                    this.maDonViQuanLy = data.maDonViQuanLy;
                    if (data.capHocList) {
                        this.capHoc = parseInt(data.capHocList);
                    }
                    this.maTruongHoc = data.maTruongHoc;
                    this.namHoc = data.namHoc;
                    this.hocKy = data.hocKy;
                    this.maGiaiDoan = data.maGiaiDoan;
                    this.tenTieuChi = data.tenTieuChi;
                    this.maTieuChi = data.maTieuChi;
                    this.giaTri = data.giaTri;
                }
            }
        },
        methods: {
            confirmThemMoi() {
                console.log("Thông tin thêm mới:")
                console.log(this.maDonViQuanLy)
                console.log(this.capHoc)
                console.log(this.maTruongHoc)
                console.log(this.namHoc)
                console.log(this.hocKy)
                console.log(this.maGiaiDoan)
                console.log(this.tenTieuChi)
                console.log(this.maTieuChi)
                console.log(this.giaTri)
                if(!this.tenTieuChi||!this.maTieuChi||!this.giaTri){
                    this.thongBao('error','Vui lòng kiểm tra lại thông tin')
                    return;
                }
                this.$confirm('Xác nhận thêm mới?', 'Thông báo', {
                        confirmButtonText: 'Xác nhận',
                        cancelButtonText: 'Hủy',
                        closeOnClickModal: false,
                    })
                    .then(_ => {
                        let params = {
                            capHocList: this.capHoc,
                            giaTri: this.giaTri,
                            hocKy: this.hocKy,
                            maDonViQuanLy: this.maDonViQuanLy,
                            maGiaiDoan: this.maGiaiDoan,
                            maTieuChi: this.maTieuChi,
                            maTruongHoc: this.maTruongHoc,
                            namHoc: this.namHoc,
                            tenTieuChi: this.tenTieuChi,
                        }
                        console.log("Thông tin thêm:")
                        rest_api.post("/csdlgd-analytic-api/external-data/insert", params, response => {
                            console.log('thêm mới trả về:')
                            console.log(response)
                            if(response.statusText=='OK'){
                                this.thongBao('success','Thêm mới thành công');
                                this.$emit('success')
                            }else{
                                this.thongBao('error','Thêm mới thất bại')
                            }
                        });
                    })
                    .catch(_ => {});
            },
            dongModal() {
                this.$emit('close');
            },
            ChonCapHoc() {
                this.maTruongHoc = '';
                this.list_truong_hoc = [];
                this.getTruongHoc();
            },
            getTruongHoc() {
                this.list_truong_hoc = [];
                let params = {
                    maDonVi: [],
                    capHoc: []
                };
                if (this.maDonViQuanLy) {
                    params.maDonVi = [this.maDonViQuanLy];
                }
                if (this.capHoc) {
                    params.capHoc = [this.capHoc];
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, data => {
                    loading.close();
                    if (data.data.statusResponse == 0) {
                        let dulieu = data.data.rows;
                        let ldv = [];
                        for (let i = 0; i < dulieu.length; i++) {
                            let obj = {
                                tenTruongHoc: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                maTruongHoc: dulieu[i].maTruongHoc
                            }
                            ldv.push(obj)
                        }
                        this.list_truong_hoc = ldv;
                    } else {
                        this.list_truong_hoc = [];
                    }
                });
            },

            thongBao(t, e) {
                let msg = "";
                let cl = "";
                if (e) {
                    msg = e;
                }
                let type = "success";
                if (t) {
                    type = t
                }
                if (type == "success") {
                    cl = "dts-noty-success"
                }
                if (type == "warning") {
                    cl = "dts-noty-warning"
                }
                if (type == "error") {
                    cl = "dts-noty-error"
                }
                if (type == "info") {
                    cl = "dts-noty-info"
                }
                this.$message({
                    customClass: cl,
                    showClose: true,
                    message: msg,
                    type: t,
                    duration: 5000
                });
            },
        }
    };

</script>
<style scoped="scoped">
</style>

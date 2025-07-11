<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog width="80%" top="15vh" :title="text_header" custom-class="showThongTinLoiImportSSO"
            :visible.sync="show_update" :close-on-press-escape="false" append-to-body :close-on-click-modal="false"
            :show-close="false" @before-close="closeImport">
            <el-row :gutter="20">
                <el-col :xs="24" :sm="16" :md="16" :lg="8">
                    <label>Đơn vị:</label>
                    <eselect collapseTags v-model="dataEdit.maDonVi" @change="chonDonVi" :placeholder="'Chọn'"
                        filterable :data="list_don_vi" :fields="['name','value']" />
                </el-col>
                <el-col :xs="24" :sm="8" :md="8" :lg="4">
                    <label>Cấp học</label>
                    <eselect collapseTags v-model="dataEdit.capHocs" @change="chonCapHoc" :placeholder="'Chọn'"
                        filterable :data="list_cap_hoc" :fields="['name','id']" />
                </el-col>
                <el-col :xs="24" :sm="16" :md="16" :lg="8">
                    <label>Trường học: <span class="red">*</span></label>
                    <eselect collapseTags v-model="dataEdit.maTruongHoc" :placeholder="'Chọn'" filterable
                        :data="list_truong_hoc" :fields="['name','value']" />
                </el-col>
                <el-col :xs="24" :sm="8" :md="8" :lg="4">
                    <label>Đối tác: <span class="red">*</span></label>
                    <eselect collapseTags v-model="dataEdit.maDoiTac" :placeholder="'Chọn'" filterable
                        :data="list_doi_tac" :fields="['name','value']" />
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="danger" @click="closeImport">Huỷ</el-button>
                <el-button size="mini" type="warning" @click.prevent="confirmUpdate">Chỉnh sửa</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import DatePicker from 'vue2-datepicker';
    import ESelectVue from '../../ui/ESelect.vue';
    import 'vue2-datepicker/index.css';

    export default {
        props: ['item', 'list_doi_tac'],
        components: {
            DatePicker,
            'eselect': ESelectVue,
        },
        watch: {},
        data() {
            return {
                loading: {
                    status: false,
                    text: 'Loading...'
                },
                show_update: false,
                text_header: 'Chỉnh sửa thông tin đối tác trường',
                list_don_vi: [],
                list_truong_hoc: [],
                dataEdit: {},
                thongtin: {},
                list_cap_hoc: window.listCapHoc,
            }
        },

        mounted: function () {
            console.log('Mounted chỉnh sửa giáo viên')
            this.thongtin = JSON.parse(window.userInfo);
            console.log(this.item)
            this.getDonVi();
            this.getTruongHoc();
            this.ganDuLieuChinhSua();
        },
        methods: {
            confirmUpdate() {
                console.log('confirmUpdate');
                if (!this.dataEdit.maDoiTac || this.dataEdit.maDoiTac == '') {
                    this.thongBao('error', 'Vui lòng bổ sung đối tác');
                    return
                }
                if (!this.dataEdit.maTruongHoc || this.dataEdit.maTruongHoc == '') {
                    this.thongBao('error', 'Vui lòng bổ sung trường học');
                    return
                }

                this.upDate();
                // this.$confirm('Xác nhận chỉnh sửa dữ liệu?', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {})
                //     .catch(_ => {});
            },
            upDate() {
                try {
                    let params = {
                        "id": this.dataEdit.id,
                        "maDoiTac": this.dataEdit.maDoiTac,
                        "maTruongHoc": this.dataEdit.maTruongHoc,
                    };
                    this.loading.text = 'Vui lòng đợi...';
                    this.loading.status = true;
                    rest_api.post("/csdlgd-admin/heThongDoiTacTruong/updateDoiTacTruong", params, (response) => {
                        if (response && response.data.rc == 0) {
                            this.thongBao('success', 'Chỉnh sửa thành công');
                            this.loading.status = false;
                            this.$emit('updateSuccess');
                        } else {
                            this.thongBao('error', response.data.rd)
                        }
                        this.loading.status = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Có lỗi trong quá trình thao tác. Vui lòng thử lại');
                }
            },
            ganDuLieuChinhSua() {
                console.log('ganDuLieuChinhSua')
                this.dataEdit = JSON.parse(JSON.stringify(this.item));
                this.show_update = true;
            },
            chonCapHoc() {
                this.dataEdit.maTruongHoc = '';
                this.list_truong_hoc = [];
                this.getTruongHoc()
            },
            chonDonVi() {
                this.chonCapHoc();
            },
            getDonVi() {
                console.log('getDonVi');
                try {
                    console.log("Lấy danh sách đơn vị:")
                    let params = {
                        "start": 0,
                        "limit": 9999,
                        "maTinhThanh": this.thongtin.ma_so
                    };
                    this.loading.status = true;
                    this.loading.text = 'Lấy danh sách đơn vị';
                    rest_api.get("/internal-api/dmDonVi/filter", params, (response) => {
                        console.log("res lấy đơn vị:")
                        console.log(response)
                        if (response.data.code == 200) {
                            let ldv = []
                            let dulieu = response.data.rows;
                            for (let i = 0; i < dulieu.length; i++) {
                                let obj = {
                                    name: dulieu[i].tenDonVi.replace("Giáo dục và Đào tạo", "GD&ĐT") +
                                        ' - [' + dulieu[i].maDonVi + ']',
                                    value: dulieu[i].maDonVi
                                }
                                ldv.push(obj)
                            }
                            this.list_don_vi = ldv;
                        } else {

                        }
                        this.loading.status = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
                }
            },
            getTruongHoc() {
                console.log('Lấy trường học')
                try {
                    this.list_truong_hoc = [];
                    let params = {
                        maDonVi: [],
                        capHoc: []
                    };
                    if (this.dataEdit.maDonVi && this.dataEdit.maDonVi != '') {
                        params.maDonVi = [this.dataEdit.maDonVi];
                    }
                    if (this.dataEdit.capHoc && this.dataEdit.capHoc != '') {
                        params.capHoc = [parseInt(this.dataEdit.capHoc)];
                    }
                    this.loading.text = 'Lấy trường học';
                    this.loading.status = true;
                    rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, response => {
                        if (response.data.code == 200) {
                            let data_demo = response.data.rows;
                            for (let i = 0; i < data_demo.length; i++) {
                                let obj = {
                                    name: data_demo[i].tenTruongHoc + " - [" + data_demo[i].maTruongHoc +
                                        "]",
                                    value: data_demo[i].maTruongHoc
                                }
                                this.list_truong_hoc.push(obj)
                            }
                        } else {
                            this.thongBao('error', 'Không lấy được danh sách trường')
                        }
                        this.loading.status = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Không lấy được danh sách trường')
                }
            },
            closeImport() {
                this.$emit('close');
            },

            thongBao(typeNoty, message) {
                let msg = "";
                let cl = "";
                if (message) {
                    msg = message;
                }
                let type = "success";
                if (typeNoty) {
                    type = typeNoty
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
                    type: type,
                    duration: 5000
                });
            },
        }

    }

</script>
<style scoped="scoped">
    .bg-purple {
        background: #d3dce6;
    }

    .grid-content {
        border-radius: 4px;
        min-height: 36px;
    }

    .mt-15 {
        margin-top: 15px
    }

    .mb-15 {
        margin-bottom: 15px
    }

    .pd-10 {
        padding: 10px
    }

</style>

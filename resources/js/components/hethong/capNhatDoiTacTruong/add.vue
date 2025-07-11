<template>
    <div v-loading.fullscreen.lock="loading.status" :element-loading-text="loading.text"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog width="80%" top="15vh" :title="text_header" custom-class="showThongTinLoiImportSSO"
            :visible.sync="show_add" :close-on-press-escape="false" append-to-body :close-on-click-modal="false"
            :show-close="false" @before-close="closeImport">
            <el-row :gutter="20">
                <el-col :xs="24" :sm="16" :md="16" :lg="8">
                    <label>Đơn vị:</label>
                    <eselect collapseTags v-model="dataAdd.donVis" multiple @change="chonDonVi" :placeholder="'Chọn'"
                        filterable :data="list_don_vi" :fields="['name','value']" />
                </el-col>
                <el-col :xs="24" :sm="8" :md="8" :lg="4">
                    <label>Cấp học</label>
                    <eselect collapseTags v-model="dataAdd.capHocs" multiple @change="chonCapHoc" :placeholder="'Chọn'"
                        filterable :data="list_cap_hoc" :fields="['name','id']" />
                </el-col>
                <el-col :xs="24" :sm="16" :md="16" :lg="8">
                    <label>Trường học: <span class="red">*</span></label>
                    <eselect collapseTags v-model="dataAdd.truongHocs" :placeholder="'Chọn'" filterable
                        :data="list_truong_hoc" multiple :fields="['name','value']" />
                </el-col>
                <el-col :xs="24" :sm="8" :md="8" :lg="4">
                    <label>Đối tác: <span class="red">*</span></label>
                    <eselect collapseTags v-model="dataAdd.doiTac" :placeholder="'Chọn'" filterable :data="list_doi_tac"
                        :fields="['name','value']" />
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="danger" @click="closeImport">Huỷ</el-button>
                <el-button size="mini" type="primary" @click.prevent="confirmAdd">Thêm mới</el-button>
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
                show_add: false,
                text_header: 'Thêm mới thông tin đối tác trường',
                list_don_vi: [],
                list_truong_hoc: [],
                dataAdd: {
                    donVis: [],
                    capHocs: [],
                    truongHocs: [],
                    doiTac: ''
                },
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
            this.show_add = true;
        },
        methods: {
            confirmAdd() {
                console.log('confirmAdd');
                console.log(this.dataAdd)
                if (!this.dataAdd.truongHocs || this.dataAdd.truongHocs == '') {
                    this.thongBao('error', 'Vui lòng bổ sung trường học');
                    return
                }
                if (!this.dataAdd.doiTac || this.dataAdd.doiTac == '') {
                    this.thongBao('error', 'Vui lòng bổ sung đối tác');
                    return
                }
                this.addData();
                // this.$confirm('Xác nhận thêm mới dữ liệu', 'Thông báo', {
                //         confirmButtonText: 'Xác nhận',
                //         cancelButtonText: 'Hủy',
                //     })
                //     .then(_ => {})
                //     .catch(_ => {});
            },
            addData() {
                try {

                    this.ds_req = [];
                    for (let i = 0; i < this.dataAdd.truongHocs.length; i++) {
                        let obj = {
                            maDoiTac: this.dataAdd.doiTac,
                            maTruongHoc: this.dataAdd.truongHocs[i]
                        }
                        this.ds_req.push(obj)
                    }
                    let params = {
                        truongEntities: this.ds_req
                    };
                    this.loading.text = 'Vui lòng đợi...';
                    this.loading.status = true;
                    rest_api.post("/csdlgd-admin/heThongDoiTacTruong/createDoiTacTruong", params, (response) => {
                        if (response && response.data.rc == 0) {
                            this.thongBao('success', 'Thêm mới đối tác thành công');
                            this.loading.status = false;
                            this.$emit('addSuccess');
                        } else {
                            this.thongBao('error', response.data.rd)
                        }
                        this.loading.status = false;
                    });
                } catch (e) {
                    this.thongBao('error', 'Có lỗi trong quá trình thao tác. Vui lòng thử lại');
                }
            },
            chonCapHoc() {
                this.dataAdd.truongHocs = [];
                this.list_truong_hoc = [];
                this.getTruongHoc();
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
                        maDonVi: this.dataAdd.donVis,
                        capHoc: this.dataAdd.capHocs
                    };
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

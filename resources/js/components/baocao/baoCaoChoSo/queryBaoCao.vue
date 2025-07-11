<template>
    <div v-loading.fullscreen.lock="loading" :element-loading-text="loadingText"
        element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
        <el-dialog :close-on-click-modal="false" width="90%" :close-on-press-escape="false" :before-close="dongModal"
            :title="textTitle" :visible.sync="hienThiPopup">
            <el-row :gutter="20">
                <el-col :xs="24" :sm="24" :md="12" :lg="12" >
                    <label for="">Đơn vị quản lý
                        <!-- <span class="red" v-if="!truongHoc||truongHoc.length==0">*</span> -->
                    </label>
                    <eselect style="width:100%" multiple collapseTags v-model="donVi" :disabled="thongtin.role>3"
                        clearable @change="chonDonVi" :placeholder="'Chọn'" filterable :data="list_don_vi"
                        :fields="['name','value']" />
                </el-col>
                <el-col v-if="thongtin.ma_so==36||thongtin.ma_so==19" :xs="24" :sm="12" :md="6" :lg="6" >
                    <label for="">Loại hình đào tạo </label>
                    <eselect style="width:100%" collapseTags v-model="loaiHinhTruong" @change="chonDonVi" clearable
                        :placeholder="'Chọn'" filterable :data="list_loai_hinh_dao_tao"
                        :fields="['name','value']" />
                </el-col>
                <el-col v-if="caphoc==4||caphoc==5" :xs="24" :sm="12" :md="6" :lg="6" >
                    <label for="">Quy mô</label>
                    <eselect style="width:100%" clearable @change="getTruongHoc" multiple collapseTags
                        v-model="nhomTreMamNon" :placeholder="'Chọn'" filterable :data="nhom_tre_doc_lap"
                        :fields="['constantTitle','moetCode']" />
                </el-col>
                <el-col :xs="24" :sm="24" :md="12" :lg="12" >
                    <label for="">Trường học
                    </label>
                    <eselect style="width:100%" :disabled="thongtin.role==5" multiple collapseTags v-model="truongHoc"
                        :placeholder="'Chọn'" filterable clearable :data="danh_sach_truong_hoc"
                        :fields="['name','value']" />
                </el-col>
                <el-col :xs="12" :sm="12" :md="6" :lg="6" >
                    <label for="">Năm học <span class="red">*</span></label>
                    <eselect style="width:100%" collapseTags v-model="namHoc" :placeholder="'Chọn'" filterable
                        :data="list_nam_hoc" :fields="['name','id']" />
                </el-col>
                <el-col v-if="canhocky" :xs="12" :sm="12" :md="8" :lg="6" >
                    <label for="">Học kỳ <span class="red">*</span></label>
                    <eselect style="width:100%" collapseTags v-model="hocKy" :placeholder="'Chọn'" filterable
                        :data="list_hoc_ky" :fields="['name','id']" />
                </el-col>
            </el-row>
            <el-row :gutter="20">
                <el-col :span="24" class="text-center">
                    <el-button type="primary" @click.prevent="getDataBaoCao(1)" size="mini">Xem báo cáo
                    </el-button>
                    <el-button @click.prevent="getDataBaoCao(2)" type="primary" size="mini">Xuất Excel
                    </el-button>
                </el-col>
            </el-row>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="default" @click.prevent="close()">Đóng</el-button>
            </span>
        </el-dialog>

    </div>
</template>
<script>
    import rest_api from "../../../utils/rest_api";
    import constant from "../../../utils/constant";
    import ESelectVue from '../../ui/ESelect.vue';

    export default {
        props: [
            'ten', 'cln', 'caphoc', 'canhocky', 'item', 'list_don_vi', 'category'
        ],
        watch: {
            item: function (newVal) {
                console.error("Thông tin thay đổi")
                this.loaiHinhTruong = ''
                console.log(this.thongtin)
                console.log("newVal" + newVal)
                if (newVal) {
                    this.namHoc = this.thongtin.namHocHienTai;
                    this.truongHoc = [];
                    this.nhomTreMamNon = [];
                    this.hienThiPopup = true;
                    if (this.thongtin.role > 3) {
                        this.donVi = [this.thongtin.ma_don_vi]
                    }
                    if (this.thongtin.role == 5) {
                        this.truongHoc = [this.thongtin.ma_truong_hoc]
                    }
                    this.textTitle = this.category + ' - ' + this.ten;
                } else {
                    this.hienThiPopup = false;
                }
                console.error('Bind');
                console.error(this.donVi);
            },
            caphoc: function (newVal) {
                if (newVal) {
                    console.log("Cấp học thay đổi")
                    console.log(newVal)
                    if (newVal == 5 || newVal == 4) {
                        this.getNhomCapHoc(newVal)
                    }
                    this.getTruongHoc();

                }
            }
        },
        components: {
            'eselect': ESelectVue,
        },
        data() {
            return {
                taiXuong: false,
                loading: false,
                loadingText: 'Loading...',
                danh_sach_truong_hoc: [],
                hienThiPopup: false,
                thongtin: JSON.parse(window.userInfo),
                textTitle: '',
                donVi: [],
                truongHoc: [],
                nhomTreMamNon: [],
                namHoc: '',
                hocKy: '',
                list_nam_hoc: constant.LIST_YEARS_FULL,
                list_hoc_ky: constant.LIST_HOC_KY,
                // nhom_tre_doc_lap: constant.NHOM_TRE_DOC_LAP,
                nhom_tre_doc_lap: [],
                baseLink: "/view-excel?path=",
                linkDowndLoad: "",
                loaiHinhTruong: '',
                list_loai_hinh_dao_tao: [{
                        name: "Dân lập",
                        value: "5"
                    },
                    {
                        name: "Tư thục",
                        value: "2"
                    },
                    {
                        name: "Công lập",
                        value: "1"
                    },
                    // {
                    //     name: "GDTX",
                    //     value: "3"
                    // },
                ],
            }
        },
        mounted: function () {
            if (this.thongtin.ma_so == 36) {
                console.log('Xem online office:')
                this.baseLink = 'https://view.officeapps.live.com/op/view.aspx?src='
            }

            if (this.thongtin.role > 3) {
                this.donVi = [this.thongtin.ma_don_vi]
            }
        },
        methods: {
            getNhomCapHoc(capHoc) {
                this.nhom_tre_doc_lap = [];
                try {
                    this.loadingText = 'Lấy danh sách trường học...';
                    let params = {
                        capHoc: capHoc
                    };
                    this.loading = true;
                    console.log("pr ẻty" + JSON.stringify(params));
                    rest_api.get("/internal-api/sme/getNhomCapHocByCapHoc", params, (response) => {
                        console.log("Lấy nhóm ấp học trả về:");
                        console.log(response)
                        if (response.data.code == 200) {
                            this.nhom_tre_doc_lap = response.data.rows;
                            console.log(this.danh_sach_truong_hoc)
                        }
                        this.loading = false;
                    });
                } catch (e) {
                    this.loading = false;
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
                }
            },
            dongModal() {
                this.reset();
                this.$emit('close');
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
            getDataBaoCao(type) {
                //type: 1-xem online, 2 - tải xuống
                try {

                    this.linkExcel = "";
                    this.linkDowndLoad = "";
                    this.taiXuong = false;
                    if (!this.caphoc || this.caphoc == '') {
                        this.thongBao('error', 'Thiếu thông tin cấp học.');
                        return
                    }
                    // if (!this.truongHoc || this.truongHoc.length == 0) {
                    //     if (!this.donVi || this.donVi.length == 0) {
                    //         this.thongBao('error', 'Thiếu thông tin đơn vị');
                    //         return
                    //     }
                    // }
                    // if (this.loaiHinhTruong && this.loaiHinhTruong != '') {
                    //     if (!this.truongHoc || this.truongHoc.length == 0) {
                    //         this.thongBao('error', 'Thiếu thông tin trường học');
                    //         return
                    //     }
                    // }
                    console.log(this.caphoc)
                    // if (this.caphoc == 4 || this.caphoc == 5) {
                    //     if (!this.nhomTreMamNon || this.nhomTreMamNon.length == 0) {
                    //         this.thongBao('error', 'Thiếu thông tin quy mô trường.');
                    //         return
                    //     }
                    // }
                    if (!this.namHoc || this.namHoc == '') {
                        this.thongBao('error', 'Thiếu thông tin năm học.');
                        return
                    }

                    this.loading = true;
                    this.loadingText = 'Đang lấy dữ liệu báo cáo...'
                    let params = {
                        "capHoc": this.caphoc,
                        "namHoc": this.namHoc,
                        "collectionName": this.cln,
                        "maTruongs": this.truongHoc,
                        "maDonVis": this.donVi
                    };
                    if (this.canhocky) {
                        params.hocKy = parseInt(this.hocKy);
                    }
                    if (this.caphoc == 4 || this.caphoc == 5) {
                        params.maNhomCapHocs = this.nhomTreMamNon;
                    }
                    if (this.loaiHinhTruong && this.loaiHinhTruong != '') {
                        params.loaiHinhDaoTao = this.loaiHinhTruong;
                    }
                    this.loading = true;
                    rest_api.post("/csdlgd-report-api/download-excel/get-report-link/", params, (data) => {
                        console.log("thông tin trả về:" + JSON.stringify(data.data));
                        if (data.data.rc == 0) {
                            this.linkDowndLoad = this.thongtin.tenMien + data.data.urlContext;
                            let urlReport = this.baseLink + this.thongtin.tenMien + data.data.urlContext;
                            console.log('urlReport:' + urlReport)
                            this.loadingText = 'Tổng hợp xong.'
                            if (type == 1) {
                                setTimeout(() => {
                                    this.thongBao('success',
                                        'Xem dữ liệu kết quả báo cáo trong tab mới');
                                }, 1000)
                            }
                            setTimeout(() => {
                                this.taiXuong = true;
                                this.loading = false;
                                if (type == 1) {
                                    window.open(urlReport, '_blank');
                                }
                                if (type == 2) {
                                    window.open(this.linkDowndLoad, '_blank');
                                    // this.$confirm('Xác nhận tải xuống dữ liệu?', 'Xuất dữ liệu', {
                                    //     confirmButtonText: 'Xác nhận',
                                    //     cancelButtonText: 'Hủy',
                                    // })
                                    //     .then(_ => {
                                    //     })
                                    //     .catch(_ => {
                                    //     });
                                }
                            }, 2000);
                        } else {
                            this.loading = false;
                            this.thongBao('error',
                                'Có lỗi trong quá trình tổng hợp dữ liệu. Vui lòng thử lại...')
                        }
                    });
                } catch (e) {
                    this.thongBao('error', 'Có lỗi trong quá trình thao tác. Vui lòng thử lại.')
                }
            },
            getTruongHoc() {
                try {
                    this.loadingText = 'Lấy danh sách trường học...';
                    let params = {
                        capHoc: [this.caphoc],
                        maDonVi: this.donVi,
                        maNhomCapHoc: this.nhomTreMamNon
                    };
                    if (this.loaiHinhTruong && this.loaiHinhTruong != '') {
                        params.loaiHinhDaoTao = this.loaiHinhTruong;
                    }
                    // this.loading = true;
                    console.log("pr ẻty" + JSON.stringify(params));
                    rest_api.post("/internal-api/dmTruongHoc/filterSchool", params, (response) => {
                        console.log("Lấy đơn vị trả về:");
                        console.log(response)
                        if (response.data.code == 200) {
                            let dulieu = response.data.rows;
                            let mang = [];
                            if (dulieu && dulieu.length > 0) {
                                for (let i = 0; i < dulieu.length; i++) {
                                    let obj = {
                                        name: dulieu[i].tenTruongHoc + ' - [' + dulieu[i].maTruongHoc + ']',
                                        value: dulieu[i].maTruongHoc
                                    }
                                    mang.push(obj)
                                }
                            }
                            this.danh_sach_truong_hoc = mang;
                            console.log("Danh sách đơn vị: ")
                            console.log(this.danh_sach_truong_hoc)
                        }
                        // this.loading = false;
                    });
                } catch (e) {
                    this.loading = false;
                    this.thongBao('error', 'Vui lòng thử lại sau ít phút...')
                }
            },
            chonDonVi() {
                this.danh_sach_truong_hoc = [];
                this.truongHoc = [];
                this.getTruongHoc()
            },
            reset() {},
            close() {
                this.reset();
                this.$emit('close');
            },
        }
    }

</script>
<style scoped="scoped">
</style>

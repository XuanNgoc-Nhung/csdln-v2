<template>
    <div @mousemove="diChuyenChuot">
        <div class="row page-header">
            <div class="col-sm-6 text-uppercase">
                <a href="#">TRANG CHỦ</a><span><span class="kytu"> &raquo;</span> BÁO CÁO <span class="kytu">
                        &raquo;</span> BÁO CÁO TIÊU CHÍ</span>
            </div>
        </div>
        <div class="row" style="">
            <div style="    display: flex;
    background: white;
    margin: 0 15px;
    border-radius: 5px;
    border-color: #ddd;
    padding: 15px 0;">

                <div class="col-md-2" style="align-self:center">
                    <label for="">Mã tiêu chí</label>
                    <input type="text" v-model="maTieuChi" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-md-2" style="align-self:center">
                    <label for="">Tên tiêu chí</label>
                    <input type="text" v-model="tenTieuChi" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-md-2" style="align-self:center">
                    <label for="">Loại tiêu chí</label>
                    <eselect style="width:100%" v-model="tieu_chi_he_thong" collapseTags
                        no-match-text="Không tìm thấy bản ghi nào" no-data-text="Chọn" :placeholder="'Chọn'" filterable
                        :data="list_doi_tuong" :fields="['name','value']" />
                </div>
                <div class="col-md-2" style="align-self:center">
                    <label for="">Đối tượng <span class="red">*</span></label>
                    <eselect style="width:100%" v-model="doiTuong" ref="doiTuong" collapseTags
                        no-match-text="Không tìm thấy bản ghi nào" no-data-text="Chọn" :placeholder="'Chọn'" filterable
                        :data="list_the_loai" :fields="['name','value']" />
                </div>
                <div class="col-md-2" style="align-self:center">
                    <label for="">Từ khóa</label>
                    <input type="text" v-model="textSreach" class="form-control" placeholder="Nhập...">
                </div>
                <div class="col-md-2" style="align-self:flex-end">
                    <button class="btn btn-success" style="padding:4px 15px;" @click.prevent="checkTruocKhiTim()">Tìm
                        kiếm</button>
                </div>
            </div>
        </div>
        <div class="row" style="margin:0 !important;padding-top:15px;">
            <div class="col-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-12 text-right">
                                <el-button size="mini" type="primary" v-on:click.prevent="AddFaq()">
                                    Thêm mới
                                </el-button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive" style="margin-top:5px">

                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr style="background:#e4ebf5">
                                                <th class="text-center">
                                                    <p>STT</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Mã tiêu chí</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Tên tiêu chí</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Mô tả</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Đối tượng</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Thẻ (Tag)</p>
                                                </th>
                                                <th class="text-center">
                                                    <p>Hành động</p>
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="ds_tieu_chi.length===0">
                                            <tr>
                                                <td class="text-center" colspan="7">
                                                    <p>Không có bản ghi nào</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr v-for="(tt,index) in ds_tieu_chi">
                                                <td class="text-center">
                                                    <p>{{(currentPage-1)*limit + index+1}}</p>
                                                </td>
                                                <td class="text-center">
                                                    <p>{{tt.maTieuChi}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tt.tenTieuChi}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tt.moTa}}</p>
                                                </td>
                                                <td>
                                                    <p>{{tt.doiTuong}}</p>
                                                </td>
                                                <td>
                                                    <span v-for="(tag,j) in tt.tag">
                                                        <p class="btn btn-default" style="padding:3px; margin:0 2px;">
                                                            {{tag}}</p>
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <!-- <a title="Chỉnh sửa" v-on:click="showUpdate(tt)">
                                                        <i class="far fa-edit"></i>
                                                    </a> -->
                                                    <el-tooltip content="Chỉnh sửa" placement="top">
                                                        <el-button plain type="primary" size="mini"
                                                            v-on:click="showUpdate(tt)" icon="el-icon-edit"></el-button>
                                                    </el-tooltip>
                                                    <el-tooltip content="Clone tiêu chí" placement="top">
                                                        <el-button plain type="success" size="mini"
                                                            v-on:click="CloneTieuChi(tt)" icon="el-icon-document-copy">
                                                        </el-button>
                                                    </el-tooltip>
                                                    <el-tooltip content="Nhập liệu" placement="top">
                                                        <el-button plain type="warning" size="mini"
                                                            v-on:click="NhapLieuTieuChi(tt)" icon="el-icon-edit">
                                                        </el-button>
                                                    </el-tooltip>
                                                    <el-tooltip content="Xóa" placement="top">
                                                        <el-button plain type="danger" size="mini"
                                                            v-on:click="deleteUnit(tt)" icon="el-icon-delete">
                                                        </el-button>
                                                    </el-tooltip>
                                                    <!-- <a title="Clone tiêu chí" v-on:click.prevent="CloneTieuChi(tt)">
                                                        <i class="far fa-clone"></i>
                                                    </a>
                                                    <a title="Xóa" v-on:click.prevent="deleteUnit(tt)">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a> -->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Page :total_rows="total_rows" :batdau="trangbatdau" @pageChange="layLai($event)">
                                </Page>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import QueryBuilder from "query-builder-vue";
    import ESelectVue from '../ui/ESelect.vue';
    import rest_api from "../../utils/rest_api";
    import dialog from '../../utils/dialog';
    import Page from "../ui/PagingCustom";

    export default {
        components: {
            QueryBuilder,
            Page,
            'eselect': ESelectVue,
        },
        data() {
            return {
                trangbatdau: false,
                show_add: false,
                show_update: false,
                total_rows: 0,
                start: 0,
                currentPage: 1,
                limit: 25,
                ds_tieu_chi: [],
                list_doi_tuong: [{
                        name: "Tiêu chí hệ thống",
                        value: "1"
                    },
                    {
                        name: "Tiêu chí người dùng",
                        value: "2"
                    },
                ],
                list_the_loai: [{
                        name: "Cán bộ, Giáo viên",
                        value: "GiaoVien"
                    },
                    {
                        name: "Lớp học",
                        value: "LopHoc"
                    },
                    {
                        name: "Kết quả học tập",
                        value: "KQHT"
                    },
                    {
                        name: "Trường học",
                        value: "TruongHoc"
                    },
                    {
                        name: "Học sinh",
                        value: "HocSinh"
                    },
                    {
                        name: "Tiêu chí ngoài",
                        value: "Custom"
                    },
                ],
                searchTerm: "",
                maTieuChi: "",
                tenTieuChi: "",
                idUpdate: "",
                doi_tuong: "",
                doiTuong: "",
                textSreach: "",
                tieu_chi_he_thong: "",
            };
        },
        mounted: function () {
            let demo = [];
            console.log(demo);
        },
        methods: {
            NhapLieuTieuChi(e){
                console.log("Nhập liệu tiêu chí:")
                console.log(e)
                let data = e;
                if(data.doiTuong == 'Tiêu chí ngoài'){

                let uri = 'dynamic-report-external-indicator?';
                if (e.maTieuChi) {
                    uri += '&maTieuChi=' + data.maTieuChi;
                }
                window.open(uri, '_blank');
                }
            },
            diChuyenChuot() {
                // console.log("Di chuyển chuột trong trang");
                let reload = localStorage["ReLoadTrangQuanLyTieuChi"];
                // console.log(reload)
                if (reload == 'true') {
                    this.trangbatdau = !this.trangbatdau;
                }
            },
            deleteUnit(e) {

                dialog.confirmDialog(
                    "Xác nhận xóa tiêu chí đã chọn?",
                    "Đồng ý",
                    () => {
                        this.thongBao('error', "Bạn không đủ quyền thực hiện chức năng này.")
                        return;
                        let params = {
                            namHoc: this.namHoc
                        };
                        rest_api.post("/csdlgd-admin/DataTruong/deleteMoetCode", params, data => {
                            if (data.data.rc == 0) {
                                this
                                    .$alertify
                                    .success("Xóa dữ liệu thành công");
                                this.getListClass();
                            } else {
                                this
                                    .$alertify
                                    .error(data.data.rd)
                            }
                        });
                    }
                );
            },
            showUpdate(e) {
                console.log("click update");
                console.log(e)
                let url = '/manage-criteria-of-dynamic-reports?type=update&id=' + e.id
                window.open(url, '_blank');
            },
            CloneTieuChi(e) {
                console.log("click update");
                console.log(e)
                let url = '/manage-criteria-of-dynamic-reports?type=clone&id=' + e.id
                window.open(url, '_blank');
            },
            getData() {
                if(!this.doiTuong||this.doiTuong==''){
                    this.thongBao('error','Vui lòng bổ sung đối tượng')
                    this.$refs.doiTuong.focus()
                    return;
                }
                const loading = this.$loading({
                    lock: true,
                    text: 'Loading',
                    spinner: 'el-icon-loading',
                    background: 'rgba(0, 0, 0, 0.7)'
                });
                this.total_rows = 0;
                this.ds_tieu_chi = [];
                let url = "/csdlgd-analytic-api/criteria/search?skip=" + this.start +
                    "&limit=" + this.limit
                const params = {
                    "doiTuong": this.doiTuong,
                    "maTieuChi": this.maTieuChi,
                    "tenTieuChi": this.tenTieuChi,
                    "textSreach": this.textSreach,
                };
                if (this.tieu_chi_he_thong == '1') {
                    params.tieuChiHeThong = true;
                } else if (this.tieu_chi_he_thong == '2') {
                    params.tieuChiHeThong = false;
                } else {
                    params.tieuChiHeThong = null;
                }
                console.log("params lấy ds tiêu chí:" + params);
                rest_api.post(url, params, response => {
                    loading.close();
                    console.log("response:")
                    console.error(response)
                    localStorage.setItem('ReLoadTrangQuanLyTieuChi', 'false');
                    if (response.data.rc === 0) {
                        this.total_rows = response.data.total;
                        this.ds_tieu_chi = response.data.rows;
                        if(this.total_rows==0){
                            // this.thongBao('error','Không tìm thấy bản ghi nào.');
                        }
                        else{
                            // this.thongBao("success",'Lấy dữ liệu thành công.')
                        }
                    } else {
                        this.thongBao('error', response.data.rd)
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
            layLai(e) {
                console.log("lấy lại danh sách:" + JSON.stringify(e));
                this.start = e.start;
                this.limit = e.limit;
                this.currentPage = e.currentPage;
                this.getData();
            },
            checkTruocKhiTim() {
                this.trangbatdau = !this.trangbatdau;
            },
            OnSuccess() {
                this.show_add = false;
                this.show_update = false;
                // this.tuKhoa = e;
                this.checkTruocKhiTim()
            },
            AddFaq() {
                window.open('/manage-criteria-of-dynamic-reports?type=add', '_blank');
            },
        },
    };

</script>

<style>

</style>

<template>

    <div id="thongtin_nhanduoc" style="display:none" ref="thongtin_nhanduoc" ap class="modal fade">
        <div class="modal-dialog" style="width: 60%;">
            <div class="modal-content">
                <form @submit.prevent="themToThonSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"
                            v-on:click="closeinfo()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Chi tiết
                        </h4>
                    </div>
                    <div v-if="type==3||type==4" class="modal-body clearfix">
                        <div class="text-center" v-if="tenBang==1">
                            <div v-if="ChiTietDuLieu.Status==1">
                                <p style="font-size:24px;">Thành công</p>
                            </div>
                            <div v-else="v-else">
                                <p style="font-size:24px;">Thất bại</p>
                            </div>
                        </div>
                        <div class="text-center" v-if="tenBang==2">
                            <div class="table-responsive row_tp" style="height:400px;">
                                <table v-if="loaiDuLieu==8" class="table table-striped table-bordered table-hover"
                                   >
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã lớp học</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ChiTietDuLieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có dữ liệu phù hợp</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(tt,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                <div v-if="tt.MaLopHoc">
                                                    {{tt.MaLopHoc}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                            <td>{{tt.Message}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="loaiDuLieu!=8">
                                    <div>
                                        <textarea class="language-json myTextArea"
                                            style="width:100%; margin:0 auto;height:50vh" :value="duLieuTextArea"
                                            id="myTextArea" cols="50" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center" v-if="tenBang==3||tenBang==4">
                            <div class="table-responsives row_tp" style="height:400px;">
                                <table v-if="loaiDuLieu==8" class="table table-striped table-bordered table-hover"
                                    style="font-size:12px; ">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã học sinh</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ChiTietDuLieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có dữ liệu phù hợp</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(tt,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                <div v-if="tt.MaHocSinh">
                                                    {{tt.MaHocSinh}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                            <td>{{tt.Message}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="loaiDuLieu!=8">
                                    <div>
                                        <textarea class="language-json myTextArea"
                                            style="width:100%; margin:0 auto;height:50vh" :value="duLieuTextArea"
                                            id="myTextArea" cols="50" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center" v-if="tenBang==7||tenBang==8">
                            <div class="table-responsive row_tp" style="height:400px;">
                                <table class="table table-striped table-bordered table-hover" style="font-size:12px; ">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã học sinh</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ChiTietDuLieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có bản ghi lỗi nào</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(tt,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                <div v-if="tt.MaHocSinh">
                                                    {{tt.MaHocSinh}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                            <td>{{tt.Message}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="text-center" v-if="tenBang==5||tenBang==6">
                            <div class="table-responsive row_tp" style="height:400px;">
                                <table v-if="loaiDuLieu==8" class="table table-striped table-bordered table-hover"
                                    style="font-size:12px; ">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã cán bộ</th>
                                            <th class="text-center">Tên cán bộ</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ChiTietDuLieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có dữ liệu phù hợp</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(tt,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                <div v-if="tt.MaCanBo">
                                                    {{tt.MaCanBo}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td class="text-center">
                                                <div v-if="tt.TenCanBo">
                                                    {{tt.TenCanBo}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                            <td>{{tt.Message}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="loaiDuLieu!=8">
                                    <div>
                                        <textarea class="language-json myTextArea"
                                            style="width:100%; margin:0 auto;height:50vh" :value="duLieuTextArea"
                                            id="myTextArea" cols="50" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center" v-if="tenBang==9">
                            <div class="table-responsive row_tp" style="height:400px;">
                                <table v-if="loaiDuLieu==8" class="table table-striped table-bordered table-hover"
                                    style="font-size:12px; ">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã điểm trường</th>
                                            <th class="text-center">Tên điểm trường</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ChiTietDuLieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có dữ liệu phù hợp</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(tt,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                <div v-if="tt.MaDiemTruong">
                                                    {{tt.MaDiemTruong}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>
                                                <div v-if="tt.TenDiemTruong">
                                                    {{tt.TenDiemTruong}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                            <td>{{tt.Message}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="loaiDuLieu!=8">
                                    <div>
                                        <textarea class="language-json myTextArea"
                                            style="width:100%; margin:0 auto;height:50vh" :value="duLieuTextArea"
                                            id="myTextArea" cols="50" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center" v-if="tenBang==10">
                            <div class="table-responsive row_tp" style="height:400px;">
                                <table v-if="loaiDuLieu==8" class="table table-striped table-bordered table-hover"
                                    style="font-size:12px; ">
                                    <thead>
                                        <tr>
                                            <th class="text-center">STT</th>
                                            <th class="text-center">Mã thí sinh</th>
                                            <th class="text-center">Tên thí sinh</th>
                                            <th class="text-center">Trạng thái</th>
                                            <th class="text-center">Mô tả</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="ChiTietDuLieu.length===0">
                                        <tr>
                                            <td class="text-center" colspan="7">Không có dữ liệu phù hợp</td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else="v-else">
                                        <tr v-for="(tt,index) in ChiTietDuLieu">
                                            <td class="text-center">{{index+1}}</td>
                                            <td class="text-center">
                                                <div v-if="tt.MaThiSinhTuDo">
                                                    {{tt.MaThiSinhTuDo}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>
                                                <div v-if="tt.TenThiSinh">
                                                    {{tt.TenThiSinh}}
                                                </div>
                                                <div v-else="v-else">[Trống]</div>
                                            </td>
                                            <td>{{parseInt(tt.Status)== 1 ? 'Thành công' : 'Thất bại'}}</td>
                                            <td>{{tt.Message}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div v-if="loaiDuLieu!=8">
                                    <div>
                                        <textarea class="language-json myTextArea"
                                            style="width:100%; margin:0 auto;height:50vh" :value="duLieuTextArea"
                                            id="myTextArea" cols="50" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="type==1||type==2">
                        <textarea class="language-json myTextArea" style="width:100%; margin:0 auto;height:50vh"
                            id="myTextArea" :value="duLieuTextArea" cols="50" rows="10"></textarea>
                    </div>
                    <div class="modal-footer clearfix">
                        <el-button plain size="mini" type="default" data-dismiss="modal">Đóng
                        </el-button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</template>

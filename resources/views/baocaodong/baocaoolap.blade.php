@extends("layout.app") @section("cssheader")
<style>
    body,
    html {
        height: 100%;
        width: 100%;
        overflow: hidden;
    }
    table {
        height: 100%;
        width: 100%;
        table-layout: static;
        border-collapse: collapse;
    }
    iframe {
        float: left;
        height: 100%;
        width: 100%;
    }
    .header {
        border-bottom: 1px solid #000;
    }
    .content {
        height: 100%;
    }
</style>
@endsection @section("content")
<div class="row">
    <div class="col-sm-6">
        <h3 class="text-uppercase">báo cáo động</h3>
    </div>
    <div class="col-sm-6 pull-right">
    
<button
    type="button"
    class="btn btn-info"
    data-toggle="modal"
    style="float:right; margin-top:15px;"
    data-target="#exampleModal">
   Hướng dẫn
</button></div>
</div>
<!-- Button trigger modal -->

<!-- Modal -->
<div
    class="modal fade"
    id="exampleModal"
    tabindex="-1"
    role="dialog"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true">
        <div class="modal-dialog" style="width:70%">
            <div class="modal-content">
                <form @submit.prevent="themDantocSubmit">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                            &times;
                        </button>
                        <h4 class="modal-title text-uppercase">Hướng dẫn</h4>
                    </div>
                    <div class="modal-body clearfix">
                        <div>
                            <p><span><i style="font-size:18px;"><b>Mục đích:</b></i> Chức năng này cho phép xem báo cáo theo tùy theo các tiêu chí người dùng lựa chọn. Chức năng có thể lưu được các template đã từng được xây dựng trước đó để thuận tiện cho việc kế thừa hoặc chỉnh sửa hoặc làm mới template.</span></p>
                        </div>
                        <p><span><b>Bước 1.</b></span> Chọn Cubes cần xem báo cáo (ví dụ: chọn báo cáo theo học sinh).</p>
                        <p><span><b>Bước 2.</b></span> Chọn các tiêu chí Measures và Dimensions bằng cách click chuột vào tiêu chí lựa chọn, hoặc kéo thả sang phân vùng tương ứng:</p>
                        <div style="margin-left:25px;">
                            <ul>
                                <li><p>Tại option Dimensions, người dùng có thể tạo bảng thống kê các tiêu chí theo hàng, cột tương ứng.</p></li>
                                <li><p>Đổi định dạng báo cáo dạng bảng theo option.</p></li>
                                <li><p>Đổi định dạng báo cáo dạng biểu đồ theo option.</p></li>
                            </ul>
                        </div>
                        <p><span><b>Bước 3.</b></span> Người dùng có thể lưu báo cáo, share báo cáo dưới dạng công khai hoặc cho đối tượng cụ thể</p>
                    </div>
                    <div class="modal-footer clearfix">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </form>
            </div>
        </div>
</div>
    <div id="app" class="row" style="height:500px;">
        <iframe
            src="https://moetdb-olap.dtsgroup.com.vn/index.html?DEFAULT_VIEW_STATE=open&dimension_prefetch=false#query/open//homes/home:admin/sample_reports/01-test-template.saiku"
            scrolling="yes"
            frameborder="0"></iframe>
    </div>
<script src="{{asset('js/bao-cao-cho-bo.js')}}"></script>

@endsection

@section("js_location")

@endsection
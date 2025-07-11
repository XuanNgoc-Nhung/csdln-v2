@extends("layout.app")
@section("content")
<div class="row" style="margin-top:30px;">
    <div class="col-md-12 text-center">
        <p>Đang chuyển hướng...</p>
    </div>
</div>
@endsection
@section("js_location")
<script !src="">
    window.userInfo = '{!! json_encode(get_user_info("common_info")) !!}';
    let thongtin = window.userInfo;
    thongtin = JSON.parse(thongtin);
    if (thongtin.ma_so == 45) {
        window.location.href =
            "https://sso-edu.viettel.vn/api/Core/OAuth/API/authorize?groupId=5c4811a262aa4ad14d3024b2&state=https://smas.edu.vn&redirect=1";
    }if (thongtin.ma_so == 83) {
        window.location.href =
            "https://sso-edu.viettel.vn/api/Core/OAuth/API/authorize?groupId=5c4811a262aa4ad14d3024b2&state=http://qlnt.sgdbentre.edu.vn/&redirect=1";
    }

</script>
@endsection
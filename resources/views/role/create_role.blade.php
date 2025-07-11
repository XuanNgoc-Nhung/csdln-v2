@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h3 class="page-header">Danh sách tài khoản hệ thống</h3>
        </div>
    </div>

    <div id="app" class="row">
        <create-role :role_create="'{!! check_permission_action("/system-manager","create") !!}'"
                     :role_update="'{!! check_permission_action("/system-manager","update") !!}'"
                     :role_grand_permission="'{!! check_permission_action("/system-manager","grant_permission") !!}'"
                     :role_ban="'{!! check_permission_action("/system-manager","ban") !!}'">
        </create-role>
    </div>

    <script src="{{asset('js/create_role.js')}}"></script>
@endsection

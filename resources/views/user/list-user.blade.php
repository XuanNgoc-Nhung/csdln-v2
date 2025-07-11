@extends("layout.app")
@section("content")
    <div class="row">
        <div>
            <h1 class="page-header">Danh sách người dùng</h1>
        </div>
    </div>
        <div id="app" class="row">
            <list-user
                    :role_detail="'{!! check_permission_action("/list-users","detail") !!}'"
                    :role_ban="'{!! check_permission_action("/list-users","ban") !!}'"
                    :role_update="'{!! check_permission_action("/list-users","update") !!}'"
                    :role_delete="'{!! check_permission_action("/list-users","delete") !!}'"
                    :role_accept="'{!! check_permission_action("/list-users","accept") !!}'">
            </list-user>
        </div>
    <script src="{{asset('js/list_user.js')}}"></script>
@endsection
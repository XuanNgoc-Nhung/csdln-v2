@extends("layout.app")
@section("header")
<style>

@media only screen and (max-width: 1192) {
    .inputhemtruong{
        width:75px;
    }
}
</style>
@endsection
@section("content")
    <div id="app" class="row">
        <dm-truong-hoc></dm-truong-hoc>
    </div>
@endsection
@section("js_location")
    <script src="{{asset('js/dm-truong-hoc.js')}}"></script>
@endsection


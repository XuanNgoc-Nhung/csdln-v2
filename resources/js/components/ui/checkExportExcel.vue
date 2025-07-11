<template>

    <div id="modal_export_limit" ref="modal_export_limit" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title">Xuất dữ liệu Excel</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Từ trang (<span class="required">*</span>)</label>
                        <small>(VD: 1)</small>
                        <input ref="from" class="form-control" v-model="from"/>
                        <em class="required">{{errors.from}}</em>
                    </div>
                    <div class="form-group">
                        <label for="">Đến trang (<span class="required">*</span>)</label>
                        <!-- <small>(VD: 100, xuất tối đa {{20000/so_ban_ghi_1_trang}} trang 1 lần. Mặc định: 5000 bản ghi/trang)</small> -->
                        <small>(VD: 100, <b>Lưu ý:</b> Xuất tối đa 20.000 bản ghi trong 1 lần. Mặc định: 5000 bản ghi/trang)</small>
                        <input ref="to" class="form-control" v-model="to"/>
                        <em class="required">{{errors.to}}</em>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" v-on:click="onSubmit()" class="btn btn-primary">
                       Xuất dữ liệu
                    </button>
                </div>

            </div>

        </div>
    </div>

</template>

<script>

    import {mapMutations, mapState} from 'vuex';
    // import m_utils from "../../../m_utils";
    import m_utils from "../../utils/m_utils";
    export default {

        props: ['show', 'total', 'limit','rowsview'],

        watch: {
            rowsview: function(newVal,oldVal){
                console.log("Số bản ghi của 1 trang:" + newVal);
                this.so_ban_ghi_1_trang = newVal;
            },
            show: function (newVal, oldVal) {
                console.log("show thay đổi");
                if(newVal){
                    if(this.limit) {
                        this.limitState = this.limit;
                        this.to = this.limit;
                    }
                    $(this.$refs.modal_export_limit).modal();
                }else{
                    $(this.$refs.modal_export_limit).modal('hide');
                }
            },

        },

        data() {
            return {
                gioi_han:20000,
                from: 1,
                to: 100,
                limitState: 100,
                so_ban_ghi_1_trang: 25,
                errors: {
                    from: "",
                    to: ""
                }
            }
        },

        mounted: function () {
            console.log("Xuất giới hạn excel");
            $(this.$refs.modal_export_limit).on("hidden.bs.modal", this.close);
        },

        methods: {
            
            reset() {
                this.from = 1;
                this.to = 100;
                this.errors = {
                    from: "",
                    to: "",
                };
            },

            onSubmit() {

                this.errors = {
                    from: "",
                    to: "",
                };
                
                if (!m_utils.checkString(this.from)) {
                    this.errors.from = "Vui lòng nhập trang bắt đầu";
                    this.$refs.from.focus();
                    return;
                }
                if (parseInt(this.from) < 1) {
                    this.errors.from = "Trang bắt đầu phải lớn hơn 0";
                    this.$refs.from.focus();
                    return;
                }
                if (!m_utils.checkString(this.to)) {
                    this.errors.from = "Vui lòng nhập trang kết thúc";
                    this.$refs.from.focus();
                    return;
                }
                if ((parseInt(this.to) - parseInt(this.from)) > this.gioi_han/this.so_ban_ghi_1_trang) {
                    this.errors.to = "Xuất tối đa được "+this.gioi_han/this.so_ban_ghi_1_trang+" trang 1 lần xuất";
                    this.$refs.to.focus();
                    return;
                }
                if (parseInt(this.to) < parseInt(this.from)) {
                    this.errors.to = "Trang kết thúc phải bằng hoặc lớn hơn trang bắt đầu";
                    this.$refs.to.focus();
                    return;
                }
                this.$emit('submit', {from: this.from, to: this.to});
                this.close();

            },
            close() {
                this.reset();
                this.$emit('close');
            },

        }

    }

</script>


<style scoped>

    .required {
        font-size: 14px;
        color: #DC0101
    }

</style>
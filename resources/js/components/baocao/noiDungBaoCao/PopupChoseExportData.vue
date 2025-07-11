<template>

    <div id="modal_export_limit" ref="modal_export_limit" class="modal fade">
        <div class="modal-dialog" style="width:60%">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h3 class="modal-title text-uppercase">Chọn hình thức Xem trước file</h3>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row text-center">
                            <!-- <button class="btn btn-info" @click.prevent="xemExcel">Xem dưới dạng Excel 1</button> -->
                            <button class="btn btn-primary" @click.prevent="xemExcel2">Xem dưới dạng Excel</button>
                            <button class="btn btn-success" @click.prevent="xemPdf">Xem dưới dạng PDF</button>
                            <button class="btn btn-info" @click.prevent="taiXuong">Tải xuống</button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" v-on:click="close" class="btn btn-default">
                      Đóng
                    </button>
                </div>
            </div>

        </div>
    </div>

</template>

<script>

    import {mapMutations, mapState} from 'vuex';
    import dialog from '../../../utils/dialog';
    

    export default {

        props: ['show', 'total', 'limit'],

        watch: {
            show: function (newVal, oldVal) {
                if(newVal){
                    $(this.$refs.modal_export_limit).modal();
                }else{
                    $(this.$refs.modal_export_limit).modal('hide');
                }
            },

        },

        data() {
            return {
            }
        },

        mounted: function () {
            $(this.$refs.modal_export_limit).on("hidden.bs.modal", this.close);
        },

        methods: {
            xemExcel(){
                this.$emit('getExcel')
            },
            xemExcel2(){
                this.$emit('getExcel2')
            },
            xemPdf(){
                this.$emit('getPfd')
            },
            taiXuong(){
                this.$emit('taiXuong')
            },
            close() {
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

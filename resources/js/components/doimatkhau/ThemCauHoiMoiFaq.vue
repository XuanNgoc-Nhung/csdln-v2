<template>
    <div>
        <div id="modal_faq_add" ref="modal_faq_add" class="modal fade">
            <div class="modal-dialog modal-dialog-fullscreen" style="">
                <div class="modal-content modal-content-fullscreen" style="">
                    <div class="modal-header modal-header-fullscreen" style="">
                        <h4>Thêm mới câu hỏi</h4>
                    </div>
                    <div class="modal-body modal-body-fullscreen" style="padding-bottom:200px;">
                        <div class="row">
                            <div class="col-md-12">
                                <label>Nội dung câu hỏi <span style="color:#DC0101"> *</span></label>
                                <input type="text" v-model="cauHoi" class="form-control" placeholder="Nhập...">
                            </div>
                            <div class="col-md-12">
                                <label>Nội dung câu trả lời</label>
                                <pre v-html="traLoi"></pre>
                            </div>
                            <hr/>
                            <div class="col-md-12">
                                <ckeditor v-model="traLoi" :config="editorConfig" :editor-url="editorUrl" ></ckeditor>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer modal-footer-fullscreen" style="">
                        <button type="button" @click.prevent="ThemMoi()" class="btn btn-primary">Thêm
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end div -->
    </div>
</template>
<script>
    import Vue from 'vue';
    import CKEditor from 'ckeditor4-vue';
    import utils from '../../utils'
    import rest_api from '../../utils/rest_api';
    import VueAlertify from "vue-alertify";
    Vue.use(VueAlertify, {
        notifier: {
            delay: 5,
            position: 'top-right'
        },
        glossary: {
            title: 'Thông báo',
            ok: 'Đồng ý',
            cancel: 'Hủy'
        }
    });
    Vue.use(CKEditor);
    export default {
        components: {
            "ckeditor": CKEditor,
        },
        data() {
            return {
                traLoi: '<p>Nhập nội dung câu trả lời </p>',
                cauHoi:"",
                thongtin: {},
                editorUrl: "https://cdn.ckeditor.com/4.14.1/full-all/ckeditor.js",
                editorConfig: {
                    toolbarGroups : [
                        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
                        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
                        { name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
                        { name: 'forms', groups: [ 'forms' ] },
                        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
                        { name: 'links', groups: [ 'links' ] },
                        { name: 'insert', groups: [ 'insert' ] },
                        { name: 'styles', groups: [ 'styles' ] },
                        { name: 'colors', groups: [ 'colors' ] },
                        { name: 'tools', groups: [ 'tools' ] },
                        { name: 'others', groups: [ 'others' ] },
                        { name: 'about', groups: [ 'about' ] }
                    ],
                    removeButtons: 'NewPage,Print,Save,Templates,Replace,Find,SelectAll,Scayt,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Anchor,Flash,Smiley,PageBreak,ShowBlocks,About,Language,Iframe'
                }
            };
        },

        watch: {},
        mounted: function () {
            this.thongtin = JSON.parse(window.userInfo);
            $("#modal_faq_add").modal();
            $(this.$refs.modal_faq_add).on("hidden.bs.modal", this.close);
        },
        components: {},
        methods: {
            ThemMoi(){
                if(!this.cauHoi){
                            this.$alertify.error("Thiếu nội dung câu hỏi");
                            return
                }
                if(!this.traLoi){
                            this.$alertify.error("Thiếu nội dung câu trả lời");
                            return
                }
                utils.confirmDialog("Xác nhận thêm mới câu hỏi", "Đồng ý", () => {
                    let params = {
                        cauHoi: this.cauHoi,
                        traLoi: this.traLoi,
                    };
                    rest_api.post("/csdlgd-admin/CauHoi/create", params, data => {
                        if (data.data.rc == 0) {
                            this.$alertify.success("Thêm thành công");
                            this.$emit('success');
                        } else {
                            utils.showDialog("Thất bại", data.data.rd, null, () => {});
                        }
                    });
                })
            },
            close() {
                this.$emit('close')
            }
        }
    }

</script>
<style scoped="scoped">

    .faqHeader {
        font-size: 27px;
        margin: 20px;
    }

    .panel-heading [data-toggle="collapse"]:after {
        font-family: 'Glyphicons Halflings';
        /* "play" icon */
        float: right;
        color: #F58723;
        font-size: 18px;
        line-height: 22px;
        /* rotate "play" icon from > (right arrow) to down arrow */
        -webkit-transform: rotate(-90deg);
        -moz-transform: rotate(-90deg);
        -ms-transform: rotate(-90deg);
        -o-transform: rotate(-90deg);
        transform: rotate(-90deg);
    }

    .panel-heading [data-toggle="collapse"].collapsed:after {
        /* rotate "play" icon from > (right arrow) to ^ (up arrow) */
        -webkit-transform: rotate(90deg);
        -moz-transform: rotate(90deg);
        -ms-transform: rotate(90deg);
        -o-transform: rotate(90deg);
        transform: rotate(90deg);
        color: #454444;
    }

</style>

<template>
    <div>
        <el-dialog fullscreen :close-on-click-modal="false" @close="dongModal" :close-on-press-escape="false" top="5vh"
            width="50%" title="Hướng dẫn sử dụng" :visible.sync="hien_thi_huon_dan">
            <div class="content-huong-dan">
                <div class="content-file">
                    <div id="iframe-wrapper" style="position:relative">
                        <div id="iframe-wrapper" :style="iframe.wrapperStyle">
                            <iframe :src="iframe.src" :style="iframe.style" :height="iframe.style.height"
                                :width="iframe.style.width" type="application/pdf" frameborder="0"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            <span slot="footer" class="dialog-footer">
                <el-button size="mini" type="primary" @click.prevent="taiXuong">Tải xuống</el-button>
                <el-button size="mini" type="danger" @click.prevent="dongModal">Đóng</el-button>
            </span>
        </el-dialog>
    </div>

</template>

<script>


    export default {
        props: ['show'],
        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    this.hien_thi_huon_dan = true;
                } else {
                    this.hien_thi_huon_dan = false;
                }
            },
        },
        data() {
            return {
                hien_thi_huon_dan: false,
                link:'https://dongbo.csdl.edu.vn/exportExcel/templateImport/05052021_HDSD_Edc_TRG_v2.0_Update_y_te.docx',
                iframe: {
                    src: "/view-excel?path=https://dongbo.csdl.edu.vn/exportExcel/templateImport/05052021_HDSD_Edc_TRG_v2.0_Update_y_te.docx",
                    style: null,
                    wrapperStyle: null,
                }
            }
        },

        mounted: function () {

            this.iframe.style = {
                position: 'absolute',
                width: 100+'%',
                height: window.innerHeight,
                top: 0 + "px",
                left: 0 + "px",
            }
            this.iframe.wrapperStyle = {
                overflow: 'hidden',
                height: 0 + "px",
                width: 0 + "px",
            }
        },

        methods: {
            taiXuong(){

                window.open(this.link, '_blank');
            },
            dongModal() {
                this.hien_thi_huon_dan = false;
                this.$emit('close')
            },
            close() {
                console.log("đóng");
                this.$emit('close')
            }
        }
    }

</script>
<style scoped>
    .content-huong-dan {
        border: 1px solid red;
        height: calc(100vh - 180px);
        overflow: scroll;

    }

</style>

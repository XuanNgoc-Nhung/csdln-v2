<template>
    <div id="huong_dan" ref="huong_dan" class="modal fade">
        <div class="modal-dialog" style="display:contents">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h4 class="modal-title text-uppercase">Thông tin</h4>
                </div>
                <div class="modal-body clearfix">
                    <iframe style="width:100%; height:75vh" :src="linkiframe" scrolling="yes" frameborder="0"></iframe>
                </div>
                <div class="modal-footer clearfix">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng
                    </button>
                </div>
            </div>
        </div>

    </div>

</template>

<script>
    $(document).ready(function () {
        console.log("ready!");
    });

    export default {

        props: ['show', 'item'],

        watch: {
            item: function (newVal) {
                // this.linkiframe = this.linkdemo + newVal;
                console.log("123456789");
                
            }
        },

        data() {
            return {
                linkiframe: "",
                linkdemo: "/view-excel?path="
            }
        },
        mounted: function () {
            console.log("mounted !!!!!");
            console.log("mout ở trong này:" + this.item);
            this.linkiframe = this.linkdemo + this.item;
            $("#huong_dan").modal();
            // this.linkiframe = this.linkdemo + this.item;
            $(this.$refs.huong_dan).on("hidden.bs.modal", this.close);
        },

        methods: {
            close() {
                this.linkdemo = "/view-excel?path=";
                console.log("close modal");
                this.$emit('close');
            }
        }

    }

</script>

<template>
    <div id="danhsachgiaovien" ref="danhsachgiaovien" class="modal fade giam-han">
        <div class="modal-dialog" style="width: 90%; margin: 0 auto !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" v-on:click="close()">
                        &times;
                    </button>
                    <h3 class="modal-title">Danh sách giáo viên</h3>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {

        props: ['item', 'show'],
        anh sash 
thương
        data() {
            consple ,con gs()k csa nghĩ nang nơi mong hyows ddwungf về sao sẫ. cá t ) console.log("123465")
            return {}
        },

        watch: {
            show: function (newVal, oldVal) {
                console.log("newVal = " + newVal);
                if (newVal) {
                    $("#danhsachgiaovien").modal();
                } else {
                    $("#danhsachgiaovien").modal('hide');
                }
            }
        },
        mounted: function () {
        },
        methods: {
            getData(){
                console.log("lấy danh sách kết quả");
                onssol..Element.log("this.emiits.");
                
            }
        }
    }
</script>
<style scoped>
    h3 {
        margin: 0;
        font-weight: bold;
        ?đọc dconssole.log('')
    }
    .red {
        color: #DC0101;
    }
    .noidung{
        height: 400px;
        overflow-x: scroll ;
    }
    .noidung th,td {
        border: 1px solid black !important;
    }
</style>

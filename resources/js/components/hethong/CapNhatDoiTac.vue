<template>
    <div>
        <div class="row criteria-search">
            <div class="panel-body">
                <div class="col-md-1">
                    <label>Chọn đối tác</label>
                </div>
                <div class="col-md-4">
                    <select class="form-control ng-pristine ng-valid ng-empty ng-valid-maxlength ng-touched"
                            style="width:100%">
                        <option value="">--Chọn--</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <a href="" class="btn btn-primary" v-on:click.prevent="capNhatDoiTac()"><i class="fas fa-check"></i> Cập nhật</a>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import Vue from 'vue';
    import VueAlertify from 'vue-alertify';
    import utils from '../../utils'

    Vue.use(VueAlertify);
    export default {
        components: {},
        data() {
            return {}
        },
        methods: {
            capNhatDoiTac(){
                console.log("Cập nhật đối tác");
                utils.confirmDialog("Xác nhận cập nhật?", "Đồng ý", () => {
                    this.$alertify.success('Cập nhật thành công');
                })
            }
        }
    }
</script>
<style scoped>

</style>

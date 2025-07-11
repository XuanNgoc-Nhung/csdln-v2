<template>
    <div>
        <!-- Form -->
        <el-dialog title="Shipping address" @close="dongModal" :visible.sync="dialogFormVisible">
            <el-form :model="form">
                <el-form-item label="Promotion name" :label-width="formLabelWidth">
                    <el-input clearable v-model="form.name" autocomplete="off"></el-input>
                </el-form-item>
                <el-form-item label="Zones" :label-width="formLabelWidth">
                    <el-select v-model="form.region" placeholder="Please select a zone">
                        <el-option label="Zone No.1" value="shanghai"></el-option>
                        <el-option label="Zone No.2" value="beijing"></el-option>
                    </el-select>
                </el-form-item>
            </el-form>
            <span slot="footer" class="dialog-footer">
                <el-button plain @click="dongModal">Cancel</el-button>
                <el-button plain type="primary" @click="dialogFormVisible = false">Confirm</el-button>
            </span>
        </el-dialog>
    </div>
</template>
<script>
    export default {
        props: ['item', 'show'],
        components: {},
        watch: {},
        data() {
            return {
                dialogFormVisible: true,
                form: {
                    name: '',
                    region: '',
                    date1: '',
                    date2: '',
                    delivery: false,
                    type: [],
                    resource: '',
                    desc: ''
                },
                formLabelWidth: '120px'
            }
        },
        mounted: function () {},
        methods: {
            dongModal() {
                console.log("Đóng modal");
                this.$confirm(
                        'Các thông tin vừa nhập sẽ bị mất khi đóng trang. Thầy cô có muốn tiếp tục chỉnh sửa, kiểm tra và lưu lại thông tin đã nhập?',
                        'Thông báo', {
                            confirmButtonText: 'Rời khỏi trang',
                            cancelButtonText: 'Tiếp tục chỉnh sửa',
                            confirmButtonClass: 'el-button--danger',
                            closeOnClickModal: false,
                        })
                    .then(_ => {
                        this.dialogFormVisible = false;
                    })
                    .catch(_ => {});
            },
        }
    }

</script>
<style scoped>
</style>

<template>
    <div>
        <el-row :gutter="24" class="reset">
            <el-col :span="24" class="reset" style="display:flex;">
                <p style="padding-right:5px;">Hiển thị </p>
                <el-select style="width:100px !important" v-model="soLuong" @change="onSizeChange" placeholder="Chọn">
                    <el-option v-for="item in options" :key="item.value" :label="item.label" :value="item.value">
                    </el-option>
                </el-select>
                <p style="padding-left:5px;">bản ghi/trang.</p>
            </el-col>
        </el-row>
    </div>
</template>

<script>
    import number_util from '../../utils/number_utils';
    export default {
        props: [
        ],

        watch: {
        },

        data() {
            return {
                soLuong:25,
                options: [{
                        value: 25,
                        label: '25'
                    },
                    {
                        value: 50,
                        label: '50'
                    },
                    {
                        value: 100,
                        label: '100'
                    },
                    {
                        value: 200,
                        label: '200'
                    },
                    {
                        value: 500,
                        label: '500'
                    },
                    {
                        value: 1000,
                        label: '1000'
                    },
                ],
                currentPage:1,
                start: 0,
                to: 25
            }
        },

        mounted() {
        },

        methods: {
            onSizeChange() {
                console.log("Thay đổi kích thước hiển thị")
                this.currentPage = 1;
                let ret = {
                    soluong:this.soLuong
                };
                this.$emit("chonXongSoLuong", ret);
            },
        }

    }

</script>

<style scoped>
p{
    padding-top:5px;
}
.reset{
    margin:  0 !important;
    padding:  0 !important;
}
</style>

<template>
    <div>
        <el-dialog title="Xuất dữ liệu" @close="dongHienThi" :close-on-click-modal="false" :close-on-press-escape="false" :visible.sync="hien_thi">
            <div class="form-group">
                <label for="">Từ trang (<span class="required">*</span>)</label>
                <small>(VD: 1)</small>
                <input v-on:keyup.enter="onSubmit" ref="from" class="form-control" v-model="from" />
                <em class="required">{{errors.from}}</em>
            </div>
            <div class="form-group">
                <label for="">Đến trang (<span class="required">*</span>)</label>
                <small>(VD: 100, xuất tối đa {{50000/so_ban_ghi_1_trang}} trang 1 lần)</small>
                <input v-on:keyup.enter="onSubmit" ref="to" class="form-control" v-model="to" />
                <em class="required">{{errors.to}}</em>
            </div>

            <span slot="footer" class="dialog-footer">

                <el-button type="default" @click="dongHienThi" size="mini">Đóng</el-button>
                <el-button type="success" size="mini" v-on:click="onSubmit()">
                    Hủy
                </el-button>
            </span>
        </el-dialog>
    </div>

</template>

<script>
    import {
        mapMutations,
        mapState
    } from 'vuex';
    // import m_utils from "../../../m_utils";
    import m_utils from "../../utils/m_utils";
    export default {

        props: ['show', 'total', 'limit', 'rowsview'],

        watch: {
            rowsview: function (newVal, oldVal) {
                console.log("Số bản ghi của 1 trang:" + newVal);
                this.so_ban_ghi_1_trang = newVal;
            },
            show: function (newVal, oldVal) {
                if (newVal) {
                    this.hien_thi = true;
                    if (this.limit) {
                        this.limitState = this.limit;
                        this.to = this.limit;
                    }
                } else {
                    this.hien_thi = false;
                }
            },

        },

        data() {
            return {
                hien_thi: false,
                gioi_han: 50000,
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
        },

        methods: {
            dongHienThi() {
                // this.$confirm(
                //         'Các thông tin vừa nhập sẽ bị mất khi đóng trang. Thầy cô có muốn tiếp tục chỉnh sửa, kiểm tra và lưu lại thông tin đã nhập?',
                //         'Thông báo', {
                //             confirmButtonText: 'Rời khỏi trang',
                //             cancelButtonText: 'Tiếp tục chỉnh sửa',
                //             confirmButtonClass: 'el-button--danger'
                //         })
                //     .then(_ => {
                        this.hien_thi = false;
                        this.close();
                    // })
                    // .catch(_ => {});
            },
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
                    this.errors.to = "Vui lòng nhập trang kết thúc";
                    this.$refs.to.focus();
                    return;
                }
                if ((parseInt(this.to) - parseInt(this.from)) >= this.gioi_han / this.so_ban_ghi_1_trang) {
                    this.errors.to = "Xuất tối đa được " + this.gioi_han / this.so_ban_ghi_1_trang +
                        " trang 1 lần xuất";
                    this.$refs.to.focus();
                    return;
                }
                if (parseInt(this.to) < parseInt(this.from)) {
                    this.errors.to = "Trang kết thúc phải bằng hoặc lớn hơn trang bắt đầu";
                    this.$refs.to.focus();
                    return;
                }
                this.$emit('submit', {
                    from: this.from,
                    to: this.to
                });
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

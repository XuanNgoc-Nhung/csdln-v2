<template>
    <div class="password-input" style="width: 100%;display: inline-block">
        <el-input
                :type="isPasswordVisible ? 'text' : 'password'"
                v-model="password"
                placeholder="Nhập..."
                style="width: 100%"
                class="password-field"
                @blur="emitChange"
        ></el-input>

        <div class="icon">
            <i
                    :class="isPasswordVisible ? 'el-input__icon far fa-eye' : 'el-input__icon far fa-eye-slash'"
                    @click="handleTogglePassword"
                    class="toggle-password"
            ></i>

            <i
                    v-if="password"
                    class="clear-icon el-input__icon el-icon-circle-close el-input__clear"
                    @click="handleClear"
            ></i>
        </div>

    </div>
</template>

<script>
export default {
    props: {
        value: {
            type: String,
            required: true,
        },
    },
    data() {
        return {
            password: this.value,
            isPasswordVisible: false,
        };
    },
    watch: {
        password(newValue) {
            this.$emit('input', newValue); // Cập nhật giá trị v-model
        },
    },
    methods: {
        emitChange() {
            this.$emit('change', this.password); // Phát sự kiện change
        },
        handleTogglePassword() {
            this.isPasswordVisible = !this.isPasswordVisible;
            this.$emit('show-password', this.isPasswordVisible); // Phát sự kiện show-password
        },
        handleClear() {
            this.password = '';
            this.$emit('clear'); // Phát sự kiện clear
            this.emitChange(); // Gọi luôn sự kiện change sau khi xóa
        },
    },
};
</script>

<style scoped>
.icon{
    position: absolute;
    top: 0;
    right: 0;
    height: 100%;
}
.password-input {
    position: relative;
    display: flex;

    height: 36px;
    align-items: center;
}


.toggle-password,
.clear-icon {
    position: absolute;
    right: 10px;
    cursor: pointer;
    color: #303133 !important;
    font-weight: 500;
    font-size: 14px;
}
.clear-icon{
    font-weight: 700;
}

.clear-icon {
    right: 35px !important; /* Vị trí của icon hiển thị mật khẩu */
}
.clear-icon{
    visibility: hidden;
}
.password-input:hover .clear-icon{
    visibility: visible;
}

.clear-icon {
    right: 10px; /* Vị trí của icon xóa */
}

.toggle-password:hover,
.clear-icon:hover {
    color: #333;
}
</style>
<style>
.password-field input{
    width: 100%;
    padding-right: 50px; /* Đảm bảo có không gian cho icon */
    box-sizing: border-box;
}

</style>

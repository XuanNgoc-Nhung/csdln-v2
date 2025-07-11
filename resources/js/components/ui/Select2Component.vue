<template xmlns:v-el="http://www.w3.org/1999/xhtml">
    <select v-el:select>
        <option v-for="item in items" :value="item.value">{{item.text}}</option>
    </select>
</template>

<script>
    export default {

        props: {
            value: "",
            items: [],
        },

        data: function () {
            return {};
        },

        watch: {
            items: function () {
                let select = $(this.$el.select);
                select.selectpicker("refresh");
            },
            value: function () {
                let select = $(this.$el.select);
                select.selectpicker("val", this.value);
            }
        },

        ready: function () {
            let select = $(this.$el.select);
            select.selectpicker();
            select.selectpicker("val", this.value);
            let self = this;
            select.on("changed.bs.select", function () {
                self.value = select.selectpicker("val");
            });
        }
    }
</script>

<style scoped>

</style>
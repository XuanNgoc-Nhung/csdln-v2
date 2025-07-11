require('./bootstrap');
window.Vue = require('vue');
Vue.component('lich-su-day-du-lieu-len-ioc', require('./components/quantrihethong/lichSuDayDuLieuIoc.vue').default);
new Vue({
    el: '#app'
});

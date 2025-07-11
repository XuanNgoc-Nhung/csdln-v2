require('./bootstrap');
window.Vue = require('vue');
Vue.component('lich-su-day-du-lieu-len-bo', require('./components/quantrihethong/LichSuDayDuLieuLenBo').default);
new Vue({
    el: '#app'
});

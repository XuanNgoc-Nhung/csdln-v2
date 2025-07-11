require('./bootstrap');
window.Vue = require('vue');
Vue.component('lich-su-day-du-lieu', require('./components/dulieudacthu/LichSuDayDuLieu').default);
new Vue({
    el: '#app'
});

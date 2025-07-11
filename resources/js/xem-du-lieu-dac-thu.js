require('./bootstrap');
window.Vue = require('vue');
Vue.component('xem-du-lieu-dac-thu', require('./components/dulieudacthu/XemDuLieuDacThu.vue').default);
new Vue({
    el: '#app'
});

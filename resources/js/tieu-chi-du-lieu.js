require('./bootstrap');
window.Vue = require('vue');
Vue.component('tieu-chi-du-lieu', require('./components/dulieudacthu/TieuChiDuLieu').default);
new Vue({
    el: '#app'
});

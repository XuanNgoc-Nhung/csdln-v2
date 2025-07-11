require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-day-du-lieu', require('./components/dulieudacthu/BaoCaoDayDuLieu').default);
new Vue({
    el: '#app'
});

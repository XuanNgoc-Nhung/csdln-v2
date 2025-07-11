require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-du-lieu-dac-thu', require('./components/baocao/BaoCaoDuLieuDacThu').default);
new Vue({
    el: '#app'
});

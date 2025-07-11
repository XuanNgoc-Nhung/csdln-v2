require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-cho-so', require('./components/baocao/BaoCaoChoSo').default);
new Vue({
    el: '#app'
});

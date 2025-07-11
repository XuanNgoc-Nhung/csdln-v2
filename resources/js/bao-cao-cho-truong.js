require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-cho-truong', require('./components/baocao/BaoCaoChoTruong').default);
new Vue({
    el: '#app'
});

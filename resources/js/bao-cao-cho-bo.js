require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-cho-bo', require('./components/baocao/BaoCaoChoBo').default);
new Vue({
    el: '#app'
});

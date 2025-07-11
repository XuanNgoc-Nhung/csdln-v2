require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-emis', require('./components/baocao/BaoCaoEMIS').default);
new Vue({
    el: '#app'
});

require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-dong-emis', require('./components/baocao/baoCaoDong/index').default);
new Vue({
    el: '#app'
});

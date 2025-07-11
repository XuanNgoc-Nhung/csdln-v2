require('./bootstrap');
window.Vue = require('vue');
Vue.component('bao-cao-eqms', require('./components/baocao/BaoCaoEQMS').default);
new Vue({
    el: '#app'
});

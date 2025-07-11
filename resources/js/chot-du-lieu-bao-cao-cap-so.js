require('./bootstrap');
window.Vue = require('vue');
Vue.component('chot-du-lieu-bao-cao-cap-so', require('./components/baocao/chotDuLieuBaoCao/capSo').default);
new Vue({
    el: '#app'
});

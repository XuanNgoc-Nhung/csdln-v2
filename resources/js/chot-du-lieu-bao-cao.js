require('./bootstrap');
window.Vue = require('vue');
Vue.component('chot-du-lieu-bao-cao', require('./components/baocao/chotDuLieuBaoCao/index').default);
new Vue({
    el: '#app'
});

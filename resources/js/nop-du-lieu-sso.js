require('./bootstrap');
window.Vue = require('vue');
// Vue.component('nop-du-lieu-sso', require('./components/hethong/NopDuLieuSSO/index.vue').default);
Vue.component('nop-du-lieu-sso', require('./components/hethong/NopDuLieuSSO.vue').default);
new Vue({
    el: '#app'
});

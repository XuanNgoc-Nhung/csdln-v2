require('./bootstrap');
window.Vue = require('vue');
Vue.component('import-file-du-lieu-moet', require('./components/import/importDuLieuMoet.vue').default);
new Vue({
    el: '#app'
});

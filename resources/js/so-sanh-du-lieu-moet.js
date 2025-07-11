require('./bootstrap');
window.Vue = require('vue');
Vue.component('so-sanh-du-lieu-moet', require('./components/hethong/SoSanhDuLieuMoet').default);
new Vue({
    el: '#app'
});

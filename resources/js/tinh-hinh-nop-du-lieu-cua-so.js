require('./bootstrap');
window.Vue = require('vue');
Vue.component('tinh-hinh-nop-du-lieu-cua-so', require('./components/baocao/SoNopDuLieu').default);
new Vue({
    el: '#app'
});

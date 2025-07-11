require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-chi-so-danh-gia-phat-trien', require('./components/danhmuc/ChiSoDanhGiaPhatTrien').default);
new Vue({
    el: '#app'
});

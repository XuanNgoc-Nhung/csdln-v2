require('./bootstrap');
window.Vue = require('vue');
Vue.component('dm-linh-vuc-danh-gia-phat-trien', require('./components/danhmuc/LinhVucDanhGiaPhatTrien').default);
new Vue({
    el: '#app'
});

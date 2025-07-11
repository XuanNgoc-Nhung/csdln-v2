require('./bootstrap');
window.Vue = require('vue');
Vue.component('tong-hop-tuyen-sinh', require('./components/hethong/tongHopTuyenSinh').default);
new Vue({
    el: '#app'
});


